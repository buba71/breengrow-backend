<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Services\Export;

use App\Domain\Model\Invoice\Invoice;
use App\Domain\Model\Invoice\InvoiceNumber;
use App\Infrastructure\Services\Export\ExportInvoiceToPdf;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class ExportInvoiceToPdfTest extends WebTestCase
{
    /**
     * @var ExportInvoiceToPdf
     */
    private ExportInvoiceToPdf $exportService;

    /**
     * @var string
     */
    private string $publicPath;


    protected function setUp(): void
    {
        // Mock the $publicPath service binding to root/var/tmp.
        self::bootKernel();
        $kernel = self::$kernel;
        $this->publicPath = $kernel->getProjectDir() . '/var/tmp';
        
        $client = static::createClient();

        $twig  = $client->getContainer()->get('twig');

        // Should install binary on CI environment and change path if necessary.
        $snappy = new Pdf('wkhtmltopdf');

        $this->exportService = new ExportInvoiceToPdf($twig, $snappy, $this->publicPath);
    }

    protected function tearDown(): void
    {
        $file = $this->publicPath . '/invoices/F202103091000.pdf';
        if (file_exists($file)) {
            unlink($file);
        }
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function testIfGenerateInvoiceHtmlTemplate(): void
    {
        // Given an invoice.
        $invoice = static::provideAnInvoice();

        // When generate a new invoice.
        $exportService = $this->exportService;
        $html = $exportService->buildHtmlTemplate($invoice);

        $crawler = new Crawler($html, null, null);

        // Then HTML template should contend.
        static::assertEquals('Number: F 2021-03-09 1000', $crawler->filter('thead tr th')->text());
        static::assertEquals('description', $crawler->filter('tbody tr td:nth-child(1)')->text());
        static::assertEquals('quantity', $crawler->filter('tbody tr td:nth-child(2)')->text());
        static::assertEquals('price', $crawler->filter('tbody tr td:nth-child(3)')->text());
    }


    public function testCreatePdfSuccessFull(): void
    {
        // Given an invoice.
        $invoice =  static::provideAnInvoice();

        $exportService = $this->exportService;

        // When export export invoice domain to pdf file.
        $exportService->export($invoice);

        // Then should create this pdf file.
        static::assertFileExists($this->publicPath . '/invoices/F202103091000.pdf');
    }

    public function testCreatePdfFail(): void
    {
        // Given an invoice.
        $invoice =  static::provideAnInvoice();

        $exportService = $this->exportService;

        // When export invoice domain to pdf file an exception is thrown.
        $exportService->export($invoice);

        static::expectExceptionMessage('Error on creating file');
        static::assertFileExists($this->publicPath . '/invoices/F202103091000.pdf');

        // When this file already exist.
        $exportService->export($invoice);
    }

    /**
     * @return Invoice
     */
    public static function provideAnInvoice(): Invoice
    {
        $invoiceDate = new \DateTimeImmutable('2021-03-09');
        $invoiceNumber =  new InvoiceNumber(1000, $invoiceDate);

        $invoice =  new Invoice($invoiceNumber, 4.99);
        $invoice->addInvoiceLine('description', 1, 4.99);

        return $invoice;
    }
}
