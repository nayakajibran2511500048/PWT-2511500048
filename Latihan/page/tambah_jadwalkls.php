<div class="content-header">
    <div class="container-fluid">
        <div class ="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
$carikode = mysqli_query($koneksi, "SELECT MAX(Id_jadwal) FROM jadwal_kelas") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if ($datakode && $datakode[0] != null) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "001"; // atau bisa juga default "M-001"
}

$_SESSION["KODE"] = $hasilkode;

if(isset($_POST['tambah'])){
    $Id_jadwal = $_POST['Id_jadwal'];
    $Id_kelas = $_POST['Id_kelas'];
    $Thn_ajaran = $_POST['Thn_ajaran'];
    $Semester = $_POST['Semester'];

    $Kd_mapel = $_POST['Kd_mapel'];
    $Kd_guru = $_POST['Kd_guru'];
    $Hari = $_POST['Hari'];
    $Jam = $_POST['Jam'];

    // Insert ke tabel jadwal
    $insertjadwal = mysqli_query($koneksi, "INSERT INTO jadwal_kelas VALUES ('$Id_jadwal', '$Id_kelas', '$Thn_ajaran', '$Semester')");

    if (!$insertjadwal) {
        echo "Gagal insert ke tabel jadwal: " . mysqli_error($koneksi);
        die;
    }

    // Insert ke detail_jadwal
    $allSuccess = true;
    for ($i = 0; $i < count($Kd_mapel); $i++) {
        $insert = mysqli_query($koneksi, "INSERT INTO detail_kelas (Id_jadwal, Kd_mapel, Kd_guru, Hari, Jam)
        VALUES ('$Id_jadwal', '{$Kd_mapel[$i]}', '{$Kd_guru[$i]}', '{$Hari[$i]}', '{$Jam[$i]}')");
        if (!$insert) {
            $allSuccess = false;
            echo "Gagal insert detail ke-$i: " . mysqli_error($koneksi);
        }
    }

    if ($allSuccess) {
        echo '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info</h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal_kelas">';
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info</h5>
        <h4>Gagal menyimpan sebagian atau seluruh data detail.</h4></div>';
    }
}
    ?>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h3>Tambah Jadwal</h3>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Id Jadwal</label>
                            <input type="text" name="Id_jadwal" value="<?= $hasilkode ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="Id_kelas" class="form-control">
                                <tr>
                                    <?php
                                    $kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                                    while ($k = mysqli_fetch_assoc($kelas)) {
                                        echo "<option value='{$k['Id_kelas']}'>{$k['Nm_kelas']}</option>";
                                    }
                                    ?>
                            </select>
                                                    </div>
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <select name="Thn_ajaran" class="form-control" required>
                                <option selected disabled>--Pilih Tahun Ajaran--</option>
                                <option>2024-2025</option>
                                <option>2025-2026</option>
                            </select>
                    </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="Semester" class="form-control" required>
                                <option selected disabled>--Pilih Semester--</option>
                                <option>Ganjil</option>
                                <option>Genap</option>
                            </select>
                        </div>

                    <hr>
                    <h5>Detail Jadwal</h5>
                    <div id="detail_kelas">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <select name="Kd_mapel[]" class="form-control">
                                    <option selected disabled>--Pilih Mapel--</option>
                                    <?php
                                    $mapel = mysqli_query($koneksi, "SELECT * FROM mapel");
                                    while ($m = mysqli_fetch_assoc($mapel)) {
                                        echo "<option value='{$m['Kd_mapel']}'>{$m['Nm_mapel']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="Kd_guru[]" class="form-control">
                                    <option selected disabled>--Pilih Guru--</option>
                                    <?php
                                    $guru = mysqli_query($koneksi, "SELECT * FROM guru");
                                    while ($g = mysqli_fetch_assoc($guru)) {
                                        echo "<option value='{$g['Kd_guru']}'>{$g['Nm_guru']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="Hari[]" class="form-control" required>
                                    <option selected disabled>--Pilih Hari--</option>
                                    <option>Senin</option>
                                    <option>Selasa</option>
                                    <option>Rabu</option>
                                    <option>Kamis</option>
                                    <option>Jumat</option>
                                    <option>Sabtu</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="Jam[]" class="form-control" required>
                                    <option selected disabled>--Pilih Jam--</option>
                                    <option>08.00-10.00</option>
                                    <option>08.00-09.30</option>
                                    <option>10.30-12.00</option>
                                    <option>12.30-14.00</option>
                                </select>
                            </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info" onclick="tambahBaris()">+ Tambah Mapel</button>
                        <br><br>
                        <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
                    </form>
                    
                    <script>
                    function tambahBaris() {
                        let container = document.getElementById('detail_kelas');
                        let row = container.firstElementChild.cloneNode(true);
                        row.querySelectorAll('input').forEach(input => input.value = '');
                        container.appendChild(row);
                        }
                        </script>

                        </div>
                    </div>
                </div>
            </div>