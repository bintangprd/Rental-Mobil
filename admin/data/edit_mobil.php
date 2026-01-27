<?php
session_start();
include '../../koneksi/koneksi.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: data_mobil.php");
    exit;
}

$id_mobil = (int) $_GET['id'];

// Ambil data mobil
$result = $conn->query("SELECT * FROM mobil WHERE id_mobil = $id_mobil");
$data = $result->fetch_assoc();

if (!$data) {
    die("Data mobil tidak ditemukan");
}

// PROSES UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_mobil = $conn->real_escape_string($_POST['nmobil']);
    $merk = $conn->real_escape_string($_POST['merk']);
    $tahun = $conn->real_escape_string($_POST['tahun']);
    $plat_nomor = $conn->real_escape_string($_POST['plat_nomor']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $warna = $conn->real_escape_string($_POST['warna']);
    $harga = $conn->real_escape_string($_POST['harga_sewa']);
    $status = $conn->real_escape_string($_POST['status']);
    $jumlah = $conn->real_escape_string($_POST['jumlah_mobil']);

    $fotoBaru = $data['foto'];

    // Jika upload foto baru
    if (!empty($_FILES['foto']['name'])) {

        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {

            $uploadDir = "../../uploads/mobil/";
            $fotoBaru = 'mobil_' . time() . '_' . rand(100, 999) . '.' . $ext;

            move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $fotoBaru);

            // Hapus foto lama
            if (!empty($data['foto']) && file_exists($uploadDir . $data['foto'])) {
                unlink($uploadDir . $data['foto']);
            }
        }
    }

    $update = "
        UPDATE mobil SET
            nama_mobil='$nama_mobil',
            merk='$merk',
            tahun='$tahun',
            plat_nomor='$plat_nomor',
            deskripsi='$deskripsi',
            warna='$warna',
            harga_sewa_harian='$harga',
            status='$status',
            foto='$fotoBaru',
            jumlah_mobil='$jumlah'
        WHERE id_mobil=$id_mobil
    ";

    if ($conn->query($update)) {
        $success = "Data mobil berhasil diperbarui";
        $data = $conn->query("SELECT * FROM mobil WHERE id_mobil=$id_mobil")->fetch_assoc();
    } else {
        $error = "Gagal update data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil</title>
    <link rel="stylesheet" href="../style/edit_mobil.css">
    <!-- <link rel="stylesheet" href="../../style/style.css"> -->
</head>

<body>
    <form method="post" enctype="multipart/form-data">

        <?php if (!empty($error)): ?>
            <p style="color:red"><?= $error ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p style="color:green"><?= $success ?></p>
        <?php endif; ?>


        <div class="container-table">
            <h2><a href="data_mobil.php" class="btn-close">x</a></h2>
            <h3><strong>Edit Mobil</strong></h3>
            <table>
                <tr>
                    <td>Nama Mobil</td>
                    <td><input type="text" name="nmobil" value="<?= $data['nama_mobil'] ?>" required></td>
                </tr>
                <tr>
                    <td>Merk</td>
                    <td><input type="text" name="merk" value="<?= $data['merk'] ?>" required></td>
                </tr>
                <tr>
                    <td>Tahun</td>
                    <td><input type="number" name="tahun" value="<?= $data['tahun'] ?>" required></td>
                </tr>
                <tr>
                    <td>Plat Nomor</td>
                    <td><input type="text" name="plat_nomor" value="<?= $data['plat_nomor'] ?>" required></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td><textarea name="deskripsi" required><?= $data['deskripsi'] ?></textarea></td>
                </tr>
                <tr>
                    <td>Warna</td>
                    <td><input type="text" name="warna" value="<?= $data['warna'] ?>" required></td>
                </tr>
                <tr>
                    <td>Harga Sewa</td>
                    <td><input type="text" name="harga_sewa" value="<?= $data['harga_sewa_harian'] ?>" required></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option value="Tersedia" <?= $data['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia
                            </option>
                            <option value="Disewa" <?= $data['status'] == 'Disewa' ? 'selected' : '' ?>>Disewa</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Mobil</td>
                    <td><input type="number" name="jumlah_mobil" value="<?= $data['jumlah_mobil'] ?>" required></td>
                </tr>
                <tr>
                    <td>Foto</td>
                    <td>
                        <img src="../../uploads/mobil/<?= $data['foto'] ?>" width="120"><br>
                        <input type="file" name="foto" accept="image/*">
                        <small>*Kosongkan jika tidak diganti</small>
                    </td>
                </tr>
            </table>

            <button type="submit" class="btn-submit">Update Mobil</button>
        </div>
    </form>

</body>

</html>