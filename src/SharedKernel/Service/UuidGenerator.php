<?php

declare(strict_types=1);

namespace App\SharedKernel\Service;

use Ramsey\Uuid\Uuid;
use App\Application\Services\IdGenerator;

/**
 * Class IdGenerator
 * @package App\SharedKernel
 */
class UuidGenerator implements IdGenerator
{
    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }
}
