<?php
include '../../koneksi/koneksi.php';
session_start();

// ✅ CEK LOGIN ADMIN (FIX)
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: data_transaksi.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: pembayaran.php");
    exit();
}

$id_pembayaran = (int) $_GET['id'];

// Ambil data pembayaran
$stmt = $conn->prepare(
    "SELECT id_sewa FROM pembayaran WHERE id_pembayaran = ?"
);
$stmt->bind_param("i", $id_pembayaran);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Data pembayaran tidak ditemukan");
}

$id_sewa = $data['id_sewa'];

// Update pembayaran
$stmt = $conn->prepare(
    "UPDATE pembayaran SET status = 'Lunas' WHERE id_pembayaran = ?"
);
$stmt->bind_param("i", $id_pembayaran);
$stmt->execute();

// Update penyewaan
$stmt = $conn->prepare(
    "UPDATE penyewaan SET status_sewa = 'berjalan' WHERE id_sewa = ?"
);
$stmt->bind_param("i", $id_sewa);
$stmt->execute();

header("Location: data_transaksi.php");
exit;
?>