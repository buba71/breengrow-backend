<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DomainResourcesNotFoundHttpException extends NotFoundHttpException
{

    /**
     * @var string
     */
    private string $resource;

    /**
     * DomainResourceNotFoundHttpException constructor.
     * @param string $resource
     */
    public function __construct(string $resource)
    {
        $this->resource = $resource;
        parent::__construct($this->getMessageError());
    }

    /**
     * @return string
     */
    public function getMessageError(): string
    {
        return sprintf('%s not found', $this->resource);
    }
}