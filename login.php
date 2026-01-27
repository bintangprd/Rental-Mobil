<?php

session_start();
include 'koneksi/koneksi.php';

$error = "";
$success = "";
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {

    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Ambil user berdasarkan username & email
    $query = $conn->query("
        SELECT * FROM users 
        WHERE username = '$username' 
        AND email = '$email'
        LIMIT 1
    ");

    if ($query && $query->num_rows > 0) {

        $data = $query->fetch_assoc();

        // Verifikasi password hash
        if (password_verify($password, $data['password'])) {

            $_SESSION['login'] = true;
            $_SESSION['user'] = [
                'id_user' => $data['id_user'],
                'nama' => $data['nama'],
                'username' => $data['username'],
                'email' => $data['email']
            ];

            $_SESSION['success'] = "Login berhasil, selamat datang {$data['nama']}!";

            header("Location: index.php");
            exit;

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Username atau Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/login.css">
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
        <div class="form-wrapper">
            <form action="" method="post" enctype="multipart/form-data">
                <?php if (!empty($error)): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>
                <div class="container-table">
                    <table>
                        <tr>
                            <td><label for="username">Username:</label></td>
                            <td><input type="text" name="username" id="username" required autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email:</label></td>
                            <td><input type="email" name="email" id="email" required autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td><label for="password">Password:</label></td>
                            <td>
                                <div class="password-wrapper">
                                    <input type="password" name="password" id="password" required autocomplete="off">
                                    <i class="fa-solid fa-eye" onclick="togglePassword('password',this)"></i>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <button class="btn-submit" type="submit" name="login">Login</button>
                </div>


            </form>
    </section>


    </div>

    <?php include 'layout/footer.php'; ?>


    <?php if (isset($_SESSION['logout_success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Logout Berhasil 👋',
                text: '<?= $_SESSION['logout_success']; ?>',
                confirmButtonColor: '#3085d6'
            });
        </script>
        <?php unset($_SESSION['logout_success']); endif; ?>

</body>

</html>

<script>
    function togglePassword(id, icon) {
        const input = document.getElementById(id);

        if (!input) return;

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>