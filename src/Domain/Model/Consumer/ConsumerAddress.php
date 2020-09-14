<?php

declare(strict_types=1);

namespace App\Domain\Model\Consumer;

/**
 * Class ConsumerAddress
 * @package App\Domain\Model\Consumer
 * Entity
 */
class ConsumerAddress
{

    /**
     * @var string
     */
    private string $firstName;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * @var string
     */
    private string $street;

    /**
     * @var string
     */
    private string $zipCode;

    /**
     * @var string
     */
    private string $city;

    /**
     * ConsumerAddress constructor.
     * @param string $firstName
     * @param string $lastName
     * @param string $street
     * @param string $zipCode
     * @param string $city
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $street,
        string $zipCode,
        string $city
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->street = $street;
        $this->zipCode = $zipCode;
        $this->city = $city;
    }


    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
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
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }
}
