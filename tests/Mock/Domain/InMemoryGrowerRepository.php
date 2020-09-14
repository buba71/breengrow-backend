<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Grower\Grower;
use App\Domain\Repository\GrowerRepository;

class InMemoryGrowerRepository implements GrowerRepository
{
    private array $growers = [];

    /**
     * @param Grower $user
     */
    public function addGrower(Grower $user): void
    {
        $this->growers[] = $user;

    }

    /**
     * @param string $id
     * @return Grower|null
     */
    public function getGrowerById(string $id): ?Grower
    {
        $growerFound = array_filter($this->growers, fn(Grower $grower) => $grower->getId() === $id);

        if (count($growerFound) === 1) {
            return $growerFound[0];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getGrowers(): array
    {
        return $this->growers;
    }

    /**
     * @param string $email
     * @return Grower|null
     */
    public function getGrowerByEmail(string $email): ?Grower
    {
        $growerFound = array_filter($this->growers, fn(Grower $grower) => $grower->getEmail() === $email);

        if (count($growerFound) === 1) {
            return $growerFound[0];
        }
        return null;
    }
}
