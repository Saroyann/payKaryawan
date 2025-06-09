<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../models/RekapGajiModel.php';

$model = new RekapGajiModel();
$dataGaji = $model->getPage(10000, 0); // Ambil semua data

$html = '<h2 style="text-align:center;">Rekap Gaji Karyawan</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>ID Karyawan</th>
            <th>Jabatan</th>
            <th>Gaji</th>
        </tr>
    </thead>
    <tbody>';
foreach ($dataGaji as $i => $gaji) {
    $html .= '<tr>
        <td>' . ($i + 1) . '</td>
        <td>' . htmlspecialchars($gaji['nama']) . '</td>
        <td>' . htmlspecialchars($gaji['id_karyawan']) . '</td>
        <td>' . htmlspecialchars($gaji['jabatan']) . '</td>
        <td>Rp.' . number_format($gaji['gaji'], 0, ',', '.') . '</td>
    </tr>';
}
$html .= '</tbody></table>';

$mpdf = new \Mpdf\Mpdf([
    'orientation' => 'L',
    'tempDir' => '/tmp',

]);
$mpdf->WriteHTML($html);
$mpdf->Output('rekap_gaji.pdf', 'I');