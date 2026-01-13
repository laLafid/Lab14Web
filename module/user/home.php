<?php
require_once __DIR__ . '/../../class/db.php'; // path ke class/db.php
$db = new Database();

$is_logged_in = isset($_SESSION['is_login']);
$is_admin = ($is_logged_in && $_SESSION['role'] === 'admin');

$q = ''; // untukny pencarian
if (isset($_GET['submit']) && !empty($_GET['q'])) {
    $q = $db->conn->real_escape_string($_GET['q']); // Escape the search query
    $sql_where = "nama LIKE '{$q}%'";
} else {
    $sql_where = null;
}

$b = $db->getAll('data_barang', $sql_where);
$barang = $b['data'];
$num_page = $b['num_page'];
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <h1 class="h3">Data Barang</h1>
        <?php if ($is_admin): ?>
            <a href="<?= BASE_URL ?>artikel/tambah" class="btn btn-primary">
                + Tambah Barang
            </a>
        <?php endif; ?>
    </div>

    <form action="" method="GET" class="mb-4">
        <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari nama barang...">
        <button type="submit" name="submit" class="btn btn-primary">Cari</button>
        <?php if (!empty($q)): // Show reset button only if there's a search query ?>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>
    <?php
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $db->renderPagination($num_page, $page, $q);
    ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="100">Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <?php if ($is_logged_in): ?>
                        <th>Harga Jual</th>
                        <?php if ($is_admin): ?>
                            <th>Harga Beli</th>
                        <?php endif; ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($barang && $barang->num_rows > 0): ?>
                    <?php while ($b = $barang->fetch_assoc()): ?>
                        <tr>
                            <td data-label="Gambar" class="text-center">
                                <?php if ($b['gambar'] && file_exists(ROOT . 'gambar/' . basename($b['gambar']))): ?>
                                    <img src="<?= BASE_URL ?>gambar/<?= basename($b['gambar']) ?>" width="80" class="img-thumbnail">
                                <?php else: ?>
                                    <img src="<?= BASE_URL ?>gambar/no-image.png" width="80" class="img-thumbnail">
                                <?php endif; ?>
                            </td>
                            <td data-label="Nama Barang"><?= htmlspecialchars($b['nama']) ?></td>
                            <td data-label="Kategori"><?= htmlspecialchars($b['kategori']) ?></td>
                            <?php if ($is_logged_in): ?>
                                <td data-label="Harga Jual">Rp <?= number_format($b['harga_jual']) ?></td>
                                <?php if ($is_admin): ?>
                                    <td data-label="Harga Beli">Rp <?= number_format($b['harga_beli']) ?></td>
                                <?php endif; ?>
                                <td data-label="Aksi">
                                    <?php if ($is_admin): ?>
                                        <a href="<?= BASE_URL ?>artikel/ubah?id=<?= $b['id_barang'] ?>"
                                            class="btn btn-sm btn-warning">Ubah</a>
                                        <a href="<?= BASE_URL ?>artikel/hapus?id=<?= $b['id_barang'] ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus <?= htmlspecialchars($b['nama']) ?>?')">
                                            Hapus
                                        </a>
                                    <?php else: // Non-admin logged-in user ?>
                                        <button type="button" class="btn btn-sm btn-info detail-btn"
                                            data-id="<?= $b['id_barang'] ?>"
                                            <?php if ($b['gambar'] && file_exists(ROOT . 'gambar/' . basename($b['gambar']))): ?>
                                                data-gambar="<?= BASE_URL ?>gambar/<?= basename($b['gambar']) ?>"
                                            <?php else: ?>
                                                data-gambar="<?= BASE_URL ?>gambar/no-image.png"
                                            <?php endif; ?>
                                            data-stok="<?= $b['stok'] ?>"
                                            data-nama="<?= htmlspecialchars($b['nama']) ?>"
                                            >
                                            Detail
                                        </button>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <?php
                        $colspan_value = 3; 
                        if ($is_logged_in) {
                            $colspan_value = 6;
                            if ($is_admin) {
                                $colspan_value = 7;
                            }
                        }
                        ?>
                        <td colspan="<?= $colspan_value ?>" class="text-center py-5 text-muted">
                            <?php if (!empty($q)): ?>
                                Tidak ditemukan barang dengan kata kunci "<?= htmlspecialchars($q) ?>".
                                <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">Tampilkan semua barang</a>
                            <?php else: ?>
                                Belum ada data barang. <a href="<?= BASE_URL ?>artikel/tambah">Tambah sekarang</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $db->renderPagination($num_page, $page, $q);
        ?>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel"><span id="modalProductName"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalProductImage" src="" alt="Product Image" class="img-fluid mb-3" style="max-height: 200px;">
        <p><strong>Stok:</strong> <span id="modalProductStock"></span></p>
        <button type="button" class="btn btn-success mt-3">Beli</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var detailModalElement = document.getElementById('detailModal');
        var detailModal = new bootstrap.Modal(detailModalElement);
        var detailButtons = document.querySelectorAll('.detail-btn');

        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                var productId = this.dataset.id;
                var productNama = this.dataset.nama;
                var productImage = this.dataset.gambar;
                var productStok = this.dataset.stok;

                document.getElementById('modalProductName').textContent = productNama;
                document.getElementById('modalProductImage').src = productImage;
                document.getElementById('modalProductStock').textContent = productStok;

                detailModal.show();
            });
        });
    });
</script>