<?php
require 'function.php';
$id = $_GET["id"];
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

$fakultasList = getFakultas();
$jurusanList = getJurusan();

if (isset($_POST["submit"])) {
    $_POST["id"] = $id; // Ensure id is set in POST data
    if (ubah($_POST) > 0) {
        echo "<script>
            alert('data berhasil diubah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('data gagal diubah!');
            document.location.href = 'index.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        form ul {
            list-style: none;
            padding: 0;
        }

        form ul li {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], select {
            width: calc(100% - 10px);
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fakultasSelect = document.getElementById('fakultas');
            const jurusanSelect = document.getElementById('jurusan');
            const jurusanList = <?= json_encode($jurusanList) ?>;
            
            fakultasSelect.addEventListener('change', function() {
                const fakultasId = this.value;
                jurusanSelect.innerHTML = '<option value="">Select Jurusan</option>';
                jurusanList.forEach(jurusan => {
                    if (jurusan.fakultas_id == fakultasId) {
                        const option = document.createElement('option');
                        option.value = jurusan.jurusan_id;
                        option.text = jurusan.jurusan_name;
                        jurusanSelect.add(option);
                    }
                });
            });

            // Pre-select current jurusan
            const currentJurusan = <?= json_encode($mhs["jurusan"]); ?>;
            if (currentJurusan) {
                jurusanSelect.value = currentJurusan;
            }
        });
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Ubah Data Mahasiswa</h1>
        <form action="" method="POST">
            <ul>
                <li>
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" id="nama" required value="<?= $mhs["nama"]; ?>">
                </li>
                <li>
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" required value="<?= $mhs["email"]; ?>">
                </li>
                <li>
                    <label for="fakultas">Fakultas:</label>
                    <select name="fakultas" id="fakultas" required>
                        <option value="">Select Fakultas</option>
                        <?php foreach ($fakultasList as $fakultas): ?>
                            <option value="<?= $fakultas['fakultas_id']; ?>" <?= $mhs['fakultas'] == $fakultas['fakultas_id'] ? 'selected' : ''; ?>><?= $fakultas['fakultas_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </li>
                <li>
                    <label for="jurusan">Jurusan:</label>
                    <select name="jurusan" id="jurusan" required>
                        <option value="">Select Jurusan</option>
                        <?php foreach ($jurusanList as $jurusan): ?>
                            <option value="<?= $jurusan['jurusan_id']; ?>" <?= $mhs['jurusan'] == $jurusan['jurusan_id'] ? 'selected' : ''; ?>><?= $jurusan['jurusan_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </li>
                <li>
                    <button type="submit" name="submit">Ubah Data Mahasiswa</button>
                </li>
            </ul>
        </form>
    </div>
</body>
</html>
