-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2026 at 06:17 AM
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
-- Database: `family_photo`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `concept` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `package_id`, `name`, `concept`, `description`, `cover_image`, `is_featured`, `is_published`, `created_at`, `updated_at`) VALUES
(2, 1, 'Thanh Xuân 9A Amsterdam Hà Nội', 'Tuổi Thanh Xuân', 'Concept Thanh Xuân là phong cách chụp ảnh kỷ yếu tập trung vào sự tự nhiên và chân thật nhất của tuổi học sinh.\r\n\r\nKhông cầu kỳ về tạo dáng hay setup, concept mang ý nghĩa lưu giữ những điều mộc mạc nhất của tuổi 15: những buổi ra chơi, những cái khoác vai vô tư, tiếng nói cười trong sân trường và cảm giác háo hức trước những ngày cuối cùng của thời cấp 2.\r\n\r\nĐây là concept giúp mỗi bạn học sinh nhìn lại quãng thời gian đẹp nhất, bằng những hình ảnh đầy trong trẻo và sống động.', 'albums/1778865411_6.jpg', 1, 1, '2026-05-15 10:16:43', '2026-05-15 10:16:51'),
(3, 3, 'thanh xuân 2', 'thanh xuân còn mãi', 'Vì sao lời chúc kỷ yếu quan trọng trong album thanh xuân của mỗi chúng ta?\r\nMột tấm ảnh có thể lưu giữ khoảnh khắc, nhưng chính những lời viết đi kèm mới kể trọn câu chuyện phía sau. Những caption ảnh kỷ yếu, lời tựa hay lời mở đầu kỷ yếu mang theo cảm xúc của mỗi người: vui, tiếc nuối, trưởng thành và cả những lời chưa từng nói. Khi album ảnh kỷ yếu cấp 3 được xem lại sau nhiều năm, những dòng chữ ấy sẽ đánh thức ký ức, giúp người xem nhớ lại tiếng cười, những buổi sáng trễ học, những lần chạy deadline hay cả những người bạn từng thân thiết. Việc lựa chọn lời chúc còn giúp album trông chỉnh chu hơn, có mạch cảm xúc và thể hiện rõ tính cách của lớp.', 'albums/1778870455_chup-anh-tot-nghiep.jpg', 1, 1, '2026-05-15 11:40:55', '2026-05-15 11:40:55'),
(4, 4, 'thanh xuân 3', 'thanh xuân còn mãi', 'Vì sao nên chụp một bộ ảnh kỷ yếu thanh xuân?\r\nThanh xuân chỉ có một lần duy nhất đối với mỗi người. Vì vậy, tốt nhất là hãy lưu giữ những kỷ niệm của tuổi thanh xuân bằng những bức ảnh đẹp và tươi sáng. Chụp kỷ yếu concept thanh xuân nên được thực hiện ngay khi bạn đang ở độ tuổi đẹp nhất.\r\nNhiều người chọn chụp kỷ yếu ảnh thanh xuân vì muốn lưu lại những kỉ niệm đẹp nhất và giữ giá trị về sau. Đây sẽ là bộ ảnh chứa đầy kỷ niệm cũng như các giá trị tinh thần sẽ theo chúng ta suốt đời. Sau này chúng ta có thể có khoe với con cháu về những tháng năm tuổi trẻ đẹp đẽ của riêng mình.', 'albums/1778870540_thanh-xuan-1-2048x1317.jpg', 1, 1, '2026-05-15 11:42:20', '2026-05-15 11:42:20');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `class_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `student_count` int(11) NOT NULL,
  `time` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `manager_response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `user_id`, `package_id`, `class_name`, `phone`, `area`, `student_count`, `time`, `note`, `status`, `manager_response`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'IT18', '0333414954', 'Hà Nội', 1, 'Tháng 6-7', NULL, 'completed', 'chúng tôi sẽ liên hệ với quý khách ạ', '2026-05-15 10:28:57', '2026-05-15 10:30:18', NULL);

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
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_11_194950_create_packages_table', 1),
(5, '2026_04_11_194951_create_bookings_table', 1),
(6, '2026_04_11_194952_create_albums_table', 1),
(7, '2026_04_11_194953_add_role_to_users_table', 1),
(8, '2026_04_11_194953_create_reviews_table', 1),
(9, '2026_04_16_000000_create_consultations_table', 1),
(10, '2026_05_06_000000_add_user_id_to_consultations_table', 2),
(13, '2026_05_08_232356_rename_booking_id_to_consultation_id_in_reviews_table', 3),
(14, '2026_05_08_232411_rename_booking_id_to_consultation_id_in_albums_table', 3),
(15, '2026_05_10_000001_add_manager_response_to_consultations_table', 4),
(16, '2026_05_10_000002_rename_consultation_id_to_booking_id_in_albums_table', 5),
(17, '2026_05_12_000000_create_photos_table', 6),
(18, '2026_05_12_000001_rename_reviews_booking_id_to_consultation_id', 6),
(19, '2026_05_12_000002_add_package_id_to_consultations_table', 6),
(20, '2026_05_12_000003_normalize_consultation_review_album_data', 6),
(21, '2026_05_12_000000_add_soft_deletes_to_consultations_table', 7),
(22, '2026_05_12_000004_update_reviews_table_add_fields_nullable_consultation_id', 8),
(23, '2026_05_14_000000_create_review_images_table', 9),
(24, '2026_05_16_000000_update_consultations_table_add_fields', 10);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `features` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `photos_count` int(11) NOT NULL DEFAULT 0,
  `videos_count` int(11) NOT NULL DEFAULT 0,
  `concepts_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `features`, `price`, `photos_count`, `videos_count`, `concepts_count`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Gói Cơ Bản', 'Dành Cho Lớp Thích Sự Đơn Giản\r\nGói chụp cơ bản phù hợp cho các lớp học yêu thích sự đơn giản nhưng vẫn muốn ghi lại những khoảnh khắc đáng nhớ nhất. BFF sẽ giúp bạn chụp trong những bối cảnh quen thuộc như lớp học, trường học, với các trang phục áo dài, vest, hoặc đồng phục lớp.', '[\"Th\\u1eddi gian ch\\u1ee5p: 1 ng\\u00e0y (7h30- 19h)\",\"Ekip ch\\u1ee5p \\u1ea3nh: 15-20 ng\\u01b0\\u1eddi\\/th\\u1ee3 ch\\u1ee5p\",\"Trang ph\\u1ee5c c\\u01a1 b\\u1ea3n: Set \\u00e1o d\\u00e0i n\\u1eef (qu\\u1ea7n, \\u00e1o d\\u00e0i), set vest nam (\\u00e1o, qu\\u1ea7n \\u00e2u, cavat), b\\u1ed9 trang ph\\u1ee5c c\\u1eed nh\\u00e2n (b\\u1eb1ng, m\\u0169, \\u00e1o)\",\"T\\u1eb7ng 01 g\\u00f3i ch\\u1ee5p Party Night\",\"T\\u1eb7ng ch\\u1ee5p free cho ph\\u1ee5 huynh - gi\\u00e1o vi\\u00ean\",\"Free decor trang tr\\u00ed, \\u0111\\u00e8n cho combo ch\\u1ee5p t\\u1ed1i\",\"Qu\\u00e0 t\\u1eb7ng: B\\u1eddm t\\u00f3c, gi\\u1ea5y m\\u00e0u g\\u1ea5p m\\u00e1y bay, loa th\\u00f9ng, ch\\u00f9m b\\u00f3ng bay (n\\u1ed9i th\\u00e0nh H\\u00e0 N\\u1ed9i)\",\"Chong ch\\u00f3ng cho concept thanh xu\\u00e2n\",\"\\u1ea4n ph\\u1ea9m: 01 \\u1ea3nh g\\u1ed7 30\\u00d745 cm cao c\\u1ea5p t\\u1eb7ng t\\u1eadp th\\u1ec3 l\\u1edbp, 02 \\u1ea3nh 13x18cm t\\u1eb7ng cho m\\u1ed7i c\\u00e1 nh\\u00e2n\",\"Ch\\u1ee5p \\u1ea3nh kh\\u00f4ng gi\\u1edbi h\\u1ea1n s\\u1ed1 l\\u01b0\\u1ee3ng\",\"Ch\\u1ec9nh s\\u1eeda m\\u00e0u to\\u00e0n b\\u1ed9 file ch\\u1ee5p\",\"T\\u1eb7ng thi\\u1ebft k\\u1ebf khi \\u0111\\u1eb7t in photobook k\\u1ef7 y\\u1ebfu\"]', 399000.00, 999, 1, 4, 1, '2026-05-11 17:40:23', '2026-05-11 17:40:23'),
(3, 'Gói Concept Family 2', 'Sáng Tạo Với Nhiều Phong Cách\r\nGói Concept BFF2 là lựa chọn cân bằng giữa sáng tạo ý tưởng và chi phí hợp lý, phù hợp với những tập thể muốn bộ ảnh kỷ yếu có màu sắc riêng nhưng vẫn gọn gàng, dễ triển khai. Nếu bạn mong muốn bộ ảnh có sự đa dạng về phong cách, từ hiện đại đến cổ điển, đây là sự lựa chọn lý tưởng dành cho lớp bạn', '[\"Th\\u1eddi gian ch\\u1ee5p: 1 ng\\u00e0y (7h30- 19h)\",\"Ekip ch\\u1ee5p \\u1ea3nh: 15-20 ng\\u01b0\\u1eddi\\/th\\u1ee3 ch\\u1ee5p\",\"Trang ph\\u1ee5c c\\u01a1 b\\u1ea3n: Set \\u00e1o d\\u00e0i n\\u1eef (qu\\u1ea7n, \\u00e1o d\\u00e0i), set vest nam (\\u00e1o, qu\\u1ea7n \\u00e2u, cavat), b\\u1ed9 trang ph\\u1ee5c c\\u1eed nh\\u00e2n (b\\u1eb1ng, m\\u0169, \\u00e1o)\",\"01 Trang ph\\u1ee5c concept t\\u1ef1 ch\\u1ecdn: l\\u1ef1a ch\\u1ecdn trong c\\u00e1c trang ph\\u1ee5c c\\u00f3 s\\u1eb5n t\\u1ea1i BFF ho\\u1eb7c l\\u1edbp t\\u1ef1 chu\\u1ea9n b\\u1ecb trang ph\\u1ee5c\",\"T\\u1eb7ng 01 g\\u00f3i ch\\u1ee5p Party Night\",\"T\\u1eb7ng ch\\u1ee5p free cho ph\\u1ee5 huynh - gi\\u00e1o vi\\u00ean\",\"Free decor trang tr\\u00ed, \\u0111\\u00e8n cho combo ch\\u1ee5p t\\u1ed1i\",\"Qu\\u00e0 t\\u1eb7ng: B\\u1eddm t\\u00f3c, gi\\u1ea5y m\\u00e0u g\\u1ea5p m\\u00e1y bay, loa th\\u00f9ng, ch\\u00f9m b\\u00f3ng bay (n\\u1ed9i th\\u00e0nh H\\u00e0 N\\u1ed9i)\",\"Chong ch\\u00f3ng cho concept thanh xu\\u00e2n\",\"\\u1ea4n ph\\u1ea9m: 01 \\u1ea3nh g\\u1ed7 30\\u00d745 cm cao c\\u1ea5p t\\u1eb7ng t\\u1eadp th\\u1ec3 l\\u1edbp, 02 \\u1ea3nh 13x18cm t\\u1eb7ng cho m\\u1ed7i c\\u00e1 nh\\u00e2n\",\"T\\u1eb7ng 01 video ch\\u1ea1y \\u1ea3nh chuy\\u00ean nghi\\u1ec7p\",\"Ch\\u1ee5p \\u1ea3nh kh\\u00f4ng gi\\u1edbi h\\u1ea1n s\\u1ed1 l\\u01b0\\u1ee3ng\",\"Ch\\u1ec9nh s\\u1eeda m\\u00e0u to\\u00e0n b\\u1ed9 file ch\\u1ee5p\",\"T\\u1eb7ng thi\\u1ebft k\\u1ebf khi \\u0111\\u1eb7t in photobook k\\u1ef7 y\\u1ebfu\"]', 498000.00, 999, 1, 3, 1, '2026-05-13 17:02:54', '2026-05-13 17:02:54'),
(4, 'Gói Xe Đưa Đón Family3', 'Biến Ước Mơ Thành Hiện Thực\r\nGói Xe Đưa Đón BFF3 là lựa chọn nâng cấp tiện lợi dành cho các lớp muốn buổi chụp kỷ yếu diễn ra trọn vẹn, thoải mái và tiết kiệm thời gian di chuyển. BFF3 phù hợp với những lớp đông học sinh, lịch trình nhiều điểm chụp, mong muốn một ngày chụp kỷ yếu nhẹ nhàng, chỉn chu và tối ưu trải nghiệm cho toàn bộ tập thể.', '[\"Th\\u1eddi gian ch\\u1ee5p: 1 ng\\u00e0y (7h30- 19h)\",\"Ekip ch\\u1ee5p \\u1ea3nh: 15-20 ng\\u01b0\\u1eddi\\/th\\u1ee3 ch\\u1ee5p\",\"Trang ph\\u1ee5c c\\u01a1 b\\u1ea3n: Set \\u00e1o d\\u00e0i n\\u1eef (qu\\u1ea7n, \\u00e1o d\\u00e0i), set vest nam (\\u00e1o, qu\\u1ea7n \\u00e2u, cavat), b\\u1ed9 trang ph\\u1ee5c c\\u1eed nh\\u00e2n (b\\u1eb1ng, m\\u0169, \\u00e1o)\",\"Xe \\u00f4 t\\u00f4 \\u0111\\u01b0a \\u0111\\u00f3n \\u0111\\u1ebfn c\\u00e1c \\u0111\\u1ecba \\u0111i\\u1ec3m ch\\u1ee5p (b\\u00e1n k\\u00ednh 25km, >25km ph\\u00e1t sinh ph\\u1ee5 ph\\u00ed t\\u00f9y \\u0111\\u1ecba \\u0111i\\u1ec3m di chuy\\u1ec3n)\",\"T\\u1eb7ng 01 g\\u00f3i ch\\u1ee5p Party Night\",\"T\\u1eb7ng ch\\u1ee5p free cho ph\\u1ee5 huynh - gi\\u00e1o vi\\u00ean\",\"Free decor trang tr\\u00ed, \\u0111\\u00e8n cho combo ch\\u1ee5p t\\u1ed1i\",\"Qu\\u00e0 t\\u1eb7ng: B\\u1eddm t\\u00f3c, gi\\u1ea5y m\\u00e0u g\\u1ea5p m\\u00e1y bay, loa th\\u00f9ng, ch\\u00f9m b\\u00f3ng bay (n\\u1ed9i th\\u00e0nh H\\u00e0 N\\u1ed9i)\",\"Chong ch\\u00f3ng cho concept thanh xu\\u00e2n\",\"\\u1ea4n ph\\u1ea9m: 01 \\u1ea3nh g\\u1ed7 30\\u00d745 cm cao c\\u1ea5p t\\u1eb7ng t\\u1eadp th\\u1ec3 l\\u1edbp, 02 \\u1ea3nh 13x18cm t\\u1eb7ng cho m\\u1ed7i c\\u00e1 nh\\u00e2n\",\"T\\u1eb7ng 01 video ch\\u1ea1y \\u1ea3nh chuy\\u00ean nghi\\u1ec7p\",\"Ch\\u1ee5p \\u1ea3nh kh\\u00f4ng gi\\u1edbi h\\u1ea1n s\\u1ed1 l\\u01b0\\u1ee3ng\",\"Ch\\u1ec9nh s\\u1eeda m\\u00e0u to\\u00e0n b\\u1ed9 file ch\\u1ee5p\",\"T\\u1eb7ng thi\\u1ebft k\\u1ebf khi \\u0111\\u1eb7t in photobook k\\u1ef7 y\\u1ebfu\"]', 680000.00, 999, 4, 4, 1, '2026-05-13 17:04:28', '2026-05-13 17:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `school` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `rating` tinyint(1) NOT NULL DEFAULT 5,
  `quote` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `consultation_id`, `name`, `school`, `class`, `rating`, `quote`, `image`, `is_featured`, `is_published`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Đặng Tiến Đạt', 'EAUT', '18', 5, 'tốt', 'reviews/1778545446_1.jpg', 0, 1, '2026-05-11 17:24:06', '2026-05-11 17:24:16'),
(2, NULL, 'Đặng Tiến Đạt', 'EAUT', '18', 5, 'rất tốt', NULL, 0, 0, '2026-05-13 17:14:55', '2026-05-13 17:14:55');

-- --------------------------------------------------------

--
-- Table structure for table `review_images`
--

CREATE TABLE `review_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','manager','user') DEFAULT 'user',
  `school` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `school`, `class`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'dtd@admin.com', '$2y$12$XBKVXhPwxOlPirkxIk989ebxb/t92mxnMIvdSAcoaiygCgPBtk5Py', NULL, 'admin', NULL, NULL, '2026-05-11 16:36:36', '2026-05-11 16:36:52'),
(2, 'Manager', 'manager@example.com', '$2y$12$l2wscgkXxzbRBbYDnMCz7eqSPWWwUVrICM0APzhIjIiZkVl2FBB0G', NULL, 'manager', NULL, NULL, '2026-05-11 16:36:52', '2026-05-11 16:36:52'),
(3, 'Test User', 'test@example.com', '$2y$12$La25fW1Q40vbtwIAcfEmIeEnnnE21AsIx7JjYkhddhG19rLIotMoO', NULL, 'user', NULL, NULL, '2026-05-11 16:36:52', '2026-05-11 16:36:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `albums_package_id_foreign` (`package_id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultations_user_id_foreign` (`user_id`),
  ADD KEY `consultations_package_id_foreign` (`package_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_consultation_id_foreign` (`consultation_id`);

--
-- Indexes for table `review_images`
--
ALTER TABLE `review_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_images_review_id_index` (`review_id`);

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
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review_images`
--
ALTER TABLE `review_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_consultation_id_foreign` FOREIGN KEY (`consultation_id`) REFERENCES `consultations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_images`
--
ALTER TABLE `review_images`
  ADD CONSTRAINT `review_images_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
