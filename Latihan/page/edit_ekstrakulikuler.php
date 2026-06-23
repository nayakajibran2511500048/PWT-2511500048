<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Ekstrakurikuler</h1>
      </div>
    </div>
  </div>
</div>

<?php
// ambil id dari URL
$kd = $_GET['kd'];

// ambil data ekstra
$query = mysqli_query($koneksi, "SELECT * FROM ekstrakulikuler WHERE id_ekstra = '$kd'");
$data = mysqli_fetch_array($query);

// proses update
if (isset($_POST['ubah'])) {

  $id_ekstra   = $_POST['id_ekstra'];
  $nama_ekstra = $_POST['nama_ekstra'];
  $ket         = $_POST['ket'];
  $semester    = $_POST['semester'];
  $thn_ajaran  = $_POST['thn_ajaran'];

  $update = mysqli_query($koneksi,
    "UPDATE ekstrakulikuler SET 
      nama_ekstra = '$nama_ekstra',
      ket = '$ket',
      semester = '$semester',
      thn_ajaran = '$thn_ajaran'
     WHERE id_ekstra = '$id_ekstra'"
  );

  if ($update) {
    echo '
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <h5><i class="icon fas fa-check"></i> Info</h5>
      <h4>Berhasil Disimpan</h4>
    </div>';

    echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstrakulikuler">';
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
            <label>ID Ekstra</label>
            <input type="text" name="id_ekstra"
                   value="<?= $data['id_ekstra']; ?>"
                   class="form-control" readonly>
          </div>

          <div class="form-group">
            <label>Nama Ekstra</label>
            <input type="text" name="nama_ekstra"
                   value="<?= $data['nama_ekstra']; ?>"
                   class="form-control">
          </div>

          <div class="form-group">
            <label>Keterangan</label>
            <input type="text" name="ket"
                   value="<?= $data['ket']; ?>"
                   class="form-control">
          </div>

          <div class="form-group">
            <label>Semester</label>
            <input type="text" name="semester"
                   value="<?= $data['semester']; ?>"
                   class="form-control">
          </div>

          <div class="form-group">
            <label>Tahun Ajaran</label>
            <input type="text" name="thn_ajaran"
                   value="<?= $data['thn_ajaran']; ?>"
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