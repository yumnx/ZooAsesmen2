<?php
require_once 'Hewan.php';

class Karnivora extends Hewan {
    private $mangsa_favorit;

    public function __construct($id, $nama, $jenis_makanan, $mangsa_favorit, $emoticon = '') { // ADDED emoticon
        parent::__construct($id, $nama, $jenis_makanan, $emoticon); // PASS emoticon
        $this->mangsa_favorit = $mangsa_favorit;
    }

    public function getMangsaFavorit() {
        return $this->mangsa_favorit;
    }

    public function bersuara() {
        return $this->getNama() . " mengaum!";
    }
}
?>