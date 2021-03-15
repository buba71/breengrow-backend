<?php

declare(strict_types=1);

namespace App\Tests\Domain\Services\InvoiceServices;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Domain\Model\Order\Order;
use App\Domain\Services\InvoiceServices\CreateInvoiceFromOrder;
use App\Tests\Mock\Domain\InMemoryGrowerRepository;
use App\Tests\Mock\Domain\InMemoryInvoiceRepository;
use App\Tests\Mock\Infrastructue\Services\Export\ExportToPdfMock;
use PHPUnit\Framework\TestCase;

final class CreateInvoiceFromOrderTest extends TestCase
{
    /**
     * @var CreateInvoiceFromOrder
     */
    private CreateInvoiceFromOrder $createInvoiceFromOrder;

    private InMemoryInvoiceRepository $inMemoryInvoiceRepository;

    protected function setUp(): void
    {
        $exportDomain = new ExportToPdfMock();

        $this->inMemoryInvoiceRepository = new InMemoryInvoiceRepository();

        $this->createInvoiceFromOrder = new CreateInvoiceFromOrder(
            new InMemoryGrowerRepository(),
            $this->inMemoryInvoiceRepository,
            $exportDomain
        );
    }

    public function testIfInvoiceFromOrderIsCreated(): void
    {
        // Given an Order.
        $order = new Order('123', '123', new \DateTimeImmutable('midnight'), '123', 7);
        $order->addOrderLine('123', 2, 4.9);

        // When create the invoice according to Order from Invoice domain service.
        $invoice = $this->createInvoiceFromOrder->execute($order);
        
        // Then Invoice expected should be.
        $shouldBe = new Invoice(new InvoiceNumber(1000, new \DateTimeImmutable('midnight')), $order->getAmount());
        $shouldBe->addInvoiceLine('product description', 2, 4.9);

        static::assertEquals($shouldBe, $this->inMemoryInvoiceRepository->getLastRecord());
    }
}
