-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Dez 2016 um 00:44
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

--
-- Daten für Tabelle `cms_blog`
--

INSERT INTO `cms_blog` (`id`, `sort`, `published`, `name`, `description`, `icon`, `showtitle`, `showdesc`, `showdate`, `showauthor`, `sequence`, `sortation`, `footer`, `comments`, `gid`, `permalink`, `layout`, `preview`, `voting`) VALUES
(1, 0, 1, 'Newsfeed', 'Neues aus aller Welt', 'fa-adjust', 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0);

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
(1, 1, 1, 13, 1, 1, 1, 'Samsung Galaxy 7 explodiert', 'samsung-galaxy-7-explodiert', 'Subtitle', '2016-10-22 16:03:20', '2016-10-26 23:04:29', '2016-10-22 16:02:34', '0000-00-00 00:00:00', '<p>Samsung Galaxy TeaserÂ Â Â Â </p>', '<p>Samsung Galaxy Story</p><p><br></p><p>asdasd</p>', '', '', '', 'admin', 0, -1, 0, 0, 1),
(1, 2, 1, 14, 2, 1, 1, 'microsoft bankrott', 'microsoft-bankrott', 'MS Subtitle', '2016-10-22 16:03:20', '2016-11-03 07:01:57', '2016-10-22 16:02:34', '0000-00-00 00:00:00', '<p>Samsung Galaxy TeaserÂ Â Â Â </p>', 'Microsoft vor dem Aus Story. Ka wunder bei dem Schei&szlig; IE!!!!<br><img src="media/images/w123.jpg" class="img-thumbnail">', '', '', '', '', 1, -1, 0, 0, 2);

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
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 3, 0, 1);

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
(27, 'Allura', 'Allura, cursive', 1),
(28, 'Satisfy', 'Satisfiy, cursive', 1),
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
(48, 'Special Elite', 'Special Elite', 1),
(49, 'Frijole', 'Frijole, cursive', 1),
(50, 'Press Start 2P', 'Press Start 2P, cursive', 1),
(51, 'Oleo Script Swash Caps', 'Oleo Script Swash Caps, cursive', 1),
(52, 'Kaushan Script', 'Kaushan Script, cursive', 1),
(53, 'Open Sans Condensed', 'Open Sans Condensed', 1),
(54, 'Nothing You Could Do', 'Nothing You Could Do, cursive', 1),
(55, 'Maven Pro', 'Maven Pro, sans-serif', 1),
(57, 'Short Stack', 'Short Stack, cursive', 1),
(58, 'Merriweather Sans', 'Merriweather Sans, sans-serif', 1),
(59, 'Josefin Sans', 'Josefin Sans, sans-serif', 1),
(61, 'Hind Vadodara', 'Hind Vadodara, cursive', 1),
(62, 'Sahitya', 'Sahitya, serif', 1),
(63, 'Lustria', 'Lustria, serif', 1),
(64, 'Marcellus SC', 'Marcellus SC, serif', 1),
(66, 'Jaldi', 'Jaldi, sans-serif', 1),
(67, 'Pragati Narrow', 'Pragati Narrow, sans-serif', 1),
(68, 'Righteous', 'Righteous, cursive', 1),
(69, 'Fredoka One', 'Fredoka One, cursive', 1),
(70, 'Itim', 'Itim, cursive', 1),
(71, 'Oxygen Mono', 'Oxygen Mono, monospace', 1),
(72, 'Anonymous Pro', 'Anonymous Pro, monospace', 1),
(73, 'Gudea', 'Gudea, sans-serif', 1),
(74, 'Lekton', 'Lekton, sans-serif', 1),
(75, 'Roboto Slab', 'Roboto Slab, serif', 1);

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
(216, '2016-09-30 07:58:13', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'claudia', '12345'),
(217, '2016-10-01 14:01:02', 'backend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(218, '2016-10-01 19:26:00', 'backend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'claudia', '12345'),
(219, '2016-10-03 14:54:42', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', 'test'),
(220, '2016-10-03 14:54:42', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', 'test'),
(221, '2016-10-03 14:54:42', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', 'test'),
(222, '2016-10-03 14:54:47', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', 'admin', '12345'),
(223, '2016-10-07 06:18:03', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(224, '2016-10-07 10:43:41', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'claudia', '12345'),
(225, '2016-10-09 01:33:08', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'admin', 'test'),
(226, '2016-10-09 01:33:08', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'admin', 'test'),
(227, '2016-10-09 01:33:08', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'admin', 'test'),
(228, '2016-10-09 01:33:12', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'admin', '12345'),
(229, '2016-10-09 01:45:22', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', ''),
(230, '2016-10-09 01:45:22', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', ''),
(231, '2016-10-09 01:45:22', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', ''),
(232, '2016-10-09 01:49:48', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(233, '2016-10-09 02:05:22', 'backend', 0, '192.168.1.4', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', 'admin', '12345'),
(234, '2016-10-09 02:13:33', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(235, '2016-10-09 02:13:56', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(236, '2016-10-09 02:14:42', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(237, '2016-10-09 02:48:07', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(238, '2016-10-09 02:53:13', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(239, '2016-10-09 02:59:05', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(240, '2016-10-09 03:02:19', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(241, '2016-10-09 03:16:50', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(242, '2016-10-09 03:17:45', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(243, '2016-10-09 03:21:45', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(244, '2016-10-09 19:12:28', 'backend', 0, '192.168.1.4', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'claudia', '12345'),
(245, '2016-10-10 09:02:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(246, '2016-10-10 09:02:35', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(247, '2016-10-11 13:56:00', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(248, '2016-10-11 13:56:12', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(249, '2016-10-11 13:56:12', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(250, '2016-10-11 14:17:25', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(251, '2016-10-12 00:14:44', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(252, '2016-10-12 02:41:10', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(253, '2016-10-12 02:41:10', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(254, '2016-10-16 03:22:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(255, '2016-10-16 03:22:16', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(256, '2016-10-16 03:22:18', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(257, '2016-10-16 15:51:00', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(258, '2016-10-16 16:10:19', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(259, '2016-10-16 16:10:19', 'frontend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(260, '2016-10-16 16:25:29', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(261, '2016-10-16 19:47:02', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(262, '2016-10-17 03:48:41', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(263, '2016-10-17 16:16:05', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(264, '2016-10-20 19:59:34', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', 'test'),
(265, '2016-10-20 19:59:34', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', 'test'),
(266, '2016-10-20 19:59:34', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', 'test'),
(267, '2016-10-20 19:59:38', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(268, '2016-10-23 01:21:35', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', 'test'),
(269, '2016-10-23 01:21:35', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', 'test');
INSERT INTO `cms_logins` (`id`, `datetime`, `location`, `failed`, `ip`, `useragent`, `username`, `password`) VALUES
(270, '2016-10-23 01:21:35', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', 'test'),
(271, '2016-10-23 01:21:38', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(272, '2016-10-23 01:22:00', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(273, '2016-10-23 01:50:52', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(274, '2016-10-23 03:22:25', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(275, '2016-10-23 03:33:11', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(276, '2016-10-23 03:33:25', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(277, '2016-10-23 03:52:48', 'backend', 0, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', 'test'),
(278, '2016-10-23 03:52:48', 'backend', 1, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', 'test'),
(279, '2016-10-23 03:52:48', 'backend', 1, '192.168.1.5', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', 'test'),
(280, '2016-10-23 08:33:37', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(281, '2016-10-23 08:45:43', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(282, '2016-10-23 08:46:41', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(283, '2016-10-23 08:51:18', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(284, '2016-10-23 08:52:55', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(285, '2016-10-23 08:55:32', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(286, '2016-10-26 23:17:39', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', 'admin', '12345'),
(287, '2016-11-03 00:58:53', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', 'admin', '12345'),
(288, '2016-11-03 01:09:39', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', 'claudia', '12345'),
(289, '2016-11-03 01:09:58', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', 'claudia', '12345'),
(290, '2016-11-03 01:14:07', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(291, '2016-11-03 01:14:37', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', 'claudia', '12345'),
(292, '2016-11-03 02:03:54', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', 'claudia', '12345'),
(293, '2016-11-03 02:54:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0', 'admin', '12345'),
(294, '2016-11-03 03:51:08', 'backend', 0, '192.168.1.8', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Win64; x64; Trident/4.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; Tablet PC 2.0)', 'admin', '12345'),
(295, '2016-11-03 03:56:52', 'backend', 0, '192.168.1.8', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Win64; x64; Trident/4.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; Tablet PC 2.0)', 'admin', '12345'),
(296, '2016-11-03 04:00:50', 'backend', 0, '192.168.1.8', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Win64; x64; Trident/4.0; .NET CLR 2.0.50727; SLCC2; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; Tablet PC 2.0)', 'admin', '12345'),
(297, '2016-11-03 04:38:45', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(298, '2016-11-11 00:24:34', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(299, '2016-11-11 00:24:34', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(300, '2016-11-11 00:24:34', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(301, '2016-11-11 00:24:41', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(302, '2016-11-11 00:27:26', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(303, '2016-11-11 00:27:26', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(304, '2016-11-11 00:27:26', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(305, '2016-11-11 00:27:26', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(306, '2016-11-11 00:27:38', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(307, '2016-11-11 00:27:38', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(308, '2016-11-11 00:27:38', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(309, '2016-11-11 00:27:38', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(310, '2016-11-11 00:27:46', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(311, '2016-11-11 00:27:46', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(312, '2016-11-11 00:27:46', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(313, '2016-11-11 00:27:46', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(314, '2016-11-11 00:27:58', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(315, '2016-11-11 00:27:58', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(316, '2016-11-11 00:27:58', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(317, '2016-11-11 00:27:58', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(318, '2016-11-11 00:28:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(319, '2016-11-11 00:28:20', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(320, '2016-11-11 00:28:41', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(321, '2016-11-11 00:28:41', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(322, '2016-11-11 00:29:16', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(323, '2016-11-11 00:29:16', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(324, '2016-11-11 00:29:46', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(325, '2016-11-11 00:29:46', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(326, '2016-11-11 00:30:04', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(327, '2016-11-11 00:30:04', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(328, '2016-11-11 00:30:59', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(329, '2016-11-11 00:30:59', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(330, '2016-11-11 00:31:00', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(331, '2016-11-11 00:31:00', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(332, '2016-11-11 00:31:58', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(333, '2016-11-11 00:31:58', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(334, '2016-11-11 00:31:59', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(335, '2016-11-11 00:31:59', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(336, '2016-11-11 00:32:02', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(337, '2016-11-11 00:32:02', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(338, '2016-11-11 00:32:35', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(339, '2016-11-11 00:32:35', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(340, '2016-11-11 00:32:55', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(341, '2016-11-11 00:32:55', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(342, '2016-11-11 00:33:17', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(343, '2016-11-11 00:33:17', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(344, '2016-11-11 00:33:29', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(345, '2016-11-11 00:33:29', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(346, '2016-11-11 00:33:54', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(347, '2016-11-11 00:33:54', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(348, '2016-11-11 00:34:11', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(349, '2016-11-11 00:34:11', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(350, '2016-11-11 00:35:41', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(351, '2016-11-11 00:36:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(352, '2016-11-11 00:36:09', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(353, '2016-11-11 00:36:12', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(354, '2016-11-11 00:36:12', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(355, '2016-11-11 00:36:14', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(356, '2016-11-11 00:37:39', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123123'),
(357, '2016-11-11 00:37:39', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123123'),
(358, '2016-11-11 00:37:42', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(359, '2016-11-11 00:37:42', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(360, '2016-11-11 00:37:45', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(361, '2016-11-11 00:39:37', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '4354646'),
(362, '2016-11-11 00:39:37', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '4354646'),
(363, '2016-11-11 00:40:04', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '4354646'),
(364, '2016-11-11 00:40:04', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '4354646'),
(365, '2016-11-11 00:40:38', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '4354646'),
(366, '2016-11-11 00:40:38', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '4354646'),
(367, '2016-11-11 00:40:48', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '4354646'),
(368, '2016-11-11 00:40:48', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '4354646'),
(369, '2016-11-11 00:40:51', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test5464'),
(370, '2016-11-11 00:40:51', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test5464'),
(371, '2016-11-11 00:41:37', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test5464'),
(372, '2016-11-11 00:41:37', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test5464'),
(373, '2016-11-11 00:46:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(374, '2016-11-11 00:46:20', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(375, '2016-11-11 00:46:23', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(376, '2016-11-11 00:48:23', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(377, '2016-11-11 00:48:23', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(378, '2016-11-11 00:50:21', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(379, '2016-11-11 00:50:21', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(380, '2016-11-11 00:50:33', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(381, '2016-11-11 00:50:33', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(382, '2016-11-11 00:50:48', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(383, '2016-11-11 00:50:48', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(384, '2016-11-11 00:50:59', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(385, '2016-11-11 00:50:59', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'testasd'),
(386, '2016-11-11 00:51:41', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(387, '2016-11-11 00:51:41', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(388, '2016-11-11 00:54:53', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(389, '2016-11-11 00:54:53', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(390, '2016-11-11 00:57:00', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(391, '2016-11-11 00:57:00', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(392, '2016-11-11 00:57:12', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(393, '2016-11-11 00:57:12', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(394, '2016-11-11 00:57:40', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(395, '2016-11-11 00:57:40', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(396, '2016-11-11 00:58:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(397, '2016-11-11 00:58:09', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(398, '2016-11-11 00:58:19', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(399, '2016-11-11 00:58:19', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(400, '2016-11-11 00:59:07', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(401, '2016-11-11 00:59:07', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(402, '2016-11-11 00:59:22', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(403, '2016-11-11 00:59:22', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(404, '2016-11-11 00:59:49', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(405, '2016-11-11 00:59:49', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(406, '2016-11-11 01:00:34', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(407, '2016-11-11 01:00:34', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(408, '2016-11-11 01:01:04', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(409, '2016-11-11 01:01:04', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(410, '2016-11-11 01:01:14', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(411, '2016-11-11 01:01:14', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', 'test'),
(412, '2016-11-11 01:01:23', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(413, '2016-11-11 01:01:36', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(414, '2016-11-11 01:01:46', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(415, '2016-11-11 01:01:46', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(416, '2016-11-11 01:01:59', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(417, '2016-11-11 01:01:59', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(418, '2016-11-11 01:02:19', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(419, '2016-11-11 01:04:24', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(420, '2016-11-11 01:04:46', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(421, '2016-11-11 01:04:53', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(422, '2016-11-11 01:04:53', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(423, '2016-11-11 01:04:53', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(424, '2016-11-11 01:04:53', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(425, '2016-11-11 01:05:08', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(426, '2016-11-11 01:05:08', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(427, '2016-11-11 01:05:08', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(428, '2016-11-11 01:05:08', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(429, '2016-11-11 01:05:29', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(430, '2016-11-11 01:05:29', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(431, '2016-11-11 01:05:32', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(432, '2016-11-11 01:05:32', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(433, '2016-11-11 01:05:39', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(434, '2016-11-11 01:05:39', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(435, '2016-11-11 01:05:39', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(436, '2016-11-11 01:05:39', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(437, '2016-11-11 01:05:50', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(438, '2016-11-11 01:06:12', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(439, '2016-11-11 01:06:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(440, '2016-11-11 01:06:20', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(441, '2016-11-11 01:06:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(442, '2016-11-11 01:06:20', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(443, '2016-11-11 01:06:30', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(444, '2016-11-11 01:06:30', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(445, '2016-11-11 01:06:30', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(446, '2016-11-11 01:06:30', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(447, '2016-11-11 01:07:44', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(448, '2016-11-11 01:07:44', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(449, '2016-11-11 01:07:44', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(450, '2016-11-11 01:07:44', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(451, '2016-11-11 01:07:52', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(452, '2016-11-11 01:07:52', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(453, '2016-11-11 01:07:52', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(454, '2016-11-11 01:07:52', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(455, '2016-11-11 01:08:19', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(456, '2016-11-11 01:08:19', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(457, '2016-11-11 01:08:19', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(458, '2016-11-11 01:08:19', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(459, '2016-11-11 01:08:37', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(460, '2016-11-11 01:08:37', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(461, '2016-11-11 01:08:37', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(462, '2016-11-11 01:08:37', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(463, '2016-11-11 01:10:26', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(464, '2016-11-11 01:10:26', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(465, '2016-11-11 01:10:28', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(466, '2016-11-11 01:10:43', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(467, '2016-11-11 01:11:05', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(468, '2016-11-11 01:11:15', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(469, '2016-11-11 01:11:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(470, '2016-11-11 01:11:26', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(471, '2016-11-11 01:11:26', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(472, '2016-11-11 01:11:36', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(473, '2016-11-11 01:11:36', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(474, '2016-11-11 01:11:36', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(475, '2016-11-11 01:11:36', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(476, '2016-11-11 01:11:55', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(477, '2016-11-11 01:11:55', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(478, '2016-11-11 01:11:55', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(479, '2016-11-11 01:11:55', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(480, '2016-11-11 01:12:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(481, '2016-11-11 01:12:09', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(482, '2016-11-11 01:12:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(483, '2016-11-11 01:12:09', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(484, '2016-11-11 01:12:38', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(485, '2016-11-11 01:12:38', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(486, '2016-11-11 01:12:38', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(487, '2016-11-11 01:12:38', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(488, '2016-11-11 01:12:50', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(489, '2016-11-11 01:12:50', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(490, '2016-11-11 01:13:00', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(491, '2016-11-11 01:13:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(492, '2016-11-11 01:15:10', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(493, '2016-11-11 01:18:33', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(494, '2016-11-11 01:18:42', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(495, '2016-11-11 01:18:50', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(496, '2016-11-11 01:18:50', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(497, '2016-11-11 01:18:50', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(498, '2016-11-11 01:18:50', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(499, '2016-11-11 01:22:31', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(500, '2016-11-11 01:22:31', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(501, '2016-11-11 01:22:31', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(502, '2016-11-11 01:22:31', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', '', ''),
(503, '2016-11-11 01:22:39', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(504, '2016-11-11 16:04:18', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(505, '2016-11-11 16:04:27', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(506, '2016-11-11 16:04:27', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(507, '2016-11-11 16:04:27', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(508, '2016-11-11 16:04:27', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(509, '2016-11-11 16:04:46', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(510, '2016-11-11 20:23:51', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(511, '2016-11-11 20:23:51', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(512, '2016-11-11 20:23:51', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(513, '2016-11-11 20:23:51', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(514, '2016-11-11 20:24:22', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(515, '2016-11-11 20:24:22', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(516, '2016-11-11 20:24:22', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(517, '2016-11-11 20:24:22', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '123456'),
(518, '2016-11-11 20:24:51', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36', 'admin', '12345'),
(519, '2016-11-20 11:35:26', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(520, '2016-11-20 11:35:26', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(521, '2016-11-20 11:35:26', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(522, '2016-11-20 11:35:26', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(523, '2016-11-20 11:36:43', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(524, '2016-11-20 11:36:43', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(525, '2016-11-20 11:36:43', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(526, '2016-11-20 11:36:43', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(527, '2016-11-20 11:36:54', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(528, '2016-11-20 11:36:54', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(529, '2016-11-20 11:36:54', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(530, '2016-11-20 11:36:54', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(531, '2016-11-20 11:38:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(532, '2016-11-20 11:38:09', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(533, '2016-11-20 11:38:09', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(534, '2016-11-20 11:38:09', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(535, '2016-11-20 11:38:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(536, '2016-11-20 11:38:20', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(537, '2016-11-20 11:38:20', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456');
INSERT INTO `cms_logins` (`id`, `datetime`, `location`, `failed`, `ip`, `useragent`, `username`, `password`) VALUES
(538, '2016-11-20 11:38:20', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(539, '2016-11-20 11:38:30', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(540, '2016-11-20 11:38:30', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(541, '2016-11-20 11:38:31', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(542, '2016-11-20 11:38:31', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(543, '2016-11-20 11:39:10', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '12345'),
(544, '2016-11-21 00:51:14', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '12345'),
(545, '2016-11-21 00:55:17', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '12345'),
(546, '2016-11-21 13:28:29', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'claudia', '12345'),
(547, '2016-11-21 14:11:24', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '12345'),
(548, '2016-11-21 21:41:25', 'backend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'claudia', '12345'),
(549, '2016-11-21 21:44:06', 'frontend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'claudia', '12345'),
(550, '2016-11-21 21:44:06', 'frontend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'claudia', '12345'),
(551, '2016-11-21 21:44:41', 'frontend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'claudia', '12345'),
(552, '2016-11-21 21:44:41', 'frontend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'claudia', '12345'),
(553, '2016-11-21 21:51:00', 'backend', 0, '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.2.2; de-at; GT-I9060 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', 'Claudia', '2345'),
(554, '2016-11-21 21:51:00', 'backend', 1, '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.2.2; de-at; GT-I9060 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', 'Claudia', '2345'),
(555, '2016-11-21 21:51:00', 'backend', 0, '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.2.2; de-at; GT-I9060 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', 'Claudia', '2345'),
(556, '2016-11-21 21:51:00', 'backend', 1, '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.2.2; de-at; GT-I9060 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', 'Claudia', '2345'),
(557, '2016-11-21 21:51:28', 'backend', 0, '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.2.2; de-at; GT-I9060 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', 'claudia', '12345'),
(558, '2016-11-24 05:14:59', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(559, '2016-11-24 05:14:59', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(560, '2016-11-24 05:14:59', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(561, '2016-11-24 05:14:59', 'backend', 1, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '123456'),
(562, '2016-11-24 05:15:11', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '12345'),
(563, '2016-11-24 06:54:30', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', 'test'),
(564, '2016-11-24 06:54:30', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', 'test'),
(565, '2016-11-24 06:54:31', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', 'test'),
(566, '2016-11-24 06:54:31', 'backend', 1, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', 'test'),
(567, '2016-11-24 06:54:41', 'backend', 0, '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '12345'),
(568, '2016-11-24 13:46:46', 'frontend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', 'claudia', '12345'),
(569, '2016-11-24 13:46:46', 'frontend', 0, '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', 'claudia', '12345'),
(570, '2016-12-05 16:33:12', 'backend', 0, '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', 'admin', '12345');

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
(1, 3, 1, 1, 1, 0, 1, '0000-00-00 00:00:00', '2016-10-22 22:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Startseite', 'index.html', '_self', 0, 0),
(2, 2, 2, 1, 1, 0, 1, '0000-00-00 00:00:00', '2016-10-22 22:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Styling', 'override-bootstrap-style-settings-theme-generator.html', '_self', 0, 0),
(3, 1, 3, 2, 1, 0, 0, '0000-00-00 00:00:00', '2016-10-22 22:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Userpage', 'welcome.html', '_self', 0, 0),
(26, 8, 7, 1, 1, 0, 1, '0000-00-00 00:00:00', '2016-10-22 22:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'W126', 'w126.html', '_self', 0, 0),
(30, 9, 8, 1, 1, 0, 0, '2016-10-11 13:55:40', '2016-10-22 22:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'logout', 'logout.html', '_self', 0, 0),
(31, 10, 9, 1, 1, 0, 1, '0000-00-00 00:00:00', '2016-10-22 22:05:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Newsfeed', 'newsfeed.html', '_self', 0, 1),
(33, 12, 11, 1, 1, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'mercedes-benz', 'mercedes-benz.html', '_self', 0, 0),
(35, 1, 1, 1, 2, 0, 0, '2016-11-03 06:24:40', '2016-11-03 06:36:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'mercedes-benz', 'mercedes-benz.html', '_self', 0, 0),
(36, 1, 2, 1, 2, 0, 0, '2016-11-03 06:26:00', '2016-11-03 06:36:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'TesteintrÃ¤ge', '#', '_self', 0, 0),
(37, 1, 3, 1, 2, 2, 0, '2016-11-03 06:26:06', '2016-11-03 06:36:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Eintrag 1', '#', '_self', 0, 0),
(38, 2, 4, 1, 2, 2, 1, '2016-11-03 06:26:12', '2016-11-03 06:36:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Eintrag 2', '#', '_self', 0, 0),
(39, 3, 5, 1, 2, 2, 1, '2016-11-03 06:26:18', '2016-11-03 06:36:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Eintrag 3', '#', '_self', 0, 0);

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
(10, 'description', 11, 'W123'),
(11, 'description', 12, 'Test Menu'),
(13, 'description', 14, 'Blog #2                                                                                             '),
(15, 'description', 16, 'Ms bankrott kopie                                                 '),
(18, 'description', 19, '333333'),
(19, 'description', 20, 'sadasdasd'),
(20, 'description', 21, 'sadasdasd'),
(21, 'description', 22, 'asaasdasddd'),
(22, 'description', 23, 'asd'),
(23, 'description', 24, 'sssss'),
(24, 'keywords', 2, ''),
(26, 'keywords', 4, 'keyword1, keyword2, keyword3, keyword4'),
(27, 'keywords', 5, 'keyword1, keyword2, keyword3, keyword4'),
(29, 'keywords', 7, 'keyword1, keyword2, keyword3, keyword4'),
(30, 'keywords', 8, ''),
(31, 'keywords', 9, ''),
(32, 'keywords', 10, ''),
(33, 'keywords', 11, 'E-Klasse, W123, 70er Jahre, Oldtimer'),
(34, 'keywords', 12, 'keyword1, keyword2, keyword3, keyword4'),
(36, 'keywords', 14, 'keyword1, keyword2, keyword3, keyword4'),
(38, 'keywords', 16, 'ms, kopie, copy, bankrott'),
(41, 'keywords', 19, ''),
(42, 'keywords', 20, ''),
(43, 'keywords', 21, ''),
(44, 'keywords', 22, ''),
(45, 'keywords', 23, ''),
(46, 'keywords', 24, ''),
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
(68, 'keywords', 2, '');

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
(1, '0000-00-00 00:00:00', 1, 0, 1, 0, 0, 0);

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
(1, 1, 1, '2016-08-19 09:43:45', '2016-10-05 23:15:20', '2016-08-19 09:43:45', '0000-00-00 00:00:00', 'index', 'Startseite', '', -1, 0, 0, 0, '0'),
(2, 1, 1, '2016-08-19 09:58:39', '2016-11-03 02:00:42', '2016-08-19 09:58:39', '0000-00-00 00:00:00', 'override-bootstrap-style-settings-theme-generator', 'Styling', '', -1, 0, 0, 0, '0'),
(3, 1, 2, '2016-08-19 10:54:00', '2016-08-19 10:57:07', '2016-08-19 10:54:00', '0000-00-00 00:00:00', 'welcome', 'Userpage', '', -1, 0, 1, 0, '8'),
(4, 0, 1, '2016-09-12 14:32:17', '2016-09-12 14:36:13', '2016-09-12 14:32:17', '0000-00-00 00:00:00', 'logout', 'logout', '', -1, 0, 1, 0, '0'),
(5, 1, 1, '2016-09-15 02:58:56', '0000-00-00 00:00:00', '2016-09-15 02:58:56', '0000-00-00 00:00:00', 'terms-of-service', 'terms-of-service', '', -1, 0, 0, 0, '7'),
(11, 1, 1, '2016-10-10 05:40:29', '2016-11-05 20:04:32', '2016-10-10 05:40:29', '0000-00-00 00:00:00', 'w126', 'W126', '', -1, 0, 0, 0, '0'),
(12, 1, 1, '2016-10-22 02:11:41', '0000-00-00 00:00:00', '2016-10-22 02:11:41', '0000-00-00 00:00:00', 'newsfeed', 'Newsfeed', '', -1, 0, 1, 1, '3'),
(13, 1, 1, '2016-10-22 16:03:20', '0000-00-00 00:00:00', '2016-10-22 16:03:20', '0000-00-00 00:00:00', 'samsung-galaxy-7-explodiert', 'Samsung Galaxy 7 explodiert', '', -1, 0, 1, 1, '3'),
(14, 1, 1, '2016-10-22 16:03:35', '0000-00-00 00:00:00', '2016-10-22 16:03:35', '0000-00-00 00:00:00', 'microsoft-bankrott', 'microsoft bankrott', '', -1, 0, 1, 1, '3'),
(16, 1, 1, '2016-11-03 01:57:19', '2016-11-03 06:40:38', '2016-11-02 01:25:19', '0000-00-00 00:00:00', 'mercedes-benz', 'mercedes-benz', '', -1, 0, 0, 0, '0');

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
(4, 0, 'media/images/dreads', 'Dreadlocks Hair', '', '', '', 1, 300, 0, 'thumbnail', 250, 250, 'WoD', 1, 'bottom right', '', '-12', '-12', '../system/fonts/delicious.ttf', '23', '.5', 'FCFCFC', 'E32424', '1'),
(8, 0, 'media/images/W123', 'W123, 1983', 'W123 Beschreibung', '', '', 1, 320, 0, 'thumbnail', 1180, 786, 'www.mercedesgarage.at', 1, 'bottom right', '', '-12', '-12', '../system/fonts/delicious.ttf', '24', '.5', 'E8E8E8', '424242', '1'),
(9, 0, 'media/images/W123-gruen', 'W123, 1983', 'W123 Beschreibung', '', '', 1, 200, 0, 'fit_to_width', 500, 500, 'www.mercedesgarage.at', 1, 'bottom right', '', '-12', '-12', '../system/fonts/delicious.ttf', '24', '.5', 'E8E8E8', '424242', '1'),
(10, 0, 'media/images/W126', '560 AMG SEC', 'W126 Beschreibung', '', '', 1, 300, 0, 'fit_to_width', 0, 0, 'www.mercedesgarage.at', 0, 'bottom right', '', '-12', '-12', '../system/fonts/delicious.ttf', '12', '.5', 'E8E8E8', '424242', '1');

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
(72, 4, 0, '1.jpg', 'Dreadlocks Hair', '', ''),
(73, 4, 0, '14276536_916225485148291_1634835022_n.jpg', 'Dreadlocks Hair', '', ''),
(74, 4, 0, '168ac63b1e837fa6b565df4dc1b77c5c.jpg', 'Dreadlocks Hair', '', ''),
(75, 4, 0, '24d01bb3a6dc67a637455bc1df2ac00b.jpg', 'Dreadlocks Hair', '', ''),
(76, 4, 0, '2642828af84d8c483f9d335742e477b5.jpg', 'Dreadlocks Hair', '', ''),
(78, 4, 0, '50fb473fbd67a6a6351b5e5c2478735f.jpg', 'Dreadlocks Hair', '', ''),
(79, 4, 0, '6971a0ad34c2c74b64ddc9e2c765265a.jpg', 'Dreadlocks Hair', '', ''),
(80, 4, 0, '8c9704a9c2685bcb42f972ab4eee807c.jpg', 'Dreadlocks Hair', '', ''),
(81, 4, 0, '8d93f9ea6b00345d640f875419a755af.jpg', 'Dreadlocks Hair', '', ''),
(82, 4, 0, '900full-anna-april.jpg', 'Dreadlocks Hair', '', ''),
(83, 4, 0, 'a04d398d86b0fa6138b1bb12b8af0bc0.jpg', 'Dreadlocks Hair', '', ''),
(84, 4, 0, 'a0721dcd912d976ed5f1c836858f10fe.jpg', 'Dreadlocks Hair', '', ''),
(85, 4, 0, 'ba010fa8eac8afa057b79bc93bde6107.jpg', 'Dreadlocks Hair', '', ''),
(86, 4, 0, 'blacky.jpg', 'Dreadlocks Hair', '', ''),
(87, 4, 0, 'blonde_pink_purple_turqoise_lilac_dreads_1_by_sassperella-d5j3aik.jpg', 'Dreadlocks Hair', '', ''),
(88, 4, 0, 'body-dreads-fitnes-girl-Favim.com-2920278.jpg', 'Dreadlocks Hair', '', ''),
(89, 4, 0, 'daf2aacda458096e0d511b77f7da4640.jpg', 'Dreadlocks Hair', '', ''),
(90, 4, 0, 'dread-gyal.jpg', 'Dreadlocks Hair', '', ''),
(91, 4, 0, 'dreadlock-red-2.jpg', 'Dreadlocks Hair', '', ''),
(92, 4, 0, 'dreadlocks-img_19.jpg', 'Dreadlocks Hair', '', ''),
(93, 4, 0, 'dreads402950_4010365790644_172542481_n.jpg', 'Dreadlocks Hair', '', ''),
(94, 4, 0, 'e47251992964deda192ab6643c694f71.jpg', 'Dreadlocks Hair', '', ''),
(95, 4, 0, 'ec656474fc7ab645c5240139291c908d.jpg', 'Dreadlocks Hair', '', ''),
(96, 4, 0, 'ef6735d611b197a4fa058f885bbb6d9a.jpg', 'Dreadlocks Hair', '', ''),
(97, 4, 0, 'hqdefault.jpg', 'Dreadlocks Hair', '', ''),
(98, 4, 0, 'I1ewtfv.jpg', 'Dreadlocks Hair', '', ''),
(99, 4, 0, 'il_fullxfull.791937992_nnr4.jpg', 'Dreadlocks Hair', '', ''),
(100, 4, 0, 'images (1).jpg', 'Dreadlocks Hair', '', ''),
(101, 4, 0, 'images (2).jpg', 'Dreadlocks Hair', '', ''),
(102, 4, 0, 'images (3).jpg', 'Dreadlocks Hair', '', ''),
(103, 4, 0, 'images (4).jpg', 'Dreadlocks Hair', '', ''),
(104, 4, 0, 'images.jpg', 'Dreadlocks Hair', '', ''),
(105, 4, 0, 'keeper-of-the-forest.jpg', 'Dreadlocks Hair', '', ''),
(106, 4, 0, 'large (1).jpg', 'Dreadlocks Hair', '', ''),
(107, 4, 0, 'large (2).jpg', 'Dreadlocks Hair', '', ''),
(108, 4, 0, 'large.jpg', 'Dreadlocks Hair', '', ''),
(109, 4, 0, 'maxresdefault.jpg', 'Dreadlocks Hair', '', ''),
(110, 4, 0, 'oHy7keo.jpg', 'Dreadlocks Hair', '', ''),
(111, 4, 0, 'original.jpg', 'Dreadlocks Hair', '', ''),
(112, 4, 0, 'piercings_and_dreadlocks_by_luftballong-d64j6mv.jpg', 'Dreadlocks Hair', '', ''),
(113, 4, 0, 'red-dreadlocks-1.jpg', 'Dreadlocks Hair', '', ''),
(114, 4, 0, 'superthumb.jpg', 'Dreadlocks Hair', '', ''),
(115, 4, 0, 'tumblr_mdpfdc0O9S1r902fco2_500.jpg', 'Dreadlocks Hair', '', ''),
(116, 4, 0, 'tumblr_mfrgglbDJs1rv24soo1_540.jpg', 'Dreadlocks Hair', '', ''),
(117, 4, 0, 'tumblr_mq5y3oGBjF1rcx66so1_1280.jpg', 'Dreadlocks Hair', '', ''),
(118, 4, 0, 'tumblr_mq8oc27JkL1sppbaso1_500.jpg', 'Dreadlocks Hair', '', ''),
(119, 4, 1, 'tumblr_n344hcnYUT1rab8pro6_1280.jpg', 'Dreadlocks Hair', '', ''),
(120, 4, 2, 'uwr64x6u561a056f59b19580039668.jpg', 'Dreadlocks Hair', '', ''),
(174, 8, 1, '12695030_1677143422568473_5039062717722339065_o.jpg', 'W123, 1983', '', ''),
(175, 8, 2, '12696899_1677142805901868_8085704455650964678_o.jpg', 'W123, 1983', '', ''),
(176, 8, 3, '3676720051_b0137a7ffd_b.jpg', 'W123, 1983', '', ''),
(177, 8, 4, 'ruckbank.jpg', 'W123, 1983', '', ''),
(178, 8, 5, 't-modell.jpg', 'W123, 1983', '', ''),
(179, 8, 6, 't-seite.jpg', 'W123, 1983', '', ''),
(181, 9, 2, '12799086_848326991956280_5817508020644492758_n.jpg', 'W123, 1983', '', ''),
(182, 9, 3, '12799317_848326631956316_3813086817385290843_n.jpg', 'W123, 1983', '', ''),
(183, 9, 4, '12799393_848326938622952_5970794659999518523_n.jpg', 'W123, 1983', '', ''),
(184, 9, 5, '12801210_848326658622980_5458252940704484945_n.jpg', 'W123, 1983', '', ''),
(185, 9, 6, '12803190_848327225289590_2668887040733595955_n.jpg', 'W123, 1983', '', ''),
(186, 9, 7, '12803294_848326771956302_8618617547552319109_n.jpg', 'W123, 1983', '', ''),
(188, 9, 9, '12806018_848327188622927_7257332800429910752_n.jpg', 'W123, 1983', '', ''),
(189, 9, 10, '12806041_848327181956261_7048329964599614608_n.jpg', 'W123, 1983', '', ''),
(190, 9, 11, '12806105_848326965289616_7010376505058916141_n.jpg', 'W123, 1983', '', ''),
(191, 9, 12, '12806222_848327011956278_6381066445890988576_n.jpg', 'W123, 1983', '', ''),
(192, 9, 13, '12821552_848327128622933_3183577451854840856_n.jpg', 'W123, 1983', '', ''),
(193, 9, 14, 'seite.jpg', 'W123, 1983', '', ''),
(194, 9, 15, 'sitze.jpg', 'W123, 1983', '', ''),
(199, 10, 5, 'AMG-felgen.jpg', '560 AMG SEC', '', ''),
(200, 10, 6, 'amg-plakette.jpg', '560 AMG SEC', '', ''),
(201, 10, 7, 'auspuff.jpg', '560 AMG SEC', '', ''),
(202, 10, 1, 'front.jpg', '560 AMG SEC', '', ''),
(203, 10, 9, 'holz.jpg', '560 AMG SEC', '', ''),
(204, 10, 10, 'inneninEngland22.jpg', '560 AMG SEC', '', ''),
(205, 10, 11, 'kofferraum.jpg', '560 AMG SEC', '', ''),
(206, 10, 12, 'leder.jpg', '560 AMG SEC', '', ''),
(207, 10, 13, 'motorblock.jpg', '560 AMG SEC', '', ''),
(208, 10, 14, 'motorraum.jpg', '560 AMG SEC', '', ''),
(209, 10, 2, 'seite.jpg', '560 AMG SEC', '', ''),
(210, 10, 3, 'upside.jpg', '560 AMG SEC', '', '');

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
(1, 0, '2016-09-14 00:36:26', 1, 1, 'test', 1, 0, 1),
(2, 0, '2016-11-22 06:47:47', 1, 1, 'asdasdasd', 1, 0, 0),
(3, 0, '2016-11-22 06:48:00', 1, 2, 'twerwerwer', 0, 0, 0),
(4, 0, '2016-11-22 06:48:28', 1, 1, 'test', 1, 0, 0),
(5, 0, '2016-11-22 06:48:40', 1, 1, 'test 2', 1, 0, 0),
(6, 0, '2016-11-22 13:37:36', 1, 1, 'test', 1, 0, 0);

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
('backendFooterValueLeft', 'http://yawk.io', '', 11, 2, 1, 'BACKENDFOOTERVALUE_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFooterValueRight', 'proudly presented by <b>YaWK :: <small> Yet another Web Kit</b></small>', '', 11, 2, 1, 'BACKENDFOOTERVALUERIGHT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFX', '0', '', 2, 3, 1, 'BACKENDFX_LABEL', 'fa fa-paper-plane-o', 'BACKENDFX_HEADING', 'BACKENDFX_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendFXtime', '820', '', 2, 5, 1, 'BACKENDFXTIME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFXtype', 'fadeIn In', '', 2, 4, 1, 'BACKENDFXTYPE_LABEL', '', '', '', 'form-control', 'select', '', '', 'fadeIn,Fade In:slideDown,Slide Down'),
('backendLayout', 'sidebar-mini', '', 2, 2, 1, 'BACKENDLAYOUT_LABEL', '', '', '', 'form-control', 'select', '', 'BACKENDLAYOUT_DESC', 'fixed,Fixed:sidebar-collapse,Sidebar Collapse:sidebar-mini,Sidebar Mini:layout-boxed,Layout Boxed:layout-top-nav,Layout Top Nav'),
('backendLogoSubText', 'frontend', '', 12, 2, 1, 'BACKENDLOGOSUBTEXT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendLogoText', 'YaWK', '', 12, 1, 1, 'BACKENDLOGOTEXT_LABEL', 'fa fa-bars', 'BACKENDLOGOTEXT_HEADING', 'BACKENDLOGOTEXT_SUBTEXT', 'form-control', 'input', '', '', ''),
('backendLogoUrl', '0', '', 12, 3, 1, 'BACKENDLOGOURL_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendMessagesMenu', '1', '', 12, 4, 1, 'BACKENDMSGMENU_LABEL', 'fa fa-bell-o', 'BACKENDMSGMENU_HEADING', 'BACKENDMSGMENU_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendNotificationMenu', '1', '', 12, 5, 1, 'BACKENDNOTIFYMENU_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendSkin', 'skin-wp-style', '', 2, 1, 1, 'BACKENDSKIN_LABEL', 'fa fa-paint-brush', 'BACKENDSKIN_HEADING', 'BACKENDSKIN_SUBTEXT', 'form-control', 'select', '', '', 'skin-blue,Blue:skin-green,Green:skin-red,Red:skin-yellow,Yellow:skin-purple,Purple:skin-black,Black:skin-yellow-light,Yellow Light:skin-wp-style,Wordpress Style'),
('dbhost', 'http://localhost', '', 9, 2, 1, 'DBHOST_LABEL', 'fa fa-database', 'DATABASE_HEADING', 'DATABASE_SUBTEXT', 'form-control', 'input', 'http://localhost/', '', ''),
('dbname', 'yawk_lte', '', 9, 1, 1, 'DBNAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('dbport', '3306', '', 9, 6, 1, 'DBPORT_LABEL', '', '', '', 'form-control', 'input', 'default:3306', '', ''),
('dbprefix', 'cms_', '', 9, 5, 1, 'DBPREFIX_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('dbpwd', 'test', '', 9, 4, 1, 'DBPWD_LABEL', '', '', '', 'form-control', 'password', '', '', ''),
('dbusername', 'root', '', 9, 3, 1, 'DBUSERNAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('defaultemailtext', '', 'Hello $user,\\n\\n\\Thank you for registering on site\\n\\n$url', 5, 0, 1, 'Default SignUp Email Message', '', '', '', 'form-control', 'textarea', '', '', ''),
('dirprefix', '/yawk-LTE', '', 9, 0, 1, 'DIRPREFIX_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('domain', 'localhost.net', '', 1, 4, 1, 'DOMAIN_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('editorActiveLine', '1', '', 14, 2, 1, 'EDITOR_ACTIVE_LINE_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_ACTIVE_LINE_DESC', ''),
('editorAutoCodeview', '0', '', 14, 9, 1, 'EDITOR_AUTO_CODEVIEW_LABEL', '', '', '', 'form-control', 'checkbox', '', 'EDITOR_AUTO_CODEVIEW_DESC', ''),
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
('host', 'http://192.168.1.8/yawk-LTE', '', 1, 3, 1, 'HOST_LABEL', '', '', '', 'form-control', 'input', '', 'DATABASE_DESC', ''),
('loadingTime', '0', '', 11, 3, 1, 'LOADINGTIME_LABEL', 'fa fa-signal', 'LOADINGTIME_HEADING', 'LOADINGTIME_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('logoutmenuid', '1', '', 6, 0, 1, 'Logout Menu ID for logged-in Users', '', '', '', 'form-control', '', '', '', ''),
('offline', '0', '', 8, 0, 1, 'OFFLINE_LABEL', 'fa fa-wrench', 'OFFLINE_HEADING', 'OFFLINE_SUBTEXT', 'form-control', 'checkbox', '', 'OFFLINE_DESC', ''),
('offlineimage', 'media/images/closed-sign-tm.jpg', '', 8, 0, 1, 'OFFLINEIMAGE_LABEL', '', '', '', 'form-control', 'input', 'media/images/logo.jpg', 'OFFLINEIMAGE_DESC', ''),
('offlinemsg', '<h1>Wartungsarbeiten</h1><h3>Bitte schau spÃ¤ter nochmal vorbei.</h3>', '', 8, 0, 1, 'OFFLINEMSG_LABEL', '', '', '', 'form-control', 'textarea', '', '', ''),
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
('sitename', 'YaWK - yet another webkit - CMS', '', 1, 2, 1, 'SITENAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('statsEnable', '1', '', 13, 2, 1, 'STATS_LABEL', 'fa fa-bar-chart', 'STATS_HEADING', 'STATS_SUBTEXT', 'form-control', 'select', '', 'STATS_DESC', '0,off:1,on'),
('syslogEnable', '1', '', 13, 1, 1, 'SYSLOG_LABEL', 'fa fa-terminal', 'SYSLOG_HEADING', 'SYSLOG_SUBTEXT', 'form-control', 'select', '', 'SYSLOG_DESC', '0,off:1,on'),
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
('yawkversion', '0.7.0', '', 9, 2, 1, 'YAWKVERSION_LABEL', '', '', '', 'form-control', 'input', '', '', '');

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
(16, 'database');

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
(1, 2, 4, 1, '', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 16:56:40', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(2, 2, 4, 1, '', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 16:56:41', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(3, 2, 4, 1, '', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 16:56:41', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(4, 0, 0, 0, '', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-22 16:57:03', '', 'welcome'),
(5, 0, 0, 0, '', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-22 16:57:04', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(6, 0, 0, 0, '', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-22 16:57:08', 'http://192.168.1.8/yawk-LTE/welcome.html', 'index'),
(7, 0, 0, 0, '', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-22 16:57:11', 'http://192.168.1.8/yawk-LTE/index.html', 'welcome'),
(8, 0, 0, 0, '', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-22 16:57:11', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(9, 1, 5, 1, '', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 16:57:31', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(10, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 17:17:04', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(11, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 17:17:04', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(12, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 19:08:05', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(13, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 19:08:25', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'override-bootstrap-style-settings-theme-generator'),
(14, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 19:08:26', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(15, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 19:08:26', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(16, 2, 4, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.4', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 19:22:56', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(17, 2, 4, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.4', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-22 19:22:57', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(18, 2, 4, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-23 21:12:17', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(19, 2, 4, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-23 21:12:18', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(20, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-23 21:52:14', 'http://192.168.1.8/yawk-LTE/admin/index.php', 'index'),
(21, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-23 21:53:55', 'http://192.168.1.8/yawk-LTE/admin/index.php', 'index'),
(22, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-23 21:53:56', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(23, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-23 21:55:21', '', '/yawk-lte/'),
(24, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-23 21:55:24', 'http://192.168.1.8/yawk-lte/', 'welcome'),
(25, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-23 21:55:24', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(26, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-23 22:01:48', 'http://192.168.1.8/yawk-LTE/welcome.html', 'index'),
(27, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-23 22:20:39', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(28, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:41', '', '/yawk-lte/'),
(29, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:43', 'http://192.168.1.8/yawk-lte/', 'newsfeed'),
(30, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:45', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(31, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:46', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'welcome'),
(32, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:46', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(33, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:56', 'http://192.168.1.8/yawk-LTE/welcome.html', 'override-bootstrap-style-settings-theme-generator'),
(34, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:57', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(35, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:58', 'http://192.168.1.8/yawk-LTE/index.html', 'w126'),
(36, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:59', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(37, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:36:59', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(38, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:37:02', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'override-bootstrap-style-settings-theme-generator'),
(39, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:37:03', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(40, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:37:04', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(41, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 03:37:09', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(42, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 08:37:10', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'newsfeed'),
(43, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 08:37:12', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'microsoft-bankrott'),
(44, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 08:37:13', 'http://192.168.1.8/yawk-LTE/microsoft-bankrott.html', 'override-bootstrap-style-settings-theme-generator'),
(45, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 08:37:14', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(46, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 09:37:16', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(47, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 09:37:17', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(48, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 09:37:19', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(49, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 09:37:19', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(50, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 09:37:23', 'http://192.168.1.8/yawk-LTE/welcome.html', 'index'),
(51, 0, 0, 0, 'de-AT', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '', 'Desktop', 'Windows', 'Windows 7', 'Internet Explorer', '11.0', '2016-11-24 09:37:23', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(52, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 03:46:45', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(53, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 03:46:46', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(54, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 03:46:47', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(55, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 09:46:47', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(56, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 09:50:42', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(57, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 07:50:43', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(58, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 08:53:58', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(59, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 07:54:26', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(60, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 03:54:27', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(61, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 07:06:52', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(62, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 07:07:05', '', 'override-bootstrap-style-settings-theme-generator'),
(63, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 07:07:17', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(64, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 07:07:17', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(65, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 07:07:20', 'http://192.168.1.8/yawk-LTE/welcome.html', 'newsfeed'),
(66, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 07:07:23', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(67, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:07:28', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(68, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:07:37', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(69, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 05:07:44', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(70, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 05:07:46', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(71, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 05:07:47', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(72, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 05:07:48', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(73, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 05:07:49', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(74, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 05:07:49', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(75, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-24 05:07:51', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(76, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:07:56', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(77, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:07:59', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(78, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:08:08', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(79, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:08:12', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(80, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:08:25', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(81, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:08:25', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(82, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:08:34', 'http://192.168.1.8/yawk-LTE/welcome.html', 'override-bootstrap-style-settings-theme-generator'),
(83, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:08:38', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(84, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:08:41', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(85, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:08:49', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'mercedes-benz'),
(86, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:08:57', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(87, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:09:03', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(88, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:09:34', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(89, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:09:41', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(90, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:09:58', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(91, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:10:19', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(92, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:10:30', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(93, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:10:40', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(94, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:10:47', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'override-bootstrap-style-settings-theme-generator'),
(95, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:10:59', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'mercedes-benz'),
(96, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:11:13', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'mercedes-benz'),
(97, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-11-24 05:11:19', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(98, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:36', '', 'welcome'),
(99, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:37', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(100, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:39', 'http://192.168.1.8/yawk-LTE/welcome.html', 'index'),
(101, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:40', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(102, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:41', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(103, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:41', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(104, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:42', 'http://192.168.1.8/yawk-LTE/welcome.html', 'newsfeed'),
(105, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:44', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(106, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:46', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'welcome'),
(107, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:46', 'http://192.168.1.8/yawk-LTE/welcome.html', 'welcome'),
(108, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:46', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(109, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:50', 'http://192.168.1.8/yawk-LTE/welcome.html', 'newsfeed'),
(110, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:54', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'index'),
(111, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:56', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(112, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:58', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(113, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:59', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(114, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:59', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(115, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:46:59', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(116, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:00', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(117, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:00', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(118, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:01', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'welcome'),
(119, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:01', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(120, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:02', 'http://192.168.1.8/yawk-LTE/welcome.html', 'index'),
(121, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:02', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(122, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:03', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(123, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:03', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(124, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:04', 'http://192.168.1.8/yawk-LTE/welcome.html', 'newsfeed'),
(125, 2, 4, 1, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.3', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '47.0', '2016-11-24 13:47:04', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(126, 0, 0, 0, 'de-AT, en-US', '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.1.2; de-at; LG-D682 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.1.2', 'Apple Safari', '4.0', '2016-11-25 22:04:41', '', '/yawk-lte/'),
(127, 0, 0, 0, 'de-AT, en-US', '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.1.2; de-at; LG-D682 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.1.2', 'Apple Safari', '4.0', '2016-11-25 22:04:46', '', '/yawk-lte/'),
(128, 0, 0, 0, '', '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.1.2; de-at; LG-D682 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.1.2', 'Apple Safari', '4.0', '2016-11-25 22:04:51', '', 'content/errors/404'),
(129, 0, 0, 0, '', '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.1.2; de-at; LG-D682 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.1.2', 'Apple Safari', '4.0', '2016-11-25 22:04:52', '', 'content/errors/404'),
(130, 0, 0, 0, 'de-AT, en-US', '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.1.2; de-at; LG-D682 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.1.2', 'Apple Safari', '4.0', '2016-11-25 22:08:58', 'http://192.168.1.8/yawk-lte/', 'welcome'),
(131, 0, 0, 0, 'de-AT, en-US', '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.1.2; de-at; LG-D682 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.1.2', 'Apple Safari', '4.0', '2016-11-25 22:08:58', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(132, 0, 0, 0, '', '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.1.2; de-at; LG-D682 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.1.2', 'Apple Safari', '4.0', '2016-11-25 22:08:58', '', 'content/errors/404'),
(133, 0, 0, 0, 'de-AT, en-US', '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.1.2; de-at; LG-D682 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.1.2', 'Apple Safari', '4.0', '2016-11-25 22:09:02', 'http://192.168.1.8/yawk-LTE/welcome.html', 'override-bootstrap-style-settings-theme-generator'),
(134, 0, 0, 0, '', '192.168.1.4', 'Mozilla/5.0 (Linux; U; Android 4.1.2; de-at; LG-D682 Build/JZO54K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.1.2', 'Apple Safari', '4.0', '2016-11-25 22:09:02', '', 'content/errors/404'),
(135, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 19:05:03', 'http://localhost/yawk-LTE/admin/index.php?page=stats', 'index'),
(136, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 19:05:05', 'http://localhost/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(137, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 19:05:06', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'override-bootstrap-style-settings-theme-generator'),
(138, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 19:05:12', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'override-bootstrap-style-settings-theme-generator'),
(139, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 20:37:00', 'http://localhost/yawk-LTE/admin/index.php', 'index'),
(140, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 20:37:45', 'http://localhost/yawk-LTE/admin/index.php', 'index'),
(141, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 20:37:47', 'http://localhost/yawk-LTE/index.html', 'boerns'),
(142, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 20:40:40', 'http://localhost/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(143, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 20:41:06', 'http://localhost/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(144, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 20:41:15', 'http://localhost/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(145, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 20:41:19', 'http://192.168.1.8/yawk-LTE/boerns.html', 'mercedes-benz'),
(146, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-29 21:37:41', 'http://localhost/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(147, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-30 00:30:26', 'http://localhost/yawk-LTE/admin/index.php?page=stats', 'content/errors/404'),
(148, 0, 0, 0, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-11-30 00:30:36', 'http://localhost/yawk-LTE/admin/index.php?page=stats', 'content/errors/404'),
(149, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-01 14:43:19', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(150, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-01 14:43:21', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(151, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-01 14:43:21', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(152, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-12-01 20:34:17', '', '/yawk-lte/'),
(153, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-12-01 20:34:23', 'http://192.168.1.8/yawk-lte/', 'w126'),
(154, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-12-01 20:34:27', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(155, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-12-01 20:34:30', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'newsfeed'),
(156, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-12-01 20:34:31', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(157, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-12-01 22:22:46', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(158, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-12-01 22:22:47', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'newsfeed'),
(159, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-12-01 22:22:48', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(160, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-01 22:46:17', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(161, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-01 22:54:14', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(162, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-01 22:56:01', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(163, 0, 0, 0, 'de,en-US;q=0.7,en;q=0.3', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '', 'Desktop', 'Windows', 'Windows 7', 'Mozilla Firefox', '50.0', '2016-12-01 23:15:28', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz');
INSERT INTO `cms_stats` (`id`, `uid`, `gid`, `logged_in`, `acceptLanguage`, `remoteAddr`, `userAgent`, `device`, `deviceType`, `os`, `osVersion`, `browser`, `browserVersion`, `date_created`, `referer`, `page`) VALUES
(164, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 01:01:09', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'index'),
(165, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:20', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(166, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:21', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(167, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:23', 'http://192.168.1.8/yawk-LTE/index.html', 'newsfeed'),
(168, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:24', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(169, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:25', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(170, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:26', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'welcome'),
(171, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:26', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(172, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:27', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(173, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:33', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(174, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:34', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(175, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:41', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(176, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:44', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'newsfeed'),
(177, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:01:57', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(178, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 01:02:27', 'http://192.168.1.8/yawk-LTE/w126.html', 'index'),
(179, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 01:02:28', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(180, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:02:39', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(181, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:02:39', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(182, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:02:40', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(183, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:02:41', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(184, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:02:41', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(185, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:02:42', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(186, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:02:42', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(187, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:02:43', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(188, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:00', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(189, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:43', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(190, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:43', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(191, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:44', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(192, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:44', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(193, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:44', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(194, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:44', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(195, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:45', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(196, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:45', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(197, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:45', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(198, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:45', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(199, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:45', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(200, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:45', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(201, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:46', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(202, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:46', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(203, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:46', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(204, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:46', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(205, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:47', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(206, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:47', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(207, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows Phone 10.0; Android 4.2.1; Microsoft; Lumia 950) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Mobile Safari/537.36 Edge/14.14263', '', 'Phone', 'Android', '4.2.1', 'Google Chrome', '46.0.2486.0', '2016-12-02 01:03:52', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(208, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:55', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(209, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:55', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(210, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:55', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(211, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:56', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(212, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:56', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(213, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:56', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(214, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:56', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(215, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:56', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(216, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:57', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(217, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:57', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(218, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:57', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(219, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:57', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(220, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:57', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(221, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:58', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(222, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:58', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(223, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:58', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(224, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:58', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(225, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:58', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(226, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:58', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(227, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:59', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(228, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:59', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(229, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:59', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(230, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:59', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(231, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:59', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(232, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:03:59', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(233, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:00', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(234, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:00', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(235, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:00', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(236, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:00', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(237, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:00', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(238, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:01', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(239, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:01', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(240, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:01', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(241, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:01', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(242, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:01', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(243, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:01', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(244, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:02', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(245, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:02', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(246, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:02', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(247, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:02', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(248, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:02', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(249, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:03', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(250, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:03', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(251, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:03', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(252, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:03', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(253, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (PlayBook; U; RIM Tablet OS 2.1.0; en-US) AppleWebKit/536.2+ (KHTML like Gecko) Version/7.2.1.0 Safari/536.2+', '', 'Tablet', '', '', 'Apple Safari', '7.2.1.0', '2016-12-02 01:04:03', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(254, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:04:38', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(255, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 01:04:39', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(256, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 13:17:09', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'index'),
(257, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 13:17:10', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(258, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 13:55:02', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(259, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:16', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'override-bootstrap-style-settings-theme-generator'),
(260, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:21', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'content/errors/404'),
(261, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:21', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(262, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:21', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(263, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:21', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(264, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:21', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(265, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:21', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(266, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:21', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(267, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:21', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(268, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:21:27', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'w126'),
(269, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:58:40', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'w126'),
(270, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 15:58:55', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'index'),
(271, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 15:59:08', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(272, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 15:59:10', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(273, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 15:59:10', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(274, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 15:59:10', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(275, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 15:59:10', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(276, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 15:59:10', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(277, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 15:59:10', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(278, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 15:59:10', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(279, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 15:59:24', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(280, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:18:13', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(281, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:18:21', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(282, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:06', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(283, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:08', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(284, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:08', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(285, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:09', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(286, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:10', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(287, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:11', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(288, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:11', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(289, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:12', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(290, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:13', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(291, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:14', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(292, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:15', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(293, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:20', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(294, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:22', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(295, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:29', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'index'),
(296, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:30', 'http://192.168.1.8/yawk-LTE/index.html', 'newsfeed'),
(297, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:31', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(298, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:32', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(299, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:33', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'samsung-galaxy-7-explodiert'),
(300, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed');
INSERT INTO `cms_stats` (`id`, `uid`, `gid`, `logged_in`, `acceptLanguage`, `remoteAddr`, `userAgent`, `device`, `deviceType`, `os`, `osVersion`, `browser`, `browserVersion`, `date_created`, `referer`, `page`) VALUES
(301, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:36', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'microsoft-bankrott'),
(302, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:19:40', 'http://192.168.1.8/yawk-LTE/microsoft-bankrott.html', 'mercedes-benz'),
(303, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:13', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(304, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:14', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(305, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:14', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(306, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:15', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(307, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:16', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(308, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:16', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(309, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:17', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(310, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:17', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(311, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:18', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(312, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:19', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(313, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:20', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(314, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:20', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(315, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:20', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(316, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:21', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(317, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:22', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(318, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:22', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(319, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:22', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(320, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:23', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(321, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:23', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(322, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:24', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(323, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:24', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(324, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:24', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(325, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:25', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(326, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:25', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(327, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:25', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(328, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:26', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(329, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:26', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(330, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:26', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(331, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:27', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(332, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:27', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(333, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:27', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(334, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:28', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(335, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:28', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(336, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:28', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(337, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:29', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(338, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:29', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(339, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:29', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(340, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:30', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(341, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:30', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(342, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:30', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(343, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:31', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(344, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:31', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(345, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:32', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(346, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:32', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(347, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:32', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(348, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:33', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(349, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:34', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(350, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:34', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(351, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:35', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(352, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(353, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(354, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(355, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:36', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(356, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:36', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(357, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:20:36', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(358, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:00', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'content/errors/404'),
(359, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:00', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(360, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:00', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(361, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:00', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(362, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:00', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(363, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:00', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(364, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:01', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(365, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:01', 'http://192.168.1.8/yawk-LTE/content/errors/404', 'content/errors/404'),
(366, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:21:16', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(367, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:21:16', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(368, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:21:39', 'http://192.168.1.8/yawk-LTE/welcome.html', 'welcome'),
(369, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPad', 'Tablet', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-02 16:21:39', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(370, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:59', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'welcome'),
(371, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:21:59', 'http://192.168.1.8/yawk-LTE/welcome', 'content/errors/404'),
(372, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-02 16:23:17', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(373, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Linux; U; Android 4.0; en-us; GT-I9300 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.0', 'Apple Safari', '4.0', '2016-12-02 16:24:53', 'http://192.168.1.8/yawk-LTE/welcome', 'welcome'),
(374, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Linux; U; Android 4.0; en-us; GT-I9300 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.0', 'Apple Safari', '4.0', '2016-12-02 16:24:53', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(375, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Linux; U; Android 4.0; en-us; GT-I9300 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.0', 'Apple Safari', '4.0', '2016-12-02 16:24:59', 'http://192.168.1.8/yawk-LTE/welcome.html', 'welcome'),
(376, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Linux; U; Android 4.0; en-us; GT-I9300 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.0', 'Apple Safari', '4.0', '2016-12-02 16:24:59', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(377, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Linux; U; Android 4.0; en-us; GT-I9300 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '', 'Phone', 'Android', '4.0', 'Apple Safari', '4.0', '2016-12-02 16:26:35', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(378, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-03 16:04:34', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(379, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-03 16:04:35', 'http://192.168.1.8/yawk-LTE/welcome.html', 'welcome'),
(380, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-03 16:04:36', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(381, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-03 22:14:14', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'mercedes-benz'),
(382, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-03 22:14:18', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'w126'),
(383, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-03 22:15:40', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'w126'),
(384, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-03 22:15:59', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'override-bootstrap-style-settings-theme-generator'),
(385, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-03 23:17:47', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(386, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-03 23:18:06', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(387, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 13:59:20', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(388, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 14:09:02', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'index'),
(389, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 14:09:04', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(390, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 14:09:04', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(391, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 14:09:10', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(392, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:20:16', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&overrideTemplate=1&id=1', '/yawk-LTE/index.php'),
(393, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:20:21', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(394, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:27:38', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(395, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:27:44', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&deletegfont=1&gfontid=56', '/yawk-LTE/index.php'),
(396, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:27:51', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&deletegfont=1&gfontid=26', '/yawk-LTE/index.php'),
(397, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:28:02', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&deletegfont=1&gfontid=30', '/yawk-LTE/index.php'),
(398, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:28:13', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&deletegfont=1&gfontid=47', '/yawk-LTE/index.php'),
(399, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:28:18', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&deletegfont=1&gfontid=29', '/yawk-LTE/index.php'),
(400, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:29:43', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(401, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:29:55', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(402, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:29:56', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(403, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:30:06', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(404, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:30:34', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(405, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:30:49', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(406, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:30:50', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(407, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:30:52', 'http://192.168.1.8/yawk-LTE/index.html', 'welcome'),
(408, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:30:52', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(409, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:31:09', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(410, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:31:11', 'http://192.168.1.8/yawk-LTE/index.html', 'welcome'),
(411, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:31:11', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(412, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:31:37', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(413, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:01', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(414, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:25', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(415, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:30', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(416, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:31', 'http://192.168.1.8/yawk-LTE/index.html', 'welcome'),
(417, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:31', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(418, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:32', 'http://192.168.1.8/yawk-LTE/welcome.html', 'index'),
(419, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:32', 'http://192.168.1.8/yawk-LTE/welcome.html', 'index'),
(420, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:38', 'http://192.168.1.8/yawk-LTE/welcome.html', 'index'),
(421, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:48', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(422, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:48', 'http://192.168.1.8/yawk-LTE/welcome.html', 'index'),
(423, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:51', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(424, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:32:52', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(425, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:33:25', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(426, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:33:32', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(427, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:33:33', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(428, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:33:35', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(429, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:33:37', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(430, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:33:39', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(431, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:33:50', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(432, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:33:52', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(433, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:33:57', 'http://192.168.1.8/yawk-LTE/w126.html', 'index'),
(434, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:34:18', 'http://192.168.1.8/yawk-LTE/index.php', 'override-bootstrap-style-settings-theme-generator'),
(435, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:34:20', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(436, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:34:20', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(437, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:34:21', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(438, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:34:22', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(439, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:34:23', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'index'),
(440, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:34:51', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(441, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:34:56', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(442, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:09', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(443, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:11', 'http://192.168.1.8/yawk-LTE/w126.html', 'index'),
(444, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:15', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator');
INSERT INTO `cms_stats` (`id`, `uid`, `gid`, `logged_in`, `acceptLanguage`, `remoteAddr`, `userAgent`, `device`, `deviceType`, `os`, `osVersion`, `browser`, `browserVersion`, `date_created`, `referer`, `page`) VALUES
(445, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:16', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(446, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:16', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(447, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:17', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(448, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:18', 'http://192.168.1.8/yawk-LTE/w126.html', 'welcome'),
(449, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:18', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(450, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:31', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(451, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:32', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(452, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:33', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(453, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:35:58', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(454, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:01', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(455, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:02', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(456, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:07', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(457, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:10', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'index'),
(458, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:27', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(459, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:28', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'index'),
(460, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:31', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(461, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:32', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(462, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:33', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(463, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:33', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(464, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:35', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(465, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:36:37', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(466, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:01', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(467, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:02', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(468, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:04', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'index'),
(469, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:06', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(470, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:07', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(471, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:07', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(472, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:08', 'http://192.168.1.8/yawk-LTE/welcome.html', 'welcome'),
(473, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:08', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(474, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:09', 'http://192.168.1.8/yawk-LTE/welcome.html', 'newsfeed'),
(475, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:10', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(476, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:18', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(477, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:19', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(478, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:21', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(479, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:39', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(480, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:41', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(481, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:43', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'override-bootstrap-style-settings-theme-generator'),
(482, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:37:45', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(483, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:02', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(484, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:02', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(485, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:06', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(486, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:23', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(487, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:24', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(488, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:37', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(489, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:40', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(490, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:43', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(491, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:57', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(492, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:38:58', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(493, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:05', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(494, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:06', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(495, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:08', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(496, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:09', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(497, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:17', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(498, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:19', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(499, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:19', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(500, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:26', 'http://192.168.1.8/yawk-LTE/welcome.html', 'override-bootstrap-style-settings-theme-generator'),
(501, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:27', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(502, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:34', 'http://192.168.1.8/yawk-LTE/index.html', 'mercedes-benz'),
(503, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:36', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(504, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:37', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'welcome'),
(505, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:39:37', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(506, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:52:13', 'http://192.168.1.8/yawk-LTE/welcome.html', 'override-bootstrap-style-settings-theme-generator'),
(507, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:52:13', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'welcome'),
(508, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:52:14', 'http://192.168.1.8/yawk-LTE/welcome.html', 'content/errors/404'),
(509, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:52:14', 'http://192.168.1.8/yawk-LTE/welcome.html', 'w126'),
(510, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:52:15', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(511, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 21:52:15', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(512, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 22:37:22', 'http://192.168.1.8/yawk-LTE/w126.html', 'index'),
(513, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 23:13:37', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(514, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 23:13:38', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(515, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 23:13:38', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(516, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 23:13:39', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(517, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 23:13:39', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(518, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-04 23:19:16', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(519, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:41:57', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'index'),
(520, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:41:59', 'http://192.168.1.8/yawk-LTE/index.html', 'newsfeed'),
(521, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:42:00', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(522, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:42:05', 'http://192.168.1.8/yawk-LTE/w126.html', 'index'),
(523, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:44:11', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(524, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:44:19', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'index'),
(525, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:44:32', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(526, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:48:40', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'index'),
(527, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:03', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(528, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:03', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(529, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:04', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(530, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:04', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(531, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:05', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(532, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:05', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(533, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:05', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'newsfeed'),
(534, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:06', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(535, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:06', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(536, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:07', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(537, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:07', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(538, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:08', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(539, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:08', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(540, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 01:49:09', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'index'),
(541, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:25', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'index'),
(542, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:26', 'http://192.168.1.8/yawk-LTE/index.html', 'index'),
(543, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:27', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(544, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:27', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(545, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:28', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(546, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:28', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(547, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:29', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(548, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:32', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(549, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:32', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(550, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:33', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(551, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:33', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(552, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:34', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(553, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:35', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(554, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(555, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:36', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(556, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:36', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'newsfeed'),
(557, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:37', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'w126'),
(558, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:37', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(559, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:38', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(560, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:38', 'http://192.168.1.8/yawk-LTE/w126.html', 'newsfeed'),
(561, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:39', 'http://192.168.1.8/yawk-LTE/newsfeed.html', 'mercedes-benz'),
(562, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:39', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'mercedes-benz'),
(563, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:40', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'mercedes-benz'),
(564, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:42', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'mercedes-benz'),
(565, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:43', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'mercedes-benz'),
(566, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:43', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'mercedes-benz'),
(567, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:44', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'mercedes-benz'),
(568, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:44', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(569, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:44', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(570, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:45', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(571, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:45', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(572, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:45', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(573, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:28:45', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(574, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:04', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(575, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:07', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(576, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:09', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(577, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:09', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(578, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:10', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(579, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:10', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(580, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:10', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(581, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:11', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(582, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:11', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(583, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:11', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(584, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:11', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(585, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:12', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(586, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:12', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(587, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:12', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz');
INSERT INTO `cms_stats` (`id`, `uid`, `gid`, `logged_in`, `acceptLanguage`, `remoteAddr`, `userAgent`, `device`, `deviceType`, `os`, `osVersion`, `browser`, `browserVersion`, `date_created`, `referer`, `page`) VALUES
(588, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:12', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(589, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:12', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(590, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:13', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(591, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:13', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(592, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:13', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(593, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:13', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(594, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:13', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(595, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:14', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(596, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:14', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(597, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:14', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(598, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:14', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(599, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:14', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(600, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:15', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(601, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:24', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(602, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:24', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(603, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:24', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(604, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:24', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(605, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:25', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(606, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:25', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(607, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:25', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(608, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:25', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(609, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:25', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(610, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:26', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(611, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:34', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(612, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:34', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(613, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(614, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(615, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(616, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(617, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(618, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:35', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(619, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:36', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(620, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:36', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(621, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:36', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(622, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:36', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(623, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:36', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(624, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:37', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(625, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:37', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(626, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:37', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(627, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:37', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(628, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:37', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(629, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:38', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(630, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:38', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(631, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:38', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(632, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:38', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(633, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:39', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(634, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:39', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(635, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:40', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(636, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:40', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(637, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:40', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(638, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:41', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(639, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:41', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(640, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:41', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(641, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:41', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(642, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:42', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(643, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:42', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(644, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:42', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(645, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:43', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(646, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:43', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(647, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:43', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(648, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:44', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(649, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:44', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(650, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:44', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(651, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:44', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(652, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:45', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(653, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:45', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(654, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:45', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(655, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:45', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(656, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:29:46', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(657, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:01', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(658, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:08', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(659, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:09', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(660, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:09', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(661, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:10', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(662, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:10', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(663, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:10', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(664, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:10', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(665, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:11', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(666, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:11', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(667, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:11', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(668, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:12', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(669, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:12', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(670, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:12', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(671, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:12', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(672, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:13', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(673, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:13', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(674, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:13', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(675, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:13', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(676, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:14', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(677, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:14', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(678, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:14', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(679, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:14', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(680, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:15', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(681, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:15', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(682, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:15', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(683, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:15', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(684, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:16', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(685, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:16', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(686, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:16', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(687, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:16', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(688, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:16', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(689, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:17', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(690, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:17', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(691, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:17', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(692, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:17', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(693, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:17', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(694, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:18', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(695, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:18', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(696, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:18', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(697, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:18', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(698, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:18', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(699, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:19', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(700, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:19', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(701, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:19', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(702, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:19', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(703, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:19', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(704, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:20', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(705, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:20', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(706, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:20', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(707, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:20', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(708, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:20', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(709, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:21', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(710, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:21', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(711, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:21', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(712, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:21', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(713, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:21', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(714, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:22', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(715, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:22', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(716, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:22', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(717, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:22', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(718, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:22', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(719, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:23', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(720, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:23', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(721, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:23', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(722, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:23', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(723, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:23', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(724, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:24', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(725, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:24', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(726, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:24', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(727, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:24', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(728, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:24', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(729, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:25', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(730, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:25', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(731, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:25', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(732, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:25', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126');
INSERT INTO `cms_stats` (`id`, `uid`, `gid`, `logged_in`, `acceptLanguage`, `remoteAddr`, `userAgent`, `device`, `deviceType`, `os`, `osVersion`, `browser`, `browserVersion`, `date_created`, `referer`, `page`) VALUES
(733, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:25', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(734, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:26', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(735, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:26', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(736, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:30:26', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(737, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:52:51', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(738, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:52:55', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(739, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:54:23', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&overrideTemplate=1&id=1', '/yawk-LTE/index.php'),
(740, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:54:58', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&overrideTemplate=1id=1', '/yawk-LTE/index.php'),
(741, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:55:03', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(742, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:55:04', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(743, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 11:55:05', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(744, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:55:09', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&overrideTemplate=1id=1', 'index'),
(745, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:55:10', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&overrideTemplate=1id=1', 'index'),
(746, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:55:40', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(747, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 11:55:42', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&overrideTemplate=1id=1', 'index'),
(748, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 12:14:59', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(749, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 12:19:56', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(750, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 12:23:24', 'http://192.168.1.8/yawk-LTE/w126.html', 'w126'),
(751, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', 'iPhone', 'Phone', 'iOS', '9_1', 'Apple Safari', '9.0', '2016-12-05 12:23:27', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(752, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 15:55:47', 'http://192.168.1.8/yawk-LTE/w126.html', 'mercedes-benz'),
(753, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 15:55:48', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&overrideTemplate=1id=1', 'index'),
(754, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 20:02:00', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'index'),
(755, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 20:04:04', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(756, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-05 21:08:41', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=template-edit&id=1', '/yawk-LTE/index.php'),
(757, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-06 00:43:20', 'http://192.168.1.8/yawk-LTE/admin/index.php?page=stats', 'index'),
(758, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-06 00:43:22', 'http://192.168.1.8/yawk-LTE/index.html', 'override-bootstrap-style-settings-theme-generator'),
(759, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-06 00:43:23', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'w126'),
(760, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-06 00:43:23', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator'),
(761, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-06 00:43:24', 'http://192.168.1.8/yawk-LTE/override-bootstrap-style-settings-theme-generator.html', 'mercedes-benz'),
(762, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-06 00:43:25', 'http://192.168.1.8/yawk-LTE/mercedes-benz.html', 'w126'),
(763, 1, 5, 1, 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4', '192.168.1.8', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36', '', 'Desktop', 'Windows', 'Windows 7', 'Google Chrome', '54.0.2840.99', '2016-12-06 00:43:25', 'http://192.168.1.8/yawk-LTE/w126.html', 'override-bootstrap-style-settings-theme-generator');

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
(1, '2016-11-29 20:37:29', 2, 'add ../content/pages/boerns.php', 1, 0, 0, 0),
(2, '2016-11-29 20:37:37', 2, 'save boerns', 1, 0, 0, 0),
(3, '2016-11-29 20:37:42', 2, 'toggled page 17 to online', 1, 0, 0, 0),
(4, '2016-11-29 20:37:42', 7, 'toggled menu 17 to online', 1, 0, 0, 0),
(5, '2016-11-29 21:03:55', 2, 'delete ../content/pages/boerns.php', 1, 0, 0, 0),
(6, '2016-12-04 21:09:56', 5, '404 ERROR includes/test.php', 1, 0, 0, 0),
(7, '2016-12-04 21:19:35', 5, '404 ERROR ../system/plugins/3/admin/3.php', 1, 0, 0, 0),
(8, '2016-12-04 23:13:34', 7, 'toggled menu <b>Userpage</b> to <b>offline</b>', 1, 0, 0, 0),
(9, '2016-12-05 11:54:57', 5, 'failed to set template details ()', 1, 0, 0, 0);

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
(1, 1, 'yawk-bootstrap3', 'menu:main:footer', '', '2016-09-29 00:00:00', 'Daniel Retzl ', 'https://github.com/YaWK/yawk-cms', 'http://yawk.io', '', '', '2016-10-01 02:30:00', '1.0.0', 'GNU General Public License (GPL)');

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
(3, 1, 'text-gfont', '20', '1', 'Text GoogleFont ID', 1, 0, 'form-control', 'Text Google Font'),
(4, 1, 'h1-fontcolor', 'FF9900', '000000', 'H1 Color', 1, 0, 'color', 'pick a color or leave blank'),
(6, 1, 'h2-fontcolor', '99FF00', '000000', 'H2 Color', 1, 0, 'color', 'pick a color or leave blank'),
(7, 1, 'h3-fontcolor', '85DE00', '000000', 'H3 Color', 1, 0, 'color', 'pick a color or leave blank'),
(8, 1, 'h4-fontcolor', '03A2FF', '000000', 'H4 Color', 1, 0, 'color', 'pick a color or leave blank'),
(9, 1, 'h5-fontcolor', 'FFFFFF', '000000', 'H5 Color', 1, 0, 'color', 'pick a color or leave blank'),
(10, 1, 'h6-fontcolor', 'FFFFFF', '000000', 'H6 Color', 1, 0, 'color', 'pick a color or leave blank'),
(11, 1, 'body-bg-color', '292A25', 'FFFFFF', 'Body Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(14, 1, 'well-bg-color', '525251', 'f5f5f5', 'Well Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(15, 1, 'smalltag-fontcolor', 'F5F5F5', '777777', 'Small Tag Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(16, 1, 'font-menucolor', 'EDEDED', '777777', 'Font Color', 1, 0, 'color', 'pick a color or leave blank'),
(17, 1, 'brand-menucolor', '000000', '777777', 'Brand Color', 1, 0, 'color', 'pick a color or leave blank'),
(18, 1, 'brandhover-menucolor', 'FFFFFF', '5e5e5e', 'Brand Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(19, 1, 'fonthover-menucolor', 'F7F7F7', '333333', 'Font Hover Color', 1, 0, 'color', 'pick a color or leave blank'),
(22, 1, 'fontactive-menucolor', '555555', '555555', 'Font Active Color', 1, 0, 'color', 'pick a color or leave blank'),
(23, 1, 'fontdisabled-menucolor', 'CCCCCC', 'cccccc', 'Font Disabled Color', 1, 0, 'color', 'pick a color or leave blank'),
(24, 1, 'default-menubgcolor', '242423', 'f8f8f8', 'Default Background Color', 1, 0, 'color', 'pick a color or leave blank'),
(25, 1, 'border-menubgcolor', '3D3D3C', 'e7e7e7', 'Border Color', 1, 0, 'color', 'pick a color or leave blank'),
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
(45, 1, 'text-fontcolor', 'FFFFFF', '333333', 'Text Color', 1, 0, 'color', 'pick a color or leave blank'),
(46, 1, 'fontshadow-menucolor', 'CCCCCC', '#CCCCCC', 'Menu Text Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(47, 1, 'form-valid', '009900', '009900', 'Form Valid Color', 1, 0, 'color', 'pick a color or leave blank'),
(48, 1, 'form-error', 'FF0000', 'FF0000', 'Form Error Color', 1, 0, 'color', 'pick a color or leave blank'),
(49, 1, 'body-text-shadow', '1px 0px', '1px 0px', 'Body Text Shadow Thickness', 1, 0, 'form-control', 'shadow size in pixels'),
(50, 1, 'body-text-shadow-color', '000000', 'CCCCCC', 'Body Text Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(51, 1, 'body-text-size', '1.7em', '1.7em', 'Body Font Size', 1, 0, 'form-control', 'size in 1.7em or 16px (for example)'),
(52, 1, 'body-margin-top', '40px', '40px', 'Body Top Margin', 1, 0, 'form-control', 'value in px e.g. 40px'),
(53, 1, 'body-bg-image', '', 'any .jpg or .png you want', 'Body Background Image', 1, 0, 'form-control', 'media/images/background.jpg'),
(54, 1, 'body-bg-repeat', 'no-repeat', 'no-repeat', 'Body Background Repeat', 1, 0, 'form-control', 'repeat, repeat-x, repeat-y, no-repeat, inherit'),
(55, 1, 'body-bg-position', 'center', 'center', 'Body Background Position', 1, 0, 'form-control', 'left-center, right-center, top-center, [top, bottom]'),
(56, 1, 'body-bg-attachment', 'fixed', 'fixed', 'Body Background Attach', 1, 0, 'form-control', 'scroll, fixed, local, initial, inherit'),
(57, 1, 'body-bg-size', 'cover', 'cover', 'Body Background Size', 1, 0, 'form-control', 'auto, cover, length, percentage, initial, inherit'),
(58, 1, 'main-box-shadow', '6px 12px 16px 0px', '6px 12px 6px', 'Main Box Shadow', 1, 0, 'form-control', 'eg. 3px 6px 3px'),
(59, 1, 'main-box-shadow-color', '141414', 'E8E8E8', 'Main Box Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
(60, 1, 'well-min-height', '20px', '20px', 'Well Minimum Height', 1, 0, 'form-control', 'value in px eg. 20px'),
(61, 1, 'well-padding', '20px', '19px', 'Well padding', 1, 0, 'form-control', 'value in px eg. 20px'),
(62, 1, 'well-margin-top', '0px', '0px', 'Well Margin Top', 1, 0, 'form-control', 'value in px eg. 10px'),
(63, 1, 'well-margin-bottom', '0px', '0px', 'Well Margin Bottom', 1, 0, 'form-control', 'value in px eg. 10px'),
(64, 1, 'well-border', '0px solid', '1px solid', 'Well Border Style', 1, 0, 'form-control', 'value in px eg. 1px solid'),
(65, 1, 'well-border-color', 'E0E0E0', 'e3e3e3', 'Well Border Color', 1, 0, 'color', 'pick a color or leave blank'),
(66, 1, 'well-border-radius', '0px', '0px', 'Well Border Radius', 1, 0, 'form-control', 'for rounded edges, value in px eg. 4px'),
(67, 1, 'well-shadow', '2px 2px 5px 6px', '3px 3px 5px 6px', 'Well Shadow', 1, 0, 'form-control', 'value in px eg. x,y,blur,spread'),
(68, 1, 'well-shadow-color', 'F0F0F0', 'CCCCCC', 'Well Shadow Color', 1, 0, 'color', 'pick a color or leave blank'),
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
(137, 1, 'img-brightness', '110%', '110%', 'Brightness On Hover', 1, 0, 'form-control', 'value in percent eg. 110%');

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
(1, 0, 0, 1, 5, 1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', '2016-10-10 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2016-12-05 16:33:12', 73, 'danielretzl@gmail.com', 'http://yawk.io', '', '', 'Daniel', 'Retzl', '', '', '', '', '', 1, 0, 0, 'Main Developer', 0, 0, 1),
(2, 0, 0, 1, 4, 1, 'claudia', '827ccb0eea8a706c4c34a16891f84e7b', '2016-09-13 13:54:26', '2016-10-10 04:02:11', '0000-00-00 00:00:00', '2016-11-24 13:46:46', 30, 'test@test.com', '', '', '', '', '', '', '', '', '', '', 1, 0, 0, '', 0, 0, 1);

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
(2, 1, 9, 3, 2, 'main'),
(3, 0, 6, 6, 3, 'main');

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
(24, 3, 'clockcolor', '999999', 8, 1),
(25, 3, 'clockcolor', '999999', 8, 1),
(26, 3, 'width', '450', 4, 1),
(27, 3, 'width', '450', 5, 1),
(28, 3, 'clockcolor', '999', 8, 1),
(29, 3, 'clockcolor', '999', 8, 1),
(30, 3, 'clockcolor', '999', 8, 1),
(31, 3, 'clockcolor', '999', 8, 1),
(32, 3, 'trackingcode', 'UA-0000000-00', 6, 1);

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
(15, 'Newsletter', 'newsletter'),
(16, 'Gallery', 'Gallery');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=571;
--
-- AUTO_INCREMENT für Tabelle `cms_menu`
--
ALTER TABLE `cms_menu`
  MODIFY `TMPID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT für Tabelle `cms_meta_local`
--
ALTER TABLE `cms_meta_local`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT für Tabelle `cms_notifications`
--
ALTER TABLE `cms_notifications`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT für Tabelle `cms_plugin_gallery_items`
--
ALTER TABLE `cms_plugin_gallery_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
--
-- AUTO_INCREMENT für Tabelle `cms_plugin_msg`
--
ALTER TABLE `cms_plugin_msg`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `cms_stats`
--
ALTER TABLE `cms_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=764;
--
-- AUTO_INCREMENT für Tabelle `cms_syslog`
--
ALTER TABLE `cms_syslog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;
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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT für Tabelle `cms_widget_settings`
--
ALTER TABLE `cms_widget_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
