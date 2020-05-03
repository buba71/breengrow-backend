<?php

declare(strict_types=1);

namespace App\Application\Services;

interface IdGenerator
{
    /**
     * @return string
     */
    public function nextIdentity(): string;
}
