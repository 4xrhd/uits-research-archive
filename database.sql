SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;

CREATE TABLE `users` (
  `id` bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL PRIMARY KEY,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL PRIMARY KEY,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  KEY `sessions_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `departments` (
  `id` bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL UNIQUE,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `domains` (
  `id` bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL UNIQUE,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `submissions` (
  `id` bigint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(500) NOT NULL,
  `archive_type` varchar(255) NOT NULL,
  `author_role` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `batch` varchar(100) DEFAULT NULL,
  `academic_session` varchar(100) DEFAULT NULL,
  `research_domains` longtext DEFAULT NULL,
  `authors` longtext NOT NULL,
  `external_links` longtext DEFAULT NULL,
  `pdf_url` text DEFAULT NULL,
  `drive_links` longtext DEFAULT NULL,
  `abstract` text DEFAULT NULL,
  `author_comments` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `admin_remarks` text DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `reviewed_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  CONSTRAINT `fk_submission_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cache` (`key` varchar(255) PRIMARY KEY, `value` mediumtext NOT NULL, `expiration` int(11) NOT NULL);
CREATE TABLE `jobs` (`id` bigint UNSIGNED PRIMARY KEY AUTO_INCREMENT, `queue` varchar(255) NOT NULL, `payload` longtext NOT NULL, `attempts` tinyint UNSIGNED NOT NULL, `reserved_at` int UNSIGNED DEFAULT NULL, `available_at` int UNSIGNED NOT NULL, `created_at` int UNSIGNED NOT NULL);

INSERT INTO `departments` (`name`, `created_at`, `updated_at`) VALUES
('Computer Science & Engineering', NOW(), NOW()),
('Electrical & Electronic Engineering', NOW(), NOW()),
('Business Administration', NOW(), NOW()),
('English', NOW(), NOW()),
('Law', NOW(), NOW()),
('Civil Engineering', NOW(), NOW()),
('Architecture', NOW(), NOW()),
('Electronics and Communication Engineering', NOW(), NOW()),
('Pharmacy', NOW(), NOW()),
('Public Health', NOW(), NOW()),
('Environmental Science', NOW(), NOW()),
('Mathematics', NOW(), NOW()),
('Physics', NOW(), NOW()),
('Chemistry', NOW(), NOW()),
('Biotechnology', NOW(), NOW());

INSERT INTO `domains` (`name`, `created_at`, `updated_at`) VALUES
('Artificial Intelligence', NOW(), NOW()),
('Machine Learning', NOW(), NOW()),
('Data Science', NOW(), NOW()),
('Cybersecurity', NOW(), NOW()),
('Internet of Things', NOW(), NOW()),
('Cloud Computing', NOW(), NOW()),
('Blockchain', NOW(), NOW()),
('Software Engineering', NOW(), NOW()),
('Web Development', NOW(), NOW()),
('Mobile Development', NOW(), NOW()),
('Network Engineering', NOW(), NOW()),
('Database Systems', NOW(), NOW()),
('Human-Computer Interaction', NOW(), NOW()),
('Computer Vision', NOW(), NOW()),
('Natural Language Processing', NOW(), NOW()),
('Robotics', NOW(), NOW()),
('Renewable Energy', NOW(), NOW()),
('Sustainable Development', NOW(), NOW()),
('Public Health', NOW(), NOW()),
('Environmental Science', NOW(), NOW()),
('Biotechnology', NOW(), NOW()),
('Pharmaceutical Sciences', NOW(), NOW()),
('Civil Engineering', NOW(), NOW()),
('Architecture', NOW(), NOW()),
('Business Administration', NOW(), NOW()),
('Law', NOW(), NOW()),
('English Literature', NOW(), NOW());

INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
('Admin User', 'admin@uits.edu.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW()),
('Student User', 'student@uits.edu.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW()),
('Faculty User', 'faculty@uits.edu.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'faculty', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
