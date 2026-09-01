-- =========================================================
-- Sainmatrimony.in Safe Database Schema (NO DROP / NO DATA LOSS)
-- Import this file to create database tables safely without deleting live data.
-- =========================================================

CREATE DATABASE IF NOT EXISTS `manglik_matrimony_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `manglik_matrimony_db`;

-- 1. Admin Users Table
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Candidate Profiles Table
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `profile_id` VARCHAR(20) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `gender` ENUM('Male','Female') NOT NULL,
  `age` INT(11) NOT NULL,
  `caste` VARCHAR(100) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `state` VARCHAR(100) DEFAULT NULL,
  `education` VARCHAR(150) DEFAULT NULL,
  `occupation` VARCHAR(150) DEFAULT NULL,
  `photo` VARCHAR(255) DEFAULT 'default.jpg',
  `status` ENUM('active','inactive') DEFAULT 'active',
  `is_premium` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `profile_id` (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Success Stories Table
CREATE TABLE IF NOT EXISTS `success_stories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `story` TEXT NOT NULL,
  `photo` VARCHAR(255) NOT NULL,
  `story_date` VARCHAR(50) DEFAULT NULL,
  `status` ENUM('active','inactive') DEFAULT 'active',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. User Registration Inquiries Table
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `gender` VARCHAR(20) DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user if not exists (username: admin | password: password123)
INSERT IGNORE INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$w6.U4uQ4iR4.aV1fE6kXn.o5Z8P.8vA3eH9lY7aA6y2Z1w8P.8vA3');
