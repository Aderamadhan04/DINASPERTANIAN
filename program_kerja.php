<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dinas_pertanian";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Aktifkan error reporting untuk debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kode rekening yang tersedia (bisa dari tabel lain)
$daftar_kode_rekening = [
    "5.1",
    "5.1.02",
    "5.1.02.01",
    "5.1.02.01.02",
    "5.1.02.01.01.0012"
];

// Proses tambah data
if (isset($_POST['simpan_program'])) {
    $kode_rekening = $_POST['kode_rekening'];
    $nama_program = $_POST['nama_program'];
    $uraian_kegiatan = $_POST['uraian_kegiatan'];
    $indikator_kinerja = $_POST['indikator_kinerja'];
    $anggaran = (int) $_POST['anggaran'];

    $stmt = $conn->prepare("INSERT INTO program_kerja (kode_rekening, nama_program, uraian_kegiatan, indikator_kinerja, anggaran) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $kode_rekening, $nama_program, $uraian_kegiatan, $indikator_kinerja, $anggaran);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    header("Location: program_kerja.php");
    exit;
}

// Proses hapus data
if (isset($_GET['hapus'])) {
    $kode_rekening = $_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM program_kerja WHERE kode_rekening = ?");
    $stmt->bind_param("s", $kode_rekening);
    $stmt->execute();
    $stmt->close();
    header("Location: program_kerja.php");
    exit;
}

// Proses approve data
if (isset($_GET['approve'])) {
    $kode_rekening = $_GET['approve'];
    $stmt = $conn->prepare("UPDATE program_kerja SET status_approve = 'approved' WHERE kode_rekening = ?");
    $stmt->bind_param("s", $kode_rekening);
    $stmt->execute();
    $stmt->close();
    header("Location: program_kerja.php");
    exit;
}

// Ambil data program kerja
$programs = $conn->query("SELECT * FROM program_kerja ORDER BY kode_rekening DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Program Kerja - Dinas Pertanian</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial;
            padding: 0;
            margin: 0;
            background: #f2f4f8;
        }

        .navbar {
            background-color: #234048;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 25px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            transition: 0.3s;
        }

        .navbar a:hover {
            text-decoration: underline;
            color: #ccc;
        }

        .container {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: white;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #f7f7f7;
        }

        .form-group {
            margin-bottom: 10px;
        }

        input[type=text], input[type=number], select {
            width: 100%;
            padding: 8px;
        }

        .btn {
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 13px;
            display: inline-block;
            margin: 2px 3px;
            white-space: nowrap;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-add {
            background-color: #28a745;
        }

        .btn-edit {
            background-color: #ffc107;
            color: black;
        }

        .btn-approve {
            background-color: #28a745;
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .approved-badge {
            color: green;
            font-weight: bold;
        }

        .pending-badge {
            color: gray;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div></div>
    <div>
        <a href="home.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="dashboard.php"><i class="fas fa-chart-line"></i> Kembali ke Dashboard</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <h2>Program Kerja - Dinas Pertanian</h2>

    <!-- Form Tambah -->
    <h3>➕ Tambah Program</h3>
    <form method="POST">
        <div class="form-group">
            <label>Kode Rekening:</label>
            <select name="kode_rekening" required>
                <option value="">-- Pilih Kode Rekening --</option>
                <?php foreach ($daftar_kode_rekening as $kode): ?>
                    <option value="<?= htmlspecialchars($kode) ?>"><?= htmlspecialchars($kode) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Nama Program:</label>
            <input type="text" name="nama_program" required>
        </div>
        <div class="form-group">
            <label>Uraian Kegiatan:</label>
            <input type="text" name="uraian_kegiatan" required>
        </div>
        <div class="form-group">
            <label>Indikator Kinerja:</label>
            <input type="text" name="indikator_kinerja" required>
        </div>
        <div class="form-group">
            <label>Anggaran:</label>
            <input type="number" name="anggaran" required>
        </div>
        <button type="submit" name="simpan_program" class="btn btn-add">Simpan</button>
    </form>

    <!-- Tabel Data -->
    <h3>📋 Daftar Program</h3>
    <table>
        <thead>
            <tr>
                <th>Kode Rekening</th>
                <th>Nama Program</th>
                <th>Uraian Kegiatan</th>
                <th>Indikator</th>
                <th>Anggaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($programs->num_rows > 0): ?>
                <?php while ($row = $programs->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kode_rekening']) ?></td>
                        <td><?= htmlspecialchars($row['nama_program']) ?></td>
                        <td><?= htmlspecialchars($row['uraian_kegiatan']) ?></td>
                        <td><?= htmlspecialchars($row['indikator_kinerja']) ?></td>
                        <td>Rp <?= number_format($row['anggaran'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($row['status_approve'] === 'approved'): ?>
                                <span class="approved-badge">✔ Approved</span>
                            <?php else: ?>
                                <span class="pending-badge">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="button-group">
                                <a href="edit_program_kerja.php?kode_rekening=<?= urlencode($row['kode_rekening']) ?>" class="btn btn-edit" title="Edit">✏</a>
                                <a href="?hapus=<?= urlencode($row['kode_rekening']) ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">🗑</a>

                                <?php if ($row['status_approve'] !== 'approved'): ?>
                                    <a href="?approve=<?= urlencode($row['kode_rekening']) ?>" class="btn btn-approve" title="Approve" onclick="return confirm('Setujui program ini?')">✔ Approve</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">Belum ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
