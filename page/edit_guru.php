<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Guru</h1>
            </div>
        </div>
    </div>
</div>


<?php
$kd = $_GET['kd'] ?? $_GET['id'] ?? '';

$edit = mysqli_fetch_array(mysqli_query($koneksi,
"SELECT * FROM guru WHERE Kd_guru='$kd'"
)) ?? [];

if(isset($_POST['tambah'])){
    $Kd_guru = $kd; // ✅ FIX DI SINI (pakai dari URL)
    $Nm_guru = $_POST['Nm_guru'];
    $Jenkel = $_POST['Jenkel'];
    $Pend_terakhir = $_POST['Pend_terakhir'];
    $Hp = $_POST['Hp'];
    $Alamat = $_POST['Alamat'];

    $update = mysqli_query($koneksi,"UPDATE guru SET 
        Nm_guru='$Nm_guru',
        Jenkel='$Jenkel',
        Pend_terakhir='$Pend_terakhir',
        Hp='$Hp',
        Alamat='$Alamat'
        WHERE Kd_guru='$Kd_guru' LIMIT 1
    ");

    if ($update) {
        echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=guru">';
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
                            <label>Kd Guru</label>
                            <input type="text" name="Kd_guru" value="<?= $edit['Kd_guru']; ?>" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input type="text" name="Nm_guru" value="<?= $edit['Nm_guru']; ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="Jenkel" class="form-control">
                                <option value="L" <?= $edit['Jenkel']=='L'?'selected':''; ?>>Laki-laki</option>
                                <option value="P" <?= $edit['Jenkel']=='P'?'selected':''; ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Pendidikan Terakhir</label>
                            <input type="text" name="Pend_terakhir" value="<?= $edit['Pend_terakhir']; ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>No HP</label>
                            <input type="text" name="Hp" value="<?= $edit['Hp']; ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="Alamat" class="form-control"><?= $edit['Alamat']; ?></textarea>
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