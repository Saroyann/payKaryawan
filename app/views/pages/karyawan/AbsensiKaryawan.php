<?php
$isSudahAbsenDatang = $_SESSION['sudah_absen_datang'] ?? false;
$isSudahAbsenPulang = $_SESSION['sudah_absen_pulang'] ?? false;
?>
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <h4 class="mb-4 text-center fw-bold">Absensi Kehadiran</h4>
        
        <!-- Pesan sukses/error -->
        <?php if (!empty($_SESSION['success_absen'])): ?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <?= $_SESSION['success_absen']; unset($_SESSION['success_absen']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error_foto'])): ?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <?= $_SESSION['error_foto']; unset($_SESSION['error_foto']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form id="absenForm" action="/payKaryawan/app/controllers/AbsensiController.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Kehadiran (JPG/JPEG)</label>
                <input type="file" class="form-control" name="foto" id="foto"
                    accept="image/jpeg,image/png"
                    capture="environment"
                    required <?= $isSudahAbsenDatang ? 'disabled' : '' ?>>
                <div class="form-text text-danger">
                    Hanya file JPG/JPEG, maksimal 2MB.
                </div>
                <div id="preview-container" class="mt-2 text-center"></div>
            </div>
            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi Absensi (Live)</label>
                <input type="text" class="form-control" name="lokasi" id="lokasi" readonly required <?= $isSudahAbsenDatang ? 'disabled' : '' ?>>
                <div class="form-text">Lokasi terisi otomatis.</div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" name="absen_datang"
                    class="btn w-50 me-2 <?= $isSudahAbsenDatang ? 'btn-secondary' : 'btn-primary' ?>"
                    <?= $isSudahAbsenDatang ? 'disabled' : '' ?>>
                    Absen Datang
                </button>
                <button type="submit" name="absen_pulang"
                    class="btn w-50 ms-2 <?= (!$isSudahAbsenDatang || $isSudahAbsenPulang) ? 'btn-secondary' : 'btn-success' ?>"
                    <?= (!$isSudahAbsenDatang || $isSudahAbsenPulang) ? 'disabled' : '' ?>>
                    Absen Pulang
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/payKaryawan/public/js/absensiKaryawan/PhotoPreview.js"></script>

<script src="/payKaryawan/public/js/absensiKaryawan/LokasiKaryawan.js" ></script>