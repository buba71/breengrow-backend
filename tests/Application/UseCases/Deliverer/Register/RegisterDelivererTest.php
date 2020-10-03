<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Deliverer\Register;

use App\Application\Services\IdGenerator;
use App\Application\UseCases\Deliverer\Register\RegisterDeliverer;
use App\Application\UseCases\Deliverer\Register\RegisterDelivererPresenter;
use App\Application\UseCases\Deliverer\Register\RegisterDelivererRequest;
use App\Application\UseCases\Deliverer\Register\RegisterDelivererResponse;
use App\Domain\Model\Deliverer\Deliverer;
use App\SharedKernel\Error\Error;
use App\SharedKernel\Error\Notifier;
use App\SharedKernel\Service\PasswordHash;
use App\Tests\Mock\Domain\InMemoryDelivererRepository;
use PHPUnit\Framework\TestCase;

class RegisterDelivererTest extends TestCase
{
    private IdGenerator $idGenerator;
    private InMemoryDelivererRepository $delivererRepository;
    private PasswordHash $passwordHasher;
    private $presenter;
    private RegisterDeliverer $registerDeliverer;
    private RegisterDelivererResponse $response;

    protected function setUp(): void
    {
        $this->delivererRepository = new InMemoryDelivererRepository();
        $this->idGenerator = $this->createMock(IdGenerator::class);
        $this->passwordHasher = $this->getMockBuilder(PasswordHash::class)
            ->setMethods(['hashPassword'])
            ->getMock();
        $this->presenter = $this->getMockBuilder(RegisterDelivererPresenter::class)
            ->setMethods(['present'])
            ->getMock();
        $this->registerDeliverer = new RegisterDeliverer(
            $this->delivererRepository,
            $this->idGenerator,
            $this->passwordHasher
        );
        $this->response = new RegisterDelivererResponse();
    }

    public function testRegisterDelivererRequestIsValid(): void
    {
        $request = RegisterDelivererRequestBuilder::defaultRequest()->build();

        $result = $this->registerDeliverer->checkRequest($request, $this->response);

        static::assertTrue($result);
    }

    public function testRegisterDelivererRequestNotValid(): void
    {
        $request = RegisterDelivererRequestBuilder::defaultRequest()->withFirstName('')->build();

        $result = $this->registerDeliverer->checkRequest($request, $this->response);

        static::assertFalse($result);
    }

    public function testSaveDeliverer()
    {
        $request = RegisterDelivererRequestBuilder::defaultRequest()->build();
        $deliverer = self::createDeliverer($request);

        $this->idGenerator
             ->method('nextIdentity')
             ->willReturn('1');

        $this->passwordHasher
             ->method('hashPassword')
             ->willReturn(\base64_encode($request->password));

        $this->registerDeliverer->saveDeliverer($request, $this->response);

        static::assertEquals($deliverer, $this->delivererRepository->getDelivererById($deliverer->getId()));
    }

    public function testResponseIfDelivererIsValid()
    {
        $request = RegisterDelivererRequestBuilder::defaultRequest()->build();
        $deliverer = self::createDeliverer($request);

        $this->response->setDeliverer($deliverer);
        $this->response->setStatus(201);

        $this->idGenerator
             ->method('nextIdentity')
             ->willReturn('1');

        $this->passwordHasher
             ->method('hashPassword')
             ->willReturn(\base64_encode($request->password));

        $this->presenter->expects($this->once())
             ->method('present')
             ->with($this->response);

        $this->registerDeliverer->execute($request, $this->presenter);
    }

    public function testResponseIfDelivererNotValid()
    {
        $request = RegisterDelivererRequestBuilder::defaultRequest()->withFirstName('')->build();

        $this->response->setStatus(400);
        $this->response->addError(new Error('Prénom', 'Cette valeur doit être renseignée'));

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->passwordHasher
            ->method('hashPassword')
            ->willReturn(\base64_encode($request->password));

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->registerDeliverer->execute($request, $this->presenter);
    }

    public function testFailsWhenEmailAlreadyExist()
    {
        $request = RegisterDelivererRequestBuilder::defaultRequest()->withFirstName('')->build();
        $deliverer = self::createDeliverer($request);

        $this->delivererRepository->addDeliverer($deliverer);
        
        $this->registerDeliverer->validateDeliverer($request, $this->response);
        
        $shouldBe = new Notifier();
        $shouldBe->addError(new Error('Email', 'This mail already exist.'));
        
        static:: assertEquals($shouldBe, $this->response->getNotifier());
    }

    /**
     * @param RegisterDelivererRequest $request
     * @return Deliverer
     */
    public static function createDeliverer(RegisterDelivererRequest $request): Deliverer
    {
        return new Deliverer(
            '1',
            $request->email,
            $request->firstName,
            $request->lastName,
            \base64_encode($request->password),
            $request->phone,
            $request->salt,
            $request->role
        );
    }
}
