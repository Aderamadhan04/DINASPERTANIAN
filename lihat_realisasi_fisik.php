<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Batasi akses hanya untuk role karyawan
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'karyawan')) {
    header("Location: login.php");
    exit();
}


$printMode = basename($_SERVER['PHP_SELF']) === 'cetak_semua_laporan.php';

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "dinas_pertanian");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data realisasi fisik
$query = "SELECT * FROM realisasi_fisik";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Realisasi Fisik</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background-color: #f8f9fc;
    }

    h2 {
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #fff;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #f1f1f1;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .back-link {
      margin-top: 20px;
      display: inline-block;
      text-decoration: none;
      color: #007bff;
    }

    .icon {
      width: 20px;
      vertical-align: middle;
      margin-right: 6px;
    }
  </style>
</head>
<body>

  <?php if (!$printMode): ?>
  <h3>📋 Daftar Realisasi fisik</h3>
<?php endif; ?>


  <table>
    <tr>
      <th>Nama Kegiatan</th>
      <th>Output Fisik</th>
      <th>Target</th>
      <th>Capaian</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
        <td><?= htmlspecialchars($row['output_fisik']) ?></td>
        <td><?= htmlspecialchars($row['target_kinerja']) ?></td>
        <td><?= htmlspecialchars($row['capaian_kinerja']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

  <?php if (!$printMode): ?>
  <a href="home_karyawan.php" class="back-link">← Kembali ke Home</a>
<?php endif; ?>
</body>
</html>
