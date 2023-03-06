-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2022 at 08:36 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` char(7) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `stok`, `satuan_id`, `jenis_id`) VALUES
('B000001', 'Lenovo Ideapad 1550', 42, 1, 3),
('B000002', 'Samsung Galaxy J1 Ace', 82, 1, 4),
('B000003', 'Aqua 1,5 Liter', 950, 3, 2),
('B000004', 'Mouse Wireless Logitech M220', 10, 1, 7),
('B000005', 'Laptop Oppo Apri', 215, 1, 3),
('B000006', 'Iphone 12 Pro Max', 190, 1, 4),
('B000007', 'Gitar Elektrik Yamaha B99478', 23, 1, 8),
('B000008', 'Kursi Plastik', 126, 1, 9),
('B000009', 'Case Hp Iphone xr', 34, 1, 4),
('B000010', 'batrei iphone', 15, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_barang_keluar` char(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `tanggal_keluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `user_id`, `barang_id`, `jumlah_keluar`, `tanggal_keluar`) VALUES
('T-BK-19082000001', 1, 'B000003', 35, '2019-08-20'),
('T-BK-19082000002', 1, 'B000002', 10, '2019-08-20'),
('T-BK-19092000003', 1, 'B000001', 5, '2019-09-20'),
('T-BK-19092000004', 1, 'B000003', 150, '2019-09-20'),
('T-BK-19092000005', 1, 'B000004', 10, '2019-09-20'),
('T-BK-19092200006', 1, 'B000003', 100, '2019-09-22'),
('T-BK-21110600001', 1, 'B000005', 10, '2021-11-06'),
('T-BK-22010500001', 15, 'B000002', 3, '2022-01-05'),
('T-BK-22010700001', 1, 'B000008', 9, '2022-01-07'),
('T-BK-22010800001', 1, 'B000008', 8, '2022-01-08'),
('T-BK-22011100001', 1, 'B000002', 4, '2022-01-11'),
('T-BK-22011800001', 1, 'B000008', 2, '2022-01-18'),
('T-BK-22011800002', 1, 'B000006', 10, '2022-01-18'),
('T-BK-22020100001', 1, 'B000009', 2, '2022-02-01'),
('T-BK-22020100002', 1, 'B000010', 2, '2022-02-01');

--
-- Triggers `barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `update_stok_keluar` BEFORE INSERT ON `barang_keluar` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` - NEW.jumlah_keluar WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` char(16) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `supplier_id`, `user_id`, `barang_id`, `jumlah_masuk`, `tanggal_masuk`) VALUES
('T-BM-19082000001', 2, 1, 'B000003', 800, '2019-08-20'),
('T-BM-19082000002', 3, 1, 'B000001', 20, '2019-08-20'),
('T-BM-19082000003', 3, 1, 'B000002', 10, '2019-08-20'),
('T-BM-19082000004', 1, 1, 'B000004', 15, '2019-08-20'),
('T-BM-19092000005', 3, 1, 'B000002', 40, '2019-09-20'),
('T-BM-19092000006', 2, 1, 'B000003', 50, '2019-09-20'),
('T-BM-19092200007', 3, 1, 'B000004', 15, '2019-09-22'),
('T-BM-19092200008', 1, 1, 'B000003', 135, '2019-09-22'),
('T-BM-21110600001', 1, 1, 'B000005', 200, '2021-11-06'),
('T-BM-21110600002', 3, 1, 'B000005', 20, '2021-11-06'),
('T-BM-21110700001', 1, 14, 'B000001', 27, '2021-11-07'),
('T-BM-21110700006', 5, 1, 'B000006', 19, '2021-11-07'),
('T-BM-21122700001', 6, 1, 'B000006', 45, '2021-12-27'),
('T-BM-22010500001', 3, 15, 'B000002', 8, '2022-01-05'),
('T-BM-22010800001', 2, 1, 'B000008', 190, '2022-01-08'),
('T-BM-22011300001', 3, 1, 'B000006', 15, '2022-01-13'),
('T-BM-22011300002', 3, 1, 'B000002', 11, '2022-01-13'),
('T-BM-22012300001', 3, 1, 'B000008', 10, '2022-01-23'),
('T-BM-22012300002', 3, 1, 'B000008', 10, '2022-01-23'),
('T-BM-22020100001', 3, 1, 'B000002', 2, '2022-02-01'),
('T-BM-22020100002', 2, 1, 'B000002', 2, '2022-02-01'),
('T-BM-22020100003', 2, 1, 'B000009', 15, '2022-02-01'),
('T-BM-22020100004', 4, 1, 'B000009', 21, '2022-02-01'),
('T-BM-22020100005', 3, 1, 'B000010', 17, '2022-02-01');

--
-- Triggers `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `update_stok_masuk` BEFORE INSERT ON `barang_masuk` FOR EACH ROW UPDATE `barang` SET `barang`.`stok` = `barang`.`stok` + NEW.jumlah_masuk WHERE `barang`.`id_barang` = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_return`
--

CREATE TABLE `barang_return` (
  `id_barang_return` char(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `barang_id` char(16) NOT NULL,
  `jumlah_return` int(11) NOT NULL,
  `tanggal_return` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_return`
--

INSERT INTO `barang_return` (`id_barang_return`, `user_id`, `barang_id`, `jumlah_return`, `tanggal_return`) VALUES
('T-BR-22010500001', 1, 'B000006', 3, '2022-01-05'),
('T-BR-22010500002', 15, 'B000004', 2, '2022-01-05'),
('T-BR-22010700001', 1, 'B000006', 9, '2022-01-07'),
('T-BR-22010700002', 1, 'B000005', 100, '2022-01-07'),
('T-BR-22010700003', 1, 'B000008', 7, '2022-01-07'),
('T-BR-22010700004', 1, 'B000008', 4, '2022-01-07'),
('T-BR-22010700005', 1, 'B000008', 9, '2022-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `nama_jenis`) VALUES
(1, 'Snack'),
(2, 'Minuman'),
(3, 'Laptop'),
(4, 'Handphone'),
(5, 'Sepeda Motor'),
(6, 'Mobil'),
(7, 'Perangkat Komputer'),
(8, 'Alat Musik'),
(9, 'Furniture');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'Unit'),
(2, 'Pack'),
(3, 'Botol');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `no_telp`, `alamat`) VALUES
(1, 'muh ainun', '085688772971', 'Kec. kambu kota kendari'),
(2, 'iksan hasibuan', '081341879246', 'kec.kolaka kab.kolaka'),
(3, 'zaldy fata', '087728164328', 'kec.andolo konawe selatan'),
(4, 'ainil kahdi', '0834772933', 'asrama multazam'),
(5, 'febrianto', '082388349912', 'BTN Batumarupa KDI'),
(6, 'Pandio', '084455667722', 'Kota Kolaka');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `role` enum('gudang','admin','kasir') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `foto` text NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `no_telp`, `role`, `password`, `created_at`, `foto`, `is_active`) VALUES
(1, 'pimpinan', 'pimpinan', 'pimpinan@admin.com', '025123456789', 'admin', '$2y$10$zKoVSPcy.DU2yZQpzOvvIOuglia40kkekEVXjNYh6cgK2vX/Y9OPW', 1568689561, 'd5f22535b639d55be7d099a7315e1f7f.png', 1),
(14, 'admin zul', 'apri', 'alfianapriansyah37@gmail.com', '082393210161', 'gudang', '$2y$10$dUj.lEByNzVzFIn2KpnVJeo0wxB8Vtz7yKEPctVzLV4L1JidR9HKy', 1636257020, '4a5aab21ece5a9c4345a627d17193142.png', 1),
(15, 'ainil kahdi', 'kahdi', 'kahdi@gmail.com', '082393210161', 'gudang', '$2y$10$CMV.KWxysf1siDFFX0RQt.J32MhjHYO81/iELotDcPFkV/L.pOV36', 1636258034, 'user.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `satuan_id` (`satuan_id`),
  ADD KEY `kategori_id` (`jenis_id`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `barang_return`
--
ALTER TABLE `barang_return`
  ADD PRIMARY KEY (`id_barang_return`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`jenis_id`) REFERENCES `jenis` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
