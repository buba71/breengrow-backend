<?php

declare(strict_types=1);

namespace App\Application\UseCases\Consumer\Show;

interface ShowConsumerPresenter
{
    /**
     * @param ShowConsumerResponse $response
     */
    public function present(ShowConsumerResponse $response): void;
}
