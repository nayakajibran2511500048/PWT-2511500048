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

// PERBAIKAN 1: Cek session dengan huruf kecil 'username' sesuai yang dibuat saat login
if (!isset($_SESSION['username'])) {
    echo "<div class='alert alert-danger'>Silakan login dulu!</div>";
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['ganti'])) { // Mengganti nama post menjadi lebih relevan

    // Mengamankan input teks
    $pl  = mysqli_real_escape_string($koneksi, $_POST['pl']); // password lama
    $pb  = mysqli_real_escape_string($koneksi, $_POST['pb']); // password baru
    $pbc = mysqli_real_escape_string($koneksi, $_POST['pbc']); // konfirmasi password baru

    // Validasi apakah password baru dan konfirmasi sudah cocok
    if ($pb !== $pbc) {
        echo "<div class='alert alert-danger'>Konfirmasi password baru tidak cocok!</div>";
    } else {
        // Ambil data user dari database
        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
        $data  = mysqli_fetch_assoc($query);

        if ($data) {
            // Cek apakah password lama sesuai
            if ($data['password'] == $pl) {

                // Jalankan perintah update password
                $update = mysqli_query($koneksi, "UPDATE user SET password='$pb' WHERE username='$username'");

                if ($update) {
                    echo "<div class='alert alert-success'>Password berhasil diganti!</div>";
                    echo '<meta http-equiv="refresh" content="1;url=index.php?page=ganti_password">';
                } else {
                    echo "<div class='alert alert-danger'>Gagal mengupdate password ke database!</div>";
                }

            } else {
                echo "<div class='alert alert-danger'>Password lama salah!</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>User tidak ditemukan di database!</div>";
        }
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
            <input type="password" name="pl" class="form-control" placeholder="Masukkan password saat ini" required>
          </div>

          <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="pb" class="form-control" placeholder="Masukkan password baru" required>
          </div>

          <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="pbc" class="form-control" placeholder="Ulangi password baru" required>
          </div>

          <div class="form-group">
            <button type="submit" name="ganti" class="btn btn-primary btn-sm">
              Ganti Password
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</section>