<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Repository;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Domain\Repository\InvoiceRepository;
use App\Infrastructure\Symfony\Doctrine\Entity\Invoice as InvoiceEntity;
use App\Infrastructure\Symfony\Doctrine\Entity\InvoiceLine;
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
        $invoiceDoctrineEntity = new InvoiceEntity();
        $invoiceDoctrineEntity->setNumber((string)$invoice->getNumber());
        $invoiceDoctrineEntity->setAmount($invoice->getTotalAmount());
        
        foreach ($invoice->getInvoiceLines() as $invoiceLine) {
            $invoiceLineDoctrineEntity = new InvoiceLine();
            $invoiceLineDoctrineEntity->setInvoice($invoiceDoctrineEntity);
            $invoiceLineDoctrineEntity->setProductDescription($invoiceLine->getProductDescription());
            $invoiceLineDoctrineEntity->setQuantity($invoiceLine->getQuantity());
            $invoiceLineDoctrineEntity->setLinePrice($invoiceLine->getLinePrice());

            $invoiceDoctrineEntity->addInvoiceLine($invoiceLineDoctrineEntity);
        }

        // dd($invoiceDoctrineEntity);
        $this->getEntityManager()->persist($invoiceDoctrineEntity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return Invoice[]
     */
    public function getAllInvoices(): array
    {
        return [];
    }

    /**
     * @return Invoice|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLastRecord(): ?Invoice
    {
        $query = $this->findBy([], ['number' => 'DESC'], 1, 0);

        if (!$query) {
            return null;
        }

        $lastInvoiceInserted = $query[0];

        // Extract invoice number and build new Invoice number model value object.
        list($prefix, $date, $sequenceNumber) = explode(' ', $lastInvoiceInserted->getNumber());
        $invoiceNumber = new InvoiceNumber((int)$sequenceNumber, new \DateTimeImmutable($date));

        return new Invoice($invoiceNumber, $lastInvoiceInserted->getAmount());
    }
}
