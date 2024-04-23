<?php

namespace App\Models;

use CodeIgniter\Model;

class m_admin extends Model
{
    /**
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer la liste des non admin
     */
    function getNonAdminList()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getNonAdminList`()";

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
     * @param $login
     * @return string
     * Méthode permettant d'ajouter un admin à partir de son pseudo
     */
    function ajoutAdmin($login)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$login]);

            $query = "SELECT `func_ajoutAdmin`(@p0) AS `func_ajoutAdmin`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajoutAdmin;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer la liste de admin
     */
    function getAdminList()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getAdminList`()";

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
     * @param $login
     * @return string
     * Méthode permettant de supprimer un admin à partir de son pseudo
     */
    function supprAdmin($login)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$login]);

            $query = "SELECT `func_supprAdmin`(@p0) AS `func_supprAdmin`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_supprAdmin;
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
     * @param $question
     * @return string
     * Méthode permettant d'ajouter une question
     */
    function ajoutQuestion($question)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$question]);

            $query = "SELECT `func_ajout_question`(@p0) AS `func_ajout_question`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajout_question;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer toutes les questions
     */
    function getQuestionsList()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_questionsList`()";

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
     * @param $question
     * @return string
     * Méthode permettant de supprimer une question
     */
    function supprQuestion($question)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$question]);

            $query = "SELECT `func_suppr_question`(@p0) AS `func_suppr_question`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_question;
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
     * @param $reponse
     * @return string
     * Méthode permettant d'ajouter une réponse
     */
    function ajoutReponse($reponse)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$reponse]);

            $query = "SELECT `func_ajout_reponse`(@p0) AS `func_ajout_reponse`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajout_reponse;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer la liste des réponses
     */
    function getReponsesList()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_reponsesList`()";

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
     * @param $reponse
     * @return string
     * Méthode permettant de supprimer une réponse
     */
    function supprReponse($reponse)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$reponse]);

            $query = "SELECT `func_suppr_reponse`(@p0) AS `func_suppr_reponse`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_reponse;
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
     * @param $plateforme
     * @return string
     * Méthode permettant d'ajouter une plateforme
     */
    function ajoutPlateforme($plateforme)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$plateforme]);

            $query = "SELECT `func_ajout_plateforme`(@p0) AS `func_ajout_plateforme`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajout_plateforme;
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
     * @param $plateforme
     * @return string
     * Méthode permettant supprimer une plateforme
     */
    function supprPlateforme($plateforme)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$plateforme]);

            $query = "SELECT `func_suppr_plateforme`(@p0) AS `func_suppr_plateforme`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_plateforme;
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
     * @param $nom
     * @param $description
     * @param $url_image
     * @param $pegi
     * @return string
     * Méthode permettant d'ajouter un jeu à partir d'un nom, d'une description, d'une url d'une image pour illustrer le jeu et du pegi
     */
    function ajoutJeu($nom, $description, $url_image, $pegi)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";
            $stmt3 = "SET @p2 = ?";
            $stmt4 = "SET @p3 = ?";

            $db->query($stmt1, [$nom]);
            $db->query($stmt2, [$description]);
            $db->query($stmt3, [$url_image]);
            $db->query($stmt4, [$pegi]);

            $query = "SELECT `func_ajout_jeux`(@p0, @p1, @p2, @p3) AS `func_ajout_jeux`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajout_jeux;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer la liste des jeux
     */
    function getJeuxList()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_jeuList`()";

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
     * @param $jeu
     * @return string
     * Méthode permettant de supprimer un jeu à partir d'un id
     */
    function supprJeu($jeu)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$jeu]);

            $query = "SELECT `func_suppr_jeux`(@p0) AS `func_suppr_jeux`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_jeux;
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
     * @param $categorie
     * @return string
     * Méthode permettant d'ajouter une catégorie
     */
    function ajoutCategorie($categorie)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$categorie]);

            $query = "SELECT `func_ajouter_categorie`(@p0) AS `func_ajouter_categorie`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajouter_categorie;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer toutes les catégories
     */
    function getCategories()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getCategories`()";

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
     * @param $categorie
     * @return string
     * Méthode permettant de supprimer une catégorie (nom de categorie)
     */
    function supprCategorie($categorie)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$categorie]);

            $query = "SELECT `func_suppr_categorie`(@p0) AS `func_suppr_categorie`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_categorie;
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
     * @param $question
     * @param $reponse
     * @param $bonne
     * @return string
     * Méthode permettant d'ajouter une réponse à une question à partir d'un id de question
     * , un id de réponse et un boolean pour savoir si c'est un bonne réponse
     */
    function ajout_attribuer($question, $reponse, $bonne)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";
            $stmt3 = "SET @p2 = ?";

            $db->query($stmt1, [$question]);
            $db->query($stmt2, [$reponse]);
            $db->query($stmt3, [$bonne]);

            $query = "SELECT `func_ajout_attribuer`(@p0, @p1, @p2) AS `func_ajout_attribuer`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajout_attribuer;
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
     * @param $jeu
     * @param $categorie
     * @return string
     * Méthode permettant d'ajouter une catégorie à un jeu à partir d'un id de jeu et d'un id de catégorie
     */
    function ajout_categoriser($jeu, $categorie)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";

            $db->query($stmt1, [$jeu]);
            $db->query($stmt2, [$categorie]);

            $query = "SELECT `func_jeu_ajout_categorie`(@p0, @p1) AS `func_jeu_ajout_categorie`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_jeu_ajout_categorie;
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
     * @param $jeu
     * @param $plateforme
     * @return string
     * Méthode permettant d'ajouter une plateforme à un jeu à partir d'un id de jeu et d'un id de plateforme
     */
    function ajoutJeuAPlateforme($jeu, $plateforme)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";

            $db->query($stmt1, [$jeu]);
            $db->query($stmt2, [$plateforme]);

            $query = "SELECT `func_ajout_jeu_plateforme`(@p0, @p1) AS `func_ajout_jeu_plateforme`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajout_jeu_plateforme;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer tout les jeux qui n'ont pas de tournois
     */
    function getNonTournoisList()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getAllGamesWithoutTournament`()";

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
     * Méthode permettant de récupérer tout les jeux avec des tournois
     */
    function getTournoisList()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getAllGamesWithTournament`()";

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
     * @param $jeu
     * @return string
     * Méthode permettant d'ajouter un tournoi à partir d'un id de jeu
     */
    function ajoutTournoi($jeu)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$jeu]);

            $query = "SELECT `func_ajouter_tournoi`(@p0) AS `func_ajouter_tournoi`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajouter_tournoi;
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
     * @param $tournoi
     * @param $date
     * @param $heure
     * @param $places
     * @return string
     * Méthode permettant d'ajouter une session à partir d'un id de tournoi, une date, une heure, le nombre de place
     */
    function ajoutSession($tournoi, $date, $heure, $places)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";
            $stmt3 = "SET @p2 = ?";
            $stmt4 = "SET @p3 = ?";

            $db->query($stmt1, [$tournoi]);
            $db->query($stmt2, [$date]);
            $db->query($stmt3, [$heure]);
            $db->query($stmt4, [$places]);

            $query = "SELECT `func_ajout_session_tournoi`(@p0,@p1,@p2,@p3) AS `func_ajout_session_tournoi`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajout_session_tournoi;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer toutes les sessions
     */
    function getAllSessions()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getAllSessions`()";

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
     * @param $session
     * @param $place
     * @param $recompense
     * @return string
     * Méthode permettant d'ajouter une récompense à partir d'un id de session, la place, la récompense
     */
    function ajoutRecompense($session, $place, $recompense)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";
            $stmt3 = "SET @p2 = ?";

            $db->query($stmt1, [$session]);
            $db->query($stmt2, [$place]);
            $db->query($stmt3, [$recompense]);

            $query = "SELECT `func_ajout_recompense`(@p0,@p1,@p2) AS `func_ajout_recompense`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_ajout_recompense;
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
     * @param $tournoi
     * @return string
     * Méthode permettant de supprimer un tournoi à partir de son id
     */
    function supprTournoi($tournoi)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$tournoi]);

            $query = "SELECT `func_suppr_tournoi`(@p0) AS `func_suppr_tournoi`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_tournoi;
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
     * @param $reponse
     * @return string
     * Méthode permettant de supprimer une réponse à une question à partir de son id
     */
    function supprReponseAQuestion($reponse)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$reponse]);

            $query = "SELECT `func_suppr_attribuer`(@p0) AS `func_suppr_attribuer`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_attribuer;
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
     * @param $recompense
     * @return string
     * Méthode permettant de supprimer une récompense à partir de son id
     */
    function supprRecompense($recompense)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$recompense]);

            $query = "SELECT `func_suppr_recompense`(@p0) AS `func_suppr_recompense`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_recompense;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer la liste des récompenses
     */
    function getRecompensesList()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getRecompensesList`()";

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
     * Méthode permettant de récupérer toutes les catégories de tout les jeux
     */
    function getCategoriesJeux()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getAllCategoriesGames`()";

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
     * @param $categorie
     * @return string
     * Méthode permettant de supprimer une catégorie à un jeu à partir de son id
     */
    function supprCategoriser($categorie)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$categorie]);

            $query = "SELECT `func_jeu_suppr_categorie`(@p0) AS `func_jeu_suppr_categorie`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_jeu_suppr_categorie;
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
     * @return array|array[]|object[]|\stdClass[]|string|void
     * Méthode permettant de récupérer toutes les plateformes des jeux
     */
    function getPlateformesJeux()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_getAllPlatformsGames`()";

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
     * @param $plateforme
     * @return string
     * Méthode permettant de supprimer une plateforme à un jeu à partir de son id
     */
    function supprPlateformeJeu($plateforme)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$plateforme]);

            $query = "SELECT `func_suppr_jeu_plateforme`(@p0) AS `func_suppr_jeu_plateforme`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_jeu_plateforme;
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
     * @param $session
     * @return string
     * Méthode permettant de supprimer une session à partir de son id
     */
    function supprSession($session)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";

            $db->query($stmt1, [$session]);

            $query = "SELECT `func_suppr_sesssion_tournoi`(@p0) AS `func_suppr_sesssion_tournoi`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_suppr_sesssion_tournoi;
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
     * @param $debut
     * @param $fin
     * @return string
     * Méthode permettant de modifier les dates (date de début et date de fin) de vote
     */
    function modifDatesVote($debut, $fin)
    {
        try {
            $db = db_connect();

            $stmt1 = "SET @p0 = ?";
            $stmt2 = "SET @p1 = ?";

            $db->query($stmt1, [$debut]);
            $db->query($stmt2, [$fin]);

            $query = "SELECT `func_modifDatesVote`(@p0,@p1) AS `func_modifDatesVote`";
            $result = $db->query($query);

            if ($result) {
                return $result->getResult()[0]->func_modifDatesVote;
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
