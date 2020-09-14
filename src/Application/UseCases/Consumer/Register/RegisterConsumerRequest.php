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

    // /**
    //  * @param string $firstName
    //  */
    // public function setFirstName(string $firstName): void
    // {
    //     $this->firstName = $firstName;
    // }

    // /**
    //  * @param string $lastName
    //  */
    // public function setLastName(string $lastName): void
    // {
    //     $this->lastName = $lastName;
    // }

    // /**
    //  * @param string $email
    //  */
    // public function setEmail(string $email): void
    // {
    //     $this->email = $email;
    // }

    // /**
    //  * @param string $password
    //  */
    // public function setPassword(string $password): void
    // {
    //     $this->password = $password;
    // }

    // /**
    //  * @param string $salt
    //  */
    // public function setSalt(string $salt): void
    // {
    //     $this->salt = $salt;
    // }

    // /**
    //  * @param array<string> $role
    //  */
    // public function setRole(array $role): void
    // {
    //     $this->role = $role;
    // }

    // /**
    //  * @param ConsumerAddressModel $address
    //  */
    // public function addAddress(ConsumerAddressModel $address): void
    // {
    //     if (!in_array($address, $this->addresses)) {
    //         $this->addresses[] = $address;
    //     }
    // }

    // /**
    //  * @param OrderModel $order
    //  */
    // public function addOrder(OrderModel $order): void
    // {
    //     if (!in_array($order, $this->orders)) {
    //         $this->orders[] = $order;
    //     }
    // }
}
