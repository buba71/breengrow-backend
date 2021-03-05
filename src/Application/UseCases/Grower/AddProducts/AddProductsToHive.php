<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\AddProducts;

use App\Application\Services\IdGenerator\IdGenerator;
use App\Domain\Repository\GrowerRepository;
use App\SharedKernel\Error\Error;
use Assert\Assert;
use Assert\LazyAssertionException;

final class AddProductsToHive
{
    /**
     * @var IdGenerator
     */
    private IdGenerator $idGenerator;

    /**
     * @var GrowerRepository
     */
    private GrowerRepository $growerRepository;

    /**
     * AddProductsToHive constructor.
     * @param GrowerRepository $growerRepository
     * @param IdGenerator $idGenerator
     */
    public function __construct(GrowerRepository $growerRepository, IdGenerator $idGenerator)
    {
        $this->idGenerator = $idGenerator;
        $this->growerRepository = $growerRepository;
    }

    /**
     * @param AddProductsToHiveGrowerRequest $request
     * @param string $growerId
     * @param AddProductsToHivePresenter $presenter
     */
    public function execute(
        AddProductsToHiveGrowerRequest $request,
        string $growerId,
        AddProductsToHivePresenter $presenter
    ): void {
        $response = new AddProductsToHiveGrowerResponse();

        $isValid = $this->checkRequest($request, $response);
        
        if ($isValid && property_exists($request->hive, 'products')) {
            $this->saveGrower($growerId, $request, $response);

            $response->setStatus(AddProductsToHiveGrowerResponse::HTTP_OK);
        } else {
            $response->setStatus(AddProductsToHiveGrowerResponse::HTTP_BAD_REQUEST);
        }

        $presenter->present($response);
    }

    /**
     * @param AddProductsToHiveGrowerRequest $request
     * @param AddProductsToHiveGrowerResponse $response
     * @return bool
     */
    public function checkRequest(
        AddProductsToHiveGrowerRequest $request,
        AddProductsToHiveGrowerResponse $response
    ): bool {
        try {
            foreach ($request->hive->products as $product) {
                Assert::lazy()
                    ->that($product->name, 'Nom du produit')->notEmpty('Cette valeur doit être renseignée')
                    ->that($product->description, 'Description du produit')->notEmpty('veuillez saisir une description')
                    ->that($product->price, 'Prix')->notEmpty('Veuillez entrer un prix pour ce produit')
                    ->verifyNow();
            }
            return true;
        } catch (LazyAssertionException $errors) {
            foreach ($errors->getErrorExceptions() as $error) {
                $response->addError(new Error($error->getPropertyPath(), $error->getMessage()));
            }
            return false;
        }
    }

    public function saveGrower(
        string $growerId,
        AddProductsToHiveGrowerRequest $request,
        AddProductsToHiveGrowerResponse $response
    ): void {
        $growerToUpdate = $this->growerRepository->getGrowerById($growerId);

        foreach ($request->hive->products as $product) {
            $growerToUpdate->getHive()->addProduct(
                $this->idGenerator->nextIdentity(),
                new \DateTimeImmutable('midnight'),
                $product->name,
                $product->description,
                $product->price
            );
        }

        $this->growerRepository->updateGrower($growerToUpdate);
        $response->setGrower($growerToUpdate);
    }
}
