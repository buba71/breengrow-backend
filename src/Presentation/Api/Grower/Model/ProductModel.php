<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Application\UseCases\Product\Register\RegisterProductRequest;

/**
 * Class ProductModelDto
 * @package App\Presentation\Api\Product\Model
 */
class ProductModel
{
    /**
     * @var string
     * @ApiProperty()
     */
    public string $name;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $description;

    /**
     * @var float
     * @ApiProperty()
     */
    public float $price;
}
