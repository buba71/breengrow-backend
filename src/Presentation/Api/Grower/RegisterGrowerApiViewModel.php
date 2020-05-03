<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower;

use App\Domain\Model\Grower\Grower;

/**
 * Class RegisterGrowerApiViewModel
 * @package App\Presentation\Api\Grower
 */
final class RegisterGrowerApiViewModel
{
    /**
     * @var array<array>
     */
    public array $data = [];

    /**
     * @var array<array>
     */
    public array $growerModel;

    /**
     * @var array<array>
     */
    public array $notifications;

    /**
     * @var int
     */
    public int $status;

    /**
     * @param string $field
     * @param string $message
     */
    public function addNotification(?string $field, string $message): void
    {
        $this->notifications['errors'][$field] = $message;
        $this->data = $this->notifications;
    }

    /**
     * @param Grower $model
     */
    public function modelTransformer(Grower $model): void
    {
        $this->growerModel['grower'] = [
            'id' => $model->getId(),
            'firstName' => $model->getFirstName(),
            'lastName'  => $model->getLastName()
        ];

        $this->data = $this->growerModel;
    }
}

