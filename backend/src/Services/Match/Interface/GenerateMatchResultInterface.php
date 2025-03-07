<?php

namespace App\Services\Match\Interface;

use App\Common\DTO\MatchResultDTO;
use App\Entity\Matches;

interface GenerateMatchResultInterface
{
    public function generateResult(Matches $match): MatchResultDTO;
}
