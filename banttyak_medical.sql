-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 23, 2023 at 05:02 PM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banttyak_medical`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent_generated_tracking_report`
--

CREATE TABLE `agent_generated_tracking_report` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `tracking_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem_description` text COLLATE utf8mb4_unicode_ci,
  `voice_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_voice_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem_pictures` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent_generated_tracking_report`
--

INSERT INTO `agent_generated_tracking_report` (`id`, `request_id`, `agent_id`, `tracking_no`, `problem_description`, `voice_note`, `agent_voice_note`, `problem_pictures`, `created_at`, `updated_at`) VALUES
(4, 18, 25, '9854315008', 'Testing problem description', 'test voice note', NULL, '9854315008_0.jpg', '2023-04-11 06:43:21', NULL),
(6, 22, 25, '7434182245', 'testing', NULL, '1681983119.mp3', '7434182245_0.png', '2023-04-20 09:31:59', NULL),
(7, 23, 25, '6609536388', 'testing agent description', NULL, '1682405661.mp3', '6609536388_0.jpeg', '2023-04-25 06:54:21', NULL),
(8, 24, 25, '8374840385', 'not working', NULL, '1682517517.mp3', '8374840385_0.png', '2023-04-26 13:58:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_agents`
--

CREATE TABLE `sales_agents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `simple_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_agents`
--

INSERT INTO `sales_agents` (`id`, `user_id`, `name`, `address`, `country`, `state`, `city`, `contact_number`, `email`, `password`, `simple_password`, `status`, `created_at`, `updated_at`) VALUES
(5, 25, 'Agent 1', 'Sargodha, Pakistan', 'India', 'Kerala', 'Ernakulam', '900090000', 'agent1@gmail.com', '$2y$10$JqrA.1SFZ8h3pz4vAEJhW.0na3lVAwGDdOidhVA3OXbgbw2LP8AKG', '11223344', 'active', '2023-04-11 06:33:44', '2023-04-11 06:33:44'),
(6, 26, 'Agent 1', 'Sargodha, Pakistan', 'India', 'Kerala', 'Kannur', '900090000', 'agent2@gmail.com', '$2y$10$Nz08Q7v39NCpqKNRZqnIUeoF2zIhH6mJPYoY1VXoGeryfFt5OwNey', '11223344', 'active', '2023-04-11 06:34:07', '2023-04-11 06:34:07');

-- --------------------------------------------------------

--
-- Table structure for table `service_engineers`
--

CREATE TABLE `service_engineers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `simple_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_engineers`
--

INSERT INTO `service_engineers` (`id`, `user_id`, `name`, `address`, `country`, `state`, `city`, `contact_number`, `email`, `password`, `simple_password`, `status`, `created_at`, `updated_at`) VALUES
(10, 23, 'Engineer 1', 'Sargodha', 'India', 'Kerala', 'Ernakulam', '900090000', 'engineer1@gmail.com', '$2y$10$KWrL.7badici8erQNcQuWuopdmf1nYITVzmDuRv7hFBeU2VzsJ0ea', '11223344', 'active', '2023-04-11 06:32:48', '2023-04-11 06:32:48'),
(11, 24, 'Engineer 1', 'Sargodha, Pakistan', 'India', 'Kerala', 'Idukki', '900090000', 'engineer2@gmail.com', '$2y$10$vDAau5auq6xipdeka.XdJ.aav03OXJ5cLRp3J.vXsi2fSDXbr7VWW', '11223344', 'active', '2023-04-11 06:33:11', '2023-04-11 06:33:11');

-- --------------------------------------------------------

--
-- Table structure for table `service_engineer_reports`
--

CREATE TABLE `service_engineer_reports` (
  `id` int(11) NOT NULL,
  `request_id` int(11) DEFAULT NULL,
  `engineer_id` int(11) DEFAULT NULL,
  `problem_description` text COLLATE utf8mb4_unicode_ci,
  `spare_parts_needed` text COLLATE utf8mb4_unicode_ci,
  `damage_machine_photos` text COLLATE utf8mb4_unicode_ci,
  `repaired_machine_photos` text COLLATE utf8mb4_unicode_ci,
  `voice_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `engineer_voice_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `repaire_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_engineer_reports`
--

INSERT INTO `service_engineer_reports` (`id`, `request_id`, `engineer_id`, `problem_description`, `spare_parts_needed`, `damage_machine_photos`, `repaired_machine_photos`, `voice_note`, `engineer_voice_note`, `repaire_status`, `created_at`, `updated_at`) VALUES
(5, 19, 23, 'Testing report from service engineer', 'part1, part2, part3', '202304110645290.png,202304110645291.png,202304110645292.png,202304110645293.png', '202304110648590.png,202304110648591.jpg,202304110648592.jpg,202304110648593.jpg', 'testing voice note', NULL, 'repaired', '2023-04-11 06:45:29', '2023-04-11 06:48:59'),
(6, 22, 23, 'test', 'part1, part2, part3', '202304201007490.png,202304201007491.png', NULL, NULL, '1681985959.mp3', 'unrepaired', '2023-04-20 10:07:49', '2023-04-20 10:19:19'),
(7, 23, 23, 'service engineer test report', 'part1, part2, part3', '202304250700130.jpeg,202304250700131.png,202304250700132.png', '202304250709420.jpeg,202304250709421.jpeg', NULL, '1682406013.mp3', 'repaired', '2023-04-25 07:00:13', '2023-04-25 07:09:42'),
(8, 24, 23, 'LED light need to change', 'led lights 2 units fuse 1 cable 1', '202304261403200.png', '202304261410380.jpg', NULL, '1682517800.mp3', 'repaired', '2023-04-26 14:03:20', '2023-04-26 14:10:38'),
(9, 26, 23, 'Cable connection issue', 'Cable 1 meter', '202304271104350.jpg', NULL, NULL, '1682593475.mp3', 'repaired', '2023-04-27 11:04:35', '2023-04-27 11:13:43');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(11) NOT NULL,
  `machine_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem_description` text COLLATE utf8mb4_unicode_ci,
  `voice_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `showroom_voice_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem_occured_date` datetime DEFAULT NULL,
  `tracking_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_receiving_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'unreceived',
  `posted_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_engineer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `super_admin_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `showroom_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spare_parts_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `showroom_service_charges` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `machine_collect_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `showroom_problem_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'unrepaired',
  `showroom_approval` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `machine_name`, `model_no`, `problem_description`, `voice_note`, `showroom_voice_note`, `problem_occured_date`, `tracking_no`, `device_receiving_status`, `posted_by`, `sales_agent`, `service_engineer`, `super_admin_cost`, `showroom_cost`, `spare_parts_cost`, `showroom_service_charges`, `machine_collect_method`, `showroom_problem_image`, `status`, `showroom_approval`, `work_status`, `created_at`, `updated_at`) VALUES
(16, 'Test Machine Name', '12993', 'Testing Problem Description', 'test voice note', NULL, '2023-04-11 06:35:33', NULL, 'received', '21', '5', NULL, NULL, NULL, NULL, NULL, 'pickup', '1681194933.png', 'unrepaired', NULL, NULL, '2023-04-11 06:35:33', '2023-04-21 10:58:06'),
(17, 'Test Machine Name 2', '798789', 'This is a description for testing machine 2', 'test voice note', NULL, '2023-04-11 06:36:21', NULL, 'unreceived', '21', NULL, NULL, NULL, NULL, NULL, NULL, 'courier', '1681194981.jpg', 'unrepaired', NULL, NULL, '2023-04-11 06:36:21', '2023-04-17 11:07:56'),
(18, 'Test Machine Name 3', 'U12993', 'Testing description for test machine 3', 'test voice note', NULL, '2023-04-11 06:37:52', '9854315008', 'received', '21', '5', '10', NULL, NULL, NULL, NULL, 'pickup', '1681195072.JPEG', 'unrepaired', NULL, NULL, '2023-04-11 06:37:52', '2023-04-21 11:01:55'),
(19, 'Test Machine Name 4', '798789', 'Test Description for test machine 4', 'test voice note', NULL, '2023-04-11 06:38:22', '7264807588', 'unreceived', '21', NULL, '10', NULL, NULL, '200', '100', 'courier', '1681195102.png', 'repaired', 'approved', 'completed', '2023-04-11 06:38:22', '2023-04-21 12:41:34'),
(22, 'Test Machine Name 5', '12993', 'testing voice note', NULL, '1681979568.mp3', '2023-04-20 08:19:26', '7434182245', 'unreceived', '21', '5', '10', NULL, NULL, NULL, NULL, 'pickup', '1681978766.jpeg', 'unrepaired', NULL, NULL, '2023-04-20 08:19:26', '2023-04-20 09:57:13'),
(23, 'Test Machine Name 15', '798789', 'This is testing description', NULL, '1682405459.mp3', '2023-04-25 06:50:31', '6609536388', 'received', '21', '5', '10', NULL, NULL, '2000', '500', 'pickup', '1682405431.png', 'repaired', 'approved', 'completed', '2023-04-25 06:50:31', '2023-04-25 07:09:42'),
(24, 'Omron BP Monitor', 'mm4010', 'not working', NULL, '1682517072.mp3', '2023-04-26 13:51:11', '8374840385', 'received', '21', '5', '10', NULL, NULL, '500', '300', 'pickup', '1682517071.png', 'repaired', 'approved', 'completed', '2023-04-26 13:51:11', '2023-04-26 14:10:38'),
(25, 'MOTHER MED NEBULIZER', '5016', 'NOT WORKING', NULL, '1682518483.mp3', '2023-04-26 14:14:43', NULL, 'unreceived', '21', '5', NULL, NULL, NULL, NULL, NULL, 'pickup', '1682518483.jpg', 'unrepaired', NULL, NULL, '2023-04-26 14:14:43', '2023-04-27 11:23:13'),
(26, 'Suction machine', 'Mm9000', 'Not working', NULL, '1682589945.mp3', '2023-04-27 10:05:45', '1042448204', 'received', '27', NULL, '10', NULL, NULL, '100', '100', 'courier', '1682589945.jpg', 'repaired', 'approved', 'completed', '2023-04-27 10:05:45', '2023-04-27 11:13:43'),
(27, 'Suction machine', 'Mm8000', 'Sound', NULL, '1682594570.mp3', '2023-04-27 11:22:50', NULL, 'received', '27', '5', NULL, NULL, NULL, NULL, NULL, 'pickup', '1682594570.jpg', 'unrepaired', NULL, NULL, '2023-04-27 11:22:50', '2023-04-27 13:08:51');

-- --------------------------------------------------------

--
-- Table structure for table `showrooms`
--

CREATE TABLE `showrooms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `showroom_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `simple_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `showrooms`
--

INSERT INTO `showrooms` (`id`, `user_id`, `showroom_name`, `whatsapp_number`, `contact_name`, `contact_number`, `address`, `country`, `state`, `city`, `email`, `password`, `simple_password`, `status`, `created_at`, `updated_at`) VALUES
(14, 21, 'Showroom 1', '098876546', 'Showroom 1', '900090000', 'Sargodha, Pakistan', 'India', 'Kerala', 'Thiruvananthapuram', 'showroom1@gmail.com', '$2y$10$pzN4e9wUxqGAopWeytPZIuKRy2xupIMWjj1ISTnnT7g3Wn7qaIeUa', '11223344', 'active', '2023-04-11 06:31:32', '2023-04-11 06:31:32'),
(15, 22, 'Showroom 2', '0977797569', 'Showroom 2', '900090000', 'Sargodha, Pakistan', 'India', 'Kerala', 'Wayanad', 'showroom2@gmail.com', '$2y$10$.w.Q6573bXWs6y4RBvhwS.uX1G.w7DHfELiX.tu2e.eg.9HfBmVVe', '11223344', 'active', '2023-04-11 06:32:09', '2023-04-11 06:32:09'),
(16, 27, 'Libin', '8606721676', 'Libin', '8606721676', 'libin', 'India', 'Kerala', 'Kottayam', 'libin@gmail.com', '$2y$10$zP8bVwX2VuwD9NIdtuMvdutjLNJtm6j67YDO7KmV/Ia7LcLeU02xi', '123456789', 'active', '2023-04-27 09:44:22', '2023-04-27 09:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@admin.com', NULL, '$2y$10$/8pYTJJoTP3ZQ4H.b2iAHOyXcGUYNFXOVSa.5x9EgLLR/ARCI/7jy', 'super_admin', 'active', NULL, '2023-03-21 01:48:15', '2023-03-21 01:48:15'),
(21, 'Showroom 1', 'showroom1@gmail.com', NULL, '$2y$10$zUyOyVbAGmcyw06kmzAZeuM3pb/a.F1.wncEa/cGgWaE6Q1aguGji', 'showroom_owner', 'active', NULL, '2023-04-11 06:31:32', '2023-04-11 06:31:32'),
(22, 'Showroom 2', 'showroom2@gmail.com', NULL, '$2y$10$JCC7KihHjdgmVuKLU11ueOX3d06xovMjmNi0ZDe0jtgkDWOPfeF4q', 'showroom_owner', 'active', NULL, '2023-04-11 06:32:09', '2023-04-11 06:32:09'),
(23, 'Engineer 1', 'engineer1@gmail.com', NULL, '$2y$10$uaAk9oTY9zXtY2fo1epMxeKHQ3daYGKZ5eC95LRsCPhjSUVxtJAjW', 'service_engineer', 'active', NULL, '2023-04-11 06:32:48', '2023-04-11 06:32:48'),
(24, 'Engineer 1', 'engineer2@gmail.com', NULL, '$2y$10$95Mf3M0mVIdQERI7f7pHq.eZElcoqPkyP54MayxvCmoFhvwv0c4BS', 'service_engineer', 'active', NULL, '2023-04-11 06:33:11', '2023-04-11 06:33:11'),
(25, 'Agent 1', 'agent1@gmail.com', NULL, '$2y$10$OAr/4I8kPlDL3VpPoyKJaeif9wIHY348IR4t/VoIzpCeq93bSMxGy', 'sales_agent', 'active', NULL, '2023-04-11 06:33:44', '2023-04-11 06:33:44'),
(26, 'Agent 1', 'agent2@gmail.com', NULL, '$2y$10$/zxVXhLYvfzjdxVkYHAHie8iqgZMeiNlpufETVNzWs0mlsjloVMzW', 'sales_agent', 'active', NULL, '2023-04-11 06:34:07', '2023-04-11 06:34:07'),
(27, 'Libin', 'libin@gmail.com', NULL, '$2y$10$hvMhn6Spv6hHp28mc0k4XeXz0EC2EhvZIFhlCGQdLQ3yeROKVa22q', 'showroom_owner', 'active', NULL, '2023-04-27 09:44:22', '2023-04-27 09:44:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent_generated_tracking_report`
--
ALTER TABLE `agent_generated_tracking_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sales_agents`
--
ALTER TABLE `sales_agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_engineers`
--
ALTER TABLE `service_engineers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_engineer_reports`
--
ALTER TABLE `service_engineer_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `showrooms`
--
ALTER TABLE `showrooms`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `agent_generated_tracking_report`
--
ALTER TABLE `agent_generated_tracking_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_agents`
--
ALTER TABLE `sales_agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service_engineers`
--
ALTER TABLE `service_engineers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `service_engineer_reports`
--
ALTER TABLE `service_engineer_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `showrooms`
--
ALTER TABLE `showrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
