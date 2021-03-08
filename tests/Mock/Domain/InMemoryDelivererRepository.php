<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Deliverer\Deliverer;
use App\Domain\Repository\DelivererRepository;

final class InMemoryDelivererRepository implements DelivererRepository
{
    /**
     * @var Deliverer[]
     */
    private array $deliverers = [];

    /**
     * @param Deliverer $deliverer
     * @return void
     */
    public function addDeliverer(Deliverer $deliverer): void
    {
        $this->deliverers[] = $deliverer;
    }

    /**
     * @param string $id
     * @return Deliverer|null
     */
    public function getDelivererById(string $id): ?Deliverer
    {
        $delivererFound = array_filter($this->deliverers, fn($deliverer) => $deliverer->getId() === $id);

        if (count($delivererFound) === 1) {
            return $delivererFound[0];
        }
        return null;
    }

    /**
     * @param string $email
     * @return Deliverer|null
     */
    public function getDelivererByEmail(string $email): ?Deliverer
    {
        $delivererFound = array_filter($this->deliverers, fn($deliverer) => $deliverer->getEmail() === $email);

        if (count($delivererFound) === 1) {
            return $delivererFound[0];
        }

        return null;
    }
}
