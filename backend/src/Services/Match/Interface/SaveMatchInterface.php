<?php

namespace App\Services\Match\Interface;

use App\Common\DTO\MatchResultDTO;

interface SaveMatchInterface
{
    public function saveMatchResults(MatchResultDTO $matchResult): void;
}
