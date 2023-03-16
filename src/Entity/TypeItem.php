<?php

namespace App\Entity;

use App\Repository\TypeItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeItemRepository::class)]
class TypeItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomTypeItem = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeItem(): ?string
    {
        return $this->nomTypeItem;
    }

    public function setNomTypeItem(string $nomTypeItem): self
    {
        $this->nomTypeItem = $nomTypeItem;

        return $this;
    }
}
