<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ConsumerAddress
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 * @ORM\Entity()
 */
class ConsumerAddress
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="first_name")
     */
    private string $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", name="last_name")
     */
    private string $lastName;

    /**
     * @var Consumer
     * @ORM\ManyToOne(targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\Consumer", inversedBy="consumerAddresses")
     * @ORM\JoinColumn(nullable=false, name="consumer_id", referencedColumnName="identifier")
     */
    private Consumer $consumer;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $street;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $zipCode;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $city;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Consumer
     */
    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }

    /**
     * @param Consumer $consumer
     */
    public function setConsumer(Consumer $consumer): void
    {
        $this->consumer = $consumer;
    }

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
