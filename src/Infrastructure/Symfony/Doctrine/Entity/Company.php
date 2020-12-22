<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Company
 * @ORM\Entity()
 * @package App\Infrastructure\Symfony\Doctrine
 */
class Company
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="id")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="company_name")
     */
    private string $name;

    /**
     * @var Collection
     * @ORM\OneToMany(
     *     targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\Product",
     *      mappedBy="company",
     *      cascade={"persist", "remove"}
     *     )
     */
    private Collection $products;

    /**
     * @var string
     * @ORM\Column(type="string", name="siret_number")
     */
    private string $siretNumber;

    /**
     * @var string
     * @ORM\Column(type="string", name="street_address")
     */
    private string $street;

    /**
     * @var string
     * @ORM\Column(type="string", name="city_address")
     */
    private string $city;

    /**
     * @var string
     * @ORM\Column(type="string", name="zip_code")
     */
    private string $zipCode;

    /**
     * @var GeoPoint
     * @ORM\Embedded(class = "GeoPoint", columnPrefix=false)
     */
    private GeoPoint $geoPoint;

    /**
     * Company constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSiretNumber(): string
    {
        return $this->siretNumber;
    }

    /**
     * @param string $siretNumber
     */
    public function setSiretNumber(string $siretNumber): void
    {
        $this->siretNumber = $siretNumber;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product): self
    {
        $found = $this->products->filter(function ($item) use ($product) {
            return $item->getId() === $product->getId();
        });

        if ($found->isEmpty()) {
            $this->products->add($product);
        }
        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @return GeoPoint
     */
    public function getGeoPoint(): GeoPoint
    {
        return $this->geoPoint;
    }

    /**
     * @param GeoPoint $geoPoint
     */
    public function setGeoPoint(GeoPoint $geoPoint): void
    {
        $this->geoPoint = $geoPoint;
    }


}
