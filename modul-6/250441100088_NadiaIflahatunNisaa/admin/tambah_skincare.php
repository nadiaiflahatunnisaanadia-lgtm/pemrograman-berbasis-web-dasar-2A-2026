<?php
session_start();
include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login_admin.php");
    exit;
}

$message = "";

if(isset($_POST['tambah'])){

    $nama_produk = htmlspecialchars($_POST['nama_produk']);
    $jenis = htmlspecialchars($_POST['jenis']);
    $brand = htmlspecialchars($_POST['brand']);
    $manfaat = htmlspecialchars($_POST['manfaat']);
    $tanggal_rilis = $_POST['tanggal_rilis'];
    $rating = $_POST['rating'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $link_beli = htmlspecialchars($_POST['link_beli']);

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    if(empty($nama_produk) || empty($jenis) || empty($brand) || empty($manfaat) ||
       empty($tanggal_rilis) || empty($rating) || empty($deskripsi) ||
       empty($link_beli) || empty($gambar)){

        $message = "Semua field wajib diisi";

    } else {

        move_uploaded_file($tmp, "../assets/img/" . $gambar);

        $query = mysqli_prepare(
            $conn,
            "INSERT INTO skincare
            (nama_produk,jenis,brand,manfaat,tanggal_rilis,rating,deskripsi,gambar,link_beli)
            VALUES(?,?,?,?,?,?,?,?,?)"
        );

        mysqli_stmt_bind_param(
            $query,
            "sssssdsss",
            $nama_produk,
            $jenis,
            $brand,
            $manfaat,
            $tanggal_rilis,
            $rating,
            $deskripsi,
            $gambar,
            $link_beli
        );

        if(mysqli_stmt_execute($query)){
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Gagal tambah skincare";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Skincare</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ffe4ec, #fff5f8);
}

.card-form{
    border: none;
    border-radius: 25px;
    background: #ffffffcc;
    backdrop-filter: blur(6px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.btn-primary{
    background: #ff4d6d;
    border: none;
}

.btn-primary:hover{
    background: #e63e5c;
}

</style>

</head>
<body>

<div class="container py-5">

<div class="card card-form p-4">

<h2 class="fw-bold mb-4">
Tambah Skincare ✨
</h2>

<?php if($message) : ?>
<div class="alert alert-danger">
<?= $message; ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label>Nama Produk</label>
<input type="text" name="nama_produk" class="form-control" required>
</div>

<div class="mb-3">
<label>Jenis</label>
<input type="text" name="jenis" class="form-control" required>
</div>

<div class="mb-3">
<label>Brand</label>
<input type="text" name="brand" class="form-control" required>
</div>

<div class="mb-3">
<label>Manfaat</label>
<textarea name="manfaat" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>Tanggal Rilis</label>
<input type="date" name="tanggal_rilis" class="form-control" required>
</div>

<div class="mb-3">
<label>Rating</label>
<input type="number" step="0.1" name="rating" class="form-control" min="1" max="10" required>
</div>

<div class="mb-3">
<label>Link Pembelian</label>
<input type="text" name="link_beli" class="form-control" required>
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="deskripsi" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>Gambar Produk</label>
<input type="file" name="gambar" class="form-control" required>
</div>

<button type="submit" name="tambah" class="btn btn-primary">
Simpan
</button>

<a href="dashboard.php" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

</body>
</html>