<?php
include 'koneksi/koneksi.php';

$error = "";
$success = "";

/* ===== SIMPAN DATA LAMA (AGAR FORM TIDAK KE-RESET) ===== */
$old_nama = $_POST['nama'] ?? '';
$old_username = $_POST['username'] ?? '';
$old_email = $_POST['email'] ?? '';
$old_no_hp = $_POST['no_hp'] ?? '';
$old_alamat = $_POST['alamat'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama = $conn->real_escape_string($_POST['nama']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $no_hp = $conn->real_escape_string($_POST['no_hp']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $alamat = $conn->real_escape_string($_POST['alamat']);

    /* ===== VALIDASI ===== */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } elseif (!preg_match('/^\d{10,15}$/', $no_hp)) {
        $error = "No telepon harus 10–15 digit!";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $error = "Password minimal 8 karakter dan harus kuat!";
    } elseif ($password !== $confirm) {
        $error = "Password dan Confirm Password tidak sama!";
    } else {

        /* ===== CEK USERNAME ===== */
        $check = $conn->query("SELECT id_user FROM users WHERE username='$username'");
        if ($check->num_rows > 0) {
            $error = "Username sudah digunakan!";
        } else {

            /* ===== UPLOAD FOTO KTP ===== */
            $uploadDir = "uploads/ktp/";
            $ext = strtolower(pathinfo($_FILES['foto_ktp']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $error = "Format foto harus JPG / PNG!";
            } elseif ($_FILES['foto_ktp']['size'] > 2 * 1024 * 1024) {
                $error = "Ukuran foto maksimal 2MB!";
            } else {

                $namaBaru = 'ktp_' . time() . '.' . $ext;

                if (move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $uploadDir . $namaBaru)) {

                    /* ===== HASH PASSWORD ===== */
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    /* ===== INSERT KE DB (SESUAI FIELD) ===== */
                    $conn->query("
                        INSERT INTO users 
                        (nama, username, email, no_hp, password, alamat, foto_ktp)
                        VALUES
                        ('$nama','$username','$email','$no_hp','$hashed_password','$alamat','$namaBaru')
                    ");

                    header("Location: login.php");
                    exit;
                } else {
                    $error = "Gagal upload foto KTP!";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar</title>
    <link rel="stylesheet" href="/PraktekPJY/Rental-Mobil/style/style.css">
    <link rel="stylesheet" href="/PraktekPJY/Rental-Mobil/style/daftar.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include 'layout/header.php'; ?>

    <section class="hero">
        <div class="form-wrapper">

            <div class="container-table">
                <form method="post" enctype="multipart/form-data">

                    <?php if ($error): ?>
                        <p style="color:red"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>

                    <table>

                        <tr>
                            <td><label>Nama</label></td>
                            <td><input type="text" name="nama" value="<?= htmlspecialchars($old_nama) ?>" required></td>
                        </tr>

                        <tr>
                            <td><label>Username</label></td>
                            <td><input type="text" name="username" value="<?= htmlspecialchars($old_username) ?>"
                                    required></td>
                        </tr>

                        <tr>
                            <td><label>Email</label></td>
                            <td><input type="email" name="email" value="<?= htmlspecialchars($old_email) ?>" required>
                            </td>
                        </tr>

                        <tr>
                            <td><label>No HP</label></td>
                            <td><input type="number" name="no_hp" value="<?= htmlspecialchars($old_no_hp) ?>" required>
                            </td>
                        </tr>

                        <tr>
                            <td><label>Password</label></td>
                            <td>
                                <div class="password-wrapper">
                                    <input type="password" name="password" required>
                                    <i class="fa-solid fa-eye" onclick="togglePassword(this)"></i>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><label>Confirm Password</label></td>
                            <td>
                                <div class="password-wrapper">
                                    <input type="password" name="confirm_password" required>
                                    <i class="fa-solid fa-eye" onclick="togglePassword(this)"></i>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><label>Alamat</label></td>
                            <td><textarea name="alamat" required><?= htmlspecialchars($old_alamat) ?></textarea></td>
                        </tr>

                        <tr>
                            <td><label>Foto KTP</label></td>
                            <td><input type="file" name="foto_ktp" required></td>
                        </tr>

                    </table>

                    <button type="submit" class="btn-submit">Daftar</button>

                </form>
            </div>

        </div>
    </section>


    <?php include 'layout/footer.php'; ?>

    <script>
        function togglePassword(icon) {
            const input = icon.previousElementSibling;
            input.type = input.type === "password" ? "text" : "password";
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        }
    </script>

</body>

</html>