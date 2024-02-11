-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 11, 2024 at 02:48 PM
-- Server version: 10.6.15-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u620982390_dbresihive`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_room`
--

CREATE TABLE `add_room` (
  `rm_id` int(10) NOT NULL,
  `rm_type` varchar(255) DEFAULT NULL,
  `rm_flr` varchar(255) DEFAULT NULL,
  `rm_uni_no` varchar(255) DEFAULT NULL,
  `rm_amens` varchar(255) DEFAULT NULL,
  `rm_img` varchar(255) DEFAULT NULL,
  `rm_price` decimal(65,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `add_tenant`
--

CREATE TABLE `add_tenant` (
  `rent_id` int(10) NOT NULL,
  `tf_name` varchar(255) DEFAULT NULL,
  `tm_name` varchar(255) DEFAULT NULL,
  `ts_name` varchar(255) DEFAULT NULL,
  `td_start` varchar(255) DEFAULT NULL,
  `td_end` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE `apartments` (
  `house_id` int(11) NOT NULL,
  `house_name` varchar(255) NOT NULL,
  `rent_amount` decimal(10,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `house_image` varchar(255) NOT NULL,
  `landowner_userid` int(11) NOT NULL,
  `description` text NOT NULL,
  `house_type` varchar(50) NOT NULL,
  `number_of_beds` int(11) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `space_for` varchar(50) NOT NULL,
  `cr` int(11) NOT NULL,
  `payment_terms` varchar(255) NOT NULL,
  `availability` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`house_id`, `house_name`, `rent_amount`, `location`, `house_image`, `landowner_userid`, `description`, `house_type`, `number_of_beds`, `amenities`, `space_for`, `cr`, `payment_terms`, `availability`) VALUES
(5, 'CK House', 1500.00, 'Remedios Subdivision, Bubukal, Laguna', '../data_image/rental_houses/1702843492_4v7zz80m.png', 25, 'CK House Apartments has 6 rooms for solo, 4 rooms for dual type, and 2 rooms that can cater 4 individuals.', 'Apartment', 6, 'Parking', 'Mixed', 1, 'Advance Payment, Security Payment Deposit', ''),
(6, 'Apartment near LSPU', 1500.00, 'Sitio Sampaguita, Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1702847409_amadmzzd.png', 26, 'Located near LSPU Santa Cruz - main gate.', 'Apartment', 2, 'Parking, Canteen', 'Mixed', 1, 'Advance Payment, Security Payment Deposit', '');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `chat` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Unread',
  `rent_id` int(11) NOT NULL,
  `land_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `item_id`, `chat`, `status`, `rent_id`, `land_id`) VALUES
(1, NULL, 'hey', 'Unread', 37, 30),
(2, NULL, 'message', 'Unread', 37, 30),
(3, NULL, 'This is a test message', 'Unread', 37, 30),
(4, NULL, 'message', 'Unread', 37, 30),
(5, NULL, '', 'Unread', 37, 30),
(6, NULL, 'pogi', 'Unread', 37, 30),
(7, NULL, 'hello', 'Unread', 37, 30),
(8, NULL, 'psst', 'Unread', 37, 30);

-- --------------------------------------------------------

--
-- Table structure for table `complains`
--

CREATE TABLE `complains` (
  `com_id` int(10) NOT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `c_title` varchar(255) DEFAULT NULL,
  `c_descrip` varchar(255) DEFAULT NULL,
  `c_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dorms`
--

CREATE TABLE `dorms` (
  `house_id` int(11) NOT NULL,
  `house_name` varchar(255) NOT NULL,
  `rent_amount` decimal(10,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `house_image` varchar(255) NOT NULL,
  `landowner_userid` int(11) NOT NULL,
  `description` text NOT NULL,
  `house_type` varchar(50) NOT NULL,
  `number_of_beds` int(11) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `space_for` varchar(50) NOT NULL,
  `cr` int(11) NOT NULL,
  `payment_terms` varchar(255) NOT NULL,
  `availability` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dorms`
--

INSERT INTO `dorms` (`house_id`, `house_name`, `rent_amount`, `location`, `house_image`, `landowner_userid`, `description`, `house_type`, `number_of_beds`, `amenities`, `space_for`, `cr`, `payment_terms`, `availability`) VALUES
(8, 'CK House', 1300.00, 'Bougainvilla St., Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1702842897_e1ozzyga.png', 25, 'CK Dormitory caters has 4 rooms, 2 Comfort rooms, and a lobby. ', 'Dorm', 4, 'WiFi', 'Mixed', 2, 'Advance Payment, Security Payment Deposit', ''),
(9, 'Dorm near LSPU', 1500.00, 'Sitio Sampaguita, Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1702847319_amadmzzd.png', 26, 'Located near LSPU Gate 1. ', 'Dorm', 3, 'Parking, Canteen', 'Mixed', 1, 'Advance Payment, Security Payment Deposit', ''),
(10, 'Noble Dormitory', 1000.00, 'Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1702856286_394659220_3510647509252060_4597155163122241451_n.jpg', 25, 'e', 'Dorm', 1, 'Parking', 'Male', 1, 'Advance Payment', ''),
(11, '69', 16969.00, 'Brgy. Bubukal, STC, Laguna', '../data_image/rental_houses/1703062756_RESIHIVE SYMBOL2.png', 0, 'TUloy ka', 'Dorm', 3, 'Parking, WiFi, Canteen', 'Male', 1, 'Advance Payment, Security Payment Deposit', ''),
(12, 'Noble Dormitory', 1500.00, 'Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1703072261_casetools_pro_full-removebg-preview.png', 0, 'try', 'Dorm', 10, 'Parking, WiFi, Canteen', 'Mixed', 5, 'Advance Payment', ''),
(13, 'Noble Dormitory', 1500.00, 'Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1703072956_casetools_pro_full-removebg-preview.png', 30, 'try', 'Dorm', 10, 'Parking, WiFi, Canteen', 'Mixed', 5, 'Advance Payment', ''),
(14, '69', 6969.00, 'Brgy. Bubukal, STC, Laguna', '../data_image/rental_houses/1703073509_677024.jpg', 29, 'Sunflower', 'Dorm', 5, 'WiFi', 'Female', 1, 'Advance Payment, Security Payment Deposit', ''),
(15, 'Noble Dormitory', 1500.00, 'Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1703077615_casetools_pro_full-removebg-preview.png', 30, 'try', 'Dorm', 13, 'Parking, WiFi, Canteen', 'Mixed', 5, 'Advance Payment', '3');

-- --------------------------------------------------------

--
-- Table structure for table `house_rentals`
--

CREATE TABLE `house_rentals` (
  `house_id` int(11) NOT NULL,
  `house_name` varchar(255) NOT NULL,
  `rent_amount` decimal(10,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `house_image` varchar(255) NOT NULL,
  `landowner_userid` int(11) NOT NULL,
  `description` text NOT NULL,
  `house_type` varchar(50) NOT NULL,
  `number_of_beds` int(11) NOT NULL,
  `amenities` varchar(255) NOT NULL,
  `space_for` varchar(50) NOT NULL,
  `cr` int(11) NOT NULL,
  `payment_terms` varchar(255) NOT NULL,
  `availability` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `house_rentals`
--

INSERT INTO `house_rentals` (`house_id`, `house_name`, `rent_amount`, `location`, `house_image`, `landowner_userid`, `description`, `house_type`, `number_of_beds`, `amenities`, `space_for`, `cr`, `payment_terms`, `availability`) VALUES
(17, 'CK House', 1300.00, 'Bougainvilla St., Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1702842897_e1ozzyga.png', 25, 'CK Dormitory has 4 rooms, 2 Comfort rooms, and a lobby. ', 'Dorm', 4, 'WiFi', 'Mixed', 2, 'Advance Payment, Security Payment Deposit', '4'),
(18, 'CK House', 1500.00, 'Remedios Subdivision, Bubukal, Laguna', '../data_image/rental_houses/1702843492_4v7zz80m.png', 25, 'CK House Apartments has 6 rooms for solo, 4 rooms for dual type, and 2 rooms that can cater 4 individuals.', 'Apartment', 6, 'Parking', 'Mixed', 1, 'Advance Payment, Security Payment Deposit', '6'),
(19, 'Dorm near LSPU', 1500.00, 'Sitio Sampaguita, Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1702847319_amadmzzd.png', 26, 'Located near LSPU Gate 1. ', 'Dorm', 3, 'Parking, Canteen', 'Mixed', 1, 'Advance Payment, Security Payment Deposit', '3'),
(20, 'Apartment near LSPU', 1500.00, 'Sitio Sampaguita, Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1702847409_amadmzzd.png', 26, 'Located near LSPU Santa Cruz - main gate.', 'Apartment', 2, 'Parking, Canteen', 'Mixed', 1, 'Advance Payment, Security Payment Deposit', '2'),
(25, '69', 6969.00, 'Brgy. Bubukal, STC, Laguna', '../data_image/rental_houses/1703073509_677024.jpg', 29, 'Sunflower', 'Dorm', 5, 'WiFi', 'Female', 1, 'Advance Payment, Security Payment Deposit', '5'),
(27, 'Noble Dormitory', 1500.00, 'Bubukal, Santa Cruz, Laguna', '../data_image/rental_houses/1703077615_casetools_pro_full-removebg-preview.png', 30, 'try', 'Dorm', 13, 'Parking, WiFi, Canteen', 'Mixed', 5, 'Advance Payment', '3');

-- --------------------------------------------------------

--
-- Table structure for table `parent_details`
--

CREATE TABLE `parent_details` (
  `userid` int(10) NOT NULL,
  `father_name` varchar(50) DEFAULT NULL,
  `father_contact` varchar(20) DEFAULT NULL,
  `father_occupation` varchar(50) DEFAULT NULL,
  `mother_name` varchar(50) DEFAULT NULL,
  `mother_contact` varchar(20) DEFAULT NULL,
  `mother_occupation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_details`
--

INSERT INTO `parent_details` (`userid`, `father_name`, `father_contact`, `father_occupation`, `mother_name`, `mother_contact`, `mother_occupation`) VALUES
(23, 'Edwin Jivio', '09123456789', 'Tricycle Driver', 'Ma. Teresa Jivio', '09123456678', 'Housewife'),
(27, 'Donavan Rodolfo', '09634861635', 'Dishwasher', 'Ma. Victoria Victoria Rodolfo', '09317822238', 'Housewife'),
(33, 'Edwin', '09123456789', 'Tricycle Driver', 'Ma. Teresa', '09123456678', 'Fish Vendor'),
(35, 'Edwin', '09123456789', 'Tricycle Driver', 'Ma. Teresa', '09123456678', 'Fish Vendor'),
(36, 'Donavan', '05984523145', 'Worker', 'Victoria', '09548446325', 'Houdewif'),
(37, 'Edwin', '09123456789', 'Tricycle Driver', 'Ma. Teresa', '09123456678', 'Fish Vendor');

-- --------------------------------------------------------

--
-- Table structure for table `prop_category`
--

CREATE TABLE `prop_category` (
  `c_id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prop_category`
--

INSERT INTO `prop_category` (`c_id`, `name`) VALUES
(1, 'Apartment'),
(2, 'Dormitory');

-- --------------------------------------------------------

--
-- Table structure for table `remove_rent`
--

CREATE TABLE `remove_rent` (
  `rentid` int(10) NOT NULL,
  `rf_name` varchar(255) DEFAULT NULL,
  `rm_name` varchar(255) DEFAULT NULL,
  `rs_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_options`
--

CREATE TABLE `rental_options` (
  `id` int(11) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `owner_user_id` int(11) DEFAULT NULL,
  `renter_user_id` int(11) DEFAULT NULL,
  `renter_first_name` varchar(255) DEFAULT NULL,
  `renter_last_name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rental_options`
--

INSERT INTO `rental_options` (`id`, `house_id`, `owner_user_id`, `renter_user_id`, `renter_first_name`, `renter_last_name`, `status`, `date`) VALUES
(54, 17, 25, 23, 'Jordan', 'Jivio', 'Pending', '2023-12-17 21:11:40'),
(58, 17, 25, 23, 'Jordan', 'Jivio', 'Pending', '2023-12-18 06:31:17'),
(59, 19, 26, 32, 'Noel', 'Montecillo', 'Approved', '2023-12-18 07:11:57'),
(60, 19, 26, 32, 'Noel', 'Montecillo', 'Approved', '2023-12-18 07:11:57'),
(61, 18, 25, 32, 'Noel', 'Montecillo', 'Approved', '2023-12-18 07:11:57'),
(62, 20, 26, 32, 'Noel', 'Montecillo', 'Approved', '2023-12-18 07:11:57'),
(117, 17, 25, 33, 'Jordan', 'NULL', 'Pending', '2023-12-21 01:01:19'),
(119, 18, 25, 35, 'Jordan', 'Jordan', 'Approved', '2023-12-21 06:23:19'),
(120, 17, 25, 35, 'Jordan', 'Jordan', 'Pending', '2023-12-21 06:21:57'),
(124, 20, 26, 36, 'kath', 'kath', 'Inquired', '2023-12-21 06:14:51'),
(127, 27, 30, 33, 'Jordan', 'NULL', 'Inquired', '2023-12-21 06:16:40'),
(129, 27, 30, 27, 'Try bago name to', 'Rodolfo', 'Pending', '2023-12-21 06:23:09'),
(131, 27, 30, 37, 'Jordan', 'Jordan', 'Approved', '2023-12-21 06:32:11'),
(132, 27, 30, 37, 'Jordan', 'Jordan', 'Inquired', '2023-12-21 07:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `rent_price`
--

CREATE TABLE `rent_price` (
  `prc_id` int(10) NOT NULL,
  `mon_prc` decimal(65,0) DEFAULT NULL,
  `rent_remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rent_rm`
--

CREATE TABLE `rent_rm` (
  `rentid` int(10) NOT NULL,
  `own_name` varchar(255) DEFAULT NULL,
  `build_type` varchar(255) DEFAULT NULL,
  `unit_floor` varchar(255) DEFAULT NULL,
  `unit_room` varchar(255) DEFAULT NULL,
  `rent_prc` decimal(65,0) DEFAULT NULL,
  `rent_strt` varchar(255) DEFAULT NULL,
  `rent_end` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `rep_id` int(10) NOT NULL,
  `rep_title` varchar(255) DEFAULT NULL,
  `rep_descrip` varchar(255) DEFAULT NULL,
  `rep_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `rev_id` int(10) NOT NULL,
  `rt_name` varchar(255) DEFAULT NULL,
  `rlo_name` varchar(255) DEFAULT NULL,
  `r_descrip` varchar(255) DEFAULT NULL,
  `r_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rm_category`
--

CREATE TABLE `rm_category` (
  `rm_id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rm_category`
--

INSERT INTO `rm_category` (`rm_id`, `name`) VALUES
(1, 'Shared Room'),
(2, 'Solo Room');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_landowner_account`
--

CREATE TABLE `tbl_landowner_account` (
  `userid` int(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `num` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `citizenship` varchar(20) DEFAULT NULL,
  `civil_status` varchar(20) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `social_media_link` varchar(200) DEFAULT NULL,
  `otp` int(6) DEFAULT NULL,
  `is_expired` int(11) DEFAULT 0,
  `otp_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_landowner_account`
--

INSERT INTO `tbl_landowner_account` (`userid`, `email`, `password`, `f_name`, `s_name`, `num`, `birthdate`, `citizenship`, `civil_status`, `gender`, `status`, `social_media_link`, `otp`, `is_expired`, `otp_timestamp`, `date_created`, `date_updated`) VALUES
(21, 'jordan.napiza31@gmail.com', '$2y$10$2ZpXRjLl//CatYvyVIaRLunJ4xoqFy.Ol6puaxGAdEFT2woCYu49e', 'Jordan', 'Jivio', '09197355256', NULL, NULL, NULL, NULL, 'verified', NULL, 833299, 1, '2023-12-15 22:50:10', '2023-12-15 22:50:10', '2023-12-15 22:50:38'),
(25, 'angelitapascion@gmail.com', '$2y$10$zRP0imvh85Te4QyD3UscT.7/Eu1oWAgxT2CLN/OAmVZSLam/EzA8m', 'Angelita', 'Pascion', '09123456789', NULL, NULL, NULL, NULL, 'verified', NULL, 927351, 1, '2023-12-17 19:36:12', '2023-12-17 19:34:37', '2023-12-17 19:37:34'),
(26, 'loreta_ebron@gmail.com', '$2y$10$28HxulayLWqPMVsxtAoCrOVoj4qjqkf5oRGzM66N7XaAHsSNrFLnC', 'Loreta', 'Ebron', '09123456789', NULL, NULL, NULL, NULL, 'verified', NULL, 615740, 1, '2023-12-17 20:22:29', '2023-12-17 20:22:29', '2023-12-17 20:23:26'),
(27, 'jordan.napiza23@gmail.com', '$2y$10$6EkisiYORi0G/IHO.LieEuwYWR41ihn1Ny674IjSSBJ2dfjMfsiRW', 'Jordan', 'Jordan', '09197355256', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2023-12-19 20:44:13', '2023-12-19 20:44:13', '2023-12-19 20:44:13'),
(28, 'jordan.napiza24@gmail.com', '$2y$10$2.4CyWv0arXTw2KjY6j/kuNNoKQf9u2fGMa.gNcG0PDffA6JKhJje', 'Jordan', 'Jordan', '09197355256', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2023-12-19 20:55:56', '2023-12-19 20:55:56', '2023-12-19 20:55:56'),
(29, 'daverodolfo10@gmail.com', '$2y$10$cqEgxltv7hJHcS09HiXiSuYqW573ymGL79AzQWN5vyIh5cXcZ6r9K', 'jhon', 'jhon', '09634861635', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2023-12-20 08:57:46', '2023-12-20 08:57:46', '2023-12-20 08:57:46'),
(30, 'montecillonoel14@gmail.com', '$2y$10$rskUWUYGDC0sxQ997NRWreQCR7HmnwLj.T9hjVsZeQXNCByxj8InC', 'Noel', 'Noel', '09286319693', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2023-12-20 10:24:00', '2023-12-20 10:24:00', '2023-12-20 10:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_renters_account`
--

CREATE TABLE `tbl_renters_account` (
  `userid` int(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `m_name` varchar(255) DEFAULT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `age` varchar(11) DEFAULT NULL,
  `num` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `citizenship` varchar(20) DEFAULT NULL,
  `civil_status` varchar(20) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `education_status` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `social_media_link` varchar(200) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `otp` int(6) DEFAULT NULL,
  `is_expired` int(11) DEFAULT 0,
  `otp_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `LO_Registered` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_renters_account`
--

INSERT INTO `tbl_renters_account` (`userid`, `email`, `password`, `f_name`, `m_name`, `s_name`, `age`, `num`, `birthdate`, `birthplace`, `citizenship`, `civil_status`, `gender`, `education_status`, `status`, `social_media_link`, `profile_img`, `otp`, `is_expired`, `otp_timestamp`, `LO_Registered`, `date_created`, `date_updated`) VALUES
(23, 'jordan.napiza32@gmail.com', '$2y$10$.52293614fCxbWAtgfmH3en0G5alNYA.0lVXMJvdM8d4hSeaXg.cm', 'Jordan', 'Napiza', 'Jivio', '22', '09197355256', '2001-06-13', 'Patimbao', 'Filipino', 'Single', 'Female', 'Student', 'verified', 'www.facebook.com/jordan.jivio21', '657f6568f0e0e_67v069l3.png', 159600, 1, '2023-12-15 22:51:47', NULL, '2023-12-15 22:51:47', '2023-12-17 21:20:30'),
(27, 'daverodolfo6@gmail.com', '$2y$10$7qXzWrNsv3GaPTmxCSqK7OA0ZgDjoUOxg2LxdXOTPv1doNgMa9i/a', 'Try bago name to', 'M.', 'Rodolfo', '22', '09634861635', '2001-12-06', 'Alabang', 'Filipino', 'Single', 'Female', 'Student', 'verified', 'https://www.facebook.com/dave.rodolfo', '6582e90dccfbd_Dave.jpg', 112526, 1, '2023-12-17 22:03:30', NULL, '2023-12-17 22:03:30', '2023-12-20 13:15:57'),
(28, 'jordan.napiza21@gmail.com', '$2y$10$SCerGCvcUaci6/AjFpO/8u9KKip1l08s8H2BAggMk2YprZziT1J5a', 'Jordan', NULL, 'Jivio', NULL, '09197355256', NULL, NULL, NULL, NULL, NULL, NULL, 'verified', NULL, '657f716662054_67v069l3.png', 643223, 1, '2023-12-17 22:05:18', NULL, '2023-12-17 22:05:18', '2023-12-19 20:15:40'),
(32, 'montecillonoel14@gmail.com', '$2y$10$hiWEYYE7Nu278Y/UjnQJyebfG3ALXAAZBLIaBeitmoOCA5K8Mc8KO', 'Noel', NULL, 'Montecillo', NULL, '09286319693', NULL, NULL, NULL, NULL, NULL, NULL, 'verified', NULL, NULL, 792554, 1, '2023-12-18 06:51:54', NULL, '2023-12-18 06:51:54', '2023-12-18 06:55:20'),
(33, 'jordan.napiza22@gmail.com', '$2y$10$YPJo0iBxR.rCF4V32GarAeXa52TE3lSvyXcfCOoJdsQpmQXzIk4Ue', 'Jordan', '', 'NULL', '22', '09197355256', '2001-10-21', 'Santa Cruz, Laguna', 'Filipino', 'Single', 'Female', 'Student', NULL, 'www.facebook.com/jordan.jivio21', '6582f2ce7cd9a_67v069l3.png', NULL, 0, '2023-12-19 20:41:14', NULL, '2023-12-19 20:41:14', '2023-12-21 00:57:16'),
(35, 'edwin.jivio10@gmail.com', '$2y$10$cusS2dMPRxjBWU8GFJOtPuwuGzNOq5iHPsV5T6COBDV8O2at/8HfW', 'Jordan', 'Napiza', 'Jordan', '0', '09197355256', '2023-12-21', 'Santa Cruz, Laguna', 'Filipino', 'Single', 'Female', 'Student', NULL, 'www.facebook.com/jordan.jivio21', '65839231b704d_67v069l3.png', NULL, 0, '2023-12-21 01:02:10', NULL, '2023-12-21 01:02:10', '2023-12-21 01:17:37'),
(36, 'kathleenannebal@gmail.com', '$2y$10$WeQJslLl/Wo0YAyrTzGwmeUJlTnhLLVNnM2X0IKa5BPJspdBYRjNm', 'kath', 'b', 'kath', '0', '09451356879', '0000-00-00', '', '', 'Single', 'Female', 'Student', NULL, '', '6583e59633e24_Montecillo_Noel.jpg', NULL, 0, '2023-12-21 06:12:39', NULL, '2023-12-21 06:12:39', '2023-12-21 07:13:26'),
(37, 'jordan.napiza26@gmail.com', '$2y$10$Ai2JSKYKCZvD2lWptHUO3OSPYLuTiTT4hypSG9bgN49eisFl6.ehi', 'Jordan', 'Napiza', 'Jordan', '15', '09197355256', '2008-02-21', 'Santa Cruz, Laguna', 'Filipino', 'Single', 'Male', 'Student', NULL, 'www.facebook.com/jordan.jivio21', '6583dbc1b06d1_67v069l3.png', NULL, 0, '2023-12-21 06:29:58', NULL, '2023-12-21 06:29:58', '2023-12-21 06:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `tenants_address`
--

CREATE TABLE `tenants_address` (
  `userid` int(11) NOT NULL,
  `st_house_num` varchar(20) DEFAULT NULL,
  `barangay` varchar(30) DEFAULT NULL,
  `municipality` varchar(30) DEFAULT NULL,
  `province` varchar(30) DEFAULT NULL,
  `postal_code` varchar(30) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenants_address`
--

INSERT INTO `tenants_address` (`userid`, `st_house_num`, `barangay`, `municipality`, `province`, `postal_code`, `date_created`) VALUES
(23, '093', 'Santo Angel Sur', 'Santa Cruz', 'Laguna', '4009', '2023-12-17 13:05:34'),
(27, '268', 'Linga', 'PIla', 'Laguna', '4010', '2023-12-19 15:02:40'),
(33, '093', 'Santo Angel Sur', 'Santa Cruz', 'Laguna', '4009', '2023-12-20 13:52:44'),
(35, '093', 'Santo Angel Sur', 'Santa Cruz', 'Laguna', '4009', '2023-12-21 01:17:06'),
(36, 'San Pels', 'Linga', 'Pila', 'Laguna', '4010', '2023-12-21 06:19:59'),
(37, '093', 'Santo Angel Sur', 'Santa Cruz', 'Laguna', '4009', '2023-12-21 06:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `tenants_file`
--

CREATE TABLE `tenants_file` (
  `id` int(10) NOT NULL,
  `userid` varchar(11) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `date_uploaded` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_status` varchar(20) DEFAULT NULL,
  `remarks` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenants_lst`
--

CREATE TABLE `tenants_lst` (
  `lst_id` int(10) NOT NULL,
  `userid` varchar(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lo_register` varchar(20) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `num` varchar(20) NOT NULL,
  `otp` int(6) NOT NULL,
  `is_expired` int(11) DEFAULT 0,
  `otp_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `email`, `password`, `f_name`, `s_name`, `num`, `otp`, `is_expired`, `otp_timestamp`) VALUES
(2, 2, 'jordan.napiza22@gmail.com', '$2y$10$4/OJDKTpsykQeSIj3c0ORe1DigY43ux1GYoIxKcEwCPHzMZiiiBju', 'Jordan', 'Jivio', '09197355256', 336758, 1, '2023-12-19 20:41:14'),
(3, 1, 'jordan.napiza23@gmail.com', '$2y$10$8GeuUU6vKhPa/kNFb4fF5.POjpw2Zm46ySPa31.Er4P4xUPXVFM32', 'Jordan', 'Jivio', '09197355256', 129205, 1, '2023-12-19 20:44:13'),
(4, 1, 'jordan.napiza24@gmail.com', '$2y$10$Llf8pOyMWHz4bQq7y6iToOBfa/V4n79jyzukgCyRCXDkTAqnVjfPW', 'Jordan', 'Jivio', '09197355256', 651202, 1, '2023-12-19 20:55:56'),
(5, 2, 'daverodolfo6@gmail.com', '$2y$10$yBE462/iUeJNoZ7IOpPW6utdAmppktcMeYtbSqUf6Z0Tyb9aof2Bq', 'Dave Carl Jay-Are', 'Rodolfo', '09634861635', 807679, 1, '2023-12-20 07:01:59'),
(7, 1, 'daverodolfo10@gmail.com', '$2y$10$jWIyAQMa2zRZ/regfilkUOOdiOQmtEhGA.S3D0Yl9fO.6g6FKzqSu', 'jhon', 'Laxy', '09634861635', 510541, 1, '2023-12-20 08:57:46'),
(8, 1, 'montecillonoel14@gmail.com', '$2y$10$X85aT/ls.24vJuLeBkGF.Oc76khcElgrnDsHcYMOssWhc9kapAoYa', 'Noel', 'Montecillo', '09286319693', 331035, 1, '2023-12-20 10:24:00'),
(9, 2, 'edwin.jivio10@gmail.com', '$2y$10$kr7nrkaB42AWmpa9Gp53lOy2Lm3LnK4H/4m2ySD5b2bDeUbi4ytAG', 'Jordan', 'Jivio', '09197355256', 228526, 1, '2023-12-21 01:02:10'),
(10, 1, 'loreta_ebron@gmail.com', '', 'Loreta', 'Ebron', '09286319693', 357202, 0, '2023-12-21 06:02:45'),
(11, 2, 'kathleenannebal@gmail.com', '$2y$10$bVPfZDK9Ai2tXPG.m57e9ezUv5UnwJiD98cSimY8gQe0ndvgotlB2', 'kath', 'balboa', '09451356879', 548661, 1, '2023-12-21 06:12:39'),
(12, 2, 'jordan.napiza26@gmail.com', '$2y$10$RkPlaACS2pE8TS4OkroFzOFe/OiJxodJ0PKdmUp2a9UX/Qf7fHJcS', 'Jordan', 'Jivio', '09197355256', 971191, 1, '2023-12-21 06:29:58');

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE `visit` (
  `id` int(11) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `owner_user_id` int(11) DEFAULT NULL,
  `renter_user_id` int(11) DEFAULT NULL,
  `renter_first_name` varchar(255) DEFAULT NULL,
  `renter_last_name` varchar(255) DEFAULT NULL,
  `num` varchar(11) DEFAULT NULL,
  `visit_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visit`
--

INSERT INTO `visit` (`id`, `house_id`, `owner_user_id`, `renter_user_id`, `renter_first_name`, `renter_last_name`, `num`, `visit_date`) VALUES
(1, 17, 25, 23, 'noel', 'montecillo', '09286319693', '2023-12-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_room`
--
ALTER TABLE `add_room`
  ADD PRIMARY KEY (`rm_id`);

--
-- Indexes for table `add_tenant`
--
ALTER TABLE `add_tenant`
  ADD PRIMARY KEY (`rent_id`);

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`house_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `complains`
--
ALTER TABLE `complains`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `dorms`
--
ALTER TABLE `dorms`
  ADD PRIMARY KEY (`house_id`);

--
-- Indexes for table `house_rentals`
--
ALTER TABLE `house_rentals`
  ADD PRIMARY KEY (`house_id`);

--
-- Indexes for table `parent_details`
--
ALTER TABLE `parent_details`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `prop_category`
--
ALTER TABLE `prop_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `remove_rent`
--
ALTER TABLE `remove_rent`
  ADD PRIMARY KEY (`rentid`);

--
-- Indexes for table `rental_options`
--
ALTER TABLE `rental_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `house_id` (`house_id`);

--
-- Indexes for table `rent_price`
--
ALTER TABLE `rent_price`
  ADD PRIMARY KEY (`prc_id`);

--
-- Indexes for table `rent_rm`
--
ALTER TABLE `rent_rm`
  ADD PRIMARY KEY (`rentid`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`rep_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`rev_id`);

--
-- Indexes for table `rm_category`
--
ALTER TABLE `rm_category`
  ADD PRIMARY KEY (`rm_id`);

--
-- Indexes for table `tbl_landowner_account`
--
ALTER TABLE `tbl_landowner_account`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `tbl_renters_account`
--
ALTER TABLE `tbl_renters_account`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `tenants_address`
--
ALTER TABLE `tenants_address`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `tenants_file`
--
ALTER TABLE `tenants_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants_lst`
--
ALTER TABLE `tenants_lst`
  ADD PRIMARY KEY (`lst_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `house_id` (`house_id`),
  ADD KEY `owner_user_id` (`owner_user_id`),
  ADD KEY `renter_user_id` (`renter_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_room`
--
ALTER TABLE `add_room`
  MODIFY `rm_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `add_tenant`
--
ALTER TABLE `add_tenant`
  MODIFY `rent_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `complains`
--
ALTER TABLE `complains`
  MODIFY `com_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dorms`
--
ALTER TABLE `dorms`
  MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `house_rentals`
--
ALTER TABLE `house_rentals`
  MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `prop_category`
--
ALTER TABLE `prop_category`
  MODIFY `c_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `remove_rent`
--
ALTER TABLE `remove_rent`
  MODIFY `rentid` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_options`
--
ALTER TABLE `rental_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `rent_price`
--
ALTER TABLE `rent_price`
  MODIFY `prc_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rent_rm`
--
ALTER TABLE `rent_rm`
  MODIFY `rentid` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `rep_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `rev_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rm_category`
--
ALTER TABLE `rm_category`
  MODIFY `rm_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_landowner_account`
--
ALTER TABLE `tbl_landowner_account`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_renters_account`
--
ALTER TABLE `tbl_renters_account`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tenants_file`
--
ALTER TABLE `tenants_file`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tenants_lst`
--
ALTER TABLE `tenants_lst`
  MODIFY `lst_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `rental_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parent_details`
--
ALTER TABLE `parent_details`
  ADD CONSTRAINT `parent_details_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `tbl_renters_account` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rental_options`
--
ALTER TABLE `rental_options`
  ADD CONSTRAINT `rental_options_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `house_rentals` (`house_id`);

--
-- Constraints for table `tenants_address`
--
ALTER TABLE `tenants_address`
  ADD CONSTRAINT `tenants_address_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `tbl_renters_account` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `visit`
--
ALTER TABLE `visit`
  ADD CONSTRAINT `visit_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `house_rentals` (`house_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_ibfk_2` FOREIGN KEY (`renter_user_id`) REFERENCES `tbl_renters_account` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visit_ibfk_3` FOREIGN KEY (`owner_user_id`) REFERENCES `tbl_landowner_account` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
