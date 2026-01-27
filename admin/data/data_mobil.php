<?php
session_start();
include '../../koneksi/koneksi.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM mobil";
$result = mysqli_query($conn, $sql);
$total = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Mobil</title>

    <link rel="stylesheet" href="../style/style.css"> <!--header -->
    <link rel="stylesheet" href="../style/data_mobil.css"> <!-- table -->
    <link rel="stylesheet" href="../../style/dashboard.css"> <!-- side-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="dashboard-wrapper">

        <aside class="sidebar">
            <h2 class="sidebar-title">Admin Panel</h2>

            <ul class="sidebar-menu">
                <li><a href="../index.php"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li><a href="data_mobil.php"><i class="fa-solid fa-car"></i> Data Mobil</a></li>
                <li><a href="data_user.php"><i class="fa-solid fa-users"></i> Data User</a></li>
                <li><a href="data_transaksi.php"><i class="fa-solid fa-file-invoice"></i> Transaksi</a></li>
                <li><a href="#"><i class="fa-solid fa-gear"></i> Pengaturan</a></li>
            </ul>

            <a href="../logout.php" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </aside>

        <main class="dashboard-content">

            <header class="dashboard-header">
                <h1>Data Mobil</h1>
                <span>Halo, <strong><?= $_SESSION['admin_username']; ?></strong></span>
            </header>

            <div class="container-navbar">
                <ul class="ul-navbar">
                    <li class="li-navbar"><a href="data_mobil.php" class="a-navbar">Data Mobil</a></li>
                    <li class="li-navbar"><a href="tambah_mobil.php" class="a-navbar">Tambah Mobil</a></li>
                    <li class="li-navbar"><a href="mobil.php" class="a-navbar">Hapus Mobil</a></li>
                </ul>
            </div>

            <section class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mobil</th>
                            <th>Merk</th>
                            <th>Tahun</th>
                            <th>Plat Nomor</th>
                            <th>Warna</th>
                            <th>Harga / Hari</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Stok Mobil</th>
                            <th colspan="2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ($total == 0): ?>
                            <tr>
                                <td colspan="8" class="empty">Data mobil belum tersedia</td>
                            </tr>
                        <?php else: ?>
                            <?php $i = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $row['nama_mobil'] ?></td>
                                    <td><?= $row['merk'] ?></td>
                                    <td><?= $row['tahun'] ?></td>
                                    <td><?= $row['plat_nomor'] ?></td>
                                    <td><?= $row['warna'] ?></td>
                                    <td>Rp <?= number_format($row['harga_sewa_harian'], 0, ',', '.') ?></td>
                                    <td>
                                        <span class="status <?= strtolower($row['status']) ?>">
                                            <?= $row['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <img src="../../uploads/mobil/<?= $row['foto'] ?>" class="foto">
                                    </td>
                                    <td><?= $row['jumlah_mobil']?></td>
                                    <td>
                                        <a href="edit_mobil.php?id=<?= $row['id_mobil']?>" class="btn-action btn-delete">Edit</a>
                                    </td>
                                    <td><a href="hapus_mobil.php?id=<?= $row['id_mobil']?>" 
                                    onclick="return confirm('yakin  ingin menghapus mobil ini?')"
                                    class="btn-action btn-delete">Hapus</a></td>
                                    
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

        </main>
    </div>

</body>

</html>