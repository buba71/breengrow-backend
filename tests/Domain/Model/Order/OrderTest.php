<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\Order;

use App\Domain\Model\Order\Order;
use PHPUnit\Framework\TestCase;

final class OrderTest extends TestCase
{
    /**
     * Check if order Model return the right amount.
     * @return void
     */
    public function testTotalAmountCalculation(): void
    {
        $order = new Order('consumerIdTest123', '845126849', new \DateTimeImmutable('midnight'), 'OrderNumber123', 7);
        $order->addOrderLine('productIdTest1', 2, 4.9);
        $order->addOrderLine('productIdTest2', 3, 10.5);

        static::assertEquals(41.3, $order->getAmount());
    }
}
