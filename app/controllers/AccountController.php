<?php

class AccountController extends Controller
{
    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $model = new Account($this->db);
        $accounts = $model->getAccounts($search);
        $this->render('accounts/index', ['title' => 'Manajemen Akun', 'accounts' => $accounts, 'search' => $search]);
    }

    public function create()
    {
        $this->form();
    }

    public function edit()
    {
        $id = $_GET['id'] ?? '';
        $model = new Account($this->db);
        $account = $model->getAccountById($id);
        if (!$account) {
            $this->notFound();
            return;
        }
        $this->form($account);
    }

    private function form($account = null)
    {
        $model = new Account($this->db);
        $typeModel = new AccountType($this->db);
        $id = $account['id'] ?? '';
        $data = $account ?? [
            'name' => '', 'email' => '', 'account_type_id' => '',
            'status' => 'Aktif', 'identification_type' => 'NIM', 'identification_number' => ''
        ];
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'account_type_id' => $_POST['account_type_id'] ?? '',
                'status' => $_POST['status'] ?? '',
                'identification_type' => $_POST['identification_type'] ?? '',
                'identification_number' => trim($_POST['identification_number'] ?? '')
            ];

            if ($data['name'] === '' || strlen($data['name']) > 128) {
                $error = 'Nama wajib diisi, maksimal 128 byte.';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['email']) > 128) {
                $error = 'Isi email yang valid, maksimal 128 byte.';
            } elseif ($model->emailExists($data['email'], $id)) {
                $error = 'Email sudah digunakan, termasuk oleh akun arsip.';
            } elseif ($id === '' && $data['password'] === '') {
                $error = 'Password wajib diisi saat menambah akun.';
            } elseif ($data['password'] !== '' && (strlen($data['password']) < 6 || strlen($data['password']) > 72)) {
                $error = 'Password harus 6–72 byte.';
            } elseif (!$typeModel->getAccountTypeById($data['account_type_id'])) {
                $error = 'Pilih tipe akun yang tersedia.';
            } elseif ($model->typeIsUsed($data['account_type_id'], $id)) {
                $error = 'Tipe sudah dipakai akun lain. Tambahkan tipe baru.';
            } elseif (!in_array($data['status'], ['Aktif', 'Nonaktif'])) {
                $error = 'Status harus Aktif atau Nonaktif.';
            } elseif (!in_array($data['identification_type'], ['NIM', 'NIP'])) {
                $error = 'Jenis identitas harus NIM atau NIP.';
            } elseif (!ctype_digit($data['identification_number']) || strlen($data['identification_number']) > 128) {
                $error = 'Nomor identitas wajib berupa angka, maksimal 128 digit.';
            } elseif ($id === $_SESSION['user']['id'] && $data['status'] !== 'Aktif') {
                $error = 'Akun yang sedang digunakan harus tetap Aktif.';
            }

            if ($error === '') {
                try {
                    if ($id === '') {
                        $model->createAccount($data);
                    } else {
                        $model->updateAccount($id, $data);
                    }
                    $_SESSION['message'] = 'Akun berhasil disimpan.';
                    redirect('accounts');
                } catch (PDOException $exception) {
                    error_log($exception->getMessage());
                    $error = 'Data gagal disimpan. Periksa email dan tipe akun.';
                }
            }
        }

        $types = $typeModel->getAvailableTypes($id);
        $title = $id === '' ? 'Tambah Akun' : 'Ubah Akun';
        $this->render('accounts/form', ['title' => $title, 'data' => $data, 'id' => $id, 'types' => $types, 'error' => $error]);
    }

    public function delete()
    {
        $id = $_GET['id'] ?? '';
        $model = new Account($this->db);
        if (!$model->getAccountById($id)) {
            $this->notFound();
            return;
        }
        if ($id === $_SESSION['user']['id']) {
            $_SESSION['message'] = 'Akun yang sedang digunakan tidak bisa dihapus.';
        } else {
            $model->deleteAccount($id);
            $_SESSION['message'] = 'Akun berhasil diarsipkan.';
        }
        redirect('accounts');
    }
}
