<?php

declare(strict_types=1);

namespace App\Tests\Api\Order;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Domain\Model\Order\Order;
use App\Infrastructure\Symfony\Doctrine\Repository\OrderDoctrineRepository;
use App\Tests\Mock\Domain\ModelProviders\InvoiceProvider;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

final class ApiOrderControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var OrderDoctrineRepository|object|null
     */
    private $orderRepository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->orderRepository = static::$container->get(OrderDoctrineRepository::class);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testRegisterOrder(): void
    {
        $dataOrder = [
            "consumerId" => "14c72359-f051-4681-a8a1-67037c6340df",
            "hive_siret" => "849512624",
            "orderLines" => [
                [
                    "productId" => "1",
                    "quantity"  => 2,
                    "linePrice" => 4.90
                ]
            ]
        ];

        $response = $this->client->request('POST', '/api/orders', ['json' => $dataOrder]);

        // $transport = self::$container->get('messenger.transport.sync');
        // dd($transport);

        static::assertResponseIsSuccessful();
        static::assertArrayHasKey('order', json_decode($response->getContent(), true));
    }
    
    public function testOrdersNotFound(): void
    {
        $response = $this->client->request('GET', '/api/orders');
        $formattedResponse = json_decode($response->getContent(false), true);

        static::assertResponseStatusCodeSame(404);
        static::assertEquals('no orders found', $formattedResponse['errors']['orders']);
    }
    
    public function testShowAllOrdersOfConsumer(): void
    {
        foreach (self::orderListProvider() as $order) {
            $this->orderRepository->addOrder($order);
            $this->orderRepository->update($order);  // Update order with invoice.
        }

        $response = $this->client->request('GET', '/api/orders?consumerId=1230');
        
        static::assertResponseIsSuccessful();
        static::assertArrayHasKey('orders', json_decode($response->getContent(), true));
    }

    public function testShowAllOrdersOfHive(): void
    {
        foreach (self::orderListProvider() as $order) {
            $this->orderRepository->addOrder($order);
            $this->orderRepository->update($order);  // Update order with invoice.
        }

        $response = $this->client->request('GET', '/api/orders?hiveSiret=8400');

        static::assertResponseIsSuccessful();
        static::assertArrayHasKey('orders', json_decode($response->getContent(), true));
    }

    /**
     * @return Order[]
     */
    public static function orderListProvider(): array
    {
        $orders = [];
        for ($i = 0; $i <= 4; $i++) {
            $order = new Order(
                "123{$i}",
                "840{$i}",
                new \DateTimeImmutable('midnight'),
                "123{$i}",
                7
            );
            $order->addOrderLine('123', 1, 2.2);
            $order->joinInvoice(InvoiceProvider::provideInvoice($i));
            $orders[] = $order;
        }

        return $orders;
    }
}
