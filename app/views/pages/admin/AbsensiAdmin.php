<div class="flex-grow-1">
    <div class="container mt-4">
        <h2 class="mb-4 fw-bold">Daftar Absensi Karyawan</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle bg-white">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>ID Karyawan</th>
                        <th>Jabatan</th>
                        <th>Foto</th>
                        <th>Lokasi</th>
                        <th>Jam Datang</th>
                        <th>Jam Pulang</th>
                        <th>Total Jam Kerja</th> <!-- Tambahkan ini -->
                        <th>Tanggal</th>
                        <th>Status Kehadiran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dataAbsensi)): ?>
                        <tr>
                            <td colspan="12" class="text-center bg-white">Tidak ada kegiatan absensi.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dataAbsensi as $i => $absen): ?>
                            <tr>
                                <td><?= $offset + $i + 1 ?></td>
                                <td><?= htmlspecialchars($absen['nama']) ?></td>
                                <td><?= htmlspecialchars($absen['id_karyawan']) ?></td>
                                <td><?= htmlspecialchars($absen['jabatan']) ?></td>
                                <td>
                                    <?php if (!empty($absen['foto'])): ?>
                                        <img src="<?= htmlspecialchars($absen['foto']) ?>" alt="Foto" width="50" style="cursor:pointer"
                                            data-bs-toggle="modal" data-bs-target="#fotoModal<?= $i ?>">
                                        <!-- Modal -->
                                        <div class="modal fade" id="fotoModal<?= $i ?>" tabindex="-1" aria-labelledby="fotoModalLabel<?= $i ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="fotoModalLabel<?= $i ?>">Foto Absensi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="<?= htmlspecialchars($absen['foto']) ?>" alt="Foto" class="img-fluid rounded">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($absen['lokasi']) && strpos($absen['lokasi'], ',') !== false): ?>
                                        <?php
                                        list($lat, $lng) = explode(',', $absen['lokasi']);
                                        $lat = trim($lat);
                                        $lng = trim($lng);
                                        $gmap = "https://www.google.com/maps?q={$lat},{$lng}";
                                        ?>
                                        <a href="<?= htmlspecialchars($gmap) ?>" target="_blank" class="btn btn-link p-0">
                                            Lihat Lokasi
                                        </a>
                                    <?php else: ?>
                                        <?= htmlspecialchars($absen['lokasi']) ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($absen['jam_datang']) ?></td>
                                <td><?= htmlspecialchars($absen['jam_pulang'] ?? '-') ?></td> <!-- Kolom jam pulang -->
                                <td>
                                    <?php
                                    if (!empty($absen['jam_datang']) && !empty($absen['jam_pulang'])) {
                                        $start = new DateTime($absen['jam_datang']);
                                        $end = new DateTime($absen['jam_pulang']);
                                        $interval = $start->diff($end);
                                        echo $interval->format('%h jam %i menit %s detik');
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($absen['tanggal']) ?></td>
                                <td>
                                    <?php if (!empty($absen['status_verifikasi'])): ?>
                                        <span class="badge bg-<?= $absen['status_verifikasi'] === 'diterima' ? 'success' : ($absen['status_verifikasi'] === 'ditolak' ? 'danger' : 'secondary') ?>">
                                            <?= ucfirst($absen['status_verifikasi']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($absen['status_verifikasi'] === 'menunggu' || empty($absen['status_verifikasi'])): ?>
                                        <form method="POST" action="/payKaryawan/app/controllers/VerifikasiController.php" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($absen['id']) ?>">
                                            <button type="submit" name="aksi" value="diterima" class="btn btn-success btn-sm">
                                                Terima
                                            </button>
                                            <button type="submit" name="aksi" value="ditolak" class="btn btn-danger btn-sm">
                                                Tolak
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="badge bg-<?= $absen['status_verifikasi'] === 'diterima' ? 'success' : 'danger' ?>">
                                            <?= ucfirst($absen['status_verifikasi']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="pagination-fixed">
                <?php
                $search_id = $_GET['search_id'] ?? '';
                require_once __DIR__ . '/../../components/Pagination.php';
                ?>
            </div>
        </div>
    </div>
</div>