<?php
require_once __DIR__ . '/../../controllers/RekapGajiController.php';
$controller = new RekapGajiController();
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 17;
$offset = ($page - 1) * $perPage;
$totalRows = $controller->countAll();
$totalPages = ceil($totalRows / $perPage);
$dataGaji = $controller->getRekapGaji($perPage, $offset);
?>

<div class="d-flex" style="min-height: 100vh;">
    <?php
    include __DIR__ . '/../components/Sidebar.php';
    ?>
    <div class="flex-grow-1">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0 fw-bold">Rekap Gaji Karyawan</h2>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <a href="/payKaryawan/app/views/pages/PdfDownloads/DownloadRekapGajiPDF.php" target="_blank" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle bg-white">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>ID Karyawan</th>
                            <th>Jabatan</th>
                            <th>Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dataGaji)): ?>
                            <tr>
                                <td colspan="5" class="text-center bg-white">Tidak ada data karyawan</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($dataGaji as $i => $gaji): ?>
                                <tr>
                                    <td><?= $offset + $i + 1 ?></td>
                                    <td><?= htmlspecialchars($gaji['nama'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($gaji['id_karyawan'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($gaji['jabatan'] ?? '-') ?></td>
                                    <td>Rp.<?= number_format($gaji['gaji'] ?? 0, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="pagination-fixed">
                    <?php
                    $search_id = $_GET['search_id'] ?? '';
                    require_once __DIR__ . '/../components/Pagination.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>