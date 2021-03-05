<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\MessengerBus;

use App\Domain\Shared\Bus\DomainEvent;
use App\Domain\Shared\Bus\EventBus;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerEventBus implements EventBus
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * MessengerEventBus constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param DomainEvent $event
     */
    public function publish(DomainEvent $event): void
    {
        $this->messageBus->dispatch($event);
    }
}
