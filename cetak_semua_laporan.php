<?php
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'karyawan')) {
    header("Location: login.php");
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Aktifkan opsi untuk bisa membaca gambar lokal
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Ambil konten dari setiap file HTML
ob_start();
include 'lihat_program_kerja.php';
$program_kerja = ob_get_clean();

ob_start();
include 'lihat_satuan_kerja.php';
$satuan_kerja = ob_get_clean();

ob_start();
include 'lihat_realisasi_fisik.php';
$realisasi_fisik = ob_get_clean();

ob_start();
include 'lihat_realisasi_keuangan.php';
$realisasi_keuangan = ob_get_clean();

ob_start();
include 'lihat_revisi.php';
$revisi = ob_get_clean();

ob_start();
include 'lihat_kontrak.php';
$kontrak = ob_get_clean();

$logoPath = 'logo_dinas.png'; // Pastikan file ini ada di folder yang sama
if (file_exists($logoPath)) {
    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
    $data = file_get_contents($logoPath);
    $base64_logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
} else {
    $base64_logo = ''; // fallback kosong jika tidak ditemukan
}

// Gunakan path absolut dengan file://
$logo = '
<div style="text-align: center; margin-bottom: 5px;">
  <img src="' . $base64_logo . '" width="80" alt="Logo Dinas"><br>
  <h2 style="margin: 0; font-size: 18px;">PEMERINTAH PROVINSI SUMATERA SELATAN</h2>
  <h3 style="margin: 0; font-size: 16px;">DINAS PERTANIAN TANAMAN PANGAN DAN HORTIKULTURA</h3>
  <p style="margin: 0; font-size: 12px;">Jl. Kapten P. Tendean No.1056, Palembang, Telp. (0711) XXXXXXX</p>
</div>
<hr style="border: 2px solid black; margin: 0;">
<hr style="border: 1px solid black; margin-top: 1px; margin-bottom: 20px;">
';


// Tanda tangan di akhir laporan
$tanda_tangan = '<div style="page-break-before: always; text-align: right; margin-top: 50px;">
                    <p style="margin-bottom: 60px;">Palembang, ' . date("d F Y") . '<br>
                    Kepala Bagian</p>
                    <strong style="text-decoration: underline;">Chrisant Winarni,SP,M.Si, S.TP</strong><br>
                    NIP. 19740127 200501 2 001
                 </div>';

// Gabungkan semua HTML
$html = $logo
      . $program_kerja . '<div style="page-break-after: always;"></div>'
      . $satuan_kerja . '<div style="page-break-after: always;"></div>'
      . $realisasi_fisik . '<div style="page-break-after: always;"></div>'
      . $realisasi_keuangan . '<div style="page-break-after: always;"></div>'
      . $revisi . '<div style="page-break-after: always;"></div>'
      . $kontrak
      . $tanda_tangan;

// Render dan tampilkan PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Laporan_Karyawan.pdf", ["Attachment" => false]);
