CREATE DATABASE kebun_binatang;

USE kebun_binatang;

CREATE TABLE hewan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_makanan VARCHAR(100),
    tipe ENUM('Karnivora', 'Herbivora', 'Omnivora') NOT NULL,
    favorit VARCHAR(100),
    emoticon VARCHAR(10) 
);

CREATE TABLE pengunjung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pengunjung VARCHAR(255) NOT NULL,
    zona_pilihan ENUM('Karnivora', 'Herbivora', 'Omnivora') NOT NULL,
    tgl_registrasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO hewan (nama, jenis_makanan, tipe, favorit, emoticon) VALUES
('Singa', 'Daging', 'Karnivora', 'Zebra', '🦁'),
('Harimau', 'Daging', 'Karnivora', 'Rusa', '🐯'),
('Gajah', 'Tumbuhan', 'Herbivora', 'Rumput Gajah', '🐘'),
('Jerapah', 'Tumbuhan', 'Herbivora', 'Daun Akasia', '🦒'),
('Beruang', 'Segala Jenis Makanan', 'Omnivora', 'Ikan & Madu', '🐻'),
('Monyet', 'Segala Jenis Makanan', 'Omnivora', 'Pisang & Serangga', '🐒'),
('Serigala', 'Daging', 'Karnivora', 'Kelinci', '🐺'),
('Panda', 'Tumbuhan', 'Herbivora', 'Bambu', '🐼'),
('Rakun', 'Segala Jenis Makanan', 'Omnivora', 'Buah-buahan', '🦝');