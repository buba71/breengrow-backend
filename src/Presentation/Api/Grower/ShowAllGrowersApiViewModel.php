<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower;

use App\Domain\Model\Grower\Grower;

final class ShowAllGrowersApiViewModel
{
    /**
     * @var array<array>
     */
    public array $data;

    /**
     * @var array<array>
     */
    public array $growers;

    /**
     * @var int
     */
    public int $status;

    /**
     * @param array<Grower> $growersModel
     */
    public function transformModel(array $growersModel): void
    {
        foreach ($growersModel as $grower) {
            $products = [];
            foreach ($grower->getHive()->getProducts() as $product) {
                $products[] = [
                    'name' => $product->getName(),
                    'description' => $product->getDescription(),
                    'price' => $product->getPrice()
                ];
            }

            $this->growers['growers'][] = [
                'id'        => $grower->getId(),
                'firstName' => $grower->getFirstName(),
                'lastName'  => $grower->getLastName(),
                'email'     => $grower->getEmail(),
                'company_name'          => $grower->getHive()->getName(),
                'siretNumber'   => $grower->getHive()->getSiretNumber(),
                'street'        => $grower->getHive()->getStreet(),
                'zipCode'       => $grower->getHive()->getZipCode(),
                'city'          => $grower->getHive()->getCity(),
                'products'      => $products,
                'geoPoint'      => [
                    'latitude' => $grower->getHive()->getGeoPoint()->getLatitude(),
                    'longitude' => $grower->getHive()->getGeoPoint()->getLongitude()
                ]
            ];
        }
        
        $this->data = $this->growers;
    }
}
