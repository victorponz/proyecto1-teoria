<?php
require_once __DIR__ . "/IPasswordGenerator.php";

class BCryptPasswordGenerator implements IPasswordGenerator
{
    public static function encrypt(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    public static function passwordVerify($password, $hash): bool {
        return (password_verify($password, $hash));
    }
}