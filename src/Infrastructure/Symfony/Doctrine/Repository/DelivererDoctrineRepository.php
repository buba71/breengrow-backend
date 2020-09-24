<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Deliverer\Deliverer;
use App\Domain\Repository\DelivererRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Deliverer as DelivererEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\User as UserEntity;
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
        $delivererEntity = new DelivererEntity();
        $delivererEntity->setId($deliverer->getId());
        $delivererEntity->setFirstName($deliverer->getFirstName());
        $delivererEntity->setLastName($deliverer->getLastName());
        $delivererEntity->setPhone($deliverer->getPhone());

        $userEntity = new userEntity();
        $userEntity->setEmail($deliverer->getEmail());
        $userEntity->setPassword($deliverer->getPassword());
        $userEntity->setSalt($deliverer->getSalt());
        $userEntity->setRoles($deliverer->getRole());
        
        $delivererEntity->setUser($userEntity);
        
        

        $this->getEntityManager()->persist($delivererEntity);
        $this->getEntityManager()->flush();
    }

    public function getDelivererById(string $id): ?Deliverer
    {
        // TODO: Implement getDelivererById() method.
    }

    public function getDelivererByEmail(string $email): ?Deliverer
    {
        return null;
    }
}
