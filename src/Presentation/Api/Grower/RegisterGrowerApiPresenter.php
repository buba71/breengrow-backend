<?php

declare(strict_types=1);

namespace App\Presentation\Api\Grower;

use App\Application\UseCases\Grower\Register\RegisterGrowerPresenter;
use App\Application\UseCases\Grower\Register\RegisterGrowerResponse;

final class RegisterGrowerApiPresenter implements RegisterGrowerPresenter
{
    private RegisterGrowerApiViewModel $viewModel;

    /**
     * @param RegisterGrowerResponse $response
     * @return void
     */
    public function present(RegisterGrowerResponse $response): void
    {
        $this->viewModel = new RegisterGrowerApiViewModel();

        if ($response->getNotifier()->hasErrors()) {
            foreach ($response->getNotifier()->getErrors() as $error) {
                $this->viewModel->addNotification($error->fieldName(), $error->message());
            }
        } else {
            $this->viewModel->modelTransformer($response->getGrower());
        }

        $this->viewModel->status = $response->getStatus();
    }

    /**
     * @return RegisterGrowerApiViewModel
     */
    public function viewModel(): RegisterGrowerApiViewModel
    {
        return $this->viewModel;
    }


}