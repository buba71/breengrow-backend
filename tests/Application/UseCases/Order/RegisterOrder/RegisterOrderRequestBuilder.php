<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Order\RegisterOrder;

use App\Application\UseCases\Order\Register\RegisterOrderRequest;
use App\Presentation\Api\Order\Model\OrderLine;

class RegisterOrderRequestBuilder extends RegisterOrderRequest
{
    private const CONSUMER_ID = '14c72359-f051-4681-a8a1-67037c6340df';
    private const ORDER_NUMBER = '123456789';
    private const ORDER_STATUS = 7;

    public static function defaultRequest()
    {
        $request = new self();
        $request->number = self::ORDER_NUMBER;
        $request->consumerId = self::CONSUMER_ID;
        $request->status = self::ORDER_STATUS;
        $request->orderLines = self::createOrderLine();

        return $request;
    }

    public function build()
    {
        $request = new self();
        $request->number = $this->number;
        $request->consumerId = $this->consumerId;
        $request->status = $this->status;
        $request->orderLines = $this->orderLines;

        return $request;
    }

    private static function createOrderLine()
    {
        $orderLine = new OrderLine();
        $orderLine->productId = '123456789';
        $orderLine->quantity = 1;
        $orderLine->linePrice = 1.99;

        return [$orderLine];
    }

    public function withoutOrderLines()
    {
        $this->orderLines = [];
        return $this;
    }
}
