<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Order\RegisterOrder;

use App\Application\Services\IdGenerator;
use App\Application\UseCases\Order\Register\RegisterOrder;
use App\Application\UseCases\Order\Register\RegisterOrderPresenter;
use App\Application\UseCases\Order\Register\RegisterOrderRequest;
use App\Application\UseCases\Order\Register\RegisterOrderResponse;
use App\Domain\Model\Order\Order;
use App\SharedKernel\Error\Error;
use App\Tests\Mock\Domain\InMemoryOrderRepository;
use PHPUnit\Framework\TestCase;

final class RegisterOrderTest extends TestCase
{
    private IdGenerator $idGenerator;
    private InMemoryOrderRepository $repository;
    private RegisterOrderPresenter $presenter;
    private RegisterOrder $registerOrder;
    private RegisterOrderResponse $response;
    
    
    protected function setUp(): void
    {
        $this->idGenerator = $this->createMock(IdGenerator::class);
        $this->presenter = $this->getMockBuilder(RegisterOrderPresenter::class)
            ->setMethods(['present'])
            ->getMock();
        
        $this->repository = new InMemoryOrderRepository();
        $this->response = new RegisterOrderResponse();
        $this->registerOrder = new RegisterOrder($this->idGenerator, $this->repository);
    }

    public function testIfRegisterOrderRequestIsValid()
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->build();
        
        $result = $this->registerOrder->checkRequest($request, $this->response);

        static::assertTrue($result);
    }

    public function testIfRegisterOrderRequestNotValid()
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->withoutOrderLines()->build();
        $result = $this->registerOrder->checkRequest($request, $this->response);

        static::assertFalse($result);
    }

    public function testSaveOrder()
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->build();
        $order = static::createOrder($request);

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('123456789');

        $this->registerOrder->saveOrder($request, $this->response);

        static::assertEquals($order, $this->repository->getAllOrders()[0]);
    }

    public function testResponseWhenOrderNotValid()
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->withoutOrderLines()->build();
        
        $this->response->getNotifier()->addError(new Error('cart items', 'Your cart is empty'));
        $this->response->setStatus(RegisterOrderResponse::HTTP_BAD_REQUEST);
        
        $this->presenter
            ->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->registerOrder->execute($request, $this->presenter);
    }

    public function testResponseWhenOrderIsValid()
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->build();
        $order = static::createOrder($request);

        $this->response->setOrder($order);
        $this->response->setStatus(RegisterOrderResponse::HTTP_CREATED);

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('123456789');

        $this->presenter
            ->expects($this->once())
            ->method('present')
            ->with($this->response);
        
        $this->registerOrder->execute($request, $this->presenter);
    }

    public static function createOrder(RegisterOrderRequest $request)
    {
        $order =  new Order($request->consumerId, $request->hive_siret, new \DateTimeImmutable('midnight'), $request->number, $request->status);

        foreach ($request->orderLines as $orderLine) {
            $order->addOrderLine($orderLine->productId, $orderLine->quantity, $orderLine->linePrice);
        }

        return $order;
    }
}
