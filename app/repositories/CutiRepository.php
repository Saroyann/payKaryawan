<?php
require_once __DIR__ . '/../config/Config.php';

class CutiRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = Config::connect();
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM cuti ORDER BY tanggal_mulai DESC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function insert($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO cuti (id_karyawan, nama, jabatan, jenis, tanggal_mulai, tanggal_selesai, lampiran) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sssssss",
            $data['id_karyawan'],
            $data['nama'],
            $data['jabatan'],
            $data['jenis'],
            $data['tanggal_mulai'],
            $data['tanggal_selesai'],
            $data['lampiran']
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}