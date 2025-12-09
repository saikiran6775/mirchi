-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2025 at 08:03 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mirchi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `phone`, `username`, `password`, `profile`, `role`, `status`) VALUES
(1, 'valliaaaaaaaa', 'admin@gmail.com', '7894444444', 'admin@gmail.com', '123456', '1738733213_3.jpg', 'admin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `username`, `password`, `profile`, `role`, `status`) VALUES
(1, 'valli', 'admind@gmail.com', '7894444444', 'admin1@gmail.com', '12345678', 'uploads/3.jpg', 'admin', '1'),
(2, 'gayathri', 'admin@gmail.com', '7995826573', 'gayathri@gmail.com', '9876543', 'uploads/3.jpg', '', '1'),
(3, '', '', '', '', '', '', '', '1'),
(4, '', '', '', '', '', '', '', '1'),
(5, '', '', '', '', '', '', '', '1'),
(6, 'adminnn', '', '', '', '', 'uploads/WhatsApp Image 2025-01-31 at 2.52.39 PM.jpeg', '', '1'),
(7, '', '', '', '', '', '', '', '1'),
(8, '', '', '', '', '', '', '', '1'),
(9, '', '', '', '', '', '', '', '1'),
(10, 'dasd', 'admin@gmail.com', '7894444444', 'admin1@gmail.com', '123456789', 'uploads/WhatsApp Image 2025-01-31 at 2.52.39 PM.jpeg', '', '1'),
(11, '', '', '', '', '', '', '', '1'),
(12, 'adminnn', 'sadsa@fff', '7896767676', 'er@gmail.com', '123456', 'uploads/WhatsApp Image 2025-01-31 at 2.51.59 PM.jpeg', '', '1'),
(13, 'adminnn', 'sadsa@fff', '7896767676', 'er@gmail.com', '123456', 'uploads/WhatsApp Image 2025-01-31 at 2.51.59 PM.jpeg', '', '1'),
(14, 'adminnn', 'sadsa@fff', '7896767676', 'er@gmail.com', '123456', 'uploads/WhatsApp Image 2025-01-31 at 2.51.59 PM.jpeg', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `validity` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','suspend') DEFAULT 'inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `merchant_id` int(11) NOT NULL,
  `option` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0="active"\r\n1="delete"'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `mobile`, `username`, `password`, `validity`, `address`, `profile_image`, `status`, `created_at`, `merchant_id`, `option`) VALUES
(1, 'Gayathri', 'gayathri@gmail.com', '7897897890', 'gayathri@gmail.com', '123123', '7 Month', 'Vijayawada', 'uploads/logofor_website.jpg', 'active', '2025-02-05 11:58:51', 0, '1'),
(2, 'siri', 'rishi@gmail.com', '7897897890', 'harivallich@kbksoftwaresolutions.com', 'ghjklm', '4 Month', 'vijayawada', 'uploads/WhatsApp Image 2025-01-18 at 1.05.14 PM.jpeg', 'active', '2025-02-05 12:11:10', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `validity` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','suspend') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `option` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1="active"\r\n0="delete"',
  `role` varchar(22) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `name`, `email`, `mobile`, `username`, `password`, `validity`, `address`, `profile_image`, `status`, `created_at`, `option`, `role`) VALUES
(1, 'gayathri', 'gayathri@gmail.com', '7995826572', 'gayathri@gmal.com', 'hii333', '7 Month', 'Emani tenali', 'uploads/ssd-hotel.png', 'inactive', '2025-02-05 03:43:47', '1', 'admin'),
(2, 'siri', 'siri@gmail.com', '7897897897', 'siri@gmail.com', '12345678', '3 Month', 'Tenali Guntur', 'uploads/ssd.png', 'active', '2025-02-05 04:29:17', '1', 'admin'),
(3, 'Rishi', 'rishi@gmail.com', '7995826574', 'rishi@gmail.com', '321321', '4 Month', 'Tenali Guntur', '1738824600_2023-08-03.jpg', 'active', '2025-02-05 04:32:52', '1', 'admin'),
(4, 'siri', 'admin@gmail.com', '7897897897', 'siri@gmail.com', '123456', '3 Month', 'tenali guntur', 'uploads/38526_siva tuitons_logo_DG_-01.jpg', 'active', '2025-02-05 05:45:15', '1', 'admin'),
(5, 'sasi', 'sasi@gmail.com', '7995826572', 'sasi@gmail.com', '345678', '7 Month', 'tenali vijayawada', 'uploads/WhatsApp Image 2025-01-20 at 12.22.33 PM.jpeg', 'active', '2025-02-05 05:48:39', '1', 'admin'),
(6, 'sasi', 'sasi@gmail.com', '7995826572', 'sasi@gmail.com', '345678', '4 Month', 'tenali vijayawadas', 'uploads/spices-category.jpg', 'active', '2025-02-05 05:48:58', '1', 'admin'),
(7, 'kbk', 'kbk@gmail.com', '8923459234', 'kbk@gmail.com', '123456', '3 Month', 'Mangalagiri, vijayawada', 'uploads/WhatsApp Image 2025-01-25 at 1.56.04 PM - Copy - Copy - Copy.jpeg', 'active', '2025-02-05 06:53:38', '1', 'admin'),
(8, 'dev', 'admin@gmail.com', '7897897897', 'er@gmail.com', '456789', '10 Month', 'hhh jjj kkk ll', 'uploads/WhatsApp Image 2025-01-09 at 9.42.14 PM.jpeg', 'active', '2025-02-05 07:10:51', '1', 'admin'),
(9, 'sailaja', 'sailaja@gmail.com', '8309248015', 'sailaja@gmail.com', '111111', '9 Month', 'Cherukupalli, Guntur', 'uploads/WhatsApp Image 2025-01-08 at 8.27.35 PM (1).jpeg', 'active', '2025-02-05 07:18:26', '1', 'admin'),
(10, 'harivalli', 'hari@gmail.com', '8978176263', 'hari@gmail.com', '123456', '7 Month', 'Eluru, Vijayawada', 'uploads/WhatsApp Image 2025-01-09 at 12.55.59 PM.jpeg', 'active', '2025-02-05 09:02:03', '1', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `mirchi_types`
--

CREATE TABLE `mirchi_types` (
  `id` int(11) NOT NULL,
  `mirchi_type` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0="inactive"\r\n1="active"'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mirchi_types`
--

INSERT INTO `mirchi_types` (`id`, `mirchi_type`, `status`) VALUES
(1, 'red', '1'),
(2, 'red', '1'),
(3, 'yellow', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mirch_purchase`
--

CREATE TABLE `mirch_purchase` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `mirchi_type` varchar(50) NOT NULL,
  `no_of_bags` int(11) NOT NULL,
  `net_weight` decimal(10,2) NOT NULL,
  `qwinta_rate` decimal(10,2) NOT NULL,
  `grass_amount` decimal(10,2) NOT NULL,
  `gunnies_bag` int(11) NOT NULL,
  `gunnies_bag_rate` decimal(10,2) NOT NULL,
  `gunnies_bag_total` decimal(10,2) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_no` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `shopname` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0="inactive"\r\n1="active"'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier`, `shopname`, `mobile`, `address`, `date`, `status`) VALUES
(1, 'hari', 'hari enterprises', '6786786786', 'Guntur mirchi yard', '2025-02-05 14:52:52', '1'),
(2, 'gayathri', 'gayathri enterprises', '6786786787', 'emani tenali', '2025-02-05 14:58:08', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mirchi_types`
--
ALTER TABLE `mirchi_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mirch_purchase`
--
ALTER TABLE `mirch_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mirchi_types`
--
ALTER TABLE `mirchi_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mirch_purchase`
--
ALTER TABLE `mirch_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
