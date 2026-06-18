<?php
session_start();
include '../config/koneksi.php';

$error = "";

if (isset($_POST['login'])) {

    $no_hp = htmlspecialchars($_POST['no_hp']);
    $password = $_POST['password'];

    if (empty($no_hp) || empty($password)) {

        $error = "Semua field wajib diisi";

    } else {

        /*
        CEK USER / ADMIN BERDASARKAN NO HP
        */
        $query = mysqli_prepare(
            $conn,
            "SELECT * FROM users WHERE no_hp = ?"
        );

        mysqli_stmt_bind_param($query, "s", $no_hp);

        mysqli_stmt_execute($query);

        $result = mysqli_stmt_get_result($query);

        $data = mysqli_fetch_assoc($result);

        if ($data) {

            /*
            CEK PASSWORD
            */
            if (password_verify($password, $data['password'])) {

                $_SESSION['login'] = true;
                $_SESSION['id'] = $data['id'];
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['role'] = $data['role'];

                /*
                AUTO MASUK BERDASARKAN ROLE
                */
                if($data['role'] == 'admin'){

                    header("Location: ../admin/dashboard.php");
                    exit;

                } else {

                    header("Location: ../user/dashboard.php");
                    exit;
                }

            } else {

                $error = "Password salah";
            }

        } else {

            $error = "Akun tidak ditemukan";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login GlowTrack</title>

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
    align-items: center;
    overflow: hidden;
    position: relative;
}

.bg-circle1{
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    top: -80px;
    left: -80px;
}

.bg-circle2{
    position: absolute;
    width: 250px;
    height: 250px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    bottom: -70px;
    right: -70px;
}

.login-card{
    width: 430px;
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

.btn-login{
    border-radius: 14px;
    background: linear-gradient(135deg,#ff4f9d,#c77dff);
    border: none;
    padding: 12px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-login:hover{
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
    color: #777;
}

.register-link{
    text-align: center;
    margin-top: 18px;
}

.register-link a{
    text-decoration: none;
    font-weight: 600;
    color: #d63384;
}

</style>

</head>
<body>

<div class="bg-circle1"></div>
<div class="bg-circle2"></div>

<div class="card login-card">

    <div class="logo">
        <i class="bi bi-stars"></i>
    </div>

    <h1 class="title">
        GlowTrack
    </h1>

    <p class="subtitle">
        Smart Skincare Tracker ✨
    </p>

    <?php if(isset($_GET['success'])) : ?>

        <div class="alert alert-success">
            Registrasi berhasil, silakan login
        </div>

    <?php endif; ?>

    <?php if($error) : ?>

        <div class="alert alert-danger">
            <?= $error; ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">

            <label class="form-label fw-semibold">
                Nomor HP
            </label>

            <input 
                type="text" 
                name="no_hp" 
                class="form-control"
                placeholder="Masukkan nomor HP"
                required
            >

        </div>

        <div class="mb-4">

            <label class="form-label fw-semibold">
                Password
            </label>

            <div class="password-box">

                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required
                >

                <i class="bi bi-eye-fill toggle-password"
                   onclick="togglePassword()"></i>

            </div>

        </div>

        <button 
            type="submit" 
            name="login" 
            class="btn btn-login text-white w-100"
        >
            Login Sekarang
        </button>

        <div class="text-center mt-3">

            <a href="/glowtrack/index.php" style="
                text-decoration:none;
                color:#666;
                font-weight:500;
            ">
                ← Kembali ke Home
            </a>

        </div>

        <div class="register-link">

            Belum punya akun?

            <a href="/glowtrack/auth/register.php">
                Daftar
            </a>

        </div>

    </form>

</div>

<script>

function togglePassword(){

    const password = document.getElementById('password');

    if(password.type === "password"){

        password.type = "text";

    } else {

        password.type = "password";
    }
}

</script>

</body>
</html>