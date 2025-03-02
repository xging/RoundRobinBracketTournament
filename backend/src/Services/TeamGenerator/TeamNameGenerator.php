<?php

namespace App\Services\TeamGenerator;

use App\Services\TeamGenerator\Interface\TeamNameGeneratorInterface;
use App\Repository\TeamsRepository;

class TeamNameGenerator implements TeamNameGeneratorInterface
{
    private TeamsRepository $teamsRepository;

    public function __construct(TeamsRepository $teamsRepository)
    {
        $this->teamsRepository = $teamsRepository;
    }

    public function generate(string $type, string $shortname): string
    {
        while ($this->teamsRepository->ifTeamExists($name = 'Village ' . rand(1, 99)));
        return match ($type) {
            'shortname' => preg_replace('/^(\w{3})\w*\s*(\d+)$/', '$1$2', $shortname),
            default => $name,
        };
    }
}
