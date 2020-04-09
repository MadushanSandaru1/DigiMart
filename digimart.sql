-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 09, 2020 at 02:44 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digimart`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` varchar(6) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email`, `is_deleted`) VALUES
('ADM001', 'DigiMart', 'Admin', 'admin@digimart', 0);

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`, `logo`, `is_deleted`) VALUES
(1, 'Acer', 'acer.png', 0),
(2, 'AMD', 'amd.png', 0),
(3, 'Apple', 'apple.png', 0),
(4, 'Asus', 'asus.png', 0),
(5, 'Biostar', 'biostar.png', 0),
(6, 'Dell', 'dell.png', 0),
(7, 'Gigabyte', 'gigabyte.png', 0),
(8, 'HP', 'hp.png', 0),
(9, 'Intel', 'intel.png', 0),
(10, 'Lenovo', 'lenovo.png', 0),
(11, 'MSI', 'msi.png', 0),
(12, 'Nvidia', 'nvidia.png', 0),
(13, 'Samsung', 'samsung.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `type`, `icon`, `is_deleted`) VALUES
(1, 'Laptop', 'laptop.png', 0),
(2, 'Desktop Workstation', 'desktop_workstation.png', 0),
(3, 'Gaming Desktop', 'gaming_desktop.png', 0),
(4, 'Desktop Computer', 'desktop_computer.png', 0),
(5, 'Processor', 'processor.png', 0),
(6, 'Motherboard', 'motherboard.png', 0),
(7, 'Memory [RAM]', 'memory_ram.png', 0),
(8, 'Graphic Card', 'graphic_card.png', 0),
(9, 'Cooling and Lighting', 'cooling_n_lighting.png', 0),
(10, 'Storage', 'storage.png', 0),
(11, 'Casing', 'casing.png', 0),
(12, 'Optical Drive', 'optical_drive.png', 0),
(13, 'Monitor', 'monitor.png', 0),
(14, 'Speaker and Headphone', 'speaker_n_headphone.png', 0),
(15, 'Keyboard', 'keyboard.png', 0),
(16, 'Mouse and Gamepad', 'mouse_n_gamepad.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_message`
--

DROP TABLE IF EXISTS `contact_message`;
CREATE TABLE IF NOT EXISTS `contact_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `is_unread` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_message`
--

INSERT INTO `contact_message` (`id`, `name`, `email`, `mobile_no`, `subject`, `message`, `date_time`, `is_unread`, `is_deleted`) VALUES
(1, 'mashan', 'tg2017233@gmai.com', '0771637551', 'Damage item', 'damage keyboard', '2020-03-07 02:11:46', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` varchar(6) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `first_name`, `last_name`, `email`, `is_deleted`) VALUES
('C00001', 'madushan', 'Sandaruwan', 'madushansandaru1@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_mail_info`
--

DROP TABLE IF EXISTS `customer_mail_info`;
CREATE TABLE IF NOT EXISTS `customer_mail_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `street_1` varchar(100) NOT NULL,
  `street_2` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_mail_info`
--

INSERT INTO `customer_mail_info` (`id`, `customer_id`, `name`, `street_1`, `street_2`, `city`, `zip_code`, `mobile_no`, `is_default`, `is_deleted`) VALUES
(1, 'C00001', 'Madushan Sandaruwan', 'Bambaragala', 'Koththallena', 'Hatton', 22040, '0771637551', 1, 0),
(2, 'C00001', 'Sandaru Karunasena', '11 mile post', 'Wanathawilluwa', 'Puttalam', 52364, '0778321006', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_message`
--

DROP TABLE IF EXISTS `customer_message`;
CREATE TABLE IF NOT EXISTS `customer_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(8) NOT NULL DEFAULT 'digimart',
  `to` varchar(8) NOT NULL DEFAULT 'digimart',
  `message` varchar(500) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `is_unread` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_info`
--

DROP TABLE IF EXISTS `customer_payment_info`;
CREATE TABLE IF NOT EXISTS `customer_payment_info` (
  `customer_id` varchar(6) NOT NULL,
  `card_no` varchar(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_payment_info`
--

INSERT INTO `customer_payment_info` (`customer_id`, `card_no`, `is_deleted`) VALUES
('C00001', '4512-6985-3256-7452', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customize_order`
--

DROP TABLE IF EXISTS `customize_order`;
CREATE TABLE IF NOT EXISTS `customize_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(6) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `is_posted` tinyint(1) NOT NULL DEFAULT 0,
  `is_received` tinyint(1) NOT NULL DEFAULT 0,
  `is_canceled` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customize_order`
--

INSERT INTO `customize_order` (`id`, `customer_id`, `unit_price`, `quantity`, `date_time`, `is_posted`, `is_received`, `is_canceled`, `is_deleted`) VALUES
(3, 'C00001', '582000.00', 10, '2020-04-09 16:03:47', 0, 0, 1, 1),
(2, 'C00001', '582000.00', 5, '2020-04-07 15:18:42', 0, 0, 0, 0),
(1, 'C00001', '532000.00', 5, '2020-04-08 00:00:00', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customize_order_product`
--

DROP TABLE IF EXISTS `customize_order_product`;
CREATE TABLE IF NOT EXISTS `customize_order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customize_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customize_order_product`
--

INSERT INTO `customize_order_product` (`id`, `customize_order_id`, `product_id`, `is_deleted`) VALUES
(35, 2, 17, 0),
(34, 2, 15, 0),
(33, 2, 15, 0),
(32, 2, 14, 0),
(31, 2, 12, 0),
(30, 2, 8, 0),
(29, 1, 19, 0),
(28, 1, 20, 0),
(27, 1, 18, 0),
(26, 1, 17, 0),
(25, 1, 15, 0),
(24, 1, 16, 0),
(23, 1, 14, 0),
(22, 1, 12, 0),
(21, 1, 10, 0),
(36, 2, 18, 0),
(37, 2, 19, 0),
(38, 2, 19, 0),
(39, 3, 8, 1),
(40, 3, 12, 1),
(41, 3, 14, 1),
(42, 3, 15, 1),
(43, 3, 15, 1),
(44, 3, 17, 1),
(45, 3, 18, 1),
(46, 3, 19, 1),
(47, 3, 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_officer`
--

DROP TABLE IF EXISTS `inventory_officer`;
CREATE TABLE IF NOT EXISTS `inventory_officer` (
  `id` varchar(6) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_officer`
--

INSERT INTO `inventory_officer` (`id`, `first_name`, `last_name`, `email`, `is_deleted`) VALUES
('IO0001', 'Sandun', 'Bandara', 'io@digimart', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(6) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `is_posted` tinyint(1) NOT NULL DEFAULT 0,
  `is_received` tinyint(1) NOT NULL DEFAULT 0,
  `is_canceled` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `customer_id`, `product_id`, `quantity`, `unit_price`, `date_time`, `is_posted`, `is_received`, `is_canceled`, `is_deleted`) VALUES
(10, 'C00001', 2, 6, '169000.00', '2020-02-25 01:57:43', 1, 1, 0, 0),
(9, 'C00001', 5, 11, '158000.00', '2020-03-27 01:55:56', 1, 1, 0, 0),
(8, 'C00001', 1, 5, '11500.00', '2020-03-24 21:07:46', 1, 1, 0, 0),
(7, 'C00001', 1, 10, '11500.00', '2020-03-24 19:35:55', 0, 1, 0, 0),
(6, 'C00001', 5, 5, '158000.00', '2020-03-24 19:35:55', 1, 1, 0, 0),
(11, 'C00001', 6, 7, '135600.00', '2020-03-25 02:03:43', 0, 0, 0, 0),
(12, 'C00001', 1, 2, '11500.00', '2020-03-25 02:03:43', 0, 0, 1, 0),
(13, 'C00001', 7, 10, '412589.00', '2020-03-24 19:35:50', 1, 1, 0, 0),
(14, 'C00001', 1, 10, '11500.00', '2020-03-24 19:35:55', 0, 0, 0, 0),
(15, 'C00001', 6, 7, '135600.00', '2020-03-25 02:03:43', 0, 0, 0, 0),
(16, 'C00001', 6, 7, '135600.00', '2020-03-25 02:03:43', 0, 0, 0, 0),
(17, 'C00001', 2, 4, '676000.00', '2020-04-05 15:36:51', 0, 0, 0, 0),
(18, 'C00001', 5, 7, '1106000.00', '2020-04-05 15:50:05', 0, 0, 0, 0),
(19, 'C00001', 6, 9, '135600.00', '2020-04-05 15:57:06', 0, 0, 1, 2),
(20, 'C00001', 6, 12, '135600.00', '2020-04-05 15:59:37', 0, 0, 1, 1),
(21, 'C00001', 10, 1, '10000.00', '2020-04-09 14:23:23', 0, 0, 0, 0),
(22, 'C00001', 12, 1, '49500.00', '2020-04-09 14:23:23', 0, 0, 0, 0),
(23, 'C00001', 14, 1, '155000.00', '2020-04-09 14:23:23', 0, 0, 0, 0),
(24, 'C00001', 16, 1, '19500.00', '2020-04-09 14:23:23', 0, 0, 0, 0),
(25, 'C00001', 16, 1, '19500.00', '2020-04-09 14:23:23', 0, 0, 0, 0),
(26, 'C00001', 17, 1, '189500.00', '2020-04-09 14:23:23', 0, 0, 0, 0),
(27, 'C00001', 18, 1, '3000.00', '2020-04-09 14:23:23', 0, 0, 0, 0),
(28, 'C00001', 20, 1, '26500.00', '2020-04-09 14:23:23', 0, 0, 0, 0),
(29, 'C00001', 19, 1, '59500.00', '2020-04-09 14:23:23', 0, 0, 0, 0),
(30, 'C00001', 10, 1, '10000.00', '2020-04-09 14:25:00', 0, 0, 0, 0),
(31, 'C00001', 12, 1, '49500.00', '2020-04-09 14:25:00', 0, 0, 0, 0),
(32, 'C00001', 14, 1, '155000.00', '2020-04-09 14:25:00', 0, 0, 0, 0),
(33, 'C00001', 16, 1, '19500.00', '2020-04-09 14:25:00', 0, 0, 0, 0),
(34, 'C00001', 15, 1, '19500.00', '2020-04-09 14:25:00', 0, 0, 0, 0),
(35, 'C00001', 17, 1, '189500.00', '2020-04-09 14:25:00', 0, 0, 0, 0),
(36, 'C00001', 18, 1, '3000.00', '2020-04-09 14:25:00', 0, 0, 0, 0),
(37, 'C00001', 20, 1, '26500.00', '2020-04-09 14:25:00', 0, 0, 0, 0),
(38, 'C00001', 19, 1, '59500.00', '2020-04-09 14:25:00', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `image`, `price`, `brand_id`, `category_id`, `is_deleted`) VALUES
(1, 'Asus cerberus mech RGB gaming keyboard', 'Fully mechanical key switches for lightning-fast response and outstanding durability\r\nRGB illumination with seven pre-set lighting effects\r\nOn-the-fly macro recording\r\n100% anti-ghosting with N-key rollover (NKRO) technology\r\nGaming profile keys for storing multiple key, lighting and macro settings\r\nWindows key lock protects against accidental presses while gaming', '1.jpg', '11500.00', 4, 15, 0),
(2, 'Asus zenbook 14 UX434FLA i5 10th gen with screen pad 2.0', 'Creativity. Style. Innovation. These are the qualities that define the elegant new ZenBook 14.<br>It\'s one of the world\'s smallest 14-inch laptops, and features the breathtaking frameless NanoEdge display and the revolutionary ScreenPad™ 2.0 to give you the freedom to discover your creative power.', '2.png', '169000.00', 4, 1, 0),
(3, 'MSI GE65 9SE raider 240hz rtx 2060 9th gen', 'REVOLUTIONARY COOLING FOR ENTHUSIASTIC GAMING\r\nMATRIX DISPLAY\r\nMULTI-TASK WITH UP TO 3 MONITORS\r\nPER-KEY RGB GAMING KEYBOARD BY STEELSERIES\r\nTAILOR YOUR KEYBOARD\r\nSmaller Body. BIGGER SCREEN\r\n240HZ ULTRA-HIGH REFRESH RATE WORLD’S FASTEST GAMING DISPLAY\r\nGIANT SPEAKERS. BIGGER. LOUDER. CLEARER', '3.jpg', '360000.00', 11, 1, 0),
(4, 'Acer predator helios 300 i7 - rtx 2060', 'Ready for battle and eager for a fight, the Helios 300 drops you into the game with everything you need. Only now we’ve armed it with NVIDIA® GeForce RTX™ graphics, 9th Gen Intel® Core™ i7 Processors and our custom-engineered 4th Gen AeroBlade™ 3D Technology.', '4.gif', '299500.00', 1, 1, 0),
(5, 'Acer nitro 5 2019 gaming i5 GTX 1650', 'ACER NITRO 5 2019 GAMING i5 GTX 1650\r\nIntel Core i5-9300H PROCESSOR\r\n8GB DDR4 2666MHZ\r\n1TB (SATA)\r\n15.6\" FHD (1920x1080), 144hz IPS Panel\r\nNVIDIA® GeForce GTX 1650, 4GB GDDR5\r\nRED Backlit keyboard\r\n2.1 kg, 57WHrs\r\nFREE Predator Gaming Backpack\r\n2 Years warranty\r\nGeniune Windows 10 64Bit Pre-installed', '5.jpg', '158000.00', 1, 1, 0),
(6, 'NANO X VIDEO LITE', 'Intel® Core™ i5-9400F (9M Cache, up to 4.10 GHz)\r\nMSI B365M PRO VDH\r\n16GB Gaming Memory 2666Mhz\r\n2TB Hard Disk 5400Rpm\r\n240GB SSSD ( Sequential Read of up to 500 MB/s)\r\nNvidia GTX 1650 4GB DDR5\r\nCooler Master Q500L Case\r\nInbuilt Wifi', '6.png', '135600.00', 11, 2, 0),
(7, 'NANO X VIDEO PRO', 'AMD Ryzen™ 7 2700X (up to 4.3Ghz 8-cores 16-threads) 20M Cache X470 Motherboard RTX 2060 6GB DDR6 Graphics Card 32GB 3200Mhz Gaming Ram 4TB WD Black 7200RPM Samsung 970 EVO PLUS 500GB 650W Gold Certified FULLY MODULAR PSU Cooler Master MB500 Case 240 Liquid Cooler', '7.png', '400000.00', 11, 2, 0),
(8, 'COOLER MASTER MASTERCASE H500P RGB', 'Materials Outlook: Plastic,<br>\r\nBody: Steel<br>\r\nSide panel: Tempered Glass, Steel<br>\r\nDimensions (LxWxH) 544 x 242 x 542mm / 21.4 x 9.5 x 21.3 inch<br>\r\nMotherboard Support Mini-ITX, Micro-ATX<br>\r\nATX, E-ATX (support upto 12\" x 10.7\")<br>\r\nExpansion Slots 7 + 2 (Support vertical graphics card installation)<br>\r\nDrive Bays 5.25\" 0<br>\r\n2.5\" / 3.5\" 2<br>\r\n2.5\" SSD 2 (Drive Bay support up to 5)<br>\r\nI/O Port USB 3.0 x 2<br>\r\nUSB 2.0 x 2<br>', 'casing1.png', '27000.00', 4, 11, 0),
(9, 'ASUS PRIME A320M-E', 'AMD AM4 Socket for 2nd/1st AMD Ryzenâ„¢/2nd and 1st Gen AMD Ryzenâ„¢ with Radeonâ„¢ Vega Graphics/Athlonâ„¢ with Radeonâ„¢ Vega Graphics/7th Generation A-series/Athlon X4 Processors', 'motherboard1.png', '13900.00', 4, 6, 0),
(10, 'CORSAIR 110R TEMPERED GLASS', 'Case Dimensions 418mm x 210mm x 480mm<br>\r\nMaximum GPU Length 330mm<br>\r\nMaximum PSU Length 180mm<br>\r\nMaximum CPU Cooler Height 160mm<br>\r\nCase Expansion Slots 7<br>\r\nCase Drive Bays â€(x2) 3.5in (x2) 2.5in\"<br>', 'casing2.png', '10000.00', 4, 11, 0),
(11, 'ANTEC GX202', 'Dimensions 450 x 205 x 435 mm (DWH)<br>\r\nForm Factor Mid Tower<br>\r\nMaterials SPCC & Plastic<br>\r\nMainboard Support ATX / Micro-ATX / ITX<br>', 'casing3.png', '7000.00', 4, 11, 0),
(12, 'ASUS ROG STRIX Z390-E GAMING', 'IntelÂ® Socket 1151 9th / 8th Gen IntelÂ® Coreâ„¢, PentiumÂ® Gold and CeleronÂ® Processors<br>\r\nSupports IntelÂ® 14 nm CPU<br>\r\nSupports IntelÂ® Turbo Boost Technology 2.0<br>\r\nThe IntelÂ® Turbo Boost Technology 2.0 support depends on the CPU types.', 'mb2.png', '49500.00', 4, 6, 0),
(13, 'INTEL CORE I9-9900K', 'CPU Socket Type LGA 1151 (300 Series)<br>\r\nCore Name Coffee Lake<br>\r\n# of Cores 8-Core<br>\r\n# of Threads 16<br>\r\nOperating Frequency 3.6 GHz<br>\r\nMax Turbo Frequency 5.0 GHz<br>', 'pro1.png', '106000.00', 9, 5, 0),
(14, 'AMD RYZEN 3950X (UP TO 4.7GHZ 16-CORES 32-THREADS) 72M CACHE', '# of CPU Cores 16<br>\r\n# of Threads 32<br>\r\nBase Clock 3.5GHz<br>\r\nMax Boost Clock Up to 4.7GHz<br>\r\nTotal L1 Cache 1MB<br>', 'pro2.png', '155000.00', 2, 5, 0),
(15, 'KINGSTON HYPERX FURY 16GB DDR4 3200MHZ', 'Part Number: HX432C16FB3/16<br>\r\nSpecs: DDR4, 3200MHz, CL16, 1.35V, Unbuffered<br>\r\nTimings: 3200MHz, 16-18-18, 1.35V; 3000MHz, 15-17-17, 1.35V', 'ram1.png', '19500.00', 5, 7, 0),
(16, 'CORSAIR VENGEANCE LPX 16GB (2 x 8GB) DDR4 DRAM 3600MHz Kit with Airflow Fan', 'Part Number: HX432C16FB3/16<br>\r\nSpecs: DDR4, 3200MHz, CL16, 1.35V, Unbuffered<br>\r\nTimings: 3200MHz, 16-18-18, 1.35V; 3000MHz, 15-17-17, 1.35V', 'ram2.png', '19500.00', 5, 7, 0),
(17, 'ASUS STRIX RTX 2080 SUPER 8GB DDR6', 'NVIDIAÂ® GeForceÂ® RTX 2080 SUPER<br>\r\nBus Standard PCI Express 3.0<br>\r\nOpenGL OpenGLÂ®4.6<br>\r\nVideo Memory GDDR6 8GB', 'gc1.png', '189500.00', 4, 8, 0),
(18, 'ASUS DVDRW 24X', '1 year warranty', 'od1.png', '3000.00', 4, 12, 0),
(19, 'SAMSUNG 970 EVO PLUS M.2 NVME 1TB', 'Form Factor M.2 2280<br>\r\nCapacity 1TB<br>\r\nMemory Components V-NAND 3-bit MLC', 'st1.png', '59500.00', 13, 10, 0),
(20, 'SAMSUNG 970 EVO PLUS M.2 NVME 500GB', 'Form Factor M.2 2280<br>\r\nCapacity 500GB<br>\r\nMemory Components V-NAND 3-bit MLC', 'st2.png', '26500.00', 13, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

DROP TABLE IF EXISTS `product_review`;
CREATE TABLE IF NOT EXISTS `product_review` (
  `product_id` int(11) NOT NULL,
  `customer_id` varchar(6) NOT NULL,
  `review_value` tinyint(1) NOT NULL,
  `review_text` varchar(255) NOT NULL,
  PRIMARY KEY (`customer_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`product_id`, `customer_id`, `review_value`, `review_text`) VALUES
(2, 'C00002', 3, '5555'),
(2, 'C00001', 3, '5555');

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

DROP TABLE IF EXISTS `quotation`;
CREATE TABLE IF NOT EXISTS `quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(6) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

DROP TABLE IF EXISTS `shopping_cart`;
CREATE TABLE IF NOT EXISTS `shopping_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(6) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `role`, `is_deleted`) VALUES
('admin@digimart', '202cb962ac59075b964b07152d234b70', 'admin', 0),
('madushansandaru1@gmail.com', '202cb962ac59075b964b07152d234b70', 'customer', 0),
('io@digimart', '202cb962ac59075b964b07152d234b70', 'inventory_officer', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
