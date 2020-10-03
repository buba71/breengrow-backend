<?php

declare(strict_types=1);

namespace App\Application\UseCases\Product\Register;

interface RegisterProductPresenter
{
    /**
     * @param RegisterProductResponse $response
     */
    public function present(RegisterProductResponse $response): void;
}
