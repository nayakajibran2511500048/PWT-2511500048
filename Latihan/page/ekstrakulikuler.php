<div class="content-header">
    <div class="container-fluid">
        <div class ="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Ekstrakurikuler</h1>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_GET['action'])) {
    if($_GET['action'] == "hapus") {
        $kd = $_GET['kd'];
        $query = mysqli_query($koneksi, "DELETE FROM ekstrakulikuler WHERE id_ekstra = '$kd'");
        
        if ($query){
            echo '
            <div class="alert alert-warning alert-dismissible">
                Berhasil Di Hapus
            </div>';
            echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstrakulikuler">';
        }
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                
                <a href="index.php?page=tambah_ekstrakulikuler" class="btn btn-primary btn-sm mb-3">
                    Tambah Ekstra
                </a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>id ekstra</th>
                            <th>Nama Ekstra</th>
                            <th>Ket</th>
                            <th>Semester</th>
                            <th>thn Ajaran</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 0;
                        $query = mysqli_query($koneksi,"SELECT * FROM ekstrakulikuler");

                        while ($result = mysqli_fetch_array($query)) {
                            $no++;
                        ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $result['id_ekstra']; ?></td>
                            <td><?= $result['nama_ekstra']; ?></td>
                            <td><?= $result['ket']; ?></td>
                            <td><?= $result['semester']; ?></td>
                            <td><?= $result['thn_ajaran']; ?></td>
                            <td>
                                <a href="index.php?page=ekstrakulikuler&action=hapus&kd=<?= $result['id_ekstra']; ?>" 
                                   onclick="return confirm('Yakin mau hapus data ini?')">
                                    <span class="badge badge-danger">Hapus</span>
                                </a>

                                <a href="index.php?page=edit_ekstrakulikuler&kd=<?= $result['id_ekstra']; ?>">
                                    <span class="badge badge-warning">Edit</span>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>