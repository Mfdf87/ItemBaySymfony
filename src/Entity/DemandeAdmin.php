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

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSubmition = null;

    #[ORM\Column(length: 255)]
    private ?string $infoSup = null;

    #[ORM\Column]
    private ?bool $accept = null;

    #[ORM\Column(length: 255)]
    private ?string $Raison = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getInfoSup(): ?string
    {
        return $this->infoSup;
    }

    public function setInfoSup(string $infoSup): self
    {
        $this->infoSup = $infoSup;

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

    public function getRaison(): ?string
    {
        return $this->Raison;
    }

    public function setRaison(string $Raison): self
    {
        $this->Raison = $Raison;

        return $this;
    }
}
