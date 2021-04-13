<?php

declare(strict_types=1);

namespace App\Tests\Api\Consumer;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Domain\Model\Consumer\Consumer;
use App\Infrastructure\Symfony\Doctrine\Entity\User;
use App\Infrastructure\Symfony\Doctrine\Repository\ConsumerDoctrineRepository;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

final class ApiConsumerControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    protected Client $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->disableReboot();
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
                    "city" => "Digoin",
                    "type"  => null
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

        static::assertResponseIsSuccessful();
        static::assertArrayHasKey('consumer', json_decode($response->getContent(), true));
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testShowConsumer(): void
    {
        // Login user to allow loading consumer information.
        $user = new User();
        $user->setEmail('johndoe@test.com');
        $user->setParentId('fakeId');
        $user->setPassword('$2y$13$awPKXaqVfbkXX9tQkgyXWeHzKdsCwdRA3pnvtGRaPuMbCUmw3luDu');
        $user->setSalt('$salt');
        $user->setRoles(['ROLE_CONSUMER']);

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

        // Register a consumer in Bdd.
        $registeredConsumer = static::$container->get(ConsumerDoctrineRepository::class);
        $registeredConsumer->addConsumer(static::consumerProvider());

        $this->client->request('GET', '/api/consumers/12345');

        static::assertResponseIsSuccessful();
        static::assertMatchesJsonSchema(
            '{
            "consumer":{"firstName":"John","lastName":"Doe","email":"test@test.com"},
            "addresses":[
            {"firstName":"john","lastName":"Doe","street":"street test","zipCode":"75000","city":"city test"}
            ]
            }'
        );
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testConsumerNotFound(): void
    {
        // Given a request that consumer does not exist.
        $response = $this->client->request('GET', '/api/consumers/12345');
        $formattedResponseContent = json_decode($response->getContent(false), true);

        // Then the response Status code should be 404.
        static::assertResponseStatusCodeSame(404);
        static::assertEquals('Consumer with id: 12345 not found', $formattedResponseContent['hydra:description']);
    }

    /**
     * @return Consumer
     */
    public static function consumerProvider(): Consumer
    {
        $consumer = new Consumer(
            '12345',
            'John',
            'Doe',
            'test@test.com',
            'azeaze',
            '$salt',
            ['ROLE_CONSUMER']
        );

        $consumer->addAddress(
            'john',
            'Doe',
            'street test',
            '75000',
            'city test',
            null
        );
        return $consumer;
    }
}

