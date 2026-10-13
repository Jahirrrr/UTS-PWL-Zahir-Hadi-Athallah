<?php

class ActionController extends Controller
{
    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $model = new Action($this->db);
        $actions = $model->getActions($search);
        $this->render('actions/index', ['title' => 'Manajemen Jenis Aksi', 'actions' => $actions, 'search' => $search]);
    }

    public function create()
    {
        $this->form();
    }

    public function edit()
    {
        $id = $_GET['id'] ?? '';
        $model = new Action($this->db);
        $item = $model->getActionById($id);
        if (!$item) {
            $this->notFound();
            return;
        }
        $this->form($item);
    }

    private function form($item = null)
    {
        $model = new Action($this->db);
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
                    $model->createAction($data);
                } else {
                    $model->updateAction($id, $data);
                }
                $_SESSION['message'] = 'Jenis Aksi berhasil disimpan.';
                redirect('actions');
            }
        }

        $title = $id === '' ? 'Tambah Jenis Aksi' : 'Ubah Jenis Aksi';
        $this->render('actions/form', ['title' => $title, 'data' => $data, 'id' => $id, 'error' => $error]);
    }

    public function delete()
    {
        $id = $_GET['id'] ?? '';
        $model = new Action($this->db);
        if (!$model->getActionById($id)) {
            $this->notFound();
            return;
        }
        $model->deleteAction($id);
        $_SESSION['message'] = 'Jenis aksi berhasil diarsipkan.';
        redirect('actions');
    }
}
