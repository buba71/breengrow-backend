<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Company
 * @ORM\Entity()
 * @package App\Infrastructure\Symfony\Doctrine
 */
final class Company
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="company_name")
     */
    private string $name;

    /**
     * @var string
     * @ORM\Column(type="string", name="siret_number")
     */
    private string $siretNumber;

    /**
     * @var string
     * @ORM\Column(type="string", name="street_address")
     */
    private string $street;

    /**
     * @var string
     * @ORM\Column(type="string", name="city_address")
     */
    private string $city;

    /**
     * @var string
     * @ORM\Column(type="string", name="zip_code")
     */
    private string $zipCode;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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
}

