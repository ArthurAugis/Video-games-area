<?php

namespace App\Models;

use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Model;

class m_user extends Model
{
    /**
     * @param $login
     * @param $mail
     * @param $age
     * @param $mdp
     * @return string
     * Méthode utilisant la fonction func_createUser (permet de créer un utilisateur)
     */
    function createUser($login, $mail, $age, $mdp)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";
            $stmt3 = "SET @p2 = ?";
            $stmt4 = "SET @p3 = ?";

            $db->query($stmt1, [$login]);
            $db->query($stmt2, [$mail]);
            $db->query($stmt3, [$age]);
            $db->query($stmt4, [$mdp]);

            $query = "SELECT `func_createUser`(@p0, @p1, @p2, @p3) AS `func_createUser`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_createUser;
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
     * @param $mail
     * @return array|int|mixed|object|\stdClass|string
     * Méthode utilisant la procédure stockée proc_login (récupére le mdp)
     */
    function loginUser($mail)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$mail]);

            $query = "CALL `proc_login`(@p0)";

            $result = $db->query($query);

            if ($result) {
                $resultArray = $result->getResult();

                if (count($resultArray) > 0) {
                    if (property_exists($resultArray[0], 'mdp')) {
                        return $resultArray[0];
                    } else {
                        return -1;
                    }
                } else {
                    return -1;
                }
            } else {
                return -1;
            }
        } catch (mysqli_sql_exception $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

    /**
     * @param $age
     * @param $mail
     * @return string
     * Méthode pour changer l'âge de l'utilisateur à partir de son adresse mail
     */
    function changerAge($age, $mail)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";

            $db->query($stmt1, [$age]);
            $db->query($stmt2, [$mail]);

            $query = "SELECT `func_changerAge`(@p0, @p1) AS `func_changerAge`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_changerAge;
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
     * @param $pseudo
     * @param $mail
     * @return string
     * Méthode pour changer le pseudo de l'utilisateur à partir de son adresse mail
     */
    function changerPseudo($pseudo, $mail)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";

            $db->query($stmt1, [$pseudo]);
            $db->query($stmt2, [$mail]);

            $query = "SELECT `func_changerPseudo`(@p0, @p1) AS `func_changerPseudo`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_changerPseudo;
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
     * @param $nouveaumail
     * @param $mail
     * @return string
     * Méthode pour changer le mail de l'utilisateur à partir de son adresse mail
     */
    function changerMail($nouveaumail, $mail)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";

            $db->query($stmt1, [$nouveaumail]);
            $db->query($stmt2, [$mail]);

            $query = "SELECT `func_changerMail`(@p0, @p1) AS `func_changerMail`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_changerMail;
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
     * @param $mdp
     * @param $mail
     * @return string
     * Méthode pour changer le mot de passe de l'utilisateur à partir de son adresse mail
     */
    function changerMdp($mdp, $mail)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";

            $db->query($stmt1, [$mdp]);
            $db->query($stmt2, [$mail]);

            $query = "SELECT `func_changerMdp`(@p0, @p1) AS `func_changerMdp`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_changerMdp;
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
     * @param $login
     * @return string
     * Méthode pour supprimer un utilisateur à partir de son pseudo
     */
    function supprUser($login)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$login]);

            $query = "SELECT `func_suppr_utilisateur`(@p0) AS `func_suppr_utilisateur`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_utilisateur;
            } else {
                return 'Erreur lors de l\'exécution de la requête';
            }
        } catch (mysqli_sql_exception $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }
}
