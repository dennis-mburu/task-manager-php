-- Clean Dump File: Task Manager App
-- MySQL/MariaDB compatible dump with proper FK order
-- Passwords hashed using PASSWORD_DEFAULT (bcrypt, PHP 8+)
-- Created: 2025-07-14

-- Set up character encoding and session configs
SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

-- USERS TABLE FIRST (Parent table)
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'AliceAdmin',   'alice@example.com',   '$2y$12$h6m2VHdtrXdr2yeghRp3T.oPQIkMUeiFwq3mbrJkL20904DudjTL2', 'admin', '2025-07-14 06:08:49'),
(2, 'BobUser',      'bob@example.com',     '$2y$12$AeeFhmRg0flFhLNTideRbO0lbegZfsXrBZPGTVkGDjLE1B6yjlQYK', 'user',  '2025-07-14 06:08:49'),
(3, 'CharlieAdmin', 'charlie@example.com', '$2y$12$TcNlj2DrLDumg9B6.YCGoulMfJ8AYzQHYDPFM0n48LBMNrh69IPtO', 'admin', '2025-07-14 06:08:49'),
(4, 'DaisyUser',    'daisy@example.com',   '$2y$12$Mnfcd4B0YNaE6g15fB7BgOyKcJPfqhjPZw/4pPuU4T3Y997cYqVEO', 'user',  '2025-07-14 06:08:49');

-- TASKS TABLE AFTER USERS
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `assigned_to` (`assigned_to`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `deadline`, `status`, `created_at`) VALUES
(1,'Review Codebase','Go through the entire code structure.',1,'2025-07-14 12:00:00','Pending','2025-07-14 06:08:49'),
(2,'Plan Sprint','Define tasks for upcoming sprint.',1,'2025-07-15 14:00:00','In Progress','2025-07-14 06:08:49'),
(3,'Update Docs','Fix outdated documentation.',1,'2025-07-17 10:00:00','Completed','2025-07-14 06:08:49'),
(4,'Meet with Team','Weekly stand-up and roadmap.',1,'2025-07-19 16:00:00','Pending','2025-07-14 06:08:49'),
(5,'Optimize Queries','Improve performance of task fetch queries.',1,'2025-07-21 21:00:00','Pending','2025-07-14 06:08:49'),
(6,'Fix Login Bug','Resolve incorrect login error message.',2,'2025-07-14 13:00:00','Pending','2025-07-14 06:08:49'),
(7,'Style Dashboard','Improve dashboard UI layout.',2,'2025-07-15 11:00:00','In Progress','2025-07-14 06:08:49'),
(8,'Add Logout Alert','Confirmation popup on logout.',2,'2025-07-17 09:00:00','Pending','2025-07-14 06:08:49'),
(9,'Clean CSS','Refactor unused CSS.',2,'2025-07-19 16:00:00','Completed','2025-07-14 06:08:49'),
(10,'Implement Tooltips','Add tooltips for buttons.',2,'2025-07-21 08:00:00','Pending','2025-07-14 06:08:49'),
(11,'Setup Hosting','Deploy app to InfinityFree.',3,'2025-07-14 15:00:00','In Progress','2025-07-14 06:08:49'),
(12,'Backup DB','Create a daily dump backup script.',3,'2025-07-15 11:00:00','Pending','2025-07-14 06:08:49'),
(13,'Write Readme','Document project setup steps.',3,'2025-07-17 16:00:00','Pending','2025-07-14 06:08:49'),
(14,'Add Admin Panel','Create CRUD interface for admins.',3,'2025-07-19 10:00:00','Completed','2025-07-14 06:08:49'),
(15,'Security Review','Audit for password hashing & SQLi.',3,'2025-07-21 07:00:00','Pending','2025-07-14 06:08:49'),
(16,'Test Task Creation','Ensure tasks are added properly.',4,'2025-07-14 00:00:00','Pending','2025-07-14 06:08:49'),
(17,'Change Password UI','Improve password form feedback.',4,'2025-07-15 02:00:00','In Progress','2025-07-14 06:08:49'),
(18,'Fix Broken Link','Profile page link not working.',4,'2025-07-17 16:00:00','Pending','2025-07-14 06:08:49'),
(19,'Add Date Picker','Enhance deadline input field.',4,'2025-07-19 18:00:00','Pending','2025-07-14 06:08:49'),
(20,'Test Email Alert','Confirm if email notification works.',4,'2025-07-21 21:00:00','Completed','2025-07-14 06:08:49');

-- Restore FK checks
SET foreign_key_checks = 1;
