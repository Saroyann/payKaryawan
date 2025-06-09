<?php
require_once __DIR__ . '/../config/Config.php';

class LaporanRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = Config::connect();
    }

    public function getAllByKaryawan($id_karyawan)
    {
        $stmt = $this->conn->prepare("SELECT * FROM laporan_pekerjaan WHERE id_karyawan = ? ORDER BY tanggal DESC, id DESC");
        $stmt->bind_param("s", $id_karyawan);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        return $data;
    }

    public function add($id_karyawan, $tanggal, $isi_laporan)
    {
        $stmt = $this->conn->prepare("INSERT INTO laporan_pekerjaan (id_karyawan, tanggal, isi_laporan) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $id_karyawan, $tanggal, $isi_laporan);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update($id, $isi_laporan)
    {
        $stmt = $this->conn->prepare("UPDATE laporan_pekerjaan SET isi_laporan = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $isi_laporan, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM laporan_pekerjaan WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}