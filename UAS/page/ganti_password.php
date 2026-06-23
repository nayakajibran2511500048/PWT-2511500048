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
include 'config /koneksi.php';
$username = $_SESSION['username'];

if (isset($_POST['tambah'])) {
    $pl = $_POST['pl'];
    $pb = $_POST['pb'];

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {

        if ($data['password'] == $pl) {

            $update = mysqli_query($koneksi, "UPDATE user SET password='$pb' WHERE username='$username'");

            if ($update) {
                echo "<div class='alert alert-success'>Password berhasil diganti!</div>";
                echo '<meta http-equiv="refresh" content="1;url=index.php?page=ganti_password">';
            } else {
                echo "<div class='alert alert-danger'>Gagal update password!</div>";
                echo '<meta http-equiv="refresh" content="1;url=index.php?page=ganti_password">';
            }

        } else {
            echo "<div class='alert alert-danger'>Password lama salah!</div>";
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=ganti_password">';
        }
    }
}
?>

<div class="content-header">
  <div class="container-fluid"></div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">

        <form method="POST" action="">
          <div class="form-group">
            <label for="pl">Password Lama</label>
            <input type="password" name="pl" id="pl" placeholder="Password Lama" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="pb">Password Baru</label>
            <input type="password" name="pb" id="pb" placeholder="Password Baru" class="form-control" required>
          </div>

          <div class="form-group">
            <input type="submit" name="tambah" value="Ganti Password" class="btn btn-primary btn-sm">
          </div>
        </form>

      </div>
    </div>
  </div>
</section>