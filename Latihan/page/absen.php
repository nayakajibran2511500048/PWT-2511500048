<?php
date_default_timezone_set('Asia/Jakarta');

// Ambil data user yang login
$query_user = mysqli_query($koneksi, "SELECT id_user, nama_lengkap FROM user WHERE username='{$_SESSION['username']}'");
$data_user  = mysqli_fetch_assoc($query_user);
$id_user    = $data_user['id_user'];

$today        = date('Y-m-d');
$hari_ini     = date('l');
$jam_sekarang = date('H:i:s');

// Map hari
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

// Ambil jam kerja hari ini
$jam_kerja = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM jam_kerja WHERE hari='$hari_indo'"));

// Cek absen datang & pulang hari ini
$cek_datang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM absen_datang WHERE id_user='$id_user' AND tanggal='$today'"));
$cek_pulang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM absen_pulang WHERE id_user='$id_user' AND tanggal='$today'"));

// Proses absen datang
if (isset($_POST['absen_datang'])) {
    if (!$jam_kerja) {
        $pesan = "<div class='alert alert-warning'>Tidak ada jam kerja hari ini.</div>";
    } elseif ($cek_datang) {
        $pesan = "<div class='alert alert-warning'>Anda sudah absen datang hari ini pukul {$cek_datang['jam_datang']}.</div>";
    } else {
        $status = ($jam_sekarang <= $jam_kerja['jam_masuk_batas']) ? 'Ontime' : 'Telat';
        $insert = mysqli_query($koneksi, "INSERT INTO absen_datang (id_user, tanggal, jam_datang, status_datang) VALUES ('$id_user', '$today', '$jam_sekarang', '$status')");
        
        if ($insert) {
            $pesan = "<div class='alert alert-success'>Absen datang berhasil! Jam: $jam_sekarang | Status: $status</div>";
            $cek_datang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM absen_datang WHERE id_user='$id_user' AND tanggal='$today'"));
        } else {
            $pesan = "<div class='alert alert-danger'>Gagal menyimpan absen datang.</div>";
        }
    }
}

// Proses absen pulang
if (isset($_POST['absen_pulang'])) {
    if (!$cek_datang) {
        $pesan = "<div class='alert alert-warning'>Anda belum absen datang hari ini.</div>";
    } elseif ($cek_pulang) {
        $pesan = "<div class='alert alert-warning'>Anda sudah absen pulang hari ini pukul {$cek_pulang['jam_pulang']}.</div>";
    } else {
        $status_pulang = ($jam_sekarang >= $jam_kerja['jam_pulang_mulai']) ? 'Ontime' : 'Pulang Cepat';
        $insert = mysqli_query($koneksi, "INSERT INTO absen_pulang (id_user, tanggal, jam_pulang, status_pulang) VALUES ('$id_user', '$today', '$jam_sekarang', '$status_pulang')");
        
        if ($insert) {
            $pesan = "<div class='alert alert-success'>Absen pulang berhasil! Jam: $jam_sekarang | Status: $status_pulang</div>";
            $cek_pulang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM absen_pulang WHERE id_user='$id_user' AND tanggal='$today'"));
        } else {
            $pesan = "<div class='alert alert-danger'>Gagal menyimpan absen pulang.</div>";
        }
    }
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Absensi</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <?php if (isset($pesan)) echo $pesan; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Info Hari Ini</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Hari:</strong> <?= $hari_indo ?>, <?= date('d-m-Y') ?></p>
                        <p><strong>Jam Sekarang:</strong> <?= date('H:i:s') ?></p>
                        <?php if ($jam_kerja): ?>
                            <p><strong>Jam Masuk:</strong> <?= $jam_kerja['jam_masuk_mulai'] ?> - <?= $jam_kerja['jam_masuk_batas'] ?></p>
                            <p><strong>Jam Pulang:</strong> <?= $jam_kerja['jam_pulang_mulai'] ?></p>
                        <?php else: ?>
                            <div class="alert alert-warning">Tidak ada jam kerja hari ini.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Absen Datang</h3>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($cek_datang): ?>
                            <p class="text-success"><i class="fas fa-check-circle fa-3x"></i></p>
                            <p><strong>Sudah Absen Datang</strong></p>
                            <p>Jam: <strong><?= $cek_datang['jam_datang'] ?></strong></p>
                            <p>Status: <span class="badge badge-<?= $cek_datang['status_datang'] == 'Ontime' ? 'success' : 'warning' ?>"><?= $cek_datang['status_datang'] ?></span></p>
                        <?php else: ?>
                            <p class="text-secondary"><i class="fas fa-times-circle fa-3x"></i></p>
                            <p>Belum absen datang</p>
                            <?php if ($jam_kerja): ?>
                                <form method="POST">
                                    <button type="submit" name="absen_datang" class="btn btn-success btn-block" onclick="return confirm('Absen datang sekarang?')">
                                        <i class="fas fa-sign-in-alt"></i> Absen Datang Sekarang
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Absen Pulang</h3>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($cek_pulang): ?>
                            <p class="text-danger"><i class="fas fa-check-circle fa-3x"></i></p>
                            <p><strong>Sudah Absen Pulang</strong></p>
                            <p>Jam: <strong><?= $cek_pulang['jam_pulang'] ?></strong></p>
                            <p>Status: <span class="badge badge-<?= $cek_pulang['status_pulang'] == 'Ontime' ? 'success' : 'danger' ?>"><?= $cek_pulang['status_pulang'] ?></span></p>
                        <?php elseif (!$cek_datang): ?>
                            <p class="text-secondary"><i class="fas fa-lock fa-3x"></i></p>
                            <p>Absen datang dulu sebelum absen pulang</p>
                        <?php else: ?>
                            <p class="text-secondary"><i class="fas fa-times-circle fa-3x"></i></p>
                            <p>Belum absen pulang</p>
                            <form method="POST">
                                <button type="submit" name="absen_pulang" class="btn btn-danger btn-block" onclick="return confirm('Absen pulang sekarang?')">
                                    <i class="fas fa-sign-out-alt"></i> Absen Pulang Sekarang
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>