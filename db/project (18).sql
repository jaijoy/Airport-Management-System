-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2023 at 04:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
-- Table structure for table `airbus`
--

CREATE TABLE `airbus` (
  `airbus_id` int(11) NOT NULL,
  `airline_id` int(11) DEFAULT NULL,
  `airbus_name` varchar(255) DEFAULT NULL,
  `passenger_capacity` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airbus`
--

INSERT INTO `airbus` (`airbus_id`, `airline_id`, `airbus_name`, `passenger_capacity`, `status`) VALUES
(47, 28, 'airbus1', 200, 0),
(48, 28, 'airbus2', 220, 0),
(49, 29, 'airbys3', 300, 0),
(50, 29, 'airbus4', 400, 0),
(51, 31, 'airbus5', 400, 0),
(52, 32, 'airbus7', 500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `airline_id` int(11) NOT NULL,
  `airline_name` varchar(255) NOT NULL,
  `airline_type` varchar(255) NOT NULL,
  `logo` varchar(500) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`airline_id`, `airline_name`, `airline_type`, `logo`, `status`) VALUES
(28, 'Air Indiaa', '', 'uploads/air_india.png', 1),
(29, 'IndiGo', '', 'uploads/indigo.png', 1),
(30, 'Air India Express', '', 'uploads/Air_India_Express_Logo.png', 1),
(31, 'Vistara', '', 'uploads/Vistara_Logo.png', 1),
(32, 'Akasa Air', '', 'uploads/Akasa_Air.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `airport`
--

CREATE TABLE `airport` (
  `airport_id` int(11) NOT NULL,
  `airport_name` varchar(255) NOT NULL,
  `airport_location` varchar(255) NOT NULL,
  `terminal` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `airport`
--

INSERT INTO `airport` (`airport_id`, `airport_name`, `airport_location`, `terminal`, `active`, `status`) VALUES
(12, 'Chennai International Airport', 'Chennai', 'domestic, international, cargo', 1, 1),
(13, 'Calicut International Airport', 'Kozhikode', 'international, cargo', 1, 1),
(14, 'Trivandrum International Airport', 'Trivandrum', 'domestic, international, cargo', 1, 0),
(18, 'Calicut International Airport-2', 'Calicut', 'domestic', 0, 1),
(20, 'Indira Gandhi International Airport', 'Delhi', 'domestic, international, cargo', 1, 1),
(21, 'Trivandrum International Airport-2', 'Thiruvananthpuram', 'domestic, international, cargo', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flight_id` int(11) NOT NULL,
  `flight_name` varchar(255) DEFAULT NULL,
  `f_airline_name` varchar(255) DEFAULT NULL,
  `f_airbus_name` varchar(255) DEFAULT NULL,
  `f_departure` varchar(255) DEFAULT NULL,
  `f_arrival` varchar(255) DEFAULT NULL,
  `airline_id` int(11) DEFAULT NULL,
  `airport_id` int(11) DEFAULT NULL,
  `airbus_id` int(11) DEFAULT NULL,
  `stop` varchar(255) DEFAULT NULL,
  `flight_service` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_id`, `flight_name`, `f_airline_name`, `f_airbus_name`, `f_departure`, `f_arrival`, `airline_id`, `airport_id`, `airbus_id`, `stop`, `flight_service`, `price`, `status`) VALUES
(19, 'flight1', 'Air Indiaa', 'airbus1', '12', '13', 28, NULL, 47, 'one stop', 'Domestic', 5000.00, 1),
(20, 'flight2', 'Air Indiaa', 'airbus2', '18', '21', 28, NULL, 48, 'two stop', 'Domestic', 6000.00, 1),
(21, 'flight3', 'IndiGo', 'airbys3', '18', '21', 29, NULL, 49, 'three stop', 'Domestic', 7000.00, 1),
(22, 'flight 5', 'Akasa Air', 'airbus7', '13', '18', 32, NULL, 52, 'one stop', 'Domestic', 8000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `flight_seat`
--

CREATE TABLE `flight_seat` (
  `flightt_id` int(50) NOT NULL,
  `max_no_seats` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flight_type`
--

CREATE TABLE `flight_type` (
  `flight_t_id` int(50) NOT NULL,
  `port_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `onestop`
--

CREATE TABLE `onestop` (
  `one_stop_id` int(11) NOT NULL,
  `airport_id` int(11) DEFAULT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `airline_id` int(11) DEFAULT NULL,
  `layover_duration` text DEFAULT NULL,
  `layover_stop` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `onestop`
--

INSERT INTO `onestop` (`one_stop_id`, `airport_id`, `flight_id`, `airline_id`, `layover_duration`, `layover_stop`) VALUES
(19, NULL, 19, NULL, '1', '13'),
(20, NULL, 22, NULL, '2.5', '21');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `arrival_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `flight_id`, `departure_time`, `arrival_time`) VALUES
(9, 19, '08:20:00', '10:20:00'),
(10, 20, '09:20:00', '10:20:00'),
(11, 21, '10:20:00', '00:21:00'),
(12, 22, '10:21:00', '11:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `seat_id` int(11) NOT NULL,
  `total_seat` int(11) NOT NULL,
  `no_economy` int(11) DEFAULT NULL,
  `no_premium` int(11) DEFAULT NULL,
  `no_business` int(11) DEFAULT NULL,
  `no_first` int(11) DEFAULT NULL,
  `flight_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`seat_id`, `total_seat`, `no_economy`, `no_premium`, `no_business`, `no_first`, `flight_id`) VALUES
(6, 300, 150, 150, 0, 0, 19),
(7, 400, 100, 100, 100, 100, 20),
(8, 300, 200, 100, 0, 0, 21),
(9, 400, 200, 200, 0, 0, 22);

-- --------------------------------------------------------

--
-- Table structure for table `seat_type`
--

CREATE TABLE `seat_type` (
  `seat_id` varchar(50) NOT NULL,
  `seat_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `threestop`
--

CREATE TABLE `threestop` (
  `threestop_id` int(11) NOT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `f_duration` text DEFAULT NULL,
  `f_stop` varchar(255) DEFAULT NULL,
  `s_duration` text DEFAULT NULL,
  `s_stop` varchar(255) DEFAULT NULL,
  `t_duration` text DEFAULT NULL,
  `t_stop` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `threestop`
--

INSERT INTO `threestop` (`threestop_id`, `flight_id`, `f_duration`, `f_stop`, `s_duration`, `s_stop`, `t_duration`, `t_stop`) VALUES
(4, 21, '2', '12', '2.5', '18', '4', '21');

-- --------------------------------------------------------

--
-- Table structure for table `twostop`
--

CREATE TABLE `twostop` (
  `twostop_id` int(11) NOT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `f_duration` text DEFAULT NULL,
  `f_stop` varchar(255) DEFAULT NULL,
  `s_duration` text DEFAULT NULL,
  `s_stop` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `twostop`
--

INSERT INTO `twostop` (`twostop_id`, `flight_id`, `f_duration`, `f_stop`, `s_duration`, `s_stop`) VALUES
(6, 20, '1.5', '12', '7.5', '13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(15) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `pass1` text NOT NULL,
  `verify_token` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verify_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=no,1=yes',
  `role` tinyint(4) DEFAULT 0,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `pass1`, `verify_token`, `created_at`, `verify_status`, `role`, `image`) VALUES
(47, 'Jaimol', 'jaimoljoy2001@gmail.com', '$2y$10$7rOMpFoyby14p/VHVGHcO.8KIInfxnczaUE6nxjPSPla2Pv6CaouG', '9c41c119803b94c785c3d6a7c1d5d580', '2023-10-09 08:46:58', 1, 1, ''),
(48, 'anumoll', 'jaimoljoy2024@gmail.com', '$2y$10$Mv9IDw0nqbSx.E9RvYYHX.TvDTOR.OxcyRlWzkN.aszFyB98AYjsa', 'be69aec7e24e57e052a401dbd55bb04c', '2023-12-02 06:17:20', 1, 0, 'new4.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airbus`
--
ALTER TABLE `airbus`
  ADD PRIMARY KEY (`airbus_id`),
  ADD KEY `airline_id` (`airline_id`);

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`airline_id`);

--
-- Indexes for table `airport`
--
ALTER TABLE `airport`
  ADD PRIMARY KEY (`airport_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_id`),
  ADD KEY `airline_id` (`airline_id`),
  ADD KEY `airport_id` (`airport_id`),
  ADD KEY `airbus_id` (`airbus_id`);

--
-- Indexes for table `flight_seat`
--
ALTER TABLE `flight_seat`
  ADD PRIMARY KEY (`flightt_id`);

--
-- Indexes for table `flight_type`
--
ALTER TABLE `flight_type`
  ADD PRIMARY KEY (`flight_t_id`);

--
-- Indexes for table `onestop`
--
ALTER TABLE `onestop`
  ADD PRIMARY KEY (`one_stop_id`),
  ADD KEY `airport_id` (`airport_id`),
  ADD KEY `flight_id` (`flight_id`),
  ADD KEY `airline_id` (`airline_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `seat_type`
--
ALTER TABLE `seat_type`
  ADD PRIMARY KEY (`seat_id`);

--
-- Indexes for table `threestop`
--
ALTER TABLE `threestop`
  ADD PRIMARY KEY (`threestop_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `twostop`
--
ALTER TABLE `twostop`
  ADD PRIMARY KEY (`twostop_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airbus`
--
ALTER TABLE `airbus`
  MODIFY `airbus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `airline`
--
ALTER TABLE `airline`
  MODIFY `airline_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `airport`
--
ALTER TABLE `airport`
  MODIFY `airport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `flight_seat`
--
ALTER TABLE `flight_seat`
  MODIFY `flightt_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flight_type`
--
ALTER TABLE `flight_type`
  MODIFY `flight_t_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `onestop`
--
ALTER TABLE `onestop`
  MODIFY `one_stop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `threestop`
--
ALTER TABLE `threestop`
  MODIFY `threestop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `twostop`
--
ALTER TABLE `twostop`
  MODIFY `twostop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `airbus`
--
ALTER TABLE `airbus`
  ADD CONSTRAINT `airbus_ibfk_1` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`);

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `flight_ibfk_1` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`),
  ADD CONSTRAINT `flight_ibfk_2` FOREIGN KEY (`airport_id`) REFERENCES `airport` (`airport_id`),
  ADD CONSTRAINT `flight_ibfk_3` FOREIGN KEY (`airbus_id`) REFERENCES `airbus` (`airbus_id`);

--
-- Constraints for table `onestop`
--
ALTER TABLE `onestop`
  ADD CONSTRAINT `onestop_ibfk_1` FOREIGN KEY (`airport_id`) REFERENCES `airport` (`airport_id`),
  ADD CONSTRAINT `onestop_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`),
  ADD CONSTRAINT `onestop_ibfk_3` FOREIGN KEY (`airline_id`) REFERENCES `airline` (`airline_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`);

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `seat_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`);

--
-- Constraints for table `threestop`
--
ALTER TABLE `threestop`
  ADD CONSTRAINT `threestop_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`);

--
-- Constraints for table `twostop`
--
ALTER TABLE `twostop`
  ADD CONSTRAINT `twostop_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
