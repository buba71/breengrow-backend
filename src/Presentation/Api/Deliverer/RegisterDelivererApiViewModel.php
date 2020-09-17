<?php

declare(strict_types=1);

namespace App\Presentation\Api\Deliverer;

use App\Domain\Model\Deliverer\Deliverer;

final class RegisterDelivererApiViewModel
{
    /**
     * @var array<array>
     */
    public array $data;

    /**
     * @var array<array>
     */
    public array $delivererModel;

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
        $this->notifications['error'][$field] = $message;
        $this->data = $this->notifications;
    }

    /**
     * @param Deliverer $deliverer
     */
    public function modelTransformer(Deliverer $deliverer): void
    {
        $this->delivererModel['deliverer'] = [
            'firstName' => $deliverer->getFirstName(),
            'lastName'  => $deliverer->getLastName(),
        ];

        $this->data = $this->delivererModel;
    }
}
