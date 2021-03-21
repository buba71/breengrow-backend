<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Grower\Grower;
use App\Domain\Model\Grower\Product;
use App\Domain\Model\Invoice\SellerAddress;
use App\Domain\Repository\GrowerRepository;

/**
 * Class InMemoryGrowerRepository
 * @package App\Tests\Mock\Domain
 */
final class InMemoryGrowerRepository implements GrowerRepository
{
    /**
     * @var Grower[]
     */
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

    // /**
    //  * @return array
    //  */
    // public function getGrowers(): array
    // {
    //     return $this->growers;
    // }

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

    /**
     * @param string $productId
     * @return Product
     */
    public function getProductHiveById(string $productId): Product
    {
        return new Product('123', new \DateTimeImmutable('midnight'), 'product test', 'product description', 4.2);
    }

    /**
     * @param Grower $grower
     * @return void
     */
    public function updateGrower(Grower $grower): void
    {
        echo 'i am on InMemory Grower repository: method "updateGrower"';
    }

    /**
     * @return Grower[]
     */
    public function getAllGrowers(): array
    {
        return $this->growers;
    }

    public function getHiveAddress(string $hiveSiret): SellerAddress
    {
        return new SellerAddress('breengrowTest', '849849849', 'street test', 'city test', '00000');
    }
}
