<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class GrowerModel
 * @ApiResource(
 *     input="App\Application\UseCases\Grower\Register\RegisterGrowerRequest",
 *     output=false,
 *     )
 * @package App\Presentation\Api\DTO
 */
final class GrowerModel
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
}

