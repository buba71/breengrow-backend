<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\Register;

use App\Domain\Model\Grower\Grower;
use App\Domain\Repository\GrowerRepository;
use App\SharedKernel\Error\Error;
use App\Application\Services\IdGenerator;
use App\SharedKernel\Service\PasswordHash;
use Assert\Assert;
use Assert\LazyAssertionException;

final class RegisterGrower
{
    private IdGenerator $idGenerator;
    private PasswordHash $passwordHasher;
    private GrowerRepository $repository;

    /**
     * RegisterGrower constructor.
     * @param GrowerRepository $repository
     * @param IdGenerator $idGenerator
     * @param PasswordHash $passwordHasher
     */
    public function __construct(GrowerRepository $repository, IdGenerator $idGenerator, PasswordHash $passwordHasher)
    {
        $this->idGenerator = $idGenerator;
        $this->repository = $repository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param RegisterGrowerRequest $request
     * @param RegisterGrowerPresenter $presenter
     */
    public function execute(RegisterGrowerRequest $request, RegisterGrowerPresenter $presenter): void
    {
        $response = new RegisterGrowerResponse();

        $isValid = $this->checkRequest($request, $response) && $this->validateGrower($request, $response);


        if ($isValid) {
            $this->saveGrower($request, $response);
            $response->setStatus(RegisterGrowerResponse::HTTP_CREATED);
        } else {
            $response->setStatus(RegisterGrowerResponse::HTTP_BAD_REQUEST);
        }

        $presenter->present($response);
    }

    /**
     * @param RegisterGrowerRequest $request
     * @param RegisterGrowerResponse $response
     * @return bool
     */
    public function checkRequest(RegisterGrowerRequest $request, RegisterGrowerResponse $response): bool
    {
        try {
            Assert::lazy()
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
     * @param RegisterGrowerRequest $request
     * @param RegisterGrowerResponse $response
     */
    public function saveGrower(RegisterGrowerRequest $request, RegisterGrowerResponse $response): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword($request->password);

        $grower = new Grower(
            $this->idGenerator->nextIdentity(),
            $request->firstName,
            $request->lastName,
            $request->email,
            $hashedPassword,
            $request->salt,
            $request->role,
        );

        $grower->addHive(
            $request->hive->name,
            $request->hive->siret_number,
            $request->hive->street,
            $request->hive->city,
            $request->hive->zip_code
        );
        $this->repository->addGrower($grower);

        $response->setGrower($grower);
    }

    /**
     * @param RegisterGrowerRequest $request
     * @param RegisterGrowerResponse $response
     * @return bool
     */
    public function validateGrower(RegisterGrowerRequest $request, RegisterGrowerResponse $response): bool
    {
        $result = $this->repository->getGrowerByEmail($request->email);

        if (null !== $result) {
            $response->addError(new Error('Email', 'This address already exist.'));
            return false;
        }
        return true;
    }
}
