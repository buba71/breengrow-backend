<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Mappers;

use App\Domain\Shared\Aggregate\AggregateRoot;
use App\Infrastructure\Symfony\Doctrine\Entity\Deliverer;
use App\Infrastructure\Symfony\Doctrine\Entity\Deliverer as DelivererEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\DoctrineEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\User as UserEntity;

final class DelivererMap implements Mapper
{

    /**
     * @param AggregateRoot $model
     * @return DelivererEntity
     */
    public static function domainToPersistence(AggregateRoot $model): DelivererEntity
    {
        $delivererEntity = new DelivererEntity();
        $delivererEntity->setId($model->getId());
        $delivererEntity->setFirstName($model->getFirstName());
        $delivererEntity->setLastName($model->getLastName());
        $delivererEntity->setPhone($model->getPhone());

        $userEntity = new userEntity();
        $userEntity->setEmail($model->getEmail());
        $userEntity->setParentId($model->getId());
        $userEntity->setPassword($model->getPassword());
        $userEntity->setSalt($model->getSalt());
        $userEntity->setRoles($model->getRole());

        $delivererEntity->setUser($userEntity);

        return $delivererEntity;
    }

    /**
     * @param DoctrineEntity $persistenceEntity
     * @return mixed|void
     */
    public static function persistenceToDomain(DoctrineEntity $persistenceEntity)
    {
        // TODO: Implement persistenceToDomain() method.
    }
}