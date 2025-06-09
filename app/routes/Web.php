<?php
$path = parse_url($request, PHP_URL_PATH);

// Debug: tampilkan nilai $path
// echo "<pre>PATH: "; var_dump($path); echo "</pre>";

switch ($path) {
    case '/':
    case '/payKaryawan/public/':
        require __DIR__ . '/../controllers/LoginController.php';
        break;
    case '/payKaryawan/public/dashboard':
        require __DIR__ . '/../controllers/DashboardController.php';
        break;
    case '/payKaryawan/public/karyawan':
        require __DIR__ . '/../controllers/KaryawanController.php';
        break;
    case '/payKaryawan/public/absensi':
        require __DIR__ . '/../controllers/AbsensiController.php';
        break;
    case '/payKaryawan/public/rekapGaji':
        require __DIR__ . '/../controllers/RekapGajiController.php';
        break;
    case '/payKaryawan/public/cutiDanIjin':
        require __DIR__ . '/../controllers/CutiDanIjinController.php';
        break;
    case '/payKaryawan/public/profile':
        require __DIR__ . '/../controllers/ProfileController.php';
        break;
    case '/payKaryawan/public/logout':
        require __DIR__ . '/../views/pages/Logout.php';
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
