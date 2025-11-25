<?php
session_start();
require_once 'config/Database.php';
require_once 'classes/SistemZoo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Ambil data teks
    $nama = $_POST['nama'];
    $zona = $_POST['zona'];

    // 2. Cek apakah nama dan zona terisi
    if (!empty($nama) && !empty($zona)) {
        
        // Inisialisasi Koneksi
        $database = new Database();
        $db = $database->getConnection();
        $sistem = new SistemZoo($db);

        // --- PROSES UPLOAD FILE ---

        // 3. Upload Foto Profil (Kategori 'image')
        // Pastikan input di form bernama 'foto_profil'
        if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
            $uploadFoto = $sistem->uploadMedia($_FILES['foto_profil'], 'image');
            
            if ($uploadFoto['status'] == false) {
                // Jika gagal upload foto, hentikan dan tampilkan pesan
                die("Gagal Upload Foto: " . $uploadFoto['msg']);
            }
            $namaFileFoto = $uploadFoto['path'];
        } else {
            die("Foto profil wajib diupload.");
        }

        // 4. Upload Dokumen Tiket (Kategori 'file')
        // Pastikan input di form bernama 'dokumen'
        if (isset($_FILES['dokumen']) && $_FILES['dokumen']['error'] === UPLOAD_ERR_OK) {
            $uploadDokumen = $sistem->uploadMedia($_FILES['dokumen'], 'file');
            
            if ($uploadDokumen['status'] == false) {
                // Jika gagal upload dokumen, hentikan
                die("Gagal Upload Dokumen: " . $uploadDokumen['msg']);
            }
            $namaFileDokumen = $uploadDokumen['path'];
        } else {
            die("Dokumen wajib diupload.");
        }

        // --- SIMPAN KE DATABASE ---

        // 5. Panggil fungsi registrasi dengan 4 parameter (Nama, Zona, Foto, Dokumen)
        if ($sistem->registrasiPengunjung($nama, $zona, $namaFileFoto, $namaFileDokumen)) {
            
            // Set Session agar user dianggap login
            $_SESSION['nama_pengunjung'] = $nama;
            $_SESSION['zona_pilihan'] = $zona;
            $_SESSION['foto_profil'] = $namaFileFoto; // Simpan nama file foto di session untuk ditampilkan
            
            // Redirect ke halaman zona
            header("Location: zona.php");
            exit;
        } else {
            echo "Registrasi gagal saat menyimpan ke database.";
        }

    } else {
        echo "Nama dan Zona wajib diisi.";
    }
} else {
    // Jika file ini diakses langsung tanpa submit form
    header("Location: register.php");
    exit;
}
?>