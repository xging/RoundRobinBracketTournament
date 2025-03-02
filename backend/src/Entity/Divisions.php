<?php

namespace App\Entity;

use App\Repository\DivisionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DivisionsRepository::class)]
class Divisions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $DivisionName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDivisionName(): ?string
    {
        return $this->DivisionName;
    }

    public function setDivisionName(string $DivisionName): static
    {
        $this->DivisionName = $DivisionName;

        return $this;
    }
}
