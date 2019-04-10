-- Create syntax for TABLE 'feed'
CREATE TABLE `feed` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(500) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create syntax for TABLE 'content'
CREATE TABLE `content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `feed_id` int(11) unsigned NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create syntax for TABLE 'user'
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '',
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `password` char(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create syntax for TABLE 'session'
CREATE TABLE `session` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` char(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create syntax for TABLE 'user_feed'
CREATE TABLE `user_feed` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `feed_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `feed_id` (`feed_id`),
  CONSTRAINT `user_feed_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `user_feed_ibfk_2` FOREIGN KEY (`feed_id`) REFERENCES `feed` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;