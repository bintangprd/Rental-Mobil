<?php 
    include 'koneksi/koneksi.php';
    session_start();
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/bodyindex.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <!-- HEADER -->
    <?php include 'layout/header.php' ?>
    <!-- HEADER END-->

    <section class="hero">
        <div class="accent-top"></div>
        <div class="accent-bottom"></div>

        <div class="home-container">

            <!-- Pengantar -->
            <div class="home-intro">
                <h1>Solusi Rental Mobil Terpercaya</h1>
                <p>
                    Kami menyediakan layanan rental mobil yang aman, nyaman, dan terjangkau
                    untuk kebutuhan pribadi, bisnis, maupun wisata Anda.
                </p>

                <a href="mobil.php" class="btn-primary">
                    Lihat Mobil
                </a>
            </div>

            <!-- VISI & MISI -->
            <div class="visi-misi">
                <div class="visi">
                    <h2>Visi</h2>
                    <p>
                        Menjadi perusahaan rental mobil terpercaya yang mengutamakan
                        pelayanan terbaik dan kepuasan pelanggan.
                    </p>
                </div>

                <div class="misi">
                    <h2>Misi</h2>
                    <ul>
                        <li>Menyediakan kendaraan yang aman dan terawat</li>
                        <li>Memberikan harga yang kompetitif</li>
                        <li>Pelayanan cepat, ramah, mudah, dan profesional</li>
                        <li>Mengutamakan kenyamanan pelanggan</li>
                    </ul>
                </div>
            </div>

            <!-- LAYANAN -->
            <div class="layanan">
                <h2>Layanan Kami</h2>

                <div class="layanan-grid">
                    <div class="layanan-card">
                        <h3>Sewa Harian</h3>
                        <p>Solusi praktis untuk kebutuhan perjalanan singkat.</p>
                    </div>

                    <div class="layanan-card">
                        <h3>Sewa Mingguan</h3>
                        <p>Lebih hemat untuk penggunaan jangka menengah.</p>
                    </div>

                    <div class="layanan-card">
                        <h3>Sewa Bulanan</h3>
                        <p>Cocok untuk kebutuhan bisnis dan operasional.</p>
                    </div>

                    <div class="layanan-card">
                        <h3>Dengan Sopir</h3>
                        <p>Nyaman tanpa perlu repot menyetir sendiri.</p>
                    </div>
                </div>
            </div>

            <!-- KEUNGGULAN -->
            <div class="keunggulan">
                <h2>Kenapa Memilih Kami?</h2>
                <ul>
                    <li>Armada lengkap & terawat</li>
                    <li>Proses pemesanan mudah</li>
                    <li>Harga transparan</li>
                    <li>Customer support responsif</li>
                </ul>
            </div>

        </div>
    </section>


    <?php include 'layout/footer.php' ?>

</body>

</html>