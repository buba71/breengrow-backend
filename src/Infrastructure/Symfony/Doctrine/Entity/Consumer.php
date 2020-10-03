<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Consumer
 * @ORM\Entity()
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 */
final class Consumer
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="string", name="identifier")
     */
    private string $id;

    /**
     * @var Collection
     * @ORM\OneToMany(
     *     targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\ConsumerAddress",
     *     mappedBy="consumer",
     *     cascade={"persist", "remove"}
     *     )
     */
    private Collection $consumerAddresses;

    /**
     * @var string
     * @ORM\Column(type="string", name="first_name")
     */
    private string $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", name="last_name")
     */
    private string $lastName;

    /**
     * @var Collection
     * @ORM\OneToMany(
     *     targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\Order",
     *      mappedBy="consumer",
     *      cascade={"persist"}
     *     )
     */
    private $orders;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * Consumer constructor.
     */
    public function __construct()
    {
        $this->consumerAddresses = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

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
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @param ConsumerAddress $address
     * @return $this
     */
    public function addAddress(ConsumerAddress $address): self
    {
        if (!$this->consumerAddresses->contains($address)) {
            $this->consumerAddresses[] = $address;
        }

        return $this;
    }

    /**
     * @param ConsumerAddress $address
     * @return $this
     */
    public function removeAddress(ConsumerAddress $address): self
    {
        if ($this->consumerAddresses->contains($address)) {
            $this->consumerAddresses->removeElement($address);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getConsumerAddresses(): Collection
    {
        return $this->consumerAddresses;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
        }

        return $this;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }
}
