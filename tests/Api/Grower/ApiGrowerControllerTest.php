<?php

declare(strict_types=1);

namespace App\Tests\Api\Grower;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Domain\Model\Grower\Grower;
use App\Infrastructure\Symfony\Doctrine\Entity\User;
use App\Infrastructure\Symfony\Doctrine\Repository\GrowerDoctrineRepository;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

final class ApiGrowerControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var GrowerDoctrineRepository
     */
    private GrowerDoctrineRepository $growerRepository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->disableReboot();
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
                "zip_code"       => "71160",
                "geoPoint"      => [48.285, 3.412]
            ]
        ];

        $response = $this->client->request('POST', '/api/grower/create', ['json' => $data]);

        static::assertEquals(201, $response->getStatusCode());
        static::assertArrayHasKey('grower', json_decode($response->getContent(), true));
    }

    public function testShowGrower()
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

        $registeredGrower = static::$container->get(GrowerDoctrineRepository::class);
        $registeredGrower->addGrower(self::createGrower());

        $response = $this->client->request('GET', '/api/growers/12345');


        static::assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateGrower()
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

        $registeredGrower = static::$container->get(GrowerDoctrineRepository::class);
        $registeredGrower->addGrower(self::createGrower());

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
                "zip_code"      => "71160",
                "products"      => [
                    [
                        "name"         => "fromage",
                        "description"  => "fromage de chèvre",
                        "price"        => 4.9
                    ]
                ]
            ]
        ];

        $response = $this->client->request('PUT', '/api/growers/12345', ['json' => $data]);

        static::assertEquals(200, $response->getStatusCode());
        static::assertArrayHasKey('number of products', json_decode($response->getContent(), true));
    }

    public static function createGrower()
    {
        $grower =  new Grower(
            '12345',
            'John',
            'Doe',
            'test@test.com',
            'azeaze',
            'salt',
            ['ROLE_GROWER']
        );
        $grower->addHive(
            'Breengrow',
            '8491254561',
            'street test',
            'city test',
            '75000'
        );

        $grower->getHive()->addGeoPoint(48.314, 3.412);

        return $grower;
    }
}
