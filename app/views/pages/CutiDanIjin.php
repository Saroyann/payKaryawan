<?php
require_once __DIR__ . '/../../models/CutiModel.php';

$model = new CutiModel();
$dataCuti = $model->getAll();
?>

<div class="d-flex" style="min-height: 100vh;">
    <?php include __DIR__ . '/../components/Sidebar.php'; ?>

    <?php
    $role = $_SESSION['role'] ?? 'karyawan'; 
    ?>
        <div class="flex-grow-1">
            <div class="container mt-4">

                <?php
                if ($role === 'admin') {
                    include __DIR__ . '/admin/CutiDanIJinAdmin.php';
                } else {
                    include __DIR__ . '/karyawan/CutiDanIJinKaryawan.php';
                }
                ?>

            </div>
        </div>
    </div>
    
</div>