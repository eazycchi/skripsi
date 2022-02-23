-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2022 at 02:42 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simpentra`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_kegiatan_pencacah`
--

CREATE TABLE `all_kegiatan_pencacah` (
  `id` int(11) UNSIGNED NOT NULL,
  `kegiatan_id` int(11) UNSIGNED NOT NULL,
  `id_pengawas` varchar(18) DEFAULT NULL,
  `id_mitra` int(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `all_kegiatan_pengawas`
--

CREATE TABLE `all_kegiatan_pengawas` (
  `id` int(11) UNSIGNED NOT NULL,
  `kegiatan_id` int(11) UNSIGNED NOT NULL,
  `id_pengawas` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `all_penilaian`
--

CREATE TABLE `all_penilaian` (
  `id` int(11) UNSIGNED NOT NULL,
  `all_kegiatan_pencacah_id` int(11) UNSIGNED NOT NULL,
  `kriteria_id` int(11) UNSIGNED NOT NULL,
  `nilai` int(11) UNSIGNED NOT NULL,
  `t_bobot` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(64) NOT NULL,
  `start` varchar(32) NOT NULL,
  `finish` varchar(32) NOT NULL,
  `k_pengawas` int(11) NOT NULL,
  `k_pencacah` int(11) NOT NULL,
  `jenis_kegiatan` int(1) NOT NULL,
  `seksi_id` int(1) UNSIGNED NOT NULL DEFAULT 5,
  `ob` enum('0','1') NOT NULL DEFAULT '0',
  `created_by` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) UNSIGNED NOT NULL,
  `prioritas` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `bobot` double NOT NULL,
  `target` enum('pencacah','pengawas','','') NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `prioritas`, `nama`, `bobot`, `target`, `deskripsi`) VALUES
(1, 3, 'Kualitas Isian', 0.14289682539683, 'pencacah', NULL),
(2, 2, 'Kuantitas', 0.19289682539683, 'pencacah', NULL),
(3, 4, 'Ketepatan Waktu', 0.10956349206349, 'pencacah', NULL),
(4, 5, 'Kepatuhan SOP', 0.084563492063492, 'pencacah', NULL),
(5, 6, 'Penguasaan Kondef', 0.064563492063492, 'pencacah', NULL),
(6, 7, 'Kerapian Tulisan', 0.047896825396825, 'pencacah', NULL),
(7, 1, 'Kejujuran', 0.29289682539683, 'pencacah', ''),
(8, 10, 'Inisiatif Kerja', 0.01, 'pencacah', NULL),
(9, 9, 'Loyalitas', 0.021111111111111, 'pencacah', NULL),
(10, 8, 'Perilaku', 0.033611111111111, 'pencacah', NULL),
(40, 1, 'Kejujuran', 0.37040816326531, 'pengawas', 'Apakah Pengawas jujur dalam melakukan tugasnya?'),
(41, 4, 'Integritas', 0.10850340136054, 'pengawas', 'Apakah pengawas berintegritas dalam melakukan tugasnya?'),
(42, 5, 'Amanah', 0.072789115646258, 'pengawas', 'Apakah seluruh tugas pengawas dapat dilakukan dengan baik?'),
(44, 2, 'Tanggungjawab', 0.22755102040816, 'pengawas', 'Apakah Pengawas bertanggung jawab atas tugas-tugasnya?'),
(45, 6, 'Inisiatif', 0.04421768707483, 'pengawas', 'Apakah Pengawas berinisiatif dalam melakukan tugasnya?'),
(46, 7, 'Kerapian', 0.020408163265306, 'pengawas', 'Apakah Pengawas selalu berpenampilan rapi?'),
(48, 3, 'Profesional', 0.15612244897959, 'pengawas', 'Apakah yang bersangkutan bersungguh-sungguh dalam melaksanakan tugas?');

-- --------------------------------------------------------

--
-- Table structure for table `mitra`
--

CREATE TABLE `mitra` (
  `id_mitra` int(20) UNSIGNED NOT NULL,
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
  `is_active` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `nip` varchar(18) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `jabatan` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `penilaian_pengawas`
--

CREATE TABLE `penilaian_pengawas` (
  `id` int(11) UNSIGNED NOT NULL,
  `all_kegiatan_pengawas_id` int(11) UNSIGNED NOT NULL,
  `id_pengawas` int(11) UNSIGNED NOT NULL,
  `id_penilai` int(11) UNSIGNED NOT NULL,
  `kriteria_id` int(11) UNSIGNED NOT NULL,
  `nilai` int(11) UNSIGNED NOT NULL,
  `t_bobot` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seksi`
--

CREATE TABLE `seksi` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seksi`
--

INSERT INTO `seksi` (`id`, `nama`) VALUES
(1, 'Produksi'),
(2, 'Sosial'),
(3, 'Distribusi'),
(4, 'Nerwilis'),
(5, 'Belum');

-- --------------------------------------------------------

--
-- Table structure for table `subkriteria`
--

CREATE TABLE `subkriteria` (
  `nilai` int(1) UNSIGNED NOT NULL,
  `prioritas` int(11) NOT NULL,
  `deskripsi` varchar(32) NOT NULL,
  `bobot` double NOT NULL,
  `konversi` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subkriteria`
--

INSERT INTO `subkriteria` (`nilai`, `prioritas`, `deskripsi`, `bobot`, `konversi`) VALUES
(1, 5, 'Kurang baik', 0.04, 50),
(2, 4, 'Cukup baik', 0.09, 60),
(3, 3, 'Baik', 0.15666666666667, 70),
(4, 2, 'Sangat baik', 0.25666666666667, 80),
(5, 1, 'Sangat baik sekali', 0.45666666666667, 90);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(32) NOT NULL,
  `image` varchar(32) NOT NULL DEFAULT 'default.jpg',
  `password` varchar(128) NOT NULL DEFAULT '$2y$10$.Ifh5wIE6hnnJjIbluFNYemnKMmvQp2qJscmi/Owpd4SMoNrW9CyS',
  `role_id` int(11) UNSIGNED NOT NULL,
  `seksi_id` int(1) UNSIGNED NOT NULL DEFAULT 5,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `date_created` date NOT NULL,
  `token` varchar(128) DEFAULT NULL,
  `date_created_token` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `image`, `password`, `role_id`, `seksi_id`, `is_active`, `date_created`, `token`, `date_created_token`) VALUES
(19, 'admin@gmail.com', 'default.jpg', '$2y$10$.Ifh5wIE6hnnJjIbluFNYemnKMmvQp2qJscmi/Owpd4SMoNrW9CyS', 1, 5, '1', '2022-01-27', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) UNSIGNED NOT NULL,
  `role_id` int(11) UNSIGNED NOT NULL,
  `menu_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(11, 1, 6),
(19, 4, 3),
(20, 4, 4),
(24, 5, 4),
(36, 3, 2),
(46, 3, 8),
(48, 1, 1),
(51, 1, 7),
(54, 3, 4),
(55, 3, 5),
(57, 1, 19),
(64, 3, 19),
(65, 4, 19),
(66, 5, 19),
(68, 3, 1),
(69, 5, 21),
(70, 3, 22),
(71, 3, 23),
(72, 4, 23);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) UNSIGNED NOT NULL,
  `menu` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Master'),
(2, 'Kegiatan'),
(3, 'Penilaian'),
(4, 'Hasil Penilaian Mitra'),
(5, 'History Penilaian'),
(6, 'Admin'),
(7, 'Menu'),
(8, 'Ranking'),
(19, 'Timeline'),
(21, 'Penilaian'),
(22, 'Penilaian'),
(23, 'Hasil Penilaian Pengawas');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) UNSIGNED NOT NULL,
  `role` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `id` int(11) UNSIGNED NOT NULL,
  `menu_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(32) NOT NULL,
  `url` varchar(64) NOT NULL,
  `icon` varchar(32) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 6, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', '1'),
(4, 7, 'Menu Management', 'menu', 'fas fa-fw fa-folder', '1'),
(5, 7, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', '1'),
(9, 6, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', '1'),
(12, 1, 'Data Mitra', 'master/mitra', 'fas fa-fw fa-user', '1'),
(13, 2, 'Survei', 'kegiatan/survei', 'fas fa-fw fa-book', '1'),
(14, 3, 'Isi Penilaian Pencacah', 'penilaian', 'fas fa-fw fa-pencil-alt', '1'),
(15, 4, 'Cetak Hasil Penilaian', 'penilaian/pilihkegiatan', 'fas fa-fw fa-file-pdf', '1'),
(16, 5, 'Arsip', 'penilaian/arsip', 'fas fa-fw fa-archive', '1'),
(20, 2, 'Sensus', 'kegiatan/sensus', 'fas fa-fw fa-book', '1'),
(25, 6, 'All User', 'admin/alluser', 'fas fa-fw fa-user', '1'),
(26, 1, 'Data Pegawai', 'master/pegawai', 'fas fa-fw fa-user-tie', '1'),
(27, 8, 'Ranking Mitra', 'ranking/pilih_kegiatan_nilai_akhir', 'fas fa-fw fa-graduation-cap', '1'),
(28, 8, 'Data Kriteria', 'ranking/kriteria', 'fas fa-fw fa-key', '1'),
(29, 8, 'Penghitungan', 'ranking/pilih_kegiatan', 'fas fa-fw fa-pen', '1'),
(32, 19, 'Jadwal', 'timeline/index', 'fas fa-fw fa-calendar-alt', '1'),
(35, 21, 'Isi Penilaian Pengawas', 'penilaian/penilaianpengawas', 'fas fa-fw fa-pencil-alt', '1'),
(36, 3, 'Isi Penilaian Pengawas', 'penilaian/penilaianpengawas2', 'fas fa-fw fa-pencil-alt', '1'),
(37, 22, 'Isi Penilaian Pengawas', 'penilaian/penilaianpengawas3', 'fas fa-fw fa-pencil-alt', '1'),
(38, 23, 'Cetak Hasil Penilaian', 'penilaian/pilihkegiatan2', 'fas fa-fw fa-file-pdf', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_kegiatan_pencacah`
--
ALTER TABLE `all_kegiatan_pencacah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `all_kegiatan_pencacah_kegiatan_id_foreign` (`kegiatan_id`),
  ADD KEY `all_kegiatan_pencacah_id_pengawas_foreign` (`id_pengawas`),
  ADD KEY `all_kegiatan_pencacah_id_mitra_foreign` (`id_mitra`);

--
-- Indexes for table `all_kegiatan_pengawas`
--
ALTER TABLE `all_kegiatan_pengawas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `all_kegiatan_pengawas_kegiatan_id_foreign` (`kegiatan_id`);

--
-- Indexes for table `all_penilaian`
--
ALTER TABLE `all_penilaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `all_penilaian_all_kegiatan_pencacah_id_foreign` (`all_kegiatan_pencacah_id`),
  ADD KEY `all_penilaian_kriteria_id_foreign` (`kriteria_id`),
  ADD KEY `all_penilaian_nilai_foreign` (`nilai`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_seksi_id_foreign` (`seksi_id`),
  ADD KEY `created_by` (`created_by`);

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
-- Indexes for table `penilaian_pengawas`
--
ALTER TABLE `penilaian_pengawas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_id` (`kriteria_id`),
  ADD KEY `nilai` (`nilai`),
  ADD KEY `penilaian_pengawas_ibfk_1` (`all_kegiatan_pengawas_id`),
  ADD KEY `id_penilai` (`id_penilai`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_role_id_foreign` (`role_id`),
  ADD KEY `user_seksi_id_foreign` (`seksi_id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_access_menu_role_id_foreign` (`role_id`),
  ADD KEY `user_access_menu_menu_id_foreign` (`menu_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_sub_menu_menu_id_foreign` (`menu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_kegiatan_pencacah`
--
ALTER TABLE `all_kegiatan_pencacah`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `all_kegiatan_pengawas`
--
ALTER TABLE `all_kegiatan_pengawas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `all_penilaian`
--
ALTER TABLE `all_penilaian`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `mitra`
--
ALTER TABLE `mitra`
  MODIFY `id_mitra` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `penilaian_pengawas`
--
ALTER TABLE `penilaian_pengawas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `seksi`
--
ALTER TABLE `seksi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `nilai` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `all_kegiatan_pencacah`
--
ALTER TABLE `all_kegiatan_pencacah`
  ADD CONSTRAINT `all_kegiatan_pencacah_id_mitra_foreign` FOREIGN KEY (`id_mitra`) REFERENCES `mitra` (`id_mitra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `all_kegiatan_pencacah_id_pengawas_foreign` FOREIGN KEY (`id_pengawas`) REFERENCES `pegawai` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `all_kegiatan_pencacah_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `all_kegiatan_pengawas`
--
ALTER TABLE `all_kegiatan_pengawas`
  ADD CONSTRAINT `all_kegiatan_pengawas_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `all_penilaian`
--
ALTER TABLE `all_penilaian`
  ADD CONSTRAINT `all_penilaian_all_kegiatan_pencacah_id_foreign` FOREIGN KEY (`all_kegiatan_pencacah_id`) REFERENCES `all_kegiatan_pencacah` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `all_penilaian_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `all_penilaian_nilai_foreign` FOREIGN KEY (`nilai`) REFERENCES `subkriteria` (`nilai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `pegawai` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kegiatan_seksi_id_foreign` FOREIGN KEY (`seksi_id`) REFERENCES `seksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian_pengawas`
--
ALTER TABLE `penilaian_pengawas`
  ADD CONSTRAINT `penilaian_pengawas_ibfk_1` FOREIGN KEY (`all_kegiatan_pengawas_id`) REFERENCES `all_kegiatan_pengawas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_pengawas_ibfk_2` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_pengawas_ibfk_3` FOREIGN KEY (`nilai`) REFERENCES `subkriteria` (`nilai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_pengawas_ibfk_4` FOREIGN KEY (`id_penilai`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_seksi_id_foreign` FOREIGN KEY (`seksi_id`) REFERENCES `seksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD CONSTRAINT `user_access_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `user_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_access_menu_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD CONSTRAINT `user_sub_menu_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `user_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
