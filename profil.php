<?php include 'koneksi/koneksi.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Perusahaan</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/bodyprofil.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <?php include 'layout/header.php' ?>

    <section class="hero profile-hero">
        <div class="hero-accent">
            <div class="accent-top"></div>
            <div class="accent-bottom"></div>
        </div>

        <div class="profile-container">

            <h1 class="profile-title">Profil Perusahaan</h1>

            <p class="profile-desc">
                Kami adalah perusahaan rental mobil profesional yang berkomitmen
                memberikan layanan transportasi terbaik dengan armada berkualitas,
                harga transparan, serta pelayanan yang ramah dan terpercaya.
            </p>

            <!-- VISI MISI -->
            <div class="profile-grid">
                <div class="profile-card">
                    <h2>Visi</h2>
                    <p>
                        Menjadi perusahaan rental mobil terpercaya dan pilihan utama
                        masyarakat dalam memenuhi kebutuhan transportasi yang aman dan nyaman.
                    </p>
                </div>

                <div class="profile-card">
                    <h2>Misi</h2>
                    <ul>
                        <li>Menyediakan armada kendaraan yang layak dan terawat</li>
                        <li>Memberikan pelayanan cepat, ramah, dan profesional</li>
                        <li>Menawarkan harga yang kompetitif dan transparan</li>
                        <li>Mengutamakan kepuasan dan keamanan pelanggan</li>
                    </ul>
                </div>
            </div>

            <!-- SEJARAH PERUSAHAAN -->
            <div class="profile-section">
                <h2>Sejarah Perusahaan</h2>
                <p>
                    Perusahaan kami berdiri dengan tujuan membantu masyarakat dalam
                    memenuhi kebutuhan transportasi yang fleksibel dan efisien.
                    Berawal dari armada kecil, kini kami terus berkembang dengan
                    berbagai jenis kendaraan untuk kebutuhan pribadi, bisnis, hingga wisata.
                </p>
            </div>

            <!-- TENTANG KAMI -->
            <div class="profile-section">
                <h2>Tentang Kami</h2>
                <p>
                    Kami melayani penyewaan mobil harian, mingguan, hingga bulanan.
                    Dengan sistem pemesanan yang mudah dan dukungan tim profesional,
                    kami siap menjadi solusi transportasi terbaik Anda.
                </p>
            </div>

            <!-- LAYANAN -->
            <div class="profile-section">
                <h2>Layanan Kami</h2>
                <div class="service-grid">
                    <div class="service-card">
                        <i class="fa-solid fa-car"></i>
                        <h3>Sewa Harian</h3>
                        <p>Layanan sewa mobil fleksibel untuk kebutuhan harian Anda.</p>
                    </div>

                    <div class="service-card">
                        <i class="fa-solid fa-briefcase"></i>
                        <h3>Sewa Bisnis</h3>
                        <p>Solusi transportasi profesional untuk kebutuhan perusahaan.</p>
                    </div>

                    <div class="service-card">
                        <i class="fa-solid fa-map-location-dot"></i>
                        <h3>Wisata</h3>
                        <p>Perjalanan wisata nyaman dengan armada yang terawat.</p>
                    </div>
                </div>
            </div>

            <!-- KEUNGGULAN -->
            <div class="profile-section">
                <h2>Keunggulan Kami</h2>
                <ul class="value-list">
                    <li>Armada lengkap dan berkualitas</li>
                    <li>Harga transparan tanpa biaya tersembunyi</li>
                    <li>Pelayanan cepat dan responsif</li>
                    <li>Keamanan dan kenyamanan pelanggan</li>
                </ul>
            </div>

            <!-- NILAI PERUSAHAAN -->
            <div class="profile-section">
                <h2>Nilai Perusahaan</h2>
                <ul class="value-list">
                    <li>Profesionalisme</li>
                    <li>Kepercayaan</li>
                    <li>Integritas</li>
                    <li>Kenyamanan</li>
                </ul>
            </div>

        </div>
    </section>

    <?php include 'layout/footer.php' ?>

</body>
</html>
