-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2017 at 10:14 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tiles`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id_authors` int(11) NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id_authors`, `icon`) VALUES
(1, 'author-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tiles`
--

CREATE TABLE `tiles` (
  `id_tiles` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` char(4) NOT NULL,
  `img` text NOT NULL,
  `img_alt` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `show_date` char(1) NOT NULL,
  `id_authors` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tiles`
--

INSERT INTO `tiles` (`id_tiles`, `title`, `type`, `img`, `img_alt`, `date`, `show_date`, `id_authors`) VALUES
(1, 'Fantastic designs of 2015 concept cars', 'main', 'photo-1.jpg', 'Mountains', '2015-11-28', 't', 1),
(2, 'How to find design inspiration in the simple things around you', 'norm', 'photo-2.jpg', 'Girl jumping into the water', '2015-11-24', 't', 1),
(3, 'The only guide to choosing website photos you''ll ever need', 'norm', 'photo-3.jpg', 'Bird', '2015-11-18', 't', 1),
(4, 'Growth hack your way to a successful freelance career', 'norm', 'photo-4.jpg', 'Cat', '0000-00-00', 'f', 1),
(5, 'Get 80% off dslr photography course bundle', 'norm', 'photo-5.jpg', 'Land', '2015-11-08', 't', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id_authors`);

--
-- Indexes for table `tiles`
--
ALTER TABLE `tiles`
  ADD PRIMARY KEY (`id_tiles`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id_authors` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tiles`
--
ALTER TABLE `tiles`
  MODIFY `id_tiles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
