<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\ShowAlls;

interface ShowAllGrowersPresenter
{
    /**
     * @param ShowAllGrowersResponse $response
     */
    public function present(ShowAllGrowersResponse $response): void;

}