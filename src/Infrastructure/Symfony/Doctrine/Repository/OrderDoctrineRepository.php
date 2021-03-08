<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Order\Order;
use App\Domain\Repository\OrderRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Order as OrderEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\OrderLine as OrderLineEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\Persistence\ManagerRegistry;

class OrderDoctrineRepository extends ServiceEntityRepository implements OrderRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderEntity::class);
    }

    /**
     * @param Order $order

     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addOrder(Order $order)
    {
        $orderDoctrineEntity = new OrderEntity();
        
        $orderDoctrineEntity->setNumber($order->getNumber());
        $orderDoctrineEntity->setConsumerId($order->getConsumerId());
        $orderDoctrineEntity->setCompanySiret($order->getHiveSiret());
        $orderDoctrineEntity->setReceivedAt($order->getReceivedAt());
        $orderDoctrineEntity->setStatus($order->getStatus());
        $orderDoctrineEntity->setAmount($order->getAmount());

        foreach ($order->getOrderLines() as $orderLine) {
            $orderLineDoctrineEntity = new OrderLineEntity();
            $orderLineDoctrineEntity->setOrder($orderDoctrineEntity);
            $orderLineDoctrineEntity->setProductId($orderLine->getProductId());
            $orderLineDoctrineEntity->setQuantity($orderLine->getQuantity());
            $orderLineDoctrineEntity->setPrice($orderLine->getLinePrice());

            $orderDoctrineEntity->addOrderLine($orderLineDoctrineEntity);
        }

        $this->getEntityManager()->persist($orderDoctrineEntity);
        $this->getEntityManager()->flush();

        return $orderDoctrineEntity;
    }

    /**
     * @return array<Order>
     */
    public function getAllOrders(): array
    {
        $orderCollection =  $this->findAll();
        $orders = [];

        foreach ($orderCollection as $orderDoctrineEntity) {
            $order = new Order(
                $orderDoctrineEntity->getConsumer(),
                $orderDoctrineEntity->getCompanySiret(),
                $orderDoctrineEntity->getDate(),
                $orderDoctrineEntity->getNumber(),
                $orderDoctrineEntity->getStatus()
            );
            foreach ($orderDoctrineEntity->getOrderLines() as $orderLineDoctrineEntity) {
                $order->addOrderLine(
                    $orderLineDoctrineEntity->getProductId(),
                    $orderLineDoctrineEntity->getQuantity(),
                    $orderLineDoctrineEntity->getPrice()
                );
            }

            $orders[] = $order;
        }

        return $orders;
    }

    /**
     * @param string $hiveSiret
     * @return array<Order>
     */
    public function getOrdersByHive(string $hiveSiret): array
    {
        $orderCollection =  $this->findBy(['companySiret' => $hiveSiret]);
        $orders = [];

        foreach ($orderCollection as $orderDoctrineEntity) {
            $order = new Order(
                $orderDoctrineEntity->getConsumer(),
                $orderDoctrineEntity->getCompanySiret(),
                $orderDoctrineEntity->getDate(),
                $orderDoctrineEntity->getNumber(),
                $orderDoctrineEntity->getStatus()
            );
            foreach ($orderDoctrineEntity->getOrderLines() as $orderLineDoctrineEntity) {
                $order->addOrderLine(
                    $orderLineDoctrineEntity->getProductId(),
                    $orderLineDoctrineEntity->getQuantity(),
                    $orderLineDoctrineEntity->getPrice()
                );
            }

            $orders[] = $order;
        }

        return $orders;
    }

    /**
     * @param string $consumerId
     * @return array<Order>
     */
    public function getOrdersByConsumer(string $consumerId): array
    {
        $orderCollection =  $this->findBy(['consumerId' => $consumerId]);
        $orders = [];

        foreach ($orderCollection as $orderDoctrineEntity) {
            $order = new Order(
                $orderDoctrineEntity->getConsumer(),
                $orderDoctrineEntity->getCompanySiret(),
                $orderDoctrineEntity->getDate(),
                $orderDoctrineEntity->getNumber(),
                $orderDoctrineEntity->getStatus()
            );
            foreach ($orderDoctrineEntity->getOrderLines() as $orderLineDoctrineEntity) {
                $order->addOrderLine(
                    $orderLineDoctrineEntity->getProductId(),
                    $orderLineDoctrineEntity->getQuantity(),
                    $orderLineDoctrineEntity->getPrice()
                );
            }

            $orders[] = $order;
        }

        return $orders;
    }

    public function getOrderById(string $orderId): Order
    {
        $orderEntity = $this->findOneBy(['number' => $orderId]);
        $order = new Order(
            $orderEntity->getConsumer(),
            $orderEntity->getCompanySiret(),
            $orderEntity->getReceivedAt(),
            $orderEntity->getNumber(),
            $orderEntity->getStatus()
        );

        foreach ($orderEntity->getOrderLines() as $orderLine) {
            $order->addOrderLine($orderLine->getProductId(), $orderLine->getQuantity(), $orderLine->getPrice());
        }
        return $order;
    }
}
