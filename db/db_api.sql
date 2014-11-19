-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 17, 2014 at 04:57 PM
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
  PRIMARY KEY (`id`)
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
  `parentid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `brief` text NOT NULL,
  `content` text NOT NULL,
  `image` varchar(200) NOT NULL,
  `thumbnail_image` varchar(200) NOT NULL,
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
  `tags` text NOT NULL COMMENT 'format serialize tags',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

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
(7, 0, 0, 'kliping', 'csasa', 'csacsacas', '', '', '', 1, 2, '', '', '', '2014-10-15 12:02:08', '0000-00-00 00:00:00', '2014-10-15 00:00:00', 0, 0, 0, '', 1, 1, 0),
(8, 0, 0, 'tes agenda', '', '', '', '', '', 2, 0, '', '', '', '2014-10-15 12:12:47', '2014-10-22 11:10:00', '2014-10-15 11:10:00', 0, 0, 0, '', 1, 1, 0),
(9, 0, 0, 'agenda 1', '', '', '', '', '', 2, 0, '', '', '', '2014-10-15 13:16:49', '2014-10-05 12:15:00', '2014-10-02 12:15:00', 0, 0, 0, '', 1, 1, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

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
(36, 10050, '', '', 2, '', '2014-11-17 16:45:09', 0);

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
  `verified_date` datetime NOT NULL,
  `img` varchar(200) DEFAULT NULL COMMENT 'GIID Image',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10051 ;

--
-- Dumping data for table `social_member`
--

INSERT INTO `social_member` (`id`, `nip`, `name`, `nickname`, `email`, `register_date`, `verified_date`, `img`, `image_profile`, `small_img`, `username`, `last_login`, `city`, `zipcode`, `sex`, `birthday`, `description`, `middle_name`, `last_name`, `StreetName`, `phone_number`, `pendidikan`, `kepakaran`, `alamatKantor`, `tlpKantor`, `keberhasilan`, `n_status`, `login_count`, `verified`, `usertype`, `email_token`, `photo_moderation`, `salt`, `password`) VALUES
(10043, NULL, 'ovan', NULL, 'ovan89@gmail.com', '2014-07-16 07:53:04', '0000-00-00 00:00:00', NULL, '', NULL, 'admin', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, NULL, 0, 'codekir v3.0', 'b2e982d12c95911b6abeacad24e256ff3fa47fdb'),
(10044, NULL, NULL, NULL, 'cscasa', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '', 0, '', 'b29ae6a39d92d241eb88425f0e249a8234ff3b59'),
(10045, NULL, NULL, NULL, 'ncjanca', '2014-11-17 03:55:48', '0000-00-00 00:00:00', NULL, '', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '3msajw73cieyn2ysyadi24', 0, 'ovancop1234', '57067623e9f334a4842682a961add9bd2141da1a'),
(10046, 'csaca', 'cascsa', NULL, 'nckncaknca', '2014-11-17 04:08:37', '0000-00-00 00:00:00', NULL, '', NULL, NULL, NULL, NULL, 0, NULL, '0000-00-00', NULL, NULL, NULL, 'csacasc', 'ascasc', 'cacsa', 'csacas', 'acasca', 'csaca', NULL, 0, 0, 0, 1, 'weda23yimiys3acs27nj4y', 0, 'ovancop1234', '146b958573c7b78f11130abbb00c6f06085b9b86'),
(10047, NULL, NULL, NULL, 'cacsacas', '2014-11-17 05:43:26', '0000-00-00 00:00:00', NULL, '', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, '37ya2iywssi24jmed3yacn', 0, 'ovancop1234', 'db08ac19c565b170d167744edc204c751d0303ee'),
(10048, NULL, NULL, NULL, 'csaacacascas', '2014-11-17 05:44:35', '0000-00-00 00:00:00', NULL, '', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 'a3wjes4sacmi27ny23diyy', 0, 'ovancop1234', '7919565b4c17dcc9382bb52e8ad837aba2ba21f6'),
(10049, 'csacsa', 'csacsa', NULL, 'csakmck', '2014-11-17 05:45:56', '0000-00-00 00:00:00', NULL, '', NULL, NULL, NULL, NULL, 0, NULL, '0000-00-00', NULL, NULL, NULL, 'csasc', 'csacas', 'cacas', 'cacacsa', 'cascsa', 'csaca', 'csacsaca', 0, 0, 0, 1, 'csi2i2yae3n3y4swm7adyj', 0, 'ovancop1234', 'a4fed6a6a8cdbdb1d94317d1b3f9ef58149fe8c1'),
(10050, '', '', NULL, '', '2014-11-17 09:40:35', '0000-00-00 00:00:00', NULL, '', NULL, NULL, NULL, NULL, 0, NULL, '0000-00-00', NULL, NULL, NULL, '', '', '', '', '', '', NULL, 0, 0, 0, 1, 'es3ay23j7yy42wasiindmc', 0, 'ovancop1234', 'd822cc6212695ea7b831e481159f7acae42a5877');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
