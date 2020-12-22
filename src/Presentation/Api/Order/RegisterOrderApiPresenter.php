<?php

declare(strict_types=1);

namespace App\Presentation\Api\Order;

use App\Application\UseCases\Order\Register\RegisterOrderPresenter;
use App\Application\UseCases\Order\Register\RegisterOrderResponse;

/**
 * Class RegisterOrderApiPresenter
 * @package App\Presentation\Api\Order
 */
final class RegisterOrderApiPresenter implements RegisterOrderPresenter
{
    /**
     * @var RegisterOrderApiViewModel
     */
    private RegisterOrderApiViewModel $viewModel;

    /**
     * @param RegisterOrderResponse $response
     */
    public function present(RegisterOrderResponse $response): void
    {
        $this->viewModel = new RegisterOrderApiViewModel();
        if ($response->getNotifier()->hasErrors()) {
            foreach ($response->getNotifier()->getErrors() as $error) {
                $this->viewModel->addNotification($error->fieldName(), $error->message());
            }
        } else {
            $this->viewModel->modelTransformer($response->getOrder());
        }

        $this->viewModel->status = $response->getStatus();
    }

    /**
     * @return RegisterOrderApiViewModel
     */
    public function viewModel(): RegisterOrderApiViewModel
    {
        return $this->viewModel;
    }
}
