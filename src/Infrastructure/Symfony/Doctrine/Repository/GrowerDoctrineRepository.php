<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Grower\Grower;
use App\Infrastructure\Symfony\Doctrine\Entity\Company as CompanyEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\User as UserEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\Grower as GrowerEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\Product as ProductEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Domain\Repository\GrowerRepository;

class GrowerDoctrineRepository extends ServiceEntityRepository implements GrowerRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GrowerEntity::class);
    }


    /**
     * @param Grower $grower
     * @return GrowerEntity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addGrower(Grower $grower): GrowerEntity
    {
        $userEntity = new UserEntity();

        $userEntity->setEmail($grower->getEmail());
        $userEntity->setParentId($grower->getId());
        $userEntity->setPassword($grower->getPassword());
        $userEntity->setSalt($grower->getSalt());
        $userEntity->setRoles($grower->getRole());

        $companyEntity = new CompanyEntity();
        $hive = $grower->getHive();

        $companyEntity->setName($hive->getName());
        $companyEntity->setSiretNumber($hive->getSiretNumber());
        $companyEntity->setStreet($hive->getStreet());
        $companyEntity->setCity($hive->getCity());
        $companyEntity->setZipCode($hive->getZipCode());

        foreach ($grower->getHive()->getProducts() as $product) {
            $productEntity = new ProductEntity();
            $productEntity->setCompany($companyEntity);
            $productEntity->setId($product->getId());
            $productEntity->setName($product->getName());
            $productEntity->setDescription($product->getDescription());
            $productEntity->setPrice($product->getPrice());

            $companyEntity->addProduct($productEntity);
        }

        $growerEntity = new GrowerEntity();

        $growerEntity->setId($grower->getId());
        $growerEntity->setFirstName($grower->getFirstName());
        $growerEntity->setLastName($grower->getLastName());
        $growerEntity->setUser($userEntity);

        // Set company static data.
        $growerEntity->setCompany($companyEntity);

        $this->getEntityManager()->persist($growerEntity);
        $this->getEntityManager()->flush();

        return $growerEntity;
    }

    public function getGrowerByEmail(string $email)
    {
        $query = $this->createQueryBuilder('g');
        $query->innerJoin('g.user', 'u')
            ->addSelect('u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getGrowerById(string $id): ?Grower
    {
        $result = $this->find($id);

         $grower = new Grower(
             $result->getId(),
             $result->getFirstName(),
             $result->getLastName(),
             $result->getUser()->getEmail(),
             $result->getUser()->getPassword(),
             $result->getUser()->getSalt(),
             $result->getUser()->getRoles()
         );
         $grower->addHive(
             $result->getCompany()->getName(),
             $result->getCompany()->getSiretNumber(),
             $result->getCompany()->getStreet(),
             $result->getCompany()->getCity(),
             $result->getCompany()->getZipCode()
         );

        foreach ($result->getCompany()->getProducts() as $product) {
            $grower->getHive()->addProduct($product->getId(), $product->getName(), $product->getDescription(), $product->getPrice());
        }

         return $grower;
    }
}
