<?php

namespace App\Services;

use App\Entity\Teams;
use App\Entity\TeamsResults;
use App\Repository\TeamsRepository;
use App\Repository\TeamsResultsRepository;
use App\Services\Interface\TeamInterface;
use App\Services\TeamGenerator\Interface\DivisionAssignerInterface;
use App\Services\TeamGenerator\Interface\TeamNameGeneratorInterface;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;

#[WithMonologChannel('teams_service')]
class TeamService implements TeamInterface
{
    public function __construct(
        private TeamNameGeneratorInterface $nameGenerator,
        private DivisionAssignerInterface $divisionAssigner,
        private TeamsRepository $teamsRepository,
        private TeamsResultsRepository $teamsResultsRepository,
        private LoggerInterface $log
    ) {}



    public function createTeam(string $name, string $shortname): array
    {
        $teams = [];
        $teamCount = (empty($name) && empty($shortname)) ? 20 : 1;

        for ($i = 0; $i < $teamCount; $i++) {
            $team = new Teams();

            $teamName = empty($name) && empty($shortname) ? $this->nameGenerator->generate('name', '') : $name;
            $teamShortName = empty($name) && empty($shortname) ? $this->nameGenerator->generate('shortname', $teamName) : $shortname;

            $team
                ->setTeamName(str_replace("_", " ", $teamName))
                ->setTeamShortName($teamShortName);
            $this->divisionAssigner
                ->assign($team);

            $this->teamsRepository
                ->saveTeam($team);

            $teamResults = new TeamsResults($team->getTeamName(), $team->getDivisionName());
            $this->teamsResultsRepository
                ->addTeamResults($teamResults);

            $teams[] = $team;
        }

        $this->log->info(
            match (!empty($teams)) {
                true => "Teams are created, Count: " . count($teams),
                false => "Teams are not created.",
            },
            ['count' => count($teams)]
        );

        return $teams;
    }
}
