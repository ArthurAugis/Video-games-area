<?php

namespace App\Models;

use CodeIgniter\Model;

class m_vote extends Model
{
    /**
     * @param $plateforme
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode utilisant la procédure stockée proc_jeux_sans_tournois (permet de récupérer tout
     * les jeux n'ayant pas de tournois)
     */
    function getJeuxVote($plateforme)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$plateforme]);

            $query = "CALL `proc_jeux_sans_tournois`(@p0)";

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
     * @param $jeu
     * @return string
     * Méthode utilisant la fonction func_voter (permet de faire voter un utilisateur à un jeu)
     */
    function addVote($utilisateur, $jeu)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";

            $db->query($stmt1, [$utilisateur]);
            $db->query($stmt2, [$jeu]);

            $query = "SELECT `func_voter`(@p0, @p1) AS `func_voter`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_voter;
            } else {
                return 'Erreur lors de l\'exécution de la requête';
            }
        } catch (mysqli_sql_exception $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

    /**
     * @param $utilisateur
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode utilisant la procédure stockée proc_getVotesUtilisateur (permet de récupérer
     * tout les votes de l'utilisateur [via son pseudo])
     */
    function hasVote($utilisateur)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$utilisateur]);

            $query = "CALL `proc_getVotesUtilisateur`(@p0)";

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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode utilisant la procédure stockée proc_getPlateformes (permet récupérer toutes les plateformes)
     */
    function getPlateformes()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getPlateformes`()";

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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode utilisant la procédure stockée proc_getDefaultPlatform (permet de récupérer la premiere plateforme
     * de la base de données qui sera celle par défaut)
     */
    function getDefaultPlatform()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getDefaultPlatform`()";

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
     * @param $platform
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode utilisant la procédure stockée proc_getPlatform
     * (permet de vérifier si la plateforme existe dans la base de données)
     */
    function getPlatform($platform)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$platform]);

            $query = "CALL `proc_getPlatform`(@p0)";

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
     * @param $platform
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode utilisant la procédure stockée proc_pourcent_vote avec comme paramètre le nom d'une
     * plateforme (récupére les résultats du vote à partir du nom de la plateforme)
     */
    function getResultats($platform)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$platform]);

            $query = "CALL `proc_pourcent_vote`(@p0)";

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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode utilisant la procédure stockée proc_getDatesVote (récupére les dates de début et de fin du vote)
     */
    function getDatesVote()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getDatesVote`()";

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
}
