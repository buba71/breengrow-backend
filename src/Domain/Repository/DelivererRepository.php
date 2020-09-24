<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Deliverer\Deliverer;

interface DelivererRepository
{
    /**
     * @param Deliverer $deliverer
     * @return mixed
     */
    public function addDeliverer(Deliverer $deliverer);

    /**
     * @param string $id
     * @return Deliverer|null
     */
    public function getDelivererById(string $id): ?Deliverer;

    /**
     * @param string $email
     * @return Deliverer
     */
    public function getDelivererByEmail(string $email): ?Deliverer;
}
