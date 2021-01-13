<?php

declare(strict_types=1);

namespace App\Application\UseCases\Consumer\Show;

use App\Application\UseCases\Response;
use App\Domain\Model\Consumer\Consumer;

final class ShowConsumerResponse extends Response
{
    /**
     * @var Consumer|null
     */
    private ?Consumer $consumer;

    /**
     * @return Consumer|null
     */
    public function getConsumer(): ?Consumer
    {
        return $this->consumer;
    }

    /**
     * @param Consumer $consumer
     */
    public function setConsumer(Consumer $consumer): void
    {
        $this->consumer = $consumer;
    }



}