<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dinas_pertanian";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data
if (isset($_POST['simpan_realisasi'])) {
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $output_fisik = $_POST['output_fisik'];
    $target_kinerja = $_POST['target_kinerja'];
    $capaian_kinerja = $_POST['capaian_kinerja'];

    $stmt = $conn->prepare("INSERT INTO realisasi_fisik (nama_kegiatan, output_fisik, target_kinerja, capaian_kinerja) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama_kegiatan, $output_fisik, $target_kinerja, $capaian_kinerja);
    $stmt->execute();
    $stmt->close();
    header("Location: realisasi_fisik.php");
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $conn->prepare("DELETE FROM realisasi_fisik WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: realisasi_fisik.php");
    exit;
}

// Approve data
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $stmt = $conn->prepare("UPDATE realisasi_fisik SET status_approve = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: realisasi_fisik.php");
    exit;
}

// Ambil data
$realisasi = $conn->query("SELECT * FROM realisasi_fisik ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Realisasi Fisik - Dinas Pertanian</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial;
            margin: 0;
            padding: 0;
            background: #f2f4f8;
        }
        .navbar {
            background-color: #234048;
            padding: 10px 25px;
            color: white;
            display: flex;
            justify-content: space-between;
        }
        .navbar a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }
        .navbar a:hover {
            color: #ccc;
        }
        .container {
            padding: 30px;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            margin-top: 25px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        table th {
            background: #f7f7f7;
        }
        .form-group {
            margin-bottom: 10px;
        }
        input[type=text], textarea {
            width: 100%;
            padding: 8px;
        }
        .btn {
            padding: 6px 12px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
        }
        .btn-danger { background: #dc3545; }
        .btn-add { background: #28a745; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-approve { background: #28a745; }
        .action-buttons a {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div></div>
    <div>
        <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <h2>Realisasi Fisik - Dinas Pertanian</h2>

    <!-- Form Tambah -->
    <h3>➕ Tambah Realisasi</h3>
    <form method="POST">
        <div class="form-group">
            <label>Nama Kegiatan:</label>
            <input type="text" name="nama_kegiatan" required>
        </div>
        <div class="form-group">
            <label>Output Fisik:</label>
            <input type="text" name="output_fisik" required>
        </div>
        <div class="form-group">
            <label>Target Kinerja:</label>
            <input type="text" name="target_kinerja" required>
        </div>
        <div class="form-group">
            <label>Capaian Kinerja:</label>
            <textarea name="capaian_kinerja" required></textarea>
        </div>
        <button type="submit" name="simpan_realisasi" class="btn btn-add">Simpan</button>
    </form>

    <!-- Tabel -->
    <h3>📋 Daftar Realisasi Fisik</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Kegiatan</th>
                <th>Output Fisik</th>
                <th>Target</th>
                <th>Capaian</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($realisasi->num_rows > 0): ?>
                <?php while ($row = $realisasi->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
                        <td><?= htmlspecialchars($row['output_fisik']) ?></td>
                        <td><?= htmlspecialchars($row['target_kinerja']) ?></td>
                        <td><?= htmlspecialchars($row['capaian_kinerja']) ?></td>
                        <td>
                            <?php if ($row['status_approve'] === 'approved'): ?>
                                <span style="color: green; font-weight: bold;">✔ Approved</span>
                            <?php else: ?>
                                <span style="color: gray;">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td class="action-buttons">
                            <a href="edit_realisasi_fisik.php?id=<?= $row['id'] ?>" class="btn btn-edit">✏</a>
                            <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">🗑</a>

                            <?php if ($row['status_approve'] !== 'approved'): ?>
                                <a href="?approve=<?= $row['id'] ?>" class="btn btn-approve" onclick="return confirm('Setujui data ini?')">✔ Approve</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">Belum ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
