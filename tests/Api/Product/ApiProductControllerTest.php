<?php

declare(strict_types=1);

namespace App\Tests\Api\Product;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Infrastructure\Symfony\Doctrine\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class ApiProductControllerTest
 * @package App\Tests\Api\Product
 */
final class ApiProductControllerTest extends ApiTestCase
{
     use RefreshDatabaseTrait;

    /**
     * @var Client
     */
    private Client $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->disableReboot();
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testCreateProduct(): void
    {
        $user = new User();
        $user->setEmail('johndoe@test.com');
        $user->setParentId('fakeId');
        $user->setPassword('$2y$13$awPKXaqVfbkXX9tQkgyXWeHzKdsCwdRA3pnvtGRaPuMbCUmw3luDu');
        $user->setSalt('$salt');
        $user->setRoles(['ROLE_GROWER']);

        $entityManager = self::$container->get('doctrine')->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // user log in api as grower.
        $this->client->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json'    => [
                'email'    => 'johndoe@test.com',
                'password' => 'azeaze'
            ]
        ]);

        $data = [
            "name"        => "product name",
            "description" => "some description",
            "price"       => 15.10
        ];

        // Then grower create a new product.
        $response = $this->client->request('POST', '/api/products', ['json' => $data]);

        static::assertEquals(201, $response->getStatusCode());
        static::assertArrayHasKey('product', json_decode($response->getContent(), true));
    }
}
