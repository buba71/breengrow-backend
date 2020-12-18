<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Order\Order;
use App\Domain\Repository\OrderRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Order as OrderEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\OrderLine as OrderLineEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderDoctrineRepository extends ServiceEntityRepository implements OrderRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderEntity::class);
    }

    /**
     * @param Order $order
     * @return OrderEntity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addOrder(Order $order): OrderEntity
    {
        $orderEntity = new OrderEntity();
        
        $orderEntity->setNumber($order->getNumber());
        $orderEntity->setConsumerId($order->getConsumerId());
        $orderEntity->setStatus($order->getStatus());
        $orderEntity->setAmount($order->getAmount());

        foreach ($order->getOrderLines() as $orderLine) {
            $orderLineEntity = new OrderLineEntity();
            $orderLineEntity->setOrder($orderEntity);
            $orderLineEntity->setProductId($orderLine->getProductId());
            $orderLineEntity->setQuantity($orderLine->getQuantity());
            $orderLineEntity->setPrice($orderLine->getLinePrice());

            $orderEntity->addOrderLine($orderLineEntity);
        }

        $this->getEntityManager()->persist($orderEntity);
        $this->getEntityManager()->flush();

        return $orderEntity;
    }

    public function getAllOrders()
    {
        // TODO: Implement getAllOrders() method.
    }
}
