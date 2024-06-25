<?php
require __DIR__ . '/app/autoload.php';
session_start();

use Absensi\Mahasiswa;
use Absensi\Absensi;

$absensi = new Absensi();

// Initialize student list from session or create an empty array if not set
$mahasiswaList = isset($_SESSION['mahasiswaList']) ? $_SESSION['mahasiswaList'] : [];

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $jurusan = $_POST['jurusan'];
        $status = $_POST['status'];
        $mahasiswa = new Mahasiswa($id, $nama, $jurusan, $status);
        $absensi->tambahMahasiswa($mahasiswa);
        $_SESSION['mahasiswaList'][] = $mahasiswa; // Add new student to the session
        // Redirect to avoid form resubmission on refresh
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['hapus'])) {
        $hapusId = $_POST['id'];
        $absensi->hapusMahasiswa($hapusId);
        $_SESSION['mahasiswaList'] = $absensi->getMahasiswaList(); // Update mahasiswaList from Absensi object to session
        // Redirect to avoid form resubmission on refresh
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['edit'])) {
        $editId = $_POST['id'];
        $editNama = $_POST['nama'];
        $editJurusan = $_POST['jurusan'];
        $editStatus = $_POST['status'];
        $absensi->editMahasiswa($editId, $editNama, $editJurusan, $editStatus);
        $_SESSION['mahasiswaList'] = $absensi->getMahasiswaList(); // Update mahasiswaList from Absensi object to session
        // Redirect to avoid form resubmission on refresh
        header("Location: index.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Mahasiswa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            margin-top: 20px;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .form-inline .form-control {
            margin-right: 10px;
        }
        .edit, .hapus {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Sistem Absensi Mahasiswa</h1>
        <form class="form-inline justify-content-center" method="post">
            <input type="text" name="id" class="form-control" placeholder="ID Mahasiswa" required>
            <input type="text" name="nama" class="form-control" placeholder="Nama Mahasiswa" required>
            <input type="text" name="jurusan" class="form-control" placeholder="Jurusan" required>
            <select name="status" class="form-control" required>
                <option value="Hadir">Hadir</option>
                <option value="Alpha">Alpha</option>
                <option value="Ijin">Ijin</option>
            </select>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah Mahasiswa</button>
        </form>

        <h2 class="text-center">Daftar Mahasiswa</h2>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mahasiswaList as $mahasiswa): ?>
                <tr>
                    <td><?= $mahasiswa->getId() ?></td>
                    <td>
                        <span id="nama-text-<?= $mahasiswa->getId() ?>"><?= $mahasiswa->getNama() ?></span>
                        <input type="text" id="nama-input-<?= $mahasiswa->getId() ?>" name="nama" value="<?= $mahasiswa->getNama() ?>" class="form-control" style="display:none;" required>
                    </td>
                    <td>
                        <span id="jurusan-text-<?= $mahasiswa->getId() ?>"><?= $mahasiswa->getJurusan() ?></span>
                        <input type="text" id="jurusan-input-<?= $mahasiswa->getId() ?>" name="jurusan" value="<?= $mahasiswa->getJurusan() ?>" class="form-control" style="display:none;" required>
                    </td>
                    <td>
                        <span id="status-text-<?= $mahasiswa->getId() ?>"><?= $mahasiswa->getStatus() ?></span>
                        <select id="status-input-<?= $mahasiswa->getId() ?>" name="status" class="form-control" style="display:none;" required>
                            <option value="Hadir" <?= $mahasiswa->getStatus() == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                            <option value="Alpha" <?= $mahasiswa->getStatus() == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
                            <option value="Ijin" <?= $mahasiswa->getStatus() == 'Ijin' ? 'selected' : '' ?>>Ijin</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning edit" onclick="toggleEdit(<?= $mahasiswa->getId() ?>)">Edit</button>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $mahasiswa->getId() ?>">
                            <button type="submit" name="hapus" class="btn btn-danger hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <script>
    function toggleEdit(id) {
        var namaText = document.getElementById('nama-text-' + id);
        var jurusanText = document.getElementById('jurusan-text-' + id);
        var statusText = document.getElementById('status-text-' + id);
        var namaInput = document.getElementById('nama-input-' + id);
        var jurusanInput = document.getElementById('jurusan-input-' + id);
        var statusInput = document.getElementById('status-input-' + id);

        if (namaText.style.display === 'none') {
            namaText.textContent = namaInput.value;
            jurusanText.textContent = jurusanInput.value;
            statusText.textContent = statusInput.value;

            namaText.style.display = 'inline';
            jurusanText.style.display = 'inline';
            statusText.style.display = 'inline';
            namaInput.style.display = 'none';
            jurusanInput.style.display = 'none';
            statusInput.style.display = 'none';
        } else {
            namaText.style.display = 'none';
            jurusanText.style.display = 'none';
            statusText.style.display = 'none';
            namaInput.style.display = 'inline';
            jurusanInput.style.display = 'inline';
            statusInput.style.display = 'inline';
        }
    }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
