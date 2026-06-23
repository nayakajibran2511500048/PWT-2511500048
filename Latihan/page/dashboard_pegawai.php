<?php
date_default_timezone_set('Asia/Jakarta');

$id_user_sesi = null;
$query_user   = mysqli_query($koneksi, "SELECT id_user, nama_lengkap FROM user WHERE username='{$_SESSION['username']}'");
$data_user    = mysqli_fetch_assoc($query_user);
$id_user_sesi = $data_user['id_user'];
$nama_pegawai = $data_user['nama_lengkap'];

$today    = date('Y-m-d');
$hari_ini = date('l');

// Map hari Inggris ke Indonesia
$map_hari = [
    'Monday'    => 'Senin', 
    'Tuesday'   => 'Selasa', 
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis', 
    'Friday'    => 'Jumat', 
    'Saturday'  => 'Sabtu', 
    'Sunday'    => 'Minggu'
];
$hari_indo = $map_hari[$hari_ini] ?? $hari_ini;

// Cek status absen hari ini
$absen_datang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM absen_datang WHERE id_user='$id_user_sesi' AND tanggal='$today'"));
$absen_pulang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM absen_pulang WHERE id_user='$id_user_sesi' AND tanggal='$today'"));

// Statistik bulan ini
$bulan              = date('Y-m');
$total_hadir        = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absen_datang WHERE id_user='$id_user_sesi' AND tanggal LIKE '$bulan%'"));
$total_telat        = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absen_datang WHERE id_user='$id_user_sesi' AND tanggal LIKE '$bulan%' AND status_datang='Telat'"));
$total_pulang_cepat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absen_pulang WHERE id_user='$id_user_sesi' AND tanggal LIKE '$bulan%' AND status_pulang='Pulang Cepat'"));

// Jam kerja hari ini
$jam_kerja = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM jam_kerja WHERE hari='$hari_indo'"));
?>

<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-info">
            <h5><i class="icon fas fa-info"></i> Selamat Datang, <?= htmlspecialchars($nama_pegawai) ?>!</h5>
            Hari ini: <strong><?= $hari_indo ?>, <?= date('d-m-Y') ?></strong>
            <?php if ($jam_kerja): ?>
                &nbsp;|&nbsp; Jam Masuk: <strong><?= $jam_kerja['jam_masuk_mulai'] ?> - <?= $jam_kerja['jam_masuk_batas'] ?></strong>
                &nbsp;|&nbsp; Jam Pulang: <strong><?= $jam_kerja['jam_pulang_mulai'] ?></strong>
            <?php else: ?>
                &nbsp;|&nbsp; <span class="text-warning">Tidak ada jam kerja hari ini</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-<?= $absen_datang ? 'success' : 'secondary' ?>">
            <div class="inner">
                <h3><?= $absen_datang ? $absen_datang['jam_datang'] : '-' ?></h3>
                <p>Absen Datang Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-sign-in-alt"></i></div>
            <a href="index.php?page=riwayat" class="small-box-footer">
                <?= $absen_datang ? 'Status: ' . $absen_datang['status_datang'] : 'Belum Absen' ?>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-<?= $absen_pulang ? 'danger' : 'secondary' ?>">
            <div class="inner">
                <h3><?= $absen_pulang ? $absen_pulang['jam_pulang'] : '-' ?></h3>
                <p>Absen Pulang Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
            <a href="index.php?page=riwayat" class="small-box-footer">
                <?= $absen_pulang ? 'Status: ' . $absen_pulang['status_pulang'] : 'Belum Absen' ?>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $total_hadir ?></h3>
                <p>Hadir Bulan Ini</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-check"></i></div>
            <a href="index.php?page=riwayat" class="small-box-footer">Lihat Riwayat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $total_telat ?></h3>
                <p>Telat Bulan Ini</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
            <a href="index.php?page=riwayat" class="small-box-footer">Lihat Riwayat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Absen 5 Hari Terakhir</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Datang</th>
                            <th>Status Datang</th>
                            <th>Jam Pulang</th>
                            <th>Status Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $riwayat = mysqli_query($koneksi, "SELECT ad.tanggal, ad.jam_datang, ad.status_datang, ap.jam_pulang, ap.status_pulang
                                                           FROM absen_datang ad
                                                           LEFT JOIN absen_pulang ap ON ap.id_user = ad.id_user AND ap.tanggal = ad.tanggal
                                                           WHERE ad.id_user = '$id_user_sesi'
                                                           ORDER BY ad.tanggal DESC LIMIT 5");
                        if (mysqli_num_rows($riwayat) > 0) {
                            while ($r = mysqli_fetch_assoc($riwayat)) {
                                $bd = $r['status_datang'] == 'Ontime' ? 'success' : 'warning';
                                $bp = $r['status_pulang'] == 'Ontime' ? 'success' : ($r['status_pulang'] == 'Pulang Cepat' ? 'danger' : 'secondary');
                                
                                echo "<tr>
                                    <td>" . date('d-m-Y', strtotime($r['tanggal'])) . "</td>
                                    <td>{$r['jam_datang']}</td>
                                    <td><span class='badge badge-{$bd}'>{$r['status_datang']}</span></td>
                                    <td>" . ($r['jam_pulang'] ?? '-') . "</td>
                                    <td>" . ($r['status_pulang'] ? "<span class='badge badge-{$bp}'>{$r['status_pulang']}</span>" : '-') . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Belum ada riwayat absen</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>