<?php

declare(strict_types=1);

namespace App\Tests\Api\Invoice;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Domain\Model\Invoice\InvoiceFileNotFoundException;
use App\Domain\Shared\Exceptions\DomainException;
use App\Infrastructure\Services\Export\ExportInvoiceToPdf;
use App\Tests\Mock\Domain\ModelProviders\InvoiceProvider;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ApiInvoiceControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var string
     */
    private string $publicPath;

    /**
     * @var ExportInvoiceToPdf
     */
    private ExportInvoiceToPdf $exportService;

    protected function setUp(): void
    {
        self::bootKernel();
        $kernel = self::$kernel;
        $this->publicPath = $kernel->getProjectDir() . '/public';

        $this->client = static::createClient();
        $twig = $this->client->getContainer()->get('twig');

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

    public function testPdfDownload(): void
    {
        // Given an Invoice.
        $invoice = InvoiceProvider::provideInvoice();

        // When create pdf.
        $this->exportService->export($invoice);

        //When request downloading the invoice pdf file.
        $response = $this->client->request('GET', '/api/invoice/download/F202103091000');

        // The file is downloaded.
        static::assertResponseIsSuccessful();
        static::assertFileExists($this->publicPath . '/invoices/F202103091000.pdf');
    }
    
    public function testPdfNotFound(): void
    {
        // Given a user who request a file that does not exist.
        $this->client->request('GET', '/api/invoice/download/fake');

        // Then the response status code should be 404.
        static::assertResponseStatusCodeSame(404);
    }
}
