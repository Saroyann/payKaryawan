<?php
require_once __DIR__ . '/../../models/KaryawanModel.php';

$model = new KaryawanModel();
$perPage = 13;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

if (!empty($_GET['search_id'])) {
    $dataKaryawan = [];
    $result = $model->getById($_GET['search_id']);
    if ($result) $dataKaryawan[] = $result;
    $totalRows = count($dataKaryawan);
    $totalPages = 1;
} else {
    $allData = $model->getAll();
    $totalRows = count($allData);
    $totalPages = ceil($totalRows / $perPage);
    $dataKaryawan = array_slice($allData, $offset, $perPage);
}
?>


    <div class="d-flex" style="min-height: 100vh;">
        <?php include __DIR__ . '/../components/Sidebar.php'; ?>

        <div class="flex-grow-1 d-flex justify-content-center mt-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h2 class="fw-bold mb-0">Daftar Karyawan</h2>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <form class="d-flex align-items-center" method="get" action="">
                        <input type="text" class="form-control form-control-sm me-2" name="search_id"
                            placeholder="Cari ID Karyawan" style="width: 300px;"
                            value="<?= htmlspecialchars($_GET['search_id'] ?? '') ?>">
                        <button class="btn btn-primary btn-sm" style="width: 150px;" type="submit">Cari</button>
                        <?php if (!empty($_GET['search_id'])): ?>
                            <a href="?" class="btn btn-primary btn-sm ms-2" style="width: 150px;">Reset</a>
                        <?php endif; ?>
                    </form>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKaryawanModal"
                        style="width: 200px; height: 50px;">
                        <i class="bi bi-plus-lg"></i> Tambah Karyawan
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle bg-white">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th class="text-center">Nama Karyawan</th>
                                <th class="text-center">ID Karyawan</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Username</th>
                                <th class="text-center" style="width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($dataKaryawan)): ?>
                                <tr>
                                    <td colspan="6" class="text-center bg-white">Tidak ada data karyawan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($dataKaryawan as $i => $karyawan): ?>
                                    <tr class="bg-white">
                                        <td><?= $offset + $i + 1 ?></td>
                                        <td><?= htmlspecialchars($karyawan['nama']) ?></td>
                                        <td><?= htmlspecialchars($karyawan['id_karyawan']) ?></td>
                                        <td><?= htmlspecialchars($karyawan['jabatan']) ?></td>
                                        <td><?= htmlspecialchars($karyawan['username']) ?></td>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal"
                                                data-bs-target="#editModal<?= $karyawan['id_karyawan'] ?>">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?= $karyawan['id_karyawan'] ?>">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination-fixed">
                    <?php
                    $search_id = $_GET['search_id'] ?? '';
                    require_once __DIR__ . '/../components/Pagination.php';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit & Hapus -->
    <?php if (!empty($dataKaryawan)): ?>
        <?php foreach ($dataKaryawan as $karyawan): ?>
            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $karyawan['id_karyawan'] ?>" tabindex="-1"
                aria-labelledby="editModalLabel<?= $karyawan['id_karyawan'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <?php include __DIR__ . '/../modal/EditKaryawanModal.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Modal Hapus -->
            <div class="modal fade" id="deleteModal<?= $karyawan['id_karyawan'] ?>" tabindex="-1"
                aria-labelledby="deleteModalLabel<?= $karyawan['id_karyawan'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <?php include __DIR__ . '/../modal/HapusKaryawanModal.php'; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Modal Tambah Karyawan -->
    <?php include __DIR__ . '/../modal/KaryawanModal.php'; ?>

