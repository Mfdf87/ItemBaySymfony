<?php

namespace App\Entity;

use App\Repository\TypeItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 20)]
    private ?string $icon = null;

    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'typeItem')]
    private $item;

    #[ORM\OneToMany(mappedBy: 'typeItem', targetEntity: Item::class)]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getItems(): Collection
    {
        return $this->item;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setTypeItem($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getTypeItem() === $this) {
                $item->setTypeItem(null);
            }
        }

        return $this;
    }
}
