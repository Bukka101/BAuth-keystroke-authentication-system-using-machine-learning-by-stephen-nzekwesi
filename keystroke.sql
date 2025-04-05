-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 03, 2025 at 10:06 PM
-- Server version: 10.11.11-MariaDB
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xpressm2_keystroke`
--

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `model_id` varchar(13) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dataset_name` varchar(255) NOT NULL,
  `date_trained` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `status` text NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`model_id`, `name`, `dataset_name`, `date_trained`, `type`, `path`, `status`) VALUES
('m001', 'model0', 'industry.csv', '2025-03-28', 'Random Forest', 'Removed Apps.html', 'Inactive'),
('m048', 'model007', 'industry.csv', '2025-04-02', 'SVM', 'archive', 'Active'),
('m056', 'ModelTest', 'Staff Leave Requests.csv', '2025-04-02', 'Random Forest', 'AAP Inventory Final Figures.xlsx', 'Inactive'),
('m080', 'Model003', 'Paired Punch_20250328160223_export.csv', '2025-04-02', 'SVM', 'Paired Punch_20250213093537_export.xlsx', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(13) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_type` varchar(255) NOT NULL DEFAULT 'Password'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `auth_type`) VALUES
('S002', 'simpsons', '$2y$10$00eVtNOreUFnVKrxPFYStOtCM9t3XlqJW29hdp/UEKDmgbX2zgHJC', 'Password + ks'),
('s004', 'Achalugu', 'achichi', 'Password + ks');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD UNIQUE KEY `model_id` (`model_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_id` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
