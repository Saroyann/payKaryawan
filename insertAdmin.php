<?php
$username = 'admin';
$password_plain = 'adminganteng';

$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);


$conn = new mysqli('localhost', 'root', '', 'dataKaryawan');

$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password_hashed);
$stmt->execute();

echo "Admin berhasil ditambahkan dengan password ter-hash!";
?>