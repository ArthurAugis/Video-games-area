<?php

namespace App\Models;

use CodeIgniter\Model;

class m_tournois extends Model
{
    /**
     * @param $plateforme
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode utilisant la procédure stockée proc_jeux_avec_tournois (permet de récupérer tout
     * les jeux ayant au moins un tournoi)
     */
    function getTournois($plateforme)
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution des requêtes pour définir les paramètres de la procédure stockée
            $stmt1 = "SET @p0 = ?";
            $db->query($stmt1, [$plateforme]);

            // Exécution de la procédure stockée pour récupérer les tournois pour une plateforme spécifiée
            $query = "CALL `proc_jeux_avec_tournois`(@p0)";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                // Récupération des données du résultat
                $resultArray = $result->getResult();

                // Vérification si des tournois ont été récupérés
                if (count($resultArray) > 0) {
                    return $resultArray;
                }
            }
        } catch (mysqli_sql_exception $e) {
            // Gestion des exceptions
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

    /**
     * @param $jeu
     * @param $plateforme
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer toutes les sessions de tournoi à partir d'un nom de jeu et le nom d'une plateforme
     */
    function getSessionsTournoi($jeu, $plateforme)
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution des requêtes pour définir les paramètres de la procédure stockée
            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";
            $db->query($stmt1, [$jeu]);
            $db->query($stmt2, [$plateforme]);

            // Exécution de la procédure stockée pour récupérer les sessions de tournoi pour un jeu et une
            // plateforme spécifiés
            $query = "CALL `proc_getSessionsTournoi`(@p0, @p1)";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                // Récupération des données du résultat
                $resultArray = $result->getResult();

                // Vérification si des sessions ont été récupérées
                if (count($resultArray) > 0) {
                    return $resultArray;
                }
            }
        } catch (mysqli_sql_exception $e) {
            // Gestion des exceptions
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

    /**
     * @param $utilisateur
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode pour récupérer tout les tournois où l'utilisateur (paramètre = pseudo) est inscrit
     */
    function getInscriptions($utilisateur)
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution des requêtes pour définir les paramètres de la procédure stockée
            $stmt1 = "SET @p0 = ?";
            $db->query($stmt1, [$utilisateur]);

            // Exécution de la procédure stockée pour récupérer les inscriptions d'un utilisateur
            $query = "CALL `proc_getInscriptionsUtilisateur`(@p0)";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                // Récupération des données du résultat
                $resultArray = $result->getResult();

                // Vérification si des inscriptions ont été récupérées
                if (count($resultArray) > 0) {
                    return $resultArray;
                }
            }
        } catch (mysqli_sql_exception $e) {
            // Gestion des exceptions
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

    /**
     * @param $utilisateur
     * @param $session
     * @return string
     * Méthode permettant d'inscrire un utilisateur (paramètre = pseudo) à une session de tournoi (paramètre = id)
     */
    function addInscription($utilisateur, $session)
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution des requêtes pour définir les paramètres de la procédure stockée
            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";
            $db->query($stmt1, [$utilisateur]);
            $db->query($stmt2, [$session]);

            // Exécution de la procédure stockée pour ajouter une inscription
            $query = "SELECT `func_ajout_inscription`(@p0, @p1)";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                return "Inscription réussie";
            } else {
                return 'Erreur lors de l\'exécution de la requête';
            }
        } catch (mysqli_sql_exception $e) {
            // Gestion des exceptions
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }
}
