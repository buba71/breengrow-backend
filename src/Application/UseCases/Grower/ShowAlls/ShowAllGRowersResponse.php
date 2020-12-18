<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\ShowAlls;

use App\Application\UseCases\Response;

class ShowAllGRowersResponse extends Response
{
    /**
     * @var array
     */
    private array $growers;

    /**
     * @return array
     */
    public function getGrowers(): array
    {
        return $this->growers;
    }

    /**
     * @param array $growers
     */
    public function setGrowers(array $growers): void
    {
        $this->growers = $growers;
    }
}
