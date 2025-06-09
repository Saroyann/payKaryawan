<?php
require_once __DIR__ . '/../config/Config.php';

class RekapGajiRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = Config::connect();
    }

    public function countAll()
    {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM rekap_gaji");
        $row = $result ? $result->fetch_assoc() : null;
        return $row ? (int)$row['total'] : 0;
    }

    public function getPage($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM rekap_gaji ORDER BY id ASC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function saveOrUpdateGaji($id_karyawan, $gaji, $nama, $jabatan)
    {
        // Cek apakah data sudah ada
        $stmt = $this->conn->prepare("SELECT id FROM rekap_gaji WHERE id_karyawan = ?");
        $stmt->bind_param("s", $id_karyawan);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result && $result->num_rows > 0;
        $stmt->close();

        if ($exists) {
            // Update (tanpa koma sebelum WHERE)
            $stmt = $this->conn->prepare("UPDATE rekap_gaji SET gaji = ?, nama = ?, jabatan = ? WHERE id_karyawan = ?");
            $stmt->bind_param("isss", $gaji, $nama, $jabatan, $id_karyawan);
        } else {
            // Insert (tanpa koma setelah jabatan, dan jumlah kolom & value sama)
            $stmt = $this->conn->prepare("INSERT INTO rekap_gaji (id_karyawan, gaji, nama, jabatan) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siss", $id_karyawan, $gaji, $nama, $jabatan);
        }
        $stmt->execute();
        $stmt->close();
    }
}