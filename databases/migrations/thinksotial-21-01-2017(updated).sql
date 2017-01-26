/*
SQLyog Trial v12.15 (64 bit)
MySQL - 5.5.44 : Database - ts
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `albums` */

DROP TABLE IF EXISTS `albums`;

CREATE TABLE `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `albums` */

insert  into `albums`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'family','2017-01-26 14:17:50',NULL),
(2,'I','2017-01-26 14:17:50',NULL),
(3,'friends','2017-01-26 14:17:50',NULL),
(4,'pets','2017-01-26 14:17:50',NULL),
(5,'car','2017-01-26 14:17:50',NULL);

/*Table structure for table `albums_groups` */

DROP TABLE IF EXISTS `albums_groups`;

CREATE TABLE `albums_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `groups_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `album_id` (`album_id`),
  KEY `fk_albums_users_albums1_idx` (`album_id`),
  KEY `fk_albums_groups_groups1_idx` (`groups_id`),
  CONSTRAINT `fk_albums_groups_groups1` FOREIGN KEY (`groups_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_albums_users_albums10` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `albums_groups` */

/*Table structure for table `albums_photos` */

DROP TABLE IF EXISTS `albums_photos`;

CREATE TABLE `albums_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`album_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `file_name` (`file_name`),
  KEY `fk_albums_photos_albums1_idx` (`album_id`),
  CONSTRAINT `fk_albums_photos_albums1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `albums_photos` */

/*Table structure for table `albums_photos_comments` */

DROP TABLE IF EXISTS `albums_photos_comments`;

CREATE TABLE `albums_photos_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `albums_photos_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `comment_id` (`comment_id`),
  KEY `fk_news_comments_comments1_idx` (`comment_id`),
  KEY `fk_albums_photos_comments_albums_photos1_idx` (`albums_photos_id`),
  CONSTRAINT `fk_albums_photos_comments_albums_photos1` FOREIGN KEY (`albums_photos_id`) REFERENCES `albums_photos` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_news_comments_comments10` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `albums_photos_comments` */

/*Table structure for table `albums_users` */

DROP TABLE IF EXISTS `albums_users`;

CREATE TABLE `albums_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `album_id` (`album_id`),
  KEY `fk_albums_users_users1_idx` (`user_id`),
  KEY `fk_albums_users_albums1_idx` (`album_id`),
  CONSTRAINT `fk_albums_users_albums1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_albums_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `albums_users` */

insert  into `albums_users`(`id`,`user_id`,`album_id`,`created_at`,`updated_at`) values 
(1,1,1,'2017-01-26 14:17:54',NULL),
(2,1,3,'2017-01-26 14:17:54',NULL),
(3,1,5,'2017-01-26 14:17:54',NULL),
(4,2,2,'2017-01-26 14:17:54',NULL),
(5,2,4,'2017-01-26 14:17:54',NULL);

/*Table structure for table `cities` */

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country_id_name` (`country_id`,`name`),
  KEY `fk_cities_countries1_idx` (`country_id`),
  CONSTRAINT `fk_cities_country_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `cities` */

insert  into `cities`(`id`,`country_id`,`name`,`created_at`,`updated_at`) values 
(1,1,'Киев','2017-01-26 14:17:55',NULL),
(2,1,'Харьков','2017-01-26 14:17:55',NULL),
(3,2,'Москва','2017-01-26 14:17:55',NULL);

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `news_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_comments_users1_idx` (`user_id`),
  KEY `fk_comments_news` (`news_id`),
  CONSTRAINT `fk_comments_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  CONSTRAINT `fk_comments_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `comments` */

insert  into `comments`(`id`,`user_id`,`text`,`news_id`,`created_at`,`updated_at`,`deleted`) values 
(3,10,'first commit',13,'2017-01-26 21:30:30',NULL,0),
(4,10,' commit',12,'2017-01-26 21:31:13',NULL,0);

/*Table structure for table `complaints` */

DROP TABLE IF EXISTS `complaints`;

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `status` enum('considered','unconsidered') NOT NULL DEFAULT 'unconsidered',
  `published` timestamp NULL DEFAULT NULL,
  `complaints_types_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_comments_users1_idx` (`user_id`),
  KEY `fk_complaints_complaints_types1_idx` (`complaints_types_id`),
  CONSTRAINT `fk_comments_users10` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_complaints_complaints_types1` FOREIGN KEY (`complaints_types_id`) REFERENCES `complaints_types` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `complaints` */

/*Table structure for table `complaints_types` */

DROP TABLE IF EXISTS `complaints_types`;

CREATE TABLE `complaints_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `table_name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_name_UNIQUE` (`table_name`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `complaints_types` */

/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `countries` */

insert  into `countries`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Украина','2017-01-26 14:18:00',NULL),
(2,'Россия','2017-01-26 14:18:00',NULL);

/*Table structure for table `friends` */

DROP TABLE IF EXISTS `friends`;

CREATE TABLE `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_sender` int(11) NOT NULL,
  `user_receiver` int(11) NOT NULL,
  `status` enum('applied','unapplied','declined') NOT NULL DEFAULT 'unapplied',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sender_receiver` (`user_sender`,`user_receiver`),
  KEY `fk_table1_users1_idx` (`user_sender`),
  KEY `fk_table1_users2_idx` (`user_receiver`),
  CONSTRAINT `fk_table1_users1` FOREIGN KEY (`user_sender`) REFERENCES `users` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_table1_users2` FOREIGN KEY (`user_receiver`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `friends` */

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` tinytext NOT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idusers_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `groups` */

/*Table structure for table `groups_avatars` */

DROP TABLE IF EXISTS `groups_avatars`;

CREATE TABLE `groups_avatars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(100) NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id` (`group_id`),
  KEY `fk_groups_avatars_groups1_idx` (`group_id`),
  CONSTRAINT `fk_groups_avatars_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `groups_avatars` */

/*Table structure for table `groups_news` */

DROP TABLE IF EXISTS `groups_news`;

CREATE TABLE `groups_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `news_id` (`news_id`),
  KEY `fk_users_news_news1_idx` (`news_id`),
  KEY `fk_groups_news_groups1_idx` (`group_id`),
  CONSTRAINT `fk_groups_news_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_users_news_news10` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `groups_news` */

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `status` enum('read','unread','block','delete') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`sender_id`),
  KEY `fk_messages_users1_idx` (`sender_id`),
  KEY `fk_messages_users2_idx` (`receiver_id`),
  CONSTRAINT `fk_messages_users1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_messages_users2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `messages` */

insert  into `messages`(`id`,`sender_id`,`receiver_id`,`text`,`status`,`created_at`,`updated_at`) values 
(1,1,2,'qwe','unread','2017-01-26 14:18:07',NULL),
(2,1,3,'asd','unread','2017-01-26 14:18:07',NULL),
(3,2,1,'zxc','unread','2017-01-26 14:18:07',NULL),
(4,2,3,'dfg','unread','2017-01-26 14:18:07',NULL),
(5,1,5,'jkl','unread','2017-01-26 14:18:07',NULL),
(6,1,1,'iop','unread','2017-01-26 14:18:07',NULL);

/*Table structure for table `news` */

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `text` text NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `status` enum('active','block','delete') NOT NULL DEFAULT 'active',
  `published` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_news_users1` (`user_id`),
  CONSTRAINT `fk_news_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `news` */

insert  into `news`(`id`,`title`,`text`,`picture`,`status`,`published`,`created_at`,`updated_at`,`deleted`,`user_id`) values 
(9,'First','New','/img/img-post.jpg','active',NULL,'2017-01-26 21:08:56',NULL,0,10),
(10,'Second','Need for test','/img/img-post.jpg','active',NULL,'2017-01-26 21:09:22',NULL,0,10),
(11,'Www','qwerty','/img/img-post.jpg','active',NULL,'2017-01-26 21:25:57',NULL,0,10),
(12,'Its Work','Yuuuhuuu','/img/img-post.jpg','active',NULL,'2017-01-26 21:26:19',NULL,0,10),
(13,'Last','Last try','/img/img-post.jpg','active',NULL,'2017-01-26 21:26:34',NULL,0,10);

/*Table structure for table `passwords` */

DROP TABLE IF EXISTS `passwords`;

CREATE TABLE `passwords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_id_UNIQUE` (`user_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_passwords_users1_idx` (`user_id`),
  CONSTRAINT `fk_passwords_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `passwords` */

insert  into `passwords`(`id`,`user_id`,`password`,`created_at`,`updated_at`) values 
(1,1,'qwerty','2017-01-26 14:18:14',NULL),
(2,2,'q1w2e3','2017-01-26 14:18:14',NULL),
(3,3,'qwerty123','2017-01-26 14:18:14',NULL),
(4,10,'123456','2017-01-26 14:50:17',NULL);

/*Table structure for table `phones` */

DROP TABLE IF EXISTS `phones`;

CREATE TABLE `phones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `phone_UNIQUE` (`phone`),
  KEY `fk_phones_users1_idx` (`user_id`),
  CONSTRAINT `fk_phones_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `phones` */

insert  into `phones`(`id`,`user_id`,`phone`,`created_at`,`updated_at`) values 
(1,1,'0971231212','2017-01-26 14:18:18',NULL),
(2,1,'0681231212','2017-01-26 14:18:18',NULL),
(3,2,'0972341212','2017-01-26 14:18:18',NULL);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_2` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`created_at`,`updated_at`) values 
(5,'admin','2017-01-26 14:18:19',NULL),
(6,'user','2017-01-26 14:18:19',NULL),
(7,'unknown','2017-01-26 14:18:19',NULL),
(8,'groupOwner','2017-01-26 14:18:19',NULL),
(9,'groupSubscriber','2017-01-26 14:18:19',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(45) NOT NULL,
  `birthday` date DEFAULT NULL,
  `sex` enum('male','female') NOT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idusers_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`middle_name`,`last_name`,`email`,`birthday`,`sex`,`status`,`created_at`,`updated_at`) values 
(10,'Sergey','Vladimirovich','Hubskiy','ssskiy11@mail.ru',NULL,'male','active','2017-01-26 14:50:17',NULL);

/*Table structure for table `users_avatars` */

DROP TABLE IF EXISTS `users_avatars`;

CREATE TABLE `users_avatars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  KEY `fk_user_avatar_users1_idx` (`user_id`),
  CONSTRAINT `fk_user_avatar_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users_avatars` */

/*Table structure for table `users_avatars_comments` */

DROP TABLE IF EXISTS `users_avatars_comments`;

CREATE TABLE `users_avatars_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_avatar_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `comment_id` (`comment_id`),
  KEY `fk_users_avatars_comments_users_avatars1_idx` (`user_avatar_id`),
  KEY `fk_users_avatars_comments_comments1_idx` (`comment_id`),
  CONSTRAINT `fk_users_avatars_comments_comments1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_users_avatars_comments_users_avatars1` FOREIGN KEY (`user_avatar_id`) REFERENCES `users_avatars` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users_avatars_comments` */

/*Table structure for table `users_cities` */

DROP TABLE IF EXISTS `users_cities`;

CREATE TABLE `users_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_users_cities_1_idx` (`user_id`),
  KEY `fk_users_cities_1_idx1` (`city_id`),
  CONSTRAINT `fk_users_cities_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_users_idq_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `users_cities` */

insert  into `users_cities`(`id`,`user_id`,`city_id`,`created_at`,`updated_at`) values 
(1,1,1,'2017-01-26 14:18:24',NULL),
(2,2,1,'2017-01-26 14:18:24',NULL),
(3,3,2,'2017-01-26 14:18:24',NULL);

/*Table structure for table `users_groups` */

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '2',
  `status` enum('active','block','delete') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `group_id_user_id` (`group_id`,`user_id`),
  KEY `fk_groups_news_groups1_idx` (`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  CONSTRAINT `fk_groups_news_groups10` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users_groups` */

/*Table structure for table `users_roles` */

DROP TABLE IF EXISTS `users_roles`;

CREATE TABLE `users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `user_id_role_id` (`user_id`,`role_id`),
  KEY `fk_users_roles_users_idx` (`user_id`),
  KEY `fk_users_roles_roles1_idx` (`role_id`),
  CONSTRAINT `fk_users_roles_roles1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `fk_users_roles_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `users_roles` */

insert  into `users_roles`(`id`,`user_id`,`role_id`,`created_at`,`updated_at`) values 
(4,10,6,'2017-01-26 14:50:17',NULL);

/* Trigger structure for table `complaints` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `complaints_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `complaints_insert` AFTER INSERT ON `complaints` FOR EACH ROW BEGIN
	DECLARE comp_num INT;
	DECLARE table_name varchar(45);
    	SELECT COUNT(*) FROM complaints
		WHERE complaints_types_id=NEW.complaints_types_id
			AND object_id=NEW.object_id
		INTO comp_num;
	IF comp_num>=2	THEN
		SELECT ct.table_name FROM complaints_types ct
			WHERE ct.id=NEW.complaints_types_id
	            INTO table_name;
		CASE table_name
			WHEN 'albums_photos' THEN
			        UPDATE albums_photos SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'comments' THEN
			        UPDATE comments SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'groups_avatars' THEN
			        UPDATE groups_avatars SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'messages' THEN
			        UPDATE messages SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'news' THEN
			        UPDATE news SET status='block'
					WHERE id=NEW.object_id;
			WHEN 'users_avatars' THEN
			        UPDATE users_avatars SET status='block'
					WHERE id=NEW.object_id;
		END CASE;
	END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `friends` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `friends_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `friends_insert` BEFORE INSERT ON `friends` FOR EACH ROW BEGIN
	DECLARE row_num INT;
	SELECT COUNT(*) FROM friends
		WHERE user_receiver=NEW.user_sender
			AND user_sender=NEW.user_receiver
		INTO row_num;
	IF row_num>0 THEN
		SIGNAL SQLSTATE '02000' SET message_text="This friendship request already exists";
	END IF;
	IF NEW.user_receiver=NEW.user_sender THEN
		SIGNAL SQLSTATE '02000' SET message_text="It is impossible to be a friend of yourself";
	END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `users` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `user_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `user_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
	DECLARE role_id INT;
      SELECT id FROM roles
		WHERE name='user'
		INTO role_id;
	INSERT INTO users_roles (user_id, role_id)
		VALUES (NEW.id, role_id);
END */$$


DELIMITER ;

/*Table structure for table `admin_list` */

DROP TABLE IF EXISTS `admin_list`;

/*!50001 DROP VIEW IF EXISTS `admin_list` */;
/*!50001 DROP TABLE IF EXISTS `admin_list` */;

/*!50001 CREATE TABLE  `admin_list`(
 `first_name` varchar(20) ,
 `name` varchar(45) 
)*/;

/*View structure for view admin_list */

/*!50001 DROP TABLE IF EXISTS `admin_list` */;
/*!50001 DROP VIEW IF EXISTS `admin_list` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `admin_list` AS select `u`.`first_name` AS `first_name`,`r`.`name` AS `name` from ((`users` `u` join `users_roles` `ur` on((`u`.`id` = `ur`.`user_id`))) join `roles` `r` on((`ur`.`role_id` = `r`.`id`))) where (`r`.`name` = 'admin') */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
