<?php
$koneksi = new mysqli("localhost", "root", "", "pertanian");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $divisi = $_POST['divisi'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $anggaran = $_POST['anggaran'];

    $stmt = $koneksi->prepare("INSERT INTO kegiatan (divisi, nama_kegiatan, anggaran) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $divisi, $nama_kegiatan, $anggaran);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>
