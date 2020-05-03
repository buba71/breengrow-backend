<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Grower\Grower;
use App\Infrastructure\Symfony\Doctrine\Entity\User as UserEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\Grower as GrowerEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Domain\Repository\GrowerRepository;

class GrowerDoctrineRepository extends ServiceEntityRepository implements GrowerRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }


    /**
     * @param Grower $user
     * @return GrowerEntity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addGrower(Grower $user): GrowerEntity
    {
        $userEntity = new UserEntity();

        $userEntity->setFirstName($user->getFirstName());
        $userEntity->setLastName($user->getLastName());
        $userEntity->setEmail($user->getEmail());
        $userEntity->setPassword($user->getPassword());
        $userEntity->setSalt($user->getSalt());
        $userEntity->setRoles($user->getRole());

        $growerEntity = new GrowerEntity();

        $growerEntity->setId($user->getId());
        $growerEntity->setSiretNumber(231546);
        $growerEntity->setUser($userEntity);

        $this->getEntityManager()->persist($growerEntity);
        $this->getEntityManager()->flush();

        return $growerEntity;
    }

    public function getGrowerByEmail(string $email)
    {
         return $this->getEntityManager()->getRepository(Grower::class)->findOneBy(['email' => $email]);
    }

}