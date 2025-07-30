<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dinas_pertanian";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data berdasarkan kode_DPA
if (!isset($_GET['kode_DPA'])) {
    header("Location: satuan_kerja.php");
    exit;
}

$kode_DPA = $_GET['kode_DPA'];
$query = $conn->prepare("SELECT * FROM satuan_kerja WHERE kode_DPA = ?");
$query->bind_param("s", $kode_DPA);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo "Data tidak ditemukan.";
    exit;
}

$data = $result->fetch_assoc();

// Proses update
if (isset($_POST['update'])) {
    $nama_satker = $_POST['nama_satker'];
    $tahun_anggaran = $_POST['tahun_anggaran'];
    $lokasi_kegiatan = $_POST['lokasi_kegiatan'];
    $pendanaan = $_POST['pendanaan'];
    $Waktu_pelaksanaan = $_POST['Waktu_pelaksanaan'];

    $update = $conn->prepare("UPDATE satuan_kerja SET nama_satker=?, tahun_anggaran=?, lokasi_kegiatan=?, pendanaan=?, Waktu_pelaksanaan=? WHERE kode_DPA=?");
    $update->bind_param("sssiss", $nama_satker, $tahun_anggaran, $lokasi_kegiatan, $pendanaan, $Waktu_pelaksanaan, $kode_DPA);
    $update->execute();

    header("Location: satuan_kerja.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Satuan Kerja</title>
    <style>
        body {
            font-family: Arial;
            background: #f0f2f5;
            padding: 40px;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            width: 500px;
            margin: auto;
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

        input[type="text"], input[type="date"], input[type="number"] {
            width: 100%;
            padding: 8px;
        }

        .btn {
            background: #007bff;
            color: white;
            padding: 8px 14px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
        }

        .btn-cancel {
            background: #6c757d;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Satuan Kerja</h2>
    <form method="POST">
        <div class="form-group">
            <label>Kode DPA:</label>
            <input type="text" name="kode_DPA" value="<?= htmlspecialchars($data['kode_DPA']) ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nama Satuan Kerja:</label>
            <input type="text" name="nama_satker" value="<?= htmlspecialchars($data['nama_satker']) ?>" required>
        </div>
        <div class="form-group">
            <label>Tahun Anggaran:</label>
            <input type="date" name="tahun_anggaran" value="<?= $data['tahun_anggaran'] ?>" required>
        </div>
        <div class="form-group">
            <label>Lokasi Kegiatan:</label>
            <input type="text" name="lokasi_kegiatan" value="<?= htmlspecialchars($data['lokasi_kegiatan']) ?>" required>
        </div>
        <div class="form-group">
            <label>Pendanaan:</label>
            <input type="number" name="pendanaan" value="<?= $data['pendanaan'] ?>" required>
        </div>
        <div class="form-group">
            <label>Waktu Pelaksanaan:</label>
            <input type="date" name="Waktu_pelaksanaan" value="<?= $data['Waktu_pelaksanaan'] ?>" required>
        </div>
        <button type="submit" name="update" class="btn">Simpan Perubahan</button>
        <a href="satuan_kerja.php" class="btn btn-cancel">Kembali</a>
    </form>
</div>

</body>
</html>