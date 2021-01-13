<?php

declare(strict_types=1);

namespace App\Presentation\Api\Consumer;

use App\Application\UseCases\Consumer\Show\ShowConsumerPresenter;
use App\Application\UseCases\Consumer\Show\ShowConsumerResponse;

final class ShowConsumerApiPresenter implements ShowConsumerPresenter
{

    /**
     * @var ShowConsumerApiViewModel
     */
    private ShowConsumerApiViewModel $viewModel;

    /**
     * @param ShowConsumerResponse $response
     */
    public function present(ShowConsumerResponse $response): void
    {
        $this->viewModel = new ShowConsumerApiViewModel();

        $this->viewModel->transformModel($response->getConsumer());
        $this->viewModel->status = $response->getStatus();
    }

    /**
     * @return ShowConsumerApiViewModel
     */
    public function viewModel(): ShowConsumerApiViewModel
    {
        return $this->viewModel;
    }
}