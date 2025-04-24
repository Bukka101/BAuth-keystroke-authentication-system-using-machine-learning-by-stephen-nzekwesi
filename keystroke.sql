-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 18, 2025 at 01:19 PM
-- Server version: 10.11.11-MariaDB
-- PHP Version: 8.3.19

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
-- Table structure for table `auth_logs`
--

CREATE TABLE `auth_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `result_type` enum('TP','TN','FP','FN') NOT NULL,
  `model_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
('m062', 'TestModel', 'Paired Punch_20250328160223_export.csv', '2025-04-18', 'Random Forest', 'Documents', 'Inactive'),
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
('s002', 'simpsons', 'chichi', 'Password + ks'),
('s003', 'chan', 'shing', 'Password'),
('s004', 'Achalugu', 'achichi', 'Password'),
('s005', 'joan', 'jude', 'Password'),
('s007', 'jane', 'judas', 'Password'),
('s008', 'dane', 'kuda', 'Password + ks'),
('s010', 'max', '12321', 'Password'),
('s011', 'man', 'haram', 'Password + ks'),
('s012', 'ken007', 'kenister111', 'Password'),
('s013', 'jane', 'haram', 'Password + ks'),
('s015', 'kiss', 'miss', 'Password + ks'),
('s016', 'lane', 'padding', 'Password'),
('s017', 'jude', 'cars', 'Password + ks'),
('s018', 'cows', 'farm', 'Password'),
('s019', 'bother', 'buttock', 'Password'),
('s020', 'jack', 'shark', 'Password + ks'),
('s021', 'fame', 'dame', 'Password + ks'),
('s022', 'last', 'fight', 'Password'),
('s024', 'creed', 'loss', 'Password'),
('s025', 'boxer', 'shy', 'Password'),
('s026', 'jesse', 'fast', 'Password + ks'),
('s027', 'beast', 'mama', 'Password + ks'),
('s028', 'foden', 'feast', 'Password + ks'),
('s029', 'cenat', 'lying', 'Password'),
('s030', 'bose', 'kaddy', 'Password'),
('s031', 'klaus', 'reside', 'Password'),
('s032', 'cherish', 'winner', 'Password + ks'),
('s033', 'janet', 'fupa', 'Password'),
('s034', 'lanter', 'mode', 'Password'),
('s035', 'mister', 'jando', 'Password + ks'),
('s036', 'martins419', 'jojo', 'Password'),
('s037', 'momodu', 'kareem', 'Password'),
('s038', 'drone', 'foster', 'Password'),
('s040', 'gerald', 'kinder', 'Password'),
('s041', 'frank', 'mallam', 'Password'),
('s042', 'happy', 'dappy', 'Password + ks'),
('s043', 'jones', 'chicken', 'Password'),
('s044', 'bottle', 'crest', 'Password'),
('s046', 'hamster', 'free', 'Password + ks'),
('s047', 'cheese', 'lord', 'Password + ks'),
('s048', 'crate', 'mama', 'Password'),
('s049', 'foam', 'lamp', 'Password'),
('s050', 'florence', 'melt', 'Password + ks'),
('s051', 'palmer', 'diss', 'Password'),
('s052', 'kareem', 'farmer', 'Password + ks'),
('s053', 'gideon101', 'papa', 'Password'),
('s054', 'danny', 'jantor', 'Password'),
('s055', 'kastro01', 'flippy', 'Password + ks'),
('s056', 'tammy', 'abram', 'Password + ks'),
('s057', 'sammy', 'ramster', 'Password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_logs`
--
ALTER TABLE `auth_logs`
  ADD PRIMARY KEY (`id`);

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

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_logs`
--
ALTER TABLE `auth_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
