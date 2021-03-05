<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Deliverer\Register;

use App\Application\UseCases\Deliverer\Register\RegisterDelivererRequest;

final class RegisterDelivererRequestBuilder extends RegisterDelivererRequest
{
    private const EMAIL = 'buba@sfr.fr';
    private const FIRST_NAME = 'David';
    private const LAST_NAME = 'De Lima';
    private const PHONE_NUMBER = '0662255276';
    private const PASSWORD = 'azeaze';
    private const SALT = 'abcd1234';
    private const ROLE = ['ROLE_DELIVERER'];

    /**
     * @return self
     */
    public static function defaultRequest(): self
    {
        $request = new static();
        $request->email = self::EMAIL;
        $request->firstName = self::FIRST_NAME;
        $request->lastName = self::LAST_NAME;
        $request->phone = self::PHONE_NUMBER;
        $request->password = self::PASSWORD;
        $request->salt = self::SALT;
        $request->role = self::ROLE;

        return $request;
    }

    /**
     * @return RegisterDelivererRequest
     */
    public function build(): RegisterDelivererRequest
    {
        $request = new RegisterDelivererRequest();
        $request->email = $this->email;
        $request->firstName = $this->firstName;
        $request->lastName = $this->lastName;
        $request->phone = $this->phone;
        $request->password = $this->password;
        $request->salt = $this->salt;
        $request->role = $this->role;

        return $request;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function withFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }
}
