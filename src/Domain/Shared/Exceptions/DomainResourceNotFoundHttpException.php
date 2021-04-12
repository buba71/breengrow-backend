<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DomainResourceNotFoundHttpException extends NotFoundHttpException
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $resource;


    /**
     * DomainResourceNotFoundHttpException constructor.
     * @param string $resource
     * @param string $id
     */
    public function __construct(string $resource, string $id)
    {
        $this->resource = $resource;
        $this->id = $id;

        parent::__construct($this->getMessageError());
    }

    /**
     * @return string
     */
    public function getMessageError(): string
    {
        return sprintf('%s with id: %s not found', $this->resource, $this->id);
    }
}
