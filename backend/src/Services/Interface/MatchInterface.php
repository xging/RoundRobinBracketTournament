<?php

namespace App\Services\Interface;

interface MatchInterface
{
    public function start(int $notPlayedMatchesCount, ?string $divisionName): void;
}
