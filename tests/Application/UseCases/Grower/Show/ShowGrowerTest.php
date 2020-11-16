<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Grower\Show;

use App\Application\UseCases\Grower\Show\ShowGrower;
use App\Application\UseCases\Grower\Show\ShowGrowerPresenter;
use App\Application\UseCases\Grower\Show\ShowGrowerResponse;
use App\Domain\Model\Grower\Grower;
use App\Domain\Repository\GrowerRepository;
use App\Tests\Mock\Domain\InMemoryGrowerRepository;
use PHPUnit\Framework\TestCase;

final class ShowGrowerTest extends TestCase
{
    private ShowGrower $showGrower;
    private GrowerRepository $growerRepository;
    private ShowGrowerPresenter $presenter;
    private ShowGrowerResponse $response;

    protected function setUp(): void
    {
        $this->growerRepository = new InMemoryGrowerRepository();
        $this->showGrower = new ShowGrower($this->growerRepository);
        $this->presenter = $this->getMockBuilder(ShowGrowerPresenter::class)
                                ->setMethods(['present'])
                                ->getMock();
        $this->response = new ShowGrowerResponse();
    }

    public function testIfReturnAGrower()
    {
        $request =  ShowGrowerRequestBuilder::default()->build();
        $this->growerRepository->addGrower(self::createGrower());

        $this->response->setGrower(self::createGrower());
        $this->response->setStatus(200);

        $this->presenter->expects($this->once())
                        ->method('present')
                        ->with($this->response);

        $this->showGrower->execute($request, $this->presenter);
    }

    public static function createGrower()
    {
        return new Grower(
            '12345',
            'John',
            'Doe',
            'test@test.com',
            'azeaze',
            'salt',
            ['ROLE_GROWER']
        );
    }
}
