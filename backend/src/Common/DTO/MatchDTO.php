<?php

namespace App\Common\DTO;

use App\Entity\Matches;

class MatchDTO
{
    public function __construct(
        public int $id,
        public string $division,
        public string $teamA,
        public string $teamB,
        public ?int $scoreA,
        public ?int $scoreB
    ) {}

    public static function fromMatch(Matches $match): self
    {
        return new self(
            $match->getId(),
            $match->getDivision(),
            $match->getTeamA(),
            $match->getTeamB(),
            $match->getScoreA(),
            $match->getScoreB()
        );
    }
}
