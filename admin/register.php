<?php
include '../koneksi/koneksi.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $password = $_POST['password'];

    // CEK APAKAH ADMIN SUDAH ADA
    $cek = mysqli_query($conn, "SELECT * FROM admin WHERE id = 1");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Admin sudah terdaftar!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $insert = mysqli_query($conn, "
            INSERT INTO admin (id, username, password, nama)
            VALUES (1, '$username', '$hash', '$nama')
        ");

        if ($insert) {
            $success = "Admin berhasil didaftarkan!";
        } else {
            $error = "Gagal mendaftarkan admin!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Admin</title>
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>

<div class="form-wrapper">
    <div class="form-box">
        <h2>Daftar Admin</h2>

        <?php if ($error): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="nama" placeholder="Nama Admin" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Daftarkan Admin</button>
        </form>
    </div>
</div>

</body>
</html>
