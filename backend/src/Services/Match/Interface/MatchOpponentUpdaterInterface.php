<?php

namespace App\Services\Match\Interface;

interface MatchOpponentUpdaterInterface
{
    public function updateOpponent(array $matches, string $stage, string $winner, string $loser): void;
}
