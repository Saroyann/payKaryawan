<?php
require_once __DIR__ . '/../config/Config.php';

class KaryawanRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = Config::connect();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM karyawan";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getById($id_karyawan)
    {
        $stmt = $this->conn->prepare("SELECT * FROM karyawan WHERE id_karyawan = ?");
        $stmt->bind_param("s", $id_karyawan);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    public function getByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM karyawan WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    public function insert($id_karyawan, $nama, $jabatan, $username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO karyawan (id_karyawan, nama, jabatan, username, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $id_karyawan, $nama, $jabatan, $username, $hashedPassword);
        return $stmt->execute();
    }

    public function update($id_lama, $id_baru, $nama, $jabatan, $username)
    {
        $sql = "UPDATE karyawan SET id_karyawan=?, nama=?, jabatan=?, username=? WHERE id_karyawan=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $id_baru, $nama, $jabatan, $username, $id_lama);
        return $stmt->execute();
    }

    public function delete($id_karyawan)
    {
        $stmt = $this->conn->prepare("DELETE FROM karyawan WHERE id_karyawan = ?");
        $stmt->bind_param("s", $id_karyawan);
        return $stmt->execute();
    }
}