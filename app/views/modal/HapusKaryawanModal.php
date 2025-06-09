

<div class="modal-header">
    <h5 class="modal-title" id="deleteModalLabel<?= $karyawan['id_karyawan'] ?>">Hapus Karyawan</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="text-center">
        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
        <h5 class="mt-3">Konfirmasi Hapus</h5>
        <p class="mb-3">Apakah Anda yakin ingin menghapus karyawan ini?</p>

        <div class="alert alert-info text-start">
            <strong>Data yang akan dihapus:</strong><br>
            <strong>Nama:</strong> <?= htmlspecialchars($karyawan['nama']) ?><br>
            <strong>ID Karyawan:</strong> <?= htmlspecialchars($karyawan['id_karyawan']) ?><br>
            <strong>Jabatan:</strong> <?= htmlspecialchars($karyawan['jabatan']) ?><br>
            <strong>Username:</strong> <?= htmlspecialchars($karyawan['username']) ?>
        </div>

        <p class="text-danger">
            <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan!
        </p>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <form action="/payKaryawan/app/controllers/KaryawanHapusController.php" method="POST" style="display: inline;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id_karyawan" value="<?= htmlspecialchars($karyawan['id_karyawan']) ?>">
        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
    </form>
</div>