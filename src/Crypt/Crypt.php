<?php

namespace Scuba\Web\Crypt;

class Crypt
{
    public static function ssl_crypt(string $email): string
    {
        return password_hash($email, PASSWORD_BCRYPT);
    }

    public static function ssl_decrypt(string $email, string $hash): bool
    {
        if (!password_verify($email, $hash)) {
            throw new \DomainException('Hash não enconrado');
        }
        return true;
    }
}