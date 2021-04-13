<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Mappers;

use App\Domain\Model\Consumer\Consumer;
use App\Domain\Shared\Aggregate\AggregateRoot;
use App\Infrastructure\Symfony\Doctrine\Entity\Consumer as ConsumerEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\ConsumerAddress as ConsumerAddressEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\User as UserEntity;

final class ConsumerMap implements Mapper
{

    /**
     * @param AggregateRoot $model
     * @return ConsumerEntity
     */
    public static function domainToPersistence(AggregateRoot $model): ConsumerEntity
    {
        $consumerEntity = new ConsumerEntity();

        $consumerEntity->setId($model->getId());
        $consumerEntity->setFirstName($model->getFirstName());
        $consumerEntity->setLastName($model->getLastName());


        $userEntity = new UserEntity();

        $userEntity->setEmail($model->getEmail());
        $userEntity->setParentId($model->getId());
        $userEntity->setPassword($model->getPassword());
        $userEntity->setSalt($model->getSalt());
        $userEntity->setRoles($model->getRole());
        $consumerEntity->setUser($userEntity);

        foreach ($model->getAddresses() as $address) {
            $consumerAddressEntity = new ConsumerAddressEntity();

            $consumerAddressEntity->setConsumer($consumerEntity);
            $consumerAddressEntity->setFirstName($address->getFirstName());
            $consumerAddressEntity->setLastName($address->getLastName());
            $consumerAddressEntity->setStreet($address->getStreet());
            $consumerAddressEntity->setZipCode($address->getZipCode());
            $consumerAddressEntity->setCity($address->getCity());
            $consumerAddressEntity->setType($address->getType());
            $consumerEntity->addAddress($consumerAddressEntity);
        }

        return $consumerEntity;
    }

    /**
     * @param object|null $persistenceEntity
     * @return Consumer|null
     */
    public static function persistenceToDomain(?object $persistenceEntity): ?Consumer
    {
        if (!$persistenceEntity) {
            return null;
        }

        $consumer = new Consumer(
            $persistenceEntity->getId(),
            $persistenceEntity->getFirstName(),
            $persistenceEntity->getLastName(),
            $persistenceEntity->getUser()->getEmail(),
            $persistenceEntity->getUser()->getPassword(),
            $persistenceEntity->getUser()->getSalt(),
            $persistenceEntity->getUser()->getRoles()
        );

        foreach ($persistenceEntity->getConsumerAddresses() as $address) {
            $consumer->addAddress(
                $address->getFirstName(),
                $address->getLastName(),
                $address->getStreet(),
                $address->getZipCode(),
                $address->getCity(),
                $address->getType()
            );
        }

        return $consumer;
    }
}
