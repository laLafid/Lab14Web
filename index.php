<?php
// Mulai Session (buat login)
session_start();
include "config.php";
include "class/db.php";
include "class/form.php";

$db = new Database();

// ini biarin
$path = $_SERVER['PATH_INFO'] ?? '/';
$path = trim($path, '/');
$segments = explode('/', $path);
if (empty($segments[0])) {
    $mod = 'home';      // landing page
    $page = 'index';
} else {
    $mod = $segments[0];   // auth, artikel, dll
    $page = $segments[1] ?? 'index';  // login, tambah, ubah, index, dll
}

$file = "module/{$mod}/{$page}.php";

$public_pages = ['home', 'user'];
$admin_modules = ['artikel'];

if (in_array($mod, $admin_modules)) {
    if (!isset($_SESSION['is_login']) || $_SESSION['role'] !== 'admin') {
        header('Location: ' . BASE_URL . 'user/login');
        exit();
    }
} elseif (!in_array($mod, $public_pages)) {
    if (!isset($_SESSION['is_login'])) {
        header('Location: ' . BASE_URL . 'user/login');
        exit();
    }
}

include "template/header.php";
if (file_exists($file)) {
    include $file;
} else {
    // Kalau tidak ada, cek apakah home
    if ($mod === 'home' || $path === '') {
        ?>
        <div class="container mt-5 text-center">
            <h1 class="display-5 fw-bold text-primary mb-4">Selamat Datang!</h1>
            <?php if (isset($_SESSION['is_login'])): ?>
                <p class="lead text-muted mb-5">Anda sudah masuk sebagai <strong>
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </strong>.</p>
                <a href="<?= BASE_URL ?>user/home" class="btn btn-primary btn-lg rounded-pill px-5">
                    Masuk ke Dashboard
                </a>
            <?php else: ?>
                <p class="lead text-muted mb-5">Silakan login dulu untuk mengakses lebih dalam.</p>
                <a href="<?= BASE_URL ?>user/login" class="btn btn-primary btn-lg rounded-pill px-5">
                    Masuk ke Dashboard

                </a>
            <?php endif; ?>
        </div>
        <?php
    } else {
        echo '<div class="container mt-5"><div class="alert alert-danger">
              <strong>Modul tidak ditemukan:</strong> module/' . htmlspecialchars($mod) . '/' . htmlspecialchars($page) . '
              </div></div>';
    }
}

include "template/footer.php";
?>