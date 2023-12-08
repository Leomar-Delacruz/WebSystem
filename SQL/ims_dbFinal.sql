-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 08, 2023 at 09:04 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `collectingtotalamount`
--

DROP TABLE IF EXISTS `collectingtotalamount`;
CREATE TABLE IF NOT EXISTS `collectingtotalamount` (
  `collectionid` int NOT NULL AUTO_INCREMENT,
  `totalamount` decimal(10,2) NOT NULL,
  `collectiondate` date NOT NULL,
  PRIMARY KEY (`collectionid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `collectingtotalamount`
--

INSERT INTO `collectingtotalamount` (`collectionid`, `totalamount`, `collectiondate`) VALUES
(16, '135.00', '2023-12-06'),
(15, '490.00', '2023-12-05'),
(17, '335.00', '2023-12-06'),
(18, '35.00', '2023-12-08'),
(19, '35.00', '2023-12-08'),
(20, '105.00', '2023-12-08');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `CustomerID` int NOT NULL AUTO_INCREMENT,
  `CustomerName` varchar(100) DEFAULT NULL,
  `ContactNumber` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `CustomerName`, `ContactNumber`, `Email`) VALUES
(1, 'JhonMark', '09123456789', 'jhonmark@example.cpm');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `ProductID` int NOT NULL AUTO_INCREMENT,
  `ProductName` varchar(100) DEFAULT NULL,
  `PricePerUnit` decimal(10,2) DEFAULT NULL,
  `SupplierID` int DEFAULT NULL,
  PRIMARY KEY (`ProductID`),
  KEY `SupplierID` (`SupplierID`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `PricePerUnit`, `SupplierID`) VALUES
(20, 'spoon', '2.00', NULL),
(22, 'Box', '2.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `SupplierID` int NOT NULL AUTO_INCREMENT,
  `SupplierName` varchar(100) DEFAULT NULL,
  `ContactNumber` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`SupplierID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`SupplierID`, `SupplierName`, `ContactNumber`, `Email`, `Address`) VALUES
(1, 'JhonMark', '09123456789', 'jhonmark@example.cpm', 'Cumba Mindanao'),
(2, 'Leomar De la cruz', '09123456987', 'leomar@example.com', 'Paninsingin Tambo');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `transactionid` int NOT NULL AUTO_INCREMENT,
  `productname` varchar(100) NOT NULL,
  `transactiondate` date DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `totalamount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`transactionid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transactionid`, `productname`, `transactiondate`, `quantity`, `price`, `totalamount`) VALUES
(1, 'Spoon', '2023-12-05', 2, '25.00', '50.00'),
(2, 'Paper Plate', '2023-12-05', 5, '25.00', '125.00'),
(3, 'Plastic Cups 8oz', '2023-12-05', 1, '15.00', '15.00'),
(4, 'Chop Stick', '2023-12-05', 1, '100.00', '100.00'),
(5, 'Chop Stick', '2023-12-05', 1, '100.00', '100.00'),
(6, 'Spoon', '2023-12-05', 2, '25.00', '50.00'),
(7, 'Spoon', '2023-12-05', 2, '25.00', '50.00'),
(8, 'Spaghetti Box', '2023-12-06', 1, '135.00', '135.00'),
(9, 'Chop Stick', '2023-12-06', 2, '100.00', '200.00'),
(10, 'Spoon big', '2023-12-08', 3, '35.00', '105.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `usersign` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `usersign`) VALUES
(1, 'admin', 'admin', 'admin', 'Admin'),
(2, 'staff', 'staff', 'staff', 'Staff');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
