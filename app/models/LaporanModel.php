<?php
require_once __DIR__ . '/../repositories/LaporanRepository.php';

class LaporanModel
{
    private $repo;

    public function __construct()
    {
        $this->repo = new LaporanRepository();
    }

    public function getAllByKaryawan($id_karyawan)
    {
        return $this->repo->getAllByKaryawan($id_karyawan);
    }

    public function add($id_karyawan, $tanggal, $isi_laporan)
    {
        return $this->repo->add($id_karyawan, $tanggal, $isi_laporan);
    }

    public function update($id, $isi_laporan)
    {
        return $this->repo->update($id, $isi_laporan);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}