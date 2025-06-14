<?php
date_default_timezone_set('Asia/Makassar'); 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/AbsensiModel.php';

class AbsensiController {
    private $model;

    public function __construct() {
        $this->model = new AbsensiModel();
    }

    public function getModel() {
        return $this->model;
    }

    public function index() {
        $id_karyawan = $_SESSION['id_karyawan'] ?? null;
        $now = new DateTime('now', new DateTimeZone('Asia/Makassar'));
        $tanggal = $now->format('Y-m-d');
        $absensi = $this->model->getTodayAbsensi($id_karyawan, $tanggal);

        // Auto absen pulang jika sudah absen datang tapi belum absen pulang dan sudah lewat jam 17:15 WITA
        if ($absensi && !empty($absensi['jam_datang']) && empty($absensi['jam_pulang'])) {
            $autoPulang = new DateTime($tanggal . ' 17:15:00', new DateTimeZone('Asia/Makassar'));
            if ($now > $autoPulang) {
                $this->model->absenPulang($absensi['id'], $autoPulang->format('Y-m-d H:i:s'));
                $_SESSION['sudah_absen_pulang'] = true;
                $_SESSION['success_absen'] = "Absen pulang otomatis dicatat pada 17:15:00 WITA karena Anda tidak absen pulang.";
            }
        }

        $_SESSION['sudah_absen_datang'] = $absensi && !empty($absensi['jam_datang']);
        $_SESSION['sudah_absen_pulang'] = $absensi && !empty($absensi['jam_pulang']);

        // Debug info (hapus setelah testing)
        error_log("DEBUG - ID Karyawan: " . $id_karyawan);
        error_log("DEBUG - Tanggal: " . $tanggal);
        error_log("DEBUG - Absensi data: " . print_r($absensi, true));
        error_log("DEBUG SESSION: " . print_r($_SESSION, true));
    }

    public function handleRequest() {
        // Handle POST request untuk absensi
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['absen_datang'])) {
                $this->absenDatang();
            } elseif (isset($_POST['absen_pulang'])) {
                $this->absenPulang();
            }
        }
    }

    public function absenDatang() {
        try {
            $id_karyawan = $_SESSION['id_karyawan'] ?? null;
            $nama = $_SESSION['nama'] ?? null;
            $jabatan = $_SESSION['jabatan'] ?? null;

            if (!$id_karyawan || !$nama || !$jabatan) {
                $_SESSION['error_foto'] = "Data session tidak lengkap. Silakan login ulang.";
                header('Location: /payKaryawan/public/absensi');
                exit;
            }

            $now = new DateTime('now', new DateTimeZone('Asia/Makassar'));
            $tanggal = $now->format('Y-m-d');
            $existingAbsen = $this->model->getTodayAbsensi($id_karyawan, $tanggal);

            // Jika sudah absen datang & pulang, cek apakah sudah lewat jam 07:35
            if ($existingAbsen && !empty($existingAbsen['jam_datang']) && !empty($existingAbsen['jam_pulang'])) {
                $bukaLagi = new DateTime($tanggal . ' 07:35:00', new DateTimeZone('Asia/Makassar'));
                if ($now < $bukaLagi) {
                    $_SESSION['error_foto'] = "Anda sudah absen datang & pulang hari ini. Absensi baru bisa dibuka lagi setelah jam 07:35 WITA.";
                    header('Location: /payKaryawan/public/absensi');
                    exit;
                }
            } // <-- Tambahkan kurung kurawal penutup di sini

            $jam_datang = $now->format('Y-m-d H:i:s');

            // Debug info
            error_log("DEBUG - Processing absen datang for: " . $id_karyawan);
            error_log("DEBUG - FILES: " . print_r($_FILES, true));
            error_log("DEBUG - POST: " . print_r($_POST, true));

            // Validasi dan upload foto
            $foto = null;
            $error_foto = null;
            
            if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== 0) {
                $error_foto = "Foto wajib diupload. Error: " . ($_FILES['foto']['error'] ?? 'File tidak ada');
            } else {
                $file = $_FILES['foto'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $size = $file['size'];
                
                if (!in_array($ext, ['jpg', 'jpeg'])) {
                    $error_foto = "File harus JPG/JPEG. Format yang diupload: " . $ext;
                } elseif ($size > 2 * 1024 * 1024) {
                    $error_foto = "Ukuran file maksimal 2MB. Ukuran file: " . round($size/1024/1024, 2) . "MB";
                } else {
                    // Pastikan direktori upload ada
                    $uploadDir = __DIR__ . '/../../public/uploads/';
                    if (!is_dir($uploadDir)) {
                        if (!mkdir($uploadDir, 0777, true)) {
                            $error_foto = "Gagal membuat direktori upload.";
                        }
                    }
                    
                    if (!$error_foto) {
                        $fotoName = uniqid('absen_') . '.' . $ext;
                        $fotoPath = $uploadDir . $fotoName;
                        
                        if (move_uploaded_file($file['tmp_name'], $fotoPath)) {
                            $foto = '/payKaryawan/public/uploads/' . $fotoName;
                            error_log("DEBUG - Foto berhasil diupload: " . $foto);
                        } else {
                            $error_foto = "Gagal mengupload foto.";
                        }
                    }
                }
            }

            if ($error_foto) {
                $_SESSION['error_foto'] = $error_foto;
                header('Location: /payKaryawan/public/absensi');
                exit;
            }

            $lokasi = $_POST['lokasi'] ?? 'Lokasi tidak tersedia';

            $data = [
                'id_karyawan' => $id_karyawan,
                'nama' => $nama,
                'jabatan' => $jabatan,
                'foto' => $foto,
                'lokasi' => $lokasi,
                'jam_datang' => $jam_datang,
                'tanggal' => $tanggal,
                'status' => 'hadir',
            ];

            error_log("DEBUG - Data yang akan disimpan: " . print_r($data, true));

            // Simpan ke database
            $result = $this->model->absenDatang($data);
            
            if ($result) {
                $_SESSION['sudah_absen_datang'] = true;
                $_SESSION['success_absen'] = "Absen datang berhasil dicatat pada " . $now->format('H:i:s') . "!";
                error_log("DEBUG - Absen datang berhasil disimpan");
            } else {
                $_SESSION['error_foto'] = "Gagal menyimpan data absensi ke database.";
                error_log("DEBUG - Gagal menyimpan ke database");
            }

        } catch (Exception $e) {
            $_SESSION['error_foto'] = "Terjadi kesalahan: " . $e->getMessage();
            error_log("ERROR - Exception in absenDatang: " . $e->getMessage());
        }

        header('Location: /payKaryawan/public/absensi');
        exit;
    }

    public function absenPulang() {
        try {
            $id_karyawan = $_SESSION['id_karyawan'] ?? null;
            
            if (!$id_karyawan) {
                $_SESSION['error_foto'] = "Session tidak valid.";
                header('Location: /payKaryawan/public/absensi');
                exit;
            }



            $tanggal = date('Y-m-d');
            $absensi = $this->model->getTodayAbsensi($id_karyawan, $tanggal);
            
            if (!$absensi) {
                $_SESSION['error_foto'] = "Anda belum absen datang hari ini.";
            } elseif (!empty($absensi['jam_pulang'])) {
                $_SESSION['error_foto'] = "Anda sudah absen pulang hari ini.";
            } else {
                $this->model->absenPulang($absensi['id'], date('Y-m-d H:i:s'));
                $_SESSION['sudah_absen_pulang'] = true;
                $_SESSION['success_absen'] = "Absen pulang berhasil dicatat pada " . date('H:i:s') . "!";
            }
        } catch (Exception $e) {
            $_SESSION['error_foto'] = "Terjadi kesalahan: " . $e->getMessage();
        }

        header('Location: /payKaryawan/public/absensi');
        exit;
    }
}

$controller = new AbsensiController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest();
} else {
    $controller->index();
    render(__DIR__ . '/../views/pages/Absensi.php');
}

function render($contentFile) {
    $content = $contentFile;
    include __DIR__ . '/../views/MainPages.php';
}

$id_karyawan = $_SESSION['id_karyawan'] ?? null;
$tanggal = date('Y-m-d');
$lama_jam_kerja = $controller->getModel()->getTotalLamaJamKerja($id_karyawan, $tanggal, $tanggal);

$id_karyawan = $_SESSION['id_karyawan'] ?? null;
$tanggal = date('Y-m-d');
$lama_jam_kerja = $controller->getModel()->getTotalLamaJamKerja($id_karyawan, $tanggal, $tanggal);
