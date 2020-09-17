<?php

declare(strict_types=1);

namespace App\Presentation\Api\Deliverer;

use App\Application\UseCases\Deliverer\Register\RegisterDelivererPresenter;
use App\Application\UseCases\Deliverer\Register\RegisterDelivererResponse;

final class RegisterDelivererApiPresenter implements RegisterDelivererPresenter
{
    /**
     * @var RegisterDelivererApiViewModel
     */
    private RegisterDelivererApiViewModel $viewModel;

    /**
     * @param RegisterDelivererResponse $response
     */
    public function present(RegisterDelivererResponse $response): void
    {
        $this->viewModel = new RegisterDelivererApiViewModel();

        if ($response->getNotifier()->hasErrors()) {
            foreach ($response->getNotifier()->getErrors() as $error) {
                $this->viewModel->addNotification($error->fieldName(), $error->message());
            }
        } else {
            $this->viewModel->modelTransformer($response->getDeliverer());
        }
        $this->viewModel->status = $response->getStatus();
    }

    /**
     * @return RegisterDelivererApiViewModel
     */
    public function viewModel(): RegisterDelivererApiViewModel
    {
        return $this->viewModel;
    }
}
