<?php

namespace App\Entity;

use App\Repository\EnigmeUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnigmeUserRepository::class)]
class EnigmeUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user = null;

    #[ORM\Column]
    private ?int $enigme = null;

    #[ORM\Column]
    private ?int $fait = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEnigme(): ?int
    {
        return $this->enigme;
    }

    public function setEnigme(int $enigme): self
    {
        $this->enigme = $enigme;

        return $this;
    }

    public function getFait(): ?int
    {
        return $this->fait;
    }

    public function setFait(int $fait): self
    {
        $this->fait = $fait;

        return $this;
    }
}
