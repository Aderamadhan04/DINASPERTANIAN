<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $divisi = $_POST['divisi_kontrak'] ?? '';
  $file = $_FILES['kontrak'];

  if ($file['type'] === "application/pdf") {
    $nama_file = basename($file['name']);
    $tujuan = "uploads/" . $nama_file;

    if (move_uploaded_file($file['tmp_name'], $tujuan)) {
      echo "Kontrak berhasil diupload untuk divisi: <strong>$divisi</strong>";
    } else {
      echo "Gagal mengupload file.";
    }
  } else {
    echo "Hanya file PDF yang diperbolehkan.";
  }
}
?>
