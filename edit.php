<?php

include 'koneksi.php';

$id = intval($_GET['id'] ?? 0);

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM tb_siswa
     WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);

if (!$data) {

    header("Location: index.php");

    exit();
}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Edit Data Siswa</title>

<style>

body {

    margin: 0;

    font-family: Arial, sans-serif;

    background: #f4f7fb;
}

.container {

    max-width: 700px;

    margin: 40px auto;

    padding: 25px;

    background: white;

    border-radius: 12px;

    box-shadow:
        0 3px 15px rgba(0,0,0,.08);
}

h2 {

    margin-top: 0;

    color: #222;
}

.form-group {

    margin-bottom: 18px;
}

label {

    display: block;

    margin-bottom: 7px;

    font-weight: bold;
}

input,
select,
textarea {

    width: 100%;

    padding: 11px;

    border: 1px solid #ddd;

    border-radius: 7px;

    box-sizing: border-box;
}

input:focus,
select:focus,
textarea:focus {

    outline: none;

    border-color: #007bff;
}

.current-photo {

    width: 120px;

    height: 145px;

    object-fit: cover;

    border-radius: 8px;

    border: 2px solid #ddd;

    margin-top: 10px;
}

.btn {

    padding: 10px 16px;

    border-radius: 7px;

    border: none;

    text-decoration: none;

    display: inline-block;

    cursor: pointer;
}

.btn-primary {

    background: #007bff;

    color: white;
}

.btn-secondary {

    background: #6c757d;

    color: white;
}

small {

    color: #777;
}

</style>

</head>

<body>

<div class="container">

<h2>
    Edit Data Siswa
</h2>

<form
    action="update.php"
    method="POST"
    enctype="multipart/form-data"
>


<input
    type="hidden"
    name="id"
    value="<?php
        echo $data['id'];
    ?>"
>


<div class="form-group">

    <label>
        NIS
    </label>

    <input
        type="text"
        name="nis"
        maxlength="10"
        value="<?php
            echo htmlspecialchars(
                $data['nis']
            );
        ?>"
        required
    >

</div>


<div class="form-group">

    <label>
        Nama Lengkap
    </label>

    <input
        type="text"
        name="nama"
        value="<?php
            echo htmlspecialchars(
                $data['nama']
            );
        ?>"
        required
    >

</div>


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

        $jurusan =
            mysqli_query(
                $koneksi,
                "SELECT * FROM tb_jurusan
                 ORDER BY nama_jurusan ASC"
            );

        while (
            $j =
            mysqli_fetch_assoc(
                $jurusan
            )
        ):

        ?>

        <option
            value="<?php
                echo $j['id_jurusan'];
            ?>"
            <?php

            if (
                $j['id_jurusan']
                ==
                $data['id_jurusan']
            ) {

                echo 'selected';
            }

            ?>
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


<div class="form-group">

    <label>
        Pasfoto Saat Ini
    </label>

    <?php if (
        !empty($data['foto'])
    ): ?>

        <br>

        <img
            src="uploads/<?php
                echo htmlspecialchars(
                    $data['foto']
                );
            ?>"
            class="current-photo"
        >

    <?php endif; ?>

</div>


<div class="form-group">

    <label>
        Ganti Pasfoto
    </label>

    <input
        type="file"
        name="foto"
        accept=".jpg,.jpeg,.png"
    >

    <small>
        Kosongkan jika tidak ingin mengganti foto.
        Maksimal 2 MB.
    </small>

</div>


<div class="form-group">

    <label>
        Alasan Masuk
    </label>

    <textarea
        name="alasan"
        rows="5"
        required
    ><?php

        echo htmlspecialchars(
            $data['alasan']
        );

    ?></textarea>

</div>


<button
    type="submit"
    class="btn btn-primary"
>
    Simpan Perubahan
</button>


<a
    href="index.php"
    class="btn btn-secondary"
>
    Batal
</a>


</form>

</div>

</body>

</html>