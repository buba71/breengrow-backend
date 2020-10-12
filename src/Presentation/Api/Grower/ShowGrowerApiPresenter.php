<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower;

use App\Application\UseCases\Grower\Show\ShowGrowerPresenter;
use App\Application\UseCases\Grower\Show\ShowGrowerResponse;

class ShowGrowerApiPresenter implements ShowGrowerPresenter
{
    /**
     * @var ShowGrowerApiViewModel
     */
    private ShowGrowerApiViewModel $viewModel;

    public function present(ShowGrowerResponse $response): void
    {
        $this->viewModel = new ShowGrowerApiViewModel();
        $this->viewModel->transformModel($response->getGrower());
        $this->viewModel->status = $response->getStatus();
    }

    /**
     * @return ShowGrowerApiViewModel
     */
    public function viewModel(): ShowGrowerApiViewModel
    {
        return $this->viewModel;
    }
}
