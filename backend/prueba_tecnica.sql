-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 01:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prueba_tecnica`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estado_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_final`, `estado_id`, `user_id`, `created_at`, `updated_at`) VALUES
(4, 'EMCOSALUD', 'IMPLEMENTACION EMCOSALUD DESARROLLO', '2024-09-29', '2024-09-30', 5, 1, '2024-09-29 01:27:16', '2024-09-30 00:34:55'),
(5, 'MEDICINA INTEGRAL', 'MEDICINA INTEGRAL', '2024-09-28', '2024-09-29', 3, 1, '2024-09-29 01:49:11', '2024-09-29 01:49:11'),
(7, 'BARRANQUILLA', 'PROYECTO IMPLEMENTACION BARRANQUILLA', '2024-09-29', '2024-10-04', 1, 1, '2024-09-30 04:28:07', '2024-09-30 04:28:07');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Completado', '2024-09-26 02:58:53', NULL),
(3, 'Pendiente', '2024-09-28 19:13:09', '2024-09-28 19:13:09'),
(5, 'Pruebas', '2024-09-30 18:29:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_final`, `project_id`, `user_id`, `created_at`, `updated_at`, `state_id`) VALUES
(2, 'Modulo Autogestion', 'Revisar Modulo Autogestion', '2024-09-29', '2024-10-04', 4, 1, '2024-09-29 20:40:52', '2024-09-30 09:39:51', 1),
(3, 'PRUEBA', 'PRUEBA', '2024-09-29', '2024-09-30', 7, 1, '2024-09-29 22:55:21', '2024-09-30 09:40:14', 1),
(4, 'PRUEBAS FUNCIONALES FARMACIA', 'PRUEBAS FUNCIONALES FARMACIA', '2024-09-29', '2024-10-05', 5, 5, '2024-09-30 02:51:25', '2024-09-30 04:27:22', 3),
(5, 'PRUEBAS FUNCIONALES FARMACIA', 'PRUEBAS FUNCIONALES FARMACIA', '2024-09-29', '2024-10-17', 7, 6, '2024-09-30 03:54:07', '2024-09-30 04:31:43', 1),
(6, 'PRUEBA ESTADO', 'PRUEBA', '2024-09-30', '2024-10-02', 4, 1, '2024-09-30 07:40:44', '2024-09-30 07:40:44', 1),
(7, 'PRUEBA', 'PRUEBA', '2024-09-30', '2024-10-02', 4, 4, '2024-09-30 07:43:04', '2024-09-30 07:43:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Samuel Pineda', 'samuel.pineda@sumimedical.com', '0000-00-00 00:00:00', 'TkNAZ1X.', NULL, NULL, '2024-09-30 06:10:55'),
(4, 'Jonathan Coba', 'jocoba@sumimedical.com', NULL, '$2y$10$khzSUDxwQ5oDopYMXUZgAuXU2.9vq.tcafCgTRlKaDYH6HFIhOEXi', NULL, '2024-09-30 01:12:22', '2024-09-30 01:12:22'),
(5, 'Julian Perez', 'jperez@sumimedical.com', NULL, '$2y$10$s1gA/nxrJ/ohj7lZzLvU7OUotOqpyr.eVtfIHP4T1WJ8H5qwZbx9u', NULL, '2024-09-30 01:47:58', '2024-09-30 01:47:58'),
(6, 'Luis Pacheco', 'lpacheco@sumimedical.com', NULL, '$2y$10$44q/zRFLxZfJWjcs94m0fuhGP8tuuO54SIbiYHUR0ynuSJpz4Ith2', NULL, '2024-09-30 04:28:53', '2024-09-30 04:28:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_estado_id_foreign` (`estado_id`),
  ADD KEY `projects_user_id_foreign` (`user_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_project_id_foreign` (`project_id`),
  ADD KEY `tasks_user_id_foreign` (`user_id`),
  ADD KEY `tasks_state_id_foreign` (`state_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `tasks_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
