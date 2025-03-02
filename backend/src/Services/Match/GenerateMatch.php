<?php

namespace App\Services\Match;

use App\Entity\Matches;
use App\Services\Match\Interface\GenerateMatchInterface;
use App\Repository\MatchesRepository;
use App\Repository\TeamsRepository;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Exception;


#[WithMonologChannel('generate_match')]
class GenerateMatch implements GenerateMatchInterface
{
    public function __construct(
        private TeamsRepository $teamsRepository,
        private MatchesRepository $matchesRepository,
        private LoggerInterface $log
    ) {}

    public function generateMatches(): void
    {
        try {
            $this->mainStageMatches();
            $this->log->info("Matches have been created.");
        } catch (Exception $e) {
            $this->log->error("Failed to create matches.");
            error_log("Error occurred while creating matches: " . $e->getMessage());
        }
    }


    private function mainStageMatches(): void
    {
        $teams = $this->teamsRepository->getTeamsListName();
        foreach ($teams as $i => $team1) {
            $divisionName1 = $team1->getDivisionName();

            for ($j = $i + 1; $j < count($teams); $j++) {
                $team2 = $teams[$j];
                $divisionName2 = $team2->getDivisionName();

                if ($divisionName1 === $divisionName2) {

                    $match = new Matches;
                    $match
                        ->setDivision($divisionName1)
                        ->setTeamA($team1->getTeamName())
                        ->setTeamB($teams[$j]->getTeamName())
                        ->setPlayed(false)
                        ->setMatchDate(new \DateTime());

                    $this->matchesRepository->saveMatch($match);
                }
            }
        }
    }
}
