<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengunjung - Zoo Dunia</title>
    <link rel="stylesheet" href="style.css?v=2">
    <link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2>📝 Registrasi Pengunjung</h2>
        <p style="text-align:center;">Daftar untuk menjelajahi Yumna's Zoo dan pilih zona pertama Anda!</p>
        
        <form action="proses_registrasi.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="foto_profil">Foto Profil (JPG/PNG):</label>
                <input type="file" id="foto_profil" name="foto_profil" accept="image/*" required>
                <small>Disimpan ke folder <code>uploads/images</code></small>
            </div>
            <div class="form-group">
                <label for="dokumen">Upload Tiket/Dokumen (PDF/DOC):</label>
                <input type="file" id="dokumen" name="dokumen" accept=".pdf,.doc,.docx" required>
                <small>Disimpan ke folder <code>uploads/files</code></small>
            </div>
            <div class="form-group">
                <label for="zona">Pilih Zona Kunjungan Pertama:</label>
                <select id="zona" name="zona" required>
                    <option value="">--Pilih Zona--</option>
                    <option value="Karnivora">🦁 Zona Karnivora</option>
                    <option value="Herbivora">🐘 Zona Herbivora</option>
                    <option value="Omnivora">🐻 Zona Omnivora</option>
                </select>
            </div>
            <div class="form-group" style="text-align:center;">
                <button type="submit" class="btn btn-primary">Daftar & Masuk Zona</button>
            </div>
        </form>
        
        <div class="nav">
            <a href="index.php">Kembali ke Beranda</a> | 
            <a href="daftar_pengunjung.php">Lihat Daftar Pengunjung</a>
        </div>
    </div>
</body>
</html>