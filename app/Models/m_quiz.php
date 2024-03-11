<?php

namespace App\Models;

use CodeIgniter\Model;

class m_quiz extends Model
{

    /**
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Fonction pour récupérer le quiz (questions/réponses)
     */
    function getQuiz()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getquiz`()";

            $result = $db->query($query);

            if ($result) {
                $resultArray = $result->getResult();

                if (count($resultArray) > 0) {
                    return $resultArray;
                }
            }
        } catch (mysqli_sql_exception $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }

    }

    /**
     * @param $utilisateur
     * @param $bonneRep
     * @return string
     * Méthode permettant d'ajouter le score de l'utilisateur (paramètre = pseudo) aux scores du quiz
     */
    function ajoutResultQuiz($utilisateur, $bonneRep)
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution des requêtes pour définir les paramètres de la procédure stockée
            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";
            $db->query($stmt1, [$utilisateur]);
            $db->query($stmt2, [$bonneRep]);

            // Exécution de la procédure stockée pour ajouter le résultat du quiz
            $query = "SELECT `func_ajout_result_quiz`(@p0, @p1) AS 'func_ajout_result_quiz'";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                // Récupération du résultat de la fonction
                return $result->getResult()[0]->func_ajout_result_quiz;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer le top 10 des meilleurs scores du quiz
     */
    function getTop10()
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution de la procédure stockée pour récupérer le top 10 des scores de quiz
            $query = "CALL `proc_getTop10Quiz`()";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                // Récupération des données du résultat
                $resultArray = $result->getResult();

                // Vérification si des données ont été récupérées
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
}
