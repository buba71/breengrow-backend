<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\Show;

use App\Domain\Repository\GrowerRepository;

/**
 * Class ShowGrower
 * @package App\Application\UseCases\Grower\Show
 */
final class ShowGrower
{
    private GrowerRepository $repository;

    /**
     * ShowGrower constructor.
     * @param GrowerRepository $repository
     */
    public function __construct(GrowerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ShowGrowerRequest $request
     * @param ShowGrowerPresenter $presenter
     */
    public function execute(ShowGrowerRequest $request, ShowGrowerPresenter $presenter): void
    {
        $response = new ShowGrowerResponse();
        $grower = $this->repository->getGrowerById($request->id);
        $response->setStatus(ShowGrowerResponse::HTTP_OK);
        $response->setGrower($grower);

        $presenter->present($response);
    }
}

