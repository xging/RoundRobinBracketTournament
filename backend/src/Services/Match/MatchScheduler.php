<?php

namespace App\Services\Match;

use App\Entity\Matches;
use App\Enum\DivisionsList;
use App\Enum\MatchStages;
use App\Repository\MatchesRepository;
use App\Services\Match\Interface\MatchSchedulerInterface;

class MatchScheduler implements MatchSchedulerInterface
{
    public function __construct(private MatchesRepository $matchesRepository) {}

    public function scheduleNextMatches(string $stage, string $winner, string $loser): void
    {
        $divisionName = DivisionsList::PLAYOFF_DIVISION->value;

        $matchesToCreate = match ($stage) {
            MatchStages::SEMI_FINALS->value => [
                ['stage' => MatchStages::FINAL->value, 'teamA' => $winner],
                ['stage' => MatchStages::THIRD_PLACE->value, 'teamA' => $loser]
            ],
            MatchStages::QUARTER_FINALS->value => [
                ['stage' => MatchStages::SEMI_FINALS->value, 'teamA' => $winner]
            ],
            default => []
        };

        foreach ($matchesToCreate as $matchData) {
            $this->matchesRepository->saveMatch($this->createMatch($matchData['stage'], $divisionName, $matchData['teamA']));
        }
    }

    private function createMatch(string $stage, string $division, string $teamA): Matches
    {
        return (new Matches())
            ->setStage($stage)
            ->setDivision($division)
            ->setTeamA($teamA)
            ->setTeamB('waiting_for_opponent')
            ->setPlayed(false)
            ->setMatchDate(new \DateTime());
    }
}
