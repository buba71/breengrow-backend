<?php

declare(strict_types=1);

namespace App\Application\UseCases\Consumer\Register;

interface RegisterConsumerPresenter
{
    /**
     * @param RegisterConsumerResponse $response
     * @return mixed
     */
    public function present(RegisterConsumerResponse $response);
}
