<?php

declare(strict_types=1);

namespace App\Domain\Model\Deliverer;

class Deliverer
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $email;

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
    private string $password;

    /**
     * @var string
     */
    private string $phone;

    /**
     * @var string
     */
    private string $salt;

    /**
     * @var array<string>
     */
    private array $role;

    /**
     * Deliverer constructor.
     * @param string $id
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @param string $phone
     * @param string $salt
     * @param array<string> $role
     */
    public function __construct(
        string $id,
        string $email,
        string $firstName,
        string $lastName,
        string $password,
        string $phone,
        string $salt,
        array $role
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->phone = $phone;
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
    public function getEmail(): string
    {
        return $this->email;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getSalt(): string
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

}
