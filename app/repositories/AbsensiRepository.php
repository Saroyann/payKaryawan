<?php
require_once __DIR__ . '/../config/Config.php';

class AbsensiRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = Config::connect();

        if ($this->conn->connect_error) {
            error_log("Database connection failed: " . $this->conn->connect_error);
            throw new Exception("Database connection failed");
        }
    }

    public function getAll()
    {
        $sql = "SELECT * FROM absensi ORDER BY tanggal DESC, jam_datang DESC";
        $result = $this->conn->query($sql);

        if ($result === false) {
            error_log("Query error in getAll: " . $this->conn->error);
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM absensi";
        $result = $this->conn->query($sql);

        if ($result === false) {
            error_log("Query error in countAll: " . $this->conn->error);
            return 0;
        }

        $row = $result->fetch_assoc();
        return $row ? (int)$row['total'] : 0;
    }

    public function getPage($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM absensi ORDER BY tanggal DESC, jam_datang DESC LIMIT ? OFFSET ?");

        if (!$stmt) {
            error_log("Prepare error in getPage: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();

        return $data;
    }

    public function absenDatang($data)
    {
        $sql = "INSERT INTO absensi (id_karyawan, nama, jabatan, foto, lokasi, jam_datang, status, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("Prepare error in absenDatang: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param(
            "ssssssss",
            $data['id_karyawan'],
            $data['nama'],
            $data['jabatan'],
            $data['foto'],
            $data['lokasi'],
            $data['jam_datang'],
            $data['status'],
            $data['tanggal']
        );

        $result = $stmt->execute();

        if (!$result) {
            error_log("Execute error in absenDatang: " . $stmt->error);
            error_log("SQL: " . $sql);
            error_log("Data: " . print_r($data, true));
        } else {
            error_log("Absensi berhasil disimpan dengan ID: " . $this->conn->insert_id);
        }

        $stmt->close();
        return $result;
    }

    public function absenPulang($id_absensi, $jam_pulang)
    {
        $sql = "UPDATE absensi SET jam_pulang = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("Prepare error in absenPulang: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("si", $jam_pulang, $id_absensi);
        $result = $stmt->execute();

        if (!$result) {
            error_log("Execute error in absenPulang: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    public function getTodayAbsensi($id_karyawan, $tanggal)
    {
        $sql = "SELECT * FROM absensi WHERE id_karyawan = ? AND tanggal = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("Prepare error in getTodayAbsensi: " . $this->conn->error);
            return null;
        }

        $stmt->bind_param("ss", $id_karyawan, $tanggal);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_assoc() : null;
        $stmt->close();

        return $data;
    }

    public function updateStatusVerifikasi($id, $status)
    {
        $stmt = $this->conn->prepare("UPDATE absensi SET status_verifikasi = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function getTotalLamaJamKerja($id_karyawan, $tanggal_awal, $tanggal_akhir)
    {
        $sql = "SELECT 
                    SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(jam_pulang, jam_datang)))) as total_jam 
                FROM absensi 
                WHERE id_karyawan = ? 
                  AND tanggal BETWEEN ? AND ?
                  AND jam_datang IS NOT NULL 
                  AND jam_pulang IS NOT NULL";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare error in getTotalLamaJamKerja: " . $this->conn->error);
            return "00:00:00";
        }
        $stmt->bind_param("sss", $id_karyawan, $tanggal_awal, $tanggal_akhir);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;
        $stmt->close();
        return $row && $row['total_jam'] ? $row['total_jam'] : "00:00:00";
    }

}
