-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2026 at 04:35 AM
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
-- Database: `latihan1`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_barang`
--

CREATE TABLE `data_barang` (
  `id_barang` int(10) NOT NULL,
  `kategori` varchar(30) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `harga_beli` decimal(10,0) DEFAULT NULL,
  `harga_jual` decimal(10,0) DEFAULT NULL,
  `stok` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_barang`
--

INSERT INTO `data_barang` (`id_barang`, `kategori`, `nama`, `gambar`, `harga_beli`, `harga_jual`, `stok`) VALUES
(1, 'Handphone', 'Infinix Hot 60 Pro', 'infinix_hot60pro.jpg', 1900000, 2399000, 10),
(2, 'Handphone', 'Infinix Smart 8', 'infinix_s8.jpg', 1150000, 1350000, 25),
(3, 'Handphone', 'Itel P55 5G', 'itel_p55.jpg', 1500000, 1850000, 7),
(4, 'Handphone', 'Oppo A18', 'oppo_a18.jpg', 1550000, 1899000, 10),
(5, 'Handphone', 'Poco C65', 'poco_c65.jpg', 1450000, 1750000, 9),
(6, 'Handphone', 'Poco M7', 'poco_m7.jpg', 1900000, 2299000, 12),
(7, 'Handphone', 'Realme C71', 'realme_c71.jpg', 1400000, 1799000, 14),
(8, 'Handphone', 'Realme Note 50', 'realme_n50.jpg', 1100000, 1299000, 20),
(9, 'Handphone', 'Samsung Galaxy A05', 'samsung_a05.jpg', 1400000, 1699000, 12),
(10, 'Handphone', 'Samsung Galaxy A15', 'samsung_a15.jpg', 2600000, 2999000, 8),
(11, 'Handphone', 'Tecno Spark 20', 'tecno_s20.jpg', 1600000, 1950000, 12),
(12, 'Handphone', 'Tecno Spark 30', 'tecno_s30.jpg', 1800000, 2199000, 11),
(13, 'Handphone', 'Vivo Y02t', 'vivo_y02t.jpg', 1200000, 1450000, 15),
(14, 'Handphone', 'Vivo Y29', 'vivo_y29.jpg', 2100000, 2599000, 8),
(15, 'Handphone', 'Xiaomi Redmi 13C', 'redmi_13c.jpg', 1350000, 1650000, 18),
(16, 'Aksesoris', 'Casing Silikon Bening', 'case_bening.jpg', 12000, 30000, 60),
(17, 'Aksesoris', 'Charger Fast 20W', 'charger_20w.jpg', 95000, 150000, 25),
(18, 'Aksesoris', 'Earphone Bluetooth Sport', 'tws_sport.jpg', 140000, 210000, 15),
(19, 'Aksesoris', 'Headset Samsung Original', 'hs_samsung.jpg', 50000, 85000, 35),
(20, 'Aksesoris', 'Kabel Data Type-C 2M', 'cable_2m.jpg', 30000, 60000, 50),
(21, 'Aksesoris', 'Memory Card 32GB', 'sd_32gb.jpg', 70000, 110000, 30),
(22, 'Aksesoris', 'Powerbank 10000mAh Mini', 'pb_mini.jpg', 160000, 220000, 18),
(23, 'Aksesoris', 'Ring Light Smartphone', 'ring_hp.jpg', 40000, 75000, 25),
(24, 'Aksesoris', 'Stand Holder Meja', 'holder_meja.jpg', 25000, 50000, 30),
(25, 'Aksesoris', 'Tempered Glass Universal', 'tg_universal.jpg', 18000, 40000, 120);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`) VALUES
(1, 'admin', '$2y$10$wus4kmfZ2LKyKrIkKWyKHuKxXQtoViMVVcz9q.ZjYacKJ8ErdmRTW', 'Administrator', 'admin'),
(7, 'adaaja', '$2y$10$VUZ4kj5JONelYxXKYeKuJ.7TwxPvzl/FwA0YaVZQ07EXe4YmBCZny', NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_barang`
--
ALTER TABLE `data_barang`
  MODIFY `id_barang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
