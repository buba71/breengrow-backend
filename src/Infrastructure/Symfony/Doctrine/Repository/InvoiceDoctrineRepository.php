<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Repository\InvoiceRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Invoice as InvoiceEntity;
use App\Infrastructure\Symfony\Doctrine\Mappers\InvoiceMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class InvoiceDoctrineRepository extends ServiceEntityRepository implements InvoiceRepository
{
    /**
     * InvoiceDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoiceEntity::class);
    }

    /**
     * @param Invoice $invoice
     * @return mixed|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addInvoice(Invoice $invoice)
    {
        $invoiceDoctrineEntity = InvoiceMap::domainToPersistence($invoice);

        $this->getEntityManager()->persist($invoiceDoctrineEntity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return Invoice[]
     */
    public function getAllInvoices(): array
    {
        return $this->findAll();
    }

    /**
     * @return Invoice|null
     * @throws \Exception
     */
    public function getLastRecord(): ?Invoice
    {
        $query = $this->findBy([], ['number' => 'DESC'], 1, 0);

        if (!$query) {
            return null;
        }

        $lastInvoiceInserted = $query[0];

        return InvoiceMap::persistenceToDomain($lastInvoiceInserted);
    }
}
