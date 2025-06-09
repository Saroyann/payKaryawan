<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../models/KaryawanModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_karyawan = $_POST['id_karyawan'] ?? '';

    $model = new KaryawanModel();
    $model->delete($id_karyawan);

    header('Location: /payKaryawan/public/karyawan');
    exit;
}