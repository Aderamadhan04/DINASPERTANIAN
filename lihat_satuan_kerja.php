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

// Ambil data satuan kerja
$query = "SELECT * FROM satuan_kerja";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Satuan Kerja</title>
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
  <h3>📋 Daftar Satuan Kerja</h3>
<?php endif; ?>

  <table>
    <tr>
      <th>Kode DPA</th>
      <th>Nama Satuan Kerja</th>
      <th>Tahun Anggaran</th>
      <th>Lokasi</th>
      <th>Pendanaan</th>
      <th>Waktu Pelaksanaan</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['kode_DPA']) ?></td>
        <td><?= htmlspecialchars($row['nama_satker']) ?></td>
        <td><?= htmlspecialchars($row['tahun_anggaran']) ?></td>
        <td><?= htmlspecialchars($row['lokasi_kegiatan']) ?></td>
        <td><?= htmlspecialchars($row['pendanaan']) ?></td>
        <td><?= htmlspecialchars($row['Waktu_pelaksanaan']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

  <?php if (!$printMode): ?>
  <a href="home_karyawan.php" class="back-link">← Kembali ke Home</a>
<?php endif; ?>

</body>
</html>
