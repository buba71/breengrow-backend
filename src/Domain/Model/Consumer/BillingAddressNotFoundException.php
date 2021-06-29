<?php

declare(strict_types=1);

namespace App\Domain\Model\Consumer;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BillingAddressNotFoundException extends NotFoundHttpException
{
    /**
     * BillingAddressNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct($this->getErrorMessage());
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return 'Billing address was not set. Cannot generate invoice order';
    }
}
