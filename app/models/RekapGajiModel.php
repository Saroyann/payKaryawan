<?php
require_once __DIR__ . '/../repositories/RekapGajiRepository.php';

class RekapGajiModel
{
    private $repo;

    public function __construct()
    {
        $this->repo = new RekapGajiRepository();
    }

    public function countAll()
    {
        return $this->repo->countAll();
    }

    public function getPage($limit, $offset)
    {
        return $this->repo->getPage($limit, $offset);
    }

    // Tambahkan fungsi untuk simpan/update gaji ke rekap_gaji
    public function saveOrUpdateGaji($id_karyawan, $gaji, $nama, $jabatan)
    {
        return $this->repo->saveOrUpdateGaji($id_karyawan, $gaji, $nama, $jabatan);
    }
}