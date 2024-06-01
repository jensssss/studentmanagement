<?php
    $conn = mysqli_connect("localhost", "root", "", "phpdasar2");
    function query($query){
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows [] = $row;
        }
        return $rows;
    }
    function getTotalMahasiswa() {
        global $conn;
        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa");
        $data = mysqli_fetch_assoc($result);
        return $data['total'];
    }

    function tambah($data){
        global $conn;
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $jurusan = htmlspecialchars($data["jurusan"]);
        $fakultas = htmlspecialchars($data["fakultas"]);
        $nim = generateNIM();

        $query = "INSERT INTO mahasiswa (nama, email, jurusan, fakultas, nim)
              VALUES ('$nama', '$email', '$jurusan', '$fakultas', '$nim')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
    function generateNIM() {
        global $conn;
        
        do {
            // Generate a random 8-digit number
            $nim = rand(10000000, 99999999);
    
            // Check if the generated NIM already exists
            $result = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim = '$nim'");
        } while (mysqli_num_rows($result) > 0);
    
        return $nim;
    }

    function getFakultas() {
        global $conn;
        $result = mysqli_query($conn, "SELECT * FROM fakultas");
        $fakultas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $fakultas[] = $row;
        }
        return $fakultas;
    }
    
    function getJurusan() {
        global $conn;
        $result = mysqli_query($conn, "SELECT * FROM jurusan");
        $jurusan = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $jurusan[] = $row;
        }
        return $jurusan;
    }
    
    
    
    function hapus($id){
        global $conn;
        $query = "DELETE FROM mahasiswa WHERE id = $id";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function ubah($data){
        global $conn;
        $id = htmlspecialchars($data["id"]);
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $jurusan = htmlspecialchars($data["jurusan"]);
        $fakultas = htmlspecialchars($data["fakultas"]);
    
        $query = "UPDATE mahasiswa SET
            nama = '$nama',
            email = '$email',
            jurusan = '$jurusan',
            fakultas = '$fakultas'
            WHERE id = '$id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
    

    function cari($keyword){
        global $conn;
        $query = "SELECT mahasiswa.*, fakultas.fakultas_name, jurusan.jurusan_name 
                  FROM mahasiswa
                  LEFT JOIN fakultas ON mahasiswa.fakultas = fakultas.fakultas_id
                  LEFT JOIN jurusan ON mahasiswa.jurusan = jurusan.jurusan_id
                  WHERE
                  mahasiswa.nama LIKE '%$keyword%' OR
                  mahasiswa.email LIKE '%$keyword%' OR
                  fakultas.fakultas_name LIKE '%$keyword%' OR
                  jurusan.jurusan_name LIKE '%$keyword%' OR
                  mahasiswa.nim LIKE '%$keyword%'";
        return query($query);
    }
    

    function register($data){
        global $conn;
        $username = strtolower(stripcslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $password2 = mysqli_real_escape_string($conn, $data["password2"]);

        $query = "SELECT username FROM users WHERE username LIKE '$username'";
        $result = mysqli_query($conn, $query);
        if(mysqli_fetch_assoc($result)){
            echo "<script> alert('username sudah terdaftar') </script>";
            return false;
        }

        if($password !== $password2){
            echo "<script> alert('password tidak sesuai') </script>";
            return false;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users VALUES(
            '',
            '$username',
            '$password'
        )";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function login($data){
        global $conn;
        $username = $data["username"];
        $password =  $data["password"];

        $query = "SELECT * FROM users WHERE
        username LIKE '$username'";

        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row["password"])){
                $_SESSION["login"] = true;

                // cek remember me
                if(isset($_POST["remember"])){
                    setcookie("id", $row["id"], time() + 60);
                    setcookie("key", hash("sha256", $row["username"]), time() + 60);
                }
                header("Location:index.php");
                exit;
            }
            else{
                echo "<script> alert('password salah') </script>";
                return false;
            }
        }
        else{
            echo "<script> alert('nama tidak terdaftar') </script>";
            return false;
        }
    }
?>