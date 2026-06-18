<?php
session_start();

include '../config/koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: ../auth/login_user.php");
    exit;
}

if($_SESSION['role'] != 'user'){
    header("Location: ../auth/login_user.php");
    exit;
}

$user_id = $_SESSION['id'];

/*
AMBIL DATA FAVORIT USER (FIXED: prepared statement)
*/
$query = mysqli_prepare(
    $conn,
    "SELECT 
        favorit.*,
        skincare.nama_produk,
        skincare.brand,
        skincare.id AS skincare_id
    FROM favorit
    INNER JOIN skincare
    ON favorit.skincare_id = skincare.id
    WHERE favorit.user_id = ?"
);

mysqli_stmt_bind_param($query, "i", $user_id);

mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Favorit</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ffe4ec, #fff5f8);
}

.card-box{
    border: none;
    border-radius: 25px;
    background: #ffffffcc;
    box-shadow: 0 8px 20px rgba(255, 105, 135, 0.15);
}

</style>

</head>
<body>

<div class="container py-5">

<div class="card card-box shadow p-4">

<h2 class="fw-bold mb-4">
Skincare Favorit 💖
</h2>

<?php if(mysqli_num_rows($result) > 0) : ?>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-light">

<tr>
<th>No</th>
<th>Produk</th>
<th>Brand</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

<?php
$no = 1;

while($row = mysqli_fetch_assoc($result)) :
?>

<tr>

<td><?= $no++; ?></td>

<td><?= htmlspecialchars($row['nama_produk']); ?></td>

<td><?= htmlspecialchars($row['brand']); ?></td>

<td>

<a href="detail.php?id=<?= $row['skincare_id']; ?>"
class="btn btn-sm btn-info">
Detail
</a>

<a href="hapus_favorit.php?id=<?= $row['id']; ?>"
class="btn btn-sm btn-danger"
onclick="return confirm('Hapus dari favorit?')">
Hapus
</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php else : ?>

<div class="alert alert-warning">
Belum ada skincare favorit
</div>

<?php endif; ?>

<a href="dashboard.php" class="btn btn-secondary mt-3">
Kembali
</a>

</div>

</div>

</body>
</html>