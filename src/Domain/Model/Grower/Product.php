<?php

declare(strict_types=1);

namespace App\Domain\Model\Grower;

use DateTimeImmutable;

class Product
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var float
     */
    private float $price;

    /**
     * Product constructor.
     * @param string $id
     * @param string $name
     * @param string $description
     * @param float $price
     */
    public function __construct(string $id, string $name, string $description, float $price)
    {
        $this->id = $id;
        $this->createdAt = new DateTimeImmutable('midnight');
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
