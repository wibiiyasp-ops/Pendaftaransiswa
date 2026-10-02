<?php

include 'koneksi.php';

if (!isset($_GET['id'])) {

    header("Location: index.php");

    exit();
}


$id = intval(
    $_GET['id']
);


// ================================
// AMBIL FOTO
// ================================

$query = mysqli_query(
    $koneksi,
    "SELECT foto
     FROM tb_siswa
     WHERE id='$id'"
);

$data =
    mysqli_fetch_assoc($query);


if (!$data) {

    header("Location: index.php");

    exit();
}


$foto =
    $data['foto'];


// ================================
// HAPUS DATABASE
// ================================

$sql =
    "DELETE FROM tb_siswa
     WHERE id='$id'";


if (
    mysqli_query(
        $koneksi,
        $sql
    )
) {


    // ============================
    // HAPUS FILE FOTO
    // ============================

    if (
        !empty($foto)
        &&
        file_exists(
            "uploads/"
            . $foto
        )
    ) {

        unlink(
            "uploads/"
            . $foto
        );
    }


    header(
        "Location: index.php"
    );

    exit();


} else {

    echo
        "Gagal menghapus data: "
        . mysqli_error($koneksi);
}

?>