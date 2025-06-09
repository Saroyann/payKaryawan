<div class="d-flex" style="min-height: 100vh;">
    <?php include __DIR__ . '/../components/Sidebar.php'; ?>

    <div class="flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <h1 class="mb-4 fw-bold">Selamat Datang, Admin!</h1>
                    <?php else: ?>
                        <?php
                            include __DIR__ . '/../pages/karyawan/DashboardKaryawan.php';
                            ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>