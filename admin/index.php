<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}


$sql_mobil = "SELECT COUNT(*) AS total_mobil FROM mobil";
$result = $conn->query($sql_mobil);
$data = $result->fetch_assoc();
$totalMobil = $data['total_mobil'];

$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql_users);
$data = $result->fetch_assoc();
$totalUsers = $data['total_users'];

$sql_sewa = "SELECT COUNT(*) AS id_sewa FROM penyewaan";
$result = $conn->query($sql_sewa);
$data = $result->fetch_assoc();
$totalSewa = $data['id_sewa'];

$sql_harga = "SELECT COUNT(*) AS total_harga FROM penyewaan";
$result = $conn->query($sql_harga);
$data = $result->fetch_assoc();
$totalPendapatan = $data['total_harga'];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../style/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

    <div class="dashboard-wrapper">

        <aside class="sidebar">
            <h2 class="sidebar-title">Admin Panel</h2>

            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li><a href="data/data_mobil.php"><i class="fa-solid fa-car"></i> Data Mobil</a></li>
                <li><a href="data/data_user.php"><i class="fa-solid fa-users"></i> Data User</a></li>
                <li><a href="data/data_transaksi.php"><i class="fa-solid fa-file-invoice"></i> Transaksi</a></li>
                <li><a href="#"><i class="fa-solid fa-gear"></i> Pengaturan</a></li>
            </ul>

            <a href="logout.php" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </aside>

        <!-- MAIN -->
        <main class="dashboard-content">

            <header class="dashboard-header">
                <h1>Dashboard</h1>
                <span>Halo, <strong><?= $_SESSION['admin_username']; ?></strong></span>
            </header>

            <!-- STAT BOX -->
            <section class="stat-grid">
                <div class="stat-card">
                    <i class="fa-solid fa-car"></i>
                    <h3><?= $totalMobil ?></h3>
                    <p>Total Mobil</p>
                </div>

                <div class="stat-card">
                    <i class="fa-solid fa-users"></i>
                    <h3><?= $totalUsers?></h3>
                    <p>User</p>
                </div>

                <div class="stat-card">
                    <i class="fa-solid fa-file-invoice"></i>
                    <h3><?= $totalSewa ?></h3>
                    <p>Transaksi</p>
                </div>

                <div class="stat-card">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <h3>Rp <?= $totalPendapatan?></h3>
                    <p>Pendapatan</p>
                </div>
            </section>

            <!-- CONTENT -->
            <section class="dashboard-box">
                <h2>Selamat Datang</h2>
                <p>
                    Ini adalah halaman dashboard admin.
                    Dari sini kamu bisa mengelola data mobil, user, transaksi,
                    dan pengaturan website rental mobil.
                </p>
            </section>

        </main>
    </div>

</body>

</html>