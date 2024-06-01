<?php
session_start();

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
require 'function.php';

// Updated query to use LEFT JOIN
$mahasiswa = query("SELECT mahasiswa.*, fakultas.fakultas_name, jurusan.jurusan_name 
                    FROM mahasiswa
                    LEFT JOIN fakultas ON mahasiswa.fakultas = fakultas.fakultas_id
                    LEFT JOIN jurusan ON mahasiswa.jurusan = jurusan.jurusan_id");

if(isset($_POST["cari"])){
    $mahasiswa = cari($_POST["cari"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Mahasiswa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <form action="" method="POST" class="mb-3">
            <div class="form-group">
                <label for="cari">Cari mahasiswa</label>
                <input type="text" name="cari" id="cari" class="form-control">
            </div>
        </form>
        <div class="mb-3">
            <a href="registrasi.php" class="btn btn-primary">Tambah Admin</a>
            <a href="tambah.php" class="btn btn-primary">Tambah Mahasiswa</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Fakultas</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($mahasiswa as $mhs): ?>
                <tr>
                    <td><?= $mhs["nama"] ?></td>
                    <td><?= $mhs["nim"] ?></td>
                    <td><?= $mhs["email"] ?></td>
                    <td><?= $mhs["fakultas_name"] ?></td>
                    <td><?= $mhs["jurusan_name"] ?></td>
                    <td>
                        <a href="ubah.php?id=<?= $mhs["id"] ?>" class="btn btn-warning btn-sm">Ubah</a> 
                        <a href="hapus.php?id=<?= $mhs["id"]?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete data?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
