<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Consumer\Consumer;
use App\Domain\Model\Invoice\BillingAddress;

interface ConsumerRepository
{
    /**
     * @param Consumer $consumer
     * @return mixed
     */
    public function addConsumer(Consumer $consumer);

    /**
     * @param string $id
     * @return Consumer|null
     */
    public function getConsumerById(string $id): ?Consumer;

    /**
     * @param string $email
     * @return mixed
     */
    public function getConsumerByEmail(string $email);

    /**
     * @param string $consumerId
     * @return BillingAddress
     */
    public function getBillingAddress(string $consumerId): BillingAddress;
}
