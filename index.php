<?php
// FITUR COOKIE: Menyimpan waktu kunjungan terakhir
$pesan_kunjungan = "";
if (isset($_COOKIE['last_visit'])) {
    $pesan_kunjungan = "Selamat datang kembali! Terakhir Anda berkunjung pada: " . $_COOKIE['last_visit'];
} else {
    $pesan_kunjungan = "Selamat datang! Ini adalah kunjungan pertama Anda.";
}

// Set cookie baru untuk kunjungan SAAT INI (berlaku 30 hari)
setcookie('last_visit', date("d-m-Y H:i:s"), time() + (86400 * 30), "/");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang Yumna's Zoo!</title>
    <link rel="stylesheet" href="style.css?v=2">
    <link rel="icon" href="images/favicon.png" type="image/png"> 
</head>
<body>
    
    <div class="container" style="text-align: center;">
        <h2>🐘🦁🐻 Selamat Datang di Yumna's Zoo</h2>
        
        <div class="alert alert-info" style="background-color: #e3f2fd; color: #0d47a1; padding: 10px; margin-bottom: 20px; border-radius: 8px;">
            <?= htmlspecialchars($pesan_kunjungan); ?>
        </div>

        <p>Sistem ini mengelola kebun binatang dengan prinsip OOP yang terhubung ke database.</p>
        <p>Silakan registrasi untuk melihat hewan-hewan di setiap zona.</p>
        
        <a href="register.php" class="btn btn-primary" style="margin-top: 20px;">Mulai Registrasi</a>
        
        <div class="nav" style="margin-top: 30px;">
            <a href="daftar_pengunjung.php">Lihat Daftar Pengunjung</a>
        </div>
    </div>
</body>
</html>