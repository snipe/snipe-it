-- MySQL dump 10.13  Distrib 5.7.15, for Linux (x86_64)
--
-- Host: localhost    Database: snipeittests
-- ------------------------------------------------------
-- Server version	5.7.15-0ubuntu0.16.04.1

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
-- Table structure for table `accessories`
--

DROP TABLE IF EXISTS `accessories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accessories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `requestable` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(13,4) DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accessories`
--

LOCK TABLES `accessories` WRITE;
/*!40000 ALTER TABLE `accessories` DISABLE KEYS */;
INSERT INTO `accessories` VALUES (1,'Walter Carter',1,1,278,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,1,'2006-09-01',20.8900,'J935H60W',1,NULL,NULL),(2,'Hayes Delgado',2,1,374,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,2,'2011-06-15',82.3300,'R444V77O',1,NULL,NULL),(3,'Cairo Franks',3,1,86,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,3,'2004-02-17',91.8200,'B562M80I',2,NULL,NULL),(4,'Kasimir Best',4,1,374,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,4,'2009-04-26',63.5000,'T496S42R',3,NULL,NULL),(5,'Rajah Garcia',1,1,514,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,5,'2014-07-23',41.4400,'H299H99S',2,NULL,NULL),(6,'Damon Pearson',5,1,596,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,6,'2010-08-22',11.1600,'K403K24X',4,NULL,NULL),(7,'Jin Buckley',6,1,462,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,7,'2005-10-07',15.3600,'U911L77O',5,NULL,NULL),(8,'Barrett Simon',7,1,297,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,8,'2013-04-06',54.8500,'R642D18D',2,NULL,NULL),(9,'Reece Hayden',5,1,500,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,9,'2017-05-12',43.7600,'R389I62U',6,NULL,NULL),(10,'Honorato Greene',3,1,38,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,10,'2007-07-04',67.6600,'P231H53Z',7,NULL,NULL),(11,'Kennan Levine',8,1,268,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,11,'2007-12-09',47.8400,'K271S85U',6,NULL,NULL),(12,'Chadwick Ryan',9,1,579,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,12,'2011-03-23',49.9200,'S458L71D',8,NULL,NULL),(13,'Abraham Wynn',9,1,84,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,13,'2009-11-17',32.1900,'Q317N85T',6,NULL,NULL),(14,'Tyrone Vazquez',10,1,6,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,14,'2014-05-02',93.6100,'X530P10G',9,NULL,NULL),(15,'Lester Holmes',11,1,538,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,15,'2016-11-20',8.1800,'M377B05F',10,NULL,NULL),(16,'Ryder Stafford',5,1,428,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,16,'2014-08-06',65.7700,'R754A44P',6,NULL,NULL),(17,'Dylan Guy',7,1,502,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,'2012-09-26',45.1400,'G531X03G',11,NULL,NULL),(18,'Igor Salinas',12,1,532,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,17,'2009-10-14',90.9000,'V076X60Y',5,NULL,NULL),(19,'Xavier Mason',7,1,306,0,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,18,'2004-12-11',89.7600,'V002M54F',2,NULL,NULL),(20,'Kane Mcintyre',9,1,256,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,19,'2011-05-22',7.7900,'B393H89J',10,NULL,NULL),(21,'Wade Silva',13,1,87,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,20,'2010-10-10',78.7100,'D573N25A',6,NULL,NULL),(22,'Brock Lowery',14,1,587,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,21,'2012-11-01',22.0700,'H112I50Y',1,NULL,NULL),(23,'Gil Bright',6,1,212,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,22,'2009-07-30',70.1100,'J429A36Y',2,NULL,NULL),(24,'Raja Brewer',12,1,338,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,22,'2015-02-03',42.7500,'R567P48B',9,NULL,NULL),(25,'Malachi Conner',7,1,447,1,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,23,'2008-11-14',71.7900,'D522O37S',12,NULL,NULL);
/*!40000 ALTER TABLE `accessories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accessories_users`
--

DROP TABLE IF EXISTS `accessories_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accessories_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `accessory_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accessories_users`
--

LOCK TABLES `accessories_users` WRITE;
/*!40000 ALTER TABLE `accessories_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `accessories_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_logs`
--

DROP TABLE IF EXISTS `action_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `target_id` int(11) DEFAULT NULL,
  `target_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `filename` text COLLATE utf8_unicode_ci,
  `item_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `expected_checkin` date DEFAULT NULL,
  `accepted_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `accept_signature` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_logs_thread_id_index` (`thread_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_logs`
--

LOCK TABLES `action_logs` WRITE;
/*!40000 ALTER TABLE `action_logs` DISABLE KEYS */;
INSERT INTO `action_logs` VALUES (1,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',1,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,1,NULL),(2,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',2,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,1,NULL),(3,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',3,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,2,NULL),(4,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',4,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,3,NULL),(5,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',5,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,2,NULL),(6,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',6,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,4,NULL),(7,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',7,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,5,NULL),(8,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',8,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,2,NULL),(9,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',9,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,6,NULL),(10,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',10,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,7,NULL),(11,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',11,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,6,NULL),(12,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',12,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,8,NULL),(13,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',13,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,6,NULL),(14,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',14,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,9,NULL),(15,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',15,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,10,NULL),(16,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',16,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,6,NULL),(17,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',17,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,11,NULL),(18,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',18,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,5,NULL),(19,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',19,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,2,NULL),(20,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',20,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,10,NULL),(21,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',21,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,6,NULL),(22,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',22,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,1,NULL),(23,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',23,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,2,NULL),(24,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',24,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,9,NULL),(25,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Accessory',25,NULL,NULL,'2016-11-06 22:01:57','2016-11-06 22:01:57',NULL,NULL,12,NULL),(26,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',1,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,14,NULL),(27,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',2,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL),(28,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',3,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,15,NULL),(29,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',4,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL),(30,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',5,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL),(31,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',6,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL),(32,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',7,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL),(33,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',8,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(34,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',9,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(35,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',10,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(36,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',11,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,16,NULL),(37,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',12,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(38,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',13,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(39,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',14,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(40,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',15,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(41,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',16,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(42,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',17,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(43,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',18,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(44,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',19,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(45,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',20,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(46,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',21,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(47,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',22,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(48,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',23,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(49,1,'created',NULL,NULL,NULL,'Imported using csv importer',NULL,'App\\Models\\Asset',24,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL),(50,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',1,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,17,NULL),(51,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',2,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,6,NULL),(52,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',3,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,7,NULL),(53,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',4,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,9,NULL),(54,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',5,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,1,NULL),(55,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',6,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,12,NULL),(56,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',7,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,5,NULL),(57,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',8,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,11,NULL),(58,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',9,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,6,NULL),(59,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',10,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,4,NULL),(60,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',11,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,5,NULL),(61,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',12,NULL,NULL,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,NULL,5,NULL),(62,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',13,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,17,NULL),(63,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',14,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,10,NULL),(64,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',15,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,17,NULL),(65,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',16,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,2,NULL),(66,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',17,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,10,NULL),(67,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',18,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,5,NULL),(68,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',19,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,18,NULL),(69,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',20,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,17,NULL),(70,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',21,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,11,NULL),(71,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',22,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,3,NULL),(72,1,'created',NULL,NULL,NULL,'Imported using CSV Importer',NULL,'App\\Models\\Consumable',23,NULL,NULL,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,NULL,2,NULL);
/*!40000 ALTER TABLE `action_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_logs`
--

DROP TABLE IF EXISTS `asset_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `asset_id` int(11) NOT NULL,
  `checkedout_to` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `asset_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `filename` text COLLATE utf8_unicode_ci,
  `requested_at` datetime DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `accessory_id` int(11) DEFAULT NULL,
  `accepted_id` int(11) DEFAULT NULL,
  `consumable_id` int(11) DEFAULT NULL,
  `expected_checkin` date DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_logs`
--

LOCK TABLES `asset_logs` WRITE;
/*!40000 ALTER TABLE `asset_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_maintenances`
--

DROP TABLE IF EXISTS `asset_maintenances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_maintenances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL,
  `supplier_id` int(10) unsigned NOT NULL,
  `asset_maintenance_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_warranty` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `asset_maintenance_time` int(11) DEFAULT NULL,
  `notes` longtext COLLATE utf8_unicode_ci,
  `cost` decimal(10,2) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_maintenances`
--

LOCK TABLES `asset_maintenances` WRITE;
/*!40000 ALTER TABLE `asset_maintenances` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset_maintenances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_uploads`
--

DROP TABLE IF EXISTS `asset_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `asset_id` int(11) NOT NULL,
  `filenotes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_uploads`
--

LOCK TABLES `asset_uploads` WRITE;
/*!40000 ALTER TABLE `asset_uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `asset_tag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `serial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(8,2) DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `image` text COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `physical` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT NULL,
  `warranty_months` int(11) DEFAULT NULL,
  `depreciate` tinyint(1) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `requestable` tinyint(4) NOT NULL DEFAULT '0',
  `rtd_location_id` int(11) DEFAULT NULL,
  `_snipeit_mac_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accepted` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_checkout` datetime DEFAULT NULL,
  `expected_checkin` date DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES (1,'eget nunc donec quis','970882174-8',1,'27aa8378-b0f4-4289-84a4-405da95c6147','2016-04-05',289.59,NULL,3,'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.',NULL,1,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,5,NULL,NULL,NULL,1,0,25,'',NULL,NULL,NULL,14),(2,'mi in porttitor','544574073-0',2,'4bc7fc90-5a97-412f-8eed-77ecacc643fc','2016-03-08',763.46,NULL,4,NULL,NULL,1,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,5,NULL,NULL,NULL,2,0,26,'',NULL,NULL,NULL,NULL),(3,'morbi quis tortor id','710141467-2',3,'2837ab20-8f0d-4935-8a52-226392f2b1b0','2015-08-09',233.57,NULL,5,'In congue. Etiam justo. Etiam pretium iaculis justo.',NULL,1,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,6,NULL,NULL,NULL,3,0,27,'',NULL,NULL,NULL,15),(4,'amet cursus id turpis','103538064-1',4,'18d6e6a4-d362-4de9-beb4-7f62fb93de6f','2015-10-11',0.00,NULL,6,'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.',NULL,1,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,7,NULL,NULL,NULL,3,0,28,'',NULL,NULL,NULL,NULL),(5,'ipsum praesent','118753405-6',5,'f9b473c6-c810-42f2-8335-27ce468889a8','2015-06-16',324.80,NULL,7,NULL,NULL,1,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,2,NULL,NULL,NULL,3,0,29,'',NULL,NULL,NULL,NULL),(6,'dictumst maecenas ut','998233705-X',6,'4751495c-cee0-4961-b788-94a545b5643e','2016-04-16',261.79,NULL,8,NULL,NULL,1,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,3,NULL,NULL,NULL,4,0,30,'',NULL,NULL,NULL,NULL),(7,'libero nam','177687256-8',7,'17b3cf8d-fead-46f5-a8b0-49906bb90a00','2015-05-24',0.00,NULL,9,'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.',NULL,1,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,7,NULL,NULL,NULL,3,0,31,'',NULL,NULL,NULL,NULL),(8,'mauris morbi non','129556040-2',8,'7a6a2fdb-160c-4d91-8e05-a0337a90d9db','2015-09-15',434.86,NULL,10,'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,3,NULL,NULL,NULL,5,0,32,'',NULL,NULL,NULL,NULL),(9,'eleifend pede libero','117517007-0',9,'c1a57909-3b2e-47fe-ab2f-843401b2a7de','2016-04-13',89.53,NULL,11,'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,3,NULL,NULL,NULL,6,0,33,'',NULL,NULL,NULL,NULL),(10,'convallis nulla neque','007968217-0',10,'07540238-fb3c-4c8a-8e11-d43883ee4268','2015-07-04',0.00,NULL,12,NULL,NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,6,NULL,NULL,NULL,3,0,34,'',NULL,NULL,NULL,NULL),(11,'in felis','441402118-9',11,'527b2445-2c67-4f76-912f-6ec42400a584','2016-05-18',0.00,NULL,13,'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,6,NULL,NULL,NULL,7,0,35,'',NULL,NULL,NULL,16),(12,'vel ipsum praesent','863829558-8',12,NULL,'2015-11-10',0.00,NULL,14,'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,6,NULL,NULL,NULL,6,0,36,'',NULL,NULL,NULL,NULL),(13,'odio elementum','742114860-4',13,'9a863968-180e-451d-a723-dc85e2d5d8ff','2016-03-20',881.40,NULL,NULL,'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,1,NULL,NULL,NULL,8,0,37,'',NULL,NULL,NULL,NULL),(14,'viverra diam vitae','927820758-6',14,'e287bb64-ff4f-434c-88ab-210ad433c77b','2016-03-05',675.30,NULL,15,NULL,NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,3,NULL,NULL,NULL,9,0,38,'',NULL,NULL,NULL,NULL),(15,'felis sed interdum venenatis','789757925-5',15,'90bcab28-ffd4-48c9-ba5d-c2eeb1400698','2015-07-25',0.00,NULL,16,'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,2,NULL,NULL,NULL,10,0,39,'',NULL,NULL,NULL,NULL),(16,'id consequat','202652281-2',16,'08e440f7-bd0b-47a7-a577-4a3ce3c7dfe7','2015-08-13',446.22,NULL,17,'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,6,NULL,NULL,NULL,3,0,40,'',NULL,NULL,NULL,NULL),(17,'porta volutpat quam pede','210119288-8',17,'5f900903-0ffe-4405-b5ad-aa4aa59d911c','2015-12-24',923.90,NULL,18,'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,6,NULL,NULL,NULL,11,0,41,'',NULL,NULL,NULL,NULL),(18,'libero nam dui proin','022102715-7',18,'bde85740-f103-4b49-a691-a60c7f6859a8','2016-03-29',0.00,NULL,19,'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,5,NULL,NULL,NULL,12,0,42,'',NULL,NULL,NULL,NULL),(19,'sociis natoque penatibus','610672722-8',19,'bf4a2a92-6f29-4d24-be90-8126d4dcbd64','2016-05-13',442.51,NULL,20,NULL,NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,3,NULL,NULL,NULL,13,0,43,'',NULL,NULL,NULL,NULL),(20,'sed tristique in','898880851-7',20,'9a02817e-de79-4850-a212-84c9ae3dd1a2','2015-09-10',906.39,NULL,21,'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,5,NULL,NULL,NULL,3,0,44,'',NULL,NULL,NULL,NULL),(21,'dui luctus rutrum','466008300-4',21,'514aca2a-9080-4c49-8695-7ba4c78edc65','2015-12-21',151.27,NULL,NULL,'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,1,NULL,NULL,NULL,3,0,45,'',NULL,NULL,NULL,NULL),(22,'ut massa volutpat','313295582-5',22,'b99208e2-b8d8-4f7a-8a06-366a27733b97','2016-02-15',211.07,NULL,NULL,'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,1,NULL,NULL,NULL,3,0,46,'',NULL,NULL,NULL,NULL),(23,'habitasse platea dictumst','552327520-4',23,'c8680b36-a13c-427f-a6a1-1b9b351eb129','2015-11-25',112.11,NULL,22,'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,2,NULL,NULL,NULL,14,0,47,'',NULL,NULL,NULL,NULL),(24,'leo pellentesque ultrices','446504693-6',24,'6c1e7556-063f-4c71-87ce-e46b06e8c238','2015-08-19',221.03,NULL,23,'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.',NULL,1,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,5,NULL,NULL,NULL,15,0,48,'',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `eula_text` longtext COLLATE utf8_unicode_ci,
  `use_default_eula` tinyint(1) NOT NULL DEFAULT '0',
  `require_acceptance` tinyint(1) NOT NULL DEFAULT '0',
  `category_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'asset',
  `checkin_email` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Customer Relations','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(2,'Advertising','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(3,'Accounting','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(4,'Payroll','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(5,'Finances','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(6,'Sales and Marketing','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(7,'Tech Support','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(8,'Legal Department','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(9,'Quality Assurance','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(10,'Public Relations','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(11,'Research and Development','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(12,'Asset Management','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(13,'Customer Service','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(14,'Human Resources','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL,NULL,0,0,'accessory',0),(16,'Unnamed Category','2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,NULL,0,0,'asset',0),(17,'Triamterene/Hydrochlorothiazide','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(18,'Ranitidine HCl','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(19,'Amoxicillin','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(20,'Lantus Solostar','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(21,'Hydrocodone/APAP','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(22,'Fluticasone Propionate','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(23,'Amlodipine Besylate','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(24,'Omeprazole (Rx)','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(25,'Risperidone','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(26,'Suboxone','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(27,'Fluoxetine HCl','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(28,'Alendronate Sodium','2016-11-06 22:03:36','2016-11-06 22:03:36',1,NULL,NULL,0,0,'consumable',0),(29,'Allopurinol','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(30,'Simvastatin','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(31,'Fluconazole','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(32,'Advair Diskus','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(33,'Loestrin 24 Fe','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(34,'Pantoprazole Sodium','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(35,'Venlafaxine HCl ER','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(36,'Cephalexin','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(37,'Lyrica','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(38,'Meloxicam','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(39,'Flovent HFA','2016-11-06 22:03:37','2016-11-06 22:03:37',1,NULL,NULL,0,0,'consumable',0),(40,'Test Accessory','2016-11-06 22:35:22','2016-11-06 22:35:22',1,NULL,'',0,0,'accessory',0),(41,'Test Component','2016-11-06 22:43:03','2016-11-06 22:43:03',1,NULL,'',0,0,'component',0),(42,'Test Asset','2016-11-06 22:44:24','2016-11-06 22:44:24',1,NULL,'',0,0,'asset',0),(43,'Test Consumable','2016-11-06 22:44:37','2016-11-06 22:44:37',1,NULL,'',0,0,'consumable',0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `checkout_requests`
--

DROP TABLE IF EXISTS `checkout_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkout_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `requestable_id` int(11) NOT NULL,
  `requestable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checkout_requests_user_id_requestable_id_requestable_type_unique` (`user_id`,`requestable_id`,`requestable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `checkout_requests`
--

LOCK TABLES `checkout_requests` WRITE;
/*!40000 ALTER TABLE `checkout_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `checkout_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Macromedia','2016-11-06 22:01:57','2016-11-06 22:01:57'),(2,'Sibelius','2016-11-06 22:01:57','2016-11-06 22:01:57'),(3,'Adobe','2016-11-06 22:01:57','2016-11-06 22:01:57'),(4,'Microsoft','2016-11-06 22:01:57','2016-11-06 22:01:57'),(5,'Borland','2016-11-06 22:01:57','2016-11-06 22:01:57'),(6,'Lavasoft','2016-11-06 22:01:57','2016-11-06 22:01:57'),(7,'Google','2016-11-06 22:01:57','2016-11-06 22:01:57'),(8,'Finale','2016-11-06 22:01:57','2016-11-06 22:01:57'),(9,'Apple Systems','2016-11-06 22:01:57','2016-11-06 22:01:57'),(10,'Cakewalk','2016-11-06 22:01:57','2016-11-06 22:01:57'),(11,'Chami','2016-11-06 22:01:57','2016-11-06 22:01:57'),(12,'Yahoo','2016-11-06 22:01:57','2016-11-06 22:01:57'),(14,'Alpha','2016-11-06 22:03:21','2016-11-06 22:03:21'),(15,'Konklab','2016-11-06 22:03:21','2016-11-06 22:03:21'),(16,'Bitwolf','2016-11-06 22:03:22','2016-11-06 22:03:22'),(17,'Lycos','2016-11-06 22:03:36','2016-11-06 22:03:36'),(18,'Altavista','2016-11-06 22:03:37','2016-11-06 22:03:37');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `components`
--

DROP TABLE IF EXISTS `components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `components` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `order_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(13,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `components`
--

LOCK TABLES `components` WRITE;
/*!40000 ALTER TABLE `components` DISABLE KEYS */;
/*!40000 ALTER TABLE `components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `components_assets`
--

DROP TABLE IF EXISTS `components_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `components_assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `assigned_qty` int(11) DEFAULT '1',
  `component_id` int(11) DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `components_assets`
--

LOCK TABLES `components_assets` WRITE;
/*!40000 ALTER TABLE `components_assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `components_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consumables`
--

DROP TABLE IF EXISTS `consumables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consumables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `requestable` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(13,4) DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
  `model_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `item_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumables`
--

LOCK TABLES `consumables` WRITE;
/*!40000 ALTER TABLE `consumables` DISABLE KEYS */;
INSERT INTO `consumables` VALUES (1,'eget',17,49,1,322,0,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2011-01-03',85.9100,'T295T06V',17,NULL,NULL,NULL,NULL),(2,'Morbi',18,50,1,374,1,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2016-10-24',87.4200,'W787T62Q',6,NULL,NULL,NULL,NULL),(3,'arcu.',19,51,1,252,0,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2007-09-22',48.3400,'N961E50A',7,NULL,NULL,NULL,NULL),(4,'nec',20,52,1,30,1,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2009-08-16',8.7100,'X624N14C',9,NULL,NULL,NULL,NULL),(5,'Nam',21,NULL,1,551,1,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2017-03-30',24.0700,'N618A20S',1,NULL,NULL,NULL,NULL),(6,'Nullam',22,53,1,395,0,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2003-12-16',73.2300,'B386I67L',12,NULL,NULL,NULL,NULL),(7,'erat',23,54,1,297,1,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2010-08-03',17.4900,'G606H92I',5,NULL,NULL,NULL,NULL),(8,'purus',24,55,1,557,1,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2004-10-12',63.5200,'R660Z45O',11,NULL,NULL,NULL,NULL),(9,'dignissim',25,56,1,47,1,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2010-11-10',77.9400,'G230Z67X',6,NULL,NULL,NULL,NULL),(10,'Nam',26,57,1,310,0,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2015-01-25',64.3300,'B613L84C',4,NULL,NULL,NULL,NULL),(11,'Nunc',27,58,1,404,0,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2017-04-13',81.0200,'O367N55N',5,NULL,NULL,NULL,NULL),(12,'Phasellus',28,59,1,590,0,'2016-11-06 22:03:36','2016-11-06 22:03:36',NULL,'2005-12-23',70.6700,'K941C02T',5,NULL,NULL,NULL,NULL),(13,'Nulla',29,60,1,48,0,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2017-07-21',99.0400,'D663L90H',17,NULL,NULL,NULL,NULL),(14,'Sed',31,62,1,169,1,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2011-04-14',48.8600,'T666E70K',10,NULL,NULL,NULL,NULL),(15,'quis',32,63,1,264,0,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2014-01-08',55.6400,'T767G07U',17,NULL,NULL,NULL,NULL),(16,'viverra.',33,64,1,293,0,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2013-01-07',93.4800,'T276L44H',2,NULL,NULL,NULL,NULL),(17,'Sed',34,65,1,407,0,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2008-03-20',64.7500,'A933E55V',10,NULL,NULL,NULL,NULL),(18,'iaculis',35,66,1,115,0,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2015-07-17',56.7400,'N568F73C',5,NULL,NULL,NULL,NULL),(19,'leo.',36,67,1,208,1,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2012-12-09',96.8800,'H283Z42U',18,NULL,NULL,NULL,NULL),(20,'leo.',37,68,1,486,0,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2007-04-24',40.8700,'T054Q83U',17,NULL,NULL,NULL,NULL),(21,'pede.',30,69,1,214,1,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2010-09-29',19.6400,'L842O70A',11,NULL,NULL,NULL,NULL),(22,'massa',38,70,1,131,0,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2015-05-18',18.4300,'V029Q52K',3,NULL,NULL,NULL,NULL),(23,'urna',39,NULL,1,15,1,'2016-11-06 22:03:37','2016-11-06 22:03:37',NULL,'2014-10-22',7.4100,'Z708U15X',2,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `consumables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consumables_users`
--

DROP TABLE IF EXISTS `consumables_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consumables_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `consumable_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumables_users`
--

LOCK TABLES `consumables_users` WRITE;
/*!40000 ALTER TABLE `consumables_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `consumables_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_field_custom_fieldset`
--

DROP TABLE IF EXISTS `custom_field_custom_fieldset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_field_custom_fieldset` (
  `custom_field_id` int(11) NOT NULL,
  `custom_fieldset_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `required` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_field_custom_fieldset`
--

LOCK TABLES `custom_field_custom_fieldset` WRITE;
/*!40000 ALTER TABLE `custom_field_custom_fieldset` DISABLE KEYS */;
INSERT INTO `custom_field_custom_fieldset` VALUES (1,1,1,0);
/*!40000 ALTER TABLE `custom_field_custom_fieldset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `element` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `field_values` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `field_encrypted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields`
--

LOCK TABLES `custom_fields` WRITE;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
INSERT INTO `custom_fields` VALUES (1,'MAC Address','regex:/^[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}$/','text',NULL,'2016-11-06 21:59:38',NULL,NULL,0);
/*!40000 ALTER TABLE `custom_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fieldsets`
--

DROP TABLE IF EXISTS `custom_fieldsets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fieldsets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fieldsets`
--

LOCK TABLES `custom_fieldsets` WRITE;
/*!40000 ALTER TABLE `custom_fieldsets` DISABLE KEYS */;
INSERT INTO `custom_fieldsets` VALUES (1,'Asset with MAC Address',NULL,NULL,NULL);
/*!40000 ALTER TABLE `custom_fieldsets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `depreciations`
--

DROP TABLE IF EXISTS `depreciations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `depreciations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `months` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `depreciations`
--

LOCK TABLES `depreciations` WRITE;
/*!40000 ALTER TABLE `depreciations` DISABLE KEYS */;
/*!40000 ALTER TABLE `depreciations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `license_seats`
--

DROP TABLE IF EXISTS `license_seats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `license_seats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `license_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `license_seats`
--

LOCK TABLES `license_seats` WRITE;
/*!40000 ALTER TABLE `license_seats` DISABLE KEYS */;
/*!40000 ALTER TABLE `license_seats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licenses`
--

DROP TABLE IF EXISTS `licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serial` varchar(2048) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(8,2) DEFAULT NULL,
  `order_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seats` int(11) NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `depreciation_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `license_name` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `license_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `depreciate` tinyint(1) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `purchase_order` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `termination_date` date DEFAULT NULL,
  `maintained` tinyint(1) DEFAULT NULL,
  `reassignable` tinyint(1) NOT NULL DEFAULT '1',
  `company_id` int(10) unsigned DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licenses`
--

LOCK TABLES `licenses` WRITE;
/*!40000 ALTER TABLE `licenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'metus. Vivamus','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(2,'conubia','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(3,'Suspendisse eleifend.','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(4,'ipsum cursus vestibulum.','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(5,'Nunc laoreet lectus','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(6,'luctus','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(7,'euismod','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(8,'ipsum nunc','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(9,'et nunc. Quisque','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(10,'interdum. Curabitur','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(11,'sociis','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(12,'fermentum','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(13,'Vestibulum','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(14,'feugiat nec, diam.','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(15,'non magna.','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(16,'consectetuer rhoncus. Nullam','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(17,'viverra. Donec','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(18,'mus. Proin','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(19,'erat,','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(20,'Sed et libero.','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(21,'dolor,','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(22,'id,','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(23,'Mauris','','','','2016-11-06 22:01:57','2016-11-06 22:01:57',1,'',NULL,NULL,NULL,NULL,NULL),(25,'Daping','','','','2016-11-06 22:03:21','2016-11-06 22:03:21',1,'',NULL,NULL,NULL,NULL,NULL),(26,'Cirangga Kidul','','','','2016-11-06 22:03:21','2016-11-06 22:03:21',1,'',NULL,NULL,NULL,NULL,NULL),(27,'Shekou','','','','2016-11-06 22:03:21','2016-11-06 22:03:21',1,'',NULL,NULL,NULL,NULL,NULL),(28,'Leksand','','','','2016-11-06 22:03:21','2016-11-06 22:03:21',1,'',NULL,NULL,NULL,NULL,NULL),(29,'Dresi Wetan','','','','2016-11-06 22:03:21','2016-11-06 22:03:21',1,'',NULL,NULL,NULL,NULL,NULL),(30,'Dante Delgado','','','','2016-11-06 22:03:21','2016-11-06 22:03:21',1,'',NULL,NULL,NULL,NULL,NULL),(31,'Pingle','','','','2016-11-06 22:03:21','2016-11-06 22:03:21',1,'',NULL,NULL,NULL,NULL,NULL),(32,'Zhuli','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(33,'Niopanda','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(34,'Zoumaling','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(35,'Luts?k','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(36,'Pravdinsk','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(37,'Panay','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(38,'Achiaman','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(39,'Oemanu','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(40,'Qiaolin','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(41,'Accha','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(42,'Kerkrade','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(43,'Villa Regina','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(44,'Tibro','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(45,'Menglie','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(46,'Solidaridad','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(47,'Sorinomo','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(48,'Tamel','','','','2016-11-06 22:03:22','2016-11-06 22:03:22',1,'',NULL,NULL,NULL,NULL,NULL),(49,'mauris blandit mattis.','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(50,'iaculis','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(51,'ornare','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(52,'lectus','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(53,'Donec est mauris,','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(54,'Proin','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(55,'tellus justo sit','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(56,'nibh vulputate mauris','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(57,'taciti sociosqu ad','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(58,'nec orci.','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(59,'quis, tristique ac,','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(60,'augue malesuada malesuada.','','','','2016-11-06 22:03:36','2016-11-06 22:03:36',1,'',NULL,NULL,NULL,NULL,NULL),(61,'dolor sit amet,','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL),(62,'lectus convallis est,','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL),(63,'varius orci,','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL),(64,'cursus et, magna.','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL),(65,'arcu. Sed','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL),(66,'nec','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL),(67,'Aenean','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL),(68,'tincidunt adipiscing. Mauris','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL),(69,'nec enim. Nunc','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL),(70,'nisi magna sed','','','','2016-11-06 22:03:37','2016-11-06 22:03:37',1,'',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manufacturers`
--

DROP TABLE IF EXISTS `manufacturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manufacturers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manufacturers`
--

LOCK TABLES `manufacturers` WRITE;
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;
INSERT INTO `manufacturers` VALUES (1,'Unknown','2016-11-06 22:01:57','2016-11-06 22:01:57',1,NULL),(3,'Linkbridge','2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL),(4,'Flipstorm','2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL),(5,'Lajo','2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL),(6,'Zoomlounge','2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL),(7,'Kazu','2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL),(8,'Layo','2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL),(9,'Twiyo','2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL),(10,'Cogibox','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(11,'Flipbug','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(12,'Centimia','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(13,'Roombo','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(14,'Yakijo','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(15,'Oyope','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(16,'Flashset','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(17,'Chatterbridge','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(18,'Skipstorm','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(19,'Devpulse','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(20,'Photobug','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(21,'Photofeed','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(22,'Riffpath','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(23,'Aivee','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(24,'Abatz','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(25,'Blogtag','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(26,'Brightdog','2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL),(27,'Test Manufacturer','2016-11-06 22:35:47','2016-11-06 22:35:47',1,NULL);
/*!40000 ALTER TABLE `manufacturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2012_12_06_225921_migration_cartalyst_sentry_install_users',1),('2012_12_06_225929_migration_cartalyst_sentry_install_groups',1),('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot',1),('2012_12_06_225988_migration_cartalyst_sentry_install_throttle',1),('2013_03_23_193214_update_users_table',1),('2013_11_13_075318_create_models_table',1),('2013_11_13_075335_create_categories_table',1),('2013_11_13_075347_create_manufacturers_table',1),('2013_11_15_015858_add_user_id_to_categories',1),('2013_11_15_112701_add_user_id_to_manufacturers',1),('2013_11_15_190327_create_assets_table',1),('2013_11_15_190357_create_licenses_table',1),('2013_11_15_201848_add_license_name_to_licenses',1),('2013_11_16_040323_create_depreciations_table',1),('2013_11_16_042851_add_depreciation_id_to_models',1),('2013_11_16_084923_add_user_id_to_models',1),('2013_11_16_103258_create_locations_table',1),('2013_11_16_103336_add_location_id_to_assets',1),('2013_11_16_103407_add_checkedout_to_to_assets',1),('2013_11_16_103425_create_history_table',1),('2013_11_17_054359_drop_licenses_table',1),('2013_11_17_054526_add_physical_to_assets',1),('2013_11_17_055126_create_settings_table',1),('2013_11_17_062634_add_license_to_assets',1),('2013_11_18_134332_add_contacts_to_users',1),('2013_11_18_142847_add_info_to_locations',1),('2013_11_18_152942_remove_location_id_from_asset',1),('2013_11_18_164423_set_nullvalues_for_user',1),('2013_11_19_013337_create_asset_logs_table',1),('2013_11_19_061409_edit_added_on_asset_logs_table',1),('2013_11_19_062250_edit_location_id_asset_logs_table',1),('2013_11_20_055822_add_soft_delete_on_assets',1),('2013_11_20_121404_add_soft_delete_on_locations',1),('2013_11_20_123137_add_soft_delete_on_manufacturers',1),('2013_11_20_123725_add_soft_delete_on_categories',1),('2013_11_20_130248_create_status_labels',1),('2013_11_20_130830_add_status_id_on_assets_table',1),('2013_11_20_131544_add_status_type_on_status_labels',1),('2013_11_20_134103_add_archived_to_assets',1),('2013_11_21_002321_add_uploads_table',1),('2013_11_21_024531_remove_deployable_boolean_from_status_labels',1),('2013_11_22_075308_add_option_label_to_settings_table',1),('2013_11_22_213400_edits_to_settings_table',1),('2013_11_25_013244_create_licenses_table',1),('2013_11_25_031458_create_license_seats_table',1),('2013_11_25_032022_add_type_to_actionlog_table',1),('2013_11_25_033008_delete_bad_licenses_table',1),('2013_11_25_033131_create_new_licenses_table',1),('2013_11_25_033534_add_licensed_to_licenses_table',1),('2013_11_25_101308_add_warrantee_to_assets_table',1),('2013_11_25_104343_alter_warranty_column_on_assets',1),('2013_11_25_150450_drop_parent_from_categories',1),('2013_11_25_151920_add_depreciate_to_assets',1),('2013_11_25_152903_add_depreciate_to_licenses_table',1),('2013_11_26_211820_drop_license_from_assets_table',1),('2013_11_27_062510_add_note_to_asset_logs_table',1),('2013_12_01_113426_add_filename_to_asset_log',1),('2013_12_06_094618_add_nullable_to_licenses_table',1),('2013_12_10_084038_add_eol_on_models_table',1),('2013_12_12_055218_add_manager_to_users_table',1),('2014_01_28_031200_add_qr_code_to_settings_table',1),('2014_02_13_183016_add_qr_text_to_settings_table',1),('2014_05_24_093839_alter_default_license_depreciation_id',1),('2014_05_27_231658_alter_default_values_licenses',1),('2014_06_19_191508_add_asset_name_to_settings',1),('2014_06_20_004847_make_asset_log_checkedout_to_nullable',1),('2014_06_20_005050_make_asset_log_purchasedate_to_nullable',1),('2014_06_24_003011_add_suppliers',1),('2014_06_24_010742_add_supplier_id_to_asset',1),('2014_06_24_012839_add_zip_to_supplier',1),('2014_06_24_033908_add_url_to_supplier',1),('2014_07_08_054116_add_employee_id_to_users',1),('2014_07_09_134316_add_requestable_to_assets',1),('2014_07_17_085822_add_asset_to_software',1),('2014_07_17_161625_make_asset_id_in_logs_nullable',1),('2014_08_12_053504_alpha_0_4_2_release',1),('2014_08_17_083523_make_location_id_nullable',1),('2014_10_16_200626_add_rtd_location_to_assets',1),('2014_10_24_000417_alter_supplier_state_to_32',1),('2014_10_24_015641_add_display_checkout_date',1),('2014_10_28_222654_add_avatar_field_to_users_table',1),('2014_10_29_045924_add_image_field_to_models_table',1),('2014_11_01_214955_add_eol_display_to_settings',1),('2014_11_04_231416_update_group_field_for_reporting',1),('2014_11_05_212408_add_fields_to_licenses',1),('2014_11_07_021042_add_image_to_supplier',1),('2014_11_20_203007_add_username_to_user',1),('2014_11_20_223947_add_auto_to_settings',1),('2014_11_20_224421_add_prefix_to_settings',1),('2014_11_21_104401_change_licence_type',1),('2014_12_09_082500_add_fields_maintained_term_to_licenses',1),('2015_02_04_155757_increase_user_field_lengths',1),('2015_02_07_013537_add_soft_deleted_to_log',1),('2015_02_10_040958_fix_bad_assigned_to_ids',1),('2015_02_10_053310_migrate_data_to_new_statuses',1),('2015_02_11_044104_migrate_make_license_assigned_null',1),('2015_02_11_104406_migrate_create_requests_table',1),('2015_02_12_001312_add_mac_address_to_asset',1),('2015_02_12_024100_change_license_notes_type',1),('2015_02_17_231020_add_localonly_to_settings',1),('2015_02_19_222322_add_logo_and_colors_to_settings',1),('2015_02_24_072043_add_alerts_to_settings',1),('2015_02_25_022931_add_eula_fields',1),('2015_02_25_204513_add_accessories_table',1),('2015_02_26_091228_add_accessories_user_table',1),('2015_02_26_115128_add_deleted_at_models',1),('2015_02_26_233005_add_category_type',1),('2015_03_01_231912_update_accepted_at_to_acceptance_id',1),('2015_03_05_011929_add_qr_type_to_settings',1),('2015_03_18_055327_add_note_to_user',1),('2015_04_29_234704_add_slack_to_settings',1),('2015_05_04_085151_add_parent_id_to_locations_table',1),('2015_05_22_124421_add_reassignable_to_licenses',1),('2015_06_10_003314_fix_default_for_user_notes',1),('2015_06_10_003554_create_consumables',1),('2015_06_15_183253_move_email_to_username',1),('2015_06_23_070346_make_email_nullable',1),('2015_06_26_213716_create_asset_maintenances_table',1),('2015_07_04_212443_create_custom_fields_table',1),('2015_07_09_014359_add_currency_to_settings_and_locations',1),('2015_07_21_122022_add_expected_checkin_date_to_asset_logs',1),('2015_07_24_093845_add_checkin_email_to_category_table',1),('2015_07_25_055415_remove_email_unique_constraint',1),('2015_07_29_230054_add_thread_id_to_asset_logs_table',1),('2015_07_31_015430_add_accepted_to_assets',1),('2015_09_09_195301_add_custom_css_to_settings',1),('2015_09_21_235926_create_custom_field_custom_fieldset',1),('2015_09_22_000104_create_custom_fieldsets',1),('2015_09_22_003321_add_fieldset_id_to_assets',1),('2015_09_22_003413_migrate_mac_address',1),('2015_09_28_003314_fix_default_purchase_order',1),('2015_10_01_024551_add_accessory_consumable_price_info',1),('2015_10_12_192706_add_brand_to_settings',1),('2015_10_22_003314_fix_defaults_accessories',1),('2015_10_23_182625_add_checkout_time_and_expected_checkout_date_to_assets',1),('2015_11_05_061015_create_companies_table',1),('2015_11_05_061115_add_company_id_to_consumables_table',1),('2015_11_05_183749_image',1),('2015_11_06_092038_add_company_id_to_accessories_table',1),('2015_11_06_100045_add_company_id_to_users_table',1),('2015_11_06_134742_add_company_id_to_licenses_table',1),('2015_11_08_035832_add_company_id_to_assets_table',1),('2015_11_08_222305_add_ldap_fields_to_settings',1),('2015_11_15_151803_add_full_multiple_companies_support_to_settings_table',1),('2015_11_26_195528_import_ldap_settings',1),('2015_11_30_191504_remove_fk_company_id',1),('2015_12_21_193006_add_ldap_server_cert_ignore_to_settings_table',1),('2015_12_30_233509_add_timestamp_and_userId_to_custom_fields',1),('2015_12_30_233658_add_timestamp_and_userId_to_custom_fieldsets',1),('2016_01_28_041048_add_notes_to_models',1),('2016_02_19_070119_add_remember_token_to_users_table',1),('2016_02_19_073625_create_password_resets_table',1),('2016_03_02_193043_add_ldap_flag_to_users',1),('2016_03_02_220517_update_ldap_filter_to_longer_field',1),('2016_03_08_225351_create_components_table',1),('2016_03_09_024038_add_min_stock_to_tables',1),('2016_03_10_133849_add_locale_to_users',1),('2016_03_10_135519_add_locale_to_settings',1),('2016_03_11_185621_add_label_settings_to_settings',1),('2016_03_22_125911_fix_custom_fields_regexes',1),('2016_04_28_141554_add_show_to_users',1),('2016_05_16_164733_add_model_mfg_to_consumable',1),('2016_05_19_180351_add_alt_barcode_settings',1),('2016_05_19_191146_add_alter_interval',1),('2016_05_19_192226_add_inventory_threshold',1),('2016_05_20_024859_remove_option_keys_from_settings_table',1),('2016_05_20_143758_remove_option_value_from_settings_table',1),('2016_06_01_140218_add_email_domain_and_format_to_settings',1),('2016_06_22_160725_add_user_id_to_maintenances',1),('2016_07_13_150015_add_is_ad_to_settings',1),('2016_07_14_153609_add_ad_domain_to_settings',1),('2016_07_22_003348_fix_custom_fields_regex_stuff',1),('2016_07_22_054850_one_more_mac_addr_fix',1),('2016_07_22_143045_add_port_to_ldap_settings',1),('2016_07_22_153432_add_tls_to_ldap_settings',1),('2016_07_27_211034_add_zerofill_to_settings',1),('2016_08_02_124944_add_color_to_statuslabel',1),('2016_08_04_134500_add_disallow_ldap_pw_sync_to_settings',1),('2016_08_09_002225_add_manufacturer_to_licenses',1),('2016_08_12_121613_add_manufacturer_to_accessories_table',1),('2016_08_23_143353_add_new_fields_to_custom_fields',1),('2016_08_23_145619_add_show_in_nav_to_status_labels',1),('2016_08_30_084634_make_purchase_cost_nullable',1),('2016_09_01_141051_add_requestable_to_asset_model',1),('2016_09_02_001448_create_checkout_requests_table',1),('2016_09_04_180400_create_actionlog_table',1),('2016_09_04_182149_migrate_asset_log_to_action_log',1),('2016_09_19_235935_fix_fieldtype_for_target_type',1),('2016_09_23_140722_fix_modelno_in_consumables_to_string',1),('2016_09_28_231359_add_company_to_logs',1),('2016_10_14_130709_fix_order_number_to_varchar',1),('2016_10_19_145520_fix_order_number_in_components_to_string',1),('2016_10_27_151715_add_serial_to_components',1),('2016_10_27_213251_increase_serial_field_capacity',1),('2016_10_29_002724_enable_2fa_fields',1),('2016_10_29_082408_add_signature_to_acceptance',1),('2016_11_01_030818_fix_forgotten_filename_in_action_logs',1),('2016_10_16_015024_rename_modelno_to_model_number',2),('2016_10_16_015211_rename_consumable_modelno_to_model_number',2),('2016_10_16_143235_rename_model_note_to_notes',2),('2016_10_16_165052_rename_component_total_qty_to_qty',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `models`
--

DROP TABLE IF EXISTS `models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `models` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `depreciation_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `eol` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deprecated_mac_address` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `fieldset_id` int(11) DEFAULT NULL,
  `notes` longtext COLLATE utf8_unicode_ci,
  `requestable` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
INSERT INTO `models` VALUES (1,'massa id','6377018600094472',3,16,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(2,'congue diam id','5.02043359569189E+018',4,16,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(3,'convallis tortor risus','374622546776765',5,16,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(4,'in faucibus orci','3549618015236095',6,16,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(5,'et ultrices','3567082842822626',7,16,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(6,'accumsan felis','30052522651756',8,16,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(7,'interdum mauris','3585438057660291',9,16,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(8,'sapien dignissim','3548511052883500',10,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(9,'et ultrices posuere cubilia','6.75911579996746E+017',11,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(10,'duis mattis egestas metus aenean','378342677410961',12,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(11,'quam sapien varius','201954480670574',13,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(12,'augue vestibulum rutrum rutrum neque','3567636803247485',14,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(13,'ante vel ipsum praesent blandit','3529462300753736',15,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(14,'dapibus dolor vel','3559785746335392',16,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(15,'dui proin','4070995882635',17,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(16,'odio porttitor id consequat in','36309149183447',18,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(17,'donec vitae nisi nam','3543783295297294',19,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(18,'eget tincidunt eget tempus','201967051902986',20,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(19,'at diam nam','3533016005480310',21,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(20,'luctus et ultrices','4547299861035',22,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(21,'dictumst morbi vestibulum','4405382067928809',23,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(22,'quis odio consequat varius integer','3537252931689981',24,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(23,'quam a odio in','5018304036665243',25,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(24,'in sapien iaculis congue vivamus','30355105682126',26,16,'2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,1,NULL,NULL,0,NULL,NULL,NULL,0),(25,'Test Asset Model','',27,16,'2016-11-06 22:37:35','2016-11-06 22:37:35',0,1,0,NULL,0,NULL,NULL,'',0);
/*!40000 ALTER TABLE `models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requested_assets`
--

DROP TABLE IF EXISTS `requested_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requested_assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `denied_at` datetime DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requested_assets`
--

LOCK TABLES `requested_assets` WRITE;
/*!40000 ALTER TABLE `requested_assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `requested_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `request_code` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `per_page` int(11) NOT NULL DEFAULT '20',
  `site_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Snipe IT Asset Management',
  `qr_code` int(11) DEFAULT NULL,
  `qr_text` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_asset_name` int(11) DEFAULT NULL,
  `display_checkout_date` int(11) DEFAULT NULL,
  `display_eol` int(11) DEFAULT NULL,
  `auto_increment_assets` int(11) NOT NULL DEFAULT '0',
  `auto_increment_prefix` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `load_remote` tinyint(1) NOT NULL DEFAULT '1',
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alert_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alerts_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `default_eula_text` longtext COLLATE utf8_unicode_ci,
  `barcode_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'QRCODE',
  `slack_endpoint` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slack_channel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slack_botname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_currency` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom_css` text COLLATE utf8_unicode_ci,
  `brand` tinyint(4) NOT NULL DEFAULT '1',
  `ldap_enabled` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ldap_server` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ldap_uname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ldap_pword` longtext COLLATE utf8_unicode_ci,
  `ldap_basedn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ldap_filter` text COLLATE utf8_unicode_ci,
  `ldap_username_field` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'samaccountname',
  `ldap_lname_field` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'sn',
  `ldap_fname_field` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'givenname',
  `ldap_auth_filter_query` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'uid=samaccountname',
  `ldap_version` int(11) DEFAULT '3',
  `ldap_active_flag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ldap_emp_num` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ldap_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `full_multiple_companies_support` tinyint(1) NOT NULL DEFAULT '0',
  `ldap_server_cert_ignore` tinyint(1) NOT NULL DEFAULT '0',
  `locale` varchar(5) COLLATE utf8_unicode_ci DEFAULT 'en',
  `labels_per_page` tinyint(4) NOT NULL DEFAULT '30',
  `labels_width` decimal(6,5) NOT NULL DEFAULT '2.62500',
  `labels_height` decimal(6,5) NOT NULL DEFAULT '1.00000',
  `labels_pmargin_left` decimal(6,5) NOT NULL DEFAULT '0.21975',
  `labels_pmargin_right` decimal(6,5) NOT NULL DEFAULT '0.21975',
  `labels_pmargin_top` decimal(6,5) NOT NULL DEFAULT '0.50000',
  `labels_pmargin_bottom` decimal(6,5) NOT NULL DEFAULT '0.50000',
  `labels_display_bgutter` decimal(6,5) NOT NULL DEFAULT '0.07000',
  `labels_display_sgutter` decimal(6,5) NOT NULL DEFAULT '0.05000',
  `labels_fontsize` tinyint(4) NOT NULL DEFAULT '9',
  `labels_pagewidth` decimal(7,5) NOT NULL DEFAULT '8.50000',
  `labels_pageheight` decimal(7,5) NOT NULL DEFAULT '11.00000',
  `labels_display_name` tinyint(4) NOT NULL DEFAULT '0',
  `labels_display_serial` tinyint(4) NOT NULL DEFAULT '1',
  `labels_display_tag` tinyint(4) NOT NULL DEFAULT '1',
  `alt_barcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'C128',
  `alt_barcode_enabled` tinyint(1) DEFAULT '1',
  `alert_interval` int(11) DEFAULT '30',
  `alert_threshold` int(11) DEFAULT '5',
  `email_domain` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_format` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'filastname',
  `username_format` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'filastname',
  `is_ad` tinyint(1) NOT NULL DEFAULT '0',
  `ad_domain` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ldap_port` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '389',
  `ldap_tls` tinyint(1) NOT NULL DEFAULT '0',
  `zerofill_count` int(11) NOT NULL DEFAULT '5',
  `ldap_pw_sync` tinyint(1) NOT NULL DEFAULT '1',
  `two_factor_enabled` tinyint(4) DEFAULT NULL,
  `require_accept_signature` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'2016-11-06 22:01:02','2016-11-06 22:01:02',1,20,'Test',NULL,NULL,NULL,NULL,NULL,0,'0',1,NULL,NULL,'snipe@google.com',1,NULL,'QRCODE',NULL,NULL,NULL,'USD',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,'samaccountname','sn','givenname','uid=samaccountname',3,NULL,NULL,NULL,0,0,'en',30,2.62500,1.00000,0.21975,0.21975,0.50000,0.50000,0.07000,0.05000,9,8.50000,11.00000,0,1,1,'C128',1,30,5,'tews.com','filastname','filastname',0,NULL,'389',0,5,1,NULL,0);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_labels`
--

DROP TABLE IF EXISTS `status_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_labels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deployable` tinyint(1) NOT NULL DEFAULT '0',
  `pending` tinyint(1) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8_unicode_ci,
  `color` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_in_nav` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_labels`
--

LOCK TABLES `status_labels` WRITE;
/*!40000 ALTER TABLE `status_labels` DISABLE KEYS */;
INSERT INTO `status_labels` VALUES (1,'Pending',1,NULL,NULL,NULL,0,1,0,'These assets are not yet ready to be deployed, usually because of configuration or waiting on parts.',NULL,0),(2,'Ready to Deploy',1,NULL,NULL,NULL,1,0,0,'These assets are ready to deploy.',NULL,0),(3,'Archived',1,NULL,NULL,NULL,0,0,1,'These assets are no longer in circulation or viable.',NULL,0),(5,'Undeployable',NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,0,0,NULL,NULL,0),(6,'Lost',NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,0,0,NULL,NULL,0),(7,'Pending Diagnostics',NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,1,0,0,NULL,NULL,0);
/*!40000 ALTER TABLE `status_labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Blogspan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,NULL,NULL,NULL),(2,'Oyope',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,NULL,NULL,NULL),(3,'Unknown',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,NULL,NULL,NULL),(4,'Ntag',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:21','2016-11-06 22:03:21',1,NULL,NULL,NULL,NULL),(5,'Kwilith',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(6,'Linkbridge',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(7,'Wikizz',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(8,'Tagcat',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(9,'Meevee',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(10,'Shuffledrive',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(11,'Quamba',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(12,'Browsedrive',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(13,'Tekfly',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(14,'Quatz',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL),(15,'Mydeo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-11-06 22:03:22','2016-11-06 22:03:22',1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `throttle`
--

DROP TABLE IF EXISTS `throttle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `throttle`
--

LOCK TABLES `throttle` WRITE;
/*!40000 ALTER TABLE `throttle` DISABLE KEYS */;
/*!40000 ALTER TABLE `throttle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `employee_num` text COLLATE utf8_unicode_ci,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `company_id` int(10) unsigned DEFAULT NULL,
  `remember_token` text COLLATE utf8_unicode_ci,
  `ldap_import` tinyint(1) NOT NULL DEFAULT '0',
  `locale` varchar(5) COLLATE utf8_unicode_ci DEFAULT 'en',
  `show_in_list` tinyint(1) NOT NULL DEFAULT '1',
  `two_factor_secret` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `two_factor_enrolled` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_optin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'snipe@google.com','$2y$10$oSjP81uCdXW.nAHBIPteA..DsLPhJBiwD1tfny4hY0Ndicv1B5Nk6','{\"superuser\":\"1\",\"admin\":\"0\",\"reports.view\":\"0\",\"assets.view\":\"0\",\"assets.create\":\"0\",\"assets.edit\":\"0\",\"assets.delete\":\"0\",\"assets.checkin\":\"0\",\"assets.checkout\":\"0\",\"assets.view.requestable\":\"0\",\"accessories.view\":\"0\",\"accessories.create\":\"0\",\"accessories.edit\":\"0\",\"accessories.delete\":\"0\",\"accessories.checkout\":\"0\",\"accessories.checkin\":\"0\",\"consumables.view\":\"0\",\"consumables.create\":\"0\",\"consumables.edit\":\"0\",\"consumables.delete\":\"0\",\"consumables.checkout\":\"0\",\"licenses.view\":\"0\",\"licenses.create\":\"0\",\"licenses.edit\":\"0\",\"licenses.delete\":\"0\",\"licenses.checkout\":\"0\",\"licenses.keys\":\"0\",\"components.view\":\"0\",\"components.create\":\"0\",\"components.edit\":\"0\",\"components.delete\":\"0\",\"components.checkout\":\"0\",\"components.checkin\":\"0\",\"users.view\":\"0\",\"users.create\":\"0\",\"users.edit\":\"0\",\"users.delete\":\"0\",\"self.two_factor\":\"0\"}',1,NULL,NULL,NULL,NULL,NULL,'snipe','Snipe','2016-11-06 22:01:02','2016-11-06 22:43:51',NULL,NULL,NULL,NULL,NULL,'','',NULL,'',NULL,'snipeit','',NULL,'kI2xkXMnCbh5YXRD9nBWqwauSIgANXp9DRzwbeapxFqtWs1qKxDFEOOaCqfE',0,'en',1,NULL,0,0),(3,'bnelson0@cdbaby.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Bonnie',' Nelson','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bnelson0',NULL,NULL,NULL,0,'en',1,NULL,0,0),(4,'jferguson1@state.tx.us','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Judith',' Ferguson','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'jferguson1',NULL,NULL,NULL,0,'en',1,NULL,0,0),(5,'mgibson2@wiley.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Mildred',' Gibson','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'mgibson2',NULL,NULL,NULL,0,'en',1,NULL,0,0),(6,'blee3@quantcast.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Brandon',' Lee','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'blee3',NULL,NULL,NULL,0,'en',1,NULL,0,0),(7,'bpowell4@tuttocitta.it','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Betty',' Powell','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bpowell4',NULL,NULL,NULL,0,'en',1,NULL,0,0),(8,'awheeler5@cocolog-nifty.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Anthony',' Wheeler','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'awheeler5',NULL,NULL,NULL,0,'en',1,NULL,0,0),(9,'dreynolds6@ustream.tv','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Dennis',' Reynolds','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'dreynolds6',NULL,NULL,NULL,0,'en',1,NULL,0,0),(10,'aarnold7@cbc.ca','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Andrea',' Arnold','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'aarnold7',NULL,NULL,NULL,0,'en',1,NULL,0,0),(11,'abutler8@wikia.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Anna',' Butler','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'abutler8',NULL,NULL,NULL,0,'en',1,NULL,0,0),(12,'mbennett9@diigo.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Mark',' Bennett','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'mbennett9',NULL,NULL,NULL,0,'en',1,NULL,0,0),(13,'ewheelera@google.de','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Emily',' Wheeler','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ewheelera',NULL,NULL,NULL,0,'en',1,NULL,0,0),(14,'wfoxb@virginia.edu','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Wanda',' Fox','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'wfoxb',NULL,NULL,NULL,0,'en',1,NULL,0,0),(15,'jgrantd@cpanel.net','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Janet',' Grant','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'jgrantd',NULL,NULL,NULL,0,'en',1,NULL,0,0),(16,'alarsone@tripod.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Antonio',' Larson','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'alarsone',NULL,NULL,NULL,0,'en',1,NULL,0,0),(17,'lpowellf@com.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Lois',' Powell','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'lpowellf',NULL,NULL,NULL,0,'en',1,NULL,0,0),(18,'malleng@com.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Mildred',' Allen','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'malleng',NULL,NULL,NULL,0,'en',1,NULL,0,0),(19,'caustinh@bigcartel.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Clarence',' Austin','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'caustinh',NULL,NULL,NULL,0,'en',1,NULL,0,0),(20,'wchavezi@blogs.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Walter',' Chavez','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'wchavezi',NULL,NULL,NULL,0,'en',1,NULL,0,0),(21,'melliottj@constantcontact.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Marie',' Elliott','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'melliottj',NULL,NULL,NULL,0,'en',1,NULL,0,0),(22,'bfordm@woothemes.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Benjamin',' Ford','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bfordm',NULL,NULL,NULL,0,'en',1,NULL,0,0),(23,'twarrenn@printfriendly.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Timothy',' Warren','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'twarrenn',NULL,NULL,NULL,0,'en',1,NULL,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-06 10:44:44
