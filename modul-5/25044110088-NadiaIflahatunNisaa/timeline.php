<?php
function tandai($tahun){
    if($tahun == "2026"){
        return "<span class='highlight'>$tahun</span>";
    }
    return "<span class='normal'>$tahun</span>";
}

$timeline = [
    ["tahun"=>"2025", "ket"=>"Mulai masuk kuliah / belajar coding"],
    ["tahun"=>"2025", "ket"=>"Mulai belajar Python"],
    ["tahun"=>"2026", "ket"=>"Belajar HTML, CSS, JavaScript, dan PHP"],
    ["tahun"=>"2027", "ket"=>"Sering latihan coding"],
    ["tahun"=>"2028", "ket"=>"Membuat project sendiri yang sederhana"] 
];
?>

<!DOCTYPE html>
<html>
<head>
<title>Timeline</title>

<style>
body {
    font-family: Arial;
    margin: 0;
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    color: white;
}

.header {
    text-align: center;
    padding: 25px;
    font-size: 28px;
    font-weight: bold;
}

.timeline {
    position: relative;
    width: 80%;
    margin: auto;
    padding: 20px 0;
}

.timeline::after {
    content: '';
    position: absolute;
    width: 4px;
    background: rgba(255,255,255,0.5);
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -2px;
}

.item {
    padding: 20px;
    position: relative;
    width: 50%;
}

.left {
    left: 0;
}

.right {
    left: 50%;
}

.content {
    background: white;
    color: #333;
    padding: 15px;
    border-radius: 10px;
    position: relative;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.circle {
    position: absolute;
    width: 18px;
    height: 18px;
    background: #ffcc00;
    border-radius: 50%;
    top: 25px;
    z-index: 1;
}

.left .circle {
    right: -9px;
}
.right .circle {
    left: -9px;
}

.highlight {
    background: #4CAF50;
    color: white;
    padding: 4px 10px;
    border-radius: 6px;
}
.normal {
    color: #555;
}

.footer {
    text-align: center;
    margin: 30px;
}
.footer a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
}
.footer a:hover {
    text-decoration: underline;
}
</style>

</head>

<body>

<div class="header">
    Timeline Perjalanan Belajar Coding 🚀
</div>

<div class="timeline">

<?php foreach($timeline as $index => $t): ?>
    <div class="item <?= $index % 2 == 0 ? 'left' : 'right' ?>">
        
        <div class="circle"></div>

        <div class="content">
            <b><?= tandai($t['tahun']) ?></b>
            <p><?= $t['ket'] ?></p>
        </div>

    </div>
<?php endforeach; ?>

</div>

<div class="footer">
    <a href="index.php">← Kembali ke Profil</a> |
    <a href="blog.php">Ke Blog →</a>
</div>

</body>
</html>