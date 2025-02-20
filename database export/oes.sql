-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2025 at 08:12 PM
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
-- Database: `oes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','sub-admin') NOT NULL DEFAULT 'admin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$z14kF.6Y7S3IYw4crl1YhuaK55vxtmYB8MEnW4AKqfFXTluHAmyrO', 'admin', NULL, '2024-12-27 08:17:56', '2024-12-27 08:17:56');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `answer` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer`, `is_correct`, `created_at`, `updated_at`) VALUES
(14, 4, 'ggggggggggeghfgfgf', 0, NULL, NULL),
(98, 22, 'SRC', 0, NULL, '2025-02-15 00:35:07'),
(99, 22, '<Table>', 0, NULL, '2025-02-15 00:35:07'),
(100, 22, 'CELLPADDING', 1, NULL, '2025-02-15 00:35:07'),
(101, 22, 'BOLD', 0, NULL, '2025-02-15 00:35:07'),
(102, 22, 'None', 0, NULL, '2025-02-15 00:35:07'),
(104, 22, 'IMG', 0, NULL, '2025-02-15 00:35:07'),
(110, 4, 'gggggggddddddd', 1, NULL, NULL),
(111, 4, 'nnnnnnnnnn', 0, NULL, NULL),
(138, 23, 'Starting tag', 1, NULL, '2025-02-15 00:36:02'),
(139, 23, 'Closed tag', 0, NULL, '2025-02-15 00:36:02'),
(140, 23, 'Pair tags', 0, NULL, '2025-02-15 00:36:02'),
(208, 23, 'Ending tag', 0, NULL, NULL),
(209, 5, 'Ending tag', 0, NULL, NULL),
(210, 5, 'qqqbeee', 1, NULL, NULL),
(211, 5, 'Ending tag', 0, NULL, NULL),
(212, 5, 'Ending tag', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emailverifications`
--

CREATE TABLE `emailverifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `created_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emailverifications`
--

INSERT INTO `emailverifications` (`id`, `email`, `otp`, `created_at`) VALUES
(1, 'md.arif.5a5@gmail.com', '644941', 1738591209);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `examName` varchar(255) NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `no_of_attempts_possible` int(11) NOT NULL DEFAULT 0,
  `marks_per_q` double NOT NULL DEFAULT 4,
  `passing_marks` double NOT NULL DEFAULT 0,
  `entrance_id` varchar(255) NOT NULL,
  `plan` int(11) NOT NULL DEFAULT 0 COMMENT '0->free 1->paid',
  `prices` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`prices`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `examName`, `subject_id`, `date`, `time`, `no_of_attempts_possible`, `marks_per_q`, `passing_marks`, `entrance_id`, `plan`, `prices`, `created_at`, `updated_at`) VALUES
(1, 'Number System', 2, '2025-02-15', '00:09', 3, 1.5, 3.5, 'exid677d2d77d848c', 1, '{\"INR\":\"30\",\"USD\":\"3\"}', NULL, '2025-02-15 00:32:01'),
(2, 'Respiratory System', 1, '2025-01-09', '00:03', 2, 3, 0, 'exid677d2d872f4fa', 0, NULL, NULL, '2025-01-09 08:25:39'),
(3, 'Preposition', 3, '2025-02-16', '01:00', 3, 4, 0, 'exid67a609e0752f4', 0, NULL, NULL, '2025-02-15 00:32:45'),
(4, 'Geometry', 2, '2025-02-07', '00:05', 2, 4, 0, 'exid67a60a2967152', 1, '{\"INR\":\"500\",\"USD\":\"225\"}', NULL, '2025-02-07 11:55:51');

-- --------------------------------------------------------

--
-- Table structure for table `exam_attempts`
--

CREATE TABLE `exam_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `marks` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_attempts`
--

INSERT INTO `exam_attempts` (`id`, `exam_id`, `user_id`, `status`, `marks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, NULL, NULL, '2025-02-04 06:17:59'),
(2, 2, 1, 1, 6, NULL, '2025-02-04 06:05:49'),
(3, 2, 1, 1, 3, NULL, '2025-02-04 02:29:42'),
(4, 1, 1, 1, 0, NULL, '2025-02-04 02:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `exam_payments`
--

CREATE TABLE `exam_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payment_details`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_payments`
--

INSERT INTO `exam_payments` (`id`, `exam_id`, `user_id`, `payment_details`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '{\"razorpay_order_id\":\"order_Pv6NVFTInA9Cai\",\"razorpay_payment_id\":\"pay_Pv6NbY3rbAcaOa\",\"razorpay_signature\":\"f4f5aa6d346cfaa125c15c409f987a31a7de4a9bda8bc76ff0caf28e0c48b51a\"}', '2025-02-13 06:50:36', '2025-02-13 06:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2024_06_26_104901_create_admins_table', 1),
(3, '2024_12_22_034707_create_emailverifications_table', 1),
(4, '2024_12_24_043511_create_subjects_table', 1),
(12, '2024_12_29_154129_create_questions_table', 3),
(13, '2024_12_29_154149_create_answers_table', 3),
(14, '2025_01_03_092751_create_qna_exams_table', 4),
(17, '2025_01_05_095304_create_user_answers_table', 7),
(21, '2024_12_25_035910_create_exams_table', 8),
(22, '2025_01_05_094836_create_exam_attempts_table', 8),
(23, '2025_02_12_134619_create_exam_payments_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `qna_exams`
--

CREATE TABLE `qna_exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qna_exams`
--

INSERT INTO `qna_exams` (`id`, `exam_id`, `question_id`, `created_at`, `updated_at`) VALUES
(38, 1, 4, NULL, NULL),
(39, 1, 21, NULL, NULL),
(40, 1, 22, NULL, NULL),
(41, 2, 5, NULL, NULL),
(42, 2, 23, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `explaination` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `explaination`, `created_at`, `updated_at`) VALUES
(4, 'iwbdfwfffffff', NULL, NULL, '2025-01-03 13:06:45'),
(5, 'erhhreh', 'bollllllllll cccc bbb fffds', NULL, '2025-02-15 00:42:58'),
(22, 'Which of the following is an attribute of Table tag?', 'Cellpadding is correct', NULL, '2025-02-15 00:35:06'),
(23, 'Opening tag of HTML is called', 'Starting tag is same as opening tag', NULL, '2025-02-15 00:36:02');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subjectName` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subjectName`, `created_at`, `updated_at`) VALUES
(1, 'Science', NULL, NULL),
(2, 'Mathematics', NULL, '2025-02-15 00:31:05'),
(3, 'English', NULL, NULL),
(4, 'Bengali', NULL, NULL),
(5, 'Hindi', NULL, NULL),
(7, 'Urdu', NULL, '2025-02-15 00:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `is_verified`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Arif', 'arif@gmail.com', NULL, 1, '$2y$12$AcyyK7WDsjUIMnadof5wFejL/A.tWTOU4ydh7vMAVWkaR.tpDTp6u', NULL, '2025-01-01 07:42:45', '2025-01-01 07:42:45'),
(2, 'Raja', 'raja@gmail.com', NULL, 1, '$2y$12$AcyyK7WDsjUIMnadof5wFejL/A.tWTOU4ydh7vMAVWkaR.tpDTp6u', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attempt_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `answer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `attempt_id`, `question_id`, `answer_id`, `created_at`, `updated_at`) VALUES
(13, 1, 22, 100, NULL, NULL),
(14, 1, 4, 110, NULL, NULL),
(15, 1, 21, 94, NULL, NULL),
(16, 2, 23, 101, NULL, NULL),
(17, 2, 5, 14, NULL, NULL),
(18, 3, 23, 102, NULL, NULL),
(19, 3, 5, 14, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `emailverifications`
--
ALTER TABLE `emailverifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emailverifications_email_index` (`email`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_payments`
--
ALTER TABLE `exam_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qna_exams`
--
ALTER TABLE `qna_exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT for table `emailverifications`
--
ALTER TABLE `emailverifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `exam_attempts`
--
ALTER TABLE `exam_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_payments`
--
ALTER TABLE `exam_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `qna_exams`
--
ALTER TABLE `qna_exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
