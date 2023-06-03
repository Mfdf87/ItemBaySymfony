<?php

namespace App\Entity;

use App\Repository\AppartenanceItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppartenanceItemRepository::class)]
class AppartenanceItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $idItem = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUser = null;

    #[ORM\Column]
    private ?int $quantite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdItem(): ?Item
    {
        return $this->idItem;
    }

    public function setIdItem(?Item $idItem): self
    {
        $this->idItem = $idItem;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
