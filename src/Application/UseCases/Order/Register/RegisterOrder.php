<?php

declare(strict_types=1);

namespace App\Application\UseCases\Order\Register;

use App\Application\Services\IdGenerator\IdGenerator;
use App\Domain\Model\Order\Order;
use App\Domain\Repository\OrderRepository;
use App\Domain\Shared\Bus\EventBus;
use App\SharedKernel\Error\Error;
use Assert\Assert;
use Assert\LazyAssertionException;

final class RegisterOrder
{
    /**
     * @var IdGenerator
     * @var OrderRepository
     */
    private EventBus $eventBus;
    private IdGenerator $idGenerator;
    private OrderRepository $repository;

    /**
     * RegisterOrder constructor.
     * @param IdGenerator $idGenerator
     * @param OrderRepository $repository
     * @param EventBus $eventBus
     */
    public function __construct(IdGenerator $idGenerator, OrderRepository $repository, EventBus $eventBus)
    {
        $this->idGenerator = $idGenerator;
        $this->eventBus = $eventBus;
        $this->repository = $repository;
    }

    /**
     * @param RegisterOrderRequest $request
     * @param RegisterOrderPresenter $presenter
     */
    public function execute(RegisterOrderRequest $request, RegisterOrderPresenter $presenter): void
    {
        $response = new RegisterOrderResponse();

        $isValid = $this->checkRequest($request, $response);

        if ($isValid) {
            $this->saveOrder($request, $response);
            $response->setStatus(RegisterOrderResponse::HTTP_CREATED);
        } else {
            $response->setStatus(RegisterOrderResponse::HTTP_BAD_REQUEST);
        }

        $presenter->present($response);
    }


    /**
     * @param RegisterOrderRequest $request
     * @param RegisterOrderResponse $response
     * @return bool
     */
    public function checkRequest(RegisterOrderRequest $request, RegisterOrderResponse $response): bool
    {
        try {
            Assert::lazy()
                ->that($request->consumerId, 'consumerId')->uuid('A uuid error has occured ')
                ->that($request->orderLines, 'cart items')->minCount(1, 'Your cart is empty')
                ->verifyNow();
            return true;
        } catch (LazyAssertionException $exception) {
            foreach ($exception->getErrorExceptions() as $error) {
                $response->addError(new Error($error->getPropertyPath(), $error->getMessage()));
            }
            return false;
        }
    }

    /**
     * @param RegisterOrderRequest $request
     * @param RegisterOrderResponse $response
     */
    public function saveOrder(RegisterOrderRequest $request, RegisterOrderResponse $response): void
    {
        $order = new Order(
            $request->consumerId,
            $request->hive_siret,
            new \DateTimeImmutable('midnight'),
            $this->idGenerator->nextIdentity(),
            Order::ORDER_PENDING
        );

        foreach ($request->orderLines as $orderLine) {
            $order->addOrderLine($orderLine->productId, $orderLine->quantity, $orderLine->linePrice);
        }

        $this->repository->addOrder($order);

        // Publish events on message bus.
        $this->eventBus->publish(...$order->pullDomainEvents());
        $response->setOrder($order);
    }
}
