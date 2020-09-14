<?php

declare(strict_types=1);

namespace App\Presentation\Api\Consumer\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Application\UseCases\Consumer\Register\RegisterConsumerRequest;
use App\Presentation\Api\Order\Model\OrderModel;

/**
 * Class ConsumerModelDto
 * @ApiResource(
 *     input=RegisterConsumerRequest::class,
 *     output=false
 * )
 * @package App\Pesentation\Api\Consumer\ModelDto
 */
class ConsumerModel
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

    /**
     * @var array<ConsumerAddressModel>
     * @ApiProperty()
     */
    public array $addresses = [];

    /**
     * @var OrderModel|null
     * @ApiProperty()
     */
    public ?OrderModel $order;
}
