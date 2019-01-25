-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2019 at 01:41 AM
-- Server version: 5.7.22
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `id_qst` int(11) NOT NULL,
  `body` varchar(1024) NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attempt`
--

CREATE TABLE `attempt` (
  `id` int(11) NOT NULL,
  `user_login` varchar(64) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `start_time` int(11) DEFAULT NULL,
  `finish_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `qcm`
--

CREATE TABLE `qcm` (
  `id` int(11) NOT NULL,
  `author_login` varchar(64) NOT NULL,
  `start_time` date NOT NULL,
  `duration_seconds` int(11) DEFAULT NULL,
  `is_corrected` tinyint(1) DEFAULT NULL,
  `title` varchar(256) NOT NULL,
  `max_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `qcm`
--

INSERT INTO `qcm` (`id`, `author_login`, `start_time`, `duration_seconds`, `is_corrected`, `title`, `max_score`) VALUES
(4, 'test', '2019-01-19', 3600, 0, 'Vieta Jumping', 10);

-- --------------------------------------------------------

--
-- Table structure for table `qst`
--

CREATE TABLE `qst` (
  `id` int(11) NOT NULL,
  `id_qcm` int(11) NOT NULL,
  `body` varchar(1024) NOT NULL,
  `max_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `login` varchar(64) NOT NULL,
  `pwd` varchar(40) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(128) NOT NULL,
  `signature` varchar(256) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `school` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `grade` varchar(256) DEFAULT NULL,
  `role` varchar(256) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`login`, `pwd`, `surname`, `name`, `birthday`, `email`, `signature`, `city`, `school`, `address`, `grade`, `role`) VALUES
('ayoub', '132b19de24d66d2ab7d33b39bcf84bb222b9618e', 'Foussoul', 'Ayoub', '1997-03-02', 'ayoubfoussoul@gmail.com', NULL, NULL, NULL, NULL, NULL, 'admin'),
('example', '56ce215889eda6e7409cea0406c849e85742ed54', 'example', 'example', '2011-01-01', 'example@exmaple', NULL, NULL, NULL, NULL, NULL, 'admin'),
('test', '2aebbebe071f7013a59a6d2beda337a5514a2a69', 'test', 'test', '2005-01-01', 'test@test', NULL, NULL, NULL, NULL, NULL, 'admin'),
('test2', '14b6d99a50e875a6798b1aec06c4574c9bcfd233', 'test2', 'test2', '2014-01-01', 'test2@test', NULL, NULL, NULL, NULL, NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_qst` (`id_qst`);

--
-- Indexes for table `attempt`
--
ALTER TABLE `attempt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_id` (`answer_id`),
  ADD KEY `user_login` (`user_login`);

--
-- Indexes for table `qcm`
--
ALTER TABLE `qcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_login` (`author_login`);

--
-- Indexes for table `qst`
--
ALTER TABLE `qst`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_qcm` (`id_qcm`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attempt`
--
ALTER TABLE `attempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qcm`
--
ALTER TABLE `qcm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `qst`
--
ALTER TABLE `qst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`id_qst`) REFERENCES `qst` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attempt`
--
ALTER TABLE `attempt`
  ADD CONSTRAINT `attempt_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attempt_ibfk_3` FOREIGN KEY (`user_login`) REFERENCES `users` (`login`) ON DELETE CASCADE;

--
-- Constraints for table `qcm`
--
ALTER TABLE `qcm`
  ADD CONSTRAINT `qcm_ibfk_1` FOREIGN KEY (`author_login`) REFERENCES `users` (`login`) ON DELETE CASCADE;

--
-- Constraints for table `qst`
--
ALTER TABLE `qst`
  ADD CONSTRAINT `qst_ibfk_1` FOREIGN KEY (`id_qcm`) REFERENCES `qcm` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
