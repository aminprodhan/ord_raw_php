-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2025 at 07:37 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `order_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `amount` int(10) NOT NULL,
  `buyer` varchar(255) NOT NULL,
  `receipt_id` varchar(20) NOT NULL,
  `items` varchar(255) NOT NULL,
  `buyer_email` varchar(50) NOT NULL,
  `buyer_ip` varchar(20) NOT NULL,
  `note` text NOT NULL,
  `city` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `hash_key` varchar(255) NOT NULL,
  `entry_at` date NOT NULL,
  `entry_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `amount`, `buyer`, `receipt_id`, `items`, `buyer_email`, `buyer_ip`, `note`, `city`, `phone`, `hash_key`, `entry_at`, `entry_by`) VALUES
(1, 4720, 'test', 'testr', 'test,test2', 'test@gmail.com', '127.0.0.1', 'test', 'test', '8801234567891', '083d95f021b8db8cacf09724cdcae2e1862c55878f86c445de0d47b6d235825d58829a941c30141bc36b090273d9b50a6e3026a2ee08fe13e7e9f795c3e07688', '2025-02-16', 33),
(2, 1089, 'amin', 'testr', 'test', 'test@gmail.com', '127.0.0.1', 'test', 'test', '8801234567892', '380d0eb037ac1b996a86d042d675652e272184c173695f3896666aa2e1704a6b23d8a4773b87ee244158ade6ce0d9918bd4ed9a8492a03e2dd9c6f6ce5bd0a92', '2025-02-16', 44),
(3, 344, 'amin', 'testr', 'test', 'test@gmail.com', '127.0.0.1', 'test', 'test', '8801234567890', '0b9779912ce2faa1b34140782576f48380a75278cdf92542e30afdcfc7f73e88c0a701f077acb36e7307ed353b15edc207db9b43ab62db4492fe5bd8a176278e', '2025-02-17', 33),
(4, 33, 'tee', 'testr', 'test', 'amin@gmail.com', '127.0.0.1', 'test', 'test', '8801234567893', '2fa94c97ff093432859e54a3e1bbe86d50f862e6933eb1dfcb599194643ac2d6395d05ef85ac020489fffd593687888d5d2bf9f84bffb44a847179c7f085c29a', '2025-02-17', 33),
(5, 1089, 'test', 'testr', 'test', 'test@gmail.com', '127.0.0.1', 'test', 'test', '8801234567891', '52390f94a8dd50d0b2c992ace81529f2903abbfa67e9a047d8368f15e68f222f1965866437223b284b33e16109d1c496bbc6204b37f2384da185f3037ce5b568', '2025-02-17', 32),
(6, 1089, 'amin', 'testr', 'test', 'test@gmail.com', '127.0.0.1', 'test', 'test', '8801234567891', '7dfbf0b516eebb15eff8b5e0e5eb65a1942be2fe116cc4fc455dbb5b5446a7b6ee55b91f9f4be30220dc0c3a97dbc36168be5e139a44bb2a36cba5a859935f19', '2025-02-17', 33),
(7, 1089, 'test', 'testr', 'test', 'test@gmail.com', '127.0.0.1', 'test', 'test', '8801234567893', '54bdb92fba9de86795fc6124e980480286a813c710f6c788556b58967aa0eec57ef8253d548fdb5f2fb17e801f4d2f7bbc9686b324d5657cdf04bb8651d967ad', '2025-02-17', 23),
(8, 1089, 'test', 'testr', 'test', 'test@gmail.com', '127.0.0.1', 'test', 'test', '8801234567893', '85625031e0d03604a76f22a3e4e6398b8afbea40af22a9c89d7c2b46da5096bd3fcbb6e4a29a794b82994ef2944c4df664cae6967611d103bc62a67b65c2f297', '2025-02-17', 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
