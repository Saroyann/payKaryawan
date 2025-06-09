<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../models/LaporanModel.php';

session_start();

$nama = $_SESSION['nama'] ?? '-';
$id_karyawan = $_SESSION['id_karyawan'] ?? '-';
$jabatan = $_SESSION['jabatan'] ?? '-';

$model = new LaporanModel();
$daftar_laporan = $model->getAllByKaryawan($id_karyawan);

$html = '
<style>
    body { font-family: Arial, sans-serif; font-size: 12pt; }
    .ttd { width: 45%; display: inline-block; text-align: center; }
    .ttd-space { width: 10%; display: inline-block; }
</style>
<h2 style="text-align:center;">Laporan Pekerjaan</h2>
<table style="width:100%;margin-bottom:10px;">
    <tr><td>Nama</td><td>: ' . $nama . '</td></tr>
    <tr><td>ID Karyawan</td><td>: ' . $id_karyawan . '</td></tr>
    <tr><td>Jabatan</td><td>: ' . $jabatan . '</td></tr>
</table>
<b>Daftar Laporan:</b>
<ol>';
foreach ($daftar_laporan as $laporan) {
    $html .= '<li>' . htmlspecialchars($laporan['isi_laporan']) . '</li>';
}
$html .= '</ol>
<br><br><br><br>
<div style="position: fixed; bottom: 40px; width: 100%;">
    <table style="width:100%;">
        <tr>
            <td style="width:45%; text-align:center;">
                Mengetahui,<br><br><br><br><br><br>
                (........................................)<br>
                ' . $nama . '
            </td>
            <td style="width:10%;">&nbsp;</td>
            <td style="width:45%; text-align:center;">
                Disetujui,<br><br><br><br><br><br>
                (........................................)<br>
                Direktur
            </td>
        </tr>
    </table>
</div>
';

$mpdf = new \Mpdf\Mpdf([
    'orientation' => 'P', 
    'tempDir' => '/tmp',  
]);
$mpdf->WriteHTML($html);
$mpdf->Output('laporan_pekerjaan.pdf', 'I');
exit;
