<?php
// Ambil id_user yang login
$query_user   = mysqli_query($koneksi, "SELECT id_user, nama_lengkap FROM user WHERE username='{$_SESSION['username']}'");
$data_user    = mysqli_fetch_assoc($query_user);
$id_user      = $data_user['id_user'];
$nama_pegawai = $data_user['nama_lengkap'];

// Filter bulan
$filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');

$query = mysqli_query($koneksi, "SELECT ad.tanggal, ad.jam_datang, ad.status_datang, ap.jam_pulang, ap.status_pulang
                                 FROM absen_datang ad
                                 LEFT JOIN absen_pulang ap ON ap.id_user = ad.id_user AND ap.tanggal = ad.tanggal
                                 WHERE ad.id_user = '$id_user' AND ad.tanggal LIKE '$filter_bulan%'
                                 ORDER BY ad.tanggal DESC");

$total        = mysqli_num_rows($query);
$telat        = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absen_datang WHERE id_user='$id_user' AND tanggal LIKE '$filter_bulan%' AND status_datang='Telat'"));
$ontime       = $total - $telat;
$pulang_cepat = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absen_pulang WHERE id_user='$id_user' AND tanggal LIKE '$filter_bulan%' AND status_pulang='Pulang Cepat'"));
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Riwayat Absen</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Filter Bulan</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="index.php" class="form-inline">
                    <input type="hidden" name="page" value="riwayat">
                    <div class="form-group mr-2">
                        <label class="mr-2">Bulan:</label>
                        <input type="month" name="bulan" class="form-control" value="<?= $filter_bulan ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan</button>
                    <a href="index.php?page=riwayat" class="btn btn-default ml-2">Reset</a>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Hadir</span>
                        <span class="info-box-number"><?= $total ?> hari</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ontime</span>
                        <span class="info-box-number"><?= $ontime ?> hari</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Telat</span>
                        <span class="info-box-number"><?= $telat ?> hari</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-danger">
                    <span class="info-box-icon"><i class="fas fa-sign-out-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pulang Cepat</span>
                        <span class="info-box-number"><?= $pulang_cepat ?> hari</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Absen - <?= htmlspecialchars($nama_pegawai) ?> (<?= date('F Y', strtotime($filter_bulan . '-01')) ?>)</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Jam Datang</th>
                            <th>Status Datang</th>
                            <th>Jam Pulang</th>
                            <th>Status Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $map_hari = [
                            'Monday'    => 'Senin', 
                            'Tuesday'   => 'Selasa', 
                            'Wednesday' => 'Rabu',
                            'Thursday'  => 'Kamis', 
                            'Friday'    => 'Jumat', 
                            'Saturday'  => 'Sabtu', 
                            'Sunday'    => 'Minggu'
                        ];
                        $no = 1;
                        
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                $hari = $map_hari[date('l', strtotime($row['tanggal']))] ?? '-';
                                $bd   = $row['status_datang'] == 'Ontime' ? 'success' : 'warning';
                                $bp   = $row['status_pulang'] == 'Ontime' ? 'success' : ($row['status_pulang'] == 'Pulang Cepat' ? 'danger' : 'secondary');
                                
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
                                    <td>{$hari}</td>
                                    <td>{$row['jam_datang']}</td>
                                    <td><span class='badge badge-{$bd}'>{$row['status_datang']}</span></td>
                                    <td>" . ($row['jam_pulang'] ?? '-') . "</td>
                                    <td>" . ($row['status_pulang'] ? "<span class='badge badge-{$bp}'>{$row['status_pulang']}</span>" : '-') . "</td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Tidak ada riwayat absen bulan ini.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>