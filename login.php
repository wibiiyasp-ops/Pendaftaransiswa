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

    <title>Login Admin</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #007bff, #0056b3);

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 390px;
            background: white;
            padding: 35px;
            border-radius: 15px;

            box-shadow:
                0 15px 40px rgba(0,0,0,.2);
        }

        .logo {
            width: 70px;
            height: 70px;

            margin: auto;
            margin-bottom: 15px;

            background: #007bff;
            color: white;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 28px;
            font-weight: bold;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
            color: #222;
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

            font-size: 14px;
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

        .success {
            background: #d1e7dd;
            color: #0f5132;

            padding: 12px;
            border-radius: 8px;

            margin-bottom: 15px;

            text-align: center;
        }

        .register {
            text-align: center;
            margin-top: 20px;
        }

        .register a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            color: #999;
            font-size: 12px;
        }

    </style>

</head>

<body>

<div class="login-box">

    <div class="logo">
        PS
    </div>

    <h2>Login Admin</h2>

    <div class="subtitle">
        Sistem Pendaftaran Siswa Baru
    </div>

    <?php if (isset($_GET['success'])): ?>

        <div class="success">
            Akun berhasil dibuat. Silakan login.
        </div>

    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>

        <div class="error">
            Username atau password salah!
        </div>

    <?php endif; ?>

    <form action="proses_login.php" method="POST">

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

        <button type="submit" class="btn">
            Login
        </button>

    </form>

    <div class="register">

        Belum punya akun?

        <a href="register.php">
            Daftar di sini
        </a>

    </div>

    <div class="footer">
        © 2026 Sistem Pendaftaran Siswa
    </div>

</div>

</body>

</html>