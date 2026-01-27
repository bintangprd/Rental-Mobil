<?php include 'koneksi/koneksi.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/bodyprofil.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <!-- HEADER -->
    <?php include 'layout/header.php' ?>
    <!-- HEADER END-->

    <section class="hero profile-hero">

        <div class="hero-accent">
            <div class="accent-top"></div>
            <div class="accent-bottom"></div>
        </div>

        <div class="profile-container">

            <h1 class="profile-title">Profil Perusahaan</h1>

            <p class="profile-desc">
                Kami adalah perusahaan rental mobil yang berkomitmen menyediakan layanan
                transportasi terbaik dengan armada berkualitas, harga transparan, dan
                pelayanan profesional.
            </p>

            <!-- VISI MISI -->
            <div class="profile-grid">
                <div class="profile-card">
                    <h2>Visi</h2>
                    <p>
                        Menjadi perusahaan rental mobil terpercaya yang memberikan kenyamanan,
                        keamanan, dan kepuasan bagi setiap pelanggan.
                    </p>
                </div>

                <div class="profile-card">
                    <h2>Misi</h2>
                    <ul>
                        <li>Menyediakan kendaraan yang aman dan terawat</li>
                        <li>Memberikan harga yang kompetitif</li>
                        <li>Mengutamakan kepuasan pelanggan</li>
                        <li>Memberikan pelayanan cepat dan profesional</li>
                    </ul>
                </div>
            </div>

            <!-- TENTANG KAMI -->
            <div class="profile-section">
                <h2>Tentang Kami</h2>
                <p>
                    Rental mobil kami telah beroperasi selama bertahun-tahun dan melayani
                    berbagai kebutuhan transportasi, mulai dari perjalanan pribadi,
                    bisnis, hingga wisata. Kami selalu mengutamakan kualitas armada dan
                    kenyamanan pelanggan.
                </p>
            </div>

            <!-- NILAI PERUSAHAAN -->
            <div class="profile-section">
                <h2>Nilai Perusahaan</h2>
                <ul class="value-list">
                    <li>Profesionalisme</li>
                    <li>Kepercayaan</li>
                    <li>Keamanan</li>
                    <li>Kenyamanan</li>
                </ul>
            </div>

        </div>
    </section>


    <?php include 'layout/footer.php' ?>

</body>

</html>