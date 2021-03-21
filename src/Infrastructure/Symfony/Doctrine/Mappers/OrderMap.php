<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Mappers;

use App\Domain\Model\Order\Order;
use App\Domain\Shared\Aggregate\AggregateRoot;
use App\Infrastructure\Symfony\Doctrine\Entity\DoctrineEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\Order as OrderEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\OrderLine as OrderLineEntity;

final class OrderMap implements Mapper
{

    /**
     * @param AggregateRoot $model
     * @return OrderEntity
     */
    public static function domainToPersistence(AggregateRoot $model): OrderEntity
    {
        $orderDoctrineEntity = new OrderEntity();

        $orderDoctrineEntity->setNumber($model->getNumber());
        $orderDoctrineEntity->setConsumerId($model->getConsumerId());
        $orderDoctrineEntity->setCompanySiret($model->getHiveSiret());
        $orderDoctrineEntity->setReceivedAt($model->getReceivedAt());
        $orderDoctrineEntity->setStatus($model->getStatus());
        $orderDoctrineEntity->setAmount($model->getAmount());

        foreach ($model->getOrderLines() as $orderLine) {
            $orderLineDoctrineEntity = new OrderLineEntity();
            $orderLineDoctrineEntity->setOrder($orderDoctrineEntity);
            $orderLineDoctrineEntity->setProductId($orderLine->getProductId());
            $orderLineDoctrineEntity->setQuantity($orderLine->getQuantity());
            $orderLineDoctrineEntity->setPrice($orderLine->getLinePrice());

            $orderDoctrineEntity->addOrderLine($orderLineDoctrineEntity);
        }

        return $orderDoctrineEntity;
    }

    /**
     * @param DoctrineEntity $persistenceEntity
     * @return Order
     */
    public static function persistenceToDomain(DoctrineEntity $persistenceEntity): Order
    {
        $order = new Order(
            $persistenceEntity->getConsumer(),
            $persistenceEntity->getCompanySiret(),
            $persistenceEntity->getReceivedAt(),
            $persistenceEntity->getNumber(),
            $persistenceEntity->getStatus()
        );

        foreach ($persistenceEntity->getOrderLines() as $orderLineDoctrineEntity) {
            $order->addOrderLine(
                $orderLineDoctrineEntity->getProductId(),
                $orderLineDoctrineEntity->getQuantity(),
                $orderLineDoctrineEntity->getPrice()
            );
        }
        return $order;
    }
}