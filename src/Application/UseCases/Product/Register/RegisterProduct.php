<?php

declare(strict_types=1);

namespace App\Application\UseCases\Product\Register;

use App\Application\Services\IdGenerator;
use App\Application\UseCases\Grower\Register\RegisterGrowerResponse;
use App\Domain\Model\Product\Product;
use App\Domain\Repository\ProductRepository;
use App\SharedKernel\Error\Error;
use Assert\Assert;
use Assert\LazyAssertionException;

/**
 * Class RegisterProduct
 * @package App\Application\UseCases\Product\Register
 */
final class RegisterProduct
{
    /**
     * @var IdGenerator
     */
    private IdGenerator $idGenerator;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * RegisterProduct constructor.
     * @param IdGenerator $idGenerator
     * @param ProductRepository $productRepository
     */
    public function __construct(IdGenerator $idGenerator, ProductRepository $productRepository)
    {
        $this->idGenerator = $idGenerator;
        $this->productRepository = $productRepository;
    }

    /**
     * @param RegisterProductRequest $request
     * @param RegisterProductPresenter $presenter
     */
    public function execute(RegisterProductRequest $request, RegisterProductPresenter $presenter): void
    {
        $response = new RegisterProductResponse();

        $isValid = $this->checkRequest($request, $response);

        if ($isValid) {
            $this->saveProduct($request, $response);
            $response->setStatus(RegisterGrowerResponse::HTTP_CREATED);
        } else {
            $response->setStatus(RegisterGrowerResponse::HTTP_BAD_REQUEST);
        }

        $presenter->present($response);
    }

    /**
     * @param RegisterProductRequest $request
     * @param RegisterProductResponse $response
     * @return bool
     */
    public function checkRequest(RegisterProductRequest $request, RegisterProductResponse $response): bool
    {
        try {
            Assert::lazy()
                ->that($request->name, 'nom')->notEmpty('Le nom du produit doit être renseigné')
                ->that($request->description, 'description')->notEmpty('La description du produit doit être renseignée')
                ->that($request->price, 'prix')->notEmpty('Le prix unitaire du produit doit être renseigné')
                ->verifyNow();

            return true;
        } catch (LazyAssertionException $errors) {
            foreach ($errors->getErrorExceptions() as $error) {
                $response->addError(new Error($error->getPropertyPath(), $error->getMessage()));
            }
            return false;
        }
    }

    /**
     * @param RegisterProductRequest $request
     * @param RegisterProductResponse $response
     */
    public function saveProduct(RegisterProductRequest $request, RegisterProductResponse $response): void
    {
        $product = new Product(
            $this->idGenerator->nextIdentity(),
            $request->name,
            $request->description,
            $request->price
        );
        
        $this->productRepository->addProduct($product);
        $response->setProduct($product);
    }
}
