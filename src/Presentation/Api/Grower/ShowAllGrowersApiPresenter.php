<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower;

use App\Application\UseCases\Grower\ShowAlls\ShowAllGrowersPresenter;
use App\Application\UseCases\Grower\ShowAlls\ShowAllGRowersResponse;

final class ShowAllGrowersApiPresenter implements ShowAllGrowersPresenter
{
    /**
     * @var ShowAllGrowersApiViewModel
     */
    private ShowAllGrowersApiViewModel $viewModel;

    /**
     * @param ShowAllGRowersResponse $response
     */
    public function present(ShowAllGRowersResponse $response): void
    {
        $this->viewModel = new ShowAllGrowersApiViewModel();

        $this->viewModel->transformModel($response->getGrowers());
        $this->viewModel->status = $response->getStatus();
    }

    /**
     * @return ShowAllGrowersApiViewModel
     */
    public function viewModel()
    {
        return $this->viewModel;
    }
}
