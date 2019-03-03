-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: nc3_unittest_new
-- ------------------------------------------------------
-- Server version	5.6.40-log

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
-- Table structure for table `access_counter_frame_settings`
--

DROP TABLE IF EXISTS `access_counter_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_counter_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `display_type` int(4) NOT NULL DEFAULT '0' COMMENT '表示タイプ',
  `display_digit` int(4) NOT NULL DEFAULT '3' COMMENT '表示桁数',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_counter_frame_settings`
--

LOCK TABLES `access_counter_frame_settings` WRITE;
/*!40000 ALTER TABLE `access_counter_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `access_counter_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `access_counters`
--

DROP TABLE IF EXISTS `access_counters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_counters` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_key` varchar(255) NOT NULL COMMENT 'ブロックKey',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT 'カウント数',
  `count_start` int(11) NOT NULL DEFAULT '0' COMMENT 'カウント開始値',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_key` (`block_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_counters`
--

LOCK TABLES `access_counters` WRITE;
/*!40000 ALTER TABLE `access_counters` DISABLE KEYS */;
/*!40000 ALTER TABLE `access_counters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `language_id` int(6) NOT NULL,
  `block_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL COMMENT 'コンテンツキー',
  `status` int(4) NOT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新コンテンツかどうか 0:最新でない 1:最新',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `content` text COMMENT '本文',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (2,2,5,'announcement_key_1',1,1,1,1,0,0,'<p>Private Announcement Content</p>',1,'2019-03-02 03:35:06',1,'2019-03-02 03:35:06'),(3,2,6,'announcement_key_2',1,0,0,1,0,0,'<p>Public Announcement Content</p>',1,'2019-03-02 03:35:45',1,'2019-03-02 03:35:45'),(4,2,6,'announcement_key_2',1,1,1,1,0,0,'<p>Public Announcement Content 1</p>',1,'2019-03-02 03:35:45',1,'2019-03-02 03:37:47'),(5,2,8,'announcement_key_4',1,1,1,1,0,0,'<p>Public Announcement Content 2</p>',1,'2019-03-02 03:38:17',1,'2019-03-02 03:38:17'),(6,2,9,'announcement_key_5',2,0,1,1,0,0,'<p>Public Announcement Content 3</p>',4,'2019-03-02 03:45:30',4,'2019-03-02 03:45:30'),(7,2,10,'announcement_key_6',1,1,1,1,0,0,'<p>Community Room 2 Announcement Content 1</p>',1,'2019-03-02 03:52:16',1,'2019-03-02 03:52:16'),(8,2,11,'announcement_key_7',1,1,1,1,0,0,'<p>Community Room 1 Announcement Content 1</p>',1,'2019-03-02 03:52:39',1,'2019-03-02 03:52:39'),(9,2,12,'announcement_key_8',1,1,1,1,0,0,'<p>Top page Announcement Content</p>',1,'2019-03-02 13:45:12',1,'2019-03-02 13:45:12');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authorization_keys`
--

DROP TABLE IF EXISTS `authorization_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authorization_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `model` varchar(255) NOT NULL,
  `content_id` int(11) NOT NULL,
  `additional_id` varchar(255) DEFAULT NULL,
  `authorization_key` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`content_id`,`additional_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authorization_keys`
--

LOCK TABLES `authorization_keys` WRITE;
/*!40000 ALTER TABLE `authorization_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `authorization_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bbs_article_trees`
--

DROP TABLE IF EXISTS `bbs_article_trees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bbs_article_trees` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bbs_key` varchar(255) NOT NULL COMMENT '掲示板キー',
  `bbs_article_key` varchar(255) NOT NULL COMMENT '記事キー',
  `root_id` int(11) DEFAULT NULL COMMENT '根記事ID',
  `parent_id` int(11) DEFAULT NULL COMMENT '親記事のID treeビヘイビア必須カラム',
  `lft` int(11) NOT NULL COMMENT 'treeビヘイビア必須カラム',
  `rght` int(11) NOT NULL COMMENT 'treeビヘイビア必須カラム',
  `article_no` int(11) NOT NULL DEFAULT '1' COMMENT ' 記事毎の採番',
  `bbs_article_child_count` int(11) NOT NULL DEFAULT '0' COMMENT '公開されたコメント数',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `bbs_article_key` (`bbs_article_key`),
  KEY `root_id` (`root_id`,`bbs_key`,`lft`,`rght`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bbs_article_trees`
--

LOCK TABLES `bbs_article_trees` WRITE;
/*!40000 ALTER TABLE `bbs_article_trees` DISABLE KEYS */;
/*!40000 ALTER TABLE `bbs_article_trees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bbs_articles`
--

DROP TABLE IF EXISTS `bbs_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bbs_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bbs_key` varchar(255) DEFAULT NULL COMMENT '掲示板Key',
  `block_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '公開状況 1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新コンテンツかどうか 0:最新でない 1:最新',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `key` varchar(255) NOT NULL COMMENT 'キー',
  `title` varchar(255) NOT NULL COMMENT 'タイトル',
  `title_icon` varchar(255) DEFAULT NULL,
  `content` text COMMENT '本文',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `bbs_key` (`bbs_key`,`language_id`),
  KEY `key` (`key`,`language_id`),
  KEY `title` (`id`,`is_active`,`is_latest`,`created_user`,`is_origin`,`is_translation`,`key`),
  KEY `created` (`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bbs_articles`
--

LOCK TABLES `bbs_articles` WRITE;
/*!40000 ALTER TABLE `bbs_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `bbs_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bbs_frame_settings`
--

DROP TABLE IF EXISTS `bbs_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bbs_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `display_type` varchar(45) DEFAULT 'flat',
  `articles_per_page` int(11) NOT NULL DEFAULT '10' COMMENT '表示記事数 1件、5件、10件、20件、50件、100件',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bbs_frame_settings`
--

LOCK TABLES `bbs_frame_settings` WRITE;
/*!40000 ALTER TABLE `bbs_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `bbs_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bbses`
--

DROP TABLE IF EXISTS `bbses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bbses` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(255) NOT NULL COMMENT '掲示板キー',
  `block_id` int(11) NOT NULL,
  `language_id` int(6) NOT NULL DEFAULT '2' COMMENT '言語ID',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `name` varchar(255) NOT NULL COMMENT '掲示板名称',
  `bbs_article_modified` datetime DEFAULT NULL COMMENT '記事の最終更新日時',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `key` (`key`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bbses`
--

LOCK TABLES `bbses` WRITE;
/*!40000 ALTER TABLE `bbses` DISABLE KEYS */;
/*!40000 ALTER TABLE `bbses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `block_role_permissions`
--

DROP TABLE IF EXISTS `block_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `block_role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_room_id` int(11) NOT NULL,
  `block_key` varchar(255) NOT NULL,
  `permission` varchar(255) NOT NULL COMMENT 'パーミッション  e.g.) content_creatable,  post_top_article',
  `value` tinyint(1) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_room_id` (`roles_room_id`,`block_key`),
  KEY `block_key` (`block_key`,`permission`,`roles_room_id`,`value`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `block_role_permissions`
--

LOCK TABLES `block_role_permissions` WRITE;
/*!40000 ALTER TABLE `block_role_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `block_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `block_settings`
--

DROP TABLE IF EXISTS `block_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `block_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_key` varchar(255) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `block_key` varchar(255) DEFAULT NULL,
  `field_name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plugin_key` (`plugin_key`,`room_id`,`block_key`,`field_name`),
  KEY `block_key` (`block_key`,`field_name`,`room_id`,`plugin_key`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `block_settings`
--

LOCK TABLES `block_settings` WRITE;
/*!40000 ALTER TABLE `block_settings` DISABLE KEYS */;
INSERT INTO `block_settings` VALUES (1,'bbses',NULL,NULL,'use_like','1','boolean',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(2,'bbses',NULL,NULL,'use_unlike','1','boolean',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(3,'bbses',NULL,NULL,'use_comment','1','boolean',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(4,'blogs',NULL,NULL,'use_like','1','boolean',NULL,'2019-03-02 03:14:17',NULL,'2019-03-02 03:14:17'),(5,'blogs',NULL,NULL,'use_unlike','1','boolean',NULL,'2019-03-02 03:14:17',NULL,'2019-03-02 03:14:17'),(6,'blogs',NULL,NULL,'use_comment','1','boolean',NULL,'2019-03-02 03:14:17',NULL,'2019-03-02 03:14:17'),(7,'blogs',NULL,NULL,'use_sns','1','boolean',NULL,'2019-03-02 03:14:17',NULL,'2019-03-02 03:14:17'),(8,'faqs',NULL,NULL,'use_like','0','boolean',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(9,'faqs',NULL,NULL,'use_unlike','0','boolean',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(10,'multidatabases',NULL,NULL,'use_like','1','boolean',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(11,'multidatabases',NULL,NULL,'use_unlike','1','boolean',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(12,'multidatabases',NULL,NULL,'use_comment','1','boolean',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(13,'photo_albums',NULL,NULL,'use_like','0','boolean',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(14,'photo_albums',NULL,NULL,'use_unlike','0','boolean',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(15,'photo_albums',NULL,NULL,'use_comment','0','boolean',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(16,'tasks',NULL,NULL,'use_comment','1','boolean',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(17,'videos',NULL,NULL,'use_like','1','boolean',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(18,'videos',NULL,NULL,'use_unlike','0','boolean',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(19,'videos',NULL,NULL,'use_comment','1','boolean',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(20,'videos',NULL,NULL,'auto_play','0','boolean',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(21,'announcements',5,'block_key_2','use_workflow','0','boolean',1,'2019-03-02 03:35:06',1,'2019-03-02 03:35:06'),(22,'announcements',1,'block_key_3','use_workflow','1','boolean',1,'2019-03-02 03:35:45',1,'2019-03-02 03:37:47'),(23,'calendars',1,'block_key_4','use_workflow','1','boolean',1,'2019-03-02 03:35:59',1,'2019-03-02 03:35:59'),(24,'announcements',1,'block_key_5','use_workflow','1','boolean',1,'2019-03-02 03:38:17',1,'2019-03-02 03:38:17'),(25,'announcements',1,'block_key_6','use_workflow','1','boolean',4,'2019-03-02 03:45:30',4,'2019-03-02 03:45:30'),(26,'announcements',11,'block_key_7','use_workflow','0','boolean',1,'2019-03-02 03:52:16',1,'2019-03-02 03:52:16'),(27,'announcements',8,'block_key_8','use_workflow','0','boolean',1,'2019-03-02 03:52:39',1,'2019-03-02 03:52:39'),(28,'announcements',1,'block_key_9','use_workflow','1','boolean',1,'2019-03-02 13:45:12',1,'2019-03-02 13:45:12');
/*!40000 ALTER TABLE `block_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `plugin_key` varchar(255) NOT NULL COMMENT 'プラグインKey',
  `key` varchar(255) NOT NULL COMMENT 'ブロックKey',
  `public_type` int(4) NOT NULL DEFAULT '1' COMMENT '公開タイプ（0:非公開, 1:公開, 2:期間限定公開。期間限定公開の場合、現在時刻がfrom-toカラムの範囲内の時に公開。）',
  `publish_start` datetime DEFAULT NULL COMMENT '公開日時(from)',
  `publish_end` datetime DEFAULT NULL COMMENT '公開日時(to)',
  `content_count` int(11) NOT NULL DEFAULT '0',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`key`),
  KEY `room_id` (`room_id`,`plugin_key`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks`
--

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
INSERT INTO `blocks` VALUES (2,1,'menus','block_ins_2',1,NULL,NULL,0,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:08'),(5,5,'announcements','block_key_2',1,NULL,NULL,0,1,'2019-03-02 03:35:06',1,'2019-03-02 03:35:06'),(6,1,'announcements','block_key_3',1,NULL,NULL,0,1,'2019-03-02 03:35:45',1,'2019-03-02 03:37:47'),(7,1,'calendars','block_key_4',1,NULL,NULL,0,1,'2019-03-02 03:35:59',1,'2019-03-02 03:50:04'),(8,1,'announcements','block_key_5',1,NULL,NULL,0,1,'2019-03-02 03:38:17',1,'2019-03-02 03:38:17'),(9,1,'announcements','block_key_6',1,NULL,NULL,0,4,'2019-03-02 03:45:30',4,'2019-03-02 03:45:30'),(10,11,'announcements','block_key_7',1,NULL,NULL,0,1,'2019-03-02 03:52:16',1,'2019-03-02 03:52:16'),(11,8,'announcements','block_key_8',1,NULL,NULL,0,1,'2019-03-02 03:52:39',1,'2019-03-02 03:52:39'),(12,1,'announcements','block_key_9',1,NULL,NULL,0,1,'2019-03-02 13:45:12',1,'2019-03-02 13:45:12');
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blocks_languages`
--

DROP TABLE IF EXISTS `blocks_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `block_id` int(11) NOT NULL COMMENT 'ブロックID',
  `name` varchar(255) DEFAULT NULL COMMENT 'ブロック名',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`block_id`,`is_translation`,`language_id`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks_languages`
--

LOCK TABLES `blocks_languages` WRITE;
/*!40000 ALTER TABLE `blocks_languages` DISABLE KEYS */;
INSERT INTO `blocks_languages` VALUES (2,2,2,NULL,1,0,0,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:08'),(3,2,5,'Private Announcement Content',1,0,0,1,'2019-03-02 03:35:06',1,'2019-03-02 03:35:06'),(4,2,6,'Public Announcement Content 1',1,0,0,1,'2019-03-02 03:35:45',1,'2019-03-02 03:37:47'),(5,2,8,'Public Announcement Content 2',1,0,0,1,'2019-03-02 03:38:17',1,'2019-03-02 03:38:17'),(6,2,9,'Public Announcement Content 3',1,0,0,4,'2019-03-02 03:45:30',4,'2019-03-02 03:45:30'),(7,2,7,'',1,0,0,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(8,2,10,'Community Room 2 Announcement Content 1',1,0,0,1,'2019-03-02 03:52:16',1,'2019-03-02 03:52:16'),(9,2,11,'Community Room 1 Announcement Content 1',1,0,0,1,'2019-03-02 03:52:39',1,'2019-03-02 03:52:39'),(10,2,12,'Top page Announcement Content',1,0,0,1,'2019-03-02 13:45:12',1,'2019-03-02 13:45:12');
/*!40000 ALTER TABLE `blocks_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_entries`
--

DROP TABLE IF EXISTS `blog_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `blog_key` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL COMMENT 'カテゴリーID',
  `block_id` int(11) DEFAULT NULL,
  `key` varchar(255) NOT NULL,
  `status` int(4) NOT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_latest` tinyint(1) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `title` varchar(255) DEFAULT NULL COMMENT 'タイトル',
  `title_icon` varchar(255) DEFAULT NULL,
  `body1` text COMMENT '本文1',
  `body2` text COMMENT '本文2',
  `public_type` int(4) NOT NULL DEFAULT '2',
  `publish_start` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_entries`
--

LOCK TABLES `blog_entries` WRITE;
/*!40000 ALTER TABLE `blog_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_frame_settings`
--

DROP TABLE IF EXISTS `blog_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `articles_per_page` int(11) NOT NULL DEFAULT '10' COMMENT '表示件数',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_frame_settings`
--

LOCK TABLES `blog_frame_settings` WRITE;
/*!40000 ALTER TABLE `blog_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_id` int(11) NOT NULL,
  `language_id` int(6) DEFAULT '2' COMMENT '言語ID',
  `name` varchar(255) NOT NULL COMMENT 'BLOG名',
  `key` varchar(255) NOT NULL COMMENT 'BLOGキー',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boxes`
--

DROP TABLE IF EXISTS `boxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `container_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT 'ボックスタイプ 1:サイト全体, 2:スペース, 3:ルーム, 4:ページ',
  `space_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `container_type` int(4) DEFAULT NULL COMMENT 'コンテナータイプ.  1:Header, 2:Major, 3:Main, 4:Minor, 5:Footer',
  `weight` int(11) DEFAULT NULL COMMENT '表示順序',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`room_id`,`container_type`,`type`,`id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boxes`
--

LOCK TABLES `boxes` WRITE;
/*!40000 ALTER TABLE `boxes` DISABLE KEYS */;
INSERT INTO `boxes` VALUES (1,1,4,2,1,1,1,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:08'),(2,2,4,2,1,1,2,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:08'),(3,3,4,2,1,1,3,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:09'),(4,4,4,2,1,1,4,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:09'),(5,5,4,2,1,1,5,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:09'),(6,6,4,3,2,2,1,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(7,7,4,3,2,2,2,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(8,8,4,3,2,2,3,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(9,9,4,3,2,2,4,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(10,10,4,4,2,2,5,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(11,11,4,4,3,3,1,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(12,12,4,4,3,3,2,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(13,13,4,4,3,3,3,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(14,14,4,4,3,3,4,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(15,15,4,4,3,3,5,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(16,16,4,2,1,4,3,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(17,NULL,1,1,1,NULL,1,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(18,NULL,1,1,1,NULL,2,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(19,NULL,1,1,1,NULL,4,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(20,NULL,1,1,1,NULL,5,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(21,NULL,2,2,1,NULL,1,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(22,NULL,2,3,2,NULL,1,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(23,NULL,2,4,3,NULL,1,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(24,NULL,2,2,1,NULL,2,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(25,NULL,2,3,2,NULL,2,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(26,NULL,2,4,3,NULL,2,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(27,NULL,2,2,1,NULL,4,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(28,NULL,2,3,2,NULL,4,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(29,NULL,2,4,3,NULL,4,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(30,NULL,2,2,1,NULL,5,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(31,NULL,2,3,2,NULL,5,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(32,NULL,2,4,3,NULL,5,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(36,NULL,3,2,1,NULL,1,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(37,NULL,3,3,2,NULL,1,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(38,NULL,3,4,3,NULL,1,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(39,NULL,3,2,1,NULL,2,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(40,NULL,3,3,2,NULL,2,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(41,NULL,3,4,3,NULL,2,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(42,NULL,3,2,1,NULL,4,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(43,NULL,3,3,2,NULL,4,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(44,NULL,3,4,3,NULL,4,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(45,NULL,3,2,1,NULL,5,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(46,NULL,3,3,2,NULL,5,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(47,NULL,3,4,3,NULL,5,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(51,NULL,4,2,1,4,1,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(52,NULL,4,2,1,4,2,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(53,NULL,4,2,1,4,4,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(54,NULL,4,2,1,4,5,NULL,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(58,NULL,3,3,5,NULL,1,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(59,NULL,3,3,5,NULL,2,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(60,NULL,3,3,5,NULL,4,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(61,NULL,3,3,5,NULL,5,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(62,NULL,4,3,5,5,1,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(63,NULL,4,3,5,5,2,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(64,NULL,4,3,5,5,3,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(65,NULL,4,3,5,5,4,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(66,NULL,4,3,5,5,5,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(67,NULL,3,3,6,NULL,1,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(68,NULL,3,3,6,NULL,2,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(69,NULL,3,3,6,NULL,4,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(70,NULL,3,3,6,NULL,5,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(71,NULL,4,3,6,6,1,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(72,NULL,4,3,6,6,2,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(73,NULL,4,3,6,6,3,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(74,NULL,4,3,6,6,4,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(75,NULL,4,3,6,6,5,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(76,NULL,3,3,7,NULL,1,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(77,NULL,3,3,7,NULL,2,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(78,NULL,3,3,7,NULL,4,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(79,NULL,3,3,7,NULL,5,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(80,NULL,4,3,7,7,1,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(81,NULL,4,3,7,7,2,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(82,NULL,4,3,7,7,3,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(83,NULL,4,3,7,7,4,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(84,NULL,4,3,7,7,5,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(85,NULL,3,4,8,NULL,1,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(86,NULL,3,4,8,NULL,2,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(87,NULL,3,4,8,NULL,4,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(88,NULL,3,4,8,NULL,5,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(89,NULL,4,4,8,8,1,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(90,NULL,4,4,8,8,2,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(91,NULL,4,4,8,8,3,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(92,NULL,4,4,8,8,4,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(93,NULL,4,4,8,8,5,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(94,NULL,3,2,9,NULL,1,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(95,NULL,3,2,9,NULL,2,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(96,NULL,3,2,9,NULL,4,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(97,NULL,3,2,9,NULL,5,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(98,NULL,4,2,9,9,1,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(99,NULL,4,2,9,9,2,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(100,NULL,4,2,9,9,3,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(101,NULL,4,2,9,9,4,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(102,NULL,4,2,9,9,5,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(103,NULL,4,2,1,10,1,NULL,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(104,NULL,4,2,1,10,2,NULL,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(105,NULL,4,2,1,10,3,NULL,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(106,NULL,4,2,1,10,4,NULL,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(107,NULL,4,2,1,10,5,NULL,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(108,NULL,4,2,1,11,1,NULL,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(109,NULL,4,2,1,11,2,NULL,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(110,NULL,4,2,1,11,3,NULL,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(111,NULL,4,2,1,11,4,NULL,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(112,NULL,4,2,1,11,5,NULL,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(113,NULL,4,2,1,12,1,NULL,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(114,NULL,4,2,1,12,2,NULL,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(115,NULL,4,2,1,12,3,NULL,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(116,NULL,4,2,1,12,4,NULL,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(117,NULL,4,2,1,12,5,NULL,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(118,NULL,3,3,10,NULL,1,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(119,NULL,3,3,10,NULL,2,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(120,NULL,3,3,10,NULL,4,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(121,NULL,3,3,10,NULL,5,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(122,NULL,4,3,10,13,1,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(123,NULL,4,3,10,13,2,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(124,NULL,4,3,10,13,3,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(125,NULL,4,3,10,13,4,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(126,NULL,4,3,10,13,5,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(127,NULL,3,4,11,NULL,1,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(128,NULL,3,4,11,NULL,2,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(129,NULL,3,4,11,NULL,4,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(130,NULL,3,4,11,NULL,5,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(131,NULL,4,4,11,14,1,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(132,NULL,4,4,11,14,2,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(133,NULL,4,4,11,14,3,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(134,NULL,4,4,11,14,4,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(135,NULL,4,4,11,14,5,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(136,NULL,3,3,12,NULL,1,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(137,NULL,3,3,12,NULL,2,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(138,NULL,3,3,12,NULL,4,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(139,NULL,3,3,12,NULL,5,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(140,NULL,4,3,12,15,1,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(141,NULL,4,3,12,15,2,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(142,NULL,4,3,12,15,3,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(143,NULL,4,3,12,15,4,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(144,NULL,4,3,12,15,5,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `boxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boxes_page_containers`
--

DROP TABLE IF EXISTS `boxes_page_containers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boxes_page_containers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_container_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `container_type` int(4) DEFAULT NULL COMMENT 'コンテナータイプ.  1:Header, 2:Major, 3:Main, 4:Minor, 5:Footer',
  `box_id` int(11) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '1' COMMENT 'ボックスの表示・非表示',
  `weight` int(11) DEFAULT NULL COMMENT 'ボックスの並び順',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`,`container_type`),
  KEY `box_id` (`box_id`),
  KEY `page_container_id` (`page_container_id`,`is_published`,`box_id`,`weight`)
) ENGINE=InnoDB AUTO_INCREMENT=319 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boxes_page_containers`
--

LOCK TABLES `boxes_page_containers` WRITE;
/*!40000 ALTER TABLE `boxes_page_containers` DISABLE KEYS */;
INSERT INTO `boxes_page_containers` VALUES (1,1,1,1,17,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(2,6,2,1,17,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(3,11,3,1,17,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(4,16,4,1,17,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(5,2,1,2,18,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(6,7,2,2,18,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(7,12,3,2,18,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(8,17,4,2,18,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(9,4,1,4,19,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(10,9,2,4,19,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(11,14,3,4,19,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(12,19,4,4,19,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(13,5,1,5,20,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(14,10,2,5,20,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(15,15,3,5,20,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(16,20,4,5,20,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(32,1,1,1,21,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(33,16,4,1,21,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(34,6,2,1,22,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(35,11,3,1,23,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(36,2,1,2,24,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(37,17,4,2,24,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(38,7,2,2,25,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(39,12,3,2,26,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(40,4,1,4,27,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(41,19,4,4,27,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(42,9,2,4,28,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(43,14,3,4,29,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(44,5,1,5,30,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(45,20,4,5,30,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(46,10,2,5,31,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(47,15,3,5,32,0,2,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(63,1,1,1,36,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(64,16,4,1,36,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(65,6,2,1,37,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(66,11,3,1,38,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(67,2,1,2,39,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(68,17,4,2,39,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(69,7,2,2,40,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(70,12,3,2,41,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(71,4,1,4,42,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(72,19,4,4,42,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(73,9,2,4,43,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(74,14,3,4,44,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(75,5,1,5,45,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(76,20,4,5,45,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(77,10,2,5,46,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(78,15,3,5,47,0,3,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(94,1,1,1,1,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(95,2,1,2,2,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(96,4,1,4,4,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(97,5,1,5,5,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(98,6,2,1,6,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(99,7,2,2,7,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(100,9,2,4,9,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(101,10,2,5,10,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(102,11,3,1,11,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(103,12,3,2,12,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(104,14,3,4,14,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(105,15,3,5,15,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(106,16,4,1,51,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(107,17,4,2,52,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(108,19,4,4,53,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(109,20,4,5,54,0,4,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(125,3,1,3,3,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(126,8,2,3,8,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(127,13,3,3,13,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(128,18,4,3,16,1,1,NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(132,21,5,1,17,1,1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(133,22,5,2,18,1,1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(134,24,5,4,19,1,1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(135,25,5,5,20,1,1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(136,21,5,1,22,0,2,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(137,22,5,2,25,0,2,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(138,24,5,4,28,0,2,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(139,25,5,5,31,0,2,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(140,21,5,1,58,0,3,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(141,22,5,2,59,0,3,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(142,24,5,4,60,0,3,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(143,25,5,5,61,0,3,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(144,21,5,1,62,0,4,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(145,22,5,2,63,0,4,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(146,24,5,4,65,0,4,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(147,25,5,5,66,0,4,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(148,23,5,3,64,1,1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(149,26,6,1,17,1,1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(150,27,6,2,18,1,1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(151,29,6,4,19,1,1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(152,30,6,5,20,1,1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(153,26,6,1,22,0,2,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(154,27,6,2,25,0,2,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(155,29,6,4,28,0,2,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(156,30,6,5,31,0,2,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(157,26,6,1,67,0,3,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(158,27,6,2,68,0,3,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(159,29,6,4,69,0,3,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(160,30,6,5,70,0,3,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(161,26,6,1,71,0,4,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(162,27,6,2,72,0,4,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(163,29,6,4,74,0,4,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(164,30,6,5,75,0,4,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(165,28,6,3,73,1,1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(166,31,7,1,17,1,1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(167,32,7,2,18,1,1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(168,34,7,4,19,1,1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(169,35,7,5,20,1,1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(170,31,7,1,22,0,2,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(171,32,7,2,25,0,2,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(172,34,7,4,28,0,2,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(173,35,7,5,31,0,2,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(174,31,7,1,76,0,3,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(175,32,7,2,77,0,3,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(176,34,7,4,78,0,3,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(177,35,7,5,79,0,3,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(178,31,7,1,80,0,4,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(179,32,7,2,81,0,4,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(180,34,7,4,83,0,4,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(181,35,7,5,84,0,4,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(182,33,7,3,82,1,1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(183,36,8,1,17,1,1,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(184,37,8,2,18,1,1,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(185,39,8,4,19,1,1,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(186,40,8,5,20,1,1,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(187,36,8,1,23,0,2,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(188,37,8,2,26,0,2,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(189,39,8,4,29,0,2,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(190,40,8,5,32,0,2,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(191,36,8,1,85,0,3,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(192,37,8,2,86,0,3,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(193,39,8,4,87,0,3,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(194,40,8,5,88,0,3,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(195,36,8,1,89,0,4,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(196,37,8,2,90,0,4,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(197,39,8,4,92,0,4,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(198,40,8,5,93,0,4,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(199,38,8,3,91,1,1,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(200,41,9,1,17,1,1,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(201,42,9,2,18,1,1,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(202,44,9,4,19,1,1,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(203,45,9,5,20,1,1,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(204,41,9,1,21,0,2,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(205,42,9,2,24,0,2,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(206,44,9,4,27,0,2,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(207,45,9,5,30,0,2,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(208,41,9,1,94,0,3,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(209,42,9,2,95,0,3,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(210,44,9,4,96,0,3,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(211,45,9,5,97,0,3,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(212,41,9,1,98,0,4,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(213,42,9,2,99,0,4,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(214,44,9,4,101,0,4,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(215,45,9,5,102,0,4,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(216,43,9,3,100,1,1,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(217,46,10,1,17,1,1,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(218,47,10,2,18,1,1,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(219,49,10,4,19,1,1,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(220,50,10,5,20,1,1,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(221,46,10,1,21,0,2,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(222,47,10,2,24,0,2,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(223,49,10,4,27,0,2,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(224,50,10,5,30,0,2,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(225,46,10,1,36,0,3,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(226,47,10,2,39,0,3,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(227,49,10,4,42,0,3,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(228,50,10,5,45,0,3,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(229,46,10,1,103,0,4,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(230,47,10,2,104,0,4,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(231,49,10,4,106,0,4,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(232,50,10,5,107,0,4,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(233,48,10,3,105,1,1,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(234,51,11,1,17,1,1,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(235,52,11,2,18,1,1,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(236,54,11,4,19,1,1,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(237,55,11,5,20,1,1,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(238,51,11,1,21,0,2,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(239,52,11,2,24,0,2,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(240,54,11,4,27,0,2,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(241,55,11,5,30,0,2,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(242,51,11,1,36,0,3,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(243,52,11,2,39,0,3,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(244,54,11,4,42,0,3,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(245,55,11,5,45,0,3,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(246,51,11,1,108,0,4,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(247,52,11,2,109,0,4,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(248,54,11,4,111,0,4,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(249,55,11,5,112,0,4,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(250,53,11,3,110,1,1,1,'2019-03-02 03:22:22',1,'2019-03-02 03:22:22'),(251,56,12,1,17,1,1,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(252,57,12,2,18,1,1,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(253,59,12,4,19,1,1,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(254,60,12,5,20,1,1,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(255,56,12,1,21,0,2,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(256,57,12,2,24,0,2,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(257,59,12,4,27,0,2,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(258,60,12,5,30,0,2,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(259,56,12,1,36,0,3,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(260,57,12,2,39,0,3,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(261,59,12,4,42,0,3,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(262,60,12,5,45,0,3,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(263,56,12,1,113,0,4,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(264,57,12,2,114,0,4,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(265,59,12,4,116,0,4,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(266,60,12,5,117,0,4,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(267,58,12,3,115,1,1,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(268,61,13,1,17,1,1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(269,62,13,2,18,1,1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(270,64,13,4,19,1,1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(271,65,13,5,20,1,1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(272,61,13,1,22,0,2,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(273,62,13,2,25,0,2,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(274,64,13,4,28,0,2,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(275,65,13,5,31,0,2,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(276,61,13,1,118,0,3,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(277,62,13,2,119,0,3,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(278,64,13,4,120,0,3,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(279,65,13,5,121,0,3,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(280,61,13,1,122,0,4,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(281,62,13,2,123,0,4,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(282,64,13,4,125,0,4,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(283,65,13,5,126,0,4,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(284,63,13,3,124,1,1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(285,66,14,1,17,1,1,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(286,67,14,2,18,1,1,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(287,69,14,4,19,1,1,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(288,70,14,5,20,1,1,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(289,66,14,1,23,0,2,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(290,67,14,2,26,0,2,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(291,69,14,4,29,0,2,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(292,70,14,5,32,0,2,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(293,66,14,1,127,0,3,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(294,67,14,2,128,0,3,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(295,69,14,4,129,0,3,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(296,70,14,5,130,0,3,1,'2019-03-02 03:42:55',1,'2019-03-02 03:42:55'),(297,66,14,1,131,0,4,1,'2019-03-02 03:42:55',1,'2019-03-02 03:42:55'),(298,67,14,2,132,0,4,1,'2019-03-02 03:42:55',1,'2019-03-02 03:42:55'),(299,69,14,4,134,0,4,1,'2019-03-02 03:42:55',1,'2019-03-02 03:42:55'),(300,70,14,5,135,0,4,1,'2019-03-02 03:42:55',1,'2019-03-02 03:42:55'),(301,68,14,3,133,1,1,1,'2019-03-02 03:42:55',1,'2019-03-02 03:42:55'),(302,71,15,1,17,1,1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(303,72,15,2,18,1,1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(304,74,15,4,19,1,1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(305,75,15,5,20,1,1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(306,71,15,1,22,0,2,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(307,72,15,2,25,0,2,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(308,74,15,4,28,0,2,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(309,75,15,5,31,0,2,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(310,71,15,1,136,0,3,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(311,72,15,2,137,0,3,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(312,74,15,4,138,0,3,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(313,75,15,5,139,0,3,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(314,71,15,1,140,0,4,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(315,72,15,2,141,0,4,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(316,74,15,4,143,0,4,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(317,75,15,5,144,0,4,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(318,73,15,3,142,1,1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `boxes_page_containers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boxes_pages`
--

DROP TABLE IF EXISTS `boxes_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boxes_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `box_id` int(11) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT NULL COMMENT 'ボックスの表示・非表示',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `box_id` (`box_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boxes_pages`
--

LOCK TABLES `boxes_pages` WRITE;
/*!40000 ALTER TABLE `boxes_pages` DISABLE KEYS */;
INSERT INTO `boxes_pages` VALUES (1,1,1,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:09'),(2,1,2,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:09'),(3,1,3,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:09'),(4,1,4,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:09'),(5,1,5,1,NULL,'2019-03-02 03:14:08',NULL,'2019-03-02 03:14:09'),(6,2,6,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(7,2,7,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(8,2,8,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(9,2,9,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(10,2,10,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(11,3,11,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(12,3,12,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(13,3,13,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(14,3,14,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(15,3,15,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(16,4,1,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(17,4,2,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(18,4,16,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(19,4,4,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(20,4,5,1,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09');
/*!40000 ALTER TABLE `boxes_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cabinet_file_trees`
--

DROP TABLE IF EXISTS `cabinet_file_trees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cabinet_file_trees` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cabinet_key` varchar(255) NOT NULL COMMENT 'キャビネットキー',
  `cabinet_file_key` varchar(255) NOT NULL COMMENT 'ファイルキー',
  `parent_id` int(11) DEFAULT NULL COMMENT '親フォルダのID treeビヘイビア必須カラム',
  `lft` int(11) NOT NULL COMMENT 'lft  treeビヘイビア必須カラム',
  `rght` int(11) NOT NULL COMMENT 'rght  treeビヘイビア必須カラム',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `cabinet_key` (`cabinet_key`,`lft`,`rght`),
  KEY `lft` (`lft`,`rght`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabinet_file_trees`
--

LOCK TABLES `cabinet_file_trees` WRITE;
/*!40000 ALTER TABLE `cabinet_file_trees` DISABLE KEYS */;
/*!40000 ALTER TABLE `cabinet_file_trees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cabinet_files`
--

DROP TABLE IF EXISTS `cabinet_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cabinet_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cabinet_key` varchar(255) NOT NULL COMMENT 'キャビネットキー',
  `cabinet_file_tree_parent_id` int(11) DEFAULT NULL,
  `cabinet_file_tree_id` int(11) DEFAULT NULL,
  `key` varchar(255) NOT NULL,
  `is_folder` tinyint(1) NOT NULL DEFAULT '0',
  `use_auth_key` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(4) NOT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_latest` tinyint(1) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `filename` varchar(255) DEFAULT NULL COMMENT 'タイトル',
  `description` text COMMENT '概要',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `key` (`key`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabinet_files`
--

LOCK TABLES `cabinet_files` WRITE;
/*!40000 ALTER TABLE `cabinet_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `cabinet_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cabinets`
--

DROP TABLE IF EXISTS `cabinets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cabinets` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_id` int(11) NOT NULL,
  `language_id` int(6) DEFAULT '2' COMMENT '言語ID',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `name` varchar(255) NOT NULL COMMENT 'CABINET名',
  `key` varchar(255) NOT NULL COMMENT 'キャビネットキー',
  `total_size` float NOT NULL DEFAULT '0',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabinets`
--

LOCK TABLES `cabinets` WRITE;
/*!40000 ALTER TABLE `cabinets` DISABLE KEYS */;
/*!40000 ALTER TABLE `cabinets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_event_contents`
--

DROP TABLE IF EXISTS `calendar_event_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_event_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `content_key` varchar(255) NOT NULL COMMENT 'CONTENTキー',
  `calendar_event_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `calendar_event_id` (`calendar_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_event_contents`
--

LOCK TABLES `calendar_event_contents` WRITE;
/*!40000 ALTER TABLE `calendar_event_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar_event_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_event_share_users`
--

DROP TABLE IF EXISTS `calendar_event_share_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_event_share_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `calendar_event_id` int(11) NOT NULL,
  `share_user` int(11) DEFAULT '0' COMMENT '情報共有者',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `calendar_event_id` (`calendar_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_event_share_users`
--

LOCK TABLES `calendar_event_share_users` WRITE;
/*!40000 ALTER TABLE `calendar_event_share_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar_event_share_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_events`
--

DROP TABLE IF EXISTS `calendar_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `calendar_rrule_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL COMMENT 'イベントKey',
  `room_id` int(11) NOT NULL COMMENT 'ルームID',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `target_user` int(11) DEFAULT '0' COMMENT '対象者',
  `title` varchar(255) NOT NULL COMMENT 'タイトル',
  `title_icon` varchar(255) NOT NULL COMMENT 'タイトル アイコン',
  `location` varchar(255) NOT NULL COMMENT '場所',
  `contact` varchar(255) NOT NULL COMMENT '連絡先',
  `description` text COMMENT '詳細',
  `is_allday` tinyint(1) DEFAULT '1' COMMENT '終日かどうか | 0:終日ではない | 1:終日',
  `start_date` varchar(8) NOT NULL COMMENT '開始日 (YYYYMMDD形式)',
  `start_time` varchar(6) NOT NULL COMMENT '開始時刻 (hhmmss形式)',
  `dtstart` varchar(14) NOT NULL COMMENT '開始日時 (YYYYMMDDhhmmss) iCalendarのDTDSTARTからTとZを外したもの',
  `end_date` varchar(8) NOT NULL COMMENT '終了日 (YYYYMMDD形式)',
  `end_time` varchar(6) NOT NULL COMMENT '終了時刻 (hhmmss形式)',
  `dtend` varchar(14) NOT NULL COMMENT '終了日時 (YYYYMMDDhhmmss形式) iCalendarのDTENDからTとZをはずしたもの',
  `timezone_offset` float(3,1) NOT NULL DEFAULT '0.0' COMMENT 'タイムゾーンオフセット-12.0～+12.0',
  `status` int(4) NOT NULL COMMENT '公開状況  1:公開中>、2:公 開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新コンテンツかどうか 0:最新でない 1:最新',
  `recurrence_event_id` int(11) NOT NULL DEFAULT '0' COMMENT '1以上のとき、再発(置換）イベントidを指す。VCALENDERのRECURRENCE-ID機能実現のための項目',
  `exception_event_id` int(11) NOT NULL DEFAULT '0' COMMENT '1以上のとき、例外（削除）イベントidを指す。vcalendarの EXDATE機能実現のための項目',
  `is_enable_mail` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'イベント前にメール通知するかどうか 0:通知しない 1:通知する',
  `email_send_timing` int(11) NOT NULL DEFAULT '0' COMMENT 'イベントN分前メール通知の値N。単位は分。',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `dtstart` (`dtstart`),
  KEY `dtend` (`dtend`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_events`
--

LOCK TABLES `calendar_events` WRITE;
/*!40000 ALTER TABLE `calendar_events` DISABLE KEYS */;
INSERT INTO `calendar_events` VALUES (1,1,'calendar_event_key_1',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190303','150000','20190303150000','20190304','150000','20190304150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(2,1,'calendar_event_key_2',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190310','150000','20190310150000','20190311','150000','20190311150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(3,1,'calendar_event_key_3',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190317','150000','20190317150000','20190318','150000','20190318150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(4,1,'calendar_event_key_4',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190324','150000','20190324150000','20190325','150000','20190325150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(5,1,'calendar_event_key_5',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190331','150000','20190331150000','20190401','150000','20190401150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(6,1,'calendar_event_key_6',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190407','150000','20190407150000','20190408','150000','20190408150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(7,1,'calendar_event_key_7',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190414','150000','20190414150000','20190415','150000','20190415150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(8,1,'calendar_event_key_8',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190421','150000','20190421150000','20190422','150000','20190422150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(9,1,'calendar_event_key_9',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190428','150000','20190428150000','20190429','150000','20190429150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(10,1,'calendar_event_key_10',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190505','150000','20190505150000','20190506','150000','20190506150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(11,1,'calendar_event_key_11',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190512','150000','20190512150000','20190513','150000','20190513150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(12,1,'calendar_event_key_12',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190519','150000','20190519150000','20190520','150000','20190520150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(13,1,'calendar_event_key_13',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190526','150000','20190526150000','20190527','150000','20190527150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(14,1,'calendar_event_key_14',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190602','150000','20190602150000','20190603','150000','20190603150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(15,1,'calendar_event_key_15',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190609','150000','20190609150000','20190610','150000','20190610150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(16,1,'calendar_event_key_16',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190616','150000','20190616150000','20190617','150000','20190617150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(17,1,'calendar_event_key_17',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190623','150000','20190623150000','20190624','150000','20190624150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(18,1,'calendar_event_key_18',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190630','150000','20190630150000','20190701','150000','20190701150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(19,1,'calendar_event_key_19',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190707','150000','20190707150000','20190708','150000','20190708150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(20,1,'calendar_event_key_20',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190714','150000','20190714150000','20190715','150000','20190715150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(21,1,'calendar_event_key_21',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190721','150000','20190721150000','20190722','150000','20190722150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(22,1,'calendar_event_key_22',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190728','150000','20190728150000','20190729','150000','20190729150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(23,1,'calendar_event_key_23',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190804','150000','20190804150000','20190805','150000','20190805150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(24,1,'calendar_event_key_24',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190811','150000','20190811150000','20190812','150000','20190812150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(25,1,'calendar_event_key_25',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190818','150000','20190818150000','20190819','150000','20190819150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(26,1,'calendar_event_key_26',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190825','150000','20190825150000','20190826','150000','20190826150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(27,1,'calendar_event_key_27',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190901','150000','20190901150000','20190902','150000','20190902150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(28,1,'calendar_event_key_28',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190908','150000','20190908150000','20190909','150000','20190909150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(29,1,'calendar_event_key_29',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190915','150000','20190915150000','20190916','150000','20190916150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(30,1,'calendar_event_key_30',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190922','150000','20190922150000','20190923','150000','20190923150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(31,1,'calendar_event_key_31',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20190929','150000','20190929150000','20190930','150000','20190930150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(32,1,'calendar_event_key_32',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191006','150000','20191006150000','20191007','150000','20191007150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(33,1,'calendar_event_key_33',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191013','150000','20191013150000','20191014','150000','20191014150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(34,1,'calendar_event_key_34',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191020','150000','20191020150000','20191021','150000','20191021150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(35,1,'calendar_event_key_35',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191027','150000','20191027150000','20191028','150000','20191028150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(36,1,'calendar_event_key_36',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191103','150000','20191103150000','20191104','150000','20191104150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(37,1,'calendar_event_key_37',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191110','150000','20191110150000','20191111','150000','20191111150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(38,1,'calendar_event_key_38',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191117','150000','20191117150000','20191118','150000','20191118150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(39,1,'calendar_event_key_39',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191124','150000','20191124150000','20191125','150000','20191125150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(40,1,'calendar_event_key_40',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191201','150000','20191201150000','20191202','150000','20191202150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(41,1,'calendar_event_key_41',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191208','150000','20191208150000','20191209','150000','20191209150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(42,1,'calendar_event_key_42',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191215','150000','20191215150000','20191216','150000','20191216150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(43,1,'calendar_event_key_43',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191222','150000','20191222150000','20191223','150000','20191223150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(44,1,'calendar_event_key_44',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20191229','150000','20191229150000','20191230','150000','20191230150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(45,1,'calendar_event_key_45',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200105','150000','20200105150000','20200106','150000','20200106150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(46,1,'calendar_event_key_46',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200112','150000','20200112150000','20200113','150000','20200113150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(47,1,'calendar_event_key_47',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200119','150000','20200119150000','20200120','150000','20200120150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(48,1,'calendar_event_key_48',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200126','150000','20200126150000','20200127','150000','20200127150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(49,1,'calendar_event_key_49',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200202','150000','20200202150000','20200203','150000','20200203150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(50,1,'calendar_event_key_50',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200209','150000','20200209150000','20200210','150000','20200210150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(51,1,'calendar_event_key_51',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200216','150000','20200216150000','20200217','150000','20200217150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(52,1,'calendar_event_key_52',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200223','150000','20200223150000','20200224','150000','20200224150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(53,1,'calendar_event_key_53',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200301','150000','20200301150000','20200302','150000','20200302150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(54,1,'calendar_event_key_54',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200308','150000','20200308150000','20200309','150000','20200309150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(55,1,'calendar_event_key_55',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200315','150000','20200315150000','20200316','150000','20200316150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(56,1,'calendar_event_key_56',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200322','150000','20200322150000','20200323','150000','20200323150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(57,1,'calendar_event_key_57',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200329','150000','20200329150000','20200330','150000','20200330150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(58,1,'calendar_event_key_58',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200405','150000','20200405150000','20200406','150000','20200406150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(59,1,'calendar_event_key_59',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200412','150000','20200412150000','20200413','150000','20200413150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(60,1,'calendar_event_key_60',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200419','150000','20200419150000','20200420','150000','20200420150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(61,1,'calendar_event_key_61',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200426','150000','20200426150000','20200427','150000','20200427150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(62,1,'calendar_event_key_62',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200503','150000','20200503150000','20200504','150000','20200504150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(63,1,'calendar_event_key_63',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200510','150000','20200510150000','20200511','150000','20200511150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(64,1,'calendar_event_key_64',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200517','150000','20200517150000','20200518','150000','20200518150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(65,1,'calendar_event_key_65',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200524','150000','20200524150000','20200525','150000','20200525150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(66,1,'calendar_event_key_66',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200531','150000','20200531150000','20200601','150000','20200601150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(67,1,'calendar_event_key_67',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200607','150000','20200607150000','20200608','150000','20200608150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(68,1,'calendar_event_key_68',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200614','150000','20200614150000','20200615','150000','20200615150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(69,1,'calendar_event_key_69',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200621','150000','20200621150000','20200622','150000','20200622150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(70,1,'calendar_event_key_70',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200628','150000','20200628150000','20200629','150000','20200629150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(71,1,'calendar_event_key_71',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200705','150000','20200705150000','20200706','150000','20200706150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(72,1,'calendar_event_key_72',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200712','150000','20200712150000','20200713','150000','20200713150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(73,1,'calendar_event_key_73',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200719','150000','20200719150000','20200720','150000','20200720150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(74,1,'calendar_event_key_74',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200726','150000','20200726150000','20200727','150000','20200727150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(75,1,'calendar_event_key_75',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200802','150000','20200802150000','20200803','150000','20200803150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(76,1,'calendar_event_key_76',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200809','150000','20200809150000','20200810','150000','20200810150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(77,1,'calendar_event_key_77',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200816','150000','20200816150000','20200817','150000','20200817150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(78,1,'calendar_event_key_78',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200823','150000','20200823150000','20200824','150000','20200824150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(79,1,'calendar_event_key_79',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200830','150000','20200830150000','20200831','150000','20200831150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(80,1,'calendar_event_key_80',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200906','150000','20200906150000','20200907','150000','20200907150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(81,1,'calendar_event_key_81',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200913','150000','20200913150000','20200914','150000','20200914150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(82,1,'calendar_event_key_82',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200920','150000','20200920150000','20200921','150000','20200921150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(83,1,'calendar_event_key_83',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20200927','150000','20200927150000','20200928','150000','20200928150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(84,1,'calendar_event_key_84',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201004','150000','20201004150000','20201005','150000','20201005150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(85,1,'calendar_event_key_85',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201011','150000','20201011150000','20201012','150000','20201012150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(86,1,'calendar_event_key_86',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201018','150000','20201018150000','20201019','150000','20201019150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(87,1,'calendar_event_key_87',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201025','150000','20201025150000','20201026','150000','20201026150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(88,1,'calendar_event_key_88',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201101','150000','20201101150000','20201102','150000','20201102150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(89,1,'calendar_event_key_89',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201108','150000','20201108150000','20201109','150000','20201109150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(90,1,'calendar_event_key_90',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201115','150000','20201115150000','20201116','150000','20201116150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(91,1,'calendar_event_key_91',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201122','150000','20201122150000','20201123','150000','20201123150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(92,1,'calendar_event_key_92',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201129','150000','20201129150000','20201130','150000','20201130150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(93,1,'calendar_event_key_93',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201206','150000','20201206150000','20201207','150000','20201207150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(94,1,'calendar_event_key_94',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201213','150000','20201213150000','20201214','150000','20201214150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(95,1,'calendar_event_key_95',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201220','150000','20201220150000','20201221','150000','20201221150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(96,1,'calendar_event_key_96',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20201227','150000','20201227150000','20201228','150000','20201228150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(97,1,'calendar_event_key_97',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210103','150000','20210103150000','20210104','150000','20210104150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(98,1,'calendar_event_key_98',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210110','150000','20210110150000','20210111','150000','20210111150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(99,1,'calendar_event_key_99',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210117','150000','20210117150000','20210118','150000','20210118150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(100,1,'calendar_event_key_100',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210124','150000','20210124150000','20210125','150000','20210125150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(101,1,'calendar_event_key_101',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210131','150000','20210131150000','20210201','150000','20210201150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(102,1,'calendar_event_key_102',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210207','150000','20210207150000','20210208','150000','20210208150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(103,1,'calendar_event_key_103',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210214','150000','20210214150000','20210215','150000','20210215150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(104,1,'calendar_event_key_104',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210221','150000','20210221150000','20210222','150000','20210222150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(105,1,'calendar_event_key_105',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210228','150000','20210228150000','20210301','150000','20210301150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(106,1,'calendar_event_key_106',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210307','150000','20210307150000','20210308','150000','20210308150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(107,1,'calendar_event_key_107',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210314','150000','20210314150000','20210315','150000','20210315150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(108,1,'calendar_event_key_108',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210321','150000','20210321150000','20210322','150000','20210322150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(109,1,'calendar_event_key_109',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210328','150000','20210328150000','20210329','150000','20210329150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(110,1,'calendar_event_key_110',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210404','150000','20210404150000','20210405','150000','20210405150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(111,1,'calendar_event_key_111',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210411','150000','20210411150000','20210412','150000','20210412150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(112,1,'calendar_event_key_112',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210418','150000','20210418150000','20210419','150000','20210419150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(113,1,'calendar_event_key_113',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210425','150000','20210425150000','20210426','150000','20210426150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(114,1,'calendar_event_key_114',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210502','150000','20210502150000','20210503','150000','20210503150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(115,1,'calendar_event_key_115',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210509','150000','20210509150000','20210510','150000','20210510150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(116,1,'calendar_event_key_116',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210516','150000','20210516150000','20210517','150000','20210517150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(117,1,'calendar_event_key_117',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210523','150000','20210523150000','20210524','150000','20210524150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(118,1,'calendar_event_key_118',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210530','150000','20210530150000','20210531','150000','20210531150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(119,1,'calendar_event_key_119',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210606','150000','20210606150000','20210607','150000','20210607150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(120,1,'calendar_event_key_120',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210613','150000','20210613150000','20210614','150000','20210614150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(121,1,'calendar_event_key_121',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210620','150000','20210620150000','20210621','150000','20210621150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(122,1,'calendar_event_key_122',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210627','150000','20210627150000','20210628','150000','20210628150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(123,1,'calendar_event_key_123',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210704','150000','20210704150000','20210705','150000','20210705150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(124,1,'calendar_event_key_124',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210711','150000','20210711150000','20210712','150000','20210712150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(125,1,'calendar_event_key_125',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210718','150000','20210718150000','20210719','150000','20210719150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(126,1,'calendar_event_key_126',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210725','150000','20210725150000','20210726','150000','20210726150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(127,1,'calendar_event_key_127',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210801','150000','20210801150000','20210802','150000','20210802150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(128,1,'calendar_event_key_128',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210808','150000','20210808150000','20210809','150000','20210809150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(129,1,'calendar_event_key_129',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210815','150000','20210815150000','20210816','150000','20210816150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(130,1,'calendar_event_key_130',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210822','150000','20210822150000','20210823','150000','20210823150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(131,1,'calendar_event_key_131',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210829','150000','20210829150000','20210830','150000','20210830150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(132,1,'calendar_event_key_132',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210905','150000','20210905150000','20210906','150000','20210906150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(133,1,'calendar_event_key_133',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210912','150000','20210912150000','20210913','150000','20210913150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(134,1,'calendar_event_key_134',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210919','150000','20210919150000','20210920','150000','20210920150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(135,1,'calendar_event_key_135',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20210926','150000','20210926150000','20210927','150000','20210927150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(136,1,'calendar_event_key_136',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211003','150000','20211003150000','20211004','150000','20211004150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(137,1,'calendar_event_key_137',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211010','150000','20211010150000','20211011','150000','20211011150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(138,1,'calendar_event_key_138',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211017','150000','20211017150000','20211018','150000','20211018150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(139,1,'calendar_event_key_139',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211024','150000','20211024150000','20211025','150000','20211025150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(140,1,'calendar_event_key_140',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211031','150000','20211031150000','20211101','150000','20211101150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(141,1,'calendar_event_key_141',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211107','150000','20211107150000','20211108','150000','20211108150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(142,1,'calendar_event_key_142',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211114','150000','20211114150000','20211115','150000','20211115150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(143,1,'calendar_event_key_143',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211121','150000','20211121150000','20211122','150000','20211122150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(144,1,'calendar_event_key_144',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211128','150000','20211128150000','20211129','150000','20211129150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(145,1,'calendar_event_key_145',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211205','150000','20211205150000','20211206','150000','20211206150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(146,1,'calendar_event_key_146',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211212','150000','20211212150000','20211213','150000','20211213150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(147,1,'calendar_event_key_147',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211219','150000','20211219150000','20211220','150000','20211220150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(148,1,'calendar_event_key_148',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20211226','150000','20211226150000','20211227','150000','20211227150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(149,1,'calendar_event_key_149',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20220102','150000','20220102150000','20220103','150000','20220103150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(150,1,'calendar_event_key_150',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20220109','150000','20220109150000','20220110','150000','20220110150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(151,1,'calendar_event_key_151',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20220116','150000','20220116150000','20220117','150000','20220117150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(152,1,'calendar_event_key_152',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20220123','150000','20220123150000','20220124','150000','20220124150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(153,1,'calendar_event_key_153',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20220130','150000','20220130150000','20220131','150000','20220131150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(154,1,'calendar_event_key_154',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20220206','150000','20220206150000','20220207','150000','20220207150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(155,1,'calendar_event_key_155',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20220213','150000','20220213150000','20220214','150000','20220214150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(156,1,'calendar_event_key_156',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20220220','150000','20220220150000','20220221','150000','20220221150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(157,1,'calendar_event_key_157',1,2,1,0,0,1,'Repeat Plan 1','','','','',1,'20220227','150000','20220227150000','20220228','150000','20220228150000',9.0,1,1,1,0,0,0,5,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04');
/*!40000 ALTER TABLE `calendar_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_frame_setting_select_rooms`
--

DROP TABLE IF EXISTS `calendar_frame_setting_select_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_frame_setting_select_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `calendar_frame_setting_id` int(11) NOT NULL COMMENT 'カレンダーフレームセッティングのid',
  `room_id` int(11) NOT NULL COMMENT 'ルームID',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_frame_setting_select_rooms`
--

LOCK TABLES `calendar_frame_setting_select_rooms` WRITE;
/*!40000 ALTER TABLE `calendar_frame_setting_select_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar_frame_setting_select_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_frame_settings`
--

DROP TABLE IF EXISTS `calendar_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `display_type` int(4) NOT NULL DEFAULT '0' COMMENT '表示方法',
  `start_pos` int(4) NOT NULL DEFAULT '0' COMMENT '開始位置',
  `display_count` int(4) NOT NULL DEFAULT '0' COMMENT '表示日数',
  `is_myroom` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'プライベートルームのカレンダーコンポーネント（イベント等)を表示するかどうか 0:表示しない 1:表示する',
  `is_select_room` tinyint(1) NOT NULL DEFAULT '0' COMMENT '指定したルームのみ表示するかどうか 0:表示しない 1:表示する',
  `timeline_base_time` int(11) NOT NULL COMMENT '単一日タイムライン基準時',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_frame_settings`
--

LOCK TABLES `calendar_frame_settings` WRITE;
/*!40000 ALTER TABLE `calendar_frame_settings` DISABLE KEYS */;
INSERT INTO `calendar_frame_settings` VALUES (1,'frame_key_8',2,0,3,1,0,8,1,'2019-03-02 03:35:59',1,'2019-03-02 03:36:06'),(2,'frame_key_9',5,0,10,1,0,8,1,'2019-03-02 03:36:15',1,'2019-03-02 03:36:28');
/*!40000 ALTER TABLE `calendar_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_rrules`
--

DROP TABLE IF EXISTS `calendar_rrules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_rrules` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `calendar_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL COMMENT 'カレンダーコンポーネント(イベント等)繰返し規則 キー',
  `name` varchar(255) NOT NULL COMMENT 'カレンダーコンポーネント(イベント等)繰返し規則名称',
  `rrule` text COMMENT '繰返し規則',
  `icalendar_uid` text NOT NULL COMMENT 'iCalendarUIDの元となる情報。rrule分割元と分割先の関連性を記録する。',
  `icalendar_comp_name` varchar(255) NOT NULL COMMENT 'iCalendar仕様のコンポーネント名 (vevent,vtodo,vjournal 等)',
  `room_id` int(11) NOT NULL DEFAULT '0' COMMENT 'ルームID',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_rrules`
--

LOCK TABLES `calendar_rrules` WRITE;
/*!40000 ALTER TABLE `calendar_rrules` DISABLE KEYS */;
INSERT INTO `calendar_rrules` VALUES (1,1,'calendar_rrule_key_1','','FREQ=WEEKLY;INTERVAL=1;BYDAY=MO;UNTIL=20220304T150000','20190303T150000Z-5c79fd6c13cec@','calendar',1,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04');
/*!40000 ALTER TABLE `calendar_rrules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendars`
--

DROP TABLE IF EXISTS `calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendars` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_key` varchar(255) NOT NULL COMMENT 'Block キー',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendars`
--

LOCK TABLES `calendars` WRITE;
/*!40000 ALTER TABLE `calendars` DISABLE KEYS */;
INSERT INTO `calendars` VALUES (1,'block_key_4',1,'2019-03-02 03:35:59',1,'2019-03-02 03:35:59');
/*!40000 ALTER TABLE `calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_id` int(11) NOT NULL COMMENT 'ブロックID',
  `key` varchar(255) NOT NULL COMMENT 'カテゴリーKey',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories_languages`
--

DROP TABLE IF EXISTS `categories_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_id` int(11) NOT NULL COMMENT 'カテゴリーID',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `name` varchar(255) DEFAULT NULL COMMENT 'カテゴリー名',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories_languages`
--

LOCK TABLES `categories_languages` WRITE;
/*!40000 ALTER TABLE `categories_languages` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_orders`
--

DROP TABLE IF EXISTS `category_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_key` varchar(255) NOT NULL COMMENT 'カテゴリーKey',
  `block_key` varchar(255) NOT NULL COMMENT 'ブロックKey',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '表示の重み(表示順序)',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `category_key` (`category_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_orders`
--

LOCK TABLES `category_orders` WRITE;
/*!40000 ALTER TABLE `category_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circular_notice_choices`
--

DROP TABLE IF EXISTS `circular_notice_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circular_notice_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `circular_notice_content_id` int(11) NOT NULL COMMENT '回覧ID',
  `value` varchar(255) NOT NULL COMMENT '選択肢',
  `weight` int(11) DEFAULT NULL COMMENT '選択肢表示順',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `circular_notice_content_id` (`circular_notice_content_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circular_notice_choices`
--

LOCK TABLES `circular_notice_choices` WRITE;
/*!40000 ALTER TABLE `circular_notice_choices` DISABLE KEYS */;
/*!40000 ALTER TABLE `circular_notice_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circular_notice_contents`
--

DROP TABLE IF EXISTS `circular_notice_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circular_notice_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(255) NOT NULL COMMENT '回覧キー',
  `circular_notice_setting_key` varchar(255) NOT NULL COMMENT '回覧板キー',
  `title_icon` varchar(255) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_latest` tinyint(1) DEFAULT NULL,
  `subject` varchar(255) NOT NULL COMMENT '件名',
  `content` text NOT NULL COMMENT '本文',
  `reply_type` int(1) NOT NULL DEFAULT '1' COMMENT '回答方式  1:記述式、2:択一式、3:複数選択',
  `is_room_target` tinyint(1) DEFAULT NULL COMMENT 'ルーム対象回覧フラグ',
  `public_type` int(4) NOT NULL DEFAULT '1',
  `publish_start` datetime DEFAULT NULL COMMENT '回覧期間（開始日時）',
  `publish_end` datetime DEFAULT NULL COMMENT 'opend period (to)  | 回覧期間（終了日時） |  | ',
  `use_reply_deadline` tinyint(1) NOT NULL DEFAULT '0' COMMENT '回答期限設定フラグ  0:unset , 1:set',
  `reply_deadline` datetime DEFAULT NULL COMMENT '回答期限',
  `status` int(4) NOT NULL DEFAULT '3' COMMENT '公開状況  1:公開中、3:下書き中',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `key` (`key`),
  KEY `circular_notice_setting_key` (`circular_notice_setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circular_notice_contents`
--

LOCK TABLES `circular_notice_contents` WRITE;
/*!40000 ALTER TABLE `circular_notice_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `circular_notice_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circular_notice_frame_settings`
--

DROP TABLE IF EXISTS `circular_notice_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circular_notice_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `display_number` int(11) NOT NULL DEFAULT '10' COMMENT '表示回覧数 1件、5件、10件、20件、50件、100件',
  `created_user` int(11) NOT NULL COMMENT '作成者',
  `created` datetime NOT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circular_notice_frame_settings`
--

LOCK TABLES `circular_notice_frame_settings` WRITE;
/*!40000 ALTER TABLE `circular_notice_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `circular_notice_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circular_notice_settings`
--

DROP TABLE IF EXISTS `circular_notice_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circular_notice_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_key` varchar(255) NOT NULL COMMENT 'ブロックKey',
  `key` varchar(255) NOT NULL COMMENT '回覧板キー',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_key` (`block_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circular_notice_settings`
--

LOCK TABLES `circular_notice_settings` WRITE;
/*!40000 ALTER TABLE `circular_notice_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `circular_notice_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `circular_notice_target_users`
--

DROP TABLE IF EXISTS `circular_notice_target_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `circular_notice_target_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT '回覧先',
  `circular_notice_content_id` int(11) NOT NULL COMMENT '回覧ID',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '閲覧フラグ  0:未読、1:既読',
  `read_datetime` datetime DEFAULT NULL COMMENT '閲覧日時',
  `is_reply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '回答フラグ  0:未回答、1:回答',
  `reply_datetime` datetime DEFAULT NULL COMMENT 'reply datetime | 回答日時 |  | ',
  `reply_text_value` varchar(255) DEFAULT NULL COMMENT '回覧回答（記述式）',
  `reply_selection_value` text COMMENT '回覧回答（択一、複数選択）',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `circular_notice_content_id_2` (`circular_notice_content_id`,`user_id`),
  KEY `circular_notice_content_id` (`circular_notice_content_id`,`is_read`),
  KEY `circular_notice_content_id_3` (`circular_notice_content_id`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `circular_notice_target_users`
--

LOCK TABLES `circular_notice_target_users` WRITE;
/*!40000 ALTER TABLE `circular_notice_target_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `circular_notice_target_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `containers`
--

DROP TABLE IF EXISTS `containers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `containers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL COMMENT 'Type of the container.  1:Header, 2:Major, 3:Main, 4:Minor, 5:Footer',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `containers`
--

LOCK TABLES `containers` WRITE;
/*!40000 ALTER TABLE `containers` DISABLE KEYS */;
INSERT INTO `containers` VALUES (1,1,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(2,2,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(3,3,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(4,4,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(5,5,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(6,1,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(7,2,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(8,3,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(9,4,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(10,5,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(11,1,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(12,2,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(13,3,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(14,4,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(15,5,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(16,3,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10');
/*!40000 ALTER TABLE `containers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `containers_pages`
--

DROP TABLE IF EXISTS `containers_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `containers_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `container_id` int(11) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT NULL COMMENT '一般以下のパートが閲覧可能かどうか。ルーム配下ならルーム管理者、またはそれに準ずるユーザはこの値に関わらず閲覧できる。  e.g.) ルーム管理者、またはそれに準ずるユーザ: ルーム管理者、編集長',
  `is_configured` tinyint(1) NOT NULL DEFAULT '0' COMMENT '設定したかどうか',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `containers_pages`
--

LOCK TABLES `containers_pages` WRITE;
/*!40000 ALTER TABLE `containers_pages` DISABLE KEYS */;
INSERT INTO `containers_pages` VALUES (1,1,1,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(2,1,2,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(3,1,3,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(4,1,4,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(5,1,5,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(6,2,6,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(7,2,7,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(8,2,8,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(9,2,9,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(10,2,10,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(11,3,11,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(12,3,12,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(13,3,13,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(14,3,14,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(15,3,15,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(16,4,1,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(17,4,2,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(18,4,16,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(19,4,4,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(20,4,5,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10');
/*!40000 ALTER TABLE `containers_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_comments`
--

DROP TABLE IF EXISTS `content_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_key` varchar(255) NOT NULL COMMENT 'ブロックKey',
  `plugin_key` varchar(255) NOT NULL COMMENT 'プラグインKey',
  `content_key` varchar(255) NOT NULL COMMENT '各プラグインのコンテンツKey',
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '公開状況 1:公開中、2:未承認',
  `comment` text NOT NULL COMMENT 'コメント',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_key` (`block_key`,`plugin_key`,`content_key`,`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_comments`
--

LOCK TABLES `content_comments` WRITE;
/*!40000 ALTER TABLE `content_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_type_choices`
--

DROP TABLE IF EXISTS `data_type_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_type_choices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(5) unsigned NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `key` varchar(255) NOT NULL,
  `data_type_key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `weight` int(11) DEFAULT NULL COMMENT '表示順序',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`,`data_type_key`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_type_choices`
--

LOCK TABLES `data_type_choices` WRITE;
/*!40000 ALTER TABLE `data_type_choices` DISABLE KEYS */;
INSERT INTO `data_type_choices` VALUES (1,2,1,1,0,'prefecture_01','prefecture','北海道','01',1,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(2,2,1,1,0,'prefecture_02','prefecture','青森県','02',2,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(3,2,1,1,0,'prefecture_03','prefecture','岩手県','03',3,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(4,2,1,1,0,'prefecture_04','prefecture','宮城県','04',4,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(5,2,1,1,0,'prefecture_05','prefecture','秋田県','05',5,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(6,2,1,1,0,'prefecture_06','prefecture','山形県','06',6,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(7,2,1,1,0,'prefecture_07','prefecture','福島県','07',7,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(8,2,1,1,0,'prefecture_08','prefecture','茨城県','08',8,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(9,2,1,1,0,'prefecture_09','prefecture','栃木県','09',9,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(10,2,1,1,0,'prefecture_10','prefecture','群馬県','10',10,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(11,2,1,1,0,'prefecture_11','prefecture','埼玉県','11',11,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(12,2,1,1,0,'prefecture_12','prefecture','千葉県','12',12,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(13,2,1,1,0,'prefecture_13','prefecture','東京都','13',13,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(14,2,1,1,0,'prefecture_14','prefecture','神奈川県','14',14,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(15,2,1,1,0,'prefecture_15','prefecture','新潟県','15',15,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(16,2,1,1,0,'prefecture_16','prefecture','富山県','16',16,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(17,2,1,1,0,'prefecture_17','prefecture','石川県','17',17,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(18,2,1,1,0,'prefecture_18','prefecture','福井県','18',18,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(19,2,1,1,0,'prefecture_19','prefecture','山梨県','19',19,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(20,2,1,1,0,'prefecture_20','prefecture','長野県','20',20,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(21,2,1,1,0,'prefecture_21','prefecture','岐阜県','21',21,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(22,2,1,1,0,'prefecture_22','prefecture','静岡県','22',22,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(23,2,1,1,0,'prefecture_23','prefecture','愛知県','23',23,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(24,2,1,1,0,'prefecture_24','prefecture','三重県','24',24,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(25,2,1,1,0,'prefecture_25','prefecture','滋賀県','25',25,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(26,2,1,1,0,'prefecture_26','prefecture','京都府','26',26,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(27,2,1,1,0,'prefecture_27','prefecture','大阪府','27',27,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(28,2,1,1,0,'prefecture_28','prefecture','兵庫県','28',28,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(29,2,1,1,0,'prefecture_29','prefecture','奈良県','29',29,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(30,2,1,1,0,'prefecture_30','prefecture','和歌山県','30',30,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(31,2,1,1,0,'prefecture_31','prefecture','鳥取県','31',31,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(32,2,1,1,0,'prefecture_32','prefecture','島根県','32',32,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(33,2,1,1,0,'prefecture_33','prefecture','岡山県','33',33,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(34,2,1,1,0,'prefecture_34','prefecture','広島県','34',34,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(35,2,1,1,0,'prefecture_35','prefecture','山口県','35',35,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(36,2,1,1,0,'prefecture_36','prefecture','徳島県','36',36,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(37,2,1,1,0,'prefecture_37','prefecture','香川県','37',37,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(38,2,1,1,0,'prefecture_38','prefecture','愛媛県','38',38,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(39,2,1,1,0,'prefecture_39','prefecture','高知県','39',39,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(40,2,1,1,0,'prefecture_40','prefecture','福岡県','40',40,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(41,2,1,1,0,'prefecture_41','prefecture','佐賀県','41',41,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(42,2,1,1,0,'prefecture_42','prefecture','長崎県','42',42,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(43,2,1,1,0,'prefecture_43','prefecture','熊本県','43',43,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(44,2,1,1,0,'prefecture_44','prefecture','大分県','44',44,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(45,2,1,1,0,'prefecture_45','prefecture','宮崎県','45',45,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(46,2,1,1,0,'prefecture_46','prefecture','鹿児島県','46',46,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(47,2,1,1,0,'prefecture_47','prefecture','沖縄県','47',47,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(48,1,0,1,0,'prefecture_01','prefecture','Hokkaido','01',1,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(49,1,0,1,0,'prefecture_02','prefecture','Aomori','02',2,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(50,1,0,1,0,'prefecture_03','prefecture','Iwate','03',3,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(51,1,0,1,0,'prefecture_04','prefecture','Miyagi','04',4,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(52,1,0,1,0,'prefecture_05','prefecture','Akita','05',5,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(53,1,0,1,0,'prefecture_06','prefecture','Yamagata','06',6,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(54,1,0,1,0,'prefecture_07','prefecture','Fukushima','07',7,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(55,1,0,1,0,'prefecture_08','prefecture','Ibaraki','08',8,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(56,1,0,1,0,'prefecture_09','prefecture','Tochigi','09',9,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(57,1,0,1,0,'prefecture_10','prefecture','Gunma','10',10,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(58,1,0,1,0,'prefecture_11','prefecture','Saitama','11',11,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(59,1,0,1,0,'prefecture_12','prefecture','Chiba','12',12,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(60,1,0,1,0,'prefecture_13','prefecture','Tokyo','13',13,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(61,1,0,1,0,'prefecture_14','prefecture','Kanagawa','14',14,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(62,1,0,1,0,'prefecture_15','prefecture','Niigata','15',15,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(63,1,0,1,0,'prefecture_16','prefecture','Toyama','16',16,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(64,1,0,1,0,'prefecture_17','prefecture','Ishikawa','17',17,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(65,1,0,1,0,'prefecture_18','prefecture','Fukui','18',18,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(66,1,0,1,0,'prefecture_19','prefecture','Yamanashi','19',19,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(67,1,0,1,0,'prefecture_20','prefecture','Nagano','20',20,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(68,1,0,1,0,'prefecture_21','prefecture','Gifu','21',21,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(69,1,0,1,0,'prefecture_22','prefecture','Shizuoka','22',22,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(70,1,0,1,0,'prefecture_23','prefecture','Aichi','23',23,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(71,1,0,1,0,'prefecture_24','prefecture','Mie','24',24,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(72,1,0,1,0,'prefecture_25','prefecture','Shiga','25',25,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(73,1,0,1,0,'prefecture_26','prefecture','Kyoto','26',26,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(74,1,0,1,0,'prefecture_27','prefecture','Osaka','27',27,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(75,1,0,1,0,'prefecture_28','prefecture','Hyogo','28',28,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(76,1,0,1,0,'prefecture_29','prefecture','Nara','29',29,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(77,1,0,1,0,'prefecture_30','prefecture','Wakayama','30',30,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(78,1,0,1,0,'prefecture_31','prefecture','Tottori','31',31,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(79,1,0,1,0,'prefecture_32','prefecture','Shimane','32',32,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(80,1,0,1,0,'prefecture_33','prefecture','Okayama','33',33,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(81,1,0,1,0,'prefecture_34','prefecture','Hiroshima','34',34,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(82,1,0,1,0,'prefecture_35','prefecture','Yamaguchi','35',35,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(83,1,0,1,0,'prefecture_36','prefecture','Tokushima','36',36,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(84,1,0,1,0,'prefecture_37','prefecture','Kagawa','37',37,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(85,1,0,1,0,'prefecture_38','prefecture','Ehime','38',38,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(86,1,0,1,0,'prefecture_39','prefecture','Kochi','39',39,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(87,1,0,1,0,'prefecture_40','prefecture','Fukuoka','40',40,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(88,1,0,1,0,'prefecture_41','prefecture','Saga','41',41,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(89,1,0,1,0,'prefecture_42','prefecture','Nagasaki','42',42,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(90,1,0,1,0,'prefecture_43','prefecture','Kumamoto','43',43,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(91,1,0,1,0,'prefecture_44','prefecture','Oita','44',44,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(92,1,0,1,0,'prefecture_45','prefecture','Miyazaki','45',45,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(93,1,0,1,0,'prefecture_46','prefecture','Kagoshima','46',46,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(94,1,0,1,0,'prefecture_47','prefecture','Okinawa','47',47,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03');
/*!40000 ALTER TABLE `data_type_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_types`
--

DROP TABLE IF EXISTS `data_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_types` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(5) unsigned NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `weight` int(11) DEFAULT NULL COMMENT '表示順序',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_types`
--

LOCK TABLES `data_types` WRITE;
/*!40000 ALTER TABLE `data_types` DISABLE KEYS */;
INSERT INTO `data_types` VALUES (1,2,1,1,0,'label','ラベル',1,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(2,2,1,1,0,'text','テキストボックス',2,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(3,2,1,1,0,'textarea','テキストエリア',3,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(4,2,1,1,0,'radio','ラジオボタン',4,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(5,2,1,1,0,'checkbox','チェックボックス',5,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(6,2,1,1,0,'select','セレクトボックス',6,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(7,2,1,1,0,'multiple_select','複数セレクトボックス',7,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(8,2,1,1,0,'password','パスワード',8,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(9,2,1,1,0,'email','eメール',9,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(10,2,1,1,0,'img','画像',10,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(11,2,1,1,0,'file','ファイル',11,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(12,2,1,1,0,'date','日付',12,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(13,2,1,1,0,'time','時間',13,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(14,2,1,1,0,'datetime','日時',14,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(15,2,1,1,0,'wysiwyg','WYSIWYG',15,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(16,2,1,1,0,'prefecture','都道府県',16,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(17,2,1,1,0,'timezone','タイムゾーン',17,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(18,1,0,1,0,'label','Label',1,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(19,1,0,1,0,'text','Text',2,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(20,1,0,1,0,'textarea','Textarea',3,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(21,1,0,1,0,'radio','Radio',4,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(22,1,0,1,0,'checkbox','Checkbox',5,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(23,1,0,1,0,'select','Select',6,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(24,1,0,1,0,'multiple_select','Multiple select',7,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(25,1,0,1,0,'password','Password',8,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(26,1,0,1,0,'email','E-mail',9,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(27,1,0,1,0,'img','Picture',10,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(28,1,0,1,0,'file','Attachment file',11,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(29,1,0,1,0,'date','Date',12,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(30,1,0,1,0,'time','Time',13,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(31,1,0,1,0,'datetime','Date time',14,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(32,1,0,1,0,'wysiwyg','WYSIWYG',15,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(33,1,0,1,0,'prefecture','Prefecture',16,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(34,1,0,1,0,'timezone','Time zone',17,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03');
/*!40000 ALTER TABLE `data_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `default_role_permissions`
--

DROP TABLE IF EXISTS `default_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `default_role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_key` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL COMMENT 'ロールタイプ　e.g.) room_role, announcement_block_role, bbs_block_role',
  `permission` varchar(255) NOT NULL COMMENT 'パーミッション名　e.g.) page_creatable, content_editable',
  `value` tinyint(1) NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_key` (`role_key`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `default_role_permissions`
--

LOCK TABLES `default_role_permissions` WRITE;
/*!40000 ALTER TABLE `default_role_permissions` DISABLE KEYS */;
INSERT INTO `default_role_permissions` VALUES (1,'room_administrator','room_role','page_editable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(2,'room_administrator','room_role','block_editable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(3,'room_administrator','room_role','content_readable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(4,'room_administrator','room_role','content_creatable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(5,'room_administrator','room_role','content_editable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(6,'room_administrator','room_role','content_publishable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(7,'room_administrator','room_role','content_comment_creatable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(8,'room_administrator','room_role','content_comment_editable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(9,'room_administrator','room_role','content_comment_publishable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(10,'room_administrator','room_role','block_permission_editable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(11,'chief_editor','room_role','page_editable',1,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(12,'chief_editor','room_role','block_editable',1,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(13,'chief_editor','room_role','content_readable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(14,'chief_editor','room_role','content_creatable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(15,'chief_editor','room_role','content_editable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(16,'chief_editor','room_role','content_publishable',1,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(17,'chief_editor','room_role','content_comment_creatable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(18,'chief_editor','room_role','content_comment_editable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(19,'chief_editor','room_role','content_comment_publishable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(20,'chief_editor','room_role','block_permission_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(21,'editor','room_role','page_editable',0,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(22,'editor','room_role','block_editable',0,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(23,'editor','room_role','content_readable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(24,'editor','room_role','content_creatable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(25,'editor','room_role','content_editable',1,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(26,'editor','room_role','content_publishable',0,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(27,'editor','room_role','content_comment_creatable',1,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(28,'editor','room_role','content_comment_editable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(29,'editor','room_role','content_comment_publishable',0,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(30,'editor','room_role','block_permission_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(31,'general_user','room_role','page_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(32,'general_user','room_role','block_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(33,'general_user','room_role','content_readable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(34,'general_user','room_role','content_creatable',1,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(35,'general_user','room_role','content_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(36,'general_user','room_role','content_publishable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(37,'general_user','room_role','content_comment_creatable',1,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(38,'general_user','room_role','content_comment_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(39,'general_user','room_role','content_comment_publishable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(40,'general_user','room_role','block_permission_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(41,'visitor','room_role','page_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(42,'visitor','room_role','block_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(43,'visitor','room_role','content_readable',1,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(44,'visitor','room_role','content_creatable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(45,'visitor','room_role','content_editable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(46,'visitor','room_role','content_publishable',0,1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(47,'visitor','room_role','content_comment_creatable',0,0,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(48,'visitor','room_role','content_comment_editable',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(49,'visitor','room_role','content_comment_publishable',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(50,'visitor','room_role','block_permission_editable',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(51,'room_administrator','room_role','html_not_limited',0,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(52,'chief_editor','room_role','html_not_limited',0,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(53,'editor','room_role','html_not_limited',0,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(54,'general_user','room_role','html_not_limited',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(55,'visitor','room_role','html_not_limited',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(56,'room_administrator','room_role','mail_content_receivable',1,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(57,'chief_editor','room_role','mail_content_receivable',1,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(58,'editor','room_role','mail_content_receivable',1,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(59,'general_user','room_role','mail_content_receivable',1,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(60,'visitor','room_role','mail_content_receivable',0,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(61,'room_administrator','room_role','mail_answer_receivable',1,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(62,'chief_editor','room_role','mail_answer_receivable',1,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(63,'editor','room_role','mail_answer_receivable',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(64,'general_user','room_role','mail_answer_receivable',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(65,'visitor','room_role','mail_answer_receivable',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(66,'room_administrator','room_role','mail_editable',1,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(67,'chief_editor','room_role','mail_editable',1,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(68,'editor','room_role','mail_editable',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(69,'general_user','room_role','mail_editable',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(70,'visitor','room_role','mail_editable',0,1,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(71,'system_administrator','user_role','group_creatable',1,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(72,'administrator','user_role','group_creatable',1,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(73,'common_user','user_role','group_creatable',1,0,NULL,'2019-03-02 03:14:06',NULL,'2019-03-02 03:14:06'),(74,'room_administrator','room_role','photo_albums_photo_creatable',1,1,NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(75,'chief_editor','room_role','photo_albums_photo_creatable',1,1,NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(76,'editor','room_role','photo_albums_photo_creatable',1,1,NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(77,'general_user','room_role','photo_albums_photo_creatable',1,0,NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(78,'visitor','room_role','photo_albums_photo_creatable',0,1,NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(79,'room_administrator','location_role','location_reservable',1,1,NULL,'2019-03-02 03:14:41',NULL,'2019-03-02 03:14:41'),(80,'chief_editor','location_role','location_reservable',1,0,NULL,'2019-03-02 03:14:41',NULL,'2019-03-02 03:14:41'),(81,'editor','location_role','location_reservable',1,0,NULL,'2019-03-02 03:14:41',NULL,'2019-03-02 03:14:41'),(82,'general_user','location_role','location_reservable',0,0,NULL,'2019-03-02 03:14:41',NULL,'2019-03-02 03:14:41'),(83,'visitor','location_role','location_reservable',0,1,NULL,'2019-03-02 03:14:41',NULL,'2019-03-02 03:14:41'),(84,'guest_user','user_role','group_creatable',0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48');
/*!40000 ALTER TABLE `default_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_idp_users`
--

DROP TABLE IF EXISTS `external_idp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `external_idp_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザID',
  `idp_userid` varchar(255) NOT NULL COMMENT 'IdPによる個人識別番号',
  `is_shib_eptid` tinyint(1) DEFAULT NULL COMMENT 'ePTID(eduPersonTargetedID)かどうか | null：Shibboleth以外  0：ePPN(eduPersonPrincipalName)  1：ePTID(eduPersonTargetedID)',
  `status` int(4) DEFAULT '2' COMMENT '状態 | 0：無効  2：有効',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `modified` datetime DEFAULT NULL COMMENT '最終更新日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '最終更新者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='外部ID連携';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_idp_users`
--

LOCK TABLES `external_idp_users` WRITE;
/*!40000 ALTER TABLE `external_idp_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `external_idp_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_frame_settings`
--

DROP TABLE IF EXISTS `faq_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `content_per_page` int(11) NOT NULL DEFAULT '10' COMMENT '1ページ毎の表示件数',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_frame_settings`
--

LOCK TABLES `faq_frame_settings` WRITE;
/*!40000 ALTER TABLE `faq_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `faq_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_question_orders`
--

DROP TABLE IF EXISTS `faq_question_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_question_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `faq_key` varchar(255) NOT NULL COMMENT 'FAQキー',
  `faq_question_key` varchar(255) NOT NULL COMMENT 'FAQ質問キー',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '表示の重み(表示順序)',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `faq_question_key` (`faq_question_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_question_orders`
--

LOCK TABLES `faq_question_orders` WRITE;
/*!40000 ALTER TABLE `faq_question_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `faq_question_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_questions`
--

DROP TABLE IF EXISTS `faq_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `faq_key` varchar(255) NOT NULL COMMENT 'FAQキー',
  `block_id` int(11) NOT NULL DEFAULT '0',
  `key` varchar(255) NOT NULL COMMENT 'FAQキー',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `category_id` int(11) DEFAULT NULL COMMENT 'カテゴリーID',
  `status` int(4) NOT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新コンテンツかどうか 0:最新でない 1:最新',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `question` text COMMENT '質問',
  `answer` text COMMENT '回答',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `faq_key` (`faq_key`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_questions`
--

LOCK TABLES `faq_questions` WRITE;
/*!40000 ALTER TABLE `faq_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `faq_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'FAQ名',
  `key` varchar(255) NOT NULL COMMENT 'FAQキー',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `frame_public_languages`
--

DROP TABLE IF EXISTS `frame_public_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `frame_public_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `frame_id` int(11) NOT NULL COMMENT 'フレームID',
  `is_public` tinyint(1) NOT NULL DEFAULT '1' COMMENT '公開かどうか',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`frame_id`,`is_public`,`language_id`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frame_public_languages`
--

LOCK TABLES `frame_public_languages` WRITE;
/*!40000 ALTER TABLE `frame_public_languages` DISABLE KEYS */;
INSERT INTO `frame_public_languages` VALUES (1,0,1,1,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:11'),(2,0,2,1,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:11'),(3,0,5,1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(4,0,6,1,1,'2019-03-02 03:18:09',1,'2019-03-02 03:18:09'),(5,0,7,1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(6,0,8,1,1,'2019-03-02 03:34:45',1,'2019-03-02 03:34:45'),(7,0,9,1,1,'2019-03-02 03:35:27',1,'2019-03-02 03:35:27'),(8,0,10,1,1,'2019-03-02 03:35:59',1,'2019-03-02 03:35:59'),(9,0,11,1,1,'2019-03-02 03:36:15',1,'2019-03-02 03:36:15'),(10,0,12,1,1,'2019-03-02 03:37:58',1,'2019-03-02 03:37:58'),(11,0,13,1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(12,0,14,1,1,'2019-03-02 03:44:52',1,'2019-03-02 03:44:52'),(13,0,15,1,1,'2019-03-02 03:51:40',1,'2019-03-02 03:51:40'),(14,0,16,1,1,'2019-03-02 03:52:27',1,'2019-03-02 03:52:27'),(15,0,17,1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(16,0,18,1,1,'2019-03-02 13:44:48',1,'2019-03-02 13:44:48');
/*!40000 ALTER TABLE `frame_public_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `frames`
--

DROP TABLE IF EXISTS `frames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `frames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) DEFAULT NULL,
  `box_id` int(11) NOT NULL,
  `plugin_key` varchar(255) NOT NULL,
  `block_id` int(11) DEFAULT NULL,
  `key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `header_type` varchar(255) NOT NULL DEFAULT 'default' COMMENT 'フレームのテーマタイプ',
  `weight` int(11) DEFAULT NULL COMMENT '表示順序',
  `is_deleted` tinyint(1) DEFAULT NULL,
  `default_action` varchar(255) NOT NULL COMMENT 'デフォルトアクション',
  `default_setting_action` varchar(255) NOT NULL COMMENT '編集画面のアクション',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`key`),
  KEY `box_id_2` (`box_id`,`is_deleted`,`weight`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frames`
--

LOCK TABLES `frames` WRITE;
/*!40000 ALTER TABLE `frames` DISABLE KEYS */;
INSERT INTO `frames` VALUES (1,1,16,'announcements',NULL,'frame_ins_1','default',NULL,1,'','',NULL,'2019-03-02 03:14:10',1,'2019-03-02 03:34:34'),(2,1,18,'menus',2,'frame_ins_2','default',1,0,'','',NULL,'2019-03-02 03:14:10',1,'2019-03-02 13:45:47'),(5,5,64,'topics',NULL,'frame_key_3','default',2,0,'','',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(6,6,73,'topics',NULL,'frame_key_4','default',1,0,'','',1,'2019-03-02 03:18:09',1,'2019-03-02 03:18:09'),(7,7,82,'topics',NULL,'frame_key_5','default',1,0,'','',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(8,5,64,'announcements',5,'frame_key_6','default',1,0,'','',1,'2019-03-02 03:34:45',1,'2019-03-02 03:34:45'),(9,1,110,'announcements',6,'frame_key_7','default',3,0,'','',1,'2019-03-02 03:35:27',1,'2019-03-02 03:35:27'),(10,1,115,'calendars',7,'frame_key_8','default',2,0,'','',1,'2019-03-02 03:35:59',1,'2019-03-02 03:35:59'),(11,1,115,'calendars',7,'frame_key_9','default',1,0,'','',1,'2019-03-02 03:36:14',1,'2019-03-02 03:36:14'),(12,1,110,'announcements',8,'frame_key_10','default',2,0,'','',1,'2019-03-02 03:37:58',1,'2019-03-02 03:37:58'),(13,10,124,'topics',NULL,'frame_key_11','default',1,0,'','',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(14,1,110,'announcements',9,'frame_key_12','default',1,0,'','',1,'2019-03-02 03:44:52',4,'2019-03-02 03:44:52'),(15,11,133,'announcements',10,'frame_key_13','default',1,0,'','',1,'2019-03-02 03:51:40',1,'2019-03-02 03:51:40'),(16,8,91,'announcements',11,'frame_key_14','default',1,0,'','',1,'2019-03-02 03:52:27',1,'2019-03-02 03:52:27'),(17,12,142,'topics',NULL,'frame_key_15','default',1,0,'','',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(18,1,16,'announcements',12,'frame_key_16','default',1,0,'','',1,'2019-03-02 13:44:48',1,'2019-03-02 13:44:48');
/*!40000 ALTER TABLE `frames` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `frames_languages`
--

DROP TABLE IF EXISTS `frames_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `frames_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `frame_id` int(11) NOT NULL COMMENT 'フレームID',
  `name` varchar(255) DEFAULT NULL COMMENT 'ブロック名',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`frame_id`,`is_translation`,`language_id`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `frames_languages`
--

LOCK TABLES `frames_languages` WRITE;
/*!40000 ALTER TABLE `frames_languages` DISABLE KEYS */;
INSERT INTO `frames_languages` VALUES (1,2,1,'お知らせ',1,0,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:11'),(2,2,2,'Menu',1,0,0,NULL,'2019-03-02 03:14:10',1,'2019-03-02 13:45:47'),(3,2,5,'新着',1,0,0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(4,2,6,'新着',1,0,0,1,'2019-03-02 03:18:09',1,'2019-03-02 03:18:09'),(5,2,7,'新着',1,0,0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(6,2,8,'お知らせ',1,0,0,1,'2019-03-02 03:34:45',1,'2019-03-02 03:34:45'),(7,2,9,'お知らせ',1,0,0,1,'2019-03-02 03:35:27',1,'2019-03-02 03:35:27'),(8,2,10,'カレンダー',1,0,0,1,'2019-03-02 03:35:59',1,'2019-03-02 03:35:59'),(9,2,11,'カレンダー',1,0,0,1,'2019-03-02 03:36:15',1,'2019-03-02 03:36:15'),(10,2,12,'お知らせ',1,0,0,1,'2019-03-02 03:37:58',1,'2019-03-02 03:37:58'),(11,2,13,'新着',1,0,0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(12,2,14,'お知らせ',1,0,0,1,'2019-03-02 03:44:52',1,'2019-03-02 03:44:52'),(13,2,15,'お知らせ',1,0,0,1,'2019-03-02 03:51:40',1,'2019-03-02 03:51:40'),(14,2,16,'お知らせ',1,0,0,1,'2019-03-02 03:52:27',1,'2019-03-02 03:52:27'),(15,2,17,'新着',1,0,0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(16,2,18,'お知らせ',1,0,0,1,'2019-03-02 13:44:48',1,'2019-03-02 13:44:48');
/*!40000 ALTER TABLE `frames_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_user` (`created_user`,`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups_users`
--

DROP TABLE IF EXISTS `groups_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups_users`
--

LOCK TABLES `groups_users` WRITE;
/*!40000 ALTER TABLE `groups_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holiday_rrules`
--

DROP TABLE IF EXISTS `holiday_rrules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holiday_rrules` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `is_variable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:日付固定,1:週曜日指定の可変',
  `month_day` date DEFAULT NULL,
  `week` int(2) DEFAULT NULL,
  `day_of_the_week` varchar(2) DEFAULT NULL,
  `can_substitute` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:振替なし,1:振替あり',
  `start_year` date NOT NULL,
  `end_year` date NOT NULL,
  `rrule` text COMMENT '繰返し規則',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holiday_rrules`
--

LOCK TABLES `holiday_rrules` WRITE;
/*!40000 ALTER TABLE `holiday_rrules` DISABLE KEYS */;
INSERT INTO `holiday_rrules` VALUES (1,0,'1970-01-01',0,'',0,'1970-01-01','1974-01-01','FREQ=YEARLY;INTERVAL=1;BYMONTH=1;UNTIL=19731231T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(2,0,'1975-01-01',0,'',1,'1975-01-01','2033-01-01','FREQ=YEARLY;INTERVAL=1;BYMONTH=1;UNTIL=20321231T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(3,0,'1970-01-15',0,'',0,'1970-01-15','1974-01-15','FREQ=YEARLY;INTERVAL=1;BYMONTH=1;UNTIL=19740114T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(4,0,'1975-01-15',0,'',1,'1975-01-15','1999-01-15','FREQ=YEARLY;INTERVAL=1;BYMONTH=1;UNTIL=19990114T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(5,1,'2000-01-10',2,'MO',0,'2000-01-10','2033-01-10','FREQ=YEARLY;INTERVAL=1;BYMONTH=1;BYDAY=2MO;UNTIL=20330109T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(6,0,'1970-02-11',0,'',0,'1970-02-11','1974-02-11','FREQ=YEARLY;INTERVAL=1;BYMONTH=2;UNTIL=19740210T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(7,0,'1975-02-11',0,'',1,'1975-02-11','2033-02-11','FREQ=YEARLY;INTERVAL=1;BYMONTH=2;UNTIL=20330210T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(8,0,'1970-03-21',0,'',0,'1970-03-21','1970-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(9,0,'1971-03-21',0,'',0,'1971-03-21','1971-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(10,0,'1972-03-20',0,'',0,'1972-03-20','1972-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(11,0,'1973-03-21',0,'',0,'1973-03-21','1973-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(12,0,'1974-03-21',0,'',0,'1974-03-21','1974-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(13,0,'1970-04-29',0,'',0,'1970-04-29','1973-04-29','FREQ=YEARLY;INTERVAL=1;BYMONTH=4;UNTIL=19730428T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(14,0,'1974-04-29',0,'',1,'1974-04-29','1988-04-29','FREQ=YEARLY;INTERVAL=1;BYMONTH=4;UNTIL=19880428T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(15,0,'1989-04-29',0,'',1,'1989-04-29','2006-04-29','FREQ=YEARLY;INTERVAL=1;BYMONTH=4;UNTIL=20060428T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(16,0,'2007-04-29',0,'',1,'2007-04-29','2033-04-29','FREQ=YEARLY;INTERVAL=1;BYMONTH=4;UNTIL=20330428T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(17,0,'1970-05-03',0,'',0,'1970-05-03','1973-05-03','FREQ=YEARLY;INTERVAL=1;BYMONTH=5;UNTIL=19730502T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(18,0,'1974-05-03',0,'',1,'1974-05-03','2033-05-03','FREQ=YEARLY;INTERVAL=1;BYMONTH=5;UNTIL=20330502T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(19,0,'2007-05-04',0,'',1,'2007-05-04','2033-05-04','FREQ=YEARLY;INTERVAL=1;BYMONTH=5;UNTIL=20330503T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(20,0,'1970-05-05',0,'',0,'1970-05-05','1973-05-05','FREQ=YEARLY;INTERVAL=1;BYMONTH=5;UNTIL=19730504T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(21,0,'1974-05-05',0,'',1,'1974-05-05','2033-05-05','FREQ=YEARLY;INTERVAL=1;BYMONTH=5;UNTIL=20330504T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(22,0,'1970-09-15',0,'',0,'1970-09-15','1973-09-15','FREQ=YEARLY;INTERVAL=1;BYMONTH=9;UNTIL=19730914T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(23,0,'1974-09-15',0,'',1,'1974-09-15','2002-09-15','FREQ=YEARLY;INTERVAL=1;BYMONTH=9;UNTIL=20020914T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(24,1,'2003-09-15',3,'MO',0,'2003-09-15','2033-09-19','FREQ=YEARLY;INTERVAL=1;BYMONTH=9;BYDAY=3MO;UNTIL=20330918T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(25,0,'1970-09-23',0,'',0,'1970-09-23','1970-09-23','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(26,0,'1971-09-24',0,'',0,'1971-09-24','1971-09-24','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(27,0,'1972-09-23',0,'',0,'1972-09-23','1972-09-23','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(28,0,'1973-09-23',0,'',0,'1973-09-23','1973-09-23','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(29,0,'1970-10-10',0,'',0,'1970-10-10','1973-10-10','FREQ=YEARLY;INTERVAL=1;BYMONTH=10;UNTIL=19731009T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(30,0,'1974-10-10',0,'',1,'1974-10-10','1999-10-10','FREQ=YEARLY;INTERVAL=1;BYMONTH=10;UNTIL=19991009T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(31,1,'2000-10-09',2,'MO',0,'2000-10-09','2033-10-10','FREQ=YEARLY;INTERVAL=1;BYMONTH=10;BYDAY=2MO;UNTIL=20331009T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(32,0,'1970-11-03',0,'',0,'1970-11-03','1973-11-03','FREQ=YEARLY;INTERVAL=1;BYMONTH=11;UNTIL=19731102T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(33,0,'1974-11-03',0,'',1,'1974-11-03','2033-11-03','FREQ=YEARLY;INTERVAL=1;BYMONTH=11;UNTIL=20331102T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(34,0,'1970-11-23',0,'',0,'1970-11-23','1973-11-23','FREQ=YEARLY;INTERVAL=1;BYMONTH=11;UNTIL=19731122T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(35,0,'1974-11-23',0,'',1,'1974-11-23','2033-11-23','FREQ=YEARLY;INTERVAL=1;BYMONTH=11;UNTIL=20331122T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(36,0,'1989-12-23',0,'',1,'1989-12-23','2033-12-23','FREQ=YEARLY;INTERVAL=1;BYMONTH=12;UNTIL=20331222T150000',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(37,0,'1975-03-21',0,'',1,'1975-03-21','1975-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(38,0,'1976-03-20',0,'',1,'1976-03-20','1976-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(39,0,'1977-03-21',0,'',1,'1977-03-21','1977-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(40,0,'1978-03-21',0,'',1,'1978-03-21','1978-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(41,0,'1979-03-21',0,'',1,'1979-03-21','1979-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(42,0,'1980-03-20',0,'',1,'1980-03-20','1980-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(43,0,'1981-03-21',0,'',1,'1981-03-21','1981-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(44,0,'1982-03-21',0,'',1,'1982-03-21','1982-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(45,0,'1983-03-21',0,'',1,'1983-03-21','1983-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(46,0,'1984-03-20',0,'',1,'1984-03-20','1984-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(47,0,'1985-03-21',0,'',1,'1985-03-21','1985-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(48,0,'1986-03-21',0,'',1,'1986-03-21','1986-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(49,0,'1987-03-21',0,'',1,'1987-03-21','1987-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(50,0,'1988-03-20',0,'',1,'1988-03-20','1988-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(51,0,'1989-03-21',0,'',1,'1989-03-21','1989-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(52,0,'1990-03-21',0,'',1,'1990-03-21','1990-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(53,0,'1991-03-21',0,'',1,'1991-03-21','1991-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(54,0,'1992-03-20',0,'',1,'1992-03-20','1992-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(55,0,'1993-03-20',0,'',1,'1993-03-20','1993-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(56,0,'1994-03-21',0,'',1,'1994-03-21','1994-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(57,0,'1995-03-21',0,'',1,'1995-03-21','1995-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(58,0,'1996-03-20',0,'',1,'1996-03-20','1996-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(59,0,'1997-03-20',0,'',1,'1997-03-20','1997-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(60,0,'1998-03-21',0,'',1,'1998-03-21','1998-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(61,0,'1999-03-21',0,'',1,'1999-03-21','1999-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(62,0,'2000-03-20',0,'',1,'2000-03-20','2000-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(63,0,'2001-03-20',0,'',1,'2001-03-20','2001-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(64,0,'2002-03-21',0,'',1,'2002-03-21','2002-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(65,0,'2003-03-21',0,'',1,'2003-03-21','2003-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(66,0,'2004-03-20',0,'',1,'2004-03-20','2004-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(67,0,'2005-03-20',0,'',1,'2005-03-20','2005-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(68,0,'2006-03-21',0,'',1,'2006-03-21','2006-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(69,0,'2007-03-21',0,'',1,'2007-03-21','2007-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(70,0,'2008-03-20',0,'',1,'2008-03-20','2008-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(71,0,'2009-03-20',0,'',1,'2009-03-20','2009-03-20','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(72,0,'2010-03-21',0,'',1,'2010-03-21','2010-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(73,0,'2011-03-21',0,'',1,'2011-03-21','2011-03-21','',0,'2019-03-02 03:14:24',0,'2019-03-02 03:14:24'),(74,0,'2012-03-20',0,'',1,'2012-03-20','2012-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(75,0,'2013-03-20',0,'',1,'2013-03-20','2013-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(76,0,'2014-03-21',0,'',1,'2014-03-21','2014-03-21','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(77,0,'2015-03-21',0,'',1,'2015-03-21','2015-03-21','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(78,0,'2016-03-20',0,'',1,'2016-03-20','2016-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(79,0,'2017-03-20',0,'',1,'2017-03-20','2017-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(80,0,'2018-03-21',0,'',1,'2018-03-21','2018-03-21','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(81,0,'2019-03-21',0,'',1,'2019-03-21','2019-03-21','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(82,0,'2020-03-20',0,'',1,'2020-03-20','2020-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(83,0,'2021-03-20',0,'',1,'2021-03-20','2021-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(84,0,'2022-03-21',0,'',1,'2022-03-21','2022-03-21','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(85,0,'2023-03-21',0,'',1,'2023-03-21','2023-03-21','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(86,0,'2024-03-20',0,'',1,'2024-03-20','2024-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(87,0,'2025-03-20',0,'',1,'2025-03-20','2025-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(88,0,'2026-03-20',0,'',1,'2026-03-20','2026-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(89,0,'2027-03-21',0,'',1,'2027-03-21','2027-03-21','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(90,0,'2028-03-20',0,'',1,'2028-03-20','2028-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(91,0,'2029-03-20',0,'',1,'2029-03-20','2029-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(92,0,'2030-03-20',0,'',1,'2030-03-20','2030-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(93,0,'2031-03-21',0,'',1,'2031-03-21','2031-03-21','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(94,0,'2032-03-20',0,'',1,'2032-03-20','2032-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(95,0,'2033-03-20',0,'',1,'2033-03-20','2033-03-20','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(96,0,'1974-09-23',0,'',1,'1974-09-23','1974-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(97,0,'1975-09-24',0,'',1,'1975-09-24','1975-09-24','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(98,0,'1976-09-23',0,'',1,'1976-09-23','1976-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(99,0,'1977-09-23',0,'',1,'1977-09-23','1977-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(100,0,'1978-09-23',0,'',1,'1978-09-23','1978-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(101,0,'1979-09-24',0,'',1,'1979-09-24','1979-09-24','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(102,0,'1980-09-23',0,'',1,'1980-09-23','1980-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(103,0,'1981-09-23',0,'',1,'1981-09-23','1981-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(104,0,'1982-09-23',0,'',1,'1982-09-23','1982-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(105,0,'1983-09-23',0,'',1,'1983-09-23','1983-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(106,0,'1984-09-23',0,'',1,'1984-09-23','1984-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(107,0,'1985-09-23',0,'',1,'1985-09-23','1985-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(108,0,'1986-09-23',0,'',1,'1986-09-23','1986-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(109,0,'1987-09-23',0,'',1,'1987-09-23','1987-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(110,0,'1988-09-23',0,'',1,'1988-09-23','1988-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(111,0,'1989-09-23',0,'',1,'1989-09-23','1989-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(112,0,'1990-09-23',0,'',1,'1990-09-23','1990-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(113,0,'1991-09-23',0,'',1,'1991-09-23','1991-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(114,0,'1992-09-23',0,'',1,'1992-09-23','1992-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(115,0,'1993-09-23',0,'',1,'1993-09-23','1993-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(116,0,'1994-09-23',0,'',1,'1994-09-23','1994-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(117,0,'1995-09-23',0,'',1,'1995-09-23','1995-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(118,0,'1996-09-23',0,'',1,'1996-09-23','1996-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(119,0,'1997-09-23',0,'',1,'1997-09-23','1997-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(120,0,'1998-09-23',0,'',1,'1998-09-23','1998-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(121,0,'1999-09-23',0,'',1,'1999-09-23','1999-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(122,0,'2000-09-23',0,'',1,'2000-09-23','2000-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(123,0,'2001-09-23',0,'',1,'2001-09-23','2001-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(124,0,'2002-09-23',0,'',1,'2002-09-23','2002-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(125,0,'2003-09-23',0,'',1,'2003-09-23','2003-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(126,0,'2004-09-23',0,'',1,'2004-09-23','2004-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(127,0,'2005-09-23',0,'',1,'2005-09-23','2005-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(128,0,'2006-09-23',0,'',1,'2006-09-23','2006-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(129,0,'2007-09-23',0,'',1,'2007-09-23','2007-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(130,0,'2008-09-23',0,'',1,'2008-09-23','2008-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(131,0,'2009-09-23',0,'',1,'2009-09-23','2009-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(132,0,'2010-09-23',0,'',1,'2010-09-23','2010-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(133,0,'2011-09-23',0,'',1,'2011-09-23','2011-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(134,0,'2012-09-22',0,'',1,'2012-09-22','2012-09-22','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(135,0,'2013-09-23',0,'',1,'2013-09-23','2013-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(136,0,'2014-09-23',0,'',1,'2014-09-23','2014-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(137,0,'2015-09-23',0,'',1,'2015-09-23','2015-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(138,0,'2016-09-22',0,'',1,'2016-09-22','2016-09-22','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(139,0,'2017-09-23',0,'',1,'2017-09-23','2017-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(140,0,'2018-09-23',0,'',1,'2018-09-23','2018-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(141,0,'2019-09-23',0,'',1,'2019-09-23','2019-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(142,0,'2020-09-23',0,'',1,'2020-09-23','2020-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(143,0,'2021-09-23',0,'',1,'2021-09-23','2021-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(144,0,'2022-09-23',0,'',1,'2022-09-23','2022-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(145,0,'2023-09-23',0,'',1,'2023-09-23','2023-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(146,0,'2024-09-22',0,'',1,'2024-09-22','2024-09-22','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(147,0,'2025-09-23',0,'',1,'2025-09-23','2025-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(148,0,'2026-09-23',0,'',1,'2026-09-23','2026-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(149,0,'2027-09-23',0,'',1,'2027-09-23','2027-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(150,0,'2028-09-22',0,'',1,'2028-09-22','2028-09-22','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(151,0,'2029-09-23',0,'',1,'2029-09-23','2029-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(152,0,'2030-09-23',0,'',1,'2030-09-23','2030-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(153,0,'2031-09-23',0,'',1,'2031-09-23','2031-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(154,0,'2032-09-22',0,'',1,'2032-09-22','2032-09-22','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(155,0,'2033-09-23',0,'',1,'2033-09-23','2033-09-23','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(156,0,'1988-05-04',0,'',0,'1988-05-04','1988-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(157,0,'1989-05-04',0,'',0,'1989-05-04','1989-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(158,0,'1990-05-04',0,'',0,'1990-05-04','1990-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(159,0,'1991-05-04',0,'',0,'1991-05-04','1991-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(160,0,'1993-05-04',0,'',0,'1993-05-04','1993-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(161,0,'1994-05-04',0,'',0,'1994-05-04','1994-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(162,0,'1995-05-04',0,'',0,'1995-05-04','1995-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(163,0,'1996-05-04',0,'',0,'1996-05-04','1996-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(164,0,'1999-05-04',0,'',0,'1999-05-04','1999-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(165,0,'2000-05-04',0,'',0,'2000-05-04','2000-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(166,0,'2001-05-04',0,'',0,'2001-05-04','2001-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(167,0,'2002-05-04',0,'',0,'2002-05-04','2002-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(168,0,'2004-05-04',0,'',0,'2004-05-04','2004-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(169,0,'2005-05-04',0,'',0,'2005-05-04','2005-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(170,0,'2006-05-04',0,'',0,'2006-05-04','2006-05-04','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(171,0,'1996-07-20',0,'',1,'1996-07-20','2002-07-20','FREQ=YEARLY;INTERVAL=1;BYMONTH=7;UNTIL=20020719T150000',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(172,1,'2003-07-21',3,'MO',0,'2003-07-21','2033-07-18','FREQ=YEARLY;INTERVAL=1;BYMONTH=7;BYDAY=3MO;UNTIL=20330717T150000',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(173,0,'2015-09-22',0,'',0,'2015-09-22','2015-09-22','',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(174,0,'2016-08-11',0,'',1,'2016-08-11','2033-08-11','FREQ=YEARLY;INTERVAL=1;BYMONTH=8;UNTIL=20330811T150000',0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25');
/*!40000 ALTER TABLE `holiday_rrules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(255) NOT NULL,
  `holiday_rrule_id` int(11) NOT NULL,
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `holiday` date NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '祝日名称',
  `is_substitute` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:振替ではない,1:振替休日',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `holiday` (`holiday`,`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2023 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holidays`
--

LOCK TABLES `holidays` WRITE;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
INSERT INTO `holidays` VALUES (1,'holiday_1',1,2,1,1,0,'1970-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(2,'holiday_1',1,1,0,1,0,'1970-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(3,'holiday_2',1,2,1,1,0,'1971-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(4,'holiday_2',1,1,0,1,0,'1971-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(5,'holiday_3',1,2,1,1,0,'1972-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(6,'holiday_3',1,1,0,1,0,'1972-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(7,'holiday_4',1,2,1,1,0,'1973-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(8,'holiday_4',1,1,0,1,0,'1973-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(9,'holiday_5',1,2,1,1,0,'1974-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(10,'holiday_5',1,1,0,1,0,'1974-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(11,'holiday_6',2,2,1,1,0,'1975-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(12,'holiday_6',2,1,0,1,0,'1975-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(13,'holiday_7',2,2,1,1,0,'1976-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(14,'holiday_7',2,1,0,1,0,'1976-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(15,'holiday_8',2,2,1,1,0,'1977-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(16,'holiday_8',2,1,0,1,0,'1977-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(17,'holiday_9',2,2,1,1,0,'1978-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(18,'holiday_9',2,1,0,1,0,'1978-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(19,'holiday_10',2,2,1,1,0,'1978-01-02','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(20,'holiday_10',2,1,0,1,0,'1978-01-02','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(21,'holiday_11',2,2,1,1,0,'1979-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(22,'holiday_11',2,1,0,1,0,'1979-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(23,'holiday_12',2,2,1,1,0,'1980-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(24,'holiday_12',2,1,0,1,0,'1980-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(25,'holiday_13',2,2,1,1,0,'1981-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(26,'holiday_13',2,1,0,1,0,'1981-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(27,'holiday_14',2,2,1,1,0,'1982-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(28,'holiday_14',2,1,0,1,0,'1982-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(29,'holiday_15',2,2,1,1,0,'1983-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(30,'holiday_15',2,1,0,1,0,'1983-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(31,'holiday_16',2,2,1,1,0,'1984-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(32,'holiday_16',2,1,0,1,0,'1984-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(33,'holiday_17',2,2,1,1,0,'1984-01-02','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(34,'holiday_17',2,1,0,1,0,'1984-01-02','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(35,'holiday_18',2,2,1,1,0,'1985-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(36,'holiday_18',2,1,0,1,0,'1985-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(37,'holiday_19',2,2,1,1,0,'1986-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(38,'holiday_19',2,1,0,1,0,'1986-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(39,'holiday_20',2,2,1,1,0,'1987-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(40,'holiday_20',2,1,0,1,0,'1987-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(41,'holiday_21',2,2,1,1,0,'1988-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(42,'holiday_21',2,1,0,1,0,'1988-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(43,'holiday_22',2,2,1,1,0,'1989-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(44,'holiday_22',2,1,0,1,0,'1989-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(45,'holiday_23',2,2,1,1,0,'1989-01-02','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(46,'holiday_23',2,1,0,1,0,'1989-01-02','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(47,'holiday_24',2,2,1,1,0,'1990-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(48,'holiday_24',2,1,0,1,0,'1990-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(49,'holiday_25',2,2,1,1,0,'1991-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(50,'holiday_25',2,1,0,1,0,'1991-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(51,'holiday_26',2,2,1,1,0,'1992-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(52,'holiday_26',2,1,0,1,0,'1992-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(53,'holiday_27',2,2,1,1,0,'1993-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(54,'holiday_27',2,1,0,1,0,'1993-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(55,'holiday_28',2,2,1,1,0,'1994-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(56,'holiday_28',2,1,0,1,0,'1994-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(57,'holiday_29',2,2,1,1,0,'1995-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(58,'holiday_29',2,1,0,1,0,'1995-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(59,'holiday_30',2,2,1,1,0,'1995-01-02','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(60,'holiday_30',2,1,0,1,0,'1995-01-02','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(61,'holiday_31',2,2,1,1,0,'1996-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(62,'holiday_31',2,1,0,1,0,'1996-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(63,'holiday_32',2,2,1,1,0,'1997-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(64,'holiday_32',2,1,0,1,0,'1997-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(65,'holiday_33',2,2,1,1,0,'1998-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(66,'holiday_33',2,1,0,1,0,'1998-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(67,'holiday_34',2,2,1,1,0,'1999-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(68,'holiday_34',2,1,0,1,0,'1999-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(69,'holiday_35',2,2,1,1,0,'2000-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(70,'holiday_35',2,1,0,1,0,'2000-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(71,'holiday_36',2,2,1,1,0,'2001-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(72,'holiday_36',2,1,0,1,0,'2001-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(73,'holiday_37',2,2,1,1,0,'2002-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(74,'holiday_37',2,1,0,1,0,'2002-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(75,'holiday_38',2,2,1,1,0,'2003-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(76,'holiday_38',2,1,0,1,0,'2003-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(77,'holiday_39',2,2,1,1,0,'2004-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(78,'holiday_39',2,1,0,1,0,'2004-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(79,'holiday_40',2,2,1,1,0,'2005-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(80,'holiday_40',2,1,0,1,0,'2005-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(81,'holiday_41',2,2,1,1,0,'2006-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(82,'holiday_41',2,1,0,1,0,'2006-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(83,'holiday_42',2,2,1,1,0,'2006-01-02','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(84,'holiday_42',2,1,0,1,0,'2006-01-02','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(85,'holiday_43',2,2,1,1,0,'2007-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(86,'holiday_43',2,1,0,1,0,'2007-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(87,'holiday_44',2,2,1,1,0,'2008-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(88,'holiday_44',2,1,0,1,0,'2008-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(89,'holiday_45',2,2,1,1,0,'2009-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(90,'holiday_45',2,1,0,1,0,'2009-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(91,'holiday_46',2,2,1,1,0,'2010-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(92,'holiday_46',2,1,0,1,0,'2010-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(93,'holiday_47',2,2,1,1,0,'2011-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(94,'holiday_47',2,1,0,1,0,'2011-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(95,'holiday_48',2,2,1,1,0,'2012-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(96,'holiday_48',2,1,0,1,0,'2012-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(97,'holiday_49',2,2,1,1,0,'2012-01-02','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(98,'holiday_49',2,1,0,1,0,'2012-01-02','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(99,'holiday_50',2,2,1,1,0,'2013-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(100,'holiday_50',2,1,0,1,0,'2013-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(101,'holiday_51',2,2,1,1,0,'2014-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(102,'holiday_51',2,1,0,1,0,'2014-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(103,'holiday_52',2,2,1,1,0,'2015-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(104,'holiday_52',2,1,0,1,0,'2015-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(105,'holiday_53',2,2,1,1,0,'2016-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(106,'holiday_53',2,1,0,1,0,'2016-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(107,'holiday_54',2,2,1,1,0,'2017-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(108,'holiday_54',2,1,0,1,0,'2017-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(109,'holiday_55',2,2,1,1,0,'2017-01-02','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(110,'holiday_55',2,1,0,1,0,'2017-01-02','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(111,'holiday_56',2,2,1,1,0,'2018-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(112,'holiday_56',2,1,0,1,0,'2018-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(113,'holiday_57',2,2,1,1,0,'2019-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(114,'holiday_57',2,1,0,1,0,'2019-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(115,'holiday_58',2,2,1,1,0,'2020-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(116,'holiday_58',2,1,0,1,0,'2020-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(117,'holiday_59',2,2,1,1,0,'2021-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(118,'holiday_59',2,1,0,1,0,'2021-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(119,'holiday_60',2,2,1,1,0,'2022-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(120,'holiday_60',2,1,0,1,0,'2022-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(121,'holiday_61',2,2,1,1,0,'2023-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(122,'holiday_61',2,1,0,1,0,'2023-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(123,'holiday_62',2,2,1,1,0,'2023-01-02','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(124,'holiday_62',2,1,0,1,0,'2023-01-02','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(125,'holiday_63',2,2,1,1,0,'2024-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(126,'holiday_63',2,1,0,1,0,'2024-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(127,'holiday_64',2,2,1,1,0,'2025-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(128,'holiday_64',2,1,0,1,0,'2025-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(129,'holiday_65',2,2,1,1,0,'2026-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(130,'holiday_65',2,1,0,1,0,'2026-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(131,'holiday_66',2,2,1,1,0,'2027-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(132,'holiday_66',2,1,0,1,0,'2027-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(133,'holiday_67',2,2,1,1,0,'2028-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(134,'holiday_67',2,1,0,1,0,'2028-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(135,'holiday_68',2,2,1,1,0,'2029-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(136,'holiday_68',2,1,0,1,0,'2029-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(137,'holiday_69',2,2,1,1,0,'2030-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(138,'holiday_69',2,1,0,1,0,'2030-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(139,'holiday_70',2,2,1,1,0,'2031-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(140,'holiday_70',2,1,0,1,0,'2031-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(141,'holiday_71',2,2,1,1,0,'2032-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(142,'holiday_71',2,1,0,1,0,'2032-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(143,'holiday_72',2,2,1,1,0,'2033-01-01','元日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(144,'holiday_72',2,1,0,1,0,'2033-01-01','New Year\'s Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(145,'holiday_73',3,2,1,1,0,'1970-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(146,'holiday_73',3,1,0,1,0,'1970-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(147,'holiday_74',3,2,1,1,0,'1971-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(148,'holiday_74',3,1,0,1,0,'1971-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(149,'holiday_75',3,2,1,1,0,'1972-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(150,'holiday_75',3,1,0,1,0,'1972-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(151,'holiday_76',3,2,1,1,0,'1973-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(152,'holiday_76',3,1,0,1,0,'1973-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(153,'holiday_77',3,2,1,1,0,'1974-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(154,'holiday_77',3,1,0,1,0,'1974-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(155,'holiday_78',4,2,1,1,0,'1975-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(156,'holiday_78',4,1,0,1,0,'1975-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(157,'holiday_79',4,2,1,1,0,'1976-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(158,'holiday_79',4,1,0,1,0,'1976-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(159,'holiday_80',4,2,1,1,0,'1977-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(160,'holiday_80',4,1,0,1,0,'1977-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(161,'holiday_81',4,2,1,1,0,'1978-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(162,'holiday_81',4,1,0,1,0,'1978-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(163,'holiday_82',4,2,1,1,0,'1978-01-16','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(164,'holiday_82',4,1,0,1,0,'1978-01-16','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(165,'holiday_83',4,2,1,1,0,'1979-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(166,'holiday_83',4,1,0,1,0,'1979-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(167,'holiday_84',4,2,1,1,0,'1980-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(168,'holiday_84',4,1,0,1,0,'1980-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(169,'holiday_85',4,2,1,1,0,'1981-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(170,'holiday_85',4,1,0,1,0,'1981-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(171,'holiday_86',4,2,1,1,0,'1982-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(172,'holiday_86',4,1,0,1,0,'1982-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(173,'holiday_87',4,2,1,1,0,'1983-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(174,'holiday_87',4,1,0,1,0,'1983-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(175,'holiday_88',4,2,1,1,0,'1984-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(176,'holiday_88',4,1,0,1,0,'1984-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(177,'holiday_89',4,2,1,1,0,'1984-01-16','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(178,'holiday_89',4,1,0,1,0,'1984-01-16','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(179,'holiday_90',4,2,1,1,0,'1985-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(180,'holiday_90',4,1,0,1,0,'1985-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(181,'holiday_91',4,2,1,1,0,'1986-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(182,'holiday_91',4,1,0,1,0,'1986-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(183,'holiday_92',4,2,1,1,0,'1987-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(184,'holiday_92',4,1,0,1,0,'1987-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(185,'holiday_93',4,2,1,1,0,'1988-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(186,'holiday_93',4,1,0,1,0,'1988-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(187,'holiday_94',4,2,1,1,0,'1989-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(188,'holiday_94',4,1,0,1,0,'1989-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(189,'holiday_95',4,2,1,1,0,'1989-01-16','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(190,'holiday_95',4,1,0,1,0,'1989-01-16','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(191,'holiday_96',4,2,1,1,0,'1990-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(192,'holiday_96',4,1,0,1,0,'1990-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(193,'holiday_97',4,2,1,1,0,'1991-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(194,'holiday_97',4,1,0,1,0,'1991-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(195,'holiday_98',4,2,1,1,0,'1992-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(196,'holiday_98',4,1,0,1,0,'1992-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(197,'holiday_99',4,2,1,1,0,'1993-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(198,'holiday_99',4,1,0,1,0,'1993-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(199,'holiday_100',4,2,1,1,0,'1994-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(200,'holiday_100',4,1,0,1,0,'1994-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(201,'holiday_101',4,2,1,1,0,'1995-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(202,'holiday_101',4,1,0,1,0,'1995-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(203,'holiday_102',4,2,1,1,0,'1995-01-16','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(204,'holiday_102',4,1,0,1,0,'1995-01-16','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(205,'holiday_103',4,2,1,1,0,'1996-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(206,'holiday_103',4,1,0,1,0,'1996-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(207,'holiday_104',4,2,1,1,0,'1997-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(208,'holiday_104',4,1,0,1,0,'1997-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(209,'holiday_105',4,2,1,1,0,'1998-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(210,'holiday_105',4,1,0,1,0,'1998-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(211,'holiday_106',4,2,1,1,0,'1999-01-15','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(212,'holiday_106',4,1,0,1,0,'1999-01-15','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(213,'holiday_107',5,2,1,1,0,'2000-01-10','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(214,'holiday_107',5,1,0,1,0,'2000-01-10','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(215,'holiday_108',5,2,1,1,0,'2001-01-08','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(216,'holiday_108',5,1,0,1,0,'2001-01-08','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(217,'holiday_109',5,2,1,1,0,'2002-01-14','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(218,'holiday_109',5,1,0,1,0,'2002-01-14','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(219,'holiday_110',5,2,1,1,0,'2003-01-13','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(220,'holiday_110',5,1,0,1,0,'2003-01-13','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(221,'holiday_111',5,2,1,1,0,'2004-01-12','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(222,'holiday_111',5,1,0,1,0,'2004-01-12','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(223,'holiday_112',5,2,1,1,0,'2005-01-10','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(224,'holiday_112',5,1,0,1,0,'2005-01-10','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(225,'holiday_113',5,2,1,1,0,'2006-01-09','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(226,'holiday_113',5,1,0,1,0,'2006-01-09','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(227,'holiday_114',5,2,1,1,0,'2007-01-08','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(228,'holiday_114',5,1,0,1,0,'2007-01-08','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(229,'holiday_115',5,2,1,1,0,'2008-01-14','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(230,'holiday_115',5,1,0,1,0,'2008-01-14','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(231,'holiday_116',5,2,1,1,0,'2009-01-12','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(232,'holiday_116',5,1,0,1,0,'2009-01-12','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(233,'holiday_117',5,2,1,1,0,'2010-01-11','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(234,'holiday_117',5,1,0,1,0,'2010-01-11','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(235,'holiday_118',5,2,1,1,0,'2011-01-10','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(236,'holiday_118',5,1,0,1,0,'2011-01-10','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(237,'holiday_119',5,2,1,1,0,'2012-01-09','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(238,'holiday_119',5,1,0,1,0,'2012-01-09','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(239,'holiday_120',5,2,1,1,0,'2013-01-14','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(240,'holiday_120',5,1,0,1,0,'2013-01-14','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(241,'holiday_121',5,2,1,1,0,'2014-01-13','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(242,'holiday_121',5,1,0,1,0,'2014-01-13','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(243,'holiday_122',5,2,1,1,0,'2015-01-12','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(244,'holiday_122',5,1,0,1,0,'2015-01-12','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(245,'holiday_123',5,2,1,1,0,'2016-01-11','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(246,'holiday_123',5,1,0,1,0,'2016-01-11','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(247,'holiday_124',5,2,1,1,0,'2017-01-09','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(248,'holiday_124',5,1,0,1,0,'2017-01-09','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(249,'holiday_125',5,2,1,1,0,'2018-01-08','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(250,'holiday_125',5,1,0,1,0,'2018-01-08','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(251,'holiday_126',5,2,1,1,0,'2019-01-14','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(252,'holiday_126',5,1,0,1,0,'2019-01-14','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(253,'holiday_127',5,2,1,1,0,'2020-01-13','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(254,'holiday_127',5,1,0,1,0,'2020-01-13','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(255,'holiday_128',5,2,1,1,0,'2021-01-11','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(256,'holiday_128',5,1,0,1,0,'2021-01-11','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(257,'holiday_129',5,2,1,1,0,'2022-01-10','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(258,'holiday_129',5,1,0,1,0,'2022-01-10','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(259,'holiday_130',5,2,1,1,0,'2023-01-09','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(260,'holiday_130',5,1,0,1,0,'2023-01-09','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(261,'holiday_131',5,2,1,1,0,'2024-01-08','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(262,'holiday_131',5,1,0,1,0,'2024-01-08','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(263,'holiday_132',5,2,1,1,0,'2025-01-13','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(264,'holiday_132',5,1,0,1,0,'2025-01-13','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(265,'holiday_133',5,2,1,1,0,'2026-01-12','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(266,'holiday_133',5,1,0,1,0,'2026-01-12','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(267,'holiday_134',5,2,1,1,0,'2027-01-11','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(268,'holiday_134',5,1,0,1,0,'2027-01-11','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(269,'holiday_135',5,2,1,1,0,'2028-01-10','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(270,'holiday_135',5,1,0,1,0,'2028-01-10','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(271,'holiday_136',5,2,1,1,0,'2029-01-08','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(272,'holiday_136',5,1,0,1,0,'2029-01-08','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(273,'holiday_137',5,2,1,1,0,'2030-01-14','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(274,'holiday_137',5,1,0,1,0,'2030-01-14','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(275,'holiday_138',5,2,1,1,0,'2031-01-13','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(276,'holiday_138',5,1,0,1,0,'2031-01-13','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(277,'holiday_139',5,2,1,1,0,'2032-01-12','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(278,'holiday_139',5,1,0,1,0,'2032-01-12','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(279,'holiday_140',5,2,1,1,0,'2033-01-10','成人の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(280,'holiday_140',5,1,0,1,0,'2033-01-10','Coming-of-Age Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(281,'holiday_141',6,2,1,1,0,'1970-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(282,'holiday_141',6,1,0,1,0,'1970-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(283,'holiday_142',6,2,1,1,0,'1971-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(284,'holiday_142',6,1,0,1,0,'1971-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(285,'holiday_143',6,2,1,1,0,'1972-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(286,'holiday_143',6,1,0,1,0,'1972-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(287,'holiday_144',6,2,1,1,0,'1973-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(288,'holiday_144',6,1,0,1,0,'1973-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(289,'holiday_145',6,2,1,1,0,'1974-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(290,'holiday_145',6,1,0,1,0,'1974-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(291,'holiday_146',7,2,1,1,0,'1975-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(292,'holiday_146',7,1,0,1,0,'1975-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(293,'holiday_147',7,2,1,1,0,'1976-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(294,'holiday_147',7,1,0,1,0,'1976-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(295,'holiday_148',7,2,1,1,0,'1977-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(296,'holiday_148',7,1,0,1,0,'1977-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(297,'holiday_149',7,2,1,1,0,'1978-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(298,'holiday_149',7,1,0,1,0,'1978-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(299,'holiday_150',7,2,1,1,0,'1979-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(300,'holiday_150',7,1,0,1,0,'1979-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(301,'holiday_151',7,2,1,1,0,'1979-02-12','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(302,'holiday_151',7,1,0,1,0,'1979-02-12','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(303,'holiday_152',7,2,1,1,0,'1980-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(304,'holiday_152',7,1,0,1,0,'1980-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(305,'holiday_153',7,2,1,1,0,'1981-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(306,'holiday_153',7,1,0,1,0,'1981-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(307,'holiday_154',7,2,1,1,0,'1982-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(308,'holiday_154',7,1,0,1,0,'1982-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(309,'holiday_155',7,2,1,1,0,'1983-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(310,'holiday_155',7,1,0,1,0,'1983-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(311,'holiday_156',7,2,1,1,0,'1984-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(312,'holiday_156',7,1,0,1,0,'1984-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(313,'holiday_157',7,2,1,1,0,'1985-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(314,'holiday_157',7,1,0,1,0,'1985-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(315,'holiday_158',7,2,1,1,0,'1986-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(316,'holiday_158',7,1,0,1,0,'1986-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(317,'holiday_159',7,2,1,1,0,'1987-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(318,'holiday_159',7,1,0,1,0,'1987-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(319,'holiday_160',7,2,1,1,0,'1988-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(320,'holiday_160',7,1,0,1,0,'1988-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(321,'holiday_161',7,2,1,1,0,'1989-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(322,'holiday_161',7,1,0,1,0,'1989-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(323,'holiday_162',7,2,1,1,0,'1990-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(324,'holiday_162',7,1,0,1,0,'1990-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(325,'holiday_163',7,2,1,1,0,'1990-02-12','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(326,'holiday_163',7,1,0,1,0,'1990-02-12','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(327,'holiday_164',7,2,1,1,0,'1991-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(328,'holiday_164',7,1,0,1,0,'1991-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(329,'holiday_165',7,2,1,1,0,'1992-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(330,'holiday_165',7,1,0,1,0,'1992-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(331,'holiday_166',7,2,1,1,0,'1993-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(332,'holiday_166',7,1,0,1,0,'1993-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(333,'holiday_167',7,2,1,1,0,'1994-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(334,'holiday_167',7,1,0,1,0,'1994-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(335,'holiday_168',7,2,1,1,0,'1995-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(336,'holiday_168',7,1,0,1,0,'1995-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(337,'holiday_169',7,2,1,1,0,'1996-02-11','建国記念の日',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(338,'holiday_169',7,1,0,1,0,'1996-02-11','Foundation Day',0,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(339,'holiday_170',7,2,1,1,0,'1996-02-12','(振替休日)',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(340,'holiday_170',7,1,0,1,0,'1996-02-12','Transfer holiday',1,0,'2019-03-02 03:14:25',0,'2019-03-02 03:14:25'),(341,'holiday_171',7,2,1,1,0,'1997-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(342,'holiday_171',7,1,0,1,0,'1997-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(343,'holiday_172',7,2,1,1,0,'1998-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(344,'holiday_172',7,1,0,1,0,'1998-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(345,'holiday_173',7,2,1,1,0,'1999-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(346,'holiday_173',7,1,0,1,0,'1999-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(347,'holiday_174',7,2,1,1,0,'2000-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(348,'holiday_174',7,1,0,1,0,'2000-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(349,'holiday_175',7,2,1,1,0,'2001-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(350,'holiday_175',7,1,0,1,0,'2001-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(351,'holiday_176',7,2,1,1,0,'2001-02-12','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(352,'holiday_176',7,1,0,1,0,'2001-02-12','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(353,'holiday_177',7,2,1,1,0,'2002-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(354,'holiday_177',7,1,0,1,0,'2002-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(355,'holiday_178',7,2,1,1,0,'2003-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(356,'holiday_178',7,1,0,1,0,'2003-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(357,'holiday_179',7,2,1,1,0,'2004-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(358,'holiday_179',7,1,0,1,0,'2004-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(359,'holiday_180',7,2,1,1,0,'2005-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(360,'holiday_180',7,1,0,1,0,'2005-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(361,'holiday_181',7,2,1,1,0,'2006-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(362,'holiday_181',7,1,0,1,0,'2006-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(363,'holiday_182',7,2,1,1,0,'2007-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(364,'holiday_182',7,1,0,1,0,'2007-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(365,'holiday_183',7,2,1,1,0,'2007-02-12','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(366,'holiday_183',7,1,0,1,0,'2007-02-12','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(367,'holiday_184',7,2,1,1,0,'2008-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(368,'holiday_184',7,1,0,1,0,'2008-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(369,'holiday_185',7,2,1,1,0,'2009-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(370,'holiday_185',7,1,0,1,0,'2009-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(371,'holiday_186',7,2,1,1,0,'2010-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(372,'holiday_186',7,1,0,1,0,'2010-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(373,'holiday_187',7,2,1,1,0,'2011-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(374,'holiday_187',7,1,0,1,0,'2011-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(375,'holiday_188',7,2,1,1,0,'2012-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(376,'holiday_188',7,1,0,1,0,'2012-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(377,'holiday_189',7,2,1,1,0,'2013-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(378,'holiday_189',7,1,0,1,0,'2013-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(379,'holiday_190',7,2,1,1,0,'2014-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(380,'holiday_190',7,1,0,1,0,'2014-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(381,'holiday_191',7,2,1,1,0,'2015-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(382,'holiday_191',7,1,0,1,0,'2015-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(383,'holiday_192',7,2,1,1,0,'2016-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(384,'holiday_192',7,1,0,1,0,'2016-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(385,'holiday_193',7,2,1,1,0,'2017-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(386,'holiday_193',7,1,0,1,0,'2017-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(387,'holiday_194',7,2,1,1,0,'2018-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(388,'holiday_194',7,1,0,1,0,'2018-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(389,'holiday_195',7,2,1,1,0,'2018-02-12','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(390,'holiday_195',7,1,0,1,0,'2018-02-12','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(391,'holiday_196',7,2,1,1,0,'2019-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(392,'holiday_196',7,1,0,1,0,'2019-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(393,'holiday_197',7,2,1,1,0,'2020-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(394,'holiday_197',7,1,0,1,0,'2020-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(395,'holiday_198',7,2,1,1,0,'2021-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(396,'holiday_198',7,1,0,1,0,'2021-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(397,'holiday_199',7,2,1,1,0,'2022-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(398,'holiday_199',7,1,0,1,0,'2022-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(399,'holiday_200',7,2,1,1,0,'2023-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(400,'holiday_200',7,1,0,1,0,'2023-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(401,'holiday_201',7,2,1,1,0,'2024-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(402,'holiday_201',7,1,0,1,0,'2024-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(403,'holiday_202',7,2,1,1,0,'2024-02-12','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(404,'holiday_202',7,1,0,1,0,'2024-02-12','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(405,'holiday_203',7,2,1,1,0,'2025-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(406,'holiday_203',7,1,0,1,0,'2025-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(407,'holiday_204',7,2,1,1,0,'2026-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(408,'holiday_204',7,1,0,1,0,'2026-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(409,'holiday_205',7,2,1,1,0,'2027-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(410,'holiday_205',7,1,0,1,0,'2027-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(411,'holiday_206',7,2,1,1,0,'2028-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(412,'holiday_206',7,1,0,1,0,'2028-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(413,'holiday_207',7,2,1,1,0,'2029-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(414,'holiday_207',7,1,0,1,0,'2029-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(415,'holiday_208',7,2,1,1,0,'2029-02-12','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(416,'holiday_208',7,1,0,1,0,'2029-02-12','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(417,'holiday_209',7,2,1,1,0,'2030-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(418,'holiday_209',7,1,0,1,0,'2030-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(419,'holiday_210',7,2,1,1,0,'2031-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(420,'holiday_210',7,1,0,1,0,'2031-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(421,'holiday_211',7,2,1,1,0,'2032-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(422,'holiday_211',7,1,0,1,0,'2032-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(423,'holiday_212',7,2,1,1,0,'2033-02-11','建国記念の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(424,'holiday_212',7,1,0,1,0,'2033-02-11','Foundation Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(425,'holiday_213',8,2,1,1,0,'1970-03-21','春分の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(426,'holiday_213',8,1,0,1,0,'1970-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(427,'holiday_214',9,2,1,1,0,'1971-03-21','春分の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(428,'holiday_214',9,1,0,1,0,'1971-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(429,'holiday_215',10,2,1,1,0,'1972-03-20','春分の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(430,'holiday_215',10,1,0,1,0,'1972-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(431,'holiday_216',11,2,1,1,0,'1973-03-21','春分の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(432,'holiday_216',11,1,0,1,0,'1973-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(433,'holiday_217',12,2,1,1,0,'1974-03-21','春分の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(434,'holiday_217',12,1,0,1,0,'1974-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(435,'holiday_218',13,2,1,1,0,'1970-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(436,'holiday_218',13,1,0,1,0,'1970-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(437,'holiday_219',13,2,1,1,0,'1971-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(438,'holiday_219',13,1,0,1,0,'1971-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(439,'holiday_220',13,2,1,1,0,'1972-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(440,'holiday_220',13,1,0,1,0,'1972-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(441,'holiday_221',13,2,1,1,0,'1973-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(442,'holiday_221',13,1,0,1,0,'1973-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(443,'holiday_222',14,2,1,1,0,'1974-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(444,'holiday_222',14,1,0,1,0,'1974-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(445,'holiday_223',14,2,1,1,0,'1975-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(446,'holiday_223',14,1,0,1,0,'1975-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(447,'holiday_224',14,2,1,1,0,'1976-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(448,'holiday_224',14,1,0,1,0,'1976-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(449,'holiday_225',14,2,1,1,0,'1977-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(450,'holiday_225',14,1,0,1,0,'1977-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(451,'holiday_226',14,2,1,1,0,'1978-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(452,'holiday_226',14,1,0,1,0,'1978-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(453,'holiday_227',14,2,1,1,0,'1979-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(454,'holiday_227',14,1,0,1,0,'1979-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(455,'holiday_228',14,2,1,1,0,'1979-04-30','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(456,'holiday_228',14,1,0,1,0,'1979-04-30','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(457,'holiday_229',14,2,1,1,0,'1980-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(458,'holiday_229',14,1,0,1,0,'1980-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(459,'holiday_230',14,2,1,1,0,'1981-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(460,'holiday_230',14,1,0,1,0,'1981-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(461,'holiday_231',14,2,1,1,0,'1982-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(462,'holiday_231',14,1,0,1,0,'1982-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(463,'holiday_232',14,2,1,1,0,'1983-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(464,'holiday_232',14,1,0,1,0,'1983-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(465,'holiday_233',14,2,1,1,0,'1984-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(466,'holiday_233',14,1,0,1,0,'1984-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(467,'holiday_234',14,2,1,1,0,'1984-04-30','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(468,'holiday_234',14,1,0,1,0,'1984-04-30','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(469,'holiday_235',14,2,1,1,0,'1985-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(470,'holiday_235',14,1,0,1,0,'1985-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(471,'holiday_236',14,2,1,1,0,'1986-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(472,'holiday_236',14,1,0,1,0,'1986-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(473,'holiday_237',14,2,1,1,0,'1987-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(474,'holiday_237',14,1,0,1,0,'1987-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(475,'holiday_238',14,2,1,1,0,'1988-04-29','天皇誕生日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(476,'holiday_238',14,1,0,1,0,'1988-04-29','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(477,'holiday_239',15,2,1,1,0,'1989-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(478,'holiday_239',15,1,0,1,0,'1989-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(479,'holiday_240',15,2,1,1,0,'1990-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(480,'holiday_240',15,1,0,1,0,'1990-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(481,'holiday_241',15,2,1,1,0,'1990-04-30','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(482,'holiday_241',15,1,0,1,0,'1990-04-30','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(483,'holiday_242',15,2,1,1,0,'1991-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(484,'holiday_242',15,1,0,1,0,'1991-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(485,'holiday_243',15,2,1,1,0,'1992-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(486,'holiday_243',15,1,0,1,0,'1992-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(487,'holiday_244',15,2,1,1,0,'1993-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(488,'holiday_244',15,1,0,1,0,'1993-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(489,'holiday_245',15,2,1,1,0,'1994-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(490,'holiday_245',15,1,0,1,0,'1994-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(491,'holiday_246',15,2,1,1,0,'1995-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(492,'holiday_246',15,1,0,1,0,'1995-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(493,'holiday_247',15,2,1,1,0,'1996-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(494,'holiday_247',15,1,0,1,0,'1996-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(495,'holiday_248',15,2,1,1,0,'1997-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(496,'holiday_248',15,1,0,1,0,'1997-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(497,'holiday_249',15,2,1,1,0,'1998-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(498,'holiday_249',15,1,0,1,0,'1998-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(499,'holiday_250',15,2,1,1,0,'1999-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(500,'holiday_250',15,1,0,1,0,'1999-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(501,'holiday_251',15,2,1,1,0,'2000-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(502,'holiday_251',15,1,0,1,0,'2000-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(503,'holiday_252',15,2,1,1,0,'2001-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(504,'holiday_252',15,1,0,1,0,'2001-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(505,'holiday_253',15,2,1,1,0,'2001-04-30','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(506,'holiday_253',15,1,0,1,0,'2001-04-30','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(507,'holiday_254',15,2,1,1,0,'2002-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(508,'holiday_254',15,1,0,1,0,'2002-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(509,'holiday_255',15,2,1,1,0,'2003-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(510,'holiday_255',15,1,0,1,0,'2003-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(511,'holiday_256',15,2,1,1,0,'2004-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(512,'holiday_256',15,1,0,1,0,'2004-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(513,'holiday_257',15,2,1,1,0,'2005-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(514,'holiday_257',15,1,0,1,0,'2005-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(515,'holiday_258',15,2,1,1,0,'2006-04-29','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(516,'holiday_258',15,1,0,1,0,'2006-04-29','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(517,'holiday_259',16,2,1,1,0,'2007-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(518,'holiday_259',16,1,0,1,0,'2007-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(519,'holiday_260',16,2,1,1,0,'2007-04-30','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(520,'holiday_260',16,1,0,1,0,'2007-04-30','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(521,'holiday_261',16,2,1,1,0,'2008-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(522,'holiday_261',16,1,0,1,0,'2008-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(523,'holiday_262',16,2,1,1,0,'2009-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(524,'holiday_262',16,1,0,1,0,'2009-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(525,'holiday_263',16,2,1,1,0,'2010-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(526,'holiday_263',16,1,0,1,0,'2010-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(527,'holiday_264',16,2,1,1,0,'2011-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(528,'holiday_264',16,1,0,1,0,'2011-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(529,'holiday_265',16,2,1,1,0,'2012-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(530,'holiday_265',16,1,0,1,0,'2012-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(531,'holiday_266',16,2,1,1,0,'2012-04-30','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(532,'holiday_266',16,1,0,1,0,'2012-04-30','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(533,'holiday_267',16,2,1,1,0,'2013-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(534,'holiday_267',16,1,0,1,0,'2013-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(535,'holiday_268',16,2,1,1,0,'2014-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(536,'holiday_268',16,1,0,1,0,'2014-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(537,'holiday_269',16,2,1,1,0,'2015-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(538,'holiday_269',16,1,0,1,0,'2015-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(539,'holiday_270',16,2,1,1,0,'2016-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(540,'holiday_270',16,1,0,1,0,'2016-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(541,'holiday_271',16,2,1,1,0,'2017-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(542,'holiday_271',16,1,0,1,0,'2017-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(543,'holiday_272',16,2,1,1,0,'2018-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(544,'holiday_272',16,1,0,1,0,'2018-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(545,'holiday_273',16,2,1,1,0,'2018-04-30','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(546,'holiday_273',16,1,0,1,0,'2018-04-30','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(547,'holiday_274',16,2,1,1,0,'2019-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(548,'holiday_274',16,1,0,1,0,'2019-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(549,'holiday_275',16,2,1,1,0,'2020-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(550,'holiday_275',16,1,0,1,0,'2020-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(551,'holiday_276',16,2,1,1,0,'2021-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(552,'holiday_276',16,1,0,1,0,'2021-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(553,'holiday_277',16,2,1,1,0,'2022-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(554,'holiday_277',16,1,0,1,0,'2022-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(555,'holiday_278',16,2,1,1,0,'2023-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(556,'holiday_278',16,1,0,1,0,'2023-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(557,'holiday_279',16,2,1,1,0,'2024-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(558,'holiday_279',16,1,0,1,0,'2024-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(559,'holiday_280',16,2,1,1,0,'2025-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(560,'holiday_280',16,1,0,1,0,'2025-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(561,'holiday_281',16,2,1,1,0,'2026-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(562,'holiday_281',16,1,0,1,0,'2026-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(563,'holiday_282',16,2,1,1,0,'2027-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(564,'holiday_282',16,1,0,1,0,'2027-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(565,'holiday_283',16,2,1,1,0,'2028-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(566,'holiday_283',16,1,0,1,0,'2028-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(567,'holiday_284',16,2,1,1,0,'2029-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(568,'holiday_284',16,1,0,1,0,'2029-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(569,'holiday_285',16,2,1,1,0,'2029-04-30','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(570,'holiday_285',16,1,0,1,0,'2029-04-30','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(571,'holiday_286',16,2,1,1,0,'2030-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(572,'holiday_286',16,1,0,1,0,'2030-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(573,'holiday_287',16,2,1,1,0,'2031-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(574,'holiday_287',16,1,0,1,0,'2031-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(575,'holiday_288',16,2,1,1,0,'2032-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(576,'holiday_288',16,1,0,1,0,'2032-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(577,'holiday_289',16,2,1,1,0,'2033-04-29','昭和の日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(578,'holiday_289',16,1,0,1,0,'2033-04-29','Showa Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(579,'holiday_290',17,2,1,1,0,'1970-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(580,'holiday_290',17,1,0,1,0,'1970-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(581,'holiday_291',17,2,1,1,0,'1971-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(582,'holiday_291',17,1,0,1,0,'1971-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(583,'holiday_292',17,2,1,1,0,'1972-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(584,'holiday_292',17,1,0,1,0,'1972-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(585,'holiday_293',17,2,1,1,0,'1973-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(586,'holiday_293',17,1,0,1,0,'1973-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(587,'holiday_294',18,2,1,1,0,'1974-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(588,'holiday_294',18,1,0,1,0,'1974-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(589,'holiday_295',18,2,1,1,0,'1975-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(590,'holiday_295',18,1,0,1,0,'1975-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(591,'holiday_296',18,2,1,1,0,'1976-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(592,'holiday_296',18,1,0,1,0,'1976-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(593,'holiday_297',18,2,1,1,0,'1977-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(594,'holiday_297',18,1,0,1,0,'1977-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(595,'holiday_298',18,2,1,1,0,'1978-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(596,'holiday_298',18,1,0,1,0,'1978-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(597,'holiday_299',18,2,1,1,0,'1979-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(598,'holiday_299',18,1,0,1,0,'1979-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(599,'holiday_300',18,2,1,1,0,'1980-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(600,'holiday_300',18,1,0,1,0,'1980-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(601,'holiday_301',18,2,1,1,0,'1981-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(602,'holiday_301',18,1,0,1,0,'1981-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(603,'holiday_302',18,2,1,1,0,'1981-05-04','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(604,'holiday_302',18,1,0,1,0,'1981-05-04','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(605,'holiday_303',18,2,1,1,0,'1982-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(606,'holiday_303',18,1,0,1,0,'1982-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(607,'holiday_304',18,2,1,1,0,'1983-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(608,'holiday_304',18,1,0,1,0,'1983-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(609,'holiday_305',18,2,1,1,0,'1984-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(610,'holiday_305',18,1,0,1,0,'1984-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(611,'holiday_306',18,2,1,1,0,'1985-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(612,'holiday_306',18,1,0,1,0,'1985-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(613,'holiday_307',18,2,1,1,0,'1986-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(614,'holiday_307',18,1,0,1,0,'1986-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(615,'holiday_308',18,2,1,1,0,'1987-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(616,'holiday_308',18,1,0,1,0,'1987-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(617,'holiday_309',18,2,1,1,0,'1987-05-04','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(618,'holiday_309',18,1,0,1,0,'1987-05-04','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(619,'holiday_310',18,2,1,1,0,'1988-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(620,'holiday_310',18,1,0,1,0,'1988-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(621,'holiday_311',18,2,1,1,0,'1989-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(622,'holiday_311',18,1,0,1,0,'1989-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(623,'holiday_312',18,2,1,1,0,'1990-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(624,'holiday_312',18,1,0,1,0,'1990-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(625,'holiday_313',18,2,1,1,0,'1991-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(626,'holiday_313',18,1,0,1,0,'1991-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(627,'holiday_314',18,2,1,1,0,'1992-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(628,'holiday_314',18,1,0,1,0,'1992-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(629,'holiday_315',18,2,1,1,0,'1992-05-04','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(630,'holiday_315',18,1,0,1,0,'1992-05-04','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(631,'holiday_316',18,2,1,1,0,'1993-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(632,'holiday_316',18,1,0,1,0,'1993-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(633,'holiday_317',18,2,1,1,0,'1994-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(634,'holiday_317',18,1,0,1,0,'1994-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(635,'holiday_318',18,2,1,1,0,'1995-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(636,'holiday_318',18,1,0,1,0,'1995-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(637,'holiday_319',18,2,1,1,0,'1996-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(638,'holiday_319',18,1,0,1,0,'1996-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(639,'holiday_320',18,2,1,1,0,'1997-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(640,'holiday_320',18,1,0,1,0,'1997-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(641,'holiday_321',18,2,1,1,0,'1998-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(642,'holiday_321',18,1,0,1,0,'1998-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(643,'holiday_322',18,2,1,1,0,'1998-05-04','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(644,'holiday_322',18,1,0,1,0,'1998-05-04','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(645,'holiday_323',18,2,1,1,0,'1999-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(646,'holiday_323',18,1,0,1,0,'1999-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(647,'holiday_324',18,2,1,1,0,'2000-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(648,'holiday_324',18,1,0,1,0,'2000-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(649,'holiday_325',18,2,1,1,0,'2001-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(650,'holiday_325',18,1,0,1,0,'2001-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(651,'holiday_326',18,2,1,1,0,'2002-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(652,'holiday_326',18,1,0,1,0,'2002-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(653,'holiday_327',18,2,1,1,0,'2003-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(654,'holiday_327',18,1,0,1,0,'2003-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(655,'holiday_328',18,2,1,1,0,'2004-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(656,'holiday_328',18,1,0,1,0,'2004-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(657,'holiday_329',18,2,1,1,0,'2005-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(658,'holiday_329',18,1,0,1,0,'2005-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(659,'holiday_330',18,2,1,1,0,'2006-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(660,'holiday_330',18,1,0,1,0,'2006-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(661,'holiday_331',18,2,1,1,0,'2007-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(662,'holiday_331',18,1,0,1,0,'2007-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(663,'holiday_332',18,2,1,1,0,'2008-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(664,'holiday_332',18,1,0,1,0,'2008-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(665,'holiday_333',18,2,1,1,0,'2009-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(666,'holiday_333',18,1,0,1,0,'2009-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(667,'holiday_334',18,2,1,1,0,'2009-05-06','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(668,'holiday_334',18,1,0,1,0,'2009-05-06','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(669,'holiday_335',18,2,1,1,0,'2010-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(670,'holiday_335',18,1,0,1,0,'2010-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(671,'holiday_336',18,2,1,1,0,'2011-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(672,'holiday_336',18,1,0,1,0,'2011-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(673,'holiday_337',18,2,1,1,0,'2012-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(674,'holiday_337',18,1,0,1,0,'2012-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(675,'holiday_338',18,2,1,1,0,'2013-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(676,'holiday_338',18,1,0,1,0,'2013-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(677,'holiday_339',18,2,1,1,0,'2014-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(678,'holiday_339',18,1,0,1,0,'2014-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(679,'holiday_340',18,2,1,1,0,'2015-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(680,'holiday_340',18,1,0,1,0,'2015-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(681,'holiday_341',18,2,1,1,0,'2015-05-06','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(682,'holiday_341',18,1,0,1,0,'2015-05-06','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(683,'holiday_342',18,2,1,1,0,'2016-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(684,'holiday_342',18,1,0,1,0,'2016-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(685,'holiday_343',18,2,1,1,0,'2017-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(686,'holiday_343',18,1,0,1,0,'2017-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(687,'holiday_344',18,2,1,1,0,'2018-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(688,'holiday_344',18,1,0,1,0,'2018-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(689,'holiday_345',18,2,1,1,0,'2019-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(690,'holiday_345',18,1,0,1,0,'2019-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(691,'holiday_346',18,2,1,1,0,'2020-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(692,'holiday_346',18,1,0,1,0,'2020-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(693,'holiday_347',18,2,1,1,0,'2020-05-06','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(694,'holiday_347',18,1,0,1,0,'2020-05-06','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(695,'holiday_348',18,2,1,1,0,'2021-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(696,'holiday_348',18,1,0,1,0,'2021-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(697,'holiday_349',18,2,1,1,0,'2022-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(698,'holiday_349',18,1,0,1,0,'2022-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(699,'holiday_350',18,2,1,1,0,'2023-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(700,'holiday_350',18,1,0,1,0,'2023-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(701,'holiday_351',18,2,1,1,0,'2024-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(702,'holiday_351',18,1,0,1,0,'2024-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(703,'holiday_352',18,2,1,1,0,'2025-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(704,'holiday_352',18,1,0,1,0,'2025-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(705,'holiday_353',18,2,1,1,0,'2026-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(706,'holiday_353',18,1,0,1,0,'2026-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(707,'holiday_354',18,2,1,1,0,'2026-05-06','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(708,'holiday_354',18,1,0,1,0,'2026-05-06','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(709,'holiday_355',18,2,1,1,0,'2027-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(710,'holiday_355',18,1,0,1,0,'2027-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(711,'holiday_356',18,2,1,1,0,'2028-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(712,'holiday_356',18,1,0,1,0,'2028-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(713,'holiday_357',18,2,1,1,0,'2029-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(714,'holiday_357',18,1,0,1,0,'2029-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(715,'holiday_358',18,2,1,1,0,'2030-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(716,'holiday_358',18,1,0,1,0,'2030-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(717,'holiday_359',18,2,1,1,0,'2031-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(718,'holiday_359',18,1,0,1,0,'2031-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(719,'holiday_360',18,2,1,1,0,'2032-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(720,'holiday_360',18,1,0,1,0,'2032-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(721,'holiday_361',18,2,1,1,0,'2033-05-03','憲法記念日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(722,'holiday_361',18,1,0,1,0,'2033-05-03','Constitution Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(723,'holiday_362',19,2,1,1,0,'2007-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(724,'holiday_362',19,1,0,1,0,'2007-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(725,'holiday_363',19,2,1,1,0,'2008-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(726,'holiday_363',19,1,0,1,0,'2008-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(727,'holiday_364',19,2,1,1,0,'2008-05-06','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(728,'holiday_364',19,1,0,1,0,'2008-05-06','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(729,'holiday_365',19,2,1,1,0,'2009-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(730,'holiday_365',19,1,0,1,0,'2009-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(731,'holiday_366',19,2,1,1,0,'2010-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(732,'holiday_366',19,1,0,1,0,'2010-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(733,'holiday_367',19,2,1,1,0,'2011-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(734,'holiday_367',19,1,0,1,0,'2011-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(735,'holiday_368',19,2,1,1,0,'2012-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(736,'holiday_368',19,1,0,1,0,'2012-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(737,'holiday_369',19,2,1,1,0,'2013-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(738,'holiday_369',19,1,0,1,0,'2013-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(739,'holiday_370',19,2,1,1,0,'2014-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(740,'holiday_370',19,1,0,1,0,'2014-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(741,'holiday_371',19,2,1,1,0,'2014-05-06','(振替休日)',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(742,'holiday_371',19,1,0,1,0,'2014-05-06','Transfer holiday',1,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(743,'holiday_372',19,2,1,1,0,'2015-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(744,'holiday_372',19,1,0,1,0,'2015-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(745,'holiday_373',19,2,1,1,0,'2016-05-04','みどりの日',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(746,'holiday_373',19,1,0,1,0,'2016-05-04','Greenery Day',0,0,'2019-03-02 03:14:26',0,'2019-03-02 03:14:26'),(747,'holiday_374',19,2,1,1,0,'2017-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(748,'holiday_374',19,1,0,1,0,'2017-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(749,'holiday_375',19,2,1,1,0,'2018-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(750,'holiday_375',19,1,0,1,0,'2018-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(751,'holiday_376',19,2,1,1,0,'2019-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(752,'holiday_376',19,1,0,1,0,'2019-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(753,'holiday_377',19,2,1,1,0,'2020-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(754,'holiday_377',19,1,0,1,0,'2020-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(755,'holiday_378',19,2,1,1,0,'2021-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(756,'holiday_378',19,1,0,1,0,'2021-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(757,'holiday_379',19,2,1,1,0,'2022-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(758,'holiday_379',19,1,0,1,0,'2022-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(759,'holiday_380',19,2,1,1,0,'2023-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(760,'holiday_380',19,1,0,1,0,'2023-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(761,'holiday_381',19,2,1,1,0,'2024-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(762,'holiday_381',19,1,0,1,0,'2024-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(763,'holiday_382',19,2,1,1,0,'2025-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(764,'holiday_382',19,1,0,1,0,'2025-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(765,'holiday_383',19,2,1,1,0,'2025-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(766,'holiday_383',19,1,0,1,0,'2025-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(767,'holiday_384',19,2,1,1,0,'2026-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(768,'holiday_384',19,1,0,1,0,'2026-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(769,'holiday_385',19,2,1,1,0,'2027-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(770,'holiday_385',19,1,0,1,0,'2027-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(771,'holiday_386',19,2,1,1,0,'2028-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(772,'holiday_386',19,1,0,1,0,'2028-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(773,'holiday_387',19,2,1,1,0,'2029-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(774,'holiday_387',19,1,0,1,0,'2029-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(775,'holiday_388',19,2,1,1,0,'2030-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(776,'holiday_388',19,1,0,1,0,'2030-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(777,'holiday_389',19,2,1,1,0,'2031-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(778,'holiday_389',19,1,0,1,0,'2031-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(779,'holiday_390',19,2,1,1,0,'2031-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(780,'holiday_390',19,1,0,1,0,'2031-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(781,'holiday_391',19,2,1,1,0,'2032-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(782,'holiday_391',19,1,0,1,0,'2032-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(783,'holiday_392',19,2,1,1,0,'2033-05-04','みどりの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(784,'holiday_392',19,1,0,1,0,'2033-05-04','Greenery Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(785,'holiday_393',20,2,1,1,0,'1970-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(786,'holiday_393',20,1,0,1,0,'1970-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(787,'holiday_394',20,2,1,1,0,'1971-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(788,'holiday_394',20,1,0,1,0,'1971-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(789,'holiday_395',20,2,1,1,0,'1972-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(790,'holiday_395',20,1,0,1,0,'1972-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(791,'holiday_396',20,2,1,1,0,'1973-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(792,'holiday_396',20,1,0,1,0,'1973-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(793,'holiday_397',21,2,1,1,0,'1974-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(794,'holiday_397',21,1,0,1,0,'1974-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(795,'holiday_398',21,2,1,1,0,'1974-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(796,'holiday_398',21,1,0,1,0,'1974-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(797,'holiday_399',21,2,1,1,0,'1975-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(798,'holiday_399',21,1,0,1,0,'1975-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(799,'holiday_400',21,2,1,1,0,'1976-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(800,'holiday_400',21,1,0,1,0,'1976-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(801,'holiday_401',21,2,1,1,0,'1977-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(802,'holiday_401',21,1,0,1,0,'1977-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(803,'holiday_402',21,2,1,1,0,'1978-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(804,'holiday_402',21,1,0,1,0,'1978-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(805,'holiday_403',21,2,1,1,0,'1979-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(806,'holiday_403',21,1,0,1,0,'1979-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(807,'holiday_404',21,2,1,1,0,'1980-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(808,'holiday_404',21,1,0,1,0,'1980-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(809,'holiday_405',21,2,1,1,0,'1981-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(810,'holiday_405',21,1,0,1,0,'1981-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(811,'holiday_406',21,2,1,1,0,'1982-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(812,'holiday_406',21,1,0,1,0,'1982-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(813,'holiday_407',21,2,1,1,0,'1983-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(814,'holiday_407',21,1,0,1,0,'1983-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(815,'holiday_408',21,2,1,1,0,'1984-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(816,'holiday_408',21,1,0,1,0,'1984-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(817,'holiday_409',21,2,1,1,0,'1985-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(818,'holiday_409',21,1,0,1,0,'1985-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(819,'holiday_410',21,2,1,1,0,'1985-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(820,'holiday_410',21,1,0,1,0,'1985-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(821,'holiday_411',21,2,1,1,0,'1986-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(822,'holiday_411',21,1,0,1,0,'1986-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(823,'holiday_412',21,2,1,1,0,'1987-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(824,'holiday_412',21,1,0,1,0,'1987-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(825,'holiday_413',21,2,1,1,0,'1988-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(826,'holiday_413',21,1,0,1,0,'1988-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(827,'holiday_414',21,2,1,1,0,'1989-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(828,'holiday_414',21,1,0,1,0,'1989-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(829,'holiday_415',21,2,1,1,0,'1990-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(830,'holiday_415',21,1,0,1,0,'1990-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(831,'holiday_416',21,2,1,1,0,'1991-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(832,'holiday_416',21,1,0,1,0,'1991-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(833,'holiday_417',21,2,1,1,0,'1991-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(834,'holiday_417',21,1,0,1,0,'1991-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(835,'holiday_418',21,2,1,1,0,'1992-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(836,'holiday_418',21,1,0,1,0,'1992-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(837,'holiday_419',21,2,1,1,0,'1993-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(838,'holiday_419',21,1,0,1,0,'1993-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(839,'holiday_420',21,2,1,1,0,'1994-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(840,'holiday_420',21,1,0,1,0,'1994-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(841,'holiday_421',21,2,1,1,0,'1995-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(842,'holiday_421',21,1,0,1,0,'1995-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(843,'holiday_422',21,2,1,1,0,'1996-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(844,'holiday_422',21,1,0,1,0,'1996-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(845,'holiday_423',21,2,1,1,0,'1996-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(846,'holiday_423',21,1,0,1,0,'1996-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(847,'holiday_424',21,2,1,1,0,'1997-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(848,'holiday_424',21,1,0,1,0,'1997-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(849,'holiday_425',21,2,1,1,0,'1998-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(850,'holiday_425',21,1,0,1,0,'1998-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(851,'holiday_426',21,2,1,1,0,'1999-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(852,'holiday_426',21,1,0,1,0,'1999-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(853,'holiday_427',21,2,1,1,0,'2000-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(854,'holiday_427',21,1,0,1,0,'2000-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(855,'holiday_428',21,2,1,1,0,'2001-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(856,'holiday_428',21,1,0,1,0,'2001-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(857,'holiday_429',21,2,1,1,0,'2002-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(858,'holiday_429',21,1,0,1,0,'2002-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(859,'holiday_430',21,2,1,1,0,'2002-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(860,'holiday_430',21,1,0,1,0,'2002-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(861,'holiday_431',21,2,1,1,0,'2003-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(862,'holiday_431',21,1,0,1,0,'2003-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(863,'holiday_432',21,2,1,1,0,'2004-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(864,'holiday_432',21,1,0,1,0,'2004-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(865,'holiday_433',21,2,1,1,0,'2005-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(866,'holiday_433',21,1,0,1,0,'2005-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(867,'holiday_434',21,2,1,1,0,'2006-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(868,'holiday_434',21,1,0,1,0,'2006-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(869,'holiday_435',21,2,1,1,0,'2007-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(870,'holiday_435',21,1,0,1,0,'2007-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(871,'holiday_436',21,2,1,1,0,'2008-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(872,'holiday_436',21,1,0,1,0,'2008-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(873,'holiday_437',21,2,1,1,0,'2009-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(874,'holiday_437',21,1,0,1,0,'2009-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(875,'holiday_438',21,2,1,1,0,'2010-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(876,'holiday_438',21,1,0,1,0,'2010-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(877,'holiday_439',21,2,1,1,0,'2011-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(878,'holiday_439',21,1,0,1,0,'2011-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(879,'holiday_440',21,2,1,1,0,'2012-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(880,'holiday_440',21,1,0,1,0,'2012-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(881,'holiday_441',21,2,1,1,0,'2013-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(882,'holiday_441',21,1,0,1,0,'2013-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(883,'holiday_442',21,2,1,1,0,'2013-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(884,'holiday_442',21,1,0,1,0,'2013-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(885,'holiday_443',21,2,1,1,0,'2014-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(886,'holiday_443',21,1,0,1,0,'2014-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(887,'holiday_444',21,2,1,1,0,'2015-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(888,'holiday_444',21,1,0,1,0,'2015-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(889,'holiday_445',21,2,1,1,0,'2016-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(890,'holiday_445',21,1,0,1,0,'2016-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(891,'holiday_446',21,2,1,1,0,'2017-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(892,'holiday_446',21,1,0,1,0,'2017-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(893,'holiday_447',21,2,1,1,0,'2018-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(894,'holiday_447',21,1,0,1,0,'2018-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(895,'holiday_448',21,2,1,1,0,'2019-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(896,'holiday_448',21,1,0,1,0,'2019-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(897,'holiday_449',21,2,1,1,0,'2019-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(898,'holiday_449',21,1,0,1,0,'2019-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(899,'holiday_450',21,2,1,1,0,'2020-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(900,'holiday_450',21,1,0,1,0,'2020-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(901,'holiday_451',21,2,1,1,0,'2021-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(902,'holiday_451',21,1,0,1,0,'2021-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(903,'holiday_452',21,2,1,1,0,'2022-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(904,'holiday_452',21,1,0,1,0,'2022-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(905,'holiday_453',21,2,1,1,0,'2023-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(906,'holiday_453',21,1,0,1,0,'2023-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(907,'holiday_454',21,2,1,1,0,'2024-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(908,'holiday_454',21,1,0,1,0,'2024-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(909,'holiday_455',21,2,1,1,0,'2024-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(910,'holiday_455',21,1,0,1,0,'2024-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(911,'holiday_456',21,2,1,1,0,'2025-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(912,'holiday_456',21,1,0,1,0,'2025-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(913,'holiday_457',21,2,1,1,0,'2026-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(914,'holiday_457',21,1,0,1,0,'2026-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(915,'holiday_458',21,2,1,1,0,'2027-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(916,'holiday_458',21,1,0,1,0,'2027-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(917,'holiday_459',21,2,1,1,0,'2028-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(918,'holiday_459',21,1,0,1,0,'2028-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(919,'holiday_460',21,2,1,1,0,'2029-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(920,'holiday_460',21,1,0,1,0,'2029-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(921,'holiday_461',21,2,1,1,0,'2030-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(922,'holiday_461',21,1,0,1,0,'2030-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(923,'holiday_462',21,2,1,1,0,'2030-05-06','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(924,'holiday_462',21,1,0,1,0,'2030-05-06','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(925,'holiday_463',21,2,1,1,0,'2031-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(926,'holiday_463',21,1,0,1,0,'2031-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(927,'holiday_464',21,2,1,1,0,'2032-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(928,'holiday_464',21,1,0,1,0,'2032-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(929,'holiday_465',21,2,1,1,0,'2033-05-05','こどもの日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(930,'holiday_465',21,1,0,1,0,'2033-05-05','Children\'s Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(931,'holiday_466',22,2,1,1,0,'1970-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(932,'holiday_466',22,1,0,1,0,'1970-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(933,'holiday_467',22,2,1,1,0,'1971-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(934,'holiday_467',22,1,0,1,0,'1971-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(935,'holiday_468',22,2,1,1,0,'1972-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(936,'holiday_468',22,1,0,1,0,'1972-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(937,'holiday_469',22,2,1,1,0,'1973-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(938,'holiday_469',22,1,0,1,0,'1973-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(939,'holiday_470',23,2,1,1,0,'1974-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(940,'holiday_470',23,1,0,1,0,'1974-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(941,'holiday_471',23,2,1,1,0,'1974-09-16','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(942,'holiday_471',23,1,0,1,0,'1974-09-16','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(943,'holiday_472',23,2,1,1,0,'1975-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(944,'holiday_472',23,1,0,1,0,'1975-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(945,'holiday_473',23,2,1,1,0,'1976-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(946,'holiday_473',23,1,0,1,0,'1976-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(947,'holiday_474',23,2,1,1,0,'1977-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(948,'holiday_474',23,1,0,1,0,'1977-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(949,'holiday_475',23,2,1,1,0,'1978-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(950,'holiday_475',23,1,0,1,0,'1978-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(951,'holiday_476',23,2,1,1,0,'1979-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(952,'holiday_476',23,1,0,1,0,'1979-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(953,'holiday_477',23,2,1,1,0,'1980-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(954,'holiday_477',23,1,0,1,0,'1980-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(955,'holiday_478',23,2,1,1,0,'1981-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(956,'holiday_478',23,1,0,1,0,'1981-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(957,'holiday_479',23,2,1,1,0,'1982-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(958,'holiday_479',23,1,0,1,0,'1982-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(959,'holiday_480',23,2,1,1,0,'1983-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(960,'holiday_480',23,1,0,1,0,'1983-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(961,'holiday_481',23,2,1,1,0,'1984-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(962,'holiday_481',23,1,0,1,0,'1984-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(963,'holiday_482',23,2,1,1,0,'1985-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(964,'holiday_482',23,1,0,1,0,'1985-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(965,'holiday_483',23,2,1,1,0,'1985-09-16','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(966,'holiday_483',23,1,0,1,0,'1985-09-16','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(967,'holiday_484',23,2,1,1,0,'1986-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(968,'holiday_484',23,1,0,1,0,'1986-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(969,'holiday_485',23,2,1,1,0,'1987-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(970,'holiday_485',23,1,0,1,0,'1987-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(971,'holiday_486',23,2,1,1,0,'1988-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(972,'holiday_486',23,1,0,1,0,'1988-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(973,'holiday_487',23,2,1,1,0,'1989-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(974,'holiday_487',23,1,0,1,0,'1989-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(975,'holiday_488',23,2,1,1,0,'1990-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(976,'holiday_488',23,1,0,1,0,'1990-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(977,'holiday_489',23,2,1,1,0,'1991-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(978,'holiday_489',23,1,0,1,0,'1991-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(979,'holiday_490',23,2,1,1,0,'1991-09-16','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(980,'holiday_490',23,1,0,1,0,'1991-09-16','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(981,'holiday_491',23,2,1,1,0,'1992-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(982,'holiday_491',23,1,0,1,0,'1992-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(983,'holiday_492',23,2,1,1,0,'1993-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(984,'holiday_492',23,1,0,1,0,'1993-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(985,'holiday_493',23,2,1,1,0,'1994-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(986,'holiday_493',23,1,0,1,0,'1994-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(987,'holiday_494',23,2,1,1,0,'1995-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(988,'holiday_494',23,1,0,1,0,'1995-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(989,'holiday_495',23,2,1,1,0,'1996-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(990,'holiday_495',23,1,0,1,0,'1996-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(991,'holiday_496',23,2,1,1,0,'1996-09-16','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(992,'holiday_496',23,1,0,1,0,'1996-09-16','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(993,'holiday_497',23,2,1,1,0,'1997-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(994,'holiday_497',23,1,0,1,0,'1997-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(995,'holiday_498',23,2,1,1,0,'1998-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(996,'holiday_498',23,1,0,1,0,'1998-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(997,'holiday_499',23,2,1,1,0,'1999-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(998,'holiday_499',23,1,0,1,0,'1999-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(999,'holiday_500',23,2,1,1,0,'2000-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1000,'holiday_500',23,1,0,1,0,'2000-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1001,'holiday_501',23,2,1,1,0,'2001-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1002,'holiday_501',23,1,0,1,0,'2001-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1003,'holiday_502',23,2,1,1,0,'2002-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1004,'holiday_502',23,1,0,1,0,'2002-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1005,'holiday_503',23,2,1,1,0,'2002-09-16','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1006,'holiday_503',23,1,0,1,0,'2002-09-16','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1007,'holiday_504',24,2,1,1,0,'2003-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1008,'holiday_504',24,1,0,1,0,'2003-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1009,'holiday_505',24,2,1,1,0,'2004-09-20','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1010,'holiday_505',24,1,0,1,0,'2004-09-20','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1011,'holiday_506',24,2,1,1,0,'2005-09-19','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1012,'holiday_506',24,1,0,1,0,'2005-09-19','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1013,'holiday_507',24,2,1,1,0,'2006-09-18','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1014,'holiday_507',24,1,0,1,0,'2006-09-18','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1015,'holiday_508',24,2,1,1,0,'2007-09-17','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1016,'holiday_508',24,1,0,1,0,'2007-09-17','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1017,'holiday_509',24,2,1,1,0,'2008-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1018,'holiday_509',24,1,0,1,0,'2008-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1019,'holiday_510',24,2,1,1,0,'2009-09-21','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1020,'holiday_510',24,1,0,1,0,'2009-09-21','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1021,'holiday_511',24,2,1,1,0,'2010-09-20','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1022,'holiday_511',24,1,0,1,0,'2010-09-20','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1023,'holiday_512',24,2,1,1,0,'2011-09-19','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1024,'holiday_512',24,1,0,1,0,'2011-09-19','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1025,'holiday_513',24,2,1,1,0,'2012-09-17','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1026,'holiday_513',24,1,0,1,0,'2012-09-17','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1027,'holiday_514',24,2,1,1,0,'2013-09-16','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1028,'holiday_514',24,1,0,1,0,'2013-09-16','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1029,'holiday_515',24,2,1,1,0,'2014-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1030,'holiday_515',24,1,0,1,0,'2014-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1031,'holiday_516',24,2,1,1,0,'2015-09-21','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1032,'holiday_516',24,1,0,1,0,'2015-09-21','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1033,'holiday_517',24,2,1,1,0,'2016-09-19','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1034,'holiday_517',24,1,0,1,0,'2016-09-19','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1035,'holiday_518',24,2,1,1,0,'2017-09-18','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1036,'holiday_518',24,1,0,1,0,'2017-09-18','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1037,'holiday_519',24,2,1,1,0,'2018-09-17','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1038,'holiday_519',24,1,0,1,0,'2018-09-17','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1039,'holiday_520',24,2,1,1,0,'2019-09-16','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1040,'holiday_520',24,1,0,1,0,'2019-09-16','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1041,'holiday_521',24,2,1,1,0,'2020-09-21','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1042,'holiday_521',24,1,0,1,0,'2020-09-21','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1043,'holiday_522',24,2,1,1,0,'2021-09-20','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1044,'holiday_522',24,1,0,1,0,'2021-09-20','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1045,'holiday_523',24,2,1,1,0,'2022-09-19','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1046,'holiday_523',24,1,0,1,0,'2022-09-19','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1047,'holiday_524',24,2,1,1,0,'2023-09-18','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1048,'holiday_524',24,1,0,1,0,'2023-09-18','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1049,'holiday_525',24,2,1,1,0,'2024-09-16','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1050,'holiday_525',24,1,0,1,0,'2024-09-16','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1051,'holiday_526',24,2,1,1,0,'2025-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1052,'holiday_526',24,1,0,1,0,'2025-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1053,'holiday_527',24,2,1,1,0,'2026-09-21','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1054,'holiday_527',24,1,0,1,0,'2026-09-21','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1055,'holiday_528',24,2,1,1,0,'2027-09-20','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1056,'holiday_528',24,1,0,1,0,'2027-09-20','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1057,'holiday_529',24,2,1,1,0,'2028-09-18','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1058,'holiday_529',24,1,0,1,0,'2028-09-18','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1059,'holiday_530',24,2,1,1,0,'2029-09-17','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1060,'holiday_530',24,1,0,1,0,'2029-09-17','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1061,'holiday_531',24,2,1,1,0,'2030-09-16','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1062,'holiday_531',24,1,0,1,0,'2030-09-16','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1063,'holiday_532',24,2,1,1,0,'2031-09-15','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1064,'holiday_532',24,1,0,1,0,'2031-09-15','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1065,'holiday_533',24,2,1,1,0,'2032-09-20','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1066,'holiday_533',24,1,0,1,0,'2032-09-20','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1067,'holiday_534',24,2,1,1,0,'2033-09-19','敬老の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1068,'holiday_534',24,1,0,1,0,'2033-09-19','Respect-for-the-Aged Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1069,'holiday_535',25,2,1,1,0,'1970-09-23','秋分の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1070,'holiday_535',25,1,0,1,0,'1970-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1071,'holiday_536',26,2,1,1,0,'1971-09-24','秋分の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1072,'holiday_536',26,1,0,1,0,'1971-09-24','Autumnal Equinox Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1073,'holiday_537',27,2,1,1,0,'1972-09-23','秋分の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1074,'holiday_537',27,1,0,1,0,'1972-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1075,'holiday_538',28,2,1,1,0,'1973-09-23','秋分の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1076,'holiday_538',28,1,0,1,0,'1973-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1077,'holiday_539',29,2,1,1,0,'1970-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1078,'holiday_539',29,1,0,1,0,'1970-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1079,'holiday_540',29,2,1,1,0,'1971-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1080,'holiday_540',29,1,0,1,0,'1971-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1081,'holiday_541',29,2,1,1,0,'1972-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1082,'holiday_541',29,1,0,1,0,'1972-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1083,'holiday_542',29,2,1,1,0,'1973-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1084,'holiday_542',29,1,0,1,0,'1973-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1085,'holiday_543',30,2,1,1,0,'1974-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1086,'holiday_543',30,1,0,1,0,'1974-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1087,'holiday_544',30,2,1,1,0,'1975-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1088,'holiday_544',30,1,0,1,0,'1975-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1089,'holiday_545',30,2,1,1,0,'1976-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1090,'holiday_545',30,1,0,1,0,'1976-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1091,'holiday_546',30,2,1,1,0,'1976-10-11','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1092,'holiday_546',30,1,0,1,0,'1976-10-11','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1093,'holiday_547',30,2,1,1,0,'1977-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1094,'holiday_547',30,1,0,1,0,'1977-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1095,'holiday_548',30,2,1,1,0,'1978-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1096,'holiday_548',30,1,0,1,0,'1978-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1097,'holiday_549',30,2,1,1,0,'1979-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1098,'holiday_549',30,1,0,1,0,'1979-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1099,'holiday_550',30,2,1,1,0,'1980-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1100,'holiday_550',30,1,0,1,0,'1980-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1101,'holiday_551',30,2,1,1,0,'1981-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1102,'holiday_551',30,1,0,1,0,'1981-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1103,'holiday_552',30,2,1,1,0,'1982-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1104,'holiday_552',30,1,0,1,0,'1982-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1105,'holiday_553',30,2,1,1,0,'1982-10-11','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1106,'holiday_553',30,1,0,1,0,'1982-10-11','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1107,'holiday_554',30,2,1,1,0,'1983-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1108,'holiday_554',30,1,0,1,0,'1983-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1109,'holiday_555',30,2,1,1,0,'1984-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1110,'holiday_555',30,1,0,1,0,'1984-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1111,'holiday_556',30,2,1,1,0,'1985-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1112,'holiday_556',30,1,0,1,0,'1985-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1113,'holiday_557',30,2,1,1,0,'1986-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1114,'holiday_557',30,1,0,1,0,'1986-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1115,'holiday_558',30,2,1,1,0,'1987-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1116,'holiday_558',30,1,0,1,0,'1987-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1117,'holiday_559',30,2,1,1,0,'1988-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1118,'holiday_559',30,1,0,1,0,'1988-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1119,'holiday_560',30,2,1,1,0,'1989-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1120,'holiday_560',30,1,0,1,0,'1989-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1121,'holiday_561',30,2,1,1,0,'1990-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1122,'holiday_561',30,1,0,1,0,'1990-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1123,'holiday_562',30,2,1,1,0,'1991-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1124,'holiday_562',30,1,0,1,0,'1991-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1125,'holiday_563',30,2,1,1,0,'1992-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1126,'holiday_563',30,1,0,1,0,'1992-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1127,'holiday_564',30,2,1,1,0,'1993-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1128,'holiday_564',30,1,0,1,0,'1993-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1129,'holiday_565',30,2,1,1,0,'1993-10-11','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1130,'holiday_565',30,1,0,1,0,'1993-10-11','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1131,'holiday_566',30,2,1,1,0,'1994-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1132,'holiday_566',30,1,0,1,0,'1994-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1133,'holiday_567',30,2,1,1,0,'1995-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1134,'holiday_567',30,1,0,1,0,'1995-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1135,'holiday_568',30,2,1,1,0,'1996-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1136,'holiday_568',30,1,0,1,0,'1996-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1137,'holiday_569',30,2,1,1,0,'1997-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1138,'holiday_569',30,1,0,1,0,'1997-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1139,'holiday_570',30,2,1,1,0,'1998-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1140,'holiday_570',30,1,0,1,0,'1998-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1141,'holiday_571',30,2,1,1,0,'1999-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1142,'holiday_571',30,1,0,1,0,'1999-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1143,'holiday_572',30,2,1,1,0,'1999-10-11','(振替休日)',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1144,'holiday_572',30,1,0,1,0,'1999-10-11','Transfer holiday',1,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1145,'holiday_573',31,2,1,1,0,'2000-10-09','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1146,'holiday_573',31,1,0,1,0,'2000-10-09','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1147,'holiday_574',31,2,1,1,0,'2001-10-08','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1148,'holiday_574',31,1,0,1,0,'2001-10-08','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1149,'holiday_575',31,2,1,1,0,'2002-10-14','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1150,'holiday_575',31,1,0,1,0,'2002-10-14','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1151,'holiday_576',31,2,1,1,0,'2003-10-13','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1152,'holiday_576',31,1,0,1,0,'2003-10-13','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1153,'holiday_577',31,2,1,1,0,'2004-10-11','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1154,'holiday_577',31,1,0,1,0,'2004-10-11','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1155,'holiday_578',31,2,1,1,0,'2005-10-10','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1156,'holiday_578',31,1,0,1,0,'2005-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1157,'holiday_579',31,2,1,1,0,'2006-10-09','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1158,'holiday_579',31,1,0,1,0,'2006-10-09','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1159,'holiday_580',31,2,1,1,0,'2007-10-08','体育の日',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1160,'holiday_580',31,1,0,1,0,'2007-10-08','Sports Day Holiday',0,0,'2019-03-02 03:14:27',0,'2019-03-02 03:14:27'),(1161,'holiday_581',31,2,1,1,0,'2008-10-13','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1162,'holiday_581',31,1,0,1,0,'2008-10-13','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1163,'holiday_582',31,2,1,1,0,'2009-10-12','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1164,'holiday_582',31,1,0,1,0,'2009-10-12','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1165,'holiday_583',31,2,1,1,0,'2010-10-11','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1166,'holiday_583',31,1,0,1,0,'2010-10-11','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1167,'holiday_584',31,2,1,1,0,'2011-10-10','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1168,'holiday_584',31,1,0,1,0,'2011-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1169,'holiday_585',31,2,1,1,0,'2012-10-08','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1170,'holiday_585',31,1,0,1,0,'2012-10-08','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1171,'holiday_586',31,2,1,1,0,'2013-10-14','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1172,'holiday_586',31,1,0,1,0,'2013-10-14','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1173,'holiday_587',31,2,1,1,0,'2014-10-13','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1174,'holiday_587',31,1,0,1,0,'2014-10-13','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1175,'holiday_588',31,2,1,1,0,'2015-10-12','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1176,'holiday_588',31,1,0,1,0,'2015-10-12','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1177,'holiday_589',31,2,1,1,0,'2016-10-10','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1178,'holiday_589',31,1,0,1,0,'2016-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1179,'holiday_590',31,2,1,1,0,'2017-10-09','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1180,'holiday_590',31,1,0,1,0,'2017-10-09','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1181,'holiday_591',31,2,1,1,0,'2018-10-08','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1182,'holiday_591',31,1,0,1,0,'2018-10-08','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1183,'holiday_592',31,2,1,1,0,'2019-10-14','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1184,'holiday_592',31,1,0,1,0,'2019-10-14','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1185,'holiday_593',31,2,1,1,0,'2020-10-12','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1186,'holiday_593',31,1,0,1,0,'2020-10-12','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1187,'holiday_594',31,2,1,1,0,'2021-10-11','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1188,'holiday_594',31,1,0,1,0,'2021-10-11','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1189,'holiday_595',31,2,1,1,0,'2022-10-10','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1190,'holiday_595',31,1,0,1,0,'2022-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1191,'holiday_596',31,2,1,1,0,'2023-10-09','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1192,'holiday_596',31,1,0,1,0,'2023-10-09','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1193,'holiday_597',31,2,1,1,0,'2024-10-14','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1194,'holiday_597',31,1,0,1,0,'2024-10-14','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1195,'holiday_598',31,2,1,1,0,'2025-10-13','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1196,'holiday_598',31,1,0,1,0,'2025-10-13','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1197,'holiday_599',31,2,1,1,0,'2026-10-12','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1198,'holiday_599',31,1,0,1,0,'2026-10-12','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1199,'holiday_600',31,2,1,1,0,'2027-10-11','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1200,'holiday_600',31,1,0,1,0,'2027-10-11','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1201,'holiday_601',31,2,1,1,0,'2028-10-09','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1202,'holiday_601',31,1,0,1,0,'2028-10-09','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1203,'holiday_602',31,2,1,1,0,'2029-10-08','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1204,'holiday_602',31,1,0,1,0,'2029-10-08','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1205,'holiday_603',31,2,1,1,0,'2030-10-14','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1206,'holiday_603',31,1,0,1,0,'2030-10-14','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1207,'holiday_604',31,2,1,1,0,'2031-10-13','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1208,'holiday_604',31,1,0,1,0,'2031-10-13','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1209,'holiday_605',31,2,1,1,0,'2032-10-11','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1210,'holiday_605',31,1,0,1,0,'2032-10-11','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1211,'holiday_606',31,2,1,1,0,'2033-10-10','体育の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1212,'holiday_606',31,1,0,1,0,'2033-10-10','Sports Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1213,'holiday_607',32,2,1,1,0,'1970-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1214,'holiday_607',32,1,0,1,0,'1970-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1215,'holiday_608',32,2,1,1,0,'1971-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1216,'holiday_608',32,1,0,1,0,'1971-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1217,'holiday_609',32,2,1,1,0,'1972-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1218,'holiday_609',32,1,0,1,0,'1972-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1219,'holiday_610',32,2,1,1,0,'1973-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1220,'holiday_610',32,1,0,1,0,'1973-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1221,'holiday_611',33,2,1,1,0,'1974-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1222,'holiday_611',33,1,0,1,0,'1974-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1223,'holiday_612',33,2,1,1,0,'1974-11-04','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1224,'holiday_612',33,1,0,1,0,'1974-11-04','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1225,'holiday_613',33,2,1,1,0,'1975-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1226,'holiday_613',33,1,0,1,0,'1975-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1227,'holiday_614',33,2,1,1,0,'1976-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1228,'holiday_614',33,1,0,1,0,'1976-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1229,'holiday_615',33,2,1,1,0,'1977-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1230,'holiday_615',33,1,0,1,0,'1977-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1231,'holiday_616',33,2,1,1,0,'1978-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1232,'holiday_616',33,1,0,1,0,'1978-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1233,'holiday_617',33,2,1,1,0,'1979-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1234,'holiday_617',33,1,0,1,0,'1979-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1235,'holiday_618',33,2,1,1,0,'1980-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1236,'holiday_618',33,1,0,1,0,'1980-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1237,'holiday_619',33,2,1,1,0,'1981-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1238,'holiday_619',33,1,0,1,0,'1981-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1239,'holiday_620',33,2,1,1,0,'1982-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1240,'holiday_620',33,1,0,1,0,'1982-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1241,'holiday_621',33,2,1,1,0,'1983-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1242,'holiday_621',33,1,0,1,0,'1983-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1243,'holiday_622',33,2,1,1,0,'1984-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1244,'holiday_622',33,1,0,1,0,'1984-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1245,'holiday_623',33,2,1,1,0,'1985-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1246,'holiday_623',33,1,0,1,0,'1985-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1247,'holiday_624',33,2,1,1,0,'1985-11-04','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1248,'holiday_624',33,1,0,1,0,'1985-11-04','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1249,'holiday_625',33,2,1,1,0,'1986-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1250,'holiday_625',33,1,0,1,0,'1986-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1251,'holiday_626',33,2,1,1,0,'1987-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1252,'holiday_626',33,1,0,1,0,'1987-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1253,'holiday_627',33,2,1,1,0,'1988-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1254,'holiday_627',33,1,0,1,0,'1988-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1255,'holiday_628',33,2,1,1,0,'1989-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1256,'holiday_628',33,1,0,1,0,'1989-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1257,'holiday_629',33,2,1,1,0,'1990-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1258,'holiday_629',33,1,0,1,0,'1990-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1259,'holiday_630',33,2,1,1,0,'1991-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1260,'holiday_630',33,1,0,1,0,'1991-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1261,'holiday_631',33,2,1,1,0,'1991-11-04','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1262,'holiday_631',33,1,0,1,0,'1991-11-04','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1263,'holiday_632',33,2,1,1,0,'1992-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1264,'holiday_632',33,1,0,1,0,'1992-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1265,'holiday_633',33,2,1,1,0,'1993-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1266,'holiday_633',33,1,0,1,0,'1993-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1267,'holiday_634',33,2,1,1,0,'1994-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1268,'holiday_634',33,1,0,1,0,'1994-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1269,'holiday_635',33,2,1,1,0,'1995-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1270,'holiday_635',33,1,0,1,0,'1995-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1271,'holiday_636',33,2,1,1,0,'1996-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1272,'holiday_636',33,1,0,1,0,'1996-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1273,'holiday_637',33,2,1,1,0,'1996-11-04','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1274,'holiday_637',33,1,0,1,0,'1996-11-04','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1275,'holiday_638',33,2,1,1,0,'1997-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1276,'holiday_638',33,1,0,1,0,'1997-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1277,'holiday_639',33,2,1,1,0,'1998-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1278,'holiday_639',33,1,0,1,0,'1998-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1279,'holiday_640',33,2,1,1,0,'1999-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1280,'holiday_640',33,1,0,1,0,'1999-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1281,'holiday_641',33,2,1,1,0,'2000-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1282,'holiday_641',33,1,0,1,0,'2000-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1283,'holiday_642',33,2,1,1,0,'2001-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1284,'holiday_642',33,1,0,1,0,'2001-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1285,'holiday_643',33,2,1,1,0,'2002-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1286,'holiday_643',33,1,0,1,0,'2002-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1287,'holiday_644',33,2,1,1,0,'2002-11-04','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1288,'holiday_644',33,1,0,1,0,'2002-11-04','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1289,'holiday_645',33,2,1,1,0,'2003-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1290,'holiday_645',33,1,0,1,0,'2003-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1291,'holiday_646',33,2,1,1,0,'2004-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1292,'holiday_646',33,1,0,1,0,'2004-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1293,'holiday_647',33,2,1,1,0,'2005-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1294,'holiday_647',33,1,0,1,0,'2005-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1295,'holiday_648',33,2,1,1,0,'2006-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1296,'holiday_648',33,1,0,1,0,'2006-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1297,'holiday_649',33,2,1,1,0,'2007-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1298,'holiday_649',33,1,0,1,0,'2007-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1299,'holiday_650',33,2,1,1,0,'2008-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1300,'holiday_650',33,1,0,1,0,'2008-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1301,'holiday_651',33,2,1,1,0,'2009-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1302,'holiday_651',33,1,0,1,0,'2009-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1303,'holiday_652',33,2,1,1,0,'2010-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1304,'holiday_652',33,1,0,1,0,'2010-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1305,'holiday_653',33,2,1,1,0,'2011-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1306,'holiday_653',33,1,0,1,0,'2011-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1307,'holiday_654',33,2,1,1,0,'2012-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1308,'holiday_654',33,1,0,1,0,'2012-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1309,'holiday_655',33,2,1,1,0,'2013-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1310,'holiday_655',33,1,0,1,0,'2013-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1311,'holiday_656',33,2,1,1,0,'2013-11-04','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1312,'holiday_656',33,1,0,1,0,'2013-11-04','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1313,'holiday_657',33,2,1,1,0,'2014-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1314,'holiday_657',33,1,0,1,0,'2014-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1315,'holiday_658',33,2,1,1,0,'2015-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1316,'holiday_658',33,1,0,1,0,'2015-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1317,'holiday_659',33,2,1,1,0,'2016-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1318,'holiday_659',33,1,0,1,0,'2016-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1319,'holiday_660',33,2,1,1,0,'2017-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1320,'holiday_660',33,1,0,1,0,'2017-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1321,'holiday_661',33,2,1,1,0,'2018-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1322,'holiday_661',33,1,0,1,0,'2018-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1323,'holiday_662',33,2,1,1,0,'2019-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1324,'holiday_662',33,1,0,1,0,'2019-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1325,'holiday_663',33,2,1,1,0,'2019-11-04','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1326,'holiday_663',33,1,0,1,0,'2019-11-04','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1327,'holiday_664',33,2,1,1,0,'2020-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1328,'holiday_664',33,1,0,1,0,'2020-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1329,'holiday_665',33,2,1,1,0,'2021-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1330,'holiday_665',33,1,0,1,0,'2021-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1331,'holiday_666',33,2,1,1,0,'2022-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1332,'holiday_666',33,1,0,1,0,'2022-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1333,'holiday_667',33,2,1,1,0,'2023-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1334,'holiday_667',33,1,0,1,0,'2023-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1335,'holiday_668',33,2,1,1,0,'2024-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1336,'holiday_668',33,1,0,1,0,'2024-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1337,'holiday_669',33,2,1,1,0,'2024-11-04','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1338,'holiday_669',33,1,0,1,0,'2024-11-04','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1339,'holiday_670',33,2,1,1,0,'2025-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1340,'holiday_670',33,1,0,1,0,'2025-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1341,'holiday_671',33,2,1,1,0,'2026-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1342,'holiday_671',33,1,0,1,0,'2026-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1343,'holiday_672',33,2,1,1,0,'2027-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1344,'holiday_672',33,1,0,1,0,'2027-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1345,'holiday_673',33,2,1,1,0,'2028-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1346,'holiday_673',33,1,0,1,0,'2028-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1347,'holiday_674',33,2,1,1,0,'2029-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1348,'holiday_674',33,1,0,1,0,'2029-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1349,'holiday_675',33,2,1,1,0,'2030-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1350,'holiday_675',33,1,0,1,0,'2030-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1351,'holiday_676',33,2,1,1,0,'2030-11-04','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1352,'holiday_676',33,1,0,1,0,'2030-11-04','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1353,'holiday_677',33,2,1,1,0,'2031-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1354,'holiday_677',33,1,0,1,0,'2031-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1355,'holiday_678',33,2,1,1,0,'2032-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1356,'holiday_678',33,1,0,1,0,'2032-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1357,'holiday_679',33,2,1,1,0,'2033-11-03','文化の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1358,'holiday_679',33,1,0,1,0,'2033-11-03','Culture Day Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1359,'holiday_680',34,2,1,1,0,'1970-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1360,'holiday_680',34,1,0,1,0,'1970-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1361,'holiday_681',34,2,1,1,0,'1971-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1362,'holiday_681',34,1,0,1,0,'1971-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1363,'holiday_682',34,2,1,1,0,'1972-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1364,'holiday_682',34,1,0,1,0,'1972-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1365,'holiday_683',34,2,1,1,0,'1973-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1366,'holiday_683',34,1,0,1,0,'1973-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1367,'holiday_684',35,2,1,1,0,'1974-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1368,'holiday_684',35,1,0,1,0,'1974-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1369,'holiday_685',35,2,1,1,0,'1975-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1370,'holiday_685',35,1,0,1,0,'1975-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1371,'holiday_686',35,2,1,1,0,'1975-11-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1372,'holiday_686',35,1,0,1,0,'1975-11-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1373,'holiday_687',35,2,1,1,0,'1976-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1374,'holiday_687',35,1,0,1,0,'1976-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1375,'holiday_688',35,2,1,1,0,'1977-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1376,'holiday_688',35,1,0,1,0,'1977-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1377,'holiday_689',35,2,1,1,0,'1978-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1378,'holiday_689',35,1,0,1,0,'1978-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1379,'holiday_690',35,2,1,1,0,'1979-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1380,'holiday_690',35,1,0,1,0,'1979-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1381,'holiday_691',35,2,1,1,0,'1980-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1382,'holiday_691',35,1,0,1,0,'1980-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1383,'holiday_692',35,2,1,1,0,'1980-11-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1384,'holiday_692',35,1,0,1,0,'1980-11-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1385,'holiday_693',35,2,1,1,0,'1981-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1386,'holiday_693',35,1,0,1,0,'1981-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1387,'holiday_694',35,2,1,1,0,'1982-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1388,'holiday_694',35,1,0,1,0,'1982-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1389,'holiday_695',35,2,1,1,0,'1983-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1390,'holiday_695',35,1,0,1,0,'1983-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1391,'holiday_696',35,2,1,1,0,'1984-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1392,'holiday_696',35,1,0,1,0,'1984-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1393,'holiday_697',35,2,1,1,0,'1985-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1394,'holiday_697',35,1,0,1,0,'1985-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1395,'holiday_698',35,2,1,1,0,'1986-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1396,'holiday_698',35,1,0,1,0,'1986-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1397,'holiday_699',35,2,1,1,0,'1986-11-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1398,'holiday_699',35,1,0,1,0,'1986-11-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1399,'holiday_700',35,2,1,1,0,'1987-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1400,'holiday_700',35,1,0,1,0,'1987-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1401,'holiday_701',35,2,1,1,0,'1988-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1402,'holiday_701',35,1,0,1,0,'1988-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1403,'holiday_702',35,2,1,1,0,'1989-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1404,'holiday_702',35,1,0,1,0,'1989-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1405,'holiday_703',35,2,1,1,0,'1990-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1406,'holiday_703',35,1,0,1,0,'1990-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1407,'holiday_704',35,2,1,1,0,'1991-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1408,'holiday_704',35,1,0,1,0,'1991-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1409,'holiday_705',35,2,1,1,0,'1992-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1410,'holiday_705',35,1,0,1,0,'1992-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1411,'holiday_706',35,2,1,1,0,'1993-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1412,'holiday_706',35,1,0,1,0,'1993-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1413,'holiday_707',35,2,1,1,0,'1994-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1414,'holiday_707',35,1,0,1,0,'1994-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1415,'holiday_708',35,2,1,1,0,'1995-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1416,'holiday_708',35,1,0,1,0,'1995-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1417,'holiday_709',35,2,1,1,0,'1996-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1418,'holiday_709',35,1,0,1,0,'1996-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1419,'holiday_710',35,2,1,1,0,'1997-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1420,'holiday_710',35,1,0,1,0,'1997-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1421,'holiday_711',35,2,1,1,0,'1997-11-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1422,'holiday_711',35,1,0,1,0,'1997-11-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1423,'holiday_712',35,2,1,1,0,'1998-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1424,'holiday_712',35,1,0,1,0,'1998-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1425,'holiday_713',35,2,1,1,0,'1999-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1426,'holiday_713',35,1,0,1,0,'1999-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1427,'holiday_714',35,2,1,1,0,'2000-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1428,'holiday_714',35,1,0,1,0,'2000-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1429,'holiday_715',35,2,1,1,0,'2001-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1430,'holiday_715',35,1,0,1,0,'2001-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1431,'holiday_716',35,2,1,1,0,'2002-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1432,'holiday_716',35,1,0,1,0,'2002-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1433,'holiday_717',35,2,1,1,0,'2003-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1434,'holiday_717',35,1,0,1,0,'2003-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1435,'holiday_718',35,2,1,1,0,'2003-11-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1436,'holiday_718',35,1,0,1,0,'2003-11-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1437,'holiday_719',35,2,1,1,0,'2004-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1438,'holiday_719',35,1,0,1,0,'2004-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1439,'holiday_720',35,2,1,1,0,'2005-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1440,'holiday_720',35,1,0,1,0,'2005-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1441,'holiday_721',35,2,1,1,0,'2006-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1442,'holiday_721',35,1,0,1,0,'2006-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1443,'holiday_722',35,2,1,1,0,'2007-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1444,'holiday_722',35,1,0,1,0,'2007-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1445,'holiday_723',35,2,1,1,0,'2008-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1446,'holiday_723',35,1,0,1,0,'2008-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1447,'holiday_724',35,2,1,1,0,'2008-11-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1448,'holiday_724',35,1,0,1,0,'2008-11-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1449,'holiday_725',35,2,1,1,0,'2009-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1450,'holiday_725',35,1,0,1,0,'2009-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1451,'holiday_726',35,2,1,1,0,'2010-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1452,'holiday_726',35,1,0,1,0,'2010-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1453,'holiday_727',35,2,1,1,0,'2011-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1454,'holiday_727',35,1,0,1,0,'2011-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1455,'holiday_728',35,2,1,1,0,'2012-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1456,'holiday_728',35,1,0,1,0,'2012-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1457,'holiday_729',35,2,1,1,0,'2013-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1458,'holiday_729',35,1,0,1,0,'2013-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1459,'holiday_730',35,2,1,1,0,'2014-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1460,'holiday_730',35,1,0,1,0,'2014-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1461,'holiday_731',35,2,1,1,0,'2014-11-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1462,'holiday_731',35,1,0,1,0,'2014-11-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1463,'holiday_732',35,2,1,1,0,'2015-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1464,'holiday_732',35,1,0,1,0,'2015-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1465,'holiday_733',35,2,1,1,0,'2016-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1466,'holiday_733',35,1,0,1,0,'2016-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1467,'holiday_734',35,2,1,1,0,'2017-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1468,'holiday_734',35,1,0,1,0,'2017-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1469,'holiday_735',35,2,1,1,0,'2018-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1470,'holiday_735',35,1,0,1,0,'2018-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1471,'holiday_736',35,2,1,1,0,'2019-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1472,'holiday_736',35,1,0,1,0,'2019-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1473,'holiday_737',35,2,1,1,0,'2020-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1474,'holiday_737',35,1,0,1,0,'2020-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1475,'holiday_738',35,2,1,1,0,'2021-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1476,'holiday_738',35,1,0,1,0,'2021-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1477,'holiday_739',35,2,1,1,0,'2022-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1478,'holiday_739',35,1,0,1,0,'2022-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1479,'holiday_740',35,2,1,1,0,'2023-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1480,'holiday_740',35,1,0,1,0,'2023-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1481,'holiday_741',35,2,1,1,0,'2024-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1482,'holiday_741',35,1,0,1,0,'2024-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1483,'holiday_742',35,2,1,1,0,'2025-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1484,'holiday_742',35,1,0,1,0,'2025-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1485,'holiday_743',35,2,1,1,0,'2025-11-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1486,'holiday_743',35,1,0,1,0,'2025-11-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1487,'holiday_744',35,2,1,1,0,'2026-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1488,'holiday_744',35,1,0,1,0,'2026-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1489,'holiday_745',35,2,1,1,0,'2027-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1490,'holiday_745',35,1,0,1,0,'2027-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1491,'holiday_746',35,2,1,1,0,'2028-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1492,'holiday_746',35,1,0,1,0,'2028-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1493,'holiday_747',35,2,1,1,0,'2029-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1494,'holiday_747',35,1,0,1,0,'2029-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1495,'holiday_748',35,2,1,1,0,'2030-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1496,'holiday_748',35,1,0,1,0,'2030-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1497,'holiday_749',35,2,1,1,0,'2031-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1498,'holiday_749',35,1,0,1,0,'2031-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1499,'holiday_750',35,2,1,1,0,'2031-11-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1500,'holiday_750',35,1,0,1,0,'2031-11-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1501,'holiday_751',35,2,1,1,0,'2032-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1502,'holiday_751',35,1,0,1,0,'2032-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1503,'holiday_752',35,2,1,1,0,'2033-11-23','勤労感謝の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1504,'holiday_752',35,1,0,1,0,'2033-11-23','Labor Thanksgiving Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1505,'holiday_753',36,2,1,1,0,'1989-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1506,'holiday_753',36,1,0,1,0,'1989-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1507,'holiday_754',36,2,1,1,0,'1990-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1508,'holiday_754',36,1,0,1,0,'1990-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1509,'holiday_755',36,2,1,1,0,'1990-12-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1510,'holiday_755',36,1,0,1,0,'1990-12-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1511,'holiday_756',36,2,1,1,0,'1991-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1512,'holiday_756',36,1,0,1,0,'1991-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1513,'holiday_757',36,2,1,1,0,'1992-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1514,'holiday_757',36,1,0,1,0,'1992-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1515,'holiday_758',36,2,1,1,0,'1993-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1516,'holiday_758',36,1,0,1,0,'1993-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1517,'holiday_759',36,2,1,1,0,'1994-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1518,'holiday_759',36,1,0,1,0,'1994-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1519,'holiday_760',36,2,1,1,0,'1995-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1520,'holiday_760',36,1,0,1,0,'1995-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1521,'holiday_761',36,2,1,1,0,'1996-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1522,'holiday_761',36,1,0,1,0,'1996-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1523,'holiday_762',36,2,1,1,0,'1997-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1524,'holiday_762',36,1,0,1,0,'1997-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1525,'holiday_763',36,2,1,1,0,'1998-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1526,'holiday_763',36,1,0,1,0,'1998-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1527,'holiday_764',36,2,1,1,0,'1999-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1528,'holiday_764',36,1,0,1,0,'1999-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1529,'holiday_765',36,2,1,1,0,'2000-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1530,'holiday_765',36,1,0,1,0,'2000-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1531,'holiday_766',36,2,1,1,0,'2001-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1532,'holiday_766',36,1,0,1,0,'2001-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1533,'holiday_767',36,2,1,1,0,'2001-12-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1534,'holiday_767',36,1,0,1,0,'2001-12-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1535,'holiday_768',36,2,1,1,0,'2002-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1536,'holiday_768',36,1,0,1,0,'2002-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1537,'holiday_769',36,2,1,1,0,'2003-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1538,'holiday_769',36,1,0,1,0,'2003-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1539,'holiday_770',36,2,1,1,0,'2004-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1540,'holiday_770',36,1,0,1,0,'2004-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1541,'holiday_771',36,2,1,1,0,'2005-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1542,'holiday_771',36,1,0,1,0,'2005-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1543,'holiday_772',36,2,1,1,0,'2006-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1544,'holiday_772',36,1,0,1,0,'2006-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1545,'holiday_773',36,2,1,1,0,'2007-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1546,'holiday_773',36,1,0,1,0,'2007-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1547,'holiday_774',36,2,1,1,0,'2007-12-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1548,'holiday_774',36,1,0,1,0,'2007-12-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1549,'holiday_775',36,2,1,1,0,'2008-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1550,'holiday_775',36,1,0,1,0,'2008-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1551,'holiday_776',36,2,1,1,0,'2009-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1552,'holiday_776',36,1,0,1,0,'2009-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1553,'holiday_777',36,2,1,1,0,'2010-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1554,'holiday_777',36,1,0,1,0,'2010-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1555,'holiday_778',36,2,1,1,0,'2011-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1556,'holiday_778',36,1,0,1,0,'2011-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1557,'holiday_779',36,2,1,1,0,'2012-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1558,'holiday_779',36,1,0,1,0,'2012-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1559,'holiday_780',36,2,1,1,0,'2012-12-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1560,'holiday_780',36,1,0,1,0,'2012-12-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1561,'holiday_781',36,2,1,1,0,'2013-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1562,'holiday_781',36,1,0,1,0,'2013-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1563,'holiday_782',36,2,1,1,0,'2014-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1564,'holiday_782',36,1,0,1,0,'2014-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1565,'holiday_783',36,2,1,1,0,'2015-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1566,'holiday_783',36,1,0,1,0,'2015-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1567,'holiday_784',36,2,1,1,0,'2016-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1568,'holiday_784',36,1,0,1,0,'2016-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1569,'holiday_785',36,2,1,1,0,'2017-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1570,'holiday_785',36,1,0,1,0,'2017-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1571,'holiday_786',36,2,1,1,0,'2018-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1572,'holiday_786',36,1,0,1,0,'2018-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1573,'holiday_787',36,2,1,1,0,'2018-12-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1574,'holiday_787',36,1,0,1,0,'2018-12-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1575,'holiday_788',36,2,1,1,0,'2019-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1576,'holiday_788',36,1,0,1,0,'2019-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1577,'holiday_789',36,2,1,1,0,'2020-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1578,'holiday_789',36,1,0,1,0,'2020-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1579,'holiday_790',36,2,1,1,0,'2021-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1580,'holiday_790',36,1,0,1,0,'2021-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1581,'holiday_791',36,2,1,1,0,'2022-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1582,'holiday_791',36,1,0,1,0,'2022-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1583,'holiday_792',36,2,1,1,0,'2023-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1584,'holiday_792',36,1,0,1,0,'2023-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1585,'holiday_793',36,2,1,1,0,'2024-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1586,'holiday_793',36,1,0,1,0,'2024-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1587,'holiday_794',36,2,1,1,0,'2025-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1588,'holiday_794',36,1,0,1,0,'2025-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1589,'holiday_795',36,2,1,1,0,'2026-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1590,'holiday_795',36,1,0,1,0,'2026-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1591,'holiday_796',36,2,1,1,0,'2027-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1592,'holiday_796',36,1,0,1,0,'2027-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1593,'holiday_797',36,2,1,1,0,'2028-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1594,'holiday_797',36,1,0,1,0,'2028-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1595,'holiday_798',36,2,1,1,0,'2029-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1596,'holiday_798',36,1,0,1,0,'2029-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1597,'holiday_799',36,2,1,1,0,'2029-12-24','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1598,'holiday_799',36,1,0,1,0,'2029-12-24','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1599,'holiday_800',36,2,1,1,0,'2030-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1600,'holiday_800',36,1,0,1,0,'2030-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1601,'holiday_801',36,2,1,1,0,'2031-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1602,'holiday_801',36,1,0,1,0,'2031-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1603,'holiday_802',36,2,1,1,0,'2032-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1604,'holiday_802',36,1,0,1,0,'2032-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1605,'holiday_803',36,2,1,1,0,'2033-12-23','天皇誕生日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1606,'holiday_803',36,1,0,1,0,'2033-12-23','Emperor\'s Birthday Holiday',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1607,'holiday_804',37,2,1,1,0,'1975-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1608,'holiday_804',37,1,0,1,0,'1975-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1609,'holiday_805',38,2,1,1,0,'1976-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1610,'holiday_805',38,1,0,1,0,'1976-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1611,'holiday_806',39,2,1,1,0,'1977-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1612,'holiday_806',39,1,0,1,0,'1977-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1613,'holiday_807',40,2,1,1,0,'1978-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1614,'holiday_807',40,1,0,1,0,'1978-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1615,'holiday_808',41,2,1,1,0,'1979-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1616,'holiday_808',41,1,0,1,0,'1979-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1617,'holiday_809',42,2,1,1,0,'1980-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1618,'holiday_809',42,1,0,1,0,'1980-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1619,'holiday_810',43,2,1,1,0,'1981-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1620,'holiday_810',43,1,0,1,0,'1981-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1621,'holiday_811',44,2,1,1,0,'1982-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1622,'holiday_811',44,1,0,1,0,'1982-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1623,'holiday_812',44,2,1,1,0,'1982-03-22','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1624,'holiday_812',44,1,0,1,0,'1982-03-22','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1625,'holiday_813',45,2,1,1,0,'1983-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1626,'holiday_813',45,1,0,1,0,'1983-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1627,'holiday_814',46,2,1,1,0,'1984-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1628,'holiday_814',46,1,0,1,0,'1984-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1629,'holiday_815',47,2,1,1,0,'1985-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1630,'holiday_815',47,1,0,1,0,'1985-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1631,'holiday_816',48,2,1,1,0,'1986-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1632,'holiday_816',48,1,0,1,0,'1986-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1633,'holiday_817',49,2,1,1,0,'1987-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1634,'holiday_817',49,1,0,1,0,'1987-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1635,'holiday_818',50,2,1,1,0,'1988-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1636,'holiday_818',50,1,0,1,0,'1988-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1637,'holiday_819',50,2,1,1,0,'1988-03-21','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1638,'holiday_819',50,1,0,1,0,'1988-03-21','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1639,'holiday_820',51,2,1,1,0,'1989-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1640,'holiday_820',51,1,0,1,0,'1989-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1641,'holiday_821',52,2,1,1,0,'1990-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1642,'holiday_821',52,1,0,1,0,'1990-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1643,'holiday_822',53,2,1,1,0,'1991-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1644,'holiday_822',53,1,0,1,0,'1991-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1645,'holiday_823',54,2,1,1,0,'1992-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1646,'holiday_823',54,1,0,1,0,'1992-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1647,'holiday_824',55,2,1,1,0,'1993-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1648,'holiday_824',55,1,0,1,0,'1993-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1649,'holiday_825',56,2,1,1,0,'1994-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1650,'holiday_825',56,1,0,1,0,'1994-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1651,'holiday_826',57,2,1,1,0,'1995-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1652,'holiday_826',57,1,0,1,0,'1995-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1653,'holiday_827',58,2,1,1,0,'1996-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1654,'holiday_827',58,1,0,1,0,'1996-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1655,'holiday_828',59,2,1,1,0,'1997-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1656,'holiday_828',59,1,0,1,0,'1997-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1657,'holiday_829',60,2,1,1,0,'1998-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1658,'holiday_829',60,1,0,1,0,'1998-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1659,'holiday_830',61,2,1,1,0,'1999-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1660,'holiday_830',61,1,0,1,0,'1999-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1661,'holiday_831',61,2,1,1,0,'1999-03-22','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1662,'holiday_831',61,1,0,1,0,'1999-03-22','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1663,'holiday_832',62,2,1,1,0,'2000-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1664,'holiday_832',62,1,0,1,0,'2000-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1665,'holiday_833',63,2,1,1,0,'2001-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1666,'holiday_833',63,1,0,1,0,'2001-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1667,'holiday_834',64,2,1,1,0,'2002-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1668,'holiday_834',64,1,0,1,0,'2002-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1669,'holiday_835',65,2,1,1,0,'2003-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1670,'holiday_835',65,1,0,1,0,'2003-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1671,'holiday_836',66,2,1,1,0,'2004-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1672,'holiday_836',66,1,0,1,0,'2004-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1673,'holiday_837',67,2,1,1,0,'2005-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1674,'holiday_837',67,1,0,1,0,'2005-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1675,'holiday_838',67,2,1,1,0,'2005-03-21','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1676,'holiday_838',67,1,0,1,0,'2005-03-21','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1677,'holiday_839',68,2,1,1,0,'2006-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1678,'holiday_839',68,1,0,1,0,'2006-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1679,'holiday_840',69,2,1,1,0,'2007-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1680,'holiday_840',69,1,0,1,0,'2007-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1681,'holiday_841',70,2,1,1,0,'2008-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1682,'holiday_841',70,1,0,1,0,'2008-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1683,'holiday_842',71,2,1,1,0,'2009-03-20','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1684,'holiday_842',71,1,0,1,0,'2009-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1685,'holiday_843',72,2,1,1,0,'2010-03-21','春分の日',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1686,'holiday_843',72,1,0,1,0,'2010-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1687,'holiday_844',72,2,1,1,0,'2010-03-22','(振替休日)',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1688,'holiday_844',72,1,0,1,0,'2010-03-22','Transfer holiday',1,0,'2019-03-02 03:14:28',0,'2019-03-02 03:14:28'),(1689,'holiday_845',73,2,1,1,0,'2011-03-21','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1690,'holiday_845',73,1,0,1,0,'2011-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1691,'holiday_846',74,2,1,1,0,'2012-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1692,'holiday_846',74,1,0,1,0,'2012-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1693,'holiday_847',75,2,1,1,0,'2013-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1694,'holiday_847',75,1,0,1,0,'2013-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1695,'holiday_848',76,2,1,1,0,'2014-03-21','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1696,'holiday_848',76,1,0,1,0,'2014-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1697,'holiday_849',77,2,1,1,0,'2015-03-21','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1698,'holiday_849',77,1,0,1,0,'2015-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1699,'holiday_850',78,2,1,1,0,'2016-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1700,'holiday_850',78,1,0,1,0,'2016-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1701,'holiday_851',78,2,1,1,0,'2016-03-21','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1702,'holiday_851',78,1,0,1,0,'2016-03-21','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1703,'holiday_852',79,2,1,1,0,'2017-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1704,'holiday_852',79,1,0,1,0,'2017-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1705,'holiday_853',80,2,1,1,0,'2018-03-21','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1706,'holiday_853',80,1,0,1,0,'2018-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1707,'holiday_854',81,2,1,1,0,'2019-03-21','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1708,'holiday_854',81,1,0,1,0,'2019-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1709,'holiday_855',82,2,1,1,0,'2020-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1710,'holiday_855',82,1,0,1,0,'2020-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1711,'holiday_856',83,2,1,1,0,'2021-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1712,'holiday_856',83,1,0,1,0,'2021-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1713,'holiday_857',84,2,1,1,0,'2022-03-21','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1714,'holiday_857',84,1,0,1,0,'2022-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1715,'holiday_858',85,2,1,1,0,'2023-03-21','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1716,'holiday_858',85,1,0,1,0,'2023-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1717,'holiday_859',86,2,1,1,0,'2024-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1718,'holiday_859',86,1,0,1,0,'2024-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1719,'holiday_860',87,2,1,1,0,'2025-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1720,'holiday_860',87,1,0,1,0,'2025-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1721,'holiday_861',88,2,1,1,0,'2026-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1722,'holiday_861',88,1,0,1,0,'2026-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1723,'holiday_862',89,2,1,1,0,'2027-03-21','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1724,'holiday_862',89,1,0,1,0,'2027-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1725,'holiday_863',89,2,1,1,0,'2027-03-22','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1726,'holiday_863',89,1,0,1,0,'2027-03-22','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1727,'holiday_864',90,2,1,1,0,'2028-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1728,'holiday_864',90,1,0,1,0,'2028-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1729,'holiday_865',91,2,1,1,0,'2029-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1730,'holiday_865',91,1,0,1,0,'2029-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1731,'holiday_866',92,2,1,1,0,'2030-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1732,'holiday_866',92,1,0,1,0,'2030-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1733,'holiday_867',93,2,1,1,0,'2031-03-21','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1734,'holiday_867',93,1,0,1,0,'2031-03-21','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1735,'holiday_868',94,2,1,1,0,'2032-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1736,'holiday_868',94,1,0,1,0,'2032-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1737,'holiday_869',95,2,1,1,0,'2033-03-20','春分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1738,'holiday_869',95,1,0,1,0,'2033-03-20','Vernal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1739,'holiday_870',95,2,1,1,0,'2033-03-21','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1740,'holiday_870',95,1,0,1,0,'2033-03-21','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1741,'holiday_871',96,2,1,1,0,'1974-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1742,'holiday_871',96,1,0,1,0,'1974-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1743,'holiday_872',97,2,1,1,0,'1975-09-24','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1744,'holiday_872',97,1,0,1,0,'1975-09-24','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1745,'holiday_873',98,2,1,1,0,'1976-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1746,'holiday_873',98,1,0,1,0,'1976-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1747,'holiday_874',99,2,1,1,0,'1977-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1748,'holiday_874',99,1,0,1,0,'1977-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1749,'holiday_875',100,2,1,1,0,'1978-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1750,'holiday_875',100,1,0,1,0,'1978-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1751,'holiday_876',101,2,1,1,0,'1979-09-24','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1752,'holiday_876',101,1,0,1,0,'1979-09-24','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1753,'holiday_877',102,2,1,1,0,'1980-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1754,'holiday_877',102,1,0,1,0,'1980-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1755,'holiday_878',103,2,1,1,0,'1981-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1756,'holiday_878',103,1,0,1,0,'1981-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1757,'holiday_879',104,2,1,1,0,'1982-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1758,'holiday_879',104,1,0,1,0,'1982-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1759,'holiday_880',105,2,1,1,0,'1983-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1760,'holiday_880',105,1,0,1,0,'1983-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1761,'holiday_881',106,2,1,1,0,'1984-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1762,'holiday_881',106,1,0,1,0,'1984-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1763,'holiday_882',106,2,1,1,0,'1984-09-24','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1764,'holiday_882',106,1,0,1,0,'1984-09-24','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1765,'holiday_883',107,2,1,1,0,'1985-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1766,'holiday_883',107,1,0,1,0,'1985-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1767,'holiday_884',108,2,1,1,0,'1986-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1768,'holiday_884',108,1,0,1,0,'1986-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1769,'holiday_885',109,2,1,1,0,'1987-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1770,'holiday_885',109,1,0,1,0,'1987-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1771,'holiday_886',110,2,1,1,0,'1988-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1772,'holiday_886',110,1,0,1,0,'1988-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1773,'holiday_887',111,2,1,1,0,'1989-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1774,'holiday_887',111,1,0,1,0,'1989-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1775,'holiday_888',112,2,1,1,0,'1990-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1776,'holiday_888',112,1,0,1,0,'1990-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1777,'holiday_889',112,2,1,1,0,'1990-09-24','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1778,'holiday_889',112,1,0,1,0,'1990-09-24','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1779,'holiday_890',113,2,1,1,0,'1991-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1780,'holiday_890',113,1,0,1,0,'1991-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1781,'holiday_891',114,2,1,1,0,'1992-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1782,'holiday_891',114,1,0,1,0,'1992-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1783,'holiday_892',115,2,1,1,0,'1993-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1784,'holiday_892',115,1,0,1,0,'1993-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1785,'holiday_893',116,2,1,1,0,'1994-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1786,'holiday_893',116,1,0,1,0,'1994-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1787,'holiday_894',117,2,1,1,0,'1995-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1788,'holiday_894',117,1,0,1,0,'1995-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1789,'holiday_895',118,2,1,1,0,'1996-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1790,'holiday_895',118,1,0,1,0,'1996-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1791,'holiday_896',119,2,1,1,0,'1997-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1792,'holiday_896',119,1,0,1,0,'1997-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1793,'holiday_897',120,2,1,1,0,'1998-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1794,'holiday_897',120,1,0,1,0,'1998-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1795,'holiday_898',121,2,1,1,0,'1999-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1796,'holiday_898',121,1,0,1,0,'1999-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1797,'holiday_899',122,2,1,1,0,'2000-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1798,'holiday_899',122,1,0,1,0,'2000-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1799,'holiday_900',123,2,1,1,0,'2001-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1800,'holiday_900',123,1,0,1,0,'2001-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1801,'holiday_901',123,2,1,1,0,'2001-09-24','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1802,'holiday_901',123,1,0,1,0,'2001-09-24','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1803,'holiday_902',124,2,1,1,0,'2002-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1804,'holiday_902',124,1,0,1,0,'2002-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1805,'holiday_903',125,2,1,1,0,'2003-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1806,'holiday_903',125,1,0,1,0,'2003-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1807,'holiday_904',126,2,1,1,0,'2004-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1808,'holiday_904',126,1,0,1,0,'2004-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1809,'holiday_905',127,2,1,1,0,'2005-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1810,'holiday_905',127,1,0,1,0,'2005-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1811,'holiday_906',128,2,1,1,0,'2006-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1812,'holiday_906',128,1,0,1,0,'2006-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1813,'holiday_907',129,2,1,1,0,'2007-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1814,'holiday_907',129,1,0,1,0,'2007-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1815,'holiday_908',129,2,1,1,0,'2007-09-24','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1816,'holiday_908',129,1,0,1,0,'2007-09-24','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1817,'holiday_909',130,2,1,1,0,'2008-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1818,'holiday_909',130,1,0,1,0,'2008-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1819,'holiday_910',131,2,1,1,0,'2009-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1820,'holiday_910',131,1,0,1,0,'2009-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1821,'holiday_911',132,2,1,1,0,'2010-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1822,'holiday_911',132,1,0,1,0,'2010-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1823,'holiday_912',133,2,1,1,0,'2011-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1824,'holiday_912',133,1,0,1,0,'2011-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1825,'holiday_913',134,2,1,1,0,'2012-09-22','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1826,'holiday_913',134,1,0,1,0,'2012-09-22','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1827,'holiday_914',135,2,1,1,0,'2013-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1828,'holiday_914',135,1,0,1,0,'2013-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1829,'holiday_915',136,2,1,1,0,'2014-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1830,'holiday_915',136,1,0,1,0,'2014-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1831,'holiday_916',137,2,1,1,0,'2015-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1832,'holiday_916',137,1,0,1,0,'2015-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1833,'holiday_917',138,2,1,1,0,'2016-09-22','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1834,'holiday_917',138,1,0,1,0,'2016-09-22','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1835,'holiday_918',139,2,1,1,0,'2017-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1836,'holiday_918',139,1,0,1,0,'2017-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1837,'holiday_919',140,2,1,1,0,'2018-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1838,'holiday_919',140,1,0,1,0,'2018-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1839,'holiday_920',140,2,1,1,0,'2018-09-24','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1840,'holiday_920',140,1,0,1,0,'2018-09-24','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1841,'holiday_921',141,2,1,1,0,'2019-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1842,'holiday_921',141,1,0,1,0,'2019-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1843,'holiday_922',142,2,1,1,0,'2020-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1844,'holiday_922',142,1,0,1,0,'2020-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1845,'holiday_923',143,2,1,1,0,'2021-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1846,'holiday_923',143,1,0,1,0,'2021-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1847,'holiday_924',144,2,1,1,0,'2022-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1848,'holiday_924',144,1,0,1,0,'2022-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1849,'holiday_925',145,2,1,1,0,'2023-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1850,'holiday_925',145,1,0,1,0,'2023-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1851,'holiday_926',146,2,1,1,0,'2024-09-22','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1852,'holiday_926',146,1,0,1,0,'2024-09-22','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1853,'holiday_927',147,2,1,1,0,'2025-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1854,'holiday_927',147,1,0,1,0,'2025-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1855,'holiday_928',148,2,1,1,0,'2026-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1856,'holiday_928',148,1,0,1,0,'2026-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1857,'holiday_929',149,2,1,1,0,'2027-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1858,'holiday_929',149,1,0,1,0,'2027-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1859,'holiday_930',150,2,1,1,0,'2028-09-22','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1860,'holiday_930',150,1,0,1,0,'2028-09-22','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1861,'holiday_931',151,2,1,1,0,'2029-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1862,'holiday_931',151,1,0,1,0,'2029-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1863,'holiday_932',151,2,1,1,0,'2029-09-24','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1864,'holiday_932',151,1,0,1,0,'2029-09-24','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1865,'holiday_933',152,2,1,1,0,'2030-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1866,'holiday_933',152,1,0,1,0,'2030-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1867,'holiday_934',153,2,1,1,0,'2031-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1868,'holiday_934',153,1,0,1,0,'2031-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1869,'holiday_935',154,2,1,1,0,'2032-09-22','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1870,'holiday_935',154,1,0,1,0,'2032-09-22','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1871,'holiday_936',155,2,1,1,0,'2033-09-23','秋分の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1872,'holiday_936',155,1,0,1,0,'2033-09-23','Autumnal Equinox Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1873,'holiday_937',156,2,1,1,0,'1988-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1874,'holiday_937',156,1,0,1,0,'1988-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1875,'holiday_938',157,2,1,1,0,'1989-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1876,'holiday_938',157,1,0,1,0,'1989-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1877,'holiday_939',158,2,1,1,0,'1990-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1878,'holiday_939',158,1,0,1,0,'1990-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1879,'holiday_940',159,2,1,1,0,'1991-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1880,'holiday_940',159,1,0,1,0,'1991-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1881,'holiday_941',160,2,1,1,0,'1993-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1882,'holiday_941',160,1,0,1,0,'1993-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1883,'holiday_942',161,2,1,1,0,'1994-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1884,'holiday_942',161,1,0,1,0,'1994-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1885,'holiday_943',162,2,1,1,0,'1995-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1886,'holiday_943',162,1,0,1,0,'1995-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1887,'holiday_944',163,2,1,1,0,'1996-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1888,'holiday_944',163,1,0,1,0,'1996-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1889,'holiday_945',164,2,1,1,0,'1999-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1890,'holiday_945',164,1,0,1,0,'1999-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1891,'holiday_946',165,2,1,1,0,'2000-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1892,'holiday_946',165,1,0,1,0,'2000-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1893,'holiday_947',166,2,1,1,0,'2001-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1894,'holiday_947',166,1,0,1,0,'2001-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1895,'holiday_948',167,2,1,1,0,'2002-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1896,'holiday_948',167,1,0,1,0,'2002-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1897,'holiday_949',168,2,1,1,0,'2004-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1898,'holiday_949',168,1,0,1,0,'2004-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1899,'holiday_950',169,2,1,1,0,'2005-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1900,'holiday_950',169,1,0,1,0,'2005-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1901,'holiday_951',170,2,1,1,0,'2006-05-04','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1902,'holiday_951',170,1,0,1,0,'2006-05-04','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1903,'holiday_952',171,2,1,1,0,'1996-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1904,'holiday_952',171,1,0,1,0,'1996-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1905,'holiday_953',171,2,1,1,0,'1997-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1906,'holiday_953',171,1,0,1,0,'1997-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1907,'holiday_954',171,2,1,1,0,'1997-07-21','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1908,'holiday_954',171,1,0,1,0,'1997-07-21','Transfer holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1909,'holiday_955',171,2,1,1,0,'1998-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1910,'holiday_955',171,1,0,1,0,'1998-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1911,'holiday_956',171,2,1,1,0,'1999-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1912,'holiday_956',171,1,0,1,0,'1999-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1913,'holiday_957',171,2,1,1,0,'2000-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1914,'holiday_957',171,1,0,1,0,'2000-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1915,'holiday_958',171,2,1,1,0,'2001-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1916,'holiday_958',171,1,0,1,0,'2001-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1917,'holiday_959',171,2,1,1,0,'2002-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1918,'holiday_959',171,1,0,1,0,'2002-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1919,'holiday_960',172,2,1,1,0,'2003-07-21','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1920,'holiday_960',172,1,0,1,0,'2003-07-21','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1921,'holiday_961',172,2,1,1,0,'2004-07-19','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1922,'holiday_961',172,1,0,1,0,'2004-07-19','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1923,'holiday_962',172,2,1,1,0,'2005-07-18','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1924,'holiday_962',172,1,0,1,0,'2005-07-18','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1925,'holiday_963',172,2,1,1,0,'2006-07-17','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1926,'holiday_963',172,1,0,1,0,'2006-07-17','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1927,'holiday_964',172,2,1,1,0,'2007-07-16','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1928,'holiday_964',172,1,0,1,0,'2007-07-16','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1929,'holiday_965',172,2,1,1,0,'2008-07-21','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1930,'holiday_965',172,1,0,1,0,'2008-07-21','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1931,'holiday_966',172,2,1,1,0,'2009-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1932,'holiday_966',172,1,0,1,0,'2009-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1933,'holiday_967',172,2,1,1,0,'2010-07-19','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1934,'holiday_967',172,1,0,1,0,'2010-07-19','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1935,'holiday_968',172,2,1,1,0,'2011-07-18','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1936,'holiday_968',172,1,0,1,0,'2011-07-18','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1937,'holiday_969',172,2,1,1,0,'2012-07-16','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1938,'holiday_969',172,1,0,1,0,'2012-07-16','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1939,'holiday_970',172,2,1,1,0,'2013-07-15','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1940,'holiday_970',172,1,0,1,0,'2013-07-15','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1941,'holiday_971',172,2,1,1,0,'2014-07-21','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1942,'holiday_971',172,1,0,1,0,'2014-07-21','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1943,'holiday_972',172,2,1,1,0,'2015-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1944,'holiday_972',172,1,0,1,0,'2015-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1945,'holiday_973',172,2,1,1,0,'2016-07-18','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1946,'holiday_973',172,1,0,1,0,'2016-07-18','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1947,'holiday_974',172,2,1,1,0,'2017-07-17','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1948,'holiday_974',172,1,0,1,0,'2017-07-17','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1949,'holiday_975',172,2,1,1,0,'2018-07-16','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1950,'holiday_975',172,1,0,1,0,'2018-07-16','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1951,'holiday_976',172,2,1,1,0,'2019-07-15','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1952,'holiday_976',172,1,0,1,0,'2019-07-15','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1953,'holiday_977',172,2,1,1,0,'2020-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1954,'holiday_977',172,1,0,1,0,'2020-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1955,'holiday_978',172,2,1,1,0,'2021-07-19','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1956,'holiday_978',172,1,0,1,0,'2021-07-19','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1957,'holiday_979',172,2,1,1,0,'2022-07-18','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1958,'holiday_979',172,1,0,1,0,'2022-07-18','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1959,'holiday_980',172,2,1,1,0,'2023-07-17','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1960,'holiday_980',172,1,0,1,0,'2023-07-17','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1961,'holiday_981',172,2,1,1,0,'2024-07-15','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1962,'holiday_981',172,1,0,1,0,'2024-07-15','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1963,'holiday_982',172,2,1,1,0,'2025-07-21','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1964,'holiday_982',172,1,0,1,0,'2025-07-21','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1965,'holiday_983',172,2,1,1,0,'2026-07-20','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1966,'holiday_983',172,1,0,1,0,'2026-07-20','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1967,'holiday_984',172,2,1,1,0,'2027-07-19','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1968,'holiday_984',172,1,0,1,0,'2027-07-19','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1969,'holiday_985',172,2,1,1,0,'2028-07-17','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1970,'holiday_985',172,1,0,1,0,'2028-07-17','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1971,'holiday_986',172,2,1,1,0,'2029-07-16','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1972,'holiday_986',172,1,0,1,0,'2029-07-16','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1973,'holiday_987',172,2,1,1,0,'2030-07-15','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1974,'holiday_987',172,1,0,1,0,'2030-07-15','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1975,'holiday_988',172,2,1,1,0,'2031-07-21','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1976,'holiday_988',172,1,0,1,0,'2031-07-21','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1977,'holiday_989',172,2,1,1,0,'2032-07-19','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1978,'holiday_989',172,1,0,1,0,'2032-07-19','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1979,'holiday_990',172,2,1,1,0,'2033-07-18','海の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1980,'holiday_990',172,1,0,1,0,'2033-07-18','Marine Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1981,'holiday_991',173,2,1,1,0,'2015-09-22','国民の休日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1982,'holiday_991',173,1,0,1,0,'2015-09-22','National People\'s Day Holiday',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1983,'holiday_992',174,2,1,1,0,'2016-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1984,'holiday_992',174,1,0,1,0,'2016-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1985,'holiday_993',174,2,1,1,0,'2017-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1986,'holiday_993',174,1,0,1,0,'2017-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1987,'holiday_994',174,2,1,1,0,'2019-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1988,'holiday_994',174,1,0,1,0,'2019-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1989,'holiday_994',174,2,1,1,0,'2019-08-12','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1990,'holiday_994',174,1,0,1,0,'2019-08-11','substitute holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1991,'holiday_995',174,2,1,1,0,'2020-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1992,'holiday_995',174,1,0,1,0,'2020-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1993,'holiday_996',174,2,1,1,0,'2021-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1994,'holiday_996',174,1,0,1,0,'2021-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1995,'holiday_997',174,2,1,1,0,'2022-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1996,'holiday_997',174,1,0,1,0,'2022-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1997,'holiday_998',174,2,1,1,0,'2023-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1998,'holiday_998',174,1,0,1,0,'2023-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(1999,'holiday_999',174,2,1,1,0,'2024-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2000,'holiday_999',174,1,0,1,0,'2024-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2001,'holiday_999',174,2,1,1,0,'2024-08-12','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2002,'holiday_999',174,1,0,1,0,'2024-08-11','substitute holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2003,'holiday_1000',174,2,1,1,0,'2025-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2004,'holiday_1000',174,1,0,1,0,'2025-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2005,'holiday_1001',174,2,1,1,0,'2026-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2006,'holiday_1001',174,1,0,1,0,'2026-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2007,'holiday_1002',174,2,1,1,0,'2027-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2008,'holiday_1002',174,1,0,1,0,'2027-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2009,'holiday_1003',174,2,1,1,0,'2028-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2010,'holiday_1003',174,1,0,1,0,'2028-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2011,'holiday_1004',174,2,1,1,0,'2029-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2012,'holiday_1004',174,1,0,1,0,'2029-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2013,'holiday_1005',174,2,1,1,0,'2030-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2014,'holiday_1005',174,1,0,1,0,'2030-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2015,'holiday_1005',174,2,1,1,0,'2030-08-12','(振替休日)',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2016,'holiday_1005',174,1,0,1,0,'2030-08-11','substitute holiday',1,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2017,'holiday_1006',174,2,1,1,0,'2031-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2018,'holiday_1006',174,1,0,1,0,'2031-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2019,'holiday_1007',174,2,1,1,0,'2032-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2020,'holiday_1007',174,1,0,1,0,'2032-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2021,'holiday_1008',174,2,1,1,0,'2033-08-11','山の日',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29'),(2022,'holiday_1008',174,1,0,1,0,'2033-08-11','Mountain Day',0,0,'2019-03-02 03:14:29',0,'2019-03-02 03:14:29');
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iframe_frame_settings`
--

DROP TABLE IF EXISTS `iframe_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iframe_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `height` int(11) NOT NULL DEFAULT '400' COMMENT 'iframeの高さ',
  `display_scrollbar` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'スクロールバーの表示  1:表示する、0:表示しない',
  `display_frame` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'フレーム枠の表示  1:表示する、0:表示しない',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iframe_frame_settings`
--

LOCK TABLES `iframe_frame_settings` WRITE;
/*!40000 ALTER TABLE `iframe_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `iframe_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iframes`
--

DROP TABLE IF EXISTS `iframes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iframes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_id` int(11) NOT NULL COMMENT 'ブロックID',
  `key` varchar(255) NOT NULL COMMENT 'iframeキー',
  `url` text COMMENT 'URL',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iframes`
--

LOCK TABLES `iframes` WRITE;
/*!40000 ALTER TABLE `iframes` DISABLE KEYS */;
/*!40000 ALTER TABLE `iframes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL COMMENT '順序',
  `is_active` tinyint(1) DEFAULT NULL COMMENT 'アクティブフラグ 1:アクティブ、0:非アクティブ',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`,`weight`,`code`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'en',2,0,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03'),(2,'ja',1,1,NULL,'2019-03-02 03:14:03',NULL,'2019-03-02 03:14:03');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `plugin_key` varchar(255) DEFAULT NULL COMMENT 'プラグインKey',
  `block_key` varchar(255) DEFAULT NULL COMMENT 'ブロックKey',
  `content_key` varchar(255) DEFAULT NULL COMMENT '各プラグインのコンテンツKey',
  `like_count` int(11) NOT NULL DEFAULT '0' COMMENT 'いいね数',
  `unlike_count` int(11) NOT NULL DEFAULT '0' COMMENT 'わるいね数',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '評価(いいね数－わるいね数)',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `content_key` (`plugin_key`,`content_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes_users`
--

DROP TABLE IF EXISTS `likes_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `like_id` int(11) DEFAULT NULL COMMENT 'いいねID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザID',
  `session_key` varchar(255) DEFAULT NULL COMMENT 'セッションKey',
  `is_liked` tinyint(1) DEFAULT NULL COMMENT '0:わるいね、1:いいね',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `session_key` (`session_key`,`like_id`),
  KEY `like_id` (`user_id`,`like_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes_users`
--

LOCK TABLES `likes_users` WRITE;
/*!40000 ALTER TABLE `likes_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `likes_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link_frame_settings`
--

DROP TABLE IF EXISTS `link_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `display_type` int(4) NOT NULL DEFAULT '1' COMMENT '表示方法種別  1: ドロップダウン型、2:リスト型（説明なし）、3:リスト型（説明あり）',
  `open_new_tab` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'リンクの開き方  0:同じウィンドウ内、1:新しいタブ',
  `display_click_count` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'リンクのクリック数の表示  0:表示しない、1:表示する',
  `category_separator_line` varchar(255) DEFAULT NULL COMMENT 'カテゴリ間の区切り線',
  `list_style` varchar(255) DEFAULT NULL COMMENT 'リストマーク',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link_frame_settings`
--

LOCK TABLES `link_frame_settings` WRITE;
/*!40000 ALTER TABLE `link_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `link_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link_orders`
--

DROP TABLE IF EXISTS `link_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_key` varchar(255) NOT NULL COMMENT 'ブロックKey',
  `category_key` varchar(255) DEFAULT NULL COMMENT 'カテゴリKey',
  `link_key` varchar(255) NOT NULL COMMENT 'リンクKey',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '表示の重み(表示順序)',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `link_key` (`link_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link_orders`
--

LOCK TABLES `link_orders` WRITE;
/*!40000 ALTER TABLE `link_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `link_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_id` int(11) NOT NULL COMMENT 'ブロックID',
  `category_id` int(11) DEFAULT NULL COMMENT 'カテゴリーID',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `key` varchar(255) NOT NULL COMMENT 'リンクキー',
  `status` int(4) NOT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新コンテンツかどうか 0:最新でない 1:最新',
  `url` text COMMENT 'リンク先URL',
  `title` varchar(255) DEFAULT NULL COMMENT 'タイトル',
  `description` text COMMENT '説明',
  `click_count` int(11) NOT NULL DEFAULT '0' COMMENT 'クリック数',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `links`
--

LOCK TABLES `links` WRITE;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
/*!40000 ALTER TABLE `links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_queue_users`
--

DROP TABLE IF EXISTS `mail_queue_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_queue_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `plugin_key` varchar(255) NOT NULL COMMENT 'プラグインKey',
  `block_key` varchar(255) DEFAULT NULL COMMENT 'ブロックKey',
  `content_key` varchar(255) DEFAULT NULL COMMENT '各プラグインのコンテンツKey',
  `mail_queue_id` int(11) DEFAULT NULL COMMENT '個別送信パターン用（user_id,to_address）',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザに送信, 個別送信パターン1',
  `room_id` int(11) DEFAULT NULL COMMENT 'ルームに所属しているユーザに送信, 複数人パターン',
  `to_address` text COMMENT 'メールアドレスで送信, 個別送信パターン2',
  `send_room_permission` varchar(255) DEFAULT NULL COMMENT 'ルーム送信時のパーミッション',
  `not_send_room_user_ids` text COMMENT 'ルーム送信時に送らない複数のユーザ',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `mail_queue_id` (`mail_queue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_queue_users`
--

LOCK TABLES `mail_queue_users` WRITE;
/*!40000 ALTER TABLE `mail_queue_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_queue_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_queues`
--

DROP TABLE IF EXISTS `mail_queues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_queues` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `language_id` int(6) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `plugin_key` varchar(255) NOT NULL COMMENT 'プラグインKey',
  `block_key` varchar(255) DEFAULT NULL COMMENT 'ブロック削除用',
  `reply_to` varchar(255) DEFAULT NULL COMMENT '問合せ先メール',
  `content_key` varchar(255) DEFAULT NULL COMMENT 'ブロック削除用, 各プラグインのコンテンツキー',
  `mail_subject` varchar(255) NOT NULL COMMENT 'メール件名',
  `mail_body` text NOT NULL COMMENT 'メール本文',
  `send_time` datetime NOT NULL COMMENT '送信日時',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `send_time` (`send_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_queues`
--

LOCK TABLES `mail_queues` WRITE;
/*!40000 ALTER TABLE `mail_queues` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_queues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_setting_fixed_phrases`
--

DROP TABLE IF EXISTS `mail_setting_fixed_phrases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_setting_fixed_phrases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_setting_id` int(11) NOT NULL,
  `language_id` int(6) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `plugin_key` varchar(255) DEFAULT NULL,
  `block_key` varchar(255) DEFAULT NULL,
  `type_key` varchar(255) NOT NULL COMMENT '定型文の種類',
  `mail_fixed_phrase_subject` varchar(255) NOT NULL COMMENT '定型文 件名',
  `mail_fixed_phrase_body` text NOT NULL COMMENT '定型文 本文',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_key` (`block_key`,`plugin_key`,`language_id`,`type_key`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_setting_fixed_phrases`
--

LOCK TABLES `mail_setting_fixed_phrases` WRITE;
/*!40000 ALTER TABLE `mail_setting_fixed_phrases` DISABLE KEYS */;
INSERT INTO `mail_setting_fixed_phrases` VALUES (1,1,1,1,0,0,'announcements',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]({X-ROOM})','You are receiving this email because a message was posted to Announcement.\nRoom\'s name:{X-ROOM}\nuser:{X-USER}\ndate:{X-TO_DATE}\n\n{X-BODY}\n\nClick on the link below to reply to this article.\n{X-URL}',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(2,1,2,1,0,0,'announcements',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]({X-ROOM})','{X-PLUGIN_NAME}に投稿されたのでお知らせします。\nルーム名:{X-ROOM}\n投稿者:{X-USER}\n投稿日時:{X-TO_DATE}\n\n{X-BODY}\n\nこの記事に返信するには、下記アドレスへ\n{X-URL}',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(3,3,1,1,0,0,'bbses',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM} {X-BBS_NAME})','You are receiving this email because a message was posted to BBS.\nRoom\'s name:{X-ROOM}\nBBS title:{X-BBS_NAME}\ntitle:{X-SUBJECT}\nuser:{X-USER}\ndate:{X-TO_DATE}\n\n{X-BODY}\n\nClick on the link below to reply to this article.\n{X-URL}',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(4,3,2,1,0,0,'bbses',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM} {X-BBS_NAME})','{X-PLUGIN_NAME}に投稿されたのでお知らせします。\nルーム名:{X-ROOM}\n掲示板タイトル:{X-BBS_NAME}\n記事タイトル:{X-SUBJECT}\n投稿者:{X-USER}\n投稿日時:{X-TO_DATE}\n\n{X-BODY}\n\nこの記事に返信するには、下記アドレスへ\n{X-URL}',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(5,4,1,1,0,0,'blogs',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM} {X-BLOCK_NAME})','Posted on {X-PLUGIN_NAME}.\nRoom name: {X-ROOM}\nChannel name: {X-BLOCK_NAME}\nVideo Title: {X-SUBJECT}\nPosted by: {X-USER}\nPost time: {X-TO_DATE}\n\n{X-BODY}\n\nPlease click on the link below to check this post content.\n{X-URL}',NULL,'2019-03-02 03:14:17',NULL,'2019-03-02 03:14:17'),(6,4,2,1,0,0,'blogs',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM} {X-BLOCK_NAME})','{X-PLUGIN_NAME}にコンテンツが投稿されたのでお知らせします。\nルーム名:{X-ROOM}\nブロック名:{X-BLOCK_NAME}\nタイトル:{X-SUBJECT}\n投稿者:{X-USER}\n投稿日時:{X-TO_DATE}\n\n{X-BODY}\n\nこの投稿内容を確認するには下記のリンクをクリックしてください。\n{X-URL}',NULL,'2019-03-02 03:14:17',NULL,'2019-03-02 03:14:17'),(7,5,1,1,0,0,'calendars',NULL,'contents','','',NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(8,5,2,1,0,0,'calendars',NULL,'contents','[{X-SITE_NAME}]予定の通知','カレンダーに予定が追加されたのでお知らせします。\n\n件名:{X-SUBJECT}\n公開対象:{X-ROOM}\n開始日時:{X-START_TIME}\n終了日時:{X-END_TIME}\n場所:{X-LOCATION}\n連絡先:{X-CONTACT}\n繰返し:{X-RRULE}\n記入者:{X-USER}\n記入日時:{X-TO_DATE}\n\n{X-BODY}\n\nこの予定を見るには、下記アドレスへ\n{X-URL}\n',NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(9,6,1,1,0,0,'circular_notices',NULL,'contents','','',NULL,'2019-03-02 03:14:21',NULL,'2019-03-02 03:14:21'),(10,6,2,1,0,0,'circular_notices',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM})','{X-PLUGIN_NAME}に投稿されたのでお知らせします。\nルーム名:{X-ROOM}\n回覧タイトル:{X-SUBJECT}\n投稿者:{X-USER}\n投稿日時:{X-TO_DATE}\n\n{X-BODY}\n\nこの投稿内容を確認するには下記のリンクをクリックしてください。\n{X-URL}',NULL,'2019-03-02 03:14:21',NULL,'2019-03-02 03:14:21'),(11,7,1,1,0,0,'faqs',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-QUESTION}({X-ROOM} {X-FAQ_NAME})','You are receiving this email because a message was posted to FAQ.\nRoom\'s name:{X-ROOM}\nFAQ title:{X-FAQ_NAME}\nuser:{X-USER}\ndate:{X-TO_DATE}\n\nQuestion:\n{X-QUESTION}\n\nAnswer:\n{X-ANSWER}\n\nClick on the link below to reply to this article.\n{X-URL}',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(12,7,2,1,0,0,'faqs',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-QUESTION}({X-ROOM} {X-FAQ_NAME})','{X-PLUGIN_NAME}に投稿されたのでお知らせします。\nルーム名:{X-ROOM}\nFAQ名:{X-FAQ_NAME}\n投稿者:{X-USER}\n投稿日時:{X-TO_DATE}\n\n質問:\n{X-QUESTION}\n\n回答:\n{X-ANSWER}\n\nこの記事に返信するには、下記アドレスへ\n{X-URL}',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(13,8,1,1,0,0,'links',NULL,'contents','','{X-PLUGIN_NAME}にリンクが追加されたのでお知らせします。\nルーム名: {X-ROOM}\nリンクリスト名: {X-BLOCK_NAME}\nリンク先: {X-LINK_URL}\nタイトル: {X-TITLE}\nカテゴリ: {X-CATEGORY_NAME}\n登録者: {X-USER}\n登録日時: {X-TO_DATE}\n説明:\n{X-DESCRIPTION}\n\nこのリンクを確認するには、下記アドレスへ\n{X-URL}',NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(14,8,2,1,0,0,'links',NULL,'contents','','{X-PLUGIN_NAME}にリンクが追加されたのでお知らせします。\nルーム名: {X-ROOM}\nリンクリスト名: {X-BLOCK_NAME}\nリンク先: {X-LINK_URL}\nタイトル: {X-TITLE}\nカテゴリ: {X-CATEGORY_NAME}\n登録者: {X-USER}\n登録日時: {X-TO_DATE}\n説明:\n{X-DESCRIPTION}\n\nこのリンクについて確認するには、下記アドレスへ\n{X-URL}',NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(15,9,1,1,0,0,'multidatabases',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM} {X-BLOCK_NAME})','\nYou are receiving this email because a message was posted to MULTIDATABASE.\nRoom\'s name:{X-ROOM}\nMULTIDATABASE title:{X-BLOCK_NAME}\ntitle:{X-SUBJECT}\nuser:{X-USER}\ndate:{X-TO_DATE}\n\nClick on the link below to reply to this article.\n{X-URL}',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(16,9,2,1,0,0,'multidatabases',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM} {X-BLOCK_NAME})','\n{X-PLUGIN_NAME}に投稿されたのでお知らせします。\nルーム名:{X-ROOM}\n汎用データベースタイトル:{X-BLOCK_NAME}\nコンテンツタイトル:{X-SUBJECT}\n投稿者:{X-USER}\n投稿日時:{X-TO_DATE}\n\nこの記事に返信するには、下記アドレスへ\n{X-URL}',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(17,10,1,1,0,0,'questionnaires',NULL,'contents','','',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(18,10,2,1,0,0,'questionnaires',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM})','{X-SUBJECT}が開始されます。\nルーム名:{X-ROOM}\nアンケート名:{X-SUBJECT}\n\n回答のご協力をお願いいたします。\n下記のリンクをクリックしてください。\n{X-URL}',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(19,10,1,1,0,0,'questionnaires',NULL,'contents','','',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(20,10,2,1,0,0,'questionnaires',NULL,'contents','','',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(21,11,1,1,0,0,'quizzes',NULL,'contents','','',NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(22,11,2,1,0,0,'quizzes',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM})','{X-SUBJECT}が開始されます。\nルーム名:{X-ROOM}\n小テスト名:{X-SUBJECT}\n\n下記のリンクをクリックして試験を受けてください。\n{X-URL}',NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(23,11,1,1,0,0,'quizzes',NULL,'contents','','',NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(24,11,2,1,0,0,'quizzes',NULL,'contents','','{X-PLUGIN_NAME}に回答されたのでお知らせします。\nルーム名:{X-ROOM}\nタイトル:{X-SUBJECT}\n回答者:{X-USER}\n回答日時:{X-TO_DATE}\n\n回答結果を参照・採点するには下記のリンクをクリックしてください。\n{X-URL}',NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(25,12,1,1,0,0,'registrations',NULL,'contents','','',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(26,12,2,1,0,0,'registrations',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM})','{X-SUBJECT}が開始されます。\nルーム名:{X-ROOM}\n登録フォーム名:{X-SUBJECT}\n\n登録のご協力をお願いいたします。\n下記のリンクをクリックしてください。\n{X-URL}',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(27,12,1,1,0,0,'registrations',NULL,'answer','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT} answer','Thank you for your registration.\n\nRegistrarion form:{X-SUBJECT}\n\nRegistered date:{X-TO_DATE}\n\n\n{X-DATA}\n\nPlease print this mail and bring it with you.',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(28,12,2,1,0,0,'registrations',NULL,'answer','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}を受け付けました。','{X-SUBJECT}の登録通知先メールアドレスとしてあなたのメールアドレスが使用されました。\nもし{X-SUBJECT}への登録に覚えがない場合はこのメールを破棄してください。\n\n\n{X-SUBJECT}を受け付けました。\n\n登録日時:{X-TO_DATE}\n\n\n{X-DATA}\n\nメール内容を印刷の上、会場にご持参ください。',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(29,13,1,1,0,0,'reservations',NULL,'contents','','',NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(30,13,2,1,0,0,'reservations',NULL,'contents','[{X-SITE_NAME}]予約通知','施設に予約が追加されたのでお知らせします。\n\n件名:{X-SUBJECT}\n公開対象:{X-ROOM}\n開始日時:{X-START_TIME}\n終了日時:{X-END_TIME}\n場所:{X-LOCATION}\n連絡先:{X-CONTACT}\n繰返し:{X-RRULE}\n記入者:{X-USER}\n記入日時:{X-TO_DATE}\n\n{X-BODY}\n\nこの予約を見るには、下記アドレスへ\n{X-URL}\n',NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(31,14,1,1,0,0,'rss_readers',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-TITLE}({X-ROOM})','{X-PLUGIN_NAME}にリンクが追加されたのでお知らせします。\nルーム名: {X-ROOM}\nRDF/RSSのURL: {X-RSS_URL}\nRDF/RSSのサイト名: {X-TITLE}\nRDF/RSSのサイトURL: {X-LINK}\nRDF/RSSのサイト説明: {X-SUMMARY}\n登録者: {X-USER}\n登録日時: {X-TO_DATE}\n\nこの内容を確認するには、下記アドレスへ\n{X-URL}',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(32,14,2,1,0,0,'rss_readers',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-TITLE}({X-ROOM})','{X-PLUGIN_NAME}にリンクが追加されたのでお知らせします。\nルーム名: {X-ROOM}\nRDF/RSSのURL: {X-RSS_URL}\nRDF/RSSのサイト名: {X-TITLE}\nRDF/RSSのサイトURL: {X-LINK}\nRDF/RSSのサイト説明: {X-SUMMARY}\n登録者: {X-USER}\n登録日時: {X-TO_DATE}\n\nこの内容について確認するには、下記アドレスへ\n{X-URL}',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(33,15,1,1,0,0,'tasks',NULL,'contents','','',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(34,15,2,1,0,0,'tasks',NULL,'contents','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM})','{X-PLUGIN_NAME}に投稿されたのでお知らせします。\nルーム名:{X-ROOM}\nToDoタイトル:{X-SUBJECT}\n投稿者:{X-USER}\n投稿日時:{X-TO_DATE}\n\n{X-BODY}\n\nこのToDoの内容を確認するには下記のリンクをクリックしてください。\n{X-URL}',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(35,15,1,1,0,0,'tasks',NULL,'reminder','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM})','{X-SUBJECT}',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(36,15,2,1,0,0,'tasks',NULL,'reminder','[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-SUBJECT}({X-ROOM})実施期限終了間近のお知らせ','{X-SUBJECT}が実施期限終了間近になったのでお知らせします。\nルーム名:{X-ROOM}\nTODO名:{X-SUBJECT}\n投稿者:{X-USER}\n投稿日時:{X-TO_DATE}\n\n{X-BODY}\n\nこのToDoの内容を確認するには下記のリンクをクリックしてください。\n{X-URL}',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(37,16,1,1,0,0,'user_manager',NULL,'contents','{X-SUBJECT}','{X-BODY}',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(38,16,2,1,0,0,'user_manager',NULL,'contents','{X-SUBJECT}','{X-BODY}',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(39,16,1,1,0,0,'user_manager',NULL,'save_notify','Welcome to {X-SITE_NAME}.','Thank you for registering for {X-SITE_NAME}.\nHandle: {X-HANDLENAME}\nLogin_id: {X-USERNAME}\ne-mail: {X-EMAIL}\n\nNew to get the password from the following, please login.:\n{X-PASSWORD_URL}',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(40,16,2,1,0,0,'user_manager',NULL,'save_notify','{X-SITE_NAME}へようこそ','会員登録が完了しましたのでお知らせします。\nハンドル: {X-HANDLENAME}\nログインID: {X-USERNAME}\ne-mail: {X-EMAIL}\n\n下記から新たにパスワードを取得し、ログインてください。\n{X-PASSWORD_URL}',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(41,17,1,1,0,0,'videos',NULL,'contents','','Posted on {X-PLUGIN_NAME}.\nRoom name: {X-ROOM}\nChannel name: {X-BLOCK_NAME}\nVideo Title: {X-SUBJECT}\nPosted by: {X-USER}\nPost time: {X-TO_DATE}\n{X-TAGS}\n\n{X-BODY}\n\nPlease click on the link below to check this post content.\n{X-URL}',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(42,17,2,1,0,0,'videos',NULL,'contents','','{X-PLUGIN_NAME}に投稿されたのでお知らせします。\nルーム名:{X-ROOM}\nチャンネル名:{X-BLOCK_NAME}\n動画タイトル:{X-SUBJECT}\n投稿者:{X-USER}\n投稿日時:{X-TO_DATE}\n{X-TAGS}\n\n{X-BODY}\n\nこの投稿内容を確認するには下記のリンクをクリックしてください。\n{X-URL}',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49');
/*!40000 ALTER TABLE `mail_setting_fixed_phrases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail_settings`
--

DROP TABLE IF EXISTS `mail_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_key` varchar(255) DEFAULT NULL,
  `block_key` varchar(255) DEFAULT NULL,
  `is_mail_send` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'メール通知  0:通知しない、1:通知する',
  `is_mail_send_approval` tinyint(1) NOT NULL DEFAULT '0' COMMENT '承認メール通知  0:通知しない、1:通知する',
  `reply_to` varchar(255) DEFAULT NULL COMMENT '問合せ先メール',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `plugin_key` (`plugin_key`,`block_key`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_settings`
--

LOCK TABLES `mail_settings` WRITE;
/*!40000 ALTER TABLE `mail_settings` DISABLE KEYS */;
INSERT INTO `mail_settings` VALUES (1,'announcements',NULL,0,1,NULL,NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(2,'auth',NULL,1,0,NULL,NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(3,'bbses',NULL,0,1,NULL,NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(4,'blogs',NULL,0,1,NULL,NULL,'2019-03-02 03:14:17',NULL,'2019-03-02 03:14:17'),(5,'calendars',NULL,0,1,NULL,NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(6,'circular_notices',NULL,0,0,NULL,NULL,'2019-03-02 03:14:21',NULL,'2019-03-02 03:14:21'),(7,'faqs',NULL,0,1,NULL,NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(8,'links',NULL,0,1,NULL,NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(9,'multidatabases',NULL,0,1,NULL,NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(10,'questionnaires',NULL,0,1,NULL,NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(11,'quizzes',NULL,0,1,NULL,NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(12,'registrations',NULL,0,1,NULL,NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(13,'reservations',NULL,0,1,NULL,NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(14,'rss_readers',NULL,0,1,NULL,NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(15,'tasks',NULL,0,1,NULL,NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(16,'user_manager',NULL,1,0,NULL,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(17,'videos',NULL,0,1,NULL,NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49');
/*!40000 ALTER TABLE `mail_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_frame_settings`
--

DROP TABLE IF EXISTS `menu_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `display_type` varchar(255) NOT NULL COMMENT 'bootstrap navi type',
  `is_private_room_hidden` tinyint(1) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_frame_settings`
--

LOCK TABLES `menu_frame_settings` WRITE;
/*!40000 ALTER TABLE `menu_frame_settings` DISABLE KEYS */;
INSERT INTO `menu_frame_settings` VALUES (1,'frame_2','major',NULL,NULL,'2019-03-02 03:14:32',NULL,'2019-03-02 03:14:32'),(2,'frame_ins_2','major',0,1,'2019-03-02 13:45:26',1,'2019-03-02 13:45:26');
/*!40000 ALTER TABLE `menu_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_frames_pages`
--

DROP TABLE IF EXISTS `menu_frames_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_frames_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `page_id` int(11) DEFAULT NULL,
  `is_hidden` tinyint(1) DEFAULT NULL,
  `folder_type` tinyint(1) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`,`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_frames_pages`
--

LOCK TABLES `menu_frames_pages` WRITE;
/*!40000 ALTER TABLE `menu_frames_pages` DISABLE KEYS */;
INSERT INTO `menu_frames_pages` VALUES (1,'frame_ins_2',1,0,NULL,1,'2019-03-02 13:45:26',1,'2019-03-02 13:45:26'),(2,'frame_ins_2',4,0,NULL,1,'2019-03-02 13:45:26',1,'2019-03-02 13:45:26'),(3,'frame_ins_2',10,0,NULL,1,'2019-03-02 13:45:26',1,'2019-03-02 13:45:26'),(4,'frame_ins_2',11,0,NULL,1,'2019-03-02 13:45:26',1,'2019-03-02 13:45:26'),(5,'frame_ins_2',12,0,NULL,1,'2019-03-02 13:45:26',1,'2019-03-02 13:45:26'),(6,'frame_ins_2',9,0,NULL,1,'2019-03-02 13:45:26',1,'2019-03-02 13:45:26'),(7,'frame_ins_2',8,0,NULL,1,'2019-03-02 13:45:26',1,'2019-03-02 13:45:26'),(8,'frame_ins_2',14,0,NULL,1,'2019-03-02 13:45:26',1,'2019-03-02 13:45:26');
/*!40000 ALTER TABLE `menu_frames_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_frames_rooms`
--

DROP TABLE IF EXISTS `menu_frames_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_frames_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `is_hidden` tinyint(1) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`,`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_frames_rooms`
--

LOCK TABLES `menu_frames_rooms` WRITE;
/*!40000 ALTER TABLE `menu_frames_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu_frames_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multidatabase_contents`
--

DROP TABLE IF EXISTS `multidatabase_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multidatabase_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(255) NOT NULL COMMENT 'キー(content key)',
  `multidatabase_key` varchar(255) NOT NULL,
  `multidatabase_id` int(11) NOT NULL DEFAULT '0' COMMENT '汎用DBID',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `block_id` int(11) NOT NULL DEFAULT '0',
  `title_icon` varchar(255) DEFAULT NULL,
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '公開状況 1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新コンテンツかどうか 0:最新でない 1:最新',
  `value1` varchar(255) DEFAULT NULL,
  `value2` varchar(255) DEFAULT NULL,
  `value3` varchar(255) DEFAULT NULL,
  `value4` varchar(255) DEFAULT NULL,
  `value5` varchar(255) DEFAULT NULL,
  `value6` varchar(255) DEFAULT NULL,
  `value7` varchar(255) DEFAULT NULL,
  `value8` varchar(255) DEFAULT NULL,
  `value9` varchar(255) DEFAULT NULL,
  `value10` varchar(255) DEFAULT NULL,
  `value11` varchar(255) DEFAULT NULL,
  `value12` varchar(255) DEFAULT NULL,
  `value13` varchar(255) DEFAULT NULL,
  `value14` varchar(255) DEFAULT NULL,
  `value15` varchar(255) DEFAULT NULL,
  `value16` varchar(255) DEFAULT NULL,
  `value17` varchar(255) DEFAULT NULL,
  `value18` varchar(255) DEFAULT NULL,
  `value19` varchar(255) DEFAULT NULL,
  `value20` varchar(255) DEFAULT NULL,
  `value21` varchar(255) DEFAULT NULL,
  `value22` varchar(255) DEFAULT NULL,
  `value23` varchar(255) DEFAULT NULL,
  `value24` varchar(255) DEFAULT NULL,
  `value25` varchar(255) DEFAULT NULL,
  `value26` varchar(255) DEFAULT NULL,
  `value27` varchar(255) DEFAULT NULL,
  `value28` varchar(255) DEFAULT NULL,
  `value29` varchar(255) DEFAULT NULL,
  `value30` varchar(255) DEFAULT NULL,
  `value31` varchar(255) DEFAULT NULL,
  `value32` varchar(255) DEFAULT NULL,
  `value33` varchar(255) DEFAULT NULL,
  `value34` varchar(255) DEFAULT NULL,
  `value35` varchar(255) DEFAULT NULL,
  `value36` varchar(255) DEFAULT NULL,
  `value37` varchar(255) DEFAULT NULL,
  `value38` varchar(255) DEFAULT NULL,
  `value39` varchar(255) DEFAULT NULL,
  `value40` varchar(255) DEFAULT NULL,
  `value41` varchar(255) DEFAULT NULL,
  `value42` varchar(255) DEFAULT NULL,
  `value43` varchar(255) DEFAULT NULL,
  `value44` varchar(255) DEFAULT NULL,
  `value45` varchar(255) DEFAULT NULL,
  `value46` varchar(255) DEFAULT NULL,
  `value47` varchar(255) DEFAULT NULL,
  `value48` varchar(255) DEFAULT NULL,
  `value49` varchar(255) DEFAULT NULL,
  `value50` varchar(255) DEFAULT NULL,
  `value51` varchar(255) DEFAULT NULL,
  `value52` varchar(255) DEFAULT NULL,
  `value53` varchar(255) DEFAULT NULL,
  `value54` varchar(255) DEFAULT NULL,
  `value55` varchar(255) DEFAULT NULL,
  `value56` varchar(255) DEFAULT NULL,
  `value57` varchar(255) DEFAULT NULL,
  `value58` varchar(255) DEFAULT NULL,
  `value59` varchar(255) DEFAULT NULL,
  `value60` varchar(255) DEFAULT NULL,
  `value61` varchar(255) DEFAULT NULL,
  `value62` varchar(255) DEFAULT NULL,
  `value63` varchar(255) DEFAULT NULL,
  `value64` varchar(255) DEFAULT NULL,
  `value65` varchar(255) DEFAULT NULL,
  `value66` varchar(255) DEFAULT NULL,
  `value67` varchar(255) DEFAULT NULL,
  `value68` varchar(255) DEFAULT NULL,
  `value69` varchar(255) DEFAULT NULL,
  `value70` varchar(255) DEFAULT NULL,
  `value71` varchar(255) DEFAULT NULL,
  `value72` varchar(255) DEFAULT NULL,
  `value73` varchar(255) DEFAULT NULL,
  `value74` varchar(255) DEFAULT NULL,
  `value75` varchar(255) DEFAULT NULL,
  `value76` varchar(255) DEFAULT NULL,
  `value77` varchar(255) DEFAULT NULL,
  `value78` varchar(255) DEFAULT NULL,
  `value79` varchar(255) DEFAULT NULL,
  `value80` text,
  `value81` text,
  `value82` text,
  `value83` text,
  `value84` text,
  `value85` text,
  `value86` text,
  `value87` text,
  `value88` text,
  `value89` text,
  `value90` text,
  `value91` text,
  `value92` text,
  `value93` text,
  `value94` text,
  `value95` text,
  `value96` text,
  `value97` text,
  `value98` text,
  `value99` text,
  `value100` text,
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multidatabase_contents`
--

LOCK TABLES `multidatabase_contents` WRITE;
/*!40000 ALTER TABLE `multidatabase_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `multidatabase_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multidatabase_frame_settings`
--

DROP TABLE IF EXISTS `multidatabase_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multidatabase_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `content_per_page` int(11) NOT NULL DEFAULT '10' COMMENT '表示件数 1件,5件,10件,20件,50件,100件',
  `default_sort_type` varchar(255) DEFAULT '0' COMMENT '表示順',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multidatabase_frame_settings`
--

LOCK TABLES `multidatabase_frame_settings` WRITE;
/*!40000 ALTER TABLE `multidatabase_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `multidatabase_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multidatabase_metadata_settings`
--

DROP TABLE IF EXISTS `multidatabase_metadata_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multidatabase_metadata_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `auto_number_sequence` int(11) DEFAULT '0' COMMENT '自動採番',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multidatabase_metadata_settings`
--

LOCK TABLES `multidatabase_metadata_settings` WRITE;
/*!40000 ALTER TABLE `multidatabase_metadata_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `multidatabase_metadata_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multidatabase_metadatas`
--

DROP TABLE IF EXISTS `multidatabase_metadatas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multidatabase_metadatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(255) NOT NULL COMMENT '汎用DBキー(plugin key)',
  `multidatabase_id` int(6) NOT NULL DEFAULT '0' COMMENT '汎用DBID',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `name` varchar(255) NOT NULL COMMENT '項目名',
  `col_no` int(3) DEFAULT '0' COMMENT 'カラムNo',
  `type` varchar(20) NOT NULL DEFAULT '1' COMMENT '属性 0:画像,1:テキスト,2:テキストエリア,3:リンク,4:選択式（択一）,5:ファイル,6:WYSIWYGテキスト,7:自動採番,8:メール,9:日付,10:登録日時,11:更新日時,12:選択式（複数）',
  `rank` int(11) NOT NULL DEFAULT '0' COMMENT '表示順',
  `position` int(4) NOT NULL DEFAULT '0' COMMENT '表示位置 0:上,1:中左,2:中右,3:下',
  `selections` text COMMENT '選択肢',
  `is_require` tinyint(1) NOT NULL DEFAULT '0' COMMENT '必須か 0:必須でない,1:必須',
  `is_title` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'タイトルとするか 0:しない,1:する',
  `is_searchable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '検索対象とするか 0:対象外,1:対象',
  `is_sortable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'ソート対象とするか 0:対象外,1:対象',
  `is_file_dl_require_auth` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'ファイルDL時に認証させるか 0:認証させる,1:認証させない',
  `is_visible_file_dl_counter` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'ファイルDL回数を表示するか 0:表示しない,1:表示する',
  `is_visible_field_name` tinyint(1) NOT NULL DEFAULT '0' COMMENT '項目名を表示するか 0:表示しない,1:表示する',
  `is_visible_list` tinyint(1) NOT NULL DEFAULT '0' COMMENT '一覧に表示するか 0:表示しない,1:表示する',
  `is_visible_detail` tinyint(1) NOT NULL DEFAULT '0' COMMENT '詳細に表示するか 0:表示しない,1:表示する',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multidatabase_metadatas`
--

LOCK TABLES `multidatabase_metadatas` WRITE;
/*!40000 ALTER TABLE `multidatabase_metadatas` DISABLE KEYS */;
/*!40000 ALTER TABLE `multidatabase_metadatas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multidatabases`
--

DROP TABLE IF EXISTS `multidatabases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multidatabases` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_id` int(11) NOT NULL DEFAULT '0',
  `key` varchar(255) NOT NULL COMMENT '汎用DBキー(plugin key)',
  `name` varchar(255) NOT NULL COMMENT 'データベース名',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multidatabases`
--

LOCK TABLES `multidatabases` WRITE;
/*!40000 ALTER TABLE `multidatabases` DISABLE KEYS */;
/*!40000 ALTER TABLE `multidatabases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nc2_to_nc3_maps`
--

DROP TABLE IF EXISTS `nc2_to_nc3_maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nc2_to_nc3_maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nc2_site_id` varchar(40) NOT NULL,
  `model_name` varchar(255) NOT NULL,
  `nc2_id` varchar(255) NOT NULL,
  `nc3_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nc2_site_id` (`nc2_site_id`,`model_name`,`nc2_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nc2_to_nc3_maps`
--

LOCK TABLES `nc2_to_nc3_maps` WRITE;
/*!40000 ALTER TABLE `nc2_to_nc3_maps` DISABLE KEYS */;
/*!40000 ALTER TABLE `nc2_to_nc3_maps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(255) NOT NULL COMMENT 'キー',
  `title` varchar(255) DEFAULT NULL COMMENT 'タイトル',
  `summary` text COMMENT '内容',
  `link` varchar(255) DEFAULT NULL COMMENT 'リンク',
  `last_updated` datetime DEFAULT NULL COMMENT '最新更新日時',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (6,'dace6db68585865e18637f647c59fe7c','システムメンテナンスに伴うサイト停止のお知らせ','このたび、下記日程でシステムメンテナンスを行うため、サイトが一時閲覧できない状態になります。\n◆停止期間：2019年1月28日（月）10:00～18:00 の内、いずれか2時間程度\nご不便をおかけしますがご理解いただきますようお願い申し上げます。','https://www.netcommons.org/blogs/blog_entries/view/6/08e16e4aab89f494fbc5fe0c56975f6a','2019-01-23 01:58:53',1,'2019-03-02 09:38:43',1,'2019-03-02 09:38:43'),(7,'71b3ec46e5d0f157a9719c2cb94d089d','NetCommons3.2.2リリース','NetCommons3.2.2をリリース致しました。\nダウンロードページへ\n上記ページからダウンロードし、アップデート、もしくは、インストールをお願いします。\n今回のバージョンアップは、コアに関するDBテーブルが変更になりました。そのため、ブラウザからバージョンアップする場合、下記手順で実施をお願いします。\n\nアップデート方法（ブラウザ）\n\n1. サイトにログインし、プラグイン管理画面を表示する。2. 最新のNC3のファイルを、既存サイトのファイルに上書きする。3. プラグイン管理画面をリロードする4. 一括アップデートボタン、ならびに更新対象であるプラグインの一覧が表示されることを確認する。5. 4.で表示を確認した一括アップデートボタンをクリックする。\n※ もしブラウザからバージョンアップの手順を間違えた場合は、直接プラグイン管理画面（https://ご自身のドメイン/plugi...','https://www.netcommons.org/blogs/blog_entries/view/6/51e0b1ca8a69f48207c4cad162a96df7','2019-01-21 10:45:00',1,'2019-03-02 09:38:43',1,'2019-03-02 09:38:43'),(8,'fbe2addbce76da8abf8b86f510841688','NetCommons3.2.1.1リリース','NetCommons3.2.1.1をリリース致しました。\nこのリリースは、NetCommons3.2.1.patch1を取り込んだ不具合修正リリースです。\nダウンロードページへ\n上記ページからダウンロードし、アップデート、もしくは、インストールをお願いします。\n今回のバージョンアップは、コアに関するDBテーブルが変更になりました。そのため、ブラウザからバージョンアップする場合、下記手順で実施をお願いします。\n\nアップデート方法（ブラウザ）\n\n1. サイトにログインし、プラグイン管理画面を表示する。2. NC3.2.1.1のファイルを、既存サイトのファイルに上書きする。3. プラグイン管理画面をリロードする4. 一括アップデートボタン、ならびに更新対象であるプラグインの一覧が表示されることを確認する。5. 4.で表示を確認した一括アップデートボタンをクリックする。\n※ もしブラウザから...','https://www.netcommons.org/blogs/blog_entries/view/6/5409e27bc512384e2a3e39d0e66c4ae8','2018-11-04 07:31:39',1,'2019-03-02 09:38:43',1,'2019-03-02 09:38:43'),(9,'1bb4a6af7aafb47a767e3184bc80e4bb','NetCommons3.2.1.patch1リリース','NetCommons3.2.1.patch1をリリース致しました。このパッチは、不具合修正のパッチです。\nパッチをダウンロード\n上記からダウンロードし、パッチの適用をお願いします。\nパッチの適用方法は、下記をご参照ください。\n \n【パッチの適用方法】１．解凍したパッチを、そのままNetCommons3.2.1に上書きします。※ プラグインの一括アップデートは不要です。\n \n【修正内容】php5.4.32, 5.5.16より低いの環境の場合、プラグイン管理画面等が内部エラーで表示できずアップデートできない不具合の修正（CentOS7標準のphpは5.4.16のため、内部エラーが発生します）※ 詳しい内容は、＜GitHub＞にありますのでご確認ください。\n \n掲示板やGithubで情報提供して頂いた皆様、誠にありがとうございました。\n\nume\nprado1996\n※敬称略\n\n後日、当不具...','https://www.netcommons.org/blogs/blog_entries/view/6/6f1a4cb2122e1a16430d28da15343945','2018-11-01 10:11:15',1,'2019-03-02 09:38:43',1,'2019-03-02 09:38:43'),(10,'1d8155effc68a3e8fc13d9e21607c0fb','NetCommons3.2.1リリース','NetCommons3.2.1をリリース致しました。\nダウンロードページへ\n上記ページからダウンロードし、アップデート、もしくは、インストールをお願いします。\n今回のバージョンアップは、コアに関するDBテーブルが変更になりました。そのため、ブラウザからバージョンアップする場合、下記手順で実施をお願いします。\n\nアップデート方法（ブラウザ）\n\n1. サイトにログインし、プラグイン管理画面を表示する。2. NC3.2.1のファイルを、既存サイトのファイルに上書きする。3. プラグイン管理画面をリロードする4. 一括アップデートボタン、ならびに更新対象であるプラグインの一覧が表示されることを確認する。5. 4.で表示を確認した一括アップデートボタンをクリックする。\n※ もしブラウザからバージョンアップの手順を間違えた場合は、直接プラグイン管理画面（https://ご自身のドメイン/plug...','https://www.netcommons.org/blogs/blog_entries/view/6/1a83f2531f993aac3e29b2369912373c','2018-10-31 02:25:31',1,'2019-03-02 09:38:43',1,'2019-03-02 09:38:43');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_containers`
--

DROP TABLE IF EXISTS `page_containers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_containers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `container_type` int(4) DEFAULT NULL COMMENT 'コンテナータイプ.  1:Header, 2:Major, 3:Main, 4:Minor, 5:Footer',
  `is_published` tinyint(1) DEFAULT NULL COMMENT 'コンテナーの表示・非表示',
  `is_configured` tinyint(1) NOT NULL DEFAULT '0' COMMENT '設定したかどうか。1の場合、サイト管理もしくはルームで変更しても反映させない。',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`,`container_type`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_containers`
--

LOCK TABLES `page_containers` WRITE;
/*!40000 ALTER TABLE `page_containers` DISABLE KEYS */;
INSERT INTO `page_containers` VALUES (1,1,1,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(2,1,2,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(3,1,3,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(4,1,4,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(5,1,5,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(6,2,1,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(7,2,2,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(8,2,3,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(9,2,4,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(10,2,5,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(11,3,1,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(12,3,2,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(13,3,3,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(14,3,4,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(15,3,5,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(16,4,1,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(17,4,2,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(18,4,3,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(19,4,4,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(20,4,5,1,0,NULL,'2019-03-02 03:14:10',NULL,'2019-03-02 03:14:10'),(21,5,1,1,0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(22,5,2,1,0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(23,5,3,1,0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(24,5,4,1,0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(25,5,5,1,0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(26,6,1,1,0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(27,6,2,1,0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(28,6,3,1,0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(29,6,4,1,0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(30,6,5,1,0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(31,7,1,1,0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(32,7,2,1,0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(33,7,3,1,0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(34,7,4,1,0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(35,7,5,1,0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(36,8,1,1,0,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(37,8,2,1,0,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(38,8,3,1,0,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(39,8,4,1,0,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(40,8,5,1,0,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(41,9,1,1,0,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(42,9,2,1,0,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(43,9,3,1,0,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(44,9,4,1,0,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(45,9,5,1,0,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(46,10,1,1,0,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(47,10,2,1,0,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(48,10,3,1,0,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(49,10,4,1,0,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(50,10,5,1,0,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(51,11,1,1,0,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(52,11,2,1,0,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(53,11,3,1,0,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(54,11,4,1,0,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(55,11,5,1,0,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(56,12,1,1,0,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(57,12,2,1,0,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(58,12,3,1,0,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(59,12,4,1,0,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(60,12,5,1,0,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(61,13,1,1,0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(62,13,2,1,0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(63,13,3,1,0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(64,13,4,1,0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(65,13,5,1,0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(66,14,1,1,0,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(67,14,2,1,0,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(68,14,3,1,0,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(69,14,4,1,0,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(70,14,5,1,0,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(71,15,1,1,0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(72,15,2,1,0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(73,15,3,1,0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(74,15,4,1,0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(75,15,5,1,0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `page_containers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ページID',
  `room_id` int(11) NOT NULL,
  `root_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `sort_key` varchar(255) DEFAULT NULL,
  `child_count` int(11) DEFAULT '0',
  `permalink` text,
  `slug` varchar(255) DEFAULT NULL,
  `is_container_fluid` tinyint(1) NOT NULL DEFAULT '0',
  `theme` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `permalink` (`permalink`(255)),
  KEY `parent_id_2` (`parent_id`,`sort_key`,`id`),
  KEY `sort_key` (`sort_key`,`id`),
  KEY `weight` (`parent_id`,`weight`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,1,NULL,NULL,1,4,1,'~00000001',5,'',NULL,0,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(2,2,NULL,NULL,5,6,2,'~00000002',5,'',NULL,0,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(3,3,NULL,NULL,7,8,3,'~00000003',2,'',NULL,0,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(4,1,1,1,2,3,1,'~00000001-00000001',0,'home','home',0,NULL,NULL,'2019-03-02 03:14:09',1,'2019-03-02 13:46:29'),(5,5,2,2,NULL,NULL,1,'~00000002-00000001',0,'private_room_system_admistrator','private_room_system_admistrator',0,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(6,6,2,2,NULL,NULL,2,'~00000002-00000002',0,'private_room_general_user_1','private_room_general_user_1',0,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(7,7,2,2,NULL,NULL,3,'~00000002-00000003',0,'private_room_general_user_2','private_room_general_user_2',0,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(8,8,3,3,NULL,NULL,1,'~00000003-00000001',0,'community_room_1','community_room_1',0,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(9,9,1,1,NULL,NULL,2,'~00000001-00000002',0,'public_room_1','public_room_1',0,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(10,1,1,1,NULL,NULL,3,'~00000001-00000003',0,'frame_test_page','frame_test_page',0,NULL,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(11,1,1,1,NULL,NULL,4,'~00000001-00000004',0,'announcements_page','announcements_page',0,NULL,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(12,1,1,1,NULL,NULL,5,'~00000001-00000005',0,'calendars_page','calendars_page',0,NULL,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(13,10,2,2,NULL,NULL,4,'~00000002-00000004',0,'private_room_general_user_3','private_room_general_user_3',0,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(14,11,3,3,NULL,NULL,2,'~00000003-00000002',0,'community_room_2','community_room_2',0,NULL,1,'2019-03-02 03:42:54',1,'2019-03-02 03:42:54'),(15,12,2,2,NULL,NULL,5,'~00000002-00000005',0,'d2573c996c1bd316f0bcf0db4fa6eaab','d2573c996c1bd316f0bcf0db4fa6eaab',0,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages_languages`
--

DROP TABLE IF EXISTS `pages_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `page_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_robots` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`,`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages_languages`
--

LOCK TABLES `pages_languages` WRITE;
/*!40000 ALTER TABLE `pages_languages` DISABLE KEYS */;
INSERT INTO `pages_languages` VALUES (1,1,0,0,1,'',NULL,NULL,NULL,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(2,2,1,0,1,'',NULL,NULL,NULL,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(3,1,0,0,2,'',NULL,NULL,NULL,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(4,2,1,0,2,'',NULL,NULL,NULL,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(5,1,0,0,3,'',NULL,NULL,NULL,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(6,2,1,0,3,'',NULL,NULL,NULL,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(7,1,0,1,4,'Home',NULL,NULL,NULL,NULL,NULL,'2019-03-02 03:14:09',NULL,'2019-03-02 03:14:09'),(8,2,1,1,4,'Home',NULL,NULL,NULL,NULL,NULL,'2019-03-02 03:14:09',1,'2019-03-02 13:46:29'),(9,2,1,0,5,'プライベート',NULL,NULL,NULL,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(10,2,1,0,6,'プライベート',NULL,NULL,NULL,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(11,2,1,0,7,'プライベート',NULL,NULL,NULL,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(12,2,1,0,8,'Community room 1',NULL,NULL,NULL,NULL,1,'2019-03-02 03:19:56',1,'2019-03-02 03:19:56'),(13,2,1,0,9,'Public room 1',NULL,NULL,NULL,NULL,1,'2019-03-02 03:20:47',1,'2019-03-02 03:20:47'),(14,2,1,0,10,'Frame Test Page',NULL,NULL,NULL,NULL,1,'2019-03-02 03:21:57',1,'2019-03-02 03:21:57'),(15,2,1,0,11,'Announcements Page',NULL,NULL,NULL,NULL,1,'2019-03-02 03:22:21',1,'2019-03-02 03:22:21'),(16,2,1,0,12,'Calendars Page',NULL,NULL,NULL,NULL,1,'2019-03-02 03:22:55',1,'2019-03-02 03:22:55'),(17,2,1,0,13,'プライベート',NULL,NULL,NULL,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(18,2,1,0,14,'Community room 2',NULL,NULL,NULL,NULL,1,'2019-03-02 03:42:55',1,'2019-03-02 03:42:55'),(19,2,1,0,15,'プライベート',NULL,NULL,NULL,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `pages_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_album_display_albums`
--

DROP TABLE IF EXISTS `photo_album_display_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo_album_display_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `album_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_album_display_albums`
--

LOCK TABLES `photo_album_display_albums` WRITE;
/*!40000 ALTER TABLE `photo_album_display_albums` DISABLE KEYS */;
/*!40000 ALTER TABLE `photo_album_display_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_album_frame_settings`
--

DROP TABLE IF EXISTS `photo_album_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo_album_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `display_type` int(4) DEFAULT '1' COMMENT '1:List of album, 2:List of photo, 3: Slide show',
  `albums_per_page` int(11) DEFAULT '20' COMMENT 'Number of displays of albums per one page',
  `albums_order` varchar(128) DEFAULT 'PhotoAlbum.modified desc' COMMENT 'Sort field name',
  `albums_sort` varchar(128) DEFAULT 'PhotoAlbum.modified' COMMENT 'Sort field name',
  `albums_direction` varchar(4) DEFAULT 'desc' COMMENT 'ASC or DESC',
  `photos_per_page` int(11) DEFAULT '50' COMMENT 'Number of displays of albums per one page',
  `photos_order` varchar(128) DEFAULT 'PhotoAlbumPhoto.modified desc' COMMENT 'Sort field name',
  `photos_sort` varchar(128) DEFAULT 'PhotoAlbumPhoto.modified' COMMENT 'Sort field name',
  `photos_direction` varchar(4) DEFAULT 'desc' COMMENT 'ASC or DESC',
  `slide_height` int(11) DEFAULT '400' COMMENT 'Slide show height',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_album_frame_settings`
--

LOCK TABLES `photo_album_frame_settings` WRITE;
/*!40000 ALTER TABLE `photo_album_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `photo_album_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_album_photos`
--

DROP TABLE IF EXISTS `photo_album_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo_album_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) NOT NULL,
  `album_key` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequence number of each block',
  `key` varchar(255) NOT NULL COMMENT 'Serial key of content history',
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `status` int(4) NOT NULL COMMENT '1:Published, 2:Pending, 3:In draft, 4:Disapproved',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Deactive, 1:Acive',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Not latest, 1:Latest',
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `album_key` (`album_key`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_album_photos`
--

LOCK TABLES `photo_album_photos` WRITE;
/*!40000 ALTER TABLE `photo_album_photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `photo_album_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_albums`
--

DROP TABLE IF EXISTS `photo_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL COMMENT 'Serial key of content history',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequence number of each block',
  `block_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `status` int(4) NOT NULL COMMENT '1:Published, 2:Pending, 3:In draft, 4:Disapproved',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Deactive, 1:Acive',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:Not latest, 1:Latest',
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_albums`
--

LOCK TABLES `photo_albums` WRITE;
/*!40000 ALTER TABLE `photo_albums` DISABLE KEYS */;
/*!40000 ALTER TABLE `photo_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugins`
--

DROP TABLE IF EXISTS `plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `key` varchar(255) NOT NULL COMMENT 'プラグインKey',
  `is_m17n` tinyint(1) DEFAULT '1' COMMENT '多言語を有効にするプラグインかどうか',
  `name` varchar(255) NOT NULL COMMENT 'プラグイン名',
  `namespace` varchar(255) NOT NULL COMMENT 'packagistのネームスペース',
  `weight` int(11) DEFAULT NULL COMMENT '表示順序',
  `type` int(11) DEFAULT NULL COMMENT 'プラグインタイプ 1:一般プラグイン,2:コントロールパネル/サイト管理プラグイン,3:システム管理プラグイン,4:未インストールのため抜け番,5:テーマ,6:外部ライブラリ composer,7:外部ライブラリ bower',
  `version` varchar(255) DEFAULT NULL COMMENT 'バージョン',
  `commit_version` varchar(255) DEFAULT NULL COMMENT 'コミットバージョン',
  `commited` datetime DEFAULT NULL,
  `default_action` varchar(255) NOT NULL COMMENT '一般画面のアクション',
  `default_setting_action` varchar(255) NOT NULL COMMENT '編集画面のアクション',
  `frame_add_action` varchar(255) DEFAULT '' COMMENT 'フレーム追加時のアクション',
  `display_topics` tinyint(1) NOT NULL DEFAULT '0' COMMENT '新着に表示するか 0:表示しない 1:表示する',
  `display_search` tinyint(1) NOT NULL DEFAULT '0' COMMENT '検索に表示するか 0:表示しない 1:表示する',
  `serialize_data` text,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`key`,`language_id`),
  KEY `language_id` (`language_id`),
  KEY `weight` (`weight`),
  KEY `types` (`type`,`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plugins`
--

LOCK TABLES `plugins` WRITE;
/*!40000 ALTER TABLE `plugins` DISABLE KEYS */;
INSERT INTO `plugins` VALUES (1,2,1,1,0,'plugin_manager',NULL,'プラグイン管理','netcommons/plugin-manager',8,3,'dev-master','ec01eb5e982ab4c057ed976e5ed71665ea544a1f','2019-01-07 15:24:56','plugin_manager/index','','',0,0,'a:14:{s:3:\"key\";s:14:\"plugin_manager\";s:9:\"namespace\";s:25:\"netcommons/plugin-manager\";s:11:\"description\";s:35:\"PluginManager Plugin for NetCommons\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"ec01eb5e982ab4c057ed976e5ed71665ea544a1f\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/PluginManager.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-07T15:24:56+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"PluginManager\";s:4:\"name\";s:25:\"Netcommons Plugin-manager\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/PluginManager/tree/ec01eb5e982ab4c057ed976e5ed71665ea544a1f\";}',NULL,'2019-03-02 03:14:04',NULL,'2019-03-02 03:14:04'),(2,1,0,1,0,'plugin_manager',NULL,'Plugin Manager','netcommons/plugin-manager',8,3,'dev-master','ec01eb5e982ab4c057ed976e5ed71665ea544a1f','2019-01-07 15:24:56','plugin_manager/index','','',0,0,'a:14:{s:3:\"key\";s:14:\"plugin_manager\";s:9:\"namespace\";s:25:\"netcommons/plugin-manager\";s:11:\"description\";s:35:\"PluginManager Plugin for NetCommons\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"ec01eb5e982ab4c057ed976e5ed71665ea544a1f\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/PluginManager.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-07T15:24:56+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"PluginManager\";s:4:\"name\";s:25:\"Netcommons Plugin-manager\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/PluginManager/tree/ec01eb5e982ab4c057ed976e5ed71665ea544a1f\";}',NULL,'2019-03-02 03:14:04',NULL,'2019-03-02 03:14:04'),(3,2,1,1,0,'site_manager',NULL,'サイト管理','netcommons/site-manager',6,2,'dev-master','38b31e31d38e5dea9505e6c22a59be45290074d7','2019-01-25 08:20:35','site_manager/edit','','',0,0,'a:14:{s:3:\"key\";s:12:\"site_manager\";s:9:\"namespace\";s:23:\"netcommons/site-manager\";s:11:\"description\";s:33:\"SiteManager for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"38b31e31d38e5dea9505e6c22a59be45290074d7\";s:6:\"source\";s:46:\"https://github.com/NetCommons3/SiteManager.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-25T08:20:35+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:11:\"SiteManager\";s:4:\"name\";s:23:\"Netcommons Site-manager\";s:10:\"commit_url\";s:88:\"https://github.com/NetCommons3/SiteManager/tree/38b31e31d38e5dea9505e6c22a59be45290074d7\";}',NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(4,1,0,1,0,'site_manager',NULL,'Site Manager','netcommons/site-manager',6,2,'dev-master','38b31e31d38e5dea9505e6c22a59be45290074d7','2019-01-25 08:20:35','site_manager/edit','','',0,0,'a:14:{s:3:\"key\";s:12:\"site_manager\";s:9:\"namespace\";s:23:\"netcommons/site-manager\";s:11:\"description\";s:33:\"SiteManager for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"38b31e31d38e5dea9505e6c22a59be45290074d7\";s:6:\"source\";s:46:\"https://github.com/NetCommons3/SiteManager.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-25T08:20:35+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:11:\"SiteManager\";s:4:\"name\";s:23:\"Netcommons Site-manager\";s:10:\"commit_url\";s:88:\"https://github.com/NetCommons3/SiteManager/tree/38b31e31d38e5dea9505e6c22a59be45290074d7\";}',NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(5,2,1,1,0,'rooms',NULL,'ルーム管理','netcommons/rooms',2,2,'dev-improve_performance_current','e90a66c467a301a718a3dd269ebb1ad42e4f8b76','2019-03-01 23:45:56','rooms/index/4','','',0,0,'a:14:{s:3:\"key\";s:5:\"rooms\";s:9:\"namespace\";s:16:\"netcommons/rooms\";s:11:\"description\";s:28:\"Rooms Plugin for NetCommons3\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:31:\"dev-improve_performance_current\";s:14:\"commit_version\";s:40:\"e90a66c467a301a718a3dd269ebb1ad42e4f8b76\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Rooms.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-03-01T23:45:56+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Rooms\";s:4:\"name\";s:16:\"Netcommons Rooms\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Rooms/tree/e90a66c467a301a718a3dd269ebb1ad42e4f8b76\";}',NULL,'2019-03-02 03:14:11',NULL,'2019-03-02 03:14:11'),(6,1,0,1,0,'rooms',NULL,'Room Manager','netcommons/rooms',2,2,'dev-improve_performance_current','e90a66c467a301a718a3dd269ebb1ad42e4f8b76','2019-03-01 23:45:56','rooms/index/4','','',0,0,'a:14:{s:3:\"key\";s:5:\"rooms\";s:9:\"namespace\";s:16:\"netcommons/rooms\";s:11:\"description\";s:28:\"Rooms Plugin for NetCommons3\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:31:\"dev-improve_performance_current\";s:14:\"commit_version\";s:40:\"e90a66c467a301a718a3dd269ebb1ad42e4f8b76\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Rooms.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-03-01T23:45:56+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Rooms\";s:4:\"name\";s:16:\"Netcommons Rooms\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Rooms/tree/e90a66c467a301a718a3dd269ebb1ad42e4f8b76\";}',NULL,'2019-03-02 03:14:11',NULL,'2019-03-02 03:14:11'),(7,2,1,1,0,'access_counters',0,'アクセスカウンター','netcommons/access-counters',NULL,1,'dev-master','fa3cad40a72cdc5242f9d48fb5344c1edaee0e77','2018-01-26 07:36:06','access_counters/view','access_counter_blocks/index','',0,0,'a:14:{s:3:\"key\";s:15:\"access_counters\";s:9:\"namespace\";s:26:\"netcommons/access-counters\";s:11:\"description\";s:36:\"AccessCounters for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"fa3cad40a72cdc5242f9d48fb5344c1edaee0e77\";s:6:\"source\";s:49:\"https://github.com/NetCommons3/AccessCounters.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T07:36:06+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:14:\"AccessCounters\";s:4:\"name\";s:26:\"Netcommons Access-counters\";s:10:\"commit_url\";s:91:\"https://github.com/NetCommons3/AccessCounters/tree/fa3cad40a72cdc5242f9d48fb5344c1edaee0e77\";}',NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(8,1,0,1,0,'access_counters',0,'Access counters','netcommons/access-counters',NULL,1,'dev-master','fa3cad40a72cdc5242f9d48fb5344c1edaee0e77','2018-01-26 07:36:06','access_counters/view','access_counter_blocks/index','',0,0,'a:14:{s:3:\"key\";s:15:\"access_counters\";s:9:\"namespace\";s:26:\"netcommons/access-counters\";s:11:\"description\";s:36:\"AccessCounters for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"fa3cad40a72cdc5242f9d48fb5344c1edaee0e77\";s:6:\"source\";s:49:\"https://github.com/NetCommons3/AccessCounters.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T07:36:06+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:14:\"AccessCounters\";s:4:\"name\";s:26:\"Netcommons Access-counters\";s:10:\"commit_url\";s:91:\"https://github.com/NetCommons3/AccessCounters/tree/fa3cad40a72cdc5242f9d48fb5344c1edaee0e77\";}',NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(9,2,1,1,0,'announcements',1,'お知らせ','netcommons/announcements',NULL,1,'dev-master','a105ec9c20124fce58412332a8311e80f617b255','2019-01-23 09:03:43','announcements/view','announcement_blocks/index','announcements/edit',1,1,'a:14:{s:3:\"key\";s:13:\"announcements\";s:9:\"namespace\";s:24:\"netcommons/announcements\";s:11:\"description\";s:35:\"Announcements for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"a105ec9c20124fce58412332a8311e80f617b255\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/Announcements.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:03:43+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"Announcements\";s:4:\"name\";s:24:\"Netcommons Announcements\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/Announcements/tree/a105ec9c20124fce58412332a8311e80f617b255\";}',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(10,1,0,1,0,'announcements',1,'Announcements','netcommons/announcements',NULL,1,'dev-master','a105ec9c20124fce58412332a8311e80f617b255','2019-01-23 09:03:43','announcements/view','announcement_blocks/index','announcements/edit',1,1,'a:14:{s:3:\"key\";s:13:\"announcements\";s:9:\"namespace\";s:24:\"netcommons/announcements\";s:11:\"description\";s:35:\"Announcements for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"a105ec9c20124fce58412332a8311e80f617b255\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/Announcements.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:03:43+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"Announcements\";s:4:\"name\";s:24:\"Netcommons Announcements\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/Announcements/tree/a105ec9c20124fce58412332a8311e80f617b255\";}',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(11,2,1,1,0,'bbses',0,'掲示板','netcommons/bbses',NULL,1,'dev-master','236629f6b21541e96787b9a942ef6de1a5ba8535','2019-01-30 10:41:39','bbs_articles/index','bbs_blocks/index','',1,1,'a:14:{s:3:\"key\";s:5:\"bbses\";s:9:\"namespace\";s:16:\"netcommons/bbses\";s:11:\"description\";s:27:\"Bbses for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"236629f6b21541e96787b9a942ef6de1a5ba8535\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Bbses.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-30T10:41:39+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Bbses\";s:4:\"name\";s:16:\"Netcommons Bbses\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Bbses/tree/236629f6b21541e96787b9a942ef6de1a5ba8535\";}',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(12,1,0,1,0,'bbses',0,'BBS','netcommons/bbses',NULL,1,'dev-master','236629f6b21541e96787b9a942ef6de1a5ba8535','2019-01-30 10:41:39','bbs_articles/index','bbs_blocks/index','',1,1,'a:14:{s:3:\"key\";s:5:\"bbses\";s:9:\"namespace\";s:16:\"netcommons/bbses\";s:11:\"description\";s:27:\"Bbses for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"236629f6b21541e96787b9a942ef6de1a5ba8535\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Bbses.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-30T10:41:39+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Bbses\";s:4:\"name\";s:16:\"Netcommons Bbses\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Bbses/tree/236629f6b21541e96787b9a942ef6de1a5ba8535\";}',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(13,2,1,1,0,'blogs',1,'ブログ','netcommons/blogs',NULL,1,'dev-master','023527d66639f0c2747bb45131f8e6e5e04a79d7','2019-01-23 09:05:04','blog_entries/index','blog_blocks/index','',1,1,'a:14:{s:3:\"key\";s:5:\"blogs\";s:9:\"namespace\";s:16:\"netcommons/blogs\";s:11:\"description\";s:27:\"Blogs for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"023527d66639f0c2747bb45131f8e6e5e04a79d7\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Blogs.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:23:\"Ryuji AMANO (RYUS INC.)\";s:5:\"email\";s:16:\"ryuji@ryus.co.jp\";s:8:\"homepage\";s:18:\"http://ryus.co.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:05:04+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Blogs\";s:4:\"name\";s:16:\"Netcommons Blogs\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Blogs/tree/023527d66639f0c2747bb45131f8e6e5e04a79d7\";}',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(14,1,0,1,0,'blogs',1,'Blog','netcommons/blogs',NULL,1,'dev-master','023527d66639f0c2747bb45131f8e6e5e04a79d7','2019-01-23 09:05:04','blog_entries/index','blog_blocks/index','',1,1,'a:14:{s:3:\"key\";s:5:\"blogs\";s:9:\"namespace\";s:16:\"netcommons/blogs\";s:11:\"description\";s:27:\"Blogs for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"023527d66639f0c2747bb45131f8e6e5e04a79d7\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Blogs.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:23:\"Ryuji AMANO (RYUS INC.)\";s:5:\"email\";s:16:\"ryuji@ryus.co.jp\";s:8:\"homepage\";s:18:\"http://ryus.co.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:05:04+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Blogs\";s:4:\"name\";s:16:\"Netcommons Blogs\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Blogs/tree/023527d66639f0c2747bb45131f8e6e5e04a79d7\";}',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(15,2,1,1,0,'cabinets',1,'キャビネット','netcommons/cabinets',NULL,1,'dev-master','d2de00c728e265bbfd809a92c32ad11ccb75a98e','2019-02-04 09:34:09','cabinet_files/index','cabinet_blocks/index','',1,1,'a:14:{s:3:\"key\";s:8:\"cabinets\";s:9:\"namespace\";s:19:\"netcommons/cabinets\";s:11:\"description\";s:30:\"Cabinets for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"d2de00c728e265bbfd809a92c32ad11ccb75a98e\";s:6:\"source\";s:43:\"https://github.com/NetCommons3/Cabinets.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:23:\"Ryuji AMANO (RYUS INC.)\";s:5:\"email\";s:16:\"ryuji@ryus.co.jp\";s:8:\"homepage\";s:18:\"http://ryus.co.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-04T09:34:09+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"Cabinets\";s:4:\"name\";s:19:\"Netcommons Cabinets\";s:10:\"commit_url\";s:85:\"https://github.com/NetCommons3/Cabinets/tree/d2de00c728e265bbfd809a92c32ad11ccb75a98e\";}',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(16,1,0,1,0,'cabinets',1,'Cabinet','netcommons/cabinets',NULL,1,'dev-master','d2de00c728e265bbfd809a92c32ad11ccb75a98e','2019-02-04 09:34:09','cabinet_files/index','cabinet_blocks/index','',1,1,'a:14:{s:3:\"key\";s:8:\"cabinets\";s:9:\"namespace\";s:19:\"netcommons/cabinets\";s:11:\"description\";s:30:\"Cabinets for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"d2de00c728e265bbfd809a92c32ad11ccb75a98e\";s:6:\"source\";s:43:\"https://github.com/NetCommons3/Cabinets.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:23:\"Ryuji AMANO (RYUS INC.)\";s:5:\"email\";s:16:\"ryuji@ryus.co.jp\";s:8:\"homepage\";s:18:\"http://ryus.co.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-04T09:34:09+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"Cabinets\";s:4:\"name\";s:19:\"Netcommons Cabinets\";s:10:\"commit_url\";s:85:\"https://github.com/NetCommons3/Cabinets/tree/d2de00c728e265bbfd809a92c32ad11ccb75a98e\";}',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(17,2,1,1,0,'calendars',1,'カレンダー','netcommons/calendars',NULL,1,'dev-master','47346b15b9a7829fcd9dd4766a051ae6cc2dcf23','2019-01-23 16:56:52','calendars/index','calendar_frame_settings/edit','',1,1,'a:14:{s:3:\"key\";s:9:\"calendars\";s:9:\"namespace\";s:20:\"netcommons/calendars\";s:11:\"description\";s:31:\"Calendars for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"47346b15b9a7829fcd9dd4766a051ae6cc2dcf23\";s:6:\"source\";s:44:\"https://github.com/NetCommons3/Calendars.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T16:56:52+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:9:\"Calendars\";s:4:\"name\";s:20:\"Netcommons Calendars\";s:10:\"commit_url\";s:86:\"https://github.com/NetCommons3/Calendars/tree/47346b15b9a7829fcd9dd4766a051ae6cc2dcf23\";}',NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(18,1,0,1,0,'calendars',1,'CALENDAR','netcommons/calendars',NULL,1,'dev-master','47346b15b9a7829fcd9dd4766a051ae6cc2dcf23','2019-01-23 16:56:52','calendars/index','calendar_frame_settings/edit','',1,1,'a:14:{s:3:\"key\";s:9:\"calendars\";s:9:\"namespace\";s:20:\"netcommons/calendars\";s:11:\"description\";s:31:\"Calendars for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"47346b15b9a7829fcd9dd4766a051ae6cc2dcf23\";s:6:\"source\";s:44:\"https://github.com/NetCommons3/Calendars.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T16:56:52+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:9:\"Calendars\";s:4:\"name\";s:20:\"Netcommons Calendars\";s:10:\"commit_url\";s:86:\"https://github.com/NetCommons3/Calendars/tree/47346b15b9a7829fcd9dd4766a051ae6cc2dcf23\";}',NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(19,2,1,1,0,'circular_notices',0,'回覧板','netcommons/circular-notices',NULL,1,'dev-master','18847cf80ad0fd691187fc94ca4cf16a9572fa2b','2018-09-13 08:53:17','circular_notices/index','circular_notice_frame_settings/edit','',1,1,'a:14:{s:3:\"key\";s:16:\"circular_notices\";s:9:\"namespace\";s:27:\"netcommons/circular-notices\";s:11:\"description\";s:37:\"CircularNotices for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"18847cf80ad0fd691187fc94ca4cf16a9572fa2b\";s:6:\"source\";s:50:\"https://github.com/NetCommons3/CircularNotices.git\";s:7:\"authors\";a:3:{i:0;a:4:{s:4:\"name\";s:24:\"Hirohisa Kuwata(WithOne)\";s:5:\"email\";s:16:\"nc@withone.co.jp\";s:8:\"homepage\";s:24:\"http://www.withone.co.jp\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:24:\"Kazutaka Yamada(WithOne)\";s:5:\"email\";s:16:\"nc@withone.co.jp\";s:8:\"homepage\";s:24:\"http://www.withone.co.jp\";s:4:\"role\";s:9:\"Developer\";}i:2;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-09-13T08:53:17+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:15:\"CircularNotices\";s:4:\"name\";s:27:\"Netcommons Circular-notices\";s:10:\"commit_url\";s:92:\"https://github.com/NetCommons3/CircularNotices/tree/18847cf80ad0fd691187fc94ca4cf16a9572fa2b\";}',NULL,'2019-03-02 03:14:20',NULL,'2019-03-02 03:14:20'),(20,1,0,1,0,'circular_notices',0,'Circular Notices','netcommons/circular-notices',NULL,1,'dev-master','18847cf80ad0fd691187fc94ca4cf16a9572fa2b','2018-09-13 08:53:17','circular_notices/index','circular_notice_frame_settings/edit','',1,1,'a:14:{s:3:\"key\";s:16:\"circular_notices\";s:9:\"namespace\";s:27:\"netcommons/circular-notices\";s:11:\"description\";s:37:\"CircularNotices for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"18847cf80ad0fd691187fc94ca4cf16a9572fa2b\";s:6:\"source\";s:50:\"https://github.com/NetCommons3/CircularNotices.git\";s:7:\"authors\";a:3:{i:0;a:4:{s:4:\"name\";s:24:\"Hirohisa Kuwata(WithOne)\";s:5:\"email\";s:16:\"nc@withone.co.jp\";s:8:\"homepage\";s:24:\"http://www.withone.co.jp\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:24:\"Kazutaka Yamada(WithOne)\";s:5:\"email\";s:16:\"nc@withone.co.jp\";s:8:\"homepage\";s:24:\"http://www.withone.co.jp\";s:4:\"role\";s:9:\"Developer\";}i:2;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-09-13T08:53:17+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:15:\"CircularNotices\";s:4:\"name\";s:27:\"Netcommons Circular-notices\";s:10:\"commit_url\";s:92:\"https://github.com/NetCommons3/CircularNotices/tree/18847cf80ad0fd691187fc94ca4cf16a9572fa2b\";}',NULL,'2019-03-02 03:14:21',NULL,'2019-03-02 03:14:21'),(21,2,1,1,0,'faqs',1,'FAQ','netcommons/faqs',NULL,1,'dev-master','6482078e2ee82205e23610b8733e1ed90188e8d9','2019-02-08 06:00:00','faq_questions/index','faq_blocks/index','',1,1,'a:14:{s:3:\"key\";s:4:\"faqs\";s:9:\"namespace\";s:15:\"netcommons/faqs\";s:11:\"description\";s:26:\"Faqs for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6482078e2ee82205e23610b8733e1ed90188e8d9\";s:6:\"source\";s:39:\"https://github.com/NetCommons3/Faqs.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-08T06:00:00+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:4:\"Faqs\";s:4:\"name\";s:15:\"Netcommons Faqs\";s:10:\"commit_url\";s:81:\"https://github.com/NetCommons3/Faqs/tree/6482078e2ee82205e23610b8733e1ed90188e8d9\";}',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(22,1,0,1,0,'faqs',1,'FAQ','netcommons/faqs',NULL,1,'dev-master','6482078e2ee82205e23610b8733e1ed90188e8d9','2019-02-08 06:00:00','faq_questions/index','faq_blocks/index','',1,1,'a:14:{s:3:\"key\";s:4:\"faqs\";s:9:\"namespace\";s:15:\"netcommons/faqs\";s:11:\"description\";s:26:\"Faqs for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6482078e2ee82205e23610b8733e1ed90188e8d9\";s:6:\"source\";s:39:\"https://github.com/NetCommons3/Faqs.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-08T06:00:00+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:4:\"Faqs\";s:4:\"name\";s:15:\"Netcommons Faqs\";s:10:\"commit_url\";s:81:\"https://github.com/NetCommons3/Faqs/tree/6482078e2ee82205e23610b8733e1ed90188e8d9\";}',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(23,2,1,1,0,'holidays',NULL,'祝日設定','netcommons/holidays',5,2,'dev-master','4589c06a1d68f541c71835e5aebcd28199f0aed0','2019-01-17 05:15:56','holidays/index','','',0,0,'a:14:{s:3:\"key\";s:8:\"holidays\";s:9:\"namespace\";s:19:\"netcommons/holidays\";s:11:\"description\";s:30:\"Holidays for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"4589c06a1d68f541c71835e5aebcd28199f0aed0\";s:6:\"source\";s:43:\"https://github.com/NetCommons3/Holidays.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-17T05:15:56+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"Holidays\";s:4:\"name\";s:19:\"Netcommons Holidays\";s:10:\"commit_url\";s:85:\"https://github.com/NetCommons3/Holidays/tree/4589c06a1d68f541c71835e5aebcd28199f0aed0\";}',NULL,'2019-03-02 03:14:29',NULL,'2019-03-02 03:14:29'),(24,1,0,1,0,'holidays',NULL,'Holidays','netcommons/holidays',5,2,'dev-master','4589c06a1d68f541c71835e5aebcd28199f0aed0','2019-01-17 05:15:56','holidays/index','','',0,0,'a:14:{s:3:\"key\";s:8:\"holidays\";s:9:\"namespace\";s:19:\"netcommons/holidays\";s:11:\"description\";s:30:\"Holidays for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"4589c06a1d68f541c71835e5aebcd28199f0aed0\";s:6:\"source\";s:43:\"https://github.com/NetCommons3/Holidays.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-17T05:15:56+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"Holidays\";s:4:\"name\";s:19:\"Netcommons Holidays\";s:10:\"commit_url\";s:85:\"https://github.com/NetCommons3/Holidays/tree/4589c06a1d68f541c71835e5aebcd28199f0aed0\";}',NULL,'2019-03-02 03:14:29',NULL,'2019-03-02 03:14:29'),(25,2,1,1,0,'iframes',0,'iframe','netcommons/iframes',NULL,1,'dev-master','2af7896e233064e621df5a959c854071e8212e7f','2018-01-26 10:43:50','iframes/view','iframe_blocks/index','',0,0,'a:14:{s:3:\"key\";s:7:\"iframes\";s:9:\"namespace\";s:18:\"netcommons/iframes\";s:11:\"description\";s:29:\"Iframes for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"2af7896e233064e621df5a959c854071e8212e7f\";s:6:\"source\";s:42:\"https://github.com/NetCommons3/Iframes.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T10:43:50+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:7:\"Iframes\";s:4:\"name\";s:18:\"Netcommons Iframes\";s:10:\"commit_url\";s:84:\"https://github.com/NetCommons3/Iframes/tree/2af7896e233064e621df5a959c854071e8212e7f\";}',NULL,'2019-03-02 03:14:30',NULL,'2019-03-02 03:14:30'),(26,1,0,1,0,'iframes',0,'iframe','netcommons/iframes',NULL,1,'dev-master','2af7896e233064e621df5a959c854071e8212e7f','2018-01-26 10:43:50','iframes/view','iframe_blocks/index','',0,0,'a:14:{s:3:\"key\";s:7:\"iframes\";s:9:\"namespace\";s:18:\"netcommons/iframes\";s:11:\"description\";s:29:\"Iframes for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"2af7896e233064e621df5a959c854071e8212e7f\";s:6:\"source\";s:42:\"https://github.com/NetCommons3/Iframes.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T10:43:50+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:7:\"Iframes\";s:4:\"name\";s:18:\"Netcommons Iframes\";s:10:\"commit_url\";s:84:\"https://github.com/NetCommons3/Iframes/tree/2af7896e233064e621df5a959c854071e8212e7f\";}',NULL,'2019-03-02 03:14:30',NULL,'2019-03-02 03:14:30'),(27,2,1,1,0,'links',1,'リンクリスト','netcommons/links',NULL,1,'dev-master','7fcf1a0a8c5d747b9594de614c69f7df2abf31fd','2018-12-26 08:02:17','links/index','link_blocks/index','',1,1,'a:14:{s:3:\"key\";s:5:\"links\";s:9:\"namespace\";s:16:\"netcommons/links\";s:11:\"description\";s:27:\"Links for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"7fcf1a0a8c5d747b9594de614c69f7df2abf31fd\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Links.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-12-26T08:02:17+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Links\";s:4:\"name\";s:16:\"Netcommons Links\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Links/tree/7fcf1a0a8c5d747b9594de614c69f7df2abf31fd\";}',NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(28,1,0,1,0,'links',1,'Bookmark List','netcommons/links',NULL,1,'dev-master','7fcf1a0a8c5d747b9594de614c69f7df2abf31fd','2018-12-26 08:02:17','links/index','link_blocks/index','',1,1,'a:14:{s:3:\"key\";s:5:\"links\";s:9:\"namespace\";s:16:\"netcommons/links\";s:11:\"description\";s:27:\"Links for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"7fcf1a0a8c5d747b9594de614c69f7df2abf31fd\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Links.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-12-26T08:02:17+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Links\";s:4:\"name\";s:16:\"Netcommons Links\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Links/tree/7fcf1a0a8c5d747b9594de614c69f7df2abf31fd\";}',NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(29,2,1,1,0,'menus',0,'メニュー','netcommons/menus',NULL,1,'dev-master','7eb752346d1552623927a249c205a0f52ff506e2','2018-11-15 08:51:05','menus/index','menu_frame_settings/edit','',0,0,'a:14:{s:3:\"key\";s:5:\"menus\";s:9:\"namespace\";s:16:\"netcommons/menus\";s:11:\"description\";s:23:\"MenusPlugin for Cakephp\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"7eb752346d1552623927a249c205a0f52ff506e2\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Menus.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-11-15T08:51:05+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Menus\";s:4:\"name\";s:16:\"Netcommons Menus\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Menus/tree/7eb752346d1552623927a249c205a0f52ff506e2\";}',NULL,'2019-03-02 03:14:32',NULL,'2019-03-02 03:14:32'),(30,1,0,1,0,'menus',0,'Menu','netcommons/menus',NULL,1,'dev-master','7eb752346d1552623927a249c205a0f52ff506e2','2018-11-15 08:51:05','menus/index','menu_frame_settings/edit','',0,0,'a:14:{s:3:\"key\";s:5:\"menus\";s:9:\"namespace\";s:16:\"netcommons/menus\";s:11:\"description\";s:23:\"MenusPlugin for Cakephp\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"7eb752346d1552623927a249c205a0f52ff506e2\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Menus.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-11-15T08:51:05+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Menus\";s:4:\"name\";s:16:\"Netcommons Menus\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Menus/tree/7eb752346d1552623927a249c205a0f52ff506e2\";}',NULL,'2019-03-02 03:14:32',NULL,'2019-03-02 03:14:32'),(31,2,1,0,0,'multidatabases',1,'汎用データベース','netcommons/multidatabases',NULL,1,'dev-master','968095d436da57d7b6d633d098c400ee9ac0b7cc','2019-03-01 04:58:24','multidatabase_contents/index','multidatabase_blocks/index','',1,1,'a:14:{s:3:\"key\";s:14:\"multidatabases\";s:9:\"namespace\";s:25:\"netcommons/multidatabases\";s:11:\"description\";s:37:\"Multidatabases for NetCommons3 Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"968095d436da57d7b6d633d098c400ee9ac0b7cc\";s:6:\"source\";s:49:\"https://github.com/NetCommons3/Multidatabases.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:8:\"Ricksoft\";s:8:\"homepage\";s:24:\"https://www.ricksoft.jp/\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-03-01T04:58:24+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:14:\"Multidatabases\";s:4:\"name\";s:25:\"Netcommons Multidatabases\";s:10:\"commit_url\";s:91:\"https://github.com/NetCommons3/Multidatabases/tree/968095d436da57d7b6d633d098c400ee9ac0b7cc\";}',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(32,1,1,0,0,'multidatabases',1,'MultiDatabases','netcommons/multidatabases',NULL,1,'dev-master','968095d436da57d7b6d633d098c400ee9ac0b7cc','2019-03-01 04:58:24','multidatabase_contents/index','multidatabase_blocks/index','',1,1,'a:14:{s:3:\"key\";s:14:\"multidatabases\";s:9:\"namespace\";s:25:\"netcommons/multidatabases\";s:11:\"description\";s:37:\"Multidatabases for NetCommons3 Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"968095d436da57d7b6d633d098c400ee9ac0b7cc\";s:6:\"source\";s:49:\"https://github.com/NetCommons3/Multidatabases.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:8:\"Ricksoft\";s:8:\"homepage\";s:24:\"https://www.ricksoft.jp/\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-03-01T04:58:24+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:14:\"Multidatabases\";s:4:\"name\";s:25:\"Netcommons Multidatabases\";s:10:\"commit_url\";s:91:\"https://github.com/NetCommons3/Multidatabases/tree/968095d436da57d7b6d633d098c400ee9ac0b7cc\";}',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(33,2,1,0,0,'nc2_to_nc3',1,'NC2からの移行','netcommons/nc2-to-nc3',9,3,'dev-master','29e3f149d2cd78ad5d60fd8a729df78c3b71b353','2019-02-05 09:13:29','nc2_to_nc3/migration','','',0,0,'a:14:{s:3:\"key\";s:10:\"nc2_to_nc3\";s:9:\"namespace\";s:21:\"netcommons/nc2-to-nc3\";s:11:\"description\";s:31:\"Nc2ToNc3 Plugin for NetCommons3\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"29e3f149d2cd78ad5d60fd8a729df78c3b71b353\";s:6:\"source\";s:43:\"https://github.com/NetCommons3/Nc2ToNc3.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:4:{s:4:\"name\";s:10:\"kteraguchi\";s:5:\"email\";s:25:\"kteraguchi@commonsnet.org\";s:8:\"homepage\";s:29:\"https://github.com/kteraguchi\";s:4:\"role\";s:9:\"Developer\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-05T09:13:29+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"Nc2ToNc3\";s:4:\"name\";s:21:\"Netcommons Nc2-to-nc3\";s:10:\"commit_url\";s:85:\"https://github.com/NetCommons3/Nc2ToNc3/tree/29e3f149d2cd78ad5d60fd8a729df78c3b71b353\";}',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(34,1,1,0,0,'nc2_to_nc3',1,'Migration From NC2','netcommons/nc2-to-nc3',9,3,'dev-master','29e3f149d2cd78ad5d60fd8a729df78c3b71b353','2019-02-05 09:13:29','nc2_to_nc3/migration','','',0,0,'a:14:{s:3:\"key\";s:10:\"nc2_to_nc3\";s:9:\"namespace\";s:21:\"netcommons/nc2-to-nc3\";s:11:\"description\";s:31:\"Nc2ToNc3 Plugin for NetCommons3\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"29e3f149d2cd78ad5d60fd8a729df78c3b71b353\";s:6:\"source\";s:43:\"https://github.com/NetCommons3/Nc2ToNc3.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:4:{s:4:\"name\";s:10:\"kteraguchi\";s:5:\"email\";s:25:\"kteraguchi@commonsnet.org\";s:8:\"homepage\";s:29:\"https://github.com/kteraguchi\";s:4:\"role\";s:9:\"Developer\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-05T09:13:29+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"Nc2ToNc3\";s:4:\"name\";s:21:\"Netcommons Nc2-to-nc3\";s:10:\"commit_url\";s:85:\"https://github.com/NetCommons3/Nc2ToNc3/tree/29e3f149d2cd78ad5d60fd8a729df78c3b71b353\";}',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(35,2,1,1,0,'photo_albums',1,'フォトアルバム','netcommons/photo-albums',NULL,1,'dev-master','026b011f9058b3ec1cf86ce989aff0d9918be937','2019-01-06 06:47:03','photo_albums/index','photo_albums/setting','',0,0,'a:14:{s:3:\"key\";s:12:\"photo_albums\";s:9:\"namespace\";s:23:\"netcommons/photo-albums\";s:11:\"description\";s:33:\"PhotoAlbums for NetCommons Plugin\";s:8:\"homepage\";N;s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"026b011f9058b3ec1cf86ce989aff0d9918be937\";s:6:\"source\";s:46:\"https://github.com/NetCommons3/PhotoAlbums.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:15:\"Kohei Teraguchi\";s:5:\"email\";s:25:\"kteraguchi@commonsnet.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T06:47:03+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:11:\"PhotoAlbums\";s:4:\"name\";s:23:\"Netcommons Photo-albums\";s:10:\"commit_url\";s:88:\"https://github.com/NetCommons3/PhotoAlbums/tree/026b011f9058b3ec1cf86ce989aff0d9918be937\";}',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(36,1,0,1,0,'photo_albums',1,'Photo album','netcommons/photo-albums',NULL,1,'dev-master','026b011f9058b3ec1cf86ce989aff0d9918be937','2019-01-06 06:47:03','photo_albums/index','photo_albums/setting','',0,0,'a:14:{s:3:\"key\";s:12:\"photo_albums\";s:9:\"namespace\";s:23:\"netcommons/photo-albums\";s:11:\"description\";s:33:\"PhotoAlbums for NetCommons Plugin\";s:8:\"homepage\";N;s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"026b011f9058b3ec1cf86ce989aff0d9918be937\";s:6:\"source\";s:46:\"https://github.com/NetCommons3/PhotoAlbums.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:15:\"Kohei Teraguchi\";s:5:\"email\";s:25:\"kteraguchi@commonsnet.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T06:47:03+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:11:\"PhotoAlbums\";s:4:\"name\";s:23:\"Netcommons Photo-albums\";s:10:\"commit_url\";s:88:\"https://github.com/NetCommons3/PhotoAlbums/tree/026b011f9058b3ec1cf86ce989aff0d9918be937\";}',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(37,2,1,1,0,'questionnaires',1,'アンケート','netcommons/questionnaires',NULL,1,'dev-master','334643082157ff47a70ce964796799ecaab8c291','2019-03-01 09:31:00','questionnaires/index','questionnaire_blocks/index','',1,1,'a:14:{s:3:\"key\";s:14:\"questionnaires\";s:9:\"namespace\";s:25:\"netcommons/questionnaires\";s:11:\"description\";s:36:\"Questionnaires for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"334643082157ff47a70ce964796799ecaab8c291\";s:6:\"source\";s:49:\"https://github.com/NetCommons3/Questionnaires.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-03-01T09:31:00+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:14:\"Questionnaires\";s:4:\"name\";s:25:\"Netcommons Questionnaires\";s:10:\"commit_url\";s:91:\"https://github.com/NetCommons3/Questionnaires/tree/334643082157ff47a70ce964796799ecaab8c291\";}',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(38,1,0,1,0,'questionnaires',1,'Questionnaires','netcommons/questionnaires',NULL,1,'dev-master','334643082157ff47a70ce964796799ecaab8c291','2019-03-01 09:31:00','questionnaires/index','questionnaire_blocks/index','',1,1,'a:14:{s:3:\"key\";s:14:\"questionnaires\";s:9:\"namespace\";s:25:\"netcommons/questionnaires\";s:11:\"description\";s:36:\"Questionnaires for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"334643082157ff47a70ce964796799ecaab8c291\";s:6:\"source\";s:49:\"https://github.com/NetCommons3/Questionnaires.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-03-01T09:31:00+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:14:\"Questionnaires\";s:4:\"name\";s:25:\"Netcommons Questionnaires\";s:10:\"commit_url\";s:91:\"https://github.com/NetCommons3/Questionnaires/tree/334643082157ff47a70ce964796799ecaab8c291\";}',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(39,2,1,1,0,'quizzes',1,'小テスト','netcommons/quizzes',NULL,1,'dev-master','38234881de395297f49fa3600911be3ccf74681c','2019-01-23 09:07:07','quizzes/index','quiz_blocks/index','',1,1,'a:14:{s:3:\"key\";s:7:\"quizzes\";s:9:\"namespace\";s:18:\"netcommons/quizzes\";s:11:\"description\";s:29:\"Quizzes for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"38234881de395297f49fa3600911be3ccf74681c\";s:6:\"source\";s:42:\"https://github.com/NetCommons3/Quizzes.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:07:07+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:7:\"Quizzes\";s:4:\"name\";s:18:\"Netcommons Quizzes\";s:10:\"commit_url\";s:84:\"https://github.com/NetCommons3/Quizzes/tree/38234881de395297f49fa3600911be3ccf74681c\";}',NULL,'2019-03-02 03:14:36',NULL,'2019-03-02 03:14:36'),(40,1,0,1,0,'quizzes',1,'Quizzes','netcommons/quizzes',NULL,1,'dev-master','38234881de395297f49fa3600911be3ccf74681c','2019-01-23 09:07:07','quizzes/index','quiz_blocks/index','',1,1,'a:14:{s:3:\"key\";s:7:\"quizzes\";s:9:\"namespace\";s:18:\"netcommons/quizzes\";s:11:\"description\";s:29:\"Quizzes for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"38234881de395297f49fa3600911be3ccf74681c\";s:6:\"source\";s:42:\"https://github.com/NetCommons3/Quizzes.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:07:07+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:7:\"Quizzes\";s:4:\"name\";s:18:\"Netcommons Quizzes\";s:10:\"commit_url\";s:84:\"https://github.com/NetCommons3/Quizzes/tree/38234881de395297f49fa3600911be3ccf74681c\";}',NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(41,2,1,1,0,'registrations',1,'登録フォーム','netcommons/registrations',NULL,1,'dev-master','1d2365f07b41c2b8d914b2c3777aa7c3f34b7ff1','2019-01-23 09:07:59','registrations/index','registration_blocks/index','',1,1,'a:14:{s:3:\"key\";s:13:\"registrations\";s:9:\"namespace\";s:24:\"netcommons/registrations\";s:11:\"description\";s:35:\"Registrations for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"1d2365f07b41c2b8d914b2c3777aa7c3f34b7ff1\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/Registrations.git\";s:7:\"authors\";a:5:{i:0;a:4:{s:4:\"name\";s:23:\"Ryuji AMANO (RYUS INC.)\";s:5:\"email\";s:16:\"ryuji@ryus.co.jp\";s:8:\"homepage\";s:18:\"http://ryus.co.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:4;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:07:59+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"Registrations\";s:4:\"name\";s:24:\"Netcommons Registrations\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/Registrations/tree/1d2365f07b41c2b8d914b2c3777aa7c3f34b7ff1\";}',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(42,1,0,1,0,'registrations',1,'Registrations','netcommons/registrations',NULL,1,'dev-master','1d2365f07b41c2b8d914b2c3777aa7c3f34b7ff1','2019-01-23 09:07:59','registrations/index','registration_blocks/index','',1,1,'a:14:{s:3:\"key\";s:13:\"registrations\";s:9:\"namespace\";s:24:\"netcommons/registrations\";s:11:\"description\";s:35:\"Registrations for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"1d2365f07b41c2b8d914b2c3777aa7c3f34b7ff1\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/Registrations.git\";s:7:\"authors\";a:5:{i:0;a:4:{s:4:\"name\";s:23:\"Ryuji AMANO (RYUS INC.)\";s:5:\"email\";s:16:\"ryuji@ryus.co.jp\";s:8:\"homepage\";s:18:\"http://ryus.co.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:4;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:07:59+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"Registrations\";s:4:\"name\";s:24:\"Netcommons Registrations\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/Registrations/tree/1d2365f07b41c2b8d914b2c3777aa7c3f34b7ff1\";}',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(43,2,1,1,0,'reservations',1,'施設予約','netcommons/reservations',NULL,1,'dev-master','9ac55a62b11927878bbe1269436e7799cc279fa6','2018-12-12 04:49:49','reservations/index','reservation_frame_settings/edit','',1,1,'a:14:{s:3:\"key\";s:12:\"reservations\";s:9:\"namespace\";s:23:\"netcommons/reservations\";s:11:\"description\";s:34:\"Reservations for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"9ac55a62b11927878bbe1269436e7799cc279fa6\";s:6:\"source\";s:47:\"https://github.com/NetCommons3/Reservations.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-12-12T04:49:49+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:12:\"Reservations\";s:4:\"name\";s:23:\"Netcommons Reservations\";s:10:\"commit_url\";s:89:\"https://github.com/NetCommons3/Reservations/tree/9ac55a62b11927878bbe1269436e7799cc279fa6\";}',NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(44,1,0,1,0,'reservations',1,'RESERVATION','netcommons/reservations',NULL,1,'dev-master','9ac55a62b11927878bbe1269436e7799cc279fa6','2018-12-12 04:49:49','reservations/index','reservation_frame_settings/edit','',1,1,'a:14:{s:3:\"key\";s:12:\"reservations\";s:9:\"namespace\";s:23:\"netcommons/reservations\";s:11:\"description\";s:34:\"Reservations for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"9ac55a62b11927878bbe1269436e7799cc279fa6\";s:6:\"source\";s:47:\"https://github.com/NetCommons3/Reservations.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-12-12T04:49:49+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:12:\"Reservations\";s:4:\"name\";s:23:\"Netcommons Reservations\";s:10:\"commit_url\";s:89:\"https://github.com/NetCommons3/Reservations/tree/9ac55a62b11927878bbe1269436e7799cc279fa6\";}',NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(45,2,1,1,0,'rss_readers',0,'RSSリーダー','netcommons/rss-readers',1,1,'dev-master','a8237f5a86820b40c06c5f37147f61d661aebad0','2018-01-26 12:51:37','rss_readers/view','rss_reader_blocks/index','rss_readers/edit',1,1,'a:14:{s:3:\"key\";s:11:\"rss_readers\";s:9:\"namespace\";s:22:\"netcommons/rss-readers\";s:11:\"description\";s:32:\"RssReaders for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"a8237f5a86820b40c06c5f37147f61d661aebad0\";s:6:\"source\";s:45:\"https://github.com/NetCommons3/RssReaders.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T12:51:37+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:10:\"RssReaders\";s:4:\"name\";s:22:\"Netcommons Rss-readers\";s:10:\"commit_url\";s:87:\"https://github.com/NetCommons3/RssReaders/tree/a8237f5a86820b40c06c5f37147f61d661aebad0\";}',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(46,1,0,1,0,'rss_readers',0,'RSS Readers','netcommons/rss-readers',1,1,'dev-master','a8237f5a86820b40c06c5f37147f61d661aebad0','2018-01-26 12:51:37','rss_readers/view','rss_reader_blocks/index','rss_readers/edit',1,1,'a:14:{s:3:\"key\";s:11:\"rss_readers\";s:9:\"namespace\";s:22:\"netcommons/rss-readers\";s:11:\"description\";s:32:\"RssReaders for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"a8237f5a86820b40c06c5f37147f61d661aebad0\";s:6:\"source\";s:45:\"https://github.com/NetCommons3/RssReaders.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T12:51:37+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:10:\"RssReaders\";s:4:\"name\";s:22:\"Netcommons Rss-readers\";s:10:\"commit_url\";s:87:\"https://github.com/NetCommons3/RssReaders/tree/a8237f5a86820b40c06c5f37147f61d661aebad0\";}',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(47,2,1,1,0,'searches',0,'検索ボックス','netcommons/searches',NULL,1,'dev-master','7e7476faec1279af4f09c992d76ac42cbfdec7f4','2019-01-06 04:00:50','searches/index','search_frame_settings/edit','',0,0,'a:14:{s:3:\"key\";s:8:\"searches\";s:9:\"namespace\";s:19:\"netcommons/searches\";s:11:\"description\";s:30:\"Searches for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"7e7476faec1279af4f09c992d76ac42cbfdec7f4\";s:6:\"source\";s:43:\"https://github.com/NetCommons3/Searches.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T04:00:50+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"Searches\";s:4:\"name\";s:19:\"Netcommons Searches\";s:10:\"commit_url\";s:85:\"https://github.com/NetCommons3/Searches/tree/7e7476faec1279af4f09c992d76ac42cbfdec7f4\";}',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(48,1,0,1,0,'searches',0,'Search box','netcommons/searches',NULL,1,'dev-master','7e7476faec1279af4f09c992d76ac42cbfdec7f4','2019-01-06 04:00:50','searches/index','search_frame_settings/edit','',0,0,'a:14:{s:3:\"key\";s:8:\"searches\";s:9:\"namespace\";s:19:\"netcommons/searches\";s:11:\"description\";s:30:\"Searches for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"7e7476faec1279af4f09c992d76ac42cbfdec7f4\";s:6:\"source\";s:43:\"https://github.com/NetCommons3/Searches.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T04:00:50+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"Searches\";s:4:\"name\";s:19:\"Netcommons Searches\";s:10:\"commit_url\";s:85:\"https://github.com/NetCommons3/Searches/tree/7e7476faec1279af4f09c992d76ac42cbfdec7f4\";}',NULL,'2019-03-02 03:14:43',NULL,'2019-03-02 03:14:43'),(49,2,1,1,0,'system_manager',NULL,'システム管理','netcommons/system-manager',7,3,'dev-master','dffb12978561aba38accc881dac15a7e64efc9f8','2019-01-05 12:26:37','system_manager/edit','','',0,0,'a:14:{s:3:\"key\";s:14:\"system_manager\";s:9:\"namespace\";s:25:\"netcommons/system-manager\";s:11:\"description\";s:35:\"SystemManager for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"dffb12978561aba38accc881dac15a7e64efc9f8\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/SystemManager.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-05T12:26:37+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"SystemManager\";s:4:\"name\";s:25:\"Netcommons System-manager\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/SystemManager/tree/dffb12978561aba38accc881dac15a7e64efc9f8\";}',NULL,'2019-03-02 03:14:43',NULL,'2019-03-02 03:14:43'),(50,1,0,1,0,'system_manager',NULL,'System Controller','netcommons/system-manager',7,3,'dev-master','dffb12978561aba38accc881dac15a7e64efc9f8','2019-01-05 12:26:37','system_manager/edit','','',0,0,'a:14:{s:3:\"key\";s:14:\"system_manager\";s:9:\"namespace\";s:25:\"netcommons/system-manager\";s:11:\"description\";s:35:\"SystemManager for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"dffb12978561aba38accc881dac15a7e64efc9f8\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/SystemManager.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-05T12:26:37+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"SystemManager\";s:4:\"name\";s:25:\"Netcommons System-manager\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/SystemManager/tree/dffb12978561aba38accc881dac15a7e64efc9f8\";}',NULL,'2019-03-02 03:14:43',NULL,'2019-03-02 03:14:43'),(51,2,1,1,0,'tasks',1,'ToDo','netcommons/tasks',NULL,1,'dev-master','47fa31ba4d5cd0dc6bebf647153eb36c81c87c40','2019-01-23 09:08:52','task_contents/index','task_blocks/index','',1,1,'a:14:{s:3:\"key\";s:5:\"tasks\";s:9:\"namespace\";s:16:\"netcommons/tasks\";s:11:\"description\";s:27:\"Tasks for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"47fa31ba4d5cd0dc6bebf647153eb36c81c87c40\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Tasks.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:23:\"Yuto Kitatsuji(WithOne)\";s:5:\"email\";s:16:\"nc@withone.co.jp\";s:8:\"homepage\";s:24:\"http://www.withone.co.jp\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:08:52+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Tasks\";s:4:\"name\";s:16:\"Netcommons Tasks\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Tasks/tree/47fa31ba4d5cd0dc6bebf647153eb36c81c87c40\";}',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(52,1,0,1,0,'tasks',1,'ToDo','netcommons/tasks',NULL,1,'dev-master','47fa31ba4d5cd0dc6bebf647153eb36c81c87c40','2019-01-23 09:08:52','task_contents/index','task_blocks/index','',1,1,'a:14:{s:3:\"key\";s:5:\"tasks\";s:9:\"namespace\";s:16:\"netcommons/tasks\";s:11:\"description\";s:27:\"Tasks for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"47fa31ba4d5cd0dc6bebf647153eb36c81c87c40\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Tasks.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:23:\"Yuto Kitatsuji(WithOne)\";s:5:\"email\";s:16:\"nc@withone.co.jp\";s:8:\"homepage\";s:24:\"http://www.withone.co.jp\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T09:08:52+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Tasks\";s:4:\"name\";s:16:\"Netcommons Tasks\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Tasks/tree/47fa31ba4d5cd0dc6bebf647153eb36c81c87c40\";}',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(53,2,1,1,0,'topics',0,'新着','netcommons/topics',NULL,1,'dev-master','6eb3dcbb9d24327a851e8d4f42b68768940ce163','2019-01-06 04:00:41','topics/index','topic_frame_settings/edit','',0,0,'a:14:{s:3:\"key\";s:6:\"topics\";s:9:\"namespace\";s:17:\"netcommons/topics\";s:11:\"description\";s:28:\"Topics for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6eb3dcbb9d24327a851e8d4f42b68768940ce163\";s:6:\"source\";s:41:\"https://github.com/NetCommons3/Topics.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T04:00:41+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:6:\"Topics\";s:4:\"name\";s:17:\"Netcommons Topics\";s:10:\"commit_url\";s:83:\"https://github.com/NetCommons3/Topics/tree/6eb3dcbb9d24327a851e8d4f42b68768940ce163\";}',NULL,'2019-03-02 03:14:45',NULL,'2019-03-02 03:14:45'),(54,1,0,1,0,'topics',0,'What\'s new','netcommons/topics',NULL,1,'dev-master','6eb3dcbb9d24327a851e8d4f42b68768940ce163','2019-01-06 04:00:41','topics/index','topic_frame_settings/edit','',0,0,'a:14:{s:3:\"key\";s:6:\"topics\";s:9:\"namespace\";s:17:\"netcommons/topics\";s:11:\"description\";s:28:\"Topics for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6eb3dcbb9d24327a851e8d4f42b68768940ce163\";s:6:\"source\";s:41:\"https://github.com/NetCommons3/Topics.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T04:00:41+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:6:\"Topics\";s:4:\"name\";s:17:\"Netcommons Topics\";s:10:\"commit_url\";s:83:\"https://github.com/NetCommons3/Topics/tree/6eb3dcbb9d24327a851e8d4f42b68768940ce163\";}',NULL,'2019-03-02 03:14:45',NULL,'2019-03-02 03:14:45'),(55,2,1,1,0,'user_attributes',NULL,'会員項目設定','netcommons/user-attributes',4,2,'dev-master','1f5cb0507eb06ce6ed291dd24ee0566c78bd9653','2019-01-06 13:05:11','user_attributes/index','','',0,0,'a:14:{s:3:\"key\";s:15:\"user_attributes\";s:9:\"namespace\";s:26:\"netcommons/user-attributes\";s:11:\"description\";s:36:\"UserAttributes for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"1f5cb0507eb06ce6ed291dd24ee0566c78bd9653\";s:6:\"source\";s:49:\"https://github.com/NetCommons3/UserAttributes.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T13:05:11+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:14:\"UserAttributes\";s:4:\"name\";s:26:\"Netcommons User-attributes\";s:10:\"commit_url\";s:91:\"https://github.com/NetCommons3/UserAttributes/tree/1f5cb0507eb06ce6ed291dd24ee0566c78bd9653\";}',NULL,'2019-03-02 03:14:46',NULL,'2019-03-02 03:14:46'),(56,1,0,1,0,'user_attributes',NULL,'User attributes','netcommons/user-attributes',4,2,'dev-master','1f5cb0507eb06ce6ed291dd24ee0566c78bd9653','2019-01-06 13:05:11','user_attributes/index','','',0,0,'a:14:{s:3:\"key\";s:15:\"user_attributes\";s:9:\"namespace\";s:26:\"netcommons/user-attributes\";s:11:\"description\";s:36:\"UserAttributes for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"1f5cb0507eb06ce6ed291dd24ee0566c78bd9653\";s:6:\"source\";s:49:\"https://github.com/NetCommons3/UserAttributes.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T13:05:11+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:14:\"UserAttributes\";s:4:\"name\";s:26:\"Netcommons User-attributes\";s:10:\"commit_url\";s:91:\"https://github.com/NetCommons3/UserAttributes/tree/1f5cb0507eb06ce6ed291dd24ee0566c78bd9653\";}',NULL,'2019-03-02 03:14:46',NULL,'2019-03-02 03:14:46'),(57,2,1,1,0,'user_manager',NULL,'会員管理','netcommons/user-manager',1,2,'dev-master','50913bd448080875756efb97111b5d697dc2d3d7','2019-02-15 13:25:18','user_manager/index','','',0,0,'a:14:{s:3:\"key\";s:12:\"user_manager\";s:9:\"namespace\";s:23:\"netcommons/user-manager\";s:11:\"description\";s:33:\"UserManager for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"50913bd448080875756efb97111b5d697dc2d3d7\";s:6:\"source\";s:46:\"https://github.com/NetCommons3/UserManager.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-15T13:25:18+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:11:\"UserManager\";s:4:\"name\";s:23:\"Netcommons User-manager\";s:10:\"commit_url\";s:88:\"https://github.com/NetCommons3/UserManager/tree/50913bd448080875756efb97111b5d697dc2d3d7\";}',NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(58,1,0,1,0,'user_manager',NULL,'User Manager','netcommons/user-manager',1,2,'dev-master','50913bd448080875756efb97111b5d697dc2d3d7','2019-02-15 13:25:18','user_manager/index','','',0,0,'a:14:{s:3:\"key\";s:12:\"user_manager\";s:9:\"namespace\";s:23:\"netcommons/user-manager\";s:11:\"description\";s:33:\"UserManager for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"50913bd448080875756efb97111b5d697dc2d3d7\";s:6:\"source\";s:46:\"https://github.com/NetCommons3/UserManager.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-15T13:25:18+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:11:\"UserManager\";s:4:\"name\";s:23:\"Netcommons User-manager\";s:10:\"commit_url\";s:88:\"https://github.com/NetCommons3/UserManager/tree/50913bd448080875756efb97111b5d697dc2d3d7\";}',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(59,2,1,1,0,'user_roles',NULL,'権限管理','netcommons/user-roles',3,2,'dev-master','6cb025116fbd27c30fdb9d89ccdf8c3f657442de','2019-01-06 14:02:11','user_roles/index','','',0,0,'a:14:{s:3:\"key\";s:10:\"user_roles\";s:9:\"namespace\";s:21:\"netcommons/user-roles\";s:11:\"description\";s:31:\"UserRoles for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6cb025116fbd27c30fdb9d89ccdf8c3f657442de\";s:6:\"source\";s:44:\"https://github.com/NetCommons3/UserRoles.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T14:02:11+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:9:\"UserRoles\";s:4:\"name\";s:21:\"Netcommons User-roles\";s:10:\"commit_url\";s:86:\"https://github.com/NetCommons3/UserRoles/tree/6cb025116fbd27c30fdb9d89ccdf8c3f657442de\";}',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(60,1,0,1,0,'user_roles',NULL,'User Roles','netcommons/user-roles',3,2,'dev-master','6cb025116fbd27c30fdb9d89ccdf8c3f657442de','2019-01-06 14:02:11','user_roles/index','','',0,0,'a:14:{s:3:\"key\";s:10:\"user_roles\";s:9:\"namespace\";s:21:\"netcommons/user-roles\";s:11:\"description\";s:31:\"UserRoles for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6cb025116fbd27c30fdb9d89ccdf8c3f657442de\";s:6:\"source\";s:44:\"https://github.com/NetCommons3/UserRoles.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T14:02:11+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:9:\"UserRoles\";s:4:\"name\";s:21:\"Netcommons User-roles\";s:10:\"commit_url\";s:86:\"https://github.com/NetCommons3/UserRoles/tree/6cb025116fbd27c30fdb9d89ccdf8c3f657442de\";}',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(61,2,1,1,0,'videos',1,'動画','netcommons/videos',NULL,1,'dev-master','6d6e930aca565251b53e1f910a85fca12ae86c40','2019-02-06 09:19:55','videos/index','video_blocks/index','',1,1,'a:14:{s:3:\"key\";s:6:\"videos\";s:9:\"namespace\";s:17:\"netcommons/videos\";s:11:\"description\";s:28:\"Videos for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6d6e930aca565251b53e1f910a85fca12ae86c40\";s:6:\"source\";s:41:\"https://github.com/NetCommons3/Videos.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:38:\"Mitsuru Mutaguchi(OpenSource WorkShop)\";s:5:\"email\";s:32:\"mutaguchi@opensource-workshop.jp\";s:8:\"homepage\";s:31:\"https://opensource-workshop.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-06T09:19:55+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:6:\"Videos\";s:4:\"name\";s:17:\"Netcommons Videos\";s:10:\"commit_url\";s:83:\"https://github.com/NetCommons3/Videos/tree/6d6e930aca565251b53e1f910a85fca12ae86c40\";}',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(62,1,0,1,0,'videos',1,'Video','netcommons/videos',NULL,1,'dev-master','6d6e930aca565251b53e1f910a85fca12ae86c40','2019-02-06 09:19:55','videos/index','video_blocks/index','',1,1,'a:14:{s:3:\"key\";s:6:\"videos\";s:9:\"namespace\";s:17:\"netcommons/videos\";s:11:\"description\";s:28:\"Videos for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6d6e930aca565251b53e1f910a85fca12ae86c40\";s:6:\"source\";s:41:\"https://github.com/NetCommons3/Videos.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:38:\"Mitsuru Mutaguchi(OpenSource WorkShop)\";s:5:\"email\";s:32:\"mutaguchi@opensource-workshop.jp\";s:8:\"homepage\";s:31:\"https://opensource-workshop.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-06T09:19:55+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:6:\"Videos\";s:4:\"name\";s:17:\"Netcommons Videos\";s:10:\"commit_url\";s:83:\"https://github.com/NetCommons3/Videos/tree/6d6e930aca565251b53e1f910a85fca12ae86c40\";}',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(63,0,1,0,0,'migrations',NULL,'Cakedc Migrations','cakedc/migrations',NULL,6,'2.6.0','c8d868cab1a7146ecd9cebefbf948c7661b7b0db','2019-02-02 00:10:11','','','',0,0,'a:15:{s:3:\"key\";s:10:\"migrations\";s:9:\"namespace\";s:17:\"cakedc/migrations\";s:11:\"description\";s:29:\"Migrations Plugin for CakePHP\";s:8:\"homepage\";s:17:\"http://cakedc.com\";s:7:\"version\";s:5:\"2.6.0\";s:14:\"commit_version\";s:40:\"c8d868cab1a7146ecd9cebefbf948c7661b7b0db\";s:6:\"source\";s:45:\"https://github.com/NetCommons3/migrations.git\";s:7:\"authors\";a:1:{i:0;a:3:{s:4:\"name\";s:28:\"Cake Development Corporation\";s:5:\"email\";s:15:\"team@cakedc.com\";s:8:\"homepage\";s:17:\"http://cakedc.com\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2019-02-02T00:10:11+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:10:\"Migrations\";s:4:\"name\";s:17:\"Cakedc Migrations\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:87:\"https://github.com/NetCommons3/migrations/tree/c8d868cab1a7146ecd9cebefbf948c7661b7b0db\";}',NULL,'2019-03-02 03:14:50',NULL,'2019-03-02 03:14:50'),(64,0,1,0,0,'cakephp/cakephp',NULL,'cakephp/cakephp','cakephp/cakephp',NULL,6,'2.10.16','c4a51509c554a0762e8b4d9b3985fe042b445fe7','2019-03-01 02:45:41','','','',0,0,'a:15:{s:3:\"key\";s:15:\"cakephp/cakephp\";s:9:\"namespace\";s:15:\"cakephp/cakephp\";s:11:\"description\";s:21:\"The CakePHP framework\";s:8:\"homepage\";s:19:\"https://cakephp.org\";s:7:\"version\";s:7:\"2.10.16\";s:14:\"commit_version\";s:40:\"c4a51509c554a0762e8b4d9b3985fe042b445fe7\";s:6:\"source\";s:38:\"https://github.com/cakephp/cakephp.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:17:\"CakePHP Community\";s:8:\"homepage\";s:54:\"https://github.com/cakephp/cakephp/graphs/contributors\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2019-03-01T02:45:41+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:15:\"cakephp/cakephp\";s:4:\"name\";s:15:\"cakephp/cakephp\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:80:\"https://github.com/cakephp/cakephp/tree/c4a51509c554a0762e8b4d9b3985fe042b445fe7\";}',NULL,'2019-03-02 03:14:50',NULL,'2019-03-02 03:14:50'),(65,0,1,0,0,'debug_kit',NULL,'DebugKit','cakephp/debug_kit',NULL,6,'2.2.x-dev','80d87655dcbb8313a1816889f550714d179b01b7','2018-11-18 00:58:39','','','',0,0,'a:15:{s:3:\"key\";s:9:\"debug_kit\";s:9:\"namespace\";s:17:\"cakephp/debug_kit\";s:11:\"description\";s:17:\"CakePHP Debug Kit\";s:8:\"homepage\";s:36:\"https://github.com/cakephp/debug_kit\";s:7:\"version\";s:9:\"2.2.x-dev\";s:14:\"commit_version\";s:40:\"80d87655dcbb8313a1816889f550714d179b01b7\";s:6:\"source\";s:40:\"https://github.com/cakephp/debug_kit.git\";s:7:\"authors\";a:2:{i:0;a:3:{s:4:\"name\";s:10:\"Mark Story\";s:8:\"homepage\";s:21:\"http://mark-story.com\";s:4:\"role\";s:6:\"Author\";}i:1;a:2:{s:4:\"name\";s:17:\"CakePHP Community\";s:8:\"homepage\";s:56:\"https://github.com/cakephp/debug_kit/graphs/contributors\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2018-11-18T00:58:39+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"DebugKit\";s:4:\"name\";s:8:\"DebugKit\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:82:\"https://github.com/cakephp/debug_kit/tree/80d87655dcbb8313a1816889f550714d179b01b7\";}',NULL,'2019-03-02 03:14:50',NULL,'2019-03-02 03:14:50'),(66,0,1,0,0,'mobile_detect',NULL,'Chronon Mobile Detect','chronon/mobile_detect',NULL,6,'dev-master','01be8fbdac64136dd9bc1aa6cf70e361acc238e8','2015-05-31 18:32:43','','','',0,0,'a:15:{s:3:\"key\";s:13:\"mobile_detect\";s:9:\"namespace\";s:21:\"chronon/mobile_detect\";s:11:\"description\";s:90:\"A CakePHP plugin component for identifying mobile devices using the Mobile_Detect project.\";s:8:\"homepage\";s:63:\"https://github.com/chronon/CakePHP-MobileDetectComponent-Plugin\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"01be8fbdac64136dd9bc1aa6cf70e361acc238e8\";s:6:\"source\";s:67:\"https://github.com/chronon/CakePHP-MobileDetectComponent-Plugin.git\";s:7:\"authors\";a:1:{i:0;a:4:{s:4:\"name\";s:15:\"Gregory Gaskill\";s:5:\"email\";s:15:\"one@chronon.com\";s:8:\"homepage\";s:22:\"http://technokracy.net\";s:4:\"role\";s:9:\"Developer\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2015-05-31T18:32:43+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:12:\"MobileDetect\";s:4:\"name\";s:21:\"Chronon Mobile Detect\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:109:\"https://github.com/chronon/CakePHP-MobileDetectComponent-Plugin/tree/01be8fbdac64136dd9bc1aa6cf70e361acc238e8\";}',NULL,'2019-03-02 03:14:50',NULL,'2019-03-02 03:14:50'),(67,0,1,0,0,'composer/installers',NULL,'composer/installers','composer/installers',NULL,6,'dev-master','5d51c2c61a0a66e312057bb14c74b8a93c9a528f','2019-01-25 07:48:56','','','',0,0,'a:15:{s:3:\"key\";s:19:\"composer/installers\";s:9:\"namespace\";s:19:\"composer/installers\";s:11:\"description\";s:44:\"A multi-framework Composer library installer\";s:8:\"homepage\";s:38:\"https://composer.github.io/installers/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"5d51c2c61a0a66e312057bb14c74b8a93c9a528f\";s:6:\"source\";s:42:\"https://github.com/composer/installers.git\";s:7:\"authors\";a:1:{i:0;a:3:{s:4:\"name\";s:19:\"Kyle Robinson Young\";s:5:\"email\";s:16:\"kyle@dontkry.com\";s:8:\"homepage\";s:24:\"https://github.com/shama\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2019-01-25T07:48:56+00:00\";s:11:\"packageType\";s:15:\"composer-plugin\";s:14:\"originalSource\";s:19:\"composer/installers\";s:4:\"name\";s:19:\"composer/installers\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:84:\"https://github.com/composer/installers/tree/5d51c2c61a0a66e312057bb14c74b8a93c9a528f\";}',NULL,'2019-03-02 03:14:50',NULL,'2019-03-02 03:14:50'),(68,0,1,0,0,'doctrine/annotations',NULL,'doctrine/annotations','doctrine/annotations',NULL,6,'v1.2.7','f25c8aab83e0c3e976fd7d19875f198ccf2f7535','2015-08-31 12:32:49','','','',0,0,'a:15:{s:3:\"key\";s:20:\"doctrine/annotations\";s:9:\"namespace\";s:20:\"doctrine/annotations\";s:11:\"description\";s:27:\"Docblock Annotations Parser\";s:8:\"homepage\";s:31:\"http://www.doctrine-project.org\";s:7:\"version\";s:6:\"v1.2.7\";s:14:\"commit_version\";s:40:\"f25c8aab83e0c3e976fd7d19875f198ccf2f7535\";s:6:\"source\";s:43:\"https://github.com/doctrine/annotations.git\";s:7:\"authors\";a:5:{i:0;a:2:{s:4:\"name\";s:14:\"Roman Borschel\";s:5:\"email\";s:22:\"roman@code-factory.org\";}i:1;a:2:{s:4:\"name\";s:16:\"Benjamin Eberlei\";s:5:\"email\";s:19:\"kontakt@beberlei.de\";}i:2;a:2:{s:4:\"name\";s:16:\"Guilherme Blanco\";s:5:\"email\";s:25:\"guilhermeblanco@gmail.com\";}i:3;a:2:{s:4:\"name\";s:13:\"Jonathan Wage\";s:5:\"email\";s:17:\"jonwage@gmail.com\";}i:4;a:2:{s:4:\"name\";s:16:\"Johannes Schmitt\";s:5:\"email\";s:20:\"schmittjoh@gmail.com\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2015-08-31T12:32:49+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:20:\"doctrine/annotations\";s:4:\"name\";s:20:\"doctrine/annotations\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:85:\"https://github.com/doctrine/annotations/tree/f25c8aab83e0c3e976fd7d19875f198ccf2f7535\";}',NULL,'2019-03-02 03:14:50',NULL,'2019-03-02 03:14:50'),(69,0,1,0,0,'doctrine/instantiator',NULL,'doctrine/instantiator','doctrine/instantiator',NULL,6,'1.0.x-dev','83b5716aee90e1f733512942c635ac350cbd533c','2018-09-01 02:07:49','','','',0,0,'a:15:{s:3:\"key\";s:21:\"doctrine/instantiator\";s:9:\"namespace\";s:21:\"doctrine/instantiator\";s:11:\"description\";s:94:\"A small, lightweight utility to instantiate objects in PHP without invoking their constructors\";s:8:\"homepage\";s:40:\"https://github.com/doctrine/instantiator\";s:7:\"version\";s:9:\"1.0.x-dev\";s:14:\"commit_version\";s:40:\"83b5716aee90e1f733512942c635ac350cbd533c\";s:6:\"source\";s:44:\"https://github.com/doctrine/instantiator.git\";s:7:\"authors\";a:1:{i:0;a:3:{s:4:\"name\";s:13:\"Marco Pivetta\";s:5:\"email\";s:18:\"ocramius@gmail.com\";s:8:\"homepage\";s:27:\"http://ocramius.github.com/\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2018-09-01T02:07:49+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:21:\"doctrine/instantiator\";s:4:\"name\";s:21:\"doctrine/instantiator\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:86:\"https://github.com/doctrine/instantiator/tree/83b5716aee90e1f733512942c635ac350cbd533c\";}',NULL,'2019-03-02 03:14:50',NULL,'2019-03-02 03:14:50'),(70,0,1,0,0,'doctrine/lexer',NULL,'doctrine/lexer','doctrine/lexer',NULL,6,'dev-master','4ab6ea7c838ccb340883fd78915af079949cc64d','2018-10-21 19:22:05','','','',0,0,'a:15:{s:3:\"key\";s:14:\"doctrine/lexer\";s:9:\"namespace\";s:14:\"doctrine/lexer\";s:11:\"description\";s:90:\"PHP Doctrine Lexer parser library that can be used in Top-Down, Recursive Descent Parsers.\";s:8:\"homepage\";s:52:\"https://www.doctrine-project.org/projects/lexer.html\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"4ab6ea7c838ccb340883fd78915af079949cc64d\";s:6:\"source\";s:37:\"https://github.com/doctrine/lexer.git\";s:7:\"authors\";a:3:{i:0;a:2:{s:4:\"name\";s:14:\"Roman Borschel\";s:5:\"email\";s:22:\"roman@code-factory.org\";}i:1;a:2:{s:4:\"name\";s:16:\"Guilherme Blanco\";s:5:\"email\";s:25:\"guilhermeblanco@gmail.com\";}i:2;a:2:{s:4:\"name\";s:16:\"Johannes Schmitt\";s:5:\"email\";s:20:\"schmittjoh@gmail.com\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2018-10-21T19:22:05+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:14:\"doctrine/lexer\";s:4:\"name\";s:14:\"doctrine/lexer\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:79:\"https://github.com/doctrine/lexer/tree/4ab6ea7c838ccb340883fd78915af079949cc64d\";}',NULL,'2019-03-02 03:14:50',NULL,'2019-03-02 03:14:50'),(71,0,1,0,0,'emotionloop/visualcaptcha',NULL,'emotionloop/visualcaptcha','emotionloop/visualcaptcha',NULL,6,'0.0.4','fd1bcd8c3571aecefc1a1eedb8c76a61da031b56','2015-01-14 01:15:20','','','',0,0,'a:15:{s:3:\"key\";s:25:\"emotionloop/visualcaptcha\";s:9:\"namespace\";s:25:\"emotionloop/visualcaptcha\";s:11:\"description\";s:82:\"PHP library for visualCaptcha. Still requires you to have the front-end companion.\";s:8:\"homepage\";s:24:\"http://visualcaptcha.net\";s:7:\"version\";s:5:\"0.0.4\";s:14:\"commit_version\";s:40:\"fd1bcd8c3571aecefc1a1eedb8c76a61da031b56\";s:6:\"source\";s:58:\"https://github.com/emotionLoop/visualCaptcha-packagist.git\";s:7:\"authors\";a:1:{i:0;a:3:{s:4:\"name\";s:11:\"emotionLoop\";s:5:\"email\";s:21:\"hello@emotionloop.com\";s:8:\"homepage\";s:22:\"http://emotionloop.com\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2015-01-14T01:15:20+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:25:\"emotionloop/visualcaptcha\";s:4:\"name\";s:25:\"emotionloop/visualcaptcha\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:100:\"https://github.com/emotionLoop/visualCaptcha-packagist/tree/fd1bcd8c3571aecefc1a1eedb8c76a61da031b56\";}',NULL,'2019-03-02 03:14:50',NULL,'2019-03-02 03:14:50'),(72,0,1,0,0,'ezyang/htmlpurifier',NULL,'ezyang/htmlpurifier','ezyang/htmlpurifier',NULL,6,'v4.10.0','d85d39da4576a6934b72480be6978fb10c860021','2018-02-23 01:58:20','','','',0,0,'a:15:{s:3:\"key\";s:19:\"ezyang/htmlpurifier\";s:9:\"namespace\";s:19:\"ezyang/htmlpurifier\";s:11:\"description\";s:46:\"Standards compliant HTML filter written in PHP\";s:8:\"homepage\";s:24:\"http://htmlpurifier.org/\";s:7:\"version\";s:7:\"v4.10.0\";s:14:\"commit_version\";s:40:\"d85d39da4576a6934b72480be6978fb10c860021\";s:6:\"source\";s:42:\"https://github.com/ezyang/htmlpurifier.git\";s:7:\"authors\";a:1:{i:0;a:3:{s:4:\"name\";s:14:\"Edward Z. Yang\";s:5:\"email\";s:22:\"admin@htmlpurifier.org\";s:8:\"homepage\";s:17:\"http://ezyang.com\";}}s:7:\"license\";a:1:{i:0;s:4:\"LGPL\";}s:8:\"commited\";s:25:\"2018-02-23T01:58:20+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:19:\"ezyang/htmlpurifier\";s:4:\"name\";s:19:\"ezyang/htmlpurifier\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:84:\"https://github.com/ezyang/htmlpurifier/tree/d85d39da4576a6934b72480be6978fb10c860021\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(73,0,1,0,0,'jms/metadata',NULL,'jms/metadata','jms/metadata',NULL,6,'1.x-dev','e5854ab1aa643623dc64adde718a8eec32b957a8','2018-10-26 12:40:10','','','',0,0,'a:15:{s:3:\"key\";s:12:\"jms/metadata\";s:9:\"namespace\";s:12:\"jms/metadata\";s:11:\"description\";s:48:\"Class/method/property metadata management in PHP\";s:8:\"homepage\";N;s:7:\"version\";s:7:\"1.x-dev\";s:14:\"commit_version\";s:40:\"e5854ab1aa643623dc64adde718a8eec32b957a8\";s:6:\"source\";s:42:\"https://github.com/schmittjoh/metadata.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:14:\"Asmir Mustafic\";s:5:\"email\";s:16:\"goetas@gmail.com\";}i:1;a:2:{s:4:\"name\";s:19:\"Johannes M. Schmitt\";s:5:\"email\";s:20:\"schmittjoh@gmail.com\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2018-10-26T12:40:10+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:12:\"jms/metadata\";s:4:\"name\";s:12:\"jms/metadata\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:84:\"https://github.com/schmittjoh/metadata/tree/e5854ab1aa643623dc64adde718a8eec32b957a8\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(74,0,1,0,0,'jms/parser-lib',NULL,'jms/parser-lib','jms/parser-lib',NULL,6,'dev-master','6067cc609074ae215b96dc51047affee65f77b0f','2014-07-08 16:40:41','','','',0,0,'a:15:{s:3:\"key\";s:14:\"jms/parser-lib\";s:9:\"namespace\";s:14:\"jms/parser-lib\";s:11:\"description\";s:56:\"A library for easily creating recursive-descent parsers.\";s:8:\"homepage\";N;s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6067cc609074ae215b96dc51047affee65f77b0f\";s:6:\"source\";s:44:\"https://github.com/schmittjoh/parser-lib.git\";s:7:\"authors\";N;s:7:\"license\";a:1:{i:0;s:7:\"Apache2\";}s:8:\"commited\";s:25:\"2014-07-08T16:40:41+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:14:\"jms/parser-lib\";s:4:\"name\";s:14:\"jms/parser-lib\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:86:\"https://github.com/schmittjoh/parser-lib/tree/6067cc609074ae215b96dc51047affee65f77b0f\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(75,0,1,0,0,'jms/serializer',NULL,'jms/serializer','jms/serializer',NULL,6,'1.1.0','fe13a1f993ea3456e195b7820692f2eb2b6bbb48','2015-10-27 09:24:41','','','',0,0,'a:15:{s:3:\"key\";s:14:\"jms/serializer\";s:9:\"namespace\";s:14:\"jms/serializer\";s:11:\"description\";s:82:\"Library for (de-)serializing data of any complexity; supports XML, JSON, and YAML.\";s:8:\"homepage\";s:33:\"http://jmsyst.com/libs/serializer\";s:7:\"version\";s:5:\"1.1.0\";s:14:\"commit_version\";s:40:\"fe13a1f993ea3456e195b7820692f2eb2b6bbb48\";s:6:\"source\";s:44:\"https://github.com/schmittjoh/serializer.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:19:\"Johannes M. Schmitt\";s:5:\"email\";s:20:\"schmittjoh@gmail.com\";}}s:7:\"license\";a:1:{i:0;s:7:\"Apache2\";}s:8:\"commited\";s:25:\"2015-10-27T09:24:41+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:14:\"jms/serializer\";s:4:\"name\";s:14:\"jms/serializer\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:86:\"https://github.com/schmittjoh/serializer/tree/fe13a1f993ea3456e195b7820692f2eb2b6bbb48\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(76,0,1,0,0,'upload',NULL,'Upload','josegonzalez/cakephp-upload',NULL,6,'1.3.1','8407584cf63101c67cf6453b05a0fa3ddce95cd4','2016-04-21 12:15:21','','','',0,0,'a:15:{s:3:\"key\";s:6:\"upload\";s:9:\"namespace\";s:27:\"josegonzalez/cakephp-upload\";s:11:\"description\";s:65:\"CakePHP plugin to handle file uploading sans ridiculous automagic\";s:8:\"homepage\";s:45:\"http://github.com/josegonzalez/cakephp-upload\";s:7:\"version\";s:5:\"1.3.1\";s:14:\"commit_version\";s:40:\"8407584cf63101c67cf6453b05a0fa3ddce95cd4\";s:6:\"source\";s:51:\"https://github.com/FriendsOfCake/cakephp-upload.git\";s:7:\"authors\";a:25:{i:0;a:3:{s:4:\"name\";s:13:\"Joshua Paling\";s:8:\"homepage\";s:31:\"https://github.com/joshuapaling\";s:4:\"role\";s:11:\"Contributor\";}i:1;a:3:{s:4:\"name\";s:6:\"sdoney\";s:8:\"homepage\";s:25:\"https://github.com/sdoney\";s:4:\"role\";s:11:\"Contributor\";}i:2;a:3:{s:4:\"name\";s:10:\"Giuliano B\";s:8:\"homepage\";s:28:\"https://github.com/giulianob\";s:4:\"role\";s:11:\"Contributor\";}i:3;a:3:{s:4:\"name\";s:13:\"Justin Slamka\";s:8:\"homepage\";s:27:\"https://github.com/slamkajs\";s:4:\"role\";s:11:\"Contributor\";}i:4;a:3:{s:4:\"name\";s:12:\"Nathan Tyler\";s:8:\"homepage\";s:31:\"https://github.com/tylerdigital\";s:4:\"role\";s:11:\"Contributor\";}i:5;a:3:{s:4:\"name\";s:16:\"Mirko Chialastri\";s:8:\"homepage\";s:26:\"https://github.com/hiryu85\";s:4:\"role\";s:11:\"Contributor\";}i:6;a:3:{s:4:\"name\";s:16:\"Benjamin Allison\";s:8:\"homepage\";s:34:\"https://github.com/benjaminallison\";s:4:\"role\";s:11:\"Contributor\";}i:7;a:3:{s:4:\"name\";s:15:\"Ariel Patschiki\";s:8:\"homepage\";s:27:\"https://github.com/arielpts\";s:4:\"role\";s:11:\"Contributor\";}i:8;a:3:{s:4:\"name\";s:10:\"lucfranken\";s:8:\"homepage\";s:29:\"https://github.com/lucfranken\";s:4:\"role\";s:11:\"Contributor\";}i:9;a:3:{s:4:\"name\";s:7:\"cpierce\";s:8:\"homepage\";s:26:\"https://github.com/cpierce\";s:4:\"role\";s:11:\"Contributor\";}i:10;a:3:{s:4:\"name\";s:13:\"Barry Chapman\";s:8:\"homepage\";s:31:\"https://github.com/barrychapman\";s:4:\"role\";s:11:\"Contributor\";}i:11;a:3:{s:4:\"name\";s:15:\"Thomas Edvalson\";s:8:\"homepage\";s:24:\"https://github.com/Cruel\";s:4:\"role\";s:11:\"Contributor\";}i:12;a:3:{s:4:\"name\";s:16:\"Alejandro Ibarra\";s:8:\"homepage\";s:27:\"https://github.com/ajibarra\";s:4:\"role\";s:11:\"Contributor\";}i:13;a:3:{s:4:\"name\";s:9:\"simkimsia\";s:8:\"homepage\";s:28:\"https://github.com/simkimsia\";s:4:\"role\";s:11:\"Contributor\";}i:14;a:3:{s:4:\"name\";s:16:\"Callum Macdonald\";s:8:\"homepage\";s:24:\"https://github.com/chmac\";s:4:\"role\";s:11:\"Contributor\";}i:15;a:3:{s:4:\"name\";s:14:\"David Kullmann\";s:8:\"homepage\";s:28:\"https://github.com/dkullmann\";s:4:\"role\";s:11:\"Contributor\";}i:16;a:3:{s:4:\"name\";s:10:\"Juan Basso\";s:8:\"homepage\";s:26:\"https://github.com/jrbasso\";s:4:\"role\";s:11:\"Contributor\";}i:17;a:3:{s:4:\"name\";s:12:\"Cauan Cabral\";s:8:\"homepage\";s:30:\"https://github.com/CauanCabral\";s:4:\"role\";s:11:\"Contributor\";}i:18;a:3:{s:4:\"name\";s:11:\"Bryan Crowe\";s:8:\"homepage\";s:25:\"https://github.com/bcrowe\";s:4:\"role\";s:11:\"Contributor\";}i:19;a:3:{s:4:\"name\";s:11:\"Simon Brown\";s:8:\"homepage\";s:24:\"https://github.com/Simes\";s:4:\"role\";s:11:\"Contributor\";}i:20;a:3:{s:4:\"name\";s:12:\"wilsolutions\";s:8:\"homepage\";s:31:\"https://github.com/wilsolutions\";s:4:\"role\";s:11:\"Contributor\";}i:21;a:3:{s:4:\"name\";s:13:\"Graham Watson\";s:8:\"homepage\";s:32:\"https://github.com/PhantomWatson\";s:4:\"role\";s:11:\"Contributor\";}i:22;a:3:{s:4:\"name\";s:8:\"ceallred\";s:8:\"homepage\";s:27:\"https://github.com/ceallred\";s:4:\"role\";s:11:\"Contributor\";}i:23;a:4:{s:4:\"name\";s:18:\"Jose Diaz-Gonzalez\";s:5:\"email\";s:26:\"email@josediazgonzalez.com\";s:8:\"homepage\";s:27:\"http://josediazgonzalez.com\";s:4:\"role\";s:10:\"Maintainer\";}i:24;a:3:{s:4:\"name\";s:11:\"Marc Würth\";s:8:\"homepage\";s:27:\"https://github.com/ravage84\";s:4:\"role\";s:11:\"Contributor\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2016-04-21T12:15:21+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:6:\"Upload\";s:4:\"name\";s:6:\"Upload\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:93:\"https://github.com/FriendsOfCake/cakephp-upload/tree/8407584cf63101c67cf6453b05a0fa3ddce95cd4\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(77,0,1,0,0,'mobiledetect/mobiledetectlib',NULL,'mobiledetect/mobiledetectlib','mobiledetect/mobiledetectlib',NULL,6,'2.8.33','cd385290f9a0d609d2eddd165a1e44ec1bf12102','2018-09-01 15:05:15','','','',0,0,'a:15:{s:3:\"key\";s:28:\"mobiledetect/mobiledetectlib\";s:9:\"namespace\";s:28:\"mobiledetect/mobiledetectlib\";s:11:\"description\";s:170:\"Mobile_Detect is a lightweight PHP class for detecting mobile devices. It uses the User-Agent string combined with specific HTTP headers to detect the mobile environment.\";s:8:\"homepage\";s:44:\"https://github.com/serbanghita/Mobile-Detect\";s:7:\"version\";s:6:\"2.8.33\";s:14:\"commit_version\";s:40:\"cd385290f9a0d609d2eddd165a1e44ec1bf12102\";s:6:\"source\";s:48:\"https://github.com/serbanghita/Mobile-Detect.git\";s:7:\"authors\";a:1:{i:0;a:4:{s:4:\"name\";s:12:\"Serban Ghita\";s:5:\"email\";s:21:\"serbanghita@gmail.com\";s:8:\"homepage\";s:23:\"http://mobiledetect.net\";s:4:\"role\";s:9:\"Developer\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2018-09-01T15:05:15+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:28:\"mobiledetect/mobiledetectlib\";s:4:\"name\";s:28:\"mobiledetect/mobiledetectlib\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:90:\"https://github.com/serbanghita/Mobile-Detect/tree/cd385290f9a0d609d2eddd165a1e44ec1bf12102\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(78,0,1,0,0,'mustangostang/spyc',NULL,'mustangostang/spyc','mustangostang/spyc',NULL,6,'0.6.2','23c35ae854d835f2d7bcc3e3ad743d7e57a8c14d','2017-02-24 16:06:33','','','',0,0,'a:15:{s:3:\"key\";s:18:\"mustangostang/spyc\";s:9:\"namespace\";s:18:\"mustangostang/spyc\";s:11:\"description\";s:41:\"A simple YAML loader/dumper class for PHP\";s:8:\"homepage\";s:38:\"https://github.com/mustangostang/spyc/\";s:7:\"version\";s:5:\"0.6.2\";s:14:\"commit_version\";s:40:\"23c35ae854d835f2d7bcc3e3ad743d7e57a8c14d\";s:6:\"source\";s:41:\"https://github.com/mustangostang/spyc.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:13:\"mustangostang\";s:5:\"email\";s:23:\"vlad.andersen@gmail.com\";}}s:7:\"license\";a:1:{i:0;s:3:\"MIT\";}s:8:\"commited\";s:25:\"2017-02-24T16:06:33+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:18:\"mustangostang/spyc\";s:4:\"name\";s:18:\"mustangostang/spyc\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:83:\"https://github.com/mustangostang/spyc/tree/23c35ae854d835f2d7bcc3e3ad743d7e57a8c14d\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(79,0,1,0,0,'auth',NULL,'Netcommons Auth','netcommons/auth',NULL,0,'dev-master','ff0ad3741731fbfefcea3d22027fbe10aed49ce5','2019-01-23 16:15:47','','','',0,0,'a:14:{s:3:\"key\";s:4:\"auth\";s:9:\"namespace\";s:15:\"netcommons/auth\";s:11:\"description\";s:23:\"Auth Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"ff0ad3741731fbfefcea3d22027fbe10aed49ce5\";s:6:\"source\";s:39:\"https://github.com/NetCommons3/Auth.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-23T16:15:47+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:4:\"Auth\";s:4:\"name\";s:15:\"Netcommons Auth\";s:10:\"commit_url\";s:81:\"https://github.com/NetCommons3/Auth/tree/ff0ad3741731fbfefcea3d22027fbe10aed49ce5\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(80,0,1,0,0,'auth_general',NULL,'Netcommons Auth-general','netcommons/auth-general',NULL,0,'dev-master','cd946f8c2983686d6f98c49625aebefa20414a52','2019-01-01 07:41:33','','','',0,0,'a:14:{s:3:\"key\";s:12:\"auth_general\";s:9:\"namespace\";s:23:\"netcommons/auth-general\";s:11:\"description\";s:31:\"General Auth Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"cd946f8c2983686d6f98c49625aebefa20414a52\";s:6:\"source\";s:46:\"https://github.com/NetCommons3/AuthGeneral.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-01T07:41:33+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:11:\"AuthGeneral\";s:4:\"name\";s:23:\"Netcommons Auth-general\";s:10:\"commit_url\";s:88:\"https://github.com/NetCommons3/AuthGeneral/tree/cd946f8c2983686d6f98c49625aebefa20414a52\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(81,0,1,0,0,'authorization_keys',NULL,'Netcommons Authorization-keys','netcommons/authorization-keys',NULL,0,'dev-master','c2072ecda68a2f99b1cdafb014e00a4468e83d76','2018-01-26 07:45:40','','','',0,0,'a:14:{s:3:\"key\";s:18:\"authorization_keys\";s:9:\"namespace\";s:29:\"netcommons/authorization-keys\";s:11:\"description\";s:39:\"AuthorizationKeys for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"c2072ecda68a2f99b1cdafb014e00a4468e83d76\";s:6:\"source\";s:52:\"https://github.com/NetCommons3/AuthorizationKeys.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T07:45:40+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:17:\"AuthorizationKeys\";s:4:\"name\";s:29:\"Netcommons Authorization-keys\";s:10:\"commit_url\";s:94:\"https://github.com/NetCommons3/AuthorizationKeys/tree/c2072ecda68a2f99b1cdafb014e00a4468e83d76\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(82,0,1,0,0,'blocks',NULL,'Netcommons Blocks','netcommons/blocks',NULL,0,'dev-improve_performance_current','3a6a6a90830a4fe05310ce4f563228145670d293','2019-02-27 07:15:21','','','',0,0,'a:14:{s:3:\"key\";s:6:\"blocks\";s:9:\"namespace\";s:17:\"netcommons/blocks\";s:11:\"description\";s:28:\"Blocks for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:31:\"dev-improve_performance_current\";s:14:\"commit_version\";s:40:\"3a6a6a90830a4fe05310ce4f563228145670d293\";s:6:\"source\";s:41:\"https://github.com/NetCommons3/Blocks.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-27T07:15:21+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:6:\"Blocks\";s:4:\"name\";s:17:\"Netcommons Blocks\";s:10:\"commit_url\";s:83:\"https://github.com/NetCommons3/Blocks/tree/3a6a6a90830a4fe05310ce4f563228145670d293\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(83,0,1,0,0,'boxes',NULL,'Netcommons Boxes','netcommons/boxes',NULL,0,'dev-improve_performance_current','cfb063886be5016832de9297c7d34f9e0fc025cd','2019-03-02 00:43:08','','','',0,0,'a:14:{s:3:\"key\";s:5:\"boxes\";s:9:\"namespace\";s:16:\"netcommons/boxes\";s:11:\"description\";s:24:\"Boxes Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:31:\"dev-improve_performance_current\";s:14:\"commit_version\";s:40:\"cfb063886be5016832de9297c7d34f9e0fc025cd\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Boxes.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-03-02T00:43:08+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Boxes\";s:4:\"name\";s:16:\"Netcommons Boxes\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Boxes/tree/cfb063886be5016832de9297c7d34f9e0fc025cd\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(84,0,1,0,0,'categories',NULL,'Netcommons Categories','netcommons/categories',NULL,0,'dev-master','9e50d61244ce18615974385268151c9335a3b91b','2019-01-05 08:40:48','','','',0,0,'a:14:{s:3:\"key\";s:10:\"categories\";s:9:\"namespace\";s:21:\"netcommons/categories\";s:11:\"description\";s:32:\"Categories for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"9e50d61244ce18615974385268151c9335a3b91b\";s:6:\"source\";s:45:\"https://github.com/NetCommons3/Categories.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-05T08:40:48+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:10:\"Categories\";s:4:\"name\";s:21:\"Netcommons Categories\";s:10:\"commit_url\";s:87:\"https://github.com/NetCommons3/Categories/tree/9e50d61244ce18615974385268151c9335a3b91b\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(85,0,1,0,0,'community_space',NULL,'Netcommons Community-space','netcommons/community-space',NULL,0,'dev-master','927536d57ad6d3a283777a5c203a48f4a1634f76','2018-01-26 08:08:05','','','',0,0,'a:14:{s:3:\"key\";s:15:\"community_space\";s:9:\"namespace\";s:26:\"netcommons/community-space\";s:11:\"description\";s:36:\"CommunitySpace for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"927536d57ad6d3a283777a5c203a48f4a1634f76\";s:6:\"source\";s:49:\"https://github.com/NetCommons3/CommunitySpace.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T08:08:05+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:14:\"CommunitySpace\";s:4:\"name\";s:26:\"Netcommons Community-space\";s:10:\"commit_url\";s:91:\"https://github.com/NetCommons3/CommunitySpace/tree/927536d57ad6d3a283777a5c203a48f4a1634f76\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(86,0,1,0,0,'containers',NULL,'Netcommons Containers','netcommons/containers',NULL,0,'dev-master','696b1ff02cb9c6772b47895708fa855b0dec1c81','2018-01-26 08:09:20','','','',0,0,'a:14:{s:3:\"key\";s:10:\"containers\";s:9:\"namespace\";s:21:\"netcommons/containers\";s:11:\"description\";s:29:\"Containers Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"696b1ff02cb9c6772b47895708fa855b0dec1c81\";s:6:\"source\";s:45:\"https://github.com/NetCommons3/Containers.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T08:09:20+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:10:\"Containers\";s:4:\"name\";s:21:\"Netcommons Containers\";s:10:\"commit_url\";s:87:\"https://github.com/NetCommons3/Containers/tree/696b1ff02cb9c6772b47895708fa855b0dec1c81\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(87,0,1,0,0,'content_comments',NULL,'Netcommons Content-comments','netcommons/content-comments',NULL,0,'dev-master','5c6b7bfe124bf570a8aebd0fb36b1bac1fefa28c','2018-01-26 08:10:53','','','',0,0,'a:14:{s:3:\"key\";s:16:\"content_comments\";s:9:\"namespace\";s:27:\"netcommons/content-comments\";s:11:\"description\";s:37:\"ContentComments for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"5c6b7bfe124bf570a8aebd0fb36b1bac1fefa28c\";s:6:\"source\";s:50:\"https://github.com/NetCommons3/ContentComments.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:38:\"Mitsuru Mutaguchi(OpenSource WorkShop)\";s:5:\"email\";s:32:\"mutaguchi@opensource-workshop.jp\";s:8:\"homepage\";s:31:\"https://opensource-workshop.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T08:10:53+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:15:\"ContentComments\";s:4:\"name\";s:27:\"Netcommons Content-comments\";s:10:\"commit_url\";s:92:\"https://github.com/NetCommons3/ContentComments/tree/5c6b7bfe124bf570a8aebd0fb36b1bac1fefa28c\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(88,0,1,0,0,'control_panel',NULL,'Netcommons Control-panel','netcommons/control-panel',NULL,0,'dev-master','7b2527d3c5869a0d222f188ace2eb8e017d35da7','2019-01-24 22:43:09','','','',0,0,'a:14:{s:3:\"key\";s:13:\"control_panel\";s:9:\"namespace\";s:24:\"netcommons/control-panel\";s:11:\"description\";s:34:\"ControlPanel for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"7b2527d3c5869a0d222f188ace2eb8e017d35da7\";s:6:\"source\";s:47:\"https://github.com/NetCommons3/ControlPanel.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:15:\"Shohei Nakajima\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-24T22:43:09+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:12:\"ControlPanel\";s:4:\"name\";s:24:\"Netcommons Control-panel\";s:10:\"commit_url\";s:89:\"https://github.com/NetCommons3/ControlPanel/tree/7b2527d3c5869a0d222f188ace2eb8e017d35da7\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(89,0,1,0,0,'data_types',NULL,'Netcommons Data-types','netcommons/data-types',NULL,0,'dev-master','86680cb497e792df40c47923dde3f286a166c743','2019-01-06 07:09:36','','','',0,0,'a:14:{s:3:\"key\";s:10:\"data_types\";s:9:\"namespace\";s:21:\"netcommons/data-types\";s:11:\"description\";s:31:\"DataTypes for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"86680cb497e792df40c47923dde3f286a166c743\";s:6:\"source\";s:44:\"https://github.com/NetCommons3/DataTypes.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T07:09:36+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:9:\"DataTypes\";s:4:\"name\";s:21:\"Netcommons Data-types\";s:10:\"commit_url\";s:86:\"https://github.com/NetCommons3/DataTypes/tree/86680cb497e792df40c47923dde3f286a166c743\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(90,0,1,0,0,'files',NULL,'Netcommons Files','netcommons/files',NULL,0,'dev-master','9c764526039e25d5281b5546bd06a80493432882','2019-01-28 03:55:26','','','',0,0,'a:14:{s:3:\"key\";s:5:\"files\";s:9:\"namespace\";s:16:\"netcommons/files\";s:11:\"description\";s:27:\"Files for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"9c764526039e25d5281b5546bd06a80493432882\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Files.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-28T03:55:26+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Files\";s:4:\"name\";s:16:\"Netcommons Files\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Files/tree/9c764526039e25d5281b5546bd06a80493432882\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(91,0,1,0,0,'frames',NULL,'Netcommons Frames','netcommons/frames',NULL,0,'dev-improve_performance_current','e8f2ef06417c0ae56f381a1e2d7f77e77110e89b','2019-03-01 23:41:29','','','',0,0,'a:14:{s:3:\"key\";s:6:\"frames\";s:9:\"namespace\";s:17:\"netcommons/frames\";s:11:\"description\";s:25:\"Frames Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:31:\"dev-improve_performance_current\";s:14:\"commit_version\";s:40:\"e8f2ef06417c0ae56f381a1e2d7f77e77110e89b\";s:6:\"source\";s:41:\"https://github.com/NetCommons3/Frames.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-03-01T23:41:29+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:6:\"Frames\";s:4:\"name\";s:17:\"Netcommons Frames\";s:10:\"commit_url\";s:83:\"https://github.com/NetCommons3/Frames/tree/e8f2ef06417c0ae56f381a1e2d7f77e77110e89b\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(92,0,1,0,0,'groups',NULL,'Netcommons Groups','netcommons/groups',NULL,0,'dev-master','1da28578996562d7cfba223da8d19a3a9b863bfe','2019-01-30 06:03:17','','','',0,0,'a:14:{s:3:\"key\";s:6:\"groups\";s:9:\"namespace\";s:17:\"netcommons/groups\";s:11:\"description\";s:28:\"Groups Plugin for NetCommons\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"1da28578996562d7cfba223da8d19a3a9b863bfe\";s:6:\"source\";s:41:\"https://github.com/NetCommons3/Groups.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-30T06:03:17+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:6:\"Groups\";s:4:\"name\";s:17:\"Netcommons Groups\";s:10:\"commit_url\";s:83:\"https://github.com/NetCommons3/Groups/tree/1da28578996562d7cfba223da8d19a3a9b863bfe\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(93,0,1,0,0,'install',NULL,'Netcommons Install','netcommons/install',NULL,0,'3.2.2','7846de27890bc05f4d21aab2b686fbcaff715025','2019-01-07 14:58:00','','','',0,0,'a:14:{s:3:\"key\";s:7:\"install\";s:9:\"namespace\";s:18:\"netcommons/install\";s:11:\"description\";s:30:\"Install Plugin for NetCommons3\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:5:\"3.2.2\";s:14:\"commit_version\";s:40:\"7846de27890bc05f4d21aab2b686fbcaff715025\";s:6:\"source\";s:42:\"https://github.com/NetCommons3/Install.git\";s:7:\"authors\";N;s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-07T14:58:00+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:7:\"Install\";s:4:\"name\";s:18:\"Netcommons Install\";s:10:\"commit_url\";s:84:\"https://github.com/NetCommons3/Install/tree/7846de27890bc05f4d21aab2b686fbcaff715025\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(94,0,1,0,0,'likes',NULL,'Netcommons Likes','netcommons/likes',NULL,0,'dev-master','0a563e7b743db56575276af95fa0643d47e7b346','2019-02-05 11:29:06','','','',0,0,'a:14:{s:3:\"key\";s:5:\"likes\";s:9:\"namespace\";s:16:\"netcommons/likes\";s:11:\"description\";s:27:\"Likes for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"0a563e7b743db56575276af95fa0643d47e7b346\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Likes.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-05T11:29:06+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Likes\";s:4:\"name\";s:16:\"Netcommons Likes\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Likes/tree/0a563e7b743db56575276af95fa0643d47e7b346\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(95,0,1,0,0,'m17n',NULL,'Netcommons M17n','netcommons/m17n',NULL,0,'dev-master','3a248fe4ba496b827121b15ae1b453ed37c47583','2019-01-06 04:00:16','','','',0,0,'a:14:{s:3:\"key\";s:4:\"m17n\";s:9:\"namespace\";s:15:\"netcommons/m17n\";s:11:\"description\";s:23:\"M17n Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"3a248fe4ba496b827121b15ae1b453ed37c47583\";s:6:\"source\";s:39:\"https://github.com/NetCommons3/M17n.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T04:00:16+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:4:\"M17n\";s:4:\"name\";s:15:\"Netcommons M17n\";s:10:\"commit_url\";s:81:\"https://github.com/NetCommons3/M17n/tree/3a248fe4ba496b827121b15ae1b453ed37c47583\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(96,0,1,0,0,'mails',NULL,'Netcommons Mails','netcommons/mails',NULL,0,'dev-master','0b0118dc02c421ab1fd831ea92f5b3cba2f68951','2018-12-29 01:57:04','','','',0,0,'a:14:{s:3:\"key\";s:5:\"mails\";s:9:\"namespace\";s:16:\"netcommons/mails\";s:11:\"description\";s:27:\"Mails Plugin for NetCommons\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"0b0118dc02c421ab1fd831ea92f5b3cba2f68951\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Mails.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:38:\"Mitsuru Mutaguchi(OpenSource WorkShop)\";s:5:\"email\";s:32:\"mutaguchi@opensource-workshop.jp\";s:8:\"homepage\";s:31:\"https://opensource-workshop.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-12-29T01:57:04+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Mails\";s:4:\"name\";s:16:\"Netcommons Mails\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Mails/tree/0b0118dc02c421ab1fd831ea92f5b3cba2f68951\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(97,0,1,0,0,'net_commons',NULL,'Netcommons Net-commons','netcommons/net-commons',NULL,0,'dev-improve_performance_current','70c16126f5a0e88d98ec2f67aca829c0b1716ee1','2019-03-01 23:48:39','','','',0,0,'a:14:{s:3:\"key\";s:11:\"net_commons\";s:9:\"namespace\";s:22:\"netcommons/net-commons\";s:11:\"description\";s:17:\"NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:31:\"dev-improve_performance_current\";s:14:\"commit_version\";s:40:\"70c16126f5a0e88d98ec2f67aca829c0b1716ee1\";s:6:\"source\";s:45:\"https://github.com/NetCommons3/NetCommons.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-03-01T23:48:39+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:10:\"NetCommons\";s:4:\"name\";s:22:\"Netcommons Net-commons\";s:10:\"commit_url\";s:87:\"https://github.com/NetCommons3/NetCommons/tree/70c16126f5a0e88d98ec2f67aca829c0b1716ee1\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(98,0,1,0,0,'notifications',NULL,'Netcommons Notifications','netcommons/notifications',NULL,0,'dev-master','8e77b5fb50f82a805e03bf72892b900e9dd42ce7','2018-01-26 11:44:29','','','',0,0,'a:14:{s:3:\"key\";s:13:\"notifications\";s:9:\"namespace\";s:24:\"netcommons/notifications\";s:11:\"description\";s:35:\"Notifications for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"8e77b5fb50f82a805e03bf72892b900e9dd42ce7\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/Notifications.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T11:44:29+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"Notifications\";s:4:\"name\";s:24:\"Netcommons Notifications\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/Notifications/tree/8e77b5fb50f82a805e03bf72892b900e9dd42ce7\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(99,0,1,0,0,'pages',NULL,'Netcommons Pages','netcommons/pages',NULL,0,'dev-improve_performance_current','384551ff13b860c4f7bc5c3c30aeff7e4059302a','2019-02-27 01:17:06','','','',0,0,'a:14:{s:3:\"key\";s:5:\"pages\";s:9:\"namespace\";s:16:\"netcommons/pages\";s:11:\"description\";s:24:\"Pages Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:31:\"dev-improve_performance_current\";s:14:\"commit_version\";s:40:\"384551ff13b860c4f7bc5c3c30aeff7e4059302a\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Pages.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-27T01:17:06+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Pages\";s:4:\"name\";s:16:\"Netcommons Pages\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Pages/tree/384551ff13b860c4f7bc5c3c30aeff7e4059302a\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(100,0,1,0,0,'private_space',NULL,'Netcommons Private-space','netcommons/private-space',NULL,0,'dev-master','ad30809041671f3fac68fca035d5ccda10e36654','2019-01-06 04:00:03','','','',0,0,'a:14:{s:3:\"key\";s:13:\"private_space\";s:9:\"namespace\";s:24:\"netcommons/private-space\";s:11:\"description\";s:34:\"PrivateSpace for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"ad30809041671f3fac68fca035d5ccda10e36654\";s:6:\"source\";s:47:\"https://github.com/NetCommons3/PrivateSpace.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-06T04:00:03+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:12:\"PrivateSpace\";s:4:\"name\";s:24:\"Netcommons Private-space\";s:10:\"commit_url\";s:89:\"https://github.com/NetCommons3/PrivateSpace/tree/ad30809041671f3fac68fca035d5ccda10e36654\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(101,0,1,0,0,'public_space',NULL,'Netcommons Public-space','netcommons/public-space',NULL,0,'dev-master','365f23f98d31c5e7c2a0bfb7e8029f2af0591879','2018-01-26 11:54:02','','','',0,0,'a:14:{s:3:\"key\";s:12:\"public_space\";s:9:\"namespace\";s:23:\"netcommons/public-space\";s:11:\"description\";s:31:\"Public Space Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"365f23f98d31c5e7c2a0bfb7e8029f2af0591879\";s:6:\"source\";s:46:\"https://github.com/NetCommons3/PublicSpace.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T11:54:02+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:11:\"PublicSpace\";s:4:\"name\";s:23:\"Netcommons Public-space\";s:10:\"commit_url\";s:88:\"https://github.com/NetCommons3/PublicSpace/tree/365f23f98d31c5e7c2a0bfb7e8029f2af0591879\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(102,0,1,0,0,'roles',NULL,'Netcommons Roles','netcommons/roles',NULL,0,'dev-master','d5c074e9bbd518ad98256cb56b88ac61d75af409','2019-01-07 10:14:29','','','',0,0,'a:14:{s:3:\"key\";s:5:\"roles\";s:9:\"namespace\";s:16:\"netcommons/roles\";s:11:\"description\";s:28:\"Roles Plugin for NetCommons3\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"d5c074e9bbd518ad98256cb56b88ac61d75af409\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Roles.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-01-07T10:14:29+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Roles\";s:4:\"name\";s:16:\"Netcommons Roles\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Roles/tree/d5c074e9bbd518ad98256cb56b88ac61d75af409\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(103,0,1,0,0,'tags',NULL,'Netcommons Tags','netcommons/tags',NULL,0,'dev-master','6280440eb9b1936b03ee3655dd48c82504f0c744','2018-06-03 14:44:10','','','',0,0,'a:14:{s:3:\"key\";s:4:\"tags\";s:9:\"namespace\";s:15:\"netcommons/tags\";s:11:\"description\";s:26:\"Tags for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"6280440eb9b1936b03ee3655dd48c82504f0c744\";s:6:\"source\";s:39:\"https://github.com/NetCommons3/Tags.git\";s:7:\"authors\";a:2:{i:0;a:4:{s:4:\"name\";s:23:\"Ryuji AMANO (RYUS INC.)\";s:5:\"email\";s:16:\"ryuji@ryus.co.jp\";s:8:\"homepage\";s:18:\"http://ryus.co.jp/\";s:4:\"role\";s:9:\"Developer\";}i:1;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-06-03T14:44:10+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:4:\"Tags\";s:4:\"name\";s:15:\"Netcommons Tags\";s:10:\"commit_url\";s:81:\"https://github.com/NetCommons3/Tags/tree/6280440eb9b1936b03ee3655dd48c82504f0c744\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(104,0,1,0,0,'theme_settings',NULL,'Netcommons Theme-settings','netcommons/theme-settings',NULL,0,'dev-master','fa72f59c56459e1f8be65c743fcb2e94070855b3','2018-01-26 13:10:42','','','',0,0,'a:14:{s:3:\"key\";s:14:\"theme_settings\";s:9:\"namespace\";s:25:\"netcommons/theme-settings\";s:11:\"description\";s:32:\"ThemeSettings Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"fa72f59c56459e1f8be65c743fcb2e94070855b3\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/ThemeSettings.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T13:10:42+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"ThemeSettings\";s:4:\"name\";s:25:\"Netcommons Theme-settings\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/ThemeSettings/tree/fa72f59c56459e1f8be65c743fcb2e94070855b3\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(105,0,1,0,0,'users',NULL,'Netcommons Users','netcommons/users',NULL,0,'dev-master','ce90865cab740df0e348bcd3f8d290a439b3c308','2019-02-19 08:59:12','','','',0,0,'a:14:{s:3:\"key\";s:5:\"users\";s:9:\"namespace\";s:16:\"netcommons/users\";s:11:\"description\";s:24:\"Users Plugin for CakePHP\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"ce90865cab740df0e348bcd3f8d290a439b3c308\";s:6:\"source\";s:40:\"https://github.com/NetCommons3/Users.git\";s:7:\"authors\";a:2:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}i:1;a:2:{s:4:\"name\";s:17:\"NaKaZii Co., Ltd.\";s:8:\"homepage\";s:29:\"https://github.com/s-nakajima\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-19T08:59:12+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:5:\"Users\";s:4:\"name\";s:16:\"Netcommons Users\";s:10:\"commit_url\";s:82:\"https://github.com/NetCommons3/Users/tree/ce90865cab740df0e348bcd3f8d290a439b3c308\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(106,0,1,0,0,'visual_captcha',NULL,'Netcommons Visual-captcha','netcommons/visual-captcha',NULL,0,'dev-master','f2b4b59ce3e93c051d44d7632d5c2c59ca4142ce','2018-01-26 13:28:21','','','',0,0,'a:14:{s:3:\"key\";s:14:\"visual_captcha\";s:9:\"namespace\";s:25:\"netcommons/visual-captcha\";s:11:\"description\";s:35:\"VisualCaptcha for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"f2b4b59ce3e93c051d44d7632d5c2c59ca4142ce\";s:6:\"source\";s:48:\"https://github.com/NetCommons3/VisualCaptcha.git\";s:7:\"authors\";a:4:{i:0;a:4:{s:4:\"name\";s:41:\"Toshihide Hashimoto(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:1;a:4:{s:4:\"name\";s:40:\"Minori Kikuchihara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:2;a:4:{s:4:\"name\";s:35:\"Rika Fujiwara(AllCreator Co., Ltd.)\";s:5:\"email\";s:19:\"info@allcreator.net\";s:8:\"homepage\";s:21:\"http://allcreator.net\";s:4:\"role\";s:9:\"Developer\";}i:3;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-01-26T13:28:21+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:13:\"VisualCaptcha\";s:4:\"name\";s:25:\"Netcommons Visual-captcha\";s:10:\"commit_url\";s:90:\"https://github.com/NetCommons3/VisualCaptcha/tree/f2b4b59ce3e93c051d44d7632d5c2c59ca4142ce\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(107,0,1,0,0,'workflow',NULL,'Netcommons Workflow','netcommons/workflow',NULL,0,'dev-master','31aef7811eeb59ce77f94671b1d576c3d8508520','2019-02-01 02:46:52','','','',0,0,'a:14:{s:3:\"key\";s:8:\"workflow\";s:9:\"namespace\";s:19:\"netcommons/workflow\";s:11:\"description\";s:30:\"Workflow for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"31aef7811eeb59ce77f94671b1d576c3d8508520\";s:6:\"source\";s:43:\"https://github.com/NetCommons3/Workflow.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2019-02-01T02:46:52+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:8:\"Workflow\";s:4:\"name\";s:19:\"Netcommons Workflow\";s:10:\"commit_url\";s:85:\"https://github.com/NetCommons3/Workflow/tree/31aef7811eeb59ce77f94671b1d576c3d8508520\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(108,0,1,0,0,'wysiwyg',NULL,'Netcommons Wysiwyg','netcommons/wysiwyg',NULL,0,'dev-master','5b20bcc8140251df0a048a6ca81f57ca78ca9368','2018-12-19 10:29:51','','','',0,0,'a:14:{s:3:\"key\";s:7:\"wysiwyg\";s:9:\"namespace\";s:18:\"netcommons/wysiwyg\";s:11:\"description\";s:29:\"Wysiwyg for NetCommons Plugin\";s:8:\"homepage\";s:26:\"http://www.netcommons.org/\";s:7:\"version\";s:10:\"dev-master\";s:14:\"commit_version\";s:40:\"5b20bcc8140251df0a048a6ca81f57ca78ca9368\";s:6:\"source\";s:42:\"https://github.com/NetCommons3/Wysiwyg.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";a:1:{i:0;s:21:\"LicenseRef-NetCommons\";}s:8:\"commited\";s:25:\"2018-12-19T10:29:51+00:00\";s:11:\"packageType\";s:14:\"cakephp-plugin\";s:14:\"originalSource\";s:7:\"Wysiwyg\";s:4:\"name\";s:18:\"Netcommons Wysiwyg\";s:10:\"commit_url\";s:84:\"https://github.com/NetCommons3/Wysiwyg/tree/5b20bcc8140251df0a048a6ca81f57ca78ca9368\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(109,0,1,0,0,'phpcollection/phpcollection',NULL,'phpcollection/phpcollection','phpcollection/phpcollection',NULL,6,'0.5.0','f2bcff45c0da7c27991bbc1f90f47c4b7fb434a6','2015-05-17 12:39:23','','','',0,0,'a:15:{s:3:\"key\";s:27:\"phpcollection/phpcollection\";s:9:\"namespace\";s:27:\"phpcollection/phpcollection\";s:11:\"description\";s:42:\"General-Purpose Collection Library for PHP\";s:8:\"homepage\";N;s:7:\"version\";s:5:\"0.5.0\";s:14:\"commit_version\";s:40:\"f2bcff45c0da7c27991bbc1f90f47c4b7fb434a6\";s:6:\"source\";s:48:\"https://github.com/schmittjoh/php-collection.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:19:\"Johannes M. Schmitt\";s:5:\"email\";s:20:\"schmittjoh@gmail.com\";}}s:7:\"license\";a:1:{i:0;s:7:\"Apache2\";}s:8:\"commited\";s:25:\"2015-05-17T12:39:23+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:27:\"phpcollection/phpcollection\";s:4:\"name\";s:27:\"phpcollection/phpcollection\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:90:\"https://github.com/schmittjoh/php-collection/tree/f2bcff45c0da7c27991bbc1f90f47c4b7fb434a6\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(110,0,1,0,0,'phpoption/phpoption',NULL,'phpoption/phpoption','phpoption/phpoption',NULL,6,'1.5.0','94e644f7d2051a5f0fcf77d81605f152eecff0ed','2015-07-25 16:39:46','','','',0,0,'a:15:{s:3:\"key\";s:19:\"phpoption/phpoption\";s:9:\"namespace\";s:19:\"phpoption/phpoption\";s:11:\"description\";s:19:\"Option Type for PHP\";s:8:\"homepage\";N;s:7:\"version\";s:5:\"1.5.0\";s:14:\"commit_version\";s:40:\"94e644f7d2051a5f0fcf77d81605f152eecff0ed\";s:6:\"source\";s:44:\"https://github.com/schmittjoh/php-option.git\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:19:\"Johannes M. Schmitt\";s:5:\"email\";s:20:\"schmittjoh@gmail.com\";}}s:7:\"license\";a:1:{i:0;s:7:\"Apache2\";}s:8:\"commited\";s:25:\"2015-07-25T16:39:46+00:00\";s:11:\"packageType\";s:7:\"library\";s:14:\"originalSource\";s:19:\"phpoption/phpoption\";s:4:\"name\";s:19:\"phpoption/phpoption\";s:4:\"type\";s:1:\"6\";s:10:\"commit_url\";s:86:\"https://github.com/schmittjoh/php-option/tree/94e644f7d2051a5f0fcf77d81605f152eecff0ed\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(111,0,1,0,0,'MathJax',NULL,'MathJax','components/MathJax',NULL,7,'2.7.5','e7fc4fc2962f80dbcd11f868dfba6361fad76734','2018-08-20 18:52:37','','','',0,0,'a:15:{s:4:\"name\";s:7:\"MathJax\";s:3:\"key\";s:7:\"MathJax\";s:4:\"type\";s:1:\"7\";s:11:\"description\";N;s:8:\"homepage\";s:23:\"http://www.mathjax.org/\";s:7:\"version\";s:5:\"2.7.5\";s:14:\"commit_version\";s:40:\"e7fc4fc2962f80dbcd11f868dfba6361fad76734\";s:6:\"source\";s:41:\"https://github.com/components/MathJax.git\";s:7:\"authors\";N;s:7:\"license\";N;s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:18:\"components/MathJax\";s:9:\"namespace\";s:18:\"components/MathJax\";s:8:\"commited\";s:19:\"2018-08-20 18:52:37\";s:10:\"commit_url\";s:83:\"https://github.com/components/MathJax/tree/e7fc4fc2962f80dbcd11f868dfba6361fad76734\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(112,0,1,0,0,'angular',NULL,'angular','angular/bower-angular',NULL,7,'1.7.7','b333e148cf509428fd54f53c41710c4e8cf1ac2b','2019-02-04 13:17:50','','','',0,0,'a:15:{s:4:\"name\";s:7:\"angular\";s:3:\"key\";s:7:\"angular\";s:4:\"type\";s:1:\"7\";s:11:\"description\";N;s:8:\"homepage\";s:40:\"https://github.com/angular/bower-angular\";s:7:\"version\";s:5:\"1.7.7\";s:14:\"commit_version\";s:40:\"b333e148cf509428fd54f53c41710c4e8cf1ac2b\";s:6:\"source\";s:44:\"https://github.com/angular/bower-angular.git\";s:7:\"authors\";N;s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:7:\"angular\";s:9:\"namespace\";s:21:\"angular/bower-angular\";s:8:\"commited\";s:19:\"2019-02-04 13:17:50\";s:10:\"commit_url\";s:86:\"https://github.com/angular/bower-angular/tree/b333e148cf509428fd54f53c41710c4e8cf1ac2b\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(113,0,1,0,0,'angular-animate',NULL,'angular-animate','angular/bower-angular-animate',NULL,7,'1.7.7','ae1fb035644fa6dc3edf5e1ce284d9fe8b5de29b','2019-02-04 13:17:51','','','',0,0,'a:15:{s:4:\"name\";s:15:\"angular-animate\";s:3:\"key\";s:15:\"angular-animate\";s:4:\"type\";s:1:\"7\";s:11:\"description\";N;s:8:\"homepage\";s:48:\"https://github.com/angular/bower-angular-animate\";s:7:\"version\";s:5:\"1.7.7\";s:14:\"commit_version\";s:40:\"ae1fb035644fa6dc3edf5e1ce284d9fe8b5de29b\";s:6:\"source\";s:52:\"https://github.com/angular/bower-angular-animate.git\";s:7:\"authors\";N;s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:15:\"angular-animate\";s:9:\"namespace\";s:29:\"angular/bower-angular-animate\";s:8:\"commited\";s:19:\"2019-02-04 13:17:51\";s:10:\"commit_url\";s:94:\"https://github.com/angular/bower-angular-animate/tree/ae1fb035644fa6dc3edf5e1ce284d9fe8b5de29b\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(114,0,1,0,0,'angular-bootstrap',NULL,'angular-bootstrap','angular-ui/bootstrap-bower',NULL,7,'2.5.0','2ab82fe5b072269e897d5d11333e9925888df456','2017-01-28 13:32:59','','','',0,0,'a:15:{s:4:\"name\";s:17:\"angular-bootstrap\";s:3:\"key\";s:17:\"angular-bootstrap\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:52:\"Native AngularJS (Angular) directives for Bootstrap.\";s:8:\"homepage\";s:45:\"https://github.com/angular-ui/bootstrap-bower\";s:7:\"version\";s:5:\"2.5.0\";s:14:\"commit_version\";s:40:\"2ab82fe5b072269e897d5d11333e9925888df456\";s:6:\"source\";s:49:\"https://github.com/angular-ui/bootstrap-bower.git\";s:7:\"authors\";N;s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:17:\"angular-bootstrap\";s:9:\"namespace\";s:26:\"angular-ui/bootstrap-bower\";s:8:\"commited\";s:19:\"2017-01-28 13:32:59\";s:10:\"commit_url\";s:91:\"https://github.com/angular-ui/bootstrap-bower/tree/2ab82fe5b072269e897d5d11333e9925888df456\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(115,0,1,0,0,'angular-bootstrap-datetimepicker-directive',NULL,'angular-bootstrap-datetimepicker-directive','diosney/angular-bootstrap-datetimepicker-directive',NULL,7,'0.1.3','cd46fa63b7dfb970820cefe5fcb13708943188bf','2015-04-28 14:34:24','','','',0,0,'a:15:{s:4:\"name\";s:42:\"angular-bootstrap-datetimepicker-directive\";s:3:\"key\";s:42:\"angular-bootstrap-datetimepicker-directive\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:66:\"A wrapper directive around the bootstrap-datetimepicker component.\";s:8:\"homepage\";s:68:\"http://github.com/diosney/angular-bootstrap-datetimepicker-directive\";s:7:\"version\";s:5:\"0.1.3\";s:14:\"commit_version\";s:40:\"cd46fa63b7dfb970820cefe5fcb13708943188bf\";s:6:\"source\";s:73:\"https://github.com/diosney/angular-bootstrap-datetimepicker-directive.git\";s:7:\"authors\";a:1:{i:0;s:29:\"Diosney <diosney.s@gmail.com>\";}s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:42:\"angular-bootstrap-datetimepicker-directive\";s:9:\"namespace\";s:50:\"diosney/angular-bootstrap-datetimepicker-directive\";s:8:\"commited\";s:19:\"2015-04-28 14:34:24\";s:10:\"commit_url\";s:115:\"https://github.com/diosney/angular-bootstrap-datetimepicker-directive/tree/cd46fa63b7dfb970820cefe5fcb13708943188bf\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(116,0,1,0,0,'angular-mocks',NULL,'angular-mocks','angular/bower-angular-mocks',NULL,7,'1.7.7','512cb256cd3f8e33d79ffa1b50efc7c0ac410fdb','2019-02-04 13:17:51','','','',0,0,'a:15:{s:4:\"name\";s:13:\"angular-mocks\";s:3:\"key\";s:13:\"angular-mocks\";s:4:\"type\";s:1:\"7\";s:11:\"description\";N;s:8:\"homepage\";s:46:\"https://github.com/angular/bower-angular-mocks\";s:7:\"version\";s:5:\"1.7.7\";s:14:\"commit_version\";s:40:\"512cb256cd3f8e33d79ffa1b50efc7c0ac410fdb\";s:6:\"source\";s:50:\"https://github.com/angular/bower-angular-mocks.git\";s:7:\"authors\";N;s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:13:\"angular-mocks\";s:9:\"namespace\";s:27:\"angular/bower-angular-mocks\";s:8:\"commited\";s:19:\"2019-02-04 13:17:51\";s:10:\"commit_url\";s:92:\"https://github.com/angular/bower-angular-mocks/tree/512cb256cd3f8e33d79ffa1b50efc7c0ac410fdb\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(117,0,1,0,0,'angular-nvd3',NULL,'angular-nvd3','krispo/angular-nvd3',NULL,7,'1.0.9','6081783eb86d43015602ca91b13f249eb34d5402','2016-08-17 21:27:06','','','',0,0,'a:15:{s:4:\"name\";s:12:\"angular-nvd3\";s:3:\"key\";s:12:\"angular-nvd3\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:77:\"An AngularJS directive for NVD3.js reusable charting library (based on D3.js)\";s:8:\"homepage\";s:36:\"http://krispo.github.io/angular-nvd3\";s:7:\"version\";s:5:\"1.0.9\";s:14:\"commit_version\";s:40:\"6081783eb86d43015602ca91b13f249eb34d5402\";s:6:\"source\";s:42:\"https://github.com/krispo/angular-nvd3.git\";s:7:\"authors\";a:1:{i:0;s:17:\"Konstantin Skipor\";}s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:12:\"angular-nvd3\";s:9:\"namespace\";s:19:\"krispo/angular-nvd3\";s:8:\"commited\";s:19:\"2016-08-17 21:27:06\";s:10:\"commit_url\";s:84:\"https://github.com/krispo/angular-nvd3/tree/6081783eb86d43015602ca91b13f249eb34d5402\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(118,0,1,0,0,'angular-ui-tinymce',NULL,'angular-ui-tinymce','angular-ui/ui-tinymce',NULL,7,'0.0.19','30434e227768c47cdcf97b552cdbc4f12fad86da','2017-07-07 14:14:15','','','',0,0,'a:15:{s:4:\"name\";s:18:\"angular-ui-tinymce\";s:3:\"key\";s:18:\"angular-ui-tinymce\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:50:\"This directive allows you to TinyMCE in your form.\";s:8:\"homepage\";s:28:\"http://angular-ui.github.com\";s:7:\"version\";s:6:\"0.0.19\";s:14:\"commit_version\";s:40:\"30434e227768c47cdcf97b552cdbc4f12fad86da\";s:6:\"source\";s:44:\"https://github.com/angular-ui/ui-tinymce.git\";s:7:\"authors\";N;s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:18:\"angular-ui-tinymce\";s:9:\"namespace\";s:21:\"angular-ui/ui-tinymce\";s:8:\"commited\";s:19:\"2017-07-07 14:14:15\";s:10:\"commit_url\";s:86:\"https://github.com/angular-ui/ui-tinymce/tree/30434e227768c47cdcf97b552cdbc4f12fad86da\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(119,0,1,0,0,'bootstrap',NULL,'bootstrap','twbs/bootstrap',NULL,7,'3.4.1','68b0d231a13201eb14acd3dc84e51543d16e5f7e','2019-02-13 15:55:38','','','',0,0,'a:15:{s:4:\"name\";s:9:\"bootstrap\";s:3:\"key\";s:9:\"bootstrap\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:97:\"The most popular front-end framework for developing responsive, mobile first projects on the web.\";s:8:\"homepage\";s:25:\"https://getbootstrap.com/\";s:7:\"version\";s:5:\"3.4.1\";s:14:\"commit_version\";s:40:\"68b0d231a13201eb14acd3dc84e51543d16e5f7e\";s:6:\"source\";s:37:\"https://github.com/twbs/bootstrap.git\";s:7:\"authors\";N;s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:9:\"bootstrap\";s:9:\"namespace\";s:14:\"twbs/bootstrap\";s:8:\"commited\";s:19:\"2019-02-13 15:55:38\";s:10:\"commit_url\";s:79:\"https://github.com/twbs/bootstrap/tree/68b0d231a13201eb14acd3dc84e51543d16e5f7e\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(120,0,1,0,0,'d3',NULL,'d3','mbostock-bower/d3-bower',NULL,7,'3.5.17','abe0262a205c9f3755c3a757de4dfd1d49f34b24','2016-05-05 00:30:02','','','',0,0,'a:15:{s:4:\"name\";s:2:\"d3\";s:3:\"key\";s:2:\"d3\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:52:\"A JavaScript visualization library for HTML and SVG.\";s:8:\"homepage\";s:42:\"https://github.com/mbostock-bower/d3-bower\";s:7:\"version\";s:6:\"3.5.17\";s:14:\"commit_version\";s:40:\"abe0262a205c9f3755c3a757de4dfd1d49f34b24\";s:6:\"source\";s:46:\"https://github.com/mbostock-bower/d3-bower.git\";s:7:\"authors\";N;s:7:\"license\";s:12:\"BSD-3-Clause\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:2:\"d3\";s:9:\"namespace\";s:23:\"mbostock-bower/d3-bower\";s:8:\"commited\";s:19:\"2016-05-05 00:30:02\";s:10:\"commit_url\";s:88:\"https://github.com/mbostock-bower/d3-bower/tree/abe0262a205c9f3755c3a757de4dfd1d49f34b24\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(121,0,1,0,0,'eonasdan-bootstrap-datetimepicker',NULL,'eonasdan-bootstrap-datetimepicker','Eonasdan/bootstrap-datetimepicker',NULL,7,'4.17.47','25c11d79e614bc6463a87c3dd9cbf8280422e006','2017-02-28 14:32:02','','','',0,0,'a:15:{s:4:\"name\";s:33:\"eonasdan-bootstrap-datetimepicker\";s:3:\"key\";s:33:\"eonasdan-bootstrap-datetimepicker\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:25:\"bootstrap3 datetimepicker\";s:8:\"homepage\";s:52:\"https://github.com/Eonasdan/bootstrap-datetimepicker\";s:7:\"version\";s:7:\"4.17.47\";s:14:\"commit_version\";s:40:\"25c11d79e614bc6463a87c3dd9cbf8280422e006\";s:6:\"source\";s:56:\"https://github.com/Eonasdan/bootstrap-datetimepicker.git\";s:7:\"authors\";a:1:{i:0;s:8:\"Eonasdan\";}s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:33:\"eonasdan-bootstrap-datetimepicker\";s:9:\"namespace\";s:33:\"Eonasdan/bootstrap-datetimepicker\";s:8:\"commited\";s:19:\"2017-02-28 14:32:02\";s:10:\"commit_url\";s:98:\"https://github.com/Eonasdan/bootstrap-datetimepicker/tree/25c11d79e614bc6463a87c3dd9cbf8280422e006\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(122,0,1,0,0,'jquery',NULL,'jquery','jquery/jquery-dist',NULL,7,'3.3.1','9e8ec3d10fad04748176144f108d7355662ae75e','2018-01-20 17:26:57','','','',0,0,'a:15:{s:4:\"name\";s:6:\"jquery\";s:3:\"key\";s:6:\"jquery\";s:4:\"type\";s:1:\"7\";s:11:\"description\";N;s:8:\"homepage\";s:37:\"https://github.com/jquery/jquery-dist\";s:7:\"version\";s:5:\"3.3.1\";s:14:\"commit_version\";s:40:\"9e8ec3d10fad04748176144f108d7355662ae75e\";s:6:\"source\";s:41:\"https://github.com/jquery/jquery-dist.git\";s:7:\"authors\";N;s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:6:\"jquery\";s:9:\"namespace\";s:18:\"jquery/jquery-dist\";s:8:\"commited\";s:19:\"2018-01-20 17:26:57\";s:10:\"commit_url\";s:83:\"https://github.com/jquery/jquery-dist/tree/9e8ec3d10fad04748176144f108d7355662ae75e\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(123,0,1,0,0,'jquery-ui',NULL,'jquery-ui','components/jqueryui',NULL,7,'1.12.1','44ecf3794cc56b65954cc19737234a3119d036cc','2016-09-16 05:47:55','','','',0,0,'a:15:{s:4:\"name\";s:9:\"jquery-ui\";s:3:\"key\";s:9:\"jquery-ui\";s:4:\"type\";s:1:\"7\";s:11:\"description\";N;s:8:\"homepage\";s:38:\"https://github.com/components/jqueryui\";s:7:\"version\";s:6:\"1.12.1\";s:14:\"commit_version\";s:40:\"44ecf3794cc56b65954cc19737234a3119d036cc\";s:6:\"source\";s:42:\"https://github.com/components/jqueryui.git\";s:7:\"authors\";N;s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:8:\"jqueryui\";s:9:\"namespace\";s:19:\"components/jqueryui\";s:8:\"commited\";s:19:\"2016-09-16 05:47:55\";s:10:\"commit_url\";s:84:\"https://github.com/components/jqueryui/tree/44ecf3794cc56b65954cc19737234a3119d036cc\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(124,0,1,0,0,'moment',NULL,'moment','moment/moment',NULL,7,'2.24.0','8a6b2e11207a3856bd858d4d65d4b0822571e6c3','2019-01-21 20:59:53','','','',0,0,'a:15:{s:4:\"name\";s:6:\"moment\";s:3:\"key\";s:6:\"moment\";s:4:\"type\";s:1:\"7\";s:11:\"description\";N;s:8:\"homepage\";s:32:\"https://github.com/moment/moment\";s:7:\"version\";s:6:\"2.24.0\";s:14:\"commit_version\";s:40:\"8a6b2e11207a3856bd858d4d65d4b0822571e6c3\";s:6:\"source\";s:36:\"https://github.com/moment/moment.git\";s:7:\"authors\";N;s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:6:\"moment\";s:9:\"namespace\";s:13:\"moment/moment\";s:8:\"commited\";s:19:\"2019-01-21 20:59:53\";s:10:\"commit_url\";s:78:\"https://github.com/moment/moment/tree/8a6b2e11207a3856bd858d4d65d4b0822571e6c3\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(125,0,1,0,0,'nvd3',NULL,'nvd3','novus/nvd3',NULL,7,'1.8.6','d273ea52d91b482d044f8cef1e921256f2bfddcd','2017-08-24 01:23:44','','','',0,0,'a:15:{s:4:\"name\";s:4:\"nvd3\";s:3:\"key\";s:4:\"nvd3\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:45:\"Re-usable charts and chart components for d3.\";s:8:\"homepage\";s:19:\"http://www.nvd3.org\";s:7:\"version\";s:5:\"1.8.6\";s:14:\"commit_version\";s:40:\"d273ea52d91b482d044f8cef1e921256f2bfddcd\";s:6:\"source\";s:33:\"https://github.com/novus/nvd3.git\";s:7:\"authors\";a:5:{i:0;s:14:\"Bob Monteverde\";i:1;s:10:\"Tyler Wolf\";i:2;s:8:\"Robin Hu\";i:3;s:10:\"Frank Shao\";i:4;s:10:\"liquidpele\";}s:7:\"license\";s:10:\"Apache-2.0\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:4:\"nvd3\";s:9:\"namespace\";s:10:\"novus/nvd3\";s:8:\"commited\";s:19:\"2017-08-24 01:23:44\";s:10:\"commit_url\";s:75:\"https://github.com/novus/nvd3/tree/d273ea52d91b482d044f8cef1e921256f2bfddcd\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(126,0,1,0,0,'simplePagination-js',NULL,'simplePagination.js','flaviusmatis/simplePagination.js',NULL,7,'e32c66e0f1','e32c66e0f188d9ee022c1d2748de487fa9b77d58','2017-03-07 15:40:17','','','',0,0,'a:15:{s:4:\"name\";s:19:\"simplePagination.js\";s:3:\"key\";s:19:\"simplePagination-js\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:52:\"A simple jQuery pagination plugin with 3 CSS themes.\";s:8:\"homepage\";s:51:\"https://github.com/flaviusmatis/simplePagination.js\";s:7:\"version\";s:10:\"e32c66e0f1\";s:14:\"commit_version\";s:40:\"e32c66e0f188d9ee022c1d2748de487fa9b77d58\";s:6:\"source\";s:55:\"https://github.com/flaviusmatis/simplePagination.js.git\";s:7:\"authors\";a:1:{i:0;s:31:\"Flavius Matis <flavius@fdbk.me>\";}s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:23:\"jquery.simplePagination\";s:9:\"namespace\";s:32:\"flaviusmatis/simplePagination.js\";s:8:\"commited\";s:19:\"2017-03-07 15:40:17\";s:10:\"commit_url\";s:97:\"https://github.com/flaviusmatis/simplePagination.js/tree/e32c66e0f188d9ee022c1d2748de487fa9b77d58\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(127,0,1,0,0,'tinymce',NULL,'tinymce','tinymce/tinymce-dist',NULL,7,'4.5.9','380b70489c11f499735d9ec53c8d07ae1f37b2de','2018-08-03 12:00:41','','','',0,0,'a:15:{s:4:\"name\";s:7:\"tinymce\";s:3:\"key\";s:7:\"tinymce\";s:4:\"type\";s:1:\"7\";s:11:\"description\";s:49:\"Web based JavaScript HTML WYSIWYG editor control.\";s:8:\"homepage\";s:22:\"http://www.tinymce.com\";s:7:\"version\";s:5:\"4.5.9\";s:14:\"commit_version\";s:40:\"380b70489c11f499735d9ec53c8d07ae1f37b2de\";s:6:\"source\";s:43:\"https://github.com/tinymce/tinymce-dist.git\";s:7:\"authors\";N;s:7:\"license\";s:8:\"LGPL-2.1\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:7:\"tinymce\";s:9:\"namespace\";s:20:\"tinymce/tinymce-dist\";s:8:\"commited\";s:19:\"2018-08-03 12:00:41\";s:10:\"commit_url\";s:85:\"https://github.com/tinymce/tinymce-dist/tree/380b70489c11f499735d9ec53c8d07ae1f37b2de\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(128,0,1,0,0,'visualcaptcha-jquery',NULL,'visualcaptcha.jquery','emotionLoop/visualCaptcha-frontend-jquery',NULL,7,'0.0.8','0a8db7f6ad903a9c92d1399c31ec7c7968e56a31','2016-01-23 16:53:27','','','',0,0,'a:15:{s:4:\"name\";s:20:\"visualcaptcha.jquery\";s:3:\"key\";s:20:\"visualcaptcha-jquery\";s:4:\"type\";s:1:\"7\";s:11:\"description\";N;s:8:\"homepage\";s:24:\"http://visualcaptcha.net\";s:7:\"version\";s:5:\"0.0.8\";s:14:\"commit_version\";s:40:\"0a8db7f6ad903a9c92d1399c31ec7c7968e56a31\";s:6:\"source\";s:64:\"https://github.com/emotionLoop/visualCaptcha-frontend-jquery.git\";s:7:\"authors\";a:1:{i:0;s:35:\"emotionLoop <hello@emotionloop.com>\";}s:7:\"license\";s:3:\"MIT\";s:11:\"packageType\";s:5:\"bower\";s:14:\"originalSource\";s:20:\"visualcaptcha.jquery\";s:9:\"namespace\";s:41:\"emotionLoop/visualCaptcha-frontend-jquery\";s:8:\"commited\";s:19:\"2016-01-23 16:53:27\";s:10:\"commit_url\";s:106:\"https://github.com/emotionLoop/visualCaptcha-frontend-jquery/tree/0a8db7f6ad903a9c92d1399c31ec7c7968e56a31\";}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(129,0,1,0,0,'themed_default',NULL,'Classic Default','Themed/Default',NULL,5,'3.0.0','9362bcf73df426892af462e64c72ea8c','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:15:\"Classic Default\";s:3:\"key\";s:14:\"themed_default\";s:9:\"namespace\";s:14:\"Themed/Default\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:34:\"NetCommons3 Themed Classic Default\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.0.0\";s:14:\"commit_version\";s:32:\"9362bcf73df426892af462e64c72ea8c\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:20:\"NetCommons Community\";s:8:\"homepage\";s:25:\"http://www.netcommons.org\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:7:\"Default\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(130,0,1,0,0,'themed_default_blue',NULL,'Classic Blue','Themed/DefaultBlue',NULL,5,'3.0.0','55247cb3422a7838226475d1f5373c41','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:12:\"Classic Blue\";s:3:\"key\";s:19:\"themed_default_blue\";s:9:\"namespace\";s:18:\"Themed/DefaultBlue\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:31:\"NetCommons3 Themed Classic Blue\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.0.0\";s:14:\"commit_version\";s:32:\"55247cb3422a7838226475d1f5373c41\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:11:\"catchball21\";s:8:\"homepage\";s:22:\"https://www.cb21.co.jp\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:11:\"DefaultBlue\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(131,0,1,0,0,'themed_default_green',NULL,'Classic Green','Themed/DefaultGreen',NULL,5,'3.0.0','bccbfb14e3ab27ca00e450edd8d152d3','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:13:\"Classic Green\";s:3:\"key\";s:20:\"themed_default_green\";s:9:\"namespace\";s:19:\"Themed/DefaultGreen\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:32:\"NetCommons3 Themed Classic Green\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.0.0\";s:14:\"commit_version\";s:32:\"bccbfb14e3ab27ca00e450edd8d152d3\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:11:\"catchball21\";s:8:\"homepage\";s:22:\"https://www.cb21.co.jp\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:12:\"DefaultGreen\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(132,0,1,0,0,'themed_default_pink',NULL,'Classic Pink','Themed/DefaultPink',NULL,5,'3.0.0','46d6689b1f645e322ece81d021fc1403','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:12:\"Classic Pink\";s:3:\"key\";s:19:\"themed_default_pink\";s:9:\"namespace\";s:18:\"Themed/DefaultPink\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:31:\"NetCommons3 Themed Classic Pink\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.0.0\";s:14:\"commit_version\";s:32:\"46d6689b1f645e322ece81d021fc1403\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:11:\"catchball21\";s:8:\"homepage\";s:22:\"https://www.cb21.co.jp\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:11:\"DefaultPink\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(133,0,1,0,0,'themed_layout_blue',NULL,'Layout Blue','Themed/LayoutBlue',NULL,5,'3.0.0','3ccc783c8e4c9b579d0117c37f56df11','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:11:\"Layout Blue\";s:3:\"key\";s:18:\"themed_layout_blue\";s:9:\"namespace\";s:17:\"Themed/LayoutBlue\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:30:\"NetCommons3 Themed Layout Blue\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.0.0\";s:14:\"commit_version\";s:32:\"3ccc783c8e4c9b579d0117c37f56df11\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:11:\"catchball21\";s:8:\"homepage\";s:22:\"https://www.cb21.co.jp\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:10:\"LayoutBlue\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(134,0,1,0,0,'themed_michael1st',NULL,'Michael the 1st','Themed/Michael1st',NULL,5,'3.1.0','625f10a7a8c5ed468e02284abb6b6bb8','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:15:\"Michael the 1st\";s:3:\"key\";s:17:\"themed_michael1st\";s:9:\"namespace\";s:17:\"Themed/Michael1st\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:33:\"NetCommons3 Theme Michael the 1st\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.1.0\";s:14:\"commit_version\";s:32:\"625f10a7a8c5ed468e02284abb6b6bb8\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:34:\"Akazawa Studio LLC & Faneg factory\";s:8:\"homepage\";s:23:\"https://www.akazawa.org\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:10:\"Michael1st\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(135,0,1,0,0,'themed_michael2nd',NULL,'Michael the 2nd','Themed/Michael2nd',NULL,5,'3.1.0','e1e52c985d199d853e6aeb8a5e8982a6','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:15:\"Michael the 2nd\";s:3:\"key\";s:17:\"themed_michael2nd\";s:9:\"namespace\";s:17:\"Themed/Michael2nd\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:33:\"NetCommons3 Theme Michael the 2nd\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.1.0\";s:14:\"commit_version\";s:32:\"e1e52c985d199d853e6aeb8a5e8982a6\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:34:\"Akazawa Studio LLC & Faneg factory\";s:8:\"homepage\";s:23:\"https://www.akazawa.org\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:10:\"Michael2nd\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(136,0,1,0,0,'themed_michael3rd',NULL,'Michael the 3rd','Themed/Michael3rd',NULL,5,'3.1.0','1fa948fbf6a6ac44ba23f168af875273','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:15:\"Michael the 3rd\";s:3:\"key\";s:17:\"themed_michael3rd\";s:9:\"namespace\";s:17:\"Themed/Michael3rd\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:33:\"NetCommons3 Theme Michael the 3rd\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.1.0\";s:14:\"commit_version\";s:32:\"1fa948fbf6a6ac44ba23f168af875273\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:34:\"Akazawa Studio LLC / Faneg factory\";s:8:\"homepage\";s:23:\"https://www.akazawa.org\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:10:\"Michael3rd\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(137,0,1,0,0,'themed_michael4th',NULL,'Michael the 4th','Themed/Michael4th',NULL,5,'3.1.0','c947d1de378fb7171a4fec5049b5fcd6','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:15:\"Michael the 4th\";s:3:\"key\";s:17:\"themed_michael4th\";s:9:\"namespace\";s:17:\"Themed/Michael4th\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:33:\"NetCommons3 Theme Michael the 4th\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.1.0\";s:14:\"commit_version\";s:32:\"c947d1de378fb7171a4fec5049b5fcd6\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:34:\"Akazawa Studio LLC / Faneg factory\";s:8:\"homepage\";s:23:\"https://www.akazawa.org\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:10:\"Michael4th\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51'),(138,0,1,0,0,'themed_michael5th',NULL,'Michael the 5th','Themed/Michael5th',NULL,5,'3.1.0','dea757d6f373e77e636d926235b54c6e','0000-00-00 00:00:00','','','',0,0,'a:15:{s:4:\"name\";s:15:\"Michael the 5th\";s:3:\"key\";s:17:\"themed_michael5th\";s:9:\"namespace\";s:17:\"Themed/Michael5th\";s:4:\"type\";s:1:\"5\";s:11:\"description\";s:33:\"NetCommons3 Theme Michael the 5th\";s:8:\"homepage\";s:42:\"https://github.com/NetCommons3/NetCommons3\";s:7:\"version\";s:5:\"3.1.0\";s:14:\"commit_version\";s:32:\"dea757d6f373e77e636d926235b54c6e\";s:6:\"source\";s:0:\"\";s:7:\"authors\";a:1:{i:0;a:2:{s:4:\"name\";s:34:\"Akazawa Studio LLC / Faneg factory\";s:8:\"homepage\";s:23:\"https://www.akazawa.org\";}}s:7:\"license\";s:18:\"NetCommons License\";s:8:\"commited\";N;s:11:\"packageType\";N;s:14:\"originalSource\";s:10:\"Michael5th\";s:10:\"commit_url\";N;}',NULL,'2019-03-02 03:14:51',NULL,'2019-03-02 03:14:51');
/*!40000 ALTER TABLE `plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugins_roles`
--

DROP TABLE IF EXISTS `plugins_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plugins_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_key` varchar(255) NOT NULL,
  `plugin_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_key` (`role_key`,`plugin_key`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plugins_roles`
--

LOCK TABLES `plugins_roles` WRITE;
/*!40000 ALTER TABLE `plugins_roles` DISABLE KEYS */;
INSERT INTO `plugins_roles` VALUES (1,'system_administrator','plugin_manager',NULL,'2019-03-02 03:14:04',NULL,'2019-03-02 03:14:04'),(2,'system_administrator','site_manager',NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(3,'administrator','site_manager',NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(4,'system_administrator','rooms',NULL,'2019-03-02 03:14:11',NULL,'2019-03-02 03:14:11'),(5,'administrator','rooms',NULL,'2019-03-02 03:14:11',NULL,'2019-03-02 03:14:11'),(6,'room_administrator','access_counters',NULL,'2019-03-02 03:14:14',NULL,'2019-03-02 03:14:14'),(7,'room_administrator','announcements',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(8,'room_administrator','bbses',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(9,'room_administrator','blogs',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(10,'room_administrator','cabinets',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(11,'room_administrator','calendars',NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(12,'room_administrator','circular_notices',NULL,'2019-03-02 03:14:21',NULL,'2019-03-02 03:14:21'),(13,'room_administrator','faqs',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(14,'system_administrator','holidays',NULL,'2019-03-02 03:14:29',NULL,'2019-03-02 03:14:29'),(15,'administrator','holidays',NULL,'2019-03-02 03:14:29',NULL,'2019-03-02 03:14:29'),(16,'room_administrator','iframes',NULL,'2019-03-02 03:14:30',NULL,'2019-03-02 03:14:30'),(17,'room_administrator','links',NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(18,'room_administrator','menus',NULL,'2019-03-02 03:14:32',NULL,'2019-03-02 03:14:32'),(19,'room_administrator','multidatabases',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(20,'system_administrator','nc2_to_nc3',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(21,'room_administrator','photo_albums',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(22,'room_administrator','questionnaires',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(23,'room_administrator','quizzes',NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(24,'room_administrator','registrations',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(25,'room_administrator','reservations',NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(26,'room_administrator','rss_readers',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(27,'room_administrator','searches',NULL,'2019-03-02 03:14:43',NULL,'2019-03-02 03:14:43'),(28,'system_administrator','system_manager',NULL,'2019-03-02 03:14:43',NULL,'2019-03-02 03:14:43'),(29,'room_administrator','tasks',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(30,'room_administrator','topics',NULL,'2019-03-02 03:14:45',NULL,'2019-03-02 03:14:45'),(31,'system_administrator','user_attributes',NULL,'2019-03-02 03:14:46',NULL,'2019-03-02 03:14:46'),(32,'administrator','user_attributes',NULL,'2019-03-02 03:14:46',NULL,'2019-03-02 03:14:46'),(33,'system_administrator','user_manager',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(34,'administrator','user_manager',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(35,'system_administrator','user_roles',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(36,'administrator','user_roles',NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(37,'room_administrator','videos',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49');
/*!40000 ALTER TABLE `plugins_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugins_rooms`
--

DROP TABLE IF EXISTS `plugins_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plugins_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `plugin_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plugin_key` (`plugin_key`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=364 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plugins_rooms`
--

LOCK TABLES `plugins_rooms` WRITE;
/*!40000 ALTER TABLE `plugins_rooms` DISABLE KEYS */;
INSERT INTO `plugins_rooms` VALUES (1,4,'access_counters',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(2,1,'access_counters',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(3,2,'access_counters',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(4,3,'access_counters',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(5,4,'announcements',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(6,1,'announcements',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(7,2,'announcements',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(8,3,'announcements',NULL,'2019-03-02 03:14:15',NULL,'2019-03-02 03:14:15'),(9,4,'bbses',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(10,1,'bbses',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(11,2,'bbses',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(12,3,'bbses',NULL,'2019-03-02 03:14:16',NULL,'2019-03-02 03:14:16'),(13,4,'blogs',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(14,1,'blogs',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(15,2,'blogs',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(16,3,'blogs',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(17,4,'cabinets',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(18,1,'cabinets',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(19,2,'cabinets',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(20,3,'cabinets',NULL,'2019-03-02 03:14:18',NULL,'2019-03-02 03:14:18'),(21,4,'calendars',NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(22,1,'calendars',NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(23,2,'calendars',NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(24,3,'calendars',NULL,'2019-03-02 03:14:19',NULL,'2019-03-02 03:14:19'),(25,4,'circular_notices',NULL,'2019-03-02 03:14:21',NULL,'2019-03-02 03:14:21'),(26,1,'circular_notices',NULL,'2019-03-02 03:14:21',NULL,'2019-03-02 03:14:21'),(27,3,'circular_notices',NULL,'2019-03-02 03:14:21',NULL,'2019-03-02 03:14:21'),(28,4,'faqs',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(29,1,'faqs',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(30,2,'faqs',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(31,3,'faqs',NULL,'2019-03-02 03:14:23',NULL,'2019-03-02 03:14:23'),(32,4,'iframes',NULL,'2019-03-02 03:14:30',NULL,'2019-03-02 03:14:30'),(33,1,'iframes',NULL,'2019-03-02 03:14:30',NULL,'2019-03-02 03:14:30'),(34,2,'iframes',NULL,'2019-03-02 03:14:30',NULL,'2019-03-02 03:14:30'),(35,3,'iframes',NULL,'2019-03-02 03:14:30',NULL,'2019-03-02 03:14:30'),(36,4,'links',NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(37,1,'links',NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(38,2,'links',NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(39,3,'links',NULL,'2019-03-02 03:14:31',NULL,'2019-03-02 03:14:31'),(40,4,'menus',NULL,'2019-03-02 03:14:32',NULL,'2019-03-02 03:14:32'),(41,1,'menus',NULL,'2019-03-02 03:14:32',NULL,'2019-03-02 03:14:32'),(42,2,'menus',NULL,'2019-03-02 03:14:32',NULL,'2019-03-02 03:14:32'),(43,3,'menus',NULL,'2019-03-02 03:14:32',NULL,'2019-03-02 03:14:32'),(44,4,'multidatabases',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(45,1,'multidatabases',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(46,2,'multidatabases',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(47,3,'multidatabases',NULL,'2019-03-02 03:14:33',NULL,'2019-03-02 03:14:33'),(48,4,'photo_albums',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(49,1,'photo_albums',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(50,2,'photo_albums',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(51,3,'photo_albums',NULL,'2019-03-02 03:14:34',NULL,'2019-03-02 03:14:34'),(52,4,'questionnaires',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(53,1,'questionnaires',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(54,3,'questionnaires',NULL,'2019-03-02 03:14:35',NULL,'2019-03-02 03:14:35'),(55,4,'quizzes',NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(56,1,'quizzes',NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(57,3,'quizzes',NULL,'2019-03-02 03:14:37',NULL,'2019-03-02 03:14:37'),(58,4,'registrations',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(59,1,'registrations',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(60,3,'registrations',NULL,'2019-03-02 03:14:38',NULL,'2019-03-02 03:14:38'),(61,4,'reservations',NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(62,1,'reservations',NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(63,2,'reservations',NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(64,3,'reservations',NULL,'2019-03-02 03:14:40',NULL,'2019-03-02 03:14:40'),(65,4,'rss_readers',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(66,1,'rss_readers',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(67,2,'rss_readers',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(68,3,'rss_readers',NULL,'2019-03-02 03:14:42',NULL,'2019-03-02 03:14:42'),(69,4,'searches',NULL,'2019-03-02 03:14:43',NULL,'2019-03-02 03:14:43'),(70,1,'searches',NULL,'2019-03-02 03:14:43',NULL,'2019-03-02 03:14:43'),(71,2,'searches',NULL,'2019-03-02 03:14:43',NULL,'2019-03-02 03:14:43'),(72,3,'searches',NULL,'2019-03-02 03:14:43',NULL,'2019-03-02 03:14:43'),(73,4,'tasks',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(74,1,'tasks',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(75,2,'tasks',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(76,3,'tasks',NULL,'2019-03-02 03:14:44',NULL,'2019-03-02 03:14:44'),(77,4,'topics',NULL,'2019-03-02 03:14:45',NULL,'2019-03-02 03:14:45'),(78,1,'topics',NULL,'2019-03-02 03:14:45',NULL,'2019-03-02 03:14:45'),(79,2,'topics',NULL,'2019-03-02 03:14:45',NULL,'2019-03-02 03:14:45'),(80,3,'topics',NULL,'2019-03-02 03:14:45',NULL,'2019-03-02 03:14:45'),(81,4,'videos',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(82,1,'videos',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(83,2,'videos',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(84,3,'videos',NULL,'2019-03-02 03:14:49',NULL,'2019-03-02 03:14:49'),(85,5,'access_counters',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(86,5,'announcements',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(87,5,'bbses',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(88,5,'blogs',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(89,5,'cabinets',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(90,5,'calendars',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(91,5,'faqs',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(92,5,'iframes',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(93,5,'links',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(94,5,'menus',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(95,5,'multidatabases',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(96,5,'photo_albums',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(97,5,'reservations',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(98,5,'rss_readers',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(99,5,'searches',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(100,5,'tasks',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(101,5,'topics',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(102,5,'videos',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(116,6,'access_counters',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(117,6,'announcements',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(118,6,'bbses',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(119,6,'blogs',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(120,6,'cabinets',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(121,6,'calendars',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(122,6,'faqs',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(123,6,'iframes',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(124,6,'links',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(125,6,'menus',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(126,6,'multidatabases',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(127,6,'photo_albums',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(128,6,'reservations',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(129,6,'rss_readers',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(130,6,'searches',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(131,6,'tasks',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(132,6,'topics',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(133,6,'videos',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(147,7,'access_counters',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(148,7,'announcements',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(149,7,'bbses',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(150,7,'blogs',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(151,7,'cabinets',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(152,7,'calendars',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(153,7,'faqs',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(154,7,'iframes',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(155,7,'links',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(156,7,'menus',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(157,7,'multidatabases',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(158,7,'photo_albums',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(159,7,'reservations',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(160,7,'rss_readers',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(161,7,'searches',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(162,7,'tasks',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(163,7,'topics',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(164,7,'videos',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(178,8,'access_counters',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(179,8,'announcements',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(180,8,'bbses',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(181,8,'blogs',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(182,8,'cabinets',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(183,8,'calendars',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(184,8,'circular_notices',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(185,8,'faqs',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(186,8,'iframes',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(187,8,'links',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(188,8,'menus',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(189,8,'multidatabases',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(190,8,'photo_albums',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(191,8,'questionnaires',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(192,8,'quizzes',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(193,8,'registrations',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(194,8,'reservations',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(195,8,'rss_readers',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(196,8,'searches',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(197,8,'tasks',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(198,8,'topics',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(199,8,'videos',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(209,9,'access_counters',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(210,9,'announcements',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(211,9,'bbses',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(212,9,'blogs',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(213,9,'cabinets',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(214,9,'calendars',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(215,9,'circular_notices',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(216,9,'faqs',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(217,9,'iframes',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(218,9,'links',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(219,9,'menus',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(220,9,'multidatabases',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(221,9,'photo_albums',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(222,9,'questionnaires',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(223,9,'quizzes',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(224,9,'registrations',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(225,9,'reservations',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(226,9,'rss_readers',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(227,9,'searches',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(228,9,'tasks',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(229,9,'topics',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(230,9,'videos',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(240,10,'access_counters',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(241,10,'announcements',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(242,10,'bbses',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(243,10,'blogs',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(244,10,'cabinets',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(245,10,'calendars',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(246,10,'faqs',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(247,10,'iframes',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(248,10,'links',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(249,10,'menus',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(250,10,'multidatabases',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(251,10,'photo_albums',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(252,10,'reservations',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(253,10,'rss_readers',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(254,10,'searches',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(255,10,'tasks',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(256,10,'topics',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(257,10,'videos',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(271,11,'access_counters',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(272,11,'announcements',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(273,11,'bbses',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(274,11,'blogs',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(275,11,'cabinets',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(276,11,'calendars',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(277,11,'circular_notices',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(278,11,'faqs',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(279,11,'iframes',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(280,11,'links',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(281,11,'menus',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(282,11,'multidatabases',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(283,11,'photo_albums',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(284,11,'questionnaires',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(285,11,'quizzes',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(286,11,'registrations',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(287,11,'reservations',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(288,11,'rss_readers',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(289,11,'searches',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(290,11,'tasks',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(291,11,'topics',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(292,11,'videos',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(302,11,'access_counters',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(303,11,'announcements',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(304,11,'bbses',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(305,11,'blogs',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(306,11,'cabinets',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(307,11,'calendars',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(308,11,'circular_notices',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(309,11,'faqs',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(310,11,'iframes',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(311,11,'links',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(312,11,'menus',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(313,11,'multidatabases',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(314,11,'photo_albums',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(315,11,'questionnaires',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(316,11,'quizzes',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(317,11,'registrations',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(318,11,'reservations',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(319,11,'rss_readers',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(320,11,'searches',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(321,11,'tasks',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(322,11,'topics',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(323,11,'videos',1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(333,12,'access_counters',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(334,12,'announcements',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(335,12,'bbses',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(336,12,'blogs',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(337,12,'cabinets',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(338,12,'calendars',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(339,12,'faqs',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(340,12,'iframes',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(341,12,'links',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(342,12,'menus',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(343,12,'multidatabases',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(344,12,'photo_albums',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(345,12,'reservations',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(346,12,'rss_readers',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(347,12,'searches',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(348,12,'tasks',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(349,12,'topics',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(350,12,'videos',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `plugins_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire_answer_summaries`
--

DROP TABLE IF EXISTS `questionnaire_answer_summaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire_answer_summaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer_status` int(4) DEFAULT NULL COMMENT '回答状態 1ページずつ表示するようなアンケートの場合、途中状態か否か | 0:回答未完了 | 1:回答完了',
  `test_status` int(4) DEFAULT NULL COMMENT 'テスト時の回答かどうか 0:本番回答 | 1:テスト時回答',
  `answer_number` int(11) DEFAULT NULL COMMENT '回答回数　ログインして回答している人物の場合に限定して回答回数をカウントする',
  `answer_time` datetime DEFAULT NULL COMMENT '回答完了の時刻　ページわけされている場合、insert_timeは回答開始時刻となるため、完了時刻を設ける',
  `questionnaire_key` varchar(255) NOT NULL,
  `session_value` text COMMENT 'アンケート回答した時のセッション値を保存します。',
  `user_id` int(11) DEFAULT NULL COMMENT 'ログイン後、アンケートに回答した人のusersテーブルのid。未ログインの場合NULL',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire_answer_summaries`
--

LOCK TABLES `questionnaire_answer_summaries` WRITE;
/*!40000 ALTER TABLE `questionnaire_answer_summaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaire_answer_summaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire_answers`
--

DROP TABLE IF EXISTS `questionnaire_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matrix_choice_key` varchar(255) DEFAULT NULL,
  `answer_value` text COMMENT '回答した文字列を設定する\n選択肢、リストなどの選ぶだけの場合は、選択肢のid値:ラベルを入れる\n\n選択肢タイプで「その他」を選んだ場合は、入力されたテキストは、ここではなく、other_answer_valueに入れる。\n\n複数選択肢\nこれらの場合は、(id値):(ラベル)を|つなぎで並べる。\n',
  `other_answer_value` text COMMENT '選択しタイプで「その他」を選んだ場合、入力されたテキストはここに入る。',
  `questionnaire_answer_summary_id` int(11) NOT NULL,
  `questionnaire_question_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questionnaire_answer_questionnaire_answer_summary1_idx` (`questionnaire_answer_summary_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire_answers`
--

LOCK TABLES `questionnaire_answers` WRITE;
/*!40000 ALTER TABLE `questionnaire_answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaire_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire_choices`
--

DROP TABLE IF EXISTS `questionnaire_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `matrix_type` int(4) DEFAULT NULL COMMENT 'マトリックスタイプの場合の行列区分 | 0:行 | 1:列',
  `other_choice_type` int(4) NOT NULL DEFAULT '0' COMMENT 'その他欄か否か、また、その他欄の入力エリアタイプ | 0:その他欄でない | 1:テキストタイプを伴ったその他欄 | 2:テキストエリアタイプを伴ったその他欄\n\n',
  `choice_sequence` int(11) NOT NULL COMMENT '選択肢並び順',
  `choice_label` text COMMENT '''選択肢ラベル''',
  `choice_value` text COMMENT '選択肢の値　デフォルトでidと同じ値が入る（将来、選択肢の値を任意に設定して重みアンケができるよう）',
  `skip_page_sequence` int(11) DEFAULT NULL COMMENT 'questionnairesのskip_flagがスキップ有りの時、スキップ先のページ',
  `jump_route_number` int(11) DEFAULT NULL COMMENT 'questionnaire_questionsのis_jumpが有りのとき、分岐先のルート',
  `graph_color` varchar(16) DEFAULT NULL COMMENT 'グラフ描画時の色',
  `questionnaire_question_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questionnaire_choice_questionnaire_question1_idx` (`questionnaire_question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire_choices`
--

LOCK TABLES `questionnaire_choices` WRITE;
/*!40000 ALTER TABLE `questionnaire_choices` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaire_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire_frame_display_questionnaires`
--

DROP TABLE IF EXISTS `questionnaire_frame_display_questionnaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire_frame_display_questionnaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `questionnaire_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questionnaire_frame_display_questionnaires_questionnaire_idx` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire_frame_display_questionnaires`
--

LOCK TABLES `questionnaire_frame_display_questionnaires` WRITE;
/*!40000 ALTER TABLE `questionnaire_frame_display_questionnaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaire_frame_display_questionnaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire_frame_settings`
--

DROP TABLE IF EXISTS `questionnaire_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_type` int(4) DEFAULT NULL COMMENT '0:単一表示(default)|1:リスト表示',
  `display_num_per_page` int(3) DEFAULT NULL COMMENT 'リスト表示の場合、１ページ当たりに表示するアンケート件数',
  `sort_type` varchar(255) DEFAULT NULL,
  `frame_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questionnaire_frame_settings_frames1_idx` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire_frame_settings`
--

LOCK TABLES `questionnaire_frame_settings` WRITE;
/*!40000 ALTER TABLE `questionnaire_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaire_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire_pages`
--

DROP TABLE IF EXISTS `questionnaire_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `questionnaire_id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL COMMENT 'ページ名',
  `route_number` int(11) NOT NULL DEFAULT '0',
  `page_sequence` int(11) NOT NULL COMMENT 'ページ表示順',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questionnaire_pages_questionnaires1_idx` (`questionnaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire_pages`
--

LOCK TABLES `questionnaire_pages` WRITE;
/*!40000 ALTER TABLE `questionnaire_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaire_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaire_questions`
--

DROP TABLE IF EXISTS `questionnaire_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaire_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `question_sequence` int(11) NOT NULL COMMENT '質問表示順',
  `question_value` varchar(255) DEFAULT NULL,
  `question_type` int(4) NOT NULL COMMENT '質問タイプ | 1:択一選択 | 2:複数選択 | 3:テキスト | 4:テキストエリア | 5:マトリクス（択一） | 6:マトリクス（複数） | 7:日付・時刻 | 8:リスト\n',
  `description` text,
  `is_require` tinyint(1) NOT NULL DEFAULT '0' COMMENT '回答必須フラグ | 0:不要 | 1:必須',
  `question_type_option` int(4) DEFAULT NULL COMMENT '1: 数値 | 2:日付(未実装) | 3:時刻(未実装) | 4:メール(未実装) | 5:URL(未実装) | 6:電話番号(未実装) | HTML５チェックで将来的に実装されそうなものに順次対応',
  `is_choice_random` tinyint(1) NOT NULL DEFAULT '0' COMMENT '選択肢表示順序ランダム化 | 質問タイプが1:択一選択 2:複数選択 6:マトリクス（択一） 7:マトリクス（複数） のとき有効 ただし、６，７については行がランダムになるだけで列はランダム化されない',
  `is_choice_horizon` tinyint(1) NOT NULL DEFAULT '0',
  `is_skip` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'アンケート回答のスキップ有無  0:スキップ 無し  1:スキップ有り',
  `is_jump` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'アンケート回答の分岐',
  `is_range` tinyint(1) NOT NULL DEFAULT '0' COMMENT '範囲設定しているか否か',
  `min` varchar(32) DEFAULT NULL COMMENT '最小値　question_typeがテキストで数値タイプのときのみ有効 ',
  `max` varchar(32) DEFAULT NULL COMMENT '最大値　question_typeがテキストで数値タイプのときのみ有効 ',
  `is_result_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '集計結果表示をするか否か | 0:しない | 1:する',
  `result_display_type` int(4) DEFAULT NULL COMMENT '表示形式デファイン値が｜区切りで保存される | 0:棒グラフ（マトリクスのときは自動的に積み上げ棒グラフ） | 1:円グラフ | 2:表\n',
  `questionnaire_page_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questionnaire_question_questionnaire_page1_idx` (`questionnaire_page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire_questions`
--

LOCK TABLES `questionnaire_questions` WRITE;
/*!40000 ALTER TABLE `questionnaire_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaire_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaires`
--

DROP TABLE IF EXISTS `questionnaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '公開中データか否か',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新編集データであるか否か',
  `block_id` int(11) NOT NULL,
  `status` int(4) DEFAULT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `title` varchar(255) DEFAULT NULL COMMENT 'アンケートタイトル',
  `title_icon` varchar(255) DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL COMMENT 'アンケートサブタイトル',
  `answer_timing` int(4) NOT NULL DEFAULT '0',
  `answer_start_period` datetime DEFAULT NULL,
  `answer_end_period` datetime DEFAULT NULL,
  `is_no_member_allow` tinyint(1) DEFAULT '0' COMMENT '非会員の回答を許可するか | 0:許可しない | 1:許可する',
  `is_anonymity` tinyint(1) DEFAULT '0' COMMENT '会員回答であっても匿名扱いとするか否か | 0:非匿名 | 1:匿名',
  `is_key_pass_use` tinyint(1) DEFAULT '0' COMMENT 'キーフレーズによる回答ガードを設けるか | 0:キーフレーズガードは用いない | 1:キーフレーズガードを用いる',
  `is_repeat_allow` tinyint(1) DEFAULT '0',
  `is_total_show` tinyint(1) DEFAULT '1' COMMENT '集計結果を表示するか否か | 0:表示しない | 1:表示する',
  `total_show_timing` int(4) DEFAULT '0' COMMENT '集計結果を表示するタイミング | 0:アンケート回答後、すぐ | 1:期間設定',
  `total_show_start_period` datetime DEFAULT NULL,
  `total_comment` text COMMENT '集計表示ページの先頭に書くメッセージコメント',
  `is_image_authentication` tinyint(1) DEFAULT '0' COMMENT 'SPAMガード項目を表示するか否か | 0:表示しない | 1:表示する',
  `thanks_content` text COMMENT 'アンケート最後に表示するお礼メッセージ',
  `is_open_mail_send` tinyint(1) DEFAULT '0' COMMENT 'アンケート開始メールを送信するか(現在未使用) | 0:しない | 1:する',
  `open_mail_subject` varchar(255) DEFAULT 'Questionnaire to you has arrived' COMMENT 'アンケート開始メールタイトル(現在未使用)',
  `open_mail_body` text COMMENT 'アンケート開始通知メール本文(現在未使用)',
  `is_answer_mail_send` tinyint(1) DEFAULT '0' COMMENT 'アンケート回答時に編集者、編集長にメールで知らせるか否か | 0:知らせない| 1:知らせる\n',
  `is_page_random` tinyint(1) DEFAULT '0' COMMENT 'ページ表示順序ランダム化（※将来機能）\n選択肢分岐機能との兼ね合いを考えなくてはならないため、現時点での機能盛り込みは見送る',
  `import_key` varchar(255) DEFAULT NULL,
  `export_key` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questionnaires_blocks1_idx` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaires`
--

LOCK TABLES `questionnaires` WRITE;
/*!40000 ALTER TABLE `questionnaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_answer_summaries`
--

DROP TABLE IF EXISTS `quiz_answer_summaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_answer_summaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer_status` int(4) DEFAULT NULL COMMENT '途中状態か否か | 0:回答未完了 | 1:回答完了確認待ち | 2:確認完了',
  `test_status` int(4) DEFAULT NULL COMMENT 'テスト時の回答かどうか 0:本番回答 | 1:テスト時回答',
  `answer_number` int(11) DEFAULT NULL COMMENT '回答回数　ログインして回答している人物の場合に限定して回答回数をカウントする',
  `is_grade_finished` tinyint(1) NOT NULL DEFAULT '0' COMMENT '採点が完了しているかどうか',
  `summary_score` int(11) NOT NULL DEFAULT '0' COMMENT '得点',
  `passing_status` int(11) NOT NULL DEFAULT '0' COMMENT '0:合格判定なし 1:合格 2:不合格',
  `answer_start_time` datetime DEFAULT NULL COMMENT '回答開始時刻 小テストの開始画面でPOSTした時刻',
  `answer_finish_time` datetime DEFAULT NULL COMMENT '回答完了時刻 確認ボタンをクリックした時刻',
  `elapsed_second` int(11) DEFAULT '0' COMMENT '回答にかかった時間(秒)',
  `within_time_status` int(11) NOT NULL DEFAULT '0' COMMENT '0:時間判定なし 1:時間内 2:時間オーバー',
  `quiz_key` varchar(255) NOT NULL,
  `session_value` text COMMENT 'アンケート回答した時のセッション値を保存します。',
  `user_id` int(11) DEFAULT NULL COMMENT 'ログイン後、アンケートに回答した人のusersテーブルのid。未ログインの場合NULL',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_answer_summaries`
--

LOCK TABLES `quiz_answer_summaries` WRITE;
/*!40000 ALTER TABLE `quiz_answer_summaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_answer_summaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_answers`
--

DROP TABLE IF EXISTS `quiz_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer_value` text COMMENT '回答した文字列を設定する\\n選択肢、択一の場合は、選択肢のid値:ラベルを入れる\\n\\n複数選択肢\\nこれらの場合は、(id値):(ラベル)を|つなぎで並べる。\\n',
  `answer_correct_status` text NOT NULL,
  `correct_status` int(11) NOT NULL DEFAULT '0' COMMENT '0:未採点 1:不正解 2:正解',
  `score` int(11) NOT NULL DEFAULT '0',
  `quiz_answer_summary_id` int(11) NOT NULL,
  `quiz_question_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quiz_answer_quiz_answer_summary1_idx` (`quiz_answer_summary_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_answers`
--

LOCK TABLES `quiz_answers` WRITE;
/*!40000 ALTER TABLE `quiz_answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_choices`
--

DROP TABLE IF EXISTS `quiz_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `choice_sequence` int(11) NOT NULL COMMENT '選択肢並び順',
  `choice_label` text COMMENT '選択肢ラベル',
  `quiz_question_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quiz_choice_quiz_question1_idx` (`quiz_question_id`),
  KEY `fk_quiz_choices_languages1_idx` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_choices`
--

LOCK TABLES `quiz_choices` WRITE;
/*!40000 ALTER TABLE `quiz_choices` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_corrects`
--

DROP TABLE IF EXISTS `quiz_corrects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_corrects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `correct_sequence` int(11) NOT NULL COMMENT '順番',
  `correct_label` text NOT NULL COMMENT '複数単語の場合に使用。見出しラベル',
  `correct` text COMMENT '正解',
  `quiz_question_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quiz_correct_quiz_question1_idx` (`quiz_question_id`),
  KEY `fk_quiz_correct_languages1_idx` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_corrects`
--

LOCK TABLES `quiz_corrects` WRITE;
/*!40000 ALTER TABLE `quiz_corrects` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_corrects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_frame_display_quizzes`
--

DROP TABLE IF EXISTS `quiz_frame_display_quizzes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_frame_display_quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `quiz_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_key` (`quiz_key`),
  KEY `fk_quiz_frame_display_quizzes_quiz_idx` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_frame_display_quizzes`
--

LOCK TABLES `quiz_frame_display_quizzes` WRITE;
/*!40000 ALTER TABLE `quiz_frame_display_quizzes` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_frame_display_quizzes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_frame_settings`
--

DROP TABLE IF EXISTS `quiz_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_type` int(4) DEFAULT NULL COMMENT '0:単一表示(default)|1:リスト表示',
  `display_num_per_page` int(3) DEFAULT NULL COMMENT 'リスト表示の場合、１ページ当たりに表示するアンケート件数',
  `sort_type` varchar(255) DEFAULT NULL,
  `frame_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quiz_frame_settings_frames1_idx` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_frame_settings`
--

LOCK TABLES `quiz_frame_settings` WRITE;
/*!40000 ALTER TABLE `quiz_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_pages`
--

DROP TABLE IF EXISTS `quiz_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `quiz_id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL COMMENT 'ページ名',
  `page_sequence` int(11) NOT NULL COMMENT 'ページ順',
  `is_page_description` tinyint(1) DEFAULT '0' COMMENT 'ページ先頭に文章を表示するか',
  `page_description` text COMMENT 'ページ先頭文章',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quiz_pages_quizzes1_idx` (`quiz_id`),
  KEY `fk_quiz_pages_languages1_idx` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_pages`
--

LOCK TABLES `quiz_pages` WRITE;
/*!40000 ALTER TABLE `quiz_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_questions`
--

DROP TABLE IF EXISTS `quiz_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `question_sequence` int(11) NOT NULL COMMENT '質問表示順',
  `question_value` text COMMENT '質問文',
  `question_type` int(4) NOT NULL COMMENT '質問タイプ | 1:択一選択 | 2:複数選択 | 3:単語 | 4:単語（複数） | 5:記述式',
  `is_choice_random` tinyint(1) NOT NULL DEFAULT '0' COMMENT '選択肢表示順序ランダム化 | 質問タイプが1:択一選択 2:複数選択 のとき有効',
  `is_choice_horizon` tinyint(1) NOT NULL DEFAULT '0',
  `is_order_fixed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '単語複数時順番固定化 | 質問タイプが4:単語（複数） のとき有効',
  `allotment` int(11) NOT NULL DEFAULT '0' COMMENT '配点',
  `commentary` text COMMENT '解説',
  `quiz_page_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quiz_question_quiz_page1_idx` (`quiz_page_id`),
  KEY `fk_quiz_questions_languages1_idx` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_questions`
--

LOCK TABLES `quiz_questions` WRITE;
/*!40000 ALTER TABLE `quiz_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `quiz_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '公開中データか否か',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新編集データであるか否か',
  `block_id` int(11) NOT NULL,
  `status` int(4) DEFAULT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `title` varchar(255) DEFAULT NULL COMMENT '小テストタイトル',
  `passing_grade` int(4) NOT NULL DEFAULT '0' COMMENT '合格点',
  `estimated_time` int(4) NOT NULL DEFAULT '0' COMMENT '時間の目安(分)',
  `answer_timing` int(4) NOT NULL DEFAULT '0',
  `answer_start_period` datetime DEFAULT NULL,
  `answer_end_period` datetime DEFAULT NULL,
  `is_no_member_allow` tinyint(1) DEFAULT '0' COMMENT '非会員の回答を許可するか | 0:許可しない | 1:許可する',
  `is_key_pass_use` tinyint(1) DEFAULT '0' COMMENT 'キーフレーズによる回答ガードを設けるか | 0:キーフレーズガードは用いない | 1:キーフレーズガードを用いる',
  `is_image_authentication` tinyint(1) DEFAULT '0' COMMENT 'SPAMガード項目を表示するか否か | 0:表示しない | 1:表示する',
  `is_repeat_allow` tinyint(1) DEFAULT '0' COMMENT '繰り返しを許す',
  `is_repeat_until_passing` tinyint(1) DEFAULT '0' COMMENT '繰り返しは合格まで',
  `is_page_random` tinyint(1) DEFAULT '0' COMMENT 'ページ表示順序ランダム化',
  `perfect_score` int(11) NOT NULL DEFAULT '0' COMMENT '満点',
  `is_correct_show` tinyint(1) DEFAULT '1' COMMENT '正解を表示するか否か | 0:表示しない | 1:表示する',
  `is_total_show` tinyint(1) DEFAULT '1' COMMENT '集計結果を表示するか否か | 0:表示しない | 1:表示する',
  `is_answer_mail_send` tinyint(1) NOT NULL DEFAULT '0',
  `import_key` varchar(255) DEFAULT NULL,
  `export_key` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quizzes_blocks1_idx` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quizzes`
--

LOCK TABLES `quizzes` WRITE;
/*!40000 ALTER TABLE `quizzes` DISABLE KEYS */;
/*!40000 ALTER TABLE `quizzes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_answer_summaries`
--

DROP TABLE IF EXISTS `registration_answer_summaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration_answer_summaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_number` int(11) unsigned NOT NULL DEFAULT '0',
  `answer_status` int(4) DEFAULT NULL COMMENT '登録状態 1ページずつ表示するような登録フォームの場合、途中状態か否か | 0:登録未完了 | 1:登録完了',
  `test_status` int(4) DEFAULT NULL COMMENT 'テスト時の登録かどうか 0:本番登録 | 1:テスト時登録',
  `answer_number` int(11) DEFAULT NULL COMMENT '登録回数　ログインして登録している人物の場合に限定して登録回数をカウントする',
  `answer_time` datetime DEFAULT NULL COMMENT '登録完了の時刻　ページわけされている場合、insert_timeは登録開始時刻となるため、完了時刻を設ける',
  `registration_key` varchar(255) NOT NULL,
  `session_value` text COMMENT '登録フォーム登録した時のセッション値を保存します。',
  `user_id` int(11) DEFAULT NULL COMMENT 'ログイン後、登録フォームに登録した人のusersテーブルのid。未ログインの場合NULL',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_answer_summaries`
--

LOCK TABLES `registration_answer_summaries` WRITE;
/*!40000 ALTER TABLE `registration_answer_summaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration_answer_summaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_answers`
--

DROP TABLE IF EXISTS `registration_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matrix_choice_key` varchar(255) DEFAULT NULL,
  `answer_value` text COMMENT '登録した文字列を設定する\n選択肢、リストなどの選ぶだけの場合は、選択肢のid値:ラベルを入れる\n\n選択肢タイプで「その他」を選んだ場合は、入力されたテキストは、ここではなく、other_answer_valueに入れる。\n\n複数選択肢\nこれらの場合は、(id値):(ラベル)を|つなぎで並べる。\n',
  `other_answer_value` text COMMENT '選択しタイプで「その他」を選んだ場合、入力されたテキストはここに入る。',
  `registration_answer_summary_id` int(11) NOT NULL,
  `registration_question_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_registration_answer_registration_answer_summary1_idx` (`registration_answer_summary_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_answers`
--

LOCK TABLES `registration_answers` WRITE;
/*!40000 ALTER TABLE `registration_answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_choices`
--

DROP TABLE IF EXISTS `registration_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `matrix_type` int(4) DEFAULT NULL COMMENT 'マトリックスタイプの場合の行列区分 | 0:行 | 1:列',
  `other_choice_type` int(4) NOT NULL DEFAULT '0' COMMENT 'その他欄か否か、また、その他欄の入力エリアタイプ | 0:その他欄でない | 1:テキストタイプを伴ったその他欄 | 2:テキストエリアタイプを伴ったその他欄\n\n',
  `choice_sequence` int(11) NOT NULL COMMENT '選択肢並び順',
  `choice_label` text COMMENT '''選択肢ラベル''',
  `choice_value` text COMMENT '選択肢の値　デフォルトでidと同じ値が入る（将来、選択肢の値を任意に設定して重みアンケができるよう）',
  `skip_page_sequence` int(11) DEFAULT NULL COMMENT 'registrationsのskip_flagがスキップ有りの時、スキップ先のページ',
  `jump_route_number` int(11) DEFAULT NULL COMMENT 'registration_questionsのis_jumpが有りのとき、分岐先のルート',
  `graph_color` varchar(16) DEFAULT NULL COMMENT 'グラフ描画時の色',
  `registration_question_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_registration_choice_registration_question1_idx` (`registration_question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_choices`
--

LOCK TABLES `registration_choices` WRITE;
/*!40000 ALTER TABLE `registration_choices` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_pages`
--

DROP TABLE IF EXISTS `registration_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `registration_id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL COMMENT 'ページ名',
  `route_number` int(11) NOT NULL DEFAULT '0',
  `page_sequence` int(11) NOT NULL COMMENT 'ページ表示順',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_registration_pages_registrations1_idx` (`registration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_pages`
--

LOCK TABLES `registration_pages` WRITE;
/*!40000 ALTER TABLE `registration_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_questions`
--

DROP TABLE IF EXISTS `registration_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `question_sequence` int(11) NOT NULL COMMENT '質問表示順',
  `question_value` varchar(255) DEFAULT NULL,
  `question_type` int(4) NOT NULL COMMENT '質問タイプ | 1:択一選択 | 2:複数選択 | 3:テキスト | 4:テキストエリア | 5:マトリクス（択一） | 6:マトリクス（複数） | 7:日付・時刻 | 8:リスト\n',
  `description` text,
  `is_require` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登録必須フラグ | 0:不要 | 1:必須',
  `question_type_option` int(4) DEFAULT NULL COMMENT '1: 数値 | 2:日付(未実装) | 3:時刻(未実装) | 4:メール(未実装) | 5:URL(未実装) | 6:電話番号(未実装) | HTML５チェックで将来的に実装されそうなものに順次対応',
  `is_choice_random` tinyint(1) NOT NULL DEFAULT '0' COMMENT '選択肢表示順序ランダム化 | 質問タイプが1:択一選択 2:複数選択 6:マトリクス（択一） 7:マトリクス（複数） のとき有効 ただし、６，７については行がランダムになるだけで列はランダム化されない',
  `is_choice_horizon` tinyint(1) NOT NULL DEFAULT '0',
  `is_skip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登録フォーム登録のスキップ有無  0:スキップ 無し  1:スキップ有り',
  `is_jump` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登録フォーム登録の分岐',
  `is_range` tinyint(1) NOT NULL DEFAULT '0' COMMENT '範囲設定しているか否か',
  `min` varchar(32) DEFAULT NULL COMMENT '最小値　question_typeがテキストで数値タイプのときのみ有効 ',
  `max` varchar(32) DEFAULT NULL COMMENT '最大値　question_typeがテキストで数値タイプのときのみ有効 ',
  `is_result_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '集計結果表示をするか否か | 0:しない | 1:する',
  `result_display_type` int(4) DEFAULT NULL COMMENT '表示形式デファイン値が｜区切りで保存される | 0:棒グラフ（マトリクスのときは自動的に積み上げ棒グラフ） | 1:円グラフ | 2:表\n',
  `registration_page_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_registration_question_registration_page1_idx` (`registration_page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_questions`
--

LOCK TABLES `registration_questions` WRITE;
/*!40000 ALTER TABLE `registration_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `registration_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '公開中データか否か',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新編集データであるか否か',
  `block_id` int(11) NOT NULL,
  `status` int(4) DEFAULT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `title` varchar(255) DEFAULT NULL COMMENT '登録フォームタイトル',
  `title_icon` varchar(255) DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL COMMENT '登録フォームサブタイトル',
  `answer_timing` int(4) NOT NULL DEFAULT '0',
  `answer_start_period` datetime DEFAULT NULL,
  `answer_end_period` datetime DEFAULT NULL,
  `is_no_member_allow` tinyint(1) DEFAULT '1' COMMENT '非会員の登録を許可するか | 0:許可しない | 1:許可する',
  `is_anonymity` tinyint(1) DEFAULT '0' COMMENT '会員登録であっても匿名扱いとするか否か | 0:非匿名 | 1:匿名',
  `is_key_pass_use` tinyint(1) DEFAULT '0' COMMENT 'キーフレーズによる登録ガードを設けるか | 0:キーフレーズガードは用いない | 1:キーフレーズガードを用いる',
  `is_repeat_allow` tinyint(1) DEFAULT '1',
  `is_total_show` tinyint(1) DEFAULT '1' COMMENT '集計結果を表示するか否か | 0:表示しない | 1:表示する',
  `total_show_timing` int(4) DEFAULT '0' COMMENT '集計結果を表示するタイミング | 0:登録フォーム登録後、すぐ | 1:期間設定',
  `total_show_start_period` datetime DEFAULT NULL,
  `total_comment` text COMMENT '集計表示ページの先頭に書くメッセージコメント',
  `is_image_authentication` tinyint(1) DEFAULT '0' COMMENT 'SPAMガード項目を表示するか否か | 0:表示しない | 1:表示する',
  `thanks_content` text COMMENT '登録フォーム最後に表示するお礼メッセージ',
  `is_open_mail_send` tinyint(1) DEFAULT '0' COMMENT '登録フォーム開始メールを送信するか(現在未使用) | 0:しない | 1:する',
  `open_mail_subject` varchar(255) DEFAULT 'Registration to you has arrived' COMMENT '登録フォーム開始メールタイトル(現在未使用)',
  `open_mail_body` text COMMENT '登録フォーム開始通知メール本文(現在未使用)',
  `is_answer_mail_send` tinyint(1) DEFAULT '0' COMMENT '登録フォーム登録時に編集者、編集長にメールで知らせるか否か | 0:知らせない| 1:知らせる\n',
  `reply_to` varchar(255) DEFAULT NULL,
  `is_regist_user_send` tinyint(1) NOT NULL DEFAULT '0',
  `registration_mail_subject` varchar(255) NOT NULL,
  `registration_mail_body` text NOT NULL,
  `is_page_random` tinyint(1) DEFAULT '0' COMMENT 'ページ表示順序ランダム化（※将来機能）\n選択肢分岐機能との兼ね合いを考えなくてはならないため、現時点での機能盛り込みは見送る',
  `is_limit_number` tinyint(1) DEFAULT '0',
  `limit_number` int(11) DEFAULT NULL,
  `import_key` varchar(255) DEFAULT NULL,
  `export_key` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_registrations_blocks1_idx` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrations`
--

LOCK TABLES `registrations` WRITE;
/*!40000 ALTER TABLE `registrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_event_share_users`
--

DROP TABLE IF EXISTS `reservation_event_share_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_event_share_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `reservation_event_id` int(11) NOT NULL,
  `share_user` int(11) DEFAULT '0' COMMENT '情報共有者',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_event_share_users`
--

LOCK TABLES `reservation_event_share_users` WRITE;
/*!40000 ALTER TABLE `reservation_event_share_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_event_share_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_events`
--

DROP TABLE IF EXISTS `reservation_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `reservation_rrule_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL COMMENT 'イベントKey',
  `room_id` int(11) NOT NULL COMMENT 'ルームID',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `target_user` int(11) DEFAULT '0' COMMENT '対象者',
  `title` varchar(255) NOT NULL COMMENT 'タイトル',
  `title_icon` varchar(255) NOT NULL COMMENT 'タイトル アイコン',
  `location` varchar(255) NOT NULL COMMENT '場所',
  `contact` varchar(255) NOT NULL COMMENT '連絡先',
  `description` text COMMENT '詳細',
  `is_allday` tinyint(1) DEFAULT '1' COMMENT '終日かどうか | 0:終日ではない | 1:終日',
  `start_date` varchar(8) NOT NULL COMMENT '開始日 (YYYYMMDD形式)',
  `start_time` varchar(6) NOT NULL COMMENT '開始時刻 (hhmmss形式)',
  `dtstart` varchar(14) NOT NULL COMMENT '開始日時 (YYYYMMDDhhmmss) iReservationのDTDSTARTからTとZを外したもの',
  `end_date` varchar(8) NOT NULL COMMENT '終了日 (YYYYMMDD形式)',
  `end_time` varchar(6) NOT NULL COMMENT '終了時刻 (hhmmss形式)',
  `dtend` varchar(14) NOT NULL COMMENT '終了日時 (YYYYMMDDhhmmss形式) iReservationのDTENDからTとZをはずしたもの',
  `timezone_offset` float(3,1) NOT NULL DEFAULT '0.0' COMMENT 'タイムゾーンオフセット-12.0～+12.0',
  `timezone` varchar(255) DEFAULT NULL,
  `location_key` varchar(255) DEFAULT NULL,
  `status` int(4) NOT NULL COMMENT '公開状況  1:公開中>、2:公 開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新コンテンツかどうか 0:最新でない 1:最新',
  `recurrence_event_id` int(11) NOT NULL DEFAULT '0' COMMENT '1以上のとき、再発(置換）イベントidを指す。VCALENDERのRECURRENCE-ID機能実現のための項目',
  `exception_event_id` int(11) NOT NULL DEFAULT '0' COMMENT '1以上のとき、例外（削除）イベントidを指す。vreservationの EXDATE機能実現のための項目',
  `is_enable_mail` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'イベント前にメール通知するかどうか 0:通知しない 1:通知する',
  `email_send_timing` int(11) NOT NULL DEFAULT '0' COMMENT 'イベントN分前メール通知の値N。単位は分。',
  `calendar_key` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_events`
--

LOCK TABLES `reservation_events` WRITE;
/*!40000 ALTER TABLE `reservation_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_frame_settings`
--

DROP TABLE IF EXISTS `reservation_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `display_type` int(4) NOT NULL DEFAULT '0' COMMENT '表示方法',
  `location_key` varchar(255) DEFAULT NULL COMMENT '最初に表示する施設',
  `category_id` int(10) unsigned DEFAULT NULL COMMENT '最初に表示する施設カテゴリID',
  `display_timeframe` tinyint(1) NOT NULL DEFAULT '0' COMMENT '時間枠表時',
  `display_start_time_type` int(4) DEFAULT '0' COMMENT '0:閲覧時刻により変動 1:固定',
  `start_pos` int(4) NOT NULL DEFAULT '0' COMMENT '開始位置',
  `display_count` int(4) NOT NULL DEFAULT '0' COMMENT '表示日数',
  `is_myroom` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'プライベートルームの施設予約コンポーネント（イベント等)を表示するかどうか 0:表示しない 1:表示する',
  `is_select_room` tinyint(1) NOT NULL DEFAULT '0' COMMENT '指定したルームのみ表示するかどうか 0:表示しない 1:表示する',
  `room_id` int(11) NOT NULL COMMENT 'ルームID',
  `timeline_base_time` int(11) NOT NULL COMMENT '表示開始時',
  `display_interval` int(11) DEFAULT NULL COMMENT '表示幅（時間）',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_frame_settings`
--

LOCK TABLES `reservation_frame_settings` WRITE;
/*!40000 ALTER TABLE `reservation_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_location_reservable`
--

DROP TABLE IF EXISTS `reservation_location_reservable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_location_reservable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_key` varchar(255) NOT NULL COMMENT '施設キー',
  `role_key` varchar(255) NOT NULL COMMENT 'ロールキー',
  `room_id` int(11) DEFAULT NULL,
  `value` tinyint(1) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `location_key` (`location_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_location_reservable`
--

LOCK TABLES `reservation_location_reservable` WRITE;
/*!40000 ALTER TABLE `reservation_location_reservable` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_location_reservable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_locations`
--

DROP TABLE IF EXISTS `reservation_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `category_id` int(11) unsigned DEFAULT '0',
  `location_name` varchar(255) NOT NULL COMMENT '施設名',
  `detail` text,
  `add_authority` tinyint(1) NOT NULL DEFAULT '0',
  `time_table` varchar(32) NOT NULL COMMENT '利用可能な曜日',
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `use_private` tinyint(1) NOT NULL DEFAULT '0',
  `use_auth_flag` tinyint(1) NOT NULL DEFAULT '0',
  `use_all_rooms` tinyint(1) NOT NULL DEFAULT '0',
  `use_workflow` tinyint(1) NOT NULL DEFAULT '0',
  `weight` int(11) unsigned NOT NULL DEFAULT '0',
  `contact` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_locations`
--

LOCK TABLES `reservation_locations` WRITE;
/*!40000 ALTER TABLE `reservation_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_locations_approval_users`
--

DROP TABLE IF EXISTS `reservation_locations_approval_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_locations_approval_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `location_key` varchar(255) NOT NULL DEFAULT '0' COMMENT '施設キー',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '承認者',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_locations_approval_users`
--

LOCK TABLES `reservation_locations_approval_users` WRITE;
/*!40000 ALTER TABLE `reservation_locations_approval_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_locations_approval_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_locations_rooms`
--

DROP TABLE IF EXISTS `reservation_locations_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_locations_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_location_key` varchar(255) NOT NULL,
  `room_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_locations_rooms`
--

LOCK TABLES `reservation_locations_rooms` WRITE;
/*!40000 ALTER TABLE `reservation_locations_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_locations_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_rrules`
--

DROP TABLE IF EXISTS `reservation_rrules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_rrules` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `reservation_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL COMMENT '施設予約コンポーネント(イベント等)繰返し規則 キー',
  `name` varchar(255) NOT NULL COMMENT '施設予約コンポーネント(イベント等)繰返し規則名称',
  `rrule` text COMMENT '繰返し規則',
  `ireservation_uid` text NOT NULL COMMENT 'iReservationUIDの元となる情報。rrule分割元と分割先の関連性を記録する。',
  `ireservation_comp_name` varchar(255) NOT NULL COMMENT 'iReservation仕様のコンポーネント名 (vevent,vtodo,vjournal 等)',
  `room_id` int(11) NOT NULL DEFAULT '0' COMMENT 'ルームID',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_rrules`
--

LOCK TABLES `reservation_rrules` WRITE;
/*!40000 ALTER TABLE `reservation_rrules` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_rrules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation_timeframes`
--

DROP TABLE IF EXISTS `reservation_timeframes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation_timeframes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `title` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `color` varchar(16) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation_timeframes`
--

LOCK TABLES `reservation_timeframes` WRITE;
/*!40000 ALTER TABLE `reservation_timeframes` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation_timeframes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_key` varchar(255) NOT NULL COMMENT 'Block キー',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `key` varchar(255) DEFAULT NULL COMMENT 'ロールKey',
  `type` int(11) NOT NULL COMMENT 'ロールタイプ   1: User role, 2: Room role',
  `name` varchar(255) NOT NULL COMMENT 'ロール名',
  `description` text,
  `is_system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:システムのロール, 0:権限管理で追加したロール',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`,`language_id`),
  KEY `key` (`key`,`language_id`),
  KEY `role_id` (`language_id`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,2,1,1,0,'system_administrator',1,'システム管理者','システムの管理者。サイト構築に必要なシステム設定を行うことができます。',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(2,2,1,1,0,'administrator',1,'サイト管理者','サイトの最高責任者。すべての会員情報を閲覧でき、必要に応じて制限を加えることができます。ルームの新設／名称変更等の権限を持ち、ルームごとに運営メンバー（ルーム管理者や編集長、編集者）を指定することができます。',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(3,2,1,1,0,'common_user',1,'一般','一般会員。他人に対して、必要最低限の情報のみ閲覧できます。',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(4,1,0,1,0,'system_administrator',1,'System administrator','Super user of the system.',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(5,1,0,1,0,'administrator',1,'Site administrator','Super user of the site. The one with this authority can browse and edit all the acquired data of the users, and is assigned as a head of all the grouprooms built in the NetCommons. He/She is also a site manager of the NetCommons.',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(6,1,0,1,0,'common_user',1,'Common user','A common user',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(7,2,1,1,0,'room_administrator',2,'ルーム管理者','RoomRoleDesc.room_administrator',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(8,2,1,1,0,'chief_editor',2,'編集長','RoomRoleDesc.chief_editor',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(9,2,1,1,0,'editor',2,'編集者','RoomRoleDesc.editor',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(10,2,1,1,0,'general_user',2,'一般','RoomRoleDesc.general_user',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(11,2,1,1,0,'visitor',2,'ゲスト','RoomRoleDesc.visitor',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(12,1,0,1,0,'room_administrator',2,'Room Manager','RoomRoleDesc.room_administrator',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(13,1,0,1,0,'chief_editor',2,'Chief editor','RoomRoleDesc.chief_editor',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(14,1,0,1,0,'editor',2,'Editor','RoomRoleDesc.editor',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(15,1,0,1,0,'general_user',2,'General user','RoomRoleDesc.general_user',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(16,1,0,1,0,'visitor',2,'Guest','RoomRoleDesc.visitor',1,NULL,'2019-03-02 03:14:05',NULL,'2019-03-02 03:14:05'),(17,2,1,0,0,'guest_user',1,'ゲスト','プライベートルームおよびグループが作成できない会員。他人に対して、必要最低限の情報のみ閲覧できます。 ',0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(18,1,1,0,0,'guest_user',1,'Guest user','A guest user',0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_rooms`
--

DROP TABLE IF EXISTS `roles_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `role_key` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_key` (`role_key`,`room_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_rooms`
--

LOCK TABLES `roles_rooms` WRITE;
/*!40000 ALTER TABLE `roles_rooms` DISABLE KEYS */;
INSERT INTO `roles_rooms` VALUES (1,1,'room_administrator',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(2,1,'chief_editor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(3,1,'editor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(4,1,'general_user',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(5,1,'visitor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(6,2,'room_administrator',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(7,3,'room_administrator',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(8,3,'chief_editor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(9,3,'editor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(10,3,'general_user',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(11,3,'visitor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(12,4,'room_administrator',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(13,4,'chief_editor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(14,4,'editor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(15,4,'general_user',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(16,4,'visitor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(17,2,'chief_editor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(18,2,'editor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(19,2,'general_user',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(20,2,'visitor',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(21,5,'room_administrator',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(22,5,'chief_editor',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(23,5,'editor',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(24,5,'general_user',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(25,5,'visitor',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(28,6,'room_administrator',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(29,6,'chief_editor',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(30,6,'editor',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(31,6,'general_user',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(32,6,'visitor',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(35,7,'room_administrator',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(36,7,'chief_editor',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(37,7,'editor',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(38,7,'general_user',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(39,7,'visitor',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(42,8,'room_administrator',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(43,8,'chief_editor',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(44,8,'editor',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(45,8,'general_user',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(46,8,'visitor',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(49,9,'room_administrator',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(50,9,'chief_editor',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(51,9,'editor',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(52,9,'general_user',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(53,9,'visitor',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(56,10,'room_administrator',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(57,10,'chief_editor',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(58,10,'editor',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(59,10,'general_user',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(60,10,'visitor',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(63,11,'room_administrator',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(64,11,'chief_editor',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(65,11,'editor',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(66,11,'general_user',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(67,11,'visitor',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(70,12,'room_administrator',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(71,12,'chief_editor',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(72,12,'editor',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(73,12,'general_user',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(74,12,'visitor',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `roles_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_rooms_users`
--

DROP TABLE IF EXISTS `roles_rooms_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_rooms_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `access_count` int(11) NOT NULL DEFAULT '0',
  `last_accessed` datetime DEFAULT NULL,
  `previous_accessed` datetime DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`room_id`),
  KEY `roles_room_id` (`roles_room_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_rooms_users`
--

LOCK TABLES `roles_rooms_users` WRITE;
/*!40000 ALTER TABLE `roles_rooms_users` DISABLE KEYS */;
INSERT INTO `roles_rooms_users` VALUES (1,21,1,5,4,'2019-03-03 09:45:02','2019-03-02 13:44:28',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(2,1,1,1,4,'2019-03-03 09:45:02','2019-03-02 13:44:29',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(3,6,1,2,0,NULL,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(4,7,1,3,0,NULL,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(5,12,1,4,0,NULL,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(6,28,2,6,1,'2019-03-02 03:39:42',NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(7,5,2,1,1,'2019-03-02 03:39:42',NULL,1,'2019-03-02 03:18:09',1,'2019-03-02 03:18:09'),(8,16,2,4,0,NULL,NULL,1,'2019-03-02 03:18:09',1,'2019-03-02 03:18:09'),(9,11,2,3,0,NULL,NULL,1,'2019-03-02 03:18:09',1,'2019-03-02 03:18:09'),(10,20,2,2,0,NULL,NULL,1,'2019-03-02 03:18:09',1,'2019-03-02 03:18:09'),(11,35,3,7,0,NULL,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(12,5,3,1,0,NULL,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(13,16,3,4,0,NULL,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(14,11,3,3,0,NULL,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(15,20,3,2,0,NULL,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(16,42,1,8,2,'2019-03-03 09:45:29','2019-03-02 03:51:26',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(17,45,2,8,0,NULL,NULL,1,'2019-03-02 03:19:53',1,'2019-03-02 03:19:53'),(18,49,1,9,0,NULL,NULL,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(19,52,2,9,1,'2019-03-02 03:39:46',NULL,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:44'),(20,53,3,9,0,NULL,NULL,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(22,56,4,10,1,'2019-03-02 03:43:20',NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(23,3,4,1,1,'2019-03-02 03:43:20',NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(24,53,4,9,1,'2019-03-02 03:43:24',NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(25,14,4,4,0,NULL,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(26,9,4,3,0,NULL,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(27,18,4,2,0,NULL,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(29,63,1,11,1,'2019-03-02 03:51:28',NULL,1,'2019-03-02 03:42:37',1,'2019-03-02 03:42:37'),(30,66,2,11,0,NULL,NULL,1,'2019-03-02 03:42:52',1,'2019-03-02 03:42:52'),(31,70,5,12,0,NULL,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(32,5,5,1,0,NULL,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(33,53,5,9,0,NULL,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(34,46,5,8,0,NULL,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(35,67,5,11,0,NULL,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(36,16,5,4,0,NULL,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(37,11,5,3,0,NULL,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(38,20,5,2,0,NULL,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `roles_rooms_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_role_permissions`
--

DROP TABLE IF EXISTS `room_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roles_room_id` int(11) NOT NULL COMMENT 'ルーム毎のロールID',
  `permission` varchar(255) DEFAULT NULL COMMENT 'パーミッション  e.g.) content_creatable',
  `value` tinyint(1) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_room_id` (`roles_room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1235 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_role_permissions`
--

LOCK TABLES `room_role_permissions` WRITE;
/*!40000 ALTER TABLE `room_role_permissions` DISABLE KEYS */;
INSERT INTO `room_role_permissions` VALUES (1,1,'block_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(2,1,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(3,1,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(4,1,'content_comment_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(5,1,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(6,1,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(7,1,'content_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(8,1,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(9,1,'page_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(10,1,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(11,1,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(12,1,'mail_answer_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(13,1,'mail_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(14,2,'block_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(15,2,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(16,2,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(17,2,'content_comment_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(18,2,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(19,2,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(20,2,'content_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(21,2,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(22,2,'page_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(23,2,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(24,2,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(25,2,'mail_answer_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(26,2,'mail_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(27,3,'block_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(28,3,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(29,3,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(30,3,'content_comment_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(31,3,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(32,3,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(33,3,'content_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(34,3,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(35,3,'page_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(36,3,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(37,3,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(38,3,'mail_answer_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(39,3,'mail_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(40,4,'block_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(41,4,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(42,4,'content_comment_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(43,4,'content_comment_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(44,4,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(45,4,'content_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(46,4,'content_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(47,4,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(48,4,'page_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(49,4,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(50,4,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(51,4,'mail_answer_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(52,4,'mail_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(53,5,'block_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(54,5,'content_comment_creatable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(55,5,'content_comment_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(56,5,'content_comment_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(57,5,'content_creatable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(58,5,'content_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(59,5,'content_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(60,5,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(61,5,'page_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(62,5,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(63,5,'mail_content_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(64,5,'mail_answer_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(65,5,'mail_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(66,6,'block_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(67,6,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(68,6,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(69,6,'content_comment_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(70,6,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(71,6,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(72,6,'content_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(73,6,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(74,6,'page_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(75,6,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(76,6,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(77,6,'mail_answer_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(78,6,'mail_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(79,7,'block_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(80,7,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(81,7,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(82,7,'content_comment_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(83,7,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(84,7,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(85,7,'content_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(86,7,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(87,7,'page_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(88,7,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(89,7,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(90,7,'mail_answer_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(91,7,'mail_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(92,8,'block_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(93,8,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(94,8,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(95,8,'content_comment_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(96,8,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(97,8,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(98,8,'content_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(99,8,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(100,8,'page_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(101,8,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(102,8,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(103,8,'mail_answer_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(104,8,'mail_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(105,9,'block_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(106,9,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(107,9,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(108,9,'content_comment_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(109,9,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(110,9,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(111,9,'content_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(112,9,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(113,9,'page_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(114,9,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(115,9,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(116,9,'mail_answer_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(117,9,'mail_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(118,10,'block_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(119,10,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(120,10,'content_comment_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(121,10,'content_comment_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(122,10,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(123,10,'content_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(124,10,'content_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(125,10,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(126,10,'page_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(127,10,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(128,10,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(129,10,'mail_answer_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(130,10,'mail_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(131,11,'block_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(132,11,'content_comment_creatable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(133,11,'content_comment_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(134,11,'content_comment_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(135,11,'content_creatable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(136,11,'content_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(137,11,'content_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(138,11,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(139,11,'page_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(140,11,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(141,11,'mail_content_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(142,11,'mail_answer_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(143,11,'mail_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(144,13,'block_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(145,13,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(146,13,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(147,13,'content_comment_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(148,13,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(149,13,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(150,13,'content_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(151,13,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(152,13,'page_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(153,13,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(154,13,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(155,13,'mail_answer_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(156,13,'mail_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(159,14,'block_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(160,14,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(161,14,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(162,14,'content_comment_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(163,14,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(164,14,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(165,14,'content_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(166,14,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(167,14,'page_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(168,14,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(169,14,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(170,14,'mail_answer_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(171,14,'mail_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(174,15,'block_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(175,15,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(176,15,'content_comment_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(177,15,'content_comment_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(178,15,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(179,15,'content_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(180,15,'content_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(181,15,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(182,15,'page_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(183,15,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(184,15,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(185,15,'mail_answer_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(186,15,'mail_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(189,12,'block_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(190,12,'content_comment_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(191,12,'content_comment_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(192,12,'content_comment_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(193,12,'content_creatable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(194,12,'content_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(195,12,'content_publishable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(196,12,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(197,12,'page_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(198,12,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(199,12,'mail_content_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(200,12,'mail_answer_receivable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(201,12,'mail_editable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(204,16,'block_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(205,16,'content_comment_creatable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(206,16,'content_comment_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(207,16,'content_comment_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(208,16,'content_creatable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(209,16,'content_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(210,16,'content_publishable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(211,16,'content_readable',1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(212,16,'page_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(213,16,'html_not_limited',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(214,16,'mail_content_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(215,16,'mail_answer_receivable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(216,16,'mail_editable',0,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(219,21,'page_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(220,21,'block_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(221,21,'content_readable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(222,21,'content_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(223,21,'content_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(224,21,'content_publishable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(225,21,'content_comment_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(226,21,'content_comment_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(227,21,'content_comment_publishable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(228,21,'block_permission_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(229,21,'html_not_limited',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(230,21,'mail_content_receivable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(231,21,'mail_answer_receivable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(232,21,'mail_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(233,21,'photo_albums_photo_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(234,22,'page_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(235,22,'block_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(236,22,'content_readable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(237,22,'content_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(238,22,'content_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(239,22,'content_publishable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(240,22,'content_comment_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(241,22,'content_comment_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(242,22,'content_comment_publishable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(243,22,'block_permission_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(244,22,'html_not_limited',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(245,22,'mail_content_receivable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(246,22,'mail_answer_receivable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(247,22,'mail_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(248,22,'photo_albums_photo_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(249,23,'page_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(250,23,'block_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(251,23,'content_readable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(252,23,'content_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(253,23,'content_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(254,23,'content_publishable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(255,23,'content_comment_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(256,23,'content_comment_editable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(257,23,'content_comment_publishable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(258,23,'block_permission_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(259,23,'html_not_limited',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(260,23,'mail_content_receivable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(261,23,'mail_answer_receivable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(262,23,'mail_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(263,23,'photo_albums_photo_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(264,24,'page_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(265,24,'block_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(266,24,'content_readable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(267,24,'content_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(268,24,'content_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(269,24,'content_publishable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(270,24,'content_comment_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(271,24,'content_comment_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(272,24,'content_comment_publishable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(273,24,'block_permission_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(274,24,'html_not_limited',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(275,24,'mail_content_receivable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(276,24,'mail_answer_receivable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(277,24,'mail_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(278,24,'photo_albums_photo_creatable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(279,25,'page_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(280,25,'block_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(281,25,'content_readable',1,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(282,25,'content_creatable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(283,25,'content_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(284,25,'content_publishable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(285,25,'content_comment_creatable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(286,25,'content_comment_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(287,25,'content_comment_publishable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(288,25,'block_permission_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(289,25,'html_not_limited',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(290,25,'mail_content_receivable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(291,25,'mail_answer_receivable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(292,25,'mail_editable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(293,25,'photo_albums_photo_creatable',0,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(346,28,'page_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(347,28,'block_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(348,28,'content_readable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(349,28,'content_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(350,28,'content_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(351,28,'content_publishable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(352,28,'content_comment_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(353,28,'content_comment_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(354,28,'content_comment_publishable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(355,28,'block_permission_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(356,28,'html_not_limited',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(357,28,'mail_content_receivable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(358,28,'mail_answer_receivable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(359,28,'mail_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(360,28,'photo_albums_photo_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(361,29,'page_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(362,29,'block_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(363,29,'content_readable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(364,29,'content_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(365,29,'content_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(366,29,'content_publishable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(367,29,'content_comment_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(368,29,'content_comment_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(369,29,'content_comment_publishable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(370,29,'block_permission_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(371,29,'html_not_limited',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(372,29,'mail_content_receivable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(373,29,'mail_answer_receivable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(374,29,'mail_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(375,29,'photo_albums_photo_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(376,30,'page_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(377,30,'block_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(378,30,'content_readable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(379,30,'content_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(380,30,'content_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(381,30,'content_publishable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(382,30,'content_comment_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(383,30,'content_comment_editable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(384,30,'content_comment_publishable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(385,30,'block_permission_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(386,30,'html_not_limited',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(387,30,'mail_content_receivable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(388,30,'mail_answer_receivable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(389,30,'mail_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(390,30,'photo_albums_photo_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(391,31,'page_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(392,31,'block_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(393,31,'content_readable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(394,31,'content_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(395,31,'content_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(396,31,'content_publishable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(397,31,'content_comment_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(398,31,'content_comment_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(399,31,'content_comment_publishable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(400,31,'block_permission_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(401,31,'html_not_limited',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(402,31,'mail_content_receivable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(403,31,'mail_answer_receivable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(404,31,'mail_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(405,31,'photo_albums_photo_creatable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(406,32,'page_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(407,32,'block_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(408,32,'content_readable',1,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(409,32,'content_creatable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(410,32,'content_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(411,32,'content_publishable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(412,32,'content_comment_creatable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(413,32,'content_comment_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(414,32,'content_comment_publishable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(415,32,'block_permission_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(416,32,'html_not_limited',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(417,32,'mail_content_receivable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(418,32,'mail_answer_receivable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(419,32,'mail_editable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(420,32,'photo_albums_photo_creatable',0,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(473,35,'page_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(474,35,'block_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(475,35,'content_readable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(476,35,'content_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(477,35,'content_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(478,35,'content_publishable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(479,35,'content_comment_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(480,35,'content_comment_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(481,35,'content_comment_publishable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(482,35,'block_permission_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(483,35,'html_not_limited',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(484,35,'mail_content_receivable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(485,35,'mail_answer_receivable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(486,35,'mail_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(487,35,'photo_albums_photo_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(488,36,'page_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(489,36,'block_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(490,36,'content_readable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(491,36,'content_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(492,36,'content_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(493,36,'content_publishable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(494,36,'content_comment_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(495,36,'content_comment_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(496,36,'content_comment_publishable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(497,36,'block_permission_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(498,36,'html_not_limited',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(499,36,'mail_content_receivable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(500,36,'mail_answer_receivable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(501,36,'mail_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(502,36,'photo_albums_photo_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(503,37,'page_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(504,37,'block_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(505,37,'content_readable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(506,37,'content_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(507,37,'content_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(508,37,'content_publishable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(509,37,'content_comment_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(510,37,'content_comment_editable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(511,37,'content_comment_publishable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(512,37,'block_permission_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(513,37,'html_not_limited',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(514,37,'mail_content_receivable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(515,37,'mail_answer_receivable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(516,37,'mail_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(517,37,'photo_albums_photo_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(518,38,'page_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(519,38,'block_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(520,38,'content_readable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(521,38,'content_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(522,38,'content_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(523,38,'content_publishable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(524,38,'content_comment_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(525,38,'content_comment_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(526,38,'content_comment_publishable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(527,38,'block_permission_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(528,38,'html_not_limited',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(529,38,'mail_content_receivable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(530,38,'mail_answer_receivable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(531,38,'mail_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(532,38,'photo_albums_photo_creatable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(533,39,'page_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(534,39,'block_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(535,39,'content_readable',1,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(536,39,'content_creatable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(537,39,'content_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(538,39,'content_publishable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(539,39,'content_comment_creatable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(540,39,'content_comment_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(541,39,'content_comment_publishable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(542,39,'block_permission_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(543,39,'html_not_limited',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(544,39,'mail_content_receivable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(545,39,'mail_answer_receivable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(546,39,'mail_editable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(547,39,'photo_albums_photo_creatable',0,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(600,42,'page_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(601,42,'block_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(602,42,'content_readable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(603,42,'content_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(604,42,'content_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(605,42,'content_publishable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(606,42,'content_comment_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(607,42,'content_comment_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(608,42,'content_comment_publishable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(609,42,'block_permission_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(610,42,'html_not_limited',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(611,42,'mail_content_receivable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(612,42,'mail_answer_receivable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(613,42,'mail_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(614,42,'photo_albums_photo_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(615,43,'page_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(616,43,'block_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(617,43,'content_readable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(618,43,'content_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(619,43,'content_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(620,43,'content_publishable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(621,43,'content_comment_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(622,43,'content_comment_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(623,43,'content_comment_publishable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(624,43,'block_permission_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(625,43,'html_not_limited',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(626,43,'mail_content_receivable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(627,43,'mail_answer_receivable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(628,43,'mail_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(629,43,'photo_albums_photo_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(630,44,'page_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(631,44,'block_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(632,44,'content_readable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(633,44,'content_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(634,44,'content_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(635,44,'content_publishable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(636,44,'content_comment_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(637,44,'content_comment_editable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(638,44,'content_comment_publishable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(639,44,'block_permission_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(640,44,'html_not_limited',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(641,44,'mail_content_receivable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(642,44,'mail_answer_receivable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(643,44,'mail_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(644,44,'photo_albums_photo_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(645,45,'page_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(646,45,'block_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(647,45,'content_readable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(648,45,'content_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(649,45,'content_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(650,45,'content_publishable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(651,45,'content_comment_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(652,45,'content_comment_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(653,45,'content_comment_publishable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(654,45,'block_permission_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(655,45,'html_not_limited',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(656,45,'mail_content_receivable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(657,45,'mail_answer_receivable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(658,45,'mail_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(659,45,'photo_albums_photo_creatable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(660,46,'page_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(661,46,'block_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(662,46,'content_readable',1,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(663,46,'content_creatable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(664,46,'content_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(665,46,'content_publishable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(666,46,'content_comment_creatable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(667,46,'content_comment_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(668,46,'content_comment_publishable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(669,46,'block_permission_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(670,46,'html_not_limited',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(671,46,'mail_content_receivable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(672,46,'mail_answer_receivable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(673,46,'mail_editable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(674,46,'photo_albums_photo_creatable',0,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(727,49,'page_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(728,49,'block_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(729,49,'content_readable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(730,49,'content_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(731,49,'content_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(732,49,'content_publishable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(733,49,'content_comment_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(734,49,'content_comment_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(735,49,'content_comment_publishable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(736,49,'block_permission_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(737,49,'html_not_limited',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(738,49,'mail_content_receivable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(739,49,'mail_answer_receivable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(740,49,'mail_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(741,49,'photo_albums_photo_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(742,50,'page_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(743,50,'block_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(744,50,'content_readable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(745,50,'content_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(746,50,'content_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(747,50,'content_publishable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(748,50,'content_comment_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(749,50,'content_comment_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(750,50,'content_comment_publishable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(751,50,'block_permission_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(752,50,'html_not_limited',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(753,50,'mail_content_receivable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(754,50,'mail_answer_receivable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(755,50,'mail_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(756,50,'photo_albums_photo_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(757,51,'page_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(758,51,'block_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(759,51,'content_readable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(760,51,'content_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(761,51,'content_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(762,51,'content_publishable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(763,51,'content_comment_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(764,51,'content_comment_editable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(765,51,'content_comment_publishable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(766,51,'block_permission_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(767,51,'html_not_limited',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(768,51,'mail_content_receivable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(769,51,'mail_answer_receivable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(770,51,'mail_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(771,51,'photo_albums_photo_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(772,52,'page_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(773,52,'block_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(774,52,'content_readable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(775,52,'content_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(776,52,'content_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(777,52,'content_publishable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(778,52,'content_comment_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(779,52,'content_comment_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(780,52,'content_comment_publishable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(781,52,'block_permission_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(782,52,'html_not_limited',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(783,52,'mail_content_receivable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(784,52,'mail_answer_receivable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(785,52,'mail_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(786,52,'photo_albums_photo_creatable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(787,53,'page_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(788,53,'block_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(789,53,'content_readable',1,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(790,53,'content_creatable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(791,53,'content_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(792,53,'content_publishable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(793,53,'content_comment_creatable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(794,53,'content_comment_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(795,53,'content_comment_publishable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(796,53,'block_permission_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(797,53,'html_not_limited',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(798,53,'mail_content_receivable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(799,53,'mail_answer_receivable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(800,53,'mail_editable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(801,53,'photo_albums_photo_creatable',0,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(854,56,'page_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(855,56,'block_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(856,56,'content_readable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(857,56,'content_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(858,56,'content_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(859,56,'content_publishable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(860,56,'content_comment_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(861,56,'content_comment_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(862,56,'content_comment_publishable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(863,56,'block_permission_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(864,56,'html_not_limited',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(865,56,'mail_content_receivable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(866,56,'mail_answer_receivable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(867,56,'mail_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(868,56,'photo_albums_photo_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(869,57,'page_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(870,57,'block_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(871,57,'content_readable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(872,57,'content_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(873,57,'content_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(874,57,'content_publishable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(875,57,'content_comment_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(876,57,'content_comment_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(877,57,'content_comment_publishable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(878,57,'block_permission_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(879,57,'html_not_limited',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(880,57,'mail_content_receivable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(881,57,'mail_answer_receivable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(882,57,'mail_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(883,57,'photo_albums_photo_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(884,58,'page_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(885,58,'block_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(886,58,'content_readable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(887,58,'content_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(888,58,'content_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(889,58,'content_publishable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(890,58,'content_comment_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(891,58,'content_comment_editable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(892,58,'content_comment_publishable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(893,58,'block_permission_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(894,58,'html_not_limited',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(895,58,'mail_content_receivable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(896,58,'mail_answer_receivable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(897,58,'mail_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(898,58,'photo_albums_photo_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(899,59,'page_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(900,59,'block_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(901,59,'content_readable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(902,59,'content_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(903,59,'content_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(904,59,'content_publishable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(905,59,'content_comment_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(906,59,'content_comment_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(907,59,'content_comment_publishable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(908,59,'block_permission_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(909,59,'html_not_limited',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(910,59,'mail_content_receivable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(911,59,'mail_answer_receivable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(912,59,'mail_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(913,59,'photo_albums_photo_creatable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(914,60,'page_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(915,60,'block_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(916,60,'content_readable',1,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(917,60,'content_creatable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(918,60,'content_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(919,60,'content_publishable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(920,60,'content_comment_creatable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(921,60,'content_comment_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(922,60,'content_comment_publishable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(923,60,'block_permission_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(924,60,'html_not_limited',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(925,60,'mail_content_receivable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(926,60,'mail_answer_receivable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(927,60,'mail_editable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(928,60,'photo_albums_photo_creatable',0,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(981,63,'page_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(982,63,'block_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(983,63,'content_readable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(984,63,'content_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(985,63,'content_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(986,63,'content_publishable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:55'),(987,63,'content_comment_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(988,63,'content_comment_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(989,63,'content_comment_publishable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(990,63,'block_permission_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(991,63,'html_not_limited',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:55'),(992,63,'mail_content_receivable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(993,63,'mail_answer_receivable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(994,63,'mail_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(995,63,'photo_albums_photo_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(996,64,'page_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(997,64,'block_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(998,64,'content_readable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(999,64,'content_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1000,64,'content_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1001,64,'content_publishable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:55'),(1002,64,'content_comment_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1003,64,'content_comment_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1004,64,'content_comment_publishable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1005,64,'block_permission_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1006,64,'html_not_limited',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:55'),(1007,64,'mail_content_receivable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1008,64,'mail_answer_receivable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1009,64,'mail_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1010,64,'photo_albums_photo_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1011,65,'page_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1012,65,'block_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1013,65,'content_readable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1014,65,'content_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1015,65,'content_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1016,65,'content_publishable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:55'),(1017,65,'content_comment_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1018,65,'content_comment_editable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1019,65,'content_comment_publishable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1020,65,'block_permission_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1021,65,'html_not_limited',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:55'),(1022,65,'mail_content_receivable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1023,65,'mail_answer_receivable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1024,65,'mail_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1025,65,'photo_albums_photo_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1026,66,'page_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1027,66,'block_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1028,66,'content_readable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1029,66,'content_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1030,66,'content_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1031,66,'content_publishable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1032,66,'content_comment_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1033,66,'content_comment_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1034,66,'content_comment_publishable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1035,66,'block_permission_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1036,66,'html_not_limited',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1037,66,'mail_content_receivable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1038,66,'mail_answer_receivable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1039,66,'mail_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1040,66,'photo_albums_photo_creatable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1041,67,'page_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1042,67,'block_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1043,67,'content_readable',1,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1044,67,'content_creatable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1045,67,'content_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1046,67,'content_publishable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1047,67,'content_comment_creatable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1048,67,'content_comment_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1049,67,'content_comment_publishable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1050,67,'block_permission_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1051,67,'html_not_limited',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1052,67,'mail_content_receivable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1053,67,'mail_answer_receivable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1054,67,'mail_editable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1055,67,'photo_albums_photo_creatable',0,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:28'),(1108,70,'page_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1109,70,'block_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1110,70,'content_readable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1111,70,'content_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1112,70,'content_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1113,70,'content_publishable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1114,70,'content_comment_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1115,70,'content_comment_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1116,70,'content_comment_publishable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1117,70,'block_permission_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1118,70,'html_not_limited',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1119,70,'mail_content_receivable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1120,70,'mail_answer_receivable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1121,70,'mail_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1122,70,'photo_albums_photo_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1123,71,'page_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1124,71,'block_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1125,71,'content_readable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1126,71,'content_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1127,71,'content_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1128,71,'content_publishable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1129,71,'content_comment_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1130,71,'content_comment_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1131,71,'content_comment_publishable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1132,71,'block_permission_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1133,71,'html_not_limited',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1134,71,'mail_content_receivable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1135,71,'mail_answer_receivable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1136,71,'mail_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1137,71,'photo_albums_photo_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1138,72,'page_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1139,72,'block_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1140,72,'content_readable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1141,72,'content_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1142,72,'content_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1143,72,'content_publishable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1144,72,'content_comment_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1145,72,'content_comment_editable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1146,72,'content_comment_publishable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1147,72,'block_permission_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1148,72,'html_not_limited',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1149,72,'mail_content_receivable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1150,72,'mail_answer_receivable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1151,72,'mail_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1152,72,'photo_albums_photo_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1153,73,'page_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1154,73,'block_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1155,73,'content_readable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1156,73,'content_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1157,73,'content_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1158,73,'content_publishable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1159,73,'content_comment_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1160,73,'content_comment_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1161,73,'content_comment_publishable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1162,73,'block_permission_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1163,73,'html_not_limited',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1164,73,'mail_content_receivable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1165,73,'mail_answer_receivable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1166,73,'mail_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1167,73,'photo_albums_photo_creatable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1168,74,'page_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1169,74,'block_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1170,74,'content_readable',1,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1171,74,'content_creatable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1172,74,'content_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1173,74,'content_publishable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1174,74,'content_comment_creatable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1175,74,'content_comment_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1176,74,'content_comment_publishable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1177,74,'block_permission_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1178,74,'html_not_limited',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1179,74,'mail_content_receivable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1180,74,'mail_answer_receivable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1181,74,'mail_editable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18'),(1182,74,'photo_albums_photo_creatable',0,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `room_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_roles`
--

DROP TABLE IF EXISTS `room_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_key` varchar(255) NOT NULL,
  `level` int(11) DEFAULT NULL COMMENT '下位レベルに与えた権限を上位に与える時に使用。大きいほうが上位。',
  `weight` int(11) DEFAULT NULL COMMENT '表示順序',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_key` (`role_key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_roles`
--

LOCK TABLES `room_roles` WRITE;
/*!40000 ALTER TABLE `room_roles` DISABLE KEYS */;
INSERT INTO `room_roles` VALUES (1,'room_administrator',2147483647,1,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(2,'chief_editor',8000,2,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(3,'editor',7000,3,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(4,'general_user',6000,4,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(5,'visitor',1000,5,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12');
/*!40000 ALTER TABLE `room_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `space_id` int(11) DEFAULT NULL,
  `page_id_top` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `sort_key` varchar(255) DEFAULT NULL,
  `child_count` int(11) DEFAULT '0',
  `active` tinyint(1) DEFAULT NULL,
  `in_draft` tinyint(1) NOT NULL DEFAULT '0' COMMENT '作成中かどうか。1: 作成中、0: 確定',
  `default_role_key` varchar(255) NOT NULL COMMENT '「ルーム内の役割」のデフォルト値',
  `need_approval` tinyint(1) DEFAULT NULL,
  `default_participation` tinyint(1) DEFAULT NULL,
  `page_layout_permitted` tinyint(1) DEFAULT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id_2` (`parent_id`,`sort_key`,`id`),
  KEY `sort_key` (`sort_key`,`id`),
  KEY `weight` (`parent_id`,`weight`),
  KEY `space_id_2` (`space_id`,`page_id_top`,`sort_key`),
  KEY `default_participation` (`default_participation`,`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,2,4,4,1,2,1,'~00000001-00000001',1,1,0,'visitor',1,1,1,'Default',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(2,3,NULL,4,3,4,2,'~00000001-00000002',5,1,0,'room_administrator',0,0,0,'Default',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(3,4,NULL,4,5,6,3,'~00000001-00000003',2,1,0,'general_user',1,1,1,'Default',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(4,1,NULL,NULL,NULL,NULL,1,'~00000001',11,1,0,'visitor',1,1,0,NULL,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(5,3,5,2,NULL,NULL,1,'~00000001-00000002-00000001',0,1,0,'room_administrator',0,0,0,NULL,NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(6,3,6,2,NULL,NULL,2,'~00000001-00000002-00000002',0,1,0,'room_administrator',0,0,0,NULL,1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(7,3,7,2,NULL,NULL,3,'~00000001-00000002-00000003',0,1,0,'room_administrator',0,0,0,NULL,1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(8,4,8,3,NULL,NULL,1,'~00000001-00000003-00000001',0,1,0,'general_user',0,0,NULL,NULL,1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(9,2,9,1,NULL,NULL,1,'~00000001-00000001-00000001',0,1,0,'visitor',1,1,NULL,NULL,1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(10,3,13,2,NULL,NULL,4,'~00000001-00000002-00000004',0,1,0,'room_administrator',0,0,0,NULL,1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(11,4,14,3,NULL,NULL,2,'~00000001-00000003-00000002',0,0,0,'general_user',0,0,NULL,NULL,1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:37'),(12,3,15,2,NULL,NULL,5,'~00000001-00000002-00000005',0,1,0,'room_administrator',0,0,0,NULL,1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms_languages`
--

DROP TABLE IF EXISTS `rooms_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `room_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`,`id`),
  KEY `room_id` (`room_id`,`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms_languages`
--

LOCK TABLES `rooms_languages` WRITE;
/*!40000 ALTER TABLE `rooms_languages` DISABLE KEYS */;
INSERT INTO `rooms_languages` VALUES (1,2,1,0,0,1,'パブリック',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(2,1,0,0,0,1,'Public',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(3,2,1,0,0,2,'プライベート',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(4,1,0,0,0,2,'Private',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(5,2,1,0,0,3,'コミュニティ',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(6,1,0,0,0,3,'Community',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(7,2,1,0,0,4,'サイト全体',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(8,1,0,0,0,4,'Whole site',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(9,2,1,0,0,5,'プライベート',NULL,'2019-03-02 03:15:10',NULL,'2019-03-02 03:15:10'),(10,2,1,0,0,6,'プライベート',1,'2019-03-02 03:18:08',1,'2019-03-02 03:18:08'),(11,2,1,0,0,7,'プライベート',1,'2019-03-02 03:19:02',1,'2019-03-02 03:19:02'),(12,2,1,0,0,8,'Community room 1',1,'2019-03-02 03:19:40',1,'2019-03-02 03:19:40'),(13,2,1,0,0,9,'Public room 1',1,'2019-03-02 03:20:38',1,'2019-03-02 03:20:38'),(14,2,1,0,0,10,'プライベート',1,'2019-03-02 03:41:35',1,'2019-03-02 03:41:35'),(15,2,1,0,0,11,'Community room 2',1,'2019-03-02 03:42:28',1,'2019-03-02 03:42:37'),(16,2,1,0,0,12,'プライベート',1,'2019-03-02 09:39:18',1,'2019-03-02 09:39:18');
/*!40000 ALTER TABLE `rooms_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rss_reader_frame_settings`
--

DROP TABLE IF EXISTS `rss_reader_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rss_reader_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'RSSリーダーID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `display_number_per_page` int(4) NOT NULL DEFAULT '10' COMMENT '表示件数',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rss_reader_frame_settings`
--

LOCK TABLES `rss_reader_frame_settings` WRITE;
/*!40000 ALTER TABLE `rss_reader_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `rss_reader_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rss_reader_items`
--

DROP TABLE IF EXISTS `rss_reader_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rss_reader_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `rss_reader_id` int(11) NOT NULL DEFAULT '0' COMMENT 'RSSリーダーID',
  `title` varchar(255) DEFAULT NULL COMMENT 'タイトル',
  `summary` text COMMENT '概要',
  `link` varchar(255) DEFAULT NULL COMMENT 'リンク',
  `last_updated` datetime DEFAULT NULL COMMENT '最新更新日時',
  `serialize_value` text COMMENT 'XMLのシリアライズデータ',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `rss_reader_id` (`rss_reader_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rss_reader_items`
--

LOCK TABLES `rss_reader_items` WRITE;
/*!40000 ALTER TABLE `rss_reader_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `rss_reader_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rss_readers`
--

DROP TABLE IF EXISTS `rss_readers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rss_readers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `language_id` int(6) NOT NULL DEFAULT '0' COMMENT '言語ID',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `block_id` int(11) NOT NULL COMMENT 'ブロックID',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) DEFAULT '0' COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_latest` tinyint(1) DEFAULT '0' COMMENT 'アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ',
  `key` varchar(255) DEFAULT NULL COMMENT 'RSSリーダーKey',
  `url` varchar(255) DEFAULT NULL COMMENT 'RSS URL',
  `title` varchar(255) DEFAULT NULL COMMENT 'サイト名',
  `summary` text COMMENT 'サイト説明',
  `link` varchar(255) DEFAULT NULL COMMENT 'サイトURL',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rss_readers`
--

LOCK TABLES `rss_readers` WRITE;
/*!40000 ALTER TABLE `rss_readers` DISABLE KEYS */;
/*!40000 ALTER TABLE `rss_readers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schema_migrations`
--

DROP TABLE IF EXISTS `schema_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schema_migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=433 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schema_migrations`
--

LOCK TABLES `schema_migrations` WRITE;
/*!40000 ALTER TABLE `schema_migrations` DISABLE KEYS */;
INSERT INTO `schema_migrations` VALUES (1,'InitMigrations','Migrations','2019-03-02 03:14:02'),(2,'ConvertVersionToClassNames','Migrations','2019-03-02 03:14:02'),(3,'IncreaseClassNameLength','Migrations','2019-03-02 03:14:02'),(4,'Init','Files','2019-03-02 03:14:02'),(5,'AddIndex','Files','2019-03-02 03:14:02'),(6,'AddContentIsActiveAndLatest','Files','2019-03-02 03:14:02'),(7,'MoveUploadFiles','Files','2019-03-02 03:14:02'),(8,'AddInde2','Files','2019-03-02 03:14:02'),(9,'ModifiedIndex2','Files','2019-03-02 03:14:02'),(10,'Init','Users','2019-03-02 03:14:02'),(11,'AddLanguage','Users','2019-03-02 03:14:02'),(12,'AddIndex','Users','2019-03-02 03:14:02'),(13,'AddBinaryAttributeOnUsername','Users','2019-03-02 03:14:02'),(14,'ForSpeedUp','Users','2019-03-02 03:14:02'),(15,'ForSpeedup2','Users','2019-03-02 03:14:02'),(16,'Init','M17n','2019-03-02 03:14:03'),(17,'AddIndex','M17n','2019-03-02 03:14:03'),(18,'Records','M17n','2019-03-02 03:14:03'),(19,'UpdateEnable','M17n','2019-03-02 03:14:03'),(20,'ForSpeedup','M17n','2019-03-02 03:14:03'),(21,'Init','DataTypes','2019-03-02 03:14:03'),(22,'AddIndex','DataTypes','2019-03-02 03:14:03'),(23,'Records','DataTypes','2019-03-02 03:14:03'),(24,'DataTypesRecords','DataTypes','2019-03-02 03:14:03'),(25,'AddLanguageRecords','DataTypes','2019-03-02 03:14:03'),(26,'DeleteLanguageRecords','DataTypes','2019-03-02 03:14:04'),(27,'AddFieldsForM17n','DataTypes','2019-03-02 03:14:04'),(28,'AddTableForM17n1','DataTypes','2019-03-02 03:14:04'),(29,'AddIsOriginalCopy','DataTypes','2019-03-02 03:14:04'),(30,'Init','PluginManager','2019-03-02 03:14:04'),(31,'AddIndex','PluginManager','2019-03-02 03:14:04'),(32,'PluginRecords','PluginManager','2019-03-02 03:14:04'),(33,'AddVersionFields','PluginManager','2019-03-02 03:14:04'),(34,'AddVersionData','PluginManager','2019-03-02 03:14:04'),(35,'AddIndexPluginsRooms','PluginManager','2019-03-02 03:14:04'),(36,'AddFieldsForM17n','PluginManager','2019-03-02 03:14:05'),(37,'AddTableForM17n1','PluginManager','2019-03-02 03:14:05'),(38,'AddIsM17n','PluginManager','2019-03-02 03:14:05'),(39,'AddIsM17n1','PluginManager','2019-03-02 03:14:05'),(40,'AddIsOriginalCopy','PluginManager','2019-03-02 03:14:05'),(41,'ForSpeedUp','PluginManager','2019-03-02 03:14:05'),(42,'ForSpeedUp2','PluginManager','2019-03-02 03:14:05'),(43,'Init','Roles','2019-03-02 03:14:05'),(44,'AddIndex','Roles','2019-03-02 03:14:05'),(45,'Records','Roles','2019-03-02 03:14:05'),(46,'RolesRecords','Roles','2019-03-02 03:14:06'),(47,'AddRoomRoleDesc','Roles','2019-03-02 03:14:06'),(48,'RenameVisitor','Roles','2019-03-02 03:14:06'),(49,'AddFieldsForM17n','Roles','2019-03-02 03:14:06'),(50,'AddTableForM17n1','Roles','2019-03-02 03:14:06'),(51,'AddIsOriginalCopy','Roles','2019-03-02 03:14:06'),(52,'ForSpeedUp','Roles','2019-03-02 03:14:06'),(53,'Mails','Mails','2019-03-02 03:14:06'),(54,'AddIndex','Mails','2019-03-02 03:14:06'),(55,'AddFieldsForM17n','Mails','2019-03-02 03:14:06'),(56,'AddTableForM17n1','Mails','2019-03-02 03:14:06'),(57,'AddIsOriginalCopy','Mails','2019-03-02 03:14:07'),(58,'PluginRecords','SiteManager','2019-03-02 03:14:07'),(59,'Init','SiteManager','2019-03-02 03:14:07'),(60,'AddIndex','SiteManager','2019-03-02 03:14:07'),(61,'SiteManagerRecords','SiteManager','2019-03-02 03:14:07'),(62,'SystemManagerRecords','SiteManager','2019-03-02 03:14:07'),(63,'MetaOfM17n','SiteManager','2019-03-02 03:14:07'),(64,'MailSmtpTls','SiteManager','2019-03-02 03:14:07'),(65,'ContactAfterApprovalMail','SiteManager','2019-03-02 03:14:07'),(66,'RenameSessionCookie','SiteManager','2019-03-02 03:14:07'),(67,'RenameSessionMaxTime','SiteManager','2019-03-02 03:14:07'),(68,'AddFieldsForM17n','SiteManager','2019-03-02 03:14:07'),(69,'AddTableForM17n1','SiteManager','2019-03-02 03:14:07'),(70,'AddIsOriginalCopy','SiteManager','2019-03-02 03:14:07'),(71,'UpdateUserCancelDisclaimer','SiteManager','2019-03-02 03:14:07'),(72,'Init','Blocks','2019-03-02 03:14:08'),(73,'AddContentCount','Blocks','2019-03-02 03:14:08'),(74,'AddBlockSettings','Blocks','2019-03-02 03:14:08'),(75,'AddIndex','Blocks','2019-03-02 03:14:08'),(76,'Records','Blocks','2019-03-02 03:14:08'),(77,'AddBlocksLanguages','Blocks','2019-03-02 03:14:08'),(78,'MigrationBlocksLanguages','Blocks','2019-03-02 03:14:08'),(79,'RemoveNameOfBlocks','Blocks','2019-03-02 03:14:08'),(80,'AddIsOriginalCopy','Blocks','2019-03-02 03:14:08'),(81,'ReconsiderIndexes','Blocks','2019-03-02 03:14:08'),(82,'Init','Boxes','2019-03-02 03:14:08'),(83,'AddIndex','Boxes','2019-03-02 03:14:08'),(84,'BoxRecords','Boxes','2019-03-02 03:14:09'),(85,'Init','Pages','2019-03-02 03:14:09'),(86,'AddMeta','Pages','2019-03-02 03:14:09'),(87,'AddIndex','Pages','2019-03-02 03:14:09'),(88,'Records','Pages','2019-03-02 03:14:09'),(89,'AddIndexPages','Pages','2019-03-02 03:14:09'),(90,'RenamePagesLanguages','Pages','2019-03-02 03:14:09'),(91,'SwitchBoxes','Pages','2019-03-02 03:14:09'),(92,'AddFieldsForM17n','Pages','2019-03-02 03:14:09'),(93,'AddTableForM17n1','Pages','2019-03-02 03:14:09'),(94,'AddIsOriginalCopy1','Pages','2019-03-02 03:14:09'),(95,'ReconsiderIndexes','Pages','2019-03-02 03:14:09'),(96,'TreeRecover1','Pages','2019-03-02 03:14:09'),(97,'ForNetcommonsTreeBehavior','Pages','2019-03-02 03:14:10'),(98,'ForNetcommonsTreeBehavior2','Pages','2019-03-02 03:14:10'),(99,'ForNetcommonsTreeBehavior3','Pages','2019-03-02 03:14:10'),(100,'Init','Containers','2019-03-02 03:14:10'),(101,'ContainerRecords','Containers','2019-03-02 03:14:10'),(102,'Init','Frames','2019-03-02 03:14:10'),(103,'AddIndex','Frames','2019-03-02 03:14:11'),(104,'Records','Frames','2019-03-02 03:14:11'),(105,'AddFramesLanguages','Frames','2019-03-02 03:14:11'),(106,'MigrationFramesLanguages','Frames','2019-03-02 03:14:11'),(107,'RemoveNameOfFrames','Frames','2019-03-02 03:14:11'),(108,'AddFramePublic','Frames','2019-03-02 03:14:11'),(109,'AddFramePublic1','Frames','2019-03-02 03:14:11'),(110,'AddIsOriginalCopy','Frames','2019-03-02 03:14:11'),(111,'ReconsiderIndexes','Frames','2019-03-02 03:14:11'),(112,'AddDefaultSettingAction','Frames','2019-03-02 03:14:11'),(113,'PluginRecords','Rooms','2019-03-02 03:14:11'),(114,'Init','Rooms','2019-03-02 03:14:11'),(115,'Records','Rooms','2019-03-02 03:14:12'),(116,'RoomsRecords','Rooms','2019-03-02 03:14:12'),(117,'AddIndex','Rooms','2019-03-02 03:14:12'),(118,'AddIndexRoomsAndRolesRooms','Rooms','2019-03-02 03:14:12'),(119,'AddIndexRootIdAndParticipation','Rooms','2019-03-02 03:14:12'),(120,'AddIndexParentId','Rooms','2019-03-02 03:14:12'),(121,'AddRoomIdRoot','Rooms','2019-03-02 03:14:12'),(122,'SwitchBoxes','Rooms','2019-03-02 03:14:12'),(123,'AddFieldsForM17n','Rooms','2019-03-02 03:14:12'),(124,'AddTableForM17n1','Rooms','2019-03-02 03:14:13'),(125,'AddPermalink','Rooms','2019-03-02 03:14:13'),(126,'AddPermalink1','Rooms','2019-03-02 03:14:13'),(127,'AddIsM17n','Rooms','2019-03-02 03:14:13'),(128,'AddIsM17n1','Rooms','2019-03-02 03:14:13'),(129,'AddIsOriginalCopy','Rooms','2019-03-02 03:14:13'),(130,'AddIsOriginalCopy1','Rooms','2019-03-02 03:14:13'),(131,'AddAfterUserSaveModel','Rooms','2019-03-02 03:14:13'),(132,'AddAfterUserSaveModel2','Rooms','2019-03-02 03:14:13'),(133,'DeleteRootIdInRoomsTable','Rooms','2019-03-02 03:14:13'),(134,'RecoverRolesRoomsUsersForSpaceRooms','Rooms','2019-03-02 03:14:13'),(135,'AddPageIdTopForSpaces','Rooms','2019-03-02 03:14:13'),(136,'AddPageIdTopForSpaces1','Rooms','2019-03-02 03:14:13'),(137,'UpdatePrivateSpaceDefaultSettingAction','Rooms','2019-03-02 03:14:13'),(138,'RemoveUserNotInParentRoom','Rooms','2019-03-02 03:14:13'),(139,'AddIndex2','Rooms','2019-03-02 03:14:13'),(140,'ForSpeedUp','Rooms','2019-03-02 03:14:13'),(141,'ForSpeedUp2','Rooms','2019-03-02 03:14:13'),(142,'ForNetcommonsTreeBehavior','Rooms','2019-03-02 03:14:13'),(143,'ForNetcommonsTreeBehavior2','Rooms','2019-03-02 03:14:14'),(144,'ForNetcommonsTreeBehavior3','Rooms','2019-03-02 03:14:14'),(145,'FixSubroomDefaultParticipation','Rooms','2019-03-02 03:14:14'),(146,'FixSubroomDefaultParticipation2','Rooms','2019-03-02 03:14:14'),(147,'SwitchBoxesModifiedTables','Boxes','2019-03-02 03:14:14'),(148,'SwitchBoxes','Boxes','2019-03-02 03:14:14'),(149,'RecoverBoxesPageContainers','Boxes','2019-03-02 03:14:14'),(150,'AddIndex2','Boxes','2019-03-02 03:14:14'),(151,'ForSpeedUp','Boxes','2019-03-02 03:14:14'),(152,'PluginRecords','AccessCounters','2019-03-02 03:14:15'),(153,'Init','AccessCounters','2019-03-02 03:14:15'),(154,'AddIndex','AccessCounters','2019-03-02 03:14:15'),(155,'PluginRecords','Announcements','2019-03-02 03:14:15'),(156,'AnnouncementMailSettingRecords','Announcements','2019-03-02 03:14:15'),(157,'Init','Announcements','2019-03-02 03:14:15'),(158,'AddAnnouncementsSettings','Announcements','2019-03-02 03:14:15'),(159,'AddIndex','Announcements','2019-03-02 03:14:15'),(160,'DeleteAnnouncementSettings','Announcements','2019-03-02 03:14:15'),(161,'AddFieldsForM17n','Announcements','2019-03-02 03:14:15'),(162,'AddIsOriginalCopy','Announcements','2019-03-02 03:14:15'),(163,'AuthMailSettingRecords','Auth','2019-03-02 03:14:16'),(164,'ExternalIdpUsers','Auth','2019-03-02 03:14:16'),(165,'Init','AuthorizationKeys','2019-03-02 03:14:16'),(166,'AddedAdditionalId','AuthorizationKeys','2019-03-02 03:14:16'),(167,'AddIndex','AuthorizationKeys','2019-03-02 03:14:16'),(168,'PluginRecords','Bbses','2019-03-02 03:14:16'),(169,'BbsMailSettingRecords','Bbses','2019-03-02 03:14:16'),(170,'BlockSettingRecords','Bbses','2019-03-02 03:14:16'),(171,'Init','Bbses','2019-03-02 03:14:17'),(172,'AddIndex','Bbses','2019-03-02 03:14:17'),(173,'DeleteBbsSettings','Bbses','2019-03-02 03:14:17'),(174,'BlockContentCount','Bbses','2019-03-02 03:14:17'),(175,'AddFieldsForM17n','Bbses','2019-03-02 03:14:17'),(176,'ModifiedFromBbsIdToBbsKey','Bbses','2019-03-02 03:14:17'),(177,'ModifiedFromBbsIdToBbsKey1','Bbses','2019-03-02 03:14:17'),(178,'ModifiedFromBbsIdToBbsKey2','Bbses','2019-03-02 03:14:17'),(179,'AddIsOriginalCopy','Bbses','2019-03-02 03:14:17'),(180,'ReconsiderIndexes','Bbses','2019-03-02 03:14:17'),(181,'AddRootIndex','Bbses','2019-03-02 03:14:17'),(182,'ListOfAllArticles','Bbses','2019-03-02 03:14:17'),(183,'ForSpeedUp','Bbses','2019-03-02 03:14:17'),(184,'BlogMailSettingRecords','Blogs','2019-03-02 03:14:17'),(185,'BlockSettingRecords','Blogs','2019-03-02 03:14:17'),(186,'Init','Blogs','2019-03-02 03:14:17'),(187,'AddRecord','Blogs','2019-03-02 03:14:18'),(188,'AddIndex','Blogs','2019-03-02 03:14:18'),(189,'DeleteBlogSettings','Blogs','2019-03-02 03:14:18'),(190,'CategoryIdAllowNull','Blogs','2019-03-02 03:14:18'),(191,'AddFieldsForM17n','Blogs','2019-03-02 03:14:18'),(192,'AddIsOriginalCopy','Blogs','2019-03-02 03:14:18'),(193,'Init','Cabinets','2019-03-02 03:14:18'),(194,'AddRecord','Cabinets','2019-03-02 03:14:18'),(195,'AlterCabinetsTotalSize','Cabinets','2019-03-02 03:14:18'),(196,'AddIndex','Cabinets','2019-03-02 03:14:18'),(197,'DeleteCabinetSettings','Cabinets','2019-03-02 03:14:18'),(198,'AddUseAuthKey','Cabinets','2019-03-02 03:14:18'),(199,'AddFieldsForM17n','Cabinets','2019-03-02 03:14:19'),(200,'AddTableForM17n1','Cabinets','2019-03-02 03:14:19'),(201,'AddTableForM17n2','Cabinets','2019-03-02 03:14:19'),(202,'AddIsOriginalCopy','Cabinets','2019-03-02 03:14:19'),(203,'PluginRecords','Calendars','2019-03-02 03:14:19'),(204,'CalendarMailSettingRecords','Calendars','2019-03-02 03:14:19'),(205,'Init','Calendars','2019-03-02 03:14:19'),(206,'StatusAndOthersMoveRruleToEvent','Calendars','2019-03-02 03:14:19'),(207,'AddEmailSendTiming','Calendars','2019-03-02 03:14:20'),(208,'DeleteColumnsUseWorkflow','Calendars','2019-03-02 03:14:20'),(209,'ChangeIcalendarUid','Calendars','2019-03-02 03:14:20'),(210,'AddFieldsForM17n','Calendars','2019-03-02 03:14:20'),(211,'AddIsOriginalCopy','Calendars','2019-03-02 03:14:20'),(212,'CalendarBlockMaintenance','Calendars','2019-03-02 03:14:20'),(213,'AddIndex','Calendars','2019-03-02 03:14:20'),(214,'DropRoomIdFromCalendarFrameSettings','Calendars','2019-03-02 03:14:20'),(215,'Init','Categories','2019-03-02 03:14:20'),(216,'AddIndex','Categories','2019-03-02 03:14:20'),(217,'AddTableForM17n','Categories','2019-03-02 03:14:20'),(218,'AddTableForM17n1','Categories','2019-03-02 03:14:20'),(219,'AddTableForM17n2','Categories','2019-03-02 03:14:20'),(220,'AddIsOriginalCopy','Categories','2019-03-02 03:14:20'),(221,'PluginRecords','CircularNotices','2019-03-02 03:14:21'),(222,'MailSettingRecords','CircularNotices','2019-03-02 03:14:21'),(223,'Initialize','CircularNotices','2019-03-02 03:14:21'),(224,'DeleteUnnecessaryColumns','CircularNotices','2019-03-02 03:14:21'),(225,'ChangePublish','CircularNotices','2019-03-02 03:14:22'),(226,'AddFieldsForM17n','CircularNotices','2019-03-02 03:14:22'),(227,'AddIsOriginalCopy','CircularNotices','2019-03-02 03:14:22'),(228,'ForSpeedUp','CircularNotices','2019-03-02 03:14:22'),(229,'ContentComments','ContentComments','2019-03-02 03:14:22'),(230,'ModifyIndex','ContentComments','2019-03-02 03:14:22'),(231,'PluginRecords','Faqs','2019-03-02 03:14:23'),(232,'FaqMailSettingRecords','Faqs','2019-03-02 03:14:23'),(233,'FaqBlockSettingRecords','Faqs','2019-03-02 03:14:23'),(234,'Init','Faqs','2019-03-02 03:14:23'),(235,'AddBlockIdInFaqQuestions','Faqs','2019-03-02 03:14:23'),(236,'AddFaqFrameSetting','Faqs','2019-03-02 03:14:23'),(237,'AddLikeAndUnlike','Faqs','2019-03-02 03:14:23'),(238,'DeleteFaqSettings','Faqs','2019-03-02 03:14:23'),(239,'AddIndex','Faqs','2019-03-02 03:14:23'),(240,'AddFieldsForM17n','Faqs','2019-03-02 03:14:23'),(241,'AddFieldsForM17n1','Faqs','2019-03-02 03:14:23'),(242,'AddFieldsForM17n2','Faqs','2019-03-02 03:14:23'),(243,'AddIsOriginalCopy','Faqs','2019-03-02 03:14:23'),(244,'Init','Groups','2019-03-02 03:14:24'),(245,'AlterTable','Groups','2019-03-02 03:14:24'),(246,'AddIndex','Groups','2019-03-02 03:14:24'),(247,'Init','Holidays','2019-03-02 03:14:24'),(248,'ChangeDayOfTheWeek','Holidays','2019-03-02 03:14:24'),(249,'ModifyIndex','Holidays','2019-03-02 03:14:24'),(250,'HolidayRecords','Holidays','2019-03-02 03:14:29'),(251,'PluginRecords','Holidays','2019-03-02 03:14:29'),(252,'AddFieldsForM17n','Holidays','2019-03-02 03:14:29'),(253,'AddTableForM17n1','Holidays','2019-03-02 03:14:29'),(254,'AddIsOriginalCopy','Holidays','2019-03-02 03:14:29'),(255,'PluginRecords','Iframes','2019-03-02 03:14:30'),(256,'Init','Iframes','2019-03-02 03:14:30'),(257,'AddIframeFrameSettings','Iframes','2019-03-02 03:14:30'),(258,'AddIndex','Iframes','2019-03-02 03:14:30'),(259,'Init','Likes','2019-03-02 03:14:30'),(260,'AddIndex','Likes','2019-03-02 03:14:31'),(261,'ReconsiderIndexes','Likes','2019-03-02 03:14:31'),(262,'PluginRecords','Links','2019-03-02 03:14:31'),(263,'LinkMailSettingRecords','Links','2019-03-02 03:14:31'),(264,'Initial','Links','2019-03-02 03:14:31'),(265,'DeleteLinkSettings','Links','2019-03-02 03:14:31'),(266,'AddIndex','Links','2019-03-02 03:14:31'),(267,'AddFieldsForM17n','Links','2019-03-02 03:14:31'),(268,'AddIsOriginalCopy','Links','2019-03-02 03:14:32'),(269,'PluginRecords','Menus','2019-03-02 03:14:32'),(270,'Init','Menus','2019-03-02 03:14:32'),(271,'AddIndex','Menus','2019-03-02 03:14:32'),(272,'MenuFrameSettingsRecords','Menus','2019-03-02 03:14:32'),(273,'MenuNewTemplateAdd','Menus','2019-03-02 03:14:32'),(274,'DeleteMainType','Menus','2019-03-02 03:14:32'),(275,'MenuFramesToPageFromRoom','Menus','2019-03-02 03:14:32'),(276,'PluginRecords','Multidatabases','2019-03-02 03:14:33'),(277,'MultidatabaseMailSettingRecords','Multidatabases','2019-03-02 03:14:33'),(278,'BlockSettingRecords','Multidatabases','2019-03-02 03:14:33'),(279,'Init','Multidatabases','2019-03-02 03:14:33'),(280,'AddRecord','Nc2ToNc3','2019-03-02 03:14:33'),(281,'Initial','Nc2ToNc3','2019-03-02 03:14:33'),(282,'Init','Notifications','2019-03-02 03:14:34'),(283,'DeleteRecords','Notifications','2019-03-02 03:14:34'),(284,'BlockSettingRecords','PhotoAlbums','2019-03-02 03:14:34'),(285,'Initial','PhotoAlbums','2019-03-02 03:14:34'),(286,'AddRecord','PhotoAlbums','2019-03-02 03:14:34'),(287,'UpdateRecord','PhotoAlbums','2019-03-02 03:14:34'),(288,'AddIndex','PhotoAlbums','2019-03-02 03:14:34'),(289,'DeletePhotoAlbumSettings','PhotoAlbums','2019-03-02 03:14:34'),(290,'AddSlideHeight','PhotoAlbums','2019-03-02 03:14:34'),(291,'RenamePluginNamespace','PhotoAlbums','2019-03-02 03:14:35'),(292,'AddFieldsForM17n','PhotoAlbums','2019-03-02 03:14:35'),(293,'AddIsOriginalCopy','PhotoAlbums','2019-03-02 03:14:35'),(294,'PluginRecords','Questionnaires','2019-03-02 03:14:35'),(295,'QuestionnaireMailSettingRecords','Questionnaires','2019-03-02 03:14:35'),(296,'Init','Questionnaires','2019-03-02 03:14:35'),(297,'ChangePublicType','Questionnaires','2019-03-02 03:14:36'),(298,'AddTitleIcon','Questionnaires','2019-03-02 03:14:36'),(299,'ChangeSortType','Questionnaires','2019-03-02 03:14:36'),(300,'AddChoiceHorizon','Questionnaires','2019-03-02 03:14:36'),(301,'DeleteQuestionnaireSettings','Questionnaires','2019-03-02 03:14:36'),(302,'AddFieldsForM17n','Questionnaires','2019-03-02 03:14:36'),(303,'AddIsOriginalCopy','Questionnaires','2019-03-02 03:14:36'),(304,'PluginRecords','Quizzes','2019-03-02 03:14:37'),(305,'QuizzesMailSettingRecords','Quizzes','2019-03-02 03:14:37'),(306,'Init','Quizzes','2019-03-02 03:14:37'),(307,'AddChoiceHorizon','Quizzes','2019-03-02 03:14:37'),(308,'AddAnswerCorrectStatus','Quizzes','2019-03-02 03:14:37'),(309,'DeleteQuizSettings','Quizzes','2019-03-02 03:14:37'),(310,'AddIsAnswerMailSend','Quizzes','2019-03-02 03:14:37'),(311,'AddFieldsForM17n','Quizzes','2019-03-02 03:14:37'),(312,'AddIsOriginalCopy','Quizzes','2019-03-02 03:14:38'),(313,'AddCorrectLabel','Quizzes','2019-03-02 03:14:38'),(314,'UpdateRecordCorrectLabel','Quizzes','2019-03-02 03:14:38'),(315,'PluginRecords','Registrations','2019-03-02 03:14:38'),(316,'RegistrationMailSettingRecords','Registrations','2019-03-02 03:14:38'),(317,'Init','Registrations','2019-03-02 03:14:38'),(318,'ChangePublicType','Registrations','2019-03-02 03:14:38'),(319,'AddTitleIcon','Registrations','2019-03-02 03:14:38'),(320,'ChangeSortType','Registrations','2019-03-02 03:14:38'),(321,'AddChoiceHorizon','Registrations','2019-03-02 03:14:39'),(322,'AlterTable','Registrations','2019-03-02 03:14:39'),(323,'AddRegistrationMail','Registrations','2019-03-02 03:14:39'),(324,'DropTableRegistrationFrames','Registrations','2019-03-02 03:14:39'),(325,'AddFieldsForM17n','Registrations','2019-03-02 03:14:39'),(326,'AddIsOriginalCopy','Registrations','2019-03-02 03:14:39'),(327,'AddAnswerSummarySerialNumber','Registrations','2019-03-02 03:14:39'),(328,'PluginRecords','Reservations','2019-03-02 03:14:40'),(329,'ReservationMailSettingRecords','Reservations','2019-03-02 03:14:40'),(330,'Init','Reservations','2019-03-02 03:14:40'),(331,'StatusAndOthersMoveRruleToEvent','Reservations','2019-03-02 03:14:40'),(332,'AddEmailSendTiming','Reservations','2019-03-02 03:14:40'),(333,'DeleteColumnsUseWorkflow','Reservations','2019-03-02 03:14:40'),(334,'ChangeIreservationUid','Reservations','2019-03-02 03:14:40'),(335,'AddFieldsForM17n','Reservations','2019-03-02 03:14:40'),(336,'AddIsOriginalCopy','Reservations','2019-03-02 03:14:40'),(337,'AddLocations','Reservations','2019-03-02 03:14:41'),(338,'AlterFrameSettings','Reservations','2019-03-02 03:14:41'),(339,'AddTimeframesLocationsRooms','Reservations','2019-03-02 03:14:41'),(340,'RemoveFrameSettingsCategoryId','Reservations','2019-03-02 03:14:41'),(341,'AddFramesettingCategoryId','Reservations','2019-03-02 03:14:41'),(342,'AddReservationLocationPermissions','Reservations','2019-03-02 03:14:41'),(343,'RenameLocationPermission','Reservations','2019-03-02 03:14:41'),(344,'AlterLocationAddUseWorkflow','Reservations','2019-03-02 03:14:41'),(345,'CreateLocationsApprovalUsers','Reservations','2019-03-02 03:14:41'),(346,'AddTimezoneInLocation','Reservations','2019-03-02 03:14:41'),(347,'ChangeStartTimeEndTime','Reservations','2019-03-02 03:14:41'),(348,'AddDefaultRolePermissions','Reservations','2019-03-02 03:14:41'),(349,'AlterTimeframe','Reservations','2019-03-02 03:14:41'),(350,'AlterLocation','Reservations','2019-03-02 03:14:41'),(351,'AlterEventAddCalendarKeyAndTimezone','Reservations','2019-03-02 03:14:41'),(352,'TimezoneOffsetToId','Reservations','2019-03-02 03:14:42'),(353,'RemoveEventContent','Reservations','2019-03-02 03:14:42'),(354,'PluginRecords','RssReaders','2019-03-02 03:14:42'),(355,'RssReaderMailSettingRecords','RssReaders','2019-03-02 03:14:42'),(356,'Init','RssReaders','2019-03-02 03:14:42'),(357,'AddRssReaderSettings','RssReaders','2019-03-02 03:14:42'),(358,'DeleteRssReaderSettings','RssReaders','2019-03-02 03:14:42'),(359,'AddIndex','RssReaders','2019-03-02 03:14:42'),(360,'AddFieldsForM17n','RssReaders','2019-03-02 03:14:42'),(361,'AddIsOriginalCopy','RssReaders','2019-03-02 03:14:42'),(362,'PluginRecords','Searches','2019-03-02 03:14:43'),(363,'PluginRecords2','Searches','2019-03-02 03:14:43'),(364,'Init','Searches','2019-03-02 03:14:43'),(365,'AddIndex','Searches','2019-03-02 03:14:43'),(366,'PluginRecords','SystemManager','2019-03-02 03:14:43'),(367,'Init','Tags','2019-03-02 03:14:43'),(368,'FixOriginId','Tags','2019-03-02 03:14:43'),(369,'OriginIdToKey','Tags','2019-03-02 03:14:43'),(370,'AddIndex','Tags','2019-03-02 03:14:43'),(371,'AddFieldsForM17n','Tags','2019-03-02 03:14:43'),(372,'AddTableForM17n1','Tags','2019-03-02 03:14:43'),(373,'AddIsOriginalCopy','Tags','2019-03-02 03:14:44'),(374,'PluginRecords','Tasks','2019-03-02 03:14:44'),(375,'Initialize','Tasks','2019-03-02 03:14:44'),(376,'BlockSettingRecords','Tasks','2019-03-02 03:14:44'),(377,'DeleteTaskSettings','Tasks','2019-03-02 03:14:44'),(378,'TaskMailSettingRecords','Tasks','2019-03-02 03:14:44'),(379,'AddIsDateSet','Tasks','2019-03-02 03:14:44'),(380,'ChangeCalenderId','Tasks','2019-03-02 03:14:44'),(381,'DeleteColumnStatus','Tasks','2019-03-02 03:14:44'),(382,'AddFieldsForM17n','Tasks','2019-03-02 03:14:44'),(383,'AddIsOriginalCopy','Tasks','2019-03-02 03:14:44'),(384,'PluginRecords','Topics','2019-03-02 03:14:45'),(385,'Init','Topics','2019-03-02 03:14:45'),(386,'ModifiedForSpecificBlock','Topics','2019-03-02 03:14:45'),(387,'AddIndex','Topics','2019-03-02 03:14:45'),(388,'AddIsInRoom','Topics','2019-03-02 03:14:45'),(389,'RenamePluginName','Topics','2019-03-02 03:14:45'),(390,'AddFieldsForM17n','Topics','2019-03-02 03:14:46'),(391,'AddIsOriginalCopy','Topics','2019-03-02 03:14:46'),(392,'AddIndexForTopicsBehavior','Topics','2019-03-02 03:14:46'),(393,'ReconsiderIndexes','Topics','2019-03-02 03:14:46'),(394,'ForSpeedUp','Topics','2019-03-02 03:14:46'),(395,'PluginRecords','UserAttributes','2019-03-02 03:14:46'),(396,'Init','UserAttributes','2019-03-02 03:14:46'),(397,'Records','UserAttributes','2019-03-02 03:14:46'),(398,'UserAttributesRecords','UserAttributes','2019-03-02 03:14:47'),(399,'AddLanguageRecords','UserAttributes','2019-03-02 03:14:47'),(400,'AddUsenamePasswordDesc','UserAttributes','2019-03-02 03:14:47'),(401,'DeleteDataTypeLanguage','UserAttributes','2019-03-02 03:14:47'),(402,'AddIndex','UserAttributes','2019-03-02 03:14:47'),(403,'AddFieldsForM17n','UserAttributes','2019-03-02 03:14:47'),(404,'AddTableForM17n1','UserAttributes','2019-03-02 03:14:47'),(405,'AddIsOriginalCopy','UserAttributes','2019-03-02 03:14:47'),(406,'UpdateSystemRequire','UserAttributes','2019-03-02 03:14:47'),(407,'PluginRecords','UserManager','2019-03-02 03:14:48'),(408,'UserManagerMailSettingRecords','UserManager','2019-03-02 03:14:48'),(409,'PluginRecords','UserRoles','2019-03-02 03:14:48'),(410,'Init','UserRoles','2019-03-02 03:14:48'),(411,'Records','UserRoles','2019-03-02 03:14:48'),(412,'AddLanguageRecords','UserRoles','2019-03-02 03:14:48'),(413,'AddIndex','UserRoles','2019-03-02 03:14:48'),(414,'GuestRecords','UserRoles','2019-03-02 03:14:49'),(415,'PluginRecords','Videos','2019-03-02 03:14:49'),(416,'VideoMailSettingRecords','Videos','2019-03-02 03:14:49'),(417,'VideoBlockSettingRecords','Videos','2019-03-02 03:14:49'),(418,'Videos','Videos','2019-03-02 03:14:49'),(419,'AddIndex','Videos','2019-03-02 03:14:49'),(420,'DeleteVideoBlockSettings','Videos','2019-03-02 03:14:49'),(421,'AddVideoSettings','Videos','2019-03-02 03:14:49'),(422,'AddFieldsForM17n','Videos','2019-03-02 03:14:49'),(423,'AddIsOriginalCopy','Videos','2019-03-02 03:14:49'),(424,'ModDescriptionNl2br','Videos','2019-03-02 03:14:49'),(425,'Init','Workflow','2019-03-02 03:14:50'),(426,'AddIndex','Workflow','2019-03-02 03:14:50'),(427,'DeletePublishablePermission','Blocks','2019-03-03 09:46:06'),(428,'ImprovePerformanceCurrent','Blocks','2019-03-03 09:46:06'),(429,'ImprovePerformanceCurrent2','Blocks','2019-03-03 09:46:06'),(430,'ImprovePerformanceCurrent','Boxes','2019-03-03 09:52:49'),(431,'ImprovePerformanceCurrent','Frames','2019-03-03 09:52:51'),(432,'ImprovePerformanceCurrent','Rooms','2019-03-03 09:52:56');
/*!40000 ALTER TABLE `schema_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search_frame_settings`
--

DROP TABLE IF EXISTS `search_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `is_advanced` tinyint(1) NOT NULL COMMENT '0: 簡易検索, 1: 詳細検索',
  `created_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified_user` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search_frame_settings`
--

LOCK TABLES `search_frame_settings` WRITE;
/*!40000 ALTER TABLE `search_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search_frames_plugins`
--

DROP TABLE IF EXISTS `search_frames_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_frames_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `plugin_key` varchar(255) NOT NULL,
  `created_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified_user` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search_frames_plugins`
--

LOCK TABLES `search_frames_plugins` WRITE;
/*!40000 ALTER TABLE `search_frames_plugins` DISABLE KEYS */;
/*!40000 ALTER TABLE `search_frames_plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL COMMENT '共通の場合、0',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `key` varchar(255) NOT NULL COMMENT 'キー    e.g.) theme_name, site_name',
  `value` text COMMENT '値    e.g.) default, My Homepage',
  `label` varchar(255) NOT NULL COMMENT '項目名    e.g.) Theme, Site Name',
  `weight` int(11) DEFAULT NULL COMMENT '表示順序',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,2,1,1,0,'App.site_name','NetCommons3','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(2,1,0,1,0,'App.site_name','NetCommons3','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(3,0,0,1,0,'Config.language','ja','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(4,0,0,1,0,'App.default_start_room','2','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(5,0,0,1,0,'ForgotPass.use_password_reissue','1','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(6,2,1,1,0,'ForgotPass.issue_mail_subject','[{X-SITE_NAME}]新規パスワードのリクエスト','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(7,1,0,1,0,'ForgotPass.issue_mail_subject','[{X-SITE_NAME}]Request for new password','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(8,2,1,1,0,'ForgotPass.issue_mail_body','{X-SITE_NAME}におけるログイン用パスワードの新規発行リクエストがありました。\n新たにパスワードを発行する場合は、認証キー入力画面で、下記の認証キーを入力してください。\n\nこのリクエストが手違いの場合はこのメールを破棄してください。\n今までのパスワードでログインすることができます。\n\n認証キー：\n{X-AUTHORIZATION_KEY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(9,1,0,1,0,'ForgotPass.issue_mail_body','A web user has just requested for a new password for your account at {X-SITE_NAME} site.\nIf you didn\'t ask for one, don\'t worry.  Just delete this e-mail.\nIf you want to issue a new password, the authentication key input screen, please enter the authentication key below.\n\nAuthorization key：\n{X-AUTHORIZATION_KEY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(10,2,1,1,0,'ForgotPass.request_mail_subject','[{X-SITE_NAME}]新規パスワードのリクエスト','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(11,1,0,1,0,'ForgotPass.request_mail_subject','[{X-SITE_NAME}]Request for new password','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(12,2,1,1,0,'ForgotPass.request_mail_body','{X-SITE_NAME}におけるログイン用パスワードの新規発行リクエストがありました。\n下記のログインIDを使用して、新しいパスワードを再登録してください。\n\nハンドル: {X-HANDLENAME}\nログインID: {X-USERNAME}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(13,1,0,1,0,'ForgotPass.request_mail_body','A web user has just requested for a new password for your account at {X-SITE_NAME} site.\nUsing the login ID of the following, please re-register the new password.\n\nHandle: {X-HANDLENAME}\nLogin id: {X-USERNAME}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(14,0,0,1,0,'App.close_site','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(15,2,1,1,0,'App.site_closing_reason','<div class=\"jumbotron\"><h1>{X-SITE_NAME}</h1><h2>このサイトはただいまメンテナンス中です。後程お越しください。</h2></div>','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(16,1,0,1,0,'App.site_closing_reason','<div class=\"jumbotron\"><h1>{X-SITE_NAME}</h1><h2>This site is on maintenance. Please try again later.</h2></div>','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(21,0,0,1,0,'Meta.robots','index,follow','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(22,0,0,1,0,'AutoRegist.use_automatic_register','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(23,0,0,1,0,'AutoRegist.confirmation','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(24,0,0,1,0,'AutoRegist.use_secret_key','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(25,0,0,1,0,'AutoRegist.secret_key','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(26,0,0,1,0,'AutoRegist.role_key','common_user','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(27,0,0,1,0,'AutoRegist.prarticipate_default_room','1','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(28,2,1,1,0,'AutoRegist.disclaimer','<p>本規約は、当サイトにより提供されるコンテンツの利用条件を定めるものです。以下の利用条件をよくお読みになり、これに同意される場合にのみご登録いただきますようお願いいたします。</p>\n<p>当サイトを利用するにあたり、以下に該当する又はその恐れのある行為を行ってはならないものとします。</p>\n<ul>\n    <li>公序良俗に反する行為</li>\n    <li>法令に違反する行為</li>\n    <li>犯罪行為及び犯罪行為に結びつく行為</li>\n    <li>他の利用者、第三者、当サイトの権利を侵害する行為</li>\n    <li>他の利用者、第三者、当サイトを誹謗、中傷する行為及び名誉・信用を傷つける行為</li>\n    <li>他の利用者、第三者、当サイトに不利益を与える行為</li>\n    <li>当サイトの運営を妨害する行為</li>\n    <li>事実でない情報を発信する行為</li>\n    <li>プライバシー侵害の恐れのある個人情報の投稿</li>\n    <li>その他、当サイトが不適当と判断する行為</li>\n</ul>\n<p>【免責】</p>\n<p>\n    利用者が当サイト及び当サイトに関連するコンテンツ、リンク先サイトにおける一切のサービス等をご利用されたことに起因または関連して生じた一切の損害（間接的であると直接的であるとを問わない）について、当サイトは責任を負いません。\n</p>','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(29,1,0,1,0,'AutoRegist.disclaimer','<p>The terms & conditions for using the contents of this site is governed by this agreement. Please read carefully the following conditions, and register only if you agree to them.</p>\n<p>By using this site, I agree to refrain from the following actions, or behavior that may lead to the following actions.</p>\n<ul>\n    <li>actions that are against public order or morals</li>\n    <li>actions that are against the laws or ordinances</li>\n    <li>criminal acts or actions connected to criminal acts</li>\n    <li>actions that violate rights of other users, third party, or this site</li>\n    <li>actions that slander, defame, or cause the loss of prestige or credibility of other users, third party, or this site</li>\n    <li>actions that result in liability to other users, third party, or this site</li>\n    <li>actions that hinder the operation of this site</li>\n    <li>actions that disseminate information that are not true<b/lir>\n    <li>postings of personal information that may lead to invasion of privacy</li>\n    <li>other actions that are deemed unsuitable by this site</li>\n</ul>\n<p>Disclaimer</p>\n<p>This site is not responsible for damage (direct or indirect) to user that is caused by, is resulted from the connection of, the usage of this site, contents related to this site, services from links stemming from this site, etc.</p>','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(30,2,1,0,0,'AutoRegist.approval_mail_subject','[{X-SITE_NAME}]会員登録確認メール','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(31,1,0,0,0,'AutoRegist.approval_mail_subject','Welcome to {X-SITE_NAME}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(32,2,1,1,0,'AutoRegist.approval_mail_body','{X-SITE_NAME}におけるユーザ登録用メールアドレスとしてあなたのメールアドレスが使用されました。\nもし{X-SITE_NAME}でのユーザ登録に覚えがない場合はこのメールを破棄してください。\n\n{X-SITE_NAME}でのユーザ登録を完了するには下記のリンクをクリックして登録の承認を行ってください。\n\n{X-URL}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(33,1,0,1,0,'AutoRegist.approval_mail_body','Thank you for your registereing for {X-SITE_NAME} site.\nYour email address has been used to register an account.\nIf you did not ask for one, don\'t worry. Just delete this e-mail.\nPlease confirm your request by clicking on the link below:\n\n{X-URL}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(34,2,1,1,0,'AutoRegist.acceptance_mail_subject','[{X-SITE_NAME}]承認待ち会員のお知らせ','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(35,1,0,1,0,'AutoRegist.acceptance_mail_subject','[{X-SITE_NAME}]New Registrant','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(36,2,1,1,0,'AutoRegist.acceptance_mail_body','{X-SITE_NAME}にて新規登録ユーザがありました。\n\nログインを許可する場合は、下記のリンクをクリックして登録ユーザ宛てに承認メールを送信してください。\n\n{X-URL}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(37,1,0,1,0,'AutoRegist.acceptance_mail_body','A new user has just registered.\nClicking on the link below will activate the account of this user.\n\n{X-URL}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(38,0,0,1,0,'UserCancel.use_cancel_feature','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(39,2,1,1,0,'UserCancel.disclaimer','<p><span style=\"color: #f25a62; text-decoration: underline;\"><strong>個人情報の削除</strong></span><br />個人情報として登録された内容とプライベートルームの内容がアップロードファイルも含めて完全に削除されます。<br />同じメールアドレスを使って再登録することはできますが、同じプライベートルームを利用することはできません。</p><p>&nbsp;</p><p><span style=\"color: #f25a62; text-decoration: underline;\"><strong>個人情報の削除されない項目</strong></span><br />パブリックおよびコミュニティに投稿した内容やアップロードしたファイル等は、退会処理では削除されません。<br />投稿した内容を残したくない場合は、これらの書き込みを削除してから退会処理を行ってください。</p>','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(40,1,0,1,0,'UserCancel.disclaimer','<p><span style=\"color: #f25a62; text-decoration: underline;\"><strong>User data which will be deleted</strong></span><br />If proceeded, your user profile and private room in this NetCommons will vanish, and cannot be used again.</p><p><span style=\"color: #f25a62; text-decoration: underline;\"><strong>User data which will not be deleted</strong></span><br />Your posts and uploaded files in this NetCommons will not be deleted automatically.<br />If you wish to delete them, you have to do it manually before you cancel your account.','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(41,0,0,0,0,'UserCancel.notify_administrators','1','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(42,2,1,1,0,'UserCancel.mail_subject','[{X-SITE_NAME}]会員退会のお知らせ','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(43,1,0,1,0,'UserCancel.mail_subject','[{X-SITE_NAME}]Announcements for leaving Members','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(44,2,1,1,0,'UserCancel.mail_body','{X-SITE_NAME}の{X-HANDLE}が退会しました。','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(45,1,0,1,0,'UserCancel.mail_body','{X-SITE_NAME}\'s{X-HANDLE} is already leaved.','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(46,2,1,1,0,'Workflow.approval_mail_subject','(承認依頼){X-PLUGIN_MAIL_SUBJECT}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(47,1,0,1,0,'Workflow.approval_mail_subject','(approval request){X-PLUGIN_MAIL_SUBJECT}[{X-SITE_NAME}]{X-PLUGIN_NAME}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(48,2,1,1,0,'Workflow.approval_mail_body','{X-USER}さんから{X-PLUGIN_NAME}の承認依頼があったことをお知らせします。\n\n{X-WORKFLOW_COMMENT}\n\n\n{X-PLUGIN_MAIL_BODY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(49,1,0,1,0,'Workflow.approval_mail_body','{X-USER} we let you know that there was an approval request of {X-PLUGIN_NAME} from.\n\n{X-WORKFLOW_COMMENT}\n\n\n{X-PLUGIN_MAIL_BODY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(50,2,1,1,0,'Workflow.disapproval_mail_subject','(差し戻し){X-PLUGIN_MAIL_SUBJECT}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(51,1,0,1,0,'Workflow.disapproval_mail_subject','(remand){X-PLUGIN_MAIL_SUBJECT} [{X-SITE_NAME}]{X-PLUGIN_NAME}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(52,2,1,1,0,'Workflow.disapproval_mail_body','{X-USER}さんの{X-PLUGIN_NAME}が差し戻しされたことをお知らせします。\nもし{X-USER}さんの{X-PLUGIN_NAME}に覚えがない場合はこのメールを破棄してください。\n\n{X-WORKFLOW_COMMENT}\n\n\n{X-PLUGIN_MAIL_BODY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(53,1,0,1,0,'Workflow.disapproval_mail_body','{X-USER} \'s {X-PLUGIN_NAME} is to inform you that it has been remanded.\nPlease discard this email if you\'re still unable to recognize the if {X-USER} \'s {X-PLUGIN_NAME}.\n\n{X-WORKFLOW_COMMENT}\n\n\n{X-PLUGIN_MAIL_BODY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(54,2,1,1,0,'Workflow.approval_completion_mail_subject','(承認完了){X-PLUGIN_MAIL_SUBJECT}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(55,1,0,1,0,'Workflow.approval_completion_mail_subject','(approval completion){X-PLUGIN_MAIL_SUBJECT}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(56,2,1,1,0,'Workflow.approval_completion_mail_body','{X-USER}さんの{X-PLUGIN_NAME}の承認が完了されたことをお知らせします。\nもし{X-USER}さんの{X-PLUGIN_NAME}に覚えがない場合はこのメールを破棄してください。\n\n{X-WORKFLOW_COMMENT}\n\n\n{X-PLUGIN_MAIL_BODY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(57,1,0,1,0,'Workflow.approval_completion_mail_body','To inform you that approval of {X-USER} \'s {X-PLUGIN_NAME} has been completed.\nPlease discard this email if you\'re still unable to recognize the if {X-USER} \'s {X-PLUGIN_NAME}.\n\n{X-WORKFLOW_COMMENT}\n\n\n{X-PLUGIN_MAIL_BODY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(58,2,1,1,0,'Mail.body_header','※このメールに返信しても相手には届きませんのでご注意ください。\n\n','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(59,1,0,1,0,'Mail.body_header','- Please note even if you reply this mail directly, the mail\'s sender can not receive it.\n\n','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(60,2,1,1,0,'Mail.signature','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(61,1,0,1,0,'Mail.signature','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(62,0,0,1,0,'App.default_timezone','Asia/Tokyo','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(63,0,0,1,0,'Session.ini.[session.cookie_lifetime]','21600','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(64,0,0,1,0,'Session.ini.[session.gc_maxlifetime]','21600','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(65,0,0,1,0,'Php.memory_limit','128M','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(66,0,0,1,0,'Session.cookie','nc_cookie','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(67,0,0,1,0,'Proxy.use_proxy','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(68,0,0,1,0,'Proxy.host','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(69,0,0,1,0,'Proxy.port','8080','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(70,0,0,1,0,'Proxy.user','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(71,0,0,1,0,'Proxy.pass','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(72,0,0,1,0,'Mail.from','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(73,2,1,1,0,'Mail.from_name','管理者','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(74,1,0,1,0,'Mail.from_name','Administrator','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(75,0,0,1,0,'Mail.messageType','text','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(76,0,0,1,0,'Mail.transport','smtp','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(77,0,0,1,0,'Mail.sendmail','/usr/sbin/sendmail','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(78,0,0,1,0,'Mail.smtp.host','localhost','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(79,0,0,1,0,'Mail.smtp.port','25','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(80,0,0,1,0,'Mail.smtp.user','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(81,0,0,1,0,'Mail.smtp.pass','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(82,0,0,1,0,'Mail.use_cron','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(83,0,0,1,0,'Upload.allow_extension','csv,hqx,doc,docx,dot,bin,lha,lzh,class,so,dll,pdf,ai,eps,ps,smi,smil,wbxml,wmlc,wmlsc,xla,xls,xlsx,xlt,ppt,pptx,csh,dcr,dir,dxr,spl,gtar,sh,swf,sit,tar,tcl,ent,dtd,mod,gz,tgz,zip,au,snd,mid,midi,kar,mp1,mp2,mp3,aif,aiff,m3u,ram,rm,rpm,ra,wav,bmp,gif,jpeg,jpg,jpe,png,tiff,tif,wbmp,pnm,pbm,pgm,ppm,xbm,xpm,ics,ifb,css,asc,txt,rtf,sgml,sgm,tsv,wml,wmls,xsl,mpeg,mpg,mpe,qt,mov,avi,wmv,asf,tex,dvi,mcw,wps,xjs,xlw,wk1,wk2,wk3,wk4,wj2,wj3,pot,pps,ppa,wmf,mdb,mwd,odb,obt,obz,psd,svg,svgz,bak,cab,chm,dic,eml,hlp,ini,jhd,jtd,msg,rmi,wab,wma,smf,aac,m4a,m4v,wpl,xslt,flv,odt,odg,ods,odp,odf,odb,docm,dotm,dotx,fla,jtt,mp4,xltx','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(84,0,0,1,0,'Security.deny_ip_move','system_administrator|administrator','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(85,0,0,1,0,'Security.enable_bad_ips','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(86,0,0,1,0,'Security.bad_ips','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(87,0,0,1,0,'Security.enable_allow_system_plugin_ips','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(88,0,0,1,0,'debug','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(89,0,0,0,0,'Security.allow_system_plugin_ips','','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(90,1,0,1,0,'Meta.author','NetCommons','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(91,2,1,1,0,'Meta.author','NetCommons','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(92,1,0,1,0,'Meta.copyright','Copyright © 2016','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(93,2,1,1,0,'Meta.copyright','Copyright © 2016','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(94,1,0,1,0,'Meta.keywords','CMS,Netcommons,NetCommons3,CakePHP','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(95,2,1,1,0,'Meta.keywords','CMS,Netcommons,NetCommons3,CakePHP','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(96,1,0,1,0,'Meta.description','CMS,Netcommons,NetCommons3,CakePHP','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(97,2,1,1,0,'Meta.description','CMS,Netcommons,NetCommons3,CakePHP','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(98,0,0,1,0,'Mail.smtp.tls','0','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(99,2,1,1,0,'Workflow.contact_after_approval_mail_subject','(担当者への連絡){X-PLUGIN_MAIL_SUBJECT}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(100,1,0,1,0,'Workflow.contact_after_approval_mail_subject','(contact the person in charge){X-PLUGIN_MAIL_SUBJECT}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(101,2,1,1,0,'Workflow.contact_after_approval_mail_body','{X-USER}さんから{X-PLUGIN_NAME}の担当者への連絡があったことをお知らせします。\n\n{X-WORKFLOW_COMMENT}\n\n\n{X-PLUGIN_MAIL_BODY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(102,1,0,1,0,'Workflow.contact_after_approval_mail_body','Let you know that there was a report from {X-USER} \'s to the person in charge of {X-PLUGIN_NAME}.\n\n{X-WORKFLOW_COMMENT}\n\n\n{X-PLUGIN_MAIL_BODY}','',NULL,NULL,'2019-03-02 03:14:07',NULL,'2019-03-02 03:14:07'),(103,0,1,0,0,'Search.type','match_against','',NULL,NULL,'2019-03-02 03:14:45',NULL,'2019-03-02 03:14:45');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spaces`
--

DROP TABLE IF EXISTS `spaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spaces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT 'スペースタイプ  1:サイト全体,2:パブリックスペース,3:プライベートスペース,4:コミュニティスペース',
  `plugin_key` varchar(255) DEFAULT NULL,
  `default_setting_action` varchar(255) DEFAULT NULL,
  `room_disk_size` bigint(20) DEFAULT NULL COMMENT '各ルームの容量。NULLの場合、無制限。',
  `room_id_root` int(11) DEFAULT NULL,
  `page_id_top` int(11) DEFAULT NULL,
  `permalink` varchar(255) NOT NULL,
  `is_m17n` tinyint(1) DEFAULT '0',
  `after_user_save_model` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permalink` (`permalink`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spaces`
--

LOCK TABLES `spaces` WRITE;
/*!40000 ALTER TABLE `spaces` DISABLE KEYS */;
INSERT INTO `spaces` VALUES (1,NULL,1,8,1,NULL,NULL,NULL,1,NULL,'',0,NULL,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:12'),(2,1,2,3,2,'public_space','rooms/index/2',NULL,1,1,'',1,NULL,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:13'),(3,1,4,5,3,'private_space','rooms/index/3',52428800,2,2,'private',0,'PrivateSpace.PrivateSpace',NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:13'),(4,1,6,7,4,'community_space','rooms/index/4',524288000,3,3,'community',0,NULL,NULL,'2019-03-02 03:14:12',NULL,'2019-03-02 03:14:13');
/*!40000 ALTER TABLE `spaces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_id` int(11) NOT NULL COMMENT 'ブロックID',
  `model` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `name` varchar(255) NOT NULL COMMENT 'タグ名',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags_contents`
--

DROP TABLE IF EXISTS `tags_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) NOT NULL,
  `content_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `model` (`model`,`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags_contents`
--

LOCK TABLES `tags_contents` WRITE;
/*!40000 ALTER TABLE `tags_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_charges`
--

DROP TABLE IF EXISTS `task_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `task_content_id` int(11) NOT NULL DEFAULT '0' COMMENT 'ToDoコンテンツID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '作成者',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_charges`
--

LOCK TABLES `task_charges` WRITE;
/*!40000 ALTER TABLE `task_charges` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_contents`
--

DROP TABLE IF EXISTS `task_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `task_key` varchar(255) NOT NULL,
  `block_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT 'カテゴリーID',
  `status` int(4) NOT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_latest` tinyint(1) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `title` varchar(255) NOT NULL COMMENT 'タイトル',
  `content` text COMMENT 'タスク内容',
  `priority` int(4) DEFAULT '0' COMMENT '重要度 0:未設定、1:低、2:中、3:高',
  `task_start_date` datetime DEFAULT NULL,
  `task_end_date` datetime DEFAULT NULL,
  `is_enable_mail` tinyint(1) NOT NULL DEFAULT '0',
  `email_send_timing` int(11) NOT NULL DEFAULT '0',
  `use_calendar` tinyint(1) NOT NULL DEFAULT '0',
  `is_completion` tinyint(1) NOT NULL DEFAULT '0',
  `progress_rate` int(11) NOT NULL DEFAULT '0',
  `key` varchar(255) NOT NULL COMMENT 'タスクKey',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  `is_date_set` tinyint(1) NOT NULL DEFAULT '0',
  `calendar_key` varchar(255) DEFAULT NULL COMMENT 'カレンダーKey',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_contents`
--

LOCK TABLES `task_contents` WRITE;
/*!40000 ALTER TABLE `task_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_id` int(11) NOT NULL,
  `language_id` int(6) NOT NULL DEFAULT '2',
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `name` varchar(255) NOT NULL COMMENT 'Todo名',
  `key` varchar(255) NOT NULL COMMENT 'Todo Key',
  `public_type` int(4) NOT NULL DEFAULT '1' COMMENT '一般以下のパートが閲覧可能かどうか。（0:非公開, 1:公開, 2:期間限定公開',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic_frame_settings`
--

DROP TABLE IF EXISTS `topic_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `display_type` int(4) NOT NULL COMMENT '表示タイプ 0: フラット, 1: プラグインごとに表示, 2: ルームごとに表示',
  `unit_type` int(11) NOT NULL COMMENT '表示数 (n days / n counts)',
  `display_days` int(3) NOT NULL,
  `display_number` int(3) NOT NULL,
  `display_title` tinyint(1) NOT NULL DEFAULT '1',
  `display_summary` tinyint(1) NOT NULL DEFAULT '1',
  `display_room_name` tinyint(1) NOT NULL DEFAULT '1',
  `display_category_name` tinyint(1) NOT NULL DEFAULT '1',
  `display_plugin_name` tinyint(1) NOT NULL DEFAULT '1',
  `display_created_user` tinyint(1) NOT NULL DEFAULT '1',
  `display_created` tinyint(1) NOT NULL DEFAULT '1',
  `use_rss_feed` tinyint(1) NOT NULL,
  `select_room` tinyint(1) NOT NULL,
  `select_block` tinyint(1) NOT NULL,
  `select_plugin` tinyint(1) NOT NULL,
  `show_my_room` tinyint(1) NOT NULL,
  `feed_title` varchar(255) NOT NULL COMMENT 'RSSのタイトル',
  `feed_summary` text COMMENT 'RSSの概要',
  `created_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified_user` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic_frame_settings`
--

LOCK TABLES `topic_frame_settings` WRITE;
/*!40000 ALTER TABLE `topic_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `topic_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic_frames_blocks`
--

DROP TABLE IF EXISTS `topic_frames_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic_frames_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `room_id` int(11) NOT NULL,
  `plugin_key` varchar(255) NOT NULL,
  `block_key` varchar(255) NOT NULL,
  `created_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified_user` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic_frames_blocks`
--

LOCK TABLES `topic_frames_blocks` WRITE;
/*!40000 ALTER TABLE `topic_frames_blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `topic_frames_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic_frames_plugins`
--

DROP TABLE IF EXISTS `topic_frames_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic_frames_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `plugin_key` varchar(255) NOT NULL,
  `created_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified_user` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic_frames_plugins`
--

LOCK TABLES `topic_frames_plugins` WRITE;
/*!40000 ALTER TABLE `topic_frames_plugins` DISABLE KEYS */;
/*!40000 ALTER TABLE `topic_frames_plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic_frames_rooms`
--

DROP TABLE IF EXISTS `topic_frames_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic_frames_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frame_key` varchar(255) NOT NULL,
  `room_id` int(11) NOT NULL,
  `created_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified_user` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic_frames_rooms`
--

LOCK TABLES `topic_frames_rooms` WRITE;
/*!40000 ALTER TABLE `topic_frames_rooms` DISABLE KEYS */;
/*!40000 ALTER TABLE `topic_frames_rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic_readables`
--

DROP TABLE IF EXISTS `topic_readables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic_readables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '会員に結びつかない新着でも0として登録',
  `created_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified_user` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `whatsnew` (`topic_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic_readables`
--

LOCK TABLES `topic_readables` WRITE;
/*!40000 ALTER TABLE `topic_readables` DISABLE KEYS */;
INSERT INTO `topic_readables` VALUES (1,1,0,1,'2019-03-02 03:35:06',1,'2019-03-02 03:35:06'),(2,2,0,1,'2019-03-02 03:35:06',1,'2019-03-02 03:35:06'),(3,3,0,1,'2019-03-02 03:35:45',1,'2019-03-02 03:35:45'),(4,4,0,1,'2019-03-02 03:35:45',1,'2019-03-02 03:35:45'),(5,5,0,1,'2019-03-02 03:38:17',1,'2019-03-02 03:38:17'),(6,6,0,1,'2019-03-02 03:38:17',1,'2019-03-02 03:38:17'),(7,7,0,4,'2019-03-02 03:45:31',4,'2019-03-02 03:45:31'),(8,8,0,1,'2019-03-02 03:50:07',1,'2019-03-02 03:50:07'),(9,9,0,1,'2019-03-02 03:50:07',1,'2019-03-02 03:50:07'),(10,10,0,1,'2019-03-02 03:52:16',1,'2019-03-02 03:52:16'),(11,11,0,1,'2019-03-02 03:52:16',1,'2019-03-02 03:52:16'),(12,12,0,1,'2019-03-02 03:52:39',1,'2019-03-02 03:52:39'),(13,13,0,1,'2019-03-02 03:52:39',1,'2019-03-02 03:52:39'),(14,14,0,1,'2019-03-02 13:45:13',1,'2019-03-02 13:45:13'),(15,15,0,1,'2019-03-02 13:45:13',1,'2019-03-02 13:45:13');
/*!40000 ALTER TABLE `topic_readables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic_user_statuses`
--

DROP TABLE IF EXISTS `topic_user_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic_user_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '閲覧したかどうか',
  `answered` tinyint(1) NOT NULL DEFAULT '0' COMMENT '回答したかどうか',
  `created_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified_user` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `whatsnew` (`topic_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic_user_statuses`
--

LOCK TABLES `topic_user_statuses` WRITE;
/*!40000 ALTER TABLE `topic_user_statuses` DISABLE KEYS */;
INSERT INTO `topic_user_statuses` VALUES (1,1,1,1,0,1,'2019-03-02 03:35:07',1,'2019-03-02 03:35:07'),(2,2,1,1,0,1,'2019-03-02 03:35:07',1,'2019-03-02 03:35:07'),(5,3,1,1,0,1,'2019-03-02 03:37:53',1,'2019-03-02 03:37:53'),(6,4,1,1,0,1,'2019-03-02 03:37:53',1,'2019-03-02 03:37:53'),(7,5,1,1,0,1,'2019-03-02 03:38:18',1,'2019-03-02 03:38:18'),(8,6,1,1,0,1,'2019-03-02 03:38:18',1,'2019-03-02 03:38:18'),(9,5,2,1,0,2,'2019-03-02 03:39:48',2,'2019-03-02 03:39:48'),(10,6,2,1,0,2,'2019-03-02 03:39:48',2,'2019-03-02 03:39:48'),(11,3,2,1,0,2,'2019-03-02 03:39:48',2,'2019-03-02 03:39:48'),(12,4,2,1,0,2,'2019-03-02 03:39:48',2,'2019-03-02 03:39:48'),(13,5,4,1,0,4,'2019-03-02 03:43:27',4,'2019-03-02 03:43:27'),(14,6,4,1,0,4,'2019-03-02 03:43:27',4,'2019-03-02 03:43:27'),(15,3,4,1,0,4,'2019-03-02 03:43:27',4,'2019-03-02 03:43:27'),(16,4,4,1,0,4,'2019-03-02 03:43:27',4,'2019-03-02 03:43:27'),(17,7,4,1,0,4,'2019-03-02 03:45:31',4,'2019-03-02 03:45:31'),(18,10,1,1,0,1,'2019-03-02 03:52:17',1,'2019-03-02 03:52:17'),(19,11,1,1,0,1,'2019-03-02 03:52:17',1,'2019-03-02 03:52:17'),(20,12,1,1,0,1,'2019-03-02 03:52:40',1,'2019-03-02 03:52:40'),(21,13,1,1,0,1,'2019-03-02 03:52:40',1,'2019-03-02 03:52:40'),(22,14,1,1,0,1,'2019-03-02 13:45:14',1,'2019-03-02 13:45:14'),(23,15,1,1,0,1,'2019-03-02 13:45:14',1,'2019-03-02 13:45:14'),(24,7,1,1,0,1,'2019-03-03 09:45:41',1,'2019-03-03 09:45:41');
/*!40000 ALTER TABLE `topic_user_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `room_id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `frame_id` int(11) DEFAULT NULL,
  `content_key` varchar(255) NOT NULL,
  `content_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `plugin_key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_icon` varchar(255) DEFAULT NULL,
  `summary` mediumtext,
  `search_contents` mediumtext,
  `counts` int(11) DEFAULT NULL,
  `path` text NOT NULL,
  `public_type` int(4) NOT NULL DEFAULT '1',
  `publish_start` datetime DEFAULT NULL,
  `publish_end` datetime DEFAULT NULL,
  `is_no_member_allow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '非会員を受け付けるかどうか',
  `is_answer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '回答かどうか',
  `is_in_room` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'ルーム内で完結するかどうか。カレンダーのプライベートの予定を共有するときは、0にする',
  `answer_period_start` datetime DEFAULT NULL,
  `answer_period_end` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '公開中データか否か',
  `is_latest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '最新編集データであるか否か',
  `status` int(4) DEFAULT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `created_user` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified_user` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `plugin_key` (`plugin_key`,`language_id`,`content_key`),
  KEY `whatsnew_plugin` (`plugin_key`,`room_id`,`publish_start`,`id`,`language_id`,`public_type`,`modified`,`publish_end`,`is_active`,`is_latest`,`status`,`created_user`,`modified_user`),
  KEY `whatsnew` (`publish_start`,`id`,`language_id`,`public_type`,`modified`,`publish_end`,`room_id`,`is_active`,`is_latest`,`status`,`created_user`,`modified_user`),
  KEY `plugin_key2` (`plugin_key`,`language_id`,`block_id`,`content_id`),
  KEY `room_id` (`room_id`),
  FULLTEXT KEY `search` (`search_contents`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (1,2,5,5,NULL,'announcement_key_1',2,NULL,'announcements','Private Announcement Content',NULL,'Private Announcement Content\n','a:2:{i:0;a:1:{i:0;s:35:\"<p>Private Announcement Content</p>\";}i:1;a:1:{i:0;s:35:\"<p>Private Announcement Content</p>\";}}',NULL,'/announcements/announcements/view/5/announcement_key_1',1,'2019-03-02 03:35:06',NULL,1,0,1,NULL,NULL,0,1,1,1,0,0,1,'2019-03-02 03:35:06',1,'2019-03-02 03:35:06'),(2,2,5,5,NULL,'announcement_key_1',2,NULL,'announcements','Private Announcement Content',NULL,'Private Announcement Content\n','a:2:{i:0;a:1:{i:0;s:35:\"<p>Private Announcement Content</p>\";}i:1;a:1:{i:0;s:35:\"<p>Private Announcement Content</p>\";}}',NULL,'/announcements/announcements/view/5/announcement_key_1',1,'2019-03-02 03:35:06',NULL,1,0,1,NULL,NULL,1,0,1,1,0,0,1,'2019-03-02 03:35:06',1,'2019-03-02 03:35:06'),(3,2,1,6,9,'announcement_key_2',4,NULL,'announcements','Public Announcement Content 1',NULL,'Public Announcement Content 1\n','a:2:{i:0;a:1:{i:0;s:36:\"<p>Public Announcement Content 1</p>\";}i:1;a:1:{i:0;s:36:\"<p>Public Announcement Content 1</p>\";}}',NULL,'/announcements/announcements/view/6/announcement_key_2',1,'2019-03-02 03:35:45',NULL,1,0,1,NULL,NULL,0,1,1,1,0,0,1,'2019-03-02 03:35:45',1,'2019-03-02 03:37:47'),(4,2,1,6,9,'announcement_key_2',4,NULL,'announcements','Public Announcement Content 1',NULL,'Public Announcement Content 1\n','a:2:{i:0;a:1:{i:0;s:36:\"<p>Public Announcement Content 1</p>\";}i:1;a:1:{i:0;s:36:\"<p>Public Announcement Content 1</p>\";}}',NULL,'/announcements/announcements/view/6/announcement_key_2',1,'2019-03-02 03:35:45',NULL,1,0,1,NULL,NULL,1,0,1,1,0,0,1,'2019-03-02 03:35:45',1,'2019-03-02 03:37:47'),(5,2,1,8,NULL,'announcement_key_4',5,NULL,'announcements','Public Announcement Content 2',NULL,'Public Announcement Content 2\n','a:2:{i:0;a:1:{i:0;s:36:\"<p>Public Announcement Content 2</p>\";}i:1;a:1:{i:0;s:36:\"<p>Public Announcement Content 2</p>\";}}',NULL,'/announcements/announcements/view/8/announcement_key_4',1,'2019-03-02 03:38:17',NULL,1,0,1,NULL,NULL,0,1,1,1,0,0,1,'2019-03-02 03:38:17',1,'2019-03-02 03:38:17'),(6,2,1,8,NULL,'announcement_key_4',5,NULL,'announcements','Public Announcement Content 2',NULL,'Public Announcement Content 2\n','a:2:{i:0;a:1:{i:0;s:36:\"<p>Public Announcement Content 2</p>\";}i:1;a:1:{i:0;s:36:\"<p>Public Announcement Content 2</p>\";}}',NULL,'/announcements/announcements/view/8/announcement_key_4',1,'2019-03-02 03:38:17',NULL,1,0,1,NULL,NULL,1,0,1,1,0,0,1,'2019-03-02 03:38:17',1,'2019-03-02 03:38:17'),(7,2,1,9,NULL,'announcement_key_5',6,NULL,'announcements','Public Announcement Content 3',NULL,'Public Announcement Content 3\n','a:2:{i:0;a:1:{i:0;s:36:\"<p>Public Announcement Content 3</p>\";}i:1;a:1:{i:0;s:36:\"<p>Public Announcement Content 3</p>\";}}',NULL,'/announcements/announcements/view/9/announcement_key_5',1,'2019-03-02 03:45:30',NULL,1,0,1,NULL,NULL,0,1,2,1,0,0,4,'2019-03-02 03:45:30',4,'2019-03-02 03:45:30'),(8,2,1,7,NULL,'calendar_event_key_1',1,NULL,'calendars','Repeat Plan 1','','\n','a:6:{i:0;a:1:{i:0;s:13:\"Repeat Plan 1\";}i:1;a:1:{i:0;s:0:\"\";}i:2;a:1:{i:0;s:13:\"Repeat Plan 1\";}i:3;a:1:{i:0;s:0:\"\";}i:4;a:1:{i:0;s:0:\"\";}i:5;a:1:{i:0;s:0:\"\";}}',NULL,'/calendars/calendar_plans/view/calendar_event_key_1',1,'2019-03-02 03:50:04',NULL,1,0,1,NULL,NULL,0,1,1,1,0,0,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(9,2,1,7,NULL,'calendar_event_key_1',1,NULL,'calendars','Repeat Plan 1','','\n','a:6:{i:0;a:1:{i:0;s:13:\"Repeat Plan 1\";}i:1;a:1:{i:0;s:0:\"\";}i:2;a:1:{i:0;s:13:\"Repeat Plan 1\";}i:3;a:1:{i:0;s:0:\"\";}i:4;a:1:{i:0;s:0:\"\";}i:5;a:1:{i:0;s:0:\"\";}}',NULL,'/calendars/calendar_plans/view/calendar_event_key_1',1,'2019-03-02 03:50:04',NULL,1,0,1,NULL,NULL,1,0,1,1,0,0,1,'2019-03-02 03:50:04',1,'2019-03-02 03:50:04'),(10,2,11,10,NULL,'announcement_key_6',7,NULL,'announcements','Community Room 2 Announcement Content 1',NULL,'Community Room 2 Announcement Content 1\n','a:2:{i:0;a:1:{i:0;s:46:\"<p>Community Room 2 Announcement Content 1</p>\";}i:1;a:1:{i:0;s:46:\"<p>Community Room 2 Announcement Content 1</p>\";}}',NULL,'/announcements/announcements/view/10/announcement_key_6',1,'2019-03-02 03:52:16',NULL,1,0,1,NULL,NULL,0,1,1,1,0,0,1,'2019-03-02 03:52:16',1,'2019-03-02 03:52:16'),(11,2,11,10,NULL,'announcement_key_6',7,NULL,'announcements','Community Room 2 Announcement Content 1',NULL,'Community Room 2 Announcement Content 1\n','a:2:{i:0;a:1:{i:0;s:46:\"<p>Community Room 2 Announcement Content 1</p>\";}i:1;a:1:{i:0;s:46:\"<p>Community Room 2 Announcement Content 1</p>\";}}',NULL,'/announcements/announcements/view/10/announcement_key_6',1,'2019-03-02 03:52:16',NULL,1,0,1,NULL,NULL,1,0,1,1,0,0,1,'2019-03-02 03:52:16',1,'2019-03-02 03:52:16'),(12,2,8,11,NULL,'announcement_key_7',8,NULL,'announcements','Community Room 1 Announcement Content 1',NULL,'Community Room 1 Announcement Content 1\n','a:2:{i:0;a:1:{i:0;s:47:\"<p>Community Room 1 Announcement Content 1</p>\";}i:1;a:1:{i:0;s:47:\"<p>Community Room 1 Announcement Content 1</p>\";}}',NULL,'/announcements/announcements/view/11/announcement_key_7',1,'2019-03-02 03:52:39',NULL,1,0,1,NULL,NULL,0,1,1,1,0,0,1,'2019-03-02 03:52:39',1,'2019-03-02 03:52:39'),(13,2,8,11,NULL,'announcement_key_7',8,NULL,'announcements','Community Room 1 Announcement Content 1',NULL,'Community Room 1 Announcement Content 1\n','a:2:{i:0;a:1:{i:0;s:47:\"<p>Community Room 1 Announcement Content 1</p>\";}i:1;a:1:{i:0;s:47:\"<p>Community Room 1 Announcement Content 1</p>\";}}',NULL,'/announcements/announcements/view/11/announcement_key_7',1,'2019-03-02 03:52:39',NULL,1,0,1,NULL,NULL,1,0,1,1,0,0,1,'2019-03-02 03:52:39',1,'2019-03-02 03:52:39'),(14,2,1,12,NULL,'announcement_key_8',9,NULL,'announcements','Top page Announcement Content',NULL,'Top page Announcement Content\n','a:2:{i:0;a:1:{i:0;s:36:\"<p>Top page Announcement Content</p>\";}i:1;a:1:{i:0;s:36:\"<p>Top page Announcement Content</p>\";}}',NULL,'/announcements/announcements/view/12/announcement_key_8',1,'2019-03-02 13:45:12',NULL,1,0,1,NULL,NULL,0,1,1,1,0,0,1,'2019-03-02 13:45:12',1,'2019-03-02 13:45:12'),(15,2,1,12,NULL,'announcement_key_8',9,NULL,'announcements','Top page Announcement Content',NULL,'Top page Announcement Content\n','a:2:{i:0;a:1:{i:0;s:36:\"<p>Top page Announcement Content</p>\";}i:1;a:1:{i:0;s:36:\"<p>Top page Announcement Content</p>\";}}',NULL,'/announcements/announcements/view/12/announcement_key_8',1,'2019-03-02 13:45:12',NULL,1,0,1,NULL,NULL,1,0,1,1,0,0,1,'2019-03-02 13:45:12',1,'2019-03-02 13:45:12');
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `upload_files`
--

DROP TABLE IF EXISTS `upload_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `upload_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `plugin_key` varchar(255) DEFAULT NULL,
  `content_key` varchar(255) DEFAULT NULL,
  `field_name` varchar(255) DEFAULT NULL,
  `original_name` varchar(255) NOT NULL COMMENT 'オリジナルファイル名',
  `path` varchar(255) NOT NULL COMMENT 'ファイルのパス',
  `real_file_name` varchar(255) NOT NULL COMMENT 'ファイル名',
  `extension` varchar(255) NOT NULL COMMENT '拡張子',
  `mimetype` varchar(255) NOT NULL COMMENT 'MIMEタイプ',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT 'ファイルサイズ',
  `download_count` int(11) DEFAULT '0',
  `total_download_count` int(11) DEFAULT '0',
  `room_id` int(11) DEFAULT NULL,
  `block_key` varchar(255) DEFAULT NULL,
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `field_name` (`field_name`),
  KEY `content_key` (`content_key`,`field_name`,`plugin_key`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `upload_files`
--

LOCK TABLES `upload_files` WRITE;
/*!40000 ALTER TABLE `upload_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `upload_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `upload_files_contents`
--

DROP TABLE IF EXISTS `upload_files_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `upload_files_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_key` varchar(255) NOT NULL,
  `content_id` int(45) NOT NULL,
  `upload_file_id` int(45) NOT NULL,
  `content_is_active` tinyint(1) DEFAULT NULL,
  `content_is_latest` tinyint(1) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `plugin_key` (`plugin_key`,`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `upload_files_contents`
--

LOCK TABLES `upload_files_contents` WRITE;
/*!40000 ALTER TABLE `upload_files_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `upload_files_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_attribute_choices`
--

DROP TABLE IF EXISTS `user_attribute_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_attribute_choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `user_attribute_id` int(11) DEFAULT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `weight` int(11) DEFAULT NULL COMMENT '表示順',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_attribute_id` (`user_attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_attribute_choices`
--

LOCK TABLES `user_attribute_choices` WRITE;
/*!40000 ALTER TABLE `user_attribute_choices` DISABLE KEYS */;
INSERT INTO `user_attribute_choices` VALUES (1,2,1,1,0,8,'sex_no_setting','設定しない','no_setting',1,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(2,2,1,1,0,8,'sex_male','男','male',2,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(3,2,1,1,0,8,'sex_female','女','female',3,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(4,1,0,1,0,28,'sex_no_setting','No setting','no_setting',1,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(5,1,0,1,0,28,'sex_male','Male','male',2,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(6,1,0,1,0,28,'sex_female','Female','female',3,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(7,2,1,1,0,11,'status_1','利用可能','1',1,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(8,2,1,1,0,11,'status_0','利用不可','0',2,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(9,2,1,1,0,11,'status_2','承認待ち','2',3,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(10,2,1,1,0,11,'status_3','承認済み','3',4,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(11,1,0,1,0,31,'status_1','Active','1',1,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(12,1,0,1,0,31,'status_0','Nonactive','0',2,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(13,1,0,1,0,31,'status_2','Waiting','2',3,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(14,1,0,1,0,31,'status_3','Not yet logged-in','3',4,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(15,2,1,1,0,41,'language_0','自動','auto',1,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(16,2,1,1,0,41,'language_1','英語','en',2,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(17,2,1,1,0,41,'language_2','日本語','ja',3,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(18,1,0,1,0,42,'language_0','Auto','auto',1,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(19,1,0,1,0,42,'language_1','English','en',2,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(20,1,0,1,0,42,'language_2','Japanese','ja',3,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47');
/*!40000 ALTER TABLE `user_attribute_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_attribute_layouts`
--

DROP TABLE IF EXISTS `user_attribute_layouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_attribute_layouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Row number',
  `col` int(4) NOT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_attribute_layouts`
--

LOCK TABLES `user_attribute_layouts` WRITE;
/*!40000 ALTER TABLE `user_attribute_layouts` DISABLE KEYS */;
INSERT INTO `user_attribute_layouts` VALUES (1,2,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(2,1,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(3,1,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47');
/*!40000 ALTER TABLE `user_attribute_layouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_attribute_settings`
--

DROP TABLE IF EXISTS `user_attribute_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_attribute_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_attribute_key` varchar(255) NOT NULL,
  `data_type_key` varchar(255) NOT NULL DEFAULT 'text',
  `row` int(4) NOT NULL,
  `col` int(4) NOT NULL,
  `weight` int(11) DEFAULT NULL COMMENT '表示順',
  `required` tinyint(1) DEFAULT '0' COMMENT '「必須項目とする」の有無',
  `display` tinyint(1) DEFAULT '1' COMMENT '表示の有無',
  `only_administrator_readable` tinyint(1) DEFAULT '0' COMMENT '「本人も読めない（管理者のみ読める）」の有無',
  `only_administrator_editable` tinyint(1) DEFAULT '0' COMMENT '「本人も書けない（管理者のみ書ける）」の有無',
  `is_system` tinyint(1) DEFAULT '0' COMMENT 'システム項目かどうか',
  `display_label` tinyint(1) DEFAULT '1' COMMENT '「項目名を表示する」の有無',
  `display_search_result` tinyint(1) DEFAULT '0' COMMENT '「検索結果リストに表示する（デフォルト）」の有無。画面からの設定は不可',
  `self_public_setting` tinyint(1) DEFAULT '0' COMMENT '「各自で公開・非公開の設定可能にする」の有無',
  `self_email_setting` tinyint(1) DEFAULT '0' COMMENT '「各自でメールの受信可否を設定可能にする」の有無',
  `is_multilingualization` tinyint(1) DEFAULT '1' COMMENT '「多言語にする」の有無',
  `auto_regist_display` tinyint(1) DEFAULT NULL COMMENT '自動登録での表示有無',
  `auto_regist_weight` int(11) DEFAULT '9999' COMMENT '自動登録での表示順',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_attribute_key` (`user_attribute_key`),
  KEY `data_type_key` (`data_type_key`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_attribute_settings`
--

LOCK TABLES `user_attribute_settings` WRITE;
/*!40000 ALTER TABLE `user_attribute_settings` DISABLE KEYS */;
INSERT INTO `user_attribute_settings` VALUES (1,'avatar','img',1,1,1,0,1,0,0,1,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:46',NULL,'2019-03-02 03:14:46'),(2,'username','text',1,2,1,1,1,1,1,1,1,0,0,0,0,NULL,1,NULL,'2019-03-02 03:14:46',NULL,'2019-03-02 03:14:46'),(3,'password','password',1,2,2,1,1,1,0,1,1,0,0,0,0,NULL,2,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(4,'handlename','text',1,2,3,1,1,0,0,1,1,1,0,0,0,NULL,3,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(5,'name','text',1,2,4,0,1,0,0,0,1,1,0,0,1,1,4,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(6,'email','email',1,1,2,0,1,0,0,0,1,0,0,0,0,1,5,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(7,'moblie_mail','email',1,1,3,0,1,0,0,0,1,0,1,1,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(8,'sex','radio',1,1,4,0,0,1,1,0,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(9,'timezone','timezone',1,1,6,0,1,0,0,1,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(10,'role_key','select',1,1,7,1,0,1,1,1,1,1,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(11,'status','select',1,1,8,1,0,1,1,1,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(12,'created','label',1,2,8,0,0,1,1,1,1,1,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(13,'created_user','label',1,2,9,0,0,1,1,1,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(14,'modified','label',1,2,10,0,0,1,1,1,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(15,'modified_user','label',1,2,11,0,0,1,1,1,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(16,'password_modified','label',1,2,5,0,1,0,1,1,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(17,'last_login','label',1,2,6,0,1,0,1,1,1,1,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(18,'previous_login','label',1,2,7,0,1,0,1,1,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(19,'profile','textarea',2,1,1,0,1,0,0,0,1,0,0,0,1,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(20,'search_keywords','text',2,1,2,0,0,1,1,0,1,0,0,0,1,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(21,'language','select',1,1,5,0,1,0,0,1,1,0,0,0,0,NULL,9999,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47');
/*!40000 ALTER TABLE `user_attribute_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_attributes`
--

DROP TABLE IF EXISTS `user_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(6) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_attributes`
--

LOCK TABLES `user_attributes` WRITE;
/*!40000 ALTER TABLE `user_attributes` DISABLE KEYS */;
INSERT INTO `user_attributes` VALUES (1,2,1,1,0,'avatar','アバター','指定しない場合、ハンドルから自動的に生成します。',NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(2,2,1,1,0,'username','ログインID','4文字以上の英数字または記号を入力してください。',NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(3,2,1,1,0,'password','パスワード','4文字以上の英数字または記号を入力してください。',NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(4,2,1,1,0,'handlename','ハンドル',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(5,2,1,1,0,'name','氏名',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(6,2,1,1,0,'email','eメール',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(7,2,1,1,0,'moblie_mail','携帯メール',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(8,2,1,1,0,'sex','性別',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(9,2,1,1,0,'timezone','タイムゾーン',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(10,2,1,1,0,'role_key','権限',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(11,2,1,1,0,'status','状態',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(12,2,1,1,0,'created','作成日時',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(13,2,1,1,0,'created_user','作成者',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(14,2,1,1,0,'modified','更新日時',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(15,2,1,1,0,'modified_user','更新者',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(16,2,1,1,0,'password_modified','パスワード変更日時',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(17,2,1,1,0,'last_login','最終ログイン日時',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(18,2,1,1,0,'previous_login','前回ログイン日時',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(19,2,1,1,0,'profile','プロフィール',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(20,2,1,1,0,'search_keywords','検索キーワード',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(21,1,0,1,0,'avatar','Avatar','If you do not specify, automatically generates from the handle.',NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(22,1,0,1,0,'username','ID','Please choose at least 4 characters string. No space or special character is allowed.',NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(23,1,0,1,0,'password','Password','Please choose at least 4 characters string. No space or special character is allowed.',NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(24,1,0,1,0,'handlename','Handle',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(25,1,0,1,0,'name','Name',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(26,1,0,1,0,'email','E-mail',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(27,1,0,1,0,'moblie_mail','Mobile mail',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(28,1,0,1,0,'sex','Sex',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(29,1,0,1,0,'timezone','TimeZone',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(30,1,0,1,0,'role_key','Authority',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(31,1,0,1,0,'status','Status',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(32,1,0,1,0,'created','Created',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(33,1,0,1,0,'created_user','Creator',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(34,1,0,1,0,'modified','Last modified',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(35,1,0,1,0,'modified_user','Updater',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(36,1,0,1,0,'password_modified','Password has been changed',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(37,1,0,1,0,'last_login','Last login',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(38,1,0,1,0,'previous_login','Previous login',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(39,1,0,1,0,'profile','Profile',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(40,1,0,1,0,'search_keywords','Keywords',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(41,2,1,1,0,'language','言語',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47'),(42,1,0,1,0,'language','Language',NULL,NULL,'2019-03-02 03:14:47',NULL,'2019-03-02 03:14:47');
/*!40000 ALTER TABLE `user_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_attributes_roles`
--

DROP TABLE IF EXISTS `user_attributes_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_attributes_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_key` varchar(255) NOT NULL,
  `user_attribute_key` varchar(255) NOT NULL,
  `self_readable` tinyint(1) DEFAULT NULL,
  `self_editable` tinyint(1) DEFAULT NULL,
  `other_readable` tinyint(1) DEFAULT NULL,
  `other_editable` tinyint(1) DEFAULT NULL,
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_attribute_key` (`user_attribute_key`,`role_key`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_attributes_roles`
--

LOCK TABLES `user_attributes_roles` WRITE;
/*!40000 ALTER TABLE `user_attributes_roles` DISABLE KEYS */;
INSERT INTO `user_attributes_roles` VALUES (1,'system_administrator','avatar',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(2,'system_administrator','username',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(3,'system_administrator','password',0,1,0,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(4,'system_administrator','handlename',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(5,'system_administrator','name',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(6,'system_administrator','email',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(7,'system_administrator','moblie_mail',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(8,'system_administrator','sex',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(9,'system_administrator','timezone',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(10,'system_administrator','role_key',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(11,'system_administrator','status',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(12,'system_administrator','created',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(13,'system_administrator','created_user',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(14,'system_administrator','modified',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(15,'system_administrator','modified_user',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(16,'system_administrator','password_modified',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(17,'system_administrator','last_login',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(18,'system_administrator','previous_login',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(19,'system_administrator','profile',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(20,'system_administrator','search_keywords',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(21,'administrator','avatar',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(22,'administrator','username',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(23,'administrator','password',0,1,0,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(24,'administrator','handlename',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(25,'administrator','name',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(26,'administrator','email',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(27,'administrator','moblie_mail',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(28,'administrator','sex',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(29,'administrator','timezone',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(30,'administrator','role_key',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(31,'administrator','status',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(32,'administrator','created',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(33,'administrator','created_user',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(34,'administrator','modified',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(35,'administrator','modified_user',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(36,'administrator','password_modified',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(37,'administrator','last_login',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(38,'administrator','previous_login',1,0,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(39,'administrator','profile',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(40,'administrator','search_keywords',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(41,'common_user','avatar',1,1,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(42,'common_user','username',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(43,'common_user','password',0,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(44,'common_user','handlename',1,1,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(45,'common_user','name',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(46,'common_user','email',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(47,'common_user','moblie_mail',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(48,'common_user','sex',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(49,'common_user','timezone',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(50,'common_user','role_key',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(51,'common_user','status',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(52,'common_user','created',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(53,'common_user','created_user',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(54,'common_user','modified',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(55,'common_user','modified_user',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(56,'common_user','password_modified',1,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(57,'common_user','last_login',1,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(58,'common_user','previous_login',1,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(59,'common_user','profile',1,1,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(60,'common_user','search_keywords',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(61,'system_administrator','language',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(62,'administrator','language',1,1,1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(63,'common_user','language',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(64,'guest_user','avatar',1,1,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(65,'guest_user','username',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(66,'guest_user','password',0,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(67,'guest_user','handlename',1,1,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(68,'guest_user','name',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(69,'guest_user','email',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(70,'guest_user','moblie_mail',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(71,'guest_user','sex',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(72,'guest_user','timezone',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(73,'guest_user','role_key',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(74,'guest_user','status',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(75,'guest_user','created',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(76,'guest_user','created_user',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(77,'guest_user','modified',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(78,'guest_user','modified_user',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(79,'guest_user','password_modified',1,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(80,'guest_user','last_login',1,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(81,'guest_user','previous_login',1,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(82,'guest_user','profile',1,1,1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(83,'guest_user','search_keywords',0,0,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(84,'guest_user','language',1,1,0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48');
/*!40000 ALTER TABLE `user_attributes_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_settings`
--

DROP TABLE IF EXISTS `user_role_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_key` varchar(255) NOT NULL,
  `origin_role_key` varchar(255) NOT NULL,
  `use_private_room` tinyint(1) DEFAULT NULL COMMENT 'プライベートルームの使用有無',
  `is_site_plugins` tinyint(1) DEFAULT NULL COMMENT 'サイト運営プラグインの有無',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_key` (`role_key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_settings`
--

LOCK TABLES `user_role_settings` WRITE;
/*!40000 ALTER TABLE `user_role_settings` DISABLE KEYS */;
INSERT INTO `user_role_settings` VALUES (1,'system_administrator','system_administrator',1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(2,'administrator','administrator',1,1,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(3,'common_user','common_user',1,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48'),(4,'guest_user','common_user',0,0,NULL,'2019-03-02 03:14:48',NULL,'2019-03-02 03:14:48');
/*!40000 ALTER TABLE `user_role_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_select_counts`
--

DROP TABLE IF EXISTS `user_select_counts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_select_counts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `select_count` int(11) NOT NULL DEFAULT '0',
  `created_user` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_user` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_select_counts`
--

LOCK TABLES `user_select_counts` WRITE;
/*!40000 ALTER TABLE `user_select_counts` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_select_counts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'ログインID',
  `password` varchar(255) DEFAULT NULL COMMENT 'パスワード',
  `key` varchar(255) DEFAULT NULL COMMENT 'リンク識別子',
  `activate_key` varchar(255) DEFAULT NULL COMMENT 'アクティベートキー',
  `activated` varchar(255) DEFAULT NULL COMMENT 'アクティベート日時',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_avatar_public` tinyint(1) NOT NULL DEFAULT '0',
  `is_avatar_auto_created` tinyint(1) NOT NULL DEFAULT '1',
  `handlename` varchar(255) DEFAULT NULL COMMENT 'ハンドル',
  `is_handlename_public` tinyint(1) NOT NULL DEFAULT '0',
  `is_name_public` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL COMMENT 'eメール',
  `is_email_public` tinyint(1) NOT NULL DEFAULT '0',
  `is_email_reception` tinyint(1) NOT NULL DEFAULT '1',
  `moblie_mail` varchar(255) DEFAULT NULL COMMENT '携帯メール',
  `is_moblie_mail_public` tinyint(1) NOT NULL DEFAULT '0',
  `is_moblie_mail_reception` tinyint(1) NOT NULL DEFAULT '1',
  `sex` varchar(255) DEFAULT NULL COMMENT '性別',
  `is_sex_public` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(255) DEFAULT NULL,
  `is_language_public` tinyint(1) NOT NULL DEFAULT '0',
  `timezone` varchar(255) DEFAULT NULL COMMENT 'タイムゾーン',
  `is_timezone_public` tinyint(1) NOT NULL DEFAULT '0',
  `role_key` varchar(255) NOT NULL COMMENT '権限',
  `is_role_key_public` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) DEFAULT NULL COMMENT '状態',
  `is_status_public` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `is_created_public` tinyint(1) NOT NULL DEFAULT '0',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `is_created_user_public` tinyint(1) NOT NULL DEFAULT '0',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  `is_modified_public` tinyint(1) NOT NULL DEFAULT '0',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `is_modified_user_public` tinyint(1) NOT NULL DEFAULT '0',
  `password_modified` datetime DEFAULT NULL COMMENT 'パスワード変更日時',
  `is_password_modified_public` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL COMMENT '最終ログイン日時',
  `is_last_login_public` tinyint(1) NOT NULL DEFAULT '0',
  `previous_login` datetime DEFAULT NULL COMMENT '前回ログイン日時',
  `is_previous_login_public` tinyint(1) NOT NULL DEFAULT '0',
  `is_profile_public` tinyint(1) NOT NULL DEFAULT '0',
  `is_search_keywords_public` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `userlist` (`is_deleted`,`id`),
  KEY `handlename` (`handlename`,`is_deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','bf52eec7654a236513801b3d19c0ab557c36f3f29c47f64f82f5a73ba1c9f39cdbd62c040a2b619d3922560eace8973a7588605b33ea19bd13390e6e1f769ef8','user_key_1',NULL,NULL,0,0,1,'System administrator',0,0,NULL,0,1,NULL,0,1,NULL,0,NULL,0,'Asia/Tokyo',0,'system_administrator',0,'1',0,'2019-03-02 03:15:10',0,0,0,'2019-03-02 03:15:10',0,0,0,'2019-03-02 03:15:10',0,'2019-03-03 09:45:02',0,'2019-03-02 13:45:59',0,0,0),(2,'general_user_1','bf52eec7654a236513801b3d19c0ab557c36f3f29c47f64f82f5a73ba1c9f39cdbd62c040a2b619d3922560eace8973a7588605b33ea19bd13390e6e1f769ef8','user_key_2',NULL,NULL,0,0,1,'General user 1',0,0,'',0,1,'',0,1,'',0,'auto',0,'Asia/Tokyo',0,'common_user',0,'1',0,'2019-03-02 03:18:08',0,1,0,'2019-03-02 03:18:08',0,1,0,'2019-03-02 03:18:08',0,'2019-03-02 03:39:42',0,NULL,0,0,0),(3,'general_user_2','bf52eec7654a236513801b3d19c0ab557c36f3f29c47f64f82f5a73ba1c9f39cdbd62c040a2b619d3922560eace8973a7588605b33ea19bd13390e6e1f769ef8','user_key_3',NULL,NULL,0,0,1,'General user 2',0,0,'',0,1,'',0,1,'',0,'auto',0,'Asia/Tokyo',0,'common_user',0,'1',0,'2019-03-02 03:19:02',0,1,0,'2019-03-02 03:19:02',0,1,0,'2019-03-02 03:19:02',0,NULL,0,NULL,0,0,0),(4,'general_user_3','bf52eec7654a236513801b3d19c0ab557c36f3f29c47f64f82f5a73ba1c9f39cdbd62c040a2b619d3922560eace8973a7588605b33ea19bd13390e6e1f769ef8','user_key_4',NULL,NULL,0,0,1,'General user 3',0,0,'',0,1,'',0,1,'',0,'auto',0,'Asia/Tokyo',0,'common_user',0,'1',0,'2019-03-02 03:41:35',0,1,0,'2019-03-02 03:41:35',0,1,0,'2019-03-02 03:41:35',0,'2019-03-02 03:45:09',0,'2019-03-02 03:43:19',0,0,0),(5,'guest_user_1','bf52eec7654a236513801b3d19c0ab557c36f3f29c47f64f82f5a73ba1c9f39cdbd62c040a2b619d3922560eace8973a7588605b33ea19bd13390e6e1f769ef8','user_key_5',NULL,NULL,0,0,1,'Guest user 1',0,0,'',0,1,'',0,1,'',0,'auto',0,'Asia/Tokyo',0,'guest_user',0,'1',0,'2019-03-02 09:39:18',0,1,0,'2019-03-02 09:39:18',0,1,0,'2019-03-02 09:39:18',0,NULL,0,NULL,0,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_languages`
--

DROP TABLE IF EXISTS `users_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `language_id` int(6) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '氏名',
  `profile` text COMMENT 'プロフィール',
  `search_keywords` varchar(255) DEFAULT NULL COMMENT '検索キーワード',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_languages`
--

LOCK TABLES `users_languages` WRITE;
/*!40000 ALTER TABLE `users_languages` DISABLE KEYS */;
INSERT INTO `users_languages` VALUES (1,1,2,'System administrator',NULL,NULL),(2,2,2,'','',''),(3,3,2,'','',''),(4,4,2,'','',''),(5,5,2,'','','');
/*!40000 ALTER TABLE `users_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_frame_settings`
--

DROP TABLE IF EXISTS `video_frame_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_frame_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `frame_key` varchar(255) NOT NULL COMMENT 'フレームKey',
  `display_order` varchar(11) DEFAULT 'new' COMMENT '表示順 new:新着順、title:タイトル順、play:再生回数順、like:評価順',
  `display_number` int(11) NOT NULL DEFAULT '10' COMMENT '表示件数',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `frame_key` (`frame_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_frame_settings`
--

LOCK TABLES `video_frame_settings` WRITE;
/*!40000 ALTER TABLE `video_frame_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_frame_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_settings`
--

DROP TABLE IF EXISTS `video_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `block_key` varchar(255) NOT NULL COMMENT 'ブロックKey',
  `total_size` float NOT NULL DEFAULT '0',
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `fk_video_settings_blocks1_idx` (`block_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_settings`
--

LOCK TABLES `video_settings` WRITE;
/*!40000 ALTER TABLE `video_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `key` varchar(255) NOT NULL COMMENT 'キー',
  `language_id` int(6) NOT NULL,
  `is_origin` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'オリジナルかどうか',
  `is_translation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '翻訳したかどうか',
  `is_original_copy` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'オリジナルのコピー。言語を新たに追加したときに使用する',
  `block_id` int(11) NOT NULL COMMENT 'ブロックID',
  `category_id` int(11) NOT NULL COMMENT 'カテゴリーID',
  `title_icon` varchar(255) DEFAULT NULL,
  `title` text COMMENT 'タイトル',
  `video_time` int(11) NOT NULL DEFAULT '0' COMMENT '動画時間',
  `play_number` int(11) NOT NULL DEFAULT '0' COMMENT '再生回数',
  `description` text COMMENT '説明',
  `status` int(4) DEFAULT NULL COMMENT '公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し',
  `is_active` tinyint(1) NOT NULL,
  `is_latest` tinyint(1) NOT NULL,
  `created_user` int(11) DEFAULT NULL COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT NULL COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow_comments`
--

DROP TABLE IF EXISTS `workflow_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `plugin_key` varchar(255) NOT NULL COMMENT 'プラグインKey',
  `block_key` varchar(255) NOT NULL COMMENT 'ブロックKey',
  `content_key` varchar(255) NOT NULL COMMENT '各プラグインのコンテンツKey',
  `comment` text NOT NULL COMMENT 'コメント',
  `created_user` int(11) DEFAULT '0' COMMENT '作成者',
  `created` datetime DEFAULT NULL COMMENT '作成日時',
  `modified_user` int(11) DEFAULT '0' COMMENT '更新者',
  `modified` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `content_key` (`content_key`,`plugin_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workflow_comments`
--

LOCK TABLES `workflow_comments` WRITE;
/*!40000 ALTER TABLE `workflow_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `workflow_comments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-03 18:53:39
