<?php

declare(strict_types=1);

namespace App\Domain\Shared\Bus;

interface EventBus
{
    /**
     * @param DomainEvent $event
     */
    public function publish(DomainEvent $event): void;
}
