-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2025 at 04:34 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php3_schooldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `OTP` int DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

-- INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `role_id`, `OTP`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
-- (1, 'Quản trị viên', 'admin@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', 1, 949124, NULL, NULL, NULL, '2024-12-25 06:19:57', NULL, NULL),
-- (2, 'Trần Trung Trực', 'trantrungtruc@gmail.com', NULL, 1, 744920, NULL, NULL, 1, '2024-12-23 00:16:57', NULL, NULL),
-- (3, 'Trần Trung Vình', 'vinh@gmail.com', NULL, 1, 725196, NULL, NULL, 1, '2024-12-23 00:17:16', NULL, NULL),
-- (4, 'Lâm Canh Tân', 'lamcanhtan@gmail.com', NULL, 1, 959782, NULL, NULL, 1, '2024-12-23 00:17:46', NULL, NULL),
-- (5, 'Hoắc Kiến Hoa', 'abc@gmail.com', NULL, 1, 691870, NULL, NULL, 1, '2024-12-23 00:18:04', NULL, NULL),
-- (6, 'Super Admin', 'superadmin@test.com', '$2y$12$sFb271aJhsn2PDVd/DNH9ewGrvrlwx3GU.F.vE7rHLYMqHJKD1F6y', 1, 310781, NULL, '2025-10-01 00:21:17', NULL, '2025-10-01 00:21:17', NULL, NULL),
-- (20, 'GV Demo All Classes', 'teacher.demo@tqsqk2.edu.vn', '$2y$12$qZnDnTi3yK1AxCmrQ6jRTeLJUH/ETzhi3zLOkvMBqs7WgxWOWqtKe', 3, NULL, NULL, '2025-10-16 01:43:44', NULL, '2025-10-16 01:43:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL DEFAULT '4',
  `reply_to` bigint UNSIGNED DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_reply` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

-- INSERT INTO `chats` (`id`, `student_id`, `role_id`, `reply_to`, `message`, `is_reply`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
-- (1, 1, 2, NULL, 'Hello, I need help with my assignment.', 1, NULL, '2024-09-26 08:00:33', NULL, '2025-04-27 23:23:06', NULL, NULL),
-- (2, NULL, 4, 1, 'Hello', 1, NULL, '2024-09-26 08:00:33', NULL, '2025-04-25 06:45:20', NULL, NULL),
-- (3, NULL, 4, 1, 'Bạn cần giúp gì', 1, NULL, '2024-10-04 08:44:47', NULL, '2025-04-25 06:45:20', NULL, NULL),
-- (4, 1, 2, NULL, 'Em cần đăng ký giấy ạ', 1, NULL, '2024-10-04 08:45:06', NULL, '2025-04-27 23:23:06', NULL, NULL),
-- (5, NULL, 4, 1, 'HHahhhhahha', 1, NULL, '2024-10-04 08:45:16', NULL, '2025-04-25 06:45:20', NULL, NULL),
-- (6, 2, 2, NULL, 'Hello', 1, NULL, '2024-10-04 08:54:17', NULL, '2025-04-25 06:44:30', NULL, NULL),
-- (7, 2, 2, NULL, 'LÊU LÊU', 1, NULL, '2024-10-04 08:54:42', NULL, '2025-04-25 06:44:30', NULL, NULL),
-- (8, 1, 2, NULL, 'Xin chào ạ', 1, NULL, '2025-04-25 06:34:15', NULL, '2025-04-27 23:23:06', NULL, NULL),
-- (9, NULL, 4, 1, 'Chào em, e cần hỗ trợ gì', 1, NULL, '2025-04-25 06:35:17', NULL, '2025-04-25 06:45:20', NULL, NULL),
-- (10, 3, 2, NULL, 'Em muốn đăng ký học vượt ạ.', 1, NULL, '2025-04-25 06:36:38', NULL, '2025-04-25 06:44:21', NULL, NULL),
-- (11, 4, 2, NULL, 'Em muốn đăng ký chương trình thể chất ạ.', 1, NULL, '2025-04-25 06:37:28', NULL, '2025-04-27 23:07:14', NULL, NULL),
-- (12, 5, 2, NULL, 'Em cần tư vấn trả nợ môn ạ', 1, NULL, '2025-04-25 06:37:54', NULL, '2025-04-27 23:20:45', NULL, NULL),
-- (13, NULL, 4, 1, 'Cứ nhắn nha.', 1, NULL, '2025-04-25 06:44:47', NULL, '2025-04-25 06:45:20', NULL, NULL),
-- (14, 1, 2, NULL, 'Em cần tư vấn đăng ký môn ạ', 1, NULL, '2025-04-27 23:21:20', NULL, '2025-04-27 23:23:06', NULL, NULL),
-- (15, NULL, 4, 1, 'Chào em, em thuộc chuyên ngành nào', 0, NULL, '2025-04-27 23:21:36', NULL, '2025-04-27 23:21:36', NULL, NULL),
-- (16, 1, 2, NULL, 'Dạ CNTT ạ', 1, NULL, '2025-04-27 23:21:46', NULL, '2025-04-27 23:23:06', NULL, NULL),
-- (17, NULL, 4, 1, 'Oki em', 0, NULL, '2025-04-27 23:21:52', NULL, '2025-04-27 23:21:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `major_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `description`, `major_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'QD101', 'Lớp quân sự cơ sở', 1, 3, NULL, 6, NULL, NULL, NULL),
(2, 'QD102', 'Lớp quân sự nâng cao', 1, 3, NULL, 6, NULL, NULL, NULL),
(3, 'QD103', 'Lớp chiến thuật', 1, 3, NULL, 6, NULL, NULL, NULL),
(4, 'QD104', 'Lớp huấn luyện thể chất', 1, 3, NULL, 6, NULL, NULL, NULL),
(5, 'QD105', 'Lớp võ thuật quân sự', 1, 3, NULL, 6, NULL, NULL, NULL),
(6, 'QD106', 'Lớp điều lệnh quân đội', 1, 3, NULL, 6, NULL, NULL, NULL),
(7, 'QD107', 'Lớp kỹ năng sinh tồn', 1, 3, NULL, 6, NULL, NULL, NULL),
(8, 'QD108', 'Lớp bắn súng và vũ khí', 1, 3, NULL, 6, NULL, NULL, NULL),
(9, 'QD109', 'Lớp quân y cơ bản', 1, 3, NULL, 6, NULL, NULL, NULL),
(10, 'QD110', 'Lớp trinh sát', 1, 3, NULL, 6, NULL, NULL, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classrooms`
--

INSERT INTO `classrooms` (`id`, `name`, `description`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES

(1, '101', 'Phòng học 101', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '102', 'Phòng học 102', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '103', 'Phòng học 103', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '104', 'Phòng học 104', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '105', 'Phòng học 105', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '201', 'Phòng học 201', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '202', 'Phòng học 202', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '203', 'Phòng học 203', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '204', 'Phòng học 204', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '205', 'Phòng học 205', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '301', 'Phòng học 301', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '302', 'Phòng học 302', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '303', 'Phòng học 303', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '304', 'Phòng học 304', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '305', 'Phòng học 305', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '60.6', 'Thao trường 60.6', 1, NULL, NULL, NULL, NULL, NULL, NULL);



-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `student_count` int NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_subjects`
--

INSERT INTO `class_subjects` (`id`, `class_id`, `subject_id`, `teacher_id`, `student_count`, `start_date`, `end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 2, 30, '2024-09-01', '2024-12-15', NULL, NULL, NULL),
(2, 2, 1, 1, 0, '2024-09-01', '2024-12-15', NULL, '2025-10-06 04:01:44', NULL),
(3, 1, 1, 5, 0, '2025-10-16', '2026-01-16', '2025-10-16 01:43:44', '2025-10-16 01:43:44', NULL),
(4, 2, 1, 5, 0, '2025-10-16', '2026-01-16', '2025-10-16 01:43:44', '2025-10-16 01:43:44', NULL),
(5, 3, 1, 5, 0, '2025-10-16', '2026-01-16', '2025-10-16 01:43:44', '2025-10-16 01:43:44', NULL),
(6, 4, 1, 5, 0, '2025-10-16', '2026-01-16', '2025-10-16 01:43:44', '2025-10-16 01:43:44', NULL),
(7, 5, 1, 5, 0, '2025-10-16', '2026-01-16', '2025-10-16 01:43:44', '2025-10-16 01:43:44', NULL),
(8, 6, 1, 5, 0, '2025-10-16', '2026-01-16', '2025-10-16 01:43:44', '2025-10-16 01:43:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `training_level` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Trình độ đào tạo',
  `major_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ngành đào tạo',
  `major_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mã ngành',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `training_level`, `major_name`, `major_code`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
-- Day là huong doi tuong dao tao
(1, 'HSQCH và NVCM-KT', 'Đại học', NULL, 'HSQCH-NVCM-KT', 'Mô tả đối tượng đào tạo HSQCH và NVCM-KT', 1, NOW(), NULL, NULL, NULL, NULL),
(2, 'SQDB', 'Đại học', NULL, 'SQDB', 'Mô tả đối tượng đào tạo SQDB', 1, NOW(), NULL, NULL, NULL, NULL),
(3, 'Bồi dưỡng cán bộ', 'Đại học', NULL, 'BDC', 'Mô tả đối tượng đào tạo Bồi dưỡng cán bộ', 1, NOW(), NULL, NULL, NULL, NULL),
(4, 'Giáo dục QP&AN', 'Đại học', NULL, 'GDQPAN', 'Mô tả đối tượng đào tạo Giáo dục QP&AN', 1, NOW(), NULL, NULL, NULL, NULL),
(5, 'Đào tạo ngành QSCS', 'Đại học', NULL, 'QSCS', 'Mô tả đối tượng đào tạo Đào tạo ngành QSCS', 1, NOW(), NULL, NULL, NULL, NULL);
-- --------------------------------------------------------

--
-- Table structure for table `create_teacher_evaluations`
--

CREATE TABLE `create_teacher_evaluations` (
  `id` bigint UNSIGNED NOT NULL,
  `class_subject_id` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `create_teacher_evaluations`
--

INSERT INTO `create_teacher_evaluations` (`id`, `class_subject_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 1, 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(2, 2, 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `code`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'QL', 'Ban Quân lực', 'Trưởng ban, Trợ lý, Nhân viên Thống kê, hồ sơ', 1, NULL, NULL),
(2, 'KH', 'Ban Kế hoạch', 'Trưởng ban, Trợ lý Kế hoạch, Trợ lý Đào tạo, Nhân viên Thống kê', 1, NULL, NULL),
(3, 'BĐVCHL', 'Ban Bảo đảm vật chất huấn luyện', 'Trưởng ban, Trợ lý, Nhân viên Bản đồ, Giảng đường, In ấn', 1, NULL, NULL),
(4, 'TOCHUC', 'Ban Tổ chức', 'Trưởng ban, Trợ lý, Nhân viên hồ sơ và thống kê', 1, NULL, NULL),
(5, 'CB', 'Ban Cán bộ', 'Trưởng ban, Trợ lý, Nhân viên hồ sơ, thống kê, CMSQ', 1, NULL, NULL),
(6, 'TH', 'Ban Tuyên huấn', 'Trưởng ban, Trợ lý, Nhân viên văn hóa cơ sở, Mỹ thuật, quay phim, chụp ảnh', 1, NULL, NULL),
(7, 'QN', 'Ban Quân nhu', 'Trưởng ban, Trợ lý, Nhân viên Thống kê, kiêm Thủ kho', 1, NULL, NULL),
(8, 'DT', 'Ban Doanh trại', 'Trưởng ban, Trợ lý, Nhân viên điện, nước', 1, NULL, NULL),
(9, 'QY', 'Ban Quân y', 'Trưởng ban, Nhân viên Quân y, Dược', 1, NULL, NULL),
(10, 'KT', 'Ban Kỹ thuật', 'Trưởng ban, Trợ lý Quân khí, Trợ lý Xe máy – Xăng dầu, Thủ kho xăng dầu', 1, NULL, NULL),
(11, 'KHQS', 'Ban Khoa học quân sự', 'Trưởng ban, Trợ lý KHQS, Nhân viên tư liệu, thư viện', 1, NULL, NULL),
(12, 'TAICHINH', 'Ban Tài chính', 'Trưởng ban, Nhân viên Tài chính, Thủ quỹ', 1, NULL, NULL);

-- -- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `class_subject_id` bigint UNSIGNED DEFAULT NULL,
  `lab_1` double DEFAULT NULL,
  `lab_2` double DEFAULT NULL,
  `assignment_1` double DEFAULT NULL,
  `lab_3` double DEFAULT NULL,
  `lab_4` double DEFAULT NULL,
  `assignment_2` double DEFAULT NULL,
  `final_exam` double DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `class_subject_id`, `lab_1`, `lab_2`, `assignment_1`, `lab_3`, `lab_4`, `assignment_2`, `final_exam`, `enrollment_date`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26', 3, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(2, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26', 3, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(3, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26', 3, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(4, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26', 3, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(5, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26', 3, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(6, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26', 3, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(7, 6, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-02', 6, '2025-10-01 23:18:40', NULL, '2025-10-01 23:18:40', NULL, NULL),
(8, 7, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-06', 6, '2025-10-06 04:47:20', NULL, '2025-10-06 04:47:20', NULL, NULL),
(9, 8, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-06', 6, '2025-10-06 04:47:20', NULL, '2025-10-06 04:47:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `code`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BCHT', 'Khoa BCHT', 'Bộ môn chiến thuật, Bộ môn Kỹ thuật, Bộ môn Quân sự chung', 1, NULL, NULL),
(2, 'BC', 'Khoa Binh chủng', 'Bộ môn Binh chủng chiến đấu, Bộ môn Binh chủng Bảo đảm, Bộ môn Thông tin', 1, NULL, NULL),
(3, 'KHXHNV', 'Khoa Khoa học Xã hội & Nhân văn', 'Bộ môn Lý luận MLN, TT HCM; Bộ môn CTĐ, CTCT; Bộ môn Cơ bản', 1, NULL, NULL),
(4, 'QSDP', 'Khoa Quân sự địa phương', 'Bộ môn Lịch sử quân sự, vận động quần chúng; Bộ môn Quân sự địa phương', 1, NULL, NULL),
(5, 'CMKT', 'Khoa Chuyên môn – Kỹ thuật', 'Bộ môn Hậu cần, Bộ môn Quân khí', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE `majors` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `standard` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `course_id`, `code`, `name`, `standard`, `status`, `created_at`, `updated_at`) VALUES
-- 1. HSQCH và NVCM-KT
-- HSQCH và NVCM-KT (3 tháng)
(1, 1, 'TĐT BB', 'Tiểu đội trưởng bộ binh', '3 tháng', 0, NULL, NULL),
(2, 1, 'TĐT ĐL', 'Tiểu đội trưởng đại liên', '3 tháng', 0, NULL, NULL),
(3, 1, 'TĐT TS', 'Tiểu đội trưởng trinh sát', '3 tháng', 0, NULL, NULL),
(4, 1, 'TĐT Co60mm', 'Tiểu đội trưởng cối 60mm', '3 tháng', 0, NULL, NULL),

-- HSQCH và NVCM-KT (4 tháng)
(5, 1, 'TĐT CB', 'Tiểu đội trưởng công binh', '4 tháng', 0, NULL, NULL),
(6, 1, 'TĐT TT VTĐ', 'Tiểu đội trưởng thông tin - vô tuyến điện', '4 tháng', 0, NULL, NULL),
(7, 1, 'TĐT TT HTĐ', 'Tiểu đội trưởng thông tin - hữu tuyến điện', '4 tháng', 0, NULL, NULL),
(8, 1, 'TĐT TT QB', 'Tiểu đội trưởng quân bưu', '4 tháng', 0, NULL, NULL),
(9, 1, 'KĐT Co82mm', 'Khẩu đội trưởng cối 82mm', '4 tháng', 0, NULL, NULL),
(10, 1, 'KĐT Co100mm', 'Khẩu đội trưởng cối 100mm', '4 tháng', 0, NULL, NULL),
(11, 1, 'KĐT SPG-9', 'Khẩu đội trưởng SPG-9 (ĐKZ-82)', '4 tháng', 0, NULL, NULL),

-- HSQCH và NVCM-KT (5 tháng)
(12, 1, 'KĐT PB', 'Khẩu đội trưởng pháo binh', '5 tháng', 0, NULL, NULL),
(13, 1, 'KĐTP PK 37-57mm', 'Khẩu đội trưởng pháo phòng không 37-57mm', '5 tháng', 0, NULL, NULL),
(14, 1, 'KĐT SMPK 12.7mm', 'Khẩu đội trưởng súng máy phòng không 12,7mm', '5 tháng', 0, NULL, NULL),

-- HSQCH và NVCM-KT (6 tháng)
(15, 1, 'NVQY', 'Nhân viên y tá đại đội', '6 tháng', 0, NULL, NULL),
(16, 1, 'NVBV', 'Nhân viên báo vụ', '6 tháng', 0, NULL, NULL),
-- 2. SQDB
-- SQDB (1 tháng)
(17, 2, 'SQDBCT', 'Chuyển loại SQDB chính trị', '1 tháng', 0, NULL, NULL),
(18, 2, 'SQDBBT', 'Chuyển loại bổ túc tiểu đoàn', '1 tháng', 0, NULL, NULL),
(19, 2, 'SQDBĐC', 'Chuyển loại SQDB đặc công', '1 tháng', 0, NULL, NULL),

-- SQDB (3 tháng)
(20, 2, 'SQDBBB', 'SQDB bộ binh', '3 tháng', 0, NULL, NULL),
(21, 2, 'SQDBBC', 'SQDB binh chủng (Pháo binh, PPK)', '3 tháng', 0, NULL, NULL),
(22, 2, 'SQDBTS', 'SQDB trinh sát', '3 tháng', 0, NULL, NULL),

-- SQDB (4 tháng)
(23, 2, 'SQDBB4', 'SQDB bộ binh (4 tháng)', '4 tháng', 0, NULL, NULL);
-- 3. Bồi dưỡng cán bộ
INSERT INTO `majors` (`id`, `course_id`, `code`, `name`, `standard`, `status`, `created_at`, `updated_at`) VALUES
(24, 3, 'BDKTQSĐP', 'Bồi dưỡng kiến thức QSĐP', 'Khác nhau', 0, NULL, NULL),
(25, 3, 'BDTM', 'Bồi dưỡng tiếng Mông', 'Khác nhau', 0, NULL, NULL),
(26, 3, 'BDTL', 'Bồi dưỡng tiếng Lào', 'Khác nhau', 0, NULL, NULL),
(27, 3, 'BDTT', 'Bồi dưỡng tiếng Trung', 'Khác nhau', 0, NULL, NULL),
(28, 3, 'BDQSCT3', 'Bồi dưỡng kiến thức QS-CT (3 tháng)', '3 tháng', 0, NULL, NULL),
(29, 3, 'BDQSCT4', 'Bồi dưỡng kiến thức QS-CT (4 tháng)', '4 tháng', 0, NULL, NULL);

-- 4. Giáo dục QP&AN
INSERT INTO `majors` (`id`, `course_id`, `code`, `name`, `standard`, `status`, `created_at`, `updated_at`) VALUES
(30, 4, 'ĐT2', 'Đối tượng 2', 'Khác nhau', 0, NULL, NULL),
(31, 4, 'ĐT3', 'Đối tượng 3', 'Khác nhau', 0, NULL, NULL),
(32, 4, 'ĐT4', 'Đối tượng 4', 'Khác nhau', 0, NULL, NULL),
(33, 4, 'GDQPAN-SV', 'GDQP&AN cho sinh viên (Cao đẳng, đại học)', 'Khác nhau', 0, NULL, NULL);

-- 5. Đào tạo ngành QSCS (ĐTĐT)
INSERT INTO `majors` (`id`, `course_id`, `code`, `name`, `standard`, `status`, `created_at`, `updated_at`) VALUES
(34, 5, 'ĐHCQ', 'Đại học chính quy', 'Khác nhau', 0, NULL, NULL),
(35, 5, 'CĐCQ', 'Cao đẳng chính quy', 'Khác nhau', 0, NULL, NULL),
(36, 5, 'LTCĐ-ĐH', 'Liên thông từ cao đẳng lên đại học', 'Vừa làm vừa học', 0, NULL, NULL),
(37, 5, 'LTTC-CĐ', 'Liên thông từ trung cấp lên cao đẳng', 'Vừa làm vừa học', 0, NULL, NULL),
(38, 5, 'ĐHVB2', 'Đại học văn bằng thứ 2', 'Khác nhau', 0, NULL, NULL),
(39, 5, 'TC', 'Trung cấp', 'Khác nhau', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_07_16_000000_create_roles_table', 1),
(5, '2024_07_16_000001_create_courses_table', 1),
(6, '2024_07_16_000001_create_majors_table', 1),
(7, '2024_07_16_000002_create_subjects_table', 1),
(8, '2024_07_16_000003_create_accounts_table', 1),
(9, '2024_07_16_000004_create_teachers_table', 1),
(10, '2024_07_16_000005_create_students_table', 1),
(11, '2024_07_16_000006_create_classes_table', 1),
(12, '2024_07_16_000006_create_classrooms_table', 1),
(13, '2024_07_16_000007_create_class_subjects_table', 1),
(14, '2024_07_16_000008_create_enrollments_table', 1),
(15, '2024_07_16_000009_create_schedules_table', 1),
(16, '2024_07_16_000010_create_create_teacher_evaluations_table', 1),
(17, '2024_07_16_000011_create_teacher_evaluations_table', 1),
(18, '2024_07_16_000012_create_chats_table', 1),
(19, '2024_07_24_054813_create_training_officer_accounts_table', 1),
(20, '2024_07_26_042910_create_school_shifts_table', 1),
(21, '2024_07_27_052708_2024_07_27_create_departments_tables', 1),
(22, '2024_07_27_052822_2024_07_27_create_subject_type_tables', 1),
(23, '2024_07_30_055735_create_study_statuses_table', 1),
(24, '2024_08_04_080256_create_sics_table', 1),
(25, '2024_08_06_112910_create_teaching_materials_table', 1),
(26, '2024_08_13_143837_create_user_infos_table', 1),
(27, '2025_09_27_030927_create_permissions_table', 2),
(28, '2025_09_27_030928_create_role_permissions_table', 2),
(29, '2025_09_27_030928_create_user_permissions_table', 2),
(30, '2025_10_01_073120_add_role_id_to_users_table', 3),
(31, '2025_10_01_121537_add_status_and_sort_order_to_roles_table', 4),
(32, '2025_10_02_024205_add_class_id_subject_id_to_schedules_table', 5),
(34, '2025_10_02_050726_add_audit_columns_to_schedules_table', 6),
(35, '2025_10_02_050940_fix_school_shift_id_type_in_schedules_table', 6),
(36, '2025_10_02_051454_add_schedule_date_to_schedules_table', 7),
(37, '2025_10_06_115233_add_teacher_id_to_schedules_table', 8),
(38, '2025_10_12_075711_create_score_sheets_table', 9),
(39, '2025_10_12_080101_modify_score_sheets_uploaded_by_nullable', 10),
(40, '2025_10_12_084338_create_pl_hdtl1_files_table', 11),
(41, '2025_10_12_102335_create_pl_hdtl2_files_table', 12),
(42, '2025_10_13_020008_remove_is_evaluation_from_class_subjects_table', 13),
(43, '2025_10_13_020338_add_department_id_to_training_officer_accounts_table', 14),
(44, '2025_10_13_021214_create_offices_table', 15),
(45, '2025_10_13_021230_create_faculties_table', 15),
(46, '2025_10_13_021235_create_divisions_table', 15),
(47, '2025_10_13_021338_add_office_faculty_division_to_training_officer_accounts_table', 15),
(48, '2025_10_13_023435_remove_department_id_from_training_officer_accounts_table', 16),
(49, '2025_10_13_023512_drop_departments_table', 17),
(50, '2025_10_13_024446_add_training_level_and_major_fields_to_courses_table', 18),
(51, '2025_10_14_030142_remove_unique_constraints_from_schedules_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `code`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TM-HC', 'Phòng Tham mưu – Hành chính', 'Phòng tham mưu và hành chính', 1, NULL, NULL),
(2, 'ĐT', 'Phòng Đào Tạo', 'Phòng quản lý đào tạo', 1, NULL, NULL),
(3, 'CT', 'Phòng Chính Trị', 'Phòng quản lý công tác chính trị', 1, NULL, NULL),
(4, 'HC-KT', 'Phòng Hậu Cần - Kỹ Thuật', 'Phòng quản lý hậu cần và kỹ thuật', 1, NULL, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'dashboard.view', 'Xem trang chủ', 'Quyền xem trang chủ admin', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(2, 'user.view', 'Xem danh sách người dùng', 'Quyền xem danh sách người dùng', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(3, 'user.create', 'Tạo người dùng', 'Quyền tạo người dùng mới', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(4, 'user.edit', 'Chỉnh sửa người dùng', 'Quyền chỉnh sửa thông tin người dùng', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(5, 'user.delete', 'Xóa người dùng', 'Quyền xóa người dùng', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(6, 'student.view', 'Xem danh sách học viên', 'Quyền xem danh sách học viên', '2025-10-01 00:11:03', '2025-10-01 01:52:19', NULL),
(7, 'student.create', 'Tạo học viên', 'Quyền tạo học viên mới', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(8, 'student.edit', 'Chỉnh sửa học viên', 'Quyền chỉnh sửa thông tin học viên', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(9, 'student.delete', 'Xóa học viên', 'Quyền xóa học viên', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(10, 'teacher.view', 'Xem danh sách giáo viên', 'Quyền xem danh sách giáo viên', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(11, 'teacher.create', 'Tạo giáo viên', 'Quyền tạo giáo viên mới', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(12, 'teacher.edit', 'Chỉnh sửa giáo viên', 'Quyền chỉnh sửa thông tin giáo viên', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(13, 'teacher.delete', 'Xóa giáo viên', 'Quyền xóa giáo viên', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(14, 'subject.view', 'Xem danh sách môn học', 'Quyền xem danh sách môn học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(15, 'subject.create', 'Tạo môn học', 'Quyền tạo môn học mới', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(16, 'subject.edit', 'Chỉnh sửa môn học', 'Quyền chỉnh sửa thông tin môn học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(17, 'subject.delete', 'Xóa môn học', 'Quyền xóa môn học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(18, 'class.view', 'Xem danh sách lớp học', 'Quyền xem danh sách lớp học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(19, 'class.create', 'Tạo lớp học', 'Quyền tạo lớp học mới', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(20, 'class.edit', 'Chỉnh sửa lớp học', 'Quyền chỉnh sửa thông tin lớp học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(21, 'class.delete', 'Xóa lớp học', 'Quyền xóa lớp học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(22, 'course.view', 'Xem danh sách khóa học', 'Quyền xem danh sách khóa học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(23, 'course.create', 'Tạo khóa học', 'Quyền tạo khóa học mới', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(24, 'course.edit', 'Chỉnh sửa khóa học', 'Quyền chỉnh sửa thông tin khóa học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(25, 'course.delete', 'Xóa khóa học', 'Quyền xóa khóa học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(26, 'role.view', 'Xem danh sách vai trò', 'Quyền xem danh sách vai trò', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(27, 'role.create', 'Tạo vai trò', 'Quyền tạo vai trò mới', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(28, 'role.edit', 'Chỉnh sửa vai trò', 'Quyền chỉnh sửa vai trò', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(29, 'role.delete', 'Xóa vai trò', 'Quyền xóa vai trò', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(30, 'permission.view', 'Xem danh sách quyền', 'Quyền xem danh sách quyền', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(31, 'permission.create', 'Tạo quyền', 'Quyền tạo quyền mới', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(32, 'permission.edit', 'Chỉnh sửa quyền', 'Quyền chỉnh sửa quyền', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(33, 'permission.delete', 'Xóa quyền', 'Quyền xóa quyền', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(34, 'enrollment.view', 'Xem danh sách đăng ký', 'Quyền xem danh sách đăng ký môn học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(35, 'enrollment.create', 'Tạo đăng ký', 'Quyền tạo đăng ký môn học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(36, 'enrollment.edit', 'Chỉnh sửa đăng ký', 'Quyền chỉnh sửa đăng ký môn học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(37, 'enrollment.delete', 'Xóa đăng ký', 'Quyền xóa đăng ký môn học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(38, 'schedule.view', 'Xem lịch học', 'Quyền xem lịch học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(39, 'schedule.create', 'Tạo lịch học', 'Quyền tạo lịch học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(40, 'schedule.edit', 'Chỉnh sửa lịch học', 'Quyền chỉnh sửa lịch học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(41, 'schedule.delete', 'Xóa lịch học', 'Quyền xóa lịch học', '2025-10-01 00:11:03', '2025-10-01 00:11:03', NULL),
(42, 'Student.read', 'xem tài liệu', 'aaa', '2025-10-01 01:51:11', '2025-10-01 01:51:25', '2025-10-01 01:51:25'),
(43, 'manage_users', 'Quản lý người dùng', 'Có thể tạo, sửa, xóa tài khoản người dùng', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(44, 'manage_roles', 'Quản lý vai trò', 'Có thể tạo, sửa, xóa vai trò', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(45, 'manage_permissions', 'Quản lý quyền', 'Có thể tạo, sửa, xóa quyền hạn', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(46, 'view_system_logs', 'Xem nhật ký hệ thống', 'Có thể xem nhật ký hoạt động hệ thống', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(47, 'manage_courses', 'Quản lý khóa học', 'Có thể tạo, sửa, xóa khóa học', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(48, 'manage_majors', 'Quản lý chuyên ngành', 'Có thể tạo, sửa, xóa chuyên ngành', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(49, 'manage_subjects', 'Quản lý môn học', 'Có thể tạo, sửa, xóa môn học', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(50, 'manage_classes', 'Quản lý lớp học', 'Có thể tạo, sửa, xóa lớp học', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(51, 'manage_classrooms', 'Quản lý phòng học', 'Có thể tạo, sửa, xóa phòng học', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(52, 'manage_schedules', 'Quản lý lịch học', 'Có thể tạo, sửa, xóa lịch học', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(53, 'manage_class_subjects', 'Quản lý lớp môn học', 'Có thể tạo, sửa, xóa lớp môn học', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(54, 'manage_students', 'Quản lý học viên', 'Có thể tạo, sửa, xóa thông tin học viên', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(55, 'view_student_info', 'Xem thông tin học viên', 'Có thể xem thông tin chi tiết học viên', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(56, 'manage_enrollments', 'Quản lý đăng ký học', 'Có thể quản lý đăng ký học của học viên', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(57, 'manage_teachers', 'Quản lý giáo viên', 'Có thể tạo, sửa, xóa thông tin giáo viên', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(58, 'view_teacher_info', 'Xem thông tin giáo viên', 'Có thể xem thông tin chi tiết giáo viên', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(59, 'manage_teacher_schedules', 'Quản lý lịch dạy', 'Có thể quản lý lịch dạy của giáo viên', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(60, 'manage_scores', 'Quản lý điểm số', 'Có thể nhập, sửa, xóa điểm số', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(61, 'view_scores', 'Xem điểm số', 'Có thể xem điểm số của học viên', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(62, 'export_scores', 'Xuất báo cáo điểm', 'Có thể xuất báo cáo điểm số', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(63, 'manage_evaluations', 'Quản lý đánh giá', 'Có thể tạo, quản lý đánh giá giáo viên', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(64, 'view_evaluations', 'Xem đánh giá', 'Có thể xem kết quả đánh giá giáo viên', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(65, 'manage_chats', 'Quản lý chat', 'Có thể quản lý hệ thống chat', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(66, 'view_chats', 'Xem chat', 'Có thể xem và trả lời chat', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(67, 'view_reports', 'Xem báo cáo', 'Có thể xem các báo cáo thống kê', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(68, 'export_reports', 'Xuất báo cáo', 'Có thể xuất các báo cáo', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(69, 'view_statistics', 'Xem thống kê', 'Có thể xem thống kê hệ thống', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(70, 'manage_materials', 'Quản lý tài liệu', 'Có thể tạo, sửa, xóa tài liệu học tập', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(71, 'view_materials', 'Xem tài liệu', 'Có thể xem và tải tài liệu học tập', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(72, 'manage_training_officers', 'Quản lý cán bộ đào tạo', 'Có thể tạo, sửa, xóa cán bộ đào tạo', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(73, 'view_training_officers', 'Xem cán bộ đào tạo', 'Có thể xem thông tin cán bộ đào tạo', '2025-10-01 04:25:39', '2025-10-01 04:25:39', NULL),
(75, 'Student.aaa2222', 'aaaa222', 'aaa', '2025-10-01 04:49:26', '2025-10-06 02:20:29', '2025-10-06 02:20:29'),
(76, 'Student.read2025', 'xem tài liệu 22025', 'học sinh xem tài liệu', '2025-10-01 06:30:11', '2025-10-06 02:20:33', '2025-10-06 02:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `pl_hdtl1_files`
--

CREATE TABLE `pl_hdtl1_files` (
  `id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NOT NULL,
  `file_type` enum('kqhttx','kqrl','ngay_cong','dieu_chinh','ren_luyen_kha','hoc_gioi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('public','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hidden',
  `uploaded_by` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pl_hdtl2_files`
--

CREATE TABLE `pl_hdtl2_files` (
  `id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint NOT NULL,
  `file_extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('public','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hidden',
  `uploaded_by` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `status`, `sort_order`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'Quản trị viên', 'Quản Trị Viên', 'Quản trị viên hệ thống', 'active', 1, NULL, '2025-09-26 00:27:53', NULL, '2025-10-06 02:12:11', NULL, NULL),
(2, 'Học viên', 'Sinh Viên', 'Sinh viên trong hệ thống', 'active', 2, NULL, '2025-09-18 00:27:53', 6, '2025-10-06 02:12:20', NULL, NULL),
(3, 'Giảng viên', 'Giảng Viên', 'Giảng viên trong hệ thống', 'active', 3, NULL, '2025-09-14 00:27:53', NULL, '2025-10-06 02:12:28', NULL, NULL),
(14, 'Admin', NULL, 'Quản Lý Toàn Bộ Website', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Student', NULL, 'Tham Gia Khóa Học, Xem Điểm, Xem Lớp Học Và Đánh Giá Giáo Viên', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Teacher', NULL, 'Xem Lịch Dạy, Nhập Điểm, Điểm Danh', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Training Officer', NULL, 'Sắp Xếp Lịch Huấn Luyện, Giải Đáp Thắc Mắc Của Sinh Viên', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Admin', NULL, 'Quản Lý Toàn Bộ Website', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Student', NULL, 'Tham Gia Khóa Học, Xem Điểm, Xem Lớp Học Và Đánh Giá Giáo Viên', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Teacher', NULL, 'Xem Lịch Dạy, Nhập Điểm, Điểm Danh', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Training Officer', NULL, 'Sắp Xếp Lịch Huấn Luyện, Giải Đáp Thắc Mắc Của Sinh Viên', 'active', 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(95, 1, 1, NULL, NULL),
(96, 1, 2, NULL, NULL),
(97, 1, 3, NULL, NULL),
(98, 1, 4, NULL, NULL),
(99, 1, 5, NULL, NULL),
(100, 1, 6, NULL, NULL),
(101, 1, 7, NULL, NULL),
(102, 1, 8, NULL, NULL),
(103, 1, 9, NULL, NULL),
(104, 1, 10, NULL, NULL),
(105, 1, 11, NULL, NULL),
(106, 1, 12, NULL, NULL),
(107, 1, 13, NULL, NULL),
(108, 1, 14, NULL, NULL),
(109, 1, 15, NULL, NULL),
(110, 1, 16, NULL, NULL),
(111, 1, 17, NULL, NULL),
(112, 1, 18, NULL, NULL),
(113, 1, 19, NULL, NULL),
(114, 1, 20, NULL, NULL),
(115, 1, 21, NULL, NULL),
(116, 1, 22, NULL, NULL),
(117, 1, 23, NULL, NULL),
(118, 1, 24, NULL, NULL),
(119, 1, 25, NULL, NULL),
(120, 1, 26, NULL, NULL),
(121, 1, 27, NULL, NULL),
(122, 1, 28, NULL, NULL),
(123, 1, 29, NULL, NULL),
(124, 1, 30, NULL, NULL),
(125, 1, 31, NULL, NULL),
(126, 1, 32, NULL, NULL),
(127, 1, 33, NULL, NULL),
(128, 1, 34, NULL, NULL),
(129, 1, 35, NULL, NULL),
(130, 1, 36, NULL, NULL),
(131, 1, 37, NULL, NULL),
(132, 1, 38, NULL, NULL),
(133, 1, 39, NULL, NULL),
(134, 1, 40, NULL, NULL),
(135, 1, 41, NULL, NULL),
(183, 1, 43, NULL, NULL),
(184, 1, 44, NULL, NULL),
(185, 1, 45, NULL, NULL),
(186, 1, 46, NULL, NULL),
(187, 1, 47, NULL, NULL),
(188, 1, 48, NULL, NULL),
(189, 1, 49, NULL, NULL),
(190, 1, 50, NULL, NULL),
(191, 1, 51, NULL, NULL),
(192, 1, 52, NULL, NULL),
(193, 1, 53, NULL, NULL),
(194, 1, 54, NULL, NULL),
(195, 1, 55, NULL, NULL),
(196, 1, 56, NULL, NULL),
(197, 1, 57, NULL, NULL),
(198, 1, 58, NULL, NULL),
(199, 1, 59, NULL, NULL),
(200, 1, 60, NULL, NULL),
(201, 1, 61, NULL, NULL),
(202, 1, 62, NULL, NULL),
(203, 1, 63, NULL, NULL),
(204, 1, 64, NULL, NULL),
(205, 1, 65, NULL, NULL),
(206, 1, 66, NULL, NULL),
(207, 1, 67, NULL, NULL),
(208, 1, 68, NULL, NULL),
(209, 1, 69, NULL, NULL),
(210, 1, 70, NULL, NULL),
(211, 1, 71, NULL, NULL),
(212, 1, 72, NULL, NULL),
(213, 1, 73, NULL, NULL),
(214, 3, 58, NULL, NULL),
(215, 3, 59, NULL, NULL),
(216, 3, 60, NULL, NULL),
(217, 3, 61, NULL, NULL),
(218, 3, 55, NULL, NULL),
(219, 3, 64, NULL, NULL),
(220, 3, 71, NULL, NULL),
(221, 3, 66, NULL, NULL),
(222, 2, 55, NULL, NULL),
(223, 2, 61, NULL, NULL),
(224, 2, 64, NULL, NULL),
(225, 2, 71, NULL, NULL),
(226, 2, 66, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `class_subject_id` bigint UNSIGNED DEFAULT NULL,
  `room_id` bigint UNSIGNED DEFAULT NULL,
  `school_shift_id` bigint UNSIGNED NOT NULL,
  `day_of_week` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_date` date DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `class_id`, `subject_id`, `teacher_id`, `class_subject_id`, `room_id`, `school_shift_id`, `day_of_week`, `schedule_date`, `created_by`, `created_at`, `updated_at`, `updated_by`, `deleted_by`, `deleted_at`) VALUES
(20, 1, 1, 1, NULL, 1, 2, 'Thứ 5', '2025-10-16', 6, '2025-10-16 01:04:54', '2025-10-16 01:04:54', NULL, NULL, NULL),
(21, 1, 3, 1, NULL, 1, 3, 'Thứ 5', '2025-10-16', 6, '2025-10-16 01:42:35', '2025-10-16 01:42:35', NULL, NULL, NULL),
(22, 1, 1, 1, NULL, 2, 1, 'Thứ 5', '2025-10-16', 6, '2025-10-16 01:52:26', '2025-10-16 01:52:26', NULL, NULL, NULL),
(26, 5, 1, 1, NULL, 2, 3, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:33:16', '2025-10-16 09:33:16', NULL, NULL, NULL),
(27, 6, 1, 1, NULL, 2, 3, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:33:32', '2025-10-16 09:33:32', NULL, NULL, NULL),
(28, 3, 1, 4, NULL, 2, 3, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:34:04', '2025-10-16 09:34:04', NULL, NULL, NULL),
(29, 4, 1, 2, NULL, 2, 3, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:34:30', '2025-10-16 09:34:30', NULL, NULL, NULL),
(30, 2, 1, 3, NULL, 4, 3, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:34:59', '2025-10-16 09:34:59', NULL, NULL, NULL),
(31, 5, 1, 2, NULL, 2, 4, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:35:32', '2025-10-16 09:35:32', NULL, NULL, NULL),
(32, 1, 3, 1, NULL, 2, 4, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:39:18', '2025-10-16 09:39:18', NULL, NULL, NULL),
(33, 1, 3, 1, NULL, 5, 5, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:39:45', '2025-10-16 09:39:45', NULL, NULL, NULL),
(34, 3, 1, 3, NULL, 2, 2, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:46:12', '2025-10-16 09:46:12', NULL, NULL, NULL),
(35, 5, 1, 1, NULL, 1, 1, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:48:51', '2025-10-16 09:48:51', NULL, NULL, NULL),
(36, 3, 1, 2, NULL, 2, 1, 'Thứ 5', '2025-10-16', 6, '2025-10-16 09:50:27', '2025-10-16 09:50:27', NULL, NULL, NULL),
(37, 6, 1, 2, NULL, 2, 2, 'Thứ 7', '2025-10-18', 6, '2025-10-16 10:05:18', '2025-10-16 10:05:18', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_shifts`
--

CREATE TABLE `school_shifts` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `shift_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_shifts`
--

INSERT INTO `school_shifts` (`id`, `code`, `name`, `description`, `start_time`, `end_time`, `shift_date`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
-- =======================
-- Mùa Nóng
-- =======================
(1, 'TIET1-NONG', 'Tiết 1', 'Tiết 1 mùa nóng', '06:30:00', '07:15:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'TIET2-NONG', 'Tiết 2', 'Tiết 2 mùa nóng', '07:20:00', '08:05:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'TIET3-NONG', 'Tiết 3', 'Tiết 3 mùa nóng', '08:15:00', '09:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'TIET4-NONG', 'Tiết 4', 'Tiết 4 mùa nóng', '09:05:00', '09:50:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'TIET5-NONG', 'Tiết 5', 'Tiết 5 mùa nóng', '10:00:00', '10:45:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'TIET6-NONG', 'Tiết 6', 'Tiết 6 mùa nóng', '10:50:00', '11:35:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'TIET7-NONG', 'Tiết 7', 'Tiết 7 mùa nóng', '14:00:00', '14:45:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'TIET8-NONG', 'Tiết 8', 'Tiết 8 mùa nóng', '14:50:00', '15:35:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'TIET9-NONG', 'Tiết 9', 'Tiết 9 mùa nóng', '15:45:00', '16:30:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),

-- =======================
-- Mùa Lạnh
-- =======================
(10, 'TIET1-LANH', 'Tiết 1', 'Tiết 1 mùa lạnh', '06:45:00', '07:30:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'TIET2-LANH', 'Tiết 2', 'Tiết 2 mùa lạnh', '07:35:00', '08:20:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'TIET3-LANH', 'Tiết 3', 'Tiết 3 mùa lạnh', '08:30:00', '09:15:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'TIET4-LANH', 'Tiết 4', 'Tiết 4 mùa lạnh', '09:20:00', '10:05:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'TIET5-LANH', 'Tiết 5', 'Tiết 5 mùa lạnh', '10:15:00', '11:00:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'TIET6-LANH', 'Tiết 6', 'Tiết 6 mùa lạnh', '11:05:00', '11:45:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'TIET7-LANH', 'Tiết 7', 'Tiết 7 mùa lạnh', '13:45:00', '14:30:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'TIET8-LANH', 'Tiết 8', 'Tiết 8 mùa lạnh', '14:35:00', '15:20:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'TIET9-LANH', 'Tiết 9', 'Tiết 9 mùa lạnh', '15:30:00', '16:15:00', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `score_sheets`
--

CREATE TABLE `score_sheets` (
  `id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('public','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hidden',
  `uploaded_by` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qYm91iXwHyg3QTXkaV9fCAijagjOCDeoVoN65P4c', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTFJUNkptZjh6Ulltdk5KZFhnYmtNWVNMcTNSMHdTVEhSeXdIc1ZadCI7czoxODoiZmxhc2hlcjo6ZW52ZWxvcGVzIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760629872),
('QZ3xfGGGd4nAQ1aWRLRWYip6HLShFpsCSmJkCONs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YToxMjp7czo2OiJfdG9rZW4iO3M6NDA6InB6cFZGSm5BclZxcGsyZnF4eGVkQmNOMFJvTVRlODdpZjJMYVdxWXkiO3M6MTg6ImZsYXNoZXI6OmVudmVsb3BlcyI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC93cC1hZG1pbi90ZWFjaGluZ19zY2hlZHVsZS9pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MjE6InByZWZpbGxfc2NoZWR1bGVfZGF0ZSI7czoxMDoiMjAyNS0xMC0xNiI7czoxNjoicHJlZmlsbF9jbGFzc19pZCI7aTo2O3M6MTg6InByZWZpbGxfc3ViamVjdF9pZCI7aToxO3M6MTg6InByZWZpbGxfc2hpZnRfbmFtZSI7czo0OiJDYSAzIjtzOjc6InVzZXJfaWQiO2k6NjtzOjEwOiJ1c2VyX2VtYWlsIjtzOjE5OiJzdXBlcmFkbWluQHRlc3QuY29tIjtzOjk6InVzZXJfcm9sZSI7aToxO3M6OToidXNlcl9uYW1lIjtzOjExOiJTdXBlciBBZG1pbiI7fQ==', 1760636488);

-- --------------------------------------------------------

--
-- Table structure for table `sics`
--

CREATE TABLE `sics` (
  `id` bigint UNSIGNED NOT NULL,
  `class_subject_id` bigint UNSIGNED DEFAULT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sics`
--

INSERT INTO `sics` (`id`, `class_subject_id`, `student_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 2, 1, NULL, NULL),
(6, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_code` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint NOT NULL,
  `date_of_birth` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint UNSIGNED DEFAULT NULL,
  `major_id` bigint UNSIGNED DEFAULT NULL,
  `cccd_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cccd_issue_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cccd_place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_of_enrollment` timestamp NULL DEFAULT NULL,
  `study_status_id` bigint UNSIGNED DEFAULT NULL,
  `semesters` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT '2',
  `OTP` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `student_code`, `gender`, `date_of_birth`, `email`, `password`, `address`, `course_id`, `major_id`, `cccd_number`, `cccd_issue_date`, `cccd_place`, `year_of_enrollment`, `study_status_id`, `semesters`, `phone`, `role_id`, `OTP`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'Nguyễn Đức Hùng', '000001', 0, '2004-09-25 17:00:00', 'sinhvien@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', 'Cần Thơ', 1, 3, '388240681537', '2024-09-25 17:00:00', 'Kiên Giang', '2025-03-25 17:00:00', 1, '6', '0945567048', 2, '463941', 1,  NULL, NULL, NULL, NULL, NULL),
(2, 'ĐQ Phúc', '000002', 0, '2004-09-25 17:00:00', 'sinhvien1@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', 'Ninh Bình', 1, 3, '388240681537', '2024-09-25 17:00:00', 'Ninh Bình', '2025-03-25 17:00:00', 1, '6', '0945567048', 2, '463941', 1,  NULL, NULL, NULL, NULL, NULL),
(3, 'Nguyễn Xuân Toàn', '000003', 0, '2004-09-25 17:00:00', 'sinhvien2@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', 'Cà Mau', 1, 3, '388240681537', '2024-09-25 17:00:00', 'Cà Mau', '2025-03-25 17:00:00', 1, '6', '0945567048', 2, '463941', 1,  NULL, NULL, NULL, NULL, NULL),
(4, 'Đào Văn Biên', '000004', 0, '2004-09-25 17:00:00', 'sinhvien3@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', 'An Giang', 1, 3, '388240681537', '2024-09-25 17:00:00', 'An Giang', '2025-03-25 17:00:00', 1, '6', '0945567048', 2, '463941', 1,  NULL, NULL, NULL, NULL, NULL),
(5, 'Đàm Quang Anh', '000005', 0, '2004-09-25 17:00:00', 'sinhvien4@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', 'Đồng Nai', 1, 3, '388240681537', '2024-09-25 17:00:00', 'Đồng Nai', '2025-03-25 17:00:00', 1, '6', '0945567048', 2, '463941', 1,  NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `study_statuses`
--

CREATE TABLE `study_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `study_statuses`
--

INSERT INTO `study_statuses` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Đi học (HDI)', '', NULL, NULL),
(2, 'Học lại (HHO)', '', NULL, NULL),
(3, 'Bảo lưu (HBA)', '', NULL, NULL),
(4, 'Nghỉ học (HNG)', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `major_id` bigint UNSIGNED NOT NULL,
  `subject_type_id` bigint UNSIGNED NOT NULL,
  `coure_id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_num` int NOT NULL,
  `total_class_session` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `major_id`, `subject_type_id`, `coure_id`, `code`, `name`, `credit_num`, `total_class_session`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'TL-M-L', 'Triết học Mác - Lênin', 6, 0, 1, NULL, NULL),
(2, 1, 1, 1, 'KT-M-L', 'Kinh tế chính trị Mác - Lênin', 5, 0, 1, NULL, NULL),
(3, 1, 1, 1, 'CNXH-KH', 'Chủ nghĩa xã hội khoa học', 4, 0, 1, NULL, NULL),
(4, 1, 1, 1, 'TTHCM', 'Tư tưởng Hồ Chí Minh', 4, 0, 1, NULL, NULL),
(5, 1, 1, 1, 'LS-ĐCSVN', 'Lịch sử Đảng Cộng sản Việt Nam', 4, 0, 1, NULL, NULL),
(6, 1, 1, 1, 'LGH', 'Lôgic học', 2, 0, 1, NULL, NULL),
(7, 1, 1, 1, 'NN-PL', 'Nhà nước và pháp luật', 3, 0, 1, NULL, NULL),
(8, 1, 1, 1, 'CSVH-VN', 'Cơ sở văn hoá Việt Nam', 2, 0, 1, NULL, NULL),
(9, 1, 1, 1, 'ĐĐH', 'Đạo đức học', 2, 0, 1, NULL, NULL),
(10, 1, 1, 1, 'DT-TR', 'Dân tộc, tôn giáo học', 2, 0, 1, NULL, NULL),
(11, 1, 2, 1, 'TL-QS', 'Tâm lý học quân sự', 3, 0, 1, NULL, NULL),
(12, 1, 2, 1, 'GD-QS', 'Giáo dục học quân sự', 2, 0, 1, NULL, NULL),
(13, 1, 2, 1, 'TA-NGA', 'Tiếng Nga', 10, 0, 1, NULL, NULL),
(14, 1, 2, 1, 'TOAN-CC', 'Toán cao cấp', 4, 0, 1, NULL, NULL),
(15, 1, 2, 1, 'TIN-HOC', 'Tin học', 3, 0, 1, NULL, NULL),
(16, 1, 2, 1, 'VL-ĐH', 'Vật lý đại cương', 3, 0, 1, NULL, NULL),
(17, 1, 2, 1, 'HOA-ĐH', 'Hoá đại cương', 2, 0, 1, NULL, NULL),
(18, 1, 2, 1, 'HL-TC', 'Huấn luyện thể chất', 3, 0, 1, NULL, NULL),
-- Kiến thức giáo dục chuyên nghiệp: cơ sở nhóm ngành
(19, 1, 3, 1, 'KT-BC-BB', 'Kỹ thuật chiến đấu bộ binh', 3, 0, 1, NULL, NULL),
(20, 1, 3, 1, 'ĐL-BĐ-BĐ', 'Điều lệnh đội ngũ, quản lý bộ đội', 3, 0, 1, NULL, NULL),
(21, 1, 3, 1, 'QS-C', 'Quân sự chung', 2, 0, 1, NULL, NULL),
(22, 1, 3, 1, 'PP-HL-QS', 'Phương pháp chung huấn luyện quân sự', 2, 0, 1, NULL, NULL),
(23, 1, 3, 1, 'HL', 'Hậu cần', 3, 0, 1, NULL, NULL),
(24, 1, 3, 1, 'ĐỊA-HS-QS', 'Địa hình quân sự', 4, 0, 1, NULL, NULL),
(25, 1, 3, 1, 'LS-ĐL-QS', 'Lịch sử đường lối quân sự', 2, 0, 1, NULL, NULL),
-- Kiến thức ngành
(26, 1, 3, 1, 'TOAN-UD', 'Toán ứng dụng (Lý thuyết xác suất và tối ưu)', 3, 0, 1, NULL, NULL),
(27, 1, 3, 1, 'XE-QS-LGT', 'Xe quân sự, Luật giao thông', 2, 0, 1, NULL, NULL),
(28, 1, 3, 1, 'THUAT-PH', 'Thuật phóng', 2, 0, 1, NULL, NULL),
(29, 1, 3, 1, 'TT-TCDT', 'Thông tin, tác chiến ĐT', 2, 0, 1, NULL, NULL),
(30, 1, 3, 1, 'KT-ĐĐ', 'Khí tài và đo đạc', 6, 0, 1, NULL, NULL),
(31, 1, 3, 1, 'TRINH-SAT', 'Trinh sát', 5, 0, 1, NULL, NULL),
(32, 1, 3, 1, 'TEN-LUA-MT', 'Tên lửa mặt đất, tên lửa chống tăng', 2, 0, 1, NULL, NULL),
(33, 1, 3, 1, 'CT-ĐP-CT', 'Công tác Đảng, công tác chính trị', 12, 0, 1, NULL, NULL),
(34, 1, 3, 1, 'CT-BCHH', 'Chiến thuật Binh chủng hợp thành (có quân sự địa phương)', 5, 0, 1, NULL, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `subject_types`
--

CREATE TABLE `subject_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_types`
--

INSERT INTO `subject_types` (`id`, `name`, `note`, `created_at`, `updated_at`) VALUES
(1, 'Học trực tiếp', 'Học trực tiếp', NULL, NULL),
(2, 'Học trực tuyến', 'Học trực tuyến', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy',
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `qualifications` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cccd_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cccd_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `course_id` bigint UNSIGNED DEFAULT NULL,
  `majors_id` bigint UNSIGNED DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `OTP` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `code`, `name`, `image`, `email`, `password`, `phone`, `address`, `current_address`, `gender`, `date_of_birth`, `qualifications`, `cccd_front`, `cccd_back`, `bio`, `course_id`, `majors_id`, `role_id`, `OTP`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, '000001', 'Nguyễn Vũ Dương', NULL, 'giangvien@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', '0945567048', '123 Main St, Anytown, USA', '123 Current St, Anytown, USA', 'male', '1980-01-01', 'MSc in Education', 'cccd_front_T001.jpg', 'cccd_back_T001.jpg', 'An experienced teacher with over 20 years in the education field.', 1, 1, 3, '332456', NULL, NULL, NULL, '2025-10-16 09:27:17', NULL, NULL),
(2, '000002', 'Nguyễn Văn Toàn', NULL, 'nguyenphuc@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', '0945567048', '123 Main St, Anytown, USA', '123 Current St, Anytown, USA', 'Male', '1980-01-01', 'MSc in Education', 'cccd_front_T001.jpg', 'cccd_back_T001.jpg', 'An experienced teacher with over 20 years in the education field.', 1, NULL, 3, '655687', NULL, NULL, NULL, NULL, NULL, NULL),
(3, '000003', 'Nguyễn Văn A', NULL, 'caobaquat@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', '0945567048', '123 Main St, Anytown, USA', '123 Current St, Anytown, USA', 'Male', '1980-01-01', 'MSc in Education', 'cccd_front_T001.jpg', 'cccd_back_T001.jpg', 'An experienced teacher with over 20 years in the education field.', 1, NULL, 3, '726645', NULL, NULL, NULL, NULL, NULL, NULL),
(4, '000004', 'Nguyễn Đức Hùng', NULL, 'Tonthatthieu@gmail.com', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', '0945567048', '123 Main St, Anytown, USA', '123 Current St, Anytown, USA', 'Male', '1980-01-01', 'MSc in Education', 'cccd_front_T001.jpg', 'cccd_back_T001.jpg', 'An experienced teacher with over 20 years in the education field.', 1, NULL, 3, '666505', NULL, NULL, NULL, NULL, NULL, NULL),
(5, '000005', 'Nguyễn Văn B', NULL, 'teacher.demo@tqsqk2.edu.vn', '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy', '0000000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '893174', NULL, '2025-10-16 01:43:44', NULL, '2025-10-16 01:43:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_evaluations`
--

CREATE TABLE `teacher_evaluations` (
  `id` bigint UNSIGNED NOT NULL,
  `create_teacher_evaluation_id` bigint UNSIGNED DEFAULT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `first_rating_level` int DEFAULT NULL,
  `second_rating_level` int DEFAULT NULL,
  `third_rating_level` int DEFAULT NULL,
  `fourth_rating_level` int DEFAULT NULL,
  `fifth_rating_level` int DEFAULT NULL,
  `evaluation_date` date DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_evaluations`
--

INSERT INTO `teacher_evaluations` (`id`, `create_teacher_evaluation_id`, `student_id`, `first_rating_level`, `second_rating_level`, `third_rating_level`, `fourth_rating_level`, `fifth_rating_level`, `evaluation_date`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 1, 1, 4, 5, 3, 4, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(2, 1, 2, 4, 5, 3, 4, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(3, 1, 3, 4, 5, 3, 4, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(4, 1, 4, 3, 4, 3, 4, 4, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(5, 1, 5, 5, 4, 4, 5, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(6, 1, 6, 2, 3, 2, 3, 4, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(7, 1, 7, 4, 4, 4, 5, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(8, 1, 8, 3, 3, 4, 4, 3, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(9, 1, 9, 5, 4, 5, 4, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(10, 1, 10, 2, 2, 3, 2, 3, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(11, 2, 11, 3, 4, 5, 3, 4, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(12, 2, 12, 4, 5, 4, 5, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(13, 2, 13, 3, 4, 3, 4, 4, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(14, 2, 14, 5, 4, 5, 5, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(15, 2, 15, 4, 4, 4, 3, 4, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(16, 2, 16, 2, 2, 3, 2, 3, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(17, 2, 17, 4, 4, 5, 4, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(18, 2, 18, 3, 4, 3, 4, 3, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(19, 2, 19, 5, 5, 4, 5, 5, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL),
(20, 2, 20, 2, 3, 2, 3, 2, '2024-09-26', 1, '2024-09-26 08:00:33', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teaching_materials`
--

CREATE TABLE `teaching_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `officer_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teaching_materials`
--

INSERT INTO `teaching_materials` (`id`, `officer_id`, `course_id`, `title`, `description`, `file_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 1, 'Giáo trình nhập môn lập trình C', 'Giáo trình nhập môn lập trình C', 'http://drive.google.com/drive/folders/1WP2iliiERNUftglc9Ku7Gym2GLPRF?usp=sharing', '2025-04-27 22:33:58', '2025-04-27 22:33:58', NULL),
(2, 2, 1, 'Giáo trình Triết học mác - lênin', 'Giáo trình\r\nTriết học mác - lênin (Dùng trong các trường đại học, cao đẳng)\r\n(Tái bản lần thứ ba có sửa chữa, bổ sung)', 'https://drive.google.com/file/d/0B0PpPgJNsronbEs3Tk4wOHRXVWs/edit?resourcekey=0-KrWaA-u_79bk7hZnnqpAcQ', '2025-04-27 22:34:55', '2025-04-27 22:34:55', NULL),
(3, 5, 1, 'Giáo trình Lập trình Hướng đối tượng', 'Giáo trình Nhập môn lập trình được biên soạn dựa theo đề cương của môn học Nhập môn lập trình đang được giảng dạy tại Trường Đại học Công nghệ Thông tin', 'https://docx.com.vn/tai-lieu/giao-trinh-lap-trinh-huong-doi-tuong-truong-dai-hoc-bach-khoa-ha-noi-126543', '2025-04-27 22:39:07', '2025-04-27 22:39:07', NULL),
(4, 4, 4, 'GIÁO TRÌNH KẾ TOÁN', 'GIÁO TRÌNH KẾ TOÁN', 'https://vinatrain.edu.vn/tai-lieu-tu-hoc-ke-toan/', '2025-04-27 23:19:47', '2025-04-27 23:19:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `training_officer_accounts`
--

CREATE TABLE `training_officer_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '$2y$10$gNqpUK/kVtPA6hw9j/k.X.ssG0/fgc0xZUM5f4cQF6x3Qe6T.dQfy',
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hometown` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office_id` bigint UNSIGNED DEFAULT NULL,
  `faculty_id` bigint UNSIGNED DEFAULT NULL,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT '4',
  `OTP` int DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- --------------------------------------------------------
INSERT INTO `training_officer_accounts` (`id`, `name`, `email`)
VALUES
(2, 'Officer 2', 'officer2@gmail.com'),
(4, 'Officer 4', 'officer4@gmail.com'),
(5, 'Officer 5', 'officer5@gmail.com');
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_infos`
--

CREATE TABLE `user_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `age` int DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ward` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doe` date DEFAULT NULL,
  `cccd_front_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cccd_back_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_infos`
--

INSERT INTO `user_infos` (`id`, `name`, `date_of_birth`, `age`, `gender`, `id_number`, `nationality`, `home`, `address`, `province`, `district`, `ward`, `street`, `doe`, `cccd_front_image`, `cccd_back_image`, `created_at`, `updated_at`) VALUES
(1, 'NGUYỄN MINH QUÂN', '2004-09-09', 20, 'NAM', '001204014664', 'VIỆT NAM', 'HÒA LONG, THÀNH PHỐ BẮC NINH, BẮC NINH', '218C ĐỘI CẤN, LIỄU GIAI, BA ĐÌNH, HÀ NỘI', 'HÀ NỘI', 'BA ĐÌNH', 'LIỄU GIAI', '218C ĐỘI CẤN', '2029-09-09', 'cccd_images/3wT9lUdQ35EcD2PMEM9wbf6CobgN3cIavEUvLDHb.jpg', 'cccd_images/6qcmEEl9CZRBWjbZsQ1gx2Bnj1Fx9nikgcq78y0j.jpg', '2025-04-27 22:58:05', '2025-04-27 22:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_subjects_class_id_foreign` (`class_id`),
  ADD KEY `class_subjects_subject_id_foreign` (`subject_id`),
  ADD KEY `class_subjects_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `create_teacher_evaluations`
--
ALTER TABLE `create_teacher_evaluations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `divisions_code_unique` (`code`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculties_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `offices_code_unique` (`code`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `pl_hdtl1_files`
--
ALTER TABLE `pl_hdtl1_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pl_hdtl1_files_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `pl_hdtl1_files_class_id_file_type_status_index` (`class_id`,`file_type`,`status`),
  ADD KEY `pl_hdtl1_files_created_at_index` (`created_at`);

--
-- Indexes for table `pl_hdtl2_files`
--
ALTER TABLE `pl_hdtl2_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pl_hdtl2_files_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `pl_hdtl2_files_class_id_file_type_index` (`class_id`,`file_type`),
  ADD KEY `pl_hdtl2_files_status_index` (`status`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  ADD KEY `role_permissions_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_class_subject_id_foreign` (`class_subject_id`),
  ADD KEY `schedules_room_id_foreign` (`room_id`),
  ADD KEY `schedules_class_id_foreign` (`class_id`),
  ADD KEY `schedules_subject_id_foreign` (`subject_id`),
  ADD KEY `schedules_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `school_shifts`
--
ALTER TABLE `school_shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score_sheets`
--
ALTER TABLE `score_sheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `score_sheets_class_id_status_index` (`class_id`,`status`),
  ADD KEY `score_sheets_created_at_index` (`created_at`),
  ADD KEY `score_sheets_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sics`
--
ALTER TABLE `sics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sics_class_subject_id_foreign` (`class_subject_id`),
  ADD KEY `sics_student_id_foreign` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_student_code_unique` (`student_code`),
  ADD UNIQUE KEY `students_email_unique` (`email`);

--
-- Indexes for table `study_statuses`
--
ALTER TABLE `study_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_types`
--
ALTER TABLE `subject_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`);

--
-- Indexes for table `teacher_evaluations`
--
ALTER TABLE `teacher_evaluations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teaching_materials`
--
ALTER TABLE `teaching_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teaching_materials_officer_id_foreign` (`officer_id`),
  ADD KEY `teaching_materials_course_id_foreign` (`course_id`);

--
-- Indexes for table `training_officer_accounts`
--
ALTER TABLE `training_officer_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `training_officer_accounts_email_unique` (`email`),
  ADD KEY `training_officer_accounts_office_id_foreign` (`office_id`),
  ADD KEY `training_officer_accounts_faculty_id_foreign` (`faculty_id`),
  ADD KEY `training_officer_accounts_division_id_foreign` (`division_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_infos`
--
ALTER TABLE `user_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_permissions_user_id_permission_id_unique` (`user_id`,`permission_id`),
  ADD KEY `user_permissions_permission_id_foreign` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `create_teacher_evaluations`
--
ALTER TABLE `create_teacher_evaluations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `pl_hdtl1_files`
--
ALTER TABLE `pl_hdtl1_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pl_hdtl2_files`
--
ALTER TABLE `pl_hdtl2_files`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `school_shifts`
--
ALTER TABLE `school_shifts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `score_sheets`
--
ALTER TABLE `score_sheets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sics`
--
ALTER TABLE `sics`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `study_statuses`
--
ALTER TABLE `study_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `subject_types`
--
ALTER TABLE `subject_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teacher_evaluations`
--
ALTER TABLE `teacher_evaluations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `teaching_materials`
--
ALTER TABLE `teaching_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `training_officer_accounts`
--
ALTER TABLE `training_officer_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_infos`
--
ALTER TABLE `user_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD CONSTRAINT `class_subjects_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `class_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `class_subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pl_hdtl1_files`
--
ALTER TABLE `pl_hdtl1_files`
  ADD CONSTRAINT `pl_hdtl1_files_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pl_hdtl1_files_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pl_hdtl2_files`
--
ALTER TABLE `pl_hdtl2_files`
  ADD CONSTRAINT `pl_hdtl2_files_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pl_hdtl2_files_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `schedules_class_subject_id_foreign` FOREIGN KEY (`class_subject_id`) REFERENCES `class_subjects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `schedules_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `classrooms` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `schedules_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `score_sheets`
--
ALTER TABLE `score_sheets`
  ADD CONSTRAINT `score_sheets_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `score_sheets_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sics`
--
ALTER TABLE `sics`
  ADD CONSTRAINT `sics_class_subject_id_foreign` FOREIGN KEY (`class_subject_id`) REFERENCES `class_subjects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sics_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teaching_materials`
--
ALTER TABLE `teaching_materials`
  ADD CONSTRAINT `teaching_materials_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teaching_materials_officer_id_foreign` FOREIGN KEY (`officer_id`) REFERENCES `training_officer_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `training_officer_accounts`
--
ALTER TABLE `training_officer_accounts`
  ADD CONSTRAINT `training_officer_accounts_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `training_officer_accounts_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `training_officer_accounts_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
