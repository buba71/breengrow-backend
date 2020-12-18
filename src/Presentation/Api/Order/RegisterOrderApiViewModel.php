<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order;

use App\Domain\Model\Order\Order;

final class RegisterOrderApiViewModel
{
    public array $data = [];
    public array $notifications;
    public array $orderModel;
    public int $status;


    public function addNotification(string $field, string $message)
    {
        $this->notifications['errors'][$field] = $message;
        $this->data = $this->notifications;
    }

    public function modelTransformer(Order $model)
    {
        $this->orderModel['order'] = [
            'order_number' => $model->getNumber(),
            'status'       => $model->getStatus(),
            'amount'       => $model->getAmount()
        ];

        $this->data[] = $this->orderModel;
    }
}
