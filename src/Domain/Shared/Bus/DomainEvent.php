<?php

declare(strict_types=1);

namespace App\Domain\Shared\Bus;

interface DomainEvent
{
    /**
     * @return string
     */
    public function getAggregateId(): string;

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn(): \DateTimeImmutable;
}
