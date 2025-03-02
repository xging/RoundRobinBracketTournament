<?php

namespace App\Services\Match;

use App\Services\Match\Interface\GenerateMatchResultInterface;
use App\DTO\MatchResultDTO;
use App\Entity\Matches;

class GenerateMatchResult implements GenerateMatchResultInterface
{
    public function generateResult(Matches $match): MatchResultDTO
    {
        $probabilities = [
            0 => 10,
            1 => 30,
            2 => 25,
            3 => 20,
            4 => 10,
            5 => 5
        ];

        $isMainStage = $match->getStage() === "Main Stage";

        do {
            [$team1Score, $team2Score] = array_map([$this, 'getScoreBasedOnProbability'], [$probabilities, $probabilities]);
        } while (!$isMainStage && $team1Score === $team2Score);

        $winner = $loser = 'Draw';

        if ($team1Score !== $team2Score) {
            [$winner, $loser] = $team1Score > $team2Score
                ? [$match->getTeamA(), $match->getTeamB()]
                : [$match->getTeamB(), $match->getTeamA()];
        }

        return new MatchResultDTO(
            participants: [$match->getTeamA(), $match->getTeamB()],
            scoreTeam1: $team1Score,
            scoreTeam2: $team2Score,
            winner: $winner,
            loser: $loser,
            stage: $match->getStage()
        );
    }

    private function getScoreBasedOnProbability(array $probabilities): int
    {
        $rand = rand(1, 100);
        $cumulativeProbability = 0;

        foreach ($probabilities as $score => $probability) {
            $cumulativeProbability += $probability;
            if ($rand <= $cumulativeProbability) {
                return $score;
            }
        }
        return 0;
    }
}
