<?php
class Hewan {
    protected $id;
    protected $nama;
    protected $jenis_makanan;
    protected $emoticon; // NEW PROPERTY

    public function __construct($id, $nama, $jenis_makanan, $emoticon = '') { // ADDED emoticon parameter
        $this->id = $id;
        $this->nama = $nama;
        $this->jenis_makanan = $jenis_makanan;
        $this->emoticon = $emoticon; // ASSIGN emoticon
    }

    public function getId() {
        return $this->id;
    }

    public function getNama() {
        return $this->nama;
    }

    public function getJenisMakanan() {
        return $this->jenis_makanan;
    }

    public function getEmoticon() { // NEW GETTER
        return $this->emoticon;
    }

    public function bersuara() {
        return "Suara hewan";
    }
}
?>