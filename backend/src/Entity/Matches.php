<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    // #[Groups(['match:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    // #[Groups(['match:read'])]
    private ?string $Stage = "Main Stage";

    #[ORM\Column(length: 255)]
    // #[Groups(['match:read'])]
    private ?string $Division = null;

    #[ORM\Column(length: 255)]
    // #[Groups(['match:read'])]
    private ?string $Team_A = null;

    #[ORM\Column(length: 255)]
    // #[Groups(['match:read'])]
    private ?string $Team_B = null;

    #[ORM\Column(nullable: true)]
    // #[Groups(['match:read'])]
    private ?int $Score_A = null;

    #[ORM\Column(nullable: true)]
    // #[Groups(['match:read'])]
    private ?int $Score_B = null;

    #[ORM\Column(length: 255, nullable: true)]
    // #[Groups(['match:read'])]
    private ?string $Match_Winner = null;

    #[ORM\Column(nullable: true)]
    // #[Groups(['match:read'])]
    private ?bool $isPlayed = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // #[Groups(['match:read'])]
    private ?\DateTimeInterface $Match_Date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStage(): ?string
    {
        return $this->Stage;
    }

    public function setStage(string $Stage): static
    {
        $this->Stage = $Stage;
        return $this;
    }

    public function getDivision(): ?string
    {
        return $this->Division;
    }

    public function setDivision(string $Division): static
    {
        $this->Division = $Division;

        return $this;
    }

    public function getTeamA(): ?string
    {
        return $this->Team_A;
    }

    public function setTeamA(string $Team_A): static
    {
        $this->Team_A = $Team_A;

        return $this;
    }

    public function getTeamB(): ?string
    {
        return $this->Team_B;
    }

    public function setTeamB(string $Team_B): static
    {
        $this->Team_B = $Team_B;

        return $this;
    }

    public function getScoreA(): ?int
    {
        return $this->Score_A;
    }

    public function setScoreA(?int $Score_A): static
    {
        $this->Score_A = $Score_A;

        return $this;
    }

    public function getScoreB(): ?int
    {
        return $this->Score_B;
    }

    public function setScoreB(?int $Score_B): static
    {
        $this->Score_B = $Score_B;
        return $this;
    }

    public function getMatchWinner(): ?string
    {
        return $this->Match_Winner;
    }

    public function setMatchWinner(?string $Match_Winner): static
    {
        $this->Match_Winner = $Match_Winner;

        return $this;
    }

    public function isPlayed(): ?bool
    {
        return $this->isPlayed;
    }

    public function setPlayed(?bool $isPlayed): static
    {
        $this->isPlayed = $isPlayed;

        return $this;
    }

    public function getMatchDate(): ?\DateTimeInterface
    {
        return $this->Match_Date;
    }

    public function setMatchDate(\DateTimeInterface $Match_Date): static
    {
        $this->Match_Date = $Match_Date;

        return $this;
    }
}
