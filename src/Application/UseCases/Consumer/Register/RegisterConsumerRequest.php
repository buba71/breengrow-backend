<?php

declare(strict_types=1);

namespace App\Application\UseCases\Consumer\Register;

use App\Presentation\Api\Consumer\Model\ConsumerAddressModel;
use App\Presentation\Api\Order\Model\OrderModel;

class RegisterConsumerRequest
{
    /**
     * @var string
     */
    public string $firstName;

    /**
     * @var string
     */
    public string $lastName;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string|null
     */
    public ?string $salt = null;
    /**
     * @var array<string>
     */
    public array $role = [];

    /**
     * @var array<ConsumerAddressModel>
     */
    public array $addresses = [];

    /**
     * @var OrderModel
     */
    public OrderModel $order;

}
