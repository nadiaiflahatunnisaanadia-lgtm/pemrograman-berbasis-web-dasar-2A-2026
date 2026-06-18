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

/*
AMBIL SEMUA TESTIMONI
JOIN 3 TABEL:
users + skincare + testimoni
*/
$query = mysqli_query(
    $conn,
    "SELECT 
        testimoni.*,
        users.nama AS nama_user,
        skincare.nama_produk,
        skincare.brand
    FROM testimoni
    INNER JOIN users
        ON testimoni.user_id = users.id
    INNER JOIN skincare
        ON testimoni.skincare_id = skincare.id
    ORDER BY testimoni.id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Testimoni User</title>

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

.table th{
    background: #ff8fab !important;
    color: white;
}

</style>

</head>
<body>

<div class="container py-5">

<div class="card card-box shadow p-4">

<h2 class="fw-bold mb-4">
Testimoni User 💬
</h2>

<?php if(mysqli_num_rows($query) > 0) : ?>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>
<th>User</th>
<th>Skincare</th>
<th>Brand</th>
<th>Catatan</th>
<th>Status</th>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($query)) : ?>

<tr>

<td><?= htmlspecialchars($row['nama_user']); ?></td>

<td><?= htmlspecialchars($row['nama_produk']); ?></td>

<td><?= htmlspecialchars($row['brand']); ?></td>

<td><?= htmlspecialchars($row['catatan']); ?></td>

<td>
<span class="badge bg-primary">
<?= htmlspecialchars($row['status_pakai']); ?>
</span>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php else : ?>

<div class="alert alert-warning">
Belum ada testimoni user
</div>

<?php endif; ?>

<a href="dashboard.php" class="btn btn-secondary mt-3">
Kembali
</a>

</div>

</div>

</body>
</html>