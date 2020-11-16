<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Grower\AddProducts;

use App\Application\Services\IdGenerator;
use App\Application\UseCases\Grower\AddProducts\AddProductsToHive;
use App\Application\UseCases\Grower\AddProducts\AddProductsToHiveGrowerResponse;
use App\Application\UseCases\Grower\AddProducts\AddProductsToHivePresenter;
use App\Application\UseCases\Grower\Register\RegisterGrower;
use App\Application\UseCases\Grower\Register\RegisterGrowerResponse;
use App\Domain\Model\Grower\Grower;
use App\SharedKernel\Error\Error;
use App\SharedKernel\Service\PasswordHash;
use App\Tests\Application\UseCases\Grower\Register\RegisterGrowerRequestBuilder;
use App\Tests\Mock\Domain\InMemoryGrowerRepository;
use PHPUnit\Framework\TestCase;

final class AddProductsToHiveTest extends TestCase
{
    private AddProductsToHive $addProductToHive;
    private IdGenerator $idGenerator;
    private InMemoryGrowerRepository $growerRepository;
    private PasswordHash $passwordHasher;
    private AddProductsToHivePresenter $presenter;
    private RegisterGrower $registerGrower;
    private AddProductsToHiveGrowerResponse $updateGrowerResponse;
    private RegisterGrowerResponse $registerGrowerResponse;

    protected function setUp(): void
    {
        $this->idGenerator = $this->createMock(IdGenerator::class);
        $this->passwordHasher = $this->createMock(PasswordHash::class);
        $this->presenter = $this->getMockBuilder(AddProductsToHivePresenter::class)
                                ->setMethods(['present'])
                                ->getMock();

        $this->growerRepository = new InMemoryGrowerRepository();
        $this->addProductToHive = new AddProductsToHive($this->growerRepository, $this->idGenerator);
        $this->registerGrower = new RegisterGrower($this->growerRepository, $this->idGenerator, $this->passwordHasher);
        $this->registerGrowerResponse = new RegisterGrowerResponse();
        $this->updateGrowerResponse = new AddProductsToHiveGrowerResponse();
    }

    public function testInputGrowerUpdateIsValid()
    {
        $request = AddProductsToHiveGrowerRequestBuilder::defaultRequest()->build();
        $result = $this->addProductToHive->checkRequest($request, $this->updateGrowerResponse);

        static::assertTrue($result);
    }

    public function testInputGrowerUpdateNotValid()
    {
        $request = AddProductsToHiveGrowerRequestBuilder::defaultRequest()->withInvalidProductsHive()->build();
        $result = $this->addProductToHive->checkRequest($request, $this->updateGrowerResponse);

        static::assertFalse($result);
    }

    public function testGrowerUpdated()
    {
        // At the begin, register a grower in Bdd(InMemory).
        $request = RegisterGrowerRequestBuilder::defaultRequest()->build();
        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->passwordHasher
            ->method('hashPassword')
            ->willReturn(base64_encode($request->password));

        $this->registerGrower->saveGrower($request, $this->registerGrowerResponse);

        // Then update grower with new product.
        $growerUpdatedRequest = AddProductsToHiveGrowerRequestBuilder::defaultRequest()->build();
        $this->addProductToHive->saveGrower('1', $growerUpdatedRequest, $this->updateGrowerResponse);

        $products = $this->growerRepository->getGrowerById('1')->getHive()->getProducts();
        static::assertEquals(1, count($products));
    }

    public function testResponseGrowerUpdateIsValid()
    {
        // At the begin, register a grower in Bdd(InMemory).
        $request = RegisterGrowerRequestBuilder::defaultRequest()->build();
        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->passwordHasher
            ->method('hashPassword')
            ->willReturn(base64_encode($request->password));

        $this->registerGrower->saveGrower($request, $this->registerGrowerResponse);

        // Then update this grower on adding a new product.
        $growerUpdatedRequest = AddProductsToHiveGrowerRequestBuilder::defaultRequest()->build();
        $growerUpdated = self::createGrower($growerUpdatedRequest);


        $this->updateGrowerResponse->setGrower($growerUpdated);
        $this->updateGrowerResponse->setStatus(200);

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->passwordHasher
            ->method('hashPassword')
            ->willReturn(base64_encode($request->password));

        $this->presenter->expects($this->once())
                       ->method('present')
                       ->with($this->updateGrowerResponse);

        $this->addProductToHive->execute($growerUpdatedRequest, '1', $this->presenter);
    }

    public function testResponseGrowerUpdateNotValid()
    {
        // At the begin, register a grower in Bdd(InMemory).
        $request = RegisterGrowerRequestBuilder::defaultRequest()->build();
        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->passwordHasher
            ->method('hashPassword')
            ->willReturn(base64_encode($request->password));

        $this->registerGrower->saveGrower($request, $this->registerGrowerResponse);

        // Then update this grower on adding an invalid new product.
        $growerUpdatedRequest = AddProductsToHiveGrowerRequestBuilder::defaultRequest()
            ->withInvalidProductsHive()
            ->build();

        $this->updateGrowerResponse->addError(new Error('Nom du produit', 'Cette valeur doit être renseignée'));
        $this->updateGrowerResponse->setStatus(400);

        $this->idGenerator
            ->method('nextIdentity')
            ->willReturn('1');

        $this->passwordHasher
            ->method('hashPassword')
            ->willReturn(base64_encode($request->password));

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->updateGrowerResponse);

        $this->addProductToHive->execute($growerUpdatedRequest, '1', $this->presenter);
    }

    private static function createGrower($request)
    {
        $grower = new Grower(
            '1',
            $request->firstName,
            $request->lastName,
            $request->email,
            base64_encode($request->password),
            $request->salt,
            $request->role
        );

        $grower->addHive(
            'Breengrow',
            '123456789',
            '20 rue François Ducarouge',
            'Digoin',
            '71160'
        );

        $grower->getHive()->addProduct('1', new \DateTimeImmutable('midnight'), 'fromage', 'fromage de chèvre', 2.3);

        return $grower;
    }
}
