<?php
$artikel = [
    "html" => [
        "judul" => "Belajar HTML Pertama Kali",
        "tanggal" => "20 Februari 2026",
        "isi" => "Aku mulai belajar HTML di tahun 2026. Awalnya cukup bingung, tapi lama-lama mulai paham struktur dasar website.",
        "gambar" => "img/one.png",
        "link" => "https://www.w3schools.com"
    ],
    "error" => [
        "judul" => "Error Pertama",
        "tanggal" => "18 februari 2026",
        "isi" => "Saat belajar, aku sering error. Dari situ aku belajar memahami kesalahan dan memperbaikinya.",
        "gambar" => "img/error.jpg",
        "link" => "https://stackoverflow.com"
    ]
];

$quotes = [
    "Jangan takut error, itu bagian dari belajar.",
    "Coding itu proses, bukan instan.",
    "Semakin sering latihan, semakin paham.",
    "Error adalah guru terbaik."
];

$randomQuote = $quotes[array_rand($quotes)];
$pilih = $_GET['artikel'] ?? 'html';
?>

<!DOCTYPE html>
<html>
<head>
<title>Blog Developer</title>

<style>
body {
    font-family: Arial;
    margin: 0;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
}

.header {
    text-align: center;
    padding: 20px;
    font-size: 26px;
    font-weight: bold;
    background: rgba(0,0,0,0.3);
    color: white;
}

.container {
    display: flex;
    padding: 20px;
    gap: 20px;
}

.sidebar {
    width: 30%;
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.sidebar a {
    display: block;
    padding: 10px;
    margin-bottom: 10px;
    text-decoration: none;
    color: #333;
    border-radius: 5px;
    background: #f1f1f1;
}

.sidebar a:hover {
    background: #4CAF50;
    color: white;
}

.content {
    flex: 1;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.content img {
    width: 100%;
    border-radius: 10px;
    margin: 10px 0;
}

.link {
    display: inline-block;
    margin-top: 10px;
    color: white;
    background: #4CAF50;
    padding: 8px 12px;
    border-radius: 5px;
    text-decoration: none;
}

.quote {
    margin: 20px;
    padding: 15px;
    background: #fff;
    border-left: 5px solid #4CAF50;
    border-radius: 5px;
    font-style: italic;
}

.footer {
    text-align: center;
    margin: 20px;
}
.footer a {
    text-decoration: none;
    color: white;
}
</style>

</head>

<body>

<div class="header">
    Blog Reflektif Developer ✨
</div>

<div class="container">

<div class="sidebar">
    <h3>Pilih Artikel</h3>
    <?php foreach($artikel as $key => $a): ?>
        <a href="blog.php?artikel=<?= $key ?>">
            <?= $a['judul'] ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="content">

    <h2><?= $artikel[$pilih]['judul'] ?></h2>
    <p><b><?= $artikel[$pilih]['tanggal'] ?></b></p>

    <img src="<?= $artikel[$pilih]['gambar'] ?>">

    <p><?= $artikel[$pilih]['isi'] ?></p>

    <a href="<?= $artikel[$pilih]['link'] ?>" target="_blank" class="link">
        Baca Referensi
    </a>

</div>

</div>

<div class="quote">
    <?= $randomQuote ?>
</div>

<div class="footer">
    <a href="timeline.php">← Kembali ke Timeline</a>
</div>

</body>
</html>