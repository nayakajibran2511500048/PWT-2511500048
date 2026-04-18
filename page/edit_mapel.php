<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Mata Pelajaran</h1>
      </div>
    </div>
  </div>
</div>

<?php
// ambil id dari URL
$kd = $_GET['kd'];

// ambil data mapel
$query = mysqli_query($koneksi, "SELECT * FROM mapel WHERE kd_mapel = '$kd'");
$data = mysqli_fetch_array($query);

// proses update
if (isset($_POST['ubah'])) {

  $kd_mapel = $_POST['kd_mapel'];
  $nm_mapel = $_POST['nm_mapel'];
  $kkm      = $_POST['kkm'];

  $update = mysqli_query($koneksi,
    "UPDATE mapel SET 
      nm_mapel = '$nm_mapel',
      kkm = '$kkm'
     WHERE kd_mapel = '$kd_mapel'"
  );

  if ($update) {
    echo '
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <h5><i class="icon fas fa-check"></i> Info</h5>
      <h4>Berhasil Disimpan</h4>
    </div>';

    echo '<meta http-equiv="refresh" content="1;url=index.php?page=mapel">';
  } else {
    echo '
    <div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <h5><i class="icon fas fa-times"></i> Info</h5>
      <h4>Gagal Disimpan</h4>
    </div>';
  }
}
?>

<!-- FORM EDIT -->
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">

        <form method="POST">

          <div class="form-group">
            <label>Kode Mapel</label>
            <input type="text" name="kd_mapel"
                   value="<?= $data['kd_mapel']; ?>"
                   class="form-control" readonly>
          </div>

          <div class="form-group">
            <label>Nama Mapel</label>
            <input type="text" name="nm_mapel"
                   value="<?= $data['nm_mapel']; ?>"
                   class="form-control">
          </div>

          <div class="form-group">
            <label>KKM</label>
            <input type="number" name="kkm"
                   value="<?= $data['kkm']; ?>"
                   class="form-control">
          </div>

          <button type="submit" name="ubah" class="btn btn-primary">
            Update
          </button>

        </form>

      </div>
    </div>
  </div>
</section>