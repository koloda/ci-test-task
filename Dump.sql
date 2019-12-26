CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(1024) DEFAULT NULL,
  `short_description` varchar(2048) DEFAULT NULL,
  `text` text,
  `img` varchar(1024) DEFAULT NULL,
  `tags` varchar(1024) DEFAULT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `time_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `news` (`id`, `header`, `short_description`, `text`, `img`, `tags`, `status`, `time_created`, `time_updated`)
VALUES
	(1,'News #1','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore \' +\n            \'et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip\' +\n            \' ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu \' +\n            \'fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt \' +\n            \'mollit anim id est laborum.','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore \' +\n            \'et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip\' +\n            \' ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu \' +\n            \'fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt \' +\n            \'mollit anim id est laborum.','/assets/images/news/cover-news-20180808.png','кек,чебурек','open','2018-08-30 16:31:14','2018-10-11 04:37:16'),
	(3,'Эх, чужд кайф, сплющь','<p>Широкая электрификация южных губерний даст мощный толчок подъёму сельского хозяйства.<br></p>','<<<<<<<p>Эй, жлоб! Где туз? Прячь юных <u><b>съёмщиц</b></u> в шкаф. Съешь [же] ещё этих мягких <span style=\"background-color: rgb(255, 255, 0);\">французских</span> булок да выпей чаю. В чащах юга жил бы цитрус? Да, но фальшивый экземпляр! Эх, чужак! Общий съём <a href=\"#\" target=\"_blank\">цен</a> шляп (юфть) — вдрызг!<br></p>','/assets/images/news/3.jpg',NULL,'open','2018-10-11 04:33:27','2018-11-13 04:17:04'),
	(null,'ART Dont say', 'Dont say a word. Precisely. Right. Uh, well, I havent finished those up yet, but you know I figured since they werent due till- Yeah, where does he live?', 'Now remember, according to my theory you interfered with with your parents first meeting' ,'/assets/images/news/3.jpg',NULL,'open','2019-10-11 04:33:27','2019-11-13 04:17:04'),
	(null, '4th Article', 'FOURTH ARTICLE  -  Dont say a word. Precisely. Right. Uh, well, I havent finished those up yet, but you know I figured since they werent due till- Yeah, where does he live?', 'FOURTH ARTICLE  -  Now remember, according to my theory you interfered with with your parents first meeting' ,'/assets/images/news/3.jpg',NULL,'open','2019-11-11 04:33:27','2019-11-13 04:17:04');


CREATE TABLE `news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(1024) DEFAULT NULL,
  `news_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `news_comments` ADD CONSTRAINT `fk_news_comments` FOREIGN KEY (`news_id`)
  REFERENCES `news`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `news_comments` (`news_id`, `text`) VALUES
(1, 'Лорем ипсум долор сит амет, ин перпетуа цомплецтитур хис. Ин сеа пхилосопхиа цонсецтетуер, зрил номинати.'),
(1, 'Vel et munere consul principes. Id his graeco inimicus. Nam in duis corrumpit scripserit, te.'),
(3, 'Vero nusquam scribentur ex mel. Nonumes omittantur ei mea, ne per etiam doctus. At ius.'),
(3, 'Vel ferri latine te, vix no purto quaestio. Usu aliquando delicatissimi interpretaris in, epicuri accumsan.'),
(3, 'Eu putent prompta eleifend cum, eum luptatum suavitate id. Usu id volumus consequat, duo ei.'),
(5, 'the process and we kind of need to fill the blank spaces with something that will look like a regular text.'),
(5, 'What, what is it hot?');

CREATE TABLE `likes` (
  `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `entity` ENUM('news','comments') NOT NULL ,
  `entity_id` INT(11) NOT NULL ,
  `user_id` VARCHAR(32) NOT NULL ,
  `created_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
   PRIMARY KEY (`id`), INDEX `lv_index` (`entity`), INDEX `userid_like_index` (`user_id`)) ENGINE = InnoDB;

ALTER TABLE `likes` ADD UNIQUE `unique_user_like` (`entity`, `entity_id`, `user_id`);

CREATE VIEW `news_likes` AS
  SELECT `id`, `entity`, `entity_id` AS `news_id`, `user_id`, `created_at` FROM `likes` WHERE `entity` = 'news';

CREATE VIEW `news_comments_likes` AS
  SELECT `id`, `entity`, `entity_id` AS `comment_id`, `user_id`, `created_at` FROM `likes` WHERE `entity` = 'comments';