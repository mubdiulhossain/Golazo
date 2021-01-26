-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2019 at 03:17 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `golazo`
--

-- --------------------------------------------------------

--
-- Table structure for table `generaluser`
--

CREATE TABLE `generaluser` (
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `generaluser`
--

INSERT INTO `generaluser` (`userID`) VALUES
(1),
(4),
(17);

-- --------------------------------------------------------

--
-- Table structure for table `referee`
--

CREATE TABLE `referee` (
  `userID` int(11) NOT NULL,
  `refereeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `referee`
--

INSERT INTO `referee` (`userID`, `refereeID`) VALUES
(2, 1),
(4, 2),
(17, 3);

-- --------------------------------------------------------

--
-- Table structure for table `subtasks`
--

CREATE TABLE `subtasks` (
  `subtaskID` int(11) NOT NULL,
  `subtaskTitle` text NOT NULL,
  `subtaskDueDate` date NOT NULL,
  `taskID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subtasks`
--

INSERT INTO `subtasks` (`subtaskID`, `subtaskTitle`, `subtaskDueDate`, `taskID`) VALUES
(2, 'Assignment', '2019-02-20', 26),
(3, 'Quiz', '2019-02-21', 26),
(15, 'Lab Test', '2019-02-26', 26),
(16, 'midtest', '2019-02-24', 26),
(18, 'final', '2019-02-28', 26),
(19, 'final2', '2019-02-27', 26);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `taskID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `taskTitle` text NOT NULL,
  `taskParcentage` int(11) NOT NULL DEFAULT '0',
  `taskDueDate` date NOT NULL,
  `taskStatus` text NOT NULL,
  `taskSpentTime` int(11) NOT NULL DEFAULT '0',
  `refereeID` int(11) DEFAULT NULL,
  `reminders` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskID`, `userID`, `taskTitle`, `taskParcentage`, `taskDueDate`, `taskStatus`, `taskSpentTime`, `refereeID`, `reminders`) VALUES
(1, 1, 'Algorithm Design and Analysis', 60, '2019-01-15', 'active', 60, NULL, ''),
(2, 1, 'Object Oriented Analysis and Design', 80, '2019-02-17', 'active', 600, NULL, ''),
(3, 1, 'Test For Referee', 30, '2019-02-17', 'active', 0, 1, ''),
(22, 17, 'Algo', 0, '2019-01-15', 'active', 0, 2, 'haloooo'),
(28, 4, 'Web App Dev', 0, '2019-02-21', 'active', 0, 3, 'Enter new reminders');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `email`, `firstName`, `lastName`, `password`) VALUES
(1, 'mubdiulhossain.rakin@gmail.com', 'Mubdiul', 'Hossain', '12345'),
(2, 'mubdiulhossain@gmail.com', 'Referee', 'Test', '12345'),
(4, 'syafiqzahri321@gmail.com', 'Syafiq', 'Zahri', '321'),
(17, 'fahmibakar98@gmail.com', 'Fahmi ', 'Bakar', '98');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `generaluser`
--
ALTER TABLE `generaluser`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `referee`
--
ALTER TABLE `referee`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `refereeID` (`refereeID`);

--
-- Indexes for table `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`subtaskID`),
  ADD KEY `taskID` (`taskID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `refereeID` (`refereeID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_3` (`email`),
  ADD KEY `email_2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `referee`
--
ALTER TABLE `referee`
  MODIFY `refereeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `subtaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `generaluser`
--
ALTER TABLE `generaluser`
  ADD CONSTRAINT `fk_userID` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `referee`
--
ALTER TABLE `referee`
  ADD CONSTRAINT `referee_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `refereeID` FOREIGN KEY (`refereeID`) REFERENCES `referee` (`refereeID`),
  ADD CONSTRAINT `taskRefereeID` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `generaluser` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
