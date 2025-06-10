<?php
require_once __DIR__ . '/../config/Config.php';
require_once __DIR__ . '/../models/RekapGajiModel.php';

class RekapGajiController {
    private $conn;

    public function __construct() {
        $this->conn = Config::connect();
    }

    private function getGajiPokok($jabatan) {
        $gaji = [
            'Manajer' => 8000000,
            'Asisten Manajer' => 6500000,
            'Supervisor' => 5000000,
            'Staff' => 3500000,
            'Office Boy/Girl' => 2500000,
        ];
        return $gaji[$jabatan] ?? 0;
    }

    public function getRekapGaji($limit, $offset) {
        // Ambil semua karyawan
        $sqlKaryawan = "SELECT id_karyawan, nama, jabatan FROM karyawan";
        $resultKaryawan = $this->conn->query($sqlKaryawan);
        $karyawanList = [];
        while ($row = $resultKaryawan->fetch_assoc()) {
            $karyawanList[$row['id_karyawan']] = [
                'id_karyawan' => $row['id_karyawan'],
                'nama' => $row['nama'],
                'jabatan' => $row['jabatan'],
                'gaji_pokok' => $this->getGajiPokok($row['jabatan']),
                'total_detik' => 0,
                'gaji' => 0
            ];
        }

        // Ambil total detik kerja dari absensi valid
        $sqlDetik = "SELECT id_karyawan, 
            SUM(TIME_TO_SEC(TIMEDIFF(jam_pulang, jam_datang))) AS total_detik 
            FROM absensi
            WHERE status_verifikasi = 'diterima'
              AND jam_datang IS NOT NULL
              AND jam_pulang IS NOT NULL
            GROUP BY id_karyawan";
        $resultDetik = $this->conn->query($sqlDetik);
        $detikMap = [];
        while ($row = $resultDetik->fetch_assoc()) {
            $detikMap[$row['id_karyawan']] = (int)$row['total_detik'];
        }

        $totalDetikBulan = 22 * 8 * 60 * 60;

        foreach ($karyawanList as $id => &$data) {
            $totalDetik = $detikMap[$id] ?? 0;
            $data['total_detik'] = $totalDetik;
            $data['gaji'] = round($data['gaji_pokok'] * ($totalDetik / $totalDetikBulan));
        }

        $rekapModel = new RekapGajiModel();
        foreach ($karyawanList as $karyawan) {
            $rekapModel->saveOrUpdateGaji(
                $karyawan['id_karyawan'],
                $karyawan['gaji'],
                $karyawan['nama'],
                $karyawan['jabatan'],
                $karyawan['id_jabatan'] ?? null 
            );
        }

        //pagination
        $allData = array_values($karyawanList);
        $pagedData = array_slice($allData, $offset, $limit);

        return $pagedData;
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM karyawan");
        $row = $result->fetch_assoc();
        return $row ? (int)$row['total'] : 0;
    }
}

function render($contentFile) {
    $content = $contentFile;
    include __DIR__ . '/../views/MainPages.php';
}

render(__DIR__ . '/../views/pages/RekapGaji.php');