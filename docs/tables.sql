-- MySQL dump 10.13  Distrib 5.1.30, for Win32 (ia32)
--
-- Host: localhost    Database: phpmyscrum
-- ------------------------------------------------------
-- Server version	5.1.30-community

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `priorities`
--

DROP TABLE IF EXISTS `priorities`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(200) NOT NULL COMMENT 'name',
  `disabled` tinyint(1) DEFAULT '0' COMMENT 'disabled',
  `created` datetime DEFAULT NULL COMMENT 'created',
  `updated` datetime DEFAULT NULL COMMENT 'updated',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `remaining_times`
--

DROP TABLE IF EXISTS `remaining_times`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `remaining_times` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `task_id` int(11) NOT NULL COMMENT 'task_id',
  `hours` int(11) NOT NULL COMMENT 'hours',
  `created` date NOT NULL COMMENT 'created',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `resolutions`
--

DROP TABLE IF EXISTS `resolutions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `resolutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `is_fixed` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `sprints`
--

DROP TABLE IF EXISTS `sprints`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sprints` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(200) NOT NULL COMMENT 'name',
  `description` text COMMENT 'description',
  `startdate` datetime NOT NULL COMMENT 'startdate',
  `enddate` datetime NOT NULL COMMENT 'enddate',
  `disabled` tinyint(1) DEFAULT '0' COMMENT 'disabled',
  `created` datetime DEFAULT NULL COMMENT 'created',
  `updated` datetime DEFAULT NULL COMMENT 'updated',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stories`
--

DROP TABLE IF EXISTS `stories`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL COMMENT 'description',
  `storypoints` int(11) DEFAULT NULL,
  `businessvalue` int(11) DEFAULT '0' COMMENT 'businessvalue',
  `priority_id` int(11) DEFAULT NULL COMMENT 'priority_id',
  `sprint_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT '0' COMMENT 'disabled',
  `created` datetime DEFAULT NULL COMMENT 'created',
  `updated` datetime DEFAULT NULL COMMENT 'updated',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sprint_id` int(11) NOT NULL COMMENT 'sprint_id',
  `story_id` int(11) NOT NULL COMMENT 'story_id',
  `name` varchar(255) DEFAULT NULL,
  `description` text COMMENT 'description',
  `estimate_hours` int(11) DEFAULT '0' COMMENT 'estimate_hours',
  `resolution_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'user_id',
  `disabled` tinyint(1) DEFAULT '0' COMMENT 'disabled',
  `created` datetime DEFAULT NULL COMMENT 'created',
  `updated` datetime DEFAULT NULL COMMENT 'updated',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `teammembers`
--

DROP TABLE IF EXISTS `teammembers`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `teammembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `team_id` int(11) NOT NULL COMMENT 'team_id',
  `user_id` int(11) NOT NULL COMMENT 'user_id',
  `disabled` tinyint(1) DEFAULT '0' COMMENT 'disabled',
  `updated` datetime DEFAULT NULL COMMENT 'updated',
  `created` datetime DEFAULT NULL COMMENT 'created',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(200) NOT NULL COMMENT 'name',
  `description` text COMMENT 'description',
  `disabled` tinyint(1) DEFAULT '0' COMMENT 'disabled',
  `created` datetime DEFAULT NULL COMMENT 'created',
  `updated` datetime DEFAULT NULL COMMENT 'updated',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `loginname` varchar(100) NOT NULL COMMENT 'loginname',
  `password` varchar(100) NOT NULL COMMENT 'password',
  `username` varchar(100) NOT NULL COMMENT 'username',
  `email` varchar(100) DEFAULT NULL COMMENT 'email',
  `disabled` tinyint(1) DEFAULT '0' COMMENT 'disabled',
  `created` datetime DEFAULT NULL COMMENT 'created',
  `updated` datetime DEFAULT NULL COMMENT 'updated',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_users_pkey` (`loginname`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-03-31  4:47:58
