<?php
require_once 'Hewan.php';

class Herbivora extends Hewan {
    private $tumbuhan_favorit;

    public function __construct($id, $nama, $jenis_makanan, $tumbuhan_favorit, $emoticon = '') { // ADDED emoticon
        parent::__construct($id, $nama, $jenis_makanan, $emoticon); // PASS emoticon
        $this->tumbuhan_favorit = $tumbuhan_favorit;
    }

    public function getTumbuhanFavorit() {
        return $this->tumbuhan_favorit;
    }

    public function bersuara() {
        return $this->getNama() . " mengunyah daun...";
    }
}
?>