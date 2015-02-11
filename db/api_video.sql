-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 18 Des 2014 pada 17.10
-- Versi Server: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project_uzbek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `api_video`
--

CREATE TABLE IF NOT EXISTS `api_video` (
`id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `posted_date` date NOT NULL,
  `expired_date` date DEFAULT NULL,
  `langid` tinyint(4) NOT NULL,
  `author_id` tinyint(4) DEFAULT NULL,
  `video_type` varchar(50) NOT NULL,
  `title_bhs` varchar(200) NOT NULL,
  `brief_bhs` text NOT NULL,
  `content_bhs` text NOT NULL,
  `title_en` varchar(200) NOT NULL,
  `brief_en` text NOT NULL,
  `content_en` text NOT NULL,
  `title_uzbek` varchar(200) NOT NULL,
  `brief_uzbek` text NOT NULL,
  `content_uzbek` text NOT NULL,
  `video` varchar(200) NOT NULL,
  `thumbnail_image` varchar(200) DEFAULT NULL,
  `file` varchar(200) NOT NULL,
  `filesize` int(11) DEFAULT NULL,
  `n_stats` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_video`
--
ALTER TABLE `api_video`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_video`
--
ALTER TABLE `api_video`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
