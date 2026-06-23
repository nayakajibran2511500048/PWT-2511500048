<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Tambah Jadwal Kelas</h1>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['tambah'])){
    $Id_kelas   = $_POST['Id_kelas'];
    $Thn_ajaran = $_POST['Thn_ajaran'];
    $Semester   = $_POST['Semester'];

    $insert = mysqli_query($koneksi, "INSERT INTO jadwal_kelas (Id_kelas, Thn_ajaran, Semester) VALUES ('$Id_kelas', '$Thn_ajaran', '$Semester')");
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal_kelas">';
    } else {
        echo '<div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
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
                            <label for="Id_kelas">Pilih Kelas</label>
                            <select name="Id_kelas" id="Id_kelas" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php
                                $sql_kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                                while ($k = mysqli_fetch_array($sql_kelas)) {
                                    echo "<option value='{$k['Id_kelas']}'>{$k['Nm_kelas']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Thn_ajaran">Tahun Ajaran</label>
                            <input type="text" name="Thn_ajaran" id="Thn_ajaran" placeholder="Contoh: 2025/2026" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="Semester">Semester</label>
                            <select name="Semester" id="Semester" class="form-control" required>
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
                            <a href="index.php?page=jadwal_kelas" class="btn border">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>