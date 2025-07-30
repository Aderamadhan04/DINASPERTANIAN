<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dinas_pertanian";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data
if (isset($_POST['simpan'])) {
    $bulan = $_POST['bulan'];
    $jumlah = $_POST['jumlah_dana_ditarik'];
    $sisa = $_POST['sisa_dana'];
    $total = $_POST['total_realisasi_perbulan'];

    $stmt = $conn->prepare("INSERT INTO realisasi_keuangan (bulan, jumlah_dana_ditarik, sisa_dana, total_realisasi_perbulan, status_approve) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("sddd", $bulan, $jumlah, $sisa, $total);
    $stmt->execute();
    $stmt->close();

    header("Location: realisasi_keuangan.php");
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
    $bulan = $_GET['hapus'];
    $conn->query("DELETE FROM realisasi_keuangan WHERE bulan = '$bulan'");
    header("Location: realisasi_keuangan.php");
    exit;
}

// Approve data
if (isset($_GET['approve'])) {
    $bulan = $_GET['approve'];
    $conn->query("UPDATE realisasi_keuangan SET status_approve = 'approved' WHERE bulan = '$bulan'");
    header("Location: realisasi_keuangan.php");
    exit;
}

// Ambil data
$data = $conn->query("SELECT * FROM realisasi_keuangan ORDER BY jumlah_dana_ditarik ASC");

// Kelompokkan berdasarkan jumlah dana
$grouped_data = [
    '100.000 - 900.000' => [],
    '1.000.000 - 9.000.000' => [],
    '10.000.000 ke atas' => [],
];

while ($row = $data->fetch_assoc()) {
    $jumlah = $row['jumlah_dana_ditarik'];
    if ($jumlah >= 100000 && $jumlah <= 900000) {
        $grouped_data['100.000 - 900.000'][] = $row;
    } elseif ($jumlah >= 1000000 && $jumlah <= 9000000) {
        $grouped_data['1.000.000 - 9.000.000'][] = $row;
    } elseif ($jumlah > 9000000) {
        $grouped_data['10.000.000 ke atas'][] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Realisasi Keuangan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: Arial; background: #f2f4f8; margin: 0; padding: 0; }
        .navbar {
            background-color: #234048; color: white;
            display: flex; justify-content: space-between;
            align-items: center; padding: 10px 25px;
        }
        .navbar a { color: white; margin-left: 20px; text-decoration: none; font-weight: bold; }
        .navbar a:hover { text-decoration: underline; }
        .container { padding: 30px; }
        table {
            width: 100%; margin-top: 10px; border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px; border: 1px solid #ccc;
            text-align: center;
        }
        th { background-color: #f7f7f7; }
        .form-group { margin-bottom: 10px; }
        input[type=text], input[type=number], select {
            width: 100%; padding: 8px; box-sizing: border-box;
        }
        .btn {
            padding: 6px 12px; border-radius: 5px;
            text-decoration: none; color: white;
            font-size: 14px; margin: 2px; display: inline-block;
        }
        .btn-add { background-color: #28a745; }
        .btn-edit { background-color: #ffc107; }
        .btn-delete { background-color: #dc3545; }
        .btn-approve { background-color: #28a745; }
        .badge {
            font-weight: bold; padding: 3px 6px;
            border-radius: 4px; display: inline-block;
        }
        .badge-approved { color: green; }
        .badge-pending { color: gray; }
        h3.group-title {
            background-color: #ddd;
            padding: 10px;
            margin-top: 30px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div></div>
    <div>
        <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="dashboard.php"><i class="fas fa-chart-line"></i> Kembali Ke Dashboard</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <h2>Realisasi Keuangan</h2>

    <h3>➕ Tambah Data</h3>
    <form method="POST">
        <div class="form-group">
            <label>Bulan:</label>
            <input type="text" name="bulan" placeholder="Contoh: Januari" required>
        </div>
        <div class="form-group">
            <label>Jumlah Dana Ditarik:</label>
            <input type="number" name="jumlah_dana_ditarik" step="0.01" required>
        </div>
        <div class="form-group">
            <label>Sisa Dana:</label>
            <input type="number" name="sisa_dana" required>
        </div>
        <div class="form-group">
            <label>Total Realisasi Per Bulan:</label>
            <input type="number" name="total_realisasi_perbulan" step="0.01" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-add">Simpan</button>
    </form>

    <h3>📋 Data Realisasi Keuangan</h3>

    <?php foreach ($grouped_data as $label => $items): ?>
        <h3 class="group-title"><?= $label ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Jumlah Dana Ditarik</th>
                    <th>Sisa Dana</th>
                    <th>Total Realisasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['bulan']) ?></td>
                        <td>Rp <?= number_format($row['jumlah_dana_ditarik'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($row['sisa_dana'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($row['total_realisasi_perbulan'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($row['status_approve'] === 'approved'): ?>
                                <span class="badge badge-approved">✔ Approved</span>
                            <?php else: ?>
                                <span class="badge badge-pending">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_realisasi_keuangan.php?bulan=<?= urlencode($row['bulan']) ?>" class="btn btn-edit">✏</a>
                            <a href="?hapus=<?= urlencode($row['bulan']) ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus?')">🗑</a>
                            <?php if ($row['status_approve'] !== 'approved'): ?>
                                <a href="?approve=<?= urlencode($row['bulan']) ?>" class="btn btn-approve" onclick="return confirm('Setujui realisasi ini?')">✔ Approve</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">Tidak ada data pada kelompok ini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>

</body>
</html>
