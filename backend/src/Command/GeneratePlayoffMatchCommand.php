<?php

namespace App\Command;

use App\Enum\MatchStages;
use App\Message\AddTeamMessage;
use App\Services\TeamService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Services\Match\Interface\GenerateMatchInterface;
use App\Services\Match\GeneratePlayoffMatch;

class GeneratePlayoffMatchCommand extends Command
{
    private MessageBusInterface $messageBus;
    protected static $defaultName = 'app:generate-playoff';
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
            ->setName('app:generate-playoff')
            ->setDescription('Generate playoff matches')
            ->addArgument('argument', InputArgument::OPTIONAL, 'args');
    }

    //Process console command
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $argument = $input->getArgument('argument');

        $this->gmi->generateMatches();
        // $bracket = [
        //     MatchStages::QUARTER_FINALS,
        //     MatchStages::SEMI_FINALS,
        //     MatchStages::THIRD_PLACE,
        //     MatchStages::FINAL,
        // ];



        // $output->writeln('Generate Playoff Matches Started:');
        // //Get 8 Teams
        // $teams = $this->databaseModel->getPlayoffTeams();

        // //shuffle teams
        // shuffle($teams);


        // for ($i = 0; $i < count($teams); $i += 2) {
        //     $output->writeln($teams[$i]['DivisionName']);
        //     $output->writeln("{$teams[$i][0]->getTeamName()} - {$teams[$i + 1][0]->getTeamName()}");


        //     $this->databaseModel->addMatch($bracket[0]->value, $teams[$i]['DivisionName'], $teams[$i][0]->getTeamName(), $teams[$i + 1][0]->getTeamName(), false);
        // }


        return Command::SUCCESS;
    }
}
