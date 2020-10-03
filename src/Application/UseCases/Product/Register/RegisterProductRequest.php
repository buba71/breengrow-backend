<?php

declare(strict_types=1);

namespace App\Application\UseCases\Product\Register;

class RegisterProductRequest
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var float
     */
    public float $price;

}