<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Consumer\Consumer;
use App\Domain\Repository\ConsumerRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Consumer as ConsumerEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\ConsumerAddress as ConsumerAddressEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\Order as OrderEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\User as UserEntity;
use Doctrine\Persistence\ManagerRegistry;

class ConsumerDoctrineRepository extends ServiceEntityRepository implements ConsumerRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsumerEntity::class);
    }

    /**
     * @param Consumer $consumer
     * @return mixed|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addConsumer(Consumer $consumer)
    {
        $consumerEntity = new ConsumerEntity();

        $consumerEntity->setId($consumer->getId());
        $consumerEntity->setFirstName($consumer->getFirstName());
        $consumerEntity->setLastName($consumer->getLastName());


        $userEntity = new UserEntity();

        $userEntity->setEmail($consumer->getEmail());
        $userEntity->setParentId($consumer->getId());
        $userEntity->setPassword($consumer->getPassword());
        $userEntity->setSalt($consumer->getSalt());
        $userEntity->setRoles($consumer->getRole());
        $consumerEntity->setUser($userEntity);

        foreach ($consumer->getAddresses() as $address) {
            $consumerAddressEntity = new ConsumerAddressEntity();

            $consumerAddressEntity->setConsumer($consumerEntity);
            $consumerAddressEntity->setFirstName($address->getFirstName());
            $consumerAddressEntity->setLastName($address->getLastName());
            $consumerAddressEntity->setStreet($address->getStreet());
            $consumerAddressEntity->setZipCode($address->getZipCode());
            $consumerAddressEntity->setCity($address->getCity());
            $consumerEntity->addAddress($consumerAddressEntity);
        }

        $this->getEntityManager()->persist($consumerEntity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $id
     * @return Consumer|null
     */
    public function getConsumerById(string $id): ?Consumer
    {
        $consumerDoctrineEntity = $this->findOneBy(['id' => $id]);

        $consumer = new Consumer(
            $consumerDoctrineEntity->getId(),
            $consumerDoctrineEntity->getFirstName(),
            $consumerDoctrineEntity->getLastName(),
            $consumerDoctrineEntity->getUser()->getEmail(),
            $consumerDoctrineEntity->getUser()->getPassword(),
            $consumerDoctrineEntity->getUser()->getSalt(),
            $consumerDoctrineEntity->getUser()->getRoles()
        );

        foreach ($consumerDoctrineEntity->getConsumerAddresses() as $address) {
            $consumer->addAddress(
                $address->getFirstName(),
                $address->getLastName(),
                $address->getStreet(),
                $address->getZipCode(),
                $address->getCity()
            );
        }

        return $consumer;
    }

    /**
     * @param string $email
     * @return mixed|void
     */
    public function getConsumerByEmail(string $email)
    {
        // TODO: Implement getConsumerByEmail() method.
    }
}
