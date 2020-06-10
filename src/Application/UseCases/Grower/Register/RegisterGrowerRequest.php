<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\Register;

/**
 * Class RegisterGrowerRequest
 * @package App\Application\UseCases\Grower
 */
class RegisterGrowerRequest
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
    public ?string $salt = null;
    /**
     * @var array<string>
     */
    public array $role = [];

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $salt
     */
    public function setSalt(?string $salt): void
    {
        $this->salt = $salt;
    }

    /**
     * @param array<string> $role
     */
    public function setRole(array $role): void
    {
        $this->role = $role;
    }
}
