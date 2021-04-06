<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Mappers;

use App\Domain\Shared\Aggregate\AggregateRoot;

interface Mapper
{
    /**
     * @param AggregateRoot $model
     * @return mixed
     */
    public static function domainToPersistence(AggregateRoot $model);

    /**
     * @param object $persistenceEntity
     * @return mixed
     */
    public static function persistenceToDomain(object $persistenceEntity);
}
