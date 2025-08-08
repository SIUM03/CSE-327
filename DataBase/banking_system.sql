-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 08, 2025 at 01:15 PM
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
-- Database: `banking_system`
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
(100, 'savings', 'active', 0, 0),
(101, 'savings', 'inactive', 50000, 1),
(102, 'current', 'active', 20000, 2),
(103, 'fixed', 'closed', 68723.54, 3),
(104, 'fixed', 'inactive', 49246.94, 4),
(105, 'current', 'closed', 1814.98, 5),
(106, 'fixed', 'active', 91389.91, 6),
(107, 'savings', 'active', 47133.77, 7),
(108, 'current', 'inactive', 13224.91, 8),
(109, 'fixed', 'closed', 28037.06, 9),
(110, 'current', 'inactive', 88565.15, 10),
(111, 'current', 'closed', 29255.36, 11),
(112, 'current', 'active', 46329.62, 12),
(113, 'current', 'inactive', 67334.58, 13),
(114, 'fixed', 'inactive', 91112.21, 14),
(115, 'fixed', 'closed', 57877.56, 15),
(116, 'fixed', 'active', 19197.17, 16),
(117, 'current', 'closed', 65044.84, 17),
(118, 'current', 'closed', 71733.3, 18),
(119, 'current', 'active', 65921.76, 19),
(120, 'savings', 'closed', 89185.08, 20),
(121, 'fixed', 'active', 36420.21, 21),
(122, 'fixed', 'inactive', 60219.69, 22);

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
  `kycstatus` tinyint(1) DEFAULT NULL,
  `password` varchar(255) DEFAULT 'changeme'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`customerId`, `name`, `nid`, `phone`, `email`, `address`, `kycstatus`, `password`) VALUES
(0, 'Bank', 3434, '01700000', 'bank@bankii', 'Online', 1, 'bankknows\r\n'),
(1, 'Alice Rahman', 1234567890, '01700000001', 'alice@example.com', 'Dhaka, BD', 1, '111111'),
(2, 'Babar Khan', 1234567891, '01700000002', 'babar@example.com', 'Chittagong, BD', 1, '2232322'),
(3, 'Customer_3', 1234567903, '01700000003', 'customer3@example.com', 'City_3, BD', 0, '435435'),
(4, 'Customer_4', 1234567904, '01700000004', 'customer4@example.com', 'City_4, BD', 0, 'changeme'),
(5, 'Customer_5', 1234567905, '01700000005', 'customer5@example.com', 'City_5, BD', 1, 'changeme'),
(6, 'Customer_6', 1234567906, '01700000006', 'customer6@example.com', 'City_6, BD', 0, 'changeme'),
(7, 'Customer_7', 1234567907, '01700000007', 'customer7@example.com', 'City_7, BD', 0, 'changeme'),
(8, 'Customer_8', 1234567908, '01700000008', 'customer8@example.com', 'City_8, BD', 1, 'changeme'),
(9, 'Customer_9', 1234567909, '01700000009', 'customer9@example.com', 'City_9, BD', 0, 'changeme'),
(10, 'Customer_10', 1234567910, '01700000010', 'customer10@example.com', 'City_10, BD', 1, 'changeme'),
(11, 'Customer_11', 1234567911, '01700000011', 'customer11@example.com', 'City_11, BD', 0, 'changeme'),
(12, 'Customer_12', 1234567912, '01700000012', 'customer12@example.com', 'City_12, BD', 0, 'changeme'),
(13, 'Customer_13', 1234567913, '01700000013', 'customer13@example.com', 'City_13, BD', 0, 'changeme'),
(14, 'Customer_14', 1234567914, '01700000014', 'customer14@example.com', 'City_14, BD', 0, 'changeme'),
(15, 'Customer_15', 1234567915, '', 'customer15@example.com', 'City_15, BD', 0, 'changeme'),
(16, 'Customer_16', 1234567916, '01700000016', 'customer16@example.com', 'City_16, BD', 1, 'changeme'),
(17, 'Customer_17', 1234567917, '01700000017', 'customer17@example.com', 'City_17, BD', 0, 'changeme'),
(18, 'Customer_18', 1234567918, '01700000018', 'customer18@example.com', 'City_18, BD', 0, 'changeme'),
(19, 'Customer_19', 1234567919, '01700000019', 'customer19@example.com', 'City_19, BD', 1, 'changeme'),
(20, 'Customer_20', 1234567920, '01700000020', 'customer20@example.com', 'City_20, BD', 1, 'changeme'),
(21, 'Customer_21', 1234567921, '01700000021', 'customer21@example.com', 'City_21, BD', 0, 'changeme'),
(22, 'Customer_22', 1234567922, '01700000022', 'customer22@example.com', 'City_22, BD', 0, 'changeme');

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `employeeId` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` enum('Admin','Employee') DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`employeeId`, `name`, `email`, `role`, `username`, `password`) VALUES
(201, 'Shila Akter', 'shila004@gmail.com', 'Employee', 'shila_emp', 'pass123'),
(202, 'Tamim Islam', 'tamim003@gmail.com', 'Admin', 'tamim_admin', 'admin456'),
(203, 'Employee_203', 'emp203@bank.com', 'Admin', 'user203', 'pass203'),
(204, 'Employee_204', 'emp204@bank.com', 'Admin', 'user204', 'pass204'),
(205, 'Employee_205', 'emp205@bank.com', 'Admin', 'user205', 'pass205'),
(206, 'Employee_206', 'emp206@bank.com', 'Admin', 'user206', 'pass206'),
(207, 'Employee_207', 'emp207@bank.com', 'Admin', 'user207', 'pass207'),
(208, 'Employee_208', 'emp208@bank.com', 'Admin', 'user208', 'pass208'),
(209, 'Employee_209', 'emp209@bank.com', 'Admin', 'user209', 'pass209'),
(210, 'Employee_210', 'emp210@bank.com', 'Admin', 'user210', 'pass210'),
(211, 'Employee_211', 'emp211@bank.com', 'Admin', 'user211', 'pass211'),
(212, 'Employee_212', 'emp212@bank.com', 'Admin', 'user212', 'pass212'),
(213, 'Employee_213', 'emp213@bank.com', 'Admin', 'user213', 'pass213'),
(214, 'Employee_214', 'emp214@bank.com', 'Employee', 'user214', 'pass214'),
(215, 'Employee_215', 'emp215@bank.com', 'Admin', 'user215', 'pass215'),
(216, 'Employee_216', 'emp216@bank.com', 'Admin', 'user216', 'pass216'),
(217, 'Employee_217', 'emp217@bank.com', 'Employee', 'user217', 'pass217'),
(218, 'Employee_218', 'emp218@bank.com', 'Admin', 'user218', 'pass218'),
(219, 'Employee_219', 'emp219@bank.com', 'Admin', 'user219', 'pass219'),
(220, 'Employee_220', 'emp220@bank.com', 'Employee', 'user220', 'pass220'),
(221, 'Employee_221', 'emp221@bank.com', 'Employee', 'user221', 'pass221'),
(222, 'Employee_222', 'emp222@bank.com', 'Employee', 'user222', 'pass222');

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
('KYC002', 2, '2025-08-04 00:24:00', 1),
('KYC101', 3, '2025-06-23 10:53:47', 0),
('KYC102', 4, '2025-07-23 10:53:47', 0),
('KYC103', 5, '2025-07-03 10:53:47', 0),
('KYC104', 6, '2025-06-08 10:53:47', 0),
('KYC105', 7, '2025-07-20 10:53:47', 1),
('KYC106', 8, '2025-06-25 10:53:47', 0),
('KYC107', 9, '2025-05-19 10:53:47', 1),
('KYC108', 10, '2025-07-23 10:53:47', 0),
('KYC109', 11, '2025-07-27 10:53:47', 1),
('KYC110', 12, '2025-07-22 10:53:47', 1),
('KYC111', 13, '2025-07-10 10:53:47', 1),
('KYC112', 14, '2025-08-08 10:53:47', 0),
('KYC113', 15, '2025-07-04 10:53:47', 0),
('KYC114', 16, '2025-08-08 10:53:47', 1),
('KYC115', 17, '2025-05-05 10:53:47', 1),
('KYC116', 18, '2025-05-31 10:53:47', 0),
('KYC117', 19, '2025-06-18 10:53:47', 1),
('KYC118', 20, '2025-07-31 10:53:47', 1),
('KYC119', 21, '2025-07-10 10:53:47', 1),
('KYC120', 22, '2025-07-20 10:53:47', 0);

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
(301, 'Suspicious login detected', 201, '2025-08-04 00:24:00'),
(302, 'Data change', 203, '2025-06-16 10:53:47'),
(303, 'Login attempt', 204, '2025-07-19 10:53:47'),
(304, 'Login attempt', 205, '2025-07-13 10:53:47'),
(305, 'Suspicious transaction', 206, '2025-06-29 10:53:47'),
(306, 'Login attempt', 207, '2025-07-16 10:53:47'),
(307, 'Failed login', 208, '2025-06-25 10:53:47'),
(308, 'Failed login', 209, '2025-06-22 10:53:47'),
(309, 'Account closed', 210, '2025-08-06 10:53:47'),
(310, 'Failed login', 211, '2025-07-06 10:53:47'),
(311, 'Login attempt', 212, '2025-07-21 10:53:47'),
(312, 'Account closed', 213, '2025-07-06 10:53:47'),
(313, 'Suspicious transaction', 214, '2025-07-22 10:53:47'),
(314, 'Account closed', 215, '2025-06-23 10:53:47'),
(315, 'Failed login', 216, '2025-06-14 10:53:47'),
(316, 'Data change', 217, '2025-06-20 10:53:47'),
(317, 'Login attempt', 218, '2025-07-12 10:53:47'),
(318, 'Failed login', 219, '2025-07-29 10:53:47'),
(319, 'Suspicious transaction', 220, '2025-07-03 10:53:47'),
(320, 'Data change', 221, '2025-07-15 10:53:47'),
(321, 'Suspicious transaction', 222, '2025-07-09 10:53:47');

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
(1001, 'transfer', 101, 102, 1000, '2025-08-04 00:24:00', 'completed', 'KYC001'),
(1002, 'transfer', 117, 115, 6683.99, '2025-07-12 10:53:47', 'completed', 'KYC101'),
(1003, 'withdrawal', 103, 100, 798.6, '2025-07-24 10:53:47', 'pending', 'KYC102'),
(1004, 'withdrawal', 114, 100, 3696.01, '2025-07-24 10:53:47', 'failed', 'KYC103'),
(1005, 'deposit', 100, 117, 3054.75, '2025-08-07 10:53:47', 'completed', 'KYC104'),
(1006, 'transfer', 118, 109, 1911.74, '2025-08-01 10:53:47', 'completed', 'KYC105'),
(1007, 'transfer', 103, 112, 7675.42, '2025-08-08 10:53:47', 'pending', 'KYC106'),
(1008, 'transfer', 119, 113, 5182.42, '2025-07-16 10:53:47', 'failed', 'KYC107'),
(1009, 'transfer', 122, 110, 3959.42, '2025-07-30 10:53:47', 'pending', 'KYC108'),
(1010, 'deposit', 100, 107, 2076.32, '2025-07-09 10:53:47', 'completed', 'KYC109'),
(1011, 'transfer', 114, 121, 5890.75, '2025-07-29 10:53:47', 'pending', 'KYC110'),
(1012, 'deposit', 100, 113, 9573.24, '2025-08-08 10:53:47', 'completed', 'KYC111'),
(1013, 'deposit', 100, 107, 3080.04, '2025-08-08 10:53:47', 'pending', 'KYC112'),
(1014, 'transfer', 115, 108, 9441.15, '2025-08-05 10:53:47', 'completed', 'KYC113'),
(1015, 'deposit', 100, 116, 4896.31, '2025-08-08 10:53:47', 'pending', 'KYC114'),
(1016, 'transfer', 118, 108, 5298.91, '2025-08-06 10:53:47', 'completed', 'KYC115'),
(1017, 'withdrawal', 108, 100, 3623.79, '2025-07-19 10:53:47', 'pending', 'KYC116'),
(1018, 'deposit', 100, 112, 7171.96, '2025-07-27 10:53:47', 'failed', 'KYC117'),
(1019, 'withdrawal', 103, 100, 5328.1, '2025-07-25 10:53:47', 'failed', 'KYC118'),
(1020, 'transfer', 112, 122, 803.31, '2025-07-25 10:53:47', 'pending', 'KYC119'),
(1021, 'withdrawal', 103, 100, 4435.73, '2025-07-28 10:53:47', 'pending', 'KYC120');

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
