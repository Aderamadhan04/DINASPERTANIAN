<?php
session_start();

// Pastikan hanya karyawan yang bisa akses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Home Karyawan - Dinas Pertanian</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f0f8ff;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #2c3e50;
      padding: 15px 30px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar h1 {
      margin: 0;
      font-size: 20px;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-weight: bold;
    }

    .container {
      padding: 40px;
    }

    h2 {
      color: #2c3e50;
    }

    ul {
      list-style-type: none;
      padding-left: 0;
    }

    ul li {
      margin: 12px 0;
    }

    ul li a {
      text-decoration: none;
      color: #2980b9;
      font-size: 16px;
    }

    ul li a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <h1>Dashboard Karyawan</h1>
    <div>
      <span>Halo, <?= htmlspecialchars($_SESSION['username']) ?>!</span>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <h2>Menu Akses Karyawan</h2>
    <ul>
      <li><a href="lihat_program_kerja.php">📁 Lihat Program Kerja</a></li>
      <li><a href="lihat_satuan_kerja.php">🏢 Lihat Satuan Kerja</a></li>
      <li><a href="lihat_realisasi_fisik.php">📊 Lihat Realisasi Fisik</a></li>
      <li><a href="lihat_realisasi_keuangan.php">💰 Lihat Realisasi Keuangan</a></li>
      <li><a href="lihat_revisi.php">📝 Lihat Revisi</a></li>
      <li><a href="lihat_kontrak.php">📄 Unduh File Kontrak</a></li>
      <a href="cetak_semua_laporan.php" class="btn btn-success">📄 Unduh Semua Data PDF</a>

    </ul>
  </div>

</body>
</html>
