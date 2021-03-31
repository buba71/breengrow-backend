<?php

declare(strict_types=1);

namespace App\Application\UseCases\Invoice\DownloadInvoicePdf;

final class DownloadInvoiceRequest
{
    /**
     * @var string
     */
    public string $fileName;
}
