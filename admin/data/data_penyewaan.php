<?php
session_start();
include '../../koneksi/koneksi.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

$sql = "
    SELECT 
        p.*, 
        pb.id_pembayaran,
        pb.status AS status_pembayaran
    FROM penyewaan p
    LEFT JOIN pembayaran pb ON p.id_sewa = pb.id_sewa
";
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
                <h1>Data Penyewaan</h1>
                <span>Halo, <strong><?= $_SESSION['admin_username']; ?></strong></span>
            </header>

            <div class="container-navbar">
                <ul class="ul-navbar">
                    <li class="li-navbar"><a href="data_transaksi.php" class="a-navbar">Data Transaksi</a></li>
                    <li class="li-navbar"><a href="data_penyewaan.php" class="a-navbar">Data Penyewaan</a></li>
                    <li class="li-navbar"><a href="#" class="a-navbar">#</a></li>
                </ul>
            </div>

            <section class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID User</th>
                            <th>ID Mobil</th>
                            <th>Nama Penyewa</th>
                            <th>No Handphone</th>
                            <th>Tnggal Sewa</th>
                            <th>Tanggal Kembali</th>
                            <th>Lama Sewa</th>
                            <th>Total Harga</th>
                            <th>Status Sewa</th>
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
                                    <td><?= $row['id_user'] ?></td>
                                    <td><?= $row['id_mobil'] ?></td>
                                    <td><?= $row['nama_penyewa'] ?></td>
                                    <td><?= $row['no_hp'] ?></td>
                                    <td><?= $row['tanggal_sewa'] ?></td>
                                    <td><?= $row['tanggal_kembali'] ?></td>
                                    <td><?= $row['lama_sewa'] ?></td>
                                    <td><?= $row['total_harga'] ?></td>
                                    <td><?= $row['status_sewa'] ?></td>
                                    <td><a href="#" class="btn-action btn-delete">Tolak</a></td>
                                    <td>
                                        <?php if ($row['status_sewa'] !== 'selesai'): ?>
                                        <a href="selesai_penyewaan.php?id_sewa=<?=$row['id_sewa']?>"
                                            onclick="return confirm('Selesaikan Penyewaan ini?')"
                                            class="btn-action btn-accept">Selesai</a>
                                        <?php else: ?>
                                            <span class="btn-action btn-selesai" > Selesai</span>
                                        <?php endif; ?>
                                    </td>
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