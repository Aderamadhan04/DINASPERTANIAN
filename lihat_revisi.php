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

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "dinas_pertanian");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data revisi
$query = "SELECT * FROM revisi";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Revisi</title>
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
      <th>Tanggal Revisi</th>
      <th>Uraian Perubahan</th>
      <th>Nilai Setelah Revisi</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['tanggal_revisi']) ?></td>
        <td><?= htmlspecialchars($row['uraian_perubahan']) ?></td>
        <td><?= htmlspecialchars($row['nilai_setelah_revisi']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

  <?php if (!$printMode): ?>
  <a href="home_karyawan.php" class="back-link">← Kembali ke Home</a>
<?php endif; ?>

</body>
</html>
