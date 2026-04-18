<?php
// koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "jadwal", 3306);

if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Kelas</h1>
      </div>
    </div>
  </div>
</div>

<?php
// ================= DELETE DATA =================
if (isset($_GET['action']) && $_GET['action'] == "hapus") {

  if (isset($_GET['id']) && $_GET['id'] != "") {

    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    $hapus = mysqli_query($koneksi,
      "DELETE FROM kelas WHERE Id_kelas = '$id'"
    );

    if ($hapus) {
      echo "<script>
        alert('Data berhasil dihapus');
        window.location='index.php?page=kelas';
      </script>";
    } else {
      echo "<div class='alert alert-danger'>
        Gagal hapus: " . mysqli_error($koneksi) . "
      </div>";
    }
  }
}
?>

<div class="container-fluid">
  <div class="card">
    <div class="card-body">

      <!-- Tombol tambah -->
      <a href="index.php?page=tambah_kelas" class="btn btn-primary btn-sm mb-3">
        Tambah Kelas
      </a>

      <!-- Tabel data -->
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>ID Kelas</th>
            <th>Nama Kelas</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM kelas");

        if (!$query) {
          die("Query error: " . mysqli_error($koneksi));
        }

        while ($result = mysqli_fetch_assoc($query)) {
        ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $result['Id_kelas']; ?></td>
            <td><?= $result['Nm_kelas']; ?></td>
            <td>

              <!-- tombol edit -->
              <a href="index.php?page=edit_kelas&id=<?= $result['Id_kelas']; ?>" 
                 class="btn btn-warning btn-sm">
                Edit
              </a>

              <!-- tombol hapus -->
              <a href="index.php?page=kelas&action=hapus&id=<?= $result['Id_kelas']; ?>" 
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Yakin ingin menghapus data ini?')">
                Hapus
              </a>

            </td>
          </tr>
        <?php } ?>
        </tbody>

      </table>

    </div>
  </div>
</div>