<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Application\UseCases\Grower\Register\RegisterGrowerRequest;

/**
 * Class GrowerModelDto
 * @ApiResource(
 *     input=RegisterGrowerRequest::class,
 *     output=false
 * ),
 * @package App\Presentation\Api\Grower\ModelDto
 */
class GrowerModel
{
    /**
     * @var string
     * @ApiProperty(identifier=true)
     */
    public string $id;

    /**12
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
    public string $email;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $password;

    /**
     * @var string
     * @ApiProperty()
     */
    public string $salt;

    /**
     * @var array<string>
     * @ApiProperty()
     */
    public array $role = [];

    /**
     * @var HiveModel
     */
    public HiveModel $hive;

}
