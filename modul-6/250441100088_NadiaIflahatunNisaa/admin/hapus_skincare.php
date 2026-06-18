<?php
session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login_admin.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_prepare(
    $conn,
    "DELETE FROM skincare WHERE id=?"
);

mysqli_stmt_bind_param($query, "i", $id);

mysqli_stmt_execute($query);

header("Location: dashboard.php");
exit;
?>