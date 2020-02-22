/*
SQLyog Community v12.09 (64 bit)
MySQL - 5.1.50-community-log : Database - trafalgar
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`trafalgar` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `trafalgar`;

/*Table structure for table `advertisement` */

DROP TABLE IF EXISTS `advertisement`;

CREATE TABLE `advertisement` (
  `id` int(11) NOT NULL,
  `banner` tinytext NOT NULL,
  `title` tinytext NOT NULL,
  `details` mediumtext,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `destination` */

DROP TABLE IF EXISTS `destination`;

CREATE TABLE `destination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `sub_title` tinytext,
  `body` longtext NOT NULL,
  `image` tinytext NOT NULL,
  `phone` tinytext,
  `enabled` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `device` */

DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `device_id` longblob NOT NULL,
  `dated_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `news_article` */

DROP TABLE IF EXISTS `news_article`;

CREATE TABLE `news_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `body` longtext NOT NULL,
  `image` tinytext,
  `enabled` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

/*Table structure for table `specials` */

DROP TABLE IF EXISTS `specials`;

CREATE TABLE `specials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `sub_title` tinytext,
  `body` longtext NOT NULL,
  `phone` tinytext,
  `image` tinytext NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Table structure for table `view_destination_api_data` */

DROP TABLE IF EXISTS `view_destination_api_data`;

/*!50001 DROP VIEW IF EXISTS `view_destination_api_data` */;
/*!50001 DROP TABLE IF EXISTS `view_destination_api_data` */;

/*!50001 CREATE TABLE  `view_destination_api_data`(
 `id` int(11) ,
 `title` tinytext ,
 `subtitle` tinytext ,
 `phone` tinytext ,
 `body` longtext ,
 `image` tinytext 
)*/;

/*Table structure for table `view_get_location` */

DROP TABLE IF EXISTS `view_get_location`;

/*!50001 DROP VIEW IF EXISTS `view_get_location` */;
/*!50001 DROP TABLE IF EXISTS `view_get_location` */;

/*!50001 CREATE TABLE  `view_get_location`(
 `id` int(11) ,
 `title` tinytext ,
 `sub_title` tinytext ,
 `phone` tinytext ,
 `body` longtext ,
 `image` tinytext ,
 `enabled` varchar(3) ,
 `date_added` datetime 
)*/;

/*Table structure for table `view_get_news` */

DROP TABLE IF EXISTS `view_get_news`;

/*!50001 DROP VIEW IF EXISTS `view_get_news` */;
/*!50001 DROP TABLE IF EXISTS `view_get_news` */;

/*!50001 CREATE TABLE  `view_get_news`(
 `id` int(11) ,
 `title` tinytext ,
 `body` longtext ,
 `image` tinytext ,
 `enabled` varchar(3) ,
 `date_added` datetime 
)*/;

/*Table structure for table `view_get_special` */

DROP TABLE IF EXISTS `view_get_special`;

/*!50001 DROP VIEW IF EXISTS `view_get_special` */;
/*!50001 DROP TABLE IF EXISTS `view_get_special` */;

/*!50001 CREATE TABLE  `view_get_special`(
 `id` int(11) ,
 `title` tinytext ,
 `sub_title` tinytext ,
 `phone` tinytext ,
 `body` longtext ,
 `image` tinytext ,
 `enabled` varchar(3) ,
 `date_added` datetime 
)*/;

/*Table structure for table `view_home_page_summary` */

DROP TABLE IF EXISTS `view_home_page_summary`;

/*!50001 DROP VIEW IF EXISTS `view_home_page_summary` */;
/*!50001 DROP TABLE IF EXISTS `view_home_page_summary` */;

/*!50001 CREATE TABLE  `view_home_page_summary`(
 `des_count` bigint(21) ,
 `news_count` bigint(21) ,
 `spec_count` bigint(21) ,
 `ad_count` bigint(21) 
)*/;

/*Table structure for table `view_news_api_data` */

DROP TABLE IF EXISTS `view_news_api_data`;

/*!50001 DROP VIEW IF EXISTS `view_news_api_data` */;
/*!50001 DROP TABLE IF EXISTS `view_news_api_data` */;

/*!50001 CREATE TABLE  `view_news_api_data`(
 `id` int(11) ,
 `title` tinytext ,
 `body` longtext ,
 `image` varchar(255) ,
 `date` varchar(74) 
)*/;

/*Table structure for table `view_specials_api_data` */

DROP TABLE IF EXISTS `view_specials_api_data`;

/*!50001 DROP VIEW IF EXISTS `view_specials_api_data` */;
/*!50001 DROP TABLE IF EXISTS `view_specials_api_data` */;

/*!50001 CREATE TABLE  `view_specials_api_data`(
 `id` int(11) ,
 `title` tinytext ,
 `subtitle` tinytext ,
 `phone` tinytext ,
 `body` longtext ,
 `image` tinytext 
)*/;

/*View structure for view view_destination_api_data */

/*!50001 DROP TABLE IF EXISTS `view_destination_api_data` */;
/*!50001 DROP VIEW IF EXISTS `view_destination_api_data` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_destination_api_data` AS (select `destination`.`id` AS `id`,`destination`.`title` AS `title`,`destination`.`sub_title` AS `subtitle`,`destination`.`phone` AS `phone`,`destination`.`body` AS `body`,`destination`.`image` AS `image` from `destination` order by `destination`.`date_added` desc) */;

/*View structure for view view_get_location */

/*!50001 DROP TABLE IF EXISTS `view_get_location` */;
/*!50001 DROP VIEW IF EXISTS `view_get_location` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_get_location` AS (select `destination`.`id` AS `id`,`destination`.`title` AS `title`,`destination`.`sub_title` AS `sub_title`,`destination`.`phone` AS `phone`,`destination`.`body` AS `body`,`destination`.`image` AS `image`,if((`destination`.`enabled` = '1'),'Yes','No') AS `enabled`,`destination`.`date_added` AS `date_added` from `destination` order by `destination`.`date_added` desc) */;

/*View structure for view view_get_news */

/*!50001 DROP TABLE IF EXISTS `view_get_news` */;
/*!50001 DROP VIEW IF EXISTS `view_get_news` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_get_news` AS select `news_article`.`id` AS `id`,`news_article`.`title` AS `title`,`news_article`.`body` AS `body`,`news_article`.`image` AS `image`,if((`news_article`.`enabled` = '1'),'Yes','No') AS `enabled`,`news_article`.`date_added` AS `date_added` from `news_article` order by `news_article`.`date_added` desc */;

/*View structure for view view_get_special */

/*!50001 DROP TABLE IF EXISTS `view_get_special` */;
/*!50001 DROP VIEW IF EXISTS `view_get_special` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_get_special` AS (select `specials`.`id` AS `id`,`specials`.`title` AS `title`,`specials`.`sub_title` AS `sub_title`,`specials`.`phone` AS `phone`,`specials`.`body` AS `body`,`specials`.`image` AS `image`,if((`specials`.`enabled` = '1'),'Yes','No') AS `enabled`,`specials`.`date_added` AS `date_added` from `specials` order by `specials`.`date_added` desc) */;

/*View structure for view view_home_page_summary */

/*!50001 DROP TABLE IF EXISTS `view_home_page_summary` */;
/*!50001 DROP VIEW IF EXISTS `view_home_page_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_home_page_summary` AS (select count(0) AS `des_count`,(select count(0) from `news_article`) AS `news_count`,(select count(0) from `specials`) AS `spec_count`,(select count(0) from `advertisement`) AS `ad_count` from `destination`) */;

/*View structure for view view_news_api_data */

/*!50001 DROP TABLE IF EXISTS `view_news_api_data` */;
/*!50001 DROP VIEW IF EXISTS `view_news_api_data` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_news_api_data` AS (select `a`.`id` AS `id`,`a`.`title` AS `title`,`a`.`body` AS `body`,if(isnull(`a`.`image`),'',trim(`a`.`image`)) AS `image`,date_format(`a`.`date_added`,'%M %d, %Y.') AS `date` from `news_article` `a`) */;

/*View structure for view view_specials_api_data */

/*!50001 DROP TABLE IF EXISTS `view_specials_api_data` */;
/*!50001 DROP VIEW IF EXISTS `view_specials_api_data` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_specials_api_data` AS (select `specials`.`id` AS `id`,`specials`.`title` AS `title`,`specials`.`sub_title` AS `subtitle`,`specials`.`phone` AS `phone`,`specials`.`body` AS `body`,`specials`.`image` AS `image` from `specials` order by `specials`.`date_added` desc) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
