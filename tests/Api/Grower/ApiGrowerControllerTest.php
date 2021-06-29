<?php

declare(strict_types=1);

namespace App\Tests\Api\Grower;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Domain\Model\Grower\Grower;
use App\Infrastructure\Symfony\Doctrine\Entity\User;
use App\Infrastructure\Symfony\Doctrine\Repository\GrowerDoctrineRepository;
use App\Presentation\Api\Grower\Model\GrowerModel;
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

        $this->client->request('POST', '/api/grower/create', ['json' => $data]);

        static::assertResponseIsSuccessful();
        static::assertMatchesJsonSchema(
            '{"grower":{"id":"88caa0b8-85ca-42d3-9f12-af995cf8e380","firstName":"David","lastName":"De Lima"}}'
        );
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testShowGrower(): void
    {
        // Login user to allow loading grower information.
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
        $registeredGrower->addGrower(self::growerProvider());

        $this->client->request('GET', '/api/growers/12345');

        static::assertResponseIsSuccessful();
        static::assertMatchesJsonSchema(
            '{
            "grower":
            {
            "firstName":"John",
            "lastName":"Doe",
            "email":"test@test.com"
            },
            "hive":
            {
            "name":"Breengrow",
            "siretNumber":"8491254561",
            "street":"street test",
            "zipCode":"75000",
            "geoPoint":{"latitude":48.314,"longitude":3.412}}}'
        );
    }
    
    public function testGrowerNotFound(): void
    {
        // Given a user who request grower does not exist in Bdd.
        $response = $this->client->request('GET', '/api/growers/12345');

        $formattedResponseContent = json_decode($response->getContent(false), true);

        // Then the response status code should be 404(Throw a DomainResourceNotFoundException).
        static::assertResponseStatusCodeSame(404);
        static::assertEquals('Grower with id: 12345 not found', $formattedResponseContent['hydra:description']);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testShowAllGrowers(): void
    {
        $registeredGrower = self::$container->get(GrowerDoctrineRepository::class);

        foreach (static::growerListProvider() as $grower) {
            $registeredGrower->addGrower($grower);
        }

        $response = $this->client->request('GET', '/api/growers');

        static::assertResponseIsSuccessful();
        static::assertResponseHeaderSame('content-type', 'application/json');
        static::assertCount(3, json_decode($response->getContent(), true)['growers']);
    }

    public function testGrowersNotFound(): void
    {
        // Given a user who request growers that not exist into bdd.
        $response = $this->client->request('GET', '/api/growers');
        $formattedResponseContent = json_decode($response->getContent(false), true);

        // Then Response status code should be 404.
        static::assertResponseStatusCodeSame(404);
        static::assertEquals('Growers not found', $formattedResponseContent['hydra:description']);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testUpdateGrower(): void
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
        $registeredGrower->addGrower(self::growerProvider());

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

        $this->client->request('PUT', '/api/growers/12345', ['json' => $data]);

        static::assertResponseIsSuccessful();
        static::assertMatchesJsonSchema(
            '{
            "number of products":1,
            "products":[{"name":"fromage","description":"fromage de ch\u00e8vre","price":4.9}]
            }'
        );
    }

    /**
     * @return Grower
     */
    public static function growerProvider(): Grower
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

    /**
     * @return Grower[]
     */
    public static function growerListProvider(): array
    {
        $growerList = [];
        for ($i = 0; $i <= 2; $i++) {
            $grower =  new Grower(
                "{$i}",
                "John{$i}",
                "Doe{$i}",
                "test{$i}@test.com",
                'azeaze',
                'salt',
                ['ROLE_GROWER']
            );
            $grower->addHive(
                "Breengrow{$i}",
                "8491254561{$i}",
                "street test{$i}",
                "city test{$i}",
                '75000'
            );

            $grower->getHive()->addGeoPoint(48.314, 3.412);
            $growerList[] = $grower;
        }
        return $growerList;
    }
}
