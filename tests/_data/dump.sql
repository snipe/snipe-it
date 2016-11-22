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
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `model_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accessories`
--

LOCK TABLES `accessories` WRITE;
/*!40000 ALTER TABLE `accessories` DISABLE KEYS */;
INSERT INTO `accessories` VALUES (1,'Voluptatem enim.',15,NULL,8,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,1,NULL,NULL,NULL,2,2,NULL,NULL),(2,'Dolores aut aut.',14,NULL,7,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,3,NULL,NULL,NULL,3,1,NULL,NULL),(3,'Quaerat corrupti.',13,NULL,9,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,3,NULL,NULL,NULL,3,1,NULL,NULL),(4,'Expedita mollitia.',12,NULL,9,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,4,NULL,NULL,NULL,1,2,NULL,NULL),(5,'Est culpa totam.',11,NULL,8,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,1,NULL,NULL,NULL,3,2,NULL,NULL),(6,'Quae esse vero.',12,NULL,7,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,3,NULL,NULL,NULL,4,1,NULL,NULL),(7,'Nemo rerum soluta.',14,NULL,6,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,4,NULL,NULL,NULL,3,1,NULL,NULL),(8,'Ut error deleniti.',13,NULL,7,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,5,NULL,NULL,NULL,4,2,NULL,NULL),(9,'Est ut ad et quos.',13,NULL,8,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,3,NULL,NULL,NULL,3,2,NULL,NULL),(10,'Itaque voluptas est.',13,NULL,9,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,1,NULL,NULL,NULL,2,1,NULL,NULL),(11,'Est aspernatur in.',12,NULL,6,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,2,NULL,NULL,NULL,3,1,NULL,NULL),(12,'Consequatur quo a.',15,NULL,10,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,4,NULL,NULL,NULL,2,2,NULL,NULL),(13,'Placeat perferendis.',14,NULL,10,0,'2016-11-20 23:07:28','2016-11-21 00:33:27','2016-11-21 00:33:27',3,NULL,NULL,NULL,3,2,NULL,NULL),(14,'Dolore corrupti.',12,NULL,7,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,3,NULL,NULL,NULL,4,2,NULL,NULL),(15,'Ut pariatur.',14,NULL,5,0,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,4,NULL,NULL,NULL,2,1,NULL,NULL),(16,'TestAccessory',19,1,12,0,'2016-11-21 00:33:26','2016-11-21 00:33:26',NULL,5,'2016-01-01',25.00,'12345',4,6,8,'');
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
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_logs`
--

LOCK TABLES `action_logs` WRITE;
/*!40000 ALTER TABLE `action_logs` DISABLE KEYS */;
INSERT INTO `action_logs` VALUES (1,26,'checkout',39,'App\\Models\\User',NULL,'Minus architecto autem neque vel ut.',NULL,'App\\Models\\Asset',36,NULL,NULL,'1972-01-14 18:00:46','2016-11-20 23:07:29',NULL,NULL,2,NULL),(2,34,'checkout',42,'App\\Models\\User',NULL,'Odio optio vitae ipsa facere repudiandae consequatur.',NULL,'App\\Models\\Asset',54,NULL,NULL,'2003-10-04 22:32:16','2016-11-20 23:07:29',NULL,NULL,3,NULL),(3,40,'checkout',36,'App\\Models\\User',NULL,'Aliquid eligendi nesciunt expedita repudiandae alias veritatis hic.',NULL,'App\\Models\\Asset',1,NULL,NULL,'1978-02-16 03:07:32','2016-11-20 23:07:29',NULL,NULL,4,NULL),(4,41,'checkout',40,'App\\Models\\User',NULL,'Earum corrupti impedit ab sed placeat.',NULL,'App\\Models\\Asset',28,NULL,NULL,'2009-12-09 21:33:02','2016-11-20 23:07:29',NULL,NULL,4,NULL),(5,34,'checkout',34,'App\\Models\\User',NULL,'Exercitationem aut repellendus officiis impedit pariatur aut rerum.',NULL,'App\\Models\\Asset',4,NULL,NULL,'1978-12-03 19:18:58','2016-11-20 23:07:29',NULL,NULL,3,NULL),(6,29,'checkout',31,'App\\Models\\User',NULL,'Dolores nostrum deleniti laborum voluptatem quas eligendi iste et.',NULL,'App\\Models\\Asset',36,NULL,NULL,'2000-03-22 00:11:42','2016-11-20 23:07:29',NULL,NULL,2,NULL),(7,43,'checkout',44,'App\\Models\\User',NULL,'Voluptate et omnis omnis quidem impedit mollitia harum.',NULL,'App\\Models\\Asset',97,NULL,NULL,'2006-07-17 06:26:47','2016-11-20 23:07:29',NULL,NULL,1,NULL),(8,27,'checkout',27,'App\\Models\\User',NULL,'Aspernatur dolores non ab cum.',NULL,'App\\Models\\Asset',5,NULL,NULL,'2000-04-11 13:21:42','2016-11-20 23:07:29',NULL,NULL,2,NULL),(9,25,'checkout',32,'App\\Models\\User',NULL,'Et ipsa adipisci nisi beatae.',NULL,'App\\Models\\Asset',29,NULL,NULL,'1970-08-21 14:33:04','2016-11-20 23:07:29',NULL,NULL,1,NULL),(10,40,'checkout',36,'App\\Models\\User',NULL,'Non sunt architecto omnis delectus dolorem qui est.',NULL,'App\\Models\\Asset',40,NULL,NULL,'2003-01-07 19:51:30','2016-11-20 23:07:29',NULL,NULL,4,NULL),(11,24,'checkout',25,'App\\Models\\User',NULL,'Explicabo itaque eos dolor officia itaque labore ipsam.',NULL,'App\\Models\\Asset',48,NULL,NULL,'2013-12-15 02:06:16','2016-11-20 23:07:29',NULL,NULL,1,NULL),(12,40,'checkout',37,'App\\Models\\User',NULL,'Quibusdam minima quisquam veniam est repudiandae in.',NULL,'App\\Models\\Asset',49,NULL,NULL,'2000-04-10 18:27:00','2016-11-20 23:07:29',NULL,NULL,4,NULL),(13,34,'checkout',34,'App\\Models\\User',NULL,'Magnam consectetur ut unde omnis corporis perferendis.',NULL,'App\\Models\\Asset',83,NULL,NULL,'1994-12-22 15:29:46','2016-11-20 23:07:29',NULL,NULL,3,NULL),(14,34,'checkout',34,'App\\Models\\User',NULL,'Velit ut nam voluptates et et repellendus.',NULL,'App\\Models\\Asset',92,NULL,NULL,'1993-03-25 07:22:31','2016-11-20 23:07:29',NULL,NULL,3,NULL),(15,25,'checkout',24,'App\\Models\\User',NULL,'Totam quia modi voluptate soluta.',NULL,'App\\Models\\Asset',50,NULL,NULL,'1983-12-24 12:33:35','2016-11-20 23:07:30',NULL,NULL,1,NULL),(16,35,'checkout',44,'App\\Models\\User',NULL,'Quas occaecati necessitatibus distinctio.',NULL,'App\\Models\\Asset',84,NULL,NULL,'1999-02-04 03:31:56','2016-11-20 23:07:30',NULL,NULL,1,NULL),(17,42,'checkout',42,'App\\Models\\User',NULL,'Dolores aut recusandae aut deserunt magni non.',NULL,'App\\Models\\Asset',2,NULL,NULL,'2014-08-20 09:31:19','2016-11-20 23:07:30',NULL,NULL,3,NULL),(18,24,'checkout',24,'App\\Models\\User',NULL,'Officiis porro voluptatem placeat aut voluptas quis est.',NULL,'App\\Models\\Asset',60,NULL,NULL,'1993-10-15 18:56:40','2016-11-20 23:07:30',NULL,NULL,1,NULL),(19,43,'checkout',28,'App\\Models\\User',NULL,'Necessitatibus repellat itaque illo qui officiis aut non.',NULL,'App\\Models\\Asset',86,NULL,NULL,'1980-01-26 00:20:38','2016-11-20 23:07:30',NULL,NULL,1,NULL),(20,36,'checkout',41,'App\\Models\\User',NULL,'Vel nihil ut et vel et doloribus ut.',NULL,'App\\Models\\Asset',62,NULL,NULL,'2000-01-13 15:45:17','2016-11-20 23:07:30',NULL,NULL,4,NULL),(21,42,'checkout',30,'App\\Models\\User',NULL,'Reprehenderit porro tempore saepe nisi illum qui.',NULL,'App\\Models\\Asset',2,NULL,NULL,'2014-07-25 15:21:25','2016-11-20 23:07:30',NULL,NULL,3,NULL),(22,36,'checkout',36,'App\\Models\\User',NULL,'Totam corporis aut beatae voluptatem nihil labore nihil vero.',NULL,'App\\Models\\Asset',68,NULL,NULL,'2012-11-12 12:07:30','2016-11-20 23:07:30',NULL,NULL,4,NULL),(23,31,'checkout',39,'App\\Models\\User',NULL,'Repudiandae debitis molestias odio iste voluptatem eum.',NULL,'App\\Models\\Asset',23,NULL,NULL,'1975-01-11 12:34:13','2016-11-20 23:07:30',NULL,NULL,2,NULL),(24,30,'checkout',34,'App\\Models\\User',NULL,'Repellat nisi doloribus optio porro nisi magnam.',NULL,'App\\Models\\Asset',17,NULL,NULL,'2012-03-28 03:56:46','2016-11-20 23:07:30',NULL,NULL,3,NULL),(25,26,'checkout',29,'App\\Models\\User',NULL,'Excepturi sunt quo libero illum vitae.',NULL,'App\\Models\\Asset',10,NULL,NULL,'2009-11-25 08:36:11','2016-11-20 23:07:30',NULL,NULL,2,NULL),(26,43,'checkout',35,'App\\Models\\User',NULL,'Laborum quia molestiae totam quam sapiente aut quaerat fugit.',NULL,'App\\Models\\Accessory',4,NULL,NULL,'1986-03-15 09:45:58','2016-11-20 23:07:30',NULL,NULL,1,NULL),(27,31,'checkout',38,'App\\Models\\User',NULL,'Perspiciatis possimus est qui excepturi mollitia aspernatur animi.',NULL,'App\\Models\\Accessory',15,NULL,NULL,'2003-02-16 03:08:32','2016-11-20 23:07:30',NULL,NULL,2,NULL),(28,29,'checkout',31,'App\\Models\\User',NULL,'Ab unde dicta ut odit temporibus facilis.',NULL,'App\\Models\\Accessory',1,NULL,NULL,'1992-02-26 19:41:44','2016-11-20 23:07:30',NULL,NULL,2,NULL),(29,30,'checkout',34,'App\\Models\\User',NULL,'Vero qui iste ipsum ad labore.',NULL,'App\\Models\\Accessory',3,NULL,NULL,'1979-04-19 20:56:34','2016-11-20 23:07:30',NULL,NULL,3,NULL),(30,31,'checkout',29,'App\\Models\\User',NULL,'Dolorum nesciunt atque et iste quia doloremque quasi.',NULL,'App\\Models\\Accessory',10,NULL,NULL,'2007-10-14 11:53:40','2016-11-20 23:07:30',NULL,NULL,2,NULL),(31,24,'checkout',25,'App\\Models\\User',NULL,'Labore aliquid rerum rerum fugit impedit optio.',NULL,'App\\Models\\Accessory',4,NULL,NULL,'2014-05-17 04:23:16','2016-11-20 23:07:30',NULL,NULL,1,NULL),(32,40,'checkout',41,'App\\Models\\User',NULL,'Id et ducimus similique unde.',NULL,'App\\Models\\Accessory',6,NULL,NULL,'2012-03-19 12:34:56','2016-11-20 23:07:30',NULL,NULL,4,NULL),(33,42,'checkout',34,'App\\Models\\User',NULL,'Aliquid quisquam non quo nihil enim et.',NULL,'App\\Models\\Accessory',3,NULL,NULL,'2000-09-07 05:58:59','2016-11-20 23:07:30',NULL,NULL,3,NULL),(34,42,'checkout',42,'App\\Models\\User',NULL,'Rerum possimus voluptas voluptate sit ut incidunt et.',NULL,'App\\Models\\Accessory',3,NULL,NULL,'2003-08-10 04:47:44','2016-11-20 23:07:30',NULL,NULL,3,NULL),(35,30,'checkout',34,'App\\Models\\User',NULL,'Est rerum temporibus ratione voluptatem dolorem minus.',NULL,'App\\Models\\Accessory',11,NULL,NULL,'1974-01-18 19:02:43','2016-11-20 23:07:30',NULL,NULL,3,NULL),(36,44,'checkout',44,'App\\Models\\User',NULL,'Voluptatem harum et ea possimus et.',NULL,'App\\Models\\Accessory',4,NULL,NULL,'1978-03-20 15:07:44','2016-11-20 23:07:30',NULL,NULL,1,NULL),(37,29,'checkout',26,'App\\Models\\User',NULL,'Minima fugit voluptas in harum suscipit aut.',NULL,'App\\Models\\Accessory',12,NULL,NULL,'1973-05-25 22:49:02','2016-11-20 23:07:30',NULL,NULL,2,NULL),(38,40,'checkout',33,'App\\Models\\User',NULL,'Officiis non dolorem consequuntur.',NULL,'App\\Models\\Accessory',6,NULL,NULL,'2002-01-19 14:02:55','2016-11-20 23:07:30',NULL,NULL,4,NULL),(39,30,'checkout',34,'App\\Models\\User',NULL,'Quidem et deleniti temporibus aut consectetur ipsam id.',NULL,'App\\Models\\Accessory',7,NULL,NULL,'2012-03-04 15:45:00','2016-11-20 23:07:30',NULL,NULL,3,NULL),(40,30,'checkout',34,'App\\Models\\User',NULL,'Quia totam ratione aliquam animi aliquam at.',NULL,'App\\Models\\Accessory',11,NULL,NULL,'2014-07-15 00:14:16','2016-11-20 23:07:30',NULL,NULL,3,NULL),(41,30,'checkout',42,'App\\Models\\User',NULL,'Dolorem eius ipsum et omnis.',NULL,'App\\Models\\Consumable',10,NULL,NULL,'1970-04-18 03:14:14','2016-11-20 23:07:30',NULL,NULL,3,NULL),(42,43,'checkout',25,'App\\Models\\User',NULL,'Et qui veritatis tenetur.',NULL,'App\\Models\\Consumable',23,NULL,NULL,'1991-12-24 00:58:37','2016-11-20 23:07:30',NULL,NULL,1,NULL),(43,27,'checkout',27,'App\\Models\\User',NULL,'Voluptatem velit quo voluptatum illo.',NULL,'App\\Models\\Consumable',15,NULL,NULL,'1975-03-22 13:47:58','2016-11-20 23:07:30',NULL,NULL,2,NULL),(44,41,'checkout',40,'App\\Models\\User',NULL,'Nobis non sint nisi eligendi ut qui quo.',NULL,'App\\Models\\Consumable',16,NULL,NULL,'1987-05-18 08:21:45','2016-11-20 23:07:30',NULL,NULL,4,NULL),(45,44,'checkout',28,'App\\Models\\User',NULL,'Dolorum iste pariatur non molestias quo possimus aut qui.',NULL,'App\\Models\\Consumable',18,NULL,NULL,'1977-10-31 11:56:47','2016-11-20 23:07:30',NULL,NULL,1,NULL),(46,25,'checkout',24,'App\\Models\\User',NULL,'Nemo et inventore omnis ipsum et.',NULL,'App\\Models\\Consumable',2,NULL,NULL,'1972-09-01 04:51:50','2016-11-20 23:07:30',NULL,NULL,1,NULL),(47,33,'checkout',33,'App\\Models\\User',NULL,'Odio sunt beatae facere quae.',NULL,'App\\Models\\Consumable',3,NULL,NULL,'2010-07-02 14:17:15','2016-11-20 23:07:30',NULL,NULL,4,NULL),(48,27,'checkout',39,'App\\Models\\User',NULL,'Rerum eveniet dolor maiores earum.',NULL,'App\\Models\\Consumable',24,NULL,NULL,'1985-06-24 03:57:41','2016-11-20 23:07:30',NULL,NULL,2,NULL),(49,24,'checkout',25,'App\\Models\\User',NULL,'Unde delectus corporis ad provident assumenda molestias consequatur sint.',NULL,'App\\Models\\Consumable',18,NULL,NULL,'1990-10-16 14:04:14','2016-11-20 23:07:30',NULL,NULL,1,NULL),(50,41,'checkout',33,'App\\Models\\User',NULL,'Vero ea corrupti eius voluptatibus corporis iste officiis est.',NULL,'App\\Models\\Consumable',3,NULL,NULL,'1988-08-15 17:36:08','2016-11-20 23:07:30',NULL,NULL,4,NULL),(51,34,'checkout',34,'App\\Models\\User',NULL,'Et ad quaerat in commodi.',NULL,'App\\Models\\Consumable',14,NULL,NULL,'1970-04-02 22:05:18','2016-11-20 23:07:30',NULL,NULL,3,NULL),(52,27,'checkout',39,'App\\Models\\User',NULL,'Aliquam ut minus quis qui repellat placeat.',NULL,'App\\Models\\Consumable',1,NULL,NULL,'2005-06-21 04:36:35','2016-11-20 23:07:30',NULL,NULL,2,NULL),(53,27,'checkout',26,'App\\Models\\User',NULL,'Est provident dolorem est.',NULL,'App\\Models\\Consumable',24,NULL,NULL,'1998-08-11 04:12:32','2016-11-20 23:07:30',NULL,NULL,2,NULL),(54,38,'checkout',38,'App\\Models\\User',NULL,'Suscipit et corporis et impedit enim.',NULL,'App\\Models\\Consumable',9,NULL,NULL,'1973-03-25 08:34:15','2016-11-20 23:07:30',NULL,NULL,2,NULL),(55,29,'checkout',31,'App\\Models\\User',NULL,'Occaecati earum sed aspernatur ex pariatur assumenda fuga.',NULL,'App\\Models\\Consumable',17,NULL,NULL,'2006-03-24 14:39:34','2016-11-20 23:07:30',NULL,NULL,2,NULL),(56,24,'checkout',25,'App\\Models\\User',NULL,'Perspiciatis expedita voluptas iure facilis debitis sed.',NULL,'App\\Models\\Component',8,NULL,NULL,'2010-02-22 13:01:32','2016-11-20 23:07:30',NULL,NULL,1,NULL),(57,31,'checkout',27,'App\\Models\\User',NULL,'Quos enim in quidem et quia.',NULL,'App\\Models\\Component',5,NULL,NULL,'2002-01-19 19:08:11','2016-11-20 23:07:30',NULL,NULL,2,NULL),(58,35,'checkout',32,'App\\Models\\User',NULL,'Dolorem fugiat sapiente aut rem.',NULL,'App\\Models\\Component',9,NULL,NULL,'2004-02-02 02:21:13','2016-11-20 23:07:30',NULL,NULL,1,NULL),(59,40,'checkout',36,'App\\Models\\User',NULL,'Harum unde minus praesentium et.',NULL,'App\\Models\\Component',4,NULL,NULL,'1974-09-30 16:26:05','2016-11-20 23:07:30',NULL,NULL,4,NULL),(60,30,'checkout',34,'App\\Models\\User',NULL,'Et et et maxime laudantium nihil.',NULL,'App\\Models\\Component',3,NULL,NULL,'1977-09-08 05:22:06','2016-11-20 23:07:30',NULL,NULL,3,NULL),(61,35,'checkout',35,'App\\Models\\User',NULL,'Id iste id animi.',NULL,'App\\Models\\Component',9,NULL,NULL,'1971-04-06 04:16:29','2016-11-20 23:07:30',NULL,NULL,1,NULL),(62,24,'checkout',44,'App\\Models\\User',NULL,'Optio laborum sint delectus sint porro consequuntur.',NULL,'App\\Models\\Component',10,NULL,NULL,'1976-07-02 09:12:21','2016-11-20 23:07:30',NULL,NULL,1,NULL),(63,26,'checkout',26,'App\\Models\\User',NULL,'Recusandae eum porro id.',NULL,'App\\Models\\Component',5,NULL,NULL,'2016-03-06 02:09:25','2016-11-20 23:07:30',NULL,NULL,2,NULL),(64,37,'checkout',33,'App\\Models\\User',NULL,'Aut voluptas facilis reprehenderit ut consectetur.',NULL,'App\\Models\\Component',4,NULL,NULL,'1994-03-25 08:16:58','2016-11-20 23:07:30',NULL,NULL,4,NULL),(65,42,'checkout',30,'App\\Models\\User',NULL,'Mollitia et officiis iste id quis sint.',NULL,'App\\Models\\Component',3,NULL,NULL,'2001-10-12 06:59:58','2016-11-20 23:07:30',NULL,NULL,3,NULL),(66,29,'checkout',29,'App\\Models\\User',NULL,'Eos aliquid maxime et ea porro et.',NULL,'App\\Models\\Component',6,NULL,NULL,'2013-08-26 01:44:47','2016-11-20 23:07:30',NULL,NULL,2,NULL),(67,30,'checkout',42,'App\\Models\\User',NULL,'Maxime quibusdam sed fugiat ex.',NULL,'App\\Models\\Component',3,NULL,NULL,'1987-01-17 04:30:12','2016-11-20 23:07:30',NULL,NULL,3,NULL),(68,37,'checkout',41,'App\\Models\\User',NULL,'Ea et tempora magni nam sit consequatur.',NULL,'App\\Models\\Component',2,NULL,NULL,'2005-12-08 16:20:24','2016-11-20 23:07:30',NULL,NULL,4,NULL),(69,42,'checkout',34,'App\\Models\\User',NULL,'Reiciendis hic dicta labore saepe quia dolore minus.',NULL,'App\\Models\\Component',3,NULL,NULL,'1984-03-22 03:00:37','2016-11-20 23:07:30',NULL,NULL,3,NULL),(70,40,'checkout',33,'App\\Models\\User',NULL,'Consequatur dolor iste quidem rerum perspiciatis quisquam.',NULL,'App\\Models\\Component',2,NULL,NULL,'2015-09-15 22:36:44','2016-11-20 23:07:30',NULL,NULL,4,NULL),(71,41,'checkout',41,'App\\Models\\Asset',NULL,'Mollitia nulla incidunt autem non veritatis culpa ipsum.',NULL,'App\\Models\\License',7,NULL,NULL,'1974-07-30 00:54:19','2016-11-20 23:07:30',NULL,NULL,4,NULL),(72,41,'checkout',47,'App\\Models\\Asset',NULL,'Eos aut reiciendis eaque quam.',NULL,'App\\Models\\License',7,NULL,NULL,'1985-08-02 17:10:38','2016-11-20 23:07:30',NULL,NULL,4,NULL),(73,33,'checkout',1,'App\\Models\\Asset',NULL,'Quas nobis culpa nihil at.',NULL,'App\\Models\\License',4,NULL,NULL,'1999-11-08 18:13:14','2016-11-20 23:07:30',NULL,NULL,4,NULL),(74,30,'checkout',42,'App\\Models\\Asset',NULL,'Est quis quo ipsa vel repudiandae.',NULL,'App\\Models\\License',1,NULL,NULL,'2016-11-03 21:47:29','2016-11-20 23:07:30',NULL,NULL,3,NULL),(75,37,'checkout',68,'App\\Models\\Asset',NULL,'Nihil ut eos omnis est consequatur eum.',NULL,'App\\Models\\License',7,NULL,NULL,'1971-06-15 04:38:12','2016-11-20 23:07:30',NULL,NULL,4,NULL),(76,27,'checkout',100,'App\\Models\\Asset',NULL,'Quod perferendis aliquid temporibus ut aut.',NULL,'App\\Models\\License',3,NULL,NULL,'1974-12-18 16:59:54','2016-11-20 23:07:30',NULL,NULL,2,NULL),(77,42,'checkout',96,'App\\Models\\Asset',NULL,'Et aspernatur provident excepturi.',NULL,'App\\Models\\License',1,NULL,NULL,'1975-08-09 17:31:54','2016-11-20 23:07:30',NULL,NULL,3,NULL),(78,40,'checkout',38,'App\\Models\\Asset',NULL,'Quia et quasi sint perspiciatis voluptate fugit.',NULL,'App\\Models\\License',7,NULL,NULL,'1976-07-21 10:51:54','2016-11-20 23:07:30',NULL,NULL,4,NULL),(79,35,'checkout',98,'App\\Models\\Asset',NULL,'Laborum est eos porro nihil in.',NULL,'App\\Models\\License',5,NULL,NULL,'2011-02-04 03:40:05','2016-11-20 23:07:30',NULL,NULL,1,NULL),(80,30,'checkout',92,'App\\Models\\Asset',NULL,'Architecto enim officiis accusamus asperiores dolorem sequi.',NULL,'App\\Models\\License',1,NULL,NULL,'2002-05-25 16:02:39','2016-11-20 23:07:30',NULL,NULL,3,NULL),(81,42,'checkout',92,'App\\Models\\Asset',NULL,'Adipisci cum totam nostrum dolorem aut velit.',NULL,'App\\Models\\License',1,NULL,NULL,'2003-04-11 12:01:28','2016-11-20 23:07:30',NULL,NULL,3,NULL),(82,38,'checkout',6,'App\\Models\\Asset',NULL,'Repudiandae sit qui est aut est.',NULL,'App\\Models\\License',10,NULL,NULL,'1997-03-20 06:55:10','2016-11-20 23:07:30',NULL,NULL,2,NULL),(83,42,'checkout',31,'App\\Models\\Asset',NULL,'Voluptates quia temporibus aut quia sequi.',NULL,'App\\Models\\License',1,NULL,NULL,'1979-07-30 22:23:20','2016-11-20 23:07:30',NULL,NULL,3,NULL),(84,26,'checkout',37,'App\\Models\\Asset',NULL,'Sit ut expedita quo aperiam iure.',NULL,'App\\Models\\License',6,NULL,NULL,'1976-03-26 22:44:34','2016-11-20 23:07:30',NULL,NULL,2,NULL),(85,37,'checkout',8,'App\\Models\\Asset',NULL,'Quo nihil non voluptatem omnis omnis ut et.',NULL,'App\\Models\\License',8,NULL,NULL,'2004-06-22 07:53:01','2016-11-20 23:07:30',NULL,NULL,4,NULL),(86,1,'created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\Accessory',16,NULL,NULL,'2016-11-21 00:33:26','2016-11-21 00:33:26',NULL,NULL,4,NULL),(87,1,'created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\Asset',101,NULL,NULL,'2016-11-21 00:33:30','2016-11-21 00:33:30',NULL,NULL,2,NULL),(88,1,'checkout',20,'App\\Models\\User',NULL,'Checked out on asset creation',NULL,'App\\Models\\Asset',101,NULL,NULL,'2016-11-21 00:33:30','2016-11-21 00:33:30',NULL,NULL,NULL,NULL),(89,1,'created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\Component',11,NULL,NULL,'2016-11-21 00:33:36','2016-11-21 00:33:36',NULL,NULL,2,NULL),(90,1,'created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\Consumable',26,NULL,NULL,'2016-11-21 00:33:39','2016-11-21 00:33:39',NULL,NULL,2,NULL),(91,1,'created',NULL,NULL,NULL,NULL,NULL,'App\\Models\\License',11,NULL,NULL,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL,4,NULL);
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
  `cost` decimal(20,2) DEFAULT NULL,
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
  `purchase_cost` decimal(20,2) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES (1,'Sharable contextually-based function','310455216',4,'de8ec8cb-387d-3861-accf-031a26b6da4b','1989-11-14',NULL,'3452948',NULL,'Error quas error libero suscipit qui hic non.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,0,1,NULL,NULL,NULL,NULL,4),(2,'Digitized didactic capacity','842399003',5,'c579659e-e6df-3f21-8b32-f2e5e60cb960','1975-02-19',NULL,'5783754',NULL,'Quibusdam consectetur sunt perspiciatis error.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,1,4,NULL,NULL,NULL,NULL,3),(3,'Enhanced executive groupware','990185629',1,'8e09a1b5-ecf1-3ea0-b045-f51fb5631fb8','1971-07-19',NULL,'24388545',NULL,'Doloremque labore quos excepturi est accusamus at cumque a.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,0,3,NULL,NULL,NULL,NULL,1),(4,'Customer-focused intangible complexity','546752914',4,'82ea2c28-c182-3c5d-b370-4c8c66b96d02','2000-11-27',NULL,'34470480',NULL,'Assumenda consequatur dolores quo commodi.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,1,4,NULL,NULL,NULL,NULL,3),(5,'Configurable client-driven support','212535141',1,'5efd5c23-b151-3a8b-87e3-4d3479571ba4','1988-09-22',NULL,'3328283',NULL,'Ad est quidem aliquam quae voluptatem nam.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,1,5,NULL,NULL,NULL,NULL,2),(6,'User-centric static toolset','411277269',5,'e82002a4-450c-3ff2-9568-71e7e5b67b36','1972-05-18',NULL,'3971980',NULL,'Ducimus quasi sed quis eius unde.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,0,3,NULL,NULL,NULL,NULL,2),(7,'Virtual neutral monitoring','1172159860',4,'0a7a05c7-8b7b-3896-aa26-418dbc5f56ef','1985-11-20',NULL,'10377281',NULL,'Necessitatibus est et nam doloremque impedit enim libero qui.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,1,5,NULL,NULL,NULL,NULL,1),(8,'Monitored mission-critical time-frame','298965372',2,'7c5cd287-32b1-30f5-979d-d50b24411c35','2000-01-03',NULL,'25514597',NULL,'Aut harum dignissimos quia officia ipsum qui corporis laudantium.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,1,2,NULL,NULL,NULL,NULL,4),(9,'Upgradable background structure','1040526590',4,'0c973af0-7192-39af-8d15-61df89c44516','2007-09-13',NULL,'3935957',NULL,'Distinctio quia quod adipisci sunt.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,NULL,2),(10,'Facetoface holistic task-force','820364496',3,'85e0b99c-9e20-3fa4-8fbc-b03c947496cf','1992-05-08',NULL,'40804751',NULL,'Quo velit fuga occaecati quia.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,0,5,NULL,NULL,NULL,NULL,2),(11,'Team-oriented holistic service-desk','993520225',1,'e6641a5d-34d5-318e-b4e0-a6c56c460194','1978-10-13',NULL,'8692167',NULL,'Eum et voluptate omnis.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,0,2,NULL,NULL,NULL,NULL,3),(12,'Configurable heuristic capability','925029102',5,'5bc69980-51fa-35bf-8dd4-18397ca99282','1998-02-05',NULL,'31551001',NULL,'Praesentium et autem quis minima neque enim enim.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,0,2,NULL,NULL,NULL,NULL,4),(13,'Expanded systemic forecast','1194379470',1,'52cbe397-fdcf-3502-9d05-fcb291bbc7a9','1976-09-12',NULL,'33902721',NULL,'Suscipit excepturi magni voluptatem dolores veniam est.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,0,5,NULL,NULL,NULL,NULL,1),(14,'Robust demand-driven knowledgeuser','614105786',1,'8d38ebeb-ae28-37f5-817f-ca9ee939c6ec','1985-09-19',NULL,'24172772',NULL,'Saepe dolorem atque atque quia debitis incidunt delectus.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,0,4,NULL,NULL,NULL,NULL,1),(15,'Synergistic systemic circuit','1346537212',4,'46051bf4-eb05-35f2-b1a2-9cdf7101360f','2015-03-14',NULL,'3419670',NULL,'Doloribus rerum sint itaque cumque.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,1,2,NULL,NULL,NULL,NULL,1),(16,'Switchable grid-enabled frame','806381735',1,'b33dde10-66f9-31fd-b21f-5b8d33e5b181','1971-03-16',NULL,'23911374',NULL,'Cumque quis qui voluptas possimus.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,0,1,NULL,NULL,NULL,NULL,3),(17,'Reactive optimal budgetarymanagement','577709240',2,'8f09492b-26d5-3bc5-92df-0c6a7086f121','2011-02-26',NULL,'7513540',NULL,'Sit ullam provident aut.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,1,4,NULL,NULL,NULL,NULL,3),(18,'Total zerodefect capacity','234586180',5,'b34cf5bd-2e33-3860-a8d6-4f95d356d59b','1988-12-17',NULL,'38996992',NULL,'Impedit rerum voluptas ea dolor id consequatur.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,0,4,NULL,NULL,NULL,NULL,3),(19,'Open-source bandwidth-monitored capacity','1449709770',4,'37fd77d0-d26c-3063-8922-e8f7176cd1b2','2012-12-12',NULL,'39149042',NULL,'Et inventore corrupti non dicta.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,1,2,NULL,NULL,NULL,NULL,2),(20,'Polarised didactic data-warehouse','48615263',1,'e67c3282-f525-3ddd-a264-4122a290c88b','1974-07-15',NULL,'21663155',NULL,'Est et est modi ut.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,1,3,NULL,NULL,NULL,NULL,3),(21,'Exclusive grid-enabled projection','878641912',1,'ef92eb6e-43b7-32a4-8fdb-2ef94c378371','2002-04-30',NULL,'21516797',NULL,'Quam illum sunt rem neque nam vel ratione.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,1,1,NULL,NULL,NULL,NULL,2),(22,'Right-sized eco-centric forecast','571667321',4,'3910e3d7-3c50-3fe7-bb41-675257c4540b','1970-09-22',NULL,'45627107',NULL,'Ut autem et velit ea vitae voluptatem.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,1,4,NULL,NULL,NULL,NULL,4),(23,'Managed optimizing info-mediaries','284186616',3,'7bbb0f48-e09f-341d-8c4e-745fc7fc40ab','1990-07-14',NULL,'43121262',NULL,'Perferendis dolor nihil quidem suscipit quam aut repudiandae est.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,1,2,NULL,NULL,NULL,NULL,2),(24,'Polarised reciprocal interface','83082897',4,'b05a187b-f59a-3c13-b212-31e8f0c2c11b','1971-08-29',NULL,'35002634',NULL,'Sunt error ducimus enim sunt et.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,NULL,1),(25,'Organic impactful model','1360793242',5,'2f03fe66-48bd-3f7e-b562-7857d61d7b02','1997-07-07',NULL,'6053575',NULL,'Architecto fugiat et porro.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,NULL,2),(26,'Compatible optimal groupware','488026256',4,'170e05ab-0a46-338f-9777-5f869ee3e73e','1992-07-27',NULL,'46455897',NULL,'At magni iusto quidem qui laudantium ducimus quos laudantium.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,1,5,NULL,NULL,NULL,NULL,1),(27,'Exclusive fault-tolerant collaboration','283373007',1,'54220f06-df0a-39b9-9cce-7d2618b52027','1978-12-11',NULL,'17354785',NULL,'Atque praesentium aut voluptatem.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,0,1,NULL,NULL,NULL,NULL,4),(28,'Grass-roots human-resource monitoring','1358583588',2,'14a2bb09-5c86-3580-a9f7-f957c029cdd4','2013-09-23',NULL,'41513341',NULL,'Et architecto qui a aperiam ipsam aspernatur neque aut.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,0,1,NULL,NULL,NULL,NULL,4),(29,'Adaptive mobile methodology','1078959508',5,'deb6de18-d353-3028-abb5-b85c53e572b3','1986-10-11',NULL,'30129295',NULL,'Consequatur iste temporibus possimus distinctio nobis tempore.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,0,1,NULL,NULL,NULL,NULL,1),(30,'Multi-layered asynchronous info-mediaries','500823859',4,'b9e52b26-6654-3ec5-8114-052da7e81e68','2003-12-28',NULL,'31894531',NULL,'Quisquam aut voluptate aliquam aut vel voluptate odit blanditiis.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,1,1,NULL,NULL,NULL,NULL,4),(31,'Reverse-engineered disintermediate artificialintelligence','127910469',4,'b803e358-430d-383d-869c-df491742aeab','1985-05-02',NULL,'9595266',NULL,'Consectetur consequatur modi dolor quibusdam dolor.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,0,4,NULL,NULL,NULL,NULL,3),(32,'Reactive intermediate database','1427050701',5,'b15aa82f-4c3c-3c46-8ac0-bbb8d93c3d8d','2010-04-13',NULL,'33941269',NULL,'Explicabo nihil dolorum sed numquam cupiditate.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,0,3,NULL,NULL,NULL,NULL,4),(33,'Stand-alone intangible benchmark','1002621001',2,'34357519-e421-397b-9f29-fed75f4d257c','1983-10-27',NULL,'5195666',NULL,'Temporibus neque non enim.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,1,1,NULL,NULL,NULL,NULL,1),(34,'Multi-channelled responsive paradigm','179562199',4,'146dc1b3-4ec5-33a1-8784-6e0e4c2374e4','1990-06-17',NULL,'3817771',NULL,'Aspernatur laudantium ullam quaerat nihil aut expedita quia.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,1,1,NULL,NULL,NULL,NULL,3),(35,'Multi-lateral heuristic leverage','1266601024',2,'55ccf3ae-fe75-3488-a92c-68f488217915','1976-11-05',NULL,'26941625',NULL,'Omnis culpa ipsam est quam eius ea.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,1,3,NULL,NULL,NULL,NULL,3),(36,'Up-sized explicit info-mediaries','985581598',3,'4d5fcd70-12ae-3b50-b71d-679d3d596b6e','2005-06-26',NULL,'46999637',NULL,'Dolor dolore sed enim nobis pariatur quia.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,0,3,NULL,NULL,NULL,NULL,2),(37,'Innovative bottom-line internetsolution','838243568',1,'5098fe99-190c-38ea-b622-26bb229fb529','2009-07-14',NULL,'43758387',NULL,'Et ratione culpa corporis.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,0,5,NULL,NULL,NULL,NULL,2),(38,'Adaptive radical localareanetwork','376999050',5,'66268f06-09ea-368f-9fcf-046e35a685f7','1978-06-01',NULL,'37849620',NULL,'Veniam qui maxime cupiditate omnis.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,0,1,NULL,NULL,NULL,NULL,4),(39,'Polarised user-facing success','82661970',4,'a1de80a1-26da-3990-9157-eb66282dec40','2007-04-29',NULL,'2358580',NULL,'Quam sunt aliquid et quisquam.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,0,2,NULL,NULL,NULL,NULL,1),(40,'Configurable needs-based access','1230479844',4,'d70d75e7-fa62-331e-9b04-b465aa447c02','1994-05-18',NULL,'18594912',NULL,'Dolorem nam repellendus sed et aperiam.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,0,4,NULL,NULL,NULL,NULL,4),(41,'Front-line multimedia knowledgeuser','741179654',2,'4b5012b4-94cd-39a1-8e21-b5cb26963c8d','2013-05-23',NULL,'41270267',NULL,'Fuga sit ut natus vel atque accusantium.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,1,3,NULL,NULL,NULL,NULL,4),(42,'Business-focused exuding info-mediaries','108582572',1,'86b87c96-fe5a-3dee-aa03-161611dbffdb','1998-06-08',NULL,'49700731',NULL,'Sequi et consequatur facere.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,1,2,NULL,NULL,NULL,NULL,3),(43,'Ergonomic explicit initiative','700392813',3,'593eed07-359c-38ef-adec-9029e6277e2a','1972-10-16',NULL,'10456327',NULL,'Libero quos ipsam quis exercitationem id in eveniet.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,0,2,NULL,NULL,NULL,NULL,1),(44,'Total multimedia migration','908962454',2,'b880a4bf-5d51-331b-af07-44949d4d8f01','1976-04-26',NULL,'39976319',NULL,'Odit ut quos accusantium ea tempore et dignissimos soluta.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,1,1,NULL,NULL,NULL,NULL,1),(45,'Digitized methodical middleware','871620142',4,'93dcd8d1-e5dd-3fc9-834b-a718039f88df','1992-01-09',NULL,'48614317',NULL,'Earum nesciunt similique id possimus modi blanditiis blanditiis voluptatem.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,1,4,NULL,NULL,NULL,NULL,1),(46,'Devolved holistic database','714126156',3,'d354e507-609b-3b35-9926-7dd3a02443d3','1977-08-19',NULL,'35269691',NULL,'Praesentium aut nobis in libero tempora impedit quo.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,1,3,NULL,NULL,NULL,NULL,3),(47,'Proactive mobile opensystem','951658867',1,'a50527d7-6446-3e05-be4a-a3a3a372828e','1990-02-25',NULL,'31860138',NULL,'Consequatur quam sed odit repellat quo minima velit.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,1,5,NULL,NULL,NULL,NULL,4),(48,'Automated upward-trending data-warehouse','1404644407',5,'b48f599e-fe8a-3014-8255-fed3a2f78890','1977-01-20',NULL,'16120858',NULL,'Neque ipsum et facilis exercitationem pariatur.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,0,2,NULL,NULL,NULL,NULL,1),(49,'Triple-buffered dynamic leverage','680909548',5,'335597d2-5a98-37a7-822a-ef0569a5ab95','2005-03-30',NULL,'26186255',NULL,'Ad dolorem voluptatibus assumenda porro veniam velit.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,1,1,NULL,NULL,NULL,NULL,4),(50,'Realigned interactive solution','1130331690',3,'b7269c22-c407-3068-b56e-b5b7dd95058a','1972-01-18',NULL,'37522795',NULL,'Sequi delectus maxime officia veniam voluptate rem assumenda.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,0,1,NULL,NULL,NULL,NULL,1),(51,'Enterprise-wide didactic moratorium','220321065',5,'ab296e0f-feb8-3d99-995e-46656abed8a7','1990-12-21',NULL,'19764329',NULL,'Doloribus nobis labore numquam dolores voluptatum accusantium.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,0,2,NULL,NULL,NULL,NULL,1),(52,'Synchronised mobile securedline','252957019',4,'326b1528-d097-39fb-aca3-34bc9358ad22','2008-05-04',NULL,'36459823',NULL,'Illum dolorem dolore totam aut inventore et eos.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,2,0,4,NULL,NULL,NULL,NULL,1),(53,'Phased high-level groupware','1460225704',5,'456aa264-6ab8-3fea-a380-84a1c0d2eb5c','1987-10-30',NULL,'31759001',NULL,'Porro nihil magni aut sint vel.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,0,1,NULL,NULL,NULL,NULL,1),(54,'Proactive reciprocal alliance','164799827',1,'99bec0dd-6911-3bb7-8e3b-28b7013f1aa9','2003-09-30',NULL,'5320150',NULL,'Consequatur quaerat id veritatis velit ut deserunt enim.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,NULL,3),(55,'Customer-focused mobile processimprovement','842187902',4,'622648bc-4337-3782-a0e7-359b732c6c2a','2014-02-20',NULL,'41277223',NULL,'Incidunt earum est quae et.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,1,1,2,NULL,NULL,NULL,NULL,4),(56,'Switchable assymetric workforce','1132463686',4,'b246d72c-d613-34c3-aa67-eaa3fa4c718c','2007-06-02',NULL,'40685216',NULL,'Ipsa ab itaque magnam sed aut consequuntur error.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,0,4,NULL,NULL,NULL,NULL,1),(57,'Robust secondary emulation','741678897',2,'e39094df-9355-35b3-a423-638d4b5374ec','2002-12-14',NULL,'40667019',NULL,'Eos vel distinctio tenetur necessitatibus ullam eaque at.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,5,0,5,NULL,NULL,NULL,NULL,4),(58,'Business-focused directional approach','245586010',3,'4f871145-518c-3058-ab28-a0a9645a999f','2013-03-12',NULL,'21388822',NULL,'Sit amet in similique sit et.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,1,4,NULL,NULL,NULL,NULL,2),(59,'Multi-tiered attitude-oriented circuit','204819247',3,'f11378bf-49b5-3ee1-b7f6-7347077e3407','1984-06-14',NULL,'45678120',NULL,'Cupiditate ex accusantium doloremque eum.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,4,1,3,NULL,NULL,NULL,NULL,4),(60,'Networked upward-trending methodology','333703861',4,'672ca486-160b-3cc1-b932-7a5c7ac65453','2007-08-23',NULL,'46145283',NULL,'Mollitia voluptatem ipsam veritatis non est in.',NULL,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',1,NULL,1,NULL,NULL,NULL,3,1,3,NULL,NULL,NULL,NULL,1),(61,'Ameliorated homogeneous systemengine','32734771',4,'5684a908-ab00-3208-91ce-338df98d3a0e','2001-02-23',NULL,'9828673',NULL,'Quasi quia veritatis omnis ut minima nam dolorem libero.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,5,1,5,NULL,NULL,NULL,NULL,4),(62,'Reverse-engineered reciprocal analyzer','1140960148',4,'d882b242-b85c-3c25-9958-5fc154043cc5','1990-10-06',NULL,'6516317',NULL,'Dolorum molestiae quae aut deleniti ab qui reprehenderit libero.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,1,5,NULL,NULL,NULL,NULL,4),(63,'Monitored client-server architecture','67900820',2,'ba0a1d56-1394-3d7a-bb8b-877f978a72b4','1979-04-14',NULL,'4555334',NULL,'Nihil praesentium commodi dolore nemo.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,5,1,4,NULL,NULL,NULL,NULL,1),(64,'Operative multi-state GraphicalUserInterface','922778850',4,'2a91a2d6-103c-3121-b0b1-57c58404e614','1971-01-06',NULL,'27487453',NULL,'Qui rerum odio dignissimos voluptas qui.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,5,0,3,NULL,NULL,NULL,NULL,1),(65,'Integrated value-added collaboration','402777469',4,'bdf57636-fb88-388a-b601-e20fb01877c4','1980-03-03',NULL,'42870244',NULL,'Corporis optio blanditiis nam voluptatibus.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,4,1,4,NULL,NULL,NULL,NULL,1),(66,'Cross-group web-enabled info-mediaries','148247000',5,'370fc561-99a6-3dfb-87d0-7a8705887f85','2003-08-18',NULL,'1357945',NULL,'Ipsum ab quae omnis aut ad.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,3,0,2,NULL,NULL,NULL,NULL,2),(67,'Versatile interactive matrix','734828974',4,'e488a1a3-c807-310e-85b0-d75f87ea2ceb','1971-05-11',NULL,'17363905',NULL,'Neque molestiae id voluptates quo assumenda rerum voluptas voluptatum.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,5,0,2,NULL,NULL,NULL,NULL,4),(68,'Cloned discrete toolset','1393028026',2,'42cdb987-2dfc-308a-89de-bac00786d055','1973-08-19',NULL,'47005444',NULL,'Expedita est porro eveniet incidunt.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,5,1,1,NULL,NULL,NULL,NULL,4),(69,'Re-engineered uniform projection','479009911',5,'45e8a143-f6ad-3003-85c8-26e4e5c45b02','2001-08-28',NULL,'29723297',NULL,'Reiciendis et rerum fuga impedit.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,5,0,4,NULL,NULL,NULL,NULL,4),(70,'Universal didactic hardware','1207336596',2,'507c36a4-2a3a-382d-8f9f-99996e76cfb6','2013-09-24',NULL,'49138793',NULL,'Vitae ipsam autem molestias eos quos necessitatibus.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,1,3,NULL,NULL,NULL,NULL,2),(71,'Balanced assymetric GraphicalUserInterface','1247913785',2,'bc05fdfc-f519-374c-8049-badb52f69e6d','1996-01-20',NULL,'2827249',NULL,'Nam deserunt ullam quo beatae.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,1,2,NULL,NULL,NULL,NULL,4),(72,'Expanded 4thgeneration algorithm','1335669067',2,'44df7155-0921-3e29-9c5a-cefee90f4324','1970-04-20',NULL,'28076837',NULL,'Et accusantium molestias sequi ipsa doloremque.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,4,1,4,NULL,NULL,NULL,NULL,4),(73,'Function-based maximized parallelism','1444938202',3,'83db23c4-72f1-3d6c-a8f6-bfb5b459bdf2','1982-10-22',NULL,'46097977',NULL,'Quisquam praesentium ipsam debitis aut nobis quasi.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,0,4,NULL,NULL,NULL,NULL,2),(74,'Customizable mobile access','293016748',4,'c8abc7f9-d06e-3974-9fde-0df0411a044b','1993-02-09',NULL,'25470347',NULL,'Minus consequatur numquam eos et laudantium debitis corrupti.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,1,0,3,NULL,NULL,NULL,NULL,3),(75,'Future-proofed foreground forecast','349758044',1,'9c55dfa4-3c20-3ed5-a5cd-4dba4c9bdbf2','1982-03-08',NULL,'18219755',NULL,'Harum exercitationem nihil est porro magni in sint.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,NULL,4),(76,'Stand-alone dedicated algorithm','263812040',1,'041dbed7-dae5-32ca-89ee-ea2699efc988','2014-04-25',NULL,'25260035',NULL,'Aut et maiores tenetur consequatur et.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,1,1,5,NULL,NULL,NULL,NULL,1),(77,'Robust analyzing function','383948027',4,'62d427a4-572d-395a-a4a3-062bdff4c5cc','1981-01-15',NULL,'48945490',NULL,'Sapiente dicta saepe accusamus et dolores.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,0,4,NULL,NULL,NULL,NULL,2),(78,'Virtual neutral functionalities','477380190',2,'77735935-e7cc-32aa-8e80-c9ab3bbbd62c','2016-02-05',NULL,'25244642',NULL,'Et nam sed et corrupti esse et.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,3,0,3,NULL,NULL,NULL,NULL,2),(79,'Grass-roots responsive GraphicInterface','1010848030',4,'e969f95f-7656-39fc-b392-25fbbed2ad91','1991-03-23',NULL,'19825588',NULL,'Iure qui officiis rerum illum aut ut.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,5,1,3,NULL,NULL,NULL,NULL,4),(80,'Realigned composite adapter','899386095',5,'dd62fd8d-a4cd-3c93-a138-50b37f17ad7d','1974-03-11',NULL,'12030390',NULL,'Doloremque in similique iure quasi perferendis id.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,0,4,NULL,NULL,NULL,NULL,4),(81,'Optimized bifurcated intranet','838575063',2,'f0364606-5bc5-3821-8bd7-6bf1e90e7f11','1991-12-07',NULL,'15632187',NULL,'Cupiditate expedita et minus aut culpa provident quae.',NULL,1,'2016-11-20 23:07:29','2016-11-21 00:33:30',1,'2016-11-21 00:33:30',1,NULL,NULL,NULL,3,0,4,NULL,NULL,NULL,NULL,4),(82,'Ameliorated user-facing monitoring','326235593',5,'d1d95514-6f07-3fd4-b12e-2fccfc2ddd27','1999-05-31',NULL,'1149074',NULL,'Quos modi aspernatur a et aut aut tenetur.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,0,2,NULL,NULL,NULL,NULL,4),(83,'Business-focused high-level interface','1140579465',5,'46bc076b-720c-33fa-ae4f-33a3a66451f7','2003-12-09',NULL,'8509936',NULL,'Sint inventore nisi repellendus ab debitis.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,5,0,4,NULL,NULL,NULL,NULL,3),(84,'Seamless asynchronous info-mediaries','1336928942',4,'9b5fbd7c-b786-332e-bfc8-9cca434ed204','1981-08-19',NULL,'41932039',NULL,'Temporibus exercitationem ducimus libero amet.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,1,1,NULL,NULL,NULL,NULL,1),(85,'Multi-layered dynamic parallelism','861858215',2,'9628e727-03c2-313f-bc2b-a1a5888f2f39','1995-06-20',NULL,'18992739',NULL,'Amet nemo aperiam et pariatur.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,5,1,5,NULL,NULL,NULL,NULL,1),(86,'Programmable tertiary matrix','955798318',4,'fc61789d-a6e8-3566-91e1-2c2112467a0a','1972-07-22',NULL,'15909141',NULL,'Assumenda doloremque explicabo perspiciatis vel et dolorem molestiae.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,3,0,5,NULL,NULL,NULL,NULL,1),(87,'Right-sized contextually-based archive','1329991897',1,'4b44a0b1-3ecb-30b7-b58f-d4849447b39a','1995-05-27',NULL,'15640006',NULL,'Sit pariatur in non impedit sed sed magni.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,3,1,1,NULL,NULL,NULL,NULL,4),(88,'Automated user-facing initiative','66332732',1,'59027125-0623-3037-bb4a-0d0114e0db5f','1992-09-05',NULL,'9927501',NULL,'Eum sed velit minus doloribus ad omnis cum.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,1,0,4,NULL,NULL,NULL,NULL,1),(89,'Optimized discrete moderator','242159572',3,'181a0950-006d-3fdd-936d-81355fd6df88','2005-09-18',NULL,'38282301',NULL,'Omnis eum quae animi eius.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,3,0,2,NULL,NULL,NULL,NULL,3),(90,'Persistent cohesive middleware','393498501',3,'a3d399cb-f25a-383e-af65-54a2e974a56f','1970-02-21',NULL,'42991820',NULL,'Excepturi nulla voluptatem voluptatem ea.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,1,0,1,NULL,NULL,NULL,NULL,3),(91,'Multi-channelled grid-enabled customerloyalty','814134806',1,'8155b403-8383-31e9-a521-4a7a2aea61ca','1978-03-03',NULL,'31285966',NULL,'Perspiciatis aspernatur dolor vel sit.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,4,0,2,NULL,NULL,NULL,NULL,4),(92,'Integrated static interface','215458633',4,'119654ac-8269-3714-bdc2-fc25308c96fc','1972-04-07',NULL,'6193991',NULL,'A facere quo at doloremque ut reprehenderit.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,1,5,NULL,NULL,NULL,NULL,3),(93,'Up-sized 24hour GraphicalUserInterface','321345315',4,'5a892eb9-8c99-3a71-90af-e6e80a5b9273','1971-03-19',NULL,'38803546',NULL,'Atque blanditiis tenetur cumque ipsum inventore alias.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,1,3,NULL,NULL,NULL,NULL,1),(94,'Facetoface demand-driven matrix','693214522',3,'b82ce41d-cff1-3b4c-9f74-554058bf9669','1982-08-26',NULL,'13705892',NULL,'Reiciendis et molestias id quis eveniet.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,2,0,5,NULL,NULL,NULL,NULL,1),(95,'Front-line heuristic middleware','1067734512',5,'4205ffc6-210a-3ef7-84b3-76df4f1316ce','1997-03-08',NULL,'27900091',NULL,'Ut earum consequatur dolor non possimus omnis.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,3,0,4,NULL,NULL,NULL,NULL,1),(96,'Down-sized zerodefect utilisation','1366417144',3,'9f4b8786-7e45-3683-a4f5-2fa4f260609c','1983-11-09',NULL,'37309051',NULL,'Cumque consequatur delectus modi aliquid nulla.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,4,0,5,NULL,NULL,NULL,NULL,3),(97,'Pre-emptive asynchronous benchmark','366257155',4,'603e9346-3120-3ff7-9966-829a61f29d32','2015-09-06',NULL,'45384019',NULL,'Dolores assumenda delectus quae explicabo eum distinctio eaque.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,4,0,5,NULL,NULL,NULL,NULL,1),(98,'Networked secondary product','64846550',3,'97eb19e5-cc94-3946-9472-65422c7ffe00','1983-09-28',NULL,'17430473',NULL,'Officiis aut molestiae necessitatibus vitae.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,3,0,2,NULL,NULL,NULL,NULL,1),(99,'Business-focused 24hour leverage','936840003',5,'395e8f2c-799f-3310-a6c9-b328498f6a5b','1976-02-19',NULL,'46175843',NULL,'Iure veniam animi mollitia molestias dolores hic dolorem.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,1,1,2,NULL,NULL,NULL,NULL,2),(100,'Decentralized homogeneous groupware','285321693',2,'eabc9e1e-4a5d-3d97-88db-98112689290f','1979-12-21',NULL,'39805401',NULL,'Earum molestiae autem aspernatur quis.',NULL,1,'2016-11-20 23:07:29','2016-11-20 23:07:29',1,NULL,1,NULL,NULL,NULL,3,1,5,NULL,NULL,NULL,NULL,2),(101,'TestModel','230-name-21 2',2,'350335','2016-01-01',25.00,'12345',20,'lorem ipsum blah blah',NULL,1,'2016-11-21 00:33:30','2016-11-21 00:33:30',1,NULL,6,0,15,0,2,1,5,NULL,NULL,'2016-11-20 18:33:30',NULL,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Soluta consequatur.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'asset',0),(2,'Saepe repellendus.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'asset',0),(3,'Hic dolores minus.','2016-11-20 23:07:29','2016-11-21 00:33:32',NULL,'2016-11-21 00:33:32',NULL,0,0,'asset',0),(4,'Qui necessitatibus.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'asset',0),(5,'Beatae accusamus.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'asset',0),(6,'Error cum omnis.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'asset',0),(7,'Ipsam repellat id.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'asset',0),(8,'Asperiores nesciunt.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'asset',0),(9,'Quia sit veniam.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'asset',0),(10,'Quaerat repellendus.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'asset',0),(11,'Atque fuga esse.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'accessory',0),(12,'Et illo error porro.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'accessory',0),(13,'Soluta ipsam ea.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'accessory',0),(14,'Repellat mollitia.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'accessory',0),(15,'Et reprehenderit.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'accessory',0),(16,'Quia unde qui.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'consumable',0),(17,'Sunt quo voluptatem.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'consumable',0),(18,'Voluptatum dolor.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'consumable',0),(19,'Et sed doloremque.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'consumable',0),(20,'Pariatur qui amet.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'consumable',0),(21,'Deleniti occaecati.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'component',0),(22,'Tenetur aut dolores.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'component',0),(23,'Quae a ullam maxime.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'component',0),(24,'Quo harum enim quo.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'component',0),(25,'Nesciunt molestias.','2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,0,0,'component',0),(26,'TestModel','2016-11-21 00:33:32','2016-11-21 00:33:32',1,NULL,'lorem ipsum blah blah',0,1,'accessory',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Brekke-Heathcote','2016-11-20 23:07:28','2016-11-20 23:07:28'),(2,'Watsica Ltd','2016-11-20 23:07:28','2016-11-20 23:07:28'),(3,'Armstrong Group','2016-11-20 23:07:28','2016-11-20 23:07:28'),(4,'Willms, Brakus and Shields','2016-11-20 23:07:28','2016-11-20 23:07:28'),(5,'TestCompany','2016-11-21 00:33:34','2016-11-21 00:33:34');
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
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
  `serial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `components`
--

LOCK TABLES `components` WRITE;
/*!40000 ALTER TABLE `components` DISABLE KEYS */;
INSERT INTO `components` VALUES (1,'Non rerum.',21,NULL,1,NULL,9,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,2,NULL),(2,'Ut odio nesciunt.',23,NULL,4,NULL,8,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,1,NULL),(3,'Quia eaque deleniti.',22,NULL,3,NULL,4,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-21 00:33:37','2016-11-21 00:33:37',2,NULL),(4,'Et et voluptates.',21,NULL,4,NULL,4,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,2,NULL),(5,'In aliquid soluta.',25,NULL,2,NULL,3,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,1,NULL),(6,'Quod expedita.',23,NULL,2,NULL,5,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,2,NULL),(7,'Delectus rerum.',21,NULL,2,NULL,10,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,1,NULL),(8,'Et et molestiae.',21,NULL,1,NULL,3,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,1,NULL),(9,'Nisi praesentium.',22,NULL,1,NULL,5,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,1,NULL),(10,'Vitae vitae maxime.',22,NULL,1,NULL,8,NULL,NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,1,NULL),(11,'TestComponent',25,2,2,1,12,'12345','2016-01-01',25.00,'2016-11-21 00:33:36','2016-11-21 00:33:36',NULL,6,'3062436032621632326-325632523');
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
  `purchase_cost` decimal(20,2) DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
  `model_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `item_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumables`
--

LOCK TABLES `consumables` WRITE;
/*!40000 ALTER TABLE `consumables` DISABLE KEYS */;
INSERT INTO `consumables` VALUES (1,'Corporis voluptate.',17,NULL,NULL,5,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,2,2,NULL,NULL,NULL),(2,'Quis dolores sunt.',19,NULL,NULL,10,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL),(3,'Perferendis.',16,NULL,NULL,8,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,4,2,NULL,NULL,NULL),(4,'Maiores esse magni.',20,NULL,NULL,10,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,2,2,NULL,NULL,NULL),(5,'Vitae eum deserunt.',19,NULL,NULL,8,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,2,2,NULL,NULL,NULL),(6,'Nam et ab officiis.',17,NULL,NULL,9,0,'2016-11-20 23:07:29','2016-11-21 00:33:39','2016-11-21 00:33:39',NULL,NULL,NULL,3,2,NULL,NULL,NULL),(7,'Voluptates officia.',19,NULL,NULL,9,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,3,1,NULL,NULL,NULL),(8,'Autem reprehenderit.',19,NULL,NULL,7,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,3,1,NULL,NULL,NULL),(9,'Omnis fugit sed.',17,NULL,NULL,5,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,2,1,NULL,NULL,NULL),(10,'Quia qui.',17,NULL,NULL,10,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,3,1,NULL,NULL,NULL),(11,'Officiis impedit.',19,NULL,NULL,8,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,2,2,NULL,NULL,NULL),(12,'Sunt harum dicta.',18,NULL,NULL,7,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,2,1,NULL,NULL,NULL),(13,'Sed accusamus porro.',20,NULL,NULL,7,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,4,1,NULL,NULL,NULL),(14,'Deleniti magnam.',16,NULL,NULL,5,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,3,1,NULL,NULL,NULL),(15,'Fugiat.',19,NULL,NULL,6,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,2,1,NULL,NULL,NULL),(16,'Illum vel enim.',17,NULL,NULL,5,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,4,1,NULL,NULL,NULL),(17,'Debitis quae.',16,NULL,NULL,5,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,2,2,NULL,NULL,NULL),(18,'Nulla inventore.',20,NULL,NULL,6,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL),(19,'Quaerat voluptatem.',18,NULL,NULL,8,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,3,1,NULL,NULL,NULL),(20,'Dolores.',17,NULL,NULL,6,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,1,1,NULL,NULL,NULL),(21,'Modi maiores.',18,NULL,NULL,8,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,4,1,NULL,NULL,NULL),(22,'Provident eos.',20,NULL,NULL,10,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,4,2,NULL,NULL,NULL),(23,'Error molestiae.',19,NULL,NULL,9,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,1,2,NULL,NULL,NULL),(24,'Dolor quos est rem.',18,NULL,NULL,7,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,2,1,NULL,NULL,NULL),(25,'Maiores facilis.',16,NULL,NULL,10,0,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,3,2,NULL,NULL,NULL),(26,'TestConsumable',21,0,1,12,0,'2016-11-21 00:33:39','2016-11-21 00:33:39',NULL,'2016-01-01',25.00,'12345',2,6,'032-356',0,'32503');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields`
--

LOCK TABLES `custom_fields` WRITE;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `depreciations`
--

LOCK TABLES `depreciations` WRITE;
/*!40000 ALTER TABLE `depreciations` DISABLE KEYS */;
INSERT INTO `depreciations` VALUES (2,'TestDepreciation',15,'2016-11-21 00:33:41','2016-11-21 00:33:41',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (2,'TestGroup','{\"superuser\":\"0\",\"admin\":\"0\",\"reports.view\":\"0\",\"assets.view\":\"0\",\"assets.create\":\"0\",\"assets.edit\":\"0\",\"assets.delete\":\"0\",\"assets.checkin\":\"0\",\"assets.checkout\":\"0\",\"assets.view.requestable\":\"0\",\"accessories.view\":\"0\",\"accessories.create\":\"0\",\"accessories.edit\":\"0\",\"accessories.delete\":\"0\",\"accessories.checkout\":\"0\",\"accessories.checkin\":\"0\",\"consumables.view\":\"0\",\"consumables.create\":\"0\",\"consumables.edit\":\"0\",\"consumables.delete\":\"0\",\"consumables.checkout\":\"0\",\"licenses.view\":\"0\",\"licenses.create\":\"0\",\"licenses.edit\":\"0\",\"licenses.delete\":\"0\",\"licenses.checkout\":\"0\",\"licenses.keys\":\"0\",\"components.view\":\"0\",\"components.create\":\"0\",\"components.edit\":\"0\",\"components.delete\":\"0\",\"components.checkout\":\"0\",\"components.checkin\":\"0\",\"users.view\":\"0\",\"users.create\":\"0\",\"users.edit\":\"0\",\"users.delete\":\"0\",\"self.two_factor\":\"0\"}','2016-11-21 00:33:44','2016-11-21 00:33:44');
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `license_seats`
--

LOCK TABLES `license_seats` WRITE;
/*!40000 ALTER TABLE `license_seats` DISABLE KEYS */;
INSERT INTO `license_seats` VALUES (1,1,NULL,'Enim ratione repudiandae voluptas inventore harum nihil non.',1,'1985-04-22 07:56:43','2016-11-21 00:33:47','2016-11-21 00:33:47',NULL),(2,5,NULL,'Quidem nesciunt laudantium reprehenderit quia nemo non enim saepe.',1,'2008-11-13 14:47:37','2002-06-10 20:39:02',NULL,NULL),(3,10,NULL,'Ipsa labore repellendus magni rem.',1,'1997-03-02 08:23:45','1970-03-28 10:33:13',NULL,NULL),(4,3,NULL,'Impedit corporis sapiente numquam tenetur explicabo dolores et ipsam.',1,'1997-07-18 14:12:28','2012-11-20 06:52:26',NULL,NULL),(5,3,NULL,'Autem explicabo consequatur harum consequatur repellat voluptate.',1,'1992-02-25 09:18:12','2013-11-25 04:08:47',NULL,NULL),(6,5,NULL,'Repellendus vero voluptatem voluptate sed ipsam.',1,'1970-03-25 07:11:55','1994-07-21 11:28:55',NULL,NULL),(7,10,NULL,'Tenetur sequi blanditiis similique quaerat explicabo quibusdam excepturi.',1,'1971-07-26 14:28:52','1995-12-16 02:16:50',NULL,NULL),(8,3,NULL,'Nostrum veniam nulla quo consequatur consequatur et omnis eum.',1,'1972-09-10 03:47:34','1979-11-30 18:06:57',NULL,NULL),(9,5,NULL,'Sint nihil omnis quod accusamus.',1,'1983-04-08 19:17:09','2008-06-22 21:35:40',NULL,NULL),(10,7,NULL,'Ea et placeat quod blanditiis sed.',1,'2002-04-06 11:19:24','1996-02-14 01:10:39',NULL,NULL),(11,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(12,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(13,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(14,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(15,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(16,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(17,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(18,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(19,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(20,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(21,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL),(22,11,NULL,NULL,1,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,NULL);
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
  `purchase_cost` decimal(20,2) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licenses`
--

LOCK TABLES `licenses` WRITE;
/*!40000 ALTER TABLE `licenses` DISABLE KEYS */;
INSERT INTO `licenses` VALUES (1,'Implemented composite firmware','399629fa-69f5-3eaa-a0c0-8a53977030e3','2002-08-18',2744038.81,NULL,8,'Aut ea corrupti eligendi.',NULL,NULL,'2016-11-20 23:07:29','2016-11-21 00:33:47','2016-11-21 00:33:47','Katharina Kulas','noelia.hermann@example.com',NULL,NULL,NULL,NULL,NULL,NULL,1,3,NULL),(2,'Optimized systemic intranet','89c6abac-19d9-3b54-ae5e-66f2556f0ec3','2012-08-25',269.24,NULL,1,'Quam eos praesentium sed aut quisquam dignissimos.',NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,'Mrs. Anika Cruickshank','drake.block@example.net',NULL,NULL,NULL,NULL,NULL,NULL,1,4,NULL),(3,'Expanded client-server methodology','7ae03022-765d-3791-b96f-e7fe31491061','1994-02-28',213701.76,NULL,2,'Molestiae porro dolorem vero quisquam quos praesentium debitis.',NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,'Prof. Dock Schumm MD','roslyn.torp@example.org',NULL,NULL,NULL,NULL,NULL,NULL,1,2,NULL),(4,'Mandatory solution-oriented extranet','f3d92679-78db-38fa-aa9b-d93354e74d0c','1996-10-08',2725956.85,NULL,9,'Et et nesciunt quasi magnam dolorum sed.',NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,'Kendra Skiles','valerie62@example.org',NULL,NULL,NULL,NULL,NULL,NULL,1,4,NULL),(5,'Secured fault-tolerant architecture','d2fe95cd-38b2-3b85-9d9f-ad325288bb06','2010-08-24',5924561.63,NULL,5,'Repellat iste laudantium eum ullam quam.',NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,'Erica Kunde Jr.','genoveva16@example.org',NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL),(6,'Fundamental context-sensitive product','ac1d2639-e0a7-34e6-9141-a491f4081e06','1982-06-16',2173.49,NULL,7,'Ut non esse qui voluptas.',NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,'Maryam Sawayn','raymond35@example.org',NULL,NULL,NULL,NULL,NULL,NULL,1,2,NULL),(7,'Visionary attitude-oriented collaboration','da42bf65-2aeb-315a-a05a-92b0e4dea5f0','2005-06-03',0.00,NULL,9,'Velit consequuntur cum cumque maxime voluptas.',NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,'Ofelia Bogan MD','alessia.friesen@example.com',NULL,NULL,NULL,NULL,NULL,NULL,1,4,NULL),(8,'Visionary needs-based strategy','24c1090b-fda1-382b-bf30-97435c22c225','1980-05-16',394166.60,NULL,6,'Provident omnis incidunt non consequuntur molestiae et adipisci.',NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,'Emile Langosh DVM','ndietrich@example.org',NULL,NULL,NULL,NULL,NULL,NULL,1,4,NULL),(9,'Public-key responsive installation','7bc5a1fe-c90e-391a-bc71-194cdaa8bfbc','1994-01-07',674379.59,NULL,9,'Reiciendis dolor excepturi consequatur velit nobis magni.',NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,'Curt Gutmann','enienow@example.com',NULL,NULL,NULL,NULL,NULL,NULL,1,2,NULL),(10,'Cross-group asynchronous neural-net','1e8d0378-3fdb-3883-8bd2-a7dbf477d2dc','1986-12-28',178.51,NULL,7,'Sunt est ducimus tempora excepturi ut.',NULL,NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,'Brittany Mann','pouros.cristopher@example.net',NULL,NULL,NULL,NULL,NULL,NULL,1,2,NULL),(11,'Test Software','946346-436346-346436','2016-01-01',25.00,'12345',12,'lorem ipsum omicron delta phi',1,0,'2016-11-21 00:33:46','2016-11-21 00:33:46',NULL,'Marco Polo','g@m.com',NULL,4,'2018-01-01','234562','2020-01-01',1,1,4,1);
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
  `state` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'New Edd','Margieton','FL','UM','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL,NULL,NULL,NULL,NULL,'AUD'),(2,'Hesselside','Daletown','WA','AM','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL,NULL,NULL,NULL,NULL,'SCR'),(3,'South Cleoramouth','Gudrunville','MD','MS','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL,NULL,NULL,NULL,NULL,'TTD'),(4,'Breitenbergview','Rolfsonmouth','NH','DE','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL,NULL,NULL,NULL,NULL,'JOD'),(5,'Beahanmouth','Haylieland','IL','SO','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL,NULL,NULL,NULL,NULL,'ZWL'),(6,'Test Location','Sutherland','BV','AF','2016-11-21 00:33:49','2016-11-21 00:33:49',1,'046t46 South Street','Apt 356','30266','2016-11-21 00:33:49',3,'YEN');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manufacturers`
--

LOCK TABLES `manufacturers` WRITE;
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;
INSERT INTO `manufacturers` VALUES (1,'Schaden, Waters and Koelpin','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL),(2,'Harber Group','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL),(3,'Johnson, Skiles and Howell','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL),(4,'Krajcik, Gutmann and Walter','2016-11-20 23:07:30','2016-11-21 00:33:52',NULL,'2016-11-21 00:33:52'),(5,'Stark, Bradtke and Rohan','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL),(6,'Gulgowski, Renner and Lebsack','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL),(7,'Murazik-Lakin','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL),(8,'Fahey and Sons','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL),(9,'Leannon Ltd','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL),(10,'Romaguera-Heidenreich','2016-11-20 23:07:30','2016-11-20 23:07:30',NULL,NULL),(11,'Testufacturer','2016-11-21 00:33:52','2016-11-21 00:33:52',1,NULL);
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
INSERT INTO `migrations` VALUES ('2012_12_06_225921_migration_cartalyst_sentry_install_users',1),('2012_12_06_225929_migration_cartalyst_sentry_install_groups',1),('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot',1),('2012_12_06_225988_migration_cartalyst_sentry_install_throttle',1),('2013_03_23_193214_update_users_table',1),('2013_11_13_075318_create_models_table',1),('2013_11_13_075335_create_categories_table',1),('2013_11_13_075347_create_manufacturers_table',1),('2013_11_15_015858_add_user_id_to_categories',1),('2013_11_15_112701_add_user_id_to_manufacturers',1),('2013_11_15_190327_create_assets_table',1),('2013_11_15_190357_create_licenses_table',1),('2013_11_15_201848_add_license_name_to_licenses',1),('2013_11_16_040323_create_depreciations_table',1),('2013_11_16_042851_add_depreciation_id_to_models',1),('2013_11_16_084923_add_user_id_to_models',1),('2013_11_16_103258_create_locations_table',1),('2013_11_16_103336_add_location_id_to_assets',1),('2013_11_16_103407_add_checkedout_to_to_assets',1),('2013_11_16_103425_create_history_table',1),('2013_11_17_054359_drop_licenses_table',1),('2013_11_17_054526_add_physical_to_assets',1),('2013_11_17_055126_create_settings_table',1),('2013_11_17_062634_add_license_to_assets',1),('2013_11_18_134332_add_contacts_to_users',1),('2013_11_18_142847_add_info_to_locations',1),('2013_11_18_152942_remove_location_id_from_asset',1),('2013_11_18_164423_set_nullvalues_for_user',1),('2013_11_19_013337_create_asset_logs_table',1),('2013_11_19_061409_edit_added_on_asset_logs_table',1),('2013_11_19_062250_edit_location_id_asset_logs_table',1),('2013_11_20_055822_add_soft_delete_on_assets',1),('2013_11_20_121404_add_soft_delete_on_locations',1),('2013_11_20_123137_add_soft_delete_on_manufacturers',1),('2013_11_20_123725_add_soft_delete_on_categories',1),('2013_11_20_130248_create_status_labels',1),('2013_11_20_130830_add_status_id_on_assets_table',1),('2013_11_20_131544_add_status_type_on_status_labels',1),('2013_11_20_134103_add_archived_to_assets',1),('2013_11_21_002321_add_uploads_table',1),('2013_11_21_024531_remove_deployable_boolean_from_status_labels',1),('2013_11_22_075308_add_option_label_to_settings_table',1),('2013_11_22_213400_edits_to_settings_table',1),('2013_11_25_013244_create_licenses_table',1),('2013_11_25_031458_create_license_seats_table',1),('2013_11_25_032022_add_type_to_actionlog_table',1),('2013_11_25_033008_delete_bad_licenses_table',1),('2013_11_25_033131_create_new_licenses_table',1),('2013_11_25_033534_add_licensed_to_licenses_table',1),('2013_11_25_101308_add_warrantee_to_assets_table',1),('2013_11_25_104343_alter_warranty_column_on_assets',1),('2013_11_25_150450_drop_parent_from_categories',1),('2013_11_25_151920_add_depreciate_to_assets',1),('2013_11_25_152903_add_depreciate_to_licenses_table',1),('2013_11_26_211820_drop_license_from_assets_table',1),('2013_11_27_062510_add_note_to_asset_logs_table',1),('2013_12_01_113426_add_filename_to_asset_log',1),('2013_12_06_094618_add_nullable_to_licenses_table',1),('2013_12_10_084038_add_eol_on_models_table',1),('2013_12_12_055218_add_manager_to_users_table',1),('2014_01_28_031200_add_qr_code_to_settings_table',1),('2014_02_13_183016_add_qr_text_to_settings_table',1),('2014_05_24_093839_alter_default_license_depreciation_id',1),('2014_05_27_231658_alter_default_values_licenses',1),('2014_06_19_191508_add_asset_name_to_settings',1),('2014_06_20_004847_make_asset_log_checkedout_to_nullable',1),('2014_06_20_005050_make_asset_log_purchasedate_to_nullable',1),('2014_06_24_003011_add_suppliers',1),('2014_06_24_010742_add_supplier_id_to_asset',1),('2014_06_24_012839_add_zip_to_supplier',1),('2014_06_24_033908_add_url_to_supplier',1),('2014_07_08_054116_add_employee_id_to_users',1),('2014_07_09_134316_add_requestable_to_assets',1),('2014_07_17_085822_add_asset_to_software',1),('2014_07_17_161625_make_asset_id_in_logs_nullable',1),('2014_08_12_053504_alpha_0_4_2_release',1),('2014_08_17_083523_make_location_id_nullable',1),('2014_10_16_200626_add_rtd_location_to_assets',1),('2014_10_24_000417_alter_supplier_state_to_32',1),('2014_10_24_015641_add_display_checkout_date',1),('2014_10_28_222654_add_avatar_field_to_users_table',1),('2014_10_29_045924_add_image_field_to_models_table',1),('2014_11_01_214955_add_eol_display_to_settings',1),('2014_11_04_231416_update_group_field_for_reporting',1),('2014_11_05_212408_add_fields_to_licenses',1),('2014_11_07_021042_add_image_to_supplier',1),('2014_11_20_203007_add_username_to_user',1),('2014_11_20_223947_add_auto_to_settings',1),('2014_11_20_224421_add_prefix_to_settings',1),('2014_11_21_104401_change_licence_type',1),('2014_12_09_082500_add_fields_maintained_term_to_licenses',1),('2015_02_04_155757_increase_user_field_lengths',1),('2015_02_07_013537_add_soft_deleted_to_log',1),('2015_02_10_040958_fix_bad_assigned_to_ids',1),('2015_02_10_053310_migrate_data_to_new_statuses',1),('2015_02_11_044104_migrate_make_license_assigned_null',1),('2015_02_11_104406_migrate_create_requests_table',1),('2015_02_12_001312_add_mac_address_to_asset',1),('2015_02_12_024100_change_license_notes_type',1),('2015_02_17_231020_add_localonly_to_settings',1),('2015_02_19_222322_add_logo_and_colors_to_settings',1),('2015_02_24_072043_add_alerts_to_settings',1),('2015_02_25_022931_add_eula_fields',1),('2015_02_25_204513_add_accessories_table',1),('2015_02_26_091228_add_accessories_user_table',1),('2015_02_26_115128_add_deleted_at_models',1),('2015_02_26_233005_add_category_type',1),('2015_03_01_231912_update_accepted_at_to_acceptance_id',1),('2015_03_05_011929_add_qr_type_to_settings',1),('2015_03_18_055327_add_note_to_user',1),('2015_04_29_234704_add_slack_to_settings',1),('2015_05_04_085151_add_parent_id_to_locations_table',1),('2015_05_22_124421_add_reassignable_to_licenses',1),('2015_06_10_003314_fix_default_for_user_notes',1),('2015_06_10_003554_create_consumables',1),('2015_06_15_183253_move_email_to_username',1),('2015_06_23_070346_make_email_nullable',1),('2015_06_26_213716_create_asset_maintenances_table',1),('2015_07_04_212443_create_custom_fields_table',1),('2015_07_09_014359_add_currency_to_settings_and_locations',1),('2015_07_21_122022_add_expected_checkin_date_to_asset_logs',1),('2015_07_24_093845_add_checkin_email_to_category_table',1),('2015_07_25_055415_remove_email_unique_constraint',1),('2015_07_29_230054_add_thread_id_to_asset_logs_table',1),('2015_07_31_015430_add_accepted_to_assets',1),('2015_09_09_195301_add_custom_css_to_settings',1),('2015_09_21_235926_create_custom_field_custom_fieldset',1),('2015_09_22_000104_create_custom_fieldsets',1),('2015_09_22_003321_add_fieldset_id_to_assets',1),('2015_09_22_003413_migrate_mac_address',1),('2015_09_28_003314_fix_default_purchase_order',1),('2015_10_01_024551_add_accessory_consumable_price_info',1),('2015_10_12_192706_add_brand_to_settings',1),('2015_10_22_003314_fix_defaults_accessories',1),('2015_10_23_182625_add_checkout_time_and_expected_checkout_date_to_assets',1),('2015_11_05_061015_create_companies_table',1),('2015_11_05_061115_add_company_id_to_consumables_table',1),('2015_11_05_183749_image',1),('2015_11_06_092038_add_company_id_to_accessories_table',1),('2015_11_06_100045_add_company_id_to_users_table',1),('2015_11_06_134742_add_company_id_to_licenses_table',1),('2015_11_08_035832_add_company_id_to_assets_table',1),('2015_11_08_222305_add_ldap_fields_to_settings',1),('2015_11_15_151803_add_full_multiple_companies_support_to_settings_table',1),('2015_11_26_195528_import_ldap_settings',1),('2015_11_30_191504_remove_fk_company_id',1),('2015_12_21_193006_add_ldap_server_cert_ignore_to_settings_table',1),('2015_12_30_233509_add_timestamp_and_userId_to_custom_fields',1),('2015_12_30_233658_add_timestamp_and_userId_to_custom_fieldsets',1),('2016_01_28_041048_add_notes_to_models',1),('2016_02_19_070119_add_remember_token_to_users_table',1),('2016_02_19_073625_create_password_resets_table',1),('2016_03_02_193043_add_ldap_flag_to_users',1),('2016_03_02_220517_update_ldap_filter_to_longer_field',1),('2016_03_08_225351_create_components_table',1),('2016_03_09_024038_add_min_stock_to_tables',1),('2016_03_10_133849_add_locale_to_users',1),('2016_03_10_135519_add_locale_to_settings',1),('2016_03_11_185621_add_label_settings_to_settings',1),('2016_03_22_125911_fix_custom_fields_regexes',1),('2016_04_28_141554_add_show_to_users',1),('2016_05_16_164733_add_model_mfg_to_consumable',1),('2016_05_19_180351_add_alt_barcode_settings',1),('2016_05_19_191146_add_alter_interval',1),('2016_05_19_192226_add_inventory_threshold',1),('2016_05_20_024859_remove_option_keys_from_settings_table',1),('2016_05_20_143758_remove_option_value_from_settings_table',1),('2016_06_01_140218_add_email_domain_and_format_to_settings',1),('2016_06_22_160725_add_user_id_to_maintenances',1),('2016_07_13_150015_add_is_ad_to_settings',1),('2016_07_14_153609_add_ad_domain_to_settings',1),('2016_07_22_003348_fix_custom_fields_regex_stuff',1),('2016_07_22_054850_one_more_mac_addr_fix',1),('2016_07_22_143045_add_port_to_ldap_settings',1),('2016_07_22_153432_add_tls_to_ldap_settings',1),('2016_07_27_211034_add_zerofill_to_settings',1),('2016_08_02_124944_add_color_to_statuslabel',1),('2016_08_04_134500_add_disallow_ldap_pw_sync_to_settings',1),('2016_08_09_002225_add_manufacturer_to_licenses',1),('2016_08_12_121613_add_manufacturer_to_accessories_table',1),('2016_08_23_143353_add_new_fields_to_custom_fields',1),('2016_08_23_145619_add_show_in_nav_to_status_labels',1),('2016_08_30_084634_make_purchase_cost_nullable',1),('2016_09_01_141051_add_requestable_to_asset_model',1),('2016_09_02_001448_create_checkout_requests_table',1),('2016_09_04_180400_create_actionlog_table',1),('2016_09_04_182149_migrate_asset_log_to_action_log',1),('2016_09_19_235935_fix_fieldtype_for_target_type',1),('2016_09_23_140722_fix_modelno_in_consumables_to_string',1),('2016_09_28_231359_add_company_to_logs',1),('2016_10_14_130709_fix_order_number_to_varchar',1),('2016_10_19_145520_fix_order_number_in_components_to_string',1),('2016_10_27_151715_add_serial_to_components',1),('2016_10_27_213251_increase_serial_field_capacity',1),('2016_10_29_002724_enable_2fa_fields',1),('2016_10_29_082408_add_signature_to_acceptance',1),('2016_11_01_030818_fix_forgotten_filename_in_action_logs',1),('2016_10_16_015024_rename_modelno_to_model_number',2),('2016_10_16_015211_rename_consumable_modelno_to_model_number',2),('2016_10_16_143235_rename_model_note_to_notes',2),('2016_10_16_165052_rename_component_total_qty_to_qty',2),('2016_11_13_020954_rename_component_serial_number_to_serial',2),('2016_11_16_172119_increase_purchase_cost_size',3),('2016_11_17_161317_longer_state_field_in_location',3),('2016_11_17_193706_add_model_number_to_accessories',3);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
INSERT INTO `models` VALUES (1,'Organized zerotolerance strategy','41955019',3,1,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,1,NULL,0,NULL,NULL,NULL,0),(2,'Operative responsive focusgroup','36408246',7,5,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,1,NULL,0,NULL,NULL,NULL,0),(3,'Operative actuating success','44231380',8,4,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,1,NULL,0,NULL,NULL,NULL,0),(4,'Configurable 3rdgeneration success','17070824',1,2,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,1,NULL,0,NULL,NULL,NULL,0),(5,'Multi-channelled background model','25964380',2,2,'2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,1,NULL,0,NULL,NULL,NULL,0),(6,'Test Model','',2,5,'2016-11-20 23:12:49','2016-11-21 00:33:29',0,1,0,NULL,0,'2016-11-21 00:33:29',NULL,'',0),(7,'TestModel','350335',8,11,'2016-11-21 00:33:28','2016-11-21 00:33:28',0,1,12,NULL,0,NULL,NULL,'lorem ipsum blah blah',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_labels`
--

LOCK TABLES `status_labels` WRITE;
/*!40000 ALTER TABLE `status_labels` DISABLE KEYS */;
INSERT INTO `status_labels` VALUES (1,'Ready to Deploy',1,'2004-12-14 19:19:01','2011-11-20 01:20:52',NULL,1,0,0,'',NULL,0),(2,'Pending',1,'2007-02-27 15:33:24','1987-07-30 16:33:07',NULL,0,1,0,'',NULL,0),(3,'Archived',1,'2001-11-21 23:22:44','2000-07-30 19:54:16',NULL,0,0,1,'These assets are permanently undeployable',NULL,0),(4,'Out for Diagnostics',1,'1981-09-28 05:03:46','1979-03-28 12:50:57',NULL,0,0,0,'',NULL,0),(5,'Out for Repair',1,'2010-09-10 11:59:47','1973-10-19 04:27:48',NULL,0,0,0,'',NULL,0),(6,'Broken - Not Fixable',1,'1979-08-28 12:09:59','1981-08-25 12:56:48',NULL,0,0,1,'',NULL,0),(7,'Lost/Stolen',1,'2011-04-26 04:28:42','1999-07-22 04:43:21',NULL,0,0,1,'',NULL,0),(8,'Test Status',1,'2016-11-21 00:33:54','2016-11-21 00:33:54',NULL,0,1,0,'lorem ipsum something else','#b46262',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Deckow-Schuppe','695 Alejandra Motorway',NULL,'Torpmouth','OR','BG','292.995.6573 x818',NULL,'addie65@example.com','Jaiden Gutkowski DVM',NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,NULL),(2,'Gislason LLC','8624 Kenneth Tunnel',NULL,'Jamalburgh','RI','HK','1-250-263-8392',NULL,'marielle32@example.com','Arianna Metz',NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,NULL),(3,'Pouros, Bernhard and Herzog','681 Simonis Summit',NULL,'East Jaylinside','TX','MX','756-364-0473',NULL,'jerad.schoen@example.net','Delphine Gulgowski Jr.',NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,NULL),(4,'Weissnat, Reynolds and Quigley','7175 Lowe Bridge',NULL,'Vandervortberg','ND','MG','446.315.3002 x50031',NULL,'ryleigh69@example.com','Bradly Rogahn DDS',NULL,'2016-11-20 23:07:29','2016-11-20 23:07:29',NULL,NULL,NULL,NULL,NULL),(5,'Test Supplier','046t46 South Street','Apt 356','Sutherland','BV','AF','032626236 x35','342 33 6647 3555','p@roar.com','Mr. Smith','lorem ipsum indigo something','2016-11-21 00:33:56','2016-11-21 00:33:56',1,NULL,'30266','http://snipeitapp.com',NULL),(6,'Blank Supplier','','','','','','','','','','','2016-11-21 00:35:59','2016-11-21 00:35:59',1,NULL,'','http://',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'snipe@google.com','$2y$10$oSjP81uCdXW.nAHBIPteA..DsLPhJBiwD1tfny4hY0Ndicv1B5Nk6','{\"superuser\":\"1\",\"admin\":\"0\",\"reports.view\":\"0\",\"assets.view\":\"0\",\"assets.create\":\"0\",\"assets.edit\":\"0\",\"assets.delete\":\"0\",\"assets.checkin\":\"0\",\"assets.checkout\":\"0\",\"assets.view.requestable\":\"0\",\"accessories.view\":\"0\",\"accessories.create\":\"0\",\"accessories.edit\":\"0\",\"accessories.delete\":\"0\",\"accessories.checkout\":\"0\",\"accessories.checkin\":\"0\",\"consumables.view\":\"0\",\"consumables.create\":\"0\",\"consumables.edit\":\"0\",\"consumables.delete\":\"0\",\"consumables.checkout\":\"0\",\"licenses.view\":\"0\",\"licenses.create\":\"0\",\"licenses.edit\":\"0\",\"licenses.delete\":\"0\",\"licenses.checkout\":\"0\",\"licenses.keys\":\"0\",\"components.view\":\"0\",\"components.create\":\"0\",\"components.edit\":\"0\",\"components.delete\":\"0\",\"components.checkout\":\"0\",\"components.checkin\":\"0\",\"users.view\":\"0\",\"users.create\":\"0\",\"users.edit\":\"0\",\"users.delete\":\"0\",\"self.two_factor\":\"0\"}',1,NULL,NULL,NULL,NULL,NULL,'snipe','Snipe','2016-11-06 22:01:02','2016-11-21 00:33:59',NULL,NULL,NULL,NULL,NULL,'','',NULL,'',NULL,'snipeit','',NULL,'yui6FpaJTPf72mgW84Cv8YqcoE6C7UbuNoh5yGe9eW2yKCoOtryJNE230g9q',0,'en',1,NULL,0,0),(3,'bnelson0@cdbaby.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Bonnie',' Nelson','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bnelson0',NULL,NULL,NULL,0,'en',1,NULL,0,0),(4,'jferguson1@state.tx.us','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Judith',' Ferguson','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'jferguson1',NULL,NULL,NULL,0,'en',1,NULL,0,0),(5,'mgibson2@wiley.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Mildred',' Gibson','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'mgibson2',NULL,NULL,NULL,0,'en',1,NULL,0,0),(6,'blee3@quantcast.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Brandon',' Lee','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'blee3',NULL,NULL,NULL,0,'en',1,NULL,0,0),(7,'bpowell4@tuttocitta.it','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Betty',' Powell','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bpowell4',NULL,NULL,NULL,0,'en',1,NULL,0,0),(8,'awheeler5@cocolog-nifty.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Anthony',' Wheeler','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'awheeler5',NULL,NULL,NULL,0,'en',1,NULL,0,0),(9,'dreynolds6@ustream.tv','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Dennis',' Reynolds','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'dreynolds6',NULL,NULL,NULL,0,'en',1,NULL,0,0),(10,'aarnold7@cbc.ca','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Andrea',' Arnold','2016-11-06 22:03:21','2016-11-06 22:03:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'aarnold7',NULL,NULL,NULL,0,'en',1,NULL,0,0),(11,'abutler8@wikia.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Anna',' Butler','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'abutler8',NULL,NULL,NULL,0,'en',1,NULL,0,0),(12,'mbennett9@diigo.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Mark',' Bennett','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'mbennett9',NULL,NULL,NULL,0,'en',1,NULL,0,0),(13,'ewheelera@google.de','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Emily',' Wheeler','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ewheelera',NULL,NULL,NULL,0,'en',1,NULL,0,0),(14,'wfoxb@virginia.edu','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Wanda',' Fox','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'wfoxb',NULL,NULL,NULL,0,'en',1,NULL,0,0),(15,'jgrantd@cpanel.net','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Janet',' Grant','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'jgrantd',NULL,NULL,NULL,0,'en',1,NULL,0,0),(16,'alarsone@tripod.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Antonio',' Larson','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'alarsone',NULL,NULL,NULL,0,'en',1,NULL,0,0),(17,'lpowellf@com.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Lois',' Powell','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'lpowellf',NULL,NULL,NULL,0,'en',1,NULL,0,0),(18,'malleng@com.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Mildred',' Allen','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'malleng',NULL,NULL,NULL,0,'en',1,NULL,0,0),(19,'caustinh@bigcartel.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Clarence',' Austin','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'caustinh',NULL,NULL,NULL,0,'en',1,NULL,0,0),(20,'wchavezi@blogs.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Walter',' Chavez','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'wchavezi',NULL,NULL,NULL,0,'en',1,NULL,0,0),(21,'melliottj@constantcontact.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Marie',' Elliott','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'melliottj',NULL,NULL,NULL,0,'en',1,NULL,0,0),(22,'bfordm@woothemes.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Benjamin',' Ford','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bfordm',NULL,NULL,NULL,0,'en',1,NULL,0,0),(23,'twarrenn@printfriendly.com','$2y$10$XXJbpVOtPb81jg0hRF9wRO9d62/qquyn5Pi7WLj/HHnxhEk4ThiZO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Timothy',' Warren','2016-11-06 22:03:22','2016-11-06 22:03:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'twarrenn',NULL,NULL,NULL,0,'en',1,NULL,0,0),(24,'carli.kutch@example.com','n.rSn]5><0@J]5y/akE',NULL,0,NULL,NULL,NULL,NULL,NULL,'Virgie','Koepp','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hodkiewicz.ora',NULL,1,NULL,0,'en',1,NULL,0,0),(25,'jaida.yundt@example.org',';5lrG0D]`,\"a&8EK',NULL,0,NULL,NULL,NULL,NULL,NULL,'Aidan','Kuhn','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'emilie99',NULL,1,NULL,0,'en',1,NULL,0,0),(26,'stroman.ferne@example.org','$Tv\"Th',NULL,0,NULL,NULL,NULL,NULL,NULL,'Brendan','Beier','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'kpfannerstill',NULL,2,NULL,0,'en',1,NULL,0,0),(27,'janae.kris@example.net','h:D;__sn',NULL,0,NULL,NULL,NULL,NULL,NULL,'Johann','Jenkins','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'agnes.schaden',NULL,2,NULL,0,'en',1,NULL,0,0),(28,'iwalker@example.org','gPxOMxb^nQhdT',NULL,0,NULL,NULL,NULL,NULL,NULL,'Lilla','Marks','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'blanca05',NULL,1,NULL,0,'en',1,NULL,0,0),(29,'santos18@example.net','uEB#o(rvmE&.',NULL,0,NULL,NULL,NULL,NULL,NULL,'Magdalen','Ondricka','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'lenore02',NULL,2,NULL,0,'en',1,NULL,0,0),(30,'gislason.arely@example.com','5F\\]9dw)Z*\"z',NULL,0,NULL,NULL,NULL,NULL,NULL,'Herbert','Mueller','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'sbeier',NULL,3,NULL,0,'en',1,NULL,0,0),(31,'kris.lauriane@example.net','b*GzqFjV\'5==s4',NULL,0,NULL,NULL,NULL,NULL,NULL,'Hope','Ledner','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'cameron.dickens',NULL,2,NULL,0,'en',1,NULL,0,0),(32,'glenda.jacobi@example.net','fuPK3mC~Gwy',NULL,0,NULL,NULL,NULL,NULL,NULL,'Shayne','Mraz','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'heaven.conn',NULL,1,NULL,0,'en',1,NULL,0,0),(33,'rkonopelski@example.net','XD6mF&1XZyX@6d3izG',NULL,0,NULL,NULL,NULL,NULL,NULL,'Magali','Hamill','2016-11-20 23:03:56','2016-11-20 23:03:56',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'susie26',NULL,4,NULL,0,'en',1,NULL,0,0),(34,'g@roar.com','$2y$10$3//tj9exuu7n/RVVBH2XfuEjj6KyVo0DNsMyXbqmTzieDvbrkZ27G','{\"superuser\":\"0\",\"admin\":\"0\",\"reports.view\":\"0\",\"assets.view\":\"0\",\"assets.create\":\"0\",\"assets.edit\":\"0\",\"assets.delete\":\"0\",\"assets.checkin\":\"0\",\"assets.checkout\":\"0\",\"assets.view.requestable\":\"0\",\"accessories.view\":\"0\",\"accessories.create\":\"0\",\"accessories.edit\":\"0\",\"accessories.delete\":\"0\",\"accessories.checkout\":\"0\",\"accessories.checkin\":\"0\",\"consumables.view\":\"0\",\"consumables.create\":\"0\",\"consumables.edit\":\"0\",\"consumables.delete\":\"0\",\"consumables.checkout\":\"0\",\"licenses.view\":\"0\",\"licenses.create\":\"0\",\"licenses.edit\":\"0\",\"licenses.delete\":\"0\",\"licenses.checkout\":\"0\",\"licenses.keys\":\"0\",\"components.view\":\"0\",\"components.create\":\"0\",\"components.edit\":\"0\",\"components.delete\":\"0\",\"components.checkout\":\"0\",\"components.checkin\":\"0\",\"users.view\":\"0\",\"users.create\":\"0\",\"users.edit\":\"0\",\"users.delete\":\"0\",\"self.two_factor\":\"0\"}',1,NULL,NULL,NULL,NULL,NULL,'John','Smdt','2016-11-20 23:06:01','2016-11-20 23:06:01',NULL,NULL,NULL,NULL,67,'35235 33535 x5','Robot',19,'1636 636',NULL,'jsmdt','lorem ipsum indigo something',3,NULL,0,'en-GB',1,NULL,0,0),(35,'khyatt@example.net','(RFSG=`Z8$Zf%J',NULL,0,NULL,NULL,NULL,NULL,NULL,'Kristopher','Skiles','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'dovie08',NULL,1,NULL,0,'en',1,NULL,0,0),(36,'lockman.demarcus@example.org','vAJ^z=8$=?9$wfut',NULL,0,NULL,NULL,NULL,NULL,NULL,'Bell','Franecki','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'rocky.nitzsche',NULL,4,NULL,0,'en',1,NULL,0,0),(37,'murray37@example.org','9yz{h<vVQ',NULL,0,NULL,NULL,NULL,NULL,NULL,'Blanca','Nitzsche','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'mmarvin',NULL,4,NULL,0,'en',1,NULL,0,0),(38,'zschimmel@example.com','/&G_cO4JJglZ*<>y%',NULL,0,NULL,NULL,NULL,NULL,NULL,'Ivory','Wyman','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'vince.renner',NULL,2,NULL,0,'en',1,NULL,0,0),(39,'jacobson.yadira@example.com','#K.%ev&$gKr_[',NULL,0,NULL,NULL,NULL,NULL,NULL,'Harry','Brown','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'jarred.bode',NULL,2,NULL,0,'en',1,NULL,0,0),(40,'mdaniel@example.net','%`_LI(aPpUJ^(Bg3Hv~',NULL,0,NULL,NULL,NULL,NULL,NULL,'Jules','Herman','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hdenesik',NULL,4,NULL,0,'en',1,NULL,0,0),(41,'vincent.mcglynn@example.net','/$qJ#@u',NULL,0,NULL,NULL,NULL,NULL,NULL,'Marilou','O\'Keefe','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ova.cronin',NULL,4,NULL,0,'en',1,NULL,0,0),(42,'frami.lupe@example.com','5{0@yQpA0tI{',NULL,0,NULL,NULL,NULL,NULL,NULL,'Michelle','Lubowitz','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'smith.lorenzo',NULL,3,NULL,0,'en',1,NULL,0,0),(43,'davion83@example.net','$S?[!#^F\",oo&',NULL,0,NULL,NULL,NULL,NULL,NULL,'Cary','Medhurst','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'schowalter.tremaine',NULL,1,NULL,0,'en',1,NULL,0,0),(44,'roxane.torp@example.net','wplSIT.N=',NULL,0,NULL,NULL,NULL,NULL,NULL,'Ethan','Stanton','2016-11-20 23:07:28','2016-11-20 23:07:28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'rey71',NULL,1,NULL,0,'en',1,NULL,0,0);
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

-- Dump completed on 2016-11-20 12:36:32
