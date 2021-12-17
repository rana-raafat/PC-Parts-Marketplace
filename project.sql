-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2021 at 05:37 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(10) UNSIGNED NOT NULL,
  `penalties` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `penalties`) VALUES
(3, 0),
(4, 2),
(5, 1),
(6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

CREATE TABLE `cartitem` (
  `customerID` int(10) UNSIGNED NOT NULL,
  `productID` int(10) UNSIGNED NOT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hrpartner`
--

CREATE TABLE `hrpartner` (
  `id` int(10) UNSIGNED NOT NULL,
  `penaltiesGiven` int(11) DEFAULT NULL,
  `investigationsMade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hrpartner`
--

INSERT INTO `hrpartner` (`id`, `penaltiesGiven`, `investigationsMade`) VALUES
(1, 6, 16),
(2, 8, 12);

-- --------------------------------------------------------

--
-- Table structure for table `investigationrequest`
--

CREATE TABLE `investigationrequest` (
  `id` int(10) UNSIGNED NOT NULL,
  `auditorID` int(10) UNSIGNED NOT NULL,
  `hrID` int(10) UNSIGNED NOT NULL,
  `adminID` int(10) UNSIGNED NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(10) UNSIGNED NOT NULL,
  `senderID` int(10) UNSIGNED NOT NULL,
  `recepientID` int(10) UNSIGNED NOT NULL,
  `messageText` varchar(255) DEFAULT NULL,
  `readStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penalty`
--

CREATE TABLE `penalty` (
  `id` int(10) UNSIGNED NOT NULL,
  `adminID` int(10) UNSIGNED NOT NULL,
  `hrID` int(10) UNSIGNED NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penalty`
--

INSERT INTO `penalty` (`id`, `adminID`, `hrID`, `reason`) VALUES
(1, 4, 1, 'Inappropriate langauge'),
(2, 5, 1, 'Unprofessional mannerisms'),
(3, 4, 2, 'Rude to customers');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` float(10,2) NOT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `1star` int(11) DEFAULT NULL,
  `2stars` int(11) DEFAULT NULL,
  `3stars` int(11) DEFAULT NULL,
  `4stars` int(11) DEFAULT NULL,
  `5stars` int(11) DEFAULT NULL,
  `numberOfReviews` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `productsuggestion`
--

CREATE TABLE `productsuggestion` (
  `id` int(10) UNSIGNED NOT NULL,
  `customerID` int(10) UNSIGNED NOT NULL,
  `hrID` int(10) UNSIGNED NOT NULL,
  `adminID` int(10) UNSIGNED NOT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `productLink` varchar(255) DEFAULT NULL,
  `productname` varchar(255) DEFAULT NULL,
  `productDescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(10) UNSIGNED NOT NULL,
  `productID` int(10) UNSIGNED NOT NULL,
  `customerID` int(10) UNSIGNED NOT NULL,
  `reviewText` varchar(255) DEFAULT NULL,
  `starRating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `id` int(10) UNSIGNED NOT NULL,
  `customerID` int(10) UNSIGNED NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `improvement` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `userType` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `address`, `imagePath`, `userType`) VALUES
(1, 'Sarah', 'sarahpass', 'sarah@mail.com', 'Nasr City', 'ProfilePictures/hr1.jpg', 'hrpartner'),
(2, 'Hady', 'hadypass', 'hady@mail.com', 'Maadi', 'ProfilePictures/hr2.jpg', 'hrpartner'),
(3, 'Dina', 'dinapass', 'dina@mail.com', 'Obour', 'ProfilePictures/admin1.jpg', 'administrator'),
(4, 'John', 'johnpass', 'john@mail.com', 'Nasr City', 'ProfilePictures/admin2.jpg', 'administrator'),
(5, 'Mona', 'monapass', 'mona@mail.com', '6th of October', 'ProfilePictures/admin3.png', 'administrator'),
(6, 'Mohamed', 'mohamedpass', 'mohamed@mail.com', 'Obour', 'ProfilePictures/admin4.png', 'administrator'),
(7, 'Arsany', 'arsanypass', 'arsany@mail.com', 'Obour', 'ProfilePictures/auditor1.jpg', 'auditor'),
(8, 'Mazen', 'mazenpass', 'mazen@mail.com', 'Nasr City', 'ProfilePictures/auditor2.jpg', 'auditor'),
(9, 'Ayman', 'aymanpass', 'ayman@mail.com', 'Maadi', 'ProfilePictures/customer1.png', 'customer'),
(10, 'Mostafa', 'mostafapass', 'mostafa@mail.com', 'Nasr City', 'ProfilePictures/customer2.png', 'customer'),
(11, 'Laila', 'lailapass', 'laila@mail.com', 'Nasr City', 'ProfilePictures/customer3.png', 'customer'),
(12, 'Farida', 'faridapass', 'farida@mail.com', 'Obour', 'ProfilePictures/customer4.png', 'customer'),
(13, 'Rahma', 'rahmapass', 'rahma@mail.com', '6th of October', 'ProfilePictures/customer5.png', 'customer'),
(14, 'Sayed', 'sayedpass', 'sayed@mail.com', 'Obour', 'ProfilePictures/customer6.png', 'customer'),
(15, 'Helmy', 'helmypass', 'helmy@mail.com', 'Maadi', 'ProfilePictures/customer7.png', 'customer'),
(16, 'Reem', 'reempass', 'reem@mail.com', 'Nasr City', 'ProfilePictures/customer8.png', 'customer'),
(17, 'Wael', 'waelpass', 'wael@mail.com', 'Obour', 'ProfilePictures/customer9.png', 'customer'),
(18, 'Khaled', 'khaledpass', 'khaled@mail.com', 'Maadi', 'ProfilePictures/customer10.png', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`productID`,`customerID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `hrpartner`
--
ALTER TABLE `hrpartner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investigationrequest`
--
ALTER TABLE `investigationrequest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auditorID` (`auditorID`),
  ADD KEY `hrID` (`hrID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `senderID` (`senderID`),
  ADD KEY `recepientID` (`recepientID`);

--
-- Indexes for table `penalty`
--
ALTER TABLE `penalty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `hrID` (`hrID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productsuggestion`
--
ALTER TABLE `productsuggestion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productID` (`productID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`,`customerID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `investigationrequest`
--
ALTER TABLE `investigationrequest`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penalty`
--
ALTER TABLE `penalty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productsuggestion`
--
ALTER TABLE `productsuggestion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `cartitem_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `users` (`id`);

--
-- Constraints for table `hrpartner`
--
ALTER TABLE `hrpartner`
  ADD CONSTRAINT `hrpartner_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `investigationrequest`
--
ALTER TABLE `investigationrequest`
  ADD CONSTRAINT `investigationrequest_ibfk_1` FOREIGN KEY (`auditorID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `investigationrequest_ibfk_2` FOREIGN KEY (`hrID`) REFERENCES `hrpartner` (`id`),
  ADD CONSTRAINT `investigationrequest_ibfk_3` FOREIGN KEY (`adminID`) REFERENCES `administrator` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`senderID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`recepientID`) REFERENCES `users` (`id`);

--
-- Constraints for table `penalty`
--
ALTER TABLE `penalty`
  ADD CONSTRAINT `penalty_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `administrator` (`id`),
  ADD CONSTRAINT `penalty_ibfk_2` FOREIGN KEY (`hrID`) REFERENCES `hrpartner` (`id`);

--
-- Constraints for table `productsuggestion`
--
ALTER TABLE `productsuggestion`
  ADD CONSTRAINT `productsuggestion_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `productsuggestion_ibfk_2` FOREIGN KEY (`adminID`) REFERENCES `administrator` (`id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `users` (`id`);

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `survey_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
