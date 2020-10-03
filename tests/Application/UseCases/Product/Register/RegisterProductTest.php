<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Product\Register;

use App\Application\Services\IdGenerator;
use App\Application\UseCases\Product\Register\RegisterProduct;
use App\Application\UseCases\Product\Register\RegisterProductPresenter;
use App\Application\UseCases\Product\Register\RegisterProductRequest;
use App\Application\UseCases\Product\Register\RegisterProductResponse;
use App\Domain\Model\Product\Product;
use App\SharedKernel\Error\Error;
use App\Tests\Mock\Domain\InMemoryProductRepository;
use PHPUnit\Framework\TestCase;

class RegisterProductTest extends TestCase
{
    private IdGenerator $idGenerator;
    private InMemoryProductRepository $productRepository;
    private $presenter;
    private RegisterProduct $registerProduct;
    private RegisterProductResponse $response;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->idGenerator = $this->createMock(IdGenerator::class);
        $this->presenter = $this->getMockBuilder(RegisterProductPresenter::class)
            ->setMethods(['present'])
            ->getMock();
        $this->productRepository = new InMemoryProductRepository();
        $this->registerProduct = new RegisterProduct(
            $this->idGenerator,
            $this->productRepository
        );
        $this->response = new RegisterProductResponse();
    }

    /**
     * Check if Product input request is valid(checkRequest() return true).
     */
    public function testInputProductRegistrationIsValid(): void
    {
        $request = RegisterProductRequestBuilder::defaultRequest()->build();

        $result = $this->registerProduct->checkRequest($request, $this->response);

        static::assertTrue($result);
    }

    /**
     * Check if Grower input request is valid before to store grower on bdd(CheckRequest return true).
     */
    public function testInputGrowerRegistrationNotValid(): void
    {
        // Request is set with default name property not valid.
        $request = RegisterProductRequestBuilder::defaultRequest()->withName('')->build();
        $result = $this->registerProduct->checkRequest($request, $this->response);
        static:: assertFalse($result);
    }
     /**
      * Test  product record on bdd if value input is valid.
      */
    public function testSaveProduct(): void
    {
        $request = RegisterProductRequestBuilder::defaultRequest()->build();
        $product = self::createProduct($request);

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->registerProduct->saveProduct($request, $this->response);

        static::assertEquals($product, $this->productRepository->getProductById($product->getId()));
    }
//
     /**
      * Check the response on valid input.
      */
    public function testResponseIfProductIsValid(): void
    {
        $request = RegisterProductRequestBuilder::defaultRequest()->build();
        $productRegistered = self::createProduct($request);

        // Should be.
        $this->response->setProduct($productRegistered);
        $this->response->setStatus(201);

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->registerProduct->execute($request, $this->presenter);
    }
//
     /**
      * Check the response on not valid input.
      */
    public function testResponseIfProductIsNotValid(): void
    {
        $request = RegisterProductRequestBuilder::defaultRequest()->withName('')->build();

        // Should be.
        $this->response->setStatus(400);
        $this->response->addError(new Error('nom', 'Le nom du produit doit être renseigné'));

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->registerProduct->execute($request, $this->presenter);
    }

    public static function createProduct(RegisterProductRequest $request): Product
    {
        return new Product(
            '1',
            $request->name,
            $request->description,
            $request->price,
        );
    }
}
