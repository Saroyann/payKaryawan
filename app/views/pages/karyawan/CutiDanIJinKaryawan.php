<div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 450px;">
        <h2 class="mb-4 fw-bold text-center">Pengajuan Cuti & Ijin</h2>
        <?php if (!empty($_SESSION['success_cuti'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success_cuti']; unset($_SESSION['success_cuti']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error_cuti'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error_cuti']; unset($_SESSION['error_cuti']); ?></div>
        <?php endif; ?>
        <form action="/payKaryawan/app/controllers/CutiDanIjinController.php" method="POST" enctype="multipart/form-data" class="mb-2">
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Pengajuan</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="Cuti">Cuti</option>
                    <option value="Ijin">Ijin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="lampiran" class="form-label">Lampiran Surat (PDF)</label>
                <input type="file" name="lampiran" id="lampiran" class="form-control" accept=".pdf">
            </div>
            <button type="submit" name="ajukan_cuti" class="btn btn-primary w-100">Ajukan</button>
        </form>
    </div>
</div>