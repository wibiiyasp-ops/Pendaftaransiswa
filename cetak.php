<?php

include 'koneksi.php';

$id = intval(
    $_GET['id'] ?? 0
);


$query = mysqli_query(
    $koneksi,

    "SELECT
        tb_siswa.*,
        tb_jurusan.nama_jurusan

     FROM tb_siswa

     INNER JOIN tb_jurusan
     ON tb_siswa.id_jurusan =
        tb_jurusan.id_jurusan

     WHERE tb_siswa.id='$id'"
);


$data =
    mysqli_fetch_assoc($query);


if (!$data) {

    die(
        "Data siswa tidak ditemukan."
    );
}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>
    Bukti Pendaftaran -
    <?php echo htmlspecialchars(
        $data['nama']
    ); ?>
</title>

<style>

body {

    margin: 0;

    font-family: Arial, sans-serif;

    background: #eee;
}

.card {

    width: 700px;

    margin: 40px auto;

    background: white;

    padding: 35px;

    border-radius: 12px;

    box-shadow:
        0 5px 20px rgba(0,0,0,.15);
}

.header {

    text-align: center;

    border-bottom: 3px solid #007bff;

    padding-bottom: 20px;

    margin-bottom: 25px;
}

.header h1 {

    margin: 0;

    color: #007bff;

    font-size: 24px;
}

.header p {

    margin-bottom: 0;

    color: #666;
}

.content {

    display: flex;

    gap: 30px;

    align-items: flex-start;
}

.foto {

    width: 140px;

    height: 175px;

    object-fit: cover;

    border-radius: 8px;

    border: 2px solid #ddd;
}

.data {

    flex: 1;
}

.row {

    display: grid;

    grid-template-columns:
        120px 20px 1fr;

    padding: 9px 0;

    border-bottom: 1px solid #eee;
}

.label {

    font-weight: bold;
}

.status {

    display: inline-block;

    margin-top: 20px;

    padding: 8px 15px;

    border-radius: 20px;

    background: #d1e7dd;

    color: #0f5132;

    font-weight: bold;
}

.buttons {

    text-align: center;

    margin-top: 30px;
}

.btn {

    display: inline-block;

    padding: 10px 20px;

    margin: 5px;

    border-radius: 7px;

    text-decoration: none;

    border: none;

    cursor: pointer;

    color: white;
}

.btn-print {

    background: #007bff;
}

.btn-back {

    background: #6c757d;
}

@media print {

    body {

        background: white;
    }

    .card {

        margin: 0;

        width: 100%;

        box-shadow: none;
    }

    .buttons {

        display: none;
    }

}

@media(max-width: 700px) {

    .card {

        width: 95%;
    }

    .content {

        flex-direction: column;

        align-items: center;
    }

}

</style>

</head>

<body>

<div class="card">


<div class="header">

    <h1>
        BUKTI PENDAFTARAN SISWA
    </h1>

    <p>
        SMK TUNAS MEDIA BANGSA TM
    </p>

</div>


<div class="content">


<div>

    <img
        src="uploads/<?php
            echo htmlspecialchars(
                $data['foto']
            );
        ?>"
        class="foto"
        alt="Pasfoto siswa"
    >

</div>


<div class="data">


<div class="row">

    <div class="label">
        NIS
    </div>

    <div>:</div>

    <div>
        <?php
        echo htmlspecialchars(
            $data['nis']
        );
        ?>
    </div>

</div>


<div class="row">

    <div class="label">
        Nama
    </div>

    <div>:</div>

    <div>
        <?php
        echo htmlspecialchars(
            $data['nama']
        );
        ?>
    </div>

</div>


<div class="row">

    <div class="label">
        Jurusan
    </div>

    <div>:</div>

    <div>
        <?php
        echo htmlspecialchars(
            $data['nama_jurusan']
        );
        ?>
    </div>

</div>


<div class="row">

    <div class="label">
        Alasan
    </div>

    <div>:</div>

    <div>
        <?php
        echo htmlspecialchars(
            $data['alasan']
        );
        ?>
    </div>

</div>


<div class="status">
    TERDAFTAR
</div>


</div>

</div>


<div class="buttons">

    <button
        onclick="window.print()"
        class="btn btn-print"
    >
        🖨 Cetak Kartu
    </button>


    <a
        href="index.php"
        class="btn btn-back"
    >
        Kembali
    </a>

</div>


</div>

</body>

</html>