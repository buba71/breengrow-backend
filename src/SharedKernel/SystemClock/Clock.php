<?php

declare(strict_types=1);

namespace App\SharedKernel\SystemClock;

interface Clock
{
    /**
     * @return \DateTimeImmutable
     */
    public function getCurrentTime(): \DateTimeImmutable;
}
