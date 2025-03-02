<?php

namespace App\Message;

class AddTeamMessage
{
    public function __construct(
        private string $message,
        private array $args
    ) {}

    public function getArgs(): array
    {
        return $this->args;
    }
    public function getMessage(): string
    {
        return $this->message;
    }
}
