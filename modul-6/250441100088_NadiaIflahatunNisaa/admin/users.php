<?php
session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login_admin.php");
    exit;
}

$users = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE role = 'user' ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: #f5f3ff;
}

.table-card{
    border-radius: 25px;
    border: none;
}

</style>

</head>
<body>

<div class="container py-5">

<div class="card table-card shadow p-4">

<h2 class="fw-bold mb-4">
Data User 👩‍💻
</h2>

<div class="table-responsive">

<table class="table table-hover">

<thead class="table-light">

<tr>
<th>No</th>
<th>Nama</th>
<th>No HP</th>
<th>Role</th>
<th>Tanggal</th>
<th>aksi</th>
</tr>

</thead>

<tbody>

<?php
$no = 1;

while($row = mysqli_fetch_assoc($users)) :
?>

<tr>

<td><?= $no++; ?></td>

<td>
<?= htmlspecialchars($row['nama']); ?>
</td>

<td>
<?= htmlspecialchars($row['no_hp']); ?>
</td>

<td>

<span class="badge bg-primary">
<?= htmlspecialchars($row['role']); ?>
</span>

</td>

<td>
<?= htmlspecialchars($row['created_at']); ?>
</td>

<td>

<?php if($row['role'] != 'admin') : ?>

<a
href="hapus_user.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus user ini?')"
>
Hapus
</a>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<a href="dashboard.php" class="btn btn-secondary mt-3">
Kembali
</a>

</div>

</div>

</body>
</html>