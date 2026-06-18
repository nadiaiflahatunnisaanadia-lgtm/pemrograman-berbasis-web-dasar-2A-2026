<?php
session_start();

include '../config/koneksi.php';

$message = "";

if(isset($_POST['register'])){

    $nama = htmlspecialchars($_POST['nama']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if(
        empty($nama) ||
        empty($no_hp) ||
        empty($password) ||
        empty($confirm)
    ){

        $message = "Semua field wajib diisi";

    } elseif(!is_numeric($no_hp)) {

        $message = "Nomor HP harus angka";

    } elseif(strlen($no_hp) != 12){

        $message = "Nomor HP wajib 12 angka";

    } elseif(strlen($password) != 4){
        
        $message = "Password wajib 4 karakter";

    } elseif($password !== $confirm){

        $message = "Konfirmasi password tidak sama";

    } else {

        /*
        CEK NOMOR HP SUDAH TERDAFTAR
        */
        $check = mysqli_prepare(
            $conn,
            "SELECT id FROM users WHERE no_hp = ?"
        );

        mysqli_stmt_bind_param($check, "s", $no_hp);

        mysqli_stmt_execute($check);

        mysqli_stmt_store_result($check);

        if(mysqli_stmt_num_rows($check) > 0){

            $message = "Nomor HP sudah digunakan";

        } else {

            $hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $role = "user";

            $query = mysqli_prepare(
                $conn,
                "INSERT INTO users(nama, no_hp, password, role)
                VALUES(?,?,?,?)"
            );

            mysqli_stmt_bind_param(
                $query,
                "ssss",
                $nama,
                $no_hp,
                $hash,
                $role
            );

            if(mysqli_stmt_execute($query)){

                header("Location: /glowtrack/auth/login.php?success=1");
                exit;

            } else {

                $message = "Registrasi gagal";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register GlowTrack</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ffd6e8, #e0c3fc);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px 0;
    overflow-y: auto;
    position: relative;
}

.bg-circle1{
    position: absolute;
    width: 280px;
    height: 280px;
    background: rgba(255,255,255,0.18);
    border-radius: 50%;
    top: -90px;
    left: -90px;
}

.bg-circle2{
    position: absolute;
    width: 230px;
    height: 230px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    bottom: -60px;
    right: -60px;
}

.register-card{
    width: 460px;
    border: none;
    border-radius: 30px;
    padding: 40px;
    background: rgba(255,255,255,0.22);
    backdrop-filter: blur(16px);
    box-shadow: 0 10px 35px rgba(0,0,0,0.1);
    position: relative;
    z-index: 2;
}

.logo{
    width: 85px;
    height: 85px;
    border-radius: 50%;
    background: linear-gradient(135deg,#ff5ea8,#c77dff);
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
    color: white;
    font-size: 35px;
    margin-bottom: 20px;
}

.title{
    text-align: center;
    font-weight: 700;
    font-size: 32px;
    color: #d63384;
}

.subtitle{
    text-align: center;
    color: #666;
    margin-bottom: 30px;
}

.form-control{
    border-radius: 14px;
    padding: 12px;
    border: none;
}

.form-control:focus{
    box-shadow: 0 0 0 3px rgba(214,51,132,0.15);
}

.btn-register{
    background: linear-gradient(135deg,#ff4f9d,#c77dff);
    border: none;
    border-radius: 14px;
    padding: 12px;
    font-weight: 600;
}

.btn-register:hover{
    transform: translateY(-2px);
}

.password-box{
    position: relative;
}

.toggle-password{
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
}

.login-link{
    text-align: center;
    margin-top: 18px;
}

.login-link a{
    text-decoration: none;
    font-weight: 600;
    color: #d63384;
}

.home-link{
    text-align: center;
    margin-top: 15px;
}

.home-link a{
    text-decoration: none;
    font-weight: 600;
    color: #c21870;
}

</style>

</head>
<body>

<div class="bg-circle1"></div>
<div class="bg-circle2"></div>

<div class="card register-card">

    <div class="logo">
        <i class="bi bi-stars"></i>
    </div>

    <h1 class="title">
        GlowTrack
    </h1>

    <p class="subtitle">
        Buat akun dan mulai tracking skincare favoritmu ✨
    </p>

    <?php if($message) : ?>

        <div class="alert alert-danger">
            <?= $message; ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">

            <label class="form-label fw-semibold">
                Nama Lengkap
            </label>

            <input
                type="text"
                name="nama"
                class="form-control"
                placeholder="Masukkan nama lengkap"
                required
            >

        </div>

        <div class="mb-3">

            <label class="form-label fw-semibold">
                Nomor HP
            </label>

            <input
                type="text"
                name="no_hp"
                class="form-control"
                placeholder="08xxxxxxxxxx"
                required
            >

        </div>

        <div class="mb-3">

            <label class="form-label fw-semibold">
                Password
            </label>

            <div class="password-box">

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="4 karakter"
                    required
                >

                <i class="bi bi-eye-fill toggle-password"
                   onclick="togglePassword('password')"></i>

            </div>

        </div>

        <div class="mb-4">

            <label class="form-label fw-semibold">
                Konfirmasi Password
            </label>

            <div class="password-box">

                <input
                    type="password"
                    name="confirm"
                    id="confirm"
                    class="form-control"
                    placeholder="Ulangi password"
                    required
                >

                <i class="bi bi-eye-fill toggle-password"
                   onclick="togglePassword('confirm')"></i>

            </div>

        </div>

        <button
            type="submit"
            name="register"
            class="btn btn-register text-white w-100"
        >
            Register Sekarang
        </button>

        <div class="login-link">

            Sudah punya akun?

            <a href="/glowtrack/auth/login.php">
                Login
            </a>

        </div>

        <div style="text-align:center; margin-top:15px;">

            <a 
                href="/glowtrack/auth/login.php"
                style="
                    text-decoration:none;
                    font-weight:600;
                    color:#c21870;
                "
            >
                ← Kembali ke Login
            </a>

        </div>

    </form>

</div>

<script>

function togglePassword(id){

    const input = document.getElementById(id);

    if(input.type === "password"){

        input.type = "text";

    } else {

        input.type = "password";
    }
}

</script>

</body>
</html>