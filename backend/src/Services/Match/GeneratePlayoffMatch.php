<?php

namespace App\Services\Match;

use App\Entity\Matches;
use App\Enum\DivisionsList;
use App\Enum\MatchStages;
use App\Services\Match\Interface\GeneratePlayoffMatchInterface;
use App\Repository\MatchesRepository;
use App\Repository\TeamsRepository;

use Exception;

class GeneratePlayoffMatch implements GeneratePlayoffMatchInterface
{
    public function __construct(
        private MatchesRepository $matchesRepository,
        private TeamsRepository $teamsRepository
    ) {}

    public function generateMatches(): void
    {
        try {
            $this->playoffStageMatches();
        } catch (Exception $e) {
            error_log("Ошибка при генерации матчей четвертьфинала: " . $e->getMessage());
        }
    }

    private function playoffStageMatches(): void
    {
        $teams = $this->teamsRepository->getPlayoffTeams();
        shuffle($teams);

        for ($i = 0; $i < count($teams); $i += 2) {

            $match = new Matches;
            $match
                ->setStage(MatchStages::QUARTER_FINALS->value)
                ->setDivision(DivisionsList::PLAYOFF_DIVISION->value)
                ->setTeamA($teams[$i][0]->getTeamName())
                ->setTeamB($teams[$i + 1][0]->getTeamName())
                ->setPlayed(false)
                ->setMatchDate(new \DateTime());

            $this->matchesRepository->saveMatch($match);
        }
    }
}
