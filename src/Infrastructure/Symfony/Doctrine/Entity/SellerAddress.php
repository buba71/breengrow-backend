<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SellerAddress
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 * @ORM\Embeddable()
 */
class SellerAddress
{
    /**
     * @var string
     * @ORM\Column(type="string", name="name_seller")
     */
    private string $name;

    /**
     * @var string
     * @ORM\Column(type="string", name="siret_seller")
     */
    private string $siretNumber;

    /**
     * @var string
     * @ORM\Column(type="string", name="street_seller")
     */
    private string $street;

    /**
     * @var string
     * @ORM\Column(type="string", name="zipCode_seller")
     */
    private string $zipCode;

    /**
     * @var string
     * @ORM\Column(type="string", name="city_seller")
     */
    private string $city;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSiretNumber(): string
    {
        return $this->siretNumber;
    }

    /**
     * @param string $siretNumber
     */
    public function setSiretNumber(string $siretNumber): void
    {
        $this->siretNumber = $siretNumber;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }
}
