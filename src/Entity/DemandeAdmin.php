<?php

namespace App\Entity;

use App\Repository\DemandeAdminRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeAdminRepository::class)]
class DemandeAdmin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSubmition = null;

    #[ORM\Column]
    private ?bool $accept = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $NomJoueur = null;

    #[ORM\Column]
    private ?int $TypeDemande = null;

    #[ORM\Column(nullable: true)]
    private ?int $Somme = null;

    #[ORM\ManyToOne]
    private ?User $CreatedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSubmition(): ?\DateTimeInterface
    {
        return $this->dateSubmition;
    }

    public function setDateSubmition(\DateTimeInterface $dateSubmition): self
    {
        $this->dateSubmition = $dateSubmition;

        return $this;
    }

    public function isAccept(): ?bool
    {
        return $this->accept;
    }

    public function setAccept(bool $accept): self
    {
        $this->accept = $accept;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getNomJoueur(): ?string
    {
        return $this->NomJoueur;
    }

    public function setNomJoueur(?string $NomJoueur): self
    {
        $this->NomJoueur = $NomJoueur;

        return $this;
    }

    public function getTypeDemande(): ?int
    {
        return $this->TypeDemande;
    }

    public function setTypeDemande(int $TypeDemande): self
    {
        $this->TypeDemande = $TypeDemande;

        return $this;
    }

    public function getSomme(): ?int
    {
        return $this->Somme;
    }

    public function setSomme(?int $Somme): self
    {
        $this->Somme = $Somme;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->CreatedBy;
    }

    public function setCreatedBy(?User $CreatedBy): self
    {
        $this->CreatedBy = $CreatedBy;

        return $this;
    }
}
