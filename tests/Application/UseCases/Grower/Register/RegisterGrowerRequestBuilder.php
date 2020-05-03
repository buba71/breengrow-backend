<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Grower\Register;

use App\Application\UseCases\Grower\Register\RegisterGrowerRequest;

final class RegisterGrowerRequestBuilder extends RegisterGrowerRequest
{
    private const FIRST_NAME = 'David';
    private const LAST_NAME = 'De Lima';
    private const EMAIL = 'buba71@gmail.com';
    private const PASSWORD = '1234azeaze';
    private const SALT = 'abcd1234';
    private const ROLES = ['GROWER_ROLE'];

    public static function defaultRequest(): self
    {
        $request = new static();
        $request->setFirstName(self::FIRST_NAME);
        $request->setLastName(self::LAST_NAME);
        $request->setEmail(self::EMAIL);
        $request->setPassword(self::PASSWORD);
        $request->setSalt(self::SALT);
        $request->setRole(self::ROLES);

        return $request;
    }

    public function build(): RegisterGrowerRequest
    {
        $request = new RegisterGrowerRequest();
        $request->setFirstName($this->firstName);
        $request->setLastName($this->lastName);
        $request->setEmail($this->email);
        $request->setPassword($this->password);
        $request->setSalt($this->salt);
        $request->setRole($this->role);

        return $request;
    }

    public function withFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function withEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

}
