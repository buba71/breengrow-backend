<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Grower\Product;
use App\Domain\Repository\ProductRepository;

/**
 * Class InMemoryProductRepository
 * @package App\Tests\Mock\Domain
 */
final class InMemoryProductRepository implements ProductRepository
{
    /**
     * @var Product[]
     */
    private array $products;

    /**
     * InMemoryProductRepository constructor.
     */
    public function __construct()
    {
        $this->products = [];
    }

    /**
     * @param Product $product
     * @return void
     */
    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    /**
     * @param string $id
     * @return Product|null
     */
    public function getProductById(string $id): ?Product
    {
        $productFounded = array_filter($this->products, fn(Product $product) => $product->getId() === $id);

        if (count($productFounded) === 1) {
            return $productFounded[0];
        }
        return null;
    }
}
