<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Order\Show;

use App\Application\Services\OrdersLoader\AllOrdersProvider;
use App\Application\Services\OrdersLoader\ConsumerOrdersProvider;
use App\Application\Services\OrdersLoader\HiveOrdersProvider;
use App\Application\UseCases\Order\ShowAllOrders\ShowAllOrders;
use App\Application\UseCases\Order\ShowAllOrders\ShowAllOrdersPresenter;
use App\Application\UseCases\Order\ShowAllOrders\ShowAllOrdersResponse;
use App\Domain\Model\Order\Order;
use App\Tests\Mock\Domain\InMemoryOrderRepository;
use PHPUnit\Framework\TestCase;

final class ShowAllOrdersTest extends TestCase
{
    /**
     * @var ShowAllOrdersPresenter|\PHPUnit\Framework\MockObject\MockObject
     */
    private $presenter;
    
    /**
     * @var InMemoryOrderRepository
     */
    private InMemoryOrderRepository $repository;
    
    /**
     * @var ShowAllOrdersResponse
     */
    private ShowAllOrdersResponse $response;
    
    /**
     * @var ShowAllOrders
     */
    private ShowAllOrders $showAllOrdersUseCase;

    public function setUp(): void
    {
        $this->presenter = $this->getMockBuilder(ShowAllOrdersPresenter::class)
            ->setMethods(['present'])
            ->getMock();
        $this->repository = new InMemoryOrderRepository();
        $this->response = new ShowAllOrdersResponse();

        $this->showAllOrdersUseCase = new ShowAllOrders(
            new HiveOrdersProvider($this->repository),
            new ConsumerOrdersProvider($this->repository),
            new AllOrdersProvider($this->repository)
        );

        // First register orders List into Inmemory Bdd.
        $ordersList = static::createOrders();

        foreach ($ordersList as $order) {
            $this->repository->addOrder($order);
        }
    }


    /**
     * @dataProvider provideRequestFilters
     * @param array $requestFilters
     * @param array $orderListFiltered
     * If request contains filter, use case should return the valid order list(ordersByHive, ordersByConsumer).
     */
    public function testIfReturnValidOrderList(array $requestFilters, array $orderListFiltered)
    {
        // The response should be.
        $this->response->setOrders($orderListFiltered);
        $this->response->setStatus(200);

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->showAllOrdersUseCase->execute($requestFilters, $this->presenter);
    }

    /**
     * Use case should return all orders if request does not contain any filter.
     */
    public function testIfReturnAllOrdersList()
    {
        // Given request filters = null.
        $requestFilters = [];

        $orderListFiltered = $this->repository->getAllOrders();

        // The response should be.
        $this->response->setOrders($orderListFiltered);
        $this->response->setStatus(200);

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->showAllOrdersUseCase->execute($requestFilters, $this->presenter);
    }

    public static function createOrders()
    {
        $orders = [];

        for ($i = 0; $i <= 5; $i++) {
            $order = new Order(
                "consumerId{$i}",
                "hiveSiret{$i}",
                new \DateTimeImmutable('midnight'),
                "{$i}",
                7
            );
            $orders[] = $order;
        }
        return $orders;
    }

    /**
     * @return string[][][]
     */
    public function provideRequestFilters()
    {
        $orderListFiltered = [new Order('consumerId0', 'hiveSiret0', new \DateTimeImmutable('midnight'), '0', 7)];

        return [
            [
                ['hiveSiret' => 'hiveSiret0'], $orderListFiltered
            ],
            [
                ['consumerId' => 'consumerId0'], $orderListFiltered
            ]
        ];
    }
}
