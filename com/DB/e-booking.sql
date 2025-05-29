-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2023 at 04:13 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_type` enum('asset','expense','equity','liability','income') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_name`, `account_type`) VALUES
(1, 'Bank', 'asset'),
(2, 'Capital', 'equity'),
(3, 'Rent', 'expense'),
(4, 'vehicle', 'asset'),
(5, 'drawings', 'equity'),
(6, 'purchase', 'expense'),
(7, 'Sales', 'income'),
(8, 'Inventory', 'asset'),
(9, 'rent recievable', 'income'),
(10, 'www', 'asset'),
(11, 'leon', 'asset'),
(12, 'hy', 'asset'),
(13, 'ok', 'asset'),
(14, 'then', 'asset'),
(15, 'ttt', 'expense'),
(16, 'qw', 'expense'),
(17, 's', 'equity');

-- --------------------------------------------------------

--
-- Table structure for table `journalentries`
--

CREATE TABLE `journalentries` (
  `entry_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `debit_amount` decimal(10,2) DEFAULT NULL,
  `credit_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `journalentries`
--

INSERT INTO `journalentries` (`entry_id`, `transaction_id`, `account_id`, `debit_amount`, `credit_amount`) VALUES
(1, 1, 1, '10000000.00', '0.00'),
(2, 2, 2, '0.00', '10000000.00'),
(3, 3, 3, '100000.00', '0.00'),
(4, 4, 1, '0.00', '100000.00'),
(5, 5, 4, '15000.00', '0.00'),
(6, 6, 1, '0.00', '15000.00'),
(7, 7, 5, '15000.00', '0.00'),
(8, 8, 1, '0.00', '15000.00'),
(9, 9, 2, '15000.00', '0.00'),
(10, 10, 5, '0.00', '15000.00'),
(11, 11, 1, '0.00', '5000.00'),
(13, 13, 6, '5000.00', '0.00'),
(14, 14, 6, '0.00', '5000.00'),
(15, 15, 8, '5000.00', '0.00'),
(16, 16, 7, '8000.00', '0.00'),
(17, 17, 7, '0.00', '8000.00'),
(18, 18, 1, '8000.00', '0.00'),
(19, 19, 8, '0.00', '8000.00'),
(20, 20, 10, '500.00', '0.00'),
(21, 20, 1, '0.00', '500.00'),
(22, 21, 11, '1000.00', '0.00'),
(23, 21, 1, '0.00', '1000.00'),
(24, 22, 15, '100.00', '0.00'),
(25, 22, 1, '0.00', '100.00'),
(26, 23, 14, '10000.00', '0.00'),
(27, 23, 1, '0.00', '10000.00'),
(28, 24, 15, '1000.00', '0.00'),
(29, 24, 1, '0.00', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `transaction_date`, `description`) VALUES
(1, '2023-07-24', 'deposit'),
(2, '2023-07-24', 'deposit'),
(3, '2023-07-25', 'paid rent'),
(4, '2023-07-25', 'paid rent'),
(5, '2023-07-26', 'bought a car'),
(6, '2023-07-26', 'bought a car'),
(7, '2023-07-24', 'drawings for school fees'),
(8, '2023-07-24', 'drawings for school fees'),
(9, '2023-07-24', 'drawings for school fees'),
(10, '2023-07-24', 'drawings for school fees'),
(11, '2023-07-24', 'bought beans'),
(13, '2023-07-24', 'bought beans'),
(14, '2023-07-24', 'bought beans'),
(15, '2023-07-24', 'bought beans'),
(16, '2023-07-24', 'sold beans'),
(17, '2023-07-24', 'sold beans'),
(18, '2023-07-24', 'sold beans'),
(19, '2023-07-24', 'sold beans'),
(20, '2023-07-28', 'bought  www'),
(21, '2023-07-28', 'Buying Leon'),
(22, '2023-07-28', 'ttt bought'),
(23, '2023-07-28', 'then'),
(24, '2023-07-29', 'oky test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `journalentries`
--
ALTER TABLE `journalentries`
  ADD PRIMARY KEY (`entry_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `journalentries`
--
ALTER TABLE `journalentries`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `journalentries`
--
ALTER TABLE `journalentries`
  ADD CONSTRAINT `journalentries_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`),
  ADD CONSTRAINT `journalentries_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
