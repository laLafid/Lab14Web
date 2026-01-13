<?php
require_once __DIR__ . '/../../class/db.php';
$db = new Database();
include_once __DIR__ . '/../../class/form.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';

    $errors = [];

    // Basic validation
    if (empty($username)) {
        $errors[] = "Nama pengguna wajib diisi.";
    }
    if (empty($password)) {
        $errors[] = "Password wajib diisi.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password minimal harus 6 karakter.";
    }
    if ($password !== $password_confirmation) {
        $errors[] = "Password tidak cocok.";
    }

    if (empty($errors)) {
        // Check if username or email already exists
        $stmt_check = $db->query("SELECT * FROM users WHERE username = ?", [$username]);
        if ($stmt_check->num_rows > 0) {
            $existing_user = $stmt_check->fetch_assoc();
            if ($existing_user['username'] === $username) {
                $errors[] = "Nama pengguna sudah digunakan.";
            }
        }
    }


    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $insert_result = $db->query("INSERT INTO users (username, password) VALUES (?, ?)", [$username, $hashed_password]);

        if ($insert_result) {
            echo "<script>alert('Pendaftaran berhasil! udah bisa pake login.'); window.location.href = 'login';</script>";
            exit;
        } else {
            $errors[] = "Pendaftaran gagal. Silakan coba lagi.";
        }
    }
}

// Display errors if any
if (!empty($errors)) {
    echo '<div style="color: red; margin-bottom: 10px;">';
    foreach ($errors as $error) {
        echo $error . '<br>';
    }
    echo '</div>';
}

$form = new Form("", "Daftar");
$form->addField("username", "Nama Pengguna", "text", $_POST['username'] ?? '');
$form->addField("password", "Password", "password");
$form->addField("password_confirmation", "Konfirmasi Password", "password");

echo "<h3 style=\"text-align: center;\">Registrasi Pengguna</h3>";
$form->displayForm();
?>