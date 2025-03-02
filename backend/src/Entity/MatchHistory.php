<?php

namespace App\Entity;

use App\Repository\MatchHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchHistoryRepository::class)]
class MatchHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $TeamName = null;

    #[ORM\Column(length: 255)]
    private ?string $OponnentName = null;

    #[ORM\Column(length: 10)]
    private ?string $MatchScore = null;

    #[ORM\Column(length: 25)]
    private ?string $MatchWinner = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $MatchDate = null;

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

    public function getOponnentName(): ?string
    {
        return $this->OponnentName;
    }

    public function setOponnentName(string $OponnentName): static
    {
        $this->OponnentName = $OponnentName;

        return $this;
    }

    public function getMatchScore(): ?string
    {
        return $this->MatchScore;
    }

    public function setMatchScore(string $MatchScore): static
    {
        $this->MatchScore = $MatchScore;

        return $this;
    }

    public function getMatchWinner(): ?string
    {
        return $this->MatchWinner;
    }

    public function setMatchWinner(string $MatchWinner): static
    {
        $this->MatchWinner = $MatchWinner;

        return $this;
    }

    public function getMatchDate(): ?\DateTimeInterface
    {
        return $this->MatchDate;
    }

    public function setMatchDate(\DateTimeInterface $MatchDate): static
    {
        $this->MatchDate = $MatchDate;

        return $this;
    }
}
