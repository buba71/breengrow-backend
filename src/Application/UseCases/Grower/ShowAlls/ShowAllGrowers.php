<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\ShowAlls;

use App\Domain\Model\Grower\Grower;
use App\Domain\Repository\GrowerRepository;

final class ShowAllGrowers
{
    /**
     * @var GrowerRepository
     */
    private GrowerRepository $repository;

    /**
     * ShowAllGrowers constructor.
     * @param GrowerRepository $repository
     */
    public function __construct(GrowerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ShowAllGrowersPresenter $presenter
     */
    public function execute(ShowAllGrowersPresenter $presenter): void
    {
        $response = new ShowAllGrowersResponse();

        $growerCollection =  $this->repository->getAllGrowers();
        $response->setGrowers($growerCollection);
        $response->setStatus(ShowAllGrowersResponse::HTTP_OK);
        
        $presenter->present($response);
    }

}
