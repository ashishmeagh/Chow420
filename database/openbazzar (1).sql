-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 13, 2019 at 07:45 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `openbazzar`
--

-- --------------------------------------------------------

--
-- Table structure for table `activations`
--

CREATE TABLE `activations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, '', 1, '2019-02-24 18:30:00', NULL, NULL),
(2, 2, '93z1zMyJ7GCc5RpTxjV5HljkdwbgNvFj', 1, '2019-02-25 01:13:04', '2019-02-25 01:06:51', '2019-02-25 01:13:04'),
(4, 4, 'EAfzBHdu0U3Hi5jbz4imsgCr7dMfIzS2', 1, '2019-02-25 03:49:11', '2019-02-25 03:46:04', '2019-02-25 03:49:11'),
(5, 5, 'rYQneX7ZoAgXxArCbASJlyvxDZeNnAKn', 1, '2019-02-25 03:49:02', '2019-02-25 03:47:58', '2019-02-25 03:49:02'),
(6, 6, '66dIN0ZkPk22tGt8oGeGzT72JTBGmuh4', 1, '2019-02-25 22:22:21', '2019-02-25 22:21:58', '2019-02-25 22:22:21'),
(7, 7, 'TMi7MMN793j11hLzk3PVywdSRWBolRLq', 1, '2019-03-05 23:25:37', '2019-03-05 23:25:07', '2019-03-05 23:25:37'),
(11, 12, 'zvKWTSt06Ns65V39d6UgepkBizHAKgJ1', 1, '2019-03-08 04:21:51', '2019-03-08 04:21:51', '2019-03-08 04:21:51'),
(12, 14, 'OvznFrb10cfbg7Fr3nluOHiSwDbh9ikV', 1, '2019-03-08 04:29:37', '2019-03-08 04:29:37', '2019-03-08 04:29:37'),
(13, 16, 'z6ns2Th24mzoKswlVkpWvS80XxyPHCgV', 1, '2019-03-08 04:37:04', '2019-03-08 04:37:04', '2019-03-08 04:37:04'),
(14, 17, '2XJay2xLPKffu8ojYucRXccE6FB5dTp0', 1, '2019-03-08 04:46:39', '2019-03-08 04:46:38', '2019-03-08 04:46:39'),
(15, 18, 'a34bHmUU3DtALKiaVIOAzW2pjsEIayK2', 1, '2019-03-08 04:48:33', '2019-03-08 04:48:33', '2019-03-08 04:48:33'),
(16, 19, 'kyfSaUyN8rKCeD4fcRWMVWr2wqlPe6If', 1, '2019-03-08 04:49:22', '2019-03-08 04:49:22', '2019-03-08 04:49:22'),
(17, 20, 'eRZCbddZY95ZxCBDsnYBtsre61wTPrag', 1, '2019-03-08 05:05:59', '2019-03-08 05:05:59', '2019-03-08 05:05:59'),
(18, 21, '73S1uXr6SHJ3XUsqXL2ZPXuDq7d9fjjJ', 1, '2019-03-08 05:33:01', '2019-03-08 05:33:01', '2019-03-08 05:33:01'),
(19, 22, 'EdeZwFWHD04l5VvCBiCZyaf4wAcb3Yjr', 1, NULL, '2019-03-10 23:46:40', '2019-03-10 23:46:40'),
(20, 23, 'lftFy2DWDaZLHDR3F7z6iEE0llgiy3v0', 1, '2019-03-16 03:39:36', '2019-03-16 03:39:09', '2019-03-16 03:39:36'),
(21, 24, 'ZAYp9VurmcsHYu0kZtASwFFiOMsUjs91', 1, '2019-03-22 04:54:36', '2019-03-22 04:54:17', '2019-03-22 04:54:36'),
(22, 25, 'VJrxV1g444yS1TYuHQobgyFeh9ovyH8W', 1, '2019-03-22 04:56:22', '2019-03-22 04:56:07', '2019-03-22 04:56:22'),
(23, 26, '9HMKKEaP3YXgw6C76i7v0pSjntyuUWbw', 1, '2019-03-22 05:05:23', '2019-03-22 05:05:03', '2019-03-22 05:05:23'),
(25, 28, 'pVE3Wc3vTTZ6ACRDBR9dJCRa4TAzmbKG', 1, '2019-03-26 23:52:21', '2019-03-26 23:45:09', '2019-03-26 23:52:21'),
(26, 29, 'Fy9nHIErFkjzychFjMy5T3qjHl9LC64l', 1, '2019-03-27 00:07:13', '2019-03-27 00:07:00', '2019-03-27 00:07:13'),
(27, 30, 'Tqu6xWoF4P0GXzR2hJwOYIP9CsjMZTnR', 1, '2019-03-27 00:15:03', '2019-03-27 00:14:33', '2019-03-27 00:15:03'),
(29, 32, 'i3TVbq7cacrcYPgeuzcqiOwnOrqKSJWy', 1, '2019-03-27 01:32:46', '2019-03-27 01:32:29', '2019-03-27 01:32:46'),
(30, 33, '6McfmdoglqQegaMH0cMsydWAe54FgWyS', 1, '2019-03-27 01:35:05', '2019-03-27 01:34:44', '2019-03-27 01:35:05'),
(38, 41, 'DA47Vff3D1fQ2wdxI6NGB5qM0zJtGNjn', 1, '2019-03-27 05:32:38', '2019-03-27 04:23:28', '2019-03-27 05:32:38'),
(39, 42, 'M1aIyBJ97nk5C9vuTog2RjXsJCcxZAQk', 1, '2019-04-01 04:15:11', '2019-04-01 04:14:30', '2019-04-01 04:15:11'),
(40, 43, 'Ty4NvTIgZzsiMdPCvv5H1pVRKHvIDZNG', 1, '2019-04-01 04:22:56', '2019-04-01 04:22:12', '2019-04-01 04:22:56'),
(42, 45, '3WCFKT9h5sZaCKWe1ju4qPfKfF1mAUth', 1, '2019-04-02 01:07:44', '2019-04-02 01:07:25', '2019-04-02 01:07:44'),
(43, 46, 'aMa9z0nMJElNtRCmk1nfkHUr2dkw6bzK', 1, '2019-04-03 00:29:51', '2019-04-03 00:29:51', '2019-04-03 00:29:51'),
(44, 47, 'vOtJpkYf8OYExyolJjDIfduhucEGmeEy', 1, '2019-04-03 00:30:32', '2019-04-03 00:30:32', '2019-04-03 00:30:32'),
(45, 48, 'Lb0ZhctM21ZZhOErHzFnrT5IRwk1M1WU', 1, '2019-04-09 01:13:53', '2019-04-09 01:12:40', '2019-04-09 01:13:53'),
(47, 50, 'GLXpO3VyhdCi9dvWh5GmppBJn65iPA6h', 1, '2019-04-11 23:23:54', '2019-04-11 23:23:54', '2019-04-11 23:23:54'),
(48, 51, 'o8yxdXUY74KhC7NERIuklfkPpw7ELiCy', 0, NULL, '2019-04-12 05:56:28', '2019-04-12 05:56:28'),
(49, 52, 'bXGBVbCYunh0viRCaC7scoaC3Moi0J5C', 1, '2019-04-12 06:01:19', '2019-04-12 06:01:19', '2019-04-12 06:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(255) NOT NULL,
  `module_title` varchar(255) NOT NULL,
  `module_action` enum('ADD','EDIT','REMOVED') NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `module_title`, `module_action`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Site Settings', 'EDIT', 1, '2019-03-26 01:37:38', '2019-03-26 01:37:38', NULL),
(2, 'Site Settings', 'EDIT', 1, '2019-03-26 01:41:53', '2019-03-26 01:41:53', NULL),
(3, 'Site Settings', 'EDIT', 1, '2019-03-26 01:42:39', '2019-03-26 01:42:39', NULL),
(4, 'Site Settings', 'EDIT', 1, '2019-03-26 07:01:21', '2019-03-26 07:01:21', NULL),
(5, 'Site Settings', 'EDIT', 1, '2019-03-26 07:02:34', '2019-03-26 07:02:34', NULL),
(6, 'Site Settings', 'EDIT', 1, '2019-03-26 07:03:31', '2019-03-26 07:03:31', NULL),
(7, 'Email Template', 'EDIT', 1, '2019-03-26 23:00:07', '2019-03-26 23:00:07', NULL),
(8, 'Email Template', 'EDIT', 1, '2019-03-26 23:00:29', '2019-03-26 23:00:29', NULL),
(9, 'Email Template', 'EDIT', 1, '2019-03-26 23:00:39', '2019-03-26 23:00:39', NULL),
(10, 'Email Template', 'EDIT', 1, '2019-03-26 23:00:58', '2019-03-26 23:00:58', NULL),
(11, 'Email Template', 'EDIT', 1, '2019-03-26 23:01:13', '2019-03-26 23:01:13', NULL),
(12, 'Email Template', 'EDIT', 1, '2019-03-27 02:07:15', '2019-03-27 02:07:15', NULL),
(13, 'Email Template', 'EDIT', 1, '2019-03-27 02:12:57', '2019-03-27 02:12:57', NULL),
(14, 'Email Template', 'EDIT', 1, '2019-03-28 00:44:11', '2019-03-28 00:44:11', NULL),
(15, 'Email Template', 'EDIT', 1, '2019-03-28 00:45:44', '2019-03-28 00:45:44', NULL),
(16, 'Email Template', 'EDIT', 1, '2019-03-28 00:45:49', '2019-03-28 00:45:49', NULL),
(17, 'Email Template', 'EDIT', 1, '2019-03-28 00:50:20', '2019-03-28 00:50:20', NULL),
(18, 'Email Template', 'EDIT', 1, '2019-03-28 00:51:47', '2019-03-28 00:51:47', NULL),
(19, 'Email Template', 'EDIT', 1, '2019-03-28 00:53:34', '2019-03-28 00:53:34', NULL),
(20, 'Site Settings', 'EDIT', 1, '2019-03-29 00:53:39', '2019-03-29 00:53:39', NULL),
(21, 'Site Settings', 'EDIT', 1, '2019-03-29 01:08:42', '2019-03-29 01:08:42', NULL),
(22, 'Site Settings', 'EDIT', 1, '2019-03-29 01:12:07', '2019-03-29 01:12:07', NULL),
(23, 'Site Settings', 'EDIT', 1, '2019-03-29 02:04:58', '2019-03-29 02:04:58', NULL),
(24, 'Testimonial', 'EDIT', 1, '2019-03-29 03:52:27', '2019-03-29 03:52:27', NULL),
(25, 'Testimonial', 'EDIT', 1, '2019-03-29 03:55:17', '2019-03-29 03:55:17', NULL),
(26, 'Testimonial', 'EDIT', 1, '2019-03-29 03:59:00', '2019-03-29 03:59:00', NULL),
(27, 'Testimonial', 'EDIT', 1, '2019-03-29 03:59:56', '2019-03-29 03:59:56', NULL),
(28, 'Testimonial', 'EDIT', 1, '2019-03-29 04:12:41', '2019-03-29 04:12:41', NULL),
(29, 'Testimonial', 'EDIT', 1, '2019-03-29 04:14:09', '2019-03-29 04:14:09', NULL),
(30, 'Testimonial', 'EDIT', 1, '2019-03-29 04:16:34', '2019-03-29 04:16:34', NULL),
(31, 'Testimonial', 'EDIT', 1, '2019-03-29 04:16:39', '2019-03-29 04:16:39', NULL),
(32, 'Testimonial', 'EDIT', 1, '2019-03-29 04:19:14', '2019-03-29 04:19:14', NULL),
(33, 'Testimonial', 'EDIT', 1, '2019-03-29 04:19:25', '2019-03-29 04:19:25', NULL),
(34, 'Testimonial', 'EDIT', 1, '2019-03-29 04:20:43', '2019-03-29 04:20:43', NULL),
(35, 'Testimonial', 'EDIT', 1, '2019-03-29 05:09:17', '2019-03-29 05:09:17', NULL),
(36, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:10:04', '2019-03-29 05:10:04', NULL),
(37, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:11:58', '2019-03-29 05:11:58', NULL),
(38, 'Testimonial', 'EDIT', 1, '2019-03-29 05:20:30', '2019-03-29 05:20:30', NULL),
(39, 'Testimonial', 'EDIT', 1, '2019-03-29 05:23:15', '2019-03-29 05:23:15', NULL),
(40, 'Testimonial', 'EDIT', 1, '2019-03-29 05:23:35', '2019-03-29 05:23:35', NULL),
(41, 'Testimonial', 'EDIT', 1, '2019-03-29 05:26:12', '2019-03-29 05:26:12', NULL),
(42, 'Testimonial', 'ADD', 1, '2019-03-29 05:28:00', '2019-03-29 05:28:00', NULL),
(43, 'Testimonial', 'ADD', 1, '2019-03-29 05:28:54', '2019-03-29 05:28:54', NULL),
(44, 'Testimonial', 'ADD', 1, '2019-03-29 05:29:40', '2019-03-29 05:29:40', NULL),
(45, 'Testimonial', 'ADD', 1, '2019-03-29 05:30:31', '2019-03-29 05:30:31', NULL),
(46, 'Testimonial', 'ADD', 1, '2019-03-29 05:31:04', '2019-03-29 05:31:04', NULL),
(47, 'Testimonial', 'ADD', 1, '2019-03-29 05:31:47', '2019-03-29 05:31:47', NULL),
(48, 'Testimonial', 'ADD', 1, '2019-03-29 05:32:00', '2019-03-29 05:32:00', NULL),
(49, 'Testimonial', 'ADD', 1, '2019-03-29 05:32:59', '2019-03-29 05:32:59', NULL),
(50, 'Testimonial', 'ADD', 1, '2019-03-29 05:33:21', '2019-03-29 05:33:21', NULL),
(51, 'Testimonial', 'ADD', 1, '2019-03-29 05:34:26', '2019-03-29 05:34:26', NULL),
(52, 'Testimonial', 'ADD', 1, '2019-03-29 05:35:44', '2019-03-29 05:35:44', NULL),
(53, 'Testimonial', 'ADD', 1, '2019-03-29 05:36:58', '2019-03-29 05:36:58', NULL),
(54, 'Testimonial', 'ADD', 1, '2019-03-29 05:38:14', '2019-03-29 05:38:14', NULL),
(55, 'Testimonial', 'ADD', 1, '2019-03-29 05:38:37', '2019-03-29 05:38:37', NULL),
(56, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:27', '2019-03-29 05:40:27', NULL),
(57, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:27', '2019-03-29 05:40:27', NULL),
(58, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:27', '2019-03-29 05:40:27', NULL),
(59, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:27', '2019-03-29 05:40:27', NULL),
(60, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:27', '2019-03-29 05:40:27', NULL),
(61, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:27', '2019-03-29 05:40:27', NULL),
(62, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:27', '2019-03-29 05:40:27', NULL),
(63, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:27', '2019-03-29 05:40:27', NULL),
(64, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:46', '2019-03-29 05:40:46', NULL),
(65, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:46', '2019-03-29 05:40:46', NULL),
(66, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:46', '2019-03-29 05:40:46', NULL),
(67, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:46', '2019-03-29 05:40:46', NULL),
(68, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:46', '2019-03-29 05:40:46', NULL),
(69, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:46', '2019-03-29 05:40:46', NULL),
(70, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:47', '2019-03-29 05:40:47', NULL),
(71, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:52', '2019-03-29 05:40:52', NULL),
(72, 'Testimonial', 'REMOVED', 1, '2019-03-29 05:40:56', '2019-03-29 05:40:56', NULL),
(73, 'Testimonial', 'ADD', 1, '2019-03-29 05:42:02', '2019-03-29 05:42:02', NULL),
(74, 'Testimonial', 'EDIT', 1, '2019-03-29 05:55:50', '2019-03-29 05:55:50', NULL),
(75, 'Testimonial', 'ADD', 1, '2019-03-29 06:54:31', '2019-03-29 06:54:31', NULL),
(76, 'Testimonial', 'ADD', 1, '2019-03-29 06:55:20', '2019-03-29 06:55:20', NULL),
(77, 'Testimonial', 'EDIT', 1, '2019-03-29 06:56:35', '2019-03-29 06:56:35', NULL),
(78, 'Testimonial', 'EDIT', 1, '2019-03-29 06:56:48', '2019-03-29 06:56:48', NULL),
(79, 'Testimonial', 'EDIT', 1, '2019-03-29 07:38:55', '2019-03-29 07:38:55', NULL),
(80, 'Testimonial', 'EDIT', 1, '2019-03-29 07:39:07', '2019-03-29 07:39:07', NULL),
(81, 'Testimonial', 'EDIT', 1, '2019-03-29 07:39:14', '2019-03-29 07:39:14', NULL),
(82, 'Testimonial', 'EDIT', 1, '2019-03-29 07:39:23', '2019-03-29 07:39:23', NULL),
(83, 'Testimonial', 'EDIT', 1, '2019-03-29 07:39:28', '2019-03-29 07:39:28', NULL),
(84, 'Testimonial', 'EDIT', 1, '2019-03-29 07:39:39', '2019-03-29 07:39:39', NULL),
(85, 'Testimonial', 'EDIT', 1, '2019-03-29 07:39:45', '2019-03-29 07:39:45', NULL),
(86, 'Testimonial', 'EDIT', 1, '2019-03-29 07:39:54', '2019-03-29 07:39:54', NULL),
(87, 'Testimonial', 'EDIT', 1, '2019-03-29 07:40:02', '2019-03-29 07:40:02', NULL),
(88, 'Testimonial', 'EDIT', 1, '2019-03-29 07:40:37', '2019-03-29 07:40:37', NULL),
(89, 'Testimonial', 'EDIT', 1, '2019-03-29 07:40:48', '2019-03-29 07:40:48', NULL),
(90, 'Testimonial', 'EDIT', 1, '2019-03-29 07:40:54', '2019-03-29 07:40:54', NULL),
(91, 'Testimonial', 'EDIT', 1, '2019-03-29 07:42:51', '2019-03-29 07:42:51', NULL),
(92, 'Testimonial', 'EDIT', 1, '2019-03-29 07:42:58', '2019-03-29 07:42:58', NULL),
(93, 'Testimonial', 'EDIT', 1, '2019-03-29 07:43:07', '2019-03-29 07:43:07', NULL),
(94, 'Testimonial', 'EDIT', 1, '2019-03-29 07:43:40', '2019-03-29 07:43:40', NULL),
(95, 'Testimonial', 'EDIT', 1, '2019-03-29 07:44:02', '2019-03-29 07:44:02', NULL),
(96, 'Testimonial', 'EDIT', 1, '2019-03-29 07:44:13', '2019-03-29 07:44:13', NULL),
(97, 'Testimonial', 'EDIT', 1, '2019-03-29 07:44:36', '2019-03-29 07:44:36', NULL),
(98, 'Testimonial', 'EDIT', 1, '2019-03-29 07:45:22', '2019-03-29 07:45:22', NULL),
(99, 'Testimonial', 'EDIT', 1, '2019-03-29 07:58:31', '2019-03-29 07:58:31', NULL),
(100, 'Testimonial', 'EDIT', 1, '2019-03-29 07:58:45', '2019-03-29 07:58:45', NULL),
(101, 'Testimonial', 'EDIT', 1, '2019-03-29 07:58:57', '2019-03-29 07:58:57', NULL),
(102, 'Testimonial', 'EDIT', 1, '2019-03-29 07:59:22', '2019-03-29 07:59:22', NULL),
(103, 'Testimonial', 'EDIT', 1, '2019-03-29 07:59:31', '2019-03-29 07:59:31', NULL),
(104, 'Testimonial', 'EDIT', 1, '2019-03-29 08:02:25', '2019-03-29 08:02:25', NULL),
(105, 'Testimonial', 'EDIT', 1, '2019-03-29 08:03:25', '2019-03-29 08:03:25', NULL),
(106, 'Testimonial', 'EDIT', 1, '2019-03-29 08:22:30', '2019-03-29 08:22:30', NULL),
(107, 'Testimonial', 'EDIT', 1, '2019-03-29 08:24:36', '2019-03-29 08:24:36', NULL),
(108, 'Testimonial', 'EDIT', 1, '2019-03-29 08:25:11', '2019-03-29 08:25:11', NULL),
(109, 'Testimonial', 'EDIT', 1, '2019-03-29 08:26:37', '2019-03-29 08:26:37', NULL),
(110, 'Testimonial', 'EDIT', 1, '2019-03-29 08:26:40', '2019-03-29 08:26:40', NULL),
(111, 'Testimonial', 'EDIT', 1, '2019-03-29 08:27:36', '2019-03-29 08:27:36', NULL),
(112, 'Testimonial', 'EDIT', 1, '2019-03-29 08:28:25', '2019-03-29 08:28:25', NULL),
(113, 'Testimonial', 'EDIT', 1, '2019-03-29 08:28:43', '2019-03-29 08:28:43', NULL),
(114, 'Testimonial', 'EDIT', 1, '2019-03-29 08:29:49', '2019-03-29 08:29:49', NULL),
(115, 'Testimonial', 'EDIT', 1, '2019-03-29 08:30:05', '2019-03-29 08:30:05', NULL),
(116, 'Testimonial', 'EDIT', 1, '2019-03-29 08:30:23', '2019-03-29 08:30:23', NULL),
(117, 'Testimonial', 'EDIT', 1, '2019-03-29 08:31:07', '2019-03-29 08:31:07', NULL),
(118, 'Testimonial', 'EDIT', 1, '2019-03-29 08:31:18', '2019-03-29 08:31:18', NULL),
(119, 'Testimonial', 'EDIT', 1, '2019-03-29 08:31:24', '2019-03-29 08:31:24', NULL),
(120, 'Testimonial', 'EDIT', 1, '2019-03-29 08:31:42', '2019-03-29 08:31:42', NULL),
(121, 'Testimonial', 'EDIT', 1, '2019-03-29 08:32:43', '2019-03-29 08:32:43', NULL),
(122, 'Testimonial', 'EDIT', 1, '2019-03-31 23:05:45', '2019-03-31 23:05:45', NULL),
(123, 'Testimonial', 'EDIT', 1, '2019-03-31 23:06:07', '2019-03-31 23:06:07', NULL),
(124, 'Testimonial', 'EDIT', 1, '2019-03-31 23:06:16', '2019-03-31 23:06:16', NULL),
(125, 'Testimonial', 'EDIT', 1, '2019-03-31 23:06:28', '2019-03-31 23:06:28', NULL),
(126, 'Testimonial', 'EDIT', 1, '2019-03-31 23:06:41', '2019-03-31 23:06:41', NULL),
(127, 'Testimonial', 'EDIT', 1, '2019-03-31 23:42:25', '2019-03-31 23:42:25', NULL),
(128, 'Testimonial', 'EDIT', 1, '2019-03-31 23:49:56', '2019-03-31 23:49:56', NULL),
(129, 'Testimonial', 'EDIT', 1, '2019-03-31 23:49:57', '2019-03-31 23:49:57', NULL),
(130, 'Testimonial', 'EDIT', 1, '2019-03-31 23:50:59', '2019-03-31 23:50:59', NULL),
(131, 'Site Settings', 'EDIT', 1, '2019-04-01 04:09:22', '2019-04-01 04:09:22', NULL),
(132, 'Site Settings', 'EDIT', 1, '2019-04-01 04:10:01', '2019-04-01 04:10:01', NULL),
(133, 'Site Settings', 'EDIT', 1, '2019-04-01 04:13:57', '2019-04-01 04:13:57', NULL),
(134, 'Site Settings', 'EDIT', 1, '2019-04-01 04:17:26', '2019-04-01 04:17:26', NULL),
(135, 'Site Settings', 'EDIT', 1, '2019-04-01 04:17:52', '2019-04-01 04:17:52', NULL),
(136, 'Site Settings', 'EDIT', 1, '2019-04-01 04:18:06', '2019-04-01 04:18:06', NULL),
(137, 'Users', 'REMOVED', 1, '2019-04-01 04:35:06', '2019-04-01 04:35:06', NULL),
(138, 'Email Template', 'EDIT', 1, '2019-04-01 05:51:19', '2019-04-01 05:51:19', NULL),
(139, 'Email Template', 'EDIT', 1, '2019-04-01 05:51:30', '2019-04-01 05:51:30', NULL),
(140, 'Email Template', 'EDIT', 1, '2019-04-01 05:51:39', '2019-04-01 05:51:39', NULL),
(141, 'Email Template', 'EDIT', 1, '2019-04-01 05:54:18', '2019-04-01 05:54:18', NULL),
(142, 'Email Template', 'EDIT', 1, '2019-04-01 05:54:35', '2019-04-01 05:54:35', NULL),
(143, 'Email Template', 'EDIT', 1, '2019-04-01 05:54:41', '2019-04-01 05:54:41', NULL),
(144, 'Site Settings', 'EDIT', 1, '2019-04-01 23:10:56', '2019-04-01 23:10:56', NULL),
(145, 'Site Settings', 'EDIT', 1, '2019-04-01 23:13:21', '2019-04-01 23:13:21', NULL),
(146, 'Site Settings', 'EDIT', 1, '2019-04-01 23:14:59', '2019-04-01 23:14:59', NULL),
(147, 'Site Settings', 'EDIT', 1, '2019-04-01 23:16:56', '2019-04-01 23:16:56', NULL),
(148, 'Site Settings', 'EDIT', 1, '2019-04-01 23:17:22', '2019-04-01 23:17:22', NULL),
(149, 'Site Settings', 'EDIT', 1, '2019-04-01 23:17:34', '2019-04-01 23:17:34', NULL),
(150, 'Site Settings', 'EDIT', 1, '2019-04-01 23:17:40', '2019-04-01 23:17:40', NULL),
(151, 'Site Settings', 'EDIT', 1, '2019-04-01 23:17:53', '2019-04-01 23:17:53', NULL),
(152, 'Site Settings', 'EDIT', 1, '2019-04-01 23:18:00', '2019-04-01 23:18:00', NULL),
(153, 'Site Settings', 'EDIT', 1, '2019-04-01 23:21:06', '2019-04-01 23:21:06', NULL),
(154, 'Site Settings', 'EDIT', 1, '2019-04-01 23:21:57', '2019-04-01 23:21:57', NULL),
(155, 'Site Settings', 'EDIT', 1, '2019-04-01 23:27:07', '2019-04-01 23:27:07', NULL),
(156, 'Site Settings', 'EDIT', 1, '2019-04-01 23:28:10', '2019-04-01 23:28:10', NULL),
(157, 'Site Settings', 'EDIT', 1, '2019-04-01 23:28:45', '2019-04-01 23:28:45', NULL),
(158, 'Site Settings', 'EDIT', 1, '2019-04-01 23:49:12', '2019-04-01 23:49:12', NULL),
(159, 'CMS', 'EDIT', 1, '2019-04-03 00:11:04', '2019-04-03 00:11:04', NULL),
(160, 'Email Template', 'EDIT', 1, '2019-04-03 01:26:17', '2019-04-03 01:26:17', NULL),
(161, 'Email Template', 'EDIT', 1, '2019-04-03 01:26:32', '2019-04-03 01:26:32', NULL),
(162, 'Site Settings', 'EDIT', 1, '2019-04-03 04:03:33', '2019-04-03 04:03:33', NULL),
(163, 'Site Settings', 'EDIT', 1, '2019-04-11 03:37:22', '2019-04-11 03:37:22', NULL),
(164, 'Site Settings', 'EDIT', 1, '2019-04-11 23:35:58', '2019-04-11 23:35:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_name` varchar(256) NOT NULL,
  `account_no` varchar(256) NOT NULL,
  `account_holder_name` varchar(256) NOT NULL,
  `branch` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`id`, `user_id`, `bank_name`, `account_no`, `account_holder_name`, `branch`, `created_at`, `updated_at`) VALUES
(1, 22, 'Dena bank', '12435346535432', 'hello', 'Deola', '2019-04-12 05:41:31', '2019-04-12 05:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `blockchain_transactions`
--

CREATE TABLE `blockchain_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'User id - the user id who will do the payment',
  `trans_hash` text NOT NULL,
  `trade_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL COMMENT '''dispute_settlement'',''trade_initialize'',''trade_completed''',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blockchain_transactions`
--

INSERT INTO `blockchain_transactions` (`id`, `user_id`, `trans_hash`, `trade_id`, `action`, `created_at`, `updated_at`) VALUES
(1, 0, '0x46ffac64b523294dfe181f36d2253d76d3a192d3b892bb48292f6763b0234976', 55, 'trade_initialize', '2019-03-19 07:19:05', '2019-03-19 07:19:05'),
(2, 0, '0x85157d220da544d1ee366f10b74e8c058cac62f4c65b94a9bdae702648021874', 60, 'trade_initialize', '2019-03-19 07:35:07', '2019-03-19 07:35:07'),
(3, 0, '0xc4331c4c1a84e768e88e40f0ab2fe2490e0d84fc2eb2ed81947a30b7e97af065', 66, 'trade_initialize', '2019-03-19 07:58:40', '2019-03-19 07:58:40'),
(4, 0, '0xa37e30beaf9145f2f475c104b1722fb30d7aafbc98d439f1b439df94baa0aa2c', 67, 'trade_initialize', '2019-03-19 08:03:26', '2019-03-19 08:03:26'),
(5, 0, '0xf3a111e2c9f79c60dc64c822cc0d57ef1212b09220fed7112ddca27ed8de2cb1', 73, 'trade_initialize', '2019-03-19 08:11:06', '2019-03-19 08:11:06'),
(6, 0, '0x04d997ae440fd899daf23562a7d60f61c159a3d86604819d1761ddda5b8d75d0', 73, 'trade_completed', '2019-03-19 08:14:02', '2019-03-19 08:14:02'),
(7, 0, '0x18bc6c7da346e119fb1003362971e7adbf5b8eaabc528ae680d4f5cd6321fe07', 74, 'trade_initialize', '2019-03-19 08:34:15', '2019-03-19 08:34:15'),
(8, 0, '0xb723ca688aaf0d1879dc2fe5b3124c4db36dcd98ac12625f3add236eb01b68d0', 74, 'dispute_settlement', '2019-03-19 08:35:54', '2019-03-19 08:35:54'),
(9, 0, '0x048457da4723c04d0102ac0d720ba0acdca589fd2a27684d4471a4e59b5409cf', 79, 'trade_initialize', '2019-03-20 00:25:25', '2019-03-20 00:25:25'),
(10, 1, '0x9f4a3c0839c5103b95238a3eb201daef018ba6992556cd934d85018c55db0593', 79, 'dispute_settlement', '2019-03-20 00:30:30', '2019-03-20 00:30:30'),
(11, 0, '0x5cfb35a663a1cdd922bf6ed802de5b4593236163d6fd91966adfc8bb35511263', 78, 'trade_initialize', '2019-03-20 00:36:30', '2019-03-20 00:36:30'),
(12, 1, '0x301b6e77827df40b65ad125f44f4e4b4d8e6beeb738dfba15e4808a0951215d9', 78, 'dispute_settlement', '2019-03-20 00:39:11', '2019-03-20 00:39:11'),
(13, 0, '0x9d4460f17fc684840d1397c50b1753398695cfd10fe2deb75398d25aabfbdb2d', 99, 'trade_initialize', '2019-03-21 01:14:37', '2019-03-21 01:14:37'),
(14, 0, '0x030d963a5a6d51f436322d1d5b7fb99defe158162316af7247d3299f2321f8b4', 115, 'trade_initialize', '2019-03-21 04:31:03', '2019-03-21 04:31:03'),
(15, 0, '0xae6325d8d9b56b0fc6c3c5213c3d964db81394ca31cde125e7e955a8eaf10491', 115, 'trade_completed', '2019-03-21 05:28:16', '2019-03-21 05:28:16'),
(17, 0, '0xdc8cfda4d1a754f16d0fbe8b9749fb30356e5b9a6e42717dd8df6674ca0d8ad1', 121, 'trade_initialize', '2019-03-21 05:39:06', '2019-03-21 05:39:06'),
(18, 0, '0x1706ac4642072eb589616c11e664dd9c6883681d936befaefdf7a6431556b4b5', 124, 'trade_initialize', '2019-03-21 05:53:17', '2019-03-21 05:53:17'),
(19, 0, '0x8db4e17f298efeb66af1628b2ba95fffa846c90fe56aa68371e8be84c2690b40', 120, 'trade_initialize', '2019-03-21 06:28:28', '2019-03-21 06:28:28'),
(20, 0, '0x7656ef09ba829670ce80ac5fe756519e98711da993311565cd76822df4ce1412', 126, 'trade_initialize', '2019-03-21 06:38:49', '2019-03-21 06:38:49'),
(21, 1, '0x1933f2e58150c7aabc313d9783d5bb20a63df72f7ae7daac7eb71ced8d9f2bd2', 126, 'dispute_settlement', '2019-03-21 07:44:27', '2019-03-21 07:44:27'),
(22, 4, '0xd79a123b207cdaec8788ed0e8c46125b61f251c9fab4487334d7c6ec0cdc77ed', 136, 'trade_initialize', '2019-03-22 01:24:28', '2019-03-22 01:24:28'),
(23, 4, '0x1726b2eb783fd2c6308b98cb4cf1adc094e96a5259708ab28c5c44801ef8307f', 136, 'trade_completed', '2019-03-22 01:27:25', '2019-03-22 01:27:25'),
(24, 0, '0xb1d7659824d3e1857c21756bac748ef55b07fa2f8b828627f1997e29b9215185', 138, 'trade_initialize', '2019-03-22 05:01:14', '2019-03-22 05:01:14'),
(25, 0, '0x1d6dd5be1f8230b055ca68220e3759dbbdd8e4cdf7ea32f51bd256e0420a1164', 140, 'trade_initialize', '2019-03-22 05:06:29', '2019-03-22 05:06:29'),
(26, 0, '0x2464425ae3106a3f28863ef8559ba5b161f292ee1459f83406630472af6dd45c', 141, 'trade_initialize', '2019-03-22 05:07:09', '2019-03-22 05:07:09'),
(27, 4, '0x7b618ee57c53fc294ef7346cc2bcb85c85608e38679b1a83cc12c731e14d3da2', 143, 'trade_initialize', '2019-03-23 01:56:22', '2019-03-23 01:56:22'),
(28, 4, '0x4964d885ca741d298f70edc67ad58ef90ada595c1ad6174216b90c74e176f9c3', 145, 'trade_initialize', '2019-03-23 05:04:04', '2019-03-23 05:04:04'),
(29, 28, '0x631fcaabe334fdd07eafd1874606f104ccbb1f5585a25f89c7a6bdbb602ddba0', 160, 'trade_initialize', '2019-03-27 08:14:14', '2019-03-27 08:14:14'),
(30, 28, '0xe335fc35f63dbeec50d427970e11bef8509da22a7fcccbb006db4ec9744911a3', 161, 'trade_initialize', '2019-03-27 08:33:31', '2019-03-27 08:33:31'),
(31, 4, '0x2ca6f85cbc1ed39fc21036c907317ff449240794838452ddaa069c1ae891281a', 158, 'trade_initialize', '2019-03-27 22:23:20', '2019-03-27 22:23:20'),
(32, 1, '0xc0f6b14ed6474c481fdeec92625eb20f747ef6171f50aaa4339e8b1fad1536ec', 158, 'dispute_settlement', '2019-03-27 22:55:42', '2019-03-27 22:55:42'),
(33, 1, '0xddf1c65f6ab0094a89ed33d746912ecce47d341bd63ab45562a1d5fda7e96d79', 161, 'dispute_settlement', '2019-03-27 23:02:32', '2019-03-27 23:02:32'),
(34, 28, '0x1cb68858086af16f9b63d24d6bad2e813f4f469a8ea0a6d303e40b66a67a84b9', 160, 'trade_completed', '2019-03-27 23:51:26', '2019-03-27 23:51:26'),
(35, 4, '0x0e74533dd00723b83dbb5254e72bb2c60d661d9e89a851967b48473ba8c5f142', 165, 'trade_initialize', '2019-03-28 00:03:13', '2019-03-28 00:03:13'),
(36, 4, '0xade1abcb3ec706edf3f9968c571df8bc9596153cf5c13b99c6826728bca1aab6', 165, 'trade_initialize', '2019-03-28 00:04:53', '2019-03-28 00:04:53'),
(37, 4, '0x46797dc15407c65c380454570c7a43fd47973ce899d24cec18d054f130b6305b', 165, 'trade_initialize', '2019-03-28 00:05:26', '2019-03-28 00:05:26'),
(38, 4, '0xaf02f2dcc3941a1040098e79330d1567dbfec17d24a788a74cf296d52da293be', 165, 'trade_initialize', '2019-03-28 00:06:44', '2019-03-28 00:06:44'),
(39, 4, '0x37f95a3170d2b4ca3121f61f4020c719476f1a37321466965b992add96cca245', 165, 'trade_initialize', '2019-03-28 00:06:57', '2019-03-28 00:06:57'),
(40, 4, '0x8c78b8a58b5d56b7d556d75860810d03871c76c837500eeb9a31c707ebad5dfa', 165, 'trade_completed', '2019-03-28 00:11:25', '2019-03-28 00:11:25'),
(41, 4, '0x085e2e45ae5c7511d4bd78f329333207acf2599c0cb20e38e8eb387cd7dfaf38', 169, 'trade_initialize', '2019-03-28 00:33:47', '2019-03-28 00:33:47'),
(42, 4, '0x3c1b17d01c977e9961a1df8ed224223a887ffb363aabedcdd63dc8071d03c26b', 169, 'trade_completed', '2019-03-28 00:36:37', '2019-03-28 00:36:37'),
(43, 4, '0xa62440a611af72d5e9a130e9b6ae7c811dad646339bb8093ab0a5fa63de02245', 187, 'trade_initialize', '2019-03-28 05:37:49', '2019-03-28 05:37:49'),
(44, 4, '0x4eec0a0ddb8d9218c984092fc1d554b1febc4d30613c6e778bf198afcd2fa065', 187, 'trade_completed', '2019-03-28 05:43:42', '2019-03-28 05:43:42'),
(45, 4, '0xc9453de158061f6107c39326b4e0827a7e4f32bf330bd567ace7a35f6476ab1c', 186, 'trade_initialize', '2019-03-28 07:03:25', '2019-03-28 07:03:25'),
(46, 4, '0x2cc7c857414c04c0d17da2f9d8163777f193281ddd72cb9075247abec46448e7', 186, 'trade_completed', '2019-03-28 07:05:25', '2019-03-28 07:05:25'),
(47, 4, '0x9e66fc32894055f932532565ac82c81a5966fb4800f8069bd4c0006053b519a3', 189, 'trade_initialize', '2019-03-28 07:44:00', '2019-03-28 07:44:00'),
(48, 4, '0x15141e2375425d65f055360d7a2c14816faed9a479fcc1eee66aa12500701f6e', 191, 'trade_initialize', '2019-03-28 08:08:12', '2019-03-28 08:08:12'),
(49, 4, '0x7d5058cda954f06378da52c269e7a947d9e6b68d6e86a8b9459c24dfc21fe976', 195, 'trade_initialize', '2019-04-01 00:36:06', '2019-04-01 00:36:06'),
(50, 4, '0x9208f04c39dc6f57f0e675afedd180332f7f1144e7ee184e4dfd067f7a1dc0c3', 195, 'trade_completed', '2019-04-01 00:38:28', '2019-04-01 00:38:28'),
(51, 4, '0xd3f0e14173381d2d9770676beac41c8f896caae67f3e420f9425d9acf778b512', 197, 'trade_initialize', '2019-04-01 00:48:12', '2019-04-01 00:48:12'),
(52, 4, '0x0f5bef4b93daac5d29a8dc04e0b0f3cc26f3a37371d160f101c2f8ab6211c5ca', 197, 'trade_completed', '2019-04-01 00:53:08', '2019-04-01 00:53:08'),
(53, 43, '0xe16c09beff056ff623cf39c0e93683da9be99fb578a7adaba6cd48c2ce7a9f57', 199, 'trade_initialize', '2019-04-01 04:40:19', '2019-04-01 04:40:19'),
(54, 1, '0xc8c5cf2edaf2275de2c290db7f5e1b7b939b04db035b514e803dd699c17e5a9f', 199, 'dispute_settlement', '2019-04-01 04:52:51', '2019-04-01 04:52:51'),
(55, 43, '0x16f73f8dfbbd20aa76899d9a1525f080d098f8c743d5916cb087757bc59aeb63', 201, 'trade_initialize', '2019-04-01 05:01:08', '2019-04-01 05:01:08'),
(56, 1, '0xb715911f426afe9e11a4d7c40c38bfc7d678ff77538de1e60e414c9addcc317b', 201, 'dispute_settlement', '2019-04-01 05:04:05', '2019-04-01 05:04:05'),
(57, 43, '0x1628e8073159f0fa164668bc386d18311593f4de5e4645c342bd873a0ec19fce', 203, 'trade_initialize', '2019-04-01 05:07:04', '2019-04-01 05:07:04'),
(58, 43, '0xd8cfc729be3704ae9e8623be916ca486efc70ed4b071953e80ecf2bd5358e689', 203, 'trade_completed', '2019-04-01 05:07:35', '2019-04-01 05:07:35'),
(59, 43, '0x63d20d05c2e72c286abaf47a7b4bacb5eb5fa70c367d95434640771b13cb1542', 205, 'trade_initialize', '2019-04-01 05:47:41', '2019-04-01 05:47:41'),
(60, 43, '0xaf1f556e7ef674f8f87d7cdf0101cf673f47192401311e1851a680f68698e833', 205, 'trade_completed', '2019-04-01 05:50:20', '2019-04-01 05:50:20'),
(61, 43, '0x8e8a74af91dae445f8a4d1b2fd2eeb52f9aa5a676927c2b6aed2056fc7abd9c8', 207, 'trade_initialize', '2019-04-01 06:41:01', '2019-04-01 06:41:01'),
(62, 4, '0x8e89c595799552ce43c031b01377a2844f78c0eb0a4347eca18bdf7eb7d06e55', 208, 'trade_initialize', '2019-04-01 06:43:40', '2019-04-01 06:43:40'),
(63, 25, '0xf8c69e86ea3bd20840d726d3ba069507c7cf3142f6b2499771f0c2e27e28b5a4', 209, 'trade_initialize', '2019-04-01 06:45:31', '2019-04-01 06:45:31'),
(64, 25, '0x15aa16182820a775fc7a03d96cac9789d4cc2710dc71ffe9e51837e7b6044127', 209, 'trade_completed', '2019-04-01 06:45:54', '2019-04-01 06:45:54'),
(65, 43, '0x9f88c21887f035409d63a78b027370eb65f98f3a7719d150879b9d1d46c83eb7', 212, 'trade_initialize', '2019-04-01 07:28:00', '2019-04-01 07:28:00'),
(66, 4, '0x9346a19ac4741f8c3b7698cd92dd17a5484aff5927e4748147282a831febbd20', 213, 'trade_initialize', '2019-04-01 07:41:38', '2019-04-01 07:41:38'),
(67, 43, '0x6628c7814f5a5da10714ab917c80e4b22da7d442edd9c16a64a7ad00b9c52b9a', 2, 'trade_initialize', '2019-04-02 00:27:06', '2019-04-02 00:27:06'),
(68, 4, '0xa69839175b096ae456365abf740bd5c7d656fba80cf0e5f27a0a54b545b379ae', 3, 'trade_initialize', '2019-04-02 00:42:41', '2019-04-02 00:42:41'),
(69, 4, '0x3ed09dd0bfd6a469af0e16adbe69769f37099419cac5fffe9d6cdd3f59a3ba06', 5, 'trade_initialize', '2019-04-02 01:53:01', '2019-04-02 01:53:01'),
(70, 4, '0x5b795fb4cbecc0dc6db9a9739cab4866593203c3c8667706ead11c53e855bfe1', 5, 'trade_completed', '2019-04-02 01:54:22', '2019-04-02 01:54:22'),
(71, 2, '0xffb7e1ce20bf2e79bc7f245679cf6706162e978f6f8c16f631b83226119fa242', 6, 'trade_initialize', '2019-04-02 03:29:55', '2019-04-02 03:29:55'),
(72, 2, '0xdfd38c00ee8a2f8e36dae44d112f6f1510ec56b4169ceb2bbd2c9bc3edd83325', 6, 'trade_completed', '2019-04-02 03:35:53', '2019-04-02 03:35:53'),
(73, 4, '0xa08e09f1825e3a482932078e38b3c2ee01a0a8b87796c431f017c20ef999bce5', 11, 'trade_initialize', '2019-04-02 07:25:47', '2019-04-02 07:25:47'),
(74, 4, '0xad61eeadd7677f2655c8e60157f111897a680f55bd775e09e1e721519057c41f', 11, 'trade_initialize', '2019-04-02 07:26:12', '2019-04-02 07:26:12'),
(75, 4, '0xfbffd5e4ca55f062aa62fd0c8f334340ee0dabcb6c75dd9f39c54e2cdc7fbaf4', 11, 'trade_completed', '2019-04-02 07:27:04', '2019-04-02 07:27:04'),
(76, 4, '0x1a4722fe06eb5cb0b5acb541945c056813a6070a734a46043e7ea1269346f231', 11, 'trade_completed', '2019-04-02 07:27:27', '2019-04-02 07:27:27'),
(77, 4, '0xb1e5b0fe71706ed8d911531344f476805da47ecaddb0d5056cb1339b26624877', 12, 'trade_initialize', '2019-04-02 23:25:54', '2019-04-02 23:25:54'),
(78, 4, '0xc7d7a8697d26b6129dc2db603bcb6f024b32c26b37f741794b509f8d1f492039', 12, 'trade_completed', '2019-04-02 23:27:45', '2019-04-02 23:27:45'),
(79, 43, '0xb5dc3567479d27f06ec22e56771904be46fa379f685b56e5d36173723b806cae', 13, 'trade_initialize', '2019-04-02 23:44:15', '2019-04-02 23:44:15'),
(80, 43, '0x29492bdd647872a23370a7e24ac9b029a628a4f7ad826314b5cc110bf091790c', 13, 'trade_completed', '2019-04-02 23:49:24', '2019-04-02 23:49:24'),
(81, 4, '0xdbcc6d1820d61f6fc1cfc69829831f8844fe1beecd70d9fc3b810d473311cdf1', 25, 'trade_initialize', '2019-04-04 00:04:22', '2019-04-04 00:04:22'),
(82, 4, '0x4c4fa1cd21e3c40b0c3acd1aedfc2ec4c7155bf26521daaaf74a9504d331e6ff', 28, 'trade_initialize', '2019-04-04 00:10:32', '2019-04-04 00:10:32'),
(83, 43, '0xd8ff31c76bb8818a75369a0af462e335a2a8c90130e2fa46a12ae78bfbaeb4e2', 29, 'trade_initialize', '2019-04-04 00:12:29', '2019-04-04 00:12:29'),
(84, 43, '0x769d6dc0b67f0601dff0e254e90a43ec8ef1a58ede2a1c77952d539a8862d167', 31, 'trade_initialize', '2019-04-04 00:51:32', '2019-04-04 00:51:32'),
(85, 4, '0xd1a254e405f92b10ccf0cd3a23b726a205a68d625e871b847bdd5b8d771e93ac', 32, 'trade_initialize', '2019-04-04 01:14:13', '2019-04-04 01:14:13'),
(86, 4, '0xc2450a703e9e228850eaffba428adf00567895b7c9094edd2c4e745dea57558a', 34, 'trade_initialize', '2019-04-04 01:21:02', '2019-04-04 01:21:02'),
(87, 43, '0x1252e549374aa5fcca095f5164857acd1998a5822706b7ea0f3ee10089976811', 35, 'trade_initialize', '2019-04-04 01:24:13', '2019-04-04 01:24:13'),
(88, 28, '0xce152d23929204e2eb41e137820eac05e14ae3cc6e379dbb1f74bc6870de841d', 37, 'trade_initialize', '2019-04-04 01:37:00', '2019-04-04 01:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `crypto_symbol` varchar(255) NOT NULL,
  `crypto_wallet_address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`id`, `user_id`, `crypto_symbol`, `crypto_wallet_address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'USDC', '0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c', '2019-02-25 01:06:51', '2019-03-15 05:36:02', NULL),
(2, 3, 'USDC', '12sdfsdgfergvbgdfger5', '2019-02-25 01:46:10', '2019-02-25 01:46:10', NULL),
(3, 4, 'USDC', '0x0f276c3a192Ec0562c1d370a3830e6b03565efC9', '2019-02-25 03:46:04', '2019-04-04 01:20:34', NULL),
(4, 5, 'USDC', 'sdffvgdsagvds', '2019-02-25 03:47:58', '2019-02-25 03:47:58', NULL),
(5, 8, 'USDC', 'test', '2019-03-07 01:42:03', '2019-03-07 01:42:03', NULL),
(6, 17, 'USDC', 'asas@saas.com', '2019-03-08 04:46:39', '2019-03-08 04:46:39', NULL),
(7, 21, 'USDC', 'teeee@ff.sd', '2019-03-08 05:33:01', '2019-03-08 05:34:20', NULL),
(8, 25, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-22 04:56:07', '2019-03-22 04:56:07', NULL),
(9, 26, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-22 05:05:02', '2019-03-22 05:05:02', NULL),
(10, 28, 'USDC', '0x0f276c3a192Ec0562c1d370a3830e6b03565efC9', '2019-03-26 23:45:09', '2019-04-04 01:36:43', NULL),
(11, 33, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 01:34:44', '2019-03-27 01:34:44', NULL),
(12, 43, 'USDC', '0x0f276c3a192Ec0562c1d370a3830e6b03565efC9', '2019-04-01 04:22:12', '2019-04-04 00:12:12', NULL),
(13, 46, 'USDC', 'Nashik, Maharashtra, India', '2019-04-03 00:29:51', '2019-04-03 00:29:51', NULL),
(14, 47, 'USDC', 'Nashik, Maharashtra, India', '2019-04-03 00:30:32', '2019-04-03 00:30:32', NULL),
(15, 48, 'USDC', '0xf08d90facd6728fed7e76f59bbd0d8c5179251c0', '2019-04-09 01:12:40', '2019-04-09 01:12:40', NULL),
(16, 49, 'USDC', '0xf08d90facd6728fed7e76f59bbd0d8c5179251c0', '2019-04-09 01:20:31', '2019-04-09 01:20:31', NULL),
(17, 50, 'USDC', 'qwqwedwq', '2019-04-11 23:23:54', '2019-04-11 23:23:54', NULL),
(18, 51, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-04-12 05:56:28', '2019-04-12 05:56:28', NULL),
(19, 52, '', '', '2019-04-12 06:01:19', '2019-04-12 06:05:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `public_key` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'active :1 , disable/not-active:0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `public_key`, `country_id`, `state_id`, `is_active`, `created_at`, `updated_at`) VALUES
(48, NULL, 358, '5', 1, '2018-05-25 01:23:07', '2018-05-25 01:23:07'),
(49, '1HWngfA', 358, '5', 1, '2018-05-25 01:29:35', '2018-05-28 00:48:12'),
(50, NULL, 358, '5', 1, '2018-05-25 01:59:45', '2018-05-25 01:59:45'),
(51, NULL, 358, '5', 1, '2018-05-27 23:52:11', '2018-05-27 23:52:11'),
(52, 'IWPdEtu', 259, '11', 1, '2018-05-28 00:04:03', '2018-05-28 00:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `city_translation`
--

CREATE TABLE `city_translation` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `city_title` varchar(500) CHARACTER SET utf8 NOT NULL,
  `city_slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city_translation`
--

INSERT INTO `city_translation` (`id`, `city_id`, `city_title`, `city_slug`, `locale`, `created_at`, `updated_at`) VALUES
(2, 2, 'Badlapur', 'badlapur', 'en', '2017-01-23 04:02:45', '2017-01-23 04:02:45'),
(3, 3, 'Nashik', 'nashik', 'en', '2017-01-23 04:03:28', '2017-01-23 04:03:28'),
(5, 5, 'gandinagar', 'gandinagar', 'en', '2018-04-30 12:27:27', '2018-04-30 06:57:27'),
(6, 5, 'गांधीनगर', '', 'hi', '2018-04-30 06:59:44', '2018-04-30 06:59:44'),
(7, 44, 'gj', 'gj', 'en', '2018-05-25 00:48:21', '2018-05-25 00:48:21'),
(8, 45, 'GJ', 'gj', 'en', '2018-05-25 00:49:08', '2018-05-25 00:49:08'),
(9, 47, 'sdfs', 'sdfs', 'en', '2018-05-25 01:12:19', '2018-05-25 01:12:19'),
(10, 48, 'surat nagari', 'surat-nagari', 'en', '2018-05-25 07:27:19', '2018-05-25 01:57:19'),
(11, 49, 'Ahmedabad', 'ahmedabad', 'en', '2018-05-28 06:18:12', '2018-05-28 00:48:12'),
(12, 50, 'navapur', 'navapur', 'en', '2018-05-25 01:59:45', '2018-05-25 01:59:45'),
(13, 51, 'Ahemdabad', 'ahemdabad', 'en', '2018-05-27 23:52:11', '2018-05-27 23:52:11'),
(14, 52, 'algeria', 'algeria', 'en', '2018-05-28 05:35:20', '2018-05-28 00:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `contact_enquiry`
--

CREATE TABLE `contact_enquiry` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `comments` text CHARACTER SET utf8 NOT NULL,
  `is_view` enum('1','0') CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_enquiry`
--

INSERT INTO `contact_enquiry` (`id`, `user_name`, `email`, `phone`, `subject`, `comments`, `is_view`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bhavana Shirude', 'abc@gmail.com', '7744885511', '', 'hi i m here', '1', '2019-03-08 04:23:10', '2019-04-03 00:15:42', NULL),
(2, 'sagar B. jadhav', 'assd#z@df.gf', '9090909090', '', 'sda', '0', '2019-03-11 23:38:47', '2019-03-11 23:38:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cron_logs`
--

CREATE TABLE `cron_logs` (
  `id` int(11) NOT NULL,
  `cron_signature` varchar(255) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cron_logs`
--

INSERT INTO `cron_logs` (`id`, `cron_signature`, `start_datetime`, `end_datetime`, `created_at`, `updated_at`) VALUES
(1, 'save:total-buy-trades', '2019-03-28 12:51:29', '2019-03-28 12:51:29', '2019-03-28 07:21:29', '2019-03-28 07:21:29'),
(2, 'save:total-buy-trades', '2019-04-03 11:31:34', '2019-04-03 11:31:34', '2019-04-03 06:01:34', '2019-04-03 06:01:34'),
(3, 'save:total-buy-trades', '2019-04-12 05:09:06', '2019-04-12 05:09:06', '2019-04-11 23:39:06', '2019-04-11 23:39:06');

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE `email_template` (
  `id` int(11) NOT NULL,
  `template_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_subject` text COLLATE utf8_unicode_ci NOT NULL,
  `template_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_from_mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_html` text COLLATE utf8_unicode_ci NOT NULL,
  `template_variables` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NA' COMMENT '~ Separated',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email_template`
--

INSERT INTO `email_template` (`id`, `template_name`, `template_subject`, `template_from`, `template_from_mail`, `template_html`, `template_variables`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'Contact Enquiry', 'New Contact Enquiry at Afroin.', 'Afroin - Admin', 'jaydip.imperialsoftech@gmail.com', '<p>Hello ##SITE_URL## Admin<br />&nbsp; &nbsp;<br />You have new contact enquiry&nbsp;from <strong>##USER_NAME## </strong>following are details.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Enquiry Details:</strong></p>\r\n<table style=\"height: 82px; width: 724px;\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 153px;\"><strong>Email Id</strong></td>\r\n<td style=\"width: 555px;\">##USER_EMAIL##</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 153px;\"><strong>Phone No.</strong></td>\r\n<td style=\"width: 555px;\">##PHONE##</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 153px;\"><strong>Enquiry Message</strong></td>\r\n<td style=\"width: 555px;\">##ENQUIRY##</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p><br /><br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp; <br /><br />Thanks and Regards,<br />##SITE_URL##</p>', '##USER_NAME##~##SUBJECT##~##USER_EMAIL##~##SITE_URL##~##PHONE##~##ENQUIRY##', NULL, '2016-05-05 22:11:18', '2019-04-01 05:54:41'),
(6, 'Account Activation', 'VERIFY YOUR ACCOUNT', 'Afroin - Admin', 'admin@Afroin.com', '<h2>Verify Your Email Address</h2>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;Hello<strong> ##USER_FNAME##, </strong></p>\r\n<div style=\"text-align: left;\"><br />Thank you&nbsp;&nbsp;for creating an account with&nbsp;&nbsp;##APP_NAME##.</div>\r\n<div style=\"text-align: left;\">&nbsp;</div>\r\n<div style=\"text-align: left;\">You are successfully register with us and now you have to complete our authentication process. You have to verify your account by clicking following activation button.</div>\r\n<div style=\"text-align: left;\">&nbsp;</div>\r\n<div style=\"text-align: left;\">&nbsp;</div>\r\n<div style=\"text-align: center;\">&nbsp;</div>\r\n<div style=\"text-align: center;\">&nbsp;</div>\r\n<div style=\"text-align: center;\"><strong>Please click on below button to verify your account.</strong></div>\r\n<div style=\"text-align: center;\">&nbsp;</div>\r\n<div style=\"text-align: center;\">&nbsp;</div>\r\n<div style=\"text-align: center;\">##ACTIVATION_URL## .<br /><br /></div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>&nbsp;</div>\r\n<div>Thanks and Regards,<br />&nbsp;##APP_NAME##</div>', '##USER_FNAME##~##APP_NAME##~##ACTIVATION_URL##', NULL, '2016-05-15 23:12:14', '2019-04-01 05:51:39'),
(7, 'Forgot Password', 'FORGOT PASSWORD', 'Afroin - Admin', 'contact@Afroin.com', '<p>Hello <strong>##FIRST_NAME##</strong> ,</p>\r\n<p>You forget your password, don\'t worry. Our system help you to reset your password easily.</p>\r\n<p>Following &nbsp;are the details of your account. You can now set your new password by just click on following button.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Account Details:</strong></p>\r\n<table style=\"height: 36px; width: 604px;\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 103px;\"><strong>Username</strong></td>\r\n<td style=\"width: 485px;\">##EMAIL##</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: center;\"><strong>Reset Your Password Just Click On Following Button</strong></p>\r\n<p style=\"text-align: center;\">&nbsp;</p>\r\n<p style=\"text-align: center;\">##REMINDER_URL##</p>\r\n<p style=\"text-align: left;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n<p style=\"text-align: left;\"><br /><br />Thanks and Regards, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; <br />##SITE_URL## &nbsp;&nbsp;</p>', '##FIRST_NAME##~##EMAIL##~##REMINDER_URL##~##SITE_URL##', NULL, '2016-05-16 01:43:47', '2019-03-26 23:00:58'),
(8, 'Social Auth Registration', 'Your Account Details for Quedemonos', 'Afroin - Admin', 'admin@Afroin.com', '<p>Hello&nbsp; ##USER_NAME##,<br /><br />Thanks you for registering at <strong>##SITE_LINK##</strong>. You may now log in to your account using following credentials</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Acount Details:</strong></p>\r\n<table style=\"height: 48px; width: 682px;\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 184px;\">User Name/ Email Id</td>\r\n<td style=\"width: 482px;\">##USER_EMAIL##</td>\r\n</tr>\r\n<tr>\r\n<td style=\"width: 184px;\">Password</td>\r\n<td style=\"width: 482px;\">##USER_PWD##</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p><br /><br /><strong>Note</strong>: Please Change your password after first login</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><br /><br />Thanks and Regards,<br />##SITE_LINK##</p>', '##USER_EMAIL##~##USER_NAME##~##SITE_LINK##~##USER_PWD##', NULL, '2016-05-18 02:41:57', '2019-03-26 23:01:13'),
(31, 'Email Notification', '##SUBJECT##', 'Afroin - Checker', 'admin@Afroin.com', '<p>Hello  ##USER_NAME##,<br /><br />##MESSAGE##</p>\r\n<div style=\"text-align: center;\"><strong>Please click on below button to view details.</strong></div>\r\n<div style=\"text-align: center;\"> </div>\r\n<div style=\"text-align: center;\"> </div>\r\n<div style=\"text-align: center;\"><a style=\"background: #fa8612; color: #fff; text-align: center; border-radius: 4px; padding: 15px 18px; text-decoration: none;\" href=\"##URL##\" target=\"_blank\" rel=\"noopener\">View Details</a></div>\r\n<p><br />Thanks and Regards,<br />##APP_NAME##</p>', '##USER_EMAIL##~##USER_NAME##~##SITE_LINK##~##MESSAGE##~##URL##~##SUBJECT##', NULL, '2016-05-18 02:41:57', '2019-04-03 01:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `is_active` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Soft Delete AND Active/Block Maintained';

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, '1', '2016-10-14 05:43:44', '2018-04-27 07:45:19', NULL),
(7, '1', '2016-10-14 05:46:17', '2018-06-11 00:58:51', NULL),
(8, '1', '2016-10-14 05:47:11', '2018-06-11 00:58:51', NULL),
(9, '1', '2016-10-14 05:47:50', '2018-06-11 00:58:51', NULL),
(10, '1', '2016-10-14 05:48:46', '2018-06-11 00:58:51', NULL),
(11, '1', '2016-10-14 05:49:24', '2018-06-11 00:58:51', NULL),
(12, '0', '2016-10-14 05:50:10', '2018-07-21 01:22:23', NULL),
(13, '1', '2016-10-14 05:50:53', '2018-07-21 01:22:14', NULL),
(14, '1', '2016-10-14 05:51:31', '2018-06-11 00:58:51', NULL),
(15, '1', '2016-10-14 05:52:15', '2018-06-11 00:58:51', NULL),
(16, '1', '2016-10-14 05:53:00', '2018-07-21 01:21:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faq_translation`
--

CREATE TABLE `faq_translation` (
  `id` int(11) NOT NULL,
  `faq_id` int(11) NOT NULL,
  `question` varchar(500) CHARACTER SET utf8 NOT NULL,
  `answer` mediumtext CHARACTER SET utf8 NOT NULL,
  `locale` varchar(10) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='No Soft Delete OR Active/Block Maintained';

--
-- Dumping data for table `faq_translation`
--

INSERT INTO `faq_translation` (`id`, `faq_id`, `question`, `answer`, `locale`, `created_at`, `updated_at`) VALUES
(7, 6, 'Is account registration required?', '<p>Account registration at <strong>PrepBootstrap</strong> is only required if you will be selling or buying themes. This ensures a valid communication channel for all parties involved in any transactions.</p>', 'en', '2016-10-14 05:43:44', '2016-10-14 05:43:44'),
(8, 7, 'Can I submit my own Bootstrap templates or themes?', '<p>A lot of the content of the site has been submitted by the community. Whether it is a commercial element/template/theme <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; or a free one, you are encouraged to contribute. All credits are published along with the resources.</p>', 'en', '2016-10-14 05:46:17', '2016-10-14 05:46:17'),
(9, 8, 'What is the currency used for all transactions?', '<p>All prices for themes, templates and other items, including each seller\'s or buyer\'s account balance are in <strong>USD</strong></p>', 'en', '2016-10-14 05:47:11', '2016-10-14 05:47:11'),
(10, 9, 'Who cen sell items?', '<p>Any registed user, who presents a work, which is genuine and appealing, can post it on <strong>PrepBootstrap</strong>.</p>', 'en', '2016-10-14 05:47:50', '2016-10-14 05:47:50'),
(11, 10, 'I want to sell my items - what are the steps?', '<p>The steps involved in this process are really simple. All you need to do is:</p>\r\n<ul>\r\n<li>Register an account</li>\r\n<li>Activate your account</li>\r\n<li>Go to the <strong>Themes</strong> section and upload your theme</li>\r\n<li>The next step is the approval step, which usually takes about 72 hours.</li>\r\n</ul>', 'en', '2016-10-14 05:48:46', '2016-10-14 05:48:46'),
(12, 11, 'How much do I get from each sale?', '<p>Here, at <strong>PrepBootstrap</strong>, we offer a great, 70% rate for each seller, regardless of any restrictions, such as volume, date of entry, etc. </p>', 'en', '2016-10-14 05:49:24', '2016-10-14 05:49:24'),
(13, 12, 'Why sell my items here?', '<p>There are a number of reasons why you should join us:</p>\r\n<ul>\r\n<li>A great 70% flat rate for your items.</li>\r\n<li>Fast response/approval times. Many sites take weeks to process a theme or template. And if it gets rejected, there is another iteration. We have aliminated this, and made the process very fast. It only takes up to 72 hours for a template/theme to get reviewed.</li>\r\n<li>We are not an exclusive marketplace. This means that you can sell your items on <strong>PrepBootstrap</strong>, as well as on any other marketplate, and thus increase your earning potential.</li>\r\n</ul>', 'en', '2016-10-14 05:50:10', '2016-10-14 05:50:10'),
(14, 13, 'What are the payment options?', '<p>The best way to transfer funds is via Paypal. This secure platform ensures timely payments and a secure environment.</p>', 'en', '2016-10-14 05:50:53', '2016-10-14 05:50:53'),
(15, 14, 'When do I get paid?', '<p>Our standard payment plan provides for monthly payments. At the end of each month, all accumulated funds are transfered to your account. The minimum amount of your balance should be at least 70 USD.</p>', 'en', '2016-10-14 05:51:31', '2016-10-14 05:51:31'),
(16, 15, 'I want to buy a theme - what are the steps?', '<p>Buying a theme on <strong>PrepBootstrap</strong> is really simple. Each theme has a live preview. Once you have selected a theme or template, which is to your liking, you can quickly and securely pay via Paypal. <br /> Once the transaction is complete, you gain full access to the purchased product.</p>', 'en', '2016-10-14 05:52:15', '2016-10-14 05:52:15'),
(17, 16, 'Is this the latest version of an item', '<p>Each item in <strong>PrepBootstrap</strong> is maintained to its latest version. This ensures its smooth operation.</p>', 'en', '2016-10-14 05:53:00', '2016-10-14 05:53:00'),
(18, 17, 'what is imperial?', '<h2>Where does it come from?</h2>\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>', 'en', '2016-11-03 22:43:26', '2018-04-30 00:39:21');

-- --------------------------------------------------------

--
-- Table structure for table `first_level_category`
--

CREATE TABLE `first_level_category` (
  `id` int(11) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `is_crypto_category` int(11) NOT NULL COMMENT '1= yes/0=no',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `first_level_category`
--

INSERT INTO `first_level_category` (`id`, `product_type`, `slug`, `is_active`, `is_crypto_category`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Natural Resources', 'natural_resources', 1, 0, '2019-03-10 23:15:01', '2019-03-10 23:15:01', NULL),
(2, 'Renewable Resources', 'renewable_resources', 1, 0, '2019-03-10 23:16:31', '2019-03-10 23:16:31', NULL),
(3, 'Non-renewable Resources', 'non_renewable_resources', 1, 0, '2019-03-10 23:16:50', '2019-03-10 23:16:50', NULL),
(4, 'Commodity', 'commodity', 1, 0, '2019-03-10 23:36:46', '2019-03-28 23:15:26', NULL),
(5, 'USDC', 'crypto', 1, 0, '2019-04-11 04:57:49', '2019-04-11 10:30:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `data_id` varchar(255) NOT NULL,
  `data_value` text NOT NULL,
  `data_live` text CHARACTER SET utf8,
  `data_sandbox` text CHARACTER SET utf8,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `data_id`, `data_value`, `data_live`, `data_sandbox`, `created_at`, `updated_at`) VALUES
(1, 'CRYPTO_SYMBOL', 'USDC', '', '', '2019-02-20 06:22:39', '2019-02-20 06:22:39'),
(2, 'GOOGLE_API_KEY', 'AIzaSyCccvQtzVx4aAt05YnfzJDSWEzPiVnNVsY', '', '', '2019-02-20 08:45:35', '2019-02-20 08:45:35'),
(3, 'ESCROW_CONTRACT_ADDRESS', '0x4bcF2da91A8387bF2CE5e14468aeB1f6864be836', '', '', '2019-03-22 14:15:21', '2019-03-22 08:45:36'),
(4, 'USDC_CONTACT_ADDRESS', '0x7d66CDe53cc0A169cAE32712fC48934e610aeF14', '', '', '2019-02-20 08:45:35', '2019-02-20 08:45:35'),
(5, 'TRANSACTION_RECEIVING_ADDRESS', '', '', '', '2019-03-19 06:45:40', '2019-03-19 06:45:40'),
(6, 'TRANSACTION_COMMISSION', '2.326', '', '', '2019-03-22 12:32:22', '2019-03-19 06:46:22'),
(7, 'DISPUTE_RECEIVING_ADDRESS', '', '', '', '2019-03-19 06:49:07', '2019-03-19 06:49:07'),
(8, 'DISPUTE_COMMISSION', '2', '', '', '2019-03-22 11:56:02', '2019-03-22 06:26:02');

-- --------------------------------------------------------

--
-- Table structure for table `keyword_translations`
--

CREATE TABLE `keyword_translations` (
  `id` int(11) NOT NULL,
  `keyword` varchar(256) NOT NULL,
  `title` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keyword_translations`
--

INSERT INTO `keyword_translations` (`id`, `keyword`, `title`, `locale`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'dashboard', 'Dashboard', 'en', '2016-12-10 04:33:19', '2018-11-01 00:05:52', NULL),
(2, 'dashboard', 'डैशबोर्ड', 'hi', '2016-12-10 04:33:19', '2018-11-01 00:05:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `title`, `locale`, `status`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '2016-02-06 15:47:35', '2016-02-03 03:22:23'),
(2, 'Deutsch', 'de', 0, '2016-02-06 15:47:35', '2016-02-17 00:10:19'),
(3, 'Italiano', 'it', 0, '2016-02-06 15:47:35', '2016-02-19 03:14:03'),
(4, 'Fran&ccedil;ais', 'fr', 0, '2016-02-06 15:47:35', '2016-02-10 08:15:21'),
(5, 'Espa&ntilde;ol', 'eo', 0, '2016-02-06 15:47:35', '2016-02-10 08:15:22'),
(6, 'Portugu&ecirc;s (Brasil)', 'pt-BR', 0, '2016-02-06 15:47:35', '2016-02-04 08:10:24'),
(7, 'Croatian', 'hr', 0, '2016-02-06 15:47:35', '2016-02-04 08:10:25'),
(8, 'Nederlands', 'nl-NL', 0, '2016-02-06 15:47:35', '2016-02-03 07:22:19'),
(9, 'Norsk', 'nn-NO', 0, '2016-02-06 15:47:35', '2016-02-03 05:35:21'),
(10, 'Svenska', 'sv-SE', 0, '2016-02-06 15:47:35', '2016-02-03 05:35:22'),
(11, 'Hindi', 'hi', 0, '2016-12-10 04:52:25', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `language_phrases`
--

CREATE TABLE `language_phrases` (
  `id` int(11) NOT NULL,
  `phrase` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(3) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language_phrases`
--

INSERT INTO `language_phrases` (`id`, `phrase`, `content`, `locale`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 'en', '2016-11-10 13:04:13', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_07_02_230147_migration_cartalyst_sentinel', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2014_07_02_230147_migration_cartalyst_sentinel', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_user_id` int(10) UNSIGNED NOT NULL,
  `to_user_id` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `url` text NOT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - not read, 1 - read',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `from_user_id`, `to_user_id`, `message`, `url`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 42, 1, 'New Seller Bhavana registered successfully.', 'http://192.168.0.6/openbazzar/admin/users/', 1, '2019-04-01 04:14:34', '2019-04-11 23:35:25'),
(2, 1, 42, 'Checker  approved you Successfully.', 'http://192.168.0.6/openbazzar/login', 1, '2019-04-01 04:16:25', '2019-04-08 04:37:17'),
(3, 1, 42, 'Checker  approved you Successfully.', 'http://192.168.0.6/openbazzar/login', 1, '2019-04-01 04:16:30', '2019-04-08 04:37:17'),
(4, 43, 1, 'New Buyer Vishal registered successfully.', 'http://192.168.0.6/openbazzar/admin/users/', 1, '2019-04-01 04:22:16', '2019-04-11 23:35:25'),
(5, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>E0Il7cK8CRxWqzEa1AshryxvyrHUO83V</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-01 04:25:06', '2019-04-11 23:35:25'),
(6, 43, 42, 'Buyer Vishal is applied for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MTk5', 1, '2019-04-01 04:27:50', '2019-04-08 04:37:17'),
(7, 1, 31, 'Checker  approved you Successfully.', 'http://localhost/Jaydip/open_bazzar/login', 0, '2019-04-01 04:32:37', '2019-04-01 04:32:37'),
(8, 42, 43, 'Seller Bhavana accepted trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MTk5', 1, '2019-04-01 04:33:10', '2019-04-08 04:39:43'),
(9, 42, 1, 'Seller Bhavana accepted trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MTk4', 1, '2019-04-01 04:33:14', '2019-04-11 23:35:25'),
(10, 42, 43, 'Seller Bhavana added handling charges for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MTk5', 1, '2019-04-01 04:37:07', '2019-04-08 04:39:43'),
(11, 42, 1, 'Seller Bhavana added handling charges for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MTk5', 1, '2019-04-01 04:37:11', '2019-04-11 23:35:25'),
(12, 1, 5, 'Checker  approved you Successfully.', 'http://localhost/Jaydip/open_bazzar/login', 0, '2019-04-01 04:40:03', '2019-04-01 04:40:03'),
(13, 43, 42, 'Buyer Vishal did the payment for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MTk5', 1, '2019-04-01 04:40:20', '2019-04-08 04:37:17'),
(14, 43, 1, 'Buyer Vishal did the payment for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/admin/transaction/view/MTk5', 1, '2019-04-01 04:40:24', '2019-04-11 23:35:25'),
(15, 42, 43, 'Seller Bhavana added dispute for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MTk5', 1, '2019-04-01 04:48:57', '2019-04-08 04:39:43'),
(16, 42, 1, 'Seller Bhavana added dispute for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/admin/trades/chat/MTk5/NDM=', 1, '2019-04-01 04:49:01', '2019-04-11 23:35:25'),
(17, 1, 43, 'Checker settled dispute for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MTk5', 1, '2019-04-01 04:52:51', '2019-04-08 04:39:43'),
(18, 1, 42, 'Checker settled dispute for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MTk5', 1, '2019-04-01 04:52:55', '2019-04-08 04:37:17'),
(19, 42, 43, 'Seller Bhavana added shipment proof for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MTk5', 1, '2019-04-01 04:56:07', '2019-04-08 04:39:43'),
(20, 42, 1, 'Seller Bhavana added shipment proof for trade <b>DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MTk5', 1, '2019-04-01 04:56:14', '2019-04-11 23:35:25'),
(21, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>eNO6WZbN4hOy3zDmUcsHk5YUzmRq9qKR</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-01 04:58:39', '2019-04-11 23:35:25'),
(22, 43, 42, 'Buyer Vishal is applied for trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjAx', 1, '2019-04-01 04:59:32', '2019-04-08 04:37:17'),
(23, 42, 43, 'Seller Bhavana accepted trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjAx', 1, '2019-04-01 04:59:59', '2019-04-08 04:39:43'),
(24, 42, 1, 'Seller Bhavana accepted trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjAw', 1, '2019-04-01 05:00:03', '2019-04-11 23:35:25'),
(25, 42, 43, 'Seller Bhavana added handling charges for trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjAx', 1, '2019-04-01 05:00:14', '2019-04-08 04:39:43'),
(26, 42, 1, 'Seller Bhavana added handling charges for trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjAx', 1, '2019-04-01 05:00:18', '2019-04-11 23:35:25'),
(27, 43, 42, 'Buyer Vishal did the payment for trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjAx', 1, '2019-04-01 05:01:08', '2019-04-08 04:37:17'),
(28, 43, 1, 'Buyer Vishal did the payment for trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/admin/transaction/view/MjAx', 1, '2019-04-01 05:01:12', '2019-04-11 23:35:25'),
(29, 43, 42, 'Buyer Vishal added dispute for trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjAx', 1, '2019-04-01 05:01:32', '2019-04-08 04:37:17'),
(30, 43, 1, 'Buyer Vishal added dispute for trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/admin/trades/chat/MjAx/NDM=', 1, '2019-04-01 05:01:36', '2019-04-11 23:35:25'),
(31, 1, 43, 'Checker settled dispute for trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjAx', 1, '2019-04-01 05:04:05', '2019-04-08 04:39:43'),
(32, 1, 42, 'Checker settled dispute for trade <b>KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjAx', 1, '2019-04-01 05:04:09', '2019-04-08 04:37:17'),
(33, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>JFVkjbsuUO59NLuYfv1UTif5bzXoBcPX</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-01 05:05:23', '2019-04-11 23:35:25'),
(34, 43, 42, 'Buyer Vishal is applied for trade <b>lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjAz', 1, '2019-04-01 05:05:47', '2019-04-08 04:37:17'),
(35, 42, 43, 'Seller Bhavana accepted trade <b>lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjAz', 1, '2019-04-01 05:06:11', '2019-04-08 04:39:43'),
(36, 42, 1, 'Seller Bhavana accepted trade <b>lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjAy', 1, '2019-04-01 05:06:14', '2019-04-11 23:35:25'),
(37, 42, 43, 'Seller Bhavana added handling charges for trade <b>lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjAz', 1, '2019-04-01 05:06:29', '2019-04-08 04:39:43'),
(38, 42, 1, 'Seller Bhavana added handling charges for trade <b>lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjAz', 1, '2019-04-01 05:06:32', '2019-04-11 23:35:25'),
(39, 43, 42, 'Buyer Vishal did the payment for trade <b>lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjAz', 1, '2019-04-01 05:07:04', '2019-04-08 04:37:17'),
(40, 43, 1, 'Buyer Vishal did the payment for trade <b>lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32</b>', 'http://192.168.0.6/openbazzar/admin/transaction/view/MjAz', 1, '2019-04-01 05:07:08', '2019-04-11 23:35:25'),
(41, 43, 42, 'Buyer Vishal has completed the trade <b>lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjAz', 1, '2019-04-01 05:07:35', '2019-04-08 04:37:17'),
(42, 43, 1, 'Buyer Vishal has completed the trade <b>lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32</b>', 'http://192.168.0.6/openbazzar/admin/transaction/view/MjAz', 1, '2019-04-01 05:07:39', '2019-04-11 23:35:25'),
(43, 1, 3, 'Checker  approved you Successfully.', 'http://localhost/Jaydip/open_bazzar/login', 0, '2019-04-01 05:14:13', '2019-04-01 05:14:13'),
(44, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>DcsWc71bz9DlRqzR5sAR7GFmr3NZUHPa</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-01 05:45:50', '2019-04-11 23:35:25'),
(45, 43, 42, 'Buyer Vishal is applied for trade <b>zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjA1', 1, '2019-04-01 05:46:18', '2019-04-08 04:37:17'),
(46, 42, 43, 'Seller Bhavana accepted trade <b>zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjA1', 1, '2019-04-01 05:46:51', '2019-04-08 04:39:43'),
(47, 42, 1, 'Seller Bhavana accepted trade <b>zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjA0', 1, '2019-04-01 05:46:55', '2019-04-11 23:35:25'),
(48, 42, 43, 'Seller Bhavana added handling charges for trade <b>zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjA1', 1, '2019-04-01 05:47:04', '2019-04-08 04:39:43'),
(49, 42, 1, 'Seller Bhavana added handling charges for trade <b>zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjA1', 1, '2019-04-01 05:47:09', '2019-04-11 23:35:25'),
(50, 43, 42, 'Buyer Vishal did the payment for trade <b>zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjA1', 1, '2019-04-01 05:47:41', '2019-04-08 04:37:17'),
(51, 43, 1, 'Buyer Vishal did the payment for trade <b>zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W</b>', 'http://192.168.0.6/openbazzar/admin/transaction/view/NTk=', 1, '2019-04-01 05:47:45', '2019-04-11 23:35:25'),
(52, 43, 42, 'Buyer Vishal has completed the trade <b>zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjA1', 1, '2019-04-01 05:50:20', '2019-04-08 04:37:17'),
(53, 43, 1, 'Buyer Vishal has completed the trade <b>zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W</b>', 'http://192.168.0.6/openbazzar/admin/transaction/view/NjA=', 1, '2019-04-01 05:50:25', '2019-04-11 23:35:25'),
(54, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>Lif5LO837Lyel6y8I7hF8lpKfFkVR40T</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-01 06:38:57', '2019-04-11 23:35:25'),
(55, 43, 42, 'Buyer Vishal is applied for trade <b>uEBLgLN84pdcwXsAW4rHLC1vvmctUS1a</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/intrested-buyer-details/MjA3', 1, '2019-04-01 06:39:29', '2019-04-08 04:37:17'),
(56, 42, 43, 'Seller Bhavana accepted trade <b>uEBLgLN84pdcwXsAW4rHLC1vvmctUS1a</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjA3', 1, '2019-04-01 06:39:36', '2019-04-08 04:39:43'),
(57, 42, 1, 'Seller Bhavana accepted trade <b>uEBLgLN84pdcwXsAW4rHLC1vvmctUS1a</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjA2', 1, '2019-04-01 06:39:40', '2019-04-11 23:35:25'),
(58, 42, 43, 'Seller Bhavana added handling charges for trade <b>uEBLgLN84pdcwXsAW4rHLC1vvmctUS1a</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjA3', 1, '2019-04-01 06:39:49', '2019-04-08 04:39:43'),
(59, 42, 1, 'Seller Bhavana added handling charges for trade <b>uEBLgLN84pdcwXsAW4rHLC1vvmctUS1a</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjA3', 1, '2019-04-01 06:39:52', '2019-04-11 23:35:25'),
(60, 43, 42, 'Buyer Vishal did the payment for trade <b>uEBLgLN84pdcwXsAW4rHLC1vvmctUS1a</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/intrested-buyer-details/MjA3', 1, '2019-04-01 06:41:02', '2019-04-08 04:37:17'),
(61, 43, 1, 'Buyer Vishal did the payment for trade <b>uEBLgLN84pdcwXsAW4rHLC1vvmctUS1a</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/MjA3', 1, '2019-04-01 06:41:06', '2019-04-11 23:35:25'),
(62, 4, 42, 'Buyer Priyanka Kedare is applied for trade <b>MNU5XXvjE76S7dhqjFS2duXc3JYRrgFl</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/intrested-buyer-details/MjA4', 1, '2019-04-01 06:41:32', '2019-04-08 04:37:17'),
(64, 42, 1, 'Seller Bhavana accepted trade <b>MNU5XXvjE76S7dhqjFS2duXc3JYRrgFl</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjA2', 1, '2019-04-01 06:42:12', '2019-04-11 23:35:25'),
(65, 42, 4, 'Seller Bhavana added handling charges for trade <b>MNU5XXvjE76S7dhqjFS2duXc3JYRrgFl</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjA4', 1, '2019-04-01 06:42:22', '2019-04-02 02:02:59'),
(66, 42, 1, 'Seller Bhavana added handling charges for trade <b>MNU5XXvjE76S7dhqjFS2duXc3JYRrgFl</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjA4', 1, '2019-04-01 06:42:26', '2019-04-11 23:35:25'),
(67, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>MNU5XXvjE76S7dhqjFS2duXc3JYRrgFl</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/intrested-buyer-details/MjA4', 1, '2019-04-01 06:43:40', '2019-04-08 04:37:17'),
(68, 25, 42, 'Buyer Deepali is applied for trade <b>yQLSyPz67si5F4lWRFm1iR9nutLuPgIr</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjA5', 1, '2019-04-01 06:43:42', '2019-04-08 04:37:17'),
(69, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>MNU5XXvjE76S7dhqjFS2duXc3JYRrgFl</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/MjA4', 1, '2019-04-01 06:43:44', '2019-04-11 23:35:25'),
(70, 42, 25, 'Seller Bhavana accepted trade <b>yQLSyPz67si5F4lWRFm1iR9nutLuPgIr</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjA5', 0, '2019-04-01 06:44:32', '2019-04-01 06:44:32'),
(71, 42, 1, 'Seller Bhavana accepted trade <b>yQLSyPz67si5F4lWRFm1iR9nutLuPgIr</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjA2', 1, '2019-04-01 06:44:36', '2019-04-11 23:35:25'),
(72, 42, 25, 'Seller Bhavana added handling charges for trade <b>yQLSyPz67si5F4lWRFm1iR9nutLuPgIr</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjA5', 0, '2019-04-01 06:44:47', '2019-04-01 06:44:47'),
(73, 42, 1, 'Seller Bhavana added handling charges for trade <b>yQLSyPz67si5F4lWRFm1iR9nutLuPgIr</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjA5', 1, '2019-04-01 06:44:51', '2019-04-11 23:35:25'),
(74, 25, 42, 'Buyer Deepali did the payment for trade <b>yQLSyPz67si5F4lWRFm1iR9nutLuPgIr</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjA5', 1, '2019-04-01 06:45:31', '2019-04-08 04:37:17'),
(75, 25, 1, 'Buyer Deepali did the payment for trade <b>yQLSyPz67si5F4lWRFm1iR9nutLuPgIr</b>', 'http://192.168.0.6/openbazzar/admin/transaction/view/NjM=', 1, '2019-04-01 06:45:36', '2019-04-11 23:35:25'),
(76, 25, 42, 'Buyer Deepali has completed the trade <b>yQLSyPz67si5F4lWRFm1iR9nutLuPgIr</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjA5', 1, '2019-04-01 06:45:54', '2019-04-08 04:37:17'),
(77, 25, 1, 'Buyer Deepali has completed the trade <b>yQLSyPz67si5F4lWRFm1iR9nutLuPgIr</b>', 'http://192.168.0.6/openbazzar/admin/transaction/view/NjQ=', 1, '2019-04-01 06:45:58', '2019-04-11 23:35:25'),
(78, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>TOLUgELKzlzTXlUGLkU1gYAe699dJye4</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-01 06:50:12', '2019-04-11 23:35:25'),
(79, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>vp0Qe53DU6ezNADy9r7HRKpJLZDmv9Ay</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-01 07:02:23', '2019-04-11 23:35:25'),
(80, 43, 42, 'Buyer Vishal is applied for trade <b>PZcbD1F4HXb5Hu3ys64d0aCz1fymsrWY</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjEy', 1, '2019-04-01 07:25:06', '2019-04-08 04:37:17'),
(81, 42, 43, 'Seller Bhavana accepted trade <b>PZcbD1F4HXb5Hu3ys64d0aCz1fymsrWY</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjEy', 1, '2019-04-01 07:25:37', '2019-04-08 04:39:43'),
(82, 42, 1, 'Seller Bhavana accepted trade <b>PZcbD1F4HXb5Hu3ys64d0aCz1fymsrWY</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjEx', 1, '2019-04-01 07:25:41', '2019-04-11 23:35:25'),
(83, 42, 43, 'Seller Bhavana added handling charges for trade <b>PZcbD1F4HXb5Hu3ys64d0aCz1fymsrWY</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjEy', 1, '2019-04-01 07:25:49', '2019-04-08 04:39:43'),
(84, 42, 1, 'Seller Bhavana added handling charges for trade <b>PZcbD1F4HXb5Hu3ys64d0aCz1fymsrWY</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjEy', 1, '2019-04-01 07:25:53', '2019-04-11 23:35:25'),
(85, 43, 42, 'Buyer Vishal did the payment for trade <b>PZcbD1F4HXb5Hu3ys64d0aCz1fymsrWY</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/intrested-buyer-details/MjEy', 1, '2019-04-01 07:28:01', '2019-04-08 04:37:17'),
(86, 43, 1, 'Buyer Vishal did the payment for trade <b>PZcbD1F4HXb5Hu3ys64d0aCz1fymsrWY</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/NjU=', 1, '2019-04-01 07:28:05', '2019-04-11 23:35:25'),
(87, 4, 42, 'Buyer Priyanka Kedare is applied for trade <b>damMv3I98C242FeZLlmhe3t9uHUzjfnS</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjEz', 1, '2019-04-01 07:39:51', '2019-04-08 04:37:17'),
(88, 42, 4, 'Seller Bhavana accepted trade <b>damMv3I98C242FeZLlmhe3t9uHUzjfnS</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjEz', 1, '2019-04-01 07:40:15', '2019-04-02 02:02:59'),
(89, 42, 1, 'Seller Bhavana accepted trade <b>damMv3I98C242FeZLlmhe3t9uHUzjfnS</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjEx', 1, '2019-04-01 07:40:20', '2019-04-11 23:35:25'),
(90, 42, 4, 'Seller Bhavana added handling charges for trade <b>damMv3I98C242FeZLlmhe3t9uHUzjfnS</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjEz', 1, '2019-04-01 07:40:29', '2019-04-02 02:02:59'),
(91, 42, 1, 'Seller Bhavana added handling charges for trade <b>damMv3I98C242FeZLlmhe3t9uHUzjfnS</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjEz', 1, '2019-04-01 07:40:33', '2019-04-11 23:35:25'),
(92, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>damMv3I98C242FeZLlmhe3t9uHUzjfnS</b>', 'http://192.168.0.6/openbazzar/seller/trade/intrested-buyer-details/MjEz', 1, '2019-04-01 07:41:38', '2019-04-08 04:37:17'),
(93, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>damMv3I98C242FeZLlmhe3t9uHUzjfnS</b>', 'http://192.168.0.6/openbazzar/admin/transaction/view/NjY=', 1, '2019-04-01 07:41:41', '2019-04-11 23:35:25'),
(94, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>s3VvrK5ff3WXW9L3kPa0DZwKKtAicyYS</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-02 00:19:17', '2019-04-11 23:35:25'),
(95, 43, 42, 'Buyer Vishal is applied for trade <b>CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/intrested-buyer-details/Mg==', 1, '2019-04-02 00:24:53', '2019-04-08 04:37:17'),
(96, 42, 43, 'Seller Bhavana accepted trade <b>CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/Mg==', 1, '2019-04-02 00:25:54', '2019-04-08 04:39:43'),
(97, 42, 1, 'Seller Bhavana accepted trade <b>CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/offers/NDI=/MQ==', 1, '2019-04-02 00:25:58', '2019-04-11 23:35:25'),
(98, 42, 43, 'Seller Bhavana added handling charges for trade <b>CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/Mg==', 1, '2019-04-02 00:26:10', '2019-04-08 04:39:43'),
(99, 42, 1, 'Seller Bhavana added handling charges for trade <b>CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/Mg==', 1, '2019-04-02 00:26:14', '2019-04-11 23:35:25'),
(100, 43, 42, 'Buyer Vishal did the payment for trade <b>CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/intrested-buyer-details/Mg==', 1, '2019-04-02 00:27:06', '2019-04-08 04:37:17'),
(101, 43, 1, 'Buyer Vishal did the payment for trade <b>CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/Njc=', 1, '2019-04-02 00:27:10', '2019-04-11 23:35:25'),
(102, 42, 43, 'Seller Bhavana added shipment proof for trade <b>CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/Mg==', 1, '2019-04-02 00:28:06', '2019-04-08 04:39:43'),
(103, 42, 1, 'Seller Bhavana added shipment proof for trade <b>CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/Mg==', 1, '2019-04-02 00:28:10', '2019-04-11 23:35:25'),
(104, 4, 42, 'Buyer Priyanka Kedare is applied for trade <b>azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/intrested-buyer-details/Mw==', 1, '2019-04-02 00:39:13', '2019-04-08 04:37:17'),
(105, 42, 4, 'Seller Bhavana accepted trade <b>azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/Mw==', 1, '2019-04-02 00:39:50', '2019-04-02 02:02:59'),
(106, 42, 1, 'Seller Bhavana accepted trade <b>azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/offers/NDI=/MQ==', 1, '2019-04-02 00:39:54', '2019-04-11 23:35:25'),
(107, 42, 4, 'Seller Bhavana added handling charges for trade <b>azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/Mw==', 1, '2019-04-02 00:40:05', '2019-04-02 02:02:59'),
(108, 42, 1, 'Seller Bhavana added handling charges for trade <b>azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/Mw==', 1, '2019-04-02 00:40:09', '2019-04-11 23:35:25'),
(109, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/intrested-buyer-details/Mw==', 1, '2019-04-02 00:42:41', '2019-04-08 04:37:17'),
(110, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/Njg=', 1, '2019-04-02 00:42:45', '2019-04-11 23:35:25'),
(111, 42, 4, 'Seller Bhavana added shipment proof for trade <b>azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/Mw==', 1, '2019-04-02 00:54:42', '2019-04-02 02:02:59'),
(112, 42, 1, 'Seller Bhavana added shipment proof for trade <b>azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/Mw==', 1, '2019-04-02 00:54:46', '2019-04-11 23:35:25'),
(113, 44, 1, 'New Seller seller sagar registered successfully.', 'http://192.168.0.7/openbazzar/admin/users/', 1, '2019-04-02 01:05:49', '2019-04-11 23:35:25'),
(114, 45, 1, 'New Seller test registered successfully.', 'http://192.168.0.7/openbazzar/admin/users/', 1, '2019-04-02 01:07:29', '2019-04-11 23:35:25'),
(115, 1, 45, 'Checker  approved you Successfully.', 'http://192.168.0.7/openbazzar/login', 0, '2019-04-02 01:08:35', '2019-04-02 01:08:35'),
(116, 45, 1, 'Seller test added new trade. Trade ID: <b>a7vm7UxiY8RYpxES6wJP8lEmCdHNZNBO</b>', 'http://192.168.0.7/openbazzar/admin/trades/NDU=', 1, '2019-04-02 01:12:22', '2019-04-11 23:35:25'),
(117, 4, 45, 'Buyer Priyanka Kedare is applied for trade <b>jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k</b>', 'http://192.168.0.7/openbazzar/seller/trade/intrested-buyer-details/NQ==', 0, '2019-04-02 01:14:40', '2019-04-02 01:14:40'),
(118, 45, 4, 'Seller test accepted trade <b>jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k</b>', 'http://192.168.0.7/openbazzar/buyer/trade/view/NQ==', 1, '2019-04-02 01:15:39', '2019-04-02 02:02:59'),
(119, 45, 1, 'Seller test accepted trade <b>jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k</b>', 'http://192.168.0.7/openbazzar/admin/trades/offers/NDU=/NA==', 1, '2019-04-02 01:15:43', '2019-04-11 23:35:25'),
(120, 45, 4, 'Seller test added handling charges for trade <b>jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k</b>', 'http://192.168.0.7/openbazzar/buyer/trade/view/NQ==', 1, '2019-04-02 01:16:20', '2019-04-02 02:02:59'),
(121, 45, 1, 'Seller test added handling charges for trade <b>jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k</b>', 'http://192.168.0.7/openbazzar/admin/trades/view/NQ==', 1, '2019-04-02 01:16:24', '2019-04-11 23:35:25'),
(122, 4, 45, 'Buyer Priyanka Kedare did the payment for trade <b>jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k</b>', 'http://192.168.0.7/openbazzar/seller/trade/intrested-buyer-details/NQ==', 0, '2019-04-02 01:53:01', '2019-04-02 01:53:01'),
(123, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k</b>', 'http://192.168.0.7/openbazzar/admin/transaction/view/Njk=', 1, '2019-04-02 01:53:05', '2019-04-11 23:35:25'),
(124, 4, 45, 'Buyer Priyanka Kedare has completed the trade <b>jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k</b>', 'http://192.168.0.7/openbazzar/seller/trade/intrested-buyer-details/NQ==', 0, '2019-04-02 01:54:22', '2019-04-02 01:54:22'),
(125, 4, 1, 'Buyer Priyanka Kedare has completed the trade <b>jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k</b>', 'http://192.168.0.7/openbazzar/admin/transaction/view/NzA=', 1, '2019-04-02 01:54:26', '2019-04-11 23:35:25'),
(126, 2, 45, 'Buyer Sagar Jadhav is applied for trade <b>2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6</b>', 'http://192.168.0.7/openbazzar/seller/trade/intrested-buyer-details/Ng==', 0, '2019-04-02 03:27:32', '2019-04-02 03:27:32'),
(127, 45, 2, 'Seller test accepted trade <b>2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6</b>', 'http://192.168.0.7/openbazzar/buyer/trade/view/Ng==', 0, '2019-04-02 03:27:53', '2019-04-02 03:27:53'),
(128, 45, 1, 'Seller test accepted trade <b>2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6</b>', 'http://192.168.0.7/openbazzar/admin/trades/offers/NDU=/NA==', 1, '2019-04-02 03:27:58', '2019-04-11 23:35:25'),
(129, 45, 2, 'Seller test added handling charges for trade <b>2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6</b>', 'http://192.168.0.7/openbazzar/buyer/trade/view/Ng==', 0, '2019-04-02 03:28:58', '2019-04-02 03:28:58'),
(130, 45, 1, 'Seller test added handling charges for trade <b>2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6</b>', 'http://192.168.0.7/openbazzar/admin/trades/view/Ng==', 1, '2019-04-02 03:29:02', '2019-04-11 23:35:25'),
(131, 2, 45, 'Buyer Sagar Jadhav did the payment for trade <b>2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6</b>', 'http://192.168.0.7/openbazzar/seller/trade/intrested-buyer-details/Ng==', 0, '2019-04-02 03:29:55', '2019-04-02 03:29:55'),
(132, 2, 1, 'Buyer Sagar Jadhav did the payment for trade <b>2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6</b>', 'http://192.168.0.7/openbazzar/admin/transaction/view/NzE=', 1, '2019-04-02 03:29:59', '2019-04-11 23:35:25'),
(133, 2, 45, 'Buyer Sagar Jadhav has completed the trade <b>2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6</b>', 'http://192.168.0.7/openbazzar/seller/trade/intrested-buyer-details/Ng==', 0, '2019-04-02 03:35:53', '2019-04-02 03:35:53'),
(134, 2, 1, 'Buyer Sagar Jadhav has completed the trade <b>2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6</b>', 'http://192.168.0.7/openbazzar/admin/transaction/view/NzI=', 1, '2019-04-02 03:35:57', '2019-04-11 23:35:25'),
(135, 22, 1, 'Seller Jaydip added new trade. Trade ID: <b>O8rOgUEjSTXmtiEy23EfHBONWvk9x1S7</b>', 'http://192.168.0.7/openbazzar/admin/trades/MjI=', 1, '2019-04-02 03:48:13', '2019-04-11 23:35:25'),
(136, 4, 22, 'Buyer Priyanka Kedare is applied for trade <b>U4mm4ixDjBgjCabDg5ViK41dsTzJLBqI</b>', 'http://192.168.0.7/openbazzar/seller/trade/interested-buyer-details/OA==', 0, '2019-04-02 04:06:35', '2019-04-02 04:06:35'),
(137, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>mg3rwhHh59qmy3GJDNq4LA9S6PoaTW3b</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/NDI=', 1, '2019-04-02 07:11:27', '2019-04-11 23:35:25'),
(138, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>ugMMXFDBAUZZ6aH6GFciEcJAY0kGfuLJ</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/NDI=', 1, '2019-04-02 07:20:00', '2019-04-11 23:35:25'),
(139, 4, 42, 'Buyer Priyanka Kedare is applied for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTE=', 1, '2019-04-02 07:23:02', '2019-04-08 04:37:17'),
(140, 42, 4, 'Seller Bhavana accepted trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTE=', 1, '2019-04-02 07:23:21', '2019-04-02 23:05:32'),
(141, 42, 1, 'Seller Bhavana accepted trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/offers/NDI=/MTA=', 1, '2019-04-02 07:23:26', '2019-04-11 23:35:25'),
(142, 42, 4, 'Seller Bhavana added handling charges for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTE=', 1, '2019-04-02 07:24:20', '2019-04-02 23:05:17'),
(143, 42, 1, 'Seller Bhavana added handling charges for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/MTE=', 1, '2019-04-02 07:24:25', '2019-04-11 23:35:25'),
(144, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTE=', 1, '2019-04-02 07:25:47', '2019-04-08 04:37:17'),
(145, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/NzM=', 1, '2019-04-02 07:25:51', '2019-04-11 23:35:25'),
(146, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTE=', 1, '2019-04-02 07:26:12', '2019-04-08 04:37:17'),
(147, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/NzQ=', 1, '2019-04-02 07:26:16', '2019-04-11 23:35:25'),
(148, 42, 4, 'Seller Bhavana added shipment proof for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTE=', 1, '2019-04-02 07:26:39', '2019-04-02 23:04:58'),
(149, 42, 1, 'Seller Bhavana added shipment proof for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/MTE=', 1, '2019-04-02 07:26:43', '2019-04-11 23:35:25'),
(150, 4, 42, 'Buyer Priyanka Kedare has completed the trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTE=', 1, '2019-04-02 07:27:04', '2019-04-08 04:37:17'),
(151, 4, 1, 'Buyer Priyanka Kedare has completed the trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/NzU=', 1, '2019-04-02 07:27:08', '2019-04-11 23:35:25'),
(152, 4, 42, 'Buyer Priyanka Kedare has completed the trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTE=', 1, '2019-04-02 07:27:27', '2019-04-08 04:37:17'),
(153, 4, 1, 'Buyer Priyanka Kedare has completed the trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/NzY=', 1, '2019-04-02 07:27:31', '2019-04-11 23:35:25'),
(154, 4, 42, 'Buyer Priyanka Kedare is applied for trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTI=', 1, '2019-04-02 23:20:12', '2019-04-08 04:37:17'),
(155, 42, 4, 'Seller Bhavana accepted trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTI=', 1, '2019-04-02 23:21:00', '2019-04-02 23:22:50'),
(156, 42, 1, 'Seller Bhavana accepted trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/offers/NDI=/OQ==', 1, '2019-04-02 23:21:04', '2019-04-11 23:35:25'),
(157, 42, 4, 'Seller Bhavana added handling charges for trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTI=', 1, '2019-04-02 23:21:16', '2019-04-02 23:22:57'),
(158, 42, 1, 'Seller Bhavana added handling charges for trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/MTI=', 1, '2019-04-02 23:21:20', '2019-04-11 23:35:25'),
(159, 42, 4, 'Seller Bhavana added shipment proof for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTE=', 1, '2019-04-02 23:25:01', '2019-04-02 23:27:24'),
(160, 42, 1, 'Seller Bhavana added shipment proof for trade <b>V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/MTE=', 1, '2019-04-02 23:25:05', '2019-04-11 23:35:25'),
(161, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTI=', 1, '2019-04-02 23:25:54', '2019-04-08 04:37:17'),
(162, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/Nzc=', 1, '2019-04-02 23:25:58', '2019-04-11 23:35:25'),
(163, 42, 4, 'Seller Bhavana added shipment proof for trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTI=', 1, '2019-04-02 23:26:55', '2019-04-02 23:27:31'),
(164, 42, 1, 'Seller Bhavana added shipment proof for trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/MTI=', 1, '2019-04-02 23:26:59', '2019-04-11 23:35:25'),
(165, 4, 42, 'Buyer Priyanka Kedare has completed the trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTI=', 1, '2019-04-02 23:27:45', '2019-04-08 04:37:17'),
(166, 4, 1, 'Buyer Priyanka Kedare has completed the trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/Nzg=', 1, '2019-04-02 23:27:49', '2019-04-11 23:35:25'),
(167, 42, 4, 'Seller Bhavana added shipment proof for trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTI=', 1, '2019-04-02 23:28:04', '2019-04-02 23:28:30'),
(168, 42, 1, 'Seller Bhavana added shipment proof for trade <b>iXhmHV0SXgNGCiK386xqHI5JadNCweeB</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/MTI=', 1, '2019-04-02 23:28:07', '2019-04-11 23:35:25'),
(169, 43, 42, 'Buyer Vishal is applied for trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTM=', 1, '2019-04-02 23:39:03', '2019-04-08 04:37:17'),
(170, 42, 43, 'Seller Bhavana accepted trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTM=', 1, '2019-04-02 23:40:32', '2019-04-08 04:39:43'),
(171, 42, 1, 'Seller Bhavana accepted trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/offers/NDI=/MTA=', 1, '2019-04-02 23:40:36', '2019-04-11 23:35:25'),
(172, 42, 43, 'Seller Bhavana added handling charges for trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTM=', 1, '2019-04-02 23:42:51', '2019-04-08 04:39:43'),
(173, 42, 1, 'Seller Bhavana added handling charges for trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/MTM=', 1, '2019-04-02 23:42:55', '2019-04-11 23:35:25'),
(174, 43, 42, 'Buyer Vishal did the payment for trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTM=', 1, '2019-04-02 23:44:15', '2019-04-08 04:37:17'),
(175, 43, 1, 'Buyer Vishal did the payment for trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/Nzk=', 1, '2019-04-02 23:44:19', '2019-04-11 23:35:25'),
(176, 43, 42, 'Buyer Vishal has completed the trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MTM=', 1, '2019-04-02 23:49:24', '2019-04-08 04:37:17'),
(177, 43, 1, 'Buyer Vishal has completed the trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/ODA=', 1, '2019-04-02 23:49:28', '2019-04-11 23:35:25'),
(178, 42, 43, 'Seller Bhavana added shipment proof for trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/MTM=', 1, '2019-04-02 23:50:04', '2019-04-08 04:39:43'),
(179, 42, 1, 'Seller Bhavana added shipment proof for trade <b>LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/MTM=', 1, '2019-04-02 23:50:08', '2019-04-11 23:35:25'),
(180, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>zTdvotppJDnJWL8hWUgjK7lbMelSMFK7</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-03 00:18:56', '2019-04-11 23:35:25'),
(181, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>LOA8Aoqza3cLeGjGJTRK94RCN9yM2PyU</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-03 01:11:13', '2019-04-11 23:35:25'),
(182, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>sc1M3RL6i3glHp3IyFlnVJHzeNquVdMv</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-03 01:12:14', '2019-04-11 23:35:25'),
(183, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>1pBldbZgc3QHNmV8USLjIRoJ7p75QYjC</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-03 01:18:58', '2019-04-11 23:35:25'),
(184, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>lc2Bbi9kSRDGw5sTq8O2UQwvNPItk0Oj</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-03 01:19:39', '2019-04-11 23:35:25'),
(185, 22, 1, 'Seller Jaydip added new trade. Trade ID: <b>SQQYvqnDPt3nRoAVLWQu1SCO43eJa02i</b>', 'http://192.168.0.7/openbazzar/admin/trades/MjI=', 1, '2019-04-03 06:33:01', '2019-04-11 23:35:25'),
(186, 22, 1, 'Seller Jaydip added new trade. Trade ID: <b>0zmAUmzkJi2LBoPYs1MeXmka69ytYmeF</b>', 'http://192.168.0.7/openbazzar/admin/trades/MjI=', 1, '2019-04-03 06:37:45', '2019-04-11 23:35:25'),
(187, 22, 1, 'Seller Jaydip added new trade. Trade ID: <b>3kQs6A47yk5jJArZRKRj4YkiTjYQbjr5</b>', 'http://192.168.0.7/openbazzar/admin/trades/MjI=', 1, '2019-04-03 06:50:29', '2019-04-11 23:35:25'),
(188, 22, 1, 'Seller Jaydip added new trade. Trade ID: <b>Q6JxgIP7IXp7V8PmCmq7dSu8PV1iPOZo</b>', 'http://192.168.0.7/openbazzar/admin/trades/MjI=', 1, '2019-04-03 06:59:34', '2019-04-11 23:35:25'),
(189, 22, 1, 'Seller Jaydip added new trade. Trade ID: <b>7a6RVxpkyCXdKtZfqjsmgrjZ0dK8OhcS</b>', 'http://192.168.0.7/openbazzar/admin/trades/MjI=', 1, '2019-04-03 07:07:04', '2019-04-11 23:35:25'),
(190, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>giocfaezsmQ0pFvVsPXfJG3g6YeZ3RVM</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-03 23:59:41', '2019-04-11 23:35:25'),
(191, 4, 42, 'Buyer Priyanka Kedare is applied for trade <b>7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MjU=', 1, '2019-04-04 00:00:47', '2019-04-08 04:37:17'),
(192, 43, 42, 'Buyer Vishal is applied for trade <b>kD66o8Yvz5vFgvNVZ7YGXI9gfUJSBPKN</b>', 'http://192.168.0.6/openbazzar/seller/trade/interested-buyer-details/MjY=', 1, '2019-04-04 00:01:30', '2019-04-08 04:37:17'),
(193, 42, 43, 'Seller Bhavana accepted trade <b>kD66o8Yvz5vFgvNVZ7YGXI9gfUJSBPKN</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjY=', 1, '2019-04-04 00:02:17', '2019-04-08 04:39:43'),
(194, 42, 1, 'Seller Bhavana accepted trade <b>kD66o8Yvz5vFgvNVZ7YGXI9gfUJSBPKN</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjQ=', 1, '2019-04-04 00:02:21', '2019-04-11 23:35:25'),
(195, 42, 43, 'Seller Bhavana added handling charges for trade <b>kD66o8Yvz5vFgvNVZ7YGXI9gfUJSBPKN</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjY=', 1, '2019-04-04 00:02:30', '2019-04-08 04:39:43'),
(196, 42, 1, 'Seller Bhavana added handling charges for trade <b>kD66o8Yvz5vFgvNVZ7YGXI9gfUJSBPKN</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjY=', 1, '2019-04-04 00:02:34', '2019-04-11 23:35:25'),
(197, 42, 4, 'Seller Bhavana accepted trade <b>7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjU=', 1, '2019-04-04 00:02:49', '2019-04-04 00:04:01'),
(198, 42, 1, 'Seller Bhavana accepted trade <b>7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MjQ=', 1, '2019-04-04 00:02:53', '2019-04-11 23:35:25'),
(199, 42, 4, 'Seller Bhavana added handling charges for trade <b>7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MjU=', 1, '2019-04-04 00:03:02', '2019-04-04 00:03:20'),
(200, 42, 1, 'Seller Bhavana added handling charges for trade <b>7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MjU=', 1, '2019-04-04 00:03:06', '2019-04-11 23:35:25'),
(201, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MjU=', 1, '2019-04-04 00:04:22', '2019-04-08 04:37:17'),
(202, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/ODE=', 1, '2019-04-04 00:04:26', '2019-04-11 23:35:25'),
(203, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>ee07JifNU5yq14j21foG39hRTgfxrAz4</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-04 00:08:36', '2019-04-11 23:35:25'),
(204, 4, 42, 'Buyer Priyanka Kedare is applied for trade <b>7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/Mjg=', 1, '2019-04-04 00:09:06', '2019-04-08 04:37:17'),
(205, 43, 42, 'Buyer Vishal is applied for trade <b>Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe</b>', 'http://192.168.0.6/openbazzar/seller/trade/interested-buyer-details/Mjk=', 1, '2019-04-04 00:09:23', '2019-04-08 04:37:17'),
(206, 42, 4, 'Seller Bhavana accepted trade <b>7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/Mjg=', 0, '2019-04-04 00:09:51', '2019-04-04 00:09:51'),
(207, 42, 1, 'Seller Bhavana accepted trade <b>7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/Mjc=', 1, '2019-04-04 00:09:55', '2019-04-11 23:35:25'),
(208, 42, 4, 'Seller Bhavana added handling charges for trade <b>7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/Mjg=', 0, '2019-04-04 00:10:06', '2019-04-04 00:10:06'),
(209, 42, 1, 'Seller Bhavana added handling charges for trade <b>7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/Mjg=', 1, '2019-04-04 00:10:09', '2019-04-11 23:35:25'),
(210, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/Mjg=', 1, '2019-04-04 00:10:32', '2019-04-08 04:37:17'),
(211, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/ODI=', 1, '2019-04-04 00:10:35', '2019-04-11 23:35:25'),
(212, 42, 43, 'Seller Bhavana accepted trade <b>Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/Mjk=', 1, '2019-04-04 00:11:21', '2019-04-08 04:39:43'),
(213, 42, 1, 'Seller Bhavana accepted trade <b>Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/Mjc=', 1, '2019-04-04 00:11:27', '2019-04-11 23:35:25'),
(214, 42, 43, 'Seller Bhavana added handling charges for trade <b>Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/Mjk=', 1, '2019-04-04 00:11:41', '2019-04-08 04:39:43'),
(215, 42, 1, 'Seller Bhavana added handling charges for trade <b>Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/Mjk=', 1, '2019-04-04 00:11:45', '2019-04-11 23:35:25'),
(216, 43, 42, 'Buyer Vishal did the payment for trade <b>Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/Mjk=', 1, '2019-04-04 00:12:29', '2019-04-08 04:37:17'),
(217, 43, 1, 'Buyer Vishal did the payment for trade <b>Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/ODM=', 1, '2019-04-04 00:12:33', '2019-04-11 23:35:25'),
(218, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>czfB3C5DpilFEB2jCIDZKzIhlutwBN9p</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-04 00:47:47', '2019-04-11 23:35:25'),
(219, 43, 42, 'Buyer Vishal is applied for trade <b>zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MzE=', 1, '2019-04-04 00:50:30', '2019-04-08 04:37:17'),
(220, 42, 43, 'Seller Bhavana accepted trade <b>zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzE=', 1, '2019-04-04 00:50:47', '2019-04-08 04:39:43'),
(221, 42, 1, 'Seller Bhavana accepted trade <b>zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MzA=', 1, '2019-04-04 00:50:52', '2019-04-11 23:35:25'),
(222, 42, 43, 'Seller Bhavana added handling charges for trade <b>zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzE=', 1, '2019-04-04 00:51:02', '2019-04-08 04:39:43'),
(223, 42, 1, 'Seller Bhavana added handling charges for trade <b>zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MzE=', 1, '2019-04-04 00:51:05', '2019-04-11 23:35:25'),
(224, 43, 42, 'Buyer Vishal did the payment for trade <b>zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MzE=', 1, '2019-04-04 00:51:32', '2019-04-08 04:37:17'),
(225, 43, 1, 'Buyer Vishal did the payment for trade <b>zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/ODQ=', 1, '2019-04-04 00:51:36', '2019-04-11 23:35:25'),
(226, 4, 42, 'Buyer Priyanka Kedare is applied for trade <b>LaaR4gaj10q2PhAcg4cbgdCg6sUteahn</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MzI=', 1, '2019-04-04 01:12:34', '2019-04-08 04:37:17'),
(227, 42, 4, 'Seller Bhavana accepted trade <b>LaaR4gaj10q2PhAcg4cbgdCg6sUteahn</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzI=', 0, '2019-04-04 01:13:44', '2019-04-04 01:13:44'),
(228, 42, 1, 'Seller Bhavana accepted trade <b>LaaR4gaj10q2PhAcg4cbgdCg6sUteahn</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MzA=', 1, '2019-04-04 01:13:49', '2019-04-11 23:35:25'),
(229, 42, 4, 'Seller Bhavana added handling charges for trade <b>LaaR4gaj10q2PhAcg4cbgdCg6sUteahn</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzI=', 0, '2019-04-04 01:13:58', '2019-04-04 01:13:58'),
(230, 42, 1, 'Seller Bhavana added handling charges for trade <b>LaaR4gaj10q2PhAcg4cbgdCg6sUteahn</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MzI=', 1, '2019-04-04 01:14:02', '2019-04-11 23:35:25'),
(231, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>LaaR4gaj10q2PhAcg4cbgdCg6sUteahn</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MzI=', 1, '2019-04-04 01:14:13', '2019-04-08 04:37:17'),
(232, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>LaaR4gaj10q2PhAcg4cbgdCg6sUteahn</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/ODU=', 1, '2019-04-04 01:14:17', '2019-04-11 23:35:25'),
(233, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>qtpR7s6Ea29blNfN667VAi9w90gAYI89</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-04 01:15:31', '2019-04-11 23:35:25'),
(234, 4, 42, 'Buyer Priyanka Kedare is applied for trade <b>Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MzQ=', 1, '2019-04-04 01:19:09', '2019-04-08 04:37:17'),
(235, 42, 4, 'Seller Bhavana accepted trade <b>Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzQ=', 0, '2019-04-04 01:19:42', '2019-04-04 01:19:42'),
(236, 42, 1, 'Seller Bhavana accepted trade <b>Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MzM=', 1, '2019-04-04 01:19:47', '2019-04-11 23:35:25'),
(237, 42, 4, 'Seller Bhavana added handling charges for trade <b>Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzQ=', 0, '2019-04-04 01:19:57', '2019-04-04 01:19:57'),
(238, 42, 1, 'Seller Bhavana added handling charges for trade <b>Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MzQ=', 1, '2019-04-04 01:20:01', '2019-04-11 23:35:25'),
(239, 4, 42, 'Buyer Priyanka Kedare did the payment for trade <b>Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MzQ=', 1, '2019-04-04 01:21:02', '2019-04-08 04:37:17'),
(240, 4, 1, 'Buyer Priyanka Kedare did the payment for trade <b>Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/ODY=', 1, '2019-04-04 01:21:06', '2019-04-11 23:35:25'),
(241, 43, 42, 'Buyer Vishal is applied for trade <b>Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MzU=', 1, '2019-04-04 01:23:08', '2019-04-08 04:37:17'),
(242, 42, 43, 'Seller Bhavana accepted trade <b>Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzU=', 1, '2019-04-04 01:23:25', '2019-04-08 04:39:43'),
(243, 42, 1, 'Seller Bhavana accepted trade <b>Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MzM=', 1, '2019-04-04 01:23:29', '2019-04-11 23:35:25');
INSERT INTO `notifications` (`id`, `from_user_id`, `to_user_id`, `message`, `url`, `is_read`, `created_at`, `updated_at`) VALUES
(244, 42, 43, 'Seller Bhavana added handling charges for trade <b>Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzU=', 1, '2019-04-04 01:23:39', '2019-04-08 04:39:43'),
(245, 42, 1, 'Seller Bhavana added handling charges for trade <b>Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MzU=', 1, '2019-04-04 01:23:43', '2019-04-11 23:35:25'),
(246, 43, 42, 'Buyer Vishal did the payment for trade <b>Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MzU=', 1, '2019-04-04 01:24:13', '2019-04-08 04:37:17'),
(247, 43, 1, 'Buyer Vishal did the payment for trade <b>Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/ODc=', 1, '2019-04-04 01:24:17', '2019-04-11 23:35:25'),
(248, 25, 42, 'Buyer Deepali is applied for trade <b>peA1koczSqXkTCWHcoG87fGtQ7yXpRao</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/MzY=', 1, '2019-04-04 01:26:12', '2019-04-08 04:37:17'),
(249, 42, 25, 'Seller Bhavana accepted trade <b>peA1koczSqXkTCWHcoG87fGtQ7yXpRao</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzY=', 0, '2019-04-04 01:26:38', '2019-04-04 01:26:38'),
(250, 42, 1, 'Seller Bhavana accepted trade <b>peA1koczSqXkTCWHcoG87fGtQ7yXpRao</b>', 'http://192.168.0.6/openbazzar/admin/trades/offers/NDI=/MzM=', 1, '2019-04-04 01:26:42', '2019-04-11 23:35:25'),
(251, 42, 25, 'Seller Bhavana added handling charges for trade <b>peA1koczSqXkTCWHcoG87fGtQ7yXpRao</b>', 'http://192.168.0.6/openbazzar/buyer/trade/view/MzY=', 0, '2019-04-04 01:26:55', '2019-04-04 01:26:55'),
(252, 42, 1, 'Seller Bhavana added handling charges for trade <b>peA1koczSqXkTCWHcoG87fGtQ7yXpRao</b>', 'http://192.168.0.6/openbazzar/admin/trades/view/MzY=', 1, '2019-04-04 01:26:59', '2019-04-11 23:35:25'),
(253, 28, 42, 'Buyer Savi is applied for trade <b>ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/Mzc=', 1, '2019-04-04 01:28:40', '2019-04-08 04:37:17'),
(254, 42, 28, 'Seller Bhavana accepted trade <b>ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/Mzc=', 0, '2019-04-04 01:31:56', '2019-04-04 01:31:56'),
(255, 42, 1, 'Seller Bhavana accepted trade <b>ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/offers/NDI=/MzM=', 1, '2019-04-04 01:32:01', '2019-04-11 23:35:25'),
(256, 42, 28, 'Seller Bhavana added handling charges for trade <b>ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h</b>', 'http://localhost/Jaydip/open_bazzar/buyer/trade/view/Mzc=', 0, '2019-04-04 01:32:30', '2019-04-04 01:32:30'),
(257, 42, 1, 'Seller Bhavana added handling charges for trade <b>ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h</b>', 'http://localhost/Jaydip/open_bazzar/admin/trades/view/Mzc=', 1, '2019-04-04 01:32:34', '2019-04-11 23:35:25'),
(258, 28, 42, 'Buyer Savi did the payment for trade <b>ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h</b>', 'http://localhost/Jaydip/open_bazzar/seller/trade/interested-buyer-details/Mzc=', 1, '2019-04-04 01:37:00', '2019-04-08 04:37:17'),
(259, 28, 1, 'Buyer Savi did the payment for trade <b>ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h</b>', 'http://localhost/Jaydip/open_bazzar/admin/transaction/view/ODg=', 1, '2019-04-04 01:37:04', '2019-04-11 23:35:25'),
(260, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>ultTT8XpxCtSToXOR8yLQVgpL0rm8xK9</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-05 00:43:15', '2019-04-11 23:35:25'),
(261, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>q3EAJWUKzN7ZVn9gC3FLqZh6TY5lIuQ0</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-05 01:06:14', '2019-04-11 23:35:25'),
(262, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>Te6sLCbhng4eprEpWQ02WLwop2r0iWX4</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-05 01:07:39', '2019-04-11 23:35:25'),
(263, 43, 42, 'Buyer Vishal is applied for trade <b>ZwV93RHHbQcQIJ7MNw2TMXJie6ei3UEF</b>', 'http://192.168.0.6/openbazzar/seller/trade/interested-buyer-details/NDE=', 1, '2019-04-05 01:17:01', '2019-04-08 04:37:17'),
(264, 43, 42, 'Buyer Vishal is applied for trade <b>xQQLVJ9GsLNeJWctCf8ODkyecWlRmEGB</b>', 'http://192.168.0.6/openbazzar/seller/trade/interested-buyer-details/NDI=', 1, '2019-04-05 01:17:40', '2019-04-08 04:37:17'),
(265, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>rWltgmUAZQpoWOdlE7Sl1xDQbwi5PQ5G</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-05 01:26:52', '2019-04-11 23:35:25'),
(266, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>LXlmO2YWLU2Pf3HCFvCkMijBuPT5ET2K</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-05 01:28:00', '2019-04-11 23:35:25'),
(267, 42, 1, 'Seller Bhavana added new trade. Trade ID: <b>7rnSkUUzhaGaoQSG1LtnZrPl9d20rJWX</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDI=', 1, '2019-04-05 01:28:30', '2019-04-11 23:35:25'),
(268, 48, 1, 'New Simran registered successfully.', 'http://192.168.0.6/openbazzar/admin/users/', 1, '2019-04-09 01:12:46', '2019-04-11 23:35:25'),
(269, 49, 1, 'New Ziva registered successfully.', 'http://192.168.0.6/openbazzar/admin/users/', 1, '2019-04-09 01:20:36', '2019-04-11 23:35:25'),
(270, 1, 49, 'Checker  approved you Successfully.', 'http://192.168.0.6/openbazzar/login', 0, '2019-04-09 01:32:46', '2019-04-09 01:32:46'),
(271, 1, 48, 'Checker  approved you Successfully.', 'http://192.168.0.6/openbazzar/login', 1, '2019-04-09 01:32:55', '2019-04-10 07:43:23'),
(272, 48, 1, 'Seller Simran added new trade. Trade ID: <b>psFQ6P5Mdl8mOa39w4oUKSVgXcOLpUfr</b>', 'http://192.168.0.6/openbazzar/admin/trades/NDg=', 1, '2019-04-10 06:29:15', '2019-04-11 23:35:25'),
(273, 48, 42, 'Buyer Simran is applied for trade <b>IwEks3VFb6SO8Hu7ZyEKsyj9NHN5rDdG</b>', 'http://192.168.0.6/openbazzar/seller/trade/interested-buyer-details/NDQ=', 0, '2019-04-10 06:57:29', '2019-04-10 06:57:29'),
(274, 4, 22, 'Buyer Priyanka Kedare is applied for trade <b>JDcJndr8XxhGqeFYquWjiZmSQuXh2dnY</b>', 'http://192.168.0.7/openbazzar/seller/trade/interested-buyer-details/NTA=', 1, '2019-04-11 07:53:14', '2019-04-12 06:20:28'),
(275, 1, 50, 'Checker  approved you Successfully.', 'http://192.168.0.7/openbazzar/login', 1, '2019-04-11 23:28:45', '2019-04-11 23:37:41'),
(276, 22, 4, 'Seller Jaydip accepted trade <b>JDcJndr8XxhGqeFYquWjiZmSQuXh2dnY</b>', 'http://192.168.0.7/openbazzar/buyer/trade/view/NTA=', 0, '2019-04-12 05:01:04', '2019-04-12 05:01:04'),
(277, 22, 1, 'Seller Jaydip accepted trade <b>JDcJndr8XxhGqeFYquWjiZmSQuXh2dnY</b>', 'http://192.168.0.7/openbazzar/admin/trades/offers/MjI=/NDk=', 0, '2019-04-12 05:01:11', '2019-04-12 05:01:11'),
(278, 51, 1, 'New tester registered successfully.', 'http://192.168.0.7/openbazzar/admin/users/', 0, '2019-04-12 05:56:34', '2019-04-12 05:56:34'),
(279, 22, 48, 'Buyer Jaydip is applied for trade <b>3ooJRG1755itqFNA2SR9rpMcccWSd2tN</b>', 'http://192.168.0.7/openbazzar/seller/trade/interested-buyer-details/NTE=', 0, '2019-04-12 06:50:08', '2019-04-12 06:50:08'),
(280, 22, 1, 'Seller Jaydip added new trade. Trade ID: <b>VzTBtJoFN8Q9j7IUkSQoVAs7ZCpQL2sm</b>', 'http://192.168.0.7/openbazzar/admin/trades/MjI=', 0, '2019-04-12 23:17:17', '2019-04-12 23:17:17');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persistences`
--

CREATE TABLE `persistences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(3, 1, 'YWEhdzyHy17o28NxgIwPocgKAZdsWR6m', '2016-04-25 09:11:50', '2016-04-25 09:11:50'),
(4, 1, 'ohjZeLW0IJcBzKoSOsVYYPq4pNGLwNW9', '2016-04-25 23:31:27', '2016-04-25 23:31:27'),
(5, 1, 'Kv0vgkcewQYBKGNTrSdKKaMaP2srjqL2', '2016-04-26 00:48:34', '2016-04-26 00:48:34'),
(6, 1, 'BtZFQI6mqYLkBds3viVMWxYFa6ntpjiA', '2016-04-27 06:13:48', '2016-04-27 06:13:48'),
(7, 1, 'kO6IY5kueVHDeCwiaByXUEurIryxIIsZ', '2016-04-30 04:40:09', '2016-04-30 04:40:09'),
(8, 1, 'ODbVCEd5GlK0x1t5YfYGijzITInKeB1w', '2016-04-30 07:01:36', '2016-04-30 07:01:36'),
(9, 1, 'lTdCjvFHEA0fQW27RKpfnL4KzKxNqgDM', '2016-05-01 22:38:20', '2016-05-01 22:38:20'),
(10, 1, 'Toevdm6KNeIiX164iMcyQwYjLmUxf3WX', '2016-05-02 02:55:21', '2016-05-02 02:55:21'),
(11, 1, '2tKCFPQxNKIcnvLNk1FNI8GqjRQtyTY6', '2016-05-02 04:26:53', '2016-05-02 04:26:53'),
(12, 1, 'ph9qUZpA2yWLbfkWXn4VLQ3MBvggZB5g', '2016-05-03 22:51:32', '2016-05-03 22:51:32'),
(13, 1, 'dzq5xfSAGsqhfyJzDXiPzqxCnBFvtrpf', '2016-05-04 22:20:59', '2016-05-04 22:20:59'),
(14, 1, 'KSUtIgDd1r3ut2eg43i0eZYoaMhPJQti', '2016-05-04 23:43:56', '2016-05-04 23:43:56'),
(15, 1, 'tTZF8nLGA4le3uSOIlKHkGTtPLVsxtSz', '2016-05-05 22:26:49', '2016-05-05 22:26:49'),
(17, 1, 'qW7plMaYUYLt53fXOJ40ffdyZVkUjitu', '2016-05-06 00:06:40', '2016-05-06 00:06:40'),
(18, 1, 'xWyvBYTdhyMzsnu3doHgjCFdMEX2Aqvq', '2016-05-06 03:09:00', '2016-05-06 03:09:00'),
(19, 1, 'e2MkxKOD1S14l1BCXva9KgIEoAIewQcC', '2016-05-06 03:18:34', '2016-05-06 03:18:34'),
(20, 1, '5VwxmQJG8HjVbf9RRxG8RtnEH7xpLLsB', '2016-05-06 03:53:32', '2016-05-06 03:53:32'),
(23, 1, 'l4RTliZuRS2bdHEFmiXkpxH1QxTDH196', '2016-05-06 05:34:10', '2016-05-06 05:34:10'),
(25, 1, 'qW2GgENX14F4CXdjRF6SSj0eL9ANNzTo', '2016-05-06 08:17:20', '2016-05-06 08:17:20'),
(26, 1, 'XGRFKQI0wGijkuNFMnaPhI296WVDhnIc', '2016-05-06 08:51:48', '2016-05-06 08:51:48'),
(29, 1, 'QuqQ4OGPVbmCO3M64DLwr8bP8j1UmpKm', '2016-05-06 09:02:00', '2016-05-06 09:02:00'),
(30, 1, 'yBeF82eCEgP9TpBxaiU4xvJnmIQkK1bk', '2016-05-06 09:42:55', '2016-05-06 09:42:55'),
(31, 1, 'u6lsmMYSUmpHzDASlYHn0sWlRw2A9lou', '2016-05-19 08:47:49', '2016-05-19 08:47:49'),
(32, 1, 'Mx3EwspZkZ7gQpYCKIXqcYIXXgMkJsSo', '2016-05-21 04:08:02', '2016-05-21 04:08:02'),
(33, 1, 'sN6jdZX71x8okxAcUnBXq6wBBkGeqspg', '2016-05-22 22:52:22', '2016-05-22 22:52:22'),
(34, 1, 'Xuj6I2ah7iJQZM1RAWyGwo45QUaQrdBK', '2016-06-11 06:26:10', '2016-06-11 06:26:10'),
(35, 1, '5b4nIGn89LO6rVDs7zw45krOKhejc6qW', '2016-07-15 00:53:28', '2016-07-15 00:53:28'),
(37, 1, 'N4iQXjTlnci6vSLgWZxYVfdxxuK5haZn', '2016-07-15 01:59:59', '2016-07-15 01:59:59'),
(38, 1, 'Yh2H8G0XzJLsyqgCKUoecqoXpKM4OfEA', '2016-08-06 04:39:56', '2016-08-06 04:39:56'),
(39, 1, 'aTlVcTPqszrlnmDFVNroSJYlqIGg0iz9', '2016-08-16 07:35:36', '2016-08-16 07:35:36'),
(40, 1, 'bi5UHzlPjARxFGFGDh06OV6bAjxJwt27', '2016-08-16 22:27:44', '2016-08-16 22:27:44'),
(42, 2, 'gdUYcFmBPfmKdQtJ1bvjrPeVtzZD1W9C', '2016-08-17 00:44:16', '2016-08-17 00:44:16'),
(43, 1, 'Hcy4RAVDTI9wRYDqDzXPtCFIXLl6Sv9k', '2016-08-17 01:08:04', '2016-08-17 01:08:04'),
(44, 1, 'X7A1lyoyoh6bT2wyC0f9Mif4nasQPzRX', '2016-08-17 03:43:02', '2016-08-17 03:43:02'),
(45, 2, 'Yf5hU5wX1VjfkdKcp2C1SkZICMAECJVt', '2016-08-20 06:22:56', '2016-08-20 06:22:56'),
(46, 1, 'eselAvWp1pSzx42SZ8AK99shvRGx2U9x', '2016-08-29 03:24:18', '2016-08-29 03:24:18'),
(48, 1, 'mlHBvcAAHdTgRmxIrxCn6Cn7yMHKcoJa', '2016-09-01 03:27:31', '2016-09-01 03:27:31'),
(52, 1, 'iQ6axEtp98AejaWLfACVvzAaHcF6gSgC', '2016-09-01 05:09:17', '2016-09-01 05:09:17'),
(53, 1, 'lGeO68klod1Q7tIZOldKCgtbWrYF4YEX', '2016-09-02 22:26:56', '2016-09-02 22:26:56'),
(54, 1, '6MAmtOfdDbKGjoJdnQY7iETYTpb8gnGR', '2016-09-03 05:07:33', '2016-09-03 05:07:33'),
(55, 1, '9fTeIZjjG5nVMH9PnWBMHp3WzXjx2Ysk', '2016-09-04 23:15:12', '2016-09-04 23:15:12'),
(57, 1, 'Cjpacmqk6ep1G3rk4C0ZWfIJwTTCscIt', '2016-09-06 07:40:25', '2016-09-06 07:40:25'),
(58, 1, 'zcGBqgeiTORN4YvaJXVGvQLGDaPWoBMS', '2016-09-07 01:56:19', '2016-09-07 01:56:19'),
(59, 1, 'ETWChHJZnCXG7q8oG1jrEBt16OQMGAuN', '2016-09-20 22:26:12', '2016-09-20 22:26:12'),
(60, 1, 'MQGg9qur9mxfKDZS6Q901pxiKOGov9ta', '2016-10-03 04:21:48', '2016-10-03 04:21:48'),
(61, 1, 'V4SGvqIP4DUtNO7rNdJMnWdHbojuIWOw', '2016-10-13 05:51:16', '2016-10-13 05:51:16'),
(62, 1, 'fxbR67uUSywpttSrXLMfIb50wXrv74Cm', '2016-10-24 23:05:33', '2016-10-24 23:05:33'),
(63, 1, 'uVWt2FJjD4lZh5QMt8kLYmB4kXvBeO80', '2016-10-26 23:05:55', '2016-10-26 23:05:55'),
(64, 1, 'uju4KRqzNoDfXlOGsoBYyYahEXNm9GCI', '2016-10-27 00:59:44', '2016-10-27 00:59:44'),
(65, 1, '1uVIQF9d1ydqU8ut2PD1NjbeNtvP9Kmq', '2016-10-27 01:58:11', '2016-10-27 01:58:11'),
(66, 1, 'ogq67U5aCKASyr98iS1YW9DFXwYuBMOD', '2016-10-28 00:52:17', '2016-10-28 00:52:17'),
(67, 1, 'NZQ3dl0KSWbscviGQB9uT7nmeHAmeyl1', '2016-11-05 01:01:53', '2016-11-05 01:01:53'),
(68, 1, '74ke7cZi59WdufyPVpSfQv2dQVrqYsfi', '2016-11-05 07:33:19', '2016-11-05 07:33:19'),
(69, 1, 'RQ1iseiyqxOxk32nmXKsUibRzlvZc2X4', '2016-11-07 01:11:54', '2016-11-07 01:11:54'),
(70, 1, 'XpkOtotduJF0rSEYdt6ZLtBo60dJNxpn', '2016-11-07 04:02:11', '2016-11-07 04:02:11'),
(71, 1, 'BW4QIoeGhRvxy8aFQpv9RCHbejpqP52o', '2016-11-08 07:49:45', '2016-11-08 07:49:45'),
(72, 1, 'mOhvFEptvooDA84tyKkT7hSlELFpBNHP', '2016-11-09 03:09:34', '2016-11-09 03:09:34'),
(75, 1, '1Ip1gVQpqbtZj1tkyYMRZwMkXfUUYsQp', '2016-11-10 00:28:45', '2016-11-10 00:28:45'),
(78, 1, 'm93X9L9kgbEydlQaWkHgVV9HdQ5UwKOO', '2016-11-10 02:57:00', '2016-11-10 02:57:00'),
(79, 1, 'OwmuqztoAVER1OKlKaaw6ipQPNL1G6YS', '2016-11-10 06:38:49', '2016-11-10 06:38:49'),
(80, 1, '5IBCSv0CL1uyepMSeOnfVhO1LERqw889', '2016-11-10 07:13:48', '2016-11-10 07:13:48'),
(81, 1, 'pHtb3JRNvyVhvpbRYHi3hp0CxhN5mlkN', '2016-11-10 07:33:30', '2016-11-10 07:33:30'),
(82, 1, 'RzIfGyMgMJvaHQR6oUavrUB392pc357j', '2016-11-10 22:30:04', '2016-11-10 22:30:04'),
(83, 1, 'PgfBy5RB94nY8ehVqA0YKA6a7jQx7Adp', '2016-11-10 23:00:12', '2016-11-10 23:00:12'),
(84, 1, 'NVgqzBRutXFBA4COdFWmuz5MgXNGrDNq', '2016-11-22 00:20:23', '2016-11-22 00:20:23'),
(85, 1, 'OuBhFPmnCUbKVFt7XkMPETz1MeoFoRmL', '2016-12-09 07:35:56', '2016-12-09 07:35:56'),
(86, 1, 'KekM39HwLb0xz6gKGDLs8egOSXmPoXh4', '2016-12-09 07:45:58', '2016-12-09 07:45:58'),
(87, 1, 'SfoisGhc2J8UQPkkuc1tAJjBw4Qbw8jq', '2016-12-27 01:05:43', '2016-12-27 01:05:43'),
(88, 1, 'lGOpLz60gkVnzcDLoEPQOxgob8mgLMAv', '2017-01-20 23:30:52', '2017-01-20 23:30:52'),
(89, 1, '6vKi8IVRJLjhKJhAPXwERQk0LKsFDGU4', '2017-01-20 23:34:39', '2017-01-20 23:34:39'),
(90, 1, 'dMh6GUVIZzx06Nx25d70aq4t3HfrpOY6', '2017-01-21 06:53:40', '2017-01-21 06:53:40'),
(91, 1, 'rsp4emdifk4xnHAAcTv560AUDhZqhm0B', '2017-01-22 22:51:05', '2017-01-22 22:51:05'),
(92, 10, 'oGzgqeGFJZuYGB6m443sy4yGvqxayFhg', '2017-01-23 00:01:15', '2017-01-23 00:01:15'),
(93, 1, 'ChizmJZId5VYfp9IsTFMEaB95dHdETP9', '2017-01-23 03:53:01', '2017-01-23 03:53:01'),
(94, 1, 'gIVasba4doIYkiUhw3ywgNWoU0rcDpFD', '2017-01-23 03:58:19', '2017-01-23 03:58:19'),
(95, 1, 'tDTgUZRswTOafqgwRDGUeSZNP7crmm2K', '2017-01-23 05:12:34', '2017-01-23 05:12:34'),
(96, 1, 'g34z5PFP7KpFOQ0wvbzf37naxzbuhd1O', '2017-02-22 00:18:05', '2017-02-22 00:18:05'),
(97, 1, 'R3vIElxuwrQZOjFUG1TxvDxkQlEuGcWy', '2017-02-22 03:04:16', '2017-02-22 03:04:16'),
(98, 1, 'DALessyPVBZtUhtmqPFomOzEleYJXZwy', '2017-02-22 04:57:44', '2017-02-22 04:57:44'),
(99, 1, '2x0fV2Z4V11EnIzIanGUUQyKuFd1xMbz', '2017-02-27 02:52:38', '2017-02-27 02:52:38'),
(101, 1, 'n4jEOW9Og4ulSENp4TIs9S7cjwJVSWLb', '2017-02-27 03:00:27', '2017-02-27 03:00:27'),
(102, 1, 'mM09PHt6oqJJl0aFwKtZNQISGLYYNpiu', '2017-03-13 23:24:26', '2017-03-13 23:24:26'),
(103, 1, '4S6TT3i2onouciszUSieizDDaTMN5Yzu', '2017-03-22 22:41:50', '2017-03-22 22:41:50'),
(104, 1, 'QMa7sjPtUIbYWBKCEZvwk504Ru9vZoRl', '2018-04-23 03:17:02', '2018-04-23 03:17:02'),
(105, 1, '7M0E659krmEfT20U9JUYHtPNl6FWKQls', '2018-04-23 03:22:31', '2018-04-23 03:22:31'),
(106, 1, '3roYkTLWuzco8lMwhDOMPhzaBTwNNy1B', '2018-04-23 03:23:23', '2018-04-23 03:23:23'),
(107, 1, '6p9r5p6ZdJzj4OlnSTUoMbilMFpLOikX', '2018-04-23 03:38:11', '2018-04-23 03:38:11'),
(108, 1, 'r5FhWSgtfIncpLu8qMORtWpXTYwzkdIW', '2018-04-23 04:46:47', '2018-04-23 04:46:47'),
(109, 1, 'RTmsSZw3JUrgET5SH150OEyUZr5suU6V', '2018-04-23 05:18:07', '2018-04-23 05:18:07'),
(110, 1, 'vwmq4JuYVsyCfUrmizqDyauKQzjmwxhb', '2018-04-23 05:55:45', '2018-04-23 05:55:45'),
(111, 1, '1oPRoCGkLUnCd9LVouBq3gaHzANBuvUT', '2018-04-23 05:55:52', '2018-04-23 05:55:52'),
(112, 1, 'GggcEreFvvRWKFRV3LUwzmKCl1DPtVh9', '2018-04-23 05:56:34', '2018-04-23 05:56:34'),
(113, 1, '2mEwWSKKIOGOmlxiILbkfxt2wdXQs7cs', '2018-04-23 05:57:01', '2018-04-23 05:57:01'),
(114, 1, 'gGCZoIwKzB9dZFlBky7e3JXGZo3zrpyf', '2018-04-23 06:00:04', '2018-04-23 06:00:04'),
(115, 1, 'taUjFwxUCMmm3s694OtWcbcEhM1yvct7', '2018-04-23 06:04:25', '2018-04-23 06:04:25'),
(116, 1, 'pZNMzwD8TNIKMRxhcvxP72rK0hUf512n', '2018-04-23 06:04:46', '2018-04-23 06:04:46'),
(117, 1, 'y4m4C3HhV3RnPKruSo4AlZz2CY5b3wDy', '2018-04-23 06:05:08', '2018-04-23 06:05:08'),
(118, 1, 'd3woi8EJgarh41okwhYTkpEQ8azOSx5x', '2018-04-23 06:24:58', '2018-04-23 06:24:58'),
(119, 1, 'WqRLtGtHkWQvTfJCQEcbm2qbwHr7fy6U', '2018-04-23 07:00:31', '2018-04-23 07:00:31'),
(120, 1, '3mSSPMN1ageG1AVjR88t83dgbMBO4moI', '2018-04-23 07:26:32', '2018-04-23 07:26:32'),
(121, 1, 'Teo6Xkm0b2LbPnabmb4QLwzaUPJ4ANFb', '2018-04-23 07:35:46', '2018-04-23 07:35:46'),
(122, 1, 'TLLw3h5waLyshqOQR5BeWjOFPLN2eg8U', '2018-04-23 08:28:48', '2018-04-23 08:28:48'),
(123, 1, 'Lt2zXsMjQ1DX7jj2H8cCZEzV2zOiicX5', '2018-04-23 23:30:15', '2018-04-23 23:30:15'),
(124, 1, 'JVkxcqPd73WG18syyeChY0Y5hfc5EVAy', '2018-04-23 23:31:53', '2018-04-23 23:31:53'),
(125, 1, 'ObO9QtUXvcZM8Pdd5mhcb3viQ7c9bCA9', '2018-04-23 23:48:07', '2018-04-23 23:48:07'),
(126, 1, 'OkLilXLOKNBcjfS8nDDhldE8YZhfC1Pq', '2018-04-24 00:03:17', '2018-04-24 00:03:17'),
(127, 1, 'ptDxjGnuGLRkF21fpZPuQMd102W2hZYP', '2018-04-24 00:09:57', '2018-04-24 00:09:57'),
(128, 1, '7UlDDJj7hchIXzzGpmwIfAuUuQ0gyDQ0', '2018-04-24 00:35:21', '2018-04-24 00:35:21'),
(129, 1, 'GOVpdxE3TxKtNxrYG0QlZFFEZGEZxkzq', '2018-04-24 01:00:42', '2018-04-24 01:00:42'),
(130, 1, '6boobPyDxUJvYX0DbSRYmmaf2MHkAPQT', '2018-04-24 01:04:51', '2018-04-24 01:04:51'),
(131, 1, 'gAZWPV8L4uMmFAtVQntD9dyfvlNREWJ0', '2018-04-24 01:22:44', '2018-04-24 01:22:44'),
(132, 1, '7LTr6U4TsBOLnIAWaomIpi1tcIJewTFQ', '2018-04-24 01:30:53', '2018-04-24 01:30:53'),
(133, 1, '2CuaSbyN26njrv4RmQBT3YD14mMKM2hh', '2018-04-24 01:42:09', '2018-04-24 01:42:09'),
(134, 1, 'serZZprqKKfdhYlJQ3Zdc7O1AuJn5sQd', '2018-04-24 03:07:27', '2018-04-24 03:07:27'),
(135, 1, 'ZPu6OD1vzU6reec6ubzv2UNohmA7MM6v', '2018-04-24 03:31:33', '2018-04-24 03:31:33'),
(136, 1, 'yDJCTdovnNsgZ69DWWsYs1uAzAKnzByM', '2018-04-24 05:18:57', '2018-04-24 05:18:57'),
(137, 1, 'AfarOYHN1kiDGzJNhQAjihh3QVw6lxVH', '2018-04-24 05:25:04', '2018-04-24 05:25:04'),
(138, 1, 'quRDUNZ65njsXF5TvGYFigPXKyH3UxqM', '2018-04-24 06:25:54', '2018-04-24 06:25:54'),
(139, 1, 'Rk4n7oC7Zk860XHzMrTYoJYPRvOz2eK9', '2018-04-24 06:40:37', '2018-04-24 06:40:37'),
(140, 1, 'rOK7M9tRGyQmIHJEpHcJTaMAZ7b5MJ5P', '2018-04-24 06:57:26', '2018-04-24 06:57:26'),
(141, 1, 'RNx7BZs8cNOGAuRUEtlTIU6W4DeJitoB', '2018-04-24 07:08:21', '2018-04-24 07:08:21'),
(142, 1, 'OTToVINzQfK7yTqfAcHukITk1DnViY2Q', '2018-04-24 07:44:13', '2018-04-24 07:44:13'),
(143, 1, '31XauE5wCAAFBDS8ja90LCrM2mD9N8EL', '2018-04-24 07:49:19', '2018-04-24 07:49:19'),
(144, 1, 'oeyfdnplTyEil0p8ZMegCc3T68qQ2IIB', '2018-04-24 07:55:08', '2018-04-24 07:55:08'),
(145, 1, '1N5Wz0GJxRQA2hd40t6ZbP32GNGrw4Z6', '2018-04-24 08:46:08', '2018-04-24 08:46:08'),
(146, 1, 'eO0pezaLabNhf66qZiywnNRcWC76bBW0', '2018-04-24 22:57:34', '2018-04-24 22:57:34'),
(147, 1, 'btnfp4kXUL9kkQy1DRC4dU1D7oPpADpL', '2018-04-24 22:58:22', '2018-04-24 22:58:22'),
(148, 1, 'iyjFI118qN4qIF5H34SD0GKmGCWFmd6B', '2018-04-24 22:58:35', '2018-04-24 22:58:35'),
(149, 1, 'qgqEzsDGNmFVNfTVkXQRw5ao1kpxVBCo', '2018-04-24 22:59:47', '2018-04-24 22:59:47'),
(150, 1, 'ueua8TbtUVV5vMewOycvO3x4atNuFcIC', '2018-04-24 22:59:54', '2018-04-24 22:59:54'),
(151, 1, '5og96tq7NU4DqJheq3rmT24hjmJYlI8U', '2018-04-24 23:01:14', '2018-04-24 23:01:14'),
(152, 1, 'XFab72WNVUDVGxw6I2pbkzPtgp7UmrZV', '2018-04-24 23:01:27', '2018-04-24 23:01:27'),
(153, 1, '8pkeV3k6MCOhizDD43EZZvGgiglYgpQB', '2018-04-24 23:01:42', '2018-04-24 23:01:42'),
(154, 1, 'ppFwzxoCniJqGNCTVoDWT6sTB1ddpNbx', '2018-04-24 23:02:00', '2018-04-24 23:02:00'),
(155, 1, 'b4XPMH1ujr5ucIEoVexLjZgC3OGjxC9F', '2018-04-24 23:03:28', '2018-04-24 23:03:28'),
(156, 1, 'XiDh8ErJFlf1FFV6x0jW7OfI0aXKZMaU', '2018-04-24 23:03:46', '2018-04-24 23:03:46'),
(157, 1, 'ETNDK81eVBWwJzyGdHrNCfRyyUHtzdfu', '2018-04-24 23:03:51', '2018-04-24 23:03:51'),
(158, 1, '8tmBXKWdW2AUrRdwISq1W3TXAeTWVwke', '2018-04-24 23:04:51', '2018-04-24 23:04:51'),
(159, 1, 'MCebCEIYdS8H7UKP38nPSNYqV8NJZ40Q', '2018-04-24 23:05:14', '2018-04-24 23:05:14'),
(160, 1, '7KNJShihzt2QM2BmOeDeB4isTYjSJDA6', '2018-04-24 23:05:27', '2018-04-24 23:05:27'),
(161, 1, 'qkr5QI764hvmrj7hytc8rurBSSypcRZ9', '2018-04-24 23:06:01', '2018-04-24 23:06:01'),
(162, 1, 'tsJqoKkjLj7vf37PmLj5nYWhAO6dOWDB', '2018-04-24 23:06:12', '2018-04-24 23:06:12'),
(163, 1, 'CCiIcwJKKgViJ2TouUGkrk4Cv9y3L89s', '2018-04-24 23:06:35', '2018-04-24 23:06:35'),
(164, 1, 'SxkJXssXY2lKRw4lIMB8Sq27nlAwzCn0', '2018-04-24 23:40:48', '2018-04-24 23:40:48'),
(165, 1, 'zGt5GI0Aj5Wwnc2cp0qoOtv7GO1MbcGg', '2018-04-24 23:42:01', '2018-04-24 23:42:01'),
(166, 1, '51EofMhqTqi3h4n1JiT7SXs0dBpTSAnk', '2018-04-24 23:42:35', '2018-04-24 23:42:35'),
(167, 1, 'McyNkrnCOHlQbz6FvjNAjkx55XetXxfV', '2018-04-24 23:42:38', '2018-04-24 23:42:38'),
(168, 1, 'p3yAMeXsL07mg9T5xj9N81E071NCUJT4', '2018-04-24 23:42:45', '2018-04-24 23:42:45'),
(169, 1, '4Bl44GOH0z0W28dEDXFQMWyPzK2JKWDx', '2018-04-24 23:43:04', '2018-04-24 23:43:04'),
(170, 1, '3qmnP2VXppEDpF7gzLHxwbXtSQv1w6N6', '2018-04-24 23:43:28', '2018-04-24 23:43:28'),
(171, 1, 'XgGKoMHsCKWxHAb1cTNmWjX7Y6CezW02', '2018-04-24 23:43:34', '2018-04-24 23:43:34'),
(172, 1, 'HUMULq1N8KupV2Y9gtWI7rksZ2webQTS', '2018-04-24 23:43:39', '2018-04-24 23:43:39'),
(173, 1, 'HLjUpSPk2RFyy5jOAbTuMA2l9p9YNmJq', '2018-04-24 23:44:01', '2018-04-24 23:44:01'),
(174, 1, 'aXbN6qJNisb14Sw9giAcMgGswsbaIlQ9', '2018-04-24 23:49:36', '2018-04-24 23:49:36'),
(175, 1, 'wd514WwYHIMf5cpPQXN69YmngAGsWa5p', '2018-04-24 23:49:45', '2018-04-24 23:49:45'),
(176, 1, '5Q8QzQiuAlKIYwXOs7c2ji8Ahg7sOPkt', '2018-04-24 23:50:24', '2018-04-24 23:50:24'),
(177, 1, 'VS0ndxn2JFpUXA2CYoxccXuxMszlOsWo', '2018-04-24 23:50:29', '2018-04-24 23:50:29'),
(178, 1, 'RUvBeqp52vM8DKuuDjtj4xs00C6KIKgE', '2018-04-24 23:50:52', '2018-04-24 23:50:52'),
(179, 1, 'GGAS2xTkzsH8UqVRPgSMP8weD4pA2VhD', '2018-04-25 00:44:04', '2018-04-25 00:44:04'),
(180, 1, '05XdN7wdPKsMbvliIIwXxBXVfLDxTuhu', '2018-04-25 00:46:29', '2018-04-25 00:46:29'),
(181, 1, '9acfuJjoZpMLqLh2nU6GjIgepJCrpnQ6', '2018-04-25 00:48:20', '2018-04-25 00:48:20'),
(182, 1, 'UEAGwRvIMshmXq2DNh8rcCJLIL0euGSd', '2018-04-25 03:42:37', '2018-04-25 03:42:37'),
(183, 1, 'GNuoyze0yX0K49OEcoAJ0m2zoAO5JHST', '2018-04-25 03:42:48', '2018-04-25 03:42:48'),
(184, 1, 'MNi2oHklqTZseypxPy25sU5FU2EfSUL8', '2018-04-25 03:52:58', '2018-04-25 03:52:58'),
(188, 1, 'ls1ugJ2b4m5xN0SxMYMFKYrEJL5d8Ncb', '2018-04-25 04:45:29', '2018-04-25 04:45:29'),
(191, 1, 'OhFMZ3NAaVyOpBh8KDKUrMbhomquMzsP', '2018-04-25 05:17:00', '2018-04-25 05:17:00'),
(192, 1, 'bALKrFcWYmpOpF9sHbtCBWxvgiWHhv9q', '2018-04-25 05:17:25', '2018-04-25 05:17:25'),
(195, 1, '56u3BaBLj5UtPFu9gHxk9SOGVjtht4Mo', '2018-04-25 06:15:29', '2018-04-25 06:15:29'),
(196, 1, 'vKcuyQcuEVa8zMAkPjNmO5jhYHDlT9qB', '2018-04-25 06:38:29', '2018-04-25 06:38:29'),
(197, 1, 'HP1YuUtcMLAoAc8Jf2nR8vZsv1bYZj1j', '2018-04-25 06:38:50', '2018-04-25 06:38:50'),
(202, 1, 'L61VBIrxmGUrtbnYHQEsasHnnSebNg3p', '2018-04-25 07:08:09', '2018-04-25 07:08:09'),
(203, 1, 'kfT9yAbppZRXVYcVVbGasc87bSMTW3aN', '2018-04-25 07:08:37', '2018-04-25 07:08:37'),
(204, 1, 'P0VYeVctk63kOARVWRiBacHsN9hzamLi', '2018-04-25 07:10:01', '2018-04-25 07:10:01'),
(205, 1, 'xVJovO59Lo94mKCPtvY1IR76do0wh3hk', '2018-04-25 07:10:23', '2018-04-25 07:10:23'),
(206, 1, 'ZV07GBwFq5Alg3gZokI5yvEFFjqFJhHa', '2018-04-25 07:11:03', '2018-04-25 07:11:03'),
(207, 1, 'mXYTEqjew1yq9dJTsJvVxhH5WfF1cUQY', '2018-04-25 07:14:34', '2018-04-25 07:14:34'),
(210, 1, 'bxrPyOBetGtA1EHihLIKESH9CEXQpb8a', '2018-04-25 08:14:12', '2018-04-25 08:14:12'),
(213, 1, '1vSGW1Iqg2PsvHcOWI5PUoncjzSXXwvp', '2018-04-25 09:00:27', '2018-04-25 09:00:27'),
(216, 1, 'aAS2w57WwqeEwAMeeGkWFXMdxZfGjLDj', '2018-04-26 02:11:15', '2018-04-26 02:11:15'),
(218, 1, 'doh30yCtEcXbXoHvtYapQx8Ka1ok9mGU', '2018-04-26 08:50:07', '2018-04-26 08:50:07'),
(220, 1, 'O8ahNxDCkEZGw9dme2yrXWsvayuEyfS1', '2018-04-27 00:47:42', '2018-04-27 00:47:42'),
(221, 1, 'ZSE3qQRHj0ZRCr2XDLLRnqLIkt2RAhq6', '2018-04-27 00:48:25', '2018-04-27 00:48:25'),
(225, 1, 'M1rZ9J5PvHAEaWeTivUHnpBTV19PVUYG', '2018-04-27 01:03:24', '2018-04-27 01:03:24'),
(228, 1, '27yNlAllesFF4tRoBTbFtD3tDtg4vghQ', '2018-04-27 01:14:20', '2018-04-27 01:14:20'),
(230, 1, 'kGdU7RgVZfeOWK04B9rXJRN9xjbrOsHr', '2018-04-27 01:14:30', '2018-04-27 01:14:30'),
(248, 1, 'WPdRLKzdkfO3eR2v3nWzguUz776uhjGd', '2018-04-27 01:54:46', '2018-04-27 01:54:46'),
(249, 1, '9mXD6iGmkKxfPNncqU48h271OegiRJG6', '2018-04-27 03:49:15', '2018-04-27 03:49:15'),
(250, 1, 'Oudf7Giy0zqBaJLbSGkLQu01BMjJLQT3', '2018-04-27 03:51:07', '2018-04-27 03:51:07'),
(251, 1, 'Jp0aJLnpvLU9tFbp4xWMYQollKy0tr91', '2018-04-27 04:14:04', '2018-04-27 04:14:04'),
(253, 1, 'K1r0mh1dQOoNc3vM2LusVzEBI2uhCrt9', '2018-04-27 05:01:05', '2018-04-27 05:01:05'),
(254, 1, '6Ja0KAR6rNB5yLm7dH7KrOoztCzvaN6w', '2018-04-27 05:50:33', '2018-04-27 05:50:33'),
(255, 1, 'qMs1EqPEb4J7cze71TP48Rk0uLSP1k9T', '2018-04-27 07:27:50', '2018-04-27 07:27:50'),
(261, 1, 'Tnh2aQnIXZF3yy5tLkFVDvlpcBpAbnZJ', '2018-04-30 00:05:11', '2018-04-30 00:05:11'),
(262, 1, 'iEFnJ3qZAndo7oxsWy6I9zhmnZIeHaHh', '2018-04-30 01:03:35', '2018-04-30 01:03:35'),
(263, 1, 'KqvqXlDWjXMnL996tSIDRIoWqUs6lJBu', '2018-04-30 01:04:01', '2018-04-30 01:04:01'),
(264, 1, '4wWhGPuNmJ3j3zKY8xedKn0BoZpqK5hj', '2018-04-30 01:53:50', '2018-04-30 01:53:50'),
(265, 1, 'UiiUbeWcm9PYjjW4AFqrb833QuGMPpqT', '2018-04-30 02:04:59', '2018-04-30 02:04:59'),
(266, 1, '9PwUxol2U39jMNSnH09OCkFqBxhRDLCW', '2018-04-30 03:19:04', '2018-04-30 03:19:04'),
(267, 1, 'cDxKdEkZfyjiD0SPtjNMPUwf443RMEhz', '2018-04-30 04:15:20', '2018-04-30 04:15:20'),
(268, 1, '8puxFy2rTYU16Azr8WacSbxVvhNwKiX1', '2018-04-30 07:22:38', '2018-04-30 07:22:38'),
(269, 1, 'Ml6K4e0FDiQ6zoFgRwccRkE8kODG9M2q', '2018-04-30 07:47:08', '2018-04-30 07:47:08'),
(270, 1, 're8lgqCBedzieAEDvhA7ZDlIXE0Hsu6T', '2018-05-01 22:44:34', '2018-05-01 22:44:34'),
(271, 1, 'fCIaijNYA0NXIVZInv1FaJmFVDKlaLQJ', '2018-05-02 03:59:04', '2018-05-02 03:59:04'),
(272, 1, 'F0j6Xi5SSyAE06rzDZBNvVHMYWtNp0DP', '2018-05-02 05:55:37', '2018-05-02 05:55:37'),
(273, 1, '1uciwdQuggr37eCkbYzxI76MYhAABHpU', '2018-05-02 22:52:50', '2018-05-02 22:52:50'),
(274, 1, '32NpufrtMfd5ekIkhcyfOsy027MbNBhR', '2018-05-04 00:25:42', '2018-05-04 00:25:42'),
(275, 1, 'xKW6dowGDwNilAFc86HuD5ivcsWvSuyz', '2018-05-04 06:08:37', '2018-05-04 06:08:37'),
(276, 1, 'LXcmSyqjiSNzXGVNMeYpoMsu73tLz9gA', '2018-05-04 06:38:04', '2018-05-04 06:38:04'),
(277, 1, 'm73CsPR7zZ9vd74yKcfEXzQIliA7IIDZ', '2018-05-04 06:59:02', '2018-05-04 06:59:02'),
(278, 1, 'xSrBtV0tEcBSLBGuPidQ0ggVHDWuyslt', '2018-05-04 07:09:54', '2018-05-04 07:09:54'),
(279, 1, 'xFhuVPc1aJJgEQUAERgTdwWFeZWpmGdr', '2018-05-05 00:11:58', '2018-05-05 00:11:58'),
(280, 1, '4wbzud4lw7Ic074zNi5DtXsP098LQKD6', '2018-05-05 00:58:08', '2018-05-05 00:58:08'),
(281, 1, 'XQKFd6TEJowtf2BT9GgaLS3vPxRDNZKX', '2018-05-05 04:29:14', '2018-05-05 04:29:14'),
(282, 1, 'NHYEbFfnh1jkc6mqnKoySSMF7NjcQYRm', '2018-05-05 06:29:22', '2018-05-05 06:29:22'),
(283, 1, 'X8qgobUguOrvchgvzaDmZ7YWbRLiAOFU', '2018-05-05 06:42:50', '2018-05-05 06:42:50'),
(284, 1, 'qwIS4yKlNwwFYQ9LtnfOxr9SgaViNwri', '2018-05-05 07:50:28', '2018-05-05 07:50:28'),
(285, 1, 'GdYoNJWuBITuwQ6XmsN6cOr9onREqVPK', '2018-05-06 23:53:43', '2018-05-06 23:53:43'),
(286, 1, 'tAmc5qsjtITkmE7uhYW8jZ0iMq3DDMPk', '2018-05-07 00:20:53', '2018-05-07 00:20:53'),
(287, 1, 'CxUzZafoVm4sy4rkChs6ixGfUIXb4hnY', '2018-05-07 00:28:54', '2018-05-07 00:28:54'),
(288, 1, 'pcW0SGxboIPniajjlAJpWXH3NIolTHtL', '2018-05-07 03:29:01', '2018-05-07 03:29:01'),
(289, 1, 'cigpVnKTLMJq4Zr73gwtanhQgZXF1nJz', '2018-05-07 03:40:54', '2018-05-07 03:40:54'),
(290, 1, 'ljiDLajz5b5UegqHdLb347OQSzARo5WC', '2018-05-07 22:43:21', '2018-05-07 22:43:21'),
(291, 1, 'kLLQ8pWgAdzpmjrBjeXZpEqymw7txmZA', '2018-05-07 22:49:33', '2018-05-07 22:49:33'),
(292, 1, 'PdTvVHL1P6rEewUC76NKU9O0aYyeiLIW', '2018-05-07 22:52:37', '2018-05-07 22:52:37'),
(293, 1, 'CDcixVgNKI3UF8uCBl2i6yt3hhbhzR8R', '2018-05-08 00:14:01', '2018-05-08 00:14:01'),
(294, 1, 'yePD0haKAZhxFg67z7oQJyCXExgnfAYa', '2018-05-08 01:51:22', '2018-05-08 01:51:22'),
(295, 1, '8ZKQU0YdD06OIj9DDUJHYz04iMUr6g3d', '2018-05-08 04:29:33', '2018-05-08 04:29:33'),
(296, 1, 'rdbKw7goSDgJ3HeSboAxdWOmIEOMFZhq', '2018-05-08 05:50:46', '2018-05-08 05:50:46'),
(297, 1, '4gdoTvTxZV7h86kdKFR7qbmdX924u1Dl', '2018-05-08 07:49:04', '2018-05-08 07:49:04'),
(298, 1, 'CHh658lSqJTEKadFsauImJsLjoKAQ0uk', '2018-05-08 08:23:56', '2018-05-08 08:23:56'),
(299, 1, '4bL5GQ3NpOxAekp0voWsUPlbasdvndqg', '2018-05-08 08:30:08', '2018-05-08 08:30:08'),
(300, 1, 'kX06PswygNDa80POBRgDnyK1LrEeWjpp', '2018-05-09 00:33:33', '2018-05-09 00:33:33'),
(301, 1, 'bdYOaPcVZhtUNkni0ZCvOtI2ElWZ4WmS', '2018-05-09 03:49:47', '2018-05-09 03:49:47'),
(302, 1, '9YCpEzbnTxxYgHYsEFCCJ8drektmRvHU', '2018-05-09 04:54:44', '2018-05-09 04:54:44'),
(303, 1, '1RtuC1DKZtEyxkEw2E19ds4zy1WuqKcp', '2018-05-09 07:51:12', '2018-05-09 07:51:12'),
(304, 1, 'e3VS2kLFzhzJ8hZaLrPrtKuojEaNjuWR', '2018-05-10 00:09:58', '2018-05-10 00:09:58'),
(305, 1, 'Epr1HWr4QxtG7hos7sauye6Ubo6CJI6h', '2018-05-10 00:35:59', '2018-05-10 00:35:59'),
(306, 1, 'SOBl3zBEo1uhEaxEduAS11sVy5sTN3tg', '2018-05-10 00:43:55', '2018-05-10 00:43:55'),
(307, 1, 'cTNcHhdiEjGHEPehy5bArthuQXlc3mSY', '2018-05-10 06:43:55', '2018-05-10 06:43:55'),
(308, 1, 'RjQUKv3KBGy46D4rLSNghubcLUHPhDtZ', '2018-05-10 07:33:18', '2018-05-10 07:33:18'),
(309, 1, 'aBnagmWiZBKYtoIfCsUKadxGaysB4lRl', '2018-05-14 05:04:03', '2018-05-14 05:04:03'),
(310, 1, 'OCOyqcikzKFzamBv4YxijjPfFatI0msc', '2018-05-14 05:54:30', '2018-05-14 05:54:30'),
(311, 1, 'XL0NbO2woxvX17br6SpVKQt7bn2reqOn', '2018-05-14 08:34:30', '2018-05-14 08:34:30'),
(312, 1, 'PXBevDSbXsdPitDHp2RoIe9QN5I3qmgp', '2018-05-14 22:41:04', '2018-05-14 22:41:04'),
(313, 1, 'ES9nL3XYCyjX0Rk1McZQazxY09cEbZMR', '2018-05-15 05:12:38', '2018-05-15 05:12:38'),
(315, 1, 'rIbE7RvUBGvErWhcjkCzYbXv4RKPjdy0', '2018-05-16 07:05:35', '2018-05-16 07:05:35'),
(316, 1, 'nATZOzzeCmKJMmwerc37p0gsgCJUHTgc', '2018-05-16 22:58:58', '2018-05-16 22:58:58'),
(318, 1, 'jVVdPHoeyai5DpLxz7iY8qLDDFanlWep', '2018-05-17 04:16:44', '2018-05-17 04:16:44'),
(319, 1, '1s1pUHZfaVtaEgQg3wVhUkmggHCyNM60', '2018-05-18 05:47:00', '2018-05-18 05:47:00'),
(321, 1, 'SJhuN2CNcBaipxeBEqNcqznByKge8pPV', '2018-05-19 08:30:38', '2018-05-19 08:30:38'),
(322, 1, 'thKW39Ltk8p4rSPIcB21Badtf35dXbu3', '2018-05-21 00:12:48', '2018-05-21 00:12:48'),
(323, 1, 'HB7Tt6Ha0kwyTWhUzfdamWfJLnsONzM8', '2018-05-23 00:06:44', '2018-05-23 00:06:44'),
(324, 1, 'kMWC0yroqqLXbB5a9zKhose8XEXYKrEq', '2018-05-23 06:38:02', '2018-05-23 06:38:02'),
(325, 1, 'hxnDaHIvMASpc3Tg9pU1n6fvanDUB9u3', '2018-05-23 06:53:20', '2018-05-23 06:53:20'),
(326, 1, 'x3nkkmmwO3Ta6RicTS8HZzDlIVsbVpuA', '2018-05-24 04:55:58', '2018-05-24 04:55:58'),
(327, 1, '21F2vXZvUOXGWUmZH5DgiF2WOoShsDFC', '2018-05-24 04:56:05', '2018-05-24 04:56:05'),
(328, 1, 'az3R2mp52whZJBjf5eXrLPmfschFvcnd', '2018-05-24 04:56:21', '2018-05-24 04:56:21'),
(329, 1, 'II8mIBLvJZU7oFrejdm0uQ8AM2QkS63P', '2018-05-24 22:56:13', '2018-05-24 22:56:13'),
(330, 1, 'npgkZN4bjLgaCi1D0fmdij7JxjducXRq', '2018-05-27 22:54:36', '2018-05-27 22:54:36'),
(333, 1, 'vL4GtnxbGANL4zrpv6nMZNKFwmrIs2wl', '2018-05-28 05:32:54', '2018-05-28 05:32:54'),
(334, 1, 'HmXBJp1JCgpInw9AerbOeLYqUnewgTHi', '2018-06-01 06:08:29', '2018-06-01 06:08:29'),
(335, 1, '9ZP9DJgK0pYh6zaeKT5zmljzvL69Iyi7', '2018-06-07 23:33:56', '2018-06-07 23:33:56'),
(336, 1, '8BD4jyFav0WfQyUESglmQ2L1iwthI6LM', '2018-06-08 01:48:11', '2018-06-08 01:48:11'),
(337, 1, 'iHNpTbkjqFhPhu4nvl0LxBdy1MjlN7oD', '2018-06-11 00:36:41', '2018-06-11 00:36:41'),
(338, 1, 'W7DJyiuHuF6MaAQ5COycvRXxmqqxsnbt', '2018-06-12 00:17:40', '2018-06-12 00:17:40'),
(339, 1, 'pkkto0YHGYFzcSA4rqc7pE0UjFMl29zn', '2018-06-12 07:47:11', '2018-06-12 07:47:11'),
(340, 1, 'kjdBOdmAVsknE2pGIvQbvmw3IYmEKdaZ', '2018-06-13 06:09:54', '2018-06-13 06:09:54'),
(341, 1, 'hKV2eN0ZlWoIfLqkQ0VRpzo8f2X9C0Pg', '2018-07-03 06:15:50', '2018-07-03 06:15:50'),
(342, 1, 'HT5U9sgJ50foShLRFLVuRzqdpddw7FBF', '2018-07-04 23:24:45', '2018-07-04 23:24:45'),
(343, 1, 'YMfwJSns8A24CmmI4W9QkazKvGrLYfwy', '2018-07-07 00:09:20', '2018-07-07 00:09:20'),
(345, 1, 'EvMJHxZ7GZc1lUJxFbQiTi7mSUX90dyu', '2018-07-11 04:15:38', '2018-07-11 04:15:38'),
(346, 1, 'f2j0yFXDm3ipHymKsppZCK18L364LXCp', '2018-08-02 04:28:37', '2018-08-02 04:28:37'),
(347, 1, 'KavW7n27AOeQecALAy5FEEzHomDQ7L0y', '2018-08-13 04:09:04', '2018-08-13 04:09:04'),
(348, 1, 'udcgxoKdUGp59kC1dH82DPqC9tqilFua', '2018-08-13 04:18:33', '2018-08-13 04:18:33'),
(349, 1, 'ez1ma4v7x7vDlgc6XFsalnW2jIHcIScA', '2018-08-13 04:26:12', '2018-08-13 04:26:12'),
(350, 1, 'uyWfqnTYBx9ZYbnuqqcZVQPAnZaefhbd', '2018-08-13 04:42:34', '2018-08-13 04:42:34'),
(351, 1, 'IJlVs8qMzvukShVCSxI3zdZX9MKa34y3', '2018-10-22 03:49:06', '2018-10-22 03:49:06'),
(353, 1, 'lFQZHEvY0ObKsbWSowzvyCFtCACmBIjB', '2019-01-18 23:58:53', '2019-01-18 23:58:53'),
(354, 1, '3SLS1b1eMjlEvGdz4zPAGHBQIEeQ9BGH', '2019-01-19 00:07:46', '2019-01-19 00:07:46'),
(355, 1, 'QZUPySRQ4mus1JlElshdVLjfjWwhHfz8', '2019-01-19 05:37:18', '2019-01-19 05:37:18'),
(356, 1, 'yP57X31Hn3aJkAO5TrxaurtkZPUI0wmA', '2019-01-20 21:58:12', '2019-01-20 21:58:12'),
(357, 1, 'MWKmtzoAKpU93cNzKqyb90ZPENpCRmGS', '2019-01-20 23:42:02', '2019-01-20 23:42:02'),
(358, 1, '2TIHBiM0KQPpFXCWUH4JsWL8du6zHEd0', '2019-01-22 04:08:09', '2019-01-22 04:08:09'),
(359, 1, 'C9CH9Bi9Ub5iPVOPZXkUKDQkpkO8GejK', '2019-01-22 22:05:24', '2019-01-22 22:05:24'),
(360, 1, 'acLpTgZbai44cHLOpCyT3BFPYaZKjFax', '2019-02-14 06:34:51', '2019-02-14 06:34:51'),
(361, 1, 'QDdyq0k7PDZiKjvKqovHte6cwtNYCECW', '2019-02-14 07:11:00', '2019-02-14 07:11:00'),
(362, 1, 'hpG3SnjB7HaGKVcj6UL5YQXSLkXSEY7E', '2019-02-14 22:46:14', '2019-02-14 22:46:14'),
(363, 1, 'EVKljgvc62ZAnvB9oIxFtL1NXJYsF1vT', '2019-02-14 23:30:46', '2019-02-14 23:30:46'),
(364, 1, 'wgZQKi9ppmHjjAV9TPBJxcrWAQUh0vc7', '2019-02-15 00:51:36', '2019-02-15 00:51:36'),
(365, 1, 'u98qtWwEjMU6d1aqYeF7Tvks0M5SCgZN', '2019-02-15 00:54:23', '2019-02-15 00:54:23'),
(366, 1, '095bMxVaLEez1biybDkhSPqY4LvKDQRH', '2019-02-15 01:05:52', '2019-02-15 01:05:52'),
(367, 1, 'f0Ks4tWOgrJnKhq1B9gCof3ySd2a49Wp', '2019-02-15 03:42:51', '2019-02-15 03:42:51'),
(368, 1, 'nbqL4J7vLlv5BIXdWrXW0yaKCQw0DvaQ', '2019-02-15 22:16:04', '2019-02-15 22:16:04'),
(369, 1, 'mImbVQJ77Ln01DKQms09ZBNY8l7EC7zu', '2019-02-15 22:24:49', '2019-02-15 22:24:49'),
(370, 1, '4ExS0eKAEaFcNyQfOAnjNyrV4UHupggU', '2019-02-16 01:08:19', '2019-02-16 01:08:19'),
(371, 1, '4i0ewztKGdUgbQ7vgsFI2WUPBuVzyZp9', '2019-02-16 04:16:40', '2019-02-16 04:16:40'),
(373, 1, 'fOrZmViCtWEKHcwH8wrKDgwVezjJf30p', '2019-02-16 09:53:28', '2019-02-16 09:53:28'),
(374, 1, '1gxxmHgqknTf3OGYJBzI9woTC64aRzLZ', '2019-02-17 22:15:08', '2019-02-17 22:15:08'),
(375, 1, 'U2Mgx50FhWZtPEwYjROqFVnmGyBCEsQW', '2019-02-17 22:21:14', '2019-02-17 22:21:14'),
(376, 1, 'as4RbEiBlVWwdYPnzW7Xe6HNF80uTaIg', '2019-02-18 00:15:39', '2019-02-18 00:15:39'),
(377, 1, 'JbRZzaw7UGSnLRmVNn7wXw9uCNLwHoMA', '2019-02-18 00:15:56', '2019-02-18 00:15:56'),
(378, 1, '9tvjEITKJeOEb1zwG4R1IiErb3tqqe20', '2019-02-18 00:56:29', '2019-02-18 00:56:29'),
(379, 1, 'kmxTEygNzt2Yh8RBfqkSz0zRo0oDlhxb', '2019-02-18 23:37:31', '2019-02-18 23:37:31'),
(380, 1, 'JdjVrh7g6o4PrIAivV4FizHri44v3sID', '2019-02-19 04:12:10', '2019-02-19 04:12:10'),
(381, 1, 'hsnvBtLO6dXeqZw7gYAdepK04bxP9Nc9', '2019-02-19 23:02:36', '2019-02-19 23:02:36'),
(382, 1, 'm92ru17GAvQFMwVH9CZJJXpRhpijlEID', '2019-02-20 22:58:24', '2019-02-20 22:58:24'),
(388, 1, 'Xngs7FLf2bMV5NRk2boWn8PaaiGUBvCd', '2019-02-21 04:43:29', '2019-02-21 04:43:29'),
(389, 1, 'jOnMSdU87g4DGRbQwzhPmBqBs10foWgN', '2019-02-21 05:13:08', '2019-02-21 05:13:08'),
(390, 1, 'CLMiBqFv6QYq0BZQnWhWfIliqc9rcj78', '2019-02-21 07:07:05', '2019-02-21 07:07:05'),
(391, 1, 'hkYCeRMK2RekWWI4VuYzgbr2FHhsLGX3', '2019-02-21 07:07:08', '2019-02-21 07:07:08'),
(392, 1, 'UCLElSvFZXqXPAS0xM5Soa6iTa2oGVA5', '2019-02-21 07:07:22', '2019-02-21 07:07:22'),
(393, 1, 'QVPoyFnpPHnaXuJWbViakK8bNRBPYvTj', '2019-02-21 07:10:25', '2019-02-21 07:10:25'),
(394, 1, '6Tp7pjeI4Ixl4sXahoQ1SADkXlM1PQFI', '2019-02-21 07:10:37', '2019-02-21 07:10:37'),
(395, 1, 'X17DMeYeAHIdB5cjomWGsyY1Wnj3Buim', '2019-02-21 07:10:58', '2019-02-21 07:10:58'),
(396, 1, 'OX0GRCE3zTpsvVXWjFusCt93JCYv69xa', '2019-02-21 07:11:04', '2019-02-21 07:11:04'),
(397, 1, 'yfR0kVgOn6Sq1kMaXLde5bS7AGpQdJ0f', '2019-02-21 07:11:08', '2019-02-21 07:11:08'),
(398, 1, 'fjEdPTZzZLSMWmHt1PekloZJKVCDM41i', '2019-02-21 07:11:09', '2019-02-21 07:11:09'),
(399, 1, 'L8uKZg8VwAWdiAqv6xZkcTHXz3Nz1DMn', '2019-02-21 07:11:20', '2019-02-21 07:11:20'),
(400, 1, 'oxOuDUsPkEAx9yRvfaCn3juPoeBuyhsJ', '2019-02-21 07:17:09', '2019-02-21 07:17:09'),
(401, 1, 'Z0IMUIM7YYtopDPTh9EPW30ZNWTPAVK6', '2019-02-21 07:17:14', '2019-02-21 07:17:14'),
(402, 1, 'IvTUWKcfIAKji9AvF65wbGJQEyvRYEtl', '2019-02-21 07:17:17', '2019-02-21 07:17:17'),
(403, 1, 'Q3F8w73ya3ktjFosyDMXxtu5M7qt1wVX', '2019-02-21 07:21:45', '2019-02-21 07:21:45'),
(404, 1, 'JNzb5IGzeDe08c5zIcp0jhza09DM0UUj', '2019-02-21 07:25:09', '2019-02-21 07:25:09'),
(405, 1, 'tnHvSGY5BUGntF9SveAdSgmbPEro0yxo', '2019-02-21 07:25:30', '2019-02-21 07:25:30'),
(406, 1, 'TodOTfirdov11VXMRQQQLAWHAtfU5gr3', '2019-02-21 07:26:16', '2019-02-21 07:26:16'),
(407, 124, 'uhngTtxN9wjAi0IeMSN90w4NXBuwFvAU', '2019-02-21 07:26:40', '2019-02-21 07:26:40'),
(408, 124, 'f2sgccC6bzTNr9CuyCtrkrdiw8IW2coe', '2019-02-21 07:26:41', '2019-02-21 07:26:41'),
(409, 124, 'OST7OsfkzzsrdXtwoiT9ArS3BYIllPIT', '2019-02-21 07:33:29', '2019-02-21 07:33:29'),
(410, 124, 'mRizHetdQwlH9CKZh5CiUWQlQLDSd1EB', '2019-02-21 07:36:45', '2019-02-21 07:36:45'),
(411, 124, '4LNNW7DOQXpXVQNeInnTs6D6i1SLiwPW', '2019-02-21 07:36:54', '2019-02-21 07:36:54'),
(412, 124, 'BeTwOLntvHCyl9iDjHhpMHHYyzwtvd8X', '2019-02-21 07:37:00', '2019-02-21 07:37:00'),
(413, 124, 'CqVuWhGkZBwHtVnEYPd93zQGnvcfh1Ww', '2019-02-21 07:38:19', '2019-02-21 07:38:19'),
(414, 1, 'CssGWyi27bAzPfoqIhQP9kgD9Zuu1Tv1', '2019-02-21 07:40:27', '2019-02-21 07:40:27'),
(415, 1, '3mn6UqjOCApXEYA6M4SiyO8zox54DoNy', '2019-02-21 07:40:35', '2019-02-21 07:40:35'),
(416, 1, 'BK0F7cQRWjanazg4RpovRJPrUdrvjKHF', '2019-02-21 07:42:06', '2019-02-21 07:42:06'),
(417, 1, '40hY2kQrhyw7fpCjJNAc4SrRULKmaFyo', '2019-02-21 07:42:41', '2019-02-21 07:42:41'),
(418, 1, 'ItS2ywbk5qZy3f5Md0Tsm7Kl68QMNDBL', '2019-02-21 07:44:17', '2019-02-21 07:44:17'),
(419, 124, 'ItNC8AYfj3n1K3FtGey0rbT3bspqPw1F', '2019-02-21 07:44:23', '2019-02-21 07:44:23'),
(420, 124, '7JtVf35dKFngLdof5txqSKpHZZuPtJc4', '2019-02-21 07:45:28', '2019-02-21 07:45:28'),
(421, 1, 'LME1DWJGWhKvbzfIoOaXXYvatWA8LvTX', '2019-02-21 07:50:48', '2019-02-21 07:50:48'),
(422, 124, 'ffbZ3huK8e5g45Bv0va81NtykRqSx1Bd', '2019-02-21 07:51:04', '2019-02-21 07:51:04'),
(423, 1, 'uB2ar9Dz2JM3kDQ7xdx9Q4y6FmEkNrHE', '2019-02-21 07:54:31', '2019-02-21 07:54:31'),
(424, 124, '9mADccH85p6QTVS0FZ8Azsh7EtY8IWtX', '2019-02-21 07:54:44', '2019-02-21 07:54:44'),
(425, 1, 'vN5HHFocGeRicHN569izST048smvWZc7', '2019-02-22 03:24:53', '2019-02-22 03:24:53'),
(426, 129, '0HMVcCjKhpDSsxaXILcvoMjLGZkNoFEi', '2019-02-22 03:26:11', '2019-02-22 03:26:11'),
(427, 129, 'lqtTlsNdLVoN357I5MR2M6trvZVUOM1U', '2019-02-22 03:31:19', '2019-02-22 03:31:19'),
(428, 130, 'Rg8k9Nfb5kvvtvFN4kpSn7zeuHxkDS7H', '2019-02-22 04:26:06', '2019-02-22 04:26:06'),
(429, 129, 'tiNVz5N6fGGIwivAXypkMhIqtgjZRDyf', '2019-02-22 04:37:44', '2019-02-22 04:37:44'),
(431, 130, '1j4lcReoFgKiFd5cORYdNGzAcJUrcdlj', '2019-02-22 04:55:19', '2019-02-22 04:55:19'),
(432, 130, 'VvKUPqwaJq1FkHPC19rN2npaRmK5kZ0w', '2019-02-22 04:55:34', '2019-02-22 04:55:34'),
(433, 130, 'jZjbL9yvJrGrGAD8aZPxBQRmY9u0BvHZ', '2019-02-22 04:56:09', '2019-02-22 04:56:09'),
(434, 130, 'lTtXvZdyR2msK952oKHXT9kADfdUqFvm', '2019-02-22 04:56:50', '2019-02-22 04:56:50'),
(435, 130, 'TAgK0TqMbBSH9eUi0Hibjrkqd5gsMdSH', '2019-02-22 04:58:01', '2019-02-22 04:58:01'),
(436, 130, '8EM6Tz3EAFYX3n4V2aOQx7P3tCxzPGFN', '2019-02-22 04:59:28', '2019-02-22 04:59:28'),
(437, 130, 'BApIjzezQER243QztmMoMQshgOyVgogO', '2019-02-22 04:59:46', '2019-02-22 04:59:46'),
(438, 1, 'YDlZ9lTpgbNBzI0Id4w9ZYdqOsANiXG7', '2019-02-22 05:17:24', '2019-02-22 05:17:24'),
(439, 130, '7Xkv2s0YTbaeUxSdtMKpuOiJmKSKSifr', '2019-02-22 05:20:57', '2019-02-22 05:20:57'),
(440, 131, '4NY2IBx4EHIWgPbf1dNbz5rSoqPMhChw', '2019-02-22 05:22:13', '2019-02-22 05:22:13'),
(443, 129, 'ds2t4CNtLLrKvx3GfwLRmivT2ynmc1NC', '2019-02-22 05:37:36', '2019-02-22 05:37:36'),
(444, 131, 'MtOAG1UEFijSDHpyHwgQ9FYHMMfXtBtZ', '2019-02-22 06:05:05', '2019-02-22 06:05:05'),
(445, 131, 'pmeLsFtPl8l3ZZqMP7gwrJyRU3R8QsyC', '2019-02-22 06:14:27', '2019-02-22 06:14:27'),
(446, 131, 'JYfq6x9jJDx7qD3J1AfBLAAn53q5n2Sw', '2019-02-22 06:21:24', '2019-02-22 06:21:24'),
(448, 132, '9cn4hkOfcyWeNETPORkS9qQortxYlOc6', '2019-02-22 06:58:25', '2019-02-22 06:58:25'),
(453, 1, 'PWCXphjWvpQdM8zR8pup0FJuaQhTqwRA', '2019-02-24 23:30:53', '2019-02-24 23:30:53'),
(454, 141, 'SnhasPmLJdFo6PZsVr2PBAKgnJaM7d3Y', '2019-02-25 00:49:03', '2019-02-25 00:49:03'),
(455, 1, 'vsV470iB8yY646MkWazBh2gSxcPwTc0s', '2019-02-25 00:58:06', '2019-02-25 00:58:06'),
(456, 1, 'dBeQ3ofYSjtt2PyAtPCxpW04mVG9ZD3L', '2019-02-25 00:59:44', '2019-02-25 00:59:44'),
(464, 4, '4QNirqHHTdC5MWLfqoNEbMQT94HoPy9u', '2019-02-25 03:49:11', '2019-02-25 03:49:11'),
(466, 1, 'raE5mTheB3aixp5LyzhZpHS5DVb3e7FC', '2019-02-25 22:20:10', '2019-02-25 22:20:10'),
(467, 6, 'WDmtauKPDhnZcvPDnuJI7uNleLKxk33h', '2019-02-25 22:22:21', '2019-02-25 22:22:21'),
(471, 1, 'Uf0KMu0n9NcUpa9jctCKGF00mvuya3Xo', '2019-02-26 01:51:36', '2019-02-26 01:51:36'),
(482, 2, 'ap0zwDzqVCOsrZ3AoH4cIQTxliwcb3jq', '2019-02-26 06:18:48', '2019-02-26 06:18:48'),
(483, 1, 'PGdZNJVfpxePoXMutMM3lnJcgQanubf9', '2019-02-26 07:15:32', '2019-02-26 07:15:32'),
(484, 2, 'rHTL4pQv85HIhwiJIgW8UmPd8qVHTcgh', '2019-02-26 23:07:01', '2019-02-26 23:07:01'),
(486, 1, 'T0aTcDHImOMiQEwMcVdPA1c2IQ2ZUGDY', '2019-02-27 00:40:54', '2019-02-27 00:40:54'),
(487, 1, 'mutkLkL31HwDVEV3O9kUxo4ZKF1ygGKR', '2019-02-27 03:36:37', '2019-02-27 03:36:37'),
(504, 6, 'tpE2tQUiYp6mpqe9upqR22ryw85m4OQT', '2019-02-28 04:45:25', '2019-02-28 04:45:25'),
(509, 6, 'IU5LGDlY4P44O55lsObB77NTs1vBRlFJ', '2019-02-28 05:58:35', '2019-02-28 05:58:35'),
(510, 2, '2A5cDtrCk0hCIkP5hkpZTt4E9Ds9d2d1', '2019-02-28 06:00:27', '2019-02-28 06:00:27'),
(523, 2, 'bR9LLcP2Y9ZE21KlBOKDUSBeyJXnGKCL', '2019-03-01 06:32:24', '2019-03-01 06:32:24'),
(524, 2, '4RiMUWfTiIbli3RQzb0lWLPocrZLHkGU', '2019-03-01 06:32:44', '2019-03-01 06:32:44'),
(525, 1, 'ptb7Yp4tocLBwvAQtGu4yNyKXTPren66', '2019-03-01 06:33:51', '2019-03-01 06:33:51'),
(526, 1, 'Z8GP9SAIoodvis4mhtdfW0pGwobbAvCj', '2019-03-01 06:34:23', '2019-03-01 06:34:23'),
(533, 1, 'P1CIbPwLBKclkIDXkHrprzGcTinBNSxD', '2019-03-02 05:38:04', '2019-03-02 05:38:04'),
(535, 1, '6pUeqBFGIAkjMYc7PtbIZOMrHpFKuVpI', '2019-03-03 23:58:20', '2019-03-03 23:58:20'),
(536, 2, 'hgUjVCZjoApKRGDv7oJUvlbThyOjuOrq', '2019-03-04 00:34:26', '2019-03-04 00:34:26'),
(537, 1, 'ffS3pOtyh6xc4JbRCbnwEFOEKQTK9dLI', '2019-03-04 00:39:43', '2019-03-04 00:39:43'),
(546, 1, 'Itrfe0oRNNo1ZSkuhKjpJ7pVPBvgIE4n', '2019-03-04 04:38:13', '2019-03-04 04:38:13'),
(556, 2, 'ln7neYC2cv2OUifhWDjMrAqOWRX8Pgky', '2019-03-05 01:38:50', '2019-03-05 01:38:50'),
(559, 1, 'f1KLiU3XoaAYtyQ1uZaL31u1d5U9XnDI', '2019-03-05 04:08:56', '2019-03-05 04:08:56'),
(560, 1, '4Dfj6qc5tGx3c3SlYq81C8Tx1XvSOneX', '2019-03-05 06:30:56', '2019-03-05 06:30:56'),
(563, 2, '8GfsNYtemXxpwejVyW35cgZf2P5cetL1', '2019-03-05 23:12:22', '2019-03-05 23:12:22'),
(573, 1, 'AwA3jB7WG3Ynk8QX4TpN36cvXzHlQeGu', '2019-03-05 23:50:24', '2019-03-05 23:50:24'),
(574, 2, 'SBJkT8c1ARVDRyLsuMt8vE4eoalA6j51', '2019-03-06 00:21:28', '2019-03-06 00:21:28'),
(575, 1, 'gaGVWRaV3YeNhlg0v8WAqmX2UmwVsSs9', '2019-03-06 00:21:41', '2019-03-06 00:21:41'),
(578, 2, 'vt6E3T6F8FZtD9huCKX0lIDgzLok2mkd', '2019-03-06 00:51:15', '2019-03-06 00:51:15'),
(579, 4, 'bgOFJGpNeWRqwfjrDlRXr4tB0Ce794kB', '2019-03-06 01:32:33', '2019-03-06 01:32:33'),
(580, 1, '7yG2VIzZotsfQRSQe8crmejMe8PQcaja', '2019-03-06 02:03:30', '2019-03-06 02:03:30'),
(581, 7, 'KJHMpeGaxfnDjY8XZMII5pNVR8kUgdK3', '2019-03-06 02:06:18', '2019-03-06 02:06:18'),
(582, 4, 'N9I9rK7s8zU0DFh1q85tm2ZL2BORGA8b', '2019-03-06 04:33:29', '2019-03-06 04:33:29'),
(583, 7, 'UzQnBUtAhiYlOSIBlX38aTbQNV4uOTeG', '2019-03-06 04:33:37', '2019-03-06 04:33:37'),
(584, 7, 'h18SRO35vFuC5ZGVPPIYxWEOneWscBNe', '2019-03-06 04:50:33', '2019-03-06 04:50:33'),
(585, 4, 'P7OLFte2Qr0GirwaeXABhBEJHiHsb642', '2019-03-06 05:51:04', '2019-03-06 05:51:04'),
(586, 1, 'V45vlFdpyMjHYouSDweJyuSjhF1u1XmN', '2019-03-06 05:56:34', '2019-03-06 05:56:34'),
(594, 6, 'cGn6HkQA8ZR4OF0zs6owMUfPNar0x4Kg', '2019-03-07 00:33:21', '2019-03-07 00:33:21'),
(595, 1, 'tuWbWS8u1rhRrKpj4ESuh8qGwzhc1ZdJ', '2019-03-07 00:33:31', '2019-03-07 00:33:31'),
(596, 6, 'KnMaAvnHGKLptFpDmT8wZOIMqpiEWXvC', '2019-03-07 00:45:22', '2019-03-07 00:45:22'),
(602, 6, 'NuG1K4aepE57ynLNpJkZPWXUTFIwtTj2', '2019-03-07 03:39:23', '2019-03-07 03:39:23'),
(610, 1, 'Hofg2opYw7Xw2hW7fsEq2kOFAJZ0u7UW', '2019-03-07 06:41:54', '2019-03-07 06:41:54'),
(611, 6, '1h736VkmWLK9L744KVCo9CZpxEUsXKfb', '2019-03-07 06:55:39', '2019-03-07 06:55:39'),
(612, 1, 'IrR8Ogj873dXnd1w9T7GJW3NtDDipoTa', '2019-03-07 07:35:54', '2019-03-07 07:35:54'),
(613, 1, 'K8YlkaUFWLx6xG4POfEAIGTTJRbzRufp', '2019-03-07 07:36:21', '2019-03-07 07:36:21'),
(614, 1, 'OUlsXXWnHzvOLUiivOM0hfSQj5yZNjis', '2019-03-07 23:54:05', '2019-03-07 23:54:05'),
(616, 6, 'wL3xudpVdx2NeINizPKGSSWIosNlv0mS', '2019-03-08 02:05:41', '2019-03-08 02:05:41'),
(621, 6, '4kIYzkKIme3oL61QAZ92Xt4fg5tkruJu', '2019-03-08 06:20:35', '2019-03-08 06:20:35'),
(622, 1, 'vhF2xY6yQvsIBPDTPQ6fXGCTD3yEvcrJ', '2019-03-09 03:56:42', '2019-03-09 03:56:42'),
(626, 1, 'hKiRttib56Xt65QjXYHsJ6sTAg7BlLXf', '2019-03-09 06:47:05', '2019-03-09 06:47:05'),
(637, 22, 'eMutLFFSB3wCxFoDl7TbjsDVo0iRxXzR', '2019-03-11 07:30:39', '2019-03-11 07:30:39'),
(639, 22, 'hjULcqBCJb23Qk0EH4O9IAm6tha2mjpP', '2019-03-11 07:31:32', '2019-03-11 07:31:32'),
(641, 22, 'JJd5xbZs20epCtd6hkgThLSFHNpsMLkx', '2019-03-11 07:32:59', '2019-03-11 07:32:59'),
(648, 2, 'DKkqwTLVK2EPZFbpcgkfiuH49oQ0yWPz', '2019-03-11 07:53:25', '2019-03-11 07:53:25'),
(655, 1, 'aWv6DjBRJjGSGjgwX2JGuBecu5bAUTu1', '2019-03-12 01:08:55', '2019-03-12 01:08:55'),
(656, 1, 'rukjRHFl0N9CzX02OfO9TtLUzFM22n6J', '2019-03-13 00:53:34', '2019-03-13 00:53:34'),
(657, 1, '44OB0iAEq0GA6TvKn3bguw85aUNKgKkp', '2019-03-13 00:57:45', '2019-03-13 00:57:45'),
(664, 22, 'QjjZ89jV0xu4JBv2lNxvnsnCZAXwaBrj', '2019-03-13 05:32:59', '2019-03-13 05:32:59'),
(665, 1, 'RiEkMLfsoNIdXiTkyry1LkVgQrmM8nUC', '2019-03-15 00:03:26', '2019-03-15 00:03:26'),
(668, 22, 'pzfi1qTqLdCwKbCWvnHyEXXVn9dtiSy1', '2019-03-15 00:41:21', '2019-03-15 00:41:21'),
(671, 1, 'zYyzIXSLnc6S1ina9dsxsbj1TKT6yvJg', '2019-03-15 00:49:04', '2019-03-15 00:49:04'),
(692, 2, 'GZRZna8FflDbzjoPiv9nC7lGpek7ZQrP', '2019-03-16 00:13:48', '2019-03-16 00:13:48'),
(695, 1, '52oKmLyg6awLlC02Prso42TorVfcjPz4', '2019-03-17 23:25:27', '2019-03-17 23:25:27'),
(700, 1, 'rAjmVgmTQMbGmGIYM5Q0QOXwbFUMKds0', '2019-03-18 01:34:31', '2019-03-18 01:34:31'),
(707, 1, 'zMZU0mkndG3OZfL0J6MDEbKfJkFuDpJU', '2019-03-18 22:17:45', '2019-03-18 22:17:45'),
(708, 1, 'EH0itYGm3bdZlKewYwguy4WpXLkjHSNm', '2019-03-18 22:34:22', '2019-03-18 22:34:22'),
(709, 1, 'M5gb6C5fbsmPxrLnYQ42p9PAUhy7kIyZ', '2019-03-18 22:35:21', '2019-03-18 22:35:21'),
(720, 22, 'xig0C8ljz96NcXatIFLKgrRJpmV2h6fu', '2019-03-19 04:09:11', '2019-03-19 04:09:11'),
(721, 4, 'DwjDI5P19fmPFYxxDxM3HQVx1iZVKGXM', '2019-03-19 04:39:51', '2019-03-19 04:39:51'),
(725, 22, 'pFtu4e0Uta5FbH7C83KTddquuhVmIVap', '2019-03-19 04:53:53', '2019-03-19 04:53:53'),
(727, 1, 'qwNy13cKZEsjTe4sSR5bggyUguukXnPc', '2019-03-19 05:03:08', '2019-03-19 05:03:08'),
(754, 4, 'QHjNrd0XV3uf81rowHHsC8Rkteg98M5Z', '2019-03-19 07:52:33', '2019-03-19 07:52:33'),
(768, 1, '4j6lA5vaVXfGkRKYricq7NiTF9T3ciFr', '2019-03-19 08:32:41', '2019-03-19 08:32:41'),
(769, 22, 'YS4xJqAI1k7vbiUJuIVJWsmS9GD1HyTy', '2019-03-19 08:33:38', '2019-03-19 08:33:38'),
(786, 1, 'HYG8JvxOcXp5nSCipDCBx0IwdULxAhX8', '2019-03-20 00:37:42', '2019-03-20 00:37:42'),
(787, 4, 'r7RfHyLsUMIy4Zc4EGEtmWVn7A2gSGJU', '2019-03-20 04:37:08', '2019-03-20 04:37:08'),
(790, 4, '5bO22TPt4rXpIXg3sCOjfyvBXF4BVaSm', '2019-03-20 06:15:11', '2019-03-20 06:15:11'),
(792, 1, 'icRVgAAUcuJQ20gAMSsYnCN6oyR1VIFE', '2019-03-20 06:49:31', '2019-03-20 06:49:31'),
(803, 1, 'jkE99YgWETyqbqCDqhMLftz4kAPDCsBf', '2019-03-20 23:16:40', '2019-03-20 23:16:40'),
(805, 1, 'uaKL0yncZ5CKyp1GUHp04a7F4llCbu3X', '2019-03-20 23:44:24', '2019-03-20 23:44:24'),
(821, 22, '2PjCSxCPuu0K3VBBiJCfDzxu9uj55hFH', '2019-03-21 01:38:28', '2019-03-21 01:38:28'),
(827, 1, 'WuJu0hxm9w5uGe10f820QVzwMRakl0ry', '2019-03-21 01:56:04', '2019-03-21 01:56:04'),
(843, 22, 'wV8lDQg9f1NgBpIRM5l0fFT6SBK6Ju1j', '2019-03-21 03:41:35', '2019-03-21 03:41:35'),
(852, 4, '5pEAxbsMkrjbdhJz4pijCPRbobqOG0l8', '2019-03-21 05:27:33', '2019-03-21 05:27:33'),
(854, 4, 'BEgx9JIxPNwQXwmet8cff8IKx9hhV1Ps', '2019-03-21 05:28:30', '2019-03-21 05:28:30'),
(858, 1, '5lkBAZAmsdPlZlEWWYfrV3RVEGDBBsD7', '2019-03-21 05:30:47', '2019-03-21 05:30:47'),
(859, 1, 'QHFZqfFYPGtk13IBMoqwQyrQwhbzB6tK', '2019-03-21 05:30:47', '2019-03-21 05:30:47'),
(860, 1, 'hcvXTdiX8LbPuCelies4xf28YwNaZprg', '2019-03-21 05:30:48', '2019-03-21 05:30:48'),
(885, 1, 'm4nXQuwqQavEJpNqgM1rdby7okzfRxpw', '2019-03-21 06:45:02', '2019-03-21 06:45:02'),
(896, 22, 'GPk7w4FvPALCvehiY5oj9hCLiAx9rSKV', '2019-03-21 07:47:05', '2019-03-21 07:47:05'),
(898, 1, 'J5oHTvWHjCy9r9HbYwG4MLj0BvyR19BC', '2019-03-21 23:03:41', '2019-03-21 23:03:41'),
(899, 1, 'GwtW8Bs1IcedgctE9Juybcq55Ty79syc', '2019-03-21 23:36:27', '2019-03-21 23:36:27'),
(907, 1, 'tFi2wy0G11HXzm7DjEKuj6NSwZ6Ko7kF', '2019-03-22 00:50:28', '2019-03-22 00:50:28'),
(912, 4, 'KfBmunZ3AvnJtGH5q3j7iKvFcjvpyr2G', '2019-03-22 01:23:50', '2019-03-22 01:23:50'),
(919, 1, 'AHI5aLYjujoHhsQTojPCgBixYttg2aEq', '2019-03-22 04:50:05', '2019-03-22 04:50:05'),
(922, 24, 'fKeG5X8hgTt9DrlkBNBcRaORmQu5iIIG', '2019-03-22 04:57:15', '2019-03-22 04:57:15'),
(923, 22, 'egHdzS7ZkdsWXrjqgnbLxZvHMX0z3ZS7', '2019-03-22 04:57:58', '2019-03-22 04:57:58'),
(926, 22, '1HX5KGWgShBwqftbYmrfG401NwMaYO9u', '2019-03-22 05:00:02', '2019-03-22 05:00:02'),
(940, 22, 'AdJ7HrhxwMPuF8myrr0H2CUlHFDkUxub', '2019-03-22 06:01:09', '2019-03-22 06:01:09'),
(943, 1, 'RqKCCuXTXcT9hxnFuPuHBxl2L9rb5fXx', '2019-03-22 06:39:51', '2019-03-22 06:39:51'),
(948, 22, 'AYSzrgYfHeh5D82m8WZzdzlx3W1r4i3S', '2019-03-22 06:41:52', '2019-03-22 06:41:52'),
(949, 1, 'G3Y2LZF2FKIIxgCjYHERbSeBoaGYEPDu', '2019-03-22 07:40:21', '2019-03-22 07:40:21'),
(950, 4, 'pz70uzUWgYdQJu4qLM1PkedJRMg92JxR', '2019-03-22 07:54:48', '2019-03-22 07:54:48'),
(952, 1, 'Cx0dw5C5zGvFps4F3QgiUWHAHAuT65lv', '2019-03-22 08:48:56', '2019-03-22 08:48:56'),
(961, 22, '3aIz3c0W6DVzl1wQ3cNO4WwbSHfaQnFY', '2019-03-23 03:33:18', '2019-03-23 03:33:18'),
(962, 1, 'vJvoX0NxbhSWnLsntaIFvaSR1LIqmV8a', '2019-03-23 03:33:27', '2019-03-23 03:33:27'),
(963, 1, 'nRY6FRIFEKUupkqb4S0RL6HmULcCgxgA', '2019-03-23 03:47:08', '2019-03-23 03:47:08'),
(964, 1, 'ZlHhQKWqmNVSsLq53j195ZReZTheV14t', '2019-03-23 03:48:23', '2019-03-23 03:48:23'),
(968, 1, 'sWmf82CXlhO155Hvw1RNhohQdrb5nleo', '2019-03-23 05:02:07', '2019-03-23 05:02:07'),
(973, 22, 'EvCVWVB4AWs3e59WuOAovWRa2wb5ad38', '2019-03-23 06:55:01', '2019-03-23 06:55:01'),
(977, 1, 'ALt4hfmSzaZKdXfwA4Dta1xXTvN0NdcC', '2019-03-26 01:01:38', '2019-03-26 01:01:38'),
(980, 24, 'HBH7MYlGCuBQsyhyjRaiW77cMHjXAE7P', '2019-03-26 03:30:56', '2019-03-26 03:30:56'),
(992, 1, 'cGujwFiJUNaIFEPTvs3s8VV2Rb8oVBva', '2019-03-26 23:39:55', '2019-03-26 23:39:55'),
(995, 28, '3ihUewYGmvFXo3k4VOfGhHhzq4BTayU7', '2019-03-26 23:52:34', '2019-03-26 23:52:34'),
(996, 28, 'OUckCeeC6RnaamlRod3Gd6OmDHWCWnOX', '2019-03-26 23:52:44', '2019-03-26 23:52:44'),
(997, 28, 'Cr3nzOJvG3GyXwS9OLrhVmt5i3tG06K5', '2019-03-26 23:54:20', '2019-03-26 23:54:20'),
(1001, 29, 'dlZgIkji4odV6oBDpeoIDTmyCkBUCpwT', '2019-03-27 00:07:26', '2019-03-27 00:07:26'),
(1002, 29, 'yzxbs7yqLe3EA6zaKjeMjArQk4LbreKA', '2019-03-27 00:07:28', '2019-03-27 00:07:28'),
(1003, 29, 'shaX4wbCkNXAHpVKc6ZtlgEQG93r4Ckv', '2019-03-27 00:07:29', '2019-03-27 00:07:29'),
(1004, 29, 'i2NEEIeFPOk7LPMYIqf3oObbsMCQWjH6', '2019-03-27 00:07:30', '2019-03-27 00:07:30'),
(1006, 30, 'Yp1cCH7ZZZYABV1QDDdboawVr8zYS6tN', '2019-03-27 00:15:23', '2019-03-27 00:15:23'),
(1008, 30, '64C1y5woZrpFFsaZ6La1Zp0IRrAosuup', '2019-03-27 00:16:25', '2019-03-27 00:16:25'),
(1011, 30, 'QvScS3r6bOmiaL8YAHFie1Nn2050DNJJ', '2019-03-27 00:19:08', '2019-03-27 00:19:08'),
(1012, 30, 'SQPbFZbGXP6ffMPh9D7CeU3f9ov5wLcj', '2019-03-27 00:19:13', '2019-03-27 00:19:13'),
(1013, 30, 'WAZeMj6xcOyEsuJuARrSjMWowUf8oJoV', '2019-03-27 00:20:30', '2019-03-27 00:20:30'),
(1014, 30, 'xYkicdSBbPngLCZyjniuYHn5H5JMqczt', '2019-03-27 00:23:11', '2019-03-27 00:23:11'),
(1027, 1, 'BBZXnuSDx79YXH3upJDquOnhQeR4oDgH', '2019-03-27 04:00:03', '2019-03-27 04:00:03'),
(1031, 1, 'X4Wa5hMMwYNFYiJDMrQ8HZnUefF5EKG9', '2019-03-27 05:49:10', '2019-03-27 05:49:10'),
(1032, 1, 'hzGwlpG1RMABQur32CjAvpUizfCABk5W', '2019-03-27 05:49:18', '2019-03-27 05:49:18'),
(1034, 4, 'vrBiWsaL8xilUH9viwFOzguARjbbAn4e', '2019-03-27 05:52:26', '2019-03-27 05:52:26'),
(1043, 22, 'FBhVwAv7XUeAXqJ3kCp1LCUiVkr8ta63', '2019-03-27 06:39:03', '2019-03-27 06:39:03'),
(1046, 1, '9Ci3ruJfhBBOX66vc0yiP2kPpk4tRG0B', '2019-03-27 07:07:55', '2019-03-27 07:07:55'),
(1047, 1, 'lf9VbYs96LzprQlwzymRAecCMSrd5F6Q', '2019-03-27 07:21:01', '2019-03-27 07:21:01'),
(1056, 22, 'yDQ0bfB9P99KMk5OCTqHbkzjN6mehCDm', '2019-03-27 07:58:57', '2019-03-27 07:58:57'),
(1059, 22, 'tRUuJNiDQP4L1ZaFzhmCHIrXeH7JHJ6E', '2019-03-27 08:00:01', '2019-03-27 08:00:01'),
(1061, 22, '1Ra70xtU2CsTrohZ4DypJWwgimG2mMV3', '2019-03-27 08:02:11', '2019-03-27 08:02:11'),
(1064, 22, 'x9GNZJy8FcEmtXiXPLHggoqxuqovgt5b', '2019-03-27 08:05:25', '2019-03-27 08:05:25'),
(1066, 1, 'd2SjYDCYdzUrfHD5qqyHQR7AR3RVCuAM', '2019-03-27 22:19:19', '2019-03-27 22:19:19'),
(1067, 1, 'qnzOVw7BlxtuYXsbqTvAO1tRVvlU0e3G', '2019-03-27 22:20:31', '2019-03-27 22:20:31'),
(1071, 1, 'tcOQzKzOfVHQVHHm9jNAVQfiP2CRGAHV', '2019-03-27 22:49:28', '2019-03-27 22:49:28'),
(1083, 22, 'RvYWD1k4JUsHHu9P8CBjryMIaLXPXvT1', '2019-03-27 23:29:44', '2019-03-27 23:29:44'),
(1084, 1, '2fF8a273E8KcpiOUp6GlC8RHzcU8nGTI', '2019-03-27 23:29:49', '2019-03-27 23:29:49'),
(1085, 22, 'TeBjPg7UKKT3ldseA9Xx7aZkUqnVBACC', '2019-03-27 23:30:21', '2019-03-27 23:30:21'),
(1086, 22, 'RnHMtKmKnQE3hxvwlIyESfo9FTe8MND0', '2019-03-27 23:31:35', '2019-03-27 23:31:35'),
(1089, 1, 'WYFIm50aPkfT3eTypZnMzF6yKZtKkxwo', '2019-03-27 23:33:25', '2019-03-27 23:33:25'),
(1090, 22, 'QjyU4gwdPxSUuD1r7G3uVtJibzbj9tJt', '2019-03-27 23:33:40', '2019-03-27 23:33:40'),
(1093, 4, 'ONI8y9VBbfoeLX0m6JRsYVT79NgnJUaQ', '2019-03-27 23:35:32', '2019-03-27 23:35:32'),
(1098, 1, 'a7Uepx9mb2t9ORhzUf6kZ0u0vyTdbdnN', '2019-03-27 23:53:48', '2019-03-27 23:53:48'),
(1099, 4, 'QkWuDDKa6u1Fy0LFnfeQ7YFHq9VyIL0k', '2019-03-27 23:54:35', '2019-03-27 23:54:35'),
(1102, 22, 'ZrdU9WJ69B4hEzPeabypvaGhrkRTzkt6', '2019-03-27 23:57:17', '2019-03-27 23:57:17'),
(1103, 1, 'PH1FbhmvwmFCZUixAhIE1UvPpOK1bl21', '2019-03-28 00:03:46', '2019-03-28 00:03:46'),
(1104, 22, 'UuKq45sJo7gpozKR5JJEH41ArF2r4lPw', '2019-03-28 00:10:04', '2019-03-28 00:10:04'),
(1107, 1, 'XO8nROKlNsz2xtsBHEEHOb5xGFNToHHw', '2019-03-28 00:13:42', '2019-03-28 00:13:42'),
(1117, 22, 'XfV2wpUe68m3QaCdKzbuxRHTIWeQu7oU', '2019-03-28 00:30:18', '2019-03-28 00:30:18'),
(1119, 1, 'HNsmUNGbipiruS1U20qBTje4MMxg8GG4', '2019-03-28 00:39:19', '2019-03-28 00:39:19'),
(1121, 22, '50C6iqc6vd2HSGrOnwvvAAul0xiEwiTA', '2019-03-28 01:01:51', '2019-03-28 01:01:51'),
(1128, 1, 's37Dso4AtEluzU0uXsqo3GJwMmUvnrhR', '2019-03-28 01:48:06', '2019-03-28 01:48:06'),
(1130, 1, 'ojA93M5G1p9MVWGHOAUCO1DyDK9O3ArR', '2019-03-28 04:41:59', '2019-03-28 04:41:59'),
(1132, 22, 'aj0XwFOoVQmsrVppdjUaWYX7RVjnz5PB', '2019-03-28 05:37:07', '2019-03-28 05:37:07'),
(1144, 1, 'G9HDZvOc4x7viLZrV6f12L3osI49DcFP', '2019-03-28 07:34:59', '2019-03-28 07:34:59'),
(1158, 22, 'GQHgyBWwziaatMnXB5VktIUHeoeZC4j7', '2019-03-28 07:58:24', '2019-03-28 07:58:24'),
(1159, 4, 'Pic2rU5gKXwfgYMPiUvoVk7NZr9Dow9X', '2019-03-28 22:55:53', '2019-03-28 22:55:53'),
(1160, 4, 'TBUqrCNvewrotet6R35akXzV3kNWBsaf', '2019-03-28 23:20:22', '2019-03-28 23:20:22'),
(1164, 6, '6iKhngXOAstSTv2u7fz4IMns5OjAONSD', '2019-03-28 23:25:48', '2019-03-28 23:25:48'),
(1168, 33, 'jwa0tiXDO3imRATPu904m5az4IjBe3Fk', '2019-03-28 23:55:05', '2019-03-28 23:55:05'),
(1170, 1, 'xhSZXtKZC11m9I95PvHosEUabTolT6jw', '2019-03-29 00:22:01', '2019-03-29 00:22:01'),
(1173, 1, '50zZsO47yDTRuvD1k0hnwUi9e8Uym72u', '2019-03-29 00:34:42', '2019-03-29 00:34:42'),
(1185, 22, 'pf6r8NJqfRnXT4xcGzTdSjIp7sU1MQvs', '2019-03-29 02:03:56', '2019-03-29 02:03:56'),
(1186, 1, '4kXLbD9pIM8q2pvm98BtJjM3il0O0fWH', '2019-03-29 02:04:42', '2019-03-29 02:04:42'),
(1191, 22, 'NnZgYO8lHX1vAtMCX0M2ynnIB44tDlwp', '2019-03-31 22:44:22', '2019-03-31 22:44:22'),
(1192, 1, 'thOa9hXMqdCI15QakKpvLJrg7lUITUAz', '2019-03-31 23:01:54', '2019-03-31 23:01:54'),
(1193, 1, '5CBEdQ8fzx1iC5bShXpgiwH4wk3F3ygs', '2019-03-31 23:12:44', '2019-03-31 23:12:44'),
(1194, 22, 'PcBwTDSlXVHe7JqBjLTPjLBQh6gG75qy', '2019-03-31 23:13:13', '2019-03-31 23:13:13'),
(1196, 1, 'L6PbIn8snfvvWHuSGzndfBQokfIL85Sr', '2019-03-31 23:16:38', '2019-03-31 23:16:38'),
(1198, 1, 'whB5rOVs9g0tQaKjephg7Rkmgi1Ub8Ow', '2019-03-31 23:17:33', '2019-03-31 23:17:33'),
(1201, 41, 'R9FhN94bCGj1lPVTIcCoCIptzlrk6xbg', '2019-03-31 23:47:22', '2019-03-31 23:47:22'),
(1206, 4, 'xu2OMtY0qEV9OhLA0daTyzLFX3bKijxu', '2019-04-01 00:33:48', '2019-04-01 00:33:48'),
(1210, 1, 'lFgNIAxF8mgkqoSdRbnlwMmLrhOvOGrM', '2019-04-01 00:57:20', '2019-04-01 00:57:20'),
(1223, 42, 'PLrona9ASQrxrVGdGmlKgcStQaTJ18Ob', '2019-04-01 04:16:56', '2019-04-01 04:16:56'),
(1227, 42, '6amPd6JJAXcJeoArF6Noqj3WM7gz3A93', '2019-04-01 04:24:45', '2019-04-01 04:24:45'),
(1238, 42, 'hTSU4hV54bQG2O37TPuOBwfCMz9cHS5K', '2019-04-01 04:36:53', '2019-04-01 04:36:53'),
(1246, 42, 'zTBAYnoKZilgYVc9SUpj9MkIUO3DZi7K', '2019-04-01 04:42:12', '2019-04-01 04:42:12'),
(1248, 42, 'fJiDzz0SVRLI58fYswpxvoQtPkRmrlH5', '2019-04-01 04:45:55', '2019-04-01 04:45:55'),
(1249, 1, '4YsFHgTfr31MjfRozFfISw0OawebQoI1', '2019-04-01 04:47:02', '2019-04-01 04:47:02'),
(1250, 42, 'g01RgmNyOEAzdYlTXYsYgjOwwIAiargW', '2019-04-01 04:47:51', '2019-04-01 04:47:51'),
(1254, 42, 'DWoS8VfK1oCgTmgoJkCfu9TLlrn2tvPD', '2019-04-01 04:54:42', '2019-04-01 04:54:42');
INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(1255, 1, 'pZxM98qhHbBBTsZJdIOy9IMXSsMhaDcU', '2019-04-01 04:57:09', '2019-04-01 04:57:09'),
(1260, 42, 'RMduGCWUyY7zfRrpdhG81Aj336CV4MNv', '2019-04-01 05:02:12', '2019-04-01 05:02:12'),
(1261, 1, '3pKdMA4Eb5HM0huESPulRJaK3p6meZTq', '2019-04-01 05:03:24', '2019-04-01 05:03:24'),
(1269, 42, 'qzlrPHPlWTAn4szvRCDSL4PQN2yOddkW', '2019-04-01 05:07:59', '2019-04-01 05:07:59'),
(1271, 1, 'zoYU9GHUFjxul3Z7gpIogkJd34vHGrOa', '2019-04-01 05:12:28', '2019-04-01 05:12:28'),
(1278, 43, 'FFc7ANNtjTenHYvJ9vvkV6M1H3tLiX4k', '2019-04-01 05:47:23', '2019-04-01 05:47:23'),
(1279, 1, 'XgLF082Nsq39gi5NkECKrSWO92mbFBYS', '2019-04-01 05:48:41', '2019-04-01 05:48:41'),
(1280, 43, 'jreJyvCzFl47BATdoQEEhduvKWnXADbc', '2019-04-01 05:50:04', '2019-04-01 05:50:04'),
(1281, 1, 'cvVvECB3wNaU37UcKZpZoYGNVj1W05Ak', '2019-04-01 05:51:28', '2019-04-01 05:51:28'),
(1286, 4, 'yki6Rr6ryb2unGYat27lWxHFpwJ4uByc', '2019-04-01 06:21:50', '2019-04-01 06:21:50'),
(1287, 1, 'JhOwWf3AzMtImOcVjafepl1whMpNoJFE', '2019-04-01 06:33:51', '2019-04-01 06:33:51'),
(1293, 25, 'SMe3uVKbVMJyISMte9WdXpsrzMnlZz2u', '2019-04-01 06:45:10', '2019-04-01 06:45:10'),
(1298, 1, 'pPQxmMRZgYFhgvnY9UWElpmRRWAd5WHM', '2019-04-01 07:08:57', '2019-04-01 07:08:57'),
(1306, 1, 'zvcDFW7qZdFEcAG6kLGjPeEN9USGI37t', '2019-04-01 23:00:39', '2019-04-01 23:00:39'),
(1307, 43, 'rRaxff1CNDs2HrSpDGNjkUUZErO2VQpL', '2019-04-01 23:36:31', '2019-04-01 23:36:31'),
(1308, 1, 'pEA5v6pMb0pPziiDkNkadD6BUU7berCh', '2019-04-01 23:48:09', '2019-04-01 23:48:09'),
(1318, 1, 'qX4GqazuHMsp8WMbwpEpP2poCniSkq9U', '2019-04-02 00:29:22', '2019-04-02 00:29:22'),
(1327, 42, 'tbcVEvJWS9G8jKLaKLzJHMUykn7AcTqI', '2019-04-02 01:04:14', '2019-04-02 01:04:14'),
(1328, 1, 'pQ5WeuZwrXAyaHcHLkSct7tHyAZxRrwI', '2019-04-02 01:08:23', '2019-04-02 01:08:23'),
(1334, 1, 'uRX50bqRToYviX85LzXmyT4kZMeM7Vum', '2019-04-02 01:45:01', '2019-04-02 01:45:01'),
(1336, 42, 'f3fKEd2KeY5LjzACRujJOJ0OQlcrgWsG', '2019-04-02 02:01:40', '2019-04-02 02:01:40'),
(1343, 1, '477dJjvObCmcVA2ILKO9TzoamcM3kHkN', '2019-04-02 04:28:31', '2019-04-02 04:28:31'),
(1346, 42, 'cQKKUmoR73H5EqTM5xDWYZDs3338w3HI', '2019-04-02 07:10:25', '2019-04-02 07:10:25'),
(1351, 1, '4lfyv747Kyt8iIax0eGB2KzHdPsbppYF', '2019-04-02 23:00:53', '2019-04-02 23:00:53'),
(1353, 1, 'nLoJFUzloKs0xXF8405PSwbQ8zcCu2bw', '2019-04-02 23:08:38', '2019-04-02 23:08:38'),
(1354, 42, 'dBryjUMUyxD7Cz2gDQGJzLVEZf8NWevU', '2019-04-02 23:20:43', '2019-04-02 23:20:43'),
(1357, 42, '8JIXtCoQ4FrneTkSJSh4bhF2YilUlUTz', '2019-04-02 23:24:45', '2019-04-02 23:24:45'),
(1360, 42, 'DCxWVNWV1COEWPqArQrdRUcmRuz1Zv3u', '2019-04-02 23:39:42', '2019-04-02 23:39:42'),
(1362, 42, 'pfdfmuePFuGwA59NKnVFEwbhHDRSlCpY', '2019-04-02 23:42:29', '2019-04-02 23:42:29'),
(1364, 42, 'fncOEtjwo7iLkLwagTeb6x9kmw2ttExH', '2019-04-02 23:43:52', '2019-04-02 23:43:52'),
(1366, 42, 'f0B7oy2SyDhR7KiqqpL89HmpfHudVa2I', '2019-04-02 23:48:45', '2019-04-02 23:48:45'),
(1369, 42, 'FKn3wKAzNsNw9lSBh0oZHStywqAqfXij', '2019-04-02 23:58:17', '2019-04-02 23:58:17'),
(1370, 1, 'yledOdjjTu7mqHGO4bAdftX6dapVu9zM', '2019-04-03 00:24:34', '2019-04-03 00:24:34'),
(1373, 1, '3mnR3rVS1RLSCaNn2hgMMzIFPYAky3Cg', '2019-04-03 01:32:23', '2019-04-03 01:32:23'),
(1382, 1, 'a0iRuS8Ki1YWrWatOG4SGSuURsZ6rFwb', '2019-04-03 06:54:39', '2019-04-03 06:54:39'),
(1383, 1, 'nZF4PwbaTrw0EXVCLDAmuW5h9YWE0ppU', '2019-04-03 07:24:52', '2019-04-03 07:24:52'),
(1402, 42, 'axfYXT4iaqxJgTdjC6KaWKfpQGNdKUrG', '2019-04-04 01:13:14', '2019-04-04 01:13:14'),
(1407, 1, 'oXdUSt7JtY9JXOTR5JZwrurvCf7nFQLI', '2019-04-04 01:31:13', '2019-04-04 01:31:13'),
(1408, 42, 'pNIomFPCazMUWmewQIm0ac7UOTcMMcPq', '2019-04-04 01:31:39', '2019-04-04 01:31:39'),
(1412, 25, '51z3W5Al3aVlrb9gXNFfvdQDNr53ZL2F', '2019-04-04 01:37:27', '2019-04-04 01:37:27'),
(1413, 1, 'sYFjKJI13XaWfERWdUx76yRBnzg469Au', '2019-04-04 01:48:43', '2019-04-04 01:48:43'),
(1414, 1, '7czbrxOYTIVrmkVt39YmN97JhVwFKgsH', '2019-04-04 01:48:49', '2019-04-04 01:48:49'),
(1415, 1, '6JTqfr6LcQtrphN8DyTXi4QP9WEpTwOP', '2019-04-04 06:45:59', '2019-04-04 06:45:59'),
(1418, 1, '17Olqv0hwfjehiP6F7YODzpiSPB9WSE5', '2019-04-07 23:37:08', '2019-04-07 23:37:08'),
(1419, 1, '5ePPhExd10EbGD4Brgps8CEWf10rTfmS', '2019-04-09 01:32:23', '2019-04-09 01:32:23'),
(1420, 48, 'CIoe2tTmTzcOra87bZlAmwnbOLfHXvJX', '2019-04-09 01:33:12', '2019-04-09 01:33:12'),
(1424, 1, '67NqolibJfqvift1V8d2pKd48sw9a5UC', '2019-04-11 03:37:04', '2019-04-11 03:37:04'),
(1429, 4, 'v30Rt9GsJ9PXggFcnnJ6Nos4eB0wZfuF', '2019-04-11 05:40:03', '2019-04-11 05:40:03'),
(1431, 25, '3SHJLrzI1y6T02oefYVfqfIOXsUkaGKz', '2019-04-11 05:42:44', '2019-04-11 05:42:44'),
(1433, 1, 'yPCYHgtKqzoPOw3bNwJAUPfNDSxTmJsT', '2019-04-11 23:12:15', '2019-04-11 23:12:15'),
(1434, 50, 'AbfmnZ9420a2e4KKBo4eztzj8kUEPSnC', '2019-04-11 23:29:06', '2019-04-11 23:29:06'),
(1441, 22, 'qTlO9y3eJyfVD6cj0B3YS5WwxJvcyMuR', '2019-04-12 07:54:17', '2019-04-12 07:54:17'),
(1442, 22, '7qIg1z1BXQEVSuJchsjHPKIOV1VPwctx', '2019-04-12 23:03:47', '2019-04-12 23:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(19, 1, '6RhbybyEJwpfJaeIvY6tZ87QS6L3Ltg5', 1, '2016-09-01 04:43:00', '2016-09-01 04:33:06', '2016-09-01 04:43:00'),
(44, 1, '6b1ckMEcSS4cnfJmaC3iYCR6m3KjMkfn', 1, '2018-04-25 08:05:55', '2018-04-25 07:54:42', '2018-04-25 08:05:55'),
(45, 1, 'UouDJGcLWxC7ydJLmrcUDnnFEImJ0PfW', 1, '2018-04-25 08:07:34', '2018-04-25 08:07:16', '2018-04-25 08:07:34'),
(46, 1, 'lVARFATpFSnV73NxaIYIkhjIQUu3acS4', 1, '2018-04-25 08:31:05', '2018-04-25 08:29:02', '2018-04-25 08:31:05'),
(50, 1, 'wieObCktYu2lKYJHk0VFWMudne7p6W9J', 1, '2019-01-21 05:26:01', '2019-01-21 05:23:42', '2019-01-21 05:26:01'),
(54, 2, 'm9XUzeTcFwB5K8cbU0lVSehDcCo3AF0X', 1, '2019-02-26 03:56:50', '2019-02-26 02:13:43', '2019-02-26 03:56:50'),
(55, 2, 'ifowtsfSoo4XkNyJmR81bSA6CE34UQT4', 1, '2019-02-26 04:06:09', '2019-02-26 04:05:41', '2019-02-26 04:06:09'),
(56, 2, 'A74PcdD3FC5oXs9iEWHGbxQYXaMkmtTF', 1, '2019-03-04 04:53:21', '2019-03-04 04:51:44', '2019-03-04 04:53:21'),
(57, 2, 'DI0tYtjtYgHnVx6ZGQUePSqWJV5qRw3j', 1, '2019-03-29 01:10:00', '2019-03-29 01:09:16', '2019-03-29 01:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'Checker', '{\"admin\":true}', '2016-04-25 07:50:54', '2016-05-06 06:05:21', NULL),
(2, 'user', 'User', '{\"admin\":false}', '2016-05-06 06:20:47', '2016-05-06 06:20:47', NULL),
(3, 'buyer', 'Buyer', NULL, '2019-02-14 23:08:58', '2019-02-14 23:08:58', NULL),
(4, 'seller', 'Seller', NULL, '2019-02-14 23:10:31', '2019-02-14 23:10:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 3, '2019-02-25 01:06:51', '2019-02-25 01:06:51'),
(3, 3, '2019-02-25 01:46:10', '2019-02-25 01:46:10'),
(4, 3, '2019-02-25 03:46:04', '2019-02-25 03:46:04'),
(5, 3, '2019-02-25 03:47:58', '2019-02-25 03:47:58'),
(6, 4, '2019-02-25 22:21:58', '2019-02-25 22:21:58'),
(7, 4, '2019-03-05 23:25:06', '2019-03-05 23:25:06'),
(8, 3, '2019-03-07 01:42:03', '2019-03-07 01:42:03'),
(10, 4, '2019-03-07 01:51:30', '2019-03-07 01:51:30'),
(12, 3, '2019-03-08 04:21:51', '2019-03-08 04:21:51'),
(14, 4, '2019-03-08 04:29:37', '2019-03-08 04:29:37'),
(16, 4, '2019-03-08 04:37:04', '2019-03-08 04:37:04'),
(17, 3, '2019-03-08 04:46:39', '2019-03-08 04:46:39'),
(20, 4, '2019-03-08 05:05:59', '2019-03-08 05:26:43'),
(21, 3, '2019-03-08 05:33:01', '2019-03-08 05:33:01'),
(22, 4, '2019-03-10 23:46:40', '2019-03-10 23:46:40'),
(23, 4, '2019-03-16 03:39:09', '2019-03-16 03:39:09'),
(24, 4, '2019-03-22 04:54:16', '2019-03-22 04:54:16'),
(25, 3, '2019-03-22 04:56:07', '2019-03-22 04:56:07'),
(26, 3, '2019-03-22 05:05:02', '2019-03-22 05:05:02'),
(27, 4, '2019-03-26 23:43:46', '2019-03-26 23:43:46'),
(28, 3, '2019-03-26 23:45:09', '2019-03-26 23:45:09'),
(29, 4, '2019-03-27 00:06:59', '2019-03-27 00:06:59'),
(30, 4, '2019-03-27 00:14:32', '2019-03-27 00:14:32'),
(31, 4, '2019-03-27 01:31:05', '2019-03-27 01:31:05'),
(32, 4, '2019-03-27 01:32:29', '2019-03-27 01:32:29'),
(33, 3, '2019-03-27 01:34:44', '2019-03-27 01:34:44'),
(34, 4, '2019-03-27 03:40:11', '2019-03-27 03:40:11'),
(35, 4, '2019-03-27 03:42:22', '2019-03-27 03:42:22'),
(36, 4, '2019-03-27 03:43:42', '2019-03-27 03:43:42'),
(37, 4, '2019-03-27 03:44:38', '2019-03-27 03:44:38'),
(38, 4, '2019-03-27 03:48:21', '2019-03-27 03:48:21'),
(39, 4, '2019-03-27 03:50:07', '2019-03-27 03:50:07'),
(40, 4, '2019-03-27 03:58:48', '2019-03-27 03:58:48'),
(41, 4, '2019-03-27 04:23:28', '2019-03-27 04:23:28'),
(42, 4, '2019-04-01 04:14:29', '2019-04-01 04:14:29'),
(43, 3, '2019-04-01 04:22:12', '2019-04-01 04:22:12'),
(44, 4, '2019-04-02 01:05:44', '2019-04-02 01:05:44'),
(45, 4, '2019-04-02 01:07:25', '2019-04-02 01:07:25'),
(46, 3, '2019-04-03 00:29:51', '2019-04-03 00:29:51'),
(47, 3, '2019-04-03 00:30:32', '2019-04-03 00:30:32'),
(48, 3, '2019-04-09 01:12:40', '2019-04-09 01:12:40'),
(48, 4, '2019-04-09 01:12:40', '2019-04-09 01:12:40'),
(49, 3, '2019-04-09 01:20:31', '2019-04-09 01:20:31'),
(49, 4, '2019-04-09 01:20:31', '2019-04-09 01:20:31'),
(50, 3, '2019-04-11 23:23:54', '2019-04-11 23:23:54'),
(50, 4, '2019-04-11 23:23:54', '2019-04-11 23:23:54'),
(51, 3, '2019-04-12 05:56:27', '2019-04-12 05:56:27'),
(51, 4, '2019-04-12 05:56:28', '2019-04-12 05:56:28'),
(52, 3, '2019-04-12 06:01:19', '2019-04-12 06:01:19'),
(52, 4, '2019-04-12 06:01:19', '2019-04-12 06:01:19');

-- --------------------------------------------------------

--
-- Table structure for table `second_level_category`
--

CREATE TABLE `second_level_category` (
  `id` int(11) NOT NULL,
  `first_level_category_id` int(11) NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `unit_price` decimal(15,6) NOT NULL,
  `minimum_quantity` decimal(20,10) DEFAULT NULL,
  `trade_symbol` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `is_visible` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - Not Visible, 1 - Visible, is_visible means if admin set as 1 then this category will be show at home page on slider',
  `is_crypto_category` int(11) NOT NULL COMMENT '1= yes/0= no',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `second_level_category`
--

INSERT INTO `second_level_category` (`id`, `first_level_category_id`, `unit_id`, `name`, `slug`, `description`, `image`, `unit_price`, `minimum_quantity`, `trade_symbol`, `is_active`, `is_visible`, `is_crypto_category`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 6, 'Plants', 'plants', 'Renewable resources are those that are constantly available (like water) or can be reasonably replaced or recovered, like vegetative lands. Animals are also renewable because with a bit of care, they can reproduce offsprings to replace adult animals. Even though some renewable resources can be replaced, they may take many years and that does not make them renewable.', 'a469a1c8a5ba73fa64c063aed849f4b2e003fba2.jpg', '100.000000', '1.0000000000', '&', 1, 1, 0, '2019-03-10 23:18:33', '2019-03-21 00:50:17', NULL),
(2, 2, 3, 'Animals', 'animals', 'If renewable resources come from living things, (such as trees and animals) they can be called organic renewable resources.', '073f33f755439913c16c2503f82bc499e3d19025.png', '500.000000', '10.0000000000', '&', 1, 0, 0, '2019-03-10 23:19:33', '2019-03-22 05:07:27', NULL),
(3, 3, 1, 'Minerales', 'minerales', 'Non-renewable resources are those that cannot easily be replaced once they are destroyed. Examples include fossil fuels. Minerals are also non-renewable because even though they form naturally in a process called the rock cycle, it can take thousands of years, making it non-renewable. Some animals can also be considered non-renewable, because if people hunt for a particular species without ensuring their reproduction, they will be extinct. This is why we must ensure that we protect resources that are endangered.', '81320c73c4c7b5f0e6136d41526789e842006455.png', '20.000000', '100.0000000000', 'mm', 1, 1, 0, '2019-03-10 23:20:40', '2019-03-26 05:09:52', NULL),
(4, 3, 5, 'Fossil Fuels', 'fossil_fuels', 'Some non-renewable resources come from living things — such as fossil fuels. They can be called organic non-renewable resources.', '31e812d59cb349f6fc81ff96dd9421373460bab9.jpg', '50.000000', '30.0000000000', '$', 1, 1, 0, '2019-03-10 23:21:40', '2019-03-26 05:09:54', NULL),
(5, 3, 6, 'Soils', 'soils', 'Inorganic resources may be metallic or non-metallic. Metallic minerals are those that have metals in them. They are harder, shiny, and can be melted to form new products. Examples are iron, copper and tin. Non-metallic minerals have no metals in them. They are softer and do not shine. Examples include clay and coal.', '1000f25997c817d0151c5674a12a72d247d80c5d.png', '50.000000', '100.0000000000', '#', 1, 1, 0, '2019-03-10 23:22:21', '2019-03-26 05:09:56', NULL),
(6, 1, 3, 'Water', 'water', 'Water', '6b6c51fbbb1673693ad87ea196cfc17f06bf7577.png', '2.000000', '2.0000000000', 'mm', 1, 1, 0, '2019-03-10 23:28:32', '2019-03-26 05:09:57', NULL),
(7, 1, 3, 'Coal', 'coal', 'Coal', '469dc5abdf1ec61d8fb6b47cb29e4fb84dff6f34.png', '50.000000', '10.0000000000', '$', 1, 0, 0, '2019-03-10 23:29:12', '2019-03-22 05:07:16', NULL),
(8, 1, 7, 'Oil', 'oil', 'Oil', '85950afa0dbadb6f2b490ff0c2002942dbe704bd.jpg', '100.000000', '50.0000000000', '%', 1, 0, 0, '2019-03-10 23:29:43', '2019-03-22 05:07:13', NULL),
(9, 1, 3, 'Natural gas', 'natural_gas', 'Natural gas', '7eb922f41731fc80b7a44ca7d8d3625eab741d48.jpg', '100.000000', '10.0000000000', '%', 1, 0, 0, '2019-03-10 23:30:11', '2019-03-22 05:07:11', NULL),
(10, 1, 4, 'Phosphorus', 'phosphorus', 'Phosphorus', 'c405a047aff4ae4753164a8630041538a716243f.jpg', '100.000000', '160.0000000000', '50', 1, 0, 0, '2019-03-10 23:30:43', '2019-03-22 05:07:10', NULL),
(11, 1, 5, 'Iron', 'iron', 'Iron is also in limited supply. It is made from elements such as silica which then have to be heated to create the pig iron that industrialisation depends on. Iron was the most important natural resource on earth during ancient ages. It allowed people at that time to build stronger weapons, better transportation and taller buildings. Both iron and steel are still used in modern day industries.', '8d533743192cb8334207d26d11e3af0810879f65.jpg', '50.000000', '1.0000000000', '%', 1, 1, 0, '2019-03-10 23:31:18', '2019-03-26 05:09:47', NULL),
(12, 1, 4, 'Forests and Timber', 'soil', 'As the world gets more modern and population grows, there is more of a demand for housing and construction projects. This reduces open green spaces. Forests are necessary to preserve the ecology of the world that supports all of the natural resources and life. Forests also play a critical role in providing clean air and the lumber that builds the homes.', 'fb4130818b1523fe710a6c00440fa97fb252eb0a.jpg', '60.000000', '56.0000000000', '#', 1, 1, 0, '2019-03-10 23:31:48', '2019-03-26 05:09:44', NULL),
(13, 4, 3, 'Gold', 'gold', 'GOLD', 'b805f2f9d62afd5b0dff42dbfdaa6cf97ce09991.png', '3000.000000', '1.0000000000', '$', 1, 1, 0, '2019-03-10 23:37:39', '2019-03-26 05:09:30', NULL),
(14, 4, 7, 'Silver', 'silver', 'Silver', 'ed1b8d2c2e233fb8f9d9aeaae6d7e3f784332089.png', '2000.000000', '5.0000000000', '$', 1, 1, 0, '2019-03-10 23:38:37', '2019-03-26 05:09:28', NULL),
(15, 4, 7, 'Crudeoil', 'crudeoil', 'CRUDEOIL', '530cb8702fc7283906e45e07db2dd6cb2c64938a.jpeg', '1000.000000', '23.0000000000', '*', 1, 1, 0, '2019-03-10 23:39:23', '2019-03-26 05:09:27', NULL),
(16, 4, 7, 'Aluminium', 'aluminium', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo,', 'ddf219ac32febb7674211bfc8b8125278ca263c9.jpeg', '60.000000', '45.0000000000', '$', 1, 1, 0, '2019-03-10 23:40:13', '2019-03-26 05:09:25', NULL),
(17, 4, 7, 'Copper', 'copper', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo,', '45fe321ab55b9c475fcdc2d7f0df171b485ec959.jpg', '1500.000000', '56.0000000000', '$', 1, 1, 0, '2019-03-10 23:40:52', '2019-03-26 05:09:23', NULL),
(18, 4, 7, 'Nickel', 'nickel', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo,', '46931a7b64c9b63c1f98580653865bf775646946.jpg', '2000.000000', '34.0000000000', '$', 1, 1, 0, '2019-03-10 23:41:31', '2019-03-26 05:09:21', NULL),
(19, 4, 6, 'Lead', 'lead', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo,', 'a5b688aeb1146f177098383a4494100127f39805.jpeg', '1200.000000', '45.0000000000', '#', 1, 1, 0, '2019-03-10 23:42:00', '2019-03-22 05:13:27', NULL),
(20, 4, 5, 'Zinc', 'zinc', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo,', '5c2630be34535e531f5df14881304b71a057ad86.jpg', '67.000000', '4.0000000000', '$', 1, 1, 0, '2019-03-10 23:42:23', '2019-03-22 05:13:14', NULL),
(21, 4, 4, 'Menthaoil', 'menthaoil', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo,', '41c634973a83996141707fdb2946df664b785a78.jpeg', '34.000000', '23.0000000000', '&', 1, 1, 0, '2019-03-10 23:42:59', '2019-03-22 05:13:03', NULL),
(22, 4, 3, 'Cotton', 'cotton', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo,', 'd424b43875cde7637bab4747966435ab3c3d20d2.png', '23.000000', '23.0000000000', '@', 1, 0, 0, '2019-03-10 23:43:26', '2019-03-27 22:55:39', NULL),
(23, 5, 1, 'Crypto', 'crypto', 'Crypto', '78db54f040d0208e2948ae8dff25425908e17f52.jpg', '0.000000', NULL, 'usdc', 1, 0, 1, '2019-04-11 04:59:10', '2019-04-11 10:42:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `crypto_symbol` varchar(255) NOT NULL,
  `crypto_wallet_address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`id`, `user_id`, `crypto_symbol`, `crypto_wallet_address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 6, 'USDC', 'W1234567890', '2019-02-25 22:21:58', '2019-03-11 08:37:02', NULL),
(2, 7, 'USDC', 'Wfdsfsdfdsf', '2019-03-05 23:25:07', '2019-03-05 23:25:07', NULL),
(4, 10, 'USDC', 'sdasdasd', '2019-03-07 01:51:30', '2019-03-07 01:51:30', NULL),
(5, 11, 'USDC', 'asfdsa', '2019-03-08 04:17:51', '2019-03-08 04:17:51', NULL),
(6, 14, 'USDC', 'sadfsafas', '2019-03-08 04:29:37', '2019-03-08 04:29:37', NULL),
(7, 16, 'USDC', 'dfgdgd', '2019-03-08 04:37:04', '2019-03-08 04:37:04', NULL),
(8, 20, 'USDC', 'steeeeeeeeeee', '2019-03-08 05:05:59', '2019-03-08 05:32:24', '2019-03-08 05:32:24'),
(9, 22, 'USDC', '0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0', '2019-03-10 23:46:40', '2019-03-13 05:35:05', NULL),
(10, 23, 'USDC', '0x93572b4a32cc0f642ada98c9a69fd2c4c6255b6c', '2019-03-16 03:39:09', '2019-04-01 04:35:05', '2019-04-01 04:35:05'),
(11, 24, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-22 04:54:16', '2019-03-22 04:54:16', NULL),
(12, 27, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-26 23:43:46', '2019-03-26 23:43:46', NULL),
(13, 29, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 00:06:59', '2019-03-27 00:06:59', NULL),
(14, 30, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 00:14:33', '2019-03-27 00:14:33', NULL),
(15, 31, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 01:31:06', '2019-03-27 01:31:06', NULL),
(16, 32, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 01:32:29', '2019-03-27 01:32:29', NULL),
(17, 34, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 03:40:11', '2019-03-27 03:40:11', NULL),
(18, 35, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 03:42:22', '2019-03-27 03:42:22', NULL),
(19, 36, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 03:43:43', '2019-03-27 03:43:43', NULL),
(20, 37, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 03:44:38', '2019-03-27 03:44:38', NULL),
(21, 38, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 03:48:21', '2019-03-27 03:48:21', NULL),
(22, 39, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 03:50:08', '2019-03-27 03:50:08', NULL),
(23, 40, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 03:58:48', '2019-03-27 03:58:48', NULL),
(24, 41, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-03-27 04:23:28', '2019-03-27 04:23:28', NULL),
(25, 42, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-04-01 04:14:30', '2019-04-01 04:14:30', NULL),
(26, 44, 'USDC', '0x93572b4a32cc0f642ada98c9a69fd2c4c6255b6c', '2019-04-02 01:05:44', '2019-04-02 01:05:44', NULL),
(27, 45, 'USDC', '0x93572b4a32cc0f642ada98c9a69fd2c4c6255b6c', '2019-04-02 01:07:25', '2019-04-02 01:07:25', NULL),
(28, 48, 'USDC', '0xf08d90facd6728fed7e76f59bbd0d8c5179251c0', '2019-04-09 01:12:40', '2019-04-09 01:12:40', NULL),
(29, 49, 'USDC', '0xf08d90facd6728fed7e76f59bbd0d8c5179251c0', '2019-04-09 01:20:31', '2019-04-09 01:20:31', NULL),
(30, 50, 'USDC', 'qwqwedwq', '2019-04-11 23:23:54', '2019-04-11 23:23:54', NULL),
(31, 51, 'USDC', '0xab0874cb61d83f6b67dc08141568868102233bef', '2019-04-12 05:56:28', '2019-04-12 05:56:28', NULL),
(32, 52, '', '', '2019-04-12 06:01:19', '2019-04-12 06:05:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `site_setting_id` int(11) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_address` varchar(255) NOT NULL,
  `site_contact_number` varchar(255) NOT NULL,
  `meta_desc` text NOT NULL,
  `meta_keyword` varchar(500) NOT NULL,
  `site_email_address` varchar(255) NOT NULL,
  `site_logo` text,
  `twitter_url` varchar(255) NOT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `telegram_url` varchar(255) NOT NULL,
  `buy_and_sell_commodities` varchar(255) NOT NULL,
  `coin_url` varchar(255) NOT NULL,
  `site_status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0 - Offline / 1- Online',
  `coin` varchar(255) NOT NULL COMMENT 'this will be shown at front header top',
  `deleted_at` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`site_setting_id`, `site_name`, `site_address`, `site_contact_number`, `meta_desc`, `meta_keyword`, `site_email_address`, `site_logo`, `twitter_url`, `youtube_url`, `telegram_url`, `buy_and_sell_commodities`, `coin_url`, `site_status`, `coin`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Afroin', 'Rental House Mall 39, M.G. Road Boulevard Ground Floor London', '7485123698', 'Afroin', 'Afroin', 'info@Afroin.com', 'f642fc6c9029b77f017f5ef09484417f79a0c437.png', 'http://twitter.com/Afroin', 'http://youtube.com/Afroin', 'http://youtube.com/Afroin', 'afroin is the easiest way to buy and sell commodities easily with cryptocurrency', 'http://demo.imperialsoftech.com/decentralized_marketplace/', '1', '2.633 XFR', 0, '2016-05-30 22:59:12', '2019-04-11 23:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `slider_images`
--

CREATE TABLE `slider_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `slider_image` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider_images`
--

INSERT INTO `slider_images` (`id`, `slider_image`, `image_url`, `created_at`, `updated_at`) VALUES
(24, '508595c9a224fa8148.jpg', '', '2019-03-26 07:29:59', '2019-03-26 07:29:59'),
(25, '353885c9a225ddeff6.jpg', '', '2019-03-26 07:30:13', '2019-03-26 07:30:13'),
(26, '435265c9a22698e2cd.jpg', '', '2019-03-26 07:30:25', '2019-03-26 07:30:25'),
(27, '653665c9a2274393a1.jpg', '', '2019-03-26 07:30:36', '2019-03-26 07:30:36'),
(28, '562975c9a2289f3830.jpg', '', '2019-03-26 07:30:58', '2019-03-26 07:30:58'),
(29, '900735c9a2294dfa13.jpg', '', '2019-03-26 07:31:08', '2019-03-26 07:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `public_key` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'active :1 , disable/not-active:0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `public_key`, `country_id`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'dnDBrL7', 358, 1, '2018-04-30 04:57:02', '2018-04-30 06:51:42'),
(11, 'V6yWPxR', 259, 1, '2018-05-27 23:29:41', '2018-05-27 23:29:41'),
(12, '7rXkDeW', 268, 1, '2018-05-28 00:55:30', '2018-05-28 00:55:30'),
(13, 'DrXuEJw', 268, 1, '2018-05-28 00:56:06', '2018-05-28 01:45:31');

-- --------------------------------------------------------

--
-- Table structure for table `state_translation`
--

CREATE TABLE `state_translation` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `state_title` varchar(500) CHARACTER SET utf8 NOT NULL,
  `state_slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state_translation`
--

INSERT INTO `state_translation` (`id`, `state_id`, `state_title`, `state_slug`, `locale`, `created_at`, `updated_at`) VALUES
(8, 5, 'gujrat', 'gujrat', 'en', '2018-04-30 04:57:02', '2018-04-30 04:57:02'),
(10, 5, 'गुजरात', '', 'hi', '2018-04-30 05:41:15', '2018-04-30 05:41:15'),
(11, 10, 'adadsda', 'adadsda', 'en', '2018-05-27 23:27:53', '2018-05-27 23:27:53'),
(12, 11, 'algeria', 'algeria', 'en', '2018-05-27 23:29:41', '2018-05-27 23:29:41'),
(13, 13, 'Australiaa', 'australiaa', 'en', '2018-05-28 07:15:31', '2018-05-28 01:45:31');

-- --------------------------------------------------------

--
-- Table structure for table `static_pages`
--

CREATE TABLE `static_pages` (
  `id` int(11) NOT NULL,
  `page_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `static_pages`
--

INSERT INTO `static_pages` (`id`, `page_slug`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'terms-and-conditions', '1', '2019-02-19 04:44:35', '2019-03-20 06:39:30', NULL),
(2, 'about-us', '1', '2019-02-19 04:45:03', '2019-03-20 06:39:24', NULL),
(3, 'faq', '1', '2019-02-19 04:45:27', '2019-02-19 04:45:31', NULL),
(4, 'help-us', '1', '2019-02-19 04:45:59', '2019-03-07 05:10:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `static_pages_translation`
--

CREATE TABLE `static_pages_translation` (
  `id` int(11) NOT NULL,
  `static_page_id` int(11) NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_desc` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `static_pages_translation`
--

INSERT INTO `static_pages_translation` (`id`, `static_page_id`, `page_title`, `page_desc`, `locale`, `meta_keyword`, `meta_desc`) VALUES
(1, 1, 'Terms And Conditions', '<div class=\"hsg-featured-snippet\">&nbsp;</div>\r\n<h4>Why the \"About Me\" Page Rocks: It\'s confident, creative, and easy to skim.</h4>\r\n<p>\"About Us\" pages might encompass the values of more than one person or entity, but they\'re no more important to the image of a business than your personal about page. Take Joe Payton\'s \"About Me\" page, below.</p>\r\n<p>Not only does Joe\'s illustrative self-portrait give him a personal brand that customers will remember, but it also demonstrates his expertise as a designer and animator. His website visitors can learn not just what he does, but <em>why</em> he does it, in an easily digestible way. Being able to express his values as a creative professional in such a well-organized page is something to be desired by anyone creating their own about page.</p>\r\n<p><img style=\"width: 690px;\" src=\"https://blog.hubspot.com/hs-fs/hubfs/joe-payton-about-me-page.png?width=690&amp;name=joe-payton-about-me-page.png\" sizes=\"(max-width: 690px) 100vw, 690px\" srcset=\"https://blog.hubspot.com/hs-fs/hubfs/joe-payton-about-me-page.png?width=345&amp;name=joe-payton-about-me-page.png 345w, https://blog.hubspot.com/hs-fs/hubfs/joe-payton-about-me-page.png?width=690&amp;name=joe-payton-about-me-page.png 690w, https://blog.hubspot.com/hs-fs/hubfs/joe-payton-about-me-page.png?width=1035&amp;name=joe-payton-about-me-page.png 1035w, https://blog.hubspot.com/hs-fs/hubfs/joe-payton-about-me-page.png?width=1380&amp;name=joe-payton-about-me-page.png 1380w, https://blog.hubspot.com/hs-fs/hubfs/joe-payton-about-me-page.png?width=1725&amp;name=joe-payton-about-me-page.png 1725w, https://blog.hubspot.com/hs-fs/hubfs/joe-payton-about-me-page.png?width=2070&amp;name=joe-payton-about-me-page.png 2070w\" alt=\"Joe Payton about me page\" width=\"690\" /></p>', 'en', 'terms and conditions', 'Terms And Conditions'),
(2, 2, 'About Us', '<div>\r\n<h1>About Web Pages CMS</h1>\r\n<p>Web Pages CMS is designed to be a simple to use, open source content management system. So are countless other content management systems, so what makes Web Pages CMS different? Well, Web Pages CMS is built using the ASP.NET Web Pages framework.</p>\r\n<h2>ASP.NET Web Pages</h2>\r\n<p>ASP.NET is a mature web development framework&nbsp;from Microsoft. It offers three development models: Web Forms, ASP.NET MVC and Web Pages. Web Forms is an event-driven development model that closely mimics that which Windows Forms developers are used to, with controls, labels and so on that map to HTML elements. One of its major criticisms is that in its attempt to mimic Windows Forms development, ASP.NET Web Forms adds numerous layers of abstraction that hide HTML, CSS and other web technologies. These layers add to the complexity of the framework and result in an increased learning curve.</p>\r\n<p>ASP.NET MVC was designed mainly to resolve another criticism&nbsp;levelled at the Web Forms development model - the difficulty in being able to test Web Forms development. ASP.NET MVC is founded on the principal of extensibility - allowing the developer to cleanly separate modules of code for easy reuse and testing. It implements the Model-View-Controller pattern, and while it brings the developer a lot closer to HTML and other core web development technologies, it is a daunting way to learn web development from scratch.</p>\r\n<p>ASP.NET Web Pages was developed with one aim in mind - to lower the concept count required to learn how to use ASP.NET to develop dynamic web sites. It offers a page-centric development model similar to that experienced by classic ASP or PHP developers, which permits the intermixing of HTML and server-side code in the same file. It introduced a new templating syntax: Razor. Despite the fact that Web Pages makes ASP.NET web development simpler, it still sits on top of the full .NET framework offering developers access to all the same libraries as those that enterprise developers use.&nbsp;</p>\r\n<h2>Simple To Use</h2>\r\n<p>In keeping with the principals behind the ASP.NET Web Pages framework, Web Pages CMS is intended to be simple to use. It is ideal for small to medium sites and over time, additional modules such as blog will be made available so that the system can just as easily be used as a blogging engine.</p>\r\n<h2>Open Source</h2>\r\n<p>Web Pages CMS is released under the MIT licence, which basically permits&nbsp;you to do anything you like with it - so long as any copies of the software that you make and distribute retain a copy&nbsp;of the original licence.&nbsp;</p>\r\n</div>', 'en', 'About Us', 'About Us'),
(3, 3, 'FAQ', '<div>\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n<div>&nbsp;</div>', 'en', 'FAQ', 'FAQ'),
(4, 4, 'Help Us', '<div>\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n<div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt te<em><strong>mpus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate elei</strong></em>fend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Sed aliquam ultrices mauris. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Praesent adipiscing. Phasellus ullamcorper ipsum rutrum nunc. Nunc nonummy metus. Vestibulum volutpat pretium libero. Cras id dui. Aenean ut eros et nisl sagittis vestibulum. Nullam nulla eros, ultricies sit amet, nonummy id, imperdiet feugiat, pede. Sed lectus. Donec mollis hendrerit risus. Phasellus nec sem in justo pellentesque facilisis. Etiam imperdiet imperdiet orci. Nunc nec neque. Phasellus leo dolor, tempus non, auctor et, hendrerit quis, nisi. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo. Maecenas malesuada. Praesent congue erat at massa. Sed cursus turpis vitae tortor. Donec posuere vulputate arcu. Phasellus accumsan cursus velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed aliquam, nisi quis porttitor congue, elit erat euismod orci, ac</div>', 'en', 'Help Us', 'Help Us');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(4) NOT NULL COMMENT '''0'' => deactive,''1''=>''active''',
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`id`, `name`, `description`, `is_active`, `profile_photo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'akshay', 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem', 0, NULL, '2019-03-29 03:52:27', '2019-03-31 23:05:28', NULL),
(2, 'abhimnyu', 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem', 0, '561375c9e254646e8e.jpg', '2019-03-29 05:20:30', '2019-03-31 23:05:35', NULL),
(20, 'shubham patil', 'lorem insumlorem insumlorem insumlorem insumlorem insumlorem insumlorem insumlorem insumlorem insumlorem insum loremip sumlore mipsumloremip sumlorem ipsumlore ipsumlore mipsum', 1, '722585ca19f7cca6c5.png', '2019-03-29 05:42:02', '2019-03-31 23:49:56', NULL),
(21, 'rahul', 'loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum', 1, '752085c9e1db1ee921.jpeg', '2019-03-29 06:54:31', '2019-03-31 23:04:34', NULL),
(22, 'Tushar', 'loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum loremipsum', 1, NULL, '2019-03-29 06:55:20', '2019-03-31 23:04:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `third_level_category`
--

CREATE TABLE `third_level_category` (
  `id` int(11) NOT NULL,
  `first_level_category_id` int(11) NOT NULL,
  `second_level_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `unit_id` int(11) NOT NULL,
  `unit_price` decimal(15,6) NOT NULL,
  `trade_symbol` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE `throttle` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`) VALUES
(1, NULL, 'global', NULL, '2019-03-15 05:30:08', '2019-03-15 05:30:08'),
(2, NULL, 'ip', '192.168.0.7', '2019-03-15 05:30:08', '2019-03-15 05:30:08'),
(3, 22, 'user', NULL, '2019-03-15 05:30:08', '2019-03-15 05:30:08'),
(4, NULL, 'global', NULL, '2019-03-15 05:31:05', '2019-03-15 05:31:05'),
(5, NULL, 'ip', '192.168.0.7', '2019-03-15 05:31:05', '2019-03-15 05:31:05'),
(6, 2, 'user', NULL, '2019-03-15 05:31:05', '2019-03-15 05:31:05'),
(7, NULL, 'global', NULL, '2019-03-15 05:49:39', '2019-03-15 05:49:39'),
(8, NULL, 'ip', '192.168.0.7', '2019-03-15 05:49:39', '2019-03-15 05:49:39'),
(9, 6, 'user', NULL, '2019-03-15 05:49:39', '2019-03-15 05:49:39'),
(10, NULL, 'global', NULL, '2019-03-15 23:50:31', '2019-03-15 23:50:31'),
(11, NULL, 'ip', '192.168.0.7', '2019-03-15 23:50:31', '2019-03-15 23:50:31'),
(12, 22, 'user', NULL, '2019-03-15 23:50:31', '2019-03-15 23:50:31'),
(13, NULL, 'global', NULL, '2019-03-15 23:52:49', '2019-03-15 23:52:49'),
(14, NULL, 'ip', '192.168.0.7', '2019-03-15 23:52:49', '2019-03-15 23:52:49'),
(15, 2, 'user', NULL, '2019-03-15 23:52:49', '2019-03-15 23:52:49'),
(16, NULL, 'global', NULL, '2019-03-16 00:40:56', '2019-03-16 00:40:56'),
(17, NULL, 'ip', '192.168.0.7', '2019-03-16 00:40:56', '2019-03-16 00:40:56'),
(18, 2, 'user', NULL, '2019-03-16 00:40:56', '2019-03-16 00:40:56'),
(19, NULL, 'global', NULL, '2019-03-16 06:13:04', '2019-03-16 06:13:04'),
(20, NULL, 'ip', '192.168.0.7', '2019-03-16 06:13:04', '2019-03-16 06:13:04'),
(21, NULL, 'global', NULL, '2019-03-16 06:13:11', '2019-03-16 06:13:11'),
(22, NULL, 'ip', '192.168.0.7', '2019-03-16 06:13:11', '2019-03-16 06:13:11'),
(23, NULL, 'global', NULL, '2019-03-17 23:25:13', '2019-03-17 23:25:13'),
(24, NULL, 'ip', '192.168.0.7', '2019-03-17 23:25:13', '2019-03-17 23:25:13'),
(25, NULL, 'global', NULL, '2019-03-18 05:30:05', '2019-03-18 05:30:05'),
(26, NULL, 'ip', '192.168.0.7', '2019-03-18 05:30:05', '2019-03-18 05:30:05'),
(27, NULL, 'global', NULL, '2019-03-19 05:02:51', '2019-03-19 05:02:51'),
(28, NULL, 'ip', '192.168.0.7', '2019-03-19 05:02:52', '2019-03-19 05:02:52'),
(29, NULL, 'global', NULL, '2019-03-19 07:49:17', '2019-03-19 07:49:17'),
(30, NULL, 'ip', '::1', '2019-03-19 07:49:17', '2019-03-19 07:49:17'),
(31, 4, 'user', NULL, '2019-03-19 07:49:17', '2019-03-19 07:49:17'),
(32, NULL, 'global', NULL, '2019-03-19 07:50:20', '2019-03-19 07:50:20'),
(33, NULL, 'ip', '::1', '2019-03-19 07:50:20', '2019-03-19 07:50:20'),
(34, NULL, 'global', NULL, '2019-03-19 07:50:24', '2019-03-19 07:50:24'),
(35, NULL, 'ip', '::1', '2019-03-19 07:50:24', '2019-03-19 07:50:24'),
(36, NULL, 'global', NULL, '2019-03-19 07:50:27', '2019-03-19 07:50:27'),
(37, NULL, 'ip', '::1', '2019-03-19 07:50:27', '2019-03-19 07:50:27'),
(38, NULL, 'global', NULL, '2019-03-20 06:49:09', '2019-03-20 06:49:09'),
(39, NULL, 'ip', '::1', '2019-03-20 06:49:09', '2019-03-20 06:49:09'),
(40, NULL, 'global', NULL, '2019-03-20 22:55:33', '2019-03-20 22:55:33'),
(41, NULL, 'ip', '192.168.0.7', '2019-03-20 22:55:33', '2019-03-20 22:55:33'),
(42, NULL, 'global', NULL, '2019-03-20 23:16:17', '2019-03-20 23:16:17'),
(43, NULL, 'ip', '172.17.0.1', '2019-03-20 23:16:17', '2019-03-20 23:16:17'),
(44, NULL, 'global', NULL, '2019-03-20 23:25:18', '2019-03-20 23:25:18'),
(45, NULL, 'ip', '::1', '2019-03-20 23:25:18', '2019-03-20 23:25:18'),
(46, NULL, 'global', NULL, '2019-03-20 23:25:29', '2019-03-20 23:25:29'),
(47, NULL, 'ip', '::1', '2019-03-20 23:25:29', '2019-03-20 23:25:29'),
(48, NULL, 'global', NULL, '2019-03-21 00:35:28', '2019-03-21 00:35:28'),
(49, NULL, 'ip', '::1', '2019-03-21 00:35:28', '2019-03-21 00:35:28'),
(50, NULL, 'global', NULL, '2019-03-21 01:07:09', '2019-03-21 01:07:09'),
(51, NULL, 'ip', '::1', '2019-03-21 01:07:09', '2019-03-21 01:07:09'),
(52, NULL, 'global', NULL, '2019-03-21 05:34:52', '2019-03-21 05:34:52'),
(53, NULL, 'ip', '192.168.0.7', '2019-03-21 05:34:52', '2019-03-21 05:34:52'),
(54, NULL, 'global', NULL, '2019-03-21 05:35:12', '2019-03-21 05:35:12'),
(55, NULL, 'ip', '192.168.0.7', '2019-03-21 05:35:13', '2019-03-21 05:35:13'),
(56, NULL, 'global', NULL, '2019-03-21 05:50:53', '2019-03-21 05:50:53'),
(57, NULL, 'ip', '192.168.0.7', '2019-03-21 05:50:53', '2019-03-21 05:50:53'),
(58, 2, 'user', NULL, '2019-03-21 05:50:53', '2019-03-21 05:50:53'),
(59, NULL, 'global', NULL, '2019-03-21 05:51:08', '2019-03-21 05:51:08'),
(60, NULL, 'ip', '192.168.0.7', '2019-03-21 05:51:08', '2019-03-21 05:51:08'),
(61, 2, 'user', NULL, '2019-03-21 05:51:08', '2019-03-21 05:51:08'),
(62, NULL, 'global', NULL, '2019-03-21 06:47:44', '2019-03-21 06:47:44'),
(63, NULL, 'ip', '192.168.0.7', '2019-03-21 06:47:44', '2019-03-21 06:47:44'),
(64, 4, 'user', NULL, '2019-03-21 06:47:44', '2019-03-21 06:47:44'),
(65, NULL, 'global', NULL, '2019-03-21 07:38:27', '2019-03-21 07:38:27'),
(66, NULL, 'ip', '::1', '2019-03-21 07:38:27', '2019-03-21 07:38:27'),
(67, NULL, 'global', NULL, '2019-03-22 07:55:01', '2019-03-22 07:55:01'),
(68, NULL, 'ip', '192.168.0.7', '2019-03-22 07:55:01', '2019-03-22 07:55:01'),
(69, NULL, 'global', NULL, '2019-03-25 22:50:27', '2019-03-25 22:50:27'),
(70, NULL, 'ip', '192.168.0.7', '2019-03-25 22:50:27', '2019-03-25 22:50:27'),
(71, NULL, 'global', NULL, '2019-03-26 23:52:10', '2019-03-26 23:52:10'),
(72, NULL, 'ip', '192.168.0.6', '2019-03-26 23:52:10', '2019-03-26 23:52:10'),
(73, 28, 'user', NULL, '2019-03-26 23:52:10', '2019-03-26 23:52:10'),
(74, NULL, 'global', NULL, '2019-04-01 00:23:13', '2019-04-01 00:23:13'),
(75, NULL, 'ip', '192.168.0.7', '2019-04-01 00:23:13', '2019-04-01 00:23:13'),
(76, NULL, 'global', NULL, '2019-04-04 01:24:41', '2019-04-04 01:24:41'),
(77, NULL, 'ip', '::1', '2019-04-04 01:24:41', '2019-04-04 01:24:41'),
(78, 2, 'user', NULL, '2019-04-04 01:24:41', '2019-04-04 01:24:41'),
(79, NULL, 'global', NULL, '2019-04-04 01:24:55', '2019-04-04 01:24:55'),
(80, NULL, 'ip', '::1', '2019-04-04 01:24:55', '2019-04-04 01:24:55'),
(81, 2, 'user', NULL, '2019-04-04 01:24:55', '2019-04-04 01:24:55'),
(82, NULL, 'global', NULL, '2019-04-04 01:25:08', '2019-04-04 01:25:08'),
(83, NULL, 'ip', '::1', '2019-04-04 01:25:09', '2019-04-04 01:25:09'),
(84, 2, 'user', NULL, '2019-04-04 01:25:09', '2019-04-04 01:25:09'),
(85, NULL, 'global', NULL, '2019-04-10 23:12:46', '2019-04-10 23:12:46'),
(86, NULL, 'ip', '192.168.0.7', '2019-04-10 23:12:46', '2019-04-10 23:12:46'),
(87, 22, 'user', NULL, '2019-04-10 23:12:46', '2019-04-10 23:12:46'),
(88, NULL, 'global', NULL, '2019-04-11 03:36:52', '2019-04-11 03:36:52'),
(89, NULL, 'ip', '192.168.0.7', '2019-04-11 03:36:52', '2019-04-11 03:36:52');

-- --------------------------------------------------------

--
-- Table structure for table `trade`
--

CREATE TABLE `trade` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT 'user table id, it will be either buyer or seller',
  `first_level_category_id` int(11) UNSIGNED NOT NULL COMMENT 'first_level_category table id',
  `second_level_category_id` int(11) UNSIGNED NOT NULL COMMENT 'second_level_category table id',
  `third_level_category_id` int(11) UNSIGNED NOT NULL COMMENT 'third_level_category table id',
  `trade_ref` tinytext NOT NULL,
  `quantity` decimal(20,10) NOT NULL,
  `unit_price` decimal(18,10) NOT NULL,
  `minimum_quantity` decimal(20,10) DEFAULT NULL,
  `sold_out_qty` decimal(20,10) NOT NULL DEFAULT '0.0000000000',
  `trade_status` tinyint(4) NOT NULL COMMENT '0 - Pending, 1 - Accepted and Initiate Chat, 2 - Waiting for Payment Initiation, 3 - Waiting for Payment Confirmation, 4 - Completed.     This status will use for buyer',
  `order_status` tinyint(4) NOT NULL COMMENT '0 - Pending, 1- Partially Completed, 2 - Completed. This status will use for seller ',
  `trade_type` tinyint(4) NOT NULL COMMENT '0 - Buy, 1 - Sell',
  `unit_id` int(11) NOT NULL,
  `handling_charges` decimal(18,10) NOT NULL,
  `is_active` tinyint(4) NOT NULL COMMENT '0 - inactive, 1 - active',
  `linked_to` int(10) UNSIGNED DEFAULT NULL COMMENT 'id of trade, if buyer add the trade then only this field will use',
  `is_crypto_trade` int(11) NOT NULL DEFAULT '0' COMMENT '0= no/1=yes',
  `is_escrow_approved` int(11) DEFAULT '0' COMMENT '0= no, 1= yes this is only use for crypto trade',
  `is_finalized` tinyint(4) DEFAULT NULL COMMENT 'This field use when buyer add the offer, 0 -  not finalized by seller, 1- finalized by seller',
  `is_disputed` tinyint(4) DEFAULT NULL COMMENT '0 - Not Disputed, 1- Disputed',
  `trade_settlement_seller` decimal(18,10) DEFAULT NULL,
  `trade_settlement_buyer` decimal(18,10) DEFAULT NULL,
  `shipment_company_name` text NOT NULL,
  `tracking_id` varchar(255) NOT NULL,
  `good_bill_of_loading` varchar(255) DEFAULT NULL,
  `delivery_proof` varchar(255) DEFAULT NULL,
  `other` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trade`
--

INSERT INTO `trade` (`id`, `user_id`, `first_level_category_id`, `second_level_category_id`, `third_level_category_id`, `trade_ref`, `quantity`, `unit_price`, `minimum_quantity`, `sold_out_qty`, `trade_status`, `order_status`, `trade_type`, `unit_id`, `handling_charges`, `is_active`, `linked_to`, `is_crypto_trade`, `is_escrow_approved`, `is_finalized`, `is_disputed`, `trade_settlement_seller`, `trade_settlement_buyer`, `shipment_company_name`, `tracking_id`, `good_bill_of_loading`, `delivery_proof`, `other`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 42, 3, 4, 0, 's3VvrK5ff3WXW9L3kPa0DZwKKtAicyYS', '5.0000000000', '1.0000000000', '1.0000000000', '5.0000000000', 0, 2, 1, 5, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-02 00:19:17', '2019-04-02 00:42:41', NULL),
(2, 43, 3, 4, 0, 'CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5', '2.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 5, '1.0000000000', 1, 1, 0, 0, 1, NULL, NULL, NULL, 'imperial', 'TRCID456321', NULL, NULL, NULL, '2019-04-02 00:24:52', '2019-04-02 00:28:06', NULL),
(3, 4, 3, 4, 0, 'azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ', '3.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 5, '2.0000000000', 1, 1, 0, 0, 1, NULL, NULL, NULL, 'mahendra trading company', 'TRD784512', NULL, NULL, NULL, '2019-04-02 00:39:13', '2019-04-02 00:54:42', NULL),
(4, 45, 1, 8, 0, 'a7vm7UxiY8RYpxES6wJP8lEmCdHNZNBO', '15.0000000000', '5.0000000000', '5.0000000000', '20.0000000000', 0, 2, 1, 7, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-02 01:12:22', '2019-04-02 03:29:55', NULL),
(5, 4, 1, 8, 0, 'jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k', '5.0000000000', '5.0000000000', NULL, '0.0000000000', 4, 0, 0, 7, '10.0000000000', 1, 4, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-02 01:14:40', '2019-04-02 01:54:22', NULL),
(6, 2, 1, 8, 0, '2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6', '15.0000000000', '5.0000000000', NULL, '0.0000000000', 4, 0, 0, 7, '2.0000000000', 1, 4, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-02 03:27:32', '2019-04-02 03:35:53', NULL),
(7, 22, 3, 3, 0, 'O8rOgUEjSTXmtiEy23EfHBONWvk9x1S7', '10.0000000000', '1.0000000000', '2.0000000000', '0.0000000000', 0, 0, 1, 1, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-02 03:48:13', '2019-04-02 03:48:13', NULL),
(8, 4, 3, 3, 0, 'U4mm4ixDjBgjCabDg5ViK41dsTzJLBqI', '2.0000000000', '1.0000000000', NULL, '0.0000000000', 0, 0, 0, 1, '0.0000000000', 1, 7, 0, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-02 04:06:35', '2019-04-02 04:06:35', NULL),
(9, 42, 4, 14, 0, 'mg3rwhHh59qmy3GJDNq4LA9S6PoaTW3b', '3.0000000000', '1.0000000000', '1.0000000000', '1.0000000000', 0, 1, 1, 7, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-02 07:11:26', '2019-04-02 23:25:54', NULL),
(10, 42, 2, 1, 0, 'ugMMXFDBAUZZ6aH6GFciEcJAY0kGfuLJ', '20.0000000000', '1.0000000000', '1.0000000000', '2.0000000000', 0, 1, 1, 6, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-02 07:20:00', '2019-04-02 23:44:15', NULL),
(11, 4, 2, 1, 0, 'V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR', '1.0000000000', '1.0000000000', NULL, '0.0000000000', 4, 0, 0, 6, '1.0000000000', 1, 10, 0, 0, 1, NULL, NULL, NULL, 'company name', 'TRC12457', NULL, NULL, NULL, '2019-04-02 07:23:02', '2019-04-02 23:25:01', NULL),
(12, 4, 4, 14, 0, 'iXhmHV0SXgNGCiK386xqHI5JadNCweeB', '1.0000000000', '1.0000000000', NULL, '0.0000000000', 4, 0, 0, 7, '1.0000000000', 1, 9, 0, 0, 1, NULL, NULL, NULL, 'imperial', 'TRC784', NULL, NULL, NULL, '2019-04-02 23:20:12', '2019-04-02 23:28:04', NULL),
(13, 43, 2, 1, 0, 'LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX', '1.0000000000', '1.0000000000', NULL, '0.0000000000', 4, 0, 0, 6, '1.0000000000', 1, 10, 0, 0, 1, NULL, NULL, NULL, 'Company name', 'TRDID124578', NULL, NULL, NULL, '2019-04-02 23:39:03', '2019-04-02 23:50:04', NULL),
(20, 22, 1, 8, 0, '0zmAUmzkJi2LBoPYs1MeXmka69ytYmeF', '10.0000000000', '2.0000000000', '1.0000000000', '0.0000000000', 0, 0, 1, 7, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-03 06:37:45', '2019-04-03 06:37:45', NULL),
(21, 22, 1, 8, 0, '3kQs6A47yk5jJArZRKRj4YkiTjYQbjr5', '5.0000000000', '1.0000000000', '3.0000000000', '0.0000000000', 0, 0, 1, 7, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-03 06:50:29', '2019-04-03 06:50:29', NULL),
(22, 22, 1, 7, 0, 'Q6JxgIP7IXp7V8PmCmq7dSu8PV1iPOZo', '18.0000000000', '1.0000000000', '6.0000000000', '0.0000000000', 0, 0, 1, 3, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-03 06:59:34', '2019-04-03 06:59:34', NULL),
(23, 22, 1, 7, 0, '7a6RVxpkyCXdKtZfqjsmgrjZ0dK8OhcS', '10.0000000000', '2.0000000000', '4.0000000000', '0.0000000000', 0, 0, 1, 3, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-03 07:07:04', '2019-04-03 07:07:04', NULL),
(24, 42, 2, 1, 0, 'giocfaezsmQ0pFvVsPXfJG3g6YeZ3RVM', '10.0000000000', '1.0000000000', '6.0000000000', '6.0000000000', 0, 1, 1, 6, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-03 23:59:41', '2019-04-04 00:04:22', NULL),
(25, 4, 2, 1, 0, '7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX', '6.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 6, '1.0000000000', 1, 24, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 00:00:47', '2019-04-04 00:04:22', NULL),
(26, 43, 2, 1, 0, 'kD66o8Yvz5vFgvNVZ7YGXI9gfUJSBPKN', '6.0000000000', '1.0000000000', NULL, '0.0000000000', 2, 0, 0, 6, '1.0000000000', 1, 24, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 00:01:30', '2019-04-04 00:02:30', NULL),
(27, 42, 3, 4, 0, 'ee07JifNU5yq14j21foG39hRTgfxrAz4', '12.0000000000', '1.0000000000', '5.0000000000', '11.0000000000', 0, 1, 1, 5, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 00:08:36', '2019-04-04 00:12:29', NULL),
(28, 4, 3, 4, 0, '7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK', '5.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 5, '1.0000000000', 1, 27, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 00:09:06', '2019-04-04 00:10:32', NULL),
(29, 43, 3, 4, 0, 'Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe', '6.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 5, '1.0000000000', 1, 27, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 00:09:23', '2019-04-04 00:12:29', NULL),
(30, 42, 4, 15, 0, 'czfB3C5DpilFEB2jCIDZKzIhlutwBN9p', '30.0000000000', '1.0000000000', '17.0000000000', '30.0000000000', 0, 2, 1, 7, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 00:47:47', '2019-04-04 01:14:13', NULL),
(31, 43, 4, 15, 0, 'zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg', '19.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 7, '1.0000000000', 1, 30, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 00:50:30', '2019-04-04 00:51:32', NULL),
(32, 4, 4, 15, 0, 'LaaR4gaj10q2PhAcg4cbgdCg6sUteahn', '11.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 7, '1.0000000000', 1, 30, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 01:12:34', '2019-04-04 01:14:13', NULL),
(33, 42, 1, 6, 0, 'qtpR7s6Ea29blNfN667VAi9w90gAYI89', '50.0000000000', '1.0000000000', '18.0000000000', '50.0000000000', 0, 2, 1, 3, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 01:15:31', '2019-04-11 06:56:22', NULL),
(34, 4, 1, 6, 0, 'Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk', '22.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 3, '1.0000000000', 1, 33, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 01:19:09', '2019-04-11 06:56:24', NULL),
(35, 43, 1, 6, 0, 'Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa', '18.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 3, '1.0000000000', 1, 33, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 01:23:08', '2019-04-11 06:56:25', NULL),
(36, 25, 1, 6, 0, 'peA1koczSqXkTCWHcoG87fGtQ7yXpRao', '10.0000000000', '1.0000000000', NULL, '0.0000000000', 2, 0, 0, 3, '1.0000000000', 1, 33, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 01:26:12', '2019-04-11 06:56:21', NULL),
(37, 28, 1, 6, 0, 'ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h', '10.0000000000', '1.0000000000', NULL, '0.0000000000', 3, 0, 0, 3, '1.0000000000', 1, 33, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-04 01:28:40', '2019-04-11 06:56:15', NULL),
(39, 42, 4, 19, 0, 'q3EAJWUKzN7ZVn9gC3FLqZh6TY5lIuQ0', '12.0000000000', '1.0000000000', '1.0000000000', '0.0000000000', 0, 0, 1, 6, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-05 01:06:14', '2019-04-11 06:56:17', NULL),
(40, 42, 3, 3, 0, 'Te6sLCbhng4eprEpWQ02WLwop2r0iWX4', '20.0000000000', '1.0000000000', '1.0000000000', '0.0000000000', 0, 0, 1, 1, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-05 01:07:38', '2019-04-11 06:56:05', NULL),
(41, 43, 3, 3, 0, 'ZwV93RHHbQcQIJ7MNw2TMXJie6ei3UEF', '1.0000000000', '1.0000000000', NULL, '0.0000000000', 0, 0, 0, 1, '0.0000000000', 1, 40, 0, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-05 01:17:00', '2019-04-11 06:56:07', NULL),
(42, 43, 4, 19, 0, 'xQQLVJ9GsLNeJWctCf8ODkyecWlRmEGB', '1.0000000000', '1.0000000000', NULL, '0.0000000000', 0, 0, 0, 6, '0.0000000000', 1, 39, 1, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-05 01:17:40', '2019-04-11 10:36:23', NULL),
(43, 48, 1, 6, 0, 'psFQ6P5Mdl8mOa39w4oUKSVgXcOLpUfr', '10.0000000000', '1.0000000000', '1.0000000000', '0.0000000000', 0, 0, 1, 3, '0.0000000000', 1, NULL, 1, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-10 06:29:15', '2019-04-11 10:36:20', NULL),
(44, 48, 2, 1, 0, 'IwEks3VFb6SO8Hu7ZyEKsyj9NHN5rDdG', '4.0000000000', '1.0000000000', NULL, '0.0000000000', 0, 0, 0, 6, '0.0000000000', 1, 24, 1, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-10 06:57:28', '2019-04-11 10:36:18', NULL),
(49, 22, 5, 23, 0, 'BbwA3l7r3EBYufKRgvT7A1ZC8uhYXRog', '30.0000000000', '2.0000000000', '5.0000000000', '0.0000000000', 0, 0, 1, 0, '0.0000000000', 1, NULL, 1, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-11 05:43:22', '2019-04-11 05:43:22', NULL),
(50, 4, 5, 23, 0, 'JDcJndr8XxhGqeFYquWjiZmSQuXh2dnY', '5.0000000000', '2.0000000000', NULL, '0.0000000000', 1, 0, 0, 0, '0.0000000000', 1, 49, 0, 0, 1, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-11 07:53:14', '2019-04-12 05:01:04', NULL),
(51, 22, 1, 6, 0, '3ooJRG1755itqFNA2SR9rpMcccWSd2tN', '4.0000000000', '1.0000000000', NULL, '0.0000000000', 0, 0, 0, 3, '0.0000000000', 1, 43, 1, 0, 0, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-12 06:50:08', '2019-04-12 06:50:08', NULL),
(52, 22, 5, 23, 0, 'YnDQprca7MRsGr6Bih7ze2Nx3qFMFtNC', '543.0000000000', '543.0000000000', '356.0000000000', '0.0000000000', 0, 0, 1, 0, '0.0000000000', 1, NULL, 1, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-12 08:04:01', '2019-04-12 08:04:01', NULL),
(53, 22, 1, 6, 0, 'VzTBtJoFN8Q9j7IUkSQoVAs7ZCpQL2sm', '100.0000000000', '12.0000000000', '10.0000000000', '0.0000000000', 0, 0, 1, 3, '0.0000000000', 1, NULL, 0, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-12 23:17:17', '2019-04-12 23:17:17', NULL),
(54, 22, 5, 23, 0, 'wZWjqzHpwnp92tLDj4ZXqIVyMxsyuRx8', '100.0000000000', '12.0000000000', '10.0000000000', '0.0000000000', 0, 0, 1, 0, '0.0000000000', 1, NULL, 1, 1, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-12 23:33:22', '2019-04-13 05:10:34', NULL),
(55, 22, 5, 23, 0, 'l508XCCIMQWtog868gw6CnBB3Cf4og7v', '40.0000000000', '8.0000000000', '5.0000000000', '0.0000000000', 0, 0, 1, 0, '0.0000000000', 1, NULL, 1, 1, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-12 23:33:54', '2019-04-13 05:10:32', NULL),
(56, 22, 5, 23, 0, 'aUS1mPVobzxM08wxn6SPdWrZEY4ZoGFQ', '1.0000000000', '1.0000000000', '1.0000000000', '0.0000000000', 0, 0, 1, 0, '0.0000000000', 1, NULL, 1, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-12 23:36:44', '2019-04-13 05:10:23', NULL),
(57, 22, 5, 23, 0, 'nnLItTBKwb2JWjQa5Vde3P3UfY57plKh', '45.0000000000', '3.0000000000', '3.0000000000', '0.0000000000', 0, 0, 1, 0, '0.0000000000', 1, NULL, 1, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-12 23:41:43', '2019-04-12 23:41:43', NULL),
(58, 22, 5, 23, 0, 'Z6YkMKcH1yXYcgvTkcTLCEdNBlnQ3PWm', '23.0000000000', '2.0000000000', '23.0000000000', '0.0000000000', 0, 0, 1, 0, '0.0000000000', 1, NULL, 1, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-12 23:45:09', '2019-04-12 23:45:09', NULL),
(59, 22, 5, 23, 0, 'WAzxwxMCsH4Iqs6bRkgAGhgLp0pO1VcS', '3.0000000000', '2.0000000000', '2.0000000000', '0.0000000000', 0, 0, 1, 0, '0.0000000000', 1, NULL, 1, 0, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '2019-04-12 23:58:44', '2019-04-12 23:58:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trade_buy_history`
--

CREATE TABLE `trade_buy_history` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `avg_volume` decimal(18,10) DEFAULT NULL,
  `avg_unit_price` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trade_buy_history`
--

INSERT INTO `trade_buy_history` (`id`, `category_id`, `avg_volume`, `avg_unit_price`, `created_at`, `updated_at`) VALUES
(1, 1, '5.5000000000', '5', '2019-03-20 05:33:24', '2019-03-22 11:27:32'),
(2, 3, '1.0000000000', '1.00000000000000', '2019-03-28 07:21:29', '2019-03-28 07:21:29'),
(3, 12, '1.0000000000', '1.00000000000000', '2019-03-28 07:21:29', '2019-03-28 07:21:29'),
(4, 13, '1.0000000000', '1.00000000000000', '2019-03-28 07:21:29', '2019-03-28 07:21:29'),
(5, 1, '1.0000000000', '1.00000000000000', '2019-04-03 06:01:34', '2019-04-03 06:01:34'),
(6, 4, '2.5000000000', '1.00000000000000', '2019-04-03 06:01:34', '2019-04-03 06:01:34'),
(7, 14, '1.0000000000', '1.00000000000000', '2019-04-03 06:01:34', '2019-04-03 06:01:34'),
(8, 6, '16.6666666667', '1.00000000000000', '2019-04-11 23:39:06', '2019-04-11 23:39:06');

-- --------------------------------------------------------

--
-- Table structure for table `trade_chat_history`
--

CREATE TABLE `trade_chat_history` (
  `id` int(11) UNSIGNED NOT NULL,
  `trade_id` int(11) UNSIGNED NOT NULL,
  `sender_id` int(11) UNSIGNED NOT NULL COMMENT 'user table id',
  `receiver_id` int(11) UNSIGNED NOT NULL COMMENT 'user table id',
  `message` text NOT NULL,
  `is_viewed` tinyint(4) DEFAULT '0' COMMENT '0 - Not viewed, 1 - Viewed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trade_chat_history`
--

INSERT INTO `trade_chat_history` (`id`, `trade_id`, `sender_id`, `receiver_id`, `message`, `is_viewed`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 16, 22, 4, 'Hello Priyanka', 0, '2019-03-13 01:11:52', '2019-03-13 01:11:52', NULL),
(2, 16, 1, 4, 'priyanka are you there?', 0, '2019-03-13 01:12:28', '2019-03-13 01:12:28', NULL),
(3, 16, 4, 22, 'Hello guyz im here', 0, '2019-03-13 01:13:18', '2019-03-13 01:13:18', NULL),
(4, 16, 4, 22, 'Please add handling charges is 10 only', 0, '2019-03-13 01:13:57', '2019-03-13 01:13:57', NULL),
(5, 18, 22, 4, 'Hello', 0, '2019-03-15 01:44:20', '2019-03-15 01:44:20', NULL),
(6, 21, 22, 2, 'Hello sagar', 0, '2019-03-15 05:11:37', '2019-03-15 05:11:37', NULL),
(7, 21, 22, 2, 'i am adding 2 rs as a handling charges', 0, '2019-03-15 05:12:04', '2019-03-15 05:12:04', NULL),
(8, 21, 2, 22, 'hey how says you to add handling charges', 0, '2019-03-15 05:14:53', '2019-03-15 05:14:53', NULL),
(9, 23, 22, 2, 'Hi', 0, '2019-03-15 05:22:03', '2019-03-15 05:22:03', NULL),
(10, 21, 22, 2, 'charges added', 0, '2019-03-15 23:51:44', '2019-03-15 23:51:44', NULL),
(11, 40, 1, 4, 'hi', 0, '2019-03-18 23:51:48', '2019-03-18 23:51:48', NULL),
(12, 40, 1, 4, 'hey', 0, '2019-03-19 00:30:48', '2019-03-19 00:30:48', NULL),
(13, 40, 1, 4, 'yess', 0, '2019-03-19 00:30:55', '2019-03-19 00:30:55', NULL),
(14, 40, 1, 4, 'dwer', 0, '2019-03-19 00:31:00', '2019-03-19 00:31:00', NULL),
(15, 44, 4, 22, 'please add handling charges', 0, '2019-03-19 04:54:42', '2019-03-19 04:54:42', NULL),
(16, 55, 4, 22, '2 add plase', 0, '2019-03-19 07:17:17', '2019-03-19 07:17:17', NULL),
(17, 60, 1, 4, 'hi', 0, '2019-03-19 07:34:24', '2019-03-19 07:34:24', NULL),
(18, 123, 1, 4, 'hi', 0, '2019-03-23 04:04:16', '2019-03-23 04:04:16', NULL),
(19, 123, 1, 4, 'gr', 0, '2019-03-23 04:04:20', '2019-03-23 04:04:20', NULL),
(20, 123, 1, 4, 'hgfhf', 0, '2019-03-23 04:04:23', '2019-03-23 04:04:23', NULL),
(21, 123, 1, 4, 'hfghfg', 0, '2019-03-23 04:04:26', '2019-03-23 04:04:26', NULL),
(22, 123, 1, 4, 'fghfg', 0, '2019-03-23 04:04:27', '2019-03-23 04:04:27', NULL),
(23, 123, 1, 4, 'ghfghfg', 0, '2019-03-23 04:04:29', '2019-03-23 04:04:29', NULL),
(24, 123, 1, 4, 'ghfgh', 0, '2019-03-23 04:04:30', '2019-03-23 04:04:30', NULL),
(25, 123, 1, 4, 'hi', 0, '2019-03-26 03:23:51', '2019-03-26 03:23:51', NULL),
(26, 189, 22, 4, 'hi', 0, '2019-03-28 07:38:23', '2019-03-28 07:38:23', NULL),
(27, 191, 1, 4, 'h', 0, '2019-03-29 00:43:44', '2019-03-29 00:43:44', NULL),
(28, 191, 1, 4, 'hgello', 0, '2019-03-29 00:43:51', '2019-03-29 00:43:51', NULL),
(29, 191, 1, 4, 'ghg', 0, '2019-03-29 00:47:00', '2019-03-29 00:47:00', NULL),
(30, 191, 1, 4, 'fdf', 0, '2019-03-29 00:47:06', '2019-03-29 00:47:06', NULL),
(31, 191, 1, 4, 'gdfg', 0, '2019-03-29 00:48:42', '2019-03-29 00:48:42', NULL),
(32, 191, 22, 4, 'fsdf', 0, '2019-03-29 00:48:48', '2019-03-29 00:48:48', NULL),
(33, 191, 1, 4, 'teeeeeeeeeeeee', 0, '2019-03-29 00:48:52', '2019-03-29 00:48:52', NULL),
(34, 191, 1, 4, 'ds', 0, '2019-03-29 00:55:07', '2019-03-29 00:55:07', NULL),
(35, 191, 4, 22, 'cvd', 0, '2019-03-29 00:55:52', '2019-03-29 00:55:52', NULL),
(36, 191, 1, 4, 'fdgdf', 0, '2019-03-29 00:55:55', '2019-03-29 00:55:55', NULL),
(37, 13, 1, 43, 'gdfg', 0, '2019-04-03 00:58:10', '2019-04-03 00:58:10', NULL),
(38, 13, 1, 43, 'gdfg', 0, '2019-04-03 00:58:12', '2019-04-03 00:58:12', NULL),
(39, 13, 1, 43, 'gdfg', 0, '2019-04-03 00:58:14', '2019-04-03 00:58:14', NULL),
(40, 13, 1, 43, 'dfgdfg', 0, '2019-04-03 00:58:16', '2019-04-03 00:58:16', NULL),
(41, 13, 1, 43, 'gdfg', 0, '2019-04-03 00:58:17', '2019-04-03 00:58:17', NULL),
(42, 13, 1, 43, 'gdfgdf', 0, '2019-04-03 00:58:19', '2019-04-03 00:58:19', NULL),
(43, 13, 1, 43, 'dasda', 0, '2019-04-03 00:58:20', '2019-04-03 00:58:20', NULL),
(44, 13, 1, 43, 'sfdhsfg', 0, '2019-04-03 00:58:22', '2019-04-03 00:58:22', NULL),
(45, 13, 1, 43, 'hfdsg', 0, '2019-04-03 00:58:24', '2019-04-03 00:58:24', NULL),
(46, 13, 1, 43, 'hsfhgfh', 0, '2019-04-03 00:58:25', '2019-04-03 00:58:25', NULL),
(47, 13, 1, 43, 'hfdgs', 0, '2019-04-03 00:58:27', '2019-04-03 00:58:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trade_dispute`
--

CREATE TABLE `trade_dispute` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'buyer or seller user id',
  `trade_id` int(10) UNSIGNED NOT NULL COMMENT 'id from trade table',
  `dispute_reason` text NOT NULL,
  `is_dispute_finalized` tinyint(4) NOT NULL COMMENT '0- Not Finalized, 1 - Finalized',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trade_dispute`
--

INSERT INTO `trade_dispute` (`id`, `user_id`, `trade_id`, `dispute_reason`, `is_dispute_finalized`, `created_at`, `updated_at`) VALUES
(1, 22, 40, 'testttt', 0, '2019-03-19 01:42:45', '2019-03-19 01:42:45'),
(2, 4, 38, 'test2', 0, '2019-03-19 02:00:31', '2019-03-19 02:00:31'),
(3, 4, 42, 'quality is very poor', 0, '2019-03-19 04:51:09', '2019-03-19 04:51:09'),
(4, 4, 44, 'df', 0, '2019-03-19 04:57:20', '2019-03-19 04:57:20'),
(5, 4, 46, 'test', 0, '2019-03-19 05:07:48', '2019-03-19 05:07:48'),
(6, 4, 48, 'test', 0, '2019-03-19 06:32:54', '2019-03-19 06:32:54'),
(7, 22, 50, 'test', 0, '2019-03-19 06:39:56', '2019-03-19 06:39:56'),
(8, 4, 55, 'rtdf', 1, '2019-03-19 07:19:34', '2019-03-20 05:39:56'),
(9, 4, 60, 'not good', 0, '2019-03-19 07:35:40', '2019-03-19 07:35:40'),
(10, 4, 66, 'dsadeas', 0, '2019-03-19 07:59:28', '2019-03-19 07:59:28'),
(11, 4, 73, 'no', 0, '2019-03-19 08:11:13', '2019-03-19 08:11:13'),
(12, 22, 74, 'testing', 0, '2019-03-19 08:35:54', '2019-03-19 08:35:54'),
(18, 22, 126, 'i did not recv money', 1, '2019-03-21 07:18:41', '2019-03-21 07:44:27'),
(19, 4, 143, 'Not good product', 0, '2019-03-23 01:57:20', '2019-03-23 01:57:20'),
(20, 41, 160, 'Not get money', 0, '2019-03-27 08:29:11', '2019-03-27 08:29:11'),
(21, 28, 161, 'Bhanagar Quality', 1, '2019-03-27 09:01:50', '2019-03-27 23:02:32'),
(22, 4, 158, 'Ekdam Danger Quality , don\'t like', 1, '2019-03-27 22:26:36', '2019-03-27 22:55:42'),
(23, 42, 199, 'No money received', 1, '2019-04-01 04:48:57', '2019-04-01 04:52:50'),
(24, 43, 201, 'Qulaity is not good', 1, '2019-04-01 05:01:32', '2019-04-01 05:04:05');

-- --------------------------------------------------------

--
-- Table structure for table `trade_ratings`
--

CREATE TABLE `trade_ratings` (
  `id` int(11) UNSIGNED NOT NULL,
  `trade_id` int(11) UNSIGNED NOT NULL COMMENT 'trade table id',
  `seller_user_id` int(11) UNSIGNED NOT NULL COMMENT 'user table id',
  `buyer_user_id` int(11) UNSIGNED NOT NULL COMMENT 'user table id',
  `points` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 -buyer to seller, 2 - seller to buyer',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trade_ratings`
--

INSERT INTO `trade_ratings` (`id`, `trade_id`, `seller_user_id`, `buyer_user_id`, `points`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 40, 22, 4, '4', 1, '2019-03-19 00:14:21', '2019-03-19 00:14:28', NULL),
(2, 60, 22, 4, '4', 1, '2019-03-19 07:46:05', '2019-03-19 07:51:13', NULL),
(3, 66, 22, 4, '4.5', 1, '2019-03-19 08:01:09', '2019-03-19 08:01:09', NULL),
(4, 73, 22, 4, '2', 1, '2019-03-19 08:14:09', '2019-03-19 08:14:09', NULL),
(5, 115, 22, 4, '2', 1, '2019-03-21 05:29:54', '2019-03-21 05:29:54', NULL),
(6, 136, 22, 4, '3.5', 1, '2019-03-22 01:28:22', '2019-03-22 01:28:22', NULL),
(7, 126, 22, 4, '5', 1, '2019-03-27 06:37:59', '2019-03-27 06:37:59', NULL),
(8, 165, 22, 4, '4.5', 1, '2019-03-28 00:11:39', '2019-03-28 00:11:39', NULL),
(9, 169, 22, 4, '5', 1, '2019-03-28 00:36:45', '2019-03-28 00:36:45', NULL),
(10, 186, 22, 4, '2.5', 1, '2019-03-28 07:06:36', '2019-03-28 07:06:36', NULL),
(11, 187, 22, 4, '2', 1, '2019-03-28 07:27:02', '2019-03-28 07:27:02', NULL),
(12, 195, 22, 4, '3', 1, '2019-04-01 00:40:04', '2019-04-01 00:40:04', NULL),
(13, 197, 22, 4, '1.5', 1, '2019-04-01 00:55:50', '2019-04-01 00:55:50', NULL),
(14, 5, 45, 4, '4.5', 1, '2019-04-02 02:01:28', '2019-04-02 02:01:28', NULL),
(15, 6, 45, 2, '3.5', 1, '2019-04-02 03:37:13', '2019-04-02 03:37:13', NULL),
(16, 11, 42, 4, '3.5', 1, '2019-04-02 07:27:36', '2019-04-02 07:27:55', NULL),
(17, 12, 42, 4, '4.5', 1, '2019-04-02 23:28:17', '2019-04-02 23:28:17', NULL),
(18, 13, 42, 43, '4.5', 1, '2019-04-02 23:50:43', '2019-04-02 23:50:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trade_transaction_detail`
--

CREATE TABLE `trade_transaction_detail` (
  `id` int(11) UNSIGNED NOT NULL,
  `trade_id` int(11) UNSIGNED NOT NULL COMMENT 'trade table id',
  `user_id` int(10) UNSIGNED NOT NULL,
  `transaction_ref` varchar(255) NOT NULL,
  `total_price` decimal(18,10) DEFAULT NULL,
  `payment_status` tinyint(4) DEFAULT NULL COMMENT '0- Pending, 1 - Completed, 2 - Failed',
  `payment_data` text COMMENT 'buyer_wallet_address, buyer_transaction_ref',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trade_transaction_detail`
--

INSERT INTO `trade_transaction_detail` (`id`, `trade_id`, `user_id`, `transaction_ref`, `total_price`, `payment_status`, `payment_data`, `created_at`, `updated_at`) VALUES
(1, 7, 0, 'TRN123456', '1800.0000000000', 1, NULL, '2019-03-05 06:32:56', '2019-03-05 10:19:06'),
(2, 29, 0, 'txHash', '29.0000000000', 0, '{\"paymentData\":{\"trade_ref_id\":\"29\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"W1234567890\",\"depositeAddress\":\"29\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":29,\\\"user_id\\\":2,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":1,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"300e90c005ab409cd45e3e021d8306eb51f61f7c185810d832479cf25fe26a3b\\\",\\\"quantity\\\":\\\"2.0000000000\\\",\\\"unit_price\\\":\\\"3.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"23.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":28,\\\"is_finalized\\\":1,\\\"created_at\\\":\\\"2019-03-15 11:22:25\\\",\\\"updated_at\\\":\\\"2019-03-15 11:23:53\\\",\\\"deleted_at\\\":null}\",\"csrf_token\":\"l3JIuQOrcybrRGKJHr4EHWpzi4Wwk5BbQvJXzX2y\"},\"txHash\":\"txHash\",\"trade_id\":\"29\",\"total_price\":\"29\"}', '2019-03-15 06:44:17', '2019-03-15 06:44:17'),
(3, 23, 0, '0xfa84ccda313034330e8ab9484e864d0731ec751ade13bad54971a0bd3dd0b3b2', '7.0000000000', 0, '{\"paymentData\":{\"trade_ref_id\":\"23\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"7\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":23,\\\"user_id\\\":2,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":13,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"ca8c36bf628c694a3834edf14a196d3beedb1e47d8a353575db6f3c044c308bc\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"3.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"4.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":22,\\\"is_finalized\\\":1,\\\"created_at\\\":\\\"2019-03-15 10:50:53\\\",\\\"updated_at\\\":\\\"2019-03-15 11:00:51\\\",\\\"deleted_at\\\":null}\",\"csrf_token\":\"DwOmwvstKGCh2nTCybmoFqrLrctvioeMkizNQN8R\"},\"txHash\":\"0xfa84ccda313034330e8ab9484e864d0731ec751ade13bad54971a0bd3dd0b3b2\",\"trade_id\":\"23\",\"total_price\":\"7\"}', '2019-03-15 23:23:34', '2019-03-15 23:23:34'),
(4, 42, 0, '0x43e44b40c989196bbfcd72be599ad255ce476bbb53878bffb4bbf4fd46df153e', '35.0000000000', 0, '{\"paymentData\":{\"trade_ref_id\":\"6EGi3SHqjYmXu1P7NV7x9uYsW7noAKby\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"35\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":42,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"6EGi3SHqjYmXu1P7NV7x9uYsW7noAKby\\\",\\\"quantity\\\":\\\"11.0000000000\\\",\\\"unit_price\\\":\\\"3.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"2.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":41,\\\"is_finalized\\\":1,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 09:38:49\\\",\\\"updated_at\\\":\\\"2019-03-19 09:39:30\\\",\\\"deleted_at\\\":null}\",\"csrf_token\":\"trA6dNRcF7RZ1T3Cmb461mgs9T5QHwpfQPjOJjVo\"},\"txHash\":\"0x43e44b40c989196bbfcd72be599ad255ce476bbb53878bffb4bbf4fd46df153e\",\"trade_id\":\"6EGi3SHqjYmXu1P7NV7x9uYsW7noAKby\",\"total_price\":\"35\"}', '2019-03-19 04:40:46', '2019-03-19 10:19:44'),
(5, 44, 0, '0x21e70951089ea9deb0784f61888911cbf814419b37332874dc8a1dc2e62a9b2e', '4.0000000000', 0, '{\"paymentData\":{\"trade_ref_id\":\" \",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"4\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":44,\\\"user_id\\\":4,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":1,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"TSPQajbADxmUvWBVpp8xNs3Fav9ayhlc\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"2.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":43,\\\"is_finalized\\\":1,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 10:23:35\\\",\\\"updated_at\\\":\\\"2019-03-19 10:24:23\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"44\",\"csrf_token\":\"GaczUtEsG9QtBZfuxZ30Pzo1WjwuY0exumPc47Xk\"},\"txHash\":\"0x21e70951089ea9deb0784f61888911cbf814419b37332874dc8a1dc2e62a9b2e\",\"trade_id\":\"TSPQajbADxmUvWBVpp8xNs3Fav9ayhlc\",\"total_price\":\"4\"}', '2019-03-19 04:54:55', '2019-03-19 10:53:49'),
(6, 46, 0, '0x033241de253cc3f73cdecbc6e176aebefb99282185031e59190a60a197f1ffb7', '7.0000000000', 0, '{\"paymentData\":{\"trade_ref_id\":\"qGfkOn1FHizI8RECFxqbxUIzrSDCVhT9\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"7\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":46,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":20,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"qGfkOn1FHizI8RECFxqbxUIzrSDCVhT9\\\",\\\"quantity\\\":\\\"4.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"3.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":45,\\\"is_finalized\\\":1,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 10:33:50\\\",\\\"updated_at\\\":\\\"2019-03-19 10:34:22\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"46\",\"csrf_token\":\"PCSHxdwLcccOQGyJO0VjXrzBuyjBKmlHH4LK5Rmz\"},\"txHash\":\"0x033241de253cc3f73cdecbc6e176aebefb99282185031e59190a60a197f1ffb7\",\"trade_id\":\"46\",\"total_price\":\"7\"}', '2019-03-19 05:06:14', '2019-03-19 05:06:14'),
(7, 48, 0, '0x62dfa308593bf1f8203021cdc350f74d5fa3d93a3e7a05234151c44d0acafc2a', '49.0000000000', 0, '{\"paymentData\":{\"trade_ref_id\":\"lEq9Ww1Sjf713H0uak4FSHzod0a8SzQ6\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"49\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":48,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":16,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"lEq9Ww1Sjf713H0uak4FSHzod0a8SzQ6\\\",\\\"quantity\\\":\\\"45.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"4.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":47,\\\"is_finalized\\\":1,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 11:03:26\\\",\\\"updated_at\\\":\\\"2019-03-19 11:04:03\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"48\",\"csrf_token\":\"HJPxwuacK9cHltvLg0Oh2lnPmCHghyjEAlLx8QSB\"},\"txHash\":\"0x62dfa308593bf1f8203021cdc350f74d5fa3d93a3e7a05234151c44d0acafc2a\",\"trade_id\":\"48\",\"total_price\":\"49\"}', '2019-03-19 05:34:43', '2019-03-19 05:34:43'),
(8, 50, 0, '0xc6f1165af8d24a13bf2dd6e62a270f4af29141f72ff3f12a004c1ba580012b51', '23.0000000000', 0, '{\"paymentData\":{\"trade_ref_id\":\"dgsXbWAirJDtzccTJ9SBRXrZZHiaGciD\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"23\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":50,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":9,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"dgsXbWAirJDtzccTJ9SBRXrZZHiaGciD\\\",\\\"quantity\\\":\\\"10.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"3.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":49,\\\"is_finalized\\\":1,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 12:07:34\\\",\\\"updated_at\\\":\\\"2019-03-19 12:08:04\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"50\",\"csrf_token\":\"MkuLoEpg2FWyVkLCiZZMwZuUU6Cx9WrfSFCOnFAi\"},\"txHash\":\"0xc6f1165af8d24a13bf2dd6e62a270f4af29141f72ff3f12a004c1ba580012b51\",\"trade_id\":\"50\",\"total_price\":\"23\",\"trade_ref\":\"0x6467735862574169724a44747a6363544a3953425258725a5a48696147636944\"}', '2019-03-19 06:38:37', '2019-03-19 06:38:37'),
(10, 55, 0, '0x46ffac64b523294dfe181f36d2253d76d3a192d3b892bb48292f6763b0234976', '22.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"59LYOO1XmfjEoswzyYvZhQR754LwZBjJ\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"22\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":55,\\\"user_id\\\":4,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":2,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"59LYOO1XmfjEoswzyYvZhQR754LwZBjJ\\\",\\\"quantity\\\":\\\"10.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"2.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":54,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 12:46:32\\\",\\\"updated_at\\\":\\\"2019-03-19 12:46:56\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"55\",\"csrf_token\":\"vUnflz08BY5mJKaDzvCDHTsMoBnjOOJZXd1X9OSe\"},\"txHash\":\"0x46ffac64b523294dfe181f36d2253d76d3a192d3b892bb48292f6763b0234976\",\"trade_id\":\"55\",\"total_price\":\"22\"}', '2019-03-19 07:19:05', '2019-03-19 07:19:05'),
(11, 60, 0, '0x85157d220da544d1ee366f10b74e8c058cac62f4c65b94a9bdae702648021874', '7.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"hNNUYHPHimlC1sX2r8R8rOSkSmWzqSIj\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"7\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":60,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":11,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"hNNUYHPHimlC1sX2r8R8rOSkSmWzqSIj\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"5.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":59,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 13:02:47\\\",\\\"updated_at\\\":\\\"2019-03-19 13:03:20\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"60\",\"csrf_token\":\"qwaqUStcwY9QVl204EWzn47NrScStUwo6YLxYliD\"},\"txHash\":\"0x85157d220da544d1ee366f10b74e8c058cac62f4c65b94a9bdae702648021874\",\"trade_id\":\"60\",\"total_price\":\"7\"}', '2019-03-19 07:35:07', '2019-03-19 07:35:07'),
(12, 60, 0, '123455', '4.0000000000', 1, NULL, '2019-03-19 07:44:43', '2019-03-19 07:44:43'),
(13, 60, 0, '123455', '4.0000000000', 1, NULL, '2019-03-19 07:44:49', '2019-03-19 07:44:49'),
(14, 66, 0, '0xc4331c4c1a84e768e88e40f0ab2fe2490e0d84fc2eb2ed81947a30b7e97af065', '5.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"rTgwGHz9yEdLj6xvrnLBduTUQcjjhjEb\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"5\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":66,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":13,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"rTgwGHz9yEdLj6xvrnLBduTUQcjjhjEb\\\",\\\"quantity\\\":\\\"2.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":65,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 13:27:37\\\",\\\"updated_at\\\":\\\"2019-03-19 13:28:11\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"66\",\"csrf_token\":\"0CsZcqW33PO3uLJld80BEnC7ZKasAdRcgM6gCImY\"},\"txHash\":\"0xc4331c4c1a84e768e88e40f0ab2fe2490e0d84fc2eb2ed81947a30b7e97af065\",\"trade_id\":\"66\",\"total_price\":\"5\"}', '2019-03-19 07:58:40', '2019-03-19 07:58:40'),
(15, 66, 0, '0x8f913deaa36a877a0b82387b52a4367a59f69d69bf97f760c0afe331a8fb15ce', '4.0000000000', 1, NULL, '2019-03-19 07:59:38', '2019-03-19 07:59:38'),
(16, 67, 0, '0xa37e30beaf9145f2f475c104b1722fb30d7aafbc98d439f1b439df94baa0aa2c', '61.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"LdoIY3LWw3t14isQtBKUk4yQ5IJlUc0E\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"61\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":67,\\\"user_id\\\":4,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":4,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"LdoIY3LWw3t14isQtBKUk4yQ5IJlUc0E\\\",\\\"quantity\\\":\\\"30.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":64,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 13:27:44\\\",\\\"updated_at\\\":\\\"2019-03-19 13:28:24\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"67\",\"csrf_token\":\"0CsZcqW33PO3uLJld80BEnC7ZKasAdRcgM6gCImY\"},\"txHash\":\"0xa37e30beaf9145f2f475c104b1722fb30d7aafbc98d439f1b439df94baa0aa2c\",\"trade_id\":\"67\",\"total_price\":\"61\"}', '2019-03-19 08:03:26', '2019-03-19 08:03:26'),
(17, 73, 0, '0xf3a111e2c9f79c60dc64c822cc0d57ef1212b09220fed7112ddca27ed8de2cb1', '11.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"EA2lHkf5Zx7I0kvD3L4dZ1khyM23SVTW\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"11\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":73,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"EA2lHkf5Zx7I0kvD3L4dZ1khyM23SVTW\\\",\\\"quantity\\\":\\\"10.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":70,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 13:39:54\\\",\\\"updated_at\\\":\\\"2019-03-19 13:40:43\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"73\",\"csrf_token\":\"tcLsEVymkAD5BHBqBQltER6TRRatwlWFxmqwQMka\"},\"txHash\":\"0xf3a111e2c9f79c60dc64c822cc0d57ef1212b09220fed7112ddca27ed8de2cb1\",\"trade_id\":\"73\",\"total_price\":\"11\"}', '2019-03-19 08:11:06', '2019-03-19 08:11:06'),
(18, 73, 0, '0x04d997ae440fd899daf23562a7d60f61c159a3d86604819d1761ddda5b8d75d0', NULL, NULL, NULL, '2019-03-19 08:14:02', '2019-03-19 08:14:02'),
(19, 74, 0, '0x18bc6c7da346e119fb1003362971e7adbf5b8eaabc528ae680d4f5cd6321fe07', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"yBYKcAS3BddTiaBG3i0udoiLp7ZK5mhr\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":74,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":13,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"yBYKcAS3BddTiaBG3i0udoiLp7ZK5mhr\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":72,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-19 13:44:09\\\",\\\"updated_at\\\":\\\"2019-03-19 14:01:27\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"74\",\"csrf_token\":\"tcLsEVymkAD5BHBqBQltER6TRRatwlWFxmqwQMka\"},\"txHash\":\"0x18bc6c7da346e119fb1003362971e7adbf5b8eaabc528ae680d4f5cd6321fe07\",\"trade_id\":\"74\",\"total_price\":\"2\"}', '2019-03-19 08:34:15', '2019-03-19 08:34:15'),
(20, 74, 0, '0xb723ca688aaf0d1879dc2fe5b3124c4db36dcd98ac12625f3add236eb01b68d0', '2.0000000000', 1, NULL, '2019-03-19 08:35:54', '2019-03-19 08:35:54'),
(21, 79, 0, '0x048457da4723c04d0102ac0d720ba0acdca589fd2a27684d4471a4e59b5409cf', '3.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"x6Hizzcp9wtePiqCPEnpYVE3XPhXazzF\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"3\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":79,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":11,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"x6Hizzcp9wtePiqCPEnpYVE3XPhXazzF\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"2.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":76,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-20 05:52:26\\\",\\\"updated_at\\\":\\\"2019-03-20 05:53:15\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"79\",\"csrf_token\":\"zKA4Zb63IcBcilO6uiDGARMyG475BWbqmo8exkMe\"},\"txHash\":\"0x048457da4723c04d0102ac0d720ba0acdca589fd2a27684d4471a4e59b5409cf\",\"trade_id\":\"79\",\"total_price\":\"3\"}', '2019-03-20 00:25:25', '2019-03-20 00:25:25'),
(22, 79, 1, '0x9f4a3c0839c5103b95238a3eb201daef018ba6992556cd934d85018c55db0593', '3.0000000000', 1, NULL, '2019-03-20 00:30:30', '2019-03-20 00:30:30'),
(23, 78, 0, '0x5cfb35a663a1cdd922bf6ed802de5b4593236163d6fd91966adfc8bb35511263', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"fyJXdaDsnKoLpKZjTFpYXFRqpKUFOToM\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":78,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":11,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"fyJXdaDsnKoLpKZjTFpYXFRqpKUFOToM\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":77,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-20 05:52:19\\\",\\\"updated_at\\\":\\\"2019-03-20 05:53:00\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"78\",\"csrf_token\":\"QoKJ9kHt2NTggzKN3GhdL2BmHdEFR73WpenwVABi\"},\"txHash\":\"0x5cfb35a663a1cdd922bf6ed802de5b4593236163d6fd91966adfc8bb35511263\",\"trade_id\":\"78\",\"total_price\":\"2\"}', '2019-03-20 00:36:30', '2019-03-20 00:36:30'),
(24, 78, 1, '0x301b6e77827df40b65ad125f44f4e4b4d8e6beeb738dfba15e4808a0951215d9', '2.0000000000', 1, NULL, '2019-03-20 00:39:11', '2019-03-20 00:39:11'),
(25, 99, 0, '0x9d4460f17fc684840d1397c50b1753398695cfd10fe2deb75398d25aabfbdb2d', '5.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"eWOLehwLUmNzkMwkrujxA1KDn9hiIR6k\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"5\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":99,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":6,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"eWOLehwLUmNzkMwkrujxA1KDn9hiIR6k\\\",\\\"quantity\\\":\\\"2.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":98,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-21 06:43:40\\\",\\\"updated_at\\\":\\\"2019-03-21 06:44:06\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"99\",\"csrf_token\":\"gEmrAkSw12vMaFhOIvLpP2K5RrdUmK9He9KvMKn8\"},\"txHash\":\"0x9d4460f17fc684840d1397c50b1753398695cfd10fe2deb75398d25aabfbdb2d\",\"trade_id\":\"99\",\"total_price\":\"5\"}', '2019-03-21 01:14:37', '2019-03-21 01:14:37'),
(26, 115, 0, '0x030d963a5a6d51f436322d1d5b7fb99defe158162316af7247d3299f2321f8b4', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"0z2pT6C4N5HFLVCtP28zrQywJo15Yqjv\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":115,\\\"user_id\\\":4,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":1,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"0z2pT6C4N5HFLVCtP28zrQywJo15Yqjv\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":114,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-21 08:34:22\\\",\\\"updated_at\\\":\\\"2019-03-21 08:47:02\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"115\",\"csrf_token\":\"XMw3tlJ9tQRT3C4zXFCfowy5YGWuRoQODT9Ezxat\"},\"txHash\":\"0x030d963a5a6d51f436322d1d5b7fb99defe158162316af7247d3299f2321f8b4\",\"trade_id\":\"115\",\"total_price\":\"2\"}', '2019-03-21 04:31:03', '2019-03-21 04:31:03'),
(27, 115, 0, '0xae6325d8d9b56b0fc6c3c5213c3d964db81394ca31cde125e7e955a8eaf10491', NULL, NULL, NULL, '2019-03-21 05:28:16', '2019-03-21 05:28:16'),
(29, 121, 0, '0xdc8cfda4d1a754f16d0fbe8b9749fb30356e5b9a6e42717dd8df6674ca0d8ad1', '15.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"CWecn75ZnEXVa5Wa9lTQ4WLI0EgKSpS8\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"15\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":121,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":8,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"CWecn75ZnEXVa5Wa9lTQ4WLI0EgKSpS8\\\",\\\"quantity\\\":\\\"6.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"3.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":119,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-21 11:02:57\\\",\\\"updated_at\\\":\\\"2019-03-21 11:03:55\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"121\",\"csrf_token\":\"mKRsJezzj9TPyERFHAYYTQV9VZ5VpyF295CUeJEY\"},\"txHash\":\"0xdc8cfda4d1a754f16d0fbe8b9749fb30356e5b9a6e42717dd8df6674ca0d8ad1\",\"trade_id\":\"121\",\"total_price\":\"15\"}', '2019-03-21 05:39:06', '2019-03-21 05:39:06'),
(30, 124, 0, '0x1706ac4642072eb589616c11e664dd9c6883681d936befaefdf7a6431556b4b5', '12.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"fFOTUietGM1f7xpBRf5w0OJeWCUAJRkk\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"12\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":124,\\\"user_id\\\":2,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":8,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"fFOTUietGM1f7xpBRf5w0OJeWCUAJRkk\\\",\\\"quantity\\\":\\\"5.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"2.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":119,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-21 11:21:24\\\",\\\"updated_at\\\":\\\"2019-03-21 11:22:46\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"124\",\"csrf_token\":\"YMEdKrdSKJoiCKacK1fujti3KRKbOWogj36GCC5l\"},\"txHash\":\"0x1706ac4642072eb589616c11e664dd9c6883681d936befaefdf7a6431556b4b5\",\"trade_id\":\"124\",\"total_price\":\"12\"}', '2019-03-21 05:53:17', '2019-03-21 05:53:17'),
(31, 120, 0, '0x8db4e17f298efeb66af1628b2ba95fffa846c90fe56aa68371e8be84c2690b40', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"xhiTwWNnq53IPH37O79AAtJ8GMZ5ufsl\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":120,\\\"user_id\\\":4,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":4,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"xhiTwWNnq53IPH37O79AAtJ8GMZ5ufsl\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":118,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-21 11:01:10\\\",\\\"updated_at\\\":\\\"2019-03-21 11:50:21\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"120\",\"csrf_token\":\"D4arou5T4uG7zopw6z3YWEiIiVNBDEaQtrkZIicQ\"},\"txHash\":\"0x8db4e17f298efeb66af1628b2ba95fffa846c90fe56aa68371e8be84c2690b40\",\"trade_id\":\"120\",\"total_price\":\"2\"}', '2019-03-21 06:28:28', '2019-03-21 06:28:28'),
(32, 126, 0, '0x7656ef09ba829670ce80ac5fe756519e98711da993311565cd76822df4ce1412', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"6G0jJo06xRpTVN8FZcYi3wHfGV5wzgGX\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":126,\\\"user_id\\\":4,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":2,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"6G0jJo06xRpTVN8FZcYi3wHfGV5wzgGX\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":125,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-21 12:07:32\\\",\\\"updated_at\\\":\\\"2019-03-21 12:08:09\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"126\",\"csrf_token\":\"88AMPwpqgoFz0o5uCRtuHGb3y1HusrmzflLMapEe\"},\"txHash\":\"0x7656ef09ba829670ce80ac5fe756519e98711da993311565cd76822df4ce1412\",\"trade_id\":\"126\",\"total_price\":\"2\"}', '2019-03-21 06:38:49', '2019-03-21 06:38:49'),
(33, 126, 1, '0x1933f2e58150c7aabc313d9783d5bb20a63df72f7ae7daac7eb71ced8d9f2bd2', '2.0000000000', 1, NULL, '2019-03-21 07:44:27', '2019-03-21 07:44:27'),
(34, 136, 0, '0xd79a123b207cdaec8788ed0e8c46125b61f251c9fab4487334d7c6ec0cdc77ed', '55.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"h9rST3HnDVVwvlUkDrxDqcc5wHcv3KkK\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"55\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":136,\\\"user_id\\\":4,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":1,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"h9rST3HnDVVwvlUkDrxDqcc5wHcv3KkK\\\",\\\"quantity\\\":\\\"10.0000000000\\\",\\\"unit_price\\\":\\\"5.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"5.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":135,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-22 06:50:05\\\",\\\"updated_at\\\":\\\"2019-03-22 06:53:37\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"136\",\"csrf_token\":\"VjMvBygFWUxSqjLlaYllAcRp2hwEXrbF6YQj6Crf\"},\"txHash\":\"0xd79a123b207cdaec8788ed0e8c46125b61f251c9fab4487334d7c6ec0cdc77ed\",\"trade_id\":\"136\",\"total_price\":\"55\"}', '2019-03-22 01:24:28', '2019-03-22 01:24:28'),
(35, 136, 0, '0x1726b2eb783fd2c6308b98cb4cf1adc094e96a5259708ab28c5c44801ef8307f', NULL, NULL, NULL, '2019-03-22 01:27:25', '2019-03-22 01:27:25'),
(36, 138, 0, '0xb1d7659824d3e1857c21756bac748ef55b07fa2f8b828627f1997e29b9215185', '5.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"c9TOwjMNkhm8V7LhBFAfjaYKwOlcmDXV\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"5\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":138,\\\"user_id\\\":25,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":11,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"c9TOwjMNkhm8V7LhBFAfjaYKwOlcmDXV\\\",\\\"quantity\\\":\\\"2.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":137,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-22 10:29:28\\\",\\\"updated_at\\\":\\\"2019-03-22 10:30:21\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"138\",\"csrf_token\":\"Y3CTnPXKGnlKaLKf7f0roTj7yHpTlPM2EnWXK2sP\"},\"txHash\":\"0xb1d7659824d3e1857c21756bac748ef55b07fa2f8b828627f1997e29b9215185\",\"trade_id\":\"138\",\"total_price\":\"5\"}', '2019-03-22 05:01:14', '2019-03-22 05:01:14'),
(37, 140, 0, '0x1d6dd5be1f8230b055ca68220e3759dbbdd8e4cdf7ea32f51bd256e0420a1164', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"s6akaIXis9Y0b4l76KDZjSuuGn7cBBvb\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":140,\\\"user_id\\\":25,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"s6akaIXis9Y0b4l76KDZjSuuGn7cBBvb\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":139,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-22 10:33:35\\\",\\\"updated_at\\\":\\\"2019-03-22 10:34:17\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"140\",\"csrf_token\":\"OJE0PTG8q4HB00r7B4Scblc0dbiM04qvRUp772nQ\"},\"txHash\":\"0x1d6dd5be1f8230b055ca68220e3759dbbdd8e4cdf7ea32f51bd256e0420a1164\",\"trade_id\":\"140\",\"total_price\":\"2\"}', '2019-03-22 05:06:29', '2019-03-22 05:06:29'),
(38, 141, 0, '0x2464425ae3106a3f28863ef8559ba5b161f292ee1459f83406630472af6dd45c', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"4kmKOrqdlfwrGbq8DeTZ6yiPh3L31d9U\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":141,\\\"user_id\\\":26,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"4kmKOrqdlfwrGbq8DeTZ6yiPh3L31d9U\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":139,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-22 10:35:32\\\",\\\"updated_at\\\":\\\"2019-03-22 10:36:01\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"141\",\"csrf_token\":\"fjzqxyvBUV9tbhVyxWdTUtGcVBM6OQsHkOkSZabw\"},\"txHash\":\"0x2464425ae3106a3f28863ef8559ba5b161f292ee1459f83406630472af6dd45c\",\"trade_id\":\"141\",\"total_price\":\"2\"}', '2019-03-22 05:07:09', '2019-03-22 05:07:09'),
(39, 143, 0, '0x7b618ee57c53fc294ef7346cc2bcb85c85608e38679b1a83cc12c731e14d3da2', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"LnB1idnpYAjcuOo2NhN37MOHKeZKrAML\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":143,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":11,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"LnB1idnpYAjcuOo2NhN37MOHKeZKrAML\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":142,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-22 12:11:04\\\",\\\"updated_at\\\":\\\"2019-03-22 12:11:28\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"143\",\"csrf_token\":\"odOth0kQgYuJyxn8pmU74PRi9bAqEEFIOgpGzXdE\"},\"txHash\":\"0x7b618ee57c53fc294ef7346cc2bcb85c85608e38679b1a83cc12c731e14d3da2\",\"trade_id\":\"143\",\"total_price\":\"2\"}', '2019-03-23 01:56:22', '2019-03-23 01:56:22'),
(40, 145, 0, '0x4964d885ca741d298f70edc67ad58ef90ada595c1ad6174216b90c74e176f9c3', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"eGONIM6h4OUcelHUle8EbSOSLczaYxWA\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":145,\\\"user_id\\\":4,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":4,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"eGONIM6h4OUcelHUle8EbSOSLczaYxWA\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"is_approved\\\":null,\\\"linked_to\\\":144,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-23 10:32:56\\\",\\\"updated_at\\\":\\\"2019-03-23 10:33:35\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"145\",\"csrf_token\":\"0r31u9wl9fPmD77VAQ5IGxTM1WycbIomS435QZW7\"},\"txHash\":\"0x4964d885ca741d298f70edc67ad58ef90ada595c1ad6174216b90c74e176f9c3\",\"trade_id\":\"145\",\"total_price\":\"2\"}', '2019-03-23 05:04:03', '2019-03-23 05:04:03'),
(41, 160, 0, '0x631fcaabe334fdd07eafd1874606f104ccbb1f5585a25f89c7a6bdbb602ddba0', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"WdewAzpONphSpxOiN1zdoBWW6obT0qeW\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":160,\\\"user_id\\\":28,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":3,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"WdewAzpONphSpxOiN1zdoBWW6obT0qeW\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":1,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":157,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-27 11:47:55\\\",\\\"updated_at\\\":\\\"2019-03-27 13:34:26\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"160\",\"csrf_token\":\"SXCDKA4GtYGZHOpJ1ajmMHasdzhp8GRjDyw5cwIT\"},\"txHash\":\"0x631fcaabe334fdd07eafd1874606f104ccbb1f5585a25f89c7a6bdbb602ddba0\",\"trade_id\":\"160\",\"total_price\":\"2\"}', '2019-03-27 08:14:14', '2019-03-27 08:14:14'),
(42, 161, 0, '0xe335fc35f63dbeec50d427970e11bef8509da22a7fcccbb006db4ec9744911a3', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"WqNT1m1AnDIYLHb6rI27thEeSkH1WHCt\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":161,\\\"user_id\\\":28,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":12,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"WqNT1m1AnDIYLHb6rI27thEeSkH1WHCt\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":4,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":152,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-27 11:53:10\\\",\\\"updated_at\\\":\\\"2019-03-27 13:15:25\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"161\",\"csrf_token\":\"rD22YBvISpcG5aXFVTXHeRtXhGnxADufyMMGN1XS\"},\"txHash\":\"0xe335fc35f63dbeec50d427970e11bef8509da22a7fcccbb006db4ec9744911a3\",\"trade_id\":\"161\",\"total_price\":\"2\"}', '2019-03-27 08:33:31', '2019-03-27 08:33:31'),
(43, 158, 0, '0x2ca6f85cbc1ed39fc21036c907317ff449240794838452ddaa069c1ae891281a', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"mgKb1UbqJ4IdSPNch0jCu7eQV3by2RFQ\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":158,\\\"user_id\\\":4,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":3,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"mgKb1UbqJ4IdSPNch0jCu7eQV3by2RFQ\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":1,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":157,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-27 11:38:28\\\",\\\"updated_at\\\":\\\"2019-03-28 03:51:08\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"158\",\"csrf_token\":\"cyK8xq9n2aZ1fDPwLyFVi4ojb9yH3m9WutvUC3jd\"},\"txHash\":\"0x2ca6f85cbc1ed39fc21036c907317ff449240794838452ddaa069c1ae891281a\",\"trade_id\":\"158\",\"total_price\":\"2\"}', '2019-03-27 22:23:20', '2019-03-27 22:23:20'),
(44, 158, 1, '0xc0f6b14ed6474c481fdeec92625eb20f747ef6171f50aaa4339e8b1fad1536ec', '2.0000000000', 1, NULL, '2019-03-27 22:55:42', '2019-03-27 22:55:42'),
(45, 161, 1, '0xddf1c65f6ab0094a89ed33d746912ecce47d341bd63ab45562a1d5fda7e96d79', '2.0000000000', 1, NULL, '2019-03-27 23:02:32', '2019-03-27 23:02:32'),
(46, 160, 0, '0x1cb68858086af16f9b63d24d6bad2e813f4f469a8ea0a6d303e40b66a67a84b9', NULL, NULL, NULL, '2019-03-27 23:51:26', '2019-03-27 23:51:26');
INSERT INTO `trade_transaction_detail` (`id`, `trade_id`, `user_id`, `transaction_ref`, `total_price`, `payment_status`, `payment_data`, `created_at`, `updated_at`) VALUES
(47, 165, 0, '0x0e74533dd00723b83dbb5254e72bb2c60d661d9e89a851967b48473ba8c5f142', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":165,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":146,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 05:31:37\\\",\\\"updated_at\\\":\\\"2019-03-28 05:32:31\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"165\",\"csrf_token\":\"slQwv4dSLYZuXxiC7qJTRhMgUS9VptvBjsPxYhta\"},\"txHash\":\"0x0e74533dd00723b83dbb5254e72bb2c60d661d9e89a851967b48473ba8c5f142\",\"trade_id\":\"165\",\"total_price\":\"2\"}', '2019-03-28 00:03:13', '2019-03-28 00:03:13'),
(48, 165, 0, '0xade1abcb3ec706edf3f9968c571df8bc9596153cf5c13b99c6826728bca1aab6', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":165,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":146,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 05:31:37\\\",\\\"updated_at\\\":\\\"2019-03-28 05:32:31\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"165\",\"csrf_token\":\"slQwv4dSLYZuXxiC7qJTRhMgUS9VptvBjsPxYhta\"},\"txHash\":\"0xade1abcb3ec706edf3f9968c571df8bc9596153cf5c13b99c6826728bca1aab6\",\"trade_id\":\"165\",\"total_price\":\"2\"}', '2019-03-28 00:04:53', '2019-03-28 00:04:53'),
(49, 165, 0, '0x46797dc15407c65c380454570c7a43fd47973ce899d24cec18d054f130b6305b', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":165,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":146,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 05:31:37\\\",\\\"updated_at\\\":\\\"2019-03-28 05:32:31\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"165\",\"csrf_token\":\"slQwv4dSLYZuXxiC7qJTRhMgUS9VptvBjsPxYhta\"},\"txHash\":\"0x46797dc15407c65c380454570c7a43fd47973ce899d24cec18d054f130b6305b\",\"trade_id\":\"165\",\"total_price\":\"2\"}', '2019-03-28 00:05:26', '2019-03-28 00:05:26'),
(50, 165, 0, '0xaf02f2dcc3941a1040098e79330d1567dbfec17d24a788a74cf296d52da293be', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":165,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":146,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 05:31:37\\\",\\\"updated_at\\\":\\\"2019-03-28 05:32:31\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"165\",\"csrf_token\":\"slQwv4dSLYZuXxiC7qJTRhMgUS9VptvBjsPxYhta\"},\"txHash\":\"0xaf02f2dcc3941a1040098e79330d1567dbfec17d24a788a74cf296d52da293be\",\"trade_id\":\"165\",\"total_price\":\"2\"}', '2019-03-28 00:06:44', '2019-03-28 00:06:44'),
(51, 165, 0, '0x37f95a3170d2b4ca3121f61f4020c719476f1a37321466965b992add96cca245', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":165,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"7QZcYC3IwLAuFjoN5tYFaCI3LsEcnIvB\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":146,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 05:31:37\\\",\\\"updated_at\\\":\\\"2019-03-28 05:32:31\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"165\",\"csrf_token\":\"slQwv4dSLYZuXxiC7qJTRhMgUS9VptvBjsPxYhta\"},\"txHash\":\"0x37f95a3170d2b4ca3121f61f4020c719476f1a37321466965b992add96cca245\",\"trade_id\":\"165\",\"total_price\":\"2\"}', '2019-03-28 00:06:57', '2019-03-28 00:06:57'),
(52, 165, 0, '0x8c78b8a58b5d56b7d556d75860810d03871c76c837500eeb9a31c707ebad5dfa', NULL, NULL, NULL, '2019-03-28 00:11:25', '2019-03-28 00:11:25'),
(53, 169, 0, '0x085e2e45ae5c7511d4bd78f329333207acf2599c0cb20e38e8eb387cd7dfaf38', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"No55Rv6LSF3mdryCD8lxZZcMGkcbqt8R\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":169,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":13,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"No55Rv6LSF3mdryCD8lxZZcMGkcbqt8R\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":168,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 05:59:22\\\",\\\"updated_at\\\":\\\"2019-03-28 06:01:00\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"169\",\"csrf_token\":\"OC15RJZf1HuupxyXGoJlDYKVCdhwNQNh9KH8p2NH\"},\"txHash\":\"0x085e2e45ae5c7511d4bd78f329333207acf2599c0cb20e38e8eb387cd7dfaf38\",\"trade_id\":\"169\",\"total_price\":\"2\"}', '2019-03-28 00:33:47', '2019-03-28 00:33:47'),
(54, 169, 0, '0x3c1b17d01c977e9961a1df8ed224223a887ffb363aabedcdd63dc8071d03c26b', NULL, NULL, NULL, '2019-03-28 00:36:37', '2019-03-28 00:36:37'),
(55, 187, 0, '0xa62440a611af72d5e9a130e9b6ae7c811dad646339bb8093ab0a5fa63de02245', '22.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"VOoT2XW40REkylLByiFAzeAL9cdtjoBY\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"22\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":187,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":8,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"VOoT2XW40REkylLByiFAzeAL9cdtjoBY\\\",\\\"quantity\\\":\\\"10.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"12.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":184,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 07:07:13\\\",\\\"updated_at\\\":\\\"2019-03-28 07:28:03\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"187\",\"csrf_token\":\"BByZkATLdGSNDHvWIk9ulAtXwA4t4Yhtfr06FH7u\"},\"txHash\":\"0xa62440a611af72d5e9a130e9b6ae7c811dad646339bb8093ab0a5fa63de02245\",\"trade_id\":\"187\",\"total_price\":\"22\"}', '2019-03-28 05:37:49', '2019-03-28 05:37:49'),
(56, 187, 0, '0x4eec0a0ddb8d9218c984092fc1d554b1febc4d30613c6e778bf198afcd2fa065', NULL, NULL, NULL, '2019-03-28 05:43:42', '2019-03-28 05:43:42'),
(57, 186, 0, '0xc9453de158061f6107c39326b4e0827a7e4f32bf330bd567ace7a35f6476ab1c', '60.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"B60qgaPiXwIk0ZANm9qeZUtYpB7EqJ19\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"60\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":186,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":7,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"B60qgaPiXwIk0ZANm9qeZUtYpB7EqJ19\\\",\\\"quantity\\\":\\\"4.0000000000\\\",\\\"unit_price\\\":\\\"12.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"12.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":185,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 07:00:47\\\",\\\"updated_at\\\":\\\"2019-03-28 07:05:08\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"186\",\"csrf_token\":\"BByZkATLdGSNDHvWIk9ulAtXwA4t4Yhtfr06FH7u\"},\"txHash\":\"0xc9453de158061f6107c39326b4e0827a7e4f32bf330bd567ace7a35f6476ab1c\",\"trade_id\":\"186\",\"total_price\":\"60\"}', '2019-03-28 07:03:25', '2019-03-28 07:03:25'),
(58, 186, 0, '0x2cc7c857414c04c0d17da2f9d8163777f193281ddd72cb9075247abec46448e7', NULL, NULL, NULL, '2019-03-28 07:05:25', '2019-03-28 07:05:25'),
(59, 189, 0, '0x9e66fc32894055f932532565ac82c81a5966fb4800f8069bd4c0006053b519a3', '25.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"Wk30KCqXty3u4xiqQKfBUWoL89YCJx5K\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"25\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":189,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":14,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"Wk30KCqXty3u4xiqQKfBUWoL89YCJx5K\\\",\\\"quantity\\\":\\\"13.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"12.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":188,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 13:07:07\\\",\\\"updated_at\\\":\\\"2019-03-28 13:07:57\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"189\",\"csrf_token\":\"i0CmyPrbasjDqsWtOaB6loyTw4PqZk30a2IMH2mr\"},\"txHash\":\"0x9e66fc32894055f932532565ac82c81a5966fb4800f8069bd4c0006053b519a3\",\"trade_id\":\"189\",\"total_price\":\"25\"}', '2019-03-28 07:44:00', '2019-03-28 07:44:00'),
(60, 191, 0, '0x15141e2375425d65f055360d7a2c14816faed9a479fcc1eee66aa12500701f6e', '34.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"bB8qPOCnDNoNUmDsyhMurR2pQLxu0Wse\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"34\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":191,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":15,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"bB8qPOCnDNoNUmDsyhMurR2pQLxu0Wse\\\",\\\"quantity\\\":\\\"12.0000000000\\\",\\\"unit_price\\\":\\\"2.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"10.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":190,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-03-28 13:26:32\\\",\\\"updated_at\\\":\\\"2019-03-28 13:28:35\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"191\",\"csrf_token\":\"RJ2M85TdkqqFdpQ2YCt147XsIfkC9P8FwmzopwaO\"},\"txHash\":\"0x15141e2375425d65f055360d7a2c14816faed9a479fcc1eee66aa12500701f6e\",\"trade_id\":\"191\",\"total_price\":\"34\"}', '2019-03-28 08:08:12', '2019-03-28 08:08:12'),
(61, 195, 0, '0x7d5058cda954f06378da52c269e7a947d9e6b68d6e86a8b9459c24dfc21fe976', '250.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"sGK1KxnIDuflCE8b6ROkHK3igi7Iuoq3\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"250\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":195,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":8,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"sGK1KxnIDuflCE8b6ROkHK3igi7Iuoq3\\\",\\\"quantity\\\":\\\"20.0000000000\\\",\\\"unit_price\\\":\\\"12.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"10.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":194,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 06:01:34\\\",\\\"updated_at\\\":\\\"2019-04-01 06:03:33\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"195\",\"csrf_token\":\"5sGXuUuP2ubBunR2JdKA23diFUD5XkbxDIniGjig\"},\"txHash\":\"0x7d5058cda954f06378da52c269e7a947d9e6b68d6e86a8b9459c24dfc21fe976\",\"trade_id\":\"195\",\"total_price\":\"250\"}', '2019-04-01 00:36:06', '2019-04-01 00:36:06'),
(62, 195, 0, '0x9208f04c39dc6f57f0e675afedd180332f7f1144e7ee184e4dfd067f7a1dc0c3', NULL, NULL, NULL, '2019-04-01 00:38:28', '2019-04-01 00:38:28'),
(63, 197, 0, '0xd3f0e14173381d2d9770676beac41c8f896caae67f3e420f9425d9acf778b512', '7.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"162iBri1wFEW0LMbKiQy3hY6nylFiw47\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0xF08D90FacD6728FEd7E76F59BbD0D8c5179251C0\",\"depositeAddress\":\"7\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":197,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":9,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"162iBri1wFEW0LMbKiQy3hY6nylFiw47\\\",\\\"quantity\\\":\\\"2.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"5.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":196,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 06:11:45\\\",\\\"updated_at\\\":\\\"2019-04-01 06:13:01\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"197\",\"csrf_token\":\"5sGXuUuP2ubBunR2JdKA23diFUD5XkbxDIniGjig\"},\"txHash\":\"0xd3f0e14173381d2d9770676beac41c8f896caae67f3e420f9425d9acf778b512\",\"trade_id\":\"197\",\"total_price\":\"7\"}', '2019-04-01 00:48:12', '2019-04-01 00:48:12'),
(64, 197, 0, '0x0f5bef4b93daac5d29a8dc04e0b0f3cc26f3a37371d160f101c2f8ab6211c5ca', NULL, NULL, NULL, '2019-04-01 00:53:08', '2019-04-01 00:53:08'),
(65, 199, 0, '0xe16c09beff056ff623cf39c0e93683da9be99fb578a7adaba6cd48c2ce7a9f57', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":199,\\\"user_id\\\":43,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":1,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"DKqY7Fu32ZtTbSyYTERGFuW3GEAsR2G9\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":198,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 09:57:50\\\",\\\"updated_at\\\":\\\"2019-04-01 10:07:07\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"199\",\"csrf_token\":\"YpjTpuff441hDAllKUnAb1tmSaZylH3tpFskPtUO\"},\"txHash\":\"0xe16c09beff056ff623cf39c0e93683da9be99fb578a7adaba6cd48c2ce7a9f57\",\"trade_id\":\"199\",\"total_price\":\"2\"}', '2019-04-01 04:40:19', '2019-04-01 04:40:19'),
(66, 199, 1, '0xc8c5cf2edaf2275de2c290db7f5e1b7b939b04db035b514e803dd699c17e5a9f', '2.0000000000', 1, NULL, '2019-04-01 04:52:50', '2019-04-01 04:52:50'),
(67, 201, 0, '0x16f73f8dfbbd20aa76899d9a1525f080d098f8c743d5916cb087757bc59aeb63', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":201,\\\"user_id\\\":43,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":4,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"KA5Ojhi8IDYBWWXKRglLm3xwklzYwKss\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":200,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 10:29:32\\\",\\\"updated_at\\\":\\\"2019-04-01 10:30:14\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"201\",\"csrf_token\":\"u7ISpwfvyQ4GnsmqQ5rLdjvWouXc56Rjeh3WUDFl\"},\"txHash\":\"0x16f73f8dfbbd20aa76899d9a1525f080d098f8c743d5916cb087757bc59aeb63\",\"trade_id\":\"201\",\"total_price\":\"2\"}', '2019-04-01 05:01:08', '2019-04-01 05:01:08'),
(68, 201, 1, '0xb715911f426afe9e11a4d7c40c38bfc7d678ff77538de1e60e414c9addcc317b', '2.0000000000', 1, NULL, '2019-04-01 05:04:05', '2019-04-01 05:04:05'),
(69, 203, 0, '0x1628e8073159f0fa164668bc386d18311593f4de5e4645c342bd873a0ec19fce', '3.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"3\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":203,\\\"user_id\\\":43,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":6,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"lQ9oWnGZtj8hUDnoDrJh1msia1IGjl32\\\",\\\"quantity\\\":\\\"2.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":202,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 10:35:47\\\",\\\"updated_at\\\":\\\"2019-04-01 10:36:29\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"203\",\"csrf_token\":\"VdbDb9EkSXmy0KIahjwwwt1IgITBbV1AAoIjgSYH\"},\"txHash\":\"0x1628e8073159f0fa164668bc386d18311593f4de5e4645c342bd873a0ec19fce\",\"trade_id\":\"203\",\"total_price\":\"3\"}', '2019-04-01 05:07:04', '2019-04-01 05:07:04'),
(70, 203, 0, '0xd8cfc729be3704ae9e8623be916ca486efc70ed4b071953e80ecf2bd5358e689', NULL, NULL, NULL, '2019-04-01 05:07:35', '2019-04-01 05:07:35'),
(71, 205, 0, '0x63d20d05c2e72c286abaf47a7b4bacb5eb5fa70c367d95434640771b13cb1542', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":205,\\\"user_id\\\":43,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":15,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"zAD5kGyAxWwFg6OnQlnVuKER1ioRHP2W\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":204,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 11:16:18\\\",\\\"updated_at\\\":\\\"2019-04-01 11:17:04\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"205\",\"csrf_token\":\"hdr8IcufMmYSz7tCWa33NzLxW5n02zbq9CNBA2p4\"},\"txHash\":\"0x63d20d05c2e72c286abaf47a7b4bacb5eb5fa70c367d95434640771b13cb1542\",\"trade_id\":\"205\",\"total_price\":\"2\"}', '2019-04-01 05:47:41', '2019-04-01 05:47:41'),
(72, 205, 0, '0xaf1f556e7ef674f8f87d7cdf0101cf673f47192401311e1851a680f68698e833', NULL, NULL, NULL, '2019-04-01 05:50:20', '2019-04-01 05:50:20'),
(73, 207, 0, '0x8e8a74af91dae445f8a4d1b2fd2eeb52f9aa5a676927c2b6aed2056fc7abd9c8', '3.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"uEBLgLN84pdcwXsAW4rHLC1vvmctUS1a\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"3\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":207,\\\"user_id\\\":43,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":19,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"uEBLgLN84pdcwXsAW4rHLC1vvmctUS1a\\\",\\\"quantity\\\":\\\"2.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":206,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 12:09:29\\\",\\\"updated_at\\\":\\\"2019-04-01 12:09:48\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"207\",\"csrf_token\":\"7DDY4KxzN6m0cXS8t1dpqD4WlhjN5bto9nh7jePB\"},\"txHash\":\"0x8e8a74af91dae445f8a4d1b2fd2eeb52f9aa5a676927c2b6aed2056fc7abd9c8\",\"trade_id\":\"207\",\"total_price\":\"3\"}', '2019-04-01 06:41:01', '2019-04-01 06:41:01'),
(74, 208, 0, '0x8e89c595799552ce43c031b01377a2844f78c0eb0a4347eca18bdf7eb7d06e55', '3.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"MNU5XXvjE76S7dhqjFS2duXc3JYRrgFl\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"3\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":208,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":19,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"MNU5XXvjE76S7dhqjFS2duXc3JYRrgFl\\\",\\\"quantity\\\":\\\"2.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":206,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 12:11:32\\\",\\\"updated_at\\\":\\\"2019-04-01 12:12:21\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"208\",\"csrf_token\":\"2Jy7G4w5FnjsVr9ogdDY8v4PMym3D4b1OCGmp9wT\"},\"txHash\":\"0x8e89c595799552ce43c031b01377a2844f78c0eb0a4347eca18bdf7eb7d06e55\",\"trade_id\":\"208\",\"total_price\":\"3\"}', '2019-04-01 06:43:40', '2019-04-01 06:43:40'),
(75, 209, 0, '0xf8c69e86ea3bd20840d726d3ba069507c7cf3142f6b2499771f0c2e27e28b5a4', '4.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"yQLSyPz67si5F4lWRFm1iR9nutLuPgIr\",\"buyerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"4\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":209,\\\"user_id\\\":25,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":19,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"yQLSyPz67si5F4lWRFm1iR9nutLuPgIr\\\",\\\"quantity\\\":\\\"3.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":206,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 12:13:42\\\",\\\"updated_at\\\":\\\"2019-04-01 12:14:46\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"209\",\"csrf_token\":\"NM2HQKHlqd1XsN9WHJsu0sj6A4QKxp6CTmW7nb83\"},\"txHash\":\"0xf8c69e86ea3bd20840d726d3ba069507c7cf3142f6b2499771f0c2e27e28b5a4\",\"trade_id\":\"209\",\"total_price\":\"4\"}', '2019-04-01 06:45:31', '2019-04-01 06:45:31'),
(76, 209, 0, '0x15aa16182820a775fc7a03d96cac9789d4cc2710dc71ffe9e51837e7b6044127', NULL, NULL, NULL, '2019-04-01 06:45:54', '2019-04-01 06:45:54'),
(77, 212, 0, '0x9f88c21887f035409d63a78b027370eb65f98f3a7719d150879b9d1d46c83eb7', '6.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"PZcbD1F4HXb5Hu3ys64d0aCz1fymsrWY\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"6\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":212,\\\"user_id\\\":43,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":18,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"PZcbD1F4HXb5Hu3ys64d0aCz1fymsrWY\\\",\\\"quantity\\\":\\\"5.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":211,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 12:55:06\\\",\\\"updated_at\\\":\\\"2019-04-01 12:55:49\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"212\",\"csrf_token\":\"qCSJRavtJN8yBmNb6gnzjELwvu4WoMGtodKDHq2W\"},\"txHash\":\"0x9f88c21887f035409d63a78b027370eb65f98f3a7719d150879b9d1d46c83eb7\",\"trade_id\":\"212\",\"total_price\":\"6\"}', '2019-04-01 07:28:00', '2019-04-01 07:28:00'),
(78, 213, 0, '0x9346a19ac4741f8c3b7698cd92dd17a5484aff5927e4748147282a831febbd20', '6.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"damMv3I98C242FeZLlmhe3t9uHUzjfnS\",\"buyerAddress\":\"0xab0874cB61D83F6B67Dc08141568868102233bef\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"6\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":213,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":18,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"damMv3I98C242FeZLlmhe3t9uHUzjfnS\\\",\\\"quantity\\\":\\\"5.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":211,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-01 13:09:51\\\",\\\"updated_at\\\":\\\"2019-04-01 13:10:29\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"213\",\"csrf_token\":\"3EAuzaePygeFSm15RorDFMhjSBgSot92GXsaG68N\"},\"txHash\":\"0x9346a19ac4741f8c3b7698cd92dd17a5484aff5927e4748147282a831febbd20\",\"trade_id\":\"213\",\"total_price\":\"6\"}', '2019-04-01 07:41:38', '2019-04-01 07:41:38'),
(79, 2, 0, '0x6628c7814f5a5da10714ab917c80e4b22da7d442edd9c16a64a7ad00b9c52b9a', '3.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"3\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":2,\\\"user_id\\\":43,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":4,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"CqZ3umIWpI1BYntHGL0aUJWlV53JiTp5\\\",\\\"quantity\\\":\\\"2.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":1,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-02 05:54:52\\\",\\\"updated_at\\\":\\\"2019-04-02 05:56:10\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"2\",\"csrf_token\":\"BWRDN1FIyOYDnorJshZ8DTWTy2hm5gDzyiIOiYsz\"},\"txHash\":\"0x6628c7814f5a5da10714ab917c80e4b22da7d442edd9c16a64a7ad00b9c52b9a\",\"trade_id\":\"2\",\"total_price\":\"3\"}', '2019-04-02 00:27:06', '2019-04-02 00:27:06'),
(80, 3, 0, '0xa69839175b096ae456365abf740bd5c7d656fba80cf0e5f27a0a54b545b379ae', '5.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"5\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":3,\\\"user_id\\\":4,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":4,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"azkNniRMPAz8WLMVki2R0lRp6EVP1cbZ\\\",\\\"quantity\\\":\\\"3.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"2.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":1,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-02 06:09:13\\\",\\\"updated_at\\\":\\\"2019-04-02 06:10:05\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"3\",\"csrf_token\":\"cat3VPOzGiw6HzRtGtk1Qwq1pOt14Foc7seZoWLO\"},\"txHash\":\"0xa69839175b096ae456365abf740bd5c7d656fba80cf0e5f27a0a54b545b379ae\",\"trade_id\":\"3\",\"total_price\":\"5\"}', '2019-04-02 00:42:41', '2019-04-02 00:42:41'),
(81, 5, 0, '0x3ed09dd0bfd6a469af0e16adbe69769f37099419cac5fffe9d6cdd3f59a3ba06', '35.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0x93572b4a32cc0f642ada98c9a69fd2c4c6255b6c\",\"depositeAddress\":\"35\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":5,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":8,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"jbTTxVkQVoARVMYlq9jayukyGFfNXQ7k\\\",\\\"quantity\\\":\\\"5.0000000000\\\",\\\"unit_price\\\":\\\"5.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"10.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":4,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-02 06:44:40\\\",\\\"updated_at\\\":\\\"2019-04-02 06:46:20\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"5\",\"csrf_token\":\"qnNXswHStE0SaCIYsCbVTIenZWL2yzkDDVEABiTk\"},\"txHash\":\"0x3ed09dd0bfd6a469af0e16adbe69769f37099419cac5fffe9d6cdd3f59a3ba06\",\"trade_id\":\"5\",\"total_price\":\"35\"}', '2019-04-02 01:53:01', '2019-04-02 01:53:01'),
(82, 5, 0, '0x5b795fb4cbecc0dc6db9a9739cab4866593203c3c8667706ead11c53e855bfe1', NULL, NULL, NULL, '2019-04-02 01:54:22', '2019-04-02 01:54:22'),
(83, 6, 0, '0xffb7e1ce20bf2e79bc7f245679cf6706162e978f6f8c16f631b83226119fa242', '77.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6\",\"buyerAddress\":\"0x93572B4A32cC0F642ada98C9A69FD2C4c6255b6c\",\"sellerAddress\":\"0x93572b4a32cc0f642ada98c9a69fd2c4c6255b6c\",\"depositeAddress\":\"77\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":6,\\\"user_id\\\":2,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":8,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"2e3qeQQHH9TPOPeTMDy6h3R9Vr58T2I6\\\",\\\"quantity\\\":\\\"15.0000000000\\\",\\\"unit_price\\\":\\\"5.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"2.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":4,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-02 08:57:32\\\",\\\"updated_at\\\":\\\"2019-04-02 08:58:58\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"6\",\"csrf_token\":\"pu0XeLkfJviKilGg3x8s6e68r7eU5OVcfynHc4Xb\"},\"txHash\":\"0xffb7e1ce20bf2e79bc7f245679cf6706162e978f6f8c16f631b83226119fa242\",\"trade_id\":\"6\",\"total_price\":\"77\"}', '2019-04-02 03:29:55', '2019-04-02 03:29:55'),
(84, 6, 0, '0xdfd38c00ee8a2f8e36dae44d112f6f1510ec56b4169ceb2bbd2c9bc3edd83325', NULL, NULL, NULL, '2019-04-02 03:35:53', '2019-04-02 03:35:53'),
(85, 11, 0, '0xa08e09f1825e3a482932078e38b3c2ee01a0a8b87796c431f017c20ef999bce5', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":11,\\\"user_id\\\":4,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":1,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":10,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-02 12:53:02\\\",\\\"updated_at\\\":\\\"2019-04-02 12:54:19\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"11\",\"csrf_token\":\"GdNp7jyREDw7nIsHAWR4HolC3CPg9Gzrr1YOPZqV\"},\"txHash\":\"0xa08e09f1825e3a482932078e38b3c2ee01a0a8b87796c431f017c20ef999bce5\",\"trade_id\":\"11\",\"total_price\":\"2\"}', '2019-04-02 07:25:47', '2019-04-02 07:25:47'),
(86, 11, 0, '0xad61eeadd7677f2655c8e60157f111897a680f55bd775e09e1e721519057c41f', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":11,\\\"user_id\\\":4,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":1,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"V1pYeY4mTwRkZshjrcmVz4JAFfdhrswR\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":10,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-02 12:53:02\\\",\\\"updated_at\\\":\\\"2019-04-02 12:54:19\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"11\",\"csrf_token\":\"GdNp7jyREDw7nIsHAWR4HolC3CPg9Gzrr1YOPZqV\"},\"txHash\":\"0xad61eeadd7677f2655c8e60157f111897a680f55bd775e09e1e721519057c41f\",\"trade_id\":\"11\",\"total_price\":\"2\"}', '2019-04-02 07:26:12', '2019-04-02 07:26:12'),
(87, 11, 0, '0xfbffd5e4ca55f062aa62fd0c8f334340ee0dabcb6c75dd9f39c54e2cdc7fbaf4', NULL, NULL, NULL, '2019-04-02 07:27:04', '2019-04-02 07:27:04'),
(88, 11, 0, '0x1a4722fe06eb5cb0b5acb541945c056813a6070a734a46043e7ea1269346f231', NULL, NULL, NULL, '2019-04-02 07:27:27', '2019-04-02 07:27:27'),
(89, 12, 0, '0xb1e5b0fe71706ed8d911531344f476805da47ecaddb0d5056cb1339b26624877', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"iXhmHV0SXgNGCiK386xqHI5JadNCweeB\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":12,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":14,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"iXhmHV0SXgNGCiK386xqHI5JadNCweeB\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":9,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-03 04:50:12\\\",\\\"updated_at\\\":\\\"2019-04-03 04:51:16\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"12\",\"csrf_token\":\"AbOR7S2klPdVFDysx68VKvwpUTMnMolpGKfQEzn8\"},\"txHash\":\"0xb1e5b0fe71706ed8d911531344f476805da47ecaddb0d5056cb1339b26624877\",\"trade_id\":\"12\",\"total_price\":\"2\"}', '2019-04-02 23:25:54', '2019-04-02 23:25:54'),
(90, 12, 0, '0xc7d7a8697d26b6129dc2db603bcb6f024b32c26b37f741794b509f8d1f492039', NULL, NULL, NULL, '2019-04-02 23:27:45', '2019-04-02 23:27:45'),
(91, 13, 0, '0xb5dc3567479d27f06ec22e56771904be46fa379f685b56e5d36173723b806cae', '2.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"2\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":13,\\\"user_id\\\":43,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":1,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"LzsFTiY20sTNgVgdJ48h2KdW9dUklOFX\\\",\\\"quantity\\\":\\\"1.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":10,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-03 05:09:03\\\",\\\"updated_at\\\":\\\"2019-04-03 05:12:51\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"13\",\"csrf_token\":\"cmBIbbeDdTZsMWWZBlr20vKacUlTUVnFkjkc8n95\"},\"txHash\":\"0xb5dc3567479d27f06ec22e56771904be46fa379f685b56e5d36173723b806cae\",\"trade_id\":\"13\",\"total_price\":\"2\"}', '2019-04-02 23:44:15', '2019-04-02 23:44:15'),
(92, 13, 0, '0x29492bdd647872a23370a7e24ac9b029a628a4f7ad826314b5cc110bf091790c', NULL, NULL, NULL, '2019-04-02 23:49:24', '2019-04-02 23:49:24'),
(93, 25, 0, '0xdbcc6d1820d61f6fc1cfc69829831f8844fe1beecd70d9fc3b810d473311cdf1', '7.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"7\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":25,\\\"user_id\\\":4,\\\"first_level_category_id\\\":2,\\\"second_level_category_id\\\":1,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"7wHMvKdaAkrtSFg7LPBSkX21X2XSwMUX\\\",\\\"quantity\\\":\\\"6.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":6,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":24,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-04 05:30:47\\\",\\\"updated_at\\\":\\\"2019-04-04 05:33:02\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"25\",\"csrf_token\":\"KeHYU8Ko9f8mhmGkkMZpVJmmRqmFet6q6WxtZK2C\"},\"txHash\":\"0xdbcc6d1820d61f6fc1cfc69829831f8844fe1beecd70d9fc3b810d473311cdf1\",\"trade_id\":\"25\",\"total_price\":\"7\"}', '2019-04-04 00:04:22', '2019-04-04 00:04:22');
INSERT INTO `trade_transaction_detail` (`id`, `trade_id`, `user_id`, `transaction_ref`, `total_price`, `payment_status`, `payment_data`, `created_at`, `updated_at`) VALUES
(94, 28, 0, '0x4c4fa1cd21e3c40b0c3acd1aedfc2ec4c7155bf26521daaaf74a9504d331e6ff', '6.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"6\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":28,\\\"user_id\\\":4,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":4,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"7cVvyOTXATJdHnLUaI3uuGQW2uwH5nzK\\\",\\\"quantity\\\":\\\"5.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":27,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-04 05:39:06\\\",\\\"updated_at\\\":\\\"2019-04-04 05:40:06\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"28\",\"csrf_token\":\"KeHYU8Ko9f8mhmGkkMZpVJmmRqmFet6q6WxtZK2C\"},\"txHash\":\"0x4c4fa1cd21e3c40b0c3acd1aedfc2ec4c7155bf26521daaaf74a9504d331e6ff\",\"trade_id\":\"28\",\"total_price\":\"6\"}', '2019-04-04 00:10:32', '2019-04-04 00:10:32'),
(95, 29, 0, '0xd8ff31c76bb8818a75369a0af462e335a2a8c90130e2fa46a12ae78bfbaeb4e2', '7.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"7\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":29,\\\"user_id\\\":43,\\\"first_level_category_id\\\":3,\\\"second_level_category_id\\\":4,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"Mcf5lQzrIbb6zTlooRCGJkPpkkylBMTe\\\",\\\"quantity\\\":\\\"6.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":5,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":27,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-04 05:39:23\\\",\\\"updated_at\\\":\\\"2019-04-04 05:41:41\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"29\",\"csrf_token\":\"7RB1GloIDTlTlCzqzvrOifJMjuAY0GBtuDcIHnAA\"},\"txHash\":\"0xd8ff31c76bb8818a75369a0af462e335a2a8c90130e2fa46a12ae78bfbaeb4e2\",\"trade_id\":\"29\",\"total_price\":\"7\"}', '2019-04-04 00:12:29', '2019-04-04 00:12:29'),
(96, 31, 0, '0x769d6dc0b67f0601dff0e254e90a43ec8ef1a58ede2a1c77952d539a8862d167', '20.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"20\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":31,\\\"user_id\\\":43,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":15,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"zJebPZtKS0hu1xmvrzdFpffA58tI2ZAg\\\",\\\"quantity\\\":\\\"19.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":30,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-04 06:20:30\\\",\\\"updated_at\\\":\\\"2019-04-04 06:21:02\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"31\",\"csrf_token\":\"7RB1GloIDTlTlCzqzvrOifJMjuAY0GBtuDcIHnAA\"},\"txHash\":\"0x769d6dc0b67f0601dff0e254e90a43ec8ef1a58ede2a1c77952d539a8862d167\",\"trade_id\":\"31\",\"total_price\":\"20\"}', '2019-04-04 00:51:32', '2019-04-04 00:51:32'),
(97, 32, 0, '0xd1a254e405f92b10ccf0cd3a23b726a205a68d625e871b847bdd5b8d771e93ac', '12.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"LaaR4gaj10q2PhAcg4cbgdCg6sUteahn\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"12\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":32,\\\"user_id\\\":4,\\\"first_level_category_id\\\":4,\\\"second_level_category_id\\\":15,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"LaaR4gaj10q2PhAcg4cbgdCg6sUteahn\\\",\\\"quantity\\\":\\\"11.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":7,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":30,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-04 06:42:34\\\",\\\"updated_at\\\":\\\"2019-04-04 06:43:58\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"32\",\"csrf_token\":\"7RB1GloIDTlTlCzqzvrOifJMjuAY0GBtuDcIHnAA\"},\"txHash\":\"0xd1a254e405f92b10ccf0cd3a23b726a205a68d625e871b847bdd5b8d771e93ac\",\"trade_id\":\"32\",\"total_price\":\"12\"}', '2019-04-04 01:14:13', '2019-04-04 01:14:13'),
(98, 34, 0, '0xc2450a703e9e228850eaffba428adf00567895b7c9094edd2c4e745dea57558a', '23.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"23\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":34,\\\"user_id\\\":4,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":6,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"Tunwgm0i6MWV0s2W7Ct5OWrYVfAyaMdk\\\",\\\"quantity\\\":\\\"22.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":33,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-04 06:49:09\\\",\\\"updated_at\\\":\\\"2019-04-04 06:49:57\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"34\",\"csrf_token\":\"7RB1GloIDTlTlCzqzvrOifJMjuAY0GBtuDcIHnAA\"},\"txHash\":\"0xc2450a703e9e228850eaffba428adf00567895b7c9094edd2c4e745dea57558a\",\"trade_id\":\"34\",\"total_price\":\"23\"}', '2019-04-04 01:21:02', '2019-04-04 01:21:02'),
(99, 35, 0, '0x1252e549374aa5fcca095f5164857acd1998a5822706b7ea0f3ee10089976811', '19.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"19\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":35,\\\"user_id\\\":43,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":6,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"Of57Yu0GFLgbgRu6zcbJUaOAteyEmyoa\\\",\\\"quantity\\\":\\\"18.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":33,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-04 06:53:08\\\",\\\"updated_at\\\":\\\"2019-04-04 06:53:39\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"35\",\"csrf_token\":\"vDVxBFlRoc0fGGv7rp82UfcC0K1PltqfIZRF1PqY\"},\"txHash\":\"0x1252e549374aa5fcca095f5164857acd1998a5822706b7ea0f3ee10089976811\",\"trade_id\":\"35\",\"total_price\":\"19\"}', '2019-04-04 01:24:13', '2019-04-04 01:24:13'),
(100, 37, 0, '0xce152d23929204e2eb41e137820eac05e14ae3cc6e379dbb1f74bc6870de841d', '11.0000000000', NULL, '{\"paymentData\":{\"trade_ref_id\":\"ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h\",\"buyerAddress\":\"0x0f276c3a192Ec0562c1d370a3830e6b03565efC9\",\"sellerAddress\":\"0xab0874cb61d83f6b67dc08141568868102233bef\",\"depositeAddress\":\"11\",\"tokenAddress\":\"0x7d66CDe53cc0A169cAE32712fC48934e610aeF14\",\"tradeRefData\":\"{\\\"id\\\":37,\\\"user_id\\\":28,\\\"first_level_category_id\\\":1,\\\"second_level_category_id\\\":6,\\\"third_level_category_id\\\":0,\\\"trade_ref\\\":\\\"ijB7vpAJXNnkM0aDVIcmsUfPUlDwUN5h\\\",\\\"quantity\\\":\\\"10.0000000000\\\",\\\"unit_price\\\":\\\"1.0000000000\\\",\\\"minimum_quantity\\\":null,\\\"sold_out_qty\\\":\\\"0.0000000000\\\",\\\"trade_status\\\":2,\\\"order_status\\\":0,\\\"trade_type\\\":0,\\\"unit_id\\\":3,\\\"handling_charges\\\":\\\"1.0000000000\\\",\\\"shipment_company_name\\\":\\\"\\\",\\\"tracking_id\\\":\\\"\\\",\\\"good_bill_of_loading\\\":null,\\\"delivery_proof\\\":null,\\\"other\\\":null,\\\"is_active\\\":1,\\\"linked_to\\\":33,\\\"is_finalized\\\":1,\\\"is_disputed\\\":null,\\\"trade_settlement_seller\\\":null,\\\"trade_settlement_buyer\\\":null,\\\"created_at\\\":\\\"2019-04-04 06:58:40\\\",\\\"updated_at\\\":\\\"2019-04-04 07:02:30\\\",\\\"deleted_at\\\":null}\",\"trade_id\":\"37\",\"csrf_token\":\"LdYo9CYgf0zv5JJZRbMgVx4Ewk7RbHQXN2O04oUH\"},\"txHash\":\"0xce152d23929204e2eb41e137820eac05e14ae3cc6e379dbb1f74bc6870de841d\",\"trade_id\":\"37\",\"total_price\":\"11\"}', '2019-04-04 01:37:00', '2019-04-04 01:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit`) VALUES
(1, 'bbl'),
(2, 'U.S.gal'),
(3, 'mmBTU'),
(4, 'Tons'),
(5, 'troyounce'),
(6, 'Metric Ton'),
(7, 'KG');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google2fa_secret` text COLLATE utf8_unicode_ci NOT NULL,
  `google2fa_status` int(11) NOT NULL COMMENT ' - enable, 0 - Disable',
  `permissions` text COLLATE utf8_unicode_ci,
  `is_active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `is_approved` tinyint(4) NOT NULL COMMENT '0 - Not Approved,1 - Approved, For Buyer by default 1, For seller admin will approve',
  `user_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(17) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image` text COLLATE utf8_unicode_ci,
  `country` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` int(12) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `google2fa_secret`, `google2fa_status`, `permissions`, `is_active`, `is_approved`, `user_type`, `last_login`, `user_name`, `first_name`, `last_name`, `phone`, `profile_image`, `country`, `street_address`, `state`, `city`, `zipcode`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'bhavana@imperialsoftech.com', '$2y$10$DdvUOCJ6ZqkQWzwZ/58Hwucgm4xf1VXsmH/AT7d8HQYMm/pDltpXm', '', 0, NULL, '', 0, 'admin', '2019-04-12 05:59:32', 'Admin', 'Bhavana', 'Shirude', NULL, '3e9b7cf1481eddb60375a8304a53a87556e8a7d8.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-12 05:59:32', NULL),
(2, 'sagar.imperialsoftech@gmail.com', '$2y$10$4WAtAB0kzuMgZ5BBI/L3oOdatqzF7Lqm332pnjijaO8/h2yJQCVMu', '6IWPYOEPSJVMJXH2', 0, NULL, '1', 1, 'buyer', '2019-04-12 04:14:40', 'Sagar Jadhav', 'sagar', 'Jadhav', '745454', '15511818615c7528254968e.jpg', NULL, 'Nashik, Maharashtra, India', NULL, NULL, NULL, '2019-02-25 01:06:51', '2019-04-12 04:14:40', NULL),
(3, 'vaguminero@eoffice.top', '$2y$10$YVXBNJfJijC./pQLzDrb8efKORU0rDqq8lC86OxAbtFl12dqJ5Bby', 'I5CCWRQJCWYLIGAS', 0, NULL, '1', 1, 'buyer', NULL, 'supriya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-02-25 01:46:10', '2019-04-01 05:14:13', NULL),
(4, 'kpriyanka.imperialsoftech@gmail.com', '$2y$10$nG7NZl34EIxuInRL.S63T.yCHm8LA698QH3P9MAp3lxJWMxejm3D6', 'X3KHYWVIHIYGJEK7', 0, NULL, '1', 1, 'buyer', '2019-04-11 22:41:03', 'Priyanka Kedare', 'Priyanka', 'Kedare', '111111111', '15523711885c874df40b1fb.jpg', NULL, 'Jail Road, Nashik, Maharashtra, India', NULL, NULL, NULL, '2019-02-25 03:46:04', '2019-04-11 22:41:03', NULL),
(5, 'gunegoh@directmail24.net', '$2y$10$M9SxDyPo6T01bz9H6UE0Nuq/S78WehCtYSUQOThev8NG2sWXGpbF2', 'DBMKXLYAMRGPYUR4', 0, NULL, '1', 1, 'buyer', '2019-02-25 03:49:02', 'jaydip', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-02-25 03:47:57', '2019-04-01 04:40:02', NULL),
(6, 'zutesawov@eoffice.top', '$2y$10$DOsgKdyOX3Z3ZT/kv9YPeuCK8aNtJcMVZ33zHNHrqDeBVeuPjxG56', '3FUOR47SDMTDJRRK', 0, NULL, '1', 1, 'seller', '2019-03-28 23:25:48', 'Vishal', NULL, NULL, '12123123', '15517764755c7e3adb6c332.png', NULL, 'Nashik, Maharashtra, India', NULL, NULL, NULL, '2019-02-25 22:21:58', '2019-03-28 23:25:48', NULL),
(7, 'mehulab@web-experts.net', '$2y$10$ohRjBit4tMjc38nlxfJ20OKaT0ClAPcIg5vz0omUXHzKjEAYGnwye', 'R36WAVG6PUC74YZQ', 0, NULL, '1', 1, 'seller', '2019-03-06 04:50:33', 'Gopal Jadhav', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-05 23:25:06', '2019-03-27 01:27:52', NULL),
(19, 'sadd@hm.com', '$2y$10$liDdjGoiXiKQfCN56lwkHOnQDvDuGES6L9.8uTA5B/74A2pULy8Au', '', 0, NULL, '1', 0, 'seller', NULL, 'asas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-08 04:49:18', '2019-03-08 05:32:27', '2019-03-08 05:32:27'),
(20, 'teeee@ff.sd', '$2y$10$e8InrkzNAYeUkgAlPD3Dh.lhRhy0w1C9WtOEIsTmov.I3XQFnGkYC', '', 0, NULL, '1', 0, 'seller', NULL, 'teeeeeeeeeee', NULL, NULL, NULL, '11928d3f05ef3ad104f8bfbf52715089df7f83b6.jpg', NULL, NULL, NULL, NULL, NULL, '2019-03-08 05:05:55', '2019-03-08 05:32:24', '2019-03-08 05:32:24'),
(21, 'testu@test.com', '$2y$10$PnS1t8cgcmt9Fdol1m4dNe8n3.eVY3U6XrdoBiCud0gljnbjcderC', '', 0, NULL, '1', 1, 'buyer', '2019-03-08 05:33:35', 'test', 'test', 'test', '1234567890', '7a4540090dfbd509eced3d3d316be95cc7ce2d8d.jpg', NULL, NULL, NULL, NULL, NULL, '2019-03-08 05:32:57', '2019-03-27 01:27:49', NULL),
(22, 'jaydip.imperialsoftech@gmail.com', '$2y$10$i/B6G2Hgdw6PkYJ6PnG4LeNW3HFjCD/n5MoUXoJBNdvxYTLRtX5/e', 'ZUOAVAVFOT3TU337', 0, NULL, '1', 1, 'seller', '2019-04-12 23:03:47', 'Jaydip', NULL, NULL, '1234567890', NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-10 23:46:40', '2019-04-12 23:03:47', NULL),
(23, 'bonogi@quick-mail.online', '$2y$10$nt.ZkhzA.QgewQv53CmzIewi3TiU4swUelghoO.ctssELksilejGG', '2VGDXEYAMA5C2YVY', 0, NULL, '1', 1, 'seller', '2019-03-16 06:14:31', 'pradip', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-16 03:39:09', '2019-04-01 04:35:05', '2019-04-01 04:35:05'),
(24, 'zotojon@placemail.online', '$2y$10$MIwQc.556i1YVfECOC5zdeSpXFOD5QTAALezJmHWiRMcFm0osV14u', 'JCNT6PNXQ2J66JR2', 0, NULL, '1', 1, 'seller', '2019-03-26 03:30:56', 'Suyash', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-22 04:54:16', '2019-03-27 01:16:52', NULL),
(25, 'musugozi@networkapps.info', '$2y$10$pgduJYZRuuvoRypEs9tFrueX3Rp3L5wEv/Uwm26W07goX1S.2Qvz.', 'XGEPAAZIJHMOKMAE', 0, NULL, '1', 1, 'buyer', '2019-04-11 05:42:44', 'Deepali', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-22 04:56:07', '2019-04-11 05:42:44', NULL),
(27, 'fuwe@network-source.com', '$2y$10$/ctMksW2k5K4VLIz2.qFYO6kjxlZYCDRJRjm1VCuNgQm5JyjukRCy', 'DTWSB6ICSLOKLBPT', 0, NULL, '1', 1, 'seller', NULL, 'Ashish', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-26 23:43:46', '2019-03-27 01:16:46', NULL),
(28, 'yeluwokus@net-solution.info', '$2y$10$1O1uAM2489hpa7GC0ZsObO3XHbwFc8AFoBv4Foq0mIojeLGlskr4a', 'WCEKHLJ2UMDLH6FT', 0, NULL, '1', 1, 'buyer', '2019-04-04 01:35:51', 'Savi', NULL, NULL, '121212121212', NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-26 23:45:09', '2019-04-04 01:36:43', NULL),
(29, 'carozawa@mailfavorite.com', '$2y$10$sPmn90csii.kPAhL7cbngOnlJyp8eDCd82ioWqPyP2VlBpicaroqi', 'I4FOWZ45S5JJU7KB', 0, NULL, '1', 1, 'seller', '2019-03-27 01:18:31', 'Kavita', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 00:06:59', '2019-03-27 01:18:31', NULL),
(30, 'pudelopo@networkapps.info', '$2y$10$B3P4po2tr4If3kwv1BQwTeQWYLDgM2dArxE98TrII.qfgATF7/mI6', 'QL4X24MPOLZBKGSD', 0, NULL, '1', 1, 'seller', '2019-03-27 01:18:42', 'Sanjana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 00:14:32', '2019-03-27 01:27:07', NULL),
(31, 'petyteja@getnada.com', '$2y$10$4PYa5okw6QNlTFYjihOUpO92Nj8bEYW99vh7Sbrzgk.dXeU1Mu4Pm', 'IHISYS47CBSJF6RJ', 0, NULL, '1', 1, 'seller', NULL, 'preeti', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 01:31:05', '2019-04-01 04:32:37', NULL),
(32, 'ralucesi@postemail.net', '$2y$10$TU3hz7z5u.Oa9hdd72psQeyWiW9dhQxZgUb.fHf8EDNRmz1zUrf0W', '32GQVEB2CP4DGVSM', 0, NULL, '1', 1, 'seller', '2019-03-27 01:35:48', 'Rasika', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 01:32:29', '2019-03-27 01:35:48', NULL),
(33, 'bhavassdasdna.imperialsoftech@gmail.com', '$2y$10$UXFUMQ8SacFD04Sqk5KbJ.Xr.jlhGpQGjfuAJfncJys3PMps6n3Aa', 'Z4KDRAMV2VPV7L7C', 0, NULL, '1', 1, 'buyer', '2019-04-01 04:07:26', 'Nayan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 01:34:44', '2019-04-01 04:07:26', NULL),
(34, 'yuyavisuj@networkapps.info', '$2y$10$SuD6hs9q18zFAwAzmMa3.uvHogTXOoe8IFdoGEvnYmxY.XpRSTQrW', 'VKVS7KKMFVPMVLNH', 0, NULL, '1', 1, 'seller', NULL, 'Akshay', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 03:40:11', '2019-03-27 04:36:23', NULL),
(35, 'favolija@networkapps.info', '$2y$10$bMMAbZzX65pjipvQUR6J8eXfiHqdNDbpZQ5Lpt56o1Ut/L2WliQt2', 'BPSVIZ7MHBNSMMTX', 0, NULL, '1', 1, 'seller', NULL, 'Sima', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 03:42:21', '2019-03-27 04:36:41', NULL),
(36, 'cogadusodu@gift-link.com', '$2y$10$I9gUl6LCxsg5oTYwK8HsEeTU89q7TDKQkxyN71hkykKjqa7WZoTbG', '6U6T37JMY7TIT3TC', 0, NULL, '1', 1, 'seller', NULL, 'Sujay', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 03:43:42', '2019-03-27 04:37:00', NULL),
(37, 'comonod@myfavorite.info', '$2y$10$5m6VPoCDyoVvvFOKVLuxKOxVQ5389j4JsrcMYx2UM2oY6LBHprzfq', 'JGIFM3DM4U4QTCAA', 0, NULL, '1', 1, 'seller', NULL, 'Saurabh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 03:44:38', '2019-03-27 05:05:58', NULL),
(38, 'ruhega@world-travel.online', '$2y$10$cs17L9EtzNaFnOMGqS.M7epmQNXCVTSmlbkzRRwnWTjh/pLzQFlGO', 'NQPJ5RH4PW7F5E3N', 0, NULL, '1', 1, 'seller', NULL, 'Ruhi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 03:48:21', '2019-03-27 04:53:41', NULL),
(39, 'yokolucu@net-solution.info', '$2y$10$Kx95xLCZsY8jCRdP8TVrlOH4AGyC08IP7lzVol93K.biPETflBK6.', 'RCNOPGM3A6SPKTPL', 0, NULL, '1', 1, 'seller', NULL, 'Niharika', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 03:50:07', '2019-03-27 04:54:17', NULL),
(40, 'mazepoga@network-source.com', '$2y$10$HcS/AcZe/ThOHx84k59soOrMUmx2yfRj9iJJE.adQSb2oa/lkSVau', '3Z3OI75KHVXNV6U5', 0, NULL, '1', 1, 'seller', NULL, 'Saniya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 03:58:48', '2019-03-27 04:56:18', NULL),
(41, 'saledobow@networkapps.info', '$2y$10$ptaLSG1Yd3R9WdWLYFjqwOnIBtSONuLGj7UXTKVq7oK48yCFL0QWK', 'FRB6N546WRIR2OJP', 0, NULL, '1', 1, 'seller', '2019-04-01 03:56:40', 'Siri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-03-27 04:23:28', '2019-04-01 03:56:40', NULL),
(42, 'bhavana.imperialsoftech@gmail.com', '$2y$10$sd3VxzwdtlkSWyLBcVTx3OviGdtsWj5VvTcxmsTfVou.4UIM04N4y', 'L2HGDOIO2S64I2A5', 0, NULL, '1', 1, 'seller', '2019-04-08 03:52:54', 'Bhavana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-01 04:14:29', '2019-04-08 03:52:54', NULL),
(43, 'vishal.imperialsoftech@gmail.com', '$2y$10$7vncIGnm6QTVu9JOxFQpr.Q0FwT.DDkby3NUoFDKv.DcOmiQ6HGXG', 'WHZY5ZNIP7FQBX3D', 0, NULL, '1', 1, 'buyer', '2019-04-08 07:30:58', 'Vishal', NULL, NULL, '112356', NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-01 04:22:12', '2019-04-08 07:30:58', NULL),
(44, 'seller@getnada.com', '$2y$10$zqUit1nQ0VLTughg3LZxBuNKUqI/nqPNBaw4D0Qv2JDB6n9/MYDtK', '362P3O6ZXPU75H4I', 0, NULL, '1', 0, 'seller', NULL, 'seller sagar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-02 01:05:44', '2019-04-02 01:05:44', NULL),
(45, 'lojeveli@5-mail.info', '$2y$10$gHvyasnicftUtxm0eqnjSOMMp6w6H.2brjnyxCtmFl1//7u.3D49.', 'SP6X5CKJMKO6MFIK', 0, NULL, '1', 1, 'seller', '2019-04-02 03:26:13', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-02 01:07:25', '2019-04-02 03:26:13', NULL),
(46, 'rakesh@gmail.com', '$2y$10$4e1edRKCc.gLk5E6PimrW.QnWaMXPplKjBspuatsF/EybiNFMWIEW', '', 0, NULL, '1', 1, 'buyer', NULL, 'rakesh', NULL, NULL, NULL, '7081b16a4f207e8c44380e89d8394f7672063ec3.png', NULL, NULL, NULL, NULL, NULL, '2019-04-03 00:29:51', '2019-04-03 00:29:51', NULL),
(47, 'bachhan@gmail.com', '$2y$10$zppaFpNopTwkALXPou0jkO.mgNOGjsr80HH2jyYLD4Pv9v2.huokm', '', 0, NULL, '1', 1, 'buyer', NULL, 'amitabh', NULL, NULL, NULL, '0b783996a47eaf72b30ad9baec65b9390fa5d4ee.png', NULL, NULL, NULL, NULL, NULL, '2019-04-03 00:30:32', '2019-04-03 00:30:32', NULL),
(48, 'sigezoho@mail-register.com', '$2y$10$O2kR2GZVPCu3XNnLLaEGwOdVrPwOLcZwUFZFPNXHk1LNDWkOR.kS6', 'I2TJAPHQHG4VDRCK', 0, NULL, '1', 1, 'buyer', '2019-04-11 05:52:01', 'Simran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-09 01:12:39', '2019-04-11 05:52:01', NULL),
(49, 'zuwinazic@mail-register.com', '$2y$10$QOfASTJJlefN7ENYi7aJROn8UmuHMRX4BdfhxrVO8iH093ODqFUem', 'BDCNF6NUEVEE5GNZ', 0, NULL, '1', 1, 'buyer', NULL, 'Ziva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-09 01:20:31', '2019-04-09 01:32:45', NULL),
(50, 'poonam@gmail.com', '$2y$10$eWp1LPw9uSRW.lDBuK7KLeeenvvSKwpPNbKbQ.MNN6OCJ.DBpRldG', '', 0, NULL, '1', 1, 'buyer', '2019-04-12 04:04:13', 'poonam sharma', NULL, NULL, NULL, '3019db8c79cfad5bcddabc9d05fa6ae11aa6e04c.png', NULL, NULL, NULL, NULL, NULL, '2019-04-11 23:23:54', '2019-04-12 04:04:13', NULL),
(51, 'tester@tester.tester', '$2y$10$kCRA3Z8bG0csGVpT5cfvY.yc2a1uupd7YTrJXUy6hWktBYinYAztO', '7E4Y75P6IQWVUPOC', 0, NULL, '1', 0, 'both', NULL, 'tester', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-04-12 05:56:27', '2019-04-12 05:56:27', NULL),
(52, 'testu@testu.testu', '$2y$10$.DswKYfak/4arknFLxy/bOEA0uU2haOIbjvsPIW1jl46B6yoRJv7u', '', 0, NULL, '1', 0, 'both', NULL, 'testu', NULL, NULL, NULL, '4172a5cf47b5244735e6812d50ac4835f0196047.jpeg', NULL, NULL, NULL, NULL, NULL, '2019-04-12 06:01:18', '2019-04-12 06:13:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_shipping_address`
--

CREATE TABLE `user_shipping_address` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'user id from user table (it will be buyer or seller)',
  `address` text NOT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lng` decimal(11,8) NOT NULL,
  `post_code` varchar(255) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_shipping_address`
--

INSERT INTO `user_shipping_address` (`id`, `user_id`, `address`, `lat`, `lng`, `post_code`, `country_id`, `state`, `city`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 16, 'Lohoner - Vasol Road, Lohoner, Maharashtra, India', '20.51316220', '74.20719450', '423301', 99, 'Maharashtra', 'Lohoner', '2019-03-08 04:37:04', '2019-03-08 04:37:04', NULL),
(2, 17, 'Sea View, Jamestown, Saint Helena, Ascension and Tristan da Cunha', '-15.94630070', '-5.70433270', 'STHL 1ZZ', 179, 'Saint Helena', 'Jamestown', '2019-03-08 04:46:39', '2019-03-08 04:46:39', NULL),
(3, 20, 'Gujarat State Highway 41, Dharm Nagar II, Keshav Nagar, Ahmedabad, Gujarat, India', '23.07554810', '23.07554810', '400053', 99, 'Gujarat', 'Ahmedabad', '2019-03-08 05:06:00', '2019-03-08 05:26:43', NULL),
(4, 21, 'Sano By-pass, Shimohanedacho, Sano, Tochigi Prefecture, Japan', '36.28948050', '139.54975230', '327-0044', 107, 'Tochigi-ken', 'Sano', '2019-03-08 05:33:02', '2019-03-08 05:33:02', NULL),
(5, 4, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-08 06:20:17', '2019-03-08 06:20:17', NULL),
(6, 22, 'Surat, Gujarat, India', '21.17024010', '72.83106070', NULL, 99, 'Gujarat', 'Surat', '2019-03-10 23:46:40', '2019-03-10 23:46:40', NULL),
(7, 2, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-11 07:28:40', '2019-03-11 07:28:40', NULL),
(8, 23, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-16 03:39:09', '2019-03-16 03:39:09', NULL),
(9, 24, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-22 04:54:17', '2019-03-22 04:54:17', NULL),
(10, 25, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-22 04:56:07', '2019-03-22 04:56:07', NULL),
(11, 26, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-22 05:05:02', '2019-03-22 05:05:02', NULL),
(12, 27, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-26 23:43:47', '2019-03-26 23:43:47', NULL),
(13, 28, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-26 23:45:09', '2019-03-26 23:45:09', NULL),
(14, 29, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 00:06:59', '2019-03-27 00:06:59', NULL),
(15, 30, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 00:14:33', '2019-03-27 00:15:54', NULL),
(16, 31, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 01:31:06', '2019-03-27 01:31:06', NULL),
(17, 32, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 01:32:29', '2019-03-27 01:32:29', NULL),
(18, 33, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 01:34:44', '2019-03-27 01:34:44', NULL),
(19, 34, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 03:40:12', '2019-03-27 03:40:12', NULL),
(20, 35, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 03:42:22', '2019-03-27 03:42:22', NULL),
(21, 36, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 03:43:43', '2019-03-27 03:43:43', NULL),
(22, 37, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 03:44:38', '2019-03-27 03:44:38', NULL),
(23, 38, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 03:48:21', '2019-03-27 03:48:21', NULL),
(24, 39, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 03:50:08', '2019-03-27 03:50:08', NULL),
(25, 40, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 03:58:48', '2019-03-27 03:58:48', NULL),
(26, 41, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-03-27 04:23:28', '2019-03-27 04:23:28', NULL),
(27, 42, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-04-01 04:14:30', '2019-04-01 04:14:30', NULL),
(28, 43, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-04-01 04:22:12', '2019-04-01 04:22:12', NULL),
(29, 44, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', '422009', 99, 'Maharashtra', 'Nashik', '2019-04-02 01:05:44', '2019-04-02 01:05:44', NULL),
(30, 45, 'Pune, Maharashtra, India', '18.52043030', '73.85674370', NULL, 99, 'Maharashtra', 'Pune', '2019-04-02 01:07:25', '2019-04-02 01:07:25', NULL),
(31, 48, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-04-09 01:12:40', '2019-04-09 01:12:40', NULL),
(32, 49, 'Nashik, Maharashtra, India', '19.99745330', '73.78980230', NULL, 99, 'Maharashtra', 'Nashik', '2019-04-09 01:20:31', '2019-04-09 01:20:31', NULL),
(33, 50, 'Lahore-Islamabad Motorway, Pakistan', '32.35896100', '32.35896100', NULL, 162, 'Punjab', NULL, '2019-04-11 23:23:54', '2019-04-11 23:26:35', NULL),
(34, 51, 'SDSSécurité, Birkhadem, Algeria', '36.72254690', '3.03835700', NULL, 3, 'Wilaya d\'Alger', 'Birkhadem', '2019-04-12 05:56:28', '2019-04-12 05:56:28', NULL),
(35, 52, 'Lohoner - Vasol Road, Lohoner, Maharashtra, India', '20.51316220', '20.51316220', '423301', 99, 'Maharashtra', 'Lohoner', '2019-04-12 06:01:19', '2019-04-12 06:05:27', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blockchain_transactions`
--
ALTER TABLE `blockchain_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_translation`
--
ALTER TABLE `city_translation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_enquiry`
--
ALTER TABLE `contact_enquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_logs`
--
ALTER TABLE `cron_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_translation`
--
ALTER TABLE `faq_translation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `first_level_category`
--
ALTER TABLE `first_level_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keyword_translations`
--
ALTER TABLE `keyword_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_phrases`
--
ALTER TABLE `language_phrases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `to_user_id` (`to_user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `persistences`
--
ALTER TABLE `persistences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persistences_code_unique` (`code`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Indexes for table `second_level_category`
--
ALTER TABLE `second_level_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_level_category_id` (`first_level_category_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`site_setting_id`);

--
-- Indexes for table `slider_images`
--
ALTER TABLE `slider_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state_translation`
--
ALTER TABLE `state_translation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `static_pages`
--
ALTER TABLE `static_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `static_pages_translation`
--
ALTER TABLE `static_pages_translation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `third_level_category`
--
ALTER TABLE `third_level_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_level_category_id` (`first_level_category_id`),
  ADD KEY `second_level_category_id` (`second_level_category_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `throttle`
--
ALTER TABLE `throttle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `throttle_user_id_index` (`user_id`);

--
-- Indexes for table `trade`
--
ALTER TABLE `trade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `first_level_category_id` (`first_level_category_id`),
  ADD KEY `second_level_category_id` (`second_level_category_id`),
  ADD KEY `third_level_category_id` (`third_level_category_id`),
  ADD KEY `seller_user_id` (`user_id`),
  ADD KEY `linked_to` (`linked_to`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `trade_buy_history`
--
ALTER TABLE `trade_buy_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trade_chat_history`
--
ALTER TABLE `trade_chat_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`sender_id`),
  ADD KEY `buyer_id` (`receiver_id`),
  ADD KEY `trade_id` (`trade_id`);

--
-- Indexes for table `trade_dispute`
--
ALTER TABLE `trade_dispute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trade_ratings`
--
ALTER TABLE `trade_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_user_id`),
  ADD KEY `buyer_id` (`buyer_user_id`),
  ADD KEY `trade_id` (`trade_id`);

--
-- Indexes for table `trade_transaction_detail`
--
ALTER TABLE `trade_transaction_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trade_id` (`trade_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_shipping_address`
--
ALTER TABLE `user_shipping_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activations`
--
ALTER TABLE `activations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blockchain_transactions`
--
ALTER TABLE `blockchain_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `city_translation`
--
ALTER TABLE `city_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contact_enquiry`
--
ALTER TABLE `contact_enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `cron_logs`
--
ALTER TABLE `cron_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `faq_translation`
--
ALTER TABLE `faq_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `first_level_category`
--
ALTER TABLE `first_level_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `keyword_translations`
--
ALTER TABLE `keyword_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `language_phrases`
--
ALTER TABLE `language_phrases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `persistences`
--
ALTER TABLE `persistences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1443;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `second_level_category`
--
ALTER TABLE `second_level_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `site_setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slider_images`
--
ALTER TABLE `slider_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `state_translation`
--
ALTER TABLE `state_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `static_pages`
--
ALTER TABLE `static_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `static_pages_translation`
--
ALTER TABLE `static_pages_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `third_level_category`
--
ALTER TABLE `third_level_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `trade`
--
ALTER TABLE `trade`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `trade_buy_history`
--
ALTER TABLE `trade_buy_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trade_chat_history`
--
ALTER TABLE `trade_chat_history`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `trade_dispute`
--
ALTER TABLE `trade_dispute`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `trade_ratings`
--
ALTER TABLE `trade_ratings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `trade_transaction_detail`
--
ALTER TABLE `trade_transaction_detail`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_shipping_address`
--
ALTER TABLE `user_shipping_address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
