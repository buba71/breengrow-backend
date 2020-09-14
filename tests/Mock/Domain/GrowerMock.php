<?php

declare(strict_types=1);

namespace App\Tests\Mock\Domain;

use App\Application\UseCases\Grower\Register\RegisterGrowerRequest;
use App\Domain\Model\Grower\Grower;
use App\Domain\Model\Grower\Hive;

class GrowerMock extends Grower
{
    public static function getGrowerMock(RegisterGrowerRequest $request): Grower
    {
        return new self(
            '1',
            $request->firstName,
            $request->lastName,
            $request->email,
            base64_encode($request->password),
            $request->salt,
            $request->role,
            static::buildHive()
        );
    }

    private static function buildHive(): Hive
    {
        return new Hive(
            null,
            'Breengrow',
            '123456789',
            '20 rue François Ducarouge',
            'Digoin',
            '71160'
        );
    }
}
