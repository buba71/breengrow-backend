<?php

declare(strict_types=1);

namespace App\Application\UseCases\Deliverer\Register;

interface RegisterDelivererPresenter
{
    /**
     * @param RegisterDelivererResponse $response
     * @return mixed
     */
    public function present(RegisterDelivererResponse $response);
}