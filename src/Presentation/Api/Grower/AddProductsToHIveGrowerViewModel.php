<?php

namespace App\Presentation\Api\Grower;

use App\Domain\Model\Grower\Grower;

class AddProductsToHIveGrowerViewModel
{
    /**
     * @var array<array>
     */
    public array $data = [];

    /**
     * @var array
     */
    public array $products;

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
    public function addNotification(string $field, string $message): void
    {
        $this->notifications['errors'][$field] = $message;
        $this->data = $this->notifications;
    }

    /**
     * @param Grower $model
     */
    public function transformModel(Grower $model): void
    {
        $productsModel = $model->getHive()->getProducts();
        $countProducts = count($productsModel);

        foreach ($productsModel as $product) {
            $this->products['products'][] = [
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice()
            ];
        }
        $this->products = array_merge(['number of products' => $countProducts], $this->products);
        $this->data = $this->products;
    }
}
