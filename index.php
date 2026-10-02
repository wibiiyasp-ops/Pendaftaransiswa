<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: login.php");

    exit();
}

include 'koneksi.php';


// ================================
// SEARCH
// ================================

$search = "";

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string(
        $koneksi,
        $_GET['search']
    );
}


// ================================
// FILTER JURUSAN
// ================================

$filter_jurusan = "";

if (isset($_GET['jurusan'])) {

    $filter_jurusan = mysqli_real_escape_string(
        $koneksi,
        $_GET['jurusan']
    );
}


// ================================
// QUERY DATA
// ================================

$sql = "
    SELECT
        tb_siswa.*,
        tb_jurusan.nama_jurusan

    FROM tb_siswa

    INNER JOIN tb_jurusan
    ON tb_siswa.id_jurusan =
       tb_jurusan.id_jurusan

    WHERE 1=1
";


if ($search != "") {

    $sql .= "
        AND (
            tb_siswa.nis LIKE '%$search%'
            OR tb_siswa.nama LIKE '%$search%'
        )
    ";
}


if ($filter_jurusan != "") {

    $sql .= "
        AND tb_siswa.id_jurusan =
        '$filter_jurusan'
    ";
}


$sql .= "
    ORDER BY tb_siswa.id DESC
";


$query = mysqli_query($koneksi, $sql);


// ================================
// STATISTIK
// ================================

$total_siswa = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT COUNT(*) AS total
         FROM tb_siswa"
    )
)['total'];


$total_jurusan = mysqli_fetch_assoc(
    mysqli_query(
        $koneksi,
        "SELECT COUNT(*) AS total
         FROM tb_jurusan"
    )
)['total'];

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Dashboard Pendaftaran Siswa</title>

<style>

* {
    box-sizing: border-box;
}

body {

    margin: 0;

    font-family: Arial, sans-serif;

    background: #f4f7fb;

    color: #333;
}

.navbar {

    background: #007bff;

    color: white;

    padding: 18px 30px;

    display: flex;

    justify-content: space-between;

    align-items: center;
}

.logo {

    font-size: 20px;

    font-weight: bold;
}

.user-area {

    display: flex;

    align-items: center;

    gap: 15px;
}

.logout {

    background: #dc3545;

    color: white;

    padding: 8px 14px;

    border-radius: 6px;

    text-decoration: none;

    font-size: 13px;
}

.container {

    max-width: 1200px;

    margin: 30px auto;

    padding: 0 20px;
}

.header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 25px;
}

.header h1 {

    margin: 0;

    color: #222;
}

.header p {

    color: #777;
}


/* STATISTIK */

.stats {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 20px;

    margin-bottom: 25px;
}

.stat-card {

    background: white;

    padding: 25px;

    border-radius: 12px;

    box-shadow:
        0 3px 12px rgba(0,0,0,.07);
}

.stat-card h3 {

    margin: 0;

    color: #777;

    font-size: 14px;
}

.stat-card .number {

    margin-top: 10px;

    font-size: 32px;

    font-weight: bold;

    color: #007bff;
}


/* FORM */

.card {

    background: white;

    padding: 25px;

    border-radius: 12px;

    box-shadow:
        0 3px 12px rgba(0,0,0,.07);

    margin-bottom: 25px;
}

.card h2 {

    margin-top: 0;

    margin-bottom: 20px;
}

.form-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 18px;
}

.form-group {

    margin-bottom: 5px;
}

.form-group.full {

    grid-column:
        1 / -1;
}

label {

    display: block;

    margin-bottom: 7px;

    font-weight: bold;

    font-size: 14px;
}

input,
select,
textarea {

    width: 100%;

    padding: 11px;

    border: 1px solid #ddd;

    border-radius: 7px;

    font-size: 14px;
}

textarea {

    resize: vertical;
}

input:focus,
select:focus,
textarea:focus {

    outline: none;

    border-color: #007bff;
}

.preview {

    width: 100px;

    height: 120px;

    object-fit: cover;

    border-radius: 8px;

    border: 2px solid #ddd;

    margin-top: 10px;

    display: none;
}

.btn {

    border: none;

    border-radius: 7px;

    padding: 10px 15px;

    color: white;

    text-decoration: none;

    cursor: pointer;

    display: inline-block;

    font-size: 13px;
}

.btn-primary {

    background: #007bff;
}

.btn-success {

    background: #198754;
}

.btn-warning {

    background: #ffc107;

    color: #222;
}

.btn-danger {

    background: #dc3545;
}

.btn-info {

    background: #0dcaf0;

    color: #222;
}


/* SEARCH */

.filter-box {

    display: grid;

    grid-template-columns:
        2fr 1fr auto auto;

    gap: 10px;

    margin-bottom: 20px;
}


/* TABLE */

.table-wrapper {

    overflow-x: auto;
}

table {

    width: 100%;

    border-collapse: collapse;
}

th {

    background: #007bff;

    color: white;

    padding: 13px;

    text-align: left;
}

td {

    padding: 12px;

    border-bottom: 1px solid #eee;

    vertical-align: middle;
}

tr:hover {

    background: #f8fbff;
}

.foto {

    width: 55px;

    height: 65px;

    object-fit: cover;

    border-radius: 6px;

    border: 1px solid #ddd;
}

.aksi {

    display: flex;

    gap: 5px;

    flex-wrap: wrap;
}

.empty {

    text-align: center;

    padding: 30px;

    color: #777;
}

@media(max-width: 768px) {

    .stats,
    .form-grid {

        grid-template-columns: 1fr;
    }

    .filter-box {

        grid-template-columns: 1fr;
    }

    .navbar {

        padding: 15px;
    }

    .user-area {

        font-size: 12px;
    }
}

</style>

</head>

<body>


<!-- ============================= -->
<!-- NAVBAR -->
<!-- ============================= -->

<div class="navbar">

    <div class="logo">
        Pendaftaran Siswa
    </div>

    <div class="user-area">

        <span>
            Admin:
            <strong>
                <?php
                echo htmlspecialchars(
                    $_SESSION['username']
                );
                ?>
            </strong>
        </span>

        <a
            href="logout.php"
            class="logout"
            onclick="
                return confirm(
                    'Yakin ingin logout?'
                )
            "
        >
            Logout
        </a>

    </div>

</div>


<div class="container">


<!-- ============================= -->
<!-- HEADER -->
<!-- ============================= -->

<div class="header">

    <div>

        <h1>
            Dashboard
        </h1>

        <p>
            Kelola data pendaftaran siswa
        </p>

    </div>

    <a
        href="jurusan.php"
        class="btn btn-primary"
    >
        Kelola Jurusan
    </a>

</div>


<!-- ============================= -->
<!-- STATISTIK -->
<!-- ============================= -->

<div class="stats">

    <div class="stat-card">

        <h3>
            Total Siswa
        </h3>

        <div class="number">
            <?php echo $total_siswa; ?>
        </div>

    </div>


    <div class="stat-card">

        <h3>
            Total Jurusan
        </h3>

        <div class="number">
            <?php echo $total_jurusan; ?>
        </div>

    </div>

</div>


<!-- ============================= -->
<!-- FORM PENDAFTARAN -->
<!-- ============================= -->

<div class="card">

    <h2>
        Form Pendaftaran Siswa Baru
    </h2>

    <form
        action="simpan.php"
        method="POST"
        enctype="multipart/form-data"
        onsubmit="return validasiForm()"
    >

        <div class="form-grid">


            <!-- NIS -->

            <div class="form-group">

                <label>
                    NIS
                </label>

                <input
                    type="text"
                    id="nis"
                    name="nis"
                    maxlength="10"
                    placeholder="Masukkan NIS"
                    required
                >

            </div>


            <!-- NAMA -->

            <div class="form-group">

                <label>
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    placeholder="Masukkan nama lengkap"
                    required
                >

            </div>


            <!-- JURUSAN -->

            <div class="form-group">

                <label>
                    Jurusan
                </label>

                <select
                    name="id_jurusan"
                    required
                >

                    <option value="">
                        -- Pilih Jurusan --
                    </option>

                    <?php

                    $jurusan_query = mysqli_query(
                        $koneksi,
                        "SELECT * FROM tb_jurusan
                         ORDER BY nama_jurusan ASC"
                    );

                    while (
                        $j =
                        mysqli_fetch_assoc(
                            $jurusan_query
                        )
                    ):

                    ?>

                    <option
                        value="<?php
                        echo $j['id_jurusan'];
                        ?>"
                    >

                        <?php
                        echo htmlspecialchars(
                            $j['nama_jurusan']
                        );
                        ?>

                    </option>

                    <?php endwhile; ?>

                </select>

            </div>


            <!-- FOTO -->

            <div class="form-group">

                <label>
                    Pasfoto
                </label>

                <input
                    type="file"
                    id="foto"
                    name="foto"
                    accept=".jpg,.jpeg,.png"
                    required
                    onchange="previewFoto(event)"
                >

                <small>
                    JPG/PNG, maksimal 2 MB
                </small>

                <br>

                <img
                    id="preview"
                    class="preview"
                    alt="Preview foto"
                >

            </div>


            <!-- ALASAN -->

            <div class="form-group full">

                <label>
                    Alasan Masuk
                </label>

                <textarea
                    name="alasan"
                    rows="4"
                    placeholder="Tuliskan alasan masuk sekolah..."
                    required
                ></textarea>

            </div>


            <div class="form-group full">

                <button
                    type="submit"
                    class="btn btn-success"
                >
                    + Daftar Siswa
                </button>

            </div>

        </div>

    </form>

</div>


<!-- ============================= -->
<!-- DATA SISWA -->
<!-- ============================= -->

<div class="card">

    <h2>
        Daftar Siswa Terdaftar
    </h2>


    <!-- SEARCH FILTER -->

    <form
        method="GET"
        class="filter-box"
    >

        <input
            type="text"
            name="search"
            placeholder="Cari NIS atau nama..."
            value="<?php
                echo htmlspecialchars($search);
            ?>"
        >


        <select name="jurusan">

            <option value="">
                Semua Jurusan
            </option>

            <?php

            $filter_query = mysqli_query(
                $koneksi,
                "SELECT * FROM tb_jurusan
                 ORDER BY nama_jurusan ASC"
            );

            while (
                $j2 =
                mysqli_fetch_assoc(
                    $filter_query
                )
            ):

            ?>

            <option
                value="<?php
                    echo $j2['id_jurusan'];
                ?>"
                <?php
                if (
                    $filter_jurusan ==
                    $j2['id_jurusan']
                ) {
                    echo 'selected';
                }
                ?>
            >

                <?php
                echo htmlspecialchars(
                    $j2['nama_jurusan']
                );
                ?>

            </option>

            <?php endwhile; ?>

        </select>


        <button
            type="submit"
            class="btn btn-primary"
        >
            Cari
        </button>


        <a
            href="index.php"
            class="btn btn-warning"
        >
            Reset
        </a>

    </form>


    <!-- TABLE -->

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Pasfoto
                    </th>

                    <th>
                        NIS
                    </th>

                    <th>
                        Nama
                    </th>

                    <th>
                        Jurusan
                    </th>

                    <th>
                        Alasan
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

            <?php

            $no = 1;

            if (
                mysqli_num_rows($query)
                > 0
            ):

                while (
                    $row =
                    mysqli_fetch_assoc($query)
                ):

            ?>

                <tr>

                    <td>
                        <?php echo $no++; ?>
                    </td>


                    <td>

                        <?php if (
                            !empty($row['foto'])
                        ): ?>

                            <img
                                src="uploads/<?php
                                    echo htmlspecialchars(
                                        $row['foto']
                                    );
                                ?>"
                                class="foto"
                                alt="Foto siswa"
                            >

                        <?php endif; ?>

                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $row['nis']
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $row['nama']
                        );
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
                        <?php
                        echo htmlspecialchars(
                            $row['alasan']
                        );
                        ?>
                    </td>


                    <td>

                        <div class="aksi">

                            <a
                                href="edit.php?id=<?php
                                    echo $row['id'];
                                ?>"
                                class="btn btn-warning"
                            >
                                Edit
                            </a>


                            <a
                                href="cetak.php?id=<?php
                                    echo $row['id'];
                                ?>"
                                target="_blank"
                                class="btn btn-info"
                            >
                                Cetak
                            </a>


                            <a
                                href="hapus.php?id=<?php
                                    echo $row['id'];
                                ?>"
                                class="btn btn-danger"
                                onclick="
                                    return confirm(
                                        'Yakin ingin menghapus data ini?'
                                    )
                                "
                            >
                                Hapus
                            </a>

                        </div>

                    </td>

                </tr>

            <?php

                endwhile;

            else:

            ?>

                <tr>

                    <td
                        colspan="7"
                        class="empty"
                    >
                        Data siswa tidak ditemukan.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</div>


<script>

function previewFoto(event) {

    const file =
        event.target.files[0];

    const preview =
        document.getElementById(
            "preview"
        );

    if (!file) {

        preview.style.display = "none";

        return;
    }

    if (file.size > 2 * 1024 * 1024) {

        alert(
            "Ukuran foto maksimal 2 MB!"
        );

        event.target.value = "";

        preview.style.display = "none";

        return;
    }

    preview.src =
        URL.createObjectURL(file);

    preview.style.display = "inline-block";
}


function validasiForm() {

    const nis =
        document.getElementById(
            "nis"
        ).value.trim();

    const nama =
        document.getElementById(
            "nama"
        ).value.trim();

    const foto =
        document.getElementById(
            "foto"
        ).files[0];


    if (nis === "") {

        alert(
            "NIS wajib diisi!"
        );

        return false;
    }


    if (!/^[0-9]+$/.test(nis)) {

        alert(
            "NIS hanya boleh berisi angka!"
        );

        return false;
    }


    if (nama === "") {

        alert(
            "Nama wajib diisi!"
        );

        return false;
    }


    if (!foto) {

        alert(
            "Pasfoto wajib diupload!"
        );

        return false;
    }


    if (foto.size > 2 * 1024 * 1024) {

        alert(
            "Ukuran foto maksimal 2 MB!"
        );

        return false;
    }


    return true;
}

</script>

</body>

</html>