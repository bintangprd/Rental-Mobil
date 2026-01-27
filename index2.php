<?php
session_start();
include 'koneksi/koneksi.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <!-- HEADER -->
    <?php include 'layout/header2.php' ?>
    <!-- HEADER END-->

    <section class="hero">
        <div class="accent-top"></div>
        <div class="accent-bottom"></div>
    </section>

    <?php include 'layout/footer.php' ?>

    <?php if (isset($_SESSION['success'])): ?>
        <script>
            alert("<?= $_SESSION['success']; ?>");
        </script>
        <?php unset($_SESSION['success']); endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_SESSION['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Login 🎉',
                text: '<?= $_SESSION['success']; ?>',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        <?php unset($_SESSION['success']); endif; ?>

</body>

</html>