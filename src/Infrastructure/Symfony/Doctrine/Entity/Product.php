<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @ORM\Entity()
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 */
class Product
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="string", name="identifier")
     */
    private string $id;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\Company", inversedBy="products")
     * @ORM\JoinColumn(nullable=false, name="company_id", referencedColumnName="id")
     */
    private Company $company;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="date_immutable", name="created_at")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @var string
     * @ORM\Column(type="text", name="description")
     */
    private string $description;

    /**
     * @var string
     * @ORM\Column(type="string", name="product_name")
     */
    private string $name;

    /**
     * @var float
     * @ORM\Column(type="float", name="product_price")
     */
    private float $price;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     *
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
