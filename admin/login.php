<?php
session_start();
include '../koneksi/koneksi.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    $admin = mysqli_fetch_assoc($query);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_nama'] = $admin['nama'];

        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>

    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="../style/alogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <section class="login-section">
        <div class="login-box">

            <h2><i class="fa-solid fa-user-shield"></i> Login Admin
                <a href="../index.php"><i class="fa-solid fa-right-to-bracket"></i><!-- Logout --></a>
            </h2>

            <?php if ($error): ?>
                <div class="error-msg"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required autocomplete="off">
                </div>

                <div class="form-group password-wrapper">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                    <i class="fa-solid fa-eye" id="togglePassword"></i>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </button>
            </form>

        </div>
    </section>

    <script>
        const toggle = document.getElementById("togglePassword");
        const password = document.getElementById("password");

        toggle.addEventListener("click", () => {
            const type = password.type === "password" ? "text" : "password";
            password.type = type;
            toggle.classList.toggle("fa-eye-slash");
        });
    </script>

</body>

</html>