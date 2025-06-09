<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['role'] ?? '';

// Fungsi untuk cek apakah menu aktif
function isActive($path, $currentPath)
{
    return ($currentPath == $path) ? ' active' : '';
}
?>
<div class="d-flex flex-column flex-shrink-0 p-3 text-white align-items-center enhanced-sidebar" style="width: 350px; min-height: 100vh;">
    <!-- Logo -->
    <a href="#" class="d-flex align-items-center mb-4 text-white text-decoration-none logo-link">
        <span class="fs-2 fw-bold">PayKaryawan</span>
    </a>
    <hr class="w-100 sidebar-divider">

    <!-- Navigasi di tengah sidebar -->
    <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1 w-100">
        <ul class="nav nav-pills flex-column w-100 align-items-stretch">
            <li class="nav-item mb-3 w-100">
                <a href="/payKaryawan/public/dashboard"
                    class="nav-link w-100 fs-5 py-3 text-start<?= isActive('/payKaryawan/public/dashboard', $currentPath); ?>"
                    data-tooltip="Lihat ringkasan data">
                    <i class="bi bi-speedometer2 me-2 fs-4"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mb-3 w-100">
                <a href="/payKaryawan/public/absensi"
                    class="nav-link w-100 fs-5 py-3 text-start<?= isActive('/payKaryawan/public/absensi', $currentPath); ?>"
                    data-tooltip="Catat kehadiran">
                    <i class="bi bi-calendar-check me-2 fs-4"></i> Absensi
                </a>
            </li>

            <?php if ($role === 'admin'): ?>
                <!-- Sidebar untuk admin -->
                <li class="nav-item mb-3 w-100">
                    <a href="/payKaryawan/public/karyawan"
                        class="nav-link w-100 fs-5 py-3 text-start<?= isActive('/payKaryawan/public/karyawan', $currentPath); ?>"
                        data-tooltip="Kelola data karyawan">
                        <i class="bi bi-people-fill me-2 fs-4"></i> Karyawan
                    </a>
                </li>
                <li class="nav-item mb-3 w-100">
                    <a href="/payKaryawan/public/rekapGaji"
                        class="nav-link w-100 fs-5 py-3 text-start<?= isActive('/payKaryawan/public/rekapGaji', $currentPath); ?>"
                        data-tooltip="Rekap penggajian">
                        <i class="bi bi-cash-stack me-2 fs-4"></i> Rekap Gaji
                    </a>
                </li>
                <li class="nav-item mb-3 w-100">
                    <a href="/payKaryawan/public/cutiDanIjin"
                        class="nav-link w-100 fs-5 py-3 text-start<?= isActive('/payKaryawan/public/cutiDanIjin', $currentPath); ?>"
                        data-tooltip="Kelola cuti karyawan">
                        <i class="bi bi-calendar-x me-2 fs-4"></i> Cuti & Ijin
                    </a>
                </li>
            <?php elseif ($role === 'karyawan'): ?>
                <!-- Sidebar untuk karyawan biasa -->
                <li class="nav-item mb-3 w-100">
                    <a href="/payKaryawan/public/cutiDanIjin"
                        class="nav-link w-100 fs-5 py-3 text-start<?= isActive('/payKaryawan/public/cutiDanIjin', $currentPath); ?>"
                        data-tooltip="Pengajuan cuti/ijin">
                        <i class="bi bi-calendar-x me-2 fs-4"></i> Pengajuan Cuti
                    </a>
                </li>

            <?php endif; ?>

            <li class="nav-item mt-4 w-100">
                <a href="/payKaryawan/public/logout"
                    class="nav-link fw-bold w-100 fs-5 py-3 text-start logout-link text-danger"
                    data-tooltip="Keluar dari sistem"
                    style="color: #dc3545 !important;">
                    <i class="bi bi-box-arrow-right me-2 fs-4"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>