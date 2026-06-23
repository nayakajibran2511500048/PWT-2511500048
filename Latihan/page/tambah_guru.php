<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Guru</h1>
            </div>
        </div>
    </div>
</div>

<?php
// AUTO KODE GURU 
$query = mysqli_query($koneksi, "SELECT MAX(Kd_guru) as kodeTerbesar FROM guru");
$data = mysqli_fetch_array($query);

$kodeGuru = $data['kodeTerbesar'];

if ($kodeGuru) {
    $urutan = (int) substr($kodeGuru, 1, 3);
    $urutan++;
} else {
    $urutan = 1;
}

$kodeGuru = "G" . sprintf("%03d", $urutan);

// PROSES SIMPAN
if(isset($_POST['tambah'])){
    $Kd_guru = $kodeGuru;
    $Nm_guru = $_POST['Nm_guru'];
    $Jenkel = $_POST['Jenkel'];
    $Pend_terakhir = $_POST['Pend_terakhir'];
    $Hp = $_POST['Hp'];
    $Alamat = $_POST['Alamat'];

    $Password = '12345'; // ✅  PASSWORD

    $insert = mysqli_query($koneksi,"INSERT INTO guru 
    (Kd_guru, Nm_guru, Jenkel, Pend_terakhir, Hp, Alamat, password) 
    VALUES (
        '$Kd_guru',
        '$Nm_guru',
        '$Jenkel',
        '$Pend_terakhir',
        '$Hp',
        '$Alamat',
        '$Password'
    )");

     $username = $_POST['username'];
    $password = $_POST['password'];
    $role = "guru";

    $insert = mysqli_query($koneksi,"INSERT INTO guru values ('$Kd_guru','$Nm_guru','$Jenkel','$Pend_terakhir','$Hp','$Alamat')");

    $insert = mysqli_query($koneksi,"INSERT INTO user (username, password, role) values ('$username','$password','$role')");
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=guru">';
    } else {
        echo '<div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Gagal Disimpan</h4></div>';
    }
}

?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-body p-2">
                    <form method="POST" action="">
                        
                        <div class="form-group">
                            <label>Kd Guru</label>
                            <!-- FIX DI SINI -->
                            <input type="text" name="Kd_guru" value="<?= $kodeGuru; ?>" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input type="text" name="Nm_guru" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="Jenkel" class="form-control">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pendidikan Terakhir</label>
                            <input type="text" name="Pend_terakhir" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>No HP</label>
                            <input type="text" name="Hp" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="Alamat" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" placeholder="Username" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                        </div>


                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name="tambah" value="Simpan">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>