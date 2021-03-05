<?php

declare(strict_types=1);

namespace App\SharedKernel\SystemClock;

final class SystemClock implements Clock
{

    /**
     * @return \DateTimeImmutable
     */
    public function getCurrentTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('midnight');
    }
}
