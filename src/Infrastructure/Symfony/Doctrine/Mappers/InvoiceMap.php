<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Mappers;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Domain\Shared\Aggregate\AggregateRoot;
use App\Infrastructure\Symfony\Doctrine\Entity\BillingAddress;
use App\Infrastructure\Symfony\Doctrine\Entity\DoctrineEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\Invoice as InvoiceEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\InvoiceLine;
use App\Infrastructure\Symfony\Doctrine\Entity\SellerAddress;

final class InvoiceMap implements Mapper
{

    /**
     * @param AggregateRoot $model
     * @return InvoiceEntity
     */
    public static function domainToPersistence(AggregateRoot $model): InvoiceEntity
    {
        $invoiceDoctrineEntity = new InvoiceEntity();
        $invoiceDoctrineEntity->setNumber((string)$model->getNumber());
        $invoiceDoctrineEntity->setAmount($model->getTotalAmount());
        $invoiceDoctrineEntity->setFilePath($model->getFileName());

        $billingAddressEntity = new BillingAddress();
        $billingAddressEntity->setFirstName($model->getBillingAddress()->getFirstName());
        $billingAddressEntity->setLastName($model->getBillingAddress()->getLastName());
        $billingAddressEntity->setStreet($model->getBillingAddress()->getStreet());
        $billingAddressEntity->setZipCode($model->getBillingAddress()->getZipCode());
        $billingAddressEntity->setCity($model->getBillingAddress()->getCity());
        $invoiceDoctrineEntity->setBillingAddress($billingAddressEntity);

        $sellerAddressEntity = new SellerAddress();
        $sellerAddressEntity->setSiretNumber($model->getSellerAddress()->getHiveSiret());
        $sellerAddressEntity->setName($model->getSellerAddress()->getHiveName());
        $sellerAddressEntity->setStreet($model->getSellerAddress()->getStreetAddress());
        $sellerAddressEntity->setZipCode($model->getSellerAddress()->getZipCode());
        $sellerAddressEntity->setCity($model->getSellerAddress()->getCityAddress());
        $invoiceDoctrineEntity->setSellerAddress($sellerAddressEntity);

        foreach ($model->getInvoiceLines() as $invoiceLine) {
            $invoiceLineDoctrineEntity = new InvoiceLine();
            $invoiceLineDoctrineEntity->setInvoice($invoiceDoctrineEntity);
            $invoiceLineDoctrineEntity->setProductDescription($invoiceLine->getProductDescription());
            $invoiceLineDoctrineEntity->setQuantity($invoiceLine->getQuantity());
            $invoiceLineDoctrineEntity->setLinePrice($invoiceLine->getLinePrice());

            $invoiceDoctrineEntity->addInvoiceLine($invoiceLineDoctrineEntity);
        }

        return $invoiceDoctrineEntity;
    }


    /**
     * @param DoctrineEntity $persistenceEntity
     * @return Invoice
     * @throws \Exception
     */
    public static function persistenceToDomain(DoctrineEntity $persistenceEntity): Invoice
    {
        /// Extract invoice number and build new Invoice number model value object.
        list($prefix, $date, $sequenceNumber) = explode(' ', $persistenceEntity->getNumber());
        $invoiceNumber = new InvoiceNumber((int)$sequenceNumber, new \DateTimeImmutable($date));

        $billingAddressDoctrine = $persistenceEntity->getBillingAddress();
        $billingAddressModel = new \App\Domain\Model\Invoice\BillingAddress(
            $billingAddressDoctrine->getFirstName(),
            $billingAddressDoctrine->getLastName(),
            $billingAddressDoctrine->getStreet(),
            $billingAddressDoctrine->getZipCode(),
            $billingAddressDoctrine->getCity(),
            'BILL'
        );

        $sellerAddressDoctrine = $persistenceEntity->getSellerAddress();
        $sellerAddressModel = new \App\Domain\Model\Invoice\SellerAddress(
            $sellerAddressDoctrine->getName(),
            $sellerAddressDoctrine->getSiretNumber(),
            $sellerAddressDoctrine->getStreet(),
            $sellerAddressDoctrine->getCity(),
            $sellerAddressDoctrine->getZipCode()
        );


        return new Invoice(
            $invoiceNumber,
            $persistenceEntity->getAmount(),
            $billingAddressModel,
            $sellerAddressModel
        );
    }
}