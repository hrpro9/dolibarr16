-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 23 déc. 2022 à 11:28
-- Version du serveur :  10.11.1-MariaDB-1:10.11.1+maria~ubu2004
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `igdoli`
--

-- --------------------------------------------------------

--
-- Structure de la table `llx_accounting_account`
--

CREATE TABLE `llx_accounting_account` (
  `rowid` bigint(20) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_pcg_version` varchar(32) NOT NULL,
  `pcg_type` varchar(20) NOT NULL,
  `account_number` varchar(32) NOT NULL,
  `account_parent` int(11) DEFAULT 0,
  `label` varchar(255) NOT NULL,
  `labelshort` varchar(255) DEFAULT NULL,
  `fk_accounting_category` int(11) DEFAULT 0,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `reconcilable` tinyint(4) NOT NULL DEFAULT 0,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_accounting_bookkeeping`
--

CREATE TABLE `llx_accounting_bookkeeping` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `piece_num` int(11) NOT NULL,
  `doc_date` date NOT NULL,
  `doc_type` varchar(30) NOT NULL,
  `doc_ref` varchar(300) NOT NULL,
  `fk_doc` int(11) NOT NULL,
  `fk_docdet` int(11) NOT NULL,
  `thirdparty_code` varchar(32) DEFAULT NULL,
  `subledger_account` varchar(32) DEFAULT NULL,
  `subledger_label` varchar(255) DEFAULT NULL,
  `numero_compte` varchar(32) NOT NULL,
  `label_compte` varchar(255) NOT NULL,
  `label_operation` varchar(255) DEFAULT NULL,
  `debit` double(24,8) NOT NULL,
  `credit` double(24,8) NOT NULL,
  `montant` double(24,8) DEFAULT NULL,
  `sens` varchar(1) DEFAULT NULL,
  `multicurrency_amount` double(24,8) DEFAULT NULL,
  `multicurrency_code` varchar(255) DEFAULT NULL,
  `lettering_code` varchar(255) DEFAULT NULL,
  `date_lettering` datetime DEFAULT NULL,
  `date_lim_reglement` datetime DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user` int(11) DEFAULT NULL,
  `code_journal` varchar(32) NOT NULL,
  `journal_label` varchar(255) DEFAULT NULL,
  `date_validated` datetime DEFAULT NULL,
  `date_export` datetime DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_accounting_bookkeeping_tmp`
--

CREATE TABLE `llx_accounting_bookkeeping_tmp` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `doc_date` date NOT NULL,
  `doc_type` varchar(30) NOT NULL,
  `doc_ref` varchar(300) NOT NULL,
  `fk_doc` int(11) NOT NULL,
  `fk_docdet` int(11) NOT NULL,
  `thirdparty_code` varchar(32) DEFAULT NULL,
  `subledger_account` varchar(32) DEFAULT NULL,
  `subledger_label` varchar(255) DEFAULT NULL,
  `numero_compte` varchar(32) DEFAULT NULL,
  `label_compte` varchar(255) NOT NULL,
  `label_operation` varchar(255) DEFAULT NULL,
  `debit` double(24,8) NOT NULL,
  `credit` double(24,8) NOT NULL,
  `montant` double(24,8) NOT NULL,
  `sens` varchar(1) DEFAULT NULL,
  `multicurrency_amount` double(24,8) DEFAULT NULL,
  `multicurrency_code` varchar(255) DEFAULT NULL,
  `lettering_code` varchar(255) DEFAULT NULL,
  `date_lettering` datetime DEFAULT NULL,
  `date_lim_reglement` datetime DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user` int(11) DEFAULT NULL,
  `code_journal` varchar(32) NOT NULL,
  `journal_label` varchar(255) DEFAULT NULL,
  `piece_num` int(11) NOT NULL,
  `date_validated` datetime DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_accounting_fiscalyear`
--

CREATE TABLE `llx_accounting_fiscalyear` (
  `rowid` int(11) NOT NULL,
  `label` varchar(128) NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `statut` tinyint(4) NOT NULL DEFAULT 0,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datec` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_accounting_groups_account`
--

CREATE TABLE `llx_accounting_groups_account` (
  `rowid` int(11) NOT NULL,
  `fk_accounting_account` int(11) NOT NULL,
  `fk_c_accounting_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_accounting_journal`
--

CREATE TABLE `llx_accounting_journal` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `code` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  `nature` smallint(6) NOT NULL DEFAULT 1,
  `active` smallint(6) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_accounting_system`
--

CREATE TABLE `llx_accounting_system` (
  `rowid` int(11) NOT NULL,
  `fk_country` int(11) DEFAULT NULL,
  `pcg_version` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  `active` smallint(6) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_actioncomm`
--

CREATE TABLE `llx_actioncomm` (
  `id` int(11) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datep` datetime DEFAULT NULL,
  `datep2` datetime DEFAULT NULL,
  `fk_action` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_mod` int(11) DEFAULT NULL,
  `fk_project` int(11) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_contact` int(11) DEFAULT NULL,
  `fk_parent` int(11) NOT NULL DEFAULT 0,
  `fk_user_action` int(11) DEFAULT NULL,
  `fk_user_done` int(11) DEFAULT NULL,
  `transparency` int(11) DEFAULT NULL,
  `priority` smallint(6) DEFAULT NULL,
  `visibility` varchar(12) DEFAULT 'default',
  `fulldayevent` smallint(6) NOT NULL DEFAULT 0,
  `percent` smallint(6) NOT NULL DEFAULT 0,
  `location` varchar(128) DEFAULT NULL,
  `durationp` double DEFAULT NULL,
  `label` varchar(255) NOT NULL,
  `note` mediumtext DEFAULT NULL,
  `calling_duration` int(11) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_msgid` varchar(255) DEFAULT NULL,
  `email_from` varchar(255) DEFAULT NULL,
  `email_sender` varchar(255) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `email_tocc` varchar(255) DEFAULT NULL,
  `email_tobcc` varchar(255) DEFAULT NULL,
  `errors_to` varchar(255) DEFAULT NULL,
  `reply_to` varchar(255) DEFAULT NULL,
  `recurid` varchar(128) DEFAULT NULL,
  `recurrule` varchar(128) DEFAULT NULL,
  `recurdateend` datetime DEFAULT NULL,
  `num_vote` int(11) DEFAULT NULL,
  `event_paid` smallint(6) NOT NULL DEFAULT 0,
  `status` smallint(6) NOT NULL DEFAULT 0,
  `fk_element` int(11) DEFAULT NULL,
  `elementtype` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_actioncomm_extrafields`
--

CREATE TABLE `llx_actioncomm_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_actioncomm_reminder`
--

CREATE TABLE `llx_actioncomm_reminder` (
  `rowid` int(11) NOT NULL,
  `dateremind` datetime NOT NULL,
  `typeremind` varchar(32) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `offsetvalue` int(11) NOT NULL,
  `offsetunit` varchar(1) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `lasterror` varchar(128) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_actioncomm` int(11) NOT NULL,
  `fk_email_template` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_actioncomm_resources`
--

CREATE TABLE `llx_actioncomm_resources` (
  `rowid` int(11) NOT NULL,
  `fk_actioncomm` int(11) NOT NULL,
  `element_type` varchar(50) NOT NULL,
  `fk_element` int(11) NOT NULL,
  `answer_status` varchar(50) DEFAULT NULL,
  `mandatory` smallint(6) DEFAULT NULL,
  `transparency` smallint(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_adherent`
--

CREATE TABLE `llx_adherent` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(128) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `civility` varchar(6) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `pass_crypted` varchar(128) DEFAULT NULL,
  `fk_adherent_type` int(11) NOT NULL,
  `morphy` varchar(3) NOT NULL,
  `societe` varchar(128) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `zip` varchar(30) DEFAULT NULL,
  `town` varchar(50) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `socialnetworks` text DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `phone_perso` varchar(30) DEFAULT NULL,
  `phone_mobile` varchar(30) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `statut` smallint(6) NOT NULL DEFAULT 0,
  `public` smallint(6) NOT NULL DEFAULT 0,
  `datefin` datetime DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `datevalid` datetime DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_mod` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `canvas` varchar(32) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_adherent_extrafields`
--

CREATE TABLE `llx_adherent_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_adherent_type`
--

CREATE TABLE `llx_adherent_type` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `statut` smallint(6) NOT NULL DEFAULT 0,
  `libelle` varchar(50) NOT NULL,
  `morphy` varchar(3) NOT NULL,
  `duration` varchar(6) DEFAULT NULL,
  `subscription` varchar(3) NOT NULL DEFAULT '1',
  `amount` double(24,8) DEFAULT NULL,
  `vote` varchar(3) NOT NULL DEFAULT '1',
  `note` text DEFAULT NULL,
  `mail_valid` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_adherent_type_extrafields`
--

CREATE TABLE `llx_adherent_type_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_adherent_type_lang`
--

CREATE TABLE `llx_adherent_type_lang` (
  `rowid` int(11) NOT NULL,
  `fk_type` int(11) NOT NULL DEFAULT 0,
  `lang` varchar(5) NOT NULL DEFAULT '0',
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bank`
--

CREATE TABLE `llx_bank` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datev` date DEFAULT NULL,
  `dateo` date DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `amount_main_currency` double(24,8) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_rappro` int(11) DEFAULT NULL,
  `fk_type` varchar(6) DEFAULT NULL,
  `num_releve` varchar(50) DEFAULT NULL,
  `num_chq` varchar(50) DEFAULT NULL,
  `numero_compte` varchar(32) DEFAULT NULL,
  `rappro` tinyint(4) DEFAULT 0,
  `note` text DEFAULT NULL,
  `fk_bordereau` int(11) DEFAULT 0,
  `banque` varchar(255) DEFAULT NULL,
  `emetteur` varchar(255) DEFAULT NULL,
  `author` varchar(40) DEFAULT NULL,
  `origin_id` int(11) DEFAULT NULL,
  `origin_type` varchar(64) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bank_account`
--

CREATE TABLE `llx_bank_account` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ref` varchar(12) NOT NULL,
  `label` varchar(30) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `bank` varchar(60) DEFAULT NULL,
  `code_banque` varchar(128) DEFAULT NULL,
  `code_guichet` varchar(6) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `cle_rib` varchar(5) DEFAULT NULL,
  `bic` varchar(11) DEFAULT NULL,
  `iban_prefix` varchar(34) DEFAULT NULL,
  `country_iban` varchar(2) DEFAULT NULL,
  `cle_iban` varchar(2) DEFAULT NULL,
  `domiciliation` varchar(255) DEFAULT NULL,
  `pti_in_ctti` smallint(6) DEFAULT 0,
  `state_id` int(11) DEFAULT NULL,
  `fk_pays` int(11) NOT NULL,
  `proprio` varchar(60) DEFAULT NULL,
  `owner_address` varchar(255) DEFAULT NULL,
  `courant` smallint(6) NOT NULL DEFAULT 0,
  `clos` smallint(6) NOT NULL DEFAULT 0,
  `rappro` smallint(6) DEFAULT 1,
  `url` varchar(128) DEFAULT NULL,
  `account_number` varchar(32) DEFAULT NULL,
  `fk_accountancy_journal` int(11) DEFAULT NULL,
  `currency_code` varchar(3) NOT NULL,
  `min_allowed` int(11) DEFAULT 0,
  `min_desired` int(11) DEFAULT 0,
  `comment` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `ics` varchar(32) DEFAULT NULL,
  `ics_transfer` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bank_account_extrafields`
--

CREATE TABLE `llx_bank_account_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bank_categ`
--

CREATE TABLE `llx_bank_categ` (
  `rowid` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bank_class`
--

CREATE TABLE `llx_bank_class` (
  `lineid` int(11) NOT NULL,
  `fk_categ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bank_url`
--

CREATE TABLE `llx_bank_url` (
  `rowid` int(11) NOT NULL,
  `fk_bank` int(11) DEFAULT NULL,
  `url_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `type` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_blockedlog`
--

CREATE TABLE `llx_blockedlog` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` varchar(50) DEFAULT NULL,
  `amounts` double(24,8) NOT NULL,
  `element` varchar(50) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `user_fullname` varchar(255) DEFAULT NULL,
  `fk_object` int(11) DEFAULT NULL,
  `ref_object` varchar(255) DEFAULT NULL,
  `date_object` datetime DEFAULT NULL,
  `signature` varchar(100) NOT NULL,
  `signature_line` varchar(100) NOT NULL,
  `object_data` mediumtext DEFAULT NULL,
  `object_version` varchar(32) DEFAULT '',
  `certified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_blockedlog_authority`
--

CREATE TABLE `llx_blockedlog_authority` (
  `rowid` int(11) NOT NULL,
  `blockchain` longtext NOT NULL,
  `signature` varchar(100) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bom_bom`
--

CREATE TABLE `llx_bom_bom` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref` varchar(128) NOT NULL,
  `bomtype` int(11) DEFAULT 0,
  `label` varchar(255) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `qty` double(24,8) DEFAULT NULL,
  `efficiency` double(24,8) DEFAULT 1.00000000,
  `duration` double(24,8) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bom_bomline`
--

CREATE TABLE `llx_bom_bomline` (
  `rowid` int(11) NOT NULL,
  `fk_bom` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `fk_bom_child` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `qty` double(24,8) NOT NULL,
  `qty_frozen` smallint(6) DEFAULT 0,
  `disable_stock_change` smallint(6) DEFAULT 0,
  `efficiency` double(24,8) NOT NULL DEFAULT 1.00000000,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bom_bomline_extrafields`
--

CREATE TABLE `llx_bom_bomline_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bom_bom_extrafields`
--

CREATE TABLE `llx_bom_bom_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bookmark`
--

CREATE TABLE `llx_bookmark` (
  `rowid` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `dateb` datetime DEFAULT NULL,
  `url` text DEFAULT NULL,
  `target` varchar(16) DEFAULT NULL,
  `title` varchar(64) DEFAULT NULL,
  `favicon` varchar(24) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `entity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_bordereau_cheque`
--

CREATE TABLE `llx_bordereau_cheque` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `datec` datetime NOT NULL,
  `date_bordereau` date DEFAULT NULL,
  `amount` double(24,8) NOT NULL,
  `nbcheque` smallint(6) NOT NULL,
  `fk_bank_account` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `statut` smallint(6) NOT NULL DEFAULT 0,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` text DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_boxes`
--

CREATE TABLE `llx_boxes` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `box_id` int(11) NOT NULL,
  `position` smallint(6) NOT NULL,
  `box_order` varchar(3) NOT NULL,
  `fk_user` int(11) NOT NULL DEFAULT 0,
  `maxline` int(11) DEFAULT NULL,
  `params` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_boxes_def`
--

CREATE TABLE `llx_boxes_def` (
  `rowid` int(11) NOT NULL,
  `file` varchar(200) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_user` int(11) NOT NULL DEFAULT 0,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` varchar(130) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_budget`
--

CREATE TABLE `llx_budget` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `label` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_budget_lines`
--

CREATE TABLE `llx_budget_lines` (
  `rowid` int(11) NOT NULL,
  `fk_budget` int(11) NOT NULL,
  `fk_project_ids` varchar(180) NOT NULL,
  `amount` double(24,8) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie`
--

CREATE TABLE `llx_categorie` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_parent` int(11) NOT NULL DEFAULT 0,
  `label` varchar(180) NOT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `color` varchar(8) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `visible` tinyint(4) NOT NULL DEFAULT 1,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categories_extrafields`
--

CREATE TABLE `llx_categories_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_account`
--

CREATE TABLE `llx_categorie_account` (
  `fk_categorie` int(11) NOT NULL,
  `fk_account` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_actioncomm`
--

CREATE TABLE `llx_categorie_actioncomm` (
  `fk_categorie` int(11) NOT NULL,
  `fk_actioncomm` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_contact`
--

CREATE TABLE `llx_categorie_contact` (
  `fk_categorie` int(11) NOT NULL,
  `fk_socpeople` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_fournisseur`
--

CREATE TABLE `llx_categorie_fournisseur` (
  `fk_categorie` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_knowledgemanagement`
--

CREATE TABLE `llx_categorie_knowledgemanagement` (
  `fk_categorie` int(11) NOT NULL,
  `fk_knowledgemanagement` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_lang`
--

CREATE TABLE `llx_categorie_lang` (
  `rowid` int(11) NOT NULL,
  `fk_category` int(11) NOT NULL DEFAULT 0,
  `lang` varchar(5) NOT NULL DEFAULT '0',
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_member`
--

CREATE TABLE `llx_categorie_member` (
  `fk_categorie` int(11) NOT NULL,
  `fk_member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_product`
--

CREATE TABLE `llx_categorie_product` (
  `fk_categorie` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_project`
--

CREATE TABLE `llx_categorie_project` (
  `fk_categorie` int(11) NOT NULL,
  `fk_project` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_societe`
--

CREATE TABLE `llx_categorie_societe` (
  `fk_categorie` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_user`
--

CREATE TABLE `llx_categorie_user` (
  `fk_categorie` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_categorie_warehouse`
--

CREATE TABLE `llx_categorie_warehouse` (
  `fk_categorie` int(11) NOT NULL,
  `fk_warehouse` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_chargesociales`
--

CREATE TABLE `llx_chargesociales` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(16) DEFAULT NULL,
  `date_ech` datetime NOT NULL,
  `libelle` varchar(80) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_creation` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_type` int(11) NOT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `paye` smallint(6) NOT NULL DEFAULT 0,
  `periode` date DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commande`
--

CREATE TABLE `llx_commande` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(255) DEFAULT NULL,
  `ref_int` varchar(255) DEFAULT NULL,
  `ref_client` varchar(255) DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_creation` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `date_commande` date DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `source` smallint(6) DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT 0,
  `amount_ht` double(24,8) DEFAULT 0.00000000,
  `remise_percent` double DEFAULT 0,
  `remise_absolue` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `localtax1` double(24,8) DEFAULT 0.00000000,
  `localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `module_source` varchar(32) DEFAULT NULL,
  `pos_source` varchar(32) DEFAULT NULL,
  `facture` tinyint(4) DEFAULT 0,
  `fk_account` int(11) DEFAULT NULL,
  `fk_currency` varchar(3) DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `deposit_percent` varchar(63) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `date_livraison` datetime DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `fk_availability` int(11) DEFAULT NULL,
  `fk_input_reason` int(11) DEFAULT NULL,
  `fk_delivery_address` int(11) DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commandedet`
--

CREATE TABLE `llx_commandedet` (
  `rowid` int(11) NOT NULL,
  `fk_commande` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT NULL,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `fk_remise_except` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `subprice` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `product_type` int(11) DEFAULT 0,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT 0,
  `buy_price_ht` double(24,8) DEFAULT 0.00000000,
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(11) DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `fk_unit` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `fk_commandefourndet` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commandedet_extrafields`
--

CREATE TABLE `llx_commandedet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commande_extrafields`
--

CREATE TABLE `llx_commande_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commande_fournisseur`
--

CREATE TABLE `llx_commande_fournisseur` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(180) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(255) DEFAULT NULL,
  `ref_supplier` varchar(255) DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT 0,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_creation` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_approve` datetime DEFAULT NULL,
  `date_approve2` datetime DEFAULT NULL,
  `date_commande` date DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_approve` int(11) DEFAULT NULL,
  `fk_user_approve2` int(11) DEFAULT NULL,
  `source` smallint(6) NOT NULL,
  `fk_statut` smallint(6) DEFAULT 0,
  `billed` smallint(6) DEFAULT 0,
  `amount_ht` double(24,8) DEFAULT 0.00000000,
  `remise_percent` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `localtax1` double(24,8) DEFAULT 0.00000000,
  `localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `date_livraison` datetime DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `fk_input_method` int(11) DEFAULT 0,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commande_fournisseurdet`
--

CREATE TABLE `llx_commande_fournisseurdet` (
  `rowid` int(11) NOT NULL,
  `fk_commande` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `subprice` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `product_type` int(11) DEFAULT 0,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT 0,
  `special_code` int(11) DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `import_key` varchar(14) DEFAULT NULL,
  `fk_unit` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commande_fournisseurdet_extrafields`
--

CREATE TABLE `llx_commande_fournisseurdet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commande_fournisseur_dispatch`
--

CREATE TABLE `llx_commande_fournisseur_dispatch` (
  `rowid` int(11) NOT NULL,
  `fk_commande` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `fk_commandefourndet` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_reception` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `fk_entrepot` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `batch` varchar(128) DEFAULT NULL,
  `eatby` date DEFAULT NULL,
  `sellby` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cost_price` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commande_fournisseur_dispatch_extrafields`
--

CREATE TABLE `llx_commande_fournisseur_dispatch_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commande_fournisseur_extrafields`
--

CREATE TABLE `llx_commande_fournisseur_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_commande_fournisseur_log`
--

CREATE TABLE `llx_commande_fournisseur_log` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datelog` datetime NOT NULL,
  `fk_commande` int(11) NOT NULL,
  `fk_statut` smallint(6) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_comment`
--

CREATE TABLE `llx_comment` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` text NOT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_element` int(11) DEFAULT NULL,
  `element_type` varchar(50) DEFAULT NULL,
  `entity` int(11) DEFAULT 1,
  `import_key` varchar(125) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_const`
--

CREATE TABLE `llx_const` (
  `rowid` int(11) NOT NULL,
  `name` varchar(180) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `value` text NOT NULL,
  `type` varchar(64) DEFAULT 'string',
  `visible` tinyint(4) NOT NULL DEFAULT 1,
  `note` text DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_contrat`
--

CREATE TABLE `llx_contrat` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `ref_customer` varchar(255) DEFAULT NULL,
  `ref_supplier` varchar(255) DEFAULT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `date_contrat` datetime DEFAULT NULL,
  `statut` smallint(6) DEFAULT 0,
  `fin_validite` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_commercial_signature` int(11) DEFAULT NULL,
  `fk_commercial_suivi` int(11) DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL DEFAULT 0,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_contratdet`
--

CREATE TABLE `llx_contratdet` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_contrat` int(11) NOT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `statut` smallint(6) DEFAULT 0,
  `label` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fk_remise_except` int(11) DEFAULT NULL,
  `date_commande` datetime DEFAULT NULL,
  `date_ouverture_prevue` datetime DEFAULT NULL,
  `date_ouverture` datetime DEFAULT NULL,
  `date_fin_validite` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `qty` double NOT NULL,
  `remise_percent` double DEFAULT 0,
  `subprice` double(24,8) DEFAULT 0.00000000,
  `price_ht` double DEFAULT NULL,
  `remise` double DEFAULT 0,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `product_type` int(11) DEFAULT 1,
  `info_bits` int(11) DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `buy_price_ht` double(24,8) DEFAULT NULL,
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL DEFAULT 0,
  `fk_user_ouverture` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `fk_unit` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_contratdet_extrafields`
--

CREATE TABLE `llx_contratdet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_contratdet_log`
--

CREATE TABLE `llx_contratdet_log` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_contratdet` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `statut` smallint(6) NOT NULL,
  `fk_user_author` int(11) NOT NULL,
  `commentaire` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_contrat_extrafields`
--

CREATE TABLE `llx_contrat_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_cronjob`
--

CREATE TABLE `llx_cronjob` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `jobtype` varchar(10) NOT NULL,
  `label` varchar(255) NOT NULL,
  `command` varchar(255) DEFAULT NULL,
  `classesname` varchar(255) DEFAULT NULL,
  `objectname` varchar(255) DEFAULT NULL,
  `methodename` varchar(255) DEFAULT NULL,
  `params` text DEFAULT NULL,
  `md5params` varchar(32) DEFAULT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `priority` int(11) DEFAULT 0,
  `datelastrun` datetime DEFAULT NULL,
  `datenextrun` datetime DEFAULT NULL,
  `datestart` datetime DEFAULT NULL,
  `dateend` datetime DEFAULT NULL,
  `datelastresult` datetime DEFAULT NULL,
  `lastresult` text DEFAULT NULL,
  `lastoutput` text DEFAULT NULL,
  `unitfrequency` varchar(255) NOT NULL DEFAULT '3600',
  `frequency` int(11) NOT NULL DEFAULT 0,
  `maxrun` int(11) NOT NULL DEFAULT 0,
  `nbrun` int(11) DEFAULT NULL,
  `autodelete` int(11) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `processing` int(11) NOT NULL DEFAULT 0,
  `test` varchar(255) DEFAULT '1',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_mod` int(11) DEFAULT NULL,
  `fk_mailing` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `libname` varchar(255) DEFAULT NULL,
  `email_alert` varchar(128) DEFAULT NULL,
  `entity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_accounting_category`
--

CREATE TABLE `llx_c_accounting_category` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `code` varchar(16) NOT NULL,
  `label` varchar(255) NOT NULL,
  `range_account` varchar(255) NOT NULL,
  `sens` tinyint(4) NOT NULL DEFAULT 0,
  `category_type` tinyint(4) NOT NULL DEFAULT 0,
  `formula` varchar(255) NOT NULL,
  `position` int(11) DEFAULT 0,
  `fk_country` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_actioncomm`
--

CREATE TABLE `llx_c_actioncomm` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'system',
  `libelle` varchar(128) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `todo` tinyint(4) DEFAULT NULL,
  `color` varchar(9) DEFAULT NULL,
  `picto` varchar(48) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_action_trigger`
--

CREATE TABLE `llx_c_action_trigger` (
  `rowid` int(11) NOT NULL,
  `elementtype` varchar(64) NOT NULL,
  `code` varchar(64) NOT NULL,
  `label` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `rang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_availability`
--

CREATE TABLE `llx_c_availability` (
  `rowid` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `label` varchar(128) NOT NULL,
  `type_duration` varchar(1) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_barcode_type`
--

CREATE TABLE `llx_c_barcode_type` (
  `rowid` int(11) NOT NULL,
  `code` varchar(16) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `libelle` varchar(128) NOT NULL,
  `coder` varchar(16) NOT NULL,
  `example` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_chargesociales`
--

CREATE TABLE `llx_c_chargesociales` (
  `id` int(11) NOT NULL,
  `libelle` varchar(128) DEFAULT NULL,
  `deductible` smallint(6) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `code` varchar(12) NOT NULL,
  `accountancy_code` varchar(32) DEFAULT NULL,
  `fk_pays` int(11) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_civility`
--

CREATE TABLE `llx_c_civility` (
  `rowid` int(11) NOT NULL,
  `code` varchar(6) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_country`
--

CREATE TABLE `llx_c_country` (
  `rowid` int(11) NOT NULL,
  `code` varchar(2) NOT NULL,
  `code_iso` varchar(3) DEFAULT NULL,
  `label` varchar(128) NOT NULL,
  `eec` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `favorite` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_currencies`
--

CREATE TABLE `llx_c_currencies` (
  `code_iso` varchar(3) NOT NULL,
  `label` varchar(128) NOT NULL,
  `unicode` varchar(32) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_departements`
--

CREATE TABLE `llx_c_departements` (
  `rowid` int(11) NOT NULL,
  `code_departement` varchar(6) NOT NULL,
  `fk_region` int(11) DEFAULT NULL,
  `cheflieu` varchar(50) DEFAULT NULL,
  `tncc` int(11) DEFAULT NULL,
  `ncc` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_ecotaxe`
--

CREATE TABLE `llx_c_ecotaxe` (
  `rowid` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `price` double(24,8) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `fk_pays` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_effectif`
--

CREATE TABLE `llx_c_effectif` (
  `id` int(11) NOT NULL,
  `code` varchar(12) NOT NULL,
  `libelle` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_email_senderprofile`
--

CREATE TABLE `llx_c_email_senderprofile` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `private` smallint(6) NOT NULL DEFAULT 0,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `label` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `signature` text DEFAULT NULL,
  `position` smallint(6) DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_email_templates`
--

CREATE TABLE `llx_c_email_templates` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL,
  `type_template` varchar(32) DEFAULT NULL,
  `lang` varchar(6) DEFAULT '',
  `private` smallint(6) NOT NULL DEFAULT 0,
  `fk_user` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `label` varchar(180) DEFAULT NULL,
  `position` smallint(6) DEFAULT NULL,
  `enabled` varchar(255) DEFAULT '1',
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `email_from` varchar(255) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `email_tocc` varchar(255) DEFAULT NULL,
  `email_tobcc` varchar(255) DEFAULT NULL,
  `topic` text DEFAULT NULL,
  `joinfiles` text DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `content_lines` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_exp_tax_cat`
--

CREATE TABLE `llx_c_exp_tax_cat` (
  `rowid` int(11) NOT NULL,
  `label` varchar(128) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_exp_tax_range`
--

CREATE TABLE `llx_c_exp_tax_range` (
  `rowid` int(11) NOT NULL,
  `fk_c_exp_tax_cat` int(11) NOT NULL DEFAULT 1,
  `range_ik` double NOT NULL DEFAULT 0,
  `entity` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_field_list`
--

CREATE TABLE `llx_c_field_list` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `element` varchar(64) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `name` varchar(32) NOT NULL,
  `alias` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL,
  `align` varchar(6) DEFAULT 'left',
  `sort` tinyint(4) NOT NULL DEFAULT 1,
  `search` tinyint(4) NOT NULL DEFAULT 0,
  `visible` tinyint(4) NOT NULL DEFAULT 1,
  `enabled` varchar(255) DEFAULT '1',
  `rang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_format_cards`
--

CREATE TABLE `llx_c_format_cards` (
  `rowid` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `paper_size` varchar(20) NOT NULL,
  `orientation` varchar(1) NOT NULL,
  `metric` varchar(5) NOT NULL,
  `leftmargin` double(24,8) NOT NULL,
  `topmargin` double(24,8) NOT NULL,
  `nx` int(11) NOT NULL,
  `ny` int(11) NOT NULL,
  `spacex` double(24,8) NOT NULL,
  `spacey` double(24,8) NOT NULL,
  `width` double(24,8) NOT NULL,
  `height` double(24,8) NOT NULL,
  `font_size` int(11) NOT NULL,
  `custom_x` double(24,8) NOT NULL,
  `custom_y` double(24,8) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_forme_juridique`
--

CREATE TABLE `llx_c_forme_juridique` (
  `rowid` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `fk_pays` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `isvatexempted` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_holiday_types`
--

CREATE TABLE `llx_c_holiday_types` (
  `rowid` int(11) NOT NULL,
  `code` varchar(16) NOT NULL,
  `label` varchar(255) NOT NULL,
  `affect` int(11) NOT NULL,
  `delay` int(11) NOT NULL,
  `newbymonth` double(8,5) NOT NULL DEFAULT 0.00000,
  `fk_country` int(11) DEFAULT NULL,
  `block_if_negative` int(11) NOT NULL DEFAULT 0,
  `sortorder` smallint(6) DEFAULT NULL,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_hrm_department`
--

CREATE TABLE `llx_c_hrm_department` (
  `rowid` int(11) NOT NULL,
  `pos` tinyint(4) NOT NULL DEFAULT 0,
  `code` varchar(16) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_hrm_function`
--

CREATE TABLE `llx_c_hrm_function` (
  `rowid` int(11) NOT NULL,
  `pos` tinyint(4) NOT NULL DEFAULT 0,
  `code` varchar(16) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  `c_level` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_hrm_public_holiday`
--

CREATE TABLE `llx_c_hrm_public_holiday` (
  `id` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 0,
  `fk_country` int(11) DEFAULT NULL,
  `fk_departement` int(11) DEFAULT NULL,
  `code` varchar(62) DEFAULT NULL,
  `dayrule` varchar(64) DEFAULT '',
  `day` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT 1,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_incoterms`
--

CREATE TABLE `llx_c_incoterms` (
  `rowid` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `libelle` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_input_method`
--

CREATE TABLE `llx_c_input_method` (
  `rowid` int(11) NOT NULL,
  `code` varchar(30) DEFAULT NULL,
  `libelle` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_input_reason`
--

CREATE TABLE `llx_c_input_reason` (
  `rowid` int(11) NOT NULL,
  `code` varchar(30) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_lead_status`
--

CREATE TABLE `llx_c_lead_status` (
  `rowid` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `percent` double(5,2) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_paiement`
--

CREATE TABLE `llx_c_paiement` (
  `id` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `code` varchar(6) NOT NULL,
  `libelle` varchar(128) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `accountancy_code` varchar(32) DEFAULT NULL,
  `module` varchar(32) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_paper_format`
--

CREATE TABLE `llx_c_paper_format` (
  `rowid` int(11) NOT NULL,
  `code` varchar(16) NOT NULL,
  `label` varchar(128) NOT NULL,
  `width` float(6,2) DEFAULT 0.00,
  `height` float(6,2) DEFAULT 0.00,
  `unit` varchar(5) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_partnership_type`
--

CREATE TABLE `llx_c_partnership_type` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `code` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  `keyword` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_payment_term`
--

CREATE TABLE `llx_c_payment_term` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `code` varchar(16) DEFAULT NULL,
  `sortorder` smallint(6) DEFAULT NULL,
  `active` tinyint(4) DEFAULT 1,
  `libelle` varchar(255) DEFAULT NULL,
  `libelle_facture` text DEFAULT NULL,
  `type_cdr` tinyint(4) DEFAULT NULL,
  `nbjour` smallint(6) DEFAULT NULL,
  `decalage` smallint(6) DEFAULT NULL,
  `deposit_percent` varchar(63) DEFAULT NULL,
  `module` varchar(32) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_price_expression`
--

CREATE TABLE `llx_c_price_expression` (
  `rowid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `expression` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_price_global_variable`
--

CREATE TABLE `llx_c_price_global_variable` (
  `rowid` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `value` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_price_global_variable_updater`
--

CREATE TABLE `llx_c_price_global_variable_updater` (
  `rowid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `parameters` text DEFAULT NULL,
  `fk_variable` int(11) NOT NULL,
  `update_interval` int(11) DEFAULT 0,
  `next_update` int(11) DEFAULT 0,
  `last_status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_productbatch_qcstatus`
--

CREATE TABLE `llx_c_productbatch_qcstatus` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `code` varchar(16) NOT NULL,
  `label` varchar(128) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_product_nature`
--

CREATE TABLE `llx_c_product_nature` (
  `rowid` int(11) NOT NULL,
  `code` tinyint(4) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_propalst`
--

CREATE TABLE `llx_c_propalst` (
  `id` smallint(6) NOT NULL,
  `code` varchar(12) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_prospectcontactlevel`
--

CREATE TABLE `llx_c_prospectcontactlevel` (
  `code` varchar(12) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  `sortorder` smallint(6) DEFAULT NULL,
  `active` smallint(6) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_prospectlevel`
--

CREATE TABLE `llx_c_prospectlevel` (
  `code` varchar(12) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  `sortorder` smallint(6) DEFAULT NULL,
  `active` smallint(6) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_recruitment_origin`
--

CREATE TABLE `llx_c_recruitment_origin` (
  `rowid` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_regions`
--

CREATE TABLE `llx_c_regions` (
  `rowid` int(11) NOT NULL,
  `code_region` int(11) NOT NULL,
  `fk_pays` int(11) NOT NULL,
  `cheflieu` varchar(50) DEFAULT NULL,
  `tncc` int(11) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_revenuestamp`
--

CREATE TABLE `llx_c_revenuestamp` (
  `rowid` int(11) NOT NULL,
  `fk_pays` int(11) NOT NULL,
  `taux` double NOT NULL,
  `revenuestamp_type` varchar(16) NOT NULL DEFAULT 'fixed',
  `note` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `accountancy_code_sell` varchar(32) DEFAULT NULL,
  `accountancy_code_buy` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_shipment_mode`
--

CREATE TABLE `llx_c_shipment_mode` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `code` varchar(30) NOT NULL,
  `libelle` varchar(128) NOT NULL,
  `description` text DEFAULT NULL,
  `tracking` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT 0,
  `module` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_shipment_package_type`
--

CREATE TABLE `llx_c_shipment_package_type` (
  `rowid` int(11) NOT NULL,
  `label` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `entity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_socialnetworks`
--

CREATE TABLE `llx_c_socialnetworks` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `code` varchar(100) DEFAULT NULL,
  `label` varchar(150) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `icon` varchar(20) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_stcomm`
--

CREATE TABLE `llx_c_stcomm` (
  `id` int(11) NOT NULL,
  `code` varchar(24) NOT NULL,
  `libelle` varchar(128) DEFAULT NULL,
  `picto` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_stcommcontact`
--

CREATE TABLE `llx_c_stcommcontact` (
  `id` int(11) NOT NULL,
  `code` varchar(12) NOT NULL,
  `libelle` varchar(128) DEFAULT NULL,
  `picto` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_ticket_category`
--

CREATE TABLE `llx_c_ticket_category` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT 1,
  `code` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  `public` int(11) DEFAULT 0,
  `use_default` int(11) DEFAULT 1,
  `fk_parent` int(11) NOT NULL DEFAULT 0,
  `force_severity` varchar(32) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `pos` int(11) NOT NULL DEFAULT 0,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_ticket_resolution`
--

CREATE TABLE `llx_c_ticket_resolution` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT 1,
  `code` varchar(32) NOT NULL,
  `pos` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  `active` int(11) DEFAULT 1,
  `use_default` int(11) DEFAULT 1,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_ticket_severity`
--

CREATE TABLE `llx_c_ticket_severity` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT 1,
  `code` varchar(32) NOT NULL,
  `pos` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  `color` varchar(10) DEFAULT NULL,
  `active` int(11) DEFAULT 1,
  `use_default` int(11) DEFAULT 1,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_ticket_type`
--

CREATE TABLE `llx_c_ticket_type` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT 1,
  `code` varchar(32) NOT NULL,
  `pos` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  `active` int(11) DEFAULT 1,
  `use_default` int(11) DEFAULT 1,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_transport_mode`
--

CREATE TABLE `llx_c_transport_mode` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `code` varchar(3) NOT NULL,
  `label` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_tva`
--

CREATE TABLE `llx_c_tva` (
  `rowid` int(11) NOT NULL,
  `fk_pays` int(11) NOT NULL,
  `code` varchar(10) DEFAULT '',
  `taux` double NOT NULL,
  `localtax1` varchar(20) NOT NULL DEFAULT '0',
  `localtax1_type` varchar(10) NOT NULL DEFAULT '0',
  `localtax2` varchar(20) NOT NULL DEFAULT '0',
  `localtax2_type` varchar(10) NOT NULL DEFAULT '0',
  `recuperableonly` int(11) NOT NULL DEFAULT 0,
  `note` varchar(128) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `accountancy_code_sell` varchar(32) DEFAULT NULL,
  `accountancy_code_buy` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_typent`
--

CREATE TABLE `llx_c_typent` (
  `id` int(11) NOT NULL,
  `code` varchar(12) NOT NULL,
  `libelle` varchar(128) DEFAULT NULL,
  `fk_country` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_type_contact`
--

CREATE TABLE `llx_c_type_contact` (
  `rowid` int(11) NOT NULL,
  `element` varchar(30) NOT NULL,
  `source` varchar(8) NOT NULL DEFAULT 'external',
  `code` varchar(32) NOT NULL,
  `libelle` varchar(128) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_type_container`
--

CREATE TABLE `llx_c_type_container` (
  `rowid` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `label` varchar(128) NOT NULL,
  `module` varchar(32) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_type_fees`
--

CREATE TABLE `llx_c_type_fees` (
  `id` int(11) NOT NULL,
  `code` varchar(12) NOT NULL,
  `label` varchar(128) DEFAULT NULL,
  `type` int(11) DEFAULT 0,
  `accountancy_code` varchar(32) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `module` varchar(32) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_type_resource`
--

CREATE TABLE `llx_c_type_resource` (
  `rowid` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_units`
--

CREATE TABLE `llx_c_units` (
  `rowid` int(11) NOT NULL,
  `code` varchar(3) DEFAULT NULL,
  `sortorder` smallint(6) DEFAULT NULL,
  `scale` int(11) DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `short_label` varchar(5) DEFAULT NULL,
  `unit_type` varchar(10) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_c_ziptown`
--

CREATE TABLE `llx_c_ziptown` (
  `rowid` int(11) NOT NULL,
  `code` varchar(5) DEFAULT NULL,
  `fk_county` int(11) DEFAULT NULL,
  `fk_pays` int(11) NOT NULL DEFAULT 0,
  `zip` varchar(10) NOT NULL,
  `town` varchar(180) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_default_values`
--

CREATE TABLE `llx_default_values` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `type` varchar(10) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `page` varchar(255) DEFAULT NULL,
  `param` varchar(255) DEFAULT NULL,
  `value` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_delivery`
--

CREATE TABLE `llx_delivery` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ref` varchar(30) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) NOT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `ref_int` varchar(255) DEFAULT NULL,
  `ref_customer` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `date_delivery` datetime DEFAULT NULL,
  `fk_address` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT 0,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_deliverydet`
--

CREATE TABLE `llx_deliverydet` (
  `rowid` int(11) NOT NULL,
  `fk_delivery` int(11) DEFAULT NULL,
  `fk_origin_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `subprice` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `rang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_deliverydet_extrafields`
--

CREATE TABLE `llx_deliverydet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_delivery_extrafields`
--

CREATE TABLE `llx_delivery_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_document_model`
--

CREATE TABLE `llx_document_model` (
  `rowid` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `type` varchar(64) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_ecm_directories`
--

CREATE TABLE `llx_ecm_directories` (
  `rowid` int(11) NOT NULL,
  `label` varchar(64) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_parent` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `cachenbofdoc` int(11) NOT NULL DEFAULT 0,
  `fullpath` varchar(750) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_c` int(11) DEFAULT NULL,
  `fk_user_m` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `acl` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_ecm_directories_extrafields`
--

CREATE TABLE `llx_ecm_directories_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_ecm_files`
--

CREATE TABLE `llx_ecm_files` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) DEFAULT NULL,
  `label` varchar(128) NOT NULL,
  `share` varchar(128) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `filepath` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `src_object_type` varchar(64) DEFAULT NULL,
  `src_object_id` int(11) DEFAULT NULL,
  `fullpath_orig` varchar(750) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `keywords` varchar(750) DEFAULT NULL,
  `cover` text DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `gen_or_uploaded` varchar(12) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_c` int(11) DEFAULT NULL,
  `fk_user_m` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `acl` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_ecm_files_extrafields`
--

CREATE TABLE `llx_ecm_files_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_element_contact`
--

CREATE TABLE `llx_element_contact` (
  `rowid` int(11) NOT NULL,
  `datecreate` datetime DEFAULT NULL,
  `statut` smallint(6) DEFAULT 5,
  `element_id` int(11) NOT NULL,
  `fk_c_type_contact` int(11) NOT NULL,
  `fk_socpeople` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_element_element`
--

CREATE TABLE `llx_element_element` (
  `rowid` int(11) NOT NULL,
  `fk_source` int(11) NOT NULL,
  `sourcetype` varchar(32) NOT NULL,
  `fk_target` int(11) NOT NULL,
  `targettype` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_element_resources`
--

CREATE TABLE `llx_element_resources` (
  `rowid` int(11) NOT NULL,
  `element_id` int(11) DEFAULT NULL,
  `element_type` varchar(64) DEFAULT NULL,
  `resource_id` int(11) DEFAULT NULL,
  `resource_type` varchar(64) DEFAULT NULL,
  `busy` int(11) DEFAULT NULL,
  `mandatory` int(11) DEFAULT NULL,
  `duree` double DEFAULT NULL,
  `fk_user_create` int(11) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_element_tag`
--

CREATE TABLE `llx_element_tag` (
  `rowid` int(11) NOT NULL,
  `fk_categorie` int(11) NOT NULL,
  `fk_element` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_emailcollector_emailcollector`
--

CREATE TABLE `llx_emailcollector_emailcollector` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref` varchar(128) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `hostcharset` varchar(16) DEFAULT 'UTF-8',
  `login` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `source_directory` varchar(255) NOT NULL,
  `target_directory` varchar(255) DEFAULT NULL,
  `maxemailpercollect` int(11) DEFAULT 100,
  `datelastresult` datetime DEFAULT NULL,
  `codelastresult` varchar(16) DEFAULT NULL,
  `lastresult` varchar(255) DEFAULT NULL,
  `datelastok` datetime DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `import_key` varchar(14) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_emailcollector_emailcollectoraction`
--

CREATE TABLE `llx_emailcollector_emailcollectoraction` (
  `rowid` int(11) NOT NULL,
  `fk_emailcollector` int(11) NOT NULL,
  `type` varchar(128) NOT NULL,
  `actionparam` text DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `import_key` varchar(14) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_emailcollector_emailcollectorfilter`
--

CREATE TABLE `llx_emailcollector_emailcollectorfilter` (
  `rowid` int(11) NOT NULL,
  `fk_emailcollector` int(11) NOT NULL,
  `type` varchar(128) NOT NULL,
  `rulevalue` varchar(128) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_entrepot`
--

CREATE TABLE `llx_entrepot` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_project` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `lieu` varchar(64) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `town` varchar(50) DEFAULT NULL,
  `fk_departement` int(11) DEFAULT NULL,
  `fk_pays` int(11) DEFAULT 0,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `barcode` varchar(180) DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT NULL,
  `warehouse_usage` int(11) DEFAULT 1,
  `statut` tinyint(4) DEFAULT 1,
  `fk_user_author` int(11) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `fk_parent` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_entrepot_extrafields`
--

CREATE TABLE `llx_entrepot_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_establishment`
--

CREATE TABLE `llx_establishment` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `label` varchar(255) DEFAULT NULL,
  `ref` varchar(30) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip` varchar(25) DEFAULT NULL,
  `town` varchar(50) DEFAULT NULL,
  `fk_state` int(11) DEFAULT 0,
  `fk_country` int(11) DEFAULT 0,
  `profid1` varchar(20) DEFAULT NULL,
  `profid2` varchar(20) DEFAULT NULL,
  `profid3` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL,
  `fk_user_mod` int(11) DEFAULT NULL,
  `datec` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_eventorganization_conferenceorboothattendee`
--

CREATE TABLE `llx_eventorganization_conferenceorboothattendee` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) NOT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_actioncomm` int(11) DEFAULT NULL,
  `fk_project` int(11) NOT NULL,
  `fk_invoice` int(11) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `email_company` varchar(128) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `date_subscription` datetime DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_eventorganization_conferenceorboothattendee_extrafields`
--

CREATE TABLE `llx_eventorganization_conferenceorboothattendee_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_events`
--

CREATE TABLE `llx_events` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` varchar(32) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `prefix_session` varchar(255) DEFAULT NULL,
  `dateevent` datetime DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `description` varchar(250) NOT NULL,
  `ip` varchar(250) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `fk_object` int(11) DEFAULT NULL,
  `authentication_method` varchar(64) DEFAULT NULL,
  `fk_oauth_token` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_event_element`
--

CREATE TABLE `llx_event_element` (
  `rowid` int(11) NOT NULL,
  `fk_source` int(11) NOT NULL,
  `fk_target` int(11) NOT NULL,
  `targettype` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expedition`
--

CREATE TABLE `llx_expedition` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ref` varchar(30) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `ref_int` varchar(255) DEFAULT NULL,
  `ref_customer` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `date_delivery` datetime DEFAULT NULL,
  `date_expedition` datetime DEFAULT NULL,
  `fk_address` int(11) DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `tracking_number` varchar(50) DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT 0,
  `billed` smallint(6) DEFAULT 0,
  `height` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `size_units` int(11) DEFAULT NULL,
  `size` float DEFAULT NULL,
  `weight_units` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expeditiondet`
--

CREATE TABLE `llx_expeditiondet` (
  `rowid` int(11) NOT NULL,
  `fk_expedition` int(11) NOT NULL,
  `fk_origin_line` int(11) DEFAULT NULL,
  `fk_entrepot` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `rang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expeditiondet_batch`
--

CREATE TABLE `llx_expeditiondet_batch` (
  `rowid` int(11) NOT NULL,
  `fk_expeditiondet` int(11) NOT NULL,
  `eatby` date DEFAULT NULL,
  `sellby` date DEFAULT NULL,
  `batch` varchar(128) DEFAULT NULL,
  `qty` double NOT NULL DEFAULT 0,
  `fk_origin_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expeditiondet_extrafields`
--

CREATE TABLE `llx_expeditiondet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expedition_extrafields`
--

CREATE TABLE `llx_expedition_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expedition_package`
--

CREATE TABLE `llx_expedition_package` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_expedition` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `value` double(24,8) DEFAULT 0.00000000,
  `fk_package_type` int(11) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `length` float DEFAULT NULL,
  `size_units` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `weight_units` int(11) DEFAULT NULL,
  `dangerous_goods` smallint(6) DEFAULT 0,
  `tail_lift` smallint(6) DEFAULT 0,
  `note_public` text DEFAULT NULL,
  `ref` varchar(128) NOT NULL DEFAULT '(PROV)',
  `ref_supplier` varchar(128) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_supplier` int(11) DEFAULT NULL,
  `fk_project` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expedition_packagedet`
--

CREATE TABLE `llx_expedition_packagedet` (
  `rowid` int(11) NOT NULL,
  `fk_shipmentpackage` int(11) NOT NULL,
  `fk_origin_line` int(11) DEFAULT NULL,
  `fk_origin_batch_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `product_lot_batch` varchar(128) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `rang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expedition_package_extrafields`
--

CREATE TABLE `llx_expedition_package_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT NULL,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expensereport`
--

CREATE TABLE `llx_expensereport` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(50) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_number_int` int(11) DEFAULT NULL,
  `ref_ext` int(11) DEFAULT NULL,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `localtax1` double(24,8) DEFAULT 0.00000000,
  `localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `date_create` datetime NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_approve` datetime DEFAULT NULL,
  `date_refuse` datetime DEFAULT NULL,
  `date_cancel` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_author` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_validator` int(11) DEFAULT NULL,
  `fk_user_approve` int(11) DEFAULT NULL,
  `fk_user_refuse` int(11) DEFAULT NULL,
  `fk_user_cancel` int(11) DEFAULT NULL,
  `fk_statut` int(11) NOT NULL,
  `fk_c_paiement` int(11) DEFAULT NULL,
  `paid` smallint(6) NOT NULL DEFAULT 0,
  `note_public` text DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `detail_refuse` varchar(255) DEFAULT NULL,
  `detail_cancel` varchar(255) DEFAULT NULL,
  `integration_compta` int(11) DEFAULT NULL,
  `fk_bank_account` int(11) DEFAULT NULL,
  `model_pdf` varchar(50) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expensereport_det`
--

CREATE TABLE `llx_expensereport_det` (
  `rowid` int(11) NOT NULL,
  `fk_expensereport` int(11) NOT NULL,
  `docnumber` varchar(128) DEFAULT NULL,
  `fk_c_type_fees` int(11) NOT NULL,
  `fk_c_exp_tax_cat` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `comments` text NOT NULL,
  `product_type` int(11) DEFAULT -1,
  `qty` double NOT NULL,
  `subprice` double(24,8) NOT NULL DEFAULT 0.00000000,
  `value_unit` double(24,8) NOT NULL,
  `remise_percent` double DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT NULL,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `total_ht` double(24,8) NOT NULL DEFAULT 0.00000000,
  `total_tva` double(24,8) NOT NULL DEFAULT 0.00000000,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) NOT NULL DEFAULT 0.00000000,
  `date` date NOT NULL,
  `info_bits` int(11) DEFAULT 0,
  `special_code` int(11) DEFAULT 0,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000,
  `fk_facture` int(11) DEFAULT 0,
  `fk_ecm_files` int(11) DEFAULT NULL,
  `fk_code_ventilation` int(11) DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `import_key` varchar(14) DEFAULT NULL,
  `rule_warning_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expensereport_extrafields`
--

CREATE TABLE `llx_expensereport_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expensereport_ik`
--

CREATE TABLE `llx_expensereport_ik` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_c_exp_tax_cat` int(11) NOT NULL DEFAULT 0,
  `fk_range` int(11) NOT NULL DEFAULT 0,
  `coef` double NOT NULL DEFAULT 0,
  `ikoffset` double NOT NULL DEFAULT 0,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_expensereport_rules`
--

CREATE TABLE `llx_expensereport_rules` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dates` datetime NOT NULL,
  `datee` datetime NOT NULL,
  `amount` double(24,8) NOT NULL,
  `restrictive` tinyint(4) NOT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_usergroup` int(11) DEFAULT NULL,
  `fk_c_type_fees` int(11) NOT NULL,
  `code_expense_rules_type` varchar(50) NOT NULL,
  `is_for_all` tinyint(4) DEFAULT 0,
  `entity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_export_compta`
--

CREATE TABLE `llx_export_compta` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(12) NOT NULL,
  `date_export` datetime NOT NULL,
  `fk_user` int(11) NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_export_model`
--

CREATE TABLE `llx_export_model` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT 0,
  `fk_user` int(11) NOT NULL DEFAULT 0,
  `label` varchar(50) NOT NULL,
  `type` varchar(64) NOT NULL,
  `field` text NOT NULL,
  `filter` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_extrafields`
--

CREATE TABLE `llx_extrafields` (
  `rowid` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `elementtype` varchar(64) NOT NULL DEFAULT 'member',
  `label` varchar(255) NOT NULL,
  `type` varchar(8) DEFAULT NULL,
  `size` varchar(8) DEFAULT NULL,
  `fieldcomputed` text DEFAULT NULL,
  `fielddefault` varchar(255) DEFAULT NULL,
  `fieldunique` int(11) DEFAULT 0,
  `fieldrequired` int(11) DEFAULT 0,
  `perms` varchar(255) DEFAULT NULL,
  `enabled` varchar(255) DEFAULT NULL,
  `pos` int(11) DEFAULT 0,
  `alwayseditable` int(11) DEFAULT 0,
  `param` text DEFAULT NULL,
  `list` varchar(255) DEFAULT '1',
  `printable` int(11) DEFAULT 0,
  `totalizable` tinyint(1) DEFAULT 0,
  `langs` varchar(64) DEFAULT NULL,
  `help` text DEFAULT NULL,
  `css` varchar(128) DEFAULT NULL,
  `cssview` varchar(128) DEFAULT NULL,
  `csslist` varchar(128) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture`
--

CREATE TABLE `llx_facture` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(255) DEFAULT NULL,
  `ref_int` varchar(255) DEFAULT NULL,
  `ref_client` varchar(255) DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT 0,
  `fk_soc` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `datef` date DEFAULT NULL,
  `date_pointoftax` date DEFAULT NULL,
  `date_valid` date DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_closing` datetime DEFAULT NULL,
  `paye` smallint(6) NOT NULL DEFAULT 0,
  `remise_percent` double DEFAULT 0,
  `remise_absolue` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `close_code` varchar(16) DEFAULT NULL,
  `close_missing_amount` double(24,8) DEFAULT NULL,
  `close_note` varchar(128) DEFAULT NULL,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `localtax1` double(24,8) DEFAULT 0.00000000,
  `localtax2` double(24,8) DEFAULT 0.00000000,
  `revenuestamp` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `fk_statut` smallint(6) NOT NULL DEFAULT 0,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_closing` int(11) DEFAULT NULL,
  `module_source` varchar(32) DEFAULT NULL,
  `pos_source` varchar(32) DEFAULT NULL,
  `fk_fac_rec_source` int(11) DEFAULT NULL,
  `fk_facture_source` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `increment` varchar(10) DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_currency` varchar(3) DEFAULT NULL,
  `fk_cond_reglement` int(11) NOT NULL DEFAULT 1,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `date_lim_reglement` date DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) DEFAULT NULL,
  `fk_transport_mode` int(11) DEFAULT NULL,
  `situation_cycle_ref` smallint(6) DEFAULT NULL,
  `situation_counter` smallint(6) DEFAULT NULL,
  `situation_final` smallint(6) DEFAULT NULL,
  `retained_warranty` double DEFAULT NULL,
  `retained_warranty_date_limit` date DEFAULT NULL,
  `retained_warranty_fk_cond_reglement` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facturedet`
--

CREATE TABLE `llx_facturedet` (
  `rowid` int(11) NOT NULL,
  `fk_facture` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT NULL,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `fk_remise_except` int(11) DEFAULT NULL,
  `subprice` double(24,8) DEFAULT NULL,
  `price` double(24,8) DEFAULT NULL,
  `total_ht` double(24,8) DEFAULT NULL,
  `total_tva` double(24,8) DEFAULT NULL,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT NULL,
  `product_type` int(11) DEFAULT 0,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT 0,
  `buy_price_ht` double(24,8) DEFAULT 0.00000000,
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(11) DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `fk_contract_line` int(11) DEFAULT NULL,
  `fk_unit` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `fk_code_ventilation` int(11) NOT NULL DEFAULT 0,
  `situation_percent` double DEFAULT 100,
  `fk_prev_id` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000,
  `ref_ext` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facturedet_extrafields`
--

CREATE TABLE `llx_facturedet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facturedet_rec`
--

CREATE TABLE `llx_facturedet_rec` (
  `rowid` int(11) NOT NULL,
  `fk_facture` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `product_type` int(11) DEFAULT 0,
  `label` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT NULL,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `subprice` double(24,8) DEFAULT NULL,
  `price` double(24,8) DEFAULT NULL,
  `total_ht` double(24,8) DEFAULT NULL,
  `total_tva` double(24,8) DEFAULT NULL,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT NULL,
  `date_start_fill` int(11) DEFAULT 0,
  `date_end_fill` int(11) DEFAULT 0,
  `info_bits` int(11) DEFAULT 0,
  `buy_price_ht` double(24,8) DEFAULT 0.00000000,
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(10) UNSIGNED DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `fk_contract_line` int(11) DEFAULT NULL,
  `fk_unit` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facturedet_rec_extrafields`
--

CREATE TABLE `llx_facturedet_rec_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_extrafields`
--

CREATE TABLE `llx_facture_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_fourn`
--

CREATE TABLE `llx_facture_fourn` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(180) NOT NULL,
  `ref_supplier` varchar(180) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(255) DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT 0,
  `fk_soc` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `datef` date DEFAULT NULL,
  `date_pointoftax` date DEFAULT NULL,
  `date_valid` date DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_closing` datetime DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `paye` smallint(6) NOT NULL DEFAULT 0,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `remise` double(24,8) DEFAULT 0.00000000,
  `close_code` varchar(16) DEFAULT NULL,
  `close_missing_amount` double(24,8) DEFAULT NULL,
  `close_note` varchar(128) DEFAULT NULL,
  `tva` double(24,8) DEFAULT 0.00000000,
  `localtax1` double(24,8) DEFAULT 0.00000000,
  `localtax2` double(24,8) DEFAULT 0.00000000,
  `total` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `fk_statut` smallint(6) NOT NULL DEFAULT 0,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_closing` int(11) DEFAULT NULL,
  `fk_fac_rec_source` int(11) DEFAULT NULL,
  `fk_facture_source` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `date_lim_reglement` date DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) DEFAULT NULL,
  `fk_transport_mode` int(11) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_fourn_det`
--

CREATE TABLE `llx_facture_fourn_det` (
  `rowid` int(11) NOT NULL,
  `fk_facture_fourn` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pu_ht` double(24,8) DEFAULT NULL,
  `pu_ttc` double(24,8) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT 0,
  `fk_remise_except` int(11) DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT NULL,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `total_ht` double(24,8) DEFAULT NULL,
  `tva` double(24,8) DEFAULT NULL,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT NULL,
  `product_type` int(11) DEFAULT 0,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT 0,
  `fk_code_ventilation` int(11) NOT NULL DEFAULT 0,
  `special_code` int(11) DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `import_key` varchar(14) DEFAULT NULL,
  `fk_unit` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_fourn_det_extrafields`
--

CREATE TABLE `llx_facture_fourn_det_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_fourn_det_rec`
--

CREATE TABLE `llx_facture_fourn_det_rec` (
  `rowid` int(11) NOT NULL,
  `fk_facture_fourn` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pu_ht` double(24,8) DEFAULT NULL,
  `pu_ttc` double(24,8) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT 0,
  `fk_remise_except` int(11) DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT NULL,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `total_ht` double(24,8) DEFAULT NULL,
  `total_tva` double(24,8) DEFAULT NULL,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT NULL,
  `product_type` int(11) DEFAULT 0,
  `date_start` int(11) DEFAULT NULL,
  `date_end` int(11) DEFAULT NULL,
  `info_bits` int(11) DEFAULT 0,
  `special_code` int(10) UNSIGNED DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `fk_unit` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_fourn_det_rec_extrafields`
--

CREATE TABLE `llx_facture_fourn_det_rec_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_fourn_extrafields`
--

CREATE TABLE `llx_facture_fourn_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_fourn_rec`
--

CREATE TABLE `llx_facture_fourn_rec` (
  `rowid` int(11) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `ref_supplier` varchar(180) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `suspended` int(11) DEFAULT 0,
  `libelle` varchar(255) DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `remise` double DEFAULT 0,
  `vat_src_code` varchar(10) DEFAULT '',
  `localtax1` double(24,8) DEFAULT 0.00000000,
  `localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `date_lim_reglement` date DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `modelpdf` varchar(255) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000,
  `usenewprice` int(11) DEFAULT 0,
  `frequency` int(11) DEFAULT NULL,
  `unit_frequency` varchar(2) DEFAULT 'm',
  `date_when` datetime DEFAULT NULL,
  `date_last_gen` datetime DEFAULT NULL,
  `nb_gen_done` int(11) DEFAULT NULL,
  `nb_gen_max` int(11) DEFAULT NULL,
  `auto_validate` int(11) DEFAULT 0,
  `generate_pdf` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_fourn_rec_extrafields`
--

CREATE TABLE `llx_facture_fourn_rec_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_rec`
--

CREATE TABLE `llx_facture_rec` (
  `rowid` int(11) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `suspended` int(11) DEFAULT 0,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `remise` double DEFAULT 0,
  `remise_percent` double DEFAULT 0,
  `remise_absolue` double DEFAULT 0,
  `vat_src_code` varchar(10) DEFAULT '',
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `localtax1` double(24,8) DEFAULT 0.00000000,
  `localtax2` double(24,8) DEFAULT 0.00000000,
  `revenuestamp` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_cond_reglement` int(11) NOT NULL DEFAULT 1,
  `fk_mode_reglement` int(11) DEFAULT 0,
  `date_lim_reglement` date DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `modelpdf` varchar(255) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000,
  `usenewprice` int(11) DEFAULT 0,
  `frequency` int(11) DEFAULT NULL,
  `unit_frequency` varchar(2) DEFAULT 'm',
  `date_when` datetime DEFAULT NULL,
  `date_last_gen` datetime DEFAULT NULL,
  `nb_gen_done` int(11) DEFAULT NULL,
  `nb_gen_max` int(11) DEFAULT NULL,
  `auto_validate` int(11) DEFAULT 0,
  `generate_pdf` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_facture_rec_extrafields`
--

CREATE TABLE `llx_facture_rec_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_fichinter`
--

CREATE TABLE `llx_fichinter` (
  `rowid` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT 0,
  `fk_contrat` int(11) DEFAULT 0,
  `ref` varchar(30) NOT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `ref_client` varchar(255) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `datei` date DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT 0,
  `dateo` date DEFAULT NULL,
  `datee` date DEFAULT NULL,
  `datet` date DEFAULT NULL,
  `duree` double DEFAULT NULL,
  `description` text DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_fichinterdet`
--

CREATE TABLE `llx_fichinterdet` (
  `rowid` int(11) NOT NULL,
  `fk_fichinter` int(11) DEFAULT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `rang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_fichinterdet_extrafields`
--

CREATE TABLE `llx_fichinterdet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_fichinterdet_rec`
--

CREATE TABLE `llx_fichinterdet_rec` (
  `rowid` int(11) NOT NULL,
  `fk_fichinter` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `rang` int(11) DEFAULT 0,
  `total_ht` double(24,8) DEFAULT NULL,
  `subprice` double(24,8) DEFAULT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `tva_tx` double(6,3) DEFAULT NULL,
  `localtax1_tx` double(6,3) DEFAULT 0.000,
  `localtax1_type` varchar(1) DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT 0.000,
  `localtax2_type` varchar(1) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `fk_remise_except` int(11) DEFAULT NULL,
  `price` double(24,8) DEFAULT NULL,
  `total_tva` double(24,8) DEFAULT NULL,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT NULL,
  `product_type` int(11) DEFAULT 0,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT 0,
  `buy_price_ht` double(24,8) DEFAULT 0.00000000,
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `fk_code_ventilation` int(11) NOT NULL DEFAULT 0,
  `fk_export_commpta` int(11) NOT NULL DEFAULT 0,
  `special_code` int(10) UNSIGNED DEFAULT 0,
  `fk_unit` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_fichinter_extrafields`
--

CREATE TABLE `llx_fichinter_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_fichinter_rec`
--

CREATE TABLE `llx_fichinter_rec` (
  `rowid` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `fk_contrat` int(11) DEFAULT 0,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `duree` double DEFAULT NULL,
  `description` text DEFAULT NULL,
  `modelpdf` varchar(50) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `frequency` int(11) DEFAULT NULL,
  `unit_frequency` varchar(2) DEFAULT 'm',
  `date_when` datetime DEFAULT NULL,
  `date_last_gen` datetime DEFAULT NULL,
  `nb_gen_done` int(11) DEFAULT NULL,
  `nb_gen_max` int(11) DEFAULT NULL,
  `auto_validate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_holiday`
--

CREATE TABLE `llx_holiday` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_user` int(11) NOT NULL,
  `fk_user_create` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_type` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `halfday` int(11) DEFAULT 0,
  `nb_open_day` double(24,8) DEFAULT NULL,
  `statut` int(11) NOT NULL DEFAULT 1,
  `fk_validator` int(11) NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `date_approve` datetime DEFAULT NULL,
  `fk_user_approve` int(11) DEFAULT NULL,
  `date_refuse` datetime DEFAULT NULL,
  `fk_user_refuse` int(11) DEFAULT NULL,
  `date_cancel` datetime DEFAULT NULL,
  `fk_user_cancel` int(11) DEFAULT NULL,
  `detail_refuse` varchar(250) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_holiday_config`
--

CREATE TABLE `llx_holiday_config` (
  `rowid` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_holiday_extrafields`
--

CREATE TABLE `llx_holiday_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_holiday_logs`
--

CREATE TABLE `llx_holiday_logs` (
  `rowid` int(11) NOT NULL,
  `date_action` datetime NOT NULL,
  `fk_user_action` int(11) NOT NULL,
  `fk_user_update` int(11) NOT NULL,
  `fk_type` int(11) NOT NULL,
  `type_action` varchar(255) NOT NULL,
  `prev_solde` varchar(255) NOT NULL,
  `new_solde` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_holiday_users`
--

CREATE TABLE `llx_holiday_users` (
  `fk_user` int(11) NOT NULL,
  `fk_type` int(11) NOT NULL,
  `nb_holiday` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_import_model`
--

CREATE TABLE `llx_import_model` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 0,
  `fk_user` int(11) NOT NULL DEFAULT 0,
  `label` varchar(50) NOT NULL,
  `type` varchar(64) NOT NULL,
  `field` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_inventory`
--

CREATE TABLE `llx_inventory` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT 0,
  `ref` varchar(48) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `date_inventory` datetime DEFAULT NULL,
  `date_validation` datetime DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_inventorydet`
--

CREATE TABLE `llx_inventorydet` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_inventory` int(11) DEFAULT 0,
  `fk_warehouse` int(11) DEFAULT 0,
  `fk_product` int(11) DEFAULT 0,
  `batch` varchar(128) DEFAULT NULL,
  `qty_stock` double DEFAULT NULL,
  `qty_view` double DEFAULT NULL,
  `qty_regulated` double DEFAULT NULL,
  `pmp_real` double DEFAULT NULL,
  `pmp_expected` double DEFAULT NULL,
  `fk_movement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_inventory_extrafields`
--

CREATE TABLE `llx_inventory_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_knowledgemanagement_knowledgerecord`
--

CREATE TABLE `llx_knowledgemanagement_knowledgerecord` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref` varchar(128) NOT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_main_doc` varchar(255) DEFAULT NULL,
  `lang` varchar(6) DEFAULT NULL,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `question` text NOT NULL,
  `answer` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `fk_ticket` int(11) DEFAULT NULL,
  `fk_c_ticket_category` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_knowledgemanagement_knowledgerecord_extrafields`
--

CREATE TABLE `llx_knowledgemanagement_knowledgerecord_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_links`
--

CREATE TABLE `llx_links` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datea` datetime NOT NULL,
  `url` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `objecttype` varchar(255) NOT NULL,
  `objectid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_localtax`
--

CREATE TABLE `llx_localtax` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `localtaxtype` tinyint(4) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datep` date DEFAULT NULL,
  `datev` date DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `fk_bank` int(11) DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_mailing`
--

CREATE TABLE `llx_mailing` (
  `rowid` int(11) NOT NULL,
  `statut` smallint(6) DEFAULT 0,
  `titre` varchar(128) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `sujet` varchar(128) DEFAULT NULL,
  `body` mediumtext DEFAULT NULL,
  `bgcolor` varchar(8) DEFAULT NULL,
  `bgimage` varchar(255) DEFAULT NULL,
  `cible` varchar(60) DEFAULT NULL,
  `nbemail` int(11) DEFAULT NULL,
  `email_from` varchar(160) DEFAULT NULL,
  `email_replyto` varchar(160) DEFAULT NULL,
  `email_errorsto` varchar(160) DEFAULT NULL,
  `tag` varchar(128) DEFAULT NULL,
  `date_creat` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_appro` datetime DEFAULT NULL,
  `date_envoi` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_appro` int(11) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `joined_file1` varchar(255) DEFAULT NULL,
  `joined_file2` varchar(255) DEFAULT NULL,
  `joined_file3` varchar(255) DEFAULT NULL,
  `joined_file4` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_mailing_advtarget`
--

CREATE TABLE `llx_mailing_advtarget` (
  `rowid` int(11) NOT NULL,
  `name` varchar(180) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_element` int(11) NOT NULL,
  `type_element` varchar(180) NOT NULL,
  `filtervalue` text DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL,
  `datec` datetime NOT NULL,
  `fk_user_mod` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_mailing_cibles`
--

CREATE TABLE `llx_mailing_cibles` (
  `rowid` int(11) NOT NULL,
  `fk_mailing` int(11) NOT NULL,
  `fk_contact` int(11) NOT NULL,
  `lastname` varchar(160) DEFAULT NULL,
  `firstname` varchar(160) DEFAULT NULL,
  `email` varchar(160) NOT NULL,
  `other` varchar(255) DEFAULT NULL,
  `tag` varchar(64) DEFAULT NULL,
  `statut` smallint(6) NOT NULL DEFAULT 0,
  `source_url` varchar(255) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `source_type` varchar(16) DEFAULT NULL,
  `date_envoi` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `error_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_mailing_unsubscribe`
--

CREATE TABLE `llx_mailing_unsubscribe` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `unsubscribegroup` varchar(128) DEFAULT '',
  `ip` varchar(128) DEFAULT NULL,
  `date_creat` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_menu`
--

CREATE TABLE `llx_menu` (
  `rowid` int(11) NOT NULL,
  `menu_handler` varchar(16) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `module` varchar(255) DEFAULT NULL,
  `type` varchar(4) NOT NULL,
  `mainmenu` varchar(100) NOT NULL,
  `leftmenu` varchar(100) DEFAULT NULL,
  `fk_menu` int(11) NOT NULL,
  `fk_mainmenu` varchar(100) DEFAULT NULL,
  `fk_leftmenu` varchar(100) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target` varchar(100) DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `langs` varchar(100) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `perms` text DEFAULT NULL,
  `enabled` text DEFAULT NULL,
  `usertype` int(11) NOT NULL DEFAULT 0,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_mrp_mo`
--

CREATE TABLE `llx_mrp_mo` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref` varchar(128) NOT NULL DEFAULT '(PROV)',
  `mrptype` int(11) DEFAULT 0,
  `label` varchar(255) DEFAULT NULL,
  `qty` double NOT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `date_start_planned` datetime DEFAULT NULL,
  `date_end_planned` datetime DEFAULT NULL,
  `fk_bom` int(11) DEFAULT NULL,
  `fk_project` int(11) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `fk_parent_line` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_mrp_mo_extrafields`
--

CREATE TABLE `llx_mrp_mo_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_mrp_production`
--

CREATE TABLE `llx_mrp_production` (
  `rowid` int(11) NOT NULL,
  `fk_mo` int(11) NOT NULL,
  `origin_id` int(11) DEFAULT NULL,
  `origin_type` varchar(10) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `fk_product` int(11) NOT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `qty` double NOT NULL DEFAULT 1,
  `qty_frozen` smallint(6) DEFAULT 0,
  `disable_stock_change` smallint(6) DEFAULT 0,
  `batch` varchar(128) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `fk_mrp_production` int(11) DEFAULT NULL,
  `fk_stock_movement` int(11) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_multicurrency`
--

CREATE TABLE `llx_multicurrency` (
  `rowid` int(11) NOT NULL,
  `date_create` datetime DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `entity` int(11) DEFAULT 1,
  `fk_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_multicurrency_rate`
--

CREATE TABLE `llx_multicurrency_rate` (
  `rowid` int(11) NOT NULL,
  `date_sync` datetime DEFAULT NULL,
  `rate` double NOT NULL DEFAULT 0,
  `fk_multicurrency` int(11) NOT NULL,
  `entity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_notify`
--

CREATE TABLE `llx_notify` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `daten` datetime DEFAULT NULL,
  `fk_action` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_contact` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `type` varchar(16) DEFAULT 'email',
  `type_target` varchar(16) DEFAULT NULL,
  `objet_type` varchar(24) NOT NULL,
  `objet_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_notify_def`
--

CREATE TABLE `llx_notify_def` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` date DEFAULT NULL,
  `fk_action` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_contact` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `type` varchar(16) DEFAULT 'email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_notify_def_object`
--

CREATE TABLE `llx_notify_def_object` (
  `id` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `objet_type` varchar(16) DEFAULT NULL,
  `objet_id` int(11) NOT NULL,
  `type_notif` varchar(16) DEFAULT 'browser',
  `date_notif` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `moreparam` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_oauth_state`
--

CREATE TABLE `llx_oauth_state` (
  `rowid` int(11) NOT NULL,
  `service` varchar(36) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_adherent` int(11) DEFAULT NULL,
  `entity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_oauth_token`
--

CREATE TABLE `llx_oauth_token` (
  `rowid` int(11) NOT NULL,
  `service` varchar(36) DEFAULT NULL,
  `token` text DEFAULT NULL,
  `tokenstring` text DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_adherent` int(11) DEFAULT NULL,
  `restricted_ips` varchar(200) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `entity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_object_lang`
--

CREATE TABLE `llx_object_lang` (
  `rowid` int(11) NOT NULL,
  `fk_object` int(11) NOT NULL DEFAULT 0,
  `type_object` varchar(32) NOT NULL,
  `property` varchar(32) NOT NULL,
  `lang` varchar(5) NOT NULL DEFAULT '',
  `value` text DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_onlinesignature`
--

CREATE TABLE `llx_onlinesignature` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `object_type` varchar(32) NOT NULL,
  `object_id` int(11) NOT NULL,
  `datec` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) NOT NULL,
  `ip` varchar(128) DEFAULT NULL,
  `pathoffile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_overwrite_trans`
--

CREATE TABLE `llx_overwrite_trans` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `lang` varchar(5) DEFAULT NULL,
  `transkey` varchar(128) DEFAULT NULL,
  `transvalue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_paiement`
--

CREATE TABLE `llx_paiement` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) DEFAULT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `multicurrency_amount` double(24,8) DEFAULT 0.00000000,
  `fk_paiement` int(11) NOT NULL,
  `num_paiement` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `ext_payment_id` varchar(255) DEFAULT NULL,
  `ext_payment_site` varchar(128) DEFAULT NULL,
  `fk_bank` int(11) NOT NULL DEFAULT 0,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `statut` smallint(6) NOT NULL DEFAULT 0,
  `fk_export_compta` int(11) NOT NULL DEFAULT 0,
  `pos_change` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_paiementcharge`
--

CREATE TABLE `llx_paiementcharge` (
  `rowid` int(11) NOT NULL,
  `fk_charge` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `fk_typepaiement` int(11) NOT NULL,
  `num_paiement` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `fk_bank` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_paiementfourn`
--

CREATE TABLE `llx_paiementfourn` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) DEFAULT NULL,
  `entity` int(11) DEFAULT 1,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `multicurrency_amount` double(24,8) DEFAULT 0.00000000,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_paiement` int(11) NOT NULL,
  `num_paiement` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `fk_bank` int(11) NOT NULL,
  `statut` smallint(6) NOT NULL DEFAULT 0,
  `model_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_paiementfourn_facturefourn`
--

CREATE TABLE `llx_paiementfourn_facturefourn` (
  `rowid` int(11) NOT NULL,
  `fk_paiementfourn` int(11) DEFAULT NULL,
  `fk_facturefourn` int(11) DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_amount` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_paiement_facture`
--

CREATE TABLE `llx_paiement_facture` (
  `rowid` int(11) NOT NULL,
  `fk_paiement` int(11) DEFAULT NULL,
  `fk_facture` int(11) DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_amount` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_bdpParameters`
--

CREATE TABLE `llx_Paie_bdpParameters` (
  `id` int(11) NOT NULL,
  `cnss` float DEFAULT NULL,
  `patronaleCnss` float DEFAULT NULL,
  `amo` float DEFAULT NULL,
  `patronaleAmo` float DEFAULT NULL,
  `fp` float DEFAULT NULL,
  `TaxFormationPro` float DEFAULT NULL,
  `prestationFamilial` float DEFAULT NULL,
  `maxCNSS` float DEFAULT NULL,
  `maxFraitPro` float DEFAULT NULL,
  `maxFreeTransport` float DEFAULT NULL,
  `maxChildrens` int(11) DEFAULT NULL,
  `primDenfan` float DEFAULT NULL,
  `smigHoraire` float DEFAULT NULL,
  `hoursMonsuele` int(11) DEFAULT NULL,
  `workingDays` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_EtatRubs`
--

CREATE TABLE `llx_Paie_EtatRubs` (
  `id` int(11) NOT NULL,
  `cnssSalariale` float DEFAULT NULL,
  `cnssPatronale` float DEFAULT NULL,
  `amoSalariale` float DEFAULT NULL,
  `amoPatronale` float DEFAULT NULL,
  `indemRepr` float DEFAULT NULL,
  `indemTrans` float DEFAULT NULL,
  `taxePro` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_HourSupp`
--

CREATE TABLE `llx_Paie_HourSupp` (
  `rub` int(11) NOT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `codeComptable` int(11) DEFAULT NULL,
  `percentHourSupp` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_HourSuppDeclaration`
--

CREATE TABLE `llx_Paie_HourSuppDeclaration` (
  `userid` int(11) NOT NULL,
  `rub` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `nhours` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_IRParameters`
--

CREATE TABLE `llx_Paie_IRParameters` (
  `id` int(11) NOT NULL,
  `irmin` float DEFAULT NULL,
  `irmax` varchar(10) DEFAULT NULL,
  `percentIR` float DEFAULT NULL,
  `deduction` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_MonthDeclaration`
--

CREATE TABLE `llx_Paie_MonthDeclaration` (
  `userid` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `workingDays` float DEFAULT NULL,
  `workingHours` int(11) DEFAULT NULL,
  `salaireBrut` float DEFAULT NULL,
  `salaireNet` float DEFAULT NULL,
  `netImposable` float DEFAULT NULL,
  `ir` float DEFAULT NULL,
  `arrondi` float DEFAULT NULL,
  `cloture` int(11) DEFAULT NULL,
  `joursferie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_MonthDeclarationRubs`
--

CREATE TABLE `llx_Paie_MonthDeclarationRubs` (
  `userid` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `post` varchar(50) DEFAULT NULL,
  `situationFamiliale` varchar(50) DEFAULT NULL,
  `enfants` int(11) DEFAULT NULL,
  `salaireDeBase` float DEFAULT NULL,
  `salaireMensuel` float DEFAULT NULL,
  `salaireHoraire` float DEFAULT NULL,
  `rubs` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_PrimDancienParameters`
--

CREATE TABLE `llx_Paie_PrimDancienParameters` (
  `id` int(11) NOT NULL,
  `de` float DEFAULT NULL,
  `a` varchar(10) DEFAULT NULL,
  `percentPrimDancien` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_Rub`
--

CREATE TABLE `llx_Paie_Rub` (
  `rub` int(11) NOT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `codeComptable` int(11) DEFAULT NULL,
  `cotisation` tinyint(1) DEFAULT NULL,
  `calcule` tinyint(1) DEFAULT NULL,
  `base` varchar(50) DEFAULT NULL,
  `percentage` float DEFAULT NULL,
  `imposable` tinyint(1) DEFAULT NULL,
  `partiel` tinyint(1) DEFAULT NULL,
  `maxFree` float DEFAULT NULL,
  `plafonne` tinyint(1) DEFAULT NULL,
  `plafond` float DEFAULT NULL,
  `enBrut` tinyint(1) DEFAULT NULL,
  `enJours` tinyint(1) DEFAULT NULL,
  `avecConge` tinyint(1) DEFAULT NULL,
  `auFiche` tinyint(1) DEFAULT NULL,
  `surBulletin` tinyint(1) DEFAULT NULL,
  `enNetImposable` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_Rubriques`
--

CREATE TABLE `llx_Paie_Rubriques` (
  `rub` int(11) NOT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `codeComptable` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_UserInfo`
--

CREATE TABLE `llx_Paie_UserInfo` (
  `userid` int(11) NOT NULL,
  `cnss` varchar(50) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `mutuelle` varchar(50) DEFAULT NULL,
  `cimr` varchar(50) DEFAULT NULL,
  `mode_paiement` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_Paie_UserParameters`
--

CREATE TABLE `llx_Paie_UserParameters` (
  `userid` int(11) NOT NULL,
  `rub` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `checked` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_partnership`
--

CREATE TABLE `llx_partnership` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) NOT NULL DEFAULT '(PROV)',
  `status` smallint(6) NOT NULL DEFAULT 0,
  `fk_type` int(11) NOT NULL DEFAULT 0,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_member` int(11) DEFAULT NULL,
  `date_partnership_start` date NOT NULL,
  `date_partnership_end` date DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `reason_decline_or_cancel` text DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `fk_user_creat` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_modif` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `url_to_check` varchar(255) DEFAULT NULL,
  `count_last_url_check_error` int(11) DEFAULT 0,
  `last_check_backlink` datetime DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_partnership_extrafields`
--

CREATE TABLE `llx_partnership_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_payment_donation`
--

CREATE TABLE `llx_payment_donation` (
  `rowid` int(11) NOT NULL,
  `fk_donation` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `ext_payment_id` varchar(255) DEFAULT NULL,
  `ext_payment_site` varchar(128) DEFAULT NULL,
  `fk_bank` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_payment_expensereport`
--

CREATE TABLE `llx_payment_expensereport` (
  `rowid` int(11) NOT NULL,
  `fk_expensereport` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `fk_bank` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_payment_loan`
--

CREATE TABLE `llx_payment_loan` (
  `rowid` int(11) NOT NULL,
  `fk_loan` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datep` datetime DEFAULT NULL,
  `amount_capital` double(24,8) DEFAULT 0.00000000,
  `amount_insurance` double(24,8) DEFAULT 0.00000000,
  `amount_interest` double(24,8) DEFAULT 0.00000000,
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `fk_bank` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_payment_salary`
--

CREATE TABLE `llx_payment_salary` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `datep` date DEFAULT NULL,
  `datev` date DEFAULT NULL,
  `salary` double(24,8) DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `datesp` date DEFAULT NULL,
  `dateep` date DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `note` text DEFAULT NULL,
  `fk_bank` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_salary` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_payment_salary_extrafields`
--

CREATE TABLE `llx_payment_salary_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `situation` varchar(255) DEFAULT NULL,
  `enfants` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_payment_various`
--

CREATE TABLE `llx_payment_various` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) DEFAULT NULL,
  `num_payment` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `datep` date DEFAULT NULL,
  `datev` date DEFAULT NULL,
  `sens` smallint(6) NOT NULL DEFAULT 0,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `fk_typepayment` int(11) NOT NULL,
  `accountancy_code` varchar(32) DEFAULT NULL,
  `subledger_account` varchar(32) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `note` text DEFAULT NULL,
  `fk_bank` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_payment_vat`
--

CREATE TABLE `llx_payment_vat` (
  `rowid` int(11) NOT NULL,
  `fk_tva` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `fk_typepaiement` int(11) NOT NULL,
  `num_paiement` varchar(50) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `fk_bank` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_pos_cash_fence`
--

CREATE TABLE `llx_pos_cash_fence` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref` varchar(64) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `opening` double(24,8) DEFAULT 0.00000000,
  `cash` double(24,8) DEFAULT 0.00000000,
  `card` double(24,8) DEFAULT 0.00000000,
  `cheque` double(24,8) DEFAULT 0.00000000,
  `status` int(11) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `day_close` int(11) DEFAULT NULL,
  `month_close` int(11) DEFAULT NULL,
  `year_close` int(11) DEFAULT NULL,
  `posmodule` varchar(30) DEFAULT NULL,
  `posnumber` varchar(30) DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_prelevement_bons`
--

CREATE TABLE `llx_prelevement_bons` (
  `rowid` int(11) NOT NULL,
  `type` varchar(16) DEFAULT 'debit-order',
  `ref` varchar(12) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datec` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `statut` smallint(6) DEFAULT 0,
  `credite` smallint(6) DEFAULT 0,
  `note` text DEFAULT NULL,
  `date_trans` datetime DEFAULT NULL,
  `method_trans` smallint(6) DEFAULT NULL,
  `fk_user_trans` int(11) DEFAULT NULL,
  `date_credit` datetime DEFAULT NULL,
  `fk_user_credit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_prelevement_facture`
--

CREATE TABLE `llx_prelevement_facture` (
  `rowid` int(11) NOT NULL,
  `fk_facture` int(11) DEFAULT NULL,
  `fk_facture_fourn` int(11) DEFAULT NULL,
  `fk_prelevement_lignes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_prelevement_facture_demande`
--

CREATE TABLE `llx_prelevement_facture_demande` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_facture` int(11) DEFAULT NULL,
  `fk_facture_fourn` int(11) DEFAULT NULL,
  `sourcetype` varchar(32) DEFAULT NULL,
  `amount` double(24,8) NOT NULL,
  `date_demande` datetime NOT NULL,
  `traite` smallint(6) DEFAULT 0,
  `date_traite` datetime DEFAULT NULL,
  `fk_prelevement_bons` int(11) DEFAULT NULL,
  `fk_user_demande` int(11) NOT NULL,
  `code_banque` varchar(128) DEFAULT NULL,
  `code_guichet` varchar(6) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `cle_rib` varchar(5) DEFAULT NULL,
  `ext_payment_id` varchar(255) DEFAULT NULL,
  `ext_payment_site` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_prelevement_lignes`
--

CREATE TABLE `llx_prelevement_lignes` (
  `rowid` int(11) NOT NULL,
  `fk_prelevement_bons` int(11) DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `statut` smallint(6) DEFAULT 0,
  `client_nom` varchar(255) DEFAULT NULL,
  `amount` double(24,8) DEFAULT 0.00000000,
  `code_banque` varchar(128) DEFAULT NULL,
  `code_guichet` varchar(6) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `cle_rib` varchar(5) DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_prelevement_rejet`
--

CREATE TABLE `llx_prelevement_rejet` (
  `rowid` int(11) NOT NULL,
  `fk_prelevement_lignes` int(11) DEFAULT NULL,
  `date_rejet` datetime DEFAULT NULL,
  `motif` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `fk_user_creation` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `afacturer` tinyint(4) DEFAULT 0,
  `fk_facture` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_printing`
--

CREATE TABLE `llx_printing` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `printer_name` text NOT NULL,
  `printer_location` text NOT NULL,
  `printer_id` varchar(255) NOT NULL,
  `copy` int(11) NOT NULL DEFAULT 1,
  `module` varchar(16) NOT NULL,
  `driver` varchar(16) NOT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product`
--

CREATE TABLE `llx_product` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(128) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_parent` int(11) DEFAULT 0,
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `customcode` varchar(32) DEFAULT NULL,
  `fk_country` int(11) DEFAULT NULL,
  `fk_state` int(11) DEFAULT NULL,
  `price` double(24,8) DEFAULT 0.00000000,
  `price_ttc` double(24,8) DEFAULT 0.00000000,
  `price_min` double(24,8) DEFAULT 0.00000000,
  `price_min_ttc` double(24,8) DEFAULT 0.00000000,
  `price_base_type` varchar(3) DEFAULT 'HT',
  `cost_price` double(24,8) DEFAULT NULL,
  `default_vat_code` varchar(10) DEFAULT NULL,
  `tva_tx` double(7,4) DEFAULT NULL,
  `recuperableonly` int(11) NOT NULL DEFAULT 0,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) NOT NULL DEFAULT '0',
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) NOT NULL DEFAULT '0',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `tosell` tinyint(4) DEFAULT 1,
  `tobuy` tinyint(4) DEFAULT 1,
  `onportal` tinyint(4) DEFAULT 0,
  `tobatch` tinyint(4) NOT NULL DEFAULT 0,
  `batch_mask` varchar(32) DEFAULT NULL,
  `fk_product_type` int(11) DEFAULT 0,
  `duration` varchar(6) DEFAULT NULL,
  `seuil_stock_alerte` float DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `barcode` varchar(180) DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT NULL,
  `accountancy_code_sell` varchar(32) DEFAULT NULL,
  `accountancy_code_sell_intra` varchar(32) DEFAULT NULL,
  `accountancy_code_sell_export` varchar(32) DEFAULT NULL,
  `accountancy_code_buy` varchar(32) DEFAULT NULL,
  `accountancy_code_buy_intra` varchar(32) DEFAULT NULL,
  `accountancy_code_buy_export` varchar(32) DEFAULT NULL,
  `partnumber` varchar(32) DEFAULT NULL,
  `net_measure` float DEFAULT NULL,
  `net_measure_units` tinyint(4) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `weight_units` tinyint(4) DEFAULT NULL,
  `length` float DEFAULT NULL,
  `length_units` tinyint(4) DEFAULT NULL,
  `width` float DEFAULT NULL,
  `width_units` tinyint(4) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `height_units` tinyint(4) DEFAULT NULL,
  `surface` float DEFAULT NULL,
  `surface_units` tinyint(4) DEFAULT NULL,
  `volume` float DEFAULT NULL,
  `volume_units` tinyint(4) DEFAULT NULL,
  `stock` double DEFAULT NULL,
  `pmp` double(24,8) NOT NULL DEFAULT 0.00000000,
  `fifo` double(24,8) DEFAULT NULL,
  `lifo` double(24,8) DEFAULT NULL,
  `fk_default_warehouse` int(11) DEFAULT NULL,
  `canvas` varchar(32) DEFAULT NULL,
  `finished` tinyint(4) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `qc_frequency` int(11) DEFAULT NULL,
  `hidden` tinyint(4) DEFAULT 0,
  `import_key` varchar(14) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `fk_price_expression` int(11) DEFAULT NULL,
  `desiredstock` float DEFAULT 0,
  `fk_unit` int(11) DEFAULT NULL,
  `price_autogen` tinyint(4) DEFAULT 0,
  `fk_project` int(11) DEFAULT NULL,
  `mandatory_period` tinyint(4) DEFAULT 0,
  `fk_default_bom` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_association`
--

CREATE TABLE `llx_product_association` (
  `rowid` int(11) NOT NULL,
  `fk_product_pere` int(11) NOT NULL DEFAULT 0,
  `fk_product_fils` int(11) NOT NULL DEFAULT 0,
  `qty` double DEFAULT NULL,
  `incdec` int(11) DEFAULT 1,
  `rang` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_attribute`
--

CREATE TABLE `llx_product_attribute` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `ref_ext` varchar(255) DEFAULT NULL,
  `label` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `entity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_attribute_combination`
--

CREATE TABLE `llx_product_attribute_combination` (
  `rowid` int(11) NOT NULL,
  `fk_product_parent` int(11) NOT NULL,
  `fk_product_child` int(11) NOT NULL,
  `variation_price` double(24,8) NOT NULL,
  `variation_price_percentage` int(11) DEFAULT NULL,
  `variation_weight` double NOT NULL,
  `variation_ref_ext` varchar(255) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_attribute_combination2val`
--

CREATE TABLE `llx_product_attribute_combination2val` (
  `rowid` int(11) NOT NULL,
  `fk_prod_combination` int(11) NOT NULL,
  `fk_prod_attr` int(11) NOT NULL,
  `fk_prod_attr_val` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_attribute_combination_price_level`
--

CREATE TABLE `llx_product_attribute_combination_price_level` (
  `rowid` int(11) NOT NULL,
  `fk_product_attribute_combination` int(11) NOT NULL DEFAULT 1,
  `fk_price_level` int(11) NOT NULL DEFAULT 1,
  `variation_price` double(24,8) NOT NULL,
  `variation_price_percentage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_attribute_value`
--

CREATE TABLE `llx_product_attribute_value` (
  `rowid` int(11) NOT NULL,
  `fk_product_attribute` int(11) NOT NULL,
  `ref` varchar(180) NOT NULL,
  `value` varchar(255) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_batch`
--

CREATE TABLE `llx_product_batch` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_product_stock` int(11) NOT NULL,
  `eatby` datetime DEFAULT NULL,
  `sellby` datetime DEFAULT NULL,
  `batch` varchar(128) NOT NULL,
  `qty` double NOT NULL DEFAULT 0,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_customer_price`
--

CREATE TABLE `llx_product_customer_price` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_product` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `ref_customer` varchar(128) DEFAULT NULL,
  `price` double(24,8) DEFAULT 0.00000000,
  `price_ttc` double(24,8) DEFAULT 0.00000000,
  `price_min` double(24,8) DEFAULT 0.00000000,
  `price_min_ttc` double(24,8) DEFAULT 0.00000000,
  `price_base_type` varchar(3) DEFAULT 'HT',
  `default_vat_code` varchar(10) DEFAULT NULL,
  `tva_tx` double(7,4) DEFAULT NULL,
  `recuperableonly` int(11) NOT NULL DEFAULT 0,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) NOT NULL DEFAULT '0',
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) NOT NULL DEFAULT '0',
  `fk_user` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_customer_price_log`
--

CREATE TABLE `llx_product_customer_price_log` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datec` datetime DEFAULT NULL,
  `fk_product` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL DEFAULT 0,
  `ref_customer` varchar(30) DEFAULT NULL,
  `price` double(24,8) DEFAULT 0.00000000,
  `price_ttc` double(24,8) DEFAULT 0.00000000,
  `price_min` double(24,8) DEFAULT 0.00000000,
  `price_min_ttc` double(24,8) DEFAULT 0.00000000,
  `price_base_type` varchar(3) DEFAULT 'HT',
  `default_vat_code` varchar(10) DEFAULT NULL,
  `tva_tx` double(7,4) DEFAULT NULL,
  `recuperableonly` int(11) NOT NULL DEFAULT 0,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) NOT NULL DEFAULT '0',
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) NOT NULL DEFAULT '0',
  `fk_user` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_extrafields`
--

CREATE TABLE `llx_product_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_fournisseur_price`
--

CREATE TABLE `llx_product_fournisseur_price` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_product` int(11) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `ref_fourn` varchar(128) DEFAULT NULL,
  `desc_fourn` text DEFAULT NULL,
  `fk_availability` int(11) DEFAULT NULL,
  `price` double(24,8) DEFAULT 0.00000000,
  `quantity` double DEFAULT NULL,
  `remise_percent` double NOT NULL DEFAULT 0,
  `remise` double NOT NULL DEFAULT 0,
  `unitprice` double(24,8) DEFAULT 0.00000000,
  `charges` double(24,8) DEFAULT 0.00000000,
  `default_vat_code` varchar(10) DEFAULT NULL,
  `barcode` varchar(180) DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT NULL,
  `tva_tx` double(7,4) NOT NULL,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) NOT NULL DEFAULT '0',
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) NOT NULL DEFAULT '0',
  `info_bits` int(11) NOT NULL DEFAULT 0,
  `fk_user` int(11) DEFAULT NULL,
  `fk_supplier_price_expression` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `delivery_time_days` int(11) DEFAULT NULL,
  `supplier_reputation` varchar(10) DEFAULT NULL,
  `packaging` double DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_unitprice` double(24,8) DEFAULT NULL,
  `multicurrency_price` double(24,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_fournisseur_price_extrafields`
--

CREATE TABLE `llx_product_fournisseur_price_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_fournisseur_price_log`
--

CREATE TABLE `llx_product_fournisseur_price_log` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `fk_product_fournisseur` int(11) NOT NULL,
  `price` double(24,8) DEFAULT 0.00000000,
  `quantity` double DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_unitprice` double(24,8) DEFAULT NULL,
  `multicurrency_price` double(24,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_lang`
--

CREATE TABLE `llx_product_lang` (
  `rowid` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL DEFAULT 0,
  `lang` varchar(5) NOT NULL DEFAULT '0',
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_lot`
--

CREATE TABLE `llx_product_lot` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT 1,
  `fk_product` int(11) NOT NULL,
  `batch` varchar(128) DEFAULT NULL,
  `eatby` date DEFAULT NULL,
  `sellby` date DEFAULT NULL,
  `eol_date` datetime DEFAULT NULL,
  `manufacturing_date` datetime DEFAULT NULL,
  `scrapping_date` datetime DEFAULT NULL,
  `barcode` varchar(180) DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_lot_extrafields`
--

CREATE TABLE `llx_product_lot_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_price`
--

CREATE TABLE `llx_product_price` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_product` int(11) NOT NULL,
  `date_price` datetime NOT NULL,
  `price_level` smallint(6) DEFAULT 1,
  `price` double(24,8) DEFAULT NULL,
  `price_ttc` double(24,8) DEFAULT NULL,
  `price_min` double(24,8) DEFAULT NULL,
  `price_min_ttc` double(24,8) DEFAULT NULL,
  `price_base_type` varchar(3) DEFAULT 'HT',
  `default_vat_code` varchar(10) DEFAULT NULL,
  `tva_tx` double(7,4) NOT NULL DEFAULT 0.0000,
  `recuperableonly` int(11) NOT NULL DEFAULT 0,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) NOT NULL DEFAULT '0',
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) NOT NULL DEFAULT '0',
  `fk_user_author` int(11) DEFAULT NULL,
  `tosell` tinyint(4) DEFAULT 1,
  `price_by_qty` int(11) NOT NULL DEFAULT 0,
  `fk_price_expression` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_price` double(24,8) DEFAULT NULL,
  `multicurrency_price_ttc` double(24,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_pricerules`
--

CREATE TABLE `llx_product_pricerules` (
  `rowid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `fk_level` int(11) NOT NULL,
  `var_percent` double NOT NULL,
  `var_min_percent` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_price_by_qty`
--

CREATE TABLE `llx_product_price_by_qty` (
  `rowid` int(11) NOT NULL,
  `fk_product_price` int(11) NOT NULL,
  `price` double(24,8) DEFAULT 0.00000000,
  `price_base_type` varchar(3) DEFAULT 'HT',
  `quantity` double DEFAULT NULL,
  `remise_percent` double NOT NULL DEFAULT 0,
  `remise` double NOT NULL DEFAULT 0,
  `unitprice` double(24,8) DEFAULT 0.00000000,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_price` double(24,8) DEFAULT NULL,
  `multicurrency_price_ttc` double(24,8) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_stock`
--

CREATE TABLE `llx_product_stock` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_product` int(11) NOT NULL,
  `fk_entrepot` int(11) NOT NULL,
  `reel` double DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_product_warehouse_properties`
--

CREATE TABLE `llx_product_warehouse_properties` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_product` int(11) NOT NULL,
  `fk_entrepot` int(11) NOT NULL,
  `seuil_stock_alerte` float DEFAULT 0,
  `desiredstock` float DEFAULT 0,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_projet`
--

CREATE TABLE `llx_projet` (
  `rowid` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dateo` date DEFAULT NULL,
  `datee` date DEFAULT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `public` int(11) DEFAULT NULL,
  `fk_statut` int(11) NOT NULL DEFAULT 0,
  `fk_opp_status` int(11) DEFAULT NULL,
  `opp_percent` double(5,2) DEFAULT NULL,
  `fk_opp_status_end` int(11) DEFAULT NULL,
  `date_close` datetime DEFAULT NULL,
  `fk_user_close` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `email_msgid` varchar(175) DEFAULT NULL,
  `opp_amount` double(24,8) DEFAULT NULL,
  `budget_amount` double(24,8) DEFAULT NULL,
  `usage_opportunity` int(11) DEFAULT 0,
  `usage_task` int(11) DEFAULT 1,
  `usage_bill_time` int(11) DEFAULT 0,
  `usage_organize_event` int(11) DEFAULT 0,
  `accept_conference_suggestions` int(11) DEFAULT 0,
  `accept_booth_suggestions` int(11) DEFAULT 0,
  `max_attendees` int(11) DEFAULT 0,
  `price_registration` double(24,8) DEFAULT NULL,
  `price_booth` double(24,8) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_projet_extrafields`
--

CREATE TABLE `llx_projet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_projet_task`
--

CREATE TABLE `llx_projet_task` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(50) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_projet` int(11) NOT NULL,
  `fk_task_parent` int(11) NOT NULL DEFAULT 0,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dateo` datetime DEFAULT NULL,
  `datee` datetime DEFAULT NULL,
  `datev` datetime DEFAULT NULL,
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration_effective` double DEFAULT 0,
  `planned_workload` double DEFAULT 0,
  `progress` int(11) DEFAULT 0,
  `priority` int(11) DEFAULT 0,
  `budget_amount` double(24,8) DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) NOT NULL DEFAULT 0,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `rang` int(11) DEFAULT 0,
  `model_pdf` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_projet_task_extrafields`
--

CREATE TABLE `llx_projet_task_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_projet_task_time`
--

CREATE TABLE `llx_projet_task_time` (
  `rowid` int(11) NOT NULL,
  `fk_task` int(11) NOT NULL,
  `task_date` date DEFAULT NULL,
  `task_datehour` datetime DEFAULT NULL,
  `task_date_withhour` int(11) DEFAULT 0,
  `task_duration` double DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `thm` double(24,8) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `invoice_line_id` int(11) DEFAULT NULL,
  `intervention_id` int(11) DEFAULT NULL,
  `intervention_line_id` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_propal`
--

CREATE TABLE `llx_propal` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(255) DEFAULT NULL,
  `ref_int` varchar(255) DEFAULT NULL,
  `ref_client` varchar(255) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `datep` date DEFAULT NULL,
  `fin_validite` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_signature` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_signature` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) NOT NULL DEFAULT 0,
  `price` double DEFAULT 0,
  `remise_percent` double DEFAULT 0,
  `remise_absolue` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `localtax1` double(24,8) DEFAULT 0.00000000,
  `localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `fk_account` int(11) DEFAULT NULL,
  `fk_currency` varchar(3) DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `deposit_percent` varchar(63) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `online_sign_ip` varchar(48) DEFAULT NULL,
  `online_sign_name` varchar(64) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `date_livraison` date DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `fk_availability` int(11) DEFAULT NULL,
  `fk_input_reason` int(11) DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `fk_delivery_address` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_propaldet`
--

CREATE TABLE `llx_propaldet` (
  `rowid` int(11) NOT NULL,
  `fk_propal` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fk_remise_except` int(11) DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `price` double DEFAULT NULL,
  `subprice` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `product_type` int(11) DEFAULT 0,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT 0,
  `buy_price_ht` double(24,8) DEFAULT 0.00000000,
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(11) DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `fk_unit` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_propaldet_extrafields`
--

CREATE TABLE `llx_propaldet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_propal_extrafields`
--

CREATE TABLE `llx_propal_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_propal_merge_pdf_product`
--

CREATE TABLE `llx_propal_merge_pdf_product` (
  `rowid` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `lang` varchar(5) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_mod` int(11) NOT NULL,
  `datec` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_reception`
--

CREATE TABLE `llx_reception` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ref` varchar(30) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `ref_ext` varchar(30) DEFAULT NULL,
  `ref_int` varchar(30) DEFAULT NULL,
  `ref_supplier` varchar(128) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `date_delivery` datetime DEFAULT NULL,
  `date_reception` datetime DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `tracking_number` varchar(50) DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT 0,
  `billed` smallint(6) DEFAULT 0,
  `height` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `size_units` int(11) DEFAULT NULL,
  `size` float DEFAULT NULL,
  `weight_units` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_reception_extrafields`
--

CREATE TABLE `llx_reception_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_recruitment_recruitmentcandidature`
--

CREATE TABLE `llx_recruitment_recruitmentcandidature` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref` varchar(128) NOT NULL DEFAULT '(PROV)',
  `fk_recruitmentjobposition` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `firstname` varchar(128) DEFAULT NULL,
  `lastname` varchar(128) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `remuneration_requested` int(11) DEFAULT NULL,
  `remuneration_proposed` int(11) DEFAULT NULL,
  `email_msgid` varchar(175) DEFAULT NULL,
  `fk_recruitment_origin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_recruitment_recruitmentcandidature_extrafields`
--

CREATE TABLE `llx_recruitment_recruitmentcandidature_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_recruitment_recruitmentjobposition`
--

CREATE TABLE `llx_recruitment_recruitmentjobposition` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) NOT NULL DEFAULT '(PROV)',
  `entity` int(11) NOT NULL DEFAULT 1,
  `label` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_project` int(11) DEFAULT NULL,
  `fk_user_recruiter` int(11) DEFAULT NULL,
  `email_recruiter` varchar(255) DEFAULT NULL,
  `fk_user_supervisor` int(11) DEFAULT NULL,
  `fk_establishment` int(11) DEFAULT NULL,
  `date_planned` date DEFAULT NULL,
  `remuneration_suggested` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_recruitment_recruitmentjobposition_extrafields`
--

CREATE TABLE `llx_recruitment_recruitmentjobposition_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_resource`
--

CREATE TABLE `llx_resource` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref` varchar(255) DEFAULT NULL,
  `asset_number` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fk_code_type_resource` varchar(32) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) NOT NULL DEFAULT 0,
  `note_public` text DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `fk_country` int(11) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_resource_extrafields`
--

CREATE TABLE `llx_resource_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_rights_def`
--

CREATE TABLE `llx_rights_def` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `module` varchar(64) DEFAULT NULL,
  `module_position` int(11) NOT NULL DEFAULT 0,
  `family_position` int(11) NOT NULL DEFAULT 0,
  `entity` int(11) NOT NULL DEFAULT 1,
  `perms` varchar(50) DEFAULT NULL,
  `subperms` varchar(50) DEFAULT NULL,
  `type` varchar(1) DEFAULT NULL,
  `bydefault` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_salary`
--

CREATE TABLE `llx_salary` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `fk_user` int(11) NOT NULL,
  `datep` date DEFAULT NULL,
  `datev` date DEFAULT NULL,
  `salary` double(24,8) DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `datesp` date DEFAULT NULL,
  `dateep` date DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `note` text DEFAULT NULL,
  `fk_bank` int(11) DEFAULT NULL,
  `paye` smallint(6) NOT NULL DEFAULT 0,
  `fk_account` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_salary_extrafields`
--

CREATE TABLE `llx_salary_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_session`
--

CREATE TABLE `llx_session` (
  `session_id` varchar(50) NOT NULL,
  `session_variable` text DEFAULT NULL,
  `last_accessed` datetime NOT NULL,
  `fk_user` int(11) NOT NULL,
  `remote_ip` varchar(64) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe`
--

CREATE TABLE `llx_societe` (
  `rowid` int(11) NOT NULL,
  `nom` varchar(128) DEFAULT NULL,
  `name_alias` varchar(128) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(255) DEFAULT NULL,
  `ref_int` varchar(255) DEFAULT NULL,
  `statut` tinyint(4) DEFAULT 0,
  `parent` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `code_client` varchar(24) DEFAULT NULL,
  `code_fournisseur` varchar(24) DEFAULT NULL,
  `code_compta` varchar(24) DEFAULT NULL,
  `code_compta_fournisseur` varchar(24) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip` varchar(25) DEFAULT NULL,
  `town` varchar(50) DEFAULT NULL,
  `fk_departement` int(11) DEFAULT 0,
  `fk_pays` int(11) DEFAULT 0,
  `fk_account` int(11) DEFAULT 0,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `socialnetworks` text DEFAULT NULL,
  `fk_effectif` int(11) DEFAULT 0,
  `fk_typent` int(11) DEFAULT NULL,
  `fk_forme_juridique` int(11) DEFAULT 0,
  `fk_currency` varchar(3) DEFAULT NULL,
  `siren` varchar(128) DEFAULT NULL,
  `siret` varchar(128) DEFAULT NULL,
  `ape` varchar(128) DEFAULT NULL,
  `idprof4` varchar(128) DEFAULT NULL,
  `idprof5` varchar(128) DEFAULT NULL,
  `idprof6` varchar(128) DEFAULT NULL,
  `tva_intra` varchar(20) DEFAULT NULL,
  `capital` double(24,8) DEFAULT NULL,
  `fk_stcomm` int(11) NOT NULL DEFAULT 0,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `prefix_comm` varchar(5) DEFAULT NULL,
  `client` tinyint(4) DEFAULT 0,
  `fournisseur` tinyint(4) DEFAULT 0,
  `supplier_account` varchar(32) DEFAULT NULL,
  `fk_prospectlevel` varchar(12) DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) DEFAULT NULL,
  `customer_bad` tinyint(4) DEFAULT 0,
  `customer_rate` double DEFAULT 0,
  `supplier_rate` double DEFAULT 0,
  `remise_client` double DEFAULT 0,
  `remise_supplier` double DEFAULT 0,
  `mode_reglement` tinyint(4) DEFAULT NULL,
  `cond_reglement` tinyint(4) DEFAULT NULL,
  `deposit_percent` varchar(63) DEFAULT NULL,
  `transport_mode` tinyint(4) DEFAULT NULL,
  `mode_reglement_supplier` tinyint(4) DEFAULT NULL,
  `cond_reglement_supplier` tinyint(4) DEFAULT NULL,
  `transport_mode_supplier` tinyint(4) DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `tva_assuj` tinyint(4) DEFAULT 1,
  `localtax1_assuj` tinyint(4) DEFAULT 0,
  `localtax1_value` double(7,4) DEFAULT NULL,
  `localtax2_assuj` tinyint(4) DEFAULT 0,
  `localtax2_value` double(7,4) DEFAULT NULL,
  `barcode` varchar(180) DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT 0,
  `price_level` int(11) DEFAULT NULL,
  `outstanding_limit` double(24,8) DEFAULT NULL,
  `order_min_amount` double(24,8) DEFAULT NULL,
  `supplier_order_min_amount` double(24,8) DEFAULT NULL,
  `default_lang` varchar(6) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo_squarred` varchar(255) DEFAULT NULL,
  `canvas` varchar(32) DEFAULT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `webservices_url` varchar(255) DEFAULT NULL,
  `webservices_key` varchar(128) DEFAULT NULL,
  `accountancy_code_sell` varchar(32) DEFAULT NULL,
  `accountancy_code_buy` varchar(32) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_account`
--

CREATE TABLE `llx_societe_account` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT 1,
  `login` varchar(128) NOT NULL,
  `pass_encoding` varchar(24) DEFAULT NULL,
  `pass_crypted` varchar(128) DEFAULT NULL,
  `pass_temp` varchar(128) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_website` int(11) DEFAULT NULL,
  `site` varchar(128) DEFAULT NULL,
  `site_account` varchar(128) DEFAULT NULL,
  `key_account` varchar(128) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `date_last_login` datetime DEFAULT NULL,
  `date_previous_login` datetime DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_address`
--

CREATE TABLE `llx_societe_address` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `label` varchar(30) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT 0,
  `name` varchar(60) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `town` varchar(50) DEFAULT NULL,
  `fk_pays` int(11) DEFAULT 0,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_commerciaux`
--

CREATE TABLE `llx_societe_commerciaux` (
  `rowid` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_contacts`
--

CREATE TABLE `llx_societe_contacts` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `date_creation` datetime NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_c_type_contact` int(11) NOT NULL,
  `fk_socpeople` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_extrafields`
--

CREATE TABLE `llx_societe_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_prices`
--

CREATE TABLE `llx_societe_prices` (
  `rowid` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT 0,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `price_level` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_remise`
--

CREATE TABLE `llx_societe_remise` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `remise_client` double(7,4) NOT NULL DEFAULT 0.0000,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_remise_except`
--

CREATE TABLE `llx_societe_remise_except` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) NOT NULL,
  `discount_type` int(11) NOT NULL DEFAULT 0,
  `datec` datetime DEFAULT NULL,
  `amount_ht` double(24,8) NOT NULL,
  `amount_tva` double(24,8) NOT NULL DEFAULT 0.00000000,
  `amount_ttc` double(24,8) NOT NULL DEFAULT 0.00000000,
  `tva_tx` double(7,4) NOT NULL DEFAULT 0.0000,
  `vat_src_code` varchar(10) DEFAULT '',
  `fk_user` int(11) NOT NULL,
  `fk_facture_line` int(11) DEFAULT NULL,
  `fk_facture` int(11) DEFAULT NULL,
  `fk_facture_source` int(11) DEFAULT NULL,
  `fk_invoice_supplier_line` int(11) DEFAULT NULL,
  `fk_invoice_supplier` int(11) DEFAULT NULL,
  `fk_invoice_supplier_source` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `multicurrency_amount_ht` double(24,8) NOT NULL DEFAULT 0.00000000,
  `multicurrency_amount_tva` double(24,8) NOT NULL DEFAULT 0.00000000,
  `multicurrency_amount_ttc` double(24,8) NOT NULL DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_remise_supplier`
--

CREATE TABLE `llx_societe_remise_supplier` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_soc` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `remise_supplier` double(7,4) NOT NULL DEFAULT 0.0000,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_societe_rib`
--

CREATE TABLE `llx_societe_rib` (
  `rowid` int(11) NOT NULL,
  `type` varchar(32) NOT NULL DEFAULT 'ban',
  `label` varchar(200) DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bank` varchar(255) DEFAULT NULL,
  `code_banque` varchar(128) DEFAULT NULL,
  `code_guichet` varchar(6) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `cle_rib` varchar(5) DEFAULT NULL,
  `bic` varchar(20) DEFAULT NULL,
  `iban_prefix` varchar(34) DEFAULT NULL,
  `domiciliation` varchar(255) DEFAULT NULL,
  `proprio` varchar(60) DEFAULT NULL,
  `owner_address` varchar(255) DEFAULT NULL,
  `default_rib` smallint(6) NOT NULL DEFAULT 0,
  `rum` varchar(32) DEFAULT NULL,
  `date_rum` date DEFAULT NULL,
  `frstrecur` varchar(16) DEFAULT 'FRST',
  `last_four` varchar(4) DEFAULT NULL,
  `card_type` varchar(255) DEFAULT NULL,
  `cvn` varchar(255) DEFAULT NULL,
  `exp_date_month` int(11) DEFAULT NULL,
  `exp_date_year` int(11) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `approved` int(11) DEFAULT 0,
  `email` varchar(255) DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `max_total_amount_of_all_payments` double(24,8) DEFAULT NULL,
  `preapproval_key` varchar(255) DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `total_amount_of_all_payments` double(24,8) DEFAULT NULL,
  `stripe_card_ref` varchar(128) DEFAULT NULL,
  `stripe_account` varchar(128) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `ipaddress` varchar(68) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_socpeople`
--

CREATE TABLE `llx_socpeople` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_soc` int(11) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(255) DEFAULT NULL,
  `civility` varchar(6) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip` varchar(25) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `fk_departement` int(11) DEFAULT NULL,
  `fk_pays` int(11) DEFAULT 0,
  `birthday` date DEFAULT NULL,
  `poste` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `phone_perso` varchar(30) DEFAULT NULL,
  `phone_mobile` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `socialnetworks` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `no_email` smallint(6) NOT NULL DEFAULT 0,
  `priv` smallint(6) NOT NULL DEFAULT 0,
  `fk_prospectcontactlevel` varchar(12) DEFAULT NULL,
  `fk_stcommcontact` int(11) NOT NULL DEFAULT 0,
  `fk_user_creat` int(11) DEFAULT 0,
  `fk_user_modif` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `default_lang` varchar(6) DEFAULT NULL,
  `canvas` varchar(32) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `statut` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_socpeople_extrafields`
--

CREATE TABLE `llx_socpeople_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_stock_mouvement`
--

CREATE TABLE `llx_stock_mouvement` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datem` datetime DEFAULT NULL,
  `fk_product` int(11) NOT NULL,
  `batch` varchar(128) DEFAULT NULL,
  `eatby` date DEFAULT NULL,
  `sellby` date DEFAULT NULL,
  `fk_entrepot` int(11) NOT NULL,
  `value` double DEFAULT NULL,
  `price` double(24,8) DEFAULT 0.00000000,
  `type_mouvement` smallint(6) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `inventorycode` varchar(128) DEFAULT NULL,
  `fk_project` int(11) DEFAULT NULL,
  `fk_origin` int(11) DEFAULT NULL,
  `origintype` varchar(64) DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `fk_projet` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_stock_mouvement_extrafields`
--

CREATE TABLE `llx_stock_mouvement_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_subscription`
--

CREATE TABLE `llx_subscription` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `fk_adherent` int(11) DEFAULT NULL,
  `fk_type` int(11) DEFAULT NULL,
  `dateadh` datetime DEFAULT NULL,
  `datef` datetime DEFAULT NULL,
  `subscription` double(24,8) DEFAULT NULL,
  `fk_bank` int(11) DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_supplier_proposal`
--

CREATE TABLE `llx_supplier_proposal` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_ext` varchar(255) DEFAULT NULL,
  `ref_int` varchar(255) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) NOT NULL DEFAULT 0,
  `price` double DEFAULT 0,
  `remise_percent` double DEFAULT 0,
  `remise_absolue` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `localtax1` double(24,8) DEFAULT 0.00000000,
  `localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `fk_account` int(11) DEFAULT NULL,
  `fk_currency` varchar(3) DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `note_private` text DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `last_main_doc` varchar(255) DEFAULT NULL,
  `date_livraison` date DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `extraparams` varchar(255) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT 1.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_supplier_proposaldet`
--

CREATE TABLE `llx_supplier_proposaldet` (
  `rowid` int(11) NOT NULL,
  `fk_supplier_proposal` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fk_remise_except` int(11) DEFAULT NULL,
  `vat_src_code` varchar(10) DEFAULT '',
  `tva_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_tx` double(7,4) DEFAULT 0.0000,
  `localtax1_type` varchar(10) DEFAULT NULL,
  `localtax2_tx` double(7,4) DEFAULT 0.0000,
  `localtax2_type` varchar(10) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT 0,
  `remise` double DEFAULT 0,
  `price` double DEFAULT NULL,
  `subprice` double(24,8) DEFAULT 0.00000000,
  `total_ht` double(24,8) DEFAULT 0.00000000,
  `total_tva` double(24,8) DEFAULT 0.00000000,
  `total_localtax1` double(24,8) DEFAULT 0.00000000,
  `total_localtax2` double(24,8) DEFAULT 0.00000000,
  `total_ttc` double(24,8) DEFAULT 0.00000000,
  `product_type` int(11) DEFAULT 0,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT 0,
  `buy_price_ht` double(24,8) DEFAULT 0.00000000,
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(11) DEFAULT 0,
  `rang` int(11) DEFAULT 0,
  `ref_fourn` varchar(30) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(3) DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ht` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_tva` double(24,8) DEFAULT 0.00000000,
  `multicurrency_total_ttc` double(24,8) DEFAULT 0.00000000,
  `fk_unit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_supplier_proposaldet_extrafields`
--

CREATE TABLE `llx_supplier_proposaldet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_supplier_proposal_extrafields`
--

CREATE TABLE `llx_supplier_proposal_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_takepos_floor_tables`
--

CREATE TABLE `llx_takepos_floor_tables` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `label` varchar(255) DEFAULT NULL,
  `leftpos` float DEFAULT NULL,
  `toppos` float DEFAULT NULL,
  `floor` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_tva`
--

CREATE TABLE `llx_tva` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `datec` datetime DEFAULT NULL,
  `datep` date DEFAULT NULL,
  `datev` date DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT 0.00000000,
  `fk_typepayment` int(11) DEFAULT NULL,
  `num_payment` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `note` text DEFAULT NULL,
  `paye` smallint(6) NOT NULL DEFAULT 0,
  `fk_account` int(11) DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_user`
--

CREATE TABLE `llx_user` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref_employee` varchar(50) DEFAULT NULL,
  `ref_ext` varchar(50) DEFAULT NULL,
  `admin` smallint(6) DEFAULT 0,
  `employee` tinyint(4) DEFAULT 1,
  `fk_establishment` int(11) DEFAULT 0,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `login` varchar(50) NOT NULL,
  `pass_encoding` varchar(24) DEFAULT NULL,
  `pass` varchar(128) DEFAULT NULL,
  `pass_crypted` varchar(128) DEFAULT NULL,
  `pass_temp` varchar(128) DEFAULT NULL,
  `api_key` varchar(128) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `civility` varchar(6) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zip` varchar(25) DEFAULT NULL,
  `town` varchar(50) DEFAULT NULL,
  `fk_state` int(11) DEFAULT 0,
  `fk_country` int(11) DEFAULT 0,
  `birth` date DEFAULT NULL,
  `job` varchar(128) DEFAULT NULL,
  `office_phone` varchar(20) DEFAULT NULL,
  `office_fax` varchar(20) DEFAULT NULL,
  `user_mobile` varchar(20) DEFAULT NULL,
  `personal_mobile` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `personal_email` varchar(255) DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `socialnetworks` text DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_socpeople` int(11) DEFAULT NULL,
  `fk_member` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_user_expense_validator` int(11) DEFAULT NULL,
  `fk_user_holiday_validator` int(11) DEFAULT NULL,
  `idpers1` varchar(128) DEFAULT NULL,
  `idpers2` varchar(128) DEFAULT NULL,
  `idpers3` varchar(128) DEFAULT NULL,
  `note_public` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL,
  `datelastlogin` datetime DEFAULT NULL,
  `datepreviouslogin` datetime DEFAULT NULL,
  `datelastpassvalidation` datetime DEFAULT NULL,
  `datestartvalidity` datetime DEFAULT NULL,
  `dateendvalidity` datetime DEFAULT NULL,
  `iplastlogin` varchar(250) DEFAULT NULL,
  `ippreviouslogin` varchar(250) DEFAULT NULL,
  `egroupware_id` int(11) DEFAULT NULL,
  `ldap_sid` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `statut` tinyint(4) DEFAULT 1,
  `photo` varchar(255) DEFAULT NULL,
  `lang` varchar(6) DEFAULT NULL,
  `color` varchar(6) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT 0,
  `accountancy_code` varchar(32) DEFAULT NULL,
  `nb_holiday` int(11) DEFAULT 0,
  `thm` double(24,8) DEFAULT NULL,
  `tjm` double(24,8) DEFAULT NULL,
  `salary` double(24,8) DEFAULT NULL,
  `salaryextra` double(24,8) DEFAULT NULL,
  `dateemployment` date DEFAULT NULL,
  `dateemploymentend` date DEFAULT NULL,
  `weeklyhours` double(16,8) DEFAULT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `default_range` int(11) DEFAULT NULL,
  `default_c_exp_tax_cat` int(11) DEFAULT NULL,
  `national_registration_number` varchar(50) DEFAULT NULL,
  `fk_warehouse` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_usergroup`
--

CREATE TABLE `llx_usergroup` (
  `rowid` int(11) NOT NULL,
  `nom` varchar(180) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `note` text DEFAULT NULL,
  `model_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_usergroup_extrafields`
--

CREATE TABLE `llx_usergroup_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_usergroup_rights`
--

CREATE TABLE `llx_usergroup_rights` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_usergroup` int(11) NOT NULL,
  `fk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_usergroup_user`
--

CREATE TABLE `llx_usergroup_user` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_user` int(11) NOT NULL,
  `fk_usergroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_user_alert`
--

CREATE TABLE `llx_user_alert` (
  `rowid` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `fk_contact` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_user_clicktodial`
--

CREATE TABLE `llx_user_clicktodial` (
  `fk_user` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `login` varchar(32) DEFAULT NULL,
  `pass` varchar(64) DEFAULT NULL,
  `poste` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_user_employment`
--

CREATE TABLE `llx_user_employment` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `ref` varchar(50) DEFAULT NULL,
  `ref_ext` varchar(50) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `job` varchar(128) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `salary` double(24,8) DEFAULT NULL,
  `salaryextra` double(24,8) DEFAULT NULL,
  `weeklyhours` double(16,8) DEFAULT NULL,
  `dateemployment` date DEFAULT NULL,
  `dateemploymentend` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_user_extrafields`
--

CREATE TABLE `llx_user_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) DEFAULT NULL,
  `cin` varchar(255) DEFAULT NULL,
  `matricule` varchar(255) DEFAULT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `idpointage` int(5) DEFAULT NULL,
  `enfants` int(2) DEFAULT NULL,
  `situation` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_user_param`
--

CREATE TABLE `llx_user_param` (
  `fk_user` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `param` varchar(180) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_user_rib`
--

CREATE TABLE `llx_user_rib` (
  `rowid` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `label` varchar(30) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `code_banque` varchar(128) DEFAULT NULL,
  `code_guichet` varchar(6) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `cle_rib` varchar(5) DEFAULT NULL,
  `bic` varchar(11) DEFAULT NULL,
  `iban_prefix` varchar(34) DEFAULT NULL,
  `domiciliation` varchar(255) DEFAULT NULL,
  `proprio` varchar(60) DEFAULT NULL,
  `owner_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `llx_user_rights`
--

CREATE TABLE `llx_user_rights` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT 1,
  `fk_user` int(11) NOT NULL,
  `fk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `llx_accounting_account`
--
ALTER TABLE `llx_accounting_account`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_accounting_account` (`account_number`,`entity`,`fk_pcg_version`),
  ADD KEY `idx_accounting_account_fk_pcg_version` (`fk_pcg_version`),
  ADD KEY `idx_accounting_account_account_parent` (`account_parent`);

--
-- Index pour la table `llx_accounting_bookkeeping`
--
ALTER TABLE `llx_accounting_bookkeeping`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_accounting_bookkeeping_fk_doc` (`fk_doc`),
  ADD KEY `idx_accounting_bookkeeping_fk_docdet` (`fk_docdet`),
  ADD KEY `idx_accounting_bookkeeping_doc_date` (`doc_date`),
  ADD KEY `idx_accounting_bookkeeping_numero_compte` (`numero_compte`,`entity`),
  ADD KEY `idx_accounting_bookkeeping_code_journal` (`code_journal`,`entity`),
  ADD KEY `idx_accounting_bookkeeping_piece_num` (`piece_num`,`entity`);

--
-- Index pour la table `llx_accounting_bookkeeping_tmp`
--
ALTER TABLE `llx_accounting_bookkeeping_tmp`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_accounting_bookkeeping_tmp_doc_date` (`doc_date`),
  ADD KEY `idx_accounting_bookkeeping_tmp_fk_docdet` (`fk_docdet`),
  ADD KEY `idx_accounting_bookkeeping_tmp_numero_compte` (`numero_compte`),
  ADD KEY `idx_accounting_bookkeeping_tmp_code_journal` (`code_journal`);

--
-- Index pour la table `llx_accounting_fiscalyear`
--
ALTER TABLE `llx_accounting_fiscalyear`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_accounting_groups_account`
--
ALTER TABLE `llx_accounting_groups_account`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_accounting_journal`
--
ALTER TABLE `llx_accounting_journal`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_accounting_journal_code` (`code`,`entity`);

--
-- Index pour la table `llx_accounting_system`
--
ALTER TABLE `llx_accounting_system`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_accounting_system_pcg_version` (`pcg_version`);

--
-- Index pour la table `llx_actioncomm`
--
ALTER TABLE `llx_actioncomm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_actioncomm_ref` (`ref`,`entity`),
  ADD KEY `idx_actioncomm_fk_soc` (`fk_soc`),
  ADD KEY `idx_actioncomm_fk_contact` (`fk_contact`),
  ADD KEY `idx_actioncomm_code` (`code`),
  ADD KEY `idx_actioncomm_fk_element` (`fk_element`),
  ADD KEY `idx_actioncomm_fk_user_action` (`fk_user_action`),
  ADD KEY `idx_actioncomm_fk_project` (`fk_project`),
  ADD KEY `idx_actioncomm_datep` (`datep`),
  ADD KEY `idx_actioncomm_datep2` (`datep2`),
  ADD KEY `idx_actioncomm_recurid` (`recurid`),
  ADD KEY `idx_actioncomm_ref_ext` (`ref_ext`);

--
-- Index pour la table `llx_actioncomm_extrafields`
--
ALTER TABLE `llx_actioncomm_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_actioncomm_extrafields` (`fk_object`);

--
-- Index pour la table `llx_actioncomm_reminder`
--
ALTER TABLE `llx_actioncomm_reminder`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_actioncomm_reminder_unique` (`fk_actioncomm`,`fk_user`,`typeremind`,`offsetvalue`,`offsetunit`),
  ADD KEY `idx_actioncomm_reminder_dateremind` (`dateremind`),
  ADD KEY `idx_actioncomm_reminder_fk_user` (`fk_user`),
  ADD KEY `idx_actioncomm_reminder_status` (`status`);

--
-- Index pour la table `llx_actioncomm_resources`
--
ALTER TABLE `llx_actioncomm_resources`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_actioncomm_resources` (`fk_actioncomm`,`element_type`,`fk_element`),
  ADD KEY `idx_actioncomm_resources_fk_element` (`fk_element`);

--
-- Index pour la table `llx_adherent`
--
ALTER TABLE `llx_adherent`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_adherent_ref` (`ref`,`entity`),
  ADD UNIQUE KEY `uk_adherent_login` (`login`,`entity`),
  ADD UNIQUE KEY `uk_adherent_fk_soc` (`fk_soc`),
  ADD KEY `idx_adherent_fk_adherent_type` (`fk_adherent_type`);

--
-- Index pour la table `llx_adherent_extrafields`
--
ALTER TABLE `llx_adherent_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_adherent_extrafields` (`fk_object`);

--
-- Index pour la table `llx_adherent_type`
--
ALTER TABLE `llx_adherent_type`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_adherent_type_libelle` (`libelle`,`entity`);

--
-- Index pour la table `llx_adherent_type_extrafields`
--
ALTER TABLE `llx_adherent_type_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_adherent_type_extrafields` (`fk_object`);

--
-- Index pour la table `llx_adherent_type_lang`
--
ALTER TABLE `llx_adherent_type_lang`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_bank`
--
ALTER TABLE `llx_bank`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_bank_datev` (`datev`),
  ADD KEY `idx_bank_dateo` (`dateo`),
  ADD KEY `idx_bank_fk_account` (`fk_account`),
  ADD KEY `idx_bank_rappro` (`rappro`),
  ADD KEY `idx_bank_num_releve` (`num_releve`);

--
-- Index pour la table `llx_bank_account`
--
ALTER TABLE `llx_bank_account`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bank_account_label` (`label`,`entity`),
  ADD KEY `idx_fk_accountancy_journal` (`fk_accountancy_journal`);

--
-- Index pour la table `llx_bank_account_extrafields`
--
ALTER TABLE `llx_bank_account_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_bank_account_extrafields` (`fk_object`);

--
-- Index pour la table `llx_bank_categ`
--
ALTER TABLE `llx_bank_categ`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_bank_class`
--
ALTER TABLE `llx_bank_class`
  ADD UNIQUE KEY `uk_bank_class_lineid` (`lineid`,`fk_categ`);

--
-- Index pour la table `llx_bank_url`
--
ALTER TABLE `llx_bank_url`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bank_url` (`fk_bank`,`url_id`,`type`);

--
-- Index pour la table `llx_blockedlog`
--
ALTER TABLE `llx_blockedlog`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `signature` (`signature`),
  ADD KEY `fk_object_element` (`fk_object`,`element`),
  ADD KEY `entity` (`entity`),
  ADD KEY `fk_user` (`fk_user`),
  ADD KEY `entity_action` (`entity`,`action`),
  ADD KEY `entity_action_certified` (`entity`,`action`,`certified`);

--
-- Index pour la table `llx_blockedlog_authority`
--
ALTER TABLE `llx_blockedlog_authority`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `signature` (`signature`);

--
-- Index pour la table `llx_bom_bom`
--
ALTER TABLE `llx_bom_bom`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bom_bom_ref` (`ref`,`entity`),
  ADD KEY `idx_bom_bom_rowid` (`rowid`),
  ADD KEY `idx_bom_bom_ref` (`ref`),
  ADD KEY `llx_bom_bom_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_bom_bom_status` (`status`),
  ADD KEY `idx_bom_bom_fk_product` (`fk_product`);

--
-- Index pour la table `llx_bom_bomline`
--
ALTER TABLE `llx_bom_bomline`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_bom_bomline_rowid` (`rowid`),
  ADD KEY `idx_bom_bomline_fk_product` (`fk_product`),
  ADD KEY `idx_bom_bomline_fk_bom` (`fk_bom`);

--
-- Index pour la table `llx_bom_bomline_extrafields`
--
ALTER TABLE `llx_bom_bomline_extrafields`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_bom_bom_extrafields`
--
ALTER TABLE `llx_bom_bom_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_bom_bom_extrafields_fk_object` (`fk_object`);

--
-- Index pour la table `llx_bookmark`
--
ALTER TABLE `llx_bookmark`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bookmark_title` (`fk_user`,`entity`,`title`);

--
-- Index pour la table `llx_bordereau_cheque`
--
ALTER TABLE `llx_bordereau_cheque`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bordereau_cheque` (`ref`,`entity`);

--
-- Index pour la table `llx_boxes`
--
ALTER TABLE `llx_boxes`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_boxes` (`entity`,`box_id`,`position`,`fk_user`),
  ADD KEY `idx_boxes_boxid` (`box_id`),
  ADD KEY `idx_boxes_fk_user` (`fk_user`);

--
-- Index pour la table `llx_boxes_def`
--
ALTER TABLE `llx_boxes_def`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_boxes_def` (`file`,`entity`,`note`);

--
-- Index pour la table `llx_budget`
--
ALTER TABLE `llx_budget`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_budget_lines`
--
ALTER TABLE `llx_budget_lines`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_budget_lines` (`fk_budget`,`fk_project_ids`);

--
-- Index pour la table `llx_categorie`
--
ALTER TABLE `llx_categorie`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_categories_extrafields`
--
ALTER TABLE `llx_categories_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_categories_extrafields` (`fk_object`);

--
-- Index pour la table `llx_categorie_account`
--
ALTER TABLE `llx_categorie_account`
  ADD PRIMARY KEY (`fk_categorie`,`fk_account`),
  ADD KEY `idx_categorie_account_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_account_fk_account` (`fk_account`);

--
-- Index pour la table `llx_categorie_actioncomm`
--
ALTER TABLE `llx_categorie_actioncomm`
  ADD PRIMARY KEY (`fk_categorie`,`fk_actioncomm`),
  ADD KEY `idx_categorie_actioncomm_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_actioncomm_fk_actioncomm` (`fk_actioncomm`);

--
-- Index pour la table `llx_categorie_contact`
--
ALTER TABLE `llx_categorie_contact`
  ADD PRIMARY KEY (`fk_categorie`,`fk_socpeople`),
  ADD KEY `idx_categorie_contact_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_contact_fk_socpeople` (`fk_socpeople`);

--
-- Index pour la table `llx_categorie_fournisseur`
--
ALTER TABLE `llx_categorie_fournisseur`
  ADD PRIMARY KEY (`fk_categorie`,`fk_soc`),
  ADD KEY `idx_categorie_fournisseur_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_fournisseur_fk_societe` (`fk_soc`);

--
-- Index pour la table `llx_categorie_knowledgemanagement`
--
ALTER TABLE `llx_categorie_knowledgemanagement`
  ADD PRIMARY KEY (`fk_categorie`,`fk_knowledgemanagement`),
  ADD KEY `idx_categorie_knowledgemanagement_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_knowledgemanagement_fk_knowledgemanagement` (`fk_knowledgemanagement`);

--
-- Index pour la table `llx_categorie_lang`
--
ALTER TABLE `llx_categorie_lang`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_category_lang` (`fk_category`,`lang`);

--
-- Index pour la table `llx_categorie_member`
--
ALTER TABLE `llx_categorie_member`
  ADD PRIMARY KEY (`fk_categorie`,`fk_member`),
  ADD KEY `idx_categorie_member_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_member_fk_member` (`fk_member`);

--
-- Index pour la table `llx_categorie_product`
--
ALTER TABLE `llx_categorie_product`
  ADD PRIMARY KEY (`fk_categorie`,`fk_product`),
  ADD KEY `idx_categorie_product_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_product_fk_product` (`fk_product`);

--
-- Index pour la table `llx_categorie_project`
--
ALTER TABLE `llx_categorie_project`
  ADD PRIMARY KEY (`fk_categorie`,`fk_project`),
  ADD KEY `idx_categorie_project_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_project_fk_project` (`fk_project`);

--
-- Index pour la table `llx_categorie_societe`
--
ALTER TABLE `llx_categorie_societe`
  ADD PRIMARY KEY (`fk_categorie`,`fk_soc`),
  ADD KEY `idx_categorie_societe_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_societe_fk_societe` (`fk_soc`);

--
-- Index pour la table `llx_categorie_user`
--
ALTER TABLE `llx_categorie_user`
  ADD PRIMARY KEY (`fk_categorie`,`fk_user`),
  ADD KEY `idx_categorie_user_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_user_fk_user` (`fk_user`);

--
-- Index pour la table `llx_categorie_warehouse`
--
ALTER TABLE `llx_categorie_warehouse`
  ADD PRIMARY KEY (`fk_categorie`,`fk_warehouse`),
  ADD KEY `idx_categorie_warehouse_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_warehouse_fk_warehouse` (`fk_warehouse`);

--
-- Index pour la table `llx_chargesociales`
--
ALTER TABLE `llx_chargesociales`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_commande`
--
ALTER TABLE `llx_commande`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_commande_ref` (`ref`,`entity`),
  ADD KEY `idx_commande_fk_soc` (`fk_soc`),
  ADD KEY `idx_commande_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_commande_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_commande_fk_user_cloture` (`fk_user_cloture`),
  ADD KEY `idx_commande_fk_projet` (`fk_projet`),
  ADD KEY `idx_commande_fk_account` (`fk_account`),
  ADD KEY `idx_commande_fk_currency` (`fk_currency`);

--
-- Index pour la table `llx_commandedet`
--
ALTER TABLE `llx_commandedet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commandedet_fk_commande` (`fk_commande`),
  ADD KEY `idx_commandedet_fk_product` (`fk_product`),
  ADD KEY `fk_commandedet_fk_unit` (`fk_unit`),
  ADD KEY `fk_commandedet_fk_commandefourndet` (`fk_commandefourndet`);

--
-- Index pour la table `llx_commandedet_extrafields`
--
ALTER TABLE `llx_commandedet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commandedet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_commande_extrafields`
--
ALTER TABLE `llx_commande_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_extrafields` (`fk_object`);

--
-- Index pour la table `llx_commande_fournisseur`
--
ALTER TABLE `llx_commande_fournisseur`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_commande_fournisseur_ref` (`ref`,`fk_soc`,`entity`),
  ADD KEY `idx_commande_fournisseur_fk_soc` (`fk_soc`),
  ADD KEY `billed` (`billed`);

--
-- Index pour la table `llx_commande_fournisseurdet`
--
ALTER TABLE `llx_commande_fournisseurdet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_commande_fournisseurdet_fk_unit` (`fk_unit`),
  ADD KEY `idx_commande_fournisseurdet_fk_commande` (`fk_commande`),
  ADD KEY `idx_commande_fournisseurdet_fk_product` (`fk_product`);

--
-- Index pour la table `llx_commande_fournisseurdet_extrafields`
--
ALTER TABLE `llx_commande_fournisseurdet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_fournisseurdet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_commande_fournisseur_dispatch`
--
ALTER TABLE `llx_commande_fournisseur_dispatch`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_fournisseur_dispatch_fk_commande` (`fk_commande`),
  ADD KEY `idx_commande_fournisseur_dispatch_fk_reception` (`fk_reception`);

--
-- Index pour la table `llx_commande_fournisseur_dispatch_extrafields`
--
ALTER TABLE `llx_commande_fournisseur_dispatch_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_fournisseur_dispatch_extrafields` (`fk_object`);

--
-- Index pour la table `llx_commande_fournisseur_extrafields`
--
ALTER TABLE `llx_commande_fournisseur_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_fournisseur_extrafields` (`fk_object`);

--
-- Index pour la table `llx_commande_fournisseur_log`
--
ALTER TABLE `llx_commande_fournisseur_log`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_comment`
--
ALTER TABLE `llx_comment`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_const`
--
ALTER TABLE `llx_const`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_const` (`name`,`entity`);

--
-- Index pour la table `llx_contrat`
--
ALTER TABLE `llx_contrat`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_contrat_ref` (`ref`,`entity`),
  ADD KEY `idx_contrat_fk_soc` (`fk_soc`),
  ADD KEY `idx_contrat_fk_user_author` (`fk_user_author`);

--
-- Index pour la table `llx_contratdet`
--
ALTER TABLE `llx_contratdet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_contratdet_fk_contrat` (`fk_contrat`),
  ADD KEY `idx_contratdet_fk_product` (`fk_product`),
  ADD KEY `idx_contratdet_date_ouverture_prevue` (`date_ouverture_prevue`),
  ADD KEY `idx_contratdet_date_ouverture` (`date_ouverture`),
  ADD KEY `idx_contratdet_date_fin_validite` (`date_fin_validite`),
  ADD KEY `fk_contratdet_fk_unit` (`fk_unit`);

--
-- Index pour la table `llx_contratdet_extrafields`
--
ALTER TABLE `llx_contratdet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_contratdet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_contratdet_log`
--
ALTER TABLE `llx_contratdet_log`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_contratdet_log_fk_contratdet` (`fk_contratdet`),
  ADD KEY `idx_contratdet_log_date` (`date`);

--
-- Index pour la table `llx_contrat_extrafields`
--
ALTER TABLE `llx_contrat_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_contrat_extrafields` (`fk_object`);

--
-- Index pour la table `llx_cronjob`
--
ALTER TABLE `llx_cronjob`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_cronjob` (`label`,`entity`),
  ADD KEY `idx_cronjob_status` (`status`),
  ADD KEY `idx_cronjob_datelastrun` (`datelastrun`),
  ADD KEY `idx_cronjob_datenextrun` (`datenextrun`),
  ADD KEY `idx_cronjob_datestart` (`datestart`),
  ADD KEY `idx_cronjob_dateend` (`dateend`);

--
-- Index pour la table `llx_c_accounting_category`
--
ALTER TABLE `llx_c_accounting_category`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_accounting_category` (`code`,`entity`);

--
-- Index pour la table `llx_c_actioncomm`
--
ALTER TABLE `llx_c_actioncomm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_actioncomm` (`code`);

--
-- Index pour la table `llx_c_action_trigger`
--
ALTER TABLE `llx_c_action_trigger`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_action_trigger_code` (`code`),
  ADD KEY `idx_action_trigger_rang` (`rang`);

--
-- Index pour la table `llx_c_availability`
--
ALTER TABLE `llx_c_availability`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_availability` (`code`);

--
-- Index pour la table `llx_c_barcode_type`
--
ALTER TABLE `llx_c_barcode_type`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_barcode_type` (`code`,`entity`);

--
-- Index pour la table `llx_c_chargesociales`
--
ALTER TABLE `llx_c_chargesociales`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `llx_c_civility`
--
ALTER TABLE `llx_c_civility`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_civility` (`code`);

--
-- Index pour la table `llx_c_country`
--
ALTER TABLE `llx_c_country`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_c_country_code` (`code`),
  ADD UNIQUE KEY `idx_c_country_label` (`label`),
  ADD UNIQUE KEY `idx_c_country_code_iso` (`code_iso`);

--
-- Index pour la table `llx_c_currencies`
--
ALTER TABLE `llx_c_currencies`
  ADD PRIMARY KEY (`code_iso`),
  ADD UNIQUE KEY `uk_c_currencies_code_iso` (`code_iso`);

--
-- Index pour la table `llx_c_departements`
--
ALTER TABLE `llx_c_departements`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_departements` (`code_departement`,`fk_region`),
  ADD KEY `idx_departements_fk_region` (`fk_region`);

--
-- Index pour la table `llx_c_ecotaxe`
--
ALTER TABLE `llx_c_ecotaxe`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_ecotaxe` (`code`);

--
-- Index pour la table `llx_c_effectif`
--
ALTER TABLE `llx_c_effectif`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_effectif` (`code`);

--
-- Index pour la table `llx_c_email_senderprofile`
--
ALTER TABLE `llx_c_email_senderprofile`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_email_senderprofile` (`entity`,`label`,`email`);

--
-- Index pour la table `llx_c_email_templates`
--
ALTER TABLE `llx_c_email_templates`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_email_templates` (`entity`,`label`,`lang`),
  ADD KEY `idx_type` (`type_template`);

--
-- Index pour la table `llx_c_exp_tax_cat`
--
ALTER TABLE `llx_c_exp_tax_cat`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_exp_tax_range`
--
ALTER TABLE `llx_c_exp_tax_range`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_field_list`
--
ALTER TABLE `llx_c_field_list`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_format_cards`
--
ALTER TABLE `llx_c_format_cards`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_forme_juridique`
--
ALTER TABLE `llx_c_forme_juridique`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_forme_juridique` (`code`);

--
-- Index pour la table `llx_c_holiday_types`
--
ALTER TABLE `llx_c_holiday_types`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_holiday_types` (`code`);

--
-- Index pour la table `llx_c_hrm_department`
--
ALTER TABLE `llx_c_hrm_department`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_hrm_function`
--
ALTER TABLE `llx_c_hrm_function`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_hrm_public_holiday`
--
ALTER TABLE `llx_c_hrm_public_holiday`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_hrm_public_holiday` (`entity`,`code`),
  ADD UNIQUE KEY `uk_c_hrm_public_holiday2` (`entity`,`fk_country`,`dayrule`,`day`,`month`,`year`);

--
-- Index pour la table `llx_c_incoterms`
--
ALTER TABLE `llx_c_incoterms`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_incoterms` (`code`);

--
-- Index pour la table `llx_c_input_method`
--
ALTER TABLE `llx_c_input_method`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_input_method` (`code`);

--
-- Index pour la table `llx_c_input_reason`
--
ALTER TABLE `llx_c_input_reason`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_input_reason` (`code`);

--
-- Index pour la table `llx_c_lead_status`
--
ALTER TABLE `llx_c_lead_status`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_lead_status_code` (`code`);

--
-- Index pour la table `llx_c_paiement`
--
ALTER TABLE `llx_c_paiement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_paiement_code` (`entity`,`code`);

--
-- Index pour la table `llx_c_paper_format`
--
ALTER TABLE `llx_c_paper_format`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_partnership_type`
--
ALTER TABLE `llx_c_partnership_type`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_partnership_type` (`entity`,`code`);

--
-- Index pour la table `llx_c_payment_term`
--
ALTER TABLE `llx_c_payment_term`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_payment_term_code` (`entity`,`code`);

--
-- Index pour la table `llx_c_price_expression`
--
ALTER TABLE `llx_c_price_expression`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_price_global_variable`
--
ALTER TABLE `llx_c_price_global_variable`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_price_global_variable_updater`
--
ALTER TABLE `llx_c_price_global_variable_updater`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_productbatch_qcstatus`
--
ALTER TABLE `llx_c_productbatch_qcstatus`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_productbatch_qcstatus` (`code`,`entity`);

--
-- Index pour la table `llx_c_product_nature`
--
ALTER TABLE `llx_c_product_nature`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_product_nature` (`code`);

--
-- Index pour la table `llx_c_propalst`
--
ALTER TABLE `llx_c_propalst`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_propalst` (`code`);

--
-- Index pour la table `llx_c_prospectcontactlevel`
--
ALTER TABLE `llx_c_prospectcontactlevel`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `llx_c_prospectlevel`
--
ALTER TABLE `llx_c_prospectlevel`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `llx_c_recruitment_origin`
--
ALTER TABLE `llx_c_recruitment_origin`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_regions`
--
ALTER TABLE `llx_c_regions`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code_region` (`code_region`),
  ADD KEY `idx_c_regions_fk_pays` (`fk_pays`);

--
-- Index pour la table `llx_c_revenuestamp`
--
ALTER TABLE `llx_c_revenuestamp`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_shipment_mode`
--
ALTER TABLE `llx_c_shipment_mode`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_shipment_mode` (`code`,`entity`);

--
-- Index pour la table `llx_c_shipment_package_type`
--
ALTER TABLE `llx_c_shipment_package_type`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_c_socialnetworks`
--
ALTER TABLE `llx_c_socialnetworks`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_c_socialnetworks_code_entity` (`entity`,`code`);

--
-- Index pour la table `llx_c_stcomm`
--
ALTER TABLE `llx_c_stcomm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_stcomm` (`code`);

--
-- Index pour la table `llx_c_stcommcontact`
--
ALTER TABLE `llx_c_stcommcontact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_stcommcontact` (`code`);

--
-- Index pour la table `llx_c_ticket_category`
--
ALTER TABLE `llx_c_ticket_category`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code` (`code`,`entity`);

--
-- Index pour la table `llx_c_ticket_resolution`
--
ALTER TABLE `llx_c_ticket_resolution`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code` (`code`,`entity`);

--
-- Index pour la table `llx_c_ticket_severity`
--
ALTER TABLE `llx_c_ticket_severity`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code` (`code`,`entity`);

--
-- Index pour la table `llx_c_ticket_type`
--
ALTER TABLE `llx_c_ticket_type`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code` (`code`,`entity`);

--
-- Index pour la table `llx_c_transport_mode`
--
ALTER TABLE `llx_c_transport_mode`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_transport_mode` (`code`,`entity`);

--
-- Index pour la table `llx_c_tva`
--
ALTER TABLE `llx_c_tva`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_tva_id` (`fk_pays`,`code`,`taux`,`recuperableonly`);

--
-- Index pour la table `llx_c_typent`
--
ALTER TABLE `llx_c_typent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_typent` (`code`);

--
-- Index pour la table `llx_c_type_contact`
--
ALTER TABLE `llx_c_type_contact`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_type_contact_id` (`element`,`source`,`code`);

--
-- Index pour la table `llx_c_type_container`
--
ALTER TABLE `llx_c_type_container`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_type_container_id` (`code`,`entity`);

--
-- Index pour la table `llx_c_type_fees`
--
ALTER TABLE `llx_c_type_fees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_type_fees` (`code`);

--
-- Index pour la table `llx_c_type_resource`
--
ALTER TABLE `llx_c_type_resource`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_type_resource_id` (`label`,`code`);

--
-- Index pour la table `llx_c_units`
--
ALTER TABLE `llx_c_units`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_units_code` (`code`);

--
-- Index pour la table `llx_c_ziptown`
--
ALTER TABLE `llx_c_ziptown`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_ziptown_fk_pays` (`zip`,`town`,`fk_pays`),
  ADD KEY `idx_c_ziptown_fk_county` (`fk_county`),
  ADD KEY `idx_c_ziptown_fk_pays` (`fk_pays`),
  ADD KEY `idx_c_ziptown_zip` (`zip`);

--
-- Index pour la table `llx_default_values`
--
ALTER TABLE `llx_default_values`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_default_values` (`type`,`entity`,`user_id`,`page`,`param`);

--
-- Index pour la table `llx_delivery`
--
ALTER TABLE `llx_delivery`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_delivery_uk_ref` (`ref`,`entity`),
  ADD KEY `idx_delivery_fk_soc` (`fk_soc`),
  ADD KEY `idx_delivery_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_delivery_fk_user_valid` (`fk_user_valid`);

--
-- Index pour la table `llx_deliverydet`
--
ALTER TABLE `llx_deliverydet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_deliverydet_fk_delivery` (`fk_delivery`);

--
-- Index pour la table `llx_deliverydet_extrafields`
--
ALTER TABLE `llx_deliverydet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_deliverydet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_delivery_extrafields`
--
ALTER TABLE `llx_delivery_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_delivery_extrafields` (`fk_object`);

--
-- Index pour la table `llx_document_model`
--
ALTER TABLE `llx_document_model`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_document_model` (`nom`,`type`,`entity`);

--
-- Index pour la table `llx_ecm_directories`
--
ALTER TABLE `llx_ecm_directories`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_ecm_directories` (`label`,`fk_parent`,`entity`),
  ADD KEY `idx_ecm_directories_fk_user_c` (`fk_user_c`),
  ADD KEY `idx_ecm_directories_fk_user_m` (`fk_user_m`);

--
-- Index pour la table `llx_ecm_directories_extrafields`
--
ALTER TABLE `llx_ecm_directories_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_ecm_directories_extrafields` (`fk_object`);

--
-- Index pour la table `llx_ecm_files`
--
ALTER TABLE `llx_ecm_files`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_ecm_files` (`filepath`,`filename`,`entity`),
  ADD KEY `idx_ecm_files_label` (`label`);

--
-- Index pour la table `llx_ecm_files_extrafields`
--
ALTER TABLE `llx_ecm_files_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_ecm_files_extrafields` (`fk_object`);

--
-- Index pour la table `llx_element_contact`
--
ALTER TABLE `llx_element_contact`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_element_contact_idx1` (`element_id`,`fk_c_type_contact`,`fk_socpeople`),
  ADD KEY `fk_element_contact_fk_c_type_contact` (`fk_c_type_contact`),
  ADD KEY `idx_element_contact_fk_socpeople` (`fk_socpeople`);

--
-- Index pour la table `llx_element_element`
--
ALTER TABLE `llx_element_element`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_element_element_idx1` (`fk_source`,`sourcetype`,`fk_target`,`targettype`),
  ADD KEY `idx_element_element_fk_target` (`fk_target`);

--
-- Index pour la table `llx_element_resources`
--
ALTER TABLE `llx_element_resources`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_element_resources_idx1` (`resource_id`,`resource_type`,`element_id`,`element_type`),
  ADD KEY `idx_element_element_element_id` (`element_id`);

--
-- Index pour la table `llx_element_tag`
--
ALTER TABLE `llx_element_tag`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_element_tag_uk` (`fk_categorie`,`fk_element`);

--
-- Index pour la table `llx_emailcollector_emailcollector`
--
ALTER TABLE `llx_emailcollector_emailcollector`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_emailcollector_emailcollector_ref` (`ref`,`entity`),
  ADD KEY `idx_emailcollector_entity` (`entity`),
  ADD KEY `idx_emailcollector_status` (`status`);

--
-- Index pour la table `llx_emailcollector_emailcollectoraction`
--
ALTER TABLE `llx_emailcollector_emailcollectoraction`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_emailcollector_emailcollectoraction` (`fk_emailcollector`,`type`),
  ADD KEY `idx_emailcollector_fk_emailcollector` (`fk_emailcollector`);

--
-- Index pour la table `llx_emailcollector_emailcollectorfilter`
--
ALTER TABLE `llx_emailcollector_emailcollectorfilter`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_emailcollector_emailcollectorfilter` (`fk_emailcollector`,`type`,`rulevalue`),
  ADD KEY `idx_emailcollector_fk_emailcollector` (`fk_emailcollector`);

--
-- Index pour la table `llx_entrepot`
--
ALTER TABLE `llx_entrepot`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_entrepot_label` (`ref`,`entity`);

--
-- Index pour la table `llx_entrepot_extrafields`
--
ALTER TABLE `llx_entrepot_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_entrepot_extrafields` (`fk_object`);

--
-- Index pour la table `llx_establishment`
--
ALTER TABLE `llx_establishment`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_eventorganization_conferenceorboothattendee`
--
ALTER TABLE `llx_eventorganization_conferenceorboothattendee`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_eventorganization_conferenceorboothattendee` (`fk_project`,`email`,`fk_actioncomm`),
  ADD KEY `idx_eventorganization_conferenceorboothattendee_rowid` (`rowid`),
  ADD KEY `idx_eventorganization_conferenceorboothattendee_ref` (`ref`),
  ADD KEY `idx_eventorganization_conferenceorboothattendee_fk_soc` (`fk_soc`),
  ADD KEY `idx_eventorganization_conferenceorboothattendee_fk_actioncomm` (`fk_actioncomm`),
  ADD KEY `idx_eventorganization_conferenceorboothattendee_fk_project` (`fk_project`),
  ADD KEY `idx_eventorganization_conferenceorboothattendee_email` (`email`),
  ADD KEY `idx_eventorganization_conferenceorboothattendee_status` (`status`);

--
-- Index pour la table `llx_eventorganization_conferenceorboothattendee_extrafields`
--
ALTER TABLE `llx_eventorganization_conferenceorboothattendee_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_conferenceorboothattendee_fk_object` (`fk_object`);

--
-- Index pour la table `llx_events`
--
ALTER TABLE `llx_events`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_events_dateevent` (`dateevent`);

--
-- Index pour la table `llx_event_element`
--
ALTER TABLE `llx_event_element`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_expedition`
--
ALTER TABLE `llx_expedition`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_expedition_uk_ref` (`ref`,`entity`),
  ADD KEY `idx_expedition_fk_soc` (`fk_soc`),
  ADD KEY `idx_expedition_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_expedition_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_expedition_fk_shipping_method` (`fk_shipping_method`);

--
-- Index pour la table `llx_expeditiondet`
--
ALTER TABLE `llx_expeditiondet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expeditiondet_fk_expedition` (`fk_expedition`),
  ADD KEY `idx_expeditiondet_fk_origin_line` (`fk_origin_line`);

--
-- Index pour la table `llx_expeditiondet_batch`
--
ALTER TABLE `llx_expeditiondet_batch`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_fk_expeditiondet` (`fk_expeditiondet`);

--
-- Index pour la table `llx_expeditiondet_extrafields`
--
ALTER TABLE `llx_expeditiondet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expeditiondet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_expedition_extrafields`
--
ALTER TABLE `llx_expedition_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expedition_extrafields` (`fk_object`);

--
-- Index pour la table `llx_expedition_package`
--
ALTER TABLE `llx_expedition_package`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_reception_uk_ref` (`ref`,`entity`);

--
-- Index pour la table `llx_expedition_packagedet`
--
ALTER TABLE `llx_expedition_packagedet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expedition_packagedet_fk_shipmentpackage` (`fk_shipmentpackage`),
  ADD KEY `idx_expedition_packagedet_fk_origin_line` (`fk_origin_line`);

--
-- Index pour la table `llx_expedition_package_extrafields`
--
ALTER TABLE `llx_expedition_package_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expedition_package_fk_object` (`fk_object`);

--
-- Index pour la table `llx_expensereport`
--
ALTER TABLE `llx_expensereport`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_expensereport_uk_ref` (`ref`,`entity`),
  ADD KEY `idx_expensereport_date_debut` (`date_debut`),
  ADD KEY `idx_expensereport_date_fin` (`date_fin`),
  ADD KEY `idx_expensereport_fk_statut` (`fk_statut`),
  ADD KEY `idx_expensereport_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_expensereport_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_expensereport_fk_user_approve` (`fk_user_approve`),
  ADD KEY `idx_expensereport_fk_refuse` (`fk_user_approve`);

--
-- Index pour la table `llx_expensereport_det`
--
ALTER TABLE `llx_expensereport_det`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_expensereport_extrafields`
--
ALTER TABLE `llx_expensereport_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expensereport_extrafields` (`fk_object`);

--
-- Index pour la table `llx_expensereport_ik`
--
ALTER TABLE `llx_expensereport_ik`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_expensereport_rules`
--
ALTER TABLE `llx_expensereport_rules`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_export_compta`
--
ALTER TABLE `llx_export_compta`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_export_model`
--
ALTER TABLE `llx_export_model`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_export_model` (`label`,`type`);

--
-- Index pour la table `llx_extrafields`
--
ALTER TABLE `llx_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_extrafields_name` (`name`,`entity`,`elementtype`);

--
-- Index pour la table `llx_facture`
--
ALTER TABLE `llx_facture`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_facture_ref` (`ref`,`entity`),
  ADD KEY `idx_facture_fk_soc` (`fk_soc`),
  ADD KEY `idx_facture_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_facture_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_facture_fk_facture_source` (`fk_facture_source`),
  ADD KEY `idx_facture_fk_projet` (`fk_projet`),
  ADD KEY `idx_facture_fk_account` (`fk_account`),
  ADD KEY `idx_facture_fk_currency` (`fk_currency`),
  ADD KEY `idx_facture_fk_statut` (`fk_statut`),
  ADD KEY `idx_facture_datef` (`datef`);

--
-- Index pour la table `llx_facturedet`
--
ALTER TABLE `llx_facturedet`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_fk_remise_except` (`fk_remise_except`,`fk_facture`),
  ADD KEY `idx_facturedet_fk_facture` (`fk_facture`),
  ADD KEY `idx_facturedet_fk_product` (`fk_product`),
  ADD KEY `idx_facturedet_fk_code_ventilation` (`fk_code_ventilation`),
  ADD KEY `fk_facturedet_fk_unit` (`fk_unit`);

--
-- Index pour la table `llx_facturedet_extrafields`
--
ALTER TABLE `llx_facturedet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facturedet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_facturedet_rec`
--
ALTER TABLE `llx_facturedet_rec`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_facturedet_rec_fk_unit` (`fk_unit`);

--
-- Index pour la table `llx_facturedet_rec_extrafields`
--
ALTER TABLE `llx_facturedet_rec_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facturedet_rec_extrafields` (`fk_object`);

--
-- Index pour la table `llx_facture_extrafields`
--
ALTER TABLE `llx_facture_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_extrafields` (`fk_object`);

--
-- Index pour la table `llx_facture_fourn`
--
ALTER TABLE `llx_facture_fourn`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_facture_fourn_ref` (`ref`,`entity`),
  ADD UNIQUE KEY `uk_facture_fourn_ref_supplier` (`ref_supplier`,`fk_soc`,`entity`),
  ADD KEY `idx_facture_fourn_date_lim_reglement` (`date_lim_reglement`),
  ADD KEY `idx_facture_fourn_fk_soc` (`fk_soc`),
  ADD KEY `idx_facture_fourn_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_facture_fourn_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_facture_fourn_fk_projet` (`fk_projet`);

--
-- Index pour la table `llx_facture_fourn_det`
--
ALTER TABLE `llx_facture_fourn_det`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_fk_remise_except` (`fk_remise_except`,`fk_facture_fourn`),
  ADD KEY `idx_facture_fourn_det_fk_facture` (`fk_facture_fourn`),
  ADD KEY `idx_facture_fourn_det_fk_product` (`fk_product`),
  ADD KEY `idx_facture_fourn_det_fk_code_ventilation` (`fk_code_ventilation`),
  ADD KEY `fk_facture_fourn_det_fk_unit` (`fk_unit`);

--
-- Index pour la table `llx_facture_fourn_det_extrafields`
--
ALTER TABLE `llx_facture_fourn_det_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_fourn_det_extrafields` (`fk_object`);

--
-- Index pour la table `llx_facture_fourn_det_rec`
--
ALTER TABLE `llx_facture_fourn_det_rec`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_facture_fourn_det_rec_fk_unit` (`fk_unit`);

--
-- Index pour la table `llx_facture_fourn_det_rec_extrafields`
--
ALTER TABLE `llx_facture_fourn_det_rec_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `llx_facture_fourn_det_rec_extrafields` (`fk_object`);

--
-- Index pour la table `llx_facture_fourn_extrafields`
--
ALTER TABLE `llx_facture_fourn_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_fourn_extrafields` (`fk_object`);

--
-- Index pour la table `llx_facture_fourn_rec`
--
ALTER TABLE `llx_facture_fourn_rec`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_facture_fourn_rec_ref` (`titre`,`entity`),
  ADD KEY `idx_facture_fourn_rec_fk_soc` (`fk_soc`),
  ADD KEY `idx_facture_fourn_rec_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_facture_fourn_rec_fk_projet` (`fk_projet`);

--
-- Index pour la table `llx_facture_fourn_rec_extrafields`
--
ALTER TABLE `llx_facture_fourn_rec_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_fourn_rec_extrafields` (`fk_object`);

--
-- Index pour la table `llx_facture_rec`
--
ALTER TABLE `llx_facture_rec`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_facture_rec_uk_titre` (`titre`,`entity`),
  ADD KEY `idx_facture_rec_fk_soc` (`fk_soc`),
  ADD KEY `idx_facture_rec_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_facture_rec_fk_projet` (`fk_projet`);

--
-- Index pour la table `llx_facture_rec_extrafields`
--
ALTER TABLE `llx_facture_rec_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_rec_extrafields` (`fk_object`);

--
-- Index pour la table `llx_fichinter`
--
ALTER TABLE `llx_fichinter`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_fichinter_ref` (`ref`,`entity`),
  ADD KEY `idx_fichinter_fk_soc` (`fk_soc`);

--
-- Index pour la table `llx_fichinterdet`
--
ALTER TABLE `llx_fichinterdet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_fichinterdet_fk_fichinter` (`fk_fichinter`);

--
-- Index pour la table `llx_fichinterdet_extrafields`
--
ALTER TABLE `llx_fichinterdet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_ficheinterdet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_fichinterdet_rec`
--
ALTER TABLE `llx_fichinterdet_rec`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_fichinter_extrafields`
--
ALTER TABLE `llx_fichinter_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_ficheinter_extrafields` (`fk_object`);

--
-- Index pour la table `llx_fichinter_rec`
--
ALTER TABLE `llx_fichinter_rec`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_fichinter_rec_uk_titre` (`titre`,`entity`),
  ADD KEY `idx_fichinter_rec_fk_soc` (`fk_soc`),
  ADD KEY `idx_fichinter_rec_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_fichinter_rec_fk_projet` (`fk_projet`);

--
-- Index pour la table `llx_holiday`
--
ALTER TABLE `llx_holiday`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_holiday_entity` (`entity`),
  ADD KEY `idx_holiday_fk_user` (`fk_user`),
  ADD KEY `idx_holiday_fk_user_create` (`fk_user_create`),
  ADD KEY `idx_holiday_date_create` (`date_create`),
  ADD KEY `idx_holiday_date_debut` (`date_debut`),
  ADD KEY `idx_holiday_date_fin` (`date_fin`),
  ADD KEY `idx_holiday_fk_validator` (`fk_validator`);

--
-- Index pour la table `llx_holiday_config`
--
ALTER TABLE `llx_holiday_config`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_holiday_config` (`name`);

--
-- Index pour la table `llx_holiday_extrafields`
--
ALTER TABLE `llx_holiday_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_holiday_extrafields` (`fk_object`);

--
-- Index pour la table `llx_holiday_logs`
--
ALTER TABLE `llx_holiday_logs`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_holiday_users`
--
ALTER TABLE `llx_holiday_users`
  ADD UNIQUE KEY `uk_holiday_users` (`fk_user`,`fk_type`);

--
-- Index pour la table `llx_import_model`
--
ALTER TABLE `llx_import_model`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_import_model` (`label`,`type`);

--
-- Index pour la table `llx_inventory`
--
ALTER TABLE `llx_inventory`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_inventory_ref` (`ref`,`entity`),
  ADD KEY `idx_inventory_tms` (`tms`),
  ADD KEY `idx_inventory_date_creation` (`date_creation`);

--
-- Index pour la table `llx_inventorydet`
--
ALTER TABLE `llx_inventorydet`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_inventorydet` (`fk_inventory`,`fk_warehouse`,`fk_product`,`batch`),
  ADD KEY `idx_inventorydet_tms` (`tms`),
  ADD KEY `idx_inventorydet_datec` (`datec`),
  ADD KEY `idx_inventorydet_fk_inventory` (`fk_inventory`);

--
-- Index pour la table `llx_inventory_extrafields`
--
ALTER TABLE `llx_inventory_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_inventory_extrafields` (`fk_object`);

--
-- Index pour la table `llx_knowledgemanagement_knowledgerecord`
--
ALTER TABLE `llx_knowledgemanagement_knowledgerecord`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_knowledgemanagement_knowledgerecord_rowid` (`rowid`),
  ADD KEY `idx_knowledgemanagement_knowledgerecord_ref` (`ref`),
  ADD KEY `llx_knowledgemanagement_knowledgerecord_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_knowledgemanagement_knowledgerecord_status` (`status`);

--
-- Index pour la table `llx_knowledgemanagement_knowledgerecord_extrafields`
--
ALTER TABLE `llx_knowledgemanagement_knowledgerecord_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_knowledgerecord_fk_object` (`fk_object`);

--
-- Index pour la table `llx_links`
--
ALTER TABLE `llx_links`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_links` (`objectid`,`label`);

--
-- Index pour la table `llx_localtax`
--
ALTER TABLE `llx_localtax`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_mailing`
--
ALTER TABLE `llx_mailing`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_mailing` (`titre`,`entity`);

--
-- Index pour la table `llx_mailing_advtarget`
--
ALTER TABLE `llx_mailing_advtarget`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_advtargetemailing_name` (`name`);

--
-- Index pour la table `llx_mailing_cibles`
--
ALTER TABLE `llx_mailing_cibles`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_mailing_cibles` (`fk_mailing`,`email`),
  ADD KEY `idx_mailing_cibles_email` (`email`),
  ADD KEY `idx_mailing_cibles_tag` (`tag`);

--
-- Index pour la table `llx_mailing_unsubscribe`
--
ALTER TABLE `llx_mailing_unsubscribe`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_mailing_unsubscribe` (`email`,`entity`,`unsubscribegroup`);

--
-- Index pour la table `llx_menu`
--
ALTER TABLE `llx_menu`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_menu_uk_menu` (`menu_handler`,`fk_menu`,`position`,`url`,`entity`),
  ADD KEY `idx_menu_menuhandler_type` (`menu_handler`,`type`);

--
-- Index pour la table `llx_mrp_mo`
--
ALTER TABLE `llx_mrp_mo`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_mrp_mo_ref` (`ref`),
  ADD KEY `idx_mrp_mo_entity` (`entity`),
  ADD KEY `idx_mrp_mo_fk_soc` (`fk_soc`),
  ADD KEY `fk_mrp_mo_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_mrp_mo_status` (`status`),
  ADD KEY `idx_mrp_mo_fk_product` (`fk_product`),
  ADD KEY `idx_mrp_mo_date_start_planned` (`date_start_planned`),
  ADD KEY `idx_mrp_mo_date_end_planned` (`date_end_planned`),
  ADD KEY `idx_mrp_mo_fk_bom` (`fk_bom`),
  ADD KEY `idx_mrp_mo_fk_project` (`fk_project`);

--
-- Index pour la table `llx_mrp_mo_extrafields`
--
ALTER TABLE `llx_mrp_mo_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_mrp_mo_fk_object` (`fk_object`);

--
-- Index pour la table `llx_mrp_production`
--
ALTER TABLE `llx_mrp_production`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_mrp_production_product` (`fk_product`),
  ADD KEY `fk_mrp_production_stock_movement` (`fk_stock_movement`),
  ADD KEY `idx_mrp_production_fk_mo` (`fk_mo`);

--
-- Index pour la table `llx_multicurrency`
--
ALTER TABLE `llx_multicurrency`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_multicurrency_rate`
--
ALTER TABLE `llx_multicurrency_rate`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_notify`
--
ALTER TABLE `llx_notify`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_notify_def`
--
ALTER TABLE `llx_notify_def`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_notify_def_object`
--
ALTER TABLE `llx_notify_def_object`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `llx_oauth_state`
--
ALTER TABLE `llx_oauth_state`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_oauth_token`
--
ALTER TABLE `llx_oauth_token`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_object_lang`
--
ALTER TABLE `llx_object_lang`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_object_lang` (`fk_object`,`type_object`,`property`,`lang`);

--
-- Index pour la table `llx_onlinesignature`
--
ALTER TABLE `llx_onlinesignature`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_overwrite_trans`
--
ALTER TABLE `llx_overwrite_trans`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_overwrite_trans` (`lang`,`transkey`);

--
-- Index pour la table `llx_paiement`
--
ALTER TABLE `llx_paiement`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_paiementcharge`
--
ALTER TABLE `llx_paiementcharge`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_paiementfourn`
--
ALTER TABLE `llx_paiementfourn`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_paiementfourn_facturefourn`
--
ALTER TABLE `llx_paiementfourn_facturefourn`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_paiementfourn_facturefourn` (`fk_paiementfourn`,`fk_facturefourn`),
  ADD KEY `idx_paiementfourn_facturefourn_fk_facture` (`fk_facturefourn`),
  ADD KEY `idx_paiementfourn_facturefourn_fk_paiement` (`fk_paiementfourn`);

--
-- Index pour la table `llx_paiement_facture`
--
ALTER TABLE `llx_paiement_facture`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_paiement_facture` (`fk_paiement`,`fk_facture`),
  ADD KEY `idx_paiement_facture_fk_facture` (`fk_facture`),
  ADD KEY `idx_paiement_facture_fk_paiement` (`fk_paiement`);

--
-- Index pour la table `llx_Paie_bdpParameters`
--
ALTER TABLE `llx_Paie_bdpParameters`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `llx_Paie_HourSupp`
--
ALTER TABLE `llx_Paie_HourSupp`
  ADD PRIMARY KEY (`rub`);

--
-- Index pour la table `llx_Paie_HourSuppDeclaration`
--
ALTER TABLE `llx_Paie_HourSuppDeclaration`
  ADD PRIMARY KEY (`rub`,`month`,`year`,`userid`);

--
-- Index pour la table `llx_Paie_IRParameters`
--
ALTER TABLE `llx_Paie_IRParameters`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `llx_Paie_MonthDeclaration`
--
ALTER TABLE `llx_Paie_MonthDeclaration`
  ADD PRIMARY KEY (`userid`,`year`,`month`);

--
-- Index pour la table `llx_Paie_MonthDeclarationRubs`
--
ALTER TABLE `llx_Paie_MonthDeclarationRubs`
  ADD PRIMARY KEY (`userid`,`year`,`month`);

--
-- Index pour la table `llx_Paie_PrimDancienParameters`
--
ALTER TABLE `llx_Paie_PrimDancienParameters`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `llx_Paie_Rub`
--
ALTER TABLE `llx_Paie_Rub`
  ADD PRIMARY KEY (`rub`);

--
-- Index pour la table `llx_Paie_Rubriques`
--
ALTER TABLE `llx_Paie_Rubriques`
  ADD PRIMARY KEY (`rub`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `llx_Paie_UserInfo`
--
ALTER TABLE `llx_Paie_UserInfo`
  ADD PRIMARY KEY (`userid`);

--
-- Index pour la table `llx_Paie_UserParameters`
--
ALTER TABLE `llx_Paie_UserParameters`
  ADD PRIMARY KEY (`userid`,`rub`);

--
-- Index pour la table `llx_partnership`
--
ALTER TABLE `llx_partnership`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_partnership_ref` (`ref`,`entity`),
  ADD UNIQUE KEY `uk_fk_type_fk_soc` (`fk_type`,`fk_soc`,`date_partnership_start`),
  ADD UNIQUE KEY `uk_fk_type_fk_member` (`fk_type`,`fk_member`,`date_partnership_start`),
  ADD KEY `idx_partnership_entity` (`entity`);

--
-- Index pour la table `llx_partnership_extrafields`
--
ALTER TABLE `llx_partnership_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_partnership_extrafields` (`fk_object`);

--
-- Index pour la table `llx_payment_donation`
--
ALTER TABLE `llx_payment_donation`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_payment_expensereport`
--
ALTER TABLE `llx_payment_expensereport`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_payment_loan`
--
ALTER TABLE `llx_payment_loan`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_payment_salary`
--
ALTER TABLE `llx_payment_salary`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_payment_salary_ref` (`num_payment`),
  ADD KEY `idx_payment_salary_user` (`fk_user`,`entity`),
  ADD KEY `idx_payment_salary_datep` (`datep`),
  ADD KEY `idx_payment_salary_datesp` (`datesp`),
  ADD KEY `idx_payment_salary_dateep` (`dateep`);

--
-- Index pour la table `llx_payment_various`
--
ALTER TABLE `llx_payment_various`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_payment_vat`
--
ALTER TABLE `llx_payment_vat`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_pos_cash_fence`
--
ALTER TABLE `llx_pos_cash_fence`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_prelevement_bons`
--
ALTER TABLE `llx_prelevement_bons`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_prelevement_bons_ref` (`ref`,`entity`);

--
-- Index pour la table `llx_prelevement_facture`
--
ALTER TABLE `llx_prelevement_facture`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_prelevement_facture_fk_prelevement_lignes` (`fk_prelevement_lignes`);

--
-- Index pour la table `llx_prelevement_facture_demande`
--
ALTER TABLE `llx_prelevement_facture_demande`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_prelevement_facture_demande_fk_facture` (`fk_facture`),
  ADD KEY `idx_prelevement_facture_demande_fk_facture_fourn` (`fk_facture_fourn`);

--
-- Index pour la table `llx_prelevement_lignes`
--
ALTER TABLE `llx_prelevement_lignes`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_prelevement_lignes_fk_prelevement_bons` (`fk_prelevement_bons`);

--
-- Index pour la table `llx_prelevement_rejet`
--
ALTER TABLE `llx_prelevement_rejet`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_printing`
--
ALTER TABLE `llx_printing`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_product`
--
ALTER TABLE `llx_product`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_ref` (`ref`,`entity`),
  ADD UNIQUE KEY `uk_product_barcode` (`barcode`,`fk_barcode_type`,`entity`),
  ADD KEY `idx_product_label` (`label`),
  ADD KEY `idx_product_barcode` (`barcode`),
  ADD KEY `idx_product_import_key` (`import_key`),
  ADD KEY `idx_product_seuil_stock_alerte` (`seuil_stock_alerte`),
  ADD KEY `idx_product_fk_country` (`fk_country`),
  ADD KEY `idx_product_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_product_fk_barcode_type` (`fk_barcode_type`),
  ADD KEY `idx_product_fk_project` (`fk_project`),
  ADD KEY `fk_product_fk_unit` (`fk_unit`),
  ADD KEY `fk_product_finished` (`finished`),
  ADD KEY `fk_product_default_warehouse` (`fk_default_warehouse`);

--
-- Index pour la table `llx_product_association`
--
ALTER TABLE `llx_product_association`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_association` (`fk_product_pere`,`fk_product_fils`),
  ADD KEY `idx_product_association_fils` (`fk_product_fils`);

--
-- Index pour la table `llx_product_attribute`
--
ALTER TABLE `llx_product_attribute`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_attribute_ref` (`ref`);

--
-- Index pour la table `llx_product_attribute_combination`
--
ALTER TABLE `llx_product_attribute_combination`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_att_com_product_parent` (`fk_product_parent`),
  ADD KEY `idx_product_att_com_product_child` (`fk_product_child`);

--
-- Index pour la table `llx_product_attribute_combination2val`
--
ALTER TABLE `llx_product_attribute_combination2val`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_product_attribute_combination_price_level`
--
ALTER TABLE `llx_product_attribute_combination_price_level`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `fk_product_attribute_combination` (`fk_product_attribute_combination`,`fk_price_level`);

--
-- Index pour la table `llx_product_attribute_value`
--
ALTER TABLE `llx_product_attribute_value`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_attribute_value` (`fk_product_attribute`,`ref`);

--
-- Index pour la table `llx_product_batch`
--
ALTER TABLE `llx_product_batch`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_batch` (`fk_product_stock`,`batch`),
  ADD KEY `idx_fk_product_stock` (`fk_product_stock`),
  ADD KEY `idx_batch` (`batch`);

--
-- Index pour la table `llx_product_customer_price`
--
ALTER TABLE `llx_product_customer_price`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_customer_price_fk_product_fk_soc` (`fk_product`,`fk_soc`),
  ADD KEY `idx_product_customer_price_fk_user` (`fk_user`),
  ADD KEY `idx_product_customer_price_fk_soc` (`fk_soc`);

--
-- Index pour la table `llx_product_customer_price_log`
--
ALTER TABLE `llx_product_customer_price_log`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_product_extrafields`
--
ALTER TABLE `llx_product_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_extrafields` (`fk_object`);

--
-- Index pour la table `llx_product_fournisseur_price`
--
ALTER TABLE `llx_product_fournisseur_price`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_fournisseur_price_ref` (`ref_fourn`,`fk_soc`,`quantity`,`entity`),
  ADD UNIQUE KEY `uk_product_barcode` (`barcode`,`fk_barcode_type`,`entity`),
  ADD KEY `idx_product_fournisseur_price_fk_user` (`fk_user`),
  ADD KEY `idx_product_fourn_price_fk_product` (`fk_product`,`entity`),
  ADD KEY `idx_product_fourn_price_fk_soc` (`fk_soc`,`entity`),
  ADD KEY `idx_product_barcode` (`barcode`),
  ADD KEY `idx_product_fk_barcode_type` (`fk_barcode_type`);

--
-- Index pour la table `llx_product_fournisseur_price_extrafields`
--
ALTER TABLE `llx_product_fournisseur_price_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_fournisseur_price_extrafields` (`fk_object`);

--
-- Index pour la table `llx_product_fournisseur_price_log`
--
ALTER TABLE `llx_product_fournisseur_price_log`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_product_lang`
--
ALTER TABLE `llx_product_lang`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_lang` (`fk_product`,`lang`);

--
-- Index pour la table `llx_product_lot`
--
ALTER TABLE `llx_product_lot`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_lot` (`fk_product`,`batch`);

--
-- Index pour la table `llx_product_lot_extrafields`
--
ALTER TABLE `llx_product_lot_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_lot_extrafields` (`fk_object`);

--
-- Index pour la table `llx_product_price`
--
ALTER TABLE `llx_product_price`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_price_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_product_price_fk_product` (`fk_product`);

--
-- Index pour la table `llx_product_pricerules`
--
ALTER TABLE `llx_product_pricerules`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `unique_level` (`level`);

--
-- Index pour la table `llx_product_price_by_qty`
--
ALTER TABLE `llx_product_price_by_qty`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_price_by_qty_level` (`fk_product_price`,`quantity`),
  ADD KEY `idx_product_price_by_qty_fk_product_price` (`fk_product_price`);

--
-- Index pour la table `llx_product_stock`
--
ALTER TABLE `llx_product_stock`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_stock` (`fk_product`,`fk_entrepot`),
  ADD KEY `idx_product_stock_fk_product` (`fk_product`),
  ADD KEY `idx_product_stock_fk_entrepot` (`fk_entrepot`);

--
-- Index pour la table `llx_product_warehouse_properties`
--
ALTER TABLE `llx_product_warehouse_properties`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_projet`
--
ALTER TABLE `llx_projet`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_projet_ref` (`ref`,`entity`),
  ADD KEY `idx_projet_fk_soc` (`fk_soc`),
  ADD KEY `idx_projet_ref` (`ref`),
  ADD KEY `idx_projet_fk_statut` (`fk_statut`),
  ADD KEY `idx_projet_fk_opp_status` (`fk_opp_status`);

--
-- Index pour la table `llx_projet_extrafields`
--
ALTER TABLE `llx_projet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_projet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_projet_task`
--
ALTER TABLE `llx_projet_task`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_projet_task_ref` (`ref`,`entity`),
  ADD KEY `idx_projet_task_fk_projet` (`fk_projet`),
  ADD KEY `idx_projet_task_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_projet_task_fk_user_valid` (`fk_user_valid`);

--
-- Index pour la table `llx_projet_task_extrafields`
--
ALTER TABLE `llx_projet_task_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_projet_task_extrafields` (`fk_object`);

--
-- Index pour la table `llx_projet_task_time`
--
ALTER TABLE `llx_projet_task_time`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_projet_task_time_task` (`fk_task`),
  ADD KEY `idx_projet_task_time_date` (`task_date`),
  ADD KEY `idx_projet_task_time_datehour` (`task_datehour`);

--
-- Index pour la table `llx_propal`
--
ALTER TABLE `llx_propal`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_propal_ref` (`ref`,`entity`),
  ADD KEY `idx_propal_fk_soc` (`fk_soc`),
  ADD KEY `idx_propal_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_propal_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_propal_fk_user_signature` (`fk_user_signature`),
  ADD KEY `idx_propal_fk_user_cloture` (`fk_user_cloture`),
  ADD KEY `idx_propal_fk_projet` (`fk_projet`),
  ADD KEY `idx_propal_fk_account` (`fk_account`),
  ADD KEY `idx_propal_fk_currency` (`fk_currency`),
  ADD KEY `idx_propal_fk_warehouse` (`fk_warehouse`);

--
-- Index pour la table `llx_propaldet`
--
ALTER TABLE `llx_propaldet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_propaldet_fk_propal` (`fk_propal`),
  ADD KEY `idx_propaldet_fk_product` (`fk_product`),
  ADD KEY `fk_propaldet_fk_unit` (`fk_unit`);

--
-- Index pour la table `llx_propaldet_extrafields`
--
ALTER TABLE `llx_propaldet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_propaldet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_propal_extrafields`
--
ALTER TABLE `llx_propal_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_propal_extrafields` (`fk_object`);

--
-- Index pour la table `llx_propal_merge_pdf_product`
--
ALTER TABLE `llx_propal_merge_pdf_product`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_reception`
--
ALTER TABLE `llx_reception`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_reception_uk_ref` (`ref`,`entity`),
  ADD KEY `idx_reception_fk_soc` (`fk_soc`),
  ADD KEY `idx_reception_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_reception_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_reception_fk_shipping_method` (`fk_shipping_method`);

--
-- Index pour la table `llx_reception_extrafields`
--
ALTER TABLE `llx_reception_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_reception_extrafields` (`fk_object`);

--
-- Index pour la table `llx_recruitment_recruitmentcandidature`
--
ALTER TABLE `llx_recruitment_recruitmentcandidature`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_recruitmentcandidature_email_msgid` (`email_msgid`),
  ADD KEY `idx_recruitment_recruitmentcandidature_rowid` (`rowid`),
  ADD KEY `idx_recruitment_recruitmentcandidature_ref` (`ref`),
  ADD KEY `llx_recruitment_recruitmentcandidature_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_recruitment_recruitmentcandidature_status` (`status`);

--
-- Index pour la table `llx_recruitment_recruitmentcandidature_extrafields`
--
ALTER TABLE `llx_recruitment_recruitmentcandidature_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_recruitmentcandidature_fk_object` (`fk_object`);

--
-- Index pour la table `llx_recruitment_recruitmentjobposition`
--
ALTER TABLE `llx_recruitment_recruitmentjobposition`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_recruitment_recruitmentjobposition_rowid` (`rowid`),
  ADD KEY `idx_recruitment_recruitmentjobposition_ref` (`ref`),
  ADD KEY `idx_recruitment_recruitmentjobposition_fk_soc` (`fk_soc`),
  ADD KEY `idx_recruitment_recruitmentjobposition_fk_project` (`fk_project`),
  ADD KEY `llx_recruitment_recruitmentjobposition_fk_user_recruiter` (`fk_user_recruiter`),
  ADD KEY `llx_recruitment_recruitmentjobposition_fk_user_supervisor` (`fk_user_supervisor`),
  ADD KEY `llx_recruitment_recruitmentjobposition_fk_establishment` (`fk_establishment`),
  ADD KEY `llx_recruitment_recruitmentjobposition_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_recruitment_recruitmentjobposition_status` (`status`);

--
-- Index pour la table `llx_recruitment_recruitmentjobposition_extrafields`
--
ALTER TABLE `llx_recruitment_recruitmentjobposition_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_recruitmentjobposition_fk_object` (`fk_object`);

--
-- Index pour la table `llx_resource`
--
ALTER TABLE `llx_resource`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_resource_ref` (`ref`,`entity`),
  ADD KEY `fk_code_type_resource_idx` (`fk_code_type_resource`),
  ADD KEY `idx_resource_fk_country` (`fk_country`);

--
-- Index pour la table `llx_resource_extrafields`
--
ALTER TABLE `llx_resource_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_resource_extrafields` (`fk_object`);

--
-- Index pour la table `llx_rights_def`
--
ALTER TABLE `llx_rights_def`
  ADD PRIMARY KEY (`id`,`entity`);

--
-- Index pour la table `llx_salary`
--
ALTER TABLE `llx_salary`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_salary_extrafields`
--
ALTER TABLE `llx_salary_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_salary_extrafields` (`fk_object`);

--
-- Index pour la table `llx_session`
--
ALTER TABLE `llx_session`
  ADD PRIMARY KEY (`session_id`);

--
-- Index pour la table `llx_societe`
--
ALTER TABLE `llx_societe`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_prefix_comm` (`prefix_comm`,`entity`),
  ADD UNIQUE KEY `uk_societe_code_client` (`code_client`,`entity`),
  ADD UNIQUE KEY `uk_societe_code_fournisseur` (`code_fournisseur`,`entity`),
  ADD UNIQUE KEY `uk_societe_barcode` (`barcode`,`fk_barcode_type`,`entity`),
  ADD KEY `idx_societe_user_creat` (`fk_user_creat`),
  ADD KEY `idx_societe_user_modif` (`fk_user_modif`),
  ADD KEY `idx_societe_stcomm` (`fk_stcomm`),
  ADD KEY `idx_societe_pays` (`fk_pays`),
  ADD KEY `idx_societe_account` (`fk_account`),
  ADD KEY `idx_societe_prospectlevel` (`fk_prospectlevel`),
  ADD KEY `idx_societe_typent` (`fk_typent`),
  ADD KEY `idx_societe_forme_juridique` (`fk_forme_juridique`),
  ADD KEY `idx_societe_shipping_method` (`fk_shipping_method`);

--
-- Index pour la table `llx_societe_account`
--
ALTER TABLE `llx_societe_account`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_account_login_website_soc` (`entity`,`fk_soc`,`login`,`site`,`fk_website`),
  ADD UNIQUE KEY `uk_societe_account_key_account_soc` (`entity`,`fk_soc`,`key_account`,`site`,`fk_website`),
  ADD KEY `idx_societe_account_rowid` (`rowid`),
  ADD KEY `idx_societe_account_login` (`login`),
  ADD KEY `idx_societe_account_status` (`status`),
  ADD KEY `idx_societe_account_fk_website` (`fk_website`),
  ADD KEY `idx_societe_account_fk_soc` (`fk_soc`);

--
-- Index pour la table `llx_societe_address`
--
ALTER TABLE `llx_societe_address`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_societe_commerciaux`
--
ALTER TABLE `llx_societe_commerciaux`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_commerciaux` (`fk_soc`,`fk_user`);

--
-- Index pour la table `llx_societe_contacts`
--
ALTER TABLE `llx_societe_contacts`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_societe_contacts_idx1` (`entity`,`fk_soc`,`fk_c_type_contact`,`fk_socpeople`),
  ADD KEY `fk_societe_contacts_fk_c_type_contact` (`fk_c_type_contact`),
  ADD KEY `fk_societe_contacts_fk_soc` (`fk_soc`),
  ADD KEY `fk_societe_contacts_fk_socpeople` (`fk_socpeople`);

--
-- Index pour la table `llx_societe_extrafields`
--
ALTER TABLE `llx_societe_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_extrafields` (`fk_object`);

--
-- Index pour la table `llx_societe_prices`
--
ALTER TABLE `llx_societe_prices`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_societe_remise`
--
ALTER TABLE `llx_societe_remise`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_societe_remise_except`
--
ALTER TABLE `llx_societe_remise_except`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_societe_remise_except_fk_user` (`fk_user`),
  ADD KEY `idx_societe_remise_except_fk_soc` (`fk_soc`),
  ADD KEY `idx_societe_remise_except_fk_facture_line` (`fk_facture_line`),
  ADD KEY `idx_societe_remise_except_fk_facture` (`fk_facture`),
  ADD KEY `idx_societe_remise_except_fk_facture_source` (`fk_facture_source`),
  ADD KEY `idx_societe_remise_except_discount_type` (`discount_type`),
  ADD KEY `fk_soc_remise_fk_invoice_supplier_line` (`fk_invoice_supplier_line`),
  ADD KEY `fk_societe_remise_fk_invoice_supplier_source` (`fk_invoice_supplier`);

--
-- Index pour la table `llx_societe_remise_supplier`
--
ALTER TABLE `llx_societe_remise_supplier`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_societe_rib`
--
ALTER TABLE `llx_societe_rib`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_rib` (`label`,`fk_soc`),
  ADD KEY `llx_societe_rib_fk_societe` (`fk_soc`);

--
-- Index pour la table `llx_socpeople`
--
ALTER TABLE `llx_socpeople`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_socpeople_fk_soc` (`fk_soc`),
  ADD KEY `idx_socpeople_fk_user_creat` (`fk_user_creat`);

--
-- Index pour la table `llx_socpeople_extrafields`
--
ALTER TABLE `llx_socpeople_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_socpeople_extrafields` (`fk_object`);

--
-- Index pour la table `llx_stock_mouvement`
--
ALTER TABLE `llx_stock_mouvement`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_stock_mouvement_fk_product` (`fk_product`),
  ADD KEY `idx_stock_mouvement_fk_entrepot` (`fk_entrepot`);

--
-- Index pour la table `llx_stock_mouvement_extrafields`
--
ALTER TABLE `llx_stock_mouvement_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_stock_mouvement_extrafields` (`fk_object`);

--
-- Index pour la table `llx_subscription`
--
ALTER TABLE `llx_subscription`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_subscription` (`fk_adherent`,`dateadh`);

--
-- Index pour la table `llx_supplier_proposal`
--
ALTER TABLE `llx_supplier_proposal`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_supplier_proposaldet`
--
ALTER TABLE `llx_supplier_proposaldet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_supplier_proposaldet_fk_supplier_proposal` (`fk_supplier_proposal`),
  ADD KEY `idx_supplier_proposaldet_fk_product` (`fk_product`),
  ADD KEY `fk_supplier_proposaldet_fk_unit` (`fk_unit`);

--
-- Index pour la table `llx_supplier_proposaldet_extrafields`
--
ALTER TABLE `llx_supplier_proposaldet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_supplier_proposaldet_extrafields` (`fk_object`);

--
-- Index pour la table `llx_supplier_proposal_extrafields`
--
ALTER TABLE `llx_supplier_proposal_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_supplier_proposal_extrafields` (`fk_object`);

--
-- Index pour la table `llx_takepos_floor_tables`
--
ALTER TABLE `llx_takepos_floor_tables`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `entity` (`entity`,`label`);

--
-- Index pour la table `llx_tva`
--
ALTER TABLE `llx_tva`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_user`
--
ALTER TABLE `llx_user`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_user_login` (`login`,`entity`),
  ADD UNIQUE KEY `uk_user_fk_socpeople` (`fk_socpeople`),
  ADD UNIQUE KEY `uk_user_fk_member` (`fk_member`),
  ADD UNIQUE KEY `uk_user_api_key` (`api_key`),
  ADD KEY `idx_user_fk_societe` (`fk_soc`);

--
-- Index pour la table `llx_usergroup`
--
ALTER TABLE `llx_usergroup`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_usergroup_name` (`nom`,`entity`);

--
-- Index pour la table `llx_usergroup_extrafields`
--
ALTER TABLE `llx_usergroup_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_usergroup_extrafields` (`fk_object`);

--
-- Index pour la table `llx_usergroup_rights`
--
ALTER TABLE `llx_usergroup_rights`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_usergroup_rights` (`entity`,`fk_usergroup`,`fk_id`),
  ADD KEY `fk_usergroup_rights_fk_usergroup` (`fk_usergroup`);

--
-- Index pour la table `llx_usergroup_user`
--
ALTER TABLE `llx_usergroup_user`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_usergroup_user` (`entity`,`fk_user`,`fk_usergroup`),
  ADD KEY `fk_usergroup_user_fk_user` (`fk_user`),
  ADD KEY `fk_usergroup_user_fk_usergroup` (`fk_usergroup`);

--
-- Index pour la table `llx_user_alert`
--
ALTER TABLE `llx_user_alert`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_user_clicktodial`
--
ALTER TABLE `llx_user_clicktodial`
  ADD PRIMARY KEY (`fk_user`);

--
-- Index pour la table `llx_user_employment`
--
ALTER TABLE `llx_user_employment`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_user_employment` (`ref`,`entity`),
  ADD KEY `fk_user_employment_fk_user` (`fk_user`);

--
-- Index pour la table `llx_user_extrafields`
--
ALTER TABLE `llx_user_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_user_extrafields_cin` (`cin`),
  ADD UNIQUE KEY `uk_user_extrafields_matricule` (`matricule`),
  ADD UNIQUE KEY `uk_user_extrafields_idpointage` (`idpointage`),
  ADD KEY `idx_user_extrafields` (`fk_object`);

--
-- Index pour la table `llx_user_param`
--
ALTER TABLE `llx_user_param`
  ADD UNIQUE KEY `uk_user_param` (`fk_user`,`param`,`entity`);

--
-- Index pour la table `llx_user_rib`
--
ALTER TABLE `llx_user_rib`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `llx_user_rights`
--
ALTER TABLE `llx_user_rights`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_user_rights` (`entity`,`fk_user`,`fk_id`),
  ADD KEY `fk_user_rights_fk_user_user` (`fk_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `llx_accounting_account`
--
ALTER TABLE `llx_accounting_account`
  MODIFY `rowid` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_accounting_bookkeeping`
--
ALTER TABLE `llx_accounting_bookkeeping`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_accounting_bookkeeping_tmp`
--
ALTER TABLE `llx_accounting_bookkeeping_tmp`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_accounting_fiscalyear`
--
ALTER TABLE `llx_accounting_fiscalyear`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_accounting_groups_account`
--
ALTER TABLE `llx_accounting_groups_account`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_accounting_journal`
--
ALTER TABLE `llx_accounting_journal`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_accounting_system`
--
ALTER TABLE `llx_accounting_system`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_actioncomm`
--
ALTER TABLE `llx_actioncomm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_actioncomm_extrafields`
--
ALTER TABLE `llx_actioncomm_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_actioncomm_reminder`
--
ALTER TABLE `llx_actioncomm_reminder`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_actioncomm_resources`
--
ALTER TABLE `llx_actioncomm_resources`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_adherent`
--
ALTER TABLE `llx_adherent`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_adherent_extrafields`
--
ALTER TABLE `llx_adherent_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_adherent_type`
--
ALTER TABLE `llx_adherent_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_adherent_type_extrafields`
--
ALTER TABLE `llx_adherent_type_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_adherent_type_lang`
--
ALTER TABLE `llx_adherent_type_lang`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bank`
--
ALTER TABLE `llx_bank`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bank_account`
--
ALTER TABLE `llx_bank_account`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bank_account_extrafields`
--
ALTER TABLE `llx_bank_account_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bank_categ`
--
ALTER TABLE `llx_bank_categ`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bank_url`
--
ALTER TABLE `llx_bank_url`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_blockedlog`
--
ALTER TABLE `llx_blockedlog`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_blockedlog_authority`
--
ALTER TABLE `llx_blockedlog_authority`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bom_bom`
--
ALTER TABLE `llx_bom_bom`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bom_bomline`
--
ALTER TABLE `llx_bom_bomline`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bom_bomline_extrafields`
--
ALTER TABLE `llx_bom_bomline_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bom_bom_extrafields`
--
ALTER TABLE `llx_bom_bom_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bookmark`
--
ALTER TABLE `llx_bookmark`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_bordereau_cheque`
--
ALTER TABLE `llx_bordereau_cheque`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_boxes`
--
ALTER TABLE `llx_boxes`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_boxes_def`
--
ALTER TABLE `llx_boxes_def`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_budget`
--
ALTER TABLE `llx_budget`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_budget_lines`
--
ALTER TABLE `llx_budget_lines`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_categorie`
--
ALTER TABLE `llx_categorie`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_categories_extrafields`
--
ALTER TABLE `llx_categories_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_categorie_lang`
--
ALTER TABLE `llx_categorie_lang`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_chargesociales`
--
ALTER TABLE `llx_chargesociales`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commande`
--
ALTER TABLE `llx_commande`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commandedet`
--
ALTER TABLE `llx_commandedet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commandedet_extrafields`
--
ALTER TABLE `llx_commandedet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commande_extrafields`
--
ALTER TABLE `llx_commande_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commande_fournisseur`
--
ALTER TABLE `llx_commande_fournisseur`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commande_fournisseurdet`
--
ALTER TABLE `llx_commande_fournisseurdet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commande_fournisseurdet_extrafields`
--
ALTER TABLE `llx_commande_fournisseurdet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commande_fournisseur_dispatch`
--
ALTER TABLE `llx_commande_fournisseur_dispatch`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commande_fournisseur_dispatch_extrafields`
--
ALTER TABLE `llx_commande_fournisseur_dispatch_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commande_fournisseur_extrafields`
--
ALTER TABLE `llx_commande_fournisseur_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_commande_fournisseur_log`
--
ALTER TABLE `llx_commande_fournisseur_log`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_comment`
--
ALTER TABLE `llx_comment`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_const`
--
ALTER TABLE `llx_const`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_contrat`
--
ALTER TABLE `llx_contrat`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_contratdet`
--
ALTER TABLE `llx_contratdet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_contratdet_extrafields`
--
ALTER TABLE `llx_contratdet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_contratdet_log`
--
ALTER TABLE `llx_contratdet_log`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_contrat_extrafields`
--
ALTER TABLE `llx_contrat_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_cronjob`
--
ALTER TABLE `llx_cronjob`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_accounting_category`
--
ALTER TABLE `llx_c_accounting_category`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_action_trigger`
--
ALTER TABLE `llx_c_action_trigger`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_availability`
--
ALTER TABLE `llx_c_availability`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_barcode_type`
--
ALTER TABLE `llx_c_barcode_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_chargesociales`
--
ALTER TABLE `llx_c_chargesociales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_civility`
--
ALTER TABLE `llx_c_civility`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_departements`
--
ALTER TABLE `llx_c_departements`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_ecotaxe`
--
ALTER TABLE `llx_c_ecotaxe`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_email_senderprofile`
--
ALTER TABLE `llx_c_email_senderprofile`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_email_templates`
--
ALTER TABLE `llx_c_email_templates`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_exp_tax_cat`
--
ALTER TABLE `llx_c_exp_tax_cat`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_exp_tax_range`
--
ALTER TABLE `llx_c_exp_tax_range`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_field_list`
--
ALTER TABLE `llx_c_field_list`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_format_cards`
--
ALTER TABLE `llx_c_format_cards`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_forme_juridique`
--
ALTER TABLE `llx_c_forme_juridique`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_holiday_types`
--
ALTER TABLE `llx_c_holiday_types`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_hrm_public_holiday`
--
ALTER TABLE `llx_c_hrm_public_holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_incoterms`
--
ALTER TABLE `llx_c_incoterms`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_input_method`
--
ALTER TABLE `llx_c_input_method`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_input_reason`
--
ALTER TABLE `llx_c_input_reason`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_lead_status`
--
ALTER TABLE `llx_c_lead_status`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_paiement`
--
ALTER TABLE `llx_c_paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_paper_format`
--
ALTER TABLE `llx_c_paper_format`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_partnership_type`
--
ALTER TABLE `llx_c_partnership_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_payment_term`
--
ALTER TABLE `llx_c_payment_term`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_price_expression`
--
ALTER TABLE `llx_c_price_expression`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_price_global_variable`
--
ALTER TABLE `llx_c_price_global_variable`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_price_global_variable_updater`
--
ALTER TABLE `llx_c_price_global_variable_updater`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_productbatch_qcstatus`
--
ALTER TABLE `llx_c_productbatch_qcstatus`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_product_nature`
--
ALTER TABLE `llx_c_product_nature`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_recruitment_origin`
--
ALTER TABLE `llx_c_recruitment_origin`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_regions`
--
ALTER TABLE `llx_c_regions`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_revenuestamp`
--
ALTER TABLE `llx_c_revenuestamp`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_shipment_mode`
--
ALTER TABLE `llx_c_shipment_mode`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_shipment_package_type`
--
ALTER TABLE `llx_c_shipment_package_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_socialnetworks`
--
ALTER TABLE `llx_c_socialnetworks`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_ticket_category`
--
ALTER TABLE `llx_c_ticket_category`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_ticket_resolution`
--
ALTER TABLE `llx_c_ticket_resolution`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_ticket_severity`
--
ALTER TABLE `llx_c_ticket_severity`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_ticket_type`
--
ALTER TABLE `llx_c_ticket_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_transport_mode`
--
ALTER TABLE `llx_c_transport_mode`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_tva`
--
ALTER TABLE `llx_c_tva`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_type_contact`
--
ALTER TABLE `llx_c_type_contact`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_type_container`
--
ALTER TABLE `llx_c_type_container`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_type_fees`
--
ALTER TABLE `llx_c_type_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_type_resource`
--
ALTER TABLE `llx_c_type_resource`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_units`
--
ALTER TABLE `llx_c_units`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_c_ziptown`
--
ALTER TABLE `llx_c_ziptown`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_default_values`
--
ALTER TABLE `llx_default_values`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_delivery`
--
ALTER TABLE `llx_delivery`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_deliverydet`
--
ALTER TABLE `llx_deliverydet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_deliverydet_extrafields`
--
ALTER TABLE `llx_deliverydet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_delivery_extrafields`
--
ALTER TABLE `llx_delivery_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_document_model`
--
ALTER TABLE `llx_document_model`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_ecm_directories`
--
ALTER TABLE `llx_ecm_directories`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_ecm_directories_extrafields`
--
ALTER TABLE `llx_ecm_directories_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_ecm_files`
--
ALTER TABLE `llx_ecm_files`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_ecm_files_extrafields`
--
ALTER TABLE `llx_ecm_files_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_element_contact`
--
ALTER TABLE `llx_element_contact`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_element_element`
--
ALTER TABLE `llx_element_element`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_element_resources`
--
ALTER TABLE `llx_element_resources`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_element_tag`
--
ALTER TABLE `llx_element_tag`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_emailcollector_emailcollector`
--
ALTER TABLE `llx_emailcollector_emailcollector`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_emailcollector_emailcollectoraction`
--
ALTER TABLE `llx_emailcollector_emailcollectoraction`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_emailcollector_emailcollectorfilter`
--
ALTER TABLE `llx_emailcollector_emailcollectorfilter`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_entrepot`
--
ALTER TABLE `llx_entrepot`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_entrepot_extrafields`
--
ALTER TABLE `llx_entrepot_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_establishment`
--
ALTER TABLE `llx_establishment`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_eventorganization_conferenceorboothattendee`
--
ALTER TABLE `llx_eventorganization_conferenceorboothattendee`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_eventorganization_conferenceorboothattendee_extrafields`
--
ALTER TABLE `llx_eventorganization_conferenceorboothattendee_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_events`
--
ALTER TABLE `llx_events`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_event_element`
--
ALTER TABLE `llx_event_element`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expedition`
--
ALTER TABLE `llx_expedition`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expeditiondet`
--
ALTER TABLE `llx_expeditiondet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expeditiondet_batch`
--
ALTER TABLE `llx_expeditiondet_batch`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expeditiondet_extrafields`
--
ALTER TABLE `llx_expeditiondet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expedition_extrafields`
--
ALTER TABLE `llx_expedition_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expedition_package`
--
ALTER TABLE `llx_expedition_package`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expedition_packagedet`
--
ALTER TABLE `llx_expedition_packagedet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expedition_package_extrafields`
--
ALTER TABLE `llx_expedition_package_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expensereport`
--
ALTER TABLE `llx_expensereport`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expensereport_det`
--
ALTER TABLE `llx_expensereport_det`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expensereport_extrafields`
--
ALTER TABLE `llx_expensereport_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expensereport_ik`
--
ALTER TABLE `llx_expensereport_ik`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_expensereport_rules`
--
ALTER TABLE `llx_expensereport_rules`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_export_compta`
--
ALTER TABLE `llx_export_compta`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_export_model`
--
ALTER TABLE `llx_export_model`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_extrafields`
--
ALTER TABLE `llx_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture`
--
ALTER TABLE `llx_facture`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facturedet`
--
ALTER TABLE `llx_facturedet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facturedet_extrafields`
--
ALTER TABLE `llx_facturedet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facturedet_rec`
--
ALTER TABLE `llx_facturedet_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facturedet_rec_extrafields`
--
ALTER TABLE `llx_facturedet_rec_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_extrafields`
--
ALTER TABLE `llx_facture_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_fourn`
--
ALTER TABLE `llx_facture_fourn`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_fourn_det`
--
ALTER TABLE `llx_facture_fourn_det`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_fourn_det_extrafields`
--
ALTER TABLE `llx_facture_fourn_det_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_fourn_det_rec`
--
ALTER TABLE `llx_facture_fourn_det_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_fourn_det_rec_extrafields`
--
ALTER TABLE `llx_facture_fourn_det_rec_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_fourn_extrafields`
--
ALTER TABLE `llx_facture_fourn_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_fourn_rec`
--
ALTER TABLE `llx_facture_fourn_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_fourn_rec_extrafields`
--
ALTER TABLE `llx_facture_fourn_rec_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_rec`
--
ALTER TABLE `llx_facture_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_facture_rec_extrafields`
--
ALTER TABLE `llx_facture_rec_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_fichinter`
--
ALTER TABLE `llx_fichinter`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_fichinterdet`
--
ALTER TABLE `llx_fichinterdet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_fichinterdet_extrafields`
--
ALTER TABLE `llx_fichinterdet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_fichinterdet_rec`
--
ALTER TABLE `llx_fichinterdet_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_fichinter_extrafields`
--
ALTER TABLE `llx_fichinter_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_fichinter_rec`
--
ALTER TABLE `llx_fichinter_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_holiday`
--
ALTER TABLE `llx_holiday`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_holiday_config`
--
ALTER TABLE `llx_holiday_config`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_holiday_extrafields`
--
ALTER TABLE `llx_holiday_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_holiday_logs`
--
ALTER TABLE `llx_holiday_logs`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_import_model`
--
ALTER TABLE `llx_import_model`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_inventory`
--
ALTER TABLE `llx_inventory`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_inventorydet`
--
ALTER TABLE `llx_inventorydet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_inventory_extrafields`
--
ALTER TABLE `llx_inventory_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_knowledgemanagement_knowledgerecord`
--
ALTER TABLE `llx_knowledgemanagement_knowledgerecord`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_knowledgemanagement_knowledgerecord_extrafields`
--
ALTER TABLE `llx_knowledgemanagement_knowledgerecord_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_links`
--
ALTER TABLE `llx_links`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_localtax`
--
ALTER TABLE `llx_localtax`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_mailing`
--
ALTER TABLE `llx_mailing`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_mailing_advtarget`
--
ALTER TABLE `llx_mailing_advtarget`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_mailing_cibles`
--
ALTER TABLE `llx_mailing_cibles`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_mailing_unsubscribe`
--
ALTER TABLE `llx_mailing_unsubscribe`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_menu`
--
ALTER TABLE `llx_menu`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_mrp_mo`
--
ALTER TABLE `llx_mrp_mo`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_mrp_mo_extrafields`
--
ALTER TABLE `llx_mrp_mo_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_mrp_production`
--
ALTER TABLE `llx_mrp_production`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_multicurrency`
--
ALTER TABLE `llx_multicurrency`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_multicurrency_rate`
--
ALTER TABLE `llx_multicurrency_rate`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_notify`
--
ALTER TABLE `llx_notify`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_notify_def`
--
ALTER TABLE `llx_notify_def`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_notify_def_object`
--
ALTER TABLE `llx_notify_def_object`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_oauth_state`
--
ALTER TABLE `llx_oauth_state`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_oauth_token`
--
ALTER TABLE `llx_oauth_token`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_object_lang`
--
ALTER TABLE `llx_object_lang`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_onlinesignature`
--
ALTER TABLE `llx_onlinesignature`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_overwrite_trans`
--
ALTER TABLE `llx_overwrite_trans`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_paiement`
--
ALTER TABLE `llx_paiement`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_paiementcharge`
--
ALTER TABLE `llx_paiementcharge`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_paiementfourn`
--
ALTER TABLE `llx_paiementfourn`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_paiementfourn_facturefourn`
--
ALTER TABLE `llx_paiementfourn_facturefourn`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_paiement_facture`
--
ALTER TABLE `llx_paiement_facture`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_partnership`
--
ALTER TABLE `llx_partnership`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_partnership_extrafields`
--
ALTER TABLE `llx_partnership_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_payment_donation`
--
ALTER TABLE `llx_payment_donation`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_payment_expensereport`
--
ALTER TABLE `llx_payment_expensereport`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_payment_loan`
--
ALTER TABLE `llx_payment_loan`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_payment_salary`
--
ALTER TABLE `llx_payment_salary`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_payment_various`
--
ALTER TABLE `llx_payment_various`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_payment_vat`
--
ALTER TABLE `llx_payment_vat`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_pos_cash_fence`
--
ALTER TABLE `llx_pos_cash_fence`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_prelevement_bons`
--
ALTER TABLE `llx_prelevement_bons`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_prelevement_facture`
--
ALTER TABLE `llx_prelevement_facture`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_prelevement_facture_demande`
--
ALTER TABLE `llx_prelevement_facture_demande`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_prelevement_lignes`
--
ALTER TABLE `llx_prelevement_lignes`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_prelevement_rejet`
--
ALTER TABLE `llx_prelevement_rejet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_printing`
--
ALTER TABLE `llx_printing`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product`
--
ALTER TABLE `llx_product`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_association`
--
ALTER TABLE `llx_product_association`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_attribute`
--
ALTER TABLE `llx_product_attribute`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_attribute_combination`
--
ALTER TABLE `llx_product_attribute_combination`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_attribute_combination2val`
--
ALTER TABLE `llx_product_attribute_combination2val`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_attribute_combination_price_level`
--
ALTER TABLE `llx_product_attribute_combination_price_level`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_attribute_value`
--
ALTER TABLE `llx_product_attribute_value`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_batch`
--
ALTER TABLE `llx_product_batch`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_customer_price`
--
ALTER TABLE `llx_product_customer_price`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_customer_price_log`
--
ALTER TABLE `llx_product_customer_price_log`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_extrafields`
--
ALTER TABLE `llx_product_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_fournisseur_price`
--
ALTER TABLE `llx_product_fournisseur_price`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_fournisseur_price_extrafields`
--
ALTER TABLE `llx_product_fournisseur_price_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_fournisseur_price_log`
--
ALTER TABLE `llx_product_fournisseur_price_log`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_lang`
--
ALTER TABLE `llx_product_lang`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_lot`
--
ALTER TABLE `llx_product_lot`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_lot_extrafields`
--
ALTER TABLE `llx_product_lot_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_price`
--
ALTER TABLE `llx_product_price`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_pricerules`
--
ALTER TABLE `llx_product_pricerules`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_price_by_qty`
--
ALTER TABLE `llx_product_price_by_qty`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_stock`
--
ALTER TABLE `llx_product_stock`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_product_warehouse_properties`
--
ALTER TABLE `llx_product_warehouse_properties`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_projet`
--
ALTER TABLE `llx_projet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_projet_extrafields`
--
ALTER TABLE `llx_projet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_projet_task`
--
ALTER TABLE `llx_projet_task`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_projet_task_extrafields`
--
ALTER TABLE `llx_projet_task_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_projet_task_time`
--
ALTER TABLE `llx_projet_task_time`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_propal`
--
ALTER TABLE `llx_propal`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_propaldet`
--
ALTER TABLE `llx_propaldet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_propaldet_extrafields`
--
ALTER TABLE `llx_propaldet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_propal_extrafields`
--
ALTER TABLE `llx_propal_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_propal_merge_pdf_product`
--
ALTER TABLE `llx_propal_merge_pdf_product`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_reception`
--
ALTER TABLE `llx_reception`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_reception_extrafields`
--
ALTER TABLE `llx_reception_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_recruitment_recruitmentcandidature`
--
ALTER TABLE `llx_recruitment_recruitmentcandidature`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_recruitment_recruitmentcandidature_extrafields`
--
ALTER TABLE `llx_recruitment_recruitmentcandidature_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_recruitment_recruitmentjobposition`
--
ALTER TABLE `llx_recruitment_recruitmentjobposition`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_recruitment_recruitmentjobposition_extrafields`
--
ALTER TABLE `llx_recruitment_recruitmentjobposition_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_resource`
--
ALTER TABLE `llx_resource`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_resource_extrafields`
--
ALTER TABLE `llx_resource_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_salary`
--
ALTER TABLE `llx_salary`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_salary_extrafields`
--
ALTER TABLE `llx_salary_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe`
--
ALTER TABLE `llx_societe`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_account`
--
ALTER TABLE `llx_societe_account`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_address`
--
ALTER TABLE `llx_societe_address`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_commerciaux`
--
ALTER TABLE `llx_societe_commerciaux`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_contacts`
--
ALTER TABLE `llx_societe_contacts`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_extrafields`
--
ALTER TABLE `llx_societe_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_prices`
--
ALTER TABLE `llx_societe_prices`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_remise`
--
ALTER TABLE `llx_societe_remise`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_remise_except`
--
ALTER TABLE `llx_societe_remise_except`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_remise_supplier`
--
ALTER TABLE `llx_societe_remise_supplier`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_societe_rib`
--
ALTER TABLE `llx_societe_rib`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_socpeople`
--
ALTER TABLE `llx_socpeople`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_socpeople_extrafields`
--
ALTER TABLE `llx_socpeople_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_stock_mouvement`
--
ALTER TABLE `llx_stock_mouvement`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_stock_mouvement_extrafields`
--
ALTER TABLE `llx_stock_mouvement_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_subscription`
--
ALTER TABLE `llx_subscription`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_supplier_proposal`
--
ALTER TABLE `llx_supplier_proposal`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_supplier_proposaldet`
--
ALTER TABLE `llx_supplier_proposaldet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_supplier_proposaldet_extrafields`
--
ALTER TABLE `llx_supplier_proposaldet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_supplier_proposal_extrafields`
--
ALTER TABLE `llx_supplier_proposal_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_takepos_floor_tables`
--
ALTER TABLE `llx_takepos_floor_tables`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_tva`
--
ALTER TABLE `llx_tva`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_user`
--
ALTER TABLE `llx_user`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_usergroup`
--
ALTER TABLE `llx_usergroup`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_usergroup_extrafields`
--
ALTER TABLE `llx_usergroup_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_usergroup_rights`
--
ALTER TABLE `llx_usergroup_rights`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_usergroup_user`
--
ALTER TABLE `llx_usergroup_user`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_user_alert`
--
ALTER TABLE `llx_user_alert`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_user_employment`
--
ALTER TABLE `llx_user_employment`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_user_extrafields`
--
ALTER TABLE `llx_user_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_user_rib`
--
ALTER TABLE `llx_user_rib`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `llx_user_rights`
--
ALTER TABLE `llx_user_rights`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `llx_accounting_account`
--
ALTER TABLE `llx_accounting_account`
  ADD CONSTRAINT `fk_accounting_account_fk_pcg_version` FOREIGN KEY (`fk_pcg_version`) REFERENCES `llx_accounting_system` (`pcg_version`);

--
-- Contraintes pour la table `llx_adherent`
--
ALTER TABLE `llx_adherent`
  ADD CONSTRAINT `adherent_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_adherent_adherent_type` FOREIGN KEY (`fk_adherent_type`) REFERENCES `llx_adherent_type` (`rowid`);

--
-- Contraintes pour la table `llx_bank_account`
--
ALTER TABLE `llx_bank_account`
  ADD CONSTRAINT `fk_bank_account_accountancy_journal` FOREIGN KEY (`fk_accountancy_journal`) REFERENCES `llx_accounting_journal` (`rowid`);

--
-- Contraintes pour la table `llx_bom_bom`
--
ALTER TABLE `llx_bom_bom`
  ADD CONSTRAINT `llx_bom_bom_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_bom_bomline`
--
ALTER TABLE `llx_bom_bomline`
  ADD CONSTRAINT `llx_bom_bomline_fk_bom` FOREIGN KEY (`fk_bom`) REFERENCES `llx_bom_bom` (`rowid`);

--
-- Contraintes pour la table `llx_boxes`
--
ALTER TABLE `llx_boxes`
  ADD CONSTRAINT `fk_boxes_box_id` FOREIGN KEY (`box_id`) REFERENCES `llx_boxes_def` (`rowid`);

--
-- Contraintes pour la table `llx_budget_lines`
--
ALTER TABLE `llx_budget_lines`
  ADD CONSTRAINT `fk_budget_lines_budget` FOREIGN KEY (`fk_budget`) REFERENCES `llx_budget` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_account`
--
ALTER TABLE `llx_categorie_account`
  ADD CONSTRAINT `fk_categorie_account_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_account_fk_account` FOREIGN KEY (`fk_account`) REFERENCES `llx_bank_account` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_actioncomm`
--
ALTER TABLE `llx_categorie_actioncomm`
  ADD CONSTRAINT `fk_categorie_actioncomm_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_actioncomm_fk_actioncomm` FOREIGN KEY (`fk_actioncomm`) REFERENCES `llx_actioncomm` (`id`);

--
-- Contraintes pour la table `llx_categorie_contact`
--
ALTER TABLE `llx_categorie_contact`
  ADD CONSTRAINT `fk_categorie_contact_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_contact_fk_socpeople` FOREIGN KEY (`fk_socpeople`) REFERENCES `llx_socpeople` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_fournisseur`
--
ALTER TABLE `llx_categorie_fournisseur`
  ADD CONSTRAINT `fk_categorie_fournisseur_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_fournisseur_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_knowledgemanagement`
--
ALTER TABLE `llx_categorie_knowledgemanagement`
  ADD CONSTRAINT `fk_categorie_knowledgemanagement_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_knowledgemanagement_knowledgemanagement_rowid` FOREIGN KEY (`fk_knowledgemanagement`) REFERENCES `llx_knowledgemanagement_knowledgerecord` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_lang`
--
ALTER TABLE `llx_categorie_lang`
  ADD CONSTRAINT `fk_category_lang_fk_category` FOREIGN KEY (`fk_category`) REFERENCES `llx_categorie` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_member`
--
ALTER TABLE `llx_categorie_member`
  ADD CONSTRAINT `fk_categorie_member_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_member_member_rowid` FOREIGN KEY (`fk_member`) REFERENCES `llx_adherent` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_product`
--
ALTER TABLE `llx_categorie_product`
  ADD CONSTRAINT `fk_categorie_product_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_product_product_rowid` FOREIGN KEY (`fk_product`) REFERENCES `llx_product` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_project`
--
ALTER TABLE `llx_categorie_project`
  ADD CONSTRAINT `fk_categorie_project_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_project_fk_project_rowid` FOREIGN KEY (`fk_project`) REFERENCES `llx_projet` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_societe`
--
ALTER TABLE `llx_categorie_societe`
  ADD CONSTRAINT `fk_categorie_societe_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_societe_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_user`
--
ALTER TABLE `llx_categorie_user`
  ADD CONSTRAINT `fk_categorie_user_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_user_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_categorie_warehouse`
--
ALTER TABLE `llx_categorie_warehouse`
  ADD CONSTRAINT `fk_categorie_warehouse_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_warehouse_fk_warehouse_rowid` FOREIGN KEY (`fk_warehouse`) REFERENCES `llx_entrepot` (`rowid`);

--
-- Contraintes pour la table `llx_commande`
--
ALTER TABLE `llx_commande`
  ADD CONSTRAINT `fk_commande_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `llx_projet` (`rowid`),
  ADD CONSTRAINT `fk_commande_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_commande_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_commande_fk_user_cloture` FOREIGN KEY (`fk_user_cloture`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_commande_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_commandedet`
--
ALTER TABLE `llx_commandedet`
  ADD CONSTRAINT `fk_commandedet_fk_commande` FOREIGN KEY (`fk_commande`) REFERENCES `llx_commande` (`rowid`),
  ADD CONSTRAINT `fk_commandedet_fk_commandefourndet` FOREIGN KEY (`fk_commandefourndet`) REFERENCES `llx_commande_fournisseurdet` (`rowid`),
  ADD CONSTRAINT `fk_commandedet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_commande_fournisseur`
--
ALTER TABLE `llx_commande_fournisseur`
  ADD CONSTRAINT `fk_commande_fournisseur_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`);

--
-- Contraintes pour la table `llx_commande_fournisseurdet`
--
ALTER TABLE `llx_commande_fournisseurdet`
  ADD CONSTRAINT `fk_commande_fournisseurdet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_commande_fournisseur_dispatch`
--
ALTER TABLE `llx_commande_fournisseur_dispatch`
  ADD CONSTRAINT `fk_commande_fournisseur_dispatch_fk_reception` FOREIGN KEY (`fk_reception`) REFERENCES `llx_reception` (`rowid`);

--
-- Contraintes pour la table `llx_contrat`
--
ALTER TABLE `llx_contrat`
  ADD CONSTRAINT `fk_contrat_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_contrat_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_contratdet`
--
ALTER TABLE `llx_contratdet`
  ADD CONSTRAINT `fk_contratdet_fk_contrat` FOREIGN KEY (`fk_contrat`) REFERENCES `llx_contrat` (`rowid`),
  ADD CONSTRAINT `fk_contratdet_fk_product` FOREIGN KEY (`fk_product`) REFERENCES `llx_product` (`rowid`),
  ADD CONSTRAINT `fk_contratdet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_contratdet_log`
--
ALTER TABLE `llx_contratdet_log`
  ADD CONSTRAINT `fk_contratdet_log_fk_contratdet` FOREIGN KEY (`fk_contratdet`) REFERENCES `llx_contratdet` (`rowid`);

--
-- Contraintes pour la table `llx_c_departements`
--
ALTER TABLE `llx_c_departements`
  ADD CONSTRAINT `fk_departements_fk_region` FOREIGN KEY (`fk_region`) REFERENCES `llx_c_regions` (`code_region`);

--
-- Contraintes pour la table `llx_c_regions`
--
ALTER TABLE `llx_c_regions`
  ADD CONSTRAINT `fk_c_regions_fk_pays` FOREIGN KEY (`fk_pays`) REFERENCES `llx_c_country` (`rowid`);

--
-- Contraintes pour la table `llx_c_ziptown`
--
ALTER TABLE `llx_c_ziptown`
  ADD CONSTRAINT `fk_c_ziptown_fk_county` FOREIGN KEY (`fk_county`) REFERENCES `llx_c_departements` (`rowid`),
  ADD CONSTRAINT `fk_c_ziptown_fk_pays` FOREIGN KEY (`fk_pays`) REFERENCES `llx_c_country` (`rowid`);

--
-- Contraintes pour la table `llx_delivery`
--
ALTER TABLE `llx_delivery`
  ADD CONSTRAINT `fk_delivery_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_delivery_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_delivery_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_deliverydet`
--
ALTER TABLE `llx_deliverydet`
  ADD CONSTRAINT `fk_deliverydet_fk_delivery` FOREIGN KEY (`fk_delivery`) REFERENCES `llx_delivery` (`rowid`);

--
-- Contraintes pour la table `llx_ecm_directories`
--
ALTER TABLE `llx_ecm_directories`
  ADD CONSTRAINT `fk_ecm_directories_fk_user_c` FOREIGN KEY (`fk_user_c`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_ecm_directories_fk_user_m` FOREIGN KEY (`fk_user_m`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_element_contact`
--
ALTER TABLE `llx_element_contact`
  ADD CONSTRAINT `fk_element_contact_fk_c_type_contact` FOREIGN KEY (`fk_c_type_contact`) REFERENCES `llx_c_type_contact` (`rowid`);

--
-- Contraintes pour la table `llx_element_tag`
--
ALTER TABLE `llx_element_tag`
  ADD CONSTRAINT `fk_element_tag_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `llx_categorie` (`rowid`);

--
-- Contraintes pour la table `llx_emailcollector_emailcollectoraction`
--
ALTER TABLE `llx_emailcollector_emailcollectoraction`
  ADD CONSTRAINT `fk_emailcollectoraction_fk_emailcollector` FOREIGN KEY (`fk_emailcollector`) REFERENCES `llx_emailcollector_emailcollector` (`rowid`);

--
-- Contraintes pour la table `llx_emailcollector_emailcollectorfilter`
--
ALTER TABLE `llx_emailcollector_emailcollectorfilter`
  ADD CONSTRAINT `fk_emailcollectorfilter_fk_emailcollector` FOREIGN KEY (`fk_emailcollector`) REFERENCES `llx_emailcollector_emailcollector` (`rowid`);

--
-- Contraintes pour la table `llx_expedition`
--
ALTER TABLE `llx_expedition`
  ADD CONSTRAINT `fk_expedition_fk_shipping_method` FOREIGN KEY (`fk_shipping_method`) REFERENCES `llx_c_shipment_mode` (`rowid`),
  ADD CONSTRAINT `fk_expedition_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_expedition_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_expedition_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_expeditiondet`
--
ALTER TABLE `llx_expeditiondet`
  ADD CONSTRAINT `fk_expeditiondet_fk_expedition` FOREIGN KEY (`fk_expedition`) REFERENCES `llx_expedition` (`rowid`);

--
-- Contraintes pour la table `llx_expeditiondet_batch`
--
ALTER TABLE `llx_expeditiondet_batch`
  ADD CONSTRAINT `fk_expeditiondet_batch_fk_expeditiondet` FOREIGN KEY (`fk_expeditiondet`) REFERENCES `llx_expeditiondet` (`rowid`);

--
-- Contraintes pour la table `llx_expedition_packagedet`
--
ALTER TABLE `llx_expedition_packagedet`
  ADD CONSTRAINT `fk_expeditiondet_fk_shipmentpackage` FOREIGN KEY (`fk_shipmentpackage`) REFERENCES `llx_expedition_package` (`rowid`);

--
-- Contraintes pour la table `llx_facture`
--
ALTER TABLE `llx_facture`
  ADD CONSTRAINT `fk_facture_fk_facture_source` FOREIGN KEY (`fk_facture_source`) REFERENCES `llx_facture` (`rowid`),
  ADD CONSTRAINT `fk_facture_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `llx_projet` (`rowid`),
  ADD CONSTRAINT `fk_facture_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_facture_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_facture_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_facturedet`
--
ALTER TABLE `llx_facturedet`
  ADD CONSTRAINT `fk_facturedet_fk_facture` FOREIGN KEY (`fk_facture`) REFERENCES `llx_facture` (`rowid`),
  ADD CONSTRAINT `fk_facturedet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_facturedet_rec`
--
ALTER TABLE `llx_facturedet_rec`
  ADD CONSTRAINT `fk_facturedet_rec_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_facture_fourn`
--
ALTER TABLE `llx_facture_fourn`
  ADD CONSTRAINT `fk_facture_fourn_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `llx_projet` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_facture_fourn_det`
--
ALTER TABLE `llx_facture_fourn_det`
  ADD CONSTRAINT `fk_facture_fourn_det_fk_facture` FOREIGN KEY (`fk_facture_fourn`) REFERENCES `llx_facture_fourn` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_det_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_facture_fourn_det_rec`
--
ALTER TABLE `llx_facture_fourn_det_rec`
  ADD CONSTRAINT `fk_facture_fourn_det_rec_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_facture_fourn_rec`
--
ALTER TABLE `llx_facture_fourn_rec`
  ADD CONSTRAINT `fk_facture_fourn_rec_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `llx_projet` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_rec_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_rec_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_facture_rec`
--
ALTER TABLE `llx_facture_rec`
  ADD CONSTRAINT `fk_facture_rec_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `llx_projet` (`rowid`),
  ADD CONSTRAINT `fk_facture_rec_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_facture_rec_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_fichinter`
--
ALTER TABLE `llx_fichinter`
  ADD CONSTRAINT `fk_fichinter_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`);

--
-- Contraintes pour la table `llx_fichinterdet`
--
ALTER TABLE `llx_fichinterdet`
  ADD CONSTRAINT `fk_fichinterdet_fk_fichinter` FOREIGN KEY (`fk_fichinter`) REFERENCES `llx_fichinter` (`rowid`);

--
-- Contraintes pour la table `llx_fichinter_rec`
--
ALTER TABLE `llx_fichinter_rec`
  ADD CONSTRAINT `fk_fichinter_rec_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `llx_projet` (`rowid`),
  ADD CONSTRAINT `fk_fichinter_rec_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_knowledgemanagement_knowledgerecord`
--
ALTER TABLE `llx_knowledgemanagement_knowledgerecord`
  ADD CONSTRAINT `llx_knowledgemanagement_knowledgerecord_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_mrp_mo`
--
ALTER TABLE `llx_mrp_mo`
  ADD CONSTRAINT `fk_mrp_mo_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_mrp_production`
--
ALTER TABLE `llx_mrp_production`
  ADD CONSTRAINT `fk_mrp_production_mo` FOREIGN KEY (`fk_mo`) REFERENCES `llx_mrp_mo` (`rowid`),
  ADD CONSTRAINT `fk_mrp_production_product` FOREIGN KEY (`fk_product`) REFERENCES `llx_product` (`rowid`),
  ADD CONSTRAINT `fk_mrp_production_stock_movement` FOREIGN KEY (`fk_stock_movement`) REFERENCES `llx_stock_mouvement` (`rowid`);

--
-- Contraintes pour la table `llx_paiement_facture`
--
ALTER TABLE `llx_paiement_facture`
  ADD CONSTRAINT `fk_paiement_facture_fk_facture` FOREIGN KEY (`fk_facture`) REFERENCES `llx_facture` (`rowid`),
  ADD CONSTRAINT `fk_paiement_facture_fk_paiement` FOREIGN KEY (`fk_paiement`) REFERENCES `llx_paiement` (`rowid`);

--
-- Contraintes pour la table `llx_payment_salary`
--
ALTER TABLE `llx_payment_salary`
  ADD CONSTRAINT `fk_payment_salary_user` FOREIGN KEY (`fk_user`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_prelevement_facture`
--
ALTER TABLE `llx_prelevement_facture`
  ADD CONSTRAINT `fk_prelevement_facture_fk_prelevement_lignes` FOREIGN KEY (`fk_prelevement_lignes`) REFERENCES `llx_prelevement_lignes` (`rowid`);

--
-- Contraintes pour la table `llx_prelevement_lignes`
--
ALTER TABLE `llx_prelevement_lignes`
  ADD CONSTRAINT `fk_prelevement_lignes_fk_prelevement_bons` FOREIGN KEY (`fk_prelevement_bons`) REFERENCES `llx_prelevement_bons` (`rowid`);

--
-- Contraintes pour la table `llx_product`
--
ALTER TABLE `llx_product`
  ADD CONSTRAINT `fk_product_barcode_type` FOREIGN KEY (`fk_barcode_type`) REFERENCES `llx_c_barcode_type` (`rowid`),
  ADD CONSTRAINT `fk_product_default_warehouse` FOREIGN KEY (`fk_default_warehouse`) REFERENCES `llx_entrepot` (`rowid`),
  ADD CONSTRAINT `fk_product_finished` FOREIGN KEY (`finished`) REFERENCES `llx_c_product_nature` (`code`),
  ADD CONSTRAINT `fk_product_fk_country` FOREIGN KEY (`fk_country`) REFERENCES `llx_c_country` (`rowid`),
  ADD CONSTRAINT `fk_product_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_product_batch`
--
ALTER TABLE `llx_product_batch`
  ADD CONSTRAINT `fk_product_batch_fk_product_stock` FOREIGN KEY (`fk_product_stock`) REFERENCES `llx_product_stock` (`rowid`);

--
-- Contraintes pour la table `llx_product_customer_price`
--
ALTER TABLE `llx_product_customer_price`
  ADD CONSTRAINT `fk_product_customer_price_fk_product` FOREIGN KEY (`fk_product`) REFERENCES `llx_product` (`rowid`),
  ADD CONSTRAINT `fk_product_customer_price_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_product_customer_price_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_product_fournisseur_price`
--
ALTER TABLE `llx_product_fournisseur_price`
  ADD CONSTRAINT `fk_product_fournisseur_price_barcode_type` FOREIGN KEY (`fk_barcode_type`) REFERENCES `llx_c_barcode_type` (`rowid`),
  ADD CONSTRAINT `fk_product_fournisseur_price_fk_product` FOREIGN KEY (`fk_product`) REFERENCES `llx_product` (`rowid`),
  ADD CONSTRAINT `fk_product_fournisseur_price_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_product_lang`
--
ALTER TABLE `llx_product_lang`
  ADD CONSTRAINT `fk_product_lang_fk_product` FOREIGN KEY (`fk_product`) REFERENCES `llx_product` (`rowid`);

--
-- Contraintes pour la table `llx_product_price`
--
ALTER TABLE `llx_product_price`
  ADD CONSTRAINT `fk_product_price_product` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_product_price_user_author` FOREIGN KEY (`fk_product`) REFERENCES `llx_product` (`rowid`);

--
-- Contraintes pour la table `llx_product_price_by_qty`
--
ALTER TABLE `llx_product_price_by_qty`
  ADD CONSTRAINT `fk_product_price_by_qty_fk_product_price` FOREIGN KEY (`fk_product_price`) REFERENCES `llx_product_price` (`rowid`);

--
-- Contraintes pour la table `llx_projet`
--
ALTER TABLE `llx_projet`
  ADD CONSTRAINT `fk_projet_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`);

--
-- Contraintes pour la table `llx_projet_task`
--
ALTER TABLE `llx_projet_task`
  ADD CONSTRAINT `fk_projet_task_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `llx_projet` (`rowid`),
  ADD CONSTRAINT `fk_projet_task_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_projet_task_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_propal`
--
ALTER TABLE `llx_propal`
  ADD CONSTRAINT `fk_propal_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `llx_projet` (`rowid`),
  ADD CONSTRAINT `fk_propal_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_propal_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_propal_fk_user_cloture` FOREIGN KEY (`fk_user_cloture`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_propal_fk_user_signature` FOREIGN KEY (`fk_user_signature`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_propal_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_propaldet`
--
ALTER TABLE `llx_propaldet`
  ADD CONSTRAINT `fk_propaldet_fk_propal` FOREIGN KEY (`fk_propal`) REFERENCES `llx_propal` (`rowid`),
  ADD CONSTRAINT `fk_propaldet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_reception`
--
ALTER TABLE `llx_reception`
  ADD CONSTRAINT `fk_reception_fk_shipping_method` FOREIGN KEY (`fk_shipping_method`) REFERENCES `llx_c_shipment_mode` (`rowid`),
  ADD CONSTRAINT `fk_reception_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_reception_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_reception_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_recruitment_recruitmentcandidature`
--
ALTER TABLE `llx_recruitment_recruitmentcandidature`
  ADD CONSTRAINT `llx_recruitment_recruitmentcandidature_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_recruitment_recruitmentjobposition`
--
ALTER TABLE `llx_recruitment_recruitmentjobposition`
  ADD CONSTRAINT `llx_recruitment_recruitmentjobposition_fk_establishment` FOREIGN KEY (`fk_establishment`) REFERENCES `llx_establishment` (`rowid`),
  ADD CONSTRAINT `llx_recruitment_recruitmentjobposition_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `llx_recruitment_recruitmentjobposition_fk_user_recruiter` FOREIGN KEY (`fk_user_recruiter`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `llx_recruitment_recruitmentjobposition_fk_user_supervisor` FOREIGN KEY (`fk_user_supervisor`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_resource`
--
ALTER TABLE `llx_resource`
  ADD CONSTRAINT `fk_resource_fk_country` FOREIGN KEY (`fk_country`) REFERENCES `llx_c_country` (`rowid`);

--
-- Contraintes pour la table `llx_societe_account`
--
ALTER TABLE `llx_societe_account`
  ADD CONSTRAINT `llx_societe_account_fk_societe` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`);

--
-- Contraintes pour la table `llx_societe_contacts`
--
ALTER TABLE `llx_societe_contacts`
  ADD CONSTRAINT `fk_societe_contacts_fk_c_type_contact` FOREIGN KEY (`fk_c_type_contact`) REFERENCES `llx_c_type_contact` (`rowid`),
  ADD CONSTRAINT `fk_societe_contacts_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_societe_contacts_fk_socpeople` FOREIGN KEY (`fk_socpeople`) REFERENCES `llx_socpeople` (`rowid`);

--
-- Contraintes pour la table `llx_societe_remise_except`
--
ALTER TABLE `llx_societe_remise_except`
  ADD CONSTRAINT `fk_soc_remise_fk_facture_line` FOREIGN KEY (`fk_facture_line`) REFERENCES `llx_facturedet` (`rowid`),
  ADD CONSTRAINT `fk_soc_remise_fk_invoice_supplier_line` FOREIGN KEY (`fk_invoice_supplier_line`) REFERENCES `llx_facture_fourn_det` (`rowid`),
  ADD CONSTRAINT `fk_soc_remise_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_facture` FOREIGN KEY (`fk_facture`) REFERENCES `llx_facture` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_facture_source` FOREIGN KEY (`fk_facture_source`) REFERENCES `llx_facture` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_invoice_supplier` FOREIGN KEY (`fk_invoice_supplier`) REFERENCES `llx_facture_fourn` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_invoice_supplier_source` FOREIGN KEY (`fk_invoice_supplier`) REFERENCES `llx_facture_fourn` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_societe_rib`
--
ALTER TABLE `llx_societe_rib`
  ADD CONSTRAINT `llx_societe_rib_fk_societe` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`);

--
-- Contraintes pour la table `llx_socpeople`
--
ALTER TABLE `llx_socpeople`
  ADD CONSTRAINT `fk_socpeople_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `llx_societe` (`rowid`),
  ADD CONSTRAINT `fk_socpeople_user_creat_user_rowid` FOREIGN KEY (`fk_user_creat`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_supplier_proposaldet`
--
ALTER TABLE `llx_supplier_proposaldet`
  ADD CONSTRAINT `fk_supplier_proposaldet_fk_supplier_proposal` FOREIGN KEY (`fk_supplier_proposal`) REFERENCES `llx_supplier_proposal` (`rowid`),
  ADD CONSTRAINT `fk_supplier_proposaldet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `llx_c_units` (`rowid`);

--
-- Contraintes pour la table `llx_usergroup_rights`
--
ALTER TABLE `llx_usergroup_rights`
  ADD CONSTRAINT `fk_usergroup_rights_fk_usergroup` FOREIGN KEY (`fk_usergroup`) REFERENCES `llx_usergroup` (`rowid`);

--
-- Contraintes pour la table `llx_usergroup_user`
--
ALTER TABLE `llx_usergroup_user`
  ADD CONSTRAINT `fk_usergroup_user_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `llx_user` (`rowid`),
  ADD CONSTRAINT `fk_usergroup_user_fk_usergroup` FOREIGN KEY (`fk_usergroup`) REFERENCES `llx_usergroup` (`rowid`);

--
-- Contraintes pour la table `llx_user_employment`
--
ALTER TABLE `llx_user_employment`
  ADD CONSTRAINT `fk_user_employment_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `llx_user` (`rowid`);

--
-- Contraintes pour la table `llx_user_rights`
--
ALTER TABLE `llx_user_rights`
  ADD CONSTRAINT `fk_user_rights_fk_user_user` FOREIGN KEY (`fk_user`) REFERENCES `llx_user` (`rowid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
