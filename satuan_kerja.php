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
if (isset($_POST['simpan'])) {
    $kode_DPA = $_POST['kode_DPA'];
    $nama_satker = $_POST['nama_satker'];
    $tahun_anggaran = $_POST['tahun_anggaran'];
    $lokasi_kegiatan = $_POST['lokasi_kegiatan'];
    $pendanaan = $_POST['pendanaan'];
    $Waktu_pelaksanaan = $_POST['Waktu_pelaksanaan'];

    $stmt = $conn->prepare("INSERT INTO satuan_kerja (kode_DPA, nama_satker, tahun_anggaran, lokasi_kegiatan, pendanaan, Waktu_pelaksanaan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdis", $kode_DPA, $nama_satker, $tahun_anggaran, $lokasi_kegiatan, $pendanaan, $Waktu_pelaksanaan);
    $stmt->execute();
    $stmt->close();

    header("Location: satuan_kerja.php");
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
    $kode_DPA = $_GET['hapus'];
    $conn->query("DELETE FROM satuan_kerja WHERE kode_DPA = '$kode_DPA'");
    header("Location: satuan_kerja.php");
    exit;
}

// Approve
if (isset($_GET['approve'])) {
    $kode_DPA = $_GET['approve'];
    $conn->query("UPDATE satuan_kerja SET status_approve = 'approved' WHERE kode_DPA = '$kode_DPA'");
    header("Location: satuan_kerja.php");
    exit;
}

$data = $conn->query("SELECT * FROM satuan_kerja ORDER BY kode_DPA DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Satuan Kerja - Dinas Pertanian</title>
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
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 25px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            transition: 0.3s;
        }

        .navbar a:hover {
            text-decoration: underline;
            color: #ccc;
        }

        .container {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: white;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        table th {
            background-color: #f7f7f7;
        }

        .form-group {
            margin-bottom: 10px;
        }

        input[type=text], input[type=number], input[type=date], select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            margin-right: 5px;
            display: inline-block;
        }

        .btn-add {
            background-color: #28a745;
        }

        .btn-edit {
            background-color: #ffc107;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-approve {
            background-color: #28a745;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div></div>
    <div>
        <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="dashboard.php"><i class="fas fa-chart-line"></i> Kembali ke Dashboard</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <h2>Satuan Kerja - Dinas Pertanian</h2>

    <h3>➕ Tambah Data</h3>
    <form method="POST">
        <div class="form-group">
            <label>Kode DPA:</label>
            <input type="text" name="kode_DPA" required>
        </div>
        <div class="form-group">
            <label>Nama Satuan Kerja:</label>
            <select name="nama_satker" required>
                <option value="">-- Pilih Satuan Kerja --</option>
                <option value="Tanaman Pangan">Tanaman Pangan</option>
                <option value="Hortikultura">Hortikultura</option>
                <option value="Perkebunan">Perkebunan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tahun Anggaran:</label>
            <input type="date" name="tahun_anggaran" required>
        </div>
        <div class="form-group">
            <label>Lokasi Kegiatan:</label>
            <input type="text" name="lokasi_kegiatan" required>
        </div>
        <div class="form-group">
            <label>Pendanaan:</label>
            <input type="number" name="pendanaan" required>
        </div>
        <div class="form-group">
            <label>Waktu Pelaksanaan:</label>
            <input type="date" name="Waktu_pelaksanaan" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-add">Simpan</button>
    </form>

    <h3>📋 Daftar Satuan Kerja</h3>
    <table>
        <thead>
            <tr>
                <th>Kode DPA</th>
                <th>Nama Satuan Kerja</th>
                <th>Tahun Anggaran</th>
                <th>Lokasi</th>
                <th>Pendanaan</th>
                <th>Waktu Pelaksanaan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($data->num_rows > 0): ?>
                <?php while ($row = $data->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['kode_DPA'] ?></td>
                    <td><?= htmlspecialchars($row['nama_satker']) ?></td>
                    <td><?= $row['tahun_anggaran'] ?></td>
                    <td><?= htmlspecialchars($row['lokasi_kegiatan']) ?></td>
                    <td>Rp <?= number_format($row['pendanaan'], 0, ',', '.') ?></td>
                    <td><?= $row['Waktu_pelaksanaan'] ?></td>
                    <td>
                    <?php if ($row['status_approve'] === 'approved'): ?>
                                <span class="approved-badge">✔ Approved</span>
                            <?php else: ?>
                                <span class="pending-badge">Pending</span>
                            <?php endif; ?>
                    <td>
                        <a href="edit_satuan_kerja.php?kode_DPA=<?= $row['kode_DPA'] ?>" class="btn btn-edit">✏</a>
                        <a href="?hapus=<?= $row['kode_DPA'] ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus?')">🗑</a>
                        <?php if ($row['status_approve'] !== 'approved'): ?>
                            <a href="?approve=<?= $row['kode_DPA'] ?>" class="btn btn-approve">✔ Approve</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">Belum ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
