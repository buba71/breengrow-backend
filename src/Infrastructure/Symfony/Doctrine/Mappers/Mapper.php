<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Mappers;

use App\Domain\Shared\Aggregate\AggregateRoot;
use App\Infrastructure\Symfony\Doctrine\Entity\DoctrineEntity;

interface Mapper
{
    /**
     * @param AggregateRoot $model
     * @return mixed
     */
    public static function domainToPersistence(AggregateRoot $model);

    /**
     * @param DoctrineEntity $persistenceEntity
     * @return mixed
     */
    public static function persistenceToDomain(DoctrineEntity $persistenceEntity);
}
