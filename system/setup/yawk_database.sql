-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Apr 2017 um 21:37
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
(1, 1, 1, 1, 1, 0, 1, '2017-03-08 19:02:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'Welcome to YaWK CMS!', 'index.html', '_self', 0, 0);

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
(1, 'MainMenu', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_meta_global`
--

CREATE TABLE `cms_meta_global` (
  `name` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_meta_global`
--

INSERT INTO `cms_meta_global` (`name`, `content`) VALUES
('author', 'YaWK'),
('description', 'This Text appears on search engines. It is the typical description of your page underneath the link or title of every search result.'),
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
(1, 1, 1, '2017-03-08 00:00:00', '2017-03-26 19:53:19', '2017-03-08 00:00:00', '0000-00-00 00:00:00', 'index', 'Welcome to YaWK CMS!', '', -1, 0, 0, 0, '0');

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
  `fieldClass` varchar(128) NOT NULL DEFAULT 'form-control',
  `fieldType` varchar(64) NOT NULL,
  `placeholder` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `options` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_settings`
--

INSERT INTO `cms_settings` (`property`, `value`, `longValue`, `type`, `sortation`, `activated`, `label`, `icon`, `heading`, `subtext`, `fieldClass`, `fieldType`, `placeholder`, `description`, `options`) VALUES
('admin_email', '', '', 1, 5, 1, 'ADMIN_EMAIL_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFooter', '0', '', 11, 5, 1, 'BACKENDFOOTER_LABEL', 'fa fa-chevron-down', 'BACKENDFOOTER_HEADING', 'BACKENDFOOTER_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendFooterCopyright', '0', '', 11, 6, 1, 'BACKENDFOOTERCOPYRIGHT_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendFooterValueLeft', 'http://yawk.io', '', 11, 7, 1, 'BACKENDFOOTERVALUE_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFooterValueRight', '<b>YaWK :: <small> Yet another Web Kit</b></small>', '', 11, 8, 1, 'BACKENDFOOTERVALUERIGHT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFX', '0', '', 2, 5, 1, 'BACKENDFX_LABEL', 'fa fa-paper-plane-o', 'BACKENDFX_HEADING', 'BACKENDFX_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendFXtime', '820', '', 2, 7, 1, 'BACKENDFXTIME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendFXtype', 'fadeIn In', '', 2, 6, 1, 'BACKENDFXTYPE_LABEL', '', '', '', 'form-control', 'select', '', '', 'fadeIn,Fade In:slideDown,Slide Down'),
('backendLanguage', 'de-DE', '', 2, 4, 1, 'BACKENDLANGUAGE_LABEL', 'fa fa-language', 'BACKENDLANGUAGE_HEADING', 'BACKENDLANGUAGE_SUBTEXT', 'form-control', 'select', '', '', 'en-EN,English (en-EN):de-DE,German (de-DE)'),
('backendLayout', 'sidebar-mini', '', 2, 2, 1, 'BACKENDLAYOUT_LABEL', '', '', '', 'form-control', 'select', '', 'BACKENDLAYOUT_DESC', 'fixed,Fixed:sidebar-collapse,Sidebar Collapse:sidebar-mini,Sidebar Mini:layout-boxed,Layout Boxed:layout-top-nav,Layout Top Nav'),
('backendLogoSubText', '', '', 12, 2, 1, 'BACKENDLOGOSUBTEXT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('backendLogoText', 'http://yawk.io', '', 12, 1, 1, 'BACKENDLOGOTEXT_LABEL', 'fa fa-bars', 'BACKENDLOGOTEXT_HEADING', 'BACKENDLOGOTEXT_SUBTEXT', 'form-control', 'input', '', '', ''),
('backendLogoUrl', '1', '', 12, 3, 1, 'BACKENDLOGOURL_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendMessagesMenu', '1', '', 12, 4, 1, 'BACKENDMSGMENU_LABEL', 'fa fa-bell-o', 'BACKENDMSGMENU_HEADING', 'BACKENDMSGMENU_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('backendNotificationMenu', '1', '', 12, 5, 1, 'BACKENDNOTIFYMENU_LABEL', '', '', '', 'form-control', 'checkbox', '', '', ''),
('backendSkin', 'skin-wp-style', '', 2, 1, 1, 'BACKENDSKIN_LABEL', 'fa fa-paint-brush', 'BACKENDSKIN_HEADING', 'BACKENDSKIN_SUBTEXT', 'form-control', 'select', '', '', 'skin-blue,Blue:skin-green,Green:skin-red,Red:skin-yellow,Yellow:skin-purple,Purple:skin-black,Black:skin-yellow-light,Yellow Light:skin-wp-style,Wordpress Style'),
('dbhost', 'localhost', '', 9, 2, 1, 'DBHOST_LABEL', 'fa fa-database', 'DATABASE_HEADING', 'DATABASE_SUBTEXT', 'form-control', 'input', 'http://localhost/', '', ''),
('dbname', 'yawk_database', '', 9, 1, 1, 'DBNAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('dbport', '3306', '', 9, 6, 1, 'DBPORT_LABEL', '', '', '', 'form-control', 'input', 'default:3306', '', ''),
('dbprefix', 'cms_', '', 9, 5, 1, 'DBPREFIX_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('dbpwd', 'test', '', 9, 4, 1, 'DBPWD_LABEL', '', '', '', 'form-control', 'password', '', '', ''),
('dbusername', 'admin', '', 9, 3, 1, 'DBUSERNAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('defaultemailtext', '', 'Hello $user,\\n\\n\\Thank you for registering on site\\n\\n$url', 5, 0, 1, 'Default SignUp Email Message', '', '', '', 'form-control', 'textarea', '', '', ''),
('dirprefix', '/', '', 9, 0, 1, 'DIRPREFIX_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('domain', '', '', 1, 4, 1, 'DOMAIN_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
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
('globalmetatext', 'YaWK LTE', '', 10, 0, 1, 'Global Meta Description', '', '', '', 'form-control', '', '', '', ''),
('host', 'http://192.168.1.8/yawk-LTE', '', 1, 3, 1, 'HOST_LABEL', '', '', '', 'form-control', 'input', '', 'DATABASE_DESC', ''),
('loadingTime', '0', '', 11, 10, 1, 'LOADINGTIME_LABEL', 'fa fa-signal', 'LOADINGTIME_HEADING', 'LOADINGTIME_SUBTEXT', 'form-control', 'checkbox', '', '', ''),
('logoutmenuid', '1', '', 6, 0, 1, 'Logout Menu ID for logged-in Users', '', '', '', 'form-control', '', '', '', ''),
('offline', '0', '', 8, 0, 1, 'OFFLINE_LABEL', 'fa fa-wrench', 'OFFLINE_HEADING', 'OFFLINE_SUBTEXT', 'form-control', 'checkbox', '', 'OFFLINE_DESC', ''),
('offlineimage', 'media/images/closed-sign-tm.jpg', '', 8, 0, 1, 'OFFLINEIMAGE_LABEL', '', '', '', 'form-control', 'input', 'media/images/logo.jpg', 'OFFLINEIMAGE_DESC', ''),
('offlinemsg', '<h1>Maintenance Downtime</h1><h3>We are sorry, right now we are going to do some housekeeping at our website. Please come back later.</h3>', '', 8, 0, 1, 'OFFLINEMSG_LABEL', '', '', '', 'form-control', 'textarea', '', '', ''),
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
('signup_legend0-long', '', '<h2>Membership  <small>- become a VIP!</small></h2><p>\nIf you signup today, you can\n<ul>\n<li class="fa fa-check"> login to Website</li><br>\n<li class="fa fa-check"> get your own profile page</li><br>\n<li class="fa fa-check"> additional exclusive Member''s Stuff</li><br>\n<li class="fa fa-check"> super-douper-whatever you want to sell or show</li><br>\n</ul>\n\nBeein VIP is free. As long as you want it. Expect nothing, get all!</p>\n<b>But beware! You need an email invitation to register here - its exclusive! (: </b>', 5, 0, 1, 'signUp legend text', '', '', '', 'form-control', '', '', '', ''),
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
('sitename', 'YaWK Yet another WebKit CMS', '', 1, 2, 1, 'SITENAME_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('statsEnable', '0', '', 13, 2, 1, 'STATS_LABEL', 'fa fa-bar-chart', 'STATS_HEADING', 'STATS_SUBTEXT', 'form-control', 'select', '', 'STATS_DESC', '0,off:1,on'),
('syslogEnable', '0', '', 13, 1, 1, 'SYSLOG_LABEL', 'fa fa-terminal', 'SYSLOG_HEADING', 'SYSLOG_SUBTEXT', 'form-control', 'select', '', 'SYSLOG_DESC', '0,off:1,on'),
('timediff', '1', '', 7, 1, 1, 'TIMEDIFF_LABEL', 'fa fa-clock-o', 'TIMEDIFF_HEADING', 'TIMEDIFF_SUBTEXT', 'form-control', 'checkbox', '', 'TIMEDIFF_DESC', ''),
('timedifftext', 'This page is not online yet. Please come back in ', '', 7, 2, 1, 'TIMEDIFFTEXT_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('title', 'YaWK Test Page', '', 1, 1, 1, 'TITLE_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
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
('yawkversion', '1.0 r2017.4', '', 9, 2, 1, 'YAWKVERSION_LABEL', '', '', '', 'form-control', 'input', '', '', ''),
('youtubeChannelUrl', 'http://www.youtube.com', '', 4, 0, 1, 'YouTube Channel URL', '', '', '', 'form-control', '', '', '', ''),
('youtubestatus', '0', '', 4, 0, 1, 'YouTube on/off', '', '', '', 'form-control', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_settings_types`
--

CREATE TABLE `cms_settings_types` (
  `id` int(11) NOT NULL,
  `value` varchar(64) NOT NULL
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
  `positions` text NOT NULL,
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
(1, 1, 'yawk-bootstrap3', 'outerTop:outerLeft:outerRight:intro:globalmenu:top:leftMenu:mainTop:mainTopLeft:mainTopCenter:mainTopRight:main:mainBottom:mainBottomLeft:mainBottomCenter:mainBottomRight:mainFooter:mainFooterLeft:mainFooterCenter:mainFooterRight:rightMenu:bottom:footer:hiddentoolbar:debug:outerBottom', 'YaWK Bootstrap 3 Default Theme.', '2016-09-29 00:00:00', 'Daniel Retzl ', 'https://github.com/YaWK', 'http://www.yawk.io', 'Daniel Retzl', '', '2016-10-01 02:30:00', '1.0.0', 'GNU General Public License (GPL)');

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
  `type` int(11) NOT NULL,
  `activated` int(1) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `label` varchar(256) NOT NULL,
  `fieldClass` varchar(128) NOT NULL,
  `fieldType` varchar(64) NOT NULL,
  `options` varchar(255) DEFAULT NULL,
  `placeholder` varchar(256) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `subtext` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_template_settings`
--

INSERT INTO `cms_template_settings` (`id`, `templateID`, `property`, `value`, `valueDefault`, `longValue`, `type`, `activated`, `sort`, `label`, `fieldClass`, `fieldType`, `options`, `placeholder`, `description`, `icon`, `heading`, `subtext`) VALUES
(1, 1, 'heading-gfont', '76', '1', '', 0, 1, 0, 'Global GoogleFont ID', 'form-control', '', '', 'Default Google Font', '', '', '', ''),
(2, 1, 'menu-gfont', '76', '1', '', 0, 1, 0, 'Menu GoogleFont ID', 'form-control', '', '', 'Menu Google Font', '', '', '', ''),
(3, 1, 'text-gfont', '76', '1', '', 0, 1, 0, 'Text GoogleFont ID', 'form-control', '', '', 'Text Google Font', '', '', '', ''),
(4, 1, 'h1-fontcolor', '000000', '000000', '', 5, 1, 1, 'TPL_H1_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(6, 1, 'h2-fontcolor', '000000', '000000', '', 5, 1, 2, 'TPL_H2_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(7, 1, 'h3-fontcolor', '000000', '000000', '', 5, 1, 3, 'TPL_H3_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(8, 1, 'h4-fontcolor', '000000', '000000', '', 5, 1, 4, 'TPL_H4_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(9, 1, 'h5-fontcolor', '000000', '000000', '', 5, 1, 5, 'TPL_H5_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(10, 1, 'h6-fontcolor', '000000', '000000', '', 5, 1, 6, 'TPL_H6_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(11, 1, 'body-bg-color', 'FFFFFF', 'FFFFFF', '', 6, 1, 0, 'TPL_BODY_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(14, 1, 'well-bg-color', 'F5F5F5', 'F5F5F5', '', 14, 1, 1, 'TPL_WELL_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(15, 1, 'smalltag-fontcolor', '777777', '777777', '', 5, 1, 7, 'TPL_SMALLTAG_FONT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(16, 1, 'font-menucolor', '777777', '777777', '', 10, 1, 1, 'TPL_MENU_FONT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(17, 1, 'brand-menucolor', '777777', '777777', '', 10, 1, 2, 'TPL_MENU_BRAND_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(18, 1, 'brandhover-menucolor', '5E5E5E', '5e5e5e', '', 10, 1, 3, 'TPL_MENU_BRAND_HOVER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(19, 1, 'fonthover-menucolor', '333333', '333333', '', 10, 1, 4, 'TPL_MENU_FONT_HOVER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(22, 1, 'fontactive-menucolor', '555555', '555555', '', 10, 1, 5, 'TPL_MENU_FONT_ACTIVE_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(23, 1, 'fontdisabled-menucolor', 'CCCCCC', 'CCCCCC', '', 10, 1, 6, 'TPL_MENU_FONT_DISABLED_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(24, 1, 'default-menubgcolor', 'F8F8F8', 'f8f8f8', '', 11, 1, 1, 'TPL_MENU_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(25, 1, 'border-menubgcolor', 'E7E7E7', 'e7e7e7', '', 11, 1, 2, 'TPL_MENU_BGCOLOR_BORDER', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(26, 1, 'active-menubgcolor', 'E7E7E7', 'e7e7e7', '', 11, 1, 3, 'TPL_MENU_BGCOLOR_ACTIVE', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(27, 1, 'toggle-menubgcolor', 'DDDDDD', 'dddddd', '', 11, 1, 4, 'TPL_MENU_BGCOLOR_TOGGLE', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(28, 1, 'iconbar-menubgcolor', '888888', '888888', '', 11, 1, 5, 'TPL_MENU_BGCOLOR_ICONBAR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(29, 1, 'background-menudropdowncolor', 'FFFFFF', 'FFFFFF', '', 12, 1, 1, 'TPL_MENU_DROPDOWN_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(30, 1, 'border-menudropdowncolor', 'CCCCCC', 'CCCCCC', '', 12, 1, 4, 'TPL_MENU_DROPDOWN_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(31, 1, 'font-menudropdowncolor', '333333', '333333', '', 12, 1, 5, 'TPL_MENU_DROPDOWN_FONT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(32, 1, 'fonthover-menudropdowncolor', '262626', '262626', '', 12, 1, 6, 'TPL_MENU_DROPDOWN_FONT_HOVER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(33, 1, 'hoverbg-menudropdowncolor', 'F5F5F5', 'F5F5F5', '', 12, 1, 2, 'TPL_MENU_DROPDOWN_BGCOLOR_HOVER', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(34, 1, 'fontactive-menudropdowncolor', 'FFFFFF', 'FFFFFF', '', 12, 1, 7, 'TPL_MENU_DROPDOWN_FONT_ACTIVE_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(35, 1, 'activebg-menudropdowncolor', 'FFFFFF', '337AB7', '', 12, 1, 3, 'TPL_MENU_DROPDOWN_BGCOLOR_ACTIVE', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(36, 1, 'disabled-menudropdowncolor', '777777', '777777', '', 12, 1, 8, 'TPL_MENU_DROPDOWN_FONT_DISABLED_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(37, 1, 'a-link', '337AB7', '337ab7', '', 3, 1, 1, 'TPL_LINK_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(38, 1, 'visited-link', '337AB7', '337ab7', '', 3, 1, 2, 'TPL_LINK_VISITED_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(39, 1, 'hover-link', '23527C', '23527c', '', 3, 1, 3, 'TPL_LINK_HOVER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(40, 1, 'decoration-link', 'none', 'none', '', 3, 1, 4, 'TPL_LINK_DECORATION', 'form-control', 'select', 'none,none:underline,underline:overline,overline:line-trough,line-trough:blink,blink:inherit,inherit', 'TPL_LINK_COLOR_DECORATION_PLACEHOLDER', '', '', '', ''),
(41, 1, 'hoverdecoration-link', 'underline', 'underline', '', 3, 1, 5, 'TPL_LINK_HOVER_DECORATION', 'form-control', 'select', 'none,none:underline,underline:overline,overline:line-trough,line-trough:blink,blink:inherit,inherit', 'TPL_HOVER_DECORATION_PLACEHOLDER', '', '', '', ''),
(42, 1, 'buttontext-link', 'FFFFFF', 'ffffff', '', 3, 1, 6, 'TPL_BTN_TEXT_LINK_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(43, 1, 'background-listgroup', 'FFFFFF', 'ffffff', '', 15, 1, 0, 'TPL_LISTGROUP_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(44, 1, 'fontcolor-listgroup', 'FFFFFF', '000000', '', 15, 1, 0, 'TPL_LISTGROUP_FONTCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(45, 1, 'text-fontcolor', '333333', '333333', '', 5, 1, 8, 'TPL_TEXT_FONT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(46, 1, 'fontshadow-menucolor', 'CCCCCC', 'CCCCCC', '', 10, 1, 7, 'TPL_MENU_FONT_SHADOW_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(47, 1, 'form-valid', '009900', '009900', '', 0, 1, 0, 'Form Valid Color', 'color', '', '', 'pick a color or leave blank', '', '', '', ''),
(48, 1, 'form-error', 'FF0000', 'FF0000', '', 0, 1, 0, 'Form Error Color', 'color', '', '', 'pick a color or leave blank', '', '', '', ''),
(49, 1, 'body-text-shadow', '1px 0px', '1px 0px', '', 2, 1, 0, 'TPL_BODY_TEXT_SHADOW', 'form-control', '', '', 'TPL_BODY_TEXT_SHADOW_PLACEHOLDER', '', '', '', ''),
(50, 1, 'body-text-shadow-color', 'C7C7C7', 'CCCCCC', '', 2, 1, 0, 'TPL_BODY_TEXT_SHADOW_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(51, 1, 'body-text-size', '1.8em', '1.7em', '', 2, 1, 0, 'TPL_BODY_TEXT_SIZE', 'form-control', '', '', 'TPL_BODY_TEXT_SIZE_PLACEHOLDER', '', '', '', ''),
(52, 1, 'body-margin-top', '0px', '40px', '', 7, 1, 1, 'TPL_BODY_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(53, 1, 'body-bg-image', '', 'any .jpg or .png you want', '', 8, 1, 1, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(54, 1, 'body-bg-repeat', 'no-repeat', 'no-repeat', '', 8, 1, 2, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(55, 1, 'body-bg-position', 'center', 'center', '', 8, 1, 3, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(56, 1, 'body-bg-attachment', 'fixed', 'fixed', '', 8, 1, 4, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(57, 1, 'body-bg-size', 'cover', 'cover', '', 8, 1, 5, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(58, 1, 'main-box-shadow', '6px 12px 16px 0px', '6px 12px 6px', '', 9, 1, 1, 'TPL_MAIN_SHADOW', 'form-control', '', '', 'TPL_MAIN_SHADOW_PLACEHOLDER', '', '', '', ''),
(59, 1, 'main-box-shadow-color', 'E8E8E8', 'E8E8E8', '', 9, 1, 2, 'TPL_MAIN_SHADOW_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(60, 1, 'well-min-height', '20px', '20px', '', 14, 1, 2, 'TPL_WELL_MIN_HEIGHT', 'form-control', '', '', 'value in px eg. 20px', '', '', '', ''),
(61, 1, 'well-padding', '1.5em', '19px', '', 14, 1, 3, 'TPL_WELL_PADDING', 'form-control', '', '', 'value in px eg. 20px', '', '', '', ''),
(62, 1, 'well-margin-top', '0px', '0px', '', 14, 1, 4, 'TPL_WELL_MARGIN_TOP', 'form-control', '', '', 'value in px eg. 10px', '', '', '', ''),
(63, 1, 'well-margin-bottom', '240px', '0px', '', 14, 1, 5, 'TPL_WELL_MARGIN_BOTTOM', 'form-control', '', '', 'value in px eg. 10px', '', '', '', ''),
(64, 1, 'well-border', '0px solid', '1px solid', '', 14, 1, 6, 'TPL_WELL_BORDER_STYLE', 'form-control', '', '', 'value in px eg. 1px solid', '', '', '', ''),
(65, 1, 'well-border-color', 'E3E3E3', 'e3e3e3', '', 14, 1, 7, 'TPL_WELL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(66, 1, 'well-border-radius', '12px', '0px', '', 14, 1, 8, 'TPL_WELL_BORDER_RADIUS', 'form-control', '', '', 'rounded edges, value in px eg. 4px', '', '', '', ''),
(67, 1, 'well-shadow', '8px 8px 20px -6px', '3px 3px 5px 6px', '', 14, 1, 9, 'TPL_WELL_SHADOW', 'form-control', '', '', 'value in px eg. x,y,blur,spread', '', '', '', ''),
(68, 1, 'well-shadow-color', 'CCCCCC', 'CCCCCC', '', 14, 1, 10, 'TPL_WELL_SHADOW_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(69, 1, 'h1-size', '48px', '36px', '', 4, 1, 1, 'TPL_H1_SIZE', 'form-control', '', '', 'TPL_H1_SIZE_PLACEHOLDER', '', '', '', ''),
(70, 1, 'h2-size', '36px', '30px', '', 4, 1, 2, 'TPL_H2_SIZE', 'form-control', '', '', 'TPL_H2_SIZE_PLACEHOLDER', '', '', '', ''),
(71, 1, 'h3-size', '32px', '24px', '', 4, 1, 3, 'TPL_H3_SIZE', 'form-control', '', '', 'TPL_H3_SIZE_PLACEHOLDER', '', '', '', ''),
(72, 1, 'h4-size', '24px', '18px', '', 4, 1, 4, 'TPL_H4_SIZE', 'form-control', '', '', 'TPL_H4_SIZE_PLACEHOLDER', '', '', '', ''),
(73, 1, 'h5-size', '18px', '14px', '', 4, 1, 5, 'TPL_H5_SIZE', 'form-control', '', '', 'TPL_H5_SIZE_PLACEHOLDER', '', '', '', ''),
(74, 1, 'h6-size', '14px', '12px', '', 4, 1, 6, 'TPL_H6_SIZE', 'form-control', '', '', 'TPL_H6_SIZE_PLACEHOLDER', '', '', '', ''),
(75, 1, 'btn-fontsize', '14px', '14px', '', 17, 1, 0, 'TPL_BTN_FONTSIZE', 'form-control', '', '', 'TPL_BTN_FONTSIZE_PLACEHOLDER', '', '', '', ''),
(76, 1, 'btn-font-weight', 'normal', 'normal', '', 17, 1, 0, 'TPL_BTN_FONTWEIGHT', 'form-control', 'select', 'normal,normal:bold,bold', '', '', '', '', ''),
(77, 1, 'btn-border', '1px', '1px', '', 17, 1, 0, 'TPL_BTN_BORDER', 'form-control', '', '', 'TPL_BTN_PLACEHOLDER', '', '', '', ''),
(78, 1, 'btn-border-style', 'solid', 'solid', '', 17, 1, 0, 'TPL_BTN_BORDER_STYLE', 'form-control', 'select', 'solid,solid:dotted,dotted:dashed,dashed', 'solid, dotted, dashed', '', '', '', ''),
(79, 1, 'btn-border-radius', '4px', '4px', '', 17, 1, 0, 'TPL_BTN_BORDER_RADIUS', 'form-control', '', '', 'TPL_BTN_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(80, 1, 'btn-default-color', '333333', '333333', '', 18, 1, 1, 'TPL_BTN_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(81, 1, 'btn-default-background-color', 'FFFFFF', 'FFFFFF', '', 18, 1, 2, 'TPL_BTN_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(82, 1, 'btn-default-border-color', 'CCCCCC', 'CCCCCC', '', 18, 1, 3, 'TPL_BTN_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(83, 1, 'btn-default-focus-background-color', 'E6E6E6', 'E6E6E6', '', 18, 1, 4, 'TPL_BTN_FOCUS_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(84, 1, 'btn-default-focus-border-color', '8C8C8C', '8C8C8C', '', 18, 1, 5, 'TPL_BTN_FOCUS_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(85, 1, 'btn-default-hover-color', '333333', '333333', '', 18, 1, 6, 'TPL_BTN_HOVER_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(86, 1, 'btn-default-hover-background-color', 'E6E6E6', 'E6E6E6', '', 18, 1, 7, 'TPL_BTN_HOVER_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(87, 1, 'btn-default-hover-border-color', 'ADADAD', 'ADADAD', '', 18, 1, 8, 'TPL_BTN_HOVER_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(88, 1, 'btn-primary-color', 'FFFFFF', 'FFFFFF', '', 19, 1, 1, 'TPL_BTN_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(89, 1, 'btn-primary-background-color', '337AB7', '337ab7', '', 19, 1, 2, 'TPL_BTN_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(90, 1, 'btn-primary-border-color', '2E6DA4', '2e6da4', '', 19, 1, 3, 'TPL_BTN_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(91, 1, 'btn-primary-focus-background-color', '286090', '286090', '', 19, 1, 4, 'TPL_BTN_FOCUS_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(92, 1, 'btn-primary-focus-border-color', '122B40', '122b40', '', 19, 1, 5, 'TPL_BTN_FOCUS_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(93, 1, 'btn-primary-hover-color', 'FFFFFF', 'FFFFFF', '', 19, 1, 6, 'TPL_BTN_HOVER_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(94, 1, 'btn-primary-hover-background-color', '286090', '286090', '', 19, 1, 7, 'TPL_BTN_HOVER_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(95, 1, 'btn-primary-hover-border-color', '204D74', '204d74', '', 19, 1, 8, 'TPL_BTN_HOVER_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(96, 1, 'btn-success-color', 'FFFFFF', 'FFFFFF', '', 20, 1, 0, 'TPL_BTN_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(97, 1, 'btn-success-background-color', '5CB85C', '5cb85c', '', 20, 1, 0, 'TPL_BTN_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(98, 1, 'btn-success-border-color', '4CAE4C', '4cae4c', '', 20, 1, 0, 'TPL_BTN_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(99, 1, 'btn-success-focus-background-color', '449D44', '449d44', '', 20, 1, 0, 'TPL_BTN_FOCUS_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(100, 1, 'btn-success-focus-border-color', '255625', '255625', '', 20, 1, 0, 'TPL_BTN_FOCUS_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(101, 1, 'btn-success-hover-color', 'FFFFFF', 'FFFFFF', '', 20, 1, 0, 'TPL_BTN_HOVER_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(102, 1, 'btn-success-hover-background-color', '449D44', '449d44', '', 20, 1, 0, 'TPL_BTN_HOVER_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(103, 1, 'btn-success-hover-border-color', '398439', '398439', '', 20, 1, 0, 'TPL_BTN_HOVER_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(104, 1, 'btn-info-color', 'FFFFFF', 'FFFFFF', '', 23, 1, 1, 'TPL_BTN_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(105, 1, 'btn-info-background-color', '5BC0DE', '5bc0de', '', 23, 1, 2, 'TPL_BTN_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(106, 1, 'btn-info-border-color', '46B8DA', '46b8da', '', 23, 1, 3, 'TPL_BTN_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(107, 1, 'btn-info-focus-background-color', '31B0D5', '31b0d5', '', 23, 1, 4, 'TPL_BTN_FOCUS_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(108, 1, 'btn-info-focus-border-color', '1B6D85', '1b6d85', '', 23, 1, 5, 'TPL_BTN_FOCUS_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(109, 1, 'btn-info-hover-color', 'FFFFFF', 'FFFFFF', '', 23, 1, 6, 'TPL_BTN_HOVER_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(110, 1, 'btn-info-hover-background-color', '31B0D5', '31b0d5', '', 23, 1, 7, 'TPL_BTN_HOVER_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(111, 1, 'btn-info-hover-border-color', '269ABC', '269abc', '', 23, 1, 8, 'TPL_BTN_HOVER_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(112, 1, 'btn-warning-color', 'FFFFFF', 'FFFFFF', '', 21, 1, 1, 'TPL_BTN_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(113, 1, 'btn-warning-background-color', 'F0AD4E', 'f0ad4e', '', 21, 1, 2, 'TPL_BTN_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(114, 1, 'btn-warning-border-color', 'EEA236', 'eea236', '', 21, 1, 3, 'TPL_BTN_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(115, 1, 'btn-warning-focus-background-color', 'EC971F', 'ec971f', '', 21, 1, 4, 'TPL_BTN_FOCUS_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(116, 1, 'btn-warning-focus-border-color', '985F0D', '985f0d', '', 21, 1, 5, 'TPL_BTN_FOCUS_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(117, 1, 'btn-warning-hover-color', 'FFFFFF', 'FFFFFF', '', 21, 1, 6, 'TPL_BTN_HOVER_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(118, 1, 'btn-warning-hover-background-color', 'EC971F', 'ec971f', '', 21, 1, 7, 'TPL_BTN_HOVER_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(119, 1, 'btn-warning-hover-border-color', 'D58512', 'd58512', '', 21, 1, 8, 'TPL_BTN_HOVER_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(120, 1, 'btn-danger-color', 'FFFFFF', 'FFFFFF', '', 22, 1, 1, 'TPL_BTN_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(121, 1, 'btn-danger-background-color', 'D9534F', 'd9534f', '', 22, 1, 2, 'TPL_BTN_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(122, 1, 'btn-danger-border-color', 'D43F3A', 'd43f3a', '', 22, 1, 3, 'TPL_BTN_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(123, 1, 'btn-danger-focus-background-color', 'C9302C', 'c9302c', '', 22, 1, 4, 'TPL_BTN_FOCUS_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(124, 1, 'btn-danger-focus-border-color', '761C19', '761c19', '', 22, 1, 5, 'TPL_BTN_FOCUS_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(125, 1, 'btn-danger-hover-color', 'FFFFFF', 'FFFFFF', '', 22, 1, 6, 'TPL_BTN_HOVER_TEXT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(126, 1, 'btn-danger-hover-background-color', 'C9302C', 'c9302c', '', 22, 1, 7, 'TPL_BTN_HOVER_BG_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(127, 1, 'btn-danger-hover-border-color', 'AC2925', 'ac2925', '', 22, 1, 8, 'TPL_BTN_HOVER_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(128, 1, 'body-margin-bottom', '0px', '40px', '', 7, 1, 2, 'TPL_BODY_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(129, 1, 'body-margin-left', '0px', '0px', '', 7, 1, 3, 'TPL_BODY_MARGIN_LEFT', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(130, 1, 'body-margin-right', '0px', '0px', '', 7, 1, 4, 'TPL_BODY_MARGIN_RIGHT', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(131, 1, 'img-shadow', '2px 2px 12px 2px', '2px 2px 12px 2px', '', 24, 1, 1, 'TPL_IMG_SHADOW', 'form-control', '', '', 'TPL_IMG_SHADOW_PLACEHOLDER', '', '', '', ''),
(132, 1, 'img-shadow-color', '0A0A0A', '0A0A0A', '', 24, 1, 2, 'TPL_IMG_SHADOW_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(133, 1, 'img-righty', '7deg', '7deg', '', 24, 1, 3, 'TPL_IMG_RIGHTY', 'form-control', '', '', 'TPL_IMG_RIGHTY_PLACEHOLDER', '', '', '', ''),
(134, 1, 'img-lefty', '-7deg', '-7deg', '', 24, 1, 4, 'TPL_IMG_LEFTY', 'form-control', '', '', 'TPL_IMG_LEFTY_PLACEHOLDER', '', '', '', ''),
(135, 1, 'img-righty-less', '4deg', '4deg', '', 24, 1, 5, 'TPL_IMG_RIGHTY_LESS', 'form-control', '', '', 'TPL_IMG_RIGHTY_LESS_PLACEHOLDER', '', '', '', ''),
(136, 1, 'img-lefty-less', '-4deg', '-4deg', '', 24, 1, 6, 'TPL_IMG_LEFTY_LESS', 'form-control', '', '', 'TPL_IMG_LEFTY_LESS_PLACEHOLDER', '', '', '', ''),
(137, 1, 'img-brightness', '110%', '110%', '', 24, 1, 7, 'TPL_IMG_HOVER_BRIGHTNESS', 'form-control', '', '', 'TPL_IMG_HOVER_BRIGHTNESS_PLACEHOLDER', '', '', '', ''),
(138, 1, 'listgroup-paddingLeft', '0px', '0', '', 15, 1, 0, 'TPL_LISTGROUP_PADDING_LEFT', 'form-control', '', '', 'value in px eg. 0px', '', '', '', ''),
(139, 1, 'listgroup-marginBottom', '20px', '0', '', 15, 1, 0, 'TPL_LISTGROUP_PADDING_BOTTOM', 'form-control', '', '', 'value in px eg. 0px', '', '', '', ''),
(140, 1, 'listgroup-itemPosition', 'relative', 'relative', '', 15, 1, 0, 'TPL_LISTGROUP_ITEM_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', 'static, relative, fixed, absolute', '', '', '', ''),
(141, 1, 'listgroup-itemDisplay', 'block', 'block', '', 15, 1, 0, 'TPL_LISTGROUP_ITEM_DISPLAY', 'form-control', 'select', 'block,block:inline,inline:inline-block,inline-block:flex,flex', 'block, inline, inline-block, flex', '', '', '', ''),
(142, 1, 'listgroup-itemPadding', '10px 15px', '10px 15px', '', 15, 1, 0, 'TPL_LISTGROUP_ITEM_PADDING', 'form-control', '', '', 'top, right, bottom left in px', '', '', '', ''),
(143, 1, 'listgroup-itemBorder', '1px solid #2E3037', '1px solid #ddd', '', 15, 1, 0, 'TPL_LISTGROUP_ITEM_BORDER', 'form-control', '', '', 'border width. type and color', '', '', '', ''),
(144, 1, 'listgroup-itemBackgroundColor', 'FFFFFF', 'FFF', '', 15, 1, 0, 'TPL_LISTGROUP_ITEM_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(145, 1, 'jumbotron-paddingTop', '30px', '30px', '', 16, 1, 2, 'TPL_JUMBOTRON_PADDING_TOP', 'form-control', '', '', 'TPL_JUMBOTRON_PADDING_TOP_PLACEHOLDER', '', '', '', ''),
(146, 1, 'jumbotron-paddingBottom', '30px', '30px', '', 16, 1, 3, 'TPL_JUMBOTRON_PADDING_BOTTOM', 'form-control', '', '', 'TPL_JUMBOTRON_PADDING_BOTTOM_PLACEHOLDER', '', '', '', ''),
(147, 1, 'jumbotron-marginBottom', '30px', '30px', '', 16, 1, 4, 'TPL_JUMBOTRON_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_JUMBOTRON_MARGIN_BOTTOM_PLACEHOLDER', '', '', '', ''),
(148, 1, 'jumbotron-backgroundColor', 'EEEEEE', 'EEE', '', 16, 1, 1, 'TPL_JUMBOTRON_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(149, 1, 'jumbotron-pMarginBottom', '15px', '15px', '', 16, 1, 5, 'TPL_JUMBOTRON_P_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_JUMBOTRON_P_MARGIN_BOTTOM_PLACEHOLDER', '', '', '', ''),
(150, 1, 'jumbotron-pFontSize', '21px', '21px', '', 16, 1, 6, 'TPL_JUMBOTRON_P_FONTSIZE', 'form-control', '', '', 'TPL_JUMBOTRON_P_FONTSIZE_PLACEHOLDER', '', '', '', ''),
(151, 1, 'jumbotron-pFontWeight', '200', '200', '', 16, 1, 7, 'TPL_JUMBOTRON_P_FONTWEIGHT', 'form-control', '', '', 'TPL_JUMBOTRON_P_FONTWEIGHT_PLACEHOLDER', '', '', '', ''),
(152, 1, 'jumbotron-hrColor', 'D5D5D5', 'D5D5D5', '', 16, 1, 8, 'TPL_JUMBOTRON_HR_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(153, 1, 'jumbotron-containerPaddingRight', '15px', '15px', '', 16, 1, 9, 'TPL_JUMBOTRON_CONTAINER_PADDING_R', 'form-control', '', '', 'TPL_JUMBOTRON_CONTAINER_PADDING_R_PLACEHOLDER', '', '', '', ''),
(154, 1, 'jumbotron-containerPaddingLeft', '15px', '15px', '', 16, 1, 10, 'TPL_JUMBOTRON_CONTAINER_PADDING_L', 'form-control', '', '', 'TPL_JUMBOTRON_CONTAINER_PADDING_L_PLACEHOLDER', '', '', '', ''),
(155, 1, 'jumbotron-borderRadius', '6px', '6px', '', 16, 1, 11, 'TPL_JUMBOTRON_BORDER_RADIUS', 'form-control', '', '', 'TPL_JUMBOTRON_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(156, 1, 'jumbotron-containerMaxWidth', '100%', '100%', '', 16, 1, 12, 'TPL_JUMBOTRON_CONTAINER_MAXWIDTH', 'form-control', '', '', 'TPL_JUMBOTRON_CONTAINER_MAXWIDTH_PLACEHOLDER', '', '', '', ''),
(157, 1, 'jumbotron-fluidPaddingRight', '60px', '60px', '', 16, 1, 13, 'TPL_JUMBOTRON_FLUID_PADDING_R', 'form-control', '', '', 'TPL_JUMBOTRON_FLUID_PADDING_R_PLACEHOLDER', '', '', '', ''),
(158, 1, 'jumbotron-fluidPaddingLeft', '60px', '60px', '', 16, 1, 14, 'TPL_JUMBOTRON_FLUID_PADDING_L', 'form-control', '', '', 'TPL_JUMBOTRON_FLUID_PADDING_L_PLACEHOLDER', '', '', '', ''),
(159, 1, 'jumbotron-h1FontSize', '63px', '63px', '', 16, 1, 15, 'TPL_JUMBOTRON_H1_FONTSIZE', 'form-control', '', '', 'TPL_JUMBOTRON_H1_FONTSIZE_PLACEHOLDER', '', '', '', ''),
(160, 1, 'jumbotron-h1Color', 'FFFFFF', 'FFFFFF', '', 16, 1, 0, 'TPL_JUMBOTRON_H1_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(161, 1, 'jumbotron-fontColor', 'CCCCCC', 'CCCCCC', '', 5, 1, 9, 'TPL_JUMBOTRON_FONT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(162, 1, 'listgroup-fontColor', 'FFFFFF', 'FFFFFF', '', 5, 1, 10, 'TPL_LISTGROUP_FONT_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(163, 1, 'listgroup-fontSize', '0.9em', '1.2em', '', 15, 1, 0, 'TPL_LISTGROUP_FONTSIZE', 'form-control', '', '', 'font size in em or px eg 16px or 1.2em', '', '', '', ''),
(164, 1, 'navbar-marginTop', '0px', '0px', '', 13, 1, 1, 'TPL_MENU_NAVBAR_MARGIN_TOP', 'form-control', '', '', 'margin in em or px eg 20px or 1.2em', '', '', '', ''),
(174, 1, 'listgroup-bg-gradient-longValue', '', '', '', 15, 1, 0, 'TPL_LISTGROUP_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(175, 1, 'listgroup-firstChild-topLeft-radius', '4px', '4px', '', 15, 1, 0, 'TPL_LISTGROUP_FIRST_CHILD_TOP_L_BORDER_RADIUS', 'form-control', '', '', 'value in px eg. 4px', '', '', '', ''),
(176, 1, 'listgroup-firstChild-topRight-radius', '4px', '4px', '', 15, 1, 0, 'TPL_LISTGROUP_FIRST_CHILD_TOP_R_BORDER_RADIUS', 'form-control', '', '', 'value in px eg. 4px', '', '', '', ''),
(177, 1, 'listgroup-lastChild-bottomRight-radius', '4px', '4px', '', 15, 1, 0, 'TPL_LISTGROUP_LAST_CHILD_BOTTOM_R_BORDER_RADIUS', 'form-control', '', '', 'value in px eg. 4px', '', '', '', ''),
(178, 1, 'listgroup-lastChild-bottomLeft-radius', '4px', '4px', '', 15, 1, 0, 'TPL_LISTGROUP_LAST_CHILD_BOTTOM_L_BORDER_RADIUS', 'form-control', '', '', 'value in px eg. 4px', '', '', '', ''),
(267, 1, 'pos-outerTop-indicator', '1', '0', '', 26, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(268, 1, 'pos-outerTop-vertical-align', 'baseline', 'baseline', '', 26, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(269, 1, 'pos-outerTop-customCSS-longValue', '', '', '', 26, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(270, 1, 'pos-outerTop-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 26, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(271, 1, 'pos-outerTop-box-shadow-color', '888888', '888888', '', 26, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(272, 1, 'pos-outerTop-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 26, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(273, 1, 'pos-outerTop-border-style', 'none', 'solid', '', 26, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(274, 1, 'pos-outerTop-border-color', '888888', '888888', '', 26, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(275, 1, 'pos-outerTop-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 26, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(276, 1, 'pos-outerTop-padding', '0px', '0px', '', 26, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(277, 1, 'pos-outerTop-overflow', 'visible', 'visible', '', 26, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(278, 1, 'pos-outerTop-visibility', 'visible', 'visible', '', 26, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(279, 1, 'pos-outerTop-text-align', 'left', 'left', '', 26, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(280, 1, 'pos-outerTop-enabled', '1', '0', '', 26, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_OUTERTOP_HEADING', 'TPL_POS_OUTERTOP_SUBTEXT'),
(281, 1, 'pos-outerTop-bg-gradient-longValue', '', '', '', 26, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(282, 1, 'pos-outerTop-zindex', '9999', '9999', '', 26, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(283, 1, 'pos-outerTop-width', '100%', '100%', '', 26, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(284, 1, 'pos-outerTop-height', 'auto', 'auto', '', 26, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(285, 1, 'pos-outerTop-bgcolor', 'F8F8F8', 'F8F8F8', '', 26, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(286, 1, 'pos-outerTop-position', 'static', 'static', '', 26, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(287, 1, 'pos-outerTop-marginBottom', '0px', '0px', '', 26, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(288, 1, 'pos-outerTop-marginTop', '0px', '0px', '', 26, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(289, 1, 'pos-intro-indicator', '1', '0', '', 27, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(290, 1, 'pos-intro-vertical-align', 'baseline', 'baseline', '', 27, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(291, 1, 'pos-intro-customCSS-longValue', '', '', '', 27, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(292, 1, 'pos-intro-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 27, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(293, 1, 'pos-intro-box-shadow-color', '888888', '888888', '', 27, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(294, 1, 'pos-intro-box-shadow-width', '1px 6px 25px -8px', '6px 6px 25px -8px', '', 27, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(295, 1, 'pos-intro-border-style', 'none', 'solid', '', 27, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(296, 1, 'pos-intro-border-color', '888888', '888888', '', 27, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(297, 1, 'pos-intro-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 27, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(298, 1, 'pos-intro-padding', '0px', '0px', '', 27, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(299, 1, 'pos-intro-overflow', 'visible', 'visible', '', 27, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(300, 1, 'pos-intro-visibility', 'visible', 'visible', '', 27, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(301, 1, 'pos-intro-text-align', 'left', 'left', '', 27, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(302, 1, 'pos-intro-enabled', '1', '0', '', 27, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_INTRO_HEADING', 'TPL_POS_INTRO_SUBTEXT'),
(303, 1, 'pos-intro-bg-gradient-longValue', '', '', '', 27, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(304, 1, 'pos-intro-zindex', '9999', '9999', '', 27, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(305, 1, 'pos-intro-width', '100%', '100%', '', 27, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(306, 1, 'pos-intro-height', 'auto', 'auto', '', 27, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(307, 1, 'pos-intro-bgcolor', 'F8F8F8', 'F8F8F8', '', 27, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(308, 1, 'pos-intro-position', 'static', 'static', '', 27, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(309, 1, 'pos-intro-marginBottom', '0px', '0px', '', 27, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(310, 1, 'pos-intro-marginTop', '0px', '0px', '', 27, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(311, 1, 'pos-globalmenu-indicator', '1', '0', '', 28, 1, 30, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(312, 1, 'pos-globalmenu-vertical-align', 'baseline', 'baseline', '', 28, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(313, 1, 'pos-globalmenu-customCSS-longValue', '', '', '', 28, 1, 29, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(314, 1, 'pos-globalmenu-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 28, 1, 18, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(315, 1, 'pos-globalmenu-box-shadow-color', '888888', '888888', '', 28, 1, 20, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(316, 1, 'pos-globalmenu-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 28, 1, 19, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(317, 1, 'pos-globalmenu-border-style', 'none', 'solid', '', 28, 1, 17, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(318, 1, 'pos-globalmenu-border-color', '888888', '888888', '', 28, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(319, 1, 'pos-globalmenu-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 28, 1, 15, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(320, 1, 'pos-globalmenu-padding', '0px', '0px', '', 28, 1, 24, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(321, 1, 'pos-globalmenu-overflow', 'visible', 'visible', '', 28, 1, 25, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(322, 1, 'pos-globalmenu-visibility', 'visible', 'visible', '', 28, 1, 27, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(323, 1, 'pos-globalmenu-text-align', 'left', 'left', '', 28, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(324, 1, 'pos-globalmenu-enabled', '1', '0', '', 28, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_GLOBALMENU_HEADING', 'TPL_POS_GLOBALMENU_SUBTEXT'),
(325, 1, 'pos-globalmenu-bg-gradient-longValue', '', '', '', 28, 1, 14, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(326, 1, 'pos-globalmenu-zindex', '9999', '9999', '', 28, 1, 26, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(327, 1, 'pos-globalmenu-width', '100%', '100%', '', 28, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(328, 1, 'pos-globalmenu-height', 'auto', 'auto', '', 28, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(329, 1, 'pos-globalmenu-bgcolor', 'F8F8F8', 'F8F8F8', '', 28, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(330, 1, 'pos-globalmenu-position', 'static', 'static', '', 28, 1, 21, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(331, 1, 'pos-globalmenu-marginBottom', '0px', '0px', '', 28, 1, 23, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(332, 1, 'pos-globalmenu-marginTop', '0px', '0px', '', 28, 1, 22, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(333, 1, 'pos-top-indicator', '1', '0', '', 29, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(334, 1, 'pos-top-vertical-align', 'baseline', 'baseline', '', 29, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(335, 1, 'pos-top-customCSS-longValue', '', '', '', 29, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(336, 1, 'pos-top-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 29, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(337, 1, 'pos-top-box-shadow-color', '888888', '888888', '', 29, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(338, 1, 'pos-top-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 29, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(339, 1, 'pos-top-border-style', 'none', 'solid', '', 29, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(340, 1, 'pos-top-border-color', '888888', '888888', '', 29, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(341, 1, 'pos-top-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 29, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(342, 1, 'pos-top-padding', '0px', '0px', '', 29, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(343, 1, 'pos-top-overflow', 'visible', 'visible', '', 29, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(344, 1, 'pos-top-visibility', 'visible', 'visible', '', 29, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(345, 1, 'pos-top-text-align', 'left', 'left', '', 29, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(346, 1, 'pos-top-enabled', '1', '0', '', 29, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_TOP_HEADING', 'TPL_POS_TOP_SUBTEXT'),
(347, 1, 'pos-top-bg-gradient-longValue', '', '', '', 29, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(348, 1, 'pos-top-zindex', '9999', '9999', '', 29, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(349, 1, 'pos-top-width', '100%', '100%', '', 29, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(350, 1, 'pos-top-height', 'auto', 'auto', '', 29, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(351, 1, 'pos-top-bgcolor', 'F8F8F8', 'F8F8F8', '', 29, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(352, 1, 'pos-top-position', 'static', 'static', '', 29, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(353, 1, 'pos-top-marginBottom', '0px', '0px', '', 29, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(354, 1, 'pos-top-marginTop', '0px', '0px', '', 29, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(355, 1, 'pos-outerLeft-indicator', '1', '0', '', 30, 1, 27, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(356, 1, 'pos-outerLeft-vertical-align', 'baseline', 'baseline', '', 30, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(357, 1, 'pos-outerLeft-customCSS-longValue', '', '', '', 30, 1, 26, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(358, 1, 'pos-outerLeft-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 30, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(359, 1, 'pos-outerLeft-box-shadow-color', 'FFFFFF', '888888', '', 30, 1, 18, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(360, 1, 'pos-outerLeft-box-shadow-width', '0px 0px 0px 0px', '6px 6px 25px -8px', '', 30, 1, 17, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(361, 1, 'pos-outerLeft-border-style', 'none', 'solid', '', 30, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(362, 1, 'pos-outerLeft-border-color', '888888', '888888', '', 30, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(363, 1, 'pos-outerLeft-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 30, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(364, 1, 'pos-outerLeft-padding', '0px', '0px', '', 30, 1, 22, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(365, 1, 'pos-outerLeft-overflow', 'visible', 'visible', '', 30, 1, 23, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(366, 1, 'pos-outerLeft-visibility', 'visible', 'visible', '', 30, 1, 25, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(367, 1, 'pos-outerLeft-text-align', 'left', 'left', '', 30, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(368, 1, 'pos-outerLeft-enabled', '1', '0', '', 30, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_OUTERLEFT_HEADING', 'TPL_POS_OUTERLEFT_SUBTEXT'),
(369, 1, 'pos-outerLeft-bg-gradient-longValue', '', '', '', 30, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(370, 1, 'pos-outerLeft-zindex', '9999', '9999', '', 30, 1, 24, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(371, 1, 'pos-outerLeft-width', '', '100%', '', 30, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(372, 1, 'pos-outerLeft-height', 'auto', 'auto', '', 30, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(373, 1, 'pos-outerLeft-bgcolor', 'F8F8F8', 'F8F8F8', '', 30, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(374, 1, 'pos-outerLeft-position', 'static', 'static', '', 30, 1, 19, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(375, 1, 'pos-outerLeft-marginBottom', '0px', '0px', '', 30, 1, 21, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(376, 1, 'pos-outerLeft-marginTop', '0px', '0px', '', 30, 1, 20, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(377, 1, 'pos-outerRight-indicator', '1', '0', '', 31, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(378, 1, 'pos-outerRight-vertical-align', 'baseline', 'baseline', '', 31, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(379, 1, 'pos-outerRight-customCSS-longValue', '', '', '', 31, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(380, 1, 'pos-outerRight-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 31, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(381, 1, 'pos-outerRight-box-shadow-color', '888888', '888888', '', 31, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(382, 1, 'pos-outerRight-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 31, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(383, 1, 'pos-outerRight-border-style', 'none', 'solid', '', 31, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(384, 1, 'pos-outerRight-border-color', '888888', '888888', '', 31, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', '');
INSERT INTO `cms_template_settings` (`id`, `templateID`, `property`, `value`, `valueDefault`, `longValue`, `type`, `activated`, `sort`, `label`, `fieldClass`, `fieldType`, `options`, `placeholder`, `description`, `icon`, `heading`, `subtext`) VALUES
(385, 1, 'pos-outerRight-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 31, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(386, 1, 'pos-outerRight-padding', '0px', '0px', '', 31, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(387, 1, 'pos-outerRight-overflow', 'visible', 'visible', '', 31, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(388, 1, 'pos-outerRight-visibility', 'visible', 'visible', '', 31, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(389, 1, 'pos-outerRight-text-align', 'left', 'left', '', 31, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(390, 1, 'pos-outerRight-enabled', '1', '0', '', 31, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_OUTERRIGHT_HEADING', 'TPL_POS_OUTERRIGHT_SUBTEXT'),
(391, 1, 'pos-outerRight-bg-gradient-longValue', '', '', '', 31, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(392, 1, 'pos-outerRight-zindex', '9999', '9999', '', 31, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(393, 1, 'pos-outerRight-width', '100%', '100%', '', 31, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(394, 1, 'pos-outerRight-height', 'auto', 'auto', '', 31, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(395, 1, 'pos-outerRight-bgcolor', 'F8F8F8', 'F8F8F8', '', 31, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(396, 1, 'pos-outerRight-position', 'static', 'static', '', 31, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(397, 1, 'pos-outerRight-marginBottom', '0px', '0px', '', 31, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(398, 1, 'pos-outerRight-marginTop', '0px', '0px', '', 31, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(399, 1, 'pos-leftMenu-indicator', '1', '0', '', 32, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(400, 1, 'pos-leftMenu-vertical-align', 'baseline', 'baseline', '', 32, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(401, 1, 'pos-leftMenu-customCSS-longValue', '', '', '', 32, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(402, 1, 'pos-leftMenu-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 32, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(403, 1, 'pos-leftMenu-box-shadow-color', '888888', '888888', '', 32, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(404, 1, 'pos-leftMenu-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 32, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(405, 1, 'pos-leftMenu-border-style', 'none', 'solid', '', 32, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(406, 1, 'pos-leftMenu-border-color', '888888', '888888', '', 32, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(407, 1, 'pos-leftMenu-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 32, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(408, 1, 'pos-leftMenu-padding', '0px', '0px', '', 32, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(409, 1, 'pos-leftMenu-overflow', 'visible', 'visible', '', 32, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(410, 1, 'pos-leftMenu-visibility', 'visible', 'visible', '', 32, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(411, 1, 'pos-leftMenu-text-align', 'left', 'left', '', 32, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(412, 1, 'pos-leftMenu-enabled', '1', '0', '', 32, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_LEFTMENU_HEADING', 'TPL_POS_LEFTMENU_SUBTEXT'),
(413, 1, 'pos-leftMenu-bg-gradient-longValue', '', '', '', 32, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(414, 1, 'pos-leftMenu-zindex', '9999', '9999', '', 32, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(415, 1, 'pos-leftMenu-width', '100%', '100%', '', 32, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(416, 1, 'pos-leftMenu-height', 'auto', 'auto', '', 32, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(417, 1, 'pos-leftMenu-bgcolor', 'F8F8F8', 'F8F8F8', '', 32, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(418, 1, 'pos-leftMenu-position', 'static', 'static', '', 32, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(419, 1, 'pos-leftMenu-marginBottom', '0px', '0px', '', 32, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(420, 1, 'pos-leftMenu-marginTop', '0px', '0px', '', 32, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(421, 1, 'pos-rightMenu-indicator', '1', '0', '', 33, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(422, 1, 'pos-rightMenu-vertical-align', 'baseline', 'baseline', '', 33, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(423, 1, 'pos-rightMenu-customCSS-longValue', '', '', '', 33, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(424, 1, 'pos-rightMenu-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 33, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(425, 1, 'pos-rightMenu-box-shadow-color', '888888', '888888', '', 33, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(426, 1, 'pos-rightMenu-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 33, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(427, 1, 'pos-rightMenu-border-style', 'none', 'solid', '', 33, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(428, 1, 'pos-rightMenu-border-color', '888888', '888888', '', 33, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(429, 1, 'pos-rightMenu-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 33, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(430, 1, 'pos-rightMenu-padding', '0px', '0px', '', 33, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(431, 1, 'pos-rightMenu-overflow', 'visible', 'visible', '', 33, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(432, 1, 'pos-rightMenu-visibility', 'visible', 'visible', '', 33, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(433, 1, 'pos-rightMenu-text-align', 'left', 'left', '', 33, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(434, 1, 'pos-rightMenu-enabled', '1', '0', '', 33, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_RIGHTMENU_HEADING', 'TPL_POS_RIGHTMENU_SUBTEXT'),
(435, 1, 'pos-rightMenu-bg-gradient-longValue', '', '', '', 33, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(436, 1, 'pos-rightMenu-zindex', '9999', '9999', '', 33, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(437, 1, 'pos-rightMenu-width', '100%', '100%', '', 33, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(438, 1, 'pos-rightMenu-height', 'auto', 'auto', '', 33, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(439, 1, 'pos-rightMenu-bgcolor', 'F8F8F8', 'F8F8F8', '', 33, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(440, 1, 'pos-rightMenu-position', 'static', 'static', '', 33, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(441, 1, 'pos-rightMenu-marginBottom', '0px', '0px', '', 33, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(442, 1, 'pos-rightMenu-marginTop', '0px', '0px', '', 33, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(443, 1, 'pos-mainTop-indicator', '1', '0', '', 34, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(444, 1, 'pos-mainTop-vertical-align', 'baseline', 'baseline', '', 34, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(445, 1, 'pos-mainTop-customCSS-longValue', '', '', '', 34, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(446, 1, 'pos-mainTop-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 34, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(447, 1, 'pos-mainTop-box-shadow-color', '888888', '888888', '', 34, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(448, 1, 'pos-mainTop-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 34, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(449, 1, 'pos-mainTop-border-style', 'none', 'solid', '', 34, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(450, 1, 'pos-mainTop-border-color', '888888', '888888', '', 34, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(451, 1, 'pos-mainTop-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 34, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(452, 1, 'pos-mainTop-padding', '0px', '0px', '', 34, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(453, 1, 'pos-mainTop-overflow', 'visible', 'visible', '', 34, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(454, 1, 'pos-mainTop-visibility', 'visible', 'visible', '', 34, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(455, 1, 'pos-mainTop-text-align', 'left', 'left', '', 34, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(456, 1, 'pos-mainTop-enabled', '1', '0', '', 34, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINTOP_HEADING', 'TPL_POS_MAINTOP_SUBTEXT'),
(457, 1, 'pos-mainTop-bg-gradient-longValue', '', '', '', 34, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(458, 1, 'pos-mainTop-zindex', '9999', '9999', '', 34, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(459, 1, 'pos-mainTop-width', '100%', '100%', '', 34, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(460, 1, 'pos-mainTop-height', 'auto', 'auto', '', 34, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(461, 1, 'pos-mainTop-bgcolor', 'F8F8F8', 'F8F8F8', '', 34, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(462, 1, 'pos-mainTop-position', 'static', 'static', '', 34, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(463, 1, 'pos-mainTop-marginBottom', '0px', '0px', '', 34, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(464, 1, 'pos-mainTop-marginTop', '0px', '0px', '', 34, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(465, 1, 'pos-mainTopLeft-indicator', '1', '0', '', 35, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(466, 1, 'pos-mainTopLeft-vertical-align', 'baseline', 'baseline', '', 35, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(467, 1, 'pos-mainTopLeft-customCSS-longValue', '', '', '', 35, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(468, 1, 'pos-mainTopLeft-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 35, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(469, 1, 'pos-mainTopLeft-box-shadow-color', '888888', '888888', '', 35, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(470, 1, 'pos-mainTopLeft-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 35, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(471, 1, 'pos-mainTopLeft-border-style', 'none', 'solid', '', 35, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(472, 1, 'pos-mainTopLeft-border-color', '888888', '888888', '', 35, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(473, 1, 'pos-mainTopLeft-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 35, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(474, 1, 'pos-mainTopLeft-padding', '0px', '0px', '', 35, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(475, 1, 'pos-mainTopLeft-overflow', 'visible', 'visible', '', 35, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(476, 1, 'pos-mainTopLeft-visibility', 'visible', 'visible', '', 35, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(477, 1, 'pos-mainTopLeft-text-align', 'left', 'left', '', 35, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(478, 1, 'pos-mainTopLeft-enabled', '1', '0', '', 35, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINTOPLEFT_HEADING', 'TPL_POS_MAINTOPLEFT_SUBTEXT'),
(479, 1, 'pos-mainTopLeft-bg-gradient-longValue', '', '', '', 35, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(480, 1, 'pos-mainTopLeft-zindex', '9999', '9999', '', 35, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(481, 1, 'pos-mainTopLeft-width', '100%', '100%', '', 35, 0, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(482, 1, 'pos-mainTopLeft-height', 'auto', 'auto', '', 35, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(483, 1, 'pos-mainTopLeft-bgcolor', 'F8F8F8', 'F8F8F8', '', 35, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(484, 1, 'pos-mainTopLeft-position', 'static', 'static', '', 35, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(485, 1, 'pos-mainTopLeft-marginBottom', '0px', '0px', '', 35, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(486, 1, 'pos-mainTopLeft-marginTop', '0px', '0px', '', 35, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(487, 1, 'pos-mainTopCenter-indicator', '1', '0', '', 36, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(488, 1, 'pos-mainTopCenter-vertical-align', 'baseline', 'baseline', '', 36, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(489, 1, 'pos-mainTopCenter-customCSS-longValue', '', '', '', 36, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(490, 1, 'pos-mainTopCenter-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 36, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(491, 1, 'pos-mainTopCenter-box-shadow-color', '888888', '888888', '', 36, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(492, 1, 'pos-mainTopCenter-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 36, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(493, 1, 'pos-mainTopCenter-border-style', 'none', 'solid', '', 36, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(494, 1, 'pos-mainTopCenter-border-color', '888888', '888888', '', 36, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(495, 1, 'pos-mainTopCenter-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 36, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(496, 1, 'pos-mainTopCenter-padding', '0px', '0px', '', 36, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(497, 1, 'pos-mainTopCenter-overflow', 'visible', 'visible', '', 36, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(498, 1, 'pos-mainTopCenter-visibility', 'visible', 'visible', '', 36, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(499, 1, 'pos-mainTopCenter-text-align', 'left', 'left', '', 36, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(500, 1, 'pos-mainTopCenter-enabled', '1', '0', '', 36, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINTOPCENTER_HEADING', 'TPL_POS_MAINTOPCENTER_SUBTEXT'),
(501, 1, 'pos-mainTopCenter-bg-gradient-longValue', '', '', '', 36, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(502, 1, 'pos-mainTopCenter-zindex', '9999', '9999', '', 36, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(503, 1, 'pos-mainTopCenter-width', '100%', '100%', '', 36, 0, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(504, 1, 'pos-mainTopCenter-height', 'auto', 'auto', '', 36, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(505, 1, 'pos-mainTopCenter-bgcolor', 'F8F8F8', 'F8F8F8', '', 36, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(506, 1, 'pos-mainTopCenter-position', 'static', 'static', '', 36, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(507, 1, 'pos-mainTopCenter-marginBottom', '0px', '0px', '', 36, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(508, 1, 'pos-mainTopCenter-marginTop', '0px', '0px', '', 36, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(509, 1, 'pos-mainTopRight-indicator', '1', '0', '', 37, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(510, 1, 'pos-mainTopRight-vertical-align', 'baseline', 'baseline', '', 37, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(511, 1, 'pos-mainTopRight-customCSS-longValue', '', '', '', 37, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(512, 1, 'pos-mainTopRight-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 37, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(513, 1, 'pos-mainTopRight-box-shadow-color', '888888', '888888', '', 37, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(514, 1, 'pos-mainTopRight-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 37, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(515, 1, 'pos-mainTopRight-border-style', 'none', 'solid', '', 37, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(516, 1, 'pos-mainTopRight-border-color', '888888', '888888', '', 37, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(517, 1, 'pos-mainTopRight-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 37, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(518, 1, 'pos-mainTopRight-padding', '0px', '0px', '', 37, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(519, 1, 'pos-mainTopRight-overflow', 'visible', 'visible', '', 37, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(520, 1, 'pos-mainTopRight-visibility', 'visible', 'visible', '', 37, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(521, 1, 'pos-mainTopRight-text-align', 'left', 'left', '', 37, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(522, 1, 'pos-mainTopRight-enabled', '1', '0', '', 37, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINTOPRIGHT_HEADING', 'TPL_POS_MAINTOPRIGHT_SUBTEXT'),
(523, 1, 'pos-mainTopRight-bg-gradient-longValue', '', '', '', 37, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(524, 1, 'pos-mainTopRight-zindex', '9999', '9999', '', 37, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(525, 1, 'pos-mainTopRight-width', '100%', '100%', '', 37, 0, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(526, 1, 'pos-mainTopRight-height', 'auto', 'auto', '', 37, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(527, 1, 'pos-mainTopRight-bgcolor', 'F8F8F8', 'F8F8F8', '', 37, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(528, 1, 'pos-mainTopRight-position', 'static', 'static', '', 37, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(529, 1, 'pos-mainTopRight-marginBottom', '0px', '0px', '', 37, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(530, 1, 'pos-mainTopRight-marginTop', '0px', '0px', '', 37, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(531, 1, 'pos-main-indicator', '1', '0', '', 38, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(532, 1, 'pos-main-vertical-align', 'baseline', 'baseline', '', 38, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(533, 1, 'pos-main-customCSS-longValue', '', '', '', 38, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(534, 1, 'pos-main-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 38, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(535, 1, 'pos-main-box-shadow-color', '888888', '888888', '', 38, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(536, 1, 'pos-main-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 38, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(537, 1, 'pos-main-border-style', 'none', 'solid', '', 38, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(538, 1, 'pos-main-border-color', '888888', '888888', '', 38, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(539, 1, 'pos-main-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 38, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(540, 1, 'pos-main-padding', '0px', '0px', '', 38, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(541, 1, 'pos-main-overflow', 'visible', 'visible', '', 38, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(542, 1, 'pos-main-visibility', 'visible', 'visible', '', 38, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(543, 1, 'pos-main-text-align', 'left', 'left', '', 38, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(544, 1, 'pos-main-enabled', '1', '0', '', 38, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAIN_HEADING', 'TPL_POS_MAIN_SUBTEXT'),
(545, 1, 'pos-main-bg-gradient-longValue', '', '', '', 38, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(546, 1, 'pos-main-zindex', '9999', '9999', '', 38, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(547, 1, 'pos-main-width', '100%', '100%', '', 38, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(548, 1, 'pos-main-height', 'auto', 'auto', '', 38, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(549, 1, 'pos-main-bgcolor', 'FFFFFF', 'F8F8F8', '', 38, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(550, 1, 'pos-main-position', 'static', 'static', '', 38, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(551, 1, 'pos-main-marginBottom', '0px', '0px', '', 38, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(552, 1, 'pos-main-marginTop', '0px', '0px', '', 38, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(553, 1, 'pos-mainBottom-indicator', '1', '0', '', 39, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(554, 1, 'pos-mainBottom-vertical-align', 'baseline', 'baseline', '', 39, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(555, 1, 'pos-mainBottom-customCSS-longValue', '', '', '', 39, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(556, 1, 'pos-mainBottom-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 39, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(557, 1, 'pos-mainBottom-box-shadow-color', '888888', '888888', '', 39, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(558, 1, 'pos-mainBottom-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 39, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(559, 1, 'pos-mainBottom-border-style', 'none', 'solid', '', 39, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(560, 1, 'pos-mainBottom-border-color', '888888', '888888', '', 39, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(561, 1, 'pos-mainBottom-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 39, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(562, 1, 'pos-mainBottom-padding', '0px', '0px', '', 39, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(563, 1, 'pos-mainBottom-overflow', 'visible', 'visible', '', 39, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(564, 1, 'pos-mainBottom-visibility', 'visible', 'visible', '', 39, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(565, 1, 'pos-mainBottom-text-align', 'left', 'left', '', 39, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(566, 1, 'pos-mainBottom-enabled', '1', '0', '', 39, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINBOTTOM_HEADING', 'TPL_POS_MAINBOTTOM_SUBTEXT'),
(567, 1, 'pos-mainBottom-bg-gradient-longValue', '', '', '', 39, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(568, 1, 'pos-mainBottom-zindex', '9999', '9999', '', 39, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(569, 1, 'pos-mainBottom-width', '100%', '100%', '', 39, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(570, 1, 'pos-mainBottom-height', 'auto', 'auto', '', 39, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(571, 1, 'pos-mainBottom-bgcolor', 'F8F8F8', 'F8F8F8', '', 39, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(572, 1, 'pos-mainBottom-position', 'static', 'static', '', 39, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(573, 1, 'pos-mainBottom-marginBottom', '0px', '0px', '', 39, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(574, 1, 'pos-mainBottom-marginTop', '0px', '0px', '', 39, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(575, 1, 'pos-mainBottomLeft-indicator', '1', '0', '', 40, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(576, 1, 'pos-mainBottomLeft-vertical-align', 'baseline', 'baseline', '', 40, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(577, 1, 'pos-mainBottomLeft-customCSS-longValue', '', '', '', 40, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(578, 1, 'pos-mainBottomLeft-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 40, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(579, 1, 'pos-mainBottomLeft-box-shadow-color', '888888', '888888', '', 40, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(580, 1, 'pos-mainBottomLeft-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 40, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(581, 1, 'pos-mainBottomLeft-border-style', 'none', 'solid', '', 40, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(582, 1, 'pos-mainBottomLeft-border-color', '888888', '888888', '', 40, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(583, 1, 'pos-mainBottomLeft-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 40, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(584, 1, 'pos-mainBottomLeft-padding', '0px', '0px', '', 40, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(585, 1, 'pos-mainBottomLeft-overflow', 'visible', 'visible', '', 40, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(586, 1, 'pos-mainBottomLeft-visibility', 'visible', 'visible', '', 40, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(587, 1, 'pos-mainBottomLeft-text-align', 'left', 'left', '', 40, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(588, 1, 'pos-mainBottomLeft-enabled', '1', '0', '', 40, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINBOTTOMLEFT_HEADING', 'TPL_POS_MAINBOTTOMLEFT_SUBTEXT'),
(589, 1, 'pos-mainBottomLeft-bg-gradient-longValue', '', '', '', 40, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(590, 1, 'pos-mainBottomLeft-zindex', '9999', '9999', '', 40, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(591, 1, 'pos-mainBottomLeft-width', '100%', '100%', '', 40, 0, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(592, 1, 'pos-mainBottomLeft-height', 'auto', 'auto', '', 40, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(593, 1, 'pos-mainBottomLeft-bgcolor', 'F8F8F8', 'F8F8F8', '', 40, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(594, 1, 'pos-mainBottomLeft-position', 'static', 'static', '', 40, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(595, 1, 'pos-mainBottomLeft-marginBottom', '0px', '0px', '', 40, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(596, 1, 'pos-mainBottomLeft-marginTop', '0px', '0px', '', 40, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(597, 1, 'pos-mainBottomCenter-indicator', '1', '0', '', 41, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(598, 1, 'pos-mainBottomCenter-vertical-align', 'baseline', 'baseline', '', 41, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(599, 1, 'pos-mainBottomCenter-customCSS-longValue', '', '', '', 41, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(600, 1, 'pos-mainBottomCenter-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 41, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(601, 1, 'pos-mainBottomCenter-box-shadow-color', '888888', '888888', '', 41, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(602, 1, 'pos-mainBottomCenter-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 41, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(603, 1, 'pos-mainBottomCenter-border-style', 'none', 'solid', '', 41, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(604, 1, 'pos-mainBottomCenter-border-color', '888888', '888888', '', 41, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(605, 1, 'pos-mainBottomCenter-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 41, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(606, 1, 'pos-mainBottomCenter-padding', '0px', '0px', '', 41, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(607, 1, 'pos-mainBottomCenter-overflow', 'visible', 'visible', '', 41, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(608, 1, 'pos-mainBottomCenter-visibility', 'visible', 'visible', '', 41, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(609, 1, 'pos-mainBottomCenter-text-align', 'left', 'left', '', 41, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(610, 1, 'pos-mainBottomCenter-enabled', '1', '0', '', 41, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINBOTTOMCENTER_HEADING', 'TPL_POS_MAINBOTTOMCENTER_SUBTEXT'),
(611, 1, 'pos-mainBottomCenter-bg-gradient-longValue', '', '', '', 41, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(612, 1, 'pos-mainBottomCenter-zindex', '9999', '9999', '', 41, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(613, 1, 'pos-mainBottomCenter-width', '100%', '100%', '', 41, 0, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(614, 1, 'pos-mainBottomCenter-height', 'auto', 'auto', '', 41, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(615, 1, 'pos-mainBottomCenter-bgcolor', 'F8F8F8', 'F8F8F8', '', 41, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(616, 1, 'pos-mainBottomCenter-position', 'static', 'static', '', 41, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(617, 1, 'pos-mainBottomCenter-marginBottom', '0px', '0px', '', 41, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(618, 1, 'pos-mainBottomCenter-marginTop', '0px', '0px', '', 41, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(619, 1, 'pos-mainBottomRight-indicator', '1', '0', '', 42, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(620, 1, 'pos-mainBottomRight-vertical-align', 'baseline', 'baseline', '', 42, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(621, 1, 'pos-mainBottomRight-customCSS-longValue', '', '', '', 42, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(622, 1, 'pos-mainBottomRight-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 42, 1, 18, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(623, 1, 'pos-mainBottomRight-box-shadow-color', '888888', '888888', '', 42, 1, 20, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(624, 1, 'pos-mainBottomRight-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 42, 1, 19, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(625, 1, 'pos-mainBottomRight-border-style', 'none', 'solid', '', 42, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(626, 1, 'pos-mainBottomRight-border-color', '888888', '888888', '', 42, 1, 17, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(627, 1, 'pos-mainBottomRight-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 42, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(628, 1, 'pos-mainBottomRight-padding', '0px', '0px', '', 42, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(629, 1, 'pos-mainBottomRight-overflow', 'visible', 'visible', '', 42, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(630, 1, 'pos-mainBottomRight-visibility', 'visible', 'visible', '', 42, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(631, 1, 'pos-mainBottomRight-text-align', 'left', 'left', '', 42, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(632, 1, 'pos-mainBottomRight-enabled', '1', '0', '', 42, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINBOTTOMRIGHT_HEADING', 'TPL_POS_MAINBOTTOMRIGHT_SUBTEXT'),
(633, 1, 'pos-mainBottomRight-bg-gradient-longValue', '', '', '', 42, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(634, 1, 'pos-mainBottomRight-zindex', '9999', '9999', '', 42, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(635, 1, 'pos-mainBottomRight-width', '100%', '100%', '', 42, 0, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(636, 1, 'pos-mainBottomRight-height', 'auto', 'auto', '', 42, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(637, 1, 'pos-mainBottomRight-bgcolor', 'F8F8F8', 'F8F8F8', '', 42, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(638, 1, 'pos-mainBottomRight-position', 'static', 'static', '', 42, 1, 22, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(639, 1, 'pos-mainBottomRight-marginBottom', '0px', '0px', '', 42, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(640, 1, 'pos-mainBottomRight-marginTop', '0px', '0px', '', 42, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(641, 1, 'pos-mainFooter-indicator', '1', '0', '', 43, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(642, 1, 'pos-mainFooter-vertical-align', 'baseline', 'baseline', '', 43, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', '');
INSERT INTO `cms_template_settings` (`id`, `templateID`, `property`, `value`, `valueDefault`, `longValue`, `type`, `activated`, `sort`, `label`, `fieldClass`, `fieldType`, `options`, `placeholder`, `description`, `icon`, `heading`, `subtext`) VALUES
(643, 1, 'pos-mainFooter-customCSS-longValue', '', '', '', 43, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(644, 1, 'pos-mainFooter-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 43, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(645, 1, 'pos-mainFooter-box-shadow-color', '888888', '888888', '', 43, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(646, 1, 'pos-mainFooter-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 43, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(647, 1, 'pos-mainFooter-border-style', 'none', 'solid', '', 43, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(648, 1, 'pos-mainFooter-border-color', '888888', '888888', '', 43, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(649, 1, 'pos-mainFooter-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 43, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(650, 1, 'pos-mainFooter-padding', '0px', '0px', '', 43, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(651, 1, 'pos-mainFooter-overflow', 'visible', 'visible', '', 43, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(652, 1, 'pos-mainFooter-visibility', 'visible', 'visible', '', 43, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(653, 1, 'pos-mainFooter-text-align', 'left', 'left', '', 43, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(654, 1, 'pos-mainFooter-enabled', '1', '0', '', 43, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINFOOTER_HEADING', 'TPL_POS_MAINFOOTER_SUBTEXT'),
(655, 1, 'pos-mainFooter-bg-gradient-longValue', '', '', '', 43, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(656, 1, 'pos-mainFooter-zindex', '9999', '9999', '', 43, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(657, 1, 'pos-mainFooter-width', '100%', '100%', '', 43, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(658, 1, 'pos-mainFooter-height', 'auto', 'auto', '', 43, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(659, 1, 'pos-mainFooter-bgcolor', 'F8F8F8', 'F8F8F8', '', 43, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(660, 1, 'pos-mainFooter-position', 'static', 'static', '', 43, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(661, 1, 'pos-mainFooter-marginBottom', '0px', '0px', '', 43, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(662, 1, 'pos-mainFooter-marginTop', '0px', '0px', '', 43, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(663, 1, 'pos-mainFooterLeft-indicator', '1', '0', '', 44, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(664, 1, 'pos-mainFooterLeft-vertical-align', 'baseline', 'baseline', '', 44, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(665, 1, 'pos-mainFooterLeft-customCSS-longValue', '', '', '', 44, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(666, 1, 'pos-mainFooterLeft-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 44, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(667, 1, 'pos-mainFooterLeft-box-shadow-color', '888888', '888888', '', 44, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(668, 1, 'pos-mainFooterLeft-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 44, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(669, 1, 'pos-mainFooterLeft-border-style', 'none', 'solid', '', 44, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(670, 1, 'pos-mainFooterLeft-border-color', '888888', '888888', '', 44, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(671, 1, 'pos-mainFooterLeft-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 44, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(672, 1, 'pos-mainFooterLeft-padding', '0px', '0px', '', 44, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(673, 1, 'pos-mainFooterLeft-overflow', 'visible', 'visible', '', 44, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(674, 1, 'pos-mainFooterLeft-visibility', 'visible', 'visible', '', 44, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(675, 1, 'pos-mainFooterLeft-text-align', 'left', 'left', '', 44, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(676, 1, 'pos-mainFooterLeft-enabled', '1', '0', '', 44, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINFOOTERLEFT_HEADING', 'TPL_POS_MAINFOOTERLEFT_SUBTEXT'),
(677, 1, 'pos-mainFooterLeft-bg-gradient-longValue', '', '', '', 44, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(678, 1, 'pos-mainFooterLeft-zindex', '9999', '9999', '', 44, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(679, 1, 'pos-mainFooterLeft-width', '100%', '100%', '', 44, 0, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(680, 1, 'pos-mainFooterLeft-height', 'auto', 'auto', '', 44, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(681, 1, 'pos-mainFooterLeft-bgcolor', 'F8F8F8', 'F8F8F8', '', 44, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(682, 1, 'pos-mainFooterLeft-position', 'static', 'static', '', 44, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(683, 1, 'pos-mainFooterLeft-marginBottom', '0px', '0px', '', 44, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(684, 1, 'pos-mainFooterLeft-marginTop', '0px', '0px', '', 44, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(685, 1, 'pos-mainFooterCenter-indicator', '1', '0', '', 45, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(686, 1, 'pos-mainFooterCenter-vertical-align', 'baseline', 'baseline', '', 45, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(687, 1, 'pos-mainFooterCenter-customCSS-longValue', '', '', '', 45, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(688, 1, 'pos-mainFooterCenter-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 45, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(689, 1, 'pos-mainFooterCenter-box-shadow-color', '888888', '888888', '', 45, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(690, 1, 'pos-mainFooterCenter-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 45, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(691, 1, 'pos-mainFooterCenter-border-style', 'none', 'solid', '', 45, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(692, 1, 'pos-mainFooterCenter-border-color', '888888', '888888', '', 45, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(693, 1, 'pos-mainFooterCenter-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 45, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(694, 1, 'pos-mainFooterCenter-padding', '0px', '0px', '', 45, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(695, 1, 'pos-mainFooterCenter-overflow', 'visible', 'visible', '', 45, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(696, 1, 'pos-mainFooterCenter-visibility', 'visible', 'visible', '', 45, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(697, 1, 'pos-mainFooterCenter-text-align', 'left', 'left', '', 45, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(698, 1, 'pos-mainFooterCenter-enabled', '1', '0', '', 45, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINFOOTERCENTER_HEADING', 'TPL_POS_MAINFOOTERCENTER_SUBTEXT'),
(699, 1, 'pos-mainFooterCenter-bg-gradient-longValue', '', '', '', 45, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(700, 1, 'pos-mainFooterCenter-zindex', '9999', '9999', '', 45, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(701, 1, 'pos-mainFooterCenter-width', '100%', '100%', '', 45, 0, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(702, 1, 'pos-mainFooterCenter-height', 'auto', 'auto', '', 45, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(703, 1, 'pos-mainFooterCenter-bgcolor', 'F8F8F8', 'F8F8F8', '', 45, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(704, 1, 'pos-mainFooterCenter-position', 'static', 'static', '', 45, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(705, 1, 'pos-mainFooterCenter-marginBottom', '0px', '0px', '', 45, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(706, 1, 'pos-mainFooterCenter-marginTop', '0px', '0px', '', 45, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(707, 1, 'pos-mainFooterRight-indicator', '1', '0', '', 46, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(708, 1, 'pos-mainFooterRight-vertical-align', 'baseline', 'baseline', '', 46, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(709, 1, 'pos-mainFooterRight-customCSS-longValue', '', '', '', 46, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(710, 1, 'pos-mainFooterRight-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 46, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(711, 1, 'pos-mainFooterRight-box-shadow-color', '888888', '888888', '', 46, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(712, 1, 'pos-mainFooterRight-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 46, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(713, 1, 'pos-mainFooterRight-border-style', 'none', 'solid', '', 46, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(714, 1, 'pos-mainFooterRight-border-color', '888888', '888888', '', 46, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(715, 1, 'pos-mainFooterRight-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 46, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(716, 1, 'pos-mainFooterRight-padding', '0px', '0px', '', 46, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(717, 1, 'pos-mainFooterRight-overflow', 'visible', 'visible', '', 46, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(718, 1, 'pos-mainFooterRight-visibility', 'visible', 'visible', '', 46, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(719, 1, 'pos-mainFooterRight-text-align', 'left', 'left', '', 46, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(720, 1, 'pos-mainFooterRight-enabled', '1', '0', '', 46, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_MAINFOOTERRIGHT_HEADING', 'TPL_POS_MAINFOOTERRIGHT_SUBTEXT'),
(721, 1, 'pos-mainFooterRight-bg-gradient-longValue', '', '', '', 46, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(722, 1, 'pos-mainFooterRight-zindex', '9999', '9999', '', 46, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(723, 1, 'pos-mainFooterRight-width', '100%', '100%', '', 46, 0, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(724, 1, 'pos-mainFooterRight-height', 'auto', 'auto', '', 46, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(725, 1, 'pos-mainFooterRight-bgcolor', 'F8F8F8', 'F8F8F8', '', 46, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(726, 1, 'pos-mainFooterRight-position', 'static', 'static', '', 46, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(727, 1, 'pos-mainFooterRight-marginBottom', '0px', '0px', '', 46, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(728, 1, 'pos-mainFooterRight-marginTop', '0px', '0px', '', 46, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(729, 1, 'pos-footer-indicator', '1', '0', '', 47, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(730, 1, 'pos-footer-vertical-align', 'baseline', 'baseline', '', 47, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(731, 1, 'pos-footer-customCSS-longValue', '', '', '', 47, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(732, 1, 'pos-footer-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 47, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(733, 1, 'pos-footer-box-shadow-color', '888888', '888888', '', 47, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(734, 1, 'pos-footer-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 47, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(735, 1, 'pos-footer-border-style', 'none', 'solid', '', 47, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(736, 1, 'pos-footer-border-color', '888888', '888888', '', 47, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(737, 1, 'pos-footer-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 47, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(738, 1, 'pos-footer-padding', '0px', '0px', '', 47, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(739, 1, 'pos-footer-overflow', 'visible', 'visible', '', 47, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(740, 1, 'pos-footer-visibility', 'visible', 'visible', '', 47, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(741, 1, 'pos-footer-text-align', 'left', 'left', '', 47, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(742, 1, 'pos-footer-enabled', '1', '0', '', 47, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_FOOTER_HEADING', 'TPL_POS_FOOTER_SUBTEXT'),
(743, 1, 'pos-footer-bg-gradient-longValue', '', '', '', 47, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(744, 1, 'pos-footer-zindex', '9999', '9999', '', 47, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(745, 1, 'pos-footer-width', '100%', '100%', '', 47, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(746, 1, 'pos-footer-height', 'auto', 'auto', '', 47, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(747, 1, 'pos-footer-bgcolor', 'F8F8F8', 'F8F8F8', '', 47, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(748, 1, 'pos-footer-position', 'static', 'static', '', 47, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(749, 1, 'pos-footer-marginBottom', '0px', '0px', '', 47, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(750, 1, 'pos-footer-marginTop', '0px', '0px', '', 47, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(751, 1, 'pos-hiddenToolbar-indicator', '1', '0', '', 48, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(752, 1, 'pos-hiddenToolbar-vertical-align', 'baseline', 'baseline', '', 48, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(753, 1, 'pos-hiddenToolbar-customCSS-longValue', '', '', '', 48, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(754, 1, 'pos-hiddenToolbar-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 48, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(755, 1, 'pos-hiddenToolbar-box-shadow-color', '888888', '888888', '', 48, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(756, 1, 'pos-hiddenToolbar-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 48, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(757, 1, 'pos-hiddenToolbar-border-style', 'none', 'solid', '', 48, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(758, 1, 'pos-hiddenToolbar-border-color', '888888', '888888', '', 48, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(759, 1, 'pos-hiddenToolbar-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 48, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(760, 1, 'pos-hiddenToolbar-padding', '0px', '0px', '', 48, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(761, 1, 'pos-hiddenToolbar-overflow', 'visible', 'visible', '', 48, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(762, 1, 'pos-hiddenToolbar-visibility', 'visible', 'visible', '', 48, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(763, 1, 'pos-hiddenToolbar-text-align', 'left', 'left', '', 48, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(764, 1, 'pos-hiddenToolbar-enabled', '1', '0', '', 48, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_HIDDENTOOLBAR_HEADING', 'TPL_POS_HIDDENTOOLBAR_SUBTEXT'),
(765, 1, 'pos-hiddenToolbar-bg-gradient-longValue', '', '', '', 48, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(766, 1, 'pos-hiddenToolbar-zindex', '9999', '9999', '', 48, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(767, 1, 'pos-hiddenToolbar-width', '100%', '100%', '', 48, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(768, 1, 'pos-hiddenToolbar-height', 'auto', 'auto', '', 48, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(769, 1, 'pos-hiddenToolbar-bgcolor', 'F8F8F8', 'F8F8F8', '', 48, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(770, 1, 'pos-hiddenToolbar-position', 'static', 'static', '', 48, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(771, 1, 'pos-hiddenToolbar-marginBottom', '0px', '0px', '', 48, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(772, 1, 'pos-hiddenToolbar-marginTop', '0px', '0px', '', 48, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(773, 1, 'pos-debug-indicator', '1', '0', '', 49, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(774, 1, 'pos-debug-vertical-align', 'baseline', 'baseline', '', 49, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(775, 1, 'pos-debug-customCSS-longValue', '', '', '', 49, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(776, 1, 'pos-debug-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 49, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(777, 1, 'pos-debug-box-shadow-color', '888888', '888888', '', 49, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(778, 1, 'pos-debug-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 49, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(779, 1, 'pos-debug-border-style', 'none', 'solid', '', 49, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(780, 1, 'pos-debug-border-color', '888888', '888888', '', 49, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(781, 1, 'pos-debug-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 49, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(782, 1, 'pos-debug-padding', '0px', '0px', '', 49, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(783, 1, 'pos-debug-overflow', 'visible', 'visible', '', 49, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(784, 1, 'pos-debug-visibility', 'visible', 'visible', '', 49, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(785, 1, 'pos-debug-text-align', 'left', 'left', '', 49, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(786, 1, 'pos-debug-enabled', '1', '0', '', 49, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_DEBUG_HEADING', 'TPL_POS_DEBUG_SUBTEXT'),
(787, 1, 'pos-debug-bg-gradient-longValue', '', '', '', 49, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(788, 1, 'pos-debug-zindex', '9999', '9999', '', 49, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(789, 1, 'pos-debug-width', '100%', '100%', '', 49, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(790, 1, 'pos-debug-height', 'auto', 'auto', '', 49, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(791, 1, 'pos-debug-bgcolor', 'F8F8F8', 'F8F8F8', '', 49, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(792, 1, 'pos-debug-position', 'static', 'static', '', 49, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(793, 1, 'pos-debug-marginBottom', '0px', '0px', '', 49, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(794, 1, 'pos-debug-marginTop', '0px', '0px', '', 49, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(795, 1, 'pos-outerBottom-indicator', '1', '0', '', 50, 1, 28, 'TPL_POS_INDICATOR', 'form-control', 'checkbox toggle', '', '', '', '', '', ''),
(796, 1, 'pos-outerBottom-vertical-align', 'baseline', 'baseline', '', 50, 1, 6, 'TPL_VERTICAL_ALIGN', 'form-control', 'select', 'baseline,baseline:sub,subscript:super,superscript:top,top:text-top,text-top:middle,middle:bottom,bottom:text-bottom,text-bottom:initial,initial:inherit,inherit', '', '', '', '', ''),
(797, 1, 'pos-outerBottom-customCSS-longValue', '', '', '', 50, 1, 27, 'TPL_CUSTOM_CSS', 'form-control', 'textarea', '', '', '', '', '', ''),
(798, 1, 'pos-outerBottom-border-radius', '0 0 0 0', '12px 12px 12px 12px', '', 50, 1, 17, 'TPL_BORDER_RADIUS', 'form-control', '', '', 'TPL_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(799, 1, 'pos-outerBottom-box-shadow-color', '888888', '888888', '', 50, 1, 19, 'TPL_BOX_SHADOW_COLOR', 'form-control color', '', '', '', '', '', '', ''),
(800, 1, 'pos-outerBottom-box-shadow-width', '6px 6px 25px -8px', '6px 6px 25px -8px', '', 50, 1, 18, 'TPL_BOX_SHADOW', 'form-control', '', '', 'TPL_BOX_SHADOW_PLACEHOLDER', '', '', 'TPL_BOX_SHADOW_HEADING', 'TPL_BOX_SHADOW_SUBTEXT'),
(801, 1, 'pos-outerBottom-border-style', 'none', 'solid', '', 50, 1, 15, 'TPL_BORDER_STYLE', 'form-control', 'select', 'none,none:hidden,hidden:dotted,dotted:dashed,dashed:solid,solid:double,double:groove,groove:ridge,ridge:inset,inset:outset,outset:initial,initial:inherit,inherit', '', '', '', '', ''),
(802, 1, 'pos-outerBottom-border-color', '888888', '888888', '', 50, 1, 16, 'TPL_BORDER_COLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(803, 1, 'pos-outerBottom-border-width', '1px 1px 1px 1px', '1px 1px 1px 1px', '', 50, 1, 14, 'TPL_BORDER_WIDTH', 'form-control', '', '', 'TPL_BORDER_WIDTH_PLACEHOLDER', '', '', 'TPL_BORDER_HEADING', 'TPL_BORDER_SUBTEXT'),
(804, 1, 'pos-outerBottom-padding', '0px', '0px', '', 50, 1, 23, 'TPL_PADDING', 'form-control', '', '', 'TPL_PADDING_PLACEHOLDER', '', '', '', ''),
(805, 1, 'pos-outerBottom-overflow', 'visible', 'visible', '', 50, 1, 24, 'TPL_OVERFLOW', 'form-control', 'select', 'visible,visible:hidden,hidden:scroll,scroll:auto,auto:initial,initial:inherit,inherit', '', '', '', 'TPL_OVERFLOW_HEADING', 'TPL_OVERFLOW_SUBTEXT'),
(806, 1, 'pos-outerBottom-visibility', 'visible', 'visible', '', 50, 1, 26, 'TPL_VISIBILITY', 'form-control', 'select', 'visible,visible:hidden,hidden', '', '', '', '', ''),
(807, 1, 'pos-outerBottom-text-align', 'left', 'left', '', 50, 1, 5, 'TPL_TEXT_ALIGN', 'form-control', 'select', 'left,left:center,center:right,right:justify,justify:initial,initial:inherit,inherit', '', '', '', 'TPL_ALIGN_HEADING', 'TPL_ALIGN_SUBTEXT'),
(808, 1, 'pos-outerBottom-enabled', '1', '0', '', 50, 1, 1, 'TPL_POS_ACTIVE', 'form-control', 'checkbox toggle', '', '', '', '', 'TPL_POS_OUTERBOTTOM_HEADING', 'TPL_POS_OUTERBOTTOM_SUBTEXT'),
(809, 1, 'pos-outerBottom-bg-gradient-longValue', '', '', '', 50, 1, 13, 'TPL_POS_BG_GRADIENT', 'form-control', 'textarea', '', '', '', '', '', ''),
(810, 1, 'pos-outerBottom-zindex', '9999', '9999', '', 50, 1, 25, 'TPL_POS_ZINDEX', 'form-control', '', '', 'TPL_ZINDEX_PLACEHOLDER', '', '', '', ''),
(811, 1, 'pos-outerBottom-width', '100%', '100%', '', 50, 1, 4, 'TPL_POS_WIDTH', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(812, 1, 'pos-outerBottom-height', 'auto', 'auto', '', 50, 1, 3, 'TPL_POS_HEIGHT', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', 'TPL_SIZE_HEADING', 'TPL_SIZE_SUBTEXT'),
(813, 1, 'pos-outerBottom-bgcolor', 'F8F8F8', 'F8F8F8', '', 50, 1, 7, 'TPL_POS_BGCOLOR', 'form-control color', '', '', 'TPL_COLOR_PLACEHOLDER', '', '', 'TPL_BG_HEADING', 'TPL_BG_SUBTEXT'),
(814, 1, 'pos-outerBottom-position', 'static', 'static', '', 50, 1, 20, 'TPL_POS_POSITION', 'form-control', 'select', 'static,static:relative,relative:fixed,fixed:absolute,absolute', '', '', '', 'TPL_POSITION_HEADING', 'TPL_POSITION_SUBTEXT'),
(815, 1, 'pos-outerBottom-marginBottom', '0px', '0px', '', 50, 1, 22, 'TPL_POS_MARGIN_BOTTOM', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(816, 1, 'pos-outerBottom-marginTop', '0px', '0px', '', 50, 1, 21, 'TPL_POS_MARGIN_TOP', 'form-control', '', '', 'TPL_MARGIN_PLACEHOLDER', '', '', '', ''),
(817, 1, 'navbar-marginBottom', '0px', '0px', '', 13, 1, 2, 'TPL_MENU_NAVBAR_MARGIN_BOTTOM', 'form-control', '', '', 'margin in em or px eg 20px or 1.2em', '', '', '', ''),
(818, 1, 'pos-outerTop-bg-attachment', 'fixed', 'fixed', '', 26, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(819, 1, 'pos-outerTop-bg-image', '', 'any .jpg or .png you want', '', 26, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(820, 1, 'pos-outerTop-bg-position', 'center', 'center', '', 26, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(821, 1, 'pos-outerTop-bg-repeat', 'no-repeat', 'no-repeat', '', 26, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(822, 1, 'pos-outerTop-bg-size', 'cover', 'cover', '', 26, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(823, 1, 'pos-intro-bg-image', '', 'any .jpg or .png you want', '', 27, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(824, 1, 'pos-intro-bg-attachment', 'fixed', 'fixed', '', 27, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(825, 1, 'pos-intro-bg-position', 'center', 'center', '', 27, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(826, 1, 'pos-intro-bg-repeat', 'no-repeat', 'no-repeat', '', 27, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(827, 1, 'pos-intro-bg-size', 'cover', 'cover', '', 27, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(828, 1, 'pos-globalmenu-bg-image', '', 'any .jpg or .png you want', '', 28, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(829, 1, 'pos-globalmenu-bg-attachment', 'fixed', 'fixed', '', 28, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(830, 1, 'pos-globalmenu-bg-position', 'center', 'center', '', 28, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(831, 1, 'pos-globalmenu-bg-repeat', 'no-repeat', 'no-repeat', '', 28, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(832, 1, 'pos-globalmenu-bg-size', 'cover', 'cover', '', 28, 1, 13, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(833, 1, 'pos-top-bg-image', '', 'any .jpg or .png you want', '', 29, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(834, 1, 'pos-top-bg-attachment', 'fixed', 'fixed', '', 29, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(835, 1, 'pos-top-bg-position', 'center', 'center', '', 29, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(836, 1, 'pos-top-bg-repeat', 'no-repeat', 'no-repeat', '', 29, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(837, 1, 'pos-top-bg-size', 'cover', 'cover', '', 29, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(838, 1, 'pos-outerLeft-bg-image', '', 'any .jpg or .png you want', '', 30, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(839, 1, 'pos-outerLeft-bg-attachment', 'fixed', 'fixed', '', 30, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(840, 1, 'pos-outerLeft-bg-position', 'center', 'center', '', 30, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(841, 1, 'pos-outerLeft-bg-repeat', 'no-repeat', 'no-repeat', '', 30, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(842, 1, 'pos-outerLeft-bg-size', 'cover', 'cover', '', 30, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(843, 1, 'pos-outerRight-bg-image', '', 'any .jpg or .png you want', '', 31, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(844, 1, 'pos-outerRight-bg-attachment', 'fixed', 'fixed', '', 31, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(845, 1, 'pos-outerRight-bg-position', 'center', 'center', '', 31, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(846, 1, 'pos-outerRight-bg-repeat', 'no-repeat', 'no-repeat', '', 31, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(847, 1, 'pos-outerRight-bg-size', 'cover', 'cover', '', 31, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(848, 1, 'pos-leftMenu-bg-image', '', 'any .jpg or .png you want', '', 32, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(849, 1, 'pos-leftMenu-bg-attachment', 'fixed', 'fixed', '', 32, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(850, 1, 'pos-leftMenu-bg-position', 'center', 'center', '', 32, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(851, 1, 'pos-leftMenu-bg-repeat', 'no-repeat', 'no-repeat', '', 32, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(852, 1, 'pos-leftMenu-bg-size', 'cover', 'cover', '', 32, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(853, 1, 'pos-rightMenu-bg-image', '', 'any .jpg or .png you want', '', 33, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(854, 1, 'pos-rightMenu-bg-attachment', 'fixed', 'fixed', '', 33, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(855, 1, 'pos-rightMenu-bg-position', 'center', 'center', '', 33, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(856, 1, 'pos-rightMenu-bg-repeat', 'no-repeat', 'no-repeat', '', 33, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(857, 1, 'pos-rightMenu-bg-size', 'cover', 'cover', '', 33, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(858, 1, 'pos-mainTop-bg-image', '', 'any .jpg or .png you want', '', 34, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(859, 1, 'pos-mainTop-bg-attachment', 'fixed', 'fixed', '', 34, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(860, 1, 'pos-mainTop-bg-position', 'center', 'center', '', 34, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(861, 1, 'pos-mainTop-bg-repeat', 'no-repeat', 'no-repeat', '', 34, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(862, 1, 'pos-mainTop-bg-size', 'cover', 'cover', '', 34, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(863, 1, 'pos-mainTopLeft-bg-image', '', 'any .jpg or .png you want', '', 35, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(864, 1, 'pos-mainTopLeft-bg-attachment', 'fixed', 'fixed', '', 35, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(865, 1, 'pos-mainTopLeft-bg-position', 'center', 'center', '', 35, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(866, 1, 'pos-mainTopLeft-bg-repeat', 'no-repeat', 'no-repeat', '', 35, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(867, 1, 'pos-mainTopLeft-bg-size', 'cover', 'cover', '', 35, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(868, 1, 'pos-mainTopCenter-bg-image', '', 'any .jpg or .png you want', '', 36, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(869, 1, 'pos-mainTopCenter-bg-attachment', 'fixed', 'fixed', '', 36, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(870, 1, 'pos-mainTopCenter-bg-position', 'center', 'center', '', 36, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(871, 1, 'pos-mainTopCenter-bg-repeat', 'no-repeat', 'no-repeat', '', 36, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(872, 1, 'pos-mainTopCenter-bg-size', 'cover', 'cover', '', 36, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(873, 1, 'pos-mainTopRight-bg-image', '', 'any .jpg or .png you want', '', 37, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(874, 1, 'pos-mainTopRight-bg-attachment', 'fixed', 'fixed', '', 37, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(875, 1, 'pos-mainTopRight-bg-position', 'center', 'center', '', 37, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(876, 1, 'pos-mainTopRight-bg-repeat', 'no-repeat', 'no-repeat', '', 37, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(877, 1, 'pos-mainTopRight-bg-size', 'cover', 'cover', '', 37, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(878, 1, 'pos-main-bg-image', '', 'any .jpg or .png you want', '', 38, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(879, 1, 'pos-main-bg-attachment', 'fixed', 'fixed', '', 38, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(880, 1, 'pos-main-bg-position', 'center', 'center', '', 38, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(881, 1, 'pos-main-bg-repeat', 'no-repeat', 'no-repeat', '', 38, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(882, 1, 'pos-main-bg-size', 'cover', 'cover', '', 38, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(883, 1, 'pos-mainBottom-bg-image', '', 'any .jpg or .png you want', '', 39, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(884, 1, 'pos-mainBottom-bg-attachment', 'fixed', 'fixed', '', 39, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(885, 1, 'pos-mainBottom-bg-position', 'center', 'center', '', 39, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(886, 1, 'pos-mainBottom-bg-repeat', 'no-repeat', 'no-repeat', '', 39, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(887, 1, 'pos-mainBottom-bg-size', 'cover', 'cover', '', 39, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(888, 1, 'pos-mainBottomLeft-bg-image', '', 'any .jpg or .png you want', '', 40, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(889, 1, 'pos-mainBottomLeft-bg-attachment', 'fixed', 'fixed', '', 40, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', '');
INSERT INTO `cms_template_settings` (`id`, `templateID`, `property`, `value`, `valueDefault`, `longValue`, `type`, `activated`, `sort`, `label`, `fieldClass`, `fieldType`, `options`, `placeholder`, `description`, `icon`, `heading`, `subtext`) VALUES
(890, 1, 'pos-mainBottomLeft-bg-position', 'center', 'center', '', 40, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(891, 1, 'pos-mainBottomLeft-bg-repeat', 'no-repeat', 'no-repeat', '', 40, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(892, 1, 'pos-mainBottomLeft-bg-size', 'cover', 'cover', '', 40, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(893, 1, 'pos-mainBottomCenter-bg-image', '', 'any .jpg or .png you want', '', 41, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(894, 1, 'pos-mainBottomCenter-bg-attachment', 'fixed', 'fixed', '', 41, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(895, 1, 'pos-mainBottomCenter-bg-position', 'center', 'center', '', 41, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(896, 1, 'pos-mainBottomCenter-bg-repeat', 'no-repeat', 'no-repeat', '', 41, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(897, 1, 'pos-mainBottomCenter-bg-size', 'cover', 'cover', '', 41, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(898, 1, 'pos-mainBottomRight-bg-image', '', 'any .jpg or .png you want', '', 42, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(899, 1, 'pos-mainBottomRight-bg-attachment', 'fixed', 'fixed', '', 42, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(900, 1, 'pos-mainBottomRight-bg-position', 'center', 'center', '', 42, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(901, 1, 'pos-mainBottomRight-bg-repeat', 'no-repeat', 'no-repeat', '', 42, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(902, 1, 'pos-mainBottomRight-bg-size', 'cover', 'cover', '', 42, 1, 16, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(903, 1, 'pos-mainFooter-bg-image', '', 'any .jpg or .png you want', '', 43, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(904, 1, 'pos-mainFooter-bg-attachment', 'fixed', 'fixed', '', 43, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(905, 1, 'pos-mainFooter-bg-position', 'center', 'center', '', 43, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(906, 1, 'pos-mainFooter-bg-repeat', 'no-repeat', 'no-repeat', '', 43, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(907, 1, 'pos-mainFooter-bg-size', 'cover', 'cover', '', 43, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(908, 1, 'pos-mainFooterLeft-bg-image', '', 'any .jpg or .png you want', '', 44, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(909, 1, 'pos-mainFooterLeft-bg-attachment', 'fixed', 'fixed', '', 44, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(910, 1, 'pos-mainFooterLeft-bg-position', 'center', 'center', '', 44, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(911, 1, 'pos-mainFooterLeft-bg-repeat', 'no-repeat', 'no-repeat', '', 44, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(912, 1, 'pos-mainFooterLeft-bg-size', 'cover', 'cover', '', 44, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(913, 1, 'pos-mainFooterCenter-bg-image', '', 'any .jpg or .png you want', '', 45, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(914, 1, 'pos-mainFooterCenter-bg-attachment', 'fixed', 'fixed', '', 45, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(915, 1, 'pos-mainFooterCenter-bg-position', 'center', 'center', '', 45, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(916, 1, 'pos-mainFooterCenter-bg-repeat', 'no-repeat', 'no-repeat', '', 45, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(917, 1, 'pos-mainFooterCenter-bg-size', 'cover', 'cover', '', 45, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(918, 1, 'pos-mainFooterRight-bg-image', '', 'any .jpg or .png you want', '', 46, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(919, 1, 'pos-mainFooterRight-bg-attachment', 'fixed', 'fixed', '', 46, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(920, 1, 'pos-mainFooterRight-bg-position', 'center', 'center', '', 46, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(921, 1, 'pos-mainFooterRight-bg-repeat', 'no-repeat', 'no-repeat', '', 46, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(922, 1, 'pos-mainFooterRight-bg-size', 'cover', 'cover', '', 46, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(924, 1, 'pos-footer-bg-attachment', 'fixed', 'fixed', '', 47, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(925, 1, 'pos-footer-bg-position', 'center', 'center', '', 47, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(926, 1, 'pos-footer-bg-repeat', 'no-repeat', 'no-repeat', '', 47, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(927, 1, 'pos-footer-bg-size', 'cover', 'cover', '', 47, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(928, 1, 'pos-footer-bg-image', '', 'any .jpg or .png you want', '', 47, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(933, 1, 'pos-hiddenToolbar-bg-image', '', 'any .jpg or .png you want', '', 48, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(934, 1, 'pos-hiddenToolbar-bg-attachment', 'fixed', 'fixed', '', 48, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(935, 1, 'pos-hiddenToolbar-bg-position', 'center', 'center', '', 48, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(936, 1, 'pos-hiddenToolbar-bg-repeat', 'no-repeat', 'no-repeat', '', 48, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(937, 1, 'pos-hiddenToolbar-bg-size', 'cover', 'cover', '', 48, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(938, 1, 'pos-debug-bg-image', '', 'any .jpg or .png you want', '', 49, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(939, 1, 'pos-debug-bg-attachment', 'fixed', 'fixed', '', 49, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(940, 1, 'pos-debug-bg-position', 'center', 'center', '', 49, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(941, 1, 'pos-debug-bg-repeat', 'no-repeat', 'no-repeat', '', 49, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(942, 1, 'pos-debug-bg-size', 'cover', 'cover', '', 49, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(943, 1, 'pos-outerBottom-bg-image', '', 'any .jpg or .png you want', '', 50, 1, 8, 'TPL_BODY_BG_IMAGE', 'form-control', '', '', 'TPL_BODY_BG_IMAGE_PLACEHOLDER', '', '', '', ''),
(944, 1, 'pos-outerBottom-bg-attachment', 'fixed', 'fixed', '', 50, 1, 9, 'TPL_BODY_BG_IMAGE_ATTACH', 'form-control', 'select', 'scroll,scroll:fixed,fixed:local,local:initial,inital:inherit,inherit', '', '', '', '', ''),
(945, 1, 'pos-outerBottom-bg-position', 'center', 'center', '', 50, 1, 10, 'TPL_BODY_BG_IMAGE_POSITION', 'form-control', 'select', 'left-center,left-center:right-center,right-center:top-center,top-center:top,top:bottom,bottom', '', '', '', '', ''),
(946, 1, 'pos-outerBottom-bg-repeat', 'no-repeat', 'no-repeat', '', 50, 1, 11, 'TPL_BODY_BG_IMAGE_REPEAT', 'form-control', 'select', 'no-repeat,no-repeat:repeat-x,repeat-x:repeat-y,repeat-y:inherit,inherit', '', '', '', '', ''),
(947, 1, 'pos-outerBottom-bg-size', 'cover', 'cover', '', 50, 1, 12, 'TPL_BODY_BG_IMAGE_SIZE', 'form-control', 'select', 'auto,auto:cover,cover:contain,contain:length,length:percentage,percentage:initial,inital:inherit,inherit', '', '', '', '', ''),
(948, 1, 'form-display', 'block', 'block', '', 25, 1, 1, 'TPL_FORM_DISPLAY_LABEL', 'form-control', 'select', 'block,block:inline,inline:inline-block,inline-block:flex,flex', '', '', '', '', ''),
(949, 1, 'form-width', '100%', '100%', '', 25, 1, 2, 'TPL_FORM_WIDTH_LABEL', 'form-control', '', '', 'TPL_WIDTH_PLACEHOLDER', '', '', '', ''),
(950, 1, 'form-height', '34px', '34px', '', 25, 1, 3, 'TPL_FORM_HEIGHT_LABEL', 'form-control', '', '', 'TPL_HEIGHT_PLACEHOLDER', '', '', '', ''),
(951, 1, 'form-padding', '6px 12px', '6px 12px', '', 25, 1, 4, 'TPL_FORM_PADDING_LABEL', 'form-control', '', '', 'TPL_FORM_PADDING_PLACEHOLDER', '', '', '', ''),
(952, 1, 'form-textSize', '14px', '14px', '', 25, 1, 5, 'TPL_FORM_TEXTSIZE_LABEL', 'form-control', '', '', 'TPL_FORM_TEXTSIZE_PLACEHOLDER', '', '', '', ''),
(953, 1, 'form-lineHeight', '1.42857143', '1.42857143', '', 25, 1, 6, 'TPL_FORM_LINEHEIGHT_LABEL', 'form-control', '', '', 'TPL_FORM_LINEHEIGHT_PLACEHOLDER', '', '', '', ''),
(954, 1, 'form-textColor', '555555', '#555555', '', 51, 1, 1, 'TPL_FORM_TEXTCOLOR_LABEL', 'form-control color', 'color', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(955, 1, 'form-bgcolor', 'FFFFFF', '#fff', '', 51, 1, 2, 'TPL_FORM_BGCOLOR_LABEL', 'form-control color', 'color', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(956, 1, 'form-border', '1px solid #ccc', '1px solid #ccc', '', 51, 1, 3, 'TPL_FORM_BORDER_LABEL', 'form-control', '', '', 'TPL_FORM_BORDER_PLACEHOLDER', '', '', '', ''),
(957, 1, 'form-border-radius', '4px', '4px', '', 51, 1, 4, 'TPL_FORM_BORDER_RADIUS_LABEL', 'form-control', '', '', 'TPL_FORM_BORDER_RADIUS_PLACEHOLDER', '', '', '', ''),
(958, 1, 'form-activeBorderColor', '66AFE9', '#66afe9', '', 51, 1, 5, 'TPL_FORM_ACTIVE_BORDERCOLOR_LABEL', 'form-control color', 'color', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', ''),
(959, 1, 'form-placeholderColor', '999999', '#999', '', 51, 1, 6, 'TPL_FORM_PLACEHOLDERCOLOR_LABEL', 'form-control color', 'color', '', 'TPL_COLOR_PLACEHOLDER', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_template_settings_types`
--

CREATE TABLE `cms_template_settings_types` (
  `id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `cms_template_settings_types`
--

INSERT INTO `cms_template_settings_types` (`id`, `type`) VALUES
(1, 'positions'),
(2, 'text-common'),
(3, 'link-colors'),
(4, 'h-size'),
(5, 'font-colors'),
(6, 'body-bgcolor'),
(7, 'body-margin'),
(8, 'body-bg-image'),
(9, 'main-shadow'),
(10, 'font-menucolor'),
(11, 'menubgcolor'),
(12, 'menudropdowncolor'),
(13, 'navbar-margintop'),
(14, 'well'),
(15, 'listgroup'),
(16, 'jumbotron'),
(17, 'button'),
(18, 'btn-default'),
(19, 'btn-primary'),
(20, 'btn-success'),
(21, 'btn-warning'),
(22, 'btn-danger'),
(23, 'btn-info'),
(24, 'image'),
(25, 'forms'),
(26, 'pos-outerTop'),
(27, 'pos-intro'),
(28, 'pos-globalmenu'),
(29, 'pos-top'),
(30, 'pos-outerLeft'),
(31, 'pos-outerRight'),
(32, 'pos-leftMenu'),
(33, 'pos-rightMenu'),
(34, 'pos-mainTop'),
(35, 'pos-mainTopLeft'),
(36, 'pos-mainTopCenter'),
(37, 'pos-mainTopRight'),
(38, 'pos-main'),
(39, 'pos-mainBottom'),
(40, 'pos-mainBottomLeft'),
(41, 'pos-mainBottomCenter'),
(42, 'pos-mainBottomRight'),
(43, 'pos-mainFooter'),
(44, 'pos-mainFooterLeft'),
(45, 'pos-mainFooterCenter'),
(46, 'pos-mainFooterRight'),
(47, 'pos-footer'),
(48, 'pos-hiddenToolbar'),
(49, 'pos-debug'),
(50, 'pos-outerBottom'),
(51, 'forms-extended');

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
('youtubeDescription', '', 16, 1, 'Description under the video', 'form-control', 43),
('chaturbateRoom', 'disneydeee', 17, 1, 'Chaturbate Room (nickname)', 'form-control', 44),
('chaturbateDisableSound', '1', 17, 1, 'Disable Sound? (0 | 1)', 'form-control', 45),
('chaturbateVideoOnly', '0', 17, 1, 'Video Only? (0 | 1)', 'form-control', 46),
('chaturbateHeight', '850', 17, 1, 'Video height in px', 'form-control', 47),
('chaturbateWidth', '100%', 17, 1, 'Video width in px', 'form-control', 48),
('chaturbateHeading', 'Watch me', 17, 1, 'Heading above the video', 'form-control', 49),
('chaturbateSubtext', 'being nasty', 17, 1, 'Subtext beneath heading', 'form-control', 50),
('googleMapsEmbedHtmlCode', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d85064.65940758218!2d16.310020639299537!3d48.22066363084218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476d079e5136ca9f%3A0xfdc2e58a51a25b46!2sWien%2C+%C3%96sterreich!5e0!3m2!1sde!2sde!4v1491406650968" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>', 18, 1, 'HTML Code you get from GoogleMaps (iframe...)', 'form-control', 51),
('cbaUrl', 'https://cba.fro.at/331756', 19, 1, 'URL of your CBA Stream', 'form-control', 52),
('cbaHeading', 'Heading', 19, 1, 'Heading before your stream', 'form-control', 53),
('cbaSubtext', 'Subtext', 19, 1, 'Small subtext beneath heading', 'form-control', 54),
('cbaHeight', '209', 19, 1, 'Height', 'form-control', 55),
('cbaWidth', '100%', 19, 1, 'Width', 'form-control', 56),
('cbaWaveform', '0', 19, 1, 'Display Waveform? 0|1', 'form-control', 57),
('cbaTitle', '0', 19, 1, 'Display Title? 0|1', 'form-control', 58),
('cbaSocialmedia', '0', 19, 1, 'Display Socialmedia Links? 0|1', 'form-control', 59),
('cbaPodcast', '0', 19, 1, 'Allow to subscribe? 0|1', 'form-control', 60),
('cbaSeries', '0', 19, 1, 'Link to series? 0|1', 'form-control', 61),
('cbaDescription', '0', 19, 1, 'Display Description? 0|1', 'form-control', 62),
('cbaMeta', '0', 19, 1, 'Display Meta Information? 0|1', 'form-control', 63),
('cbaEmbedCode', '', 19, 1, 'OR use embed code instead (iframe...)', 'form-control', 64),
('instagramUrl', 'https://www.instagram.com/p/BSqEReEgW4d/', 20, 1, 'URL of your Instagram Posting', 'form-control', 65),
('instagramWidth', '100%', 20, 1, 'Width in px or %', 'form-control', 66),
('instagramTarget', '_blank', 20, 1, 'Target of the link (_blank or _self)', 'form-control', 67),
('instagramHeading', '', 20, 1, 'Heading above the Posting', 'form-control', 68),
('instagramSubtext', '', 20, 1, 'Subtext beneath heading', 'form-control', 69),
('spotifyEmbedCode', '<iframe src="https://embed.spotify.com/?uri=spotify%3Atrack%3A30LDuVfrePWbedYTc1mUCn" width="300" height="380" frameborder="0" allowtransparency="true"></iframe>', 21, 1, 'Spotify Embed HTML Code', 'form-control', 70),
('spotifyWidth', '100%', 21, 1, 'Width in px or %', 'form-control', 71),
('spotifyHeight', '380', 21, 1, 'Height in px or %', 'form-control', 72),
('spotifyHeading', 'Heading', 21, 1, 'Heading above Widget', 'form-control', 73),
('spotifySubtext', 'Subtext', 21, 1, 'Subtext beneath heading', 'form-control', 74),
('fbPostEmbedCode', '<iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fzuck%2Fposts%2F10103625699665601&width=500" width="500" height="625" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>', 22, 1, 'Facebook Posting Embed HTML Code', 'form-control', 75),
('fbPostWidth', '100%', 22, 1, 'Width in px or %', 'form-control', 76),
('fbPostHeight', '625', 22, 1, 'Height in px', 'form-control', 77),
('fbPostHeading', 'Heading', 22, 1, 'Heading above Posting', 'form-control', 78),
('fbPostSubtext', 'Subtext', 22, 1, 'Subtext beneath Posting', 'form-control', 79),
('fbVideoEmbedCode', '<iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F10155656407651729%2F&show_text=0&width=560" width="560" height="315" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>', 23, 1, 'Facebook Video Embed HTML Code', 'form-control', 80),
('fbVideoWidth', '100%', 23, 1, 'Width in px or %', 'form-control', 81),
('fbVideoHeight', '700', 23, 1, 'Height in px', 'form-control', 82),
('fbVideoHeading', 'Heading', 23, 1, 'Heading above Video', 'form-control', 83),
('fbVideoSubtext', 'Subtext', 23, 1, 'Subtext beside Heading', 'form-control', 84),
('twitterTweetUrl', 'https://twitter.com/danielretzl/status/802569003172499456', 24, 1, 'URL (Link) to the Tweet you want to embed', 'form-control', 85),
('twitterHideDataCards', '0', 24, 1, 'Hide Images and Media? 0|1', 'form-control', 86),
('twitterDataConversation', '0', 24, 1, 'Display Conversation? 0|1', 'form-control', 87),
('twitterTweetHeading', 'Heading', 24, 1, 'Heading above Tweet', 'form-control', 88),
('twitterTweetSubtext', 'Subtext', 24, 1, 'Subtext beside Heading', 'form-control', 89),
('twitterTimelineUrl', 'https://twitter.com/danielretzl', 25, 1, 'URL (Link) to the Timeline you want to embed', 'form-control', 90),
('twitterTimelineHeading', 'Heading', 25, 1, 'Heading above Tweet', 'form-control', 91),
('twitterTimelineSubtext', 'Subtext', 25, 1, 'Subtext beside Heading', 'form-control', 92),
('twitterTimelineTweetLimit', '5', 25, 1, 'How many tweets to display?', 'form-control', 93),
('twitterGridUrl', 'https://twitter.com/TwitterDev/timelines/539487832448843776', 26, 1, 'URL (Link) to the Timeline you want to embed as grid', 'form-control', 94),
('twitterGridHeading', 'Heading', 26, 1, 'Heading above Timeline Grid', 'form-control', 95),
('twitterGridSubtext', 'Subtext', 26, 1, 'Subtext beside Heading', 'form-control', 96),
('twitterGridTweetLimit', '5', 26, 1, 'How many tweets to display?', 'form-control', 97),
('twitterTweetButtonText', 'Yet another WebKit - spread the word out lout! Sharing is caring!', 27, 1, 'pre-defined tweet text', 'form-control', 98),
('twitterTweetButtonHeading', 'Heading', 27, 1, 'Heading above Tweet Button', 'form-control', 99),
('twitterTweetButtonSubtext', 'Subtext', 27, 1, 'Subtext beside Heading', 'form-control', 100),
('pinterestProfileUrl', 'https://www.pinterest.com/pinterest', 28, 1, 'Pinterest Profile URL', 'form-control', 101),
('pinterestProfileWidth', '900', 28, 1, 'Width in px or %', 'form-control', 102),
('pinterestProfileHeight', '600', 28, 1, 'Height in px', 'form-control', 103),
('pinterestProfileHeading', 'Heading', 28, 1, 'Heading above Pinterest Profile', 'form-control', 104),
('pinterestProfileSubtext', 'Subtext', 28, 1, 'Subtext beside Heading', 'form-control', 105),
('pinterestPinUrl', 'https://www.pinterest.com/pin/99360735500167749/', 29, 1, 'Pinterest Pin URL', 'form-control', 106),
('pinterestPinSize', 'large', 29, 1, 'small, medium or large', 'form-control', 107),
('pinterestPinHideDescription', 'true', 29, 1, 'Hide description? true|false', 'form-control', 108),
('pinterestPinHeading', 'Heading', 29, 1, 'Heading above Pinterest Pin', 'form-control', 109),
('pinterestPinSubtext', 'Subtext', 29, 1, 'Subtext beside Heading', 'form-control', 110),
('pinterestFollowUrl', 'https://www.pinterest.com/pinterest/', 30, 1, 'Pinterest Follow URL', 'form-control', 111),
('pinterestFollowHeading', 'Heading', 30, 1, 'Heading above Pinterest Follow Button', 'form-control', 112),
('pinterestFollowSubtext', 'Subtext', 30, 1, 'Subtext beside Heading', 'form-control', 113),
('bubblusUrl', 'https://bubbl.us/NDAxNjg1Mi83OTM0MjA4LzJhMTViYjE0MDhmN2ZjNjgxZTA3Mjc3YjdjYWY4MDM2-X?s=7934208', 31, 1, 'Url to your Bubbl.us Mindmap', 'form-control', 114),
('bubblusWidth', '100%', 31, 1, 'Width in px or %', 'form-control', 115),
('bubblusHeight', '600', 31, 1, 'Height in px', 'form-control', 116),
('bubblusHeading', 'Heading', 31, 1, 'Heading above Bubbl.us Mindmap', 'form-control', 117),
('bubblusSubtext', 'Subtext', 31, 1, 'Subtext beside Heading', 'form-control', 118),
('jPlayerUserMediaFolder', 'demo', 32, 1, 'Any folder in media/audio/', 'form-control', 119),
('jPlayerWidth', '100%', 32, 1, 'Width in px or %', 'form-control', 120),
('jPlayerHeading', 'Heading', 32, 1, 'Heading above jPlayer', 'form-control', 121),
('jPlayerSubtext', 'Subtext', 32, 1, 'Subtext beside Heading', 'form-control', 122),
('jPlayerSkin', 'dark', 32, 1, 'Skin (dark | light)', 'form-control', 123),
('jPlayerRootMediaFolder', 'media/audio/', 32, 1, 'Path to media root folder', 'form-control', 124),
('jPlayerInstance', '1', 32, 1, 'Player Instance ID - if more than one player is loaded on the same page', 'form-control', 125),
('jPlayerDefaultVolume', '0.3', 32, 1, 'Initial Player Volume 0 to 1 (eg. 0.3)', 'form-control', 126),
('jPlayerInitialMute', 'false', 32, 1, 'Set mute on startup (true | false)', 'form-control', 127);

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
(1, 1, 'Loginbox', 'loginbox', 'Display a User Login Box'),
(2, 1, 'Simple Contact Form', 'form_simple', ''),
(3, 1, 'Prezi', 'prezi', ''),
(4, 1, 'FacebookPage', 'fb_page', ''),
(5, 1, 'FacebookLike', 'fb_like', ''),
(6, 1, 'GoogleAnalytics', 'google_analytics', 'Embed Google Analytics on your page'),
(7, 1, 'SimpleUpload', 'simple_upload', ''),
(8, 1, 'Clock', 'clock', 'A simple digital clock'),
(9, 1, 'Signup', 'signup', ''),
(10, 1, 'Divbox', 'divbox', ''),
(11, 1, 'News Blog Widget', 'news', ''),
(12, 1, 'Newsletter', 'newsletter', 'Newsletter Widget'),
(13, 1, 'Gallery', 'gallery', 'Display a gallery at any position'),
(14, 1, 'Twitch Stream', 'twitch', 'Embed any Twitch Stream'),
(15, 1, 'Sub Menu', 'submenu', 'Embed a Menu as Submenu at any position'),
(16, 1, 'Youtube Stream', 'youtube', 'Embed any YouTube Video'),
(17, 1, 'Chaturbate Stream', 'chaturbate', 'Embed any chaturbate cam room on your website'),
(18, 1, 'Google Maps', 'google_maps', 'Embed Google Maps on your website'),
(19, 1, 'Cultural Broadcasting Archive', 'culturalbroadcasting', 'CBA - Cultural Broadcasting Archive -\r\n Verband Freier Radios Österreich'),
(20, 1, 'Instagram Posting', 'instagram', 'Embed any single Instagram posting'),
(21, 1, 'Spotify', 'spotify', 'Embed a Spotify Stream'),
(22, 1, 'Facebook Posting', 'fb_post', 'Embed any public Facebook Posting'),
(23, 1, 'Facebook Video', 'fb_video', 'Embed any public Facebook Video'),
(24, 1, 'Twitter (Single Tweet)', 'twitter_tweet', 'Embed any single Tweet'),
(25, 1, 'Twitter (Timeline)', 'twitter_timeline', 'Embed the timeline of any Twitter User'),
(26, 1, 'Twitter (Grid)', 'twitter_grid', 'Embed a timeline link as grid'),
(27, 1, 'Twitter Button', 'twitter_tweetbutton', 'Embed a Tweet button to let users drop a tweet'),
(28, 1, 'Pinterest Profile', 'pinterest_profile', 'Embed any Pinterest Profile'),
(29, 1, 'Pinterest Pin', 'pinterest_pin', 'Embed any Pinterest Pin'),
(30, 1, 'Pinterest Follow', 'pinterest_profile', 'Embed a Pinterest Follow Button'),
(31, 1, 'Bubbl.us Mindmap', 'bubblus', 'Embed Bubbl.us Mindmap');

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
-- Indizes für die Tabelle `cms_template_settings_types`
--
ALTER TABLE `cms_template_settings_types`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_friends`
--
ALTER TABLE `cms_friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_logins`
--
ALTER TABLE `cms_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_menu`
--
ALTER TABLE `cms_menu`
  MODIFY `TMPID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `cms_meta_local`
--
ALTER TABLE `cms_meta_local`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_newsletter`
--
ALTER TABLE `cms_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT für Tabelle `cms_widget_defaults`
--
ALTER TABLE `cms_widget_defaults`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT für Tabelle `cms_widget_settings`
--
ALTER TABLE `cms_widget_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
