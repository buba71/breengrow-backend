<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Consumer\Show;

use App\Application\UseCases\Consumer\Show\ShowConsumerRequest;

final class ShowConsumerRequestBuilder extends ShowConsumerRequest
{
    private const CONSUMER_ID = '12345';

    public function build()
    {
        $request = new ShowConsumerRequest();
        $request->id = $this->id;

        return $request;
    }

    public static function default()
    {
        $request = new static();
        $request->id = self::CONSUMER_ID;

        return $request;
    }
}