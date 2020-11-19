<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Grower\Register;

use App\Application\UseCases\Grower\Register\RegisterGrowerRequest;
use App\Presentation\Api\Grower\Model\HiveModel;

/**
 * Class RegisterGrowerRequestBuilder
 * @package App\Tests\Application\UseCases\Grower\Register
 */
final class RegisterGrowerRequestBuilder extends RegisterGrowerRequest
{
    private const FIRST_NAME = 'David';
    private const LAST_NAME = 'De Lima';
    private const EMAIL = 'buba71@gmail.com';
    private const PASSWORD = '1234azeaze';
    private const SALT = 'abcd1234';
    private const ROLES = ['GROWER_ROLE'];

    private const HIVE_NAME = 'Breengrow';
    private const HIVE_SIRET = '123456789';
    private const HIVE_STREET = '20 rue François Ducarouge';
    private const HIVE_CITY = 'Digoin';
    private const HIVE_ZIP_CODE = '71160';
    private const HIVE_PRODUCTS = [];
    private const HIVE_GEO_POINT = [48.314, 3.312];

    /**
     * @return static
     */
    public static function defaultRequest(): self
    {
        $request = new static();
        $request->firstName = self::FIRST_NAME;
        $request->lastName = self::LAST_NAME;
        $request->email = self::EMAIL;
        $request->password = self::PASSWORD;
        $request->salt = self::SALT;
        $request->role = self::ROLES;
        $request-> hive = static::createHive();

        return $request;
    }

    /**
     * @return RegisterGrowerRequest
     */
    public function build(): RegisterGrowerRequest
    {
        $request = new RegisterGrowerRequest();
        $request->firstName = $this->firstName;
        $request->lastName = $this->lastName;
        $request->email = $this->email;
        $request->password = $this->password;
        $request->salt = $this->salt;
        $request->role = $this->role;
        $request->hive = $this->hive;

        return $request;
    }

    /**
     * @return HiveModel
     */
    private static function createHive(): HiveModel
    {
        $hive = new HiveModel();
        $hive->name = self::HIVE_NAME;
        $hive->siret_number = self::HIVE_SIRET;
        $hive->street = self::HIVE_STREET;
        $hive->city = self::HIVE_CITY;
        $hive->zip_code = self::HIVE_ZIP_CODE;
        $hive->products = self::HIVE_PRODUCTS;
        $hive->geoPoint = self::HIVE_GEO_POINT;

        return $hive;
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

    /**
     * @param string $email
     * @return $this
     */
    public function withEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

}
