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

// Ambil data kontrak
$query = "SELECT * FROM kontrak";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Kontrak</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fc;
      padding: 30px;
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
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    a.pdf-link {
      color: purple;
      text-decoration: underline;
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
  <h3>📋 Daftar kontrak</h3>
<?php endif; ?>

  <table>
    <tr>
      <th>Nama Kontrak</th>
      <th>Penyedia Barang</th>
      <th>Nilai Kontrak</th>
      <th>Tanggal Mulai</th>
      <th>Status Pelaksanaan</th>
      <th>Bukti Kontrak</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['nama_kontrak']) ?></td>
        <td><?= htmlspecialchars($row['penyedia_barang']) ?></td>
        <td><?= htmlspecialchars($row['nilai_kontrak']) ?></td>
        <td><?= htmlspecialchars($row['tanggal_mulai']) ?></td>
        <td><?= htmlspecialchars($row['status_pelaksanaan']) ?></td>
        <td>
          <?php if (!empty($row['bukti_kontrak'])) : ?>
            <a href="uploads/<?= htmlspecialchars($row['bukti_kontrak']) ?>" class="pdf-link" target="_blank">
              📎 Lihat PDF
            </a>
          <?php else : ?>
            Tidak ada file
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>

  <?php if (!$printMode): ?>
  <a href="home_karyawan.php" class="back-link">← Kembali ke Home</a>
<?php endif; ?>

</body>
</html>
