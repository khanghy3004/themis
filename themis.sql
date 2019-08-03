-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2016 at 09:24 AM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `themis`
--
CREATE DATABASE IF NOT EXISTS `themis` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `themis`;

-- --------------------------------------------------------

--
-- Table structure for table `caidat`
--

CREATE TABLE IF NOT EXISTS `caidat` (
  `submiton` tinyint(1) NOT NULL,
  `registeron` tinyint(1) NOT NULL,
  `viewrank` tinyint(1) NOT NULL,
  `editprofile` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `caidat`
--

INSERT INTO `caidat` (`submiton`, `registeron`, `viewrank`, `editprofile`, `id`) VALUES
(1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `URLS` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Birthday` varchar(255) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `email`, `URLS`, `Name`, `Birthday`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'dangminhtien06@gmail.com', 'http://kienthuc24h.com', '<font color="red"><b>admin</font></b>', '11/09/1998', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
