<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\AddProducts;

use App\Application\UseCases\Response;
use App\Domain\Model\Grower\Grower;

final class AddProductsToHiveGrowerResponse extends Response
{
    /**
     * @var Grower
     */
    private Grower $grower;

    /**
     * @return Grower
     */
    public function getGrower(): Grower
    {
        return $this->grower;
    }

    /**
     * @param Grower $grower
     */
    public function setGrower(Grower $grower): void
    {
        $this->grower = $grower;
    }
}
