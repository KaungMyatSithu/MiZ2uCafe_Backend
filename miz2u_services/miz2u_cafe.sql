-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2025 at 05:53 AM
-- Server version: 8.0.41
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miz2u_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `name`, `price`, `description`, `image`) VALUES
('P-0002', 'Signature Mis2u Latte', 9.55, 'Latte more and coffee less. Signature cafe is supported.', '67eb5c8849236_mizuss coffee.jpg'),
('P-0003', 'Iced Passion Tea', 6.30, 'Passion fruit and tea mixed. Sour and Soda.', 'pission_tea.jpg'),
('P-0004', 'Black Coffee', 4.65, 'Only Coffee without adding sugar.', 'black_cafe.jpg'),
('P-0005', 'Ice Latte', 12.30, 'little coffee and more milk forma.', 'latte_ice.jpeg'),
('P-0006', 'Green Milk Tea', 9.50, 'Green Tea mixing milk not too sweet.', 'green_milk_tea.avif'),
('P-0007', 'Grape Soda', 9.45, 'Grape juice and soda', 'grape_soda.jpg'),
('P-0008', 'Iced Matcha Late', 16.45, 'Laxuary Matcha with Tea. More Milk Forma.', '67e6497eddf02_ice_matcha.jpg'),
('P-0009', 'Peach Tea', 11.25, 'Peach Juice mixed with Tea. Formal sweet. Can get not sugar.', '67f76d8fc8953_peach_soda.webp');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
