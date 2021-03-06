<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\Show;

use App\Application\UseCases\Response;
use App\Domain\Model\Grower\Grower;

final class ShowGrowerResponse extends Response
{
    /**
     * @var Grower|null
     */
    private ?Grower $grower;

    /**
     * @return Grower
     */
    public function getGrower(): ?Grower
    {
        return $this->grower;
    }

    /**
     * @param Grower|null $grower
     */
    public function setGrower(?Grower $grower): void
    {
        $this->grower = $grower;
    }
}
