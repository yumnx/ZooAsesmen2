<?php
require_once 'Hewan.php';

class Omnivora extends Hewan {
    private $menu_favorit;

    public function __construct($id, $nama, $jenis_makanan, $menu_favorit, $emoticon = '') { // ADDED emoticon
        parent::__construct($id, $nama, $jenis_makanan, $emoticon); // PASS emoticon
        $this->menu_favorit = $menu_favorit;
    }

    public function getMenuFavorit() {
        return $this->menu_favorit;
    }

    public function bersuara() {
        return $this->getNama() . " makan apa saja!";
    }
}
?>