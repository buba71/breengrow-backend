<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Grower\Grower;

interface GrowerRepository
{
    /**
     * @param Grower $user
     * @return mixed
     */
    public function addGrower(Grower $user);

    /**
     * @param string $id
     * @return Grower
     */
    public function getGrowerById(string $id): ?Grower;

    /**
     * @param string $email
     * @return mixed
     */
    public function getGrowerByEmail(string $email);
}