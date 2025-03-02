<?php

namespace App\Command;

use App\Services\DivisionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class AddDivisionCommand extends Command
{
    private MessageBusInterface $messageBus;
    protected static $defaultName = 'app:add-division';
    private DivisionService $divisionService;

    public function __construct(

        DivisionService $divisionService
    ) {
        parent::__construct();

        $this->divisionService = $divisionService;
    }
    //Setup console command
    protected function configure(): void
    {
        $this
            ->setName('app:add-division')
            ->setDescription('Add new division')
            ->addArgument('argument', InputArgument::OPTIONAL, 'args');
    }
    //Process console command
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $argument = $input->getArgument('argument');

        if (!$argument) {
            $output->writeln('No division data provided. Adding random Division.');
            $divisionName = "";
        } else {
            [$divisionName] = explode(' ', $argument);
            $output->writeln("Division name: {$divisionName}");
        }

        $this->divisionService->createDivision($divisionName);

        $output->writeln("New division have been sent to the queue for processing.");
        return Command::SUCCESS;
    }
}
