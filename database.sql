-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2019 at 09:00 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tambola`
--

-- --------------------------------------------------------

--
-- Table structure for table `numbers`
--

CREATE TABLE `numbers` (
  `number` int(10) NOT NULL,
  `tag_line` varchar(256) NOT NULL,
  `status` varchar(256) NOT NULL DEFAULT 'not_declared',
  `declaration_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `numbers`
--

INSERT INTO `numbers` (`number`, `tag_line`, `status`, `declaration_time`) VALUES
(1, '', 'not_declared', NULL),
(2, '', 'not_declared', NULL),
(3, '', 'not_declared', NULL),
(4, '', 'not_declared', NULL),
(5, '', 'not_declared', NULL),
(6, '', 'not_declared', NULL),
(7, '', 'not_declared', NULL),
(8, '', 'not_declared', NULL),
(9, '', 'not_declared', NULL),
(10, '', 'not_declared', NULL),
(11, '', 'not_declared', NULL),
(12, '', 'not_declared', NULL),
(13, '', 'not_declared', NULL),
(14, '', 'not_declared', NULL),
(15, '', 'not_declared', NULL),
(16, '', 'not_declared', NULL),
(17, '', 'not_declared', NULL),
(18, '', 'not_declared', NULL),
(19, '', 'not_declared', NULL),
(20, '', 'not_declared', NULL),
(21, '', 'not_declared', NULL),
(22, '', 'not_declared', NULL),
(23, '', 'not_declared', NULL),
(24, '', 'not_declared', NULL),
(25, '', 'not_declared', NULL),
(26, '', 'not_declared', NULL),
(27, '', 'not_declared', NULL),
(28, '', 'not_declared', NULL),
(29, '', 'not_declared', NULL),
(30, '', 'not_declared', NULL),
(31, '', 'not_declared', NULL),
(32, '', 'not_declared', NULL),
(33, '', 'not_declared', NULL),
(34, '', 'not_declared', NULL),
(35, '', 'not_declared', NULL),
(36, '', 'not_declared', NULL),
(37, '', 'not_declared', NULL),
(38, '', 'not_declared', NULL),
(39, '', 'not_declared', NULL),
(40, '', 'not_declared', NULL),
(41, '', 'not_declared', NULL),
(42, '', 'not_declared', NULL),
(43, '', 'not_declared', NULL),
(44, '', 'not_declared', NULL),
(45, '', 'not_declared', NULL),
(46, '', 'not_declared', NULL),
(47, '', 'not_declared', NULL),
(48, '', 'not_declared', NULL),
(49, '', 'not_declared', NULL),
(50, '', 'not_declared', NULL),
(51, '', 'not_declared', NULL),
(52, '', 'not_declared', NULL),
(53, '', 'not_declared', NULL),
(54, '', 'not_declared', NULL),
(55, '', 'not_declared', NULL),
(56, '', 'not_declared', NULL),
(57, '', 'not_declared', NULL),
(58, '', 'not_declared', NULL),
(59, '', 'not_declared', NULL),
(60, '', 'not_declared', NULL),
(61, '', 'not_declared', NULL),
(62, '', 'not_declared', NULL),
(63, '', 'not_declared', NULL),
(64, '', 'not_declared', NULL),
(65, '', 'not_declared', NULL),
(66, '', 'not_declared', NULL),
(67, '', 'not_declared', NULL),
(68, '', 'not_declared', NULL),
(69, '', 'not_declared', NULL),
(70, '', 'not_declared', NULL),
(71, '', 'not_declared', NULL),
(72, '', 'not_declared', NULL),
(73, '', 'not_declared', NULL),
(74, '', 'not_declared', NULL),
(75, '', 'not_declared', NULL),
(76, '', 'not_declared', NULL),
(77, '', 'not_declared', NULL),
(78, '', 'not_declared', NULL),
(79, '', 'not_declared', NULL),
(80, '', 'not_declared', NULL),
(81, '', 'not_declared', NULL),
(82, '', 'not_declared', NULL),
(83, '', 'not_declared', NULL),
(84, '', 'not_declared', NULL),
(85, '', 'not_declared', NULL),
(86, '', 'not_declared', NULL),
(87, '', 'not_declared', NULL),
(88, '', 'not_declared', NULL),
(89, '', 'not_declared', NULL),
(90, '', 'not_declared', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(255) NOT NULL,
  `username` varchar(253) NOT NULL,
  `ticket_obj` longtext NOT NULL,
  `claim` varchar(253) NOT NULL,
  `claim_time` timestamp NULL DEFAULT NULL,
  `status` varchar(253) NOT NULL,
  `comment` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(253) NOT NULL,
  `fname` varchar(254) NOT NULL,
  `lname` varchar(254) NOT NULL,
  `role` varchar(20) NOT NULL,
  `email` varchar(253) NOT NULL,
  `password` varbinary(253) NOT NULL,
  `no_tickets` int(5) NOT NULL,
  `status` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`timestamp`, `username`, `fname`, `lname`, `role`, `email`, `password`, `no_tickets`, `status`) VALUES
('2019-05-08 06:44:33', 'admin', 'admin', 'admin', 'ADM', 'niraj.gohel@spec-india.com', 0x13ad15598d7530f058580163c6f3eddd, 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
