<?php
session_start();
include '../../koneksi/koneksi.php';

/* ================= CEK LOGIN ADMIN ================= */
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

/* ================= VALIDASI ID ================= */
if (!isset($_GET['id'])) {
    header("Location: data_mobil.php");
    exit;
}

$id_mobil = (int) $_GET['id'];

/* ================= AMBIL DATA MOBIL ================= */
$stmt = $conn->prepare("SELECT foto FROM mobil WHERE id_mobil = ?");
$stmt->bind_param("i", $id_mobil);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    $_SESSION['error'] = "Data mobil tidak ditemukan!";
    header("Location: data_mobil.php");
    exit;
}

/* ================= HAPUS FOTO ================= */
$pathFoto = "../../uploads/mobil/" . $data['foto'];
if (!empty($data['foto']) && file_exists($pathFoto)) {
    unlink($pathFoto);
}

/* ================= HAPUS DATA ================= */
$del = $conn->prepare("DELETE FROM mobil WHERE id_mobil = ?");
$del->bind_param("i", $id_mobil);

if ($del->execute()) {
    $_SESSION['success'] = "Mobil berhasil dihapus";
} else {
    $_SESSION['error'] = "Gagal menghapus mobil";
}

header("Location: data_mobil.php");
exit;
