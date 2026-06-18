<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/pilih_login.php");
    exit;
}
?>