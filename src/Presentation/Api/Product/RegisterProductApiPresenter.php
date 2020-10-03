<?php

declare(strict_types=1);

namespace App\Presentation\Api\Product;

use App\Application\UseCases\Product\Register\RegisterProductPresenter;
use App\Application\UseCases\Product\Register\RegisterProductResponse;

final class RegisterProductApiPresenter implements RegisterProductPresenter
{
    /**
     * @var RegisterProductApiViewModel
     */
    private RegisterProductApiViewModel $viewModel;

    /**
     * @param RegisterProductResponse $response
     */
    public function present(RegisterProductResponse $response): void
    {
        $this->viewModel = new RegisterProductApiViewModel();

        if ($response->getNotifier()->hasErrors()) {
            foreach ($response->getNotifier()->getErrors() as $error) {
                $this->viewModel->addNotification($error->fieldName(), $error->message());
            }
        } else {
            $this->viewModel->modelTransformer($response->getProduct());
        }

        $this->viewModel->status = $response->getStatus();
    }

    /**
     * @return RegisterProductApiViewModel
     */
    public function viewModel(): RegisterProductApiViewModel
    {
        return $this->viewModel;
    }
}