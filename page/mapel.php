<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data mapel</h1>
      </div>
    </div>
  </div>
</div>

<?php
if(isset($_GET['action'])) {
  if($_GET['action'] == "hapus") {
    $kd = $_GET['kd'];
    $query = mysqli_query($koneksi, "DELETE FROM mapel WHERE kd_mapel = '$kd'");
    if ($query) {
      echo '
      <div class="alert alert-warning alert-dismissible">
        Berhasil Di Hapus
      </div>';
    }
  }
}
?>

<div class="container-fluid">
  <div class="card">
    <div class="card-body">

      <a href="index.php?page=tambah_mapel" class="btn btn-primary btn-sm">
        Tambah Mapel
      </a>

      <table class="table table-striped">
        <thead>
          <tr>
            <th>NO</th>
            <th>Kd mapel</th>
            <th>Nama mapel</th>
            <th>KKM</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <?php
        $no = 0;
        $query = mysqli_query($koneksi, "SELECT * FROM mapel");
        while ($result = mysqli_fetch_array($query)) {
          $no++;
        ?>

        <tbody>
          <tr>
            <td><?= $no; ?></td>
            <td><?= $result['kd_mapel']; ?></td>
            <td><?= $result['nm_mapel']; ?></td>
            <td><?= $result['kkm']; ?></td>
            <td>
              <!-- tombol aksi biasanya edit & hapus -->
            </td>
          </tr>
        </tbody>

        <?php } ?>

      </table>

    </div>
  </div>
</div>