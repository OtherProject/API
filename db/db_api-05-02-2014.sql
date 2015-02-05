-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2015 at 08:27 AM
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
-- Table structure for table `activity_log`
--

CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `activityId` int(11) NOT NULL,
  `activityDesc` text NOT NULL,
  `source` varchar(20) NOT NULL,
  `datetimes` datetime NOT NULL,
  `n_status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_member`
--

CREATE TABLE IF NOT EXISTS `admin_member` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(46) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(46) DEFAULT NULL,
  `salt` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `n_status` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin_member`
--

INSERT INTO `admin_member` (`id`, `name`, `nickname`, `email`, `register_date`, `username`, `salt`, `password`, `n_status`) VALUES
(1, 'admin', 'admin', 'admin@example.com', '2014-08-08 05:56:36', 'admin', 'codekir v3.0', 'b2e982d12c95911b6abeacad24e256ff3fa47fdb', 1);

-- --------------------------------------------------------

--
-- Table structure for table `api_category`
--

CREATE TABLE IF NOT EXISTS `api_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `relation` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `n_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `api_member_interest`
--

CREATE TABLE IF NOT EXISTS `api_member_interest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `date_join` varchar(300) NOT NULL,
  `n_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `api_news_category`
--

CREATE TABLE IF NOT EXISTS `api_news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catName` varchar(100) DEFAULT NULL,
  `n_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `api_news_category`
--

INSERT INTO `api_news_category` (`id`, `catName`, `n_status`) VALUES
(1, 'Artikel', 1),
(2, 'Agenda', 1),
(3, 'Tentang', 1),
(4, 'Afiliasi', 1),
(5, 'Kepakaran', 1),
(6, 'Buah Pikir', 1),
(7, 'Perundangan', 1),
(8, 'Repositori', 1),
(9, 'Gallery', 1);

-- --------------------------------------------------------

--
-- Table structure for table `api_news_content`
--

CREATE TABLE IF NOT EXISTS `api_news_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `lid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `brief` text NOT NULL,
  `content` text NOT NULL,
  `image` varchar(200) NOT NULL,
  `thumbnail_image` varchar(200) DEFAULT NULL,
  `slider_image` varchar(200) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `articleType` int(11) NOT NULL COMMENT '1:news,2:profil,3:publikasi',
  `url` varchar(200) NOT NULL,
  `sourceurl` varchar(100) NOT NULL,
  `file` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `expired_date` datetime NOT NULL,
  `posted_date` datetime NOT NULL,
  `fromwho` int(11) NOT NULL DEFAULT '0' COMMENT '0:web or admin ;1:user ;2:pages',
  `filesize` int(11) NOT NULL,
  `can_save` int(11) NOT NULL,
  `tags` text COMMENT 'format serialize tags',
  `authorid` int(11) NOT NULL,
  `n_status` int(11) NOT NULL DEFAULT '0',
  `topcontent` int(11) NOT NULL DEFAULT '0' COMMENT '0;standart;1:featured;2:review;3:interview',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `categoryid` (`categoryid`),
  KEY `created_date` (`created_date`),
  KEY `posted_date` (`posted_date`),
  KEY `n_status` (`n_status`),
  KEY `articleTypeID` (`articleType`),
  KEY `image` (`image`),
  KEY `parentID` (`parentid`),
  KEY `lid` (`lid`),
  KEY `online` (`fromwho`),
  KEY `expired_date` (`expired_date`),
  KEY `url` (`url`),
  KEY `aid` (`authorid`),
  KEY `file` (`file`),
  KEY `slider_image` (`slider_image`),
  KEY `sourceurl` (`filesize`),
  KEY `thumbnail_image` (`thumbnail_image`),
  KEY `topcontent` (`topcontent`),
  KEY `sourceurl_2` (`sourceurl`),
  KEY `can_save` (`can_save`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `api_news_content`
--

INSERT INTO `api_news_content` (`id`, `parentid`, `lid`, `title`, `brief`, `content`, `image`, `thumbnail_image`, `slider_image`, `categoryid`, `articleType`, `url`, `sourceurl`, `file`, `created_date`, `expired_date`, `posted_date`, `fromwho`, `filesize`, `can_save`, `tags`, `authorid`, `n_status`, `topcontent`) VALUES
(1, 0, 0, 'test', 'ada', 'adsaas', '', '', '', 0, 0, '', '', '', '2014-09-10 08:51:49', '0000-00-00 00:00:00', '2014-09-03 00:00:00', 0, 0, 0, '', 1, 1, 0),
(2, 0, 0, 'test', 'csacsaa', 'cascsacsa', '', '', '', 0, 0, '', '', '', '2014-10-02 12:02:40', '0000-00-00 00:00:00', '2014-10-01 00:00:00', 0, 0, 0, '', 1, 1, 0),
(3, 0, 0, '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;        &lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;        &lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '0e4974e00ab53caf3704aadd18f4dd98.png', '', '', 3, 1, '', '', 'http://localhost/API/public_assets/news/0e4974e00ab53caf3704aadd18f4dd98.png', '2014-10-15 11:39:51', '0000-00-00 00:00:00', '2014-11-17 16:35:46', 0, 0, 0, '', 1, 1, 0),
(4, 0, 0, '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&lt;/p&gt;', '', '', '', 3, 2, '', '', '', '2014-10-15 11:50:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', 1, 1, 0),
(5, 0, 0, 'artikel 1', 'tess', '&lt;p class=&quot;text-justify&quot;&gt;                Integer nibh orci, elementum quis adipiscing non, tristique ut risus. Cras elementum, nunc vel egestas tincidunt, magna sem tristique dolor, vel molestie enim nibh non lectus. Aliquam lacinia ipsum ut risus dapibus ullamcorper congue risus feugiat. Praesent venenatis nibh id est egestas sagittis. Maecenas euismod diam id justo tempus a volutpat velit pretium. Duis enim quam, fringilla in dignissim eu, mattis in lectus. Maecenas rutrum turpis sed elit Integer nibh orci, elementum quis adipiscing non, tristique ut risus.            &lt;/p&gt;', '', '', '', 1, 1, '', '', 'http://localhost/API/', '2014-10-15 11:54:26', '0000-00-00 00:00:00', '2014-10-15 00:00:00', 0, 0, 0, '', 1, 1, 0),
(6, 0, 0, 'betita', 'csaasas', 'csacacas', '', '', '', 1, 1, '', '', '', '2014-10-15 12:01:33', '0000-00-00 00:00:00', '2014-10-15 00:00:00', 0, 0, 0, '', 1, 1, 0),
(7, 0, 0, 'kliping', 'csasa', 'csacsacas adsdasdaas&lt;br&gt;', '', '', '', 1, 2, '', '', '', '2014-10-15 12:02:08', '0000-00-00 00:00:00', '2014-12-02 00:00:00', 0, 0, 0, '', 1, 1, 0),
(8, 0, 0, 'tes agenda', '', '', '', '', '', 2, 0, '', '', '', '2014-10-15 12:12:47', '2014-10-22 11:10:00', '2014-10-15 11:10:00', 0, 0, 0, '', 1, 1, 0),
(9, 0, 0, 'agenda 1', '', '', '', '', '', 2, 0, '', '', '', '2014-10-15 13:16:49', '2014-10-05 12:15:00', '2014-10-02 12:15:00', 0, 0, 0, '', 1, 1, 0),
(10, 0, 0, 'test album', '', '', 'd7d559b5e3c246535be627efc2dcde47.jpg', '', '', 9, 1, '', '', 'http://localhost/API/public_assets/gallery/images/d7d559b5e3c246535be627efc2dcde47.jpg', '2015-01-23 14:00:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, '', 0, 0, 0),
(11, 0, 0, 'coba', 'oke', 'test aja&lt;br&gt;', '9ad77cee0067310a9812fa101c6c86af.jpg', '', '', 1, 1, '', '', 'http://localhost/API/public_assets/news/9ad77cee0067310a9812fa101c6c86af.jpg', '2015-01-23 14:42:08', '0000-00-00 00:00:00', '2015-01-10 00:00:00', 0, 0, 0, '', 1, 1, 0),
(12, 0, 0, 'testing escape cksa''csaca &quot;oke&quot;', 'dsadasds', 'cskak''asda mckmamsla &quot;sdadas&quot;&lt;br&gt;', '', '', '', 1, 1, '', '', '', '2015-02-04 11:49:19', '0000-00-00 00:00:00', '2015-02-04 00:00:00', 0, 0, 0, '', 1, 1, 0),
(13, 0, 0, 'test kliping', 'test kliping', 'test kliping', '', NULL, '', 1, 2, '', '', '', '2015-02-04 14:34:41', '0000-00-00 00:00:00', '2015-02-04 00:00:00', 0, 0, 0, NULL, 1, 1, 0),
(14, 0, 0, 'csacaas', 'csaca', 'csaacasc', '', NULL, '', 1, 2, '', '', '', '2015-02-04 19:05:56', '0000-00-00 00:00:00', '2015-02-04 00:00:00', 0, 0, 0, NULL, 1, 1, 0),
(15, 0, 0, 'fasaa', 'scaasaca', 'csaa', '', NULL, '', 1, 2, '', '', '', '2015-02-04 19:06:20', '0000-00-00 00:00:00', '2015-02-05 00:00:00', 0, 0, 0, NULL, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `api_news_content_comment`
--

CREATE TABLE IF NOT EXISTS `api_news_content_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `contentid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  `n_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `userid` (`userid`),
  KEY `contentid` (`contentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `api_news_content_repo`
--

CREATE TABLE IF NOT EXISTS `api_news_content_repo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `brief` text NOT NULL,
  `content` text NOT NULL,
  `typealbum` int(11) NOT NULL COMMENT '1:song;2:images;3:video',
  `gallerytype` int(11) NOT NULL COMMENT '0:content,1:contest',
  `files` varchar(200) NOT NULL COMMENT 'can be image or song',
  `thumbnail` varchar(200) NOT NULL,
  `fromwho` int(11) NOT NULL COMMENT '0;admin;1:user;2:pages',
  `otherid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `n_status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `otherid` (`otherid`),
  KEY `IDX_typeAlbum` (`typealbum`),
  KEY `IDX_Album_ID` (`gallerytype`),
  KEY `IDX_FROM_WHO` (`fromwho`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `api_news_content_repo`
--

INSERT INTO `api_news_content_repo` (`id`, `title`, `brief`, `content`, `typealbum`, `gallerytype`, `files`, `thumbnail`, `fromwho`, `otherid`, `userid`, `created_date`, `n_status`) VALUES
(1, '', '', 'cd5ffbb489f4be0113f37eeb2301740f.jpg', 2, 9, 'http://localhost/API/public_assets/gallery/images/cd5ffbb489f4be0113f37eeb2301740f.jpg', '', 0, 10, 0, '2015-01-23 14:00:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `api_nomenklatur`
--

CREATE TABLE IF NOT EXISTS `api_nomenklatur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `content` varchar(100) DEFAULT NULL,
  `n_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `api_riwayat_pendidikan`
--

CREATE TABLE IF NOT EXISTS `api_riwayat_pendidikan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL DEFAULT '0',
  `tahun` varchar(4) DEFAULT NULL,
  `judul` varchar(200) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0:mtkuliah, 1:publikasi, 2:pekerjaan',
  `keterangan` varchar(300) DEFAULT NULL,
  `createDate` datetime NOT NULL,
  `n_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `api_riwayat_pendidikan`
--

INSERT INTO `api_riwayat_pendidikan` (`id`, `userID`, `tahun`, `judul`, `type`, `keterangan`, `createDate`, `n_status`) VALUES
(1, 10049, '2131', 'sacsa', 0, 'csac', '2014-11-17 12:47:35', 0),
(2, 10049, '2131', 'csac', 0, 'ascas', '2014-11-17 12:47:35', 0),
(3, 10049, '2131', 'csaca', 0, 'csaca', '2014-11-17 12:47:35', 0),
(4, 10049, '2131', 'cas', 1, 'csaca', '2014-11-17 12:47:35', 0),
(5, 10049, '2131', 'asc', 1, 'csa', '2014-11-17 12:47:35', 0),
(6, 10049, '2131', 'cac', 1, 'casc', '2014-11-17 12:47:35', 0),
(7, 10049, '2131', 'csaca', 2, 'csac', '2014-11-17 12:47:35', 0),
(8, 10049, '2131', 'asc', 2, 'csa', '2014-11-17 12:47:35', 0),
(9, 10049, '2131', 'csac', 2, 'casc', '2014-11-17 12:47:35', 0),
(10, 10050, '', '', 0, '', '2014-11-17 16:44:47', 0),
(11, 10050, '', '', 0, '', '2014-11-17 16:44:47', 0),
(12, 10050, '', '', 0, '', '2014-11-17 16:44:47', 0),
(13, 10050, '', '', 1, '', '2014-11-17 16:44:47', 0),
(14, 10050, '', '', 1, '', '2014-11-17 16:44:47', 0),
(15, 10050, '', '', 1, '', '2014-11-17 16:44:47', 0),
(16, 10050, '', '', 2, '', '2014-11-17 16:44:47', 0),
(17, 10050, '', '', 2, '', '2014-11-17 16:44:47', 0),
(18, 10050, '', '', 2, '', '2014-11-17 16:44:47', 0),
(19, 10050, '', '', 0, '', '2014-11-17 16:44:55', 0),
(20, 10050, '', '', 0, '', '2014-11-17 16:44:55', 0),
(21, 10050, '', '', 0, '', '2014-11-17 16:44:55', 0),
(22, 10050, '', '', 1, '', '2014-11-17 16:44:55', 0),
(23, 10050, '', '', 1, '', '2014-11-17 16:44:55', 0),
(24, 10050, '', '', 1, '', '2014-11-17 16:44:55', 0),
(25, 10050, '', '', 2, '', '2014-11-17 16:44:55', 0),
(26, 10050, '', '', 2, '', '2014-11-17 16:44:55', 0),
(27, 10050, '', '', 2, '', '2014-11-17 16:44:55', 0),
(28, 10050, '', '', 0, '', '2014-11-17 16:45:09', 0),
(29, 10050, '', '', 0, '', '2014-11-17 16:45:09', 0),
(30, 10050, '', '', 0, '', '2014-11-17 16:45:09', 0),
(31, 10050, '', '', 1, '', '2014-11-17 16:45:09', 0),
(32, 10050, '', '', 1, '', '2014-11-17 16:45:09', 0),
(33, 10050, '', '', 1, '', '2014-11-17 16:45:09', 0),
(34, 10050, '', '', 2, '', '2014-11-17 16:45:09', 0),
(35, 10050, '', '', 2, '', '2014-11-17 16:45:09', 0),
(36, 10050, '', '', 2, '', '2014-11-17 16:45:09', 0),
(37, 1, '2014', 'tess', 0, 'oke', '2014-12-09 23:06:02', 0),
(38, 1, '', '', 0, '', '2014-12-09 23:06:02', 0),
(39, 1, '', '', 0, '', '2014-12-09 23:06:02', 0),
(40, 1, '2014', 'kosong', 1, 'sama', '2014-12-09 23:06:02', 0),
(41, 1, '', '', 1, '', '2014-12-09 23:06:02', 0),
(42, 1, '', '', 1, '', '2014-12-09 23:06:02', 0),
(43, 1, '2014', 'gundar', 2, 'dosen', '2014-12-09 23:06:02', 0),
(44, 1, '', '', 2, '', '2014-12-09 23:06:02', 0),
(45, 1, '', '', 2, '', '2014-12-09 23:06:02', 0),
(46, 1, '2014', 'tess', 0, 'oke', '2014-12-09 23:06:50', 0),
(47, 1, '', '', 0, '', '2014-12-09 23:06:50', 0),
(48, 1, '', '', 0, '', '2014-12-09 23:06:50', 0),
(49, 1, '123', 'kosong', 1, 'sama', '2014-12-09 23:06:50', 0),
(50, 1, '', '', 1, '', '2014-12-09 23:06:50', 0),
(51, 1, '', '', 1, '', '2014-12-09 23:06:50', 0),
(52, 1, '2014', 'gundar', 2, 'dosen', '2014-12-09 23:06:50', 0),
(53, 1, '', '', 2, '', '2014-12-09 23:06:50', 0),
(54, 1, '', '', 2, '', '2014-12-09 23:06:50', 0),
(55, 1, '2014', 'tess', 0, 'oke', '2014-12-09 23:07:03', 0),
(56, 1, '', '', 0, '', '2014-12-09 23:07:03', 0),
(57, 1, '', '', 0, '', '2014-12-09 23:07:03', 0),
(58, 1, '123', 'kosong', 1, 'sama', '2014-12-09 23:07:03', 0),
(59, 1, '', '', 1, '', '2014-12-09 23:07:03', 0),
(60, 1, '', '', 1, '', '2014-12-09 23:07:03', 0),
(61, 1, '2014', 'gundar', 2, 'dosen', '2014-12-09 23:07:03', 0),
(62, 1, '', '', 2, '', '2014-12-09 23:07:03', 0),
(63, 1, '', '', 2, '', '2014-12-09 23:07:03', 0),
(64, 1, '2014', 'tess', 0, 'oke', '2014-12-09 23:09:19', 0),
(65, 1, '', '', 0, '', '2014-12-09 23:09:19', 0),
(66, 1, '', '', 0, '', '2014-12-09 23:09:19', 0),
(67, 1, '123', 'kosong', 1, 'sama', '2014-12-09 23:09:19', 0),
(68, 1, '', '', 1, '', '2014-12-09 23:09:19', 0),
(69, 1, '', '', 1, '', '2014-12-09 23:09:19', 0),
(70, 1, '2014', 'gundar', 2, 'dosen', '2014-12-09 23:09:19', 0),
(71, 1, '', '', 2, '', '2014-12-09 23:09:19', 0),
(72, 1, '', '', 2, '', '2014-12-09 23:09:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `social_member`
--

CREATE TABLE IF NOT EXISTS `social_member` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) DEFAULT NULL,
  `name` varchar(46) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verified_date` datetime DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL COMMENT 'Persetujuan Image',
  `image_profile` varchar(200) NOT NULL,
  `small_img` varchar(200) DEFAULT NULL,
  `username` varchar(46) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `zipcode` int(10) NOT NULL,
  `sex` varchar(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `description` text,
  `middle_name` varchar(46) DEFAULT NULL,
  `last_name` varchar(46) DEFAULT NULL,
  `StreetName` varchar(150) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `pendidikan` varchar(20) DEFAULT NULL,
  `kepakaran` varchar(100) DEFAULT NULL,
  `alamatKantor` varchar(300) DEFAULT NULL,
  `tlpKantor` varchar(20) DEFAULT NULL,
  `keberhasilan` varchar(300) DEFAULT NULL,
  `n_status` int(3) NOT NULL DEFAULT '0' COMMENT ' pending , approved, verified, rejected , deleted ( 7 day ), deactivated ( kill my self )',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `verified` tinyint(3) DEFAULT '0' COMMENT '0->no hp blm verified, 1->sudah verified.',
  `usertype` int(11) NOT NULL COMMENT '0:online;1:offline;2;existing',
  `email_token` varchar(50) DEFAULT NULL,
  `photo_moderation` int(11) NOT NULL,
  `salt` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `social_member`
--

INSERT INTO `social_member` (`id`, `nip`, `name`, `nickname`, `email`, `register_date`, `verified_date`, `img`, `image_profile`, `small_img`, `username`, `last_login`, `city`, `zipcode`, `sex`, `birthday`, `description`, `middle_name`, `last_name`, `StreetName`, `phone_number`, `pendidikan`, `kepakaran`, `alamatKantor`, `tlpKantor`, `keberhasilan`, `n_status`, `login_count`, `verified`, `usertype`, `email_token`, `photo_moderation`, `salt`, `password`) VALUES
(1, '123', 'ovan pulu', NULL, 'ovan@gmail.com', '2014-12-09 16:04:25', NULL, '168d2b29b4ea028a4714af69a1d89131.png', '', NULL, NULL, NULL, NULL, 0, NULL, '0000-00-00', NULL, NULL, NULL, 'depok', '1234', 's2', 'semantic', 'jakarta', '321', NULL, 0, 0, 0, 1, '2m7ny2saaisy3ey4cwjd3i', 0, 'ovancop1234', '3bf34316ca21533589737d23ff56af02c3d4ee3f'),
(2, '', '', NULL, 'ovasdjak@fmscks.com', '2015-02-04 04:37:07', NULL, NULL, '', NULL, NULL, NULL, NULL, 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '', '', NULL, 0, 0, 0, 1, 'jemyicisaawy42n33dsy72', 0, 'ovancop1234', '99c1ae34ee109d52109e368c0cb30c49bb480a55'),
(3, NULL, NULL, NULL, 'njcan@mfsd.com', '2015-02-04 04:42:14', NULL, NULL, '', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 'iyje3assdw4ny3y2ami2c7', 0, 'ovancop1234', '62d0b5a60f1634efe45eb4dd03810a97553ce67f'),
(4, 'dsadsa', 'dasda', NULL, 'okvan@dcsmk.com', '2015-02-04 11:56:19', NULL, NULL, '', NULL, NULL, NULL, NULL, 0, NULL, '0000-00-00', NULL, NULL, NULL, 'dsada', 'dsada', 'dsada', 'dsad', 'dsada', 'dsada', NULL, 0, 0, 0, 1, '2myii2sjcns4yaay3w3e7d', 0, 'ovancop1234', '62d0b5a60f1634efe45eb4dd03810a97553ce67f');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
