<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\ShowAlls;

use App\Application\UseCases\Response;
use App\Domain\Model\Grower\Grower;

class ShowAllGrowersResponse extends Response
{
    /**
     * @var array<Grower>
     */
    private array $growers;

    /**
     * @return array<Grower>
     */
    public function getGrowers(): array
    {
        return $this->growers;
    }

    /**
     * @param array<Grower> $growers
     */
    public function setGrowers(array $growers): void
    {
        $this->growers = $growers;
    }
}
