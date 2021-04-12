<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Order\Order;
use App\Domain\Repository\OrderRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Order as OrderEntity;
use App\Infrastructure\Symfony\Doctrine\Mappers\InvoiceMap;
use App\Infrastructure\Symfony\Doctrine\Mappers\OrderMap;
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
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addOrder(Order $order): void
    {
        $orderDoctrineEntity = OrderMap::domainToPersistence($order);

        $this->getEntityManager()->persist($orderDoctrineEntity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return array<Order>
     */
    public function getAllOrders(): array
    {
        $orderCollection =  $this->findAll();
        $orders = [];

        foreach ($orderCollection as $orderDoctrineEntity) {
            $order = OrderMap::persistenceToDomain($orderDoctrineEntity);
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
            $order = OrderMap::persistenceToDomain($orderDoctrineEntity);
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
            $order = OrderMap::persistenceToDomain($orderDoctrineEntity);
            $orders[] = $order;
        }

        return $orders;
    }

    /**
     * @param string $orderId
     * @return Order
     */
    public function getOrderById(string $orderId): Order
    {
        $orderDoctrineEntity = $this->findOneBy(['number' => $orderId]);
        return OrderMap::persistenceToDomain($orderDoctrineEntity);
    }

    public function update(Order $order)
    {
        $invoiceDoctrineEntity = InvoiceMap::domainToPersistence($order->getInvoice());
        // Get current order and update it with invoice generated.
        $orderDoctrineEntity = $this->findOneBy(['number' => $order->getNumber()]);
        $orderDoctrineEntity->setInvoice($invoiceDoctrineEntity);

        $this->getEntityManager()->flush();
    }
}
