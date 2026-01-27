<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLogin = isset($_SESSION['login']) && $_SESSION['login'] === true;
$user = $_SESSION['user'] ?? null;
?>

<header>
    <div class="container-navbar">

        <!-- LEFT -->
        <div class="navbar-left">
            <a href="index.php">
                <img src="public/II.png" alt="Logo Rental" class="logo">
            </a>
        </div>

        <!-- CENTER -->
        <ul class="ul-navbar">
            <li class="li-navbar">
                <a href="index.php" class="a-navbar">Home</a>
            </li>

            <li class="li-navbar">
                <a href="profil.php" class="a-navbar">Profil</a>
            </li>

            <li class="li-navbar">
                <a href="mobil.php" class="a-navbar">Daftar Mobil</a>
            </li>

            <li class="li-navbar">
                <a href="#" class="a-navbar">Info Terbaru</a>
            </li>

            <li class="li-navbar">
                <a href="#" class="a-navbar">Pengantaran</a>
            </li>
        </ul>

        <!-- RIGHT -->
        <div class="navbar-right">
            <ul class="ul-navbar">

                <!-- ===== GUEST ===== -->
                <?php if (!$isLogin): ?>
                    <li class="li-navbar2">
                        <a href="daftar.php" class="a-navbar">Daftar Member</a>
                    </li>
                    <li class="li-navbar2">
                        <a href="login.php" class="a-navbar">Login</a>
                    </li>

                <!-- ===== MEMBER ===== -->
                <?php else: ?>
                    <li class="li-navbar2">
                        <span class="a-navbar">
                            Halo, <?= htmlspecialchars($user['nama']); ?>
                        </span>
                    </li>

                    <li class="li-navbar2">
                        <a href="logout.php" class="a-navbar">Logout</a>
                    </li>
                <?php endif; ?>

                <!-- ADMIN -->
                <li class="li-navbar2">
                    <a href="admin/login.php" class="a-navbar">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                </li>

            </ul>
        </div>

    </div>
</header>
