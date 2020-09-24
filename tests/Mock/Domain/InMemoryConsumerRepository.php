<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Domain\Model\Consumer\Consumer;
use App\Domain\Repository\ConsumerRepository;

class InMemoryConsumerRepository implements ConsumerRepository
{
    private array $consumers = [];

    /**
     * @param Consumer $consumer
     * @return mixed|void
     */
    public function addConsumer(Consumer $consumer)
    {
        $this->consumers[] = $consumer;
    }

    public function getConsumerById(string $id): ?Consumer
    {
        $consumerFound = array_filter($this->consumers, fn(Consumer $consumer) => $consumer->getId() === $id);

        if (count($consumerFound) === 1) {
            return $consumerFound[0];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getConsumers()
    {
        return $this->consumers;
    }

    public function getConsumerByEmail(string $email)
    {
        $consumerFound = array_filter($this->consumers, fn(Consumer $consumer) => $consumer->getEmail() === $email);

        if (count($consumerFound) === 1) {
            return $consumerFound[0];
        }
        return null;
    }
}
