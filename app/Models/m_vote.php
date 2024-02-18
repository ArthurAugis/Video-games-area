<?php

namespace App\Models;

use CodeIgniter\Model;

class m_vote extends Model
{

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
        } catch (PDOException $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

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
        } catch (PDOException $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

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
        } catch (PDOException $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

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
        } catch (PDOException $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

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
        } catch (PDOException $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

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
        } catch (PDOException $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }


}