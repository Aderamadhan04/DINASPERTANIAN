<?php
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'karyawan')) {
  header("Location: login.php");
  exit();
}

$conn = new mysqli("localhost", "root", "", "dinas_pertanian");
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

$totalProgram = $conn->query("SELECT COUNT(*) FROM program_kerja")->fetch_row()[0];
$totalSatker = $conn->query("SELECT COUNT(*) FROM satuan_kerja")->fetch_row()[0];
$totalFisik = $conn->query("SELECT COUNT(*) FROM realisasi_fisik")->fetch_row()[0];
$totalKeuangan = $conn->query("SELECT COUNT(*) FROM realisasi_keuangan")->fetch_row()[0];
$totalRevisi = $conn->query("SELECT COUNT(*) FROM revisi")->fetch_row()[0];
$totalKontrak = count(glob("uploads/*.pdf"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Utama - Dinas Pertanian</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f4f6f8;
    }

    .navbar {
      background: #264653;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .navbar-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .navbar-left img {
      height: 36px;
      width: auto;
      border-radius: 4px;
    }

    .navbar-left span {
      color: white;
      font-weight: bold;
      font-size: 20px;
    }

    .navbar-right {
      display: flex;
      gap: 20px;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .navbar a:hover {
      color: #2a9d8f;
    }

    h1 {
      text-align: center;
      margin: 30px 0 10px;
      color: #264653;
    }

    .dashboard {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      padding: 20px 40px;
    }

    .dashboard a.card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      text-align: center;
      text-decoration: none;
      color: inherit;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dashboard a.card:hover {
      transform: scale(1.03);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .card h3 {
      margin: 10px 0;
      color: #2a9d8f;
    }

    .card i {
      font-size: 35px;
      color: #264653;
    }

    .card span {
      font-size: 24px;
      font-weight: bold;
      display: block;
      margin-top: 5px;
    }

    .print-laporan {
      text-align: center;
      margin: 40px 0 60px;
    }

    .print-laporan a {
      background-color: #2a9d8f;
      color: white;
      padding: 12px 22px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: background-color 0.3s ease;
    }

    .print-laporan a:hover {
      background-color: #21867a;
    }

    .print-laporan i {
      margin-right: 6px;
    }

    @media (max-width: 992px) {
      .dashboard {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 600px) {
      .dashboard {
        grid-template-columns: 1fr;
      }

      .navbar {
        flex-direction: column;
        align-items: flex-start;
      }

      .navbar-right {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        margin-top: 10px;
      }
    }
  </style>
</head>
<body>

<div class="navbar">
  <div class="navbar-left">
    <img src="logo.jpg" alt="Logo Dinas">
    <span>Dinas Pertanian</span>
  </div>
  <div class="navbar-right">
    <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
    <a href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>
</div>

<h1>📊 Dashboard Utama - Dinas Pertanian</h1>

<div class="dashboard">
  <a href="program_kerja.php" class="card">
    <i class="fas fa-clipboard-list"></i>
    <h3>Program Kerja</h3>
    <span><?= $totalProgram ?></span>
  </a>
  <a href="satuan_kerja.php" class="card">
    <i class="fas fa-users-cog"></i>
    <h3>Satuan Kerja</h3>
    <span><?= $totalSatker ?></span>
  </a>
  <a href="realisasi_fisik.php" class="card">
    <i class="fas fa-hammer"></i>
    <h3>Realisasi Fisik</h3>
    <span><?= $totalFisik ?></span>
  </a>
  <a href="realisasi_keuangan.php" class="card">
    <i class="fas fa-coins"></i>
    <h3>Realisasi Keuangan</h3>
    <span><?= $totalKeuangan ?></span>
  </a>
  <a href="revisi.php" class="card">
    <i class="fas fa-edit"></i>
    <h3>Revisi</h3>
    <span><?= $totalRevisi ?></span>
  </a>
  <a href="kontrak.php" class="card">
    <i class="fas fa-file-pdf"></i>
    <h3>File Kontrak</h3>
    <span><?= $totalKontrak ?></span>
  </a>
</div>

<div class="print-laporan">
  <a href="cetak_semua_laporan.php" target="_blank">
    <i class="fas fa-print"></i> Cetak Semua Laporan
  </a>
</div>

</body>
</html>
