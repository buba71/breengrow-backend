<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower\Register;

use App\Presentation\Api\Grower\Model\HiveModel;

/**
 * Class RegisterGrowerRequest
 * @package App\Application\UseCases\Grower
 */
class RegisterGrowerRequest
{
    /**
     * @var string
     */
    public string $firstName;

    /**
     * @var string
     */
    public string $lastName;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string|null
     */
    public ?string $salt = null;
    /**
     * @var array<string>
     */
    public array $role = [];

    /**
     * @var HiveModel
     */
    public HiveModel $hive;

    // /**
    //  * @param string $firstName
    //  */
    // public function setFirstName(string $firstName): void
    // {
    //     $this->firstName = $firstName;
    // }

    // /**
    //  * @param string $lastName
    //  */
    // public function setLastName(string $lastName): void
    // {
    //     $this->lastName = $lastName;
    // }

    // /**
    //  * @param string $email
    //  */
    // public function setEmail(string $email): void
    // {
    //     $this->email = $email;
    // }

    // /**
    //  * @param string $password
    //  */
    // public function setPassword(string $password): void
    // {
    //     $this->password = $password;
    // }

    // /**
    //  * @param string|null $salt
    //  */
    // public function setSalt(?string $salt): void
    // {
    //     $this->salt = $salt;
    // }

    // /**
    //  * @param array<string> $role
    //  */
    // public function setRole(array $role): void
    // {
    //     $this->role = $role;
    // }

    // /**
    //  * @return HiveModel
    //  */
    // public function getHive(): HiveModel
    // {
    //     return $this->hive;
    // }

    // /**
    //  * @param HiveModel $hive
    //  */
    // public function setHive(HiveModel $hive): void
    // {
    //     $this->hive = $hive;
    // }
}//
