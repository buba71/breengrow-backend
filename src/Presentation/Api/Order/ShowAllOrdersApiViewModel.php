<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order;

use App\Domain\Model\Order\Order;

final class ShowAllOrdersApiViewModel
{
    /**
     * @var array<array|Order>
     */
    public array $data = [];

    /**
     * @var array[]
     */
    public array $notifications;
    /**
     * @var array[]
     */
    public array $orders;

    /**
     * @var int
     */
    public int $status;


    /**
     * @param string $field
     * @param string $message
     */
    public function addNotification(string $field, string $message): void
    {
        $this->notifications['errors'][$field] = $message;
        $this->data = $this->notifications;
    }

    /**
     * @param array<Order> $ordersModel
     */
    public function modelTransformer(array $ordersModel): void
    {
        foreach ($ordersModel as $order) {
            $orderLines = [];
            foreach ($order->getOrderLines() as $orderLine) {
                $orderLines[] = [
                    'productId' => $orderLine->getProductId(),
                    'quantity'  => $orderLine->getQuantity(),
                    'price'     => $orderLine->getLinePrice()
                ];
            }

            $this->orders['orders'][] = [
                'number'        => $order->getNumber(),
                'registeredAt'  => $order->getReceivedAt(),
                'invoiceFile'   => $order->getInvoice()->getFileName(),
                'orderlines'    => $orderLines,
                'amount'        => $order->getAmount(),
                'status'        => $order->getStatus(),
            ];
        }
        $this->data = $this->orders;
    }
}
