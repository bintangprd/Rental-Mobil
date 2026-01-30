<?php
include 'koneksi/koneksi.php';

/*
|=====================================================
| Ambil data mobil
| - Status tersedia
| - Tampilkan semua, tapi kontrol sewa via jumlah_mobil
|=====================================================
*/
$query = "
    SELECT * FROM mobil 
    WHERE status = 'tersedia'
";
$result = $conn->query($query);

/* Ambil merk unik */
$merkQuery = $conn->query("
    SELECT DISTINCT merk 
    FROM mobil 
    WHERE status = 'tersedia'
    ORDER BY merk ASC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mobil</title>

    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/bodymobil.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<!-- HEADER -->
<?php include 'layout/header.php'; ?>
<!-- HEADER END -->

<!-- NAVBAR FILTER -->
<div class="container-navbar2">

    <div class="brand-dropdown">
        <button class="dropdown-btn">☰ Merk Mobil</button>

        <ul class="dropdown-menu">
            <li><button data-filter="all">Semua</button></li>

            <?php while ($m = $merkQuery->fetch_assoc()): ?>
                <li>
                    <button data-filter="<?= strtolower($m['merk']); ?>">
                        <?= htmlspecialchars($m['merk']); ?>
                    </button>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="navbar-right">
        <ul class="ul-navbar">
            <li class="li-navbar2">
                <a href="https://wa.me/6283844398309" class="a-navbar">
                    <i class="fa-solid fa-phone"></i>
                </a>
            </li>
            <li class="li-navbar2">
                <a href="https://maps.app.goo.gl/9oQVxy9ZrczphfGY7" class="a-navbar">
                    <i class="fa-solid fa-location-dot"></i>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- LIST MOBIL -->
<section class="car-section">

    <h2 class="section-title">Daftar Mobil</h2>

    <div class="car-container">

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>

                <div class="car-card" data-brand="<?= strtolower($row['merk']); ?>">

                    <img src="uploads/mobil/<?= htmlspecialchars($row['foto']); ?>"
                         alt="<?= htmlspecialchars($row['nama_mobil']); ?>">

                    <h3>
                        <?= htmlspecialchars($row['merk']); ?>
                        <?= htmlspecialchars($row['nama_mobil']); ?>
                    </h3>

                    <p class="price">
                        Rp <?= number_format($row['harga_sewa_harian'], 0, ',', '.'); ?> / hari
                    </p>

                    <!-- STATUS JUMLAH -->
                    <?php if ($row['jumlah_mobil'] > 0): ?>
                        <p class="stok tersedia">
                            Tersedia (<?= $row['jumlah_mobil']; ?> unit)
                        </p>

                        <a href="sewa.php?id=<?= $row['id_mobil']; ?>" class="btn-sewa">
                            <button>Sewa Sekarang</button>
                        </a>
                    <?php else: ?>
                        <p class="stok habis">Mobil Habis</p>

                        <button class="btn-habis" disabled>
                            Tidak Tersedia
                        </button>
                    <?php endif; ?>

                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">Tidak ada mobil tersedia</p>
        <?php endif; ?>

    </div>
</section>

<!-- FOOTER -->
<?php include 'layout/footer.php'; ?>
<!-- FOOTER END -->

<!-- FILTER SCRIPT -->
<script>
    const filterButtons = document.querySelectorAll('.dropdown-menu button');
    const cars = document.querySelectorAll('.car-card');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;

            cars.forEach(car => {
                const brand = car.dataset.brand;

                if (filter === 'all' || brand === filter) {
                    car.style.display = 'block';
                } else {
                    car.style.display = 'none';
                }
            });
        });
    });

    const dropdownBtn = document.querySelector('.dropdown-btn');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    dropdownBtn.addEventListener('click', () => {
        dropdownMenu.classList.toggle('show');
    });

    document.querySelectorAll('.dropdown-menu button').forEach(item => {
        item.addEventListener('click', () => {
            dropdownMenu.classList.remove('show');
        });
    });
</script>

</body>
</html>
