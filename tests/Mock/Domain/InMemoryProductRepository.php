<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Product\Product;
use App\Domain\Repository\ProductRepository;

final class InMemoryProductRepository implements ProductRepository
{
    private array $products;

    public function __construct()
    {
        $this->products = [];
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function getProductById(string $id): ?Product
    {
        $productFounded = array_filter($this->products, fn(Product $product) => $product->getId() === $id);

        if (count($productFounded) === 1) {
            return $productFounded[0];
        }
        return null;
    }
}
