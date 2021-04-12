<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\MessengerBus;

use App\Domain\Shared\Bus\DomainEvent;
use App\Domain\Shared\Bus\EventBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerEventBus implements EventBus
{
    private LoggerInterface $logger;
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * MessengerEventBus constructor.
     * @param LoggerInterface $logger
     * @param MessageBusInterface $messageBus
     */
    public function __construct(LoggerInterface $logger, MessageBusInterface $messageBus)
    {
        $this->logger = $logger;
        $this->messageBus = $messageBus;
    }

    /**
     * @param DomainEvent $event
     */
    public function publish(DomainEvent $event): void
    {
        $eventId = get_class($event);

        $this->messageBus->dispatch($event);

        $this->logger->info(sprintf('An event %s was occurred', $eventId));
    }
}
