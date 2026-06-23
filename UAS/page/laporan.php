<?php
if ($_SESSION['role'] != 'admin') {
    echo "<div class='alert alert-danger'>Akses ditolak.</div>";
    exit;
}

// Filter
$filter_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
$filter_user  = isset($_GET['id_user']) ? (int)$_GET['id_user'] : 0;

$where = "WHERE ad.tanggal LIKE '$filter_bulan%'";
if ($filter_user > 0) {
    $where .= " AND ad.id_user = '$filter_user'";
}

$query = mysqli_query($koneksi, "SELECT u.nama_lengkap, ad.tanggal, ad.jam_datang, ad.status_datang, ap.jam_pulang, ap.status_pulang
                                 FROM absen_datang ad
                                 JOIN user u ON ad.id_user = u.id_user
                                 LEFT JOIN absen_pulang ap ON ap.id_user = ad.id_user AND ap.tanggal = ad.tanggal
                                 $where
                                 ORDER BY ad.tanggal DESC, u.nama_lengkap ASC");

// Statistik
$total_hadir = mysqli_num_rows($query);
mysqli_data_seek($query, 0);

$stat_telat  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM absen_datang ad $where AND ad.status_datang='Telat'"));
$stat_ontime = $total_hadir - $stat_telat;

$daftar_pegawai = mysqli_query($koneksi, "SELECT id_user, nama_lengkap FROM user WHERE role='pegawai' ORDER BY nama_lengkap");
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Laporan Absensi</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Filter Laporan</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="index.php">
                    <input type="hidden" name="page" value="laporan">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bulan</label>
                                <input type="month" name="bulan" class="form-control" value="<?= $filter_bulan ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Pegawai</label>
                                <select name="id_user" class="form-control">
                                    <option value="0">-- Semua Pegawai --</option>
                                    <?php
                                    while ($p = mysqli_fetch_assoc($daftar_pegawai)) {
                                        $sel = ($filter_user == $p['id_user']) ? 'selected' : '';
                                        echo "<option value='{$p['id_user']}' $sel>{$p['nama_lengkap']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                                <a href="index.php?page=laporan" class="btn btn-default">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Ontime</span>
                        <span class="info-box-number"><?= $stat_ontime ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Telat</span>
                        <span class="info-box-number"><?= $stat_telat ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Absensi</span>
                        <span class="info-box-number"><?= $total_hadir ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rekap Absensi Bulan <?= date('F Y', strtotime($filter_bulan . '-01')) ?></h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Tanggal</th>
                            <th>Jam Datang</th>
                            <th>Status Datang</th>
                            <th>Jam Pulang</th>
                            <th>Status Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                $bd = $row['status_datang'] == 'Ontime' ? 'success' : 'warning';
                                $bp = $row['status_pulang'] == 'Ontime' ? 'success' : ($row['status_pulang'] == 'Pulang Cepat' ? 'danger' : 'secondary');
                                
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>" . htmlspecialchars($row['nama_lengkap']) . "</td>
                                    <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
                                    <td>{$row['jam_datang']}</td>
                                    <td><span class='badge badge-{$bd}'>{$row['status_datang']}</span></td>
                                    <td>" . ($row['jam_pulang'] ?? '-') . "</td>
                                    <td>" . ($row['status_pulang'] ? "<span class='badge badge-{$bp}'>{$row['status_pulang']}</span>" : '-') . "</td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Tidak ada data absensi untuk periode ini.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>