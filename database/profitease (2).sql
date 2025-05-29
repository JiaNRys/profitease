-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 01:10 AM
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
-- Database: `profitease`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_type` enum('asset','expense','equity','liability','income') NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_name`, `account_type`, `user_id`) VALUES
(75, 'Cash', 'asset', NULL),
(76, 'Inventory', 'asset', NULL),
(77, 'Rent Expense', 'expense', NULL),
(78, 'Utilities Expense', 'expense', NULL),
(79, 'Salaries Expense', 'expense', NULL),
(80, 'Marketing Expense', 'expense', NULL),
(81, 'Maintenance Expense', 'expense', NULL),
(82, 'Owner’s Equity', 'equity', NULL),
(83, 'Accounts Payable', 'liability', NULL),
(84, 'Sales Revenue', 'income', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `title`, `content`, `created_at`) VALUES
(1, '1st table', '<table id=\"excelTable\">\r\n                    <thead>\r\n                        <tr>\r\n                            <th contenteditable=\"true\">Header 1</th>\r\n                            <th contenteditable=\"true\">Header 2</th>\r\n                        </tr>\r\n                    </thead>\r\n                    <tbody>\r\n                        <tr>\r\n                            <td contenteditable=\"true\">Row 1, Col 1</td>\r\n                            <td contenteditable=\"true\">Row 1, Col 2</td>\r\n                        </tr>\r\n                    <tr><td contenteditable=\"true\">Row 2, Col 1</td><td contenteditable=\"true\">Row 2, Col 2</td></tr><tr><td contenteditable=\"true\">Row 3, Col 1</td><td contenteditable=\"true\">Row 3, Col 2</td></tr><tr><td contenteditable=\"true\">Row 4, Col 1</td><td contenteditable=\"true\">Row 4, Col 2</td></tr></tbody>\r\n                </table>', '2025-04-11 13:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `journalentries`
--

CREATE TABLE `journalentries` (
  `entry_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `debit_amount` decimal(10,2) DEFAULT NULL,
  `credit_amount` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journalentries`
--

INSERT INTO `journalentries` (`entry_id`, `transaction_id`, `account_id`, `debit_amount`, `credit_amount`, `description`, `user_id`) VALUES
(103, 97, 75, 100000.00, 0.00, 'Owner invests capital', NULL),
(104, 97, 82, 0.00, 100000.00, 'Owner invests capital', NULL),
(107, 99, 77, 10000.00, 0.00, 'Paid rent', NULL),
(108, 99, 75, 0.00, 10000.00, 'Paid rent', NULL),
(109, 100, 83, 0.00, 30000.00, 'Inventory purchased (on credit)', NULL),
(110, 100, 76, 30000.00, 0.00, 'Inventory purchased (on credit)', NULL),
(111, 101, 75, 20000.00, 0.00, 'Cash sales', NULL),
(112, 101, 84, 0.00, 20000.00, 'Cash sales', NULL),
(113, 102, 75, 0.00, 3000.00, 'Paid utility bill', NULL),
(114, 102, 78, 3000.00, 0.00, 'Paid utility bill', NULL),
(115, 103, 79, 12000.00, 0.00, 'Paid salaries', NULL),
(116, 103, 75, 0.00, 12000.00, 'Paid salaries', NULL),
(117, 104, 75, 0.00, 10000.00, 'Paid rent', NULL),
(118, 104, 77, 10000.00, 0.00, 'Paid rent', NULL),
(119, 105, 83, 15000.00, 0.00, 'Partial payment of Jan inventory', NULL),
(120, 105, 75, 0.00, 15000.00, 'Partial payment of Jan inventory', NULL),
(121, 106, 75, 25000.00, 0.00, 'Cash sales', NULL),
(122, 106, 83, 0.00, 25000.00, 'Cash sales', NULL),
(123, 107, 76, 20000.00, 0.00, 'Inventory purchased (on credit)', NULL),
(124, 107, 83, 0.00, 20000.00, 'Inventory purchased (on credit)', NULL),
(125, 108, 79, 12000.00, 0.00, 'Paid salaries', NULL),
(126, 108, 75, 0.00, 12000.00, 'Paid salaries', NULL),
(127, 109, 77, 10000.00, 0.00, 'Paid rent', NULL),
(128, 109, 75, 0.00, 10000.00, 'Paid rent', NULL),
(129, 110, 77, 3500.00, 0.00, 'Paid utilities', NULL),
(130, 110, 75, 0.00, 3500.00, 'Paid utilities', NULL),
(131, 111, 79, 12000.00, 0.00, 'Paid salaries', NULL),
(132, 111, 75, 0.00, 12000.00, 'Paid salaries', NULL),
(133, 112, 77, 10000.00, 0.00, 'Paid rent', NULL),
(134, 112, 75, 0.00, 10000.00, 'Paid rent', NULL),
(135, 113, 84, 0.00, 35000.00, 'Cash sales', NULL),
(136, 113, 75, 35000.00, 0.00, 'Cash sales', NULL),
(137, 114, 76, 25000.00, 0.00, 'Inventory purchase (cash)', NULL),
(138, 114, 75, 0.00, 25000.00, 'Inventory purchase (cash)', NULL),
(139, 115, 79, 12000.00, 0.00, 'Paid salaries', NULL),
(140, 115, 75, 0.00, 12000.00, 'Paid salaries', NULL),
(141, 116, 75, 0.00, 10000.00, 'Paid rent', NULL),
(142, 116, 77, 10000.00, 0.00, 'Paid rent', NULL),
(145, 118, 83, 50000.00, 0.00, 'Paid for equipment', NULL),
(146, 118, 75, 0.00, 50000.00, 'Paid for equipment', NULL),
(147, 119, 75, 45000.00, 0.00, 'Cash sales', NULL),
(148, 119, 84, 0.00, 45000.00, 'Cash sales', NULL),
(149, 120, 78, 3800.00, 0.00, 'Paid utilities', NULL),
(150, 120, 75, 0.00, 3800.00, 'Paid utilities', NULL),
(151, 121, 79, 12000.00, 0.00, 'Paid salaries', NULL),
(152, 121, 75, 0.00, 12000.00, 'Paid salaries', NULL),
(153, 122, 84, 0.00, 45000.00, 'Cash sales', NULL),
(154, 122, 75, 45000.00, 0.00, 'Cash sales', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `transaction_date`, `description`, `user_id`) VALUES
(97, '2025-01-01', '', NULL),
(98, '2025-05-13', '', NULL),
(99, '2025-01-03', '', NULL),
(100, '2025-01-06', '', NULL),
(101, '2025-05-13', '', NULL),
(102, '2025-01-20', '', NULL),
(103, '2025-05-13', '', NULL),
(104, '2025-02-01', '', NULL),
(105, '2025-02-04', '', NULL),
(106, '2025-02-10', '', NULL),
(107, '2025-05-13', '', NULL),
(108, '2025-02-25', '', NULL),
(109, '2025-03-01', '', NULL),
(110, '2025-03-20', '', NULL),
(111, '2025-03-28', '', NULL),
(112, '2025-04-01', '', NULL),
(113, '2025-04-15', '', NULL),
(114, '2025-04-15', '', NULL),
(115, '2025-04-25', '', NULL),
(116, '2025-06-01', '', NULL),
(117, '2025-05-13', '', NULL),
(118, '2025-06-10', '', NULL),
(119, '2025-05-13', '', NULL),
(120, '2025-06-22', '', NULL),
(121, '2025-06-30', '', NULL),
(122, '2025-06-18', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$O.jgaUxwAxMRniB1zDgDc.tczVqcXqRkX/oEMqAEslrwoMBpHQhZ6', NULL),
(2, 'system', 'system@test.exp', '$2y$10$kdkVh8hfY4cydQTgyqJ1Ye3xemc.Y8Bx949EpMLhPoWMXiZjnzUKi', NULL),
(3, 'jian', 'jian@test.exp', '$2y$10$ka7XmNM9Yz5sJQrcemPpDOE5bxndFVfnzeybvBpkrdqCHap8M4f4q', NULL),
(4, 'admin', 'admin@gmail.com', '$2y$10$dydUvM7rYqXCzzFdDUT1tO5zfXCOY/8./71uNVG8Jy33BDvRA4XVa', NULL),
(5, NULL, 'test', '$2y$10$8wYgAlAtOU1Y18Ox.78opehdPjzNYJn/gMXC5EWFYCtckMOJ2tbhi', NULL),
(6, NULL, 'test1', '$2y$10$yULShSaVoGGHoqZthguW/eCJuzCerrrYhe1r0exThiXS1R5bdmXLK', NULL),
(7, 'test@test.com', 'test1', '$2y$10$cdG3cH54CgS7o34EFVsP9.Qo8YLPveC9YcQfa6jzWVdHKQhog6F6a', NULL),
(8, 'test@test.com', 'test3', '$2y$10$zKsGLJ0UVhuRN2wqpCdQku7UdvfD.IrD6KaW9PGzufF.wKKJSyTFe', NULL),
(9, 'JiaNRys', 'jianreyes558@gmail.com', '$2y$10$667rWOCWjbKAdtk5R8TsZOzVG8UabmzNlkcnTVxCiULx.jdjSG/OO', NULL),
(11, 'Gyan', '202311221@gordoncollege.edu.ph', '$2y$10$9ReVpgrZ2Tc98nH9QahrWuAa3qLdZFNQ99p.NxU67b/i5eNMzo29O', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `journalentries`
--
ALTER TABLE `journalentries`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
