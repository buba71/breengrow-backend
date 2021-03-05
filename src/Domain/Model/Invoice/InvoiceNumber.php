<?php

declare(strict_types=1);

namespace App\Domain\Model\Invoice;

use App\Domain\Repository\InvoiceRepository;
use App\Domain\Services\InvoiceServices\InvoiceNumberGenerator;
use App\SharedKernel\SystemClock\Clock;

final class InvoiceNumber
{
    private const PREFIX = 'F';

    /**
     * @var \DateTimeImmutable|null
     */
    private ?\DateTimeImmutable $date;

    /**
     * @var int|null
     */
    private ?int $sequenceNumber;

    public function __construct(int $sequenceNumber = null, \DateTimeImmutable $date = null)
    {
        $this->date = $date;
        $this->sequenceNumber = $sequenceNumber;
    }

    /**
     * @param InvoiceRepository $repository
     * @param Clock $clock
     * @return self
     */
    public static function generate(InvoiceRepository $repository, Clock $clock): self
    {
        $invoiceNumberGenerator = new InvoiceNumberGenerator($repository, $clock);

        $invoiceNumber = new self();
        $invoiceNumber->date = $clock->getCurrentTime();
        $invoiceNumber->sequenceNumber = $invoiceNumberGenerator->nextNumber($invoiceNumber->date);

        return $invoiceNumber;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getSequenceNumber(): int
    {
        return $this->sequenceNumber;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return  self::PREFIX . ' ' . $this->getDate()->format('Y-m-d') . ' ' . (string)$this->sequenceNumber;
    }
}
