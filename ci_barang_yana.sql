-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2023 at 04:05 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

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
('B000002', 'Samsung Galaxy J1 Ace', 98, 1, 4),
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
  `tanggal_keluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `user_id`, `tanggal_keluar`) VALUES
('T-BK-19082000001', 1, '2019-08-20'),
('T-BK-23030600001', 1, '2023-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` varchar(16) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `supplier_id`, `user_id`, `tanggal_masuk`) VALUES
('T-BM-21122700001', 6, 1, '2021-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `barang_return`
--

CREATE TABLE `barang_return` (
  `id_barang_return` char(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_return` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_return`
--

INSERT INTO `barang_return` (`id_barang_return`, `user_id`, `tanggal_return`) VALUES
('T-BR-22010500001', 1, '2022-01-05'),
('T-BR-22010500002', 15, '2022-01-05'),
('T-BR-22010700001', 1, '2022-01-07'),
('T-BR-22010700002', 1, '2022-01-07'),
('T-BR-22010700003', 1, '2022-01-07'),
('T-BR-22010700004', 1, '2022-01-07'),
('T-BR-22010700005', 1, '2022-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `detail_barang_keluar`
--

CREATE TABLE `detail_barang_keluar` (
  `id_detail_barang_keluar` int(12) NOT NULL,
  `id_barang_keluar` varchar(100) NOT NULL,
  `barang_id` varchar(12) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_barang_keluar`
--

INSERT INTO `detail_barang_keluar` (`id_detail_barang_keluar`, `id_barang_keluar`, `barang_id`, `jumlah_masuk`) VALUES
(1, 'T-BK-19082000001', 'B000001', 20),
(8, 'T-BK-19082000001', 'B000004', 2),
(9, 'T-BK-19082000001', 'B000002', 7),
(10, 'T-BK-19082000001', 'B000003', 3),
(11, 'T-BK-19082000001', 'B000003', 1),
(12, 'T-BK-19082000001', 'B000003', 6),
(13, 'T-BK-19082000001', 'B000001', 4),
(14, 'T-BK-19082000001', 'B000010', 5),
(15, 'T-BK-23030600001', 'B000002', 5);

-- --------------------------------------------------------

--
-- Table structure for table `detail_barang_masuk`
--

CREATE TABLE `detail_barang_masuk` (
  `id_detail_barang_masuk` int(15) NOT NULL,
  `id_barang_masuk` varchar(16) NOT NULL,
  `barang_id` varchar(15) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_barang_masuk`
--

INSERT INTO `detail_barang_masuk` (`id_detail_barang_masuk`, `id_barang_masuk`, `barang_id`, `jumlah_masuk`) VALUES
(123123124, 'T-BM-21122700001', 'B000001', 20),
(123123126, 'T-BM-21122700001', 'B000002', 10),
(123123127, 'T-BM-21122700001', 'B000001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_barang_return`
--

CREATE TABLE `detail_barang_return` (
  `id_detail_barang_return` int(12) NOT NULL,
  `id_barang_return` varchar(15) NOT NULL,
  `barang_id` varchar(15) NOT NULL,
  `jumlah_masuk` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'pimpinan', 'pimpinan', 'pimpinan@admin.com', '025123456789', 'admin', '$2y$10$zKoVSPcy.DU2yZQpzOvvIOuglia40kkekEVXjNYh6cgK2vX/Y9OPW', 1568689561, 'e5865de924059921e071878865a6e8be.PNG', 1),
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
  ADD KEY `id_user` (`user_id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_user` (`user_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `barang_return`
--
ALTER TABLE `barang_return`
  ADD PRIMARY KEY (`id_barang_return`);

--
-- Indexes for table `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  ADD PRIMARY KEY (`id_detail_barang_keluar`),
  ADD KEY `id_barang_keluar_2` (`id_barang_keluar`);
ALTER TABLE `detail_barang_keluar` ADD FULLTEXT KEY `id_barang_keluar` (`id_barang_keluar`);

--
-- Indexes for table `detail_barang_masuk`
--
ALTER TABLE `detail_barang_masuk`
  ADD PRIMARY KEY (`id_detail_barang_masuk`),
  ADD KEY `id_barang_masuk` (`id_barang_masuk`) USING BTREE;

--
-- Indexes for table `detail_barang_return`
--
ALTER TABLE `detail_barang_return`
  ADD PRIMARY KEY (`id_detail_barang_return`),
  ADD UNIQUE KEY `id_barang_return` (`id_barang_return`);

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
-- AUTO_INCREMENT for table `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  MODIFY `id_detail_barang_keluar` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `detail_barang_masuk`
--
ALTER TABLE `detail_barang_masuk`
  MODIFY `id_detail_barang_masuk` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123123128;

--
-- AUTO_INCREMENT for table `detail_barang_return`
--
ALTER TABLE `detail_barang_return`
  MODIFY `id_detail_barang_return` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
