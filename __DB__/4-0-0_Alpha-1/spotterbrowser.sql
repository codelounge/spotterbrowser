SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `spotterbrowser_dump`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aircrafts`
--

DROP TABLE IF EXISTS `aircrafts`;
CREATE TABLE IF NOT EXISTS `aircrafts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `aircrafts`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `airline`
--

DROP TABLE IF EXISTS `airline`;
CREATE TABLE IF NOT EXISTS `airline` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `airline`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `airports`
--

DROP TABLE IF EXISTS `airports`;
CREATE TABLE IF NOT EXISTS `airports` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `iata` varchar(3) DEFAULT NULL,
  `icao` varchar(4) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `icao` (`icao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `airports`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET ucs2 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Daten für Tabelle `manufacturer`
--

INSERT INTO `manufacturer` VALUES(1, 'Airbus');
INSERT INTO `manufacturer` VALUES(2, 'Antonov');
INSERT INTO `manufacturer` VALUES(3, 'ATR');
INSERT INTO `manufacturer` VALUES(4, 'BAE Systems');
INSERT INTO `manufacturer` VALUES(5, 'Beechcraft');
INSERT INTO `manufacturer` VALUES(6, 'Bell');
INSERT INTO `manufacturer` VALUES(7, 'Boeing');
INSERT INTO `manufacturer` VALUES(8, 'Bombardier');
INSERT INTO `manufacturer` VALUES(9, 'Canadair');
INSERT INTO `manufacturer` VALUES(10, 'Cessna');
INSERT INTO `manufacturer` VALUES(11, 'Dassault');
INSERT INTO `manufacturer` VALUES(12, 'De Havilland');
INSERT INTO `manufacturer` VALUES(13, 'Dornier');
INSERT INTO `manufacturer` VALUES(14, 'Douglas');
INSERT INTO `manufacturer` VALUES(15, 'Embraer');
INSERT INTO `manufacturer` VALUES(16, 'Fokker');
INSERT INTO `manufacturer` VALUES(17, 'Gulfstream');
INSERT INTO `manufacturer` VALUES(18, 'Hawker');
INSERT INTO `manufacturer` VALUES(19, 'Ilyushin');
INSERT INTO `manufacturer` VALUES(20, 'Junkers');
INSERT INTO `manufacturer` VALUES(21, 'Learjet');
INSERT INTO `manufacturer` VALUES(22, 'Lockheed');
INSERT INTO `manufacturer` VALUES(23, 'McDonnell Douglas');
INSERT INTO `manufacturer` VALUES(24, 'MD Helicopters');
INSERT INTO `manufacturer` VALUES(25, 'Piper');
INSERT INTO `manufacturer` VALUES(26, 'Raytheon');
INSERT INTO `manufacturer` VALUES(27, 'Rosenbauer');
INSERT INTO `manufacturer` VALUES(28, 'Saab');
INSERT INTO `manufacturer` VALUES(29, 'Tupolev');
INSERT INTO `manufacturer` VALUES(30, 'Yakovlev');
INSERT INTO `manufacturer` VALUES(31, 'British Aerospace');
INSERT INTO `manufacturer` VALUES(32, 'AI(R)');
INSERT INTO `manufacturer` VALUES(33, 'Zeppelin');
INSERT INTO `manufacturer` VALUES(34, 'Shorts');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pictures`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `airport_id` int(11) NOT NULL,
  `imagedate` date NOT NULL,
  `imagenumber` int(11) NOT NULL,
  `registration` varchar(20) NOT NULL,
  `airline_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `specials` mediumtext,
  `user_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `pictures`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` VALUES(1, 'login', 'Validating');
INSERT INTO `roles` VALUES(2, 'member', 'general user');
INSERT INTO `roles` VALUES(3, 'admin', 'Administrator');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles_users`
--

DROP TABLE IF EXISTS `roles_users`;
CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `roles_users`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(24) NOT NULL,
  `last_active` int(10) unsigned NOT NULL,
  `contents` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_active` (`last_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `sessions`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `type` varchar(50) NOT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `settings`
--

INSERT INTO `settings` VALUES(2, 'version', '', 'string', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spot`
--

DROP TABLE IF EXISTS `spot`;
CREATE TABLE IF NOT EXISTS `spot` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Ort` char(3) NOT NULL DEFAULT '0',
  `Datum` date NOT NULL DEFAULT '0000-00-00',
  `Nummer` int(5) NOT NULL DEFAULT '0',
  `Registration` varchar(10) NOT NULL DEFAULT '0',
  `Airline` varchar(100) NOT NULL DEFAULT '0',
  `Typ` varchar(100) NOT NULL DEFAULT '0',
  `Kommentar` varchar(255) NOT NULL DEFAULT '',
  `views` int(10) NOT NULL DEFAULT '0',
  `Besonderheiten` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='MySQL.Spotterbrowser' AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `spot`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `updatelog`
--

DROP TABLE IF EXISTS `updatelog`;
CREATE TABLE IF NOT EXISTS `updatelog` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `updatetime` int(10) NOT NULL,
  `version` varchar(20) NOT NULL,
  `step` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `cycle` int(11) NOT NULL DEFAULT '1',
  `offset` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `updatelog`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `username_seo` varchar(40) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `realname_access` int(11) NOT NULL DEFAULT '4',
  `password` char(50) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `avatar` int(10) NOT NULL,
  `avatar_access` int(11) NOT NULL DEFAULT '4',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `invitationcode` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `users`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_tokens`
--

DROP TABLE IF EXISTS `user_tokens`;
CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `user_tokens`
--


--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
