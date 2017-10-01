-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: snipeittests
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.17.04.1

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accessories`
--

LOCK TABLES `accessories` WRITE;
/*!40000 ALTER TABLE `accessories` DISABLE KEYS */;
INSERT INTO `accessories` VALUES (1,'Ut mollitia.',14,NULL,8,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,3,'1988-09-17',25836.87,'35014616',11,2,10,NULL),(2,'Ut et ut soluta.',14,NULL,5,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,2,'1985-11-06',200108.21,'21094683',14,1,4,NULL),(3,'Error tenetur.',12,NULL,5,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,1,'1986-05-14',28577.40,'41322960',4,2,1,NULL),(4,'Iusto et et non.',12,NULL,9,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,2,'1996-12-13',157.48,'29118579',10,2,2,NULL),(5,'Voluptatem ad rem.',14,NULL,6,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,3,'2015-12-30',310.50,'6252438',10,1,9,NULL),(6,'Nihil dignissimos.',14,NULL,7,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,5,'1999-10-30',59697588.47,'45178757',6,2,6,NULL),(7,'Dignissimos est et.',15,NULL,9,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,5,'1974-12-19',6.61,'2144808',12,2,9,NULL),(8,'Est in non autem.',12,NULL,5,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,4,'1979-11-15',425290.63,'27097724',9,1,8,NULL),(9,'Asperiores suscipit.',15,NULL,7,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,4,'2008-02-19',276973.34,'27119729',10,1,6,NULL),(10,'Officiis.',13,NULL,8,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,5,'2008-10-30',166316.55,'20862511',3,2,4,NULL),(11,'Tenetur minima.',15,NULL,5,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,3,'1990-11-13',1632.04,'24359280',11,1,10,NULL),(12,'Consequuntur.',12,NULL,8,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,4,'1971-06-18',0.72,'46029235',7,2,7,NULL),(13,'Dolorem vel nisi.',11,NULL,10,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,4,'2004-05-30',14910998.69,'41178738',8,2,5,NULL),(14,'Eum vel adipisci.',14,NULL,9,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,4,'2006-05-22',1.48,'4330024',14,2,1,NULL),(15,'Temporibus qui.',14,NULL,7,0,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,4,'1985-06-30',1806222.61,'7563193',14,1,9,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_logs`
--

LOCK TABLES `action_logs` WRITE;
/*!40000 ALTER TABLE `action_logs` DISABLE KEYS */;
INSERT INTO `action_logs` VALUES (1,24,'checkout',24,'App\\Models\\User',NULL,'Vel vel commodi optio.',NULL,'App\\Models\\Asset',73,NULL,NULL,'1995-05-10 01:17:29','2016-12-19 21:50:33',NULL,NULL,6,NULL),(2,27,'checkout',27,'App\\Models\\User',NULL,'Porro sapiente impedit accusamus nemo eum.',NULL,'App\\Models\\Asset',91,NULL,NULL,'1975-11-15 05:12:56','2016-12-19 21:50:33',NULL,NULL,9,NULL),(3,26,'checkout',26,'App\\Models\\User',NULL,'Nobis voluptas voluptate rem velit.',NULL,'App\\Models\\Asset',72,NULL,NULL,'2010-04-08 09:14:12','2016-12-19 21:50:33',NULL,NULL,8,NULL),(4,23,'checkout',23,'App\\Models\\User',NULL,'Est alias non vitae cum sequi eveniet inventore.',NULL,'App\\Models\\Asset',48,NULL,NULL,'1988-04-25 12:07:21','2016-12-19 21:50:33',NULL,NULL,5,NULL),(5,31,'checkout',31,'App\\Models\\User',NULL,'Incidunt architecto consequatur excepturi impedit.',NULL,'App\\Models\\Asset',37,NULL,NULL,'1983-03-30 03:15:07','2016-12-19 21:50:33',NULL,NULL,13,NULL),(6,25,'checkout',25,'App\\Models\\User',NULL,'Dicta enim sed inventore deserunt maxime.',NULL,'App\\Models\\Asset',69,NULL,NULL,'1970-02-05 04:54:45','2016-12-19 21:50:33',NULL,NULL,7,NULL),(7,25,'checkout',25,'App\\Models\\User',NULL,'Voluptatem quod dolor possimus laudantium sunt.',NULL,'App\\Models\\Asset',69,NULL,NULL,'2012-11-07 14:29:14','2016-12-19 21:50:33',NULL,NULL,7,NULL),(8,26,'checkout',26,'App\\Models\\User',NULL,'Id molestiae illum odit ut beatae alias cupiditate.',NULL,'App\\Models\\Asset',17,NULL,NULL,'2000-03-14 21:08:49','2016-12-19 21:50:33',NULL,NULL,8,NULL),(9,30,'checkout',30,'App\\Models\\User',NULL,'Et corporis voluptates consectetur sunt.',NULL,'App\\Models\\Asset',68,NULL,NULL,'1972-07-24 22:55:24','2016-12-19 21:50:33',NULL,NULL,12,NULL),(10,24,'checkout',24,'App\\Models\\User',NULL,'Explicabo et alias hic sed itaque nobis.',NULL,'App\\Models\\Asset',30,NULL,NULL,'2016-01-09 03:44:45','2016-12-19 21:50:33',NULL,NULL,6,NULL),(11,31,'checkout',31,'App\\Models\\User',NULL,'Molestias enim velit aliquam similique fugiat error voluptatem.',NULL,'App\\Models\\Asset',87,NULL,NULL,'2015-11-08 07:26:48','2016-12-19 21:50:33',NULL,NULL,13,NULL),(12,31,'checkout',31,'App\\Models\\User',NULL,'Et illo saepe et fugiat est.',NULL,'App\\Models\\Asset',9,NULL,NULL,'2001-10-10 05:22:36','2016-12-19 21:50:33',NULL,NULL,13,NULL),(13,27,'checkout',27,'App\\Models\\User',NULL,'Et est exercitationem itaque id.',NULL,'App\\Models\\Asset',63,NULL,NULL,'1994-05-10 00:38:33','2016-12-19 21:50:33',NULL,NULL,9,NULL),(14,31,'checkout',31,'App\\Models\\User',NULL,'Consequatur tenetur voluptate voluptatem ducimus.',NULL,'App\\Models\\Asset',87,NULL,NULL,'2014-09-28 04:11:04','2016-12-19 21:50:33',NULL,NULL,13,NULL),(15,23,'checkout',23,'App\\Models\\User',NULL,'Est esse maiores expedita qui dolorum.',NULL,'App\\Models\\Asset',35,NULL,NULL,'1993-11-26 19:17:32','2016-12-19 21:50:33',NULL,NULL,5,NULL),(16,27,'checkout',27,'App\\Models\\User',NULL,'Quae sit dolor optio quis et sit dolores eaque.',NULL,'App\\Models\\Asset',63,NULL,NULL,'1975-02-20 03:56:26','2016-12-19 21:50:33',NULL,NULL,9,NULL),(17,25,'checkout',25,'App\\Models\\User',NULL,'Iste culpa et harum est.',NULL,'App\\Models\\Asset',47,NULL,NULL,'2007-03-29 18:02:31','2016-12-19 21:50:33',NULL,NULL,7,NULL),(18,25,'checkout',25,'App\\Models\\User',NULL,'Et et doloribus rerum perspiciatis nihil.',NULL,'App\\Models\\Asset',47,NULL,NULL,'2008-07-06 13:46:10','2016-12-19 21:50:33',NULL,NULL,7,NULL),(19,28,'checkout',28,'App\\Models\\User',NULL,'Aut fuga magnam excepturi omnis.',NULL,'App\\Models\\Asset',54,NULL,NULL,'2005-12-20 04:13:13','2016-12-19 21:50:33',NULL,NULL,10,NULL),(20,31,'checkout',31,'App\\Models\\User',NULL,'Vel porro voluptatem maiores quod.',NULL,'App\\Models\\Asset',37,NULL,NULL,'1986-05-04 02:57:58','2016-12-19 21:50:33',NULL,NULL,13,NULL),(21,30,'checkout',30,'App\\Models\\User',NULL,'Nulla reiciendis temporibus ab repudiandae magni dolores.',NULL,'App\\Models\\Asset',1,NULL,NULL,'2015-06-15 02:40:58','2016-12-19 21:50:33',NULL,NULL,12,NULL),(22,30,'checkout',30,'App\\Models\\User',NULL,'Dolores unde temporibus magni dolorum voluptas enim.',NULL,'App\\Models\\Asset',1,NULL,NULL,'1978-09-20 04:58:31','2016-12-19 21:50:33',NULL,NULL,12,NULL),(23,30,'checkout',30,'App\\Models\\User',NULL,'Sed quia natus dolores vel ducimus ut beatae qui.',NULL,'App\\Models\\Asset',68,NULL,NULL,'1986-01-13 08:51:15','2016-12-19 21:50:33',NULL,NULL,12,NULL),(24,23,'checkout',23,'App\\Models\\User',NULL,'Delectus fugiat exercitationem est totam.',NULL,'App\\Models\\Asset',81,NULL,NULL,'2011-03-07 09:37:29','2016-12-19 21:50:33',NULL,NULL,5,NULL),(25,32,'checkout',32,'App\\Models\\User',NULL,'Et architecto suscipit nesciunt et voluptatem veritatis.',NULL,'App\\Models\\Asset',86,NULL,NULL,'1974-06-10 05:56:36','2016-12-19 21:50:33',NULL,NULL,14,NULL),(26,30,'checkout',30,'App\\Models\\User',NULL,'Tempora rem nisi cumque dicta sunt.',NULL,'App\\Models\\Accessory',7,NULL,NULL,'1974-10-15 03:43:14','2016-12-19 21:50:33',NULL,NULL,12,NULL),(27,24,'checkout',24,'App\\Models\\User',NULL,'Impedit laboriosam neque voluptas vel quia sequi aspernatur.',NULL,'App\\Models\\Accessory',6,NULL,NULL,'2014-08-27 16:35:28','2016-12-19 21:50:33',NULL,NULL,6,NULL),(28,26,'checkout',26,'App\\Models\\User',NULL,'Ut ea omnis repellat qui dicta consequuntur non.',NULL,'App\\Models\\Accessory',13,NULL,NULL,'1981-04-30 14:57:50','2016-12-19 21:50:33',NULL,NULL,8,NULL),(29,32,'checkout',32,'App\\Models\\User',NULL,'Ullam assumenda dolores veniam in sequi id voluptas possimus.',NULL,'App\\Models\\Accessory',14,NULL,NULL,'2008-06-03 04:54:41','2016-12-19 21:50:33',NULL,NULL,14,NULL),(30,25,'checkout',25,'App\\Models\\User',NULL,'Ea et repellendus fugiat aperiam sit ea repudiandae.',NULL,'App\\Models\\Accessory',12,NULL,NULL,'2004-08-11 00:47:29','2016-12-19 21:50:33',NULL,NULL,7,NULL),(31,24,'checkout',24,'App\\Models\\User',NULL,'Velit ad excepturi aut beatae.',NULL,'App\\Models\\Accessory',6,NULL,NULL,'1998-06-23 20:01:36','2016-12-19 21:50:33',NULL,NULL,6,NULL),(32,25,'checkout',25,'App\\Models\\User',NULL,'Quis nisi consequatur laudantium et.',NULL,'App\\Models\\Accessory',12,NULL,NULL,'1980-07-26 06:18:01','2016-12-19 21:50:33',NULL,NULL,7,NULL),(33,26,'checkout',26,'App\\Models\\User',NULL,'Omnis quia minima ipsum.',NULL,'App\\Models\\Accessory',13,NULL,NULL,'1986-03-17 11:20:43','2016-12-19 21:50:33',NULL,NULL,8,NULL),(34,24,'checkout',24,'App\\Models\\User',NULL,'Id sunt et praesentium eligendi voluptates vel ut.',NULL,'App\\Models\\Accessory',6,NULL,NULL,'1971-06-04 14:41:28','2016-12-19 21:50:33',NULL,NULL,6,NULL),(35,28,'checkout',28,'App\\Models\\User',NULL,'Sint libero odio non veniam commodi.',NULL,'App\\Models\\Accessory',4,NULL,NULL,'2007-07-02 12:21:13','2016-12-19 21:50:33',NULL,NULL,10,NULL),(36,26,'checkout',26,'App\\Models\\User',NULL,'Quibusdam officiis cupiditate velit iure eos ut.',NULL,'App\\Models\\Accessory',13,NULL,NULL,'2007-06-30 02:35:23','2016-12-19 21:50:33',NULL,NULL,8,NULL),(37,32,'checkout',32,'App\\Models\\User',NULL,'Consequuntur accusamus cum quo sunt repudiandae fugiat.',NULL,'App\\Models\\Accessory',15,NULL,NULL,'1973-06-05 18:46:12','2016-12-19 21:50:33',NULL,NULL,14,NULL),(38,27,'checkout',27,'App\\Models\\User',NULL,'Temporibus et sapiente quaerat ea ut animi et iure.',NULL,'App\\Models\\Accessory',8,NULL,NULL,'1990-03-07 22:36:15','2016-12-19 21:50:33',NULL,NULL,9,NULL),(39,24,'checkout',24,'App\\Models\\User',NULL,'Veniam eligendi accusamus officiis non.',NULL,'App\\Models\\Accessory',6,NULL,NULL,'1982-10-23 03:19:36','2016-12-19 21:50:33',NULL,NULL,6,NULL),(40,27,'checkout',27,'App\\Models\\User',NULL,'Qui non vel eaque.',NULL,'App\\Models\\Accessory',8,NULL,NULL,'1978-11-18 21:01:26','2016-12-19 21:50:33',NULL,NULL,9,NULL),(41,24,'checkout',24,'App\\Models\\User',NULL,'Illo qui earum ut maxime commodi ullam.',NULL,'App\\Models\\Consumable',17,NULL,NULL,'1994-11-09 00:38:45','2016-12-19 21:50:33',NULL,NULL,6,NULL),(42,25,'checkout',25,'App\\Models\\User',NULL,'Omnis veniam mollitia doloribus laborum consequuntur voluptatibus.',NULL,'App\\Models\\Consumable',10,NULL,NULL,'1985-06-20 18:36:29','2016-12-19 21:50:33',NULL,NULL,7,NULL),(43,26,'checkout',26,'App\\Models\\User',NULL,'Expedita consectetur eum adipisci.',NULL,'App\\Models\\Consumable',21,NULL,NULL,'1975-12-15 03:41:45','2016-12-19 21:50:33',NULL,NULL,8,NULL),(44,32,'checkout',32,'App\\Models\\User',NULL,'Repellendus tempore et magnam consequuntur ut saepe ipsa explicabo.',NULL,'App\\Models\\Consumable',11,NULL,NULL,'2005-08-11 15:44:56','2016-12-19 21:50:33',NULL,NULL,14,NULL),(45,25,'checkout',25,'App\\Models\\User',NULL,'Excepturi in et eum corporis earum sit.',NULL,'App\\Models\\Consumable',10,NULL,NULL,'1998-06-09 10:14:09','2016-12-19 21:50:33',NULL,NULL,7,NULL),(46,24,'checkout',24,'App\\Models\\User',NULL,'Dolor voluptatum officiis non et.',NULL,'App\\Models\\Consumable',17,NULL,NULL,'1988-12-14 06:06:08','2016-12-19 21:50:33',NULL,NULL,6,NULL),(47,23,'checkout',23,'App\\Models\\User',NULL,'Vel eveniet et dolorem incidunt corporis.',NULL,'App\\Models\\Consumable',14,NULL,NULL,'1983-03-27 19:44:57','2016-12-19 21:50:33',NULL,NULL,5,NULL),(48,24,'checkout',24,'App\\Models\\User',NULL,'Doloremque consequatur eveniet ratione sint.',NULL,'App\\Models\\Consumable',17,NULL,NULL,'1984-12-25 02:37:48','2016-12-19 21:50:33',NULL,NULL,6,NULL),(49,28,'checkout',28,'App\\Models\\User',NULL,'Facilis dicta voluptas molestiae aspernatur.',NULL,'App\\Models\\Consumable',20,NULL,NULL,'1993-11-04 18:16:37','2016-12-19 21:50:33',NULL,NULL,10,NULL),(50,31,'checkout',31,'App\\Models\\User',NULL,'Recusandae sed nemo aspernatur quas dolores earum ab ut.',NULL,'App\\Models\\Consumable',13,NULL,NULL,'1981-09-20 00:52:40','2016-12-19 21:50:33',NULL,NULL,13,NULL),(51,27,'checkout',27,'App\\Models\\User',NULL,'Et non libero ut ipsam repellendus rerum.',NULL,'App\\Models\\Consumable',22,NULL,NULL,'1972-10-05 10:05:57','2016-12-19 21:50:33',NULL,NULL,9,NULL),(52,28,'checkout',28,'App\\Models\\User',NULL,'Nobis porro sit aut non nihil.',NULL,'App\\Models\\Consumable',20,NULL,NULL,'1995-10-22 21:04:16','2016-12-19 21:50:33',NULL,NULL,10,NULL),(53,28,'checkout',28,'App\\Models\\User',NULL,'Esse consequatur totam est sit.',NULL,'App\\Models\\Consumable',20,NULL,NULL,'1996-02-04 19:03:51','2016-12-19 21:50:33',NULL,NULL,10,NULL),(54,29,'checkout',29,'App\\Models\\User',NULL,'Esse aut et laborum illum accusamus.',NULL,'App\\Models\\Consumable',5,NULL,NULL,'1984-10-03 10:34:17','2016-12-19 21:50:33',NULL,NULL,11,NULL),(55,24,'checkout',24,'App\\Models\\User',NULL,'Saepe et sed ducimus veniam maiores et.',NULL,'App\\Models\\Consumable',18,NULL,NULL,'1985-09-08 07:51:31','2016-12-19 21:50:33',NULL,NULL,6,NULL),(56,30,'checkout',30,'App\\Models\\User',NULL,'Tenetur vel et et ab sequi qui molestias ut.',NULL,'App\\Models\\Component',8,NULL,NULL,'2004-02-05 06:50:03','2016-12-19 21:50:33',NULL,NULL,12,NULL),(57,31,'checkout',31,'App\\Models\\User',NULL,'Quia repellendus rerum voluptatum ipsum.',NULL,'App\\Models\\Component',6,NULL,NULL,'1987-12-04 11:47:41','2016-12-19 21:50:33',NULL,NULL,13,NULL),(58,32,'checkout',32,'App\\Models\\User',NULL,'Velit repudiandae aut laboriosam voluptatibus repellendus cum.',NULL,'App\\Models\\Component',1,NULL,NULL,'2000-07-07 13:44:09','2016-12-19 21:50:33',NULL,NULL,14,NULL),(59,24,'checkout',24,'App\\Models\\User',NULL,'Reprehenderit cum consequuntur consequatur repellendus.',NULL,'App\\Models\\Component',7,NULL,NULL,'1991-03-10 23:23:04','2016-12-19 21:50:33',NULL,NULL,6,NULL),(60,24,'checkout',24,'App\\Models\\User',NULL,'Consequatur ut qui animi asperiores.',NULL,'App\\Models\\Component',7,NULL,NULL,'2005-03-12 14:09:19','2016-12-19 21:50:33',NULL,NULL,6,NULL),(61,31,'checkout',31,'App\\Models\\User',NULL,'Unde laboriosam aut in.',NULL,'App\\Models\\Component',6,NULL,NULL,'1984-04-14 18:22:36','2016-12-19 21:50:33',NULL,NULL,13,NULL),(62,32,'checkout',32,'App\\Models\\User',NULL,'Culpa est corrupti totam quia illum maiores.',NULL,'App\\Models\\Component',1,NULL,NULL,'1972-02-27 23:08:45','2016-12-19 21:50:33',NULL,NULL,14,NULL),(63,24,'checkout',24,'App\\Models\\User',NULL,'Officiis nulla ex quas vero quo necessitatibus dolores.',NULL,'App\\Models\\Component',7,NULL,NULL,'1989-10-18 17:45:26','2016-12-19 21:50:33',NULL,NULL,6,NULL),(64,29,'checkout',29,'App\\Models\\User',NULL,'Non aut voluptatem impedit cumque quia a.',NULL,'App\\Models\\Component',10,NULL,NULL,'1970-03-18 02:34:24','2016-12-19 21:50:33',NULL,NULL,11,NULL),(65,30,'checkout',30,'App\\Models\\User',NULL,'Voluptatem porro omnis officiis eius suscipit.',NULL,'App\\Models\\Component',4,NULL,NULL,'1979-02-25 12:15:40','2016-12-19 21:50:33',NULL,NULL,12,NULL),(66,29,'checkout',29,'App\\Models\\User',NULL,'Et dignissimos aperiam quod quis architecto sed.',NULL,'App\\Models\\Component',10,NULL,NULL,'1974-05-16 12:29:54','2016-12-19 21:50:33',NULL,NULL,11,NULL),(67,24,'checkout',24,'App\\Models\\User',NULL,'Molestiae nemo quidem odio culpa aut ut.',NULL,'App\\Models\\Component',7,NULL,NULL,'2011-11-28 06:56:33','2016-12-19 21:50:33',NULL,NULL,6,NULL),(68,29,'checkout',29,'App\\Models\\User',NULL,'Quia libero minus aliquid porro soluta.',NULL,'App\\Models\\Component',10,NULL,NULL,'2015-08-18 17:31:40','2016-12-19 21:50:33',NULL,NULL,11,NULL),(69,29,'checkout',29,'App\\Models\\User',NULL,'Occaecati animi deserunt est quaerat nam ut aliquam.',NULL,'App\\Models\\Component',10,NULL,NULL,'1989-05-18 06:08:46','2016-12-19 21:50:33',NULL,NULL,11,NULL),(70,32,'checkout',32,'App\\Models\\User',NULL,'Ut expedita cumque culpa blanditiis quia.',NULL,'App\\Models\\Component',1,NULL,NULL,'1981-12-16 17:31:14','2016-12-19 21:50:33',NULL,NULL,14,NULL),(71,31,'checkout',87,'App\\Models\\Asset',NULL,'Ut animi earum delectus aperiam.',NULL,'App\\Models\\License',3,NULL,NULL,'1989-02-13 12:10:30','2016-12-19 21:50:33',NULL,NULL,13,NULL),(72,24,'checkout',34,'App\\Models\\Asset',NULL,'In maxime nam asperiores qui magnam.',NULL,'App\\Models\\License',7,NULL,NULL,'2007-06-29 01:57:24','2016-12-19 21:50:33',NULL,NULL,6,NULL),(73,24,'checkout',30,'App\\Models\\Asset',NULL,'Esse consequuntur numquam ipsam soluta eveniet porro.',NULL,'App\\Models\\License',7,NULL,NULL,'1975-01-20 12:21:57','2016-12-19 21:50:33',NULL,NULL,6,NULL),(74,24,'checkout',25,'App\\Models\\Asset',NULL,'Quis alias qui sed ad sunt cum ea.',NULL,'App\\Models\\License',7,NULL,NULL,'2016-03-06 03:19:52','2016-12-19 21:50:33',NULL,NULL,6,NULL),(75,32,'checkout',88,'App\\Models\\Asset',NULL,'Ipsam sit qui explicabo dolor neque rerum in.',NULL,'App\\Models\\License',6,NULL,NULL,'2015-04-07 18:35:31','2016-12-19 21:50:33',NULL,NULL,14,NULL),(76,32,'checkout',31,'App\\Models\\Asset',NULL,'Eum vero voluptas eveniet vel nihil.',NULL,'App\\Models\\License',6,NULL,NULL,'1971-04-10 08:02:47','2016-12-19 21:50:33',NULL,NULL,14,NULL),(77,25,'checkout',12,'App\\Models\\Asset',NULL,'Labore quidem consequuntur quidem ipsa nulla eaque cum.',NULL,'App\\Models\\License',5,NULL,NULL,'1980-12-04 22:01:56','2016-12-19 21:50:33',NULL,NULL,7,NULL),(78,23,'checkout',24,'App\\Models\\Asset',NULL,'Incidunt eligendi nisi quod fuga.',NULL,'App\\Models\\License',9,NULL,NULL,'1998-11-15 03:15:00','2016-12-19 21:50:33',NULL,NULL,5,NULL),(79,31,'checkout',70,'App\\Models\\Asset',NULL,'Provident architecto est quasi voluptatibus placeat.',NULL,'App\\Models\\License',3,NULL,NULL,'1988-08-31 21:01:43','2016-12-19 21:50:33',NULL,NULL,13,NULL),(80,31,'checkout',70,'App\\Models\\Asset',NULL,'Occaecati sed magnam omnis quos corporis sed quis.',NULL,'App\\Models\\License',3,NULL,NULL,'2011-06-09 04:25:21','2016-12-19 21:50:33',NULL,NULL,13,NULL),(81,31,'checkout',70,'App\\Models\\Asset',NULL,'Omnis est architecto esse totam itaque quia.',NULL,'App\\Models\\License',3,NULL,NULL,'1982-07-20 06:59:37','2016-12-19 21:50:33',NULL,NULL,13,NULL),(82,24,'checkout',84,'App\\Models\\Asset',NULL,'Ut placeat magni similique dolor qui et sit pariatur.',NULL,'App\\Models\\License',7,NULL,NULL,'2006-04-20 06:44:28','2016-12-19 21:50:33',NULL,NULL,6,NULL),(83,26,'checkout',62,'App\\Models\\Asset',NULL,'Sint ab et et hic tempora ut omnis.',NULL,'App\\Models\\License',2,NULL,NULL,'1988-04-09 22:43:53','2016-12-19 21:50:33',NULL,NULL,8,NULL),(84,25,'checkout',47,'App\\Models\\Asset',NULL,'Ipsam quibusdam debitis dignissimos est optio et explicabo culpa.',NULL,'App\\Models\\License',5,NULL,NULL,'2000-08-06 04:38:43','2016-12-19 21:50:33',NULL,NULL,7,NULL),(85,32,'checkout',79,'App\\Models\\Asset',NULL,'Veniam tempora rerum vero dolorum.',NULL,'App\\Models\\License',6,NULL,NULL,'1975-05-03 23:05:42','2016-12-19 21:50:33',NULL,NULL,14,NULL);
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
  `assigned_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES (1,'Visionary secondary core','1465939380',1,'b69474b2-27b1-3f93-97e9-db014b50855c','1994-09-15',65.91,'20260334',NULL,'Incidunt unde et ipsum.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,5,1,4,NULL,NULL,NULL,NULL,12,NULL),(2,'Multi-channelled assymetric hierarchy','62067267',2,'2939d8f0-517c-3813-92ae-600b730d7077','2012-09-16',8118065.09,'2966491',NULL,'Ut voluptatem soluta at omnis.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,0,3,NULL,NULL,NULL,NULL,14,NULL),(3,'Automated stable instructionset','1040897710',4,'f976dfff-88bd-365c-abec-c7e2866c8b39','1971-10-23',2.67,'13451420',NULL,'Eligendi amet harum fuga harum sunt.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,0,4,NULL,NULL,NULL,NULL,11,NULL),(4,'Total maximized data-warehouse','1249884067',3,'eb57f9f7-df07-30af-98e1-c6ce50d463e8','2009-06-22',1549.23,'32663424',NULL,'Non nihil quo aut aut odit dolorem.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,2,0,3,NULL,NULL,NULL,NULL,2,NULL),(5,'Sharable directional monitoring','1243453118',4,'3eb5e7d4-d07b-3dc2-a66c-c66a1440f273','2006-07-07',101.96,'45353300',NULL,'Voluptatibus et autem tempora.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,NULL,12,NULL),(6,'Multi-tiered intermediate help-desk','670576799',5,'202b8cef-61cf-3bfc-990f-76ab70b23af3','2001-03-25',12224.44,'25748332',NULL,'Expedita sint dolor nesciunt.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,5,1,4,NULL,NULL,NULL,NULL,1,NULL),(7,'Advanced dynamic task-force','1287783991',5,'7ee9c0de-bc09-32a9-8102-836ebca4e1cc','2004-11-09',16.52,'15204825',NULL,'Inventore consequuntur voluptate accusantium voluptas nesciunt sed harum eligendi.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,0,3,NULL,NULL,NULL,NULL,1,NULL),(8,'Realigned tangible interface','130771471',5,'d9d51b6f-c5ee-3493-b645-9e7bdbe015f7','1970-05-02',66.19,'47326077',NULL,'Est voluptatem necessitatibus sit.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,0,2,NULL,NULL,NULL,NULL,3,NULL),(9,'Polarised hybrid neural-net','550271593',4,'b1ab1fce-0d01-384a-b4be-860202392dcb','2010-08-06',97.79,'41439691',NULL,'Dolorem nihil illum magni sed sunt.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,5,1,5,NULL,NULL,NULL,NULL,13,NULL),(10,'Facetoface zeroadministration workforce','480468566',4,'3162a8b8-7ac0-3e90-a944-ecaf37c3b8ef','2015-01-17',2803464.97,'15427150',NULL,'Ipsam error ut assumenda laudantium omnis aut.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,5,0,2,NULL,NULL,NULL,NULL,13,NULL),(11,'Quality-focused grid-enabled service-desk','543913477',2,'f7ac27b3-57d1-388c-bb01-da4db118f36b','2006-04-06',29720634.10,'47076493',NULL,'Nulla aut sunt voluptatem corrupti debitis unde.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,3,0,1,NULL,NULL,NULL,NULL,9,NULL),(12,'Seamless non-volatile focusgroup','364062836',3,'6563015c-d18a-3a11-9663-4190acb417d5','1993-12-11',2268554.13,'10865899',NULL,'Et voluptas molestias voluptatum commodi ut eius in.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,0,4,NULL,NULL,NULL,NULL,7,NULL),(13,'Secured local structure','101852892',5,'24bb7294-e323-3f65-bb0f-a289d4948d64','2000-02-01',138.91,'46488840',NULL,'Commodi possimus animi et deserunt qui dolor vero.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,3,0,3,NULL,NULL,NULL,NULL,3,NULL),(14,'Profound empowering collaboration','344958216',2,'481f212f-64bc-3ba9-afba-ee88e67b593b','2011-10-01',33910133.63,'24685446',NULL,'Sed ut modi aut rerum rerum.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,1,5,NULL,NULL,NULL,NULL,3,NULL),(15,'Visionary multi-tasking securedline','767397902',1,'51d48976-a23b-31c7-b6cd-b8ad0df184d3','2000-01-14',4576.44,'14926990',NULL,'Sed sunt porro eum sed quia.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,3,1,2,NULL,NULL,NULL,NULL,9,NULL),(16,'Ergonomic web-enabled architecture','615124208',5,'14e3263e-990c-3ab4-ac07-bae840766a00','1979-02-09',0.02,'2105706',NULL,'Sunt id dolores inventore rerum pariatur est quia.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,5,0,3,NULL,NULL,NULL,NULL,12,NULL),(17,'Open-source intermediate instructionset','1270731692',5,'9fdbe892-9469-3ed5-bce5-e0ff0b966dc2','2012-01-12',237.80,'14518413',NULL,'Nemo ut aperiam blanditiis rerum doloribus.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,0,5,NULL,NULL,NULL,NULL,8,NULL),(18,'Managed disintermediate moratorium','1022866111',2,'3466d91a-75e6-3a0f-95a5-1477e7770745','1983-05-03',2.92,'14715014',NULL,'Perferendis vel autem autem dolor consequatur eum.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,0,3,NULL,NULL,NULL,NULL,11,NULL),(19,'Decentralized user-facing website','940534451',5,'c4836458-cb4c-32d3-8b4d-5414351771b9','2000-06-29',247045.04,'4657436',NULL,'Accusamus non id et voluptatem.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,4,0,4,NULL,NULL,NULL,NULL,4,NULL),(20,'Expanded content-based solution','942251388',4,'116d7d4a-4b56-322e-b479-16218caf56bc','2009-02-19',39627130.06,'32035872',NULL,'Veritatis veritatis ut expedita in eum voluptatem qui.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,2,0,5,NULL,NULL,NULL,NULL,8,NULL),(21,'Focused maximized implementation','1249819308',5,'cb682760-e287-386e-8160-487403deb74c','2012-07-15',5778.07,'47965311',NULL,'Sed voluptatem eius placeat blanditiis soluta id deserunt.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,1,0,2,NULL,NULL,NULL,NULL,14,NULL),(22,'Proactive client-server processimprovement','883029704',3,'4e7ad5b0-a675-3846-b5a6-4d342bf33b54','1990-04-16',0.00,'26251720',NULL,'Eos voluptas explicabo magni aut cupiditate nostrum atque ducimus.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,2,0,2,NULL,NULL,NULL,NULL,2,NULL),(23,'Operative demand-driven info-mediaries','656985114',1,'13b0499e-e49b-3618-b45f-b228d2d25fc5','2015-05-16',24.46,'3609650',NULL,'Modi ut sit minus.',NULL,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',1,NULL,1,NULL,NULL,NULL,3,0,5,NULL,NULL,NULL,NULL,9,NULL),(24,'Open-architected grid-enabled software','59169139',4,'41502a6f-1dfd-3eab-9c31-029f8872f2be','1990-01-30',450.80,'49015606',NULL,'Consequuntur praesentium quod sit quod.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,0,3,NULL,NULL,NULL,NULL,5,NULL),(25,'Persistent exuding opensystem','856754651',1,'dc45fcd5-2fc7-3d62-8bb1-0c685a270004','2011-07-13',1.53,'3161489',NULL,'Et voluptates corporis sed possimus iure maiores.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,0,1,NULL,NULL,NULL,NULL,6,NULL),(26,'Multi-tiered attitude-oriented projection','807015293',5,'1125d40f-ed93-3a8c-a69f-1bb068e44026','1976-10-04',37019.76,'7052260',NULL,'Expedita alias laborum accusantium praesentium necessitatibus est assumenda veniam.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,0,4,NULL,NULL,NULL,NULL,14,NULL),(27,'Facetoface well-modulated projection','1395451594',3,'2093efe3-f44f-30f6-b885-de3d023a0d5f','1987-12-30',51.82,'31340938',NULL,'Distinctio perspiciatis ut rerum culpa consequatur eligendi ipsam.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,1,NULL,NULL,NULL,NULL,3,NULL),(28,'Phased cohesive forecast','298505210',5,'196cec02-89c7-36de-a4ff-940fce629151','1986-12-20',20563.38,'4349606',NULL,'Enim rerum reiciendis in iste vel architecto.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,5,NULL,NULL,NULL,NULL,3,NULL),(29,'Phased asynchronous productivity','565884861',5,'fc89d527-3495-3255-a38a-f92bd1f01eca','2012-03-11',222963311.08,'49169719',NULL,'Minus et rerum voluptatum eos sed perferendis.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,1,NULL,NULL,NULL,NULL,4,NULL),(30,'Upgradable composite collaboration','45774522',4,'f4e12518-7f22-3f0a-8f3c-531e95021230','1978-05-08',690.36,'33700051',NULL,'Non veniam et iusto qui.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,NULL,6,NULL),(31,'Automated clear-thinking approach','280800955',1,'15f9b534-e2e3-338b-9ebb-708ee0eb281c','2007-05-02',25.02,'46111413',NULL,'Repellendus minima culpa suscipit esse tenetur in totam.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,1,5,NULL,NULL,NULL,NULL,14,NULL),(32,'Cross-platform value-added collaboration','291396827',3,'6b0d7ca1-cf4b-3a5c-999a-44c5dd5f8444','1988-10-28',878.62,'24306169',NULL,'Dolores eaque quidem veniam sapiente.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,4,NULL,NULL,NULL,NULL,14,NULL),(33,'Ameliorated heuristic forecast','434327491',4,'bd587d6c-0067-3f2a-a6e5-82e94e82a556','2001-03-03',612863.41,'30945188',NULL,'Suscipit est cupiditate consequatur libero voluptates corrupti fuga repudiandae.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,1,4,NULL,NULL,NULL,NULL,8,NULL),(34,'Progressive zeroadministration toolset','1130124248',1,'1568dc2b-f5de-3f95-a9f9-cbf77b45c8bd','1986-04-07',281.85,'34711081',NULL,'Pariatur illo veritatis eos minima eaque autem.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,1,2,NULL,NULL,NULL,NULL,6,NULL),(35,'Operative full-range instructionset','442560802',1,'c4461312-fd67-3ab2-ab32-d8b37b3d91a5','1986-09-01',19807940.14,'26289988',NULL,'Accusantium ea molestiae dolor.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,1,3,NULL,NULL,NULL,NULL,5,NULL),(36,'Pre-emptive coherent systemengine','9154795',5,'60f0ef79-9c7b-3d33-8b31-b040a6068f9b','1975-08-13',29.15,'19758830',NULL,'Voluptatem temporibus molestias sapiente tempora qui vitae.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,1,4,NULL,NULL,NULL,NULL,5,NULL),(37,'Robust value-added core','243145492',4,'7c37cb50-d2d1-3290-88d1-6c21132815b5','1986-02-10',67.41,'22175367',NULL,'Nisi quos omnis dolorum inventore.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,4,NULL,NULL,NULL,NULL,13,NULL),(38,'Ameliorated directional standardization','226248616',5,'31961f4d-a1b2-3676-bbb5-212cb767c549','1970-01-05',3010.68,'26395661',NULL,'Et sit perspiciatis sapiente inventore libero reprehenderit.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,2,NULL,NULL,NULL,NULL,9,NULL),(39,'Re-contextualized optimal frame','1362407233',3,'8a5be53f-eb59-30e0-b72c-e69b0d3a0e1a','1988-07-23',0.71,'46708629',NULL,'Maiores enim et dolores deserunt.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,5,NULL,NULL,NULL,NULL,14,NULL),(40,'Virtual static encoding','140377232',4,'8f746dee-734d-328d-a214-a2fa3548ffac','1996-01-11',14.73,'20834904',NULL,'Rerum placeat nobis magnam dolor amet et consectetur id.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,5,NULL,NULL,NULL,NULL,4,NULL),(41,'Vision-oriented high-level standardization','925970645',1,'e9cad216-ee72-3719-b5e4-38c62518d376','2004-01-14',4028.08,'31200094',NULL,'Tenetur error quisquam delectus expedita odit iusto sit rerum.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,1,NULL,NULL,NULL,NULL,11,NULL),(42,'Synergized scalable processimprovement','183749766',2,'9558eabb-6ba3-376f-b0c9-f3c2a7f067a6','1974-11-03',51096673.90,'22830723',NULL,'Voluptas assumenda delectus laborum ut voluptatem.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,0,4,NULL,NULL,NULL,NULL,12,NULL),(43,'Sharable non-volatile groupware','1230911641',4,'7154da35-5124-3fff-ac72-720d6e525eba','1973-12-16',23.40,'39001862',NULL,'Doloribus dolorem atque occaecati quas modi harum.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,1,4,NULL,NULL,NULL,NULL,9,NULL),(44,'Public-key 6thgeneration frame','449063516',2,'98590565-4f9d-365b-a884-73812ab79219','1999-07-16',1374.18,'29236659',NULL,'Et dicta veniam ea consequatur quibusdam.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,0,5,NULL,NULL,NULL,NULL,4,NULL),(45,'Automated empowering knowledgeuser','1130771148',4,'72a1b675-9897-3e2c-b7a1-4888bbeadc0e','2005-09-27',8.21,'29698142',NULL,'Blanditiis odit qui quos cupiditate alias est.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,1,4,NULL,NULL,NULL,NULL,2,NULL),(46,'Grass-roots incremental contingency','623854414',3,'9ffc77b4-c7c2-3514-9444-4a94c86a8839','1976-05-04',0.60,'48683741',NULL,'Esse odit neque quis illo velit magnam ut.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,1,4,NULL,NULL,NULL,NULL,12,NULL),(47,'Cross-platform holistic architecture','1479230642',5,'d6d61e4a-385e-302a-94ff-a3b7b9e09dd5','1989-12-04',30718642.38,'14503829',NULL,'Dolores suscipit aut natus quasi aut quos dignissimos.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,2,NULL,NULL,NULL,NULL,7,NULL),(48,'Diverse mission-critical matrices','177201955',3,'3c56ef7a-faca-3dfa-af18-b2b3fc215254','1971-06-08',8610849.64,'6040629',NULL,'Sit dolore dolorem totam dolor nulla sed hic.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,5,NULL,NULL,NULL,NULL,5,NULL),(49,'Focused uniform policy','213591583',2,'b2029504-c1b7-3182-8a69-6baba3a8bc80','2002-05-13',131830.90,'16141740',NULL,'Voluptas molestias et doloremque sunt ut nobis voluptatibus quam.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,1,5,NULL,NULL,NULL,NULL,13,NULL),(50,'Exclusive secondary leverage','322955899',1,'0d9c50f6-8ce4-333b-967e-7767e634f118','1977-08-29',5.93,'47631112',NULL,'Unde sapiente eaque aut.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,4,NULL,NULL,NULL,NULL,10,NULL),(51,'Advanced bandwidth-monitored adapter','1053798415',1,'b1ba053c-c2b0-3063-871d-4525b97479a1','2006-02-25',14.07,'11366596',NULL,'Expedita nulla inventore rerum perferendis consectetur.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,NULL,12,NULL),(52,'Innovative bandwidth-monitored GraphicInterface','454122127',2,'56cdb129-3eda-320b-88e8-f7f009e3b394','2006-06-24',145.41,'19949540',NULL,'Maxime ut ut exercitationem et et officia.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,1,4,NULL,NULL,NULL,NULL,7,NULL),(53,'Cloned upward-trending project','1344071999',1,'1f3b59a0-d39a-3086-9ce0-2535a1b8d4e8','2007-04-30',109.27,'46042391',NULL,'Placeat dolore beatae suscipit qui facilis consequatur dolore.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,1,2,NULL,NULL,NULL,NULL,5,NULL),(54,'Open-source modular info-mediaries','443740773',5,'dc5ef34e-2cfc-3987-9b96-af403f0a0d06','2001-02-04',334805.88,'44092000',NULL,'Et quis quo voluptates exercitationem.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,2,NULL,NULL,NULL,NULL,10,NULL),(55,'Balanced bottom-line knowledgebase','796374239',4,'bb347c78-122e-33f6-9a70-63c65e327ebf','2007-01-04',6.12,'43452338',NULL,'Dicta nesciunt reiciendis distinctio voluptatibus necessitatibus unde sit.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,0,1,NULL,NULL,NULL,NULL,11,NULL),(56,'Synchronised dynamic implementation','1212402558',1,'1f2c8176-c5f0-34f0-9926-b57add52a3ee','1998-08-16',1939.33,'7361962',NULL,'Natus adipisci consectetur voluptatem.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,1,4,NULL,NULL,NULL,NULL,11,NULL),(57,'User-friendly 5thgeneration focusgroup','1012354793',3,'3a02d70d-f206-3c20-a720-ca86ec9cfc84','1988-06-23',7.57,'44656197',NULL,'Consequatur culpa ut quod placeat sed rerum quidem illo.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,0,3,NULL,NULL,NULL,NULL,14,NULL),(58,'Expanded 5thgeneration complexity','812742014',4,'74a49bb8-af57-3af0-a1a0-a5731ac07b41','1981-12-02',118346182.29,'23747179',NULL,'Alias dolorem quam et amet perferendis.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,2,NULL,NULL,NULL,NULL,2,NULL),(59,'User-centric context-sensitive intranet','383856329',5,'e3b74a52-fc9e-3276-83e6-ec42e05301cb','2015-08-16',328816073.70,'23618511',NULL,'Ex cumque voluptas blanditiis quia exercitationem et cupiditate.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,1,2,NULL,NULL,NULL,NULL,13,NULL),(60,'Networked contextually-based forecast','14450513',2,'59dbf327-d381-346e-af9b-f56b9850be4e','1974-10-06',1488.84,'2923279',NULL,'Odio officia consequuntur cupiditate distinctio.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,3,NULL,NULL,NULL,NULL,14,NULL),(61,'Team-oriented secondary frame','710696247',1,'437c2828-37d2-3127-b75f-b1c06f478752','1975-05-24',521.61,'16444048',NULL,'Possimus tempore minus consequatur eos nisi quasi.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,0,2,NULL,NULL,NULL,NULL,14,NULL),(62,'Reverse-engineered neutral matrices','346946928',5,'8fb61550-665b-325d-a4eb-649ed4a19ddd','1983-05-02',654299.59,'21473608',NULL,'Adipisci harum modi quibusdam praesentium fugit ut quia.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,NULL,8,NULL),(63,'Intuitive mission-critical benchmark','633215379',5,'3267a389-57ee-3b40-be84-132ff9c92fc1','2011-04-01',1.09,'2663674',NULL,'Dolores veniam omnis aliquam in qui omnis.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,0,4,NULL,NULL,NULL,NULL,9,NULL),(64,'Vision-oriented user-facing analyzer','213197662',1,'46798b8d-87e9-3297-abd6-647886af7010','2016-08-03',14040.30,'17712399',NULL,'Consequuntur quis non earum.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,1,2,NULL,NULL,NULL,NULL,3,NULL),(65,'Centralized actuating initiative','1077234046',5,'47444ffb-8478-3923-aea2-54f1192b762d','1982-02-21',34253.85,'15265807',NULL,'Odit rerum sit repudiandae quo quam sequi consequuntur.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,5,NULL,NULL,NULL,NULL,4,NULL),(66,'Networked real-time function','136655874',1,'90da2bd4-dbde-3c0e-9719-a85b7507d5fa','2014-01-20',7131565.52,'7516067',NULL,'Officiis eos dolor inventore quia ipsa cum voluptas placeat.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,0,3,NULL,NULL,NULL,NULL,12,NULL),(67,'Enhanced tertiary interface','707949478',3,'b175217f-6a2f-31d5-bc5c-26d71ac0567e','2010-03-20',205.62,'5367013',NULL,'Deleniti incidunt adipisci facere aut voluptatibus quia voluptas rerum.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,0,4,NULL,NULL,NULL,NULL,12,NULL),(68,'Future-proofed methodical task-force','1288802320',1,'94f3892b-74a7-3387-b031-b7167246ac6a','1977-12-22',1939.36,'42716894',NULL,'Et aut est libero facilis et voluptas est.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,1,NULL,NULL,NULL,NULL,12,NULL),(69,'Synergistic local opensystem','36202885',5,'1b0fd973-d826-357a-bcc6-f87a483aa0a6','1972-10-09',31887.76,'21192424',NULL,'Tempora dolorem animi exercitationem illo.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,NULL,7,NULL),(70,'Organic uniform encoding','1469159579',5,'5aaa2005-5f7b-39b0-8265-bbbb6b11ee52','1990-11-10',327686100.97,'6324570',NULL,'Sed illum laboriosam nulla et dignissimos quia.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,5,NULL,NULL,NULL,NULL,13,NULL),(71,'Multi-channelled uniform capacity','397078339',5,'f4c3e126-cfdd-3f11-a498-9b227d9bb611','2006-09-12',30.26,'6934888',NULL,'Necessitatibus velit qui cum minima iste.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,1,4,NULL,NULL,NULL,NULL,3,NULL),(72,'User-friendly multi-state approach','884331378',4,'2d5a5518-b2b1-3fff-b912-d2876d24e030','2001-04-15',17843.21,'33136904',NULL,'Provident sit quisquam fugiat dolores voluptatem.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,NULL,8,NULL),(73,'Optimized neutral standardization','1270281282',4,'250c0dc2-fa13-390a-b713-7cb4b32beff8','2000-09-23',0.25,'27616493',NULL,'Voluptatem nobis dolores quibusdam consequatur.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,0,5,NULL,NULL,NULL,NULL,6,NULL),(74,'Re-engineered uniform model','345559146',5,'8c6710aa-d2f8-36c7-9311-ebde607a86fd','1977-12-03',513427.58,'48640671',NULL,'Saepe sint enim libero facere totam ratione.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,3,NULL,NULL,NULL,NULL,3,NULL),(75,'Upgradable motivating support','1353404468',5,'90cdfb07-6a2d-363d-b54a-6d6b638ef230','2007-03-23',0.26,'18523115',NULL,'Eos quisquam asperiores impedit.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,1,5,NULL,NULL,NULL,NULL,7,NULL),(76,'Innovative client-server opensystem','999240677',5,'ba835bad-1314-3209-8622-e628127a4c40','1980-03-29',2429924.99,'36149854',NULL,'Velit quia corrupti quis quas eaque qui.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,1,NULL,NULL,NULL,NULL,4,NULL),(77,'Reactive multi-tasking info-mediaries','145227946',3,'b0c62e7e-9d2c-35a3-8ed4-48c4050174f3','1974-08-31',288914923.45,'26555421',NULL,'Esse fugit temporibus debitis impedit in.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,1,2,NULL,NULL,NULL,NULL,4,NULL),(78,'Ergonomic demand-driven support','1139109215',2,'272286a8-33f7-3246-91c6-1fe32c6049b5','2016-08-25',124281091.67,'16599931',NULL,'Ipsa nisi expedita et quisquam aspernatur dolor error.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,0,5,NULL,NULL,NULL,NULL,6,NULL),(79,'Versatile systemic model','121747493',3,'7b3fb812-fa96-32e3-a07e-f06001523621','1983-07-09',3.41,'11741859',NULL,'Aut minima dolorem expedita aperiam quod cupiditate dolorem.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,0,2,NULL,NULL,NULL,NULL,14,NULL),(80,'Re-contextualized composite installation','946487822',2,'9deaac7c-2730-36c6-9a58-7f2682b9a177','1985-11-30',915.44,'32391115',NULL,'Modi omnis ut illo sed sed exercitationem.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,5,NULL,NULL,NULL,NULL,7,NULL),(81,'User-friendly national customerloyalty','376127354',5,'60216fff-abb1-321d-9128-f46f2056729f','1975-03-10',72.94,'4606858',NULL,'Sint in quo assumenda.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,4,NULL,NULL,NULL,NULL,5,NULL),(82,'Synergized 6thgeneration hub','797353978',4,'9e338295-77f0-3242-923f-4b241bfbb976','2014-04-27',10024083.74,'9387562',NULL,'Porro error delectus voluptas at deserunt labore.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,0,4,NULL,NULL,NULL,NULL,12,NULL),(83,'Assimilated encompassing knowledgeuser','1319949896',5,'d04e4c37-d01e-30d5-a9f5-328fe50232c3','2010-03-28',5242576.03,'10247809',NULL,'Voluptas molestias et et quia et provident velit nihil.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,0,4,NULL,NULL,NULL,NULL,3,NULL),(84,'Mandatory contextually-based circuit','904726044',5,'f0b7bdc2-893b-3e9d-a808-ce2a42d3a494','1997-08-13',1111.13,'28859502',NULL,'Inventore qui nihil dignissimos similique consequatur.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,0,1,NULL,NULL,NULL,NULL,6,NULL),(85,'Customizable maximized extranet','205955368',1,'18d73a95-93ee-32d0-8066-3e257f13ecec','2002-05-03',106017393.41,'32640013',NULL,'Et perferendis voluptatem asperiores molestiae qui.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,1,NULL,NULL,NULL,NULL,11,NULL),(86,'Organic interactive projection','706656762',1,'a63e284e-4b57-3f71-8209-89c8a3da1209','1983-09-13',3054.38,'14048494',NULL,'Eum sit velit ut accusantium a numquam.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,1,4,NULL,NULL,NULL,NULL,14,NULL),(87,'Monitored heuristic processimprovement','874379490',2,'0a5ddfa9-1cb5-3fcb-afe8-18be65b50bf5','2006-02-27',142285.11,'42475659',NULL,'Voluptatum nostrum aut dolor labore quaerat amet et.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,0,3,NULL,NULL,NULL,NULL,13,NULL),(88,'Enhanced non-volatile internetsolution','1042013011',2,'17d54504-ef82-3031-a406-407c6cac62f6','1987-12-02',3750104.82,'11286898',NULL,'Voluptatibus aperiam est sunt.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,1,2,NULL,NULL,NULL,NULL,14,NULL),(89,'Facetoface system-worthy data-warehouse','1349469825',5,'1ffa7309-863f-35cf-ba86-22a2f8d8c046','2011-12-07',10424.74,'42589963',NULL,'Soluta fugit sunt quia quis nesciunt aut.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,1,NULL,NULL,NULL,NULL,8,NULL),(90,'Devolved tertiary architecture','756516594',2,'6360f8fe-9f17-3f6b-bb4c-0dfae611890a','2012-06-20',58040.91,'37322517',NULL,'Repellendus omnis possimus iure enim qui.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,1,NULL,NULL,NULL,NULL,10,NULL),(91,'Object-based cohesive infrastructure','540855250',2,'a2c2d9f1-4fee-3937-99ba-201c185255b4','1982-09-16',14.85,'2855858',NULL,'Quia facilis amet eum accusamus expedita omnis.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,0,3,NULL,NULL,NULL,NULL,9,NULL),(92,'User-centric nextgeneration framework','1407060264',2,'64360e7a-e7f3-37e1-8a4a-35e8c5d4a4d6','1983-02-22',701943.52,'39532771',NULL,'Tempore commodi sed aut dolor ut libero.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,0,3,NULL,NULL,NULL,NULL,14,NULL),(93,'Implemented high-level functionalities','522206565',4,'4d5d7fb0-0a63-3ef2-b573-63dfa2f6c885','1996-09-30',3408.58,'46163648',NULL,'Numquam qui explicabo dolor et quis consequuntur.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,NULL,1,NULL),(94,'Decentralized zeroadministration approach','1317557840',2,'d822ba42-a6f8-30b3-b719-4f796912cba0','1973-09-25',538.60,'23608596',NULL,'Doloremque eos ea nostrum sint sequi.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,5,0,1,NULL,NULL,NULL,NULL,3,NULL),(95,'Optimized 3rdgeneration hardware','456187922',1,'774a815d-3235-366d-8f5d-35bd1c079dc1','2005-08-11',96654.32,'14312696',NULL,'Ab quisquam maxime architecto est delectus dolores minus.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,NULL,11,NULL),(96,'Exclusive leadingedge task-force','1000549766',3,'bf8134fb-ab14-30a4-ad80-c5dc5fbd2e9e','2008-04-05',1099228.44,'29187413',NULL,'Ipsum excepturi consequatur necessitatibus excepturi neque aut.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,1,1,3,NULL,NULL,NULL,NULL,8,NULL),(97,'Right-sized fault-tolerant instructionset','1081323227',3,'8f22c98c-c4cd-3031-860d-26e8e429052f','2011-09-23',178778663.20,'18280703',NULL,'Perspiciatis reprehenderit consequatur odit totam qui in adipisci.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,2,1,2,NULL,NULL,NULL,NULL,11,NULL),(98,'Business-focused systemic analyzer','1180494483',1,'5ea014ef-0001-384c-a63f-ba45cfc3ae1c','1998-06-19',5.05,'22932729',NULL,'Tenetur id vero ipsum molestias aut voluptas.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,3,0,2,NULL,NULL,NULL,NULL,9,NULL),(99,'Future-proofed dedicated portal','995595961',3,'9989615a-ca48-3a18-84ab-7bd0dd828adb','1988-09-09',28505188.20,'22468488',NULL,'Fugit ut incidunt nemo iure reiciendis ut.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,0,2,NULL,NULL,NULL,NULL,9,NULL),(100,'Facetoface hybrid focusgroup','1126621095',5,'a9045d81-1c28-3ee0-8101-d1d8a55a58f1','1976-12-14',3705370.96,'48014315',NULL,'Et ullam non quaerat voluptas.',NULL,1,'2016-12-19 21:50:32','2016-12-19 21:50:32',1,NULL,1,NULL,NULL,NULL,4,1,4,NULL,NULL,NULL,NULL,12,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Consequuntur nam et.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Ab quasi ut dolore voluptas. Aperiam beatae quia voluptatum ea. Dolores in perspiciatis consequatur qui iusto eius.',0,1,'asset',0),(2,'Quas et quia rerum.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Animi veritatis molestiae provident ut culpa hic. Optio laboriosam esse totam temporibus optio. Sint dolores ea sunt eveniet. Sit aliquam et culpa reiciendis quasi.',0,0,'asset',0),(3,'Exercitationem.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Fugit et ut eos laboriosam. Unde quis labore laborum assumenda voluptatum expedita. Ut qui expedita doloremque placeat. Corrupti et quibusdam explicabo aut at est voluptatibus.',0,0,'asset',1),(4,'Ullam qui.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Soluta ipsa iure ut. Delectus est in fugiat architecto aspernatur. Consequuntur quisquam hic cum corrupti. Repudiandae aliquam perferendis vero reiciendis fugit dolores fugiat.',0,0,'asset',0),(5,'Culpa earum rerum.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Et natus nostrum aut aperiam sit soluta dolorem. Alias eum cumque dolores qui velit aliquid assumenda. Quo quia rerum omnis ducimus itaque.',0,1,'asset',0),(6,'Est ad id veniam.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Sapiente minus dolorem qui doloremque unde. Perferendis dignissimos qui nobis dolores aspernatur et. Ad ut eum eos quis voluptatem omnis.',0,1,'asset',0),(7,'Nulla commodi nobis.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Illo quam ut consequatur quo. Non quaerat sit esse quisquam aut omnis veniam autem.',0,1,'asset',1),(8,'Maxime illo quidem.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Est labore quia enim dolores autem eligendi sit. Nisi et voluptatem id praesentium. Vitae repellendus natus suscipit provident quasi non. Doloremque hic ut voluptatem dolore corrupti nihil. Et qui est iure ut voluptatem eos.',0,0,'asset',1),(9,'Dolorum ut.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Temporibus et ullam doloribus. Doloribus debitis voluptas aut et enim. Dolorem corporis cumque nulla nihil laudantium eum corrupti.',0,0,'asset',0),(10,'Repellat sed sequi.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'Animi non omnis aut perferendis architecto. Dolores earum non voluptas voluptas nostrum quis aut. Et cumque non perspiciatis facere maiores quis similique. Accusantium eum perspiciatis ut doloribus quia ut.',0,0,'asset',0),(11,'Placeat sequi nulla.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,NULL,0,0,'accessory',0),(12,'Doloribus rem quod.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,NULL,0,0,'accessory',0),(13,'Ea exercitationem.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,NULL,0,0,'accessory',0),(14,'Temporibus rerum.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,NULL,0,0,'accessory',0),(15,'Molestiae quam.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,NULL,0,0,'accessory',0),(16,'Deserunt ex ducimus.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'consumable',0),(17,'Perspiciatis quas.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'consumable',0),(18,'Nobis tempora.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'consumable',0),(19,'Reiciendis tempora.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'consumable',0),(20,'Qui sapiente.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'consumable',0),(21,'Molestiae quia.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'component',0),(22,'Vero quos sapiente.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'component',0),(23,'Architecto dicta.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'component',0),(24,'Voluptatem et aut.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'component',0),(25,'Delectus iusto.','2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,NULL,NULL,0,0,'component',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Witting-Lynch','2016-12-19 21:50:31','2016-12-19 21:50:31'),(2,'Rippin, Muller and Luettgen','2016-12-19 21:50:31','2016-12-19 21:50:31'),(3,'Harber LLC','2016-12-19 21:50:31','2016-12-19 21:50:31'),(4,'Ortiz, Corwin and Howe','2016-12-19 21:50:31','2016-12-19 21:50:31'),(5,'Abernathy-Hagenes','2016-12-19 21:50:31','2016-12-19 21:50:31'),(6,'Sipes-Bruen','2016-12-19 21:50:31','2016-12-19 21:50:31'),(7,'Marquardt-Maggio','2016-12-19 21:50:31','2016-12-19 21:50:31'),(8,'Bayer-Mohr','2016-12-19 21:50:31','2016-12-19 21:50:31'),(9,'Kuhlman-Dickinson','2016-12-19 21:50:31','2016-12-19 21:50:31'),(10,'Bergnaum, Lesch and White','2016-12-19 21:50:31','2016-12-19 21:50:31'),(11,'Heller-Ritchie','2016-12-19 21:50:31','2016-12-19 21:50:31'),(12,'Nicolas Ltd','2016-12-19 21:50:31','2016-12-19 21:50:31'),(13,'Kiehn-Tillman','2016-12-19 21:50:31','2016-12-19 21:50:31'),(14,'Schulist PLC','2016-12-19 21:50:31','2016-12-19 21:50:31');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `components`
--

LOCK TABLES `components` WRITE;
/*!40000 ALTER TABLE `components` DISABLE KEYS */;
INSERT INTO `components` VALUES (1,'Quo accusantium.',25,3,14,NULL,6,'5276113','1982-10-01',146570010.65,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,1,'97446409-3f8a-3cfd-a0c2-f3b41e635e4e'),(2,'Nemo aperiam.',22,5,2,NULL,3,'13119731','1978-05-14',2.92,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,1,'d719a64b-3efc-3ec3-a9ab-b4f2c92e608a'),(3,'Dolore quia nobis.',24,4,2,NULL,4,'18938355','1977-11-30',30.00,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,1,'a628f55b-dd07-3312-bc50-9ec914edf380'),(4,'Qui eligendi et.',22,2,12,NULL,5,'46656548','1980-10-12',1.01,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,1,'d0dbbeab-b199-380c-b1ce-1ffad2b96a6b'),(5,'Doloribus explicabo.',25,1,3,NULL,9,'28269151','1996-01-08',208.29,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,1,'93f6e95d-caf0-3fbe-bbf7-9de557d809bc'),(6,'Rerum et expedita.',21,1,13,NULL,9,'31787294','1974-12-14',169.40,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,2,'3cfdbe64-af6f-3cf6-b8fb-ba56c2d04ce0'),(7,'Ut placeat nam.',23,3,6,NULL,6,'14635326','1981-09-28',136.38,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,2,'c39f550a-5188-3f45-916c-1429007e7fd4'),(8,'Assumenda nostrum.',25,3,12,NULL,9,'30435102','1971-09-25',675467.29,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,1,'0725a57c-b77d-3789-8416-5073cb4f68b8'),(9,'Cupiditate deserunt.',23,4,4,NULL,10,'41401814','1988-12-22',1.72,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,2,'64fd4267-ca2f-32aa-bedb-65b7c3de2efa'),(10,'Quaerat possimus ad.',21,2,11,NULL,6,'26163775','2007-02-11',29839.13,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,2,'ff1a4866-5da6-3b0d-ab63-0efce06899c9');
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumables`
--

LOCK TABLES `consumables` WRITE;
/*!40000 ALTER TABLE `consumables` DISABLE KEYS */;
INSERT INTO `consumables` VALUES (1,'Dolorem autem.',17,NULL,NULL,5,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2016-02-16',507.15,'6976392',2,2,'13465702',NULL,'13353410'),(2,'Fugiat enim labore.',17,NULL,NULL,6,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1996-11-07',21517.73,'9509607',4,1,'32881375',NULL,'30455104'),(3,'Ullam quia dolores.',18,NULL,NULL,9,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1999-11-15',54896.12,'40573251',12,1,'21988042',NULL,'18057084'),(4,'Sunt odit atque.',18,NULL,NULL,7,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1985-04-22',690129.28,'43303406',1,2,'49636820',NULL,'25536611'),(5,'Quam incidunt.',20,NULL,NULL,9,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1971-12-19',2426969.19,'21877507',11,1,'32460677',NULL,'22811534'),(6,'Provident non.',19,NULL,NULL,6,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2011-03-25',167.90,'8853497',6,2,'40203583',NULL,'16006812'),(7,'Nostrum rerum est.',19,NULL,NULL,6,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1975-01-15',230401243.30,'9379535',2,2,'8727416',NULL,'42504871'),(8,'Nihil at.',20,NULL,NULL,9,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2001-10-15',15556237.79,'17361470',12,2,'10398395',NULL,'25775635'),(9,'Laboriosam qui.',17,NULL,NULL,6,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1976-03-20',653032741.28,'41913675',12,2,'24295643',NULL,'41812753'),(10,'Enim illum culpa.',20,NULL,NULL,10,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2006-08-14',110117.47,'26935159',7,2,'30738784',NULL,'36229625'),(11,'Eum commodi eum.',18,NULL,NULL,7,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2011-04-18',27.01,'24450060',14,2,'42782151',NULL,'43116946'),(12,'Voluptatem et esse.',18,NULL,NULL,7,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1987-04-22',18.70,'24071954',2,2,'46802751',NULL,'46411285'),(13,'Commodi ipsum.',17,NULL,NULL,10,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1994-06-15',0.35,'4457969',13,1,'20065743',NULL,'21985297'),(14,'Suscipit aut sed.',20,NULL,NULL,6,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1991-02-10',4812.52,'46912386',5,1,'4471192',NULL,'22201553'),(15,'Iste eos ipsum.',20,NULL,NULL,8,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2001-10-05',86.31,'3290625',14,1,'46937674',NULL,'44510259'),(16,'Ut unde dolores.',16,NULL,NULL,6,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1975-06-29',58.32,'33777371',4,1,'46549686',NULL,'11400310'),(17,'Ea vel ea.',18,NULL,NULL,5,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1980-09-08',561914353.65,'16006671',6,2,'32826525',NULL,'8161568'),(18,'Et dolorem aut.',19,NULL,NULL,10,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2013-02-10',1.37,'24984050',6,1,'22532772',NULL,'34330878'),(19,'Atque aperiam.',20,NULL,NULL,9,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2009-06-19',382.24,'23722665',4,1,'5598352',NULL,'49367661'),(20,'Quam sit porro.',16,NULL,NULL,5,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2005-05-02',38.16,'48727140',10,1,'36765531',NULL,'44519233'),(21,'Voluptas soluta.',18,NULL,NULL,5,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1976-01-06',2717.80,'43854143',8,1,'16609710',NULL,'17357462'),(22,'Asperiores eum.',20,NULL,NULL,7,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2006-09-16',3.43,'5570944',9,1,'2701249',NULL,'13455708'),(23,'Aliquam sunt at aut.',17,NULL,NULL,6,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2004-04-11',1.52,'37111882',3,2,'11437542',NULL,'10192323'),(24,'Autem autem fuga.',20,NULL,NULL,9,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'2014-03-10',9351.93,'34134586',14,1,'34320514',NULL,'9872607'),(25,'Ratione qui enim.',19,NULL,NULL,10,0,'2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,'1998-08-17',697456.72,'13809747',13,1,'17918268',NULL,'17347142');
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
  `field_values` text COLLATE utf8_unicode_ci,
  `field_encrypted` tinyint(1) NOT NULL DEFAULT '0',
  `db_column` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `help_text` text COLLATE utf8_unicode_ci,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `depreciations`
--

LOCK TABLES `depreciations` WRITE;
/*!40000 ALTER TABLE `depreciations` DISABLE KEYS */;
INSERT INTO `depreciations` VALUES (1,'Excepturi eius.',6,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL);
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
-- Table structure for table `imports`
--

DROP TABLE IF EXISTS `imports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filesize` int(11) NOT NULL,
  `import_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imports`
--

LOCK TABLES `imports` WRITE;
/*!40000 ALTER TABLE `imports` DISABLE KEYS */;
/*!40000 ALTER TABLE `imports` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `license_seats`
--

LOCK TABLES `license_seats` WRITE;
/*!40000 ALTER TABLE `license_seats` DISABLE KEYS */;
INSERT INTO `license_seats` VALUES (1,7,NULL,'Eum quam aut quia ab fugiat officiis.',1,'1979-04-17 02:53:27','1998-10-18 20:04:38',NULL,NULL),(2,1,NULL,'Blanditiis minima dolorum sed tenetur molestias.',1,'2012-05-20 16:59:26','1970-04-13 02:45:39',NULL,NULL),(3,6,NULL,'Consequatur suscipit debitis occaecati quo sunt vel qui vel.',1,'2012-03-08 05:56:23','2014-08-27 08:05:06',NULL,NULL),(4,1,NULL,'Molestiae repellendus tempore laudantium architecto non.',1,'1976-03-28 12:49:56','2013-02-20 02:58:00',NULL,NULL),(5,7,NULL,'Doloribus ratione officiis error eum eum magnam.',1,'1983-04-26 01:44:32','1975-08-27 11:45:27',NULL,NULL),(6,5,NULL,'Omnis libero nobis recusandae rerum possimus.',1,'1993-08-09 04:40:13','1989-05-15 13:53:39',NULL,NULL),(7,4,NULL,'Repudiandae perspiciatis pariatur at blanditiis.',1,'2016-11-24 21:08:57','1985-06-29 02:24:14',NULL,NULL),(8,1,NULL,'Rerum aut itaque ut est.',1,'1990-06-25 14:12:00','1990-12-09 10:53:53',NULL,NULL),(9,9,NULL,'Amet provident suscipit similique ducimus repudiandae nobis beatae.',1,'2009-08-07 14:18:58','2010-08-13 10:44:43',NULL,NULL),(10,7,NULL,'Vero facilis molestiae occaecati iure.',1,'2015-03-27 06:46:55','1989-10-16 06:21:40',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licenses`
--

LOCK TABLES `licenses` WRITE;
/*!40000 ALTER TABLE `licenses` DISABLE KEYS */;
INSERT INTO `licenses` VALUES (1,'Managed human-resource data-warehouse','922a477b-5b45-3ed6-874c-0e7de14c1881','1982-06-12',499979278.31,'12058',9,'Modi et vel cum aspernatur totam.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Samir Zboncak','shaylee30@example.org',NULL,1,NULL,'7160',NULL,NULL,1,3,NULL),(2,'Reverse-engineered neutral opensystem','c73e659c-4f0d-3068-ac19-fc8b2b19ecf9','2008-08-30',4805486.18,'6378',1,'Voluptatum veritatis non et iusto reprehenderit et sit.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Mrs. Luna Kreiger DVM','carter.tad@example.net',NULL,5,NULL,'6376',NULL,NULL,1,8,NULL),(3,'Horizontal uniform complexity','fa785f96-b3c8-3193-a711-7bc1efedd170','1987-04-21',260263734.84,'3005',4,'Officia cumque quia quas quos omnis ab.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Vergie Vandervort','opowlowski@example.net',NULL,3,NULL,'11274',NULL,NULL,1,13,NULL),(4,'Ergonomic didactic conglomeration','ec6ef12c-b410-3049-a67e-ad347cfafde8','1980-08-12',543563363.20,'8633',9,'Et fugiat architecto ut exercitationem ut aliquam ratione.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Fiona Zieme','kip.aufderhar@example.org',NULL,2,NULL,'3138',NULL,NULL,1,6,NULL),(5,'Virtual discrete hierarchy','9e9a0f16-7112-3520-94ef-4ea35f5fee91','1993-11-28',80.01,'3054',1,'Unde error illo animi.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Toy Mohr','brenda24@example.com',NULL,5,NULL,'8272',NULL,NULL,1,7,NULL),(6,'Vision-oriented client-driven hierarchy','507a0df7-bed3-3d11-aa6a-276f196314b8','2009-03-19',389822553.07,'1773',9,'Atque amet quia quas consequatur ea.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Hadley Reynolds','deckow.dino@example.com',NULL,4,NULL,'1720',NULL,NULL,1,14,NULL),(7,'Customer-focused tertiary standardization','4986e730-2f34-33da-8dcb-48797f7cb264','2010-08-15',55988090.42,'1889',9,'Voluptas beatae repellat quia.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Dr. Casper Grimes Jr.','yessenia.buckridge@example.org',NULL,1,NULL,'8278',NULL,NULL,1,6,NULL),(8,'Sharable contextually-based framework','2bca5bc2-b157-365a-84b3-d26d36a433a6','1988-08-31',458496.90,'12951',1,'Vel suscipit consequatur non exercitationem beatae facilis.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Prof. Ashton Wiza','mmonahan@example.net',NULL,5,NULL,'9662',NULL,NULL,1,3,NULL),(9,'Compatible user-facing securedline','a8f1eb71-a815-3548-81b1-07dfc6539365','2012-02-10',20240139.56,'10135',10,'Nihil consequatur et itaque.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Mr. Garett Wuckert','thartmann@example.net',NULL,3,NULL,'10645',NULL,NULL,1,5,NULL),(10,'Implemented upward-trending initiative','58ebb089-8c77-3adc-ac4e-7c557ebca861','1980-12-21',212.73,'7550',10,'Et et molestiae recusandae facere.',NULL,NULL,'2016-12-19 21:50:33','2016-12-19 21:50:33',NULL,'Dr. Jada Dach','ulices69@example.com',NULL,3,NULL,'2130',NULL,NULL,1,1,NULL);
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
  `ldap_ou` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Multi-lateral 24hour hub','North Llewellyn','IN','BJ','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,'13212 Schmidt Extensions Suite 682','Apt. 456','67559',NULL,NULL,'TWD',NULL,NULL),(2,'Streamlined value-added firmware','East Johnathonville','IL','BS','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,'9429 Koch Village','Suite 789','51112-9226',NULL,NULL,'TTD',NULL,NULL),(3,'Persistent asynchronous frame','New Delphaside','AK','LR','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,'7600 Howell Valleys Apt. 730','Suite 939','26693',NULL,NULL,'JPY',NULL,NULL),(4,'Inverse optimal array','Port Laura','DE','SC','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,'9542 Cronin Crescent Apt. 550','Suite 792','56208-6621',NULL,NULL,'SYP',NULL,NULL),(5,'Networked zeroadministration standardization','Paucekfort','FL','MZ','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,'187 Gerhold Harbor Suite 314','Suite 620','68500',NULL,NULL,'CLF',NULL,NULL);
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
  `url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `support_url` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `support_phone` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `support_email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manufacturers`
--

LOCK TABLES `manufacturers` WRITE;
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;
INSERT INTO `manufacturers` VALUES (1,'Hansen and Sons','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL),(2,'Walker-Kiehn','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL),(3,'Crooks, Mante and Cruickshank','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL),(4,'Larson and Sons','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL),(5,'Koss Ltd','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL),(6,'Bruen-Adams','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL),(7,'Smith LLC','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL),(8,'Johnston, Cummings and Blanda','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL),(9,'Welch and Sons','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL),(10,'Raynor Ltd','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `manufacturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2012_12_06_225921_migration_cartalyst_sentry_install_users',1),(2,'2012_12_06_225929_migration_cartalyst_sentry_install_groups',1),(3,'2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot',1),(4,'2012_12_06_225988_migration_cartalyst_sentry_install_throttle',1),(5,'2013_03_23_193214_update_users_table',1),(6,'2013_11_13_075318_create_models_table',1),(7,'2013_11_13_075335_create_categories_table',1),(8,'2013_11_13_075347_create_manufacturers_table',1),(9,'2013_11_15_015858_add_user_id_to_categories',1),(10,'2013_11_15_112701_add_user_id_to_manufacturers',1),(11,'2013_11_15_190327_create_assets_table',1),(12,'2013_11_15_190357_create_licenses_table',1),(13,'2013_11_15_201848_add_license_name_to_licenses',1),(14,'2013_11_16_040323_create_depreciations_table',1),(15,'2013_11_16_042851_add_depreciation_id_to_models',1),(16,'2013_11_16_084923_add_user_id_to_models',1),(17,'2013_11_16_103258_create_locations_table',1),(18,'2013_11_16_103336_add_location_id_to_assets',1),(19,'2013_11_16_103407_add_checkedout_to_to_assets',1),(20,'2013_11_16_103425_create_history_table',1),(21,'2013_11_17_054359_drop_licenses_table',1),(22,'2013_11_17_054526_add_physical_to_assets',1),(23,'2013_11_17_055126_create_settings_table',1),(24,'2013_11_17_062634_add_license_to_assets',1),(25,'2013_11_18_134332_add_contacts_to_users',1),(26,'2013_11_18_142847_add_info_to_locations',1),(27,'2013_11_18_152942_remove_location_id_from_asset',1),(28,'2013_11_18_164423_set_nullvalues_for_user',1),(29,'2013_11_19_013337_create_asset_logs_table',1),(30,'2013_11_19_061409_edit_added_on_asset_logs_table',1),(31,'2013_11_19_062250_edit_location_id_asset_logs_table',1),(32,'2013_11_20_055822_add_soft_delete_on_assets',1),(33,'2013_11_20_121404_add_soft_delete_on_locations',1),(34,'2013_11_20_123137_add_soft_delete_on_manufacturers',1),(35,'2013_11_20_123725_add_soft_delete_on_categories',1),(36,'2013_11_20_130248_create_status_labels',1),(37,'2013_11_20_130830_add_status_id_on_assets_table',1),(38,'2013_11_20_131544_add_status_type_on_status_labels',1),(39,'2013_11_20_134103_add_archived_to_assets',1),(40,'2013_11_21_002321_add_uploads_table',1),(41,'2013_11_21_024531_remove_deployable_boolean_from_status_labels',1),(42,'2013_11_22_075308_add_option_label_to_settings_table',1),(43,'2013_11_22_213400_edits_to_settings_table',1),(44,'2013_11_25_013244_create_licenses_table',1),(45,'2013_11_25_031458_create_license_seats_table',1),(46,'2013_11_25_032022_add_type_to_actionlog_table',1),(47,'2013_11_25_033008_delete_bad_licenses_table',1),(48,'2013_11_25_033131_create_new_licenses_table',1),(49,'2013_11_25_033534_add_licensed_to_licenses_table',1),(50,'2013_11_25_101308_add_warrantee_to_assets_table',1),(51,'2013_11_25_104343_alter_warranty_column_on_assets',1),(52,'2013_11_25_150450_drop_parent_from_categories',1),(53,'2013_11_25_151920_add_depreciate_to_assets',1),(54,'2013_11_25_152903_add_depreciate_to_licenses_table',1),(55,'2013_11_26_211820_drop_license_from_assets_table',1),(56,'2013_11_27_062510_add_note_to_asset_logs_table',1),(57,'2013_12_01_113426_add_filename_to_asset_log',1),(58,'2013_12_06_094618_add_nullable_to_licenses_table',1),(59,'2013_12_10_084038_add_eol_on_models_table',1),(60,'2013_12_12_055218_add_manager_to_users_table',1),(61,'2014_01_28_031200_add_qr_code_to_settings_table',1),(62,'2014_02_13_183016_add_qr_text_to_settings_table',1),(63,'2014_05_24_093839_alter_default_license_depreciation_id',1),(64,'2014_05_27_231658_alter_default_values_licenses',1),(65,'2014_06_19_191508_add_asset_name_to_settings',1),(66,'2014_06_20_004847_make_asset_log_checkedout_to_nullable',1),(67,'2014_06_20_005050_make_asset_log_purchasedate_to_nullable',1),(68,'2014_06_24_003011_add_suppliers',1),(69,'2014_06_24_010742_add_supplier_id_to_asset',1),(70,'2014_06_24_012839_add_zip_to_supplier',1),(71,'2014_06_24_033908_add_url_to_supplier',1),(72,'2014_07_08_054116_add_employee_id_to_users',1),(73,'2014_07_09_134316_add_requestable_to_assets',1),(74,'2014_07_17_085822_add_asset_to_software',1),(75,'2014_07_17_161625_make_asset_id_in_logs_nullable',1),(76,'2014_08_12_053504_alpha_0_4_2_release',1),(77,'2014_08_17_083523_make_location_id_nullable',1),(78,'2014_10_16_200626_add_rtd_location_to_assets',1),(79,'2014_10_24_000417_alter_supplier_state_to_32',1),(80,'2014_10_24_015641_add_display_checkout_date',1),(81,'2014_10_28_222654_add_avatar_field_to_users_table',1),(82,'2014_10_29_045924_add_image_field_to_models_table',1),(83,'2014_11_01_214955_add_eol_display_to_settings',1),(84,'2014_11_04_231416_update_group_field_for_reporting',1),(85,'2014_11_05_212408_add_fields_to_licenses',1),(86,'2014_11_07_021042_add_image_to_supplier',1),(87,'2014_11_20_203007_add_username_to_user',1),(88,'2014_11_20_223947_add_auto_to_settings',1),(89,'2014_11_20_224421_add_prefix_to_settings',1),(90,'2014_11_21_104401_change_licence_type',1),(91,'2014_12_09_082500_add_fields_maintained_term_to_licenses',1),(92,'2015_02_04_155757_increase_user_field_lengths',1),(93,'2015_02_07_013537_add_soft_deleted_to_log',1),(94,'2015_02_10_040958_fix_bad_assigned_to_ids',1),(95,'2015_02_10_053310_migrate_data_to_new_statuses',1),(96,'2015_02_11_044104_migrate_make_license_assigned_null',1),(97,'2015_02_11_104406_migrate_create_requests_table',1),(98,'2015_02_12_001312_add_mac_address_to_asset',1),(99,'2015_02_12_024100_change_license_notes_type',1),(100,'2015_02_17_231020_add_localonly_to_settings',1),(101,'2015_02_19_222322_add_logo_and_colors_to_settings',1),(102,'2015_02_24_072043_add_alerts_to_settings',1),(103,'2015_02_25_022931_add_eula_fields',1),(104,'2015_02_25_204513_add_accessories_table',1),(105,'2015_02_26_091228_add_accessories_user_table',1),(106,'2015_02_26_115128_add_deleted_at_models',1),(107,'2015_02_26_233005_add_category_type',1),(108,'2015_03_01_231912_update_accepted_at_to_acceptance_id',1),(109,'2015_03_05_011929_add_qr_type_to_settings',1),(110,'2015_03_18_055327_add_note_to_user',1),(111,'2015_04_29_234704_add_slack_to_settings',1),(112,'2015_05_04_085151_add_parent_id_to_locations_table',1),(113,'2015_05_22_124421_add_reassignable_to_licenses',1),(114,'2015_06_10_003314_fix_default_for_user_notes',1),(115,'2015_06_10_003554_create_consumables',1),(116,'2015_06_15_183253_move_email_to_username',1),(117,'2015_06_23_070346_make_email_nullable',1),(118,'2015_06_26_213716_create_asset_maintenances_table',1),(119,'2015_07_04_212443_create_custom_fields_table',1),(120,'2015_07_09_014359_add_currency_to_settings_and_locations',1),(121,'2015_07_21_122022_add_expected_checkin_date_to_asset_logs',1),(122,'2015_07_24_093845_add_checkin_email_to_category_table',1),(123,'2015_07_25_055415_remove_email_unique_constraint',1),(124,'2015_07_29_230054_add_thread_id_to_asset_logs_table',1),(125,'2015_07_31_015430_add_accepted_to_assets',1),(126,'2015_09_09_195301_add_custom_css_to_settings',1),(127,'2015_09_21_235926_create_custom_field_custom_fieldset',1),(128,'2015_09_22_000104_create_custom_fieldsets',1),(129,'2015_09_22_003321_add_fieldset_id_to_assets',1),(130,'2015_09_22_003413_migrate_mac_address',1),(131,'2015_09_28_003314_fix_default_purchase_order',1),(132,'2015_10_01_024551_add_accessory_consumable_price_info',1),(133,'2015_10_12_192706_add_brand_to_settings',1),(134,'2015_10_22_003314_fix_defaults_accessories',1),(135,'2015_10_23_182625_add_checkout_time_and_expected_checkout_date_to_assets',1),(136,'2015_11_05_061015_create_companies_table',1),(137,'2015_11_05_061115_add_company_id_to_consumables_table',1),(138,'2015_11_05_183749_image',1),(139,'2015_11_06_092038_add_company_id_to_accessories_table',1),(140,'2015_11_06_100045_add_company_id_to_users_table',1),(141,'2015_11_06_134742_add_company_id_to_licenses_table',1),(142,'2015_11_08_035832_add_company_id_to_assets_table',1),(143,'2015_11_08_222305_add_ldap_fields_to_settings',1),(144,'2015_11_15_151803_add_full_multiple_companies_support_to_settings_table',1),(145,'2015_11_26_195528_import_ldap_settings',1),(146,'2015_11_30_191504_remove_fk_company_id',1),(147,'2015_12_21_193006_add_ldap_server_cert_ignore_to_settings_table',1),(148,'2015_12_30_233509_add_timestamp_and_userId_to_custom_fields',1),(149,'2015_12_30_233658_add_timestamp_and_userId_to_custom_fieldsets',1),(150,'2016_01_28_041048_add_notes_to_models',1),(151,'2016_02_19_070119_add_remember_token_to_users_table',1),(152,'2016_02_19_073625_create_password_resets_table',1),(153,'2016_03_02_193043_add_ldap_flag_to_users',1),(154,'2016_03_02_220517_update_ldap_filter_to_longer_field',1),(155,'2016_03_08_225351_create_components_table',1),(156,'2016_03_09_024038_add_min_stock_to_tables',1),(157,'2016_03_10_133849_add_locale_to_users',1),(158,'2016_03_10_135519_add_locale_to_settings',1),(159,'2016_03_11_185621_add_label_settings_to_settings',1),(160,'2016_03_22_125911_fix_custom_fields_regexes',1),(161,'2016_04_28_141554_add_show_to_users',1),(162,'2016_05_16_164733_add_model_mfg_to_consumable',1),(163,'2016_05_19_180351_add_alt_barcode_settings',1),(164,'2016_05_19_191146_add_alter_interval',1),(165,'2016_05_19_192226_add_inventory_threshold',1),(166,'2016_05_20_024859_remove_option_keys_from_settings_table',1),(167,'2016_05_20_143758_remove_option_value_from_settings_table',1),(168,'2016_06_01_000001_create_oauth_auth_codes_table',1),(169,'2016_06_01_000002_create_oauth_access_tokens_table',1),(170,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(171,'2016_06_01_000004_create_oauth_clients_table',1),(172,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(173,'2016_06_01_140218_add_email_domain_and_format_to_settings',1),(174,'2016_06_22_160725_add_user_id_to_maintenances',1),(175,'2016_07_13_150015_add_is_ad_to_settings',1),(176,'2016_07_14_153609_add_ad_domain_to_settings',1),(177,'2016_07_22_003348_fix_custom_fields_regex_stuff',1),(178,'2016_07_22_054850_one_more_mac_addr_fix',1),(179,'2016_07_22_143045_add_port_to_ldap_settings',1),(180,'2016_07_22_153432_add_tls_to_ldap_settings',1),(181,'2016_07_27_211034_add_zerofill_to_settings',1),(182,'2016_08_02_124944_add_color_to_statuslabel',1),(183,'2016_08_04_134500_add_disallow_ldap_pw_sync_to_settings',1),(184,'2016_08_09_002225_add_manufacturer_to_licenses',1),(185,'2016_08_12_121613_add_manufacturer_to_accessories_table',1),(186,'2016_08_23_143353_add_new_fields_to_custom_fields',1),(187,'2016_08_23_145619_add_show_in_nav_to_status_labels',1),(188,'2016_08_30_084634_make_purchase_cost_nullable',1),(189,'2016_09_01_141051_add_requestable_to_asset_model',1),(190,'2016_09_02_001448_create_checkout_requests_table',1),(191,'2016_09_04_180400_create_actionlog_table',1),(192,'2016_09_04_182149_migrate_asset_log_to_action_log',1),(193,'2016_09_19_235935_fix_fieldtype_for_target_type',1),(194,'2016_09_23_140722_fix_modelno_in_consumables_to_string',1),(195,'2016_09_28_231359_add_company_to_logs',1),(196,'2016_10_14_130709_fix_order_number_to_varchar',1),(197,'2016_10_16_015024_rename_modelno_to_model_number',1),(198,'2016_10_16_015211_rename_consumable_modelno_to_model_number',1),(199,'2016_10_16_143235_rename_model_note_to_notes',1),(200,'2016_10_16_165052_rename_component_total_qty_to_qty',1),(201,'2016_10_19_145520_fix_order_number_in_components_to_string',1),(202,'2016_10_27_151715_add_serial_to_components',1),(203,'2016_10_27_213251_increase_serial_field_capacity',1),(204,'2016_10_29_002724_enable_2fa_fields',1),(205,'2016_10_29_082408_add_signature_to_acceptance',1),(206,'2016_11_01_030818_fix_forgotten_filename_in_action_logs',1),(207,'2016_11_13_020954_rename_component_serial_number_to_serial',1),(208,'2016_11_16_172119_increase_purchase_cost_size',1),(209,'2016_11_17_161317_longer_state_field_in_location',1),(210,'2016_11_17_193706_add_model_number_to_accessories',1),(211,'2016_11_24_160405_add_missing_target_type_to_logs_table',1),(212,'2016_12_07_173720_increase_size_of_state_in_suppliers',1),(213,'2016_12_19_004212_adjust_locale_length_to_10',1),(214,'2016_12_19_133936_extend_phone_lengths_in_supplier_and_elsewhere',1),(215,'2016_12_27_212631_make_asset_assigned_to_polymorphic',2),(216,'2017_01_09_040429_create_locations_ldap_query_field',3),(217,'2017_01_14_002418_create_imports_table',3),(218,'2017_01_25_063357_fix_utf8_custom_field_column_names',3),(219,'2017_03_03_154632_add_time_date_display_to_settings',3),(220,'2017_03_10_210807_add_fields_to_manufacturer',3),(221,'2017_05_08_195520_increase_size_of_field_values_in_custom_fields',4),(222,'2017_05_22_233509_add_manager_to_locations_table',4);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
INSERT INTO `models` VALUES (1,'Customer-focused secondary capability','18707983',9,6,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,1,NULL,0,NULL,NULL,'Doloribus in consequatur minima eum tempore nobis. Id ipsam eaque non dicta. Recusandae aut eaque voluptatem voluptas consequatur maiores. Quia saepe impedit beatae sed laborum.',1),(2,'Enhanced tertiary functionalities','47351031',10,4,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,1,NULL,0,NULL,NULL,'Sunt ut consequatur exercitationem voluptatem voluptatum laboriosam in. Distinctio molestiae voluptates ut dolores quia rerum. Commodi ducimus sint ut omnis qui. Velit temporibus et temporibus asperiores qui.',0),(3,'Enhanced leadingedge encoding','22262258',6,5,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,1,NULL,0,NULL,NULL,'Voluptate assumenda harum et aliquid esse. Aut enim amet natus consequatur dolores amet fugiat eum. Quis id sed incidunt eveniet fuga. Quasi excepturi quam eaque eveniet qui.',0),(4,'Vision-oriented mission-critical artificialintelligence','37285898',3,4,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,1,NULL,0,NULL,NULL,'Enim quidem qui voluptas. Voluptas nostrum perferendis et ipsum. Voluptate non qui vitae reprehenderit. Eius ipsam non qui ipsam cumque.',1),(5,'Phased client-server instructionset','31964592',5,1,'2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,1,NULL,0,NULL,NULL,'Voluptatem sit officiis dolorem ut est sed. Suscipit ut praesentium aperiam adipisci aut est. Aut nisi nihil officiis optio cumque eveniet. Aut aut minima perspiciatis aut perspiciatis.',0);
/*!40000 ALTER TABLE `models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
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
  `date_display_format` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y-m-d',
  `time_display_format` varchar(191) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'h:i A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'2016-12-19 21:48:55','2016-12-19 21:48:55',1,20,'Test',NULL,NULL,NULL,NULL,NULL,0,'0',1,NULL,NULL,'d@example.com',1,NULL,'QRCODE',NULL,NULL,NULL,'USD',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,'samaccountname','sn','givenname','uid=samaccountname',3,NULL,NULL,NULL,0,0,'en',30,2.62500,1.00000,0.21975,0.21975,0.50000,0.50000,0.07000,0.05000,9,8.50000,11.00000,0,1,1,'C128',1,30,5,'342d','filastname','filastname',0,NULL,'389',0,5,1,NULL,0,'Y-m-d','h:i A');
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
INSERT INTO `status_labels` VALUES (1,'Ready to Deploy',1,'1981-07-19 10:16:27','2007-02-22 00:56:54',NULL,1,0,0,'',NULL,0),(2,'Pending',1,'1995-09-12 10:52:43','2010-04-24 19:45:34',NULL,0,1,0,'Assumenda vero aliquam sapiente corporis consequatur itaque qui.',NULL,0),(3,'Archived',1,'1995-07-03 14:33:27','1983-06-23 03:14:03',NULL,0,0,1,'These assets are permanently undeployable',NULL,0),(4,'Out for Diagnostics',1,'1994-02-16 18:38:00','1990-03-31 03:03:17',NULL,0,0,0,'',NULL,0),(5,'Out for Repair',1,'1997-12-28 18:07:43','1983-08-31 06:02:37',NULL,0,0,0,'',NULL,0),(6,'Broken - Not Fixable',1,'2015-01-17 21:10:49','1986-01-14 14:40:53',NULL,0,0,1,'',NULL,0),(7,'Lost/Stolen',1,'2009-01-30 14:33:33','2002-11-23 10:32:40',NULL,0,0,1,'',NULL,0);
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
  `state` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Corkery-Moore','30665 Lucinda Divide','Suite 776','Avismouth','WI','TR','1-717-505-1802','(591) 370-8443 x4472','swaniawski.abbigail@example.org','Araceli Murphy','Voluptatibus sed exercitationem laboriosam quo. Laudantium deserunt rerum mollitia ut quia deleniti ducimus. Temporibus dolores voluptatum aut non labore. Magni voluptate nulla laboriosam possimus. Ut unde et ipsam.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'60788','https://www.goyette.com/quibusdam-et-vel-asperiores-sint',NULL),(2,'Oberbrunner, Williamson and Torp','41780 Wilber Court','Suite 386','Gailborough','KY','BS','1-641-705-0778 x4064','+1.604.605.0292','alaina.gibson@example.org','Miguel Gerlach DVM','Et voluptates quasi recusandae sunt unde labore. Assumenda illum et neque ipsa sint. Officia quo tempore qui odio tempore aut dolorum qui.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'18717','https://www.heaney.biz/quaerat-dolorem-velit-officiis-distinctio-blanditiis',NULL),(3,'Berge Group','425 Shad Ports Apt. 353','Apt. 206','West Wilbertshire','NJ','SH','716-802-5252 x704','(872) 854-6737 x39599','keebler.israel@example.org','Thurman Schroeder','Esse quia amet voluptatem quo ullam est. Modi sed repellat et. Assumenda neque a laboriosam reiciendis. Vel dolores debitis vitae ut. Consequuntur et cumque enim omnis.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'32410','http://effertz.net/',NULL),(4,'Nolan-Hermiston','12352 Toy Crossing Apt. 626','Suite 629','Henriettebury','NM','AM','+1-707-767-4616','667.470.0440 x2062','mabelle49@example.org','Jordi Glover','Optio deserunt laborum voluptatem ad enim. Nemo fuga et dolorem nesciunt voluptatum. Est voluptas consectetur atque tempore blanditiis aliquid. Consequatur nisi voluptas sit ut distinctio.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'97408-0637','http://armstrong.com/pariatur-tempora-eveniet-pariatur-autem-eum-in',NULL),(5,'Hickle-Homenick','6189 Camryn Station Apt. 608','Suite 965','Kesslermouth','OK','SJ','881.747.8278','1-904-341-0049','leopold.conn@example.com','Dr. Fletcher Roberts','Natus nesciunt id qui explicabo omnis quia aliquid. Perferendis aspernatur sit quia nihil similique sint. Ducimus quasi quis rerum laborum. Quae architecto temporibus ratione autem dolores. Qui deleniti molestiae ipsam maxime aut perspiciatis.','2016-12-19 21:50:32','2016-12-19 21:50:32',NULL,NULL,'54046-6614','https://www.oreilly.info/veniam-nihil-ut-odit-quibusdam-sit-molestias',NULL);
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
  `locale` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'en',
  `show_in_list` tinyint(1) NOT NULL DEFAULT '1',
  `two_factor_secret` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `two_factor_enrolled` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_optin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'d@example.com','$2y$10$XkH04QqWoC.IhtnPze3YruWUpu1/9Q80zDJG2FR4mk3CyjrnhkmsW','{\"superuser\":1}',1,NULL,NULL,NULL,NULL,NULL,'test','test','2016-12-19 21:48:55','2016-12-19 21:48:55',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'snipeit',NULL,NULL,'zuY1fNwUa36UV6ufSCgB9HhW06JgwQ7CxPkuZVIajEiPSOAj1DN1wtabmOHy',0,'en',1,NULL,0,0),(2,'bnelson0@cdbaby.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Bonnie',' Nelson','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bnelson0',NULL,NULL,NULL,0,'en',1,NULL,0,0),(3,'jferguson1@state.tx.us','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Judith',' Ferguson','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'jferguson1',NULL,NULL,NULL,0,'en',1,NULL,0,0),(4,'mgibson2@wiley.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Mildred',' Gibson','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'mgibson2',NULL,NULL,NULL,0,'en',1,NULL,0,0),(5,'blee3@quantcast.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Brandon',' Lee','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'blee3',NULL,NULL,NULL,0,'en',1,NULL,0,0),(6,'bpowell4@tuttocitta.it','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Betty',' Powell','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bpowell4',NULL,NULL,NULL,0,'en',1,NULL,0,0),(7,'awheeler5@cocolog-nifty.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Anthony',' Wheeler','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'awheeler5',NULL,NULL,NULL,0,'en',1,NULL,0,0),(8,'dreynolds6@ustream.tv','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Dennis',' Reynolds','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'dreynolds6',NULL,NULL,NULL,0,'en',1,NULL,0,0),(9,'aarnold7@cbc.ca','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Andrea',' Arnold','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'aarnold7',NULL,NULL,NULL,0,'en',1,NULL,0,0),(10,'abutler8@wikia.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Anna',' Butler','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'abutler8',NULL,NULL,NULL,0,'en',1,NULL,0,0),(11,'mbennett9@diigo.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Mark',' Bennett','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'mbennett9',NULL,NULL,NULL,0,'en',1,NULL,0,0),(12,'ewheelera@google.de','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Emily',' Wheeler','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ewheelera',NULL,NULL,NULL,0,'en',1,NULL,0,0),(13,'wfoxb@virginia.edu','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Wanda',' Fox','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'wfoxb',NULL,NULL,NULL,0,'en',1,NULL,0,0),(14,'jgrantd@cpanel.net','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Janet',' Grant','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'jgrantd',NULL,NULL,NULL,0,'en',1,NULL,0,0),(15,'alarsone@tripod.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Antonio',' Larson','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'alarsone',NULL,NULL,NULL,0,'en',1,NULL,0,0),(16,'lpowellf@com.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Lois',' Powell','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'lpowellf',NULL,NULL,NULL,0,'en',1,NULL,0,0),(17,'malleng@com.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Mildred',' Allen','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'malleng',NULL,NULL,NULL,0,'en',1,NULL,0,0),(18,'caustinh@bigcartel.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Clarence',' Austin','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'caustinh',NULL,NULL,NULL,0,'en',1,NULL,0,0),(19,'wchavezi@blogs.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Walter',' Chavez','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'wchavezi',NULL,NULL,NULL,0,'en',1,NULL,0,0),(20,'melliottj@constantcontact.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Marie',' Elliott','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'melliottj',NULL,NULL,NULL,0,'en',1,NULL,0,0),(21,'bfordm@woothemes.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Benjamin',' Ford','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'bfordm',NULL,NULL,NULL,0,'en',1,NULL,0,0),(22,'twarrenn@printfriendly.com','$2y$10$MeHQGBejPHm0YLePHWzISutbekRfGDJ1gKeHAbw6xeEpas0oj5Qsq',NULL,1,NULL,NULL,NULL,NULL,NULL,'Timothy',' Warren','2016-12-19 21:49:34','2016-12-19 21:49:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'twarrenn',NULL,NULL,NULL,0,'en',1,NULL,0,0),(23,'oleta24@example.org','~(T$*jvkgD','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Seamus','Johnston','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'696-391-4397 x7738','voluptatibus',NULL,'30018',NULL,'cwalsh','Dolorem ut sunt enim ipsam et ex aliquid.',5,NULL,0,'es_ES',1,NULL,0,0),(24,'collins.felix@example.net','}mFLoec%d@%8F`\'','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Brooklyn','Kozey','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'298.890.9657 x932','consequatur',NULL,'4377',NULL,'palma.gusikowski','Fugiat quo alias sed illo est aut.',6,NULL,0,'st_LS',1,NULL,0,0),(25,'wallace74@example.com','BU_5GB^m<7QtA3A','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Delores','Glover','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'+1-494-731-3779','adipisci',NULL,'17781',NULL,'sbecker','Repellendus incidunt sit placeat provident id.',7,NULL,0,'ve_ZA',1,NULL,0,0),(26,'alex.ward@example.com','JP%\'2I>XCJH8P','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Olga','Dietrich','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'+1 (606) 203-6612','et',NULL,'18909',NULL,'nbarrows','Totam rerum dolores odit voluptate quasi.',8,NULL,0,'tig_ER',1,NULL,0,0),(27,'abe.greenfelder@example.org','wG*H7xY&QN:WWjh\'iSsG','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Mack','Ebert','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'558.948.8107','natus',NULL,'9036',NULL,'little.archibald','Repellat veniam eligendi occaecati.',9,NULL,0,'lv_LV',1,NULL,0,0),(28,'camila85@example.net','bqR_^Gx&@','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Miller','Bogisich','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'+1-956-557-3228','excepturi',NULL,'4977',NULL,'fern.batz','Autem quidem animi iste maxime vitae laborum vitae.',10,NULL,0,'tt_RU',1,NULL,0,0),(29,'veda.erdman@example.net','~+3v)}y~zZZmj','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Isaiah','Bogan','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'+1-602-935-4426','odit',NULL,'29496',NULL,'ssimonis','Deserunt eius voluptates velit illo dolores sunt ex.',11,NULL,0,'en_US',1,NULL,0,0),(30,'friedrich02@example.com','\'Y/^}J~{v!IN`Fg6','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Lavonne','Parisian','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'(478) 560-1259','quia',NULL,'23923',NULL,'mallie19','Architecto aut rerum modi est tempore et nobis.',12,NULL,0,'ms_MY',1,NULL,0,0),(31,'gerda44@example.net','US*`0L4','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Jeanne','Feest','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'682-498-7097 x96752','aperiam',NULL,'19524',NULL,'jessy12','Dignissimos voluptatum molestiae a velit optio quasi aliquam.',13,NULL,0,'gv_GB',1,NULL,0,0),(32,'clementine06@example.com','OD&VXKe\\','{\"user\":\"0\"}',0,NULL,NULL,NULL,NULL,NULL,'Llewellyn','Lubowitz','2016-12-19 21:50:31','2016-12-19 21:50:31',NULL,NULL,NULL,NULL,NULL,'819.370.6281 x2886','rerum',NULL,'6129',NULL,'fwalsh','Reprehenderit quos porro vitae mollitia ut ipsa rerum.',14,NULL,0,'fil_PH',1,NULL,0,0);
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

-- Dump completed on 2017-10-01 15:36:56
