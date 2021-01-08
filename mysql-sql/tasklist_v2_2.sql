DROP DATABASE IF EXISTS `tasklist`;
CREATE DATABASE `tasklist` DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;
USE `tasklist`;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11),
  `name` varchar(255) NOT NULL,
  `priority` enum('high','normal','low') NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci AUTO_INCREMENT = 4;


INSERT INTO `tasks` VALUES (1, 1, 'Een dringende taak', 'high', now());
INSERT INTO `tasks` VALUES (2, 2, 'Een normale taak', 'normal', now());
INSERT INTO `tasks` VALUES (3, 1, 'Een niet zo belangrijke taak', 'low', now());
INSERT INTO `tasks` VALUES (7, null, '🍰 Taart eten', 'normal', now());


CREATE TABLE `users` (
`id` int(11) NOT NULL auto_increment,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'joris', '$2y$10$/FPq.CjbqsI5ShQTMP33SevKq4CuIPm1fI8gIhZY/Knm5TiVm1vnm', 'joris.maervoet@odisee.be'),
(2, 'pieter', '$2y$10$EbUrgw9iguKDLGZRiWYIK.bZbubV1AVmFMIsM.bOW/ioscH7Desle', 'pieter.vanpeteghem@odisee.be');

ALTER TABLE `tasks` ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(id);