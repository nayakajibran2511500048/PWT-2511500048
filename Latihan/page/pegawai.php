<?php
if ($_SESSION['role'] != 'admin') {
    echo "<div class='alert alert-danger'>Akses ditolak.</div>";
    exit;
}

$pesan = '';

// Tambah pegawai
if (isset($_POST['tambah'])) {
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $uname = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass  = mysqli_real_escape_string($koneksi, $_POST['password']);

    $cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE username='$uname'"));
    if ($cek > 0) {
        $pesan = "<div class='alert alert-warning'>Username sudah digunakan.</div>";
    } else {
        $ins   = mysqli_query($koneksi, "INSERT INTO user (nama_lengkap, username, password, role) VALUES ('$nama','$uname','$pass','pegawai')");
        $pesan = $ins
            ? "<div class='alert alert-success'>Pegawai berhasil ditambahkan.</div>"
            : "<div class='alert alert-danger'>Gagal menambahkan pegawai.</div>";
    }
}

// Hapus pegawai
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];

    // Hapus data relasi terlebih dahulu (absen)
    mysqli_query($koneksi, "DELETE FROM absen_datang WHERE id_user='$id_hapus'");
    mysqli_query($koneksi, "DELETE FROM absen_pulang WHERE id_user='$id_hapus'");

    // Baru hapus data user utama
    $hapus = mysqli_query($koneksi, "DELETE FROM user WHERE id_user='$id_hapus' AND role='pegawai'");
    $pesan = $hapus
        ? "<div class='alert alert-success'>Pegawai & data absensi berhasil dihapus.</div>"
        : "<div class='alert alert-danger'>Gagal menghapus pegawai.</div>";
}

// Ambil data untuk Edit pegawai
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit   = (int)$_GET['edit'];
    $edit_data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id_edit'"));
}

// Proses Update pegawai
if (isset($_POST['update'])) {
    $id_upd = (int)$_POST['id_user'];
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $uname  = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass   = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    $sql = $pass
        ? "UPDATE user SET nama_lengkap='$nama', username='$uname', password='$pass' WHERE id_user='$id_upd'"
        : "UPDATE user SET nama_lengkap='$nama', username='$uname' WHERE id_user='$id_upd'";
        
    $upd   = mysqli_query($koneksi, $sql);
    $pesan = $upd
        ? "<div class='alert alert-success'>Data pegawai berhasil diupdate.</div>"
        : "<div class='alert alert-danger'>Gagal mengupdate data.</div>";
    $edit_data = null;
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Pegawai</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <?= $pesan ?>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $edit_data ? 'Edit Pegawai' : 'Tambah Pegawai' ?></h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <?php if ($edit_data): ?>
                        <input type="hidden" name="id_user" value="<?= $edit_data['id_user'] ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" required value="<?= htmlspecialchars($edit_data['nama_lengkap'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($edit_data['username'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Password <?= $edit_data ? '(kosongkan jika tidak diubah)' : '' ?></label>
                                <input type="password" name="password" class="form-control" <?= $edit_data ? '' : 'required' ?>>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($edit_data): ?>
                        <button type="submit" name="update" class="btn btn-warning btn-sm">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="index.php?page=pegawai" class="btn btn-secondary btn-sm">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="tambah" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Pegawai</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM user ORDER BY role DESC, nama_lengkap ASC");
                        $no    = 1;
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            $badge = $row['role'] == 'admin' ? 'danger' : 'success';
                            
                            echo "<tr>
                                <td>{$no}</td>
                                <td>" . htmlspecialchars($row['nama_lengkap']) . "</td>
                                <td>" . htmlspecialchars($row['username']) . "</td>
                                <td><span class='badge badge-{$badge}'>{$row['role']}</span></td>
                                <td>";
                                
                            if ($row['role'] == 'pegawai') {
                                echo "<a href='index.php?page=pegawai&edit={$row['id_user']}' class='btn btn-warning btn-xs'><i class='fas fa-edit'></i> Edit</a> ";
                                echo "<a href='index.php?page=pegawai&hapus={$row['id_user']}' class='btn btn-danger btn-xs' onclick=\"return confirm('Hapus pegawai ini?')\"><i class='fas fa-trash'></i> Hapus</a>";
                            } else {
                                echo "<span class='text-muted'>-</span>";
                            }
                            
                            echo "</td></tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>