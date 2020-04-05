-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 05, 2020 at 09:55 AM
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
  `id_pembelian` varchar(64) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty_beli` int(11) NOT NULL,
  `subtotal_beli` int(11) NOT NULL DEFAULT '0',
  `subtotal_rugi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_detail_pembelian`, `id_pembelian`, `id_barang`, `qty_beli`, `subtotal_beli`, `subtotal_rugi`) VALUES
(16, '78066ff333a2d46528d18bbe03a19e2a', 2, 4, 5000, 0),
(18, 'b8fb1d5198926d7ab9daa76a4d8d8f15', 2, 4, 5000, 4000);

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
(12, 18, 2, 1, 3000),
(13, 18, 3, 4, 20000),
(14, 20, 2, 3, 9000),
(15, 20, 3, 5, 25000),
(16, 21, 4, 3, 15000),
(17, 21, 3, 4, 20000),
(18, 22, 2, 1, 3000),
(19, 22, 3, 4, 20000),
(20, 23, 3, 3, 15000),
(21, 24, 3, 1, 5000),
(22, 25, 4, 4, 20000),
(23, 25, 5, 2, 10000),
(24, 26, 3, 2, 10000),
(25, 27, 3, 2, 10000),
(26, 28, 3, 3, 15000),
(27, 29, 3, 3, 15000),
(28, 30, 3, 2, 10000),
(29, 30, 4, 1, 5000),
(30, 43, 3, 2, 10000),
(31, 43, 4, 3, 15000),
(32, 44, 3, 4, 20000),
(33, 46, 3, 1, 5000),
(34, 49, 3, 2, 10000),
(35, 50, 3, 3, 15000),
(36, 50, 4, 3, 15000),
(37, 51, 3, 2, 10000),
(38, 51, 4, 3, 15000),
(39, 52, 3, 12, 60000),
(40, 52, 4, 8, 40000),
(41, 53, 3, 3, 15000),
(42, 54, 3, 4, 20000),
(43, 54, 5, 3, 15000),
(44, 55, 3, 3, 15000),
(45, 55, 6, 5, 20000),
(46, 56, 6, 6, 24000);

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
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty_pesanan` int(11) NOT NULL,
  `subtotal_pesanan` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `id_pembelian` varchar(64) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `waktu_pembelian` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `banyak_barang` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL DEFAULT '0',
  `total_rugi` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_user`, `nama_toko`, `waktu_pembelian`, `banyak_barang`, `total_harga`, `total_rugi`, `status`) VALUES
('b8fb1d5198926d7ab9daa76a4d8d8f15', 6, 'Kacong Store', '2020-04-05 09:25:26', 4, 5000, 4000, 1);

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
(18, 6, '2020-03-25 12:35:25', 23000),
(20, 7, '2020-03-25 12:58:07', 34000),
(21, 7, '2020-03-25 13:00:18', 35000),
(22, 6, '2020-03-25 13:01:10', 23000),
(23, 6, '2020-03-25 13:16:37', 15000),
(24, 6, '2020-03-25 13:17:36', 5000),
(25, 6, '2020-03-25 13:18:36', 30000),
(26, 6, '2020-03-25 13:21:00', 10000),
(27, 6, '2020-03-25 13:22:07', 10000),
(28, 6, '2020-03-25 13:23:30', 15000),
(29, 6, '2020-03-25 13:29:25', 15000),
(30, 7, '2020-03-25 13:31:17', 15000),
(43, 7, '2020-03-25 13:52:32', 25000),
(44, 7, '2020-03-25 13:55:01', 20000),
(46, 7, '2020-03-25 14:01:50', 5000),
(49, 7, '2020-03-25 14:03:38', 10000),
(50, 14, '2020-03-26 00:22:16', 30000),
(51, 6, '2020-03-26 10:17:00', 25000),
(52, 6, '2020-03-26 14:53:58', 100000),
(53, 6, '2020-03-31 00:32:08', 15000),
(54, 6, '2020-04-01 22:10:32', 35000),
(55, 6, '2020-04-05 16:49:45', 35000),
(56, 6, '2020-04-05 16:50:23', 24000);

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
(2, 'minuman', 'Teh Sariwangi', 60, 3000),
(3, 'makanan', 'Indomie Goreng', 65, 5000),
(4, 'makanan', 'Indomie Kare Spesial', 24, 5000),
(5, 'minuman', 'Good Day Freeze', 81, 5000),
(6, 'minuman', 'Extra Joss', 139, 4000),
(7, 'minuman', 'Beng Beng', 53, 5000),
(8, 'minuman', 'Hilo Milk', 89, 7000);

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
(6, 'Administrator', 'admin@admin.com', '$2y$10$VxFzBtDgQviH9q/IqS3dS.TpaW6sxT31vjJdqE4oLgtyQFuQQvBSq', '911', '17081010000', 'admin', 'aktif'),
(7, 'Kasir', 'kasir@kasir.com', '$2y$10$pZ28jFXoSs3V9bYYp0SmwuW19EmUvAcQjEezYnurYA2GxNVQg7YkO', '087855777360', '17081010054', 'kasir', 'aktif'),
(8, 'Kasir Kedua', 'kasir2@kasir.com', '$2y$10$L85.qX10Ktnc1gfkaHUL8OcXC4j.CIZDnKwBdDLeMN7xTaS.dXOBW', '087855777360', '17081010055', 'kasir', 'non-aktif'),
(10, 'Kasir Keempat', 'kasir4@kasir.com', '$2y$10$g/bU7dk/BVTYiF1WKVEJ.eQZSHvQRbNoh0Ht8jrT06kdDfAYpNkcW', '447773', '17081010051', 'kasir', 'non-aktif'),
(11, 'Kasir Kelima', 'kasir5@kasir.com', '$2y$10$rDB6KRsFFAowt0GvxEIfgOfTW80NKc1gJm2qbUQs5QW7IbPMrctXG', '12449939', '17081010093', 'kasir', 'aktif'),
(12, 'Kasir Keenam', 'kasir6@kasir.com', '$2y$10$TtlU9R8xyawAHcDIe2kpf.dC1PU2Y/pLPmbvOD81XhPkpWlu9G6na', '888449333', '17081010044', 'kasir', 'aktif'),
(14, 'Kasir Ketujuh', 'kasir7@kasir.com', '$2y$10$4.eIdY57ZXwgKCniQzx2FO493OupNt47T3QPLB33fX7mlUP9alwHO', '288874747', '12777363633', 'kasir', 'aktif');

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
  MODIFY `id_detail_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `keuntungan`
--
ALTER TABLE `keuntungan`
  MODIFY `id_keuntungan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `stock_barang`
--
ALTER TABLE `stock_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
