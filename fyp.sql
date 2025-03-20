-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2024 at 03:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`) VALUES
(2, 'admin', 'admin123', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `log_events`
--

CREATE TABLE `log_events` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `event` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_events`
--

INSERT INTO `log_events` (`id`, `timestamp`, `event`) VALUES
(1, '2024-03-21 18:33:36', 'Successful login for username: AM2007006932'),
(2, '2024-03-21 18:41:09', 'Login from: AM2007006932'),
(3, '2024-03-21 18:41:09', 'User AM2007006932 accessed a sensitive resource'),
(4, '2024-03-21 18:43:08', 'Failed login attempt for non-existing username: AM2007006931'),
(5, '2024-03-21 18:54:05', 'Failed login attempt for non-existing username: AM2007006931'),
(6, '2024-03-21 19:05:17', 'Failed login attempt for admin admin: Incorrect password'),
(7, '2024-03-21 19:06:33', 'Failed login attempt for admin admin: Incorrect password'),
(8, '2024-03-22 05:33:11', 'Failed login attempt for non-existing username: AM2304013280'),
(9, '2024-03-22 05:33:45', 'Login from: AM2007006932'),
(10, '2024-03-22 05:33:45', 'User AM2007006932 accessed a sensitive resource'),
(11, '2024-03-22 06:47:38', 'Failed login attempt for username: AM2007006932'),
(12, '2024-03-22 06:48:29', 'Login from: AM2007006932'),
(13, '2024-03-22 06:48:29', 'User AM2007006932 accessed a sensitive resource'),
(14, '2024-03-22 06:59:35', 'Login from: AM2007006932'),
(15, '2024-03-22 06:59:35', 'User AM2007006932 accessed a sensitive resource'),
(16, '2024-03-22 07:04:41', 'Login from: AM2007006932'),
(17, '2024-03-22 07:04:41', 'User AM2007006932 accessed a sensitive resource'),
(18, '2024-03-22 07:10:55', 'Login from: AM2007006932'),
(19, '2024-03-22 07:10:55', 'User AM2007006932 accessed a sensitive resource'),
(20, '2024-03-22 13:07:55', 'Login from: AM2007006932'),
(21, '2024-03-22 13:07:55', 'User AM2007006932 accessed a sensitive resource'),
(22, '2024-03-22 13:51:52', 'Login from: AM2007006932'),
(23, '2024-03-22 13:51:52', 'User AM2007006932 accessed a sensitive resource'),
(24, '2024-03-22 13:53:58', 'Login from: AM2007006932'),
(25, '2024-03-22 13:53:58', 'User AM2007006932 accessed a sensitive resource');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`) VALUES
(46, 'AM2007006930', '$2y$10$2QMzisuwcfyaxCzJHLV6K.CNWtZmCJyzENt7BOMg.ybSW1Q83xfDW', 'amirah'),
(47, 'AM2007006932', '$2y$10$SfCMTHts.nFmZZ9yUTIV9.mvtPqD/cCwEBwFhE6gb4MTwm89RATqW', 'mira hanis');

-- --------------------------------------------------------

--
-- Table structure for table `userform`
--

CREATE TABLE `userform` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `tarikhmula` date NOT NULL,
  `tarikhtamat` date NOT NULL,
  `ic` int(14) NOT NULL,
  `ndp` int(8) NOT NULL,
  `bengkel` varchar(100) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `sebab` text NOT NULL,
  `filename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userform`
--

INSERT INTO `userform` (`id`, `name`, `tarikhmula`, `tarikhtamat`, `ic`, `ndp`, `bengkel`, `semester`, `sebab`, `filename`) VALUES
(39, 'AMIRAH NUR HANIS BIN', '2024-03-14', '2024-03-22', 2147483647, 0, 'Diploma in Computer Science', 'Semester 2', 'Period Pain', 'photo_2024-03-20_21-24-25.jpg'),
(41, 'AMIRAH NUR HANIS BIN', '2024-03-18', '2024-03-19', 2147483647, 0, 'BACHELOR OF INFORMATION TECHNOLOGY (HONOURS) IN CYBER SECURITY', 'Semester 5', 'Fever', 'photo_2024-03-20_21-24-25.jpg'),
(42, 'AMIRAH ARISSA ', '2024-03-06', '2024-03-09', 2147483647, 0, 'BACHELOR OF INFORMATION TECHNOLOGY (HONOURS) IN CYBER SECURITY', 'Semester 6', '&lt;headache&lt;', 'photo_2024-03-20_21-24-25.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_events`
--
ALTER TABLE `log_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userform`
--
ALTER TABLE `userform`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log_events`
--
ALTER TABLE `log_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `userform`
--
ALTER TABLE `userform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
