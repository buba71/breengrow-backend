<?php

declare(strict_types=1);

namespace App\Presentation\Api\Product;

use App\Domain\Model\Product\Product;

final class RegisterProductApiViewModel
{
    /**
     * @var array<array>
     */
    public array $data = [];

    /**
     * @var array<array>
     */
    public array $product = [];

    /**
     * @var array<array>
     */
    public array $notifications = [];

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
     * @param Product $product
     */
    public function modelTransformer(Product $product): void
    {
        $this->product['product'] = [
            'id'          => $product->getId(),
            'createdAt'   => $product->getCreatedAt()->format('d-m-Y H:i:s'),
            'name'        => $product->getName(),
            'description' => $product->getDescription(),
            'price'       => $product->getPrice()
        ];

        $this->data = $this->product;
    }
}
