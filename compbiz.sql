-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2013 at 12:30 PM
-- Server version: 5.5.31
-- PHP Version: 5.4.4-14+deb7u4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `compbiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `phone1` varchar(32) NOT NULL,
  `phone2` varchar(32) NOT NULL,
  `email` varchar(256) NOT NULL,
  `address` varchar(512) NOT NULL,
  `notes` varchar(2048) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job` int(11) NOT NULL,
  `madeby` int(11) NOT NULL,
  `status` varchar(32) NOT NULL,
  `notes` varchar(5120) NOT NULL,
  `created` int(11) NOT NULL,
  `adminonly` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `createdby` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `passcode` varchar(256) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `account` int(11) NOT NULL,
  `flag` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
