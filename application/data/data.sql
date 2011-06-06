-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2011 at 05:38 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `wbvs`
--

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `vote_id`, `text`, `vote_count`) VALUES
(1, 1, 'Fine', 1),
(2, 1, 'Worse', 5),
(3, 1, 'Best', 1),
(4, 1, 'Better', 0),
(5, 2, 'Keep Going', 0),
(6, 2, 'Stop Doing This, Please!', 2);

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `fname`, `lname`, `email`, `password`, `company`, `is_admin`, `is_active`) VALUES
(1, 'roy2', 'simkes12', 'roy@kartaca.com', '356a192b7913b04c54574d18c28d46e6395428ab', 'park', 0, 1),
(2, 'ali', 'veil', 'ali@veli.com', '', '', 0, 0),
(6, 'roy', 'simkes', 'wbvs@wbvs.com', '7c222fb2927d828af22f592134e8932480637c0d', 'Kartaca', 1, 1);

--
-- Dumping data for table `participant_answers`
--

INSERT INTO `participant_answers` (`id`, `participant_id`, `vote_id`, `answer_id`) VALUES
(2, 6, 2, 6),
(3, 6, 1, 3);

--
-- Dumping data for table `participant_subscriptions`
--

INSERT INTO `participant_subscriptions` (`id`, `participant_id`, `vote_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 6, 2),
(4, 6, 1);

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `name`, `desc`, `expire_date`, `begin_date`) VALUES
(1, 'My First Voting', 'My first voting and I''m excited about it.', '2011-06-30 00:00:01', '2011-06-01 00:00:01'),
(2, 'Continuing Vote', 'Keep Going', '2011-06-30 14:07:00', '2011-06-02 14:07:00'),
(3, 'My Expired Voting', 'This one is already expired', '2011-06-02 14:07:00', '2011-06-02 14:07:00');
