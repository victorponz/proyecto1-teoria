<?php
namespace ProyectoWeb\security;

use ProyectoWeb\security\IPasswordGenerator;

class Argon2PasswordGenerator implements IPasswordGenerator
{
    public static function encrypt(string $plainPassword): string {
        return password_hash($plainPassword, PASSWORD_ARGON2I);
    }
    
    public static function passwordVerify($password, $hash): bool {
        return (password_verify($password, $hash));
    }
}