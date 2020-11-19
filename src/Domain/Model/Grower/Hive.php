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
     * @var GeoPoint
     */
    private GeoPoint $geoPoint;

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
     * @param float $latitude
     * @param float $longitude
     */
    public function addGeoPoint(float $latitude, float $longitude): void
    {
        $this->geoPoint = new GeoPoint($latitude, $longitude);
    }

    /**
     * @param string $id
     * @param \DateTimeImmutable $createdAt
     * @param string $name
     * @param string $description
     * @param float $price
     */
    public function addProduct(
        string $id,
        \DateTimeImmutable $createdAt,
        string $name,
        string $description,
        float $price
    ): void {
        $this->products[] = new Product($id, $createdAt, $name, $description, $price);
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

    /**
     * @return GeoPoint
     */
    public function getGeoPoint(): GeoPoint
    {
        return $this->geoPoint;
    }
}
