<?php

declare(strict_types=1);

namespace App\Presentation\Api\Consumer;

use App\Domain\Model\Consumer\Consumer;

final class ShowConsumerApiViewModel
{
    /**
     * @var array[]
     */
    public array $data = [];

    /**
     * @var array[]
     */
    public array $consumerModel;

    /**
     * @var array[]
     */
    public array $addressesModel;

    /**
     * @var int
     */
    public int $status;

    /**
     * @param Consumer $consumerModel
     */
    public function transformModel(Consumer $consumerModel): void
    {
        foreach ($consumerModel->getAddresses() as $addressModel) {
            $this->addressesModel['addresses'][] = [
                'firstName' => $addressModel->getFirstName(),
                'lastName'  => $addressModel->getLastName(),
                'street'    => $addressModel->getStreet(),
                'zipCode'   => $addressModel->getZipCode(),
                'city'      => $addressModel->getCity()

            ];
        }

        $this->consumerModel['consumer'] = [
            'firstName' => $consumerModel->getFirstName(),
            'lastName'  => $consumerModel->getLastName(),
            'email'     => $consumerModel->getEmail()
        ];

        $this->data = array_merge($this->consumerModel, $this->addressesModel);
    }
}
