-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2015 at 07:32 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_nomenklatur_rumpun`
--

CREATE TABLE IF NOT EXISTS `api_nomenklatur_rumpun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rumpun` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `api_nomenklatur_rumpun`
--

INSERT INTO `api_nomenklatur_rumpun` (`id`, `rumpun`) VALUES
(1, 'RUMPUN ILMU AGAMA'),
(2, 'RUMPUN ILMU HUMANIORA'),
(3, 'RUMPUN ILMU SOSIAL'),
(4, 'RUMPUN  ILMU ALAM'),
(5, 'RUMPUN  ILMU FORMAT'),
(6, 'RUMPUN  ILMU TERAPAN');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
