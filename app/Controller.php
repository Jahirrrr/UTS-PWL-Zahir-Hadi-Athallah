<?php

class Controller
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    protected function render($view, $viewData = [])
    {
        extract($viewData);
        require __DIR__ . '/views/layout/header.php';
        require __DIR__ . '/views/' . $view . '.php';
        require __DIR__ . '/views/layout/footer.php';
    }

    protected function notFound()
    {
        http_response_code(404);
        $this->render('error', ['title' => 'Data tidak ditemukan', 'message' => 'Data tidak tersedia atau sudah dihapus.']);
    }
}
