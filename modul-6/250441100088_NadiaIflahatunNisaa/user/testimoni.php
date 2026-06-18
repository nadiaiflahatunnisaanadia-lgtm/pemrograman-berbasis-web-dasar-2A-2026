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
AMBIL DATA TESTIMONI USER
JOIN: testimoni + skincare
*/
$query = mysqli_prepare(
    $conn,
    "SELECT 
        testimoni.*,
        skincare.nama_produk,
        skincare.brand
    FROM testimoni
    INNER JOIN skincare
    ON testimoni.skincare_id = skincare.id
    WHERE testimoni.user_id = ?
    ORDER BY testimoni.id DESC"
);

mysqli_stmt_bind_param($query, "i", $user_id);

mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);

/*
AMBIL LIST PRODUK UNTUK PILIH SKINCARE (FIX DI SINI)
*/
$produk = mysqli_query(
    $conn,
    "SELECT id AS skincare_id, nama_produk 
     FROM skincare 
     ORDER BY nama_produk ASC"
);

$message = "";

/*
INSERT TESTIMONI
*/
if(isset($_POST['kirim'])){

    $skincare_id = $_POST['skincare_id'];
    $catatan = htmlspecialchars($_POST['catatan']);
    $status = htmlspecialchars($_POST['status_pakai']);

    $insert = mysqli_prepare(
        $conn,
        "INSERT INTO testimoni (user_id, skincare_id, catatan, status_pakai)
        VALUES(?,?,?,?)"
    );

    mysqli_stmt_bind_param(
        $insert,
        "iiss",
        $user_id,
        $skincare_id,
        $catatan,
        $status
    );

    if(mysqli_stmt_execute($insert)){
        $message = "Testimoni berhasil dikirim 💖";
    } else {
        $message = "Gagal mengirim testimoni";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Testimoni</title>

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
Testimoni Skincare 💬
</h2>

<?php if($message) : ?>
<div class="alert alert-info">
<?= $message; ?>
</div>
<?php endif; ?>

<!-- FORM TESTIMONI -->
<form method="POST" class="mb-4">

<div class="mb-3">

<label>Pilih Skincare</label>

<select name="skincare_id" class="form-select" required>

<option value="">-- Pilih Produk --</option>

<?php while($p = mysqli_fetch_assoc($produk)) : ?>

<option value="<?= $p['skincare_id']; ?>">
<?= $p['nama_produk']; ?>
</option>

<?php endwhile; ?>

</select>

</div>

<div class="mb-3">

<label>Catatan Kulit</label>

<textarea name="catatan" class="form-control" required></textarea>

</div>

<div class="mb-3">

<label>Status Pemakaian</label>

<select name="status_pakai" class="form-select" required>

<option value="">-- Pilih --</option>
<option value="Cocok">Cocok</option>
<option value="Tidak Cocok">Tidak Cocok</option>
<option value="Masih Mencoba">Masih Mencoba</option>

</select>

</div>

<button type="submit" name="kirim" class="btn btn-primary">
Kirim Testimoni
</button>

</form>

<hr>

<!-- LIST TESTIMONI -->
<h5 class="fw-bold mb-3">Riwayat Testimoni</h5>

<?php if(mysqli_num_rows($result) > 0) : ?>

<table class="table table-hover">

<thead>
<tr>
<th>Produk</th>
<th>Brand</th>
<th>Catatan</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)) : ?>

<tr>

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

<?php else : ?>

<div class="alert alert-warning">
Belum ada testimoni
</div>

<?php endif; ?>

<a href="dashboard.php" class="btn btn-secondary mt-3">
Kembali
</a>

</div>

</div>

</body>
</html>