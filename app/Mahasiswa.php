<?php
namespace Absensi;

use Absensi\Abstract\AbstractMahasiswa;

class Absensi {
    private $mahasiswaList = [];

    public function tambahMahasiswa($mahasiswa) {
        $this->mahasiswaList[] = $mahasiswa;
    }

    public function hapusMahasiswa($id) {
        $this->mahasiswaList = array_filter($this->mahasiswaList, function($mahasiswa) use ($id) {
            return $mahasiswa->getId() != $id;
        });
    }

    public function editMahasiswa($id, $nama, $jurusan, $status) {
        foreach ($this->mahasiswaList as $mahasiswa) {
            if ($mahasiswa->getId() == $id) {
                $mahasiswa->setNama($nama);
                $mahasiswa->setJurusan($jurusan);
                $mahasiswa->setStatus($status);
                break;
            }
        }
    }

    public function getMahasiswaList() {
        return $this->mahasiswaList;
    }
}

?>
