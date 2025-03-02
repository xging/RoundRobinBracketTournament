<?php

namespace App\Services\Match\Interface;

interface MatchSchedulerInterface
{
    public function scheduleNextMatches(string $stage, string $winner, string $loser): void;
}
