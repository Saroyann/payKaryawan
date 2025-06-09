<?php
require_once __DIR__ . '/../models/KaryawanModel.php';
require_once __DIR__ . '/../config/Config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $id_karyawan = $_POST['id_karyawan'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $model = new KaryawanModel();
    $model->insert($id_karyawan, $nama, $jabatan, $username, $password);

    $conn = Config::connect();
    $stmt = $conn->prepare("INSERT INTO rekap_gaji (id_karyawan, nama, jabatan, gaji) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("sss", $id_karyawan, $nama, $jabatan);
    $stmt->execute();

    header('Location: /payKaryawan/public/karyawan');
    exit;
}