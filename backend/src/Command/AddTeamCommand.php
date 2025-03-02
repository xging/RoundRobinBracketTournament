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

class AddTeamCommand extends Command
{
    private MessageBusInterface $messageBus;
    protected static $defaultName = 'app:add-pair';
    private TeamService $teamService;

    public function __construct(
        MessageBusInterface $messageBus,
        TeamService $teamService
    ) {
        parent::__construct();
        $this->messageBus = $messageBus;
        $this->teamService = $teamService;
    }
    //Setup console command
    protected function configure(): void
    {
        $this
            ->setName('app:add-team')
            ->setDescription('Add new Team')
            ->addArgument('argument', InputArgument::OPTIONAL, 'args');
    }

    //Process console command
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $argument = $input->getArgument('argument');

        if (!$argument) {
            $output->writeln('No team data provided. Adding random Team.');
            [$teamName, $teamShortName] = ["", ""];
        } else {
            [$teamName, $teamShortName] = explode(' ', $argument);
            $output->writeln("Team name: {$teamName}");
            $output->writeln("Shortname: {$teamShortName}");
        }

        $this->teamService->createTeam($teamName, $teamShortName);

        $output->writeln("New team have been sent to the queue for processing.");
        return Command::SUCCESS;
    }
}
