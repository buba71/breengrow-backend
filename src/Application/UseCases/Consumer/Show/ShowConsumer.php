<?php

declare(strict_types=1);

namespace App\Application\UseCases\Consumer\Show;

use App\Domain\Repository\ConsumerRepository;

final class ShowConsumer
{
    /**
     * @var ConsumerRepository
     */
    private ConsumerRepository $repository;

    /**
     * ShowConsumer constructor.
     * @param ConsumerRepository $repository
     */
    public function __construct(ConsumerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ShowConsumerRequest $request
     * @param ShowConsumerPresenter $presenter
     */
    public function execute(ShowConsumerRequest $request, ShowConsumerPresenter $presenter): void
    {
        $response = new ShowConsumerResponse();

        $consumer = $this->repository->getConsumerById($request->id);
        $response->setConsumer($consumer);
        $response->setStatus(ShowConsumerResponse::HTTP_OK);

        $presenter->present($response);
    }
}