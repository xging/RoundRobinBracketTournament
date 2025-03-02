<?php

namespace App\Services\TeamGenerator\Interface;

interface TeamNameGeneratorInterface
{
    public function generate(string $type, string $shortname): string;
}
