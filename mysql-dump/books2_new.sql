-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 05:20 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books2_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `auteur`
--

CREATE TABLE `auteur` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biographie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auteur`
--

INSERT INTO `auteur` (`id`, `prenom`, `nom`, `biographie`) VALUES
(1, 'Hugo', 'Victor', ''),
(2, 'Zola', 'Émile', ''),
(3, 'Camus', 'Albert', ''),
(4, 'Verne', 'Jules', ''),
(5, 'Proust', 'Marcel', ''),
(6, 'de Beauvoir', 'Simone', ''),
(7, 'Orwell', 'George', ''),
(8, 'Austen', 'Jane', ''),
(9, 'Nietzsche', 'Friedrich', ''),
(10, 'Christie', 'Agatha', '');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `designation`, `description`) VALUES
(1, 'Fiction', 'Books that contain events and characters created from the imagination.'),
(2, 'Non-Fiction', 'Books based on real events, people, or facts.'),
(3, 'Fantasy', 'Books that feature magical elements and fantastical worlds.'),
(4, 'Science Fiction', 'Books that explore futuristic settings, advanced technology, and space exploration.'),
(5, 'Mystery', 'Books that revolve around solving a crime or uncovering secrets.'),
(6, 'Biography', 'Books that tell the story of a person\'s life.'),
(7, 'Romance', 'Books that focus on romantic relationships and love stories.'),
(8, 'Historical', 'Books that are set in the past and often depict historical events.'),
(9, 'Thriller', 'Books that are full of suspense, excitement, and tension.'),
(10, 'Self-Help', 'Books designed to help readers solve personal problems or improve aspects of their lives.');

-- --------------------------------------------------------

--
-- Table structure for table `editeur`
--

CREATE TABLE `editeur` (
  `id` int(11) NOT NULL,
  `nom_editeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `editeur`
--

INSERT INTO `editeur` (`id`, `nom_editeur`, `pays`, `address`, `telephone`) VALUES
(1, 'Bloomsbury', 'United Kingdom', '50 Bedford Square, London', '00442076315600'),
(2, 'Penguin Random House', 'United States', '1745 Broadway, New York', '0012127829000'),
(3, 'HarperCollins', 'United States', '195 Broadway, New York', '0012122077000'),
(4, 'Houghton Mifflin Harcourt', 'United States', '125 High Street, Boston', '0016173515000');

-- --------------------------------------------------------

--
-- Table structure for table `emprunt`
--

CREATE TABLE `emprunt` (
  `id` int(11) NOT NULL,
  `data_emprunt` datetime NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emprunt_livre`
--

CREATE TABLE `emprunt_livre` (
  `emprunt_id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emprunt_user`
--

CREATE TABLE `emprunt_user` (
  `emprunt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livre`
--

CREATE TABLE `livre` (
  `id` int(11) NOT NULL,
  `editeur_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_pages` int(11) NOT NULL,
  `date_edition` date NOT NULL,
  `nb_exemplaire` int(11) NOT NULL,
  `prix` double NOT NULL,
  `isbn` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livre_auteur`
--

CREATE TABLE `livre_auteur` (
  `livre_id` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250114171148', '2025-01-15 15:48:00', 2771);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbre_avertissement` int(11) NOT NULL,
  `black_listed` tinyint(1) NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nom`, `prenom`, `nbre_avertissement`, `black_listed`, `is_verified`) VALUES
(1, 'admin@example.com', '[\"ROLE_ADMIN\"]', '$2y$13$Bm9Ii6dlxLLitlNJGxmXR.nMW4BOyepifrF2MiweaoFom1F4wcuvK', '', '', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editeur`
--
ALTER TABLE `editeur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emprunt`
--
ALTER TABLE `emprunt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emprunt_livre`
--
ALTER TABLE `emprunt_livre`
  ADD PRIMARY KEY (`emprunt_id`,`livre_id`),
  ADD KEY `IDX_562087F2AE7FEF94` (`emprunt_id`),
  ADD KEY `IDX_562087F237D925CB` (`livre_id`);

--
-- Indexes for table `emprunt_user`
--
ALTER TABLE `emprunt_user`
  ADD PRIMARY KEY (`emprunt_id`,`user_id`),
  ADD KEY `IDX_C166DE57AE7FEF94` (`emprunt_id`),
  ADD KEY `IDX_C166DE57A76ED395` (`user_id`);

--
-- Indexes for table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AC634F993375BD21` (`editeur_id`),
  ADD KEY `IDX_AC634F99BCF5E72D` (`categorie_id`);

--
-- Indexes for table `livre_auteur`
--
ALTER TABLE `livre_auteur`
  ADD PRIMARY KEY (`livre_id`,`auteur_id`),
  ADD KEY `IDX_A11876B537D925CB` (`livre_id`),
  ADD KEY `IDX_A11876B560BB6FE6` (`auteur_id`);

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `editeur`
--
ALTER TABLE `editeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `emprunt`
--
ALTER TABLE `emprunt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `livre`
--
ALTER TABLE `livre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emprunt_livre`
--
ALTER TABLE `emprunt_livre`
  ADD CONSTRAINT `FK_562087F237D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_562087F2AE7FEF94` FOREIGN KEY (`emprunt_id`) REFERENCES `emprunt` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emprunt_user`
--
ALTER TABLE `emprunt_user`
  ADD CONSTRAINT `FK_C166DE57A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C166DE57AE7FEF94` FOREIGN KEY (`emprunt_id`) REFERENCES `emprunt` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `FK_AC634F993375BD21` FOREIGN KEY (`editeur_id`) REFERENCES `editeur` (`id`),
  ADD CONSTRAINT `FK_AC634F99BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

--
-- Constraints for table `livre_auteur`
--
ALTER TABLE `livre_auteur`
  ADD CONSTRAINT `FK_A11876B537D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A11876B560BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
