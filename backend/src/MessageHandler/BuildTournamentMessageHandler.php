<?php

namespace App\MessageHandler;

use App\Message\BuildTournamentMessage;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use App\Services\Interface\DivisionInterface;
use App\Services\Interface\TeamInterface;
use App\Repository\DivisionsRepository;
use App\Repository\MatchesRepository;
use App\Repository\TeamsRepository;
use App\Repository\TeamsResultsRepository;
use App\Services\Interface\TournamentMsgDispatcherInterface;
use App\Services\Match\Interface\GenerateMatchInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Exception;

#[AsMessageHandler]
#[WithMonologChannel('message_handler')]
class BuildTournamentMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private DivisionInterface $division,
        private TeamInterface $team,
        private GenerateMatchInterface $generateMatch,
        private DivisionsRepository $divisionsRepository,
        private MatchesRepository $matchesRepository,
        private TeamsRepository $teamsRepository,
        private TeamsResultsRepository $teamsResultsRepository,
        private TournamentMsgDispatcherInterface $msgDispatcher
    ) {}

    public function __invoke(BuildTournamentMessage $message): void
    {
        try {
            match ($message->getAction()) {
                'clear_tables' => $this->handleClearTables(),
                'create_division' => $this->handleCreateDivision(),
                'create_team' => $this->handleCreateTeam(),
                'create_match' => $this->handleCreateMatch(),
                default => $this->logger->error("Unknown action: {$message->getAction()}")
            };
        } catch (Exception $e) {
            $this->logger->error("Error in action {$message->getAction()}: {$e->getMessage()}");
            throw $e;
        }
    }

    private function handleClearTables(): void
    {
        $this->logger->info("Delete tables message handled.");
        $this->divisionsRepository->clearDivisions();
        $this->teamsRepository->clearTeams();
        $this->teamsResultsRepository->clearTeamsResults();
        $this->matchesRepository->clearMatches();
        $this->msgDispatcher->dispatchBuildTournamentMessage('create_division');
    }

    private function handleCreateDivision(): void
    {
        $this->logger->info("Create Divisions message handled.");
        $this->division->createDivision("");
        $this->msgDispatcher->dispatchBuildTournamentMessage('create_team');
    }

    private function handleCreateTeam(): void
    {
        $this->logger->info("Create Teams message handled.");
        $this->team->createTeam("", "");
        $this->msgDispatcher->dispatchBuildTournamentMessage('create_match');
    }

    private function handleCreateMatch(): void
    {
        $this->logger->info("Generate Matches message handled.");
        $this->generateMatch->generateMatches();
    }
}
