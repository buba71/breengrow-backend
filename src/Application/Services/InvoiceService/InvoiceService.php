<?php

declare(strict_types=1);

namespace App\Application\Services\InvoiceService;

use App\Domain\Model\Order\Events\OrderWasPlaced;
use App\Domain\Repository\OrderRepository;
use App\Domain\Services\InvoiceServices\CreateInvoiceFromOrder;

final class InvoiceService
{
    /**
     * @var CreateInvoiceFromOrder
     */
    private CreateInvoiceFromOrder $domainService;

    /**
     * @var OrderRepository
     */
    private OrderRepository $orderRepository;

    /**
     * InvoiceService constructor.
     * @param CreateInvoiceFromOrder $domainService
     * @param OrderRepository $orderRepository
     */
    public function __construct(CreateInvoiceFromOrder $domainService, OrderRepository $orderRepository)
    {
        $this->domainService = $domainService;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param OrderWasPlaced $orderWasPlaced
     * OrderWasPlaced Event handler
     */
    public function __invoke(OrderWasPlaced $orderWasPlaced): void
    {
        $order = $this->orderRepository->getOrderById($orderWasPlaced->getAggregateId());
        $this->domainService->execute($order);
    }
}
