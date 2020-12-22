<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\Register;

use App\Application\UseCases\Response;
use App\Domain\Model\Grower\Grower;

/**
 * Class RegisterGrowerResponse
 * @package App\Application\UseCases\Grower
 */
final class RegisterGrowerResponse extends Response
{
    /**
     * @var Grower
     */
    private Grower $grower;

    /**
     * @param Grower $grower
     */
    public function setGrower(Grower $grower): void
    {
        $this->grower = $grower;
    }

    /**
     * @return Grower
     */
    public function getGrower(): Grower
    {
        return $this->grower;
    }
}
