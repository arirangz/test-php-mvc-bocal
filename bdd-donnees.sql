-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 22 août 2022 à 17:28
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `test-bocal-academy`
--

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `first_name`, `last_name`, `email`, `phone`, `created_at`) VALUES
(19, 'Anthony', 'Laplane', 'anthony.laplane@gmail.com', '+33610666245', '2022-08-22 17:13:13'),
(20, 'Pierre', 'Grand', 'pierre@gmail.com', '', '2022-08-22 17:26:52');

--
-- Déchargement des données de la table `invoice`
--

INSERT INTO `invoice` (`id`, `date`, `number`, `total_tax_excl`, `total_tax_incl`, `tax_rate`, `title`, `client_id`, `created_at`) VALUES
(10, '2022-08-22', '22082022-19-56', '800.000000', '960.000000', '20.000', 'Test aaa', 19, '2022-08-22 17:13:37');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
