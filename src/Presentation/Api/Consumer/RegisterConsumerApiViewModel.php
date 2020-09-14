<?php

declare(strict_types=1);

namespace App\Presentation\Api\Consumer;

use App\Domain\Model\Consumer\Consumer;

final class RegisterConsumerApiViewModel
{
    /**
     * @var array<array>
     */
    public array $data = [];

    /**
     * @var array<array>
     */
    public array $consumerModel;

    /**
     * @var array<array>
     */
    public array $notifications;

    /**
     * @var int
     */
    public int $status;

    /**
     * @param string|null $field
     * @param string $message
     */
    public function addNotification(?string $field, string $message): void
    {
        $this->notifications['errors'][$field] = $message;
        $this->data = $this->notifications;
    }

    /**
     * @param Consumer $model
     */
    public function modelTransformer(Consumer $model): void
    {
        $this->consumerModel['consumer'] = [
            'id' => $model->getId(),
            'firstName' => $model->getFirstName(),
            'lastName'  => $model->getLastName()
        ];

        $this->data = $this->consumerModel;
    }
}
