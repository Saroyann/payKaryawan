<?php
require_once __DIR__ . '/../../models/AbsensiModel.php';

$model = new AbsensiModel();

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 13;
$offset = ($page - 1) * $perPage;

$totalRows = $model->countAllAbsensi();
$totalPages = ceil($totalRows / $perPage);

$dataAbsensi = $model->getAbsensiPage($perPage, $offset);

$role = $_SESSION['role'] ?? 'karyawan'; // default karyawan
?>

<div class="d-flex" style="min-height: 100vh;">
        <?php include __DIR__ . '/../components/Sidebar.php'; ?>
    <div class="flex-grow-1">
        <div class="container mt-4">

            <?php
            if ($role === 'admin') {
                include __DIR__ . '/admin/AbsensiAdmin.php';
            } else {
                include __DIR__ . '/karyawan/AbsensiKaryawan.php';
            }
            ?>
            
        </div>
    </div>
</div>
