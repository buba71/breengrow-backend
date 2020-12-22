<?php

declare(strict_types=1);

namespace App\Application\UseCases\Deliverer\Register;

use App\Application\UseCases\Response;
use App\Domain\Model\Deliverer\Deliverer;

final class RegisterDelivererResponse extends Response
{
    /**
     * @var Deliverer
     */
    private Deliverer $deliverer;

    /**
     * @return Deliverer
     */
    public function getDeliverer(): Deliverer
    {
        return $this->deliverer;
    }

    /**
     * @param Deliverer $deliverer
     */
    public function setDeliverer(Deliverer $deliverer): void
    {
        $this->deliverer = $deliverer;
    }
}
