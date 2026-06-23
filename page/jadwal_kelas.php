<?php
// Pastikan variabel $role sudah didefinisikan melalui session di index.php

if (isset($_GET['hapus'])) {
    // Amankan variabel ID yang akan dihapus
    $Id_jadwal = mysqli_real_escape_string($koneksi, $_GET['hapus']);

    // 1. PERBAIKAN: Menyelaraskan nama tabel menjadi detail_jadwal sesuai database Anda
    $hapus_detail = mysqli_query($koneksi, "DELETE FROM detail_jadwal WHERE Id_jadwal = '$Id_jadwal'");

    // 2. Lalu hapus data utama di jadwal_kelas
    $hapus = mysqli_query($koneksi, "DELETE FROM jadwal_kelas WHERE Id_jadwal = '$Id_jadwal'");

    if ($hapus) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Berhasil!</strong> Data jadwal dan detailnya telah dihapus.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
        // Refresh halaman otomatis agar data yang dihapus langsung hilang dari tabel
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal_kelas">';
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Gagal!</strong> Tidak dapat menghapus data: " . mysqli_error($koneksi) . "
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
    }
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                
                <?php if (isset($role) && $role == 'admin') { ?>
                    <a href="index.php?page=tambah_jadwalkls" class="btn btn-primary btn-sm mb-3">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </a>
                <?php } ?>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id Jadwal</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Detail Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Ambil data jadwal kelas dikombinasikan dengan nama kelas
                        $query = mysqli_query($koneksi, "SELECT * FROM jadwal_kelas 
                            LEFT JOIN kelas ON jadwal_kelas.Id_kelas = kelas.Id_kelas");
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>
                                <td>{$row['Id_jadwal']}</td>
                                <td>" . ($row['Nm_kelas'] ?? $row['Kelas'] ?? '-') . "</td>
                                <td>{$row['Thn_ajaran']}</td>
                                <td>{$row['Semester']}</td>
                                <td>
                                <ul>";
                                
                                // PERBAIKAN: Mengubah detail_kelas menjadi detail_jadwal agar sesuai dengan database Anda
                                $det = mysqli_query($koneksi, "SELECT d.*, m.Nm_mapel, g.Nm_guru 
                                    FROM detail_jadwal d 
                                    JOIN mapel m ON d.Kd_mapel = m.Kd_mapel 
                                    JOIN guru g ON d.Kd_guru = g.Kd_guru
                                    WHERE d.Id_jadwal = '{$row['Id_jadwal']}'");
                                
                                $cek_detail = 0;
                                while ($d = mysqli_fetch_assoc($det)) {
                                    $cek_detail++;
                                    // PERBAIKAN: Menyesuaikan tampilan jam_mulai s.d jam_selesai sesuai kolom database asli
                                    echo "<li><strong>{$d['Nm_mapel']}</strong> - {$d['Nm_guru']} ({$d['Hari']}, {$d['Jam_mulai']} - {$d['Jam_selesai']})</li>";
                                }

                                if ($cek_detail === 0) {
                                    echo "<li><em class='text-muted'>Belum ada detail pelajaran</em></li>";
                                }

                            echo "</ul>
                                </td>
                                <td>
                                    <a href='index.php?page=jadwal_kelas&hapus={$row['Id_jadwal']}' 
                                       onclick=\"return confirm('Yakin ingin menghapus data jadwal ini beserta seluruh detailnya?')\" 
                                       class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Hapus</a>
                                    
                                    <a href='cetak.php?Id_jadwal={$row['Id_jadwal']}' 
                                       target='_blank'
                                       class='btn btn-success btn-sm'><i class='fas fa-print'></i> Cetak</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>