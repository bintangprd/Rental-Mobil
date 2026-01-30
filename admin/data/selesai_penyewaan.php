<?php
session_start();
include '../../koneksi/koneksi.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!isset($_SESSION['admin_login'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id_sewa'])) {
    die("ID sewa tidak ditemukan");
}

$id_sewa = (int) $_GET['id_sewa'];

/* Ambil data penyewaan */
$stmt = $conn->prepare(
    "SELECT id_mobil, status_sewa 
     FROM penyewaan 
     WHERE id_sewa = ?"
);
$stmt->bind_param("i", $id_sewa);
$stmt->execute();
$sewa = $stmt->get_result()->fetch_assoc();

if (!$sewa) {
    die("Data penyewaan tidak ditemukan");
}

/* Cek sudah selesai */
if ($sewa['status_sewa'] === 'selesai') {
    header("Location: data_penyewaan.php");
    exit;
}

/* Cek pembayaran */
$stmt = $conn->prepare(
    "SELECT status FROM pembayaran WHERE id_sewa = ?"
);
$stmt->bind_param("i", $id_sewa);
$stmt->execute();
$bayar = $stmt->get_result()->fetch_assoc();

if (!$bayar || $bayar['status'] !== 'Lunas') {
    die("Penyewaan belum lunas");
}

$id_mobil = $sewa['id_mobil'];

/* TRANSAKSI */
$conn->begin_transaction();

try {
    // update penyewaan
    $stmt = $conn->prepare(
        "UPDATE penyewaan 
         SET status_sewa = 'selesai' 
         WHERE id_sewa = ?"
    );
    $stmt->bind_param("i", $id_sewa);
    $stmt->execute();

    // update stok mobil
    $stmt = $conn->prepare(
        "UPDATE mobil 
         SET jumlah_mobil = jumlah_mobil + 1 
         WHERE id_mobil = ?"
    );
    $stmt->bind_param("i", $id_mobil);
    $stmt->execute();

    $conn->commit();

} catch (mysqli_sql_exception $e) {
    $conn->rollback();
    die("ERROR DATABASE: " . $e->getMessage());
}

header("Location: data_penyewaan.php");
exit;
?>