<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/AbsensiModel.php';

class VerifikasiController {
    private $model;

    public function __construct() {
        $this->model = new AbsensiModel();
    }

    public function verifikasi() {
        // Hanya admin yang boleh verifikasi
        if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /payKaryawan/public/');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $aksi = $_POST['aksi'] ?? null;

        if ($id && in_array($aksi, ['diterima', 'ditolak'])) {
            $this->model->updateStatusVerifikasi($id, $aksi);
        }

        header('Location: http://localhost/payKaryawan/public/absensi');
        exit;
    }
}

$controller = new VerifikasiController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->verifikasi();
}