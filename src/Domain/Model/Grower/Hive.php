<?php

declare(strict_types=1);

namespace App\Domain\Model\Grower;

class Hive
{
    /**
     * @var string
     */
    private string $city;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var array<Product>
     */
    private array $products = [];

    /**
     * @var string
     */
    private string $siretNumber;

    /**
     * @var string
     */
    private string $street;

    /**
     * @var string
     */
    private string $zipCode;

    public function __construct(
        string $name,
        string $siretNumber,
        string $street,
        string $city,
        string $zipCode
    ) {
        $this->name = $name;
        $this->siretNumber = $siretNumber;
        $this->street =  $street;
        $this->city = $city;
        $this->zipCode = $zipCode;
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @param float $price
     */
    public function addProduct(string $id, string $name, string $description, float $price): void
    {
        $this->products[] = new Product($id, $name, $description, $price);
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
    public function getSiretNumber(): string
    {
        return $this->siretNumber;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @return array<Product>
     */
    public function getProducts(): array
    {
        return $this->products;
    }


}
