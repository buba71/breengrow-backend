<?php

declare(strict_types=1);

namespace App\Domain\Model\Grower;

class GeoPoint extends \App\Infrastructure\Symfony\Doctrine\Entity\GeoPoint
{
    /**
     * @var float
     */
    private float $latitude;

    /**
     * @var float
     */
    private float $longitude;

    /**
     * GeoPoint constructor.
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
