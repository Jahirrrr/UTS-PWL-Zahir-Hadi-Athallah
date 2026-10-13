<?php

class AccountTypeController extends Controller
{
    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $model = new AccountType($this->db);
        $types = $model->getAccountType($search);
        $this->render('types/index', ['title' => 'Manajemen Tipe Akun', 'types' => $types, 'search' => $search]);
    }

    public function create()
    {
        $this->form();
    }

    public function edit()
    {
        $id = $_GET['id'] ?? '';
        $model = new AccountType($this->db);
        $item = $model->getAccountTypeById($id);
        if (!$item) {
            $this->notFound();
            return;
        }
        $this->form($item);
    }

    private function form($item = null)
    {
        $model = new AccountType($this->db);
        $id = $item['id'] ?? '';
        $data = $item ?? ['name' => '', 'description' => ''];
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? '')
            ];
            if ($data['name'] === '' || strlen($data['name']) > 128) {
                $error = 'Nama wajib diisi, maksimal 128 byte.';
            } elseif (strlen($data['description']) > 5000) {
                $error = 'Deskripsi maksimal 5000 byte.';
            }

            if ($error === '') {
                if ($id === '') {
                    $model->createAccountType($data);
                } else {
                    $model->updateAccountType($id, $data);
                }
                $_SESSION['message'] = 'Tipe Akun berhasil disimpan.';
                redirect('types');
            }
        }

        $title = $id === '' ? 'Tambah Tipe Akun' : 'Ubah Tipe Akun';
        $this->render('types/form', ['title' => $title, 'data' => $data, 'id' => $id, 'error' => $error]);
    }

    public function delete()
    {
        $id = $_GET['id'] ?? '';
        $model = new AccountType($this->db);
        if (!$model->getAccountTypeById($id)) {
            $this->notFound();
            return;
        }
        if ($model->isUsed($id)) {
            $_SESSION['message'] = 'Tipe masih dipakai akun yang belum diarsipkan.';
        } else {
            $model->deleteAccountType($id);
            $_SESSION['message'] = 'Tipe akun berhasil diarsipkan.';
        }
        redirect('types');
    }
}
