<?php

declare(strict_types=1);

namespace App\Domain\Model\Invoice;

final class SellerAddress
{
    /**
     * @var string
     */
    private string $hiveName;

    /**
     * @var string
     */
    private string $hiveSiret;

    /**
     * @var string
     */
    private string $streetAddress;

    /**
     * @var string
     */
    private string $cityAddress;

    /**
     * @var string
     */
    private string $zipCode;

    /**
     * SellerAddress constructor.
     * @param string $hiveName
     * @param string $hiveSiret
     * @param string $streetAddress
     * @param string $cityAddress
     * @param string $zipCode
     */
    public function __construct(
        string $hiveName,
        string $hiveSiret,
        string $streetAddress,
        string $cityAddress,
        string $zipCode
    ) {
        $this->hiveName = $hiveName;
        $this->hiveSiret = $hiveSiret;
        $this->streetAddress = $streetAddress;
        $this->cityAddress = $cityAddress;
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getHiveName(): string
    {
        return $this->hiveName;
    }

    /**
     * @return string
     */
    public function getHiveSiret(): string
    {
        return $this->hiveSiret;
    }

    /**
     * @return string
     */
    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    /**
     * @return string
     */
    public function getCityAddress(): string
    {
        return $this->cityAddress;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }
}