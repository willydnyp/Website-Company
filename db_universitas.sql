-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2026 at 11:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_universitas`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `isi`, `foto`, `penulis`, `tanggal`, `created_at`) VALUES
(1, 'Penerimaan Mahasiswa Baru Tahun Akademik 2026/2027 Resmi Dibuka', 'Universitas YPIB Majalengka dengan bangga mengumumkan pembukaan pendaftaran mahasiswa baru untuk tahun akademik 2026/2027. Pendaftaran dapat dilakukan secara online melalui website resmi kampus maupun langsung datang ke kampus. Calon mahasiswa dapat memilih dari berbagai program studi unggulan yang tersedia di empat fakultas.', 'default-berita.jpg', 'Humas Kampus', '2026-08-01', '2026-08-19 04:00:00'),
(2, 'Wisuda Angkatan XV Berlangsung Khidmat', 'Universitas YPIB Majalengka menggelar upacara wisuda bagi ratusan lulusan dari berbagai program studi. Acara berlangsung khidmat dan dihadiri oleh keluarga besar wisudawan serta jajaran pimpinan universitas. Rektor berpesan agar para lulusan terus mengembangkan diri dan berkontribusi bagi masyarakat.', 'default-berita.jpg', 'Humas Kampus', '2026-07-20', '2026-08-19 04:00:00'),
(3, 'Seminar Nasional Teknologi dan Inovasi Digital 2026', 'Fakultas Ilmu Komputer menyelenggarakan seminar nasional bertema teknologi dan inovasi digital yang menghadirkan pembicara dari kalangan akademisi dan praktisi industri. Kegiatan ini bertujuan untuk membekali mahasiswa dengan wawasan terkini seputar perkembangan teknologi informasi.', 'default-berita.jpg', 'Admin', '2026-07-05', '2026-08-19 04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `fakultas_id` int(11) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nidn`, `nama`, `fakultas_id`, `jabatan`, `foto`, `created_at`) VALUES
(1, '0001018501', 'Dr. Ir. Budi Santoso, M.T.', 1, 'Lektor Kepala', 'default-dosen.jpg', '2026-07-27 04:17:25'),
(2, '0002028502', 'Dr. Siti Rahmawati, S.E., M.M.', 2, 'Lektor Kepala', 'default-dosen.jpg', '2026-07-27 04:17:25'),
(3, '0003038503', 'Dr. Andi Prasetyo, S.Kom., M.Kom.', 3, 'Lektor', 'default-dosen.jpg', '2026-07-27 04:17:25'),
(4, '0004048504', 'Dr. Rina Kusuma, S.H., M.H.', 4, 'Lektor', 'default-dosen.jpg', '2026-07-27 04:17:25'),
(5, '0005058505', 'Yusuf Maulana, S.Kom., M.T.', 3, 'Asisten Ahli', 'default-dosen.jpg', '2026-07-27 04:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id` int(11) NOT NULL,
  `nama_fakultas` varchar(150) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama_dekan` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id`, `nama_fakultas`, `foto`, `nama_dekan`, `deskripsi`) VALUES
(1, 'Fakultas Teknik', 'default-fakultas.jpg', 'Dr. Ir. Budi Santoso, M.T.', 'Fakultas Teknik menyelenggarakan pendidikan di bidang rekayasa dan teknologi dengan fasilitas laboratorium modern.'),
(2, 'Fakultas Ekonomi dan Bisnis', 'default-fakultas.jpg', 'Dr. Siti Rahmawati, S.E., M.M.', 'Fakultas Ekonomi dan Bisnis mencetak lulusan yang siap bersaing di dunia bisnis dan industri keuangan.'),
(3, 'Fakultas Ilmu Komputer', 'default-fakultas.jpg', 'Dr. Andi Prasetyo, S.Kom., M.Kom.', 'Fakultas Ilmu Komputer fokus pada pengembangan teknologi informasi, sistem cerdas, dan rekayasa perangkat lunak.'),
(4, 'Fakultas Hukum', 'default-fakultas.jpg', 'Dr. Rina Kusuma, S.H., M.H.', 'Fakultas Hukum membekali mahasiswa dengan wawasan hukum nasional dan internasional yang kuat.');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `judul`, `foto`, `kategori`) VALUES
(1, 'Gedung Utama Kampus', 'default-galeri.jpg', 'Fasilitas'),
(2, 'Kegiatan Wisuda', 'default-galeri.jpg', 'Acara'),
(3, 'Laboratorium Komputer', 'default-galeri.jpg', 'Fasilitas'),
(4, 'Perpustakaan Pusat', 'default-galeri.jpg', 'Fasilitas'),
(5, 'Kegiatan Mahasiswa Baru', 'default-galeri.jpg', 'Acara'),
(6, 'Seminar Nasional', 'default-galeri.jpg', 'Acara');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `subjek` varchar(200) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `status` enum('belum_dibaca','dibaca') DEFAULT 'belum_dibaca',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id`, `nama`, `email`, `no_hp`, `subjek`, `pesan`, `status`, `created_at`) VALUES
(1, 'Joko Widianto', 'joko@example.com', '081234567890', 'Informasi Pendaftaran', 'Selamat siang, saya ingin bertanya terkait jadwal pendaftaran mahasiswa baru tahun ini.', 'belum_dibaca', '2026-07-27 04:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `prodi_id` int(11) DEFAULT NULL,
  `angkatan` year(4) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `prodi_id`, `angkatan`, `jenis_kelamin`, `foto`, `created_at`) VALUES
(1, '2023010001', 'Rizky Ramadhan', 6, '2023', 'L', NULL, '2026-07-27 04:17:25'),
(2, '2023010002', 'Anisa Putri', 5, '2023', 'P', NULL, '2026-07-27 04:17:25'),
(3, '2022010003', 'Fajar Nugroho', 1, '2022', 'L', NULL, '2026-07-27 04:17:25'),
(4, '2022010004', 'Dewi Lestari', 3, '2022', 'P', NULL, '2026-07-27 04:17:25'),
(5, '2021010005', 'Bagus Setiawan', 7, '2021', 'L', NULL, '2026-07-27 04:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `pengunjung`
--

CREATE TABLE `pengunjung` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengunjung`
--

INSERT INTO `pengunjung` (`id`, `ip_address`, `tanggal`) VALUES
(1, '192.168.1.1', '2026-07-27'),
(2, '::1', '2026-07-27'),
(3, '::1', '2026-07-27');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `isi` text NOT NULL,
  `kategori` varchar(50) NOT NULL DEFAULT 'Umum',
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_studi`
--

CREATE TABLE `program_studi` (
  `id` int(11) NOT NULL,
  `nama_prodi` varchar(150) NOT NULL,
  `fakultas_id` int(11) DEFAULT NULL,
  `jenjang` varchar(20) DEFAULT NULL,
  `akreditasi` varchar(20) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_studi`
--

INSERT INTO `program_studi` (`id`, `nama_prodi`, `fakultas_id`, `jenjang`, `akreditasi`, `deskripsi`) VALUES
(1, 'Teknik Sipil', 1, 'S1', 'A', 'Program studi yang mempelajari perencanaan, konstruksi, dan pemeliharaan infrastruktur.'),
(2, 'Teknik Elektro', 1, 'S1', 'B', 'Program studi yang mempelajari kelistrikan, elektronika, dan sistem tenaga.'),
(3, 'Manajemen', 2, 'S1', 'A', 'Program studi yang mempelajari manajemen bisnis, pemasaran, dan sumber daya manusia.'),
(4, 'Akuntansi', 2, 'S1', 'A', 'Program studi yang mempelajari akuntansi keuangan, perpajakan, dan audit.'),
(5, 'Sistem Informasi', 3, 'S1', 'A', 'Program studi yang menggabungkan ilmu komputer dan manajemen bisnis.'),
(6, 'Teknik Informatika', 3, 'S1', 'A', 'Program studi yang fokus pada pengembangan perangkat lunak dan kecerdasan buatan.'),
(7, 'Ilmu Hukum', 4, 'S1', 'B', 'Program studi yang mempelajari hukum perdata, pidana, dan tata negara.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('superadmin','admin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$rCvp3kySpCEQ4qP.7gubq.jEmMvWpO2irQJRlJGvs2vgtA8sU4hqO', 'Administrator', 'superadmin', '2026-07-27 04:17:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nidn` (`nidn`),
  ADD KEY `fakultas_id` (`fakultas_id`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fakultas_id` (`fakultas_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `pengunjung`
--
ALTER TABLE `pengunjung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `program_studi`
--
ALTER TABLE `program_studi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `program_studi` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD CONSTRAINT `program_studi_ibfk_1` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;