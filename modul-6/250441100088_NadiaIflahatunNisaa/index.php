<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>GlowTrack</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    background: linear-gradient(135deg,#ffe4ec,#fff5f8,#f3d9fa);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hero{
    text-align: center;
    max-width: 700px;
    padding: 40px;
    position: relative;
    z-index: 2;
}

.hero h1{
    font-size: 70px;
    font-weight: 700;
    color: #ff4d8d;
    margin-bottom: 20px;
}

.hero p{
    font-size: 18px;
    color: #555;
    line-height: 1.8;
    margin-bottom: 35px;
}

.btn-glow{
    background: linear-gradient(135deg,#ff4d8d,#c77dff);
    color: white;
    border: none;
    padding: 14px 40px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
    box-shadow: 0 8px 25px rgba(255,77,141,0.3);
}

.btn-glow:hover{
    transform: translateY(-3px);
    color: white;
}

.circle{
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.35);
    backdrop-filter: blur(10px);
}

.circle1{
    width: 250px;
    height: 250px;
    top: -80px;
    left: -80px;
}

.circle2{
    width: 180px;
    height: 180px;
    bottom: -60px;
    right: -40px;
}

.circle3{
    width: 120px;
    height: 120px;
    top: 20%;
    right: 15%;
}

</style>

</head>
<body>

<div class="circle circle1"></div>
<div class="circle circle2"></div>
<div class="circle circle3"></div>

<div class="hero">

    <h1>✨ GlowTrack ✨</h1>

    <p>
        Platform skincare modern untuk membantu kamu
        menyimpan produk favorit, membagikan testimoni,
        dan memantau pengalaman skincare dengan mudah.
    </p>

    <a href="/glowtrack/auth/login.php" class="btn-glow">
    Login Sekarang
</a>

</div>

</body>
</html>