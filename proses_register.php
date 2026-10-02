<?php

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string(
        $koneksi,
        $_POST['username']
    );

    $password = $_POST['password'];

    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {

        header(
            "Location: register.php?error=password"
        );

        exit();
    }

    $cek = mysqli_query(
        $koneksi,
        "SELECT * FROM users
         WHERE username='$username'"
    );

    if (mysqli_num_rows($cek) > 0) {

        header(
            "Location: register.php?error=username"
        );

        exit();
    }

    $password_hash = md5($password);

    $sql = "
        INSERT INTO users
        (username, password)

        VALUES
        ('$username', '$password_hash')
    ";

    if (mysqli_query($koneksi, $sql)) {

        header("Location: login.php?success=1");

        exit();

    } else {

        echo "Gagal mendaftar: "
            . mysqli_error($koneksi);
    }
}

?>