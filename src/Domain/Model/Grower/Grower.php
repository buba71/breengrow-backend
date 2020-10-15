<?php

declare(strict_types=1);

namespace App\Domain\Model\Grower;

/**
 * Class Grower
 * @package App\Domain\Model
 * Entity
 */
class Grower
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
     * @var Hive
     */
    private Hive $hive;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var array<Product>
     */
    private array $products;

    /**
     * @var string|null
     */
    private ?string $salt;

    /**
     * @var array<string>
     */
    private array $role = [];

    /**
     * Grower constructor.
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
     * @param string $name
     * @param string $siretNumber
     * @param string $street
     * @param string $city
     * @param string $zipCode
     */
    public function addHive(string $name, string $siretNumber, string $street, string $city, string $zipCode): void
    {
        $this->hive =  new Hive($name, $siretNumber, $street, $city, $zipCode);
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
     * @return string
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
     * @return Hive
     */
    public function getHive(): Hive
    {
        return $this->hive;
    }
}
