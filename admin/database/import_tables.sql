-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2020 at 10:31 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `import_tables`
--

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` int(11) NOT NULL,
  `access_key` varchar(64) NOT NULL,
  `secret_access_key` varchar(64) NOT NULL,
  `region` varchar(32) NOT NULL,
  `bucket_name` varchar(255) NOT NULL,
  `smtp_host` varchar(64) NOT NULL,
  `smtp_port` varchar(32) NOT NULL,
  `smtp_encryption` varchar(32) NOT NULL,
  `email_login` varchar(64) NOT NULL,
  `email_password` varchar(64) NOT NULL,
  `from_email` varchar(64) NOT NULL,
  `from_name` varchar(64) NOT NULL,
  `email_cc` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `access_key`, `secret_access_key`, `region`, `bucket_name`, `smtp_host`, `smtp_port`, `smtp_encryption`, `email_login`, `email_password`, `from_email`, `from_name`, `email_cc`) VALUES
(1, '', '', 'eu-central-1', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `configs_google`
--

CREATE TABLE `configs_google` (
  `id` int(11) NOT NULL,
  `adsense_left` varchar(1024) NOT NULL,
  `adsense_right` varchar(1024) NOT NULL,
  `analytics_id` varchar(32) NOT NULL,
  `maps_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configs_google`
--

INSERT INTO `configs_google` (`id`, `adsense_left`, `adsense_right`, `analytics_id`, `maps_key`) VALUES
(1, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_dashboard`
--

CREATE TABLE `data_dashboard` (
  `id` int(11) NOT NULL,
  `total_uploads` int(11) NOT NULL,
  `total_bucket_size` int(11) NOT NULL,
  `emails_sent` int(11) NOT NULL,
  `links_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_dashboard`
--

INSERT INTO `data_dashboard` (`id`, `total_uploads`, `total_bucket_size`, `emails_sent`, `links_created`) VALUES
(1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `data_table_files`
--

CREATE TABLE `data_table_files` (
  `id` int(11) NOT NULL,
  `filename` varchar(256) NOT NULL,
  `filetype` varchar(256) NOT NULL,
  `size` int(11) NOT NULL,
  `sharetype` varchar(16) NOT NULL,
  `uploaddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `data_table_shares`
--

CREATE TABLE `data_table_shares` (
  `id` int(11) NOT NULL,
  `sharetype` varchar(32) NOT NULL,
  `filequantity` int(11) NOT NULL,
  `filenames` varchar(1024) NOT NULL,
  `senderemail` varchar(255) NOT NULL,
  `receiveremail` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `privatelink` varchar(32) NOT NULL,
  `expirationtime` varchar(32) NOT NULL,
  `uploaddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `data_upload_files`
--

CREATE TABLE `data_upload_files` (
  `id` int(11) NOT NULL,
  `total_files` int(11) NOT NULL,
  `upload_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `data_upload_traffic`
--

CREATE TABLE `data_upload_traffic` (
  `id` int(11) NOT NULL,
  `file_size` int(11) NOT NULL,
  `upload_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `upload_settings`
--

CREATE TABLE `upload_settings` (
  `id` int(11) NOT NULL,
  `max_size` int(11) NOT NULL,
  `max_quantity` int(11) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `share_type` varchar(16) NOT NULL,
  `server_encryption` varchar(16) NOT NULL,
  `signed_link` varchar(16) NOT NULL,
  `signed_link_expiration` int(11) NOT NULL,
  `chunk_size` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `copyright` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `upload_settings`
--

INSERT INTO `upload_settings` (`id`, `max_size`, `max_quantity`, `file_type`, `share_type`, `server_encryption`, `signed_link`, `signed_link_expiration`, `chunk_size`, `title`, `description`, `copyright`) VALUES
(1, 1000, 10, '[]', 'email', '', 'disabled', 1, 50, 'Upload & Share', '<h6>Direct Upload & Download from Wasabi Bucket</h6>\r\n<h6>with Native Multipart Feature</h6>', '<p>Copyright &copy; 2020</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `joindate` datetime NOT NULL,
  `email` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `joindate`, `email`) VALUES
(1, 'admin', 'first_name last_name', '$2y$10$kJC8qRWElkzIQFuCu13m4edRZNDcWO8Ov.PE8L89LSA0lwj27Ac0a', '2020-09-26 20:51:43', 'admin@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_table_files`
--
ALTER TABLE `data_table_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_table_shares`
--
ALTER TABLE `data_table_shares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_upload_files`
--
ALTER TABLE `data_upload_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_upload_traffic`
--
ALTER TABLE `data_upload_traffic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_settings`
--
ALTER TABLE `upload_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_table_files`
--
ALTER TABLE `data_table_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_table_shares`
--
ALTER TABLE `data_table_shares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_upload_files`
--
ALTER TABLE `data_upload_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_upload_traffic`
--
ALTER TABLE `data_upload_traffic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upload_settings`
--
ALTER TABLE `upload_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
