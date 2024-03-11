-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 09 mars 2024 à 12:05
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

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
DROP PROCEDURE IF EXISTS `proc_getAdminList`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAdminList` ()   BEGIN

SELECT tab_utilisateurs.pseudo FROM tab_utilisateurs WHERE tab_utilisateurs.admin = 1;

END$$

DROP PROCEDURE IF EXISTS `proc_getAllCategoriesGames`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAllCategoriesGames` ()   BEGIN

SELECT tab_categoriser.id, tab_categories.nom_categorie, tab_jeux.nom
FROM tab_categoriser
INNER JOIN tab_categories ON tab_categories.id = tab_categoriser.categorie
INNER JOIN tab_jeux ON tab_categoriser.jeu = tab_jeux.id
ORDER BY tab_jeux.nom;

END$$

DROP PROCEDURE IF EXISTS `proc_getAllGamesWithoutTournament`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAllGamesWithoutTournament` ()   BEGIN

SELECT tab_platforme_jeu.id AS "id_jeu", 
tab_jeux.nom AS "nom_jeu",
tab_plateformes.nom AS "plateforme_jeu"
FROM tab_platforme_jeu
LEFT JOIN tab_tournois ON tab_platforme_jeu.id = tab_tournois.jeu
LEFT JOIN tab_jeux ON tab_platforme_jeu.jeu = tab_jeux.id
LEFT JOIN tab_categoriser ON tab_categoriser.jeu = tab_jeux.id
LEFT JOIN tab_categories ON tab_categoriser.categorie = tab_categories.id
LEFT JOIN tab_plateformes ON tab_platforme_jeu.plateforme = tab_plateformes.id
WHERE tab_tournois.jeu IS NULL;

END$$

DROP PROCEDURE IF EXISTS `proc_getAllGamesWithTournament`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAllGamesWithTournament` ()   BEGIN

SELECT tab_tournois.id AS 'id_tournoi', tab_jeux.nom AS 'jeu_tournoi', tab_plateformes.nom AS 'plateforme_tournoi'
FROM tab_platforme_jeu
INNER JOIN tab_tournois ON tab_platforme_jeu.id = tab_tournois.jeu
INNER JOIN tab_jeux ON tab_platforme_jeu.jeu = tab_jeux.id
INNER JOIN tab_plateformes ON tab_plateformes.id = tab_platforme_jeu.plateforme;

END$$

DROP PROCEDURE IF EXISTS `proc_getAllPlatformsGames`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAllPlatformsGames` ()   BEGIN

SELECT tab_platforme_jeu.id, tab_plateformes.nom AS 'plateforme', tab_jeux.nom AS 'jeu'
FROM tab_platforme_jeu
INNER JOIN tab_plateformes ON tab_platforme_jeu.plateforme = tab_plateformes.id
INNER JOIN tab_jeux ON tab_platforme_jeu.jeu = tab_jeux.id
ORDER BY tab_jeux.nom;

END$$

DROP PROCEDURE IF EXISTS `proc_getAllSessions`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getAllSessions` ()   BEGIN

SELECT tab_jeux.nom AS 'nom_jeu', tab_tournoi_session.date, tab_tournoi_session.heure_debut, tab_tournoi_session.id AS 'id_session', tab_plateformes.nom AS 'nom_plateforme'
FROM tab_jeux
LEFT JOIN tab_platforme_jeu ON tab_platforme_jeu.jeu = tab_jeux.id
LEFT JOIN tab_plateformes ON tab_plateformes.id = tab_platforme_jeu.plateforme
LEFT JOIN tab_tournois ON tab_tournois.jeu = tab_platforme_jeu.id
INNER JOIN tab_tournoi_session ON tab_tournoi_session.tournoi = tab_tournois.id
ORDER BY tab_tournoi_session.date, tab_tournoi_session.heure_debut ASC;

END$$

DROP PROCEDURE IF EXISTS `proc_getCategories`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getCategories` ()   BEGIN

SELECT tab_categories.nom_categorie, tab_categories.id FROM tab_categories;

END$$

DROP PROCEDURE IF EXISTS `proc_getCommentaires`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getCommentaires` ()   BEGIN

SELECT tab_utilisateurs.pseudo AS 'pseudo_utilisateur', 
tab_evaluer.note AS 'note_tournois', 
tab_evaluer.commentaire AS 'commentaire_tournois', 
tab_tournoi_session.date AS 'date_tournois', 
tab_tournoi_session.heure_debut  AS 'heure_debut_tournois', 
tab_plateformes.nom AS 'nom_plateforme_tournois',
tab_jeux.nom AS 'nom_jeu', tab_evaluer.id
FROM tab_evaluer
INNER JOIN tab_utilisateurs ON tab_utilisateurs.id = tab_evaluer.utilisateur
INNER JOIN tab_tournoi_session ON tab_evaluer.tournoi = tab_tournoi_session.id
INNER JOIN tab_tournois ON tab_tournoi_session.tournoi = tab_tournois.id
INNER JOIN tab_platforme_jeu ON tab_platforme_jeu.id = tab_tournois.jeu
INNER JOIN tab_plateformes ON tab_plateformes.id = tab_platforme_jeu.plateforme
INNER JOIN tab_jeux ON tab_jeux.id = tab_platforme_jeu.jeu;

END$$

DROP PROCEDURE IF EXISTS `proc_getDatesVote`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getDatesVote` ()   BEGIN

SELECT tab_dates_importantes.debut_votes, tab_dates_importantes.fin_votes
FROM tab_dates_importantes
LIMIT 1;

END$$

DROP PROCEDURE IF EXISTS `proc_getDefaultPlatform`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getDefaultPlatform` ()   BEGIN

SELECT tab_plateformes.nom FROM tab_plateformes LIMIT 1;

END$$

DROP PROCEDURE IF EXISTS `proc_getInscriptionsUtilisateur`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getInscriptionsUtilisateur` (IN `_pseudo` VARCHAR(50))   BEGIN

SELECT tab_inscrire.tournoi
FROM tab_inscrire
INNER JOIN tab_utilisateurs ON tab_inscrire.utilisateur = tab_utilisateurs.id
WHERE tab_utilisateurs.pseudo = _pseudo;

END$$

DROP PROCEDURE IF EXISTS `proc_getNonAdminList`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getNonAdminList` ()   BEGIN

SELECT tab_utilisateurs.pseudo FROM tab_utilisateurs WHERE tab_utilisateurs.admin = 0;

END$$

DROP PROCEDURE IF EXISTS `proc_getPlateformes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getPlateformes` ()   BEGIN

SELECT tab_plateformes.id, tab_plateformes.nom 
FROM tab_plateformes;

END$$

DROP PROCEDURE IF EXISTS `proc_getPlatform`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getPlatform` (IN `_nom` VARCHAR(50))   BEGIN

SELECT tab_plateformes.nom FROM tab_plateformes WHERE tab_plateformes.nom = _nom LIMIT 1;

END$$

DROP PROCEDURE IF EXISTS `proc_getquiz`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getquiz` ()   BEGIN

SELECT tab_questions.libelle AS "Questions", tab_reponses.libelle AS "Reponses", tab_attribuer.bonnereponse AS "BonneReponse",
tab_attribuer.id
FROM tab_attribuer
INNER JOIN tab_questions ON tab_attribuer.question = tab_questions.id
INNER JOIN tab_reponses ON tab_attribuer.reponse = tab_reponses.id;

END$$

DROP PROCEDURE IF EXISTS `proc_getRecompenses`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getRecompenses` (IN `_session` INT)   BEGIN

SELECT tab_recompenses.place, tab_recompenses.libelle
FROM tab_recompenses
WHERE tab_recompenses.tournoi = _session;

END$$

DROP PROCEDURE IF EXISTS `proc_getRecompensesList`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getRecompensesList` ()   BEGIN

SELECT tab_recompenses.id, tab_plateformes.nom AS 'plateforme', tab_jeux.nom AS 'jeu', tab_recompenses.place, tab_recompenses.libelle
FROM tab_recompenses
INNER JOIN tab_tournoi_session ON tab_tournoi_session.id = tab_recompenses.tournoi
INNER JOIN tab_tournois ON tab_tournois.id = tab_tournoi_session.tournoi
INNER JOIN tab_platforme_jeu ON tab_tournois.jeu = tab_platforme_jeu.id
INNER JOIN tab_jeux ON tab_platforme_jeu.jeu = tab_jeux.id
INNER JOIN tab_plateformes ON tab_plateformes.id = tab_platforme_jeu.plateforme;

END$$

DROP PROCEDURE IF EXISTS `proc_getSessionsParticipe`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getSessionsParticipe` (IN `_pseudo` VARCHAR(50))   BEGIN

SELECT 
	tab_tournoi_session.id AS 'id_session',
    tab_tournoi_session.date AS 'date_tournois', 
    tab_tournoi_session.heure_debut AS 'heure_debut_tournois', 
    tab_plateformes.nom AS 'nom_plateforme_tournois',
    tab_jeux.nom AS 'nom_jeu'
FROM 
    tab_tournoi_session
INNER JOIN 
    tab_inscrire ON tab_inscrire.tournoi = tab_tournoi_session.id
INNER JOIN 
    tab_utilisateurs ON tab_utilisateurs.id = tab_inscrire.utilisateur
INNER JOIN 
    tab_tournois ON tab_tournoi_session.tournoi = tab_tournois.id
INNER JOIN 
    tab_platforme_jeu ON tab_platforme_jeu.id = tab_tournois.jeu
INNER JOIN 
    tab_plateformes ON tab_plateformes.id = tab_platforme_jeu.plateforme
INNER JOIN 
    tab_jeux ON tab_jeux.id = tab_platforme_jeu.jeu
WHERE 
    tab_utilisateurs.pseudo = _pseudo
    AND (tab_tournoi_session.date < CURDATE()
         OR (tab_tournoi_session.date = CURDATE() AND tab_tournoi_session.heure_debut < CURTIME()));

END$$

DROP PROCEDURE IF EXISTS `proc_getSessionsTournoi`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getSessionsTournoi` (IN `_jeu` VARCHAR(100), IN `_plateforme` VARCHAR(50))   BEGIN

SELECT tab_jeux.nom, tab_jeux.description, tab_jeux.url_image, tab_jeux.pegi, tab_categories.nom_categorie, tab_tournoi_session.date, tab_tournoi_session.heure_debut, tab_tournoi_session.nbplaces, COUNT(tab_inscrire.utilisateur) AS 'nb_participants', tab_tournoi_session.id AS 'id_session'
FROM tab_jeux
LEFT JOIN tab_categoriser ON tab_jeux.id = tab_categoriser.jeu
LEFT JOIN tab_categories ON tab_categoriser.categorie = tab_categories.id
LEFT JOIN tab_platforme_jeu ON tab_platforme_jeu.jeu = tab_jeux.id
LEFT JOIN tab_plateformes ON tab_plateformes.id = tab_platforme_jeu.plateforme
LEFT JOIN tab_tournois ON tab_tournois.jeu = tab_platforme_jeu.id
LEFT JOIN tab_tournoi_session ON tab_tournoi_session.tournoi = tab_tournois.id
LEFT JOIN tab_inscrire ON tab_inscrire.tournoi = tab_tournoi_session.id
WHERE tab_jeux.nom = _jeu
GROUP BY tab_categories.nom_categorie, tab_tournoi_session.date, tab_tournoi_session.heure_debut
ORDER BY tab_tournoi_session.date, tab_tournoi_session.heure_debut ASC;

END$$

DROP PROCEDURE IF EXISTS `proc_getTop10Quiz`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getTop10Quiz` ()   BEGIN

SELECT tab_utilisateurs.pseudo, tab_result_quiz.nbBonnesReponses
FROM tab_result_quiz
INNER JOIN tab_utilisateurs ON tab_utilisateurs.id = tab_result_quiz.utilisateur
ORDER BY tab_result_quiz.nbBonnesReponses DESC
LIMIT 10;

END$$

DROP PROCEDURE IF EXISTS `proc_getVotesUtilisateur`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_getVotesUtilisateur` (IN `_login` VARCHAR(50))   BEGIN

SELECT tab_plateformes.nom
FROM tab_voter
INNER JOIN tab_platforme_jeu ON tab_platforme_jeu.id = tab_voter.jeu
INNER JOIN tab_plateformes ON tab_plateformes.id = tab_platforme_jeu.plateforme
INNER JOIN tab_utilisateurs ON tab_utilisateurs.id = tab_voter.utilisateur
WHERE tab_utilisateurs.pseudo = _login;

END$$

DROP PROCEDURE IF EXISTS `proc_jeuList`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_jeuList` ()   BEGIN

SELECT tab_jeux.id, tab_jeux.nom FROM tab_jeux;

END$$

DROP PROCEDURE IF EXISTS `proc_jeux_avec_tournois`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_jeux_avec_tournois` (IN `_plateforme` VARCHAR(50))   BEGIN

SELECT tab_platforme_jeu.id, tab_jeux.nom,tab_jeux.url_image
FROM tab_platforme_jeu
INNER JOIN tab_tournois ON tab_platforme_jeu.id = tab_tournois.jeu
INNER JOIN tab_jeux ON tab_platforme_jeu.jeu = tab_jeux.id
INNER JOIN tab_plateformes ON tab_plateformes.id = tab_platforme_jeu.plateforme
WHERE tab_plateformes.nom = _plateforme;

END$$

DROP PROCEDURE IF EXISTS `proc_jeux_sans_tournois`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_jeux_sans_tournois` (IN `_plateforme` VARCHAR(50))   BEGIN

SELECT tab_platforme_jeu.id AS "id_jeu", 
tab_jeux.nom AS "nom_jeu",
tab_jeux.description AS "description_jeu", 
tab_jeux.url_image AS "image_jeu", 
tab_jeux.pegi AS "pegi_jeu", 
tab_categories.nom_categorie AS "categories_jeu", 
tab_plateformes.nom AS "plateforme_jeu"
FROM tab_platforme_jeu
LEFT JOIN tab_tournois ON tab_platforme_jeu.id = tab_tournois.jeu
LEFT JOIN tab_jeux ON tab_platforme_jeu.jeu = tab_jeux.id
LEFT JOIN tab_categoriser ON tab_categoriser.jeu = tab_jeux.id
LEFT JOIN tab_categories ON tab_categoriser.categorie = tab_categories.id
LEFT JOIN tab_plateformes ON tab_platforme_jeu.plateforme = tab_plateformes.id
WHERE tab_tournois.jeu IS NULL
AND tab_plateformes.nom = _plateforme;

END$$

DROP PROCEDURE IF EXISTS `proc_login`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_login` (IN `mail` VARCHAR(100))   BEGIN
    SELECT tab_utilisateurs.mdp, tab_utilisateurs.pseudo, tab_utilisateurs.age, tab_utilisateurs.admin
    FROM tab_utilisateurs
    WHERE tab_utilisateurs.mail = mail;
END$$

DROP PROCEDURE IF EXISTS `proc_pourcent_vote`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_pourcent_vote` (IN `_plateforme` VARCHAR(50))   BEGIN
    DECLARE total_votes INT;
    DECLARE platform_id INT;

    SELECT id INTO platform_id FROM tab_plateformes WHERE nom = _plateforme;

    SELECT COUNT(*) INTO total_votes FROM tab_voter
    INNER JOIN tab_platforme_jeu ON tab_voter.jeu = tab_platforme_jeu.id
    WHERE tab_platforme_jeu.plateforme = platform_id;

    SELECT tab_jeux.nom,
           ROUND(COUNT(utilisateur) * 100.0 / total_votes, 0) AS pourcentage
    FROM tab_platforme_jeu
    LEFT JOIN tab_voter ON tab_voter.jeu = tab_platforme_jeu.id
    LEFT JOIN tab_jeux ON tab_jeux.id = tab_platforme_jeu.jeu
    WHERE tab_platforme_jeu.plateforme = platform_id
    GROUP BY tab_jeux.nom;

END$$

DROP PROCEDURE IF EXISTS `proc_questionsList`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_questionsList` ()   BEGIN

SELECT tab_questions.libelle, tab_questions.id FROM tab_questions;

END$$

DROP PROCEDURE IF EXISTS `proc_reponsesList`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_reponsesList` ()   BEGIN

SELECT tab_reponses.libelle, tab_reponses.id FROM tab_reponses;

END$$

--
-- Fonctions
--
DROP FUNCTION IF EXISTS `func_ajoutAdmin`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajoutAdmin` (`_pseudo` VARCHAR(50)) RETURNS INT  BEGIN

UPDATE tab_utilisateurs SET admin = 1 WHERE pseudo = _pseudo;
RETURN 1;

END$$

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

DROP FUNCTION IF EXISTS `func_ajout_attribuer`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_attribuer` (`_question` INT, `_reponse` INT, `_bonnereponse` TINYINT(1)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;
    
INSERT INTO tab_attribuer(tab_attribuer.question, tab_attribuer.reponse, tab_attribuer.bonnereponse) VALUES (_question, _reponse, _bonnereponse);

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

DROP FUNCTION IF EXISTS `func_ajout_evaluer`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_evaluer` (`_pseudo` VARCHAR(50), `_tournoi` INT, `_note` INT, `_commentaire` TEXT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;
    
SELECT COUNT(tab_utilisateurs.pseudo) INTO EXISTE
FROM tab_evaluer
INNER JOIN tab_utilisateurs ON tab_utilisateurs.id = tab_evaluer.utilisateur
WHERE tab_evaluer.utilisateur = _pseudo
AND tab_evaluer.tournoi = _tournoi;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT tab_evaluer(tab_evaluer.utilisateur, tab_evaluer.tournoi, tab_evaluer.note, tab_evaluer.commentaire) VALUES ((SELECT tab_utilisateurs.id FROM tab_utilisateurs WHERE tab_utilisateurs.pseudo = _pseudo), _tournoi, _note, _commentaire);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_inscription`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_inscription` (`_pseudo` VARCHAR(50), `tournoi_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_inscrire.utilisateur) INTO EXISTE
FROM tab_inscrire
INNER JOIN tab_utilisateurs ON tab_inscrire.utilisateur = tab_utilisateurs.id
WHERE tab_utilisateurs.pseudo = _pseudo AND tab_inscrire.tournoi = tournoi_id;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_inscrire VALUES ((SELECT tab_utilisateurs.id FROM tab_utilisateurs WHERE tab_utilisateurs.pseudo = _pseudo), tournoi_id);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_jeux`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_jeux` (`_nom` VARCHAR(100), `_description` VARCHAR(1000), `_url_image` VARCHAR(200), `_pegi` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;
    
SELECT COUNT(tab_jeux.id) INTO EXISTE
FROM tab_jeux
WHERE tab_jeux.nom = _nom;

IF EXISTE <> 0 THEN
	SET RETOUR = -1;
ELSE
	INSERT INTO tab_jeux(nom, description, url_image, pegi) VALUES (_nom, _description, _url_image, _pegi);
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

INSERT INTO tab_recompenses(tab_recompenses.tournoi, tab_recompenses.place, tab_recompenses.libelle) VALUES (_tournoi, _place, _libelle);

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

DROP FUNCTION IF EXISTS `func_ajout_result_quiz`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_result_quiz` (`_pseudo` VARCHAR(50), `_nbBonnesReponses` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 1;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;
    
INSERT INTO tab_result_quiz VALUES ((SELECT tab_utilisateurs.id FROM tab_utilisateurs WHERE tab_utilisateurs.pseudo = _pseudo), _nbBonnesReponses);

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_ajout_session_tournoi`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_ajout_session_tournoi` (`_tournoi` INT, `_date` DATE, `_heure_debut` TIME, `_nbplaces` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

INSERT INTO tab_tournoi_session(tournoi, date, heure_debut, nbplaces) VALUES (_tournoi, _date, _heure_debut, _nbplaces);


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
	INSERT INTO tab_categoriser(tab_categoriser.jeu, tab_categoriser.categorie) VALUES (jeu_id, categorie_id);
    SET RETOUR = 1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_jeu_suppr_categorie`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_jeu_suppr_categorie` (`_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_categoriser.id) INTO EXISTE
FROM tab_categoriser
WHERE tab_categoriser.id = _id;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_categoriser` WHERE tab_categoriser.id = _id;
    SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_modifDatesVote`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_modifDatesVote` (`date_debut` DATETIME, `date_fin` DATETIME) RETURNS INT  BEGIN

UPDATE `tab_dates_importantes` SET `debut_votes`=date_debut,`fin_votes`=date_fin;
RETURN 1;

END$$

DROP FUNCTION IF EXISTS `func_supprAdmin`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_supprAdmin` (`_pseudo` VARCHAR(50)) RETURNS INT  BEGIN

UPDATE tab_utilisateurs SET admin = 0 WHERE pseudo = _pseudo;
RETURN 1;

END$$

DROP FUNCTION IF EXISTS `func_suppr_attribuer`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_attribuer` (`_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_attribuer.id) INTO EXISTE
FROM tab_attribuer
WHERE tab_attribuer.id = _id;

IF EXISTE <> 0 THEN
	DELETE FROM tab_attribuer WHERE tab_attribuer.id = _id;
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

DROP FUNCTION IF EXISTS `func_suppr_evaluer`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_evaluer` (`_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_evaluer.id) INTO EXISTE
FROM tab_evaluer
WHERE tab_evaluer.id = _id;

IF EXISTE <> 0 THEN
	DELETE FROM tab_evaluer WHERE tab_evaluer.id = _id;
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

DROP FUNCTION IF EXISTS `func_suppr_jeux`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_jeux` (`_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;
    
SELECT COUNT(tab_jeux.id) INTO EXISTE
FROM tab_jeux
WHERE tab_jeux.id = _id;

IF EXISTE <> 0 THEN
	DELETE FROM tab_jeux WHERE tab_jeux.id = _id;
    SET RETOUR = 1;
ELSE
	SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_jeu_plateforme`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_jeu_plateforme` (`_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_platforme_jeu.id) INTO EXISTE
FROM tab_platforme_jeu
WHERE tab_platforme_jeu.id = _id;

IF EXISTE <> 0 THEN
	DELETE FROM tab_platforme_jeu WHERE tab_platforme_jeu.id = _id;
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
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_recompense` (`_id` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = 1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = 1452;
    
SELECT COUNT(tab_recompenses.id) INTO EXISTE
FROM tab_recompenses
WHERE tab_recompenses.id = _id;

IF EXISTE <> 0 THEN
	DELETE FROM tab_recompenses WHERE tab_recompenses.id = _id;
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
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_tournoi` (`id_tournoi` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_tournois.id) INTO EXISTE
FROM tab_tournois
WHERE tab_tournois.id = id_tournoi;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_tournois` WHERE tab_tournois.id = id_tournoi;
    SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_suppr_utilisateur`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_suppr_utilisateur` (`_pseudo` VARCHAR(50)) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE EXISTE INT DEFAULT 0;

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_utilisateurs.id) INTO EXISTE
FROM tab_utilisateurs
WHERE tab_utilisateurs.pseudo = _pseudo;

IF EXISTE <> 0 THEN
	DELETE FROM `tab_utilisateurs` WHERE tab_utilisateurs.pseudo = _pseudo;
	SET RETOUR = 1;
ELSE
    SET RETOUR = -1;
END IF;

RETURN RETOUR;

END$$

DROP FUNCTION IF EXISTS `func_voter`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `func_voter` (`_utilisateur` VARCHAR(50), `_jeuChoisi` INT) RETURNS INT  BEGIN

DECLARE RETOUR INT DEFAULT 0;
DECLARE nbJeu INT;
DECLARE idUtilisateur VARCHAR(50);

DECLARE CONTINUE HANDLER FOR 1062
	SET RETOUR  = -1062;

DECLARE CONTINUE HANDLER FOR 1452
	SET RETOUR  = -1452;

SELECT COUNT(tab_voter.jeu) INTO nbJeu
FROM tab_voter
INNER JOIN tab_platforme_jeu ON tab_voter.jeu = tab_platforme_jeu.id
INNER JOIN tab_utilisateurs ON tab_utilisateurs.id = tab_voter.utilisateur
WHERE tab_platforme_jeu.plateforme = 
(SELECT tab_platforme_jeu.plateforme
FROM tab_platforme_jeu 
WHERE id = _jeuChoisi)
AND tab_utilisateurs.pseudo = _utilisateur;

IF nbJeu <> 0 THEN
	SET RETOUR = -1;
ELSE
	
    SELECT tab_utilisateurs.id INTO idUtilisateur
    FROM tab_utilisateurs
    WHERE tab_utilisateurs.pseudo = _utilisateur;
    
	INSERT INTO tab_voter (utilisateur, jeu)
    VALUES (idUtilisateur, _jeuChoisi);
    
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
  `id` int NOT NULL AUTO_INCREMENT,
  `question` int NOT NULL,
  `reponse` int NOT NULL,
  `bonnereponse` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ce_questions_attribuer` (`question`),
  KEY `ce_reponses_attribuer` (`reponse`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_attribuer`
--

INSERT INTO `tab_attribuer` (`id`, `question`, `reponse`, `bonnereponse`) VALUES
(1, 1, 1, 1),
(2, 1, 3, 0),
(3, 1, 4, 0),
(4, 2, 5, 0),
(5, 2, 7, 0),
(6, 2, 6, 0),
(7, 2, 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `tab_categories`
--

DROP TABLE IF EXISTS `tab_categories`;
CREATE TABLE IF NOT EXISTS `tab_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `id` int NOT NULL AUTO_INCREMENT,
  `jeu` int NOT NULL,
  `categorie` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ce_jeux_categoriser` (`jeu`),
  KEY `ce_categorie_categoriser` (`categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_categoriser`
--

INSERT INTO `tab_categoriser` (`id`, `jeu`, `categorie`) VALUES
(1, 2, 3),
(2, 3, 4),
(4, 5, 4);

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
-- Structure de la table `tab_dates_importantes`
--

DROP TABLE IF EXISTS `tab_dates_importantes`;
CREATE TABLE IF NOT EXISTS `tab_dates_importantes` (
  `debut_votes` datetime NOT NULL,
  `fin_votes` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_dates_importantes`
--

INSERT INTO `tab_dates_importantes` (`debut_votes`, `fin_votes`) VALUES
('2024-03-06 00:00:00', '2024-03-31 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `tab_evaluer`
--

DROP TABLE IF EXISTS `tab_evaluer`;
CREATE TABLE IF NOT EXISTS `tab_evaluer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur` int NOT NULL,
  `tournoi` int NOT NULL,
  `note` int NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ce_util_evaluer` (`utilisateur`),
  KEY `ce_tournois_evaluer` (`tournoi`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_evaluer`
--

INSERT INTO `tab_evaluer` (`id`, `utilisateur`, `tournoi`, `note`, `commentaire`) VALUES
(18, 26, 6, 5, 'incroyable tournoi');

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

--
-- Déchargement des données de la table `tab_inscrire`
--

INSERT INTO `tab_inscrire` (`utilisateur`, `tournoi`) VALUES
(26, 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_jeux`
--

INSERT INTO `tab_jeux` (`id`, `nom`, `description`, `url_image`, `pegi`) VALUES
(2, 'Smash bros ultimate', 'Jeu smash bros ultimate', 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000012332/ac4d1fc9824876ce756406f0525d50c57ded4b2a666f6dfe40a6ac5c3563fad9', 18),
(3, 'My little pony', 'My little pony', 'https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/ncom/software/switch/70010000044000/c231f02fb967bdfeacb1e338245fa53254fe1072850641d131ed12c5ce1dd751', 3),
(4, 'Sims', 'Sims', 'https://cdn-uploads.gameblog.fr/img/news/452020_64e74c23d1566.jpg', 18),
(5, 'Cyberpunk', 'Cyberpunk', 'https://www.cyberpunk.net/build/images/pre-order/buy-b/keyart-ue-fr@2x-cd66fd0d.jpg', 18),
(6, 'Destiny 2', 'Destiny 2', 'https://cdn1.epicgames.com/offer/428115def4ca4deea9d69c99c5a5a99e/EGS_Destiny2_Bungie_S1_2560x1440-d91ec3c799ec514732341a13ba0c030c?h=270&quality=medium&resize=1&w=480', 18);

-- --------------------------------------------------------

--
-- Structure de la table `tab_plateformes`
--

DROP TABLE IF EXISTS `tab_plateformes`;
CREATE TABLE IF NOT EXISTS `tab_plateformes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_platforme_jeu`
--

INSERT INTO `tab_platforme_jeu` (`id`, `jeu`, `plateforme`) VALUES
(1, 2, 6),
(2, 3, 6),
(3, 4, 6),
(4, 5, 6),
(5, 6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `tab_questions`
--

DROP TABLE IF EXISTS `tab_questions`;
CREATE TABLE IF NOT EXISTS `tab_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_questions`
--

INSERT INTO `tab_questions` (`id`, `libelle`) VALUES
(1, 'Qu\'est-ce que la vie ?'),
(2, 'Comment craft une pioche en bois dans minecraft ?');

-- --------------------------------------------------------

--
-- Structure de la table `tab_recompenses`
--

DROP TABLE IF EXISTS `tab_recompenses`;
CREATE TABLE IF NOT EXISTS `tab_recompenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tournoi` int NOT NULL,
  `place` int NOT NULL,
  `libelle` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ce_tournois_recompenses` (`tournoi`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tab_reponses`
--

DROP TABLE IF EXISTS `tab_reponses`;
CREATE TABLE IF NOT EXISTS `tab_reponses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_reponses`
--

INSERT INTO `tab_reponses` (`id`, `libelle`) VALUES
(1, '42'),
(3, 'le PHP'),
(4, 'Yoshi'),
(5, '2 diamants et un baton'),
(6, '3 buches de bois et 2 planches'),
(7, '3 buches de bois et 2 batons'),
(8, '3 planches de bois et 2 batons');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_tournois`
--

INSERT INTO `tab_tournois` (`id`, `jeu`) VALUES
(10, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_tournoi_session`
--

INSERT INTO `tab_tournoi_session` (`id`, `tournoi`, `date`, `heure_debut`, `nbplaces`) VALUES
(6, 10, '2024-03-06', '18:00:00', 12);

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tab_utilisateurs`
--

INSERT INTO `tab_utilisateurs` (`id`, `mail`, `pseudo`, `age`, `mdp`, `admin`) VALUES
(26, 'admin@arthuraugis.fr', 'RainbowYoshi', 19, '$2y$10$hyJqkR.ENVzFUaZAZmQOl.ahDhJEmR79mwU1YIeTMn4.uA..m7B.S', 1),
(27, 'arthur41.augis@gmail.com', 'Arthur', 19, '$2y$10$KCPiz4HRTvWyhRilDoKYp.sB0L1/j6uYMS2FerA9HkWI5n8JEzc6y', 0);

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
  ADD CONSTRAINT `ce_questions_attribuer` FOREIGN KEY (`question`) REFERENCES `tab_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ce_reponses_attribuer` FOREIGN KEY (`reponse`) REFERENCES `tab_reponses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_categoriser`
--
ALTER TABLE `tab_categoriser`
  ADD CONSTRAINT `ce_categorie_categoriser` FOREIGN KEY (`categorie`) REFERENCES `tab_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ce_jeux_categoriser` FOREIGN KEY (`jeu`) REFERENCES `tab_jeux` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_classement`
--
ALTER TABLE `tab_classement`
  ADD CONSTRAINT `ce_tournoi_classement` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournoi_session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ce_util_classement` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_evaluer`
--
ALTER TABLE `tab_evaluer`
  ADD CONSTRAINT `ce_tournois_evaluer` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournoi_session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ce_util_evaluer` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_inscrire`
--
ALTER TABLE `tab_inscrire`
  ADD CONSTRAINT `ce_tournois_inscrire` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournoi_session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ce_util_inscrire` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_platforme_jeu`
--
ALTER TABLE `tab_platforme_jeu`
  ADD CONSTRAINT `ce_jeu_pljeu` FOREIGN KEY (`jeu`) REFERENCES `tab_jeux` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ce_platforme_pljeu` FOREIGN KEY (`plateforme`) REFERENCES `tab_plateformes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_recompenses`
--
ALTER TABLE `tab_recompenses`
  ADD CONSTRAINT `ce_tournois_recompenses` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournoi_session` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_result_quiz`
--
ALTER TABLE `tab_result_quiz`
  ADD CONSTRAINT `ce_util_resultquiz` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_tournois`
--
ALTER TABLE `tab_tournois`
  ADD CONSTRAINT `ce_jeux_tournois` FOREIGN KEY (`jeu`) REFERENCES `tab_platforme_jeu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_tournoi_session`
--
ALTER TABLE `tab_tournoi_session`
  ADD CONSTRAINT `ce_tournoi_toursess` FOREIGN KEY (`tournoi`) REFERENCES `tab_tournois` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tab_voter`
--
ALTER TABLE `tab_voter`
  ADD CONSTRAINT `ce_jeux_voter` FOREIGN KEY (`jeu`) REFERENCES `tab_platforme_jeu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ce_util_voter` FOREIGN KEY (`utilisateur`) REFERENCES `tab_utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
