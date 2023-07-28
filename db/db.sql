-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2023 at 08:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `task_manager`
--
CREATE DATABASE IF NOT EXISTS `task_manager` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `task_manager`;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_description` text DEFAULT NULL,
  `status` enum('pending','completed','deleted') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `assigned_by`, `assigned_to`, `task_name`, `task_description`, `status`, `created_at`, `completed_at`, `deleted_at`) VALUES
(2, 2, 3, 'a', 'aaa', 'completed', '2023-07-27 14:55:43', '2023-07-27 15:48:47', NULL),
(3, 2, 3, 'task1', 'task1 description here', 'deleted', '2023-07-27 16:55:18', '2023-07-27 17:01:47', '2023-07-27 17:01:56'),
(4, 4, 3, 'task2', 'task2', 'deleted', '2023-07-27 18:15:15', '2023-07-27 18:15:26', '2023-07-27 18:23:29'),
(5, 4, 3, 'task4', 'task4', 'pending', '2023-07-27 18:53:57', NULL, NULL),
(6, 4, 5, 'task5', 'task5', 'pending', '2023-07-27 18:54:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'varad', '$2y$10$OyCeM7FFJ4/5QejT950xl.8eA6zzSnaeu7hfh0gGfgBJ/0Mbxl9tK', 'admin'),
(3, 'employee1', '$2y$10$6DieCyOxqK6s4GNOvfNZbeutRDNbUj.l90phRZMS0fsw14arbsB9e', 'employee'),
(4, 'project_manager', '$2y$10$wJe2LC5V4MtuzxrWeQCuXuXEc8Rzw633/Mv4vck0cNKYBCT/shZ1S', 'project_manager'),
(5, 'Employee2', '$2y$10$q0hWUwakqfNHfMjiJxVh7eIneMp9pSY/fv0DK9hiZ2wt2/6q3nQ/m', 'employee'),
(6, 'admin', '$2y$10$zh7H8Q4H2bPkvK89ShQP7uVXGMWAKfxhmunIhu/itQEWIE.PifeM.', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
