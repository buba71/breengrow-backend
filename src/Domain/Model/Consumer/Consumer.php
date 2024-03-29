<?php

declare(strict_types=1);

namespace App\Domain\Model\Consumer;

use App\Domain\Shared\Aggregate\AggregateRoot;

/**
 * Class Consumer
 * @package App\Domain\Model\Consumer
 * Entity
 */
class Consumer extends AggregateRoot
{
    /**
     * @var string
     */
    private string $id;

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
    private string $email;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string|null
     */
    private ?string $salt = null;

    /**
     * @var array<string>
     */
    private array $role;

    /**
     * @var array<ConsumerAddress>
     */
    private array $addresses;

    /**
     * Consumer constructor.
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string|null $salt
     * @param array<string> $role
     */
    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        ?string $salt,
        array $role
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->salt = $salt;
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @return array<string>
     */
    public function getRole(): array
    {
        return $this->role;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $street
     * @param string $zipCode
     * @param string $city
     * @param string|null $type
     */
    public function addAddress(
        string $firstName,
        string $lastName,
        string $street,
        string $zipCode,
        string $city,
        ?string $type
    ): void {
        $this->addresses[] = new ConsumerAddress($firstName, $lastName, $street, $zipCode, $city, $type);
    }

    /**
     * @return array<ConsumerAddress>
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }
}
