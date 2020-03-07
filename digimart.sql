-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 06, 2020 at 09:31 PM
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
('ADM001', 'DigiMart', 'Admin', 'admin.digimart@gmail.com', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_message`
--

INSERT INTO `contact_message` (`id`, `name`, `email`, `mobile_no`, `subject`, `message`, `date_time`, `is_unread`, `is_deleted`) VALUES
(1, 'mashan', 'tg2017233@gmai.com', '0771637551', 'Damage item', 'damage keyboard', '2020-03-07 02:11:46', 1, 0);

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
('C00001', 'Madushan', 'Sandaruwan', 'madushansandaru1@gmail.com', 0);

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
('C00001', '2587-6358-9574-2514', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_shipping_address`
--

DROP TABLE IF EXISTS `customer_shipping_address`;
CREATE TABLE IF NOT EXISTS `customer_shipping_address` (
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_shipping_address`
--

INSERT INTO `customer_shipping_address` (`id`, `customer_id`, `name`, `street_1`, `street_2`, `city`, `zip_code`, `mobile_no`, `is_default`, `is_deleted`) VALUES
(1, 'C00001', 'Madushan Sandaruwan', 'Bambaragala', 'Koththallena', 'Hatton', 22040, '0771637551', 1, 0);

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
('IO0001', 'Sandun', 'Bandara', 'sandaru1wgm@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(6) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `is_not_received` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
(1, 'C00001', 4, 'Good product');

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

DROP TABLE IF EXISTS `quotation`;
CREATE TABLE IF NOT EXISTS `quotation` (
  `customer_id` varchar(6) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`customer_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`customer_id`, `product_id`, `date_time`) VALUES
('C00001', 3, '2020-03-07 02:30:17');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

DROP TABLE IF EXISTS `shopping_cart`;
CREATE TABLE IF NOT EXISTS `shopping_cart` (
  `customer_id` varchar(6) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`customer_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`customer_id`, `product_id`, `date_time`) VALUES
('C00001', 1, '2020-03-07 02:28:07');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(6) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `password`, `role`, `is_deleted`) VALUES
('ADM001', '123', 'admin', 0),
('C00001', '123', 'customer', 0),
('IO0001', '123', 'inventory_officer', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
