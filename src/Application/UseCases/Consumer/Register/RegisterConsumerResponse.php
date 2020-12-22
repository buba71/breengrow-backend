<?php

declare(strict_types=1);

namespace App\Application\UseCases\Consumer\Register;

use App\Application\UseCases\Response;
use App\Domain\Model\Consumer\Consumer;


final class RegisterConsumerResponse extends Response
{
    /**
     * @var Consumer
     */
    private Consumer $consumer;

    /**
     * @param Consumer $consumer
     */
    public function setConsumer(Consumer $consumer): void
    {
        $this->consumer = $consumer;
    }

    /**
     * @return Consumer
     */
    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }
}
