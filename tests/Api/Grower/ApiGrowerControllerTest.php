<?php

declare(strict_types=1);

namespace App\Tests\Api\Grower;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

final class ApiGrowerControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var Client
     */
    protected Client $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testCreateGrower(): void
    {
        $data = [
            "firstName" => "David",
            "lastName"  => "De Lima",
            "email"     => "buba@gmail.com",
            "password"  => "abcd1234",
            "salt"      => "abcd",
            "role"      => [
                "ROLE_GROWER"
            ],
            "hive"      => [
                "name"          => "Breengrow",
                "siret_number"  => "123456789",
                "street"        => "20 rue François Ducarouge",
                "city"          => "Digoin",
                "zip_code"       => "71160"
            ]
        ];

        $response = $this->client->request('POST', '/api/grower/create', ['json' => $data]);

        static::assertEquals(201, $response->getStatusCode());
        static::assertArrayHasKey('grower', json_decode($response->getContent(), true));
    }
}
