<?php

include 'koneksi/koneksi.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama     = $conn->real_escape_string($_POST['nama']);
    $username = $conn->real_escape_string($_POST['username']);
    $email    = $conn->real_escape_string($_POST['email']);
    $no_hp    = $conn->real_escape_string($_POST['no_hp']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $alamat   = $conn->real_escape_string($_POST['alamat']);

    /* ================= VALIDASI INPUT ================= */

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    }
    elseif (!preg_match('/^\d{10,15}$/', $no_hp)) {
        $error = "No telepon harus 10–15 digit angka!";
    }
    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        $error = "Password minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, dan simbol!";
    }
    elseif ($password !== $confirm) {
        $error = "Password dan Confirm Password tidak sama!";
    }
    else {

        /* ================= CEK USERNAME ================= */
        $check = $conn->query("SELECT * FROM users WHERE username='$username'");
        if ($check->num_rows > 0) {
            $error = "Username sudah digunakan!";
        }
        else {

            /* ================= UPLOAD FOTO KTP ================= */
            $uploadDir = "uploads/ktp/";

            $namaFile = $_FILES['foto_ktp']['name'];
            $tmpFile  = $_FILES['foto_ktp']['tmp_name'];
            $sizeFile = $_FILES['foto_ktp']['size'];
            $errorFile = $_FILES['foto_ktp']['error'];

            $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png'];

            if ($errorFile !== 0) {
                $error = "Gagal upload foto!";
            }
            elseif (!in_array($ext, $allowed)) {
                $error = "Format foto harus JPG atau PNG!";
            }
            elseif ($sizeFile > 2 * 1024 * 1024) {
                $error = "Ukuran foto maksimal 2MB!";
            }
            else {

                $namaBaru = 'ktp_' . time() . '.' . $ext;

                if (move_uploaded_file($tmpFile, $uploadDir . $namaBaru)) {

                    /* ================= HASH PASSWORD ================= */
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    /* ================= INSERT DATABASE ================= */
                    $insert_sql = "
                        INSERT INTO users (nama, username, email, no_hp, password, alamat, foto_ktp)
                        VALUES ('$nama', '$username', '$email', '$no_hp', '$hashed_password', '$alamat', '$namaBaru')
                    ";

                    if ($conn->query($insert_sql)) {
                        header("Location: login.php");
                        exit;
                    } else {
                        $error = "Gagal menyimpan data: " . $conn->error;
                    }

                } else {
                    $error = "Gagal menyimpan file ke folder!";
                }
            }
        }
    }
}


// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $nama = $conn->real_escape_string($_POST['nama']);
//     $username = $conn->real_escape_string($_POST['username']);
//     $email = $conn->real_escape_string($_POST['email']);
//     $no_hp = $conn->real_escape_string($_POST['no_hp']);
//     $password = $_POST['password'];
//     $confirm = $_POST['confirm_password'];
//     $alamat = $conn->real_escape_string($_POST['alamat']);
//     $foto_ktp = $conn->real_escape_string($_POST['foto_ktp']);

//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $error = "Format email tidak valid!";
//     } elseif (!preg_match('/^\d{10,15}$/', $no_hp)) {
//         $error = "No telepon tidak sah! Harus terdiri dari 10-15 digit angka!";
//     } elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)){
//         $error = "Password minimal harus 8 karakter dan mengandung huruf besar, huruf kecil,angka, dan simbol!";
//     } elseif ($password !== $confirm) {
//         $error = "Password tidak sama!";
//     } else {
//         $check_sql = "SELECT * FROM users WHERE username = '$username'";
//         $check_result = $conn->query($check_sql);

//         if ($check_result === false) {
//             $error = "Gagal mengecek Username: " . $conn->error;
//         } elseif ($check_result->num_rows > 0) {
//             $error = "Username sudah ada, Silahkan untuk diganti!";
//         } else {
//             $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//             $insert_sql = "INSERT INTO users (nama,username,email,no_hp,password,alamat,foto_ktp) 
//             VALUES ('$nama', '$username', '$email', '$no_hp', '$hashed_password', '$alamat', '$foto_ktp')";

//             if (!$conn->query($insert_sql)) {
//                 $error = "Gagal mendaftar: " . $conn->error;
//             } else {
//                 header("Location: login.php");
//                 exit;
//             }

//         }


//     }
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/daftar.css">
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
                            <td><label for="nama">Nama:</label></td>
                            <td><input type="text" name="nama" id="nama" required autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td><label for="username">Username:</label></td>
                            <td><input type="text" name="username" id="username" required autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email:</label></td>
                            <td><input type="email" name="email" id="email" required autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td><label for="no_hp">No Hp:</label></td>
                            <td><input type="number" name="no_hp" id="no_hp" required autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td><label for="password">Password:</label></td>
                            <p>Password minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, dan simbol!</p>
                            <td>
                                <div class="password-wrapper">
                                    <input type="password" name="password" id="password" required autocomplete="off"  >
                                    <i class="fa-solid fa-eye" onclick="togglePassword('password',this)"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="confirm_password">Confirm Password;</label></td>
                            <td>
                                <div class="password-wrapper">
                                    <input type="password" name="confirm_password" id="confirm_password" required autocomplete="off">
                                    <i class="fa-solid fa-eye" onclick="togglePassword('confirm_password',this)"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="alamat">Alamat:</label></td>
                            <td><textarea name="alamat" id="alamat" required autocomplete="off"></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="foto">Foto KTP:</label></td>
                            <td><input type="file" name="foto_ktp" accept="image/*" required></td>
                        </tr>
                    </table>
                    <button class="btn-submit" type="submit" name="submit">Daftar</button>
                </div>


            </form>
    </section>


    </div>

    <?php include 'layout/footer.php'; ?>


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
