
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `accessories` WRITE;
/*!40000 ALTER TABLE `accessories` DISABLE KEYS */;
INSERT INTO `accessories` VALUES (1,'Flatley-Terry',12,NULL,2,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,4,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (2,'Pfannerstill, Schmidt and Franecki',13,NULL,5,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,2,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (3,'Lebsack Ltd',13,NULL,4,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,2,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (4,'O\'Keefe Group',15,NULL,10,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,4,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (5,'Hilpert and Sons',14,NULL,10,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,3,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (6,'Donnelly, Wiegand and Wiegand',14,NULL,4,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,3,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (7,'Boehm, Wiza and Sanford',11,NULL,10,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,5,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (8,'Schuster, Brown and Weimann',12,NULL,10,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,3,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (9,'Swaniawski, Weimann and Sawayn',13,NULL,7,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,1,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (10,'Daugherty Group',12,NULL,2,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,3,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (11,'Fadel LLC',13,NULL,3,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,1,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (12,'Schneider, Pfeffer and Kunde',12,NULL,2,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,2,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (13,'Erdman LLC',13,NULL,1,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,5,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (14,'Boyle, Kreiger and Schroeder',14,NULL,3,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,4,NULL,NULL,NULL,NULL);
INSERT INTO `accessories` VALUES (15,'Swaniawski Ltd',14,NULL,3,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `accessories` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `accessories_users` WRITE;
/*!40000 ALTER TABLE `accessories_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `accessories_users` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `asset_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `checkedout_to` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `asset_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `filename` text COLLATE utf8_unicode_ci,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `requested_at` datetime DEFAULT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `accessory_id` int(11) DEFAULT NULL,
  `accepted_id` int(11) DEFAULT NULL,
  `consumable_id` int(11) DEFAULT NULL,
  `expected_checkin` date DEFAULT NULL,
  `thread_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asset_logs_thread_id_index` (`thread_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `asset_logs` WRITE;
/*!40000 ALTER TABLE `asset_logs` DISABLE KEYS */;
INSERT INTO `asset_logs` VALUES (1,1,'checkout',10,1,NULL,'2013-10-09 19:33:05','hardware','Soluta rerum aut dolor aut itaque non.',NULL,'2016-02-23 22:11:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `asset_logs` VALUES (2,1,'checkout',4,1,NULL,'1992-01-23 12:31:58','hardware','Unde error impedit voluptatem ut.',NULL,'2016-02-23 22:11:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `asset_logs` VALUES (3,1,'checkout',3,1,NULL,'1988-02-17 01:43:35','hardware','Nemo praesentium ut pariatur et iusto.',NULL,'2016-02-23 22:11:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `asset_logs` VALUES (4,1,'checkout',4,1,NULL,'1999-07-25 07:48:42','hardware','Natus eveniet suscipit impedit repellat nam consequuntur.',NULL,'2016-02-23 22:11:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `asset_logs` VALUES (5,1,'checkout',7,1,NULL,'1987-08-10 13:20:31','hardware','Molestiae voluptatibus sunt pariatur ea omnis eos tenetur.',NULL,'2016-02-23 22:11:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `asset_logs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `asset_maintenances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_maintenances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL,
  `supplier_id` int(10) unsigned NOT NULL,
  `asset_maintenance_type` enum('Maintenance','Repair','Upgrade') COLLATE utf8_unicode_ci NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `asset_maintenances` WRITE;
/*!40000 ALTER TABLE `asset_maintenances` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset_maintenances` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `asset_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `asset_id` int(11) NOT NULL,
  `filenotes` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `asset_uploads` WRITE;
/*!40000 ALTER TABLE `asset_uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset_uploads` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `asset_tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` int(11) NOT NULL,
  `serial` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(13,4) NOT NULL DEFAULT '0.0000',
  `order_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `image` text COLLATE utf8_unicode_ci,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `physical` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `warranty_months` int(3) DEFAULT NULL,
  `depreciate` tinyint(1) NOT NULL DEFAULT '0',
  `supplier_id` int(11) DEFAULT NULL,
  `requestable` tinyint(4) NOT NULL DEFAULT '0',
  `rtd_location_id` int(11) DEFAULT NULL,
  `_snipeit_mac_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accepted` enum('pending','accepted','rejected') COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_checkout` datetime DEFAULT NULL,
  `expected_checkin` date DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
INSERT INTO `assets` VALUES (1,'Cross-platform neutral hub','448618548',3,'f14ffbd2-9c38-39d8-a871-aff8f5525d9c','2014-08-25',0.0000,'14531074',NULL,'Nesciunt consequatur ipsa tempore nulla molestias.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,4,1,2,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (2,'Multi-layered homogeneous task-force','399482905',5,'57b2fe9b-e371-3106-bc86-3599876ebfc6','2010-08-11',0.0000,'30085069',NULL,'Est sed eum quasi aut iure.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,3,0,3,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (3,'Adaptive upward-trending groupware','920237204',3,'cd9daede-0289-388d-baf9-b4bf421ded3c','2006-04-10',0.0000,'3577311',NULL,'Esse quo dignissimos dolorem id magni sequi.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,3,0,4,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (4,'Exclusive system-worthy data-warehouse','682363019',5,'09484b43-8694-3322-8190-7291ec051346','1988-05-30',0.0000,'49524960',NULL,'Magni sed eum sequi molestiae doloremque voluptas maxime.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,2,1,3,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (5,'Focused leadingedge analyzer','701311786',2,'c5e6e5cf-c702-333a-bdb6-fba8498a6499','1989-05-24',0.0000,'12233872',NULL,'Dolores eum culpa ipsa iusto nam.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,1,0,5,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (6,'Proactive needs-based localareanetwork','1157495283',2,'8ca8f18f-24b3-381c-a7c8-28299db47ac5','1991-05-10',0.0000,'6048036',NULL,'Non dolores veritatis inventore in doloremque dolorum vel sit.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,2,0,5,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (7,'Intuitive mission-critical GraphicInterface','468588121',1,'55aefd1d-f66e-3f7b-a854-9d4a02ff9ba1','2008-04-02',0.0000,'4115618',NULL,'Nostrum velit totam necessitatibus quod nostrum eos.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,3,1,4,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (8,'Assimilated attitude-oriented ability','216343836',1,'3ddf3fb0-cceb-300e-b187-87fd4be3876f','1998-10-09',0.0000,'24486266',NULL,'Voluptatum iste sunt vel est et quo.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,3,1,3,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (9,'Operative 6thgeneration capacity','679564193',5,'ff925ad4-f837-3679-bc7a-95d5371cfdb6','1970-11-22',0.0000,'3654896',NULL,'Qui facere dolores eum eos nam earum optio.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,2,0,5,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (10,'Open-source bottom-line initiative','1215659502',3,'dfae068e-3b30-3e40-b3fc-e09e269a4190','1977-11-23',0.0000,'32877365',NULL,'Doloribus aut eos aperiam magnam dicta.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,5,1,1,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (11,'Progressive regional systemengine','368903642',2,'49c9253e-df32-3934-bdb6-9bc56f681120','1990-07-24',0.0000,'15493445',NULL,'Aliquid quia nemo maxime rerum.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,5,1,1,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (12,'Optional regional support','1181886883',5,'fbcef07a-3346-3204-8f9a-5e04ca930556','1998-05-16',0.0000,'49073926',NULL,'Et in molestias impedit sunt non in est.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,4,0,4,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (13,'Multi-channelled 24/7 help-desk','500019256',5,'b4049972-0afe-3085-8c3f-ed5e281030af','1999-12-21',0.0000,'3776664',NULL,'Sit possimus suscipit consequatur voluptates aperiam fugiat.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,1,0,2,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (14,'Mandatory tangible utilisation','859123034',4,'8d70b3b6-7621-39fa-834b-680bad057fc4','1986-08-07',0.0000,'38040606',NULL,'Nulla incidunt aliquid quia nihil ipsum voluptas.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,4,1,2,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (15,'Visionary impactful info-mediaries','640450833',2,'a755b226-120e-3098-8e7d-5fa028bb82b4','1985-10-18',0.0000,'36217255',NULL,'Explicabo natus maiores ipsa quidem quam neque.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,3,1,2,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (16,'Digitized incremental definition','20928628',2,'8bdb3c3c-4899-3f17-881a-27deec4ca279','1970-04-17',0.0000,'14916213',NULL,'Distinctio ullam delectus voluptates rerum qui.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,5,0,3,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (17,'Universal clear-thinking superstructure','1078429800',2,'e4bc8bc8-8c8b-32bb-a2ac-75d97be7ee9a','1988-06-01',0.0000,'24967829',NULL,'Deserunt rerum accusantium possimus.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,2,1,1,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (18,'Distributed grid-enabled implementation','1389227059',1,'9510e81f-b2b1-334d-a69d-0e68c2252523','2013-01-24',0.0000,'37250818',NULL,'Adipisci quas ut culpa fugiat dignissimos nihil facere sapiente.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,1,1,4,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (19,'Vision-oriented attitude-oriented policy','1116168023',4,'0b975301-8c8d-3a70-802b-33225344c20e','2011-09-03',0.0000,'30944019',NULL,'Repellendus sed eligendi qui impedit velit.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,4,1,3,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `assets` VALUES (20,'Down-sized interactive standardization','1106200044',3,'17156208-72a4-3ace-b560-9200ee505819','1982-06-24',0.0000,'49219190',NULL,'Suscipit consequatur et est praesentium nemo et.',NULL,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',1,NULL,1,0,NULL,0,2,1,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `eula_text` longtext COLLATE utf8_unicode_ci,
  `use_default_eula` tinyint(1) NOT NULL DEFAULT '0',
  `require_acceptance` tinyint(1) NOT NULL DEFAULT '0',
  `category_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'asset',
  `checkin_email` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Voluptatem accusamus.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (2,'Voluptatem quam deserunt dolor.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (3,'Voluptate recusandae quos sunt.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (4,'Excepturi corrupti dolor expedita.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (5,'Et ut enim tenetur.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (6,'Nam nemo.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (7,'Eius rerum pariatur nulla.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (8,'Deserunt qui ullam.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (9,'Voluptas minima eos qui.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (10,'Ex inventore quia.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'asset',0);
INSERT INTO `categories` VALUES (11,'Eos harum.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'accessory',0);
INSERT INTO `categories` VALUES (12,'Dolorem minima.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'accessory',0);
INSERT INTO `categories` VALUES (13,'Ut occaecati.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'accessory',0);
INSERT INTO `categories` VALUES (14,'Consequatur odio itaque.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'accessory',0);
INSERT INTO `categories` VALUES (15,'Facere optio.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'accessory',0);
INSERT INTO `categories` VALUES (16,'Cum laborum quae.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'consumable',0);
INSERT INTO `categories` VALUES (17,'Ullam voluptate doloribus necessitatibus.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'consumable',0);
INSERT INTO `categories` VALUES (18,'Sit consequatur optio iusto a.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'consumable',0);
INSERT INTO `categories` VALUES (19,'Id optio voluptatem.','2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,0,0,'consumable',0);
INSERT INTO `categories` VALUES (20,'Pariatur praesentium.','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL,NULL,0,0,'consumable',0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `consumables` WRITE;
/*!40000 ALTER TABLE `consumables` DISABLE KEYS */;
INSERT INTO `consumables` VALUES (1,'Profound fresh-thinking service-desk',18,NULL,NULL,3,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,4);
INSERT INTO `consumables` VALUES (2,'Secured systemic processimprovement',16,NULL,NULL,2,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,5);
INSERT INTO `consumables` VALUES (3,'Assimilated neutral migration',18,NULL,NULL,7,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,1);
INSERT INTO `consumables` VALUES (4,'Pre-emptive human-resource firmware',19,NULL,NULL,6,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,6);
INSERT INTO `consumables` VALUES (5,'Stand-alone high-level budgetarymanagement',16,NULL,NULL,1,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,6);
INSERT INTO `consumables` VALUES (6,'Cross-platform modular systemengine',18,NULL,NULL,9,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,7);
INSERT INTO `consumables` VALUES (7,'Business-focused user-facing monitoring',20,NULL,NULL,10,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,5);
INSERT INTO `consumables` VALUES (8,'Multi-tiered coherent installation',19,NULL,NULL,10,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,2);
INSERT INTO `consumables` VALUES (9,'Team-oriented responsive collaboration',18,NULL,NULL,8,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,3);
INSERT INTO `consumables` VALUES (10,'Balanced holistic pricingstructure',16,NULL,NULL,10,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,2);
INSERT INTO `consumables` VALUES (11,'Persevering context-sensitive focusgroup',17,NULL,NULL,9,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,4);
INSERT INTO `consumables` VALUES (12,'Progressive systematic frame',16,NULL,NULL,4,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,5);
INSERT INTO `consumables` VALUES (13,'Progressive scalable superstructure',18,NULL,NULL,4,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,10);
INSERT INTO `consumables` VALUES (14,'Up-sized grid-enabled info-mediaries',19,NULL,NULL,7,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,9);
INSERT INTO `consumables` VALUES (15,'Assimilated user-facing function',16,NULL,NULL,7,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,5);
INSERT INTO `consumables` VALUES (16,'Mandatory non-volatile support',18,NULL,NULL,4,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,4);
INSERT INTO `consumables` VALUES (17,'Customer-focused bifurcated adapter',16,NULL,NULL,5,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,5);
INSERT INTO `consumables` VALUES (18,'Centralized global standardization',18,NULL,NULL,6,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,2);
INSERT INTO `consumables` VALUES (19,'De-engineered attitude-oriented project',20,NULL,NULL,3,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,9);
INSERT INTO `consumables` VALUES (20,'Cross-group client-driven circuit',16,NULL,NULL,9,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,2);
INSERT INTO `consumables` VALUES (21,'Enhanced human-resource matrix',16,NULL,NULL,10,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,5);
INSERT INTO `consumables` VALUES (22,'Reduced upward-trending neural-net',19,NULL,NULL,6,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,9);
INSERT INTO `consumables` VALUES (23,'Synergized interactive approach',18,NULL,NULL,10,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,6);
INSERT INTO `consumables` VALUES (24,'Phased human-resource methodology',17,NULL,NULL,4,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,10);
INSERT INTO `consumables` VALUES (25,'Balanced interactive matrices',17,NULL,NULL,4,0,'2016-02-23 22:11:56','2016-02-23 22:11:56',NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `consumables` ENABLE KEYS */;
UNLOCK TABLES;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `consumables_users` WRITE;
/*!40000 ALTER TABLE `consumables_users` DISABLE KEYS */;
INSERT INTO `consumables_users` VALUES (1,1,7,1,'2016-02-20 07:14:36','2016-02-20 07:14:36');
/*!40000 ALTER TABLE `consumables_users` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `custom_field_custom_fieldset` WRITE;
/*!40000 ALTER TABLE `custom_field_custom_fieldset` DISABLE KEYS */;
INSERT INTO `custom_field_custom_fieldset` VALUES (1,1,1,0);
/*!40000 ALTER TABLE `custom_field_custom_fieldset` ENABLE KEYS */;
UNLOCK TABLES;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `custom_fields` WRITE;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_fields` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `custom_fieldsets` WRITE;
/*!40000 ALTER TABLE `custom_fieldsets` DISABLE KEYS */;
INSERT INTO `custom_fieldsets` VALUES (1,'Asset with MAC Address',NULL,NULL,NULL);
/*!40000 ALTER TABLE `custom_fieldsets` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `depreciations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `depreciations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `months` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `depreciations` WRITE;
/*!40000 ALTER TABLE `depreciations` DISABLE KEYS */;
INSERT INTO `depreciations` VALUES (1,'Muller and Sons',5,'2016-02-23 22:11:57','2016-02-23 22:11:57',0);
/*!40000 ALTER TABLE `depreciations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `checkedout_to` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `license_seats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `license_seats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `license_id` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `asset_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `license_seats` WRITE;
/*!40000 ALTER TABLE `license_seats` DISABLE KEYS */;
INSERT INTO `license_seats` VALUES (1,3,NULL,'Et velit est temporibus occaecati.',1,'1982-01-10 19:37:44','1970-10-01 12:47:59',NULL,NULL);
INSERT INTO `license_seats` VALUES (2,3,NULL,'Est ut dicta rerum voluptas nisi sed.',1,'2000-07-17 15:06:36','1983-07-23 16:39:49',NULL,NULL);
INSERT INTO `license_seats` VALUES (3,10,NULL,'Quod inventore officiis maxime explicabo temporibus sed natus.',1,'1978-04-27 15:06:21','2009-06-25 00:39:56',NULL,NULL);
INSERT INTO `license_seats` VALUES (4,3,NULL,'Voluptatem dolore pariatur dolor facere.',1,'1976-11-03 20:26:21','1996-10-08 09:09:13',NULL,NULL);
INSERT INTO `license_seats` VALUES (5,9,NULL,'Sint vero aut nostrum ab corporis quasi.',1,'1973-04-14 07:02:51','2008-01-25 16:16:58',NULL,NULL);
INSERT INTO `license_seats` VALUES (6,6,NULL,'In architecto nam exercitationem maxime.',1,'2003-12-15 04:27:32','1971-10-29 23:33:01',NULL,NULL);
INSERT INTO `license_seats` VALUES (7,5,NULL,'Assumenda fugiat et sed esse.',1,'1988-06-05 12:13:29','1994-07-16 23:55:24',NULL,NULL);
INSERT INTO `license_seats` VALUES (8,1,NULL,'Esse autem sunt necessitatibus consequatur blanditiis maiores.',1,'2008-01-28 04:03:04','1975-02-06 18:44:31',NULL,NULL);
INSERT INTO `license_seats` VALUES (9,8,NULL,'Sequi quod eaque accusantium ad sapiente nemo quis.',1,'1975-12-01 01:52:52','1981-03-19 01:51:02',NULL,NULL);
INSERT INTO `license_seats` VALUES (10,3,NULL,'Voluptas eum expedita corrupti et.',1,'1979-09-13 08:29:18','1975-10-30 20:56:44',NULL,NULL);
/*!40000 ALTER TABLE `license_seats` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serial` text COLLATE utf8_unicode_ci,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(13,4) DEFAULT NULL,
  `order_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seats` int(11) NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8_unicode_ci,
  `user_id` int(11) NOT NULL,
  `depreciation_id` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `license_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `license_email` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `depreciate` tinyint(1) DEFAULT '0',
  `supplier_id` int(11) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `purchase_order` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `termination_date` date DEFAULT NULL,
  `maintained` tinyint(1) NOT NULL,
  `reassignable` tinyint(1) NOT NULL DEFAULT '1',
  `company_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `licenses` WRITE;
/*!40000 ALTER TABLE `licenses` DISABLE KEYS */;
INSERT INTO `licenses` VALUES (1,'Up-sized secondary protocol','3778e42f-1136-37e2-b282-c6ea1f8fef16','2004-04-19',194114442.2700,NULL,2,'Sint facilis minima molestiae atque cupiditate vitae labore.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Mrs. Flo Schuppe III','hcole@example.org',0,NULL,NULL,NULL,NULL,0,1,NULL);
INSERT INTO `licenses` VALUES (2,'Devolved heuristic support','1adcc3bb-0506-3125-8541-1bd049a092ea','1975-12-27',10113768.0700,NULL,1,'Dolores vel amet amet occaecati voluptatum voluptatibus rerum.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Mr. Bennett O\'Keefe PhD','ajohns@example.org',0,NULL,NULL,NULL,NULL,0,1,NULL);
INSERT INTO `licenses` VALUES (3,'De-engineered mobile securedline','5ed82a0d-8a8f-31af-938f-d79fb1702d8c','2012-05-07',2563406.1500,NULL,1,'Quaerat voluptatum sint qui.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Kallie McLaughlin','gerhard35@example.org',0,NULL,NULL,NULL,NULL,0,1,NULL);
INSERT INTO `licenses` VALUES (4,'Quality-focused fresh-thinking internetsolution','474ab0f7-d2ab-36f3-82d3-231abcb46f0a','2012-08-06',273519183.2600,NULL,2,'Ullam dolores et eos voluptatem id pariatur.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Madison Bogisich','lkoepp@example.org',0,NULL,NULL,NULL,NULL,0,1,NULL);
INSERT INTO `licenses` VALUES (5,'Inverse multimedia functionalities','fe1e3b79-e294-37dc-bd37-2b8fa28198ff','1999-10-07',46696828.1600,NULL,10,'Cumque tenetur enim itaque eaque.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Mr. Lucious McKenzie','odell67@example.net',0,NULL,NULL,NULL,NULL,0,1,NULL);
INSERT INTO `licenses` VALUES (6,'Multi-channelled zerodefect product','8c44c04e-9314-3dc1-8746-09dfb24bec8e','1981-05-18',14299.4900,NULL,9,'Laborum occaecati voluptatibus delectus et.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Dr. Alverta Kessler DDS','lou.eichmann@example.com',0,NULL,NULL,NULL,NULL,0,1,NULL);
INSERT INTO `licenses` VALUES (7,'Universal even-keeled archive','bbfc4061-d062-3cfd-8963-562ece330053','1993-08-25',1466239.0100,NULL,3,'Eveniet fuga magni sit occaecati.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Mrs. Danielle Emmerich','stoltenberg.ettie@example.com',0,NULL,NULL,NULL,NULL,0,1,NULL);
INSERT INTO `licenses` VALUES (8,'Triple-buffered encompassing software','abf2ced0-0f38-30bd-a51c-e6759ac4333c','2001-11-29',5.3200,NULL,3,'Repudiandae aut id maiores.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Alena Halvorson','jblock@example.com',0,NULL,NULL,NULL,NULL,0,1,NULL);
INSERT INTO `licenses` VALUES (9,'Phased global methodology','53127a63-05dc-31b8-9416-53d74cb35ccf','2012-12-26',8058459.5000,NULL,3,'Iusto non velit praesentium.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Marques Lemke II','armstrong.caesar@example.com',0,NULL,NULL,NULL,NULL,0,1,NULL);
INSERT INTO `licenses` VALUES (10,'Business-focused object-oriented productivity','2a74a2bf-8090-3dc0-b216-b7eec3644f9b','1983-02-07',20265.0500,NULL,3,'Similique voluptate voluptas temporibus consectetur perferendis ipsam ut id.',0,0,'2016-02-23 22:11:57','2016-02-23 22:11:57',NULL,'Donavon Little','afahey@example.org',0,NULL,NULL,NULL,NULL,0,1,NULL);
/*!40000 ALTER TABLE `licenses` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Port Justina','Mohrbury','RI','AL','2016-02-23 22:11:57','2016-02-23 22:11:57',0,'',NULL,NULL,NULL,NULL,'PLN');
INSERT INTO `locations` VALUES (2,'North Otha','Kunzemouth','IA','KH','2016-02-23 22:11:57','2016-02-23 22:11:57',0,'',NULL,NULL,NULL,NULL,'HKD');
INSERT INTO `locations` VALUES (3,'Terenceville','North Florian','NE','RS','2016-02-23 22:11:57','2016-02-23 22:11:57',0,'',NULL,NULL,NULL,NULL,'AUD');
INSERT INTO `locations` VALUES (4,'Maddisonside','New Joana','KS','KW','2016-02-23 22:11:57','2016-02-23 22:11:57',0,'',NULL,NULL,NULL,NULL,'JOD');
INSERT INTO `locations` VALUES (5,'Cassinmouth','North Alessiamouth','RI','UG','2016-02-23 22:11:57','2016-02-23 22:11:57',0,'',NULL,NULL,NULL,NULL,'INR');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `manufacturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manufacturers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `manufacturers` WRITE;
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;
INSERT INTO `manufacturers` VALUES (1,'Nolan PLC','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
INSERT INTO `manufacturers` VALUES (2,'Koelpin, Keebler and O\'Kon','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
INSERT INTO `manufacturers` VALUES (3,'Schoen-Johns','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
INSERT INTO `manufacturers` VALUES (4,'Lind-Kreiger','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
INSERT INTO `manufacturers` VALUES (5,'Connelly LLC','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
INSERT INTO `manufacturers` VALUES (6,'Osinski LLC','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
INSERT INTO `manufacturers` VALUES (7,'Dach-Eichmann','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
INSERT INTO `manufacturers` VALUES (8,'Beatty, Kuhn and Wiza','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
INSERT INTO `manufacturers` VALUES (9,'Wisoky-Runte','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
INSERT INTO `manufacturers` VALUES (10,'Larkin-Effertz','2016-02-23 22:11:57','2016-02-23 22:11:57',0,NULL);
/*!40000 ALTER TABLE `manufacturers` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2012_12_06_225921_migration_cartalyst_sentry_install_users',1);
INSERT INTO `migrations` VALUES ('2012_12_06_225929_migration_cartalyst_sentry_install_groups',1);
INSERT INTO `migrations` VALUES ('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot',1);
INSERT INTO `migrations` VALUES ('2012_12_06_225988_migration_cartalyst_sentry_install_throttle',1);
INSERT INTO `migrations` VALUES ('2013_03_23_193214_update_users_table',1);
INSERT INTO `migrations` VALUES ('2013_11_13_075318_create_models_table',1);
INSERT INTO `migrations` VALUES ('2013_11_13_075335_create_categories_table',1);
INSERT INTO `migrations` VALUES ('2013_11_13_075347_create_manufacturers_table',1);
INSERT INTO `migrations` VALUES ('2013_11_15_015858_add_user_id_to_categories',1);
INSERT INTO `migrations` VALUES ('2013_11_15_112701_add_user_id_to_manufacturers',1);
INSERT INTO `migrations` VALUES ('2013_11_15_190327_create_assets_table',1);
INSERT INTO `migrations` VALUES ('2013_11_15_190357_create_licenses_table',1);
INSERT INTO `migrations` VALUES ('2013_11_15_201848_add_license_name_to_licenses',1);
INSERT INTO `migrations` VALUES ('2013_11_16_040323_create_depreciations_table',1);
INSERT INTO `migrations` VALUES ('2013_11_16_042851_add_depreciation_id_to_models',1);
INSERT INTO `migrations` VALUES ('2013_11_16_084923_add_user_id_to_models',1);
INSERT INTO `migrations` VALUES ('2013_11_16_103258_create_locations_table',1);
INSERT INTO `migrations` VALUES ('2013_11_16_103336_add_location_id_to_assets',1);
INSERT INTO `migrations` VALUES ('2013_11_16_103407_add_checkedout_to_to_assets',1);
INSERT INTO `migrations` VALUES ('2013_11_16_103425_create_history_table',1);
INSERT INTO `migrations` VALUES ('2013_11_17_054359_drop_licenses_table',1);
INSERT INTO `migrations` VALUES ('2013_11_17_054526_add_physical_to_assets',1);
INSERT INTO `migrations` VALUES ('2013_11_17_055126_create_settings_table',1);
INSERT INTO `migrations` VALUES ('2013_11_17_062634_add_license_to_assets',1);
INSERT INTO `migrations` VALUES ('2013_11_18_134332_add_contacts_to_users',1);
INSERT INTO `migrations` VALUES ('2013_11_18_142847_add_info_to_locations',1);
INSERT INTO `migrations` VALUES ('2013_11_18_152942_remove_location_id_from_asset',1);
INSERT INTO `migrations` VALUES ('2013_11_18_164423_set_nullvalues_for_user',1);
INSERT INTO `migrations` VALUES ('2013_11_19_013337_create_asset_logs_table',1);
INSERT INTO `migrations` VALUES ('2013_11_19_061409_edit_added_on_asset_logs_table',1);
INSERT INTO `migrations` VALUES ('2013_11_19_062250_edit_location_id_asset_logs_table',1);
INSERT INTO `migrations` VALUES ('2013_11_20_055822_add_soft_delete_on_assets',1);
INSERT INTO `migrations` VALUES ('2013_11_20_121404_add_soft_delete_on_locations',1);
INSERT INTO `migrations` VALUES ('2013_11_20_123137_add_soft_delete_on_manufacturers',1);
INSERT INTO `migrations` VALUES ('2013_11_20_123725_add_soft_delete_on_categories',1);
INSERT INTO `migrations` VALUES ('2013_11_20_130248_create_status_labels',1);
INSERT INTO `migrations` VALUES ('2013_11_20_130830_add_status_id_on_assets_table',1);
INSERT INTO `migrations` VALUES ('2013_11_20_131544_add_status_type_on_status_labels',1);
INSERT INTO `migrations` VALUES ('2013_11_20_134103_add_archived_to_assets',1);
INSERT INTO `migrations` VALUES ('2013_11_21_002321_add_uploads_table',1);
INSERT INTO `migrations` VALUES ('2013_11_21_024531_remove_deployable_boolean_from_status_labels',1);
INSERT INTO `migrations` VALUES ('2013_11_22_075308_add_option_label_to_settings_table',1);
INSERT INTO `migrations` VALUES ('2013_11_22_213400_edits_to_settings_table',1);
INSERT INTO `migrations` VALUES ('2013_11_25_013244_create_licenses_table',1);
INSERT INTO `migrations` VALUES ('2013_11_25_031458_create_license_seats_table',1);
INSERT INTO `migrations` VALUES ('2013_11_25_032022_add_type_to_actionlog_table',1);
INSERT INTO `migrations` VALUES ('2013_11_25_033008_delete_bad_licenses_table',1);
INSERT INTO `migrations` VALUES ('2013_11_25_033131_create_new_licenses_table',1);
INSERT INTO `migrations` VALUES ('2013_11_25_033534_add_licensed_to_licenses_table',1);
INSERT INTO `migrations` VALUES ('2013_11_25_101308_add_warrantee_to_assets_table',1);
INSERT INTO `migrations` VALUES ('2013_11_25_104343_alter_warranty_column_on_assets',1);
INSERT INTO `migrations` VALUES ('2013_11_25_150450_drop_parent_from_categories',1);
INSERT INTO `migrations` VALUES ('2013_11_25_151920_add_depreciate_to_assets',1);
INSERT INTO `migrations` VALUES ('2013_11_25_152903_add_depreciate_to_licenses_table',1);
INSERT INTO `migrations` VALUES ('2013_11_26_211820_drop_license_from_assets_table',1);
INSERT INTO `migrations` VALUES ('2013_11_27_062510_add_note_to_asset_logs_table',1);
INSERT INTO `migrations` VALUES ('2013_12_01_113426_add_filename_to_asset_log',1);
INSERT INTO `migrations` VALUES ('2013_12_06_094618_add_nullable_to_licenses_table',1);
INSERT INTO `migrations` VALUES ('2013_12_10_084038_add_eol_on_models_table',1);
INSERT INTO `migrations` VALUES ('2013_12_12_055218_add_manager_to_users_table',1);
INSERT INTO `migrations` VALUES ('2014_01_28_031200_add_qr_code_to_settings_table',1);
INSERT INTO `migrations` VALUES ('2014_02_13_183016_add_qr_text_to_settings_table',1);
INSERT INTO `migrations` VALUES ('2014_05_24_093839_alter_default_license_depreciation_id',1);
INSERT INTO `migrations` VALUES ('2014_05_27_231658_alter_default_values_licenses',1);
INSERT INTO `migrations` VALUES ('2014_06_19_191508_add_asset_name_to_settings',1);
INSERT INTO `migrations` VALUES ('2014_06_20_004847_make_asset_log_checkedout_to_nullable',1);
INSERT INTO `migrations` VALUES ('2014_06_20_005050_make_asset_log_purchasedate_to_nullable',1);
INSERT INTO `migrations` VALUES ('2014_06_24_003011_add_suppliers',1);
INSERT INTO `migrations` VALUES ('2014_06_24_010742_add_supplier_id_to_asset',1);
INSERT INTO `migrations` VALUES ('2014_06_24_012839_add_zip_to_supplier',1);
INSERT INTO `migrations` VALUES ('2014_06_24_033908_add_url_to_supplier',1);
INSERT INTO `migrations` VALUES ('2014_07_08_054116_add_employee_id_to_users',1);
INSERT INTO `migrations` VALUES ('2014_07_09_134316_add_requestable_to_assets',1);
INSERT INTO `migrations` VALUES ('2014_07_17_085822_add_asset_to_software',1);
INSERT INTO `migrations` VALUES ('2014_07_17_161625_make_asset_id_in_logs_nullable',1);
INSERT INTO `migrations` VALUES ('2014_08_12_053504_alpha_0_4_2_release',1);
INSERT INTO `migrations` VALUES ('2014_08_17_083523_make_location_id_nullable',1);
INSERT INTO `migrations` VALUES ('2014_10_16_200626_add_rtd_location_to_assets',1);
INSERT INTO `migrations` VALUES ('2014_10_24_000417_alter_supplier_state_to_32',1);
INSERT INTO `migrations` VALUES ('2014_10_24_015641_add_display_checkout_date',1);
INSERT INTO `migrations` VALUES ('2014_10_28_222654_add_avatar_field_to_users_table',1);
INSERT INTO `migrations` VALUES ('2014_10_29_045924_add_image_field_to_models_table',1);
INSERT INTO `migrations` VALUES ('2014_11_01_214955_add_eol_display_to_settings',1);
INSERT INTO `migrations` VALUES ('2014_11_04_231416_update_group_field_for_reporting',1);
INSERT INTO `migrations` VALUES ('2014_11_05_212408_add_fields_to_licenses',1);
INSERT INTO `migrations` VALUES ('2014_11_07_021042_add_image_to_supplier',1);
INSERT INTO `migrations` VALUES ('2014_11_20_203007_add_username_to_user',1);
INSERT INTO `migrations` VALUES ('2014_11_20_223947_add_auto_to_settings',1);
INSERT INTO `migrations` VALUES ('2014_11_20_224421_add_prefix_to_settings',1);
INSERT INTO `migrations` VALUES ('2014_11_21_104401_change_licence_type',1);
INSERT INTO `migrations` VALUES ('2014_12_09_082500_add_fields_maintained_term_to_licenses',1);
INSERT INTO `migrations` VALUES ('2015_02_04_155757_increase_user_field_lengths',1);
INSERT INTO `migrations` VALUES ('2015_02_07_013537_add_soft_deleted_to_log',1);
INSERT INTO `migrations` VALUES ('2015_02_10_040958_fix_bad_assigned_to_ids',1);
INSERT INTO `migrations` VALUES ('2015_02_10_053310_migrate_data_to_new_statuses',1);
INSERT INTO `migrations` VALUES ('2015_02_11_044104_migrate_make_license_assigned_null',1);
INSERT INTO `migrations` VALUES ('2015_02_11_104406_migrate_create_requests_table',1);
INSERT INTO `migrations` VALUES ('2015_02_12_001312_add_mac_address_to_asset',1);
INSERT INTO `migrations` VALUES ('2015_02_12_024100_change_license_notes_type',1);
INSERT INTO `migrations` VALUES ('2015_02_17_231020_add_localonly_to_settings',1);
INSERT INTO `migrations` VALUES ('2015_02_19_222322_add_logo_and_colors_to_settings',1);
INSERT INTO `migrations` VALUES ('2015_02_24_072043_add_alerts_to_settings',1);
INSERT INTO `migrations` VALUES ('2015_02_25_022931_add_eula_fields',1);
INSERT INTO `migrations` VALUES ('2015_02_25_204513_add_accessories_table',1);
INSERT INTO `migrations` VALUES ('2015_02_26_091228_add_accessories_user_table',1);
INSERT INTO `migrations` VALUES ('2015_02_26_115128_add_deleted_at_models',1);
INSERT INTO `migrations` VALUES ('2015_02_26_233005_add_category_type',1);
INSERT INTO `migrations` VALUES ('2015_03_01_231912_update_accepted_at_to_acceptance_id',1);
INSERT INTO `migrations` VALUES ('2015_03_05_011929_add_qr_type_to_settings',1);
INSERT INTO `migrations` VALUES ('2015_03_18_055327_add_note_to_user',1);
INSERT INTO `migrations` VALUES ('2015_04_29_234704_add_slack_to_settings',1);
INSERT INTO `migrations` VALUES ('2015_05_04_085151_add_parent_id_to_locations_table',1);
INSERT INTO `migrations` VALUES ('2015_05_22_124421_add_reassignable_to_licenses',1);
INSERT INTO `migrations` VALUES ('2015_06_10_003314_fix_default_for_user_notes',1);
INSERT INTO `migrations` VALUES ('2015_06_10_003554_create_consumables',1);
INSERT INTO `migrations` VALUES ('2015_06_15_183253_move_email_to_username',1);
INSERT INTO `migrations` VALUES ('2015_06_23_070346_make_email_nullable',1);
INSERT INTO `migrations` VALUES ('2015_06_26_213716_create_asset_maintenances_table',1);
INSERT INTO `migrations` VALUES ('2015_07_04_212443_create_custom_fields_table',1);
INSERT INTO `migrations` VALUES ('2015_07_09_014359_add_currency_to_settings_and_locations',1);
INSERT INTO `migrations` VALUES ('2015_07_21_122022_add_expected_checkin_date_to_asset_logs',1);
INSERT INTO `migrations` VALUES ('2015_07_24_093845_add_checkin_email_to_category_table',1);
INSERT INTO `migrations` VALUES ('2015_07_25_055415_remove_email_unique_constraint',1);
INSERT INTO `migrations` VALUES ('2015_07_29_230054_add_thread_id_to_asset_logs_table',1);
INSERT INTO `migrations` VALUES ('2015_07_31_015430_add_accepted_to_assets',1);
INSERT INTO `migrations` VALUES ('2015_09_09_195301_add_custom_css_to_settings',1);
INSERT INTO `migrations` VALUES ('2015_09_21_235926_create_custom_field_custom_fieldset',1);
INSERT INTO `migrations` VALUES ('2015_09_22_000104_create_custom_fieldsets',1);
INSERT INTO `migrations` VALUES ('2015_09_22_003321_add_fieldset_id_to_assets',1);
INSERT INTO `migrations` VALUES ('2015_09_22_003413_migrate_mac_address',1);
INSERT INTO `migrations` VALUES ('2015_09_28_003314_fix_default_purchase_order',1);
INSERT INTO `migrations` VALUES ('2015_10_01_024551_add_accessory_consumable_price_info',1);
INSERT INTO `migrations` VALUES ('2015_10_12_192706_add_brand_to_settings',1);
INSERT INTO `migrations` VALUES ('2015_10_22_003314_fix_defaults_accessories',1);
INSERT INTO `migrations` VALUES ('2015_10_23_182625_add_checkout_time_and_expected_checkout_date_to_assets',1);
INSERT INTO `migrations` VALUES ('2015_11_05_061015_create_companies_table',1);
INSERT INTO `migrations` VALUES ('2015_11_05_061115_add_company_id_to_consumables_table',1);
INSERT INTO `migrations` VALUES ('2015_11_05_183749_image',1);
INSERT INTO `migrations` VALUES ('2015_11_06_092038_add_company_id_to_accessories_table',1);
INSERT INTO `migrations` VALUES ('2015_11_06_100045_add_company_id_to_users_table',1);
INSERT INTO `migrations` VALUES ('2015_11_06_134742_add_company_id_to_licenses_table',1);
INSERT INTO `migrations` VALUES ('2015_11_08_035832_add_company_id_to_assets_table',1);
INSERT INTO `migrations` VALUES ('2015_11_08_222305_add_ldap_fields_to_settings',1);
INSERT INTO `migrations` VALUES ('2015_11_15_151803_add_full_multiple_companies_support_to_settings_table',1);
INSERT INTO `migrations` VALUES ('2015_11_26_195528_import_ldap_settings',1);
INSERT INTO `migrations` VALUES ('2015_11_30_191504_remove_fk_company_id',1);
INSERT INTO `migrations` VALUES ('2015_12_21_193006_add_ldap_server_cert_ignore_to_settings_table',1);
INSERT INTO `migrations` VALUES ('2015_12_30_233509_add_timestamp_and_userId_to_custom_fields',1);
INSERT INTO `migrations` VALUES ('2015_12_30_233658_add_timestamp_and_userId_to_custom_fieldsets',1);
INSERT INTO `migrations` VALUES ('2016_01_28_041048_add_notes_to_models',1);
INSERT INTO `migrations` VALUES ('2016_02_19_070119_add_remember_token_to_users_table',1);
INSERT INTO `migrations` VALUES ('2016_02_19_073625_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `models` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `modelno` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `depreciation_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `eol` int(11) DEFAULT '0',
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deprecated_mac_address` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `fieldset_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
INSERT INTO `models` VALUES (1,'Self-enabling methodical toolset','15569555',1,3,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,0,1,NULL,0,NULL,NULL,NULL);
INSERT INTO `models` VALUES (2,'Horizontal human-resource productivity','4247645',6,2,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,0,1,NULL,0,NULL,NULL,NULL);
INSERT INTO `models` VALUES (3,'Multi-lateral well-modulated application','42731313',1,9,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,0,1,NULL,0,NULL,NULL,NULL);
INSERT INTO `models` VALUES (4,'Versatile leadingedge task-force','30742575',2,3,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,0,1,NULL,0,NULL,NULL,NULL);
INSERT INTO `models` VALUES (5,'Versatile client-server methodology','39169101',10,2,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,0,1,NULL,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `models` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `requested_assets` WRITE;
/*!40000 ALTER TABLE `requested_assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `requested_assets` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_code` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
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
  `ldap_filter` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'cn=*',
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'2016-02-20 06:54:17','2016-02-20 17:02:31',1,100,'Snipe-IT v3 Pre-Alpha',1,'',NULL,NULL,NULL,0,'',1,NULL,'','snipe@snipe.net',1,'','C128','','','','USD','',1,'0','','','eyJpdiI6InhpYkM0ajdnSFVpY014YWFpYk1aNlQ4Umh5cXRjbjN5UnR2MyszRmJKdzA9IiwidmFsdWUiOiJFWlErWUhQM2JoeVNHXC85YVFQWGhublwvQ2dkd2M2aU9cL3psdUxMdDZTa1dVPSIsIm1hYyI6IjZhYmJjYTVkNjNmOTJjMTAyNzM4YzkwZjA2MzlkNjdhMmYzYWJkYzc3NWJkZmVhYjFkNmNkNTYxOTdkMThkNjUifQ==','','cn=*','samaccountname','sn','givenname','uid=samaccountname',3,'','','',0,0);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `status_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_labels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deployable` tinyint(1) NOT NULL DEFAULT '0',
  `pending` tinyint(1) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `status_labels` WRITE;
/*!40000 ALTER TABLE `status_labels` DISABLE KEYS */;
INSERT INTO `status_labels` VALUES (1,'Ready to Deploy',1,'1984-04-01 09:01:15','1992-03-09 20:29:18',NULL,1,0,0,'');
INSERT INTO `status_labels` VALUES (2,'Pending',1,'1982-08-02 05:01:39','1972-10-09 13:44:05',NULL,0,1,0,'');
INSERT INTO `status_labels` VALUES (3,'Archived',1,'2012-03-24 20:49:48','1993-05-26 18:55:00',NULL,0,0,1,'These assets are permanently undeployable');
INSERT INTO `status_labels` VALUES (4,'Out for Diagnostics',1,'1981-02-21 12:11:12','2006-03-08 13:49:13',NULL,0,0,0,'');
INSERT INTO `status_labels` VALUES (5,'Out for Repair',1,'2015-06-16 14:13:51','2013-12-11 19:38:13',NULL,0,0,0,'');
INSERT INTO `status_labels` VALUES (6,'Broken - Not Fixable',1,'1984-01-23 08:13:56','1973-01-15 08:39:15',NULL,0,0,1,'');
INSERT INTO `status_labels` VALUES (7,'Lost/Stolen',1,'2015-08-25 23:31:23','2005-11-18 13:51:43',NULL,0,0,1,'');
/*!40000 ALTER TABLE `status_labels` ENABLE KEYS */;
UNLOCK TABLES;
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
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Baumbach PLC','7976 Kenny Fork Apt. 891',NULL,'South Viviane','ND','CN','970-432-6984',NULL,'hills.vladimir@example.com','Beth Nicolas',NULL,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,NULL,NULL);
INSERT INTO `suppliers` VALUES (2,'Runolfsson, Fisher and Hoppe','9331 Hickle Mount',NULL,'Madalineburgh','PA','CU','605.969.3422x639',NULL,'ddoyle@example.net','Ada Kerluke IV',NULL,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,NULL,NULL);
INSERT INTO `suppliers` VALUES (3,'Schaden Inc','35332 Ziemann Walk Apt. 031',NULL,'Kuhlmanburgh','MA','ET','(013)022-3370x30461',NULL,'mayert.geo@example.org','Dr. Marty Wunsch III',NULL,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,NULL,NULL);
INSERT INTO `suppliers` VALUES (4,'Price PLC','0331 Verla Plaza Apt. 381',NULL,'Smithbury','KY','MH','1-466-132-0719',NULL,'vpollich@example.org','Jayden Hodkiewicz',NULL,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,NULL,NULL);
INSERT INTO `suppliers` VALUES (5,'Becker Group','81506 Vandervort Isle',NULL,'Geovanyfort','AK','GD','(650)841-9251x69764',NULL,'bernier.akeem@example.com','Mr. Nick Halvorson V',NULL,'2016-02-23 22:11:56','2016-02-23 22:11:56',0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;
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

LOCK TABLES `throttle` WRITE;
/*!40000 ALTER TABLE `throttle` DISABLE KEYS */;
/*!40000 ALTER TABLE `throttle` ENABLE KEYS */;
UNLOCK TABLES;
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
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jobtitle` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `employee_num` text COLLATE utf8_unicode_ci,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `remember_token` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'snipe@snipe.net','$2y$10$UO62GxS.cGLnxq7gpitkfOZh8w4xZULpX54ZwhZtdJ/LUdrs68sFO',NULL,1,NULL,NULL,NULL,NULL,NULL,'Alison','Gianotto','2016-02-20 06:54:17','2016-02-20 06:54:24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin',NULL,NULL,'PKylEuqriFqaJeldRS9GT2ewi1DihN2vG9rOyxCVlU9t54FZGAoo5faz6qRn');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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

-- MySQL dump 10.13  Distrib 5.7.13, for Linux (x86_64)
--
-- Host: localhost    Database: snipeit
-- ------------------------------------------------------
-- Server version	5.7.13-0ubuntu0.16.04.2

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
-- Current Database: `snipeit`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `snipeit` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `snipeit`;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accessories`
--

LOCK TABLES `accessories` WRITE;
/*!40000 ALTER TABLE `accessories` DISABLE KEYS */;
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
  `thread_id` int(11) DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asset_logs_thread_id_index` (`thread_id`)
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
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
  `total_qty` int(11) NOT NULL DEFAULT '1',
  `order_number` int(11) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(13,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `min_amt` int(11) DEFAULT NULL,
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
  `model_no` int(11) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `item_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumables`
--

LOCK TABLES `consumables` WRITE;
/*!40000 ALTER TABLE `consumables` DISABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields`
--

LOCK TABLES `custom_fields` WRITE;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
INSERT INTO `custom_fields` VALUES (1,'MAC Address','regex:/^[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}$/','text',NULL,'2016-07-23 20:53:58',NULL);
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
  `serial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manufacturers`
--

LOCK TABLES `manufacturers` WRITE;
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;
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
INSERT INTO `migrations` VALUES ('2012_12_06_225921_migration_cartalyst_sentry_install_users',1),('2012_12_06_225929_migration_cartalyst_sentry_install_groups',1),('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot',1),('2012_12_06_225988_migration_cartalyst_sentry_install_throttle',1),('2013_03_23_193214_update_users_table',1),('2013_11_13_075318_create_models_table',1),('2013_11_13_075335_create_categories_table',1),('2013_11_13_075347_create_manufacturers_table',1),('2013_11_15_015858_add_user_id_to_categories',1),('2013_11_15_112701_add_user_id_to_manufacturers',1),('2013_11_15_190327_create_assets_table',1),('2013_11_15_190357_create_licenses_table',1),('2013_11_15_201848_add_license_name_to_licenses',1),('2013_11_16_040323_create_depreciations_table',1),('2013_11_16_042851_add_depreciation_id_to_models',1),('2013_11_16_084923_add_user_id_to_models',1),('2013_11_16_103258_create_locations_table',1),('2013_11_16_103336_add_location_id_to_assets',1),('2013_11_16_103407_add_checkedout_to_to_assets',1),('2013_11_16_103425_create_history_table',1),('2013_11_17_054359_drop_licenses_table',1),('2013_11_17_054526_add_physical_to_assets',1),('2013_11_17_055126_create_settings_table',1),('2013_11_17_062634_add_license_to_assets',1),('2013_11_18_134332_add_contacts_to_users',1),('2013_11_18_142847_add_info_to_locations',1),('2013_11_18_152942_remove_location_id_from_asset',1),('2013_11_18_164423_set_nullvalues_for_user',1),('2013_11_19_013337_create_asset_logs_table',1),('2013_11_19_061409_edit_added_on_asset_logs_table',1),('2013_11_19_062250_edit_location_id_asset_logs_table',1),('2013_11_20_055822_add_soft_delete_on_assets',1),('2013_11_20_121404_add_soft_delete_on_locations',1),('2013_11_20_123137_add_soft_delete_on_manufacturers',1),('2013_11_20_123725_add_soft_delete_on_categories',1),('2013_11_20_130248_create_status_labels',1),('2013_11_20_130830_add_status_id_on_assets_table',1),('2013_11_20_131544_add_status_type_on_status_labels',1),('2013_11_20_134103_add_archived_to_assets',1),('2013_11_21_002321_add_uploads_table',1),('2013_11_21_024531_remove_deployable_boolean_from_status_labels',1),('2013_11_22_075308_add_option_label_to_settings_table',1),('2013_11_22_213400_edits_to_settings_table',1),('2013_11_25_013244_create_licenses_table',1),('2013_11_25_031458_create_license_seats_table',1),('2013_11_25_032022_add_type_to_actionlog_table',1),('2013_11_25_033008_delete_bad_licenses_table',1),('2013_11_25_033131_create_new_licenses_table',1),('2013_11_25_033534_add_licensed_to_licenses_table',1),('2013_11_25_101308_add_warrantee_to_assets_table',1),('2013_11_25_104343_alter_warranty_column_on_assets',1),('2013_11_25_150450_drop_parent_from_categories',1),('2013_11_25_151920_add_depreciate_to_assets',1),('2013_11_25_152903_add_depreciate_to_licenses_table',1),('2013_11_26_211820_drop_license_from_assets_table',1),('2013_11_27_062510_add_note_to_asset_logs_table',1),('2013_12_01_113426_add_filename_to_asset_log',1),('2013_12_06_094618_add_nullable_to_licenses_table',1),('2013_12_10_084038_add_eol_on_models_table',1),('2013_12_12_055218_add_manager_to_users_table',1),('2014_01_28_031200_add_qr_code_to_settings_table',1),('2014_02_13_183016_add_qr_text_to_settings_table',1),('2014_05_24_093839_alter_default_license_depreciation_id',1),('2014_05_27_231658_alter_default_values_licenses',1),('2014_06_19_191508_add_asset_name_to_settings',1),('2014_06_20_004847_make_asset_log_checkedout_to_nullable',1),('2014_06_20_005050_make_asset_log_purchasedate_to_nullable',1),('2014_06_24_003011_add_suppliers',1),('2014_06_24_010742_add_supplier_id_to_asset',1),('2014_06_24_012839_add_zip_to_supplier',1),('2014_06_24_033908_add_url_to_supplier',1),('2014_07_08_054116_add_employee_id_to_users',1),('2014_07_09_134316_add_requestable_to_assets',1),('2014_07_17_085822_add_asset_to_software',1),('2014_07_17_161625_make_asset_id_in_logs_nullable',1),('2014_08_12_053504_alpha_0_4_2_release',1),('2014_08_17_083523_make_location_id_nullable',1),('2014_10_16_200626_add_rtd_location_to_assets',1),('2014_10_24_000417_alter_supplier_state_to_32',1),('2014_10_24_015641_add_display_checkout_date',1),('2014_10_28_222654_add_avatar_field_to_users_table',1),('2014_10_29_045924_add_image_field_to_models_table',1),('2014_11_01_214955_add_eol_display_to_settings',1),('2014_11_04_231416_update_group_field_for_reporting',1),('2014_11_05_212408_add_fields_to_licenses',1),('2014_11_07_021042_add_image_to_supplier',1),('2014_11_20_203007_add_username_to_user',1),('2014_11_20_223947_add_auto_to_settings',1),('2014_11_20_224421_add_prefix_to_settings',1),('2014_11_21_104401_change_licence_type',1),('2014_12_09_082500_add_fields_maintained_term_to_licenses',1),('2015_02_04_155757_increase_user_field_lengths',1),('2015_02_07_013537_add_soft_deleted_to_log',1),('2015_02_10_040958_fix_bad_assigned_to_ids',1),('2015_02_10_053310_migrate_data_to_new_statuses',1),('2015_02_11_044104_migrate_make_license_assigned_null',1),('2015_02_11_104406_migrate_create_requests_table',1),('2015_02_12_001312_add_mac_address_to_asset',1),('2015_02_12_024100_change_license_notes_type',1),('2015_02_17_231020_add_localonly_to_settings',1),('2015_02_19_222322_add_logo_and_colors_to_settings',1),('2015_02_24_072043_add_alerts_to_settings',1),('2015_02_25_022931_add_eula_fields',1),('2015_02_25_204513_add_accessories_table',1),('2015_02_26_091228_add_accessories_user_table',1),('2015_02_26_115128_add_deleted_at_models',1),('2015_02_26_233005_add_category_type',1),('2015_03_01_231912_update_accepted_at_to_acceptance_id',1),('2015_03_05_011929_add_qr_type_to_settings',1),('2015_03_18_055327_add_note_to_user',1),('2015_04_29_234704_add_slack_to_settings',1),('2015_05_04_085151_add_parent_id_to_locations_table',1),('2015_05_22_124421_add_reassignable_to_licenses',1),('2015_06_10_003314_fix_default_for_user_notes',1),('2015_06_10_003554_create_consumables',1),('2015_06_15_183253_move_email_to_username',1),('2015_06_23_070346_make_email_nullable',1),('2015_06_26_213716_create_asset_maintenances_table',1),('2015_07_04_212443_create_custom_fields_table',1),('2015_07_09_014359_add_currency_to_settings_and_locations',1),('2015_07_21_122022_add_expected_checkin_date_to_asset_logs',1),('2015_07_24_093845_add_checkin_email_to_category_table',1),('2015_07_25_055415_remove_email_unique_constraint',1),('2015_07_29_230054_add_thread_id_to_asset_logs_table',1),('2015_07_31_015430_add_accepted_to_assets',1),('2015_09_09_195301_add_custom_css_to_settings',1),('2015_09_21_235926_create_custom_field_custom_fieldset',1),('2015_09_22_000104_create_custom_fieldsets',1),('2015_09_22_003321_add_fieldset_id_to_assets',1),('2015_09_22_003413_migrate_mac_address',1),('2015_09_28_003314_fix_default_purchase_order',1),('2015_10_01_024551_add_accessory_consumable_price_info',1),('2015_10_12_192706_add_brand_to_settings',1),('2015_10_22_003314_fix_defaults_accessories',1),('2015_10_23_182625_add_checkout_time_and_expected_checkout_date_to_assets',1),('2015_11_05_061015_create_companies_table',1),('2015_11_05_061115_add_company_id_to_consumables_table',1),('2015_11_05_183749_image',1),('2015_11_06_092038_add_company_id_to_accessories_table',1),('2015_11_06_100045_add_company_id_to_users_table',1),('2015_11_06_134742_add_company_id_to_licenses_table',1),('2015_11_08_035832_add_company_id_to_assets_table',1),('2015_11_08_222305_add_ldap_fields_to_settings',1),('2015_11_15_151803_add_full_multiple_companies_support_to_settings_table',1),('2015_11_26_195528_import_ldap_settings',1),('2015_11_30_191504_remove_fk_company_id',1),('2015_12_21_193006_add_ldap_server_cert_ignore_to_settings_table',1),('2015_12_30_233509_add_timestamp_and_userId_to_custom_fields',1),('2015_12_30_233658_add_timestamp_and_userId_to_custom_fieldsets',1),('2016_01_28_041048_add_notes_to_models',1),('2016_02_19_070119_add_remember_token_to_users_table',1),('2016_02_19_073625_create_password_resets_table',1),('2016_03_02_193043_add_ldap_flag_to_users',1),('2016_03_02_220517_update_ldap_filter_to_longer_field',1),('2016_03_08_225351_create_components_table',1),('2016_03_09_024038_add_min_stock_to_tables',1),('2016_03_10_133849_add_locale_to_users',1),('2016_03_10_135519_add_locale_to_settings',1),('2016_03_11_185621_add_label_settings_to_settings',1),('2016_03_22_125911_fix_custom_fields_regexes',1),('2016_04_28_141554_add_show_to_users',1),('2016_05_16_164733_add_model_mfg_to_consumable',1),('2016_05_19_180351_add_alt_barcode_settings',1),('2016_05_19_191146_add_alter_interval',1),('2016_05_19_192226_add_inventory_threshold',1),('2016_05_20_024859_remove_option_keys_from_settings_table',1),('2016_05_20_143758_remove_option_value_from_settings_table',1),('2016_06_01_140218_add_email_domain_and_format_to_settings',1),('2016_06_22_160725_add_user_id_to_maintenances',1),('2016_07_13_150015_add_is_ad_to_settings',1),('2016_07_14_153609_add_ad_domain_to_settings',1),('2016_07_22_003348_fix_custom_fields_regex_stuff',1),('2016_07_22_054850_one_more_mac_addr_fix',1),('2016_07_22_143045_add_port_to_ldap_settings',1),('2016_07_22_153432_add_tls_to_ldap_settings',1);
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
  `modelno` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  `note` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'2016-07-23 21:17:54','2016-07-23 21:17:54',1,20,'Test Snipe #3',NULL,NULL,NULL,NULL,NULL,0,'0',1,NULL,NULL,'snipe@test.com',1,NULL,'QRCODE',NULL,NULL,NULL,'USD',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,'samaccountname','sn','givenname','uid=samaccountname',3,NULL,NULL,NULL,0,0,'en',30,2.62500,1.00000,0.21975,0.21975,0.50000,0.50000,0.07000,0.05000,9,8.50000,11.00000,0,1,1,'C128',1,30,5,'test.com','filastname','filastname',0,NULL,'389',0);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_labels`
--

LOCK TABLES `status_labels` WRITE;
/*!40000 ALTER TABLE `status_labels` DISABLE KEYS */;
INSERT INTO `status_labels` VALUES (1,'Pending',1,NULL,NULL,NULL,0,1,0,'These assets are not yet ready to be deployed, usually because of configuration or waiting on parts.'),(2,'Ready to Deploy',1,NULL,NULL,NULL,1,0,0,'These assets are ready to deploy.'),(3,'Archived',1,NULL,NULL,NULL,0,0,1,'These assets are no longer in circulation or viable.');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
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
  PRIMARY KEY (`id`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'snipe@test.com','$2y$10$dCsBcTMvcK9AL2Tddpp2FeCqHFni4gZXxINX.wBvHguLYkaA9W7Hi','{\"superuser\":1}',1,NULL,NULL,NULL,NULL,NULL,'Snipe','Tester','2016-07-23 21:17:54','2016-07-23 21:17:54',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'snipeit',NULL,NULL,NULL,0,'en',1);
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

-- Dump completed on 2016-07-23 11:20:04
