<?php

declare(strict_types=1);

namespace App\Presentation\Api\Product\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Application\UseCases\Product\Register\RegisterProductRequest;

/**
 * Class ProductModelDto
 * @ApiResource(
 *     input=RegisterProductRequest::class,
 *     output=false
 * )
 * @package App\Presentation\Api\Product\ModelDto
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
