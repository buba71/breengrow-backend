<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\ShowAlls;

use App\Domain\Model\Grower\Grower;
use App\Domain\Repository\GrowerRepository;

final class ShowAllGrowers
{
    private GrowerRepository $repository;

    public function __construct(GrowerRepository $repository)
    {
        $this->repository = $repository;
    }
    public function execute(ShowAllGrowersPresenter $presenter)
    {
        $response = new ShowAllGRowersResponse();

        $growerCollection =  $this->repository->getAllGrowers();
        $response->setGrowers($growerCollection);
        $response->setStatus(ShowAllGrowersResponse::HTTP_OK);
        
        $presenter->present($response);
    }

}
