-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 27, 2020 at 05:08 AM
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
('ADM001', 'DigiMart', 'Admin', 'admin@digimart', 0),
('ADM002', 'aaaa', 'kkkkk', 'kkkkk@g', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_message`
--

INSERT INTO `contact_message` (`id`, `name`, `email`, `mobile_no`, `subject`, `message`, `date_time`, `is_unread`, `is_deleted`) VALUES
(1, 'mashan', 'tg2017233@gmai.com', '0771637551', 'Damage item', 'damage keyboard', '2020-03-07 02:11:46', 1, 0),
(2, 'mashan sandaru', 'madushansandaru1@gmail.com', '0771637551', 'jjjddvdfv dvs', 'dsaxdwdcw vdvf\r\nfedfc dds', '2020-03-18 19:14:37', 0, 0),
(3, 'mashan', 'tg2017233@gmai.com', '0771637551', 'Damage item', 'damage keyboard', '2020-03-05 02:11:46', 1, 0),
(4, 'mashan sandaru', 'madushansandaru1@gmail.com', '0771637551', 'jjjddvdfv dvs', 'dsaxdwdcw vdvf\r\nfedfc dds', '2020-03-13 19:14:37', 0, 0);

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
('C00001', 'madushan', 'Sandaruwan', 'madushansandaru1@gmail.com', 0),
('C00004', 'madushan', 'Sandaruwan', '41222@gmail.com', 0),
('C00003', 'madushan', 'Sandaruwan', 'ddddddddddddd@gmail.com', 0),
('C00002', 'madushan', 'Sandaruwan', 'fvfv@gmail.com', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_mail_info`
--

INSERT INTO `customer_mail_info` (`id`, `customer_id`, `name`, `street_1`, `street_2`, `city`, `zip_code`, `mobile_no`, `is_default`, `is_deleted`) VALUES
(1, 'C00001', 'Madushan Sandaruwan', 'Bambaragala', 'Koththallena', 'Hatton', 22040, '0771637551', 1, 0),
(2, 'C00001', 'Sandaru Karunasena', '11 mile post', 'Wanathawilluwa', 'Puttalam', 52364, '0778321006', 0, 0),
(3, 'C00001', 'dszjnk', 'jikj', 'jkij', 'ol', 45, 'klj', 0, 0),
(4, 'C00001', 'dv nj', 'jbhnj', 'njlhn', 'njklh', 5, 'mkjj', 0, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_message`
--

INSERT INTO `customer_message` (`id`, `from`, `to`, `message`, `date_time`, `is_unread`, `is_deleted`) VALUES
(1, 'C00001', 'digimart', 'damage keyboard', '2020-03-07 02:11:46', 0, 0),
(2, 'C00001', 'digimart', 'dsaxdwdcw vdvf\r\nfedfc dds', '2020-03-18 19:14:37', 0, 0),
(3, 'digimart', 'C00001', 'Payment for invoice 2028, dated 3/3/19 has not been received. Please submit payment by 3/12/19 to avoid any late fees. – Your Citizens Bank Team\r\n\r\nProfessional Interview Text\r\nAndrew. Your interview at Citizens Bank is at 11am tomorrow on 101 Poe Street. Please bring a copy of your i.d for security. -Citizens HR Team', '2020-03-25 10:55:43', 0, 0),
(4, 'C00001', 'digimart', 'damage keyboard', '2020-03-07 02:11:46', 0, 0),
(5, 'digimart', 'C00001', 'dsaxdwdcw vdvf\r\nfedfc dds', '2020-03-18 19:14:37', 0, 0),
(6, 'C00001', 'digimart', 'Payment for invoice 2028, dated 3/3/19 has not been received. Please submit payment by 3/12/19 to avoid any late fees. – Your Citizens Bank Team\r\n\r\nProfessional Interview Text\r\nAndrew. Your interview at Citizens Bank is at 11am tomorrow on 101 Poe Street. Please bring a copy of your i.d for security. -Citizens HR Team', '2020-03-25 10:55:43', 0, 0),
(7, 'C00001', 'digimart', 'damage keyboard', '1998-01-17 02:11:46', 0, 0),
(8, 'C00001', 'digimart', 'madushan sandaruwan', '2020-03-25 12:48:27', 0, 0),
(9, 'C00001', 'digimart', 'hiiiiii', '2020-03-25 12:48:56', 0, 0),
(10, 'C00001', 'digimart', 'how are you', '2020-03-25 12:49:17', 0, 0),
(11, 'C00001', 'digimart', 'hellow', '2020-03-25 13:15:25', 0, 0),
(12, 'C00001', 'digimart', 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh', '2020-03-25 13:21:29', 0, 0),
(14, 'C00002', 'digimart', '', '2020-03-25 00:00:00', 0, 0),
(15, 'C00002', 'digimart', 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh', '2020-03-25 13:21:29', 0, 0),
(16, 'C00002', 'digimart', 'hellow', '2020-03-25 13:15:25', 0, 0),
(17, 'C00003', 'digimart', 'how are you', '2020-03-25 12:49:17', 0, 0),
(18, 'C00003', 'digimart', 'hiiiiii', '2020-03-25 12:48:56', 0, 0),
(19, 'C00003', 'digimart', 'madushan sandaruwan', '2020-03-25 12:48:27', 0, 0),
(20, 'digimart', 'C00003', 'Payment for invoice 2028, dated 3/3/19 has not been received. Please submit payment by 3/12/19 to avoid any late fees. – Your Citizens Bank Team\r\n\r\nProfessional Interview Text\r\nAndrew. Your interview at Citizens Bank is at 11am tomorrow on 101 Poe Street. Please bring a copy of your i.d for security. -Citizens HR Team', '2020-03-25 10:55:43', 0, 0),
(21, 'C00004', 'digimart', 'Payment for invoice 2028, dated 3/3/19 has not been received. Please submit payment by 3/12/19 to avoid any late fees. – Your Citizens Bank Team\r\n\r\nProfessional Interview Text\r\nAndrew. Your interview at Citizens Bank is at 11am tomorrow on 101 Poe Street. Please bring a copy of your i.d for security. -Citizens HR Team', '2020-03-25 10:55:43', 0, 0),
(22, 'digimart', 'C00004', 'dsaxdwdcw vdvf\r\nfedfc dds', '2020-03-18 19:14:37', 0, 0),
(34, 'C00002', 'digimart', 'eeeeeeeeeeeeeeee', '2020-03-26 20:07:16', 0, 0),
(26, 'digimart', 'C00005', 'damage keyboard', '1998-01-17 02:11:46', 0, 0);

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
('C00001', '4512-6985-3256-7458', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `customer_id`, `product_id`, `quantity`, `unit_price`, `date_time`, `is_posted`, `is_received`, `is_canceled`, `is_deleted`) VALUES
(10, 'C00001', 2, 6, '169000.00', '2020-02-25 01:57:43', 1, 0, 0, 0),
(9, 'C00001', 5, 11, '158000.00', '2020-03-27 01:55:56', 0, 0, 0, 0),
(8, 'C00001', 1, 5, '11500.00', '2020-03-24 21:07:46', 1, 0, 0, 0),
(7, 'C00001', 1, 10, '11500.00', '2020-03-24 19:35:55', 0, 0, 0, 0),
(6, 'C00001', 5, 5, '158000.00', '2020-03-24 19:35:55', 1, 1, 0, 0),
(11, 'C00001', 6, 7, '135600.00', '2020-03-25 02:03:43', 0, 0, 0, 0),
(12, 'C00001', 1, 2, '11500.00', '2020-03-25 02:03:43', 0, 0, 1, 0),
(13, 'C00001', 7, 10, '412589.00', '2020-03-24 19:35:50', 1, 1, 0, 0),
(14, 'C00001', 1, 10, '11500.00', '2020-03-24 19:35:55', 0, 0, 0, 0),
(15, 'C00001', 6, 7, '135600.00', '2020-03-25 02:03:43', 0, 0, 0, 0),
(16, 'C00001', 6, 7, '135600.00', '2020-03-25 02:03:43', 0, 0, 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `image`, `price`, `brand_id`, `category_id`, `is_deleted`) VALUES
(1, 'Asus cerberus mech RGB gaming keyboard', 'Fully mechanical key switches for lightning-fast response and outstanding durability\r\nRGB illumination with seven pre-set lighting effects\r\nOn-the-fly macro recording\r\n100% anti-ghosting with N-key rollover (NKRO) technology\r\nGaming profile keys for storing multiple key, lighting and macro settings\r\nWindows key lock protects against accidental presses while gaming', '1.jpg', '11500.00', 4, 15, 0),
(2, 'Asus zenbook 14 UX434FLA i5 10th gen with screen pad 2.0', 'Creativity. Style. Innovation. These are the qualities that define the elegant new ZenBook 14. It’s one of the world’s smallest 14-inch laptops, and features the breathtaking frameless NanoEdge display and the revolutionary ScreenPad™ 2.0 to give you the freedom to discover your creative power.', '2.png', '169000.00', 4, 1, 0),
(3, 'MSI GE65 9SE raider 240hz rtx 2060 9th gen', 'REVOLUTIONARY COOLING FOR ENTHUSIASTIC GAMING\r\nMATRIX DISPLAY\r\nMULTI-TASK WITH UP TO 3 MONITORS\r\nPER-KEY RGB GAMING KEYBOARD BY STEELSERIES\r\nTAILOR YOUR KEYBOARD\r\nSmaller Body. BIGGER SCREEN\r\n240HZ ULTRA-HIGH REFRESH RATE WORLD’S FASTEST GAMING DISPLAY\r\nGIANT SPEAKERS. BIGGER. LOUDER. CLEARER', '3.jpg', '360000.00', 11, 1, 0),
(4, 'Acer predator helios 300 i7 - rtx 2060', 'Ready for battle and eager for a fight, the Helios 300 drops you into the game with everything you need. Only now we’ve armed it with NVIDIA® GeForce RTX™ graphics, 9th Gen Intel® Core™ i7 Processors and our custom-engineered 4th Gen AeroBlade™ 3D Technology.', '4.gif', '299500.00', 1, 1, 0),
(5, 'Acer nitro 5 2019 gaming i5 GTX 1650', 'ACER NITRO 5 2019 GAMING i5 GTX 1650\r\nIntel Core i5-9300H PROCESSOR\r\n8GB DDR4 2666MHZ\r\n1TB (SATA)\r\n15.6\" FHD (1920x1080), 144hz IPS Panel\r\nNVIDIA® GeForce GTX 1650, 4GB GDDR5\r\nRED Backlit keyboard\r\n2.1 kg, 57WHrs\r\nFREE Predator Gaming Backpack\r\n2 Years warranty\r\nGeniune Windows 10 64Bit Pre-installed', '5.jpg', '158000.00', 1, 1, 0),
(6, 'NANO X VIDEO LITE', 'Intel® Core™ i5-9400F (9M Cache, up to 4.10 GHz)\r\nMSI B365M PRO VDH\r\n16GB Gaming Memory 2666Mhz\r\n2TB Hard Disk 5400Rpm\r\n240GB SSSD ( Sequential Read of up to 500 MB/s)\r\nNvidia GTX 1650 4GB DDR5\r\nCooler Master Q500L Case\r\nInbuilt Wifi', '6.png', '135600.00', 11, 2, 0),
(7, 'NANO X VIDEO PRO', 'AMD Ryzen™ 7 2700X (up to 4.3Ghz 8-cores 16-threads) 20M Cache X470 Motherboard RTX 2060 6GB DDR6 Graphics Card 32GB 3200Mhz Gaming Ram 4TB WD Black 7200RPM Samsung 970 EVO PLUS 500GB 650W Gold Certified FULLY MODULAR PSU Cooler Master MB500 Case 240 Liquid Cooler', '7.png', '400000.00', 11, 2, 0);

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
(1, 'C00001', 2, 'u can leave feedback for sellers within 30 days in \"Orders Awaiting My Feedbac'),
(1, 'C00002', 5, ''),
(1, 'C00003', 2, ''),
(1, 'C00004', 2, ''),
(1, 'C00005', 3, ''),
(1, 'C00006', 5, ''),
(1, 'C00007', 5, '');

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

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `customer_id`, `product_id`, `date_time`) VALUES
(1, 'C00001', 1, '2020-03-24 16:03:20');

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

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`id`, `customer_id`, `product_id`, `date_time`) VALUES
(10, 'C00001', 3, '2020-03-25 02:07:04'),
(9, 'C00001', 5, '2020-03-25 02:07:04');

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
('io@digimart', '202cb962ac59075b964b07152d234b70', 'inventory_officer', 0),
('kkkkk@g', '202cb962ac59075b964b07152d234b70', 'admin', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
