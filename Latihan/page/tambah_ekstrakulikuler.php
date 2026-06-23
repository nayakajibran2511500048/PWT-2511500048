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
  SELECT MAX(CAST(SUBSTRING(id_ekstra, 3) AS UNSIGNED)) AS kode 
  FROM ekstrakulikuler
") or die(mysqli_error($koneksi));

$data_kode = mysqli_fetch_assoc($cari_kode);

if ($data_kode['kode'] != NULL) {
  $kode = (int)$data_kode['kode'] + 1;
} else {
  $kode = 1;
}

$hasilkode = "E-" . str_pad($kode, 3, "0", STR_PAD_LEFT);

$_SESSION['KODE'] = $hasilkode;

// ================== PROSES SIMPAN ==================
if (isset($_POST['tambah'])) {

  // ambil & amankan input
  $id_ekstra    = mysqli_real_escape_string($koneksi, $_POST['id_ekstra']);
  $nama_ekstra  = mysqli_real_escape_string($koneksi, $_POST['nama_ekstra']);
  $ket          = mysqli_real_escape_string($koneksi, $_POST['ket']);
  $semester     = mysqli_real_escape_string($koneksi, $_POST['semester']);
  $thn_ajaran   = mysqli_real_escape_string($koneksi, $_POST['thn_ajaran']);

  // validasi sederhana
  if ($nama_ekstra == "" || $ket == "") {
    echo '<div class="alert alert-warning">Data tidak boleh kosong!</div>';
  } else {

    $insert = mysqli_query($koneksi, 
      "INSERT INTO ekstrakulikuler (id_ekstra, nama_ekstra, ket, semester, thn_ajaran) 
       VALUES ('$id_ekstra','$nama_ekstra','$ket','$semester','$thn_ajaran')"
    );

    if ($insert) {
      echo '<div class="alert alert-success">Berhasil Disimpan</div>';
      echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstrakulikuler">';
    } else {
      echo '<div class="alert alert-danger">Gagal: ' . mysqli_error($koneksi) . '</div>';
    }
  }
}
?>

<!-- ================== HTML ================== -->

<div class="content-header">
  <div class="container-fluid">
    <h1 class="m-0 text-dark">Data Ekstrakurikuler</h1>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">

        <form method="POST">

          <div class="form-group">
            <label>ID Ekstrakulikuler</label>
            <input type="text" name="id_ekstra" 
                   value="<?= $hasilkode; ?>" 
                   class="form-control" readonly>
          </div>

          <div class="form-group">
            <label>Nama Ekstra</label>
            <input type="text" name="nama_ekstra" 
                   placeholder="Nama Ekstra" 
                   class="form-control" required>
          </div>

          <div class="form-group">
            <label>Ket</label>
            <input type="text" name="ket" 
                   class="form-control" required>
          </div>

          <div class="form-group">
            <label>Semester</label>
            <input type="text" name="semester" 
                   class="form-control" required>
          </div>

          <div class="form-group">
            <label>Thn Ajaran</label>
            <input type="text" name="thn_ajaran" 
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