<?php
require 'function.php';
if(isset($_POST["register"])){
    if(register($_POST) > 0){
        echo "<script>
        alert('berhasil registrasi!');
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
    <title>Registration</title>
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
            /* text-align: center; */
        }

        .form-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
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
            /* font-weight: bold; */
        }

        input[type="text"],
        input[type="password"] {
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

        .registration{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 class="registration">REGISTRATION</h1>
        <form action="" method="POST">
            <ul>
                <li>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </li>
                <li>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </li>
                <li>
                    <label for="password2">Re-enter Password</label>
                    <input type="password" name="password2" id="password2" required>
                </li>
                <li>
                    <button type="submit" name="register">Submit</button>
                </li>
            </ul>
        </form>
    </div>
</body>
</html>