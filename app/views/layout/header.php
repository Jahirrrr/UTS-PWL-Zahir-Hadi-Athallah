<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($title) ?> | Manajemen Akun</title>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<?php if (!empty($_SESSION['user'])): ?>
    <?php $page = $_GET['page'] ?? 'accounts'; ?>
    <nav class="navbar navbar-expand-lg bg-primary shadow-sm py-3" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?page=accounts"><span class="badge bg-white text-primary rounded-3 me-2">M</span>Manajemen Akun</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainMenu">
                <div class="navbar-nav me-auto mb-3 mb-lg-0 gap-1">
                    <a class="nav-link rounded-3 px-3 <?= $page === 'accounts' ? 'active bg-white text-primary' : 'text-white' ?>" href="index.php?page=accounts">Akun</a>
                    <a class="nav-link rounded-3 px-3 <?= $page === 'types' ? 'active bg-white text-primary' : 'text-white' ?>" href="index.php?page=types">Tipe Akun</a>
                    <a class="nav-link rounded-3 px-3 <?= $page === 'actions' ? 'active bg-white text-primary' : 'text-white' ?>" href="index.php?page=actions">Jenis Aksi</a>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="small text-white">
                        <strong><?= h($_SESSION['user']['name']) ?></strong>
                        <span class="d-block text-break"><?= h($_SESSION['user']['email']) ?></span>
                    </div>
                    <form method="post" action="index.php?page=auth&amp;action=logout">
                        <button class="btn btn-light btn-sm text-primary rounded-pill px-3" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
<?php endif; ?>
<main class="container py-4 flex-grow-1">
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info border-0 rounded-3" role="status"><?= h($_SESSION['message']) ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>
