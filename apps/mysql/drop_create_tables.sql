DROP TABLE IF EXISTS `home_m`;
CREATE TABLE `home_m` (
  `home_id` int(10) unsigned NOT NULL DEFAULT '0', 
  `home_name` text NOT NULL,
  `home_url` text NOT NULL,
  `home_rent` float(3.1) unsigned NOT NULL DEFAULT '0', 
  `home_age` int(5) unsigned NOT NULL DEFAULT '0', 
  `home_address` text NOT NULL,
  `delf` tinyint(1) unsigned NOT NULL DEFAULT '0', 
  `uptime` datetime NOT NULL,
  `intime` datetime NOT NULL,
   PRIMARY KEY (`home_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `home_traffic_t`;
CREATE TABLE `home_traffic_t` (
  `home_id` int(10) unsigned NOT NULL DEFAULT '0',
  `home_traffic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_m`;
CREATE TABLE `user_m` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_mail` varchar(255) DEFAULT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `user_last_name` text NOT NULL,
  `user_first_name` text NOT NULL,
  `user_gender` tinyint(1) unsigned NOT NULL,
  `user_age` int(10) unsigned NOT NULL DEFAULT '0',
  `delf` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `uptime` datetime NOT NULL,
  `intime` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id_2` (`user_id`,`delf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_session_t`;
CREATE TABLE `user_session_t` (
  `session_id` varchar(100) NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0', 
  `login_time` datetime NOT NULL,
  `logout_time` datetime NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `home_favorite_t`;
CREATE TABLE `home_favorite_t` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `home_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `intime` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`home_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
