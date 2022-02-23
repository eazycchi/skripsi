-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2021 at 09:23 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tes`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_kegiatan_pencacah`
--

CREATE TABLE `all_kegiatan_pencacah` (
  `id` int(11) NOT NULL,
  `kegiatan_id` int(11) NOT NULL,
  `id_pengawas` varchar(18) NOT NULL DEFAULT '0',
  `id_mitra` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `all_kegiatan_pengawas`
--

CREATE TABLE `all_kegiatan_pengawas` (
  `id` int(11) NOT NULL,
  `kegiatan_id` int(11) NOT NULL,
  `id_pengawas` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `all_penilaian`
--

CREATE TABLE `all_penilaian` (
  `id` int(11) NOT NULL,
  `all_kegiatan_pencacah_id` int(11) NOT NULL,
  `kriteria_id` int(11) NOT NULL,
  `nilai` int(1) NOT NULL,
  `t_bobot` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `start` varchar(32) NOT NULL,
  `finish` varchar(32) NOT NULL,
  `k_pengawas` int(11) NOT NULL,
  `k_pencacah` int(11) NOT NULL,
  `jenis_kegiatan` int(1) NOT NULL,
  `seksi_id` int(1) NOT NULL DEFAULT 0,
  `ob` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `prioritas` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `bobot` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `prioritas`, `nama`, `bobot`) VALUES
(1, 3, 'Kualitas Isian', 0.14289682539683),
(2, 2, 'Kuantitas', 0.19289682539683),
(3, 4, 'Ketepatan Waktu', 0.10956349206349),
(4, 5, 'Kepatuhan SOP', 0.084563492063492),
(5, 6, 'Penguasaan Kondef', 0.064563492063492),
(6, 7, 'Kerapian Tulisan', 0.047896825396825),
(7, 1, 'Kejujuran', 0.29289682539683),
(8, 10, 'Inisiatif Kerja', 0.01),
(9, 9, 'Loyalitas', 0.021111111111111),
(10, 8, 'Perilaku', 0.033611111111111);

-- --------------------------------------------------------

--
-- Table structure for table `mitra`
--

CREATE TABLE `mitra` (
  `id_mitra` bigint(20) NOT NULL,
  `nama_lengkap` varchar(32) NOT NULL,
  `nama_panggilan` varchar(16) NOT NULL,
  `email` varchar(32) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `no_wa` varchar(13) NOT NULL,
  `no_tsel` varchar(13) NOT NULL,
  `pekerjaan_utama` varchar(32) NOT NULL,
  `kompetensi` varchar(32) NOT NULL,
  `bahasa` varchar(32) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `nip` char(18) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `jabatan` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seksi`
--

CREATE TABLE `seksi` (
  `id` int(11) NOT NULL,
  `nama` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seksi`
--

INSERT INTO `seksi` (`id`, `nama`) VALUES
(1, 'Produksi'),
(2, 'Sosial'),
(3, 'Distribusi'),
(4, 'Nerwilis');

-- --------------------------------------------------------

--
-- Table structure for table `subkriteria`
--

CREATE TABLE `subkriteria` (
  `prioritas` int(11) NOT NULL,
  `nilai` int(1) NOT NULL,
  `deskripsi` varchar(32) NOT NULL,
  `bobot` double NOT NULL,
  `konversi` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subkriteria`
--

INSERT INTO `subkriteria` (`prioritas`, `nilai`, `deskripsi`, `bobot`, `konversi`) VALUES
(5, 1, 'Kurang baik', 0.04, 50),
(4, 2, 'Cukup baik', 0.09, 60),
(3, 3, 'Baik', 0.15666666666667, 70),
(2, 4, 'Sangat baik', 0.25666666666667, 80),
(1, 5, 'Sangat baik sekali', 0.45666666666667, 90);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(32) NOT NULL,
  `image` varchar(32) NOT NULL DEFAULT 'default.jpg',
  `password` varchar(128) NOT NULL DEFAULT '$2y$10$LbxrTcSA4dSZlSnoPWUUoeb7b6xBZD.tE/fsBxydlgn.q6aqV18nO',
  `role_id` int(1) NOT NULL,
  `seksi_id` int(1) NOT NULL DEFAULT 0,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `date_created` int(11) NOT NULL,
  `token` varchar(128) DEFAULT NULL,
  `date_created_token` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `image`, `password`, `role_id`, `seksi_id`, `is_active`, `date_created`, `token`, `date_created_token`) VALUES
(45, 'superadmin@gmail.com', 'logo_msa1.png', '$2y$10$LbxrTcSA4dSZlSnoPWUUoeb7b6xBZD.tE/fsBxydlgn.q6aqV18nO', 1, 0, 1, 1621989189, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(1) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(11, 1, 6),
(14, 2, 2),
(19, 4, 3),
(20, 4, 4),
(23, 2, 1),
(24, 5, 4),
(36, 3, 2),
(45, 2, 8),
(46, 3, 8),
(48, 1, 1),
(51, 1, 7),
(52, 2, 4),
(53, 2, 5),
(54, 3, 4),
(55, 3, 5),
(57, 1, 18),
(63, 2, 19),
(64, 3, 19),
(65, 4, 19),
(66, 5, 19),
(68, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Master'),
(2, 'Kegiatan'),
(3, 'Penilaian'),
(4, 'Hasil Penilaian'),
(5, 'History Penilaian'),
(6, 'Admin'),
(7, 'Menu'),
(8, 'Ranking'),
(19, 'Timeline');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Super Admin'),
(3, 'Operator Seksi'),
(4, 'Pengawas'),
(5, 'Mitra');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `url` varchar(64) NOT NULL,
  `icon` varchar(32) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 6, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(4, 7, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(5, 7, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(9, 6, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(12, 1, 'Data Mitra', 'master/mitra', 'fas fa-fw fa-user', 1),
(13, 2, 'Survei', 'kegiatan/survei', 'fas fa-fw fa-book', 1),
(14, 3, 'Isi Penilaian', 'penilaian', 'fas fa-fw fa-pencil-alt', 1),
(15, 4, 'Cetak Hasil Penilaian', 'penilaian/pilihkegiatan', 'fas fa-fw fa-file-pdf', 1),
(16, 5, 'Arsip', 'penilaian/arsip', 'fas fa-fw fa-archive', 1),
(20, 2, 'Sensus', 'kegiatan/sensus', 'fas fa-fw fa-book', 1),
(25, 6, 'All User', 'admin/alluser', 'fas fa-fw fa-user', 1),
(26, 1, 'Data Pegawai', 'master/pegawai', 'fas fa-fw fa-user-tie', 1),
(27, 8, 'Ranking Mitra', 'ranking/pilih_kegiatan_nilai_akhir', 'fas fa-fw fa-graduation-cap', 1),
(28, 8, 'Data Kriteria', 'ranking/kriteria', 'fas fa-fw fa-key', 1),
(29, 8, 'Penghitungan', 'ranking/pilih_kegiatan', 'fas fa-fw fa-pen', 1),
(32, 19, 'Jadwal', 'timeline/index', 'fas fa-fw fa-calendar-alt', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_kegiatan_pencacah`
--
ALTER TABLE `all_kegiatan_pencacah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_kegiatan_pengawas`
--
ALTER TABLE `all_kegiatan_pengawas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_penilaian`
--
ALTER TABLE `all_penilaian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id_mitra`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `seksi`
--
ALTER TABLE `seksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`nilai`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_kegiatan_pencacah`
--
ALTER TABLE `all_kegiatan_pencacah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `all_kegiatan_pengawas`
--
ALTER TABLE `all_kegiatan_pengawas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `all_penilaian`
--
ALTER TABLE `all_penilaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=421;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id_mitra` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483723;

--
-- AUTO_INCREMENT for table `seksi`
--
ALTER TABLE `seksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
