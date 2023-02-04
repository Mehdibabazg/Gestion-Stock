-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2022 at 06:31 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestion`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Inc_BL` ()  begin
declare v_Max int default 0;
set v_Max=(select MAX(left(num_BL,4)) from BL where year(date_BL) = year(NOW(3))); 
	if (v_Max is Null)
		then
			set v_Max=1;
	else
	set v_Max = v_Max+1;
	end if;
	select concat(LPAD(v_Max,4,'0'),"/",DATE_FORMAT(curdate(),'%m-%y'));
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Inc_devis` ()  begin
declare v_Max int default 0;
set v_Max=(select MAX(left(num_devis,4)) from devis where year(date_devis) = year(NOW(3))); 
	if (v_Max is Null)
		then
			set v_Max=1;
	else
	set v_Max = v_Max+1;
	end if;
	select concat(LPAD(v_Max,4,'0'),"/",DATE_FORMAT(curdate(),'%m-%y')) as num;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Inc_facture` ()  begin
declare v_Max int default 0;
set v_Max=(select MAX(left(num_facture,4)) from facture where year(date_facture) = year(NOW(3))); 
	if (v_Max is Null)
		then
			set v_Max=1;
	else
	set v_Max = v_Max+1;
	end if;
	select concat(LPAD(v_Max,4,'0'),"/",DATE_FORMAT(curdate(),'%m-%y')) as num;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `quantite` int(10) NOT NULL,
  `prix_achat` float NOT NULL,
  `TVA` varchar(10) NOT NULL,
  `fournisseur` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `reference`, `type`, `quantite`, `prix_achat`, `TVA`, `fournisseur`) VALUES
(2, 'SOURIS SF 690', 'ACCESSOIRE', 36, 113, '20', 'FIRST'),
(4, 'BATTERIE 9V', 'ACCESSOIRES', 8, 20, '20%', 'HIK'),
(5, 'HDMI 30M', 'CABLES', 3, 120, '20%', 'SES'),
(6, 'ECRAN DELL 1', 'ORDINATEUR', 1, 50, '20%', 'SES');

-- --------------------------------------------------------

--
-- Table structure for table `bl`
--

CREATE TABLE `bl` (
  `id` int(11) NOT NULL,
  `num_BL` varchar(15) DEFAULT NULL,
  `date_BL` date DEFAULT NULL,
  `n_bon` varchar(20) DEFAULT NULL,
  `cheque` varchar(15) DEFAULT NULL,
  `mt_chaque` float DEFAULT NULL,
  `especes` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bl`
--

INSERT INTO `bl` (`id`, `num_BL`, `date_BL`, `n_bon`, `cheque`, `mt_chaque`, `especes`) VALUES
(1, '0241/11-18', '2018-11-02', '3261/EF', NULL, NULL, NULL),
(2, '0256/11-19', '2019-11-20', '6325/ED', NULL, NULL, NULL),
(3, '0850/11-20', '2020-11-16', '0125/DC', NULL, NULL, NULL),
(4, '0250/11-21', '2021-11-04', '9631/EK', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `caisse`
--

CREATE TABLE `caisse` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `objet` varchar(255) DEFAULT NULL,
  `nature` varchar(50) DEFAULT NULL,
  `montant` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `caisse`
--

INSERT INTO `caisse` (`id`, `date`, `objet`, `nature`, `montant`) VALUES
(1, '2022-03-02', 'BN°226/SD', 'Recette', 2305),
(3, '2022-03-02', 'BN°7152', 'Recette', 1250),
(4, '2022-02-15', 'DEVIS', 'Construction', 10500),
(5, '2022-02-25', 'CLIENT', 'Autres', 650);

-- --------------------------------------------------------

--
-- Table structure for table `cheques`
--

CREATE TABLE `cheques` (
  `id` int(11) NOT NULL,
  `emis` date DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `fournisseur` varchar(150) DEFAULT NULL,
  `echeance` date DEFAULT NULL,
  `debite` varchar(3) DEFAULT NULL,
  `nature` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cheques`
--

INSERT INTO `cheques` (`id`, `emis`, `type`, `numero`, `montant`, `fournisseur`, `echeance`, `debite`, `nature`) VALUES
(1, '2022-01-06', 'Lettre Change', '1668688', 1362.32, 'ECV', '2022-01-06', 'Non', 'Caméra'),
(2, '2022-01-06', 'Lettre Change', '564365', 222.88, 'hik', '2022-01-06', 'Non', 'Caméra'),
(3, '2022-01-13', 'Vairement', '4963295', 123.25, 'FIRST', '2022-01-26', 'Non', 'Caméra'),
(4, '2022-01-07', 'Lettre Change', '4239635', 96349, 'KIA', '2023-01-07', 'Non', 'Caméra'),
(5, '2022-01-07', 'Vairement', '1236896', 4852, 'ECV', '2022-01-15', 'Oui', 'Caméra'),
(6, '2022-01-08', 'Lettre Change', '696355', 12500.4, 'LOLN', '2022-04-16', 'Oui', 'Caméra');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `societe` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gsm` varchar(15) NOT NULL,
  `email` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `nom`, `societe`, `gsm`, `email`, `adresse`) VALUES
(2, 'KASSI', 'SES', '0623412971', 'GTA@mail.com', ''),
(11, 'mehdi', 'ZAGORA', '0686316534', 'email@mail.com', 'massar Av 5'),
(13, 'nom1', 'societe1 adresse 2 XXXXXXXXX ICE : 98752314632145699', '600000001', 'email1@gmail.com', 'adresse1'),
(14, 'nom2', 'societe2', '600000002', 'email1@gmail.com', 'adresse2'),
(15, 'nom3', 'societe3', '600000003', 'email1@gmail.com', 'adresse3'),
(16, 'nom4', 'societe4', '600000004', 'email1@gmail.com', 'adresse4'),
(17, 'nom5', 'societe5', '600000005', 'email1@gmail.com', 'adresse5'),
(18, 'nom6', 'societe6', '600000006', 'email1@gmail.com', 'adresse6'),
(19, 'nom7', 'societe7', '600000007', 'email1@gmail.com', 'adresse7'),
(20, 'nom8', 'societe8', '600000008', 'email1@gmail.com', 'adresse8'),
(21, 'nom9', 'societe9', '600000009', 'email1@gmail.com', 'adresse9'),
(22, 'nom10', 'societe10', '600000010', 'email1@gmail.com', 'adresse10'),
(23, 'nom11', 'societe11', '600000011', 'email1@gmail.com', 'adresse11'),
(24, 'nom12', 'societe12', '600000012', 'email1@gmail.com', 'adresse12'),
(25, 'nom13', 'societe13', '600000013', 'email1@gmail.com', 'adresse13'),
(26, 'nom14', 'societe14', '600000014', 'email1@gmail.com', 'adresse14'),
(27, 'nom15', 'societe15', '600000015', 'email1@gmail.com', 'adresse15'),
(28, 'nom16', 'societe16', '600000016', 'email1@gmail.com', 'adresse16'),
(29, 'nom17', 'societe17', '600000017', 'email1@gmail.com', 'adresse17'),
(30, 'nom18', 'societe18', '600000018', 'email1@gmail.com', 'adresse18'),
(31, 'nom19', 'societe19', '600000019', 'email1@gmail.com', 'adresse19'),
(32, 'nom20', 'societe20', '600000020', 'email1@gmail.com', 'adresse20'),
(33, 'nom21', 'societe21', '600000021', 'email1@gmail.com', 'adresse21'),
(34, 'nom22', 'societe22', '600000022', 'email1@gmail.com', 'adresse22'),
(35, 'nom23', 'societe23', '600000023', 'email1@gmail.com', 'adresse23'),
(36, 'nom24', 'societe24', '600000024', 'email1@gmail.com', 'adresse24'),
(37, 'nom25', 'societe25', '600000025', 'email1@gmail.com', 'adresse25'),
(38, 'nom26', 'societe26', '600000026', 'email1@gmail.com', 'adresse26'),
(39, 'nom27', 'societe27', '600000027', 'email1@gmail.com', 'adresse27'),
(40, 'nom28', 'societe28', '600000028', 'email1@gmail.com', 'adresse28'),
(41, 'nom29', 'societe29', '600000029', 'email1@gmail.com', 'adresse29'),
(42, 'nom30', 'societe30', '600000030', 'email1@gmail.com', 'adresse30'),
(43, 'nom31', 'societe31', '600000031', 'email1@gmail.com', 'adresse31'),
(44, 'nom32', 'societe32', '600000032', 'email1@gmail.com', 'adresse32'),
(45, 'nom33', 'societe33', '600000033', 'email1@gmail.com', 'adresse33'),
(46, 'nom34', 'societe34', '600000034', 'email1@gmail.com', 'adresse34'),
(47, 'nom35', 'societe35', '600000035', 'email1@gmail.com', 'adresse35'),
(48, 'nom36', 'societe36', '600000036', 'email1@gmail.com', 'adresse36'),
(49, 'nom37', 'societe37', '600000037', 'email1@gmail.com', 'adresse37'),
(50, 'nom38', 'societe38', '600000038', 'email1@gmail.com', 'adresse38'),
(51, 'nom39', 'societe39', '600000039', 'email1@gmail.com', 'adresse39'),
(52, 'nom40', 'societe40', '600000040', 'email1@gmail.com', 'adresse40'),
(53, 'nom41', 'societe41', '600000041', 'email1@gmail.com', 'adresse41'),
(54, 'nom42', 'societe42', '600000042', 'email1@gmail.com', 'adresse42'),
(55, 'nom43', 'societe43', '600000043', 'email1@gmail.com', 'adresse43'),
(56, 'nom44', 'societe44', '600000044', 'email1@gmail.com', 'adresse44'),
(57, 'nom45', 'societe45', '600000045', 'email1@gmail.com', 'adresse45'),
(58, 'nom46', 'societe46', '600000046', 'email1@gmail.com', 'adresse46'),
(59, 'nom47', 'societe47', '600000047', 'email1@gmail.com', 'adresse47'),
(60, 'nom48', 'societe48', '600000048', 'email1@gmail.com', 'adresse48'),
(61, 'nom49', 'societe49', '600000049', 'email1@gmail.com', 'adresse49'),
(62, 'nom50', 'societe50', '600000050', 'email1@gmail.com', 'adresse50'),
(63, 'nom51', 'societe51', '600000051', 'email1@gmail.com', 'adresse51'),
(64, 'nom52', 'societe52', '600000052', 'email1@gmail.com', 'adresse52'),
(65, 'nom53', 'societe53', '600000053', 'email1@gmail.com', 'adresse53'),
(66, 'nom54', 'societe54', '600000054', 'email1@gmail.com', 'adresse54'),
(67, 'nom55', 'societe55', '600000055', 'email1@gmail.com', 'adresse55'),
(68, 'nom56', 'societe56', '600000056', 'email1@gmail.com', 'adresse56'),
(69, 'nom57', 'societe57', '600000057', 'email1@gmail.com', 'adresse57'),
(70, 'nom58', 'societe58', '600000058', 'email1@gmail.com', 'adresse58'),
(71, 'nom59', 'societe59', '600000059', 'email1@gmail.com', 'adresse59'),
(72, 'nom60', 'societe60', '600000060', 'email1@gmail.com', 'adresse60'),
(73, 'nom61', 'societe61', '600000061', 'email1@gmail.com', 'adresse61'),
(74, 'nom62', 'societe62', '600000062', 'email1@gmail.com', 'adresse62'),
(75, 'nom63', 'societe63', '600000063', 'email1@gmail.com', 'adresse63'),
(76, 'nom64', 'societe64', '600000064', 'email1@gmail.com', 'adresse64'),
(77, 'nom65', 'societe65', '600000065', 'email1@gmail.com', 'adresse65'),
(78, 'nom66', 'societe66', '600000066', 'email1@gmail.com', 'adresse66'),
(79, 'nom67', 'societe67', '600000067', 'email1@gmail.com', 'adresse67'),
(80, 'nom68', 'societe68', '600000068', 'email1@gmail.com', 'adresse68'),
(81, 'nom69', 'societe69', '600000069', 'email1@gmail.com', 'adresse69'),
(82, 'nom70', 'societe70', '600000070', 'email1@gmail.com', 'adresse70'),
(83, 'nom71', 'societe71', '600000071', 'email1@gmail.com', 'adresse71'),
(84, 'nom72', 'societe72', '600000072', 'email1@gmail.com', 'adresse72'),
(85, 'nom73', 'societe73', '600000073', 'email1@gmail.com', 'adresse73'),
(86, 'nom74', 'societe74', '600000074', 'email1@gmail.com', 'adresse74'),
(87, 'nom75', 'societe75', '600000075', 'email1@gmail.com', 'adresse75'),
(88, 'nom76', 'societe76', '600000076', 'email1@gmail.com', 'adresse76'),
(89, 'nom77', 'societe77', '600000077', 'email1@gmail.com', 'adresse77'),
(90, 'nom78', 'societe78', '600000078', 'email1@gmail.com', 'adresse78'),
(91, 'nom79', 'societe79', '600000079', 'email1@gmail.com', 'adresse79'),
(92, 'nom80', 'societe80', '600000080', 'email1@gmail.com', 'adresse80'),
(93, 'nom81', 'societe81', '600000081', 'email1@gmail.com', 'adresse81'),
(94, 'nom82', 'societe82', '600000082', 'email1@gmail.com', 'adresse82'),
(95, 'nom83', 'societe83', '600000083', 'email1@gmail.com', 'adresse83'),
(96, 'nom84', 'societe84', '600000084', 'email1@gmail.com', 'adresse84'),
(97, 'nom85', 'societe85', '600000085', 'email1@gmail.com', 'adresse85'),
(98, 'nom86', 'societe86', '600000086', 'email1@gmail.com', 'adresse86'),
(99, 'nom87', 'societe87', '600000087', 'email1@gmail.com', 'adresse87'),
(100, 'nom88', 'societe88', '600000088', 'email1@gmail.com', 'adresse88'),
(101, 'nom89', 'societe89', '600000089', 'email1@gmail.com', 'adresse89'),
(102, 'nom90', 'societe90', '600000090', 'email1@gmail.com', 'adresse90'),
(103, 'nom91', 'societe91', '600000091', 'email1@gmail.com', 'adresse91'),
(104, 'nom92', 'societe92', '600000092', 'email1@gmail.com', 'adresse92'),
(105, 'nom93', 'societe93', '600000093', 'email1@gmail.com', 'adresse93'),
(106, 'nom94', 'societe94', '600000094', 'email1@gmail.com', 'adresse94'),
(107, 'nom95', 'societe95', '600000095', 'email1@gmail.com', 'adresse95'),
(108, 'nom96', 'societe96', '600000096', 'email1@gmail.com', 'adresse96'),
(109, 'nom97', 'societe97', '600000097', 'email1@gmail.com', 'adresse97'),
(110, 'nom98', 'societe98', '600000098', 'email1@gmail.com', 'adresse98'),
(111, 'nom99', 'societe99', '600000099', 'email1@gmail.com', 'adresse99'),
(112, 'nom100', 'societe100', '600000100', 'email1@gmail.com', 'adresse100'),
(113, 'nom101', 'societe101', '600000101', 'email1@gmail.com', 'adresse101'),
(114, 'nom102', 'societe102', '600000102', 'email1@gmail.com', 'adresse102'),
(115, 'nom103', 'societe103', '600000103', 'email1@gmail.com', 'adresse103'),
(116, 'nom104', 'societe104', '600000104', 'email1@gmail.com', 'adresse104'),
(117, 'nom105', 'societe105', '600000105', 'email1@gmail.com', 'adresse105'),
(118, 'nom106', 'societe106', '600000106', 'email1@gmail.com', 'adresse106'),
(119, 'nom107', 'societe107', '600000107', 'email1@gmail.com', 'adresse107'),
(120, 'nom108', 'societe108', '600000108', 'email1@gmail.com', 'adresse108'),
(121, 'nom109', 'societe109', '600000109', 'email1@gmail.com', 'adresse109'),
(122, 'nom110', 'societe110', '600000110', 'email1@gmail.com', 'adresse110'),
(123, 'nom111', 'societe111', '600000111', 'email1@gmail.com', 'adresse111'),
(124, 'nom112', 'societe112', '600000112', 'email1@gmail.com', 'adresse112'),
(125, 'nom113', 'societe113', '600000113', 'email1@gmail.com', 'adresse113'),
(126, 'nom114', 'societe114', '600000114', 'email1@gmail.com', 'adresse114'),
(127, 'nom115', 'societe115', '600000115', 'email1@gmail.com', 'adresse115'),
(128, 'nom116', 'societe116', '600000116', 'email1@gmail.com', 'adresse116'),
(129, 'nom117', 'societe117', '600000117', 'email1@gmail.com', 'adresse117'),
(130, 'nom118', 'societe118', '600000118', 'email1@gmail.com', 'adresse118'),
(131, 'nom119', 'societe119', '600000119', 'email1@gmail.com', 'adresse119'),
(132, 'nom120', 'societe120', '600000120', 'email1@gmail.com', 'adresse120'),
(133, 'nom121', 'societe121', '600000121', 'email1@gmail.com', 'adresse121'),
(134, 'nom122', 'societe122', '600000122', 'email1@gmail.com', 'adresse122'),
(135, 'nom123', 'societe123', '600000123', 'email1@gmail.com', 'adresse123'),
(136, 'nom124', 'societe124', '600000124', 'email1@gmail.com', 'adresse124'),
(137, 'nom125', 'societe125', '600000125', 'email1@gmail.com', 'adresse125'),
(138, 'nom126', 'societe126', '600000126', 'email1@gmail.com', 'adresse126'),
(139, 'nom127', 'societe127', '600000127', 'email1@gmail.com', 'adresse127'),
(140, 'nom128', 'societe128', '600000128', 'email1@gmail.com', 'adresse128'),
(141, 'nom129', 'societe129', '600000129', 'email1@gmail.com', 'adresse129'),
(142, 'nom130', 'societe130', '600000130', 'email1@gmail.com', 'adresse130'),
(143, 'nom131', 'societe131', '600000131', 'email1@gmail.com', 'adresse131'),
(144, 'nom132', 'societe132', '600000132', 'email1@gmail.com', 'adresse132'),
(145, 'nom133', 'societe133', '600000133', 'email1@gmail.com', 'adresse133'),
(146, 'nom134', 'societe134', '600000134', 'email1@gmail.com', 'adresse134'),
(147, 'nom135', 'societe135', '600000135', 'email1@gmail.com', 'adresse135'),
(148, 'nom136', 'societe136', '600000136', 'email1@gmail.com', 'adresse136'),
(149, 'nom137', 'societe137', '600000137', 'email1@gmail.com', 'adresse137'),
(150, 'nom138', 'societe138', '600000138', 'email1@gmail.com', 'adresse138'),
(151, 'nom139', 'societe139', '600000139', 'email1@gmail.com', 'adresse139'),
(152, 'nom140', 'societe140', '600000140', 'email1@gmail.com', 'adresse140'),
(153, 'nom141', 'societe141', '600000141', 'email1@gmail.com', 'adresse141'),
(154, 'nom142', 'societe142', '600000142', 'email1@gmail.com', 'adresse142'),
(155, 'nom143', 'societe143', '600000143', 'email1@gmail.com', 'adresse143'),
(156, 'nom144', 'societe144', '600000144', 'email1@gmail.com', 'adresse144'),
(157, 'nom145', 'societe145', '600000145', 'email1@gmail.com', 'adresse145'),
(158, 'nom146', 'societe146', '600000146', 'email1@gmail.com', 'adresse146'),
(159, 'nom147', 'societe147', '600000147', 'email1@gmail.com', 'adresse147'),
(160, 'nom148', 'societe148', '600000148', 'email1@gmail.com', 'adresse148'),
(161, 'nom149', 'societe149', '600000149', 'email1@gmail.com', 'adresse149'),
(162, 'nom150', 'societe150', '600000150', 'email1@gmail.com', 'adresse150'),
(163, 'nom151', 'societe151', '600000151', 'email1@gmail.com', 'adresse151'),
(164, 'nom152', 'societe152', '600000152', 'email1@gmail.com', 'adresse152'),
(165, 'nom153', 'societe153', '600000153', 'email1@gmail.com', 'adresse153'),
(166, 'nom154', 'societe154', '600000154', 'email1@gmail.com', 'adresse154'),
(167, 'nom155', 'societe155', '600000155', 'email1@gmail.com', 'adresse155'),
(168, 'nom156', 'societe156', '600000156', 'email1@gmail.com', 'adresse156'),
(169, 'nom157', 'societe157', '600000157', 'email1@gmail.com', 'adresse157'),
(170, 'nom158', 'societe158', '600000158', 'email1@gmail.com', 'adresse158'),
(171, 'nom159', 'societe159', '600000159', 'email1@gmail.com', 'adresse159'),
(172, 'nom160', 'societe160', '600000160', 'email1@gmail.com', 'adresse160'),
(173, 'nom161', 'societe161', '600000161', 'email1@gmail.com', 'adresse161'),
(174, 'nom162', 'societe162', '600000162', 'email1@gmail.com', 'adresse162'),
(175, 'nom163', 'societe163', '600000163', 'email1@gmail.com', 'adresse163'),
(176, 'nom164', 'societe164', '600000164', 'email1@gmail.com', 'adresse164'),
(177, 'nom165', 'societe165', '600000165', 'email1@gmail.com', 'adresse165'),
(178, 'nom166', 'societe166', '600000166', 'email1@gmail.com', 'adresse166'),
(179, 'nom167', 'societe167', '600000167', 'email1@gmail.com', 'adresse167'),
(180, 'nom168', 'societe168', '600000168', 'email1@gmail.com', 'adresse168'),
(181, 'nom169', 'societe169', '600000169', 'email1@gmail.com', 'adresse169'),
(182, 'nom170', 'societe170', '600000170', 'email1@gmail.com', 'adresse170'),
(183, 'nom171', 'societe171', '600000171', 'email1@gmail.com', 'adresse171'),
(184, 'nom172', 'societe172', '600000172', 'email1@gmail.com', 'adresse172'),
(185, 'nom173', 'societe173', '600000173', 'email1@gmail.com', 'adresse173'),
(186, 'nom174', 'societe174', '600000174', 'email1@gmail.com', 'adresse174'),
(187, 'nom175', 'societe175', '600000175', 'email1@gmail.com', 'adresse175'),
(188, 'nom176', 'societe176', '600000176', 'email1@gmail.com', 'adresse176'),
(189, 'nom177', 'societe177', '600000177', 'email1@gmail.com', 'adresse177'),
(190, 'nom178', 'societe178', '600000178', 'email1@gmail.com', 'adresse178'),
(191, 'nom179', 'societe179', '600000179', 'email1@gmail.com', 'adresse179'),
(192, 'nom180', 'societe180', '600000180', 'email1@gmail.com', 'adresse180'),
(193, 'nom181', 'societe181', '600000181', 'email1@gmail.com', 'adresse181'),
(194, 'nom182', 'societe182', '600000182', 'email1@gmail.com', 'adresse182'),
(195, 'nom183', 'societe183', '600000183', 'email1@gmail.com', 'adresse183'),
(196, 'nom184', 'societe184', '600000184', 'email1@gmail.com', 'adresse184'),
(197, 'nom185', 'societe185', '600000185', 'email1@gmail.com', 'adresse185'),
(198, 'nom186', 'societe186', '600000186', 'email1@gmail.com', 'adresse186'),
(199, 'nom187', 'societe187', '600000187', 'email1@gmail.com', 'adresse187'),
(200, 'nom188', 'societe188', '600000188', 'email1@gmail.com', 'adresse188'),
(1015, 'KECH BUREAU', 'KECHBUREAU', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `devis`
--

CREATE TABLE `devis` (
  `id` int(11) NOT NULL,
  `num_devis` varchar(10) NOT NULL,
  `id_client` int(11) NOT NULL,
  `date_devis` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `devis`
--

INSERT INTO `devis` (`id`, `num_devis`, `id_client`, `date_devis`) VALUES
(1, '0001/03-22', 197, '2022-03-10'),
(2, '0002/03-22', 199, '2022-03-10'),
(3, '0003/03-22', 198, '2022-03-10'),
(4, '0004/03-22', 197, '2022-03-10'),
(5, '0005/03-22', 1015, '2022-03-10'),
(6, '0006/03-22', 1015, '2022-03-10'),
(7, '0007/03-22', 1015, '2022-03-10');

-- --------------------------------------------------------

--
-- Table structure for table `devis_details`
--

CREATE TABLE `devis_details` (
  `id` int(11) NOT NULL,
  `num_devis` varchar(10) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_ttc` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `devis_details`
--

INSERT INTO `devis_details` (`id`, `num_devis`, `reference`, `type`, `quantite`, `prix_ttc`) VALUES
(2, '0001/03-22', 'DS-2CE16H0T-ITF', 'CAMERA ANALOGIQUE', 58, 858),
(3, '0002/03-22', 'gvhbgvhb', 'vghbgvhb', 2, 60),
(4, '0003/03-22', 'CAMERA IP II68', 'CAMERA ANALOGIQUE', 13, 12),
(5, '0004/03-22', 'CAMERA IP II68', 'CAMERA ANALOGIQUE', 13, 22),
(7, '0005/03-22', 'CAMERA IP II68', 'CAMERA ANALOGIQUE', 2, 263),
(9, '0005/03-22', 'DS-2CE19U1T-IT3ZF', 'CAMERA 4K', 13, 20),
(10, '0005/03-22', 'ghf', 'dfgcnv', 1265, 12),
(11, '0005/03-22', 'sgfd', 'sgd', 13, 221),
(12, '0005/03-22', 'ZFESG', 'FES', 12, 4445),
(13, '0005/03-22', 'ZZZ', 'SZDZS', 45, 5896),
(14, '0005/03-22', 'SZADC', 'DQSZQ', 12, 452),
(15, '0005/03-22', 'HNHFTN', 'FTYH', 6, 12),
(16, '0005/03-22', 'ERGER', 'YHGH', 12, 22),
(17, '0005/03-22', 'EGNTYH', 'ESTHTSDG', 36, 369),
(18, '0005/03-22', 'JYNHGB', 'JYHG', 12, 3695),
(19, '0005/03-22', 'YTDGFJNYUJGNF', 'TTNJTHUN', 8, 698),
(20, '0005/03-22', 'UYJGHFHT', 'TRJHNTHF', 4, 45),
(21, '0005/03-22', 'UJNTUGHJNTU', 'UTHGJNUG', 26, 236),
(22, '0005/03-22', 'TJNUTUTJUYHG', 'TUJNTDGQSD', 45, 53),
(23, '0005/03-22', 'TGJUETYJH', 'JYZRTSHDGV', 12, 125),
(24, '0005/03-22', 'YHFF', 'YHRFSGHG', 43, 345),
(25, '0005/03-22', 'khjgfyjghfb', 'kyhjgb', 47, 123),
(26, '0005/03-22', 'kjyhgn', 'yjhgfbf', 9, 60),
(27, '0005/03-22', 'utdhfjntdy', 'tjhdfhbtf', 1, 15),
(28, '0005/03-22', 'hjkuyjgh', 'uyjgh', 25, 22),
(29, '0005/03-22', 'jyugnfhgjn', 'utjydfhrt', 36, 3),
(30, '0005/03-22', 'hytdfhdrt', 'rthet', 25, 5),
(31, '0005/03-22', 'strdhdbt', 'rthgfd', 25, 36),
(32, '0006/03-22', 'dgfhb', 'fgvhbdrftgh', 25, 22),
(33, '0006/03-22', 'grffzdsf', 'drzdfzed', 2, 25),
(34, '0006/03-22', 'fedvfs', 'fsqvsf', 2, 22),
(35, '0006/03-22', 'cfdrsfr', 'sdcedde', 3, 33),
(36, '0006/03-22', 'zesdcezds', 'ezdsfez', 69, 22),
(37, '0006/03-22', 'dscsd', 'dsfczds', 55, 6),
(38, '0006/03-22', 'rfzadde', 'zefcsszsdf', 2, 22),
(39, '0006/03-22', 'srsgrthythy', 'yrhfghbrr', 3, 33),
(40, '0006/03-22', 'gfvtfhbteeggdgt', 'ttdfbteedf', 45, 5),
(41, '0006/03-22', 'trfhbrgfhtbrfh', 'trfdhtrhtr', 33, 33),
(42, '0006/03-22', 'htrhbrth', 'trhtrhrt', 6, 66),
(43, '0006/03-22', 'trhrthtrtr', 'ijlkkjh', 3, 33),
(44, '0006/03-22', 'sazda', 'sasadz', 5, 33),
(45, '0006/03-22', 'zadaz', 'tbete', 5, 55),
(46, '0006/03-22', 'qezfdzad', 'aecdaz', 6, 66),
(47, '0006/03-22', 'feztbr', 'yijhkhjh', 6, 77),
(48, '0006/03-22', 'nkjhjhgjh', 'khjvjhf', 6, 66),
(50, '0006/03-22', 'uygghg', 'gfghhg', 9, 9),
(51, '0006/03-22', 'tffcrfcv', 'rfvref', 56, 5),
(52, '0006/03-22', 'fgzrefzr', 'rzzvsd', 5, 663),
(53, '0006/03-22', 'trhggbrgfzef', 'rztbezrgfzr', 3, 658),
(54, '0006/03-22', 'tfdgrdfz', 'zrfzedfr', 163, 45589),
(55, '0006/03-22', 'yyrgghg', 'hgfhn', 2, 33),
(56, '0006/03-22', 'egghhhn', 'hyjtthrh', 36, 55),
(57, '0006/03-22', 'tegvfscd', 'hrtg', 22, 33),
(58, '0006/03-22', 'DS-2CE16H0T-ITF', 'CAMERA ANALOGIQUE', 22, 259),
(59, '0006/03-22', 'SOURIS SF 690', 'ACCESSOIRE', 25, 30),
(60, '0006/03-22', 'tfgyhj', 'tfghj', 58, 85),
(61, '0006/03-22', 'sdsada', 'deced', 6, 8585),
(62, '0006/03-22', 'dcdsc', 'zsdd', 58, 858),
(63, '0006/03-22', 'ecdsc', 'dc', 58, 82),
(64, '0006/03-22', 'fgvhbn', 'fgbhn', 8, 22),
(65, '0006/03-22', 'xxfcgvb', 'fgvhbn', 225, 25),
(66, '0006/03-22', 'fcgvhb', 'fcgvhb', 85, 4),
(67, '0006/03-22', 'fcgvh', 'fgvhb', 8, 44),
(68, '0006/03-22', 'fcgvhb', 'fcgvbh', 8, 58),
(69, '0006/03-22', 'dxfcgvbh', 'dcfgvb', 5, 9),
(70, '0006/03-22', 'dxfcgvhb', 'fcgv', 5, 58),
(71, '0006/03-22', 'fcgvhb', 'fcgvhb', 22, 2),
(72, '0006/03-22', 'fcgvhb', 'fcgvhbkjhvgbv', 5, 58),
(73, '0006/03-22', 'cvb', 'cvbn', 44, 8),
(74, '0006/03-22', 'fgh', 'ghnlkjh', 2, 88),
(75, '0006/03-22', 'bcfhj', 'ghjh', 8, 5),
(76, '0006/03-22', 'fghvg', 'jhg', 22, 5),
(77, '0007/03-22', 'DE-KS602', 'VIDEO PHONE', 5, 66);

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `num_facture` varchar(15) DEFAULT NULL,
  `mt_total` float NOT NULL,
  `date_facture` date DEFAULT NULL,
  `num_cheque` varchar(15) DEFAULT NULL,
  `mt_cheque` float DEFAULT NULL,
  `especes` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`id`, `num_facture`, `mt_total`, `date_facture`, `num_cheque`, `mt_cheque`, `especes`) VALUES
(1, '0001/03-22', 3425, '2022-03-10', '6635', 3425, 0);

-- --------------------------------------------------------

--
-- Table structure for table `paiement`
--

CREATE TABLE `paiement` (
  `id` int(11) NOT NULL,
  `n_bon` varchar(20) DEFAULT NULL,
  `num_cheque` varchar(30) DEFAULT NULL,
  `mt_cheque` float DEFAULT NULL,
  `especes` float DEFAULT NULL,
  `virement` float DEFAULT NULL,
  `reste` float DEFAULT NULL,
  `date_Encaissement` date DEFAULT NULL,
  `Echeance` date DEFAULT NULL,
  `debit` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paiement`
--

INSERT INTO `paiement` (`id`, `n_bon`, `num_cheque`, `mt_cheque`, `especes`, `virement`, `reste`, `date_Encaissement`, `Echeance`, `debit`) VALUES
(1, '2000/ER', '', 0, 243, 0, 0, '2022-01-08', '1900-01-01', 'Non'),
(2, '2136/EZ', '', 0, 16200, 0, 33, '1900-01-01', '1900-01-01', 'Non'),
(3, '6398/EQ', '', 0, 20, 0, 20, '1900-01-01', '1900-01-01', 'Non'),
(4, '6235/EZ', '365566', 360, 0, 0, 0, '2022-02-26', '2022-02-25', 'Non'),
(5, '3651/EQ', '', 0, 312, 0, 0, '2022-02-27', '1900-01-01', 'Non'),
(6, '3651/EQ', '', 0, 312, 0, 0, '2022-02-27', '1900-01-01', 'Non');

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE `reference` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reference`
--

INSERT INTO `reference` (`id`, `reference`, `prix`) VALUES
(2, 'DS-2CE16H0T-ITF', 150.3);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `N_serie` varchar(20) NOT NULL,
  `fournisseur` varchar(50) DEFAULT NULL,
  `date_entre` date DEFAULT NULL,
  `N_bon` varchar(15) DEFAULT NULL,
  `etat_vente` varchar(3) DEFAULT NULL,
  `date_vente` date DEFAULT NULL,
  `prix_vente` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `type`, `reference`, `N_serie`, `fournisseur`, `date_entre`, `N_bon`, `etat_vente`, `date_vente`, `prix_vente`) VALUES
(5, 'NVR', 'NVR D1365II DJ', 'F9618315', 'HIK', '2021-11-08', '', 'Non', '1900-01-01', 0),
(6, 'CAMERA', 'CAMERA IP II68', 'F966985', 'HIK', '2021-11-08', '', 'Non', '1900-01-01', 0),
(7, 'CAMERA', 'CAMERA IP II68', 'f126862', 'HIK', '2021-11-10', '', 'Non', '1900-01-01', 0),
(8, 'CAMERA ANALOGIQUE', 'DS-2CE16H0T-ITF', 'F15236556', 'KGB', '2021-11-10', NULL, 'Non', '1900-01-01', NULL),
(12, 'CAMERA ANALOGIQUE', 'CAMERA IP II68', 'r15573', 'HIK', '2021-11-10', NULL, 'Non', '1900-01-01', NULL),
(13, 'CAMERA ANALOGIQUE', 'CAMERA IP II68', 'Q4696856', 'HIK', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(14, 'CAMERA ANALOGIQUE', 'CAMERA IP II68', 'R1336985', 'HIK', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(15, 'CAMERA', 'CAMERA IP II68', 'E136698', 'KGB', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(16, 'vghbgvhb', 'gvhbgvhb', 'y18468', 'chgvhb', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(17, 'CAMERA', 'CAMERA IP II68', '8566635', 'dzsdx', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(18, 'cgvhv', 'hjbgjhb', 'Z165636', 'ftvjghb', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(19, 'cgvhv', 'hjbgjhb', 'GGHrcsd13', 'ftvjghb', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(20, 'cgvhv', 'hjbgjhb', 'sbdhs', 'ftvjghb', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(21, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882143', 'XKL', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(22, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882161', 'XKL', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(23, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882144', 'XKL', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(24, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882146', 'XKL', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(25, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882109', 'XKL', '2021-11-11', '', 'Non', '1900-01-01', 0),
(26, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882118', 'XKL', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(27, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882092', 'XKL', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(28, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882105', 'XKL', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(29, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882124', 'XKL', '2021-11-11', NULL, 'Non', '1900-01-01', NULL),
(30, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882126', 'XKL', '2021-11-11', '', 'Non', '1900-01-01', 0),
(31, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882102', 'XKL', '2021-11-11', '7521/EC', 'Oui', '2021-11-13', 1295),
(32, 'CAMERA 4K', 'DS-2CE19U1T-IT3ZF', 'G32882131', 'XKL', '2021-11-11', '', 'Non', '1900-01-01', 0),
(33, 'CAMERA ANALOGIQUE', 'DS-2CE16H0T-ITF', '54', 'FIRST', '2022-02-27', NULL, 'Non', '1900-01-01', NULL),
(34, 'CAMERA ANALOGIQUE', 'DS-2CE16H0T-ITF', '', '', '2022-02-27', '5000/EV', 'Oui', '2022-02-28', 0),
(35, 'VIDEO PHONE', 'DE-KS602', 'F12666584', 'ECV', '2022-02-28', NULL, 'Non', '1900-01-01', NULL),
(36, 'VIDEO PHONE', 'DE-KS602', 'J17875185', 'ECV', '2022-02-28', NULL, 'Non', '1900-01-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'Administrateur');

-- --------------------------------------------------------

--
-- Table structure for table `vente_article`
--

CREATE TABLE `vente_article` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_articles` int(11) NOT NULL,
  `N_bon` varchar(15) NOT NULL,
  `quantite` int(10) NOT NULL,
  `prix_vente` float NOT NULL,
  `date_vente` date NOT NULL,
  `facture` varchar(3) NOT NULL,
  `num_facture` varchar(20) NOT NULL,
  `bl` varchar(3) NOT NULL,
  `num_bl` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vente_article`
--

INSERT INTO `vente_article` (`id`, `id_client`, `id_articles`, `N_bon`, `quantite`, `prix_vente`, `date_vente`, `facture`, `num_facture`, `bl`, `num_bl`) VALUES
(10, 13, 4, '7521/EC', 2, 21, '2021-11-13', 'Oui', '0001/03-22', 'Non', ''),
(11, 13, 6, '7521/EC', 1, 1000, '2021-11-13', 'Oui', '0001/03-22', 'Non', ''),
(13, 15, 5, '7968/EQ', 5, 150, '2021-11-13', 'Non', '', 'Non', ''),
(14, 13, 6, '7639/DC', 8, 136, '2021-11-22', 'Oui', '0001/03-22', 'Non', ''),
(17, 19, 5, '2000/ER', 1, 120, '2021-12-21', 'Non', '', 'Non', ''),
(18, 19, 2, '2000/ER', 1, 123, '2021-12-21', 'Non', '', 'Non', ''),
(19, 20, 2, '3651/EQ', 2, 156, '2021-12-21', 'Non', '', 'Non', ''),
(20, 16, 4, '6398/EQ', 2, 20, '2022-01-04', 'Non', '', 'Non', ''),
(21, 18, 2, '6235/EZ', 3, 120, '2022-01-05', 'Non', '', 'Non', '');

-- --------------------------------------------------------

--
-- Table structure for table `vente_details`
--

CREATE TABLE `vente_details` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `N_serie` varchar(20) NOT NULL,
  `N_bon` varchar(15) NOT NULL,
  `prix_vente` float NOT NULL,
  `date_vente` date NOT NULL,
  `facture` varchar(3) NOT NULL,
  `num_facture` varchar(20) NOT NULL,
  `bl` varchar(3) NOT NULL,
  `num_bl` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vente_details`
--

INSERT INTO `vente_details` (`id`, `id_client`, `N_serie`, `N_bon`, `prix_vente`, `date_vente`, `facture`, `num_facture`, `bl`, `num_bl`) VALUES
(8, 13, 'G32882102', '7521/EC', 1295, '2021-11-13', 'Oui', '0001/03-22', 'Non', ''),
(11, 2, '', '5000/EV', 0, '2022-02-28', 'Non', '', 'Non', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bl`
--
ALTER TABLE `bl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caisse`
--
ALTER TABLE `caisse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheques`
--
ALTER TABLE `cheques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`id`,`num_devis`),
  ADD KEY `idc` (`id_client`);

--
-- Indexes for table `devis_details`
--
ALTER TABLE `devis_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reference`
--
ALTER TABLE `reference`
  ADD PRIMARY KEY (`id`,`reference`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`,`N_serie`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vente_article`
--
ALTER TABLE `vente_article`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id_article` (`id_articles`),
  ADD KEY `id_client` (`id_client`);

--
-- Indexes for table `vente_details`
--
ALTER TABLE `vente_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vente_details_ibfk_1` (`id_client`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bl`
--
ALTER TABLE `bl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `caisse`
--
ALTER TABLE `caisse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cheques`
--
ALTER TABLE `cheques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1016;

--
-- AUTO_INCREMENT for table `devis`
--
ALTER TABLE `devis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `devis_details`
--
ALTER TABLE `devis_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `facture`
--
ALTER TABLE `facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reference`
--
ALTER TABLE `reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vente_article`
--
ALTER TABLE `vente_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `vente_details`
--
ALTER TABLE `vente_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `idc` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`);

--
-- Constraints for table `vente_article`
--
ALTER TABLE `vente_article`
  ADD CONSTRAINT `id_article` FOREIGN KEY (`id_articles`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `id_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`);

--
-- Constraints for table `vente_details`
--
ALTER TABLE `vente_details`
  ADD CONSTRAINT `vente_details_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
