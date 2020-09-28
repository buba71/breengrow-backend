<?php

declare(strict_types=1);

namespace App\Application\UseCases\Deliverer\Register;

class RegisterDelivererRequest
{
    /**
     * @var string
     */
    public string $firstName;

    /**
     * @var string
     */
    public string $lastName;

    /**
     * @var string
     */
    public string $phone;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string|null
     */
    public ?string $salt = null;

    /**
     * @var array<string>
     */
    public array $role;
}
