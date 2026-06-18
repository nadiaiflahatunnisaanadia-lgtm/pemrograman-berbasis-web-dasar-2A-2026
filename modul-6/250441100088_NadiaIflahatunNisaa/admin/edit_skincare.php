<?php
session_start();

include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: ../auth/login_admin.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    header("Location: ../auth/login_admin.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_prepare(
    $conn,
    "SELECT * FROM skincare WHERE id=?"
);

mysqli_stmt_bind_param($query, "i", $id);

mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);

$data = mysqli_fetch_assoc($result);

$message = "";

if(isset($_POST['update'])){

    $nama_produk = htmlspecialchars($_POST['nama_produk']);
    $jenis = htmlspecialchars($_POST['jenis']);
    $brand = htmlspecialchars($_POST['brand']);
    $manfaat = htmlspecialchars($_POST['manfaat']);
    $tanggal_rilis = $_POST['tanggal_rilis'];
    $rating = $_POST['rating'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    // LINK SHOPEE
    $link_beli = htmlspecialchars($_POST['link_beli']);

    $gambarLama = $data['gambar'];

    if($_FILES['gambar']['name'] != ""){

        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file(
            $tmp,
            "../assets/img/" . $gambar
        );

    } else {

        $gambar = $gambarLama;
    }

    $update = mysqli_prepare(
        $conn,
        "UPDATE skincare SET
        nama_produk=?,
        jenis=?,
        brand=?,
        manfaat=?,
        tanggal_rilis=?,
        rating=?,
        deskripsi=?,
        gambar=?,
        link_beli=?
        WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $update,
        "sssssdsssi",
        $nama_produk,
        $jenis,
        $brand,
        $manfaat,
        $tanggal_rilis,
        $rating,
        $deskripsi,
        $gambar,
        $link_beli,
        $id
    );

    if(mysqli_stmt_execute($update)){
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Gagal update skincare";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Skincare</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: #f5f3ff;
}

.card-form{
    border: none;
    border-radius: 25px;
}

.preview-img{
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 20px;
}

</style>

</head>
<body>

<div class="container py-5">

<div class="card card-form shadow p-4">

<h2 class="fw-bold mb-4">
Edit Skincare ✨
</h2>

<?php if($message) : ?>
<div class="alert alert-danger">
<?= $message; ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<img
src="../assets/img/<?= htmlspecialchars($data['gambar']); ?>"
class="preview-img"
>

</div>

<div class="mb-3">

<label>Nama Produk</label>

<input type="text" name="nama_produk" class="form-control"
value="<?= htmlspecialchars($data['nama_produk']); ?>" required>

</div>

<div class="mb-3">

<label>Jenis</label>

<input type="text" name="jenis" class="form-control"
value="<?= htmlspecialchars($data['jenis']); ?>" required>

</div>

<div class="mb-3">

<label>Brand</label>

<input type="text" name="brand" class="form-control"
value="<?= htmlspecialchars($data['brand']); ?>" required>

</div>

<div class="mb-3">

<label>Manfaat</label>

<textarea name="manfaat" class="form-control" required>
<?= htmlspecialchars($data['manfaat']); ?>
</textarea>

</div>

<div class="mb-3">

<label>Tanggal Rilis</label>

<input type="date" name="tanggal_rilis" class="form-control"
value="<?= htmlspecialchars($data['tanggal_rilis']); ?>" required>

</div>

<div class="mb-3">

<label>Rating</label>

<input type="number" step="0.1" name="rating" class="form-control"
min="1" max="10"
value="<?= htmlspecialchars($data['rating']); ?>" required>

</div>

<!-- LINK SHOPEE -->
<div class="mb-3">

<label>Link Pembelian (Shopee)</label>

<input type="text" name="link_beli" class="form-control"
value="<?= htmlspecialchars($data['link_beli']); ?>"
placeholder="https://shopee.co.id/..." required>

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea name="deskripsi" class="form-control" required>
<?= htmlspecialchars($data['deskripsi']); ?>
</textarea>

</div>

<div class="mb-3">

<label>Ganti Gambar Produk</label>

<input type="file" name="gambar" class="form-control">

</div>

<button type="submit" name="update" class="btn btn-primary">
Update
</button>

<a href="dashboard.php" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

</body>
</html>