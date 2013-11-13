-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 09 Juillet 2013 à 05:04
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `myprojects_v2`
--

-- --------------------------------------------------------

--
-- Structure de la table `mp_arbo`
--

CREATE TABLE IF NOT EXISTS `mp_arbo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_src` int(11) NOT NULL,
  `id_dest` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `mp_arbo`
--

INSERT INTO `mp_arbo` (`id`, `id_src`, `id_dest`) VALUES
(1, 4, 5),
(2, 5, 7),
(3, 4, 6),
(5, 2, 4),
(6, 3, 4),
(7, 8, 9),
(8, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `mp_conteneurs`
--

CREATE TABLE IF NOT EXISTS `mp_conteneurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `pub_date` varchar(255) NOT NULL,
  `pub_autor` varchar(255) NOT NULL,
  `edit_date` varchar(255) NOT NULL,
  `edit_autor` varchar(255) NOT NULL,
  `type` enum('note','projet') NOT NULL,
  `id_right_level` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `mp_conteneurs`
--

INSERT INTO `mp_conteneurs` (`id`, `titre`, `description`, `pub_date`, `pub_autor`, `edit_date`, `edit_autor`, `type`, `id_right_level`) VALUES
(1, 'Titre de la 1ere note', 'Description de la 1ere note', '2013/06/27', 'Clem', '', '', 'note', 1),
(2, 'Titre de la 2eme note', 'Descritpion 2eme note', '2013/06/27', 'Clem', '', '', 'note', 1),
(3, 'Titre de la 3eme note', 'Descritpion 3eme note', '2013/06/27', 'Clem', '', '', 'note', 1),
(4, 'Titre du 1er Projet', 'Titre du 1er Projet', '2013/06/27', 'Clem', '', '', 'projet', 1),
(5, 'Titre du 2eme Projet', 'Titre du 2eme Projet', '2013/06/27', 'Clem', '', '', 'projet', 2),
(6, 'Titre du 3eme Projet', 'Titre du 3eme Projet', '2013/06/27', 'Clem', '', '', 'projet', 2),
(7, 'titre 4', 'sdsdf', '2013/07/01', 'Clem', '', '', 'projet', 3),
(8, 'titre 4', 'qsdgfqSDF', '2013/07/01', 'cLEM', '', '', 'projet', 1),
(9, 'Titre 5', 'sdf', '2013/07/01', 'Clem', '', '', 'projet', 1),
(10, 'Titre 6', 'wscfgsdfg', '2013/07/01', 'Clem', '', '', 'projet', 1);

-- --------------------------------------------------------

--
-- Structure de la table `mp_group_access`
--

CREATE TABLE IF NOT EXISTS `mp_group_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `right_level` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `access_note` tinyint(1) NOT NULL DEFAULT '1',
  `arbo_access_rights` int(11) NOT NULL DEFAULT '1',
  `note_add` tinyint(1) NOT NULL DEFAULT '0',
  `note_edit_own` tinyint(1) NOT NULL DEFAULT '0',
  `note_edit_all` tinyint(1) NOT NULL DEFAULT '0',
  `note_suppr_own` tinyint(1) NOT NULL DEFAULT '0',
  `note_suppr_all` tinyint(1) NOT NULL DEFAULT '0',
  `com_add` tinyint(1) NOT NULL DEFAULT '0',
  `com_edit_own` tinyint(1) NOT NULL DEFAULT '0',
  `com_edit_all` tinyint(1) NOT NULL DEFAULT '0',
  `com_suppr_own` tinyint(1) NOT NULL DEFAULT '0',
  `com_suppr_all` tinyint(1) NOT NULL DEFAULT '0',
  `com_suppr_all_own_note` tinyint(1) NOT NULL DEFAULT '0',
  `upload_image` tinyint(1) NOT NULL DEFAULT '0',
  `upload_son` tinyint(1) NOT NULL DEFAULT '0',
  `upload_video` tinyint(1) NOT NULL DEFAULT '0',
  `upload_suppr_own` tinyint(1) NOT NULL DEFAULT '0',
  `upload_suppr_all` tinyint(1) NOT NULL DEFAULT '0',
  `compte_reset_pwd_own` tinyint(1) NOT NULL DEFAULT '0',
  `compte_edit_own` tinyint(1) NOT NULL DEFAULT '0',
  `compte_suppr_own` tinyint(1) NOT NULL DEFAULT '0',
  `stats_see_own` tinyint(1) NOT NULL DEFAULT '0',
  `stats_see_access_right` int(11) NOT NULL DEFAULT '1',
  `access_admin` tinyint(1) NOT NULL DEFAULT '0',
  `compte_reset_pwd_all_less_admin` tinyint(1) NOT NULL DEFAULT '0',
  `compte_reset_pwd_all` tinyint(1) NOT NULL DEFAULT '0',
  `compte_create_normal_user` tinyint(1) NOT NULL DEFAULT '0',
  `compte_create_admin_user` tinyint(1) NOT NULL DEFAULT '0',
  `compte_edit_all_less_admin` tinyint(1) NOT NULL DEFAULT '0',
  `compte_edit_all` tinyint(1) NOT NULL DEFAULT '0',
  `compte_suppr_all_less_admin` tinyint(1) NOT NULL DEFAULT '0',
  `compte_suppr_all` tinyint(1) NOT NULL DEFAULT '0',
  `arbo_create` tinyint(1) NOT NULL DEFAULT '0',
  `arbo_edit` tinyint(1) NOT NULL DEFAULT '0',
  `arbo_suppr` tinyint(1) NOT NULL DEFAULT '0',
  `access_sources` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `mp_group_access`
--

INSERT INTO `mp_group_access` (`id`, `right_level`, `name`, `access_note`, `arbo_access_rights`, `note_add`, `note_edit_own`, `note_edit_all`, `note_suppr_own`, `note_suppr_all`, `com_add`, `com_edit_own`, `com_edit_all`, `com_suppr_own`, `com_suppr_all`, `com_suppr_all_own_note`, `upload_image`, `upload_son`, `upload_video`, `upload_suppr_own`, `upload_suppr_all`, `compte_reset_pwd_own`, `compte_edit_own`, `compte_suppr_own`, `stats_see_own`, `stats_see_access_right`, `access_admin`, `compte_reset_pwd_all_less_admin`, `compte_reset_pwd_all`, `compte_create_normal_user`, `compte_create_admin_user`, `compte_edit_all_less_admin`, `compte_edit_all`, `compte_suppr_all_less_admin`, `compte_suppr_all`, `arbo_create`, `arbo_edit`, `arbo_suppr`, `access_sources`) VALUES
(1, 0, 'visitor', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 'user_normal', 1, 0, 1, 1, 0, 1, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 2, 'admin', 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mp_logins`
--

CREATE TABLE IF NOT EXISTS `mp_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `mp_logins`
--

INSERT INTO `mp_logins` (`id`, `user`, `password`) VALUES
(1, 'test', 'test'),
(2, 'admin', 'admin'),
(3, 'visitor', 'visitor');

-- --------------------------------------------------------

--
-- Structure de la table `mp_users_profile`
--

CREATE TABLE IF NOT EXISTS `mp_users_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_login` int(11) NOT NULL,
  `id_group_access` int(11) NOT NULL,
  `id_ban` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path_avatar` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `localisation` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `date_naissance` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `mp_users_profile`
--

INSERT INTO `mp_users_profile` (`id`, `id_login`, `id_group_access`, `id_ban`, `last_ip`, `name`, `path_avatar`, `mail`, `localisation`, `tel`, `date_naissance`) VALUES
(1, 1, 2, 0, '', 'TeSt', '', 'test@test.test', 'Dtc', '065089565656', '10/42/3277'),
(2, 2, 3, 0, '', 'AdMiN', '', '', '', '', ''),
(3, 3, 1, 0, '', 'Visitor', '', '', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
