<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower;

use App\Domain\Model\Grower\Grower;

final class ShowGrowerApiViewModel
{
    /**
     * @var array<array>
     */
    public array $data = [];

    /**
     * @var array<array>
     */
    public array $growerModel = [];

    /**
     * @var array<array>
     */
    public array $hiveModel = [];

    /**
     * @var array<array>
     */
    public array $productsModel = [];

    /**
     * @var int
     */
    public int $status;


    /**
     * @param Grower $model
     * @return array<array>
     */
    public function transformModel(Grower $model): array
    {

        $this->growerModel['grower'] = [
            'firstName' => $model->getFirstName(),
            'lastName'  => $model->getLastName(),
            'email'     => $model->getEmail(),
        ];

        $this->hiveModel['hive'] = [
            'name'          => $model->getHive()->getName(),
            'siretNumber'   => $model->getHive()->getSiretNumber(),
            'street'        => $model->getHive()->getStreet(),
            'zipCode'       => $model->getHive()->getZipCode()
        ];

        foreach ($model->getHive()->getProducts() as $product) {
            $this->productsModel['products'][] = [
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice()
            ];
        }

        $this->data = array_merge($this->growerModel, $this->hiveModel, $this->productsModel);
        return $this->data;
    }
}
