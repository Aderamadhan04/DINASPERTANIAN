<?php

$koneksi = new mysqli("localhost", "root", "", "dinas_pertanian");



// Cek parameter id

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    die("Parameter tidak valid.");

}



$id = intval($_GET['id']);



// Ambil data berdasarkan ID

$stmt = $koneksi->prepare("SELECT * FROM realisasi_fisik WHERE id = ?");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    die("Data tidak ditemukan.");

}

$data = $result->fetch_assoc();



// Proses update

if (isset($_POST['update'])) {

    $nama_kegiatan = $_POST['nama_kegiatan'];

    $output_fisik = $_POST['output_fisik'];

    $target_kinerja = $_POST['target_kinerja'];

    $capaian_kinerja = $_POST['capaian_kinerja'];



    $stmt = $koneksi->prepare("UPDATE realisasi_fisik SET nama_kegiatan=?, output_fisik=?, target_kinerja=?, capaian_kinerja=? WHERE id=?");

    $stmt->bind_param("ssssi", $nama_kegiatan, $output_fisik, $target_kinerja, $capaian_kinerja, $id);

    $stmt->execute();



    header("Location: realisasi_fisik.php");

    exit;

}

?>



<!DOCTYPE html>

<html>

<head>

    <title>Edit Realisasi Fisik</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>

        body {

            font-family: Arial;

            background: #f0f2f5;

            padding: 40px;

            margin: 0;

        }



        .navbar {

            background-color: #234048;

            color: white;

            padding: 10px 25px;

            display: flex;

            justify-content: space-between;

        }



        .navbar a {

            color: white;

            text-decoration: none;

            margin-left: 20px;

            font-weight: bold;

        }



        .container {

            background: white;

            padding: 25px;

            border-radius: 8px;

            width: 500px;

            margin: auto;

            margin-top: 30px;

        }



        h2 {

            text-align: center;

        }



        .form-group {

            margin-bottom: 12px;

        }



        label {

            font-weight: bold;

        }



        input[type="text"],

        textarea {

            width: 100%;

            padding: 8px;

        }



        textarea {

            resize: vertical;

        }



        .btn {

            background: #007bff;

            color: white;

            padding: 8px 14px;

            text-decoration: none;

            border: none;

            border-radius: 5px;

            cursor: pointer;

        }



        .btn-cancel {

            background: #6c757d;

            margin-left: 10px;

        }

    </style>

</head>

<body>

<!-- Form -->

<div class="container">

    <h2>Edit Realisasi Fisik</h2>

    <form method="POST">

        <div class="form-group">

            <label>Nama Kegiatan:</label>

            <input type="text" name="nama_kegiatan" value="<?= htmlspecialchars($data['nama_kegiatan']) ?>" required>

        </div>

        <div class="form-group">

            <label>Output Fisik:</label>

            <input type="text" name="output_fisik" value="<?= htmlspecialchars($data['output_fisik']) ?>" required>

        </div>

        <div class="form-group">

            <label>Target Kinerja:</label>

            <input type="text" name="target_kinerja" value="<?= htmlspecialchars($data['target_kinerja']) ?>" required>

        </div>

        <div class="form-group">

            <label>Capaian Kinerja:</label>

            <textarea name="capaian_kinerja" rows="4" required><?= htmlspecialchars($data['capaian_kinerja']) ?></textarea>

        </div>

        <button type="submit" name="update" class="btn">Simpan Perubahan</button>

        <a href="realisasi_fisik.php" class="btn btn-cancel">Kembali</a>

    </form>

</div>



</body>

</html>