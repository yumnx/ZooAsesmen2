<?php
session_start();

if (!isset($_SESSION['nama_pengunjung']) || !isset($_SESSION['zona_pilihan'])) {
    header("Location: register.php");
    exit;
}

require_once 'config/Database.php';
require_once 'classes/SistemZoo.php';

if (isset($_GET['add_fav']) && isset($_GET['fav_name'])) {
    $id_hewan = $_GET['add_fav'];
    $nama_hewan = $_GET['fav_name'];
    if (!isset($_SESSION['favorit_hewan'])) $_SESSION['favorit_hewan'] = [];
    $_SESSION['favorit_hewan'][$id_hewan] = $nama_hewan;
    header("Location: zona.php");
    exit;
}
if (isset($_GET['remove_fav'])) {
    $id_to_remove = $_GET['remove_fav'];
    if (isset($_SESSION['favorit_hewan'][$id_to_remove])) unset($_SESSION['favorit_hewan'][$id_to_remove]);
    header("Location: zona.php");
    exit;
}
if (isset($_GET['reset_fav'])) {
    unset($_SESSION['favorit_hewan']);
    header("Location: zona.php");
    exit;
}
// ---------------------------------------------------

$nama_pengunjung = $_SESSION['nama_pengunjung'];
$zona_pilihan = $_SESSION['zona_pilihan'];
$foto_profil = isset($_SESSION['foto_profil']) ? $_SESSION['foto_profil'] : null;

$database = new Database();
$db = $database->getConnection();
$sistem = new SistemZoo($db);

$hewan_zona_pilihan = $sistem->getHewanByZona($zona_pilihan);

$semua_zona = ['Karnivora', 'Herbivora', 'Omnivora'];
$zona_lain = array_values(array_diff($semua_zona, [$zona_pilihan]));
$hewan_zona_lain_1 = $sistem->getHewanByZona($zona_lain[0]);
$hewan_zona_lain_2 = $sistem->getHewanByZona($zona_lain[1]);

function displayHewanTable($hewanArray) {
    foreach ($hewanArray as $h) {
        $is_fav = isset($_SESSION['favorit_hewan'][$h->getId()]);
        echo "<tr>";
        echo "<td>" . $h->getId() . "</td>";
        echo "<td><span class='emoji'>" . htmlspecialchars($h->getEmoticon()) . "</span>" . htmlspecialchars($h->getNama()) . "</td>";
        echo "<td>" . htmlspecialchars($h->getJenisMakanan()) . "</td>";
        echo "<td>";
        if ($h instanceof Karnivora) echo "Mangsa: " . htmlspecialchars($h->getMangsaFavorit());
        elseif ($h instanceof Herbivora) echo "Tumbuhan: " . htmlspecialchars($h->getTumbuhanFavorit());
        elseif ($h instanceof Omnivora) echo "Menu: " . htmlspecialchars($h->getMenuFavorit());
        echo "</td>";
        echo "<td style='text-align:center;'>";
        if ($is_fav) echo "<span style='color:red; font-size:1.2em;'>❤️</span>";
        else echo "<a href='zona.php?add_fav=" . $h->getId() . "&fav_name=" . urlencode($h->getNama()) . "' class='btn' style='background-color:#FF9800; padding:5px 10px; font-size:0.8em;'>⭐ Like</a>";
        echo "</td>";
        echo "</tr>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tur Zona Kebun Binatang</title>
    <link rel="stylesheet" href="style.css?v=2">
    <link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 20px;">
            
            <div style="display: flex; align-items: center; gap: 15px;">
                <?php if($foto_profil): ?>
                    <img src="uploads/images/<?= htmlspecialchars($foto_profil); ?>" 
                         alt="Foto Profil" 
                         style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #4CAF50; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <?php else: ?>
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #ddd; display: flex; align-items: center; justify-content: center; font-size: 2em;">👤</div>
                <?php endif; ?>
                
                <div>
                    <h2 style="margin: 0; text-align: left;">Halo, <?= htmlspecialchars($nama_pengunjung); ?>! 👋</h2>
                    <p style="margin: 5px 0 0 0;">Anda sedang menjelajahi <strong>Zona <?= htmlspecialchars($zona_pilihan); ?></strong></p>
                </div>
            </div>

            <div style="background: #FFF3E0; padding: 10px 15px; border-radius: 8px; border: 1px solid #FFB74D; width: 250px;">
                <h4 style="margin:0 0 5px 0; font-size:0.9em;">⭐ Hewan Favorit</h4>
                <?php if (empty($_SESSION['favorit_hewan'])): ?>
                    <small style="color:#777;">Belum ada.</small>
                <?php else: ?>
                    <ul style="margin:0; padding-left:15px; font-size: 0.9em;">
                        <?php foreach ($_SESSION['favorit_hewan'] as $fid => $fnama): ?>
                            <li>
                                <?= htmlspecialchars($fnama); ?> 
                                <a href="zona.php?remove_fav=<?= $fid; ?>" style="color:red; text-decoration:none;">[x]</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div style="text-align:right;">
                        <a href="zona.php?reset_fav=true" style="font-size:0.7em; color:#d32f2f;">Reset</a>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
        
        <div class="nav">
            <a href="daftar_pengunjung.php">Lihat Daftar Pengunjung</a> |
            <a href="logout.php">Keluar (Logout)</a>
        </div>

        <div class="zona-section">
            <h3>Hewan di Zona Anda (<?= htmlspecialchars($zona_pilihan); ?>)</h3>
            <table>
                <thead>
                    <tr><th>ID</th><th>Nama Hewan</th><th>Jenis Makanan</th><th>Keterangan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php displayHewanTable($hewan_zona_pilihan); ?>
                </tbody>
            </table>
        </div>

        <hr>
        <h3>Kunjungi Juga Zona Lainnya!</h3>
        <div class="zona-section">
            <h4>Zona <?= htmlspecialchars($zona_lain[0]); ?></h4>
            <table>
                 <thead><tr><th>ID</th><th>Nama Hewan</th><th>Jenis Makanan</th><th>Keterangan</th><th>Aksi</th></tr></thead>
                <tbody><?php displayHewanTable($hewan_zona_lain_1); ?></tbody>
            </table>
        </div>
        <div class="zona-section">
             <h4>Zona <?= htmlspecialchars($zona_lain[1]); ?></h4>
            <table>
                 <thead><tr><th>ID</th><th>Nama Hewan</th><th>Jenis Makanan</th><th>Keterangan</th><th>Aksi</th></tr></thead>
                <tbody><?php displayHewanTable($hewan_zona_lain_2); ?></tbody>
            </table>
        </div>

    </div>
</body>
</html>