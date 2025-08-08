-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2025 at 06:40 PM
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
-- Database: `banking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountId` bigint(20) NOT NULL,
  `type` enum('savings','current','fixed') DEFAULT NULL,
  `status` enum('active','inactive','closed') DEFAULT NULL,
  `Balance` double DEFAULT NULL,
  `customerId` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountId`, `type`, `status`, `Balance`, `customerId`) VALUES
(1, 'savings', 'active', 5000, 3),
(101, 'savings', 'inactive', 50000, 1),
(102, 'current', 'active', 20000, 2),
(3101, 'current', 'active', 77005.67, 101),
(3102, 'current', 'active', 8846.02, 102),
(3103, 'fixed', 'active', 51163.13, 103),
(3104, 'current', 'active', 96941, 104),
(3105, 'current', 'active', 60421.29, 105);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerId` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `nid` bigint(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `kycstatus` tinyint(1) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `name`, `nid`, `phone`, `email`, `address`, `kycstatus`, `password`) VALUES
(1, 'Alice Rahman', 1234567890, '01700000001', 'alice@example.com', 'Dhaka, BD', 1, '111111'),
(2, 'Babar Khan', 1234567891, '01700000002', 'babar@example.com', 'Chittagong, BD', 1, '222222'),
(3, 'BIJOY DEB', 8265142417, '01792893505', 'debd2000m@gmail.com', 'Road No : 01, Block - A, Bashundhara R/A, Dhaka.', 0, 'aaaaaa'),
(5, 'Arafat Hossain', 1999001001, '01711111101', 'arafat01@gmail.com', 'Mirpur, Dhaka', 1, 'pass123'),
(6, 'Nafis Rahman', 1999001002, '01711111102', 'nafis02@gmail.com', 'Uttara, Dhaka', 0, 'pass123'),
(7, 'Rizwan Karim', 1999001003, '01711111103', 'rizwan03@gmail.com', 'Banani, Dhaka', 1, 'pass123'),
(8, 'Sadia Ahmed', 1999001004, '01711111104', 'sadia04@gmail.com', 'Dhanmondi, Dhaka', 1, 'pass123'),
(9, 'Tania Alam', 1999001005, '01711111105', 'tania05@gmail.com', 'Gulshan, Dhaka', 0, 'pass123'),
(10, 'Shakib Hasan', 1999001006, '01711111106', 'shakib06@gmail.com', 'Chawkbazar, Chattogram', 1, 'pass123'),
(11, 'Imran Siddiq', 1999001007, '01711111107', 'imran07@gmail.com', 'Agrabad, Chattogram', 0, 'pass123'),
(12, 'Lubna Tahsin', 1999001008, '01711111108', 'lubna08@gmail.com', 'Kotwali, Rajshahi', 1, 'pass123'),
(13, 'Zahidul Islam', 1999001009, '01711111109', 'zahid09@gmail.com', 'Rangpur Sadar, Rangpur', 1, 'pass123'),
(14, 'Nahid Hasan', 1999001010, '01711111110', 'nahid10@gmail.com', 'Khulna City, Khulna', 0, 'pass123'),
(15, 'Fahim Rahman', 1999001011, '01711111111', 'fahim11@gmail.com', 'Barisal Sadar, Barisal', 1, 'pass123'),
(16, 'Oishi Nahar', 1999001012, '01711111112', 'oishi12@gmail.com', 'Sylhet City, Sylhet', 0, 'pass123'),
(17, 'Rayhan Kabir', 1999001013, '01711111113', 'rayhan13@gmail.com', 'Jashore Town, Jashore', 1, 'pass123'),
(18, 'Tanjina Akter', 1999001014, '01711111114', 'tanjina14@gmail.com', 'Pabna Town, Pabna', 1, 'pass123'),
(19, 'Rafiq Hossain', 1999001015, '01711111115', 'rafiq15@gmail.com', 'Narayanganj, Dhaka', 0, 'pass123'),
(20, 'Mehzabeen Chowdhury', 1999001016, '01711111116', 'mehzabeen16@gmail.com', 'Cumilla City, Cumilla', 1, 'pass123'),
(21, 'Abdullah Khan', 1999001017, '01711111117', 'abdullah17@gmail.com', 'Bogra Sadar, Bogra', 0, 'pass123'),
(22, 'Farzana Mim', 1999001018, '01711111118', 'farzana18@gmail.com', 'Feni Town, Feni', 1, 'pass123'),
(23, 'Zarin Tasnim', 1999001019, '01711111119', 'zarin19@gmail.com', 'Sirajganj Town, Sirajganj', 1, 'pass123'),
(24, 'Ayman Islam', 1999001020, '01711111120', 'ayman20@gmail.com', 'Tangail Town, Tangail', 0, 'pass123');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employeeId` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` enum('Admin','Employee') DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeId`, `name`, `email`, `role`, `username`, `password`) VALUES
(201, 'Shila Akter', 'shila004@gmail.com', 'Employee', 'shila_emp', 'pass123'),
(202, 'Tamim Islam', 'tamim003@gmail.com', 'Admin', 'tamim_admin', 'admin456');

-- --------------------------------------------------------

--
-- Table structure for table `kycverification`
--

CREATE TABLE `kycverification` (
  `verificationID` varchar(50) NOT NULL,
  `customerId` bigint(20) DEFAULT NULL,
  `TIMESTAMP` datetime DEFAULT NULL,
  `verificationStatus` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `reportId` bigint(20) NOT NULL,
  `cause` text DEFAULT NULL,
  `reportedBy` bigint(20) DEFAULT NULL,
  `TIMESTAMP` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`reportId`, `cause`, `reportedBy`, `TIMESTAMP`) VALUES
(301, 'Suspicious login detected', 201, '2025-08-04 00:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionId` bigint(20) NOT NULL,
  `type` enum('transfer','deposit','withdrawal') DEFAULT NULL,
  `sender_accountId` bigint(20) DEFAULT NULL,
  `receiver_accountId` bigint(20) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `TIMESTAMP` datetime DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT NULL,
  `verificationID` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionId`, `type`, `sender_accountId`, `receiver_accountId`, `amount`, `TIMESTAMP`, `status`, `verificationID`) VALUES
(1001, 'transfer', 101, 102, 1000, '2025-08-04 00:24:00', 'completed', 'KYC001'),
(1002, 'deposit', 101, 0, 3000, '2025-08-06 10:00:00', 'completed', 'KYC002'),
(1003, 'withdrawal', 0, 3101, 1000, '2025-08-06 12:30:00', 'completed', 'KYC003'),
(1004, 'transfer', 0, 101, 2000, '2025-08-06 15:45:00', 'completed', 'KYC004'),
(1005, 'transfer', 102, 0, 1500, '2025-08-07 09:15:00', 'completed', 'KYC005'),
(1006, 'deposit', 3101, 0, 5000, '2025-08-07 10:30:00', 'completed', 'KYC006'),
(1007, 'withdrawal', 0, 3103, 1500, '2025-08-07 13:45:00', 'completed', 'KYC007');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountId`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`),
  ADD UNIQUE KEY `nid` (`nid`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeId`);

--
-- Indexes for table `kycverification`
--
ALTER TABLE `kycverification`
  ADD PRIMARY KEY (`verificationID`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`reportId`),
  ADD KEY `reportedBy` (`reportedBy`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionId`),
  ADD KEY `sender_accountId` (`sender_accountId`),
  ADD KEY `receiver_accountId` (`receiver_accountId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3107;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`reportedBy`) REFERENCES `employee` (`employeeId`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`sender_accountId`) REFERENCES `account` (`accountId`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`receiver_accountId`) REFERENCES `account` (`accountId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
