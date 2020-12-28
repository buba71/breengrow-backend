<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order;

use App\Domain\Model\Order\Order;

final class RegisterOrderApiViewModel
{
    /**
     * @var array<array>
     */
    public array $data = [];

    /**
     * @var array<array>
     */
    public array $notifications;
    /**
     * @var array<array>
     */
    public array $orderModel;

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
     * @param Order $model
     */
    public function modelTransformer(Order $model): void
    {
        $this->orderModel['order'] = [
            'order_number' => $model->getNumber(),
            'status'       => $model->getStatus(),
            'amount'       => $model->getAmount()
        ];

        $this->data = $this->orderModel;
    }
}
