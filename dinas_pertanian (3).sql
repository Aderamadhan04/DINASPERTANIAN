-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2025 at 05:15 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinas_pertanian`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123'),
(2, 'karyawan', 'karyawan123');

-- --------------------------------------------------------

--
-- Table structure for table `kontrak`
--

CREATE TABLE `kontrak` (
  `nama_kontrak` varchar(100) NOT NULL,
  `penyedia_barang` varchar(50) NOT NULL,
  `nilai_kontrak` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `status_pelaksanaan` varchar(100) NOT NULL,
  `bukti_kontrak` varchar(255) NOT NULL,
  `status_approve` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontrak`
--

INSERT INTO `kontrak` (`nama_kontrak`, `penyedia_barang`, `nilai_kontrak`, `tanggal_mulai`, `status_pelaksanaan`, `bukti_kontrak`, `status_approve`) VALUES
('Belanja Barang Pakai Habis ', 'Toko Guna Sarana Mandiri', 'Rp. 1670000', '2025-06-14', 'Berskala bertahap', '1749815605_1. Toko Guna Sarana Mandiri-1.670.250.pdf', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `program_kerja`
--

CREATE TABLE `program_kerja` (
  `kode_rekening` varchar(50) NOT NULL,
  `nama_program` varchar(150) NOT NULL,
  `uraian_kegiatan` varchar(50) NOT NULL,
  `indikator_kinerja` varchar(20) NOT NULL,
  `anggaran` int(100) NOT NULL,
  `status_approve` enum('pending','approved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_kerja`
--

INSERT INTO `program_kerja` (`kode_rekening`, `nama_program`, `uraian_kegiatan`, `indikator_kinerja`, `anggaran`, `status_approve`) VALUES
('5.1', 'program pengendalian dan penanggulangan bencana pertanian', 'pengendalian dan penanggulangan bencana pertanian ', 'dana yang dibutuhkan', 100000, 'approved'),
('5.1.02', 'program pengendalian dan penanggulangan bencana pertanian', 'pengendalian dan penanggulangan bencana pertanian ', 'memproses program', 100000, 'approved'),
('5.1.02.01.01.0012', 'program pengendalian dan penanggulangan bencana pertanian', 'pengendalian dan penanggulangan bencana pertanian ', 'memproses program', 120000, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `realisasi_fisik`
--

CREATE TABLE `realisasi_fisik` (
  `id` int(11) NOT NULL,
  `nama_kegiatan` varchar(64) NOT NULL,
  `output_fisik` varchar(54) NOT NULL,
  `target_kinerja` varchar(47) NOT NULL,
  `capaian_kinerja` text NOT NULL,
  `status_approve` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `realisasi_fisik`
--

INSERT INTO `realisasi_fisik` (`id`, `nama_kegiatan`, `output_fisik`, `target_kinerja`, `capaian_kinerja`, `status_approve`) VALUES
(3, 'pengendalian dan penanggulangan bencana', 'barang habis pakai', 'berhasil', 'kegiatan tercapai', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `realisasi_keuangan`
--

CREATE TABLE `realisasi_keuangan` (
  `id` int(11) NOT NULL,
  `bulan` varchar(50) DEFAULT NULL,
  `jumlah_dana_ditarik` decimal(15,2) NOT NULL,
  `sisa_dana` int(51) NOT NULL,
  `total_realisasi_perbulan` decimal(54,0) NOT NULL,
  `status_approve` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `realisasi_keuangan`
--

INSERT INTO `realisasi_keuangan` (`id`, `bulan`, `jumlah_dana_ditarik`, `sisa_dana`, `total_realisasi_perbulan`, `status_approve`) VALUES
(2, 'Januari', 1000000.00, 2900000, 1500000, 'approved'),
(4, 'Januari', 100000.00, 10000, 190000, 'approved'),
(5, 'november', 800000.00, 10200000, 11000000, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `rekening_ref`
--

CREATE TABLE `rekening_ref` (
  `kode` varchar(50) NOT NULL,
  `uraian` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekening_ref`
--

INSERT INTO `rekening_ref` (`kode`, `uraian`) VALUES
('5.1', 'Belanja Operasi'),
('5.1.02', 'Belanja Barang dan Jasa'),
('5.1.02.01', 'Belanja Barang'),
('5.1.02.01.01', 'Belanja Barang Pakai Habis'),
('5.1.02.01.01.0012', 'Belanjan Bahan-Bahan Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `revisi`
--

CREATE TABLE `revisi` (
  `tanggal_revisi` date NOT NULL,
  `uraian_perubahan` text NOT NULL,
  `nilai_setelah_revisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revisi`
--

INSERT INTO `revisi` (`tanggal_revisi`, `uraian_perubahan`, `nilai_setelah_revisi`) VALUES
('2025-12-22', 'barang terbeli 5', 15);

-- --------------------------------------------------------

--
-- Table structure for table `satuan_kerja`
--

CREATE TABLE `satuan_kerja` (
  `kode_DPA` varchar(50) NOT NULL,
  `nama_satker` varchar(100) NOT NULL,
  `tahun_anggaran` date NOT NULL,
  `lokasi_kegiatan` varchar(40) NOT NULL,
  `pendanaan` int(11) NOT NULL,
  `Waktu_pelaksanaan` date NOT NULL,
  `status_approve` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan_kerja`
--

INSERT INTO `satuan_kerja` (`kode_DPA`, `nama_satker`, `tahun_anggaran`, `lokasi_kegiatan`, `pendanaan`, `Waktu_pelaksanaan`, `status_approve`) VALUES
('DPA/A.1/3.27.0.00.0.00.02.0000/001/2022', 'Tanaman Pangan', '2025-06-12', 'Dinaas Pertanian', 350000, '2025-06-12', 'approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kontrak`
--
ALTER TABLE `kontrak`
  ADD PRIMARY KEY (`tanggal_mulai`);

--
-- Indexes for table `program_kerja`
--
ALTER TABLE `program_kerja`
  ADD PRIMARY KEY (`kode_rekening`),
  ADD KEY `id_revisi` (`kode_rekening`);

--
-- Indexes for table `realisasi_fisik`
--
ALTER TABLE `realisasi_fisik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `realisasi_keuangan`
--
ALTER TABLE `realisasi_keuangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekening_ref`
--
ALTER TABLE `rekening_ref`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `satuan_kerja`
--
ALTER TABLE `satuan_kerja`
  ADD PRIMARY KEY (`kode_DPA`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `realisasi_fisik`
--
ALTER TABLE `realisasi_fisik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `realisasi_keuangan`
--
ALTER TABLE `realisasi_keuangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
