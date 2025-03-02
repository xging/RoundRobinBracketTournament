<?php

namespace App\Services\Match;

use App\Enum\MatchStages;
use App\Repository\MatchesRepository;
use App\Services\Match\Interface\MatchOpponentUpdaterInterface;

class MatchOpponentUpdater implements MatchOpponentUpdaterInterface
{
    public function __construct(private MatchesRepository $matchesRepository) {}

    public function updateOpponent(array $matches, string $stage, string $winner, string $loser): void
    {
        match ($stage) {
            MatchStages::QUARTER_FINALS->value =>
            $this->matchesRepository->updateMatchOpponent($matches[0]->getTeamA(), $winner),

            MatchStages::SEMI_FINALS->value => array_map(
                fn($match) =>
                match ($match->getStage()) {
                    MatchStages::THIRD_PLACE->value => $this->matchesRepository->updateMatchOpponent($match->getTeamA(), $loser),
                    MatchStages::FINAL->value => $this->matchesRepository->updateMatchOpponent($match->getTeamA(), $winner),
                    default => null
                },
                $matches
            ),

            default => null
        };
    }
}
