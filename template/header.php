<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/flatly/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="header mb-4">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(45deg,#5d87b8,#4a6fa5);">
            <div class="container-fluid">
                <?php if (isset($_SESSION['is_login'])): ?>
                    <a class="navbar-brand" href="<?= BASE_URL ?>user/home">Inventori</a>
                <?php else: ?>
                    <a class="navbar-brand" href="<?= BASE_URL ?>home/index">Inventori</a>
                <?php endif; ?>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>user/about">Tentang</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>user/kontak">Kontak</a></li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <?php if (isset($_SESSION['is_login'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i>
                                    <?= $_SESSION['nama'] ?? $_SESSION['username'] ?? '' ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>user/profile">Profil</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>user/logout">Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>user/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>user/register">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-5 flex-grow-1">