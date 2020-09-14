<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Grower\Register;

use App\Application\Services\IdGenerator;
use App\Application\UseCases\Grower\Register\RegisterGrower;
use App\Application\UseCases\Grower\Register\RegisterGrowerPresenter;
use App\Application\UseCases\Grower\Register\RegisterGrowerResponse;
use App\Domain\Model\Grower\Grower;
use App\SharedKernel\Error\Error;
use App\SharedKernel\Error\Notifier;
use App\SharedKernel\Service\PasswordHash;
use App\Tests\Mock\Domain\InMemoryGrowerRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class RegisterGrowerTest
 * @package App\Tests\Application\UseCases\Grower\Register
 */
class RegisterGrowerTest extends TestCase
{
    private IdGenerator $idGenerator;
    private InMemoryGrowerRepository $growerRepository;
    private PasswordHash $passwordHasher;
    private $presenter;
    private RegisterGrower $register;
    private RegisterGrowerResponse $response;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->idGenerator = $this->createMock(IdGenerator::class);
        $this->passwordHasher = $this->getMockBuilder(PasswordHash::class)
                                     ->setMethods(['hashPassword'])
                                     ->getMock();
        $this->presenter = $this->getMockBuilder(RegisterGrowerPresenter::class)
                                ->setMethods(['present'])
                                ->getMock();
        $this->growerRepository = new InMemoryGrowerRepository();
        $this->register = new RegisterGrower(
            $this->growerRepository,
            $this->idGenerator,
            $this->passwordHasher
        );
        $this->response = new RegisterGrowerResponse();
    }

    /**
     * Check if Grower input request is not valid(checkRequest() return false).
     */
    public function testInputGrowerRegistrationNotValid(): void
    {
        // Set the request with not valid value(firstName).
        $request = RegisterGrowerRequestBuilder::defaultRequest()->withFirstName('')->build();

        $result = $this->register->checkRequest($request, $this->response);

        static::assertFalse($result);
    }

    /**
     * Check if Grower input request is valid before to store grower on bdd(CheckRequest return true).
     */
    public function testInputGrowerRegistrationIsValid(): void
    {
        // Request is set with default value.
        $request = RegisterGrowerRequestBuilder::defaultRequest()->build();

        $result = $this->register->checkRequest($request, $this->response);

        static:: assertTrue($result);
    }

    /**
     * Test  grower record on bdd if value input is valid.
     */
    public function testSaveGrower(): void
    {
        $request = RegisterGrowerRequestBuilder::defaultRequest()->build();

        $grower = new Grower(
            '1',
            $request->firstName,
            $request->lastName,
            $request->email,
            base64_encode($request->password),
            $request->salt,
            $request->role,
        );
        $grower->addHive('Breengrow', '123456789', '20 rue François Ducarouge', 'Digoin', '71160');

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->passwordHasher
            ->method('hashPassword')
            ->willReturn(base64_encode($request->password));

        $this->register->saveGrower($request, $this->response);

        static::assertEquals($grower, $this->growerRepository->getGrowerById($grower->getId()));
    }

    /**
     * Check the response on valid input.
     */
    public function testResponseIfGrowerIsValid(): void
    {
        $request = RegisterGrowerRequestBuilder::defaultRequest()->build();

        $growerRegistered = new Grower(
            '1',
            $request->firstName,
            $request->lastName,
            $request->email,
            base64_encode($request->password),
            $request->salt,
            $request->role,
        );
        $growerRegistered->addHive('Breengrow', '123456789', '20 rue François Ducarouge', 'Digoin', '71160');

        // Should be.
        $this->response->setGrower($growerRegistered);
        $this->response->setStatus(201);

        $this->idGenerator->expects($this->once())
                  ->method('nextIdentity')
                  ->willReturn('1');

        $this->passwordHasher->expects($this->once())
                  ->method('hashPassword')
                  ->willReturn(base64_encode($request->password));

        $this->presenter->expects($this->once())
                  ->method('present')
                  ->with($this->response);

        $this->register->execute($request, $this->presenter);
    }

    /**
     * Check the response on not valid input.
     */
    public function testResponseIfGrowerIsNotValid(): void
    {
        $request = RegisterGrowerRequestBuilder::defaultRequest()->withFirstName('')->build();

        // Should be.
        $this->response->setStatus(400);
        $this->response->addError(new Error('Prénom', 'Cette valeur doit être renseignée'));

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->register->execute($request, $this->presenter);
    }

    public function testFailsWhenEmailAlreadyExist()
    {
        $request = RegisterGrowerRequestBuilder::defaultRequest()->build();

        $grower = new Grower(
            '1',
            $request->firstName,
            $request->lastName,
            $request->email,
            base64_encode($request->password),
            $request->salt,
            $request->role,
        );
        $grower->addHive('Breengrow', '123456789', '20 rue François Ducarouge', 'Digoin', '71160');

        $this->growerRepository->addGrower($grower);
        $this->register->validateGrower($request, $this->response);

        $shouldBe = new Notifier();
        $shouldBe ->addError(new Error('Email', 'This address already exist.'));

        static::assertEquals($shouldBe, $this->response->getNotifier());
    }
}
