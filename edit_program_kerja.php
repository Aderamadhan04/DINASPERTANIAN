<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dinas_pertanian";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$daftar_kode_rekening = [
    "5.1",
    "5.1.02",
    "5.1.02.01",
    "5.1.02.01.01",
    "5.1.02.01.01.0012"
];

if (!isset($_GET['kode_rekening'])) {
    header("Location: program_kerja.php");
    exit;
}

$kode_rekening = $_GET['kode_rekening'];
$stmt = $conn->prepare("SELECT * FROM program_kerja WHERE kode_rekening = ?");
$stmt->bind_param("s", $kode_rekening);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

// Update data
if (isset($_POST['update_program'])) {
    $kode_rekening_baru = $_POST['kode_rekening'];
    $nama_program = $_POST['nama_program'];
    $uraian_kegiatan = $_POST['uraian_kegiatan'];
    $indikator_kinerja = $_POST['indikator_kinerja'];
    $anggaran = $_POST['anggaran'];

    $update = $conn->prepare("UPDATE program_kerja SET kode_rekening=?, nama_program=?, uraian_kegiatan=?, indikator_kinerja=?, anggaran=? WHERE kode_rekening=?");
    $update->bind_param("ssssss", $kode_rekening_baru, $nama_program, $uraian_kegiatan, $indikator_kinerja, $anggaran, $kode_rekening);
    $update->execute();

    header("Location: program_kerja.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Program Kerja</title>
    <style>
        body {
            font-family: Arial;
            padding: 40px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
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

        input[type=text], input[type=number], select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #6c757d;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Program Kerja</h2>
    <form method="POST">
        <div class="form-group">
            <label>Kode Rekening:</label>
            <select name="kode_rekening" required>
                <?php foreach ($daftar_kode_rekening as $kode): ?>
                    <option value="<?= $kode ?>" <?= ($kode == $data['kode_rekening']) ? 'selected' : '' ?>><?= $kode ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Nama Program:</label>
            <input type="text" name="nama_program" value="<?= htmlspecialchars($data['nama_program']) ?>" required>
        </div>
        <div class="form-group">
            <label>Uraian Kegiatan:</label>
            <input type="text" name="uraian_kegiatan" value="<?= htmlspecialchars($data['uraian_kegiatan']) ?>" required>
        </div>
        <div class="form-group">
            <label>Indikator Kinerja:</label>
            <input type="text" name="indikator_kinerja" value="<?= htmlspecialchars($data['indikator_kinerja']) ?>" required>
        </div>
        <div class="form-group">
            <label>Anggaran:</label>
            <input type="number" name="anggaran" value="<?= $data['anggaran'] ?>" required>
        </div>
        <button type="submit" name="update_program" class="btn">Simpan Perubahan</button>
        <a href="program_kerja.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

</body>
</html>