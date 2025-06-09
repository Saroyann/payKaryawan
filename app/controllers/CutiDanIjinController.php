<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../models/CutiModel.php';

class CutiController {
    private $model;
    public function __construct() {
        $this->model = new CutiModel();
    }

    public function ajukan() {
        $id_karyawan = $_SESSION['id_karyawan'] ?? null;
        $nama = $_SESSION['nama'] ?? null;
        $jabatan = $_SESSION['jabatan'] ?? null;
        $jenis = $_POST['jenis'] ?? '';
        $tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
        $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
        $lampiran = null;

        // Upload lampiran jika ada
        if (!empty($_FILES['lampiran']['name'])) {
            $ext = strtolower(pathinfo($_FILES['lampiran']['name'], PATHINFO_EXTENSION));
            $allowed = ['pdf'];
            if (in_array($ext, $allowed) && $_FILES['lampiran']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/cuti/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = uniqid('cuti_') . '.' . $ext;
                $filePath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['lampiran']['tmp_name'], $filePath)) {
                    $lampiran = '/payKaryawan/public/uploads/cuti/' . $fileName;
                }
            }
        }

        $data = [
            'id_karyawan' => $id_karyawan,
            'nama' => $nama,
            'jabatan' => $jabatan,
            'jenis' => $jenis,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'lampiran' => $lampiran
        ];

        if ($this->model->ajukanCuti($data)) {
            $_SESSION['success_cuti'] = "Pengajuan berhasil dikirim!";
        } else {
            $_SESSION['error_cuti'] = "Pengajuan gagal. Cek data Anda.";
        }
        header('Location: /payKaryawan/public/cutiDanIjin');
        exit;
    }
}

$controller = new CutiController();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajukan_cuti'])) {
    $controller->ajukan();
}

function render($contentFile) {
    $content = $contentFile;
    include __DIR__ . '/../views/MainPages.php';
}

render(__DIR__ . '/../views/pages/CutiDanIjin.php');