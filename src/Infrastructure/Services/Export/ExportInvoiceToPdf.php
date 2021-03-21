<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Export;

use App\Domain\Services\ExportDomain;
use App\Domain\Shared\Aggregate\AggregateRoot;
use Knp\Snappy\Pdf;
use Twig\Environment;

final class ExportInvoiceToPdf implements ExportDomain
{
    /**
     * @var string
     */
    private string $invoiceBasePath;

    /**
     * @var Pdf
     */
    private Pdf $pdf;

    /**
     * @var Environment
     */
    private Environment $twig;


    /**
     * ExportInvoiceToPdf constructor.
     * @param Environment $twig
     * @param Pdf $snappy
     * @param string $publicPath (Service parameter binding)
     */
    public function __construct(Environment $twig, Pdf $snappy, string $publicPath)
    {
        $this->invoiceBasePath = $publicPath;
        $this->pdf = $snappy;
        $this->twig = $twig;
    }

    /**
     * @param AggregateRoot $domainModel
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function export(AggregateRoot $domainModel): string
    {
        $htmlTemplate = $this->buildHtmlTemplate($domainModel);
        $invoiceFileName = $domainModel->getFileName() . '.pdf';

        $file = $this->invoiceBasePath . '/invoices/' . $invoiceFileName;

        try {
            if (file_exists($file)) {
                throw new \Exception('File ' . $invoiceFileName . ' already exist');
            }
            $this->pdf->generateFromHtml($htmlTemplate, $file);
            return $invoiceFileName;
        } catch (\Exception $exception) {
            throw new \Exception('Error on creating file: ', 0, $exception);
        }
    }

    /**
     * @param AggregateRoot $invoiceDomainModel
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function buildHtmlTemplate(AggregateRoot $invoiceDomainModel): string
    {
        $templateData = [
            'billingAddress' => $invoiceDomainModel->getBillingAddress(),
            'sellerAddress'  => $invoiceDomainModel->getSellerAddress(),
            'invoiceNumber'  => $invoiceDomainModel->getNumber(),
            'invoiceLines'   => $invoiceDomainModel->getInvoiceLines(),
            'amount'         => $invoiceDomainModel->getTotalAmount()
        ];

        return $this->twig->render('Invoice.html.twig', $templateData);
    }
}
