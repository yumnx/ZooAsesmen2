<?php
session_start(); 
require_once 'config/Database.php';
require_once 'classes/SistemZoo.php';

$database = new Database();
$db = $database->getConnection();
$sistem = new SistemZoo($db);

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_pengunjung = (int)$_GET['id'];

    
    if ($sistem->deletePengunjung($id_pengunjung)) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Pengunjung berhasil dihapus!'];
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Gagal menghapus pengunjung.'];
    }
    header("Location: daftar_pengunjung.php"); 
    exit;
}

$daftar_pengunjung = $sistem->getDaftarPengunjung();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengunjung - Zoo Dunia</title>
    <link rel="stylesheet" href="style.css?v=2">
    <link rel="icon" href="images/favicon.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2>👥 Daftar Pengunjung Terdaftar</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message']['type']; ?>">
                <?= $_SESSION['message']['text']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="nav">
            <a href="index.php">Beranda</a> | 
            <a href="register.php">Registrasi Baru</a>
            <?php if (isset($_SESSION['nama_pengunjung'])): ?>
                | <a href="zona.php">Kembali ke Zona Anda</a>
                | <a href="logout.php">Keluar (Logout)</a>
            <?php endif; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto Profil</th> <th>Nama Pengunjung</th>
                    <th>Zona Pilihan</th>
                    <th>Dokumen</th> <th>Waktu Registrasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftar_pengunjung)): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">Belum ada pengunjung yang terdaftar.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftar_pengunjung as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['id']); ?></td>
                            
                            <td style="text-align: center;">
                                <?php if (!empty($p['foto_profil'])): ?>
                                    <img src="uploads/images/<?= htmlspecialchars($p['foto_profil']); ?>" 
                                         alt="Foto" 
                                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;">
                                <?php else: ?>
                                    <span style="font-size: 2em;">👤</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($p['nama_pengunjung']); ?></td>
                            <td><?= htmlspecialchars($p['zona_pilihan']); ?></td>
                            
                            <td style="text-align: center;">
                                <?php if (!empty($p['dokumen_file'])): ?>
                                    <a href="uploads/files/<?= htmlspecialchars($p['dokumen_file']); ?>" 
                                       target="_blank" 
                                       class="btn" 
                                       style="background-color: #607D8B; padding: 5px 10px; font-size: 0.8em;">
                                       📄 Unduh
                                    </a>
                                <?php else: ?>
                                    <span style="color: #999;">-</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($p['tgl_registrasi']); ?></td>
                            
                            <td>
                                <a href="edit_pengunjung.php?id=<?= htmlspecialchars($p['id']); ?>" class="btn btn-edit">Edit</a>
                                
                                <a href="daftar_pengunjung.php?action=delete&id=<?= htmlspecialchars($p['id']); ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus pengunjung ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>