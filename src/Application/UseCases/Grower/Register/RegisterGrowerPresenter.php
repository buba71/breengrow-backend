<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\Register;

interface RegisterGrowerPresenter
{
    /**
     * @param RegisterGrowerResponse $response
     * @return mixed
     */
    public function present(RegisterGrowerResponse $response);
}