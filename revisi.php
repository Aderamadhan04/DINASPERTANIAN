<?php
$conn = new mysqli("localhost", "root", "", "dinas_pertanian");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['tambah'])) {
    $tanggal_revisi = $_POST['tanggal_revisi'];
    $uraian_perubahan = $_POST['uraian_perubahan'];
    $nilai_setelah_revisi = $_POST['nilai_setelah_revisi'];

    $stmt = $conn->prepare("INSERT INTO revisi (tanggal_revisi, uraian_perubahan, nilai_setelah_revisi) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $tanggal_revisi, $uraian_perubahan, $nilai_setelah_revisi);
    $stmt->execute();
    $stmt->close();

    header("Location: revisi.php");
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
    $tanggal = $_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM revisi WHERE tanggal_revisi = ?");
    $stmt->bind_param("s", $tanggal);
    $stmt->execute();
    $stmt->close();

    header("Location: revisi.php");
    exit;
}

$result = $conn->query("SELECT * FROM revisi ORDER BY tanggal_revisi DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Revisi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f1f3f6;
        }

        .top-navbar {
            background-color: #223e44;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 25px;
        }

        .top-navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .top-navbar a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        form {
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
        }

        .aksi-btn {
            display: flex;
            gap: 5px;
        }

        .btn-hapus {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-hapus:hover {
            background-color: #c82333;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="top-navbar">
    <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> Kembali Ke Dashboard</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="container">
    <h2>Revisi</h2>

    <div class="section-title">
        <h3>➕ Tambah Data</h3>
    </div>

    <form method="POST">
        <div class="form-group">
            <label for="tanggal_revisi">Tanggal Revisi</label>
            <input type="date" name="tanggal_revisi" required>
        </div>
        <div class="form-group">
            <label for="uraian_perubahan">Uraian Perubahan</label>
            <textarea name="uraian_perubahan" rows="2" required></textarea>
        </div>
        <div class="form-group">
            <label for="nilai_setelah_revisi">Nilai Setelah Revisi</label>
            <input type="number" name="nilai_setelah_revisi" required>
        </div>
        <button type="submit" name="tambah">Simpan</button>
    </form>

    <div class="section-title">
        <h3>📋 Data Revisi</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal Revisi</th>
                <th>Uraian Perubahan</th>
                <th>Nilai Setelah Revisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['tanggal_revisi']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['uraian_perubahan'])) ?></td>
                    <td><?= number_format($row['nilai_setelah_revisi'], 0, ',', '.'); ?></td>
                    <td class="aksi-btn">
                        <form method="GET" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            <input type="hidden" name="hapus" value="<?= htmlspecialchars($row['tanggal_revisi']) ?>">
                            <button class="btn-hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>