<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda - Dinas Pertanian</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(180deg, #1d1d1f 0%, #2f2f35 50%, #3e3c3f 100%);
      color: #333;
    }

    .navbar {
      background: #264653;
      color: white;
      padding: 16px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
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

    .navbar-right a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .navbar-right a:hover {
      color: #2a9d8f;
    }

    .hero {
      height: 100vh;
      background: url('Gambar.png') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      text-align: center;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.65);
      backdrop-filter: blur(3px) brightness(0.8);
    }

    .hero-content {
      position: relative;
      z-index: 2;
      color: white;
      max-width: 800px;
      padding: 20px;
      animation: fadeIn 1.5s ease;
      text-shadow: 0px 3px 8px rgba(0,0,0,0.5);
    }

    .hero-content h1 {
      font-size: 40px;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .hero-content p {
      font-size: 18px;
      line-height: 1.7;
      opacity: 0.9;
    }

    .content-wrapper {
      background: transparent;
      padding: 60px 20px;
    }

    .content-section {
      max-width: 1000px;
      margin: 0 auto 60px;
      background: #fff;
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      transition: all 0.3s ease-in-out;
    }

    .content-section:hover {
      box-shadow: 0 14px 35px rgba(0,0,0,0.12);
    }

    .content-section h2 {
      font-size: 28px;
      margin-bottom: 16px;
      color: #0d3b66;
      border-left: 5px solid #00c2cb;
      padding-left: 12px;
      font-weight: 600;
    }

    .content-section p {
      margin-bottom: 18px;
      font-size: 17px;
      color: #444;
      line-height: 1.9;
      text-align: justify;
    }

    .content-section img {
      max-width: 100%;
      border-radius: 14px;
      margin-top: 30px;
      box-shadow: 0 8px 22px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .content-section img:hover {
      transform: scale(1.03);
    }

    .footer {
      text-align: center;
      font-size: 14px;
      color: #ccc;
      padding: 25px 10px;
      background: #1a1a1a;
      border-top: 1px solid #333;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .navbar {
        flex-direction: column;
        align-items: flex-start;
        padding: 16px 20px;
      }

      .navbar-right {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }

      .hero-content h1 {
        font-size: 28px;
      }

      .hero-content p {
        font-size: 16px;
      }

      .content-section {
        margin: 40px 20px;
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

<section class="hero">
  <div class="overlay"></div>
  <div class="hero-content">
    <h1>Selamat Datang di Sistem Informasi Dinas Pertanian</h1>
    <p>
      Aplikasi berbasis website untuk pengolahan data Divisi Keuangan Dinas Pertanian Tanaman Pangan dan Hortikultura Provinsi Sumatera Selatan.
    </p>
  </div>
</section>

<div class="content-wrapper">
  <div class="content-section">
    <h2><i class="fas fa-info-circle" style="color:#00c2cb;"></i> Informasi Umum</h2>
    <p>
      <strong>Dinas Pertanian Tanaman Pangan dan Hortikultura</strong> merupakan unsur pelaksana Pemerintah Provinsi
      di bidang pertanian tanaman pangan dan hortikultura, yang berperan penting dalam mendukung ketahanan pangan daerah.
    </p>
    <p>
      Dinas ini dipimpin oleh seorang <strong>Kepala Dinas</strong> yang berada di bawah dan bertanggung jawab kepada
      <em>Gubernur melalui Sekretaris Daerah</em>. Dinas memiliki tugas untuk menyelenggarakan kewenangan desentralisasi
      dan tugas dekonsentrasi sesuai bidang pertanian.
    </p>
  </div>

  <div class="content-section">
    <h2><i class="fas fa-map-marker-alt" style="color:#00c2cb;"></i> Lokasi Dinas</h2>
    <p>
      <strong>Alamat:</strong> Jl. Kapten P. Tendean No. 1056, Sei Pangeran, Ilir Timur I, Kota Palembang, Sumatera Selatan
    </p>
    <img src="Gambardinas.jpg" alt="Foto Kantor Dinas Pertanian">
  </div>

  <div class="content-section" style="display: flex; flex-wrap: wrap; align-items: center; gap: 30px;">
    <div style="flex:1; min-width:250px;">
      <h2><i class="fas fa-seedling" style="color:#00c2cb;"></i> Visi & Misi</h2>
      <p>
        <strong>Visi:</strong>  RPJPD Provinsi Sumatera Selatan Tahun 2005–2025 “Sumatera Selatan Unggul dan Terdepan Tahun 2025”.<br><br>
        <strong>Misi:</strong>
        <ul style="margin-left:20px; padding-left:15px; color:#444; line-height:1.8;">
          <li>Menjadikan Sumatera Selatan sebagai salah satu penggerak pertumbuhan ekonomi regional.</li>
          <li>Meningkatkan pemanfaatan potensi sumber daya alam guna penyediaan sumber energi dan pangan yang berkelanjutan.</li>
          <li>Mewujudkan kehidupan masyarakat yang berkualitas.</li>
          <li>Meningkatkan kapasitas manajemen pemerintahan.</li>
        </ul>
      </p>
    </div>
    <img src="Petani.jpg" alt="Ilustrasi Pertanian" style="max-width:400px; border-radius:12px; box-shadow:0 5px 18px rgba(0,0,0,0.12); flex:1; min-width:250px;">
  </div>
</div>

<div class="footer">
  &copy; <?= date('Y') ?> Dinas Pertanian Provinsi Sumatera Selatan. All rights reserved.
</div>

</body>
</html>