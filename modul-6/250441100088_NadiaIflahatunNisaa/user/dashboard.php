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

$dataSkincare = mysqli_query(
    $conn,
    "SELECT * FROM skincare ORDER BY id DESC"
);

$total = mysqli_num_rows($dataSkincare);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ffe4ec, #fff5f8);
}

.sidebar{
    width: 250px;
    height: 100vh;
    background: linear-gradient(180deg,#ff8fab,#ffc2d1);
    position: fixed;
    padding: 30px 20px;
    box-shadow: 5px 0 20px rgba(0,0,0,0.05);
}

.sidebar h3{
    color: white;
    font-weight: bold;
    margin-bottom: 40px;
}

.sidebar a{
    display: block;
    color: white;
    text-decoration: none;
    padding: 12px;
    border-radius: 12px;
    margin-bottom: 10px;
    transition: 0.3s;
}

.sidebar a:hover{
    background: rgba(255,255,255,0.25);
}

.content{
    margin-left: 270px;
    padding: 30px;
}

.card-dashboard{
    border: none;
    border-radius: 20px;
    background: linear-gradient(135deg,#ff758f,#ffb199);
    color: white;
    padding: 25px;
}

.skincare-card{
    border: none;
    border-radius: 20px;
    overflow: hidden;
    height: 100%;
    background: #fff;
    box-shadow: 0 8px 20px rgba(255, 105, 135, 0.15);
}

.product-img{
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.card-body{
    display: flex;
    flex-direction: column;
}

.text-card{
    min-height: 70px;
}

</style>

</head>
<body>

<div class="sidebar">

<h3>GlowTrack</h3>

<a href="dashboard.php">
<i class="bi bi-house-fill"></i>
Dashboard
</a>

<!-- 🔥 TAMBAHAN MENU BARU -->
<a href="testimoni.php">
<i class="bi bi-chat-heart-fill"></i>
Testimoni
</a>

<a href="favorit.php">
<i class="bi bi-heart-fill"></i>
Favorit
</a>

<a href="../auth/logout.php">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</div>

<div class="content">

<h2 class="fw-bold mb-4">
Halo, <?= htmlspecialchars($_SESSION['nama']); ?> ✨
</h2>

<div class="card-dashboard shadow mb-5">

<h5>Total Skincare</h5>

<h1><?= $total; ?></h1>

</div>

<div class="row g-4">

<?php while($row = mysqli_fetch_assoc($dataSkincare)) : ?>

<div class="col-md-4">

<div class="card skincare-card h-100">

<img
src="../assets/img/<?= htmlspecialchars($row['gambar']); ?>"
class="product-img"
/>

<div class="card-body">

<h5 class="fw-bold">
<?= htmlspecialchars($row['nama_produk']); ?>
</h5>

<p class="text-muted">
<?= htmlspecialchars($row['brand']); ?>
</p>

<span class="badge bg-success mb-2">
<?= htmlspecialchars($row['rating']); ?>/10
</span>

<p class="mt-3 text-card">
<?= htmlspecialchars($row['manfaat']); ?>
</p>

<?php if(!empty($row['link_beli'])) : ?>
<a
href="<?= htmlspecialchars($row['link_beli']); ?>"
target="_blank"
class="btn btn-danger btn-sm mb-2"
>
<i class="bi bi-cart-fill"></i> Beli di Shopee
</a>
<?php endif; ?>

<a
href="detail.php?id=<?= $row['id']; ?>"
class="btn btn-outline-primary btn-sm mt-auto"
>
Detail
</a>

</div>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>