<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login_admin.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login_admin.php");
    exit;
}

$totalUser = mysqli_query($conn, "SELECT * FROM users WHERE role = 'user'");
$countUser = mysqli_num_rows($totalUser);

$totalSkincare = mysqli_query($conn, "SELECT * FROM skincare");
$countSkincare = mysqli_num_rows($totalSkincare);

/* 🔥 FIX TOTAL TESTIMONI */
$totalTestimoni = mysqli_query(
    $conn,
    "SELECT 
        testimoni.id
    FROM testimoni
    INNER JOIN users
        ON testimoni.user_id = users.id
    INNER JOIN skincare
        ON testimoni.skincare_id = skincare.id"
);

$countTestimoni = mysqli_num_rows($totalTestimoni);

/* 🔥 SKINCARE PALING FAVORIT */
$favoritTerbanyak = mysqli_query(
    $conn,
    "SELECT 
        skincare.nama_produk,
        COUNT(favorit.id) AS total_favorit
    FROM favorit
    INNER JOIN skincare
        ON favorit.skincare_id = skincare.id
    GROUP BY favorit.skincare_id
    ORDER BY total_favorit DESC
    LIMIT 1"
);

$dataFavorit = mysqli_fetch_assoc($favoritTerbanyak);

$dataSkincare = mysqli_query($conn, "SELECT * FROM skincare ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ffe4ec, #fff5f8);
}

/* SIDEBAR */
.sidebar{
    width: 250px;
    height: 100vh;
    background: linear-gradient(180deg,#ff8fab,#c77dff);
    position: fixed;
    padding: 30px 20px;
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

/* CONTENT */
.content{
    margin-left: 270px;
    padding: 30px;
}

/* CARD */
.card-dashboard{
    border: none;
    border-radius: 20px;
    color: white;
    padding: 25px;
    min-height: 170px;
}

.bg-user{
    background: linear-gradient(135deg,#ff758f,#ffb199);
}

.bg-skincare{
    background: linear-gradient(135deg,#7b2cbf,#c77dff);
}

.bg-testimoni{
    background: linear-gradient(135deg,#ff4d6d,#ff8fab);
}

.table-card{
    border-radius: 20px;
    border: none;
    background: #ffffffcc;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h3>GlowTrack ✨</h3>

    <a href="dashboard.php"><i class="bi bi-grid-fill"></i> Dashboard</a>
    <a href="tambah_skincare.php"><i class="bi bi-plus-circle"></i> Tambah Skincare</a>
    <a href="users.php"><i class="bi bi-people-fill"></i> Data User</a>

    <!-- 🔥 TESTIMONI ADMIN -->
    <a href="testimoni_user.php"><i class="bi bi-chat-heart-fill"></i> Testimoni User</a>

    <a href="../auth/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>

</div>

<!-- CONTENT -->
<div class="content">

    <h2 class="fw-bold mb-4">Dashboard Admin ✨</h2>

    <!-- CARD STAT -->
<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card-dashboard bg-user shadow">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Total User</h6>
                    <h1><?= $countUser; ?></h1>
                </div>

                <i class="bi bi-people-fill fs-1"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-dashboard bg-skincare shadow">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Total Skincare</h6>
                    <h1><?= $countSkincare; ?></h1>
                </div>

                <i class="bi bi-bag-heart-fill fs-1"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-dashboard bg-testimoni shadow">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Total Testimoni</h6>
                    <h1><?= $countTestimoni; ?></h1>
                </div>

                <i class="bi bi-chat-heart-fill fs-1"></i>
            </div>
        </div>
    </div>

    <!-- 🔥 ANALISA FAVORIT -->
    <div class="col-md-3">
        <div class="card-dashboard shadow h-100"
             style="background: linear-gradient(135deg,#ff5d8f,#9d4edd);">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>
                    <h6>Skincare Favorit</h6>

                    <h2 class="fw-bold">
                        <?= $dataFavorit['total_favorit'] ?? 0; ?>x
                    </h2>
                </div>

                <i class="bi bi-heart-fill fs-1"></i>

            </div>

            <p class="mb-0 small">
                <?= htmlspecialchars($dataFavorit['nama_produk'] ?? 'Belum ada data'); ?>
            </p>

        </div>
    </div>

</div>


    <!-- TABLE SKINCARE -->
    <div class="card table-card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h4 class="fw-bold">Data Skincare</h4>

            <a href="tambah_skincare.php" class="btn btn-primary">
                Tambah Data
            </a>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Brand</th>
                        <th>Jenis</th>
                        <th>Rating</th>
                        <th>Link Beli</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php $no = 1; while($row = mysqli_fetch_assoc($dataSkincare)) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                        <td><?= htmlspecialchars($row['brand']); ?></td>
                        <td><?= htmlspecialchars($row['jenis']); ?></td>

                        <td>
                            <span class="badge bg-success">
                                <?= htmlspecialchars($row['rating']); ?>/10
                            </span>
                        </td>

                        <td>
                            <?php if(!empty($row['link_beli'])): ?>
                                <a href="<?= htmlspecialchars($row['link_beli']); ?>" target="_blank">
                                    Shopee
                                </a>
                            <?php else: ?>
                                <span class="text-danger">Belum ada</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="edit_skincare.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                            <a href="hapus_skincare.php?id=<?= $row['id']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus data?')">
                               Hapus
                            </a>
                        </td>

                    </tr>
                <?php endwhile; ?>

                </tbody>
            </table>

        </div>

    </div>

</div>

</body>
</html>