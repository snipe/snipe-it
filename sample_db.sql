-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 21, 2018 at 08:33 AM
-- Server version: 10.0.34-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `snipe`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

CREATE TABLE `accessories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `requestable` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
  `normal_amt` int(5) DEFAULT '8',
  `manufacturer_id` int(11) DEFAULT NULL,
  `model_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`id`, `name`, `category_id`, `user_id`, `qty`, `requestable`, `created_at`, `updated_at`, `deleted_at`, `location_id`, `purchase_date`, `purchase_cost`, `order_number`, `company_id`, `min_amt`, `normal_amt`, `manufacturer_id`, `model_number`, `image`, `supplier_id`) VALUES
(1, 'USB Keyboard', 8, 1, 15, 0, '2018-05-15 04:40:21', '2018-05-16 06:05:41', NULL, 3, NULL, NULL, '', 0, 2, 5, 1, '20085439', NULL, 5),
(2, 'Bluetooth Keyboard', 8, 1, 10, 0, '2018-05-15 04:40:21', '2018-05-15 04:40:21', NULL, 1, NULL, NULL, NULL, NULL, 2, 8, 1, '17815811', NULL, 4),
(3, 'Magic Mouse', 9, 1, 13, 0, '2018-05-15 04:40:21', '2018-05-15 04:40:21', NULL, 5, NULL, NULL, NULL, NULL, 2, 8, 1, '29649227', NULL, 3),
(4, 'Sculpt Comfort Mouse', 9, 1, 13, 0, '2018-05-15 04:40:21', '2018-05-15 04:40:21', NULL, 1, NULL, NULL, NULL, NULL, 2, 8, 2, '13817252', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `accessories_users`
--

CREATE TABLE `accessories_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `accessory_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `action_logs`
--

CREATE TABLE `action_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` int(11) DEFAULT NULL,
  `target_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `filename` text COLLATE utf8mb4_unicode_ci,
  `item_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `expected_checkin` date DEFAULT NULL,
  `accepted_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `accept_signature` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log_meta` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `action_logs`
--

INSERT INTO `action_logs` (`id`, `user_id`, `action_type`, `target_id`, `target_type`, `location_id`, `note`, `filename`, `item_type`, `item_id`, `expected_checkin`, `accepted_id`, `created_at`, `updated_at`, `deleted_at`, `thread_id`, `company_id`, `accept_signature`, `log_meta`) VALUES
(1, 1, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 501, NULL, NULL, '2018-04-17 05:35:50', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(2, 1, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 29, NULL, NULL, '2017-11-09 10:07:37', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(3, 1, 'checkout', 23, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1366, NULL, NULL, '2017-06-12 23:02:59', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(4, 2, 'checkout', 31, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 46, NULL, NULL, '2017-05-24 16:04:14', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(5, 2, 'checkout', 4, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1218, NULL, NULL, '2017-11-25 12:04:30', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(6, 1, 'checkout', 7, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 762, NULL, NULL, '2017-12-10 06:19:43', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(7, 1, 'checkout', 44, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1339, NULL, NULL, '2018-02-22 22:09:28', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(8, 2, 'checkout', 4, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 364, NULL, NULL, '2018-05-02 19:27:32', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(9, 2, 'checkout', 1, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 881, NULL, NULL, '2017-06-07 22:13:46', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(10, 1, 'checkout', 41, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 90, NULL, NULL, '2017-05-16 13:14:10', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(11, 2, 'checkout', 47, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1306, NULL, NULL, '2018-04-12 07:01:59', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(12, 1, 'checkout', 58, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 946, NULL, NULL, '2017-11-15 05:35:34', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(13, 2, 'checkout', 2, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 703, NULL, NULL, '2017-12-08 23:04:57', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(14, 1, 'checkout', 19, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 863, NULL, NULL, '2017-09-26 14:32:40', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(15, 1, 'checkout', 58, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 567, NULL, NULL, '2017-08-19 07:30:15', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(16, 1, 'checkout', 5, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 510, NULL, NULL, '2017-10-27 14:58:11', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(17, 2, 'checkout', 17, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1119, NULL, NULL, '2018-01-27 03:37:57', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(18, 2, 'checkout', 53, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 684, NULL, NULL, '2017-12-23 23:35:45', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(19, 2, 'checkout', 30, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1353, NULL, NULL, '2018-01-23 22:02:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(20, 2, 'checkout', 25, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1214, NULL, NULL, '2017-08-26 07:03:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(21, 2, 'checkout', 10, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1255, NULL, NULL, '2017-11-02 21:40:50', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(22, 2, 'checkout', 8, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1335, NULL, NULL, '2018-04-01 18:01:43', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(23, 1, 'checkout', 47, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 583, NULL, NULL, '2018-01-23 02:04:12', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(24, 1, 'checkout', 35, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 609, NULL, NULL, '2018-04-01 17:15:18', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(25, 2, 'checkout', 49, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 160, NULL, NULL, '2017-12-12 12:07:56', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(26, 1, 'checkout', 45, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 489, NULL, NULL, '2018-05-13 09:22:36', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(27, 1, 'checkout', 4, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 894, NULL, NULL, '2017-12-10 15:44:44', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(28, 2, 'checkout', 25, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 367, NULL, NULL, '2017-12-04 03:47:54', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(29, 2, 'checkout', 57, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 275, NULL, NULL, '2017-11-25 16:01:08', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(30, 2, 'checkout', 42, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 722, NULL, NULL, '2017-11-01 14:09:49', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(31, 1, 'checkout', 25, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1246, NULL, NULL, '2017-06-10 22:12:56', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(32, 2, 'checkout', 19, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 982, NULL, NULL, '2018-03-15 06:32:19', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(33, 2, 'checkout', 58, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 111, NULL, NULL, '2018-03-20 01:16:55', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(34, 2, 'checkout', 41, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 981, NULL, NULL, '2017-12-26 00:48:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(35, 2, 'checkout', 1, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 424, NULL, NULL, '2017-10-29 17:02:13', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(36, 1, 'checkout', 4, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 346, NULL, NULL, '2017-09-10 06:25:38', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(37, 1, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 192, NULL, NULL, '2017-10-09 10:27:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(38, 2, 'checkout', 20, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 415, NULL, NULL, '2018-04-18 01:06:30', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(39, 1, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 205, NULL, NULL, '2017-08-17 18:34:46', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(40, 2, 'checkout', 55, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 681, NULL, NULL, '2017-12-06 06:31:12', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(41, 1, 'checkout', 51, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 43, NULL, NULL, '2017-10-31 03:27:20', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(42, 2, 'checkout', 18, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 509, NULL, NULL, '2017-12-26 21:53:50', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(43, 2, 'checkout', 38, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 57, NULL, NULL, '2018-04-16 22:13:14', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(44, 1, 'checkout', 49, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 729, NULL, NULL, '2017-09-17 21:07:34', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(45, 2, 'checkout', 49, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1292, NULL, NULL, '2018-04-15 14:47:56', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(46, 1, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 433, NULL, NULL, '2018-01-31 19:41:10', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(47, 1, 'checkout', 39, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 152, NULL, NULL, '2017-07-16 08:56:49', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(48, 1, 'checkout', 21, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 555, NULL, NULL, '2017-08-28 04:37:46', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(49, 2, 'checkout', 21, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 442, NULL, NULL, '2018-03-05 07:39:16', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(50, 1, 'checkout', 45, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1239, NULL, NULL, '2017-09-01 19:08:09', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(51, 1, 'checkout', 1, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 303, NULL, NULL, '2017-10-03 18:56:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(52, 2, 'checkout', 57, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 67, NULL, NULL, '2017-11-07 18:54:42', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(53, 2, 'checkout', 45, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 290, NULL, NULL, '2018-01-25 15:22:12', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(54, 2, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 443, NULL, NULL, '2017-12-13 13:54:55', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(55, 2, 'checkout', 22, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1234, NULL, NULL, '2017-12-23 04:24:59', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(56, 2, 'checkout', 24, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1313, NULL, NULL, '2017-12-05 20:54:53', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(57, 1, 'checkout', 42, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 426, NULL, NULL, '2017-10-06 23:06:59', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(58, 1, 'checkout', 47, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 812, NULL, NULL, '2018-03-05 22:24:29', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(59, 1, 'checkout', 54, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1326, NULL, NULL, '2018-01-18 16:01:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(60, 2, 'checkout', 48, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 833, NULL, NULL, '2017-05-30 01:37:09', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(61, 2, 'checkout', 16, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 271, NULL, NULL, '2017-12-18 16:43:06', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(62, 2, 'checkout', 53, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 208, NULL, NULL, '2018-01-25 03:24:44', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(63, 2, 'checkout', 22, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 893, NULL, NULL, '2017-07-25 07:03:53', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(64, 2, 'checkout', 32, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1169, NULL, NULL, '2018-03-29 17:57:33', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(65, 1, 'checkout', 26, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 546, NULL, NULL, '2018-02-16 08:41:03', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(66, 1, 'checkout', 13, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 713, NULL, NULL, '2017-12-25 16:55:09', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(67, 2, 'checkout', 53, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 629, NULL, NULL, '2017-06-11 07:32:23', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(68, 1, 'checkout', 48, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 879, NULL, NULL, '2017-05-23 17:02:36', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(69, 1, 'checkout', 23, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1275, NULL, NULL, '2018-05-14 01:38:11', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(70, 1, 'checkout', 8, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 939, NULL, NULL, '2017-10-25 07:11:35', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(71, 2, 'checkout', 46, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 89, NULL, NULL, '2018-04-20 21:58:37', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(72, 1, 'checkout', 54, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1368, NULL, NULL, '2017-08-21 07:08:16', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(73, 2, 'checkout', 27, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 385, NULL, NULL, '2018-04-02 22:22:48', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(74, 2, 'checkout', 20, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 754, NULL, NULL, '2018-04-10 06:33:39', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(75, 2, 'checkout', 43, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 898, NULL, NULL, '2017-11-12 09:05:15', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(76, 2, 'checkout', 38, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 311, NULL, NULL, '2017-11-24 14:34:18', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(77, 2, 'checkout', 10, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 394, NULL, NULL, '2017-06-02 06:46:08', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(78, 1, 'checkout', 25, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 159, NULL, NULL, '2017-11-21 18:44:43', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(79, 1, 'checkout', 31, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 5, NULL, NULL, '2017-07-16 19:48:43', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(80, 2, 'checkout', 8, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 732, NULL, NULL, '2017-11-24 12:20:42', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(81, 1, 'checkout', 1, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 413, NULL, NULL, '2017-09-23 13:44:09', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(82, 2, 'checkout', 48, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 940, NULL, NULL, '2017-05-20 09:07:14', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(83, 1, 'checkout', 25, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1181, NULL, NULL, '2018-02-27 16:46:08', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(84, 2, 'checkout', 23, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 234, NULL, NULL, '2017-09-28 23:08:52', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(85, 2, 'checkout', 55, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1349, NULL, NULL, '2018-03-14 22:50:17', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(86, 1, 'checkout', 11, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 388, NULL, NULL, '2018-02-07 08:29:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(87, 2, 'checkout', 15, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1134, NULL, NULL, '2017-06-01 12:21:14', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(88, 2, 'checkout', 13, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 667, NULL, NULL, '2018-03-22 05:54:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(89, 1, 'checkout', 1, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 535, NULL, NULL, '2017-07-14 15:22:05', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(90, 2, 'checkout', 5, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 934, NULL, NULL, '2018-01-23 20:46:13', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(91, 1, 'checkout', 18, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 151, NULL, NULL, '2017-05-17 17:41:43', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(92, 1, 'checkout', 28, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 589, NULL, NULL, '2017-10-21 02:38:48', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(93, 2, 'checkout', 24, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 529, NULL, NULL, '2018-02-15 00:56:42', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(94, 2, 'checkout', 2, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 94, NULL, NULL, '2017-08-16 06:44:33', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(95, 2, 'checkout', 37, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 91, NULL, NULL, '2018-04-08 21:11:48', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(96, 2, 'checkout', 36, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 992, NULL, NULL, '2018-05-01 10:23:40', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(97, 1, 'checkout', 53, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 641, NULL, NULL, '2017-05-29 23:21:43', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(98, 2, 'checkout', 31, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1362, NULL, NULL, '2017-10-09 18:43:09', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(99, 2, 'checkout', 21, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 429, NULL, NULL, '2017-06-23 23:20:48', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(100, 1, 'checkout', 27, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 523, NULL, NULL, '2017-09-21 06:54:51', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(101, 2, 'checkout', 8, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 605, NULL, NULL, '2017-07-17 10:14:39', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(102, 2, 'checkout', 23, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 928, NULL, NULL, '2018-02-21 15:51:41', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(103, 2, 'checkout', 27, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 853, NULL, NULL, '2018-04-26 03:15:10', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(104, 2, 'checkout', 30, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 339, NULL, NULL, '2017-05-20 07:56:00', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(105, 1, 'checkout', 19, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 242, NULL, NULL, '2018-03-08 14:08:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(106, 1, 'checkout', 3, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 37, NULL, NULL, '2018-05-10 21:45:20', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(107, 1, 'checkout', 58, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 829, NULL, NULL, '2018-05-06 01:45:49', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(108, 1, 'checkout', 52, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 345, NULL, NULL, '2017-12-02 18:29:31', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(109, 1, 'checkout', 31, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 655, NULL, NULL, '2017-10-05 17:23:10', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(110, 2, 'checkout', 33, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1207, NULL, NULL, '2017-07-01 04:17:41', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(111, 2, 'checkout', 39, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 999, NULL, NULL, '2018-03-25 20:05:41', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(112, 1, 'checkout', 47, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 882, NULL, NULL, '2018-03-24 07:04:07', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(113, 2, 'checkout', 26, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 419, NULL, NULL, '2017-06-29 04:43:42', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(114, 1, 'checkout', 15, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 749, NULL, NULL, '2017-09-15 10:45:16', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(115, 1, 'checkout', 13, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 395, NULL, NULL, '2017-12-31 12:06:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(116, 1, 'checkout', 6, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1303, NULL, NULL, '2018-01-11 13:28:45', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(117, 1, 'checkout', 7, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1310, NULL, NULL, '2017-09-10 13:32:42', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(118, 2, 'checkout', 4, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 738, NULL, NULL, '2017-12-10 19:23:00', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(119, 1, 'checkout', 30, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 756, NULL, NULL, '2018-01-08 21:15:14', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(120, 2, 'checkout', 15, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 793, NULL, NULL, '2018-01-20 23:19:30', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(121, 2, 'checkout', 22, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 140, NULL, NULL, '2017-12-10 03:22:34', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(122, 2, 'checkout', 52, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 598, NULL, NULL, '2017-12-17 04:28:57', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(123, 2, 'checkout', 39, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 384, NULL, NULL, '2017-08-10 09:14:08', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(124, 1, 'checkout', 35, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 856, NULL, NULL, '2017-08-08 20:12:45', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(125, 1, 'checkout', 30, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 188, NULL, NULL, '2017-06-11 00:18:20', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(126, 1, 'checkout', 6, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 383, NULL, NULL, '2018-01-31 19:54:18', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(127, 2, 'checkout', 48, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 538, NULL, NULL, '2018-04-16 02:07:32', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(128, 2, 'checkout', 41, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1147, NULL, NULL, '2017-11-08 22:08:34', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(129, 2, 'checkout', 32, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 724, NULL, NULL, '2017-09-21 09:50:44', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(130, 2, 'checkout', 58, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 636, NULL, NULL, '2018-05-07 23:20:05', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(131, 2, 'checkout', 6, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 59, NULL, NULL, '2017-07-06 10:46:01', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(132, 2, 'checkout', 35, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 302, NULL, NULL, '2017-08-17 14:26:30', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(133, 2, 'checkout', 29, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 464, NULL, NULL, '2017-11-06 03:31:08', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(134, 2, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 693, NULL, NULL, '2017-10-09 19:24:04', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(135, 1, 'checkout', 58, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 17, NULL, NULL, '2018-04-06 22:45:17', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(136, 2, 'checkout', 2, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1183, NULL, NULL, '2017-10-05 15:49:10', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(137, 2, 'checkout', 56, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1227, NULL, NULL, '2017-05-19 04:32:59', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(138, 1, 'checkout', 57, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 461, NULL, NULL, '2018-02-15 20:10:47', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(139, 1, 'checkout', 36, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 333, NULL, NULL, '2017-07-13 17:38:55', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(140, 2, 'checkout', 37, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 726, NULL, NULL, '2018-01-27 16:45:05', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(141, 1, 'checkout', 58, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 891, NULL, NULL, '2017-09-20 20:26:01', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(142, 2, 'checkout', 57, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 559, NULL, NULL, '2017-07-30 00:07:00', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(143, 1, 'checkout', 20, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1168, NULL, NULL, '2017-06-03 20:04:45', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(144, 2, 'checkout', 36, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 606, NULL, NULL, '2018-04-24 03:38:33', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(145, 1, 'checkout', 55, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 68, NULL, NULL, '2018-05-04 01:11:49', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(146, 1, 'checkout', 2, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 330, NULL, NULL, '2018-02-11 15:04:25', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(147, 1, 'checkout', 15, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 766, NULL, NULL, '2018-03-20 00:02:53', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(148, 2, 'checkout', 33, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 695, NULL, NULL, '2018-01-28 17:04:52', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(149, 2, 'checkout', 27, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1304, NULL, NULL, '2017-06-27 21:54:50', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(150, 1, 'checkout', 24, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1278, NULL, NULL, '2017-08-01 22:46:06', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(151, 1, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1372, NULL, NULL, '2018-01-25 22:04:05', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(152, 2, 'checkout', 42, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1325, NULL, NULL, '2017-11-18 02:02:00', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(153, 2, 'checkout', 19, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 644, NULL, NULL, '2017-07-07 11:02:50', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(154, 1, 'checkout', 42, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 64, NULL, NULL, '2018-05-09 12:15:49', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(155, 2, 'checkout', 17, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1102, NULL, NULL, '2017-10-08 19:48:51', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(156, 1, 'checkout', 11, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1373, NULL, NULL, '2017-09-17 06:57:05', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(157, 1, 'checkout', 38, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1276, NULL, NULL, '2017-07-22 12:45:35', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(158, 2, 'checkout', 5, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1226, NULL, NULL, '2018-01-06 03:44:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(159, 2, 'checkout', 17, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 526, NULL, NULL, '2017-12-04 07:02:19', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(160, 1, 'checkout', 57, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 976, NULL, NULL, '2018-03-19 20:34:44', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(161, 2, 'checkout', 12, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 256, NULL, NULL, '2017-06-17 23:39:47', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(162, 2, 'checkout', 44, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 747, NULL, NULL, '2017-11-05 15:34:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(163, 2, 'checkout', 30, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 100, NULL, NULL, '2017-07-22 22:39:25', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(164, 1, 'checkout', 40, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 918, NULL, NULL, '2018-04-25 02:13:36', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(165, 1, 'checkout', 11, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 890, NULL, NULL, '2017-06-04 21:39:09', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(166, 2, 'checkout', 11, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 465, NULL, NULL, '2017-08-24 09:50:18', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(167, 2, 'checkout', 24, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1323, NULL, NULL, '2017-10-15 13:30:25', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(168, 1, 'checkout', 58, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1209, NULL, NULL, '2018-01-27 23:30:25', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(169, 1, 'checkout', 36, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 780, NULL, NULL, '2017-05-17 15:16:18', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(170, 1, 'checkout', 21, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 686, NULL, NULL, '2017-10-15 11:12:33', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(171, 2, 'checkout', 53, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 557, NULL, NULL, '2018-03-06 12:03:57', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(172, 1, 'checkout', 42, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 883, NULL, NULL, '2018-05-09 21:21:58', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(173, 1, 'checkout', 51, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 689, NULL, NULL, '2017-06-30 08:45:11', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(174, 2, 'checkout', 23, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 869, NULL, NULL, '2017-05-27 16:03:04', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(175, 1, 'checkout', 13, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 922, NULL, NULL, '2018-03-22 18:20:06', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(176, 1, 'checkout', 20, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 727, NULL, NULL, '2017-06-02 04:50:13', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(177, 1, 'checkout', 49, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1345, NULL, NULL, '2018-02-27 03:10:50', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(178, 1, 'checkout', 45, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 649, NULL, NULL, '2017-06-26 09:04:09', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(179, 2, 'checkout', 32, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 213, NULL, NULL, '2018-05-07 03:17:23', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(180, 1, 'checkout', 12, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 495, NULL, NULL, '2017-10-29 21:46:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(181, 2, 'checkout', 53, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 720, NULL, NULL, '2018-03-02 06:00:52', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(182, 1, 'checkout', 38, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1215, NULL, NULL, '2017-05-18 10:25:42', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(183, 2, 'checkout', 51, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 457, NULL, NULL, '2017-12-05 09:36:48', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(184, 2, 'checkout', 10, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 194, NULL, NULL, '2017-10-07 04:28:39', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(185, 1, 'checkout', 25, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 36, NULL, NULL, '2018-01-01 22:18:02', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(186, 1, 'checkout', 41, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 119, NULL, NULL, '2017-06-06 23:15:44', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(187, 2, 'checkout', 55, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1129, NULL, NULL, '2018-01-18 01:44:02', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(188, 2, 'checkout', 41, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 773, NULL, NULL, '2017-09-11 03:46:30', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(189, 2, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 403, NULL, NULL, '2017-08-06 11:09:10', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(190, 2, 'checkout', 2, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 838, NULL, NULL, '2017-05-29 22:10:42', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(191, 2, 'checkout', 14, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 975, NULL, NULL, '2017-08-20 10:30:00', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(192, 1, 'checkout', 17, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 582, NULL, NULL, '2017-10-02 02:06:05', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(193, 2, 'checkout', 50, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 200, NULL, NULL, '2017-08-01 08:19:01', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(194, 2, 'checkout', 19, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 504, NULL, NULL, '2017-11-23 08:19:20', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(195, 2, 'checkout', 57, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 11, NULL, NULL, '2017-11-17 10:34:31', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(196, 1, 'checkout', 8, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 19, NULL, NULL, '2017-05-29 20:09:12', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(197, 1, 'checkout', 30, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 452, NULL, NULL, '2017-11-16 12:32:24', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(198, 2, 'checkout', 6, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 945, NULL, NULL, '2018-01-29 07:14:14', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(199, 1, 'checkout', 52, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 522, NULL, NULL, '2017-10-10 03:30:37', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(200, 2, 'checkout', 29, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 993, NULL, NULL, '2017-06-05 04:08:57', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(201, 2, 'checkout', 7, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1365, NULL, NULL, '2017-10-16 20:00:06', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(202, 1, 'checkout', 25, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 532, NULL, NULL, '2017-06-02 20:28:19', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(203, 1, 'checkout', 29, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 320, NULL, NULL, '2017-11-17 23:44:43', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(204, 2, 'checkout', 44, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1238, NULL, NULL, '2017-09-21 12:13:32', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(205, 1, 'checkout', 27, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 437, NULL, NULL, '2018-04-21 20:58:48', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(206, 1, 'checkout', 37, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 181, NULL, NULL, '2017-10-28 23:34:37', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(207, 2, 'checkout', 37, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 668, NULL, NULL, '2017-06-04 08:21:25', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(208, 1, 'checkout', 54, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 75, NULL, NULL, '2018-04-03 02:21:16', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(209, 2, 'checkout', 2, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 948, NULL, NULL, '2017-12-31 06:13:50', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(210, 2, 'checkout', 56, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1171, NULL, NULL, '2017-08-30 14:37:12', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(211, 2, 'checkout', 8, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 481, NULL, NULL, '2017-10-09 03:03:35', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(212, 2, 'checkout', 33, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1328, NULL, NULL, '2018-01-03 06:52:00', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(213, 2, 'checkout', 42, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 158, NULL, NULL, '2018-01-26 16:39:05', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(214, 1, 'checkout', 56, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 126, NULL, NULL, '2018-04-26 02:23:05', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(215, 1, 'checkout', 27, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 943, NULL, NULL, '2017-10-23 12:12:41', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(216, 1, 'checkout', 42, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 849, NULL, NULL, '2017-07-22 15:37:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(217, 1, 'checkout', 19, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 144, NULL, NULL, '2018-04-21 06:51:28', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(218, 2, 'checkout', 8, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1149, NULL, NULL, '2018-03-23 12:23:08', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(219, 2, 'checkout', 48, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 149, NULL, NULL, '2017-08-06 04:32:30', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(220, 1, 'checkout', 15, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 549, NULL, NULL, '2017-10-12 04:09:19', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(221, 2, 'checkout', 14, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 167, NULL, NULL, '2018-04-08 13:39:53', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(222, 1, 'checkout', 58, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1308, NULL, NULL, '2017-05-17 17:41:37', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(223, 2, 'checkout', 27, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 857, NULL, NULL, '2018-03-17 01:52:13', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(224, 2, 'checkout', 42, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1262, NULL, NULL, '2017-12-20 21:25:02', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(225, 2, 'checkout', 10, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1166, NULL, NULL, '2018-04-30 06:47:31', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(226, 1, 'checkout', 16, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 985, NULL, NULL, '2017-07-24 02:58:53', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(227, 2, 'checkout', 21, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 578, NULL, NULL, '2017-10-02 07:35:36', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(228, 1, 'checkout', 52, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 379, NULL, NULL, '2018-01-06 16:43:36', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(229, 2, 'checkout', 5, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 910, NULL, NULL, '2018-04-20 14:25:51', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(230, 1, 'checkout', 36, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 283, NULL, NULL, '2017-08-02 15:59:14', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(231, 2, 'checkout', 28, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 950, NULL, NULL, '2017-06-22 13:27:30', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(232, 1, 'checkout', 19, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 816, NULL, NULL, '2017-07-22 12:36:24', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(233, 1, 'checkout', 57, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 115, NULL, NULL, '2017-10-06 18:16:23', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(234, 2, 'checkout', 56, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 573, NULL, NULL, '2018-02-07 01:46:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(235, 1, 'checkout', 2, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 299, NULL, NULL, '2017-10-31 04:49:53', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(236, 2, 'checkout', 32, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 467, NULL, NULL, '2018-02-28 07:39:55', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(237, 1, 'checkout', 44, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 904, NULL, NULL, '2018-02-11 07:45:27', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(238, 2, 'checkout', 51, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 871, NULL, NULL, '2018-04-26 22:40:28', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(239, 1, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 101, NULL, NULL, '2018-02-19 09:24:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(240, 2, 'checkout', 15, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 132, NULL, NULL, '2018-01-30 22:07:20', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(241, 2, 'checkout', 7, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1211, NULL, NULL, '2018-02-17 03:53:48', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(242, 2, 'checkout', 23, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1347, NULL, NULL, '2018-02-01 09:30:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(243, 1, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 643, NULL, NULL, '2017-11-20 23:06:24', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(244, 2, 'checkout', 10, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 258, NULL, NULL, '2017-12-14 12:43:43', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(245, 2, 'checkout', 30, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1321, NULL, NULL, '2018-04-20 23:57:49', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(246, 2, 'checkout', 21, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 306, NULL, NULL, '2018-04-21 21:35:52', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(247, 2, 'checkout', 38, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1118, NULL, NULL, '2018-02-16 16:04:06', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(248, 1, 'checkout', 4, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 232, NULL, NULL, '2018-04-14 05:33:30', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(249, 2, 'checkout', 46, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 548, NULL, NULL, '2017-11-29 18:41:18', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(250, 1, 'checkout', 49, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 195, NULL, NULL, '2017-11-11 04:24:25', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(251, 1, 'checkout', 53, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 848, NULL, NULL, '2017-10-03 09:36:10', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(252, 1, 'checkout', 51, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 828, NULL, NULL, '2017-05-21 21:01:17', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(253, 2, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1180, NULL, NULL, '2017-10-05 04:44:49', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(254, 1, 'checkout', 24, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 998, NULL, NULL, '2017-11-25 16:05:13', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(255, 2, 'checkout', 10, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 217, NULL, NULL, '2017-07-19 17:35:36', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(256, 2, 'checkout', 5, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 968, NULL, NULL, '2017-06-09 11:37:40', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(257, 2, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 39, NULL, NULL, '2017-05-30 13:43:16', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(258, 2, 'checkout', 32, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 103, NULL, NULL, '2018-03-25 17:44:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(259, 2, 'checkout', 2, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 230, NULL, NULL, '2017-07-03 11:54:17', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(260, 1, 'checkout', 17, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 955, NULL, NULL, '2017-07-06 02:26:11', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(261, 2, 'checkout', 44, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1359, NULL, NULL, '2017-06-15 02:34:45', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(262, 2, 'checkout', 48, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 786, NULL, NULL, '2018-03-02 23:23:32', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(263, 2, 'checkout', 17, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 658, NULL, NULL, '2017-06-15 18:19:57', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(264, 1, 'checkout', 28, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 220, NULL, NULL, '2017-11-08 14:11:17', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(265, 1, 'checkout', 50, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1193, NULL, NULL, '2017-07-11 17:24:16', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(266, 2, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 576, NULL, NULL, '2018-02-19 12:49:50', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(267, 1, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1157, NULL, NULL, '2018-02-10 09:56:21', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(268, 2, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 618, NULL, NULL, '2017-10-25 08:41:54', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(269, 2, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 288, NULL, NULL, '2017-06-23 17:53:55', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(270, 1, 'checkout', 5, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 31, NULL, NULL, '2017-06-08 14:24:58', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(271, 1, 'checkout', 36, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 300, NULL, NULL, '2017-12-28 18:46:36', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(272, 2, 'checkout', 37, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 595, NULL, NULL, '2017-06-15 15:47:41', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(273, 1, 'checkout', 22, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 479, NULL, NULL, '2018-03-12 19:58:30', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(274, 2, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1309, NULL, NULL, '2017-11-25 13:05:46', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(275, 1, 'checkout', 40, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 340, NULL, NULL, '2017-10-10 23:07:39', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(276, 2, 'checkout', 19, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 139, NULL, NULL, '2017-11-05 05:02:22', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(277, 2, 'checkout', 14, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 341, NULL, NULL, '2017-11-03 17:52:56', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(278, 2, 'checkout', 52, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 678, NULL, NULL, '2017-10-30 00:41:56', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(279, 1, 'checkout', 39, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 129, NULL, NULL, '2017-12-25 01:07:16', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `action_logs` (`id`, `user_id`, `action_type`, `target_id`, `target_type`, `location_id`, `note`, `filename`, `item_type`, `item_id`, `expected_checkin`, `accepted_id`, `created_at`, `updated_at`, `deleted_at`, `thread_id`, `company_id`, `accept_signature`, `log_meta`) VALUES
(280, 1, 'checkout', 23, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 798, NULL, NULL, '2017-06-24 15:16:26', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(281, 2, 'checkout', 9, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 6, NULL, NULL, '2017-10-29 03:00:27', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(282, 2, 'checkout', 8, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 706, NULL, NULL, '2017-07-19 01:29:00', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(283, 1, 'checkout', 34, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 32, NULL, NULL, '2018-01-19 06:38:09', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(284, 1, 'checkout', 30, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 248, NULL, NULL, '2018-01-02 14:31:29', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(285, 2, 'checkout', 47, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 631, NULL, NULL, '2017-08-17 12:56:29', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(286, 1, 'checkout', 6, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 942, NULL, NULL, '2018-01-28 01:08:26', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(287, 2, 'checkout', 43, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1163, NULL, NULL, '2018-03-02 02:28:37', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(288, 1, 'checkout', 42, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1283, NULL, NULL, '2017-07-12 09:48:36', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(289, 2, 'checkout', 44, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 610, NULL, NULL, '2017-07-27 16:17:57', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(290, 2, 'checkout', 33, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1337, NULL, NULL, '2017-10-30 19:03:19', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(291, 2, 'checkout', 24, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 447, NULL, NULL, '2017-06-06 12:26:59', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(292, 2, 'checkout', 25, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1240, NULL, NULL, '2017-11-15 14:22:46', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(293, 1, 'checkout', 12, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 805, NULL, NULL, '2018-02-21 22:30:06', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(294, 2, 'checkout', 48, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 371, NULL, NULL, '2018-05-15 00:56:40', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(295, 1, 'checkout', 43, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 989, NULL, NULL, '2017-11-09 10:59:31', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(296, 2, 'checkout', 10, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1324, NULL, NULL, '2017-09-18 04:37:48', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(297, 2, 'checkout', 24, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 285, NULL, NULL, '2017-07-11 09:03:57', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(298, 1, 'checkout', 40, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 788, NULL, NULL, '2017-12-19 10:37:53', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(299, 1, 'checkout', 22, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 675, NULL, NULL, '2017-06-16 22:05:25', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(300, 1, 'checkout', 2, 'App\\Models\\User', NULL, NULL, NULL, 'App\\Models\\Asset', 1159, NULL, NULL, '2017-09-04 05:14:23', '2018-05-15 04:40:36', NULL, NULL, NULL, NULL, NULL),
(301, 1, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1251, NULL, NULL, '2018-01-26 00:18:57', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(302, 2, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 518, NULL, NULL, '2018-03-18 09:31:10', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(303, 2, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 823, NULL, NULL, '2018-04-03 01:03:58', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(304, 2, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 617, NULL, NULL, '2018-01-26 18:53:49', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(305, 2, 'checkout', 4, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1260, NULL, NULL, '2017-06-14 15:44:49', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(306, 1, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 497, NULL, NULL, '2017-12-12 04:13:48', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(307, 1, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 919, NULL, NULL, '2017-09-18 22:43:15', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(308, 1, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1136, NULL, NULL, '2017-07-30 08:54:06', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(309, 2, 'checkout', 8, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 806, NULL, NULL, '2017-12-29 21:50:06', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(310, 1, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 127, NULL, NULL, '2017-05-20 13:19:44', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(311, 1, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 247, NULL, NULL, '2018-02-16 12:32:20', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(312, 2, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 699, NULL, NULL, '2018-03-18 05:25:51', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(313, 2, 'checkout', 4, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 243, NULL, NULL, '2017-08-06 15:57:17', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(314, 2, 'checkout', 4, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 355, NULL, NULL, '2018-01-16 07:28:27', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(315, 2, 'checkout', 8, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 971, NULL, NULL, '2017-09-13 21:24:58', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(316, 2, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1318, NULL, NULL, '2018-01-30 19:04:43', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(317, 1, 'checkout', 3, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1187, NULL, NULL, '2018-03-28 10:20:39', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(318, 2, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1115, NULL, NULL, '2018-02-21 06:46:26', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(319, 1, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 843, NULL, NULL, '2017-10-23 02:57:33', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(320, 1, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1000, NULL, NULL, '2017-10-18 00:07:22', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(321, 2, 'checkout', 9, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 468, NULL, NULL, '2018-01-16 01:20:26', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(322, 2, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 597, NULL, NULL, '2017-08-31 10:52:53', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(323, 2, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 739, NULL, NULL, '2017-08-19 09:41:28', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(324, 1, 'checkout', 9, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 958, NULL, NULL, '2018-03-19 13:19:08', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(325, 1, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1151, NULL, NULL, '2018-04-02 22:14:28', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(326, 2, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 701, NULL, NULL, '2017-10-05 20:03:31', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(327, 2, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1237, NULL, NULL, '2017-08-19 21:57:04', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(328, 2, 'checkout', 8, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 513, NULL, NULL, '2017-05-29 21:51:08', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(329, 2, 'checkout', 9, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 347, NULL, NULL, '2017-08-08 12:41:35', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(330, 1, 'checkout', 8, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 909, NULL, NULL, '2018-02-20 11:36:08', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(331, 1, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 368, NULL, NULL, '2018-03-06 07:25:11', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(332, 1, 'checkout', 9, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 444, NULL, NULL, '2018-04-06 18:56:44', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(333, 2, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 237, NULL, NULL, '2017-12-24 23:12:17', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(334, 1, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 596, NULL, NULL, '2018-02-07 19:08:44', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(335, 2, 'checkout', 3, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 536, NULL, NULL, '2017-10-06 07:50:26', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(336, 2, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 428, NULL, NULL, '2017-09-23 00:29:31', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(337, 1, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 172, NULL, NULL, '2018-05-01 00:18:15', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(338, 1, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 493, NULL, NULL, '2017-11-09 09:41:19', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(339, 2, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 961, NULL, NULL, '2018-01-22 23:04:31', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(340, 1, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 996, NULL, NULL, '2017-08-29 21:45:45', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(341, 2, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 520, NULL, NULL, '2017-09-15 22:46:18', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(342, 1, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 487, NULL, NULL, '2017-07-08 02:23:46', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(343, 2, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 965, NULL, NULL, '2017-10-28 08:24:31', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(344, 2, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 82, NULL, NULL, '2017-07-17 07:43:44', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(345, 1, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 588, NULL, NULL, '2017-10-18 05:03:46', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(346, 2, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 377, NULL, NULL, '2017-10-24 22:35:41', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(347, 1, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 130, NULL, NULL, '2017-11-09 23:04:15', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(348, 1, 'checkout', 4, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 587, NULL, NULL, '2017-09-13 07:02:19', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(349, 2, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 821, NULL, NULL, '2017-09-04 09:44:37', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(350, 2, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 690, NULL, NULL, '2017-05-27 05:14:31', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(351, 1, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 286, NULL, NULL, '2018-04-06 16:36:20', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(352, 1, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 627, NULL, NULL, '2018-01-30 03:29:16', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(353, 1, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 390, NULL, NULL, '2018-01-16 13:04:34', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(354, 2, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 81, NULL, NULL, '2018-02-25 15:28:54', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(355, 1, 'checkout', 3, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 888, NULL, NULL, '2017-12-12 03:08:20', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(356, 2, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 760, NULL, NULL, '2017-12-08 01:01:26', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(357, 2, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1258, NULL, NULL, '2017-11-17 04:36:35', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(358, 1, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 186, NULL, NULL, '2017-06-05 23:25:52', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(359, 2, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 54, NULL, NULL, '2017-09-30 12:27:34', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(360, 2, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 317, NULL, NULL, '2017-10-30 04:20:34', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(361, 1, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 295, NULL, NULL, '2017-07-05 06:30:57', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(362, 2, 'checkout', 8, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1206, NULL, NULL, '2018-02-09 17:52:54', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(363, 1, 'checkout', 9, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1173, NULL, NULL, '2017-08-28 09:08:32', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(364, 1, 'checkout', 3, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1340, NULL, NULL, '2017-09-10 18:09:01', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(365, 1, 'checkout', 8, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 475, NULL, NULL, '2018-03-31 22:30:51', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(366, 2, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1301, NULL, NULL, '2017-07-09 17:58:26', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(367, 1, 'checkout', 8, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 674, NULL, NULL, '2018-03-10 01:09:40', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(368, 2, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 175, NULL, NULL, '2017-08-22 10:02:41', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(369, 1, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1140, NULL, NULL, '2018-02-07 17:07:21', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(370, 2, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 76, NULL, NULL, '2017-11-18 07:38:55', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(371, 2, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1179, NULL, NULL, '2017-12-14 17:46:08', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(372, 2, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 895, NULL, NULL, '2017-09-17 14:21:21', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(373, 1, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 476, NULL, NULL, '2017-12-25 01:47:06', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(374, 1, 'checkout', 9, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 870, NULL, NULL, '2017-05-18 11:48:53', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(375, 2, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 744, NULL, NULL, '2017-11-09 11:39:10', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(376, 1, 'checkout', 4, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 399, NULL, NULL, '2017-12-22 18:24:01', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(377, 1, 'checkout', 8, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 178, NULL, NULL, '2018-03-31 18:58:24', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(378, 1, 'checkout', 4, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 321, NULL, NULL, '2017-11-13 17:09:31', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(379, 2, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 216, NULL, NULL, '2018-03-28 18:54:56', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(380, 2, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 952, NULL, NULL, '2018-04-02 12:03:29', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(381, 2, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 224, NULL, NULL, '2018-01-09 02:32:08', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(382, 2, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 63, NULL, NULL, '2017-07-28 16:56:10', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(383, 1, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 375, NULL, NULL, '2017-11-28 17:16:06', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(384, 2, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 628, NULL, NULL, '2017-12-07 03:02:04', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(385, 2, 'checkout', 8, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 401, NULL, NULL, '2017-06-10 06:10:14', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(386, 2, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 927, NULL, NULL, '2017-11-08 02:37:39', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(387, 2, 'checkout', 5, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 289, NULL, NULL, '2018-04-18 15:36:42', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(388, 1, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 203, NULL, NULL, '2018-01-04 08:24:09', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(389, 2, 'checkout', 4, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 92, NULL, NULL, '2017-05-24 11:12:12', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(390, 1, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 718, NULL, NULL, '2017-09-09 23:06:20', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(391, 1, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 161, NULL, NULL, '2018-03-31 02:57:10', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(392, 1, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1192, NULL, NULL, '2018-04-09 03:58:36', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(393, 1, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 416, NULL, NULL, '2017-05-25 07:41:52', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(394, 1, 'checkout', 4, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 657, NULL, NULL, '2018-04-14 23:56:03', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(395, 2, 'checkout', 2, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1253, NULL, NULL, '2018-04-02 14:45:20', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(396, 1, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 228, NULL, NULL, '2017-11-21 20:37:39', '2018-05-15 04:40:37', NULL, NULL, NULL, NULL, NULL),
(397, 2, 'checkout', 7, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 613, NULL, NULL, '2018-04-07 07:32:17', '2018-05-15 04:40:38', NULL, NULL, NULL, NULL, NULL),
(398, 2, 'checkout', 10, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 210, NULL, NULL, '2018-02-22 03:03:25', '2018-05-15 04:40:38', NULL, NULL, NULL, NULL, NULL),
(399, 1, 'checkout', 1, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 274, NULL, NULL, '2017-08-11 19:40:46', '2018-05-15 04:40:38', NULL, NULL, NULL, NULL, NULL),
(400, 1, 'checkout', 6, 'App\\Models\\Location', NULL, NULL, NULL, 'App\\Models\\Asset', 1165, NULL, NULL, '2017-11-02 03:01:26', '2018-05-15 04:40:38', NULL, NULL, NULL, NULL, NULL),
(401, 1, 'delete', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Consumable', 1, NULL, NULL, '2018-05-15 09:45:21', '2018-05-15 09:45:21', NULL, NULL, 3, NULL, NULL),
(402, 1, 'delete', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Consumable', 2, NULL, NULL, '2018-05-15 09:45:27', '2018-05-15 09:45:27', NULL, NULL, NULL, NULL, NULL),
(403, 1, 'delete', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Consumable', 3, NULL, NULL, '2018-05-15 09:45:31', '2018-05-15 09:45:31', NULL, NULL, NULL, NULL, NULL),
(404, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Component', 1, NULL, NULL, '2018-05-16 02:51:38', '2018-05-16 02:51:38', NULL, NULL, 4, NULL, NULL),
(405, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Component', 2, NULL, NULL, '2018-05-16 02:52:56', '2018-05-16 02:52:56', NULL, NULL, 4, NULL, NULL),
(406, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Component', 4, NULL, NULL, '2018-05-16 02:53:51', '2018-05-16 02:53:51', NULL, NULL, 1, NULL, NULL),
(407, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Component', 3, NULL, NULL, '2018-05-16 02:54:29', '2018-05-16 02:54:29', NULL, NULL, 4, NULL, NULL),
(408, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Accessory', 1, NULL, NULL, '2018-05-16 06:05:21', '2018-05-16 06:05:21', NULL, NULL, 0, NULL, NULL),
(409, 1, 'update', NULL, NULL, NULL, NULL, NULL, 'App\\Models\\Accessory', 1, NULL, NULL, '2018-05-16 06:05:41', '2018-05-16 06:05:41', NULL, NULL, 0, NULL, NULL),
(410, 1, 'checkout', 1, 'App\\Models\\User', 1, '', NULL, 'App\\Models\\Asset', 1284, NULL, NULL, '2018-05-17 06:47:12', '2018-05-17 06:47:12', NULL, NULL, 0, NULL, NULL),
(411, 1, 'checkout', 1, 'App\\Models\\User', 1, '', NULL, 'App\\Models\\Asset', 3, NULL, NULL, '2018-05-17 06:49:51', '2018-05-17 06:49:51', NULL, NULL, 0, NULL, NULL),
(412, 1, 'checkout', 1, 'App\\Models\\User', 1, '', NULL, 'App\\Models\\Asset', 512, NULL, NULL, '2018-05-17 06:50:59', '2018-05-17 06:50:59', NULL, NULL, 0, NULL, NULL),
(413, 1, 'checkout', 1, 'App\\Models\\User', 1, '', NULL, 'App\\Models\\Asset', 768, NULL, NULL, '2018-05-17 06:51:50', '2018-05-17 06:51:50', NULL, NULL, 0, NULL, NULL),
(414, 1, 'checkout', 1, 'App\\Models\\User', 1, '', NULL, 'App\\Models\\Asset', 1280, NULL, NULL, '2018-05-17 06:59:35', '2018-05-17 06:59:35', NULL, NULL, 0, NULL, NULL),
(415, 1, 'checkout', 1, 'App\\Models\\User', 1, '', NULL, 'App\\Models\\Asset', 1, NULL, NULL, '2018-05-17 07:03:33', '2018-05-17 07:03:33', NULL, NULL, 0, NULL, NULL),
(416, 1, 'checkout', 1, 'App\\Models\\User', 1, '', NULL, 'App\\Models\\Asset', 257, NULL, NULL, '2018-05-17 07:05:26', '2018-05-17 07:05:26', NULL, NULL, 0, NULL, NULL),
(417, 1, 'checkout', 1, 'App\\Models\\User', 1, '', NULL, 'App\\Models\\Asset', 769, NULL, NULL, '2018-05-17 07:13:45', '2018-05-17 07:13:45', NULL, NULL, 0, NULL, NULL),
(418, 1, 'checkin from', 1, 'App\\Models\\User', NULL, '', NULL, 'App\\Models\\Asset', 768, NULL, NULL, '2018-05-17 09:00:30', '2018-05-17 09:00:30', NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `serial` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `physical` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT '0',
  `warranty_months` int(11) DEFAULT NULL,
  `depreciate` tinyint(1) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `requestable` tinyint(4) NOT NULL DEFAULT '0',
  `rtd_location_id` int(11) DEFAULT NULL,
  `accepted` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_checkout` datetime DEFAULT NULL,
  `expected_checkin` date DEFAULT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `assigned_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_audit_date` datetime DEFAULT NULL,
  `next_audit_date` date DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `_snipeit_digitized_dynamic_success_1` text COLLATE utf8mb4_unicode_ci,
  `_snipeit_universal_intangible_info_mediaries_2` text COLLATE utf8mb4_unicode_ci,
  `_snipeit_up_sized_foreground_model_3` text COLLATE utf8mb4_unicode_ci,
  `_snipeit_vision_oriented_coherent_implementation_4` text COLLATE utf8mb4_unicode_ci,
  `_snipeit_normal_re_order_level_5` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `accepted`, `last_checkout`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `_snipeit_digitized_dynamic_success_1`, `_snipeit_universal_intangible_info_mediaries_2`, `_snipeit_up_sized_foreground_model_3`, `_snipeit_vision_oriented_coherent_implementation_4`, `_snipeit_normal_re_order_level_5`) VALUES
(1, NULL, '252869272', 1, '8e3b0707-79fa-32dd-9ea3-cfbcfda15bea', '2017-09-13', '1213.26', '37846073', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-17 07:03:33', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, 'pending', '2018-05-17 10:03:33', NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(2, NULL, '1172875471', 1, 'abdcbb99-fe34-30c5-9bbc-a7f55868ac75', '2017-10-23', '2101.67', '16981506', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(3, NULL, '1087094920', 1, '03aa9e69-d62e-3001-aeb6-9304dac5607d', '2017-08-18', '2875.41', '15541250', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-17 06:49:51', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, 'pending', '2018-05-17 09:49:51', NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(4, NULL, '1348296186', 1, '77d84d2a-e298-37e2-bfb3-7f6a7406a6d4', '2017-08-13', '2920.58', '41423053', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(5, NULL, '183999918', 1, 'd300c209-a949-3e6c-876d-2e723513335c', '2017-12-08', '1109.85', '49335532', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(6, NULL, '939138558', 1, 'c8cc8dd5-6cb7-380a-ae2b-356eb4b2a2ab', '2018-03-31', '563.25', '4710230', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(7, NULL, '1051708739', 1, 'ab1ab0a1-4588-37d6-b90b-c5ff8742965b', '2017-08-15', '2062.93', '19503372', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(8, NULL, '422124343', 1, 'c75b57cd-1719-31a3-8074-fb8588adc268', '2018-04-14', '2621.00', '24399801', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(9, NULL, '430439798', 1, '73919b39-a696-31da-9f67-4a21e914310e', '2017-12-26', '2242.23', '11167677', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(10, NULL, '1434574874', 1, 'f3b87272-bee9-3760-b495-74c22cc5e75f', '2017-06-07', '2657.90', '1774542', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(11, NULL, '441501102', 1, '1eba762d-d128-37eb-a1d7-a8f2a50e5975', '2017-07-15', '356.94', '26645004', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(12, NULL, '807088866', 1, '4942eec1-fc5f-3e4f-a61f-e370e5c11035', '2017-09-27', '2640.25', '37366847', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(13, NULL, '196835959', 1, '3c38bcd0-84a3-3cd5-a2eb-58f3b9f7a260', '2017-12-31', '2019.05', '41071311', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(14, NULL, '850323371', 1, '79d4bbf6-5e64-3bb6-a5a4-ab1a0519030d', '2018-04-13', '2168.90', '36302955', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(15, NULL, '913559520', 1, '160d6d5e-cec3-33ec-b175-c7edd1a1f3ab', '2017-06-25', '438.86', '1548120', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(16, NULL, '168353008', 1, '5cb58ac3-95d7-31c3-ab4d-5a74e67ace5e', '2018-04-12', '731.65', '19122186', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(17, NULL, '719759026', 1, '3eda41e8-4145-34d5-ab65-0480508104db', '2018-05-11', '1101.23', '33763116', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(18, NULL, '1057518450', 1, 'b7453f59-e395-3237-8728-9b83b37e6ebf', '2018-03-12', '2839.60', '8021157', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(19, NULL, '681539298', 1, '5400323a-87b5-3ceb-a565-953096df3bb6', '2017-12-20', '2994.75', '22433275', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(20, NULL, '545711730', 1, '7b6063d1-61ab-3bb9-b46d-570c4ddd823a', '2017-06-03', '621.36', '4410868', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(21, NULL, '1272325618', 1, 'bd9f799c-8e15-39cf-84b3-f167ec9168c3', '2018-03-31', '2543.77', '49653724', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(22, NULL, '1121689243', 1, '3d2c71b0-55b2-3aec-85e0-b2a4d46d609b', '2017-10-25', '391.30', '1885095', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(23, NULL, '701630480', 1, 'dd860dcf-5f1e-39f3-a8e3-d69e2571f176', '2017-08-26', '334.61', '44981123', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(24, NULL, '514319822', 1, 'c66d49d8-f68a-3b9c-9ea3-dc1016da3d31', '2018-04-29', '2258.05', '15395981', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(25, NULL, '1023670845', 1, '5f669f87-6bb0-39a6-b93c-c5a5d5458587', '2017-09-06', '2926.96', '18845514', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(26, NULL, '1243964913', 1, 'a4de6990-8b40-3f22-9059-8537c8493262', '2017-09-21', '841.74', '4557920', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(27, NULL, '460512851', 1, '752b19b2-05d0-3497-a0c8-6ef8a60895ee', '2017-08-06', '1833.89', '2317884', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(28, NULL, '481878441', 1, '61a6e3c6-dbb8-3f30-8231-39b0a91e57ba', '2017-08-10', '848.35', '19816478', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(29, NULL, '1141207092', 1, '5a118189-a1fc-3889-bfec-f60054e3d1f1', '2018-05-04', '450.84', '20314048', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(30, NULL, '754467186', 1, 'ec34b69a-45ed-36e8-b50e-d285fdf3a3b9', '2017-12-06', '2935.70', '7762873', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(31, NULL, '861096898', 1, '599d8537-118a-37e2-aca4-49a59947f8b9', '2018-01-05', '1206.59', '28056064', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(32, NULL, '401376762', 1, '9473c963-6908-3da2-abc3-0cb976cdf49f', '2017-07-09', '373.94', '30143700', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(33, NULL, '964733379', 1, '413a8c52-038b-3a50-b410-b9498dff5bb3', '2017-08-02', '684.72', '9507127', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(34, NULL, '212804244', 1, 'b929fffd-9b32-3295-adb4-fd7f953d0d3f', '2018-05-06', '1467.03', '34269138', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(35, NULL, '1497657196', 1, '34c416cb-68fa-3d59-97ac-fab7952c0d45', '2017-08-15', '2830.71', '42581264', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(36, NULL, '318316816', 1, 'c9e45f3d-52e0-3042-a511-52f6f5be10be', '2018-05-02', '2052.08', '47112722', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(37, NULL, '1288099191', 1, '168b819b-84da-339d-96c3-974181b05401', '2017-06-26', '1298.21', '44251025', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(38, NULL, '754679451', 1, '91cebd23-b3bb-3f41-a554-33a04f5d0466', '2018-04-06', '1957.42', '8101969', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(39, NULL, '969739573', 1, '7133106f-81a9-3a90-b026-cd55d7e1896d', '2018-05-10', '2871.64', '43589962', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(40, NULL, '893993885', 1, '3b448c7e-df25-3ed2-a50d-70a3cc567596', '2018-03-30', '2858.40', '24206157', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(41, NULL, '776115889', 1, '473f2840-a598-3e89-b2c4-2e328ddcf0f3', '2017-12-25', '1008.28', '17498867', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(42, NULL, '744915563', 1, '14ed9ad9-0441-3aef-a356-5618da08884c', '2017-05-28', '2050.45', '14886199', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(43, NULL, '938338592', 1, '5f19014a-1441-3d09-9767-ea077f387dd3', '2018-03-22', '1553.34', '33684568', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(44, NULL, '141155760', 1, 'ce57803f-cf05-371d-86bb-c17411f2d8e7', '2018-02-02', '2344.23', '3629171', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(45, NULL, '1490656057', 1, 'e9b025f6-cf3e-37e9-92b5-bd583756a861', '2017-06-09', '1445.93', '31516022', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(46, NULL, '739051830', 1, 'daea2029-25e3-303e-a94f-402aadd0da53', '2017-08-27', '724.81', '33820240', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(47, NULL, '1109443878', 1, '695b9921-385e-30f4-a805-5f15187d3743', '2018-04-25', '1858.79', '17013609', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(48, NULL, '348549125', 1, '97e82ff3-ef69-3eab-b2df-1724fd8f52f1', '2018-05-07', '1810.01', '13467022', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(49, NULL, '1042504918', 1, '1c2cf9b2-8a82-38a0-bda8-b3512c0a48d3', '2017-09-03', '2053.93', '12599495', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(50, NULL, '140916704', 1, '7c3c3017-1afe-3eea-b26e-4a8fca5dcd2f', '2018-04-06', '670.25', '15012816', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(51, NULL, '671331470', 1, '1638308b-daee-3962-9df6-3e57552f8610', '2018-02-25', '2174.32', '20332799', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(52, NULL, '907002820', 1, '08ae04fb-4c1c-3877-94ae-f0bdae1512a4', '2017-11-07', '1544.57', '5350427', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(53, NULL, '24624306', 1, '183338f9-9340-357f-8feb-0f476489ff17', '2017-11-15', '2777.24', '20411990', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(54, NULL, '417881635', 1, 'bf7f395b-0a07-3ba1-b0da-bf956bc4b356', '2017-09-13', '1994.52', '48014102', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(55, NULL, '756394516', 1, 'c37d7ed1-03e0-349a-b3b0-5c4c24b2f872', '2017-11-01', '1648.96', '33582443', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(56, NULL, '1024237865', 1, '53f34e42-762d-3364-aa20-e4782661f2da', '2017-08-08', '2190.00', '24579362', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(57, NULL, '1517784429', 1, '9093f314-549a-3163-b51c-b4851029bd0e', '2018-03-31', '454.69', '38666088', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(58, NULL, '469586390', 1, '0e4d1eb2-709d-362d-b62c-8172d66d5943', '2018-04-24', '2215.21', '10063759', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(59, NULL, '1094829247', 1, 'd19eaaf8-7919-3f8e-9791-1309c1fde89a', '2017-09-13', '777.29', '5868483', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(60, NULL, '507205570', 1, '429db914-2c5f-39c9-b0ad-47dc25c9df84', '2017-11-15', '1509.33', '44614575', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(61, NULL, '764224855', 1, 'd3784eca-3ef5-3698-af59-b2478d9d21b8', '2017-06-27', '2194.66', '12468891', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(62, NULL, '77242441', 1, '46f35192-7757-3431-b059-271bf737cc91', '2017-10-31', '2197.36', '24257880', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(63, NULL, '1310139037', 1, '2b2d4de4-c5b4-3da8-907b-35b0d3b11b67', '2017-10-16', '2118.45', '20481027', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(64, NULL, '1472612758', 1, '2e956dc3-58c4-3ee8-a63e-ccc21ee84d7d', '2018-03-25', '367.28', '30564852', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(65, NULL, '25909044', 1, '233d902c-c841-3a2b-8ae5-cea5ecbd969f', '2018-03-10', '583.68', '38707194', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(66, NULL, '1010586266', 1, 'e104c26b-f306-3f05-92aa-82edce73ae4d', '2017-09-15', '2718.92', '5683192', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(67, NULL, '1518231788', 1, 'a44030ae-8b72-3b1f-a359-dd0f38a2320a', '2017-05-25', '831.22', '10455020', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(68, NULL, '425080780', 1, 'f2dcf6a3-4821-3c16-9090-5af85418a023', '2017-09-25', '2526.25', '31719344', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(69, NULL, '475331296', 1, '1b647cdf-fed1-327e-89dd-2c00b376f2d5', '2017-08-24', '1584.53', '19672285', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(70, NULL, '38057414', 1, 'b80aaa6c-2947-32d7-af03-d4fa7a84facc', '2017-06-25', '745.98', '3709631', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(71, NULL, '1120240545', 1, '3533e1ea-3503-3992-9406-cb95af35fbfd', '2018-02-24', '2080.08', '44650017', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(72, NULL, '537864439', 1, '31e4b2cc-6de9-30cd-919a-26a92ab5d1d2', '2017-05-25', '643.15', '8989804', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(73, NULL, '1315574834', 1, '7a276bf9-38ee-3671-a2d2-7974a8d784c0', '2017-12-17', '2971.27', '28121627', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(74, NULL, '1272955029', 1, '49f2e81b-9ae0-3800-b7af-dabd4b86b5ef', '2018-02-02', '1807.73', '3641867', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(75, NULL, '584027231', 1, '65ca6ec6-18b5-3d6f-bbff-ab2e8d55802e', '2017-07-02', '1371.77', '30137952', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(76, NULL, '1227486320', 1, '6e7cdc25-7b60-330c-a1d9-55282bd698c4', '2017-09-07', '1998.40', '33322032', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(77, NULL, '71341264', 1, '233e1362-07d3-355e-a63e-1095813822bd', '2017-11-28', '1205.59', '7305651', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(78, NULL, '1166940659', 1, '940dbe63-6e9c-361e-b97b-b8e9d2aacbfe', '2017-09-06', '2999.37', '49178366', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(79, NULL, '154551545', 1, 'ccb98c4a-f51b-3baf-b1fd-f6d946a531a0', '2017-07-10', '923.80', '5370334', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(80, NULL, '164270280', 1, '3af11136-b9d2-334c-a0d1-5112f096b37b', '2017-09-26', '2483.34', '7597332', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(81, NULL, '258688840', 1, '01eba1b7-6144-3ad9-96ad-7abf727c4163', '2017-09-03', '1507.45', '18947266', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(82, NULL, '56459914', 1, '321bbd09-7b21-3236-bf31-391b303f18b6', '2017-06-23', '2080.57', '14763526', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(83, NULL, '170494679', 1, 'a3885d14-4be6-3ba1-9bdb-15df9695036e', '2017-07-27', '564.65', '34392299', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(84, NULL, '1180346793', 1, 'cd2dd46a-a3ff-31f6-8c06-cf3d02f9a762', '2018-01-29', '305.46', '48495197', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(85, NULL, '937193534', 1, '4d7fc8af-3920-327e-8264-33337666baf2', '2017-06-27', '694.23', '27990058', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(86, NULL, '695616508', 1, '35e9f3d1-4531-3faf-b128-5f29b94966db', '2017-11-23', '1148.54', '29017741', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(87, NULL, '209152398', 1, 'b8d4e8f1-47ba-3411-b571-20dacc41c5dd', '2017-06-23', '1942.34', '42162185', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(88, NULL, '835813082', 1, 'c4b51b11-2b60-3165-98dc-1f3ca42f57fe', '2017-10-07', '883.03', '16520571', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(89, NULL, '907040337', 1, '11fd4c37-7134-3604-8c70-8a18e1bb39d6', '2017-11-19', '451.48', '29756948', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(90, NULL, '1008061134', 1, '8563ff46-1713-372f-9f01-27c8e6de159f', '2018-02-12', '587.21', '22435413', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(91, NULL, '470311462', 1, 'e5b3369c-3223-3a9a-af86-4d3dfb5385ab', '2017-08-19', '1369.05', '39652157', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(92, NULL, '458197148', 1, '9aa0658a-39c8-333c-87a1-a4c65cf4e0ce', '2017-06-23', '1496.90', '31716173', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(93, NULL, '198491962', 1, '529e0315-0802-3345-8baf-62cc6ea0c32f', '2017-06-14', '2071.84', '29528663', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(94, NULL, '583956433', 1, 'c8ae14be-348a-38bd-86d2-22e9227077fb', '2018-05-12', '790.63', '32048797', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(95, NULL, '39941011', 1, '7621a3e8-2201-3389-a442-c0b30db0055c', '2018-04-24', '1897.18', '22744564', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(96, NULL, '1058120106', 1, '66b82285-00a4-3678-9393-585e43b95527', '2018-04-25', '1337.64', '37652282', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(97, NULL, '1119968895', 1, '42aec146-6ba4-392e-9236-6e859cb5e9ea', '2018-02-22', '839.77', '39646759', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(98, NULL, '25503663', 1, 'd1883e46-2a08-3de7-b4b7-441ceab280d5', '2017-10-16', '2483.90', '17955828', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(99, NULL, '1514994656', 1, 'e770e6ac-5ce6-3702-8b58-e21abd2c33cf', '2017-10-09', '2844.42', '4366592', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(100, NULL, '1369001680', 1, 'fbb25159-d8ab-30e1-b07c-5421b6f3ab8e', '2017-10-22', '2801.66', '42665299', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(101, NULL, '876509000', 1, 'a90a7d45-099a-3ac0-9d41-618da3a8deca', '2017-06-07', '2996.84', '34724117', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(102, NULL, '1185769362', 1, '99a6c431-b267-3786-90d0-6e7ad8727473', '2017-07-10', '1279.68', '41950420', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(103, NULL, '1115836306', 1, '8668821a-e2b8-3f79-b0f2-7e8d95faa913', '2017-07-19', '683.73', '6098723', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(104, NULL, '51937509', 1, 'f99fd7b0-8446-3ba4-acbe-3aefe77100c2', '2018-03-07', '2454.83', '8831917', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(105, NULL, '461760056', 1, '7ac9ed9a-0b3a-3f65-8172-6c411fbe1898', '2017-08-27', '2163.48', '13598395', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(106, NULL, '1399703697', 1, '8dfaa4e0-6a7f-3235-b6e3-15243366a6b8', '2017-10-07', '1715.94', '44425495', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(107, NULL, '598661522', 1, '08c5e5bf-bbc7-30d9-8a73-a6af87f77b42', '2018-04-26', '2895.98', '12106790', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(108, NULL, '474284029', 1, 'dafde8d1-5d1a-39a4-bb7f-3bcb1376f577', '2017-10-19', '1596.02', '15380813', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(109, NULL, '1466014942', 1, '87756453-d6e9-3739-8157-2f9ea17bcedf', '2018-05-14', '1126.33', '30674526', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(110, NULL, '1165371599', 1, '428e0a7f-c8c4-36b5-9fb0-9c67bdf190a1', '2018-05-10', '2505.74', '49422010', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(111, NULL, '642975571', 1, 'c7ba0918-5a64-3c85-ac73-b4d28edef0f2', '2018-03-29', '2801.87', '8206120', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(112, NULL, '172588654', 1, 'bddf272e-77a1-3263-ab49-e5e45a3b88d1', '2017-10-03', '2488.20', '35741464', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(113, NULL, '411616138', 1, '18d39b3d-8108-3002-96c6-8015766f678e', '2017-09-04', '2657.37', '35706214', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(114, NULL, '1309878970', 1, 'f8b844ff-3cd8-330d-ad89-5df11f22caa7', '2017-09-29', '2481.93', '18044607', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(115, NULL, '1468762851', 1, 'a51f1936-2602-39e7-a594-c6cda7caf044', '2017-08-01', '1431.61', '26899840', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(116, NULL, '127645993', 1, '075d2fe1-73f7-34c3-b9ca-b6bb7ced55dd', '2017-12-10', '401.12', '25714058', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(117, NULL, '76823572', 1, '5ed8f4e1-c0a3-35c3-a1d4-1f515c32193f', '2017-05-15', '495.72', '42587329', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(118, NULL, '438487180', 1, 'dbcad56b-7e16-39ff-b7b4-6a5718debbb2', '2017-12-18', '2830.59', '27134061', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(119, NULL, '8870608', 1, '1f1ce712-32e8-3322-80be-34c3fa14fa3a', '2017-05-16', '837.78', '46489365', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(120, NULL, '617029457', 1, '24095de5-7a3a-3eda-87e4-e4a9d5de4ec5', '2018-04-28', '921.87', '37217983', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:21', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(121, NULL, '386169911', 1, '13c791cd-3c17-3bd5-9181-59663119122b', '2018-04-10', '2227.06', '14927742', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(122, NULL, '1145190236', 1, '7e9af65d-12c0-3768-8c0f-52c3c3cf3093', '2018-05-14', '554.87', '38722170', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(123, NULL, '1022102116', 1, 'fbdb0655-2ccf-3d75-a1c5-0fd28da6215c', '2017-08-31', '2880.92', '40075336', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(124, NULL, '1141610199', 1, '1356a3ed-9ef3-3be7-8d8d-6bcd0b16d477', '2017-08-30', '528.07', '12532866', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(125, NULL, '941643462', 1, '50ca5765-18ca-3565-a317-139da8c6b3bf', '2017-07-19', '2195.00', '25169316', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(126, NULL, '637407362', 1, 'aefac1a7-0362-3447-aa89-2b1bf355c473', '2017-12-04', '1704.75', '30537349', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(127, NULL, '1513191136', 1, '2fdfc274-47b7-38d1-bb7b-3a2851dd0a47', '2017-11-18', '750.56', '32569996', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(128, NULL, '399094287', 1, '1150b307-6f26-3aad-bc5a-3ef79869d696', '2018-02-15', '2639.04', '31378268', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(129, NULL, '602238282', 1, '7cfedc0a-8d40-3c30-b6fe-77e31657b065', '2017-10-25', '1179.20', '37299088', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(130, NULL, '558662197', 1, '62a0502b-533f-36d9-975b-d3f494f0fe67', '2018-01-14', '2711.38', '3426345', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(131, NULL, '923345624', 1, '92f1ebe3-3b02-337b-b06c-f89c122b2a33', '2017-08-31', '1438.92', '25344358', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(132, NULL, '879148754', 1, '16b69805-08b2-3a5e-9644-5d67e6c2d97b', '2017-10-28', '2678.31', '26144771', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(133, NULL, '705099185', 1, 'e1535033-72be-35b2-8a9a-b8d001e1104a', '2017-06-09', '1765.53', '44337437', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(134, NULL, '918503613', 1, '0084f2a8-1b7a-3093-928a-7768dfe72a1a', '2017-12-20', '2362.29', '1582201', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(135, NULL, '1492888049', 1, '9e54935e-3bad-3456-bd44-7c7f99fa8fb2', '2018-01-07', '1175.31', '35142827', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(136, NULL, '240452685', 1, '8f7095c5-f66e-32a3-b09b-625d61c870b1', '2018-04-09', '318.90', '39071823', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(137, NULL, '717806894', 1, 'f160226a-d3fa-32ee-a1bf-c2d9b5bd5cfc', '2017-11-13', '1524.75', '42698092', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(138, NULL, '1416794357', 1, '73b65557-7a94-37ed-86f5-1c912e17a192', '2018-04-21', '634.62', '26068836', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(139, NULL, '455730599', 1, '7db54758-0cbf-3a10-81f2-aa16bfb6a9af', '2017-11-16', '1099.36', '47514827', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(140, NULL, '179378413', 1, '5400c98b-bc92-3e04-b5d4-7e94685aa6d5', '2017-10-09', '1486.59', '47713219', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(141, NULL, '735691057', 1, '09956060-b7b9-356f-becd-4bee36ce5886', '2017-09-24', '2147.56', '49744572', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(142, NULL, '1273908788', 1, '6660d345-423f-39c8-98c1-7225c3e17e09', '2017-10-10', '2279.91', '3815446', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(143, NULL, '539057451', 1, '253e027a-2f29-3eb1-b66b-d19e81dedda4', '2018-03-09', '1057.75', '42107826', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(144, NULL, '645299176', 1, '7a9df491-42e1-3b2e-b726-bef1e9c711ad', '2017-08-28', '1463.63', '12308163', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(145, NULL, '605369258', 1, 'b188e112-56b8-3967-928f-20581c6ce3da', '2017-05-29', '317.43', '49552398', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(146, NULL, '426580632', 1, '154d399b-555d-3c06-b43e-670353922401', '2017-11-11', '2088.13', '32171744', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(147, NULL, '1366510552', 1, 'a6b65550-8d91-340e-882f-f06f565b9828', '2017-08-22', '2311.25', '37543131', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(148, NULL, '1484010933', 1, '9bb2e811-6674-386f-9058-fe1e238293fc', '2017-07-09', '2327.37', '3574330', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(149, NULL, '666022898', 1, '0d1c0b69-fe13-3f96-901f-da9e160ee6ef', '2017-08-08', '2305.19', '30211934', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(150, NULL, '552912102', 1, '63bbf01d-68cc-3822-bfd7-13a459f55680', '2018-02-25', '2069.25', '37045386', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(151, NULL, '383618580', 1, 'a8a8ef07-d72a-32fd-b42d-3e7bb35fc448', '2018-01-07', '1034.74', '27637515', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(152, NULL, '437269545', 1, '583151a5-ad73-3f3c-923f-954842793495', '2018-04-18', '1432.76', '20625030', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(153, NULL, '993553160', 1, 'e71c081b-61be-3818-b461-cfe1ed08c7ce', '2017-11-11', '2752.81', '21695622', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(154, NULL, '1254944891', 1, '663a57ef-fffa-301d-8705-762f01ae57ee', '2017-06-28', '1923.26', '25291877', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(155, NULL, '699362664', 1, '21e58707-87a4-37e9-b490-d9fab3eed513', '2018-01-19', '1522.30', '5406077', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(156, NULL, '1479251873', 1, 'fc3c11c7-961f-3130-82d7-4dddc68c272e', '2017-05-31', '2892.31', '39529609', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(157, NULL, '1435697104', 1, 'c529d86c-0877-385c-9e1c-497b9ade89fb', '2018-05-01', '1860.66', '34827845', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(158, NULL, '204200269', 1, '4ac96411-24d6-3ef0-93d1-6f6bf7206f51', '2017-11-08', '2372.94', '34223619', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(159, NULL, '1525889880', 1, 'b9cee15e-792c-3697-a2e7-e4914a414c42', '2017-12-14', '2166.50', '20200134', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(160, NULL, '112197229', 1, '99736e33-a30b-3030-8ca4-2daec33e0992', '2018-02-28', '709.69', '34434085', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(161, NULL, '1487482486', 1, '9c4d9d15-c7ff-3ffc-82b1-450e2e72d2ab', '2017-11-18', '1547.83', '47720844', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(162, NULL, '255166980', 1, '981f19bf-16e0-3a08-b47d-a63c1dfc99b2', '2017-10-31', '898.18', '1004499', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8');
INSERT INTO `assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `accepted`, `last_checkout`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `_snipeit_digitized_dynamic_success_1`, `_snipeit_universal_intangible_info_mediaries_2`, `_snipeit_up_sized_foreground_model_3`, `_snipeit_vision_oriented_coherent_implementation_4`, `_snipeit_normal_re_order_level_5`) VALUES
(163, NULL, '1254293773', 1, '3540fd7d-2d65-3c0d-aba4-35fc84b5d71b', '2017-05-17', '1897.40', '32830515', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(164, NULL, '88303066', 1, 'c1257d93-eabe-3ac1-932e-db454136aa90', '2018-04-10', '2764.22', '18221032', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(165, NULL, '450728228', 1, '3e7d45f7-8812-3cef-9278-11430230629f', '2017-12-25', '2821.28', '39017448', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(166, NULL, '1195093694', 1, 'f780c971-013e-3aa3-aa52-fc7b3a5764cf', '2018-01-30', '2507.58', '22144454', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(167, NULL, '3209607', 1, '80159f4c-8a9e-3c56-972c-8add5ba847e7', '2018-02-05', '1583.10', '1749896', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(168, NULL, '57834261', 1, 'b903f6af-0ee6-3643-aaf3-6fa13fd7cb95', '2018-01-13', '2521.21', '48373943', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(169, NULL, '768595400', 1, 'f28fc888-d155-3bc7-a8a5-6338a330babc', '2017-10-31', '2680.58', '12421814', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(170, NULL, '309856633', 1, 'a4b7d951-12a1-3c42-a162-4a05db0745e6', '2018-04-25', '2075.68', '26989914', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(171, NULL, '1259021191', 1, 'd5023110-1376-3064-918a-c9ae1eccd38f', '2018-03-20', '2277.89', '8043187', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(172, NULL, '1261753271', 1, '0556c56b-cce9-3132-8514-96608c3f48b4', '2017-07-28', '1050.43', '12207458', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(173, NULL, '193843421', 1, 'b2ff8520-a61c-31cb-849f-e9b1ee112a5d', '2018-03-17', '1481.19', '2035958', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(174, NULL, '13904709', 1, '7174e713-e2c6-345d-b83c-731543e83eb2', '2018-02-03', '2553.36', '8633169', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(175, NULL, '1048114003', 1, '1dc9c850-ab04-33e2-aee1-82a4a1fe6e39', '2017-11-25', '1300.96', '17004146', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(176, NULL, '1336552220', 1, '370a3076-7c36-3f8d-a298-fda406959939', '2017-09-24', '2366.95', '22311921', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(177, NULL, '906271027', 1, '81eeffe6-5b48-343a-8ff8-897b46d7b25f', '2017-09-11', '2892.23', '41736719', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(178, NULL, '456486980', 1, '8f4080f9-de5c-3999-a33f-6d5976076bf7', '2017-10-23', '1434.13', '26437841', 8, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(179, NULL, '487493194', 1, '9b8a83e1-0dde-326f-9017-eb5d48c59820', '2017-08-02', '326.29', '44872441', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(180, NULL, '903748135', 1, 'db2f8e1b-5f14-3bc7-bdf4-71c1e07f7008', '2017-07-03', '1689.60', '49845241', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(181, NULL, '174471575', 1, 'e3a81a15-acce-3aed-86f5-2fa75e7496a2', '2017-12-25', '2767.72', '20559413', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(182, NULL, '1340348906', 1, '1ab627b7-bfcc-36db-8417-6538d1221857', '2017-11-16', '2622.55', '34128738', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(183, NULL, '350157734', 1, 'fbd3fa30-14af-38ef-92c2-4f49234420d3', '2017-09-22', '1580.14', '40377838', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(184, NULL, '426666593', 1, 'a8e3ef82-b9f0-390b-8069-c4e1d0a2e129', '2018-04-09', '404.36', '48307819', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(185, NULL, '764030748', 1, 'aabc757e-4530-3326-b19e-e1553e626f95', '2017-08-12', '429.35', '36087594', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(186, NULL, '928970037', 1, 'd83fbe7a-442d-35af-8aed-e2855294ca85', '2017-09-08', '934.33', '19121629', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(187, NULL, '364567469', 1, 'af5b18a9-e7fb-3f2c-9f1b-017a1fcb335e', '2017-08-17', '1844.15', '30925452', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(188, NULL, '656247442', 1, '09ba0d60-d804-3289-94b7-185f50b7229c', '2017-07-26', '2760.15', '34678576', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(189, NULL, '1017410054', 1, 'e935241f-4ef2-39f1-be03-2c5bfbc408c3', '2017-08-12', '1530.92', '45016504', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(190, NULL, '494019704', 1, '274718bd-f060-3473-b984-f71693fa1846', '2017-12-15', '2237.77', '2356835', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(191, NULL, '222792863', 1, 'e024be28-536f-34cc-b994-c5468ea34149', '2017-11-30', '2605.99', '41744864', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(192, NULL, '640121049', 1, 'c36cce30-bf53-3955-bee1-c1a0356f475e', '2017-06-23', '829.42', '23743704', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(193, NULL, '450312151', 1, '151fcc97-74e8-3a1c-9b18-9aaf30189eee', '2018-01-02', '981.95', '36335510', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(194, NULL, '900773768', 1, 'a5907a43-474d-310d-bef9-fb5e965659ee', '2017-10-04', '1789.34', '26586812', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(195, NULL, '8496102', 1, 'd0766f2c-4989-32f9-887b-bf7b5495e951', '2017-05-17', '728.95', '6296492', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(196, NULL, '976716720', 1, '1ff2c15c-7236-3c6b-917a-b59133383893', '2017-10-13', '2311.38', '31179052', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(197, NULL, '195703629', 1, 'ce849b9c-8cc6-3a6c-b4e3-653ed00e8bc7', '2017-07-07', '1809.18', '6022070', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(198, NULL, '1325149513', 1, '3c786c8b-8ed7-38a5-9a71-f571feab61f5', '2018-03-31', '2298.21', '6442141', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(199, NULL, '1313855971', 1, '0892e8a9-a806-3a2c-89ad-419b0dc8aff3', '2017-09-03', '762.32', '39319352', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(200, NULL, '1374349101', 1, '52e86be6-5115-3c8b-b89f-b565f7bcdbbe', '2017-08-07', '1002.98', '47431754', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(201, NULL, '1391433068', 1, '04cff292-3617-3c8c-b84e-017521abd816', '2017-12-12', '1744.69', '45830182', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(202, NULL, '534768029', 1, '05009a97-da3c-39f8-aa1a-95f1b1f0eb36', '2017-10-14', '1367.55', '3704542', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(203, NULL, '1195830589', 1, '7afbcd8b-39cf-38ab-8006-a6d44f299a5e', '2017-07-29', '2184.32', '49880963', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(204, NULL, '1402045831', 1, 'b018d11f-7fb8-37c6-b230-2015eee7dcbf', '2017-08-09', '1161.91', '27942651', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(205, NULL, '940195914', 1, 'a697f097-71eb-3714-98a9-e5ab1b5425b5', '2017-06-07', '2648.73', '40764355', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(206, NULL, '848953779', 1, '6e0d9361-b14e-324e-ac6c-fe2628ebc342', '2018-02-27', '1645.59', '30657996', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(207, NULL, '557417260', 1, '14baae5c-fdc0-3a62-9c3a-bd803be200e3', '2017-08-29', '1968.83', '21688965', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(208, NULL, '207555538', 1, '322f3da1-7a47-3c5d-a2f3-1728a8d29c0e', '2017-05-19', '1665.76', '36310474', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(209, NULL, '313901968', 1, '7341ccca-fdae-302f-80b2-7ab88642b017', '2017-11-21', '1006.81', '24261366', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(210, NULL, '1132636397', 1, 'a272108f-6c91-3517-9330-86d71612786f', '2018-02-21', '1140.37', '33102267', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(211, NULL, '138515667', 1, '57e81730-631a-3aff-b2f1-0ef77f799789', '2018-04-25', '745.12', '40588252', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(212, NULL, '316565409', 1, 'b265cacc-8fc5-37f1-9bc6-1be7af46f070', '2018-03-19', '2064.48', '3766703', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(213, NULL, '234724672', 1, '0cb0dceb-14c6-3ab9-8ef6-6f2fcec4c60d', '2017-12-19', '2417.77', '48563782', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(214, NULL, '1394527945', 1, 'fdf807f8-de75-3072-b5e8-a8b673c84310', '2017-08-21', '2161.28', '11894241', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(215, NULL, '794948293', 1, '92dca4d8-f0c5-344a-a425-5dc685442985', '2017-11-11', '2027.60', '48436532', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(216, NULL, '807818060', 1, '0b0a2a73-1d25-36d2-8a10-3fa465b7637d', '2017-10-04', '2340.54', '34449291', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(217, NULL, '351961292', 1, 'e7e9233e-530d-3b96-94fc-6d83d2f100f2', '2018-02-23', '2087.79', '41477111', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(218, NULL, '84419304', 1, '2d4fa497-0afe-370a-baee-fbb6cf03c9ec', '2017-07-24', '2122.24', '8066138', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(219, NULL, '224851546', 1, '4f4be99f-1332-36cb-b94e-4daf8950bed3', '2018-03-04', '818.94', '46040828', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(220, NULL, '93172527', 1, 'b1f1d059-4141-3dbf-b69d-90894688fe22', '2017-12-06', '2431.88', '35006470', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(221, NULL, '448807226', 1, 'b1a9f132-8daa-3a36-9abd-cec34ba6b40b', '2018-03-29', '962.77', '4514607', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(222, NULL, '399186061', 1, '10ec8896-b9b0-315f-a6c3-dbbec9e9fb0d', '2017-11-26', '1664.00', '41186935', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(223, NULL, '99388346', 1, '7e608d74-3c46-31db-8bb7-f470726dddd5', '2018-03-03', '1799.33', '9204455', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(224, NULL, '440037287', 1, 'dee65d19-ca43-301c-8860-c13dae747154', '2018-03-06', '360.14', '46258972', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(225, NULL, '177596425', 1, '22543f95-dbf7-3354-af2f-c06abc803c8f', '2017-06-21', '705.78', '9293537', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(226, NULL, '1135658543', 1, 'df024847-ff09-3577-97ad-b79fc0a8e7a9', '2017-10-14', '302.11', '47794432', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(227, NULL, '368152174', 1, 'e37ea4b5-3ebe-3589-846c-3b2a214bfb7c', '2017-09-13', '416.61', '1873402', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(228, NULL, '358148931', 1, 'af88ae85-5ff3-37a1-a0b2-019b9f3c6230', '2018-04-09', '2554.03', '14236298', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(229, NULL, '354381084', 1, '7f950fae-24a8-3e3d-96ab-6149cd4b1bcf', '2017-11-14', '1321.38', '34193927', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(230, NULL, '1524240832', 1, '8ea854b6-7c09-395e-8aa9-80c7920a8979', '2017-06-27', '1208.68', '44782247', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(231, NULL, '911307679', 1, '410fbd44-7d8a-3d8c-9c1b-5f7d1ba03136', '2017-09-13', '1162.19', '36819942', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(232, NULL, '1502940385', 1, 'aeb37f72-ab5e-31d0-8661-60b7422011c7', '2018-03-08', '1119.06', '29687000', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(233, NULL, '1059593597', 1, 'e89de333-57b8-3b63-b4c9-7a7502732d16', '2018-01-20', '2352.52', '47256343', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(234, NULL, '863379375', 1, 'f3d6efd5-a18f-3986-97e8-06d0df0398ce', '2017-12-29', '1769.84', '30569613', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(235, NULL, '1403769756', 1, 'c3509b7d-ba0b-3312-924c-8b5c0d8aa358', '2017-07-14', '876.14', '32002894', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(236, NULL, '47838638', 1, 'a755d275-3a27-33b3-baa1-4fe44a027cb9', '2017-08-17', '2769.58', '49973527', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(237, NULL, '1082942540', 1, '6c833115-cbf9-3972-8ec8-63ea95f06cd2', '2017-06-08', '363.85', '27877026', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(238, NULL, '71789873', 1, '507e3ac1-4443-390f-a08b-4ed2acbe58d4', '2018-02-05', '2673.91', '9174293', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(239, NULL, '1460854709', 1, 'ec67fea4-ca6a-31c2-bbe7-057317a4b303', '2017-12-24', '1543.95', '21996430', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(240, NULL, '189211027', 1, 'f47cfd1d-7077-3ffc-9d13-68e04bdb6569', '2018-04-16', '657.59', '23898401', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(241, NULL, '410738960', 1, 'b32bc75f-8fee-3ad6-b553-0ee89ffb009e', '2017-09-18', '1903.30', '23974840', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(242, NULL, '1213349977', 1, '660cec48-51ef-3cc1-a09c-a5fe3370b233', '2018-05-07', '1685.29', '18416417', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(243, NULL, '1516556837', 1, 'fd0c3007-9529-3f8c-9295-c163cff43db1', '2017-12-18', '2701.24', '49538863', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(244, NULL, '249399150', 1, 'e6631e3d-7b3a-3cb0-841a-d622ac40f0be', '2018-02-02', '1020.34', '8919360', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(245, NULL, '1289579821', 1, '8c28775c-b0ba-3120-91e4-a33d3d30744f', '2017-09-21', '2930.51', '42976068', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(246, NULL, '259980401', 1, '5b174925-8d00-3d31-a64e-d0e13236716c', '2017-09-28', '2110.59', '5574322', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(247, NULL, '1121252580', 1, 'ed623dd1-bcec-31bb-9d50-17d0146c354e', '2017-09-26', '2505.55', '42845931', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(248, NULL, '765036641', 1, '18c5bd69-b53c-3676-a2e7-7106beeecd45', '2017-08-13', '2144.85', '35998607', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(249, NULL, '194482380', 1, '6fc82a29-e0d8-3402-ab14-2d4bda5dc0a6', '2017-10-11', '1326.38', '26333805', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(250, NULL, '207457210', 1, 'e4e7ee1c-5904-369f-9990-ec0c69ab60f1', '2018-02-16', '1205.85', '11802431', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(251, NULL, '940463700', 1, 'ec8a745d-cfc1-326b-96b8-08b24a2850bd', '2017-06-19', '355.46', '9691827', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(252, NULL, '180395767', 1, '7608b008-8c02-37e5-b382-27d22f4ea877', '2018-03-27', '2888.52', '13172307', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(253, NULL, '274881917', 1, 'b76415b2-c17d-3860-862c-2905e3f00bc0', '2017-10-03', '2418.66', '48423639', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(254, NULL, '910023031', 1, '7ca054d4-5420-3db8-b814-17b9dc12d28d', '2018-01-16', '1376.41', '20488524', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(255, NULL, '111886165', 1, '03dd5b86-34ff-3ce8-9e89-df015746ff5c', '2018-05-03', '2247.63', '7309946', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(256, NULL, '651186680', 1, '1c9366c3-c6a5-3f1e-89c7-13810289c971', '2017-11-02', '1214.02', '1344695', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(257, NULL, '752088881', 1, '7146b68a-0d8e-329a-8ccc-149a1e64241a', '2018-02-01', '2374.11', '39677901', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-17 07:05:26', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, 'pending', '2018-05-17 10:05:26', NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(258, NULL, '346064548', 1, '8bdeacd5-3713-3f2d-8168-0732cac3f369', '2017-11-30', '2368.58', '21749621', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(259, NULL, '721758504', 1, '3e5a5e83-f924-3101-a92a-3d34b5ad6865', '2017-10-25', '1313.17', '15246937', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:22', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(260, NULL, '1265396569', 1, 'fca84348-13e6-3f34-8877-9bf4607fd789', '2018-05-14', '2948.06', '31127899', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(261, NULL, '1391303902', 1, '3800d4ac-b48c-3f0a-b332-79f4b020504e', '2017-06-21', '497.57', '1645280', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(262, NULL, '56046121', 1, 'e63c623d-ee51-30be-8ca4-bda9a5c60d31', '2017-12-11', '565.95', '14279565', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(263, NULL, '896765780', 1, 'eb4bb21a-f6f8-383b-91a6-e3c8f495c8ab', '2017-06-17', '2757.04', '37944627', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(264, NULL, '562584003', 1, '9cd6982e-6fbc-3494-8ff6-81ba5a070301', '2017-08-07', '2975.70', '26648126', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(265, NULL, '49377787', 1, '58408d9e-1b7e-3239-96ff-6e892ed8bfab', '2018-01-11', '2668.81', '47526554', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(266, NULL, '489748216', 1, '1e69e6eb-751c-309b-8bd0-de91b2d925ba', '2017-09-09', '2103.68', '7876300', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(267, NULL, '137724488', 1, '87bfd4e3-d80c-377c-b494-7d141d4b706c', '2017-06-26', '2625.90', '48420328', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(268, NULL, '1510819805', 1, '3191a578-4062-3bd6-b5ef-96decd619c35', '2018-01-08', '914.97', '31041957', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(269, NULL, '414994348', 1, 'a1c0d726-78be-3c53-9994-4bc73aed5401', '2017-08-21', '2069.68', '35765137', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(270, NULL, '104131033', 1, 'd0c6a306-1f4d-3ee4-a98f-b00e93028b9f', '2018-02-28', '1625.58', '3778810', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(271, NULL, '692197568', 1, '8ef11030-ebc6-3c6d-823d-c61e180f723a', '2017-10-04', '769.84', '15730110', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(272, NULL, '710353597', 1, '5db07ffe-304b-3217-8412-b44a28b80597', '2018-04-24', '2363.96', '35216565', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(273, NULL, '870275786', 1, '39dd3b18-aa6d-3064-8082-3f67c3caf768', '2017-05-17', '1503.74', '41464837', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:38', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(274, NULL, '404033438', 1, '077fb18c-d2c1-3389-9cc2-a94f92f5aef9', '2017-12-29', '2543.07', '17163701', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(275, NULL, '1255369983', 1, '421c46a0-9c05-3c83-942f-360d25238a2d', '2017-11-07', '1073.72', '9329843', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(276, NULL, '1445238800', 1, 'cfd68964-36a3-35f6-92d1-71cdd68ae689', '2017-11-18', '2456.26', '22867868', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(277, NULL, '65575587', 1, 'eb1baa8c-097b-3ef7-93e2-a8e61a84efc9', '2018-04-04', '1237.74', '18803472', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(278, NULL, '919384123', 1, '9db7df25-804e-3170-bef8-b10f978d75d9', '2017-05-26', '2713.77', '44284688', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(279, NULL, '1343514455', 1, '5c49f4ed-8004-3d5a-8023-1139fb532f7a', '2018-02-11', '1908.24', '12748721', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(280, NULL, '751652908', 1, '6c8d4a88-7f26-3489-b567-0fb7bdb6ff89', '2018-01-28', '2470.53', '28968358', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(281, NULL, '1362603474', 1, 'ac5ff0b0-a581-329b-8143-1496e34d81ff', '2017-08-20', '2806.86', '48727219', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(282, NULL, '55800541', 1, 'e6425c5e-f17d-329a-8fa9-606e985a575d', '2017-07-13', '1517.80', '37202565', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(283, NULL, '986387430', 1, '2a9182df-f385-3910-a62d-c09c9b354118', '2017-10-04', '1533.83', '14428715', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(284, NULL, '1252873359', 1, '98fe0e6f-daf3-3bad-9860-3916bff6d844', '2017-10-29', '1677.97', '7340940', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(285, NULL, '760507876', 1, '6ba832d1-0e42-3d24-9196-14ca5135f939', '2017-10-14', '726.42', '17276137', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(286, NULL, '445661381', 1, '1ad0865f-3561-3603-8889-709eb740e9b8', '2017-08-06', '2776.70', '49558554', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(287, NULL, '1387127399', 1, '603ec779-4dda-33aa-adce-afff4de77013', '2017-09-06', '1597.28', '27353501', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(288, NULL, '1463281245', 1, 'a3a9a135-3d8f-35c4-ae8e-6f75488203bb', '2018-04-02', '378.13', '33134863', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(289, NULL, '773826307', 1, '6468d058-696b-3bd6-8423-7d4dfc55186e', '2017-12-21', '2003.02', '47831628', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(290, NULL, '1072062580', 1, '3f99c596-a645-3ff7-8580-9e8454fb4fa5', '2017-05-16', '1147.95', '17392897', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(291, NULL, '986129029', 1, '65dae6c1-a7df-31ac-bf2b-f0e2726ca077', '2017-11-12', '2441.59', '2578738', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(292, NULL, '1462628649', 1, '42f4c317-11ba-3321-acb7-b09e7c5dfe19', '2017-05-27', '2316.13', '41161558', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(293, NULL, '168604658', 1, 'acfa488c-80fd-38c3-9666-d11901dc46f1', '2018-01-22', '1424.91', '20356835', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(294, NULL, '1109984434', 1, '1df853b1-7bfb-3ed0-87ab-5b34ffba9ecf', '2017-09-28', '1652.45', '3483254', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(295, NULL, '1242765204', 1, '6c9019b2-415f-3563-8744-047c2ec08c52', '2017-05-21', '1900.38', '48389056', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(296, NULL, '1319150767', 1, '6a940fdf-d705-381c-bf49-cf617e936478', '2017-12-15', '1304.45', '39324999', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(297, NULL, '894863327', 1, '84a2bde9-5385-346e-96cb-1209c2ae5459', '2017-08-25', '592.52', '40268177', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(298, NULL, '270781145', 1, '9412d51e-fbbe-39d5-ae22-b8df1cd16d96', '2018-04-10', '2521.21', '20514338', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(299, NULL, '485351855', 1, '249b23d1-43e7-375d-9c5a-d14a0d8b54e5', '2018-03-07', '1901.58', '17811618', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(300, NULL, '689937677', 1, '6c29b5ee-5e36-3c89-9947-fa3ebdb1e3b7', '2017-11-25', '1865.98', '4291552', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(301, NULL, '605893817', 1, '9b85b94d-3cce-3f63-a4e4-c48dba195d3e', '2017-10-21', '1591.28', '15290565', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(302, NULL, '900918816', 1, 'cf99f8dc-29d5-3272-b69f-13e9893dbd9b', '2017-10-09', '1786.18', '36056421', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(303, NULL, '86105655', 1, 'caa8c62f-6cb7-39e4-ab2b-b69ef6bbe01d', '2018-03-11', '1820.00', '41085785', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(304, NULL, '58180994', 1, '9c0f2c73-933a-327a-b611-e5bb10933b0e', '2017-07-13', '665.57', '19075413', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(305, NULL, '440535817', 1, 'cb3fea45-54d4-3361-8f59-89371e098073', '2017-07-08', '1003.90', '45683185', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(306, NULL, '174880676', 1, 'f6c7c684-0e2b-3ddb-9c4d-67fe58c0b925', '2018-02-22', '997.06', '38335894', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(307, NULL, '1025819002', 1, 'b649ea9a-edc0-39b1-8964-e97e04203a9f', '2018-03-21', '1224.33', '28143524', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(308, NULL, '691584506', 1, '691bf6dd-7bbe-3abf-b902-c27f5ebdf5d5', '2018-02-23', '2375.94', '12677301', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(309, NULL, '7115977', 1, '419270f8-70f0-3137-a1b0-d622f3c60502', '2018-01-19', '1675.72', '35686508', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(310, NULL, '1042441860', 1, 'f98b162e-0712-3521-a84d-1c95b1f4c882', '2018-01-19', '1141.84', '20858551', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(311, NULL, '343605166', 1, '229dcaaf-4469-3d01-92ae-e0386b4eb4fe', '2018-01-25', '1183.54', '13190853', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(312, NULL, '1010411598', 1, '932f806d-b658-3222-a86c-91dac2bb3482', '2018-02-20', '1767.05', '1828485', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(313, NULL, '1114195368', 1, 'a00d6615-5724-34b4-ac54-1ff3bfcf46ef', '2017-07-17', '2943.90', '33193174', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(314, NULL, '372391324', 1, '11460c70-d7ee-3d1e-b218-468ad6a6bc65', '2017-06-16', '2061.25', '39234764', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(315, NULL, '431906924', 1, '5a4a6559-14e0-3f1d-acda-9dc7c2c1c391', '2017-06-30', '1931.70', '15592453', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(316, NULL, '727974248', 1, '61104dfc-ddda-3c4f-86be-0f5145082657', '2017-09-12', '864.96', '25878869', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(317, NULL, '4359613', 1, '1a0d39d8-5338-3e21-9367-ac8b8790e4df', '2017-11-22', '2466.85', '43152021', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(318, NULL, '894487727', 1, '29524536-b1ba-386e-83de-3018e5b5104a', '2017-09-24', '640.93', '34656324', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(319, NULL, '360669095', 1, '61e5c316-ea99-3c07-b026-06c91bf1baf6', '2018-04-15', '2548.11', '29030060', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(320, NULL, '772602625', 1, '9fe24c85-c01b-3115-8e08-4821397608f7', '2017-12-02', '1867.94', '17564437', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(321, NULL, '1366021337', 1, '392aff12-a43a-3dcc-a22c-def42393f9ec', '2017-08-06', '1641.47', '20405979', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(322, NULL, '1388632953', 1, '73574eb4-7e24-39d1-a58c-b228d6facc99', '2018-05-03', '840.33', '36558584', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(323, NULL, '1231486196', 1, '84a08c01-568e-391e-a157-e5c36875b0a0', '2018-04-16', '2494.84', '3499518', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(324, NULL, '1223672241', 1, 'e6c17d6b-fa7a-3e34-a124-6b3b9f00cf36', '2018-01-11', '2283.50', '4360754', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8');
INSERT INTO `assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `accepted`, `last_checkout`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `_snipeit_digitized_dynamic_success_1`, `_snipeit_universal_intangible_info_mediaries_2`, `_snipeit_up_sized_foreground_model_3`, `_snipeit_vision_oriented_coherent_implementation_4`, `_snipeit_normal_re_order_level_5`) VALUES
(325, NULL, '853815609', 1, 'c5d50199-f689-37b4-8d03-0f580f5c689d', '2017-07-20', '2464.65', '10913057', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(326, NULL, '1074001014', 1, 'fb619810-9f86-3149-a05f-547421d3090c', '2017-07-20', '1008.95', '9768554', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(327, NULL, '246621280', 1, 'dabfc5ea-7872-3532-b23f-07a0e377cf06', '2017-12-17', '534.35', '12932991', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(328, NULL, '790050821', 1, '013ba697-e8d7-3b55-820c-6440b7d19d48', '2017-05-19', '1995.07', '30469842', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(329, NULL, '1472043270', 1, '940867ad-c22e-3155-a7d0-9f9d13c18efa', '2018-01-31', '1120.03', '5145162', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(330, NULL, '1096628420', 1, '5de2b01b-cdbf-3e37-81ae-cc6d0694a9d4', '2017-05-21', '2665.53', '39412648', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(331, NULL, '461142309', 1, 'cc388e6e-9a05-3d55-b178-d156670a03a4', '2017-09-12', '875.55', '49316778', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(332, NULL, '1110595231', 1, 'f847e0bc-2e47-3885-9ffc-f213a9deea94', '2018-01-02', '1146.12', '18082434', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(333, NULL, '506360428', 1, '31fc6f96-0e97-328b-a8a2-34319ebc82b1', '2017-06-03', '1613.21', '9974753', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(334, NULL, '725878540', 1, 'eb0113d7-4776-32c2-a0eb-af2000e05e29', '2018-03-02', '1086.37', '25769675', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(335, NULL, '936357563', 1, 'e43115a4-e01e-32d6-aa1c-f32ea8daf732', '2018-04-04', '2007.06', '8876303', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(336, NULL, '1378489905', 1, '18c73794-dd34-35e6-96fe-d723c570c4ac', '2017-07-14', '2808.18', '22334243', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(337, NULL, '1268779673', 1, '879b4d23-c2d7-3586-97fd-c42395c2479a', '2017-08-02', '1286.58', '18895443', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(338, NULL, '1346922255', 1, 'd65c8d09-e350-3394-8a55-e7a7b1fe26b0', '2017-05-31', '857.04', '45350397', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(339, NULL, '744281711', 1, '09341847-8657-3bb8-b5fa-e140a51b26dd', '2018-01-26', '601.78', '26062115', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(340, NULL, '239971190', 1, '62366717-0b39-3da6-881c-232b0112bbbe', '2017-06-06', '950.78', '34197985', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(341, NULL, '143461145', 1, '71a4627b-70d6-3566-bcd8-2d477da9a3b1', '2017-12-03', '2814.57', '10378059', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(342, NULL, '563499581', 1, '81d6e55b-af7f-3285-9c5a-191564d072d2', '2018-01-13', '2075.63', '2412592', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(343, NULL, '1350610259', 1, '154e6e74-a62d-3b66-afe7-8fe663fdde81', '2017-12-22', '601.98', '32638890', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(344, NULL, '593160740', 1, 'f1b95861-d526-3927-a10e-33485f9da574', '2017-08-14', '2996.04', '11249458', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(345, NULL, '1489181103', 1, '718acced-460a-3b7d-ab00-8ef28b859e11', '2018-05-11', '559.47', '14756308', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(346, NULL, '1435801664', 1, '1d62fded-9a9e-3fd8-a4b8-43a3e5293622', '2017-08-13', '470.10', '13144846', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(347, NULL, '337201920', 1, 'a248423e-bb22-3aa5-b6f5-72bd302169d1', '2017-06-15', '2638.35', '16893068', 9, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(348, NULL, '1022210381', 1, '19d44b2e-6f4c-357d-821f-18a61f166851', '2017-11-21', '964.46', '49583723', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(349, NULL, '302674297', 1, '5a07c458-25ed-3ace-a6ff-e04f9c816107', '2017-07-22', '2158.28', '6816233', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(350, NULL, '1500729165', 1, '145f7543-395d-3ba8-aad2-cf01b621d1d9', '2017-09-11', '2721.04', '14091246', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(351, NULL, '723434918', 1, '56fec3be-daeb-3bb0-a8ba-db74e4156a49', '2017-11-19', '477.51', '2262884', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(352, NULL, '925563983', 1, '6fd06e9d-edaf-3f62-86dc-00b7f29f6723', '2017-12-25', '2572.20', '31564823', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(353, NULL, '94712566', 1, '04516317-28da-33ea-ae1d-416782775d4d', '2017-08-08', '1434.61', '3634312', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(354, NULL, '671653054', 1, 'b3c9e619-b3f5-39ec-8712-aa08dfacfc88', '2017-08-23', '2832.75', '36970675', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(355, NULL, '999000503', 1, '95cc0b0a-aef7-33bf-bae7-6f230d2ddb70', '2018-01-03', '2927.99', '9852443', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(356, NULL, '1209900865', 1, 'd444637c-1ae5-340f-81ae-a70fdf799884', '2017-08-20', '384.11', '45150752', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(357, NULL, '1064491916', 1, '82be689b-e99e-3037-87c7-a582fd107ad7', '2017-06-02', '376.23', '7197630', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(358, NULL, '438829550', 1, '6c15e234-ba0a-30bd-8d70-11e5c3c5fe01', '2017-12-06', '714.16', '8941972', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(359, NULL, '30396740', 1, 'b060b42d-9225-3df4-a142-e24ff791ce43', '2017-08-01', '352.43', '37735049', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(360, NULL, '735078616', 1, '5cecb119-f263-38ed-9adb-07523be3a1cd', '2017-09-29', '2187.59', '32293161', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(361, NULL, '13506203', 1, 'e3a46ab6-8377-36c4-b276-6e95ab71cbe7', '2018-01-16', '517.26', '4680754', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(362, NULL, '292866637', 1, 'c9cc7afd-2e36-3998-a953-ed325d99f1f9', '2017-09-29', '1043.44', '8008348', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(363, NULL, '1324319654', 1, 'd09c2f48-cf2b-3458-9749-9df34404cb1b', '2017-06-13', '2200.80', '19141621', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(364, NULL, '453183183', 1, '76d7fa9f-55f8-35b8-9d7a-f76aba7baf5e', '2017-09-26', '2211.71', '23195722', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(365, NULL, '253359887', 1, 'b6be24d1-44f7-360f-aaee-d469d8d9a5c2', '2017-07-17', '360.56', '42490389', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(366, NULL, '100876275', 1, '98072d30-d4fc-3393-8480-c6ffd29b5e85', '2018-01-06', '495.21', '4751787', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(367, NULL, '748523837', 1, 'cf1393fb-c92e-3fdb-a182-b837173ab012', '2017-09-30', '1620.00', '34575392', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(368, NULL, '313252775', 1, '54a63723-6de5-3e6e-8c9c-acfa68593783', '2017-07-08', '632.83', '24008979', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(369, NULL, '225224223', 1, '82f21d21-9f02-37cd-9831-7290fe43b249', '2018-02-01', '1924.80', '26354042', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(370, NULL, '712184051', 1, '1ae34968-4c81-3089-a9ab-5990fd4702ed', '2017-07-09', '1464.44', '35453717', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(371, NULL, '136061115', 1, 'e90cb741-0a4c-31c3-bc56-d415bec592a6', '2018-04-11', '809.23', '18157606', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(372, NULL, '1359499002', 1, '54ca39ed-c6b1-3164-9509-b2a80a2a2a9d', '2017-09-20', '559.74', '24391310', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(373, NULL, '148366757', 1, 'f5618816-c444-38d9-9258-43552554d15a', '2017-11-09', '1707.11', '17208056', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(374, NULL, '553788454', 1, '67531c02-869e-3b8e-8ceb-3b1a330afab4', '2018-01-02', '1853.14', '3216734', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(375, NULL, '661374051', 1, '42d7fdc9-4250-323b-906e-4393237026db', '2017-06-17', '591.18', '24197692', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(376, NULL, '1490105251', 1, 'c0a12b18-2d02-3ab0-82bb-23b3f36cd4a5', '2017-07-06', '2640.67', '7547733', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(377, NULL, '323906031', 1, 'cb19ad05-273b-3234-82f2-eb071001184f', '2017-07-26', '2459.13', '12640630', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(378, NULL, '683140282', 1, 'cff56712-e8b9-37cd-b9da-606f434089ee', '2017-08-28', '2931.25', '15496096', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(379, NULL, '1340665838', 1, '1664bf9d-ed28-31b1-9f51-979bd69433fc', '2018-04-22', '1442.36', '47871910', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(380, NULL, '1097955545', 1, '87c1d88e-2841-399e-a22d-1a2f203f74a4', '2017-11-06', '2053.04', '18596515', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(381, NULL, '840971989', 1, 'c4ccf602-4ad2-3bae-8743-b2886231e637', '2017-07-21', '498.33', '34973973', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(382, NULL, '907275773', 1, '62b64a94-2af4-3bfe-b453-47f436d6bf35', '2018-05-13', '2669.14', '49819670', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(383, NULL, '298133447', 1, 'c518957e-b0a9-375e-92b6-5ed9a73d11cb', '2017-11-24', '1494.87', '27235803', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(384, NULL, '688042512', 1, 'ef71c050-001d-32a6-88cc-9da6bf42df2d', '2017-11-09', '1445.09', '17905535', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(385, NULL, '535502341', 1, 'd3b38083-3c3d-323b-89d9-488bacc14cd0', '2017-08-31', '2020.86', '14639726', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(386, NULL, '774967804', 1, '8151d3d4-712b-3a6c-888b-22cc6face082', '2017-11-22', '2866.97', '9840570', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:23', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(387, NULL, '509648564', 1, 'bdc131c3-9cd6-3cbc-b60d-09889a2d0e7b', '2017-09-01', '2117.16', '21413542', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(388, NULL, '593185161', 1, 'f7c265c5-3b4e-3682-9a8a-19420e83ec83', '2017-05-21', '2065.99', '10313260', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(389, NULL, '1266328665', 1, 'e407f9fb-e6b0-3d31-a2b1-d654be90614f', '2018-05-12', '1423.33', '30467293', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(390, NULL, '1012940078', 1, '54f15fba-41d5-3f46-8fab-7c59c761c6d2', '2018-03-22', '2610.06', '45310358', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(391, NULL, '1377013172', 1, 'e1e95bc5-aa44-3151-bba2-1fb9cbf78d56', '2018-02-14', '2712.17', '39308483', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(392, NULL, '155456688', 1, 'd3004cfe-5fdf-32ae-be50-df3a406cbbb3', '2018-03-27', '2151.14', '41766443', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(393, NULL, '194835095', 1, 'ec199d80-7d79-30d1-bed2-1891b0802f13', '2017-09-03', '459.91', '30944332', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(394, NULL, '779556169', 1, '3268aa87-901f-3843-bae6-9eb4ceb02c7c', '2018-05-11', '2550.53', '37737032', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(395, NULL, '1469397858', 1, 'be6ec726-0644-33d2-a741-3f2eed6a92d6', '2018-02-21', '2099.32', '11829093', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(396, NULL, '262223155', 1, 'c88be966-0acf-3f0d-ac59-d0469ec31807', '2017-10-14', '1693.59', '16165331', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(397, NULL, '345713084', 1, '56c09c18-a8d0-3f65-9917-402d0bfc1670', '2018-02-24', '2804.96', '22794553', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(398, NULL, '272570191', 1, '1c24d7a8-fcbc-3fb9-93cf-ac31c2457146', '2017-05-30', '2791.70', '10774748', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(399, NULL, '449068275', 1, '7a1291c4-2b0c-3231-af95-1f911a188a24', '2017-11-05', '1407.84', '19346625', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(400, NULL, '1279932567', 1, '82a8658e-e66f-3a77-b0e7-275d29e2022b', '2018-04-10', '1652.11', '20281288', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(401, NULL, '896112613', 1, '41762a75-8649-3960-9884-4c6bd2af5bd4', '2017-08-04', '1955.42', '10380827', 8, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(402, NULL, '145691641', 1, '98218345-47f9-37db-929f-6994fd95ed85', '2018-02-04', '848.57', '13766236', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(403, NULL, '698668581', 1, '024361c7-2839-3362-bbe5-bd919d833dc3', '2018-04-16', '1958.04', '27572549', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(404, NULL, '676579482', 1, '0c9bde6b-8ffe-3469-9aeb-363824a8a663', '2018-01-16', '2527.11', '3743337', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(405, NULL, '678418507', 1, 'd6b414bf-01be-3b6e-ab2e-db5fe9f5ec1c', '2017-08-15', '1080.21', '26713916', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(406, NULL, '1421613854', 1, '9788d65e-8df6-39d5-8a5f-5b7f2c258ed9', '2017-12-25', '1847.20', '35258617', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(407, NULL, '243251431', 1, '8989c15e-fd84-3339-98ef-b36af790b60b', '2017-06-24', '2430.84', '7635425', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(408, NULL, '88585630', 1, '8877dea7-0e69-38a4-905b-9362ca4246c6', '2018-05-10', '1333.96', '13692338', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(409, NULL, '1269848163', 1, 'fb166ca5-1b32-37d4-9bda-4f1b9056ac3a', '2017-11-12', '443.04', '19369194', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(410, NULL, '1299811648', 1, 'd02e9e66-41d3-3949-a780-aca62a94625a', '2017-07-27', '491.99', '22822256', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(411, NULL, '1439486032', 1, 'cfb0842f-43cf-3e8e-9e95-cdd262b43c1b', '2017-08-25', '2740.60', '36546981', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(412, NULL, '915022757', 1, 'b679d7ce-3706-3443-beb6-5da281f06b35', '2017-08-25', '889.60', '44890448', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(413, NULL, '409762814', 1, '214c8df7-5f4c-3eba-8f29-7f17fba5f9c6', '2018-02-10', '2357.63', '41612896', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(414, NULL, '553689644', 1, '7e9ef47a-15a6-3c22-b30e-50e69abc3a57', '2017-11-05', '1960.89', '27973392', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(415, NULL, '1333455161', 1, 'de7432e0-64b8-3a20-9f32-5d88ab9e427d', '2017-07-30', '1818.27', '41053357', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(416, NULL, '1196134718', 1, 'e38f007c-3442-36e4-8d39-c09c610d842b', '2017-11-01', '2734.29', '19252277', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(417, NULL, '570454268', 1, 'e869b1f2-d394-3584-a9df-182e99000718', '2017-12-10', '2304.79', '20283904', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(418, NULL, '189820799', 1, 'dc393b00-1d3c-3774-a17f-f1f7a8d506c2', '2017-08-28', '1050.71', '48653592', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(419, NULL, '715771063', 1, '5fb4a7f8-e4f7-3cb9-a440-310bbb4ec0cc', '2018-05-14', '846.74', '43084445', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(420, NULL, '678420376', 1, '03a9a116-b6cb-3be3-a792-9366f8e36c31', '2017-11-19', '1684.36', '4996284', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(421, NULL, '981458149', 1, '738acc4a-19c0-3017-b1eb-cb8a26825b49', '2018-03-31', '1253.30', '14791856', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(422, NULL, '535402790', 1, 'c46ff042-624c-300f-bf62-3ce57a091c1a', '2017-06-16', '1778.93', '32036068', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(423, NULL, '1032182448', 1, '0b5974f6-d20c-3cf2-b690-2047cf64163e', '2018-03-05', '2845.51', '34373708', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(424, NULL, '843462159', 1, 'e78ed8c9-eda2-3f31-8cfd-6ed1095e231b', '2017-10-20', '310.71', '32122445', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(425, NULL, '142435838', 1, '59e32049-be7b-3e9f-9a64-8fa812fe7cbd', '2017-10-09', '2046.73', '17151093', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(426, NULL, '120929149', 1, 'e6e4e8fe-602d-3b5c-8fb0-5792f8b7f0c6', '2017-07-30', '1560.39', '38597344', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(427, NULL, '569140382', 1, '6bc5ac40-df2b-3b0f-8671-cbce8121cb32', '2018-03-03', '426.35', '31488904', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(428, NULL, '112989132', 1, 'c39823b3-7656-3754-99f1-65404b47d41e', '2018-02-16', '2228.60', '24301154', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(429, NULL, '1372826136', 1, 'ce0a0c14-e227-31c2-b8ec-bf74b9236916', '2018-04-17', '1030.15', '38506741', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(430, NULL, '1338325310', 1, 'a58d30a9-4220-3a0f-aae4-8e079224b813', '2017-07-21', '2579.16', '28130870', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(431, NULL, '251455456', 1, '1b0f4b64-b2da-3fea-9475-12ad559c9b65', '2017-05-26', '2000.04', '44586022', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(432, NULL, '766246007', 1, '60dea566-96de-3860-8cb9-61ed698646c0', '2017-10-01', '1774.91', '15237162', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(433, NULL, '595388673', 1, 'f03cd08d-bebd-3fb9-b0a8-04b72e07f1c2', '2017-12-21', '1631.58', '27292818', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(434, NULL, '17780167', 1, '582d8e69-e9f1-3843-9c71-35ef40b2043e', '2017-06-01', '2846.49', '30102943', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(435, NULL, '511442718', 1, '1efd480d-b327-378c-9b1b-7efaf585c877', '2017-11-19', '419.78', '45720127', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(436, NULL, '1129498799', 1, '8f3fe2a5-0d5a-3f5d-8490-aa8eb9bffe8c', '2017-08-18', '2554.09', '31807341', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(437, NULL, '1002935353', 1, '1c353d62-dd92-389e-a7f4-876a6c967091', '2017-07-29', '2625.75', '39764140', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(438, NULL, '841691032', 1, 'e453c73a-0810-3286-bf89-be01522ebffd', '2017-05-22', '1699.97', '4928260', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(439, NULL, '363235104', 1, 'ae2be7bf-93d1-3e67-bc31-07ed7359ff69', '2018-03-03', '1675.53', '23325620', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(440, NULL, '491092103', 1, '11cc451d-88ea-3575-97d1-a69324d79f7f', '2017-10-01', '1219.47', '49827426', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(441, NULL, '1221812405', 1, 'bb9b1470-303c-3b6c-8684-e74563fa0fcc', '2017-06-28', '2325.64', '16427539', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(442, NULL, '239108337', 1, '188e9464-f2a4-37fa-9093-0dcc9d6a4a38', '2018-01-13', '1319.94', '35233126', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(443, NULL, '943290590', 1, '3be218e1-1e8e-3131-9449-4f4ed62a9b82', '2017-09-08', '2365.54', '25178349', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(444, NULL, '354984469', 1, '7ed6b189-2d5d-3da4-87ce-4fb8db24d4b4', '2017-10-24', '2976.49', '36122545', 9, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(445, NULL, '536068070', 1, 'dd9797e5-2bf3-332b-ab8e-b4a85a8505f9', '2017-11-30', '459.70', '2648827', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(446, NULL, '985173348', 1, '84ea32ed-6bf9-3871-a6e4-f5e63578df08', '2017-09-01', '2626.45', '46053312', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(447, NULL, '221004405', 1, '7300f1e0-98b4-3fcc-b19f-3fd269d70be3', '2018-02-26', '2697.16', '49527765', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(448, NULL, '47493974', 1, '01e0c6bf-e339-3b3d-aa1f-289f1a238cb1', '2017-10-23', '932.10', '33958882', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(449, NULL, '1044268505', 1, 'c81c2668-5736-3eb0-a497-674ec58872e9', '2018-03-20', '927.74', '32907979', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(450, NULL, '1017352950', 1, '3dc44a77-9520-34f2-8c97-5ed76ce74254', '2018-01-08', '1716.19', '18652644', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(451, NULL, '700058177', 1, 'e776504f-0c87-34a9-9461-d71a5206044e', '2017-10-01', '1013.76', '38873982', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(452, NULL, '143064123', 1, '92082cff-954c-3ad0-a0cd-7de4dccc248f', '2017-09-21', '2195.30', '48328347', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(453, NULL, '859038267', 1, '03a78694-6e8a-34e2-913b-6eca9e49ec0d', '2018-01-04', '1603.29', '37661738', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(454, NULL, '59347412', 1, '7d8810bc-02c1-3494-93ef-a0e2015a0211', '2018-02-25', '703.72', '30371216', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(455, NULL, '870067197', 1, 'aac8331a-b85b-30ad-8bac-aec38a8b3ee3', '2018-02-16', '2462.56', '27057196', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(456, NULL, '253431807', 1, 'f9c9c578-9853-312d-b70d-0bb95072e82a', '2018-03-13', '840.63', '20652812', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(457, NULL, '437196850', 1, '488fb6f5-f3aa-3a67-9b81-ab6ee777e82e', '2017-05-30', '1137.66', '1011623', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(458, NULL, '544390767', 1, 'bd2c18e3-c373-375a-9b9c-faf63f7dcb6b', '2018-04-22', '416.83', '9841175', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(459, NULL, '383505504', 1, 'a9bbeb4d-60ee-3dfc-94bb-95d148bc3e4b', '2017-10-08', '448.33', '4776868', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(460, NULL, '1176379632', 1, '488d4423-e157-37a0-9cec-645be50783b7', '2018-04-23', '1382.29', '7786769', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(461, NULL, '685463514', 1, 'f66c8344-a6eb-3460-b3e6-139453865dee', '2018-01-13', '837.63', '42444928', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(462, NULL, '1387059082', 1, '1f7335bf-33d5-32ce-ac37-5ed093c4c1bd', '2018-03-12', '932.98', '9002605', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(463, NULL, '750272453', 1, '3fe876c2-6886-36c7-84a4-27568f0d3c6b', '2017-08-30', '673.64', '23543495', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(464, NULL, '1323900465', 1, '47932b61-7043-3a17-a725-f119baeb2a00', '2018-04-29', '1078.02', '37514674', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(465, NULL, '856778735', 1, '3d6a5859-f7ed-3b1d-a7e2-08bf0324edfa', '2017-05-21', '493.97', '5837428', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(466, NULL, '319641861', 1, '6cc2a514-90ec-3af2-8a26-3afa8b128252', '2017-08-21', '2597.47', '42392065', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(467, NULL, '598382911', 1, '4c6498a5-ffb3-39ac-9117-37104a6bd313', '2017-07-04', '2896.34', '21261815', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(468, NULL, '1492829859', 1, 'f0919fd4-5572-3fa5-bf8d-b80b1505c2cd', '2018-03-07', '1836.29', '25626885', 9, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(469, NULL, '1398077848', 1, '74a2dfee-96cf-37a2-84e7-a2030cd8b9a4', '2018-02-17', '1876.88', '24792529', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(470, NULL, '15391357', 1, 'd8ba2d0a-e0a6-31fc-a1e1-6c5153207309', '2018-03-25', '1771.14', '47045746', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(471, NULL, '1416771669', 1, 'c67fc72e-949a-3c4a-a771-a0649ce57537', '2017-06-30', '2970.37', '42615911', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(472, NULL, '61918221', 1, 'efc57f2f-5bd8-31ed-ac56-6297fef2fcac', '2017-10-01', '1517.40', '35439617', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(473, NULL, '1243529551', 1, '672f6d26-b61b-340c-9a24-e2a16aae0f4d', '2017-08-31', '2062.81', '16860690', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(474, NULL, '1118853990', 1, 'c9641532-ca4d-36d4-9fe0-9f7aed939246', '2018-04-22', '1114.61', '37111471', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(475, NULL, '473947811', 1, 'af3f4c97-9a4e-3a27-bc79-945b4e45d790', '2017-07-30', '1202.11', '7195108', 8, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(476, NULL, '869032039', 1, 'b648322c-ab5b-3c8b-9402-0a80fc3aab14', '2017-07-25', '406.28', '8579596', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(477, NULL, '543884990', 1, '4d22e9b1-767e-3cea-afa3-ca5b737303fb', '2018-04-22', '1987.47', '32715840', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(478, NULL, '991878813', 1, 'a771c80e-1ca4-34db-937b-cd143cb0d8dc', '2018-04-30', '654.73', '38263216', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(479, NULL, '380637365', 1, 'a55d7879-d57c-39a2-b754-93bbb7961623', '2017-11-06', '1497.48', '7691018', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(480, NULL, '145097222', 1, 'f9ce9d30-6486-38ec-b5dd-751540b69ea6', '2018-03-04', '1615.69', '10891984', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(481, NULL, '1262771630', 1, '0b8d71ca-1a49-3c69-9bfa-d125134eddb5', '2018-02-15', '1663.28', '12636219', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(482, NULL, '26627563', 1, '75897856-1b45-3936-87d2-dc071ac2a8ea', '2018-01-27', '2789.74', '19595262', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(483, NULL, '58940736', 1, 'd6e0def7-3bd5-3b0d-99b1-e4abf0d6fe02', '2017-09-17', '2283.55', '1139247', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(484, NULL, '982488026', 1, 'd5950efa-6842-3211-849b-7210805c865d', '2018-01-30', '301.69', '44398052', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(485, NULL, '201628504', 1, '413d6a7b-ac86-31fb-98fa-0faf6603e89d', '2017-10-15', '1308.21', '29579637', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(486, NULL, '666122298', 1, '036c19aa-3bc2-3a4b-8d65-2f37e7bda05f', '2017-11-17', '1847.10', '17984318', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8');
INSERT INTO `assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `accepted`, `last_checkout`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `_snipeit_digitized_dynamic_success_1`, `_snipeit_universal_intangible_info_mediaries_2`, `_snipeit_up_sized_foreground_model_3`, `_snipeit_vision_oriented_coherent_implementation_4`, `_snipeit_normal_re_order_level_5`) VALUES
(487, NULL, '146523273', 1, '945dc09b-b906-3355-83b0-99ed12f4f534', '2018-03-03', '2399.41', '19813129', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(488, NULL, '204852304', 1, '2298bf78-397c-362c-8fbd-d9fcab253353', '2018-03-21', '1169.32', '39740148', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(489, NULL, '824287521', 1, '3b938222-c1fa-3881-81a9-2d796ad14153', '2017-09-01', '1010.23', '22029196', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(490, NULL, '815241538', 1, '37dddaf3-f9b9-3ea1-8e57-74b05882aa5e', '2017-11-19', '1050.59', '11780655', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(491, NULL, '1150584140', 1, '1c7ee77b-c4eb-3930-827e-f66e6b12133b', '2018-04-13', '544.62', '10604413', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(492, NULL, '1175730722', 1, '51144693-ed01-3ebb-acb2-d296079a4ebb', '2018-05-14', '568.60', '24223635', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(493, NULL, '1277341443', 1, '9c05aa5c-d194-3d40-8c54-0671d058800d', '2017-08-29', '961.33', '3724260', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(494, NULL, '1480366104', 1, 'c4b191b6-9160-3e17-bd23-c44994f1f48f', '2017-11-03', '1085.26', '21145858', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(495, NULL, '1468832717', 1, '28fa2282-361e-3c57-924a-a9973dd881d3', '2018-03-09', '1131.38', '38707178', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(496, NULL, '1428927449', 1, '3d25c8da-5c6d-38a4-9faa-2b6298fb5f3d', '2018-04-24', '1772.11', '6575610', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(497, NULL, '810978254', 1, '5e644d0a-87f6-3305-b4f7-54cd6530690f', '2017-08-06', '2620.56', '2781726', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(498, NULL, '689681173', 1, '78645759-9757-3a41-8630-3bb28b619335', '2018-01-30', '2442.11', '12116116', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(499, NULL, '711690908', 1, '5d246d66-9790-3d97-a445-872a5bc108cd', '2018-04-11', '380.66', '42923908', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(500, NULL, '1308785438', 1, '18546dad-679d-3498-9629-3c78fa5c7fc9', '2017-10-23', '1310.99', '47813159', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(501, NULL, '1358098769', 1, '3cfc76fe-e0dc-358b-8301-c5b65d6fed88', '2018-04-19', '1992.68', '47856728', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(502, NULL, '1256004551', 1, '9b92d6da-a1dc-3a84-98ce-20e36a95aead', '2017-09-11', '1769.53', '32667657', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(503, NULL, '1217831423', 1, 'f15337eb-071b-3171-a0e6-5f2681657bdf', '2018-03-15', '1542.11', '4244970', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(504, NULL, '429280582', 1, '26d0f4ea-0f4d-3077-9dc8-17aa7d1a8aa7', '2017-07-17', '2444.78', '41403807', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(505, NULL, '599120389', 1, 'e66bc2b4-8b05-3448-a80f-7dac7264238c', '2017-07-08', '1501.61', '17376137', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(506, NULL, '81996396', 1, '6a32939f-5099-34b2-963d-bcf9fefa0b12', '2017-07-14', '1996.05', '5063658', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(507, NULL, '1505146568', 1, '8804d165-18cc-301c-97bf-ce2529507dc1', '2018-04-16', '1839.30', '20435839', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:24', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(508, NULL, '553488247', 1, 'fba4ae49-94be-3b44-8990-2cac21620588', '2017-06-05', '2598.22', '23789510', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(509, NULL, '1055695010', 1, '79c23640-5727-3360-bd1a-e42388415c2d', '2017-05-21', '870.11', '40911855', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(510, NULL, '518771384', 1, '65aff04e-4529-3dd3-8ac9-c3c49f922777', '2018-01-09', '1777.65', '44992408', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(511, NULL, '100318226', 1, '37d3ac00-0853-3d53-a5a8-7944c1086604', '2017-10-14', '2896.01', '23954730', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(512, NULL, '1232279007', 1, '01ec4335-d17f-3c3d-8ed0-7dc682301b2e', '2017-10-24', '1681.59', '11393242', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-17 06:50:59', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, 'pending', '2018-05-17 09:50:59', NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(513, NULL, '773749091', 1, '9362197a-08fe-32ea-af3d-75555b1c81e2', '2017-10-09', '629.60', '31092031', 8, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(514, NULL, '669309617', 1, '07a2546c-1dc2-3d5c-92f1-14b58ba56479', '2017-11-18', '2108.41', '18374184', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(515, NULL, '1024405865', 1, 'd13d7b80-c529-3e88-b709-26defe383b2d', '2017-10-28', '1568.99', '2047366', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(516, NULL, '1190004560', 1, 'a318986a-5660-3461-899d-efb297742b59', '2017-05-21', '859.20', '22060698', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(517, NULL, '995770648', 1, 'c1fd6e47-e08a-3ca7-ab97-fab6d5835ce4', '2017-07-15', '1859.95', '6593755', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(518, NULL, '1262367730', 1, '988af27e-8125-3330-beb0-75b9c9d38e8c', '2017-11-26', '1081.29', '15236242', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(519, NULL, '1153684206', 1, '3ea7aadf-8325-38f3-8494-c830c0bbcc3f', '2017-07-10', '2624.65', '41704833', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(520, NULL, '1342618247', 1, '3600acb7-58b7-3d05-901c-0a5220cee315', '2017-07-17', '2822.80', '7231284', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(521, NULL, '436538385', 1, '8877170f-635c-3bfc-ab23-25144e0475bf', '2017-08-01', '1394.27', '44305350', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(522, NULL, '817890890', 1, 'c45ba22e-ccef-38d8-b534-293eabfcb8cb', '2018-04-12', '910.85', '16744564', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(523, NULL, '720018219', 1, '74579498-8dab-329c-9453-7352404b0b26', '2018-01-05', '1555.50', '44224986', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(524, NULL, '891924572', 1, 'e8f21cb9-66dd-3fd4-a5a2-71d35d5efe2c', '2017-12-29', '1712.74', '13263096', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(525, NULL, '1518139542', 1, 'b2d22c28-4768-389e-b023-1ad6b819c1f2', '2017-11-30', '1025.80', '1140879', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(526, NULL, '564102080', 1, 'a025a44e-6d63-3438-b936-64ef4825645c', '2017-06-26', '1611.54', '44686584', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(527, NULL, '28174231', 1, '02630455-c09c-3bd8-bb27-af71f6f91353', '2017-09-03', '2944.12', '16036398', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(528, NULL, '43199128', 1, '4d0d83b0-b959-3e29-982a-6447cb70da1b', '2018-04-17', '683.04', '23347505', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(529, NULL, '154646370', 1, 'd8bc8da3-f0c6-38f3-b37f-45d376c37ad5', '2017-08-14', '1928.82', '37706318', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(530, NULL, '684048338', 1, '12cfd3d4-c704-37ff-9492-2dd5787a8fb7', '2017-11-03', '1800.58', '8494859', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(531, NULL, '734170977', 1, '7e1c638a-a393-3ab9-8b48-0dc7ffa583e6', '2017-12-03', '2499.32', '40102599', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(532, NULL, '882891901', 1, 'a844f989-9b23-3955-b6ec-827273d56297', '2017-11-02', '2479.51', '10759517', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(533, NULL, '1259929482', 1, '05fed9e8-9e08-326d-ab8d-43d86d8c8323', '2017-06-07', '1955.89', '40162692', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(534, NULL, '218197413', 1, 'ab2c1518-dba9-32ac-b24d-c45e0c3bd1de', '2017-06-27', '1276.05', '22781634', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(535, NULL, '1039174937', 1, '308df461-7028-3320-9ef5-656953c61164', '2018-05-01', '454.63', '37988409', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(536, NULL, '597047107', 1, '24498b75-3dcb-38dc-9b7e-4e6fc9ad57d3', '2018-02-20', '779.66', '47839280', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(537, NULL, '1468105209', 1, '837ac673-dec4-3f52-aff8-835c14cb525e', '2018-01-22', '808.99', '20428172', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(538, NULL, '1261745423', 1, 'aa759353-0578-34c6-a753-01bebc8ad92f', '2017-08-08', '2261.63', '3954454', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(539, NULL, '138974425', 1, 'c72dedd7-476c-30de-b302-95c887869772', '2018-04-07', '514.87', '1138854', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(540, NULL, '712030305', 1, '000ad747-9dc5-3cb1-a362-8fe05d76f487', '2018-03-01', '780.15', '28285603', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(541, NULL, '1441203889', 1, 'abd4e57c-9bcd-3ad6-a33e-e08d654263cf', '2018-02-07', '2070.55', '1863638', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(542, NULL, '313347277', 1, '87422518-da35-3a74-843c-9222803c0d3f', '2017-06-02', '2575.70', '4624111', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(543, NULL, '882000609', 1, 'c1022a6c-e228-3fa3-b95b-96ae6ca3fcde', '2018-04-29', '1765.62', '35730707', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(544, NULL, '1139656218', 1, 'ad0569a6-78bb-38d0-b450-4a740eec201e', '2017-10-21', '1310.36', '38254069', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(545, NULL, '1022532456', 1, 'e28d1bf4-0314-38fa-927f-49281d5fe6ac', '2018-05-15', '1966.58', '6648926', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(546, NULL, '1507997584', 1, '3918ffe5-5c6d-30dd-9226-1d6bc041a27e', '2017-12-22', '2199.16', '35092804', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(547, NULL, '73491454', 1, '698efe87-9a16-3979-9a4b-4248224ef0fa', '2017-08-27', '943.25', '35034261', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(548, NULL, '1215210123', 1, '60e6cf56-07c6-3e90-8b3d-0301e34af1c8', '2017-11-30', '532.28', '26595722', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(549, NULL, '1337026343', 1, '240d4841-eb18-3748-be2a-833fee229fb3', '2017-06-16', '411.58', '45960976', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(550, NULL, '1351020476', 1, 'ccd88d2c-902a-3ce4-86a8-79fb663d0b1c', '2017-08-31', '1369.08', '41507483', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(551, NULL, '1024175234', 1, 'ecf402eb-849b-3aa1-b9ad-b800e77cb0ec', '2017-06-27', '1497.66', '21113048', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(552, NULL, '44442394', 1, 'bf97cef0-1e89-3cb8-949c-d3b28936af56', '2018-04-06', '358.38', '34103660', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(553, NULL, '762769775', 1, '6cb0b3b2-54cc-3707-9883-09f1b3dc5cdd', '2017-09-23', '2698.05', '18158710', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(554, NULL, '438910511', 1, '877364b4-f885-33c8-99b7-3cb62da1fa3f', '2017-12-25', '2284.91', '23316969', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(555, NULL, '312464001', 1, '5d53628f-a602-30d3-a56c-4d023e41f5ef', '2017-09-11', '1792.15', '32225399', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(556, NULL, '1264935596', 1, 'cda48690-d945-36ba-b75f-7da7eca3830f', '2017-09-27', '934.41', '6970680', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(557, NULL, '679513665', 1, '699b0722-d7be-3ef0-8cde-b99b511a007b', '2018-03-04', '2806.57', '47690632', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(558, NULL, '1001382971', 1, '7d860bd6-56db-3a7c-acf3-0d7b0468cc9b', '2017-12-24', '1400.92', '9769512', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(559, NULL, '1483343964', 1, 'd7459eb9-f450-301b-8f22-7f0a290d509b', '2017-07-01', '1056.08', '16373106', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(560, NULL, '701455695', 1, 'a3ff278b-1535-36c5-9ad0-e9ed279f0e11', '2017-09-16', '2433.43', '35544685', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(561, NULL, '1244702671', 1, '02e80b50-22bd-34dc-87e5-ff3d052b5215', '2018-01-31', '2359.51', '49365932', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(562, NULL, '556428262', 1, '09065966-a4d3-32ea-80fa-d755997b1e5f', '2017-10-22', '1232.74', '45554993', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(563, NULL, '28875099', 1, '3ff15d0b-1cd0-3fdd-9c21-2e8284cad103', '2017-05-23', '2406.68', '31116485', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(564, NULL, '1174646364', 1, '960aa1ea-3b5b-33ac-9156-1bec2cda8042', '2017-07-22', '887.16', '28648078', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(565, NULL, '411965254', 1, '9d7ad49c-e7c4-31e9-8c84-438b31694e37', '2017-12-05', '1692.33', '21840100', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(566, NULL, '881618651', 1, 'e305dc76-0556-3308-9b7d-9010b218177e', '2017-05-21', '749.88', '34373866', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(567, NULL, '156964134', 1, '3aa8dd70-ffee-34ed-b90a-8cf089c8d838', '2017-12-03', '2961.32', '41044632', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(568, NULL, '174647176', 1, 'bc11049a-9c4a-3c37-9845-e1698e7c5734', '2018-05-12', '1091.55', '37214710', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(569, NULL, '118744390', 1, 'f6c8e651-fcb8-39d3-98b4-008f50142eae', '2017-12-12', '2610.52', '2450273', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(570, NULL, '799099631', 1, '696bac0f-a63a-3540-9402-07ead81d474b', '2018-03-15', '1110.91', '24245380', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(571, NULL, '750109210', 1, 'd452889e-e9da-3706-9ba9-b8d6a8ae6c6f', '2017-10-16', '2194.17', '29144917', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(572, NULL, '1095860633', 1, 'c6022688-8c37-3fc2-abec-02eda823fbca', '2018-01-06', '2362.06', '6162666', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(573, NULL, '703918864', 1, 'aa1472e7-d94d-35c8-bf2c-268795a0d967', '2017-07-06', '2078.08', '11876881', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(574, NULL, '139598432', 1, '02244793-fad1-36c7-afbf-50c0994a91d4', '2017-12-14', '385.25', '32780865', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(575, NULL, '542800148', 1, 'd9b79271-b25f-3c64-9648-d970c657567c', '2018-03-05', '1111.48', '10640540', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(576, NULL, '1040050516', 1, '37cfbb77-8a15-3e18-ab8c-52f180390b75', '2017-10-08', '1066.08', '42098003', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(577, NULL, '1439997047', 1, 'b8bd0a30-dd04-3302-b813-cd6d10a451f2', '2018-03-16', '1533.77', '10828891', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(578, NULL, '350944787', 1, '0bb59965-cb47-313f-b1b2-42181f1fe53c', '2017-10-17', '752.92', '46273580', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(579, NULL, '520511452', 1, 'f0e51da0-f0c7-3385-9a57-6bb8da4adc77', '2018-05-06', '2482.22', '33475841', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(580, NULL, '674146408', 1, 'cb6bff19-44a9-331e-a196-47913ef8d8df', '2017-06-17', '1586.36', '36005326', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(581, NULL, '482623355', 1, '8b5997e5-2ccd-336d-8086-db538dda2ff9', '2017-10-05', '2915.88', '3457722', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(582, NULL, '1155740059', 1, '2d94f09f-b09f-3529-998a-56a4a1b7d366', '2017-08-30', '1946.44', '6914303', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(583, NULL, '266423327', 1, 'd830124c-bd02-3dd6-9da9-90ef10ee9901', '2017-06-20', '2678.98', '31141993', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(584, NULL, '81474310', 1, '8ce11eef-84cc-33c9-814b-fcf4379af039', '2018-02-14', '2774.18', '24437192', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(585, NULL, '128586343', 1, '82086b6d-ac52-3298-9d81-68e5f61b9265', '2018-02-02', '2256.15', '2286244', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(586, NULL, '253894196', 1, 'a9a5424c-b4d1-32f4-a948-559f80dd6e45', '2017-06-13', '2517.65', '28453162', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(587, NULL, '483114902', 1, 'a2cf6323-fe60-388e-b056-0b261a06f75f', '2018-03-12', '1090.93', '36236550', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(588, NULL, '524485720', 1, 'a49791d5-fdbb-3f64-a92a-422b7845c75f', '2018-03-14', '1265.19', '8221441', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(589, NULL, '1000466836', 1, '6f01b0ff-89b6-33d6-b162-12ef2aef5fd5', '2018-04-10', '2213.00', '13968089', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(590, NULL, '1037464492', 1, '49158e7e-2ca0-384f-9548-f6065f68bcbb', '2017-10-16', '1535.48', '47101234', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(591, NULL, '921559959', 1, '00579fa3-7e21-37ab-8731-a00b267ec4d7', '2018-01-09', '2185.00', '27241399', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(592, NULL, '1101538347', 1, 'c418f252-c24c-3265-aa47-7e5f59293b7f', '2017-09-16', '2021.28', '36536152', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(593, NULL, '425087780', 1, 'f863889c-b336-3fde-a4ba-8c794302d2af', '2017-06-12', '1271.39', '43190844', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(594, NULL, '644289921', 1, 'c55f60f0-e1a1-3c64-9e3a-6a0ec24c10d0', '2018-03-26', '2441.00', '49322415', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(595, NULL, '391433207', 1, 'a2c4d9f8-c26a-36e0-8bd7-f3fdfdb2d942', '2018-03-06', '1359.34', '15629101', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(596, NULL, '132373412', 1, 'c20bcc02-6b80-3880-9c54-8f29a36b42e7', '2017-12-25', '2012.41', '34200845', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(597, NULL, '370517405', 1, 'a6728988-65df-3d01-b238-6028a4131b85', '2017-11-30', '1700.40', '7866010', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(598, NULL, '52739423', 1, '58f4db3f-030f-374b-8d75-fc962da17c16', '2017-10-30', '479.88', '5445390', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(599, NULL, '729227018', 1, '046f0189-9c0d-3d07-acaf-8161be37d05f', '2017-08-22', '2062.96', '35705359', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(600, NULL, '856003587', 1, '2de62671-8ace-30c3-aa1f-99cc8289e5a1', '2018-03-15', '1961.65', '26916713', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(601, NULL, '817744130', 1, '02e06671-07c4-3c57-98b8-46c1bafe0b75', '2017-11-19', '2691.75', '11706392', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(602, NULL, '890268022', 1, 'ab5f8245-1337-3337-b944-8be3020863ab', '2017-11-10', '1529.24', '33327688', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(603, NULL, '1320801535', 1, '1c9117f4-33b7-30ef-9bec-be76a1db72c2', '2017-11-25', '1700.41', '36658256', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(604, NULL, '18334555', 1, 'ed1d9b71-ec89-37b7-b12e-db4c42daf1c6', '2017-06-25', '880.59', '43241786', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(605, NULL, '1210045502', 1, 'da2e2230-34c3-31c9-b164-b41800f660cb', '2017-10-26', '1221.38', '2863832', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(606, NULL, '1168222188', 1, '8885951c-390f-354d-a63b-6e3589a4a990', '2017-09-12', '1718.50', '21358405', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(607, NULL, '701136462', 1, '0d61e809-8c78-3568-89fd-0147959d76f2', '2017-10-19', '1304.16', '1399707', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(608, NULL, '792543628', 1, '4e65e760-c6e8-377d-bc42-2dab5e9aa821', '2017-12-15', '425.76', '24656762', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(609, NULL, '512920377', 1, '285ed8a4-d960-35dd-b975-756e29e563dc', '2017-07-30', '772.02', '40172849', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(610, NULL, '1180314824', 1, '06750621-356b-3e61-aff9-9138e0687e9a', '2017-11-21', '370.52', '41056238', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(611, NULL, '482225979', 1, '950da989-8160-3f58-b394-24fba5b7caa5', '2018-01-14', '1389.26', '12617276', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(612, NULL, '1323750107', 1, 'bd7d6beb-7591-3228-a2fe-b781a35eb234', '2017-08-26', '2804.21', '20357292', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(613, NULL, '200117715', 1, '3f68eb11-d853-35ac-9730-81661f155106', '2018-03-17', '781.26', '47367102', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(614, NULL, '1108014713', 1, '85b31734-aaee-35d7-9273-c09a1bae6a4c', '2018-03-11', '1079.20', '6258476', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(615, NULL, '810556835', 1, 'bd920abd-ed73-3702-b4ac-a96316b52bdc', '2017-08-24', '1284.56', '21109934', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(616, NULL, '515918356', 1, '9002f081-0479-3f4f-a9dc-f92d2920d02c', '2018-02-09', '637.91', '28114370', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(617, NULL, '995840986', 1, '6363f99b-e224-3b35-9b6f-065bd86d4a20', '2017-11-29', '1709.59', '3967597', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(618, NULL, '1158307138', 1, 'c866d295-5f78-3222-9abc-2c3bc910e6c1', '2018-01-15', '2805.03', '26398835', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(619, NULL, '807305080', 1, '8eb95b42-2782-3c2e-97ec-56123dacdb95', '2017-09-08', '394.24', '5148717', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(620, NULL, '220855257', 1, 'abe91f6c-7968-3cf7-8d13-26d3a7ce5f1c', '2017-10-22', '2396.97', '32617472', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(621, NULL, '1339181854', 1, 'b04a04ad-257d-30bf-a8b5-7eafaa69086a', '2018-05-13', '1586.57', '48573666', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(622, NULL, '1193084683', 1, 'e8f1ee89-9e3f-370a-90d9-a114bf6dd85b', '2017-12-21', '1133.31', '31790487', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(623, NULL, '234700960', 1, 'f236da62-c403-3348-b9db-23d5d9273584', '2018-01-10', '2263.03', '13408534', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(624, NULL, '581622022', 1, '84e5a564-3b1a-3dab-a39f-3ba42e6c4fe3', '2018-01-10', '354.90', '44184802', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(625, NULL, '719625890', 1, '0fd295ec-09e3-3513-9b1a-303450e1c615', '2017-06-25', '1309.56', '34127562', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(626, NULL, '247092579', 1, '7d144cc8-d24b-3311-8f11-29002b1d4de2', '2017-09-01', '830.63', '23641730', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(627, NULL, '970815057', 1, '44be53af-793e-3312-b629-47cd0c651ff5', '2017-10-31', '2365.09', '47563998', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(628, NULL, '484071843', 1, '65f0ce60-03e8-3bbd-838a-477a54391ed6', '2017-09-11', '1721.69', '3513914', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(629, NULL, '1309834943', 1, '01e861a8-26a5-3253-af46-0c91d7cd7a59', '2017-12-30', '426.89', '30668598', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:25', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(630, NULL, '64037886', 1, 'ec3c9d88-c1c3-3cf7-8690-d90a83e1ab48', '2018-03-23', '2072.94', '27741850', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(631, NULL, '561360419', 1, '6c10b43b-5fc2-3d4e-88a7-efa35f8799a3', '2017-12-13', '2892.74', '9614762', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(632, NULL, '450369996', 1, 'e24e4852-b76c-3fd8-8431-4949da81de16', '2017-09-24', '1392.00', '38421896', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(633, NULL, '987099798', 1, 'ea164321-b8f2-3f71-8f32-8002979b4113', '2018-01-07', '911.71', '9244676', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(634, NULL, '1319390536', 1, '81143c38-21e5-3be8-a104-f0a1c157ca72', '2017-10-27', '1747.17', '18327747', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(635, NULL, '1228906315', 1, '16711fb2-f676-3a68-ba2c-2bab25e7f960', '2017-07-27', '715.66', '49191235', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(636, NULL, '140961664', 1, 'aaf034a0-0656-3212-819d-284c1bc4b694', '2018-01-07', '485.20', '44167433', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(637, NULL, '845895939', 1, '481d722f-b61c-31c8-83c1-f39184ff836b', '2017-08-06', '2813.73', '19773174', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(638, NULL, '1223107211', 1, '59cfefb8-2cdd-3fa5-9b3e-7ed03fdc1c8a', '2017-11-05', '2095.84', '8126713', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(639, NULL, '890696647', 1, 'bcdda093-e44d-3453-aa44-76e3c4fd2cfd', '2018-02-13', '1491.21', '20850156', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(640, NULL, '16851578', 1, 'b3f64d5d-3b80-3f08-8ad3-f29a6a5c07b7', '2018-02-19', '1745.66', '36662841', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(641, NULL, '639836095', 1, '3d070cf2-e22c-3423-8ab7-c76ff21f7afd', '2018-02-10', '2024.81', '39617105', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(642, NULL, '1474295525', 1, '050029ed-65c8-3e04-bb0c-52d136838864', '2017-05-15', '384.32', '4879114', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(643, NULL, '1322124063', 1, '17f7b379-8c14-386d-b6dd-b77b3dc3e0f6', '2018-04-24', '2690.00', '13040550', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(644, NULL, '963202307', 1, '503cfab5-3b9a-3d6e-a467-d77994337d3f', '2017-09-25', '2136.88', '16471221', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(645, NULL, '1480675020', 1, '551ef5c4-c044-35f7-af71-6bfbad121c9e', '2017-06-15', '2833.49', '22395852', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(646, NULL, '762970638', 1, 'fd049408-8d29-3988-9c84-ea355bc01e9e', '2017-07-10', '1263.26', '19343623', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(647, NULL, '1462378696', 1, '903ed74e-8fcb-33f8-a4bd-55474a8d1e6d', '2017-05-28', '2193.07', '37019351', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(648, NULL, '358351635', 1, '617194c5-dded-355a-8ddf-969acdfeeb5f', '2018-04-18', '1089.39', '15488216', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8');
INSERT INTO `assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `accepted`, `last_checkout`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `_snipeit_digitized_dynamic_success_1`, `_snipeit_universal_intangible_info_mediaries_2`, `_snipeit_up_sized_foreground_model_3`, `_snipeit_vision_oriented_coherent_implementation_4`, `_snipeit_normal_re_order_level_5`) VALUES
(649, NULL, '1088274650', 1, '029442ec-87c2-3af0-b93a-2470c1620f6d', '2017-12-09', '2756.62', '25575937', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(650, NULL, '418927457', 1, '5d011ad8-90ba-3e68-8f29-20aafc204c01', '2017-11-24', '1358.87', '23161430', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(651, NULL, '33959117', 1, '6b2dfbbe-5c35-3f35-998a-a6925eda586c', '2017-07-16', '804.77', '49612875', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(652, NULL, '1452438050', 1, '4ff4fcc3-ed50-3e7d-acc3-2b4aafdcc3c7', '2018-03-17', '809.48', '33666808', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(653, NULL, '16129937', 1, 'bca36db8-0920-3103-840d-4910a6c35b67', '2017-07-17', '965.06', '12862228', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(654, NULL, '1006443276', 1, '41a4a243-fe70-3b66-ab05-f9e9775030f3', '2017-06-03', '2396.45', '47915025', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(655, NULL, '221809629', 1, 'cc30cc8d-ae3f-375b-878f-835ff66fc6af', '2018-05-03', '2181.23', '18891315', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(656, NULL, '1149395344', 1, '60f01a74-c4c3-3868-90fe-dc212ae7543f', '2017-09-26', '1520.56', '41283462', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(657, NULL, '1415712985', 1, 'c2f711c4-3741-3a52-865d-a7d1869342ad', '2018-04-21', '1862.42', '5612180', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(658, NULL, '1245538126', 1, 'd9c430ae-6c4b-35a7-9c6f-2bbca59cd34c', '2017-12-12', '2664.27', '30322182', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(659, NULL, '773642711', 1, '74a5a674-4ff1-3a03-bf47-c5e995a5e8c1', '2017-12-21', '1798.43', '43619088', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(660, NULL, '227105786', 1, 'fdd73903-0838-3d44-90a0-2cbeb3688a80', '2017-07-20', '757.35', '11570002', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(661, NULL, '1441663750', 1, '2e2d9eba-c371-3f7e-8fa4-3fb6ff886cfc', '2017-06-11', '1410.69', '37893930', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(662, NULL, '569027734', 1, '486ae527-69f1-377b-b28d-1bda693eedf0', '2017-12-06', '316.64', '2418476', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(663, NULL, '739122651', 1, '719a91f0-311f-39b9-bf6b-092753e44ba4', '2017-09-09', '1129.87', '47711950', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(664, NULL, '1132171512', 1, 'fde8886c-021a-3b0c-a9d1-c91baa136c24', '2018-04-09', '304.63', '12217210', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(665, NULL, '183712219', 1, '5f8682de-4501-3b9b-9319-c5228d9cf324', '2017-12-21', '2432.84', '31001332', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(666, NULL, '945168681', 1, '345c3160-8954-3d78-bb59-e364625e88a7', '2017-07-23', '1008.18', '47307367', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(667, NULL, '945240996', 1, '88dabdd7-ef7e-324b-9cfd-70e5bb0ad1f2', '2017-12-03', '432.39', '1471266', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(668, NULL, '1291620581', 1, '265ec7cf-d3bb-3f68-bf87-f99a44693b61', '2017-11-04', '1580.76', '47269248', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(669, NULL, '1246357040', 1, '04687cd1-61ff-3dda-a4a8-4aca1e227bc6', '2017-10-07', '2935.05', '28603005', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(670, NULL, '722326505', 1, 'a4b5d4ab-3b13-386e-b84b-be6f3905cf4c', '2018-01-14', '1619.06', '29165917', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(671, NULL, '1350840856', 1, 'd401d222-096c-3265-a06b-43c5ea3f2e25', '2017-11-18', '361.55', '8694450', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(672, NULL, '709526764', 1, '6dee8b50-131b-31a8-9b3f-bc8e15341512', '2017-11-23', '881.12', '42641943', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(673, NULL, '110431732', 1, '844362e6-d483-330c-9a11-0d075046cbcc', '2017-07-31', '1934.66', '47574079', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(674, NULL, '335271043', 1, 'c8aad980-7353-3312-957f-89ec5f67ad05', '2018-01-16', '2551.63', '10132668', 8, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(675, NULL, '689592291', 1, '02f5f08b-bff0-3abc-9775-b31354119345', '2018-01-24', '761.05', '7889637', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(676, NULL, '396104529', 1, 'b3b274f8-71a0-395f-af99-8b02d4f7d8ca', '2018-04-03', '1907.88', '2682945', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(677, NULL, '128762915', 1, '7a7de8ef-e834-3645-ba77-a1d9d26d2f80', '2018-02-06', '838.00', '38234471', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(678, NULL, '99437461', 1, 'f8d273e7-ef5c-35b0-82ae-3a0d52745aa2', '2017-11-14', '2180.70', '35000904', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(679, NULL, '250591897', 1, 'cb6fe23e-8052-3e22-b72c-51d7cc59a2e7', '2018-03-08', '1629.36', '9195648', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(680, NULL, '1199817264', 1, '3b384a9a-0df3-31b1-87b7-ea278b4387be', '2017-11-21', '2388.56', '29109679', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(681, NULL, '1497942267', 1, '5ed0d3c0-4849-303f-b5dd-0da07e58a31c', '2018-03-19', '992.47', '6176968', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(682, NULL, '555631187', 1, 'b60e8abf-22f0-3bab-bf65-957e53e4c08b', '2018-02-01', '793.10', '26271629', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(683, NULL, '1209741754', 1, '3c779143-4dce-326d-8d70-df209c56c956', '2017-05-30', '2261.51', '28875529', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(684, NULL, '456003634', 1, 'd145fb31-04d3-3b65-aad9-7ebdce65254d', '2017-05-28', '1887.12', '28853719', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(685, NULL, '841231255', 1, 'd37e8b18-133c-3044-8f76-eff689fd50f1', '2017-08-30', '2658.08', '26068734', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(686, NULL, '797154536', 1, '92f0f09c-169c-35dc-ab08-13d71106d8d5', '2017-05-30', '546.33', '10729651', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(687, NULL, '562700456', 1, '97189eec-a728-3086-b34c-894a017b32d8', '2017-12-26', '358.04', '35899430', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(688, NULL, '1233586270', 1, '06e7addb-4c06-3488-9ba7-fb4661c17f1d', '2017-08-02', '1952.00', '29622262', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(689, NULL, '1046455099', 1, '3c6f95ca-8efa-351b-9432-8b930f59cb93', '2017-10-02', '2720.79', '39956018', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(690, NULL, '889749204', 1, '1be7c087-447b-3e28-b696-1899cd522bec', '2017-05-20', '1692.51', '30113236', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(691, NULL, '1103952138', 1, '3184df1a-9295-36a5-a6b9-2fd134be1c1c', '2017-08-27', '2064.06', '39132636', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(692, NULL, '116995921', 1, '4d1841a2-3e87-38f4-8d4d-7f005036fb84', '2018-05-14', '1898.66', '4050905', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(693, NULL, '605052181', 1, 'e40e08bc-0b6f-3deb-9ba4-5875c47a150f', '2017-09-12', '1655.44', '10347466', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(694, NULL, '591642326', 1, 'ec1be325-bd7e-36ee-a262-ac2607eeb681', '2017-10-26', '2245.65', '11322171', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(695, NULL, '378639261', 1, '5c10c4b8-2c9d-3061-81a9-ae59100718c9', '2017-08-16', '1706.72', '24751162', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(696, NULL, '676321395', 1, '8a04cc4f-3080-39ce-a4e6-bfe8164aaa5b', '2017-12-15', '2814.75', '38283388', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(697, NULL, '1434148930', 1, '6e0ea997-50fa-3328-b73e-7327d69da530', '2018-04-15', '2993.23', '35804885', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(698, NULL, '588953154', 1, 'acf11c0b-87cb-3385-8cb4-934db85d0b57', '2018-04-02', '741.72', '38864675', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(699, NULL, '557873510', 1, '43f6109e-5cd0-3d57-8f3e-64086e64c621', '2017-05-25', '2860.34', '36920656', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(700, NULL, '1160392614', 1, 'b172d533-8470-37c1-9696-c8613e001b39', '2017-12-09', '1683.60', '38522810', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(701, NULL, '1317916698', 1, 'e97cc5c9-f5c2-3d73-9ecc-3872d14567b3', '2018-02-10', '1305.05', '14360234', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(702, NULL, '358609185', 1, 'beef70d4-55b0-3af1-89c5-e5cb6091d1e5', '2017-07-07', '2183.42', '18406686', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(703, NULL, '554950372', 1, '95b0d0b2-b79e-3364-a2a7-2019323f099b', '2017-11-08', '610.16', '37524745', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(704, NULL, '560034169', 1, '3dcf28d2-6e4b-3750-a461-2caf5df01a66', '2018-05-13', '2393.79', '10127888', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(705, NULL, '23298321', 1, '908257ee-f935-3f63-b0ad-46713e1fec3b', '2017-11-12', '693.58', '38387031', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(706, NULL, '403617620', 1, '4c90afe6-09cb-3941-99a4-eb821a637e85', '2017-07-10', '2231.54', '38859470', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(707, NULL, '241862497', 1, '3beb2094-298f-3981-bb41-855fb89ffc87', '2017-12-26', '640.24', '21232628', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(708, NULL, '1481739394', 1, '88594681-e401-3cf7-8134-89ed679bd415', '2017-06-21', '1016.61', '22783050', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(709, NULL, '81898820', 1, '986e0020-ce2a-3d47-8c99-dc4d95d1c59e', '2017-11-23', '2563.26', '21792479', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(710, NULL, '301661259', 1, 'e414d9fa-03f6-3dd8-b8f4-3ae1d1110a9a', '2017-10-22', '1931.26', '2237178', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(711, NULL, '309237713', 1, '842a6fdd-8ce1-3a4f-a23e-a5807aa7e7e7', '2017-06-27', '2174.93', '8644650', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(712, NULL, '1158710847', 1, '706022e7-ea16-3f39-8e0b-2d087f94e4a9', '2017-12-14', '2830.38', '30500095', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(713, NULL, '828699995', 1, 'babd94c9-505e-3566-8498-710d04d83b61', '2017-06-02', '2924.28', '21495429', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(714, NULL, '491422933', 1, '09e0adee-9ae1-30fc-bc01-f22c057b97bf', '2017-10-26', '2127.49', '43553400', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(715, NULL, '585327721', 1, '6ea17630-eeb3-34e4-8116-87b121dc63ef', '2017-12-02', '1800.41', '35437203', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(716, NULL, '334575188', 1, 'de0da452-c76e-39fd-b1f4-9047526c620c', '2017-11-18', '2053.07', '21569144', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(717, NULL, '1453980658', 1, 'c2a6fdf0-968a-3af2-99cc-231ed270b933', '2017-12-08', '1500.90', '42483142', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(718, NULL, '951802693', 1, '0a67d24f-7db3-3dd7-8473-7d71fb93107d', '2017-06-22', '788.06', '31413598', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(719, NULL, '537005536', 1, '952747cb-8b99-3226-a14d-18265977005f', '2018-01-13', '1675.23', '21192088', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(720, NULL, '1335286782', 1, '6472cb27-98df-324d-ba52-70fd9ab87f12', '2018-01-31', '2595.11', '2534907', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(721, NULL, '335169141', 1, '72e26012-cbfa-3924-a81a-2a3425cf0f98', '2018-01-19', '1666.61', '9743628', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(722, NULL, '829681790', 1, 'd0522183-def6-3572-a21d-93eab8f13394', '2017-09-03', '1476.96', '29012347', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(723, NULL, '1294761339', 1, 'f5f4cccb-4cb5-3c2b-bd66-efc98966ffbe', '2017-06-13', '2781.04', '36687141', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(724, NULL, '825154594', 1, '42e44690-387e-3766-bfbb-181ed1d324a3', '2017-08-21', '2796.70', '8453073', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(725, NULL, '169645971', 1, '8f2ff86c-2676-350e-b613-505ae0efeee2', '2018-04-10', '506.99', '38142442', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(726, NULL, '465900555', 1, 'ad50ae31-54a5-3ea9-a01f-edcaabe712fd', '2017-11-15', '1767.11', '35516386', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(727, NULL, '1043375446', 1, '2b6ef8f7-4ff4-31e6-83a8-7d785fc0253d', '2017-08-01', '1336.32', '1534978', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(728, NULL, '1035737699', 1, 'd06ccab1-f449-3ab4-8df3-618c8192b0c1', '2017-07-18', '636.28', '7367243', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(729, NULL, '921244768', 1, '793d93bb-284b-33cb-bf80-a259d06ae8bf', '2017-10-20', '967.43', '21504499', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(730, NULL, '1072317648', 1, '6a1ca202-8012-33ff-856f-6b7bfe0bb62a', '2017-05-26', '2028.53', '30182501', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(731, NULL, '132324254', 1, '2ccb00af-8e39-399d-bfe3-5b2c98e62dc8', '2017-05-17', '2659.03', '42418847', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(732, NULL, '441091159', 1, '48227308-e837-3d44-bec1-2ee96575384d', '2017-05-23', '758.49', '28961478', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(733, NULL, '669904458', 1, '40f6bb48-0ae2-306f-a07a-4c1311882859', '2018-02-10', '1781.12', '4226305', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(734, NULL, '240938676', 1, 'acae2162-61c6-39ba-a02f-a32a14cb6065', '2017-06-16', '1016.50', '3338517', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(735, NULL, '679406319', 1, '4b0b208e-eedb-3385-ade1-84f5a418bafc', '2018-01-09', '2704.63', '36919264', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(736, NULL, '886984236', 1, '2f725155-5399-3611-bf08-6c58b5c8379d', '2017-12-11', '755.33', '33498789', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(737, NULL, '322750171', 1, '537aab4e-a54d-31a6-ad5f-9d61e0e9a41d', '2017-10-08', '2774.97', '14790205', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(738, NULL, '277105570', 1, '87b15c43-1efd-3c05-b60b-0f743f58ed32', '2018-03-19', '2385.43', '30277988', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(739, NULL, '1268069357', 1, 'e86c9aed-2296-3ae5-bb9c-35bfbda8ae3e', '2017-07-15', '1090.88', '21641557', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(740, NULL, '725795174', 1, 'dda6f13d-c755-3d9d-816c-f9fa9ae6451e', '2017-10-08', '387.50', '18800421', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(741, NULL, '282030937', 1, '78b97fc4-a8bf-3491-a2c7-13766f45924b', '2017-08-14', '1581.70', '2771384', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(742, NULL, '22630560', 1, '4b242731-0948-3098-b09f-f5c283998550', '2017-09-09', '1409.22', '49809841', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(743, NULL, '805935210', 1, '33d1bf5f-00d9-3d11-9055-d5fbd213058f', '2018-02-19', '2264.05', '17295236', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(744, NULL, '1207044560', 1, '9cbbee9d-2c9e-3f1a-82b5-62549d678b0a', '2018-04-11', '1363.34', '17792841', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(745, NULL, '1124563449', 1, 'd88d2449-2177-3d50-8f60-25ce847b6687', '2017-12-08', '2342.32', '11764001', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(746, NULL, '1065222251', 1, '1d62367b-8e7c-3a48-889e-1a31fedfb20b', '2017-05-22', '2915.57', '7412884', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(747, NULL, '620939620', 1, '26f9727e-cb69-31b7-a086-7a4cb74d1ba7', '2017-09-27', '482.34', '47960953', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(748, NULL, '431360280', 1, '12b21485-369e-3351-9ece-b14a1b86b9fd', '2017-10-28', '560.58', '41861194', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(749, NULL, '251985558', 1, 'c5a4027b-604d-3b58-820c-041148ee6788', '2017-11-28', '948.76', '29050407', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(750, NULL, '1452278176', 1, '3b8079be-8490-33f0-bf1a-61ecc88ef8ac', '2017-11-13', '1533.59', '5113557', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(751, NULL, '1384912474', 1, '01899b37-6b90-3e1a-9647-8a3e26c9ba16', '2018-04-06', '1698.90', '6906266', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(752, NULL, '1272144823', 1, 'be8a4820-17d6-327d-9060-89caa61015d4', '2018-03-20', '1847.42', '23641581', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:26', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(753, NULL, '1166022327', 1, '98c5abbc-6542-3b74-9bb6-7cafa4b53fe9', '2017-08-06', '2282.44', '44741253', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(754, NULL, '1401459914', 1, '81baf022-83cf-36c4-9d6e-f15298203a61', '2018-04-17', '1561.29', '30647984', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(755, NULL, '141816977', 1, 'feddbea0-3e9b-3736-b0c3-6cf6005dc8c0', '2017-07-16', '824.66', '46506345', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(756, NULL, '798422174', 1, 'e9cb104e-d22f-30cd-960a-7ee7434ab191', '2017-08-27', '1864.19', '18868915', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(757, NULL, '990820806', 1, '7ca1175a-95ea-3e71-a476-5b99dde63957', '2018-02-05', '1489.36', '45534602', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(758, NULL, '598833073', 1, '441391c8-e0d4-3c70-83f5-c22fc180f4bc', '2017-08-11', '2679.79', '10065789', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(759, NULL, '537486747', 1, '958c3634-9523-3180-b445-43b86d5cac1b', '2018-02-06', '2635.18', '43605740', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(760, NULL, '364489752', 1, '871dddd4-4378-3e22-a2c2-74037120c6fe', '2018-01-21', '1339.47', '8834426', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(761, NULL, '695601922', 1, '388a3e62-d976-3dd5-82ea-e4bc7960077e', '2017-11-12', '1611.95', '38727941', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(762, NULL, '19216463', 1, '51eeb57b-70c1-3fd5-b04d-d83fd6c27b7b', '2017-06-23', '2831.51', '19508248', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(763, NULL, '216048887', 1, '2b82f9bc-303f-3461-a62b-421606ff0809', '2018-02-15', '2950.99', '15022151', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(764, NULL, '1062904604', 1, 'cde7bd9f-0c95-3950-a9dd-33a67e879e58', '2017-08-27', '2189.11', '28828208', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(765, NULL, '967120389', 1, '4a942270-e63e-34a8-a059-e0d27b7929ee', '2017-07-17', '2269.13', '33925628', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(766, NULL, '121160221', 1, '71a2b80d-7b17-3755-9cb6-06ff181d0b61', '2017-09-23', '2177.40', '29356329', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(767, NULL, '538082439', 1, '75fd7797-b7ca-3a05-bca4-4c0d7740d0cf', '2018-01-19', '2915.71', '49887038', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(768, '', '643856085', 1, 'a77d4ee2-85fb-38f7-8d83-a52971111ae7', '2018-04-07', '627.43', '22038615', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-17 09:00:30', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(769, NULL, '1293103567', 1, '7a003419-a5fa-3b9c-8b3d-574261f38a6d', '2017-12-03', '2048.87', '17206741', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-17 07:13:45', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, 'pending', '2018-05-17 10:13:45', NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(770, NULL, '49343940', 1, 'd4b480f1-31f0-3ed2-9a89-aa6d1b9b13b9', '2018-02-12', '357.28', '33208929', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(771, NULL, '71029690', 1, '486d414c-6ff6-3787-a113-bf145475e2f8', '2017-11-29', '1968.61', '35849726', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(772, NULL, '950057671', 1, '31317bdc-aab2-3e59-b3ea-6ae940b1a408', '2017-05-24', '2299.61', '16978798', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(773, NULL, '6813135', 1, '297c675a-1513-3d71-80d3-14170e4984f7', '2017-11-25', '1835.68', '6456480', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(774, NULL, '731414297', 1, '73c3eb73-7f0a-3c8a-96ef-e776153d4898', '2018-01-31', '1772.27', '38657583', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(775, NULL, '455439727', 1, 'b38020fc-9b07-3881-ab39-0b4b64da2a0c', '2017-12-04', '312.58', '44442303', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(776, NULL, '1304657584', 1, '925448ac-44cd-3257-8242-98dee30c2e35', '2018-04-18', '316.87', '35980921', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(777, NULL, '767269734', 1, '70bcfef8-09bd-3dbd-965b-a7ac7e73b84a', '2018-03-12', '1962.49', '15599095', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(778, NULL, '495591229', 1, '1f392725-0a4b-3270-b882-3fe984e2ae4a', '2017-10-21', '881.72', '25228172', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(779, NULL, '464462485', 1, '10578ba8-09ab-3175-a769-0a7e146456af', '2018-03-05', '2328.88', '8850797', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(780, NULL, '1330533173', 1, '6d8bc1a1-6fd4-375b-bfdf-7c62f6fbb60b', '2017-10-07', '869.03', '17462168', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(781, NULL, '933464371', 1, 'a1bd7cd2-1321-3cea-9f58-c5884d80ed66', '2017-06-12', '2161.91', '18577531', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(782, NULL, '1478956826', 1, '21a1bf96-bcec-3bb4-9401-dc4241927aa1', '2017-10-10', '2504.21', '11973419', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(783, NULL, '1139718515', 1, 'ab82d398-39b0-3f09-a11c-bc1487b71e01', '2017-08-10', '1470.72', '18561412', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(784, NULL, '150904816', 1, '1d3f9792-538a-396e-ba35-c016ca559924', '2018-01-24', '2710.05', '33486357', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(785, NULL, '1440162244', 1, '543d59c7-28e5-3cee-9782-cff9c72ab164', '2017-05-21', '2239.97', '27968682', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(786, NULL, '321588480', 1, 'ca91aef5-5764-3e3b-99f5-25a0ac13ce39', '2018-02-04', '1458.90', '20336351', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(787, NULL, '559223460', 1, '7a77b84a-7fa1-3627-99c5-fa514519b539', '2017-11-18', '2111.40', '21265336', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(788, NULL, '1242191898', 1, 'fb768b60-9141-358f-a3a0-bef5b91175a8', '2018-01-28', '1995.83', '12274262', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(789, NULL, '862339587', 1, 'fa948162-0e51-312e-afc7-2b22c1be871e', '2018-01-09', '2187.98', '9107223', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(790, NULL, '170623415', 1, 'ba2d9090-8200-39f4-9206-74d60cb1bd81', '2017-11-28', '900.30', '27600354', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(791, NULL, '1503724417', 1, '2a765fe3-6b2a-3a9e-bae9-33cb60d2baef', '2017-12-28', '2058.82', '3238451', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(792, NULL, '769460687', 1, '509b1d8e-b474-384f-b757-8b6de2005d78', '2018-01-18', '1307.08', '48099669', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(793, NULL, '1425805982', 1, 'c360d2ed-9528-3b35-8ab8-735d84e3dee6', '2017-07-06', '2711.83', '12326180', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(794, NULL, '749082263', 1, 'e547e84b-e559-3f74-9090-f2b3fbd8ddae', '2017-09-15', '504.36', '29416220', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(795, NULL, '745994762', 1, '530cf8e4-b046-3b73-a188-b0b2dfdcdf10', '2017-07-19', '782.47', '42554462', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(796, NULL, '341840920', 1, '667e340c-cf49-34fb-8da9-75627014a752', '2017-06-03', '734.71', '6630268', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(797, NULL, '388826824', 1, '2807c5f2-3d70-3a74-8436-82ec9102b1b6', '2017-06-11', '2249.86', '35883371', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(798, NULL, '671555640', 1, '454decbd-8490-3181-bb4a-cd76cc91b31a', '2017-05-22', '2151.16', '17703038', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(799, NULL, '597686618', 1, 'ee0026a7-3580-3613-8380-2f81b97048e3', '2017-07-09', '1765.00', '2781687', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(800, NULL, '499567898', 1, '7e49a52b-58d7-351d-ae6d-b7fc7895d6c1', '2017-12-28', '1155.54', '38753278', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(801, NULL, '1384418398', 1, '9b8b65f8-e41c-3904-a1af-5e978bd5bfb0', '2017-09-12', '2038.10', '25121299', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(802, NULL, '1264655234', 1, '721b4128-a49a-3ad9-b868-d8e723b211bf', '2017-10-31', '502.65', '45787953', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(803, NULL, '522991842', 1, '732c152b-8f46-31f6-b5f3-e404d20c4fc4', '2017-10-15', '1281.78', '28540834', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(804, NULL, '1283272740', 1, '85c394ae-aeb7-3390-b324-8b8b310e6baf', '2018-03-12', '2217.71', '37494475', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(805, NULL, '698556405', 1, '754eea0d-8674-3d74-923b-4d09285fc8f7', '2018-01-09', '1332.31', '37970262', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(806, NULL, '831629171', 1, '767c4c20-1644-3ada-9551-f635da154fb6', '2017-11-23', '1387.40', '42155996', 8, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(807, NULL, '656051823', 1, '2b59d37a-0910-345f-a546-53e873785a52', '2018-01-05', '2164.87', '5294785', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(808, NULL, '228037678', 1, '9c0286d9-b8b4-3084-8778-6669351d4f0c', '2017-11-03', '672.97', '2343102', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(809, NULL, '1093278492', 1, '7df7bab6-e8bd-31b5-ba18-d1cd338e2c66', '2018-02-25', '1513.40', '7145767', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(810, NULL, '506378653', 1, 'f9dbad75-92bd-3534-aba6-c5ad69d7060a', '2017-11-07', '2331.39', '13913610', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8');
INSERT INTO `assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `accepted`, `last_checkout`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `_snipeit_digitized_dynamic_success_1`, `_snipeit_universal_intangible_info_mediaries_2`, `_snipeit_up_sized_foreground_model_3`, `_snipeit_vision_oriented_coherent_implementation_4`, `_snipeit_normal_re_order_level_5`) VALUES
(811, NULL, '1233254378', 1, 'dfae0a54-a01c-3f00-8747-5aade93a3cfc', '2017-10-07', '944.71', '12157066', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(812, NULL, '46742455', 1, '67948ffb-8939-38f4-b33c-e363197a6961', '2018-04-03', '2207.25', '1983310', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(813, NULL, '1105061400', 1, '27a117a0-b9c0-314d-8744-949548058d60', '2017-07-15', '1929.17', '26833889', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(814, NULL, '108883658', 1, '2527dd60-0489-3f8f-823c-fd7c04f2162c', '2017-07-08', '2753.03', '26365571', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(815, NULL, '121916627', 1, 'fc4ba60d-1e67-328b-9231-750d9d528f82', '2017-12-08', '507.51', '32257176', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(816, NULL, '129808356', 1, '8aaa1216-6b68-3736-babe-2afcf1b08281', '2018-01-16', '2199.19', '41945107', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(817, NULL, '1397390694', 1, '77fe95e2-e3d1-3cf9-85a5-8923799ac491', '2018-01-08', '2014.90', '46518240', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(818, NULL, '1203256857', 1, 'c5e313fc-ceb9-3903-96a7-ef1f2c62ca97', '2017-10-13', '1606.37', '19647804', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(819, NULL, '669322718', 1, 'c4f687fb-1315-3b87-a78f-ef8c7ccb6374', '2017-08-12', '1867.88', '34954167', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(820, NULL, '456489296', 1, '827944a1-1bec-3c51-8e49-59ed4960ad79', '2018-05-10', '1197.81', '22055229', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(821, NULL, '575863849', 1, 'cf9cbab4-b27a-3803-9ae4-379ca95c03a6', '2018-02-14', '748.62', '30747339', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(822, NULL, '1019648758', 1, '4abcd793-fa7d-3b13-a84f-50ca61b3929a', '2017-09-20', '1377.32', '35330680', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(823, NULL, '1072959272', 1, 'd855045c-2e6f-3711-9cfc-e2f8093b7dfa', '2017-10-16', '337.86', '29107641', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(824, NULL, '282413518', 1, 'dc023434-3b90-3cc1-ac8b-76b443cefded', '2017-06-29', '1075.12', '19297264', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(825, NULL, '98841032', 1, 'd58825eb-0664-3785-89dc-df4b550fe3ac', '2017-05-28', '705.14', '27781017', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(826, NULL, '1508333992', 1, 'b822e96d-cd46-3e26-aaf3-8bc02c4675b7', '2018-02-04', '2441.09', '27627633', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(827, NULL, '948230024', 1, 'c4b407c0-2f07-3375-b69f-a7d31b22aa5d', '2017-12-31', '1927.91', '40143776', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(828, NULL, '956378834', 1, 'c1136b88-dd02-3f8a-a503-809d86867d4e', '2017-07-28', '2684.05', '40156925', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(829, NULL, '504822212', 1, '94e1cf01-2404-3436-ae8e-8617a1b478c5', '2018-04-12', '1833.07', '49243216', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(830, NULL, '1066416596', 1, '5c124766-d73e-3d8c-b9c8-346cc851c825', '2018-04-02', '2628.11', '45046868', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(831, NULL, '349555304', 1, '7f2633bb-5e5b-3100-b677-139724881eb3', '2017-08-26', '2910.17', '36565450', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(832, NULL, '624565804', 1, '60d68697-2c11-312e-9f00-b3d7e00fcccd', '2018-03-01', '2500.33', '28962954', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(833, NULL, '76152571', 1, '0c6cd603-5c2e-3972-961b-d835213767fd', '2018-01-19', '2092.71', '11321167', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(834, NULL, '125655142', 1, '0178564b-5b8c-3b12-8e41-04147aa79176', '2018-03-05', '1096.79', '24738989', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(835, NULL, '892976110', 1, '26d201af-6480-3045-822b-07b66448493a', '2018-03-27', '627.37', '24949554', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(836, NULL, '1509208395', 1, 'cf1e10bc-ad2a-30c5-9129-314d4254d5f7', '2018-03-02', '2723.18', '36839769', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(837, NULL, '649066492', 1, 'd4ca7f8e-e848-37d9-bcf0-391a26ba0b16', '2018-02-21', '1034.05', '30803888', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(838, NULL, '1399440946', 1, '84bd9f95-1036-36c9-af5d-119287f95e4f', '2017-09-07', '2955.91', '3479594', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(839, NULL, '843502697', 1, '0fad0dbf-ae8c-38ab-b1f5-9df4dab6e528', '2017-06-14', '1124.75', '23914824', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(840, NULL, '47983988', 1, 'f24c112f-9fa4-33cf-ba0b-0eba73ebfc56', '2017-10-03', '1978.36', '24332353', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(841, NULL, '1124304265', 1, '32d6a186-2649-34c4-8712-6503d8489965', '2017-11-20', '2307.41', '35930257', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(842, NULL, '1145869574', 1, 'ca2742b7-79a9-326d-9041-ceaf5f0f82cd', '2017-05-16', '984.94', '35942911', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(843, NULL, '518038448', 1, 'b0cdc051-9487-3550-8126-eddcb8605e94', '2017-06-17', '1424.35', '23735635', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(844, NULL, '82117866', 1, '58f8db06-df65-3960-9958-b9b18d4a7e00', '2017-07-06', '2348.37', '13708768', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(845, NULL, '1054787276', 1, '2eebfaa6-32c7-3117-9821-d39b7352217f', '2017-06-30', '2544.26', '10586872', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(846, NULL, '309102538', 1, '2a3fff1d-cfb0-39e8-8dee-db1268dea28d', '2017-06-15', '335.19', '10339951', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(847, NULL, '651427165', 1, '88554380-b412-348b-9fc4-5fbbc925d25c', '2017-11-22', '1742.82', '3435956', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(848, NULL, '1135151313', 1, 'ea281edc-9f4d-36d2-8fb5-67cb69429b5a', '2018-03-07', '1986.24', '36991495', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(849, NULL, '1383591346', 1, '150bcbc7-45b2-3f78-ae94-b2e3f85e2d0c', '2017-11-01', '953.34', '25784031', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(850, NULL, '250885814', 1, '609da47b-4d42-3e54-9c8f-7fefbd881b58', '2018-03-27', '1840.07', '12079231', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(851, NULL, '1440597802', 1, '3a349289-0583-342e-bd40-a5301f56e219', '2018-03-27', '1089.68', '29006177', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(852, NULL, '667454237', 1, 'e4d39bf4-77d0-33ae-86d8-9e780745de9c', '2018-03-28', '1525.44', '17674115', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(853, NULL, '1476380826', 1, '0fbf0359-5fe3-3c85-b154-8553054690a7', '2017-10-08', '2298.40', '31811719', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(854, NULL, '309104395', 1, '9b1d3f93-04ba-3b9d-8fb2-eafa4a8ea625', '2017-07-03', '1617.81', '3715271', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(855, NULL, '6118147', 1, '6b604d96-51c3-35a6-a042-0161b563b132', '2018-02-17', '2531.32', '11606783', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(856, NULL, '1121448026', 1, '01659840-87df-38a6-9107-30b8dee2e3ec', '2018-02-26', '965.04', '19890605', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(857, NULL, '363977410', 1, '27a4fe79-0f20-3c76-86f2-45303c607f35', '2017-09-23', '1527.86', '12178681', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(858, NULL, '138326449', 1, '6210fb2e-5f8b-3e64-b5c2-de4aca2d3a72', '2017-07-13', '503.88', '8937714', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(859, NULL, '339189104', 1, 'f788db12-c3d2-333e-94d5-222a6921269f', '2017-06-16', '1415.79', '45809095', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(860, NULL, '663691941', 1, 'f92c6d20-b998-370f-877d-4ebb9a3408c8', '2018-04-03', '1745.45', '2396020', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(861, NULL, '1473815505', 1, '3d391cc9-d0f7-370a-9490-b90c1c83f755', '2017-06-02', '2337.20', '10090134', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(862, NULL, '268076676', 1, 'aea91b67-d278-3f92-9ab8-5afd05f6dc9f', '2018-04-15', '1945.35', '1765049', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(863, NULL, '466987072', 1, 'db6d763a-4b59-3e4e-9a1d-fee70c81584f', '2017-11-16', '1394.77', '40146059', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(864, NULL, '209888575', 1, '88e39e80-9de0-3a1d-8225-c5366e92c2d3', '2018-04-08', '2667.38', '1078631', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(865, NULL, '1314989094', 1, '0079bcfa-1fc7-33a9-a282-8b44875b2c09', '2018-04-05', '2317.55', '48754768', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(866, NULL, '1131287301', 1, '6fc547aa-d437-398c-a642-fbc8ed41a4b5', '2018-03-23', '1272.13', '33994986', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(867, NULL, '1137677174', 1, '59b78c6a-0d11-32ad-b4e4-013fdf760b8f', '2017-11-24', '1865.91', '26643035', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(868, NULL, '559846452', 1, '2138b056-9c10-3688-841f-47d53ac1ee1a', '2018-03-29', '2950.52', '1546018', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(869, NULL, '885812357', 1, '4248ae49-a179-33e0-85de-dba45c67d5c5', '2017-11-21', '2093.77', '17384635', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(870, NULL, '1492587477', 1, '277a2138-9115-311b-b835-3f67def76600', '2018-04-01', '1980.76', '23295710', 9, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(871, NULL, '1387599224', 1, 'dee4ac55-a2b7-3c37-b9aa-9edf0ba1c1f4', '2018-01-03', '1539.62', '4935629', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(872, NULL, '822125312', 1, 'fd9690bd-142a-330d-8531-1cf64fe0731d', '2017-06-21', '1191.25', '20906894', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:27', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(873, NULL, '85884486', 1, '1c6fe392-494d-3233-b73e-203d80b23a46', '2017-12-06', '1560.95', '22128740', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(874, NULL, '957822929', 1, 'a6a3f0cc-79b9-3297-b9be-5cfb44b7e464', '2018-04-03', '766.53', '37544323', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(875, NULL, '1368282319', 1, 'dcb3accb-849b-3fea-a1e4-dd88d9b1296e', '2017-06-27', '2068.48', '1266172', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(876, NULL, '987408796', 1, '70564207-06f3-3920-b669-bb5a823784e2', '2017-09-19', '2106.06', '11430790', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(877, NULL, '669873052', 1, 'c55dcac0-1545-3e01-9808-acd9e932de3b', '2017-10-06', '2219.25', '29125137', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(878, NULL, '689846803', 1, 'd1d0089e-da27-3a09-a01b-4d47f2665a04', '2017-08-23', '645.27', '29423412', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(879, NULL, '401184837', 1, 'bc1a5f2e-07e7-3343-83ca-e4a93a58d405', '2017-06-27', '380.84', '3868782', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(880, NULL, '1144390576', 1, '55164d2c-a49c-3e2c-9ec7-fdba1e216a44', '2017-09-18', '1960.45', '11902176', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(881, NULL, '963476861', 1, '13153e86-3ef8-3dad-8461-3b66150f1232', '2017-06-09', '2402.00', '29113350', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(882, NULL, '259727236', 1, 'a954312b-b1e9-36af-a0ba-00312d9de87c', '2017-12-03', '1764.02', '44537651', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(883, NULL, '1268830857', 1, '854a6b70-a51c-3260-80da-e6083aa31924', '2017-05-15', '734.31', '15616734', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(884, NULL, '711120876', 1, '6359b3ca-b082-31b1-8772-2787be5aed38', '2017-10-04', '1835.79', '5003759', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(885, NULL, '970553021', 1, '534e7e7a-cc7d-3aaa-92de-c020b74ad6e0', '2017-10-07', '300.25', '9390999', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(886, NULL, '1063161491', 1, '4e0c71cc-180c-3a72-ae66-fc62ae1ed8d0', '2018-03-14', '333.97', '6218357', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(887, NULL, '1466324058', 1, '0d3a535e-c60f-3101-a959-685e2ecf9c5c', '2017-08-13', '612.67', '30260190', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(888, NULL, '672636289', 1, '4566a8fe-f93c-3809-9ff1-e9c8f47d3a6b', '2018-04-05', '2244.62', '23756194', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(889, NULL, '517177853', 1, '6396e3ef-dbeb-3efe-9c50-90cbe88e1484', '2018-05-08', '398.00', '13511513', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(890, NULL, '283734127', 1, 'a778c0d4-2e4b-38db-88fa-9d22b7179099', '2017-08-20', '1047.94', '40563862', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(891, NULL, '458823023', 1, '53757a39-6bca-359a-9628-e88ed6e040e9', '2018-01-22', '1674.64', '8195133', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(892, NULL, '550640997', 1, '3b84fe4b-5d0d-31db-80f2-521911eda718', '2017-08-15', '1587.83', '39077472', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(893, NULL, '646407207', 1, 'd49aa101-29e5-3f47-8a31-5550b3e41ddf', '2017-11-07', '722.79', '19949031', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(894, NULL, '507941120', 1, '8211c3cb-2e0d-3361-936e-a2710be10ef1', '2018-02-22', '1752.34', '15768103', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(895, NULL, '333086571', 1, '59a818c1-c26a-38c7-b012-5d4004fa30c0', '2017-08-08', '1895.77', '12342864', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(896, NULL, '1166245650', 1, '796bd2f6-3c6f-3aaf-b6d3-d1f7d9bcde71', '2017-12-26', '813.40', '30913106', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(897, NULL, '1401437677', 1, '36532c57-ea4f-3c47-8a06-31ee81c9908f', '2017-07-14', '1406.16', '47239536', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(898, NULL, '879618086', 1, '8f85ca99-5f73-30e5-a5fb-72a44ed1e6fc', '2017-07-22', '1485.85', '17449576', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(899, NULL, '98598221', 1, 'b6a827f0-3954-3b89-9105-55bc9b4d948f', '2018-04-09', '1420.69', '35705155', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(900, NULL, '183495315', 1, '38e2b13a-5885-3053-9e99-953d65081a0b', '2017-09-09', '2744.05', '35820745', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(901, NULL, '525410129', 1, 'bb98c5b2-c02c-3bb0-9c29-d6e7d65dcbb6', '2017-06-16', '2959.61', '35161785', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(902, NULL, '1206313063', 1, '9a7e0553-fd8b-327e-b288-fa9c53716f51', '2017-11-08', '1698.13', '28296562', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(903, NULL, '325019253', 1, 'd884f18e-3212-3dde-a3e6-e2c92c1aa081', '2017-12-17', '2525.82', '29271500', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(904, NULL, '1321788977', 1, 'a6c14672-29b5-301c-b360-428a1221dd88', '2018-04-10', '1045.94', '31730102', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(905, NULL, '1300252757', 1, '418e31ef-fdcc-30de-a7a5-a8291b5587d8', '2018-03-18', '2065.60', '22882262', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(906, NULL, '681481083', 1, 'a01f6b15-227f-3772-b40d-898708a7e0b4', '2018-02-05', '2011.00', '8271361', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(907, NULL, '771738735', 1, '54701480-3a21-3ced-9c65-b1342f8e0d78', '2017-10-17', '1627.58', '45175491', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(908, NULL, '955171031', 1, '9818fea1-e413-3f95-85b4-faee785b1d2f', '2018-04-27', '905.70', '34316899', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(909, NULL, '223001352', 1, 'b5ca558c-d781-37d2-b796-d20201ec715f', '2018-01-20', '2958.87', '15966176', 8, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(910, NULL, '336442962', 1, 'cc87b7d1-8f7a-36e0-892b-440da447460d', '2017-09-24', '815.70', '1348634', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(911, NULL, '209509253', 1, 'ea2e2c6a-bfe4-383f-9cd5-60a728d2c590', '2018-01-11', '610.89', '46152687', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(912, NULL, '64433315', 1, '40c02d37-2017-325a-9161-5e89d59da3cd', '2018-01-09', '2415.32', '26811069', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(913, NULL, '576783256', 1, 'c2b464e7-78b8-30b6-9a1d-81a4fb8039df', '2017-12-28', '1599.44', '15570440', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(914, NULL, '263666948', 1, 'f7e78cc0-bf9f-3397-ae86-1fec16ddbbb2', '2018-02-23', '2263.75', '10902874', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(915, NULL, '197073210', 1, '4c6af90b-9768-396a-8b7c-855a9c8703f4', '2017-07-24', '1446.36', '29428411', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(916, NULL, '309015022', 1, '8b7b2bcd-a361-3a0d-8a3e-24badaabac08', '2018-02-21', '1841.97', '12527924', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(917, NULL, '911751860', 1, '1c424c97-6371-307c-9080-fafa2e8ee23e', '2017-07-18', '2263.53', '19949202', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(918, NULL, '492731286', 1, 'af7514fe-31c8-34a8-9625-0faf7a80f571', '2018-02-28', '1275.85', '17514764', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(919, NULL, '1445441906', 1, 'de3eb008-c3d9-32bf-9f9a-6a834599440d', '2018-04-08', '2949.39', '19808672', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(920, NULL, '1524728406', 1, '1eaf9b5c-779b-3d30-b5d8-4cf5a2b1902b', '2017-08-09', '1926.86', '19098066', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(921, NULL, '410157703', 1, '43f02176-1546-306d-bae3-f069e0b1aaf3', '2018-02-16', '2336.94', '40319548', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(922, NULL, '1155500887', 1, 'bc389b97-1e38-3054-abda-1a59e8c214f7', '2017-10-18', '1089.31', '28766693', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(923, NULL, '1271292400', 1, '90fd9e22-1c3f-3daa-9def-b6177ba56d50', '2017-11-01', '1628.44', '6848542', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(924, NULL, '912470673', 1, '06305bd0-c301-34e5-ba7f-1291ba33eef3', '2017-05-24', '2414.99', '27394704', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(925, NULL, '602237202', 1, 'bb07068a-b32a-3b10-86df-a3af8bb5955f', '2018-01-06', '1527.53', '18231943', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:39', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(926, NULL, '1369202654', 1, '8e8650f0-8878-3dbf-9945-9e1f35eeb738', '2017-11-03', '1453.06', '16754054', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(927, NULL, '1059984564', 1, '458f3bca-4d2f-33fa-8bc4-cf881cb31e09', '2018-05-13', '2912.30', '22209705', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(928, NULL, '833798450', 1, 'd56333a4-393a-3dfd-8e68-79751b792041', '2017-10-19', '1277.65', '5940909', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(929, NULL, '1436947019', 1, '1252f7aa-7099-3229-af03-673884c7c29b', '2018-04-14', '643.37', '49141084', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(930, NULL, '1382340173', 1, 'cfb169e6-0f7e-3024-99d4-4c7b96e14478', '2017-10-16', '2618.64', '43885685', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(931, NULL, '1042038597', 1, '640d9817-18a0-3a1a-8176-a2c78858f31d', '2017-12-09', '2133.17', '46555139', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(932, NULL, '646510949', 1, '2e3f95ef-d73a-39a9-aeb7-9ca15f516b05', '2018-02-22', '899.80', '21972185', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(933, NULL, '1155967481', 1, '6ae6495a-79b0-3971-a051-37c9a74aa0a4', '2018-05-02', '1879.78', '30814494', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(934, NULL, '526212630', 1, '9ad4b81a-ee25-3a94-9212-67a054584172', '2018-03-11', '1431.80', '2980283', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(935, NULL, '300548000', 1, '4423748e-158a-3683-9cff-78602008c0ea', '2018-01-01', '2135.84', '18189754', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(936, NULL, '1439964285', 1, 'cd952447-1d91-38d6-8d15-4cfbf872452a', '2017-06-27', '1174.77', '33782401', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(937, NULL, '228172963', 1, 'a56a18d9-84cc-36f4-a5eb-bc25beab7b1d', '2017-06-04', '2135.61', '45319100', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(938, NULL, '747291101', 1, 'f36ad663-edf4-3275-a01d-ce02fefe90cb', '2017-07-05', '1691.24', '13518667', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(939, NULL, '122779606', 1, '20d9e7c1-2396-38ef-be7d-3be145a2487a', '2017-08-30', '548.04', '3363728', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(940, NULL, '1166406847', 1, 'c682fcf9-4050-3e1a-b46a-34691b8dd6cf', '2017-12-04', '1269.19', '47434127', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(941, NULL, '809067013', 1, '1a3e61dd-8a1e-3451-9bba-c3960d86e654', '2017-05-30', '1764.21', '1064164', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(942, NULL, '1450714717', 1, '5a291063-5170-31ed-8d9d-1542af16570e', '2018-05-11', '2312.75', '32532792', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(943, NULL, '782954584', 1, '443402d3-a35e-3eb5-b942-37f679ba6dba', '2018-03-10', '2599.02', '31933511', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(944, NULL, '215776439', 1, '73b49637-259b-369f-a176-e7fdf735c990', '2018-04-27', '2282.09', '38894151', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(945, NULL, '1074420727', 1, 'e0e91de0-8445-3146-8556-fd0f2affafd6', '2018-01-07', '1028.97', '30311270', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(946, NULL, '165632287', 1, 'd0992b3b-8c5c-32bd-831d-6526a5bb85d4', '2017-10-09', '2638.63', '20641151', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(947, NULL, '534067410', 1, '2031af4b-d32a-3ff5-bb06-92bcb383f7fe', '2017-09-04', '2541.34', '42082699', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(948, NULL, '1189881333', 1, 'e8e62d55-67e5-350b-b29d-5e0fa1cf5cd1', '2017-08-07', '1319.30', '44955700', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(949, NULL, '575186886', 1, 'd1d2a217-65e7-31d5-8f1d-3e4633d683e6', '2017-08-02', '1552.64', '34268112', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(950, NULL, '731521499', 1, 'f677452f-dc84-378f-b424-96675388143a', '2018-04-15', '967.50', '43238475', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(951, NULL, '1458441243', 1, '58b4cbd3-3357-32fe-a1b8-c7a71972df76', '2018-04-01', '654.03', '16619810', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(952, NULL, '1251232567', 1, '8adc5f43-62a7-33ca-93c5-29a403650040', '2018-02-27', '354.65', '3090384', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(953, NULL, '1316778279', 1, '3cf00657-e11a-33b5-9e65-a6fc05bd8d0d', '2017-10-06', '2569.03', '28294698', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(954, NULL, '1435587341', 1, '6877ce8e-9cf9-30b6-9d40-2ce8ca9a5614', '2018-05-13', '2692.41', '5032161', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(955, NULL, '708870670', 1, 'bbf0bb56-71ff-3805-8907-49e331eb8215', '2017-09-22', '2422.04', '14565493', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(956, NULL, '39352193', 1, 'eda48f4b-3257-36c4-885b-5927ddb8eb2f', '2017-05-22', '1981.84', '37484359', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(957, NULL, '991093674', 1, '77ac16dd-a281-3a68-b27a-5783e85cd8f4', '2017-10-18', '1168.90', '25515998', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(958, NULL, '362938948', 1, '1f93b5b9-901b-3817-aa23-6ea9026d8c7f', '2018-05-11', '326.62', '41719241', 9, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(959, NULL, '621627073', 1, '997f12f1-ee2d-31ad-a5b9-229e19a803ed', '2017-07-25', '417.99', '8094668', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(960, NULL, '225591704', 1, 'b62d4948-6a7b-3228-86dc-b661b0ec052d', '2017-09-10', '1255.96', '8338839', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(961, NULL, '1310198605', 1, 'a2f4c642-47ca-3320-aba2-00196825a6b6', '2017-10-26', '2781.13', '19884929', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(962, NULL, '982673048', 1, '12e5faf7-0565-3cfd-a576-5373d7c82845', '2018-02-10', '540.28', '46528257', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(963, NULL, '1277505052', 1, 'ae846f72-458b-3246-a6c9-157e4c39a701', '2018-04-14', '2701.29', '36510824', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(964, NULL, '230286498', 1, 'ffa23fba-1752-36fb-a47c-290f2ec7f874', '2017-05-23', '474.03', '49929792', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(965, NULL, '702771480', 1, '895efa6e-0325-3d21-8024-d7f93d7eb435', '2018-01-21', '432.15', '40550592', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(966, NULL, '1360354124', 1, '702e8216-d176-3130-bd5f-0ba1af65f5d7', '2018-04-02', '2147.74', '9553377', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(967, NULL, '150137146', 1, 'a4d3256c-e3ad-334d-af26-fa319b95442a', '2017-09-09', '1610.96', '22231099', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(968, NULL, '251354004', 1, '0699f2e7-ea49-3de6-a0c3-0a58c7c580d5', '2017-06-03', '559.39', '44845461', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(969, NULL, '487803107', 1, 'daa4abf8-8d64-3bf5-aa2a-05d1a4efbeb0', '2018-05-02', '1707.60', '15170971', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(970, NULL, '887773927', 1, '7924f2be-51ef-3098-a1b7-463a5fbf3bed', '2018-05-07', '1729.02', '31153278', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(971, NULL, '1127381757', 1, '61466e4f-f8fe-353f-804f-d9181bfc56ee', '2017-07-25', '2455.20', '36950537', 8, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(972, NULL, '547957806', 1, 'dfef36bb-a918-3ccd-b54b-40d368a010e3', '2017-07-01', '2773.06', '45571561', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8');
INSERT INTO `assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `accepted`, `last_checkout`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `_snipeit_digitized_dynamic_success_1`, `_snipeit_universal_intangible_info_mediaries_2`, `_snipeit_up_sized_foreground_model_3`, `_snipeit_vision_oriented_coherent_implementation_4`, `_snipeit_normal_re_order_level_5`) VALUES
(973, NULL, '856423498', 1, 'c64a918b-0047-390f-be94-5f2238ae690b', '2017-05-15', '1363.65', '43502413', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(974, NULL, '220690161', 1, 'd7007e28-1c81-396b-9efd-bb112340cf89', '2018-01-19', '1129.41', '16635519', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(975, NULL, '645904075', 1, '39f9de95-0644-312c-b2cb-73f554bd36cb', '2017-09-23', '2890.86', '39324084', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(976, NULL, '1509544771', 1, '78563b3c-8dad-34e1-abd4-66fd95e493d7', '2017-11-09', '2475.95', '27336782', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(977, NULL, '615850118', 1, '76de461f-f0de-3ad9-a67e-8e4d1bd23014', '2017-08-11', '1004.67', '39692747', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(978, NULL, '1122064772', 1, '40d1fe3f-9883-3d83-8c43-a214fe1df272', '2017-10-18', '1720.37', '22689077', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(979, NULL, '1296176292', 1, '65b7ab82-1d2f-384b-b8c6-10fdefb6223e', '2017-10-23', '2591.02', '30906822', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(980, NULL, '1507345772', 1, '1a178326-04b8-39b0-9334-585244adfb9f', '2017-10-20', '2185.83', '37385128', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(981, NULL, '1486733346', 1, '767b2676-92b0-3c08-8de7-1625b5e5720c', '2017-06-07', '1135.35', '3834929', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(982, NULL, '682078886', 1, '39d4361c-559c-342d-9e2f-ef2fc20d2fb8', '2018-02-13', '2771.63', '35739488', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(983, NULL, '606923955', 1, '70b3000e-3b6b-3f79-ac3d-416488f73267', '2017-11-25', '466.57', '36136395', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(984, NULL, '409802089', 1, '1626221e-3922-3135-b09d-a7c0d1b39e8b', '2017-12-17', '1677.09', '10878075', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(985, NULL, '278556521', 1, 'e6498a30-42a4-39e7-a5d9-b4f3b79984f0', '2017-08-31', '1784.09', '32925139', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(986, NULL, '738588411', 1, 'a7b787d8-0dc3-3f5c-ac63-c9b921af2ae8', '2018-03-15', '976.57', '24948998', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(987, NULL, '1320437664', 1, 'a431a46d-f108-3626-b009-1981ad319c71', '2017-10-09', '733.71', '23507662', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(988, NULL, '1391562317', 1, 'eda3d094-70e2-37df-b74e-99a85d739481', '2017-11-29', '2390.66', '23444971', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(989, NULL, '1168437572', 1, '564f6210-0e31-361b-901b-0d90253bd798', '2017-11-06', '1298.78', '35051663', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(990, NULL, '973183214', 1, 'ac61e206-bfc9-3c37-b376-48a4cfe6e1f6', '2017-10-28', '2211.80', '46078854', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(991, NULL, '1001066964', 1, '308aca33-6e8b-3803-a96c-59ac39c1a72d', '2017-05-22', '1522.15', '32745565', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(992, NULL, '665080940', 1, 'e562dcc5-e4dc-39df-91e3-30a2524e6185', '2017-06-04', '2599.93', '33386512', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(993, NULL, '764393785', 1, 'c355f2b9-53a4-3d6d-ba5a-2f7c69022d3e', '2018-01-18', '1223.33', '48481331', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(994, NULL, '1210306182', 1, 'cc5b5619-92dc-332d-9711-7f40b7ca5382', '2017-10-20', '2848.47', '41248912', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(995, NULL, '453781568', 1, '3d5cd536-6834-3614-b7a7-70bb373c824a', '2017-07-15', '2581.17', '4954719', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(996, NULL, '1073498893', 1, 'b9b32368-2705-354c-928e-848a2f11a293', '2017-11-03', '2841.97', '19209861', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(997, NULL, '76295599', 1, 'ea67257d-bd0b-3ce2-8c23-257a0ff1ea28', '2018-04-01', '2067.13', '29816574', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(998, NULL, '705362376', 1, 'ea992d16-db46-31b6-b56c-6dd59a158ff4', '2018-04-03', '692.26', '35632138', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:28', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(999, NULL, '849029146', 1, 'b5a062ce-b82a-3ecb-8cf0-5e75726de3f3', '2017-08-24', '2814.52', '7983520', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1000, NULL, '1082259304', 1, 'ef69c91f-4e64-36e1-80b0-f9097071be96', '2018-02-12', '2722.37', '22613067', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1001, NULL, '952179053', 1, '6470b89a-8d11-315d-be1d-5ff627516f77', '2018-03-29', '2638.07', '1874714', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1002, NULL, '231226913', 1, 'c00a7b88-1470-3f5e-986b-ac1a5014bd1e', '2018-02-03', '2424.94', '42982973', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1003, NULL, '1448834210', 1, '3ed46a12-48cc-31fd-8c9a-9cf35fc25bc5', '2017-07-14', '1294.10', '26308701', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1004, NULL, '81721393', 1, 'c4c27831-af0e-37a3-b76c-0ecf95ed1e45', '2017-05-27', '2273.50', '34095171', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1005, NULL, '718854118', 1, '09149cf4-6821-35f1-8c9e-cf4a9d223b43', '2018-04-13', '1821.19', '7383819', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1006, NULL, '693643682', 1, 'd3dc9e33-3984-3416-8588-299a94292dc0', '2017-08-09', '1189.04', '3608268', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1007, NULL, '682638903', 1, 'b742ccd6-928b-3b41-b8b4-4eee1d617149', '2017-05-22', '2442.97', '49876203', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1008, NULL, '748474073', 1, '82d2aadc-b3d1-3326-a72a-2d1a46c66b14', '2017-12-30', '662.16', '3001181', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1009, NULL, '1287508686', 1, '2e677558-d445-3cd4-8b30-e017c97f9bbf', '2017-10-23', '763.71', '36587418', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1010, NULL, '215126657', 1, '72cccaaa-18b4-38ae-ab46-8a50afb168b2', '2017-09-10', '1319.80', '1137247', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1011, NULL, '1434562084', 1, 'b0d79982-029c-3e4d-8326-73a9a26181c1', '2017-08-02', '698.38', '21704929', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1012, NULL, '1312489768', 1, 'c8795428-e22f-3408-8235-d209ee146732', '2017-06-08', '1603.38', '29843264', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1013, NULL, '649674328', 1, '835d713a-e199-3a34-9312-f560c31c5160', '2017-11-08', '806.71', '7272772', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1014, NULL, '242813787', 1, 'c7683359-1055-3d67-977c-449dd5a7432b', '2017-08-16', '2396.44', '35127795', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1015, NULL, '289791984', 1, 'cde0b093-e89c-3e80-b6ff-3858159a1d13', '2017-12-28', '1088.98', '45184560', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1016, NULL, '832303707', 1, 'e851be9f-1506-3820-916e-c443c456c14c', '2017-06-30', '496.44', '41442765', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1017, NULL, '564136574', 1, '35524ab3-29ca-3c15-add8-f7cb04dafbb0', '2018-02-11', '306.04', '39265521', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1018, NULL, '918443520', 1, '541d2615-0f3e-30dc-be9c-1c6fc79fd02e', '2018-02-03', '2750.52', '30859944', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1019, NULL, '483598999', 1, '46e01a9a-642f-326d-8973-a7e0c374a36e', '2018-01-16', '1287.40', '14476119', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1020, NULL, '1231776468', 1, 'd2c743a2-75f4-3f25-ac3e-eaa691f365fb', '2017-10-18', '338.19', '35132223', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1021, NULL, '700897159', 1, 'c52c3b3e-2ec3-3268-9fe5-05c4d195893b', '2017-11-04', '448.24', '31226350', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1022, NULL, '354599047', 1, 'c919b766-7fca-3d51-8c4c-4c74e2a7ce18', '2017-12-18', '1579.10', '17246590', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1023, NULL, '1186729892', 1, '9135f042-6382-3f93-819e-96d18c3b055f', '2017-06-06', '2205.91', '28536018', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1024, NULL, '1048932469', 1, '4020ddb1-abeb-396d-9202-841fd1f4bfc1', '2018-03-05', '1337.36', '33883725', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1025, NULL, '1478258753', 1, 'ca7ef712-07e2-32d8-b47d-fa88895fe2cc', '2017-07-27', '691.34', '31333307', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1026, NULL, '1455696690', 1, 'db102c91-3ddb-323e-94fe-c2f00042b92f', '2017-06-03', '2881.63', '30831219', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1027, NULL, '412894216', 1, '35781df2-17a2-3acc-8f76-3ec76f1c31be', '2017-08-15', '994.70', '17084606', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1028, NULL, '894015640', 1, '61abc857-a9d7-3acf-bb7e-dafd39f0e675', '2017-07-16', '2115.65', '44439881', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1029, NULL, '1416975867', 1, '414b06e3-0be4-38b5-ab6d-1162a40f3e4f', '2017-12-17', '1053.87', '39229322', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1030, NULL, '218723320', 1, '4c9ec217-153e-3e6e-a3da-3ccaad0e56c7', '2018-02-18', '2775.47', '44180209', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1031, NULL, '216872339', 1, 'ced2035f-e229-348a-b11a-fde561c98072', '2017-09-13', '1875.62', '32935377', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1032, NULL, '516182550', 1, '3149da34-5d50-3a7c-a15f-8ee9517f6c40', '2017-12-29', '301.91', '18230730', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1033, NULL, '751058768', 1, '05f681f9-bd53-3824-abed-8c8887641858', '2018-04-26', '1260.25', '43210886', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1034, NULL, '96998484', 1, 'ccf26c36-f885-3084-9bb4-015f119d643c', '2018-01-08', '1411.34', '33959397', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1035, NULL, '1457074308', 1, '06f23e32-368f-3bf8-abbc-848f6914a7da', '2017-11-14', '1420.17', '29730243', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1036, NULL, '1420383947', 1, '8cdef7ba-f71f-30e0-98c5-bfa28ef76b6a', '2017-09-06', '1320.66', '40529320', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1037, NULL, '1214829025', 1, '22a5bf07-a5dc-3db4-9182-1cdbf75bdbc9', '2017-08-29', '1910.19', '9512644', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1038, NULL, '1032280844', 1, 'a753ab9a-cb81-3c69-80f1-b80f83c460f2', '2018-05-09', '1347.43', '2737534', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1039, NULL, '1088771256', 1, 'b0cc714b-56bd-33a0-a0f3-969123267ff8', '2017-07-24', '1727.77', '46020574', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1040, NULL, '1340706922', 1, '1ef0a7a0-2aba-31fa-8c8c-71b9edd3c346', '2017-10-11', '886.96', '47358586', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1041, NULL, '1451244614', 1, '51b90ef6-b42e-3a25-9977-ddc870982732', '2018-02-19', '339.25', '43897354', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1042, NULL, '1303470977', 1, 'ddd897ce-fc88-32ac-af76-963ed7b28d7b', '2018-03-22', '2945.78', '30712918', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1043, NULL, '940960861', 1, 'f42a2d7f-c5db-324c-8d6a-c5b5482b8865', '2018-04-03', '2291.80', '25244129', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1044, NULL, '968575552', 1, '3d76b14c-338d-369a-9f79-5389fb157f2b', '2017-06-18', '703.90', '46625613', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1045, NULL, '767094571', 1, 'fb83ec46-5287-3e19-b61c-350b9dce294a', '2018-03-24', '1025.71', '21550478', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1046, NULL, '102867441', 1, '0e12fcfd-f6e9-3d16-906d-d2a3561b5af4', '2018-02-01', '1733.61', '22276330', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1047, NULL, '167798283', 1, '1e96c8a8-da47-3cd0-861b-5f8f64e6428e', '2017-12-29', '1837.62', '31786051', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1048, NULL, '1279651366', 1, 'c0ab63af-4d85-3e3f-874f-e46f009250df', '2017-10-27', '1621.12', '27720826', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1049, NULL, '845956730', 1, 'e10149d3-3f2f-3b4d-9cb3-1b323b4e52ff', '2017-08-21', '738.71', '42020159', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1050, NULL, '843336059', 1, 'e306dcfa-b258-373a-a73b-67f4a525ccbf', '2017-12-17', '867.11', '47959972', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 2, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1051, NULL, '704847384', 1, '15ca3153-9a54-301c-9f67-87329a1e897f', '2017-07-18', '2539.64', '46187872', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1052, NULL, '119050429', 1, 'f43634d4-a11d-3ccc-a693-d8e429a7f118', '2018-04-15', '1098.40', '19858995', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1053, NULL, '797756158', 1, 'a3bf5278-0e4b-3066-99e5-e2cae437dccf', '2018-03-27', '2152.68', '17973658', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1054, NULL, '11554117', 1, '93980494-9424-30c3-aa9a-f9ae48c58d2e', '2017-09-05', '2246.40', '13410947', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1055, NULL, '1091116548', 1, 'a59149f3-1b04-3ecd-b224-f2b0729871ce', '2018-04-04', '2377.73', '40377025', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1056, NULL, '56562871', 1, 'c64844a1-b88b-361a-9a15-e5371603ae73', '2017-09-17', '953.75', '8642012', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1057, NULL, '1473826773', 1, '7f8b31ca-1ab7-336a-9071-ca6a45e0093c', '2018-01-18', '2344.88', '48994609', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1058, NULL, '502157133', 1, 'bfce9a74-d6a3-3961-87b3-3b436fddb931', '2017-08-07', '1770.81', '26823160', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1059, NULL, '171328534', 1, '06a020e8-178e-39d4-bb94-3875f508aa89', '2017-08-05', '771.52', '41484228', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1060, NULL, '681395480', 1, 'e6d5b7e5-f970-3d1f-a810-cf8b523a85d9', '2018-03-12', '1872.86', '26503886', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1061, NULL, '350639291', 1, '9cb1e5ab-ea6e-344e-b2fe-ba54ee6a3835', '2017-08-21', '916.89', '18294030', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1062, NULL, '316097768', 1, 'a2b740a8-e27b-3080-92a7-8968575321f5', '2017-08-15', '2389.73', '8312324', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1063, NULL, '57796084', 1, 'ce8b15ec-fbc3-326d-9ad3-9dfe1ab9b0e6', '2017-11-25', '2558.55', '18616229', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1064, NULL, '509210282', 1, 'a101fe44-059c-363d-99a5-19af96da3f10', '2017-11-12', '2889.09', '30070797', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1065, NULL, '1135107018', 1, 'b5952283-7734-311c-8087-c0817506015c', '2018-04-27', '484.79', '15447681', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1066, NULL, '1465771064', 1, '01ecfe91-e5af-3b1d-a2be-609f0bc2ed2c', '2017-11-13', '1227.43', '9261995', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1067, NULL, '491705799', 1, 'e8cc8cc3-2e26-3d53-bdb8-be380a4803c4', '2017-12-19', '2019.18', '39932535', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1068, NULL, '1090951739', 1, '7ac9be51-ffee-3684-b44c-9cd63fc921f8', '2017-10-25', '2928.86', '43552906', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1069, NULL, '285674208', 1, '6baaa471-5633-3ea2-9b83-30d994d5677a', '2018-04-28', '1246.59', '42441606', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1070, NULL, '174180348', 1, 'd296c78f-0812-3f0b-969a-c270c201a10c', '2017-07-08', '1062.00', '23522529', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1071, NULL, '1288425529', 1, '322c15f4-cb9e-3372-918e-1fd84a968af3', '2017-09-09', '1991.84', '42486300', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1072, NULL, '1519905870', 1, '374c91fb-9469-3484-a5eb-f20952088791', '2018-01-01', '2849.87', '31311704', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1073, NULL, '754931793', 1, '84b34ab5-4ef5-3fe5-97da-ee54c5d9c048', '2017-09-19', '1496.31', '14600932', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1074, NULL, '401369847', 1, '63b97e80-75d4-3b54-871f-f0630814dc04', '2017-06-01', '701.02', '5284883', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1075, NULL, '1076978842', 1, 'b864dc6e-86ba-3001-8f4c-ded4891d7523', '2018-04-18', '2333.02', '8228174', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1076, NULL, '537591776', 1, '7aa58f31-5871-35e6-8ea3-550a2e812167', '2018-01-18', '2551.96', '1853227', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1077, NULL, '1502450534', 1, '5f2913c0-053a-3bf9-8bb9-36565b4dfc0a', '2017-07-18', '1527.63', '30594130', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1078, NULL, '219195109', 1, '3a65e5c3-f191-3312-91aa-23c75c84c75c', '2018-01-27', '377.21', '39678305', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1079, NULL, '498858757', 1, 'fd06838a-84ca-3855-ad14-cc60fc176f84', '2018-04-05', '368.39', '11032569', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1080, NULL, '1123259557', 1, '2f628be1-31d1-390f-ab56-128a76f10b1d', '2017-11-21', '1592.12', '5059323', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1081, NULL, '337539350', 1, 'f3680485-b812-3c4d-aff1-076e16dce749', '2018-04-07', '1013.74', '38031672', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1082, NULL, '797679074', 1, '018db69e-4660-354d-bd0c-25110ee927f9', '2017-11-01', '2483.07', '30708567', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1083, NULL, '766725046', 1, '40e223dc-5746-369e-bb07-76459e45f36d', '2018-03-08', '2109.88', '32007487', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1084, NULL, '461275038', 1, '67f0906a-08e4-3dff-ba29-3d4595e6754a', '2018-01-12', '2772.09', '39686262', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1085, NULL, '492247109', 1, '672c62ea-9841-37ff-a8ca-ce69d1478531', '2017-06-24', '595.09', '42793990', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1086, NULL, '234011318', 1, 'de051463-e853-346e-afa7-b27bc84960bf', '2017-12-25', '869.80', '49634587', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1087, NULL, '296698241', 1, 'db95bca5-b57e-37c5-bc71-37ae700fd52e', '2017-10-19', '2135.61', '6457916', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1088, NULL, '800726615', 1, '0c7e469b-0ce6-3320-90f8-afab228c637d', '2018-04-10', '2822.19', '26014529', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1089, NULL, '1153717666', 1, '7e8b2404-deab-3774-a489-a8e84f6433b1', '2018-03-31', '934.62', '4943460', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1090, NULL, '1350314037', 1, '80c75193-e915-3717-adba-9ca3b040cd93', '2017-11-09', '1468.78', '12202916', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1091, NULL, '433139298', 1, '8005769e-334f-3073-8721-9686c323cd7c', '2017-08-10', '1832.84', '23193026', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1092, NULL, '1267241728', 1, 'a6f92452-16d8-3798-82f2-c45904f44587', '2017-11-12', '2126.52', '48806865', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1093, NULL, '1019168335', 1, '83828c48-6954-325a-95cb-7700554437c5', '2018-01-23', '459.40', '7093483', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1094, NULL, '311195280', 1, 'cbe0a9bf-1bf0-3fc0-9dfe-ae521a79862c', '2018-02-12', '2514.72', '38954226', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1095, NULL, '681828899', 1, '6cf62ca8-c304-377d-8a7f-a5b10fefe5e5', '2017-11-08', '1827.00', '46188974', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1096, NULL, '601271621', 1, 'f22b39bb-7990-376e-87f0-07d64087ebf1', '2017-11-19', '601.95', '40635435', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1097, NULL, '1489250168', 1, '9815e834-f12b-30d8-8b37-ff95c4f16373', '2018-03-31', '487.71', '18969370', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1098, NULL, '110875352', 1, 'bf926170-d672-3637-8848-c7a967922881', '2017-12-16', '964.89', '5929804', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1099, NULL, '1384920992', 1, 'c4d9c49a-45ea-3a25-a3c1-2144c4071f29', '2017-12-17', '2186.84', '5690228', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1100, NULL, '598470333', 1, 'c8e66b2f-62c0-3b6f-9b7b-e0e4fba4ad34', '2017-07-31', '1678.94', '49697265', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 3, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1101, NULL, '1030761511', 2, '026ce6da-0298-39e8-ab7d-53b34fbdd264', '2017-11-05', '723.86', '15568586', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1102, NULL, '438856501', 2, '3d1b4e13-267d-35e8-bea8-1c2d8b50e6a8', '2018-02-16', '1994.50', '34239412', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1103, NULL, '581853779', 2, '31e68b9e-6731-3169-ae5b-2c7988e147e5', '2018-03-07', '2872.79', '44843655', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1104, NULL, '1423377375', 2, 'e1b278c8-f684-3bb6-af04-196eab34bbb1', '2018-05-03', '1522.91', '20590477', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1105, NULL, '963070359', 2, '155e62b1-88f7-3102-87ba-6c6f320d2ef9', '2017-08-29', '724.11', '11883736', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1106, NULL, '295203645', 2, 'f852b3de-ebbf-33b5-91ac-3c34599c4e52', '2017-08-17', '1588.57', '27671373', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1107, NULL, '1010885182', 2, '36b1d720-accb-3047-9575-9d783a9ee4d0', '2018-01-29', '2057.29', '20986895', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1108, NULL, '943474914', 2, '2f63dfa8-4e11-3a99-9986-012416f23615', '2017-11-02', '1397.23', '23372890', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1109, NULL, '610909984', 2, 'f7f16672-66ce-30f1-a71b-b6d555d488ea', '2017-10-26', '1554.54', '11466071', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1110, NULL, '731460565', 2, '9552dcc2-d1a8-3036-88b6-4d42030a6953', '2017-08-08', '562.73', '5026094', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:29', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1111, NULL, '1434901898', 2, '546f013a-6975-3473-9a9c-ca4f0bde7174', '2017-12-05', '1003.40', '2218389', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1112, NULL, '486942113', 2, 'de4031ac-1295-3d3f-b7e8-1cc23e01ab53', '2017-09-01', '2040.58', '25830589', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1113, NULL, '903896314', 2, '82e45683-4345-38e4-bf5e-c793057225f7', '2017-05-26', '2110.61', '24116320', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1114, NULL, '539675702', 2, '34e5f7c6-7e5d-3543-969f-2e7f56d5f176', '2017-12-04', '982.14', '31776572', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1115, NULL, '1464996843', 2, 'f366d5d4-3ded-3023-86e1-f8ecc42a4505', '2018-04-19', '498.39', '48052091', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1116, NULL, '1420870324', 2, '3296f55c-b8cb-3610-a85e-46a06c98d788', '2018-05-15', '1231.74', '17631947', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1117, NULL, '1326097745', 2, 'd8a3c398-7b37-37f2-9ec4-87e7a897c73e', '2017-05-17', '2981.48', '35086715', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1118, NULL, '45874764', 2, '18b9620e-f787-315c-be89-11ba076ae2fd', '2017-11-03', '1532.59', '46970627', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1119, NULL, '59623761', 2, '1b2ddba0-3546-35fa-9c7d-2b74129d0528', '2017-09-25', '1916.84', '4594340', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1120, NULL, '213418775', 2, 'e05d31ff-5a20-3072-8f20-0fa867b1eba1', '2017-06-20', '756.47', '17384742', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1121, NULL, '266484903', 2, '5eb0488e-5640-304e-abc9-796469a05898', '2018-05-13', '670.57', '18722177', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1122, NULL, '25918810', 2, '621657a7-580e-318e-9b64-21803f42dfa0', '2018-05-12', '1042.08', '49953872', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1123, NULL, '1184182733', 2, 'bb059308-b516-388a-9080-7dd8df49e900', '2017-05-25', '971.74', '45340303', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1124, NULL, '1330227926', 2, '351155f0-5189-30fa-89b0-f5d1d34963df', '2018-02-03', '2995.61', '39335418', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1125, NULL, '578213347', 2, '7916480e-bb21-3faf-a99c-6db0f4dda0b2', '2018-02-27', '466.51', '25187938', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1126, NULL, '65526245', 2, '5eb7b5e4-b29a-3db0-88eb-7b7e8030bdea', '2017-12-15', '2955.41', '34105335', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1127, NULL, '883466090', 2, 'c49a90ae-a3db-34c0-97ea-a898d35afc3d', '2017-06-10', '1102.33', '32293511', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1128, NULL, '722267286', 2, '6669109e-e801-3b97-b182-c43d896e4f8e', '2017-12-17', '2642.28', '13393076', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1129, NULL, '1017159262', 2, 'bee7452f-b22c-382e-acf4-95fe2f029844', '2017-09-17', '2569.79', '25472644', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1130, NULL, '529509605', 2, 'c30a8ecf-6e90-3dff-8cfe-530bb3ef2463', '2017-06-16', '1626.18', '48901608', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1131, NULL, '1420228745', 2, '69407d01-c7c6-3ae1-bd3f-7e4f62cecd45', '2017-08-15', '676.82', '3518300', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1132, NULL, '626728669', 2, '8a7b2d15-427e-31ab-b693-135046adc884', '2017-09-20', '1408.44', '25572690', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1133, NULL, '941950117', 2, 'cb34cdd0-f7db-3473-87bb-42d88ad137f4', '2018-01-11', '1495.05', '33780304', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1134, NULL, '1104127612', 2, '9cefd329-9a4e-3029-85c7-f27f76791d57', '2017-11-09', '848.31', '42116978', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1135, NULL, '1273213961', 2, '8d1c9941-9aeb-398e-911b-dc5f09402c4a', '2017-06-02', '2803.46', '32202263', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8');
INSERT INTO `assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `accepted`, `last_checkout`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `_snipeit_digitized_dynamic_success_1`, `_snipeit_universal_intangible_info_mediaries_2`, `_snipeit_up_sized_foreground_model_3`, `_snipeit_vision_oriented_coherent_implementation_4`, `_snipeit_normal_re_order_level_5`) VALUES
(1136, NULL, '75963379', 2, 'e3a94809-4b05-37af-adaa-d472c012205f', '2017-06-12', '2976.13', '42327831', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1137, NULL, '1500812021', 2, '0c8cdcf8-5078-3184-843d-865e208615f6', '2017-11-19', '1262.22', '40364994', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1138, NULL, '912599692', 2, 'ecd529e9-5303-3c0c-8587-9e76e046ee35', '2017-08-30', '1153.32', '44473294', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1139, NULL, '294489902', 2, 'e8814143-16b6-3fe4-ad50-b88d99b26e86', '2017-10-21', '1274.33', '9157706', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1140, NULL, '1294617139', 2, 'df338480-acf2-3313-9c60-d039a981b683', '2017-10-13', '359.67', '2090665', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1141, NULL, '320282048', 2, '7936879a-accc-31cc-a153-46dc11efb2c0', '2017-08-17', '1844.18', '28987115', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1142, NULL, '1344571448', 2, 'bf45a946-20ac-3f6a-a872-50a560f2fc3a', '2018-03-26', '503.29', '33291065', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1143, NULL, '26044292', 2, '6177fcab-f4a1-3e1a-ba56-2f44cb6b4f35', '2018-03-18', '1462.49', '15429522', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1144, NULL, '821689409', 2, '0829bf98-d667-3946-8bd0-56baa9fe4fdb', '2017-10-31', '1740.96', '12240005', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1145, NULL, '722013318', 2, '091292fa-2cfe-3a3b-9adf-790a1f2daa82', '2017-06-23', '2438.09', '34064773', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1146, NULL, '651660033', 2, 'ed75fba4-e01e-3ca8-b125-dd9ec3bab58c', '2017-06-09', '2669.91', '40823465', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1147, NULL, '365818752', 2, '2ddf5f48-632a-391a-88e4-1e84314cfcf3', '2018-01-10', '2483.94', '16774485', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1148, NULL, '1271510005', 2, '200479f0-d0c2-30e4-a698-2bb87d873c36', '2018-01-09', '1448.69', '12430278', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1149, NULL, '931382910', 2, '423816f2-ce82-3292-af8e-1b36b66934c3', '2017-05-18', '1571.85', '19161755', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1150, NULL, '66315038', 2, 'f041f654-c77c-32e1-8870-2fdd8e11c637', '2018-05-03', '2474.48', '22337847', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1151, NULL, '1475239659', 3, 'e46de4ac-2f9f-38a3-8d44-a149f576c744', '2017-10-09', '1734.84', '5800457', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1152, NULL, '497636777', 3, 'e6d15d35-2fb2-3010-aea6-aedfd661bbd3', '2018-01-29', '2424.14', '26351918', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1153, NULL, '818827478', 3, '6a50706d-a691-302e-b79f-717c82085f92', '2018-03-23', '2945.59', '15529436', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1154, NULL, '39433243', 3, 'b280eb06-14d6-307b-b01c-a8c1d2295c42', '2018-02-24', '370.68', '7352643', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1155, NULL, '1191527332', 3, '3f174d1e-4942-38ba-aaae-313460dfafaf', '2018-03-26', '2140.92', '17197662', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1156, NULL, '1178993113', 4, '0973291c-b8ea-3d6e-a965-80f84417ad35', '2017-05-21', '1028.97', '16637000', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1157, NULL, '1099453712', 4, 'dbb3434e-cba8-3a7f-bfe9-8329dba7b3c1', '2017-07-05', '2297.95', '39402815', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1158, NULL, '1221087180', 4, 'ad3d625c-a35e-3d0d-be03-fbbe96cf23f9', '2017-06-06', '1032.38', '21127572', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1159, NULL, '1422686467', 4, 'a7e0a016-2b72-36c9-bc9c-0454867ef185', '2018-02-10', '2819.10', '5913916', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1160, NULL, '1448206187', 4, '8cf30065-fd2f-303e-8c1f-725b1758837e', '2017-05-28', '2815.77', '28839864', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1161, NULL, '740120564', 5, 'dd7d476c-65df-3e47-b628-da6cabc2cebb', '2017-07-24', '2429.93', '32346501', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1162, NULL, '637439688', 5, '2b8a3bdb-4526-3cc4-84f2-d095ade7db34', '2018-01-15', '809.76', '37632712', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1163, NULL, '1214936629', 5, '8ded6595-e29a-32c3-9dde-2d41e613de49', '2017-05-29', '1351.39', '4013688', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1164, NULL, '341535862', 5, 'c3f3c22c-d0dc-36ad-80e9-278ab027e454', '2017-10-12', '1605.30', '21082839', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1165, NULL, '345384616', 5, '17d5038c-ad59-38cd-bc06-dc8f10e0a619', '2017-06-21', '1018.68', '10111722', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1166, NULL, '663246951', 6, 'bca5b154-2072-32dd-8ab9-786822b1f797', '2017-09-30', '2740.92', '19327817', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1167, NULL, '7273110', 6, '1c5136a1-2b8c-3ecb-9e51-64eb64e3521d', '2017-12-30', '2765.46', '31708918', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1168, NULL, '678106083', 6, '91f6816d-df46-3f10-a390-52ec357647d0', '2018-02-16', '2180.97', '4641604', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1169, NULL, '1456015909', 6, 'f8ec74bc-ad38-327f-908e-3f568396059d', '2017-06-26', '858.09', '13320602', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1170, NULL, '422171183', 6, 'fb9b9228-e73a-31cd-b0b4-e6977fa8fb79', '2017-06-24', '2280.84', '31119251', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1171, NULL, '1466061262', 7, 'f885d7d4-92a3-370a-80d6-337a9beef5bc', '2017-12-14', '2050.09', '46067265', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1172, NULL, '676509631', 7, '245d01b7-c7eb-3fe6-be86-89cce60d8674', '2018-03-02', '593.73', '14991048', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1173, NULL, '701143525', 7, 'bc1adceb-2e27-3add-ba6d-12bc0dd69618', '2018-04-30', '2493.22', '31873024', 9, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1174, NULL, '1442047327', 8, '0cecde65-9b1f-3e7f-b790-fbe872a8c0fc', '2018-02-22', '2183.55', '30169454', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1175, NULL, '260751083', 8, '0ae093bb-3e45-331b-8f84-959d1521e602', '2018-04-21', '661.13', '38028484', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1176, NULL, '770718544', 8, '1041b82b-2b8b-30fe-bf8a-aeeda71cc1c7', '2017-12-03', '2831.84', '39873429', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1177, NULL, '1101234904', 8, '23cde382-a47a-31b6-933e-bcf4cf898dbf', '2018-04-15', '1543.58', '13942061', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1178, NULL, '576644472', 8, '18ab966e-c979-3738-8aef-3088cb5600e9', '2017-12-27', '1094.81', '21476459', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1179, NULL, '26920054', 8, 'd7d81e3f-c727-34cb-b448-c86e5b111d2e', '2018-04-12', '1077.30', '7248620', 10, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1180, NULL, '11038003', 8, '93d03785-e922-391c-80e8-e23ab0308d34', '2017-05-24', '819.05', '1346712', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1181, NULL, '73331310', 8, '386bea6b-951d-3886-acb7-d354fe3ef69c', '2017-05-21', '2076.92', '39228862', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1182, NULL, '1369456549', 8, '17f8d4cf-5dfb-3670-8449-cc440d954e59', '2017-06-26', '770.27', '43731579', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1183, NULL, '694717253', 8, '14636601-5c92-3e3c-8025-cc1fcc47e730', '2018-01-30', '2877.48', '28361203', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1184, NULL, '1445307718', 8, '8d3bb1f9-a7cc-3ee0-8848-09ea6caafe2e', '2017-10-22', '659.16', '45426169', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1185, NULL, '608519840', 8, '2433c60e-8aed-3e5e-9ae0-7d6001912e44', '2018-01-11', '2805.17', '19215608', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1186, NULL, '1183230417', 8, '404f2f7d-6cdb-358e-a648-f16bd940cf98', '2018-01-23', '499.85', '43904694', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1187, NULL, '1132279396', 8, '2ecfd6e8-ceb6-3713-bb55-054f2e781f91', '2017-09-28', '884.62', '14828040', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1188, NULL, '833736122', 8, '097fc668-a7cc-331d-b5e6-ee3cc817e4b0', '2018-01-04', '1834.24', '44005788', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1189, NULL, '121841569', 8, '0710d4ec-ae40-36b3-9b51-725fa9abee9f', '2017-12-19', '868.77', '18388320', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1190, NULL, '158562571', 8, '38b6ef0c-c8cd-302e-8419-a301771e1201', '2017-06-29', '1792.96', '2757944', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1191, NULL, '345611694', 8, 'c50c13fb-16a5-33fe-a896-8f2a6d1a821c', '2017-10-19', '1533.78', '5303119', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1192, NULL, '1125964654', 8, 'daff43d1-8135-360b-baf7-221434b0d5a4', '2018-03-02', '1016.81', '8936514', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1193, NULL, '932088634', 8, 'cf2dfc84-12fc-322b-a84f-e67ecab144e4', '2017-05-20', '1402.21', '41280110', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1194, NULL, '393839539', 8, '3ace956a-5efe-3db3-9023-2f5b2a90ab3d', '2017-06-12', '1183.46', '21295753', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1195, NULL, '657783835', 8, 'b911c35e-7d69-3c98-9bf8-cf4b8a4272ad', '2018-04-25', '2607.53', '6697141', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1196, NULL, '1043539095', 8, '20a40cba-6481-301a-a809-2c921ec52a40', '2017-08-26', '959.05', '27704852', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1197, NULL, '343881864', 8, '076da374-dbea-3b90-9c1e-56b14a26cc85', '2017-07-19', '2469.94', '27182548', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1198, NULL, '58504040', 8, '99e30a50-158c-35fb-ae62-94d2b7178926', '2017-05-29', '1007.59', '17068023', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1199, NULL, '1213240098', 8, '7df116fd-3312-3007-a040-03912ecb46e6', '2017-06-19', '1868.34', '29867366', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1200, NULL, '502473599', 8, '5cbd49e4-3683-3ec5-9050-364bfa4155f1', '2017-09-11', '469.89', '14850906', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1201, NULL, '457001763', 8, '30211d3c-3f00-3bac-aac9-1e10638322bd', '2018-05-13', '1960.25', '32956522', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1202, NULL, '233289129', 8, '9d1ed6b2-95a6-3d6f-9f02-3aaa1fd76eb8', '2018-02-25', '2584.20', '8046830', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1203, NULL, '152237081', 8, '4dc9751e-4d5f-3fbe-86c1-0591d0113034', '2017-07-25', '1944.22', '46048453', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1204, NULL, '432989267', 9, '9bdac3ae-2723-31d2-b78e-b79ed930acd3', '2018-03-10', '1780.99', '29363101', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1205, NULL, '905414995', 9, '84eab274-2c8d-3531-83e2-e3d31c1aaafe', '2017-09-26', '845.52', '25541765', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1206, NULL, '537418020', 9, '7b0c60f3-f5cc-33ca-b14e-8db1df6c9776', '2017-11-18', '1815.70', '21960693', 8, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1207, NULL, '1384209807', 9, 'ca2cde9c-86a9-359b-8d19-affa1e017974', '2017-10-28', '1379.85', '15530145', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1208, NULL, '270549403', 9, '8050ca3d-cfe9-3421-a6d6-44ddbe7a7021', '2017-12-30', '2570.55', '31940249', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1209, NULL, '943572608', 9, 'feb4ce37-40ac-350c-80ff-5e595ec1a418', '2017-07-23', '495.70', '46785419', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1210, NULL, '963581713', 9, '1c72509c-eca5-3594-a56e-13dde7711695', '2018-02-07', '2639.54', '29469792', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1211, NULL, '861506289', 9, '31d82494-b10f-38a6-9425-3ec61b2a4430', '2018-01-14', '1832.52', '27633211', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1212, NULL, '122063701', 9, '89b11e96-0675-328b-87bd-db3e4168dde9', '2017-06-09', '553.63', '16670914', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1213, NULL, '986835274', 9, '0ebb6762-791f-3ece-8895-6f21d8bb05e6', '2018-01-08', '2907.20', '24357987', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1214, NULL, '1156362299', 9, '39a474c4-4a81-323c-ab43-5dc52b4a6e9a', '2017-10-28', '2557.57', '25380222', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1215, NULL, '13117562', 9, '30cbef60-71df-3b83-8d44-a8d11e691e17', '2017-10-01', '539.18', '18493578', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1216, NULL, '854229033', 9, '660d7cab-8e6f-38cb-9292-8deab7424c31', '2017-06-13', '1504.34', '1097558', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1217, NULL, '753779913', 9, '2b3f48ae-69d4-3bd3-8f02-23ee1f3475dd', '2017-09-17', '1532.34', '44704256', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1218, NULL, '646770268', 9, '396547d5-d12b-31a1-a274-175cee50a860', '2017-05-17', '2987.96', '38675233', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:30', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1219, NULL, '412048855', 9, '4a2c44e1-30e4-3daa-b4cc-8c4880e65d02', '2017-08-12', '1710.36', '16268867', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1220, NULL, '723278434', 9, '19a54a92-f5e3-3dec-84a2-cbafaba70a1c', '2017-06-13', '2572.17', '45038602', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1221, NULL, '107442145', 9, 'e2721993-7046-3c33-bfe8-68617b2e2bb2', '2018-05-08', '1244.68', '16191252', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1222, NULL, '761236392', 9, '9886dff2-b9ba-35d4-8ace-241951e6cc55', '2017-05-23', '1047.52', '42378117', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1223, NULL, '850010265', 9, '827d86db-957c-382c-b19d-423cb6a74357', '2018-01-02', '2701.61', '33863627', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1224, NULL, '997110025', 9, '1119e911-29b7-312a-8c59-a2664a5b7959', '2017-09-27', '1936.37', '24570122', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1225, NULL, '1432701435', 9, 'd561a1bf-01ec-34e2-8bae-0ac2810e4a8d', '2017-07-12', '735.42', '3230020', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1226, NULL, '601442992', 9, '51369f6c-3a89-3374-8df8-83ba33dbf695', '2017-10-05', '578.40', '14259061', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1227, NULL, '1283597158', 9, 'daa18650-8ee9-3466-b6d2-696c351f2702', '2017-08-26', '597.84', '43155870', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1228, NULL, '1451470274', 9, '56c81e48-6f25-3a20-840b-96ed156a24eb', '2017-11-17', '934.73', '11909006', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1229, NULL, '771078016', 9, '876204aa-11d0-3fb5-bfd9-b3e1e3ebe20a', '2017-09-11', '301.99', '25551916', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1230, NULL, '342040877', 9, '39871323-320c-37ff-a11e-ac2b089fa5ac', '2017-07-28', '1501.30', '32190946', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1231, NULL, '231994034', 9, '8500525e-ffce-33d4-9168-5b992f2c4351', '2017-12-25', '937.88', '39639367', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1232, NULL, '726074345', 9, 'c3d0be01-3783-369a-814e-edfa1119dd28', '2018-03-03', '1735.04', '45943133', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1233, NULL, '1511757878', 9, '58a91cbf-24c7-33d4-8f4b-ba48b286e526', '2017-07-11', '1093.08', '26501036', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1234, NULL, '864481164', 10, '0ce16d60-2b60-31a5-ab4d-ee170d3c4e0a', '2017-10-01', '1951.58', '2376530', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1235, NULL, '854154927', 10, '0bfaa811-2005-3312-84f3-f62dc1c26c15', '2018-01-24', '1720.21', '36691471', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1236, NULL, '958571733', 10, 'ea4457f4-1700-3998-9552-592b71f7ef28', '2018-04-20', '1725.35', '12477747', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1237, NULL, '1112432782', 10, 'd67b4850-d4e4-3647-9981-ede76475a4ba', '2018-01-01', '1945.95', '32144987', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1238, NULL, '83727869', 10, 'c31ce229-6cd5-326b-a9c2-e5e95be329f7', '2017-12-22', '1964.97', '46587175', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1239, NULL, '977769339', 10, '5ac40ba4-7895-38cf-8ce9-2ada7ebd68b8', '2018-01-29', '1684.47', '39737574', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1240, NULL, '1003259845', 10, '6a0fb9b9-f5a0-33c5-9914-041d1e196c54', '2017-11-27', '978.87', '5529460', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1241, NULL, '1085988604', 10, '2fd01de1-8517-374b-847c-0cca6d5b7b61', '2018-02-22', '1671.71', '12800531', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1242, NULL, '296673995', 10, '80bc1ba4-8491-34b6-b6c4-136e5aa038ac', '2017-06-13', '727.09', '8177149', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1243, NULL, '330090359', 10, '1e9dae8b-43dd-328d-8eee-a4f96ed8d40c', '2017-12-15', '2733.93', '13055492', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1244, NULL, '1487921616', 10, 'e9650fa5-cca3-3948-b765-ff626157031c', '2017-09-21', '1052.05', '5333086', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1245, NULL, '1450958471', 10, 'df9e7a74-d20c-3dab-bad4-225e029fc25b', '2018-04-05', '1483.29', '27144599', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1246, NULL, '1185171404', 10, '6964051e-5cc9-3c90-a6f9-49378296ded4', '2017-05-19', '687.82', '26785220', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1247, NULL, '1290299909', 10, 'ae2cf8f5-29fe-359a-8861-8cedc49a9227', '2018-01-31', '2811.83', '30991273', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1248, NULL, '986030246', 10, 'c0069fa6-a7bb-30f1-8ec1-8025a61c1229', '2018-04-24', '847.50', '10194147', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1249, NULL, '1465391537', 10, 'd5b6e0f3-26ce-388a-965a-a8f11d47e759', '2018-03-13', '2803.90', '31275945', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1250, NULL, '1174102434', 10, '74265fd8-eb30-3b10-95f4-42b1b143e98d', '2018-02-25', '769.00', '6743088', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1251, NULL, '319354990', 10, '2179e110-9543-3298-9e0b-ad5cbb762322', '2017-07-27', '2795.74', '7854574', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1252, NULL, '1475773629', 10, 'db703b28-d97b-3b90-8f16-2c2af9a67d96', '2017-07-03', '1647.72', '6462582', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1253, NULL, '1375580283', 10, '91fb8195-6cc9-39ff-8c61-7b7895a93808', '2017-07-28', '2393.59', '33933136', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1254, NULL, '490318900', 10, 'a7baf0cb-8a8d-3a49-a8be-532d868363c2', '2017-11-08', '2343.96', '45676627', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1255, NULL, '852286060', 10, '74d1a79a-7a40-39d2-a7ff-5ddc549243a9', '2017-12-09', '1531.57', '47846753', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1256, NULL, '1058862473', 10, '14179525-195f-382d-a815-5234e1f2166f', '2017-12-15', '2971.36', '28122937', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1257, NULL, '580008246', 10, '24443e6b-d29f-3635-9a80-79076d754676', '2018-03-06', '941.38', '36887328', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1258, NULL, '1218893949', 10, '885fd760-9b82-3388-81d7-17148e52fa09', '2018-01-08', '2808.31', '2501932', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1259, NULL, '156121268', 10, '7f3e420d-0247-3fc2-b3cd-80981ca66ea0', '2018-01-19', '1992.32', '44047998', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1260, NULL, '1498259385', 10, 'd40f083c-2a50-35e3-b362-a57574e2ce8e', '2017-08-27', '1337.38', '37210912', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1261, NULL, '1187333664', 10, '7f59aaa9-2199-3f44-b42f-800b0dbc3fc3', '2018-01-15', '2256.36', '38073716', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1262, NULL, '651506937', 10, '2e8e951d-524e-3fbf-b03b-cc9242e1c135', '2017-07-10', '1046.56', '12660528', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1263, NULL, '1444840943', 10, 'dd83e1dd-5e85-31e7-a304-33ce38f51ce5', '2018-02-21', '2680.33', '41061263', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1264, NULL, '688511230', 11, '3d9db423-2095-36e7-840b-b34de0107af0', '2018-01-11', '811.74', '40442180', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1265, NULL, '652429456', 11, '42019f14-bd10-36ef-8048-a86e113400c3', '2017-07-18', '1647.94', '16646808', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1266, NULL, '1271555712', 11, 'ec801a5e-4151-3afa-ac3d-af8553c53c2a', '2018-02-17', '1175.94', '20222036', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1267, NULL, '532536594', 11, '697b1e9a-5511-3ab1-b0ab-66c786701628', '2018-04-03', '1573.06', '46773041', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1268, NULL, '1068074194', 11, '6e94f26c-4071-3fe9-949b-11be9298c8a8', '2017-08-13', '2557.97', '27870363', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1269, NULL, '922991274', 12, 'e1f99898-4f88-39ca-b139-646cec2c69b9', '2018-03-07', '1361.60', '44528478', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1270, NULL, '765649229', 12, 'f434f3a0-5987-3602-bcb1-e6a08b5c19ab', '2018-02-19', '504.91', '16866011', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1271, NULL, '185552692', 13, '588f0f34-0a56-350c-9649-1401c10329c1', '2018-02-01', '1338.71', '27065977', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1272, NULL, '573123575', 13, '4a7a889f-5ce2-39e7-8e16-3eafa437a614', '2017-07-04', '978.87', '44042170', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1273, NULL, '1283975231', 13, 'ea04743f-3dcd-3301-8fb2-51740b67c893', '2017-08-01', '1098.47', '14351843', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1274, NULL, '1317435500', 13, 'bf8e7669-8adb-3703-ac9a-fe955542f458', '2017-06-09', '2882.82', '44131049', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1275, NULL, '594559364', 13, '1c0efaaa-af7d-3040-ba77-c4c1e1faec85', '2018-02-16', '2862.75', '43827400', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1276, NULL, '488221198', 13, '058d7dd8-c2c9-38a7-8460-f98d20d64c83', '2017-12-17', '622.62', '35235183', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1277, NULL, '1043319666', 13, '7e16d199-b8f0-3a4b-b497-b51c7123a9d8', '2017-09-12', '921.76', '45071046', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1278, NULL, '1412311419', 13, 'a7ae859c-1537-3c1c-af50-06068fe6f394', '2017-06-11', '2485.99', '39680957', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1279, NULL, '1378685901', 13, '47eb0b3f-3495-3cb8-a69b-2646e3c98a2b', '2017-06-25', '2102.71', '17155685', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1280, NULL, '1200756300', 13, '82318dcc-31b1-3bce-b4fa-d4413d136b63', '2017-08-20', '482.52', '19117696', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-17 06:59:35', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, '2018-05-17 09:59:35', NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1281, NULL, '1402855828', 13, 'bda9e699-5193-31e9-b8bc-3dd30166c8d7', '2018-03-24', '1300.67', '44748066', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1282, NULL, '1008640515', 13, 'a70991e7-9884-3fc3-adee-d5686c378498', '2017-07-14', '1777.78', '49358264', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1283, NULL, '1277563327', 14, 'c4548437-3cd1-330c-83c9-e598bd763a01', '2017-09-03', '2834.39', '29078057', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1284, NULL, '874242643', 14, '0dc3eb9d-1558-3f2a-8061-281848af9e81', '2017-07-03', '570.14', '18145112', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-17 06:47:12', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, '2018-05-17 09:47:12', NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1285, NULL, '707546519', 14, '43584936-3959-3841-907c-67c7bff5cd75', '2017-12-04', '550.99', '42136788', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1286, NULL, '980193874', 14, 'd6e17907-b38e-37ce-acc7-ed43e0e7d093', '2018-03-21', '429.52', '26515350', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1287, NULL, '1041642502', 15, 'd8a8f99b-9573-3678-b5c6-cfd79e333200', '2018-04-11', '1284.38', '41753818', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1288, NULL, '634796540', 15, '50531c74-edaf-3dcb-af4d-96ad31ce5128', '2018-02-02', '2235.42', '32907041', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1289, NULL, '1438731272', 15, '2d0518f2-e1f1-3fce-a046-9a956bfb4c15', '2017-12-30', '1834.47', '19961134', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1290, NULL, '1197551280', 15, 'd1ecb33d-e18f-3e13-b38e-b4781423b669', '2018-04-30', '418.53', '9479687', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1291, NULL, '1251297346', 15, '786f3a0b-685b-3cc6-b52e-01ec40d0806e', '2017-08-29', '2862.35', '29960874', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1292, NULL, '201755886', 15, '82cadcbb-1ffb-35cd-8ae6-46cab8193c51', '2017-11-11', '719.62', '39804445', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1293, NULL, '1423400501', 15, '43e7f30f-a096-30ec-a0fd-a376018e11b8', '2018-01-29', '2506.18', '13429709', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1294, NULL, '391047498', 15, '6a62903b-f9b3-323b-80ee-ee1f22bc992a', '2018-03-25', '2687.69', '35777561', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1295, NULL, '996992231', 15, '40ea326b-29df-33de-aea9-cd7ceb33a40c', '2018-04-11', '601.64', '42527529', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1296, NULL, '549872720', 15, '66d98559-a18c-35ff-b629-c6558863e752', '2017-12-24', '929.27', '30743170', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8');
INSERT INTO `assets` (`id`, `name`, `asset_tag`, `model_id`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `assigned_to`, `notes`, `image`, `user_id`, `created_at`, `updated_at`, `physical`, `deleted_at`, `status_id`, `archived`, `warranty_months`, `depreciate`, `supplier_id`, `requestable`, `rtd_location_id`, `accepted`, `last_checkout`, `expected_checkin`, `company_id`, `assigned_type`, `last_audit_date`, `next_audit_date`, `location_id`, `_snipeit_digitized_dynamic_success_1`, `_snipeit_universal_intangible_info_mediaries_2`, `_snipeit_up_sized_foreground_model_3`, `_snipeit_vision_oriented_coherent_implementation_4`, `_snipeit_normal_re_order_level_5`) VALUES
(1297, NULL, '856446030', 15, '7ee6dd4f-ddcf-3a6d-a4a6-cc0ad773ae7a', '2017-09-14', '2834.82', '19937489', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1298, NULL, '1338239133', 15, 'a3b92193-8d8e-33e5-b071-b0439a04a39e', '2017-10-30', '456.74', '12941766', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1299, NULL, '1328369458', 15, '9ae0c91e-e040-394e-be68-9a938a197852', '2017-08-26', '909.85', '45719341', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1300, NULL, '470294354', 15, 'ada4ad48-9644-3386-a383-4c547d7bc25f', '2018-02-26', '2759.88', '36544140', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1301, NULL, '1043714906', 15, 'a7178c4c-baf6-325a-9d1e-9689ff6bec7d', '2018-04-19', '2763.20', '13235664', 7, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1302, NULL, '589383363', 15, '9df9a90a-be54-3a78-b4bd-7495e0e0459b', '2018-05-01', '2685.09', '44227918', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1303, NULL, '650660930', 15, 'd651587d-1dc2-310d-9e25-e9a637d8133b', '2017-08-19', '2785.69', '13019357', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1304, NULL, '132489566', 15, '1543dd44-68f3-3a6f-b2c8-84103407d98a', '2018-01-25', '1117.19', '14046082', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1305, NULL, '864479031', 15, '20b3a58f-687e-380d-8c53-103818b1f1eb', '2017-12-01', '2897.69', '7998150', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1306, NULL, '1369103792', 15, 'f0839431-e516-3a93-a05e-837ec2a7ec4a', '2017-09-30', '2113.06', '8464905', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1307, NULL, '899718283', 15, '8a72df07-d7f1-3f67-9ca6-8e33919f2053', '2017-07-09', '1256.22', '29762414', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1308, NULL, '646939935', 15, '3aa1e971-9b93-329f-baf2-f355d217c87e', '2017-07-05', '548.78', '13854659', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1309, NULL, '814297464', 15, 'b0a2e430-20a8-3e66-b2af-fd0c525a3c05', '2017-09-24', '2894.03', '28202482', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1310, NULL, '283787948', 15, '3f408472-ee20-34e2-bd72-e7c61bcd77c6', '2017-12-30', '2292.32', '34803341', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1311, NULL, '153622872', 15, 'b016e976-c0ef-38d3-82c5-2b45f83384bf', '2018-01-09', '2991.61', '2795157', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1312, NULL, '967754416', 15, '393657aa-7a22-334f-9278-10110178f83f', '2017-08-21', '2219.11', '23748676', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1313, NULL, '159017122', 15, 'cb5d69ff-5bc3-3896-a030-b2940e608c50', '2017-08-16', '2135.60', '14316130', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1314, NULL, '326448738', 16, '6eac23e0-8b4e-348b-b080-85fdfe264cf6', '2018-03-07', '2266.46', '2212676', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1315, NULL, '1415377605', 16, 'f7a67d53-5a00-3f54-8e75-b2ddf3ca5c8a', '2018-03-23', '2211.46', '20946044', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1316, NULL, '1138272570', 16, '7ed9bf93-27a4-3435-82d3-b0d62b207105', '2018-02-06', '363.85', '35142404', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1317, NULL, '1021078651', 16, '3ee7dd18-02b0-3a0f-859e-87b77d8f9ea1', '2018-05-03', '495.85', '9663477', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1318, NULL, '1298249614', 16, '1898514c-ebdb-3e48-8999-ba53ecf21102', '2017-08-29', '2597.20', '46101840', 6, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:42', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1319, NULL, '679742682', 16, 'fcc5cc2b-9e2b-36e9-a968-6f5973029430', '2018-04-01', '2205.82', '26763553', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1320, NULL, '50718422', 16, '84959ab3-00e8-3611-9166-ad0e6fb0c468', '2017-12-27', '1686.93', '15241729', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1321, NULL, '1206527004', 16, 'f83f3e7a-cce1-3ad1-9825-d4cb53375af5', '2017-11-24', '1177.72', '12923920', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1322, NULL, '1512677888', 16, '19bbbad0-699b-3bf4-80f1-1b50f857e72e', '2018-02-15', '1184.81', '41629766', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1323, NULL, '219407694', 16, '9decc0da-30f6-3b66-8b09-3a309a570016', '2017-08-01', '2045.39', '26502056', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1324, NULL, '906931777', 16, '56760942-e8f9-33fa-9032-30ee4b433dc8', '2018-02-26', '2285.81', '26246920', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1325, NULL, '659600411', 16, '06bd1ea5-9224-3171-a086-47494de7d326', '2017-11-17', '2245.17', '21776049', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 10, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1326, NULL, '1188931175', 16, '3080f7cb-4a88-38b8-8ac5-f29df845a53a', '2018-03-27', '1595.49', '36308614', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1327, NULL, '1107682910', 16, '131662dc-700c-3e0f-ba58-71d9071b481c', '2017-09-09', '2651.67', '18181772', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1328, NULL, '402851740', 16, 'a9ea8a03-63aa-3664-a040-1a43aee3667a', '2018-03-06', '2493.93', '31395620', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1329, NULL, '1166497640', 16, '8a42f556-8412-3319-96cf-8639a512c703', '2017-10-24', '2964.01', '39266301', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1330, NULL, '19582189', 16, '4fe9431e-098a-3682-8213-e4e841b0afaf', '2018-02-07', '1636.09', '35142998', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1331, NULL, '46440466', 16, 'b4e2f6d7-2860-3595-bda2-6b95482a8159', '2017-05-15', '598.18', '14501763', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1332, NULL, '672974448', 16, '27a9a98e-76f3-304c-b611-c4fe130170d6', '2017-10-04', '569.19', '31874669', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1333, NULL, '244138586', 16, 'bdc56fa7-cf78-3730-b4b2-03f538bed4ac', '2017-09-26', '2945.66', '31588538', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, '8'),
(1334, NULL, '265985043', 16, 'fe36212a-4468-3027-b3d0-4201e3659da4', '2018-04-28', '2211.96', '18807599', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1335, NULL, '1403743963', 16, '031bf721-fa07-3923-b80e-5504f1fd3dae', '2018-03-28', '835.16', '20329007', 5, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1336, NULL, '697538707', 16, '52f26158-365f-3005-b041-2c6f2dd3e925', '2017-08-20', '1428.78', '48097078', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1337, NULL, '1241205000', 16, '3d62cf02-e5c7-39be-a68e-4ee799609c75', '2017-12-14', '2386.11', '41668439', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:31', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1338, NULL, '904952943', 16, 'ae966793-6381-321d-a8c3-b1d2351f5da9', '2017-09-08', '2797.51', '30264553', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, '8'),
(1339, NULL, '1339936318', 16, 'c104e8b1-f81f-3818-b598-5a82ea24f7ef', '2018-03-14', '921.07', '11326197', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1340, NULL, '1199912449', 16, '0398f12d-fe9e-33b6-b45e-46dc0919de84', '2017-07-22', '2810.86', '22418935', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\Location', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1341, NULL, '758591254', 16, '85df1eee-6d66-3a32-8859-a3c1c46a60bf', '2017-12-31', '1763.08', '21841170', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1342, NULL, '620593765', 16, '61b4d952-7564-3c5d-9cd8-ba581dd112ee', '2017-12-22', '520.35', '30471258', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1343, NULL, '957407250', 16, '081c409e-dc5b-3951-8220-df14242206e7', '2018-05-02', '2740.58', '10033617', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1344, NULL, '483292407', 16, '0288d245-94c9-38ee-b0d6-7d8a7721e6fa', '2017-06-13', '939.59', '25122518', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1345, NULL, '1193727782', 16, 'f1d92c58-6ac9-3def-9d60-cd5d84d3c43a', '2017-07-29', '2966.62', '20723755', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1346, NULL, '670100492', 16, '3f57a6f8-5400-32a3-bd56-46517846d263', '2017-08-11', '848.26', '8547653', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, '8'),
(1347, NULL, '1058122094', 16, 'b667e629-45db-366f-ab78-52effb06c5d3', '2017-12-15', '910.28', '16724383', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1348, NULL, '237842524', 16, '8cfa7d82-526a-3247-9556-360b215e4c24', '2018-04-11', '1909.29', '10006166', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1349, NULL, '456564348', 16, 'e82202c7-a93d-3288-b655-f349585aae8b', '2017-08-28', '1243.97', '49031037', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1350, NULL, '544614977', 16, 'ad07c7c9-fb58-33c6-bf80-3e3a0d0b2614', '2017-07-13', '1723.99', '5445291', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1351, NULL, '227359471', 16, '4ce9d6e8-7ecb-3cec-a82c-97d3ca442828', '2017-10-21', '2624.97', '22366277', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1352, NULL, '389207681', 16, '798c93a4-434a-3ab0-a63c-fcb3c4b95d66', '2017-09-24', '578.48', '3605841', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1353, NULL, '1166219350', 16, 'e1d28692-5eb2-34fb-8d8f-d4cf3efad6da', '2017-08-10', '1764.39', '36852221', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1354, NULL, '1186340826', 17, '4eb68a71-2dca-392a-bf33-c8160a116b76', '2017-11-08', '1976.21', '1292077', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1355, NULL, '70799076', 17, 'f9b385dd-9a85-3561-aa48-85405fc037fe', '2018-04-23', '2329.10', '11055060', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, '8'),
(1356, NULL, '1108755972', 17, 'c55a0bc5-4168-3c83-89ee-16466be6a19a', '2017-06-16', '2504.69', '42718031', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1357, NULL, '308118368', 17, '570d9145-81aa-3697-a7e7-357c0c11246a', '2018-05-01', '1576.13', '1553499', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1358, NULL, '1258275136', 17, '08c1862d-3e0d-3f68-a590-d04c8212f39a', '2018-05-07', '1589.02', '38719377', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1359, NULL, '1525555936', 17, '410d88e5-ee08-35c0-a88d-60203efa0d8a', '2018-03-17', '1363.14', '38552242', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 6, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1360, NULL, '642006825', 17, '5af73fbf-42fd-3b5d-ac98-a2e0191f8314', '2018-03-13', '803.62', '43303735', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1361, NULL, '657943322', 17, '84f9b39b-caef-3995-ac5e-7a0a19a9e0f3', '2018-03-18', '2367.36', '19864617', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1362, NULL, '1277844465', 17, '34e9e924-5e16-34dd-bbb6-315c16357827', '2017-10-20', '1686.04', '26964256', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1363, NULL, '1237502305', 17, '565ad9cf-584e-3837-a10b-65f05216412d', '2017-10-17', '2497.79', '32299282', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, '8'),
(1364, NULL, '290361737', 18, 'ce0f390a-780d-3d89-bc1e-f12117c4fbdc', '2017-10-27', '894.76', '28870719', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1365, NULL, '1258137692', 18, '1af2cba7-b798-31f2-8f23-489e07cd75cc', '2017-07-27', '497.60', '23883692', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1366, NULL, '991461916', 18, 'dc78e71a-4c73-35ab-8481-43d7990b0d62', '2018-04-11', '2730.96', '39276145', 1, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 10:07:22', 1, NULL, 1, 0, NULL, NULL, 1, 0, 5, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1367, NULL, '729639467', 18, '7bbe5468-d594-3490-a49f-3524894cb6f3', '2017-12-15', '1664.56', '24611994', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, '8'),
(1368, NULL, '1088291208', 18, '5baa6f4b-1a62-3c0a-a4b2-1e12dc13b35a', '2017-10-19', '1398.29', '7623250', 3, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 1, 8, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1369, NULL, '13113828', 18, '266760cd-e197-3fcb-904a-afbbfbfd4e16', '2017-11-19', '480.12', '49373423', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, '8'),
(1370, NULL, '159399114', 18, '9c1d1aa7-dc48-3aba-802a-f42db2359d1b', '2017-12-07', '1748.79', '18291912', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, '8'),
(1371, NULL, '688759697', 18, 'c57d64af-dc7a-371d-a7dc-08828d7f1ad8', '2018-03-08', '807.21', '16588574', NULL, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:40', 1, NULL, 1, 0, NULL, NULL, 1, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '8'),
(1372, NULL, '634782433', 18, 'dee663d6-8b50-3853-8269-641cf09a734d', '2018-04-25', '2527.30', '3542607', 2, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 4, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 1, NULL, NULL, NULL, NULL, '8'),
(1373, NULL, '432367587', 18, '44adc57b-f9f7-3572-9d8b-adaf979727ad', '2017-11-03', '2195.98', '8014419', 4, 'Created by DB seeder', NULL, 1, '2018-05-15 04:40:32', '2018-05-15 04:40:41', 1, NULL, 1, 0, NULL, NULL, 1, 0, 3, NULL, NULL, NULL, NULL, 'App\\Models\\User', NULL, NULL, 3, NULL, NULL, NULL, NULL, '8');

-- --------------------------------------------------------

--
-- Table structure for table `asset_logs`
--

CREATE TABLE `asset_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_id` int(11) NOT NULL,
  `checkedout_to` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `asset_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `filename` text COLLATE utf8mb4_unicode_ci,
  `requested_at` datetime DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `accessory_id` int(11) DEFAULT NULL,
  `accepted_id` int(11) DEFAULT NULL,
  `consumable_id` int(11) DEFAULT NULL,
  `expected_checkin` date DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_maintenances`
--

CREATE TABLE `asset_maintenances` (
  `id` int(10) UNSIGNED NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `asset_maintenance_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_warranty` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `asset_maintenance_time` int(11) DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci,
  `cost` decimal(20,2) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_uploads`
--

CREATE TABLE `asset_uploads` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_id` int(11) NOT NULL,
  `filenotes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `eula_text` longtext COLLATE utf8mb4_unicode_ci,
  `use_default_eula` tinyint(1) NOT NULL DEFAULT '0',
  `require_acceptance` tinyint(1) NOT NULL DEFAULT '0',
  `category_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'asset',
  `checkin_email` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `user_id`, `deleted_at`, `eula_text`, `use_default_eula`, `require_acceptance`, `category_type`, `checkin_email`, `image`) VALUES
(1, 'Laptops', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Quia expedita aut deserunt amet. Maxime dolorum non ullam velit.', 0, 1, 'asset', 0, NULL),
(2, 'Desktops', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Qui deleniti ut voluptates. Aperiam cumque maiores eveniet asperiores voluptates aut. In occaecati cumque enim minus dolorem ut.', 1, 0, 'asset', 1, NULL),
(3, 'Tablets', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Dolorem exercitationem tenetur laboriosam veritatis veniam ut. Saepe eum necessitatibus molestiae qui modi rerum ipsa. Omnis eveniet voluptas debitis nulla omnis et et. Rerum et et illum voluptas tempore mollitia eum.', 1, 0, 'asset', 1, NULL),
(4, 'Mobile Phones', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Deserunt reprehenderit similique voluptatem est incidunt quia officia. Provident qui quo quaerat provident vitae. Culpa accusamus autem optio dolorem illo. Illo illum tempora ratione.', 0, 0, 'asset', 1, NULL),
(5, 'Displays', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Deleniti ex ipsa labore minus odio. Inventore delectus delectus provident animi. Voluptatibus alias sed perspiciatis laboriosam ut aut dolor. Accusantium nam optio nihil cum laudantium.', 1, 0, 'asset', 0, NULL),
(6, 'VOIP Phones', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Amet iste dolores eos ea quo sunt consequuntur vitae. Fugiat eligendi voluptatem quod repellendus ratione. Eligendi cum ad ut eos fuga. Animi voluptatum molestias praesentium sit distinctio architecto eveniet.', 1, 0, 'asset', 1, NULL),
(7, 'Conference Phones', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Voluptatem fugit sit sed velit perferendis voluptate qui et. Labore sit doloremque ullam ut sit et libero ipsam.', 0, 0, 'asset', 1, NULL),
(8, 'Keyboards', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Officia repellendus odio amet dolore. Perspiciatis cupiditate sed eos atque et dolorem. Vel unde dicta sapiente explicabo temporibus atque natus ut. Autem expedita atque eos dignissimos ipsa.', 0, 0, 'accessory', 1, NULL),
(9, 'Mouse', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Sed dolores necessitatibus doloremque possimus ea ut enim. Facilis aperiam et quo ex consequuntur consectetur aliquid. Adipisci quas at molestiae saepe.', 0, 0, 'accessory', 0, NULL),
(10, 'Printer Paper', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Recusandae nulla quas saepe tenetur. Occaecati nostrum doloremque modi saepe sunt deserunt eaque. Dolore quis magni dicta facere consectetur reiciendis perspiciatis. Rerum voluptatum libero consequatur ut harum eum iure.', 1, 0, 'consumable', 0, NULL),
(11, 'Printer Ink', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Rerum dolorem aut vel asperiores repudiandae molestiae. Dicta facere est sed consectetur. Fuga amet est quia rem delectus qui eaque. Sit laborum sit omnis consequuntur excepturi omnis.', 1, 0, 'consumable', 1, NULL),
(12, 'HDD/SSD', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Non modi ducimus dolorem quos. A ullam quia earum laboriosam dolor consequatur. Nihil ea esse a dolore eos aliquid tempora.', 0, 0, 'component', 0, NULL),
(13, 'RAM', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'Quisquam maxime voluptas corrupti facere iste ab accusantium. Est nesciunt accusamus et ipsam est. Quibusdam ut sed repellendus officiis.', 1, 0, 'component', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `checkout_requests`
--

CREATE TABLE `checkout_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `requestable_id` int(11) NOT NULL,
  `requestable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `canceled_at` datetime DEFAULT NULL,
  `fulfilled_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `created_at`, `updated_at`, `image`) VALUES
(1, 'Marketing', '2018-05-15 04:40:20', '2018-05-15 10:00:46', NULL),
(4, 'Engineering', '2018-05-15 04:40:20', '2018-05-15 09:51:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
  `serial` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`id`, `name`, `category_id`, `location_id`, `company_id`, `user_id`, `qty`, `order_number`, `purchase_date`, `purchase_cost`, `created_at`, `updated_at`, `deleted_at`, `min_amt`, `serial`, `image`) VALUES
(1, 'Crucial 4GB DDR3L-1600 SODIMM', 13, 3, 4, NULL, 10, '35311544', '2000-07-01', '7.97', '2018-05-15 04:40:32', '2018-05-16 02:51:38', NULL, 2, '91cab66c-f83c-3fd2-9e85-478d42904896', NULL),
(2, 'Crucial 8GB DDR3L-1600 SODIMM Memory for Mac', 13, 1, 4, NULL, 10, '11925626', '1996-09-04', '1307.39', '2018-05-15 04:40:32', '2018-05-16 02:52:56', NULL, 2, '46bcc7ae-7d2e-3ee7-aa60-4d298060b9ef', NULL),
(3, 'Crucial BX300 120GB SATA Internal SSD', 12, 1, 4, NULL, 10, '33193610', '1979-01-04', '9927238.63', '2018-05-15 04:40:32', '2018-05-16 02:54:28', NULL, 2, 'f619bfe5-3479-3e5b-8e7e-6a85ed67d922', NULL),
(4, 'Crucial BX300 240GB SATA Internal SSD', 12, 1, 1, NULL, 10, '16129019', '2008-04-30', '132.03', '2018-05-15 04:40:32', '2018-05-16 02:53:51', NULL, 2, 'a382c9ce-d00f-3ad5-97b0-206d3ca0b86e', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `components_assets`
--

CREATE TABLE `components_assets` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `assigned_qty` int(11) DEFAULT '1',
  `component_id` int(11) DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consumables`
--

CREATE TABLE `consumables` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `requestable` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
  `model_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `item_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consumables`
--

INSERT INTO `consumables` (`id`, `name`, `category_id`, `location_id`, `user_id`, `qty`, `requestable`, `created_at`, `updated_at`, `deleted_at`, `purchase_date`, `purchase_cost`, `order_number`, `company_id`, `min_amt`, `model_number`, `manufacturer_id`, `item_no`, `image`) VALUES
(1, 'Cardstock (White)', 10, NULL, NULL, 10, 0, '2018-05-15 04:40:32', '2018-05-15 09:45:21', '2018-05-15 09:45:21', '2017-07-03', '17.36', '5077826', 3, 2, NULL, 10, '21050855', NULL),
(2, 'Laserjet Paper (Ream)', 10, NULL, NULL, 20, 0, '2018-05-15 04:40:32', '2018-05-15 09:45:27', '2018-05-15 09:45:27', '2017-09-09', '11.50', '21459016', NULL, 2, NULL, 10, '24725040', NULL),
(3, 'Laserjet Toner (black)', 11, NULL, NULL, 20, 0, '2018-05-15 04:40:32', '2018-05-15 09:45:31', '2018-05-15 09:45:31', '2017-10-26', '5.55', '12358591', NULL, 2, NULL, 5, '12436505', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consumables_users`
--

CREATE TABLE `consumables_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `consumable_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `field_values` text COLLATE utf8mb4_unicode_ci,
  `field_encrypted` tinyint(1) NOT NULL DEFAULT '0',
  `db_column` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `help_text` text COLLATE utf8mb4_unicode_ci,
  `show_in_email` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_fields`
--

INSERT INTO `custom_fields` (`id`, `name`, `format`, `element`, `created_at`, `updated_at`, `user_id`, `field_values`, `field_encrypted`, `db_column`, `help_text`, `show_in_email`) VALUES
(1, 'Digitized dynamic success', '', 'text', '2018-05-15 04:40:38', '2018-05-15 04:40:38', NULL, NULL, 0, '_snipeit_digitized_dynamic_success_1', NULL, 0),
(2, 'Universal intangible info-mediaries', '', 'text', '2018-05-15 04:40:38', '2018-05-15 04:40:38', NULL, NULL, 0, '_snipeit_universal_intangible_info_mediaries_2', NULL, 0),
(3, 'Up-sized foreground model', '', 'text', '2018-05-15 04:40:38', '2018-05-15 04:40:38', NULL, NULL, 0, '_snipeit_up_sized_foreground_model_3', NULL, 0),
(4, 'Vision-oriented coherent implementation', '', 'text', '2018-05-15 04:40:38', '2018-05-15 04:40:38', NULL, NULL, 0, '_snipeit_vision_oriented_coherent_implementation_4', NULL, 0),
(5, 'Normal Re-Order Level ', 'numeric', 'text', '2018-05-16 02:41:38', '2018-05-16 02:41:38', NULL, '', 0, '_snipeit_normal_re_order_level_5', 'Normal Re-Order Levels for this item', 1);

-- --------------------------------------------------------

--
-- Table structure for table `custom_fieldsets`
--

CREATE TABLE `custom_fieldsets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_fieldsets`
--

INSERT INTO `custom_fieldsets` (`id`, `name`, `created_at`, `updated_at`, `user_id`) VALUES
(2, 'Normal re-order level', '2018-05-16 04:28:05', '2018-05-16 04:28:05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_custom_fieldset`
--

CREATE TABLE `custom_field_custom_fieldset` (
  `custom_field_id` int(11) NOT NULL,
  `custom_fieldset_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `required` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_field_custom_fieldset`
--

INSERT INTO `custom_field_custom_fieldset` (`custom_field_id`, `custom_fieldset_id`, `order`, `required`) VALUES
(5, 1, 1, 1),
(5, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `user_id`, `company_id`, `location_id`, `manager_id`, `notes`, `created_at`, `updated_at`, `deleted_at`, `image`) VALUES
(1, 'Human Resources', 1, NULL, 4, NULL, NULL, '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL),
(2, 'Engineering', 1, NULL, 4, NULL, NULL, '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL),
(3, 'Marketing', 1, NULL, 3, NULL, NULL, '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL),
(4, 'Client Services', 1, NULL, 4, NULL, NULL, '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL),
(5, 'Product Management', 1, NULL, 5, NULL, NULL, '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL),
(6, 'Dept of Silly Walks', 1, NULL, 2, NULL, NULL, '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `depreciations`
--

CREATE TABLE `depreciations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `months` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `depreciations`
--

INSERT INTO `depreciations` (`id`, `name`, `months`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Computer Depreciation', 36, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1),
(2, 'Display Depreciation', 12, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1),
(3, 'Mobile Phone Depreciation', 24, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filesize` int(11) NOT NULL,
  `import_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `header_row` text COLLATE utf8mb4_unicode_ci,
  `first_row` text COLLATE utf8mb4_unicode_ci,
  `field_map` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `imports`
--

INSERT INTO `imports` (`id`, `name`, `file_path`, `filesize`, `import_type`, `created_at`, `updated_at`, `header_row`, `first_row`, `field_map`) VALUES
(1, NULL, '2018-05-15-014518-snipe-user-import-testcsv', 1163, 'user', '2018-05-15 10:45:18', '2018-05-15 10:46:35', '["First Name","Last Name","email","User name","Location","Phone Num","Job Title For User","Employee Number","Company"]', '["mutwiri","muriungi","mutwiri.muriungi@poainternet.net","mutwiri.muriungi","nairobi","63-(199)661-2186","Clinical Specialist","7080919053","Engineering"]', '{"First Name":"first_name","Last Name":"last_name","email":"email","User name":"username","Location":"location","Phone Num":"phone_number","Job Title For User":"jobtitle","Employee Number":"employee_num","Company":"company"}');

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seats` int(11) NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `depreciation_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `license_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `license_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `depreciate` tinyint(1) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `purchase_order` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `termination_date` date DEFAULT NULL,
  `maintained` tinyint(1) DEFAULT NULL,
  `reassignable` tinyint(1) NOT NULL DEFAULT '1',
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `licenses`
--

INSERT INTO `licenses` (`id`, `name`, `serial`, `purchase_date`, `purchase_cost`, `order_number`, `seats`, `notes`, `user_id`, `depreciation_id`, `created_at`, `updated_at`, `deleted_at`, `license_name`, `license_email`, `depreciate`, `supplier_id`, `expiration_date`, `purchase_order`, `termination_date`, `maintained`, `reassignable`, `company_id`, `manufacturer_id`, `category_id`) VALUES
(1, 'Photoshop', 'd0020ddb-181e-3a15-a771-86e7a5bbbfd5', '2018-04-04', '299.99', '40561278', 10, 'Created by DB seeder', 1, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, 'Tara Blanda', 'hermiston.leonora@example.com', NULL, 3, '2019-09-28', '13503Q', '2017-07-31', 1, 0, NULL, 9, NULL),
(2, 'Acrobat', 'b92c3d0f-4bbf-3899-bcad-2c5924d670e9', '2017-06-15', '29.99', '38201923', 10, 'Created by DB seeder', 1, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, 'Clint Bartoletti', 'jmraz@example.net', NULL, 4, '2018-09-22', NULL, '2018-01-03', NULL, 0, NULL, 9, NULL),
(3, 'InDesign', '7fac2bcf-c8ff-388b-b0c0-9e7ecd3c2459', '2017-10-17', '199.99', '49701384', 10, 'Created by DB seeder', 1, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, 'Mya Willms', 'ajacobson@example.org', NULL, 3, '2020-04-19', NULL, '2017-10-26', NULL, 1, NULL, 9, NULL),
(4, 'Office', '403e68e3-fe07-35bd-8d5c-2ad7d34adbd9', '2018-05-03', '49.99', '28572866', 20, 'Created by DB seeder', 1, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, 'Freeda Sporer', 'davis.chaim@example.com', NULL, 4, '2018-06-05', NULL, '2017-10-03', NULL, 1, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `license_seats`
--

CREATE TABLE `license_seats` (
  `id` int(10) UNSIGNED NOT NULL,
  `license_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `license_seats`
--

INSERT INTO `license_seats` (`id`, `license_id`, `assigned_to`, `notes`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `asset_id`) VALUES
(1, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(2, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(3, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(4, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(5, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(6, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(7, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(8, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(9, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(10, 1, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(11, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(12, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(13, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(14, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(15, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(16, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(17, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(18, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(19, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(20, 2, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(21, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(22, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(23, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(24, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(25, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(26, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(27, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(28, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(29, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(30, 3, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(31, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(32, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(33, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(34, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(35, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(36, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(37, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(38, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(39, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(40, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(41, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(42, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(43, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(44, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(45, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(46, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(47, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(48, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(49, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL),
(50, 4, NULL, NULL, NULL, '2018-05-15 04:40:32', '2018-05-15 04:40:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_ou` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `city`, `state`, `country`, `created_at`, `updated_at`, `user_id`, `address`, `address2`, `zip`, `deleted_at`, `parent_id`, `currency`, `ldap_ou`, `manager_id`, `image`) VALUES
(1, 'Nairobi', 'Nairobi', 'KE', 'KE', '2018-05-15 04:40:20', '2018-05-15 09:40:13', NULL, 'Ginge Rd', '', '00100', NULL, NULL, 'KES', NULL, 0, '4.jpg'),
(2, 'Laurelport', 'Santosmouth', 'NC', 'BR', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, '10990 Jacobson Turnpike Suite 377', 'Apt. 766', '60026', NULL, NULL, 'STD', NULL, NULL, '3.jpg'),
(3, 'New Roselynville', 'Judahside', 'CO', 'HU', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, '4535 Howe Flat', 'Apt. 062', '03991', NULL, NULL, 'BZD', NULL, NULL, '7.jpg'),
(4, 'New Nat', 'East Bette', 'GA', 'IN', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, '9298 Kirlin Cliff', 'Apt. 687', '46731', NULL, NULL, 'SBD', NULL, NULL, '7.jpg'),
(5, 'East Yasminburgh', 'East Ismaelshire', 'NY', 'EH', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, '255 Yoshiko Groves Suite 855', 'Apt. 878', '28079', NULL, NULL, 'FJD', NULL, NULL, '5.jpg'),
(6, 'Briannebury', 'East Hyman', 'NE', 'HN', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, '580 Hickle Knolls', 'Apt. 174', '85420-2945', NULL, NULL, 'SHP', NULL, NULL, '3.jpg'),
(7, 'Beckerstad', 'Veronaburgh', 'DE', 'DJ', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, '7792 Walter Route Apt. 630', 'Apt. 389', '17482', NULL, NULL, 'UZS', NULL, NULL, '6.jpg'),
(8, 'New Henrymouth', 'Jacintheburgh', 'CA', 'BM', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, '5103 Marianna Corner Apt. 620', 'Suite 699', '62168-0936', NULL, NULL, 'RUB', NULL, NULL, '8.jpg'),
(9, 'North Mary', 'Watsicaberg', 'NE', 'SZ', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, '2458 Greenholt Highway', 'Apt. 113', '26627-1004', NULL, NULL, 'KYD', NULL, NULL, '8.jpg'),
(10, 'West Dorrisberg', 'Lake Nametown', 'ND', 'VA', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, '852 Ondricka Turnpike Apt. 849', 'Apt. 647', '19750-6442', NULL, NULL, 'MDL', NULL, NULL, '6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`, `created_at`, `updated_at`, `user_id`, `deleted_at`, `url`, `support_url`, `support_phone`, `support_email`, `image`) VALUES
(1, 'Apple', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://apple.com', 'https://support.apple.com', '813-661-8769 x680', 'bbins@example.com', 'apple.jpg'),
(2, 'Microsoft', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://microsoft.com', 'https://support.microsoft.com', '218.377.1110', 'walker.suzanne@example.org', 'microsoft.png'),
(3, 'Dell', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://dell.com', 'https://support.dell.com', '+1.729.799.2529', 'fmarquardt@example.org', 'dell.png'),
(4, 'Asus', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://asus.com', 'https://support.asus.com', '+1-758-946-3275', 'sanford.patsy@example.net', 'asus.png'),
(5, 'HP', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://hp.com', 'https://support.hp.com', '1-893-302-2222 x89235', 'qcrooks@example.net', 'hp.png'),
(6, 'Lenovo', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://lenovo.com', 'https://support.lenovo.com', '+12039191956', 'lakin.abdullah@example.org', 'lenovo.jpg'),
(7, 'LG', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://lg.com', 'https://support.lg.com', '516.668.8961 x29869', 'daniel.levi@example.com', 'lg.jpg'),
(8, 'Polycom', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://polycom.com', 'https://support.polycom.com', '+1-497-588-3115', 'jose71@example.com', 'polycom.png'),
(9, 'Adobe', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://adobe.com', 'https://support.adobe.com', '(908) 547-6633', 'connor.cormier@example.net', 'adobe.jpg'),
(10, 'Avery', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://avery.com', 'https://support.avery.com', '272-974-9063 x741', 'gottlieb.neil@example.org', 'avery.png'),
(11, 'Crucial', '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, NULL, 'https://crucial.com', 'https://support.crucial.com', '+1 (453) 816-8179', 'petra62@example.net', 'crucial.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2012_12_06_225921_migration_cartalyst_sentry_install_users', 1),
(2, '2012_12_06_225929_migration_cartalyst_sentry_install_groups', 1),
(3, '2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot', 1),
(4, '2012_12_06_225988_migration_cartalyst_sentry_install_throttle', 1),
(5, '2013_03_23_193214_update_users_table', 1),
(6, '2013_11_13_075318_create_models_table', 1),
(7, '2013_11_13_075335_create_categories_table', 1),
(8, '2013_11_13_075347_create_manufacturers_table', 1),
(9, '2013_11_15_015858_add_user_id_to_categories', 1),
(10, '2013_11_15_112701_add_user_id_to_manufacturers', 1),
(11, '2013_11_15_190327_create_assets_table', 1),
(12, '2013_11_15_190357_create_licenses_table', 1),
(13, '2013_11_15_201848_add_license_name_to_licenses', 1),
(14, '2013_11_16_040323_create_depreciations_table', 1),
(15, '2013_11_16_042851_add_depreciation_id_to_models', 1),
(16, '2013_11_16_084923_add_user_id_to_models', 1),
(17, '2013_11_16_103258_create_locations_table', 1),
(18, '2013_11_16_103336_add_location_id_to_assets', 1),
(19, '2013_11_16_103407_add_checkedout_to_to_assets', 1),
(20, '2013_11_16_103425_create_history_table', 1),
(21, '2013_11_17_054359_drop_licenses_table', 1),
(22, '2013_11_17_054526_add_physical_to_assets', 1),
(23, '2013_11_17_055126_create_settings_table', 1),
(24, '2013_11_17_062634_add_license_to_assets', 1),
(25, '2013_11_18_134332_add_contacts_to_users', 1),
(26, '2013_11_18_142847_add_info_to_locations', 1),
(27, '2013_11_18_152942_remove_location_id_from_asset', 1),
(28, '2013_11_18_164423_set_nullvalues_for_user', 1),
(29, '2013_11_19_013337_create_asset_logs_table', 1),
(30, '2013_11_19_061409_edit_added_on_asset_logs_table', 1),
(31, '2013_11_19_062250_edit_location_id_asset_logs_table', 1),
(32, '2013_11_20_055822_add_soft_delete_on_assets', 1),
(33, '2013_11_20_121404_add_soft_delete_on_locations', 1),
(34, '2013_11_20_123137_add_soft_delete_on_manufacturers', 1),
(35, '2013_11_20_123725_add_soft_delete_on_categories', 1),
(36, '2013_11_20_130248_create_status_labels', 1),
(37, '2013_11_20_130830_add_status_id_on_assets_table', 1),
(38, '2013_11_20_131544_add_status_type_on_status_labels', 1),
(39, '2013_11_20_134103_add_archived_to_assets', 1),
(40, '2013_11_21_002321_add_uploads_table', 1),
(41, '2013_11_21_024531_remove_deployable_boolean_from_status_labels', 1),
(42, '2013_11_22_075308_add_option_label_to_settings_table', 1),
(43, '2013_11_22_213400_edits_to_settings_table', 1),
(44, '2013_11_25_013244_create_licenses_table', 1),
(45, '2013_11_25_031458_create_license_seats_table', 1),
(46, '2013_11_25_032022_add_type_to_actionlog_table', 1),
(47, '2013_11_25_033008_delete_bad_licenses_table', 1),
(48, '2013_11_25_033131_create_new_licenses_table', 1),
(49, '2013_11_25_033534_add_licensed_to_licenses_table', 1),
(50, '2013_11_25_101308_add_warrantee_to_assets_table', 1),
(51, '2013_11_25_104343_alter_warranty_column_on_assets', 1),
(52, '2013_11_25_150450_drop_parent_from_categories', 1),
(53, '2013_11_25_151920_add_depreciate_to_assets', 1),
(54, '2013_11_25_152903_add_depreciate_to_licenses_table', 1),
(55, '2013_11_26_211820_drop_license_from_assets_table', 1),
(56, '2013_11_27_062510_add_note_to_asset_logs_table', 1),
(57, '2013_12_01_113426_add_filename_to_asset_log', 1),
(58, '2013_12_06_094618_add_nullable_to_licenses_table', 1),
(59, '2013_12_10_084038_add_eol_on_models_table', 1),
(60, '2013_12_12_055218_add_manager_to_users_table', 1),
(61, '2014_01_28_031200_add_qr_code_to_settings_table', 1),
(62, '2014_02_13_183016_add_qr_text_to_settings_table', 1),
(63, '2014_05_24_093839_alter_default_license_depreciation_id', 1),
(64, '2014_05_27_231658_alter_default_values_licenses', 1),
(65, '2014_06_19_191508_add_asset_name_to_settings', 1),
(66, '2014_06_20_004847_make_asset_log_checkedout_to_nullable', 1),
(67, '2014_06_20_005050_make_asset_log_purchasedate_to_nullable', 1),
(68, '2014_06_24_003011_add_suppliers', 1),
(69, '2014_06_24_010742_add_supplier_id_to_asset', 1),
(70, '2014_06_24_012839_add_zip_to_supplier', 1),
(71, '2014_06_24_033908_add_url_to_supplier', 1),
(72, '2014_07_08_054116_add_employee_id_to_users', 1),
(73, '2014_07_09_134316_add_requestable_to_assets', 1),
(74, '2014_07_17_085822_add_asset_to_software', 1),
(75, '2014_07_17_161625_make_asset_id_in_logs_nullable', 1),
(76, '2014_08_12_053504_alpha_0_4_2_release', 1),
(77, '2014_08_17_083523_make_location_id_nullable', 1),
(78, '2014_10_16_200626_add_rtd_location_to_assets', 1),
(79, '2014_10_24_000417_alter_supplier_state_to_32', 1),
(80, '2014_10_24_015641_add_display_checkout_date', 1),
(81, '2014_10_28_222654_add_avatar_field_to_users_table', 1),
(82, '2014_10_29_045924_add_image_field_to_models_table', 1),
(83, '2014_11_01_214955_add_eol_display_to_settings', 1),
(84, '2014_11_04_231416_update_group_field_for_reporting', 1),
(85, '2014_11_05_212408_add_fields_to_licenses', 1),
(86, '2014_11_07_021042_add_image_to_supplier', 1),
(87, '2014_11_20_203007_add_username_to_user', 1),
(88, '2014_11_20_223947_add_auto_to_settings', 1),
(89, '2014_11_20_224421_add_prefix_to_settings', 1),
(90, '2014_11_21_104401_change_licence_type', 1),
(91, '2014_12_09_082500_add_fields_maintained_term_to_licenses', 1),
(92, '2015_02_04_155757_increase_user_field_lengths', 1),
(93, '2015_02_07_013537_add_soft_deleted_to_log', 1),
(94, '2015_02_10_040958_fix_bad_assigned_to_ids', 1),
(95, '2015_02_10_053310_migrate_data_to_new_statuses', 1),
(96, '2015_02_11_044104_migrate_make_license_assigned_null', 1),
(97, '2015_02_11_104406_migrate_create_requests_table', 1),
(98, '2015_02_12_001312_add_mac_address_to_asset', 1),
(99, '2015_02_12_024100_change_license_notes_type', 1),
(100, '2015_02_17_231020_add_localonly_to_settings', 1),
(101, '2015_02_19_222322_add_logo_and_colors_to_settings', 1),
(102, '2015_02_24_072043_add_alerts_to_settings', 1),
(103, '2015_02_25_022931_add_eula_fields', 1),
(104, '2015_02_25_204513_add_accessories_table', 1),
(105, '2015_02_26_091228_add_accessories_user_table', 1),
(106, '2015_02_26_115128_add_deleted_at_models', 1),
(107, '2015_02_26_233005_add_category_type', 1),
(108, '2015_03_01_231912_update_accepted_at_to_acceptance_id', 1),
(109, '2015_03_05_011929_add_qr_type_to_settings', 1),
(110, '2015_03_18_055327_add_note_to_user', 1),
(111, '2015_04_29_234704_add_slack_to_settings', 1),
(112, '2015_05_04_085151_add_parent_id_to_locations_table', 1),
(113, '2015_05_22_124421_add_reassignable_to_licenses', 1),
(114, '2015_06_10_003314_fix_default_for_user_notes', 1),
(115, '2015_06_10_003554_create_consumables', 1),
(116, '2015_06_15_183253_move_email_to_username', 1),
(117, '2015_06_23_070346_make_email_nullable', 1),
(118, '2015_06_26_213716_create_asset_maintenances_table', 1),
(119, '2015_07_04_212443_create_custom_fields_table', 1),
(120, '2015_07_09_014359_add_currency_to_settings_and_locations', 1),
(121, '2015_07_21_122022_add_expected_checkin_date_to_asset_logs', 1),
(122, '2015_07_24_093845_add_checkin_email_to_category_table', 1),
(123, '2015_07_25_055415_remove_email_unique_constraint', 1),
(124, '2015_07_29_230054_add_thread_id_to_asset_logs_table', 1),
(125, '2015_07_31_015430_add_accepted_to_assets', 1),
(126, '2015_09_09_195301_add_custom_css_to_settings', 1),
(127, '2015_09_21_235926_create_custom_field_custom_fieldset', 1),
(128, '2015_09_22_000104_create_custom_fieldsets', 1),
(129, '2015_09_22_003321_add_fieldset_id_to_assets', 1),
(130, '2015_09_22_003413_migrate_mac_address', 1),
(131, '2015_09_28_003314_fix_default_purchase_order', 1),
(132, '2015_10_01_024551_add_accessory_consumable_price_info', 1),
(133, '2015_10_12_192706_add_brand_to_settings', 1),
(134, '2015_10_22_003314_fix_defaults_accessories', 1),
(135, '2015_10_23_182625_add_checkout_time_and_expected_checkout_date_to_assets', 1),
(136, '2015_11_05_061015_create_companies_table', 1),
(137, '2015_11_05_061115_add_company_id_to_consumables_table', 1),
(138, '2015_11_05_183749_image', 1),
(139, '2015_11_06_092038_add_company_id_to_accessories_table', 1),
(140, '2015_11_06_100045_add_company_id_to_users_table', 1),
(141, '2015_11_06_134742_add_company_id_to_licenses_table', 1),
(142, '2015_11_08_035832_add_company_id_to_assets_table', 1),
(143, '2015_11_08_222305_add_ldap_fields_to_settings', 1),
(144, '2015_11_15_151803_add_full_multiple_companies_support_to_settings_table', 1),
(145, '2015_11_26_195528_import_ldap_settings', 1),
(146, '2015_11_30_191504_remove_fk_company_id', 1),
(147, '2015_12_21_193006_add_ldap_server_cert_ignore_to_settings_table', 1),
(148, '2015_12_30_233509_add_timestamp_and_userId_to_custom_fields', 1),
(149, '2015_12_30_233658_add_timestamp_and_userId_to_custom_fieldsets', 1),
(150, '2016_01_28_041048_add_notes_to_models', 1),
(151, '2016_02_19_070119_add_remember_token_to_users_table', 1),
(152, '2016_02_19_073625_create_password_resets_table', 1),
(153, '2016_03_02_193043_add_ldap_flag_to_users', 1),
(154, '2016_03_02_220517_update_ldap_filter_to_longer_field', 1),
(155, '2016_03_08_225351_create_components_table', 1),
(156, '2016_03_09_024038_add_min_stock_to_tables', 1),
(157, '2016_03_10_133849_add_locale_to_users', 1),
(158, '2016_03_10_135519_add_locale_to_settings', 1),
(159, '2016_03_11_185621_add_label_settings_to_settings', 1),
(160, '2016_03_22_125911_fix_custom_fields_regexes', 1),
(161, '2016_04_28_141554_add_show_to_users', 1),
(162, '2016_05_16_164733_add_model_mfg_to_consumable', 1),
(163, '2016_05_19_180351_add_alt_barcode_settings', 1),
(164, '2016_05_19_191146_add_alter_interval', 1),
(165, '2016_05_19_192226_add_inventory_threshold', 1),
(166, '2016_05_20_024859_remove_option_keys_from_settings_table', 1),
(167, '2016_05_20_143758_remove_option_value_from_settings_table', 1),
(168, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(169, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(170, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(171, '2016_06_01_000004_create_oauth_clients_table', 1),
(172, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(173, '2016_06_01_140218_add_email_domain_and_format_to_settings', 1),
(174, '2016_06_22_160725_add_user_id_to_maintenances', 1),
(175, '2016_07_13_150015_add_is_ad_to_settings', 1),
(176, '2016_07_14_153609_add_ad_domain_to_settings', 1),
(177, '2016_07_22_003348_fix_custom_fields_regex_stuff', 1),
(178, '2016_07_22_054850_one_more_mac_addr_fix', 1),
(179, '2016_07_22_143045_add_port_to_ldap_settings', 1),
(180, '2016_07_22_153432_add_tls_to_ldap_settings', 1),
(181, '2016_07_27_211034_add_zerofill_to_settings', 1),
(182, '2016_08_02_124944_add_color_to_statuslabel', 1),
(183, '2016_08_04_134500_add_disallow_ldap_pw_sync_to_settings', 1),
(184, '2016_08_09_002225_add_manufacturer_to_licenses', 1),
(185, '2016_08_12_121613_add_manufacturer_to_accessories_table', 1),
(186, '2016_08_23_143353_add_new_fields_to_custom_fields', 1),
(187, '2016_08_23_145619_add_show_in_nav_to_status_labels', 1),
(188, '2016_08_30_084634_make_purchase_cost_nullable', 1),
(189, '2016_09_01_141051_add_requestable_to_asset_model', 1),
(190, '2016_09_02_001448_create_checkout_requests_table', 1),
(191, '2016_09_04_180400_create_actionlog_table', 1),
(192, '2016_09_04_182149_migrate_asset_log_to_action_log', 1),
(193, '2016_09_19_235935_fix_fieldtype_for_target_type', 1),
(194, '2016_09_23_140722_fix_modelno_in_consumables_to_string', 1),
(195, '2016_09_28_231359_add_company_to_logs', 1),
(196, '2016_10_14_130709_fix_order_number_to_varchar', 1),
(197, '2016_10_16_015024_rename_modelno_to_model_number', 1),
(198, '2016_10_16_015211_rename_consumable_modelno_to_model_number', 1),
(199, '2016_10_16_143235_rename_model_note_to_notes', 1),
(200, '2016_10_16_165052_rename_component_total_qty_to_qty', 1),
(201, '2016_10_19_145520_fix_order_number_in_components_to_string', 1),
(202, '2016_10_27_151715_add_serial_to_components', 1),
(203, '2016_10_27_213251_increase_serial_field_capacity', 1),
(204, '2016_10_29_002724_enable_2fa_fields', 1),
(205, '2016_10_29_082408_add_signature_to_acceptance', 1),
(206, '2016_11_01_030818_fix_forgotten_filename_in_action_logs', 1),
(207, '2016_11_13_020954_rename_component_serial_number_to_serial', 1),
(208, '2016_11_16_172119_increase_purchase_cost_size', 1),
(209, '2016_11_17_161317_longer_state_field_in_location', 1),
(210, '2016_11_17_193706_add_model_number_to_accessories', 1),
(211, '2016_11_24_160405_add_missing_target_type_to_logs_table', 1),
(212, '2016_12_07_173720_increase_size_of_state_in_suppliers', 1),
(213, '2016_12_19_004212_adjust_locale_length_to_10', 1),
(214, '2016_12_19_133936_extend_phone_lengths_in_supplier_and_elsewhere', 1),
(215, '2016_12_27_212631_make_asset_assigned_to_polymorphic', 1),
(216, '2017_01_09_040429_create_locations_ldap_query_field', 1),
(217, '2017_01_14_002418_create_imports_table', 1),
(218, '2017_01_25_063357_fix_utf8_custom_field_column_names', 1),
(219, '2017_03_03_154632_add_time_date_display_to_settings', 1),
(220, '2017_03_10_210807_add_fields_to_manufacturer', 1),
(221, '2017_05_08_195520_increase_size_of_field_values_in_custom_fields', 1),
(222, '2017_05_22_204422_create_departments', 1),
(223, '2017_05_22_233509_add_manager_to_locations_table', 1),
(224, '2017_06_14_122059_add_next_autoincrement_to_settings', 1),
(225, '2017_06_18_151753_add_header_and_first_row_to_importer_table', 1),
(226, '2017_07_07_191533_add_login_text', 1),
(227, '2017_07_25_130710_add_thumbsize_to_settings', 1),
(228, '2017_08_03_160105_set_asset_archived_to_zero_default', 1),
(229, '2017_08_22_180636_add_secure_password_options', 1),
(230, '2017_08_25_074822_add_auditing_tables', 1),
(231, '2017_08_25_101435_add_auditing_to_settings', 1),
(232, '2017_09_18_225619_fix_assigned_type_not_being_nulled', 1),
(233, '2017_10_03_015503_drop_foreign_keys', 1),
(234, '2017_10_10_123504_allow_nullable_depreciation_id_in_models', 1),
(235, '2017_10_17_133709_add_display_url_to_settings', 1),
(236, '2017_10_19_120002_add_custom_forgot_password_url', 1),
(237, '2017_10_19_130406_add_image_and_supplier_to_accessories', 1),
(238, '2017_10_20_234129_add_location_indices_to_assets', 1),
(239, '2017_10_25_202930_add_images_uploads_to_locations_manufacturers_etc', 1),
(240, '2017_10_27_180947_denorm_asset_locations', 1),
(241, '2017_10_27_192423_migrate_denormed_asset_locations', 1),
(242, '2017_10_30_182938_add_address_to_user', 1),
(243, '2017_11_08_025918_add_alert_menu_setting', 1),
(244, '2017_11_08_123942_labels_display_company_name', 1),
(245, '2017_12_12_010457_normalize_asset_last_audit_date', 1),
(246, '2017_12_12_033618_add_actionlog_meta', 1),
(247, '2017_12_26_170856_re_normalize_last_audit', 1),
(248, '2018_01_17_184354_add_archived_in_list_setting', 1),
(249, '2018_01_19_203121_add_dashboard_message_to_settings', 1),
(250, '2018_01_24_062633_add_footer_settings_to_settings', 1),
(251, '2018_01_24_093426_add_modellist_preferenc', 1),
(252, '2018_02_22_160436_add_remote_user_settings', 1),
(253, '2018_03_03_011032_add_theme_to_settings', 1),
(254, '2018_03_06_054937_add_default_flag_on_statuslabels', 1),
(255, '2018_03_23_212048_add_display_in_email_to_custom_fields', 1),
(256, '2018_03_24_030738_add_show_images_in_email_setting', 1),
(257, '2018_03_24_050108_add_cc_alerts', 1),
(258, '2018_03_29_053618_add_canceled_at_and_fulfilled_at_in_requests', 1),
(259, '2018_03_29_070121_add_drop_unique_requests', 1),
(260, '2018_03_29_070511_add_new_index_requestable', 1),
(261, '2018_04_16_133902_create_custom_field_default_values_table', 1),
(262, '2018_05_04_073223_add_category_to_licenses', 1),
(263, '2018_05_04_075235_add_update_license_category', 1),
(264, '2018_05_08_031515_add_gdpr_privacy_footer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `depreciation_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `eol` int(11) DEFAULT NULL,
  `min_amt` int(5) NOT NULL DEFAULT '2',
  `normal_amt` int(5) NOT NULL DEFAULT '8',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deprecated_mac_address` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `fieldset_id` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `requestable` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `name`, `model_number`, `manufacturer_id`, `category_id`, `created_at`, `updated_at`, `depreciation_id`, `user_id`, `eol`, `min_amt`, `normal_amt`, `image`, `deprecated_mac_address`, `deleted_at`, `fieldset_id`, `notes`, `requestable`) VALUES
(1, 'Macbook Pro 13"', '4716335729163', 1, 1, '2018-05-15 04:40:20', '2018-05-16 10:36:48', 1, 1, 36, 3, 9, 'mbp.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(2, 'Macbook Air', '5106607288903770', 1, 1, '2018-05-15 04:40:20', '2018-05-16 09:27:24', 1, 1, 36, 2, 8, 'macbookair.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(3, 'Surface', '4716274863403', 2, 1, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 36, 2, 8, 'surface.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(4, 'XPS 13', '4485196041131659', 3, 1, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 36, 2, 8, 'xps.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(5, 'Spectre', '4916303265279', 5, 1, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 36, 2, 8, 'spectre.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(6, 'ZenBook UX310', '2652453158612398', 4, 1, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 36, 2, 8, 'zenbook.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(7, 'Yoga 910', '4916794677221650', 6, 1, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 36, 2, 8, 'yoga.png', 0, NULL, NULL, 'Created by demo seeder', 0),
(8, 'iMac Pro', '5560967752768417', 1, 2, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 24, 2, 8, 'imacpro.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(9, 'Lenovo Intel Core i5', '4903099664810100', 6, 2, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 24, 2, 8, 'lenovoi5.png', 0, NULL, NULL, 'Created by demo seeder', 0),
(10, 'OptiPlex', '5040 (MRR81)', 3, 2, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 24, 2, 8, 'optiplex.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(11, 'SoundStation 2', '4485571193530', 8, 6, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 12, 2, 8, 'soundstation.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(12, 'Polycom CX3000 IP Conference Phone', '4532263847180505', 8, 6, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 12, 2, 8, 'cx3000.png', 0, NULL, NULL, 'Created by demo seeder', 0),
(13, 'iPad Pro', '4929014513325', 1, 3, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 12, 2, 8, 'ipad.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(14, 'Tab3', '2221330144864097', 6, 3, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 12, 2, 8, 'tab3.png', 0, NULL, NULL, 'Created by demo seeder', 0),
(15, 'iPhone 6s', '375082947681297', 1, 4, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 3, 1, 12, 2, 8, 'iphone6.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(16, 'iPhone 7', '2416918385020034', 1, 4, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 1, 1, 12, 2, 8, 'iphone7.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(17, 'Ultrafine 4k', '4539473553041', 7, 5, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 2, 1, 12, 2, 8, 'ultrafine.jpg', 0, NULL, NULL, 'Created by demo seeder', 0),
(18, 'Ultrasharp U2415', '2408019040202008', 3, 5, '2018-05-15 04:40:20', '2018-05-15 04:40:20', 2, 1, 12, 2, 8, 'ultrasharp.jpg', 0, NULL, NULL, 'Created by demo seeder', 0);

-- --------------------------------------------------------

--
-- Table structure for table `models_custom_fields`
--

CREATE TABLE `models_custom_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `asset_model_id` int(11) NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `default_value` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Snipe-IT Personal Access Client', '0Q4DJHpAzRnjxboNbiGWE50hO58ePdZAaN21howb', 'http://localhost', 1, 0, 0, '2018-05-15 04:41:03', '2018-05-15 04:41:03'),
(2, NULL, 'Snipe-IT Password Grant Client', 'NIH89VsrwKWLCQrtTa2Fmi7zpvgijPeRDW7PEB1t', 'http://localhost', 0, 1, 0, '2018-05-15 04:41:03', '2018-05-15 04:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2018-05-15 04:41:03', '2018-05-15 04:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requested_assets`
--

CREATE TABLE `requested_assets` (
  `id` int(10) UNSIGNED NOT NULL,
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `denied_at` datetime DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `request_code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `per_page` int(11) NOT NULL DEFAULT '20',
  `site_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Snipe IT Asset Management',
  `qr_code` int(11) DEFAULT NULL,
  `qr_text` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_asset_name` int(11) DEFAULT NULL,
  `display_checkout_date` int(11) DEFAULT NULL,
  `display_eol` int(11) DEFAULT NULL,
  `auto_increment_assets` int(11) NOT NULL DEFAULT '0',
  `auto_increment_prefix` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `load_remote` tinyint(1) NOT NULL DEFAULT '1',
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alert_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alerts_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `default_eula_text` longtext COLLATE utf8mb4_unicode_ci,
  `barcode_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'QRCODE',
  `slack_endpoint` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slack_channel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slack_botname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_css` text COLLATE utf8mb4_unicode_ci,
  `brand` tinyint(4) NOT NULL DEFAULT '1',
  `ldap_enabled` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_server` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_uname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_pword` longtext COLLATE utf8mb4_unicode_ci,
  `ldap_basedn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_filter` text COLLATE utf8mb4_unicode_ci,
  `ldap_username_field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'samaccountname',
  `ldap_lname_field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'sn',
  `ldap_fname_field` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'givenname',
  `ldap_auth_filter_query` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'uid=samaccountname',
  `ldap_version` int(11) DEFAULT '3',
  `ldap_active_flag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_emp_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_multiple_companies_support` tinyint(1) NOT NULL DEFAULT '0',
  `ldap_server_cert_ignore` tinyint(1) NOT NULL DEFAULT '0',
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `labels_per_page` tinyint(4) NOT NULL DEFAULT '30',
  `labels_width` decimal(6,5) NOT NULL DEFAULT '2.62500',
  `labels_height` decimal(6,5) NOT NULL DEFAULT '1.00000',
  `labels_pmargin_left` decimal(6,5) NOT NULL DEFAULT '0.21975',
  `labels_pmargin_right` decimal(6,5) NOT NULL DEFAULT '0.21975',
  `labels_pmargin_top` decimal(6,5) NOT NULL DEFAULT '0.50000',
  `labels_pmargin_bottom` decimal(6,5) NOT NULL DEFAULT '0.50000',
  `labels_display_bgutter` decimal(6,5) NOT NULL DEFAULT '0.07000',
  `labels_display_sgutter` decimal(6,5) NOT NULL DEFAULT '0.05000',
  `labels_fontsize` tinyint(4) NOT NULL DEFAULT '9',
  `labels_pagewidth` decimal(7,5) NOT NULL DEFAULT '8.50000',
  `labels_pageheight` decimal(7,5) NOT NULL DEFAULT '11.00000',
  `labels_display_name` tinyint(4) NOT NULL DEFAULT '0',
  `labels_display_serial` tinyint(4) NOT NULL DEFAULT '1',
  `labels_display_tag` tinyint(4) NOT NULL DEFAULT '1',
  `alt_barcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'C128',
  `alt_barcode_enabled` tinyint(1) DEFAULT '1',
  `alert_interval` int(11) DEFAULT '30',
  `alert_threshold` int(11) DEFAULT '5',
  `email_domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_format` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'filastname',
  `username_format` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'filastname',
  `is_ad` tinyint(1) NOT NULL DEFAULT '0',
  `ad_domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ldap_port` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '389',
  `ldap_tls` tinyint(1) NOT NULL DEFAULT '0',
  `zerofill_count` int(11) NOT NULL DEFAULT '5',
  `ldap_pw_sync` tinyint(1) NOT NULL DEFAULT '1',
  `two_factor_enabled` tinyint(4) DEFAULT NULL,
  `require_accept_signature` tinyint(1) NOT NULL DEFAULT '0',
  `date_display_format` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y-m-d',
  `time_display_format` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'h:i A',
  `next_auto_tag_base` bigint(20) NOT NULL DEFAULT '1',
  `login_note` text COLLATE utf8mb4_unicode_ci,
  `thumbnail_max_h` int(11) DEFAULT '50',
  `pwd_secure_uncommon` tinyint(1) NOT NULL DEFAULT '0',
  `pwd_secure_complexity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pwd_secure_min` int(11) NOT NULL DEFAULT '8',
  `audit_interval` int(11) DEFAULT NULL,
  `audit_warning_days` int(11) DEFAULT NULL,
  `show_url_in_emails` tinyint(1) NOT NULL DEFAULT '0',
  `custom_forgot_pass_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_alerts_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `labels_display_company_name` tinyint(1) NOT NULL DEFAULT '0',
  `show_archived_in_list` tinyint(1) NOT NULL DEFAULT '0',
  `dashboard_message` text COLLATE utf8mb4_unicode_ci,
  `support_footer` char(5) COLLATE utf8mb4_unicode_ci DEFAULT 'on',
  `footer_text` text COLLATE utf8mb4_unicode_ci,
  `modellist_displays` char(191) COLLATE utf8mb4_unicode_ci DEFAULT 'image,category,manufacturer,model_number',
  `login_remote_user_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `login_common_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `login_remote_user_custom_logout_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `skin` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_images_in_email` tinyint(1) NOT NULL DEFAULT '1',
  `admin_cc_email` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy_policy_link` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `created_at`, `updated_at`, `user_id`, `per_page`, `site_name`, `qr_code`, `qr_text`, `display_asset_name`, `display_checkout_date`, `display_eol`, `auto_increment_assets`, `auto_increment_prefix`, `load_remote`, `logo`, `header_color`, `alert_email`, `alerts_enabled`, `default_eula_text`, `barcode_type`, `slack_endpoint`, `slack_channel`, `slack_botname`, `default_currency`, `custom_css`, `brand`, `ldap_enabled`, `ldap_server`, `ldap_uname`, `ldap_pword`, `ldap_basedn`, `ldap_filter`, `ldap_username_field`, `ldap_lname_field`, `ldap_fname_field`, `ldap_auth_filter_query`, `ldap_version`, `ldap_active_flag`, `ldap_emp_num`, `ldap_email`, `full_multiple_companies_support`, `ldap_server_cert_ignore`, `locale`, `labels_per_page`, `labels_width`, `labels_height`, `labels_pmargin_left`, `labels_pmargin_right`, `labels_pmargin_top`, `labels_pmargin_bottom`, `labels_display_bgutter`, `labels_display_sgutter`, `labels_fontsize`, `labels_pagewidth`, `labels_pageheight`, `labels_display_name`, `labels_display_serial`, `labels_display_tag`, `alt_barcode`, `alt_barcode_enabled`, `alert_interval`, `alert_threshold`, `email_domain`, `email_format`, `username_format`, `is_ad`, `ad_domain`, `ldap_port`, `ldap_tls`, `zerofill_count`, `ldap_pw_sync`, `two_factor_enabled`, `require_accept_signature`, `date_display_format`, `time_display_format`, `next_auto_tag_base`, `login_note`, `thumbnail_max_h`, `pwd_secure_uncommon`, `pwd_secure_complexity`, `pwd_secure_min`, `audit_interval`, `audit_warning_days`, `show_url_in_emails`, `custom_forgot_pass_url`, `show_alerts_in_menu`, `labels_display_company_name`, `show_archived_in_list`, `dashboard_message`, `support_footer`, `footer_text`, `modellist_displays`, `login_remote_user_enabled`, `login_common_disabled`, `login_remote_user_custom_logout_url`, `skin`, `show_images_in_email`, `admin_cc_email`, `privacy_policy_link`) VALUES
(1, '2018-05-15 04:40:38', '2018-05-15 09:49:58', 1, 20, 'Poa! Asset Management', NULL, NULL, NULL, NULL, NULL, 0, '0', 1, NULL, '', 'patrick.mutwiri@poainternet.net', 1, '', 'QRCODE', NULL, NULL, NULL, 'KES', '', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'samaccountname', 'sn', 'givenname', 'uid=samaccountname', 3, NULL, NULL, NULL, 1, 0, 'en', 30, '2.62500', '1.00000', '0.21975', '0.21975', '0.50000', '0.50000', '0.07000', '0.05000', 9, '8.50000', '11.00000', 0, 1, 1, 'C128', 1, 30, 5, 'poainternet.net', 'firstname.lastname', 'firstname.lastname', 0, NULL, '389', 0, 5, 1, NULL, 0, 'D M d, Y', 'h:iA', 1, '', 50, 1, '', 10, 0, 0, 1, NULL, 1, 0, 0, '', 'on', '', 'image,category,manufacturer,model_number', 0, 0, '', '', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `status_labels`
--

CREATE TABLE `status_labels` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deployable` tinyint(1) NOT NULL DEFAULT '0',
  `pending` tinyint(1) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_in_nav` tinyint(1) NOT NULL DEFAULT '0',
  `default_label` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_labels`
--

INSERT INTO `status_labels` (`id`, `name`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `deployable`, `pending`, `archived`, `notes`, `color`, `show_in_nav`, `default_label`) VALUES
(1, 'Ready to Deploy', 1, '2016-01-31 02:13:41', '1979-08-03 01:12:13', NULL, 1, 0, 0, 'Accusamus animi et nulla blanditiis reprehenderit blanditiis nulla sit.', NULL, 0, 1),
(2, 'Pending', 1, '1987-07-04 13:57:43', '2015-03-27 14:24:07', NULL, 0, 1, 0, 'Dolore qui eveniet repellat dolorem qui.', NULL, 0, 1),
(3, 'Archived', 1, '2017-03-27 19:22:39', '1995-02-03 03:44:05', NULL, 0, 0, 1, 'These assets are permanently undeployable', NULL, 0, 0),
(4, 'Out for Diagnostics', 1, '2018-04-28 12:06:06', '1999-02-22 04:05:03', NULL, 0, 0, 0, '', NULL, 0, 0),
(5, 'Out for Repair', 1, '2001-06-14 09:55:44', '2002-04-07 12:35:20', NULL, 0, 0, 0, '', NULL, 0, 0),
(6, 'Broken - Not Fixable', 1, '1981-11-08 07:19:21', '1989-04-15 03:24:07', NULL, 0, 0, 0, '', NULL, 0, 0),
(7, 'Lost/Stolen', 1, '1990-10-01 23:21:43', '1991-04-20 02:05:13', NULL, 0, 0, 0, '', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `address`, `address2`, `city`, `state`, `country`, `phone`, `fax`, `email`, `contact`, `notes`, `created_at`, `updated_at`, `user_id`, `deleted_at`, `zip`, `url`, `image`) VALUES
(1, 'Leuschke, Luettgen and Denesik', '8506 Ozella Plains', 'Apt. 911', 'Vandervorttown', 'AZ', 'BE', '329-529-3097', '826-680-8448 x0266', 'ajerde@example.com', 'Jazmyne Lebsack', 'Dolores eos et occaecati exercitationem. Dolore repellat consectetur aliquid et ea est. Non ut ut alias aliquid omnis ut. Aut et ut molestias aut eveniet soluta et.', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL, '85319-5433', 'https://www.stoltenberg.com/delectus-rerum-numquam-et-quas-voluptate-eum-quia', NULL),
(2, 'O\'Hara, Lynch and McLaughlin', '50629 Zula Court', 'Apt. 921', 'Janellefort', 'NJ', 'ET', '+1 (427) 991-5305', '(545) 729-5563 x2350', 'turner.aimee@example.com', 'Angelita Wiegand', 'Repudiandae iusto ea quae consequatur iure culpa illo. Qui quisquam sint animi dolorem est. Quibusdam et magnam repellat sunt voluptas sint.', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL, '82533-5503', 'https://toy.com/sapiente-amet-molestias-sapiente-quo-quidem-officiis-earum.html', NULL),
(3, 'Mante, Gorczany and Schulist', '35287 Marguerite Locks Suite 688', 'Apt. 872', 'East Cassandraport', 'AZ', 'MZ', '446-201-7941 x12097', '+1.591.873.4678', 'mueller.constantin@example.net', 'Isidro Rippin', 'Recusandae id pariatur porro et porro non. Alias omnis enim quae dolores sapiente placeat. Vel nisi quam ut totam laboriosam quia. Optio magnam rerum odit et quisquam sed sunt.', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL, '21116-4006', 'http://rau.com/aliquid-quae-ducimus-maiores-fuga-rerum-quis', NULL),
(4, 'Rohan-Tromp', '41459 Jaskolski Divide Suite 616', 'Apt. 364', 'South Casperfurt', 'NJ', 'ZM', '(765) 722-7176 x405', '1-723-619-5487 x704', 'eledner@example.net', 'Gregory Block', 'Est delectus qui nobis nulla et alias. Sed perspiciatis ratione iusto qui ipsa. Voluptates non ab qui fugiat optio ipsam.', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL, '62703-4618', 'https://cruickshank.com/commodi-nulla-aut-consequatur-aperiam.html', NULL),
(5, 'Jenkins, Mills and Effertz', '611 Luettgen Fork', 'Suite 875', 'North Lennyview', 'NE', 'TM', '629.694.0354', '(782) 942-3958 x9941', 'phoebe74@example.com', 'Marcellus Lockman', 'Qui enim neque deserunt sit doloremque. Corrupti repellat culpa molestiae asperiores magni.', '2018-05-15 04:40:20', '2018-05-15 04:40:20', NULL, NULL, '45496', 'http://www.kunde.com/molestiae-cupiditate-quo-enim-iure.html', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE `throttle` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jobtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `employee_num` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `remember_token` text COLLATE utf8mb4_unicode_ci,
  `ldap_import` tinyint(1) NOT NULL DEFAULT '0',
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `show_in_list` tinyint(1) NOT NULL DEFAULT '1',
  `two_factor_secret` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_enrolled` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_optin` tinyint(1) NOT NULL DEFAULT '0',
  `department_id` int(11) DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `created_at`, `updated_at`, `deleted_at`, `website`, `country`, `gravatar`, `location_id`, `phone`, `jobtitle`, `manager_id`, `employee_num`, `avatar`, `username`, `notes`, `company_id`, `remember_token`, `ldap_import`, `locale`, `show_in_list`, `two_factor_secret`, `two_factor_enrolled`, `two_factor_optin`, `department_id`, `address`, `city`, `state`, `zip`) VALUES
(1, 'patrick.mutwiri@poainternet.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"superuser":"1","admin":"0","reports.view":"0","assets.view":"0","assets.create":"0","assets.edit":"0","assets.delete":"0","assets.checkin":"0","assets.checkout":"0","assets.audit":"0","assets.view.requestable":"0","accessories.view":"0","accessories.create":"0","accessories.edit":"0","accessories.delete":"0","accessories.checkout":"0","accessories.checkin":"0","consumables.view":"-1","consumables.create":"-1","consumables.edit":"-1","consumables.delete":"-1","consumables.checkout":"-1","licenses.view":"0","licenses.create":"0","licenses.edit":"0","licenses.delete":"0","licenses.checkout":"0","licenses.keys":"0","components.view":"0","components.create":"0","components.edit":"0","components.delete":"0","components.checkout":"0","components.checkin":"0","users.view":"0","users.create":"0","users.edit":"0","users.delete":"0","models.view":"0","models.create":"0","models.edit":"0","models.delete":"0","categories.view":"0","categories.create":"0","categories.edit":"0","categories.delete":"0","departments.view":"0","departments.create":"0","departments.edit":"0","departments.delete":"0","statuslabels.view":"0","statuslabels.create":"0","statuslabels.edit":"0","statuslabels.delete":"0","customfields.view":"0","customfields.create":"0","customfields.edit":"0","customfields.delete":"0","suppliers.view":"0","suppliers.create":"0","suppliers.edit":"0","suppliers.delete":"0","manufacturers.view":"0","manufacturers.create":"0","manufacturers.edit":"0","manufacturers.delete":"0","depreciations.view":"0","depreciations.create":"0","depreciations.edit":"0","depreciations.delete":"0","locations.view":"0","locations.create":"0","locations.edit":"0","locations.delete":"0","companies.view":"0","companies.create":"0","companies.edit":"0","companies.delete":"0","self.two_factor":"0","self.api":"0"}', 1, NULL, NULL, '2018-05-17 01:59:50', NULL, NULL, 'Mutwiri', 'Patrick', '2018-05-15 04:40:20', '2018-05-17 01:59:50', NULL, 'poainternet.net', 'KE', 'patwiri@gmail.com', 1, '', 'Developer', 0, '30684', NULL, 'admin', 'Created by DB seeder', 0, 'rIPrO1ulTXaoSJ6vkIKR2c7K50c84mWZyERQ6SKrxaiAmXayiDfdCywgtonE', 0, 'en', 1, NULL, 0, 0, 2, 'Ngong Rd', 'Nairobi', 'KE', '00100'),
(2, 'snipe@snipe.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"superuser":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Snipe E.', 'Head', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Peru', NULL, 1, '1-702-345-5952 x954', 'Numerical Tool Programmer OR Process Control Programmer', NULL, '22068', NULL, 'snipe', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 3, '969 Cronin Center Suite 834\nNew Maxwellstad, IL 62274-8723', 'North Kelvin', 'SD', '80798'),
(3, 'mante.willa@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"superuser":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Kara', 'Effertz', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Netherlands', NULL, 1, '+1 (628) 928-3993', 'Postsecondary Teacher', NULL, '26435', NULL, 'tatyana.franecki', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 1, '131 Monica Land Apt. 027\nAlexiefurt, KY 18445-1028', 'Rosenbaumport', 'MD', '05651'),
(4, 'clovis09@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"superuser":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Raymond', 'Tromp', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Malaysia', NULL, 1, '1-495-367-4497 x354', 'Communication Equipment Repairer', NULL, '4027', NULL, 'robert95', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 3, '8449 Botsford Common\nKonopelskiview, IL 93692', 'Florencioburgh', 'CA', '32834-3174'),
(5, 'vschamberger@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"superuser":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Samara', 'Hettinger', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Bangladesh', NULL, 1, '562-837-3166', 'Meter Mechanic', NULL, '24323', NULL, 'rodriguez.jeffery', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 5, '849 Little Grove\nSambury, WY 02648', 'Port Aric', 'TN', '60088-4529'),
(6, 'abogan@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"admin":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Henriette', 'Nolan', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Bouvet Island (Bouvetoya)', NULL, 1, '598-427-9989', 'Molding and Casting Worker', 2, '33141', NULL, 'botsford.lorenza', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 2, '52318 Brakus Cove\nSchimmelmouth, AZ 71341', 'Huelsmouth', 'AR', '84593-7948'),
(7, 'ulebsack@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"admin":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Kris', 'Braun', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Turks and Caicos Islands', NULL, 1, '626-703-3226', 'Photographic Processing Machine Operator', 1, '5787', NULL, 'giuseppe.stamm', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 5, '85506 Maci Mall Apt. 998\nEast Angelitaport, ID 89562', 'New Santos', 'TX', '60527-9066'),
(8, 'bauer@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"admin":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Layla', 'Harvey', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Chad', NULL, 1, '228.651.1842 x864', 'Healthcare Support Worker', 2, '19634', NULL, 'boehm.evelyn', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 4, '6510 Citlalli Light Apt. 759\nDerrickborough, GA 12324', 'South Kallie', 'WI', '51361-0026'),
(9, 'egoyette@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Janessa', 'Schmidt', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Italy', NULL, 1, '897-833-7830 x30639', 'Precision Devices Inspector', NULL, '31523', NULL, 'albertha91', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 2, '794 Haley Ports Apt. 879\nEast Kristy, WY 81693', 'Littlehaven', 'MI', '65086'),
(10, 'eliane53@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Ebba', 'Bayer', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Slovenia', NULL, 1, '+1-552-443-7813', 'Auxiliary Equipment Operator', NULL, '14206', NULL, 'vonrueden.mireya', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 2, '48378 Rhoda Squares Apt. 643\nNicklauston, NH 63715-6426', 'Hauckview', 'WY', '61911-2439'),
(11, 'jaqueline.renner@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Lilly', 'Metz', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Kyrgyz Republic', NULL, 1, '1-396-506-5069 x2183', 'Production Laborer', NULL, '8257', NULL, 'pbeahan', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 5, '97003 Klocko Forks\nSouth Karinestad, NC 36451-2258', 'Adaburgh', 'MO', '93018'),
(12, 'purdy.tate@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Gretchen', 'Gusikowski', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Tanzania', NULL, 1, '+18739198981', 'New Accounts Clerk', NULL, '5907', NULL, 'hettie.kuphal', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 4, '729 Lemke Inlet\nEast Layla, MN 84929-1378', 'Goodwinmouth', 'NE', '06253'),
(13, 'ukautzer@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Zena', 'Hintz', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Gambia', NULL, 1, '294-769-1749', 'Producer', NULL, '17197', NULL, 'mohr.greyson', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 4, '542 Hilpert Circles\nKolbyland, OR 83289', 'Halvorsonport', 'DE', '11078'),
(14, 'orunolfsdottir@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Jeromy', 'Hane', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Lao People\'s Democratic Republic', NULL, 1, '582.656.2146 x07886', 'Glazier', NULL, '8316', NULL, 'adibbert', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 5, '28828 Virginia Ridges Apt. 783\nEast Tannerport, OH 46638', 'Cartwrightmouth', 'NE', '76909'),
(15, 'estel33@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Alexzander', 'Mitchell', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Heard Island and McDonald Islands', NULL, 1, '1-689-921-9646 x8625', 'Library Science Teacher', NULL, '34180', NULL, 'hills.laila', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 3, '97251 Chadd Oval Apt. 994\nWilfridbury, NE 96610-2745', 'Port Ward', 'VT', '48822-9932'),
(16, 'audreanne.ferry@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Brannon', 'McCullough', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Sao Tome and Principe', NULL, 1, '840.819.0349', 'Radio Operator', NULL, '20387', NULL, 'mwhite', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 3, '1440 Lamar Port\nJulieview, AZ 19720', 'Lake Hailee', 'RI', '41826-5752'),
(17, 'carmella.tromp@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Oleta', 'Heathcote', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Togo', NULL, 1, '457-699-2016 x208', 'Biological Scientist', NULL, '20134', NULL, 'wbradtke', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 1, '35827 Aliza Underpass\nNorth Nicolastown, KY 18549-2979', 'Lake Coy', 'KS', '07524'),
(18, 'aleen44@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Claudine', 'White', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Vietnam', NULL, 1, '698-951-5439 x413', 'Coaches and Scout', NULL, '17957', NULL, 'victor.bahringer', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 4, '95717 Jadon Springs\nKozeyville, AR 71926-8515', 'Dickiborough', 'IN', '03538-1477'),
(19, 'alec74@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Josefa', 'Bartell', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Costa Rica', NULL, 1, '596-337-8432 x5394', 'Recreation Worker', NULL, '28424', NULL, 'niko47', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 6, '4348 Powlowski Pike Apt. 710\nSouth Lizaport, AL 12714', 'Carterview', 'WI', '48324'),
(20, 'darby.bode@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Sally', 'Jones', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Saint Barthelemy', NULL, 1, '1-780-899-8139 x70395', 'Painter and Illustrator', NULL, '18341', NULL, 'meggie79', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 6, '79215 Zulauf Pine Suite 105\nNorth Walter, KS 95216-7672', 'Neilfurt', 'MD', '15912'),
(21, 'reinger.eliza@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Dante', 'Hartmann', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Syrian Arab Republic', NULL, 1, '408-669-3149 x49212', 'Claims Taker', NULL, '4429', NULL, 'alvena40', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 2, '4776 Lindgren Camp Apt. 667\nEast Cullenburgh, MD 46829-3090', 'Lake Mariamland', 'AR', '71951'),
(22, 'rocio.vonrueden@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Shaylee', 'Hoppe', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Romania', NULL, 1, '247-824-7256 x946', 'Infantry Officer', NULL, '4091', NULL, 'murray.evie', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 3, '335 Hubert Station\nSouth Garthtown, DC 69003-3573', 'Bernierburgh', 'WV', '73767'),
(23, 'narciso62@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Garry', 'Abshire', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Guyana', NULL, 1, '797.484.3615', 'Roofer', NULL, '12654', NULL, 'moore.adrienne', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 5, '778 Graham Flat Suite 592\nEast Abdielmouth, CA 61693-7849', 'East Howell', 'MO', '09670-3275'),
(24, 'gerhard.deckow@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Mariana', 'Brown', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Malawi', NULL, 1, '1-201-345-9650', 'Computer Hardware Engineer', NULL, '8423', NULL, 'samir36', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 5, '175 Daniel Springs Suite 299\nReichertview, WA 86415-1090', 'Lake Wainoburgh', 'WA', '85005-2059'),
(25, 'metz.joan@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Ephraim', 'Senger', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Sierra Leone', NULL, 1, '(552) 807-6058 x8539', 'Sewing Machine Operator', NULL, '18959', NULL, 'brakus.paul', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 2, '702 Maybell Track Apt. 422\nLake Kristaland, NE 49067-1010', 'East Kale', 'WV', '67279-7836'),
(26, 'ward.marlin@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Kelvin', 'Macejkovic', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Northern Mariana Islands', NULL, 1, '(696) 281-6624 x71827', 'Dragline Operator', NULL, '21226', NULL, 'uhuels', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 2, '3675 Greenholt Roads\nOlenstad, IN 67523-9240', 'Port Dallin', 'NM', '24329'),
(27, 'rodriguez.keanu@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Alejandra', 'Brekke', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Lao People\'s Democratic Republic', NULL, 1, '635.410.6470 x59734', 'Mold Maker', NULL, '28878', NULL, 'hoeger.al', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 1, '56822 Myriam Terrace Suite 257\nGerholdland, NJ 52623', 'Julianaberg', 'WV', '13213'),
(28, 'zane14@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Noemie', 'Schaefer', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Christmas Island', NULL, 1, '+1 (840) 438-7134', 'Mechanical Engineer', NULL, '15915', NULL, 'misael31', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 6, '8944 Cole Pike Suite 351\nEast Bonita, KS 76954-1135', 'Brakusstad', 'NE', '78504-3315'),
(29, 'shanel.kovacek@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Helena', 'Satterfield', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Niue', NULL, 1, '953-304-7364 x451', 'Rail Yard Engineer', NULL, '6167', NULL, 'sawayn.cecilia', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 3, '1635 Russ Shoal Apt. 541\nGeorgiannaport, WA 99095-6098', 'West Wade', 'OR', '76144-7445'),
(30, 'asipes@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Dudley', 'Casper', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Mauritius', NULL, 1, '(989) 269-6578 x23243', 'Press Machine Setter, Operator', NULL, '11113', NULL, 'cassin.gillian', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 6, '3100 Haag Gardens Apt. 794\nLake Sigmundbury, NV 60522', 'East Skylatown', 'ME', '39331'),
(31, 'lia.ryan@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Frederick', 'Wilkinson', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Singapore', NULL, 1, '939-952-6018', 'Woodworking Machine Operator', NULL, '15600', NULL, 'hfritsch', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 5, '71491 Zula Mountain Suite 169\nNorth Colbyshire, KY 50037-3747', 'North Raul', 'TX', '94396-5199'),
(32, 'kaela34@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Josefina', 'Mayert', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Cote d\'Ivoire', NULL, 1, '1-297-443-4233 x8520', 'Mold Maker', NULL, '20954', NULL, 'elton78', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 2, '87001 Terry Route\nWildermanhaven, ID 28722-2167', 'Dickensberg', 'MS', '00501'),
(33, 'tnitzsche@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Alexa', 'Borer', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Chad', NULL, 1, '836-372-7718 x3549', 'Sales and Related Workers', NULL, '28227', NULL, 'russel.marcelle', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 3, '269 Rogelio Road\nBlandaland, AZ 49920', 'Gunnerstad', 'NY', '92820-4522'),
(34, 'qschaden@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Jarrod', 'Kreiger', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'New Zealand', NULL, 1, '989-350-8964 x70278', 'Animal Husbandry Worker', NULL, '21915', NULL, 'manley07', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 6, '73578 Sheldon Curve Suite 796\nSouth Javierport, TN 92304-5168', 'New Stephanie', 'TN', '41369'),
(35, 'ollie05@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Brandt', 'Pacocha', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Gambia', NULL, 1, '1-971-825-6024 x38350', 'Refinery Operator', NULL, '20431', NULL, 'tcarroll', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 2, '60481 Mitchell Hill Suite 826\nPort Dariana, LA 65166', 'West Crystal', 'WV', '75441'),
(36, 'cummings.frank@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Kendra', 'Macejkovic', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Anguilla', NULL, 1, '403-778-9640 x96278', 'Night Shift', NULL, '15985', NULL, 'alphonso32', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 5, '4808 Little Inlet Apt. 901\nLake Shanieton, AZ 28396', 'South Eusebiotown', 'DC', '69657'),
(37, 'sherzog@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Brain', 'Altenwerth', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Afghanistan', NULL, 1, '(650) 386-3715 x7892', 'Stonemason', NULL, '23094', NULL, 'zakary.metz', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 5, '13111 Carlee Coves\nDarleneburgh, MD 03659-7707', 'Wintheiserside', 'TN', '28823'),
(38, 'wtreutel@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Amaya', 'Waelchi', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Luxembourg', NULL, 1, '(298) 905-0859 x848', 'Chemical Technician', NULL, '27839', NULL, 'xratke', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 3, '880 Hegmann Plains\nWest Jannie, RI 86535-8674', 'Reinatown', 'PA', '08006-3680'),
(39, 'golden.eichmann@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Raphaelle', 'Towne', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Albania', NULL, 1, '1-445-538-5860 x5850', 'Title Searcher', NULL, '26418', NULL, 'taya.yundt', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 4, '18043 Rath Pass Apt. 985\nNew Norvalborough, WI 38935', 'Boscoton', 'KS', '27279'),
(40, 'mckenna75@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Karolann', 'Skiles', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Palestinian Territories', NULL, 1, '1-292-895-2240 x630', 'Counselor', NULL, '33121', NULL, 'pstehr', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 4, '79691 America Mountain Apt. 192\nWest Cristalview, SC 09570-3979', 'West Armandchester', 'KY', '52416'),
(41, 'rfeest@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Tyshawn', 'Donnelly', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'El Salvador', NULL, 1, '484.651.9878', 'Logging Equipment Operator', NULL, '26231', NULL, 'khowell', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 4, '627 Kovacek Brook Apt. 897\nNorth Monty, WV 57013', 'Port Erik', 'NH', '74923'),
(42, 'grimes.sabina@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Antonetta', 'Johnson', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Guinea-Bissau', NULL, 1, '1-361-382-5293', 'Marking Clerk', NULL, '17203', NULL, 'regan92', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 4, '2261 Crooks Lodge Suite 143\nSouth Idellport, SC 89548', 'Port Brenna', 'DE', '85593-5106'),
(43, 'nbradtke@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Kelsie', 'Jacobi', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'French Polynesia', NULL, 1, '1-791-667-7316 x8433', 'Internist', NULL, '12825', NULL, 'ted.wolf', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 1, '395 Monahan Mountain\nOsinskiton, CA 51765', 'Jessicaland', 'IL', '71209'),
(44, 'cecelia70@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Freeda', 'Carroll', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Namibia', NULL, 1, '1-217-912-4233 x168', 'Construction', NULL, '30695', NULL, 'emmie.cronin', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 4, '496 Matteo Coves\nBillville, CT 98056-7606', 'Brainport', 'MN', '39968'),
(45, 'dschuppe@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Jarod', 'Prosacco', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Palestinian Territories', NULL, 1, '(361) 619-9186', 'Woodworking Machine Setter', NULL, '29231', NULL, 'xzemlak', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 6, '2795 Dare Mountain Suite 042\nLake Judgeport, SD 47170', 'Devinville', 'HI', '35787-0787'),
(46, 'ghowe@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Jayce', 'Douglas', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Kyrgyz Republic', NULL, 1, '1-513-900-0169 x125', 'Pipe Fitter', NULL, '13674', NULL, 'delaney.senger', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 5, '6453 Hudson Glens\nNew Claudeside, MO 18433', 'New Gussiehaven', 'IL', '94193'),
(47, 'brennon.turner@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Roel', 'Pouros', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Senegal', NULL, 1, '(989) 400-9521', 'Dot Etcher', NULL, '32523', NULL, 'dianna.goyette', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 1, '23727 Sherman Extension Apt. 114\nUrbanfort, WV 81654', 'Margaretchester', 'TN', '15696-0613'),
(48, 'dickens.dawn@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Friedrich', 'Dach', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Zimbabwe', NULL, 1, '+18137924733', 'Stock Clerk', NULL, '25014', NULL, 'callie98', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 1, '8271 Lois Keys Suite 457\nNew Arnoside, MI 68745-7794', 'Port Skylaborough', 'AL', '36310-4780'),
(49, 'arch63@example.net', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Oma', 'Hand', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Greece', NULL, 1, '257-416-9965 x44330', 'Lifeguard', NULL, '22085', NULL, 'katherine.frami', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 2, '58372 Tiffany Knoll\nKundeborough, GA 46463-4017', 'West Jaydaberg', 'DC', '17296'),
(50, 'champlin.gaetano@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Easton', 'Ernser', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Palestinian Territories', NULL, 1, '838.826.3371', 'Online Marketing Analyst', NULL, '9954', NULL, 'alysson.greenfelder', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 5, '439 Grady Villages Apt. 863\nO\'Connerside, LA 29649-5430', 'East Leatha', 'NE', '99335'),
(51, 'quigley.henri@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Loyce', 'Toy', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'British Indian Ocean Territory (Chagos Archipelago)', NULL, 1, '576-692-0447', 'Fire-Prevention Engineer', NULL, '27438', NULL, 'uohara', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 3, '98893 Robyn Avenue\nMoniquefurt, KS 35039', 'Pearlineberg', 'RI', '11451'),
(52, 'kulas.lavonne@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Percival', 'Casper', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'New Caledonia', NULL, 1, '(540) 978-5704 x39629', 'Pipelaying Fitter', NULL, '22547', NULL, 'barrett.kuhic', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 4, '668 Rene Plaza Apt. 752\nJenkinsbury, MA 69300-1132', 'Sporerberg', 'AK', '38565-2949'),
(53, 'valentina84@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Greyson', 'Borer', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Portugal', NULL, 1, '209-439-3079 x24695', 'Carpenter Assembler and Repairer', NULL, '19584', NULL, 'prohaska.laron', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 4, '8831 Parker Lodge\nLake Josianefort, VA 05504-4256', 'Greenholthaven', 'VA', '13970'),
(54, 'xklein@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Ryder', 'Kris', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Estonia', NULL, 1, '209-302-2838 x182', 'Music Composer', NULL, '29121', NULL, 'agibson', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 1, '288 Ondricka Trace Suite 357\nPort Sabina, WY 86127-2815', 'East Etha', 'AL', '15449-0175'),
(55, 'kortiz@example.org', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Catherine', 'Fay', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Indonesia', NULL, 1, '(616) 995-4106 x2743', 'Freight Inspector', NULL, '32013', NULL, 'dagmar.bednar', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 6, '138 Connelly Streets Apt. 268\nLuzberg, MO 30853-6849', 'Hesselmouth', 'TN', '19582-4033'),
(56, 'myrtice.dubuque@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Marcos', 'Maggio', '2018-05-15 04:40:20', '2018-05-15 10:53:45', NULL, NULL, 'Niue', NULL, 1, '(947) 861-4206 x034', 'Umpire and Referee', NULL, '11444', NULL, 'deckow.efren', 'Created by DB seeder', 4, NULL, 0, 'en', 1, NULL, 0, 0, 3, '5573 Collier Ports\nNew Evanbury, OK 57023-7744', 'New Pierre', 'NM', '79034-5255'),
(57, 'hardy.crona@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Ahmad', 'Homenick', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'New Zealand', NULL, 1, '1-692-653-7347', 'Shuttle Car Operator', NULL, '22377', NULL, 'bosco.salma', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 4, '85158 Mosciski Station Apt. 502\nHudsonborough, SD 50325-3867', 'Jeanville', 'NM', '94110-4427'),
(58, 'kyle82@example.com', '$2y$10$nkHzlc/cFLv/KAgJ0Wk/KOi7T0ka0N9rUAt87b9..f6EZK2wG2NaO', '{"assets.view":"1"}', 1, NULL, NULL, NULL, NULL, NULL, 'Donald', 'Daniel', '2018-05-15 04:40:20', '2018-05-15 10:52:57', NULL, NULL, 'Netherlands', NULL, 1, '+1-445-996-6537', 'Electrical Engineer', NULL, '6818', NULL, 'turcotte.reyes', 'Created by DB seeder', 1, NULL, 0, 'en', 1, NULL, 0, 0, 5, '92803 Frami Coves\nKovacekmouth, ND 20990', 'Millerport', 'WY', '03598'),
(59, 'mutwiri.muriungi@poainternet.net', 'CNHnfYEMBGleWsxh6avm', NULL, 0, NULL, NULL, NULL, NULL, NULL, 'mutwiri', 'muriungi', '2018-05-15 10:46:35', '2018-05-15 10:53:45', NULL, NULL, NULL, NULL, 1, '63-(199)661-2186', 'Clinical Specialist', NULL, '7080919053', NULL, 'mutwiri.muriungi', NULL, 4, NULL, 0, 'en', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(60, 'collins.pamba@poainternet.net', 'CNHnfYEMBGleWsxh6avm', NULL, 0, NULL, NULL, NULL, NULL, NULL, 'collins', 'pamba', '2018-05-15 10:46:35', '2018-05-15 10:52:57', NULL, NULL, NULL, NULL, 1, '7-(885)578-0266', 'Paralegal', NULL, '6284292031', NULL, 'collins.pamba', NULL, 1, NULL, 0, 'en', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(61, 'dj.koeman@poainternet.net', 'CNHnfYEMBGleWsxh6avm', NULL, 0, NULL, NULL, NULL, NULL, NULL, 'dj', 'koeman', '2018-05-15 10:46:35', '2018-05-15 10:52:57', NULL, NULL, NULL, NULL, 1, '86-(366)635-5884', 'Nurse Practicioner', NULL, '7242692202', NULL, 'dj.koeman', NULL, 1, NULL, 0, 'en', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(62, 'mike.rhodes@poainternet.net', 'CNHnfYEMBGleWsxh6avm', NULL, 0, NULL, NULL, NULL, NULL, NULL, 'mike', 'rhodes', '2018-05-15 10:46:35', '2018-05-15 10:53:45', NULL, NULL, NULL, NULL, 1, '385-(688)644-8322', 'Senior Sales Associate', NULL, '9173736066', NULL, 'mike.rhodes', NULL, 4, NULL, 0, 'en', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(63, 'emma.crompton@poainternet.net', 'CNHnfYEMBGleWsxh6avm', NULL, 0, NULL, NULL, NULL, NULL, NULL, 'emma', 'crompton', '2018-05-15 10:46:35', '2018-05-15 10:53:45', NULL, NULL, NULL, NULL, 1, '86-(163)912-1915', 'Human Resources Manager', NULL, '4692183691', NULL, 'emma.crompton', NULL, 4, NULL, 0, 'en', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(64, 'user.one@poainternet.net', 'CNHnfYEMBGleWsxh6avm', NULL, 0, NULL, NULL, NULL, NULL, NULL, 'user', 'one', '2018-05-15 10:46:35', '2018-05-15 10:53:45', NULL, NULL, NULL, NULL, 1, '86-(303)287-0739', 'Civil Engineer', NULL, '1530903416', NULL, 'user.one', NULL, 4, NULL, 0, 'en', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(65, 'user.two@poainternet.net', 'CNHnfYEMBGleWsxh6avm', NULL, 0, NULL, NULL, NULL, NULL, NULL, 'user', 'two', '2018-05-15 10:46:35', '2018-05-15 10:53:45', NULL, NULL, NULL, NULL, 1, '224-(953)650-5363', 'Software Engineer II', NULL, '7026212001', NULL, 'user.two', NULL, 4, NULL, 0, 'en', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(66, 'user.three@poainternet.net', 'CNHnfYEMBGleWsxh6avm', NULL, 0, NULL, NULL, NULL, NULL, NULL, 'user', 'three', '2018-05-15 10:46:35', '2018-05-15 10:53:45', NULL, NULL, NULL, NULL, 1, '86-(152)931-1194', 'Dental Hygienist', NULL, '4576525239', NULL, 'user.three', NULL, 4, NULL, 0, 'en', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL),
(67, 'user.four@poainternet.net', 'CNHnfYEMBGleWsxh6avm', NULL, 0, NULL, NULL, NULL, NULL, NULL, 'user', 'four', '2018-05-15 10:46:35', '2018-05-15 10:53:45', NULL, NULL, NULL, NULL, 1, '7-(743)929-2565', 'Computer Systems Analyst III', NULL, '6187297644', NULL, 'user.four', NULL, 4, NULL, 0, 'en', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories`
--
ALTER TABLE `accessories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accessories_users`
--
ALTER TABLE `accessories_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `action_logs`
--
ALTER TABLE `action_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_logs_thread_id_index` (`thread_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assets_rtd_location_id_index` (`rtd_location_id`),
  ADD KEY `assets_assigned_type_assigned_to_index` (`assigned_type`,`assigned_to`);

--
-- Indexes for table `asset_logs`
--
ALTER TABLE `asset_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_maintenances`
--
ALTER TABLE `asset_maintenances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_uploads`
--
ALTER TABLE `asset_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkout_requests`
--
ALTER TABLE `checkout_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checkout_requests_user_id_requestable_id_requestable_type` (`user_id`,`requestable_id`,`requestable_type`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_name_unique` (`name`);

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `components_assets`
--
ALTER TABLE `components_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consumables`
--
ALTER TABLE `consumables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consumables_users`
--
ALTER TABLE `consumables_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fieldsets`
--
ALTER TABLE `custom_fieldsets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `depreciations`
--
ALTER TABLE `depreciations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `license_seats`
--
ALTER TABLE `license_seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models_custom_fields`
--
ALTER TABLE `models_custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `requested_assets`
--
ALTER TABLE `requested_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_labels`
--
ALTER TABLE `status_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `throttle`
--
ALTER TABLE `throttle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `throttle_user_id_index` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_activation_code_index` (`activation_code`),
  ADD KEY `users_reset_password_code_index` (`reset_password_code`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`user_id`,`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories`
--
ALTER TABLE `accessories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `accessories_users`
--
ALTER TABLE `accessories_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `action_logs`
--
ALTER TABLE `action_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=419;
--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1374;
--
-- AUTO_INCREMENT for table `asset_logs`
--
ALTER TABLE `asset_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `asset_maintenances`
--
ALTER TABLE `asset_maintenances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `asset_uploads`
--
ALTER TABLE `asset_uploads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `checkout_requests`
--
ALTER TABLE `checkout_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `components_assets`
--
ALTER TABLE `components_assets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `consumables`
--
ALTER TABLE `consumables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `consumables_users`
--
ALTER TABLE `consumables_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `custom_fieldsets`
--
ALTER TABLE `custom_fieldsets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `depreciations`
--
ALTER TABLE `depreciations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `license_seats`
--
ALTER TABLE `license_seats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;
--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `models_custom_fields`
--
ALTER TABLE `models_custom_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `requested_assets`
--
ALTER TABLE `requested_assets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `status_labels`
--
ALTER TABLE `status_labels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
