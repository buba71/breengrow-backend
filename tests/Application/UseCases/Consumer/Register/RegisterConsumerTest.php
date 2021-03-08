<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Consumer\Register;

use App\Application\Services\IdGenerator\IdGenerator;
use App\Application\UseCases\Consumer\Register\RegisterConsumer;
use App\Application\UseCases\Consumer\Register\RegisterConsumerPresenter;
use App\Application\UseCases\Consumer\Register\RegisterConsumerRequest;
use App\Application\UseCases\Consumer\Register\RegisterConsumerResponse;
use App\Domain\Model\Consumer\Consumer;
use App\SharedKernel\Error\Error;
use App\SharedKernel\Error\Notifier;
use App\SharedKernel\Service\PasswordHash;
use App\Tests\Mock\Domain\InMemoryConsumerRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class RegisterConsumerTest
 * @package App\Tests\Application\UseCases\Consumer\Register
 */
final class RegisterConsumerTest extends TestCase
{
    private \PHPUnit\Framework\MockObject\MockObject $idGenerator;
    private inMemoryConsumerRepository $consumerRepository;
    private \PHPUnit\Framework\MockObject\MockObject $passwordHasher;
    private \PHPUnit\Framework\MockObject\MockObject $presenter;
    private RegisterConsumer $registerConsumer;
    private RegisterConsumerResponse $response;

    protected function setUp(): void
    {
        $this->consumerRepository = new InMemoryConsumerRepository();
        $this->idGenerator = $this->createMock(IdGenerator::class);
        $this->passwordHasher = $this->getMockBuilder(PasswordHash::class)
                                     ->setMethods(['hashPassword'])
                                     ->getMock();
        $this->presenter = $this->getMockBuilder(RegisterConsumerPresenter::class)
                                     ->setMethods(['present'])
                                     ->getMock();
        $this->registerConsumer = new RegisterConsumer(
            $this->consumerRepository,
            $this->idGenerator,
            $this->passwordHasher
        );
        $this->response = new RegisterConsumerResponse();
    }

    public function testInputConsumerRegistrationIsValid(): void
    {
        $request = RegisterConsumerRequestBuilder::defaultRequest()->build();

        $result = $this->registerConsumer->checkRequest($request, $this->response);

        static::assertTrue($result);
    }

    public function testInputConsumerRegistrationNotValid(): void
    {
        $request = RegisterConsumerRequestBuilder::defaultRequest()->withFirstName('')->build();

        $result = $this->registerConsumer->checkRequest($request, $this->response);

        static::assertFalse($result);
    }

    public function testSaveConsumer(): void
    {
        $request = RegisterConsumerRequestBuilder::defaultRequest()->build();
        $consumer = self::createConsumer($request);

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->passwordHasher
            ->method('hashPassWord')
            ->willReturn(\base64_encode($request->password));

        $this->registerConsumer->saveConsumer($request, $this->response);

        static::assertEquals($consumer, $this->consumerRepository->getConsumerById($consumer->getId()));
    }

    public function testResponseIfConsumerIsValid(): void
    {
        $request = RegisterConsumerRequestBuilder::defaultRequest()->build();

        $consumerRegistered = self::createConsumer($request);

        // Should be.
        $this->response->setConsumer($consumerRegistered);
        $this->response->setStatus(201);

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->passwordHasher
            ->method('hashPassword')
            ->willReturn(base64_encode($request->password));

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->registerConsumer->execute($request, $this->presenter);
    }

    public function testResponseIfConsumerIsNotValid(): void
    {
        $request = RegisterConsumerRequestBuilder::defaultRequest()->withFirstName('')->build();

        // Should be.
        $this->response->setStatus(400);
        $this->response->addError(new Error('Prénom', 'Cette valeur doit être renseignée'));

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->registerConsumer->execute($request, $this->presenter);
    }

    public function testFailsWhenEmailAlreadyExist(): void
    {
        $request = RegisterConsumerRequestBuilder::defaultRequest()->build();

        $consumer = static::createConsumer($request);

        // Add a consumer in bdd before checking if already exist.
        $this->consumerRepository->addConsumer($consumer);

        $this->registerConsumer->validateConsumer($request, $this->response);

        $shouldBe = new Notifier();
        $shouldBe ->addError(new Error('Email', 'Cette adresse mail éxiste déjà.'));

        static::assertEquals($shouldBe, $this->response->getNotifier());
    }

    /**
     * @param RegisterConsumerRequest $request
     * @return Consumer
     */
    public static function createConsumer(RegisterConsumerRequest $request): Consumer
    {
        $consumer = new Consumer(
            '1',
            $request->firstName,
            $request->lastName,
            $request->email,
            base64_encode($request->password),
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

        return $consumer;
    }
}
