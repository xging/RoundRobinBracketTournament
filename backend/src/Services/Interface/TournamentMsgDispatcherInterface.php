<?php

namespace App\Services\Interface;

interface TournamentMsgDispatcherInterface
{
    public function dispatchBuildTournamentMessage(string $action): void;
}
