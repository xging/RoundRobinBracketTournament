<?php

namespace App\Common\DTO;

class MatchResultDTO
{
    public function __construct(
        public array $participants,
        public int $scoreTeam1,
        public int $scoreTeam2,
        public ?string $winner,
        public ?string $loser,
        public string $stage,
    ) {}
}
