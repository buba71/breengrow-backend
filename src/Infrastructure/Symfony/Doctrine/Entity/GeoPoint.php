<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class GeoPoint
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 * @ORM\Embeddable()
 */
class GeoPoint
{
    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private float $latitude;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    private float $longitude;

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

}