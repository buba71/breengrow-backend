<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Product\Register;

use _HumbugBox3ad74b9da04b\Nette\Utils\DateTime;
use App\Application\UseCases\Product\Register\RegisterProductRequest;

final class RegisterProductRequestBuilder extends RegisterProductRequest
{
    private const PRODUCT_DESCRIPTION = 'This is the product description';
    private const PRODUCT_NAME = 'Product name';
    private const PRODUCT_PRICE = 15.10;

    public static function defaultRequest(): self
    {
        $request = new static();
        $request->name = self::PRODUCT_NAME;
        $request->description = self::PRODUCT_DESCRIPTION;
        $request->price = self::PRODUCT_PRICE;

        return $request;
    }

    public function build(): RegisterProductRequest
    {
        $request = new RegisterProductRequest();
        $request->name = $this->name;
        $request->description = $this->description;
        $request->price =$this->price;

        return $request;
    }

    public function withName($name)
    {
        $this->name = $name;
        return $this;
    }

    public static function getCreatedAt()
    {
        return new \DateTimeImmutable('midnight');
    }
}
