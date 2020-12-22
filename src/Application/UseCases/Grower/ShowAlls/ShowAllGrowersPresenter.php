<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\ShowAlls;

interface ShowAllGrowersPresenter
{
    /**
     * @param ShowAllGRowersResponse $response
     */
    public function present(ShowAllGRowersResponse $response): void;

}