<?php

namespace App\Services\Interface;

interface TeamInterface
{
    public function createTeam(string $name, string $shortname): array;
}
