<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamsRepository::class)]
class Teams
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $TeamName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DivisionName = null;

    #[ORM\Column(length: 255)]
    private ?string $TeamShortName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamName(): ?string
    {
        return $this->TeamName;
    }

    public function setTeamName(string $TeamName): static
    {
        $this->TeamName = $TeamName;

        return $this;
    }

    public function getDivisionName(): ?string
    {
        return $this->DivisionName;
    }

    public function setDivisionName(?string $DivisionName): static
    {
        $this->DivisionName = $DivisionName;

        return $this;
    }

    public function getTeamShortName(): ?string
    {
        return $this->TeamShortName;
    }

    public function setTeamShortName(string $TeamShortName): static
    {
        $this->TeamShortName = $TeamShortName;

        return $this;
    }
}
