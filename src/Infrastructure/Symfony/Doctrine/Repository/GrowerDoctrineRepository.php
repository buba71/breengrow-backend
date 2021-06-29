<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Grower\Grower;
use App\Domain\Model\Grower\Product;
use App\Domain\Model\Invoice\SellerAddress;
use App\Infrastructure\Symfony\Doctrine\Entity\Grower as GrowerEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\Product as ProductEntity;
use App\Infrastructure\Symfony\Doctrine\Mappers\GrowerMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Domain\Repository\GrowerRepository;
use Doctrine\Persistence\ManagerRegistry;

class GrowerDoctrineRepository extends ServiceEntityRepository implements GrowerRepository
{
    /**$
     * @var ProductDoctrineRepository
     */
    private ProductDoctrineRepository $productRepository;

    public function __construct(ManagerRegistry $registry, ProductDoctrineRepository $productRepository)
    {
        parent::__construct($registry, GrowerEntity::class);
        $this->productRepository = $productRepository;
    }

    /**
     * @param Grower $grower
     * @return GrowerEntity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addGrower(Grower $grower): GrowerEntity
    {
        $growerDoctrineEntity = GrowerMap::domainToPersistence($grower);

        $this->getEntityManager()->persist($growerDoctrineEntity);
        $this->getEntityManager()->flush();

        return $growerDoctrineEntity;
    }

    /**
     * @return array<Grower>
     */
    public function getAllGrowers(): array
    {
        $growerCollection = $this->findAll();
        $growers = [];
        
        foreach ($growerCollection as $growerDoctrineEntity) {
            $grower = GrowerMap::persistenceToDomain($growerDoctrineEntity);
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

        return GrowerMap::persistenceToDomain($growerDoctrineEntity);
    }

    /**
     * @param string $productId
     * @return Product
     */
    public function getProductHiveById(string $productId): Product
    {
        $productDoctrineEntity =  $this->productRepository->findOneBy(['id' => $productId]);

        return new Product(
            $productDoctrineEntity->getId(),
            $productDoctrineEntity->getCreatedAt(),
            $productDoctrineEntity->getName(),
            $productDoctrineEntity->getDescription(),
            $productDoctrineEntity->getPrice()
        );
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
            $productDoctrineEntity->setCreatedAt($product->getCreatedAt());
            $productDoctrineEntity->setName($product->getName());
            $productDoctrineEntity->setDescription($product->getDescription());
            $productDoctrineEntity->setPrice($product->getPrice());

            $growerDoctrineEntity->getCompany()->addProduct($productDoctrineEntity);
        }
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $hiveSiret
     * @return SellerAddress
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getHiveAddress(string $hiveSiret): SellerAddress
    {
        $queryBuilder = $this->createQueryBuilder('g');
        $queryBuilder->select('g')
                     ->innerJoin('g.company', 'c')
                     ->addSelect('c')
                     ->where('c.siretNumber = ?0')
                     ->setParameter(0, $hiveSiret);

        $result = $queryBuilder->getQuery()->getOneOrNullResult();
        $sellerAddress = $result->getCompany();

        return new SellerAddress(
            $sellerAddress->getName(),
            $sellerAddress->getSiretNumber(),
            $sellerAddress->getStreet(),
            $sellerAddress->getCity(),
            $sellerAddress->getZipCode()
        );
    }
}
