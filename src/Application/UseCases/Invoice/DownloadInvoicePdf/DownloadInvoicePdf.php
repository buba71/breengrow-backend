<?php

declare(strict_types=1);

namespace App\Application\UseCases\Invoice\DownloadInvoicePdf;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DownloadInvoicePdf
{
    /**
     * @var string
     */
    private string $rootDir;

    public function __construct(string $publicPath)
    {
        $this->rootDir = $publicPath;
    }

    /**
     * @param DownloadInvoiceRequest $request
     * @return string
     */
    public function execute(DownloadInvoiceRequest $request): string
    {
        // TODO checking if user is logged in and is owner before downloading file.

        $file_path = $this->rootDir . 'invoices/' . $request->fileName . '.pdf';

        if (!file_exists($file_path)) {
            $message = sprintf('The file %s.pdf doest not exist.', $request->fileName);
            throw new NotFoundHttpException($message);
        }

        return $file_path;
    }
}
