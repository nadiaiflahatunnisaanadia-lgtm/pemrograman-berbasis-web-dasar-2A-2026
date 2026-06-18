<?php
function tampilkanData($data) {
    echo "<table class='hasil-table'>";
    foreach ($data as $key => $value) {
        echo "<tr>
                <td><b>$key</b></td>
                <td>$value</td>
              </tr>";
    }
    echo "</table>";
}

$pesan = "";
$data = null;

if (isset($_POST['submit'])) {

    $framework   = $_POST['framework'] ?? '';
    $pengalaman  = $_POST['pengalaman'] ?? '';
    $tools       = $_POST['tools'] ?? [];
    $minat       = $_POST['minat'] ?? '';
    $skill       = $_POST['skill'] ?? '';

    if ($framework == "" || $pengalaman == "" || empty($tools) || $minat == "" || $skill == "") {
        $pesan = "Semua input wajib diisi!";
    } else {

        $frameworkArray = explode(",", $framework);

        if (count($frameworkArray) > 2) {
            $pesan = "Skill Anda cukup luas di bidang development!";
        }

        $data = [
            "Framework"   => implode(", ", $frameworkArray),
            "Tools"       => implode(", ", $tools),
            "Minat"       => $minat,
            "Skill Level" => $skill
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Profil Developer</title>

<style>
body {
    font-family: Arial;
    margin: 0;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #333;
}

.header {
    background: rgba(0,0,0,0.3);
    color: white;
    padding: 20px;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
}

.main {
    display: flex;
    gap: 20px;
    padding: 20px;
}

.card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    flex: 1;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.profile-table {
    width: 100%;
    border-collapse: collapse;
}
.profile-table td {
    border: 1px solid #ddd;
    padding: 8px;
}

input[type="text"], textarea, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(45deg, #ff7e5f, #feb47b);
    border: none;
    color: white;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    opacity: 0.9;
}

.hasil-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
.hasil-table td {
    border: 1px solid #ddd;
    padding: 8px;
}

.pesan {
    margin-top: 10px;
    padding: 10px;
    background: #ff4d4d;
    color: white;
    border-radius: 5px;
}

.section {
    margin-bottom: 15px;
}
</style>

</head>

<body>

<div class="header">
    Profil Developer Interaktif 🚀
</div>

<div class="main">

<div class="card">
    <h3>Data Diri</h3>
    <table class="profile-table">
        <tr><td>Nama</td><td>Nadia Iflahatun Nisaa</td></tr>
        <tr><td>ID Developer</td><td>DEV 0409</td></tr>
        <tr><td>Kota/Tahun Lahir</td><td>Sumenep, 2006</td></tr>
        <tr><td>Email</td><td>nadia@email.com</td></tr>
        <tr><td>No WA</td><td>082231634388</td></tr>
    </table>
</div>

<div class="card">
    <h3>Form Input</h3>

    <form method="POST">

    <div class="section">
        Framework:
        <input type="text" name="framework">
    </div>

    <div class="section">
        Pengalaman:
        <textarea name="pengalaman"></textarea>
    </div>

    <div class="section">
        Tools:<br>
        <input type="checkbox" name="tools[]" value="VS Code"> VS Code
        <input type="checkbox" name="tools[]" value="GitHub"> GitHub
        <input type="checkbox" name="tools[]" value="Figma"> Figma
        <input type="checkbox" name="tools[]" value="Postman"> Postman
    </div>

    <div class="section">
        Minat:<br>
        <input type="radio" name="minat" value="Frontend"> Frontend
        <input type="radio" name="minat" value="Backend"> Backend
        <input type="radio" name="minat" value="Fullstack"> Fullstack
    </div>

    <div class="section">
        Skill:
        <select name="skill">
            <option value="">--Pilih--</option>
            <option>Dasar</option>
            <option>Cukup</option>
            <option>Profesional</option>
        </select>
    </div>

    <button type="submit" name="submit">Kirim</button>

    </form>

    <?php
    if (!empty($data)) {
        echo "<h3>Hasil</h3>";
        tampilkanData($data);
        echo "<p><b>Pengalaman:</b> $pengalaman</p>";
    }

    if ($pesan != "") {
        echo "<div class='pesan'>$pesan</div>";
    }
    ?>
</div>

</div>

</body>
</html>