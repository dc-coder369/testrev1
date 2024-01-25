-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2024 at 02:05 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testdbgmrcrev`
--

-- --------------------------------------------------------

--
-- Table structure for table `tab_logs_fileupload`
--

CREATE TABLE `tab_logs_fileupload` (
  `id` int(11) NOT NULL,
  `Sc_Name` varchar(50) DEFAULT NULL,
  `station_name` varchar(50) DEFAULT NULL,
  `file_type` varchar(155) DEFAULT NULL,
  `filename` varchar(256) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `record_date` date DEFAULT NULL,
  `current_time` datetime NOT NULL DEFAULT current_timestamp(),
  `upload_by` int(11) DEFAULT NULL,
  `folder_name` varchar(100) DEFAULT NULL,
  `Remark` varchar(200) DEFAULT NULL,
  `log_type` varchar(20) NOT NULL COMMENT 'upload,download'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tab_logs_fileupload`
--

INSERT INTO `tab_logs_fileupload` (`id`, `Sc_Name`, `station_name`, `file_type`, `filename`, `size`, `record_date`, `current_time`, `upload_by`, `folder_name`, `Remark`, `log_type`) VALUES
(8, 'dsad', 'apmc', 'Daily_Earning_Sheet', 'apmc_3.capacidad_65b0f1c51ea60.xlsx', '2.16', '2024-01-05', '2024-01-24 16:47:25', 33, 'Daily_Earning_Sheet/2024/Jan/05', '', 'upload'),
(9, 'dsad', 'apmc', 'Daily_Earning_Sheet', 'apmc_2010 service standards compliance review - MITC template - No 1 23 05 2012_65b0f1c521ce2.xlsx', '0.67', '2024-01-05', '2024-01-24 16:47:25', 33, 'Daily_Earning_Sheet/2024/Jan/05', '', 'upload'),
(10, 'dsad', 'apmc', 'Penalty', 'apmc_2010 service standards compliance review - MITC template - No 1 23 05 2012_65b0f1eb6de3e.xlsx', '0.67', '2024-01-05', '2024-01-24 16:48:03', 33, 'Penalty/2024/Jan/05', '', 'upload'),
(11, 'asdfasdf', 'apmc', 'Daily_Earning_Sheet', 'apmc_2011_ghg_emissions_spreadsheet_65b0f525dec2c.xlsx', '0.12', '2024-01-05', '2024-01-24 17:01:49', 33, 'Daily_Earning_Sheet/2024/Jan/05', '', 'upload'),
(12, 'asdfasdf', 'apmc', 'Daily_Earning_Sheet', 'apmc_2011+SEPA+Utility+Solar+Rankings+Data-Preview_65b0f525dfaf7.xlsx', '0.33', '2024-01-05', '2024-01-24 17:01:49', 33, 'Daily_Earning_Sheet/2024/Jan/05', '', 'upload'),
(13, 'asdfasdf', 'apmc', 'Daily_Earning_Sheet', 'apmc_2012 TRACK AND FIELD STANDARDS_65b0f525e0ba2.xlsx', '0.02', '2024-01-05', '2024-01-24 17:01:49', 33, 'Daily_Earning_Sheet/2024/Jan/05', '', 'upload'),
(14, 'chintan', 'apmc', 'Daily_Earning_Sheet', 'apmc_2010 service standards compliance review - MITC template - No 1 23 05 2012_65b0f75bd28de.xlsx', '0.67', '2024-01-05', '2024-01-24 17:11:15', 33, 'Daily_Earning_Sheet/2024/Jan/05', 'fnckjdsnckjd', 'upload'),
(15, 'chintan', 'apmc', 'Daily_Earning_Sheet', 'apmc_2011_ghg_emissions_spreadsheet_65b0f75bd3785.xlsx', '0.12', '2024-01-05', '2024-01-24 17:11:15', 33, 'Daily_Earning_Sheet/2024/Jan/05', 'fnckjdsnckjd', 'upload'),
(16, 'chintan', 'apmc', 'Daily_Earning_Sheet', 'apmc_2011+SEPA+Utility+Solar+Rankings+Data-Preview_65b0f75bd44d7.xlsx', '0.33', '2024-01-05', '2024-01-24 17:11:15', 33, 'Daily_Earning_Sheet/2024/Jan/05', 'fnckjdsnckjd', 'upload'),
(17, 'Chintan', 'apmc', 'Penalty', 'apmc_2010 service standards compliance review - MITC template - No 1 23 05 2012_65b0fd8f68efd.xlsx', '0.67', '2024-01-05', '2024-01-24 17:37:43', 33, 'Penalty/2024/Jan/05', 'ncjancjaj', 'upload'),
(18, 'Chintan', 'apmc', 'Daily_Earning_Sheet', 'apmc_2010 service standards compliance review - MITC template - No 1 23 05 2012_65b0fdbc22c3c.xlsx', '0.67', '2024-01-05', '2024-01-24 17:38:28', 33, 'Daily_Earning_Sheet/2024/Jan/05', 'dsadas', 'upload'),
(19, 'ggg', 'apmc', 'Daily_Earning_Sheet', 'apmc_00_00_00_SAMPLE SUBMISSION FORM_PI_Lastname_First_Name1_65b0ff4f5440c.xlsx', '0.87', '2024-01-04', '2024-01-24 17:45:11', 33, 'Daily_Earning_Sheet/2024/Jan/04', 'sss', 'upload'),
(20, 'vvjh', 'apmc', 'Daily_Earning_Sheet', 'apmc_00_00_00_SAMPLE SUBMISSION FORM_PI_Lastname_First_Name1_65b0ff59e7979.xlsx', '0.87', '2024-01-04', '2024-01-24 17:45:21', 33, 'Daily_Earning_Sheet/2024/Jan/04', 'svhcachshj', 'upload'),
(21, 'Ccc', 'cmsr', 'Daily_Earning_Sheet', 'cmsr_2011+SEPA+Utility+Solar+Rankings+Data-Preview_65b1f45750b40.xlsx', '0.33', '2024-01-25', '2024-01-25 11:10:39', 13, 'Daily_Earning_Sheet/2024/Jan/25', 'test', 'upload'),
(22, 'Ccc', 'cmsr', 'Daily_Earning_Sheet', 'cmsr_2012 TRACK AND FIELD STANDARDS_65b1f45752f7a.xlsx', '0.02', '2024-01-25', '2024-01-25 11:10:39', 13, 'Daily_Earning_Sheet/2024/Jan/25', 'test', 'upload'),
(23, 'Ccc', 'cmsr', 'Daily_Earning_Sheet', 'cmsr_2012-TK-MasterPrice-List_65b1f457537f6.xlsx', '0.55', '2024-01-25', '2024-01-25 11:10:39', 13, 'Daily_Earning_Sheet/2024/Jan/25', 'test', 'upload'),
(24, 'dsd', 'cmsr', 'Penalty', 'cmsr_00_00_00_SAMPLE SUBMISSION FORM_PI_Lastname_First_Name1_65b1f47184346.xlsx', '0.87', '2024-01-25', '2024-01-25 11:11:05', 13, 'Penalty/2024/Jan/25', 'gfdg', 'upload'),
(25, 'dasd', 'gkrd', 'Daily_Earning_Sheet', 'gkrd_sample2 (2)_65b1f4c88c8cf.xlsx', '0.03', '2024-01-25', '2024-01-25 11:12:32', 15, 'Daily_Earning_Sheet/2024/Jan/25', 'dfasfsd', 'upload'),
(26, 'dasd', 'gkrd', 'Daily_Earning_Sheet', 'gkrd_sample2_65b1f4c88d369.xlsx', '0.03', '2024-01-25', '2024-01-25 11:12:32', 15, 'Daily_Earning_Sheet/2024/Jan/25', 'dfasfsd', 'upload'),
(27, 'dasd', 'gkrd', 'Daily_Earning_Sheet', 'gkrd_sample3_65b1f4c88dbb6.xlsx', '0.01', '2024-01-25', '2024-01-25 11:12:32', 15, 'Daily_Earning_Sheet/2024/Jan/25', 'dfasfsd', 'upload'),
(28, 'dadss', 'gkrd', 'URC', 'gkrd_sample2 (2)_65b1f4e554314.xlsx', '0.03', '2024-01-25', '2024-01-25 11:13:01', 15, 'URC/2024/Jan/25', 'fsdfsdf', 'upload'),
(29, 'dadss', 'gkrd', 'URC', 'gkrd_sample2_65b1f4e5550e4.xlsx', '0.03', '2024-01-25', '2024-01-25 11:13:01', 15, 'URC/2024/Jan/25', 'fsdfsdf', 'upload'),
(30, 'dadss', 'gkrd', 'URC', 'gkrd_sample3_65b1f4e555ac8.xlsx', '0.01', '2024-01-25', '2024-01-25 11:13:01', 15, 'URC/2024/Jan/25', 'fsdfsdf', 'upload'),
(31, 'dfasdas', 'gkrd', 'Penalty', 'gkrd_sample1_65b1f4f5948c6.xlsx', '0.03', '2024-01-25', '2024-01-25 11:13:17', 15, 'Penalty/2024/Jan/25', 'fasf', 'upload'),
(32, 'dfasdas', 'gkrd', 'Penalty', 'gkrd_sample2 (1)_65b1f4f5953ad.xlsx', '0.03', '2024-01-25', '2024-01-25 11:13:17', 15, 'Penalty/2024/Jan/25', 'fasf', 'upload'),
(33, 'dasdasd', 'gkrd', 'URC', 'gkrd_sample2 (1)_65b1f50b706b2.xlsx', '0.03', '2024-01-25', '2024-01-25 11:13:39', 15, 'URC/2024/Jan/25', 'fafasf', 'upload'),
(34, 'dasdasd', 'gkrd', 'URC', 'gkrd_sample2 (2)_65b1f50b7103f.xlsx', '0.03', '2024-01-25', '2024-01-25 11:13:39', 15, 'URC/2024/Jan/25', 'fafasf', 'upload'),
(35, 'dasdasd', 'gkrd', 'URC', 'gkrd_sample2_65b1f50b7182f.xlsx', '0.03', '2024-01-25', '2024-01-25 11:13:39', 15, 'URC/2024/Jan/25', 'fafasf', 'upload'),
(36, 'dsa', 'gkrd', 'Manual_Collection', 'gkrd_2011_ghg_emissions_spreadsheet_65b1f7bc92c11.xlsx', '0.12', '2024-01-25', '2024-01-25 11:25:08', 15, 'Manual_Collection/2024/Jan/25', 'asdfaf', 'upload'),
(37, 'dsa', 'gkrd', 'Manual_Collection', 'gkrd_2011+SEPA+Utility+Solar+Rankings+Data-Preview_65b1f7bc9432a.xlsx', '0.33', '2024-01-25', '2024-01-25 11:25:08', 15, 'Manual_Collection/2024/Jan/25', 'asdfaf', 'upload'),
(38, NULL, 'revenuecell', NULL, 'download-all', NULL, '2024-01-25', '2024-01-25 11:32:06', NULL, NULL, NULL, 'download'),
(39, NULL, 'revenuecell', NULL, 'download-all', NULL, '2024-01-25', '2024-01-25 11:42:08', NULL, NULL, NULL, 'download');

-- --------------------------------------------------------

--
-- Table structure for table `tab_logs_lockunlock`
--

CREATE TABLE `tab_logs_lockunlock` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `timestamp` datetime NOT NULL,
  `lock_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tab_logs_lockunlock`
--

INSERT INTO `tab_logs_lockunlock` (`id`, `date`, `timestamp`, `lock_status`) VALUES
(1, '2023-12-06', '2023-12-06 00:00:00', '0'),
(2, '2023-12-06', '2023-12-06 00:00:00', '1'),
(3, '2023-12-06', '2023-12-06 16:16:37', '0'),
(4, '2023-12-06', '2023-12-06 16:17:49', '1'),
(5, '2023-12-06', '2023-12-07 12:18:27', '0'),
(6, '2023-12-07', '2023-12-07 12:32:12', '0'),
(7, '2023-12-06', '2023-12-07 12:32:15', '1'),
(8, '2023-12-07', '2023-12-07 17:42:31', '1'),
(9, '2023-12-07', '2023-12-07 17:42:33', '0'),
(10, '2023-12-07', '2023-12-07 13:35:50', '1'),
(11, '2023-12-07', '2023-12-07 13:36:08', '0'),
(12, '2023-12-07', '2023-12-09 13:35:46', '1'),
(13, '2023-12-09', '2023-12-09 13:37:33', '0'),
(14, '2023-12-09', '2023-12-09 13:45:20', '1'),
(15, '2023-12-09', '2023-12-09 13:45:20', '0'),
(16, '2023-12-09', '2023-12-09 13:45:27', '1'),
(17, '2023-12-09', '2023-12-09 13:45:28', '0'),
(18, '2023-12-09', '2023-12-09 13:45:29', '1'),
(19, '2023-12-09', '2023-12-09 13:45:29', '0'),
(20, '2023-12-09', '2023-12-09 13:45:29', '1'),
(21, '2023-12-09', '2023-12-09 13:45:30', '0'),
(22, '2023-12-18', '2023-12-18 13:30:54', '0'),
(23, '2023-12-18', '2023-12-18 13:30:54', '0'),
(24, '2023-12-18', '2023-12-18 14:08:40', '1'),
(25, '2023-12-18', '2023-12-18 14:08:43', '0'),
(26, '2023-12-18', '2023-12-18 14:08:43', '0'),
(27, '2023-12-18', '2023-12-18 15:57:55', '1'),
(28, '2023-12-18', '2023-12-18 18:39:02', '0'),
(29, '2023-12-19', '2023-12-19 07:18:22', '0'),
(30, '2023-12-19', '2023-12-19 12:05:31', '1'),
(31, '2023-12-19', '2023-12-19 12:05:31', '1'),
(32, '2023-12-19', '2023-12-19 12:05:31', 'Locked'),
(33, '2023-12-19', '2023-12-19 12:18:41', 'Unlocked'),
(34, '2023-12-19', '2023-12-19 12:18:42', 'Locked'),
(35, '2023-12-19', '2023-12-19 17:01:36', 'Unlocked'),
(36, '2023-12-20', '2023-12-20 15:38:22', 'Unlocked'),
(37, '2023-12-21', '2023-12-21 14:25:10', 'Unlocked'),
(38, '2023-12-22', '2023-12-22 15:27:27', 'Unlocked'),
(39, '2023-12-27', '2023-12-27 15:45:17', 'Unlocked'),
(40, '2023-12-17', '2023-12-27 15:45:34', 'Unlocked'),
(41, '2023-12-16', '2023-12-27 15:45:40', 'Unlocked'),
(42, '2023-12-15', '2023-12-27 15:45:46', 'Unlocked'),
(43, '2024-01-01', '2024-01-01 11:48:53', 'Unlocked'),
(44, '2024-01-01', '2024-01-01 14:38:07', 'Locked'),
(45, '2024-01-03', '2024-01-03 11:02:25', 'Unlocked'),
(46, '2024-01-03', '2024-01-03 11:12:31', 'Locked'),
(47, '2024-01-03', '2024-01-03 11:12:31', 'Unlocked'),
(48, '2024-01-03', '2024-01-03 11:12:32', 'Locked'),
(49, '2024-01-03', '2024-01-03 11:12:33', 'Unlocked'),
(50, '2024-01-03', '2024-01-03 11:12:34', 'Locked'),
(51, '2024-01-03', '2024-01-03 11:21:28', 'Unlocked'),
(52, '2024-01-03', '2024-01-03 11:21:39', 'Locked'),
(53, '2024-01-03', '2024-01-03 11:21:45', 'Unlocked'),
(54, '2024-01-03', '2024-01-03 11:21:46', 'Locked'),
(55, '2024-01-03', '2024-01-03 11:21:49', 'Unlocked'),
(56, '2024-01-03', '2024-01-03 11:21:53', 'Locked'),
(57, '2024-01-03', '2024-01-03 11:21:54', 'Unlocked'),
(58, '2024-01-03', '2024-01-03 11:21:55', 'Locked'),
(59, '2024-01-03', '2024-01-03 11:21:59', 'Unlocked'),
(60, '2023-12-31', '2024-01-03 11:26:03', 'Unlocked'),
(61, '2023-12-31', '2024-01-03 11:26:03', 'Locked'),
(62, '2024-01-03', '2024-01-03 11:26:06', 'Locked'),
(63, '2024-01-02', '2024-01-03 11:26:21', 'Unlocked'),
(64, '2024-01-03', '2024-01-03 11:26:22', 'Unlocked'),
(65, '2024-01-02', '2024-01-03 11:26:34', 'Locked'),
(66, '2024-01-04', '2024-01-04 15:01:07', 'Locked'),
(67, '2024-01-04', '2024-01-04 15:01:15', 'Unlocked'),
(68, '2024-01-04', '2024-01-04 15:03:19', 'Locked'),
(69, '2024-01-03', '2024-01-04 15:03:31', 'Unlocked'),
(70, '2024-01-03', '2024-01-04 15:03:46', 'Locked'),
(71, '2024-01-04', '2024-01-04 15:52:46', 'Unlocked'),
(72, '2024-01-05', '2024-01-05 08:13:27', 'Unlocked'),
(73, '2024-01-05', '2024-01-05 08:14:02', 'Unlocked'),
(74, '2024-01-05', '2024-01-05 08:14:49', 'Locked'),
(75, '2024-01-05', '2024-01-05 08:15:00', 'Unlocked'),
(76, '2024-01-05', '2024-01-05 08:15:17', 'Locked'),
(77, '2024-01-05', '2024-01-05 08:15:32', 'Unlocked'),
(78, '2024-01-05', '2024-01-05 08:15:33', 'Locked'),
(79, '2024-01-05', '2024-01-05 08:15:34', 'Unlocked'),
(80, '2024-01-05', '2024-01-05 08:15:41', 'Locked'),
(81, '2024-01-04', '2024-01-05 08:16:10', 'Locked'),
(82, '2024-01-04', '2024-01-05 08:16:11', 'Unlocked'),
(83, '2024-01-05', '2024-01-05 13:15:19', 'Unlocked'),
(84, '2024-01-15', '2024-01-15 09:26:33', 'Unlocked'),
(85, '2024-01-23', '2024-01-23 12:41:38', 'Unlocked'),
(86, '2024-01-05', '2024-01-24 17:19:02', 'Locked'),
(87, '2024-01-05', '2024-01-24 17:19:06', 'Unlocked'),
(88, '2024-01-05', '2024-01-24 17:40:31', 'Locked'),
(89, '2024-01-24', '2024-01-24 17:49:56', 'Unlocked'),
(90, '2024-01-25', '2024-01-25 11:10:11', 'Unlocked');

-- --------------------------------------------------------

--
-- Table structure for table `tab_revdailyreport_temp`
--

CREATE TABLE `tab_revdailyreport_temp` (
  `id` int(11) NOT NULL,
  `business_type` varchar(50) DEFAULT NULL,
  `line` varchar(50) DEFAULT NULL,
  `station` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `inorout` varchar(50) DEFAULT NULL,
  `transaction_type` varchar(50) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `amt` float DEFAULT NULL,
  `deposit` float DEFAULT NULL,
  `handling_fee` float DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tab_status_lockupload`
--

CREATE TABLE `tab_status_lockupload` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `lock_upload` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tab_status_lockupload`
--

INSERT INTO `tab_status_lockupload` (`id`, `date`, `lock_upload`) VALUES
(1, '2023-11-01', 1),
(2, '2023-11-02', 1),
(3, '2023-11-03', 1),
(4, '2023-11-04', 1),
(5, '2023-11-05', 1),
(6, '2023-11-06', 1),
(7, '2023-11-07', 1),
(8, '2023-11-08', 1),
(9, '2023-11-09', 1),
(10, '2023-11-10', 1),
(11, '2023-11-11', 1),
(12, '2023-11-12', 1),
(13, '2023-11-13', 1),
(14, '2023-11-14', 1),
(15, '2023-11-15', 1),
(16, '2023-11-16', 1),
(17, '2023-11-17', 1),
(18, '2023-11-18', 1),
(19, '2023-11-19', 1),
(20, '2023-11-20', 1),
(21, '2023-11-21', 1),
(22, '2023-11-22', 1),
(23, '2023-11-23', 1),
(24, '2023-11-24', 1),
(25, '2023-11-25', 1),
(26, '2023-11-26', 1),
(27, '2023-11-27', 1),
(28, '2023-11-28', 1),
(29, '2023-11-29', 0),
(30, '2023-11-30', 1),
(31, '2023-12-01', 0),
(32, '2023-12-02', 1),
(33, '2023-12-03', 1),
(34, '2023-12-04', 0),
(35, '2023-12-05', 1),
(36, '2023-12-06', 1),
(37, '2023-12-07', 1),
(38, '2023-12-08', 1),
(39, '2023-12-09', 0),
(40, '2023-12-10', 1),
(41, '2023-12-11', 1),
(42, '2023-12-12', 1),
(43, '2023-12-13', 1),
(44, '2023-12-14', 1),
(45, '2023-12-15', 0),
(46, '2023-12-16', 0),
(47, '2023-12-17', 0),
(48, '2023-12-18', 0),
(49, '2023-12-19', 0),
(50, '2023-12-20', 0),
(51, '2023-12-21', 0),
(52, '2023-12-22', 0),
(53, '2023-12-23', 1),
(54, '2023-12-24', 1),
(55, '2023-12-25', 1),
(56, '2023-12-26', 1),
(57, '2023-12-27', 0),
(58, '2023-12-28', 1),
(59, '2023-12-29', 1),
(60, '2023-12-30', 1),
(61, '2023-12-31', 1),
(62, '2024-01-01', 1),
(63, '2024-01-02', 1),
(64, '2024-01-03', 1),
(65, '2024-01-04', 0),
(66, '2024-01-05', 1),
(67, '2024-01-06', 1),
(68, '2024-01-07', 1),
(69, '2024-01-08', 1),
(70, '2024-01-09', 1),
(71, '2024-01-10', 1),
(72, '2024-01-11', 1),
(73, '2024-01-12', 1),
(74, '2024-01-13', 1),
(75, '2024-01-14', 1),
(76, '2024-01-15', 0),
(77, '2024-01-16', 1),
(78, '2024-01-17', 1),
(79, '2024-01-18', 1),
(80, '2024-01-19', 1),
(81, '2024-01-20', 1),
(82, '2024-01-21', 1),
(83, '2024-01-22', 1),
(84, '2024-01-23', 0),
(85, '2024-01-24', 0),
(86, '2024-01-25', 0),
(87, '2024-01-26', 1),
(88, '2024-01-27', 1),
(89, '2024-01-28', 1),
(90, '2024-01-29', 1),
(91, '2024-01-30', 1),
(92, '2024-01-31', 1),
(93, '2024-02-01', 1),
(94, '2024-02-02', 1),
(95, '2024-02-03', 1),
(96, '2024-02-04', 1),
(97, '2024-02-05', 1),
(98, '2024-02-06', 1),
(99, '2024-02-07', 1),
(100, '2024-02-08', 1),
(101, '2024-02-09', 1),
(102, '2024-02-10', 1),
(103, '2024-02-11', 1),
(104, '2024-02-12', 1),
(105, '2024-02-13', 1),
(106, '2024-02-14', 1),
(107, '2024-02-15', 1),
(108, '2024-02-16', 1),
(109, '2024-02-17', 1),
(110, '2024-02-18', 1),
(111, '2024-02-19', 1),
(112, '2024-02-20', 1),
(113, '2024-02-21', 1),
(114, '2024-02-22', 1),
(115, '2024-02-23', 1),
(116, '2024-02-24', 1),
(117, '2024-02-25', 1),
(118, '2024-02-26', 1),
(119, '2024-02-27', 1),
(120, '2024-02-28', 1),
(121, '2024-02-29', 1),
(122, '2024-03-01', 1),
(123, '2024-03-02', 1),
(124, '2024-03-03', 1),
(125, '2024-03-04', 1),
(126, '2024-03-05', 1),
(127, '2024-03-06', 1),
(128, '2024-03-07', 1),
(129, '2024-03-08', 1),
(130, '2024-03-09', 1),
(131, '2024-03-10', 1),
(132, '2024-03-11', 1),
(133, '2024-03-12', 1),
(134, '2024-03-13', 1),
(135, '2024-03-14', 1),
(136, '2024-03-15', 1),
(137, '2024-03-16', 1),
(138, '2024-03-17', 1),
(139, '2024-03-18', 1),
(140, '2024-03-19', 1),
(141, '2024-03-20', 1),
(142, '2024-03-21', 1),
(143, '2024-03-22', 1),
(144, '2024-03-23', 1),
(145, '2024-03-24', 1),
(146, '2024-03-25', 1),
(147, '2024-03-26', 1),
(148, '2024-03-27', 1),
(149, '2024-03-28', 1),
(150, '2024-03-29', 1),
(151, '2024-03-30', 1),
(152, '2024-03-31', 1),
(153, '2024-04-01', 1),
(154, '2024-04-02', 1),
(155, '2024-04-03', 1),
(156, '2024-04-04', 1),
(157, '2024-04-05', 1),
(158, '2024-04-06', 1),
(159, '2024-04-07', 1),
(160, '2024-04-08', 1),
(161, '2024-04-09', 1),
(162, '2024-04-10', 1),
(163, '2024-04-11', 1),
(164, '2024-04-12', 1),
(165, '2024-04-13', 1),
(166, '2024-04-14', 1),
(167, '2024-04-15', 1),
(168, '2024-04-16', 1),
(169, '2024-04-17', 1),
(170, '2024-04-18', 1),
(171, '2024-04-19', 1),
(172, '2024-04-20', 1),
(173, '2024-04-21', 1),
(174, '2024-04-22', 1),
(175, '2024-04-23', 1),
(176, '2024-04-24', 1),
(177, '2024-04-25', 1),
(178, '2024-04-26', 1),
(179, '2024-04-27', 1),
(180, '2024-04-28', 1),
(181, '2024-04-29', 1),
(182, '2024-04-30', 1),
(183, '2024-05-01', 1),
(184, '2024-05-02', 1),
(185, '2024-05-03', 1),
(186, '2024-05-04', 1),
(187, '2024-05-05', 1),
(188, '2024-05-06', 1),
(189, '2024-05-07', 1),
(190, '2024-05-08', 1),
(191, '2024-05-09', 1),
(192, '2024-05-10', 1),
(193, '2024-05-11', 1),
(194, '2024-05-12', 1),
(195, '2024-05-13', 1),
(196, '2024-05-14', 1),
(197, '2024-05-15', 1),
(198, '2024-05-16', 1),
(199, '2024-05-17', 1),
(200, '2024-05-18', 1),
(201, '2024-05-19', 1),
(202, '2024-05-20', 1),
(203, '2024-05-21', 1),
(204, '2024-05-22', 1),
(205, '2024-05-23', 1),
(206, '2024-05-24', 1),
(207, '2024-05-25', 1),
(208, '2024-05-26', 1),
(209, '2024-05-27', 1),
(210, '2024-05-28', 1),
(211, '2024-05-29', 1),
(212, '2024-05-30', 1),
(213, '2024-05-31', 1),
(214, '2024-06-01', 1),
(215, '2024-06-02', 1),
(216, '2024-06-03', 1),
(217, '2024-06-04', 1),
(218, '2024-06-05', 1),
(219, '2024-06-06', 1),
(220, '2024-06-07', 1),
(221, '2024-06-08', 1),
(222, '2024-06-09', 1),
(223, '2024-06-10', 1),
(224, '2024-06-11', 1),
(225, '2024-06-12', 1),
(226, '2024-06-13', 1),
(227, '2024-06-14', 1),
(228, '2024-06-15', 1),
(229, '2024-06-16', 1),
(230, '2024-06-17', 1),
(231, '2024-06-18', 1),
(232, '2024-06-19', 1),
(233, '2024-06-20', 1),
(234, '2024-06-21', 1),
(235, '2024-06-22', 1),
(236, '2024-06-23', 1),
(237, '2024-06-24', 1),
(238, '2024-06-25', 1),
(239, '2024-06-26', 1),
(240, '2024-06-27', 1),
(241, '2024-06-28', 1),
(242, '2024-06-29', 1),
(243, '2024-06-30', 1),
(244, '2024-07-01', 1),
(245, '2024-07-02', 1),
(246, '2024-07-03', 1),
(247, '2024-07-04', 1),
(248, '2024-07-05', 1),
(249, '2024-07-06', 1),
(250, '2024-07-07', 1),
(251, '2024-07-08', 1),
(252, '2024-07-09', 1),
(253, '2024-07-10', 1),
(254, '2024-07-11', 1),
(255, '2024-07-12', 1),
(256, '2024-07-13', 1),
(257, '2024-07-14', 1),
(258, '2024-07-15', 1),
(259, '2024-07-16', 1),
(260, '2024-07-17', 1),
(261, '2024-07-18', 1),
(262, '2024-07-19', 1),
(263, '2024-07-20', 1),
(264, '2024-07-21', 1),
(265, '2024-07-22', 1),
(266, '2024-07-23', 1),
(267, '2024-07-24', 1),
(268, '2024-07-25', 1),
(269, '2024-07-26', 1),
(270, '2024-07-27', 1),
(271, '2024-07-28', 1),
(272, '2024-07-29', 1),
(273, '2024-07-30', 1),
(274, '2024-07-31', 1),
(275, '2024-08-01', 1),
(276, '2024-08-02', 1),
(277, '2024-08-03', 1),
(278, '2024-08-04', 1),
(279, '2024-08-05', 1),
(280, '2024-08-06', 1),
(281, '2024-08-07', 1),
(282, '2024-08-08', 1),
(283, '2024-08-09', 1),
(284, '2024-08-10', 1),
(285, '2024-08-11', 1),
(286, '2024-08-12', 1),
(287, '2024-08-13', 1),
(288, '2024-08-14', 1),
(289, '2024-08-15', 1),
(290, '2024-08-16', 1),
(291, '2024-08-17', 1),
(292, '2024-08-18', 1),
(293, '2024-08-19', 1),
(294, '2024-08-20', 1),
(295, '2024-08-21', 1),
(296, '2024-08-22', 1),
(297, '2024-08-23', 1),
(298, '2024-08-24', 1),
(299, '2024-08-25', 1),
(300, '2024-08-26', 1),
(301, '2024-08-27', 1),
(302, '2024-08-28', 1),
(303, '2024-08-29', 1),
(304, '2024-08-30', 1),
(305, '2024-08-31', 1),
(306, '2024-09-01', 1),
(307, '2024-09-02', 1),
(308, '2024-09-03', 1),
(309, '2024-09-04', 1),
(310, '2024-09-05', 1),
(311, '2024-09-06', 1),
(312, '2024-09-07', 1),
(313, '2024-09-08', 1),
(314, '2024-09-09', 1),
(315, '2024-09-10', 1),
(316, '2024-09-11', 1),
(317, '2024-09-12', 1),
(318, '2024-09-13', 1),
(319, '2024-09-14', 1),
(320, '2024-09-15', 1),
(321, '2024-09-16', 1),
(322, '2024-09-17', 1),
(323, '2024-09-18', 1),
(324, '2024-09-19', 1),
(325, '2024-09-20', 1),
(326, '2024-09-21', 1),
(327, '2024-09-22', 1),
(328, '2024-09-23', 1),
(329, '2024-09-24', 1),
(330, '2024-09-25', 1),
(331, '2024-09-26', 1),
(332, '2024-09-27', 1),
(333, '2024-09-28', 1),
(334, '2024-09-29', 1),
(335, '2024-09-30', 1),
(336, '2024-10-01', 1),
(337, '2024-10-02', 1),
(338, '2024-10-03', 1),
(339, '2024-10-04', 1),
(340, '2024-10-05', 1),
(341, '2024-10-06', 1),
(342, '2024-10-07', 1),
(343, '2024-10-08', 1),
(344, '2024-10-09', 1),
(345, '2024-10-10', 1),
(346, '2024-10-11', 1),
(347, '2024-10-12', 1),
(348, '2024-10-13', 1),
(349, '2024-10-14', 1),
(350, '2024-10-15', 1),
(351, '2024-10-16', 1),
(352, '2024-10-17', 1),
(353, '2024-10-18', 1),
(354, '2024-10-19', 1),
(355, '2024-10-20', 1),
(356, '2024-10-21', 1),
(357, '2024-10-22', 1),
(358, '2024-10-23', 1),
(359, '2024-10-24', 1),
(360, '2024-10-25', 1),
(361, '2024-10-26', 1),
(362, '2024-10-27', 1),
(363, '2024-10-28', 1),
(364, '2024-10-29', 1),
(365, '2024-10-30', 1),
(366, '2024-10-31', 1),
(367, '2024-11-01', 1),
(368, '2024-11-02', 1),
(369, '2024-11-03', 1),
(370, '2024-11-04', 1),
(371, '2024-11-05', 1),
(372, '2024-11-06', 1),
(373, '2024-11-07', 1),
(374, '2024-11-08', 1),
(375, '2024-11-09', 1),
(376, '2024-11-10', 1),
(377, '2024-11-11', 1),
(378, '2024-11-12', 1),
(379, '2024-11-13', 1),
(380, '2024-11-14', 1),
(381, '2024-11-15', 1),
(382, '2024-11-16', 1),
(383, '2024-11-17', 1),
(384, '2024-11-18', 1),
(385, '2024-11-19', 1),
(386, '2024-11-20', 1),
(387, '2024-11-21', 1),
(388, '2024-11-22', 1),
(389, '2024-11-23', 1),
(390, '2024-11-24', 1),
(391, '2024-11-25', 1),
(392, '2024-11-26', 1),
(393, '2024-11-27', 1),
(394, '2024-11-28', 1),
(395, '2024-11-29', 1),
(396, '2024-11-30', 1),
(397, '2024-12-01', 1),
(398, '2024-12-02', 1),
(399, '2024-12-03', 1),
(400, '2024-12-04', 1),
(401, '2024-12-05', 1),
(402, '2024-12-06', 1),
(403, '2024-12-07', 1),
(404, '2024-12-08', 1),
(405, '2024-12-09', 1),
(406, '2024-12-10', 1),
(407, '2024-12-11', 1),
(408, '2024-12-12', 1),
(409, '2024-12-13', 1),
(410, '2024-12-14', 1),
(411, '2024-12-15', 1),
(412, '2024-12-16', 1),
(413, '2024-12-17', 1),
(414, '2024-12-18', 1),
(415, '2024-12-19', 1),
(416, '2024-12-20', 1),
(417, '2024-12-21', 1),
(418, '2024-12-22', 1),
(419, '2024-12-23', 1),
(420, '2024-12-24', 1),
(421, '2024-12-25', 1),
(422, '2024-12-26', 1),
(423, '2024-12-27', 1),
(424, '2024-12-28', 1),
(425, '2024-12-29', 1),
(426, '2024-12-30', 1),
(427, '2024-12-31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tab_stmaster_temp`
--

CREATE TABLE `tab_stmaster_temp` (
  `id` int(11) NOT NULL,
  `DATE` date DEFAULT NULL,
  `ST_NAME` varchar(50) DEFAULT NULL,
  `ST_CODE` varchar(50) DEFAULT NULL,
  `SAF_NO` float DEFAULT NULL,
  `EQ_NAME` varchar(50) DEFAULT NULL,
  `EQ_NO` float DEFAULT NULL,
  `CST_FET_QTY` float DEFAULT NULL,
  `CST_IR_QTY` float DEFAULT NULL,
  `SJT_QTY` float DEFAULT NULL,
  `SJT_AMT` float DEFAULT NULL,
  `RJT_QTY` float DEFAULT NULL,
  `RJT_AMT` float DEFAULT NULL,
  `PET_QTY` float DEFAULT NULL,
  `PET_AMT` float DEFAULT NULL,
  `SJT_CANCEL_QTY` float DEFAULT NULL,
  `SJT_CANCEL_AMT` float DEFAULT NULL,
  `RJT_CANCEL_QTY` float DEFAULT NULL,
  `RJT_CANCEL_AMT` float DEFAULT NULL,
  `SJT_RFND_QTY` float DEFAULT NULL,
  `SJT_RFND_AMT` float DEFAULT NULL,
  `RJT_RFND_FULL_QTY` float DEFAULT NULL,
  `RJT_RFND_2TRIP_QTY` float DEFAULT NULL,
  `RJT_RFND_2TRIP_AMT` float DEFAULT NULL,
  `CSC_QTY` float DEFAULT NULL,
  `CSC_AMT` float DEFAULT NULL,
  `CSC_IR_QTY` float DEFAULT NULL,
  `CSC_IR_AMT` float DEFAULT NULL,
  `CSC_CANCEL_QTY` float DEFAULT NULL,
  `CSC_CANCEL_AMT` float DEFAULT NULL,
  `CSC_READABLERFND_QTY` float DEFAULT NULL,
  `CSC_READABLERFND_AMT` float DEFAULT NULL,
  `CSC_TOURISTTICKET_QTY` float DEFAULT NULL,
  `CSC_TOURISTTICKET_AMT` float DEFAULT NULL,
  `CSC_ADDVAL_QTY` float DEFAULT NULL,
  `CSC_ADDVAL_AMT` float DEFAULT NULL,
  `CSC_ADDVALCANCEL_QTY` float DEFAULT NULL,
  `CSC_ADDVALCANCEL_AMT` float DEFAULT NULL,
  `CSC_ADDPRODUCT_QTY` float DEFAULT NULL,
  `CSC_ADDPRODUCT_AMT` float DEFAULT NULL,
  `CSC_ADDPRODUCTCANCEL_QTY` float DEFAULT NULL,
  `CSC_ADDPRODUCTCANCEL_AMT` float DEFAULT NULL,
  `ADJ_QTY` float DEFAULT NULL,
  `ADJ_AMT` float DEFAULT NULL,
  `PAYBACK_QTY` float DEFAULT NULL,
  `PAYBACK_AMT` float DEFAULT NULL,
  `AFCGB_QTY` float DEFAULT NULL,
  `AFCGB_NOOFPASS` float DEFAULT NULL,
  `AFCGB_AMT` float DEFAULT NULL,
  `AFCGB_CANCEL_AMT` float DEFAULT NULL,
  `AFCGB_SECDEPOSIT_RFND` float DEFAULT NULL,
  `NCMC_ADJ_QTY` float DEFAULT NULL,
  `NCMC_ADJ_AMT` float DEFAULT NULL,
  `NCMC_TOPUP_QTY` float DEFAULT NULL,
  `NCMC_TOPUP_AMT` float DEFAULT NULL,
  `AFC_TOTAL` float DEFAULT NULL,
  `FRACVAL_ADJ` varchar(50) DEFAULT NULL,
  `TVMRCM_FAILTX_QTY` float DEFAULT NULL,
  `TVMRCM_FAILTX_AMT` float DEFAULT NULL,
  `MANUALGB_QTY` float DEFAULT NULL,
  `MANUALGB_NOOFPASS` float DEFAULT NULL,
  `MANUALGB_AMT` float DEFAULT NULL,
  `URC_DAMAGED_QTY` float DEFAULT NULL,
  `URC_DAMAGED_AMT` float DEFAULT NULL,
  `URC_NONDAMAGED_QTY` float DEFAULT NULL,
  `URC_NONDAMAGED_AMT` float DEFAULT NULL,
  `PENALTY_ADMIN_QTY` float DEFAULT NULL,
  `PENALTY_ADMIN_AMT` float DEFAULT NULL,
  `PENALTY_ONM_QTY` float DEFAULT NULL,
  `PENALTY_ONM_AMT` float DEFAULT NULL,
  `PENALTY_OTH_QTY` float DEFAULT NULL,
  `PENALTY_OTH_AMT` float DEFAULT NULL,
  `EIB_AMT` float DEFAULT NULL,
  `MISC_EARNIG_AMT` float DEFAULT NULL,
  `PT_QTY` float DEFAULT NULL,
  `PT_AMT` float DEFAULT NULL,
  `PT_MANUALRFND_QTY` float DEFAULT NULL,
  `PT_MANUALRFND_AMT` float DEFAULT NULL,
  `SJT_MANUALRFND_QTY` float DEFAULT NULL,
  `SJT_MANUALRFND_AMT` float DEFAULT NULL,
  `RJT_MANUALRFND_1TRIP_QTY` float DEFAULT NULL,
  `RJT_MANUALRFND_2TRIP_QTY` float DEFAULT NULL,
  `RJT_MANUALRFND_2TRIP_AMT` float DEFAULT NULL,
  `CSC_MANUALRFND_QTY` float DEFAULT NULL,
  `CSC_MANUALRFND_AMT` float DEFAULT NULL,
  `TOPUP_EMP_QTY` float DEFAULT NULL,
  `TOPUP_EMP_AMT` float DEFAULT NULL,
  `OS_BF_AFC` float DEFAULT NULL,
  `OS_BF_MISC` float DEFAULT NULL,
  `OS_CURR_AFC` float DEFAULT NULL,
  `OS_CURR_MISC` float DEFAULT NULL,
  `OS_PAID_AFC` float DEFAULT NULL,
  `OS_PAID_MISC` float DEFAULT NULL,
  `OS_WOFF_AFC` float DEFAULT NULL,
  `OS_WOFF_MISC` float DEFAULT NULL,
  `OS_WOFF_LRNO` float DEFAULT NULL,
  `OS_CF_AFC` float DEFAULT NULL,
  `OS_CF_MISC` float DEFAULT NULL,
  `MANUAL_TOTAL` float DEFAULT NULL,
  `OSOURCE_EARNING` float DEFAULT NULL,
  `LNF_AMT` float DEFAULT NULL,
  `DP_QR_QTY` float DEFAULT NULL,
  `DP_QR_AMT` float DEFAULT NULL,
  `DP_POS_QTY` float DEFAULT NULL,
  `DP_POS_AMT` float DEFAULT NULL,
  `DP_GMRCLSV_QTY` float DEFAULT NULL,
  `DP_GMRCLSV_AMT` float DEFAULT NULL,
  `DP_NCMCSV_QTY` float DEFAULT NULL,
  `DP_NCMCSV_AMT` float DEFAULT NULL,
  `DP_PAYTMQR_QTY` float DEFAULT NULL,
  `DP_PAYTMQR_AMT` float DEFAULT NULL,
  `DP_PAYTMPOS_QTY` float DEFAULT NULL,
  `DP_PAYMTPOS_AMT` float DEFAULT NULL,
  `CTB` float DEFAULT NULL,
  `COH` float DEFAULT NULL,
  `MISMATCH` float DEFAULT NULL,
  `CHKOH` float DEFAULT NULL,
  `COH_PREVDAY` float DEFAULT NULL,
  `COINSOH_COIN1` float DEFAULT NULL,
  `COINSOH_COIN2` float DEFAULT NULL,
  `COINSOH_COIN5` float DEFAULT NULL,
  `COINSOH_COIN10` float DEFAULT NULL,
  `SG_ENTRY` float DEFAULT NULL,
  `SG_EXIT` float DEFAULT NULL,
  `FIRSTREPORT_AFC_EARNING` float DEFAULT NULL,
  `FIRSTREPORT_AFC_MISMATCH` float DEFAULT NULL,
  `UPDATEDREPORT_AFC_EARNING` float DEFAULT NULL,
  `UPDATEDREPORT_AFC_MISMATCH` float DEFAULT NULL,
  `RCM_FAILTX_QTY` float DEFAULT NULL,
  `RCM_FAILTX_AMT` float DEFAULT NULL,
  `RCM_ADDVAL_QTY` float DEFAULT NULL,
  `RCM_ADDVAL_AMT` float DEFAULT NULL,
  `TVM_CST_QTY` float DEFAULT NULL,
  `TVM_CST_AMT` float DEFAULT NULL,
  `TVM_ADDVAL_QTY` float DEFAULT NULL,
  `TVM_ADDVAL_AMT` float DEFAULT NULL,
  `TVM_GMRCLSV_QTY` float DEFAULT NULL,
  `TVM_GMRCLSV_AMT` float DEFAULT NULL,
  `TVM_NCMCSV_QTY` float DEFAULT NULL,
  `TVM_NCMCSV_AMT` float DEFAULT NULL,
  `TVM_FAILTX_QTY` float DEFAULT NULL,
  `TVM_FAILTX_AMT` float DEFAULT NULL,
  `RIDERSHIP_SJT` float DEFAULT NULL,
  `RIDERSHIP_RJT` float DEFAULT NULL,
  `RIDERSHIP_PET` float DEFAULT NULL,
  `RIDERSHIP_PT` float DEFAULT NULL,
  `RIDERSHIP_GB` float DEFAULT NULL,
  `RIDERSHIP_EXIT` float DEFAULT NULL,
  `RIDERSHIP_NCMCEXIT` float DEFAULT NULL,
  `RIDERSHIP_TOT` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tab_user_details`
--

CREATE TABLE `tab_user_details` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `stationname` varchar(128) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `stations_allotted` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tab_user_details`
--

INSERT INTO `tab_user_details` (`id`, `username`, `password`, `stationname`, `account_type`, `stations_allotted`) VALUES
(1, 'revenuecell', 'revenuecell', 'rev', 'revenuecell', ''),
(2, 'vtlg', 'vtlg', 'vtlg', 'station', ''),
(3, 'ntcr', 'ntcr', 'ntcr', 'station', ''),
(4, 'vstl', 'vstl', 'vstl', 'station', ''),
(5, 'rbcy', 'rbcy', 'rbcy', 'station', ''),
(6, 'arvd', 'arvd', 'arvd', 'station', ''),
(7, 'arpk', 'arpk', 'arpk', 'station', ''),
(8, 'kkes', 'kkes', 'kkes', 'station', ''),
(9, 'kpms', 'kpms', 'kpms', 'station', ''),
(10, 'geka', 'geka', 'geka', 'station', ''),
(11, 'shhp', 'shhp', 'shhp', 'station', ''),
(12, 'spsd', 'spsd', 'spsd', 'station', ''),
(13, 'cmsr', 'cmsr', 'cmsr', 'station', ''),
(14, 'gjuv', 'gjuv', 'gjuv', 'station', ''),
(15, 'gkrd', 'gkrd', 'gkrd', 'station', ''),
(16, 'ddkn', 'ddkn', 'ddkn', 'station', ''),
(17, 'tltj', 'tltj', 'tltj', 'station', ''),
(18, 'tltg', 'tltg', 'tltg', 'station', ''),
(19, 'mtrs', 'mtrs', 'mtrs', 'station', ''),
(20, 'smms', 'smms', 'smms', 'station', ''),
(21, 'aec', 'aec', 'aec', 'station', ''),
(22, 'sbrs', 'sbrs', 'sbrs', 'station', ''),
(23, 'rnip', 'rnip', 'rnip', 'station', ''),
(24, 'vdms', 'vdms', 'vdms', 'station', ''),
(25, 'vrms', 'vrms', 'vrms', 'station', ''),
(26, 'upms', 'upms', 'upms', 'station', ''),
(27, 'ohci', 'ohci', 'ohci', 'station', ''),
(28, 'grms', 'grms', 'grms', 'station', ''),
(29, 'pldi', 'pldi', 'pldi', 'station', ''),
(30, 'srys', 'srys', 'srys', 'station', ''),
(31, 'rnms', 'rnms', 'rnms', 'station', ''),
(32, 'jvrj', 'jvrj', 'jvrj', 'station', ''),
(33, 'apmc', 'apmc', 'apmc', 'station', ''),
(44, 'si1', 'newpassword', 'new station', 'SI', 'vtlg,kkes'),
(45, 'admin', 'admin', 'admin', 'admin', ''),
(46, 'si2', 'rahil123', 'Rahil', 'SI', 'vtlg,cmsr,ohci'),
(49, 'aba', 'aba', 'abcd', '2', ''),
(50, 'aba', 'abaaba', 'abcd', '1', ''),
(55, 'si12', 'efwefweff', 'new si', 'SI', 'arvd,spsd'),
(57, 'test', '123456', 'testSI', 'SI', 'aec,ohci,apmc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tab_logs_fileupload`
--
ALTER TABLE `tab_logs_fileupload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tab_logs_lockunlock`
--
ALTER TABLE `tab_logs_lockunlock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tab_revdailyreport_temp`
--
ALTER TABLE `tab_revdailyreport_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tab_status_lockupload`
--
ALTER TABLE `tab_status_lockupload`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- Indexes for table `tab_stmaster_temp`
--
ALTER TABLE `tab_stmaster_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tab_user_details`
--
ALTER TABLE `tab_user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tab_logs_fileupload`
--
ALTER TABLE `tab_logs_fileupload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tab_logs_lockunlock`
--
ALTER TABLE `tab_logs_lockunlock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tab_revdailyreport_temp`
--
ALTER TABLE `tab_revdailyreport_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tab_status_lockupload`
--
ALTER TABLE `tab_status_lockupload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=449;

--
-- AUTO_INCREMENT for table `tab_stmaster_temp`
--
ALTER TABLE `tab_stmaster_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tab_user_details`
--
ALTER TABLE `tab_user_details`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
