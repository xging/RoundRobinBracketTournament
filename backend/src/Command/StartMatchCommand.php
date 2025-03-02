<?php

namespace App\Command;

use App\Message\AddTeamMessage;
use App\Repository\MatchesRepository;
use App\Services\TeamService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Services\Match\Interface\GenerateMatchResultInterface;

use App\Services\MatchService;

class StartMatchCommand extends Command
{
    private MessageBusInterface $messageBus;
    protected static $defaultName = 'app:start-match';
    private MatchService $startMatch;
    private MatchesRepository $matchesRepository;
    public function __construct(
        MessageBusInterface $messageBus,
        MatchService $startMatch,
        MatchesRepository $matchesRepository
    ) {
        parent::__construct();
        $this->messageBus = $messageBus;
        $this->startMatch = $startMatch;
        $this->matchesRepository = $matchesRepository;
    }
    //Setup console command
    protected function configure(): void
    {
        $this
            ->setName('app:start-match')
            ->setDescription('Start new match')
            ->addArgument('division_name', InputArgument::OPTIONAL, 'Division name');
    }

    //Process console command
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $divisionName = $input->getArgument('division_name');
        $notPlayedMatchesCount = $this->matchesRepository->getNotPlayedMatchesCount(str_replace("_", " ", $divisionName));
        $output->writeln("Count: {$notPlayedMatchesCount}");

        if ($notPlayedMatchesCount === 0) {
            $output->writeln("No matches found for processing.");
            return Command::SUCCESS;
        }

        $this->startMatch->start($notPlayedMatchesCount, $divisionName);
        return Command::SUCCESS;
    }
}
