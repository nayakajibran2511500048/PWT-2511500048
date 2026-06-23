<?php
// 1. Tangkap parameter Id_jadwal dari URL (misal: detail_jadwal.php?Id_jadwal=1)
if (!isset($_GET['Id_jadwal']) || empty($_GET['Id_jadwal'])) {
    echo "<div class='alert alert-danger m-3'>ID Jadwal tidak ditemukan! Silakan kembali ke menu utama.</div>";
    exit;
}

$id_jadwal = mysqli_real_escape_string($koneksi, $_GET['Id_jadwal']);

// 2. Ambil data utama HANYA untuk ID yang sedang dibuka
$hasil = mysqli_query($koneksi, "SELECT * FROM jadwal_kelas WHERE Id_jadwal = '$id_jadwal'");
$data = mysqli_fetch_array($hasil);

if (!$data) {
    echo "<div class='alert alert-danger m-3'>Data jadwal tidak ditemukan di database.</div>";
    exit;
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <br>
                
                <a href="cetak.php?Id_jadwal=<?= $id_jadwal; ?>" target="_blank" class="btn btn-danger mb-3">
                    <i class="fas fa-file-pdf"></i> Download PDF
                </a>
                
                <table class="mb-3">
                    <tr>
                        <td>Tahun Ajaran</td>
                        <td>:</td>
                        <td>&nbsp;</td>
                        <td><?= htmlspecialchars($data['Thn_ajaran']); ?></td>
                    </tr>
                    <tr>
                        <td>Semester</td>
                        <td>:</td>
                        <td>&nbsp;</td>
                        <td><?= htmlspecialchars($data['Semester']); ?></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>&nbsp;</td>
                        <td><?= htmlspecialchars($data['Kelas']); ?></td>
                    </tr>
                </table>
                
                <br><strong>DETAIL JADWAL KELAS</strong>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Kd Mapel</th>
                            <th>Nama Mapel</th>
                            <th>Nama Guru</th>
                            <th>Hari</th>
                            <th>Jam</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                        $no = 0;
                        // PERBAIKAN: Menambahkan WHERE agar hanya menampilkan detail milik kelas ini saja
                        $query = mysqli_query($koneksi, "SELECT * FROM detail_jadwal
                            JOIN mapel ON mapel.Kd_mapel = detail_jadwal.Kd_mapel
                            JOIN guru ON guru.Kd_guru = detail_jadwal.Kd_guru
                            WHERE detail_jadwal.Id_jadwal = '$id_jadwal'");
                        
                        while ($result = mysqli_fetch_array($query)) {
                            $no++;
                            ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= htmlspecialchars($result['Kd_mapel']); ?></td>
                                <td><?= htmlspecialchars($result['Nm_mapel']); ?></td>
                                <td><?= htmlspecialchars($result['Nm_guru']); ?></td>
                                <td><?= htmlspecialchars($result['Hari']); ?></td>
                                <td><?= htmlspecialchars($result['Jam_mulai']); ?> s.d <?= htmlspecialchars($result['Jam_selesai']); ?></td>
                            </tr>
                        <?php } 
                        
                        if ($no === 0) {
                            echo "<tr><td colspan='6' class='text-center'>Belum ada data detail jadwal pelajaran untuk kelas ini.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>