<?php

session_start();
date_default_timezone_set('Asia/Jakarta');
require __DIR__ . '/app/helpers.php';
require __DIR__ . '/app/Controller.php';

require __DIR__ . '/app/models/Account.php';
require __DIR__ . '/app/models/AccountType.php';
require __DIR__ . '/app/models/Action.php';
require __DIR__ . '/app/controllers/AuthController.php';
require __DIR__ . '/app/controllers/AccountController.php';
require __DIR__ . '/app/controllers/AccountTypeController.php';
require __DIR__ . '/app/controllers/ActionController.php';

$page = $_GET['page'] ?? 'accounts';
$action = $_GET['action'] ?? ($page === 'auth' ? 'login' : 'index');
$allowedActions = ['index', 'create', 'edit', 'delete'];
if ($page === 'auth') {
    $allowedActions = ['login', 'logout'];
}

if (!in_array($page, ['auth', 'accounts', 'types', 'actions'], true) || !in_array($action, $allowedActions, true)) {
    http_response_code(404);
    exit('Halaman tidak ditemukan.');
}

if (empty($_SESSION['user']) && !($page === 'auth' && $action === 'login')) {
    redirect('auth', 'login');
}

if (($action === 'delete' || $action === 'logout') && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Aksi ini harus dikirim melalui form POST.');
}

try {
    require __DIR__ . '/config/database.php';

    if (!empty($_SESSION['user'])) {
        $model = new Account($db);
        $account = $model->getAccountById($_SESSION['user']['id']);
        if (!$account || $account['status'] !== 'Aktif') {
            unset($_SESSION['user']);
            $_SESSION['message'] = 'Akun tidak aktif. Silakan login kembali.';
            redirect('auth', 'login');
        }
        $_SESSION['user'] = ['id' => $account['id'], 'name' => $account['name'], 'email' => $account['email']];
    }

    switch ($page) {
        case 'auth':
            $controller = new AuthController($db);
            break;
        case 'accounts':
            $controller = new AccountController($db);
            break;
        case 'types':
            $controller = new AccountTypeController($db);
            break;
        case 'actions':
            $controller = new ActionController($db);
            break;
    }
    $controller->$action();
} catch (PDOException $error) {
    error_log($error->getMessage());
    http_response_code(500);
    $title = 'Database belum siap';
    $message = 'Pastikan MySQL aktif, coba cek database kamu, lalu cek pengaturan di config/database.php. Jika database sudah siap, periksa log PHP untuk detail kesalahan.';
    require __DIR__ . '/app/views/layout/header.php';
    require __DIR__ . '/app/views/error.php';
    require __DIR__ . '/app/views/layout/footer.php';
}
