-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Feb 2017 um 10:00
-- Server-Version: 10.1.10-MariaDB
-- PHP-Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `yawk_mercedesgarage`
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

--
-- Daten für Tabelle `cms_blog`
--

INSERT INTO `cms_blog` (`id`, `sort`, `published`, `name`, `description`, `icon`, `showtitle`, `showdesc`, `showdate`, `showauthor`, `sequence`, `sortation`, `footer`, `comments`, `gid`, `permalink`, `layout`, `preview`, `voting`) VALUES
(1, 0, 1, 'asdasd', '', '', 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0);

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
  `filename` varchar(255) NOT NULL,
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
  `weblink` varchar(255) NOT NULL,
  `itemlayout` int(4) NOT NULL DEFAULT '-1',
  `itemcomments` int(1) NOT NULL DEFAULT '-1',
  `voteUp` int(11) NOT NULL DEFAULT '0',
  `voteDown` int(11) NOT NULL DEFAULT '0',
  `primkey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_blog_items`
--

INSERT INTO `cms_blog_items` (`blogid`, `id`, `uid`, `pageid`, `sort`, `published`, `itemgid`, `title`, `filename`, `subtitle`, `date_created`, `date_changed`, `date_publish`, `date_unpublish`, `teasertext`, `blogtext`, `author`, `thumbnail`, `youtubeUrl`, `weblink`, `itemlayout`, `itemcomments`, `voteUp`, `voteDown`, `primkey`) VALUES
(1, 1, 1, 26, 1, 1, 1, 'asdasd', 'asdasd', 'asdasd', '2017-01-30 16:04:34', '0000-00-00 00:00:00', '2017-01-30 16:04:24', '0000-00-00 00:00:00', 'asdasdsdasdsd', '            ', '', '', '', 'admin', -1, -1, 0, 0, 1),
(1, 2, 1, 27, 2, 1, 0, 'asdasd-KOPIE', 'asdasd-kopie', 'asdasd', '2017-01-30 16:04:34', '2017-01-31 17:40:11', '2017-01-30 16:04:24', '0000-00-00 00:00:00', 'asdasdsdasdsd<br><br>test<h1>    asdasd</h1>', '            ', '', 'admin', '', '', 1, -1, 0, 0, 2);

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
(1, '0000-00-00 00:00:00', 1, 3),
(8, '0000-00-00 00:00:00', 1, 2);

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
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 3, 0, 1),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_gfonts`
--

CREATE TABLE `cms_gfonts` (
  `id` int(11) NOT NULL,
  `font` varchar(128) NOT NULL,
  `description` varchar(256) NOT NULL,
  `setting` varchar(32) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_gfonts`
--

INSERT INTO `cms_gfonts` (`id`, `font`, `description`, `setting`, `activated`) VALUES
(0, 'none', 'no google font selected', '', 0),
(1, 'Arvo', 'Arvo, serif', '', 1),
(2, 'Copse', 'Copse, sans-serif', '', 1),
(3, 'Droid Sans', 'Droid Sans, sans-serif', '', 1),
(4, 'Droid Serif', 'Droid Serif, serif', '300', 1),
(5, 'Lobster', 'Lobster, cursive', '', 1),
(6, 'Nobile', 'Nobile, sans-serif', '', 1),
(7, 'Open Sans', 'Open Sans, sans-serif', '', 1),
(8, 'Oswald', 'Oswald, sans-serif', '300', 1),
(9, 'Pacifico', 'Pacifico, cursive', '', 1),
(10, 'Rokkitt', 'Rokkitt, serif', '', 1),
(11, 'PT Sans', 'PT Sans, sans-serif', '', 1),
(12, 'Quattrocento', 'Quattrocento, serif', '', 1),
(13, 'Raleway', 'Raleway, cursive', '', 1),
(15, 'Yanone Kaffeesatz', 'Yanone Kaffeesatz, sans-serif', '', 1),
(16, 'Norican', 'Norican, cursive', '', 1),
(17, 'Donegal One', 'Donegal, serif', '', 1),
(18, 'Peralta', 'Peralta, display', '', 1),
(19, 'Kalam', 'Kalam, cursive', '', 1),
(20, 'Ubuntu', 'Ubuntu, serif', '', 1),
(21, 'The Girl Next Door', 'The Girl Next Door, serif', '', 1),
(22, 'Courgette', 'Courgette, serif', '', 1),
(23, 'Permanent Marker', 'Permanent Marker, cursive', '', 1),
(24, 'Gloria Hallelujah', 'Gloria Hallelujah, cursive', '', 1),
(25, 'Dancing Script', 'Dancing Script, cursive', '', 1),
(27, 'Allura', 'Allura, cursive', '', 1),
(28, 'Satisfy', 'Satisfiy, cursive', '', 1),
(31, 'Parisienne', 'Parisienne, cursive', '', 1),
(32, 'Petit Formal Script', 'Petit Formal Script, cursive', '', 1),
(33, 'Bilbo Swash Caps', 'Bilbo Swash Caps, cursive', '', 1),
(35, 'Miniver', 'Miniver, cursive', '', 1),
(36, 'Libre Baskerville', 'Libre Baskerville, serif', '', 1),
(37, 'PT Serif', 'PT Serif, serif', '', 1),
(38, 'Indie Flower', 'Indie Flower, cursive', '', 1),
(39, 'Architects Daughter', 'Architects Daughter, cursive', '', 1),
(40, 'Handlee', 'Handlee, cursive', '', 1),
(41, 'Gochi Hand', 'Gochi Hand, cursive', '', 1),
(42, 'Neucha', 'Neucha, cursive', '', 1),
(43, 'Covered By Your Grace', 'Covered By Your Grace, cursive', '', 1),
(44, 'Great Vibes', 'Great Vibes, cursive', '', 1),
(45, 'Marck Script', 'Marck Script, cursive', '', 1),
(46, 'Comfortaa', 'Comfortaa, cursive', '', 1),
(48, 'Special Elite', 'Special Elite', '', 1),
(49, 'Frijole', 'Frijole, cursive', '', 1),
(50, 'Press Start 2P', 'Press Start 2P, cursive', '', 1),
(51, 'Oleo Script Swash Caps', 'Oleo Script Swash Caps, cursive', '', 1),
(52, 'Kaushan Script', 'Kaushan Script, cursive', '', 1),
(53, 'Open Sans Condensed', 'Open Sans Condensed', '', 1),
(54, 'Nothing You Could Do', 'Nothing You Could Do, cursive', '', 1),
(55, 'Maven Pro', 'Maven Pro, sans-serif', '', 1),
(57, 'Short Stack', 'Short Stack, cursive', '', 1),
(58, 'Merriweather Sans', 'Merriweather Sans, sans-serif', '', 1),
(59, 'Josefin Sans', 'Josefin Sans, sans-serif', '', 1),
(61, 'Hind Vadodara', 'Hind Vadodara, cursive', '', 1),
(62, 'Sahitya', 'Sahitya, serif', '', 1),
(63, 'Lustria', 'Lustria, serif', '', 1),
(64, 'Marcellus SC', 'Marcellus SC, serif', '', 1),
(66, 'Jaldi', 'Jaldi, sans-serif', '', 1),
(68, 'Righteous', 'Righteous, cursive', '', 1),
(69, 'Fredoka One', 'Fredoka One, cursive', '', 1),
(70, 'Itim', 'Itim, cursive', '', 1),
(71, 'Oxygen Mono', 'Oxygen Mono, monospace', '', 1),
(72, 'Anonymous Pro', 'Anonymous Pro, monospace', '', 1),
(73, 'Gudea', 'Gudea, sans-serif', '', 1),
(74, 'Lekton', 'Lekton, sans-serif', '', 1),
(75, 'Roboto Slab', 'Roboto Slab, serif', '', 1),
(76, 'Lato', 'Lato, sans-serif;', '300', 1),
(77, 'Montserrat', 'Montserrat, sans-serif;', '', 1),
(78, 'Roboto', 'Roboto, serif', '300', 1),
(79, 'Source Sans Pro', 'Source Sans Pro, sans-serif', '', 1),
(80, 'Dosis', 'Dosis, sans-serif', '300', 1),
(81, 'Ubuntu Condensed', 'Ubuntu Condensed, sans-serif', '', 1),
(82, 'Amatic SC', 'Amatic SC, cursive', '700', 1),
(83, 'Abel', 'Abel, sans-serif', '', 1),
(84, 'Overlock', 'Overlock, cursive', '', 1),
(85, 'Voltaire', 'Voltaire, sans-serif', '', 1),
(86, 'Pragati Narrow', 'Pragati Narrow, sans-serif', '', 1),
(87, 'Peddana', 'Peddana, serif', '', 1),
(88, 'Pavanam', 'Pavanam, sans-serif', '', 1),
(89, 'News Cycle', 'News Cycle, sans-serif', '', 1);

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
(1, '2017-01-30 02:29:18', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', 'admin', '12345'),
(2, '2017-01-31 20:47:37', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', 'admin', '12345'),
(3, '2017-02-07 22:13:16', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(4, '2017-02-07 22:13:16', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(5, '2017-02-07 22:13:16', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(6, '2017-02-07 22:13:16', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(7, '2017-02-07 22:13:25', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(8, '2017-02-07 22:13:25', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(9, '2017-02-07 22:13:25', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(10, '2017-02-07 22:13:25', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(11, '2017-02-07 22:13:33', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'diddrpwd1'),
(12, '2017-02-07 22:13:33', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'diddrpwd1'),
(13, '2017-02-07 22:13:33', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'diddrpwd1'),
(14, '2017-02-07 22:13:33', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'diddrpwd1'),
(15, '2017-02-07 22:14:01', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'ashobbin1'),
(16, '2017-02-07 22:14:01', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'ashobbin1'),
(17, '2017-02-07 22:14:01', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'ashobbin1'),
(18, '2017-02-07 22:14:02', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'ashobbin1'),
(19, '2017-02-07 22:14:09', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', '12345'),
(20, '2017-02-12 22:14:27', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', '12345'),
(21, '2017-02-13 00:51:19', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(22, '2017-02-13 00:51:19', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(23, '2017-02-13 00:51:19', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(24, '2017-02-13 00:51:19', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', 'test'),
(25, '2017-02-13 01:48:32', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', '12345'),
(26, '2017-02-14 08:28:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', 'admin', '12345');

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
  `title` varchar(255) NOT NULL,
  `text` varchar(100) NOT NULL,
  `href` varchar(255) NOT NULL,
  `target` varchar(64) NOT NULL DEFAULT '_self',
  `divider` int(11) NOT NULL DEFAULT '0',
  `blogid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_menu`
--

INSERT INTO `cms_menu` (`TMPID`, `id`, `sort`, `gid`, `menuID`, `parentID`, `published`, `date_created`, `date_changed`, `date_publish`, `date_unpublish`, `title`, `text`, `href`, `target`, `divider`, `blogid`) VALUES
(2, 1, 3, 2, 1, 0, 0, '0000-00-00 00:00:00', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'Userpage', 'welcome.html', '_self', 0, 0),
(3, 1, 3, 2, 1, 0, 0, '0000-00-00 00:00:00', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'Userpage', 'welcome.html', '_self', 0, 0),
(30, 5, 8, 1, 1, 0, 0, '2016-10-11 13:55:40', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'logout', 'logout.html', '_self', 0, 0),
(36, 1, 6, 1, 2, 0, 0, '2016-11-03 06:26:00', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'W225', '#', '_self', 0, 0),
(37, 1, 6, 1, 2, 0, 0, '2016-11-03 06:26:06', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'W225', '#', '_self', 0, 0),
(38, 1, 6, 1, 2, 0, 0, '2016-11-03 06:26:12', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'W225', '#', '_self', 0, 0),
(39, 1, 6, 1, 2, 0, 0, '2016-11-03 06:26:18', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'W225', '#', '_self', 0, 0),
(40, 8, 12, 1, 1, 0, 0, '0000-00-00 00:00:00', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'booking', 'booking.html', '_self', 0, 0),
(49, 9, 13, 1, 1, 0, 0, '2016-12-28 22:16:35', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'Startseite', 'index.html', '_self', 0, 0),
(50, 10, 14, 1, 1, 0, 1, '2016-12-29 00:13:48', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'Baureihe', '#', '_self', 0, 0),
(51, 11, 15, 1, 1, 10, 1, '2016-12-29 00:14:37', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'Mercedes Benz W123 1976 bis 1986', 'mercedes-benz-w123-1976-1986.html', '_self', 0, 0),
(53, 12, 17, 1, 1, 0, 0, '2016-12-29 00:16:48', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'W114/115', 'W114-115.html', '_self', 0, 0),
(54, 13, 18, 1, 1, 10, 1, '0000-00-00 00:00:00', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'Mercedes Benz W124 1985-1994', 'mercedes-benz-w124-1985-1994.html', '_self', 0, 0),
(55, 14, 19, 1, 1, 0, 1, '0000-00-00 00:00:00', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Twitch TV', 'Twitch Stream Test', 'twitch-stream-test.html', '_self', 0, 0),
(57, 1, 6, 1, 2, 0, 0, '2017-01-18 06:13:59', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'W225', '#', '_self', 0, 0),
(58, 2, 7, 1, 2, 0, 1, '2017-01-18 06:14:11', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'C-Klasse', '#', '_self', 0, 0),
(59, 3, 8, 1, 2, 0, 1, '2017-01-18 06:14:19', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'W201', '#', '_self', 0, 0),
(60, 4, 9, 1, 2, 0, 1, '2017-01-18 06:14:24', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'W202', '#', '_self', 0, 0),
(61, 5, 10, 1, 2, 0, 0, '2017-01-18 06:14:30', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'W203', '#', '_self', 0, 0),
(62, 6, 1, 1, 2, 0, 1, '2017-01-18 06:14:56', '2017-01-22 22:22:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'A-Klasse', '#', '_self', 0, 0),
(71, 16, 21, 1, 1, 0, 1, '0000-00-00 00:00:00', '2017-01-23 19:45:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'YouTube Streaming Test', 'YouTube Test', 'youtube-test.html', '_self', 0, 0),
(72, 17, 22, 1, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'asdasd', 'asdasd.html', '_self', 0, 1);

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
(1, 'Mercedesgarage.net', 1),
(2, 'Mercedes Baureihen', 1);

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
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `page` int(11) NOT NULL,
  `content` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_meta_local`
--

INSERT INTO `cms_meta_local` (`id`, `name`, `page`, `content`) VALUES
(1, 'description', 2, ''),
(2, 'description', 3, ''),
(3, 'description', 4, 'logout'),
(4, 'description', 5, 'terms-of-service'),
(6, 'description', 7, 'Test'),
(7, 'description', 8, 'test'),
(8, 'description', 9, 'test'),
(9, 'description', 10, 'test'),
(11, 'description', 12, 'Test Menu'),
(13, 'description', 14, 'Blog #2                                                                                             '),
(18, 'description', 19, '333333'),
(19, 'description', 20, 'W124'),
(20, 'description', 21, 'sadasdasd'),
(21, 'description', 22, 'asaasdasddd'),
(22, 'description', 23, 'asd'),
(24, 'keywords', 2, ''),
(26, 'keywords', 4, 'keyword1, keyword2, keyword3, keyword4'),
(27, 'keywords', 5, 'keyword1, keyword2, keyword3, keyword4'),
(29, 'keywords', 7, 'keyword1, keyword2, keyword3, keyword4'),
(30, 'keywords', 8, ''),
(31, 'keywords', 9, ''),
(32, 'keywords', 10, ''),
(34, 'keywords', 12, 'keyword1, keyword2, keyword3, keyword4'),
(36, 'keywords', 14, 'keyword1, keyword2, keyword3, keyword4'),
(41, 'keywords', 19, ''),
(42, 'keywords', 20, ''),
(43, 'keywords', 21, ''),
(44, 'keywords', 22, ''),
(45, 'keywords', 23, ''),
(47, 'description', 3, 'microsoft bankrott-KOPIE'),
(48, 'keywords', 3, ''),
(49, 'description', 3, 'Galaxy 7 explodiert!-KOPIE'),
(50, 'keywords', 3, ''),
(51, 'description', 3, 'Microsoft bankrott-KOPIE'),
(52, 'keywords', 3, ''),
(53, 'description', 3, 'Microsoft bankrott-KOPIE'),
(54, 'keywords', 3, ''),
(55, 'description', 4, 'Microsoft bankrott-KOPIE'),
(56, 'keywords', 4, ''),
(57, 'description', 13, 'Testeintrag 2                                                                                       '),
(58, 'keywords', 13, ''),
(59, 'description', 13, 'Testeintrag 2                                                                                       '),
(60, 'keywords', 13, ''),
(61, 'description', 2, ''),
(62, 'keywords', 2, ''),
(63, 'description', 13, 'Testeintrag 2                                                                                       '),
(64, 'keywords', 13, ''),
(65, 'description', 13, 'Testeintrag 2                                                                                       '),
(66, 'keywords', 13, ''),
(67, 'description', 2, ''),
(68, 'keywords', 2, ''),
(69, 'description', 20, 'W124'),
(70, 'keywords', 20, ''),
(71, 'description', 23, 'w126'),
(72, 'keywords', 23, ''),
(73, 'description', 26, 'asdasd'),
(74, 'keywords', 26, ''),
(75, 'description', 2, 'asdasd-KOPIE'),
(76, 'keywords', 2, ''),
(77, 'description', 3, 'asdasd-KOPIE'),
(78, 'keywords', 3, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_newsletter`
--

CREATE TABLE `cms_newsletter` (
  `id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_newsletter`
--

INSERT INTO `cms_newsletter` (`id`, `date_created`, `name`, `email`, `active`) VALUES
(1, '2016-12-10 04:28:26', '', 'unknown', 1),
(2, '2016-12-10 04:28:51', '', 'danielretzl@gmail.com', 1),
(3, '2016-12-10 04:31:44', '', 'danielretzl@gmail.com', 1),
(4, '2016-12-10 04:32:27', '', 'danielretzl@gmail.com', 1),
(5, '2016-12-10 04:52:16', '', 'danielretzl@gmail.com', 1),
(6, '2016-12-10 05:11:26', '', 'danielretzl@gmail.com', 1),
(7, '2016-12-10 05:14:13', '', 'danielretzl@gmail.com', 1);

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
(1, 1, 1, '2016-08-19 09:43:45', '2016-12-28 22:25:56', '2016-08-19 09:43:45', '0000-00-00 00:00:00', 'index', 'Startseite', '', -1, 0, 0, 0, '0'),
(2, 0, 1, '2016-08-19 09:58:39', '2016-11-03 02:00:42', '2016-08-19 09:58:39', '0000-00-00 00:00:00', 'override-bootstrap-style-settings-theme-generator', 'Styling', '', -1, 0, 0, 0, '0'),
(3, 0, 2, '2016-08-19 10:54:00', '2016-08-19 10:57:07', '2016-08-19 10:54:00', '0000-00-00 00:00:00', 'welcome', 'Userpage', '', -1, 0, 1, 0, '8'),
(4, 0, 1, '2016-09-12 14:32:17', '2016-09-12 14:36:13', '2016-09-12 14:32:17', '0000-00-00 00:00:00', 'logout', 'logout', '', -1, 0, 1, 0, '0'),
(5, 1, 1, '2016-09-15 02:58:56', '0000-00-00 00:00:00', '2016-09-15 02:58:56', '0000-00-00 00:00:00', 'terms-of-service', 'terms-of-service', '', -1, 0, 0, 0, '7'),
(17, 1, 1, '2016-12-08 12:05:21', '2016-12-08 12:05:33', '2016-12-08 12:05:21', '0000-00-00 00:00:00', 'booking', 'booking', '', -1, 0, 1, 0, '0'),
(18, 0, 1, '2016-12-09 17:35:25', '2016-12-09 17:35:42', '2016-12-09 17:35:25', '0000-00-00 00:00:00', 'working-process', 'working process', '', -1, 0, 0, 0, '0'),
(19, 1, 1, '2016-12-29 00:17:30', '2017-01-03 17:56:36', '2016-12-29 00:17:30', '0000-00-00 00:00:00', 'mercedes-benz-w123-1976-1986', 'Mercedes Benz W123 1976 bis 1986', '', -1, 0, 0, 0, '0'),
(20, 1, 1, '2017-01-11 16:57:05', '2017-01-26 22:37:03', '2017-01-11 16:57:05', '0000-00-00 00:00:00', 'mercedes-benz-w124-1985-1994', 'Mercedes Benz W124 1985-1994', '', -1, 0, 0, 0, '0'),
(21, 1, 1, '2017-01-16 11:45:37', '2017-01-16 11:46:42', '2017-01-16 11:45:37', '0000-00-00 00:00:00', 'twitch-stream-test', 'Twitch Stream Test', '', -1, 0, 0, 0, '0'),
(24, 1, 1, '2017-01-20 00:31:51', '2017-01-22 22:52:52', '2017-01-20 00:31:51', '0000-00-00 00:00:00', 'youtube-test', 'YouTube Test', '', -1, 0, 0, 0, '0'),
(25, 0, 1, '2017-01-30 05:00:45', '0000-00-00 00:00:00', '2017-01-30 05:00:45', '0000-00-00 00:00:00', 'asdasd', 'asdasd', '', -1, 0, 1, 1, '0'),
(26, 1, 1, '2017-01-30 16:04:34', '0000-00-00 00:00:00', '2017-01-30 16:04:34', '0000-00-00 00:00:00', 'asdasd', 'asdasd', '', -1, 0, 1, 1, '');

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
(8, 'userpage', 'Edit User Page Settings', 'fa fa-home', 1),
(9, 'gallery', 'Create and manage image and video galleries', 'fa fa-photo', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_plugin_booking`
--

INSERT INTO `cms_plugin_booking` (`id`, `uid`, `gid`, `date_created`, `date_wish`, `date_alternative`, `confirmed`, `name`, `email`, `phone`, `text`, `todo`, `success`, `income`, `grade`, `visits`, `comment`, `ip`, `useragent`, `ban`, `outdated`, `referer`, `cut`, `invited`) VALUES
(1, 1, 5, '2016-12-08 13:56:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'admin', 'danielretzl@gmail.com', '6642262575', 'tfhdtzjfzjnfhnfdhn', 0, 0, 0, 0, 0, '', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 0, 0, 'http://192.168.1.8/yawk-LTE/booking.html', 0, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Tabellenstruktur für Tabelle `cms_plugin_gallery`
--

CREATE TABLE `cms_plugin_gallery` (
  `id` int(11) NOT NULL,
  `sortItem` int(11) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `authorUrl` varchar(255) NOT NULL,
  `createThumbnails` int(1) NOT NULL,
  `thumbnailWidth` int(6) NOT NULL,
  `resizeImages` int(1) NOT NULL DEFAULT '0',
  `resizeType` varchar(128) NOT NULL,
  `imageWidth` int(6) NOT NULL,
  `imageHeight` int(6) NOT NULL,
  `watermark` varchar(255) NOT NULL,
  `watermarkEnabled` int(1) NOT NULL DEFAULT '1',
  `watermarkPosition` varchar(16) NOT NULL,
  `watermarkImage` varchar(255) NOT NULL,
  `offsetY` varchar(11) NOT NULL,
  `offsetX` varchar(11) NOT NULL,
  `watermarkFont` varchar(255) NOT NULL,
  `watermarkTextSize` varchar(12) NOT NULL,
  `watermarkOpacity` varchar(12) NOT NULL,
  `watermarkColor` varchar(7) NOT NULL,
  `watermarkBorderColor` varchar(7) NOT NULL,
  `watermarkBorder` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_plugin_gallery`
--

INSERT INTO `cms_plugin_gallery` (`id`, `sortItem`, `folder`, `title`, `description`, `author`, `authorUrl`, `createThumbnails`, `thumbnailWidth`, `resizeImages`, `resizeType`, `imageWidth`, `imageHeight`, `watermark`, `watermarkEnabled`, `watermarkPosition`, `watermarkImage`, `offsetY`, `offsetX`, `watermarkFont`, `watermarkTextSize`, `watermarkOpacity`, `watermarkColor`, `watermarkBorderColor`, `watermarkBorder`) VALUES
(1, 0, 'media/images/W124', 'Mercedes-Benz W124 - 1985 bis 1994', 'Ob als Limousine, Kombi, CoupÃ© oder Cabrio - fÃ¼r viele Fans ist es die letzte echte E-Klasse.', '', '', 1, 300, 0, 'fit_to_width', 0, 0, 'www.mercedesgarage.at', 0, 'bottom right', '', '-12', '-12', '../system/fonts/delicious.ttf', '24', '.5', 'E8E8E8', '424242', '1'),
(2, 0, 'media/images/W123', 'Mercedes Benz W123 1976 bis 1986', 'W123 Fotos: Interieur, Exterieur, Limousine, Kombi, Coupe, Cabrio', '', '', 1, 400, 0, '', 0, 0, 'www.mercedesgarage.at', 0, 'bottom right', '', '-12', '-12', '../system/fonts/delicious.ttf', '18', '.5', 'E8E8E8', '424242', '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_plugin_gallery_items`
--

CREATE TABLE `cms_plugin_gallery_items` (
  `id` int(11) NOT NULL,
  `galleryID` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `authorUrl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_plugin_gallery_items`
--

INSERT INTO `cms_plugin_gallery_items` (`id`, `galleryID`, `sort`, `filename`, `title`, `author`, `authorUrl`) VALUES
(1, 1, 8, '14590160_1239669666071912_8179583242988687574_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(2, 1, 1, '14612479_1239669569405255_9117919262052317404_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(3, 1, 3, '14633140_1239669742738571_4198600928007421943_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(4, 1, 4, '14692139_1239669649405247_8313650990569687549_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(5, 1, 5, '14711050_1239669566071922_7424829517892465911_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(6, 1, 6, '14853293_1239669776071901_2429565509921052310_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(7, 1, 7, '14859926_1239669726071906_1903680116334103920_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(9, 1, 2, '14882310_1239669516071927_8527388114910782474_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(10, 1, 10, '14883579_1239669522738593_1022388281581614206_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(11, 1, 11, '14884718_1239669592738586_7713362563862732880_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(12, 1, 12, '14890001_1239669519405260_4264550528377150564_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(13, 1, 13, '14902923_1239669719405240_6225826415239546564_o.jpg', 'Mercedes-Benz W124 - 1985 bis 1994', '', ''),
(14, 2, 1, 'W123-300D.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(15, 2, 2, 'W123-breitbandscheinwerfer.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(16, 2, 3, 'W123-cockpit.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(17, 2, 4, 'W123-coupe-dreifach.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(18, 2, 5, 'W123-coupe-ohne-b-sauele.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(19, 2, 6, 'W123-coupe-schwarz.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(20, 2, 7, 'W123-coupe-sw.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(21, 2, 8, 'W123-crashfoto-vogelperspektive.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(22, 2, 9, 'W123-interieur-ruckbank.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(23, 2, 10, 'W123-interieur-vordersitze.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(24, 2, 11, 'W123-kofferraum.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(25, 2, 12, 'W123-kombi-01.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(26, 2, 13, 'W123-lenkrad.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(27, 2, 14, 'W123-mittelkonsole.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(28, 2, 15, 'W123-modellvielfalt.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(29, 2, 16, 'W123-pressefoto-braun-02.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(30, 2, 17, 'W123-pressefoto-braun.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(31, 2, 18, 'W123-pressefoto-L-g.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(32, 2, 19, 'W123-pressefoto-modern.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(33, 2, 20, 'W123-taxi.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(34, 2, 21, 'W123-tmodell-02.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(35, 2, 22, 'W123-tmodell-03-R.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(36, 2, 23, 'W123-tmodell-04.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(37, 2, 24, 'W123-tmodell-05.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(38, 2, 25, 'W123-tmodell-seitlich.jpg', 'Mercedes Benz W123 1976 bis 1986', '', ''),
(39, 2, 26, 'W123-vogelperspektive.jpg', 'Mercedes Benz W123 1976 bis 1986', '', '');

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
(1, 0, '2016-09-14 00:36:26', 1, 1, 'test', 1, 0, 0),
(2, 0, '2016-11-22 06:47:47', 1, 1, 'asdasdasd', 1, 0, 0),
(3, 0, '2016-11-22 06:48:00', 1, 2, 'twerwerwer', 1, 0, 0),
(4, 0, '2016-11-22 06:48:28', 1, 1, 'test', 1, 0, 0),
(7, 0, '2016-12-09 22:54:02', 2, 1, 'sooon ..... :-)', 1, 0, 0);

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

--
-- Daten für Tabelle `cms_plugin_tourdates`
--

INSERT INTO `cms_plugin_tourdates` (`id`, `date`, `band`, `venue`, `published`, `fburl`) VALUES
(1, '2016-10-23 06:45:00', 'Stephan & B&ouml;rns', 'Casablanca', 1, '');

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
('admin_email', 'danielretzl@gmail.com', '', 1, 5, 1, 'ADMIN_EMAIL_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFooter', '0', '', 11, 5, 1, 'BACKENDFOOTER_LABEL', 'fa fa-chevron-down', 'BACKENDFOOTER_HEADING', 'BACKENDFOOTER_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendFooterCopyright', '0', '', 11, 6, 1, 'BACKENDFOOTERCOPYRIGHT_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendFooterValueLeft', 'http://yawk.io', '', 11, 7, 1, 'BACKENDFOOTERVALUE_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFooterValueRight', 'proudly presented by <b>YaWK :: <small> Yet another Web Kit</b></small>', '', 11, 8, 1, 'BACKENDFOOTERVALUERIGHT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFX', '0', '', 2, 5, 1, 'BACKENDFX_LABEL', 'fa fa-paper-plane-o', 'BACKENDFX_HEADING', 'BACKENDFX_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendFXtime', '820', '', 2, 7, 1, 'BACKENDFXTIME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFXtype', 'fadeIn In', '', 2, 6, 1, 'BACKENDFXTYPE_LABEL', '', '', '', 'form-control', 'select', '', '', 'fadeIn,Fade In:slideDown,Slide Down'),
('backendLanguage', 'de-DE', '', 2, 4, 1, 'BACKENDLANGUAGE_LABEL', 'fa fa-language', 'BACKENDLANGUAGE_HEADING', 'BACKENDLANGUAGE_SUBTEXT', 'form-control', 'select', '', '', 'en-EN,English (en-EN):de-DE,German (de-DE)'),
('backendLayout', 'sidebar-mini', '', 2, 2, 1, 'BACKENDLAYOUT_LABEL', '', '', '', 'form-control', 'select', '', 'BACKENDLAYOUT_DESC', 'fixed,Fixed:sidebar-collapse,Sidebar Collapse:sidebar-mini,Sidebar Mini:layout-boxed,Layout Boxed:layout-top-nav,Layout Top Nav'),
('backendLogoSubText', '', '', 12, 2, 1, 'BACKENDLOGOSUBTEXT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendLogoText', 'mercedesgarage', '', 12, 1, 1, 'BACKENDLOGOTEXT_LABEL', 'fa fa-bars', 'BACKENDLOGOTEXT_HEADING', 'BACKENDLOGOTEXT_SUBTEXT', 'form-control', 'input', '', '', ''),
('backendLogoUrl', '0', '', 12, 3, 1, 'BACKENDLOGOURL_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendMessagesMenu', '1', '', 12, 4, 1, 'BACKENDMSGMENU_LABEL', 'fa fa-bell-o', 'BACKENDMSGMENU_HEADING', 'BACKENDMSGMENU_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendNotificationMenu', '1', '', 12, 5, 1, 'BACKENDNOTIFYMENU_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendSkin', 'skin-wp-style', '', 2, 1, 1, 'BACKENDSKIN_LABEL', 'fa fa-paint-brush', 'BACKENDSKIN_HEADING', 'BACKENDSKIN_SUBTEXT', 'form-control', 'select', '', '', 'skin-blue,Blue:skin-green,Green:skin-red,Red:skin-yellow,Yellow:skin-purple,Purple:skin-black,Black:skin-yellow-light,Yellow Light:skin-wp-style,Wordpress Style'),
('dbhost', 'http://localhost', '', 9, 2, 1, 'DBHOST_LABEL', 'fa fa-database', 'DATABASE_HEADING', 'DATABASE_SUBTEXT', 'form-control', 'input', 'http://localhost/', '', ''),
('dbname', 'yawk_mercedesgarage', '', 9, 1, 1, 'DBNAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('dbport', '3306', '', 9, 6, 1, 'DBPORT_LABEL', '', '', '', 'form-control', 'input', 'default:3306', '', ''),
('dbprefix', 'cms_', '', 9, 5, 1, 'DBPREFIX_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('dbpwd', 'test', '', 9, 4, 1, 'DBPWD_LABEL', '', '', '', 'form-control', 'password', '', '', ''),
('dbusername', 'root', '', 9, 3, 1, 'DBUSERNAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('defaultemailtext', '', 'Hello $user,\\n\\n\\Thank you for registering on site\\n\\n$url', 5, 0, 1, 'Default SignUp Email Message', '', '', '', 'form-control', 'textarea', '', '', ''),
('dirprefix', '/mercedesgarage.net', '', 9, 0, 1, 'DIRPREFIX_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('domain', '192.168.1.8/mercedesgarage.net', '', 1, 4, 1, 'DOMAIN_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('editorActiveLine', '1', '', 14, 2, 1, 'EDITOR_ACTIVE_LINE_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_ACTIVE_LINE_DESC', ''),
('editorAutoCodeview', '1', '', 14, 9, 1, 'EDITOR_AUTO_CODEVIEW_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_AUTO_CODEVIEW_DESC', ''),
('editorCloseBrackets', '1', '', 14, 11, 1, 'EDITOR_CLOSE_BRACKETS_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_CLOSE_BRACKETS_DESC', ''),
('editorCloseTags', '1', '', 14, 10, 1, 'EDITOR_CLOSE_TAGS_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_CLOSE_TAGS_DESC', ''),
('editorHeight', '670', '', 14, 5, 1, 'EDITOR_HEIGHT_LABEL', '', '', '', 'form-control', 'input', '', 'EDITOR_HEIGHT_DESC', ''),
('editorIndentUnit', '4', '', 14, 8, 1, 'EDITOR_INDENT_UNIT_LABEL', '', '', '', 'form-control', 'select', '', 'EDITOR_INDENT_UNIT_DESC', '1,1:2,2:3,3:4,4:5,5:6,6:7,7:8,8'),
('editorLineNumbers', '1', '', 14, 3, 1, 'EDITOR_LINE_NUMBERS_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_LINE_NUMBERS_DESC', ''),
('editorMatchBrackets', '1', '', 14, 10, 1, 'EDITOR_MATCH_BRACKETS_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_MATCH_BRACKETS_DESC', ''),
('editorMatchTags', '1', '', 14, 9, 1, 'EDITOR_MATCH_TAGS_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_MATCH_TAGS_DESC', ''),
('editorSmartIndent', '1', '', 14, 7, 1, 'EDITOR_SMART_INDENT_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_SMART_INDENT_DESC', ''),
('editorTeaserHeight', '100', '', 14, 4, 1, 'EDITOR_TEASER_HEIGHT_LABEL', '', '', '', 'form-control', 'input', '', 'EDITOR_TEASER_HEIGHT_DESC', ''),
('editorTheme', 'yawk', '', 14, 1, 1, 'EDITOR_THEME_LABEL', '', '', '', 'form-control', 'select', '', '', 'yawk,YaWK Theme (based on monokai):monokai,Monokai:3024-day,3024 Day:3024-night,3024 Night:abcdef,ABCDEF:ambiance,Ambiance:ambiance-mobile,Ambiance Mobile:base16-dark,Base 16 dark:base16-light,Base 16 light:bespin,Bespin:blackboard,Blackboard:cobalt,Cobalt:colorforth,Colorforth:dracula,Dracula:eclipse,Eclipse:elegant,Elegant:erlang-dark,Erlang Dark:hopscotch,Hopscotch:icecoder,Icecoder:isotope,Isotope:lesser-dark,Lesser Dark:liquibyte,Liquibyte:material,Material:mbo,MBO:mdn-like,MDN Like:midnight,Midnight:neat,Neat:neo,Neo:night,Night:panda-syntax,Panda Syntax:paraiso-dark,Paraiso Dark:paraiso-light,Paraiso Light:pastel-on-dark,Pastel On Dark:railcasts,Railcasts:rubyblue,Rubyblue:seti,Seti:solarized,Solarized:the-matrix,The Matrix:tomorrow-night-bright,Tomorrow Night Bright:tomorrow-night-eighties,Tomorrow Night Eighties:ttcn,TTCN:twilight,Twilight:vibrant-ink,Vibrant Ink:xq-dark,XQ Dark:xq-light,XQ Light:yeti,Yeti:zenburn,Zenburn'),
('editorUndoDepth', '200', '', 14, 6, 1, 'EDITOR_UNDO_DEPTH_LABEL', '', '', '', 'form-control', 'select', '', 'EDITOR_UNDO_DEPTH_DESC', '50,50:100,100:150,150:200,200:250,250:300,300:400,400:500,500:1000,1000'),
('facebookstatus', '0', '', 4, 0, 1, 'Facebook on/off', '', '', '', 'form-control', '', '', '', ''),
('facebookurl', 'http://www.facebook.com', '', 4, 0, 1, 'URL zu Facebook Seite / Profil ', '', '', '', 'form-control', '', '', '', ''),
('frontendFX', '0', '', 3, 3, 1, 'FRONTENDFX_LABEL', '', '', '', 'form-control', '', '', '', ''),
('globalmenuid', '1', '', 3, 2, 1, 'GLOBALMENUID_LABEL', 'fa fa-bars', 'GLOBALMENUID_HEADING', 'GLOBALMENUID_SUBTEXT', 'form-control', 'select', '', 'GLOBALMENUID_DESC', ''),
('globalmetakeywords', 'YAWK, CMS, WORDPRESS, JOOMLA', '', 10, 0, 1, 'Global Site Keywords', '', '', '', 'form-control', '', '', '', ''),
('globalmetatext', 'YAWK DEVELOPMENT VERSION', '', 10, 0, 1, 'Global Meta Description', '', '', '', 'form-control', '', '', '', ''),
('host', 'http://192.168.1.8/mercedesgarage.net', '', 1, 3, 1, 'HOST_LABEL', '', '', '', 'form-control', 'input', '', 'DATABASE_DESC', ''),
('loadingTime', '0', '', 11, 10, 1, 'LOADINGTIME_LABEL', 'fa fa-signal', 'LOADINGTIME_HEADING', 'LOADINGTIME_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('logoutmenuid', '1', '', 6, 0, 1, 'Logout Menu ID for logged-in Users', '', '', '', 'form-control', '', '', '', ''),
('offline', '0', '', 8, 0, 1, 'OFFLINE_LABEL', 'fa fa-wrench', 'OFFLINE_HEADING', 'OFFLINE_SUBTEXT', 'form-control', 'checkbox', '', 'OFFLINE_DESC', ''),
('offlineimage', 'media/images/closed-sign-tm.jpg', '', 8, 0, 1, 'OFFLINEIMAGE_LABEL', '', '', '', 'form-control', 'input', 'media/images/logo.jpg', 'OFFLINEIMAGE_DESC', ''),
('offlinemsg', '<h1>Wartungsarbeiten</h1><h3>Bitte schau spÃ¤ter nochmal vorbei.</h3>', '', 8, 0, 1, 'OFFLINEMSG_LABEL', '', '', '', 'form-control', 'textarea', '', '', ''),
('paceLoader', 'enabled', '', 11, 1, 1, 'PACELOADER_LABEL', 'fa fa-spinner', 'PACELOADER_HEADING', 'PACELOADER_SUBTEXT', 'form-control', 'select', '', '', 'disabled,disabled:enabled,enabled'),
('paceLoaderColor', '0073AA', '', 11, 2, 1, 'PACELOADER_COLOR_LABEL', '', '', '', 'form-control color', 'input', '0073aa', '', ''),
('paceLoaderHeight', '4px', '', 11, 3, 1, 'PACELOADER_HEIGHT_LABEL', '', '', '', 'form-control', 'input', 'PACELOADER_HEIGHT_PLACEHOLDER', '', ''),
('selectedTemplate', '1', '', 3, 1, 1, 'SELECTEDTEMPLATE_LABEL', 'fa fa-photo', 'SELECTEDTEMPLATE_HEADING', 'SELECTEDTEMPLATE_SUBTEXT', 'form-control', 'select', '', 'SELECTEDTEMPLATE_DESC', ''),
('sessiontime', '60', '', 9, 1, 1, 'SESSIONTIME_LABEL', '', '', '', 'form-control', 'select', '', 'SESSIONTIME_DESC', '10,10 Minutes:20,20 Minutes:30,30 Minutes:40,40 Minutes:50,50 Minutes:60,60 Minutes:120,120 Minutes:320,320 Minutes'),
('signup_adultcheck', '1', '', 5, 0, 1, 'display adultcheck question before registration form', '', '', '', 'form-control', '', '', '', ''),
('signup_city', '0', '', 5, 0, 1, 'require city to signup', '', '', '', 'form-control', '', '', '', ''),
('signup_country', '0', '', 5, 0, 1, 'require country to signup', '', '', '', 'form-control', '', '', '', ''),
('signup_defaultgid', '2', '', 5, 0, 1, 'Default Group ID for new users', '', '', '', 'form-control', '', '', '', ''),
('signup_firstname', '0', '', 5, 0, 1, 'require firstname to signUp', '', '', '', 'form-control', '', '', '', ''),
('signup_gid', '1', '', 5, 0, 1, 'Adds a GroupID select field to SignUp Form', '', '', '', 'form-control', '', '', '', ''),
('signup_lastname', '0', '', 5, 0, 1, 'require lastname to signUp', '', '', '', 'form-control', '', '', '', ''),
('signup_layout', 'right', '', 5, 0, 1, 'Layout of User SignUp Form (left, right or plain)', '', '', '', 'form-control', '', '', '', ''),
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
('sitename', 'Das freie Magazin fÃ¼r Youngtimer und Oldtimer von Mercedes-Benz', '', 1, 2, 1, 'SITENAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('statsEnable', '1', '', 13, 2, 1, 'STATS_LABEL', 'fa fa-bar-chart', 'STATS_HEADING', 'STATS_SUBTEXT', 'form-control', 'select', '', 'STATS_DESC', '0,off:1,on'),
('syslogEnable', '1', '', 13, 1, 1, 'SYSLOG_LABEL', 'fa fa-terminal', 'SYSLOG_HEADING', 'SYSLOG_SUBTEXT', 'form-control', 'select', '', 'SYSLOG_DESC', '0,off:1,on'),
('timediff', '1', '', 7, 1, 1, 'TIMEDIFF_LABEL', 'fa fa-clock-o', 'TIMEDIFF_HEADING', 'TIMEDIFF_SUBTEXT', 'form-control', 'checkbox', '', 'TIMEDIFF_DESC', ''),
('timedifftext', 'This page is not online yet. Please come back in ', '', 7, 2, 1, 'TIMEDIFFTEXT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('title', 'Mercedesgarage.net', '', 1, 1, 1, 'TITLE_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('twitterstatus', '0', '', 4, 0, 1, 'Twitter on/off', '', '', '', 'form-control', '', '', '', ''),
('twitterurl', 'http://www.twitter.com', '', 4, 0, 1, 'URL zu Twitter Profil', '', '', '', 'form-control', '', '', '', ''),
('userlogin', '1', '', 17, 1, 1, 'USERLOGIN_LABEL', 'fa fa-lock', 'USERLOGIN_HEADING', 'USERLOGIN_SUBTEXT', 'form-control', 'checkbox', '', 'USERLOGIN_DESC', ''),
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
('userpage_logoutmenu', '0', '', 6, 0, 1, 'enable logout menu section in globalmenu', '', '', '', 'form-control', '', '', '', ''),
('userpage_msgplugin', '1', '', 6, 0, 1, 'userpage message plugin tab enabled?', '', '', '', 'form-control', '', '', '', ''),
('userpage_profile', '1', '', 6, 0, 1, 'userpage profile enabled?', '', '', '', 'form-control', '', '', '', ''),
('userpage_settings', '1', '', 6, 0, 1, 'userpage`settings', '', '', '', 'form-control', '', '', '', ''),
('userpage_stats', '1', '', 6, 0, 1, 'userpage stats enabled?', '', '', '', 'form-control', '', '', '', ''),
('yawkversion', '0.9.0', '', 9, 2, 1, 'YAWKVERSION_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('youtubeChannelUrl', 'http://www.youtube.com', '', 4, 0, 1, 'YouTube Channel URL', '', '', '', 'form-control', '', '', '', ''),
('youtubestatus', '0', '', 4, 0, 1, 'YouTube on/off', '', '', '', 'form-control', '', '', '', '');

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
(13, 'stats'),
(14, 'editor'),
(15, 'syslog'),
(16, 'database'),
(17, 'login');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_stats`
--

CREATE TABLE `cms_stats` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `logged_in` int(1) NOT NULL,
  `acceptLanguage` varchar(128) NOT NULL,
  `remoteAddr` varchar(128) NOT NULL,
  `userAgent` varchar(255) NOT NULL,
  `device` varchar(255) NOT NULL,
  `deviceType` varchar(255) NOT NULL,
  `os` varchar(255) NOT NULL,
  `osVersion` varchar(64) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `browserVersion` varchar(64) NOT NULL,
  `date_created` datetime NOT NULL,
  `referer` varchar(255) NOT NULL,
  `page` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_stats`
--

INSERT INTO `cms_stats` (`id`, `uid`, `gid`, `logged_in`, `acceptLanguage`, `remoteAddr`, `userAgent`, `device`, `deviceType`, `os`, `osVersion`, `browser`, `browserVersion`, `date_created`, `referer`, `page`) VALUES
(1, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-29 06:24:51', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(2, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-29 06:31:39', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(3, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-29 06:31:55', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(4, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-29 06:32:00', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(5, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-29 06:32:12', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(6, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-29 06:32:40', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(7, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-29 06:32:45', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(8, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-29 06:34:03', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(9, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 01:49:15', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(10, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 02:03:52', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(11, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 02:07:19', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(12, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:38:19', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(13, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:40:05', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(14, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:40:10', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(15, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:40:18', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(16, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:40:32', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(17, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:40:48', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(18, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:41:04', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(19, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:41:22', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(20, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:41:31', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(21, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 04:41:48', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(22, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 17:32:45', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(23, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 20:17:23', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(24, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 20:17:27', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(25, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 20:21:19', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(26, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 20:32:32', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(27, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-30 21:35:33', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(28, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 06:40:34', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(29, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 06:41:04', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(30, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 17:58:05', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?plugin=blog&pluginpage=blog-edit&itemid=1&blogid=1', 'index'),
(31, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 17:58:07', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(32, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 17:58:11', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'youtube-test'),
(33, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 17:58:12', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(34, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 20:46:18', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(35, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 20:46:42', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(36, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 20:47:08', 'http://192.168.1.8/mercedesgarage.net/index.html', 'index'),
(37, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 20:47:13', 'http://192.168.1.8/mercedesgarage.net/index.html', 'index'),
(38, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 20:47:24', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(39, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 20:47:27', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'youtube-test'),
(40, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 20:47:30', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(41, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 22:18:05', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(42, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 22:19:54', 'http://192.168.1.8/mercedesgarage.net/index.html', 'index'),
(43, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 22:19:55', 'http://192.168.1.8/mercedesgarage.net/index.html', '/mercedesgarage.net/'),
(44, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 22:20:11', 'http://192.168.1.8/mercedesgarage.net/', 'index'),
(45, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-01-31 22:44:25', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(46, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-02-02 20:39:50', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(47, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-02-02 20:42:59', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(48, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-02-05 16:04:08', '', '/mercedesgarage.net/'),
(49, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-02-05 16:14:52', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(50, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '55.0.2883.87', '2017-02-05 16:15:05', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(51, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 12:57:37', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(52, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 13:18:50', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=pages', 'index'),
(53, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 13:18:52', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(54, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 13:28:10', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?plugin=signup', 'index'),
(55, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 13:28:13', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(56, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 17:18:44', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(57, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 17:19:06', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(58, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 17:21:21', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(59, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 23:44:58', 'http://localhost/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(60, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 23:46:02', 'http://localhost/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(61, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 23:46:55', 'http://localhost/mercedesgarage.net/admin/index.php?page=widget-edit&widget=3', 'index'),
(62, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 23:46:58', 'http://localhost/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(63, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 23:48:03', 'http://localhost/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(64, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 23:48:06', 'http://localhost/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(65, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 23:48:43', 'http://localhost/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(66, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-07 23:48:55', 'http://localhost/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(67, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-08 23:27:28', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(68, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-08 23:27:31', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(69, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-09 00:00:55', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(70, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2017-02-09 05:39:57', '', '/yawk-lte/'),
(71, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-09 18:43:08', 'http://localhost/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(72, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-11 19:13:38', '', '/mercedesgarage.net/'),
(73, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-11 19:23:05', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(74, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-11 19:26:30', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(75, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-11 19:29:36', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(76, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-11 21:07:59', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(77, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-11 21:08:26', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(78, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-11 21:30:38', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(79, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 12:56:28', '', '/yawk-LTE/'),
(80, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 13:04:43', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widget-edit&widget=3', 'index'),
(81, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 13:04:44', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(82, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:11:29', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(83, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:11:46', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(84, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:11:53', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(85, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:28:23', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(86, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:29:28', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(87, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:29:33', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(88, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:29:48', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(89, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:29:49', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(90, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:32:17', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(91, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 15:32:18', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(92, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 16:11:53', '', 'mercedes-benz-w124-1985-1994'),
(93, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 16:12:01', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'index'),
(94, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 16:17:41', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(95, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:37:23', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(96, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:40:11', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(97, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:40:16', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(98, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:41:09', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(99, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:41:11', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(100, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:41:12', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(101, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:41:13', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(102, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:41:45', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(103, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:41:59', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(104, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:42:31', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(105, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:45:33', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(106, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:45:38', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(107, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:45:56', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(108, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:47:27', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(109, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:47:28', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(110, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:47:51', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(111, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:47:53', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(112, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:47:55', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(113, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:48:20', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(114, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:48:51', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(115, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:49:14', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(116, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:49:16', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(117, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:49:23', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(118, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 20:49:26', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(119, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:10:06', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(120, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:10:08', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(121, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:10:17', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(122, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:10:18', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(123, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:10:19', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(124, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:10:24', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(125, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:10:49', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(126, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:11:16', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(127, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:12:39', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(128, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:12:42', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(129, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:12:45', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(130, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:13:10', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(131, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:13:51', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(132, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:13:53', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(133, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:13:55', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(134, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:13:57', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(135, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:15:01', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986');
INSERT INTO `cms_stats` (`id`, `uid`, `gid`, `logged_in`, `acceptLanguage`, `remoteAddr`, `userAgent`, `device`, `deviceType`, `os`, `osVersion`, `browser`, `browserVersion`, `date_created`, `referer`, `page`) VALUES
(136, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:15:43', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(137, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:15:47', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(138, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:15:49', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(139, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:15:53', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(140, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:16:55', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(141, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:16:55', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(142, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:16:58', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(143, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:16:58', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(144, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:17:01', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(145, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:17:04', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(146, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:17:52', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(147, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:17:56', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(148, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:18:01', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(149, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:18:05', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(150, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:18:08', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(151, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:18:40', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(152, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:18:43', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'twitch-stream-test'),
(153, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:18:45', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(154, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:18:52', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(155, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:18:52', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(156, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:19:04', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(157, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:29:52', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(158, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:29:58', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(159, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:30:04', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(160, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:30:16', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'twitch-stream-test'),
(161, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:30:18', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(162, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:31:11', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(163, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:32:51', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(164, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:32:58', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'twitch-stream-test'),
(165, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:32:59', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(166, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:33:03', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(167, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:33:39', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(168, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:33:42', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'twitch-stream-test'),
(169, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:33:44', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(170, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:34:16', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(171, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:34:17', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w124-1985-1994'),
(172, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:34:38', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(173, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:35:14', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(174, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:35:29', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(175, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:36:12', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(176, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:36:22', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(177, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 21:36:30', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'twitch-stream-test'),
(178, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:10:23', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'index'),
(179, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:10:31', 'http://192.168.1.8/mercedesgarage.net/index.html', 'youtube-test'),
(180, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:10:36', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(181, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:10:48', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(182, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:11:30', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'youtube-test'),
(183, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:12:37', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(184, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:12:38', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(185, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:12:40', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(186, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:14:09', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w123-1976-1986'),
(187, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:14:18', 'http://192.168.1.8/mercedesgarage.net/system/widgets/loginbox/logout.php?folder=mercedesgarage.net&user=admin', 'content/errors/404'),
(188, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:14:18', 'http://192.168.1.8/mercedesgarage.net/system/widgets/loginbox/logout.php?folder=mercedesgarage.net&user=admin', 'content/errors/404'),
(189, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:14:19', 'http://192.168.1.8/mercedesgarage.net/system/widgets/loginbox/logout.php?folder=mercedesgarage.net&user=admin', '/mercedesgarage.net/'),
(190, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:14:21', 'http://192.168.1.8/mercedesgarage.net/', 'mercedes-benz-w123-1976-1986'),
(191, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:14:27', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'welcome'),
(192, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:14:29', 'http://192.168.1.8/mercedesgarage.net/welcome.html', 'mercedes-benz-w123-1976-1986'),
(193, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:14:42', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(194, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:14:44', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(195, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:15:05', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(196, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:15:16', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(197, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:15:36', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'youtube-test'),
(198, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:15:51', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'youtube-test'),
(199, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:15:56', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'youtube-test'),
(200, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:16:11', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'youtube-test'),
(201, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:16:41', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'mercedes-benz-w124-1985-1994'),
(202, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:31:25', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'index'),
(203, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:31:31', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(204, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 22:31:48', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(205, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-12 23:08:12', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(206, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:49:26', 'http://192.168.1.8/mercedesgarage.net/index.html', 'youtube-test'),
(207, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:49:47', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'youtube-test'),
(208, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:49:48', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'youtube-test'),
(209, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:49:49', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'twitch-stream-test'),
(210, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:49:50', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'index'),
(211, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:49:51', 'http://192.168.1.8/mercedesgarage.net/index.html', 'youtube-test'),
(212, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:50:03', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'mercedes-benz-w123-1976-1986'),
(213, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:50:56', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(214, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:50:58', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(215, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:50:59', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'twitch-stream-test'),
(216, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:50:59', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'youtube-test'),
(217, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:51:00', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(218, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:51:25', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(219, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:51:28', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(220, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:51:29', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(221, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:51:31', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(222, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:51:32', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(223, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:51:32', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'youtube-test'),
(224, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:51:33', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(225, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:52:18', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(226, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:52:19', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'index'),
(227, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:52:54', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'index'),
(228, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:53:16', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'index'),
(229, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:53:17', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'index'),
(230, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:53:56', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(231, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:55:57', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(232, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:56:38', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(233, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:56:57', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(234, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:58:05', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(235, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:58:07', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(236, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:58:08', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(237, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:58:26', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(238, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:58:47', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(239, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:58:50', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(240, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:59:47', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(241, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:59:48', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(242, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 00:59:54', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(243, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:00:02', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(244, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:00:04', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(245, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:00:13', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(246, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:00:15', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(247, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:00:24', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(248, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:00:26', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(249, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:00:45', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(250, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:01:00', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(251, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:01:01', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(252, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:01:42', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(253, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:01:43', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(254, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:01:44', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(255, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:01:46', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(256, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:02:38', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(257, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:02:39', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(258, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:02', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(259, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:03', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(260, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:04', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'twitch-stream-test'),
(261, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:04', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'youtube-test'),
(262, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:05', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(263, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:20', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(264, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:27', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(265, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:29', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(266, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:56', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(267, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:03:59', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(268, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:04:35', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(269, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:04:37', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(270, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:07:29', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(271, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:08:11', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(272, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:08:13', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index');
INSERT INTO `cms_stats` (`id`, `uid`, `gid`, `logged_in`, `acceptLanguage`, `remoteAddr`, `userAgent`, `device`, `deviceType`, `os`, `osVersion`, `browser`, `browserVersion`, `date_created`, `referer`, `page`) VALUES
(273, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:08:39', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(274, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:09:46', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(275, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:09:58', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(276, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:10:21', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(277, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:10:54', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(278, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:10:55', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(279, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:10:55', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(280, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:10:55', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(281, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:10:56', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(282, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:10:56', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(283, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:10:57', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(284, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:10:57', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(285, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:11:03', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(286, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:11:18', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(287, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:11:22', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(288, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:12:41', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(289, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:29:27', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(290, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:35:40', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(291, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:36:54', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(292, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:36:54', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(293, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:37:04', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(294, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:37:08', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(295, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:37:17', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(296, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:37:20', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(297, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:37:23', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(298, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:37:26', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(299, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:37:32', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'index'),
(300, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:39:27', 'http://192.168.1.8/mercedesgarage.net/index.html', 'index'),
(301, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:39:29', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(302, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:39:45', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(303, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:40:07', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w123-1976-1986'),
(304, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:40:08', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(305, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:40:09', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(306, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:40:14', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'youtube-test'),
(307, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:40:16', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(308, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:40:19', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(309, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:40:21', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(310, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:40:22', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(311, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:40:26', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'youtube-test'),
(312, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:42:07', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(313, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:47:58', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(314, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:49:43', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(315, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:51:54', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(316, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:52:03', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(317, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:52:49', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(318, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:52:49', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(319, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:52:55', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(320, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:53:33', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'mercedes-benz-w123-1976-1986'),
(321, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 01:54:38', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(322, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 03:38:01', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'twitch-stream-test'),
(323, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:54:36', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(324, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:55:20', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(325, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:55:22', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(326, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:55:31', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(327, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:55:57', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w124-1985-1994'),
(328, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:56:02', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(329, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:56:12', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(330, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:56:13', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(331, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:56:14', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(332, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:56:23', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'youtube-test'),
(333, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:56:28', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'index'),
(334, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:56:29', 'http://192.168.1.8/mercedesgarage.net/index.html', 'youtube-test'),
(335, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:56:31', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'twitch-stream-test'),
(336, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:56:35', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'index'),
(337, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:57:03', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(338, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:58:35', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(339, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 05:59:45', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'index'),
(340, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 06:00:22', '', '/yawk-LTE/'),
(341, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 06:00:25', 'http://192.168.1.8/yawk-LTE/', 'mercedes-benz-w123-1976-1986'),
(342, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 17:21:31', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(343, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 17:21:34', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(344, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 18:58:40', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(345, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 19:05:58', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(346, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 19:06:00', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'mercedes-benz-w123-1976-1986'),
(347, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 19:06:01', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'index'),
(348, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 19:06:06', 'http://192.168.1.8/mercedesgarage.net/index.html', 'youtube-test'),
(349, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 19:06:07', 'http://192.168.1.8/mercedesgarage.net/youtube-test.html', 'twitch-stream-test'),
(350, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 19:06:12', 'http://192.168.1.8/mercedesgarage.net/twitch-stream-test.html', 'mercedes-benz-w123-1976-1986'),
(351, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 19:06:13', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'twitch-stream-test'),
(352, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 20:58:03', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=widgets', 'index'),
(353, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-13 20:58:08', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(354, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-14 06:36:41', '', '/mercedesgarage.net/'),
(355, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-14 06:36:43', 'http://192.168.1.8/mercedesgarage.net/', 'mercedes-benz-w124-1985-1994'),
(356, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-14 07:45:18', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=stats', 'index'),
(357, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-14 07:45:20', 'http://192.168.1.8/mercedesgarage.net/index.html', 'mercedes-benz-w123-1976-1986'),
(358, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-14 07:45:22', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w123-1976-1986.html', 'mercedes-benz-w124-1985-1994'),
(359, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-14 08:03:59', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(360, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-14 08:04:24', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(361, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2017-02-14 08:26:51', '', 'mercedes-benz-w124-1985-1994'),
(362, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-14 08:28:32', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(363, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2017-02-14 08:28:43', '', 'mercedes-benz-w124-1985-1994'),
(364, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2017-02-14 08:28:46', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(365, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-15 18:43:15', 'http://192.168.1.8/mercedesgarage.net/mercedes-benz-w124-1985-1994.html', 'twitch-stream-test'),
(366, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-15 21:11:03', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=stats', 'index'),
(367, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-15 21:11:04', 'http://192.168.1.8/mercedesgarage.net/index.html', 'twitch-stream-test'),
(368, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-15 22:11:28', '', '/mercedesgarage.net/'),
(369, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-15 22:24:32', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=stats', 'index'),
(370, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-16 23:08:47', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=stats', 'index'),
(371, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-16 23:15:33', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(372, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-17 00:41:05', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=template-edit&id=1', '/mercedesgarage.net/index.php'),
(373, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '56.0.2924.87', '2017-02-17 05:23:22', 'http://192.168.1.8/mercedesgarage.net/admin/index.php?page=stats', 'index');

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

--
-- Daten für Tabelle `cms_syslog`
--

INSERT INTO `cms_syslog` (`log_id`, `log_date`, `log_type`, `message`, `fromUID`, `toUID`, `toGID`, `seen`) VALUES
(1, '2017-02-16 23:15:02', 5, '404 ERROR includes/search.php', 1, 0, 0, 0);

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
(1, 1, 'system', 'fa fa-wrench', 'text-default'),
(2, 1, 'pages', 'fa fa-wordpress', 'text-default'),
(3, 1, 'user', 'fa fa-user-plus', 'text-blue'),
(4, 1, 'messaging', 'fa fa-envelope-o', 'text-green'),
(5, 1, 'warning', 'fa fa-exclamation-triangle', 'text-red'),
(6, 1, 'social', 'fa fa-facebook-official', 'text-default'),
(7, 1, 'menu', 'fa fa-bars', 'text-default'),
(8, 1, 'filemanager', 'fa fa-folder-open-o', 'text-default'),
(9, 1, 'plugins', 'fa fa-plug', 'text-default'),
(10, 1, 'settings', 'fa fa-gears', 'text-default'),
(11, 1, 'widgets', 'fa fa-labels', 'text-default'),
(12, 1, 'stats', 'fa fa-bar-chart', 'text-default');

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
  `releaseDate` datetime NOT NULL,
  `author` varchar(255) NOT NULL,
  `authorUrl` varchar(255) NOT NULL,
  `weblink` varchar(255) NOT NULL,
  `subAuthor` varchar(255) NOT NULL,
  `subAuthorUrl` varchar(255) NOT NULL,
  `modifyDate` datetime NOT NULL,
  `version` varchar(64) NOT NULL,
  `license` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_templates`
--

INSERT INTO `cms_templates` (`id`, `active`, `name`, `positions`, `description`, `releaseDate`, `author`, `authorUrl`, `weblink`, `subAuthor`, `subAuthorUrl`, `modifyDate`, `version`, `license`) VALUES
(1, 1, 'yawk-bootstrap3', 'intro:globalmenu:top:leftMenu:mainTop:mainTopLeft:mainTopCenter:mainTopRight:main:mainBottom:mainBottomLeft:mainBottomCenter:mainBottomRight:mainFooter:mainFooterLeft:mainFooterCenter:mainFooterRight:rightMenu:bottom:footer:hiddentoolbar:debug', 'YaWK Bootstrap 3 Default Theme.', '2016-09-29 00:00:00', 'Daniel Retzl ', 'https://github.com/YaWK/mercedesgarage.net', 'http://www.mercedesgarage.net', 'Daniel Retzl', '', '2016-10-01 02:30:00', '1.0.0', 'GNU General Public License (GPL)');

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
  `longValue` text NOT NULL,
  `description` varchar(256) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL,
  `fieldClass` varchar(128) NOT NULL,
  `placeholder` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_template_settings`
--

INSERT INTO `cms_template_settings` (`id`, `templateID`, `property`, `value`, `valueDefault`, `longValue`, `description`, `activated`, `sort`, `fieldClass`, `placeholder`) VALUES
(1, 1, 'heading-gfont', '63', '1', '', 'Global GoogleFont ID', 1, 0, 'form-control', 'Default Google Font'),
(2, 1, 'menu-gfont', '76', '1', '', 'Menu GoogleFont ID', 1, 0, 'form-control', 'Menu Google Font'),
(3, 1, 'text-gfont', '63', '1', '', 'Text GoogleFont ID', 1, 0, 'form-control', 'Text Google Font'),
(4, 1, 'h1-fontcolor', '303030', '000000', '', 'H1 Color', 1, 0, 'color', 'pick a color or leave blank'),
(6, 1, 'h2-fontcolor', '303030', '000000', '', 'H2 Color', 1, 0, 'color', 'pick a color or leave blank'),
(7, 1, 'h3-fontcolor', '5C79A1', '000000', '', 'H3 Color', 1, 0, 'color', 'pick a color or leave blank'),
(8, 1, 'h4-fontcolor', '303030', '000000', '', 'H4 Color', 1, 0, 'color', 'pick a color or leave blank'),
(9, 1, 'h5-fontcolor', '303030', '000000', '', 'H5 Color', 1, 0, 'color', 'pick a color or leave blank'),
(10, 1, 'h6-fontcolor', '303030', '000000', '', 'H6 Color', 1, 0, 'color', 'pick a color or leave blank'),
(11, 1, 'body-bg-color', '2E3037', 'FFFFFF', '', 'Body Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(14, 1, 'well-bg-color', 'ECEFF0', 'f5f5f5', '', 'Well Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(15, 1, 'smalltag-fontcolor', '757575', '777777', '', 'Small Tag Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(16, 1, 'font-menucolor', 'FFFFFF', '777777', '', 'Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(17, 1, 'brand-menucolor', 'FFFFFF', '777777', '', 'Brand Color', 1, 0, 'color', 'pick a color or leave blank'),
(18, 1, 'brandhover-menucolor', 'FFFFFF', '5e5e5e', '', 'Brand Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(19, 1, 'fonthover-menucolor', 'DDDDDD', '333333', '', 'Font Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(22, 1, 'fontactive-menucolor', '555555', '555555', '', 'Font Active Color', 1, 0, 'color', 'pick a color or leave blank'),
(23, 1, 'fontdisabled-menucolor', 'CCCCCC', 'cccccc', '', 'Font Disabled Color', 1, 0, 'color', 'pick a color or leave blank'),
(24, 1, 'default-menubgcolor', '454750', 'f8f8f8', '', 'Default Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(25, 1, 'border-menubgcolor', '000000', 'e7e7e7', '', 'Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(26, 1, 'active-menubgcolor', 'FFFFFF', 'e7e7e7', '', 'Active Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(27, 1, 'toggle-menubgcolor', 'DDDDDD', 'dddddd', '', 'Toggle Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(28, 1, 'iconbar-menubgcolor', '888888', '888888', '', 'IconBar Color', 1, 0, 'color', 'pick a color or leave blank'),
(29, 1, 'background-menudropdowncolor', 'FFFFFF', 'ffffff', '', 'Dropdown Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(30, 1, 'border-menudropdowncolor', 'CCCCCC', 'cccccc', '', 'Dropdown Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(31, 1, 'font-menudropdowncolor', '333333', '333333', '', 'Dropdown Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(32, 1, 'fonthover-menudropdowncolor', '262626', '262626', '', 'Dropdown Font Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(33, 1, 'hoverbg-menudropdowncolor', 'F5F5F5', 'f5f5f5', '', 'Hover Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(34, 1, 'fontactive-menudropdowncolor', 'FFFFFF', 'ffffff', '', 'Dropdown Font Active Color', 1, 0, 'color', 'pick a color or leave blank'),
(35, 1, 'activebg-menudropdowncolor', 'FFFFFF', '337ab7', '', 'Dropdown Active Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(36, 1, 'disabled-menudropdowncolor', '777777', '777777', '', 'Dropdown Font Disabled Color', 1, 0, 'color', 'pick a color or leave blank'),
(37, 1, 'a-link', '007CB7', '337ab7', '', 'Link Color', 1, 0, 'color', 'pick a color or leave blank'),
(38, 1, 'visited-link', '0087C7', '337ab7', '', 'Visited Link', 1, 0, 'color', 'pick a color or leave blank'),
(39, 1, 'hover-link', '00619E', '23527c', '', 'Link Hover Cover', 1, 0, 'color', 'pick a color or leave blank'),
(40, 1, 'decoration-link', 'none', 'none', '', 'Link Decoration', 1, 0, 'form-control', 'none'),
(41, 1, 'hoverdecoration-link', 'underline', 'underline', '', 'Hover Decoration', 1, 0, 'form-control', 'underline'),
(42, 1, 'buttontext-link', 'FFFFFF', 'ffffff', '', 'Button Text Color', 1, 0, 'color', 'pick a color or leave blank'),
(43, 1, 'background-listgroup', 'FFFFFF', 'ffffff', '', 'List Group Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(44, 1, 'fontcolor-listgroup', 'FFFFFF', '000000', '', 'Font Color List Group', 1, 0, 'color', 'pick a color or leave blank'),
(45, 1, 'text-fontcolor', '303030', '333333', '', 'Text Color', 1, 0, 'color', 'pick a color or leave blank'),
(46, 1, 'fontshadow-menucolor', 'CCCCCC', '#CCCCCC', '', 'Menu Text Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(47, 1, 'form-valid', '009900', '009900', '', 'Form Valid Color', 1, 0, 'color', 'pick a color or leave blank'),
(48, 1, 'form-error', 'FF0000', 'FF0000', '', 'Form Error Color', 1, 0, 'color', 'pick a color or leave blank'),
(49, 1, 'body-text-shadow', '1px 0px', '1px 0px', '', 'Body Text Shadow Thickness', 1, 0, 'form-control', 'shadow size in pixels'),
(50, 1, 'body-text-shadow-color', 'C7C7C7', 'CCCCCC', '', 'Body Text Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(51, 1, 'body-text-size', '1.8em', '1.7em', '', 'Body Font Size', 1, 0, 'form-control', 'size in 1.7em or 16px (for example)'),
(52, 1, 'body-margin-top', '35px', '40px', '', 'Body Top Margin', 1, 0, 'form-control', 'value in px e.g. 40px'),
(53, 1, 'body-bg-image', '', 'any .jpg or .png you want', '', 'Body Background Image', 1, 0, 'form-control', 'media/images/background.jpg'),
(54, 1, 'body-bg-repeat', 'no-repeat', 'no-repeat', '', 'Body Background Repeat', 1, 0, 'form-control', 'repeat, repeat-x, repeat-y, no-repeat, inherit'),
(55, 1, 'body-bg-position', 'center', 'center', '', 'Body Background Position', 1, 0, 'form-control', 'left-center, right-center, top-center, [top, bottom]'),
(56, 1, 'body-bg-attachment', 'fixed', 'fixed', '', 'Body Background Attach', 1, 0, 'form-control', 'scroll, fixed, local, initial, inherit'),
(57, 1, 'body-bg-size', 'cover', 'cover', '', 'Body Background Size', 1, 0, 'form-control', 'auto, cover, length, percentage, initial, inherit'),
(58, 1, 'main-box-shadow', '6px 12px 16px 0px', '6px 12px 6px', '', 'Main Box Shadow', 1, 0, 'form-control', 'eg. 3px 6px 3px'),
(59, 1, 'main-box-shadow-color', '141414', 'E8E8E8', '', 'Main Box Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(60, 1, 'well-min-height', '20px', '20px', '', 'Well Minimum Height', 1, 0, 'form-control', 'value in px eg. 20px'),
(61, 1, 'well-padding', '1.5em', '19px', '', 'Well padding', 1, 0, 'form-control', 'value in px eg. 20px'),
(62, 1, 'well-margin-top', '0px', '0px', '', 'Well Margin Top', 1, 0, 'form-control', 'value in px eg. 10px'),
(63, 1, 'well-margin-bottom', '240px', '0px', '', 'Well Margin Bottom', 1, 0, 'form-control', 'value in px eg. 10px'),
(64, 1, 'well-border', '0px solid', '1px solid', '', 'Well Border Style', 1, 0, 'form-control', 'value in px eg. 1px solid'),
(65, 1, 'well-border-color', 'FFFFFF', 'e3e3e3', '', 'Well Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(66, 1, 'well-border-radius', '12px', '0px', '', 'Well Border Radius', 1, 0, 'form-control', 'for rounded edges, value in px eg. 4px'),
(67, 1, 'well-shadow', '8px 8px 20px -6px', '3px 3px 5px 6px', '', 'Well Shadow', 1, 0, 'form-control', 'value in px eg. x,y,blur,spread'),
(68, 1, 'well-shadow-color', 'FFFFFF', 'CCCCCC', '', 'Well Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(69, 1, 'h1-size', '48px', '36px', '', 'H1 Text Size', 1, 0, 'form-control', 'size in px eg. 36px'),
(70, 1, 'h2-size', '36px', '30px', '', 'H2 Text Size', 1, 0, 'form-control', 'size in px eg. 30px'),
(71, 1, 'h3-size', '32px', '24px', '', 'H3 Text Size', 1, 0, 'form-control', 'size in px eg. 24px'),
(72, 1, 'h4-size', '24px', '18px', '', 'H4 Text Size', 1, 0, 'form-control', 'size in px eg. 18px'),
(73, 1, 'h5-size', '18px', '14px', '', 'H5 Text Size', 1, 0, 'form-control', 'size in px eg. 14px'),
(74, 1, 'h6-size', '14px', '12px', '', 'H6 Text Size', 1, 0, 'form-control', 'size in px eg. 12px'),
(75, 1, 'btn-fontsize', '14px', '14px', '', 'Button Fontsize', 1, 0, 'form-control', 'size in px eg. 12px'),
(76, 1, 'btn-font-weight', 'normal', 'normal', '', 'Button Font Weight', 1, 0, 'form-control', 'normal or bold'),
(77, 1, 'btn-border', '1px', '1px', '', 'Button Border', 1, 0, 'form-control', 'value in px eg. 1px'),
(78, 1, 'btn-border-style', 'solid', 'solid', '', 'Button Border Style', 1, 0, 'form-control', 'solid, dotted, dashed'),
(79, 1, 'btn-border-radius', '4px', '4px', '', 'Button Border Radius', 1, 0, 'form-control', 'value in px eg. 4px'),
(80, 1, 'btn-default-color', '333333', '333333', '', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(81, 1, 'btn-default-background-color', 'FFFFFF', 'FFFFFF', '', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(82, 1, 'btn-default-border-color', 'CCCCCC', 'CCCCCC', '', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(83, 1, 'btn-default-focus-background-color', 'E6E6E6', 'E6E6E6', '', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(84, 1, 'btn-default-focus-border-color', '8C8C8C', '8C8C8C', '', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(85, 1, 'btn-default-hover-color', '333333', '333333', '', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(86, 1, 'btn-default-hover-background-color', 'E6E6E6', 'E6E6E6', '', ':hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(87, 1, 'btn-default-hover-border-color', 'ADADAD', 'ADADAD', '', ':hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(88, 1, 'btn-primary-color', 'FFFFFF', 'FFFFFF', '', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(89, 1, 'btn-primary-background-color', '337AB7', '337ab7', '', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(90, 1, 'btn-primary-border-color', '2E6DA4', '2e6da4', '', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(91, 1, 'btn-primary-focus-background-color', '286090', '286090', '', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(92, 1, 'btn-primary-focus-border-color', '122B40', '122b40', '', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(93, 1, 'btn-primary-hover-color', 'FFFFFF', 'FFFFFF', '', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(94, 1, 'btn-primary-hover-background-color', '286090', '286090', '', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(95, 1, 'btn-primary-hover-border-color', '204D74', '204d74', '', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(96, 1, 'btn-success-color', 'FFFFFF', 'FFFFFF', '', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(97, 1, 'btn-success-background-color', '5CB85C', '5cb85c', '', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(98, 1, 'btn-success-border-color', '4CAE4C', '4cae4c', '', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(99, 1, 'btn-success-focus-background-color', '449D44', '449d44', '', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(100, 1, 'btn-success-focus-border-color', '255625', '255625', '', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(101, 1, 'btn-success-hover-color', 'FFFFFF', 'FFFFFF', '', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(102, 1, 'btn-success-hover-background-color', '449D44', '449d44', '', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(103, 1, 'btn-success-hover-border-color', '398439', '398439', '', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(104, 1, 'btn-info-color', 'FFFFFF', 'FFFFFF', '', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(105, 1, 'btn-info-background-color', '5BC0DE', '5bc0de', '', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(106, 1, 'btn-info-border-color', '46B8DA', '46b8da', '', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(107, 1, 'btn-info-focus-background-color', '31B0D5', '31b0d5', '', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(108, 1, 'btn-info-focus-border-color', '1B6D85', '1b6d85', '', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(109, 1, 'btn-info-hover-color', 'FFFFFF', 'FFFFFF', '', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(110, 1, 'btn-info-hover-background-color', '31B0D5', '31b0d5', '', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(111, 1, 'btn-info-hover-border-color', '269ABC', '269abc', '', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(112, 1, 'btn-warning-color', 'FFFFFF', 'FFFFFF', '', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(113, 1, 'btn-warning-background-color', 'F0AD4E', 'f0ad4e', '', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(114, 1, 'btn-warning-border-color', 'EEA236', 'eea236', '', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(115, 1, 'btn-warning-focus-background-color', 'EC971F', 'ec971f', '', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(116, 1, 'btn-warning-focus-border-color', '985F0D', '985f0d', '', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(117, 1, 'btn-warning-hover-color', 'FFFFFF', 'FFFFFF', '', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(118, 1, 'btn-warning-hover-background-color', 'EC971F', 'ec971f', '', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(119, 1, 'btn-warning-hover-border-color', 'D58512', 'd58512', '', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(120, 1, 'btn-danger-color', 'FFFFFF', 'FFFFFF', '', 'Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(121, 1, 'btn-danger-background-color', 'D9534F', 'd9534f', '', 'BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(122, 1, 'btn-danger-border-color', 'D43F3A', 'd43f3a', '', 'Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(123, 1, 'btn-danger-focus-background-color', 'C9302C', 'c9302c', '', 'Focus BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(124, 1, 'btn-danger-focus-border-color', '761C19', '761c19', '', 'Focus Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(125, 1, 'btn-danger-hover-color', 'FFFFFF', 'FFFFFF', '', ':hover Text Color', 1, 0, 'color', 'pick a font or leave blank'),
(126, 1, 'btn-danger-hover-background-color', 'C9302C', 'c9302c', '', 'Hover BG Color', 1, 0, 'color', 'pick a font or leave blank'),
(127, 1, 'btn-danger-hover-border-color', 'AC2925', 'ac2925', '', 'Hover Border Color', 1, 0, 'color', 'pick a font or leave blank'),
(128, 1, 'body-margin-bottom', '0px', '0px', '', 'Body Bottom Margin', 1, 0, 'form-control', 'value in px eg. 0px'),
(129, 1, 'body-margin-left', '0px', '0px', '', 'Body Left Margin', 1, 0, 'form-control', 'value in px eg. 0px'),
(130, 1, 'body-margin-right', '0px', '0px', '', 'Body Right Margin', 1, 0, 'form-control', 'value in px eg. 0px'),
(131, 1, 'img-shadow', '2px 2px 12px 2px', '2px 2px 12px 2px', '', 'Image Shadow', 1, 0, 'form-control', 'value in px eg. 2px 2px 12px 2px'),
(132, 1, 'img-shadow-color', 'A8A8A8', '0A0A0A', '', 'Image Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(133, 1, 'img-righty', '7deg', '7deg', '', 'Angle to Right', 1, 0, 'form-control', 'value in degree e.g. 7deg'),
(134, 1, 'img-lefty', '-7deg', '-7deg', '', 'Angle to Left', 1, 0, 'form-control', 'value in degree e.g. -7deg'),
(135, 1, 'img-righty-less', '4deg', '4deg', '', 'Lesser Angle to Right', 1, 0, 'form-control', 'value in degree e.g. 4deg'),
(136, 1, 'img-lefty-less', '-4deg', '-4deg', '', 'Lesser Angle to Left', 1, 0, 'form-control', 'value in degree e.g. -4deg'),
(137, 1, 'img-brightness', '110%', '110%', '', 'Brightness On Hover', 1, 0, 'form-control', 'value in percent eg. 110%'),
(138, 1, 'listgroup-paddingLeft', '0px', '0', '', 'ListGroup Padding Left', 1, 0, 'form-control', 'value in px eg. 0px'),
(139, 1, 'listgroup-marginBottom', '20px', '0', '', 'ListGroup Padding Bottom', 1, 0, 'form-control', 'value in px eg. 0px'),
(140, 1, 'listgroup-itemPosition', 'relative', 'relative', '', 'ListGroup Item Position', 1, 0, 'form-control', 'static, relative, fixed, absolute'),
(141, 1, 'listgroup-itemDisplay', 'block', 'block', '', 'ListGroup Item Display', 1, 0, 'form-control', 'block, inline, inline-block, flex'),
(142, 1, 'listgroup-itemPadding', '10px 15px', '10px 15px', '', 'ListGroup Item Padding', 1, 0, 'form-control', 'top, right, bottom left in px'),
(143, 1, 'listgroup-itemBorder', '1px solid #2E3037', '1px solid #ddd', '', 'ListGroup Item Border', 1, 0, 'form-control', 'border width. type and color'),
(144, 1, 'listgroup-itemBackgroundColor', '383638', 'FFF', '', 'ListGroup Item Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(145, 1, 'jumbotron-paddingTop', '30px', '30px', '', 'Jumbotron Padding Top', 1, 0, 'form-control', 'value in px eg. 30px'),
(146, 1, 'jumbotron-paddingBottom', '30px', '30px', '', 'Jumbotron Padding Bottom', 1, 0, 'form-control', 'value in px eg. 30px'),
(147, 1, 'jumbotron-marginBottom', '30px', '30px', '', 'Jumbotron Margin Bottom', 1, 0, 'form-control', 'value in px eg. 30px'),
(148, 1, 'jumbotron-backgroundColor', '383638', 'EEE', '', 'Jumbotron Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(149, 1, 'jumbotron-pMarginBottom', '15px', '15px', '', 'Jumbotron p Margin Bottom', 1, 0, 'form-control', 'value in px eg. 15px'),
(150, 1, 'jumbotron-pFontSize', '21px', '21px', '', 'Jumbotron p Font Size', 1, 0, 'form-control', 'value in px eg. 21px'),
(151, 1, 'jumbotron-pFontWeight', '200', '200', '', 'Jumbotron p Font Weight', 1, 0, 'form-control', 'value eg. 200'),
(152, 1, 'jumbotron-hrColor', 'D5D5D5', 'D5D5D5', '', 'Jumbotron hr color', 1, 0, 'color', 'pick a color or leave blank'),
(153, 1, 'jumbotron-containerPaddingRight', '15px', '15px', '', 'Jumbotron Container Padding Right', 1, 0, 'form-control', 'value in px eg. 15px'),
(154, 1, 'jumbotron-containerPaddingLeft', '15px', '15px', '', 'Jumbotron Container Padding Left', 1, 0, 'form-control', 'value in px eg. 15px'),
(155, 1, 'jumbotron-borderRadius', '6px', '6px', '', 'Jumbotron Border Radius', 1, 0, 'form-control', 'value in px eg. 6px'),
(156, 1, 'jumbotron-containerMaxWidth', '100%', '100%', '', 'Jumbotron Container Max Width', 1, 0, 'form-control', 'value in percent, eg. 100%'),
(157, 1, 'jumbotron-fluidPaddingRight', '60px', '60px', '', 'Jumbotron Fluid Padding Right', 1, 0, 'form-control', 'value in px eg. 60px'),
(158, 1, 'jumbotron-fluidPaddingLeft', '60px', '60px', '', 'Jumbotron Fluid Padding Left', 1, 0, 'form-control', 'value in px eg. 60px'),
(159, 1, 'jumbotron-h1FontSize', '63px', '63px', '', 'Jumbotron h1 Font Size', 1, 0, 'form-control', 'value in px eg. 63px'),
(160, 1, 'jumbotron-h1Color', 'FFFFFF', 'FFFFFF', '', 'Jumbotron h1 Color', 1, 0, 'color', 'pick a color or leave blank'),
(161, 1, 'jumbotron-fontColor', 'CCCCCC', 'ccc', '', 'Jumbotron Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(162, 1, 'listgroup-fontColor', 'FFFFFF', 'fff', '', 'ListGroup Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(163, 1, 'listgroup-fontSize', '0.9em', '1.2em', '', 'ListGroup Font Size', 1, 0, 'form-control', 'font size in em or px eg 16px or 1.2em'),
(164, 1, 'navbar-marginTop', '25px', '0px', '', 'Navbar margin from top in px', 1, 0, 'form-control', 'margin in em or px eg 20px or 1.2em'),
(165, 1, 'pos-topmenu-top', '0', '0', '', 'Position from top in px or em', 1, 0, 'form-control', 'margin in em or px eg 20px or 1.2em'),
(166, 1, 'pos-topmenu-marginBottom', '0', '0', '', 'Margin Bottom in px or em', 1, 0, 'form-control', 'margin in em or px eg 20px or 1.2em'),
(167, 1, 'pos-topmenu-property', 'fixed', 'fixed', '', 'static, relative, fixed, absolute', 1, 0, 'form-control', 'position property'),
(169, 1, 'pos-topmenu-bg-color', '3D383A', '00a65a', '', 'Background color of this position', 1, 0, 'color', 'pick a color or leave blank'),
(170, 1, 'pos-topmenu-height', '25px', '20px', '', 'Height in px', 1, 0, 'form-control', 'height of this position in px eg. 20px'),
(171, 1, 'pos-topmenu-width', '100%', '100%', '', 'Width in percent (eg. 100%)', 1, 0, 'form-control', 'width of this position in percent (default: 100%)'),
(172, 1, 'pos-topmenu-zindex', '9999', '9999', '', 'z-index: auto|number|initial|inherit', 1, 0, 'form-control', 'eg. 9999'),
(173, 1, 'pos-topmenu-bg-gradient-longValue', '', '', '/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#454b51+0,616971+48,454b51+100 */\r\nbackground: #454b51; /* Old browsers */\r\nbackground: -moz-linear-gradient(left,  #454b51 0%, #616971 48%, #454b51 100%); /* FF3.6-15 */\r\nbackground: -webkit-linear-gradient(left,  #454b51 0%,#616971 48%,#454b51 100%); /* Chrome10-25,Safari5.1-6 */\r\nbackground: linear-gradient(to right,  #454b51 0%,#616971 48%,#454b51 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */\r\nfilter: progid:DXImageTransform.Microsoft.gradient( startColorstr=''#454b51'', endColorstr=''#454b51'',GradientType=1 ); /* IE6-9 */\r\n', 'CSS gradient. Try <a href="http://www.colorzilla.com/gradient-editor/" target="_blank">colorzilla</a> to help generate code', 1, 0, 'form-control', ''),
(174, 1, 'listgroup-bg-gradient-longValue', '', '', '/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#596068+0,373c41+93,373c41+100 */\r\nbackground: #596068; /* Old browsers */\r\nbackground: -moz-linear-gradient(left,  #596068 0%, #373c41 93%, #373c41 100%); /* FF3.6-15 */\r\nbackground: -webkit-linear-gradient(left,  #596068 0%,#373c41 93%,#373c41 100%); /* Chrome10-25,Safari5.1-6 */\r\nbackground: linear-gradient(to right,  #596068 0%,#373c41 93%,#373c41 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */\r\nfilter: progid:DXImageTransform.Microsoft.gradient( startColorstr=''#596068'', endColorstr=''#373c41'',GradientType=1 ); /* IE6-9 */', 'CSS gradient. Try <a href="http://www.colorzilla.com/gradient-editor/" target="_blank">colorzilla</a> to help generate code', 1, 0, 'form-control', ''),
(175, 1, 'listgroup-firstChild-topLeft-radius', '12px', '4px', '', 'ListGroup First Child Top <i>LEFT Border Radius</i> in px', 1, 0, 'form-control', 'value in px eg. 4px'),
(176, 1, 'listgroup-firstChild-topRight-radius', '12px', '4px', '', 'ListGroup First Child Top RIGHT Border Radius in px', 1, 0, 'form-control', 'value in px eg. 4px'),
(177, 1, 'listgroup-lastChild-bottomRight-radius', '12px', '4px', '', 'ListGroup Last Child Bottom RIGHT Border Radius in px', 1, 0, 'form-control', 'value in px eg. 4px'),
(178, 1, 'listgroup-lastChild-bottomLeft-radius', '12px', '4px', '', 'ListGroup Last Child Bottom LEFT Border Radius in px', 1, 0, 'form-control', 'value in px eg. 4px');

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
(1, 0, 1, 1, 5, 1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', '2016-10-10 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-02-14 08:28:20', 103, 'danielretzl@gmail.com', 'http://yawk.io', '', '', 'Daniel', 'Retzl', '', '', '', '', '', 1, 1, 0, 'Main Developer', 0, 0, 1),
(2, 0, 0, 1, 4, 1, 'claudia', '827ccb0eea8a706c4c34a16891f84e7b', '2016-09-13 13:54:26', '2016-10-10 04:02:11', '0000-00-00 00:00:00', '2016-12-08 21:58:26', 31, 'test@test.com', '', '', '', '', '', '', '', '', '', '', 1, 0, 0, '', 0, 0, 1);

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
  `position` varchar(128) NOT NULL,
  `marginTop` int(11) NOT NULL,
  `marginBottom` int(11) NOT NULL,
  `date_publish` datetime NOT NULL,
  `date_unpublish` datetime NOT NULL,
  `widgetTitle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_widgets`
--

INSERT INTO `cms_widgets` (`id`, `published`, `widgetType`, `pageID`, `sort`, `position`, `marginTop`, `marginBottom`, `date_publish`, `date_unpublish`, `widgetTitle`) VALUES
(1, 1, 13, 19, 1, 'main', 0, 0, '2017-02-07 05:00:12', '0000-00-00 00:00:00', '123er galerie'),
(3, 1, 14, 21, 3, 'mainbottom', 0, 0, '2017-02-10 12:00:01', '0000-00-00 00:00:00', 'Twitch Beispiel'),
(4, 1, 15, 0, 4, 'leftmenu', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'modelle menÃ¼ links'),
(5, 1, 16, 24, 5, 'main', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'YouTube Beispiel'),
(6, 1, 13, 20, 6, 'mainbottom', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '124er Galerie');

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
('htmlcode', '<div class="row">\r\n        <div class="col-md-4">\r\n          <h2>Heading</h2>\r\n          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\r\n          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>\r\n        </div>\r\n        <div class="col-md-4">\r\n          <h2>Heading</h2>\r\n          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>\r\n          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>\r\n       </div>\r\n        <div class="col-md-4">\r\n          <h2>Heading</h2>\r\n          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\r\n          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>\r\n        </div>\r\n      </div>', 10, 1, 'Custom HTML in a divbox', 'form-control', 27),
('galleryID', '1', 13, 1, 'the Gallery ID to show up', 'form-control', 28),
('twitchChannel', 'salista_belladonna', 14, 1, 'the name of any twitch channel', 'form-control', 29),
('twitchChat', '1', 14, 1, 'Include the Chat for this channel? 1|0', 'form-control', 30),
('twitchChatHeight', '200', 14, 1, 'Height of the chat in px eg. 200px', 'form-control', 31),
('twitchChatWidth', '100%', 14, 1, 'Width of the chat channel in px or percent eg. 100%', 'form-control', 32),
('twitchChannelHeight', '720', 14, 1, 'Height of the video stream in px eg. 720', 'form-control', 33),
('twitchChannelWidth', '100%', 14, 1, 'Width of the video stream in eg 100%', 'form-control', 34),
('twitchChannelFullscreen', 'true', 14, 1, 'Allow fullscreen video mode? true|false', 'form-control', 35),
('menuID', '1', 15, 1, 'the menu ID you wish to show', 'form-control', 36),
('youtubeWidth', '100%', 16, 1, 'YouTube video width in px or percent', 'form-control', 37),
('youtubeHeight', '720', 16, 1, 'YouTube video height in px or percent', 'form-control', 38),
('youtubeFullscreen', 'true', 16, 1, 'Allow fullscreen video? Set true or false', 'form-control', 39),
('youtubeVideoUrl', 'https://www.youtube.com/watch?v=PK8sdl53GEA', 16, 1, 'YouTube URL', 'form-control', 40),
('youtubeHeading', '', 16, 1, 'Heading above the video', 'form-control', 41),
('youtubeSubtext', '', 16, 1, 'Small subtext beneath heading', 'form-control', 42),
('youtubeDescription', '', 16, 1, 'Description under the video', 'form-control', 43);

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
(1, 1, 'galleryID', '2', 13, 1),
(30, 3, 'twitchChannel', 'salista_belladonna', 14, 1),
(31, 3, 'twitchChat', '1', 14, 1),
(32, 3, 'twitchChatHeight', '200', 14, 1),
(33, 3, 'twitchChatWidth', '100%', 14, 1),
(34, 3, 'twitchChannelHeight', '720', 14, 1),
(35, 3, 'twitchChannelWidth', '100%', 14, 1),
(36, 3, 'twitchChannelFullscreen', 'true', 14, 1),
(37, 4, 'menuID', '2', 15, 1),
(79, 5, 'youtubeWidth', '100%', 16, 1),
(80, 5, 'youtubeHeight', '720', 16, 1),
(81, 5, 'youtubeFullscreen', 'true', 16, 1),
(82, 5, 'youtubeVideoUrl', 'https://www.youtube.com/watch?v=UGONO-vPnCk', 16, 1),
(83, 5, 'youtubeHeading', 'Am Schauplatz', 16, 1),
(84, 5, 'youtubeSubtext', 'KaisermÃ¼hlen', 16, 1),
(85, 5, 'youtubeDescription', 'E. Spira (1994)', 16, 1),
(86, 6, 'galleryID', '1', 13, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_widget_types`
--

CREATE TABLE `cms_widget_types` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `name` varchar(128) NOT NULL,
  `folder` varchar(128) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_widget_types`
--

INSERT INTO `cms_widget_types` (`id`, `status`, `name`, `folder`, `description`) VALUES
(1, 1, 'Loginbox', 'loginbox', ''),
(2, 1, 'Simple Contact Form', 'form_simple', ''),
(3, 1, 'Prezi', 'prezi', ''),
(4, 1, 'FacebookPage', 'fb_page', ''),
(5, 1, 'FacebookLike', 'fb_like', ''),
(6, 1, 'GoogleAnalytics', 'google_analytics', ''),
(7, 1, 'SimpleUpload', 'simple_upload', ''),
(8, 1, 'Clock', 'clock', ''),
(9, 1, 'Signup', 'signup', ''),
(10, 1, 'Divbox', 'divbox', ''),
(11, 1, 'News Blog Widget', 'news', ''),
(12, 1, 'Newsletter', 'newsletter', ''),
(13, 1, 'Gallery', 'gallery', ''),
(14, 1, 'Twitch Stream', 'twitch', ''),
(15, 1, 'Sub Menu', 'submenu', ''),
(16, 1, 'Youtube Stream', 'youtube', '');

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
  ADD KEY `id` (`id`,`sort`,`gid`,`menuID`,`parentID`,`published`,`date_created`,`date_changed`,`date_publish`,`date_unpublish`,`text`,`href`),
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
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_newsletter`
--
ALTER TABLE `cms_newsletter`
  ADD PRIMARY KEY (`id`);

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
-- Indizes für die Tabelle `cms_plugin_gallery`
--
ALTER TABLE `cms_plugin_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_plugin_gallery_items`
--
ALTER TABLE `cms_plugin_gallery_items`
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
-- Indizes für die Tabelle `cms_stats`
--
ALTER TABLE `cms_stats`
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
  MODIFY `primkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `cms_follower`
--
ALTER TABLE `cms_follower`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT für Tabelle `cms_friends`
--
ALTER TABLE `cms_friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `cms_logins`
--
ALTER TABLE `cms_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT für Tabelle `cms_menu`
--
ALTER TABLE `cms_menu`
  MODIFY `TMPID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT für Tabelle `cms_meta_local`
--
ALTER TABLE `cms_meta_local`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT für Tabelle `cms_newsletter`
--
ALTER TABLE `cms_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `cms_notifications`
--
ALTER TABLE `cms_notifications`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT für Tabelle `cms_plugin_gallery`
--
ALTER TABLE `cms_plugin_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `cms_plugin_gallery_items`
--
ALTER TABLE `cms_plugin_gallery_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT für Tabelle `cms_plugin_msg`
--
ALTER TABLE `cms_plugin_msg`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `cms_stats`
--
ALTER TABLE `cms_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=374;
--
-- AUTO_INCREMENT für Tabelle `cms_syslog`
--
ALTER TABLE `cms_syslog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `cms_syslog_types`
--
ALTER TABLE `cms_syslog_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT für Tabelle `cms_templates`
--
ALTER TABLE `cms_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `cms_template_settings`
--
ALTER TABLE `cms_template_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;
--
-- AUTO_INCREMENT für Tabelle `cms_users`
--
ALTER TABLE `cms_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `cms_user_groups`
--
ALTER TABLE `cms_user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `cms_widget_defaults`
--
ALTER TABLE `cms_widget_defaults`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT für Tabelle `cms_widget_settings`
--
ALTER TABLE `cms_widget_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
