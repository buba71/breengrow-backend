<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Order\RegisterOrder;

use App\Application\UseCases\Order\Register\RegisterOrderRequest;
use App\Presentation\Api\Order\Model\OrderLine;

final class RegisterOrderRequestBuilder extends RegisterOrderRequest
{
    private const CONSUMER_ID = '14c72359-f051-4681-a8a1-67037c6340df';
    private const HIVE_SIRET = '8495461236';
    private const ORDER_NUMBER = '123456789';
    private const ORDER_STATUS = 7;

    /**
     * @return self
     */
    public static function defaultRequest(): self
    {
        $request = new self();
        $request->number = self::ORDER_NUMBER;
        $request->consumerId = self::CONSUMER_ID;
        $request->hive_siret = self::HIVE_SIRET;
        $request->status = self::ORDER_STATUS;
        $request->orderLines = self::createOrderLine();

        return $request;
    }

    /**
     * @return self
     */
    public function build(): self
    {
        $request = new self();
        $request->number = $this->number;
        $request->consumerId = $this->consumerId;
        $request->hive_siret = $this->hive_siret;
        $request->status = $this->status;
        $request->orderLines = $this->orderLines;

        return $request;
    }

    /**
     * @return OrderLine[]
     */
    private static function createOrderLine(): array
    {
        $orderLine = new OrderLine();
        $orderLine->productId = '123456789';
        $orderLine->quantity = 1;
        $orderLine->linePrice = 1.99;

        return [$orderLine];
    }

    /**
     * @return self
     */
    public function withoutOrderLines(): self
    {
        $this->orderLines = [];
        return $this;
    }
}
