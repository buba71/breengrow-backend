<?php

declare(strict_types=1);

namespace App\Tests\Api\Grower;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class ApiGrowerControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    protected Client $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }


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
            ]
        ];

        $response = $this->client->request('POST', '/api/grower/create', ['json' => $data]);

        static::assertEquals(201, $response->getStatusCode());
        static::assertArrayHasKey('grower', json_decode($response->getContent(), true));
    }
}
