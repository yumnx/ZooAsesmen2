<?php
session_start();
require_once 'config/Database.php';
require_once 'classes/SistemZoo.php';

$database = new Database();
$db = $database->getConnection();
$sistem = new SistemZoo($db);

$pengunjung_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pengunjung = $sistem->getPengunjungById($pengunjung_id);

if (!$pengunjung) {
    $_SESSION['message'] = ['type' => 'error', 'text' => 'Pengunjung tidak ditemukan!'];
    header("Location: daftar_pengunjung.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_baru = $_POST['nama'];
    $zona_baru = $_POST['zona'];

    if ($sistem->updatePengunjung($pengunjung_id, $nama_baru, $zona_baru)) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Data pengunjung berhasil diperbarui!'];
        if (isset($_SESSION['nama_pengunjung']) && $_SESSION['nama_pengunjung'] == $pengunjung['nama_pengunjung']) {
            $_SESSION['nama_pengunjung'] = $nama_baru;
            $_SESSION['zona_pilihan'] = $zona_baru;
        }
        header("Location: daftar_pengunjung.php");
        exit;
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Gagal memperbarui data pengunjung.'];
        header("Location: edit_pengunjung.php?id=" . $pengunjung_id); 
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengunjung - Zoo Dunia</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2>✏️ Edit Data Pengunjung</h2>
        
        <?php 
        if (isset($_SESSION['message'])): 
        ?>
            <div class="alert alert-<?= $_SESSION['message']['type']; ?>">
                <?= $_SESSION['message']['text']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <form action="edit_pengunjung.php?id=<?= htmlspecialchars($pengunjung_id); ?>" method="POST">
            <div class="form-group">
                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($pengunjung['nama_pengunjung']); ?>" required>
            </div>
            <div class="form-group">
                <label for="zona">Pilih Zona Kunjungan Pertama:</label>
                <select id="zona" name="zona" required>
                    <option value="Karnivora" <?= ($pengunjung['zona_pilihan'] == 'Karnivora') ? 'selected' : ''; ?>>🦁 Zona Karnivora</option>
                    <option value="Herbivora" <?= ($pengunjung['zona_pilihan'] == 'Herbivora') ? 'selected' : ''; ?>>🐘 Zona Herbivora</option>
                    <option value="Omnivora" <?= ($pengunjung['zona_pilihan'] == 'Omnivora') ? 'selected' : ''; ?>>🐻 Zona Omnivora</option>
                </select>
            </div>
            <div class="form-group" style="text-align:center;">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="daftar_pengunjung.php" class="btn">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>