-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 02, 2015 at 12:26 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bmoc`
--
CREATE DATABASE IF NOT EXISTS `bmoc` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bmoc`;

-- --------------------------------------------------------

--
-- Table structure for table `as_comments`
--

CREATE TABLE IF NOT EXISTS `as_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `posted_by` int(11) NOT NULL,
  `posted_by_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `post_time` datetime NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `as_login_attempts`
--

CREATE TABLE IF NOT EXISTS `as_login_attempts` (
  `id_login_attempts` int(11) NOT NULL AUTO_INCREMENT,
  `ip_addr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `attempt_number` int(11) NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  PRIMARY KEY (`id_login_attempts`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `as_login_attempts`
--

INSERT INTO `as_login_attempts` (`id_login_attempts`, `ip_addr`, `attempt_number`, `date`) VALUES
(1, '::1', 1, '2015-06-17'),
(2, '::1', 1, '2015-06-18'),
(3, '::1', 2, '2015-06-30'),
(4, '::1', 1, '2015-07-06'),
(5, '127.0.0.1', 2, '2015-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `as_social_logins`
--

CREATE TABLE IF NOT EXISTS `as_social_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'email',
  `provider_id` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `as_users`
--

CREATE TABLE IF NOT EXISTS `as_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_key` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `password_reset_key` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password_reset_confirmed` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `password_reset_timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `register_date` date NOT NULL,
  `user_role` int(4) NOT NULL DEFAULT '1',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `banned` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `as_users`
--

INSERT INTO `as_users` (`user_id`, `email`, `username`, `password`, `confirmation_key`, `confirmed`, `password_reset_key`, `password_reset_confirmed`, `password_reset_timestamp`, `register_date`, `user_role`, `last_login`, `banned`) VALUES
(1, 'admin@localhost', 'admin', '$2a$13$SDPaCBmZQKhqcp2E.rDcSO4wciNB5Oes6Rxk9here39sgKM9zQciu', '', 'Y', '', 'N', '0000-00-00 00:00:00', '2015-06-17', 3, '2015-07-16 14:16:08', 'N'),
(2, 'pavan@gmail.com', 'pavan', '$2a$13$SDPaCBmZQKhqcp2E.rDcSO105Bb.CTFymPtai5u2Reo5/B/SO/cee', 'e9ddb0a47e6d66979fca14d6332f7fd8', 'Y', '', 'Y', '0000-00-00 00:00:00', '2015-06-18', 1, '2015-06-18 07:25:08', 'N'),
(3, 'pavan@test.com', 'dfgdfg', '$2a$13$SDPaCBmZQKhqcp2E.rDcSO105Bb.CTFymPtai5u2Reo5/B/SO/cee', '7a8d592d276d7264b2391de477534ec1', 'N', '', 'N', '0000-00-00 00:00:00', '2015-06-25', 1, '0000-00-00 00:00:00', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `as_user_details`
--

CREATE TABLE IF NOT EXISTS `as_user_details` (
  `id_user_details` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(35) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(35) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id_user_details`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Dumping data for table `as_user_details`
--

INSERT INTO `as_user_details` (`id_user_details`, `user_id`, `first_name`, `last_name`, `phone`, `address`) VALUES
(1, 2, '', '', '', ''),
(2, 3, '', '', '', ''),
(3, 3, '', '', '', ''),
(4, 4, '', '', '', ''),
(5, 5, '', '', '', ''),
(6, 6, '', '', '', ''),
(7, 7, '', '', '', ''),
(8, 8, '', '', '', ''),
(9, 9, '', '', '', ''),
(10, 10, '', '', '', ''),
(11, 11, '', '', '', ''),
(12, 0, '', '', '', ''),
(13, 0, '', '', '', ''),
(14, 12, '', '', '', ''),
(15, 13, '', '', '', ''),
(16, 1, '', '', '', ''),
(17, 2, '', '', '', ''),
(18, 3, '', '', '', ''),
(19, 4, '', '', '', ''),
(20, 5, '', '', '', ''),
(21, 6, '', '', '', ''),
(22, 1, '', '', '', ''),
(23, 2, '', '', '', ''),
(24, 3, '', '', '', ''),
(25, 4, '', '', '', ''),
(26, 5, '', '', '', ''),
(27, 6, '', '', '', ''),
(28, 7, '', '', '', ''),
(29, 8, '', '', '', ''),
(30, 9, '', '', '', ''),
(31, 10, '', '', '', ''),
(32, 11, '', '', '', ''),
(33, 12, '', '', '', ''),
(34, 13, '', '', '', ''),
(35, 14, '', '', '', ''),
(36, 0, '', '', '', ''),
(37, 0, '', '', '', ''),
(38, 2, '', '', '', ''),
(39, 3, '', '', '', ''),
(40, 4, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `as_user_roles`
--

CREATE TABLE IF NOT EXISTS `as_user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `as_user_roles`
--

INSERT INTO `as_user_roles` (`role_id`, `role`) VALUES
(1, 'user'),
(2, 'editor'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bm_admin`
--

CREATE TABLE IF NOT EXISTS `bm_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bm_admin`
--

INSERT INTO `bm_admin` (`id`, `username`, `email`, `password`, `status`) VALUES
(1, 'admin', 'pavanmishra08@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `bm_centers`
--

CREATE TABLE IF NOT EXISTS `bm_centers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `center_name` varchar(256) NOT NULL,
  `address` text NOT NULL,
  `status` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bm_centers`
--

INSERT INTO `bm_centers` (`id`, `center_name`, `address`, `status`) VALUES
(1, 'text', 'text', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `bm_franchise`
--

CREATE TABLE IF NOT EXISTS `bm_franchise` (
  `franchise_id` int(11) NOT NULL AUTO_INCREMENT,
  `franchise_name` varchar(256) NOT NULL,
  `franchise_image` varchar(256) NOT NULL,
  `gender` varchar(256) NOT NULL,
  `franchise_dob` date NOT NULL,
  `franchise_father` varchar(256) NOT NULL,
  `franchise_residence` text NOT NULL,
  `franchise_office` text NOT NULL,
  `franchise_pin` int(11) NOT NULL,
  `franchise_district` varchar(256) NOT NULL,
  `franchise_state` varchar(256) NOT NULL,
  `franchise_email` varchar(256) NOT NULL,
  `contact_no` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `franchise_education` varchar(256) NOT NULL,
  `franchise_experience` varchar(256) NOT NULL,
  `franchise_applied` varchar(256) NOT NULL,
  `franchise_course` varchar(256) NOT NULL,
  `addDateTime` datetime NOT NULL,
  `addIpAddress` varchar(256) NOT NULL,
  `status` varchar(256) NOT NULL,
  `confirmation_key` varchar(256) NOT NULL,
  PRIMARY KEY (`franchise_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bm_franchise`
--

INSERT INTO `bm_franchise` (`franchise_id`, `franchise_name`, `franchise_image`, `gender`, `franchise_dob`, `franchise_father`, `franchise_residence`, `franchise_office`, `franchise_pin`, `franchise_district`, `franchise_state`, `franchise_email`, `contact_no`, `password`, `franchise_education`, `franchise_experience`, `franchise_applied`, `franchise_course`, `addDateTime`, `addIpAddress`, `status`, `confirmation_key`) VALUES
(1, '1', '1', '1', '2015-07-07', '1', '1', '1', 1, '1', '1', '1', '1', '1', '1', '1', '1', '1', '2015-07-21 00:00:00', '1', '1', '1'),
(2, 'Pavan', '1436939785_', 'boy', '2015-07-14', 'sert', 'erter', 'twert', 56456, '456456', '456', 'pavan123@test.com', '456456', 'wfxSDNey', 'fghdfg', 'fghfd', 'BMCF', 'Abacus_Education', '2015-07-15 07:56:25', '::1', 'inactive', '7eb54c2f7da9b117bff2d592d04629d6'),
(3, 'Pavan', '1436939803_', 'boy', '2015-07-14', 'sert', 'erter', 'twert', 56456, '456456', '456', 'pavan1231@test.com', '456456', 'cNE3En1e', 'fghdfg', 'fghfd', 'BMCF', 'Abacus_Education', '2015-07-15 07:56:43', '::1', 'inactive', '773568c8ef48a2e4094c75db694da070'),
(4, 'Pavan', '1436939891_', 'boy', '2015-07-22', 'father', 'sdfsdf', 'sdf', 56456, '456456', 'sdfs', 'pvnmi08@gmail.com', '123456', 'UKPhKRch', 'fghdfg', 'fghfd', 'BMCF', 'Abacus_Education', '2015-07-15 07:58:11', '::1', 'inactive', 'b39ea32d90f98b3a0e60fa56c6b2bd80');

-- --------------------------------------------------------

--
-- Table structure for table `bm_level_master`
--

CREATE TABLE IF NOT EXISTS `bm_level_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bm_level_master`
--

INSERT INTO `bm_level_master` (`id`, `level`) VALUES
(1, 'First1'),
(2, 'Second'),
(3, 'Third'),
(4, 'Third'),
(5, 'Fifth');

-- --------------------------------------------------------

--
-- Table structure for table `bm_questions`
--

CREATE TABLE IF NOT EXISTS `bm_questions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `standard` bigint(20) NOT NULL,
  `subject` bigint(20) NOT NULL,
  `question_level` bigint(20) NOT NULL,
  `question_type` varchar(300) NOT NULL,
  `author` varchar(300) NOT NULL,
  `status` varchar(10) NOT NULL,
  `question` text NOT NULL,
  `answer` varchar(300) NOT NULL,
  `marks` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `bm_questions`
--

INSERT INTO `bm_questions` (`id`, `standard`, `subject`, `question_level`, `question_type`, `author`, `status`, `question`, `answer`, `marks`, `created_at`) VALUES
(30, 1, 1, 1, 'single_answer', 'Ankit', 'Active', 'What is the capital of India', 'Delhi', 2, '2015-08-02 09:41:17'),
(31, 1, 1, 1, 'single_answer', 'Ankit', 'Active', 'What is the capital of US', 'Newyork', 2, '2015-08-02 09:41:17'),
(32, 1, 1, 1, 'single_answer', 'Ankit', 'Active', 'What is the capitl of Austrlia', 'Sidney', 2, '2015-08-02 09:41:17'),
(33, 1, 1, 2, 'objective', 'Ankit Rana', 'Active', '{"question":"What is the capital of India","option_a":"meerut","option_b":"mzn","option_c":"lucknow","option_d":"pune"}', 'Delhi', 4, '2015-08-02 09:46:14'),
(34, 1, 1, 2, 'objective', 'Ankit Rana', 'Active', '{"question":"What is the capital of US","option_a":"meerut","option_b":"mzn","option_c":"lucknow","option_d":"pune"}', 'Newyork', 4, '2015-08-02 09:46:14'),
(35, 1, 1, 2, 'objective', 'Ankit Rana', 'Active', '{"question":"What is the capitl of Austrlia","option_a":"meerut","option_b":"mzn","option_c":"lucknow","option_d":"pune"}', 'Sidney', 4, '2015-08-02 09:46:15'),
(36, 1, 1, 2, 'objective', 'Ankit Rana', 'Active', '{"question":"What is the capital of India","option_a":"meerut","option_b":"mzn","option_c":"lucknow","option_d":"pune"}', 'Delhi', 4, '2015-08-02 09:48:22'),
(37, 1, 1, 2, 'objective', 'Ankit Rana', 'Active', '{"question":"What is the capital of US","option_a":"meerut","option_b":"mzn","option_c":"lucknow","option_d":"pune"}', 'Newyork', 4, '2015-08-02 09:48:22'),
(38, 1, 1, 2, 'objective', 'Ankit Rana', 'Active', '{"question":"What is the capitl of Austrlia","option_a":"meerut","option_b":"mzn","option_c":"lucknow","option_d":"pune"}', 'Sidney', 4, '2015-08-02 09:48:22'),
(39, 2, 1, 1, 'static_image', 'dsgsdgsdg', 'Active', '514ee976179fb73a1308f7fe550404f3a096bd0c.jpeg', 'fhjfgfgj', 5, '2015-08-02 09:49:35'),
(40, 4, 2, 2, 'single_answer', 'Ankit', 'Active', 'Who was first prime minister of India?', 'Pandit Nehru', 3, '2015-08-02 10:57:15'),
(41, 3, 3, 1, 'static_image', 'dgsdg', 'Active', '56a6d476cde62cfe61b1b5cfa95d822017511c63.jpeg', 'dfgsdfas', 4, '2015-08-02 11:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `bm_standard_master`
--

CREATE TABLE IF NOT EXISTS `bm_standard_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `standard` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bm_standard_master`
--

INSERT INTO `bm_standard_master` (`id`, `standard`) VALUES
(1, 'IAS1'),
(2, 'PCS'),
(3, 'SSC'),
(4, 'IBPS');

-- --------------------------------------------------------

--
-- Table structure for table `bm_students`
--

CREATE TABLE IF NOT EXISTS `bm_students` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_name` varchar(256) NOT NULL,
  `student_image` varchar(256) NOT NULL,
  `gender` varchar(256) NOT NULL,
  `student_dob` date NOT NULL,
  `student_mother` varchar(256) NOT NULL,
  `student_father` varchar(256) NOT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `contant_no` varchar(256) NOT NULL,
  `student_email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `exam_lang` varchar(256) NOT NULL,
  `student_class` int(11) NOT NULL,
  `school_name` text NOT NULL,
  `school_address` text NOT NULL,
  `addDateTime` datetime NOT NULL,
  `addIpAddress` varchar(256) NOT NULL,
  `status` varchar(256) NOT NULL,
  `confirmation_key` varchar(256) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `bm_students`
--

INSERT INTO `bm_students` (`student_id`, `student_name`, `student_image`, `gender`, `student_dob`, `student_mother`, `student_father`, `present_address`, `permanent_address`, `contant_no`, `student_email`, `password`, `exam_lang`, `student_class`, `school_name`, `school_address`, `addDateTime`, `addIpAddress`, `status`, `confirmation_key`) VALUES
(1, 'Pavan', 'image.png', 'boy', '2015-07-22', 'mother', 'father', 'vbnvvb', 'nvbn', '123456', 'pavan123@test.com', 'hq6rW3KJ', 'hindi', 1, 'retyretyrtrt', 'vbnvbn', '2015-07-01 14:45:06', '::1', 'inactive', 'a4d17beabc876dcd1db2e09642fd3755'),
(2, 'Pavan', 'image.png', 'boy', '2015-07-24', 'mother', 'father', 'fdgfdg', 'gfdfg', '123456', 'pavan@test.com', 'nyNodwuR', 'hindi', 1, 'retyretyrtrt', 'vbnvbn', '2015-07-01 14:53:40', '::1', 'inactive', '90273280fea9089a8268e14c69aab5dd'),
(3, 'Pavand', 'image.png', 'boy', '2015-07-02', 'mother', 'father', 'dfg', 'fgs', '123456', '14pavan@test.com', 'M02uiot2', 'hindi', 1, 'dfgd', 'gdsfg', '2015-07-02 07:11:16', '::1', 'inactive', '3e34189746cc710adb1827460d71322e'),
(4, 'junxion', 'C:\\fakepath\\image.png', 'boy', '0000-00-00', 'dfds', 'fsdfasd', 'sadfsd', 'fsdf', 'dfasdf', 'pabaam@text.com', 's8kEb1tU', 'hindi', 1, 'fghdfghf', 'ghdf', '2015-07-02 08:39:24', '::1', 'inactive', '62b4a2e8cbe48960de16048a7be3d137'),
(5, 'Pavan', '51.jpg', 'boy', '0000-00-00', 'mother', 'father', 'hjkhjkh', 'ghjk', '123456', 'pavan1234@test.com', 'GVzPcUBy', 'hindi', 1, 'hgjk', 'hjkg', '2015-07-02 08:43:18', '::1', 'inactive', 'e2c3c70c41a7cd5a53b8279d2220f56c'),
(6, 'aarti', '1435819763_C:\\fakepath\\image.png', 'boy', '2015-07-17', 'xcvxcv', 'xcvxc', 'xcvxc', 'vcxv', 'xzvc', 'aarti@text.com', 'noIzR7Dd', 'hindi', 1, 'cvbcxv', 'cvbx', '2015-07-02 08:49:23', '::1', 'inactive', '4b82749f3ba1aaace5741d9b9b00a828'),
(7, 'Pavan', '1435820384_image.png', 'boy', '2015-07-14', 'bnmbnm', 'bnmbnm', 'bnmbn', 'mbnm', 'bnmbn', 'pavan12o3@test.com', 'dhtCRuId', 'hindi', 1, 'vx', 'xvc', '2015-07-02 08:59:44', '::1', 'inactive', 'dab60cc257844df8581f70f053a8ab13'),
(8, 'Pavan', '1435820766_image.png', 'boy', '2015-07-06', 'hfdgh', 'fghf', 'ghfdg', 'hfdgh', 'dfghdfgh', 'pvnmi08@gmail.com', 'hN5Fycu5', 'hindi', 1, 'fdghdfg', 'hfdg', '2015-07-02 09:06:06', '::1', 'inactive', '9b4713ba24e2b6253a72089a2ee0e58c'),
(9, 'junxion', '1435821404_', 'boy', '2015-07-14', 'xcv', 'dfgfg', 'cc', 'xcv', 'xcvxc', 'fsfa@sdfd.com', 'eZIKmWjb', 'hindi', 1, 'dfgdsfg', 'dfg', '2015-07-02 09:16:44', '::1', 'inactive', 'b764f3b3cd63ac998514815fb0c39a09'),
(10, 'junxion', '1435905323_C:\\fakepath\\1_1432554890.gif', 'boy', '2015-07-23', 'ghdfg', 'hfgdh', 'fhfgd', 'hdfgh', 'fdg', 'fghdfg@dsfasd.com', 'mW0eiFC1', 'hindi', 1, 'nm,bnm', ',nm', '2015-07-03 08:35:23', '::1', 'inactive', '9cf9c48a628c9c6a1f9bd4172298c915'),
(11, 'junxion', '1435905395_C:\\fakepath\\1_1432554890.gif', 'boy', '2015-07-23', 'cvbcxvb', 'cxvb', 'cxvbcv', 'bcxv', 'bcb', 'cvbxc@dsfas.in', 'uPLhHJtv', 'hindi', 1, 'vbnvb', 'nvbnc', '2015-07-03 08:36:35', '::1', 'inactive', 'b1d2b7fed73f0df9aedd5d7df5232380'),
(12, 'junxion', '1435905463_C:\\fakepath\\1_1432554890.gif', 'boy', '2015-07-22', 'tyut', 'yuty', 'urtyurtut', 'ryurt', 'tryurt', 'ytyurt@dsfds.in', 'YRW9phfU', 'hindi', 1, 'fhghf', 'gdhfd', '2015-07-03 08:37:43', '::1', 'inactive', '4877553eaf6707fd42924030c5ca5804'),
(13, 'junxion', '1435905536_C:\\fakepath\\1_1432554890.gif', 'boy', '2015-07-15', 'fghdfghf', 'ghfgdh', 'fdghdf', 'ghdfg', 'hdfg', 'fdghdf@dsfgdas.in', 'j1tcmqQC', 'hindi', 1, 'fghf', 'gh', '2015-07-03 08:38:56', '::1', 'inactive', '14ea5c2d4fab39c272b3c4c02d8f4d92'),
(14, 'junxion', '1435906761_C:\\fakepath\\1_1432554890.gif', 'boy', '2015-07-22', 'dfgdfg', 'dfg', 'dfgdfg', 'dfgd', 'dfgdfg', 'dfgds@dsfdsa.in', 'LAEZPBvp', 'hindi', 1, 'gdsfgds', 'fgsd', '2015-07-03 08:59:21', '::1', 'inactive', 'f5de922d92bc21135a551dfc0af268b9');

-- --------------------------------------------------------

--
-- Table structure for table `bm_subject_master`
--

CREATE TABLE IF NOT EXISTS `bm_subject_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bm_subject_master`
--

INSERT INTO `bm_subject_master` (`id`, `subject`) VALUES
(1, 'Reasoning'),
(2, 'Maths'),
(3, 'English'),
(4, 'Hindi'),
(5, 'General Knowledge');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
