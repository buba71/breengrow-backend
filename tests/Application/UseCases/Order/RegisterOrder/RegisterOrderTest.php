<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Order\RegisterOrder;

use App\Application\Services\IdGenerator\IdGenerator;
use App\Application\UseCases\Order\Register\RegisterOrder;
use App\Application\UseCases\Order\Register\RegisterOrderPresenter;
use App\Application\UseCases\Order\Register\RegisterOrderRequest;
use App\Application\UseCases\Order\Register\RegisterOrderResponse;
use App\Domain\Model\Order\Events\OrderWasPlaced;
use App\Domain\Model\Order\Order;
use App\Infrastructure\Symfony\MessengerBus\MessengerEventBus;
use App\SharedKernel\Error\Error;
use App\Tests\Mock\Domain\InMemoryOrderRepository;
use PHPUnit\Framework\TestCase;

final class RegisterOrderTest extends TestCase
{
    private \PHPUnit\Framework\MockObject\MockObject $idGenerator;
    private InMemoryOrderRepository $repository;
    private \PHPUnit\Framework\MockObject\MockObject $presenter;
    private RegisterOrder $registerOrder;
    private RegisterOrderResponse $response;
    private \PHPUnit\Framework\MockObject\MockObject $eventBus;


    protected function setUp(): void
    {
        $this->idGenerator = $this->createMock(IdGenerator::class);
        $this->presenter = $this->getMockBuilder(RegisterOrderPresenter::class)
            ->setMethods(['present'])
            ->getMock();
        $this->eventBus = $this->getMockBuilder(MessengerEventBus::class)
            ->disableOriginalConstructor()
            ->setMethods(['publish'])
            ->getMock();
        
        $this->repository = new InMemoryOrderRepository();
        $this->response = new RegisterOrderResponse();
        $this->registerOrder = new RegisterOrder($this->idGenerator, $this->repository, $this->eventBus);
    }

    public function testIfRegisterOrderRequestIsValid(): void
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->build();
        
        $result = $this->registerOrder->checkRequest($request, $this->response);

        static::assertTrue($result);
    }

    public function testIfRegisterOrderRequestNotValid(): void
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->withoutOrderLines()->build();
        $result = $this->registerOrder->checkRequest($request, $this->response);

        static::assertFalse($result);
    }

    public function testSaveOrder(): void
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->build();
        $order = static::createOrder($request);

        // Once order is created, we need to reset events.
        $order->pullDomainEvents();

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('123456789');

        $this->registerOrder->saveOrder($request, $this->response);

        static::assertEquals($order, $this->repository->getAllOrders()[0]);
    }

    public function testResponseWhenOrderNotValid(): void
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

    public function testResponseWhenOrderIsValid(): void
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->build();
        $order = static::createOrder($request);

        // Once order is created, we need to reset events.
        $order->pullDomainEvents();



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

    public function testOrderPlacedEventIsPublished(): void
    {
        $request = RegisterOrderRequestBuilder::defaultRequest()->build();
        $order = static::createOrder($request);

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('123456789');

        $this->eventBus
            ->expects($this->once())
            ->method('publish')
            ->with(new OrderWasPlaced($order));

        $this->registerOrder->saveOrder($request, $this->response);
    }

    /**
     * @param RegisterOrderRequest $request
     * @return Order
     */
    public static function createOrder(RegisterOrderRequest $request): Order
    {
        $order =  new Order(
            $request->consumerId,
            $request->hive_siret,
            new \DateTimeImmutable('midnight'),
            $request->number,
            $request->status
        );

        foreach ($request->orderLines as $orderLine) {
            $order->addOrderLine($orderLine->productId, $orderLine->quantity, $orderLine->linePrice);
        }

        return $order;
    }
}
