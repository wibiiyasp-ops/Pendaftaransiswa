<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data input
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Pastikan nama tabel (misal: tb_user) dan kolom sesuai dengan database
    $sql = "SELECT * FROM tb_user WHERE username = '$username'";
    $query = mysqli_query($koneksi, $sql);

    // Cek jika kueri gagal dieksekusi (mencegah Fatal Error)
    if (!$query) {
        die("Kueri SQL Error: " . mysqli_error($koneksi));
    }

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        // Verifikasi password
        if ($password == $data['password']) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['status']   = "login";
            
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='login.php';</script>";
    }
}
?>