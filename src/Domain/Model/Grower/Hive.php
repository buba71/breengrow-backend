<?php

declare(strict_types=1);

namespace App\Domain\Model\Grower;

class Hive
{
    private string $name;
    private string $siretNumber;
    private string $street;
    private string $city;
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
}
