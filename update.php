<?php

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {

    header("Location: index.php");

    exit();
}


$id = intval(
    $_POST['id']
);


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


// ==================================
// AMBIL FOTO LAMA
// ==================================

$get = mysqli_query(
    $koneksi,
    "SELECT foto
     FROM tb_siswa
     WHERE id='$id'"
);

$data_lama =
    mysqli_fetch_assoc($get);


$foto_lama =
    $data_lama['foto'];


// ==================================
// CEK APAKAH ADA FOTO BARU
// ==================================

if (
    isset($_FILES['foto'])
    &&
    $_FILES['foto']['error'] == 0
) {

    $foto =
        $_FILES['foto'];


    // maksimal 2 MB

    if (
        $foto['size']
        >
        2 * 1024 * 1024
    ) {

        die(
            "Ukuran foto maksimal 2 MB."
        );
    }


    $ext =
        strtolower(
            pathinfo(
                $foto['name'],
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
            "Format foto harus JPG, JPEG, atau PNG."
        );
    }


    $nama_foto =
        uniqid('siswa_')
        . '.'
        . $ext;


    $target =
        "uploads/"
        . $nama_foto;


    if (
        move_uploaded_file(
            $foto['tmp_name'],
            $target
        )
    ) {


        // update dengan foto baru

        $sql = "
            UPDATE tb_siswa SET

                nis='$nis',

                nama='$nama',

                id_jurusan='$id_jurusan',

                foto='$nama_foto',

                alasan='$alasan'

            WHERE id='$id'
        ";


        if (
            mysqli_query(
                $koneksi,
                $sql
            )
        ) {

            // hapus foto lama

            if (
                !empty($foto_lama)
                &&
                file_exists(
                    "uploads/"
                    . $foto_lama
                )
            ) {

                unlink(
                    "uploads/"
                    . $foto_lama
                );
            }


            header(
                "Location: index.php"
            );

            exit();

        } else {

            if (
                file_exists($target)
            ) {

                unlink($target);
            }

            echo
                "Gagal update: "
                . mysqli_error($koneksi);
        }


    } else {

        die(
            "Gagal upload foto baru."
        );
    }


} else {


    // ==================================
    // UPDATE TANPA GANTI FOTO
    // ==================================

    $sql = "
        UPDATE tb_siswa SET

            nis='$nis',

            nama='$nama',

            id_jurusan='$id_jurusan',

            alasan='$alasan'

        WHERE id='$id'
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

        echo
            "Gagal update: "
            . mysqli_error($koneksi);
    }
}

?>