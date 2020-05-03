<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Grower
 * @ORM\Entity()
 * @package App\Infrastructure\Symfony\Doctrine\Entity
 */
class Grower
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", name="identifier")
     */
    private string $id;

    /**
     * @var int
     * @ORM\Column(type="string", name="siret_number")
     */
    private int $siret_number;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Infrastructure\Symfony\Doctrine\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;


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
     * @return int
     */
    public function getSiretNumber(): int
    {
        return $this->siret_number;
    }

    /**
     * @param int $siret_number
     */
    public function setSiretNumber(int $siret_number): void
    {
        $this->siret_number = $siret_number;
    }




}