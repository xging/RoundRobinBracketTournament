<?php

namespace App\Services\Match;

use App\Common\DTO\MatchResultDTO;
use App\Entity\Matches;
use App\Common\Enum\MatchStages;
use App\Repository\MatchesRepository;
use App\Services\Match\Interface\MatchOpponentUpdaterInterface;
use App\Services\Match\Interface\MatchSchedulerInterface;
use App\Services\Match\Interface\MatchStageProcessorInterface;

class MatchStageProcessor implements MatchStageProcessorInterface
{
    private const WAITING_FOR_OPPONENT = "waiting_for_opponent";

    public function __construct(
        private MatchSchedulerInterface $matchScheduler,
        private MatchOpponentUpdaterInterface $matchOpponentUpdate,
        private MatchesRepository $matchesRepository
    ) {}


    public function processNextRound(Matches $match, MatchResultDTO $results): void
    {
        [$winner, $loser, $stage] = [$results->winner, $results->loser, $match->getStage()];
        $lastPlayedMatch = $this->matchesRepository->getLastPlayedMatches($stage === MatchStages::SEMI_FINALS->value ? 2 : 1);

        if (!$lastPlayedMatch) {
            return;
        }

        if ($this->isWaitingForOpponent($lastPlayedMatch[0])) {
            $this->matchOpponentUpdate->updateOpponent($lastPlayedMatch, $stage, $winner, $loser);
        } else {
            $this->matchScheduler->scheduleNextMatches($stage, $winner, $loser);
        }
    }

    private function isWaitingForOpponent(Matches $match): bool
    {
        return $match->getTeamB() === self::WAITING_FOR_OPPONENT;
    }
}
