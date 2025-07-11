-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 10, 2025 at 06:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbws`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `unique_id` int(11) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `account_first_name` varchar(100) NOT NULL,
  `account_last_name` varchar(100) NOT NULL,
  `card_type` varchar(100) NOT NULL DEFAULT '',
  `default_discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `date_registered` date DEFAULT '2000-01-01',
  `card_status` int(11) NOT NULL DEFAULT 0,
  `comp_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`unique_id`, `account_number`, `account_first_name`, `account_last_name`, `card_type`, `default_discount`, `date_registered`, `card_status`, `comp_email`) VALUES
(1, '0483e901110c03', 'Sarah', 'Angot', 'BRONZE', 10.00, '2025-06-28', 1, ''),
(2, '04937701060c03', 'Arsene', 'Angot', 'SILVER', 0.00, '2025-06-30', 1, ''),
(3, '04C3A901EC0C03', 'Athalia', 'Angot', 'GOLD', 0.00, '2025-06-30', 1, ''),
(4, '0483E1013D0C03', 'Roboam', 'Dosdos', 'BRONZE', 0.00, '2025-07-04', 0, ''),
(5, '1234534567', 'Hello carl', 'mask', 'BRONZE', 10.00, '2025-07-10', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_companies`
--

CREATE TABLE `tbl_companies` (
  `unique_id` int(11) NOT NULL,
  `comp_id` varchar(100) NOT NULL,
  `comp_pin` int(11) NOT NULL,
  `comp_name` varchar(100) NOT NULL,
  `comp_address` varchar(200) NOT NULL,
  `comp_type` int(11) NOT NULL DEFAULT 0,
  `comp_stat` int(11) NOT NULL DEFAULT 0,
  `comp_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discounts`
--

CREATE TABLE `tbl_discounts` (
  `unique_id` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `comp_id` varchar(100) NOT NULL,
  `discount` int(11) NOT NULL,
  `card_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_discounts`
--

INSERT INTO `tbl_discounts` (`unique_id`, `date_start`, `date_end`, `comp_id`, `discount`, `card_type`) VALUES
(1, '2025-06-30', '2025-06-30', '3', 10, 'BRONZE'),
(2, '2025-06-30', '2025-06-30', '3', 15, 'SILVER'),
(3, '2025-06-30', '2025-06-30', '4', 15, 'BRONZE'),
(4, '2025-06-30', '2025-06-30', '4', 20, 'GOLD'),
(5, '2025-06-30', '2025-06-30', '4', 15, 'SILVER'),
(6, '2025-07-01', '2025-07-01', '09167847694', 10, 'BRONZE'),
(7, '2025-07-01', '2025-07-01', '09167847694', 15, 'SILVER'),
(8, '2025-07-01', '2025-07-01', '09167847694', 20, 'GOLD'),
(9, '2025-07-03', '2025-07-03', '4', 10, 'BRONZE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `unique_id` bigint(20) NOT NULL,
  `trans_date` date NOT NULL,
  `trans_time` time NOT NULL,
  `account` varchar(100) NOT NULL,
  `comp_id` varchar(100) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(12,2) NOT NULL,
  `reference` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transactions`
--

INSERT INTO `tbl_transactions` (`unique_id`, `trans_date`, `trans_time`, `account`, `comp_id`, `discount`, `amount`, `reference`) VALUES
(1, '2025-06-26', '14:50:08', '04937701060c03', '1', 10, 0.00, ''),
(2, '2025-06-27', '10:07:51', '0483e901110c03', '1', 0, 0.00, ''),
(3, '2025-06-27', '12:16:42', '0483e901110c03', '1', 10, 0.00, ''),
(4, '2025-06-30', '08:33:55', '04937701060C03', '3', 15, 0.00, ''),
(5, '2025-06-30', '08:50:23', '04937701060C03', '4', 0, 0.00, ''),
(6, '2025-06-30', '08:51:53', '04937701060C03', '4', 15, 0.00, ''),
(7, '2025-06-30', '08:52:02', '04937701060C03', '4', 15, 0.00, ''),
(8, '2025-07-01', '18:04:09', '04C3A901EC0C03', '09167847694', 20, 0.00, ''),
(9, '2025-07-01', '23:49:57', '04C3A901EC0C03', '09167847694', 20, 0.00, ''),
(10, '2025-07-02', '08:43:59', '04C3A901EC0C03', '09167847694', 20, 0.00, ''),
(11, '2025-07-03', '12:35:20', '0483E901110C03', '3', 10, 0.00, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `tbl_discounts`
--
ALTER TABLE `tbl_discounts`
  ADD PRIMARY KEY (`unique_id`);

--
-- Indexes for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`unique_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `unique_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `unique_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_discounts`
--
ALTER TABLE `tbl_discounts`
  MODIFY `unique_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `unique_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
