<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Grower\Show;

use App\Application\UseCases\Grower\ShowAlls\ShowAllGrowers;
use App\Application\UseCases\Grower\ShowAlls\ShowAllGrowersPresenter;
use App\Application\UseCases\Grower\ShowAlls\ShowAllGRowersResponse;
use App\Domain\Model\Grower\Grower;
use App\Tests\Mock\Domain\InMemoryGrowerRepository;
use PHPUnit\Framework\TestCase;

final class ShowAllGrowersTest extends TestCase
{
    private InMemoryGrowerRepository $repository;
    private ShowAllGrowersPresenter $presenter;
    private ShowAllGRowersResponse $response;
    private ShowAllGrowers $showAllGrowersUseCase;

    protected function setUp(): void
    {
        $this->presenter = $this->getMockBuilder(ShowAllGrowersPresenter::class)
            ->setMethods(['present'])
            ->getMock();
        $this->repository = new InMemoryGrowerRepository();
        $this->response = new ShowAllGRowersResponse();
        $this->showAllGrowersUseCase = new ShowAllGrowers($this->repository);
    }

    public function testIfReturnGrowerList()
    {
        $growerList = $this->createGrowers();

        foreach ($growerList as $grower) {
            $this->repository->addGrower($grower);
        }

        $this->response->setStatus(200);
        $this->response->setGrowers($growerList);

        $this->presenter->expects($this->once())
            ->method('present')
            ->with($this->response);

        $this->showAllGrowersUseCase->execute($this->presenter);
    }

    public function createGrowers()
    {
        $growers = [];
        for ($i = 1; $i >= 0; $i--) {
            $grower = new Grower("{$i}", "firstName{$i}", "lastName{$i}", "emai{$i}@test.com", "azeaze", null, []);
            $growers[] = $grower;
        }
        return $growers;
    }
}
