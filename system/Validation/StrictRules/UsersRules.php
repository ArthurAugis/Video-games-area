<?php

namespace CodeIgniter\Validation\StrictRules;

class UsersRules
{
    public function password($value, ?string &$error = null): bool
    {
        $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/';

        // Longueur de 12 caractères minimum et minimum 1 minuscule, 1 majuscule, 1 chiffre, 1 caractère spécial
        if (strlen($value) >= 12 && preg_match($pattern, $value)) {
            return true;
        }

        // Tableau pour stocker les critères manquants
        $missingCriteria = [];

        // Vérification de chaque critère individuellement
        if (strlen($value) < 12) {
            $missingCriteria[] = "au moins 12 caractères";
        }

        if (!preg_match('/[a-z]/', $value)) {
            $missingCriteria[] = "au moins 1 minuscule";
        }

        if (!preg_match('/[A-Z]/', $value)) {
            $missingCriteria[] = "au moins 1 majuscule";
        }

        if (!preg_match('/\d/', $value)) {
            $missingCriteria[] = "au moins 1 chiffre";
        }

        if (!preg_match('/[@$!%*?&]/', $value)) {
            $missingCriteria[] = "au moins 1 caractère spécial";
        }

        // Le message d'erreur en fonction des critères manquants
        $error = lang("Votre mot de passe doit contenir " . implode(", ", $missingCriteria) . " (exemple: $/~*)");

        return false;
    }

}