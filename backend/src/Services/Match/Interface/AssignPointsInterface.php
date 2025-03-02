<?php

namespace App\Services\Match\Interface;

use App\DTO\MatchResultDTO;

interface AssignPointsInterface
{
    public function updateResultAndSave(MatchResultDTO $matchResult): void;
}
