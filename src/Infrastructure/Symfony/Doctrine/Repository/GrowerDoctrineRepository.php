<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Grower\Grower;
use App\Infrastructure\Symfony\Doctrine\Entity\Company as CompanyEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\GeoPoint as GeoPointEntity;
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

        $geoPointEntity = new GeoPointEntity();
        $geoPointEntity->setLatitude($hive->getGeoPoint()->getLatitude());
        $geoPointEntity->setLongitude($hive->getGeoPoint()->getLongitude());

        $companyEntity->setName($hive->getName());
        $companyEntity->setSiretNumber($hive->getSiretNumber());
        $companyEntity->setStreet($hive->getStreet());
        $companyEntity->setCity($hive->getCity());
        $companyEntity->setGeoPoint($geoPointEntity);
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

        $growerDoctrineEntity = new GrowerEntity();

        $growerDoctrineEntity->setId($grower->getId());
        $growerDoctrineEntity->setFirstName($grower->getFirstName());
        $growerDoctrineEntity->setLastName($grower->getLastName());
        $growerDoctrineEntity->setUser($userEntity);

        // Set company static data.
        $growerDoctrineEntity->setCompany($companyEntity);

        $this->getEntityManager()->persist($growerDoctrineEntity);
        $this->getEntityManager()->flush();

        return $growerDoctrineEntity;
    }

    /**
     * @return array
     */
    public function getAllGrowers(): array
    {
        $growerCollection = $this->findAll();
        $growers = [];
        
        foreach ($growerCollection as $growerDoctrineEntity) {
            $grower = new Grower(
                $growerDoctrineEntity->getId(),
                $growerDoctrineEntity->getFirstName(),
                $growerDoctrineEntity->getLastName(),
                $growerDoctrineEntity->getUser()->getEmail(),
                $growerDoctrineEntity->getUser()->getPassword(),
                $growerDoctrineEntity->getUser()->getSalt(),
                $growerDoctrineEntity->getUser()->getRoles()
            );
            $grower->addHive(
                $growerDoctrineEntity->getCompany()->getName(),
                $growerDoctrineEntity->getCompany()->getSiretNumber(),
                $growerDoctrineEntity->getCompany()->getStreet(),
                $growerDoctrineEntity->getCompany()->getCity(),
                $growerDoctrineEntity->getCompany()->getZipCode()
            );
            $grower->getHive()->addGeoPoint(
                $growerDoctrineEntity->getCompany()->getGeoPoint()->getLatitude(),
                $growerDoctrineEntity->getCompany()->getGeoPoint()->getLongitude()
            );

            foreach ($growerDoctrineEntity->getCompany()->getProducts() as $product) {
                $grower->getHive()->addProduct(
                    $product->getId(),
                    $product->getCreatedAt(),
                    $product->getName(),
                    $product->getDescription(),
                    $product->getPrice()
                );
            }
            $growers[] = $grower;
        }
        return $growers;
    }

    /**
     * @param string $email
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
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

    /**
     * @param string $id
     * @return Grower|null
     */
    public function getGrowerById(string $id): ?Grower
    {
        $growerDoctrineEntity = $this->findOneBy(['id' => $id]);

         $grower = new Grower(
             $growerDoctrineEntity->getId(),
             $growerDoctrineEntity->getFirstName(),
             $growerDoctrineEntity->getLastName(),
             $growerDoctrineEntity->getUser()->getEmail(),
             $growerDoctrineEntity->getUser()->getPassword(),
             $growerDoctrineEntity->getUser()->getSalt(),
             $growerDoctrineEntity->getUser()->getRoles()
         );
         $grower->addHive(
             $growerDoctrineEntity->getCompany()->getName(),
             $growerDoctrineEntity->getCompany()->getSiretNumber(),
             $growerDoctrineEntity->getCompany()->getStreet(),
             $growerDoctrineEntity->getCompany()->getCity(),
             $growerDoctrineEntity->getCompany()->getZipCode()
         );
         $grower->getHive()->addGeoPoint(
             $growerDoctrineEntity->getCompany()->getGeoPoint()->getLatitude(),
             $growerDoctrineEntity->getCompany()->getGeoPoint()->getLongitude()
         );

        foreach ($growerDoctrineEntity->getCompany()->getProducts() as $product) {
            $grower->getHive()->addProduct(
                $product->getId(),
                $product->getCreatedAt(),
                $product->getName(),
                $product->getDescription(),
                $product->getPrice()
            );
        }
         return $grower;
    }

    /**
     * @param Grower $grower
     * @return mixed|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateGrower(Grower $grower)
    {
        $growerDoctrineEntity = $this->findOneBy(['id' => $grower->getId()]);

        foreach ($grower->getHive()->getProducts() as $product) {
            $productDoctrineEntity = new ProductEntity();
            $productDoctrineEntity->setId($product->getId());
            $productDoctrineEntity->setCompany($growerDoctrineEntity->getCompany());
            $productDoctrineEntity->setName($product->getName());
            $productDoctrineEntity->setDescription($product->getDescription());
            $productDoctrineEntity->setPrice($product->getPrice());

            $growerDoctrineEntity->getCompany()->addProduct($productDoctrineEntity);
        }
        $this->getEntityManager()->flush();
    }
}
