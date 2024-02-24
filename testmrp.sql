-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2024 at 07:17 AM
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
-- Database: `testmrp`
--

-- --------------------------------------------------------

--
-- Table structure for table `bufferstock_barcodes`
--

CREATE TABLE `bufferstock_barcodes` (
  `id` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `ptype` varchar(255) NOT NULL,
  `qperunit` decimal(10,2) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bufferstock_barcodes`
--

INSERT INTO `bufferstock_barcodes` (`id`, `product`, `ptype`, `qperunit`, `brand`, `barcode`, `datetime`) VALUES
(70, '1', '22.50%\r\n', 800.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'GS03540M04524000893', '2024-02-23 16:38:05'),
(71, '1', '22.50%\r\n', 400.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'GS03540M04524000894', '2024-02-23 16:38:05'),
(72, '1', '22.60%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'GS03540M04524000896', '2024-02-23 16:38:05'),
(73, '1', '22.50%\r\n', 200.00, 'Jiangxi Risun Solar Energy Co.Ltd.', '2BC23010723', '2024-02-23 16:38:05'),
(77, '1', '22.50%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'test', '2024-02-24 11:23:30'),
(78, '1', '22.50%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'testtest', '2024-02-24 11:23:30');

-- --------------------------------------------------------

--
-- Table structure for table `companylist`
--

CREATE TABLE `companylist` (
  `sno` int(11) NOT NULL,
  `cname` varchar(255) NOT NULL,
  `material_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companylist`
--

INSERT INTO `companylist` (`sno`, `cname`, `material_id`) VALUES
(1, 'Jiangxi Risun Solar Energy Co.Ltd.', 1),
(2, 'SUZHOU LNE ENERGY CO.LTD.', 1),
(3, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 1),
(4, 'Suzhou Ronma International Trade Co.Ltd.', 1),
(5, 'Changzhou GS Energy and Tech Co.Ltd.', 1),
(6, 'TONGWEI SOLAR CO.LTD.', 1),
(7, 'Xinyu Jisheng Trading Co.Ltd.', 1),
(8, 'Shandong Ronma Solar Co.Ltd.', 1),
(9, 'Lishui Zhanxin import & Export', 1),
(10, 'Krunck Errrenqy Pvt.Ltd.', 2),
(11, 'ENRICH ENCAP PRIVATE LIMITED', 2);

-- --------------------------------------------------------

--
-- Table structure for table `materiallist`
--

CREATE TABLE `materiallist` (
  `sno` int(11) NOT NULL,
  `material_name` varchar(255) NOT NULL,
  `material_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materiallist`
--

INSERT INTO `materiallist` (`sno`, `material_name`, `material_id`) VALUES
(1, 'Select Material', 0),
(2, 'Solar Cell', 1),
(3, 'EVA', 2);

-- --------------------------------------------------------

--
-- Table structure for table `materialtype`
--

CREATE TABLE `materialtype` (
  `sno` int(11) NOT NULL,
  `mtype` varchar(255) NOT NULL,
  `material_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materialtype`
--

INSERT INTO `materialtype` (`sno`, `mtype`, `material_id`) VALUES
(1, '18.90%\r\n', 1),
(2, '22.50%\r\n', 1),
(3, '22.60%\r\n', 1),
(4, '22.70%', 1),
(5, '22.80%', 1),
(6, '22.90%', 1),
(7, '23.00%', 1),
(8, '23.10%', 1),
(9, '23.20%\r\n', 1),
(10, '23.30%\r\n', 1),
(11, '23.40%\r\n', 1),
(12, '24.20%\r\n', 1),
(13, '24.50%\r\n', 1),
(14, 'xyz', 2),
(15, 'abc', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_barcodes`
--

CREATE TABLE `product_barcodes` (
  `id` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `ptype` varchar(255) NOT NULL,
  `qperunit` decimal(10,2) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_barcodes`
--

INSERT INTO `product_barcodes` (`id`, `product`, `ptype`, `qperunit`, `brand`, `barcode`, `datetime`) VALUES
(70, '1', '22.50%\r\n', 400.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'GS03540M04524000893', '2024-02-23 16:38:05'),
(71, '1', '22.50%\r\n', 400.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'GS03540M04524000894', '2024-02-23 16:38:05'),
(72, '1', '22.60%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'GS03540M04524000896', '2024-02-23 16:38:05'),
(73, '1', '22.50%\r\n', 200.00, 'Jiangxi Risun Solar Energy Co.Ltd.', '2BC23010723', '2024-02-23 16:38:05'),
(79, '1', '22.50%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'test', '2024-02-24 11:23:30'),
(80, '1', '22.50%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'testtest', '2024-02-24 11:23:30');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `ptype` varchar(255) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `ptype`, `quantity`, `brand`, `datetime`) VALUES
(70, '22.50%\r\n', 600.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', '2024-02-23 16:38:05'),
(72, '22.60%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', '2024-02-23 16:38:05'),
(74, '18.90%\r\n', 200.00, 'Jiangxi Risun Solar Energy Co.Ltd.', '2024-02-24 10:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `stock_barcodes`
--

CREATE TABLE `stock_barcodes` (
  `id` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `ptype` varchar(255) NOT NULL,
  `qperunit` decimal(10,2) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_barcodes`
--

INSERT INTO `stock_barcodes` (`id`, `product`, `ptype`, `qperunit`, `brand`, `barcode`, `datetime`) VALUES
(70, '1', '22.50%\r\n', 800.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'GS03540M04524000893', '2024-02-23 16:38:05'),
(71, '1', '22.50%\r\n', 400.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'GS03540M04524000894', '2024-02-23 16:38:05'),
(72, '1', '22.60%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'GS03540M04524000896', '2024-02-23 16:38:05'),
(73, '1', '22.50%\r\n', 200.00, 'Jiangxi Risun Solar Energy Co.Ltd.', '2BC23010723', '2024-02-23 16:38:05'),
(77, '1', '22.50%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'test', '2024-02-24 11:23:30'),
(78, '1', '22.50%\r\n', 100.00, 'Wu Xi Amphenol Solar Energy Technology Co.Ltd.', 'testtest', '2024-02-24 11:23:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bufferstock_barcodes`
--
ALTER TABLE `bufferstock_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companylist`
--
ALTER TABLE `companylist`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `materiallist`
--
ALTER TABLE `materiallist`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `materialtype`
--
ALTER TABLE `materialtype`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `product_barcodes`
--
ALTER TABLE `product_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_barcodes`
--
ALTER TABLE `stock_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bufferstock_barcodes`
--
ALTER TABLE `bufferstock_barcodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `companylist`
--
ALTER TABLE `companylist`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `materiallist`
--
ALTER TABLE `materiallist`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `materialtype`
--
ALTER TABLE `materialtype`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_barcodes`
--
ALTER TABLE `product_barcodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `stock_barcodes`
--
ALTER TABLE `stock_barcodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
