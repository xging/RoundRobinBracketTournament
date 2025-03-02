<?php

namespace App\Command;

use App\Services\Interface\BuildTournamentInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class BuildTournamentCommand extends Command
{
    private MessageBusInterface $messageBus;
    private BuildTournamentInterface $buildTournament;

    protected static $defaultName = 'app:build';

    public function __construct(
        MessageBusInterface $messageBus,
        BuildTournamentInterface $buildTournament
    ) {
        parent::__construct();
        $this->messageBus = $messageBus;
        $this->buildTournament = $buildTournament;
    }

    // Setup console command
    protected function configure(): void
    {
        $this
            ->setName('app:build')
            ->setDescription('Build new tournament');
    }

    // Process console command
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->buildTournament->build();
            $output->writeln("Tournament has been successfully built.");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln("<error>Error occurred while building the tournament: {$e->getMessage()}</error>");
            return Command::FAILURE;
        }
    }
}
