<?php

declare(strict_types=1);

namespace App\Presentation\Api\Consumer\Model;

use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Class ConsumerAddressModelDto
 * @package App\Presentation\Api\Consumer\Model
 */
class ConsumerAddressModel
{
    /**
     * @var string
     * @ApiProperty()
     */
    public string $firstName;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $lastName;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $street;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $zipCode;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $city;
}
