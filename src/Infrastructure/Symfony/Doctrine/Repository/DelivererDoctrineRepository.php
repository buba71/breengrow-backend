<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Deliverer\Deliverer;
use App\Domain\Repository\DelivererRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Deliverer as DelivererEntity;
use App\Infrastructure\Symfony\Doctrine\Mappers\DelivererMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DelivererDoctrineRepository extends ServiceEntityRepository implements DelivererRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DelivererEntity::class);
    }

    public function addDeliverer(Deliverer $deliverer)
    {
        $delivererEntity = DelivererMap::domainToPersistence($deliverer);

        $this->getEntityManager()->persist($delivererEntity);
        $this->getEntityManager()->flush();
    }

    public function getDelivererById(string $id): ?Deliverer
    {
        return null;
    }

    public function getDelivererByEmail(string $email): ?Deliverer
    {
        return null;
    }
}
