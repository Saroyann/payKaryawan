<?php
require_once __DIR__ . '/../repositories/KaryawanRepository.php';

class KaryawanModel {
    private $repo;

    public function __construct() {
        $this->repo = new KaryawanRepository();
    }

    public function getAll() {
        return $this->repo->getAll();
    }

    public function getById($id_karyawan) {
        return $this->repo->getById($id_karyawan);
    }

    public function getByUsername($username) {
        return $this->repo->getByUsername($username);
    }

    public function insert($id_karyawan, $nama, $jabatan, $username, $password) {
        return $this->repo->insert($id_karyawan, $nama, $jabatan, $username, $password);
    }

    public function update($id_lama, $id_baru, $nama, $jabatan, $username) {
        return $this->repo->update($id_lama, $id_baru, $nama, $jabatan, $username);
    }

    public function delete($id_karyawan) {
        return $this->repo->delete($id_karyawan);
    }
}