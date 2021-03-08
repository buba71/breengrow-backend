<?php

declare(strict_types=1);

namespace App\Tests\Mock\SharedKernel\SystemClock;

use App\SharedKernel\SystemClock\Clock;

final class FakeClock implements Clock
{
    private \DateTimeImmutable $frozenOn;

    public function __construct()
    {
        $this->frozenOn = new \DateTimeImmutable('midnight');
    }

    public function getCurrentTime(): \DateTimeImmutable
    {
        return $this->frozenOn;
    }

    public function setFrozenOn(\DateTimeImmutable $dateTimeImmutable): self
    {
        $this->frozenOn = $dateTimeImmutable;
        return $this;
    }
}