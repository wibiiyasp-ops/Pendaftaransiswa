<?php

session_start();

if (isset($_SESSION['login'])) {

    header("Location: index.php");

    exit();
}

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Admin</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            font-family: Arial, sans-serif;

            background: linear-gradient(
                135deg,
                #007bff,
                #0056b3
            );

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-box {
            width: 390px;

            background: white;

            padding: 35px;

            border-radius: 15px;

            box-shadow:
                0 15px 40px rgba(0,0,0,.2);
        }

        h2 {
            text-align: center;
            color: #222;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;

            border: 1px solid #ddd;

            border-radius: 8px;
        }

        input:focus {
            outline: none;
            border-color: #007bff;
        }

        .btn {
            width: 100%;
            padding: 12px;

            border: none;
            border-radius: 8px;

            background: #007bff;

            color: white;

            font-size: 15px;
            font-weight: bold;

            cursor: pointer;
        }

        .btn:hover {
            background: #0056b3;
        }

        .error {
            background: #f8d7da;
            color: #842029;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 15px;

            text-align: center;
        }

        .login {
            text-align: center;

            margin-top: 20px;
        }

        .login a {
            color: #007bff;

            text-decoration: none;

            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="register-box">

    <h2>Daftar Akun Admin</h2>

    <div class="subtitle">
        Buat akun untuk mengakses sistem
    </div>

    <?php if (
        isset($_GET['error'])
        &&
        $_GET['error'] == 'username'
    ): ?>

        <div class="error">
            Username sudah digunakan!
        </div>

    <?php elseif (
        isset($_GET['error'])
        &&
        $_GET['error'] == 'password'
    ): ?>

        <div class="error">
            Password tidak sama!
        </div>

    <?php endif; ?>

    <form
        action="proses_register.php"
        method="POST"
    >

        <div class="form-group">

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            >

        </div>

        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

        </div>

        <div class="form-group">

            <label>Konfirmasi Password</label>

            <input
                type="password"
                name="confirm_password"
                placeholder="Ulangi password"
                required
            >

        </div>

        <button type="submit" class="btn">
            Daftar
        </button>

    </form>

    <div class="login">

        Sudah punya akun?

        <a href="login.php">
            Login di sini
        </a>

    </div>

</div>

</body>

</html>