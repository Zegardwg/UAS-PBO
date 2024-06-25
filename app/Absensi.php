<?php
namespace Absensi;

use Absensi\Mahasiswa;

class Absensi {
    private $mahasiswaList = [];

    public function tambahMahasiswa(Mahasiswa $mahasiswa) {
        $this->mahasiswaList[] = $mahasiswa;
    }

    public function hapusMahasiswa($id) {
        foreach ($this->mahasiswaList as $index => $mahasiswa) {
            if ($mahasiswa->getId() == $id) {
                unset($this->mahasiswaList[$index]);
                $this->mahasiswaList = array_values($this->mahasiswaList);
                return;
            }
        }
    }

    public function editMahasiswa($id, $namaBaru, $jurusanBaru) {
        foreach ($this->mahasiswaList as $mahasiswa) {
            if ($mahasiswa->getId() == $id) {
                $mahasiswa->nama = $namaBaru;
                $mahasiswa->jurusan = $jurusanBaru;
                return;
            }
        }
    }

    // Setter
    public function setMahasiswaList(array $mahasiswaList) {
        $this->mahasiswaList = $mahasiswaList;
    }

    // Getter
    public function getMahasiswaList() {
        return $this->mahasiswaList;
    }
}
?>
