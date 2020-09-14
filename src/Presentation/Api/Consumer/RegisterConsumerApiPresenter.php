<?php

declare(strict_types=1);

namespace App\Presentation\Api\Consumer;

use App\Application\UseCases\Consumer\Register\RegisterConsumerPresenter;
use App\Application\UseCases\Consumer\Register\RegisterConsumerResponse;
use App\Presentation\Api\Consumer\RegisterConsumerApiViewModel;

final class RegisterConsumerApiPresenter implements RegisterConsumerPresenter
{
    private RegisterConsumerApiViewModel $viewModel;

    /**
     * @param RegisterConsumerResponse $response
     * @return void
     */
    public function present(RegisterConsumerResponse $response): void
    {
        $this->viewModel = new RegisterConsumerApiViewModel();

        if ($response->getNotifier()->hasErrors()) {
            foreach ($response->getNotifier()->getErrors() as $error) {
                $this->viewModel->addNotification($error->fieldName(), $error->message());
            }
        } else {
            $this->viewModel->modelTransformer($response->getConsumer());
        }

        $this->viewModel->status = $response->getStatus();
    }


    /**
     * @return \App\Presentation\Api\Consumer\RegisterConsumerApiViewModel
     */
    public function viewModel(): RegisterConsumerApiViewModel
    {
        return $this->viewModel;
    }
}
