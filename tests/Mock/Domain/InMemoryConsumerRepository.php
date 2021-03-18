<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Consumer\Consumer;
use App\Domain\Model\Invoice\BillingAddress;
use App\Domain\Repository\ConsumerRepository;

/**
 * Class InMemoryConsumerRepository
 * @package App\Tests\Mock\Domain
 */
final class InMemoryConsumerRepository implements ConsumerRepository
{
    /**
     * @var Consumer[]
     */
    private array $consumers = [];

    /**
     * @param Consumer $consumer
     * @return void
     */
    public function addConsumer(Consumer $consumer): void
    {
        $this->consumers[] = $consumer;
    }

    /**
     * @param string $id
     * @return Consumer|null
     */
    public function getConsumerById(string $id): ?Consumer
    {
        $consumerFound = array_filter($this->consumers, fn(Consumer $consumer) => $consumer->getId() === $id);

        if (count($consumerFound) === 1) {
            return $consumerFound[0];
        }
        return null;
    }


    /**
     * @return Consumer[]
     */
    public function getConsumers(): array
    {
        return $this->consumers;
    }

    /**
     * @param string $email
     * @return Consumer|null
     */
    public function getConsumerByEmail(string $email): ?Consumer
    {
        $consumerFound = array_filter($this->consumers, fn(Consumer $consumer) => $consumer->getEmail() === $email);

        if (count($consumerFound) === 1) {
            return $consumerFound[0];
        }
        return null;
    }

    public function getBillingAddress(string $consumerId): BillingAddress
    {
        return new BillingAddress('Consumer', 'test', 'street test', '00000', 'test city', 'BILL');
    }
}
