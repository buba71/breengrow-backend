<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Consumer\Consumer;
use App\Domain\Model\Invoice\BillingAddress;
use App\Domain\Repository\ConsumerRepository;
use App\Infrastructure\Symfony\Doctrine\Mappers\ConsumerMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Consumer as ConsumerEntity;
use Doctrine\Persistence\ManagerRegistry;

class ConsumerDoctrineRepository extends ServiceEntityRepository implements ConsumerRepository
{
    /**
     * ConsumerDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
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
        $consumerEntity = ConsumerMap::domainToPersistence($consumer);

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

        return ConsumerMap::persistenceToDomain($consumerDoctrineEntity);
    }

    /**
     * @param string $email
     * @return mixed|void
     */
    public function getConsumerByEmail(string $email)
    {
        // TODO: Implement getConsumerByEmail() method.
    }

    public function getBillingAddress(string $consumerId): BillingAddress
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder->innerJoin('c.consumerAddresses', 'a')
                     ->addSelect('a')
                     ->where('a.type = ?0')
                     ->setParameter(0, 'BILL');

        $result = $queryBuilder->getQuery()->getOneOrNullResult();

        $address =  $result->getConsumerAddresses()[0];


        return new BillingAddress(
            $address->getFirstName(),
            $address->getLastName(),
            $address->getStreet(),
            $address->getZipCode(),
            $address->getCity(),
            $address->getType()
        );
    }
}
