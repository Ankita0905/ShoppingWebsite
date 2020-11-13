-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 18, 2020 at 07:30 AM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imran`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT '',
  `status` tinyint(4) DEFAULT '1' COMMENT '1 => active, 2 => inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Mobiles', 1, '2020-10-16 12:40:36', '2020-10-18 00:50:54', NULL, 1, 1, NULL),
(2, 'Desktop', 1, '2020-10-16 12:40:55', '2020-10-18 00:51:31', NULL, 1, 1, NULL),
(3, 'Audio Devices', 1, '2020-10-16 12:41:05', '2020-10-18 00:51:23', NULL, 1, 1, NULL),
(4, 'Gaming Console', 1, '2020-10-16 12:41:15', '2020-10-16 12:41:15', NULL, 1, NULL, NULL),
(5, 'Home Appliances', 1, '2020-10-16 12:41:24', '2020-10-17 11:19:09', NULL, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `email` varchar(255) DEFAULT '',
  `message` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Test', 'test@gmail.com', 'this is first line\r\nthis is second line', '2020-10-16 21:59:06', '2020-10-16 21:59:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) DEFAULT NULL,
  `payment_mode` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 => cash, 2=> online',
  `order_number` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 => pending, 2 => complete',
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `total_item` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `address`, `payment_mode`, `order_number`, `order_date`, `order_status`, `user_id`, `total_price`, `total_item`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'near bus stand', 1, '0001', '2020-10-16', 3, 1, '458832.00', 37, '2020-10-16 13:24:59', '2020-10-16 13:30:44', NULL),
(2, 'Testing address', 1, '0002', '2020-10-17', 3, 18, '190485.00', 48, '2020-10-16 22:08:19', '2020-10-16 22:09:16', NULL),
(3, 'Testing address information', 1, '0003', '2020-10-17', 3, 16, '127830.00', 17, '2020-10-16 23:56:07', '2020-10-16 23:56:17', NULL),
(4, 'Testing address information', 1, '0004', '2020-10-17', 3, 16, '324141.00', 82, '2020-10-17 11:16:27', '2020-10-17 11:17:10', NULL),
(5, 'Testing address', 1, '0005', '2020-10-18', 2, 18, '2111.44', 6, '2020-10-18 01:58:59', '2020-10-18 01:58:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE IF NOT EXISTS `order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `price`, `quantity`, `total_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '13500.00', 33, '445500.00', NULL, NULL, NULL),
(2, 1, 2, '3333.00', 4, '13332.00', NULL, NULL, NULL),
(3, 2, 1, '13500.00', 3, '40500.00', NULL, NULL, NULL),
(4, 2, 2, '3333.00', 45, '149985.00', NULL, NULL, NULL),
(5, 3, 1, '13500.00', 7, '94500.00', NULL, NULL, NULL),
(6, 3, 2, '3333.00', 10, '33330.00', NULL, NULL, NULL),
(7, 4, 1, '13500.00', 5, '67500.00', NULL, NULL, NULL),
(8, 4, 2, '3333.00', 77, '256641.00', NULL, NULL, NULL),
(9, 5, 1, '202.29', 5, '1011.45', NULL, NULL, NULL),
(10, 5, 9, '1099.99', 1, '1099.99', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) DEFAULT '1' COMMENT '1 => active, 2 => inactive',
  `image` varchar(255) NOT NULL DEFAULT '''''',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `product_name`, `price`, `description`, `status`, `image`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1, 'Samsung Galaxy A20s 32GB Smartphone (SM-A207F/DS) - Dual Sim- Blue', '202.29', '<p>Samsung Galaxy A20S smartphone features a 6.5&quot; HD+ Infinity-V display, and a triple (13MP + 8MP + 5MP) rear camera. The phone has an 8MP (F2. 0) front camera. The device is available in two configurations 4 GB/64 GB and 3 GB/32 GB memory expandable up to 512 GB via a microSD card slot.</p>', 1, 'GUaFSjdp.jpeg', '2020-10-18 00:25:14', '2020-10-18 00:25:14', NULL, 1, NULL, NULL),
(2, 1, 'Apple iPhone XR, 64GB, Black', '699.99', '<p>Color Name: Black size:64 GB</p>', 1, 'QKgGaem6.jpg', '2020-10-18 00:26:05', '2020-10-18 00:26:42', NULL, 1, 1, NULL),
(3, 1, 'Samsung Galaxy S10+ Plus 128GB+8GB RAM SM-G975F/DS Dual Sim 6.4\' LTE', '809.00', '<p>6.4 inches, Dynamic AMOLED capacitive touchscreen, 16M colors, 1440 x 3040 pixels, Corning Gorilla Glass 6, 128GB Storage, 8GB RAM, Up to 512GB microSD Card slot (uses SIM 2 slot)</p>', 1, 'PgYOB6Sz.jpg', '2020-10-18 00:27:28', '2020-10-18 00:27:28', NULL, 1, NULL, NULL),
(4, 1, 'Huawei P30 Lite (128GB, 4GB RAM) 6.15\"', '339.99', '<p>AI Triple Camera, Dual SIM Global GSM IPS LCD capacitive touchscreen, 16M colors. 6.15 inches, 89.1 cm2. 1080 x 2312 pixels (~415 ppi density)</p>', 1, 'rHxlfrwq.jpg', '2020-10-18 00:28:05', '2020-10-18 00:28:05', NULL, 1, NULL, NULL),
(5, 1, 'Samsung Galaxy A71 (SM-A715F/DS) Dual SIM 4G LTE 128GB', '482.00', '<p>6.7-inch, Infinity O display with 1080 x 2400 resolution and minimum bezel for easy, uninterrupted viewing and browsing Super AMOLED display delivers faster motion response and vivid image quality, ensuring a smooth user experience</p>', 1, '8SIRHAuQ.jpg', '2020-10-18 00:28:52', '2020-10-18 00:28:52', NULL, 1, NULL, NULL),
(6, 2, 'XPS 15 Laptop', '1599.99', '<p>10th Generation Intel&reg; Core&trade; i5-10300H (8MB Cache, up to 4.5 GHz, 4 cores) &nbsp;10th Generation Intel&reg; Core&trade; i5-10300H (8MB Cache, up to 4.5 GHz, 4 cores)<br />\r\nWindows 10 Home, 64-bit, English<br />\r\nIntel&reg; UHD Graphics<br />\r\n8GB DDR4-2933MHz, 2x4G<br />\r\n256GB M.2 PCIe NVMe Solid State Drive<br />\r\nPlatinum Silver with Black Carbon Fiber Palmrest<br />\r\nPorts &amp; Slots</p>', 1, 'yt3NrWDp.jpg', '2020-10-18 00:30:54', '2020-10-18 00:30:54', NULL, 1, NULL, NULL),
(7, 2, 'ThinkPad X1 Extreme Gen 3 Laptop', '2225.40', '<p>Packed with extreme power<br />\r\n15.6&quot; powerhouse, yet portable laptop pc<br />\r\nUp to 10th Gen Intel&reg; Core&reg; vPro&trade; H series processors<br />\r\nTop professional graphic options<br />\r\nAmazing audio features<br />\r\nOptional 4K display with Dolby Vision&trade;<br />\r\nSupports up to 4 independent monitors</p>', 1, 'xOeiQMGq.jpg', '2020-10-18 00:31:38', '2020-10-18 00:31:38', NULL, 1, NULL, NULL),
(8, 2, 'Acer Aspire 5 15.6\" Laptop - Silver (Intel Ci5-1035G1/512GB SSD/20GB RAM/Windows 10)', '949.99', '<p>Display: 15.6&quot; Full HD LCD Display (1366 x 768)<br />\r\nProcessor: 1.6 GHz Intel&reg; Core&trade; i5-8265U Quad Core Processor<br />\r\nMemory: 8 GB of DDR4 SDRAM<br />\r\nStorage: 128GB Solid State Drive<br />\r\nGraphics: Intel&reg; HD Graphics 620<br />\r\nOperating System: Windows 10 Home</p>', 1, 'WXBouTYS.jpg', '2020-10-18 00:47:24', '2020-10-18 00:47:24', NULL, 1, NULL, NULL),
(9, 2, 'Inspiron 17 3000 Laptop', '1099.99', '<p>10th Generation Intel&reg; Core&trade; i7-1065G7 Processor (8MB Cache, up to 3.9 GHz)</p>', 1, 'rzmWwbAB.jpg', '2020-10-18 00:48:02', '2020-10-18 00:48:02', NULL, 1, NULL, NULL),
(10, 2, 'Microsoft Surface Laptop - Intel Core i7 / 256GB SSD / 8GB RAM - Cobalt Blue', '1199.00', '<p>13.5&rdquo; and 15&rdquo; touchscreens, rich color options,&sup1; and two durable finishes. Make a powerful statement and get improved speed, performance, and all-day battery life.&sup2;</p>', 1, 'zMPM1Xwx.jpg', '2020-10-18 00:49:10', '2020-10-18 00:49:10', NULL, 1, NULL, NULL),
(11, 3, 'Bose QuietComfort 35 (Series II)', '399.00', '<p>Brand:&nbsp;&nbsp; &nbsp;BOSE<br />\r\nConnections:&nbsp;&nbsp; &nbsp;Bluetooth, Wired, NFC<br />\r\nModel Name:&nbsp;&nbsp; &nbsp;Quietcomfort 35 II<br />\r\nColour:&nbsp;&nbsp; &nbsp;Black<br />\r\nNoise control:&nbsp;&nbsp; &nbsp;Active Noise Cancellation</p>', 1, 'TaVbBt9k.jpg', '2020-10-18 00:52:26', '2020-10-18 00:52:26', NULL, 1, NULL, NULL),
(12, 3, 'Sony MDRZX110 Over-Ear Headphones', '24.98', '<p>Brand:&nbsp;&nbsp; &nbsp;Sony<br />\r\nConnections:&nbsp;&nbsp; &nbsp;Wired<br />\r\nModel Name:&nbsp;&nbsp; &nbsp;MDRZX110/BLK ZX<br />\r\nColour:&nbsp;&nbsp; &nbsp;Black<br />\r\nHeadphones: Form Factor&nbsp;&nbsp; &nbsp;Closed-back</p>', 1, 'eJcneL8Z.jpg', '2020-10-18 00:53:12', '2020-10-18 00:53:12', NULL, 1, NULL, NULL),
(13, 3, 'Samsung Galaxy Buds+', '179.72', '<p>adaptive 3 microphone system.Charge for 3 minutes and get 1 hour of playtime.22 hours of total battery life</p>', 1, 'aDyofXEA.jpg', '2020-10-18 00:53:44', '2020-10-18 00:53:44', NULL, 1, NULL, NULL),
(14, 3, 'Apple AirPods Pro', '320.00', '<p>Brand:&nbsp;&nbsp; &nbsp;Apple<br />\r\nConnections:&nbsp;&nbsp; &nbsp;Bluetooth, Wired<br />\r\nHeadphones :Form Factor&nbsp;&nbsp; &nbsp;In Ear<br />\r\nNoise control:&nbsp;&nbsp; &nbsp;Active Noise Cancellation<br />\r\nHeadphones Jack&nbsp;&nbsp; &nbsp;:Lightning</p>', 1, 'hrHX1aSE.jpg', '2020-10-18 00:54:14', '2020-10-18 00:54:14', NULL, 1, NULL, NULL),
(15, 3, 'JBL T110 in Ear Headphones', '19.99', '<p>Brand:&nbsp;&nbsp; &nbsp;JBL<br />\r\nConnections:&nbsp;&nbsp; &nbsp;Wired<br />\r\nModel Name:&nbsp;&nbsp; &nbsp;T110<br />\r\nColour:&nbsp;&nbsp; &nbsp;Black<br />\r\nHeadphones: Form Factor&nbsp;&nbsp; &nbsp;In Ear</p>', 1, 'PCqRLIiy.jpg', '2020-10-18 00:57:57', '2020-10-18 00:57:57', NULL, 1, NULL, NULL),
(16, 5, 'Instant Pot® Lux 6-in-1 Multi-Use Programmable Pressure Cooker', '89.97', '<p>Accessories include, stainless steel steam rack without handles, rice paddle, soup spoon, measuring cup, recipe booklet (English), and manual and time table ; Power supply: 120V &ndash; 60Hz</p>', 1, 'UZMieU2j.jpg', '2020-10-18 01:00:04', '2020-10-18 01:00:04', NULL, 1, NULL, NULL),
(17, 5, 'Chefman 6.3 Quart Digital Air Fryer', '168.30', '<p>Rotisserie, Dehydrator, Convection Oven, 8 Touch Screen Presets Fry, Roast, Dehydrate &amp; Bake, BPA-Free, Auto Shutoff, Accessories Included, XL Family Size</p>', 1, 'vHc5WZ3W.jpg', '2020-10-18 01:00:37', '2020-10-18 01:00:37', NULL, 1, NULL, NULL),
(18, 5, 'Utopia Home Hand Blender', '51.99', '<p>Colour:&nbsp;&nbsp; &nbsp;Black and silver<br />\r\nMaterial:&nbsp;&nbsp; &nbsp;Stainless Steel<br />\r\nBrand:&nbsp;&nbsp; &nbsp;Utopia Home<br />\r\nItem Dimensions: LxWxH&nbsp;&nbsp; &nbsp;23.7 x 22 x 12.3 centimeters<br />\r\nPower / Wattage:&nbsp;&nbsp; &nbsp;300 Watts<br />\r\nIs Dishwasher Safe:&nbsp;&nbsp; &nbsp;Yes<br />\r\nMaterial type free:&nbsp;&nbsp; &nbsp;BPA Free</p>', 1, 'c8EnFeGZ.jpg', '2020-10-18 01:01:29', '2020-10-18 01:01:29', NULL, 1, NULL, NULL),
(19, 5, 'COSORI 1.7L Glass Electric Kettle', '49.99', '<p>Brand:&nbsp;&nbsp; &nbsp;COSORI<br />\r\nColour&nbsp;&nbsp; &nbsp;:Clear<br />\r\nCapacity:&nbsp;&nbsp; &nbsp;1.7 liters<br />\r\nMaterial&nbsp;&nbsp; &nbsp;:Stainless Steel, Borosilicate :Glass<br />\r\nVoltage&nbsp;&nbsp; &nbsp;120<br />\r\nWattage&nbsp;&nbsp; &nbsp;:1500 Watts<br />\r\nItem Dimensions: LxWxH&nbsp;&nbsp; &nbsp;20.1 x 15.5 x 24.1 centimeters</p>', 1, 'L6srvcc8.jpg', '2020-10-18 01:02:00', '2020-10-18 01:02:00', NULL, 1, NULL, NULL),
(20, 5, 'Keurig K-Mini Coffee Maker', '160.13', '<p>Model Name:&nbsp;&nbsp; &nbsp;Coffee Maker<br />\r\nBrand:&nbsp;&nbsp; &nbsp;Keurig<br />\r\nColour:&nbsp;&nbsp; &nbsp;Dusty Rose<br />\r\nVoice command:&nbsp;&nbsp; &nbsp;Buttons</p>', 1, 'CBHsijZY.jpg', '2020-10-18 01:02:34', '2020-10-18 01:02:34', NULL, 1, NULL, NULL),
(21, 4, 'Xbox One S 1TB Console - Xbox One S Edition', '379.96', '<p>Watch 4K Blu-ray movies; stream 4K video on Netflix, Amazon, and YouTube, among others; and listen to music with Spotify. Play over 2, 200 games including more than 200 exclusives and over 600 classics from Xbox 360 and original Xbox.&nbsp;</p>', 1, 'trQ0dfKf.jpg', '2020-10-18 01:04:19', '2020-10-18 01:04:19', NULL, 1, NULL, NULL),
(22, 4, 'SeeKool 3D Pandora X Arcade Game Console', '294.99', '<p>1920x1080 FULL HD. Wide Compatible &amp; Customized Buttons. NEWEST Smooth 3D SYSTEM. Support TF Card &amp; USB Drive</p>', 1, 'Iucn9Pue.jpg', '2020-10-18 01:04:51', '2020-10-18 01:04:51', NULL, 1, NULL, NULL),
(23, 4, 'Nintendo Switch with Gray Joy-Con', '399.99', '<p>The Nintendo Switch combines the mobility of a handheld with the power of a home gaming system, offering unprecedented gaming and entertainment experiences The Nintendo Switch and Dock connects the system to the TV and lets you play with your family and friends in the comfort of your living room</p>', 1, 'XTQTehHK.jpg', '2020-10-18 01:09:47', '2020-10-18 01:10:02', NULL, 1, 1, NULL),
(24, 4, 'PlayStation 4 Pro 1TB Console', '750.00', '<p>4K TV Gaming &ndash; PS4 Pro outputs gameplay to your 4K TV<br />\r\nMore HD Power &ndash; Turn on Boost Mode to give PS4 games access to the increased power of PS4 Pro<br />\r\nHDR Technology&ndash; With an HDR TV, compatible PS4 games display an unbelievably vibrant and lifelike range of colors</p>', 1, 'coQx4BQ4.jpg', '2020-10-18 01:10:37', '2020-10-18 01:10:37', NULL, 1, NULL, NULL),
(25, 4, 'GPD XD Plus [2019 HW Update] Handheld Gaming Console', '339.99', '<p>5&quot; Touchscreen Android 7.0 Portable Video Game Player Laptop MT8176 Hexa-core CPU,PowerVR GX6250 GPU,4GB/32GB,Support Google Store</p>', 1, 'IkLTjmAW.jpg', '2020-10-18 01:11:09', '2020-10-18 01:11:09', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` tinyint(4) DEFAULT '1' COMMENT '1 => admin, 2 => super sub admin, 3 => sub admin, 4 => consumer',
  `mobile_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `mobile_number`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$Ioh0rU3sOy5iQezmV0hZS.nEEeeoAsTCcQcDISkVnO1A6vKplLX3e', 1, '', '', 'GqHr10TcQZolfyAcIu1saNYFbs7H4oG7Yd8TKg1kMq9OdO0pKC8AnstoBAlG', '2019-01-03 07:57:52', '2019-01-03 07:57:52'),
(7, 'Sumeet Narula', 'admin1@gmail.com', '$2y$10$qKgVe/.zSKlgYMwhojI5p.iDvrmvAr1sW9hfRE2FkniBm9uyJK/i.', 2, '', '', NULL, '2019-09-29 00:59:20', '2019-09-29 00:59:20'),
(8, 'test', 'test@gmail.com', '$2y$10$C9se19bTqzxLsbbYOny.yuuOvNd1dfwPUPSl9acNfcEkXvQ0elapy', 2, '', '', 'mUVKuT1hmkHFg1ovjRtSrWOJPKxIC9cUdt2rXyteYCnsk1rom9dA43mswJM1', '2019-09-29 01:01:41', '2019-09-29 01:01:41'),
(9, 'register', 'register@gmail.com', '$2y$10$s.5bmf4cm7TyGpDE7DwUlO7vz0/Zzrkh3oiUoesxEgXF3cL5AuvHC', 2, '', '', NULL, '2019-09-30 10:26:51', '2019-09-30 10:26:51'),
(10, 'new', 'new@gmail.com', '$2y$10$zceljef3r2TBTD2pwy4LsuAANoEu0uHRxUKZjShMVrBZEPfv1RsC2', 2, '', '', 'g7stoTXxZ9o9wNmRwy2tAE88zkwAcLNd9rD6ygmHLSmUshIrjZt6y0Me5aij', '2019-10-01 23:30:32', '2019-10-01 23:30:32'),
(11, 'Kartik kaushal', 'dheerajkumar1905@gmail.com', '$2y$10$wGtRlZW64dKC8T/SavnvHOcSrEgtM6r6bIrdK2zEG3/QTdjMSdL/u', 2, '', '', NULL, '2019-10-03 21:48:30', '2019-10-03 21:48:30'),
(12, 'jjj', 'jjj@gmail.com', '$2y$10$CBtP4WRmdxqxuzh7JLyuMuopd9xnVLs8z6zrcjuyeN.u36Sb/qYku', 2, '8855223366', 'testing address', NULL, '2019-10-04 01:28:58', '2019-10-04 01:28:58'),
(16, 'Sumeet', 'sumeetnarula1@gmail.com', '$2y$10$j0zc5YtYFZXxkw4n9DVMXOX3yb7It37ox1YLFUlApvFsh3.FLzlXa', 2, '9988776655', 'testing address information', 'pl8DPYqUs1gdGCDJSdGFovjmP3w8CslAiGvwYqzyLBrXMSQqT8RqgGpqksGE', '2019-10-04 03:40:43', '2019-10-04 03:44:19'),
(17, 'Testing', 'testing@gmail.com', '$2y$10$aI4Egd0UWsOtRc.dJ3NX7.l2IAw9oa4Fv528MiG/RExBnu/29vZ8a', 2, '9988776655', 'Near bus stand\r\njalandhar', NULL, '2020-10-16 13:39:20', '2020-10-16 13:39:20'),
(18, 'Test', 'testnew@gmail.com', '$2y$10$qZGQnq3KIugIBo1afc80Tum93prb3Pu.Amdp75rhSvA6.VEauJnKK', 2, '9988776655', 'testing address', 'ZNJLpgu9bgaFTzSOtoWIK9Cj8bBAu3s8vbklJVrZgHbENVYCUp771m3jJjGT', '2020-10-16 22:03:04', '2020-10-16 22:03:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
