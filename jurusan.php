<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: login.php");

    exit();
}

include 'koneksi.php';


// ==================================
// TAMBAH JURUSAN
// ==================================

if (
    isset($_POST['tambah'])
) {

    $nama =
        mysqli_real_escape_string(
            $koneksi,
            $_POST['nama_jurusan']
        );


    if ($nama != "") {

        mysqli_query(
            $koneksi,
            "INSERT INTO tb_jurusan
             (nama_jurusan)
             VALUES
             ('$nama')"
        );
    }


    header("Location: jurusan.php");

    exit();
}


// ==================================
// HAPUS JURUSAN
// ==================================

if (
    isset($_GET['hapus'])
) {

    $id =
        intval(
            $_GET['hapus']
        );


    mysqli_query(
        $koneksi,
        "DELETE FROM tb_jurusan
         WHERE id_jurusan='$id'"
    );


    header("Location: jurusan.php");

    exit();
}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Master Jurusan</title>

<style>

body {

    margin: 0;

    font-family: Arial, sans-serif;

    background: #f4f7fb;
}

.container {

    max-width: 850px;

    margin: 40px auto;

    padding: 20px;
}

.card {

    background: white;

    padding: 25px;

    border-radius: 12px;

    box-shadow:
        0 3px 15px rgba(0,0,0,.08);

    margin-bottom: 20px;
}

h1 {

    margin-top: 0;
}

.form {

    display: flex;

    gap: 10px;
}

input {

    flex: 1;

    padding: 12px;

    border: 1px solid #ddd;

    border-radius: 7px;
}

button,
.btn {

    padding: 11px 16px;

    border: none;

    border-radius: 7px;

    text-decoration: none;

    cursor: pointer;
}

.btn-primary {

    background: #007bff;

    color: white;
}

.btn-danger {

    background: #dc3545;

    color: white;
}

.btn-secondary {

    background: #6c757d;

    color: white;
}

table {

    width: 100%;

    border-collapse: collapse;
}

th {

    background: #007bff;

    color: white;

    padding: 12px;

    text-align: left;
}

td {

    padding: 12px;

    border-bottom: 1px solid #eee;
}

.aksi {

    display: flex;

    gap: 5px;
}

</style>

</head>

<body>

<div class="container">

<div class="card">

    <a
        href="index.php"
        class="btn btn-secondary"
    >
        ← Kembali
    </a>

    <h1>
        Kelola Master Jurusan
    </h1>

    <p>
        Tambahkan jurusan yang akan
        digunakan pada pendaftaran siswa.
    </p>

</div>


<div class="card">

    <h2>
        Tambah Jurusan
    </h2>

    <form
        method="POST"
        class="form"
    >

        <input
            type="text"
            name="nama_jurusan"
            placeholder="Nama jurusan..."
            required
        >

        <button
            type="submit"
            name="tambah"
            class="btn-primary"
        >
            + Tambah
        </button>

    </form>

</div>


<div class="card">

    <h2>
        Daftar Jurusan
    </h2>

    <table>

        <thead>

            <tr>

                <th>
                    ID
                </th>

                <th>
                    Nama Jurusan
                </th>

                <th>
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

        <?php

        $query =
            mysqli_query(
                $koneksi,
                "SELECT *
                 FROM tb_jurusan
                 ORDER BY id_jurusan ASC"
            );


        while (
            $row =
            mysqli_fetch_assoc(
                $query
            )
        ):

        ?>

        <tr>

            <td>
                <?php
                echo $row['id_jurusan'];
                ?>
            </td>

            <td>
                <?php

                echo htmlspecialchars(
                    $row['nama_jurusan']
                );

                ?>
            </td>

            <td>

                <a
                    href="jurusan.php?hapus=<?php
                        echo $row['id_jurusan'];
                    ?>"
                    class="btn btn-danger"
                    onclick="
                        return confirm(
                            'Yakin ingin menghapus jurusan ini?'
                        )
                    "
                >
                    Hapus
                </a>

            </td>

        </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

</div>

</body>

</html>