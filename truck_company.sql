-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 15 jan 2019 kl 23:37
-- Serverversion: 10.1.35-MariaDB
-- PHP-version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `truck_company`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `contacts`
--

CREATE TABLE `contacts` (
  `name` varchar(100) NOT NULL,
  `address` varchar(300) NOT NULL,
  `phone` bigint(13) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `contractor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `contacts`
--

INSERT INTO `contacts` (`name`, `address`, `phone`, `email`, `contractor`) VALUES
('Johan Sibart', 'none', 46704995993, 'johan_sibart@jm.se', 'JM Bygg'),
('Linus Akesson', 'none', 46714294793, 'linus@jm.se', 'JM Bygg'),
('Linus Johansson', 'none', 46723995221, 'linus@gmail.com', 'Foria'),
('Therese Bergart', 'none', 46724496793, 'bergart@gmail.com', 'Peab'),
('Timo Wolf', 'none', 46733295672, 'timo@adelso.se', 'Adelso Entreprenad'),
('Johan Ritwerd', 'none', 46733295913, 'ritwerd@svevia.se', 'Svevia'),
('Fredirk Grund', 'none', 46734295193, 'grund_fr@gmail.com', 'Adelso Entreprenad'),
('Anna Klint', 'none', 46734921953, 'klint_anna@peab.se', 'Peab'),
('Stefan Berg', 'none', 46744291123, 'berg_stefan@svevia.se', 'Svevia');

-- --------------------------------------------------------

--
-- Tabellstruktur `contractors`
--

CREATE TABLE `contractors` (
  `name` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `address` varchar(300) NOT NULL,
  `phone` bigint(13) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `contractors`
--

INSERT INTO `contractors` (`name`, `description`, `address`, `phone`, `email`) VALUES
('Adelso Entreprenad', 'Company handling roadwork, digging, entreprenad', 'BryggavÃ¤gen 127, 178 31 EkerÃ¶', 46856031015, 'info@adelsoentreprenad.se'),
('Foria', 'Company handling roadwork, digging, entreprenad', 'Hammarbacken 6A, 191 49 Sollentuna', 46104745000, 'info@foria.se'),
('JM Bygg', 'Company handling construction, renovation, entreprenad', 'Gustav III:s Boulevard 64, 169 74 Solna', 4687828700, 'info@jm.se'),
('Peab', 'Company handling construction, roadwork, infrastructure, asphalt', 'GÃ¥rdsvÃ¤gen 6, 169 70 Solna', 4686236800, 'info@peab.se'),
('Ragn-Sells', 'Company handling garbage, recycling', 'Regeringsgatan 55, 111 56 Stockholm', 46771888888, 'info@ragnsells.com'),
('Svevia', 'Company handling infrastructure, roadwork, asphalt', 'SvetsarvÃ¤gen 8A, 171 41 Solna', 4684041000, 'info@svevia.se');

-- --------------------------------------------------------

--
-- Tabellstruktur `drivers`
--

CREATE TABLE `drivers` (
  `persnr` bigint(12) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(300) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(13) UNSIGNED NOT NULL,
  `contract_start` date NOT NULL,
  `contract_end` date NOT NULL,
  `ce_license` tinyint(1) NOT NULL,
  `exp_ykb` date NOT NULL,
  `fuel_card` bigint(40) NOT NULL,
  `unavailable` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `drivers`
--

INSERT INTO `drivers` (`persnr`, `name`, `address`, `email`, `phone`, `contract_start`, `contract_end`, `ce_license`, `exp_ykb`, `fuel_card`, `unavailable`) VALUES
(195606110205, 'John Bergman', 'Rimbovagen 140, xxxxx, Rimbo', 'john@gmail.com', 46720990034, '2004-06-12', '2015-09-22', 1, '2019-07-12', 5232855527282, '0000-00-00'),
(196112310023, 'Billy Strandqvist', 'Oxdragarbacken 11, xxxxx, Norrtalje', 'oxdragarbacken@gmail.com', 46708392411, '1990-03-22', '0000-00-00', 1, '2022-03-14', 12311125466, '0000-00-00'),
(196406240022, 'Rickard Brunholf', 'Hemnasvagen 220, xxxxx, Upplands Vasby', 'rickard@gmail.com', 46733892888, '2004-06-12', '2015-09-22', 1, '2019-07-12', 234283556282, '0000-00-00'),
(197307020240, 'Fredrik Bergkvist', 'Akersbergavagen 12, xxxxx, Akersberga', 'fredrik@gmail.com', 46733502189, '2004-06-12', '2015-09-22', 0, '2019-07-12', 1292835767272, '0000-00-00'),
(198104180254, 'Stefan Klingberg', 'Vallentunavagen 9, xxxxx, Vallentuna', 'stefan@gmail.com', 46789828223, '2004-06-12', '2015-09-22', 1, '2019-07-12', 5295568922282, '2019-01-24'),
(198212160246, 'Andreas Strandqvist', 'Avldalsvagen 21, 16575 Hassleby', 'likvidation@gmail.com', 46723125223, '2004-06-12', '2015-09-22', 1, '2020-06-14', 2242638221222, '0000-00-00'),
(198409080051, 'Jonas Strandqvist', 'Dovregatan 20, 16436, Kista', 'lendzin@gmail.com', 46733502189, '2004-06-12', '2015-09-22', 1, '2019-07-12', 9292838727282, '2019-06-30'),
(198602140045, 'Peter Hammar', 'Tabyvagen 1, xxxxx, Taby', 'peter@gmail.com', 46987402345, '2004-06-12', '2015-09-22', 0, '2019-07-12', 2292438757687, '0000-00-00'),
(198905080230, 'Bert Adil', 'Bergsvagen 121, xxxxx, Danderyd', 'bert@gmail.com', 46879645888, '2004-06-12', '2015-09-22', 0, '2019-07-12', 6276858323282, '0000-00-00'),
(199011020167, 'Rolf Mojner', 'Tapetserarvagen 14, xxxxx, Norrtalje', 'rolf@gmail.com', 46119874758, '2004-06-12', '2015-09-22', 0, '2019-07-12', 2342833467282, '2018-12-29'),
(199509120220, 'Erik Stenkvist', 'Kvistvagen 421, xxxxx, Bergshamra', 'erik@gmail.com', 46098277833, '2004-06-12', '2015-09-22', 1, '2019-07-12', 2342834726682, '0000-00-00');

-- --------------------------------------------------------

--
-- Tabellstruktur `jobs`
--

CREATE TABLE `jobs` (
  `id` int(100) UNSIGNED NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `location` varchar(300) NOT NULL,
  `description` varchar(500) NOT NULL,
  `truck` varchar(6) NOT NULL,
  `contractor` varchar(50) NOT NULL,
  `driver` bigint(12) NOT NULL,
  `contact` bigint(13) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `jobs`
--

INSERT INTO `jobs` (`id`, `start_time`, `end_time`, `location`, `description`, `truck`, `contractor`, `driver`, `contact`) VALUES
(2, '2019-01-01', '2019-01-02', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'BXP465', 'JM Bygg', 196112310023, 46723995221),
(4, '2019-01-03', '2019-01-03', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'BXP465', 'Foria', 196112310023, 46714294793),
(5, '2019-01-04', '2019-01-04', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'EXB053', 'Adelso Entreprenad', 197307020240, 46733295913),
(6, '2019-01-08', '2019-01-10', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'EXB058', 'Adelso Entreprenad', 196112310023, 46704995993),
(7, '2019-01-16', '2019-01-24', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'RXY248', 'Peab', 196406240022, 46724496793),
(9, '2019-01-16', '2019-01-24', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'RXY242', 'Ragn-Sells', 197307020240, 46724496793),
(10, '2019-01-02', '2019-01-09', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'RXY256', 'Peab', 195606110205, 46723995221),
(11, '2019-01-01', '2019-01-10', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'BRE292', 'JM Bygg', 198602140045, 46723995221),
(12, '2019-01-01', '2019-01-10', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'TXY621', 'Peab', 198905080230, 46733295672),
(13, '2018-12-27', '2019-01-09', 'BiovÃ¤gen 12, 12627, Ã…kersberga', 'Saltning, plogning', 'RXY248', 'Foria', 196406240022, 46714294793),
(14, '2018-09-04', '2018-09-21', 'Alajkdnlalasndas\r\nasdasd\r\nasdaksdmas\r\n', 'sadfasdfasdf\r\naslkkdmsksdasad\r\nakdslkasdla', 'EXB058', 'Peab', 197307020240, 46724496793),
(17, '2018-12-28', '2018-12-28', 'Addressroad 2', 'no idea what they\'ll do', 'BXP465', 'Foria', 196112310023, 46714294793),
(19, '2018-12-28', '2018-12-28', 'Addressroad 2', 'no idea what they\'ll do', 'RXY242', 'Ragn-Sells', 198905080230, 46723995221),
(20, '2019-01-02', '2019-01-02', 'asda', 'asda', 'EXB053', 'Adelso Entreprenad', 196406240022, 46714294793),
(22, '2019-01-05', '2019-01-05', 'an address', 'a desc', 'BNL376', 'Adelso Entreprenad', 198212160246, 46724496793);

-- --------------------------------------------------------

--
-- Tabellstruktur `trucks`
--

CREATE TABLE `trucks` (
  `regnr` varchar(6) NOT NULL,
  `model` varchar(50) NOT NULL,
  `min_weight` int(5) NOT NULL,
  `max_weight` int(5) NOT NULL,
  `axels` int(2) NOT NULL,
  `trailer` tinyint(1) NOT NULL,
  `equipment` varchar(100) NOT NULL,
  `build_year` year(4) NOT NULL,
  `warranty` date NOT NULL,
  `last_tested` date NOT NULL,
  `last_service` date NOT NULL,
  `last_lubrication` date NOT NULL,
  `unavailable_until` date NOT NULL,
  `rented_until` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `trucks`
--

INSERT INTO `trucks` (`regnr`, `model`, `min_weight`, `max_weight`, `axels`, `trailer`, `equipment`, `build_year`, `warranty`, `last_tested`, `last_service`, `last_lubrication`, `unavailable_until`, `rented_until`) VALUES
('BNL376', 'SCANIA R500', 27000, 60000, 3, 1, 'gravel_trailer', 2017, '2022-09-07', '2017-06-03', '2018-09-12', '2018-09-12', '0000-00-00', '0000-00-00'),
('BRE292', 'VOLVO F50', 27000, 42000, 3, 1, 'hooklift', 2018, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '2019-01-23'),
('BXP465', 'SCANIA R480', 32500, 48000, 4, 1, 'plow, salter, hooklift', 2010, '2015-10-10', '2018-07-19', '2018-11-01', '2018-12-01', '0000-00-00', '0000-00-00'),
('EXB053', 'MAN TGM', 24500, 33000, 2, 0, 'garbage', 2008, '2013-04-12', '2018-03-12', '2018-07-13', '2018-07-13', '0000-00-00', '0000-00-00'),
('EXB058', 'MAN TGM', 24500, 33000, 2, 0, 'garbage', 2008, '2013-04-12', '2018-03-19', '2018-07-26', '2018-07-26', '0000-00-00', '0000-00-00'),
('RXY242', 'SCANIA R650', 31900, 48000, 4, 1, 'hooklift', 2018, '2023-10-10', '2018-10-16', '2018-11-12', '2018-11-12', '0000-00-00', '0000-00-00'),
('RXY248', 'SCANIA R650', 31900, 48000, 4, 1, 'hooklift', 2018, '2023-10-10', '2018-10-16', '2018-10-16', '2018-11-23', '0000-00-00', '0000-00-00'),
('RXY256', 'SCANIA R650', 31900, 48000, 4, 1, 'hooklift', 2018, '2023-10-10', '2018-10-16', '2018-10-16', '2018-11-15', '0000-00-00', '0000-00-00'),
('TXY621', 'SCANIA R550', 32500, 48000, 4, 1, 'salter, hooklift', 2012, '2018-01-14', '2018-12-01', '2018-09-05', '2018-12-20', '0000-00-00', '0000-00-00'),
('VAX128', 'VOLVO F50', 27000, 42000, 3, 1, 'plow, salter, hooklift', 2014, '2018-06-11', '2018-06-06', '2018-10-12', '2018-12-11', '2019-01-03', '0000-00-00'),
('VHA253', 'VOLVO F40', 24500, 40000, 3, 1, 'hooklift', 2010, '2014-03-11', '2018-01-09', '2018-09-12', '2018-11-25', '0000-00-00', '0000-00-00');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`phone`);

--
-- Index för tabell `contractors`
--
ALTER TABLE `contractors`
  ADD PRIMARY KEY (`name`);

--
-- Index för tabell `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`persnr`);

--
-- Index för tabell `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `truck` (`truck`),
  ADD KEY `contractor` (`contractor`),
  ADD KEY `driver` (`driver`),
  ADD KEY `contact` (`contact`);

--
-- Index för tabell `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`regnr`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`driver`) REFERENCES `drivers` (`persnr`),
  ADD CONSTRAINT `jobs_ibfk_2` FOREIGN KEY (`truck`) REFERENCES `trucks` (`regnr`),
  ADD CONSTRAINT `jobs_ibfk_4` FOREIGN KEY (`contractor`) REFERENCES `contractors` (`name`),
  ADD CONSTRAINT `jobs_ibfk_5` FOREIGN KEY (`contact`) REFERENCES `contacts` (`phone`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
