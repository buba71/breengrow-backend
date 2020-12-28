<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower;

use App\Application\UseCases\Grower\AddProducts\AddProductsToHiveGrowerResponse;
use App\Application\UseCases\Grower\AddProducts\AddProductsToHivePresenter;

final class AddProductsToHiveGrowerApiPresenter implements AddProductsToHivePresenter
{
    /**
     * @var AddProductsToHIveGrowerViewModel
     */
    private AddProductsToHIveGrowerViewModel $viewModel;

    /**
     * @param AddProductsToHiveGrowerResponse $response
     * @return mixed|void
     */
    public function present(AddProductsToHiveGrowerResponse $response)
    {
        $this->viewModel = new AddProductsToHIveGrowerViewModel();

        if ($response->getNotifier()->hasErrors()) {
            foreach ($response->getNotifier()->getErrors() as $error) {
                $this->viewModel()->addNotification($error->fieldName(), $error->message());
            }

        } else {
            $this->viewModel()->transformModel($response->getGrower());
        }

        $this->viewModel->status = $response->getStatus();
    }

    /**
     * @return AddProductsToHIveGrowerViewModel
     */
    public function viewModel(): AddProductsToHIveGrowerViewModel
    {
        return $this->viewModel;
    }
}
