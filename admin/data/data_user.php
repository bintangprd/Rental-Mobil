<?php
session_start();
include '../../koneksi/koneksi.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$total = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data User</title>

    <link rel="stylesheet" href="../style/style.css"> <!--header -->
    <link rel="stylesheet" href="../style/data_user.css"> <!-- table -->
    <link rel="stylesheet" href="../../style/dashboard.css"> <!-- side-->
    <link rel="stylesheet" href="../../style/data_mobil.css">
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
                <h1>Data User</h1>
                <span>Halo, <strong><?= $_SESSION['admin_username']; ?></strong></span>
            </header>

            <div class="container-navbar">
                <ul class="ul-navbar">
                    <li class="li-navbar"><a href="#" class="a-navbar">Data User</a></li>
                    <li class="li-navbar"><a href="#" class="a-navbar">Tambah -</a></li>
                    <li class="li-navbar"><a href="#" class="a-navbar">Hapus User</a></li>
                </ul>
            </div>

            <section class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>No Handphone</th>
                            <th>Alamat</th>
                            <th>Role</th>
                            <th>Dibuat</th>
                            <th>Foto KTP</th>
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
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['username'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td>#</td>
                                    <td><?= $row['no_hp']?></td>
                                    <td><?= $row['alamat']?></td>
                                    <td><?= $row['role']?></td>
                                    <td><?= $row['created_at']?></td>
                                    <td>
                                        <img src="../../uploads/ktp/<?= $row['foto_ktp'] ?>" class="foto">
                                    </td>
                                    <td><a href="#" class="logout-btn">Hapus</a></td>
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