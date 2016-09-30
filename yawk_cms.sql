-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Okt 2016 um 00:46
-- Server-Version: 10.1.10-MariaDB
-- PHP-Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `yawk_lte`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_blog`
--

CREATE TABLE `cms_blog` (
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '1',
  `published` int(1) NOT NULL DEFAULT '1',
  `name` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(64) NOT NULL,
  `showtitle` int(1) NOT NULL DEFAULT '1',
  `showdesc` int(1) NOT NULL DEFAULT '1',
  `showdate` int(1) NOT NULL DEFAULT '0',
  `showauthor` int(1) NOT NULL DEFAULT '0',
  `sequence` int(1) NOT NULL DEFAULT '0',
  `sortation` int(1) NOT NULL DEFAULT '0',
  `footer` int(1) NOT NULL DEFAULT '0',
  `comments` int(1) NOT NULL DEFAULT '0',
  `gid` int(11) NOT NULL DEFAULT '1',
  `permalink` int(1) NOT NULL DEFAULT '0',
  `layout` int(1) NOT NULL DEFAULT '0',
  `preview` int(1) NOT NULL DEFAULT '0',
  `voting` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_blog_comments`
--

CREATE TABLE `cms_blog_comments` (
  `id` int(11) NOT NULL,
  `blogid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) DEFAULT NULL,
  `gid` int(11) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `isParent` int(1) NOT NULL DEFAULT '0',
  `isChild` int(1) NOT NULL DEFAULT '0',
  `parentID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_blog_items`
--

CREATE TABLE `cms_blog_items` (
  `blogid` int(11) NOT NULL DEFAULT '1',
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pageid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `itemgid` int(2) NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_changed` datetime NOT NULL,
  `date_publish` datetime NOT NULL,
  `date_unpublish` datetime NOT NULL,
  `teasertext` text NOT NULL,
  `blogtext` longtext NOT NULL,
  `author` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `youtubeUrl` varchar(255) NOT NULL,
  `voteUp` int(11) NOT NULL DEFAULT '0',
  `voteDown` int(11) NOT NULL DEFAULT '0',
  `primkey` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_follower`
--

CREATE TABLE `cms_follower` (
  `id` int(11) NOT NULL,
  `requestDate` datetime NOT NULL,
  `follower` int(11) NOT NULL,
  `hunted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_follower`
--

INSERT INTO `cms_follower` (`id`, `requestDate`, `follower`, `hunted`) VALUES
(1, '0000-00-00 00:00:00', 1, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_friends`
--

CREATE TABLE `cms_friends` (
  `id` int(11) NOT NULL,
  `requestDate` datetime NOT NULL,
  `confirmDate` datetime NOT NULL,
  `friendA` int(11) NOT NULL,
  `friendB` int(11) NOT NULL,
  `confirmed` int(1) NOT NULL DEFAULT '0',
  `aborted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_friends`
--

INSERT INTO `cms_friends` (`id`, `requestDate`, `confirmDate`, `friendA`, `friendB`, `confirmed`, `aborted`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 3, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_gfonts`
--

CREATE TABLE `cms_gfonts` (
  `id` int(11) NOT NULL,
  `font` varchar(128) NOT NULL,
  `description` varchar(256) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_gfonts`
--

INSERT INTO `cms_gfonts` (`id`, `font`, `description`, `activated`) VALUES
(0, 'none', 'no google font selected', 0),
(1, 'Arvo', 'Arvo, serif', 1),
(2, 'Copse', 'Copse, sans-serif', 1),
(3, 'Droid Sans', 'Droid Sans, sans-serif', 1),
(4, 'Droid Serif', 'Droid Serif, serif', 1),
(5, 'Lobster', 'Lobster, cursive', 1),
(6, 'Nobile', 'Nobile, sans-serif', 1),
(7, 'Open Sans', 'Open Sans, sans-serif', 1),
(8, 'Oswald', 'Oswald, sans-serif', 1),
(9, 'Pacifico', 'Pacifico, cursive', 1),
(10, 'Rokkitt', 'Rokkitt, serif', 1),
(11, 'PT Sans', 'PT Sans, sans-serif', 1),
(12, 'Quattrocento', 'Quattrocento, serif', 1),
(13, 'Raleway', 'Raleway, cursive', 1),
(15, 'Yanone Kaffeesatz', 'Yanone Kaffeesatz, sans-serif', 1),
(16, 'Norican', 'Norican, cursive', 1),
(17, 'Donegal One', 'Donegal, serif', 1),
(18, 'Peralta', 'Peralta, display', 1),
(19, 'Kalam', 'Kalam, cursive', 1),
(20, 'Ubuntu', 'Ubuntu, serif', 1),
(21, 'The Girl Next Door', 'The Girl Next Door, serif', 1),
(22, 'Courgette', 'Courgette, serif', 1),
(23, 'Permanent Marker', 'Permanent Marker, cursive', 1),
(24, 'Gloria Hallelujah', 'Gloria Hallelujah, cursive', 1),
(25, 'Dancing Script', 'Dancing Script, cursive', 1),
(26, 'Alex Brush', 'Alex Brush, cursive', 1),
(27, 'Allura', 'Allura, cursive', 1),
(28, 'Satisfy', 'Satisfiy, cursive', 1),
(29, 'Crafty Girls', 'Crafty Girls, cursive', 1),
(30, 'Yellowtail', 'Yellowtail, cursive', 1),
(31, 'Parisienne', 'Parisienne, cursive', 1),
(32, 'Petit Formal Script', 'Petit Formal Script, cursive', 1),
(33, 'Bilbo Swash Caps', 'Bilbo Swash Caps, cursive', 1),
(35, 'Miniver', 'Miniver, cursive', 1),
(36, 'Libre Baskerville', 'Libre Baskerville, serif', 1),
(37, 'PT Serif', 'PT Serif, serif', 1),
(38, 'Indie Flower', 'Indie Flower, cursive', 1),
(39, 'Architects Daughter', 'Architects Daughter, cursive', 1),
(40, 'Handlee', 'Handlee, cursive', 1),
(41, 'Gochi Hand', 'Gochi Hand, cursive', 1),
(42, 'Neucha', 'Neucha, cursive', 1),
(43, 'Covered By Your Grace', 'Covered By Your Grace, cursive', 1),
(44, 'Great Vibes', 'Great Vibes, cursive', 1),
(45, 'Marck Script', 'Marck Script, cursive', 1),
(46, 'Comfortaa', 'Comfortaa, cursive', 1),
(47, 'Chewy', 'Chewy, cursive', 1),
(48, 'Special Elite', 'Special Elite', 1),
(49, 'Frijole', 'Frijole, cursive', 1),
(50, 'Press Start 2P', 'Press Start 2P, cursive', 1),
(51, 'Oleo Script Swash Caps', 'Oleo Script Swash Caps, cursive', 1),
(52, 'Kaushan Script', 'Kaushan Script, cursive', 1),
(53, 'Open Sans Condensed', 'Open Sans Condensed', 1),
(54, 'Nothing You Could Do', 'Nothing You Could Do, cursive', 1),
(55, 'Maven Pro', 'Maven Pro, sans-serif', 1),
(56, 'Abel', 'Abel, sans-serif', 1),
(57, 'Short Stack', 'Short Stack, cursive', 1),
(58, 'Merriweather Sans', 'Merriweather Sans, sans-serif', 1),
(59, 'Josefin Sans', 'Josefin Sans, sans-serif', 1),
(61, 'Hind Vadodara', 'Hind Vadodara, cursive', 1),
(62, 'Sahitya', 'Sahitya, serif', 1),
(63, 'Lustria', 'Lustria, serif', 1),
(64, 'Marcellus SC', 'Marcellus SC, serif', 1),
(66, 'Jaldi', 'Jaldi, sans-serif', 1),
(67, 'Pragati Narrow', 'Pragati Narrow, sans-serif', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_logins`
--

CREATE TABLE `cms_logins` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `location` varchar(64) NOT NULL,
  `failed` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL,
  `useragent` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_logins`
--

INSERT INTO `cms_logins` (`id`, `datetime`, `location`, `failed`, `ip`, `useragent`, `username`, `password`) VALUES
(1, '2016-09-12 22:22:23', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', 'admin'),
(2, '2016-09-12 22:22:39', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', 'admin'),
(3, '2016-09-12 22:22:45', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', 'admin'),
(4, '2016-09-12 22:26:11', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', 'admin'),
(5, '2016-09-12 22:34:49', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(6, '2016-09-12 22:35:50', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(7, '2016-09-12 22:38:10', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(8, '2016-09-12 22:38:10', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(9, '2016-09-12 22:38:41', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(10, '2016-09-12 22:38:41', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(11, '2016-09-12 22:39:11', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(12, '2016-09-12 22:39:11', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(13, '2016-09-12 22:41:10', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(14, '2016-09-12 22:41:10', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(15, '2016-09-12 22:41:52', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(16, '2016-09-12 22:41:52', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(17, '2016-09-12 22:41:59', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(18, '2016-09-12 22:41:59', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(19, '2016-09-12 22:42:39', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(20, '2016-09-12 22:42:42', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(21, '2016-09-12 22:42:42', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(22, '2016-09-12 22:43:04', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(23, '2016-09-12 22:43:04', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(24, '2016-09-12 22:43:08', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(25, '2016-09-12 22:43:09', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(26, '2016-09-12 22:43:12', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(27, '2016-09-12 22:43:13', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(28, '2016-09-12 22:43:36', 'frontend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(29, '2016-09-12 22:45:00', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(30, '2016-09-12 22:45:00', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(31, '2016-09-12 22:50:55', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(32, '2016-09-12 22:50:55', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(33, '2016-09-12 22:57:14', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(34, '2016-09-12 22:57:14', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(35, '2016-09-12 22:57:25', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(36, '2016-09-12 22:57:25', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(37, '2016-09-12 22:57:40', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(38, '2016-09-12 22:57:40', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(39, '2016-09-12 23:25:54', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(40, '2016-09-12 23:25:54', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(41, '2016-09-12 23:26:00', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(42, '2016-09-12 23:26:00', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(43, '2016-09-13 00:16:23', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(44, '2016-09-13 00:16:23', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(45, '2016-09-13 00:56:09', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(46, '2016-09-13 00:56:09', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(47, '2016-09-13 01:20:42', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(48, '2016-09-13 01:20:42', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(49, '2016-09-13 01:56:03', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(50, '2016-09-13 01:56:03', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(51, '2016-09-13 03:14:23', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(52, '2016-09-13 03:14:23', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(53, '2016-09-13 03:37:21', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(54, '2016-09-13 03:37:21', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(55, '2016-09-13 03:41:40', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(56, '2016-09-13 03:41:40', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(57, '2016-09-13 12:01:17', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '', ''),
(58, '2016-09-13 12:01:17', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '', ''),
(59, '2016-09-13 12:01:17', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '', ''),
(60, '2016-09-13 12:08:13', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(61, '2016-09-13 12:08:13', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(62, '2016-09-13 12:08:24', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(63, '2016-09-13 12:08:24', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(64, '2016-09-13 12:08:45', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(65, '2016-09-13 12:08:45', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(66, '2016-09-13 12:15:02', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(67, '2016-09-13 12:15:02', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(68, '2016-09-13 12:21:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(69, '2016-09-13 12:29:20', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(70, '2016-09-13 12:29:20', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(71, '2016-09-13 12:29:35', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(72, '2016-09-13 12:29:35', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(73, '2016-09-13 13:10:40', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(74, '2016-09-13 13:17:59', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(75, '2016-09-13 13:17:59', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(76, '2016-09-13 13:32:49', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(77, '2016-09-13 13:32:49', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(78, '2016-09-13 13:40:22', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(79, '2016-09-13 13:40:22', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(80, '2016-09-13 13:42:14', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(81, '2016-09-13 13:42:14', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(82, '2016-09-13 13:43:42', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(83, '2016-09-13 13:43:42', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(84, '2016-09-13 13:45:28', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(85, '2016-09-13 13:45:28', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(86, '2016-09-13 13:45:48', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(87, '2016-09-13 13:45:48', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(88, '2016-09-13 13:54:08', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(89, '2016-09-13 13:54:08', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(90, '2016-09-13 14:01:32', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(91, '2016-09-13 14:01:32', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(92, '2016-09-13 14:11:59', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(93, '2016-09-13 14:11:59', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(94, '2016-09-13 14:52:49', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(95, '2016-09-13 15:53:43', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(96, '2016-09-13 15:53:43', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(97, '2016-09-13 16:07:44', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'test', '1234'),
(98, '2016-09-13 16:07:44', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'test', '1234'),
(99, '2016-09-13 16:08:07', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(100, '2016-09-13 16:08:07', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(101, '2016-09-13 16:13:44', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(102, '2016-09-13 21:11:18', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'test', '1234'),
(103, '2016-09-13 21:11:18', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'test', '1234'),
(104, '2016-09-13 21:16:29', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(105, '2016-09-13 21:16:29', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(106, '2016-09-13 21:42:09', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(107, '2016-09-13 21:42:09', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(108, '2016-09-14 11:56:31', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(109, '2016-09-14 11:56:31', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(110, '2016-09-14 12:40:15', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(111, '2016-09-14 12:40:15', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(112, '2016-09-14 15:55:14', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '123456'),
(113, '2016-09-14 15:55:14', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '123456'),
(114, '2016-09-14 21:56:38', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(115, '2016-09-14 21:56:38', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(116, '2016-09-14 22:13:01', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(117, '2016-09-14 22:13:01', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(118, '2016-09-15 00:42:16', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(119, '2016-09-15 00:42:16', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(120, '2016-09-15 00:42:52', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admins', '1234'),
(121, '2016-09-15 00:42:52', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admins', '1234'),
(122, '2016-09-15 00:43:06', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(123, '2016-09-15 00:43:06', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '1234'),
(124, '2016-09-15 01:20:11', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(125, '2016-09-15 01:20:11', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(126, '2016-09-15 02:25:52', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(127, '2016-09-15 02:51:52', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(128, '2016-09-15 02:53:04', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(129, '2016-09-15 02:54:25', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(130, '2016-09-15 02:55:38', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(131, '2016-09-15 02:56:39', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(132, '2016-09-15 03:02:01', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(133, '2016-09-15 03:02:01', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(134, '2016-09-15 03:03:20', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(135, '2016-09-15 03:03:20', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(136, '2016-09-15 05:36:56', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(137, '2016-09-15 11:57:37', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(138, '2016-09-15 11:57:37', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(139, '2016-09-15 13:53:32', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(140, '2016-09-15 14:17:02', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(141, '2016-09-15 14:17:02', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(142, '2016-09-15 15:50:31', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(143, '2016-09-15 15:50:31', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'admin', '12345'),
(144, '2016-09-24 23:59:30', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(145, '2016-09-24 23:59:30', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(146, '2016-09-24 23:59:30', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(147, '2016-09-24 23:59:45', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(148, '2016-09-24 23:59:45', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(149, '2016-09-25 00:00:17', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(150, '2016-09-25 00:00:17', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(151, '2016-09-25 00:00:38', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(152, '2016-09-25 00:00:38', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(153, '2016-09-25 00:00:52', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(154, '2016-09-25 00:00:52', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(155, '2016-09-25 00:00:54', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(156, '2016-09-25 00:00:54', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(157, '2016-09-25 00:01:59', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(158, '2016-09-25 00:02:12', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '123'),
(159, '2016-09-25 00:03:21', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', 'test'),
(160, '2016-09-25 00:03:23', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(161, '2016-09-25 00:03:26', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(162, '2016-09-25 00:03:38', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(163, '2016-09-25 00:03:38', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(164, '2016-09-25 00:03:48', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(165, '2016-09-25 00:03:50', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(166, '2016-09-25 00:04:46', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(167, '2016-09-25 00:05:07', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(168, '2016-09-25 00:05:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(169, '2016-09-25 00:05:45', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(170, '2016-09-25 00:05:54', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(171, '2016-09-25 00:06:01', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(172, '2016-09-25 00:06:01', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(173, '2016-09-25 00:06:41', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(174, '2016-09-25 00:06:41', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(175, '2016-09-25 00:06:44', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(176, '2016-09-25 00:06:44', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(177, '2016-09-25 00:06:47', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(178, '2016-09-25 00:06:55', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(179, '2016-09-25 00:06:55', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(180, '2016-09-25 00:06:55', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(181, '2016-09-25 00:07:36', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(182, '2016-09-25 00:07:36', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '1234'),
(183, '2016-09-25 00:09:35', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(184, '2016-09-25 03:39:37', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(185, '2016-09-25 03:39:37', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(186, '2016-09-25 03:39:37', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(187, '2016-09-25 03:39:43', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(188, '2016-09-25 04:01:50', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(189, '2016-09-25 04:03:00', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(190, '2016-09-25 19:09:52', 'frontend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(191, '2016-09-25 19:09:52', 'frontend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(192, '2016-09-25 19:13:58', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(193, '2016-09-25 19:13:58', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(194, '2016-09-25 19:13:58', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '', ''),
(195, '2016-09-25 19:14:11', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(196, '2016-09-25 21:12:59', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'admin', '12345'),
(197, '2016-09-28 13:07:52', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', 'test'),
(198, '2016-09-28 13:07:52', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', 'test'),
(199, '2016-09-28 13:07:52', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', 'test'),
(200, '2016-09-28 13:07:57', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(201, '2016-09-29 00:19:27', 'backend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(202, '2016-09-29 21:22:15', 'backend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '1q2345'),
(203, '2016-09-29 21:22:15', 'backend', 1, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '1q2345'),
(204, '2016-09-29 21:22:15', 'backend', 1, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '1q2345'),
(205, '2016-09-29 21:22:46', 'backend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(206, '2016-09-29 21:46:30', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(207, '2016-09-29 21:46:30', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(208, '2016-09-29 22:06:22', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(209, '2016-09-29 22:06:22', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(210, '2016-09-29 22:06:38', 'backend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(211, '2016-09-29 22:25:59', 'frontend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(212, '2016-09-29 22:26:11', 'frontend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(213, '2016-09-29 22:26:51', 'frontend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(214, '2016-09-29 22:27:03', 'frontend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(215, '2016-09-29 22:27:43', 'backend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(216, '2016-09-30 07:58:13', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'claudia', '12345');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_menu`
--

CREATE TABLE `cms_menu` (
  `TMPID` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `gid` int(11) NOT NULL DEFAULT '1',
  `menuID` int(11) NOT NULL,
  `parentID` int(11) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_changed` datetime NOT NULL,
  `date_publish` datetime NOT NULL,
  `date_unpublish` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `href` varchar(255) NOT NULL,
  `target` varchar(64) NOT NULL DEFAULT '_self',
  `divider` int(11) NOT NULL DEFAULT '0',
  `blogid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_menu`
--

INSERT INTO `cms_menu` (`TMPID`, `id`, `sort`, `gid`, `menuID`, `parentID`, `published`, `date_created`, `date_changed`, `date_publish`, `date_unpublish`, `title`, `href`, `target`, `divider`, `blogid`) VALUES
(1, 1, 1, 1, 1, 0, 1, '0000-00-00 00:00:00', '2016-08-25 04:33:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Startseite', 'index.html', '_self', 0, 0),
(2, 2, 2, 1, 1, 0, 1, '0000-00-00 00:00:00', '2016-08-25 04:33:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Styling', 'override-bootstrap-style-settings-theme-generator.html', '_self', 0, 0),
(3, 3, 3, 2, 1, 0, 1, '0000-00-00 00:00:00', '2016-08-25 04:33:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Userpage', 'welcome.html', '_self', 0, 0),
(4, 4, 4, 1, 1, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Testseite', 'testseite.html', '_self', 0, 0),
(5, 1, 1, 1, 2, 0, 1, '2016-09-26 09:53:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Eintrag 1', '#', '_self', 0, 0),
(6, 2, 2, 1, 2, 0, 1, '2016-09-26 09:53:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Eintrag 2', '#', '_self', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_menu_names`
--

CREATE TABLE `cms_menu_names` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_menu_names`
--

INSERT INTO `cms_menu_names` (`id`, `name`, `published`) VALUES
(1, 'YaWK', 1),
(2, 'Test Menu', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_meta_global`
--

CREATE TABLE `cms_meta_global` (
  `name` varchar(100) NOT NULL,
  `content` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_meta_global`
--

INSERT INTO `cms_meta_global` (`name`, `content`) VALUES
('author', 'YaWK'),
('description', 'Dieser Beschreibungstext soll einem Anwender im Suchdienst bei Auffinden dieser Datei erscheinen.'),
('robots', 'all');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_meta_local`
--

CREATE TABLE `cms_meta_local` (
  `name` varchar(100) NOT NULL,
  `page` int(11) NOT NULL,
  `content` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_meta_local`
--

INSERT INTO `cms_meta_local` (`name`, `page`, `content`) VALUES
('description', 4, 'logout'),
('description', 5, 'terms-of-service'),
('description', 6, 'Tips for web developer'),
('keywords', 4, 'keyword1, keyword2, keyword3, keyword4'),
('keywords', 5, 'keyword1, keyword2, keyword3, keyword4'),
('keywords', 6, 'keyword1, keyword2, keyword3, keyword4');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_notifications`
--

CREATE TABLE `cms_notifications` (
  `log_id` int(11) NOT NULL,
  `log_date` datetime NOT NULL,
  `log_type` int(11) NOT NULL DEFAULT '0',
  `msg_id` int(11) NOT NULL DEFAULT '0',
  `fromUID` int(11) NOT NULL DEFAULT '0',
  `toUID` int(11) NOT NULL DEFAULT '0',
  `toGID` int(11) NOT NULL DEFAULT '0',
  `seen` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_notifications`
--

INSERT INTO `cms_notifications` (`log_id`, `log_date`, `log_type`, `msg_id`, `fromUID`, `toUID`, `toGID`, `seen`) VALUES
(1, '0000-00-00 00:00:00', 1, 0, 1, 0, 0, 0),
(2, '0000-00-00 00:00:00', 1, 0, 1, 0, 0, 0),
(3, '0000-00-00 00:00:00', 1, 0, 1, 0, 0, 0),
(4, '0000-00-00 00:00:00', 1, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_notifications_msg`
--

CREATE TABLE `cms_notifications_msg` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `type` int(11) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` int(11) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `gid` int(11) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_changed` datetime NOT NULL,
  `date_publish` datetime NOT NULL,
  `date_unpublish` datetime NOT NULL,
  `alias` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `bgimage` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '-1',
  `menu` int(11) NOT NULL DEFAULT '0',
  `locked` int(1) NOT NULL DEFAULT '0',
  `blogid` int(11) NOT NULL DEFAULT '0',
  `plugin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `published`, `gid`, `date_created`, `date_changed`, `date_publish`, `date_unpublish`, `alias`, `title`, `bgimage`, `owner`, `menu`, `locked`, `blogid`, `plugin`) VALUES
(1, 1, 1, '2016-08-19 09:43:45', '2016-09-28 05:19:03', '2016-08-19 09:43:45', '0000-00-00 00:00:00', 'index', 'Startseite', '', -1, 0, 0, 0, '0'),
(2, 1, 1, '2016-08-19 09:58:39', '2016-09-04 09:47:27', '2016-08-19 09:58:39', '0000-00-00 00:00:00', 'override-bootstrap-style-settings-theme-generator', 'Styling', '', -1, 0, 0, 0, '0'),
(3, 1, 2, '2016-08-19 10:54:00', '2016-08-19 10:57:07', '2016-08-19 10:54:00', '0000-00-00 00:00:00', 'welcome', 'Userpage', '', -1, 0, 1, 0, '0'),
(4, 0, 1, '2016-09-12 14:32:17', '2016-09-12 14:36:13', '2016-09-12 14:32:17', '0000-00-00 00:00:00', 'logout', 'logout', '', -1, 0, 1, 0, '0'),
(5, 1, 1, '2016-09-15 02:58:56', '0000-00-00 00:00:00', '2016-09-15 02:58:56', '0000-00-00 00:00:00', 'terms-of-service', 'terms-of-service', '', -1, 0, 0, 0, '0'),
(6, 1, 1, '2016-09-25 18:20:36', '2016-09-28 15:07:08', '2016-09-25 18:25:36', '0000-00-00 00:00:00', 'testseite', 'Testseite', '', -1, 0, 0, 0, '0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_plugins`
--

CREATE TABLE `cms_plugins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_plugins`
--

INSERT INTO `cms_plugins` (`id`, `name`, `description`, `icon`, `activated`) VALUES
(1, 'tourdates', 'Termine, Events, Konzerte, Tourdaten u.&auml;. in einer sortierbaren Tabelle verwalten.', 'fa fa-table', 1),
(2, 'faq', 'Datenbank-gest&uuml;tze F.A.Q.s', 'fa fa-question-circle', 1),
(3, 'blog', 'Erstelle ein Blog mit fortlaufenden Eintr&auml;gen.', 'fa fa-wordpress', 1),
(4, 'booking', 'Booking App', 'fa fa-calendar-check-o', 1),
(5, 'sedcard', 'Sedcard Plugin provides Online Sedcards for "Models"', 'fa fa-female', 0),
(6, 'messages', 'A simple messaging system where users can send private messages to each other.', 'fa fa-envelope-o', 1),
(7, 'signup', 'Allow and setup user registration from frontend.', 'fa fa-user', 1),
(8, 'userpage', 'Edit User Page Settings', 'fa fa-home', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_plugin_booking`
--

CREATE TABLE `cms_plugin_booking` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `gid` int(11) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_wish` datetime NOT NULL,
  `date_alternative` datetime NOT NULL,
  `confirmed` int(1) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `todo` int(1) NOT NULL,
  `success` int(1) NOT NULL DEFAULT '0',
  `income` int(6) NOT NULL DEFAULT '0',
  `grade` int(1) NOT NULL DEFAULT '0',
  `visits` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `useragent` varchar(255) NOT NULL,
  `ban` int(1) NOT NULL DEFAULT '0',
  `outdated` int(1) NOT NULL DEFAULT '0',
  `referer` varchar(255) NOT NULL,
  `cut` int(1) NOT NULL DEFAULT '0',
  `invited` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_plugin_faq`
--

CREATE TABLE `cms_plugin_faq` (
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `cat` int(6) NOT NULL DEFAULT '1',
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_plugin_faq`
--

INSERT INTO `cms_plugin_faq` (`id`, `sort`, `published`, `cat`, `question`, `answer`) VALUES
(7, 0, 1, 1, 'Question', 'Answer'),
(8, 0, 1, 1, 'Question 2', 'Answer 2'),
(9, 0, 1, 1, 'Question 3', 'Answer 3'),
(10, 0, 1, 1, 'Question 4', 'Answer 4');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_plugin_msg`
--

CREATE TABLE `cms_plugin_msg` (
  `msg_id` int(11) NOT NULL,
  `parentID` int(11) NOT NULL,
  `msg_date` datetime NOT NULL,
  `fromUID` int(11) NOT NULL,
  `toUID` int(11) NOT NULL,
  `msg_body` text NOT NULL,
  `msg_read` int(1) NOT NULL DEFAULT '0',
  `trash` int(1) NOT NULL,
  `spam` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_plugin_msg`
--

INSERT INTO `cms_plugin_msg` (`msg_id`, `parentID`, `msg_date`, `fromUID`, `toUID`, `msg_body`, `msg_read`, `trash`, `spam`) VALUES
(1, 0, '2016-09-14 00:36:26', 1, 1, 'test', 1, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_plugin_tourdates`
--

CREATE TABLE `cms_plugin_tourdates` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `band` varchar(128) NOT NULL,
  `venue` varchar(128) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `fburl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_settings`
--

CREATE TABLE `cms_settings` (
  `property` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `longValue` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `sortation` int(11) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '1',
  `label` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `subtext` varchar(255) NOT NULL,
  `fieldClass` varchar(255) NOT NULL DEFAULT 'form-control',
  `fieldType` varchar(255) NOT NULL,
  `placeholder` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `options` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_settings`
--

INSERT INTO `cms_settings` (`property`, `value`, `longValue`, `type`, `sortation`, `activated`, `label`, `icon`, `heading`, `subtext`, `fieldClass`, `fieldType`, `placeholder`, `description`, `options`) VALUES
('admin_email', 'youremail@domain.com', '', 1, 5, 1, 'ADMIN_EMAIL_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFooter', '0', '', 11, 1, 1, 'BACKENDFOOTER_LABEL', 'fa fa-chevron-down', 'BACKENDFOOTER_HEADING', 'BACKENDFOOTER_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendFooterCopyright', '0', '', 11, 2, 1, 'BACKENDFOOTERCOPYRIGHT_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendFooterValueLeft', 'This Website is', '', 11, 2, 1, 'BACKENDFOOTERVALUE_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFooterValueRight', 'proudly presented by Yet another Web Kit', '', 11, 2, 1, 'BACKENDFOOTERVALUERIGHT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFX', '0', '', 2, 3, 1, 'BACKENDFX_LABEL', 'fa fa-paper-plane-o', 'BACKENDFX_HEADING', 'BACKENDFX_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendFXtime', '820', '', 2, 5, 1, 'BACKENDFXTIME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFXtype', 'fadeIn In', '', 2, 4, 1, 'BACKENDFXTYPE_LABEL', '', '', '', 'form-control', 'select', '', '', 'fadeIn,Fade In:slideDown,Slide Down'),
('backendLayout', 'sidebar-mini Mini', '', 2, 2, 1, 'BACKENDLAYOUT_LABEL', '', '', '', 'form-control', 'select', '', 'BACKENDLAYOUT_DESC', 'fixed,Fixed:sidebar-collapse,Sidebar Collapse:sidebar-mini,Sidebar Mini:layout-boxed,Layout Boxed:layout-top-nav,Layout Top Nav'),
('backendLogoSubText', 'frontend', '', 12, 2, 1, 'BACKENDLOGOSUBTEXT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendLogoText', 'YaWK', '', 12, 1, 1, 'BACKENDLOGOTEXT_LABEL', 'fa fa-bars', 'BACKENDLOGOTEXT_HEADING', 'BACKENDLOGOTEXT_SUBTEXT', 'form-control', 'input', '', '', ''),
('backendLogoUrl', '0', '', 12, 3, 1, 'BACKENDLOGOURL_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendMessagesMenu', '1', '', 12, 4, 1, 'BACKENDMSGMENU_LABEL', 'fa fa-bell-o', 'BACKENDMSGMENU_HEADING', 'BACKENDMSGMENU_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendNotificationMenu', '1', '', 12, 5, 1, 'BACKENDNOTIFYMENU_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendSkin', 'skin-green', '', 2, 1, 1, 'BACKENDSKIN_LABEL', 'fa fa-paint-brush', 'BACKENDSKIN_HEADING', 'BACKENDSKIN_SUBTEXT', 'form-control', 'select', '', '', 'skin-blue,Blue:skin-green,Green:skin-red,Red:skin-yellow,Yellow:skin-purple,Purple:skin-black,Black'),
('dbhost', 'http://localhost', '', 13, 2, 1, 'DBHOST_LABEL', '', '', '', 'form-control', 'input', 'http://localhost/', '', ''),
('dbname', 'yawk_lte', '', 13, 1, 1, 'DBNAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('dbport', '3306', '', 13, 6, 1, 'DBPORT_LABEL', '', '', '', 'form-control', 'input', 'default:3306', '', ''),
('dbprefix', 'cms_', '', 13, 5, 1, 'DBPREFIX_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('dbpwd', 'test', '', 13, 4, 1, 'DBPWD_LABEL', '', '', '', 'form-control', 'password', '', '', ''),
('dbusername', 'root', '', 13, 3, 1, 'DBUSERNAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('defaultemailtext', '', 'Hello $user,\\n\\n\\Thank you for registering on site\\n\\n$url', 5, 0, 1, 'Default SignUp Email Message', '', '', '', 'form-control', 'textarea', '', '', ''),
('dirprefix', '/yawk-LTE', '', 9, 0, 1, 'DIRPREFIX_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('domain', 'localhost.net', '', 1, 4, 1, 'DOMAIN_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('facebookstatus', '0', '', 4, 0, 1, 'Facebook on/off', '', '', '', 'form-control', '', '', '', ''),
('facebookurl', 'http://www.facebook.com', '', 4, 0, 1, 'URL zu Facebook Seite / Profil ', '', '', '', 'form-control', '', '', '', ''),
('frontendFX', '0', '', 3, 3, 1, 'FRONTENDFX_LABEL', '', '', '', 'form-control', '', '', '', ''),
('globalmenuid', '1', '', 3, 2, 1, 'GLOBALMENUID_LABEL', 'fa fa-bars', 'GLOBALMENUID_HEADING', 'GLOBALMENUID_SUBTEXT', 'form-control', 'select', '', 'GLOBALMENUID_DESC', ''),
('globalmetakeywords', 'YAWK, CMS, WORDPRESS, JOOMLA', '', 10, 0, 1, 'Global Site Keywords', '', '', '', 'form-control', '', '', '', ''),
('globalmetatext', 'YAWK DEVELOPMENT VERSION', '', 10, 0, 1, 'Global Meta Description', '', '', '', 'form-control', '', '', '', ''),
('host', 'http://192.168.1.8/yawk-LTE', '', 1, 3, 1, 'HOST_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('loadingTime', '0', '', 11, 3, 1, 'LOADINGTIME_LABEL', 'fa fa-signal', 'LOADINGTIME_HEADING', 'LOADINGTIME_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('logoutmenuid', '1', '', 6, 0, 1, 'Logout Menu ID for logged-in Users', '', '', '', 'form-control', '', '', '', ''),
('offline', '0', '', 8, 0, 1, 'OFFLINE_LABEL', 'fa fa-wrench', 'OFFLINE_HEADING', 'OFFLINE_SUBTEXT', 'form-control', 'checkbox', '', 'OFFLINE_DESC', ''),
('offlineimage', 'media/images/closed-sign-tm.jpg', '', 8, 0, 1, 'OFFLINEIMAGE_LABEL', '', '', '', 'form-control', 'input', 'media/images/logo.jpg', 'OFFLINEIMAGE_DESC', ''),
('offlinemsg', '<h1>Wartungsarbeiten</h1><h3>Bitte schau spÃ¤ter nochmal vorbei.</h3>', '', 8, 0, 1, 'OFFLINEMSG_LABEL', '', '', '', 'form-control', 'textarea', '', '', ''),
('selectedTemplate', '1', '', 3, 1, 1, 'SELECTEDTEMPLATE_LABEL', 'fa fa-photo', 'SELECTEDTEMPLATE_HEADING', 'SELECTEDTEMPLATE_SUBTEXT', 'form-control', 'select', '', 'SELECTEDTEMPLATE_DESC', ''),
('sessiontime', '60', '', 9, 1, 1, 'SESSIONTIME_LABEL', '', '', '', 'form-control', 'select', '', 'SESSIONTIME_DESC', '10,10 Minutes:20,20 Minutes:30,30 Minutes:40,40 Minutes:50,50 Minutes:60,60 Minutes:120,120 Minutes:320,320 Minutes'),
('signup_adultcheck', '0', '', 5, 0, 1, 'display adultcheck question before registration form', '', '', '', 'form-control', '', '', '', ''),
('signup_city', '0', '', 5, 0, 1, 'require city to signup', '', '', '', 'form-control', '', '', '', ''),
('signup_country', '0', '', 5, 0, 1, 'require country to signup', '', '', '', 'form-control', '', '', '', ''),
('signup_defaultgid', '2', '', 5, 0, 1, 'Default Group ID for new users', '', '', '', 'form-control', '', '', '', ''),
('signup_firstname', '0', '', 5, 0, 1, 'require firstname to signUp', '', '', '', 'form-control', '', '', '', ''),
('signup_gid', '1', '', 5, 0, 1, 'Adds a GroupID select field to SignUp Form', '', '', '', 'form-control', '', '', '', ''),
('signup_lastname', '0', '', 5, 0, 1, 'require lastname to signUp', '', '', '', 'form-control', '', '', '', ''),
('signup_layout', 'left', '', 5, 0, 1, 'Layout of User SignUp Form (left, right or plain)', '', '', '', 'form-control', '', '', '', ''),
('signup_legend0-long', '', '<h2>...fÃ¼r geladene GÃ¤ste <small>- become a VIP!</small></h2><p>\r\nDas bedeutet, dass Du an meinem exklusiven FSK-18 Members-Club teilnehmen kannst. Es erwarten Dich:\r\n\r\n<ul>\r\n<li class="fa fa-check"> geile Bilder</li><br>\r\n<li class="fa fa-check"> sexy Videos</li><br>\r\n<li class="fa fa-check"> private Einblicke</li><br>\r\n<li class="fa fa-check"> behind the scenes uvm...</li><br>\r\n</ul>\r\n\r\nVIP sein ist kostenlos und verpflichtet zu nichts.</p>\r\n<b>ABER ACHTUNG! Bitte beachte: Erst dann, wenn wir einander bereits persÃ¶nlich kennengelernt haben <u>und Du von mir via Email eine Einladung erhalten hast,</u> kannst Du dich hier anmelden.</b>', 5, 0, 1, 'signUp legend text', '', '', '', 'form-control', '', '', '', ''),
('signup_legend1-long', '', '<h2>SignUp as Guest</h2>', 5, 0, 1, 'signUp legend text', '', '', '', 'form-control', '', '', '', ''),
('signup_legend2-long', '', '<h2>SignUp as User <br><small>all the good things...</small></h2>\r\n<ul>\r\n<li>Item 1</li>\r\n<li>Item 2</li>\r\n<li>Item 3</li>\r\n</ul>', 5, 0, 1, 'signUp legend text', '', '', '', 'form-control', '', '', '', ''),
('signup_legend3-long', '', '<h2>SignUp as Provider</h2>', 5, 0, 1, 'signUp legend text', '', '', '', 'form-control', '', '', '', ''),
('signup_legend4-long', '', '<h2>SignUp as Admin</h2>', 5, 0, 1, 'signUp legend text', '', '', '', 'form-control', '', '', '', ''),
('signup_legend5-long', '', '<h2>SignUp as Root</h2>', 5, 0, 1, 'signUp legend text', '', '', '', 'form-control', '', '', '', ''),
('signup_street', '0', '', 5, 0, 1, 'require street to signUp', '', '', '', 'form-control', '', '', '', ''),
('signup_submitstyle', 'success', '', 5, 0, 1, 'success, error, warning, danger, info, default', '', '', '', 'form-control', '', '', '', ''),
('signup_submittext', 'SignUp', '', 5, 0, 1, 'Submit Button Text', '', '', '', 'form-control', '', '', '', ''),
('signup_terms-long', '', 'Please accept our terms of service!', 5, 0, 1, 'Terms of Service Text', '', '', '', 'form-control', '', '', '', ''),
('signup_title', '<h2>Signup as new user <small>be part of it.</small></h2>', '', 5, 0, 1, 'signup title', '', '', '', 'form-control', '', '', '', ''),
('signup_toscolor', 'A3A3A3', '', 5, 0, 1, 'terms of service color', '', '', '', 'form-control', '', '', '', ''),
('signup_tospage', 'terms-of-service', '', 5, 0, 1, 'terms of service filename', '', '', '', 'form-control', '', '', '', ''),
('signup_tostext', 'Terms of service', '', 5, 0, 1, 'terms of service description', '', '', '', 'form-control', '', '', '', ''),
('signup_zipcode', '0', '', 5, 0, 1, 'require zipcode to signup', '', '', '', 'form-control', '', '', '', ''),
('siteauthor', 'YaWK', '', 10, 0, 1, 'Site Author', '', '', '', 'form-control', '', '', '', ''),
('sitename', 'YaWK - yet another webkit - CMS', '', 1, 2, 1, 'SITENAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('timediff', '1', '', 7, 1, 1, 'TIMEDIFF_LABEL', 'fa fa-clock-o', 'TIMEDIFF_HEADING', 'TIMEDIFF_SUBTEXT', 'form-control', 'checkbox', '', 'TIMEDIFF_DESC', ''),
('timedifftext', 'This page is not online yet. Please come back in ', '', 7, 2, 1, 'TIMEDIFFTEXT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('title', 'YAWK DEMO', '', 1, 1, 1, 'TITLE_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('twitterstatus', '0', '', 4, 0, 1, 'Twitter on/off', '', '', '', 'form-control', '', '', '', ''),
('twitterurl', 'http://www.twitter.com', '', 4, 0, 1, 'URL zu Twitter Profil', '', '', '', 'form-control', '', '', '', ''),
('userpage_activeTab', 'Profile', '', 6, 0, 1, 'Userpage Active Tab', '', '', '', 'form-control', '', '', '', ''),
('userpage_admin', '1', '', 6, 0, 1, 'userpage admin tab enabled?', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeCity', '1', '', 6, 0, 1, 'allow user to change city', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeCountry', '1', '', 6, 0, 1, 'allow user to change country', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeEmail', '1', '', 6, 0, 1, 'allow user to change email adress', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeFacebook', '1', '', 6, 0, 1, 'allow user to change facebook link', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeFirstname', '1', '', 6, 0, 1, 'allow user to change firstname', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeLastname', '1', '', 6, 0, 1, 'allow user to change lastname', '', '', '', 'form-control', '', '', '', ''),
('userpage_changePassword', '1', '', 6, 0, 1, 'allow user to change password', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeState', '1', '', 6, 0, 1, 'allow user to change state', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeStreet', '1', '', 6, 0, 1, 'allow user to change street', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeTwitter', '1', '', 6, 0, 1, 'allow user to change twitter link', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeUrl', '1', '', 6, 0, 1, 'allow user to change website link', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeUsername', '1', '', 6, 0, 1, 'allow user to change the username', '', '', '', 'form-control', '', '', '', ''),
('userpage_changeZipcode', '1', '', 6, 0, 1, 'allow user to change zipcode', '', '', '', 'form-control', '', '', '', ''),
('userpage_dashboard', '1', '', 6, 0, 1, 'userpage dashboard tab enabled?', '', '', '', 'form-control', '', '', '', ''),
('userpage_hello', '1', '', 6, 0, 1, 'user greeting enabled?', '', '', '', 'form-control', '', '', '', ''),
('userpage_hellogroup', '0', '', 6, 0, 1, 'user group greeting enabled?', '', '', '', 'form-control', '', '', '', ''),
('userpage_hellotext', 'Hello', '', 6, 0, 1, 'user greeting', '', '', '', 'form-control', '', '', '', ''),
('userpage_hellotextsub', 'Welcome to your profile!', '', 6, 0, 1, 'user greeting subtext', '', '', '', 'form-control', '', '', '', ''),
('userpage_help', '1', '', 6, 0, 1, 'userpage help enabled?', '', '', '', 'form-control', '', '', '', ''),
('userpage_helptext', '', '<h2>User Help <small>this is the user help text</small></h2>\r\n<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>\r\n<h2>Second Headline <small>for more information</small></h2>\r\n<p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. </p>', 6, 0, 1, 'Userpage Help Text', '', '', '', 'form-control', '', '', '', ''),
('userpage_logoutmenu', '1', '', 6, 0, 1, 'enable logout menu section in globalmenu', '', '', '', 'form-control', '', '', '', ''),
('userpage_msgplugin', '1', '', 6, 0, 1, 'userpage message plugin tab enabled?', '', '', '', 'form-control', '', '', '', ''),
('userpage_profile', '1', '', 6, 0, 1, 'userpage profile enabled?', '', '', '', 'form-control', '', '', '', ''),
('userpage_settings', '1', '', 6, 0, 1, 'userpage`settings', '', '', '', 'form-control', '', '', '', ''),
('userpage_stats', '1', '', 6, 0, 1, 'userpage stats enabled?', '', '', '', 'form-control', '', '', '', ''),
('yawkversion', '0.6.0', '', 0, 2, 1, 'YAWKVERSION_LABEL', '', '', '', 'form-control', 'input', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_settings_types`
--

CREATE TABLE `cms_settings_types` (
  `id` int(11) NOT NULL,
  `value` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_settings_types`
--

INSERT INTO `cms_settings_types` (`id`, `value`) VALUES
(1, 'system'),
(2, 'backend'),
(3, 'frontend'),
(4, 'socialmedia'),
(5, 'plugin_signup'),
(6, 'plugin_userpage'),
(7, 'frontend-publish'),
(8, 'frontend-service'),
(9, 'server'),
(10, 'globalmeta'),
(11, 'backend-footer'),
(12, 'backend-menu'),
(13, 'database');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_syslog`
--

CREATE TABLE `cms_syslog` (
  `log_id` int(11) NOT NULL,
  `log_date` datetime NOT NULL,
  `log_type` int(11) NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL,
  `fromUID` int(11) NOT NULL DEFAULT '0',
  `toUID` int(11) NOT NULL DEFAULT '0',
  `toGID` int(11) NOT NULL DEFAULT '0',
  `seen` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_syslog_types`
--

CREATE TABLE `cms_syslog_types` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `property` varchar(255) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_syslog_types`
--

INSERT INTO `cms_syslog_types` (`id`, `active`, `property`, `icon`, `type`) VALUES
(1, 1, 'system', 'fa fa-wrench', 'text-orange'),
(2, 1, 'user', 'fa fa-user-plus', 'text-green'),
(3, 1, 'social', 'fa fa-facebook-official', 'text-blue'),
(4, 1, 'messaging', 'fa fa-envelope-o', 'text-green'),
(5, 1, 'warning', 'fa fa-exclamation-triangle', 'text-red');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_templates`
--

CREATE TABLE `cms_templates` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `positions` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `version` varchar(255) NOT NULL,
  `releaseDate` datetime NOT NULL,
  `author` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_templates`
--

INSERT INTO `cms_templates` (`id`, `active`, `name`, `positions`, `description`, `version`, `releaseDate`, `author`, `url`) VALUES
(1, 1, 'yawk-bootstrap3', 'menu:main:footer', '<b>Bootstrap 3 Theme</b> <small>SYSTEM DEFAULT THEME</SMALL>', '1.0.0', '2016-09-29 00:00:00', 'Daniel Retzl ', 'http://yawk.io'),
(2, 0, 'rosa', 'main', 'rosa', '', '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_template_settings`
--

CREATE TABLE `cms_template_settings` (
  `id` int(11) NOT NULL,
  `templateID` int(11) NOT NULL,
  `property` varchar(256) NOT NULL,
  `value` varchar(256) NOT NULL,
  `valueDefault` varchar(255) NOT NULL,
  `description` varchar(256) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL,
  `fieldClass` varchar(128) NOT NULL,
  `placeholder` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_template_settings`
--

INSERT INTO `cms_template_settings` (`id`, `templateID`, `property`, `value`, `valueDefault`, `description`, `activated`, `sort`, `fieldClass`, `placeholder`) VALUES
(1, 1, 'heading-gfont', '8', '1', 'Global GoogleFont ID', 1, 0, 'form-control', 'Default Google Font'),
(2, 1, 'menu-gfont', '8', '1', 'Menu GoogleFont ID', 1, 0, 'form-control', 'Menu Google Font'),
(3, 1, 'text-gfont', '7', '1', 'Text GoogleFont ID', 1, 0, 'form-control', 'Text Google Font'),
(4, 1, 'h1-fontcolor', '000000', '000000', 'H1 Color', 1, 0, 'color', 'pick a color or leave blank'),
(6, 1, 'h2-fontcolor', '000000', '000000', 'H2 Color', 1, 0, 'color', 'pick a color or leave blank'),
(7, 1, 'h3-fontcolor', '000000', '000000', 'H3 Color', 1, 0, 'color', 'pick a color or leave blank'),
(8, 1, 'h4-fontcolor', '000000', '000000', 'H4 Color', 1, 0, 'color', 'pick a color or leave blank'),
(9, 1, 'h5-fontcolor', '000000', '000000', 'H5 Color', 1, 0, 'color', 'pick a color or leave blank'),
(10, 1, 'h6-fontcolor', '000000', '000000', 'H6 Color', 1, 0, 'color', 'pick a color or leave blank'),
(11, 1, 'body-bg-color', '2B2B2A', 'FFFFFF', 'Body Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(14, 1, 'well-bg-color', 'F5F5F5', 'f5f5f5', 'Well Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(15, 1, 'smalltag-fontcolor', '777777', '777777', 'Small Tag Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(16, 1, 'font-menucolor', '777777', '777777', 'Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(17, 1, 'brand-menucolor', '777777', '777777', 'Brand Color', 1, 0, 'color', 'pick a color or leave blank'),
(18, 1, 'brandhover-menucolor', '5E5E5E', '5e5e5e', 'Brand Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(19, 1, 'fonthover-menucolor', '333333', '333333', 'Font Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(22, 1, 'fontactive-menucolor', '555555', '555555', 'Font Active Color', 1, 0, 'color', 'pick a color or leave blank'),
(23, 1, 'fontdisabled-menucolor', 'CCCCCC', 'cccccc', 'Font Disabled Color', 1, 0, 'color', 'pick a color or leave blank'),
(24, 1, 'default-menubgcolor', 'F8F8F8', 'f8f8f8', 'Default Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(25, 1, 'border-menubgcolor', 'E7E7E7', 'e7e7e7', 'Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(26, 1, 'active-menubgcolor', 'E7E7E7', 'e7e7e7', 'Active Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(27, 1, 'toggle-menubgcolor', 'DDDDDD', 'dddddd', 'Toggle Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(28, 1, 'iconbar-menubgcolor', '888888', '888888', 'IconBar Color', 1, 0, 'color', 'pick a color or leave blank'),
(29, 1, 'background-menudropdowncolor', 'FFFFFF', 'ffffff', 'Dropdown Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(30, 1, 'border-menudropdowncolor', 'CCCCCC', 'cccccc', 'Dropdown Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(31, 1, 'font-menudropdowncolor', '333333', '333333', 'Dropdown Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(32, 1, 'fonthover-menudropdowncolor', '262626', '262626', 'Dropdown Font Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(33, 1, 'hoverbg-menudropdowncolor', 'F5F5F5', 'f5f5f5', 'Hover Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(34, 1, 'fontactive-menudropdowncolor', 'FFFFFF', 'ffffff', 'Dropdown Font Active Color', 1, 0, 'color', 'pick a color or leave blank'),
(35, 1, 'activebg-menudropdowncolor', '337AB7', '337ab7', 'Dropdown Active Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(36, 1, 'disabled-menudropdowncolor', '777777', '777777', 'Dropdown Font Disabled Color', 1, 0, 'color', 'pick a color or leave blank'),
(37, 1, 'a-link', '337AB7', '337ab7', 'Link Color', 1, 0, 'color', 'pick a color or leave blank'),
(38, 1, 'visited-link', '337AB7', '337ab7', 'Visited Link', 1, 0, 'color', 'pick a color or leave blank'),
(39, 1, 'hover-link', '23527C', '23527c', 'Link Hover Cover', 1, 0, 'color', 'pick a color or leave blank'),
(40, 1, 'decoration-link', 'none', 'none', 'Link Decoration', 1, 0, 'form-control', 'none'),
(41, 1, 'hoverdecoration-link', 'underline', 'underline', 'Hover Decoration', 1, 0, 'form-control', 'underline'),
(42, 1, 'buttontext-link', 'FFFFFF', 'ffffff', 'Button Text Color', 1, 0, 'color', 'pick a color or leave blank'),
(43, 1, 'background-listgroup', 'FFFFFF', 'ffffff', 'List Group Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(44, 1, 'fontcolor-listgroup', '000000', '000000', 'Font Color List Group', 1, 0, 'color', 'pick a color or leave blank'),
(45, 1, 'text-fontcolor', '333333', '333333', 'Text Color', 1, 0, 'color', 'pick a color or leave blank'),
(46, 1, 'fontshadow-menucolor', 'CCCCCC', '#CCCCCC', 'Menu Text Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(47, 1, 'form-valid', '009900', '009900', 'Form Valid Color', 1, 0, 'color', 'pick a color or leave blank'),
(48, 1, 'form-error', 'FF0000', 'FF0000', 'Form Error Color', 1, 0, 'color', 'pick a color or leave blank'),
(49, 1, 'body-text-shadow', '1px 0px', '1px 0px', 'Body Text Shadow Thickness', 1, 0, 'form-control', 'shadow size in pixels'),
(50, 1, 'body-text-shadow-color', 'FFFFFF', 'CCCCCC', 'Body Text Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(51, 1, 'body-text-size', '1.7em', '1.7em', 'Body Font Size', 1, 0, 'form-control', 'size in 1.7em or 16px (for example)'),
(52, 1, 'body-margin-top', '40px', '40px', 'Body Top Margin', 1, 0, 'form-control', 'value in px e.g. 40px'),
(53, 1, 'body-bg-image', '', 'any .jpg or .png you want', 'Body Background Image', 1, 0, 'form-control', 'media/images/background.jpg'),
(54, 1, 'body-bg-repeat', 'no-repeat', 'no-repeat', 'Body Background Repeat', 1, 0, 'form-control', 'repeat, repeat-x, repeat-y, no-repeat, inherit'),
(55, 1, 'body-bg-position', 'center', 'center', 'Body Background Position', 1, 0, 'form-control', 'left-center, right-center, top-center, [top, bottom]'),
(56, 1, 'body-bg-attachment', 'fixed', 'fixed', 'Body Background Attach', 1, 0, 'form-control', 'scroll, fixed, local, initial, inherit'),
(57, 1, 'body-bg-size', 'cover', 'cover', 'Body Background Size', 1, 0, 'form-control', 'auto, cover, length, percentage, initial, inherit'),
(58, 1, 'main-box-shadow', '6px 12px 16px 0px', '6px 12px 6px', 'Main Box Shadow', 1, 0, 'form-control', 'eg. 3px 6px 3px'),
(59, 1, 'main-box-shadow-color', '474747', 'E8E8E8', 'Main Box Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(60, 1, 'well-min-height', '20px', '20px', 'Well Minimum Height', 1, 0, 'form-control', 'value in px eg. 20px'),
(61, 1, 'well-padding', '20px', '19px', 'Well padding', 1, 0, 'form-control', 'value in px eg. 20px'),
(62, 1, 'well-margin-top', '0px', '0px', 'Well Margin Top', 1, 0, 'form-control', 'value in px eg. 10px'),
(63, 1, 'well-margin-bottom', '0px', '0px', 'Well Margin Bottom', 1, 0, 'form-control', 'value in px eg. 10px'),
(64, 1, 'well-border', '0px solid', '1px solid', 'Well Border Style', 1, 0, 'form-control', 'value in px eg. 1px solid'),
(65, 1, 'well-border-color', 'E0E0E0', 'e3e3e3', 'Well Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(66, 1, 'well-border-radius', '0px', '0px', 'Well Border Radius', 1, 0, 'form-control', 'for rounded edges, value in px eg. 4px'),
(67, 1, 'well-shadow', '2px 2px 5px 6px', '3px 3px 5px 6px', 'Well Shadow', 1, 0, 'form-control', 'value in px eg. x,y,blur,spread'),
(68, 1, 'well-shadow-color', 'DBDBDB', 'CCCCCC', 'Well Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(69, 1, 'h1-size', '36px', '36px', 'H1 Text Size', 1, 0, 'form-control', 'size in px eg. 36px'),
(70, 1, 'h2-size', '30px', '30px', 'H2 Text Size', 1, 0, 'form-control', 'size in px eg. 30px'),
(71, 1, 'h3-size', '24px', '24px', 'H3 Text Size', 1, 0, 'form-control', 'size in px eg. 24px'),
(72, 1, 'h4-size', '18px', '18px', 'H4 Text Size', 1, 0, 'form-control', 'size in px eg. 18px'),
(73, 1, 'h5-size', '14px', '14px', 'H5 Text Size', 1, 0, 'form-control', 'size in px eg. 14px'),
(74, 1, 'h6-size', '12px', '12px', 'H6 Text Size', 1, 0, 'form-control', 'size in px eg. 12px'),
(75, 1, 'btn-fontsize', '14px', '14px', 'Button Fontsize', 1, 0, 'form-control', 'size in px eg. 12px'),
(76, 1, 'btn-font-weight', 'normal', 'normal', 'Button Font Weight', 1, 0, 'form-control', 'normal or bold'),
(77, 1, 'btn-border', '1px', '1px', 'Button Border', 1, 0, 'form-control', 'value in px eg. 1px'),
(78, 1, 'btn-border-style', 'solid', 'solid', 'Button Border Style', 1, 0, 'form-control', 'solid, dotted, dashed'),
(79, 1, 'btn-border-radius', '4px', '4px', 'Button Border Radius', 1, 0, 'form-control', 'value in px eg. 4px'),
(80, 1, 'btn-default-color', '333333', '333333', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(81, 1, 'btn-default-background-color', 'FFFFFF', 'FFFFFF', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(82, 1, 'btn-default-border-color', 'CCCCCC', 'CCCCCC', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(83, 1, 'btn-default-focus-background-color', 'E6E6E6', 'E6E6E6', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(84, 1, 'btn-default-focus-border-color', '8C8C8C', '8C8C8C', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(85, 1, 'btn-default-hover-color', '333333', '333333', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(86, 1, 'btn-default-hover-background-color', 'E6E6E6', 'E6E6E6', ':hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(87, 1, 'btn-default-hover-border-color', 'ADADAD', 'ADADAD', ':hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(88, 1, 'btn-primary-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(89, 1, 'btn-primary-background-color', '337AB7', '337ab7', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(90, 1, 'btn-primary-border-color', '2E6DA4', '2e6da4', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(91, 1, 'btn-primary-focus-background-color', '286090', '286090', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(92, 1, 'btn-primary-focus-border-color', '122B40', '122b40', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(93, 1, 'btn-primary-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(94, 1, 'btn-primary-hover-background-color', '286090', '286090', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(95, 1, 'btn-primary-hover-border-color', '204D74', '204d74', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(96, 1, 'btn-success-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(97, 1, 'btn-success-background-color', '5CB85C', '5cb85c', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(98, 1, 'btn-success-border-color', '4CAE4C', '4cae4c', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(99, 1, 'btn-success-focus-background-color', '449D44', '449d44', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(100, 1, 'btn-success-focus-border-color', '255625', '255625', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(101, 1, 'btn-success-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(102, 1, 'btn-success-hover-background-color', '449D44', '449d44', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(103, 1, 'btn-success-hover-border-color', '398439', '398439', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(104, 1, 'btn-info-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(105, 1, 'btn-info-background-color', '5BC0DE', '5bc0de', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(106, 1, 'btn-info-border-color', '46B8DA', '46b8da', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(107, 1, 'btn-info-focus-background-color', '31B0D5', '31b0d5', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(108, 1, 'btn-info-focus-border-color', '1B6D85', '1b6d85', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(109, 1, 'btn-info-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(110, 1, 'btn-info-hover-background-color', '31B0D5', '31b0d5', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(111, 1, 'btn-info-hover-border-color', '269ABC', '269abc', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(112, 1, 'btn-warning-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(113, 1, 'btn-warning-background-color', 'F0AD4E', 'f0ad4e', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(114, 1, 'btn-warning-border-color', 'EEA236', 'eea236', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(115, 1, 'btn-warning-focus-background-color', 'EC971F', 'ec971f', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(116, 1, 'btn-warning-focus-border-color', '985F0D', '985f0d', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(117, 1, 'btn-warning-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(118, 1, 'btn-warning-hover-background-color', 'EC971F', 'ec971f', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(119, 1, 'btn-warning-hover-border-color', 'D58512', 'd58512', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(120, 1, 'btn-danger-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(121, 1, 'btn-danger-background-color', 'D9534F', 'd9534f', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(122, 1, 'btn-danger-border-color', 'D43F3A', 'd43f3a', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(123, 1, 'btn-danger-focus-background-color', 'C9302C', 'c9302c', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(124, 1, 'btn-danger-focus-border-color', '761C19', '761c19', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(125, 1, 'btn-danger-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(126, 1, 'btn-danger-hover-background-color', 'C9302C', 'c9302c', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(127, 1, 'btn-danger-hover-border-color', 'AC2925', 'ac2925', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(128, 1, 'body-margin-bottom', '0px', '0px', 'Body Bottom Margin', 1, 0, 'form-control', 'value in px e.g. 0px'),
(129, 1, 'body-margin-left', '0px', '0px', 'Body Left Margin', 1, 0, 'form-control', 'value in px e.g. 0px'),
(130, 1, 'body-margin-right', '0px', '0px', 'Body Right Margin', 1, 0, 'form-control', 'value in px e.g. 0px'),
(131, 1, 'img-shadow', '2px 2px 12px 2px', '2px 2px 12px 2px', 'Image Shadow', 1, 0, 'form-control', 'value in px e.g. 2px 2px 12px 2px'),
(132, 1, 'img-shadow-color', 'A8A8A8', '0A0A0A', 'Image Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(133, 1, 'img-righty', '7deg', '7deg', 'Angle to Right', 1, 0, 'form-control', 'value in degree e.g. 7deg'),
(134, 1, 'img-lefty', '-7deg', '-7deg', 'Angle to Left', 1, 0, 'form-control', 'value in degree e.g. -7deg'),
(135, 1, 'img-righty-less', '4deg', '4deg', 'Lesser Angle to Right', 1, 0, 'form-control', 'value in degree e.g. 4deg'),
(136, 1, 'img-lefty-less', '-4deg', '-4deg', 'Lesser Angle to Left', 1, 0, 'form-control', 'value in degree e.g. -4deg'),
(137, 1, 'img-brightness', '110%', '110%', 'Brightness On Hover', 1, 0, 'form-control', 'value in percent eg. 110%'),
(8817, 2, 'heading-gfont', '8', '1', 'Global GoogleFont ID', 1, 0, 'form-control', 'Default Google Font'),
(8818, 2, 'menu-gfont', '8', '1', 'Menu GoogleFont ID', 1, 0, 'form-control', 'Menu Google Font'),
(8819, 2, 'text-gfont', '7', '1', 'Text GoogleFont ID', 1, 0, 'form-control', 'Text Google Font'),
(8820, 2, 'h1-fontcolor', '000000', '000000', 'H1 Color', 1, 0, 'color', 'pick a color or leave blank'),
(8821, 2, 'h2-fontcolor', '000000', '000000', 'H2 Color', 1, 0, 'color', 'pick a color or leave blank'),
(8822, 2, 'h3-fontcolor', '000000', '000000', 'H3 Color', 1, 0, 'color', 'pick a color or leave blank'),
(8823, 2, 'h4-fontcolor', '000000', '000000', 'H4 Color', 1, 0, 'color', 'pick a color or leave blank'),
(8824, 2, 'h5-fontcolor', '000000', '000000', 'H5 Color', 1, 0, 'color', 'pick a color or leave blank'),
(8825, 2, 'h6-fontcolor', '000000', '000000', 'H6 Color', 1, 0, 'color', 'pick a color or leave blank'),
(8826, 2, 'body-bg-color', 'DE909B', 'FFFFFF', 'Body Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(8827, 2, 'well-bg-color', 'FFA6B2', 'f5f5f5', 'Well Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(8828, 2, 'smalltag-fontcolor', '777777', '777777', 'Small Tag Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(8829, 2, 'font-menucolor', '777777', '777777', 'Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(8830, 2, 'brand-menucolor', '777777', '777777', 'Brand Color', 1, 0, 'color', 'pick a color or leave blank'),
(8831, 2, 'brandhover-menucolor', '5E5E5E', '5e5e5e', 'Brand Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(8832, 2, 'fonthover-menucolor', '333333', '333333', 'Font Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(8833, 2, 'fontactive-menucolor', '555555', '555555', 'Font Active Color', 1, 0, 'color', 'pick a color or leave blank'),
(8834, 2, 'fontdisabled-menucolor', 'CCCCCC', 'cccccc', 'Font Disabled Color', 1, 0, 'color', 'pick a color or leave blank'),
(8835, 2, 'default-menubgcolor', 'F8F8F8', 'f8f8f8', 'Default Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(8836, 2, 'border-menubgcolor', 'E7E7E7', 'e7e7e7', 'Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(8837, 2, 'active-menubgcolor', 'E7E7E7', 'e7e7e7', 'Active Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(8838, 2, 'toggle-menubgcolor', 'DDDDDD', 'dddddd', 'Toggle Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(8839, 2, 'iconbar-menubgcolor', '888888', '888888', 'IconBar Color', 1, 0, 'color', 'pick a color or leave blank'),
(8840, 2, 'background-menudropdowncolor', 'FFFFFF', 'ffffff', 'Dropdown Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(8841, 2, 'border-menudropdowncolor', 'CCCCCC', 'cccccc', 'Dropdown Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(8842, 2, 'font-menudropdowncolor', '333333', '333333', 'Dropdown Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(8843, 2, 'fonthover-menudropdowncolor', '262626', '262626', 'Dropdown Font Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(8844, 2, 'hoverbg-menudropdowncolor', 'F5F5F5', 'f5f5f5', 'Hover Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(8845, 2, 'fontactive-menudropdowncolor', 'FFFFFF', 'ffffff', 'Dropdown Font Active Color', 1, 0, 'color', 'pick a color or leave blank'),
(8846, 2, 'activebg-menudropdowncolor', '337AB7', '337ab7', 'Dropdown Active Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(8847, 2, 'disabled-menudropdowncolor', '777777', '777777', 'Dropdown Font Disabled Color', 1, 0, 'color', 'pick a color or leave blank'),
(8848, 2, 'a-link', '337AB7', '337ab7', 'Link Color', 1, 0, 'color', 'pick a color or leave blank'),
(8849, 2, 'visited-link', '337AB7', '337ab7', 'Visited Link', 1, 0, 'color', 'pick a color or leave blank'),
(8850, 2, 'hover-link', '23527C', '23527c', 'Link Hover Cover', 1, 0, 'color', 'pick a color or leave blank'),
(8851, 2, 'decoration-link', 'none', 'none', 'Link Decoration', 1, 0, 'form-control', 'none'),
(8852, 2, 'hoverdecoration-link', 'underline', 'underline', 'Hover Decoration', 1, 0, 'form-control', 'underline'),
(8853, 2, 'buttontext-link', 'FFFFFF', 'ffffff', 'Button Text Color', 1, 0, 'color', 'pick a color or leave blank'),
(8854, 2, 'background-listgroup', 'FFFFFF', 'ffffff', 'List Group Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(8855, 2, 'fontcolor-listgroup', '000000', '000000', 'Font Color List Group', 1, 0, 'color', 'pick a color or leave blank'),
(8856, 2, 'text-fontcolor', '333333', '333333', 'Text Color', 1, 0, 'color', 'pick a color or leave blank'),
(8857, 2, 'fontshadow-menucolor', 'CCCCCC', '#CCCCCC', 'Menu Text Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(8858, 2, 'form-valid', '009900', '009900', 'Form Valid Color', 1, 0, 'color', 'pick a color or leave blank'),
(8859, 2, 'form-error', 'FF0000', 'FF0000', 'Form Error Color', 1, 0, 'color', 'pick a color or leave blank'),
(8860, 2, 'body-text-shadow', '1px 0px', '1px 0px', 'Body Text Shadow Thickness', 1, 0, 'form-control', 'shadow size in pixels'),
(8861, 2, 'body-text-shadow-color', 'FFFFFF', 'CCCCCC', 'Body Text Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(8862, 2, 'body-text-size', '1.7em', '1.7em', 'Body Font Size', 1, 0, 'form-control', 'size in 1.7em or 16px (for example)'),
(8863, 2, 'body-margin-top', '40px', '40px', 'Body Top Margin', 1, 0, 'form-control', 'value in px e.g. 40px'),
(8864, 2, 'body-bg-image', '', 'any .jpg or .png you want', 'Body Background Image', 1, 0, 'form-control', 'media/images/background.jpg'),
(8865, 2, 'body-bg-repeat', 'no-repeat', 'no-repeat', 'Body Background Repeat', 1, 0, 'form-control', 'repeat, repeat-x, repeat-y, no-repeat, inherit'),
(8866, 2, 'body-bg-position', 'center', 'center', 'Body Background Position', 1, 0, 'form-control', 'left-center, right-center, top-center, [top, bottom]'),
(8867, 2, 'body-bg-attachment', 'fixed', 'fixed', 'Body Background Attach', 1, 0, 'form-control', 'scroll, fixed, local, initial, inherit'),
(8868, 2, 'body-bg-size', 'cover', 'cover', 'Body Background Size', 1, 0, 'form-control', 'auto, cover, length, percentage, initial, inherit'),
(8869, 2, 'main-box-shadow', '6px 12px 16px 0px', '6px 12px 6px', 'Main Box Shadow', 1, 0, 'form-control', 'eg. 3px 6px 3px'),
(8870, 2, 'main-box-shadow-color', '474747', 'E8E8E8', 'Main Box Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(8871, 2, 'well-min-height', '20px', '20px', 'Well Minimum Height', 1, 0, 'form-control', 'value in px eg. 20px'),
(8872, 2, 'well-padding', '20px', '19px', 'Well padding', 1, 0, 'form-control', 'value in px eg. 20px'),
(8873, 2, 'well-margin-top', '0px', '0px', 'Well Margin Top', 1, 0, 'form-control', 'value in px eg. 10px'),
(8874, 2, 'well-margin-bottom', '0px', '0px', 'Well Margin Bottom', 1, 0, 'form-control', 'value in px eg. 10px'),
(8875, 2, 'well-border', '0px solid', '1px solid', 'Well Border Style', 1, 0, 'form-control', 'value in px eg. 1px solid'),
(8876, 2, 'well-border-color', 'E0E0E0', 'e3e3e3', 'Well Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(8877, 2, 'well-border-radius', '0px', '0px', 'Well Border Radius', 1, 0, 'form-control', 'for rounded edges, value in px eg. 4px'),
(8878, 2, 'well-shadow', '2px 2px 5px 6px', '3px 3px 5px 6px', 'Well Shadow', 1, 0, 'form-control', 'value in px eg. x,y,blur,spread'),
(8879, 2, 'well-shadow-color', 'DBDBDB', 'CCCCCC', 'Well Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(8880, 2, 'h1-size', '36px', '36px', 'H1 Text Size', 1, 0, 'form-control', 'size in px eg. 36px'),
(8881, 2, 'h2-size', '30px', '30px', 'H2 Text Size', 1, 0, 'form-control', 'size in px eg. 30px'),
(8882, 2, 'h3-size', '24px', '24px', 'H3 Text Size', 1, 0, 'form-control', 'size in px eg. 24px'),
(8883, 2, 'h4-size', '18px', '18px', 'H4 Text Size', 1, 0, 'form-control', 'size in px eg. 18px'),
(8884, 2, 'h5-size', '14px', '14px', 'H5 Text Size', 1, 0, 'form-control', 'size in px eg. 14px'),
(8885, 2, 'h6-size', '12px', '12px', 'H6 Text Size', 1, 0, 'form-control', 'size in px eg. 12px'),
(8886, 2, 'btn-fontsize', '14px', '14px', 'Button Fontsize', 1, 0, 'form-control', 'size in px eg. 12px'),
(8887, 2, 'btn-font-weight', 'normal', 'normal', 'Button Font Weight', 1, 0, 'form-control', 'normal or bold'),
(8888, 2, 'btn-border', '1px', '1px', 'Button Border', 1, 0, 'form-control', 'value in px eg. 1px'),
(8889, 2, 'btn-border-style', 'solid', 'solid', 'Button Border Style', 1, 0, 'form-control', 'solid, dotted, dashed'),
(8890, 2, 'btn-border-radius', '4px', '4px', 'Button Border Radius', 1, 0, 'form-control', 'value in px eg. 4px'),
(8891, 2, 'btn-default-color', '333333', '333333', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8892, 2, 'btn-default-background-color', 'FFFFFF', 'FFFFFF', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8893, 2, 'btn-default-border-color', 'CCCCCC', 'CCCCCC', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8894, 2, 'btn-default-focus-background-color', 'E6E6E6', 'E6E6E6', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8895, 2, 'btn-default-focus-border-color', '8C8C8C', '8C8C8C', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8896, 2, 'btn-default-hover-color', '333333', '333333', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8897, 2, 'btn-default-hover-background-color', 'E6E6E6', 'E6E6E6', ':hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8898, 2, 'btn-default-hover-border-color', 'ADADAD', 'ADADAD', ':hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8899, 2, 'btn-primary-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8900, 2, 'btn-primary-background-color', '337AB7', '337ab7', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8901, 2, 'btn-primary-border-color', '2E6DA4', '2e6da4', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8902, 2, 'btn-primary-focus-background-color', '286090', '286090', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8903, 2, 'btn-primary-focus-border-color', '122B40', '122b40', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8904, 2, 'btn-primary-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8905, 2, 'btn-primary-hover-background-color', '286090', '286090', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8906, 2, 'btn-primary-hover-border-color', '204D74', '204d74', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8907, 2, 'btn-success-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8908, 2, 'btn-success-background-color', '5CB85C', '5cb85c', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8909, 2, 'btn-success-border-color', '4CAE4C', '4cae4c', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8910, 2, 'btn-success-focus-background-color', '449D44', '449d44', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8911, 2, 'btn-success-focus-border-color', '255625', '255625', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8912, 2, 'btn-success-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8913, 2, 'btn-success-hover-background-color', '449D44', '449d44', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8914, 2, 'btn-success-hover-border-color', '398439', '398439', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8915, 2, 'btn-info-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8916, 2, 'btn-info-background-color', '5BC0DE', '5bc0de', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8917, 2, 'btn-info-border-color', '46B8DA', '46b8da', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8918, 2, 'btn-info-focus-background-color', '31B0D5', '31b0d5', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8919, 2, 'btn-info-focus-border-color', '1B6D85', '1b6d85', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8920, 2, 'btn-info-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8921, 2, 'btn-info-hover-background-color', '31B0D5', '31b0d5', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8922, 2, 'btn-info-hover-border-color', '269ABC', '269abc', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8923, 2, 'btn-warning-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8924, 2, 'btn-warning-background-color', 'F0AD4E', 'f0ad4e', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8925, 2, 'btn-warning-border-color', 'EEA236', 'eea236', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8926, 2, 'btn-warning-focus-background-color', 'EC971F', 'ec971f', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8927, 2, 'btn-warning-focus-border-color', '985F0D', '985f0d', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8928, 2, 'btn-warning-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8929, 2, 'btn-warning-hover-background-color', 'EC971F', 'ec971f', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8930, 2, 'btn-warning-hover-border-color', 'D58512', 'd58512', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8931, 2, 'btn-danger-color', 'FFFFFF', 'FFFFFF', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8932, 2, 'btn-danger-background-color', 'D9534F', 'd9534f', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8933, 2, 'btn-danger-border-color', 'D43F3A', 'd43f3a', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8934, 2, 'btn-danger-focus-background-color', 'C9302C', 'c9302c', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8935, 2, 'btn-danger-focus-border-color', '761C19', '761c19', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8936, 2, 'btn-danger-hover-color', 'FFFFFF', 'FFFFFF', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(8937, 2, 'btn-danger-hover-background-color', 'C9302C', 'c9302c', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(8938, 2, 'btn-danger-hover-border-color', 'AC2925', 'ac2925', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(8939, 2, 'body-margin-bottom', '0px', '0px', 'Body Bottom Margin', 1, 0, 'form-control', 'value in px e.g. 0px'),
(8940, 2, 'body-margin-left', '0px', '0px', 'Body Left Margin', 1, 0, 'form-control', 'value in px e.g. 0px'),
(8941, 2, 'body-margin-right', '0px', '0px', 'Body Right Margin', 1, 0, 'form-control', 'value in px e.g. 0px'),
(8942, 2, 'img-shadow', '2px 2px 12px 2px', '2px 2px 12px 2px', 'Image Shadow', 1, 0, 'form-control', 'value in px e.g. 2px 2px 12px 2px'),
(8943, 2, 'img-shadow-color', 'A8A8A8', '0A0A0A', 'Image Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(8944, 2, 'img-righty', '7deg', '7deg', 'Angle to Right', 1, 0, 'form-control', 'value in degree e.g. 7deg'),
(8945, 2, 'img-lefty', '-7deg', '-7deg', 'Angle to Left', 1, 0, 'form-control', 'value in degree e.g. -7deg'),
(8946, 2, 'img-righty-less', '4deg', '4deg', 'Lesser Angle to Right', 1, 0, 'form-control', 'value in degree e.g. 4deg'),
(8947, 2, 'img-lefty-less', '-4deg', '-4deg', 'Lesser Angle to Left', 1, 0, 'form-control', 'value in degree e.g. -4deg'),
(8948, 2, 'img-brightness', '110%', '110%', 'Brightness On Hover', 1, 0, 'form-control', 'value in percent eg. 110%');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_users`
--

CREATE TABLE `cms_users` (
  `id` int(11) NOT NULL,
  `blocked` int(1) NOT NULL DEFAULT '0',
  `privacy` int(1) NOT NULL DEFAULT '0',
  `online` int(1) NOT NULL DEFAULT '0',
  `gid` int(11) NOT NULL DEFAULT '4',
  `terms` int(1) NOT NULL DEFAULT '1',
  `username` varchar(48) NOT NULL,
  `password` varchar(48) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_changed` datetime NOT NULL,
  `date_expired` datetime NOT NULL,
  `date_lastlogin` datetime NOT NULL,
  `login_count` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `url` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `street` varchar(128) NOT NULL,
  `zipcode` varchar(12) NOT NULL,
  `city` varchar(128) NOT NULL,
  `country` varchar(128) NOT NULL,
  `state` varchar(128) NOT NULL,
  `logged_in` int(1) NOT NULL DEFAULT '0',
  `public_email` int(1) NOT NULL DEFAULT '0',
  `terminatedByUser` int(1) NOT NULL DEFAULT '0',
  `job` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `overrideTemplate` int(1) NOT NULL,
  `templateID` int(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_users`
--

INSERT INTO `cms_users` (`id`, `blocked`, `privacy`, `online`, `gid`, `terms`, `username`, `password`, `date_created`, `date_changed`, `date_expired`, `date_lastlogin`, `login_count`, `email`, `url`, `twitter`, `facebook`, `firstname`, `lastname`, `street`, `zipcode`, `city`, `country`, `state`, `logged_in`, `public_email`, `terminatedByUser`, `job`, `likes`, `overrideTemplate`, `templateID`) VALUES
(1, 0, 1, 1, 5, 1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', '2016-09-10 00:00:00', '2016-09-15 00:44:24', '0000-00-00 00:00:00', '2016-09-29 22:06:22', 185, 'danielretzl@gmail.com', 'http://yawk.website', 'https://www.twitter.com/danielretzl', 'https://www.facebook.com/dretzl', 'Daniel', 'Retzl', '', '', '', '', '', 1, 1, 0, 'YaWK Main Developer', 0, 0, 1),
(2, 0, 0, 1, 4, 1, 'claudia', '827ccb0eea8a706c4c34a16891f84e7b', '2016-09-13 13:54:26', '2016-09-29 00:19:20', '0000-00-00 00:00:00', '2016-09-30 07:58:13', 13, 'test@test.com', '', '', '', '', '', '', '', '', '', '', 1, 0, 0, '', 0, 0, 2),
(3, 0, 0, 0, 2, 1, 'tux', '81dc9bdb52d04dc20036dbd8313ed055', '2016-09-13 13:55:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'tux@yourdomain.com', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 0, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_user_groups`
--

CREATE TABLE `cms_user_groups` (
  `id` int(11) NOT NULL,
  `value` varchar(32) NOT NULL,
  `color` varchar(64) NOT NULL,
  `signup_allowed` int(1) NOT NULL DEFAULT '0',
  `backend_allowed` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_user_groups`
--

INSERT INTO `cms_user_groups` (`id`, `value`, `color`, `signup_allowed`, `backend_allowed`) VALUES
(1, 'Guest', 'success', 1, 0),
(2, 'User', 'info', 1, 0),
(3, 'Moderator', 'warning', 1, 1),
(4, 'Administrator', 'warning', 0, 1),
(5, 'Root', 'danger', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_widgets`
--

CREATE TABLE `cms_widgets` (
  `id` int(11) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `widgetType` int(11) NOT NULL,
  `pageID` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `position` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_widgets`
--

INSERT INTO `cms_widgets` (`id`, `published`, `widgetType`, `pageID`, `sort`, `position`) VALUES
(1, 1, 1, 1, 1, 'footer'),
(2, 1, 9, 3, 2, 'main');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_widget_defaults`
--

CREATE TABLE `cms_widget_defaults` (
  `property` varchar(256) NOT NULL,
  `value` text NOT NULL,
  `widgetType` int(11) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '1',
  `description` varchar(256) NOT NULL,
  `fieldClass` varchar(128) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_widget_defaults`
--

INSERT INTO `cms_widget_defaults` (`property`, `value`, `widgetType`, `activated`, `description`, `fieldClass`, `ID`) VALUES
('buttontitle', 'Login', 1, 1, 'Beschriftung des Login Buttons', 'form-control', 1),
('width', '450', 4, 1, 'Breite der Like Box', 'form-control', 2),
('height', '65', 4, 1, 'Höhe der Like Box', 'form-control', 3),
('fbpageurl', 'http://www.facebook.com/platform', 4, 1, 'Facebook Page URL', 'form-control', 4),
('fbappID', '100710516666226', 4, 1, 'Facebook App ID', 'form-control', 5),
('width', '450', 5, 1, 'Breite des Like Button', 'form-control', 6),
('height', '35', 5, 1, 'Höhe des Like Button', 'form-control', 7),
('fblikeurl', 'http://www.facebook.com/platform', 5, 1, 'URL to Like', 'form-control', 8),
('fbappID', '100710516666226', 5, 1, 'Facebook App ID', 'form-control', 9),
('colorscheme', 'light', 5, 1, 'Farbschema (light or dark)', 'form-control', 10),
('preziID', '', 3, 1, 'The ID of Your Prezi (eg: prezi_123456789)', 'form-control', 11),
('width', '900', 3, 1, 'width of your prezi box', 'form-control', 12),
('height', '400', 3, 1, 'height of your prezi box', 'form-control', 13),
('allowfullscreen', 'true', 3, 1, 'enable fullscreen - true or false', 'form-control', 14),
('bgcolor', 'ffffff', 3, 1, 'The background color of your prezi', 'color', 15),
('autoplay', 'yes', 3, 1, 'autoplay yes or no', 'form-control', 16),
('autohidectrl', '0', 3, 1, 'automatically hide controlls 0 or 1', 'form-control', 17),
('trackingcode', 'UA-0000000-00', 6, 1, 'Tracking Code (eg. UA-0000000-00)', 'form-control', 18),
('colorscheme', 'dark', 4, 1, 'Colorscheme (light / dark)', 'form-control', 19),
('x_offset', '0', 4, 1, 'Offset, X-Axsis', 'form-control', 20),
('y_offset', '0', 4, 1, 'Offset, Y-Axsis', 'form-control', 21),
('float', 'right', 4, 1, 'left / right, or leave blank', 'form-control', 22),
('clockcolor', '999', 8, 1, 'Clock Text Color', 'form-control color', 23),
('float', 'right', 8, 1, 'Float (left / right or leave blank)', 'form-control', 24),
('textstyle', 'bold', 8, 1, 'bold or leave blank', 'form-control', 25),
('htmlcode', '<div class="row">\r\n        <div class="col-md-4">\r\n          <h2>Heading</h2>\r\n          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\r\n          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>\r\n        </div>\r\n        <div class="col-md-4">\r\n          <h2>Heading</h2>\r\n          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\r\n          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>\r\n       </div>\r\n        <div class="col-md-4">\r\n          <h2>Heading</h2>\r\n          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\r\n          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>\r\n        </div>\r\n      </div>', 11, 1, 'Custom HTML in a divbox', 'form-control', 27);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_widget_settings`
--

CREATE TABLE `cms_widget_settings` (
  `id` int(11) NOT NULL,
  `widgetID` int(11) NOT NULL,
  `property` varchar(256) NOT NULL,
  `value` text NOT NULL,
  `widgetType` int(11) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_widget_settings`
--

INSERT INTO `cms_widget_settings` (`id`, `widgetID`, `property`, `value`, `widgetType`, `activated`) VALUES
(1, 2, 'trackingcode', 'UA-69471720-1', 6, 1),
(12, 4, 'htmlcode', '<div class="row">\r\n        <div class="col-md-4">\r\n          <h2>Heading</h2>\r\n          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. ', 11, 1),
(13, 9, 'clockcolor', '999999', 8, 1),
(14, 10, 'clockcolor', '', 8, 1),
(15, 9, 'clockcolor', '999999', 8, 1),
(16, 10, 'clockcolor', '999', 8, 1),
(17, 9, 'clockcolor', '999999', 8, 1),
(18, 9, 'clockcolor', '999999', 8, 1),
(19, 9, 'clockcolor', '999999', 8, 1),
(20, 9, 'clockcolor', '999999', 8, 1),
(21, 9, 'clockcolor', '999', 8, 1),
(22, 9, 'clockcolor', '999', 8, 1),
(23, 1, 'buttontitle', 'Login', 1, 1),
(24, 3, 'clockcolor', '999', 8, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_widget_types`
--

CREATE TABLE `cms_widget_types` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `folder` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_widget_types`
--

INSERT INTO `cms_widget_types` (`id`, `name`, `folder`) VALUES
(1, 'Loginbox', 'loginbox'),
(2, 'Simple Contact Form', 'form_simple'),
(3, 'Prezi', 'prezi'),
(4, 'FacebookBox', 'fb_box'),
(5, 'FacebookLike', 'fb_like'),
(6, 'GoogleAnalytics', 'google_analytics'),
(7, 'SimpleUpload', 'simple_upload'),
(8, 'Clock', 'clock'),
(9, 'Signup', 'signup'),
(10, 'Slider', 'slider'),
(11, 'Divbox', 'divbox'),
(12, 'Header', 'header'),
(13, 'Divbox 2', 'divbox2'),
(14, 'News Blog Widget', 'news'),
(15, 'Newsletter', 'newsletter');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cms_blog`
--
ALTER TABLE `cms_blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `cms_blog_comments`
--
ALTER TABLE `cms_blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `cms_blog_items`
--
ALTER TABLE `cms_blog_items`
  ADD PRIMARY KEY (`primkey`);

--
-- Indizes für die Tabelle `cms_follower`
--
ALTER TABLE `cms_follower`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`follower`,`hunted`);

--
-- Indizes für die Tabelle `cms_friends`
--
ALTER TABLE `cms_friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`friendA`,`friendB`,`confirmed`,`aborted`);

--
-- Indizes für die Tabelle `cms_gfonts`
--
ALTER TABLE `cms_gfonts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_logins`
--
ALTER TABLE `cms_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_menu`
--
ALTER TABLE `cms_menu`
  ADD PRIMARY KEY (`TMPID`),
  ADD KEY `id` (`id`,`sort`,`gid`,`menuID`,`parentID`,`published`,`date_created`,`date_changed`,`date_publish`,`date_unpublish`,`title`,`href`),
  ADD KEY `id_2` (`id`),
  ADD KEY `id_3` (`id`);

--
-- Indizes für die Tabelle `cms_menu_names`
--
ALTER TABLE `cms_menu_names`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_meta_global`
--
ALTER TABLE `cms_meta_global`
  ADD PRIMARY KEY (`name`);

--
-- Indizes für die Tabelle `cms_meta_local`
--
ALTER TABLE `cms_meta_local`
  ADD PRIMARY KEY (`name`,`page`);

--
-- Indizes für die Tabelle `cms_notifications`
--
ALTER TABLE `cms_notifications`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `id` (`log_id`,`fromUID`),
  ADD KEY `event_date` (`log_date`),
  ADD KEY `toUID` (`toUID`,`toGID`),
  ADD KEY `msg_read` (`seen`),
  ADD KEY `type` (`log_type`),
  ADD KEY `msg_id` (`msg_id`);

--
-- Indizes für die Tabelle `cms_notifications_msg`
--
ALTER TABLE `cms_notifications_msg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`active`,`type`);

--
-- Indizes für die Tabelle `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `cms_plugins`
--
ALTER TABLE `cms_plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_plugin_booking`
--
ALTER TABLE `cms_plugin_booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`uid`,`gid`,`date_created`,`date_wish`,`date_alternative`,`confirmed`,`todo`,`success`,`grade`,`visits`,`ban`,`outdated`,`cut`,`invited`),
  ADD KEY `name` (`name`,`email`),
  ADD KEY `ip` (`ip`);

--
-- Indizes für die Tabelle `cms_plugin_faq`
--
ALTER TABLE `cms_plugin_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_plugin_msg`
--
ALTER TABLE `cms_plugin_msg`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `id` (`msg_id`),
  ADD KEY `id_2` (`msg_id`),
  ADD KEY `parentID` (`parentID`),
  ADD KEY `msg_date` (`msg_date`),
  ADD KEY `msg_read` (`msg_read`,`trash`,`spam`);
ALTER TABLE `cms_plugin_msg` ADD FULLTEXT KEY `msg_body` (`msg_body`);

--
-- Indizes für die Tabelle `cms_plugin_tourdates`
--
ALTER TABLE `cms_plugin_tourdates`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_settings`
--
ALTER TABLE `cms_settings`
  ADD PRIMARY KEY (`property`),
  ADD KEY `property` (`property`),
  ADD KEY `value` (`value`),
  ADD KEY `type` (`type`);

--
-- Indizes für die Tabelle `cms_settings_types`
--
ALTER TABLE `cms_settings_types`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_syslog`
--
ALTER TABLE `cms_syslog`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `id` (`log_id`,`fromUID`),
  ADD KEY `event_date` (`log_date`),
  ADD KEY `toUID` (`toUID`,`toGID`),
  ADD KEY `msg_read` (`seen`),
  ADD KEY `type` (`log_type`);

--
-- Indizes für die Tabelle `cms_syslog_types`
--
ALTER TABLE `cms_syslog_types`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_templates`
--
ALTER TABLE `cms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_template_settings`
--
ALTER TABLE `cms_template_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `templateID` (`templateID`);

--
-- Indizes für die Tabelle `cms_users`
--
ALTER TABLE `cms_users`
  ADD PRIMARY KEY (`id`,`username`),
  ADD KEY `username` (`username`),
  ADD KEY `gid` (`gid`),
  ADD KEY `email` (`email`);

--
-- Indizes für die Tabelle `cms_user_groups`
--
ALTER TABLE `cms_user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_widgets`
--
ALTER TABLE `cms_widgets`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_widget_defaults`
--
ALTER TABLE `cms_widget_defaults`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `cms_widget_settings`
--
ALTER TABLE `cms_widget_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `widgetID` (`widgetID`);

--
-- Indizes für die Tabelle `cms_widget_types`
--
ALTER TABLE `cms_widget_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cms_blog_items`
--
ALTER TABLE `cms_blog_items`
  MODIFY `primkey` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_follower`
--
ALTER TABLE `cms_follower`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `cms_friends`
--
ALTER TABLE `cms_friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `cms_logins`
--
ALTER TABLE `cms_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;
--
-- AUTO_INCREMENT für Tabelle `cms_menu`
--
ALTER TABLE `cms_menu`
  MODIFY `TMPID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `cms_notifications`
--
ALTER TABLE `cms_notifications`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `cms_notifications_msg`
--
ALTER TABLE `cms_notifications_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_plugin_faq`
--
ALTER TABLE `cms_plugin_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT für Tabelle `cms_plugin_msg`
--
ALTER TABLE `cms_plugin_msg`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `cms_syslog`
--
ALTER TABLE `cms_syslog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_syslog_types`
--
ALTER TABLE `cms_syslog_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `cms_templates`
--
ALTER TABLE `cms_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `cms_template_settings`
--
ALTER TABLE `cms_template_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9072;
--
-- AUTO_INCREMENT für Tabelle `cms_users`
--
ALTER TABLE `cms_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `cms_user_groups`
--
ALTER TABLE `cms_user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `cms_widget_defaults`
--
ALTER TABLE `cms_widget_defaults`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT für Tabelle `cms_widget_settings`
--
ALTER TABLE `cms_widget_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
