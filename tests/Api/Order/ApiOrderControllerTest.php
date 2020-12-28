<?php

declare(strict_types=1);

namespace App\Tests\Api\Order;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

final class ApiOrderControllerTest extends ApiTestCase
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
    public function testRegisterOrder()
    {
        $data = [
            "consumerId" => "14c72359-f051-4681-a8a1-67037c6340df",
            "orderLines" => [
                [
                    "productId" => "1",
                    "quantity"  => 2,
                    "linePrice" => 4.90
                ]
            ]
        ];
        $response = $this->client->request('POST', '/api/orders', ['json' => $data]);

        static::assertResponseIsSuccessful();
        static::assertArrayHasKey('order', json_decode($response->getContent(), true));
    }
}
