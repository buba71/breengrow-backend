<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Consumer\Register;

use App\Application\UseCases\Consumer\Register\RegisterConsumerRequest;
use App\Presentation\Api\Consumer\Model\ConsumerAddressModel;
use App\Presentation\Api\Order\Model\OrderModel;

/**
 * Class RegisterConsumerRequestBuilder
 * @package App\Tests\Application\UseCases\Consumer\Register
 */
final class RegisterConsumerRequestBuilder extends RegisterConsumerRequest
{
    private const FIRST_NAME = 'David';
    private const LAST_NAME = 'De Lima';
    private const EMAIL = 'davdelima71@gmail.com';
    private const PASSWORD = '1234azeaze';
    private const SALT = 'abcd1234';
    private const ROLES = ['CONSUMER_ROLE'];

    /**
     * @return self
     */
    public static function defaultRequest(): self
    {
        $request = new static();
        $request->firstName = self::FIRST_NAME;
        $request->lastName = self::LAST_NAME;
        $request->email = self::EMAIL;
        $request->password = self::PASSWORD;
        $request->salt = self::SALT;
        $request->role = self::ROLES;
        $request->addresses[] = self::defaultAddress();
        $request->order = self::defaultOrder();

        return $request;
    }

    /**
     * @return ConsumerAddressModel
     */
    public static function defaultAddress(): ConsumerAddressModel
    {
        $address = new ConsumerAddressModel();
        $address->firstName = 'David';
        $address->lastName = 'De Lima';
        $address->street = '20, rue François Ducarouge';
        $address->city = 'Digoin';
        $address->zipCode = '71160';

        return $address;
    }

    /**
     * @return OrderModel
     */
    public static function defaultOrder(): OrderModel
    {
        $order = new OrderModel();
        $order->amount = 25;
        $order->number = '12345';
        $order->status = 4;

        return $order;
    }

    /**
     * @return RegisterConsumerRequest
     */
    public function build(): RegisterConsumerRequest
    {
        $request = new RegisterConsumerRequest();
        $request->firstName = $this->firstName;
        $request->lastName = $this->lastName;
        $request->email = $this->email;
        $request->password = $this->password;
        $request->salt = $this->salt;
        $request->role = $this->role;
        $request->addresses = $this->addresses;
        $request->order = $this->order;

        return $request;
    }

    /**
     * @param string $firstName
     * @return self
     */
    public function withFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }
}