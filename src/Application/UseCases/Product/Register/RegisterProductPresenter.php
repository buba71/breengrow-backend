<?php

declare(strict_types=1);

namespace App\Application\UseCases\Product\Register;

interface RegisterProductPresenter
{
    /**
     * @param ProductResponse $response
     */
    public function present(ProductResponse $response): void;
}
