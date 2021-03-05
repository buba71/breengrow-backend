<?php

declare(strict_types=1);

namespace App\Application\UseCases\Deliverer\Register;

use App\Application\Services\IdGenerator\IdGenerator;
use App\Domain\Model\Deliverer\Deliverer;
use App\Domain\Repository\DelivererRepository;
use App\SharedKernel\Error\Error;
use App\SharedKernel\Service\PasswordHash;
use Assert\Assert;
use Assert\LazyAssertionException;

final class RegisterDeliverer
{
    private IdGenerator $idGenerator;
    private DelivererRepository $repository;
    private PasswordHash $passwordHasher;

    /**
     * RegisterDeliverer constructor.
     * @param DelivererRepository $repository
     * @param IdGenerator $idGenerator
     * @param PasswordHash $passwordHasher
     */
    public function __construct(DelivererRepository $repository, IdGenerator $idGenerator, PasswordHash $passwordHasher)
    {
        $this->idGenerator = $idGenerator;
        $this->repository = $repository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param RegisterDelivererRequest $request
     * @param RegisterDelivererPresenter $presenter
     */
    public function execute(RegisterDelivererRequest $request, RegisterDelivererPresenter $presenter): void
    {
        $response = new RegisterDelivererResponse();

        $isValid = $this->checkRequest($request, $response) && $this->validateDeliverer($request, $response);
        
        if ($isValid) {
            $this->saveDeliverer($request, $response);
            $response->setStatus(RegisterDelivererResponse::HTTP_CREATED);
        } else {
            $response->setStatus(RegisterDelivererResponse::HTTP_BAD_REQUEST);
        }

        $presenter->present($response);
    }

    /**
     * @param RegisterDelivererRequest $request
     * @param RegisterDelivererResponse $response
     * @return bool
     */
    public function checkRequest(RegisterDelivererRequest $request, RegisterDelivererResponse $response): bool
    {
        try {
            Assert::Lazy()
                ->that($request->firstName, 'Prénom')->notEmpty('Cette valeur doit être renseignée')
                ->that($request->lastName, 'Nom')->notEmpty('Cette valeur doit être renseignée')
                ->that($request->password, 'Mot de passe')->notEmpty('Cette valeur doit être renseignée')
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
     * @param RegisterDelivererRequest $request
     * @param RegisterDelivererResponse $response
     */
    public function saveDeliverer(RegisterDelivererRequest $request, RegisterDelivererResponse $response): void
    {
        $passwordHashed = $this->passwordHasher->hashPassword($request->password);

        $deliverer = new Deliverer(
            $this->idGenerator->nextIdentity(),
            $request->email,
            $request->firstName,
            $request->lastName,
            $passwordHashed,
            $request->phone,
            $request->salt,
            $request->role
        );

        $this->repository->addDeliverer($deliverer);
        $response->setDeliverer($deliverer);
    }

    /**
     * @param RegisterDelivererRequest $request
     * @param RegisterDelivererResponse $response
     * @return bool
     */
    public function validateDeliverer(RegisterDelivererRequest $request, RegisterDelivererResponse $response): bool
    {
        $result = $this->repository->getDelivererByEmail($request->email);

        if (null !== $result) {
            $response->addError(new Error('Email', 'This mail already exist.'));
            return false;
        } else {
            return true;
        }
    }
}
