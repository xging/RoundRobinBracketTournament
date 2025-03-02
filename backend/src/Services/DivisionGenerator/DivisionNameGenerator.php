<?php

namespace App\Services\DivisionGenerator;

use App\Services\DivisionGenerator\Interface\DivisionNameGeneratorInterface;

class DivisionNameGenerator implements DivisionNameGeneratorInterface
{
    public function generate(): string
    {
        return 'Division ' . rand(1, 99);
    }
}