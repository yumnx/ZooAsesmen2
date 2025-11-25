<?php
// classes/SistemZoo.php (Pastikan require_once hewan tetap ada di atas)
require_once 'Karnivora.php';
require_once 'Herbivora.php';
require_once 'Omnivora.php';

class SistemZoo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method helper untuk menangani proses upload
    // $file = $_FILES['nama_input']
    // $kategori = 'image' atau 'file'
    public function uploadMedia($file, $kategori) {
        $targetDir = "";
        $allowedTypes = [];

        // Tentukan folder dan tipe file berdasarkan kategori
        if ($kategori == 'image') {
            $targetDir = "uploads/images/"; // Folder khusus gambar
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        } else {
            $targetDir = "uploads/files/";  // Folder khusus file biasa
            $allowedTypes = ['pdf', 'doc', 'docx', 'txt'];
        }

        // Ambil nama file dan ekstensinya
        $fileName = basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Validasi ekstensi
        if (!in_array($fileType, $allowedTypes)) {
            return ["status" => false, "msg" => "Format file tidak diizinkan untuk kategori " . $kategori];
        }

        // Coba pindahkan file dari temp ke folder tujuan
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return ["status" => true, "path" => $fileName]; // Kembalikan nama filenya saja
        } else {
            return ["status" => false, "msg" => "Gagal mengupload file."];
        }
    }

    // Update method registrasi untuk menyimpan nama file ke DB
    public function registrasiPengunjung($nama, $zona, $foto, $dokumen) {
        $query = "INSERT INTO pengunjung (nama_pengunjung, zona_pilihan, foto_profil, dokumen_file) 
                  VALUES (:nama, :zona, :foto, :dokumen)";
        $stmt = $this->conn->prepare($query);
        
        $nama = htmlspecialchars(strip_tags($nama));
        $zona = htmlspecialchars(strip_tags($zona));
        // Foto dan dokumen tidak perlu strip_tags karena hanya nama file

        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":zona", $zona);
        $stmt->bindParam(":foto", $foto);
        $stmt->bindParam(":dokumen", $dokumen);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // ... (Method getHewanByZona, getDaftarPengunjung, dll TETAP SAMA seperti sebelumnya) ...
    public function getHewanByZona($tipe) {
        // ... kode lama ...
        $query = "SELECT id, nama, jenis_makanan, tipe, favorit, emoticon FROM hewan WHERE tipe = :tipe";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tipe", $tipe);
        $stmt->execute();
        
        $hewanArray = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['tipe'] == 'Karnivora') {
                $hewanArray[] = new Karnivora($row['id'], $row['nama'], $row['jenis_makanan'], $row['favorit'], $row['emoticon']);
            } elseif ($row['tipe'] == 'Herbivora') {
                $hewanArray[] = new Herbivora($row['id'], $row['nama'], $row['jenis_makanan'], $row['favorit'], $row['emoticon']);
            } elseif ($row['tipe'] == 'Omnivora') {
                $hewanArray[] = new Omnivora($row['id'], $row['nama'], $row['jenis_makanan'], $row['favorit'], $row['emoticon']);
            }
        }
        return $hewanArray;
    }
    
    // Pastikan update getDaftarPengunjung untuk mengambil kolom foto & dokumen
    public function getDaftarPengunjung() {
        $query = "SELECT * FROM pengunjung ORDER BY tgl_registrasi DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // ... method delete/update lainnya ...
     public function deletePengunjung($id) {
        $query = "DELETE FROM pengunjung WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>