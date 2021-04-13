<?php

declare(strict_types=1);

namespace App\Application\UseCases\Invoice\DownloadInvoicePdf;

use App\Domain\Model\Invoice\InvoiceFileNotFoundException;

final class DownloadInvoicePdf
{
    /**
     * @var string
     */
    private string $publicPath;

    public function __construct(string $publicPath)
    {
        $this->publicPath = $publicPath;
    }

    /**
     * @param DownloadInvoiceRequest $request
     * @return string
     */
    public function execute(DownloadInvoiceRequest $request): string
    {
        // TODO checking if user is logged in and is owner before downloading file.

        $file_path = $this->publicPath . 'invoices/' . $request->fileName . '.pdf';

        if (!file_exists($file_path)) {
            throw new InvoiceFileNotFoundException(sprintf('The file %s.pdf doest not exist.', $request->fileName));
        }

        return $file_path;
    }
}
