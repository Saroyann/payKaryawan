<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../models/LaporanModel.php';

class LaporanController {
    private $model;

    public function __construct() {
        $this->model = new LaporanModel();
    }

    public function index() {
        $id_karyawan = $_SESSION['id_karyawan'] ?? null;
        $daftar_laporan = $this->model->getAllByKaryawan($id_karyawan);
        include __DIR__ . '/../views/pages/karyawan/LaporanView.php';
    }

    public function tambah() {
        $id_karyawan = $_SESSION['id_karyawan'] ?? null;
        $isi_laporan = $_POST['isi_laporan'] ?? '';
        $tanggal = date('Y-m-d');
        if ($id_karyawan && $isi_laporan) {
            $this->model->add($id_karyawan, $tanggal, $isi_laporan);
        }
        header('Location: /payKaryawan/public/laporan');
        exit;
    }

    public function edit() {
        $id = $_POST['id_laporan'] ?? null;
        $isi_laporan = $_POST['isi_laporan'] ?? '';
        if ($id && $isi_laporan) {
            $this->model->update($id, $isi_laporan);
        }
        header('Location: /payKaryawan/public/laporan');
        exit;
    }

    public function hapus() {
        $id = $_POST['id_laporan'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: /payKaryawan/public/laporan');
        exit;
    }
}

// Routing sederhana
$controller = new LaporanController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambah_laporan'])) $controller->tambah();
    elseif (isset($_POST['edit_laporan'])) $controller->edit();
    elseif (isset($_POST['hapus_laporan'])) $controller->hapus();
} else {
    $controller->index();
}

if (isset($_FILES['file_laporan']) && $_FILES['file_laporan']['error'] === UPLOAD_ERR_OK) {
    $targetDir = __DIR__ . '/../../uploads/cuti/';
    $fileName = basename($_FILES['file_laporan']['name']);
    $targetFile = $targetDir . $fileName;
    move_uploaded_file($_FILES['file_laporan']['tmp_name'], $targetFile);
}