<?php

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {

    header("Location: index.php");

    exit();
}


// ================================
// AMBIL DATA
// ================================

$nis = mysqli_real_escape_string(
    $koneksi,
    $_POST['nis']
);

$nama = mysqli_real_escape_string(
    $koneksi,
    $_POST['nama']
);

$id_jurusan = intval(
    $_POST['id_jurusan']
);

$alasan = mysqli_real_escape_string(
    $koneksi,
    $_POST['alasan']
);


// ================================
// VALIDASI FOTO
// ================================

if (
    !isset($_FILES['foto'])
    ||
    $_FILES['foto']['error']
    != 0
) {

    die(
        "Foto wajib diupload."
    );
}


$foto = $_FILES['foto'];


// maksimal 2 MB

if ($foto['size'] > 2 * 1024 * 1024) {

    die(
        "Ukuran foto maksimal 2 MB."
    );
}


// ================================
// VALIDASI EKSTENSI
// ================================

$nama_file =
    $foto['name'];

$ext =
    strtolower(
        pathinfo(
            $nama_file,
            PATHINFO_EXTENSION
        )
    );


$allowed =
    ['jpg', 'jpeg', 'png'];


if (
    !in_array(
        $ext,
        $allowed
    )
) {

    die(
        "Format foto hanya JPG, JPEG, atau PNG."
    );
}


// ================================
// BUAT NAMA FILE BARU
// ================================

$nama_foto =
    uniqid('siswa_')
    . '.'
    . $ext;


$folder =
    "uploads/";


$target =
    $folder
    . $nama_foto;


// ================================
// UPLOAD FOTO
// ================================

if (
    move_uploaded_file(
        $foto['tmp_name'],
        $target
    )
) {


    // ============================
    // SIMPAN DATABASE
    // ============================

    $sql = "
        INSERT INTO tb_siswa
        (
            nis,
            nama,
            id_jurusan,
            foto,
            alasan
        )

        VALUES
        (
            '$nis',
            '$nama',
            '$id_jurusan',
            '$nama_foto',
            '$alasan'
        )
    ";


    if (
        mysqli_query(
            $koneksi,
            $sql
        )
    ) {

        header(
            "Location: index.php"
        );

        exit();

    } else {

        // jika database gagal,
        // hapus foto yang sudah terupload

        if (
            file_exists($target)
        ) {

            unlink($target);
        }

        echo
            "Gagal menyimpan data: "
            . mysqli_error($koneksi);
    }


} else {

    echo
        "Gagal mengupload foto.";
}

?>