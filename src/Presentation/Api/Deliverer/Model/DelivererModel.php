<?php

declare(strict_types=1);

namespace App\Presentation\Api\Deliverer\Model;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Application\UseCases\Deliverer\Register\RegisterDelivererRequest;

/**
 * Class DelivererModelDto
 * @ApiResource(
 *     input=RegisterDelivererRequest::class,
 *     output=false
 * )
 * @package App\Presentation\Api\Deliverer\ModelDto
 */
class DelivererModel
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
     *@ApiProperty()
     */
    public string $phone;

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
     */
    public array $role;
}
