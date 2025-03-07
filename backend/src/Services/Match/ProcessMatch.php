<?php

namespace App\Services\Match;

use App\Common\Enum\MatchStages;
use App\Repository\DivisionsRepository;
use App\Repository\MatchesRepository;
use App\Services\Match\Interface\ProcessMatchInterface;
use App\Services\Match\Interface\GenerateMatchResultInterface;
use App\Services\Match\Interface\GeneratePlayoffMatchInterface;
use App\Services\Match\Interface\MatchStageProcessorInterface;
use App\Services\Match\Interface\SaveMatchInterface;

class ProcessMatch implements ProcessMatchInterface
{
    private const DIVISION_NAME = "MORTAL KOMBAT";

    public function __construct(
        private GenerateMatchResultInterface $matchResult,
        private MatchStageProcessorInterface $stageProcessor,
        private SaveMatchInterface $saveMatch,
        private GeneratePlayoffMatchInterface $generatePlayoffStage,
        private DivisionsRepository $divisionsRepository,
        private MatchesRepository $matchesRepository
    ) {}

    public function processMatch(int $notPlayedMatchesCount, ?string $divisionName): void
    {
        for ($i = 0; $i < $notPlayedMatchesCount; $i++) {
            $selectMatch = $this->findNextMatch($divisionName ?? "");

            if ($selectMatch === false) {
                throw new \Exception("Error: Failed to generate match result.");
            }

            $results = $this->matchResult->generateResult($selectMatch);

            $this->saveMatch->saveMatchResults($results);
            $this->stageProcessor->processNextRound($selectMatch, $results);
        }

        if ($results->stage === MatchStages::MAIN_STAGE->value && $this->matchesRepository->getNotPlayedMatchesInStageCount("Main Stage") === 0) {
            $this->generatePlayoffStage->generateMatches();
        }
    }

    private function findNextMatch(?string $divisionName)
    {
        $selectedDivisionName = $this->divisionsRepository->getDivisionsName($divisionName ?? null);

        foreach ($selectedDivisionName as $division) {
            $selectMatch = $this->matchesRepository->getNotPlayedMatch($division->getDivisionName());
            if ($selectMatch !== false) {
                return $selectMatch;
            }
        }

        return $this->matchesRepository->getNotPlayedMatch(self::DIVISION_NAME);
    }
}
