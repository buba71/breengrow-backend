<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\Show;

interface ShowGrowerPresenter
{
    /**
     * @param ShowGrowerResponse $response
     */
    public function present(ShowGrowerResponse $response): void;
}
