<?php

namespace App\Services\Match\Interface;

use App\Entity\Matches;

interface ProcessMatchInterface
{
    public function processMatch(int $notPlayedMatchesCount, string $divisionName): void;
}
