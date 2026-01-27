<?php
session_start();
include 'koneksi/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id_sewa = (int) $_GET['id'];

/* AMBIL DATA SEWA */
$sql = "
SELECT p.*, m.nama_mobil, m.harga_sewa_harian
FROM penyewaan p
JOIN mobil m ON p.id_mobil = m.id_mobil
WHERE p.id_sewa = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_sewa);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    echo "Data sewa tidak ditemukan";
    exit;
}

/* PROSES UPLOAD */
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $metode = $_POST['metode'];
    $jumlah_bayar = $data['total_harga']; // AMBIL DARI SEWA

    if (!isset($_FILES['bukti']) || $_FILES['bukti']['error'] !== 0) {
        $error = "Upload bukti pembayaran wajib!";
    } else {

        $ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
        $namaFile = "bukti_" . time() . "." . $ext;

        move_uploaded_file(
            $_FILES['bukti']['tmp_name'],
            "uploads/bukti/" . $namaFile
        );

        // status TIDAK DIISI → pakai DEFAULT database
        $sql = "INSERT INTO pembayaran 
                (id_sewa, metode, jumlah_bayar, foto_pembayaran)
                VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "isis",
            $id_sewa,
            $metode,
            $jumlah_bayar,
            $namaFile
        );

        if ($stmt->execute()) {

            // status sewa tetap "berjalan" / "menunggu verifikasi"
            $conn->query("
                UPDATE penyewaan 
                SET status_sewa = 'menunggu verifikasi' 
                WHERE id_sewa = $id_sewa
            ");

            $success = "Pembayaran berhasil dikirim, menunggu verifikasi admin";
        } else {
            $error = "Gagal menyimpan pembayaran";
        }
    }
}


$enumQuery = $conn->query("SHOW COLUMNS FROM pembayaran LIKE 'metode'");
$enumRow = $enumQuery->fetch_assoc();

preg_match("/^enum\((.*)\)$/", $enumRow['Type'], $matches);
$enumValues = str_getcsv($matches[1], ',', "'");

?>

<head>

    
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/pembayaran.css">
    <title>Pembayaran</title>
</head>
<section class="pembayaran-wrapper">
    <a href="index.php" class="btn-close">x</a>
    <h2>Pembayaran</h2>

    <div class="pembayaran-info">
        <p><strong>Mobil:</strong> <?= $data['nama_mobil']; ?></p>
        <p><strong>Total:</strong> Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></p>
        <div class="qris-box">
            <img src="public/qris.jpeg" alt="Pembayaran" class="image">
        </div>
        
    </div>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p><?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?= $success ?></p><?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="form-pembayaran">
        <label>Pembayaran</label>
        <select name="metode" id="" class="select-pembayaran" required>
            <option value="">--Pilih Pembayaran--</option>
            <?php foreach ($enumValues as $metode): ?>
                <option value="<?= $metode ?>">
                    <?= strtoupper($metode) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Bukti Pembayaran</label>
        <input type="file" name="bukti" accept="image/*" required>

        <button type="submit">Kirim Pembayaran</button>
    </form>

</section>