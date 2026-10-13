<?php

class AuthController extends Controller
{
    public function login()
    {
        if (!empty($_SESSION['user'])) {
            redirect('accounts');
        }

        $error = '';
        $email = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $model = new Account($this->db);
            $account = $model->findByEmail($email);

            if ($account && $account['status'] === 'Aktif' && password_verify($password, $account['password'])) {
                session_regenerate_id(true);
                $_SESSION['user'] = ['id' => $account['id'], 'name' => $account['name'], 'email' => $account['email']];
                $_SESSION['message'] = 'Login berhasil.';
                redirect('accounts');
            }
            $error = 'Email atau password salah, atau akun tidak aktif.';
        }

        $this->render('auth/login', ['title' => 'Login', 'error' => $error, 'email' => $email]);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        $_SESSION['message'] = 'Kamu sudah logout.';
        redirect('auth', 'login');
    }
}
