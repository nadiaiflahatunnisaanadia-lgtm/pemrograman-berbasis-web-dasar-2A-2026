<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != 'user'){
    header("Location: ../auth/login_user.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['id'];

mysqli_query(
    $conn,
    "DELETE FROM favorit WHERE id='$id' AND user_id='$user_id'"
);

header("Location: favorit.php");
exit;
?>