<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Grower
 * @ORM\Entity()
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 */
final class Grower
{
    /**
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
     * @var User
     * @ORM\OneToOne(targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @var Company
     * @ORM\OneToOne(targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\Company", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Company $company;

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
    public function getId(): string
    {
        return $this->id;
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


}
