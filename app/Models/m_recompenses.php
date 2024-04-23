<?php

namespace App\Models;

use CodeIgniter\Model;

class m_recompenses extends Model
{
    /**
     * @param $session
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer toutes les récompenses d'une session (id session)
     */
    function getRecompenses($session)
    {
        try {
            // Connexion à la base de données
            $db = db_connect();

            // Exécution des requêtes pour définir les paramètres de la procédure stockée
            $stmt1 = "SET @p0 = ?";
            $db->query($stmt1, [$session]);

            // Exécution de la procédure stockée pour récupérer les récompenses pour une session de tournoi spécifiée
            $query = "CALL `proc_getRecompenses`(@p0)";
            $result = $db->query($query);

            // Vérification si le résultat est valide
            if ($result) {
                // Récupération des données du résultat
                $resultArray = $result->getResult();

                // Vérification si des récompenses ont été récupérées
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
