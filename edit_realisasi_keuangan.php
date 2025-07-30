<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "dinas_pertanian");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil nilai bulan dari GET (saat pertama kali membuka form) atau POST (saat submit)
$bulan = $_SERVER["REQUEST_METHOD"] === "POST" ? ($_POST['bulan_lama'] ?? null) : ($_GET['bulan'] ?? null);
if (!$bulan) {
    die("Bulan tidak ditemukan.");
}

// Ambil data realisasi dari database
$stmt = $conn->prepare("SELECT * FROM realisasi_keuangan WHERE bulan = ?");
$stmt->bind_param("s", $bulan);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    die("Data tidak ditemukan.");
}

// Proses update jika form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bulan_baru = $_POST['bulan']; // bulan yang ingin disimpan
    $jumlah_dana_ditarik = $_POST['jumlah_dana_ditarik'];
    $sisa_dana = $_POST['sisa_dana'];
    $total_realisasi_perbulan = $_POST['total_realisasi_perbulan'];

    $update = $conn->prepare("UPDATE realisasi_keuangan SET bulan=?, jumlah_dana_ditarik=?, sisa_dana=?, total_realisasi_perbulan=? WHERE bulan=?");
    $update->bind_param("sddss", $bulan_baru, $jumlah_dana_ditarik, $sisa_dana, $total_realisasi_perbulan, $bulan);
    $update->execute();
    $update->close();

    echo "<script>alert('Data berhasil diperbarui'); window.location.href='realisasi_keuangan.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Realisasi Keuangan</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 40px;
        }

        .container {
            background: #fff;
            padding: 30px 35px;
            border-radius: 8px;
            width: 500px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn {
            background: #007bff;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn-cancel {
            background: #6c757d;
            margin-left: 10px;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #555;
        }

        .back-link:hover {
            color: #000;
        }

        .back-link i {
            margin-right: 6px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Realisasi Keuangan</h2>
    <form method="POST">
        <!-- Hidden input untuk menyimpan bulan lama -->
        <input type="hidden" name="bulan_lama" value="<?= htmlspecialchars($bulan) ?>">

        <div class="form-group">
            <label for="bulan">Bulan</label>
            <input type="text" id="bulan" name="bulan" value="<?= htmlspecialchars($data['bulan']) ?>" required>
        </div>

        <div class="form-group">
            <label for="jumlah_dana_ditarik">Jumlah Dana Ditarik</label>
            <input type="number" step="0.01" id="jumlah_dana_ditarik" name="jumlah_dana_ditarik" value="<?= $data['jumlah_dana_ditarik'] ?>" required>
        </div>

        <div class="form-group">
            <label for="sisa_dana">Sisa Dana</label>
            <input type="number" id="sisa_dana" name="sisa_dana" value="<?= $data['sisa_dana'] ?>" required>
        </div>

        <div class="form-group">
            <label for="total_realisasi_perbulan">Total Realisasi Perbulan</label>
            <input type="number" step="0.01" id="total_realisasi_perbulan" name="total_realisasi_perbulan" value="<?= $data['total_realisasi_perbulan'] ?>" required>
        </div>

        <button type="submit" class="btn">Simpan Perubahan</button>
        <a href="realisasi_keuangan.php" class="btn btn-cancel">Kembali</a>
    </form>
</div>

</body>
</html>