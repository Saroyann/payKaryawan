<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../../models/AbsensiModel.php';

$nama = $_SESSION['nama'] ?? '-';
$id_karyawan = $_SESSION['id_karyawan'] ?? '-';
$jabatan = $_SESSION['jabatan'] ?? '-';

$model = new AbsensiModel();
$tanggal = date('Y-m-d');
$lama_jam_kerja = $model->getTotalLamaJamKerja($id_karyawan, $tanggal, $tanggal);

if (!$lama_jam_kerja) $lama_jam_kerja = "00:00:00";
list($h, $m, $s) = explode(':', $lama_jam_kerja);

$absensi = $model->getTodayAbsensi($id_karyawan, $tanggal);

// Default
$status_kehadiran = "Belum Absen";
$status_color = "danger";

if ($absensi && !empty($absensi['jam_datang'])) {
    if ($absensi['status_verifikasi'] === 'menunggu') {
        $status_kehadiran = "Menunggu Verifikasi";
        $status_color = "warning";
    } elseif ($absensi['status_verifikasi'] === 'ditolak') {
        $status_kehadiran = "Absensi Ditolak";
        $status_color = "danger";
    } elseif ($absensi['status_verifikasi'] === 'diterima') {
        $status_kehadiran = "Hadir";
        $status_color = "success";
    } else {
        $status_kehadiran = "Menunggu Verifikasi";
        $status_color = "warning";
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div style="width: 100%; max-width: 1050px;">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="fw-bold mb-1"><?= htmlspecialchars($nama) ?></h4>
                            <div class="mb-1 text-muted">ID: <?= htmlspecialchars($id_karyawan) ?></div>
                            <div class="mb-0"><?= htmlspecialchars($jabatan) ?></div>
                        </div>
                        <div>
                            <i class="bi bi-person-circle fs-1 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center gx-4 gy-3">
            <div class="col-md-4 d-flex">
                <div class="card text-center shadow-sm border-0 h-100 flex-fill mx-2">
                    <div class="card-body">
                        <i class="bi bi-clock-history fs-2 text-info mb-2"></i>
                        <h6 class="fw-bold">Lama Jam Kerja</h6>
                        <div class="d-flex justify-content-center align-items-end gap-2 fs-4 mb-2">
                            <div>
                                <span class="fw-bold"><?= $h ?></span>
                                <span class="text-muted" style="font-size:0.8em;">Jam</span>
                            </div>
                            <div>
                                <span class="fw-bold"><?= $m ?></span>
                                <span class="text-muted" style="font-size:0.8em;">Menit</span>
                            </div>
                            <div>
                                <span class="fw-bold"><?= $s ?></span>
                                <span class="text-muted" style="font-size:0.8em;">Detik</span>
                            </div>
                        </div>
                        <div class="text-muted small">Hari ini</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="card text-center shadow-sm border-0 h-100 flex-fill mx-2">
                    <div class="card-body">
                        <i class="bi bi-check-circle fs-2 text-<?= $status_color ?> mb-2"></i>
                        <h6 class="fw-bold">Status Kehadiran</h6>
                        <div class="fs-4">
                            <span class="badge bg-<?= $status_color ?>"><?= $status_kehadiran ?></span>
                        </div>
                        <div class="text-muted small">Hari ini</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card Laporan Pekerjaan di bawah -->
        <div class="row justify-content-center gx-4 gy-3 mt-4">
            <div class="col-md-8 d-flex">
                <div class="card text-center shadow-sm border-0 h-100 flex-fill">
                    <div class="card-body">
                        <i class="bi bi-clipboard-data fs-2 text-primary mb-2"></i>
                        <h6 class="fw-bold">Laporan Pekerjaan</h6>
                        <!-- Form tambah laporan -->
                        <form method="post" class="row g-1 align-items-center mb-2">
                            <div class="col">
                                <input type="text" name="isi_laporan" class="form-control form-control-sm" placeholder="Tambah pekerjaan..." required>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="tambah_laporan" class="btn btn-sm btn-primary px-3">
                                    tambah
                                </button>
                            </div>
                        </form>
                        <!-- List laporan -->
                        <ul class="list-group mb-2 text-start">
                            <?php
                            require_once __DIR__ . '/../../../models/LaporanModel.php';
                            $laporanModel = new LaporanModel();

                            // Tambah laporan
                            if (isset($_POST['tambah_laporan']) && !empty($_POST['isi_laporan'])) {
                                $laporanModel->add($id_karyawan, date('Y-m-d'), $_POST['isi_laporan']);
                                header("Location: ".$_SERVER['REQUEST_URI']); exit;
                            }
                            // Edit laporan
                            if (isset($_POST['edit_laporan']) && isset($_POST['id_laporan']) && !empty($_POST['isi_laporan'])) {
                                $laporanModel->update($_POST['id_laporan'], $_POST['isi_laporan']);
                                header("Location: ".$_SERVER['REQUEST_URI']); exit;
                            }
                            // Hapus laporan
                            if (isset($_POST['hapus_laporan']) && isset($_POST['id_laporan'])) {
                                $laporanModel->delete($_POST['id_laporan']);
                                header("Location: ".$_SERVER['REQUEST_URI']); exit;
                            }
                            // Ambil semua laporan user
                            $daftar_laporan = $laporanModel->getAllByKaryawan($id_karyawan);
                            foreach ($daftar_laporan as $laporan): ?>
                                <li class="list-group-item py-1 px-2">
                                    <form method="post" class="d-flex align-items-center mb-0" style="gap:0.5rem;">
                                        <input type="hidden" name="id_laporan" value="<?= $laporan['id'] ?>">
                                        <input type="text" name="isi_laporan" value="<?= htmlspecialchars($laporan['isi_laporan']) ?>"
                                            class="form-control form-control-sm border-0 bg-transparent px-1"
                                            style="flex:1 1 auto; min-width:0;" required>
                                        <button class="btn btn-sm btn-link p-1 text-success" type="submit" name="edit_laporan" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-link p-1 text-danger" type="submit" name="hapus_laporan" title="Hapus" onclick="return confirm('Hapus laporan ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <form method="post" action="/payKaryawan/app/views/pages/PdfDownloads/DownloadLaporanPDF.php" target="_blank">
                            <button type="submit" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="bi bi-file-earmark-pdf"></i> Download PDF
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
ob_end_flush();
?>