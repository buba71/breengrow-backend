<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Grower\AddProducts;

use App\Application\UseCases\Grower\AddProducts\AddProductsToHiveGrowerRequest;
use App\Presentation\Api\Grower\Model\HiveModel;
use App\Presentation\Api\Grower\Model\ProductModel;

final class AddProductsToHiveGrowerRequestBuilder extends AddProductsToHiveGrowerRequest
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
    private const HIVE_GEO_POINT = [ 48.314, 3.312];

    /**
     * @return self
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
     * @return AddProductsToHiveGrowerRequest
     */
    public function build(): AddProductsToHiveGrowerRequest
    {
        $request = new AddProductsToHiveGrowerRequest();
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
        $hive->products = self::createValidProduct();
        $hive->geoPoint = self::HIVE_GEO_POINT;

        return $hive;
    }

    /**
     * @return ProductModel[]
     */
    private static function createValidProduct(): array
    {
        $products = [];

        $product = new ProductModel();
        $product->name = 'fromage';
        $product->description = 'fromage de chèvre';
        $product->price = 2.3;

        $products[] = $product;

        return $products;
    }

    /**
     * @return ProductModel[]
     */
    private static function createInvalidProduct(): array
    {
        $products = [];
        $product = new ProductModel();
        $product->name = '';
        $product->description = 'fromage de chèvre';
        $product->price = 2.3;

        $products[] = $product;

        return $products;
    }

    /**
     * @param string $firstName
     * @return self
     */
    public function withFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return self
     */
    public function withInvalidProductsHive(): self
    {
        $this->hive = new HiveModel();
        $this->hive->name = self::HIVE_NAME;
        $this->hive->siret_number = self::HIVE_SIRET;
        $this->hive->street = self::HIVE_STREET;
        $this->hive->city = self::HIVE_CITY;
        $this->hive->zip_code = self::HIVE_ZIP_CODE;
        $this->hive->products = self::createInvalidProduct();

        return $this;
    }
}
