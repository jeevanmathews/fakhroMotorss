-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 26, 2019 at 04:53 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fakhro_motors`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(300) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `mailing_name` varchar(300) DEFAULT NULL,
  `address` text NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `phone` varchar(300) DEFAULT NULL,
  `email` varchar(300) NOT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `website` varchar(250) DEFAULT NULL,
  `cr_number` varchar(50) DEFAULT NULL,
  `cr_expiry` datetime DEFAULT NULL,
  `vat_number` varchar(50) DEFAULT NULL,
  `vat_expiry` datetime DEFAULT NULL,
  `branchtype_id` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `company_id`, `name`, `code`, `mailing_name`, `address`, `country_id`, `state`, `zipcode`, `phone`, `email`, `fax`, `website`, `cr_number`, `cr_expiry`, `vat_number`, `vat_expiry`, `branchtype_id`, `created_at`) VALUES
(2, 1, 'ghj', 'gfjf', 'gj', 'fdgdfg', 1, '', 'fdg', '21212', 'gfj#E@kjhlk.cc', 'gfdgfd', 'http://itvoyager.com', NULL, '1970-01-01 00:00:00', NULL, '1970-01-01 00:00:00', '3', '2019-03-22 13:30:05'),
(3, 1, 'Voyager It Solutions', 'VIS', 'Voyager', '1221212', 1, '121', '1212', '1212', 'info@voyager.in', '212', 'http://itvoyager.com', NULL, '1970-01-01 00:00:00', NULL, '1970-01-01 00:00:00', '1,2', '2019-03-22 14:49:46');

-- --------------------------------------------------------

--
-- Table structure for table `branch_types`
--

DROP TABLE IF EXISTS `branch_types`;
CREATE TABLE IF NOT EXISTS `branch_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(300) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch_types`
--

INSERT INTO `branch_types` (`id`, `type`, `status`, `created_date`) VALUES
(1, 'Warehouse', 1, '2019-03-22 10:44:27'),
(2, 'Service Center', 1, '2019-03-22 10:44:43'),
(3, 'Showroom', 1, '2019-03-22 15:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `mailing_name` varchar(300) DEFAULT NULL,
  `address` text NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `phone` varchar(300) DEFAULT NULL,
  `email` varchar(300) NOT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `website` varchar(250) DEFAULT NULL,
  `cr_number` varchar(50) DEFAULT NULL,
  `cr_expiry` varchar(100) DEFAULT NULL,
  `vat_number` varchar(50) DEFAULT NULL,
  `vat_expiry` varchar(100) DEFAULT NULL,
  `multi_branches` enum('yes','no') NOT NULL DEFAULT 'yes',
  `centrilized_warehouse` enum('yes','no') NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

DROP TABLE IF EXISTS `company_settings`;
CREATE TABLE IF NOT EXISTS `company_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `financial_year` varchar(100) DEFAULT NULL,
  `books_beginning` varchar(100) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `decimal_places` int(11) DEFAULT NULL,
  `suffix_symbol` enum('yes','no') DEFAULT 'yes',
  `enable_space` enum('yes','no') NOT NULL,
  `date_format` enum('d-m-Y','Y-m-d','m-d-Y') DEFAULT 'd-m-Y',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `phone_code` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `code`, `phone_code`, `status`, `created_at`) VALUES
(1, 'BAHRAIN', 'BH', '33', 1, '2019-03-21 12:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `symbol` char(100) DEFAULT NULL,
  `decimal_symbol` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `code`, `symbol`, `decimal_symbol`, `status`, `created_at`) VALUES
(1, 'Bahrain Dinar', 'BHD', '.Ø¯.Ø¨', '', 1, '2019-03-21 16:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `status`) VALUES
(1, 'Administration', 1),
(2, 'Store Management', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1551942608),
('m130524_201442_init', 1551942621);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(500) DEFAULT NULL,
  `action` varchar(500) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `module`, `action`, `status`) VALUES
(1, 'PermissionmasterController', 'index', 1),
(2, 'PermissionmasterController', 'view', 1),
(3, 'PermissionmasterController', 'create', 1),
(4, 'PermissionmasterController', 'update', 1),
(5, 'PermissionmasterController', 'delete', 1),
(6, 'RolesController', 'index', 1),
(7, 'RolesController', 'view', 1),
(8, 'RolesController', 'create', 1),
(9, 'RolesController', 'update', 1),
(10, 'RolesController', 'delete', 1),
(11, 'SiteController', 'index', 1),
(12, 'SiteController', 'login', 1),
(13, 'SiteController', 'logout', 1),
(14, 'BranchesController', 'index', 1),
(15, 'BranchesController', 'view', 1),
(16, 'BranchesController', 'create', 1),
(17, 'BranchesController', 'update', 1),
(18, 'BranchesController', 'delete', 1),
(19, 'CompanyController', '_index', 1),
(20, 'CompanyController', 'view', 1),
(21, 'CompanyController', '_create', 1),
(22, 'CompanyController', 'update', 1),
(23, 'CompanyController', '_delete', 1),
(24, 'CountryController', 'index', 1),
(25, 'CountryController', 'view', 1),
(26, 'CountryController', 'create', 1),
(27, 'CountryController', 'update', 1),
(28, 'CountryController', 'delete', 1),
(29, 'CurrencyController', 'index', 1),
(30, 'CurrencyController', 'view', 1),
(31, 'CurrencyController', 'create', 1),
(32, 'CurrencyController', 'update', 1),
(33, 'CurrencyController', 'delete', 1),
(34, 'DepartmentsController', 'index', 1),
(35, 'DepartmentsController', 'view', 1),
(36, 'DepartmentsController', 'create', 1),
(37, 'DepartmentsController', 'update', 1),
(38, 'DepartmentsController', 'delete', 1),
(39, 'PermissionmasterController', 'dashboard', 1),
(40, 'PermissionmasterController', 'permissions', 1),
(41, 'RolepermissionController', 'index', 1),
(42, 'RolepermissionController', 'view', 1),
(43, 'RolepermissionController', 'create', 1),
(44, 'RolepermissionController', 'update', 1),
(45, 'RolepermissionController', 'delete', 1),
(46, 'SiteController', 'launch', 1),
(47, 'SiteController', 'dashboard', 1),
(48, 'UserController', 'index', 1),
(49, 'UserController', 'view', 1),
(50, 'UserController', 'create', 1),
(51, 'UserController', 'update', 1),
(52, 'UserController', 'delete', 1),
(53, 'UserController', 'signup', 1),
(54, 'UserController', 'roles', 1),
(55, 'UserController', 'setroles', 1),
(56, 'UserController', 'uniqueemail', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `department_id`, `status`) VALUES
(1, 'Superadmin', 1, 1),
(2, 'Admin', NULL, 1),
(3, 'Accounts Manager', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE IF NOT EXISTS `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`, `status`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role_id`, `branch_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'john', '6-iKnyNm6s3F8gBKBDHWGy_rnyfFMTIS', '$2y$12$LniJV5sK5LpX/o0b2FPuVO6XDYj5MomCcH36Z4d0nxPxzw0WWn1A6', NULL, '', 1, 0, 10, 1490249848, 1552391184),
(2, 'Doe', '6-iKnyNm6s3F8gBKBDHWGy_rnyfFMTIS', '$2y$13$mwhyEQkubhVQiqWbXQDgquMZGZeDSYG2squLpoXhkrwtj5D3RVvpS', NULL, 'superadmin@gmail.com', 2, 1, 10, 1552387408, 1552566622),
(3, 'jeevan', 'NML7MyEUtb9BYlG-2_XjzIMAdnN-9Vf3', '$2y$13$6Gy/l41mEF/KkKW0/EatAOgO1qh5ic1ZdD6zG/gCHn1DpT87jEkua', NULL, 'jeevan@gmail.com', NULL, 0, 10, 1552563315, 1552563315),
(7, 'jee1', 'oapKrv4kaJg2k43k-rLopgirDkQgRtPt', '$2y$13$MIJR5rfmH0gDZq8RrBbpbeOvQkIO5KO85nR/APlsVutUnms19./KO', NULL, 'jee@gmail.com', NULL, 1, 10, 1552566226, 1552566346),
(10, 'john34', 'I6hZD6xXp_yV1znfoW-eXsjAsIk2fXph', '$2y$13$mGjdyQ3cpgTKDcPMzCeuPualqLQa21sI6oriWh2L3U.w10xOKVgs6', NULL, 'meghnaravinderan@gmail.com', NULL, 1, 10, 1553079869, 1553079869),
(11, 'admin', 'mjLQPcT3zAClA6eaikUpGT7xFODdfs52', '$2y$13$RJwSdbrIn5kxQRzAVNZaouHRiCEt1VK0y961Bl8DmQ9zvl0UhrP.m', NULL, 'admin@fkmotors.com', NULL, 1, 10, 1553148876, 1553148876),
(12, 'admin2', 'Ls_SChPdBwij3POc51rBgMEMNquADORL', '$2y$13$94ah6gtmcRj6SWimWRkt0.Qnk6TVma0XLRonMFlUPZx40/ZV4vXZa', NULL, 'admin2@gmail.com', NULL, 1, 10, 1553233964, 1553233964),
(13, 'admin3', 'pF_O5lzOqNrEFiNF5Q-5zUCBoIfYszFh', '$2y$13$gfmgjGza19Bfbu2j6xBCwOHDb2kfCOFH6GBB4DnGYaZHx3tdnoup6', NULL, 'admin3@gmail.com', NULL, 1, 10, 1553234065, 1553234065),
(14, 'admin4', '4zYye04JDrQhhBkdvzDpunePBX28vgtO', '$2y$13$j0tKbww0EYj8433n54cRWOFkkAhcWPQ7aObgy4fKHS1O8iD6wkr3m', NULL, 'admin4@gmail.com', NULL, 1, 10, 1553238970, 1553238970),
(15, 'admin12', 'xIU-TknwBGz6ZHvIDltQW2F-5jqX554O', '$2y$13$grtaDNk6r.VYnPj4Yo2j.u.LELXyfDD.O9FHEFWEJm3TwrLysC4dO', NULL, 'admin12@fkmotors.com', NULL, 1, 10, 1553572924, 1553572924);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
