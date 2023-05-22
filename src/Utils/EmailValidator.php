<?php

namespace App\Utils;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Compte;

class EmailValidator
{
    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function isEmailInBDD($email, EntityManagerInterface $entityManager)
    {
        $emailBdd = $entityManager->getRepository(Compte::class)->findOneBy([
            'email' => $email
        ]);

        return $emailBdd !== null;
    }
}
