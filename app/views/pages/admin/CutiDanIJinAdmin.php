<div class="flex-grow-1">
    <div class="container mt-4">
        <h2 class="mb-4 fw-bold">Pengajuan Cuti & Ijin Karyawan</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle bg-white">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>ID Karyawan</th>
                        <th>Jabatan</th>
                        <th>Keterangan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Lampiran Surat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dataCuti)): ?>
                        <tr>
                            <td colspan="8" class="text-center bg-white">Tidak ada pengajuan ijin atau cuti dari karyawan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dataCuti as $i => $cuti): ?>
                            <tr>
                                <td><?= $offset + $i + 1 ?></td>
                                <td><?= htmlspecialchars($cuti['nama']) ?></td>
                                <td><?= htmlspecialchars($cuti['id_karyawan']) ?></td>
                                <td><?= htmlspecialchars($cuti['jabatan']) ?></td>
                                <td><?= htmlspecialchars($cuti['jenis']) ?></td>
                                <td><?= htmlspecialchars($cuti['tanggal_mulai']) ?></td>
                                <td><?= htmlspecialchars($cuti['tanggal_selesai']) ?></td>
                                <td>
                                    <?php if (!empty($cuti['lampiran'])): ?>
                                        <a href="<?= htmlspecialchars($cuti['lampiran']) ?>" target="_blank">Lihat Surat</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>