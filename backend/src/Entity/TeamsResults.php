<?php

namespace App\Entity;

use App\Repository\TeamsResultsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamsResultsRepository::class)]
class TeamsResults
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $divisionName;

    #[ORM\Column(length: 255)]
    private string $teamName;

    #[ORM\Column(type: "integer")]
    private int $matches = 0;

    #[ORM\Column(type: "integer")]
    private int $wins = 0;

    #[ORM\Column(type: "integer")]
    private int $loss = 0;

    #[ORM\Column(type: "integer")]
    private int $ties = 0;

    #[ORM\Column(type: "integer")]
    private int $goalScored = 0;

    #[ORM\Column(type: "integer")]
    private int $goalConceded = 0;

    #[ORM\Column(type: "string")]
    private string $difference = "0";

    #[ORM\Column(type: "integer")]
    private int $points = 0;

    public function __construct(string $teamName, string $divisionName)
    {
        $this->teamName = $teamName;
        $this->divisionName = $divisionName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDivisionName(): string
    {
        return $this->divisionName;
    }

    public function setDivisionName(string $divisionName): static
    {
        $this->divisionName = $divisionName;
        return $this;
    }

    public function getTeamName(): string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): static
    {
        $this->teamName = $teamName;
        return $this;
    }

    public function getMatches(): int
    {
        return $this->matches;
    }

    public function setMatches(int $matches): static
    {
        $this->matches = $matches;
        return $this;
    }

    public function getWins(): int
    {
        return $this->wins;
    }

    public function setWins(int $wins): static
    {
        $this->wins = $wins;
        return $this;
    }

    public function getLoss(): int
    {
        return $this->loss;
    }

    public function setLoss(int $loss): static
    {
        $this->loss = $loss;
        return $this;
    }

    public function getTies(): int
    {
        return $this->ties;
    }

    public function setTies(int $ties): static
    {
        $this->ties = $ties;
        return $this;
    }

    public function getGoalScored(): int
    {
        return $this->goalScored;
    }

    public function setGoalScored(int $goalScored): static
    {
        $this->goalScored = $goalScored;
        return $this;
    }

    public function getGoalConceded(): int
    {
        return $this->goalConceded;
    }

    public function setGoalConceded(int $goalConceded): static
    {
        $this->goalConceded = $goalConceded;
        return $this;
    }

    public function getDifference(): string
    {
        return $this->difference;
    }

    public function setDifference(string $difference): static
    {
        $this->difference = $difference;
        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;
        return $this;
    }
}
