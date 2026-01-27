<?php
session_start();

$_SESSION['logout_success'] = "Anda berhasil logout.";

unset($_SESSION['login'], $_SESSION['user']);

header("Location: login.php");
exit;
?>