<?php
namespace ProyectoWeb\security;

use ProyectoWeb\security\IPasswordGenerator;

class BCryptPasswordGenerator implements IPasswordGenerator
{
    public static function encrypt(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    public static function passwordVerify($password, $hash): bool {
        return (password_verify($password, $hash));
    }
}