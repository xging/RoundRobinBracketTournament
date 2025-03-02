<?php

namespace App\Services;

use App\Entity\Matches;
use App\Services\Interface\MatchInterface;
use App\Services\Match\Interface\ProcessMatchInterface;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Exception;

#[WithMonologChannel('process_match')]
class MatchService implements MatchInterface
{
    public function __construct(
        private ProcessMatchInterface $processMatch,
        private LoggerInterface $log
    ) {}

    public function start(int $notPlayedMatchesCount, ?string $divisionName): void
    {
        try {
            $this->processMatch->processMatch($notPlayedMatchesCount, $divisionName ?? "");
            $this->log->info("Match have been started.");
        } catch (Exception $e) {
            $this->log->error("Failed to start match.");
            error_log("Error occurred while starting the match: " . $e->getMessage());
        }
    }
}
