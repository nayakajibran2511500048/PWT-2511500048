<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Mata Pelajaran</h1>
      </div>
    </div>
  </div>
</div>

<?php
//kode otomatis
$cari_kode = mysqli_query($koneksi, "select max(kd_mapel) from mapel") or die(mysqli_error());
$data_kode = mysqli_fetch_array($cari_kode);

if ($datakode) {
  $nilaikode = substr($datakode[0], 2);
  $kode = (int) $nilaikode;
  $kode = $kode + 1;
  $hasilkode = "M-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
  $hasilkode = "M-";
}
$_SESSION['KODE'] = $hasilkode;

if (isset($_POST['tambah'])) {
  $kd_mapel = $_POST['kd_mapel'];
  $nm_mapel = $_POST['nm_mapel'];
  $kkm = $_POST['kkm'];

  $insert = mysqli_query($koneksi, "INSERT INTO mapel values ('$kd_mapel','$nm_mapel','$kkm')");
  if ($insert) {
    echo '<div class="alert alert-info-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-info"></i> Info</h5>
      <h4>Berhasil Disimpan</h4></div>';
    echo '<meta http-equiv="refresh" content="1;url=index.php?page=mapel">';
  } else {
    echo '<div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-info"></i> Info</h5>
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
              <label for="kd_mapel">Kode Mapel</label>
              <input type="text" name="kd_mapel" value="<?= $hasilkode; ?>" placeholder="Id Kat" class="form-control" readonly>
            </div>

            <div class="form-group">
              <label for="nm_mapel">Nama Mapel</label>
              <input type="text" name="nm_mapel" id="nm_mapel" placeholder="Nama Mapel" class="form-control">
            </div>

            <div class="form-group">
              <label for="kkm">KKM</label>
              <input type="text" name="kkm" id="kkm" placeholder="KKM" class="form-control">
            </div>

            <div class="card-footer">
              <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</section>