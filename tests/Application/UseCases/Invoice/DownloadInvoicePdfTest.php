<?php

declare(strict_types=1);

namespace App\Tests\Application\UseCases\Invoice;

use App\Application\UseCases\Invoice\DownloadInvoicePdf\DownloadInvoicePdf;
use App\Application\UseCases\Invoice\DownloadInvoicePdf\DownloadInvoiceRequest;
use App\Domain\Model\Invoice\InvoiceFileNotFoundException;
use PHPUnit\Framework\TestCase;

final class DownloadInvoicePdfTest extends TestCase
{
    /**
     * @var string
     */
    private string $publicPath;

    /**
     * @var DownloadInvoicePdf
     */
    private DownloadInvoicePdf $useCase;

    protected function setUp(): void
    {
        $this->publicPath = __DIR__ . '../../../../../var/';
        $this->useCase = new DownloadInvoicePdf($this->publicPath);
    }

    protected function tearDown(): void
    {
        if (is_dir($this->publicPath . 'invoices')) {
            unlink($this->publicPath . 'invoices/Ftest.pdf');
            rmdir($this->publicPath . 'invoices');
        }
    }

    public function testSearchFileIsSuccessFull(): void
    {
        mkdir(__DIR__ . '../../../../../var/invoices');
        fopen('var/invoices/Ftest.pdf', 'w');

        $request = new DownloadInvoiceRequest();
        $request->fileName = 'Ftest';
        $file = $this->useCase->execute($request);

        static::assertFileExists($file);
    }

    public function testSearchFileFail(): void
    {
        $request = new DownloadInvoiceRequest();
        $request->fileName = 'Ftest';
        
        static::expectException(InvoiceFileNotFoundException::class);
        static::expectExceptionMessage('The file Ftest.pdf doest not exist.');
        
        $this->useCase->execute($request);
    }
}
