<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Order\Order;
use App\Domain\Model\Order\OrderLine;

interface OrderRepository
{
    /**
     * @param Order $order
     * @return mixed
     */
    public function addOrder(Order $order);

    /**
     * @return mixed
     */
    public function getAllOrders();
}
