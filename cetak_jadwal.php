<?php
// Pastikan tidak ada spasi atau baris kosong sebelum tag php ini
require 'vendor/autoload.php';
include 'config/koneksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// 1. Validasi parameter URL yang dikirim dari halaman detail (Id_jadwal)
if (!isset($_GET['Id_jadwal']) || empty($_GET['Id_jadwal'])) {
    die("ID jadwal tidak ditemukan atau parameter salah.");
}

// Amankan variabel dari SQL Injection
$Id_jadwal = mysqli_real_escape_string($koneksi, $_GET['Id_jadwal']);

// 2. Ambil data utama dari tabel 'jadwal_kelas' sesuai nama di database Anda
$query = mysqli_query($koneksi, "SELECT * FROM jadwal_kelas WHERE Id_jadwal = '$Id_jadwal'");
$data = mysqli_fetch_assoc($query);

// Proteksi jika data utama kosong / tidak ada di database
if (!$data) {
    die("Data jadwal utama dengan ID tersebut tidak ditemukan di database.");
}

// 3. Ambil relasi detail jadwal (gabung ke mapel dan guru)
$det = mysqli_query($koneksi, "SELECT * FROM detail_jadwal 
    JOIN mapel ON mapel.Kd_mapel = detail_jadwal.Kd_mapel
    JOIN guru ON guru.Kd_guru = detail_jadwal.Kd_guru 
    WHERE detail_jadwal.Id_jadwal = '$Id_jadwal'");

// 4. Struktur HTML yang akan diubah menjadi PDF
$html = "
<style>
body {
    font-family: Arial, sans-serif;
    font-size: 12px;
    color: #333;
}
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 15px;
}
th, td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
}
th {
    background-color: #ff0000;
    color: white;
    font-weight: bold;
}
h3 {
    text-align: center;
    margin-bottom: 5px;
}
.identity-table {
    margin-bottom: 20px;
}
.identity-table td {
    border: none !important;
    text-align: left !important;
    padding: 4px;
}
</style>

<h3>JADWAL PELAJARAN SEKOLAH</h3>
<hr>

<table class='identity-table'>
    <tr>
        <td width='120'>Tahun Ajaran</td>
        <td width='10'>:</td>
        <td>" . htmlspecialchars($data['Thn_ajaran']) . "</td>
    </tr>
    <tr>
        <td>Semester</td>
        <td>:</td>
        <td>" . htmlspecialchars($data['Semester']) . "</td>
    </tr>
    <tr>
        <td>Kelas</td>
        <td>:</td>
        <td>" . htmlspecialchars($data['Kelas']) . "</td>
    </tr>
</table>

<table>
<thead>
    <tr>
        <th width='5%'>NO</th>
        <th width='15%'>Kode Mapel</th>
        <th>Nama Mata Pelajaran</th>
        <th>Nama Guru</th>
        <th width='15%'>Hari</th>
        <th width='20%'>Jam</th>
    </tr>
</thead>
<tbody>
";

// Looping isi data detail
$no = 0;
while ($d = mysqli_fetch_assoc($det)) {
    $no++;
    $html .= "
    <tr>
        <td>{$no}</td>
        <td>" . htmlspecialchars($d['Kd_mapel']) . "</td>
        <td>" . htmlspecialchars($d['Nm_mapel']) . "</td>
        <td>" . htmlspecialchars($d['Nm_guru']) . "</td>
        <td>" . htmlspecialchars($d['Hari']) . "</td>
        <td>" . htmlspecialchars($d['Jam_mulai']) . " s.d " . htmlspecialchars($d['Jam_selesai']) . "</td>
    </tr>
    ";
}

// Jika detail jadwal ternyata masih kosong di database
if ($no === 0) {
    $html .= "<tr><td colspan='6'>Belum ada detail data pelajaran untuk jadwal kelas ini.</td></tr>";
}

$html .= "
</tbody>
</table>";

// 5. Eksekusi Render DOMPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); 

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Bersihkan buffer keluaran PHP sebelum file PDF dilempar ke browser
if (ob_get_length()) ob_end_clean();

// Tampilkan PDF langsung di browser tab baru
$dompdf->stream("jadwal_kelas_" . $Id_jadwal . ".pdf", array("Attachment" => false));
exit;
?>