-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2020 at 05:47 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `themis`
--

-- --------------------------------------------------------

--
-- Table structure for table `caidat`
--

CREATE TABLE `caidat` (
  `submiton` tinyint(1) NOT NULL,
  `registeron` tinyint(1) NOT NULL,
  `viewrank` tinyint(1) NOT NULL,
  `editprofile` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `caidat`
--

INSERT INTO `caidat` (`submiton`, `registeron`, `viewrank`, `editprofile`, `id`) VALUES
(1, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cauhoi`
--

CREATE TABLE `cauhoi` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `mabai` varchar(10) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `question` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `answer` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `cauhoi`
--

INSERT INTO `cauhoi` (`id`, `username`, `mabai`, `question`, `answer`, `status`) VALUES
(1, 'admin', 'A', 'Bài này làm sao?', 'Tự làm đê con trai', 1),
(2, 'admin', 'B', 'Xin chào các bạn!', 'Cút về làm bài đê', 1),
(3, 'duy', 'A', 'Top 1', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `username` varchar(128) CHARACTER SET latin1 NOT NULL,
  `password` varchar(32) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Name` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `email`, `Name`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '<font color=\"red\"><b>admin</font></b>', 1),
(3, 'hynvkce140237', 'c4ca4238a0b923820dcc509a6f75849b', '', 'Khang Hy', 1),
(4, 'alo', '1b2ccf52b54ea2c9468ca24fbe164919', '', 'Alo', 0),
(335, 'duy', 'c4ca4238a0b923820dcc509a6f75849b', '', 'Duy', 0),
(336, 'vu', 'c4ca4238a0b923820dcc509a6f75849b', '', 'Vũ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `thoigian`
--

CREATE TABLE `thoigian` (
  `id` int(11) NOT NULL,
  `timebegin` datetime NOT NULL,
  `timeend` datetime NOT NULL,
  `name` text COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `maxpoint` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `thoigian`
--

INSERT INTO `thoigian` (`id`, `timebegin`, `timeend`, `name`, `maxpoint`) VALUES
(1, '2020-02-03 01:00:00', '2020-02-29 01:00:00', 'FPT', 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caidat`
--
ALTER TABLE `caidat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cauhoi`
--
ALTER TABLE `cauhoi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thoigian`
--
ALTER TABLE `thoigian`
  ADD PRIMARY KEY (`timeend`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caidat`
--
ALTER TABLE `caidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cauhoi`
--
ALTER TABLE `cauhoi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
