<?php

namespace App\Services\Match;

use App\Common\DTO\MatchResultDTO;
use App\Entity\Matches;
use App\Entity\TeamsResults;
use App\Common\Enum\MatchPoints;
use App\Common\Enum\MatchStages;
use App\Repository\MatchesRepository;
use App\Repository\TeamsResultsRepository;
use App\Services\Match\Interface\AssignPointsInterface;
use App\Services\Match\Interface\SaveMatchInterface;
use Doctrine\ORM\EntityManagerInterface;

class AssignPoints implements AssignPointsInterface
{
    private $InitialStage;
    public function __construct(
        private MatchesRepository $matchesRepository,
        private EntityManagerInterface $em,
        private TeamsResultsRepository $teamsResultsRepository
    ) {
        $this->InitialStage = MatchStages::MAIN_STAGE->value;
    }

    public function updateResultAndSave(MatchResultDTO $matchResult): void
    {

        $participants = $matchResult->participants;
        $stagePoints = MatchPoints::getStagePoints();
        $teamResultsMap = [];
        $playoffStagePoints = 0;


        $teamResultsList = $this->em->getRepository(TeamsResults::class)->findBy([
            'teamName' => $participants
        ]);


        foreach ($teamResultsList as $teamResults) {
            $teamResultsMap[$teamResults->getTeamName()] = $teamResults;
        }

        foreach ($participants as $index => $participant) {
            if (!isset($teamResultsMap[$participant])) {
                continue;
            }

            $teamResults = $teamResultsMap[$participant];

            $goalScored = $index === 0 ? $matchResult->scoreTeam1 : $matchResult->scoreTeam2;
            $goalConceded = $index === 0 ? $matchResult->scoreTeam2 : $matchResult->scoreTeam1;
            $difference = $goalScored - $goalConceded;


            $wins = $teamResults->getWins();
            $loss = $teamResults->getLoss();
            $ties = $teamResults->getTies();

            match (true) {
                $matchResult->winner === $participant => $wins++,
                $matchResult->loser === $participant => $loss++,
                default => $ties++,
            };


            if ($matchResult->stage !== $this->InitialStage) {
                $playoffStagePoints = $teamResults->getPoints();
                $playoffStagePoints += $stagePoints[$matchResult->stage];
                $playoffStagePoints += ($matchResult->winner === $participant) ? $stagePoints['win'] : 0;
                $playoffStagePoints += ($matchResult->loser === $participant) ? $stagePoints['loss'] : 0;
            }

            $teamResults
                ->setMatches($teamResults->getMatches() + 1)
                ->setWins($wins)
                ->setLoss($loss)
                ->setTies($ties)
                ->setGoalScored($teamResults->getGoalScored() + $goalScored)
                ->setGoalConceded($teamResults->getGoalConceded() + $goalConceded)
                ->setDifference($teamResults->getDifference() + $difference)
                ->setPoints($teamResults->getWins() * 3 + $teamResults->getTies() + $playoffStagePoints);

            $this->teamsResultsRepository->saveTeamResult($teamResults);
        }
    }
}
