<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Kelas</h1>
            </div>
        </div>
    </div>
</div>

    <?php
    $kd = $_GET['kd'] ?? $_GET['id'] ?? '';

$edit = mysqli_fetch_array(mysqli_query($koneksi,
"SELECT * FROM kelas WHERE Id_kelas='$kd'"
));
    if(isset($_POST['tambah'])){
        $Id_kelas = $_POST['Id_kelas'];
        $Nm_kelas = $_POST['Nm_kelas'];

        $insert = mysqli_query($koneksi,"UPDATE kelas SET Nm_kelas='$Nm_kelas' WHERE Id_kelas='$Id_kelas'");
        if ($insert) {
            echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"
            aria-hidden="true">×</button>
            <h5><i class="icon fas fa-info"></i> Info </h5>
            <h4>Berhasil Disimpan</h4></div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=kelas">';
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
                                <label for="Id_kelas">Id Kelas</label>
                                <input type="text" name="Id_kelas" value="<?= $edit['Id_kelas']; ?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Nm_kelas">Nama Kelas</label>
                                <input type="text" name="Nm_kelas" value="<?= $edit['Nm_kelas']; ?>" id="Nm_kelas" placeholder="Nama kelas" class="form-control">
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