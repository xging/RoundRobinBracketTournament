<?php

namespace App\Command;

use App\Message\AddTeamMessage;
use App\Services\TeamService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Services\Match\Interface\GenerateMatchInterface;


class GenerateMatchCommand extends Command
{
    private MessageBusInterface $messageBus;
    protected static $defaultName = 'app:generate-matches';
    private TeamService $teamService;
    private GenerateMatchInterface $gmi;

    public function __construct(
        MessageBusInterface $messageBus,
        TeamService $teamService,
        GenerateMatchInterface $gmi
    ) {
        parent::__construct();
        $this->messageBus = $messageBus;
        $this->teamService = $teamService;
        $this->gmi = $gmi;
    }
    //Setup console command
    protected function configure(): void
    {
        $this
            ->setName('app:generate-matches')
            ->setDescription('Generate matches')
            ->addArgument('argument', InputArgument::OPTIONAL, 'args');
    }

    //Process console command
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $argument = $input->getArgument('argument');

        $output->writeln('Generate Matches Started:');
        $this->gmi->generateMatches();
        $output->writeln('Generate Matches Ended:');

        return Command::SUCCESS;
    }
}
