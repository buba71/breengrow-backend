<?php

declare(strict_types=1);

namespace App\Tests\Api\Consumer;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

final class ApiConsumerControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    protected Client $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testCreateConsumer(): void
    {
        $data = [
            "firstName" => "John",
            "lastName" => "Doe",
            "email" => "johndoe@gmail.com",
            "password" => "123456",
            "salt" => "12345",
            "roles" => [],
            "addresses" => [
                [
                    "firstName" => "John",
                    "lastName" => "De Lima",
                    "street" => "20, rue François Ducarouge",
                    "zipCode" => "71160",
                    "city" => "Digoin"
                ]
            ],
            "orders" => [
                [
                    "number" => "0001",
                    "amount" => 25,
                    "status" => "ORDER_PROCESSING"
                ]
            ]
        ];

        $response = $this->client->request('POST', '/api/consumer/create', ['json' => $data]);

        static::assertEquals(201, $response->getStatusCode());
        static::assertArrayHasKey('consumer', json_decode($response->getContent(), true));
    }}
