<?php

declare(strict_types=1);

namespace App\Application\UseCases\Consumer\Register;

use App\Application\Services\IdGenerator\IdGenerator;
use App\Domain\Model\Consumer\Consumer;
use App\Domain\Repository\ConsumerRepository;
use App\SharedKernel\Error\Error;
use App\SharedKernel\Service\PasswordHash;
use Assert\Assert;
use Assert\LazyAssertionException;

final class RegisterConsumer
{
    /**
     * @var IdGenerator
     */
    private IdGenerator $idGenerator;

    /**
     * @var PasswordHash
     */
    private PasswordHash $passwordHasher;

    /**
     * @var ConsumerRepository
     */
    private ConsumerRepository $repository;

    /**
     * RegisterConsumer constructor.
     * @param ConsumerRepository $repository
     * @param IdGenerator $idGenerator
     * @param PasswordHash $passwordHasher
     */
    public function __construct(ConsumerRepository $repository, IdGenerator $idGenerator, PasswordHash $passwordHasher)
    {
        $this->idGenerator = $idGenerator;
        $this->passwordHasher = $passwordHasher;
        $this->repository = $repository;
    }

    /**
     * @param RegisterConsumerRequest $request
     * @param RegisterConsumerPresenter $presenter
     */
    public function execute(RegisterConsumerRequest $request, RegisterConsumerPresenter $presenter): void
    {

        $response = new RegisterConsumerResponse();

        $isValid = $this->checkRequest($request, $response) && $this->validateConsumer($request, $response);

        if ($isValid) {
            $this->saveConsumer($request, $response);
            $response->setStatus(RegisterConsumerResponse::HTTP_CREATED);
        } else {
            $response->setStatus(RegisterConsumerResponse::HTTP_BAD_REQUEST);
        }

        $presenter->present($response);
    }

    public function checkRequest(RegisterConsumerRequest $request, RegisterConsumerResponse $response): bool
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
     * @param RegisterConsumerRequest $request
     * @param RegisterConsumerResponse $response
     */
    public function saveConsumer(RegisterConsumerRequest $request, RegisterConsumerResponse $response): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword($request->password);

        $consumer = new Consumer(
            $this->idGenerator->nextIdentity(),
            $request->firstName,
            $request->lastName,
            $request->email,
            $hashedPassword,
            $request->salt,
            $request->role,
        );

        foreach ($request->addresses as $address) {
            $consumer->addAddress(
                $address->firstName,
                $address->lastName,
                $address->street,
                $address->zipCode,
                $address->city
            );
        }

        $this->repository->addConsumer($consumer);
        $response->setConsumer($consumer);
    }

    /**
     * @param RegisterConsumerRequest $request
     * @param RegisterConsumerResponse $response
     * @return bool
     */
    public function validateConsumer(RegisterConsumerRequest $request, RegisterConsumerResponse $response): bool
    {
        $result = $this->repository->getConsumerByEmail($request->email);

        if (null !== $result) {
            $response->addError(new Error('Email', 'Cette adresse mail éxiste déjà.'));
            return false;
        }
        return true;
    }
}
