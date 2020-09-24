<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Deliverer\Deliverer;
use App\Domain\Repository\DelivererRepository;

final class InMemoryDelivererRepository implements DelivererRepository
{
    private array $deliverers;

    public function __construct()
    {
        $this->deliverers = [];
    }

    public function addDeliverer(Deliverer $deliverer)
    {
        $this->deliverers[] = $deliverer;
    }

    public function getDelivererById(string $id): ?Deliverer
    {
        $delivererFound = array_filter($this->deliverers, fn($deliverer) => $deliverer->getId() === $id);

        if (count($delivererFound) === 1) {
            return $delivererFound[0];
        }
        return null;
    }

    public function getDelivererByEmail(string $email): ?Deliverer
    {
        $delivererFound = array_filter($this->deliverers, fn($deliverer) => $deliverer->getEmail() === $email);

        if (count($delivererFound) === 1) {
            return $delivererFound[0];
        }

        return null;
    }
}
