-- ========================================================
-- DATABASE HOTEL NUANSA (SIAP IMPORT PHPMYADMIN / MYSQL)
-- Tanggal: 2026-11-17 10:55:45
-- ========================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'kasir',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `username`, `phone`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Nuansa', 'admin', 'admin', 'admin@nuansa.local', '$2y$12$U.Ybbe/nKNJJ6VNsVPmjm.9jvVMhxMgktPV7GV5URdK4OkYq.Gov2', 'admin', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(2, 'Kasir Nuansa', 'kasir', 'kasir', 'kasir@nuansa.local', '$2y$12$1fRNY5SludBs/WiKkk5Xw.UlX4UoLcOC06xxzTv13JsxFHrnd8Nu.', 'kasir', '2026-09-01 17:59:43', '2026-09-01 17:59:43');

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `room_number` varchar(50) NOT NULL,
  `type` varchar(100) NOT NULL,
  `price_per_night` decimal(12,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rooms` (`id`, `room_number`, `type`, `price_per_night`, `status`, `created_at`, `updated_at`) VALUES
(1, '01', 'Deluxe (AC)', 180000, 'dirty', '2026-09-01 17:59:43', '2026-11-17 10:10:19'),
(2, '02', 'Deluxe (AC)', 180000, 'dirty', '2026-09-01 17:59:43', '2026-11-17 09:37:46'),
(3, '03', 'Standard (Kipas)', 120000, 'occupied', '2026-09-01 17:59:43', '2026-11-17 09:08:02'),
(4, '04', 'Standard (Kipas)', 120000, 'occupied', '2026-09-01 17:59:43', '2026-11-17 09:36:10'),
(5, '05', 'Standard (Kipas)', 120000, 'occupied', '2026-09-01 17:59:43', '2026-11-17 09:36:23'),
(6, '06', 'Standard (Kipas)', 120000, 'occupied', '2026-09-01 17:59:43', '2026-11-17 10:09:10'),
(7, '07', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(8, '08', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(9, '09', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(10, '10', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(11, '11', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(12, '12', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(13, '13', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(14, '14', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(15, '15', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(16, '16', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(17, '17', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(18, '18', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(19, '19', 'Standard (Kipas)', 120000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(20, '20', 'Deluxe (AC)', 180000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(21, '21', 'Deluxe (AC)', 180000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(22, '22', 'Deluxe (AC)', 180000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(23, '23', 'Suite (AC + TV)', 200000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(24, '24', 'Suite (AC + TV)', 200000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(25, '25', 'Suite (AC + TV)', 200000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(26, '26', 'Standard Plus (Kipas)', 130000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(27, '27', 'Standard Plus (Kipas)', 130000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(28, '28', 'Standard Plus (Kipas)', 130000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(29, '29', 'Standard Plus (Kipas)', 130000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(30, '30', 'Suite (AC + TV)', 200000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(31, '31', 'Standard Plus (Kipas)', 130000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(32, '32', 'Standard Plus (Kipas)', 130000, 'available', '2026-09-01 17:59:43', '2026-09-01 17:59:43');

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(100) NOT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `payment_methods` (`id`, `bank_name`, `account_number`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Cash', NULL, 1, '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(2, 'Transfer BCA', '1234567890', 1, '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(3, 'Transfer Mandiri', '9876543210', 1, '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(4, 'QRIS', NULL, 1, '2026-09-01 17:59:43', '2026-09-01 17:59:43');

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(14,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `expenses` (`id`, `user_id`, `category`, `description`, `amount`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 'utilities', 'Tagihan Listrik Bulan Januari', 2000000.00, '2026-09-01 00:00:00', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(2, 1, 'utilities', 'Tagihan Air Bulan Januari', 500000.00, '2026-09-01 00:00:00', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(3, 1, 'maintenance', 'Perbaikan Pintu Kamar 105', 350000.00, '2026-08-31 00:00:00', '2026-09-01 17:59:43', '2026-09-01 17:59:43'),
(4, 1, 'supplies', 'Pembelian Handuk dan Sprei', 1200000.00, '2026-08-30 00:00:00', '2026-09-01 17:59:43', '2026-09-01 17:59:43');

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_code` varchar(50) NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_nik` varchar(50) DEFAULT NULL,
  `guest_phone` varchar(50) DEFAULT NULL,
  `guest_address` text DEFAULT NULL,
  `is_guest_data_complete` tinyint(1) NOT NULL DEFAULT 0,
  `check_in` datetime NOT NULL,
  `check_out` datetime DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(14,2) NOT NULL DEFAULT 0.00,
  `additional_charges` decimal(14,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(50) NOT NULL DEFAULT 'unpaid',
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `guarantee_type` varchar(50) DEFAULT NULL,
  `is_ktp_held` tinyint(1) NOT NULL DEFAULT 0,
  `guarantee_returned` tinyint(1) NOT NULL DEFAULT 0,
  `is_tc` tinyint(1) NOT NULL DEFAULT 0,
  `tc_nominal` int(11) NOT NULL DEFAULT 0,
  `cashier_name` varchar(100) DEFAULT NULL,
  `shift` varchar(50) DEFAULT NULL,
  `ktp_photo_path` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `transactions` (`id`, `invoice_code`, `room_id`, `user_id`, `payment_method_id`, `guest_name`, `guest_nik`, `guest_phone`, `guest_address`, `is_guest_data_complete`, `check_in`, `check_out`, `duration`, `total_price`, `additional_charges`, `paid_amount`, `payment_status`, `status`, `guarantee_type`, `is_ktp_held`, `guarantee_returned`, `is_tc`, `tc_nominal`, `cashier_name`, `shift`, `created_at`, `updated_at`) VALUES
(1, 'INV-01-09-2026-001', 3, 2, NULL, 'Budi Santoso', '3271234567890123', '02903894839', 'Jl. Gatot Subroto No. 1, Bandung', 1, '2026-09-01 17:59:43', '2026-09-03 17:59:43', 1, 240000, 0, 0, 'unpaid', 'active', 'KTP', 1, 0, 0, 0, NULL, NULL, '2026-09-01 17:59:43', '2026-11-17 09:36:53'),
(2, 'INV-20260901-002', 1, 2, 1, 'GUEST ROOM 01', NULL, NULL, NULL, 0, '2026-09-01 18:08:39', '2026-11-16 23:37:35', 1, 230000, 50000, 230000, 'paid', 'finished', NULL, 0, 1, 0, 0, 'Admin Nuansa', 'Malam', '2026-09-01 18:08:39', '2026-11-16 23:37:35'),
(3, 'INV-20261116-001', 2, 1, 1, 'GUEST ROOM 02', '8937492389048920', '081231355159', 'Ketintang', 1, '2026-11-16 23:37:09', '2026-11-17 09:37:46', 1, 180000, 0, 180000, 'paid', 'finished', 'KTP', 1, 1, 0, 0, 'Admin Nuansa', 'Pagi', '2026-11-16 23:37:09', '2026-11-17 09:37:46'),
(4, 'INV-20261117-001', 3, 1, 1, 'GUEST ROOM 03', NULL, NULL, NULL, 0, '2026-11-17 09:08:02', '2026-11-18 12:00:00', 1, 120000, 0, 0, 'unpaid', 'active', 'KTP', 1, 0, 0, 0, NULL, NULL, '2026-11-17 09:08:02', '2026-11-17 09:08:02'),
(5, 'INV-20261117-002', 4, 1, 1, 'GUEST ROOM 04', NULL, NULL, NULL, 0, '2026-11-17 09:36:10', '2026-11-18 12:00:00', 1, 120000, 0, 0, 'unpaid', 'active', 'KTP', 1, 0, 0, 0, NULL, NULL, '2026-11-17 09:36:10', '2026-11-17 09:36:10'),
(6, 'INV-20261117-003', 5, 1, 1, 'SUGENG', '9832749832949320', '8374893288932', 'Ketintang', 1, '2026-11-17 09:36:23', '2026-11-18 12:00:00', 1, 120000, 0, 0, 'unpaid', 'active', 'KTP', 1, 0, 0, 0, NULL, NULL, '2026-11-17 09:36:23', '2026-11-17 10:08:58'),
(7, 'INV-20261117-004', 1, 1, 1, 'GUEST ROOM 01', NULL, NULL, NULL, 0, '2026-11-17 10:09:04', '2026-11-17 10:10:19', 1, 180000, 0, 180000, 'paid', 'finished', 'KTP', 1, 1, 0, 0, 'Admin Nuansa', 'Pagi', '2026-11-17 10:09:04', '2026-11-17 10:10:19'),
(8, 'INV-20261117-005', 6, 1, 1, 'GUEST ROOM 06', NULL, NULL, NULL, 0, '2026-11-17 10:09:10', '2026-11-18 12:00:00', 1, 120000, 0, 0, 'unpaid', 'active', 'KTP', 1, 0, 0, 0, NULL, NULL, '2026-11-17 10:09:10', '2026-11-17 10:09:10');

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
