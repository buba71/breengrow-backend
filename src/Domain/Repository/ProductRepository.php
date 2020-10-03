<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Product\Product;

interface ProductRepository
{
    /**
     * @param Product $product
     * @return mixed
     */
    public function addProduct(Product $product);

    /**
     * @param string $id
     * @return Product|null
     */
    public function getProductById(string $id): ?Product;
}