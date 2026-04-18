<?php
// pastikan session aktif
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "jadwal");

if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// ================== AUTO KODE ==================
$cari_kode = mysqli_query($koneksi, "
  SELECT MAX(CAST(SUBSTRING(kd_mapel, 3) AS UNSIGNED)) AS kode 
  FROM mapel
") or die(mysqli_error($koneksi));

$data_kode = mysqli_fetch_assoc($cari_kode);

if ($data_kode['kode'] != NULL) {
  $kode = (int)$data_kode['kode'] + 1;
} else {
  $kode = 1;
}

$hasilkode = "M-" . str_pad($kode, 3, "0", STR_PAD_LEFT);

$_SESSION['KODE'] = $hasilkode;

// ================== PROSES SIMPAN ==================
if (isset($_POST['tambah'])) {

  // ambil & amankan input
  $kd_mapel = mysqli_real_escape_string($koneksi, $_POST['kd_mapel']);
  $nm_mapel = mysqli_real_escape_string($koneksi, $_POST['nm_mapel']);
  $kkm      = mysqli_real_escape_string($koneksi, $_POST['kkm']);

  // validasi sederhana
  if ($nm_mapel == "" || $kkm == "") {
    echo '<div class="alert alert-warning">Data tidak boleh kosong!</div>';
  } else {

    $insert = mysqli_query($koneksi, 
      "INSERT INTO mapel (kd_mapel, nm_mapel, kkm) 
       VALUES ('$kd_mapel','$nm_mapel','$kkm')"
    );

    if ($insert) {
      echo '<div class="alert alert-success">Berhasil Disimpan</div>';
      echo '<meta http-equiv="refresh" content="1;url=index.php?page=mapel">';
    } else {
      echo '<div class="alert alert-danger">Gagal: ' . mysqli_error($koneksi) . '</div>';
    }
  }
}
?>

<!-- ================== HTML ================== -->

<div class="content-header">
  <div class="container-fluid">
    <h1 class="m-0 text-dark">Data Mata Pelajaran</h1>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">

        <form method="POST">

          <div class="form-group">
            <label>Kode Mapel</label>
            <input type="text" name="kd_mapel" 
                   value="<?= $hasilkode; ?>" 
                   class="form-control" readonly>
          </div>

          <div class="form-group">
            <label>Nama Mapel</label>
            <input type="text" name="nm_mapel" 
                   placeholder="Nama Mapel" 
                   class="form-control" required>
          </div>

          <div class="form-group">
            <label>KKM</label>
            <input type="number" name="kkm" 
                   placeholder="KKM" 
                   class="form-control" required>
          </div>

          <button type="submit" name="tambah" class="btn btn-primary">
            Simpan
          </button>

        </form>

      </div>
    </div>
  </div>
</section>