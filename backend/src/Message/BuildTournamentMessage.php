<?php

namespace App\Message;

class BuildTournamentMessage
{
    public function __construct(
        private string $action
    ) {}

    public function getAction(): string
    {
        return $this->action;
    }
}
