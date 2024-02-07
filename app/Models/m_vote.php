<?php

namespace App\Models;

use CodeIgniter\Model;

class m_vote extends Model
{

    function getJeuxVote()
    {
        try {
            $db = db_connect();

            $query = "CALL `proc_jeux_sans_tournois`()";

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