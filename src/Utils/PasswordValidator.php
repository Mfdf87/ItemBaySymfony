<?php

namespace App\Utils;

class PasswordValidator
{
    public static function isValidPassword($password)
    {
        // On vérifie que le mot de passe contient au moins 8 caractères
        if (strlen($password) < 8) {
            return "Le mot de passe doit contenir au moins 8 caractères";
        }

        return true;
    }
}