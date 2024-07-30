-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 30, 2024 at 02:34 AM
-- Server version: 10.11.8-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brewbase`
--
CREATE DATABASE IF NOT EXISTS `brewbase` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `brewbase`;

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

DROP TABLE IF EXISTS `addons`;
CREATE TABLE `addons` (
  `addonsID` int(11) NOT NULL,
  `addons_name` varchar(20) NOT NULL,
  `addons_price` decimal(10,2) NOT NULL,
  `addons_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`addonsID`, `addons_name`, `addons_price`, `addons_img`) VALUES
(0, 'None', '0.00', NULL),
(1, 'Black Pearl', '10.00', 'pearls.png'),
(2, 'Nata De Coco', '15.00', 'nata.png'),
(3, 'Coffee Jelly', '10.00', 'coffee.png'),
(4, 'Pandan Jelly', '12.00', 'pandan.png'),
(5, 'Pineapple Jelly', '8.00', 'pineapple.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

DROP TABLE IF EXISTS `cart_item`;
CREATE TABLE `cart_item` (
  `cart_id` int(11) NOT NULL,
  `prod_no` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `addonsID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`cart_id`, `prod_no`, `id`, `quantity`, `created_at`, `addonsID`) VALUES
(58, 9, 7, 2, '2022-05-28 10:42:28', 3),
(74, 16, 1, 1, '2022-06-24 11:38:09', 0),
(86, 4, 17, 1, '2023-04-12 22:20:57', 0),
(87, 2, 19, 1, '2023-04-13 09:18:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `deliveryaddress`
--

DROP TABLE IF EXISTS `deliveryaddress`;
CREATE TABLE `deliveryaddress` (
  `deladd_id` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `street` varchar(50) NOT NULL,
  `barangay` varchar(30) NOT NULL,
  `city` varchar(40) NOT NULL,
  `province` varchar(50) NOT NULL,
  `region` varchar(100) NOT NULL,
  `country` varchar(40) NOT NULL DEFAULT '''Philippines''',
  `postalcode` varchar(30) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `additionalinfo` text NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `deliveryaddress`
--

INSERT INTO `deliveryaddress` (`deladd_id`, `userid`, `fullname`, `street`, `barangay`, `city`, `province`, `region`, `country`, `postalcode`, `phone_number`, `additionalinfo`, `status`) VALUES
(17, '2023433798592', 'Lloyd Clarence Maquiling', 'Vicente Ostia Ave.', 'Tinago', 'Ozamis City', 'Misamis Occidental', 'Region X', 'Philippines', '7201', '09982853572', 'P-Madanihon', 'Set'),
(18, '2023433798592', 'Brian Hambre', 'Banadero', 'Tinago', 'Ozamis City', 'Misamis Occidental', 'Region X', 'Philippines', '7200', '09288458344', 'Purok 6', 'Not Set'),
(32, '2023433798592', 'John Mikey Butnande', 'N/A', 'Labo', 'Ozamis City', 'Misamis Occidental', 'Region X', 'Philippines', '7200', '09453470946', 'Purok 3', 'Not Set'),
(33, '2023433798592', 'Ruxe Pasok', 'Vicente Ostia Ave.', 'Tinago', 'Ozamis City', 'Misamis Occidental', 'Region X', 'Philippines', '7200', '09982853572', 'P-Madanihon', 'Not Set');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE `orderdetail` (
  `order_id` int(11) NOT NULL,
  `prod_no` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_each` decimal(10,2) NOT NULL,
  `addonsID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`order_id`, `prod_no`, `quantity`, `price_each`, `addonsID`) VALUES
(202211992, 4, 1, '70.00', 0),
(202213617, 49, 1, '78.00', 1),
(202214556, 55, 1, '95.00', 0),
(202215043, 10, 1, '110.00', 0),
(202219794, 12, 1, '90.00', 0),
(202226678, 55, 1, '95.00', 0),
(202228876, 13, 1, '100.00', 0),
(202237790, 6, 1, '100.00', 0),
(202240384, 16, 1, '55.00', 1),
(202242464, 7, 1, '95.00', 0),
(202247071, 12, 2, '90.00', 2),
(202248328, 14, 1, '60.00', 4),
(202249943, 7, 2, '95.00', 0),
(202249943, 11, 1, '90.00', 0),
(202249943, 15, 2, '50.00', 0),
(202249943, 49, 3, '78.00', 3),
(202261665, 7, 2, '95.00', 1),
(202261665, 24, 1, '80.00', 0),
(202264013, 7, 1, '95.00', 0),
(202264013, 61, 1, '89.00', 0),
(202264267, 16, 2, '55.00', 1),
(202264267, 17, 2, '80.00', 0),
(202264961, 4, 1, '70.00', 0),
(202267816, 15, 1, '50.00', 0),
(202269032, 49, 1, '78.00', 0),
(202269331, 15, 1, '50.00', 0),
(202272711, 3, 1, '60.00', 0),
(202272971, 11, 1, '90.00', 0),
(202275859, 41, 3, '55.00', 2),
(202275859, 47, 2, '55.00', 3),
(202278902, 4, 3, '70.00', 1),
(202281585, 6, 8, '100.00', 0),
(202283829, 11, 3, '90.00', 0),
(202284707, 7, 1, '95.00', 0),
(202285394, 23, 1, '85.00', 0),
(202292358, 7, 1, '95.00', 3),
(202293872, 49, 1, '78.00', 0),
(202294734, 33, 3, '120.00', 1),
(202295830, 47, 1, '55.00', 1),
(202296728, 12, 1, '90.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(15) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `prepared_by` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `status`, `customer_id`, `prepared_by`) VALUES
(202211992, '2023-04-12 07:32:27', 'Pending', 17, 15),
(202213617, '2022-05-05 12:31:49', 'Completed', 12, 14),
(202214556, '2022-05-05 11:37:35', 'Cancelled', 13, 0),
(202215043, '2022-05-01 16:59:57', 'Cancelled', 1, 1),
(202219794, '2022-06-10 13:25:52', 'Completed', 15, 13),
(202226678, '2022-05-05 11:38:40', 'Order Confirmed', 13, 13),
(202228876, '2022-05-02 11:10:20', 'Cancelled', 2, 1),
(202237790, '2022-05-14 10:44:18', 'On The Way', 12, 14),
(202240384, '2022-06-24 11:41:34', 'Cancelled', 1, 0),
(202242464, '2022-06-24 08:53:21', 'Cancelled', 14, 0),
(202247071, '2022-06-06 14:31:23', 'Cancelled', 1, 0),
(202248328, '2022-05-27 15:12:45', 'Pending', 7, 0),
(202249943, '2023-04-09 14:47:06', 'Pending', 14, 0),
(202261665, '2022-06-24 11:43:47', 'Completed', 1, 13),
(202264013, '2022-06-24 08:47:35', 'Pending', 1, 0),
(202264267, '2022-06-06 14:34:59', 'Pending', 1, 0),
(202264961, '2022-05-02 10:41:23', 'Pending', 4, 13),
(202267816, '2022-05-02 11:16:01', 'Completed', 1, 1),
(202269032, '2022-05-05 12:42:10', 'Pending', 12, 0),
(202269331, '2022-06-15 19:23:05', 'Completed', 16, 14),
(202272711, '2022-05-05 11:32:31', 'Completed', 12, 1),
(202272971, '2022-06-21 12:10:40', 'Pending', 1, 0),
(202275859, '2022-05-05 10:35:52', 'Cancelled', 12, 0),
(202278902, '2022-05-02 10:46:31', 'Pending', 9, 13),
(202281585, '2022-05-14 10:51:15', 'Order Confirmed', 12, 13),
(202283829, '2023-02-15 10:51:06', 'Cancelled', 14, 0),
(202284707, '2022-06-24 08:11:50', 'Cancelled', 14, 0),
(202285394, '2022-05-05 11:06:49', 'Pending', 1, 1),
(202292358, '2023-04-09 13:48:38', 'Pending', 14, 0),
(202293872, '2022-05-29 21:59:58', 'Completed', 7, 14),
(202294734, '2022-05-05 11:34:41', 'Pending', 12, 13),
(202295830, '2023-04-13 09:21:50', 'Pending', 20, 0),
(202296728, '2023-06-11 09:39:38', 'Pending', 16, 0);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `pay_id` bigint(15) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` enum('Cash on Delivery','Credit Card') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pay_id`, `payment_date`, `payment_method`, `amount`, `order_id`, `customer_id`) VALUES
(2022128729728, '2022-05-05 11:37:35', 'Cash on Delivery', '95.00', 202214556, 13),
(2022130499727, '2022-05-05 11:34:41', 'Cash on Delivery', '370.00', 202294734, 12),
(2022147488385, '2022-05-29 21:59:58', 'Cash on Delivery', '78.00', 202293872, 7),
(2022151119849, '2022-06-06 14:31:23', 'Cash on Delivery', '195.00', 202247071, 1),
(2022161918721, '2022-05-05 11:38:40', 'Cash on Delivery', '95.00', 202226678, 13),
(2022252375991, '2022-05-05 12:42:10', 'Cash on Delivery', '78.00', 202269032, 12),
(2022269114563, '2022-05-05 12:31:49', 'Cash on Delivery', '88.00', 202213617, 12),
(2022294829970, '2022-05-02 11:16:01', 'Cash on Delivery', '50.00', 202267816, 1),
(2022354290941, '2022-05-05 11:06:49', 'Cash on Delivery', '85.00', 202285394, 1),
(2022378990812, '2022-06-24 08:53:21', 'Cash on Delivery', '95.00', 202242464, 14),
(2022401984280, '2023-04-12 07:32:27', 'Cash on Delivery', '70.00', 202211992, 17),
(2022483681846, '2022-05-01 16:59:57', 'Credit Card', '110.00', 202215043, 1),
(2022487986834, '2022-05-14 10:44:18', 'Cash on Delivery', '100.00', 202237790, 12),
(2022501667542, '2022-06-24 08:11:50', 'Cash on Delivery', '95.00', 202284707, 14),
(2022514812237, '2022-05-05 11:32:31', 'Credit Card', '60.00', 202272711, 12),
(2022535600268, '2022-06-24 11:43:47', 'Cash on Delivery', '280.00', 202261665, 1),
(2022615444517, '2022-05-02 11:10:20', 'Cash on Delivery', '100.00', 202228876, 2),
(2022644417671, '2022-06-10 13:25:52', 'Cash on Delivery', '90.00', 202219794, 15),
(2022668411593, '2023-04-09 14:47:06', 'Cash on Delivery', '624.00', 202249943, 14),
(2022691763125, '2022-05-02 10:46:31', 'Cash on Delivery', '220.00', 202278902, 9),
(2022701231664, '2022-05-05 10:35:52', 'Cash on Delivery', '300.00', 202275859, 12),
(2022709506878, '2022-06-15 19:23:05', 'Cash on Delivery', '50.00', 202269331, 16),
(2022710054365, '2022-05-02 10:41:23', 'Cash on Delivery', '70.00', 202264961, 4),
(2022748032580, '2022-05-14 10:51:15', 'Cash on Delivery', '800.00', 202281585, 12),
(2022759785899, '2022-06-24 11:41:34', 'Cash on Delivery', '65.00', 202240384, 1),
(2022838259431, '2023-06-11 09:39:38', 'Cash on Delivery', '90.00', 202296728, 16),
(2022871395679, '2023-04-09 13:48:38', 'Cash on Delivery', '105.00', 202292358, 14),
(2022872128709, '2022-06-06 14:34:59', 'Cash on Delivery', '280.00', 202264267, 1),
(2022875202395, '2023-04-13 09:21:50', 'Cash on Delivery', '65.00', 202295830, 20),
(2022881210675, '2023-02-15 10:51:06', 'Cash on Delivery', '270.00', 202283829, 14),
(2022882276238, '2022-05-27 15:12:45', 'Cash on Delivery', '72.00', 202248328, 7),
(2022968725284, '2022-06-24 08:47:35', 'Cash on Delivery', '184.00', 202264013, 1),
(2022996713198, '2022-06-21 12:10:40', 'Cash on Delivery', '90.00', 202272971, 1);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `fname` varchar(40) NOT NULL,
  `lname` varchar(40) NOT NULL,
  `mid_init` varchar(3) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `gender` varchar(15) NOT NULL,
  `birthdate` date NOT NULL,
  `street` varchar(50) DEFAULT NULL,
  `barangay` varchar(30) DEFAULT NULL,
  `city` varchar(40) NOT NULL,
  `province` varchar(50) NOT NULL,
  `country` varchar(40) NOT NULL,
  `postalcode` varchar(30) NOT NULL,
  `profile_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `fname`, `lname`, `mid_init`, `contact_no`, `gender`, `birthdate`, `street`, `barangay`, `city`, `province`, `country`, `postalcode`, `profile_img`) VALUES
(0, 'N/A', 'N/A', NULL, NULL, 'N/A', '2022-05-01', NULL, NULL, 'N/A', 'N/A', 'N/A', 'N/A', NULL),
(1, 'Ruxe', 'Pasok', 'E.', '09982853572', 'Male', '2001-07-04', 'Ostia Avenue Street', 'Tinago', 'Ozamiz City', 'Misamis Occidental', 'Phillipines', '7200', 'IMG-629587546b5699.27626709.jpg'),
(2, 'Marck', 'Balucan', 'M.', '0912345678', 'Male', '2002-05-26', 'Quezon Ave.', 'Poblacion', 'Tubod', 'Lanao del Norte', 'Phillipines', '9209', 'IMG-6273482ee2f1b1.45660014.png'),
(3, 'Lloyd Clarence', 'Maquiling', 'D.', '09515764390', 'Male', '2001-10-26', 'Purok 58', 'Dona Consuelo', 'Ozamiz City', 'Misamis Occidental', 'Phillipines', '7200', 'IMG-625e9c045dd5d9.41805472.jpg'),
(4, 'chester ', 'jalalon', 'c.', '09123456789', 'Male', '2022-01-01', 'asdfasd', 'asdasd', 'asdasd', 'asdasdad', 'Zaire', '134513', NULL),
(5, 'Michael Paul', 'Abangan', '', '09485388922', 'Male', '2000-09-13', 'Mindog, Maningcol', 'Mindog, Maningcol', 'Ozamiz City', 'Misamis Occidental', 'Phillipines', '7200', NULL),
(6, 'asd', 'asd', 'asd', 'asd', 'Male', '2002-01-23', 'sa', 'asd', 'ads', 'das', 'Country', 'dsa', NULL),
(7, 'Justine Mark', 'Tagaan', 'R', '09055757460', 'Untold', '2002-06-22', 'Zamora Street', '50th Barangay', 'Ozamiz City', 'Misamis Occidental', 'Phillipines', '7200', NULL),
(8, 'jay', 'phill', 'H', '09090909', 'Male', '2000-09-06', 'Street', 'P8 Banadero', 'Ozamiz City', 'Mis Oc', 'Phillipines', '7200', NULL),
(9, 'Maxine', 'Angus', 'M', '09389676328', 'Female', '2002-05-21', 'PUROK VALENSULA', 'Sinonoc', 'SINACABAN', 'MISAMIS OCCIDENTAL', 'Phillipines', '7203', NULL),
(10, 'Jed', 'Galda', 'B', '09294874338', 'Male', '2001-08-05', 'Pereyra Village', 'Maningcol', 'Ozamiz City', 'Misamis Occidental', 'Philippines', '7200', NULL),
(12, 'Juan', 'Cruz', '', '09123456789', 'Male', '1920-01-01', 'This Street', 'Barangay', 'This City', 'This Province', 'Afganistan', '9000', 'IMG-627345bc7d1961.02354918.jpg'),
(13, 'John Juan', 'Cryz', '', '09123456789', 'Male', '1920-01-01', 'This Street', 'This Barangay', 'This City', 'This Province', 'Philippines', '9000', NULL),
(14, 'Admin John ', 'Juan', '', '09123456789', 'Male', '1920-01-01', 'This Street', 'This Barangay', 'This City', 'This Province', 'Bahrain', '9000', NULL),
(15, 'asdf', 'asdf', 'd', '345', 'Female', '1920-10-01', 'asd', 'd', 'd', 'd', 'Australia', 'd', NULL),
(16, 'Ruxe', 'Pasok', 'E', '09055757460', 'Untold', '2001-07-04', '', 'Tinago', 'Ozamiz City', 'Misamis Occidental', 'Philippines', '7200', NULL),
(17, 'Secret', 'Mae', 'B.', '09157073832', 'Untold', '2002-09-02', 'Purok 2', 'Tabid', 'Ozamiz', 'Misamis Occidental', 'Philippines', '7200', NULL),
(18, 'Dave', 'Minrang', 'B', '09157073832', 'Male', '2002-01-11', 'Purok 2', 'Annex', 'Ozamiz', 'Misamis Occidental', 'Philippines', '7200', NULL),
(19, 'Dave', 'Epe', 'F.', '09556727262', 'Male', '2002-08-15', '.', '.', '.', '.', 'Philippines', '.', NULL),
(20, 'Jan Khen', 'Dayon', 'M', '123', 'Male', '2003-01-05', 'secret ', 'secret ', 'secret ', 'sekret', 'Zimbabwe', '12345', NULL),
(21, 'Crystal', 'Lagunsad', 'J', '0936 031 9176', 'Female', '2004-01-17', 'P4 Bualan Tubod Lanao Del norte', 'Bualan', 'Tubod', 'Lanao del Norte', 'Philippines', '9209', 'IMG-6613de00935a33.68039879.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `prod_no` int(11) NOT NULL,
  `category` enum('Milk Tea','Frappe','Fruit Tea','Hot Drinks','Cold Drinks','Lemonade','Soya Drink','Soda Pops','Food') NOT NULL,
  `prod_name` varchar(40) NOT NULL,
  `prod_description` text NOT NULL,
  `prod_date` date NOT NULL,
  `prod_price` decimal(10,2) NOT NULL,
  `prod_img` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_no`, `category`, `prod_name`, `prod_description`, `prod_date`, `prod_price`, `prod_img`, `status`) VALUES
(1, 'Milk Tea', 'Almond Milk Tea', 'Almond milk and black tea are a match made in heaven.\r\n\r\nThe combination first became popular with tea drinkers who had to avoid milk for dietary reasons. However, the explosion of the boba milk tea fashion quickly brought this delicious tea to conquer a much wider stage.\r\n\r\nNow, almond milk tea is one of the most popular flavors for bubble tea, especially among black tea lovers.\r\n\r\nMaking almond milk tea at home is easy. This is our tried and tested boba almond tea recipe.', '2022-04-14', '80.00', 'product-625b6be85eee85.21558417.jpg', 'Available'),
(2, 'Milk Tea', 'Hazelnut Milk Tea', 'The color of this is more of a tan with no trace of the milk separating.\r\n\r\nThis drink has an aroma of lemon curd with subtle hints of hazelnut flour. \r\n\r\nThe flavor of this drink is of sour milk and black tea. There is a citrus and berry note that is in the back like of blueberry and navel orange but its hardly noticeable.  There is no trace or flavor of hazelnut in this in any way!\r\n\r\nIt does make you salivate and has a dry after taste like of a tart green apple and is probable from malic acid. ', '2022-04-15', '85.00', 'product-625b6e1dccfcb3.39672856.jpg', 'Available'),
(3, 'Hot Drinks', 'Coffee', 'Our coffee is undoubtedly the best way to start your day, and our delicious, fresh breakfast and lunch options will satisfy your appetite.\r\n\r\nGreat coffee starts with great beans.\r\n\r\nWe use an exclusive blend of the highest quality coffee beans, then our baristas work their magic to make your coffee exactly how you like it.\r\n', '2022-04-15', '60.00', 'product-625b6efd264ae4.41136895.png', 'Not Available'),
(4, 'Cold Drinks', 'Iced Coffee', 'Drinking iced coffee is a real refreshment compared to hot coffee. You\'ll never burn your tongue on that really hot coffee again, which always means that everything you put in your mouth for the rest of the week has a slightly crazy taste. You do not have to wait for the coffee to reach a drinkable temperature, you can enjoy the coffee immediately!', '2022-04-16', '70.00', 'product-625b70a949a713.88633739.png', 'Available'),
(5, 'Soya Drink', 'Chocolate Soya', 'Soya drink, chocolate flavour, with added calcium and vitamins.\r\nA varied, balanced diet and a healthy lifestyle is recommended for good health.\r\nSoya products fit in a varied and balanced diet.\r\n\r\nProtein contributes to the maintenance of muscle mass.\r\nFarmed Responsibly, we leave the rainforest Lush and Lovely.\r\nFrom bean... grown, picked, soaked, blended and enjoyed!\r\n\r\nGo. Right. Ahead. Our guarantee to you is a Rich Chocolatey Taste at its prime. Carefully crafted, our Freshly Chilled chocolate flavour soya drink is naturally Low in Saturated Fat.', '2022-04-16', '90.00', 'product-625b72c9149e54.18982836.jpg', 'Available'),
(6, 'Frappe', 'Black Forest', 'A black forest chocolate you will go crazy for. Nothing goes better with a night in than tart cherries, dark chocolate, and airy whipped cream. Everyone will be begging for another mug of cherry hot chocolate!\r\n\r\nToday we are celebrating with a Black Forest chocolate made with rich chocolate, tart cherries, and delightfully airy whipped cream. And it can be made a little boozy if you have any kirsch or cherry-flavored brandy available.', '2022-04-16', '100.00', 'product-625b7521544c03.95918544.jpg', 'Available'),
(7, 'Lemonade', 'Blueberry Mint', 'Made with an easy blueberry simple syrup, this lemonade is so refreshing, sweet and tangy. It’s the perfect way to cool down on a hot day!\r\n\r\nWith a simple blueberry syrup, this drink could not get any easier. It’s wonderfully fruity and sweet from the plump juicy blueberries with just enough of a tart kick. And it’s really the perfect way to cool down on a hot day. Plus, if you’re anything like me, well, you’ll sneak in some vodka for an adult-style lemonade!', '2022-04-17', '95.00', 'product-625b76029ec146.11389834.png', 'Available'),
(8, 'Fruit Tea', 'Lemon Pepermint', 'Lemon and mint tea is a naturally caffeine free tea, has a strong aroma and flavor of mint because of its menthol content. This is an excellent herb tea that detoxifies, rejuvenates and soothes your body. \r\n\r\nMint leaves also known as pudina or mint derived from the Greek word Mintha is a genus of flowering plants from the Lamiaceae family.  Mint leaves are a leaf most well-known for the fragrance and cool refreshing taste. Mint can be either used as fresh leaves or dried and is best source of mint in cooking.', '2022-04-14', '60.00', 'product-625b76c9c0b9a5.49694323.jpeg', 'Available'),
(9, 'Soda Pops', 'Green Apple', 'Offer up a fun and delicious beverage your customers can trust with this Green Apple Soda. Crafted using pure cane sugar and natural flavors, this Green Apple Soda features a crisp, tart apple flavor for an irresistible treat your guests will appreciate. For best results, serve this soda chilled or over ice to accentuate its high quality taste. Whether served alone or as part of a specialty cocktail, this green apple soda is sure to please!', '2022-04-17', '70.00', 'product-625b78a4ef2ba5.16242827.png', 'Available'),
(10, 'Frappe', 'Chocolate Malt Milo Godzilla', 'Chocolate malt drinks are highly popular in Southeast Asia and are sometimes enjoyed together with a scoop of vanilla ice cream or whipped cream. As such, they are given fanciful names like “Milo Dinosaur” and “Milo Godzilla”.\r\n\r\nThe most popular chocolate malt brand that is Milo which is also widely available in Australia. One of the drinks, “Milo Dinosaur” is topped with heaps of chocolate malt powder while the other, “Milo Godzilla” is topped with whipped cream and/or vanilla ice cream. These heaps of chocolate malt powder are added to give extra crunch to the drinks.', '2022-04-17', '110.00', 'product-625b7ad183f737.99631564.jpg', 'Available'),
(11, 'Milk Tea', 'Hokkaido Milk Tea', 'Hokkaido milk tea is a unique tea-based beverage that originates from the Hokkaido region of Japan. Although green teas like Sencha and Gyokuro are the most common types of tea consumed in Japan, Hokkaido milk tea is actually made using black tea. ', '2022-05-02', '90.00', 'product-626f489b14a288.67485309.png', 'Available'),
(12, 'Milk Tea', 'Okinawa Milk Tea', 'Okinawa milk tea also originated in Japan. It consists of a hearty black tea base blended with milk and Okinawa brown sugar. This special type of brown sugar, also known as kokuto, is made by reducing pure sugarcane juice, and has a complex, nuanced flavor and a high vitamin and mineral content.', '2022-05-02', '90.00', 'product-626f4b29d573e1.29454575.png', 'Available'),
(13, 'Hot Drinks', 'Irish Coffee', 'The Irish Coffee may not be the first coffee drink with alcohol, but this cocktail has become one of the most famous. Combining coffee with Irish whiskey, brown sugar and lightly whipped cream, the Irish Coffee is a hot, creamy classic that can wake you up on cold mornings or keep you going after a long night.', '2022-05-02', '100.00', 'product-626fd6c8429524.30894853.png', 'Available'),
(14, 'Milk Tea', 'Boba (Bubble Tea)', 'Boba, often also known as bubble tea or pearl milk tea, is a unique milky tea flavored with tapioca pearls. While boba can be made without milk, milk or condensed milk is often added to the drink. This tea is typically served iced. Boba comes in many different flavors, from classic black tea versions to fruity, floral, or sweet concoctions. Boba originated in Taiwan, but is now popular all over the world.', '2022-05-02', '60.00', 'product-626f4bc0863c60.13350175.png', 'Available'),
(15, 'Milk Tea', 'Masala Chai', 'Masala Chai also has its origins in British colonization. Drinking tea became popular in India in the late 19th and early 20th centuries, when British colonists began growing tea in India rather than purchasing it from China. Masala Chai soon developed into a popular local drink in its own right, with traditional Indian spices added to black tea for a unique and satisfying drink. Masala Chai can be made by steeping tea and spices directly in steamed milk, or by adding milk to a cup of traditionally prepared tea. You can also make a chai latte by frothing the milk!', '2022-05-02', '50.00', 'product-626f4c51b4f7f9.19357400.png', 'Available'),
(16, 'Milk Tea', 'Hong Kong Milk Tea', 'This tea originated in Hong Kong, and may have its origins under the British colonial rule, where the practice of drinking afternoon tea with milk and sugar where introduced.', '2022-05-02', '55.00', 'product-626f4d80283f72.96395552.png', 'Available'),
(17, 'Milk Tea', 'Milk Oolong', 'Milk Oolong is a Taiwanese tea named for the creamy and buttery taste it passes in a cup of tea. It doesn’t actually contain any milk in it, but it really does taste like milk! Real Milk Oolong tea provides a taste of sweet butter and milk through gently roasted and rolled tea leaves, and has this sweet flowery scent.', '2022-05-02', '80.00', 'product-626f4e1b38de40.29960723.png', 'Available'),
(18, 'Milk Tea', 'Thai Tea', 'Thai tea is a combination of tea, milk, and sugar. This tea is often served as an iced tea, and usually has a base of Ceylon or Assam. Thai tea can be flavored using ingredients such as mint, lime, star anise, orange blossoms, tamarind, and other spices. It is sweetened with sugar or condensed milk. It is sold as a powdered mix, but you can also easily make this from scratch at home.', '2022-05-28', '70.00', 'product-626f4f3dd47c87.30904535.png', 'Available'),
(19, 'Frappe', 'Caramel Frappuccino', 'A blend of toffee nut syrup, Frappuccino Roast Coffee, milk and ice and topped with a layer of dark caramel sauce, finished with whipped cream and a drizzle of mocha sauce', '2022-05-21', '90.00', 'product-626f50ed4da200.88650254.png', 'Available'),
(20, 'Frappe', 'Cinnamon Roll Frappuccino', 'A blend of cinnamon dolce syrup, white chocolate mocha sauce, vanilla bean, Frappuccino Roast Coffee, milk and ice, finished with whipped cream and a sprinkle of cinnamon dolce topping ', '2022-05-21', '90.00', 'product-626f515eb23544.85377978.png', 'Available'),
(21, 'Frappe', 'Cotton Candy Frappuccino', 'A blend of vanilla bean, raspberry syrup, milk and ice, finished with whipped cream', '2022-05-02', '90.00', 'product-626f51db33c3f3.61752877.png', 'Available'),
(22, 'Frappe', 'Bloody Red Velvet Hot Chocolate', 'rves 4Thick and creamy bloody red velvet hot chocolate made with chocolate chips and red velvet cake mix. Top with whipped cream and blood splatter!', '2022-05-02', '99.00', 'product-626f53a6c930c1.84790323.png', 'Available'),
(23, 'Frappe', 'Vanilla Bean Frappuccino', 'It all comes down to the fact that there\'s just nothing special going on here. There\'s no drizzle of chocolate or caramel to compete with the overwhelming flavor of the vanilla. And after a few sips, you\'re probably going to be over it.', '2022-06-11', '85.00', 'product-626f5478763003.57192123.png', 'Available'),
(24, 'Fruit Tea', 'Green Tea', 'After the fresh, green tea leaves and buds have been picked from the tea plants, they’re withered to reduce moisture and “fixed” to keep their verdant and green qualities. By quickly heating the leaves (by firing them in pans or an oven, or steaming them with water) you deactivate the enzymes that oxidize the leaves and turn them brown.', '2022-05-02', '80.00', 'product-626f58965f9198.17312719.png', 'Available'),
(25, 'Fruit Tea', 'Rooibos Tea', 'Rooibos (red bush) is an herbal tea from South Africa. It’s naturally caffeine-free and contains as many antioxidants if not more than traditional tea. Without flavoring or additives, rooibos tea is rich, full-bodied, sweet and a little nutty. It’s a great caffeine-free alternative to tea. Health benefits of drinking rooibos tea include reducing blood pressure (thus reducing the risks of heart disease), improving skin and hair strength and preventing diabetes.', '2022-05-02', '88.00', 'product-626f597e636e56.12570149.png', 'Available'),
(26, 'Fruit Tea', 'Orange Peel Black Tea', 'Tangy and sweet with a little bite, Orange Peel blends organic black tea with organic orange peels for a delicious drink that\'s loaded with citrusy flavor. Aromatic and naturally sweet, this tea is sure to be a crowd-pleaser.', '2022-05-02', '70.00', 'product-626f5a3454f514.98414094.png', 'Available'),
(27, 'Fruit Tea', 'Mango Green Tea', 'This refreshing mango green tea gets ready in under 10 minutes using simple ingredients. Make a big pitcher using fresh or frozen mangoes.', '2022-05-28', '79.00', 'product-626f5b0810ea03.09467886.png', 'Available'),
(28, 'Fruit Tea', 'Very Berry Iced Tea', 'This Very Berry Iced Tea with Honey Mint Syrup is so refreshing and filled with the tastes of summer.', '2022-05-28', '90.00', 'product-626f5cc93f39f0.74019900.png', 'Available'),
(29, 'Fruit Tea', 'Strawberry ', 'Strawberry tea is a red, sweet, fruity, and freshly brewed tea that is flavored with fresh summer strawberries. ', '2022-05-02', '90.00', 'product-626fcc5dd563d0.77457183.png', 'Available'),
(30, 'Fruit Tea', 'Honey lemon tea', ' Honey lemon tea is as a body cleanser. · It serves as a digestive aid by providing an overall calming effect on the stomach.', '2022-05-02', '75.00', 'product-626fcd85941151.56776060.png', 'Available'),
(31, 'Fruit Tea', 'Cranberry tea', 'Drinking cranberry tea is safe and provides numerous health benefits. Filled with vitamins and anti-oxidants, cranberry tea sure is a delicious way to stay healthy!', '2022-05-26', '99.00', 'product-626fcfee55a546.05367280.png', 'Available'),
(32, 'Fruit Tea', 'Blueberry tea', 'Blueberry tea is made by steeping leaves of the blueberry bush in hot water. A fragrant and delicious beverage, it provides a number of unique health benefits that make it both refreshing to drink and beneficial to your body.\r\n\r\n', '2022-05-02', '80.00', 'product-626fd0aecd0311.66059397.png', 'Available'),
(33, 'Hot Drinks', ' Caffe mocha', 'A caffè latte with chocolate and whipped cream, made by pouring about 2 cl of chocolate sauce into the glass, followed by an espresso shot and steamed milk. ', '2022-05-02', '120.00', 'product-626fd1d6b07ec5.73293609.png', 'Available'),
(34, 'Hot Drinks', 'Latte macchiato', 'Like a traditional caffè latte, but with a thicker layer of foam. Often made by pouring an espresso last into the milk (drink size about 300 ml). Served in a latte glass.', '2022-05-30', '65.00', 'product-626fd29e818551.84485654.png', 'Available'),
(35, 'Hot Drinks', 'ESPRESSO CON PANNA', 'A shot of espresso topped with whipped cream. Served in an espresso cup.', '2022-05-02', '50.00', 'product-626fd473bde286.15018451.png', 'Available'),
(36, 'Hot Drinks', 'AMERICANO', 'Espresso with added hot water (100–150 ml). Often served in a cappuccino cup. (The espresso is added into the hot water rather than all the water being flowed through the coffee that would lead to over extraction.)', '2022-05-02', '65.00', 'product-626fd707085642.98688291.png', 'Available'),
(37, 'Hot Drinks', 'DOUBLE ESPRESSO (DOPPIO)', 'Double portion of espresso in a cappuccino/espresso cup.', '2022-05-02', '60.00', 'product-626fd5caac9335.74572430.png', 'Available'),
(38, 'Hot Drinks', 'Espresso', 'A short, strong drink (about 30 ml) served in an espresso cup.', '2022-05-02', '60.00', 'product-626fd64702cff6.79665671.png', 'Available'),
(39, 'Hot Drinks', 'Irish Coffee', 'Classic coffee coctail where Irish whiskey is mixed with filter coffee and topped with thin layer of gently whipped cream.', '2022-05-02', '100.00', 'product-626fd6c8429524.30894853.png', 'Available'),
(40, 'Hot Drinks', 'LUNGO', 'Lungo, or long in Italian, is a type of Espresso-based coffee drink. As the name suggests, this type of coffee is longer than the traditional espresso; requiring a larger coffee to water ratio.', '2022-05-02', '79.00', 'product-626fd79a0328f8.62371142.png', 'Available'),
(41, 'Cold Drinks', 'Hisbicus Mocktini', 'Mix equal parts hibiscus tea and ginger ale for a sparkling summer drink.', '2022-05-02', '55.00', 'product-626fd88306cdf2.44063163.png', 'Available'),
(42, 'Cold Drinks', 'Ginger Beer', 'Despite its name, ginger beer is a kid-friendly summer drink. This homemade version can be served on its own, or can help you kick your standard Moscow Mule or Dark and Stormy up a notch. ', '2022-05-02', '50.00', 'product-626fd90059a489.17559009.png', 'Available'),
(43, 'Cold Drinks', 'Espresso slushy', 'Instant espresso gives a low-cal cool drink some kick.', '2022-05-20', '55.00', 'product-626fd9904ef596.98079938.png', 'Available'),
(44, 'Cold Drinks', 'Raspberry Fizz', 'Top a ginger ale–cranberry juice combo with scoops of raspberry sorbet.', '2022-05-02', '88.30', 'product-626fd9f3867867.40578171.png', 'Available'),
(45, 'Cold Drinks', 'Iced green tea with ginger and mint', 'Spice up a refreshing green iced tea with the flavors of fresh ginger and mint.', '2022-05-02', '75.00', 'product-626fdaece15e12.84185148.png', 'Available'),
(46, 'Cold Drinks', 'Watermelon mint cooler', 'This summer drink is as juicy and refreshing as a slice of watermelon on a sweltering afternoon', '2022-05-02', '60.00', 'product-626fdb57470f55.27962380.png', 'Available'),
(47, 'Cold Drinks', 'Cucumber and lime spritzer', 'Slightly tart and brisk, this is a mocktail for grown-ups. ', '2022-05-31', '55.00', 'product-626fdbd65f7b26.24584763.png', 'Available'),
(48, 'Cold Drinks', 'Sparkling pineapple ginger ale', 'Pineapple sweetens the tang of ginger ale for a cool drink with tropical vibes.', '2022-05-02', '89.00', 'product-626fdcdd116155.06123354.png', 'Available'),
(49, 'Cold Drinks', 'Iced tea with plums and thyme', 'Serve this fruit-and-herb blend as a nonalcoholic sipper or spike it with bourbon. ', '2022-05-31', '78.00', 'product-626fdceeebac32.21492958.png', 'Available'),
(50, 'Frappe', 'Black forest frappe', 'With prospects of a warm and sunny weekend why not relax and enjoy this delicious Black Forest Frappe.', '2022-05-02', '150.00', 'product-626fdd94b321b1.70766533.png', 'Available'),
(51, 'Frappe', 'Cookies and cream frappe', 'A grownup coffee drink meets a childhood favorite.', '2022-05-02', '120.00', 'product-626fde5e2f1e45.35216972.png', 'Available'),
(52, 'Frappe', 'Mocha Cookie Crumble', 'Frappuccino Roast coffee, mocha sauce and Frappuccino chips blended with milk and ice, layered on top of whipped cream and chocolate cookie crumble and topped with vanilla whipped cream, mocha drizzle and even more chocolate cookie crumble.', '2022-05-02', '180.00', 'product-626fdf0e9b2df8.58041966.png', 'Available'),
(53, 'Milk Tea', 'Yakult Milk Tea', ' Offers a variety of flavours under their Yakult drink line, so if you’re up for something a little more fruity, feel free to try their Lychee, Strawberry, Passionfruit, Peach or Jasmine Tea Yakult drink! ', '2022-05-19', '95.00', 'product-626fe011eea749.37763737.png', 'Available'),
(54, 'Lemonade', 'Strawberry Watermelon Lemonade', 'A drink full of sweet-tart flavor. ', '2022-05-02', '88.00', 'product-626fe1048c7cd6.03431136.jpg', 'Available'),
(55, 'Lemonade', 'Peach-Basil Lemonade Slush', 'This chilly slush with peaches, lemon juice and garden-fresh basil is hands-down the best lemonade ever. It tastes just like summer.', '2022-05-02', '95.00', 'product-626fe14ec15895.25607047.jpg', 'Available'),
(56, 'Lemonade', 'Blackberry Beer Cocktail', 'This refreshing hard lemonade has a mild alcohol flavor; the beer adds just enough fizz to dance on your tongue as you sip. Sorry, adults only!', '2022-05-02', '165.00', 'product-626fe1c8b75322.73446216.jpg', 'Available'),
(57, 'Lemonade', 'Summertime Tea', 'ou can’t have a summer gathering around here without this sweet tea to cool you down. It’s wonderful for sipping while basking by the pool.', '2022-05-02', '89.00', 'product-626fe1fbe429d8.38661272.jpg', 'Available'),
(58, 'Lemonade', 'Kentucky Lemonade', 'Mint and bourbon give this drink a bit of a Kentucky kick, and ginger ale makes it a fizzy party punch.', '2022-05-27', '75.00', 'product-626fe2671a9a73.91834096.jpg', 'Available'),
(59, 'Lemonade', 'Rosemary Lemonade', 'The herb makes the drink taste fresh and light, and it\'s a pretty garnish. ', '2022-05-02', '55.00', 'product-626fe2a8ab92e7.32713412.jpg', 'Available'),
(60, 'Lemonade', 'Red and Blue Berry Lemonade Slush', 'This delightfully sweet-tart beverage showcases fresh raspberries and blueberries.', '2022-05-02', '79.00', 'product-626fe2e5b9c518.28673239.jpg', 'Available'),
(61, 'Lemonade', 'Blackberry Lemonade', 'Here\'s a special drink that\'s perfect when blackberries are in season. It has a tangy, refreshing flavor.', '2022-05-02', '89.00', 'product-626fe3364079c2.95746748.jpg', 'Available'),
(62, 'Lemonade', 'Sparkling Kiwi Lemonade', 'Keep some kiwi ice cubes in the freezer so they’re ready whenever you crave a tall glass of this dressed-up summertime favorite.', '2022-05-02', '69.00', 'product-626fe396af2710.55361264.jpg', 'Available'),
(63, 'Soya Drink', 'Chocolate soy thickshake', 'Indulge in this dairy-free chocolate thickshake.', '2022-05-03', '55.00', 'product-6270b0a277e105.36890627.jpeg', 'Available'),
(64, 'Soya Drink', 'Cherry yoghurt soy shake', 'Serve milkshakes topped with a scoop of sorbet.', '2022-05-03', '60.00', 'product-6270b3cb6dbaa3.91973706.jpeg', 'Available'),
(65, 'Soya Drink', 'Cherry yoghurt soy shake', 'A satisfying fruity in-between snack, that can be made in a jiffy. The antioxidants flavonoids from soya, fiber from apples and bio-active compound from cinnamon helps to avoid a quick rinse in blood sugar levels and the low-fat milk that gives you enough calcium.', '2022-05-03', '45.00', 'product-6270b38e3346a4.98098766.jpg', 'Available'),
(66, 'Soya Drink', 'Mango soya milk shake', 'Plain protien rich soya milk may be boring, but your kids can\'t just resist it when when blended with vitamin A rich with mango pulp', '2022-05-03', '75.00', 'product-6270b4ba3f6318.42741058.png', 'Available'),
(67, 'Soya Drink', 'Strawberry soy milk shake', 'Enjoy the goodness of tofu, soya milk with strawberries', '2022-05-03', '89.00', 'product-6270b5a8e46b27.64519017.png', 'Available'),
(68, 'Soya Drink', 'Apricot apple smoothie', 'Best energizing drink to keep you going all day. A combination of ingredients like banana, nuts, apples, and soya milk. Perfect energy drink after exercising ', '2022-05-03', '89.00', 'product-6270b734656312.18329747.png', 'Available'),
(69, 'Soya Drink', 'Flax seed smoothie', 'The use of fibre-rich flax seeds and calcium and protein-rich soya milk lends a healthy angle to the flax seed smoothie. At the same time, the lemon juice plays an indispensable role in enhancing the flavours of the scrumptious fruits used in this smoothie.', '2022-05-03', '75.00', 'product-6270b8152f4a97.28486276.png', 'Available'),
(70, 'Soya Drink', 'Espresso Soy Milk Shake', 'Willett is a fan of soy milk and ice cream. This satisfying shake is a speedy dessert. It\'s also a way to enjoy the health benefits of caffeine, which may help lower your risk of diabetes and Parkinson\'s disease.', '2022-05-03', '70.00', 'product-6270b90867b0c1.08407076.png', 'Available'),
(71, 'Soya Drink', 'SOY MILK HOT CHOCOLATE', 'The best way to spend a snowy day is cuddling on the couch with the family, a furry friend, or just a significant other, with a classic holiday movie playing and a warm cup of hot chocolate in your hands. ', '2022-05-03', '89.00', 'product-6270b9d01c7e63.89781170.png', 'Available'),
(72, 'Soda Pops', 'Blue Lagoon Mocktail', 'This refreshing non alcoholic drink is easy to make for kids and adults to enjoy. Savor this blue lagoon mocktail on hot summer days. You can even make it into a fun slushy!', '2022-05-03', '78.00', 'product-6270ba54084241.61021214.png', 'Available'),
(73, 'Soda Pops', 'Virgin Blackberry Rosewater Smash', 'The best refreshing drink, featuring blackberries, lime, and rosewater, is called virgin blackberry rosewater smash. A hit at every party!', '2022-05-28', '90.00', 'product-6270bb174246f0.76339678.png', 'Available'),
(74, 'Soda Pops', 'Cranberry Celebration', 'A nice choice for holiday entertaining, this fresh-flavored cranberry cocktail is made with vodka, a cranberry-orange reduction, lemon juice and club soda.', '2022-05-03', '99.00', 'product-6270bbb2c4a511.31869773.png', 'Available'),
(75, 'Soda Pops', 'Raspberry Burnet Soda Pop', 'This simple and refreshing beverage has the tart flavor of raspberries and lime and the subtle flavor of cucumber that comes from the herb burnet. ', '2022-05-03', '120.00', 'product-6270bce0385f52.51657172.png', 'Available'),
(76, 'Soda Pops', 'Cucumber Agua Fresca', 'Agua fresca de pepino or cucumber agua fresca is a delicious and refreshing beverage made from fresh cucumbers, citrus juice, water, and a touch of sweetener. ', '2022-05-03', '79.00', 'product-6270bd4628d7c7.58163084.png', 'Available'),
(77, 'Soda Pops', 'Coffee soda', 'This homemade, do-it-yourself coffee soda is so simple to make and a really fun way to enjoy your coffee.', '2022-05-03', '50.00', 'product-6270bd9ac0cd19.91474006.png', 'Available'),
(78, 'Soda Pops', 'Mango Mint Limeade Slush', 'This refreshing fruit slush is the perfect beverage to cool you down this summer! This blended frozen drink combines mangos, mint, lime, and coconut water.', '2022-05-03', '60.00', 'product-6270be4b6ec572.17582986.png', 'Available'),
(79, 'Soda Pops', 'Cream Soda', ' Cream Soda is a super simple, nostalgic soda recipe that\'s easy to make at home and is so refreshing on warm summer days. ', '2022-05-03', '45.00', 'product-6270bed9085342.27173677.png', 'Available'),
(80, 'Soda Pops', 'Soda Syrups', 'Resist popping tabs this season and get familiar with the ultimate cola cure: soda syrups made from fresh fruits and herbs.', '2022-05-28', '55.00', 'product-6270bf725a84e5.31574158.png', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `recognizedip`
--

DROP TABLE IF EXISTS `recognizedip`;
CREATE TABLE `recognizedip` (
  `rcgIP_id` int(11) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `location` varchar(150) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `recognizedip`
--

INSERT INTO `recognizedip` (`rcgIP_id`, `ip`, `location`, `datetime`, `status`, `user_id`) VALUES
(22, '49.146.36.115', 'Cagayan de Oro, Northern Mindanao', '2023-05-14 13:28:13', 'Active', '2023433798592'),
(23, '49.146.39.204', 'Cagayan de Oro, Northern Mindanao', '2023-05-21 18:45:14', 'Active', '2023433798592'),
(24, '49.146.38.174', 'Cagayan de Oro, Northern Mindanao', '2023-05-29 22:34:57', 'Inactive', '2023433798592'),
(25, '222.127.191.150', 'Davao City, Davao', '2023-06-04 20:34:07', 'Active', '2023433798592'),
(26, '120.28.213.116', 'Davao City, Davao', '2023-06-05 10:29:23', 'Active', '2023433798592');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `username` varchar(20) NOT NULL,
  `usertype` varchar(10) NOT NULL DEFAULT 'Customer',
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `email`, `username`, `usertype`, `password`) VALUES
(1, 'ruxepasok356@gmail.com', 'ruxepasok100', 'Customer', '1234'),
(2, 'marck@gmail.com', 'marck', 'Customer', 'marck123'),
(3, 'lloydclarencemaquiling@gmail.com', 'Lloydie', 'Customer', 'lloydie1026'),
(4, 'chesterfredj@gmail.com', 'chester', 'Customer', '1234'),
(5, 'bros.e.dome@gmail.com', 'Midas_Touch', 'Customer', '87654321'),
(6, 'sa@gmial.com', 'user1', 'Customer', 'user1'),
(7, 'tagaanjustinemark5@gmail.com', 'justine', 'Customer', 'justine1234'),
(8, 'phill@gmail.com', 'phill', 'Customer', '1234'),
(9, 'maxinegladys21@gmail.com', 'Maxine', 'Customer', 'enixam'),
(10, 'galdajed21@gmail.com', 'galdajed', 'Customer', 'jedgalda21'),
(12, 'customer@gmail.com', 'customer', 'Customer', 'customer1234'),
(13, 'incharge@gmail.com', 'incharge', 'In-charge', 'incharge1234'),
(14, 'admin@gmail.com', 'admin', 'Admin', 'admin1234'),
(15, 'customer@gmail.com', 'customer1', 'In-charge', '1234'),
(16, 'ruxepasok356@gmail.com', 'ruxe', 'Customer', 'pasok'),
(17, 'mae.secret@gmail.com', 'mae', 'Customer', '1234'),
(18, 'mae.secret@gmail.com', 'dave', 'In-charge', '123456'),
(19, 'epedave3@gmail.com', 'daveepe', 'Customer', '1900057epe'),
(20, 'None@none.com', 'jankhen', 'Customer', 'jankhen2003'),
(21, 'crystal@gmail.com', 'taljean', 'Customer', '123');

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

DROP TABLE IF EXISTS `userprofile`;
CREATE TABLE `userprofile` (
  `userid` varchar(20) NOT NULL,
  `fname` varchar(40) NOT NULL,
  `lname` varchar(40) NOT NULL,
  `mid_init` varchar(3) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `gender` varchar(15) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `barangay` varchar(30) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `country` varchar(40) DEFAULT 'Philippines',
  `postalcode` varchar(30) DEFAULT NULL,
  `profile_img` text DEFAULT NULL,
  `datetime_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`userid`, `fname`, `lname`, `mid_init`, `contact_no`, `gender`, `birthdate`, `street`, `barangay`, `city`, `province`, `country`, `postalcode`, `profile_img`, `datetime_created`) VALUES
('2023433798592', 'Ruxe', 'Pasok', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Philippines', NULL, NULL, '2023-05-14 13:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `prod_no` int(11) NOT NULL,
  `userid` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `prod_no`, `userid`, `created_at`) VALUES
(26, 42, '2023433798592', '2023-06-04 10:09:13'),
(27, 35, '2023433798592', '2023-06-04 10:09:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`addonsID`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `FK_product_TO_cart_item` (`prod_no`),
  ADD KEY `FK_person_TO_cart_item` (`id`),
  ADD KEY `FK_addons_TO_cart_item` (`addonsID`);

--
-- Indexes for table `deliveryaddress`
--
ALTER TABLE `deliveryaddress`
  ADD PRIMARY KEY (`deladd_id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`order_id`,`prod_no`),
  ADD KEY `FK_product_TO_orderdetail` (`prod_no`),
  ADD KEY `FK_addons_TO_orderdetail` (`addonsID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `FK_person_TO_orders` (`customer_id`),
  ADD KEY `prepared_by` (`prepared_by`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `FK_person_TO_payment` (`customer_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_id` (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_no`),
  ADD UNIQUE KEY `UQ_prod_no` (`prod_no`);

--
-- Indexes for table `recognizedip`
--
ALTER TABLE `recognizedip`
  ADD PRIMARY KEY (`rcgIP_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `prod_no` (`prod_no`),
  ADD KEY `userid` (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT for table `deliveryaddress`
--
ALTER TABLE `deliveryaddress`
  MODIFY `deladd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `recognizedip`
--
ALTER TABLE `recognizedip`
  MODIFY `rcgIP_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `FK_addons_TO_cart_item` FOREIGN KEY (`addonsID`) REFERENCES `addons` (`addonsID`),
  ADD CONSTRAINT `FK_person_TO_cart_item` FOREIGN KEY (`id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `FK_product_TO_cart_item` FOREIGN KEY (`prod_no`) REFERENCES `product` (`prod_no`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `FK_addons_TO_orderdetail` FOREIGN KEY (`addonsID`) REFERENCES `addons` (`addonsID`),
  ADD CONSTRAINT `FK_orders_TO_orderdetail` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `FK_product_TO_orderdetail` FOREIGN KEY (`prod_no`) REFERENCES `product` (`prod_no`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_person_TO_orders` FOREIGN KEY (`customer_id`) REFERENCES `person` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_person_TO_payment` FOREIGN KEY (`customer_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD CONSTRAINT `FK_person_TO_userinfo` FOREIGN KEY (`id`) REFERENCES `person` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
