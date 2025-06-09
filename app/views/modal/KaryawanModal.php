<div class="modal fade" id="tambahKaryawanModal" tabindex="-1" aria-labelledby="tambahKaryawanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="/payKaryawan/app/controllers/KaryawanTambahController.php" method="post">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKaryawanLabel">Tambah Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Karyawan</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="id_karyawan" class="form-label">ID Karyawan</label>
                    <input type="text" class="form-control" id="id_karyawan" name="id_karyawan" required>
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <select class="form-select" id="jabatan" name="jabatan" required>
                        <option value="" disabled selected>Pilih Jabatan</option>
                        <option value="Manajer">Manajer</option>
                        <option value="Asisten Manajer">Asisten Manajer</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Staff">Staff</option>
                        <option value="Office Boy/Girl">Office Boy/Girl</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username (Email)</label>
                    <input type="email" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>