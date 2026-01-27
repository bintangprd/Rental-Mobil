<?php
session_start();
include 'koneksi/koneksi.php';

$error = "";
$success = "";

/* ================= VALIDASI ID MOBIL ================= */
if (!isset($_GET['id'])) {
    header("Location: mobil.php");
    exit;
}

$id_mobil = (int) $_GET['id'];

/* ================= AMBIL DATA MOBIL ================= */
$stmt = $conn->prepare("SELECT * FROM mobil WHERE id_mobil = ?");
$stmt->bind_param("i", $id_mobil);
$stmt->execute();
$mobil = $stmt->get_result()->fetch_assoc();

if (!$mobil) {
    die("Mobil tidak ditemukan");
}

/* ================= CEK MEMBER / GUEST ================= */
$is_member = isset($_SESSION['login']) && isset($_SESSION['user']);
$id_user   = $is_member ? $_SESSION['user']['id_user'] : NULL;

$nama_member = "";
$hp_member   = "";
$diskon      = 0;

if ($is_member) {

    // ambil langsung dari session
    $nama_member = $_SESSION['user']['nama'];

    // ambil no_hp dari database (karena tidak disimpan di session)
    $u = $conn->prepare("SELECT no_hp FROM users WHERE id_user = ?");
    $u->bind_param("i", $id_user);
    $u->execute();
    $user = $u->get_result()->fetch_assoc();

    $hp_member = $user['no_hp'];

    // hitung total sewa
    $c = $conn->prepare("SELECT COUNT(*) total FROM penyewaan WHERE id_user = ?");
    $c->bind_param("i", $id_user);
    $c->execute();
    $total_sewa = $c->get_result()->fetch_assoc()['total'];

    if ($total_sewa >= 3) {
        $diskon = 0.10;
    }
}

/* ================= PROSES SEWA ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tgl_sewa = $_POST['tgl_sewa'];
    $tgl_kembali = $_POST['tgl_kembali'];

    $nama = $is_member ? $nama_member : trim($_POST['nama']);
    $hp = $is_member ? $hp_member : trim($_POST['hp']);

    if ($tgl_kembali <= $tgl_sewa) {
        $error = "Tanggal kembali harus lebih dari tanggal sewa!";
    } elseif ($mobil['jumlah_mobil'] <= 0) {
        $error = "Stok mobil habis!";
    } else {

        /* HITUNG SEWA */
        $hari = (strtotime($tgl_kembali) - strtotime($tgl_sewa)) / 86400;
        $total = $hari * $mobil['harga_sewa_harian'];

        if ($diskon > 0) {
            $total -= ($total * $diskon);
        }

        /* SIMPAN PENYEWAAN */
        $sql = "INSERT INTO penyewaan
                (id_user, id_mobil, tanggal_sewa, tanggal_kembali, lama_sewa, total_harga, status_sewa, nama_penyewa, no_hp)
                VALUES (?, ?, ?, ?, ?, ?, 'booking', ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "iissidss",
            $id_user,
            $id_mobil,
            $tgl_sewa,
            $tgl_kembali,
            $hari,
            $total,
            $nama,
            $hp
        );

        if ($stmt->execute()) {

            $id_sewa = $stmt->insert_id;

            // Kurangi stok
            $conn->query("UPDATE mobil SET jumlah_mobil = jumlah_mobil - 1 WHERE id_mobil = $id_mobil");

            header("Location: pembayaran.php?id=$id_sewa");
            exit;
        } else {
            $error = "Gagal menyimpan data sewa!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sewa Mobil</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/sewa.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include 'layout/header.php'; ?>

    <section class="sewa-wrapper">

        <div class="mobil-card">
            <img src="uploads/mobil/<?= $mobil['foto']; ?>">
            <h2><?= $mobil['nama_mobil']; ?></h2>

            <p class="harga">
                Rp <?= number_format($mobil['harga_sewa_harian'], 0, ',', '.'); ?> / hari
            </p>

            <?php if ($is_member && $diskon > 0): ?>
                <p class="badge-member">Diskon Member 10%</p>
            <?php elseif ($is_member): ?>
                <p class="badge-guest">Member (Belum Diskon)</p>
            <?php else: ?>
                <p class="badge-guest">Guest (Tanpa Diskon)</p>
            <?php endif; ?>
                <p class="warna">Warna:
                    <?= nl2br($mobil['warna'])?></p>
            <p class="deskripsi"><?= nl2br($mobil['deskripsi']); ?></p>
        </div>

        <div class="form-sewa">
            <h4><a href="mobil.php" class="btn-close">x</a></h4>
            <h3>Form Penyewaan</h3>
            

            <?php if ($error): ?>
                <p class="error"><?= $error; ?></p>
            <?php endif; ?>

            <form method="post">

                <label>Nama Penyewa</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($nama_member); ?>" <?= $is_member ? 'readonly' : 'required'; ?> autocomplete="off">

                <label>No HP</label>
                <input type="text" name="hp" value="<?= htmlspecialchars($hp_member); ?>" <?= $is_member ? 'readonly' : 'required'; ?> autocomplete="off">

                <label>Tanggal Sewa</label>
                <input type="date" name="tgl_sewa" required>

                <label>Tanggal Kembali</label>
                <input type="date" name="tgl_kembali" required>

                <button type="submit">Sewa Sekarang</button>
            </form>
        </div>

    </section>

    <?php include 'layout/footer.php'; ?>

</body>

</html>