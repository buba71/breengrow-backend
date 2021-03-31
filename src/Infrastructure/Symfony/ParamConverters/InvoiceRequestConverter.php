<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\ParamConverters;

use App\Application\UseCases\Invoice\DownloadInvoicePdf\DownloadInvoiceRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class InvoiceRequestConverter
 * @package App\Infrastructure\Symfony\ParamConverters
 * Build invoice request for pdf download.
 */
final class InvoiceRequestConverter implements ParamConverterInterface
{

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool|void
     * Transform request param into DownloadInvoiceRequest.
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $DownloadFileRequest = new DownloadInvoiceRequest();
        $DownloadFileRequest->fileName = $request->get('filename');

        $request->attributes->set($configuration->getName(), $DownloadFileRequest);

        return true;
    }

    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getName() === 'downloadInvoiceRequest';
    }
}
