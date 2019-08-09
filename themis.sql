-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2019 at 07:12 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(1, 1, 1, 1, 1);

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
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '<font color="red"><b>admin</font></b>', 1),
(2, 'khangnbpce140201', '1ac8fea598fb6f8eca02dc09e3b551e3', '', 'Phúc Khang', 0),
(3, 'hynvkce140237', 'e5bfd6a9e3ea67e708265db6b40aae2d', '', 'Khang Hy', 1),
(4, 'dunglvnce140405', '3778362936240896e1d082399a653c49', '', 'Ngọc Dung', 0),
(5, 'bangntce130421', 'bbe46fc6f7ad62831da852351e221bfd', '', 'Tuấn Bằng', 0),
(6, 'anhvhlce140319', '3f7ef6d2b9febc83feaa97148003dd0a', '', 'Lan Anh', 0),
(7, 'khanhtdce140230', '05f1b8ba6dbe323960efa4d37b7a741b', '', 'Duy Khánh', 0),
(8, 'khoanace140451', '7cdd3ae44beab9d1de7e67610be2ad34', '', 'An Khoa', 0),
(9, 'khoinhtce140133', '77a8ba8fd1f6ba2607efeaa4d96c4700', '', 'Tuấn Khôi', 0),
(10, 'lamhttce130055', 'd0cd00b4c3439663932dcffc9d63efbd', '', 'Thanh Lam', 0),
(11, 'longnmce140603', 'e3caa9639914f1fd4d13e01d81840f8a', '', 'Minh Long', 0),
(12, 'namvtce140557', 'b5938a68ffc2fd54b923e690431fe234', '', 'Tuệ Nam', 0),
(13, 'nhanpvtce140137', '8ba496f6e222fb0ff541b211a77eb2ee', '', 'Trọng Nhân', 0),
(14, 'phucnpdce140024', 'e7b10a5bd91b9d2b8edecc9d3fd7b209', '', 'Đình Phúc', 0),
(15, 'phuctntce130276', 'd78cb4f8405b37bdadb53cb523a06e49', '', 'Trường Phúc', 0),
(16, 'phunglhtce140418', 'e0cc0a2360a4b8f32d0a5e753ab2af78', '', 'Tiểu Phụng', 0),
(17, 'quynhnlnce140129', '1fb67272b2e447c10defa4d6cddc4d78', '', 'Như Quỳnh', 0),
(18, 'sangphce140487', '9ef1aeeca1a2045189b57f13dd651178', '', 'Hồng Sáng', 0),
(19, 'tanhdce140645', '6333f03443557db4a5b4d779a777b252', '', 'Duy Tân', 0),
(20, 'thailqce140217', '3f413f1b2bbbb438d44fa9d8599371ff', '', 'Quốc Thái', 0),
(21, 'thongncce140589', '787ceb966a8e04af348e96c923be90aa', '', 'Cao Thống', 0),
(22, 'thynvmce140369', '6d7a6e1fd29b7c7e7412ea5205af62af', '', 'Minh Thy', 0),
(23, 'tinphtce140639', 'cddc4745b7d77a04ab4b71448310a365', '', 'Trung Tín', 0),
(24, 'tuandace140502', '1448912bad176ca2c63948e0ed7f8b43', '', 'Anh Tuấn', 0),
(25, 'tuongtkce140347', 'e21124a6596c9c19c78bef20e15bb281', '', 'Khánh Tường', 0),
(26, 'uyennlpce140422', 'c7e86ae782792a0eb2119495c2f9bc13', '', 'Phương Uyên', 0),
(27, 'vuntce140419', 'bb02535092750dfd216b7fb2a21c7ad8', '', 'Tấn Vủ', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caidat`
--
ALTER TABLE `caidat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caidat`
--
ALTER TABLE `caidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
