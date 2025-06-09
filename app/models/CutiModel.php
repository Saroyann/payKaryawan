<?php
require_once __DIR__ . '/../repositories/CutiRepository.php';

class CutiModel {
    private $repo;
    public function __construct() {
        $this->repo = new CutiRepository();
    }

    public function getAll() {
        return $this->repo->getAll();
    }

    public function ajukanCuti($data) {
        return $this->repo->insert($data);
    }
}