<?php

declare(strict_types=1);

namespace App\Domain\Services\InvoiceServices;

use App\Domain\Repository\InvoiceRepository;
use App\SharedKernel\SystemClock\Clock;

class InvoiceNumberGenerator
{
    private const RESET_SEQUENCE_NUMBER = 1000;

    private \DateTimeImmutable $invoiceDate;

    private int $sequenceNumber;

    /**
     * @var InvoiceRepository
     */
    private InvoiceRepository $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository, Clock $clock)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceDate = $clock->getCurrentTime();
        $this->sequenceNumber = $this->nextNumber($this->invoiceDate);
    }

    /**
     * @param \DateTimeImmutable $invoiceDate
     * @return int
     */
    public function nextNumber(\DateTimeImmutable $invoiceDate): int
    {
        $lastRecord = $this->invoiceRepository->getLastRecord();
        if (null === $lastRecord || ($lastRecord->getNumber()->getDate() < $invoiceDate)) {
            return self::RESET_SEQUENCE_NUMBER;
        }

        return $lastRecord->getNumber()->getSequenceNumber() + 1;
    }
}
