

<div class="modal-header">
    <h5 class="modal-title" id="editModalLabel<?= $karyawan['id_karyawan'] ?>">Edit Karyawan</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form action="/payKaryawan/app/controllers/KaryawanEditController.php" method="POST">
    <div class="modal-body">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id_karyawan_lama" value="<?= htmlspecialchars($karyawan['id_karyawan']) ?>">

        <div class="mb-3">
            <label for="nama<?= $karyawan['id_karyawan'] ?>" class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control" id="nama<?= $karyawan['id_karyawan'] ?>" name="nama"
                value="<?= htmlspecialchars($karyawan['nama']) ?>" required>
        </div>


        <div class="mb-3">
            <label for="jabatan<?= $karyawan['id_karyawan'] ?>" class="form-label">Jabatan</label>
            <select class="form-select" id="jabatan<?= $karyawan['id_karyawan'] ?>" name="jabatan" required>
                <option value="" disabled>Pilih Jabatan</option>
                <option value="Manajer" <?= $karyawan['jabatan'] == 'Manajer' ? 'selected' : '' ?>>Manajer
                </option>
                <option value="Asisten Manajer" <?= $karyawan['jabatan'] == 'Asisten Manajer' ? 'selected' : '' ?>>
                    Asisten Manajer</option>
                <option value="Supervisor" <?= $karyawan['jabatan'] == 'Supervisor' ? 'selected' : '' ?>>Supervisor
                </option>
                <option value="Staff" <?= $karyawan['jabatan'] == 'Staff' ? 'selected' : '' ?>>Staff</option>
                <option value="Office Boy/Girl" <?= $karyawan['jabatan'] == 'Office Boy/Girl' ? 'selected' : '' ?>>
                    Office Boy/Girl</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="username<?= $karyawan['id_karyawan'] ?>" class="form-label">Username</label>
            <input type="text" class="form-control" id="username<?= $karyawan['id_karyawan'] ?>" name="username"
                value="<?= htmlspecialchars($karyawan['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="password<?= $karyawan['id_karyawan'] ?>" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" class="form-control" id="password<?= $karyawan['id_karyawan'] ?>" name="password">
        </div>

        <div class="mb-3">
            <label for="id_karyawan<?= $karyawan['id_karyawan'] ?>" class="form-label">ID Karyawan</label>
            <input type="text" class="form-control" id="id_karyawan<?= $karyawan['id_karyawan'] ?>" name="id_karyawan"
                value="<?= htmlspecialchars($karyawan['id_karyawan']) ?>" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">Update</button>
    </div>
</form>