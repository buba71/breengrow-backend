<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Grower\Grower;
use App\Domain\Model\Grower\Product;
use App\Domain\Model\Invoice\SellerAddress;

interface GrowerRepository
{
    /**
     * @param Grower $grower
     * @return mixed
     */
    public function addGrower(Grower $grower);


    /**
     * @return array<Grower>
     */
    public function getAllGrowers(): array;

    /**
     * @param string $id
     * @return Grower|null
     */
    public function getGrowerById(string $id): ?Grower;

    /**
     * @param string $email
     * @return mixed
     */
    public function getGrowerByEmail(string $email);

    /**
     * @param string $productId
     * @return Product
     */
    public function getProductHiveById(string $productId): Product;

    /**
     * @param Grower $grower
     * @return mixed
     */
    public function updateGrower(Grower $grower);

    /**
     * @param string $hiveSiret
     * @return SellerAddress
     */
    public function getHiveAddress(string $hiveSiret): SellerAddress;
}