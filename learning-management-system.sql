-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 12:19 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learning-management-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `course_id`, `instructor_id`, `start_time`, `end_time`, `created_at`, `updated_at`, `deleted_at`) VALUES
(27, 18, 1, '20:46:00', '22:44:00', '2024-06-14 15:44:06', '2024-06-14 15:44:06', NULL),
(28, 20, 1, '20:49:00', '20:50:00', '2024-06-14 15:44:24', '2024-06-14 15:44:24', NULL),
(29, 18, 1, '02:53:00', '03:54:00', '2024-06-20 20:52:57', '2024-06-20 20:52:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `available_seat` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `fee`, `available_seat`, `start_date`, `end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(18, 'Cyber Security', 'Cyber Security testing description Introduction and Management Introduction and ManagementIntroduction and Management Introduction and Management', '500.00', 100, '2024-06-15', '2024-08-30', '2024-06-14 13:19:14', '2024-06-14 13:20:52', NULL),
(20, 'Physics', 'Physics Testing description....', '1200.00', 200, '2024-06-15', '2024-12-30', '2024-06-14 14:09:37', '2024-06-14 14:09:37', NULL),
(22, 'Farsi', 'testing.............', '300.00', 100, '2024-06-15', '2024-06-30', '2024-06-14 14:23:31', '2024-06-14 14:23:31', NULL),
(26, 'Urdu', 'asrewrwe', '23.00', 0, '2024-06-15', '2024-12-14', '2024-06-14 15:28:22', '2024-06-21 15:03:33', NULL),
(35, 'DSA', 'Descriptions for DSA subject .......', '500.00', 10, '2024-06-29', '2024-09-07', '2024-06-21 19:28:57', '2024-06-21 19:28:57', NULL),
(42, 'Arabic', 'testing ', '23.00', 3, '2024-07-06', '2024-11-22', '2024-06-21 20:44:38', '2024-06-21 20:44:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_id` int(11) DEFAULT NULL,
  `instructorcourse_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `enrollment_date`, `student_id`, `instructorcourse_id`, `updated_at`, `deleted_at`) VALUES
(8, '2024-06-14 17:02:08', 5, 26, '2024-06-14 17:02:08', NULL),
(9, '2024-06-14 17:04:21', 5, 37, '2024-06-14 17:04:21', NULL),
(11, '2024-06-21 15:08:21', 1, 31, '2024-06-21 15:08:21', NULL),
(12, '2024-06-21 15:41:51', 5, 15, '2024-06-21 15:41:51', NULL),
(13, '2024-06-21 15:44:31', 5, 31, '2024-06-21 15:44:31', NULL),
(14, '2024-06-21 16:07:28', 1, 26, '2024-06-21 16:07:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '2024-06-06 20:43:12', '2024-06-06 20:43:12', NULL),
(2, 13, '2024-06-07 21:29:34', '2024-06-13 22:23:09', NULL),
(3, 14, '2024-06-07 22:07:58', '2024-06-13 14:58:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructor_course`
--

CREATE TABLE `instructor_course` (
  `id` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `enrollment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor_course`
--

INSERT INTO `instructor_course` (`id`, `instructor_id`, `course_id`, `enrollment_id`) VALUES
(15, 2, 18, NULL),
(25, 1, 20, NULL),
(26, 2, 20, NULL),
(31, 1, 22, NULL),
(32, 3, 22, NULL),
(37, 3, 26, NULL),
(43, 2, 35, NULL),
(50, 1, 42, NULL),
(51, 3, 42, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '2024-06-06 20:31:22', '2024-06-06 20:31:22', NULL),
(2, 'instructor', '2024-06-06 20:31:22', '2024-06-06 20:31:22', NULL),
(3, 'student', '2024-06-06 20:31:22', '2024-06-06 20:31:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, '2024-06-06 20:45:15', '2024-06-06 20:45:15', NULL),
(2, 11, '2024-06-07 21:59:00', '2024-06-07 21:59:00', NULL),
(3, 12, '2024-06-07 22:04:33', '2024-06-13 15:39:48', '2024-06-13 15:39:48'),
(4, 14, '2024-06-07 22:06:38', '2024-06-07 22:13:11', NULL),
(5, 5, '2024-06-14 17:01:53', '2024-06-14 17:01:53', NULL),
(6, 6, '2024-06-14 17:01:53', '2024-06-14 19:19:31', '2024-06-14 19:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$HMnBpMnO6tECimsF.G6pYuD8tym1jcLnqmtZ.v5queCjtu/fS9WvC', 1, '2024-06-06 20:31:22', '2024-06-06 20:31:22', NULL),
(2, 'Arsalan', 'arsalan@example.com', '$2y$10$PRERG03KPAA8DSuVZ22YTeuQHADo22l1XogJQsWcjsvp7b304Kptu', 2, '2024-06-06 20:31:22', '2024-06-06 20:31:22', NULL),
(3, 'Ali', 'ali@example.com', '$2y$10$HFpTbih7Y9FeztD63ZcwzOqFynfeDthmZtN7984HDZZyP1KtEPh4O', 3, '2024-06-06 20:31:22', '2024-06-06 20:31:22', NULL),
(5, 'Asad Munir', 'asad@gmail.com', '$2y$10$u2RycRKcdq1b1SHMepjie.dOXY//L6qZPkd5CPskaxXu1yKqyBQKq', 3, '2024-06-07 21:07:34', '2024-06-07 21:07:34', NULL),
(6, 'Azhar Abas', 'azar@gmail.com', '$2y$10$3fOx4UoZSSSVaaEXFdJYwexLXwR7T6aDX6nupCLSH36dvphOxQcdG', 3, '2024-06-07 21:24:50', '2024-06-07 21:24:50', NULL),
(7, 'Kamran', 'kamran@gmail.com', '$2y$10$X5c/HgQOX4US19PoSykAzuh.Pdzu5i6tB6QT14/Sk7VR1q8AlZn5G', 3, '2024-06-07 21:29:34', '2024-06-07 21:29:34', NULL),
(8, 'Zufiqar', 'zulfiqar@gmail.com', '$2y$10$LIC7IwYeQWR7A8VdZH1gP.gttY0eiKtxjWFY1GfFgp/faqbSRZn0e', 3, '2024-06-07 21:34:06', '2024-06-07 21:34:06', NULL),
(9, 'Umer', 'umer@gmail.com', '$2y$10$7yAIbXt0Ob7FBEcyPX.iteFbf0j5KJHYdAA.jD7GHh6kNZ0Hx/I06', 3, '2024-06-07 21:36:52', '2024-06-07 21:36:52', NULL),
(10, 'Razaq', 'razaq@gmail.com', '$2y$10$a9TEUwbsKMi7xllSjYJXq.kDbA5Yf3nmaZg8cI8RT7d69SIlulcyu', 3, '2024-06-07 21:53:56', '2024-06-07 21:53:56', NULL),
(11, 'Saad', 'saad@gmail.com', '$2y$10$s1BJU0V283urGTf2.J7Wk.RS9DjbA16dJ3ttOSkvkdA49UkGbaYxS', 3, '2024-06-07 21:59:00', '2024-06-07 21:59:00', NULL),
(12, 'Salman', 'salman@gmail.com', '$2y$10$2S/jY7OMcYtEi.NJxjmdK.fuoTve9bw3wHPqVOtEAA6RrvHPSXaJ.', 3, '2024-06-07 22:04:33', '2024-06-07 22:39:42', NULL),
(13, 'Waleed', 'waleed@gmail.com', '$2y$10$0ZemWi9ERuaLzGia6WMkSeRIEHqxZ0GpBA/lSSzzj78CivHWXLYR2', 2, '2024-06-07 22:06:38', '2024-06-07 22:06:38', NULL),
(14, 'Sami', 'sami@gmail.com', '$2y$10$sIjiOfPIMaHs4w5/sA5JP.pf0IRDqhrdkBoxuQg0g7BzRsCxjitWu', 2, '2024-06-07 22:07:58', '2024-06-10 13:55:03', NULL),
(15, 'Mohsin', 'mohsin@gmail.com', '$2y$10$X9xzU5gRIs0gzWPpi3ac1Old8MZUg9.MezbQz.JfCQ085HYtiz8w.', 2, '2024-06-07 22:11:20', '2024-06-07 22:11:20', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_classes_course_id` (`course_id`),
  ADD KEY `fk_classes_instructor_id` (`instructor_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_enrollments_student_id` (`student_id`),
  ADD KEY `fk_enrollments_course_id` (`instructorcourse_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_instructors_user_id` (`user_id`);

--
-- Indexes for table `instructor_course`
--
ALTER TABLE `instructor_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_instructor_course_course_id` (`course_id`),
  ADD KEY `fk_instructor_course_enrollment_id` (`enrollment_id`),
  ADD KEY `fk_instructor_course_instructor_id` (`instructor_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_students_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `instructor_course`
--
ALTER TABLE `instructor_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `fk_classes_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_classes_instructor_id` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_enrollments_course_id` FOREIGN KEY (`instructorcourse_id`) REFERENCES `instructor_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollments_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
  ADD CONSTRAINT `fk_instructors_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `instructor_course`
--
ALTER TABLE `instructor_course`
  ADD CONSTRAINT `fk_instructor_course_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_instructor_course_enrollment_id` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_instructor_course_instructor_id` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_students_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
