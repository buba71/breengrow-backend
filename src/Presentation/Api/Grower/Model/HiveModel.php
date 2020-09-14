<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower\Model;

use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Class Hive
 * @package App\Presentation\Api\Grower\Model
 */
class HiveModel
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
    public string $siret_number;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $street;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $city;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $zip_code;
}
