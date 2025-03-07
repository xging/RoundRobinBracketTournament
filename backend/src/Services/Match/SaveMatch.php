<?php

namespace App\Services\Match;

use App\Common\DTO\MatchResultDTO;
use App\Entity\Matches;
use App\Repository\MatchesRepository;
use App\Repository\TeamsResultsRepository;
use App\Services\Match\Interface\AssignPointsInterface;
use App\Services\Match\Interface\SaveMatchInterface;
use Doctrine\ORM\EntityManagerInterface;

class SaveMatch implements SaveMatchInterface
{
    public function __construct(
        private MatchesRepository $matchesRepository,
        private EntityManagerInterface $em,
        private TeamsResultsRepository $teamsResultsRepository,
        private AssignPointsInterface $assignPoints
    ) {}


    public function saveMatchResults(MatchResultDTO $matchResult): void
    {
        [$team1, $team2] = $matchResult->participants;

        $match = $this->em->getRepository(Matches::class)->findOneBy([
            'Team_A' => $team1,
            'Team_B' => $team2,
            'isPlayed' => false
        ]);

        $match
            ->setPlayed(true)
            ->setTeamA($team1)
            ->setTeamB($team2)
            ->setScoreA($matchResult->scoreTeam1)
            ->setScoreB($matchResult->scoreTeam2)
            ->setMatchWinner($matchResult->winner)
            ->setMatchDate(new \DateTime());

        $this->matchesRepository->saveMatch($match);
        $this->assignPoints->updateResultAndSave($matchResult);
    }
}
