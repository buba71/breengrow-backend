<?php

declare(strict_types=1);

namespace App\Tests\Domain\Services\InvoiceServices;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Domain\Model\Order\Order;
use App\Tests\Mock\Domain\InMemoryConsumerRepository;
use App\Tests\Mock\Domain\InMemoryGrowerRepository;
use App\Tests\Mock\Domain\InMemoryInvoiceRepository;
use App\Tests\Mock\SharedKernel\SystemClock\FakeClock;
use PHPUnit\Framework\TestCase;

final class InvoiceNumberGeneratorTest extends TestCase
{
    /**
     * @var InMemoryInvoiceRepository
     */
    private static InMemoryInvoiceRepository $inMemoryInvoiceRepository;
    
    /**
     * @var InMemoryConsumerRepository
     */
    private InMemoryConsumerRepository $inMemoryConsumerRepository;
    
    /**
     * @var InMemoryGrowerRepository
     */
    private InMemoryGrowerRepository $inMemoryGrowerRepository;

    public static function setupBeforeClass(): void
    {
        self::$inMemoryInvoiceRepository = new InMemoryInvoiceRepository();
    }
    
    protected function setUp(): void
    {
        $this->inMemoryConsumerRepository = new InMemoryConsumerRepository();
        $this->inMemoryGrowerRepository = new InMemoryGrowerRepository();
    }

    /**
     * @dataProvider provideInvoicesDates
     * @param FakeClock $date
     * @param int $expected
     */
    public function testInvoiceNumberGeneratedIsValid(FakeClock $date, int $expected): void
    {
        // Given an Order.
        $order = new Order('123', '123', new \DateTimeImmutable('midnight'), '123', 7);
        $order->addOrderLine('123', 5, 4.9);

        // Create invoice according with order date.
        // And the invoice number generator.
        $invoice = new Invoice(
            InvoiceNumber::generate(self::$inMemoryInvoiceRepository, $date),
            $order->getAmount(),
            $this->inMemoryConsumerRepository->getBillingAddress('123'),
            $this->inMemoryGrowerRepository->getHiveAddress('123')
        );

        // Refactoring....
        // $invoice = new Invoice(InvoiceNumber::generateNext($date), $this->order->getAmount());

        // And save to bdd.
        self::$inMemoryInvoiceRepository->addInvoice($invoice);
        $lastRecord = self::$inMemoryInvoiceRepository->getLastRecord();

        static::assertEquals($expected, $lastRecord->getNumber()->getSequenceNumber());
    }

    /**
     * @return iterable<FakeClock[]|int[]>
     */
    public function provideInvoicesDates(): iterable
    {
        $today = new FakeClock();

        $tomorrow = new FakeClock();
        $tomorrow->setFrozenOn(new \DateTimeImmutable('tomorrow'));

        $dayPlusTwo = new FakeClock();
        $dayPlusTwo->setFrozenOn(new \DateTimeImmutable('+2 DAY'));

        yield [$today, 1000];       //
        yield [$today, 1001];       //
        yield [$today, 1002];       //
        yield [$today, 1003];       // Sequence number increment along a day.
        // yield [$today, 1999];    // use case to implement.
        yield [$tomorrow, 1000];    // Sequence number get initialized on new day.
        yield [$tomorrow, 1001];
        yield [$dayPlusTwo, 1000];  // Sequence number get initialized on new day.
    }
}
