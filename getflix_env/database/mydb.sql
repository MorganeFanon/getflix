CREATE DATABASE IF NOT EXISTS getflix;
USE getflix;

CREATE TABLE register (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(40) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `register` (`id`, `first_name`, `last_name`, `email`, `password`, `user_type`) VALUES
(1, 'lionel', 'hello123', 'test@gmail.com', '12345678a', 'admin'),
(13, 'clara', 'doe', 'clara@gmail.com', '1234578a', 'admin'),
(12, 'david', 'dupond', 'david@gmail.com', '12345678a', 'admin'),
(14, 'morgane', 'dupond', 'morgane@gmail.com', '12345678a', 'admin'),
(14, 'user', 'dupond', 'user@gmail.com', '12345678a', 'user');


CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `email` varchar(250) NOT NULL,
  `id_movie` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
