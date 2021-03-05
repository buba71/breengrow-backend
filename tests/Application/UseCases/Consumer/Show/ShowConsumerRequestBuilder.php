<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Consumer\Show;

use App\Application\UseCases\Consumer\Show\ShowConsumerRequest;

final class ShowConsumerRequestBuilder extends ShowConsumerRequest
{
    private const CONSUMER_ID = '12345';

    /**
     * @return ShowConsumerRequest
     */
    public function build(): ShowConsumerRequest
    {
        $request = new ShowConsumerRequest();
        $request->id = $this->id;

        return $request;
    }

    /**
     * @return self
     */
    public static function default(): self
    {
        $request = new static();
        $request->id = self::CONSUMER_ID;

        return $request;
    }
}