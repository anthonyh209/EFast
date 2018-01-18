-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2018 at 08:53 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `efake`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `ID_AUCTION` varchar(9) NOT NULL,
  `ID_SELLER` varchar(9) NOT NULL,
  `ID_ITEM` varchar(9) NOT NULL,
  `START_PRICE` double NOT NULL,
  `START_TIMESTAMP` datetime NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `auction`
--
DELIMITER $$
CREATE TRIGGER `populate_id_auction` BEFORE INSERT ON `auction` FOR EACH ROW SET NEW.ID_AUCTION = CONCAT('AU_', SUBSTRING('00000', LENGTH((
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'auction'
    ))), (
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'auction'
    ))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bid`
--

CREATE TABLE `bid` (
  `ID_BID` varchar(9) NOT NULL,
  `ID_BUYER` varchar(9) NOT NULL,
  `ID_AUCTION` varchar(9) NOT NULL,
  `PRICE` double NOT NULL,
  `TIME` datetime NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `bid`
--
DELIMITER $$
CREATE TRIGGER `populate_id_bid` BEFORE INSERT ON `bid` FOR EACH ROW SET NEW.ID_BID = CONCAT('BI_', SUBSTRING('00000', LENGTH((
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'bid'
    ))), (
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'bid'
    ))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID_CATEGORY` varchar(9) NOT NULL,
  `CATEGORY` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `ID_ITEM` varchar(9) NOT NULL,
  `PIC` text NOT NULL,
  `TITLE` text NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `ID_CATEGORY` varchar(9) NOT NULL,
  `ID_STATE` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `ID_RATING` varchar(9) NOT NULL,
  `ID_REVIEWER` varchar(9) NOT NULL,
  `ID_REVIEWEE` varchar(9) NOT NULL,
  `TYPE` tinyint(1) NOT NULL,
  `COMMENT` text NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `rating`
--
DELIMITER $$
CREATE TRIGGER `populate_id_rating` BEFORE INSERT ON `rating` FOR EACH ROW SET NEW.ID_RATING = CONCAT('RA_', SUBSTRING('00000', LENGTH((
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'rating'
    ))), (
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'rating'
    ))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `ID_ROLE` varchar(9) NOT NULL,
  `ROLE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `ID_STATE` varchar(9) NOT NULL,
  `STATE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `traffic`
--

CREATE TABLE `traffic` (
  `ID_VIEW` varchar(9) NOT NULL,
  `ID_AUCTION` varchar(9) NOT NULL,
  `ID_USER` varchar(9) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `traffic`
--
DELIMITER $$
CREATE TRIGGER `populate_id_view` BEFORE INSERT ON `traffic` FOR EACH ROW SET NEW.ID_VIEW = CONCAT('TR_', SUBSTRING('00000', LENGTH((
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'traffic'
    ))), (
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'traffic'
    ))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID_USER` varchar(9) NOT NULL,
  `FNAME` text NOT NULL,
  `LNAME` text NOT NULL,
  `EMAIL` text NOT NULL,
  `PASS` text NOT NULL,
  `ID_ROLE` varchar(9) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID_USER`, `FNAME`, `LNAME`, `EMAIL`, `PASS`, `ID_ROLE`, `ID`) VALUES
('ID_000003', 'Adam', 'Smith', 'adam.smith@hotmail.com', 'pass', 'test', 3);

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `populate_id_user` BEFORE INSERT ON `user` FOR EACH ROW SET NEW.ID_USER = CONCAT('ID_', SUBSTRING('00000', LENGTH((
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'user'
    ))), (
            SELECT AUTO_INCREMENT 
            FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'user'
    ))
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID_CATEGORY`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ID_ITEM`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`ID_ROLE`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`ID_STATE`);

--
-- Indexes for table `traffic`
--
ALTER TABLE `traffic`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bid`
--
ALTER TABLE `bid`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `traffic`
--
ALTER TABLE `traffic`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
