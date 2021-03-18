<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class BillingAddress
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 * @ORM\Embeddable()
 */
class BillingAddress implements DoctrineEntity
{
    /**
     * @var string
     * @ORM\Column(type="string", name="customer_firstName")
     */
    private string $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", name="customer_lastName")
     */
    private string $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", name="customer_street")
     */
    private string $street;

    /**
     * @var string
     * @ORM\Column(type="string", name="customer_zipCode")
     */
    private string $zipCode;

    /**
     * @var string
     * @ORM\Column(type="string", name="customer_city")
     */
    private string $city;

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
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