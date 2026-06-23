<?php
date_default_timezone_set('Asia/Jakarta');

// Hitung total pegawai
$total_pegawai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE role='pegawai'"));

// Hitung absen hari ini
$today          = date('Y-m-d');
$hadir_hari_ini = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absen_datang WHERE tanggal='$today'"));
$telat_hari_ini = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absen_datang WHERE tanggal='$today' AND status_datang='Telat'"));
$pulang_cepat   = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absen_pulang WHERE tanggal='$today' AND status_pulang='Pulang Cepat'"));
?>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $total_pegawai ?></h3>
                <p>Total Pegawai</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="index.php?page=pegawai" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $hadir_hari_ini ?></h3>
                <p>Hadir Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <a href="index.php?page=laporan" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $telat_hari_ini ?></h3>
                <p>Telat Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
            <a href="index.php?page=laporan" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $pulang_cepat ?></h3>
                <p>Pulang Cepat</p>
            </div>
            <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
            <a href="index.php?page=laporan" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Absensi Hari Ini (<?= date('d-m-Y') ?>)</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Jam Datang</th>
                            <th>Status Datang</th>
                            <th>Jam Pulang</th>
                            <th>Status Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT u.nama_lengkap, ad.jam_datang, ad.status_datang, ap.jam_pulang, ap.status_pulang
                                                         FROM absen_datang ad
                                                         JOIN user u ON ad.id_user = u.id_user
                                                         LEFT JOIN absen_pulang ap ON ap.id_user = ad.id_user AND ap.tanggal = ad.tanggal
                                                         WHERE ad.tanggal = '$today'
                                                         ORDER BY ad.jam_datang ASC");
                        $no = 1;
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                $badge_datang = $row['status_datang'] == 'Ontime' ? 'success' : 'warning';
                                $badge_pulang = $row['status_pulang'] == 'Ontime' ? 'success' : ($row['status_pulang'] == 'Pulang Cepat' ? 'danger' : 'secondary');
                                
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama_lengkap']}</td>
                                    <td>{$row['jam_datang']}</td>
                                    <td><span class='badge badge-{$badge_datang}'>{$row['status_datang']}</span></td>
                                    <td>" . ($row['jam_pulang'] ?? '-') . "</td>
                                    <td>" . ($row['status_pulang'] ? "<span class='badge badge-{$badge_pulang}'>{$row['status_pulang']}</span>" : '-') . "</td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Belum ada absensi hari ini</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>