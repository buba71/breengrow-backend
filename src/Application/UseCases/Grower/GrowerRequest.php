<?php

declare(strict_types=1);

namespace App\Application\UseCases\Grower;

use App\Presentation\Api\Grower\Model\HiveModel;

/**
 * Class RegisterGrowerRequest
 * @package App\Application\UseCases\Grower
 */
class GrowerRequest
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
}

