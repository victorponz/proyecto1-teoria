<?php
require_once __DIR__ . "/IPasswordGenerator.php";

class Argon2PasswordGenerator implements IPasswordGenerator
{
    public static function encrypt(string $plainPassword): string {
        return password_hash($plainPassword, PASSWORD_ARGON2I);
    }
    
    public static function passwordVerify($password, $hash): bool {
        return (password_verify($password, $hash));
    }
}