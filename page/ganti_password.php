<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Ganti Password</h1>
      </div>
    </div>
  </div>
</div>

<?php

include 'config/koneksi.php';

// cek session
if (!isset($_SESSION['Username'])) {
    echo "<div class='alert alert-danger'>Silakan login dulu!</div>";
    exit;
}

$username = $_SESSION['Username'];

if (isset($_POST['tambah'])) {

    $pl = $_POST['pl']; // password lama
    $pb = $_POST['pb']; // password baru

    // ambil data user
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {

        // cek password lama
        if ($data['password'] == $pl) {

            // update password
            $update = mysqli_query($koneksi, "UPDATE user SET password='$pb' WHERE username='$username'");

            if ($update) {
                echo "<div class='alert alert-success'>Password berhasil diganti!</div>";
                echo '<meta http-equiv="refresh" content="1;url=index.php?page=ganti_password">';
            } else {
                echo "<div class='alert alert-danger'>Gagal update password!</div>";
            }

        } else {
            echo "<div class='alert alert-danger'>Password lama salah!</div>";
        }

    } else {
        echo "<div class='alert alert-danger'>User tidak ditemukan!</div>";
    }
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">

        <form method="POST">
          <div class="form-group">
            <label>Password Lama</label>
            <input type="password" name="pl" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="pb" class="form-control" required>
          </div>

          <div class="form-group">
            <button type="submit" name="tambah" class="btn btn-primary btn-sm">
              Ganti Password
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</section>