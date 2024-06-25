<?php
namespace Absensi;

class Mahasiswa {
    private $id;
    private $nama;
    private $jurusan;
    private $status;

    public function __construct($id, $nama, $jurusan, $status = 'Hadir') {
        $this->id = $id;
        $this->nama = $nama;
        $this->jurusan = $jurusan;
        $this->status = $status;
    }

    public function getId() {
        return $this->id;
    }

    public function getNama() {
        return $this->nama;
    }

    public function getJurusan() {
        return $this->jurusan;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}

class Absensi {
    private $mahasiswaList = [];

    public function tambahMahasiswa($mahasiswa) {
        $this->mahasiswaList[] = $mahasiswa;
    }

    public function hapusMahasiswa($id) {
        foreach ($this->mahasiswaList as $key => $mahasiswa) {
            if ($mahasiswa->getId() == $id) {
                unset($this->mahasiswaList[$key]);
            }
        }
        $this->mahasiswaList = array_values($this->mahasiswaList); // Reindex array
    }

    public function editMahasiswa($id, $nama, $jurusan) {
        foreach ($this->mahasiswaList as $mahasiswa) {
            if ($mahasiswa->getId() == $id) {
                $mahasiswa->nama = $nama;
                $mahasiswa->jurusan = $jurusan;
            }
        }
    }

    public function getMahasiswaList() {
        return $this->mahasiswaList;
    }
}
