<?php
require_once __DIR__ . '/../repositories/AbsensiRepository.php';

class AbsensiModel
{
    private $repo;

    public function __construct()
    {
        $this->repo = new AbsensiRepository();
    }

    public function isSudahAbsenHariIni($id_karyawan)
    {
        $absen = $this->repo->getTodayAbsensi($id_karyawan, date('Y-m-d'));
        return $absen !== null;
    }

    public function hitungTotalJamKerja($id_karyawan, $tanggal_awal, $tanggal_akhir)
    {
        // Ambil total jam kerja dari repository
        return $this->repo->getTotalLamaJamKerja($id_karyawan, $tanggal_awal, $tanggal_akhir);
    }

    public function absenDatang($data)
    {
        // Bisa tambahkan validasi sebelum simpan
        if (empty($data['id_karyawan']) || empty($data['jam_datang'])) {
            return false;
        }
        return $this->repo->absenDatang($data);
    }

    public function absenPulang($id_absensi, $jam_pulang)
    {
        // Bisa tambahkan validasi sebelum update
        if (empty($id_absensi) || empty($jam_pulang)) {
            return false;
        }
        return $this->repo->absenPulang($id_absensi, $jam_pulang);
    }

    public function getAllAbsensi()
    {
        return $this->repo->getAll();
    }

    public function getAbsensiPage($limit, $offset)
    {
        return $this->repo->getPage($limit, $offset);
    }

    public function countAllAbsensi()
    {
        return $this->repo->countAll();
    }

    public function getTodayAbsensi($id_karyawan, $tanggal)
    {
        return $this->repo->getTodayAbsensi($id_karyawan, $tanggal);
    }

    public function updateStatusVerifikasi($id, $status)
    {
        return $this->repo->updateStatusVerifikasi($id, $status);
    }

    public function getTotalLamaJamKerja($id_karyawan, $tanggal_awal, $tanggal_akhir)
    {
        return $this->repo->getTotalLamaJamKerja($id_karyawan, $tanggal_awal, $tanggal_akhir);
    }
}