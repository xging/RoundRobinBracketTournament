<?php

namespace App\Services\Match\Interface;

use App\DTO\MatchResultDTO;
use App\Entity\Matches;

interface MatchStageProcessorInterface
{
    public function processNextRound(Matches $match, MatchResultDTO $results): void;
}
