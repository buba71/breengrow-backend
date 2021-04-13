<?php

declare(strict_types=1);

namespace App\Domain\Model\Invoice;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class InvoiceFileNotFoundException extends NotFoundHttpException
{
    /**
     * InvoiceFileNotFoundException constructor.
     * @param string|null $message
     */
    public function __construct(string $message = null)
    {
        parent::__construct($message);
    }
}
