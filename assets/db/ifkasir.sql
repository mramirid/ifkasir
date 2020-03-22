-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 22, 2020 at 08:49 PM
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
  `id_detail_pembelian` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty_beli` int(11) NOT NULL,
  `subtotal_beli` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_detail_pembelian`, `id_pembelian`, `id_barang`, `qty_beli`, `subtotal_beli`) VALUES
(3, 3, 3, 100, 500000),
(4, 4, 4, 60, 180000),
(8, 3, 2, 10, 30000),
(9, 5, 5, 3, 15000);

--
-- Triggers `detail_pembelian`
--
DELIMITER $$
CREATE TRIGGER `hitung_subtotal_beli` BEFORE INSERT ON `detail_pembelian` FOR EACH ROW BEGIN
	# ---- Hitung Subtotal ----
	DECLARE harga_barang INT DEFAULT 0;
	SET harga_barang = (SELECT harga_jual FROM stock_barang WHERE id_barang = NEW.id_barang LIMIT 1);

	SET NEW.subtotal_beli = NEW.qty_beli * harga_barang;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_qty_barang` AFTER INSERT ON `detail_pembelian` FOR EACH ROW BEGIN
	# Update qty barang di tabel stock_barang
	UPDATE stock_barang
	SET qty_inventory = qty_inventory + NEW.qty_beli
	WHERE id_barang = NEW.id_barang;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_harga_pembelian` AFTER INSERT ON `detail_pembelian` FOR EACH ROW # ---- Hitung Total Harga ----
UPDATE pembelian
SET total_harga = total_harga + NEW.subtotal_beli
WHERE id_pembelian = NEW.id_pembelian
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail_penjualan` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty_jual` int(11) NOT NULL,
  `subtotal_jual` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail_penjualan`, `id_penjualan`, `id_barang`, `qty_jual`, `subtotal_jual`) VALUES
(2, 1, 3, 34, 170000),
(3, 1, 4, 3, 15000),
(4, 2, 4, 2, 10000),
(5, 2, 2, 1, 3000),
(7, 3, 4, 6, 30000);

--
-- Triggers `detail_penjualan`
--
DELIMITER $$
CREATE TRIGGER `hitung_subtotal_jual` BEFORE INSERT ON `detail_penjualan` FOR EACH ROW BEGIN
	# ---- Hitung Subtotal ----
	DECLARE harga_barang INT DEFAULT 0;
	SET harga_barang = (SELECT harga_jual FROM stock_barang WHERE id_barang = NEW.id_barang LIMIT 1);

	SET NEW.subtotal_jual = NEW.qty_jual * harga_barang;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `kurangi_qty_barang` BEFORE INSERT ON `detail_penjualan` FOR EACH ROW UPDATE stock_barang
SET qty_inventory = qty_inventory - NEW.qty_jual
WHERE id_barang = NEW.id_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_harga_penjualan` AFTER INSERT ON `detail_penjualan` FOR EACH ROW UPDATE penjualan
SET total_harga = total_harga + NEW.subtotal_jual
WHERE id_penjualan = NEW.id_penjualan
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_pesanan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty_pesanan` int(11) NOT NULL,
  `subtotal_pesanan` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_pesanan`, `id_barang`, `qty_pesanan`, `subtotal_pesanan`) VALUES
(1, 4, 5, 25000);

--
-- Triggers `keranjang`
--
DELIMITER $$
CREATE TRIGGER `hitung_subtotal_pesanan` BEFORE INSERT ON `keranjang` FOR EACH ROW BEGIN
	# ---- Hitung Subtotal ----
	DECLARE harga_barang INT DEFAULT 0;
	SET harga_barang = (SELECT harga_jual FROM stock_barang WHERE id_barang = NEW.id_barang LIMIT 1);

	SET NEW.subtotal_pesanan = NEW.qty_pesanan * harga_barang;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `keuntungan`
--

CREATE TABLE `keuntungan` (
  `id_keuntungan` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `nominal_keuntungan` int(11) NOT NULL,
  `tanggal_keuntungan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu_pembelian` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_harga` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_user`, `waktu_pembelian`, `total_harga`) VALUES
(3, 2, '2020-03-22 22:11:22', 45000),
(4, 2, '2020-03-22 22:16:17', 180000),
(5, 1, '2020-03-23 03:03:08', 15000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu_penjualan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_harga` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `waktu_penjualan`, `total_harga`) VALUES
(1, 1, '2020-03-22 22:20:30', 185000),
(2, 2, '2020-03-22 23:03:07', 33000),
(3, 2, '2020-03-23 03:11:08', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `stock_barang`
--

CREATE TABLE `stock_barang` (
  `id_barang` int(11) NOT NULL,
  `tipe_barang` enum('makanan','minuman') NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `qty_inventory` int(11) NOT NULL DEFAULT '0',
  `harga_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_barang`
--

INSERT INTO `stock_barang` (`id_barang`, `tipe_barang`, `nama_barang`, `qty_inventory`, `harga_jual`) VALUES
(2, 'minuman', 'Teh Sariwangi', 11, 3000),
(3, 'makanan', 'Indomie Goreng', 66, 5000),
(4, 'makanan', 'Indomie Kare Spesial', 49, 5000),
(5, 'minuman', 'Good Day Freeze', 3, 5000),
(6, 'minuman', 'Extra Joss', 0, 4000);

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
  ADD PRIMARY KEY (`id_detail_pembelian`),
  ADD KEY `FK_BARANG_MASUK` (`id_pembelian`),
  ADD KEY `FK_DETAIL_MEMBELI` (`id_barang`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail_penjualan`),
  ADD KEY `FK_DETAIL_JUAL` (`id_penjualan`),
  ADD KEY `FK_DETAI_MENJUAL` (`id_barang`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `keuntungan`
--
ALTER TABLE `keuntungan`
  ADD PRIMARY KEY (`id_keuntungan`),
  ADD KEY `FK_KEUNTUNGAN_PEMBELIAN` (`id_pembelian`),
  ADD KEY `FK_KEUNTUNGAN_PENJUALAN` (`id_penjualan`);

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
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `FK_NOTA_JUAL` (`id_user`);

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
  MODIFY `id_detail_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `keuntungan`
--
ALTER TABLE `keuntungan`
  MODIFY `id_keuntungan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_barang`
--
ALTER TABLE `stock_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
