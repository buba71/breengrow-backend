<?php

declare(strict_types=1);

namespace App\Tests\Mock\Infrastructue\Services\Export;

use App\Domain\Services\ExportDomain;
use App\Domain\Shared\Aggregate\AggregateRoot;

/**
 * Class ExportToPdfMock
 * @package App\Tests\Mock\Infrastructue\Services\Export
 */
final class ExportToPdfMock implements ExportDomain
{
    /**
     * @param AggregateRoot $domainModel
     * @return string
     */
    public function export(AggregateRoot $domainModel): string
    {
        return str_replace(
            '-',
            '',
            str_replace(' ', '', (string)$domainModel->getNumber())
        );
    }
}
