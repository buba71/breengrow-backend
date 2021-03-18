<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Shared\Aggregate\AggregateRoot;

interface ExportDomain
{
    /**
     * @param AggregateRoot $domainModel
     * @return mixed
     */
    public function export(AggregateRoot $domainModel);

}