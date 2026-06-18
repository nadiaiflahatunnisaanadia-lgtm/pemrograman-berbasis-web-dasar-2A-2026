<?php
session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'user'){

    header("Location: ../auth/login_user.php");
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

if(isset($_POST['favorit'])){

    $user_id = $_SESSION['id'];
    $skincare_id = $id;

    // 🔥 CEK DUPLIKAT FAVORIT
    $cek = mysqli_prepare(
        $conn,
        "SELECT id FROM favorit WHERE user_id=? AND skincare_id=?"
    );

    mysqli_stmt_bind_param($cek, "ii", $user_id, $skincare_id);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if(mysqli_stmt_num_rows($cek) > 0){

        $message = "⚠️ Produk sudah ada di favorit";

    } else {

        $insert = mysqli_prepare(
            $conn,
            "INSERT INTO favorit (user_id, skincare_id)
            VALUES(?,?)"
        );

        mysqli_stmt_bind_param(
            $insert,
            "ii",
            $user_id,
            $skincare_id
        );

        if(mysqli_stmt_execute($insert)){

            $message = "Berhasil ditambahkan ke favorit 💖";

        } else {

            $message = "Gagal menambahkan favorit";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Detail Skincare</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: #fff5f8;
}

.detail-card{
    border: none;
    border-radius: 25px;
}

.detail-img{
    width: 100%;
    height: 350px;
    object-fit: cover;
    border-radius: 20px;
}

</style>

</head>
<body>

<div class="container py-5">

<div class="card detail-card shadow p-5">

<img
src="../assets/img/<?= htmlspecialchars($data['gambar']); ?>"
class="detail-img mb-4"
>

<h2 class="fw-bold mb-3">
<?= htmlspecialchars($data['nama_produk']); ?>
</h2>

<p class="text-muted">
<?= htmlspecialchars($data['brand']); ?>
</p>

<span class="badge bg-success mb-3">
<?= htmlspecialchars($data['rating']); ?>/10
</span>

<h5>Jenis</h5>
<p><?= htmlspecialchars($data['jenis']); ?></p>

<h5>Manfaat</h5>
<p><?= htmlspecialchars($data['manfaat']); ?></p>

<h5>Deskripsi</h5>
<p><?= htmlspecialchars($data['deskripsi']); ?></p>

<!-- 🔥 LINK SHOPEE -->
<?php if(!empty($data['link_beli'])) : ?>
<a href="<?= htmlspecialchars($data['link_beli']); ?>"
target="_blank"
class="btn btn-danger mb-3">
🛒 Beli di Shopee
</a>
<?php endif; ?>

<?php if($message) : ?>
<div class="alert alert-info">
<?= $message; ?>
</div>
<?php endif; ?>

<hr>

<h4 class="fw-bold mb-3">
Tambah ke Favorit 💖
</h4>

<form method="POST">

<button type="submit" name="favorit" class="btn btn-primary mb-3">
Simpan ke Favorit
</button>

<a href="dashboard.php" class="btn btn-secondary mb-3">
Kembali
</a>

</form>

</div>

</div>

</body>
</html>