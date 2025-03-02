<?php

namespace App\Services;

use App\Message\BuildTournamentMessage;
use App\Services\Interface\TournamentMsgDispatcherInterface;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;

#[WithMonologChannel('message_handler')]
class TournamentMsgDispatcher implements TournamentMsgDispatcherInterface
{
    public function __construct(
        private MessageBusInterface $bus,
        private LoggerInterface $log
    ) {}

    public function dispatchBuildTournamentMessage(string $action): void
    {
        $message = new BuildTournamentMessage($action);
        $envelope = new Envelope(
            $message,
            [
                new TransportNamesStamp('async'),
                new AmqpStamp($action)
            ]
        );

        $this->log->info('Messege have been sent with a key: ' . $action);
        $this->bus->dispatch($envelope);
    }
}
