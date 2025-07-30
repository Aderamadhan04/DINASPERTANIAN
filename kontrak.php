<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "dinas_pertanian");

// Proses tambah data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kontrak = $_POST['nama_kontrak'];
    $penyedia_barang = $_POST['penyedia_barang'];
    $nilai_kontrak = $_POST['nilai_kontrak'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $status_pelaksanaan = $_POST['status_pelaksanaan'];

    // Proses upload file PDF
    $fileName = $_FILES['bukti_kontrak']['name'];
    $fileTmp = $_FILES['bukti_kontrak']['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if ($fileExt == 'pdf') {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir);
        }
        $fileNewName = time() . "_" . basename($fileName);
        $fileDest = $targetDir . $fileNewName;
        move_uploaded_file($fileTmp, $fileDest);

        // Simpan data ke database
        $koneksi->query("INSERT INTO kontrak (nama_kontrak, penyedia_barang, nilai_kontrak, tanggal_mulai, status_pelaksanaan, bukti_kontrak, status_approve) 
                         VALUES ('$nama_kontrak', '$penyedia_barang', '$nilai_kontrak', '$tanggal_mulai', '$status_pelaksanaan', '$fileNewName', 'pending')");
        header("Location: kontrak.php");
        exit();
    } else {
        echo "<script>alert('Hanya file PDF yang diperbolehkan!');</script>";
    }
}

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Hapus file PDF terkait
    $cek = $koneksi->query("SELECT bukti_kontrak FROM kontrak WHERE tanggal_mulai = '$id'");
    $row = $cek->fetch_assoc();
    if (file_exists("uploads/" . $row['bukti_kontrak'])) {
        unlink("uploads/" . $row['bukti_kontrak']);
    }

    $koneksi->query("DELETE FROM kontrak WHERE tanggal_mulai = '$id'");
    header("Location: kontrak.php");
    exit();
}

// Proses approve
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $koneksi->query("UPDATE kontrak SET status_approve = 'approved' WHERE tanggal_mulai = '$id'");
    header("Location: kontrak.php");
    exit();
}

// Ambil data dari database
$data = $koneksi->query("SELECT * FROM kontrak");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Kontrak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f8;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #203e45;
            padding: 10px 20px;
            color: white;
            text-align: right;
        }
        .navbar a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            padding: 20px;
        }
        h2 {
            color: #111;
        }
        form input, form select {
            padding: 10px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
        }
        form button {
            padding: 10px 20px;
            background-color: green;
            border: none;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: white;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th {
            background-color: #eee;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .aksi button {
            padding: 6px 10px;
            border: none;
            color: white;
            cursor: pointer;
            margin-right: 5px;
        }
        .edit-btn {
            background-color: orange;
        }
        .hapus-btn {
            background-color: red;
        }
        .approve-btn {
            background-color: green;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> Kembali ke Dashboard</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="container">
    <h2>📄 Data Kontrak</h2>

    <h3>➕ Tambah Data</h3>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>Nama Kontrak:</label>
        <input type="text" name="nama_kontrak" required>

        <label>Penyedia Barang:</label>
        <input type="text" name="penyedia_barang" required>

        <label>Nilai Kontrak:</label>
        <input type="text" name="nilai_kontrak" required>

        <label>Tanggal Mulai:</label>
        <input type="date" name="tanggal_mulai" required>

        <label>Status Pelaksanaan:</label>
        <input type="text" name="status_pelaksanaan" required>

        <label>Bukti Kontrak (PDF):</label>
        <input type="file" name="bukti_kontrak" accept="application/pdf" required>

        <button type="submit">Simpan</button>
    </form>

    <h3>📑 Tabel Data Kontrak</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Kontrak</th>
                <th>Penyedia Barang</th>
                <th>Nilai Kontrak</th>
                <th>Tanggal Mulai</th>
                <th>Status Pelaksanaan</th>
                <th>Bukti Kontrak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $data->fetch_assoc()) : ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_kontrak']) ?></td>
                <td><?= htmlspecialchars($row['penyedia_barang']) ?></td>
                <td><?= htmlspecialchars($row['nilai_kontrak']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
                <td><?= htmlspecialchars($row['status_pelaksanaan']) ?></td>
                <td>
                    <a href="uploads/<?= htmlspecialchars($row['bukti_kontrak']) ?>" target="_blank">📎 Lihat PDF</a>
                </td>
                <td class="aksi">
                    <?php if ($row['status_approve'] != 'approved') : ?>
                        <a href="?approve=<?= $row['tanggal_mulai'] ?>" onclick="return confirm('Setujui kontrak ini?')">
                            <button class="approve-btn">✔ Approve</button>
                        </a>
                    <?php else: ?>
                        <span style="color:green;font-weight:bold;">✔ Approved</span>
                    <?php endif; ?>

                    <a href="?hapus=<?= $row['tanggal_mulai'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">
                        <button class="hapus-btn">🗑️</button>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
