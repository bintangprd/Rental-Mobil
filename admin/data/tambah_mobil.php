<?php
session_start();
include '../../koneksi/koneksi.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_mobil = $conn->real_escape_string($_POST['nmobil']);
    $merk = $conn->real_escape_string($_POST['merk']);
    $tahun = $conn->real_escape_string($_POST['tahun']);
    $plat_nomor = $conn->real_escape_string($_POST['plat_nomor']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $warna = $conn->real_escape_string($_POST['warna']);
    $harga_sewa_harian = $conn->real_escape_string($_POST['harga_sewa']);
    $status = $conn->real_escape_string($_POST['status']);
    $jumlah_mobil = $conn->real_escape_string($_POST['jumlah_mobil']);

    if (
        empty($nama_mobil) || empty($merk) || empty($tahun) ||
        empty($plat_nomor) || empty($harga_sewa_harian) ||
        empty($status) || empty($jumlah_mobil)
    ) {
        $error = "Semua field wajib diisi!";
    } elseif (!isset($_FILES['foto']) || $_FILES['foto']['error'] === 4) {
        $error = "Foto mobil wajib di upload!";
    } else {

        $uploadDir = "../../uploads/mobil/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $namaFile = $_FILES['foto']['name'];
        $tmpFile = $_FILES['foto']['tmp_name'];
        $sizeFile = $_FILES['foto']['size'];
        $errorFile = $_FILES['foto']['error'];

        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if ($errorFile !== 0) {
            $error = "Gagal upload foto!";
        } elseif (!in_array($ext, $allowed)) {
            $error = "Format foto harus JPG, JPEG, atau PNG!";
        } elseif ($sizeFile > 2 * 1024 * 1024) {
            $error = "Ukuran foto maksimal 2MB!";
        } else {

            $namaBaru = 'mobil_' . time() . '_' . rand(100, 999) . '.' . $ext;

            if (move_uploaded_file($tmpFile, $uploadDir . $namaBaru)) {

                $insert_sql = "
                    INSERT INTO mobil 
                    (nama_mobil, merk, tahun, plat_nomor,deskripsi,warna, harga_sewa_harian, status, foto, jumlah_mobil)
                    VALUES
                    ('$nama_mobil', '$merk', '$tahun', '$plat_nomor', '$deskripsi', '$warna','$harga_sewa_harian', '$status', '$namaBaru', '$jumlah_mobil')
                ";

                if ($conn->query($insert_sql)) {
                    $success = "Mobil berhasil ditambahkan!";
                } else {
                    $error = "Mobil gagal ditambahkan: " . $conn->error;
                }

            } else {
                $error = "Gagal memasukkan foto ke folder!";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Mobil</title>

    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/tambah_mobil.css">
    <link rel="stylesheet" href="../../style/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

    <div class="dashboard-wrapper">

        <?php include '../layout/side.php' ?>

        <!-- MAIN -->
        <main class="dashboard-content">

            <header class="dashboard-header">
                <h1>Data Mobil</h1>
                <span>Halo, <strong><?= $_SESSION['admin_username']; ?></strong></span>
            </header>

            <div class="container-navbar">
                <!-- <div class="navbar-left"></div> -->

                <ul class="ul-navbar">
                    <li class="li-navbar">
                        <a href="data_mobil.php" class="a-navbar">Data Mobil</a>
                    </li>
                    <li class="li-navbar">
                        <a href="tambah_mobil.php" class="a-navbar">Tambah Mobil</a>
                    </li>
                    <li class="li-navbar">
                        <a href="edit_mobil.php" class="a-navbar">Hapus Mobil</a>
                    </li>
                </ul>

                <!-- <div class="navbar-right"></div> -->

            </div>

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
                                <td><label for="nmobil">Nama Mobil:</label></td>
                                <td><input type="text" name="nmobil" id="nmobil" required autocomplete="off"></td>
                            </tr>
                            <tr>
                                <td><label for="merk">Merk Mobil:</label></td>
                                <td><input type="text" name="merk" id="merk" required autocomplete="off"></td>
                            </tr>
                            <tr>
                                <td><label for="tahun">Tahun Mobil:</label></td>
                                <td><input type="number" name="tahun" id="tahun" requiredmax="<?= date('Y')?>" placeholder="2022"></td>
                            </tr>
                            <tr>
                                <td><label for="plat_nomor">Plat Nomor:</label></td>
                                <td><input type="text" name="plat_nomor" id="plat_nomor" required autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="deskripsi">Deskripsi:</label></td>
                                <td><input type="textarea" name="deskripsi" id="deskripsi" required autocomplete="off"></td>
                            </tr>
                            <tr>
                                <td><label for="warna">Warna:</label></td>
                                <td><input type="text"name="warna" id="warna" required autocomplete="off"></td>
                            </tr>
                            <tr>
                                <td><label for="harga_sewa">Harga Sewa:</label></td>
                                <td><input type="text" name="harga_sewa" id="harga_sewa" required autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td><label for="status">Status:</label></td>
                                <td>
                                    <select name="status" id="status" required>
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Disewa">Disewa</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="fmobil">Foto:</label></td>
                                <td><input type="file" name="foto" required accept="image/*"></td>
                            </tr>
                            <tr>
                                <td><label for="jumlah_mobil">Jumlah Mobil: </label></td>
                                <td><input type="number" name="jumlah_mobil" id="jumlah_mobil" required
                                        autocomplete="off"></td>
                            </tr>
                        </table>
                        <button class="btn-submit" type="submit" name="submit"> <i style="fa-solid fa-plus"></i>
                            Tambah</button>

                    </div>

                </form>

            </div>


        </main>
    </div>

</body>

</html>