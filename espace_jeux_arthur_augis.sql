-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 06 fév. 2024 à 11:09
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `espace_jeux_arthur_augis`
--
CREATE DATABASE IF NOT EXISTS `espace_jeux_arthur_augis` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `espace_jeux_arthur_augis`;

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `proc_jeux_avec_tournois`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_jeux_avec_tournois` ()   BEGIN

SELECT tab_platforme_jeu.jeu
FROM tab_platforme_jeu
INNER JOIN tab_tournois ON tab_platforme_jeu.id = tab_tournois.jeu;

END$$

DROP PROCEDURE IF EXISTS `proc_jeux_sans_tournois`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_jeux_sans_tournois` ()   BEGIN

SELECT tab_platforme_jeu.jeu
FROM tab_platforme_jeu
LEFT JOIN tab_tournois ON tab_platforme_jeu.id = tab_tournois.jeu
WHERE tab_tournois.jeu IS NULL;

END$$

DROP PROCEDURE IF EXISTS `proc_login`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_login` (IN `mail` VARCHAR(100))   BEGIN
    SELECT tab_utilisateurs.mdp, tab_utilisateurs.pseudo, tab_utilisateurs.age, tab_utilisateurs.admin
    FROM tab_utilisateurs
    WHERE tab_utilisateurs.mail = mail;
END$$

DROP PROCEDURE IF EXISTS `proc_pourcent_vote`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_pourcent_vote` ()   BEGIN

SELECT jeu, 
ROUND(
(COUNT(utilisateur) * 100.0 / 
(SELECT COUNT(*) FROM tab_voter)), 0) as pourcentage
FROM tab_voter
GROUP BY jeu;


END$$

--
-- Fonctions
--
DROP FUNCTION IF EXISTS `func_ajouter_categorie`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajouter_categorie` (`libelle` VARCHAR(50)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_categories.id) INTO EXISTE
FROM tab_categories
WHERE tab_categories.nom_categorie = libelle;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_categories(nom_categorie) VALUES (libelle);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajouter_tournoi`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajouter_tournoi` (`jeu_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_tournois.id) INTO EXISTE
FROM tab_tournois
WHERE tab_tournois.jeu = jeu_id;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_tournois(jeu) VALUES (jeu_id);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_classement`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_classement` (`_utilisateur` INT, `_tournoi` INT, `_place` INT, `_eliminer` BOOLEAN) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_classement.tournoi) INTO EXISTE
FROM tab_classement
WHERE tab_classement.tournoi = _tournoi
AND tab_classement.place = _place;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_classement VALUES (_utilisateur, _tournoi, _place, _eliminer);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_inscription`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_inscription` (`utilisateur_id` INT, `tournoi_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_inscrire.utilisateur) INTO EXISTE
FROM tab_inscrire
WHERE tab_inscrire.utilisateur = utilisateur_id AND tab_inscrire.tournoi = tournoi_id;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_inscrire VALUES (utilisateur_id, tournoi_id);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_jeu_plateforme`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_jeu_plateforme` (`jeu_id` INT, `plateforme_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_platforme_jeu.id) INTO EXISTE
FROM tab_platforme_jeu
WHERE tab_platforme_jeu.jeu = jeu_id AND tab_platforme_jeu.plateforme = plateforme_id;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_platforme_jeu (jeu, plateforme) VALUES (jeu_id, plateforme_id);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_plateforme`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_plateforme` (`libelle` VARCHAR(50)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_plateformes.id) INTO EXISTE
FROM tab_plateformes
WHERE tab_plateformes.nom = libelle;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_plateformes(nom) VALUES (libelle);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_question`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_question` (`question` VARCHAR(200)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_questions.id) INTO EXISTE
FROM tab_questions
WHERE tab_questions.libelle = question;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_questions(libelle) VALUES (question);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_recompense`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_recompense` (`_tournoi` INT, `_place` INT, `_libelle` VARCHAR(1000)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = 1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = 1452;

INSERT INTO tab_recompenses VALUES (_tournoi, _place, _libelle);

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_reponse`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_reponse` (`reponse` VARCHAR(300)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_reponses.id) INTO EXISTE
FROM tab_reponses
WHERE tab_reponses.libelle = reponse;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_reponses(libelle) VALUES (reponse);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_session_tournoi`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_session_tournoi` (`_tournoi` INT, `_date` DATE, `_heure_debut` TIME, `_nbplaces` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

IF DATEDIFF(_date, NOW() > 0) THEN
	INSERT INTO tab_tournoi_session(tournoi, date, heure_debut, nbplaces) VALUES (_tournoi, _date, _heure_debut, _nbplaces);
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_changerAge`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_changerAge` (`_age` INT, `_mail` VARCHAR(100)) RETURNS INT  BEGIN
    UPDATE `tab_utilisateurs` SET `age` = _age WHERE `mail` = _mail; 
    RETURN (SELECT age FROM tab_utilisateurs WHERE `mail` = _mail); 
END$$

DROP FUNCTION IF EXISTS `func_changerMail`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_changerMail` (`nouveaumail` VARCHAR(100), `_mail` VARCHAR(100)) RETURNS INT  BEGIN
DECLARE retour INT;
DECLARE existe INT;

    SELECT COUNT(*) INTO existe
    FROM tab_utilisateurs
    WHERE tab_utilisateurs.mail = nouveaumail;
    
    IF existe > 0 THEN
        SET retour = -1;
    ELSE
    	UPDATE tab_utilisateurs SET mail = nouveaumail WHERE mail = _mail;
        SET retour = (SELECT id FROM tab_utilisateurs WHERE mail = nouveaumail); 
    END IF;
    
    RETURN retour;
END$$

DROP FUNCTION IF EXISTS `func_changerMdp`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_changerMdp` (`_mdp` VARCHAR(255), `_mail` VARCHAR(100)) RETURNS VARCHAR(255) CHARSET utf8mb4  BEGIN
    UPDATE `tab_utilisateurs` SET `mdp` = _mdp WHERE `mail` = _mail; 
    RETURN (SELECT `mdp` FROM tab_utilisateurs WHERE `mail` = _mail); 
END$$

DROP FUNCTION IF EXISTS `func_changerPseudo`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_changerPseudo` (`_pseudo` VARCHAR(50), `_mail` VARCHAR(100)) RETURNS INT  BEGIN
DECLARE retour INT;

DECLARE CONTINUE HANDLER FOR 1062
	SET retour  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET retour  = -1452;

    SELECT COUNT(*) INTO retour
    FROM tab_utilisateurs
    WHERE tab_utilisateurs.pseudo = _pseudo;
    
    IF retour > 0 THEN
        SET retour = "-1";
    ELSE
    	UPDATE `tab_utilisateurs` SET `pseudo` = _pseudo WHERE `mail` = _mail; 
        SET retour = (SELECT id FROM tab_utilisateurs WHERE `mail` = _mail AND `pseudo` = _pseudo); 
    END IF;
    
    RETURN retour;
END$$

DROP FUNCTION IF EXISTS `func_createUser`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_createUser` (`_login` VARCHAR(50), `_mail` VARCHAR(100), `_age` INT, `_mdp` VARCHAR(255)) RETURNS INT  BEGIN 
    DECLARE retour INT;
    
    DECLARE CONTINUE HANDLER FOR 1062
	SET retour  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET retour  = -1452;

    SELECT COUNT(*) INTO retour
    FROM tab_utilisateurs
    WHERE tab_utilisateurs.pseudo = _login;
    
    IF retour > 0 THEN
        SET retour = -1;
    ELSE
        SELECT COUNT(*) INTO retour
        FROM tab_utilisateurs
        WHERE tab_utilisateurs.mail = _mail;
        
        IF retour > 0 THEN
            SET retour = -2;
        ELSE
            INSERT INTO tab_utilisateurs (mail, pseudo, age, mdp)
            VALUES (_mail, _login, _age, _mdp);
            
            SET retour = LAST_INSERT_ID();
        END IF;
    END IF;
    
    RETURN retour;
END$$

DROP FUNCTION IF EXISTS `func_jeu_ajout_categorie`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_jeu_ajout_categorie` (`jeu_id` INT, `categorie_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_categoriser.jeu) INTO EXISTE
FROM tab_categoriser
WHERE tab_categoriser.jeu = jeu_id
AND tab_categoriser.categorie = categorie_id;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_categoriser VALUES (jeu_id, categorie_id);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_jeu_suppr_categorie`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_jeu_suppr_categorie` (`jeu_id` INT, `categorie_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_categoriser.jeu) INTO EXISTE
FROM tab_categoriser
WHERE tab_categoriser.jeu = jeu_id
AND tab_categoriser.categorie = categorie_id;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_categoriser` WHERE tab_categoriser.jeu = jeu_id AND tab_categoriser.categorie = categorie_id;
    SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_categorie`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_categorie` (`libelle` VARCHAR(50)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_categories.id) INTO EXISTE
FROM tab_categories
WHERE tab_categories.nom_categorie = libelle;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_categories` WHERE tab_categories.nom_categorie = libelle;
    SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_classement`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_classement` (`_utilisateur` INT, `_tournoi` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_classement.tournoi) INTO EXISTE
FROM tab_classement
WHERE tab_classement.tournoi = _tournoi
AND tab_classement.utilisateur = _utilisateur;

IF EXISTE <> 0 THEN
	DELETE FROM tab_classement WHERE tab_classement.utilisateur = _utilisateur AND tab_classement.tournoi = _tournoi;
	SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_inscription`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_inscription` (`utilisateur_id` INT, `tournoi_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_inscrire.utilisateur) INTO EXISTE
FROM tab_inscrire
WHERE tab_inscrire.utilisateur = utilisateur_id AND tab_inscrire.tournoi = tournoi_id;

IF EXISTE <> 0 THEN
	DELETE FROM tab_inscrire WHERE tab_inscrire.utilisateur = utilisateur_id AND tab_inscrire.tournoi = tournoi_id;
	SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_jeu_plateforme`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_jeu_plateforme` (`jeu_id` INT, `plateforme_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_platforme_jeu.id) INTO EXISTE
FROM tab_platforme_jeu
WHERE tab_platforme_jeu.jeu = jeu_id AND tab_platforme_jeu.plateforme = plateforme_id;

IF EXISTE <> 0 THEN
	DELETE FROM tab_platforme_jeu WHERE tab_platforme_jeu.jeu = jeu_id AND tab_platforme_jeu.plateforme = plateforme_id;
	SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_plateforme`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_plateforme` (`libelle` VARCHAR(50)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_plateformes.id) INTO EXISTE
FROM tab_plateformes
WHERE tab_plateformes.nom = libelle;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_plateformes` WHERE tab_plateformes.nom = libelle;
    SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_question`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_question` (`question` VARCHAR(200)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_questions.id) INTO EXISTE
FROM tab_questions
WHERE tab_questions.libelle = question;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_questions` WHERE tab_questions.libelle = question;
	SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_recompense`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_recompense` (`_tournoi` INT, `_place` INT, `_libelle` VARCHAR(1000)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = 1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = 1452;
    
SELECT COUNT(tab_recompenses.libelle) INTO EXISTE
FROM tab_recompenses
WHERE tab_recompenses.tournoi = _tournoi
AND tab_recompenses.place = _place
AND tab_recompenses.libelle = _libelle;

IF EXISTE <> 0 THEN
	INSERT INTO tab_recompenses VALUES (_tournoi, _place, _libelle);
    SET RETOUR = 1;
ELSE
	SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_reponse`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_reponse` (`reponse` VARCHAR(300)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_reponses.id) INTO EXISTE
FROM tab_reponses
WHERE tab_reponses.libelle = reponse;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_reponses` WHERE tab_reponses.libelle = reponse;
	SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_sesssion_tournoi`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_sesssion_tournoi` (`id_session` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

DELETE FROM tab_tournoi_session WHERE tab_tournoi_session.id = id_session;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_tournoi`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_tournoi` (`jeu_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_tournois.id) INTO EXISTE
FROM tab_tournois
WHERE tab_tournois.jeu = jeu_id;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_tournois` WHERE tab_tournois.jeu = jeu_id;
    SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_utilisateur`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_utilisateur` (`mail_user` VARCHAR(100)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_utilisateurs.id) INTO EXISTE
FROM tab_utilisateurs
WHERE tab_utilisateurs.mail = mail_user;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_utilisateurs` WHERE tab_utilisateurs.mail = mail_user;
	SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_vote_utilisateur`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_vote_utilisateur` (`jeu_id` INT, `util_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_voter.utilisateur) INTO EXISTE
FROM tab_voter
WHERE tab_voter.utilisateur = util.id AND tab_voter.jeu = jeu_id;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_voter` WHERE tab_voter.utilisateur = util.id AND tab_voter.jeu = jeu_id;
	SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_voter`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_voter` (`_utilisateur` INT, `_jeuChoisi` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE nbJeu INT;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_voter.jeu) INTO nbJeu
FROM tab_voter
INNER JOIN tab_platforme_jeu ON tab_voter.jeu = tab_platforme_jeu.jeu
WHERE tab_platforme_jeu.plateforme = 
(SELECT tab_platforme_jeu.plateforme
FROM tab_platforme_jeu 
WHERE jeu = _jeuChoisi)
AND tab_voter.utilisateur = _utilisateur;

IF nbJeu <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_voter (utilisateur, jeu)
    VALUES (_utilisateur, _jeuChoisi);
    
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `tab_attribuer`
--

DROP TABLE IF EXISTS `tab_attribuer`;
CREATE TABLE IF NOT EXISTS `tab_attribuer` (
  `question` int NOT NULL,
  `reponse` int NOT NULL,
  `bonnereponse` tinyint(1) NOT NULL,
  KEY `ce_questions_attribuer` (`question`),
  KEY `ce_reponses_attribuer` (`reponse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_categories`
--

DROP TABLE IF EXISTS `tab_categories`;
CREATE TABLE IF NOT EXISTS `tab_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_categories`
--

INSERT INTO `tab_categories` (`id`, `nom_categorie`) VALUES
(3, 'truc'),
(4, 'bidule');

-- --------------------------------------------------------

--
-- Structure de la table `tab_categoriser`
--

DROP TABLE IF EXISTS `tab_categoriser`;
CREATE TABLE IF NOT EXISTS `tab_categoriser` (
  `jeu` int NOT NULL,
  `categorie` int NOT NULL,
  KEY `ce_jeux_categoriser` (`jeu`),
  KEY `ce_categorie_categoriser` (`categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_categoriser`
--

INSERT INTO `tab_categoriser` (`jeu`, `categorie`) VALUES
(2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `tab_classement`
--

DROP TABLE IF EXISTS `tab_classement`;
CREATE TABLE IF NOT EXISTS `tab_classement` (
  `utilisateur` int NOT NULL,
  `tournoi` int NOT NULL,
  `place` int NOT NULL,
  `eliminer` tinyint(1) NOT NULL,
  KEY `ce_util_classement` (`utilisateur`),
  KEY `ce_tournoi_classement` (`tournoi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_evaluer`
--

DROP TABLE IF EXISTS `tab_evaluer`;
CREATE TABLE IF NOT EXISTS `tab_evaluer` (
  `utilisateur` int NOT NULL,
  `tournoi` int NOT NULL,
  `note` int NOT NULL,
  `commentaire` text NOT NULL,
  KEY `ce_util_evaluer` (`utilisateur`),
  KEY `ce_tournois_evaluer` (`tournoi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_inscrire`
--

DROP TABLE IF EXISTS `tab_inscrire`;
CREATE TABLE IF NOT EXISTS `tab_inscrire` (
  `utilisateur` int NOT NULL,
  `tournoi` int NOT NULL,
  KEY `ce_util_inscrire` (`utilisateur`),
  KEY `ce_tournois_inscrire` (`tournoi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_jeux`
--

DROP TABLE IF EXISTS `tab_jeux`;
CREATE TABLE IF NOT EXISTS `tab_jeux` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `url_image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pegi` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_jeux`
--

INSERT INTO `tab_jeux` (`id`, `nom`, `description`, `url_image`, `pegi`) VALUES
(2, 'Smash bros ultimate', 'Jeu smash bros ultimate', 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000012332/ac4d1fc9824876ce756406f0525d50c57ded4b2a666f6dfe40a6ac5c3563fad9', 18),
(3, 'My little pony', 'My little pony', 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000044000/c231f02fb967bdfeacb1e338245fa53254fe1072850641d131ed12c5ce1dd751', 3);

-- --------------------------------------------------------

--
-- Structure de la table `tab_plateformes`
--

DROP TABLE IF EXISTS `tab_plateformes`;
CREATE TABLE IF NOT EXISTS `tab_plateformes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_plateformes`
--

INSERT INTO `tab_plateformes` (`id`, `nom`) VALUES
(6, 'PC'),
(7, 'Xbox'),
(8, 'Playstation');

-- --------------------------------------------------------

--
-- Structure de la table `tab_platforme_jeu`
--

DROP TABLE IF EXISTS `tab_platforme_jeu`;
CREATE TABLE IF NOT EXISTS `tab_platforme_jeu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jeu` int NOT NULL,
  `plateforme` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ce_jeu_pljeu` (`jeu`),
  KEY `ce_platforme_pljeu` (`plateforme`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_platforme_jeu`
--

INSERT INTO `tab_platforme_jeu` (`id`, `jeu`, `plateforme`) VALUES
(1, 2, 6),
(2, 3, 6);

-- --------------------------------------------------------

--
-- Structure de la table `tab_questions`
--

DROP TABLE IF EXISTS `tab_questions`;
CREATE TABLE IF NOT EXISTS `tab_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_recompenses`
--

DROP TABLE IF EXISTS `tab_recompenses`;
CREATE TABLE IF NOT EXISTS `tab_recompenses` (
  `tournoi` int NOT NULL,
  `place` int NOT NULL,
  `libelle` varchar(1000) NOT NULL,
  KEY `ce_tournois_recompenses` (`tournoi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_reponses`
--

DROP TABLE IF EXISTS `tab_reponses`;
CREATE TABLE IF NOT EXISTS `tab_reponses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_result_quiz`
--

DROP TABLE IF EXISTS `tab_result_quiz`;
CREATE TABLE IF NOT EXISTS `tab_result_quiz` (
  `utilisateur` int NOT NULL,
  `nbBonnesReponses` int NOT NULL,
  KEY `ce_util_resultquiz` (`utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_tournois`
--

DROP TABLE IF EXISTS `tab_tournois`;
CREATE TABLE IF NOT EXISTS `tab_tournois` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jeu` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ce_jeux_tournois` (`jeu`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_tournois`
--

INSERT INTO `tab_tournois` (`id`, `jeu`) VALUES
(4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `tab_tournoi_session`
--

DROP TABLE IF EXISTS `tab_tournoi_session`;
CREATE TABLE IF NOT EXISTS `tab_tournoi_session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tournoi` int NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `nbplaces` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ce_tournoi_toursess` (`tournoi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_utilisateurs`
--

DROP TABLE IF EXISTS `tab_utilisateurs`;
CREATE TABLE IF NOT EXISTS `tab_utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mail` varchar(100) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `age` int NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_utilisateurs`
--

INSERT INTO `tab_utilisateurs` (`id`, `mail`, `pseudo`, `age`, `mdp`, `admin`) VALUES
(24, 'admin@arthuraugis.fr', 'RainbowYoshi', 19, '$2y$10$ZkJnqqJuharZ1P6CNUXxgO6w8Nd.jggdh4CxdV4Bm65DwEASPCpwS', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tab_voter`
--

DROP TABLE IF EXISTS `tab_voter`;
CREATE TABLE IF NOT EXISTS `tab_voter` (
  `utilisateur` int NOT NULL,
  `jeu` int NOT NULL,
  `dateEtHeure` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `ce_util_voter` (`utilisateur`),
  KEY `ce_jeux_voter` (`jeu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tab_attribuer`
--
ALTER TABLE `tab_attribuer`
  ADD CONSTRAINT `ce_questions_attribuer` FOREIGN KEY (`question`) REFERENCES `tab_questions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ce_reponses_attribuer` FOREIGN KEY (`reponse`) REFERENCES `tab_reponses` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_categoriser`
--
ALTER TABLE `tab_categoriser`
  ADD CONSTRAINT `ce_categorie_categoriser` FOREIGN KEY (`categorie`) REFERENCES `tab_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ce_jeux_categoriser` FOREIGN KEY (`jeu`) REFERENCES `tab_jeux` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_classement`
--
ALTER TABLE `tab_classement`
  ADD CONSTRAINT `ce_tournoi_classement` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournoi_session` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ce_util_classement` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_evaluer`
--
ALTER TABLE `tab_evaluer`
  ADD CONSTRAINT `ce_tournois_evaluer` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournois` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ce_util_evaluer` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_inscrire`
--
ALTER TABLE `tab_inscrire`
  ADD CONSTRAINT `ce_tournois_inscrire` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournoi_session` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ce_util_inscrire` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_platforme_jeu`
--
ALTER TABLE `tab_platforme_jeu`
  ADD CONSTRAINT `ce_jeu_pljeu` FOREIGN KEY (`jeu`) REFERENCES `tab_jeux` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ce_platforme_pljeu` FOREIGN KEY (`plateforme`) REFERENCES `tab_plateformes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_recompenses`
--
ALTER TABLE `tab_recompenses`
  ADD CONSTRAINT `ce_tournois_recompenses` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournoi_session` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_result_quiz`
--
ALTER TABLE `tab_result_quiz`
  ADD CONSTRAINT `ce_util_resultquiz` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_tournois`
--
ALTER TABLE `tab_tournois`
  ADD CONSTRAINT `ce_jeux_tournois` FOREIGN KEY (`jeu`) REFERENCES `tab_platforme_jeu` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_tournoi_session`
--
ALTER TABLE `tab_tournoi_session`
  ADD CONSTRAINT `ce_tournoi_toursess` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournois` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tab_voter`
--
ALTER TABLE `tab_voter`
  ADD CONSTRAINT `ce_jeux_voter` FOREIGN KEY (`jeu`) REFERENCES `tab_platforme_jeu` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ce_util_voter` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
