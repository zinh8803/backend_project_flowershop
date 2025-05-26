-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2025 at 02:47 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flower_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image_url`, `created_at`, `updated_at`) VALUES
(3, 'Hoa Tình Yêu', 'assets/categories_image/1745683543.png', '2025-03-26 08:24:07', '2025-04-26 09:05:43'),
(4, 'Hoa Sinh Nhật', 'assets/categories_image/1745683601.png', '2025-03-26 09:27:29', '2025-04-26 09:06:41'),
(5, 'Hoa Chúc Mừng', 'assets/categories_image/1745683613.png', '2025-03-26 09:27:33', '2025-04-26 09:06:53');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'xanh', NULL, NULL),
(2, 'đỏ', NULL, NULL),
(3, 'cam', NULL, NULL),
(4, 'trắng', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `color_product`
--

CREATE TABLE `color_product` (
  `product_id` bigint UNSIGNED NOT NULL,
  `color_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','percentage') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `usage_limit` int DEFAULT NULL,
  `usage_count` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `code`, `type`, `value`, `start_date`, `end_date`, `created_at`, `updated_at`, `usage_limit`, `usage_count`) VALUES
(1, 'zinh', 'percentage', '20.00', '2025-03-10 00:00:00', '2025-03-30 00:00:00', '2025-03-26 07:37:19', '2025-03-26 07:37:19', NULL, 0),
(2, 'zinh1', 'fixed', '20.00', '2025-03-10 00:00:00', '2025-03-30 00:00:00', '2025-03-26 07:39:20', '2025-03-26 07:39:20', NULL, 0),
(3, 'SUPERCODE', 'percentage', '20.00', '2025-04-16 00:00:00', '2025-04-20 00:00:00', '2025-04-15 10:22:56', '2025-04-15 10:22:56', NULL, 0),
(4, 'test', 'percentage', '20.00', '2025-05-10 00:00:00', '2025-05-20 00:00:00', '2025-05-09 19:12:54', '2025-05-09 19:12:54', 10, 0),
(5, 'fixed1', 'fixed', '1000000.00', '2025-05-10 00:00:00', '2025-05-20 00:00:00', '2025-05-09 21:59:00', '2025-05-09 21:59:00', 100, 0);

-- --------------------------------------------------------

--
-- Table structure for table `discount_conditions`
--

CREATE TABLE `discount_conditions` (
  `id` bigint UNSIGNED NOT NULL,
  `discount_id` bigint UNSIGNED NOT NULL,
  `min_order_total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_conditions`
--

INSERT INTO `discount_conditions` (`id`, `discount_id`, `min_order_total`, `created_at`, `updated_at`) VALUES
(1, 4, '500000.00', '2025-05-09 19:12:54', '2025-05-09 19:12:54'),
(2, 5, '10000.00', '2025-05-09 21:59:00', '2025-05-09 21:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `password`, `address`, `phone_number`, `position_id`, `created_at`, `updated_at`) VALUES
(1, 'Quốc Vinh', 'vinhad@gmail.com', '$2y$12$Q4HoCnd.LOKY8fgrqxLVse1g49hzMwSVwadXcUqFFX0RTD4aRV.vC', NULL, NULL, 2, '2025-03-24 07:48:18', '2025-03-28 01:38:11'),
(2, 'Vinh', 'vinh@gmail.com', '$2y$12$j/BAI/AOgh2iP3J8BByU2eynnjKfNFE6AISPQGd.6WMm73pT/mi7i', NULL, NULL, 1, '2025-03-24 07:49:22', '2025-03-24 07:49:22'),
(3, 'Vinh', 'vinh1@gmail.com', '$2y$12$8kRHbjRRWZ.UOIQIVyMtleUX//r91tYp1xUSYGlyyKEhJFYFZ25Ae', NULL, NULL, 1, '2025-03-24 07:49:52', '2025-03-24 07:49:52'),
(10, 'vinh shiper', 'vinhshiper@gmail.com', '$2y$12$1n2ta6N7hWaz17KAxSjU7.dmC2Ei/H981pIQ71bELAvpeqeFNRPCW', '123 Street', '0123456789', 3, '2025-04-18 09:45:29', '2025-04-18 09:45:29'),
(11, 'ádasd', 'shiper@gmail.com', '$2y$12$1n2ta6N7hWaz17KAxSjU7.dmC2Ei/H981pIQ71bELAvpeqeFNRPCW', '3123123', '312312312321', 3, '2025-05-03 22:45:09', '2025-05-03 22:45:09'),
(12, 'admin', 'admin@gmail.com', '$2y$12$TB1Qu7nyIRCWRjg9CvbP8uVMhYg28ft9RMaXaVmntQME1jr/WKIo.', 'sg', '0123456789', 1, '2025-05-03 22:49:12', '2025-05-03 23:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `employee_category`
--

CREATE TABLE `employee_category` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_category`
--

INSERT INTO `employee_category` (`id`, `employee_id`, `category_id`, `action`, `created_at`, `updated_at`) VALUES
(2, 1, 3, 'add', '2025-03-26 08:24:07', '2025-03-26 08:24:07'),
(10, 1, 4, 'add', '2025-03-26 09:27:29', '2025-03-26 09:27:29'),
(11, 1, 5, 'add', '2025-03-26 09:27:33', '2025-03-26 09:27:33'),
(13, 1, 4, 'update', '2025-04-18 07:33:47', '2025-04-18 07:33:47'),
(14, 1, 5, 'update', '2025-04-18 07:34:40', '2025-04-18 07:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `employee_product`
--

CREATE TABLE `employee_product` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_product`
--

INSERT INTO `employee_product` (`id`, `employee_id`, `product_id`, `action`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'create', '2025-03-26 09:34:03', '2025-03-26 09:34:03'),
(2, 1, 2, 'update', '2025-03-26 09:34:42', '2025-03-26 09:34:42'),
(3, 1, 3, 'create', '2025-04-11 05:44:53', '2025-04-11 05:44:53'),
(4, 1, 4, 'create', '2025-04-11 05:44:59', '2025-04-11 05:44:59'),
(5, 1, 5, 'create', '2025-04-11 05:45:04', '2025-04-11 05:45:04'),
(6, 1, 6, 'create', '2025-04-11 05:45:10', '2025-04-11 05:45:10'),
(7, 1, 2, 'update', '2025-04-11 05:57:43', '2025-04-11 05:57:43'),
(8, 1, 2, 'update', '2025-04-11 05:57:49', '2025-04-11 05:57:49'),
(9, 1, 3, 'update', '2025-04-11 05:57:58', '2025-04-11 05:57:58'),
(10, 1, 4, 'update', '2025-04-11 05:58:03', '2025-04-11 05:58:03'),
(11, 1, 4, 'update', '2025-04-11 05:58:10', '2025-04-11 05:58:10'),
(12, 1, 5, 'update', '2025-04-11 05:58:16', '2025-04-11 05:58:16'),
(13, 1, 5, 'update', '2025-04-11 05:58:24', '2025-04-11 05:58:24'),
(14, 1, 7, 'create', '2025-04-11 07:24:02', '2025-04-11 07:24:02'),
(15, 1, 8, 'create', '2025-04-11 08:01:46', '2025-04-11 08:01:46'),
(16, 1, 9, 'create', '2025-04-11 08:19:04', '2025-04-11 08:19:04'),
(17, 1, 2, 'update', '2025-04-18 07:37:56', '2025-04-18 07:37:56'),
(27, 2, 3, 'update', '2025-05-05 07:46:16', '2025-05-05 07:46:16'),
(28, 2, 4, 'update', '2025-05-05 07:47:04', '2025-05-05 07:47:04'),
(29, 2, 5, 'update', '2025-05-05 07:47:59', '2025-05-05 07:47:59'),
(30, 2, 6, 'update', '2025-05-05 07:48:50', '2025-05-05 07:48:50'),
(31, 2, 6, 'update', '2025-05-05 07:49:04', '2025-05-05 07:49:04'),
(32, 2, 6, 'update', '2025-05-05 07:50:03', '2025-05-05 07:50:03'),
(33, 2, 7, 'update', '2025-05-05 07:51:12', '2025-05-05 07:51:12'),
(34, 2, 7, 'update', '2025-05-05 07:51:18', '2025-05-05 07:51:18'),
(35, 2, 7, 'update', '2025-05-05 07:52:05', '2025-05-05 07:52:05'),
(36, 2, 7, 'update', '2025-05-05 07:52:13', '2025-05-05 07:52:13'),
(37, 2, 7, 'update', '2025-05-05 07:52:20', '2025-05-05 07:52:20'),
(38, 2, 9, 'update', '2025-05-05 07:53:49', '2025-05-05 07:53:49'),
(39, 2, 9, 'update', '2025-05-05 07:53:58', '2025-05-05 07:53:58'),
(40, 2, 6, 'update', '2025-05-05 07:54:31', '2025-05-05 07:54:31'),
(41, 2, 10, 'update', '2025-05-05 07:55:21', '2025-05-05 07:55:21'),
(42, 2, 8, 'update', '2025-05-05 07:56:07', '2025-05-05 07:56:07'),
(43, 2, 8, 'update', '2025-05-05 07:56:19', '2025-05-05 07:56:19'),
(44, 2, 8, 'update', '2025-05-05 07:56:27', '2025-05-05 07:56:27'),
(45, 2, 8, 'update', '2025-05-05 07:56:34', '2025-05-05 07:56:34'),
(46, 2, 2, 'update', '2025-05-05 10:15:36', '2025-05-05 10:15:36'),
(47, 2, 2, 'update', '2025-05-05 10:15:42', '2025-05-05 10:15:42'),
(48, 2, 2, 'update', '2025-05-05 10:17:28', '2025-05-05 10:17:28');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` bigint UNSIGNED NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Cúc calimero hồng', NULL, NULL),
(2, 'Hồng đỏ Pháp', NULL, NULL),
(3, 'Cúc mai hồng', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `order_id`, `employee_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-03-26 10:10:49', '2025-03-26 10:10:49'),
(2, 1, 1, '2025-03-26 10:11:35', '2025-03-26 10:11:35'),
(3, 1, 1, '2025-03-26 10:11:48', '2025-03-26 10:11:48'),
(4, 1, 1, '2025-04-03 11:15:19', '2025-04-03 11:15:19'),
(5, 2, 1, '2025-04-19 10:39:25', '2025-04-19 10:39:25'),
(6, 3, 1, '2025-04-19 10:39:55', '2025-04-19 10:39:55'),
(7, 5, 1, '2025-04-26 00:39:31', '2025-04-26 00:39:31'),
(10, 83, 2, '2025-05-05 02:19:34', '2025-05-05 02:19:34'),
(11, 82, 2, '2025-05-05 03:03:47', '2025-05-05 03:03:47'),
(12, 83, 2, '2025-05-05 03:04:25', '2025-05-05 03:04:25'),
(13, 83, 2, '2025-05-05 03:07:05', '2025-05-05 03:07:05'),
(14, 83, 2, '2025-05-05 03:08:42', '2025-05-05 03:08:42'),
(15, 83, 2, '2025-05-05 03:08:56', '2025-05-05 03:08:56'),
(16, 83, 2, '2025-05-05 03:12:45', '2025-05-05 03:12:45'),
(17, 77, 10, '2025-05-05 07:21:09', '2025-05-05 07:21:09'),
(18, 73, 11, '2025-05-05 07:40:31', '2025-05-05 07:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_02_18_113819_create_categories_table', 1),
(6, '2025_02_18_113829_create_products_table', 1),
(7, '2025_02_18_113837_create_discounts_table', 1),
(8, '2025_02_18_113838_create_orders_table', 1),
(9, '2025_02_18_113848_create_order_items_table', 1),
(10, '2025_02_18_113915_create_product_discounts_table', 1),
(11, '2025_03_07_151130_add_avatar_to_users_table', 1),
(12, '2025_03_10_050507_update_product_discounts_table', 1),
(13, '2025_03_10_051304_add_dates_to_product_discounts_table', 1),
(14, '2025_03_23_172705_add_fields_to_users_table', 1),
(15, '2025_03_24_091726_remove_fields_to_users_table', 1),
(16, '2025_03_24_093028_add_stock_to_products_table', 1),
(17, '2025_03_24_094821_create_positions_table', 1),
(18, '2025_03_24_094831_create_employees_table', 1),
(19, '2025_03_24_094836_add_customer_info_to_orders_table', 1),
(20, '2025_03_24_094837_create_schedules_table', 1),
(21, '2025_03_24_095432_create_invoices_table', 1),
(22, '2025_03_24_100153_create_employee_category_table', 1),
(23, '2025_03_24_100153_create_employee_product_table', 1),
(25, '2025_03_26_065921_update_shift_info_to_schedules_table', 2),
(26, '2025_03_26_152007_add_action_to_employee_product', 3),
(27, '2025_03_26_152023_add_action_to_employee_category', 3),
(28, '2025_03_26_153034_remove_unique_to_employee_category', 4),
(29, '2025_03_26_153115_remove_unique_to_employee_product', 4),
(32, '2025_03_26_164323_remove_payment_method_to_invoices_table', 5),
(33, '2025_03_26_164428_add_payment_method_to_orders_table', 5),
(34, '2025_03_27_170640_remove_total_discount_to_invoices_table', 6),
(39, '2025_04_24_052353_create_sizes_table', 7),
(40, '2025_04_24_052434_create_colors_table', 7),
(41, '2025_04_24_052521_create_color_product_table', 7),
(42, '2025_04_24_052554_create_product_size_table', 7),
(43, '2025_04_24_055544_update_order_items_table', 8),
(44, '2025_04_24_060428_create_order_item_color_table', 8),
(45, '2025_05_10_014908_add_usage_limit_and_usage_count_to_discounts_table', 9),
(46, '2025_05_10_014909_create_discount_conditions_table', 9),
(48, '2025_05_17_030257_create_ingredients_table', 10),
(49, '2025_05_24_022937_create_product_ingredient_table', 11),
(50, '2025_05_24_023034_remove_product_id_from_ingredients_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` enum('cash','momo','vnpay') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `employee_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','declined') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone_number`, `address`, `payment_method`, `employee_id`, `user_id`, `total_price`, `status`, `discount_id`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', 1, 1, '450000.00', 'completed', NULL, '2025-03-26 07:34:08', '2025-04-03 11:14:22'),
(2, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 2, '450000.00', 'completed', 1, '2025-03-26 07:38:42', '2025-04-19 10:39:25'),
(3, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 2, '450000.00', 'completed', 1, '2025-03-26 07:39:28', '2025-04-19 10:39:55'),
(4, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 2, '450000.00', 'completed', 2, '2025-03-26 07:39:39', '2025-04-26 00:47:22'),
(5, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 2, '450000.00', 'completed', 2, '2025-03-26 07:44:58', '2025-04-26 00:39:31'),
(6, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 2, '360000.00', 'completed', 2, '2025-03-26 07:47:53', '2025-04-03 11:14:53'),
(7, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 2, '360000.00', 'processing', 2, '2025-03-26 07:50:17', '2025-03-26 07:50:17'),
(25, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg2', 'cash', 10, 4, '600000.00', 'completed', NULL, '2025-04-14 09:49:37', '2025-04-14 09:49:37'),
(26, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg4', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 09:53:54', '2025-04-14 09:53:54'),
(27, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg4', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 09:54:00', '2025-04-14 09:54:00'),
(28, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg4', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 09:55:49', '2025-04-14 09:55:49'),
(29, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg6', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 09:57:58', '2025-04-14 09:57:58'),
(30, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg7', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 09:58:32', '2025-04-14 09:58:32'),
(31, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg9', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 09:59:54', '2025-04-14 09:59:54'),
(32, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg9', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 10:00:15', '2025-04-14 10:00:15'),
(33, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sgpro', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 10:06:19', '2025-04-14 10:06:19'),
(34, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg11', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 10:13:36', '2025-04-14 10:13:36'),
(35, 'vinh', 'ngovinh0808@gmail.com', '0123456789', 'sg77', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 10:15:42', '2025-04-14 10:15:42'),
(36, 'zinh', 'ngovinh0808@gmail.com', '0799117548', 'huynh tan phat', 'cash', NULL, 4, '600000.00', 'pending', NULL, '2025-04-14 10:24:44', '2025-04-14 10:24:44'),
(37, 'zinh2', 'ngovinh0808@gmail.com', '0799117548', 'sg1111111', 'cash', NULL, 4, '300000.00', 'pending', NULL, '2025-04-18 02:49:09', '2025-04-18 02:49:09'),
(38, 'zinh2', 'ngovinh0808@gmail.com', '0799117548', 'sg', 'cash', NULL, 4, '300000.00', 'pending', NULL, '2025-04-18 02:49:41', '2025-04-18 02:49:41'),
(39, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '300000.00', 'pending', NULL, '2025-04-18 07:47:15', '2025-04-18 07:47:15'),
(40, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '300000.00', 'pending', NULL, '2025-04-18 07:48:39', '2025-04-18 07:48:39'),
(41, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '300000.00', 'pending', NULL, '2025-04-18 10:47:48', '2025-04-18 10:47:48'),
(42, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '300000.00', 'pending', NULL, '2025-04-18 10:51:12', '2025-04-18 10:51:12'),
(43, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '300000.00', 'pending', NULL, '2025-04-18 11:15:16', '2025-04-18 11:15:16'),
(44, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'vnpay', NULL, 4, '150000.00', 'pending', NULL, '2025-04-18 11:17:38', '2025-04-18 11:17:38'),
(45, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'vnpay', NULL, 4, '150000.00', 'pending', NULL, '2025-04-18 11:52:50', '2025-04-18 11:52:50'),
(46, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '150000.00', 'pending', NULL, '2025-04-19 10:18:26', '2025-04-19 10:18:26'),
(48, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '283500.00', 'pending', NULL, '2025-04-23 23:15:38', '2025-04-23 23:15:38'),
(49, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '310500.00', 'pending', NULL, '2025-04-23 23:15:55', '2025-04-23 23:15:55'),
(50, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '379500.00', 'pending', NULL, '2025-04-23 23:16:02', '2025-04-23 23:16:02'),
(51, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '379500.00', 'pending', NULL, '2025-04-23 23:21:19', '2025-04-23 23:21:19'),
(52, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '141750.00', 'pending', NULL, '2025-04-24 00:07:46', '2025-04-24 00:07:46'),
(53, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '283500.00', 'pending', NULL, '2025-04-24 00:14:21', '2025-04-24 00:14:21'),
(54, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '283500.00', 'pending', NULL, '2025-04-24 00:16:49', '2025-04-24 00:16:49'),
(55, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '765450.00', 'pending', NULL, '2025-04-24 00:17:39', '2025-04-24 00:17:39'),
(56, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '113400.00', 'pending', NULL, '2025-04-24 00:27:51', '2025-04-24 00:27:51'),
(57, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '283500.00', 'pending', NULL, '2025-04-24 00:30:31', '2025-04-24 00:30:31'),
(58, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '567000.00', 'pending', NULL, '2025-04-24 01:31:44', '2025-04-24 01:31:44'),
(59, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '283500.00', 'pending', 2, '2025-04-24 01:47:36', '2025-04-24 01:47:36'),
(60, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '1149750.00', 'pending', NULL, '2025-04-24 01:49:36', '2025-04-24 01:49:36'),
(61, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '945000.00', 'pending', NULL, '2025-04-24 01:54:09', '2025-04-24 01:54:09'),
(62, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '141750.00', 'pending', NULL, '2025-04-24 02:11:56', '2025-04-24 02:11:56'),
(63, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '173250.00', 'pending', NULL, '2025-04-24 02:16:42', '2025-04-24 02:16:42'),
(64, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '141750.00', 'pending', NULL, '2025-04-24 02:23:17', '2025-04-24 02:23:17'),
(65, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '315000.00', 'pending', 2, '2025-04-26 07:59:46', '2025-04-26 07:59:46'),
(66, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '320000.00', 'pending', NULL, '2025-04-26 08:05:33', '2025-04-26 08:05:33'),
(67, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '340000.00', 'pending', NULL, '2025-04-26 08:05:59', '2025-04-26 08:05:59'),
(68, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '340000.00', 'pending', NULL, '2025-04-26 08:06:22', '2025-04-26 08:06:22'),
(69, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '320000.00', 'pending', NULL, '2025-04-26 08:06:29', '2025-04-26 08:06:29'),
(70, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '300000.00', 'pending', NULL, '2025-04-26 08:06:37', '2025-04-26 08:06:37'),
(71, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '300000.00', 'pending', NULL, '2025-04-26 08:11:23', '2025-04-26 08:11:23'),
(72, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '320000.00', 'pending', NULL, '2025-04-26 08:11:28', '2025-04-26 08:11:28'),
(73, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', 11, 1, '340000.00', 'completed', NULL, '2025-04-26 08:11:42', '2025-05-05 07:40:31'),
(74, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', 10, 1, '400000.00', 'processing', NULL, '2025-04-26 08:12:02', '2025-05-05 06:35:09'),
(75, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', 10, 4, '200000.00', 'processing', NULL, '2025-04-26 08:30:48', '2025-05-05 06:33:52'),
(76, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', 10, 4, '200000.00', 'processing', NULL, '2025-04-26 08:34:06', '2025-05-05 06:31:35'),
(77, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', 10, 4, '150000.00', 'completed', NULL, '2025-04-26 08:38:44', '2025-05-05 07:21:09'),
(78, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', NULL, 4, '210000.00', 'processing', NULL, '2025-04-26 08:40:49', '2025-05-05 03:15:34'),
(79, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'cash', 2, 4, '150000.00', 'processing', NULL, '2025-04-26 08:51:37', '2025-05-05 03:16:46'),
(80, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long', 'vnpay', NULL, 4, '200000.00', 'completed', NULL, '2025-04-26 08:52:58', '2025-04-26 08:53:16'),
(81, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long 1', 'cash', NULL, 4, '210000.00', 'processing', NULL, '2025-04-27 23:46:14', '2025-05-05 03:09:26'),
(82, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long 1', 'cash', 10, 4, '210000.00', 'completed', NULL, '2025-05-01 07:59:15', '2025-05-05 03:03:47'),
(83, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long 1', 'vnpay', NULL, 4, '400000.00', 'completed', NULL, '2025-05-03 22:20:15', '2025-05-05 02:19:33'),
(84, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long 1', 'cash', NULL, 4, '850000.00', 'pending', NULL, '2025-05-05 07:57:58', '2025-05-05 07:57:58'),
(85, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long 1', 'cash', NULL, 4, '1900000.00', 'pending', NULL, '2025-05-05 09:25:08', '2025-05-05 09:25:08'),
(86, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '550000.00', 'pending', NULL, '2025-05-09 10:25:18', '2025-05-09 10:25:18'),
(87, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '1820000.00', 'pending', NULL, '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(88, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '1900000.00', 'pending', NULL, '2025-05-09 11:04:39', '2025-05-09 11:04:39'),
(89, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '380000.00', 'pending', NULL, '2025-05-09 19:44:15', '2025-05-09 19:44:15'),
(90, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '760000.00', 'pending', NULL, '2025-05-09 20:10:33', '2025-05-09 20:10:33'),
(91, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '760000.00', 'pending', NULL, '2025-05-09 20:41:33', '2025-05-09 20:41:33'),
(92, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '760000.00', 'pending', NULL, '2025-05-09 20:43:44', '2025-05-09 20:43:44'),
(93, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '550000.00', 'pending', NULL, '2025-05-09 20:44:42', '2025-05-09 20:44:42'),
(94, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '570000.00', 'pending', NULL, '2025-05-09 20:45:11', '2025-05-09 20:45:11'),
(95, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '550000.00', 'pending', NULL, '2025-05-09 20:47:15', '2025-05-09 20:47:15'),
(96, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '550000.00', 'pending', NULL, '2025-05-09 20:48:35', '2025-05-09 20:48:35'),
(97, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '640000.00', 'pending', 4, '2025-05-09 20:51:24', '2025-05-09 20:51:24'),
(98, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '760000.00', 'pending', NULL, '2025-05-09 20:57:34', '2025-05-09 20:57:34'),
(99, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0123456789', '123 Đường ABC, TP.HCM', 'cash', NULL, 1, '640000.00', 'pending', 4, '2025-05-09 21:01:23', '2025-05-09 21:01:23'),
(100, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '760000.00', 'pending', NULL, '2025-05-09 21:03:02', '2025-05-09 21:03:02'),
(101, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '760000.00', 'pending', NULL, '2025-05-09 21:14:22', '2025-05-09 21:14:22'),
(102, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '900000.00', 'pending', NULL, '2025-05-09 21:16:32', '2025-05-09 21:16:32'),
(103, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '950000.00', 'pending', NULL, '2025-05-09 21:17:51', '2025-05-09 21:17:51'),
(104, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '900000.00', 'pending', NULL, '2025-05-09 21:21:26', '2025-05-09 21:21:26'),
(105, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '760000.00', 'pending', NULL, '2025-05-09 21:22:22', '2025-05-09 21:22:22'),
(106, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '1140000.00', 'pending', NULL, '2025-05-09 21:25:44', '2025-05-09 21:25:44'),
(107, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '440000.00', 'pending', 4, '2025-05-09 21:30:23', '2025-05-09 21:30:23'),
(108, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '760000.00', 'pending', 4, '2025-05-09 21:46:21', '2025-05-09 21:46:21'),
(109, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '760000.00', 'pending', NULL, '2025-05-09 21:51:55', '2025-05-09 21:51:55'),
(110, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '528000.00', 'pending', 4, '2025-05-09 21:52:21', '2025-05-09 21:52:21'),
(111, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '656000.00', 'pending', 4, '2025-05-09 21:53:00', '2025-05-09 21:53:00'),
(112, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '900000.00', 'pending', NULL, '2025-05-09 21:54:50', '2025-05-09 21:54:50'),
(113, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '720000.00', 'pending', 4, '2025-05-09 21:55:14', '2025-05-09 21:55:14'),
(114, 'test02', 'test02@gmail.com', '0123456789', 'sg', 'cash', NULL, 27, '800000.00', 'pending', 5, '2025-05-09 22:00:19', '2025-05-09 22:00:19');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `size_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `size_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(48, 25, 2, NULL, 3, '150000.00', '2025-04-14 09:49:37', '2025-04-14 09:49:37'),
(49, 25, 3, NULL, 1, '150000.00', '2025-04-14 09:49:37', '2025-04-14 09:49:37'),
(50, 26, 2, NULL, 3, '150000.00', '2025-04-14 09:53:54', '2025-04-14 09:53:54'),
(51, 26, 3, NULL, 1, '150000.00', '2025-04-14 09:53:54', '2025-04-14 09:53:54'),
(52, 27, 2, NULL, 3, '150000.00', '2025-04-14 09:54:00', '2025-04-14 09:54:00'),
(53, 27, 3, NULL, 1, '150000.00', '2025-04-14 09:54:00', '2025-04-14 09:54:00'),
(54, 28, 2, NULL, 3, '150000.00', '2025-04-14 09:55:49', '2025-04-14 09:55:49'),
(55, 28, 3, NULL, 1, '150000.00', '2025-04-14 09:55:49', '2025-04-14 09:55:49'),
(56, 29, 2, NULL, 3, '150000.00', '2025-04-14 09:57:58', '2025-04-14 09:57:58'),
(57, 29, 3, NULL, 1, '150000.00', '2025-04-14 09:57:58', '2025-04-14 09:57:58'),
(58, 30, 2, NULL, 3, '150000.00', '2025-04-14 09:58:32', '2025-04-14 09:58:32'),
(59, 30, 3, NULL, 1, '150000.00', '2025-04-14 09:58:32', '2025-04-14 09:58:32'),
(60, 31, 2, NULL, 3, '150000.00', '2025-04-14 09:59:54', '2025-04-14 09:59:54'),
(61, 31, 3, NULL, 1, '150000.00', '2025-04-14 09:59:55', '2025-04-14 09:59:55'),
(62, 32, 2, NULL, 3, '150000.00', '2025-04-14 10:00:15', '2025-04-14 10:00:15'),
(63, 32, 3, NULL, 1, '150000.00', '2025-04-14 10:00:15', '2025-04-14 10:00:15'),
(64, 33, 2, NULL, 3, '150000.00', '2025-04-14 10:06:19', '2025-04-14 10:06:19'),
(65, 33, 3, NULL, 1, '150000.00', '2025-04-14 10:06:19', '2025-04-14 10:06:19'),
(66, 34, 2, NULL, 3, '150000.00', '2025-04-14 10:13:36', '2025-04-14 10:13:36'),
(67, 34, 3, NULL, 1, '150000.00', '2025-04-14 10:13:36', '2025-04-14 10:13:36'),
(68, 35, 2, NULL, 3, '150000.00', '2025-04-14 10:15:42', '2025-04-14 10:15:42'),
(69, 35, 3, NULL, 1, '150000.00', '2025-04-14 10:15:42', '2025-04-14 10:15:42'),
(70, 36, 2, NULL, 2, '150000.00', '2025-04-14 10:24:44', '2025-04-14 10:24:44'),
(71, 36, 3, NULL, 2, '150000.00', '2025-04-14 10:24:44', '2025-04-14 10:24:44'),
(72, 37, 2, NULL, 1, '150000.00', '2025-04-18 02:49:09', '2025-04-18 02:49:09'),
(73, 37, 3, NULL, 1, '150000.00', '2025-04-18 02:49:09', '2025-04-18 02:49:09'),
(74, 38, 2, NULL, 1, '150000.00', '2025-04-18 02:49:41', '2025-04-18 02:49:41'),
(75, 38, 3, NULL, 1, '150000.00', '2025-04-18 02:49:41', '2025-04-18 02:49:41'),
(76, 39, 7, NULL, 2, '150000.00', '2025-04-18 07:47:15', '2025-04-18 07:47:15'),
(77, 40, 7, NULL, 2, '150000.00', '2025-04-18 07:48:39', '2025-04-18 07:48:39'),
(78, 41, 5, NULL, 1, '150000.00', '2025-04-18 10:47:48', '2025-04-18 10:47:48'),
(79, 41, 7, NULL, 1, '150000.00', '2025-04-18 10:47:48', '2025-04-18 10:47:48'),
(80, 42, 2, NULL, 1, '150000.00', '2025-04-18 10:51:12', '2025-04-18 10:51:12'),
(81, 42, 3, NULL, 1, '150000.00', '2025-04-18 10:51:12', '2025-04-18 10:51:12'),
(82, 43, 2, NULL, 1, '150000.00', '2025-04-18 11:15:16', '2025-04-18 11:15:16'),
(83, 43, 6, NULL, 1, '150000.00', '2025-04-18 11:15:16', '2025-04-18 11:15:16'),
(84, 44, 2, NULL, 1, '150000.00', '2025-04-18 11:17:38', '2025-04-18 11:17:38'),
(85, 45, 4, NULL, 1, '150000.00', '2025-04-18 11:52:50', '2025-04-18 11:52:50'),
(86, 46, 2, NULL, 1, '150000.00', '2025-04-19 10:18:26', '2025-04-19 10:18:26'),
(88, 48, 3, NULL, 2, '150000.00', '2025-04-23 23:15:38', '2025-04-23 23:15:38'),
(89, 49, 3, NULL, 2, '150000.00', '2025-04-23 23:15:55', '2025-04-23 23:15:55'),
(90, 50, 3, NULL, 2, '150000.00', '2025-04-23 23:16:02', '2025-04-23 23:16:02'),
(91, 51, 3, 2, 2, '150000.00', '2025-04-23 23:21:19', '2025-04-23 23:21:19'),
(92, 52, 2, 1, 1, '150000.00', '2025-04-24 00:07:46', '2025-04-24 00:07:46'),
(93, 53, 2, 1, 2, '150000.00', '2025-04-24 00:14:21', '2025-04-24 00:14:21'),
(94, 54, 3, 1, 1, '150000.00', '2025-04-24 00:16:49', '2025-04-24 00:16:49'),
(95, 54, 4, 1, 1, '150000.00', '2025-04-24 00:16:49', '2025-04-24 00:16:49'),
(96, 55, 7, 1, 1, '150000.00', '2025-04-24 00:17:39', '2025-04-24 00:17:39'),
(97, 55, 10, 1, 1, '690000.00', '2025-04-24 00:17:39', '2025-04-24 00:17:39'),
(98, 56, 7, 1, 1, '150000.00', '2025-04-24 00:27:51', '2025-04-24 00:27:51'),
(99, 57, 3, 1, 1, '150000.00', '2025-04-24 00:30:31', '2025-04-24 00:30:31'),
(100, 57, 4, 1, 1, '150000.00', '2025-04-24 00:30:31', '2025-04-24 00:30:31'),
(101, 58, 2, 1, 4, '150000.00', '2025-04-24 01:31:44', '2025-04-24 01:31:44'),
(102, 59, 3, 1, 2, '150000.00', '2025-04-24 01:47:36', '2025-04-24 01:47:36'),
(103, 60, 2, 2, 3, '150000.00', '2025-04-24 01:49:36', '2025-04-24 01:49:36'),
(104, 60, 3, 1, 2, '150000.00', '2025-04-24 01:49:36', '2025-04-24 01:49:36'),
(105, 60, 3, 2, 2, '150000.00', '2025-04-24 01:49:36', '2025-04-24 01:49:36'),
(106, 61, 2, 1, 2, '150000.00', '2025-04-24 01:54:09', '2025-04-24 01:54:09'),
(107, 61, 2, 2, 1, '150000.00', '2025-04-24 01:54:09', '2025-04-24 01:54:09'),
(108, 61, 3, 2, 2, '150000.00', '2025-04-24 01:54:09', '2025-04-24 01:54:09'),
(109, 61, 2, 1, 1, '150000.00', '2025-04-24 01:54:09', '2025-04-24 01:54:09'),
(110, 62, 2, 1, 1, '150000.00', '2025-04-24 02:11:56', '2025-04-24 02:11:56'),
(111, 63, 2, 2, 1, '150000.00', '2025-04-24 02:16:42', '2025-04-24 02:16:42'),
(112, 64, 2, 1, 1, '150000.00', '2025-04-24 02:23:17', '2025-04-24 02:23:17'),
(113, 65, 3, 1, 2, '150000.00', '2025-04-26 07:59:46', '2025-04-26 07:59:46'),
(114, 66, 3, 1, 2, '150000.00', '2025-04-26 08:05:33', '2025-04-26 08:05:33'),
(115, 67, 3, 1, 2, '150000.00', '2025-04-26 08:05:59', '2025-04-26 08:05:59'),
(116, 68, 3, 1, 2, '150000.00', '2025-04-26 08:06:22', '2025-04-26 08:06:22'),
(117, 69, 3, 1, 2, '150000.00', '2025-04-26 08:06:29', '2025-04-26 08:06:29'),
(118, 70, 3, 1, 2, '150000.00', '2025-04-26 08:06:37', '2025-04-26 08:06:37'),
(119, 71, 3, 1, 2, '150000.00', '2025-04-26 08:11:23', '2025-04-26 08:11:23'),
(120, 72, 3, 1, 2, '150000.00', '2025-04-26 08:11:28', '2025-04-26 08:11:28'),
(121, 73, 3, 1, 2, '150000.00', '2025-04-26 08:11:42', '2025-04-26 08:11:42'),
(122, 74, 3, 2, 2, '150000.00', '2025-04-26 08:12:02', '2025-04-26 08:12:02'),
(123, 75, 2, 2, 1, '150000.00', '2025-04-26 08:30:48', '2025-04-26 08:30:48'),
(124, 76, 8, 2, 1, '150000.00', '2025-04-26 08:34:06', '2025-04-26 08:34:06'),
(125, 77, 2, 1, 1, '150000.00', '2025-04-26 08:38:44', '2025-04-26 08:38:44'),
(126, 78, 2, 2, 1, '150000.00', '2025-04-26 08:40:49', '2025-04-26 08:40:49'),
(127, 79, 8, 1, 1, '150000.00', '2025-04-26 08:51:37', '2025-04-26 08:51:37'),
(128, 80, 2, 2, 1, '150000.00', '2025-04-26 08:52:58', '2025-04-26 08:52:58'),
(129, 81, 9, 2, 1, '150000.00', '2025-04-27 23:46:14', '2025-04-27 23:46:14'),
(130, 82, 2, 2, 1, '150000.00', '2025-05-01 07:59:16', '2025-05-01 07:59:16'),
(131, 83, 4, 2, 2, '150000.00', '2025-05-03 22:20:15', '2025-05-03 22:20:15'),
(132, 84, 8, 2, 1, '800000.00', '2025-05-05 07:57:58', '2025-05-05 07:57:58'),
(133, 85, 7, 2, 2, '900000.00', '2025-05-05 09:25:08', '2025-05-05 09:25:08'),
(134, 86, 4, 2, 1, '500000.00', '2025-05-09 10:25:18', '2025-05-09 10:25:18'),
(135, 87, 2, 2, 1, '330000.00', '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(136, 87, 5, 2, 1, '400000.00', '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(137, 87, 4, 2, 1, '500000.00', '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(138, 87, 5, 1, 1, '400000.00', '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(139, 88, 2, 2, 5, '330000.00', '2025-05-09 11:04:39', '2025-05-09 11:04:39'),
(140, 89, 2, 2, 1, '330000.00', '2025-05-09 19:44:15', '2025-05-09 19:44:15'),
(141, 90, 2, 2, 2, '330000.00', '2025-05-09 20:10:33', '2025-05-09 20:10:33'),
(142, 91, 2, 2, 2, '330000.00', '2025-05-09 20:41:33', '2025-05-09 20:41:33'),
(143, 92, 2, 2, 2, '330000.00', '2025-05-09 20:43:44', '2025-05-09 20:43:44'),
(144, 93, 4, 2, 1, '500000.00', '2025-05-09 20:44:42', '2025-05-09 20:44:42'),
(145, 94, 4, 2, 1, '500000.00', '2025-05-09 20:45:11', '2025-05-09 20:45:11'),
(146, 95, 6, 2, 1, '500000.00', '2025-05-09 20:47:15', '2025-05-09 20:47:15'),
(147, 96, 4, 2, 1, '500000.00', '2025-05-09 20:48:35', '2025-05-09 20:48:35'),
(148, 97, 3, 1, 2, '400000.00', '2025-05-09 20:51:24', '2025-05-09 20:51:24'),
(149, 98, 2, 2, 2, '330000.00', '2025-05-09 20:57:34', '2025-05-09 20:57:34'),
(150, 99, 3, 1, 2, '400000.00', '2025-05-09 21:01:23', '2025-05-09 21:01:23'),
(151, 100, 2, 2, 2, '330000.00', '2025-05-09 21:03:02', '2025-05-09 21:03:02'),
(152, 101, 2, 2, 2, '330000.00', '2025-05-09 21:14:22', '2025-05-09 21:14:22'),
(153, 102, 3, 2, 2, '400000.00', '2025-05-09 21:16:32', '2025-05-09 21:16:32'),
(154, 103, 7, 2, 1, '900000.00', '2025-05-09 21:17:51', '2025-05-09 21:17:51'),
(155, 104, 3, 2, 2, '400000.00', '2025-05-09 21:21:26', '2025-05-09 21:21:26'),
(156, 105, 2, 2, 2, '330000.00', '2025-05-09 21:22:22', '2025-05-09 21:22:22'),
(157, 106, 2, 2, 3, '330000.00', '2025-05-09 21:25:44', '2025-05-09 21:25:44'),
(158, 107, 4, 2, 1, '500000.00', '2025-05-09 21:30:23', '2025-05-09 21:30:23'),
(159, 108, 7, 2, 1, '900000.00', '2025-05-09 21:46:21', '2025-05-09 21:46:21'),
(160, 109, 2, 2, 2, '330000.00', '2025-05-09 21:51:55', '2025-05-09 21:51:55'),
(161, 110, 2, 1, 2, '330000.00', '2025-05-09 21:52:21', '2025-05-09 21:52:21'),
(162, 111, 3, 1, 2, '400000.00', '2025-05-09 21:53:00', '2025-05-09 21:53:00'),
(163, 112, 7, 1, 1, '900000.00', '2025-05-09 21:54:50', '2025-05-09 21:54:50'),
(164, 113, 7, 1, 1, '900000.00', '2025-05-09 21:55:14', '2025-05-09 21:55:14'),
(165, 114, 7, 1, 2, '900000.00', '2025-05-09 22:00:19', '2025-05-09 22:00:19');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_color`
--

CREATE TABLE `order_item_color` (
  `id` bigint UNSIGNED NOT NULL,
  `order_item_id` bigint UNSIGNED NOT NULL,
  `color_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item_color`
--

INSERT INTO `order_item_color` (`id`, `order_item_id`, `color_id`, `created_at`, `updated_at`) VALUES
(1, 88, 1, '2025-04-23 23:15:38', '2025-04-23 23:15:38'),
(2, 89, 1, '2025-04-23 23:15:55', '2025-04-23 23:15:55'),
(3, 89, 2, '2025-04-23 23:15:55', '2025-04-23 23:15:55'),
(4, 89, 3, '2025-04-23 23:15:55', '2025-04-23 23:15:55'),
(5, 90, 1, '2025-04-23 23:16:02', '2025-04-23 23:16:02'),
(6, 90, 2, '2025-04-23 23:16:02', '2025-04-23 23:16:02'),
(7, 90, 3, '2025-04-23 23:16:02', '2025-04-23 23:16:02'),
(8, 91, 1, '2025-04-23 23:21:19', '2025-04-23 23:21:19'),
(9, 91, 2, '2025-04-23 23:21:19', '2025-04-23 23:21:19'),
(10, 91, 3, '2025-04-23 23:21:19', '2025-04-23 23:21:19'),
(11, 92, 1, '2025-04-24 00:07:46', '2025-04-24 00:07:46'),
(12, 93, 1, '2025-04-24 00:14:21', '2025-04-24 00:14:21'),
(13, 94, 1, '2025-04-24 00:16:49', '2025-04-24 00:16:49'),
(14, 95, 1, '2025-04-24 00:16:49', '2025-04-24 00:16:49'),
(15, 96, 1, '2025-04-24 00:17:39', '2025-04-24 00:17:39'),
(16, 97, 1, '2025-04-24 00:17:39', '2025-04-24 00:17:39'),
(17, 98, 1, '2025-04-24 00:27:51', '2025-04-24 00:27:51'),
(18, 99, 1, '2025-04-24 00:30:31', '2025-04-24 00:30:31'),
(19, 100, 1, '2025-04-24 00:30:31', '2025-04-24 00:30:31'),
(20, 101, 1, '2025-04-24 01:31:44', '2025-04-24 01:31:44'),
(21, 102, 2, '2025-04-24 01:47:36', '2025-04-24 01:47:36'),
(22, 103, 4, '2025-04-24 01:49:36', '2025-04-24 01:49:36'),
(23, 104, 2, '2025-04-24 01:49:36', '2025-04-24 01:49:36'),
(24, 105, 2, '2025-04-24 01:49:36', '2025-04-24 01:49:36'),
(25, 106, 1, '2025-04-24 01:54:09', '2025-04-24 01:54:09'),
(26, 107, 1, '2025-04-24 01:54:09', '2025-04-24 01:54:09'),
(27, 108, 3, '2025-04-24 01:54:09', '2025-04-24 01:54:09'),
(28, 109, 3, '2025-04-24 01:54:09', '2025-04-24 01:54:09'),
(29, 110, 1, '2025-04-24 02:11:56', '2025-04-24 02:11:56'),
(30, 111, 1, '2025-04-24 02:16:42', '2025-04-24 02:16:42'),
(31, 112, 1, '2025-04-24 02:23:17', '2025-04-24 02:23:17'),
(32, 113, 1, '2025-04-26 07:59:46', '2025-04-26 07:59:46'),
(33, 114, 1, '2025-04-26 08:05:33', '2025-04-26 08:05:33'),
(34, 115, 1, '2025-04-26 08:05:59', '2025-04-26 08:05:59'),
(35, 115, 2, '2025-04-26 08:05:59', '2025-04-26 08:05:59'),
(36, 116, 1, '2025-04-26 08:06:22', '2025-04-26 08:06:22'),
(37, 116, 2, '2025-04-26 08:06:22', '2025-04-26 08:06:22'),
(38, 117, 1, '2025-04-26 08:06:29', '2025-04-26 08:06:29'),
(39, 117, 2, '2025-04-26 08:06:29', '2025-04-26 08:06:29'),
(40, 118, 1, '2025-04-26 08:06:37', '2025-04-26 08:06:37'),
(41, 119, 1, '2025-04-26 08:11:23', '2025-04-26 08:11:23'),
(42, 120, 1, '2025-04-26 08:11:28', '2025-04-26 08:11:28'),
(43, 120, 2, '2025-04-26 08:11:28', '2025-04-26 08:11:28'),
(44, 121, 1, '2025-04-26 08:11:42', '2025-04-26 08:11:42'),
(45, 121, 2, '2025-04-26 08:11:42', '2025-04-26 08:11:42'),
(46, 121, 3, '2025-04-26 08:11:42', '2025-04-26 08:11:42'),
(47, 122, 1, '2025-04-26 08:12:02', '2025-04-26 08:12:02'),
(48, 123, 3, '2025-04-26 08:30:48', '2025-04-26 08:30:48'),
(49, 124, 2, '2025-04-26 08:34:06', '2025-04-26 08:34:06'),
(50, 125, 1, '2025-04-26 08:38:44', '2025-04-26 08:38:44'),
(51, 126, 2, '2025-04-26 08:40:49', '2025-04-26 08:40:49'),
(52, 126, 3, '2025-04-26 08:40:49', '2025-04-26 08:40:49'),
(53, 127, 2, '2025-04-26 08:51:37', '2025-04-26 08:51:37'),
(54, 128, 2, '2025-04-26 08:52:58', '2025-04-26 08:52:58'),
(55, 129, 2, '2025-04-27 23:46:14', '2025-04-27 23:46:14'),
(56, 129, 3, '2025-04-27 23:46:14', '2025-04-27 23:46:14'),
(57, 130, 2, '2025-05-01 07:59:16', '2025-05-01 07:59:16'),
(58, 130, 3, '2025-05-01 07:59:16', '2025-05-01 07:59:16'),
(59, 131, 3, '2025-05-03 22:20:15', '2025-05-03 22:20:15'),
(60, 132, 2, '2025-05-05 07:57:58', '2025-05-05 07:57:58'),
(61, 133, 4, '2025-05-05 09:25:08', '2025-05-05 09:25:08'),
(62, 134, 2, '2025-05-09 10:25:18', '2025-05-09 10:25:18'),
(63, 135, 1, '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(64, 135, 2, '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(65, 136, 3, '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(66, 137, 2, '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(67, 138, 2, '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(68, 138, 1, '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(69, 138, 3, '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(70, 138, 4, '2025-05-09 11:04:14', '2025-05-09 11:04:14'),
(71, 139, 2, '2025-05-09 11:04:39', '2025-05-09 11:04:39'),
(72, 140, 3, '2025-05-09 19:44:15', '2025-05-09 19:44:15'),
(73, 141, 2, '2025-05-09 20:10:33', '2025-05-09 20:10:33'),
(74, 142, 3, '2025-05-09 20:41:33', '2025-05-09 20:41:33'),
(75, 143, 2, '2025-05-09 20:43:44', '2025-05-09 20:43:44'),
(76, 144, 3, '2025-05-09 20:44:42', '2025-05-09 20:44:42'),
(77, 145, 2, '2025-05-09 20:45:11', '2025-05-09 20:45:11'),
(78, 145, 3, '2025-05-09 20:45:11', '2025-05-09 20:45:11'),
(79, 145, 4, '2025-05-09 20:45:11', '2025-05-09 20:45:11'),
(80, 146, 3, '2025-05-09 20:47:15', '2025-05-09 20:47:15'),
(81, 147, 3, '2025-05-09 20:48:35', '2025-05-09 20:48:35'),
(82, 148, 1, '2025-05-09 20:51:24', '2025-05-09 20:51:24'),
(83, 149, 3, '2025-05-09 20:57:34', '2025-05-09 20:57:34'),
(84, 150, 1, '2025-05-09 21:01:23', '2025-05-09 21:01:23'),
(85, 151, 3, '2025-05-09 21:03:02', '2025-05-09 21:03:02'),
(86, 152, 3, '2025-05-09 21:14:22', '2025-05-09 21:14:22'),
(87, 153, 3, '2025-05-09 21:16:32', '2025-05-09 21:16:32'),
(88, 154, 3, '2025-05-09 21:17:51', '2025-05-09 21:17:51'),
(89, 155, 3, '2025-05-09 21:21:26', '2025-05-09 21:21:26'),
(90, 156, 3, '2025-05-09 21:22:22', '2025-05-09 21:22:22'),
(91, 157, 4, '2025-05-09 21:25:44', '2025-05-09 21:25:44'),
(92, 158, 2, '2025-05-09 21:30:23', '2025-05-09 21:30:23'),
(93, 159, 4, '2025-05-09 21:46:21', '2025-05-09 21:46:21'),
(94, 160, 3, '2025-05-09 21:51:55', '2025-05-09 21:51:55'),
(95, 161, 3, '2025-05-09 21:52:21', '2025-05-09 21:52:21'),
(96, 162, 2, '2025-05-09 21:53:00', '2025-05-09 21:53:00'),
(97, 162, 1, '2025-05-09 21:53:00', '2025-05-09 21:53:00'),
(98, 163, 2, '2025-05-09 21:54:50', '2025-05-09 21:54:50'),
(99, 164, 1, '2025-05-09 21:55:14', '2025-05-09 21:55:14'),
(100, 165, 3, '2025-05-09 22:00:19', '2025-05-09 22:00:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ngovinh0808@gmail.com', '$2y$12$Bw6F5Wb//VGpCUSdnxS0Guhrt7FNBQyGmlKK7TWMvzNHEm9Z0pXGW', '2025-03-27 11:40:42');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'API Token', 'efdfb9311522124ea7b25b2134cef9e0fcf988f47518c19f5b8cc4951dc2dadc', '[\"*\"]', NULL, NULL, '2025-03-24 05:46:27', '2025-03-24 05:46:27'),
(2, 'App\\Models\\User', 1, 'API Token', '04d005c5cfff4b27861f925862a2c08dd918f9a2eb4f674b9ec3708483fce7ca', '[\"*\"]', NULL, NULL, '2025-03-24 05:50:40', '2025-03-24 05:50:40'),
(3, 'App\\Models\\Employee', 4, 'API Token', '53c0e9e250bd25e1d503bfb8ec85537c3c0f5da58ad7a5d35e00c23835b53fe2', '[\"*\"]', NULL, NULL, '2025-03-24 07:53:05', '2025-03-24 07:53:05'),
(4, 'App\\Models\\Employee', 5, 'API Token', 'd16beb53decc10ee84897401d22d11d67e61235e4d2625ec9a83714a10b6e25a', '[\"*\"]', '2025-03-26 08:53:19', NULL, '2025-03-24 08:18:21', '2025-03-26 08:53:19'),
(5, 'App\\Models\\Employee', 6, 'API Token', 'fdb543f021d8b98be533164c81447208b8eefbfc5d31950827dbc32408b04761', '[\"*\"]', NULL, NULL, '2025-03-24 08:37:36', '2025-03-24 08:37:36'),
(6, 'App\\Models\\User', 2, 'API Token', '27a7ca36aebc7a86d6923b8b21f230672f8b237910387465324a2ea15ff32cdb', '[\"*\"]', NULL, NULL, '2025-03-24 09:23:23', '2025-03-24 09:23:23'),
(7, 'App\\Models\\User', 1, 'User token', 'e005beb34100793fcba1e3241097d8eb08c5824df21acc0dacde126a60ce5350', '[\"*\"]', '2025-03-26 08:26:01', NULL, '2025-03-24 09:23:47', '2025-03-26 08:26:01'),
(8, 'App\\Models\\Employee', 7, 'Employee Token', '8ee36cad110aa5ae6f86af52615bfdff1ec4b76bde0666ca9ff690ac8aa10d73', '[\"*\"]', '2025-03-26 04:19:57', NULL, '2025-03-24 09:36:33', '2025-03-26 04:19:57'),
(9, 'App\\Models\\Employee', 8, 'Employee Token', '1b75b24055c676d58a8a46e5e1664f762375987d08336e9a589f983074a41dc1', '[\"*\"]', NULL, NULL, '2025-03-24 09:42:28', '2025-03-24 09:42:28'),
(10, 'App\\Models\\User', 1, 'User token', 'b6075e684e41fe16eff9f165249394c391592c4a0e59c0578a225eb62ccaa902', '[\"*\"]', NULL, NULL, '2025-03-26 04:05:38', '2025-03-26 04:05:38'),
(11, 'App\\Models\\User', 3, 'API Token', '70a06825092d2770a6b28d1a36513a242ac9743336438ee34b839355559c6ce5', '[\"*\"]', NULL, NULL, '2025-03-27 11:10:08', '2025-03-27 11:10:08'),
(12, 'App\\Models\\User', 3, 'User token', 'eecb5a381040f8b66db6a5e57242a84ad3078a111f894f8933dc69d670c05063', '[\"*\"]', NULL, NULL, '2025-03-27 11:33:11', '2025-03-27 11:33:11'),
(15, 'App\\Models\\User', 3, 'User token', 'e56f9f7a63fdf6c7de4b11a0dcd469cf71c79ca410394bc772909a6a23666808', '[\"*\"]', NULL, NULL, '2025-03-28 01:08:34', '2025-03-28 01:08:34'),
(16, 'App\\Models\\Employee', 9, 'Employee Token', '3934e76ca88c77f6c5459480a0389d02ad4328a03e18704463dd9bd23b9d01fc', '[\"*\"]', NULL, NULL, '2025-03-28 01:09:47', '2025-03-28 01:09:47'),
(17, 'App\\Models\\Employee', 9, 'Employee token', '5f5239d7879b1c1919fe66721f7bdc8c743a630cbcd001cb18de44a5bb7c204c', '[\"*\"]', NULL, NULL, '2025-03-28 01:10:16', '2025-03-28 01:10:16'),
(18, 'App\\Models\\User', 3, 'User token', 'a576ae86ba98850514dd4107f86c1a5f18b01dec4a2d00ce29b7836ff28f02b0', '[\"user\"]', '2025-03-28 01:28:52', NULL, '2025-03-28 01:23:55', '2025-03-28 01:28:52'),
(19, 'App\\Models\\Employee', 9, 'Employee token', '3fe0e59ec4b5ec57a1152d812d7354b0738c4c423d0e180666bcebc7819062b5', '[\"Employee\"]', '2025-03-28 01:38:11', NULL, '2025-03-28 01:24:35', '2025-03-28 01:38:11'),
(39, 'App\\Models\\Employee', 9, 'Employee token', '20ce658de57c94648c37302d2f74423f85988ad9e323d2b0f403a74293765a84', '[\"Employee\"]', '2025-04-11 10:20:17', '2025-04-18 10:20:03', '2025-04-11 10:20:03', '2025-04-11 10:20:17'),
(40, 'App\\Models\\User', 4, 'User token', '444e7eadba64fe3df91eec05867313c218358b1adfe165bd1b89a45460c61bcf', '[\"user\"]', NULL, '2025-04-18 10:28:40', '2025-04-11 10:28:40', '2025-04-11 10:28:40'),
(43, 'App\\Models\\User', 4, 'User token', '26cb387c8d7ddfa79ef84e43bd7db05b55c8044213edb8ec584751097827181e', '[\"user\"]', '2025-04-11 10:34:22', '2025-04-18 10:33:56', '2025-04-11 10:33:56', '2025-04-11 10:34:22'),
(45, 'App\\Models\\User', 4, 'User token', 'e5b13971db9dd90e8d434a7adedb99a205fcc055393a771164b9b87b61422d0a', '[\"user\"]', NULL, '2025-04-18 11:08:57', '2025-04-11 11:08:57', '2025-04-11 11:08:57'),
(46, 'App\\Models\\User', 4, 'User token', '67c159bf4c571cf0495a9a14955dd9a132d23a7bc4e866458376d03ec1d39bbb', '[\"user\"]', NULL, '2025-04-18 11:09:01', '2025-04-11 11:09:01', '2025-04-11 11:09:01'),
(51, 'App\\Models\\User', 4, 'User token', 'd6a8093141880007ad2fb19b039fe74f089585fbf85900730405d788ff3849fa', '[\"user\"]', '2025-04-12 02:09:25', '2025-04-19 01:39:21', '2025-04-12 01:39:21', '2025-04-12 02:09:25'),
(55, 'App\\Models\\User', 5, 'API Token', 'a5adf0eef75227dc1d1be9d008dcfc538a47c6cbf13a5f63f3de9a484b8e7a3b', '[\"*\"]', NULL, NULL, '2025-04-12 10:59:50', '2025-04-12 10:59:50'),
(57, 'App\\Models\\User', 6, 'API Token', '8e4adf0bf161b12aeadf19c87411fbcca05332560c6f0e546ad1acfc90509330', '[\"*\"]', NULL, NULL, '2025-04-12 11:06:54', '2025-04-12 11:06:54'),
(58, 'App\\Models\\User', 7, 'API Token', '1086b9920efea34f76b035b37592835ea3d66230f0c10c64e82c4555fd0f7ca3', '[\"*\"]', NULL, NULL, '2025-04-12 11:11:58', '2025-04-12 11:11:58'),
(59, 'App\\Models\\User', 8, 'API Token', '6328b81b470e8b0003e8e3a66a8405486325d467b5922a7064ab3c7476b1c7da', '[\"*\"]', NULL, NULL, '2025-04-12 11:12:43', '2025-04-12 11:12:43'),
(60, 'App\\Models\\User', 9, 'API Token', 'd91a203c68fcc942f6124717a93b1f1ddea5fb139da670ca913a83fa76d49948', '[\"*\"]', NULL, NULL, '2025-04-12 11:22:41', '2025-04-12 11:22:41'),
(61, 'App\\Models\\User', 10, 'API Token', 'c15368b0ea79e7137bb08a1c79c2d88ce06e2a0b4357da542d2ec670616f2fb4', '[\"*\"]', NULL, NULL, '2025-04-12 11:25:34', '2025-04-12 11:25:34'),
(62, 'App\\Models\\User', 11, 'API Token', 'df5474190f8642b8e66d72a1f1f87b238734f7d82140a8e5207d7d98e63cc52d', '[\"*\"]', NULL, NULL, '2025-04-12 11:29:22', '2025-04-12 11:29:22'),
(63, 'App\\Models\\User', 12, 'API Token', '6845b1f4026184835fb625648f9da0b59879222d7a4a7a0ff83d6a2ae85800bd', '[\"*\"]', NULL, NULL, '2025-04-12 11:31:16', '2025-04-12 11:31:16'),
(66, 'App\\Models\\User', 13, 'API Token', '710b2bfa62a9c6b9a7ad270819cdfc26e65b2635319b828263ea9c2acac60721', '[\"*\"]', NULL, NULL, '2025-04-12 11:41:57', '2025-04-12 11:41:57'),
(67, 'App\\Models\\User', 14, 'API Token', '45853353f6bfe47106c3a816ca25c0ece141f54b580df3c4ff915f0819adca8f', '[\"*\"]', NULL, NULL, '2025-04-12 11:45:30', '2025-04-12 11:45:30'),
(68, 'App\\Models\\User', 15, 'API Token', '460e43bad32cb03c0b17da1b693c976de12bac85f7c95ca3d3b35678394e06b1', '[\"*\"]', NULL, NULL, '2025-04-12 11:48:02', '2025-04-12 11:48:02'),
(69, 'App\\Models\\User', 16, 'API Token', 'c2a744c44096081bce7a9ca44bb563b07301019651cdc18f4778bd25426b4ba9', '[\"*\"]', NULL, NULL, '2025-04-12 11:50:33', '2025-04-12 11:50:33'),
(70, 'App\\Models\\User', 17, 'API Token', '119741dc3b9b41cf31012fed82cbba9779a8095d6b2c8884f15d8938d90f6832', '[\"*\"]', NULL, NULL, '2025-04-12 11:55:14', '2025-04-12 11:55:14'),
(71, 'App\\Models\\User', 18, 'API Token', '6b12f131cfa9fa2fa6c857f66e5e078412b19462ee259310b16cb5ccc4a266e3', '[\"*\"]', NULL, NULL, '2025-04-12 11:56:45', '2025-04-12 11:56:45'),
(72, 'App\\Models\\User', 19, 'API Token', 'e1972501737ec9dcc0ec7db200121532793486abeba16fa450de3b62a39d1aa6', '[\"*\"]', NULL, NULL, '2025-04-12 11:57:16', '2025-04-12 11:57:16'),
(73, 'App\\Models\\User', 20, 'API Token', '5ae62aa9923ddd14a737421771fc9bc95f86aa9a64cf57c3d6b93563ed604526', '[\"*\"]', NULL, NULL, '2025-04-12 11:59:57', '2025-04-12 11:59:57'),
(74, 'App\\Models\\User', 21, 'API Token', '95bf2426dec6443fe679fac70db1828976a1de82b4998126237601aae8785369', '[\"*\"]', NULL, NULL, '2025-04-12 12:01:16', '2025-04-12 12:01:16'),
(75, 'App\\Models\\User', 22, 'API Token', '3c183230366a04f1d2911c51500a514b89f1ac677c27f07d56a2a4bf9802db22', '[\"*\"]', NULL, NULL, '2025-04-12 12:02:20', '2025-04-12 12:02:20'),
(76, 'App\\Models\\User', 23, 'API Token', '69f11030c058f6483c082351b5226ab4b1ee70a896b41a0d4291d3d4f3321c09', '[\"*\"]', NULL, NULL, '2025-04-12 12:04:09', '2025-04-12 12:04:09'),
(77, 'App\\Models\\User', 24, 'API Token', '98294d9441b5f45f87f46cd67d42f0977ac95b0b6377959bd9473e522d0d1485', '[\"*\"]', NULL, NULL, '2025-04-12 12:06:48', '2025-04-12 12:06:48'),
(78, 'App\\Models\\User', 25, 'API Token', 'cd4f04d57de7301d44f6b7b358ce2ec55f09603dc3ff7ec8f8349e250a48d5e0', '[\"*\"]', NULL, NULL, '2025-04-12 12:14:34', '2025-04-12 12:14:34'),
(79, 'App\\Models\\User', 6, 'User token', '11f77585f00d50d2fd8444d3080c039fcbe51f79f995e27534b3109fba79ad7f', '[\"user\"]', NULL, '2025-04-19 12:16:06', '2025-04-12 12:16:06', '2025-04-12 12:16:06'),
(80, 'App\\Models\\User', 6, 'User token', 'c17088ea3628fd54b4cf2ffbbe42b4ef49c5c5deab8f8409a4cf445cf1d0f4d5', '[\"user\"]', NULL, '2025-04-19 12:16:12', '2025-04-12 12:16:12', '2025-04-12 12:16:12'),
(81, 'App\\Models\\User', 6, 'User token', '28e01d175ef825fe9e527ea5ae91682770832e4c40ea37526bb6649f774b0fa8', '[\"user\"]', NULL, '2025-04-19 12:16:42', '2025-04-12 12:16:42', '2025-04-12 12:16:42'),
(82, 'App\\Models\\User', 6, 'User token', '2bbdb4ec64576ec417ec861b722a831128f09b0185d116890ff2a21c58a3d67e', '[\"user\"]', NULL, '2025-04-19 12:16:50', '2025-04-12 12:16:50', '2025-04-12 12:16:50'),
(83, 'App\\Models\\User', 6, 'User token', '6f6bd37db9382f54f02ee7edd64aa596167ae46cd3a9f6aac9f360624cb1d7ce', '[\"user\"]', NULL, '2025-04-19 12:17:00', '2025-04-12 12:17:00', '2025-04-12 12:17:00'),
(86, 'App\\Models\\Employee', 9, 'Employee token', '5d8a08fc754e5d88ad8c0526664b3c1b55f97cf67e35afcf8142a98ffcd7eae2', '[\"Employee\"]', '2025-04-16 04:08:09', '2025-04-23 03:40:21', '2025-04-16 03:40:21', '2025-04-16 04:08:09'),
(87, 'App\\Models\\User', 4, 'User token', '08c92a3811065e1aeba585a717ae1653de0c450b7d15141de9df2593fc49e06c', '[\"user\"]', '2025-04-16 04:08:37', '2025-04-23 03:48:02', '2025-04-16 03:48:02', '2025-04-16 04:08:37'),
(88, 'App\\Models\\User', 5, 'User token', '5de6a799d45172660179b91cd65646dda7d4b96f3dc05caf93b4ebe9e338c484', '[\"user\"]', '2025-04-16 04:30:43', '2025-04-23 04:13:53', '2025-04-16 04:13:53', '2025-04-16 04:30:43'),
(89, 'App\\Models\\Employee', 1, 'Employee token', 'af49cd51ebc026d739b3873d749724e7a6cb8133034a90f47ad672b2dd8ed2df', '[\"Employee\"]', '2025-04-16 04:30:33', '2025-04-23 04:15:13', '2025-04-16 04:15:13', '2025-04-16 04:30:33'),
(90, 'App\\Models\\Employee', 9, 'Employee token', '99e5d79fa43d0f2cbbc2c67e7dcb21a1b55c01859f9401d333cce531def802e6', '[\"Employee\"]', '2025-04-16 08:40:05', '2025-04-23 04:26:54', '2025-04-16 04:26:54', '2025-04-16 08:40:05'),
(91, 'App\\Models\\User', 4, 'User token', 'd8def546cc83ef39f868b75c7c00fcbb65b64da7c41014e2ede2fba9ce2bee05', '[\"user\"]', '2025-04-16 08:50:20', '2025-04-23 08:47:58', '2025-04-16 08:47:58', '2025-04-16 08:50:20'),
(92, 'App\\Models\\Employee', 1, 'Employee token', 'c4aa2d7fb4766ba09f5deb986226873c15f472817154d3ead4ec020e6fdfa328', '[\"Employee\"]', '2025-04-20 10:49:01', '2025-04-23 08:48:47', '2025-04-16 08:48:47', '2025-04-20 10:49:01'),
(93, 'App\\Models\\Employee', 9, 'Employee token', '1d33c05bb7a70cf2cd2a7434bde0802a1bd8f8631ccd0b7006da37a5187d4021', '[\"Employee\"]', NULL, '2025-04-23 09:08:35', '2025-04-16 09:08:34', '2025-04-16 09:08:35'),
(94, 'App\\Models\\Employee', 9, 'Employee token', 'f20d0939d839d27954c77d9c7c4eca2a321775c87f57b9ea63b2b57d90f66243', '[\"Employee\"]', NULL, '2025-04-23 09:08:57', '2025-04-16 09:08:57', '2025-04-16 09:08:57'),
(95, 'App\\Models\\Employee', 9, 'Employee token', 'e156cb598f379ca9a5c5a2ec886d3fea9ee7f3bbebc3751af80d595f42fef45e', '[\"Employee\"]', NULL, '2025-04-23 09:09:08', '2025-04-16 09:09:08', '2025-04-16 09:09:08'),
(96, 'App\\Models\\Employee', 9, 'Employee token', '2f3d0b796d520e0075562fd78ef44d0f611ae233a721cb3ea9304c1a13018893', '[\"Employee\"]', NULL, '2025-04-23 09:11:41', '2025-04-16 09:11:41', '2025-04-16 09:11:41'),
(97, 'App\\Models\\Employee', 9, 'Employee token', '1060953d1a1cb7f4dd58b1227e53a1e1d1352eed75716c506ea48ef3265a0ddb', '[\"Employee\"]', NULL, '2025-04-23 09:11:59', '2025-04-16 09:11:59', '2025-04-16 09:11:59'),
(98, 'App\\Models\\Employee', 9, 'Employee token', 'd109c96cd1fa174d6f92d1d4ecd9f810f4ad92b678eadd2fc526f4059ede8a19', '[\"Employee\"]', NULL, '2025-04-23 09:24:47', '2025-04-16 09:24:47', '2025-04-16 09:24:47'),
(100, 'App\\Models\\User', 4, 'User token', '39f066b46071ee00b43349295341717d15c2001e3c327970d316b1d9a4f48397', '[\"user\"]', NULL, '2025-04-23 09:29:22', '2025-04-16 09:29:22', '2025-04-16 09:29:22'),
(103, 'App\\Models\\User', 4, 'User token', 'aca6d8ed5c3773761353d35ce65749ab75b8e7a0453b62a10a6755c9d24678c9', '[\"user\"]', '2025-04-16 23:44:01', '2025-04-23 21:35:37', '2025-04-16 21:35:37', '2025-04-16 23:44:01'),
(104, 'App\\Models\\User', 4, 'User token', '4c470fd109407302f060b2e501909c5676455426f5e4b9c6e33148824ff58751', '[\"user\"]', '2025-04-16 23:30:28', '2025-04-23 21:49:04', '2025-04-16 21:49:04', '2025-04-16 23:30:28'),
(105, 'App\\Models\\User', 4, 'User token', '7bb060e98b87f8487eacf58755ebd89bfbe853123904fc8d4b4ba63e1d79cd7d', '[\"user\"]', NULL, '2025-04-23 22:34:32', '2025-04-16 22:34:32', '2025-04-16 22:34:32'),
(106, 'App\\Models\\User', 4, 'User token', 'fb2edc63ed83b5c542f62d1bc215ec94fbe818e7b14244dd4f1c3868b3dcb978', '[\"user\"]', NULL, '2025-04-23 22:39:41', '2025-04-16 22:39:41', '2025-04-16 22:39:41'),
(108, 'App\\Models\\User', 4, 'User token', '1cd1053cece107da80fc7941072e48934bd56fa5397e12309eb7587498edc625', '[\"user\"]', '2025-04-24 10:19:29', '2025-04-24 10:41:50', '2025-04-17 10:41:50', '2025-04-24 10:19:29'),
(112, 'App\\Models\\Employee', 2, 'Employee token', '20f987dd1ecec31a2912d2f61f52126fa5350b0d32647cf3c69396c9219ed948', '[\"Employee\"]', NULL, '2025-04-25 09:21:42', '2025-04-18 09:21:42', '2025-04-18 09:21:42'),
(113, 'App\\Models\\Employee', 1, 'Employee token', '76d3742f33985807f02c2ab9ae54d5a259ade7353f86740ca549408797758455', '[\"Employee\"]', NULL, '2025-04-25 09:33:32', '2025-04-18 09:33:32', '2025-04-18 09:33:32'),
(115, 'App\\Models\\Employee', 1, 'Employee token', 'e21976d82e69a35bed1a964389b7ce3daa7f63a82e650603e9bae051d3cd0cac', '[\"Employee\"]', NULL, '2025-04-25 09:35:04', '2025-04-18 09:35:04', '2025-04-18 09:35:04'),
(117, 'App\\Models\\Employee', 2, 'Employee token', '3e2d723e73c5073705a352d7d372dd729b6346a2f2c0a7402d7eb8eb31e9860e', '[\"Employee\"]', NULL, '2025-04-25 09:44:28', '2025-04-18 09:44:28', '2025-04-18 09:44:28'),
(118, 'App\\Models\\User', 4, 'User token', 'f0dacd641d111b4693a27bb99ff113260e412cd72ee8c28aaf52f8b7a156cd84', '[\"user\"]', '2025-04-18 11:52:55', '2025-04-25 10:46:23', '2025-04-18 10:46:23', '2025-04-18 11:52:55'),
(119, 'App\\Models\\Employee', 2, 'Employee token', '01e701ed09f91eef4a4dca29134ef353496c081b811dcc6bf8c04dd5e16094da', '[\"Employee\"]', NULL, '2025-04-25 20:57:05', '2025-04-18 20:57:05', '2025-04-18 20:57:05'),
(120, 'App\\Models\\Employee', 2, 'Employee token', '3e78eca587823837a57ae650add30bf6da9011dff38ddac223fa538155b60c95', '[\"Employee\"]', NULL, '2025-04-25 20:57:31', '2025-04-18 20:57:31', '2025-04-18 20:57:31'),
(121, 'App\\Models\\Employee', 2, 'Employee token', '492807cc1ff8e218fe40b9ffda074be86ea03c63953ed8b3bdf02a5df8108455', '[\"Employee\"]', NULL, '2025-04-25 20:57:43', '2025-04-18 20:57:43', '2025-04-18 20:57:43'),
(122, 'App\\Models\\Employee', 9, 'Employee token', '5c7546e2769f9048b067fe351bd2a5299b8c6984b8d6750af0bfd65661c739a1', '[\"Employee\"]', NULL, '2025-04-26 03:30:41', '2025-04-19 03:30:41', '2025-04-19 03:30:41'),
(123, 'App\\Models\\Employee', 9, 'Employee token', '586ea64502a9b65b834ebc8f48bfb5e2dc854329973f64889760f0e5ec1f94b1', '[\"Employee\"]', NULL, '2025-04-26 03:35:13', '2025-04-19 03:35:13', '2025-04-19 03:35:13'),
(124, 'App\\Models\\Employee', 9, 'Employee token', '2509b8815a85a78c46716a1dbb4abdfcc16f9f3718d2863a8bae3553ecf7116f', '[\"Employee\"]', NULL, '2025-04-26 03:39:19', '2025-04-19 03:39:19', '2025-04-19 03:39:19'),
(125, 'App\\Models\\Employee', 9, 'Employee token', '45481df05bc6e00ab3f8690d566261e5a776cc7444e0ca20b9ce8fbbafd5b1f0', '[\"Employee\"]', NULL, '2025-04-26 03:39:42', '2025-04-19 03:39:42', '2025-04-19 03:39:42'),
(126, 'App\\Models\\Employee', 9, 'Employee token', 'b65eee48a3d6256a72e31c3ea237a0d1b0a13ecd3fd6c96d25b743810610f0e4', '[\"Employee\"]', NULL, '2025-04-26 03:40:38', '2025-04-19 03:40:38', '2025-04-19 03:40:38'),
(127, 'App\\Models\\Employee', 9, 'Employee token', 'a7fab191772a93e2264119a82602020bae0ff9291b4310e574900eb8a03b8ff2', '[\"Employee\"]', NULL, '2025-04-26 03:42:46', '2025-04-19 03:42:46', '2025-04-19 03:42:46'),
(128, 'App\\Models\\Employee', 9, 'Employee token', '733975a87256841932eebc50ed8be57a82e4759110a00e8d38ed0f78d50c4a3c', '[\"Employee\"]', '2025-04-20 00:00:52', '2025-04-26 03:44:03', '2025-04-19 03:44:03', '2025-04-20 00:00:52'),
(129, 'App\\Models\\Employee', 9, 'Employee token', 'c5780eb64a80ac580a6c99364fbb0423bc4f51f6af56e3471e3ded414107ab6f', '[\"Employee\"]', '2025-04-19 10:00:46', '2025-04-26 09:35:51', '2025-04-19 09:35:51', '2025-04-19 10:00:46'),
(130, 'App\\Models\\User', 4, 'User token', '464199c65e109ffbd739d05aeaf8666d3313cc3de0f42acae223fc4669935cf8', '[\"user\"]', '2025-04-19 10:19:16', '2025-04-26 09:37:21', '2025-04-19 09:37:21', '2025-04-19 10:19:16'),
(131, 'App\\Models\\Employee', 9, 'Employee token', 'cb162351a88de30a7164d865edcbff048e099090c6bb1826e864c6d5ecdc4c73', '[\"Employee\"]', '2025-04-20 10:55:06', '2025-04-27 09:53:57', '2025-04-20 09:53:57', '2025-04-20 10:55:06'),
(132, 'App\\Models\\User', 4, 'User token', '65d367f23ed8bbdc667183a1dcb200f9a590b7cccb40e4618da135d8a424f5c8', '[\"user\"]', NULL, '2025-04-27 11:08:33', '2025-04-20 11:08:33', '2025-04-20 11:08:33'),
(133, 'App\\Models\\User', 4, 'User token', 'c1df5402a814dc1bc34e633860bb6bceb2cd05fc8470c4a799447eed87708eb4', '[\"user\"]', NULL, '2025-04-27 11:31:54', '2025-04-20 11:31:54', '2025-04-20 11:31:54'),
(134, 'App\\Models\\User', 4, 'User token', '6b8e599cce0609634dd1776f20caaacc6b5048b207bcabe9850bfb96731ac5f3', '[\"user\"]', '2025-04-23 05:54:31', '2025-04-30 05:54:03', '2025-04-23 05:54:03', '2025-04-23 05:54:31'),
(135, 'App\\Models\\User', 4, 'User token', 'b267c827e8464ee21de18a66b2d1c1027e340b768a1c4bd67c3ba49125aa0321', '[\"user\"]', NULL, '2025-04-30 05:55:00', '2025-04-23 05:55:00', '2025-04-23 05:55:00'),
(137, 'App\\Models\\Employee', 9, 'Employee token', '5abef86e528ef7148b445dae7d79f7fbd967cabdcc169158acfbd46f896b7894', '[\"Employee\"]', '2025-04-26 01:34:04', '2025-05-01 00:01:49', '2025-04-24 00:01:49', '2025-04-26 01:34:04'),
(138, 'App\\Models\\Employee', 9, 'Employee token', '8d73ce48ff053a0dba8659b6161df0f04af930c9f81da90e146b12681b762091', '[\"Employee\"]', '2025-04-24 10:11:07', '2025-05-01 09:57:33', '2025-04-24 09:57:33', '2025-04-24 10:11:07'),
(139, 'App\\Models\\Employee', 9, 'Employee token', '78edd628267bf160f8e50179336878e27e167078063f943151445d9ed9dfde92', '[\"Employee\"]', '2025-04-26 01:30:06', '2025-05-01 10:11:41', '2025-04-24 10:11:41', '2025-04-26 01:30:06'),
(140, 'App\\Models\\Employee', 9, 'Employee token', '0054ee0cda2eb6d0d24b5b67e33a0545ce8e6888c7cd01efe9191bb3b3518f3d', '[\"Employee\"]', '2025-04-26 01:38:15', '2025-05-03 01:30:49', '2025-04-26 01:30:49', '2025-04-26 01:38:15'),
(141, 'App\\Models\\User', 4, 'User token', '00c17a7f8b1bae1bc6ec63fc0d2bc6f507dfe560361915db164f26fa25247169', '[\"user\"]', NULL, '2025-05-03 02:14:01', '2025-04-26 02:14:01', '2025-04-26 02:14:01'),
(143, 'App\\Models\\Employee', 9, 'Employee token', '38269eb1372ddd86889ddda36fc268c00fae52dbcaef1efa88098df2c443849a', '[\"Employee\"]', '2025-04-26 09:16:01', '2025-05-03 08:50:45', '2025-04-26 08:50:45', '2025-04-26 09:16:01'),
(144, 'App\\Models\\User', 4, 'User token', 'e8548ea4bb8dcafc87f5bc8b2daf284e7221cb19341cea5d052a64966bd30355', '[\"user\"]', NULL, '2025-05-03 09:22:10', '2025-04-26 09:22:10', '2025-04-26 09:22:10'),
(145, 'App\\Models\\User', 4, 'User token', '3055ecdecc7b0d96212fb8dd819ec044cec0bd79d5c4c61d315ac85c88d3ebff', '[\"user\"]', NULL, '2025-05-03 09:22:32', '2025-04-26 09:22:32', '2025-04-26 09:22:32'),
(146, 'App\\Models\\User', 4, 'User token', '1616fee0bd49a5fd18093af1862d96325955c2220754200671f0362568c97f01', '[\"user\"]', '2025-04-26 09:32:28', '2025-05-03 09:23:56', '2025-04-26 09:23:56', '2025-04-26 09:32:28'),
(147, 'App\\Models\\User', 4, 'User token', '65cae7c7c10bc23f261f6a740066dc9cb658b5659f1368187c62a015b276a369', '[\"user\"]', '2025-04-26 09:50:04', '2025-05-03 09:29:33', '2025-04-26 09:29:33', '2025-04-26 09:50:04'),
(148, 'App\\Models\\Employee', 9, 'Employee token', '9a9a94fb4bb8a5db3eebf8e1c973d50d126f541cc06436df7fe4395714dbda04', '[\"Employee\"]', '2025-04-27 23:40:28', '2025-05-04 23:37:57', '2025-04-27 23:37:57', '2025-04-27 23:40:28'),
(149, 'App\\Models\\Employee', 2, 'Employee token', 'cdd3b7f357b1193b12332eb0c6dcdf8a76a7423b87704dc74d18582cb2d076d1', '[\"Employee\"]', NULL, '2025-05-08 08:08:35', '2025-05-01 08:08:35', '2025-05-01 08:08:35'),
(151, 'App\\Models\\Employee', 3, 'Employee token', '3428cb5b3fd86b7a4f462be1f03e193649500f6834712cb59633b055aebc04cf', '[\"Employee\"]', NULL, '2025-05-08 08:11:47', '2025-05-01 08:11:47', '2025-05-01 08:11:47'),
(152, 'App\\Models\\Employee', 1, 'Employee token', 'e064ce93c5b9a5f8947f389e3de45ec0e8675d8357188a9622ec5e8149e7b14d', '[\"Employee\"]', NULL, '2025-05-08 08:12:34', '2025-05-01 08:12:34', '2025-05-01 08:12:34'),
(153, 'App\\Models\\Employee', 10, 'Employee token', 'a34ff0f32da9b3a35d9d05e58448060d1d6e5f530bed672cb756efa1d7800c54', '[\"Employee\"]', NULL, '2025-05-08 08:12:50', '2025-05-01 08:12:50', '2025-05-01 08:12:50'),
(154, 'App\\Models\\Employee', 3, 'Employee token', '4bbce539a16e41a893d6f2b59a6492c8f4a7dd174692ea3bd02959a6c79665cf', '[\"Employee\"]', NULL, '2025-05-08 08:31:02', '2025-05-01 08:31:02', '2025-05-01 08:31:02'),
(155, 'App\\Models\\Employee', 2, 'Employee token', '02abdb7c65e65f07aa4921c0178f1db8b6cb715861a4ad4d56d92a4bdc8c357a', '[\"Employee\"]', NULL, '2025-05-08 08:42:10', '2025-05-01 08:42:10', '2025-05-01 08:42:10'),
(157, 'App\\Models\\Employee', 2, 'Employee token', 'c822c3bc77ea796eb912eaec5a55945d20af0aa5c9f4c85c082243edac40124c', '[\"Employee\"]', '2025-05-03 23:14:34', '2025-05-10 22:23:59', '2025-05-03 22:23:59', '2025-05-03 23:14:34'),
(158, 'App\\Models\\Employee', 2, 'Employee token', 'eefefcc6b34acb21cd466a1c6a10ce5c143838eef043b6474628a044416b9073', '[\"Employee\"]', '2025-05-03 22:49:39', '2025-05-10 22:34:06', '2025-05-03 22:34:06', '2025-05-03 22:49:39'),
(166, 'App\\Models\\Employee', 2, 'Employee token', 'f99ec62aca5f6a59cc81615470e04828a920357eef74f8622f668c76bba90713', '[\"Employee\"]', '2025-05-05 10:18:08', '2025-05-11 22:02:42', '2025-05-04 22:02:42', '2025-05-05 10:18:08'),
(167, 'App\\Models\\Employee', 2, 'Employee token', 'a7fffac1ae73919b51201a78403c459dec81c361c42d55c8b7961582c12005cc', '[\"Employee\"]', NULL, '2025-05-12 02:16:01', '2025-05-05 02:16:01', '2025-05-05 02:16:01'),
(169, 'App\\Models\\Employee', 2, 'Employee token', 'd195ad01ae7b99d992c029aa3a1f9a2f02778351dcac27bcde74304bc9cf9435', '[\"Employee\"]', NULL, '2025-05-12 02:21:09', '2025-05-05 02:21:09', '2025-05-05 02:21:09'),
(170, 'App\\Models\\Employee', 1, 'Employee token', 'a67bca3f1cbc869ffb62de4833fe357c02aa1f159a51173b40860817321f5de8', '[\"Employee\"]', NULL, '2025-05-12 02:28:24', '2025-05-05 02:28:24', '2025-05-05 02:28:24'),
(171, 'App\\Models\\Employee', 1, 'Employee token', '5b6467b0ca9a0db9a0c76e67b480f94ec606d3873c8e7517086bd6147f4f0853', '[\"Employee\"]', NULL, '2025-05-12 02:29:52', '2025-05-05 02:29:52', '2025-05-05 02:29:52'),
(172, 'App\\Models\\Employee', 10, 'Employee token', '1171dd65c17925ab794e75e3f1577fc90578a91ad97feaafeae9caa096444723', '[\"Employee\"]', '2025-05-05 05:22:05', '2025-05-12 02:36:24', '2025-05-05 02:36:24', '2025-05-05 05:22:05'),
(174, 'App\\Models\\Employee', 10, 'Employee token', '602a7516b55a34e5080624165e73d5b2c03191892914e2efb8aec3760358cc89', '[\"Employee\"]', NULL, '2025-05-12 06:39:57', '2025-05-05 06:39:57', '2025-05-05 06:39:57'),
(175, 'App\\Models\\Employee', 10, 'Employee token', '75e5f64c6e8b4dfb42e4d7ab45b1ab56eacbdc83c6f660dec5cb297d265966b2', '[\"Employee\"]', NULL, '2025-05-12 06:47:30', '2025-05-05 06:47:30', '2025-05-05 06:47:30'),
(176, 'App\\Models\\Employee', 11, 'Employee token', '2772803e8c2d7c271ac16150de796d043bb22fa29709b153e45f5ad7da2711d3', '[\"Employee\"]', NULL, '2025-05-12 07:40:08', '2025-05-05 07:40:08', '2025-05-05 07:40:08'),
(178, 'App\\Models\\Employee', 2, 'Employee token', 'c87538967422b495899659194593653190313aab48a18f58fb1a1b18677a0488', '[\"Employee\"]', NULL, '2025-05-12 07:41:24', '2025-05-05 07:41:24', '2025-05-05 07:41:24'),
(179, 'App\\Models\\Employee', 11, 'Employee token', '85316b03f8313d0f8a0198df445cbd00093786f58747c80180e01cc8008ce9b7', '[\"Employee\"]', NULL, '2025-05-12 07:43:14', '2025-05-05 07:43:14', '2025-05-05 07:43:14'),
(181, 'App\\Models\\Employee', 11, 'Employee token', '767107d06798d021d2662ca403ebb532dc4766f3ea6b8317e1a978bd5186ee47', '[\"Employee\"]', NULL, '2025-05-12 09:39:38', '2025-05-05 09:39:38', '2025-05-05 09:39:38'),
(182, 'App\\Models\\User', 26, 'API Token', 'f1709eb44798b7eda76d5ac819930425893e8ce81f7815cef5ca8166449c23f8', '[\"*\"]', NULL, NULL, '2025-05-05 10:00:23', '2025-05-05 10:00:23'),
(183, 'App\\Models\\User', 27, 'API Token', '74b39214d011fe6b6c3036fcb4fcc58f7226fe72c0953422a057822878c8a669', '[\"*\"]', NULL, NULL, '2025-05-05 10:04:55', '2025-05-05 10:04:55'),
(184, 'App\\Models\\User', 28, 'API Token', '091bd448cf34b6bb2bf4644533783497af86772a2afef0585955730bba24f06c', '[\"*\"]', '2025-05-07 23:36:06', NULL, '2025-05-05 10:09:36', '2025-05-07 23:36:06'),
(185, 'App\\Models\\Employee', 2, 'Employee token', '471a6561d19b5443bb2a87cfa778f8643f70ed176bb336beacd7330b7c2b3b3f', '[\"Employee\"]', '2025-05-09 18:07:37', '2025-05-15 00:29:45', '2025-05-08 00:29:45', '2025-05-09 18:07:37'),
(186, 'App\\Models\\User', 27, 'User token', '40d9f3b1d4d3f8f6acd94ecbeae90e95765cdf4be1f35179d383c300ea2487f8', '[\"user\"]', '2025-05-09 22:00:29', '2025-05-16 01:14:48', '2025-05-09 01:14:48', '2025-05-09 22:00:29'),
(187, 'App\\Models\\User', 4, 'User token', 'c608c6d9644aade4a85066599a5426da839708130e3e31627a9ad7ddef4496a6', '[\"user\"]', '2025-05-12 08:43:05', '2025-05-19 08:16:02', '2025-05-12 08:16:02', '2025-05-12 08:43:05');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Senior Manager', 'Quản lý cấp cao', NULL, '2025-03-26 03:13:21'),
(2, 'Quản lý', 'Quản lý chung', '2025-03-24 06:44:23', '2025-03-24 06:44:23'),
(3, 'shiper', 'giao hàng', '2025-03-24 06:44:32', '2025-04-26 00:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image_url`, `category_id`, `created_at`, `updated_at`) VALUES
(2, 'Tình đầu thơ ngây', 'hoa xink', '330000.00', 72, 'assets/images/1745065078.jpg', 3, '2025-03-26 09:34:03', '2025-05-09 21:52:21'),
(3, 'Ngọt ngào', 'Hoa không chỉ là một món quà, mà còn là cách bày tỏ yêu thương chân thành. Một bó hồng cho người vợ tảo tần, một cành hướng dương vàng tươi dành tặng bạn thân, hay một nhành cẩm chướng gửi đến người mẹ yêu dấu – mỗi bông hoa đều mang theo thông điệp trân quý. Ngày 8/3 này, hãy để những đóa hoa thay bạn nói lời yêu thương và biết ơn đến những người phụ nữ quan trọng nhất! *Lưu ý: Do dịp lễ nhu cầu nguyên phụ liệu tăng cao, nếu thiếu hoặc hết hàng, shop xin phép thay thế hoa và phụ kiện tương tự nhưng vẫn đảm bảo tính thẩm mỹ. Rất mong Quý khách thông cảm! Sản phẩm bao gồm: Calimero nâu: 7 Green bell: 2 Hoa baby : 0,5 Hồng Pink Mondial : 5 Đồng tiền hồng nhí : 5', '400000.00', 90, 'assets/images/1746456376.jpg', 3, '2025-04-11 05:44:53', '2025-05-09 21:53:00'),
(4, 'Hoa Hồng Pháp', 'lãng mạn', '500000.00', 89, 'assets/images/1746456424.jpg', 3, '2025-04-11 05:44:59', '2025-05-09 21:30:23'),
(5, 'Hoa sinh nhật', 'Sản phẩm bao gồm: Hoa Sao tím: 1 Lá phụ khác: 7 Purple Ohara : 18', '400000.00', 97, 'assets/images/1746456479.jpg', 4, '2025-04-11 05:45:04', '2025-05-09 11:04:14'),
(6, 'Hoa sinh nhật premium', 'Sản phẩm bao gồm: Hồng tím cà: 30', '500000.00', 99, 'assets/images/1746456871.jpg', 4, '2025-04-11 05:45:10', '2025-05-09 20:47:15'),
(7, 'Hoa sinh nhật Luxury', 'Sản phẩm bao gồm: Cẩm chướng đơn hồng: 10 Cúc mẫu đơn hồng đậm NK : 2 Cúc mẫu đơn hồng đào NK : 4 Cúc mẫu đơn đỏ NK: 4 Hồng song hỷ cồ : 10', '900000.00', 92, 'assets/images/1746456740.jpg', 4, '2025-04-11 07:24:02', '2025-05-09 22:00:19'),
(8, 'Hoa chúc mừng pro', 'Sản phẩm bao gồm: Cẩm chướng đơn trắng : 20 (nhuộm xanh dương) Cúc lưới trắng : 3 (nhuộm xanh dương) Cúc mai trắng: 20 (có thể thay cúc rossi trắng) Cúc mẫu đơn xanh dương nhạt : 5 Hoa baby : 3 Hồng da: 15', '800000.00', 97, 'assets/images/1746456994.jpg', 5, '2025-04-11 08:01:46', '2025-05-05 07:57:58'),
(9, 'Hoa chúc mừng Congrats', 'Cao khoảng 70cm, kệ hoa mini này tạo điểm nhấn tinh tế cho không gian với kích thước vừa phải và không chiếm nhiều diện tích. Các loại hoa chính bao gồm hoa hướng dương tươi sáng, hoa ly vàng rực rỡ, cùng hoa hồng và hoa cúc màu cam nhạt, tạo nên một sự phối hợp màu sắc hài hòa và ấm áp. Kệ hoa này phù hợp để trưng bày trên bàn, quầy bar, lế tân,... trong các sự kiện như khai trương, chúc mừng, hoặc có thể làm quà tặng ý nghĩa trong sự kiện riêng tư, đặc biệt nào đó. Sản phẩm bao gồm: Cúc calimero vàng nhụy nâu : 5 Hồng trứng gà : 10 Hướng dương : 2 Lan vũ nữ: 5 Môn xanh: 5', '800000.00', 99, 'assets/images/1746456838.jpg', 5, '2025-04-11 08:19:04', '2025-05-05 07:53:58'),
(10, 'Hoa chúc mừng', 'Thành công là cả môt quá trình, một con đường mà bất kì ai cũng muốn được bước đi, nhưng mấy ai kiên trì và nhẫn nại để bước tới đến vinh quang của nó. Thành công đôi khi là mục tiêu nhưng đôi khi là môt chặng đường gian nan đòi hỏi ở người đi môt cái nhìn lạc quan và niềm tin mạnh mẽ để lên đỉnh thành công. Kệ hoa được tao ra với mong muốn giúp người nhận có một \"khởi đầu thuận lợi\" Sản phẩm bao gồm: Cúc mai xanh : 10 Dương xỉ pháp : 40 Hồng vàng ánh trăng : 40 Lá mật cật : 5 Lan Moka vàng nến: 33 Mõm sói vàng: 20 Môn xanh: 22 Đồng tiền vàng : 60', '690000.00', 99, 'assets/images/1746456921.png', 5, '2025-04-19 04:26:32', '2025-05-05 07:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_discounts`
--

CREATE TABLE `product_discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_discounts`
--

INSERT INTO `product_discounts` (`id`, `product_id`, `percentage`, `created_at`, `updated_at`, `start_date`, `end_date`) VALUES
(2, 8, '20.00', '2025-04-11 23:13:01', '2025-04-11 23:13:01', '2025-04-10 10:00:00', '2025-04-20 12:00:00'),
(3, 9, '30.00', '2025-04-11 23:13:07', '2025-04-11 23:13:07', '2025-04-10 10:00:00', '2025-04-20 12:00:00'),
(4, 7, '20.00', '2025-04-24 00:02:10', '2025-04-24 00:02:10', '2025-04-15 10:00:00', '2025-04-30 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_ingredient`
--

CREATE TABLE `product_ingredient` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `ingredient_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_ingredient`
--

INSERT INTO `product_ingredient` (`id`, `product_id`, `ingredient_id`, `created_at`, `updated_at`) VALUES
(1, 10, 1, NULL, NULL),
(2, 10, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `product_id` bigint UNSIGNED NOT NULL,
  `size_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `day_of_week` tinyint UNSIGNED NOT NULL,
  `shift` enum('morning','afternoon','full_day') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `employee_id`, `created_at`, `updated_at`, `start_date`, `end_date`, `day_of_week`, `shift`) VALUES
(9, 1, '2025-03-26 00:33:04', '2025-03-26 00:33:04', '2025-04-03', '2025-04-03', 4, 'full_day'),
(10, 1, '2025-03-26 00:33:04', '2025-03-26 00:33:04', '2025-04-04', '2025-04-04', 5, 'morning'),
(11, 2, '2025-03-26 00:51:13', '2025-03-26 00:51:13', '2025-03-31', '2025-03-31', 1, 'morning'),
(12, 2, '2025-03-26 00:51:13', '2025-03-26 00:51:13', '2025-04-01', '2025-04-01', 2, 'afternoon'),
(13, 2, '2025-03-26 00:51:13', '2025-03-26 00:51:13', '2025-04-03', '2025-04-03', 4, 'full_day'),
(14, 2, '2025-03-26 00:51:13', '2025-03-26 00:51:13', '2025-04-04', '2025-04-04', 5, 'morning'),
(15, 3, '2025-03-26 01:00:13', '2025-03-26 01:00:13', '2025-04-02', '2025-04-02', 3, 'afternoon'),
(43, 1, '2025-04-26 01:37:33', '2025-04-26 01:37:33', '2025-04-28', '2025-04-28', 1, 'afternoon'),
(44, 1, '2025-04-26 01:37:33', '2025-04-26 01:37:33', '2025-04-29', '2025-04-29', 2, 'afternoon'),
(45, 1, '2025-04-26 01:37:33', '2025-04-26 01:37:33', '2025-04-30', '2025-04-30', 3, 'afternoon');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_modifier` int NOT NULL DEFAULT '-10',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `price_modifier`, `created_at`, `updated_at`) VALUES
(1, 'bó nhỏ', 0, NULL, NULL),
(2, 'bó lớn', 50000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_logged_in` tinyint(1) NOT NULL DEFAULT '0',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'assets/avatar_image/avatar.png',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `address`, `is_logged_in`, `last_login_at`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Văn b', 'nguyenvana@example.com', NULL, NULL, 1, '2025-03-26 04:05:38', NULL, '$2y$12$NUKByEHwBfR/R.rBiUOswOxlMtwRQxbWPHlY0TUpLYO96hU9ALZfK', 'assets/avatar_image/avatar.png', NULL, '2025-03-24 05:46:27', '2025-03-26 04:05:38'),
(2, 'Nguyen Van A', 'nguyenvana1@example.com', NULL, NULL, 0, NULL, NULL, '$2y$12$Opw2F10TutTkFfoqUvt2bOtgR1dWcrlnRCNBVI/Jo4MnuSX3Y9PIq', 'assets/avatar_image/avatar.png', NULL, '2025-03-24 09:23:23', '2025-03-24 09:23:23'),
(3, 'vinh', 'ngoquocvinh2003@gmail.com', NULL, NULL, 1, '2025-03-28 01:23:55', NULL, '$2y$12$EukMUKlgbM.4OIqsEWnJ/.PV1SXk87rrEa/zdSFXJd2lh5x.Rdlz.', 'assets/avatar_image/avatar.png', NULL, '2025-03-27 11:10:08', '2025-03-28 01:23:55'),
(4, 'jack', 'ngovinh0808@gmail.com', '0799117548', 'Vinh Long 1', 1, '2025-05-12 08:16:01', NULL, '$2y$12$kEZ2AWAptl8k.oczOOisPuvTPy.b0J8SW2Sk7GsZNI7Ii72ku2H9S', 'assets/avatar_image/1745686216.jpg', NULL, '2025-03-27 11:40:26', '2025-05-12 08:16:01'),
(5, 'vinh', 'ngovinh123@gmail.com', NULL, NULL, 1, '2025-04-16 04:13:53', NULL, '$2y$12$74TQyLnKKB9WHBixavo/a.Rn87i696qJe6HkT9mlj6BVyvf/6TK3y', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 10:59:50', '2025-04-16 04:13:53'),
(8, 'hi1', 'vinh3@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$0.KNLNGyMm9extIGf7j9H.dP3.HAyNPJWiAOKt1GPIkLEya8wtFqC', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:12:43', '2025-04-12 11:12:43'),
(9, 'vinh3', 'vinh4@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$owp8pJ53gM7NSdSWWLJnhugx2mfMFtFTSx2TljTLnNgStSXn7YkDO', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:22:41', '2025-04-12 11:22:41'),
(10, 'vinh1', 'vinh5@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$gxyc.BVWG2h46QqwlQ4YI.i0nZ2JThsvabNq1SeuXWFecGiPRdZMK', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:25:34', '2025-04-12 11:25:34'),
(11, 'vinh3', 'vinh6@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$jl2.G0mRybD.NeO3dUDYYufywxGE2ywcEnxSTN83ZedKkHVk3El9O', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:29:22', '2025-04-12 11:29:22'),
(12, '1', 'vinh7@gmail.com', NULL, NULL, 0, '2025-04-12 11:32:05', NULL, '$2y$12$ZUuD4FJ8ClsWR9J2VwcKx.G93kTP99x5Y6Gpt39LUymphffvCgcQ6', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:31:16', '2025-04-12 11:41:41'),
(13, 'ngovinh', 'vin1@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$yY7x0pSoGhYvy1fViZg2MuGDDQFClu4Id2UOOOoR1iK11v8FpJELG', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:41:57', '2025-04-12 11:41:57'),
(14, 'vinh', 'vin2@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$JbaAuEuj9oz4lNhaUHkAm.SRfs/4zTvFLY02VB8GrMDMPz3ngaKSa', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:45:30', '2025-04-12 11:45:30'),
(15, 'vinh', 'sdf@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$D7evqTNDxwhFVU1yQKf3DeSKN9YoptT9YSsQ2unCJXNvOMKp8o48K', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:48:02', '2025-04-12 11:48:02'),
(16, 'sadasd', 'asdsa@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$Nwx9vzJa5y0SWjxC8D1gRurUJdNdz6imyvT9bB/h1XVtVHKNRsvUO', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:50:33', '2025-04-12 11:50:33'),
(17, 'vinh', 'ngovinh1234@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$KMhkQt2FyytOOThFGpzjg.kqi.WgG.3AOIjeXrYdCODiCxlzIbIJ.', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:55:14', '2025-04-12 11:55:14'),
(18, 'Nguyen Van A', 'ngovinh11@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$FOZ6LxLjwPh0NUhUhT812.vq/cTR/pOy2krbzxQrqLafx3eXxc7Ka', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:56:45', '2025-04-12 11:56:45'),
(19, 'sadasd', 'asds1a@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$n/i9KN30LHpfi2F3GqqbheyFzvfHoomzrs5s/7T/.NlGsST6EOgC2', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:57:16', '2025-04-12 11:57:16'),
(20, 'asdasd', 'asd@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$SepVPEjy/djbs02fCsygaeI4wxrpsYcyFtnJwnWo.u/2D/O.0goOW', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 11:59:57', '2025-04-12 11:59:57'),
(21, 'asdasd', 'adss@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$bjosRmXO4EP/w/G1JMd/i.XBKJXL0MY8f0Dlxm2zJmdQqhPMcYcHe', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 12:01:16', '2025-04-12 12:01:16'),
(22, 'sdffsd', 'sdf2@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$XJE74VrL.aJOm18n1tbEsuiy87qJ7haBcwzH0BKRit70TaKNFAQG2', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 12:02:20', '2025-04-12 12:02:20'),
(23, 'fssdf', 'sdfs@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$UI3IOAiBdhbgq5gTU8fpO.Lo5mu365tqFCKeCM3km1ualAK28XgpO', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 12:04:09', '2025-04-12 12:04:09'),
(24, 'ffsdf', 'sfdf@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$viquPemtaNPSn5VmB6DS4O1ovr758DbUinVNAF8AXOR8tsnP9UPJC', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 12:06:48', '2025-04-12 12:06:48'),
(25, 'asdasd', 'asdasd@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$0LRRrsqFlI.m9Ua3vrEGE.kiKf2S4ErEE/gXWLjhuBVHrMsseIM4m', 'assets/avatar_image/avatar.png', NULL, '2025-04-12 12:14:34', '2025-04-12 12:14:34'),
(26, 'test1', 'test1@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$x9iAIJvNnFIQLTA51tAz5eYKN0Ic7twnwdb/NN/hB2gaOJ8gtebG2', 'assets/avatar_image/avatar.png', NULL, '2025-05-05 10:00:23', '2025-05-05 10:00:23'),
(27, 'test02', 'test02@gmail.com', '0123456789', 'sg', 1, '2025-05-09 01:14:48', NULL, '$2y$12$inJTb9.u8CVMCMP4Y0d6wOmafg6Pns4Qtkf.jVn8g43uhFNu1.8Mu', 'assets/avatar_image/avatar.png', NULL, '2025-05-05 10:04:55', '2025-05-09 19:20:48'),
(28, 'test03', 'test03@gmail.com', NULL, NULL, 0, NULL, NULL, '$2y$12$TnW4h2FCBMYen68XMSw1puw1pYJunSIgaEnYzD3d3pawuS.E4g21K', 'assets/avatar_image/avatar.png', NULL, '2025-05-05 10:09:36', '2025-05-05 10:09:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `color_product`
--
ALTER TABLE `color_product`
  ADD PRIMARY KEY (`product_id`,`color_id`),
  ADD KEY `color_product_color_id_foreign` (`color_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discounts_code_unique` (`code`);

--
-- Indexes for table `discount_conditions`
--
ALTER TABLE `discount_conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discount_conditions_discount_id_foreign` (`discount_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_position_id_foreign` (`position_id`);

--
-- Indexes for table `employee_category`
--
ALTER TABLE `employee_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_category_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_category_category_id_foreign` (`category_id`);

--
-- Indexes for table `employee_product`
--
ALTER TABLE `employee_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_product_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_product_product_id_foreign` (`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_order_id_foreign` (`order_id`),
  ADD KEY `invoices_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_discount_id_foreign` (`discount_id`),
  ADD KEY `orders_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_item_color`
--
ALTER TABLE `order_item_color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_color_order_item_id_foreign` (`order_item_id`),
  ADD KEY `order_item_color_color_id_foreign` (`color_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_name_unique` (`name`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_discounts`
--
ALTER TABLE `product_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_discounts_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_ingredient`
--
ALTER TABLE `product_ingredient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ingredient_product_id_foreign` (`product_id`),
  ADD KEY `product_ingredient_ingredient_id_foreign` (`ingredient_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`product_id`,`size_id`),
  ADD KEY `product_size_size_id_foreign` (`size_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `discount_conditions`
--
ALTER TABLE `discount_conditions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee_category`
--
ALTER TABLE `employee_category`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `employee_product`
--
ALTER TABLE `employee_product`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `order_item_color`
--
ALTER TABLE `order_item_color`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_discounts`
--
ALTER TABLE `product_discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_ingredient`
--
ALTER TABLE `product_ingredient`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `color_product`
--
ALTER TABLE `color_product`
  ADD CONSTRAINT `color_product_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `color_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discount_conditions`
--
ALTER TABLE `discount_conditions`
  ADD CONSTRAINT `discount_conditions_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_category`
--
ALTER TABLE `employee_category`
  ADD CONSTRAINT `employee_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_category_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_product`
--
ALTER TABLE `employee_product`
  ADD CONSTRAINT `employee_product_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employee_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_item_color`
--
ALTER TABLE `order_item_color`
  ADD CONSTRAINT `order_item_color_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_color_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_discounts`
--
ALTER TABLE `product_discounts`
  ADD CONSTRAINT `product_discounts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_ingredient`
--
ALTER TABLE `product_ingredient`
  ADD CONSTRAINT `product_ingredient_ingredient_id_foreign` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ingredient_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_size_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
