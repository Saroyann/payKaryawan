<?php
require_once __DIR__ . '/../models/KaryawanModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_karyawan_lama = $_POST['id_karyawan_lama'];
    $id_karyawan_baru = $_POST['id_karyawan'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $username = $_POST['username'];

    $model = new KaryawanModel();
    $model->update($id_karyawan_lama, $id_karyawan_baru, $nama, $jabatan, $username);

    header('Location: /payKaryawan/public/karyawan');
    exit;
}