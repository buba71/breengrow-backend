<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Deliverer
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 * @ORM\Entity()
 */
final class Deliverer
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="string", name="identifier")
     */
    private string $id;

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
     * @var string
     * @ORM\Column(type="string", name="phone_number")
     */
    private string $phone;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

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
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
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

}
