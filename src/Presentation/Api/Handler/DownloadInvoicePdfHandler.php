<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler;

use App\Application\UseCases\Invoice\DownloadInvoicePdf\DownloadInvoicePdf;
use App\Application\UseCases\Invoice\DownloadInvoicePdf\DownloadInvoiceRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

final class DownloadInvoicePdfHandler
{
    /**
     * @ParamConverter(name="downloadInvoiceRequest")
     * @param DownloadInvoiceRequest $downloadInvoiceRequest
     * @param DownloadInvoicePdf $useCase
     * @return BinaryFileResponse
     */
    public function __invoke(
        DownloadInvoiceRequest $downloadInvoiceRequest,
        DownloadInvoicePdf $useCase
    ): BinaryFileResponse {

        $file_name = $downloadInvoiceRequest->fileName . '.pdf';

        $file_path = $useCase->execute($downloadInvoiceRequest);
        $response = new BinaryFileResponse($file_path);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Length', 'filesize($file_path)');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $file_name);

        return $response;
    }
}
