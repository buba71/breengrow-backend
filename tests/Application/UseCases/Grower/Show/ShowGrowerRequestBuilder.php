<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Grower\Show;

use App\Application\UseCases\Grower\Show\ShowGrowerRequest;

final class ShowGrowerRequestBuilder extends ShowGrowerRequest
{
    private const GROWER_ID = '12345';

    /**
     * @return ShowGrowerRequest
     */
    public function build(): ShowGrowerRequest
    {
        $request = new ShowGrowerRequest();
        $request->id = $this->id;
        return $request;
    }

    /**
     * @return static
     */
    public static function default(): self
    {
        $request = new static();
        $request->id = self::GROWER_ID;
        return $request;
    }
}