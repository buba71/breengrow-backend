<?php

declare(strict_types=1);

namespace App\Tests\Api\Deliverer;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

final class ApiDelivererControllerTest extends ApiTestCase
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
    public function testCreateDeliverer(): void
    {
        $data = [
            "firstName" => "David",
            "lastName"  => "De Lima",
            "phone"     => "0662154878",
            "email"     => "test@sfr.fr",
            "password"  => "azeaze",
            "salt"      => "",
            "role"      => [
                "ROLE_DELIVERER"
            ]
        ];

        $response = $this->client->request('POST', '/api/deliverers', ['json' => $data]);

        static::assertEquals(201, $response->getStatusCode());
        static::assertArrayHasKey('deliverer', json_decode($response->getContent(), true));
    }
}
