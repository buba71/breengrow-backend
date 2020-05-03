<?php

declare(strict_types=1);

namespace App\SharedKernel\Service;

class PasswordHash
{
    /**
     * @param string $plainPassword
     * @return string
     */
    public function hashPassword(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    /**
     * @param string $plainPassword
     * @param string $hashedPassword
     * @return bool
     */
    public function isPasswordValid(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
