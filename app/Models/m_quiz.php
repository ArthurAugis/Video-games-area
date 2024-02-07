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
        } catch (PDOException $e) {
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();

            return "Erreur : $errorCode - Message : $errorMessage";
        }
    }

}