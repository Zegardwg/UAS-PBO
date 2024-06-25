<?php
namespace Absensi;

use Absensi\MahasiswaInterface;

class Mahasiswa implements MahasiswaInterface {
    // Properties
    private $id;
    private $nama;
    private $jurusan;

    // Constructor
    public function __construct($id, $nama, $jurusan) {
        $this->id = $id;
        $this->nama = $nama;
        $this->jurusan = $jurusan;
    }

    // Implementing methods from MahasiswaInterface
    public function getId() {
        return $this->id;
    }

    public function getNama() {
        return $this->nama;
    }

    public function getJurusan() {
        return $this->jurusan;
    }

    public function getInfo() {
        return "ID: {$this->id}, Nama: {$this->nama}, Jurusan: {$this->jurusan}";
    }
}
?>
