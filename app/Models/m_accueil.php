<?php

namespace App\Models;

use CodeIgniter\Model;

class m_accueil extends Model
{
    /**
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer tout les avis laissés par les participants de tournois
     */
    function getCommentaires()
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution de la procédure stockée pour récupérer les commentaires
            $query = "CALL `proc_getCommentaires`()";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                // Récupération des données du résultat
                $resultArray = $result->getResult();

                // Vérification si des commentaires ont été récupérés
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
     * @param $pseudo
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer toutes les sessions auxquels l'utilisateur à participé
     */
    function getSessionsParticipe($pseudo)
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution de la procédure stockée pour récupérer les sessions de tournois auxquelles l'utilisateur
            // participe
            $stmt1 = "SET @p0 = ?";
            $db->query($stmt1, [$pseudo]);
            $query = "CALL `proc_getSessionsParticipe`(@p0)";
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
     * @param $tournoi
     * @param $note
     * @param $commentaire
     * @return string
     * Méthode permettant d'ajouter un commentaire à partir du pseudo de l'utilisateur,
     * l'id de la session, la note sur 5 et le commentaire
     */
    function ajout_avis($utilisateur, $tournoi, $note, $commentaire)
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution des requêtes pour définir les paramètres de la procédure stockée
            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";
            $stmt3 = "SET @p2 = ?";
            $stmt4 = "SET @p3 = ?";
            $db->query($stmt1, [$utilisateur]);
            $db->query($stmt2, [$tournoi]);
            $db->query($stmt3, [$note]);
            $db->query($stmt4, [$commentaire]);

            // Exécution de la procédure stockée pour ajouter un avis
            $query = "SELECT `func_ajout_evaluer`(@p0, @p1, @p2, @p3) AS 'func_ajout_evaluer'";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                // Récupération du résultat de la fonction
                return $result->getResult()[0]->func_ajout_evaluer;
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

    /**
     * @param $commentaire
     * @return string
     * Méthode permettant de supprimer un avis à partir de son id
     */
    function suppr_avis($commentaire)
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution des requêtes pour définir les paramètres de la procédure stockée
            $stmt1 = "SET @p0 = ?";
            $db->query($stmt1, [$commentaire]);

            // Exécution de la procédure stockée pour ajouter un avis
            $query = "SELECT `func_suppr_evaluer`(@p0) AS 'func_suppr_evaluer'";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                // Récupération du résultat de la fonction
                return $result->getResult()[0]->func_suppr_evaluer;
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
