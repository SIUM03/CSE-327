-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 03, 2025 at 08:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BankSystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `Account`
--

CREATE TABLE `Account` (
  `accountId` bigint(20) NOT NULL,
  `type` enum('savings','current','fixed') DEFAULT NULL,
  `status` enum('active','inactive','closed') DEFAULT NULL,
  `Balance` double DEFAULT NULL,
  `customerId` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Account`
--

INSERT INTO `Account` (`accountId`, `type`, `status`, `Balance`, `customerId`) VALUES
(101, 'savings', 'inactive', 50000, 1),
(102, 'current', 'active', 20000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `adminId` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`adminId`) VALUES
(202);

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `customerId` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `nid` bigint(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `kycstatus` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`customerId`, `name`, `nid`, `phone`, `email`, `address`, `kycstatus`) VALUES
(1, 'Alice Rahman', 1234567890, '01700000001', 'alice@example.com', 'Dhaka, BD', 1),
(2, 'Babar Khan', 1234567891, '01700000002', 'babar@example.com', 'Chittagong, BD', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `employeeId` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `role` enum('Admin','Employee') DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`employeeId`, `name`, `role`, `username`, `password`) VALUES
(201, 'Shila Akter', 'Employee', 'shila_emp', 'pass123'),
(202, 'Tamim Islam', 'Admin', 'tamim_admin', 'admin456');

-- --------------------------------------------------------

--
-- Table structure for table `KYCVerification`
--

CREATE TABLE `KYCVerification` (
  `verificationID` varchar(50) NOT NULL,
  `customerId` bigint(20) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `verificationStatus` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `KYCVerification`
--

INSERT INTO `KYCVerification` (`verificationID`, `customerId`, `timestamp`, `verificationStatus`) VALUES
('KYC001', 1, '2025-08-04 00:24:00', 1),
('KYC002', 2, '2025-08-04 00:24:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Report`
--

CREATE TABLE `Report` (
  `reportId` bigint(20) NOT NULL,
  `cause` text DEFAULT NULL,
  `reportedBy` bigint(20) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Report`
--

INSERT INTO `Report` (`reportId`, `cause`, `reportedBy`, `timestamp`) VALUES
(301, 'Suspicious login detected', 201, '2025-08-04 00:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `Transactions`
--

CREATE TABLE `Transactions` (
  `transactionId` bigint(20) NOT NULL,
  `type` enum('transfer','deposit','withdrawal') DEFAULT NULL,
  `sender_accountId` bigint(20) DEFAULT NULL,
  `receiver_accountId` bigint(20) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT NULL,
  `verificationID` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Transactions`
--

INSERT INTO `Transactions` (`transactionId`, `type`, `sender_accountId`, `receiver_accountId`, `amount`, `timestamp`, `status`, `verificationID`) VALUES
(1001, 'transfer', 101, 102, 1000, '2025-08-04 00:24:00', 'completed', 'KYC001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`accountId`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`customerId`),
  ADD UNIQUE KEY `nid` (`nid`);

--
-- Indexes for table `Employee`
--
ALTER TABLE `Employee`
  ADD PRIMARY KEY (`employeeId`);

--
-- Indexes for table `KYCVerification`
--
ALTER TABLE `KYCVerification`
  ADD PRIMARY KEY (`verificationID`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `Report`
--
ALTER TABLE `Report`
  ADD PRIMARY KEY (`reportId`),
  ADD KEY `reportedBy` (`reportedBy`);

--
-- Indexes for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD PRIMARY KEY (`transactionId`),
  ADD KEY `sender_accountId` (`sender_accountId`),
  ADD KEY `receiver_accountId` (`receiver_accountId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Account`
--
ALTER TABLE `Account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `Customer` (`customerId`);

--
-- Constraints for table `Admin`
--
ALTER TABLE `Admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `Employee` (`employeeId`);

--
-- Constraints for table `KYCVerification`
--
ALTER TABLE `KYCVerification`
  ADD CONSTRAINT `kycverification_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `Customer` (`customerId`);

--
-- Constraints for table `Report`
--
ALTER TABLE `Report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`reportedBy`) REFERENCES `Employee` (`employeeId`);

--
-- Constraints for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`sender_accountId`) REFERENCES `Account` (`accountId`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`receiver_accountId`) REFERENCES `Account` (`accountId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
