-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2021 at 02:30 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id15180135_apsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'admin', '$2y$10$fCOiMky4n5hCJx3cpsG20Od4wHtlkCLKmO6VLobJNRIg9ooHTkgjK', 'Nicko', 'Sanchez', 'male6.jpg', '2018-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time_in` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `time_out` varchar(20) NOT NULL DEFAULT '00:00:00',
  `num_hr` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `status`, `time_out`, `num_hr`) VALUES
(90, 'FPN543108976', '2020-07-11', '06:05:12', 1, '16:00:00', 7),
(95, 'EYI043281796', '2020-01-11', '06:30:00', 0, '22:30:00', 11.316666666667),
(182, 'TAP639702841', '2020-06-18', '08:00:00', 1, '12:31:52', 2.5166666666667),
(229, 'EYI043281796', '2020-11-27', '07:00:00', 1, '16:00:00', 7),
(293, 'UCJ407539281', '2021-02-17', '02:02:24am', 1, '11:22:09pm', 13.366666666667),
(300, 'EYI043281796', '2021-02-15', '08:00:00', 0, '17:00:00', 3.5333333333333),
(301, 'EYI043281796', '2021-03-16', '08:00:00', 1, '12:15:00', 0),
(302, 'EYI043281796', '2021-03-26', '08:15:00', 0, '17:15:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `date_advance` date NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cashadvance`
--

INSERT INTO `cashadvance` (`id`, `date_advance`, `employee_id`, `amount`) VALUES
(8, '2021-02-04', 'UCJ407539281', 50),
(12, '2021-02-16', 'TAP639702841', 35);

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `description`, `amount`) VALUES
(1, 'SSS', 75),
(2, 'Pag-ibig', 30),
(3, 'PhilHealth', 20);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `position_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL,
  `qrimage` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `firstname`, `lastname`, `address`, `birthdate`, `contact_info`, `gender`, `position_id`, `schedule_id`, `photo`, `created_on`, `qrimage`) VALUES
(124, 'UCJ407539281', 'Jim', 'Zamora', 'Quezon City', '1999-07-21', '09123456789', 'Male', 2, 3, 'AvatarMaker.png', '2020-10-15', '../images/qrimage/5f883e8aa4d80.png'),
(128, 'EPZ743501986', 'Peter', 'Mckinnon', '5th Avenue Metro Manila', '2012-12-12', '09225553320', 'Male', 2, 3, 'avatar04.png', '2020-10-20', '../images/qrimage/5f8eee9d5b8c6.png'),
(135, 'TAP639702841', 'Riza Jean', 'Amparado', 'Manila', '2020-11-02', '09123456789', 'Female', 1, 4, 'female4.jpg', '2020-11-19', '../images/qrimage/5fb68eed8122b.png'),
(153, 'FPN543108976', 'Jessica', 'Cabales', 'Bulacan', '1981-04-09', '09225553320', 'Female', 1, 2, 'avatar3.png', '2020-12-18', '../images/qrimage/5fdc687539681.png'),
(155, 'EYI043281796', 'Daniel', 'Schiffer', '215N Ave. Pasadena CA 91101 Manila', '1990-02-02', '09090123123', 'Male', 12, 2, 'AvatarMaker.png', '2021-01-05', '../images/qrimage/5ff3f0d32939e.png'),
(162, 'SPR967805412', 'Joseph Aldrin', 'Zamora', '#75 Diones Bldg. East Service Road Brgy. 157 Bagong Barrio, Caloocan City', '1999-07-20', '09761234589', 'Male', 1, 2, 'Logan.png', '2021-02-12', '../images/qrimage/6026ca3d80ca8.png'),
(163, 'XMQ247538906', 'Michael ', 'Santos', 'Quezon city', '1999-06-15', '09876543219', 'Male', 10, 2, 'AvatarMaker.png', '2021-02-19', '../images/qrimage/602f34cd7dbff.png');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `materials_id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `description` varchar(50) CHARACTER SET latin1 NOT NULL,
  `unit` varchar(15) CHARACTER SET latin1 NOT NULL,
  `price` double NOT NULL,
  `stock` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`materials_id`, `name`, `description`, `unit`, `price`, `stock`) VALUES
(2, 'Gravel', 'Flooring', 'lot', 170, 41),
(3, 'Concrete Works', 'Nail (2inches)', 'box', 250, 16),
(4, 'Plywood', '2ft x 10ft', 'pc', 150, 10),
(6, 'Concrete Works', 'Sand', 'bags', 1100, 11),
(7, 'Hollow Blocks', 'Concrete Hollow Blocks (CHB)', 'pc', 100, 110);

-- --------------------------------------------------------

--
-- Table structure for table `materials_list`
--

CREATE TABLE `materials_list` (
  `list_id` int(11) NOT NULL,
  `materials_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `materials_list`
--

INSERT INTO `materials_list` (`list_id`, `materials_name`, `quantity`) VALUES
(1, 'Pala', 6),
(3, 'Hammer', 8),
(4, 'Lagari', 9);

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `hours` double NOT NULL,
  `rate` double NOT NULL,
  `date_overtime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `overtime`
--

INSERT INTO `overtime` (`id`, `employee_id`, `hours`, `rate`, `date_overtime`) VALUES
(9, 'UCJ407539281', 2.3333333333333, 300, '2020-11-27'),
(17, 'TAP639702841', 2.0666666666667, 100, '2021-02-17'),
(19, 'EYI043281796', 1, 100, '2021-02-23');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `description`, `rate`) VALUES
(1, 'Foreman', 100),
(2, 'Worker', 50),
(3, 'Marketing ', 250),
(10, 'Graphic Designer', 200),
(12, 'Welder', 72.3),
(14, 'HR', 300),
(15, 'Tigapala', 500);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(9) NOT NULL,
  `project_id` varchar(15) CHARACTER SET latin1 NOT NULL,
  `project_name` varchar(30) NOT NULL,
  `project_startdate` date NOT NULL,
  `project_enddate` date NOT NULL,
  `project_description` varchar(50) NOT NULL,
  `project_owner` varchar(50) NOT NULL,
  `project_address` varchar(60) NOT NULL,
  `project_budget` double NOT NULL,
  `project_status` varchar(10) NOT NULL,
  `photo` varchar(200) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `project_id`, `project_name`, `project_startdate`, `project_enddate`, `project_description`, `project_owner`, `project_address`, `project_budget`, `project_status`, `photo`) VALUES
(1, '123ADCE2', '3rd Floor House', '2020-11-10', '2020-12-09', '3 Stories Building', 'Jimmy S. Santos', 'Sta. Mesa', 10000, 'Pending', 'logo.jpg'),
(2, 'ITN517428936', 'Commercial', '2021-02-01', '2021-11-22', 'Modern II', 'Carla Estrada', 'San Jose Corner Quezon City', 600000, 'Pending', 'clipart-telephone-animation-18.png'),
(3, 'RGJ815402376', 'SSS Guardhouse and Gate', '2020-11-25', '2022-11-25', 'Vintage Style', 'Sheena Santos', 'Bagong Barrio, Caloocan City', 300000, 'Finish', 'Kelvin Dalena.png'),
(5, 'QJT856942073', 'Rest House at Tagaytay ', '2020-10-01', '2021-10-01', '3 Story house', 'Mark A. Zamora', 'Tagaytay City', 500000, 'Active', 'implementation.png'),
(6, 'YMO893614072', 'Condominium', '2021-02-07', '2021-11-22', '3 Storey Building', 'Leo Juan', 'San Jose Del Monte, Bulacan', 1500000, 'Pending', 'OIP.jfif'),
(8, 'HJZ347258106', 'Gymnasium of PUP', '2020-07-30', '2021-11-22', '2 Storey Building', 'Marie Ann F. Fernando', 'San Jose del Monte Bulacan', 1500000, 'Active', 'OIP.jfif'),
(9, 'AGV058942713', 'Apartment', '2021-01-01', '2021-12-09', '2 Storey 2 apartment', 'Michael Santos', 'Mabait, Kawaan, Quezon City', 1500000, 'Active', '2 Storey 2 Door Apartment.jpg'),
(11, 'KQC216405793', 'Go Building', '2021-02-01', '2021-12-01', '5 Story Building', 'Mark Santos', 'Sta. Mesa, Manila', 1500000, 'Pending', '2 Storey 2 Door Apartment.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `project_employee`
--

CREATE TABLE `project_employee` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `timeline_sched` date NOT NULL,
  `project_date_end` date NOT NULL,
  `projectid` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_employee`
--

INSERT INTO `project_employee` (`id`, `name`, `position`, `status`, `timeline_sched`, `project_date_end`, `projectid`) VALUES
(190, 'UCJ407539281', 'Graphic Designer', 'Vacant', '2020-11-10', '2020-12-09', '123ADCE2'),
(191, 'FPN543108976', 'Foreman', 'On going', '2021-02-08', '2021-03-31', 'ITN517428936'),
(192, 'TAP639702841', 'Worker', 'On going', '2021-05-08', '2021-06-16', 'ITN517428936'),
(254, 'SPR967805412', 'Foreman', 'On going', '2021-02-01', '2021-12-01', 'KQC216405793'),
(256, 'EYI043281796', 'Graphic Designer', 'Vacant', '2021-02-22', '2021-02-28', 'KQC216405793'),
(257, 'EYI043281796', 'Graphic Designer', 'On going', '2021-02-01', '2021-02-20', 'QJT856942073'),
(258, 'EYI043281796', 'Welder', 'Vacant', '2020-11-10', '2020-12-09', '123ADCE2');

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

CREATE TABLE `project_files` (
  `id` int(11) NOT NULL,
  `file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `projectid` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_files`
--

INSERT INTO `project_files` (`id`, `file`, `type`, `size`, `projectid`) VALUES
(2, '56946-evaluation-iso-9126-by-joseph-aldrin.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 20, '123ADCE2'),
(4, '23148-avatar5.png', 'image/png', 8, '123ADCE2'),
(5, '22886-fbd.pdf', 'application/pdf', 348, '123ADCE2'),
(6, '37603-proposal.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 20, 'AGV058942713'),
(7, '76791-drawing.pdf', 'application/pdf', 1302, 'AGV058942713');

-- --------------------------------------------------------

--
-- Table structure for table `project_leader`
--

CREATE TABLE `project_leader` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `projectid` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_leader`
--

INSERT INTO `project_leader` (`id`, `name`, `projectid`) VALUES
(4, 'Jacob Carter', '123ADCE2'),
(5, 'Bruno Den', 'ITN517428936'),
(6, 'Bruno Den', 'YMO893614072');

-- --------------------------------------------------------

--
-- Table structure for table `project_materials`
--

CREATE TABLE `project_materials` (
  `id` int(50) NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` decimal(10,0) NOT NULL,
  `unit` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unit_cost` double NOT NULL,
  `amnt_cost` double NOT NULL,
  `proj_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_materials`
--

INSERT INTO `project_materials` (`id`, `description`, `quantity`, `unit`, `unit_cost`, `amnt_cost`, `proj_id`) VALUES
(9, '20 kgs of nails', 150, 'sack', 200, 2000, '123ADCE2'),
(12, '100 kgs of cement', 200, 'sack', 100, 1500, '123ADCE2'),
(14, 'Stone', 2, 'truck', 7000, 14000, '123ADCE2'),
(17, 'Cement', 5, 'Wood', 500, 2500, '123ADCE2'),
(21, 'Flooring', 200, 'sack', 200, 400, '123ADCE2'),
(23, 'Concrete Works', 5, 'truck', 200, 1000, 'GAC054382679'),
(24, 'Flooring', 2, 'sack', 200, 400, 'GAC054382679'),
(25, 'Concrete Works', 5, 'sack', 200, 1000, 'HJZ347258106'),
(26, '2ft x 10ft', 2, 'Block', 200, 400, 'HJZ347258106'),
(28, '4\"', 1, 'piece', 200, 2000, 'ITN517428936'),
(29, 'Concrete Works', 10, 'Sack', 150, 1500, '123ADCE2'),
(32, 'Concrete Hollow Blocks (CHB)', 10, 'Block', 100, 1000, 'AGV058942713'),
(33, 'Sand', 5, 'sack', 100, 500, 'AGV058942713');

-- --------------------------------------------------------

--
-- Table structure for table `project_materials_log`
--

CREATE TABLE `project_materials_log` (
  `id` int(9) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `material` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quantity1` int(11) NOT NULL,
  `time_borrow` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `con_dition` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time_return` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `proj_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_materials_log`
--

INSERT INTO `project_materials_log` (`id`, `date`, `name`, `material`, `quantity1`, `time_borrow`, `status`, `con_dition`, `time_return`, `price`, `proj_id`) VALUES
(25, '2021-02-13', 'UCJ407539281', '4', 1, '02:45 PM', 'Settled', 'Returned Bad', '03:45 AM', 50, '123ADCE2'),
(26, '2021-02-19', 'EPZ743501986', '3', 1, '11:30 AM', 'Unsettled', 'Returned Bad', '11:45 AM', 100, 'KQC216405793'),
(27, '2021-02-19', 'EYI043281796', '1', 1, '12:30 PM', 'Settled', 'Returned Good', '12:30 PM', 0, 'KQC216405793'),
(28, '2021-02-19', 'EYI043281796', '3', 1, '12:30 PM', 'Settled', 'Returned Bad', '12:30 PM', 50, 'KQC216405793'),
(29, '2021-02-19', 'EYI043281796', '1', 1, '12:30 PM', 'Settled', 'Missing', '12:30 PM', 0, 'KQC216405793'),
(38, '2021-03-09', 'SPR967805412', '1', 1, '12:15 PM', 'Settled', 'Returned Good', '12:15 PM', 0, 'KQC216405793'),
(99, '2021-03-16', 'EYI043281796', '1', 2, '08:30 AM', 'Settled', 'Returned Good', '08:30 AM', 0, 'QJT856942073');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `time_in`, `time_out`) VALUES
(2, '08:00:00', '17:00:00'),
(3, '09:00:00', '18:00:00'),
(4, '10:00:00', '19:00:00'),
(8, '11:00:00', '19:00:00'),
(10, '00:00:00', '17:45:00'),
(11, '12:00:00', '18:00:00'),
(12, '06:30:00', '16:30:00'),
(13, '06:30:00', '18:30:00'),
(15, '06:00:00', '16:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`materials_id`);

--
-- Indexes for table `materials_list`
--
ALTER TABLE `materials_list`
  ADD PRIMARY KEY (`list_id`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_employee`
--
ALTER TABLE `project_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_files`
--
ALTER TABLE `project_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_leader`
--
ALTER TABLE `project_leader`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_materials`
--
ALTER TABLE `project_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_materials_log`
--
ALTER TABLE `project_materials_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT for table `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `materials_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `materials_list`
--
ALTER TABLE `materials_list`
  MODIFY `list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `project_employee`
--
ALTER TABLE `project_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `project_files`
--
ALTER TABLE `project_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `project_leader`
--
ALTER TABLE `project_leader`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `project_materials`
--
ALTER TABLE `project_materials`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `project_materials_log`
--
ALTER TABLE `project_materials_log`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
