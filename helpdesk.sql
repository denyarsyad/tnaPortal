-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 12, 2025 at 08:02 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `id_backup` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id_dept` int(11) NOT NULL,
  `nama_dept` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id_dept`, `nama_dept`) VALUES
(1, 'Super Administrator'),
(2, 'Information Technology'),
(3, 'Software Tester'),
(4, 'Staf Umum');

-- --------------------------------------------------------

--
-- Table structure for table `departemen_bagian`
--

CREATE TABLE `departemen_bagian` (
  `id_bagian_dept` int(11) NOT NULL,
  `nama_bagian_dept` varchar(100) NOT NULL,
  `id_dept` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departemen_bagian`
--

INSERT INTO `departemen_bagian` (`id_bagian_dept`, `nama_bagian_dept`, `id_dept`) VALUES
(1, 'Administrator', 1),
(2, 'IT Support', 2),
(3, 'Tester', 3),
(4, 'Staf', 4);

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `id_informasi` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `subject` varchar(35) NOT NULL,
  `pesan` varchar(250) NOT NULL,
  `id_user` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `informasi`
--

INSERT INTO `informasi` (`id_informasi`, `tanggal`, `subject`, `pesan`, `id_user`) VALUES
(1, '2022-07-20 07:20:50', 'Ganti Password', 'Demi keamanan, pengguna sistem diharuskan mengganti password', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Administrator'),
(2, 'Staf IT'),
(3, 'Staf Tester'),
(4, 'Staf');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Hardware'),
(2, 'Software'),
(3, 'Request'),
(4, 'Service');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_sub`
--

CREATE TABLE `kategori_sub` (
  `id_sub_kategori` int(11) NOT NULL,
  `nama_sub_kategori` varchar(35) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori_sub`
--

INSERT INTO `kategori_sub` (`id_sub_kategori`, `nama_sub_kategori`, `id_kategori`) VALUES
(1, 'Server', 1),
(2, 'Desktop', 1),
(3, 'Laptop', 1),
(4, 'Printer', 1),
(5, 'SAP', 2),
(6, 'Office \\ Productivity', 2),
(7, 'Nisoft', 2),
(8, 'PI', 2),
(9, 'GDMS', 2),
(10, 'Email Outlook', 2),
(11, 'Others', 2),
(12, 'Data Restore', 3),
(13, 'Password Reset', 3),
(14, 'New User / User Leaving', 3),
(15, 'User / equipment Move or Change', 3),
(16, 'New Software Request', 3),
(17, 'Email', 4),
(18, 'File Storage', 4),
(19, 'Printing', 4),
(20, 'Internet', 4),
(21, 'Intranet', 4),
(22, 'Document Management', 4),
(23, 'Telecommunications', 4),
(24, 'Networking', 4);

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int(11) NOT NULL,
  `lokasi` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `lokasi`) VALUES
(1, 'Lokasi 01'),
(2, 'Lokasi 02'),
(3, 'Lokasi 03');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `nik` varchar(50) NOT NULL DEFAULT '',
  `nama` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `telp` char(25) DEFAULT NULL,
  `id_bagian_dept` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`nik`, `nama`, `email`, `telp`, `id_bagian_dept`, `id_jabatan`) VALUES
('admin', 'Administrator', 'admin@gmail.com', '082123456789', 1, 1),
('aksara', 'Aksara Delana', '-', NULL, 4, 4),
('teknisi', 'Teknisi', '-', NULL, 2, 2),
('tester', 'User Tester', '-', '081234567890', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `prioritas`
--

CREATE TABLE `prioritas` (
  `id_prioritas` int(11) NOT NULL,
  `nama_prioritas` varchar(30) NOT NULL,
  `waktu_respon` int(11) NOT NULL,
  `warna` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prioritas`
--

INSERT INTO `prioritas` (`id_prioritas`, `nama_prioritas`, `waktu_respon`, `warna`) VALUES
(1, 'High', 1, '#B14145'),
(2, 'Medium', 3, '#FC8500'),
(3, 'Low', 5, '#FFB701');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `group_setting` varchar(100) NOT NULL,
  `variable_setting` varchar(255) NOT NULL,
  `value_setting` text NOT NULL,
  `deskripsi_setting` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group_setting`, `variable_setting`, `value_setting`, `deskripsi_setting`, `updated_at`) VALUES
(1, 'app', 'aplikasi', 'TNA Portal', 'Nama Aplikasi', '2025-02-12 14:24:27'),
(2, 'app', 'developer', 'IT TNA 2025', 'Pengembang Aplikasi', '2023-06-17 15:21:28'),
(3, 'app', 'versi', '1.0', 'Versi Aplikasi', '2022-05-19 09:42:25'),
(4, 'general', 'perusahaan', 'PT Tuffindo Nittoku Autoneum', 'Nama Instansi', '2025-02-12 14:24:40'),
(5, 'general', 'alamat', 'Jalan Surya Madya VI Kav. I-46 BC, Kutanegara, Kec. Ciampel Kabupaten Karawang Jawa Barat', 'Alamat', '2025-02-12 14:25:01'),
(6, 'general', 'telepon', '081389156224', 'No Telepon', '2025-02-12 14:25:13'),
(7, 'general', 'email', 'it@tna.co.id', 'Email', '2025-02-12 14:25:22'),
(8, 'image', 'logo', 'kecil.png', 'Logo', '2025-02-12 14:26:11'),
(9, 'email', 'protocol', 'smtp', 'Email Protocol \'mail\', \'sendmail\', or \'smtp\'', NULL),
(10, 'email', 'smtp_host', 'mail.tna.co.id', 'SMTP Host', '2025-02-12 14:26:25'),
(11, 'email', 'smtp_port', '587', 'SMTP Port \'465\' or \'587\'', NULL),
(12, 'email', 'smtp_user', 'it@tna.co.id', 'SMTP User', '2025-02-12 14:26:36'),
(13, 'email', 'smtp_pass', 'phmk5k6', 'SMTP Password', '2025-02-12 14:27:20'),
(14, 'email', 'smtp_crypto', 'ssl', 'SMTP Crypto', NULL),
(15, 'image', 'background', 'PT-Tuffindo-Nittoku-Autoneum-4-Juni.jpg', 'Background', '2025-02-12 14:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `teknisi`
--

CREATE TABLE `teknisi` (
  `id_teknisi` varchar(50) NOT NULL DEFAULT '',
  `nik` varchar(50) NOT NULL DEFAULT '',
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` varchar(13) NOT NULL DEFAULT '',
  `tanggal` datetime DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `tanggal_proses` datetime DEFAULT NULL,
  `tanggal_solved` datetime DEFAULT NULL,
  `reported` varchar(50) NOT NULL DEFAULT '',
  `id_sub_kategori` int(11) NOT NULL,
  `problem_summary` varchar(50) NOT NULL DEFAULT '',
  `problem_detail` text NOT NULL,
  `teknisi` varchar(50) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL,
  `progress` decimal(10,0) NOT NULL,
  `filefoto` text NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `id_prioritas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_message`
--

CREATE TABLE `ticket_message` (
  `id_message` int(11) UNSIGNED NOT NULL,
  `id_ticket` varchar(13) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `filefoto` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id_tracking` int(11) UNSIGNED NOT NULL,
  `id_ticket` varchar(13) NOT NULL DEFAULT '',
  `tanggal` datetime DEFAULT NULL,
  `status` text NOT NULL,
  `deskripsi` text NOT NULL,
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `filefoto` text NOT NULL,
  `signature` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `level` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`) VALUES
(1, 'admin', '25d55ad283aa400af464c76d713c07ad', 'Admin'),
(2, 'teknisi', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(3, 'tester', '25d55ad283aa400af464c76d713c07ad', 'User'),
(4, 'aksara', '25d55ad283aa400af464c76d713c07ad', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id_backup`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id_dept`);

--
-- Indexes for table `departemen_bagian`
--
ALTER TABLE `departemen_bagian`
  ADD PRIMARY KEY (`id_bagian_dept`),
  ADD KEY `fk_id_dept` (`id_dept`);

--
-- Indexes for table `informasi`
--
ALTER TABLE `informasi`
  ADD PRIMARY KEY (`id_informasi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kategori_sub`
--
ALTER TABLE `kategori_sub`
  ADD PRIMARY KEY (`id_sub_kategori`),
  ADD KEY `fk_id_kategori` (`id_kategori`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `fk_id_bagian_dept` (`id_bagian_dept`),
  ADD KEY `fk_id_jabatan` (`id_jabatan`);

--
-- Indexes for table `prioritas`
--
ALTER TABLE `prioritas`
  ADD PRIMARY KEY (`id_prioritas`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teknisi`
--
ALTER TABLE `teknisi`
  ADD PRIMARY KEY (`id_teknisi`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `reported` (`reported`),
  ADD KEY `id_lokasi` (`id_lokasi`),
  ADD KEY `id_sub_kategori` (`id_sub_kategori`);

--
-- Indexes for table `ticket_message`
--
ALTER TABLE `ticket_message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id_tracking`),
  ADD KEY `id_ticket` (`id_ticket`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_nik` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `id_backup` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id_dept` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departemen_bagian`
--
ALTER TABLE `departemen_bagian`
  MODIFY `id_bagian_dept` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id_informasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_sub`
--
ALTER TABLE `kategori_sub`
  MODIFY `id_sub_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prioritas`
--
ALTER TABLE `prioritas`
  MODIFY `id_prioritas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ticket_message`
--
ALTER TABLE `ticket_message`
  MODIFY `id_message` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id_tracking` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `departemen_bagian`
--
ALTER TABLE `departemen_bagian`
  ADD CONSTRAINT `fk_id_dept` FOREIGN KEY (`id_dept`) REFERENCES `departemen` (`id_dept`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `informasi`
--
ALTER TABLE `informasi`
  ADD CONSTRAINT `informasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`username`);

--
-- Constraints for table `kategori_sub`
--
ALTER TABLE `kategori_sub`
  ADD CONSTRAINT `fk_id_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `fk_id_bagian_dept` FOREIGN KEY (`id_bagian_dept`) REFERENCES `departemen_bagian` (`id_bagian_dept`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`reported`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`),
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`id_sub_kategori`) REFERENCES `kategori_sub` (`id_sub_kategori`);

--
-- Constraints for table `ticket_message`
--
ALTER TABLE `ticket_message`
  ADD CONSTRAINT `ticket_message_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_message_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`username`);

--
-- Constraints for table `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `tracking_ibfk_1` FOREIGN KEY (`id_ticket`) REFERENCES `ticket` (`id_ticket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracking_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`username`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_nik` FOREIGN KEY (`username`) REFERENCES `pegawai` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
