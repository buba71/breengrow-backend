<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Product\Product;
use App\Domain\Repository\ProductRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Product as ProductEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductDoctrineRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductEntity::class);
    }

    public function addProduct(Product $product)
    {
        $productEntity = new ProductEntity();
        $productEntity->setId($product->getId());
        $productEntity->setCreatedAt($product->getCreatedAt());
        $productEntity->setName($product->getName());
        $productEntity->setDescription($product->getDescription());
        $productEntity->setPrice($product->getPrice());

        $this->getEntityManager()->persist($productEntity);
        $this->getEntityManager()->flush();
    }

    public function getProductById(string $id): ?Product
    {
        return null;
    }
}