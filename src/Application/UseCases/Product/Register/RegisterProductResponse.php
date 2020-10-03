<?php

declare(strict_types=1);

namespace App\Application\UseCases\Product\Register;

use App\Application\UseCases\RegisterResponse;
use App\Domain\Model\Product\Product;

final class RegisterProductResponse extends RegisterResponse
{
    /**
     * @var Product
     */
    private Product $product;

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

}