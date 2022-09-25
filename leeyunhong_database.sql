-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2022 at 11:53 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leeyunhong_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` varchar(10) NOT NULL,
  `departmentName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `departmentName`) VALUES
('DEPT001', 'Accounting'),
('DEPT002', 'Sales'),
('DEPT003', 'HR'),
('DEPT004', 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employeeID` varchar(10) NOT NULL,
  `departmentID` varchar(10) NOT NULL,
  `fullName` varchar(30) NOT NULL,
  `icNo` varchar(12) NOT NULL,
  `contactNo` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `address` varchar(60) NOT NULL,
  `position` varchar(20) NOT NULL,
  `joinDate` date NOT NULL,
  `bankAccount` int(20) NOT NULL,
  `password` longtext NOT NULL,
  `activeStatus` tinyint(1) NOT NULL,
  `profilePhoto` mediumblob NOT NULL,
  `managerID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeID`, `departmentID`, `fullName`, `icNo`, `contactNo`, `email`, `address`, `position`, `joinDate`, `bankAccount`, `password`, `activeStatus`, `profilePhoto`, `managerID`) VALUES
('EMP002', 'DEPT002', 'John', '78945612300', '0118599663', 'bryson_tai96@hotmail.com', 'No 32, Lorong Setapak 1233333', 'Manager', '2022-04-15', 789456123, '$2y$10$P0M2SAb99lM6wNiLXlhbMO0uleGx0AtoSTYfiKmW22n.ynZmPn5Ha', 1, 0x2e2e2f75706c6f6164732f454d503030325f313634393931303935302e6a706567, 'None'),
('EMP003', 'DEPT003', 'Poi Han', '123456', '3234', 'behph-am19@student.tarc.edu.my', 'No 15, jalan ABC, Kuala Lumpur', 'Admin', '2022-04-13', 789456, '$2y$10$P0M2SAb99lM6wNiLXlhbMO0uleGx0AtoSTYfiKmW22n.ynZmPn5Ha', 1, 0x2e2e2f75706c6f6164732f454d503030335f313634393836303434342e6a706567, 'None'),
('EMP004', 'DEPT001', 'Janus', '963852', '3234', 'brysontai10@gmail.com', 'No.15 Lorong YOO, KL ', 'Admin', '2022-04-14', 12345789, '$2y$10$P0M2SAb99lM6wNiLXlhbMO0uleGx0AtoSTYfiKmW22n.ynZmPn5Ha', 1, 0x2e2e2f75706c6f6164732f454d503030345f313634393836333039392e6a706567, 'None'),
('EMP005', 'DEPT004', 'Ying Yi', '78945612', '0163599885', 'dragonkw68@gmail.com', 'Unit 15 Apartment Block A', 'Manager', '2022-04-14', 12345789, '$2y$10$P0M2SAb99lM6wNiLXlhbMO0uleGx0AtoSTYfiKmW22n.ynZmPn5Ha', 1, 0x2e2e2f75706c6f6164732f454d503030355f313634393836333136342e6a706567, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplication`
--

CREATE TABLE `leaveapplication` (
  `leaveAppID` varchar(10) NOT NULL,
  `employeeID` varchar(10) NOT NULL,
  `applyDate` date NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `leaveReason` varchar(350) NOT NULL,
  `supportDocument` mediumblob NOT NULL,
  `applicationStatus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `traineelist`
--

CREATE TABLE `traineelist` (
  `id` int(11) NOT NULL,
  `trainingID` varchar(10) NOT NULL,
  `employeeID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trainingclass`
--

CREATE TABLE `trainingclass` (
  `trainingID` varchar(10) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` varchar(150) NOT NULL,
  `trainer` varchar(40) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `venue` varchar(30) NOT NULL,
  `departmentID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wages`
--

CREATE TABLE `wages` (
  `wagesID` varchar(10) NOT NULL,
  `employeeID` varchar(10) NOT NULL,
  `basicWagesPerHour` float NOT NULL,
  `annualBonus` float NOT NULL,
  `allowance` float NOT NULL,
  `epfAmount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wages`
--

INSERT INTO `wages` (`wagesID`, `employeeID`, `basicWagesPerHour`, `annualBonus`, `allowance`, `epfAmount`) VALUES
('WAG002', 'EMP002', 26.0417, 0, 400, 600),
('WAG003', 'EMP003', 26.0417, 0, 400, 600),
('WAG004', 'EMP004', 31.25, 200, 400, 720),
('WAG005', 'EMP005', 26.0417, 800, 400, 600);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeID`),
  ADD KEY `employee_ibfk_1` (`departmentID`);

--
-- Indexes for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD PRIMARY KEY (`leaveAppID`),
  ADD KEY `employeeID` (`employeeID`);

--
-- Indexes for table `traineelist`
--
ALTER TABLE `traineelist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeID` (`employeeID`),
  ADD KEY `trainingID` (`trainingID`);

--
-- Indexes for table `trainingclass`
--
ALTER TABLE `trainingclass`
  ADD PRIMARY KEY (`trainingID`),
  ADD KEY `departmentID` (`departmentID`);

--
-- Indexes for table `wages`
--
ALTER TABLE `wages`
  ADD PRIMARY KEY (`wagesID`),
  ADD KEY `employeeID` (`employeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `traineelist`
--
ALTER TABLE `traineelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`);

--
-- Constraints for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD CONSTRAINT `leaveapplication_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`);

--
-- Constraints for table `traineelist`
--
ALTER TABLE `traineelist`
  ADD CONSTRAINT `traineelist_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`),
  ADD CONSTRAINT `traineelist_ibfk_2` FOREIGN KEY (`trainingID`) REFERENCES `trainingclass` (`trainingID`);

--
-- Constraints for table `trainingclass`
--
ALTER TABLE `trainingclass`
  ADD CONSTRAINT `trainingclass_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`);

--
-- Constraints for table `wages`
--
ALTER TABLE `wages`
  ADD CONSTRAINT `wages_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
