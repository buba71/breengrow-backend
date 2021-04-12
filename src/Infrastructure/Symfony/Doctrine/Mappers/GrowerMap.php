<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Mappers;

use App\Domain\Model\Grower\Grower;
use App\Domain\Shared\Aggregate\AggregateRoot;
use App\Infrastructure\Symfony\Doctrine\Entity\Company as CompanyEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\GeoPoint as GeoPointEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\Grower as GrowerEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\Product as ProductEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\User as UserEntity;

final class GrowerMap implements Mapper
{

    /**
     * @param AggregateRoot $model
     * @return GrowerEntity
     */
    public static function domainToPersistence(AggregateRoot $model): GrowerEntity
    {
        $userEntity = new UserEntity();

        $userEntity->setEmail($model->getEmail());
        $userEntity->setParentId($model->getId());
        $userEntity->setPassword($model->getPassword());
        $userEntity->setSalt($model->getSalt());
        $userEntity->setRoles($model->getRole());

        $companyEntity = new CompanyEntity();
        $hive = $model->getHive();

        $geoPointEntity = new GeoPointEntity();
        $geoPointEntity->setLatitude($hive->getGeoPoint()->getLatitude());
        $geoPointEntity->setLongitude($hive->getGeoPoint()->getLongitude());

        $companyEntity->setName($hive->getName());
        $companyEntity->setSiretNumber($hive->getSiretNumber());
        $companyEntity->setStreet($hive->getStreet());
        $companyEntity->setCity($hive->getCity());
        $companyEntity->setGeoPoint($geoPointEntity);
        $companyEntity->setZipCode($hive->getZipCode());

        foreach ($model->getHive()->getProducts() as $product) {
            $productEntity = new ProductEntity();
            $productEntity->setCompany($companyEntity);
            $productEntity->setId($product->getId());
            $productEntity->setName($product->getName());
            $productEntity->setDescription($product->getDescription());
            $productEntity->setPrice($product->getPrice());

            $companyEntity->addProduct($productEntity);
        }

        $growerDoctrineEntity = new GrowerEntity();

        $growerDoctrineEntity->setId($model->getId());
        $growerDoctrineEntity->setFirstName($model->getFirstName());
        $growerDoctrineEntity->setLastName($model->getLastName());
        $growerDoctrineEntity->setUser($userEntity);

        // Set company static data.
        $growerDoctrineEntity->setCompany($companyEntity);

        return $growerDoctrineEntity;
    }

    /**
     * @param object|null $persistenceEntity
     * @return Grower|null
     */
    public static function persistenceToDomain(?object $persistenceEntity): ?Grower
    {
        if (!$persistenceEntity) {
            return null;
        }

        $grower = new Grower(
            $persistenceEntity->getId(),
            $persistenceEntity->getFirstName(),
            $persistenceEntity->getLastName(),
            $persistenceEntity->getUser()->getEmail(),
            $persistenceEntity->getUser()->getPassword(),
            $persistenceEntity->getUser()->getSalt(),
            $persistenceEntity->getUser()->getRoles()
        );
        $grower->addHive(
            $persistenceEntity->getCompany()->getName(),
            $persistenceEntity->getCompany()->getSiretNumber(),
            $persistenceEntity->getCompany()->getStreet(),
            $persistenceEntity->getCompany()->getCity(),
            $persistenceEntity->getCompany()->getZipCode()
        );
        $grower->getHive()->addGeoPoint(
            $persistenceEntity->getCompany()->getGeoPoint()->getLatitude(),
            $persistenceEntity->getCompany()->getGeoPoint()->getLongitude()
        );

        foreach ($persistenceEntity->getCompany()->getProducts() as $product) {
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
}