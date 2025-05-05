-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2025 at 10:32 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
  `id_backup` int NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id_dept` int NOT NULL,
  `nama_dept` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id_dept`, `nama_dept`) VALUES
(1, 'Purchasing'),
(2, 'Information Technology'),
(3, 'Maintenance'),
(4, 'Produksi'),
(5, 'QC/QA'),
(6, 'Marketing'),
(7, 'Engineering'),
(8, 'HRGA'),
(9, 'WH/PPIC'),
(10, 'Finance');

-- --------------------------------------------------------

--
-- Table structure for table `departemen_bagian`
--

CREATE TABLE `departemen_bagian` (
  `id_bagian_dept` int NOT NULL,
  `nama_bagian_dept` varchar(100) NOT NULL,
  `id_dept` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `departemen_bagian`
--

INSERT INTO `departemen_bagian` (`id_bagian_dept`, `nama_bagian_dept`, `id_dept`) VALUES
(1, 'QA', 5),
(2, 'IT', 2),
(3, 'Tester', 3),
(4, 'Produksi', 4),
(5, 'QC', 5),
(6, 'PPIC', 9),
(7, 'General affair', 8),
(8, 'Warehouse', 9),
(9, 'Marketing', 6),
(10, 'Purchasing', 1),
(11, 'Maintenance', 3),
(12, 'Engineering', 7),
(13, 'Finance', 10);

-- --------------------------------------------------------

--
-- Table structure for table `informasi`
--

CREATE TABLE `informasi` (
  `id_informasi` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `subject` varchar(35) NOT NULL,
  `pesan` varchar(250) NOT NULL,
  `id_user` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  `id_jabatan` int NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`) VALUES
(1, 'Administrator'),
(2, 'Staf IT'),
(3, 'Leader'),
(4, 'Staf'),
(5, 'Supervisor'),
(6, 'Manager'),
(7, 'Operator');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Repair'),
(2, 'Request'),
(3, 'Fabrikasi'),
(4, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_sub`
--

CREATE TABLE `kategori_sub` (
  `id_sub_kategori` int NOT NULL,
  `nama_sub_kategori` varchar(35) NOT NULL,
  `id_kategori` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `kategori_sub`
--

INSERT INTO `kategori_sub` (`id_sub_kategori`, `nama_sub_kategori`, `id_kategori`) VALUES
(2, 'Desktop', 2),
(3, 'Laptop', 2),
(10, 'Email Outlook', 2),
(15, 'Dies', 3),
(16, 'Jig', 3),
(17, 'Building', 3),
(19, 'Repair Mesin', 1),
(26, 'Mesin', 3),
(27, 'Repair dies', 1),
(28, 'Repair jig', 1),
(29, 'Repair building', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int NOT NULL,
  `lokasi` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `lokasi`) VALUES
(1, 'Rull'),
(2, 'Carpet'),
(3, 'NVH'),
(4, 'Office lt 2'),
(5, 'Office Finance'),
(6, 'Aspalt'),
(7, 'Warehouse'),
(8, 'Office warehouse'),
(9, 'Office QC/QA'),
(10, 'Office Produksi');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `nik` varchar(50) NOT NULL DEFAULT '',
  `nama` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `telp` char(25) DEFAULT NULL,
  `id_bagian_dept` int NOT NULL,
  `id_jabatan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`nik`, `nama`, `email`, `telp`, `id_bagian_dept`, `id_jabatan`) VALUES
('001', 'Marcell', 'tna_maintenance@outlook.com', '085156290937', 11, 6),
('002', 'Yulius ', 'tna_hrga@outlook.com', '085156290937', 11, 5),
('003', 'Afiatin', 'tna_ppic@outlook.co.id', '081234567899', 11, 4),
('004', 'Wawan Darmawan', '-', '-', 11, 3),
('005', 'Yanto', '-', '-', 11, 3),
('006', 'Husyen', '-', '-', 11, 7),
('007', 'Faiq', 'tna_marketing@outlook.com', '-', 11, 7),
('020', 'Luthfi', 'luthfinaufalrusdiyanto@gmail.com', '081389156224', 2, 2),
('021', 'Teguh', 'tna_qc@outlook.com', '-', 5, 7),
('022', 'Julio', 'tna_produksi@outlook.com', '-', 5, 5),
('024', 'Hafiz', '-', '08997286166', 4, 5),
('025', 'Imelda', 'produksi@tna.co.id', '081389156224', 4, 7),
('026', 'Irdam', 'produksi@tna.co.id', '081389156224', 4, 7),
('admin', 'Efedi', '-', '-', 11, 7),
('aksara', 'Bahri', '-', '-', 11, 4),
('it', 'It', 'it@tna.co.id', '', 2, 1),
('tester', 'Eko', '-', '-', 11, 7);

-- --------------------------------------------------------

--
-- Table structure for table `prioritas`
--

CREATE TABLE `prioritas` (
  `id_prioritas` int NOT NULL,
  `nama_prioritas` varchar(30) NOT NULL,
  `waktu_respon` int NOT NULL,
  `warna` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `prioritas`
--

INSERT INTO `prioritas` (`id_prioritas`, `nama_prioritas`, `waktu_respon`, `warna`) VALUES
(1, 'High', 2, '#F50A12'),
(2, 'Medium', 5, '#FC8500'),
(3, 'Low', 14, '#FFB701');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `group_setting` varchar(100) NOT NULL,
  `variable_setting` varchar(255) NOT NULL,
  `value_setting` text NOT NULL,
  `deskripsi_setting` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `group_setting`, `variable_setting`, `value_setting`, `deskripsi_setting`, `updated_at`) VALUES
(1, 'app', 'aplikasi', 'Portal', 'Nama Aplikasi', '2025-03-21 09:14:07'),
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
  `id_kategori` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  `id_sub_kategori` int NOT NULL,
  `due_date` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `problem_summary` varchar(50) NOT NULL DEFAULT '',
  `problem_detail` text NOT NULL,
  `teknisi` varchar(50) NOT NULL DEFAULT '',
  `status` int NOT NULL,
  `progress` decimal(10,0) NOT NULL,
  `filefoto` text NOT NULL,
  `id_lokasi` int NOT NULL,
  `id_prioritas` int NOT NULL,
  `assign_to` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `tanggal`, `deadline`, `last_update`, `tanggal_proses`, `tanggal_solved`, `reported`, `id_sub_kategori`, `due_date`, `problem_summary`, `problem_detail`, `teknisi`, `status`, `progress`, `filefoto`, `id_lokasi`, `id_prioritas`, `assign_to`) VALUES
('7OoB2jYIM', '2025-04-22 15:57:07', '2025-04-24 15:57:07', '2025-04-22 16:36:44', '2025-04-22 16:36:44', NULL, '021', 17, '1 jam', 'Perbaikan apa aja deh', 'Perbaikan mesin nvh', '007', 4, '0', 'Screenshot_2025-03-17_0814566.png', 3, 1, 'SPVM'),
('eu10dof2Y', '2025-03-21 14:54:20', '2025-03-23 14:54:20', '2025-04-22 14:35:56', '2025-03-21 15:01:19', '2025-04-22 14:35:56', '021', 17, '1 jam', 'Perbaikan mesin', 'Perbaikan mesin nvh', '007', 7, '100', 'OIP.jpg', 6, 1, 'SPVU'),
('HpKtiPshG', '2025-04-09 23:13:07', '2025-04-11 23:13:07', '2025-04-09 23:20:54', '2025-04-09 23:19:00', '2025-04-09 23:20:54', '021', 19, '24 jam', 'Repair mesin aspalt', 'Repair mesin aspalt', '007', 6, '100', '6.png', 6, 1, 'SPVU'),
('JcgaQ1W3d', '2025-04-17 13:13:46', '2025-04-19 13:13:46', '2025-04-17 13:25:21', '2025-04-17 13:25:21', NULL, '021', 17, '1 hari', 'Perbaikan dies', 'Perbaikan dies aspalt', '007', 4, '0', '17224068635282.jpg', 6, 1, 'SPVU'),
('PfABgOce8', '2025-04-17 14:09:41', '2025-04-19 14:09:41', '2025-04-17 14:23:08', '2025-04-17 14:23:08', NULL, '021', 17, '2 hari', 'Perbaikan dies  nvh', 'Perbaikan dies  nvh', '007', 4, '0', 'Pink_Biru_Ilustrasi_Privasi_Aksesibilitas_Presentasi2.jpg', 3, 1, 'SPVU'),
('rC6GQMLpF', '2025-03-21 13:08:29', '1970-01-01 07:00:00', '2025-03-21 13:17:38', '2025-03-21 13:14:19', '2025-03-21 13:17:38', '021', 17, '7 hari', 'Fabrikasi machine', 'Fabrikasi machine nvh', '007', 7, '100', 'no-image.jpg', 6, 1, 'SPVU'),
('tOe3wGupc', '2025-04-22 16:59:06', NULL, '2025-04-22 17:01:44', NULL, NULL, '026', 15, '1 jam', 'Perbaikan nvh', 'Perbaikan nvh', '', 8, '0', 'Pink_Biru_Ilustrasi_Privasi_Aksesibilitas_Presentasi7.jpg', 2, 0, NULL),
('zG8Pr3h1y', '2025-04-16 13:15:05', '2025-04-21 13:15:05', '2025-04-16 13:31:37', '2025-04-16 13:29:04', '2025-04-16 13:31:37', '021', 15, '1 minggu', 'Perbaikan dies', 'Perbaikan dies aspalt', '007', 6, '100', 'Pink_Biru_Ilustrasi_Privasi_Aksesibilitas_Presentasi.jpg', 6, 2, 'SPVU');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_message`
--

CREATE TABLE `ticket_message` (
  `id_message` int UNSIGNED NOT NULL,
  `id_ticket` varchar(13) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `filefoto` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ticket_message`
--

INSERT INTO `ticket_message` (`id_message`, `id_ticket`, `tanggal`, `status`, `message`, `id_user`, `filefoto`) VALUES
(2, 'HpKtiPshG', '2025-04-09 23:17:25', 1, 'gas keun', '021', NULL),
(3, 'HpKtiPshG', '2025-04-09 23:22:47', 1, 'bang ini belum selesai', '021', '1.png'),
(4, 'zG8Pr3h1y', '2025-04-16 13:30:26', 1, 'eh salah', '007', 'Pink_Biru_Ilustrasi_Privasi_Aksesibilitas_Presentasi1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id_tracking` int UNSIGNED NOT NULL,
  `id_ticket` varchar(13) NOT NULL DEFAULT '',
  `tanggal` datetime DEFAULT NULL,
  `status` text NOT NULL,
  `deskripsi` text NOT NULL,
  `id_user` varchar(50) NOT NULL DEFAULT '',
  `filefoto` text NOT NULL,
  `signature` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tracking`
--

INSERT INTO `tracking` (`id_tracking`, `id_ticket`, `tanggal`, `status`, `deskripsi`, `id_user`, `filefoto`, `signature`) VALUES
(61, 'rC6GQMLpF', '2025-03-21 13:08:29', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Fabrikasi machine nvh', '021', '', NULL),
(62, 'rC6GQMLpF', '2025-03-21 13:09:48', 'Ticket Approved', 'Approved by Supervisor Dept', '022', '', NULL),
(63, 'rC6GQMLpF', '2025-03-21 13:11:54', 'Ticket Assign To', 'Ticket Assign to SPVU', '001', '', NULL),
(64, 'rC6GQMLpF', '2025-03-21 13:13:17', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '002', '', NULL),
(65, 'rC6GQMLpF', '2025-03-21 13:14:19', 'On Process', '', '007', '', NULL),
(66, 'rC6GQMLpF', '2025-03-21 13:17:38', 'Ticket Closed. Progress: 100 %', 'Done ', '007', 'OIP.jpg', '67dd048300265.png'),
(67, 'eu10dof2Y', '2025-03-21 14:54:20', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Perbaikan mesin nvh', '021', '', NULL),
(68, 'eu10dof2Y', '2025-03-21 14:55:43', 'Ticket Approved', 'Approved by Supervisor Dept', '022', '', NULL),
(69, 'eu10dof2Y', '2025-03-21 14:58:16', 'Ticket Assign To', 'Ticket Assign to SPVU', '001', '', NULL),
(70, 'eu10dof2Y', '2025-03-21 14:59:43', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '002', '', NULL),
(71, 'eu10dof2Y', '2025-03-21 15:01:19', 'On Process', '', '007', '', NULL),
(72, 'eu10dof2Y', '2025-03-21 15:02:02', 'Ticket Closed. Progress: 100 %', 'Oke sudah selesai', '007', 'OIP1.jpg', '67dd1cfa34b67.png'),
(85, 'HpKtiPshG', '2025-04-09 23:13:07', 'Ticket Submited. Kategori: Repair(Repair Mesin)', 'Repair mesin aspalt', '021', '', NULL),
(86, 'HpKtiPshG', '2025-04-09 23:13:33', 'Ticket Approved', 'Approved by Supervisor Dept', '022', '', NULL),
(87, 'HpKtiPshG', '2025-04-09 23:14:04', 'Ticket Assign To', 'Ticket Assign to SPVU', '001', '', NULL),
(88, 'HpKtiPshG', '2025-04-09 23:14:44', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '002', '', NULL),
(89, 'HpKtiPshG', '2025-04-09 23:18:26', 'Pending', '', '007', '', NULL),
(90, 'HpKtiPshG', '2025-04-09 23:19:00', 'On Process', '', '007', '', NULL),
(91, 'HpKtiPshG', '2025-04-09 23:20:54', 'Ticket Closed. Progress: 100 %', 'Sudah selesai ya', '007', 'WhatsApp_Image_2025-04-09_at_22_37_12.jpeg', '67f69e660d198.png'),
(100, 'zG8Pr3h1y', '2025-04-16 13:15:05', 'Ticket Submited. Kategori: Fabrikasi(Dies)', 'Perbaikan dies aspalt', '021', '', NULL),
(101, 'zG8Pr3h1y', '2025-04-16 13:18:17', 'Ticket Approved', 'Approved by Supervisor Dept', '022', '', NULL),
(102, 'zG8Pr3h1y', '2025-04-16 13:21:12', 'Ticket Assign To', 'Ticket Assign to SPVU', '001', '', NULL),
(103, 'zG8Pr3h1y', '2025-04-16 13:23:24', 'Ticket Received', 'Priority of the ticket is set to Medium and assigned to technician.', '002', '', NULL),
(104, 'zG8Pr3h1y', '2025-04-16 13:29:04', 'On Process', '', '007', '', NULL),
(105, 'zG8Pr3h1y', '2025-04-16 13:31:37', 'Ticket Closed. Progress: 100 %', 'Sudah selesai', '007', 'Pink_Biru_Ilustrasi_Privasi_Aksesibilitas_Presentasi.jpg', '67ff4ec9c241c.png'),
(106, 'JcgaQ1W3d', '2025-04-17 13:13:47', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Perbaikan dies aspalt', '021', '', NULL),
(107, 'JcgaQ1W3d', '2025-04-17 13:14:30', 'Ticket Approved', 'Approved by Supervisor Dept', '022', '', NULL),
(108, 'JcgaQ1W3d', '2025-04-17 13:19:48', 'Ticket Returned', 'cat nya tidak ada', '001', '', NULL),
(109, 'JcgaQ1W3d', '2025-04-17 13:21:39', 'Ticket Approved', 'Approved by Supervisor Dept', '022', '', NULL),
(110, 'JcgaQ1W3d', '2025-04-17 13:22:24', 'Ticket Assign To', 'Ticket Assign to SPVU', '001', '', NULL),
(111, 'JcgaQ1W3d', '2025-04-17 13:23:15', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '002', '', NULL),
(112, 'JcgaQ1W3d', '2025-04-17 13:25:21', 'On Process', '', '007', '', NULL),
(113, 'eu10dof2Y', '2025-04-17 13:25:56', 'Ticket Closed. Progress: 100 %', 'Sudah selesai', '007', '1722406863528.jpg', '68009ef4e91c9.png'),
(114, 'PfABgOce8', '2025-04-17 14:09:41', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Perbaikan dies  nvh', '021', '', NULL),
(115, 'PfABgOce8', '2025-04-17 14:10:36', 'Ticket Approved', 'Approved by Supervisor Dept', '022', '', NULL),
(116, 'PfABgOce8', '2025-04-17 14:15:25', 'Ticket Returned', 'cat habis', '001', '', NULL),
(117, 'PfABgOce8', '2025-04-17 14:16:14', 'Ticket Approved', 'Approved by Supervisor Dept', '022', '', NULL),
(118, 'PfABgOce8', '2025-04-17 14:17:21', 'Ticket Assign To', 'Ticket Assign to SPVU', '001', '', NULL),
(119, 'PfABgOce8', '2025-04-17 14:20:41', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '002', '', NULL),
(120, 'PfABgOce8', '2025-04-17 14:23:08', 'On Process', '', '007', '', NULL),
(121, 'eu10dof2Y', '2025-04-17 14:23:33', 'Ticket Closed. Progress: 100 %', 'Selesai', '007', '1734264497234.jpg', '6800ac75c8535.png'),
(144, 'eu10dof2Y', '2025-04-22 14:35:56', 'Ticket Closed. Progress: 100 %', 'Sudah selesai', '007', '17342644972341.jpg', '680746dca0cf5.png'),
(145, '7OoB2jYIM', '2025-04-22 15:57:07', 'Ticket Submited. Kategori: Fabrikasi(Building)', 'Perbaikan mesin nvh', '021', '', NULL),
(146, '7OoB2jYIM', '2025-04-22 16:15:59', 'Ticket Approved', 'Approved by Supervisor Dept', '022', '', NULL),
(147, '7OoB2jYIM', '2025-04-22 16:21:16', 'Ticket Assign To', 'Ticket Assign to SPVM', '001', '', NULL),
(148, '7OoB2jYIM', '2025-04-22 16:32:16', 'Ticket Received', 'Priority of the ticket is set to High and assigned to technician.', '003', '', NULL),
(149, '7OoB2jYIM', '2025-04-22 16:36:19', 'Pending', '', '007', '', NULL),
(150, '7OoB2jYIM', '2025-04-22 16:36:44', 'On Process', '', '007', '', NULL),
(151, 'tOe3wGupc', '2025-04-22 16:59:06', 'Ticket Submited. Kategori: Fabrikasi(Dies)', 'Perbaikan nvh', '026', '', NULL),
(152, 'tOe3wGupc', '2025-04-22 17:01:44', 'Ticket Approved', 'Approved by Supervisor Dept', '025', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `level` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`) VALUES
(1, 'admin', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(3, 'tester', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(4, 'aksara', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(5, '001', '25d55ad283aa400af464c76d713c07ad', 'MGR'),
(6, '002', '25d55ad283aa400af464c76d713c07ad', 'SPVU'),
(7, '003', '25d55ad283aa400af464c76d713c07ad', 'SPVM'),
(8, '004', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(9, '005', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(10, '006', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(11, '007', '25d55ad283aa400af464c76d713c07ad', 'Technician'),
(12, '021', '25d55ad283aa400af464c76d713c07ad', 'User'),
(13, '022', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(14, 'it', '25d55ad283aa400af464c76d713c07ad', 'Admin'),
(15, '024', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(17, '025', '25d55ad283aa400af464c76d713c07ad', 'SPV'),
(18, '026', '25d55ad283aa400af464c76d713c07ad', 'User');

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
  MODIFY `id_backup` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id_dept` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `departemen_bagian`
--
ALTER TABLE `departemen_bagian`
  MODIFY `id_bagian_dept` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `informasi`
--
ALTER TABLE `informasi`
  MODIFY `id_informasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_sub`
--
ALTER TABLE `kategori_sub`
  MODIFY `id_sub_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `prioritas`
--
ALTER TABLE `prioritas`
  MODIFY `id_prioritas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ticket_message`
--
ALTER TABLE `ticket_message`
  MODIFY `id_message` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id_tracking` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
