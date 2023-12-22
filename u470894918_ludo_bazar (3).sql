-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 22, 2023 at 07:29 PM
-- Server version: 10.6.15-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u470894918_ludo_bazar`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `session_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `status`, `session_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'super admin', 'superadmin@ludobazar.com', '$2y$12$0TwLV6cRlsfThMW1X6NEBOzl4Ao518hRq9tLud1lDGyPTUFhTpyti', '1', 'b2ac978ef38a08f086b0e710081527a9', '2023-12-12 09:51:41', '2023-12-22 19:23:03', NULL),
(2, 'admin', 'admin@admin.com', '$2y$12$sn1ZPDWRYSlhqVEMIdaQderfTVFrf3CFfZwmfGfE3Ldia0hgS9XtC', '1', NULL, '2023-12-19 17:04:59', '2023-12-22 12:03:57', NULL),
(3, 'manager', 'manager@ludobazar.com', '$2y$12$ixf6ruQbDbwQiJSCGt/wquiqT5GRE7U1LmCmFPIL9x19RJsQfAzWu', '1', NULL, '2023-12-19 17:07:13', '2023-12-22 12:04:26', NULL),
(4, 'supervisor', 'supervisor_d@ludobazar.com', '$2y$12$k9YXXv5NagbhJbhKZ.CcZuDacpiJ71rDb108d64ShN1Y6jbFR6BA6', '1', NULL, '2023-12-19 17:07:24', '2023-12-22 12:04:54', NULL),
(5, 'supervisor', 'supervisor_w@ludobazar.com', '$2y$12$1yvnRpg0fYDEMYPUZPe.huBEhZGSlqttbm7KW.FAn0OoivPnWNDO2', '1', NULL, '2023-12-19 17:10:08', '2023-12-22 12:05:28', NULL),
(6, 'main', 'main@main.com', '$2y$12$0TwLV6cRlsfThMW1X6NEBOzl4Ao518hRq9tLud1lDGyPTUFhTpyti', '1', '64850032', '2023-12-20 00:48:43', '2023-12-22 18:42:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ludo classic', 'ludo.png', 1, '2023-11-20 09:14:21', '2023-12-17 07:43:38', NULL),
(2, 'snakes & ladders', 'Snake.png', 1, '2023-11-20 09:14:21', '2023-11-20 09:14:21', NULL),
(3, 'Lala JI ki Dukan', '70920jason-d-JKRXPwUoFt0-unsplash.jpg', 0, '2023-12-17 07:51:46', '2023-12-19 07:28:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_amount` decimal(20,3) NOT NULL,
  `amount` decimal(20,3) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `comment` text DEFAULT NULL,
  `status` enum('pending','success','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_id` bigint(20) UNSIGNED NOT NULL,
  `accepted_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(20,3) NOT NULL,
  `room_code` varchar(255) DEFAULT NULL,
  `room_code_timer` bigint(20) DEFAULT NULL,
  `accepter_timer` bigint(20) DEFAULT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0' COMMENT '0=>matching,1=>start,2=>ongoing,3=>status_update,4=>complete,5=>canceled',
  `comment` text DEFAULT NULL,
  `winner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `winner_amount` decimal(20,3) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_results`
--

CREATE TABLE `game_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('win','lose','cancel') NOT NULL,
  `comment` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(5, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(6, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(7, '2016_06_01_000004_create_oauth_clients_table', 1),
(8, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(9, '2019_08_19_000000_create_failed_jobs_table', 1),
(10, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(11, '2023_11_17_175230_create_user_details_table', 1),
(12, '2023_11_17_180434_create_categories_table', 1),
(13, '2023_11_17_182322_create_games_table', 1),
(14, '2023_11_17_184714_create_game_results_table', 1),
(15, '2023_11_18_050518_create_transactions_table', 1),
(16, '2023_12_08_100040_create_deposits_table', 2),
(17, '2023_12_11_070654_create_withdrawals_table', 2),
(18, '0000_00_00_000000_create_websockets_statistics_entries_table', 3),
(19, '2023_12_11_122154_create_jobs_table', 4),
(20, '2023_12_12_094349_create_admins_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('063815147f1918fced19e44e1532eede84bb02abd465102205ddf1d216e975a1846bc6dbef0b2691', 55, 1, 'API Token', '[]', 0, '2023-12-20 13:09:04', '2023-12-20 13:09:04', '2024-12-20 13:09:04'),
('06e25b4ff4bd9ef784856bcd67232d2bf8b8e4f6d8a16095cb7e1545ae40a77c0edb2f7300ab3197', 54, 1, 'API Token', '[]', 0, '2023-12-18 15:13:28', '2023-12-18 15:13:28', '2024-12-18 15:13:28'),
('0bd5744f9ce6dce94cd02bbc7e8d2374c7626a3beef67eb753d3792282a26d280763341737fbfa5a', 31, 1, 'API Token', '[]', 0, '2023-12-03 21:53:56', '2023-12-03 21:53:56', '2024-12-03 21:53:56'),
('0f62e30850941cda2aa9d968567021172f8d73dbb30d388a6776955ba5ecf889c8571a33cc29044c', 48, 1, 'API Token', '[]', 0, '2023-12-14 12:27:49', '2023-12-14 12:27:49', '2024-12-14 12:27:49'),
('121f9eb36652ab2d067cd6f3a47d20d4ff299183a61194e54bd9d6996a051cba08c0e0f229fc908f', 45, 1, 'API Token', '[]', 0, '2023-12-09 16:50:47', '2023-12-09 16:50:47', '2024-12-09 16:50:47'),
('14baba4cbaff2a39adf8bb2e8c8205a99e7b111f2c451d724e672dc6ea65e4905c79874bd8aa1f85', 3, 1, 'API Token', '[]', 0, '2023-12-22 17:38:11', '2023-12-22 17:38:11', '2024-12-22 17:38:11'),
('15053b188f69b88c9317813c890237c445725589dc012eeaf7e775ebf57f764e46a54b65dc6dcb50', 40, 1, 'API Token', '[]', 0, '2023-12-14 12:53:01', '2023-12-14 12:53:01', '2024-12-14 12:53:01'),
('1a77c85e196a216a1c44c3decc5af7dc463a0f590fbc79a86e7eed60a7d4c88f4f66d917886ab8c1', 40, 1, 'API Token', '[]', 0, '2023-12-10 08:31:55', '2023-12-10 08:31:55', '2024-12-10 08:31:55'),
('1af88db03bec0aa2832d3bb1a878af648daf47661ee668b3d876ad3d8b4f0c54c9285fc09df28cbd', 42, 1, 'API Token', '[]', 0, '2023-12-08 19:00:27', '2023-12-08 19:00:27', '2024-12-08 19:00:27'),
('200cdf7057ae33b688763a9fb2f695e88b9e371c8d263f56fe73823d041a2600d4d11c9eb5d68010', 50, 1, 'API Token', '[]', 0, '2023-12-19 06:04:10', '2023-12-19 06:04:10', '2024-12-19 06:04:10'),
('24553a968b20e28867ebb02d4456b33837e059ae3f1830e40b22d6eb710f82ede12e8107669afbe8', 33, 1, 'API Token', '[]', 0, '2023-12-20 11:54:20', '2023-12-20 11:54:20', '2024-12-20 11:54:20'),
('2e52765bf109c51a786b7f982433299cbe4843839b4f5e885a5ae0ff83c62e469c1b7e80fca7e47c', 46, 1, 'API Token', '[]', 0, '2023-12-10 15:32:24', '2023-12-10 15:32:24', '2024-12-10 15:32:24'),
('2f0b0e011a0ab3d861f42a41b7983ff18a569fd357d70b672a01b325494963bcab10b0c3a5be164e', 8, 1, 'API Token', '[]', 0, '2023-12-21 18:21:43', '2023-12-21 18:21:43', '2024-12-21 18:21:43'),
('3384ba1a982e225dc7b836166035ca6fa4ad40f14ca79ba3d61a5e36d5f30f205ab85b61177a15ce', 37, 1, 'API Token', '[]', 0, '2023-12-06 13:23:31', '2023-12-06 13:23:31', '2024-12-06 13:23:31'),
('36a19415db5f26254cece5ba96026607bcd9b12b7bffbf40e1227953aefef053725a3f0f5efa3328', 10, 1, 'API Token', '[]', 0, '2023-12-20 17:27:33', '2023-12-20 17:27:33', '2024-12-20 17:27:33'),
('37d168ad6b0484bdb49ced684262b1654771f8f787367dca0ad565a54af9c74a1194a57045140a55', 20, 1, 'API Token', '[]', 0, '2023-12-21 18:21:13', '2023-12-21 18:21:13', '2024-12-21 18:21:13'),
('43b21ac01fe388298a9c5609cb898968e7e5e414cf04aa2fde4131025c21d39599a2fcc4f04e71f5', 53, 1, 'API Token', '[]', 0, '2023-12-17 13:22:17', '2023-12-17 13:22:17', '2024-12-17 13:22:17'),
('4a683db260db35779b8c4e52f0d988b86aae254e6d12c468142a7a3511fa6157d6f6cd4bf508b394', 38, 1, 'API Token', '[]', 0, '2023-12-06 15:48:31', '2023-12-06 15:48:31', '2024-12-06 15:48:31'),
('4c89b4021d713a6398a9fae10a8bf06d11696856136adbd61d59dc26302e73cceab4a34559ac3cfb', 21, 1, 'API Token', '[]', 0, '2023-12-21 18:31:54', '2023-12-21 18:31:54', '2024-12-21 18:31:54'),
('4e279a37d76199a2ea397e1339d36d8d67ae9f24b350122e45907122733c343bd109a590ec12984d', 16, 1, 'API Token', '[]', 0, '2023-12-21 09:03:17', '2023-12-21 09:03:17', '2024-12-21 09:03:17'),
('5419f62b922314057efe78bb73bf77d07cdbd4b566024005eb7a674a74e5adfdad4dd0d8a7725e3e', 22, 1, 'API Token', '[]', 0, '2023-12-22 03:36:23', '2023-12-22 03:36:23', '2024-12-22 03:36:23'),
('5566e4407240921f9a54b3dc94c802b1d4f8406f07c2f6c5ae782167bb4827e4d9ee91a282ba5a37', 36, 1, 'API Token', '[]', 0, '2023-12-20 16:14:11', '2023-12-20 16:14:11', '2024-12-20 16:14:11'),
('56fde1367bf353ad8c6d9b2d013321209445cbee5105fa7a7c2f8e0eab1422c63ce37f935f63745d', 15, 1, 'API Token', '[]', 1, '2023-12-21 04:57:15', '2023-12-21 04:57:41', '2024-12-21 04:57:15'),
('597eac2bfc7fff18855fb8aef32b16055ae9d77a831eba424090ba600efc3dd25ee6c243a08c2b36', 26, 1, 'API Token', '[]', 0, '2023-12-04 18:05:40', '2023-12-04 18:05:40', '2024-12-04 18:05:40'),
('5d490e8d6731c65bfae70b0fcd0d79517a1203171e077b40029c7f442f0ef7806495a33ffa0fcde7', 5, 1, 'API Token', '[]', 0, '2023-12-22 17:30:16', '2023-12-22 17:30:16', '2024-12-22 17:30:16'),
('6504bfc924c7b582ad14a6bff1dcec0c721794bb0208f22b046e6374082043a63e22cb152472b79e', 18, 1, 'API Token', '[]', 0, '2023-12-21 09:05:35', '2023-12-21 09:05:35', '2024-12-21 09:05:35'),
('769a98334dd55b0f99f2ad752d9f18858af630ee162671b960e5f83d63ef119b725199429842d4a0', 40, 1, 'API Token', '[]', 0, '2023-12-09 13:01:50', '2023-12-09 13:01:50', '2024-12-09 13:01:50'),
('7cac430e87f4bd404ce24b788ae1271bf640117ca422c951f9b646d7d49e8524e749d1ed58f9775e', 58, 1, 'API Token', '[]', 0, '2023-12-20 13:46:16', '2023-12-20 13:46:16', '2024-12-20 13:46:16'),
('838a69cb48708852218c76e0e4d109f7947a6690c727c0db1227a670b628d3d7aa9f6d6f39bcb70a', 48, 1, 'API Token', '[]', 0, '2023-12-14 12:28:44', '2023-12-14 12:28:44', '2024-12-14 12:28:44'),
('89cb94cb83290b8e047dc195412f3e9f71dbb18be86caaf8f18dc0f999f55137cbc27b2c48bf0762', 27, 1, 'API Token', '[]', 0, '2023-12-03 21:30:45', '2023-12-03 21:30:45', '2024-12-03 21:30:45'),
('90d6fc8eeded63dcc497c40d75b7c0a873facb62acd14b060be9bdaaf3a08e3bdcd54d6615294c3f', 28, 1, 'API Token', '[]', 0, '2023-12-03 21:30:12', '2023-12-03 21:30:12', '2024-12-03 21:30:12'),
('91ff9b8c71f68e505236595762b65ccf4fb51b51724444477223a568e707bedcfa0bf4b350dc47e4', 40, 1, 'API Token', '[]', 0, '2023-12-09 06:02:55', '2023-12-09 06:02:55', '2024-12-09 06:02:55'),
('9ceaa2f91b69f28cd6026a9e220aa464776da2b98dba2a7ba19031a3aab412d030425e124df7ea5d', 25, 1, 'API Token', '[]', 0, '2023-12-19 16:59:41', '2023-12-19 16:59:41', '2024-12-19 16:59:41'),
('9fb0ac094d4943498bd3e8e25a14eb2683d4678d74705e674ab51503f293299b827374f1ceb5a6fa', 56, 1, 'API Token', '[]', 1, '2023-12-20 11:58:25', '2023-12-20 12:47:29', '2024-12-20 11:58:25'),
('a0934ff047833350cfe9f79408d41d8dda5f37f0289187127b4f247a4f5207fb73bd5dcd5de867f3', 34, 1, 'API Token', '[]', 0, '2023-12-18 18:03:55', '2023-12-18 18:03:55', '2024-12-18 18:03:55'),
('a24958405180a1aeed4ddbcec56bb2b3ed8ec2fdfca04618acdd86b7928a7d254037e6e8c16767b6', 32, 1, 'API Token', '[]', 0, '2023-12-07 18:50:41', '2023-12-07 18:50:41', '2024-12-07 18:50:41'),
('a5202f4e977bbc9ef1c42ce20bafad7437ed0d39c6a0d5ee47e5ac689d2a10fde7cf8472bcaa7cc5', 19, 1, 'API Token', '[]', 0, '2023-12-21 13:51:48', '2023-12-21 13:51:48', '2024-12-21 13:51:48'),
('a837add27c4340e7b08562891e6e317f43ad157f463fe0614b991b1ec0931f75fb5679b443de3200', 32, 1, 'API Token', '[]', 0, '2023-12-03 21:54:44', '2023-12-03 21:54:44', '2024-12-03 21:54:44'),
('ac062f25f441a0fba8ba5838695415307b1617fc58da70f3eaa08c8fb497b924fc71016ab6a0cea2', 23, 1, 'API Token', '[]', 0, '2023-12-03 20:19:12', '2023-12-03 20:19:12', '2024-12-03 20:19:12'),
('ac6091387812d04435e99d02bae5f7e172503c08ef3bf91f23da258c4107e55ae77274360ca0e999', 26, 1, 'API Token', '[]', 0, '2023-12-08 19:11:33', '2023-12-08 19:11:33', '2024-12-08 19:11:33'),
('b174972d1c9cb6a4b0cca5e8390e3e81ed8a1b3996099f67f749fa1f92e0e86d9cb192b092a96b1d', 29, 1, 'API Token', '[]', 0, '2023-12-03 21:47:55', '2023-12-03 21:47:55', '2024-12-03 21:47:55'),
('b1fd416f7859d94eca67d69c8134c7038f33f788fe380a02b1278b2fef9e7c41852c4bdc8e53283d', 17, 1, 'API Token', '[]', 0, '2023-12-21 08:13:00', '2023-12-21 08:13:00', '2024-12-21 08:13:00'),
('b2c36729c68f2d5ef755074935a4f299b4443820ca91f3c7bc2873832c26e76562f4feaf9cec6529', 9, 1, 'API Token', '[]', 0, '2023-12-21 06:57:01', '2023-12-21 06:57:01', '2024-12-21 06:57:01'),
('b463f48239d1c8e62d726dcbaf5fb77e1184113fc2f1de6861eb92161d7918f1aef44fd93e1f6762', 24, 1, 'API Token', '[]', 0, '2023-12-03 20:19:40', '2023-12-03 20:19:40', '2024-12-03 20:19:40'),
('b8aaa86d92e9e37edec6f96e666f675e6f3ca15b2d3176acfdd8fb2a81d305557f4dace7eb1477c4', 12, 1, 'API Token', '[]', 0, '2023-12-20 18:25:20', '2023-12-20 18:25:20', '2024-12-20 18:25:20'),
('bbbb07e90543b7a2f5548745c60268b9040c62135f56a9f926f2b7809b706561fa4d7a34a39cde40', 48, 1, 'API Token', '[]', 0, '2023-12-14 12:32:03', '2023-12-14 12:32:03', '2024-12-14 12:32:03'),
('c6feedc1dc53642f0c481843bb9bdd89524f68ae1c5cc4695fc26de3b9eb99b235384f34cda58460', 40, 1, 'API Token', '[]', 0, '2023-12-15 13:42:56', '2023-12-15 13:42:56', '2024-12-15 13:42:56'),
('d74d1e25bad89dbcb117e777fe7c337bcbc43d67c9cb0ec8ac2c4a56462b2463ec3a5778c57a8baa', 11, 1, 'API Token', '[]', 0, '2023-12-21 04:43:37', '2023-12-21 04:43:37', '2024-12-21 04:43:37'),
('de6f1968c981556d67ed32cfac718557028ac7504b3e01627d9804d35e3a85ad8404758289f82a07', 44, 1, 'API Token', '[]', 0, '2023-12-20 08:21:18', '2023-12-20 08:21:18', '2024-12-20 08:21:18'),
('e09d7e85d125c0eb0596f7f28fbcb7ba8c82977ae60feef1871a4d705f38f3b9c6ac699483f4487a', 7, 1, 'API Token', '[]', 0, '2023-12-22 19:05:54', '2023-12-22 19:05:54', '2024-12-22 19:05:54'),
('e6af4f3c6c7322214d645d3c8700a06abf94b2f33e0a22416c76e12f767d35ba834848db90b81927', 2, 1, 'API Token', '[]', 0, '2023-12-22 18:52:48', '2023-12-22 18:52:48', '2024-12-22 18:52:48'),
('e7b3d74f6febff7e74f7809b658ca2a07d8d5e805c19ea24d584b25cd67f48f5f83a0b0bf5c265be', 40, 1, 'API Token', '[]', 0, '2023-12-07 12:02:15', '2023-12-07 12:02:15', '2024-12-07 12:02:15'),
('ebbf13d372a0cb4b6fedcc8a59ce17f242a9e770b919c1d44f65b1ed2c7ed15aa87d5e5b598731e2', 35, 1, 'API Token', '[]', 0, '2023-12-20 13:40:03', '2023-12-20 13:40:03', '2024-12-20 13:40:03'),
('ecb84f56028ba173d1c0dbd081530c8288b161dcb44b2b78f2e60f5885085e9e18723fe220b0ebef', 51, 1, 'API Token', '[]', 1, '2023-12-20 11:38:37', '2023-12-20 11:58:20', '2024-12-20 11:38:37'),
('ef42e2646ce900cb877643354f6fabf916b9c5db6946475017232d9644b44b402b60fdcedf244f0c', 57, 1, 'API Token', '[]', 0, '2023-12-20 11:59:51', '2023-12-20 11:59:51', '2024-12-20 11:59:51'),
('f920004e17b94ad4cfaf88f05bd0137a10be901a39f77f85495a2ffe7b36b5afc24249ac01d08f33', 6, 1, 'API Token', '[]', 0, '2023-12-22 18:52:35', '2023-12-22 18:52:35', '2024-12-22 18:52:35'),
('f946781990821d23940c2a0a289b788fa647852e3d602c10a018515926f5c3b8da050db3ee373949', 39, 1, 'API Token', '[]', 0, '2023-12-20 01:54:13', '2023-12-20 01:54:13', '2024-12-20 01:54:13'),
('f9b90fc4eab93f696a0dea9d7a6317bbd035804cccc8fa0a514266fc2c868df19fb4c07c90d3a2d0', 1, 1, 'API Token', '[]', 0, '2023-12-22 11:58:26', '2023-12-22 11:58:26', '2024-12-22 11:58:26'),
('f9eb93431906af6fbe847410375fae4578f20634ac5ac2196b18c58eafa7c66832e80f4acdcb5b53', 4, 1, 'API Token', '[]', 0, '2023-12-22 14:39:05', '2023-12-22 14:39:05', '2024-12-22 14:39:05'),
('fa21d0e553510f53bd668dca5d23e2b7379046a089de174377093ce23c0b4d1bb56fddb41560469b', 26, 1, 'API Token', '[]', 0, '2023-12-03 21:00:16', '2023-12-03 21:00:16', '2024-12-03 21:00:16'),
('fc71c1bd6c91ac73997d5febc9b5a4431801d085d17f86df64c5604b66c43d99801476512ef0de31', 30, 1, 'API Token', '[]', 0, '2023-12-03 21:47:59', '2023-12-03 21:47:59', '2024-12-03 21:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'AKLudo Personal Access Client', '27vQKCO7BduZYf0qTq21F9WAgV4uXdTbMFNplsbE', NULL, 'http://localhost', 1, 0, 0, '2023-11-18 05:08:15', '2023-11-18 05:08:15'),
(2, NULL, 'AKLudo Password Grant Client', 'JykL8YmtNfrebMk5hlyKEemS8r63Q7QEmINH9cLX', 'users', 'http://localhost', 0, 1, 0, '2023-11-18 05:08:15', '2023-11-18 05:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-11-18 05:08:15', '2023-11-18 05:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(73, 'upi_id', 'BOSS SE BAT KRE', '2023-12-22 04:55:56', '2023-12-22 04:55:56'),
(74, 'telegram', 'https://t.me/+qgbaVNauQnFlMzU9', '2023-12-22 04:55:56', '2023-12-22 04:55:56'),
(75, 'whatsapp', 'test', '2023-12-22 04:55:56', '2023-12-22 04:55:56'),
(76, 'qr_code', '20956qr.png', '2023-12-22 04:55:56', '2023-12-22 04:55:56');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(20,3) NOT NULL,
  `trans` int(11) NOT NULL COMMENT '0=>deposit,1=>play_game,2=>bonus,3=>win,4=>referral_bonus,5=>penalty,6=>withdrawal',
  `type_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `register_id` varchar(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `deposit_wallet` decimal(20,3) NOT NULL DEFAULT 0.000,
  `winning_wallet` decimal(20,3) NOT NULL DEFAULT 0.000,
  `otp` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `aadhar_front` varchar(255) DEFAULT NULL,
  `aadhar_back` varchar(255) DEFAULT NULL,
  `status` enum('pending','review','success') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `amount` decimal(20,3) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `upi_id` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` enum('pending','success','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `games_category_id_foreign` (`category_id`),
  ADD KEY `games_created_id_foreign` (`created_id`),
  ADD KEY `games_accepted_id_foreign` (`accepted_id`),
  ADD KEY `games_winner_id_foreign` (`winner_id`);

--
-- Indexes for table `game_results`
--
ALTER TABLE `game_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_results_game_id_foreign` (`game_id`),
  ADD KEY `game_results_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Key` (`key`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `register_id` (`register_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game_results`
--
ALTER TABLE `game_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_accepted_id_foreign` FOREIGN KEY (`accepted_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `games_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `games_created_id_foreign` FOREIGN KEY (`created_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `games_winner_id_foreign` FOREIGN KEY (`winner_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `game_results`
--
ALTER TABLE `game_results`
  ADD CONSTRAINT `game_results_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `game_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`u470894918_ludo_bazar`@`127.0.0.1` EVENT `Room_Code_Timer` ON SCHEDULE EVERY 30 SECOND STARTS '2023-12-01 19:23:43' ENDS '2025-12-01 19:23:43' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE games JOIN transactions ON games.id=transactions.type_id SET games.status='5', games.comment = 'timeup for room code',transactions.status = 0 WHERE games.status = '1' AND games.room_code_timer <= UNIX_TIMESTAMP() AND transactions.trans = 1 AND games.room_code IS NULL$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
