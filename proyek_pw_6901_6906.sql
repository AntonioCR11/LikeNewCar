-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2021 at 12:25 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyek_pw_6901_6906`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id_brand` int(100) NOT NULL,
  `brand_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id_brand`, `brand_name`) VALUES
(1, 'Daihatsu'),
(2, 'Honda'),
(3, 'Mazda'),
(4, 'Mitsubishi'),
(5, 'Nissan'),
(6, 'Suzuki'),
(7, 'Toyota'),
(8, 'Wuling');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id_car` int(100) NOT NULL,
  `car_brand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_transmission` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_year` int(4) NOT NULL,
  `car_kilometer` int(100) NOT NULL,
  `car_price` int(100) NOT NULL,
  `car_location` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id_car`, `car_brand`, `car_model`, `car_type`, `car_name`, `car_transmission`, `car_year`, `car_kilometer`, `car_price`, `car_location`, `car_status`) VALUES
(1, 'Toyota', 'CALYA ', 'MPV', 'G 1.2', 'Automatic', 2016, 75833, 104000000, 'Tangerang Selatan', 'Available'),
(2, 'Toyota', 'RUSH', 'SUV', 'S TRD 1.5', 'Automatic', 2021, 14832, 252000000, 'Jakarta Selatan', 'Available'),
(3, 'Toyota', 'YARIS', 'Hatchback', 'S TRD 1.5', 'Automatic', 2019, 28264, 222000000, 'Bekasi', 'Available'),
(4, 'Toyota', 'CALYA ', 'MPV', 'G 1.2', 'Manual', 2021, 11888, 138000000, 'Tangerang Selatan', 'Available'),
(5, 'Honda', 'MOBILIO', 'MPV', 'E 1.5', 'Automatic', 2014, 83528, 126000000, 'Jakarta Selatan', 'Available'),
(6, 'Toyota', 'CALYA ', 'MPV', 'G 1.2', 'Manual', 2021, 5384, 133000000, 'Bekasi', 'Available'),
(7, 'Daihatsu', 'XENIA', 'MPV', 'X STD 1.3', 'Manual', 2015, 41140, 106000000, 'Tangerang Selatan', 'Available'),
(8, 'Toyota', 'RUSH', 'SUV', 'G 1.5', 'Automatic', 2021, 7106, 235000000, 'Jakarta Selatan', 'Available'),
(9, 'Toyota', 'YARIS', 'Hatchback', 'S TRD 1.5', 'Automatic', 2017, 46636, 187000000, 'Bekasi', 'Available'),
(10, 'Suzuki', 'XL7', 'MPV', 'ALPHA 1.5', 'Manual', 2021, 4152, 222000000, 'Tangerang Selatan', 'Available'),
(11, 'Daihatsu', 'TERIOS', 'SUV', 'R 1.5', 'Manual', 2018, 58389, 195000000, 'Jakarta Selatan', 'Available'),
(12, 'Toyota', 'FORTUNER', 'SUV', 'VRZ 4X2 2.4', 'Automatic', 2021, 3310, 545000000, 'Bekasi', 'Available'),
(13, 'Honda', 'JAZZ', 'Hatchback', 'RS 1.5', 'Automatic', 2018, 30854, 238900000, 'Tangerang Selatan', 'Available'),
(14, 'Suzuki', 'BALENO', 'Hatchback', 'HATCHBACK 1.4', 'Automatic', 2020, 12432, 201000000, 'Jakarta Selatan', 'Available'),
(15, 'Toyota', 'VOXY', 'MPV', 'VOXY 2.0', 'Automatic', 2018, 37020, 407000000, 'Bekasi', 'Available'),
(16, 'Honda', 'HR-V', 'SUV', 'E 1.5', 'Automatic', 2020, 14795, 313000000, 'Tangerang Selatan', 'Available'),
(17, 'Mitsubishi', 'XPANDER', 'SUV', 'CROSS PREMIUM 1.5', 'Automatic', 2020, 26412, 254000000, 'Jakarta Selatan', 'Available'),
(18, 'Honda', 'BR-V', 'SUV', 'PRESTIGE 1.5', 'Automatic', 2020, 20642, 215000000, 'Bekasi', 'Available'),
(19, 'Suzuki', 'KARIMUN', 'Hatchback', 'GS 1.0', 'Manual', 2017, 31529, 88000000, 'Tangerang Selatan', 'Available'),
(20, 'Nissan', 'LIVINA', 'MPV', 'VE 1.5', 'Manual', 2019, 39968, 212000000, 'Jakarta Selatan', 'Available'),
(21, 'Toyota', 'RUSH', 'SUV', 'S TRD 1.5', 'Automatic', 2018, 32953, 222000000, 'Bekasi', 'Available'),
(22, 'Toyota', 'RUSH', 'SUV', 'G 1.5', 'Automatic', 2019, 56388, 207000000, 'Tangerang Selatan', 'Available'),
(23, 'Toyota', 'VOXY', 'MPV', 'VOXY 2.0', 'Automatic', 2018, 18996, 411000000, 'Jakarta Selatan', 'Available'),
(24, 'Daihatsu', 'XENIA', 'MPV', 'R STD 1.3', 'Automatic', 2019, 14651, 182000000, 'Bekasi', 'Available'),
(25, 'Honda', 'HR-V', 'SUV', 'SE 1.5', 'Automatic', 2019, 37048, 306000000, 'Tangerang Selatan', 'Available'),
(26, 'Suzuki', 'BALENO', 'Hatchback', 'HATCHBACK 1.5', 'Manual', 2018, 42405, 142000000, 'Tangerang Selatan', 'Available'),
(27, 'Toyota', 'CALYA ', 'MPV', 'E 1.2', 'Manual', 2017, 74904, 90000000, 'Jakarta Selatan', 'Available'),
(28, 'Mitsubishi', 'XPANDER', 'MPV', 'ULTIMATE 1.5', 'Automatic', 2018, 51636, 212000000, 'Bekasi', 'Available'),
(29, 'Mitsubishi', 'PAJERO SPORT', 'SUV', 'DAKAR 4X2 2.4', 'Automatic', 2019, 32424, 491000000, 'Tangerang Selatan', 'Available'),
(30, 'Mitsubishi', 'XPANDER', 'MPV', 'ULTIMATE 1.5', 'Automatic', 2019, 31984, 228500000, 'Jakarta Selatan', 'Available'),
(31, 'Suzuki', 'ERTIGA', 'MPV', 'GL 1.4', 'Manual', 2018, 16652, 146000000, 'Bekasi', 'Available'),
(32, 'Suzuki', 'IGNIS', 'Hatchback', 'GL MT 1.2', 'Manual', 2018, 24445, 119000000, 'Tangerang Selatan', 'Available'),
(33, 'Daihatsu', 'TERIOS', 'SUV', 'R 1.5', 'Automatic', 2018, 42846, 194000000, 'Bekasi', 'Available'),
(34, 'Suzuki', 'ERTIGA SPORT', 'MPV', 'GT 1.5', 'Manual', 2019, 19477, 195000000, 'Tangerang Selatan', 'Available'),
(35, 'Suzuki', 'ERTIGA SPORT', 'MPV', 'GT 1.5', 'Manual', 2019, 12458, 199000000, 'Jakarta Selatan', 'Available'),
(36, 'Toyota', 'YARIS', 'Hatchback', 'S LTD 1.5', 'Automatic', 2018, 38768, 204000000, 'Bekasi', 'Available'),
(37, 'Honda', 'CR-V', 'SUV', 'CR-V 2.0', 'Automatic', 2017, 59573, 322000000, 'Tangerang Selatan', 'Available'),
(38, 'Honda', 'BRIO SATYA', 'Hatchback', 'E 1.2', 'Automatic', 2017, 32450, 131000000, 'Jakarta Selatan', 'Available'),
(39, 'Honda', 'MOBILIO', 'MPV', 'RS 1.5', 'Automatic', 2017, 31478, 179500000, 'Bekasi', 'Available'),
(40, 'Honda', 'BR-V', 'SUV', 'E PRESTIGE 1.5', 'Automatic', 2018, 16441, 204000000, 'Tangerang Selatan', 'Available'),
(41, 'Mitsubishi', 'OUTLANDER SPORT', 'SUV', 'PX 2.0', 'Automatic', 2017, 642825, 231000000, 'Jakarta Selatan', 'Available'),
(42, 'Toyota', 'AGYA ', 'MPV', 'G TRD 1.2', 'Automatic', 2017, 56177, 111000000, 'Jakarta Selatan', 'Available'),
(43, 'Nissan', 'SERENA ', 'MPV', 'HIGHWAY STAR 2.0', 'Automatic', 2017, 76090, 218000000, 'Tangerang Selatan', 'Available'),
(44, 'Honda', 'MOBILIO', 'MPV', 'RS 1.5', 'Manual', 2017, 48773, 154500000, 'Bekasi', 'Available'),
(45, 'Honda', 'HR-V', 'SUV', 'E 1.5', 'Automatic', 2017, 60967, 218000000, 'Jakarta Selatan', 'Available'),
(46, 'Honda', 'BR-V', 'SUV', 'E PRESTIGE 1.5', 'Automatic', 2017, 49300, 187000000, 'Jakarta Selatan', 'Available'),
(47, 'Daihatsu', 'TERIOS', 'SUV', 'CUSTOM 1.5', 'Automatic', 2016, 82404, 157000000, 'Jakarta Selatan', 'Available'),
(48, 'Honda', 'BRIO', 'Hatchback', 'RS 1.2', 'Manual', 2016, 72242, 118000000, 'Bekasi', 'Available'),
(49, 'Daihatsu', 'XENIA', 'MPV', 'R SPORTY 1.3', 'Manual', 2015, 76769, 127000000, 'Tangerang Selatan', 'Available'),
(50, 'Toyota', 'RUSH', 'SUV', 'S TRD 1.5', 'Automatic', 2021, 14831, 252000000, 'Jakarta Selatan', 'Available'),
(51, 'Toyota', 'CALYA ', 'MPV', 'G 1.2', 'Manual', 2021, 11888, 138000000, 'Bekasi', 'Available'),
(52, 'Toyota', 'CALYA ', 'MPV', 'G 1.2', 'Manual', 2021, 5384, 133000000, 'Jakarta Selatan', 'Available'),
(53, 'Toyota', 'RUSH', 'SUV', 'G 1.5', 'Automatic', 2021, 7106, 235000000, 'Jakarta Selatan', 'Available'),
(54, 'Suzuki', 'XL7', 'MPV', 'ALPHA 1.5', 'Manual', 2021, 3135, 222000000, 'Tangerang Selatan', 'Available'),
(55, 'Toyota', 'FORTUNER', 'SUV', 'VRZ 4X2 2.4', 'Automatic', 2021, 3310, 545000000, 'Jakarta Selatan', 'Available'),
(56, 'Honda', 'HR-V', 'SUV', 'E 1.5', 'Automatic', 2020, 13535, 312000000, 'Jakarta Selatan', 'Available'),
(57, 'Toyota', 'YARIS', 'Hatchback', 'S TRD 1.5', 'Automatic', 2020, 16744, 239000000, 'Bekasi', 'Available'),
(58, 'Daihatsu', 'TERIOS', 'SUV', 'X DLX 1.5', 'Automatic', 2019, 47450, 193000000, 'Bekasi', 'Available'),
(59, 'Toyota', 'FORTUNER', 'SUV', 'VRZ 4X2 2.4', 'Automatic', 2020, 18050, 472000000, 'Bekasi', 'Available'),
(60, 'Honda', 'BR-V', 'SUV', 'E 1.5', 'Automatic', 2020, 10350, 237000000, 'Jakarta Selatan', 'Available'),
(61, 'Daihatsu', 'AYLA', 'MPV', 'R 1.2', 'Automatic', 2019, 31000, 120000000, 'Tangerang Selatan', 'Available'),
(62, 'Suzuki', 'IGNIS', 'Hatchback', 'GL 1.2', 'Automatic', 2019, 24900, 137000000, 'Jakarta Selatan', 'Available'),
(63, 'Toyota', 'YARIS', 'Hatchback', 'S TRD 1.5', 'Automatic', 2019, 30500, 238000000, 'Jakarta Selatan', 'Available'),
(64, 'Toyota', 'INNOVA', 'MPV', 'V DIESEL 2.5', 'Automatic', 2019, 43005, 369000000, 'Bekasi', 'Available'),
(65, 'Toyota', 'AVANZA', 'MPV', 'G 1.3', 'Manual', 2019, 19800, 176000000, 'Tangerang Selatan', 'Available'),
(66, 'Daihatsu', 'SIGRA ', 'MPV', 'R STD 1.2', 'Automatic', 2020, 2696, 138000000, 'Tangerang Selatan', 'Available'),
(67, 'Daihatsu', 'XENIA', 'MPV', 'X 1.3', 'Manual', 2020, 8290, 155000000, 'Jakarta Selatan', 'Available'),
(68, 'Mazda ', '2', 'MPV', 'SKYACTIV 1.5', 'Automatic', 2015, 81258, 158000000, 'Bekasi', 'Available'),
(69, 'Mitsubishi', 'XPANDER', 'SUV', 'CROSS PREMIUM 1.5', 'Automatic', 2020, 28650, 244000000, 'Bekasi', 'Available'),
(70, 'Mitsubishi', 'XPANDER', 'MPV', 'ULTIMATE 1.5', 'Automatic', 2018, 56019, 222000000, 'Bekasi', 'Available'),
(71, 'Mitsubishi', 'XPANDER', 'MPV', 'ULTIMATE 1.5', 'Automatic', 2018, 40999, 218000000, 'Jakarta Selatan', 'Available'),
(72, 'Mitsubishi', 'XPANDER', 'MPV', 'ULTIMATE 1.5', 'Automatic', 2018, 61945, 222000000, 'Jakarta Selatan', 'Available'),
(73, 'Mitsubishi', 'PAJERO SPORT', 'SUV', 'DAKAR 4X2 2.4', 'Automatic', 2019, 34534, 491000000, 'Tangerang Selatan', 'Available'),
(74, 'Mitsubishi', 'XPANDER', 'MPV', 'ULTIMATE 1.5', 'Automatic', 2018, 44312, 211000000, 'Tangerang Selatan', 'Available'),
(75, 'Mitsubishi', 'OUTLANDER', 'SUV', 'PX 2.0', 'Automatic', 2018, 45244, 270000000, 'Jakarta Selatan', 'Available'),
(76, 'Nissan', 'LIVINA', 'MPV', 'VE 1.5', 'Automatic', 2019, 36839, 215000000, 'Bekasi', 'Available'),
(77, 'Nissan', 'GRAND LIVINA', 'MPV', 'XV 1.5', 'Automatic', 2017, 67532, 140000000, 'Bekasi', 'Available'),
(78, 'Nissan', 'GRAND LIVINA', 'MPV', 'X-GEAR 1.8', 'Automatic', 2013, 59140, 108500000, 'Tangerang Selatan', 'Available'),
(79, 'Nissan', 'LIVINA', 'MPV', 'EL 1.5', 'Manual', 2019, 27892, 185000000, 'Jakarta Selatan', 'Available'),
(80, 'Nissan', 'X-TRAIL', 'SUV', '2.5', 'Automatic', 2016, 79123, 235000000, 'Bekasi', 'Available'),
(81, 'Nissan', 'GRAND LIVINA', 'MPV', 'VE 1.5', 'Automatic', 2019, 34235, 205000000, 'Tangerang Selatan', 'Available'),
(82, 'Nissan', 'MARCH', 'Hatchback', 'XS 1.2', 'Automatic', 2016, 68467, 114000000, 'Tangerang Selatan', 'Available'),
(83, 'Nissan', 'GRAND LIVINA', 'MPV', 'VL 1.5', 'Automatic', 2019, 33456, 219000000, 'Bekasi', 'Available'),
(84, 'Suzuki', 'BALENO', 'Hatchback', 'HATCHBACK 1.4', 'Automatic', 2020, 12234, 201000000, 'Jakarta Selatan', 'Available'),
(85, 'Suzuki', 'IGNIS', 'Hatchback', 'GX 1.2', 'Automatic', 2017, 34129, 127000000, 'Jakarta Selatan', 'Available'),
(86, 'Suzuki', 'KARIMUN', 'Hatchback', 'GS 1.0', 'Manual', 2015, 40041, 84000000, 'Tangerang Selatan', 'Available'),
(87, 'Suzuki', 'ERTIGA', 'MPV', 'GL 1.5', 'Manual', 2019, 32228, 167000000, 'Bekasi', 'Available'),
(88, 'Suzuki', 'ERTIGA', 'MPV', 'GL 1.5', 'Manual', 2020, 34411, 183000000, 'Jakarta Selatan', 'Available'),
(89, 'Wuling', 'ALMAZ', 'SUV', 'LT LUX 1.5', 'Automatic', 2019, 22375, 246000000, 'Jakarta Selatan', 'Available'),
(90, 'Honda', 'CIVIC', 'Sedan', 'TC E 1.5', 'Automatic', 2018, 6508, 392000000, 'Jakarta Selatan', 'Available'),
(91, 'Honda', 'CIVIC TURBO', 'Sedan', 'E 1.5', 'Automatic', 2018, 34567, 395000000, 'Bekasi', 'Available'),
(92, 'Honda', 'JAZZ', 'Hatchback', 'RS 1.5', 'Automatic', 2018, 45000, 242000000, 'Bekasi', 'Available'),
(93, 'Honda', 'JAZZ', 'Hatchback', 'RS 1.5', 'Automatic', 2016, 88567, 201000000, 'Jakarta Selatan', 'Available'),
(94, 'Honda', 'JAZZ', 'Hatchback', 'RS 1.5', 'Automatic', 2018, 34868, 242000000, 'Tangerang Selatan', 'Available'),
(95, 'Honda', 'JAZZ', 'Hatchback', 'RS 1.5', 'Automatic', 2018, 23112, 251000000, 'Bekasi', 'Available'),
(96, 'Honda', 'JAZZ', 'Hatchback', 'RS 1.5', 'Automatic', 2014, 56574, 185000000, 'Bekasi', 'Available'),
(97, 'Honda', 'JAZZ', 'Hatchback', 'RS 1.5', 'Automatic', 2018, 30013, 247000000, 'Tangerang Selatan', 'Available'),
(98, 'Honda', 'JAZZ', 'Hatchback', 'RS 1.5', 'Automatic', 2015, 92189, 192000000, 'Jakarta Selatan', 'Available'),
(99, 'Honda', 'JAZZ', 'Hatchback', 'RS 1.5', 'Automatic', 2017, 54000, 211000000, 'Bekasi', 'Available'),
(100, 'Daihatsu', 'SIRION', 'Hatchback', 'D FMC 1.3', 'Manual', 2016, 58078, 100000000, 'Tangerang Selatan', 'Available'),
(101, 'Toyota', 'YARIS', 'Hatchback', 'S TRD 1.5', 'Automatic', 2021, 3000, 211000000, 'Tangerang Selatan', 'Available'),
(102, 'Toyota', 'YARIS', 'Hatchback', 'S TRD 1.5', 'Automatic', 2021, 17080, 19800000, 'Tangerang Selatan', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `id_car` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_data`
--

CREATE TABLE `car_data` (
  `id_cardata` int(100) NOT NULL,
  `fuel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat` int(10) NOT NULL,
  `registration_date` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kilometer_driven` int(10) NOT NULL,
  `sparekey` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_book` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `car_data`
--

INSERT INTO `car_data` (`id_cardata`, `fuel`, `color`, `seat`, `registration_date`, `registration_type`, `kilometer_driven`, `sparekey`, `service_book`, `warranty`, `period`) VALUES
(1, 'Bensin', 'Merah', 7, 'Sep 2016', 'Perorangan', 75833, 'Tidak', 'Tidak', 'Tidak', 'Sep 2021'),
(2, 'Bensin', 'Putih', 7, 'Jan 2021', 'Perorangan', 14832, 'Ya', 'Ya', 'Jan 2024', 'Feb 2022'),
(3, 'Bensin', 'Merah', 5, 'Mei 2019', 'Perorangan', 28264, 'Ya', 'Ya', 'Apr 2022', 'Mei 2022'),
(4, 'Bensin', 'Abu-abu', 7, 'Mar 2021', 'Perorangan', 11888, 'Ya', 'Tidak', 'Tidak', 'Mar 2022'),
(5, 'Bensin', 'Putih', 7, 'Apr 2014', 'Perorangan', 83528, 'Tidak', 'Ya', 'Tidak', 'Apr 2022'),
(6, 'Bensin', 'Silver', 7, 'Mei 2021', 'Perorangan', 5384, 'Tidak', 'Tidak', 'Tidak', 'Mei 2022'),
(7, 'Bensin', 'Hitam', 7, 'Feb 2015', 'Perorangan', 41140, 'Ya', 'Ya', 'Tidak', 'Apr 2022'),
(8, 'Bensin', 'Hitam', 7, 'Jul 2021', 'Perorangan', 7106, 'Ya', 'Tidak', 'Tidak', 'Jul 2022'),
(9, 'Bensin', 'Hitam', 4, 'Des 2017', 'Perorangan', 46636, 'Tidak', 'Tidak', 'Tidak', 'Des 2021'),
(10, 'Bensin', 'Cokelat', 7, 'Mar 2021', 'Perorangan', 4152, 'Ya', 'Ya', 'Tidak', 'Mar 2022'),
(11, 'Bensin', 'Hitam', 7, 'Jul 2018', 'Perorangan', 58389, 'Ya', 'Ya', 'Tidak', 'Jul 2021'),
(12, 'Bensin', 'Hitam', 7, 'Apr 2021', 'Perorangan', 3310, 'Tidak', 'Ya', 'Mar 2024', 'Apr 2022'),
(13, 'Bensin', 'Abu-abu', 5, 'Mei 2018', 'Perorangan', 30854, 'Ya', 'Ya', 'Tidak', 'Jun 2022'),
(14, 'Bensin', 'Merah', 5, 'Jan 2021', 'Perorangan', 12432, 'Ya', 'Ya', 'Jan 2024', 'Feb 2022'),
(15, 'Bensin', 'Hitam', 7, 'Agt 2018', 'Perorangan', 37020, 'Ya', 'Ya', 'Tidak', 'Agt 2021'),
(16, 'Bensin', 'Putih', 4, 'Nov 2022', 'Perorangan', 14795, 'Ya', 'Ya', 'Des 2023', 'Des 2021'),
(17, 'Bensin', 'Abu-abu', 7, 'Feb 2020', 'Perorangan', 26412, 'Ya', 'Ya', 'Jan 2023', 'Feb 2021'),
(18, 'Bensin', 'Abu-abu', 5, 'Agt 2020', 'Perorangan', 20642, 'Tidak', 'Ya', 'Agt 2023', 'Agt 2021'),
(19, 'Bensin', 'Abu-abu', 5, 'Jan 2017', 'Perorangan', 31529, 'Ya', 'Ya', 'Tidak', 'Jun 2021'),
(20, 'Bensin', 'Hitam', 7, 'Mar 2020', 'Perorangan', 39968, 'Ya', 'Ya', 'Agt 2023', 'Mar 2022'),
(21, 'Bensin', 'Hitam', 7, 'Jan 2018', 'Perorangan', 32953, 'Ya', 'Ya', 'Tidak', 'Jan 2022'),
(22, 'Bensin', 'Silver', 7, 'Jul 2019', 'Perorangan', 56388, 'Ya', 'Ya', 'Mei 2022', 'Jun 2022'),
(23, 'Bensin', 'Hitam', 7, 'Feb 2019', 'Perorangan', 18996, 'Ya', 'Ya', 'Jan 2022', 'Feb 2022'),
(24, 'Bensin', 'Putih', 7, 'Mar 2019', 'Perorangan', 14651, 'Ya', 'Ya', 'Mar 2022', 'Mei 2021'),
(25, 'Bensin', 'Hitam', 5, 'Mei 2019', 'Perorangan', 37048, 'Ya', 'Ya', 'Mei 2022', 'Mei 2020'),
(26, 'Bensin', 'Biru', 5, 'Mei 2018', 'Perorangan', 42405, 'Tidak', 'Tidak', 'Tidak', 'Apr 2021'),
(27, 'Bensin', 'Abu-abu', 7, 'Feb 2017', 'Perorangan', 74904, 'Ya', 'Ya', 'Tidak', 'Feb 2021'),
(28, 'Bensin', 'Abu-abu', 7, 'Mar 2018', 'Perusahaan', 51636, 'Ya', 'Ya', 'Tidak', 'Mar 2020'),
(29, 'Bensin', 'Putih', 7, 'Des 2019', 'Perorangan', 34424, 'Tidak', 'Ya', 'Jul 2022', 'Apr 2022'),
(30, 'Bensin', 'Hitam', 7, 'Feb 2020', 'Perorangan', 31984, 'Ya', 'Ya', 'Jan 2023', 'Feb 2021'),
(31, 'Bensin', 'Abu-abu', 7, 'Mei 2018', 'Perorangan', 16652, 'Ya', 'Ya', 'Tidak', 'Mei 2022'),
(32, 'Bensin', 'Hitam', 5, 'Jul 2018', 'Perorangan', 24445, 'Ya', 'Tidak', 'Tidak', 'Jul 2019'),
(33, 'Bensin', 'Putih', 7, 'Nov 2018', 'Perorangan', 42846, 'Ya', 'Ya', 'Tidak', 'Nov 2020'),
(34, 'Bensin', 'Hitam', 7, 'Nov 2019', 'Perorangan', 19477, 'Tidak', 'Tidak', 'Tidak', 'Des 2021'),
(35, 'Bensin', 'Hitam', 7, 'Jan 2020', 'Perorangan', 12458, 'Ya', 'Ya', 'Jan 2022', 'Jan 2022'),
(36, 'Bensin', 'Silver', 5, 'Okt 2018', 'Perorangan', 38768, 'Ya', 'Ya', 'Tidak', 'Okt 2021'),
(37, 'Bensin', 'Merah', 5, 'Nov 2017', 'Perorangan', 59573, 'Ya', 'Ya', 'Tidak', 'Nov 2021'),
(38, 'Bensin', 'Biru', 5, 'Jan 2017', 'Perorangan', 32450, 'Ya', 'Ya', 'Tidak', 'Feb 2022'),
(39, 'Bensin', 'Orange', 7, 'Sep 2017', 'Perorangan', 31478, 'Tidak', 'Ya', 'Tidak', 'Sep 2022'),
(40, 'Bensin', 'Hitam', 7, 'Jul 2018', 'Perorangan', 16441, 'Ya', 'Ya', 'Tidak', 'Jul 2022'),
(41, 'Bensin', 'Orange', 5, 'Jun 2017', 'Perorangan', 64825, 'Ya', 'Tidak', 'Tidak', 'Jun 2021'),
(42, 'Bensin', 'Merah', 5, 'Sep 2017', 'Perorangan', 56617, 'Tidak', 'Ya', 'Tidak', 'Sep 2022'),
(43, 'Bensin', 'Merah', 7, 'Feb 2017', 'Perorangan', 76090, 'Tidak', 'Ya', 'Tidak', 'Feb 2022'),
(44, 'Bensin', 'Hitam', 7, 'Feb 2018', 'Perorangan', 48773, 'Tidak', 'Ya', 'Tidak', 'Mei 2022'),
(45, 'Bensin', 'Merah', 5, 'Feb 2018', 'Perorangan', 60957, 'Ya', 'Ya', 'Tidak', 'Feb 2019'),
(46, 'Bensin', 'Hitam', 7, 'Agt 2017', 'Perorangan', 49035, 'Ya ', 'Ya', 'Tidak', 'Jul 2021'),
(47, 'Bensin', 'Putih', 7, 'Mei 2016', 'Perorangan', 82164, 'Ya', 'Ya', 'Tidak', 'Jun 2022'),
(48, 'Bensin', 'Abu-abu', 5, 'Okt 2016', 'Perorangan', 72232, 'Tidak', 'Ya', 'Tidak', 'Okt 2021'),
(49, 'Bensin', 'Silver', 7, 'Sep 2015', 'Perorangan', 76769, 'Ya', 'Ya', 'Tidak', 'Okt 2021'),
(50, 'Bensin', 'Putih', 7, 'Jan 2021', 'Perorangan', 14832, 'Ya', 'Ya', 'Jan 2024', 'Feb 2022'),
(51, 'Bensin', 'Abu-abu', 7, 'Mar 2021', 'Perorangan', 11888, 'Ya', 'Tidak', 'Tidak', 'Mar 2022'),
(52, 'Bensin', 'Silver', 7, 'Mei 2021', 'Perorangan', 5384, 'Tidak', 'Tidak', 'Tidak', 'Mei 2022'),
(53, 'Bensin', 'Hitam', 7, 'Jul 2021', 'Perorangan', 7106, 'Ya', 'Tidak', 'Tidak', 'Jul 2022'),
(54, 'Bensin', 'Cokelat', 7, 'Mar 2021', 'Perorangan', 4152, 'Ya', 'Ya', 'Tidak', 'Mar 2022'),
(55, 'Bensin', 'Hitam', 7, 'Apr 2021', 'Perorangan', 3310, 'Tidak', 'Ya', 'Mar 2024', 'Apr 2022'),
(56, 'Bensin', 'Abu-abu', 5, 'Jul 2020', 'Perorangan', 13538, 'Ya', 'Ya', 'Jul 2023', 'Jul 2021'),
(57, 'Bensin', 'Putih', 5, 'Feb 2020', 'Perorangan', 16744, 'Ya', 'Ya', 'Feb 2023', 'Mar 2021'),
(58, 'Bensin', 'Putih', 7, 'Apr 2019', 'Perorangan', 47432, 'Ya', 'Ya', 'Apr 2022', 'Apr 2022'),
(59, 'Diesel', 'Silver', 7, 'Nov 2019', 'Perorangan', 18030, 'Ya', 'Ya', 'Nov 2023', 'Nov 2021'),
(60, 'Bensin', 'Hitam', 7, 'Des 2020', 'Perorangan', 10358, 'Ya', 'Ya', 'Nov 2023', 'Des 2021'),
(61, 'Bensin', 'Orange', 5, 'Jan 2019', 'Perorangan', 31006, 'Tidak', 'Ya', 'Tidak', 'Jan 2022'),
(62, 'Bensin', 'Abu-abu', 5, 'Feb 2020', 'Perorangan', 24900, 'Tidak', 'Ya', 'Tidak', 'Feb 2021'),
(63, 'Bensin', 'Lainnya', 5, 'Sep 2021', 'Perorangan', 30529, 'Tidak', 'Tidak', 'Tidak', 'Okt 2022'),
(64, 'Diesel', 'Hitam', 7, 'Jul 2019', 'Perorangan', 43036, 'Ya', 'Ya', 'Mei 2022', 'Mei 2022'),
(65, 'Bensin', 'Hitam', 7, 'Nov 2019', 'Perorangan', 19854, 'Ya', 'Ya', 'Nov 2022', 'Nov 2021'),
(66, 'Bensin', 'Putih', 7, 'Des 2020', 'Perorangan', 2696, 'Tidak', 'Tidak', 'Tidak', 'Des 2020'),
(67, 'Bensin', 'Abu-abu', 7, 'Feb 2020', 'Perorangan', 8290, 'Ya', 'Ya', 'Tidak', 'Mar 2021'),
(68, 'Bensin', 'Putih', 5, 'Okt 2015', 'Perorangan', 81258, 'Ya', 'Tidak', 'Tidak', 'Nov 2021'),
(69, 'Bensin', 'Abu-abu', 7, 'Apr 2020', 'Perorangan', 28639, 'Tidak', 'Ya', 'Tidak', 'Apr 2022'),
(70, 'Bensin', 'Silver', 7, 'Mar 2018', 'Perorangan', 56019, 'Ya', 'Ya', 'Tidak', 'Mar 2022'),
(71, 'Bensin', 'Abu-abu', 7, 'Jan 2018', 'Perorangan', 40999, 'Ya', 'Ya', 'Tidak', 'Jan 2022'),
(72, 'Bensin', 'Putih', 5, 'Sep 2018', 'Perorangan', 61945, 'Ya', 'Ya', 'Tidak', 'Agt 2021'),
(73, 'Bensin', 'Putih', 7, 'Des 2019', 'Perorangan', 34424, 'Tidak', 'Ya', 'Jul 2022', 'Apr 2022'),
(74, 'Bensin', 'Hitam', 7, 'Mar 2018', 'Perorangan', 44319, 'Tidak', 'Ya ', 'Tidak', 'Feb 2022'),
(75, 'Bensin', 'Putih', 5, 'Des 2018', 'Perorangan', 45244, 'Ya', 'Ya', 'Tidak', 'Des 2021'),
(76, 'Bensin', 'Hitam', 7, 'Mar 2020', 'Perorangan', 39968, 'Ya', 'Ya', 'Agt 2023', 'Mar 2022'),
(77, 'Bensin', 'Hitam', 7, 'Feb 2017', 'Perorangan', 67293, 'Tidak', 'Ya', 'Tidak', 'Feb 2022'),
(78, 'Bensin', 'Hitam', 7, 'Agt 2014', 'Perusahaan', 59146, 'Ya', 'Ya', 'Tidak', 'Agt 2021'),
(79, 'Bensin', 'Abu-abu', 5, 'Okt 2019', 'Perorangan', 27891, 'Ya', 'Ya', 'Okt 2022', 'Okt 2021'),
(80, 'Bensin', 'Putih', 7, 'Mei 2021', 'Perorangan', 79270, 'Ya', 'Ya', 'Tidak', 'Mei 2022'),
(81, 'Bensin', 'Orange', 7, 'Des 2019', 'Perorangan', 32167, 'Ya', 'Ya', 'Des 2022', 'Des 2021'),
(82, 'Bensin', 'Silver', 4, 'Nov 2016', 'Perorangan', 68879, 'Ya', 'Ya', 'Tidak', 'Nov 2021'),
(83, 'Bensin', 'Silver', 7, 'Jul 2019', 'Perorangan', 33484, 'Ya', 'Ya', 'Mei 2022', 'Jul 2021'),
(84, 'Bensin', 'Merah', 5, 'Jan 2021', 'Perorangan', 12432, 'Ya', 'Ya', 'Jan 2024', 'Feb 2022'),
(85, 'Bensin', 'Biru', 5, 'Sep 2017', 'Perorangan', 34371, 'Ya', 'Ya', 'Tidak', 'Okt 2021'),
(86, 'Bensin', 'Putih', 5, 'Feb 2016', 'Perorangan', 40041, 'Ya', 'Ya', 'Tidak', 'Feb 2022'),
(87, 'Bensin', 'Silver', 7, 'Jun 2020', 'Perorangan', 34228, 'Ya', 'Ya', 'Mar 2023', 'Feb 2022'),
(88, 'Bensin', 'Abu-abu', 7, 'Sep 2020', 'Perorangan', 34411, 'Ya', 'Ya', 'Sep 2023', 'Sep 2021'),
(89, 'Bensin', 'Merah', 5, 'Mar 2019', 'Perorangan', 22735, 'Ya', 'Ya', 'Mar 2022', 'Mar 2022'),
(90, 'Bensin', 'Merah', 4, 'Jun 2018', 'Perorangan', 6508, 'Ya', 'Ya', 'Tidak', 'Jun 2022'),
(91, 'Bensin', 'Hitam', 5, 'Sep 2018', 'Perorangan', 34736, 'Ya', 'Ya', 'Tidak', 'Agt 2021'),
(92, 'Bensin', 'Merah', 4, 'Mei 2018', 'Perorangan', 45004, 'Ya', 'Ya', 'Tidak', 'Mei 2022'),
(93, 'Bensin', 'Putih', 5, 'Mar 2016', 'Perorangan', 88527, 'Tidak', 'Ya', 'Tidak', 'Mar 2022'),
(94, 'Bensin', 'Orange', 5, 'Nov 2018', 'Perorangan', 34968, 'Ya', 'Ya', 'Tidak', 'Nov 2021'),
(95, 'Bensin', 'Abu-abu', 4, 'Apr 2018', 'Perorangan', 23122, 'Ya', 'Ya', 'Tidak', 'Apr 2022'),
(96, 'Bensin', 'Putih', 5, 'Agt 2014', 'Perorangan', 56754, 'Ya', 'Ya', 'Tidak', 'Sep 2021'),
(97, 'Bensin', 'Hitam', 4, 'Mar 2018', 'Perorangan', 30130, 'Ya', 'Ya', 'Tidak', 'Mar 2022'),
(98, 'Bensin', 'Putih', 5, 'Jan 2016', 'Perorangan', 92189, 'Ya', 'Ya', 'Tidak', 'Jan 2022'),
(99, 'Bensin', 'Merah', 4, 'Mar 2017', 'Perorangan', 54075, 'Ya', 'Ya', 'Tidak', 'Mar 2022'),
(100, 'Bensin', 'Biru', 5, 'Jul 2016', 'Perorangan', 58078, 'Ya', 'Ya', 'Tidak', 'Jul 2021'),
(101, 'Bensin', '5', 5, '2021-11-03', 'Perorangan', 3000, 'Ya', 'Ya', 'Ya', '2021-11-04'),
(102, 'Bensin', '5', 5, '2021-11-04', 'Perorangan', 3000, 'Ya', 'Ya', 'Ya', '2021-11-03');

-- --------------------------------------------------------

--
-- Table structure for table `inspection`
--

CREATE TABLE `inspection` (
  `id_inspection` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `car_brand` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_model` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_transmission` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_year` int(100) NOT NULL,
  `car_km` int(100) NOT NULL,
  `car_price` int(100) NOT NULL,
  `car_location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fuel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seat` int(100) NOT NULL,
  `registration_date` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kilometer_driven` int(100) NOT NULL,
  `sparekey` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_book` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_note` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id_order_item` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_car` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id_type` int(50) NOT NULL,
  `type_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id_type`, `type_name`) VALUES
(1, 'Sedan'),
(2, 'SUV'),
(3, 'MPV'),
(4, 'Hatchback'),
(5, 'Coupe'),
(6, 'Truck'),
(7, 'Wagon'),
(8, 'Convertible'),
(9, 'Van');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(100) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `address`, `phone`) VALUES
(1, 'anton_io', 'achristopher989@gmail.com', 'Z01YZXJuZU1nbmIwUGpWTURXVU16UT09', 'Tambak Bayan V/12', '08575512345');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id_wishlist` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `id_car` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id_wishlist`, `id_user`, `id_car`) VALUES
(12, 1, 1),
(13, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id_brand`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id_car`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`);

--
-- Indexes for table `car_data`
--
ALTER TABLE `car_data`
  ADD PRIMARY KEY (`id_cardata`);

--
-- Indexes for table `inspection`
--
ALTER TABLE `inspection`
  ADD PRIMARY KEY (`id_inspection`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id_order_item`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id_type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_wishlist`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id_brand` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id_car` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `car_data`
--
ALTER TABLE `car_data`
  MODIFY `id_cardata` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `inspection`
--
ALTER TABLE `inspection`
  MODIFY `id_inspection` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id_order_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id_type` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_wishlist` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
