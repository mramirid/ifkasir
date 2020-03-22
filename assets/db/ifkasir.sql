-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 22, 2020 at 09:34 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ifkasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_detail_pembayaran` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty_beli` int(11) NOT NULL,
  `subtotal_beli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `ID_DETAIL_PEN` int(11) NOT NULL,
  `ID_BARANG` int(11) DEFAULT NULL,
  `ID_PENJUALAN` int(11) DEFAULT NULL,
  `HARGA_JUAL` int(11) DEFAULT NULL,
  `QTY_PEN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`ID_DETAIL_PEN`, `ID_BARANG`, `ID_PENJUALAN`, `HARGA_JUAL`, `QTY_PEN`) VALUES
(1, 1, 1, 1000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `keuntungan`
--

CREATE TABLE `keuntungan` (
  `ID_KEUNTUNGAN` int(11) NOT NULL,
  `ID_PENJUALAN` int(11) DEFAULT NULL,
  `ID_PEMBELIAN` int(11) DEFAULT NULL,
  `NOMINAL_KEUNTUNGAN` int(11) DEFAULT NULL,
  `TANGGAL_KEUNTUNGAN` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keuntungan`
--

INSERT INTO `keuntungan` (`ID_KEUNTUNGAN`, `ID_PENJUALAN`, `ID_PEMBELIAN`, `NOMINAL_KEUNTUNGAN`, `TANGGAL_KEUNTUNGAN`) VALUES
(1, 1, 1, 0, '2020-02-01 00:00:00'),
(2, NULL, NULL, 0, '2020-02-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu_pembelian` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qty_suplai` int(11) NOT NULL,
  `total_harga_pembelian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `ID_PENJUALAN` int(11) NOT NULL,
  `ID_KASIR` int(11) DEFAULT NULL,
  `TANGGAL_PENJUALAN` datetime DEFAULT NULL,
  `QTY_PENJUALAN` int(11) DEFAULT NULL,
  `TOTAL_HARGA_PENJUALAN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`ID_PENJUALAN`, `ID_KASIR`, `TANGGAL_PENJUALAN`, `QTY_PENJUALAN`, `TOTAL_HARGA_PENJUALAN`) VALUES
(1, 2, '2020-02-01 00:00:00', 5, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `stock_barang`
--

CREATE TABLE `stock_barang` (
  `id_barang` int(11) NOT NULL,
  `tipe_barang` enum('makanan','minuman') NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `qty_inventory` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `role` enum('admin','kasir') NOT NULL DEFAULT 'kasir',
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `password`, `telefon`, `ktp`, `role`, `status`) VALUES
(6, 'Admin', 'admin@admin.com', '$2y$10$57RqOUmcjWrpBBYf9cl0b.1SNkSTZ6L/nKfkAmS1jlh0DxihWnYNW', '911', '17081010000', 'admin', 'aktif'),
(7, 'Kasir', 'kasir@kasir.com', '$2y$10$1J20ZAuHiIiQgb8b6OYAye7AhPN35Fpx.6/Wb/2W1PYsRnxDERIbC', '911', '17081010001', 'kasir', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_detail_pembayaran`),
  ADD KEY `FK_BARANG_MASUK` (`id_pembelian`),
  ADD KEY `FK_DETAIL_MEMBELI` (`id_barang`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`ID_DETAIL_PEN`),
  ADD KEY `FK_DETAIL_JUAL` (`ID_BARANG`),
  ADD KEY `FK_DETAI_MENJUAL` (`ID_PENJUALAN`);

--
-- Indexes for table `keuntungan`
--
ALTER TABLE `keuntungan`
  ADD PRIMARY KEY (`ID_KEUNTUNGAN`),
  ADD KEY `FK_KEUNTUNGAN_PEMBELIAN` (`ID_PEMBELIAN`),
  ADD KEY `FK_KEUNTUNGAN_PENJUALAN` (`ID_PENJUALAN`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `FK_NOTA_BELI` (`id_user`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`ID_PENJUALAN`),
  ADD KEY `FK_NOTA_JUAL` (`ID_KASIR`);

--
-- Indexes for table `stock_barang`
--
ALTER TABLE `stock_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id_detail_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_barang`
--
ALTER TABLE `stock_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
