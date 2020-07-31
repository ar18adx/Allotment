-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2020 at 06:07 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `allotment`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `homeAddress` varchar(100) NOT NULL,
  `siteName` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(280) NOT NULL,
  `adminRole` varchar(50) NOT NULL,
  `addedBy` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `firstName`, `lastName`, `emailAddress`, `telephone`, `homeAddress`, `siteName`, `gender`, `password`, `adminRole`, `addedBy`, `datetime`) VALUES
(1, 'Olawale', 'Borokini', 'waleborokini@gmail.com', '08164860852', 'Ikeja, Lagos', 'All', 'Male', '$2y$10$umVlijYfv.Gp5PRlWZdfJuiEMjuo2CtKmY7x4/lyH0aizYRw2kWJC', 'Super_Admin', ' ', 'July-16-2020 at 01:03:AM'),
(2, 'John', 'Doe', 'johndoe@gmail.com', '08164860852', 'Surulere, Lagos', 'Surulere', 'Male', '$2y$10$rJE6A..S9X3gm94y/xpmeOLWQPYbZKl7luOVDIBu1kJLTBpJJ72GO', 'Site_Manager', 'Olawale Borokini', 'July-16-2020 at 02:49:AM'),
(3, 'James', 'Bond', 'jamesbond@gmail.com', '08164860852', 'Ikeja, Lagos', 'Ikeja', 'Male', '$2y$10$wmqTgnAyowVF1Te7yJAmDeN/.NJLBTE60wPdAuUzzWHAZbR7Z3Ip6', 'Site_Manager', 'Olawale Borokini', 'July-16-2020 at 02:52:AM'),
(4, 'Tom', 'Ford', 'tomford@gmail.com', '08164860852', 'Victoria Island, Lagos', 'Victoria Island', 'Male', '$2y$10$v5yUgZ8hIyJUgpsK9JA91ueXGQ7uNFHTwDepaLdwKh0jCNBR6FGLW', 'Site_Manager', 'Olawale Borokini', 'July-16-2020 at 02:55:AM'),
(9, 'William', 'Gallas', 'gallas@gmail.com', '08164860852', 'Ajah, Lagos', 'Ajah', 'Male', '$2y$10$RtSTeNeb2phcftzfuZACE.bLsNdFmujDsfk0CDtHURdFORNTqJMNq', 'Site_Manager', 'Olawale Borokini', 'July-23-2020 at 04:31:PM');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(50) NOT NULL,
  `cityName` varchar(50) NOT NULL,
  `cityShortCode` varchar(50) NOT NULL,
  `addedBy` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `availabilityStatus` varchar(50) NOT NULL,
  `asUpdatedBy` varchar(50) NOT NULL,
  `updateTime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `cityName`, `cityShortCode`, `addedBy`, `datetime`, `availabilityStatus`, `asUpdatedBy`, `updateTime`) VALUES
(5, 'Ikeja', 'IKJ', 'Wale Borokini', 'June-29-2020 at 10:20:PM', 'Open', 'Olawale Borokini', 'July-23-2020 at 01:53:PM'),
(6, 'Surulere', 'SRL', 'Wale Borokini', 'June-29-2020 at 11:12:PM', 'Open', 'Olawale Borokini', 'July-23-2020 at 01:53:PM'),
(7, 'Lekki', 'LEK', 'Wale Borokini', 'June-29-2020 at 11:12:PM', 'Open', '', ''),
(8, 'Victoria Island', 'VIS', 'Olawale Borokini', 'July-02-2020 at 02:22:AM', 'Open', 'Tom Ford', 'July-28-2020 at 09:22:PM'),
(9, 'Ajah', 'AJA', 'Olawale Borokini', 'July-02-2020 at 02:23:AM', 'Open', '', ''),
(10, 'Yaba', 'YAB', 'Olawale Borokini', 'July-23-2020 at 02:10:AM', 'Open', 'Olawale Borokini', 'July-23-2020 at 03:47:AM'),
(11, 'Oshodi', 'OSH', 'Olawale Borokini', 'July-23-2020 at 02:12:AM', 'Open', '', ''),
(15, 'Ikoyi', 'IKY', 'Olawale Borokini', 'July-23-2020 at 02:25:AM', 'Open', 'Olawale Borokini', 'July-23-2020 at 01:53:PM'),
(17, 'Somolu', 'SML', 'Olawale Borokini', 'July-23-2020 at 02:39:AM', 'Open', 'Olawale Borokini', 'July-29-2020 at 03:38:AM');

-- --------------------------------------------------------

--
-- Table structure for table `contactmessages`
--

CREATE TABLE `contactmessages` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `subjectMsg` varchar(50) NOT NULL,
  `textMessage` text NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contactmessages`
--

INSERT INTO `contactmessages` (`id`, `firstName`, `lastName`, `emailAddress`, `telephone`, `subjectMsg`, `textMessage`, `datetime`) VALUES
(3, 'Raji', 'Smith', 'raji@gmail.com', '08164860852', 'Permission To Apply', 'Hello !!!', 'July-28-2020 at 04:28:PM');

-- --------------------------------------------------------

--
-- Table structure for table `formertenants`
--

CREATE TABLE `formertenants` (
  `id` int(50) NOT NULL,
  `tenantId` varchar(50) NOT NULL,
  `tenantFirstName` varchar(50) NOT NULL,
  `tenantLastName` varchar(50) NOT NULL,
  `tenantEmailAddress` varchar(50) NOT NULL,
  `tenantPhoneNum` varchar(50) NOT NULL,
  `tenantCity` varchar(50) NOT NULL,
  `siteCity` varchar(50) NOT NULL,
  `plotNumber` varchar(50) NOT NULL,
  `leaseDate` varchar(50) NOT NULL,
  `expirationDate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `formertenants`
--

INSERT INTO `formertenants` (`id`, `tenantId`, `tenantFirstName`, `tenantLastName`, `tenantEmailAddress`, `tenantPhoneNum`, `tenantCity`, `siteCity`, `plotNumber`, `leaseDate`, `expirationDate`) VALUES
(6, '13', 'Tunde', 'Fashola', 'fashola@gmail.com', '08164860852', 'Surulere', 'Surulere', 'SRL9BTRL06PEB', '2020-07-25 ', '2020-07-25'),
(7, '19', 'Harry', 'Kane', 'kane@gmail.com', '08164860852', 'Surulere', 'Surulere', 'SRL4UNIU68DIV', '2020-07-25 ', '2020-07-20'),
(8, '25', 'David', 'Luiz', 'davidluiz@gmail.com', '08164860852', 'Surulere', 'Surulere', 'SRL9BTRL06PEB', '2020-07-25 ', '2020-07-25'),
(16, '12', 'Gareth', 'Bale', 'bale@gmail.com', '08164860852', 'Surulere', 'Surulere', 'SRL4UNIU68DIV', '2020-07-30', '2020-07-25'),
(17, '8', 'Larry', 'Gaga', 'larrygaga@gmail.com', '08164860852', 'Surulere', 'Surulere', 'SRLGPQ58527I2', '2020-07-25 ', '2020-07-25'),
(18, '9', '', '', '', '', '', '', '', '', ''),
(19, '18', '', '', '', '', '', '', '', '', ''),
(20, '18', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `inspectionreport`
--

CREATE TABLE `inspectionreport` (
  `id` int(11) NOT NULL,
  `siteName` varchar(50) NOT NULL,
  `plotNumber` varchar(50) NOT NULL,
  `inspectionDate` varchar(50) NOT NULL,
  `tenantFirstName` varchar(50) NOT NULL,
  `tenantLastName` varchar(50) NOT NULL,
  `adminId` int(11) NOT NULL,
  `inspectionOfficer` varchar(50) NOT NULL,
  `inspectionReport` text NOT NULL,
  `evidence` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inspectionreport`
--

INSERT INTO `inspectionreport` (`id`, `siteName`, `plotNumber`, `inspectionDate`, `tenantFirstName`, `tenantLastName`, `adminId`, `inspectionOfficer`, `inspectionReport`, `evidence`) VALUES
(1, 'Ikeja', 'IKJA5NMFT7Q5X', 'July-22-2020 at 12:00:PM', 'Wale', 'Borokini', 3, 'James Bond', 'Hello', 'Add City1595415650.PNG,Register User1595415650.PNG,Register User1595415650.PNG'),
(2, 'Ikeja', 'IKJA5NMFT7Q5X', 'July-22-2020 at 05:36:PM', 'Wale', 'Borokini', 3, 'James Bond', 'Hello', '21595435769.jpg,41595435769.jpg,41595435769.jpg'),
(3, 'Victoria Island', 'VIS3DNFHF8A2P', 'July-24-2020 at 12:34:AM', 'John', 'Terry', 4, 'Tom Ford', 'A well maintained Plot', '73059282_720662095093862_4649956657787928741_n1595547267.jpg,73279654_1642102665926425_1712078080597190867_n1595547267.jpg,73279654_1642102665926425_1712078080597190867_n1595547267.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(50) NOT NULL,
  `tenantId` int(50) NOT NULL,
  `userId` int(50) NOT NULL,
  `tenantFirstName` varchar(50) NOT NULL,
  `tenantLastName` varchar(50) NOT NULL,
  `tenantEmail` varchar(50) NOT NULL,
  `siteName` varchar(50) NOT NULL,
  `smName` varchar(50) NOT NULL,
  `msgFrom` varchar(50) NOT NULL,
  `textMessage` text NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `readMsg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `tenantId`, `userId`, `tenantFirstName`, `tenantLastName`, `tenantEmail`, `siteName`, `smName`, `msgFrom`, `textMessage`, `datetime`, `readMsg`) VALUES
(1, 15, 10, 'John', 'Terry', 'johnterry@gmail.com', 'Victoria Island', 'Tenant', 'John Terry', 'Hello Site Manager', '2020-07-20 01:05:07', 1),
(2, 15, 10, 'John', 'Terry', 'johnterry@gmail.com', 'Victoria Island', 'Tom Ford', 'Site Manager', 'Hello John Terry, \r\nHope You are doing good?', '2020-07-20 01:07:17', 1),
(3, 15, 10, 'John', 'Terry', 'johnterry@gmail.com', 'Victoria Island', 'Tom Ford', 'Site Manager', 'Merry Christmas', '2020-07-20 01:07:57', 1),
(4, 15, 10, 'John', 'Terry', 'johnterry@gmail.com', 'Victoria Island', 'Tom Ford', 'Site Manager', 'Your Lease will expire soon', '2020-07-20 01:08:13', 1),
(5, 13, 7, 'Wale', 'Borokini', 'waleborokini@gmail.com', 'Ikeja', 'Tenant', 'Wale Borokini', 'Hello Site Manager for Ikeja!', '2020-07-20 01:37:33', 0),
(6, 13, 7, 'Wale', 'Borokini', 'waleborokini@gmail.com', 'Ikeja', 'Tenant', 'Wale Borokini', 'Are you the only site manager available?', '2020-07-20 01:38:10', 0),
(7, 13, 7, 'Wale', 'Borokini', 'waleborokini@gmail.com', 'Ikeja', 'Tenant', 'Wale Borokini', 'Happy New week', '2020-07-20 01:38:39', 0),
(8, 13, 7, 'Wale', 'Borokini', 'waleborokini@gmail.com', 'Ikeja', 'James Bond', 'Site Manager', 'Hello Wale, I am the Site Manager for Ikeja', '2020-07-20 01:40:07', 1),
(9, 14, 11, 'Raji', 'Raji ', 'raji@gmail.com', 'Ikeja', 'James Bond', 'Site Manager', 'Hello Raji, How are You doing?', '2020-07-20 01:49:52', 1),
(10, 14, 11, 'Raji', 'Raji ', 'raji@gmail.com', 'Ikeja', 'James Bond', 'Site Manager', 'Welcome on board Raji!', '2020-07-20 01:50:37', 1),
(11, 14, 11, 'Raji', 'Raji ', 'raji@gmail.com', 'Ikeja', 'Tenant', 'Raji Raji ', 'Hello Site Manager', '2020-07-20 01:52:57', 0),
(12, 14, 11, 'Raji', 'Raji ', 'raji@gmail.com', 'Ikeja', 'James Bond', 'Site Manager', 'Good Morning Raji!', '2020-07-20 03:07:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plots`
--

CREATE TABLE `plots` (
  `id` int(50) NOT NULL,
  `plotNumber` varchar(50) NOT NULL,
  `plotSize` varchar(50) NOT NULL,
  `plotDescription` varchar(260) NOT NULL,
  `addedBy` varchar(50) NOT NULL,
  `siteIdNum` varchar(50) NOT NULL,
  `plotSite` varchar(50) NOT NULL,
  `plotStatus` varchar(50) NOT NULL,
  `dateCreated` varchar(50) NOT NULL,
  `dateLastModified` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plots`
--

INSERT INTO `plots` (`id`, `plotNumber`, `plotSize`, `plotDescription`, `addedBy`, `siteIdNum`, `plotSite`, `plotStatus`, `dateCreated`, `dateLastModified`) VALUES
(8, 'IKJVHQ08SBB7G', '100 x 300', 'A large plot', 'Wale Borokini', '5', 'Ikeja', 'On_Offer', 'June-30-2020 at 12:28:AM', '2020-07-22'),
(10, 'LEKGGJTDCKKKW', '100 x 300', 'A large plot', 'Wale Borokini', '7', 'Lekki', 'Occupied', 'June-30-2020 at 12:31:AM', '2020-07-24'),
(12, 'SRLGPQ58527I2', '100 x 300', 'A large plot', 'Wale Borokini', '6', 'Surulere', 'Occupied', 'June-30-2020 at 12:33:AM', '2020-07-27'),
(13, 'VIS5T59KWJPZG', '100 x 300', 'A very large plot', 'Olawale Borokini', '8', 'Victoria Island', 'Vacant', 'July-02-2020 at 02:23:AM', 'July-02-2020 at 02:23:AM'),
(14, 'AJAVCX2GUWH7B', '100 x 300', 'A very large plot', 'Olawale Borokini', '9', 'Ajah', 'Vacant', 'July-02-2020 at 02:24:AM', 'July-02-2020 at 02:24:AM'),
(16, 'SRL4UNIU68DIV', '100 x 300', 'A large plot', ' ', '6', 'Surulere1', 'On_Offer', 'July-03-2020 at 12:15:AM', '2020-07-27'),
(17, 'VISDA7Z70SWA0', '100 x 300', 'A very large plot', ' ', '8', 'Victoria Island', 'Vacant', 'July-03-2020 at 12:15:AM', 'July-03-2020 at 12:15:AM'),
(18, 'LEKRB398QNW1P', '100 x 300', 'A very large plot', ' ', '7', 'Lekki', 'Vacant', 'July-03-2020 at 12:17:AM', 'July-03-2020 at 12:17:AM'),
(20, 'IKJ2GTQI0HNP1', '100 x 300', 'A large plot', ' ', '5', 'Ikeja', 'On_Offer', 'July-03-2020 at 12:52:AM', '2020-07-22'),
(21, 'VIS6NOHDCCE0B', '100 x 300', 'A large plot', ' ', '8', 'Victoria Island', 'Vacant', 'July-03-2020 at 03:19:PM', 'July-03-2020 at 03:19:PM'),
(22, 'VISGFLYJEGGH6', '100 x 300', 'A large plot', ' ', '8', 'Victoria Island', 'Vacant', 'July-03-2020 at 03:19:PM', 'July-03-2020 at 03:19:PM'),
(23, 'VIS3DNFHF8A2P', '100 x 300', 'A very large plot', ' ', '8', 'Victoria Island', 'Soon_Vacant', 'July-03-2020 at 03:19:PM', '2020-07-12'),
(24, 'AJAHYMBVM8T3Q', '100 x 300', 'A large plot', ' ', '9', 'Ajah', 'Vacant', 'July-03-2020 at 03:19:PM', 'July-03-2020 at 03:19:PM'),
(25, 'LEKFXVZI3653U', '100 x 300', 'A large plot', ' ', '7', 'Lekki', 'Occupied', 'July-03-2020 at 03:19:PM', '2020-07-12'),
(26, 'LEKIHVG0ZAF93', '100 x 300', 'A large plot', ' ', '7', 'Lekki', 'Vacant', 'July-03-2020 at 03:19:PM', 'July-03-2020 at 03:19:PM'),
(27, 'IKJA5NMFT7Q5X', '100 x 300', 'A large plot', ' ', '5', 'Ikeja', 'Soon_Vacant', 'July-07-2020 at 12:13:AM', '2020-07-14'),
(28, 'IKJFKHAXIT4FB', '100 x 300', 'A very large plot', ' ', '5', 'Ikeja', 'Occupied', 'July-08-2020 at 04:47:PM', '2020-07-13'),
(30, 'AJA6P2YW0UMR1', '100 x 300', 'A large plot', ' ', '9', 'Ajah', 'Vacant', 'July-08-2020 at 04:54:PM', 'July-08-2020 at 04:54:PM'),
(34, 'VISANJLXC3M33', '100 x 300', 'A large plot', 'Tom Ford', '8', 'Victoria Island', 'Vacant', 'July-20-2020 at 12:49:PM', 'July-20-2020 at 12:49:PM'),
(35, 'VISFH6XJQ5FFG', '100 x 300', 'A large plot', 'Olawale Borokini', '8', 'Victoria Island', 'Vacant', 'July-20-2020 at 12:51:PM', 'July-20-2020 at 12:51:PM'),
(36, 'SRL9BTRL06PEB', '100 x 300', 'A large plot', 'Olawale Borokini', '6', 'Surulere', 'On_Offer', 'July-25-2020 at 12:57:AM', '2020-07-27');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(50) NOT NULL,
  `tenantId` varchar(50) NOT NULL,
  `tenantFirstName` varchar(50) NOT NULL,
  `tenantLastName` varchar(50) NOT NULL,
  `tenantEmailAddress` varchar(50) NOT NULL,
  `tenantPhoneNum` varchar(50) NOT NULL,
  `tenantCity` varchar(50) NOT NULL,
  `siteId` varchar(50) NOT NULL,
  `siteCity` varchar(50) NOT NULL,
  `plotId` varchar(50) NOT NULL,
  `plotNumber` varchar(50) NOT NULL,
  `leaseDate` varchar(50) NOT NULL,
  `expirationDate` varchar(20) NOT NULL,
  `renewalStatus` varchar(50) NOT NULL,
  `tenantStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `tenantId`, `tenantFirstName`, `tenantLastName`, `tenantEmailAddress`, `tenantPhoneNum`, `tenantCity`, `siteId`, `siteCity`, `plotId`, `plotNumber`, `leaseDate`, `expirationDate`, `renewalStatus`, `tenantStatus`) VALUES
(13, '7', 'Wale', 'Borokini', 'waleborokini@gmail.com', '08164860852', 'Ikeja', '5', 'Ikeja', '27', 'IKJA5NMFT7Q5X', '2020-07-12 ', '2020-08-10', 'Pending', 'Active'),
(14, '11', 'Raji', 'Raji ', 'raji@gmail.com', '08164860852', 'Ikeja', '5', 'Ikeja', '20', 'IKJ2GTQI0HNP1', '2020-09-13 ', '2021-09-13', 'Will_Renew', 'Active'),
(15, '10', 'John', 'Terry', 'johnterry@gmail.com', '08164860852', 'Victoria Island', '8', 'Victoria Island', '23', 'VIS3DNFHF8A2P', '2019-07-30', '2020-09-30', 'Will_Renew', 'Active'),
(16, '16', 'James', 'Brown', 'jamesbrown@gmail.com', '08164860852', 'Lekki', '7', 'Lekki', '25', 'LEKFXVZI3653U', '2020-07-12 ', '2021-07-13', 'Pending', 'Active'),
(25, '8', 'Larry', 'Gaga', 'larrygaga@gmail.com', '08164860852', 'Surulere', '6', 'Surulere', '12', 'SRLGPQ58527I2', '2020-07-27 ', '2021-07-28', 'Pending', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(60) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `homeAddress` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(280) NOT NULL,
  `userStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `datetime`, `firstName`, `lastName`, `emailAddress`, `telephone`, `homeAddress`, `city`, `gender`, `password`, `userStatus`) VALUES
(7, 'June-29-2020 at 02:05:AM', 'Wale', 'Borokini', 'waleborokini@gmail.com', '08164860852', 'Ikeja, Lagos', 'Ikeja', 'Male', '$2y$10$e/oR0MPg0X0zK/N0mzjF.eFsFzJKNdc0xd/Xu/19L8pJw90.eNvja', 'Tenant'),
(8, 'July-03-2020 at 12:58:AM', 'Larry', 'Gaga', 'larrygaga@gmail.com', '08164860852', 'Surulere, Lagos', 'Surulere', 'Male', '$2y$10$98vA8FXpFKCd/kqgR3kFuu/khHZMaurktjCneeN0MXSpWph/oGFp.', 'Tenant'),
(9, 'July-03-2020 at 03:18:PM', 'Will', 'Smith', 'willsmith@gmail.com', '08164860852', 'Victoria Island, Lagos', 'Victoria Island', 'Male', '$2y$10$MKOzBNdnjy0.6INrmouFW.H4kTu/FunFKHKh8RgaXkP4AzwgwTEYK', 'New_User'),
(10, 'July-05-2020 at 12:31:AM', 'John', 'Terry', 'johnterry@gmail.com', '08164860852', 'Victoria Island, Lagos', 'Victoria Island', 'Male', '$2y$10$APNQ7nTwljV4gtb52tMeguomePE8KzTut5Q/EGsFlxK/2tva3/ZaO', 'Tenant'),
(11, 'July-05-2020 at 09:21:PM', 'Raji', 'Raji ', 'raji@gmail.com', '08164860852', 'Lagos, Nigeria', 'Ikeja', 'Male', '$2y$10$vmBnYR0LmaS0P8mvsKy6IOaE8UIo633xf0jq/appssartSDzmuu0.', 'Tenant'),
(12, 'July-06-2020 at 11:47:PM', 'Gareth', 'Bale', 'bale@gmail.com', '08164860852', 'Surulere, Lagos', 'Surulere', 'Male', '$2y$10$TDtorJk5q9xEwmp46qS.t.7w/MHR.Bke/EykOlf8J7pQ9USW8r.sC', 'New_User'),
(13, 'July-12-2020 at 05:53:PM', 'Tunde', 'Fashola', 'fashola@gmail.com', '08164860852', 'Surulere, Lagos', 'Surulere', 'Male', '$2y$10$SFTgWQR4b2zmHqeWIriZMeWghmUAqYr6.C9OuYV9XD1L0yJPeTTwy', 'Awaiting_Plot'),
(14, 'July-12-2020 at 05:54:PM', 'Korede', 'Bello', 'bello@gmail.com', '08164860852', 'Surulere, Lagos', 'Surulere', 'Male', '$2y$10$36vjvlNis32f9YTx09PJnOAP9osvIIeiqPZSd6PuQ13SeAa8y85hG', 'Awaiting_Plot'),
(15, 'July-12-2020 at 08:48:PM', 'John', 'Terry', 'johnterry@gmail.com', '08164860852', 'Victoria Island, Lagos', 'Victoria Island', 'Male', '$2y$10$Uh/JHIECk67PT/eDZ3vnZOAptZRCvGfJ6MfRAbR9ME1wdgEopp0m.', 'New_User'),
(16, 'July-12-2020 at 09:11:PM', 'James', 'Brown', 'jamesbrown@gmail.com', '08164860852', 'Lekki', 'Lekki', 'Male', '$2y$10$ckblKTYnV9NLEIzCmTKj3OBvKDdtzOpv7avnhmEM5DHIHwt.aEXBW', 'Tenant'),
(17, 'July-13-2020 at 09:22:PM', 'David', 'Beckham', 'beckam@gmail.com', '08164860852', 'Surulere, Lagos', 'Surulere', 'Male', '$2y$10$13jAqtXcAC4CIBG.W34eQuYjXrW3jWfsR7oThJxcdYVymoXEdKvT6', 'Awaiting_Plot'),
(18, 'July-13-2020 at 09:23:PM', 'Paul', 'Scholes', 'scholes@yahoo.com', '08164860852', 'Surulere, Lagos', 'Surulere', 'Male', '$2y$10$vfw97fzRs5NhOdhBd.4PhO7wUE79pGMeSIgOA9lWavkVDk3bgATEK', 'New_User'),
(19, 'July-13-2020 at 09:24:PM', 'Harry', 'Kane', 'kane@gmail.com', '08164860852', 'Surulere, Lagos', 'Surulere', 'Male', '$2y$10$KuHHHLKo7hEPz4KHm2MCMOuYEfRA.neh7Lz8JIaLuioIntgeHqw6O', 'Awaiting_Plot'),
(21, 'July-14-2020 at 12:13:AM', 'Mesut', 'Ozil', 'mesut@gmail.com', '08164860852', 'Ikeja, Lagos', 'Ikeja', 'Male', '$2y$10$JB9yu0PTixfCneOqjXYHsORjrkwijRYqU83eWF5cCdI2LrYNCGtyq', 'New_User'),
(23, 'July-23-2020 at 01:54:AM', 'Juan', 'Coasta', 'juan@yahoo.com', '08164860852', 'Ajah, Lagos', 'Ajah', 'Male', '$2y$10$NvZeViSC6DavIVgnpf8TYeMli1d5TYZK/d8L0ma1cX5VU4VEjzudG', 'New_User'),
(24, 'July-23-2020 at 01:55:AM', 'Ryan', 'Giggs', 'ryangiggs@gmail.com', '08164860852', 'Ajah, Lagos', 'Ajah', 'Male', '$2y$10$AMPYmwk4/sbr8sGUB9s5OepgfLJm/2Ldg5XrkLJUONZz9dFJBYFoa', 'New_User'),
(25, 'July-25-2020 at 01:10:AM', 'David', 'Luiz', 'davidluiz@gmail.com', '08164860852', 'Surulere, Lagos', 'Surulere', 'Male', '$2y$10$iN77/rlXhe4DhIW.53SmMe3hg9TBM1u4943KUZuwYelMkD/xNdxRa', 'New_User');

-- --------------------------------------------------------

--
-- Table structure for table `waitinglist`
--

CREATE TABLE `waitinglist` (
  `id` int(50) NOT NULL,
  `userId` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `telephoneNumber` varchar(50) NOT NULL,
  `userCity` varchar(50) NOT NULL,
  `siteIdNum` varchar(50) NOT NULL,
  `siteCity` varchar(50) NOT NULL,
  `plotIdNum` varchar(50) NOT NULL,
  `plotNumberApp` varchar(50) NOT NULL,
  `applicationStatus` varchar(50) NOT NULL,
  `offerCount` int(50) NOT NULL,
  `dateApplied` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `waitinglist`
--

INSERT INTO `waitinglist` (`id`, `userId`, `firstName`, `lastName`, `emailAddress`, `telephoneNumber`, `userCity`, `siteIdNum`, `siteCity`, `plotIdNum`, `plotNumberApp`, `applicationStatus`, `offerCount`, `dateApplied`) VALUES
(2, '17', 'David', 'Beckham', 'beckam@gmail.com', '08164860852', 'Surulere', 'None', 'Surulere', 'None', 'None', 'Awaiting_Plot', 0, '2020-07-27'),
(3, '19', 'Harry', 'Kane', 'kane@gmail.com', '08164860852', 'Surulere', 'None', 'Surulere', 'None', 'None', 'Awaiting_Plot', 0, '2020-07-27'),
(5, '13', 'Tunde', 'Fashola', 'fashola@gmail.com', '08164860852', 'Surulere', 'None', 'Surulere', 'None', 'None', 'Awaiting_Plot', 0, '2020-07-28'),
(8, '14', 'Korede', 'Bello', 'bello@gmail.com', '08164860852', 'Surulere', '6', 'Surulere', '36', 'SRL9BTRL06PEB', 'Pending_Confirmation', 0, '2020-07-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactmessages`
--
ALTER TABLE `contactmessages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formertenants`
--
ALTER TABLE `formertenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspectionreport`
--
ALTER TABLE `inspectionreport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plots`
--
ALTER TABLE `plots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waitinglist`
--
ALTER TABLE `waitinglist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `contactmessages`
--
ALTER TABLE `contactmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `formertenants`
--
ALTER TABLE `formertenants`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `inspectionreport`
--
ALTER TABLE `inspectionreport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `plots`
--
ALTER TABLE `plots`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `waitinglist`
--
ALTER TABLE `waitinglist`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
