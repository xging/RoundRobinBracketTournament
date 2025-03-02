<?php

namespace App\Services;

use App\Message\BuildTournamentMessage;
use App\Services\Interface\BuildTournamentInterface;
use App\Services\Interface\TournamentMsgDispatcherInterface;
use Monolog\Attribute\WithMonologChannel;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Exception;


#[WithMonologChannel('build_tournament')]
// #[AsMessageHandler]
class BuildTournament implements BuildTournamentInterface
{
    public function __construct(
        private LoggerInterface $log,
        private MessageBusInterface $bus,
        private TournamentMsgDispatcherInterface $msgDispatcher
    ) {}


    public function build(): void
    {
        //Start with very first stage of build tournament - clear tables stage.
        $this->msgDispatcher->dispatchBuildTournamentMessage('clear_tables');
    }
}
