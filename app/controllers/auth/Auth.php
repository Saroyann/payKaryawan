<?php
session_start();
require_once __DIR__ . '/../../models/KaryawanModel.php';
require_once __DIR__ . '/../../config/Config.php';

$conn = Config::connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Cek di tabel admin
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed);
    if ($stmt->fetch() && password_verify($password, $hashed)) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin';
        $_SESSION['password'] = $hashed; // simpan hash password admin
        $stmt->close();
        header('Location: /payKaryawan/public/dashboard');
        exit;
    }
    $stmt->close();

    $stmt = $conn->prepare("SELECT id_karyawan, nama, jabatan, password FROM karyawan WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id_karyawan, $nama, $jabatan, $hashed);
    if ($stmt->fetch() && password_verify($password, $hashed)) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'karyawan';
        $_SESSION['id_karyawan'] = $id_karyawan;
        $_SESSION['nama'] = $nama;
        $_SESSION['jabatan'] = $jabatan;
        $_SESSION['password'] = $hashed; // simpan hash password karyawan
        $stmt->close();
        header('Location: /payKaryawan/public/dashboard');
        exit;
    }
    $stmt->close();

    // login gagal
    $_SESSION['login_error'] = 'Username atau password salah!';
    header('Location: /payKaryawan/public/');
    exit;
}