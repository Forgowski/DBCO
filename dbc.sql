-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2023 at 07:47 PM
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
-- Database: `dbc`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `is_admin` (`id` INT) RETURNS INT(11)  BEGIN
DECLARE admin INT;
SELECT user.isAdmin INTO admin from user WHERE user.id=id;
IF admin is null then
RETURN 0;
ELSE
RETURN admin;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `try_log_in` (`email` VARCHAR(40), `password` VARCHAR(256)) RETURNS INT(11)  BEGIN
DECLARE user_id INT;

SELECT user.id INTO user_id from user WHERE user.email=email AND user.password=password;

if user_id is null then
RETURN -1;
ELSE
RETURN user_id;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `text_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `text_content`) VALUES
(18, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt cursus auctor. Maecenas nunc ligula, facilisis facilisis nunc quis, elementum sollicitudin diam. Donec pharetra quis erat nec volutpat. Maecenas odio sem, vehicula id dolor a, finibus tempor ante. Nullam leo nisi, tempor eu mattis ac, scelerisque sed enim. Sed dapibus congue dui, eu luctus dui maximus et. Aenean hendrerit lectus vitae orci finibus volutpat. Phasellus eleifend arcu ut ligula pretium bibendum ac eu risus. Etiam enim lacus, luctus nec cursus eget, laoreet ullamcorper augue. Donec tincidunt quam lacus, ac egestas nibh venenatis at. Nam nisl orci, elementum id dictum id, placerat ut tortor. Suspendisse sed interdum magna. Aliquam vel pulvinar felis. Fusce bibendum quis ligula at malesuada. '),
(19, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt cursus auctor. Maecenas nunc ligula, facilisis facilisis nunc quis, elementum sollicitudin diam. Donec pharetra quis erat nec volutpat. Maecenas odio sem, vehicula id dolor a, finibus tempor ante. Nullam leo nisi, tempor eu mattis ac, scelerisque sed enim. Sed dapibus congue dui, eu luctus dui maximus et. Aenean hendrerit lectus vitae orci finibus volutpat. Phasellus eleifend arcu ut ligula pretium bibendum ac eu risus. Etiam enim lacus, luctus nec cursus eget, laoreet ullamcorper augue. Donec tincidunt quam lacus, ac egestas nibh venenatis at. Nam nisl orci, elementum id dictum id, placerat ut tortor. Suspendisse sed interdum magna. Aliquam vel pulvinar felis. Fusce bibendum quis ligula at malesuada.         ');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `order_num` int(11) NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `ext_resource_id` int(11) NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `course_id`, `order_num`, `type`, `ext_resource_id`, `title`) VALUES
(18, 6, 0, 'article', 18, 'Pierwszy artykół'),
(19, 6, 1, 'article', 19, 'Drugi artykół');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `author` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `price` double NOT NULL,
  `category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `aprox_lenght_min` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `vote_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `author`, `description`, `price`, `category`, `aprox_lenght_min`, `rate`, `vote_num`) VALUES
(6, 'Testowy', 'Adam Kowalski', 'Cieżka zmiana opisu', 39.99, 'Informatyka', 30, 0, 0),
(7, 'Testowy2', 'admin admin', 'Test numer 2', 30, 'Księgowość', 40, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_t`
--

CREATE TABLE `order_t` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `quizId` int(11) NOT NULL,
  `question` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `answerA` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `answerB` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `answerC` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `answerD` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `correctAnswer` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `point` int(11) NOT NULL,
  `order_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `max_point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `max_point`) VALUES
(5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `lastName` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`, `isAdmin`) VALUES
(1, 'test', 'test', 'test', 'test', 0),
(2, 'Ada', 'Godzic', 'ada.godzic@gmail.com', 'haslo123', 0),
(3, 'Marcin', 'Bober', 'marcin.bober@gmail.com', 'haslo123', 0),
(4, 'Marcin', 'Bober', 'marcin.bober2@gmail.com', 'haslo123', 0),
(5, 'Test', 'Subject', 'test@subject.com', 'a7cabaeccd03442ed10c98e1edac2899', 0),
(6, 'admin', 'admin', 'admin@a.com', '23cfd86b0632e42222b4ac7aac81f166', 1),
(7, 'User', 'User', 'user@u.com', '3f3def178746a7e49ebc345d2e8a07b0', 0),
(8, 'usermd', 'usermd', 'user33@u.com', '3f3def178746a7e49ebc345d2e8a07b0', 0),
(9, 'Adam', 'Adam', 'adam@w.com', '3f3def178746a7e49ebc345d2e8a07b0', 0),
(10, 'Eryk', 'Eryk', 'eryk@e.com', '3f3def178746a7e49ebc345d2e8a07b0', 0),
(11, 'dom', 'dom', 'dom@d.com', '3f3def178746a7e49ebc345d2e8a07b0', 0),
(12, 'Pat', 'Pat', 'pat@p.com', '3f3def178746a7e49ebc345d2e8a07b0', 0),
(13, 'mat', 'mat', 'mat@m.com', '3f3def178746a7e49ebc345d2e8a07b0', 0),
(14, 'Adam', 'Kowalski', 'map@com.com', '3f3def178746a7e49ebc345d2e8a07b0', 0),
(15, 'Adam', 'Smoczek', 'ama@com.com', '3f3def178746a7e49ebc345d2e8a07b0', 0),
(16, 'admin', 'admin', 'admin@admin.com', '3f3def178746a7e49ebc345d2e8a07b0', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_t`
--
ALTER TABLE `order_t`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_t`
--
ALTER TABLE `order_t`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
